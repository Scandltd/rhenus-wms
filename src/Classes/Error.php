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

namespace Scand\RhenusWMS\Classes;

trait Error
{
    /**
     * Collection of errors
     */
    protected $errors = [];

    /**
     * Adds new error into collection
     * @param int $err_code Error code
     * @param string $err_msg Error message
     */
    protected function addError($err_code, $err_msg)
    {
        $this->errors[] = [
            'code' => $err_code,
            'message' => $err_msg,
        ];
    }

    /**
     * @param mixed $errors
     */
    protected function addErrors($errors)
    {
        foreach ($errors as $code => $msg) {
            $this->addError($code, $msg);
        }
    }

    /**
     * Indicates if there was errors
     * @return boolean
     */
    protected function hasError()
    {
        return sizeof($this->errors) > 0;
    }

    /**
     * @param mixed $errors
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;
    }

    /**
     * @return mixed
     */
    public function getErrors()
    {
        return $this->errors;
    }

    public function getErrorsAsString()
    {
        $ret = '';

        foreach ($this->errors as $error) {
            if (!empty($ret)) {
                $ret .= '; ';
            }

            $ret .= $error['message'];
        }

        return $ret;
    }
}
