<?php
session_start();
include("lwj/lwj.php");
/**
 * PHP Grid Component
 *
 * @author Abu Ghufran <gridphp@gmail.com> - http://www.phpgrid.org
 * @version 1.5.2
 * @license: see license.txt included in package
 */

// include db config
include_once("config.php");

// set up DB
mysql_connect(PHPGRID_DBHOST, PHPGRID_DBUSER, PHPGRID_DBPASS);
mysql_select_db(PHPGRID_DBNAME);

// include and create object
include(PHPGRID_LIBPATH."inc/jqgrid_dist.php");

session_start();

$g = new jqgrid();

// set few params
$grid["caption"] = "Statistics list management";
$grid["autowidth"] = true;
$grid["add_options"] = array('width'=>'840');
$grid["edit_options"] = array('width'=>'840');
$grid["view_options"] = array('width'=>'840');

$g->set_options($grid);

// set database table for CRUD operations
$g->table = 'patient';

//some param
$col = array();
$col['title'] = "care ID#";
$col['name'] = "HospNo";
$col['hidden'] = false;
$col['editable'] = false;
$cols[] = $col;

$col=array();
$col['title'] = "First name";
$col['name'] = "Name1";
$col['editable'] = false;
$cols[] = $col;

$col=array();
$col['title'] = "Middle initial";
$col['name'] = "Name2";
$col['editable'] = false;
$cols[] = $col;

$col=array();
$col['title'] = "Last name";
$col['name'] = "Name3";
$col['editable'] = false;
$cols[] = $col;

$col=array();
$col['title'] = "Suffix";
$col['name'] = "Name4";
$col['editable'] = false;
$cols[] = $col;


$col = array();
$col['title'] = "Whether included in the statistics ";
$col['name'] = "instat";
$col['width'] = "40";
$col["editable"] = true;
$col["edittype"] = "checkbox";
$col["editoptions"] = array("value"=>"1:0");
$col["formatter"] = "checkbox";
$col["show"] = array("list"=>true, "add"=>false, "edit"=>true, "view"=>true);
$cols[] = $col;

$col = array();
$col['title'] = "Manipulate";
$col['name'] = "act";
$cols[] = $col;

$g->set_columns($cols);

$g->set_actions(array(     
                        "add"=>false, // allow/disallow add 
                        "edit"=>true, // allow/disallow edit 
                        "delete"=>false, // allow/disallow delete 
                        "view"=>true, // allow/disallow view
						"export"=>false,  // allow export
                        "rowactions"=>true // show/hide row wise edit/del/save option
                    )  
                ); 
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