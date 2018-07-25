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
 * Class AUF
 * @package RhenusWMS\Messages\Segments\Types
 *
 * @property string $record_type
 * @property string $branch
 * @property string $client
 * @property string $sub_client
 * @property string $order_number
 * @property string $ext_order_number
 * @property string $order_type
 * @property integer $priority
 * @property string $forwarder
 * @property string $partial_delivery
 * @property string $dispatch_date
 * @property string $dispatch_type
 * @property string $export_indicator
 * @property string $incoterm1
 * @property string $incoterm2
 * @property string $zus_info1
 * @property string $zus_info2
 * @property string $zus_info3
 * @property string $zus_info4
 * @property string $zus_info5
 */
class AUF extends Segment
{
    /**
     * Segment name property
     */
    protected $name = SegmentInterface::TYPE_AUF;

    /**
     * Initialization of attributes
     */
    protected function init()
    {
        $this->initCommonInAttributes(SegmentInterface::RECORD_TYPE_AUF);

        $attr = new Attribute();
        $attr->setName('Order number');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_MANDATORY);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(27);
        $this->attributes['order_number'] = $attr;

        $attr = new Attribute();
        $attr->setName('External order number');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_OPTIONAL);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(30);
        $this->attributes['ext_order_number'] = $attr;

        $attr = new Attribute();
        $attr->setName('Type of order');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_MANDATORY);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(6);
        $this->attributes['order_type'] = $attr;

        $attr = new Attribute();
        $attr->setName('Priority');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_MANDATORY);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_NUMERIC);
        $attr->setLength(2);
        $this->attributes['priority'] = $attr;

        $attr = new Attribute();
        $attr->setName('Forwarder');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_MANDATORY);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(20);
        $this->attributes['forwarder'] = $attr;

        $attr = new Attribute();
        $attr->setName('Partial delivery attribute');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_MANDATORY);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(1);
        $this->attributes['partial_delivery'] = $attr;

        $attr = new Attribute();
        $attr->setName('Dispatch date');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_MANDATORY);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_DATE);
        $attr->setLength(10);
        $this->attributes['dispatch_date'] = $attr;

        $attr = new Attribute();
        $attr->setName('Type of dispatch');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_MANDATORY);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(20);
        $this->attributes['dispatch_type'] = $attr;

        $attr = new Attribute();
        $attr->setName('Export indicator');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_OPTIONAL);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(1);
        $this->attributes['export_indicator'] = $attr;

        $attr = new Attribute();
        $attr->setName('INCOTERM1');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_OPTIONAL);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(3);
        $this->attributes['incoterm1'] = $attr;

        $attr = new Attribute();
        $attr->setName('INCOTERM2');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_OPTIONAL);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(30);
        $this->attributes['incoterm2'] = $attr;

        $this->initZusInfoAttributes();
    }
}
