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

namespace Scand\RhenusWMS\Messages\Segments\DataTypes;

/**
 * The possible types of attributes
 */
interface DataTypeInterface
{
    /**
     * Numeric
     */
    const DATA_TYPE_NUMERIC = "N";
    /**
     * Alphanumeric/character
     */
    const DATA_TYPE_CHARACTER = "C";
    /**
     * Date without time
     */
    const DATA_TYPE_DATE = "DoZ";
    /**
     * Time
     */
    const DATA_TYPE_TIME = "Z";

    /**
     * The customer ERP system can initially insert this attribute.
     * The attribute is then transferred to the RHENUS authority.
     */
    const AUTHORITY_INITIAL_INSERT = "IR";
    /**
     * The attribute is administered by RHENUS only.
     */
    const AUTHORITY_RHENUS_ADMINISTERED_ONLY = "R";
    /**
     * The customer ERP system can change this attribute.
     * The attribute is not changed by RHENUS.
     */
    const AUTHORITY_CUSTOMER_CAN_CNAGE = "W";
    /**
     * The customer ERP system sends this attribute to the Rhenus WMS System.
     * Neither the customer nor RHENUS change this attribute.
     */
    const AUTHORITY_READ_ONLY = "I";

    /**
     * Returns true if ERP system can change this attribute
     */
    public function canUpdate($authority);
}
