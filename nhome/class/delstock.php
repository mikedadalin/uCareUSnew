<?php
include("DB.php");
include("function.php");


echo "@@";
$db1 = new DB;
//$db1->query("INSERT INTO `stockmove` (`STK_NO`,`old_StockID`,`new_StockID`,`qty`,`amt`,`Fmark`,`userID`) VALUES ('".$arrStock[1]."', '".$arrStock[0]."', '".$newStock."', '".$arrStock[4]."', '".$arrStock[5]."', '".$fmark."', '".$_SESSION['ncareID_lwj']."')");

?>