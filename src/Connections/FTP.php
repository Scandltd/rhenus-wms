<?php
/**
 * PHP library to communication with Rhenus Logistics Warehouse Management System (WMS)
 *
 * @author     Scand Ltd. <info@scand.com>
 * @license    GPLv2
 *
 * This file is part of Rhenus WMS library.
 *
 * Rhenus WMS – Copyright (C) 2018, Scand Ltd.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

namespace Scand\RhenusWMS\Connections;

use Scand\RhenusWMS\Classes;
use Scand\RhenusWMS\Exceptions\RhenusException;
use Scand\RhenusWMS\Messages\Files\FileTypeInterface;
use Scand\RhenusWMS\Classes\Curl;
use Scand\RhenusWMS\Message;

/**
 * Class FTP
 * @package RhenusWMS\Connections
 */
class FTP implements ConnectionInterface
{
    use Classes\Error;

    protected $ftpHost = null;
    protected $ftpLogin = null;
    protected $ftpPassword = null;
    protected $inDir = null;
    protected $outDir = null;

    public function __construct($ftpHost, $ftpLogin, $ftpPassword, $inDir, $outDir)
    {
        $this->ftpHost = $ftpHost;
        $this->ftpLogin = $ftpLogin;
        $this->ftpPassword = $ftpPassword;
        $this->inDir = $inDir;
        $this->outDir = $outDir;
    }

    /**
     * @param string $direction should be FileTypeInterface::FILE_DIRECTION_IN or FileTypeInterface::FILE_DIRECTION_OUT
     * @return string
     */
    public function getBaseURL($direction)
    {
        $folder = ($direction === FileTypeInterface::FILE_DIRECTION_OUT ? $this->inDir : $this->outDir);
        return rtrim($this->ftpHost, '/') . '/' . trim($folder, '/');
    }

    /**
     * @param $direction
     * @param bool $onlyNames
     * @return array
     * @throws \Scand\RhenusWMS\Exceptions\RhenusException
     */
    public function getFilesList($direction, $onlyNames = true)
    {
        $url = $this->getBaseURL($direction);
        $curl = $this->getNewCurlInstance($url);

        $list = $curl->listDir();

        $result = [];
        foreach ($list as $item) {
            $matches = $this->parseFileName($item);
            if (count($matches) !== 4) {
                continue;
            }

            if ($onlyNames) {
                $result[] = $matches[0];
            } else {
                $fileName = $matches[0];
                $type = $matches[1];
                $branch = substr($matches[2], 0, 2);
                $client = substr($matches[2], 2, 2);
                $subClient = substr($matches[2], 4, 2);
                $number = (int)str_replace('.csv', '', $matches[3]);

                $result[$type][] = [
                    'name' => $fileName,
                    'type' => $type,
                    'branch' => $branch,
                    'client' => $client,
                    'subClient' => $subClient,
                    'number' => $number,
                    'url' => $url . '/' . $fileName,
                ];
            }
        }

        return $result;
    }


    /**
     * Returns array of downloaded Messages
     *
     * @return Message[]
     */
    public function downloadMessages()
    {
        $url = $this->getBaseURL(FileTypeInterface::FILE_DIRECTION_IN);
        $list = $this->getFilesList($url, false);

        $result = [];
        foreach ($list as $type => $files) {
            foreach ($files as $file) {
                $curl = $this->getNewCurlInstance($file['url']);
                $csv = $curl->downloadFile();
                $result[] = Message::createFromCSVString($type, $csv, true);
            }
        }

        return $result;
    }

    /**
     * @param Message[] $messages array of messages to upload
     * @throws \Scand\RhenusWMS\Exceptions\RhenusException
     */
    public function uploadMessages($messages)
    {
        if (is_object($messages)) {
            $messages = [$messages];
        }

        $destinationURL = $this->getBaseURL(FileTypeInterface::FILE_DIRECTION_OUT);
        $lastFileNumbers = $this->getLastFileNumbers(FileTypeInterface::FILE_DIRECTION_OUT);

        foreach ($messages as $message) {
            if (false === ($message instanceof Message)) {
                throw new RhenusException('Unsupported object type, unable to upload.');
            }

            if (!$message->isOut()) {
                //todo: what we should do?
                throw new RhenusException('Only OUT messages allowed to be uploaded');
            }

            $csv = $message->toCSV();
            if (false === $csv) {
                //todo: what we should do?
                throw new RhenusException('Error while generating CSV: ' . $message->getErrorsAsString());
            }

            if (!isset($lastFileNumbers[$message->getType()]['current'])) {
                $lastFileNumbers[$message->getType()]['current'] = 0;
            }

            $num = ++$lastFileNumbers[$message->getType()]['current'];
            $fileURL = $destinationURL . '/' . $message->generateCSVFileName($num);

            $curl = $this->getNewCurlInstance();
            $curl->uploadFile($csv, $fileURL);
            $curl->uploadFile($csv, str_replace('.csv', '.rel', $fileURL));
        }
    }

