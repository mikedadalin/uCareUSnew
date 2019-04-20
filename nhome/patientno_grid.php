<?php
session_start();

include("class/DB2.php");
$db1 = new DB2;
$db1->query("SELECT * FROM `userinfo` WHERE `OrgID`='".$_SESSION['nOrgID_lwj']."' ORDER BY `userID` ASC");
for ($i=0;$i<$db1->num_rows();$i++) {
	$r1 = $db1->fetch_assoc();
	if ($usertxt!="") { $usertxt .= ';'; }
	$usertxt .= $r1['userID'].':'.$r1['name'];
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
$grid["caption"] = "每日院民人數輸入daily visiting resident(patient) input";
$grid["autowidth"] = true;
$grid["add_options"] = array('width'=>'840');
$grid["edit_options"] = array('width'=>'840');
$grid["view_options"] = array('width'=>'840');
$grid["sortname"] = 'date'; // by default sort grid by this field 
$grid["sortorder"] = "DESC";

$g->set_options($grid);

// set database table for CRUD operations
$g->table = 'dailypatientno';

//some param
$col = array();
$col['title'] = "Date";
$col['width'] = "140";
$col['name'] = "date";
$col['editable'] = true;
$col["formatter"] = "date"; 
$col["formatoptions"] = array("srcformat"=>'Y-m-d',"newformat"=>'Y-m-d');
$cols[] = $col;

$col = array();
$col['title'] = "新入住人數number of people new check-in";
$col['name'] = "newpat";
$col['width'] = "180";
$col["editable"] = true;
$cols[] = $col;

$col = array();
$col['title'] = "人數number of people";
$col['name'] = "no";
$col['width'] = "180";
$col["editable"] = true;
$cols[] = $col;

$col = array();
$col['title'] = "退住人數number of people check-out";
$col['name'] = "outpat";
$col['width'] = "180";
$col["editable"] = true;
$cols[] = $col;

$col = array();
$col['title'] = "發佈者announce by";
$col['name'] = "Qfiller";
$col['width'] = "60";
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