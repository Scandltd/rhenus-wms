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

namespace Scand\RhenusWMS\Messages\Segments;

interface SegmentInterface
{
    /**
     * Attribute mandatory flag
     */
    const ATTRIBUTE_MANDATORY = "M";
    /**
     * Attribute optional flag
     */
    const ATTRIBUTE_OPTIONAL = "O";
    /**
     * AR message segments
     */
    const TYPE_AR = "AR";
    /*
     * TYPE_AR_ZUS_INFO is a part of TYPE_AR but declared as separate type
     * because it must be at the end of structure after all segments
     * */
    const TYPE_AR_ZUS_INFO = "AR_ZUS_INFO";
    const TYPE_AR_TEXT = "AR_TEXT";
    const TYPE_AR_LOG_EINH = "AR_LOG_EINH";
    const TYPE_AR_EAN = "AR_EAN";
    const RECORD_TYPE_AR = "1100";
    const AR_CSV_COL_COUNT = 86;
    /**
     * AVIS message segments
     */
    const TYPE_AVIS = "AVIS";
    const TYPE_AVIS_POS = "AVIS_POS";
    const RECORD_TYPE_AVIS = "1200";
    const AVIS_CSV_COL_COUNT = 32;
    /**
     * BEST message segments
     */
    const TYPE_BEST = "BEST";
    const TYPE_BEST_POS = "BEST_POS";
    const RECORD_TYPE_BEST = "1300";
    /**
     * AUF message segments
     */
    const TYPE_AUF = "AUF";
    const TYPE_AUF_ADR = "AUF_ADR";
    const TYPE_AUF_TEXT = "AUF_TEXT";
    const TYPE_AUF_POS = "AUF_POS";
    const TYPE_AUF_POS_TEXT = "AUF_POS_TEXT";
    const RECORD_TYPE_AUF = "1400";
    const RECORD_TYPE_AUF_POS = "1430";
    const AUF_CSV_COL_COUNT = 160;
    /**
     * BEW message segments
     */
    const TYPE_BEW = "BEW";
    const RECORD_TYPE_BEW = "2500";
    const BEW_CSV_COL_COUNT = 27;
    /**
     * BESTAND message segments
     */
    const TYPE_BESTAND = "BESTAND";
    const RECORD_TYPE_BESTAND = "2600";
    const BESTAND_CSV_COL_COUNT = 12;
    /**
     * RAVIS message segments
     */
    const TYPE_RAVIS = "RAVIS";
    const TYPE_RAVIS_POS = "RAVIS_POS";
    const RECORD_TYPE_RAVIS_POS = "2200";
    const RAVIS_CSV_COL_COUNT = 9;
    const RAVIS_POS_CSV_COL_COUNT = 18;
    /**
     * RAUF message segments
     */
    const TYPE_RAUF = "RAUF";
    const TYPE_RAUF_POS = "RAUF_POS";
    const TYPE_RAUF_LE = "RAUF_LE";
    const TYPE_RAUF_POS_LE = "RAUF_POS_LE";
    const TYPE_RAUF_POS_SN = "RAUF_POS_SN";
    const RECORD_TYPE_RAUF_POS = "2400";
    const RAUF_CSV_COL_COUNT = 37;
}
