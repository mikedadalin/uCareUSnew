<?php 
if ((int) @$_POST['oldCount1'] <> ""){
$IN = $_POST['IN_firmStockID'];	
$UPDATE_DB = new DB;	
$OrdDB = new DB;
$OrdDB1 = new DB;
$OrdDB2 = new DB;
$STK_DB = new DB;
$STK_DB1 = new DB;
$INSERT_DB = new DB;

if($type =="IC"){
	$STK = "IN_STK";
	$PRC = "IN_PRC";
}elseif($type =='A'){
	$STK = "ADJ_STK";
	$PRC = "ADJ_PRC";			  
}else{
	$STK = "OUT_STK";
	$PRC = "OUT_PRC";
}
$arrDateFunction = chkDate(($STKDATE==""?$_POST['STK_Date']:$STKDATE));
$strSTK = " and `STK_YEAR`='".$arrDateFunction['year']."' and STK_MONTH='".$arrDateFunction['month']."'";  

  for ($i=1;$i<=$_POST['oldCount1'];$i++) {
	  
	  if ($_POST['oldSTK_NO'.$i]==NULL) {
		  $strQry = "SELECT * FROM `".$subModule."` WHERE type='".$type."' and ".$strModule."ID='".$firmstockID."' and infoOrd=".$i." and `STK_DATE`='".$STKDATE."'";
		  $STK_DB->query($strQry);
		  if ($STK_DB->num_rows()>0) {			  
			  $rs = $STK_DB->fetch_assoc();	
			  //扣庫存總表
			  /*$strQry = "UPDATE `stock` SET ";
			  $strQry .="`StockSum`=StockSum-".$rs['QTY'].", ";
			  $strQry .="`stockAMT`=stockAMT-".$rs['QTY']*$rs['Price'].", ";
			  $strQry .="`uDate`='".date("Y-m-d H:i:s")."', ";
			  $strQry .="`userID`='".$_SESSION['ncareID_lwj']."' ";
			  $strQry .=" WHERE StockID='".$rs['StockID']."' and STK_NO=".$rs['STK_NO']."";
			  $UPDATE_DB->query($strQry);	*/
			  
			  //寫入庫存進出表write into storage In/Output list
			  $strQry = "UPDATE `stockform` SET ";
			  $strQry .="`".$STK."`=".$STK."-".$rs['QTY'].", ";
			  $strQry .="`".$PRC."`=".$PRC."-".$rs['QTY']*$rs['Price'].", ";
			  $strQry .="`uDate`='".date("Y-m-d H:i:s")."', ";
			  $strQry .="`userID`='".$_SESSION['ncareID_lwj']."' ";
			  $strQry .=" WHERE StockID='".$rs['StockID']."' and STK_NO=".$rs['STK_NO']." ".$strSTK."";
			  $UPDATE_DB->query($strQry);
			  
			  //delete DB					  
			  $strQry = "DELETE FROM `".$subModule."` ";
			  $strQry .=" WHERE type='".$type."' and ".$strModule."ID='".$firmstockID."' and infoOrd=".$i."";
			  $UPDATE_DB->query($strQry);
		  }
		  
	  }else {	
	  	  if ( $_POST['oldSTOCK_INFO_NAME'.$i] <> ''){
		  //$strSTK = " and `STK_YEAR`='".date("Y")."' and STK_MONTH='".date("m")."'";
		  $STK_DB->query("SELECT * FROM `".$subModule."` WHERE type='".$type."' and ".$strModule."ID='".$firmstockID."' and infoOrd=".$i." AND `STK_DATE`='".mysql_escape_string($_POST['STK_Date'])."'");
		  
		  if($STK_DB->num_rows()>0){
			  $rs = $STK_DB->fetch_assoc();
			  if($rs['StockID'] == $_POST['oldSTOCK_INFO'.$i] && $rs['STK_NO'] == $_POST['oldSTK_NO'.$i]){  //產品與庫位相同			  
			  		$old = $rs['QTY'] * $rs['Price'] ;
					$new = ($_POST['olddQTY'.$i] * $_POST['oldIN_PRC'.$i])-$old;
					
			  		$tmpQTY= $_POST['olddQTY'.$i] - $rs['QTY'];
					
					$count = "+";
			      //更新庫存總表
				 /* $strQry = "UPDATE `stock` SET ";
				  $strQry .="`StockSum`=StockSum".$count.$tmpQTY.", ";
				  $strQry .="`stockAMT`=stockAMT".$count.$new.", ";
				  $strQry .="`uDate`='".date("Y-m-d H:i:s")."', ";
				  $strQry .="`userID`='".$_SESSION['ncareID_lwj']."' ";
				  $strQry .=" WHERE StockID='".$rs['StockID']."' and STK_NO=".$rs['STK_NO']."";
			  	  $UPDATE_DB->query($strQry);*/
					  
				  //寫入庫存進出表write into storage In/Output list				  
				  $strQry = "UPDATE `stockform` SET ";
				  $strQry .="`".$STK."`=".$STK.$count.$tmpQTY.", ";
				  $strQry .="`".$PRC."`=".$PRC.$count.$new.", ";
				  $strQry .="`uDate`='".date("Y-m-d H:i:s")."', ";
				  $strQry .="`userID`='".$_SESSION['ncareID_lwj']."' ";
				  $strQry .=" WHERE StockID='".$rs['StockID']."' and STK_NO=".$rs['STK_NO']." ".$strSTK."";
				  $UPDATE_DB->query($strQry);
			  }else{	
				  //先扣除原本庫存
				  /*$strQry = "UPDATE `stock` SET ";
				  $strQry .="`StockSum`=StockSum-".$rs['QTY'].", ";
				  $strQry .="`stockAMT`=stockAMT-".$rs['QTY'] * $rs['Price'].", ";
				  $strQry .="`uDate`='".date("Y-m-d H:i:s")."', ";
				  $strQry .="`userID`='".$_SESSION['ncareID_lwj']."' ";
				  $strQry .=" WHERE StockID='".$rs['StockID']."' and STK_NO=".$rs['STK_NO']."";
				  $UPDATE_DB->query($strQry);			  
				  
				  //查欲詢修改是否有資料search for if the data exist
				  $db->query("SELECT * FROM `stock` WHERE `StockID`='".mysql_escape_string($_POST['oldSTOCK_INFO'.$i])."' and `STK_NO`=".$_POST['oldSTK_NO'.$i]."");
				  //Yes
				  if($db->num_rows()>0){					  
					  //直接將數量與金額加上add the quantity and amount($) directly
					  $strQry = "UPDATE `stock` SET ";
					  $strQry .="`StockSum`=StockSum+".$_POST['olddQTY'.$i].", ";
					  $strQry .="`stockAMT`=stockAMT+".$_POST['oldT_PRC'.$i].", ";
					  $strQry .="`uDate`='".date("Y-m-d H:i:s")."', ";
					  $strQry .="`userID`='".$_SESSION['ncareID_lwj']."' ";
					  $strQry .=" WHERE StockID='".mysql_escape_string($_POST['oldSTOCK_INFO'.$i])."' and STK_NO=".$_POST['oldSTK_NO'.$i]."";
					  $UPDATE_DB->query($strQry);
				  }else{
					  //新增一筆add one data
					  $strQry ="INSERT INTO `stock` (`StockID`,`STK_NO`,`Title`,`StockSum`,`stockAMT`,`userID`";
					  $strQry .=") VALUES (";
					  $strQry .=" '".mysql_escape_string($_POST['oldSTOCK_INFO'.$i])."',";							 
					  $strQry .=" '".mysql_escape_string($_POST['oldSTK_NO'.$i])."',"; 		
					  $strQry .=" '".mysql_escape_string($_POST['oldSTK_NAME'.$i])."',";	
					  $strQry .=" '".mysql_escape_string($_POST['olddQTY'.$i])."',";			 
					  $strQry .=" '".mysql_escape_string($_POST['oldT_PRC'.$i])."',";			 
					  $strQry .=" '".$_SESSION['ncareID_lwj']."'"; 								 
					  $strQry .="  )";		
					  $UPDATE_DB->query($strQry);
				  }*/
				  
				  //先扣除原本庫存進出表subtract original storage In/Output list
				  $strQry = "UPDATE `stockform` SET ";
				  $strQry .="`".$STK."`=".$STK."-".$rs['QTY'].", ";
				  $strQry .="`".$PRC."`=".$PRC."-".$rs['QTY'] * $rs['Price'].", ";
				  $strQry .="`uDate`='".date("Y-m-d H:i:s")."', ";
				  $strQry .="`userID`='".$_SESSION['ncareID_lwj']."' ";
				  $strQry .=" WHERE StockID='".$rs['StockID']."' and STK_NO=".$rs['STK_NO']." ".$strSTK."";
				  $UPDATE_DB->query($strQry);	
				 
				  //查詢庫存進出表是否有資料search if storage In/Output list has the data
				  $STK_DB->query("SELECT * FROM `stockform` WHERE `StockID`='".mysql_escape_string($_POST['oldSTOCK_INFO'.$i])."' and `STK_NO`=".$_POST['oldSTK_NO'.$i]." ".$strSTK."");
				  if($STK_DB->num_rows()>0){
					  $strQry = "UPDATE `stockform` SET ";
					  $strQry .="`".$STK."`=".$STK."+".mysql_escape_string($_POST['olddQTY'.$i]).", ";
					  $strQry .="`".$PRC."`=".$PRC."+".mysql_escape_string($_POST['oldT_PRC'.$i]).", ";
					  $strQry .="`uDate`='".date("Y-m-d H:i:s")."', ";
					  $strQry .="`userID`='".$_SESSION['ncareID_lwj']."' ";
					  $strQry .=" WHERE StockID='".mysql_escape_string($_POST['STOCK_INFO'.$i])."' and STK_NO=".$_POST['oldSTK_NO'.$i]." ".$strSTK."";
					  $UPDATE_DB->query($strQry);
				  }else{			  
					  $strQry ="INSERT INTO `stockform` (`StockID`,`STK_NO`,`Title`,`".$STK."`,`".$PRC."`,`STK_YEAR`,`STK_MONTH`,`userID`";
					  $strQry .=") VALUES (";
					  $strQry .=" '".mysql_escape_string($_POST['oldSTOCK_INFO'.$i])."',";						 //庫位storage location
					  $strQry .=" '".mysql_escape_string($_POST['oldSTK_NO'.$i])."',"; 		 //Product serial number
					  $strQry .=" '".mysql_escape_string($_POST['oldSTK_NAME'.$i])."',";	 //product name
					  $strQry .=" '".mysql_escape_string($_POST['olddQTY'.$i])."',";		 //入庫量perchage/input quantity to storage
					  $strQry .=" '".mysql_escape_string($_POST['oldT_PRC'.$i])."',";		 //價格price
					  $strQry .=" '".$arrDateFunction['year']."',";							 //Year
					  $strQry .=" '".$arrDateFunction['month']."',";						 //月
					  $strQry .=" '".$_SESSION['ncareID_lwj']."'"; 								 //建立人員established by staff
					  $strQry .="  )";		
					  $INSERT_DB->query($strQry);
				  }
				  
			  }
		  }			  


		  //update DB
		  $strQry = "UPDATE `".$subModule."` SET ";
		  $strQry .="`STK_NO`='".mysql_escape_string($_POST['oldSTK_NO'.$i])."', ";
		  $strQry .="`QTY`='".mysql_escape_string($_POST['olddQTY'.$i])."', ";
		  $strQry .="`Price`='".mysql_escape_string($_POST['oldIN_PRC'.$i])."', ";
		  $strQry .="`StockID`='".mysql_escape_string($_POST['oldSTOCK_INFO'.$i])."', ";
		  $strQry .="`uDate`='".date("Y-m-d H:i:s")."' ";
		  $strQry .=" WHERE type='".$type."' and ".$strModule."ID='".$firmstockID."' and infoOrd=".$i." and STK_DATE='".$STKDATE."'";
		  $UPDATE_DB->query($strQry);
		  //echo "更".$strQry."<br>";
		  
		  //更新商品倉庫位置
		  $db3 = new DB;
		  $strQry = "update `arkstock` set LAY_NO='".mysql_escape_string($_POST['oldSTOCK_INFO'.$i])."' where STK_NO=".$_POST['oldSTK_NO'.$i];
		  $db3->query($strQry);
		  }		  
	  }
	  
  }		  
		  //調整順序		  		  	
		  $strQry = "select ".$strModule."ID, infoOrd from `".$subModule."`";
		  $strQry .= " where type='".$type."' and ".$strModule."ID =".$firmstockID." and STK_DATE='".$STKDATE."'";
		  $strQry .= " order by infoOrd";		  
		  $OrdDB->query($strQry);
		  //echo "Fully".$strQry."<br>";
		  if ($OrdDB->num_rows()>0) {
			  $J = 1;
			  for ($i2=0;$i2<$OrdDB->num_rows();$i2++){
				  $rs = $OrdDB->fetch_assoc();
				  $tmpOrd = $i2 + $J ;
				  if($tmpOrd==$rs['infoOrd']){
					  $tmpOrd = $i2 + $J;
			  }
				  //先加號
				  $strQry = "update `".$subModule."` set infoOrd=99".$tmpOrd."";
				  $strQry .= " where type='".$type."' and ".$strModule."ID =".$rs[$strModule.'ID']."";
				  $strQry .= " and infoOrd=".$rs['infoOrd']."";
				  $OrdDB1->query($strQry);
				  //echo "加".$strQry."<br>";
				  //重新編號
				  $strQry = "update `".$subModule."` set infoOrd=".$tmpOrd."";
				  $strQry .= " where type='".$type."' and ".$strModule."ID =".$rs[$strModule.'ID']."";
				  $strQry .= " and infoOrd=99".$tmpOrd."";
				  $OrdDB2->query($strQry);
				  //echo "重".$strQry."<br>";
			}
		  }//調整順序end
		  
}
?>