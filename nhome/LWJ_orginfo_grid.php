<?php
/**
 * PHP Grid Component
 *
 * @author Abu Ghufran <gridphp@gmail.com> - http://www.phpgrid.org
 * @version 1.5.2
 * @license: see license.txt included in package
 */

// include db config
include_once("LWJ_config.php");
include_once("class/DB2.php");

// set up DB
mysql_connect(PHPGRID_DBHOST, PHPGRID_DBUSER, PHPGRID_DBPASS);
mysql_select_db(PHPGRID_DBNAME);

// include and create object
include(PHPGRID_LIBPATH."inc/LWJ_jqgrid_dist.php");

session_start();

$status_option = "0:停用;1:正常;2:評鑑";
$OrgType_option = "nhome:nhome";
$homecare_option = "0:None;1:Has";

$g = new jqgrid();

// set few params
$grid["caption"] = "Orginfo";
$grid["autowidth"] = false;
$g->set_options($grid);

// set database table for CRUD operations
$g->table = 'orginfo';

//some param
$col = array();
$col['title'] = "OrgID";
$col['name'] = "OrgID";
$col['width'] = "80";
$col['editable'] = true;
$cols[] = $col;

$col = array();
$col['title'] = "Name";
$col['name'] = "Name";
$col['editable'] = true;
$cols[] = $col;

$col = array();
$col['title'] = "ShortName";
$col['name'] = "ShortName";
$col['editable'] = true;
$cols[] = $col;

$col = array();
$col['title'] = "Address";
$col['name'] = "Address";
$col['editable'] = true;
$cols[] = $col;

$col = array();
$col['title'] = "Phone";
$col['name'] = "Phone";
$col['editable'] = true;
$cols[] = $col;

$col = array();
$col['title'] = "InvoiceNo";
$col['name'] = "InvoiceNo";
$col['editable'] = true;
$cols[] = $col;

$col = array();
$col['title'] = "Contact";
$col['name'] = "ContactPerson";
$col['editable'] = true;
$cols[] = $col;

$col = array();
$col['title'] = "ExpireDate";
$col['name'] = "ExpireDate";
$col['width'] = "100";
$col['editable'] = true;
$col['formatter'] = "date";
$cols[] = $col;

$col = array();
$col['title'] = "DB";
$col['name'] = "DBname";
$col['editable'] = true;
$col['width'] = "200";
$cols[] = $col;

$col = array();
$col['title'] = "狀態";
$col['name'] = "status";
$col['width'] = "55";
$col['editable'] = true;
$col['formatter'] = "select";
$col['edittype'] = "select";
$col['editoptions'] = array("value"=>":;".$status_option);
$cols[] = $col;

$col = array();
$col['title'] = "類型";
$col['name'] = "OrgType";
$col['width'] = "65";
$col['editable'] = true;
$col['formatter'] = "select";
$col['edittype'] = "select";
$col['editoptions'] = array("value"=>":;".$OrgType_option);
$cols[] = $col;

$col = array();
$col['title'] = "居護";
$col['name'] = "homecare";
$col['width'] = "55";
$col['editable'] = true;
$col['formatter'] = "select";
$col['edittype'] = "select";
$col['editoptions'] = array("value"=>":;".$homecare_option);
$cols[] = $col;

$col = array();
$col['title'] = "Manipulate";
$col['name'] = "act";
$cols[] = $col;

$g->set_columns($cols);

// render grid
$out = $g->render("list1");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
<head>
	<link rel="stylesheet" type="text/css" media="screen" href="lib/js/themes/start/jquery-ui.custom.css"></link>	
	<link rel="stylesheet" type="text/css" media="screen" href="lib/js/jqgrid/css/ui.jqgrid.css"></link>	
	
	<script src="lib/js/jquery.min.js" type="text/javascript"></script>
	<script src="lib/js/jqgrid/js/i18n/grid.locale-en.js" type="text/javascript"></script>
	<script src="lib/js/jqgrid/js/jquery.jqGrid.min.js" type="text/javascript"></script>	
	<script src="lib/js/themes/jquery-ui.custom.min.js" type="text/javascript"></script>
<style>
* { font-size:12pt; }
</style>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<?php echo $out?>
</body>
</html>