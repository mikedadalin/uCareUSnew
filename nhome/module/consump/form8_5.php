<?php

//模組名稱
$strModule = "firmstock";
$firmstockID = str_pad((int) @$_GET[$strModule.'ID'],4,'0',STR_PAD_LEFT);
$fid = $firmstockID;
$subModule = "firmstockinfo";
$type = "A";
if ($_GET['STK_DATE']=="") {
	$STKDATE = date("Y/m/d");
} else {
	$STKDATE = $_GET['STK_DATE'];
}

if (isset($_POST['submit'])) {

	//讀寫資料
	if ($_POST['firmstockID']!=NULL) {
		//更新調整單
		$db = new DB;
		$strQry = "UPDATE `".$strModule."` SET ";
		$strQry .="`ReceiptNO`='".mysql_escape_string($_POST['ReceiptNO'])."', ";
		$strQry .="`ReceiptDate`='".mysql_escape_string($_POST['ReceiptDate'])."', ";
		$strQry .="`Tax_1`='".mysql_escape_string($_POST['Tax_1'])."', ";
		$strQry .="`Tax_2`='".mysql_escape_string($_POST['Tax_2'])."', ";
		$strQry .="`T_PRC`='".mysql_escape_string($_POST['T_PRC'])."', ";
		$strQry .="`STK_NET`='".mysql_escape_string($_POST['STK_NET'])."', ";
		$strQry .="`STK_TAX`='".mysql_escape_string($_POST['STK_TAX'])."', ";
		$strQry .="`STK_TOT`='".mysql_escape_string($_POST['STK_TOT'])."', ";
		$strQry .="`Fmark`='".mysql_escape_string($_POST['Fmark'])."', ";
		$strQry .="`uDate`='".date("Y-m-d H:i:s")."', ";
		$strQry .="`userID`='".$_SESSION['ncareID_lwj']."'"; 
		$strQry .=" WHERE ".$strModule."ID='".$firmstockID."' and type='".$type."' and STK_DATE='".$STKDATE."'";
		$db->query($strQry);	
		//echo $strQry."<br>";
		
		include("class/updateTable.php");
		include("class/insertTable.php");
		
		echo "<script>alert('Modify success!'); self.reload();</script>";
	}
}

//編輯畫面
$db = new DB;
$strSQL = "SELECT a.*,  RIGHT( EXTRACT( YEAR_MONTH FROM  `STK_Date` ) , 4 ) ordDate FROM `firmstock` a WHERE a.type='".$type."' and a.`".$strModule."ID`='".mysql_escape_string($firmstockID)."' AND a.`STK_Date`='".$STKDATE."'";
$db->query($strSQL);
if ($db->num_rows()>0) {
	$r = $db->fetch_assoc();
	foreach ($r as $k=>$v) {
		$arrPatientInfo = explode("_",$k);
		if (count($arrPatientInfo)==2) {
			if ($v==1) {
				${$arrPatientInfo[0]} = $arrPatientInfo[1];
			}
		} else {
			${$k} = $v;
		}
	}
?>
<h3>Adjustment note</h3>
<form  method="post">
<div class="content-table">
<table width="100%">
  <tr id="backtr">
    <td height="23" class="title" >Adjustment note ID#</td>
    <td colspan="5" ><input type="text" value="<?php echo $type; echo $r['ordDate'].$r['firmStockID']; ?>" id="a" name="a" disabled="disabled"/></td>   
    <td class="title">Adjusted date</td>
    <td ><script> $(function() { $( "#STK_Date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="STK_Date" id="STK_Date" value="<?php echo $r['STK_Date']; ?>" size="12" ></td>
    </tr>
  
  <tr >
    <td class="title" >Comment</td>
    <td colspan="5" ><textarea id="Fmark" name="Fmark" rows="1" cols="50"><?php echo $r['Fmark']; ?></textarea></td>   
    <td class="title"  >Documented personnel</td>
    <td colspan="2" ><?php echo checkusername($_SESSION['ncareID_lwj']);?></td>
    </tr>  
    
</table>
<?php include("class/blockTable.php"); ?>
<?php 
if($r['IsStatus'] == 'N'){
	include("class/addTable.php");
}
?>
</div>
<br />&nbsp;
<center>
	<input type="hidden" id="<?php echo $strModule ?>ID" name="<?php echo $strModule ?>ID" value="<?php echo $firmstockID ?>" />
    <input type="button" id="cmdBack" name="cmdBack" value="Back to list"  />
    <?php if($r['IsStatus'] == 'N'){?>
	<input type="submit" name="submit" id="submit" value="Save" />
    <?php }?>
</center>
</form>
<?php
}
?>

<script language="javascript">
$(function() {
	//Back to list
	$('#cmdBack').click(function(){
	  location.href='index.php?mod=consump&func=formview&id=8_3' ;
	});
	
  //驗證
  $('#submit').click(function(){
	if($('#Fmark').val()== ""){
		alert('請輸入調整原因!!')
		$('#Fmark').focus();
		return false;
	}
	
	for (var jj = 1; jj <= $('#oldCount').val(); jj++) {		
	
	  if($('#oldSTK_NAME'+jj).val()== ""){
		  alert('請輸入產品代碼!!')
		  $('#oldSTK_NO'+jj).focus();
		  return false;
	  }

	  if(!$('#oldSTK_NO'+jj).val()){
		return;	
	  }	
	  
	  if($('#olddQTY'+jj).val() == ""){
		  alert('請輸入數量!!')
		  $('#olddQTY'+jj).focus();
		  return false;
	  }else{
		if(isNaN($('#olddQTY'+jj).val())){
		   alert("請輸入有效數量!!");
		   $('#olddQTY'+jj).focus();
		   return false;
		}		
	  }
	  if ($("#oldSTOCK_INFO_NAME"+jj).val()==""){
		  $('#oldSTOCK_INFO'+jj).focus();
		  alert('請輸入有效倉庫代碼!!')
		  return false;
	  }	  	  
	}		
	  
	  //新增項目
	for (var j = 1; j <= $('#fileCount').val(); j++) {		
	
	  if($('#STK_NAME'+j).val()== ""){
		  alert('@請輸入產品代碼!!')
		  $('#STK_NO'+j).focus();
		  return false;
	  }
	  if(!$('#STK_NO'+j).val()){
		return;	
	  }

	  if($('#dQTY'+j).val() == ""){
		  alert('@請輸入數量!!')
		  $('#dQTY'+j).focus();
		  return false;
	  }else{
		if(isNaN($('#dQTY'+j).val())){
		   alert("@請輸入有效數量!!");
		   $('#dQTY'+j).focus();
		   return false;
		}		
	  }
	  if ($("#STOCK_INFO_NAME"+j).val()==""){
		  $('#STOCK_INFO'+j).focus();
		  alert('@請輸入有效倉庫代碼!!')
		  return false;
	  }	  	  
	}		
  });
  $('#btn_Tax_1').click(function(){
	  S_TAX($("#STK_NET").val());
  });
  $('#btn_Tax_2').click(function(){
	  S_TAX($("#STK_NET").val());
  });
});
    

</script>

