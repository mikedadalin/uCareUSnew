<?php
session_start();

include("class/DB2.php");
include("class/DB.php");

$pid = (int) @$_GET['pid'];

$db1 = new DB2;
$db1->query("SELECT * FROM `userinfo` WHERE `OrgID`='".$_SESSION['nOrgID_lwj']."' ORDER BY `userID` ASC");
for ($i=0;$i<$db1->num_rows();$i++) {
	$r1 = $db1->fetch_assoc();
	if ($usertxt!="") { $usertxt .= ';'; }
	$usertxt .= $r1['userID'].':'.$r1['name'];
}

$db2 = new DB;
$db2->query("SELECT * FROM `labitem` ORDER BY `category` DESC");
for ($i=0;$i<$db2->num_rows();$i++) {
	$r2 = $db2->fetch_assoc();
	$newcate = $r2['category'];
	if ($labitemtxt!="") { $labitemtxt .= ';'; }
	if ($newcate!=$oldcate) { $labitemtxt .= '0:---'.$r2['category'].'---;'; }
	$labitemtxt .= $r2['id'].':'.$r2['name'];
	if ($r2['nickname']!="") { $labitemtxt .= ' ('.$r2['nickname'].')'; }
	$oldcate = $r2['category'];
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
$grid["caption"] = "檢驗數值輸入input inspection number";
$grid["autowidth"] = true;
$grid["add_options"] = array('width'=>'840');
$grid["edit_options"] = array('width'=>'840');
$grid["view_options"] = array('width'=>'840');

$grid["grouping"] = true; //  
$grid["groupingView"] = array(); 
$grid["groupingView"]["groupField"] = array("date"); // specify column name to group listing 
$grid["groupingView"]["groupColumnShow"] = array(false); // either show grouped column in list or not (default: true) 
$grid["groupingView"]["groupText"] = array("<b>{0} - {1} 個檢驗項目</b>"); // {0} is grouped value, {1} is count in group 
$grid["groupingView"]["groupOrder"] = array("desc"); // show group in asc or desc order 
$grid["groupingView"]["groupDataSorted"] = array(true); // show sorted data within group  
$grid["groupingView"]["groupCollapse"] = true; // Turn true to show group collapse (default: false)  
$grid["groupingView"]["showSummaryOnHide"] = false;

$g->set_options($grid);

// set database table for CRUD operations
$g->table = 'labpatient';
$g->select_command = "SELECT * FROM `labpatient` WHERE `patientID`='".$pid."'";

//some param
$col = array();
$col['title'] = "pid";
$col['name'] = "patientID";
$col['hidden'] = true;
$col['editable'] = true;
$col['edittype'] = "select";
$col['editoptions'] = array("defaultValue"=>$pid, "value"=>$pid.':'.$pid);
//$col["show"] = array("list"=>true, "add"=>true, "edit"=>true, "view"=>true);
$cols[] = $col;

$col = array();
$col['title'] = "Date";
$col['name'] = "date";
$col['editable'] = true;
$col["show"] = array("list"=>true, "add"=>true, "edit"=>true, "view"=>true);
$cols[] = $col;

$col = array();
$col['title'] = "項目item";
$col['name'] = "labID";
$col['editable'] = true;
$col["edittype"] = "select";
$col["editoptions"] = array("value"=>$labitemtxt);
$col["formatter"] = "select";
$col["show"] = array("list"=>true, "add"=>true, "edit"=>true, "view"=>true);
$cols[] = $col;

$col = array();
$col['title'] = "value";
$col['name'] = "value";
$col['editable'] = true;
$cols[] = $col;

$col = array();
$col['title'] = "輸入人員input staff";
$col['name'] = "Qfiller";
$col["editable"] = true;
$col["editrules"] = array("readonly"=>true);
$col["edittype"] = "select";
$col["editoptions"] = array("defaultValue"=>$_SESSION['ncareID_lwj'], "value"=>$usertxt);
$col["formatter"] = "select";
$col["show"] = array("list"=>true, "add"=>false, "edit"=>false, "view"=>false);
$cols[] = $col;

$col = array();
$col['title'] = "Manipulate";
$col['name'] = "act";
$cols[] = $col;

$g->set_columns($cols);

$e["js_on_load_complete"] = "grid_load"; 
$e["js_on_select_row"] = "grid_select";     
$g->set_events($e);

$g->set_actions(array(     
                        "add"=>true, // allow/disallow add 
                        "edit"=>true, // allow/disallow edit 
                        "delete"=>true, // allow/disallow delete 
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
<script> 
    function grid_load() 
    { 
        var grid = $('#list1'); 
        var rowids = grid.getDataIDs(); 
        var columnModels = grid.getGridParam().colModel; 

        // check each visible row 
        for (var i = 0; i < rowids.length; i++)  
        { 
            var rowid = rowids[i]; 
            var data = grid.getRowData(rowid); 

            if (data.Qfiller != '<?php echo $_SESSION['ncareID_lwj']; ?>' && data.Qfiller != "") // view only 
            {      
                jQuery("tr#"+rowid).addClass("not-editable-row");
				jQuery("tr#"+rowid+" td[aria-describedby$='_act']").html("-"); 
            } 
             
        } 
    } 

    function grid_select(id) 
    { 
        var grid = $('#list1'); 
        var rowid = grid.getGridParam('selrow'); 

        var data = grid.getRowData(rowid); 

        if (data.Qfiller != '<?php echo $_SESSION['ncareID_lwj']; ?>') // view only 
        {      
              jQuery("#edit_list1").addClass("ui-state-disabled"); 
              jQuery("#del_list1").addClass("ui-state-disabled"); 
        } 
        else 
        { 
            jQuery("#edit_list1").removeClass("ui-state-disabled"); 
            jQuery("#del_list1").removeClass("ui-state-disabled"); 
        } 
    } 
    </script> 
</body>
</html>