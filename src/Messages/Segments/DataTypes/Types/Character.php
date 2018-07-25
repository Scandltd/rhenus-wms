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

namespace Scand\RhenusWMS\Messages\Segments\DataTypes\Types;

use Scand\RhenusWMS\Messages\Segments\DataTypes\DataTypeInterface;
use Scand\RhenusWMS\Messages\Segments\DataTypes\DataType;

class Character extends DataType
{
    protected $type = DataTypeInterface::DATA_TYPE_CHARACTER;
    protected $title = "Alphanumeric";

    /**
     * Figures from 0 to 9
     * Letters from a to z and A to Z including umlauts
     * Symbols: . , ! ? % ( ) = + - * /
     */
    protected $format = "[0-9a-zA-Z\\.\\,\\!\\?\\%\\(\\)\\=\\+\\-\\*\\/]";

    /**
     * Validates attribute value based on format
     */
    public function validate()
    {
        return $this->validateByFormat();
    }
}
