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

namespace Scand\RhenusWMS;

use Scand\RhenusWMS\Exceptions\RhenusException;
use Scand\RhenusWMS\Messages\Files\FileType;
use Scand\RhenusWMS\Messages\Segments\Segment;
use Scand\RhenusWMS\Classes;

/**
 * Class Message
 * @package RhenusWMS
 */
abstract class Message implements MessageInterface, \Iterator
{
    use Classes\Error;

    /**
     * File type property
     */
    protected $type;
    /**
     * Instance of object
     */
    protected $fileTypeObject = null;
    /**
     * @var Segment[] Collection of segments
     */
    protected $segments = [];
    /**
     * Message structure
     */
    protected $structure = [];

    /**
     * Raw message data, used for loading message from file.
     */
    protected $rawData = null;
    /**
     * @var string Original csv file from Rhenus ftp
     */
    protected $originalCsv = null;

    /**
     * Create Message instance by file type
     * @param string $file_type Name of file type
     * @return Message Instance of new class
     * @throws RhenusException
     */
    public static function factory($file_type)
    {
        $class_name = __NAMESPACE__ . '\\Messages\\Types\\' . $file_type;
        if (!class_exists($class_name)) {
            throw new RhenusException("Class '" . $class_name . "' not found");
        }

        return new $class_name;
    }

    /**
     * Created Message instance (or instances array) based on file name
     *
     * File name example:
     * <code>
     *    <Type><Branch><Client><Subclient>nnnnnnnnn
     * </code>
     * @param string $file_path Name of file
     * @return Message|Message[] Instance of new class
     */
    public static function createFromFile($file_path)
    {
        // length of parts
        // <Branch> and <Client> and <Subclient> always by 2 digits, totally 6
        // nnnnnnnnn - 9
        $file_name = pathinfo($file_path, PATHINFO_FILENAME);

        if (preg_match('/^([a-zA-Z]+)/', $file_name, $matches)) {
            $file_type = strtoupper($matches[1]);
        } else {
            $file_type = strtoupper(substr($file_name, 0, -15));
        }

        $instance = self::factory($file_type);
        return $instance->loadFromFile($file_path);
    }

    /**
     * @param string $type FileTypeInterface::FILE_TYPE_...
     * @param string $csv CSV string
     * @param boolean $isNewFile
     * @return \Scand\RhenusWMS\Message
     * @throws \Scand\RhenusWMS\Exceptions\RhenusException
     */
    public static function createFromCSVString($type, $csv, $isNewFile = false)
    {
        $instance = self::factory($type);
        $instance->loadCSV($csv, $isNewFile);

        return $instance;
    }

    public function current()
    {
        return current($this->segments);
    }

    public function next()
    {
        return next($this->segments);
    }

    public function key()
    {
        return key($this->segments);
    }

    public function valid()
    {
        return key($this->segments) !== null;
    }

    public function rewind()
    {
        reset($this->segments);
    }

    /**
     * Method used to build message structure from raw data (loaded from file)
     */
    protected function buildFromRawData()
    {
        return false;
    }

    /**
     * Getter for FileType object
     * @return FileType
     * @throws RhenusException
     */
    public function getFileTypeObject()
    {
        if ($this->fileTypeObject == null) {
            $class_name = __NAMESPACE__ . '\\Messages\\Files\\Types\\' . $this->type;
            if (!class_exists($class_name)) {
                throw new RhenusException("Class '" . $class_name . "' not found");
            }
            $this->fileTypeObject = new $class_name;
        }
        return $this->fileTypeObject;
    }

    /**
     * Returns the file type
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Returns true if direction is out
     * @return boolean
     */
    public function isOut()
    {
        return $this->getFileTypeObject()->isOut();
    }

    /**
     * Adds new segment
     * @param Segment $segment Instance of segment
     */
    public function addSegment(Segment $segment)
    {
        $this->segments[] = $segment;
    }

    /**
     * Sets segments
     * @param array $segments Array of segments
     */
    public function setSegments(array $segments)
    {
        $this->segments = $segments;
    }

    /**
     * Returns segments
     * @return Segment[] array
     */
    public function getSegments()
    {
        return $this->segments;
    }

    /**
     * @param string $name
     * @return null|\RhenusWMS\Messages\Segments\Segment
     */
    public function getSegmentByName($name)
    {
        foreach ($this->segments as &$segment) {
            if ($segment->getName() == $name) {
                return $segment;
            }
        }

        return null;
    }

    /**
     * Returns first segment of message or null
     * @return Segment|null
     */
    public function getFirstSegment()
    {
        return isset($this->segments[0]) ? $this->segments[0] : null;
    }

    /**
     * Return original csv file from Rhenus ftp
     * @return string
     */
    public function getOriginalCsv()
    {
        return $this->originalCsv;
    }

    public function loadFromFile($file_path)
    {
        if (!file_exists($file_path)) {
            throw new RhenusException('Unable to open file "' . $file_path . '".');
        }

        $f = fopen($file_path, 'r');

        if (!$f) {
            throw new RhenusException('Error while opening file "' . $file_path . '".');
        }

        $this->rawData = [];
        while ($line = fgets($f)) {
            $this->rawData[] = rtrim($line, "\n");
        }

        return $this->buildInstance();
    }

    /**
     * @param array|string $csv
     * @param boolean $isNewFile
     * @return $this
     */
    public function loadCSV($csv, $isNewFile = false)
    {
        if ($isNewFile) {
            $this->originalCsv = $csv;
        }

        $this->rawData = [];

        foreach (preg_split("/((\r?\n)|(\r\n?))/", $csv) as $line) {
            if (!empty(trim($line))) {
                $this->rawData[] = $line;
            }
        }

        $this->buildFromRawData();

        return $this;
    }

    /**
     * Generates correct csv file name for outgoing message
     *
     * @param int $num message number
     * @return string
     * @throws \Scand\RhenusWMS\Exceptions\RhenusException
     */
    public function generateCSVFileName($num = 1)
    {
        if (!$this->isOut()) {
            throw new RhenusException('Only IN direction filename generation supported.');
        }

        $root = $this->getFirstSegment();

        $branch = $root->getAttributeValue('branch');
        $client = $root->getAttributeValue('client');
        $sub_client = $root->getAttributeValue('sub_client');

        if (!$branch || !$client || !$sub_client) {
            throw new RhenusException('Unable to generate CSV file name: wrong branch, client or sub_client values.');
        }

        $type = strtoupper($this->getType());

        $filename_base = $type . $branch . $client . $sub_client;

        return $filename_base . sprintf("%09d", $num) . '.csv';
    }

    /**
     * Converts segments to CSV format
     * @return boolean|string FALSE if failure or message in CSV format
     */
    public function toCSV()
    {
        $csv = [];
        /* @var $segment Segment */
        foreach ($this->segments as $segment) {
            if ($segment->validate()) {
                $csv[] = $segment->toCSV();
            } else {
                $this->addErrors($segment->getErrors());
            }
        }

        return $this->hasError() ? false : implode(MessageInterface::CSV_STRUCTURE_DELIMITER, $csv);
    }

    protected function buildInstance()
    {
        $this->buildFromRawData();

        return $this;
    }
}
