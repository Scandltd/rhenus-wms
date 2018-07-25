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
 * Class AVIS
 * @package RhenusWMS\Messages\Segments\Types
 *
 * @property string $record_type
 * @property string $branch
 * @property string $client
 * @property string $sub_client
 * @property string $advice_number
 * @property string $advice_type
 * @property string $supplier
 * @property string $delivery_date
 * @property string $delivery_time
 * @property string $transport_number
 * @property string $zus_info1
 * @property string $zus_info2
 * @property string $zus_info3
 * @property string $zus_info4
 * @property string $zus_info5
 */
class AVIS extends Segment
{
    /**
     * Segment name property
     */
    protected $name = SegmentInterface::TYPE_AVIS;

    /**
     * Initialization of attributes
     */
    protected function init()
    {
        $this->initCommonInAttributes(SegmentInterface::RECORD_TYPE_AVIS);

        $attr = new Attribute();
        $attr->setName('Advice number');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_MANDATORY);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(47);
        $this->attributes['advice_number'] = $attr;

        $attr = new Attribute();
        $attr->setName('Type of advice');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_MANDATORY);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(7);
        $this->attributes['advice_type'] = $attr;

        $attr = new Attribute();
        $attr->setName('Supplier');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_MANDATORY);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(20);
        $this->attributes['supplier'] = $attr;

        $attr = new Attribute();
        $attr->setName('Target delivery date');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_OPTIONAL);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_DATE);
        $attr->setLength(10);
        $this->attributes['delivery_date'] = $attr;

        $attr = new Attribute();
        $attr->setName('Target delivery time');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_OPTIONAL);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_TIME);
        $attr->setLength(8);
        $this->attributes['delivery_time'] = $attr;

        $attr = new Attribute();
        $attr->setName('Transport number');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_OPTIONAL);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(20);
        $this->attributes['transport_number'] = $attr;

        $this->initZusInfoAttributes(5, 40);
    }
}
