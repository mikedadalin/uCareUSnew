<?php

//模組名稱
$strModule = "firmstock";
$firmstockID = str_pad((int) @$_GET[$strModule.'ID'],4,'0',STR_PAD_LEFT);
$fid = str_pad((int) @$_GET[$strModule.'ID'],4,'0',STR_PAD_LEFT);
$subModule = "firmstockinfo";
$type = "IC";
if ($_GET['STK_DATE']=="") {
	$STKDATE = date("Y/m/d");
} else {
	$STKDATE = $_GET['STK_DATE'];
}

if (isset($_POST['submit'])) {

	//讀寫資料
	if ($_POST['firmstockID']!=NULL) {
		//更新進貨單
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
		
		//echo "<script>alert('Modify success!'); self.reload();<//script>";
	}
}

//編輯畫面
$db = new DB;
$strSQL = "SELECT a.*,  RIGHT( EXTRACT( YEAR_MONTH FROM  `STK_Date` ) , 4 ) ordDate , b.Title, b.Fidno, b.Discount FROM `firmstock` a INNER JOIN `firm` b ON a.firmID = b.firmID  WHERE a.type='".$type."' and a.`".$strModule."ID`='".mysql_escape_string($firmstockID)."' and STK_DATE='".$STKDATE."'";
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
<h3>Purchase bill</h3>
<form  method="post">
<div class="content-table">
<table>
  <tr id="backtr">
    <td height="23" class="title" >Purchase bill #</td>
    <td  align="left"><input type="text" value="<?php echo $type.$r['ordDate'].$r['firmStockID']; ?>" id="IN_firmStockID" name="IN_firmStockID" readonly="readonly"/></td>   
    <td class="title">Purchase date</td>
    <td  align="left"><input type="text" name="STK_Date" id="STK_Date" value="<?php echo $r['STK_Date']; ?>" size="12" readonly="readonly"> <font size="-4" color="#FF0000">*Can not be modified</font></td>
    <td class="title"  >Tax</td>
    <td colspan="2"  align="left"><?php echo draw_option("Tax","Taxable;Exemption","m","single",$Tax,false,2);?></td>
    </tr>

  <tr id="backtr"  style=" height:20px;" >
    <td class="title" width="100"  style=" background-color:#eecb35;">Vendor ID#</td>
    <td align="left">
      <div id="FirmDiv" style="width:200px;"><input name="firmID" type="text" id="firmID" value="<?php echo $r['firmID']; ?>" readonly="readonly"/></div></td>
    <td class="title"  width="100">Vendor's name</td>
    <td  align="left"><input type="text" id="log0" name="log0" size="25" disabled="disabled" value="<?php echo $r['Title']; ?>"/></td>
    <td class="title" width="100" >EIN/Tax ID</td>
    <td colspan="2"  align="left"><input type="text" id="log1" name="log1" disabled="disabled" value="<?php echo $r['Fidno']; ?>" /></td>
    </tr>
  <tr  style=" height:20px;" >
    <td class="title">Invoice/reciept No.</td>
    <td align="left"><input name="ReceiptNO" type="text" id="ReceiptNO" value="<?php echo $r['ReceiptNO']; ?>" /></td>
    <td class="title">Invoice/reciept date</td>
    <td  align="left"><script> $(function() { $( "#ReceiptDate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="ReceiptDate" id="ReceiptDate" size="12" value="<?php echo $r['ReceiptDate']; ?>"></td>
    <td class="title">Purchase payment amount</td>
    <td colspan="2"  align="left"><input type="text" id="T_PRC" name="T_PRC" readonly="readonly" value="<?php echo $r['T_PRC']; ?>" /></td>
  </tr>
  <tr id="backtr"  >
    <td class="title" >Net purchase</td>
    <td  align="left"><input type="text" id="STK_NET" name="STK_NET" readonly="readonly" value="<?php echo $r['STK_NET']; ?>"/>Discount<input type="text" id="log2" name="log2" size="2" disabled="disabled" value="<?php echo $r['Discount']; ?>" />%</td>   
    <td class="title"  >Sales/use tax</td>
    <td  align="left"><input type="text" id="STK_TAX" name="STK_TAX" readonly="readonly" value="<?php echo $r['STK_TAX']; ?>" /></td>
    <td class="title"  >Purchase total value</td>
    <td colspan="2"  align="left"><input type="text" id="STK_TOT" name="STK_TOT" readonly="readonly" value="<?php echo $r['STK_TOT']; ?>" /></td>
    </tr>
  
  <tr >
    <td class="title" >Comment</td>
    <td colspan="3"  align="left"><textarea id="Fmark" name="Fmark" rows="1" cols="50"><?php echo $r['Fmark']; ?></textarea></td>   
    <td class="title"  >Documented personnel</td>
    <td colspan="2"  align="left"><?php echo checkusername($_SESSION['ncareID_lwj']);?></td>
    </tr>  
    
</table>
<?php 
$IN = $type.$r['ordDate'].$r['firmStockID'];
include("class/blockTable.php");
 ?>
<?php 
if($r['IsStatus'] == 'N' && chkReturned($IN)=="0"){
	include("class/addTable.php");
}
?>
</div>
<br />&nbsp;
<center>
	<input type="hidden" id="<?php echo $strModule ?>ID" name="<?php echo $strModule ?>ID" value="<?php echo $firmstockID ?>" />    
    <input type="button" id="cmdBack" name="cmdBack" value="Back to list"  />
    <?php if($r['IsStatus'] == 'N' && chkReturned($IN)=="0"){?>
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
	  location.href='index.php?mod=consump&func=formview&id=8_2' ;
	});
	
  //驗證
  $('#submit').click(function(){
    if($('#fileCount').val()=="" && $('#oldCount').val()==0){alert('請先新增產品');return false;}
  
	for (var jj = 1; jj <= $('#oldCount1').val(); jj++) {		
		if ($('#oldRemoved'+jj).val()==0) {
		  if($('#oldSTK_NAME'+jj).val()== ""){
			  alert('請輸入產品代碼!!')
			  $('#oldSTK_NO'+jj).focus();
			  return false;
		  }
		  
		  if($('#olddQTY'+jj).val() == ""){
			  alert('請輸入數量!!')
			  $('#olddQTY'+jj).focus();
			  return false;
		  }else{
			if(isNaN($('#olddQTY'+jj).val()) || $('#olddQTY'+jj).val() == 0){
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
	}		
	  //新增項目
	for (var j = 1; j <= $('#fileCount1').val(); j++) {		

		if ($('#removed'+j).val()==0) {
			if($('#STK_NAME'+j).val()== ""){
				alert('@請輸入產品代碼!!')
				$('#STK_NO'+j).focus();
				return false;
			}
	  
			if($('#dQTY'+j).val() == ""){
				alert('@請輸入數量!!')
				$('#dQTY'+j).focus();
				return false;
			}else{
			  if(isNaN($('#dQTY'+j).val()) || $('#dQTY'+j).val() == 0){
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

