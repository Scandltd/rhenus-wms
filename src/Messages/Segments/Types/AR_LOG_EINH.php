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

use Scand\RhenusWMS\Messages\Segments\DataTypes\DataTypeInterface;
use Scand\RhenusWMS\Messages\Segments\Segment;
use Scand\RhenusWMS\Messages\Segments\SegmentInterface;
use Scand\RhenusWMS\Messages\Segments\Attributes\Attribute;

/**
 * Class AR_LOG_EINH
 * @package RhenusWMS\Messages\Segments\Types
 *
 * @property string $quantity_unit
 * @property integer $length
 * @property integer $width
 * @property integer $height
 * @property integer $weight
 * @property string $base_quantity_attribute
 * @property integer $number_quantity_unit
 */
class AR_LOG_EINH extends Segment
{
    /**
     * Segment name property
     */
    protected $name = SegmentInterface::TYPE_AR_LOG_EINH;

    /**
     * Initialization of attributes
     */
    protected function init()
    {
        $attr = new Attribute();
        $attr->setName('Quantity unit');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_MANDATORY);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(10);
        $attr->setAuthority(DataTypeInterface::AUTHORITY_READ_ONLY);
        $this->attributes['quantity_unit'] = $attr;

        $attr = new Attribute();
        $attr->setName('Length');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_MANDATORY);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_NUMERIC);
        $attr->setLength(5);
        $attr->setAuthority(DataTypeInterface::AUTHORITY_INITIAL_INSERT);
        $this->attributes['length'] = $attr;

        $attr = new Attribute();
        $attr->setName('Width');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_MANDATORY);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_NUMERIC);
        $attr->setLength(5);
        $attr->setAuthority(DataTypeInterface::AUTHORITY_INITIAL_INSERT);
        $this->attributes['width'] = $attr;

        $attr = new Attribute();
        $attr->setName('Height');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_MANDATORY);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_NUMERIC);
        $attr->setLength(5);
        $attr->setAuthority(DataTypeInterface::AUTHORITY_INITIAL_INSERT);
        $this->attributes['height'] = $attr;

        $attr = new Attribute();
        $attr->setName('Weight');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_MANDATORY);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_NUMERIC);
        $attr->setLength(5);
        $attr->setAuthority(DataTypeInterface::AUTHORITY_INITIAL_INSERT);
        $this->attributes['weight'] = $attr;

        $attr = new Attribute();
        $attr->setName('Base quantity attribute');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_MANDATORY);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(1);
        $attr->setAuthority(DataTypeInterface::AUTHORITY_INITIAL_INSERT);
        $attr->setAllowableValues(['J', 'N']);
        $this->attributes['base_quantity_attribute'] = $attr;

        $attr = new Attribute();
        $attr->setName('Number in basis quantity unit');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_MANDATORY);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_NUMERIC);
        $attr->setLength(9);
        $attr->setAuthority(DataTypeInterface::AUTHORITY_CUSTOMER_CAN_CNAGE);
        $this->attributes['number_quantity_unit'] = $attr;
    }
}
