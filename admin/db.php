<?php

/** edit your configuration */
$dbuser = 'dipak';
$dbname = 'ner';
$dbpassword = 'tmp123';
$dbhost = 'localhost';

/** Stop editing from here, else you know what you are doing ;) */

/** defined the root for the db */
if(!defined('ADMIN_DB_DIR'))
    define('ADMIN_DB_DIR', dirname(__FILE__));

require_once ADMIN_DB_DIR . '/ez_sql_core.php';
require_once ADMIN_DB_DIR . '/ez_sql_mysql.php';
global $db;
$db = new ezSQL_mysql($dbuser, $dbpassword, $dbname, $dbhost);
