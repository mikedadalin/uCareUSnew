<?php
/**
 * PHP Grid Component
 *
 * @author Abu Ghufran <gridphp@gmail.com> - http://www.phpgrid.org
 * @version 1.5.2
 * @license: see license.txt included in package
 */

// include db config
include_once("config.php");
include_once("class/DB.php");

// set up DB
mysql_connect(PHPGRID_DBHOST, PHPGRID_DBUSER, PHPGRID_DBPASS);
mysql_select_db(PHPGRID_DBNAME);

// include and create object
include(PHPGRID_LIBPATH."inc/jqgrid_dist.php");

session_start();

$dbU = new DB;
$dbU->query("SELECT * FROM `formmaker_list`");
$order_option = '';
$number = 1;
for ($iU=0;$iU<$dbU->num_rows();$iU++) {
	$order_option .= $number.':'.$number;
	if(($iU+1)!=$dbU->num_rows()){ $order_option .= ';';}
	$number++;
}

$g = new jqgrid();

// set few params
$grid["caption"] = "From Order";
$grid["autowidth"] = false;
$g->set_options($grid);

// set database table for CRUD operations
$g->table = 'formmaker_order';

//some param
$col = array();
$col['title'] = "No.";
$col['name'] = "no";
$col['width'] = "60";
$cols[] = $col;

$col = array();
$col['title'] = "Category ID";
$col['name'] = "CategoryID";
$cols[] = $col;

$col = array();
$col['title'] = "Category";
$col['name'] = "CategoryName";
$cols[] = $col;

$col = array();
$col['title'] = "FormID ID#";
$col['name'] = "formID";
$cols[] = $col;

$col = array();
$col['title'] = "Form";
$col['name'] = "FormName";
$cols[] = $col;

$col = array();
$col['title'] = "Order";
$col['name'] = "Show_Order";
$col['width'] = "80";
$col['editable'] = true;
$col['formatter'] = "select";
$col['edittype'] = "select";
$col['editoptions'] = array("value"=>":;".$order_option);
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