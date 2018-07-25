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

class BestandTest extends \PHPUnit_Framework_TestCase
{
    protected function getMessageErrorsAsLine($errors)
    {
        $result = '';

        foreach ($errors as $error) {
            $result .= !empty($result) ? ';' : '';
            if (is_array($error)) {
                $result .= $error['message'];
            } else {
                $result .= $error;
            }
        }

        return $result;
    }

    public function testCreateFromFile()
    {
        $file_path = dirname(__FILE__) . '/data/valid/BESTAND181300000000001.csv';
        $messages = Message::createFromFile($file_path);
        $this->assertTrue(is_array($messages), 'Message::createFromFile returned not an array.');
        $this->assertEquals(11, count($messages), 'Wrong messages count');

        foreach ($messages as $message) {
            $this->assertInstanceOf(
                'Scand\RhenusWMS\Messages\Types\BESTAND',
                $message,
                'Created message is not instance of BESTAND message'
            );

            $errors = $message->getErrors();
            $csv = $message->toCSV();
            $this->assertEmpty(
                $errors,
                'Errors appeared during loading message from file: ' . $this->getMessageErrorsAsLine($errors)
            );
            $this->assertNotEmpty($csv, 'Got empty CSV string');

            foreach ($message as $segment) {
                /** @var \Scand\RhenusWMS\Messages\Segments\Segment $segment */
                $this->assertNotEmpty($segment->getName());
            }

            $first = $message->getFirstSegment();
            $rec_type = $first->getAttributeValue('record_type');
            $date = $first->getAttributeValue('date');
            $time = $first->getAttributeValue('time');
            $this->assertEquals('2600', $rec_type, 'getAttributeValue returned wrong value for record_type');
            $this->assertEquals('27.05.2016', $date, 'getAttributeValue returned wrong value for date');
            $this->assertEquals('16:59:12', $time, 'getAttributeValue returned wrong value for time');
        }
    }
}
