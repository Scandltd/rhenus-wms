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
 * Class RAUF
 * @package RhenusWMS\Messages\Segments\Types
 *
 * @property string $record_type
 * @property string $order_number
 * @property string $external_order_number
 * @property string $forwarder
 * @property string $date_stamp
 * @property string $time_stamp
 * @property string $status
 * @property integer $net_weight
 * @property integer $gross_weight
 * @property integer $volumes
 * @property string $zus_info1
 * @property string $zus_info2
 * @property string $zus_info3
 * @property string $zus_info4
 * @property string $zus_info5
 */
class RAUF extends Segment
{
    /**
     * Segment name property
     */
    protected $name = SegmentInterface::TYPE_RAUF;

    /**
     * Initialization of attributes
     */
    protected function init()
    {
        $attr = new Attribute();
        $attr->setName('Record type');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_MANDATORY);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(4);
        $attr->setValue(SegmentInterface::RECORD_TYPE_RAUF_POS);
        $this->attributes['record_type'] = $attr;

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
        $this->attributes['external_order_number'] = $attr;

        $attr = new Attribute();
        $attr->setName('Forwarder');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_MANDATORY);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(20);
        $this->attributes['forwarder'] = $attr;

        $attr = new Attribute();
        $attr->setName('Date stamp');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_MANDATORY);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_DATE);
        $attr->setLength(10);
        $this->attributes['date_stamp'] = $attr;

        $attr = new Attribute();
        $attr->setName('Time stamp');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_MANDATORY);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_TIME);
        $attr->setLength(8);
        $this->attributes['time_stamp'] = $attr;

        $attr = new Attribute();
        $attr->setName('Status');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_MANDATORY);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(10);
        $attr->setAllowableValues(['akt', 'im_vers', 'vers_ber', 'verl']);
        $this->attributes['status'] = $attr;

        $attr = new Attribute();
        $attr->setName('Net weight');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_MANDATORY);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_NUMERIC);
        $attr->setLength(11);
        $this->attributes['net_weight'] = $attr;

        $attr = new Attribute();
        $attr->setName('Gross weight');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_MANDATORY);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_NUMERIC);
        $attr->setLength(11);
        $this->attributes['gross_weight'] = $attr;

        $attr = new Attribute();
        $attr->setName('Volumes');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_MANDATORY);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_NUMERIC);
        $attr->setLength(11);
        $this->attributes['volumes'] = $attr;

        $this->initZusInfoAttributes(5, 200);
    }
}
