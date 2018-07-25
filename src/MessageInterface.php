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

namespace Scand\RhenusWMS;

use Scand\RhenusWMS\Messages\Segments\Segment;

interface MessageInterface
{
    /**
     * This does not apply to transfers in CSV formant,
     * since only the actual user data can be transferred in each field.
     * The '|' divider symbol is expected between the individual fields.
     */
    const CSV_STRUCTURE_DELIMITER = "|";

    /**
     * Getter for FileType object
     * @return \Scand\RhenusWMS\Messages\Files\FileType
     */
    public function getFileTypeObject();

    /**
     * Returns the type of message based on file type
     * @return string
     */
    public function getType();

    /**
     * Returns true if direction is out
     * @return boolean
     */
    public function isOut();

    /**
     * Adds new segment
     * @param Segment $segment Instance of segment
     */
    public function addSegment(Segment $segment);
}
