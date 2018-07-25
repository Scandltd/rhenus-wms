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

use Scand\RhenusWMS\Classes\Curl;
use Scand\RhenusWMS\Connections\FTP;

/**
 * Class CurlTest
 */
class FtpTest extends \PHPUnit_Framework_TestCase
{
    /** @var  \PHPUnit_Framework_MockObject_MockObject */
    private $curl;

    /**
     * Set up default objects
     */
    public function setUp()
    {
        $this->curl = $this->getMockBuilder(Curl::class)->disableOriginalConstructor()->setMethods(
            [
                "exec",
                "setOpt",
                "ftpFileExists",
            ]
        )->getMock();
    }

    /**
     * Test checkAndDeleteMessageFile methods
     */
    public function testCheckAndDeleteMessageFile()
    {
        $this->curl->expects($this->any())->method("exec")->will($this->returnValue(""));
        $this->curl->expects($this->any())->method("setOpt")->will($this->returnValue(true));
        $this->curl->expects($this->any())->method("ftpFileExists")->will(
            $this->returnCallback(
                function () {
                    $args = func_get_args();
                    $validValues = [
                        "//AUF181300000000001.csv",
                        "//AUF181300000000002.csv",
                        "//AUF181300000000002.rel",
                    ];
                    if (in_array($args[0], $validValues)) {
                        return true;
                    } else {
                        return false;
                    }
                }
            )
        );

        /** @var FTP|\PHPUnit_Framework_MockObject_MockObject $ftp */
        $ftp = $this->getMockBuilder(FTP::class)
            ->setMethods(["getNewCurlInstance"])
            ->disableOriginalConstructor()
            ->getMock();
        $ftp->expects($this->any())->method("getNewCurlInstance")->will($this->returnValue($this->curl));

        $this->assertEquals(false, $ftp->checkAndDeleteMessageFile("XXX.csv"));
        $this->assertEquals(true, $ftp->checkAndDeleteMessageFile("AUF181300000000001.csv"));
        $this->assertEquals(false, $ftp->checkAndDeleteMessageFile("AUF181300000000002.csv"));
    }
}
