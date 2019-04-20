<?php
session_start();
include("lwj/lwj.php");
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
	/*if ($r1['Enddate1']==NULL) {
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
	}*/
	if ($ForeignEmpTxt!=NULL) { $ForeignEmpTxt .= ';'; }
	$ForeignEmpTxt .= ($r1['foreignID']+0).':'.$r1['cNickname'];
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
$grid["caption"] = "個人核准函管理 Approval Letter Manage";
$grid["autowidth"] = true;
$grid["add_options"] = array('width'=>'840');
$grid["edit_options"] = array('width'=>'840');
$grid["view_options"] = array('width'=>'840');

$g->set_options($grid);

// set database table for CRUD operations
$g->table = 'foreign_personal_approval';

//some param
$col = array();
$col['title'] = "Full name";
$col['name'] = "foreignID";
$col['width'] = "90";
$col["editable"] = true;
$col["edittype"] = "select";
$col["editoptions"] = array("value"=>$ForeignEmpTxt);
$col["formatter"] = "select";
$cols[] = $col;

$col = array();
$col['title'] = "核准函編號Approval Letter Serial number";
$col['name'] = "AppID";
$col["editable"] = true;
$col['width'] = "140";
$cols[] = $col;

$col = array();
$col['title'] = "核准函日期Approval Letter date";
$col['name'] = "AppDate";
$col['width'] = "140";
$col['editable'] = true;
$col["formatter"] = "date"; 
$col["formatoptions"] = array("srcformat"=>'Y/m/d',"newformat"=>'Y/m/d');
$cols[] = $col;

$col = array();
$col['title'] = "居留展延Extension of residency";
$col['name'] = "StayExtDate";
$col['width'] = "140";
$col['editable'] = true;
$col["formatter"] = "date"; 
$col["formatoptions"] = array("srcformat"=>'Y/m/d',"newformat"=>'Y/m/d');
$cols[] = $col;

$col = array();
$col['title'] = "Note";
$col['name'] = "StayExtMemo";
$col["editable"] = true;
$col['width'] = "70";
$cols[] = $col;

$col = array();
$col['title'] = "辦理日execute date";
$col['name'] = "StayExtDate";
$col['width'] = "140";
$col['editable'] = true;
$col["formatter"] = "date"; 
$col["formatoptions"] = array("srcformat"=>'Y/m/d',"newformat"=>'Y/m/d');
$cols[] = $col;

$col = array();
$col['title'] = "到職日appointment duty star date)";
$col['name'] = "InDate";
$col['width'] = "140";
$col['editable'] = true;
$col["formatter"] = "date"; 
$col["formatoptions"] = array("srcformat"=>'Y/m/d',"newformat"=>'Y/m/d');
$cols[] = $col;

$col = array();
$col['title'] = "護照號碼passport number";
$col['name'] = "PassportNo";
$col["editable"] = true;
$col['width'] = "140";
$cols[] = $col;

$col = array();
$col['title'] = "Expire date expire date";
$col['name'] = "PassportExpireDate";
$col['width'] = "140";
$col['editable'] = true;
$col["formatter"] = "date"; 
$col["formatoptions"] = array("srcformat"=>'Y/m/d',"newformat"=>'Y/m/d');
$cols[] = $col;

$col = array();
$col['title'] = "居留證residence permit";
$col['name'] = "ResidentCardNo";
$col["editable"] = true;
$col['width'] = "140";
$cols[] = $col;

$col = array();
$col['title'] = "到期日expire date";
$col['name'] = "ResidentCardDate";
$col['width'] = "140";
$col['editable'] = true;
$col["formatter"] = "date"; 
$col["formatoptions"] = array("srcformat"=>'Y/m/d',"newformat"=>'Y/m/d');
$cols[] = $col;

$col = array();
$col['title'] = "應辦日date should execute";
$col['name'] = "ResidentCardAppDate";
$col['width'] = "140";
$col['editable'] = true;
$col["formatter"] = "date"; 
$col["formatoptions"] = array("srcformat"=>'Y/m/d',"newformat"=>'Y/m/d');
$cols[] = $col;

$col = array();
$col['title'] = "Note";
$col['name'] = "ResidentCardMemo";
$col["editable"] = true;
$col['width'] = "70";
$cols[] = $col;

$col = array();
$col['title'] = "辦理日execute date";
$col['name'] = "ResidentCardDoneDate";
$col['width'] = "140";
$col['editable'] = true;
$col["formatter"] = "date"; 
$col["formatoptions"] = array("srcformat"=>'Y/m/d',"newformat"=>'Y/m/d');
$cols[] = $col;

$col = array();
$col['title'] = "體檢日examination date";
$col['name'] = "PhyExamDate1";
$col['width'] = "140";
$col['editable'] = true;
$col["formatter"] = "date"; 
$col["formatoptions"] = array("srcformat"=>'Y/m/d',"newformat"=>'Y/m/d');
$cols[] = $col;

$col = array();
$col['title'] = "辦理日execute date";
$col['name'] = "PhyExamDate2";
$col['width'] = "140";
$col['editable'] = true;
$col["formatter"] = "date"; 
$col["formatoptions"] = array("srcformat"=>'Y/m/d',"newformat"=>'Y/m/d');
$cols[] = $col;

$col = array();
$col['title'] = "核備日approved date";
$col['name'] = "CheckDate";
$col['width'] = "140";
$col['editable'] = true;
$col["formatter"] = "date"; 
$col["formatoptions"] = array("srcformat"=>'Y/m/d',"newformat"=>'Y/m/d');
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
* { font-size:10pt; }
</style>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<?php echo $out?>
</body>
</html>