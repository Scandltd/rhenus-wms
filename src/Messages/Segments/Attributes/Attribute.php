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

namespace Scand\RhenusWMS\Messages\Segments\Attributes;

use Scand\RhenusWMS\Messages\Segments\DataTypes\DataTypeInterface;

class Attribute implements AttributeInterface
{
    /**
     * Attribute name property
     */
    protected $name;
    /**
     * Attribute mandatory property
     */
    protected $mandatory;
    /**
     * Attribute data type property
     */
    protected $dataType;
    /**
     * Attribute length property
     */
    protected $length;
    /**
     * Attribute authority property
     */
    protected $authority = DataTypeInterface::AUTHORITY_CUSTOMER_CAN_CNAGE;
    /**
     * Attribute allowableValues property
     */
    protected $allowableValues;
    /**
     * Attribute value property
     */
    protected $value;
    /**
     * Defines if attribute will be visible in CSV
     * @var bool
     */
    protected $visibleInCSV = true;

    /**
     * @return mixed
     */
    public function getAllowableValues()
    {
        return $this->allowableValues;
    }

    /**
     * @return mixed
     */
    public function getAuthority()
    {
        return $this->authority;
    }

    /**
     * @return mixed
     */
    public function getDataType()
    {
        return $this->dataType;
    }

    /**
     * @return mixed
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @return mixed
     */
    public function getMandatory()
    {
        return $this->mandatory;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return empty($this->value) ? '' : $this->value;
    }

    /**
     * @param mixed $allowableValues
     */
    public function setAllowableValues($allowableValues)
    {
        $this->allowableValues = $allowableValues;
    }

    /**
     * @param mixed $authority
     */
    public function setAuthority($authority)
    {
        $this->authority = $authority;
    }

    /**
     * @param mixed $dataType
     */
    public function setDataType($dataType)
    {
        $this->dataType = $dataType;
    }

    /**
     * @param mixed $length
     */
    public function setLength($length)
    {
        $this->length = $length;
    }

    /**
     * @param mixed $mandatory
     */
    public function setMandatory($mandatory)
    {
        $this->mandatory = $mandatory;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return bool
     */
    public function isVisibleInCSV()
    {
        return $this->visibleInCSV;
    }

    /**
     * @param bool $value
     */
    public function setVisibleInCSV($value)
    {
        $this->visibleInCSV = $value;
    }

    /**
     * Validates attribute based on data type
     * @return boolean
     */
    public function validate()
    {
        // TODO: validate by data type
        return true;
    }

    /**
     * Returns error code
     * @return integer
     */
    public function getErrCode()
    {
        return 0;
    }

    /**
     * Returns error message
     * @return string
     */
    public function getErrMessage()
    {
        return "";
    }
}
