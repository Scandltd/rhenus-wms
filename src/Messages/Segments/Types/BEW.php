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
 * Class BEW
 * @package RhenusWMS\Messages\Segments\Types
 *
 * @property string $record_type
 * @property string $from_article_number
 * @property string $to_article_number
 * @property string $from_batch
 * @property string $to_batch
 * @property string $from_ed
 * @property string $to_ed
 * @property string $from_supplier
 * @property string $to_supplier
 * @property string $from_package_number
 * @property string $to_package_number
 * @property integer $quantity
 * @property string $document_text
 * @property string $movement_type
 * @property string $from_stock_type
 * @property string $to_stock_type
 * @property string $from_stock_reference
 * @property string $to_stock_reference
 * @property string $from_stock_reference_position
 * @property string $to_stock_reference_position
 * @property string $purchase_order_number
 * @property string $purchase_order_line
 * @property string $zus_info1
 * @property string $zus_info2
 * @property string $zus_info3
 * @property string $zus_info4
 * @property string $zus_info5
 */
class BEW extends Segment
{
    /**
     * Segment name property
     */
    protected $name = SegmentInterface::TYPE_BEW;

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
        $attr->setValue(SegmentInterface::RECORD_TYPE_BEW);
        $this->attributes['record_type'] = $attr;

        $attr = new Attribute();
        $attr->setName('From article number');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_OPTIONAL);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(27);
        $this->attributes['from_article_number'] = $attr;

        $attr = new Attribute();
        $attr->setName('To article number');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_OPTIONAL);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(27);
        $this->attributes['to_article_number'] = $attr;

        $attr = new Attribute();
        $attr->setName('From batch');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_OPTIONAL);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(10);
        $this->attributes['from_batch'] = $attr;

        $attr = new Attribute();
        $attr->setName('To batch');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_OPTIONAL);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(10);
        $this->attributes['to_batch'] = $attr;

        $attr = new Attribute();
        $attr->setName('From ED');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_OPTIONAL);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_DATE);
        $attr->setLength(10);
        $this->attributes['from_ed'] = $attr;

        $attr = new Attribute();
        $attr->setName('To ED');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_OPTIONAL);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_DATE);
        $attr->setLength(10);
        $this->attributes['to_ed'] = $attr;

        $attr = new Attribute();
        $attr->setName('From supplier');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_OPTIONAL);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(20);
        $this->attributes['from_supplier'] = $attr;

        $attr = new Attribute();
        $attr->setName('To supplier');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_OPTIONAL);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(20);
        $this->attributes['to_supplier'] = $attr;

        $attr = new Attribute();
        $attr->setName('From package number');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_OPTIONAL);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(18);
        $this->attributes['from_package_number'] = $attr;

        $attr = new Attribute();
        $attr->setName('To package number');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_OPTIONAL);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(18);
        $this->attributes['to_package_number'] = $attr;

        $attr = new Attribute();
        $attr->setName('Quantity');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_MANDATORY);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_NUMERIC);
        $attr->setLength(9);
        $this->attributes['quantity'] = $attr;

        $attr = new Attribute();
        $attr->setName('Document text');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_OPTIONAL);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(100);
        $this->attributes['document_text'] = $attr;

        $attr = new Attribute();
        $attr->setName('Type of movement');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_MANDATORY);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(2);
        $this->attributes['movement_type'] = $attr;

        $attr = new Attribute();
        $attr->setName('From stock type');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_MANDATORY);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(10);
        $this->attributes['from_stock_type'] = $attr;

        $attr = new Attribute();
        $attr->setName('To stock type');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_MANDATORY);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(10);
        $this->attributes['to_stock_type'] = $attr;

        $attr = new Attribute();
        $attr->setName('From stock reference');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_OPTIONAL);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(40);
        $this->attributes['from_stock_reference'] = $attr;

        $attr = new Attribute();
        $attr->setName('To stock reference');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_OPTIONAL);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(40);
        $this->attributes['to_stock_reference'] = $attr;

        $attr = new Attribute();
        $attr->setName('From stock reference position');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_OPTIONAL);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_NUMERIC);
        $attr->setLength(9);
        $this->attributes['from_stock_reference_position'] = $attr;

        $attr = new Attribute();
        $attr->setName('To stock reference position');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_OPTIONAL);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_NUMERIC);
        $attr->setLength(9);
        $this->attributes['to_stock_reference_position'] = $attr;

        $attr = new Attribute();
        $attr->setName('Purchase order number');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_OPTIONAL);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(47);
        $this->attributes['purchase_order_number'] = $attr;

        $attr = new Attribute();
        $attr->setName('Purchase order line');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_OPTIONAL);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_NUMERIC);
        $attr->setLength(9);
        $this->attributes['purchase_order_line'] = $attr;

        $this->initZusInfoAttributes(5, 40);
    }
}
