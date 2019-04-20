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
include_once("class/DB2.php");

// set up DB
mysql_connect(PHPGRID_DBHOST, PHPGRID_DBUSER, PHPGRID_DBPASS);
mysql_select_db(PHPGRID_DBNAME);

// include and create object
include(PHPGRID_LIBPATH."inc/jqgrid_dist.php");

session_start();

$dbU = new DB2;
$dbU->query("SELECT * FROM `userinfo` WHERE `OrgID`='".$_SESSION['nOrgID_lwj']."' AND `active`='1'");
for ($iU=0;$iU<$dbU->num_rows();$iU++) {
	$rU = $dbU->fetch_assoc();
	$option .= $rU['userID'].':'.$rU['name'];
	if(($iU+1)!=$dbU->num_rows()){ $option .= ';';}
}

$g = new jqgrid();

// set few params
$grid["caption"] = "Shift group";
$grid["autowidth"] = false;
$g->set_options($grid);

// set database table for CRUD operations
$g->table = 'shift_group';

//some param
$col = array();
$col['title'] = "ID #";
$col['name'] = "GroupID";
$col['width'] = "60";
$cols[] = $col;

$col = array();
$col['title'] = "Name";
$col['name'] = "GroupName";
$col['editable'] = true;
$cols[] = $col;

$col = array();
$col['title'] = "Group Leader";
$col['name'] = "GroupLeader";
$col['editable'] = true;
$col['formatter'] = "select";
$col['edittype'] = "select";
$col['editoptions'] = array("value"=>":;".$option);
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