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

class Date extends DataType
{
    protected $type = DataTypeInterface::DATA_TYPE_DATE;
    protected $title = "Date without time";

    /**
     * Validates attribute value based on format
     * 10 symbols meaning
     * Format DD/MM/YYYY
     * YYYY: Year
     * MM: Month
     * DD: Day
     * Each of these components are displayed in numerical form separately.
     */
    public function validate()
    {
        $value = $this->getValue();
        if (strlen($value) != 10) {
            throw new RhenusException('Wrong date format: expected 10 symbols');
        }

        $date = explode("/", $value);
        if (sizeof($date) < 2 || strlen($date[0]) != 2 || strlen($date[1]) != 2 || strlen($date[2]) != 4) {
            throw new RhenusException("Wrong date format: expected 'DD/MM/YYYY' format.");
        }

        $day = (int)$date[0];
        $month = (int)$date[1];
        $year = (int)$date[2];

        return checkdate($month, $day, $year);
    }
}
