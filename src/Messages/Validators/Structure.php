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

namespace Scand\RhenusWMS\Messages\Validators;

use Scand\RhenusWMS\Exceptions\RhenusException;

abstract class Structure implements StructureInterface
{
    public static function factory($occurrence_type)
    {
        $class_name = __NAMESPACE__ . '\\Messages\\Validators\\Occurrences\\Occurrence' . $occurrence_type;
        if (!class_exists($class_name)) {
            throw new RhenusException("Class '" . $class_name . "' not found");
        }

        return new $class_name;
    }

    /**
     * Validate structure
     */
    abstract public function validate();
}
