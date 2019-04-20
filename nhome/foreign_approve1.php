<?php
session_start();

if ($_SESSION['ncareID_lwj']==NULL) {
	$QR_URL = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$QR_URL = str_replace("&","_TWNo1_",$QR_URL);
	echo "<script>alert('Please log in again!'); window.location.href='logout.php?QR_URL=".$QR_URL."';</script>"; 
}

include("class/DB.php");
$db1 = new DB;
$db1->query("SELECT * FROM `foreignemployer`");
$ForeignEmpTxt = "0:";
for ($i=0;$i<$db1->num_rows();$i++) {
	$r1 = $db1->fetch_assoc();
	if ($r1['Enddate1']==NULL) {
		if ($ForeignEmpTxt!=NULL) { $ForeignEmpTxt .= ';'; }
		$ForeignEmpTxt .= ($r1['foreignID']+0).':'.$r1['cNickname'];
	} elseif ($r1['Startdate2']!=NULL && $r1['Enddate2']==NULL) {
		if ($ForeignEmpTxt!=NULL) { $ForeignEmpTxt .= ';'; }
		$ForeignEmpTxt .= ($r1['foreignID']+0).':'.$r1['cNickname'];
	} elseif ($r1['Startdate3']!=NULL && $r1['Enddate3']==NULL) {
		if ($ForeignEmpTxt!=NULL) { $ForeignEmpTxt .= ';'; }
		$ForeignEmpTxt .= ($r1['foreignID']+0).':'.$r1['cNickname'];
	} elseif ($r1['Startdate4']!=NULL && $r1['Enddate4']==NULL) {
		if ($ForeignEmpTxt!=NULL) { $ForeignEmpTxt .= ';'; }
		$ForeignEmpTxt .= ($r1['foreignID']+0).':'.$r1['cNickname'];
	} elseif ($r1['Startdate5']!=NULL && $r1['Enddate5']==NULL) {
		if ($ForeignEmpTxt!=NULL) { $ForeignEmpTxt .= ';'; }
		$ForeignEmpTxt .= ($r1['foreignID']+0).':'.$r1['cNickname'];
	}
}

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
$grid["caption"] = "Approval Letter Manage";
$grid["autowidth"] = false;
$grid["add_options"] = array('width'=>'840');
$grid["edit_options"] = array('width'=>'840');
$grid["view_options"] = array('width'=>'840');

$g->set_options($grid);

// set database table for CRUD operations
$g->table = 'foreign_approval1';

//some param
$col = array();
$col['title'] = "Approval Letter Serial number";
$col['name'] = "AppID";
$col["editable"] = true;
$col['width'] = "140";
$cols[] = $col;

$col = array();
$col['title'] = "Update Number";
$col['name'] = "App_renew_ID";
$col["editable"] = true;
$col['width'] = "140";
$cols[] = $col;

$col = array();
$col['title'] = "Date";
$col['name'] = "AppDate";
$col['width'] = "140";
$col['editable'] = true;
$col["formatter"] = "date"; 
$col["formatoptions"] = array("srcformat"=>'Y/m/d',"newformat"=>'Y/m/d');
$cols[] = $col;

$col = array();
$col['title'] = "People approved";
$col['name'] = "AppNo1";
$col["editable"] = true;
$col['width'] = "120";
$cols[] = $col;

$col = array();
$col['title'] = "Manpower applied";
$col['name'] = "AppNo";
$col["editable"] = true;
$col['width'] = "120";
$cols[] = $col;

$col = array();
$col['title'] = "Foreign worker 1";
$col['name'] = "ForeignID_1";
$col['width'] = "90";
$col["editable"] = true;
$col["edittype"] = "select";
$col["editoptions"] = array("value"=>$ForeignEmpTxt);
$col["formatter"] = "select";
$cols[] = $col;

$col = array();
$col['title'] = "Foreign worker 2";
$col['name'] = "ForeignID_2";
$col['width'] = "90";
$col["editable"] = true;
$col["edittype"] = "select";
$col["editoptions"] = array("value"=>$ForeignEmpTxt);
$col["formatter"] = "select";
$cols[] = $col;

$col = array();
$col['title'] = "Foreign worker 3";
$col['name'] = "ForeignID_3";
$col['width'] = "90";
$col["editable"] = true;
$col["edittype"] = "select";
$col["editoptions"] = array("value"=>$ForeignEmpTxt);
$col["formatter"] = "select";
$cols[] = $col;

$col = array();
$col['title'] = "Foreign worker 4";
$col['name'] = "ForeignID_4";
$col['width'] = "90";
$col["editable"] = true;
$col["edittype"] = "select";
$col["editoptions"] = array("value"=>$ForeignEmpTxt);
$col["formatter"] = "select";
$cols[] = $col;

$col = array();
$col['title'] = "Foreign worker 5";
$col['name'] = "ForeignID_5";
$col['width'] = "90";
$col["editable"] = true;
$col["edittype"] = "select";
$col["editoptions"] = array("value"=>$ForeignEmpTxt);
$col["formatter"] = "select";
$cols[] = $col;

$col = array();
$col['title'] = "Note";
$col['name'] = "Memo";
$col["editable"] = true;
$col['editoptions'] = array("size"=>"80");
$col['width'] = "240";
$cols[] = $col;

$g->set_columns($cols);

$g->set_actions(array(     
                        "add"=>true, // allow/disallow add 
                        "edit"=>true, // allow/disallow edit 
                        "delete"=>true, // allow/disallow delete 
                        "view"=>true, // allow/disallow view
						"export"=>false,  // allow export
                        "rowactions"=>false // show/hide row wise edit/del/save option
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
/* { font-size:12pt; }*/
</style>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<?php echo $out?>
</body>
</html>