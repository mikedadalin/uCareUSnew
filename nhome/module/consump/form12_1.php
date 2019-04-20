<script type="text/javascript" src="js/share.js"></script>

<?php
//模組名稱
$strModule = "firmstock";
$subModule = "firmstockinfo";


if($_GET['pid'] == ""){
	$pID = "";
}else{
	$pID = mysql_escape_string($_GET['pid']);
	$myID = $pID;
}
if($_GET['aID'] == ""){
	$areaID = "";
}else{
	$areaID = mysql_escape_string($_GET['aID']);
	$myID = "Area".$areaID;
}
$type = "SP";
$firmstockID = mysql_escape_string($_GET['firmstockID']);
if ($_GET['STK_DATE']=="") {
	$STKDATE = date("Y/m/d");
} else {
	$STKDATE = $_GET['STK_DATE'];
}
if (isset($_POST['submit'])) {
	$firmstockID = mysql_escape_string($_POST['firmstockID']);
	$newid = $firmstockID;
	//讀寫資料
	if ($firmstockID != NULL) {
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
		$strQry .=" WHERE ".$strModule."ID='".$firmstockID."' and type='".$type."' and firmID='".$myID."' and STK_DATE='".$STKDATE."'";
		$db->query($strQry);	
		include("class/updateTable.php");
		include("class/insertTable2.php");
		echo "<script>alert('Modify success!');window.location.href='index.php?mod=consump&func=formview&id=12'</script>";
	}else{
		echo "<script>alert('Data error!');window.location.href='index.php?mod=consump&func=formview&id=12'</script>";
	}
}


//編輯畫面
$db = new DB;
$strSQL = "SELECT a.*, RIGHT( EXTRACT( YEAR_MONTH FROM  `STK_Date` ) , 4 ) ordDate FROM `firmstock` a WHERE a.type='".$type."' and a.`".$strModule."ID`='".$firmstockID."' and STK_DATE='".$STKDATE."' and firmID='".$myID."'";
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
	if(substr($firmID,0,4)=="Area"){
		$com = 1 ;
	}else{
		$com = 0 ;
	}

