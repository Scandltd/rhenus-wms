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
use Scand\RhenusWMS\Messages\Files\FileTypeInterface;
use Scand\RhenusWMS\Messages\Segments\SegmentInterface;
use Scand\RhenusWMS\Messages\Validators\StructureInterface;
use Scand\RhenusWMS\MessageInterface;
use Scand\RhenusWMS\Messages\Segments\Segment;

/**
 * Confirmation on general movements as well as goods receipt entries for purchase orders
 */
class BEW extends Message
{
    /**
     * Related file type
     */
    protected $type = FileTypeInterface::FILE_TYPE_GENERAL_CONFIRMATION;
    /**
     * Message structure
     */
    protected $structure = [
        'name' => SegmentInterface::TYPE_BEW,
        'occurrence' => StructureInterface::OCCURRENCE_MANY_TIMES,
    ];

    protected function buildBEWSegment($data)
    {
        /** @var \Scand\RhenusWMS\Messages\Segments\Types\BEW $segment */
        $segment = Segment::factory(SegmentInterface::TYPE_BEW);
        $segment->setAttributeValue('record_type', $data[0]);
        $segment->setAttributeValue('from_article_number', $data[1]);
        $segment->setAttributeValue('to_article_number', $data[2]);
        $segment->setAttributeValue('from_batch', $data[3]);
        $segment->setAttributeValue('to_batch', $data[4]);
        $segment->setAttributeValue('from_ed', $data[5]);
        $segment->setAttributeValue('to_ed', $data[6]);
        $segment->setAttributeValue('from_supplier', $data[7]);
        $segment->setAttributeValue('to_supplier', $data[8]);
        $segment->setAttributeValue('from_package_number', $data[9]);
        $segment->setAttributeValue('to_package_number', $data[10]);
        $segment->setAttributeValue('quantity', $data[11]);
        $segment->setAttributeValue('document_text', $data[12]);
        $segment->setAttributeValue('movement_type', $data[13]);
        $segment->setAttributeValue('from_stock_type', $data[14]);
        $segment->setAttributeValue('to_stock_type', $data[15]);
        $segment->setAttributeValue('from_stock_reference', $data[16]);
        $segment->setAttributeValue('to_stock_reference', $data[17]);
        $segment->setAttributeValue('from_stock_reference_position', $data[18]);
        $segment->setAttributeValue('to_stock_reference_position', $data[19]);
        $segment->setAttributeValue('purchase_order_number', $data[20]);
        $segment->setAttributeValue('purchase_order_line', $data[21]);

        for ($i = 1; $i <= 5; $i++) {
            $segment->setAttributeValue('zus_info' . $i, $data[21 + $i]);
        }

        return $segment;
    }

    protected function buildFromRawData()
    {
        if (empty($this->rawData)) {
            return false;
        }

        if (!empty($this->segments)) {
            $this->segments = [];
        }

        foreach ($this->rawData as $line) {
            $line = str_replace(["\r", "\n", "\r\n"], '', $line);
            $data = explode(MessageInterface::CSV_STRUCTURE_DELIMITER, $line);
            if (count($data) - 1 == SegmentInterface::BEW_CSV_COL_COUNT
                && $data[SegmentInterface::BEW_CSV_COL_COUNT] === ""
            ) {
                array_pop($data);
            }
            if (count($data) != SegmentInterface::BEW_CSV_COL_COUNT) {
                $this->addError(null, 'Wrong CSV format, unable to build message');

                return false;
            }
            if (empty($this->segments)) {
                $bew = $this->buildBEWSegment($data);

                if (!$bew->validate()) {
                    $this->addErrors($bew->getErrors());

                    return false;
                }

                $this->addSegment($bew);
            }
        }

        return true;
    }
}
