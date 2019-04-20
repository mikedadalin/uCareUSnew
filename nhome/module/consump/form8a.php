<script type="text/javascript" src="js/share.js"></script>
<?php
//模組名稱
$strModule = "firmstock";
$firmstockID = str_pad((int) @$_GET[$strModule.'ID'],4,'0',STR_PAD_LEFT);
$subModule = "firmstockinfo";
$type = "IC";
$type1 = "OC";
//先取得最新退貨編號
$db = new DB;
$db->query("SELECT count(*)+1 AS fid FROM `firmstock` WHERE type='".$type1."' and YEAR(`STK_Date`)=YEAR(DATE(STK_Date)) and MONTH(`STK_Date`)=MONTH(DATE(STK_Date)) ");
if($db->num_rows() >0){
	$rs = $db->fetch_assoc();
	$fid = $rs['fid'];
	$fid = str_pad($fid,4,'0',STR_PAD_LEFT);
}

if (isset($_POST['submit'])) {

	//讀寫資料
	if ($firmstockID != NULL) {
		//新增退貨單
		$db = new DB;
		$strQry ="INSERT INTO `".$strModule."` (`firmStockID`,`STK_Date`,`type`, `firmID`,`ReceiptNO`,`ReceiptDate`,`Tax_1`,`Tax_2`,";
		$strQry .="`IN_firmStockID`, `T_PRC`,`STK_NET`,`STK_TAX`,`STK_TOT`,`Fmark`,`userID`) VALUES (";
		$strQry .=" '".mysql_escape_string($_POST['firmstockID'])."',";
		$strQry .=" '".mysql_escape_string($_POST['STK_Date'])."',";
		$strQry .=" '".$type1."',";
		$strQry .=" '".mysql_escape_string($_POST['firmID'])."',";
		$strQry .=" '".mysql_escape_string($_POST['ReceiptNO'])."',";
		$strQry .=" '".mysql_escape_string($_POST['ReceiptDate'])."',";
		$strQry .=" '".mysql_escape_string($_POST['Tax_1'])."',";
		$strQry .=" '".mysql_escape_string($_POST['Tax_2'])."',";
		$strQry .=" '".mysql_escape_string($_POST['IN_firmStockID'])."',";
		$strQry .=" '".mysql_escape_string($_POST['T_PRC'])."',";
		$strQry .=" '".mysql_escape_string($_POST['STK_NET'])."',";
		$strQry .=" '".mysql_escape_string($_POST['STK_TAX'])."',";
		$strQry .=" '".mysql_escape_string($_POST['STK_TOT'])."',";
		$strQry .=" '".mysql_escape_string($_POST['Fmark'])."',";
		$strQry .=" '".$_SESSION['ncareID_lwj']."'"; 
		$strQry .="  )";		
		$db->query($strQry);		
		include("class/insertTable1.php");
		echo "<script>alert('Add successfully!');window.location.href='index.php?mod=consump&func=formview&id=8_2a'</script>";
	}else{
		echo "<script>alert('Data error!');window.location.href='index.php?mod=consump&func=formview&id=8_2a'</script>";
	}
}
//編輯畫面
$db = new DB;
$strSQL = "SELECT a.*,  RIGHT( EXTRACT( YEAR_MONTH FROM  `STK_Date` ) , 4 ) ordDate , b.Title, b.Fidno, b.Discount FROM `firmstock` a INNER JOIN `firm` b ON a.firmID = b.firmID  WHERE a.type='".$type."' and a.`".$strModule."ID`='".mysql_escape_string($firmstockID)."'";
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
<h3>Add return</h3>
<form name="FSform" id="FSform" method="post">
<div class="content-table">
<table>
  <tr id="backtr">
    <td height="23" class="title" >Purchase bill #</td>
    <td colspan="5"><input type="text" value="<?php echo $type; echo $r['ordDate'].$r['firmStockID']; ?>" id="IN_firmStockID" name="IN_firmStockID" readonly="readonly"/></td>   
