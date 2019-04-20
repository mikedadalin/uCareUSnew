<?php
include("DB.php");
$p_no = mysql_escape_string($_POST['p_no']);
$db = new DB;
$db->query("SELECT * FROM `property` WHERE `p_no`='".$p_no."'");
if ($db->num_rows()==0) { echo "OK"; } else { echo "EXISTED"; }
//echo $STKNO;
?>