<?php
// PHP Grid database connection settings
session_start();
define("PHPGRID_DBTYPE","Mysql"); // or mysqli
define("PHPGRID_DBHOST","localhost");
define("PHPGRID_DBUSER","tnoaunimewb9aenr");
define("PHPGRID_DBPASS","2A28C5TLYTYFq1ZkkX1I");
define("PHPGRID_DBNAME","tnoaunimewb9aenr-0");

// Automatically make db connection inside lib
define("PHPGRID_AUTOCONNECT",1);

// Basepath for lib
define("PHPGRID_LIBPATH",dirname(__FILE__).DIRECTORY_SEPARATOR."lib".DIRECTORY_SEPARATOR);
?>