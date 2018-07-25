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
use Scand\RhenusWMS\Messages\Segments\SegmentInterface;
use Scand\RhenusWMS\Messages\Files\FileTypeInterface;
use Scand\RhenusWMS\Messages\Validators\StructureInterface;
use Scand\RhenusWMS\MessageInterface;
use Scand\RhenusWMS\Messages\Segments\Segment;
use Scand\RhenusWMS\Exceptions\RhenusException;

/**
 * Article master data message
 */
class AR extends Message
{
    /**
     * Related file type
     */
    protected $type = FileTypeInterface::FILE_TYPE_ARTICLE;
    /**
     * Message structure
     */
    protected $structure = [
        'name' => SegmentInterface::TYPE_AR,
        'occurrence' => StructureInterface::OCCURRENCE_ONCE,
        'segments' => [
            [
                'name' => SegmentInterface::TYPE_AR_TEXT,
                'occurrence' => StructureInterface::OCCURRENCE_MANY_TIMES,
            ],
            [
                'name' => SegmentInterface::TYPE_AR_LOG_EINH,
                'occurrence' => StructureInterface::OCCURRENCE_OPTIONAL,
                'segments' => [
                    [
                        'name' => SegmentInterface::TYPE_AR_EAN,
                        'occurrence' => StructureInterface::OCCURRENCE_OPTIONAL,
                    ],
                ],
            ],
        ],
    ];


    protected function buildFromRawData()
    {
        if (empty($this->rawData) || !is_array($this->rawData) || empty($this->rawData[0])) {
            return false;
        }

        if (!empty($this->segments)) {
            $this->segments = [];
        }

        $data = explode(MessageInterface::CSV_STRUCTURE_DELIMITER, $this->rawData[0]);

        if (count($data) != SegmentInterface::AR_CSV_COL_COUNT) {
            throw new RhenusException('Wrong CSV columns count.');
        }

        $ar = Segment::factory(SegmentInterface::TYPE_AR);
        /** @var \Scand\RhenusWMS\Messages\Segments\Types\AR $ar */
        $ar->article_number = $data[4];
        $this->segments[] = $ar;

        return true;
    }

    protected function buildInstance()
    {
        $messages = [];

        foreach ($this->rawData as $line) {
            $tmp = new AR();
            $tmp->loadCSV($line);
            $messages[] = $tmp;
        }

        return $messages;
    }
}
