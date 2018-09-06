<?php
/**
 * Copyright (c) 2017, Art of WiFi
 *
 * This file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.md
 *
 */

/**
 * Controller configuration
 * ===============================
 * Copy this file to your working directory, rename it to config.php and update the section below with your UniFi
 * controller details and credentials
 */
$controller_user     = 'lehoang'; // the user name for access to the UniFi Controller
$controller_password = '12345678'; // the password for access to the UniFi Controller
$controller_url      = 'https://localhost:8443'; // full url to the UniFi Controller, eg. 'https://22.22.11.11:8443'
$controller_version  = '5.5.20'; // the version of the Controller software, eg. '4.6.6' (must be at least 4.0.0)
$MAX_DATA_USAGE_PER_DAY = 2; //maximum data usage for user in one day.(GB)
$site_id = "default";
/**
 * set to true (without quotes) to enable debug output to the browser and the PHP error log
 */
$debug = false;
