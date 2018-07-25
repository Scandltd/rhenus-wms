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

namespace Scand\RhenusWMS\Messages\Segments;

use Scand\RhenusWMS\Exceptions\RhenusException;
use Scand\RhenusWMS\Classes;
use Scand\RhenusWMS\MessageInterface;
use Scand\RhenusWMS\Messages\Segments\Attributes\Attribute;
use Scand\RhenusWMS\Messages\Segments\DataTypes\DataTypeInterface;

abstract class Segment implements SegmentInterface
{
    use Classes\Error;

    /**
     * Segment name property
     */
    protected $name;
    /**
     * Collection of attributes
     * @var Attribute[]
     */
    protected $attributes;
    /**
     *
     */
    protected $csv = [];

    /**
     * Creates instance of segment by type
     * @param string $segment_type Name of segment type
     * @throws RhenusException
     * @return Segment
     */
    public static function factory($segment_type)
    {
        $class_name = __NAMESPACE__ . '\\Types\\' . $segment_type;
        if (!class_exists($class_name)) {
            throw new RhenusException("Class '" . $class_name . "' not found");
        }

        return new $class_name;
    }

    /**
     * Constructor for instance
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     * Initialization of attributes
     */
    abstract protected function init();

    /**
     * Initialization of common IN attributes
     */
    protected function initCommonInAttributes($record_type = null)
    {
        $attr = new Attribute();
        $attr->setName('Record type');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_MANDATORY);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(4);
        $attr->setAuthority(DataTypeInterface::AUTHORITY_READ_ONLY);
        $attr->setValue($record_type);
        $this->attributes['record_type'] = $attr;

        $attr = new Attribute();
        $attr->setName('Branch');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_MANDATORY);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(2);
        $attr->setAuthority(DataTypeInterface::AUTHORITY_READ_ONLY);
        $this->attributes['branch'] = $attr;

        $attr = new Attribute();
        $attr->setName('Client');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_MANDATORY);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(2);
        $attr->setAuthority(DataTypeInterface::AUTHORITY_READ_ONLY);
        $this->attributes['client'] = $attr;

        $attr = new Attribute();
        $attr->setName('Subclient');
        $attr->setMandatory(SegmentInterface::ATTRIBUTE_MANDATORY);
        $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
        $attr->setLength(2);
        $attr->setAuthority(DataTypeInterface::AUTHORITY_READ_ONLY);
        $this->attributes['sub_client'] = $attr;
    }

    /**
     * Initialization of zus_info attributes group
     *
     * @param int $count
     * @param int $length
     */
    protected function initZusInfoAttributes($count = 5, $length = 200)
    {
        for ($i = 1; $i < $count + 1; $i++) {
            $attr = new Attribute();
            $attr->setName('Zus_info' . $i);
            $attr->setMandatory(SegmentInterface::ATTRIBUTE_OPTIONAL);
            $attr->setDataType(DataTypeInterface::DATA_TYPE_CHARACTER);
            $attr->setLength($length);
            $this->attributes['zus_info' . $i] = $attr;
        }
    }

    /**
     * @param mixed $attributes
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * @return mixed
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets attribute value by attribute name
     * @param string $name Attribute name
     * @param string $value Attribute value
     * @throws RhenusException
     */
    public function setAttributeValue($name, $value)
    {
        if (isset($this->attributes[$name])) {
            /* @var $attr \Scand\RhenusWMS\Messages\Segments\Attributes\Attribute */
            $attr = $this->attributes[$name];
            $attr->setValue($value);
        } else {
            throw new RhenusException("Attribute '" . $name . "' not found");
        }
    }

    /**
     * Gets attribute value by name. If attribute has no value - will return $default.
     * Will throw exception in case of nonexisting attribute
     * @param $name
     * @param null $default
     * @return null
     * @throws \Scand\RhenusWMS\Exceptions\RhenusException
     */
    public function getAttributeValue($name, $default = null)
    {
        if (isset($this->attributes[$name])) {
            /* @var $attr \Scand\RhenusWMS\Messages\Segments\Attributes\Attribute */
            $attr = isset($this->attributes[$name]) ? $this->attributes[$name] : null;
            return $attr ? $attr->getValue() : $default;
        } else {
            throw new RhenusException("Attribute '" . $name . "' not found");
        }
    }

    /**
     * Validates attributes
     * @return boolean
     */
    public function validate()
    {
        $this->csv = [];

        /* @var $attribute \Scand\RhenusWMS\Messages\Segments\Attributes\Attribute */
        foreach ($this->attributes as $attribute) {
            if ($attribute->validate()) {
                if (!$attribute->isVisibleInCSV()) {
                    continue;
                }

                $this->csv[] = $attribute->getValue();
            } else {
                $this->addError($attribute->getErrCode(), $attribute->getErrMessage());
            }
        }

        return !$this->hasError();
    }

    /**
     * Returns segment attribute values in CSV format
     * @return string
     */
    public function toCSV()
    {
        return implode(MessageInterface::CSV_STRUCTURE_DELIMITER, $this->csv);
    }

    /**
     * Returns segment's attributes values as array
     * @return array
     */
    public function toArray()
    {
        return $this->csv;
    }

    /**
     * Returns count of segment's attributes
     * @return int
     */
    public function getAttributesCount()
    {
        return count($this->attributes);
    }

    public function __set($name, $value)
    {
        if (!isset($this->attributes[$name])) {
            throw new RhenusException('Trying to set unknown attribute "' . $name . '"');
        }

        $this->attributes[$name]->setValue($value);
    }

    public function __get($name)
    {
        if (!isset($this->attributes[$name])) {
            throw new RhenusException('Trying to get unknown attribute "' . $name . '"');
        }
        return $this->attributes[$name]->getValue();
    }

    public function getAttributeObject($name)
    {
        if (!isset($this->attributes[$name])) {
            throw new RhenusException('Trying to get unknown attribute "' . $name . '"');
        }
        return $this->attributes[$name];
    }
}
