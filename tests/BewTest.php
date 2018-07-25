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

class BewTest extends \PHPUnit_Framework_TestCase
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

    public function testCreateFromRawData()
    {
        $file_path = dirname(__FILE__) . '/data/valid/BEW181300000000004.csv';
        $message = Message::createFromFile($file_path);
        $this->assertInstanceOf(
            'Scand\RhenusWMS\Messages\Types\BEW',
            $message,
            'Created message is not instance of BEW message'
        );

        $errors = $message->getErrors();
        $this->assertEmpty(
            $errors,
            'Errors appeared during loading message from file: ' . $this->getMessageErrorsAsLine($errors)
        );

        foreach ($message as $segment) {
            /** @var \Scand\RhenusWMS\Messages\Segments\Segment $segment */
            $this->assertNotEmpty($segment->getName());
        }

        $first = $message->getFirstSegment();
        $rec_type = $first->getAttributeValue('record_type');
        $fromArticleNumber = $first->getAttributeValue('from_article_number');
        $this->assertEquals('2500', $rec_type, 'getAttributeValue returned wrong value for record_type');
        $this->assertEquals('70200146', $fromArticleNumber, 'getAttributeValue returned wrong value for booking_date');
    }
}
