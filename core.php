<?php
//ini_set('display_errors',1);
//error_reporting(E_ALL);

require('config.php');
mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS);
mysql_select_db(MYSQL_DB);
?>