    /**
     * @param string $file file local path
     * @param string $ftpFileName ftp file name
     * @throws \Scand\RhenusWMS\Exceptions\RhenusException
     */
    public function uploadPdfFile($file, $ftpFileName)
    {
        $fileData = file_get_contents($file);
        if ($fileData === false) {
            throw new RhenusException('Error reading from PDF file');
        }

        $destinationURL = $this->getBaseURL(FileTypeInterface::FILE_DIRECTION_OUT);
        $fileURL = $destinationURL . '/' . $ftpFileName;

        $curl = $this->getNewCurlInstance();
        $curl->uploadFile($fileData, $fileURL);
    }

    /**
     * @param string $fileURL
     * @param bool $rel
     * @param bool $onlyRel
     * @param bool $retry
     * @param string $destinationPath
     * @throws RhenusException
     *
     * @return int transmitted bytes
     */
    public function uploadMessageFile($fileURL, $rel = true, $onlyRel = false, $retry = false, &$destinationPath = null)
    {
        $destinationURL = $this->getBaseURL(FileTypeInterface::FILE_DIRECTION_OUT);
        $lastFileNumbers = $this->getLastFileNumbers(FileTypeInterface::FILE_DIRECTION_OUT);

        preg_match('/^(\D+)(\d+)/', basename($fileURL), $matches);

        if (3 !== count($matches)) {
            throw new RhenusException('Unable to parse file name.');
        }

        $matches = $this->parseFileName($fileURL);

        $type = $matches[1];
        $branch = substr($matches[2], 0, 2);
        $client = substr($matches[2], 2, 2);
        $subClient = substr($matches[2], 4, 2);

        if (!isset($lastFileNumbers[$type]['current'])) {
            $lastFileNumbers[$type]['current'] = 0;
        }

        if ($rel && $onlyRel || $retry) {
            $num = $lastFileNumbers[$type]['current'];
        } else {
            $num = ++$lastFileNumbers[$type]['current'];
        }

        $destinationPath = $destination = implode('', [
            $destinationURL,
            '/',
            strtoupper($type),
            $branch,
            $client,
            $subClient,
            sprintf('%09d', $num),
        ]);

        $data = file_get_contents($fileURL);
        $curl = $this->getNewCurlInstance();
        if ($rel && $onlyRel) {
            $curl->uploadFile($data, $destination . '.rel');

            return $this->getFileSize($destination . '.rel');
        } elseif (!$rel) {
            $curl->uploadFile($data, $destination . '.csv');

            return $this->getFileSize($destination . '.csv');
        } else {
            $curl->uploadFile($data, $destination . '.csv');
            $curl->uploadFile($data, $destination . '.rel');

            return $this->getFileSize($destination . '.csv');
        }
    }

    /**
     * @param $fileName
     * @return bool
     */
    public function checkAndDeleteMessageFile($fileName)
    {
        $destinationURL = $this->getBaseURL(FileTypeInterface::FILE_DIRECTION_OUT);

        $curl = $this->getNewCurlInstance();

        $relFileName = str_replace(".csv", ".rel", $fileName);

        if ($curl->ftpFileExists($destinationURL . "/" . $fileName)
            && !$curl->ftpFileExists($destinationURL . "/" . $relFileName)
        ) {
            $curl->deleteFile($destinationURL . "/" . $fileName);
            return true;
        }

        return false;
    }

    /**
     * @param string $fileURL
     * @return int size in bytes
     */
    public function getFileSize($fileURL)
    {
        $curl = $this->getNewCurlInstance($fileURL);
        $curl->head($fileURL);
        $curl->exec();

        return curl_getinfo($curl->curl, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
    }

    /**
     * @param null|string $url
     * @return \Scand\RhenusWMS\Classes\Curl
     */
    public function getNewCurlInstance($url = null)
    {
        $curl = new Curl($this->ftpLogin, $this->ftpPassword);

        if ($url) {
            $curl->setURL($url);
        }

        return $curl;
    }

    protected function getLastFileNumbers($direction)
    {
        $result = [];
        $list = $this->getFilesList($direction, false);

        foreach ($list as $type => $files) {
            $result[$type] = ['current' => 0];

            foreach ($files as $file) {
                if ($file['number'] > $result[$type]['current']) {
                    $result[$type]['current'] = $file['number'];
                }
            }
        }

        return $result;
    }

    protected function parseFileName($item)
    {
        preg_match('/(\w+)(\d{6})(\d{9}\.csv)/', $item, $matches);
        return $matches;
    }

    /**
     * @param $destination
     */
    public function deleteFile($destination)
    {
        $curl = $this->getNewCurlInstance($destination);
        $fileSize = $this->getFileSize($destination);
        if ($fileSize != -1) {
            $curl->deleteFile(str_replace($this->ftpHost, '', $destination));
        }
    }
}
