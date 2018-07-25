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

namespace Scand\RhenusWMS\Messages\Segments\Types;

use Scand\RhenusWMS\Messages\Segments\Attributes\Attribute;
use Scand\RhenusWMS\Messages\Segments\DataTypes\DataTypeInterface;
use Scand\RhenusWMS\Messages\Segments\Segment;
use Scand\RhenusWMS\Messages\Segments\SegmentInterface;

/**
 * Class AUF_TEXT
 * @package RhenusWMS\Messages\Segments\Types
 *
 * @property string $header_text_type
 * @property integer $line_number
 * @property string text
 */
class AUF_TEXT extends Segment
{
    /**
     * Segment name property
     */
    protected $name = SegmentInterface::TYPE_AUF_TEXT;

    /**
     * Initialization of attributes
     */
    protected function init()
    {
        $attr = new Attribute();
        $attr->setName('Type of order header text');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_MANDATORY);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(10);
        $attr->setAllowableValues(['KUNDE', 'PACK_TEXT']);
        $this->attributes['header_text_type'] = $attr;

        $attr = new Attribute();
        $attr->setName('Line number');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_MANDATORY);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_NUMERIC);
        $attr->setLength(6);
        $this->attributes['line_number'] = $attr;

        $attr = new Attribute();
        $attr->setName('Text');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_MANDATORY);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(200);
        $this->attributes['text'] = $attr;
    }
}
