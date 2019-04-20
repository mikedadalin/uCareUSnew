<?php
include("DB.php");
include("DB2.php");
include("function.php");

$stock = $_POST['NewStock'];
$arrStock = explode(",",$_POST['mid']);
$newStock = $_POST['NewStock'];
$fmark = $_POST['fmark'];
//print_r($arrStock);


$db1 = new DB;
$db1->query("INSERT INTO `stockmove` (`STK_NO`,`old_StockID`,`new_StockID`,`qty`,`amt`,`Fmark`,`userID`) VALUES ('".$arrStock[1]."', '".$arrStock[0]."', '".$newStock."', '".$arrStock[4]."', '".$arrStock[5]."', '".$fmark."', '".$_SESSION['ncareID_lwj']."')");

$arrDate = chkDate(date("Y/m/d"));
$strSTK = " and `STK_YEAR`='".$arrDate['year']."' and STK_MONTH='".$arrDate['month']."'";

$STK_DB = new DB;
$STK_DB->query("SELECT * FROM `stockform` WHERE `StockID`='".$newStock."' and `STK_NO`=".$arrStock[1]." ".$strSTK."");
//更新庫存資料update storage info
	if($STK_DB->num_rows()>0){
		$strQry = "UPDATE `stockform` SET ";
		$strQry .="`IN_STK` = `IN_STK` + ".$arrStock[4].", ";
		$strQry .="`IN_PRC` = `IN_PRC` + ".$arrStock[5].", ";
		$strQry .="`uDate`='".date("Y-m-d H:i:s")."', ";
		$strQry .="`userID`='".$_SESSION['ncareID_lwj']."' ";
		$strQry .=" WHERE StockID='".$newStock."' and STK_NO=".$arrStock[1]." ".$strSTK."";
		$UPDATE_DB = new DB;		
		$UPDATE_DB->query($strQry);

	}else{			  
		$strQry ="INSERT INTO `stockform` (`StockID`,`STK_NO`,`Title`,`IN_STK`,`IN_PRC`,`STK_YEAR`,`STK_MONTH`,`userID`";
		$strQry .=") VALUES (";
		$strQry .=" '".$newStock."',";			 //庫位storage inventory location
		$strQry .=" '".$arrStock[1]."',"; 		 //Product serial number
		$strQry .=" '".STK_NAME($arrStock[1])."',"; //product name
		$strQry .=" '".$arrStock[4]."',";		 //入庫量perchage/input quantity to storage
		$strQry .=" '".$arrStock[5]."',";		 //價格price
		$strQry .=" '".$arrDate['year']."',";			//Year
		$strQry .=" '".$arrDate['month']."',";			//月
		$strQry .=" '".$_SESSION['ncareID_lwj']."'"; //建立人員established by staff
		$strQry .="  )";		
		$INSERT_DB = new DB;				
		$INSERT_DB->query($strQry);
	}
	
	  $strQry = "UPDATE `stockform` SET ";
	  $strQry .="`OUT_STK` = OUT_STK+".$arrStock[4].", ";
	  $strQry .="`OUT_PRC` = OUT_PRC+".$arrStock[5].", ";
	  $strQry .="`uDate`='".date("Y-m-d H:i:s")."', ";
	  $strQry .="`userID`='".$_SESSION['ncareID_lwj']."' ";
	  $strQry .=" WHERE StockID='".$arrStock[0]."' and STK_NO=".$arrStock[1]." ".$strSTK."";
	  $UPDATE_DB = new DB;
	  $UPDATE_DB->query($strQry);
	

?>