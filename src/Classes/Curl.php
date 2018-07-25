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

namespace Scand\RhenusWMS\Classes;

use Scand\RhenusWMS\Exceptions\RhenusException;

/**
 * Class Curl
 *
 * @package RhenusWMS\Classes
 */
class Curl extends \Curl\Curl
{
    /**
     * Curl constructor.
     *
     * @param string $login
     * @param string $password
     * @param string $url default null
     */
    public function __construct($login, $password, $url = '')
    {
        parent::__construct($url);

        $this->setCredentials($login, $password);
    }

    /**
     * FTP Credentials
     * @param $login
     * @param $password
     */
    public function setCredentials($login, $password)
    {
        $this->setOpt(CURLOPT_USERPWD, $login . ':' . $password);
    }

    /**
     * @param string $data file data to be uploaded
     * @param string $destination upload to URL
     * @return string
     */
    public function uploadFile($data, $destination)
    {
        $this->setURL($destination);

        $size = $this->getFileSizeFromData($data);
        $source = $this->getFileStream($data);

        $this->setOpt(CURLOPT_UPLOAD, 1);
        $this->setOpt(CURLOPT_INFILE, $source);
        $this->setOpt(CURLOPT_INFILESIZE, $size);

        return $this->exec();
    }

    /**
     * @return string|bool
     */
    public function downloadFile()
    {
        return $this->exec();
    }

    /**
     * @param string $filePath
     * @return mixed
     * @throws \Scand\RhenusWMS\Exceptions\RhenusException
     */
    public function deleteFile($filePath)
    {
        $this->setOpt(CURLOPT_QUOTE, ["DELE /" . trim($filePath, "/")]);
        return $this->exec();
    }

    /**
     * @param string $filePath
     * @return bool
     * @throws \Scand\RhenusWMS\Exceptions\RhenusException
     */
    public function ftpFileExists($filePath)
    {
        $this->setURL($filePath);
        $this->setOpt(CURLOPT_HEADER, true);
        $this->setOpt(CURLOPT_NOBODY, true);

        $this->exec();
        $size = $this->getInfo(CURLINFO_CONTENT_LENGTH_DOWNLOAD);

        return $size > 0 ? true : false;
    }

    /**
     * @param $opt
     * @return mixed
     */
    public function getInfo($opt)
    {
        return curl_getinfo($this->curl, $opt);
    }

    /**
     * Returns directory listing
     * @param string|null $url
     * @return mixed
     * @throws \Scand\RhenusWMS\Exceptions\RhenusException
     */
    public function listDir($url = null)
    {
        if ($url == null) {
            $url = trim($this->baseUrl, '/') . '/';
        }

        $this->setOpt(CURLOPT_CUSTOMREQUEST, 'MLSD');
        $this->setOpt(CURLOPT_FTPLISTONLY, 1);
        $this->setURL($url);

        $resp = $this->exec();

        if ($this->error) {
            throw new RhenusException('Unable to retrieve directory listing: ' . $this->errorMessage);
        }

        $result = trim($resp);
        $result = explode("\n", $result);

        array_walk(
            $result,
            function ($item) {
                return trim($item);
            }
        );

        return array_filter(
            $result,
            function ($item) {
                return !empty($item) && !in_array($item, ['.', '..', '.ssh']);
            }
        );
    }

    protected function getFileStream($data)
    {
        $fileStream = fopen('php://temp', 'r+');
        fwrite($fileStream, $data);
        rewind($fileStream);

        return $fileStream;
    }

    protected function getFileSizeFromData($data)
    {
        if (function_exists('mb_strlen')) {
            return mb_strlen($data, '8bit');
        }

        return strlen($data);
    }
}
