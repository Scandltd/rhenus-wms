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
 * Class AUF_POS
 * @package RhenusWMS\Messages\Segments\Types
 *
 * @property string $record_type
 * @property string $branch
 * @property string $client
 * @property string $sub_client
 * @property integer $order_line
 * @property string $order_line_type
 * @property string $article_number
 * @property string $package_number
 * @property integer $quantity
 * @property string $stock_type
 * @property string $partial_delivery
 * @property string $ed_purity
 * @property string $ed
 * @property string $batch_purity
 * @property string $batch
 * @property string $supplier_purity
 * @property string $supplier
 * @property string $order_line_group
 * @property string $stock_reference
 * @property integer $stock_reference_position
 * @property string $bill_material_indicator
 * @property integer $bill_material_line
 * @property string $customer_article_number
 * @property string $customer_article_description
 * @property string $zus_info1
 * @property string $zus_info2
 * @property string $zus_info3
 * @property string $zus_info4
 * @property string $zus_info5
 */
class AUF_POS extends Segment
{
    /**
     * Segment name property
     */
    protected $name = SegmentInterface::TYPE_AUF_POS;

    /**
     * Initialization of attributes
     */
    protected function init()
    {
        $attr = new Attribute();
        $attr->setName('Order line');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_MANDATORY);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_NUMERIC);
        $attr->setLength(9);
        $this->attributes['order_line'] = $attr;

        $attr = new Attribute();
        $attr->setName('Type of order line');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_MANDATORY);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(9);
        $attr->setAllowableValues(['ar', 'packst']);
        $this->attributes['order_line_type'] = $attr;

        $attr = new Attribute();
        $attr->setName('Article number');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_OPTIONAL);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(27);
        $this->attributes['article_number'] = $attr;

        $attr = new Attribute();
        $attr->setName('Package number');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_OPTIONAL);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(30);
        $this->attributes['package_number'] = $attr;

        $attr = new Attribute();
        $attr->setName('Quantity');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_MANDATORY);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_NUMERIC);
        $attr->setLength(9);
        $this->attributes['quantity'] = $attr;

        $attr = new Attribute();
        $attr->setName('Stock type');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_OPTIONAL);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(10);
        $this->attributes['stock_type'] = $attr;

        $attr = new Attribute();
        $attr->setName('Partial delivery attribute');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_MANDATORY);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(1);
        $this->attributes['partial_delivery'] = $attr;

        $attr = new Attribute();
        $attr->setName('ED purity');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_MANDATORY);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(1);
        $attr->setAllowableValues(['J', 'N']);
        $this->attributes['ed_purity'] = $attr;

        $attr = new Attribute();
        $attr->setName('ED');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_OPTIONAL);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_DATE);
        $attr->setLength(10);
        $this->attributes['ed'] = $attr;

        $attr = new Attribute();
        $attr->setName('Batch purity');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_MANDATORY);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(1);
        $attr->setAllowableValues(['J', 'N']);
        $this->attributes['batch_purity'] = $attr;

        $attr = new Attribute();
        $attr->setName('Batch');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_OPTIONAL);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(30);
        $this->attributes['batch'] = $attr;

        $attr = new Attribute();
        $attr->setName('Supplier purity');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_MANDATORY);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(1);
        $attr->setAllowableValues(['J', 'N']);
        $this->attributes['supplier_purity'] = $attr;

        $attr = new Attribute();
        $attr->setName('Supplier');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_OPTIONAL);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(20);
        $this->attributes['supplier'] = $attr;

        $attr = new Attribute();
        $attr->setName('Order line group');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_OPTIONAL);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(10);
        $this->attributes['order_line_group'] = $attr;

        $attr = new Attribute();
        $attr->setName('Stock reference');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_OPTIONAL);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(40);
        $this->attributes['stock_reference'] = $attr;

        $attr = new Attribute();
        $attr->setName('Stock reference position');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_OPTIONAL);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_NUMERIC);
        $attr->setLength(9);
        $this->attributes['stock_reference_position'] = $attr;

        $attr = new Attribute();
        $attr->setName('Bill of material indicator');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_MANDATORY);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(1);
        $attr->setAllowableValues(['J', 'N']);
        $this->attributes['bill_material_indicator'] = $attr;

        $attr = new Attribute();
        $attr->setName('Bill of material line');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_OPTIONAL);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_NUMERIC);
        $attr->setLength(9);
        $this->attributes['bill_material_line'] = $attr;

        $attr = new Attribute();
        $attr->setName('Customer article number');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_OPTIONAL);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(30);
        $this->attributes['customer_article_number'] = $attr;

        $attr = new Attribute();
        $attr->setName('Customer article description');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_OPTIONAL);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(20);
        $this->attributes['customer_article_description'] = $attr;

        $this->initZusInfoAttributes();
    }
}
