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
use Scand\RhenusWMS\Messages\Segments\SegmentInterface;

class RaufTest extends \PHPUnit_Framework_TestCase
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
        $file_path = dirname(__FILE__) . '/data/valid/RAUF460400000000000000001.csv';
        $messages = Message::createFromFile($file_path);
        $this->assertTrue(is_array($messages), 'Message::createFromFile returned not an array.');
        $this->assertEquals(2, count($messages), 'Wrong messages count');

        foreach ($messages as $message) {
            $this->assertInstanceOf(
                'Scand\RhenusWMS\Messages\Types\RAUF',
                $message,
                'Created message is not instance of RAUF message'
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
            $this->assertEquals('2400', $rec_type, 'getAttributeValue returned wrong value for record_type');
        }
    }

    public function testAufCreateFromFile()
    {
        $file_path = dirname(__FILE__) . '/data/valid/AUF181300000000001.csv';

        $messages = Message::createFromFile($file_path);
        $num = 0;
        foreach ($messages as $message) {
            /** @var \Scand\RhenusWMS\Messages\Segments\Types\AUF $auf */
            $auf = $message->getSegmentByName(SegmentInterface::TYPE_AUF);
            /** @var \Scand\RhenusWMS\Messages\Segments\Types\AUF_POS $auf_pos */
            $auf_pos = $message->getSegmentByName(SegmentInterface::TYPE_AUF_POS);

            $order_number = $auf->order_number;
            $order_line = $auf_pos->order_line;
            $docNum = $auf->zus_info3;

            $this->assertEquals('14010773', $order_number, 'Wrong order number');
            $this->assertEquals('12011392', $docNum, 'Wrong doc number');
            $this->assertEquals(++$num, $order_line, 'Wrong line number');
        }
    }
}
