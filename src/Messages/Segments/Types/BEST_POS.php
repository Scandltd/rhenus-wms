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
 * Class BEST_POS
 * @package RhenusWMS\Messages\Segments\Types
 *
 * @property integer $purchase_order_line
 * @property string $article_number
 * @property integer $quantity
 * @property string $supplier_article_number
 * @property integer $handover_quantity
 * @property string $delivery_date
 * @property string $stock_reference
 * @property integer $stock_reference_position
 * @property string $reference_number
 * @property string $reference_position
 * @property string $closing_indicator
 * @property string $zus_info1
 * @property string $zus_info2
 * @property string $zus_info3
 * @property string $zus_info4
 * @property string $zus_info5
 */
class BEST_POS extends Segment
{
    /**
     * Segment name property
     */
    protected $name = SegmentInterface::TYPE_BEST_POS;

    /**
     * Initialization of attributes
     */
    protected function init()
    {
        $attr = new Attribute();
        $attr->setName('Purchase Order Line');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_MANDATORY);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_NUMERIC);
        $attr->setLength(9);
        $this->attributes['purchase_order_line'] = $attr;

        $attr = new Attribute();
        $attr->setName('Article number');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_MANDATORY);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(27);
        $this->attributes['article_number'] = $attr;

        $attr = new Attribute();
        $attr->setName('Quantity');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_MANDATORY);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_NUMERIC);
        $attr->setLength(9);
        $this->attributes['quantity'] = $attr;

        $attr = new Attribute();
        $attr->setName('Supplier Article Number');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_OPTIONAL);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(30);
        $this->attributes['supplier_article_number'] = $attr;

        $attr = new Attribute();
        $attr->setName('Handover Quantity');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_OPTIONAL);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_NUMERIC);
        $attr->setLength(9);
        $this->attributes['handover_quantity'] = $attr;

        $attr = new Attribute();
        $attr->setName('Delivery date');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_OPTIONAL);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_DATE);
        $attr->setLength(10);
        $this->attributes['delivery_date'] = $attr;

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
        $attr->setName('Reference number');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_OPTIONAL);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(35);
        $this->attributes['reference_number'] = $attr;

        $attr = new Attribute();
        $attr->setName('Reference position');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_OPTIONAL);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(6);
        $this->attributes['reference_position'] = $attr;

        $attr = new Attribute();
        $attr->setName('Indicator for closing purchase order');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_OPTIONAL);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(1);
        $attr->setAllowableValues(['J', 'N']);
        $this->attributes['closing_indicator'] = $attr;

        $this->initZusInfoAttributes(5, 40);
    }
}
