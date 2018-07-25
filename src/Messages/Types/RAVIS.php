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

/**
 * Advice confirmation message
 */
class RAVIS extends Message
{
    protected $type = FileTypeInterface::FILE_TYPE_ADVICE_CONFIRMATION;
    /**
     * Message structure
     */
    protected $structure = [
        'name' => SegmentInterface::TYPE_RAVIS,
        'occurrence' => StructureInterface::OCCURRENCE_ONCE,
        'segments' => [
            [
                'name' => SegmentInterface::TYPE_RAVIS_POS,
                'occurrence' => StructureInterface::OCCURRENCE_MANY_TIMES,
            ],
        ],
    ];

    /**
     * Builds RAVIS segment from CSV data
     *
     * @param $data
     * @return \Scand\RhenusWMS\Messages\Segments\Types\RAVIS
     * @throws \Scand\RhenusWMS\Exceptions\RhenusException
     */
    protected function buildRAVISSegment($data)
    {
        /** @var \Scand\RhenusWMS\Messages\Segments\Types\RAVIS $segment */
        $segment = Segment::factory(SegmentInterface::TYPE_RAVIS);
        $segment->setAttributeValue('record_type', $data[0]);
        $segment->setAttributeValue('advice_number', $data[1]);
        $segment->setAttributeValue('booking_date', $data[2]);
        $segment->setAttributeValue('booking_time', $data[3]);
        for ($i = 1; $i <= 5; $i++) {
            $segment->setAttributeValue('zus_info' . $i, $data[3 + $i]);
        }

        return $segment;
    }

    /**
     * Builds RAVIS_POS segment from CSV data.
     * WARNING! You need to validate data (count) before passing to this method.
     *
     * @param $data
     * @param $advice_number
     * @return \Scand\RhenusWMS\Messages\Segments\Types\RAVIS
     * @throws \Scand\RhenusWMS\Exceptions\RhenusException
     */
    protected function buildRavisPosSegment($data, $advice_number)
    {
        /** @var \Scand\RhenusWMS\Messages\Segments\Types\RAVIS $segment */
        $segment = Segment::factory(SegmentInterface::TYPE_RAVIS_POS);
        $segment->setAttributeValue('advice_number', $advice_number);
        $segment->setAttributeValue('linenumber', $data[0]);
        $segment->setAttributeValue('article_number', $data[1]);
        $segment->setAttributeValue('batch', $data[2]);
        $segment->setAttributeValue('ed', $data[3]);
        $segment->setAttributeValue('supplier', $data[4]);
        $segment->setAttributeValue('quantity', $data[5]);
        $segment->setAttributeValue('stock_type', $data[6]);
        $segment->setAttributeValue('package_number', $data[7]);
        $segment->setAttributeValue('package_type', $data[8]);
        $segment->setAttributeValue('stock_reference', $data[9]);
        $segment->setAttributeValue('stock_position', $data[10]);
        $segment->setAttributeValue('reference_number', $data[11]);
        $segment->setAttributeValue('reference_position', $data[12]);

        for ($i = 1; $i <= 5; $i++) {
            $segment->setAttributeValue('zus_info' . $i, $data[12 + $i]);
        }

        return $segment;
    }

    /**
     * @inheritdoc
     * @return bool
     */
    protected function buildFromRawData()
    {
        if (empty($this->rawData)) {
            return false;
        }

        if (!empty($this->segments)) {
            $this->segments = [];
        }

        foreach ($this->rawData as $line) {
            $data = explode(MessageInterface::CSV_STRUCTURE_DELIMITER, $line);
            if (empty($this->segments)) {
                $ravis = $this->buildRAVISSegment($data);

                if (!$ravis->validate()) {
                    $this->addErrors($ravis->getErrors());
                    return false;
                }

                $this->addSegment($ravis);
            }

            $advice_number = $this->getFirstSegment()->getAttributeValue('advice_number');
            $position = SegmentInterface::RAVIS_CSV_COL_COUNT;
            $segment_data = array_slice($data, $position, SegmentInterface::RAVIS_POS_CSV_COL_COUNT);
            if (empty($segment_data)) {
                break;
            }

            if (count($segment_data) != SegmentInterface::RAVIS_POS_CSV_COL_COUNT) {
                $this->addError(null, 'Wrong CSV format, unable to build message');
                return false;
            }

            $segment = $this->buildRavisPosSegment($segment_data, $advice_number);

            if (!$segment->validate()) {
                $this->addErrors($segment->getErrors());
                return false;
            }

            $this->addSegment($segment);
        }

        return true;
    }

    public function toCSV()
    {
        $csv = '';

        $root = null;
        foreach ($this->segments as $segment) {
            $line = [];
            /* @var $segment Segment */
            /* @var $root Segment */
            if (!$root) {
                $root = $segment;
                continue;
            } else {
                $line += $root->toArray();
            }

            if ($segment->validate()) {
                $segmentArray = $segment->toArray();
                $line = array_merge($line, array_slice($segmentArray, 2));

                $csv .= !empty($csv) ? "\r\n" : '';
                $csv .= implode(MessageInterface::CSV_STRUCTURE_DELIMITER, $line);
                $csv .= MessageInterface::CSV_STRUCTURE_DELIMITER;
            } else {
                $this->addErrors($segment->getErrors());
            }
        }

        if ($this->hasError()) {
            return false;
        }

        return $csv;
    }
}
