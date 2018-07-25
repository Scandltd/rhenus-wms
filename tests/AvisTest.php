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

namespace Scand\RhenusWMS\Tests;

use Scand\RhenusWMS\Message;
use Scand\RhenusWMS\Messages\Types\AVIS;

class AvisTest extends \PHPUnit_Framework_TestCase
{
    public function testGetData()
    {
        $file_path = dirname(__FILE__) . '/data/valid/AVIS181300000000001.csv';
        $messages = Message::createFromFile($file_path);

        $this->assertNotEmpty($messages, 'Empty messages array');
        $this->assertTrue(
            $messages[0] instanceof AVIS,
            'Created message is not instance of AVIS'
        );

        /** @var \Scand\RhenusWMS\Messages\Segments\Types\AVIS $avis */
        $avis = $messages[0]->getFirstSegment();
        $this->assertEquals('29', $avis->advice_number, 'Wrong advice number');
    }
}
