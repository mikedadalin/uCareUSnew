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

$glucoseRecord_option = "0:No;1:護紀";
$ContactPersonNo_option = "3:3";
$InsulinImage_option = "2:2";
$allowNotInCompany_option = "0:Lock;1:Unlock";
$medFormat_option = "1:1";
$receiptFormat_option = "1:1";
$HospNoLength_option = "6:6";
$autoPatNo_option = "0:Not Auto;1:Auto";

$g = new jqgrid();

// set few params
$grid["caption"] = "System Setting";
$grid["autowidth"] = false;
$g->set_options($grid);

// set database table for CRUD operations
$g->table = 'system_setting';

//some param
$col = array();
$col['title'] = "OrgID";
$col['name'] = "OrgID";
$col['width'] = "80";
$col['editable'] = true;
$cols[] = $col;

$col = array();
$col['title'] = "血糖"; //代入護紀
$col['name'] = "glucoseRecord";
$col['width'] = "50";
$col['editable'] = true;
$col['formatter'] = "select";
$col['edittype'] = "select";
$col['editoptions'] = array("value"=>":;".$glucoseRecord_option);
$cols[] = $col;

$col = array();
$col['title'] = "聯絡"; //聯絡人(人數)
$col['name'] = "ContactPersonNo";
$col['width'] = "50";
$col['editable'] = true;
$col['formatter'] = "select";
$col['edittype'] = "select";
$col['editoptions'] = array("value"=>":;".$ContactPersonNo_option);
$cols[] = $col;

$col = array();
$col['title'] = "胰島"; //格式
$col['name'] = "InsulinImage";
$col['width'] = "50";
$col['editable'] = true;
$col['formatter'] = "select";
$col['edittype'] = "select";
$col['editoptions'] = array("value"=>":;".$InsulinImage_option);
$cols[] = $col;

$col = array();
$col['title'] = "IP Lock";
$col['name'] = "allowNotInCompany";
$col['width'] = "80";
$col['editable'] = true;
$col['formatter'] = "select";
$col['edittype'] = "select";
$col['editoptions'] = array("value"=>":;".$allowNotInCompany_option);
$cols[] = $col;

$col = array();
$col['title'] = "藥單"; //格式
$col['name'] = "medFormat";
$col['width'] = "50";
$col['editable'] = true;
$col['formatter'] = "select";
$col['edittype'] = "select";
$col['editoptions'] = array("value"=>":;".$medFormat_option);
$cols[] = $col;

$col = array();
$col['title'] = "收據"; //格式
$col['name'] = "receiptFormat";
$col['width'] = "50";
$col['editable'] = true;
$col['formatter'] = "select";
$col['edittype'] = "select";
$col['editoptions'] = array("value"=>":;".$receiptFormat_option);
$cols[] = $col;

$col = array();
$col['title'] = "機構";
$col['name'] = "orgTitle";
$col['editable'] = true;
$cols[] = $col;

$col = array();
$col['title'] = "Contact";
$col['name'] = "orgPerson";
$col['editable'] = true;
$cols[] = $col;

$col = array();
$col['title'] = "Address";
$col['name'] = "orgAddress";
$col['editable'] = true;
$cols[] = $col;

$col = array();
$col['title'] = "機構電話";
$col['name'] = "orgTel";
$col['editable'] = true;
$cols[] = $col;

$col = array();
$col['title'] = "GovNo";
$col['name'] = "orgGovNo";
$col['editable'] = true;
$cols[] = $col;

$col = array();
$col['title'] = "NPI";
$col['name'] = "NPI";
$col['editable'] = true;
$cols[] = $col;

$col = array();
$col['title'] = "CCN";
$col['name'] = "CCN";
$col['editable'] = true;
$cols[] = $col;

$col = array();
$col['title'] = "SPN";
$col['name'] = "SPN";
$col['editable'] = true;
$cols[] = $col;

$col = array();
$col['title'] = "HNL"; //HospNo長度
$col['name'] = "HospNoLength";
$col['width'] = "50";
$col['editable'] = true;
$col['formatter'] = "select";
$col['edittype'] = "select";
$col['editoptions'] = array("value"=>":;".$HospNoLength_option);
$cols[] = $col;

$col = array();
$col['title'] = "人日";
$col['name'] = "autoPatNo";
$col['width'] = "90";
$col['editable'] = true;
$col['formatter'] = "select";
$col['edittype'] = "select";
$col['editoptions'] = array("value"=>":;".$autoPatNo_option);
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