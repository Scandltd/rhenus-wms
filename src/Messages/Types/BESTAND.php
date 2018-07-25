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

namespace Scand\RhenusWMS\Messages\Types;

use Scand\RhenusWMS\Message;
use Scand\RhenusWMS\MessageInterface;
use Scand\RhenusWMS\Messages\Files\FileTypeInterface;
use Scand\RhenusWMS\Messages\Segments\Segment;
use Scand\RhenusWMS\Messages\Segments\SegmentInterface;
use Scand\RhenusWMS\Messages\Validators\StructureInterface;
use Scand\RhenusWMS\Messages\Types\BESTAND as BestandMessage;

/**
 * Stock comparison message
 */
class BESTAND extends Message
{
    /**
     * Related file type
     */
    protected $type = FileTypeInterface::FILE_TYPE_STOCK_COMPARISON;
    /**
     * Message structure
     */
    protected $structure = [
        'name' => 'BESTAND',
        'occurrence' => StructureInterface::OCCURRENCE_ONCE,
    ];

    public function buildFromRawData()
    {
        if (empty($this->rawData) || !is_array($this->rawData) || empty($this->rawData[0])) {
            return false;
        }

        if (!empty($this->segments)) {
            $this->segments = [];
        }

        $data = explode(MessageInterface::CSV_STRUCTURE_DELIMITER, $this->rawData[0]);
        /** @var \Scand\RhenusWMS\Messages\Segments\Types\BESTAND $segment */
        $segment = Segment::factory(SegmentInterface::TYPE_BESTAND);

        $count = count($data) - 1; // handling last pipe in CSV - Rhenus adds pipe - '|' - at the end of CSV line
        if ($count !== SegmentInterface::BESTAND_CSV_COL_COUNT) {
            $this->addError(0, 'Wrong columns count');
        }

        $segment->record_type = $data[0];
        $segment->date = $data[1];
        $segment->time = $data[2];
        $segment->article_number = $data[3];
        $segment->batch = $data[4];
        $segment->ed = $data[5];
        $segment->supplier = $data[6];
        $segment->quantity = $data[7];
        $segment->package_number = $data[8];
        $segment->stock_type = $data[9];
        $segment->stock_reference = $data[10];
        $segment->reference_position = $data[11];

        if (!$segment->validate()) {
            $this->addErrors($segment->getErrors());
            return false;
        }

        $this->segments[] = $segment;

        return true;
    }

    protected function buildInstance()
    {
        $messages = [];

        foreach ($this->rawData as $line) {
            $tmp = new BestandMessage();
            $tmp->loadCSV($line);
            $messages[] = $tmp;
        }

        return $messages;
    }
}
