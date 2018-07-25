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

namespace Scand\RhenusWMS\Messages\Files;

interface FileTypeInterface
{
    /**
     * The following file types shall exist for Communication Customer -> Rhenus
     */
    const FILE_DIRECTION_OUT = "OUT";
    /**
     * The following file types shall exist for Communication Rhenus -> Customer
     */
    const FILE_DIRECTION_IN = "IN";

    /* OUT types */
    /**
     * Article master data
     */
    const FILE_TYPE_ARTICLE = "AR";
    /**
     * Advice
     */
    const FILE_TYPE_ADVICE = "AVIS";
    /**
     * Purchase order
     */
    const FILE_TYPE_PURCHASE = "BEST";
    /**
     * Orders
     */
    const FILE_TYPE_ORDERS = "AUF";

    /* IN types */
    /**
     * Advice confirmation
     */
    const FILE_TYPE_ADVICE_CONFIRMATION = "RAVIS";
    /**
     * Orders confirmation
     */
    const FILE_TYPE_ORDERS_CONFIRMATION = "RAUF";
    /**
     * Confirmation on general movements as well as goods receipt entries for purchase orders
     */
    const FILE_TYPE_GENERAL_CONFIRMATION = "BEW";
    /**
     * Stock comparison
     */
    const FILE_TYPE_STOCK_COMPARISON = "BESTAND";

    /**
     * Returns true if type is out
     * @return boolean
     */
    public function isOut();
}
