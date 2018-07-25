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

use Scand\RhenusWMS\Classes;
use Scand\RhenusWMS\Connections\FTP;
use Scand\RhenusWMS\Exceptions\RhenusException;

/**
 * Class Client
 * @package RhenusWMS
 */
class Client
{
    /**
     * @var Client
     */
    protected static $instance = null;
    protected static $ftpHost = null;
    protected static $ftpLogin = null;
    protected static $ftpPassword = null;
    protected static $inDir = null;
    protected static $outDir = null;

    /**
     * @param string $ftpHost
     * @param string $ftpLogin
     * @param string $ftpPassword
     * @param string $inDir
     * @param string $outDir
     */
    public static function initializeConnection($ftpHost, $ftpLogin, $ftpPassword, $inDir, $outDir)
    {
        static::$ftpHost = $ftpHost;
        static::$ftpLogin = $ftpLogin;
        static::$ftpPassword = $ftpPassword;
        static::$inDir = $inDir;
        static::$outDir = $outDir;
    }

    /**
     * @return \Scand\RhenusWMS\Connections\ConnectionInterface
     * @throws \Scand\RhenusWMS\Exceptions\RhenusException
     */
    public static function getConnection()
    {
        if (!static::$ftpHost || !static::$ftpLogin || !static::$ftpPassword || !static::$inDir || !static::$outDir) {
            throw new RhenusException('Connection details are missing. Unable to connect.');
        }

        if (!static::$instance) {
            static::$instance = new FTP(
                static::$ftpHost,
                static::$ftpLogin,
                static::$ftpPassword,
                static::$inDir,
                static::$outDir
            );
        }

        return static::$instance;
    }

    private function __construct()
    {
    }

    private function __wakeup()
    {
    }

    private function __clone()
    {
    }
}
