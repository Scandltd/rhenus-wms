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

use Scand\RhenusWMS\Exceptions\RhenusException;
use Scand\RhenusWMS\Message;
use Scand\RhenusWMS\MessageInterface;
use Scand\RhenusWMS\Messages\Files\FileTypeInterface;
use Scand\RhenusWMS\Messages\Segments\Segment;
use Scand\RhenusWMS\Messages\Segments\SegmentInterface;
use Scand\RhenusWMS\Messages\Segments\Types\RAUF_LE;
use Scand\RhenusWMS\Messages\Segments\Types\RAUF_POS;
use Scand\RhenusWMS\Messages\Segments\Types\RAUF_POS_LE;
use Scand\RhenusWMS\Messages\Segments\Types\RAUF_POS_SN;
use Scand\RhenusWMS\Messages\Validators\StructureInterface;

/**
 * Orders confirmation message
 */
class RAUF extends Message
{
    /**
     * Related file type
     */
    protected $type = FileTypeInterface::FILE_TYPE_ORDERS_CONFIRMATION;

    /**
     * Message structure
     */
    protected $structure = [
        'name' => SegmentInterface::TYPE_RAUF,
        'occurrence' => StructureInterface::OCCURRENCE_ONCE,
        'segments' => [
            [
                'name' => SegmentInterface::TYPE_RAUF_POS,
                'occurrence' => StructureInterface::OCCURRENCE_MANY_TIMES,
            ],
            [
                'name' => SegmentInterface::TYPE_RAUF_LE,
                'occurrence' => StructureInterface::OCCURRENCE_OPTIONAL,
                'segments' => [
                    [
                        'name' => SegmentInterface::TYPE_RAUF_POS_LE,
                        'occurrence' => StructureInterface::OCCURRENCE_OPTIONAL,
                        'segments' => [
                            [
                                'name' => SegmentInterface::TYPE_RAUF_POS_SN,
                                'occurrence' => StructureInterface::OCCURRENCE_OPTIONAL,
                            ]
                        ],
                    ]
                ],
            ]
        ],
    ];

    /**
     * @return bool
     * @throws \Scand\RhenusWMS\Exceptions\RhenusException
     */
    protected function buildFromRawData()
    {
        if (empty($this->rawData) || !is_array($this->rawData) || empty($this->rawData[0])) {
            return false;
        }

        if (!empty($this->segments)) {
            $this->segments = [];
        }

        $data = explode(MessageInterface::CSV_STRUCTURE_DELIMITER, $this->rawData[0]);

        if (count($data) != SegmentInterface::RAUF_CSV_COL_COUNT) {
            throw new RhenusException('Wrong CSV columns count.');
        }

        $this->segments[] = $this->buildRaufSegment($data);
        $this->segments[] = $this->buildRaufPosSegment($data);
        $this->segments[] = $this->buildRaufPosSnSegment($data);
        $this->segments[] = $this->buildRaufLeSegment($data);
        $this->segments[] = $this->buildRaufPosLeSegment($data);

        foreach ($this->segments as $segment) {
            if (!$segment->validate()) {
                $this->addErrors($segment->getErrors());
            }
        }

        return !$this->hasError();
    }

    protected function buildInstance()
    {
        $messages = [];

        foreach ($this->rawData as $line) {
            $tmp = new RAUF();
            $tmp->loadCSV($line);
            $messages[] = $tmp;
        }

        return $messages;
    }

    /**
     * @param array $data
     * @return \Scand\RhenusWMS\Messages\Segments\Types\RAUF
     * @throws \Scand\RhenusWMS\Exceptions\RhenusException
     */
    protected function buildRaufSegment($data)
    {
        /** @var \Scand\RhenusWMS\Messages\Segments\Types\RAUF $segment */
        $segment = Segment::factory(SegmentInterface::TYPE_RAUF);

        $segment->record_type = $data[0];
        $segment->order_number = $data[1];
        $segment->external_order_number = $data[2];
        $segment->forwarder = $data[3];
        $segment->date_stamp = $data[4];
        $segment->time_stamp = $data[5];
        $segment->status = $data[6];
        $segment->net_weight = $data[7];
        $segment->gross_weight = $data[8];
        $segment->volumes = $data[9];
        $segment->zus_info1 = $data[10];
        $segment->zus_info2 = $data[11];
        $segment->zus_info3 = $data[12];
        $segment->zus_info4 = $data[13];
        $segment->zus_info5 = $data[14];

        return $segment;
    }

    /**
     * @param array $data
     * @return \Scand\RhenusWMS\Messages\Segments\Types\RAUF_POS
     * @throws \Scand\RhenusWMS\Exceptions\RhenusException
     */
    protected function buildRaufPosSegment($data)
    {
        /** @var RAUF_POS $segment */
        $segment = Segment::factory(SegmentInterface::TYPE_RAUF_POS);

        $segment->order_line = $data[15];
        $segment->article_number = $data[16];
        $segment->batch = $data[17];
        $segment->ed = $data[18];
        $segment->supplier = $data[19];
        $segment->quantity = $data[20];
        $segment->stock_type = $data[21];
        $segment->stock_reference = $data[22];
        $segment->stock_reference_position = $data[23];
        $segment->package_number = $data[24];
        $segment->zus_info1 = $data[25];
        $segment->zus_info2 = $data[26];
        $segment->zus_info3 = $data[27];
        $segment->zus_info4 = $data[28];
        $segment->zus_info5 = $data[29];

        return $segment;
    }

    /**
     * @param array $data
     * @return \Scand\RhenusWMS\Messages\Segments\Types\RAUF_LE
     * @throws \Scand\RhenusWMS\Exceptions\RhenusException
     */
    protected function buildRaufLeSegment($data)
    {
        /** @var RAUF_LE $segment */
        $segment = Segment::factory(SegmentInterface::TYPE_RAUF_LE);

        $segment->le_number = $data[31];
        $segment->type = $data[32];
        $segment->sscc = $data[33];
        $segment->gross_weight = $data[34];
        $segment->net_weight = $data[35];

        return $segment;
    }

    /**
     * @param array $data
     * @return \Scand\RhenusWMS\Messages\Segments\Types\RAUF_POS_SN
     * @throws \Scand\RhenusWMS\Exceptions\RhenusException
     */
    protected function buildRaufPosSnSegment($data)
    {
        /** @var RAUF_POS_SN $segment */
        $segment = Segment::factory(SegmentInterface::TYPE_RAUF_POS_SN);

        $segment->sn_number = $data[30];

        return $segment;
    }

    /**
     * @param array $data
     * @return \Scand\RhenusWMS\Messages\Segments\Types\RAUF_POS_LE
     * @throws \Scand\RhenusWMS\Exceptions\RhenusException
     */
    protected function buildRaufPosLeSegment($data)
    {
        /** @var RAUF_POS_LE $segment */
        $segment = Segment::factory(SegmentInterface::TYPE_RAUF_POS_LE);

        $segment->quantity = $data[36];

        return $segment;
    }
}
