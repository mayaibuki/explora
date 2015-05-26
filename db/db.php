<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
/**
 * The db.php file which initiates a connection to the database
 * and gives a global $db variable for access
 * @author Swashata <swashata@intechgrity.com>
 * @uses ezSQL MySQL
 */
/** edit your configuration */
$dbuser = 'mayaibuk_dbuser';
$dbname = 'mayaibuk_explora';
$dbpassword = 't-hEFG)([hUv';
$dbhost = 'localhost';

/** Stop editing from here, else you know what you are doing ;) */

/** defined the root for the db */
if(!defined('ADMIN_DB_DIR'))
    define('ADMIN_DB_DIR', dirname(__FILE__));

require_once ADMIN_DB_DIR . '/ez_sql_core.php';
require_once ADMIN_DB_DIR . '/ez_sql_mysql.php';
global $db;
$db = new ezSQL_mysql($dbuser, $dbpassword, $dbname, $dbhost);
