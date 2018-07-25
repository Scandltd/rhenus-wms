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
 * Class AR
 * @package RhenusWMS\Messages\Segments\Types
 *
 * @property string $record_type
 * @property string $branch
 * @property string $client
 * @property string $sub_client
 * @property string $article_number
 * @property string $type
 * @property string $group
 * @property string $mandatory_ean
 * @property string $mandatory_batch
 * @property string $mandatory_ed
 * @property string $mandatory_supplier
 * @property string $mandatory_s_n
 * @property string $brand_name
 * @property string $brand_number
 * @property string $hazardous_attribute
 * @property string $origin_country
 * @property string $tariff_number
 */
class AR extends Segment
{
    /**
     * Segment name property
     */
    protected $name = SegmentInterface::TYPE_AR;

    /**
     * Initialization of attributes
     */
    protected function init()
    {
        $this->initCommonInAttributes(SegmentInterface::RECORD_TYPE_AR);

        $attr = new Attribute();
        $attr->setName('Article number');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_MANDATORY);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(27);
        $attr->setAuthority(DataTypeInterface::AUTHORITY_READ_ONLY);
        $this->attributes['article_number'] = $attr;

        $attr = new Attribute();
        $attr->setName('Type');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_MANDATORY);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(10);
        $attr->setAuthority(DataTypeInterface::AUTHORITY_CUSTOMER_CAN_CNAGE);
        $attr->setAllowableValues(['NORM', 'VERP']);
        $this->attributes['type'] = $attr;

        $attr = new Attribute();
        $attr->setName('Group');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_OPTIONAL);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(12);
        $attr->setAuthority(DataTypeInterface::AUTHORITY_CUSTOMER_CAN_CNAGE);
        $this->attributes['group'] = $attr;

        $attr = new Attribute();
        $attr->setName('Mandatory EAN');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_MANDATORY);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(1);
        $attr->setAuthority(DataTypeInterface::AUTHORITY_CUSTOMER_CAN_CNAGE);
        $attr->setAllowableValues(['J', 'N']);
        $this->attributes['mandatory_ean'] = $attr;

        $attr = new Attribute();
        $attr->setName('Mandatory batch');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_MANDATORY);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(1);
        $attr->setAuthority(DataTypeInterface::AUTHORITY_READ_ONLY);
        $attr->setAllowableValues(['J', 'N']);
        $this->attributes['mandatory_batch'] = $attr;

        $attr = new Attribute();
        $attr->setName('Mandatory ED');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_MANDATORY);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(1);
        $attr->setAuthority(DataTypeInterface::AUTHORITY_READ_ONLY);
        $attr->setAllowableValues(['J', 'N']);
        $this->attributes['mandatory_ed'] = $attr;

        $attr = new Attribute();
        $attr->setName('Mandatory supplier');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_MANDATORY);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(1);
        $attr->setAuthority(DataTypeInterface::AUTHORITY_READ_ONLY);
        $attr->setAllowableValues(['J', 'N']);
        $this->attributes['mandatory_supplier'] = $attr;

        $attr = new Attribute();
        $attr->setName('Mandatory S/N');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_MANDATORY);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(1);
        $attr->setAuthority(DataTypeInterface::AUTHORITY_CUSTOMER_CAN_CNAGE);
        $attr->setAllowableValues(['J', 'N']);
        $this->attributes['mandatory_s_n'] = $attr;

        $attr = new Attribute();
        $attr->setName('Brand name');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_OPTIONAL);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(40);
        $attr->setAuthority(DataTypeInterface::AUTHORITY_CUSTOMER_CAN_CNAGE);
        $this->attributes['brand_name'] = $attr;

        $attr = new Attribute();
        $attr->setName('Brand number');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_OPTIONAL);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(20);
        $attr->setAuthority(DataTypeInterface::AUTHORITY_CUSTOMER_CAN_CNAGE);
        $this->attributes['brand_number'] = $attr;

        $attr = new Attribute();
        $attr->setName('Hazardous substance attribute');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_MANDATORY);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(1);
        $attr->setAuthority(DataTypeInterface::AUTHORITY_INITIAL_INSERT);
        $attr->setAllowableValues(['J', 'N']);
        $this->attributes['hazardous_attribute'] = $attr;

        $attr = new Attribute();
        $attr->setName('Country of origin attribute');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_OPTIONAL);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(3);
        $attr->setAuthority(DataTypeInterface::AUTHORITY_CUSTOMER_CAN_CNAGE);
        $this->attributes['origin_country'] = $attr;

        $attr = new Attribute();
        $attr->setName('Customs tariff number');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_OPTIONAL);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(25);
        $attr->setAuthority(DataTypeInterface::AUTHORITY_CUSTOMER_CAN_CNAGE);
        $this->attributes['tariff_number'] = $attr;
    }
}