</tr>
  <tr id="backtr">
    <td height="23" class="title" style=" background-color:#FF8928;">Return bill #</td>
    <td ><input type="text" value="<?php echo $type1; echo date("ym"); echo $fid; ?>" id="a" name="a" disabled="disabled"/></td>   
    <td class="title">Return date</td>
    <td ><script> $(function() { $( "#STK_Date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="STK_Date" id="STK_Date" value="<?php echo $r['STK_Date']; ?>" size="12" ></td>
    <td class="title"  >Tax</td>
    <td colspan="2" ><?php echo draw_option("Tax","Taxable;Exemption","s","single",$Tax,false,2);?></td>
    </tr>

  <tr id="backtr"  style=" height:20px;" >
    <td class="title" width="100">Vendor ID#</td>
    <td>
      <div id="FirmDiv" style="width:200px;"><input name="firmID" type="text" id="firmID" value="<?php echo $r['firmID']; ?>" readonly="readonly"/></div></td>
    <td class="title"  width="100">Vendor's name</td>
    <td ><input type="text" id="log0" name="log0" size="25" disabled="disabled" value="<?php echo $r['Title']; ?>"/></td>
    <td class="title" width="100" >EIN/Tax ID</td>
    <td colspan="2" ><input type="text" id="log1" name="log1" disabled="disabled" value="<?php echo $r['Fidno']; ?>" /></td>
    </tr>
  <tr  style=" height:20px;" >
    <td class="title">Invoice/reciept No.</td>
    <td><input name="ReceiptNO" type="text" id="ReceiptNO" value="<?php echo $r['ReceiptNO']; ?>" /></td>
    <td class="title">Invoice/reciept date</td>
    <td ><script> $(function() { $( "#ReceiptDate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="ReceiptDate" id="ReceiptDate" size="12" value="<?php echo $r['ReceiptDate']; ?>"></td>
    <td class="title">Return $ amount</td>
    <td colspan="2" ><input type="text" id="T_PRC" name="T_PRC" readonly="readonly" value="0" /></td>
  </tr>
  <tr id="backtr"  >
    <td class="title" >Net $ returns</td>
    <td ><input type="text" id="STK_NET" name="STK_NET" readonly="readonly" value="0"/>Discount<input type="text" id="log2" name="log2" size="2" disabled="disabled" value="<?php echo $r['Discount']; ?>" />%</td>   
    <td class="title"  >Tax of return</td>
    <td ><input type="text" id="STK_TAX" name="STK_TAX" readonly="readonly" value="0" /></td>
    <td class="title"  >Return total value</td>
    <td colspan="2" ><input type="text" id="STK_TOT" name="STK_TOT" readonly="readonly" value="0" /></td>
    </tr>
  
  <tr >
    <td class="title" >Comment</td>
    <td colspan="3" ><textarea id="Fmark" name="Fmark" rows="1" cols="50"><?php echo $r['Fmark']; ?></textarea></td>   
    <td class="title"  >Documented personnel</td>
    <td colspan="2" ><?php echo checkusername($_SESSION['ncareID_lwj']);?></td>
    </tr>  
    
</table>
<?php 
$IN = $type.$r['ordDate'].$r['firmStockID']; 
include("class/blockTable1.php");
 ?>
</div>
<br />&nbsp;
<center>
	<input type="hidden" id="<?php echo $strModule ?>ID" name="<?php echo $strModule ?>ID" value="<?php echo $fid ?>" />
    <input type="button" id="cmdBack" name="cmdBack" value="Back to list"  />
	<input type="submit" name="submit" id="submit" value="Save" />
</center>
</form>
<?php }?>
<script language="javascript">

$(function() {
	//Back to list
	$('#cmdBack').click(function(){
	  location.href='index.php?mod=consump&func=formview&id=8_2' ;
	});

  //驗證
  $('#submit').click(function(){

	if($('#oldCount').val()==0){
		alert('產品不得為空!!\n請按F5重新整理頁面');		
		return false;
	}  
	for (var jj = 1; jj <= $('#oldCount').val(); jj++) {		
	if($('#olddQTY'+jj).val() == ""){
	  alert(1);
	}  
	  if($('#olddQTY'+jj).val() != ""){
//		  alert('請輸入數量!!')
//		  $('#olddQTY'+jj).focus();
//		  //return false;
//	  }else{
		if(isNaN($('#olddQTY'+jj).val()) || $('#olddQTY'+jj).val() == 0){
		   alert("請輸入有效數量!!");
		   $('#olddQTY'+jj).focus();
		   //return false;
		}		
	  }
	  var cQTY = parseFloat($('#olddQTY'+jj).val());
	  var xQTY = parseFloat($('#xCount'+jj).val());
	  var maxQTY = parseFloat($('#maxCount'+jj).val());

	  if ((cQTY + xQTY) > maxQTY){
		  $('#olddQTY'+jj).focus();
		  alert('退貨總數量已超過\n Purchase quantity  【 ' + maxQTY + ' 】\n最多僅可退 【 '+(maxQTY-xQTY)+ ' 】');
		  return false;
	  }	  	  
	}		
	return false;
//		if (chkAll() == false){
//			 return false;
//		}
  });
  $('#btn_Tax_1').click(function(){
	  S_TAX($("#STK_NET").val());
  });
  $('#btn_Tax_2').click(function(){
	  S_TAX($("#STK_NET").val());
  });
});

</script>

