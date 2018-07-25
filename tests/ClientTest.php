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

use Scand\RhenusWMS\Client;
use Scand\RhenusWMS\Messages\Files\FileTypeInterface;
use Scand\RhenusWMS\Messages\Segments\SegmentInterface;
use Scand\RhenusWMS\Message;
use Scand\RhenusWMS\Messages\Segments\Segment;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    protected function initClient()
    {
        Client::initializeConnection('ftp://localhost', 'rhenus', 'rhenus', 'in/test', 'out/test');
    }

    protected function getSampleMessage()
    {
        /* @var $messageAR \Scand\RhenusWMS\Messages\Types\AR */
        $messageAR = Message::factory(FileTypeInterface::FILE_TYPE_ARTICLE);

        /* @var $segmentAR \Scand\RhenusWMS\Messages\Segments\Types\AR */
        $segmentAR = Segment::factory(SegmentInterface::TYPE_AR);
        $segmentAR->setAttributeValue('branch', '11');
        $segmentAR->setAttributeValue('client', '15');
        $segmentAR->setAttributeValue('sub_client', '04');
        $segmentAR->setAttributeValue('article_number', '1233421');
        $segmentAR->setAttributeValue('type', 'NORM');
        $segmentAR->setAttributeValue('mandatory_ean', 'N');
        $segmentAR->setAttributeValue('mandatory_batch', 'J');
        $segmentAR->setAttributeValue('mandatory_ed', 'N');
        $segmentAR->setAttributeValue('mandatory_supplier', 'N');
        $segmentAR->setAttributeValue('mandatory_s_n', 'J');
        $segmentAR->setAttributeValue('brand_name', 'Brand Name');
        $segmentAR->setAttributeValue('brand_number', '234');
        $segmentAR->setAttributeValue('hazardous_attribute', 'N');
        $segmentAR->setAttributeValue('origin_country', 'CN');
        $segmentAR->setAttributeValue('tariff_number', 'CustomTariff3546');
        $messageAR->addSegment($segmentAR);

        /* @var $segmentText \Scand\RhenusWMS\Messages\Segments\Types\AR_TEXT */
        $segmentText = Segment::factory(SegmentInterface::TYPE_AR_TEXT);
        $segmentText->setAttributeValue('text', 'dies ist ein Text 1');
        $segmentText->setAttributeValue('language', 'DE');
        $messageAR->addSegment($segmentText);

        $segmentText = Segment::factory(SegmentInterface::TYPE_AR_TEXT);
        $segmentText->setAttributeValue('text', 'this is a text 1');
        $segmentText->setAttributeValue('language', 'EN');
        $messageAR->addSegment($segmentText);

        $segmentText = Segment::factory(SegmentInterface::TYPE_AR_TEXT);
        $segmentText->setAttributeValue('text', 'se trata de un texto 1');
        $segmentText->setAttributeValue('language', 'ES');
        $messageAR->addSegment($segmentText);

        /* @var $segmentLog \Scand\RhenusWMS\Messages\Segments\Types\AR_LOG_EINH */
        $segmentLog = Segment::factory(SegmentInterface::TYPE_AR_LOG_EINH);
        $segmentLog->setAttributeValue('quantity_unit', 'ST');
        $segmentLog->setAttributeValue('length', 50);
        $segmentLog->setAttributeValue('width', 50);
        $segmentLog->setAttributeValue('height', 50);
        $segmentLog->setAttributeValue('weight', 200);
        $segmentLog->setAttributeValue('base_quantity_attribute', 'J');
        $segmentLog->setAttributeValue('number_quantity_unit', 1);
        $messageAR->addSegment($segmentLog);

        /* @var $segmentEan \Scand\RhenusWMS\Messages\Segments\Types\AR_EAN */
        $segmentEan = Segment::factory(SegmentInterface::TYPE_AR_EAN);
        $segmentEan->setAttributeValue('code', '4006381333931');
        $messageAR->addSegment($segmentEan);

        $segmentEan = Segment::factory(SegmentInterface::TYPE_AR_EAN);
        $segmentEan->setAttributeValue('code', '4003994155486');
        $messageAR->addSegment($segmentEan);

        $segmentLog = Segment::factory(SegmentInterface::TYPE_AR_LOG_EINH);
        $segmentLog->setAttributeValue('quantity_unit', 'VE');
        $segmentLog->setAttributeValue('length', 250);
        $segmentLog->setAttributeValue('width', 50);
        $segmentLog->setAttributeValue('height', 100);
        $segmentLog->setAttributeValue('weight', 2000);
        $segmentLog->setAttributeValue('base_quantity_attribute', 'N');
        $segmentLog->setAttributeValue('number_quantity_unit', 10);
        $messageAR->addSegment($segmentLog);

        $segmentEan = Segment::factory(SegmentInterface::TYPE_AR_EAN);
        $segmentEan->setAttributeValue('code', '4006366333931');
        $messageAR->addSegment($segmentEan);

        $segmentEan = Segment::factory(SegmentInterface::TYPE_AR_EAN);
        $segmentEan->setAttributeValue('code', '4003994155111');
        $messageAR->addSegment($segmentEan);

        $segmentEan = Segment::factory(SegmentInterface::TYPE_AR_EAN);
        $segmentEan->setAttributeValue('code', '4002394155111');
        $messageAR->addSegment($segmentEan);

        /* @var $segmentZusInfo \Scand\RhenusWMS\Messages\Segments\Types\AR_ZUS_INFO */
        $segmentZusInfo = Segment::factory(SegmentInterface::TYPE_AR_ZUS_INFO);
        $segmentZusInfo->setAttributeValue('zus_info3', 'Zus Info 3');
        $segmentZusInfo->setAttributeValue('zus_info9', 'Zus Info 9');
        $messageAR->addSegment($segmentZusInfo);

        return $messageAR;
    }

    protected function getRuntimeDir()
    {
        $dir = dirname(__FILE__) . '/runtime';

        if (!file_exists($dir)) {
            if (!mkdir($dir, 0777, true)) {
                $this->fail('Unable to create runtime directory');
            }
        }

        return $dir;
    }

    public function testMessagesUpload()
    {
        $this->initClient();
        $file_path = dirname(__FILE__) . '/data/valid/AR181300000000001.csv';
        Client::getConnection()->uploadMessageFile($file_path);
        Client::getConnection()->uploadMessageFile($file_path, false);
        Client::getConnection()->uploadMessageFile($file_path, false);
        $baseUrl = Client::getConnection()->getBaseURL(FileTypeInterface::FILE_DIRECTION_OUT);
        $this->assertEquals(
            doubleval(filesize($file_path)),
            Client::getConnection()->getFileSize($baseUrl . '/AR181300000000001.csv'),
            'The message sizes are not the same'
        );
        $this->assertNotEquals(
            doubleval(-1),
            Client::getConnection()->getFileSize($baseUrl . '/AR181300000000001.rel'),
            'The *.rel file is not exists'
        );
        $this->deleteFile($baseUrl . '/AR181300000000001.csv');
        $this->deleteFile($baseUrl . '/AR181300000000001.rel');
        $this->deleteFile($baseUrl . '/AR181300000000002.csv');
        $this->deleteFile($baseUrl . '/AR181300000000003.csv');
    }

    public function testMessagesDownload()
    {
        $this->initClient();
        $file_path = dirname(__FILE__) . '/data/valid/AR181300000000001.csv';
        $data = file_get_contents($file_path);
        $baseUrl = Client::getConnection()->getBaseURL(FileTypeInterface::FILE_DIRECTION_IN);
        $curl = Client::getConnection()->getNewCurlInstance($baseUrl);
        $curl->uploadFile($data, $baseUrl . '/AR181300000000001.csv');
        $curl->uploadFile($data, $baseUrl . '/AR181300000000002.csv');
        $curl->uploadFile($data, $baseUrl . '/AR181300000000003.csv');
        $messages = Client::getConnection()->downloadMessages();
        $this->assertEquals(
            3,
            count($messages),
            'Can not download messages'
        );
        $this->deleteFile($baseUrl . '/AR181300000000001.csv');
        $this->deleteFile($baseUrl . '/AR181300000000002.csv');
        $this->deleteFile($baseUrl . '/AR181300000000003.csv');
    }

    public function reftestPdfUpload()
    {
        $this->initClient();
        $file_path = dirname(__FILE__) . '/data/test.pdf';
        Client::getConnection()->uploadPdfFile($file_path, '123test.pdf');
        $baseUrl = Client::getConnection()->getBaseURL(FileTypeInterface::FILE_DIRECTION_OUT);
        $this->assertEquals(
            doubleval(filesize($file_path)),
            Client::getConnection()->getFileSize($baseUrl . '/123test.pdf'),
            'The PDF file sizes are not the same'
        );
        $this->deleteFile($baseUrl . '/123test.pdf');
    }

    protected function deleteFile($filePath)
    {
        Client::getConnection()->deleteFile($filePath);
        $this->assertEquals(
            doubleval(-1),
            Client::getConnection()->getFileSize($filePath),
            "File '" . basename($filePath) . "' has not been removed"
        );
    }
}
