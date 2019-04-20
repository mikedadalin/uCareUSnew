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
$arrGroup = array("", "Administration", "Nursing", "Domestic CNA", "Pharmacy", "Social worker", "Physiotherapist", "Nutritionist", "Public work", "General manage", "Foreign CNA");
foreach ($arrGroup as $k1=>$v1) {
	if($group_option!=""){ $group_option .= ";"; }
	$group_option .= $k1.":".$v1;
}
$level_option = "1:一般;4:組長;5:主管";
$active_option = "0:關閉;1:啟動";

$g = new jqgrid();

// set few params
$grid["caption"] = "User";
$grid["autowidth"] = false;
$g->set_options($grid);

// set database table for CRUD operations
$g->table = 'userinfo';

//some param
$col = array();
$col['title'] = "userID";
$col['name'] = "userID";
$col['width'] = "300";
$col['editable'] = false;
$cols[] = $col;

$col = array();
$col['title'] = "OrgID";
$col['name'] = "OrgID";
$col['width'] = "100";
$col['editable'] = true;
$col['formatter'] = "select";
$col['edittype'] = "select";
$col['editoptions'] = array("value"=>":;".$OrgID_option);
$cols[] = $col;

$col = array();
$col['title'] = "name";
$col['name'] = "name";
$col['width'] = "280";
$col['editable'] = true;
$cols[] = $col;

$col = array();
$col['title'] = "position";
$col['name'] = "position";
$col['editable'] = true;
$cols[] = $col;

$col = array();
$col['title'] = "email";
$col['name'] = "email";
$col['editable'] = true;
$cols[] = $col;

$col = array();
$col['title'] = "S";
$col['name'] = "psw";
$col['editable'] = true;
$cols[] = $col;

$col = array();
$col['title'] = "group";
$col['name'] = "group";
$col['editable'] = false;
$col['formatter'] = "select";
$col['edittype'] = "select";
$col['editoptions'] = array("value"=>":;".$group_option);
$cols[] = $col;

$col = array();
$col['title'] = "level";
$col['name'] = "level";
$col['width'] = "60";
$col['editable'] = true;
$col['formatter'] = "select";
$col['edittype'] = "select";
$col['editoptions'] = array("value"=>":;".$level_option);
$cols[] = $col;

$col = array();
$col['title'] = "active";
$col['name'] = "active";
$col['width'] = "60";
$col['editable'] = true;
$col['formatter'] = "select";
$col['edittype'] = "select";
$col['editoptions'] = array("value"=>":;".$active_option);
$cols[] = $col;

$col = array();
$col['title'] = "rfidno";
$col['name'] = "rfidno";
$col['editable'] = true;
$cols[] = $col;

$col = array();
$col['title'] = "V";
$col['name'] = "VN";
$col['editable'] = true;
$cols[] = $col;

$col = array();
$col['title'] = "EmpID";
$col['name'] = "EmpID";
$col['width'] = "80";
$col['editable'] = false;
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