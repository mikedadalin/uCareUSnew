<?php 

if ((int) @$_POST['oldCount1'] <> ""){
	$fCount =  (int) @$_POST['oldCount1'];
	$ItemCount = 0;
	for ($i=1; $i<=$fCount ;$i++) {
		$tmp_STK_NO = "";
		if($_POST['oldSTK_NO'.$i] <> 0){
			$tmp_STK_NO = $_POST['oldSTK_NO'.$i];
		}
	
		if($tmp_STK_NO <> 0 && $_POST['oldSTOCK_INFO_NAME'.$i] <> '')
		{
		  $ItemCount +=1;
		  		  
		  //新增明細adding detail list
		  $db2 = new DB;
		  $strQry ="INSERT INTO `".$strModule."info` (`FirmStockID`,`STK_Date`,`infoOrd`,`STK_NO`,`QTY`,`Price`,`StockID`,`type`,`userID`,`OUT_ORD`";
		  $strQry .=") VALUES (";
		  $strQry .=" '".$newid."',";
		  $strQry .=" '".mysql_escape_string($_POST['STK_Date'])."',";
   	  	  $strQry .=" '".$ItemCount."',";
		  $strQry .=" '".mysql_escape_string($tmp_STK_NO)."',";
		  $strQry .=" '".mysql_escape_string($_POST['olddQTY'.$i])."',";
		  $strQry .=" '".mysql_escape_string($_POST['oldOUT_PRC'.$i])."',";
		  $strQry .=" '".mysql_escape_string($_POST['oldSTOCK_INFO'.$i])."',";
		  $strQry .=" '".$type."',";
		  $strQry .=" '".$_SESSION['ncareID_lwj']."',"; 
		  $strQry .=" '".mysql_escape_string($_POST['oldORD_NO'.$i])."'"; 
		  $strQry .="  )";		
		  $db2->query($strQry);
		  
		  //print_r($_POST);
		  $rORD = explode(';',$_POST['oldORD_NO'.$i]);
		  $tmpQTY = mysql_escape_string($_POST['olddQTY'.$i]); //Delivery quantity
		  foreach ($rORD as $k=>$v) {
			  $arrORDNO = explode('-',$v);
			  $ORDSEQ = $arrORDNO[0]; //申請單-主單號
			  $ORDSEQ1 = $arrORDNO[1]; //申請單-明細項目編號
			  $db3a = new DB;
			  $db3a->query("SELECT * FROM `arkord` WHERE `ORD_SEQ`='".$ORDSEQ."' AND `ORD_SEQ1`='".$ORDSEQ1."'");
			  $r3a = $db3a->fetch_assoc();
			  if ($tmpQTY>=$r3a['ORD_QTY']) {
				  $newORDRMK = "2";
			  } else {
				  $newORDRMK = "1";
			  }
			  //1=已出貨但有缺數量
			  //2=己完成出貨
			  $db3b = new DB;
			  $db3b->query("UPDATE `arkord` SET `OUT_NO`='".$newid."', `OUT_DATE`='".mysql_escape_string($_POST['STK_Date'])."', `ORD_RMK`='".$newORDRMK."' WHERE `ORD_SEQ`='".$ORDSEQ."' AND `ORD_SEQ1`='".$ORDSEQ1."'");
			  $tmpQTY = $tmpQTY - $r3a['ORD_QTY'];
		  }
		  
		  //更新狀為為已退貨
//		  $strQry = "update `firmstockinfo` set IsStatus='O' where STK_NO=".$tmp_STK_NO." and type='IC' and infoOrd=".$i."";
//		  $db2->query($strQry);
		  
		  //更新商品倉庫位置update product storage location
//		  $db3 = new DB;
//		  $strQry = "update `arkstock` set LAY_NO='".mysql_escape_string($_POST['oldSTOCK_INFO'.$i])."' where STK_NO=".$tmp_STK_NO;
//		  $db3->query($strQry);
		  
		  //寫入庫存總表write into storage total list
		  $STK_DB = new DB;
		  $UPDATE_DB = new DB;
		  $INSERT_DB = new DB;
		  $STK_DB->query("SELECT * FROM `stock` WHERE `StockID`='".mysql_escape_string($_POST['oldSTOCK_INFO'.$i])."' and `STK_NO`=".$tmp_STK_NO."");
		  if($STK_DB->num_rows()>0){
			  $strQry = "UPDATE `stock` SET ";
			  $strQry .="`StockSum`=StockSum-".mysql_escape_string($_POST['olddQTY'.$i]).", ";
			  $strQry .="`stockAMT`=stockAMT-".mysql_escape_string($_POST['oldT_PRC'.$i]).", ";
			  $strQry .="`uDate`='".date("Y-m-d H:i:s")."', ";
			  $strQry .="`userID`='".$_SESSION['ncareID_lwj']."' ";
			  $strQry .=" WHERE StockID='".mysql_escape_string($_POST['oldSTOCK_INFO'.$i])."' and STK_NO=".$tmp_STK_NO."";
			  $UPDATE_DB->query($strQry);
		  }else{			  
			  $strQry ="INSERT INTO `stock` (`StockID`,`STK_NO`,`Title`,`StockSum`,`stockAMT`,`userID`";
			  $strQry .=") VALUES (";
			  $strQry .=" '".mysql_escape_string($_POST['oldSTOCK_INFO'.$i])."',";							 //庫位storage inventory location
			  $strQry .=" '".mysql_escape_string($tmp_STK_NO)."',"; 				 	 //Product serial number
			  $strQry .=" '".mysql_escape_string($_POST['oldSTK_NAME'.$i])."',";		 //product name
			  $strQry .=" '".mysql_escape_string($_POST['olddQTY'.$i])."',";			 //總量total quantity
			  $strQry .=" '".mysql_escape_string($_POST['oldT_PRC'.$i])."',";			 //總價total amount($)
			  $strQry .=" '".$_SESSION['ncareID_lwj']."'"; 								 	 //建立人員established by staff
			  $strQry .="  )";		
			  $INSERT_DB->query($strQry);
		  }

		  //寫入庫存進出表write into storage In/Output list
		  if($type1 =="IC"){
			  $STK = "IN_STK";
			  $PRC = "IN_PRC";
		  }elseif($type1 =='A'){
			  $STK = "ADJ_STK";
			  $PRC = "ADJ_PRC";			  
		  }else
		  {
			  $STK = "OUT_STK";
			  $PRC = "OUT_PRC";
		  }
		  $arrDateFunction = chkDate(($STKDATE==""?$_POST['STK_Date']:$STKDATE));
		  $strSTK = " and `STK_YEAR`='".$arrDateFunction['year']."' and STK_MONTH='".$arrDateFunction['month']."'";  
		  $STK_DB->query("SELECT * FROM `stockform` WHERE `StockID`='".mysql_escape_string($_POST['oldSTOCK_INFO'.$i])."' and `STK_NO`=".$tmp_STK_NO." ".$strSTK."");
		  if($STK_DB->num_rows()>0){
			  $strQry = "UPDATE `stockform` SET ";
			  $strQry .="`".$STK."`=".$STK."+".mysql_escape_string($_POST['olddQTY'.$i]).", ";
			  $strQry .="`".$PRC."`=".$PRC."+".mysql_escape_string($_POST['oldT_PRC'.$i]).", ";
			  $strQry .="`uDate`='".date("Y-m-d H:i:s")."', ";
			  $strQry .="`userID`='".$_SESSION['ncareID_lwj']."' ";
			  $strQry .=" WHERE StockID='".mysql_escape_string($_POST['oldSTOCK_INFO'.$i])."' and STK_NO=".$tmp_STK_NO." ".$strSTK."";
			  $UPDATE_DB->query($strQry);
		  }else{			  
			  $strQry ="INSERT INTO `stockform` (`StockID`,`STK_NO`,`Title`,`".$STK."`,`".$PRC."`,`STK_YEAR`,`STK_MONTH`,`userID`";
			  $strQry .=") VALUES (";
			  $strQry .=" '".mysql_escape_string($_POST['oldSTOCK_INFO'.$i])."',";							 //庫位storage inventory location
			  $strQry .=" '".mysql_escape_string($tmp_STK_NO)."',"; 				 	 //Product serial number
			  $strQry .=" '".mysql_escape_string($_POST['oldSTK_NAME'.$i])."',";		 //product name
			  $strQry .=" '".mysql_escape_string($_POST['olddQTY'.$i])."',";			 //入庫量perchage/input quantity to storage
			  $strQry .=" '".mysql_escape_string($_POST['oldT_PRC'.$i])."',";			 //價格price
			  $strQry .=" '".$arrDateFunction['year']."',";					 	 		 //Year
			  $strQry .=" '".$arrDateFunction['month']."',";				 	 		 //月
			  $strQry .=" '".$_SESSION['ncareID_lwj']."'"; 								 	 //建立人員established by staff
			  $strQry .="  )";		
			  $INSERT_DB->query($strQry);
		  }
		  
		}
	}
};

?>