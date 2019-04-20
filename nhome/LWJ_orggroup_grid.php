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

$db = new DB2;
$db->query("SELECT `OrgID` FROM `orginfo` WHERE `status`!='0'");
for($i=0;$i<$db->num_rows();$i++){
	$r = $db->fetch_assoc();
	if($OrgID_option!=""){ $OrgID_option .= ";"; }
	$OrgID_option .= $r['OrgID'].":".$r['OrgID'];
}

$g = new jqgrid();

// set few params
$grid["caption"] = "Group";
$grid["autowidth"] = false;
$g->set_options($grid);

// set database table for CRUD operations
$g->table = 'orggroup';

//some param
$col = array();
$col['title'] = "no";
$col['name'] = "no";
$col['width'] = "80";
$col['editable'] = false;
$cols[] = $col;

$col = array();
$col['title'] = "GroupID";
$col['name'] = "GroupID";
$col['editable'] = true;
$cols[] = $col;

$col = array();
$col['title'] = "OrgID";
$col['name'] = "OrgID";
$col['editable'] = true;
$col['formatter'] = "select";
$col['edittype'] = "select";
$col['editoptions'] = array("value"=>":;".$OrgID_option);
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