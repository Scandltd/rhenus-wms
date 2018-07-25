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

use Scand\RhenusWMS\Exceptions\RhenusException;
use Scand\RhenusWMS\Messages\Segments\DataTypes\DataTypeInterface;
use Scand\RhenusWMS\Messages\Segments\DataTypes\DataType;

class Time extends DataType
{
    protected $type = DataTypeInterface::DATA_TYPE_TIME;
    protected $title = "Time";

    /**
     * Validates attribute value based on format
     * 8 symbols meaning
     * Format hh:mm:ss
     * hh: Hours (00-23)
     * mm: Minutes
     * ss: Seconds
     */
    public function validate()
    {
        $value = $this->getValue();
        if (strlen($value) != 8) {
            throw new RhenusException('Wrong time format: expected 8 symbols');
        }

        $time = explode(":", $value);
        if (sizeof($time) < 2 || strlen($time[0]) != 2 || strlen($time[1]) != 2 || strlen($time[2]) != 2) {
            throw new RhenusException("Wrong time format: expected 'hh:mm:ss' format.");
        }

        $sec = (int)$time[0];
        $min = (int)$time[1];
        $hour = (int)$time[2];

        return $sec >= 0 && $sec < 60 && $min >= 0 && $min < 60 && $hour >= 0 && $hour < 24;
    }
}