?>
<h3>Delivery note </h3>
<form name="FSform" id="FSform" method="post">
<div class="content-table">
<table align="left"  width="100%" style="font-size:10pt; margin-left:0px;">
  <tr id="backtr"  >
    <td class="title" >Application category</td>
    <td colspan="3"  align="left"><?php if($com == 1){echo "Public use";}else{echo "Individual use";} ?></td>   
    <td class="title"  >EIN/Tax ID</td>
    <td colspan="2" align="left"><input type="text" id="log1" name="log1" disabled="disabled" <?php echo $r['Fidno']; ?> /></td>
    </tr>
  <tr id="backtr"  >
    <td class="title" >Delivery note ID#</td>
    <td  align="left"><input type="text" value="<?php echo $type.$r['ordDate'].$r['firmStockID']; ?>" id="a" name="a" disabled="disabled"/></td>   
    <td class="title"  >Shipping date</td>
    <td  align="left"><script> $(function() { $( "#STK_Date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="STK_Date" id="STK_Date" value="<?php echo $r['STK_Date']; ?>" size="12" ></td>
    <td class="title"  >Tax</td>
    <td colspan="2"  align="left"><?php echo draw_option("Tax","Taxable;Exemption","m","single",$Tax,false,2);?></td>
    </tr>
  <?php if($com == 1){?>     
  <tr id="AreaTR"  style="border:none; height:20px;" >
    <td class="title" width="10%"  style="border:none; background-color:#FF8928;">Area</td>
    <td colspan="5" align="left">
      <?php 
	  $db3 = new DB;
	  $db3->query("SELECT * FROM `arkarea` where `areaID`= '".$areaID."' ORDER BY `areaID` ASC");
	  if ($db3->num_rows() > 0) {
		  $r3 = $db3->fetch_assoc();
		  echo '<input name="area" type="text" id="area" value="'.$r3['areaName'].'" readonly="readonly"/>';
	  }
	?>
        </td>
	</tr>
  <?php }else{?>  
  <tr id="PatientTR"  style="border:none; height:20px;" >
    <td class="title" width="10%"  style="border:none; background-color:#eecb35;">Care ID#</td>
    <td align="left">
      <div id="FirmDiv" style="width:200px;"><input class="validate[required,custom[integer]]" name="firmID" type="text" id="firmID" readonly value="<?php echo getHospNoDisplayByHospNo($firmID); ?>"/></div></td>
    <td class="title"  >Resident's name</td>
    <td align="left"><input type="text" id="log0" name="log0" disabled="disabled"  /></td>
    <td class="title"  >Bed #</td>
    <td  align="left"><input type="text" id="log4" name="log4" disabled="disabled"  /></td>
  </tr>
  <?php }?>
  <tr  style="border:none; height:20px;" >
    <td class="title">Invoice/reciept No.</td>
    <td align="left"><input name="ReceiptNO" type="text" id="ReceiptNO" value="<?php echo $r['ReceiptNO']; ?>"/></td>
    <td class="title">Invoice/reciept date</td>
    <td  align="left"><script> $(function() { $( "#ReceiptDate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="ReceiptDate" id="ReceiptDate" size="12"  value="<?php echo $r['ReceiptDate']; ?>"></td>
    <td class="title">Delivery $ amount</td>
    <td colspan="2"  align="left"><input type="text" id="T_PRC" name="T_PRC" readonly value="<?php echo $r['T_PRC']; ?>" /></td>
  </tr>
  <tr id="backtr"  >
    <td class="title" >Net delivery</td>
    <td  align="left">
    <input type="text" id="STK_NET" name="STK_NET" size="8" readonly value="<?php echo $r['STK_NET']; ?>" />Discount<input type="text" id="log2" name="log2" size="2" readonly /> %, waiver<input type="text" id="log3" name="log3" size="5" readonly />
    </td>   
    <td class="title"  >Delivery tax</td>
    <td  align="left"><input type="text" id="STK_TAX" name="STK_TAX" readonly value="<?php echo $r['STK_TAX']; ?>"/></td>
    <td class="title"  >Delivery total value</td>
    <td colspan="2"  align="left"><input type="text" id="STK_TOT" name="STK_TOT" readonly value="<?php echo $r['STK_TOT']; ?>"/></td>
    </tr>
  
  <tr >
    <td class="title" >Comment</td>
    <td colspan="3"  align="left"><textarea id="Fmark" name="Fmark"><?php echo $r['Fmark']; ?></textarea></td>   
    <td class="title"  >Documented personnel</td>
    <td colspan="2"  align="left"><?php echo checkusername($_SESSION['ncareID_lwj']);?></td>
    </tr>  
    
</table>
<?php 
	$IN = $type.$r['ordDate'].$r['firmStockID'];
	include("class/blockTable2.php");
	include("class/addTable2.php");
}?>
</div>
<br />&nbsp;
<center>
	<input type="hidden" id="<?php echo $strModule ?>ID" name="<?php echo $strModule ?>ID" value="<?php echo $firmstockID ?>" />
    <input type="button" id="cmdBack" name="cmdBack" value="Back to list"  />
    <?php if($r['IsStatus']=="N"){?>
		<input type="submit" name="submit" id="submit" value="Save" />
    <?php }?>
</center>
</form>
<script language="javascript">

function showPatient() {
  $.ajax({
	  url: "class/patient.php",
	  type: "POST",
	  data: { "PID": $("#firmID").val()},
	  success: function(data) {
		  var dataArr = data.split(';');
		  for (i = 0; i < dataArr.length; i++){				
			  $( "#log"+i ).val( dataArr[i] );
		  }
		  oS_AMT(1);
	  }
  });
}

$(function() {
	var chkID = '<?php echo $pID;?>';
	if(chkID!=""){
		showPatient();
	}
	
	//Back to list
	$('#cmdBack').click(function(){
	  location.href='index.php?mod=consump&func=formview&id=12' ;
	});
	

  //驗證
  $('#submit').click(function(){

	if($('#OrdType_1').val()==0 && $('#OrdType_2').val()==0){
		alert('請確認申請類別');
		return false;
	}
	if($('#Tax_1').val()==0 && $('#Tax_2').val()==0){
		alert('請確認稅別');
		return false;
	}
  });
  
  $('#btn_Tax_1').click(function(){
	  S_TAX($("#STK_NET").val());
  });
  $('#btn_Tax_2').click(function(){
	  S_TAX($("#STK_NET").val());
  });
  
  $('#FSform').validationEngine();
});
</script>

