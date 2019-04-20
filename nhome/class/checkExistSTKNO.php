<?php
include("DB.php");
$STKNO = mysql_escape_string($_POST['STKNO']);
$db = new DB;
$db->query("SELECT * FROM `arkstock` WHERE `STK_NO`='".$STKNO."'");
if ($db->num_rows()==0) { echo "OK"; } else { echo "EXISTED"; }
//echo $STKNO;
?>