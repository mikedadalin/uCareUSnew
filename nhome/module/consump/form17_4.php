<?php
//模組名稱
$strModule = "feecreate";
$type = "AR";


if($_GET['pid'] == ""){
	$pID = "";
}else{
	$pID = mysql_escape_string(getHospNo($_GET['pid']));
}
$reID = mysql_escape_string($_GET['reID']);

$nowMonth = date("m");
$nowYear = date("Y");
$myMonth = date("m", mktime(0,0,0,$nowMonth-1,1,$nowYear));
$myYear = date("Y", mktime(0,0,0,$nowMonth-1,1,$nowYear))-1911;


//IsStatus N:Normal,M:關帳,C:Billing,P:Reverse the entry
if (isset($_POST['submit'])) {

  //讀寫資料
  if ($_POST['receiptID'] != NULL) {
	array_pop($_POST);
	$db3 = new DB;
	$db3a = new DB;
	$db3b = new DB;
	$db3c = new DB;
	$db3d = new DB;
	$str0 = "SELECT CONCAT(b.type,RIGHT(EXTRACT(YEAR_MONTH FROM a.`STK_Date` ),4) ,b.firmStockID) firmStockNO  ";
	$str0 .=" ,a.firmStockID, a.STK_Date, a.type ";
	$str0 .=" FROM `firmstock` a inner join `firmstockinfo` b on a.type=b.type and a.STK_Date=b.STK_Date and ";
	$str0 .=" a.firmStockID=b.firmStockID WHERE a.`type`='SP' AND a.IsStatus = 'C' and a.firmID='".$pID."' order by a.STK_Date";//
	//echo $str0;
	$db3->query($str0);
	for($i1=0;$i1<$db3->num_rows();$i1++){
	  $r3 = $db3->fetch_assoc();
	  //更新出貨單與明細的狀態
	  $db3b->query("UPDATE firmstock SET isStatus='P',userID='".mysql_escape_string($_POST['userID'])."' WHERE firmStockID='".$r3['firmStockID']."' and STK_Date='".$r3['STK_Date']."' and type='".$r3['type']."'");
	  $db3c->query("UPDATE  firmstockinfo SET isStatus='P',userID='".mysql_escape_string($_POST['userID'])."' WHERE firmStockID='".$r3['firmStockID']."' and STK_Date='".$r3['STK_Date']."' and type='".$r3['type']."'");	
	}
	
	//收據沖帳
	$db = new DB;
	$db->query("UPDATE `feecreate` SET `status` = 'Y', userID='".mysql_escape_string($_POST['userID'])."',pDate='".date("Y-m-d H:i:s")."' WHERE receiptID='".mysql_escape_string($_POST['receiptID'])."' AND date='".mysql_escape_string($_POST['date'])."'");
	$db4 = new DB;
	$db4->query("UPDATE `closedcase` SET feeclear=1 WHERE `patientID`='".getPID($pID)."'");
	
	 echo "<script>alert('沖帳成功!');window.location.href='index.php?mod=consump&func=formview&id=17_3&pid=".getPID($pID)."';</script>";
  }else{
	  echo "<script>alert('Data error!');window.location.href='index.php?mod=consump&func=formview&id=17_3&pid=".getPID($pID)."';</script>";
  }
}
$db = new DB;
$db->query("select * from `".$strModule."` where HospNo='".$pID."' and receiptID='".$reID."'");
$rs = $db->fetch_assoc();
?>
<h3>Reverse the entry</h3>
<form name="FSform" id="FSform" method="post">
<div class="content-table">
<table align="left"  width="100%" style="font-size:10pt; margin-left:0px;">
  <tr id="backtr"  >
    <td class="title" >Receipt No.</td>
    <td  align="left"><input type="text" value="<?php echo $rs['receiptID']; ?>" id="receiptID" name="receiptID" readonly="readonly"/></td>   
    <td class="title"  >Billing date</td>
    <td  align="left"><input type="text" name="date" id="date" value="<?php echo $rs['date']; ?>" size="12" readonly="readonly"></td>
    <td class="title"  >Bed #</td>
    <td colspan="2"  align="left"><input type="text" id="log4" name="log4" disabled="disabled"  /></td>
    </tr>
  <tr id="PatientTR"  style="border:none; height:20px;" >
    <td class="title" width="10%">Care ID#</td>
    <td align="left">
      <div id="FirmDiv" style="width:200px;"><input name="HospNo" type="hidden" id="HospNo" value="<?php echo $pID; ?>"/><input class="validate[required]" id="HospNoDisplay" type="text" readonly="readonly" value="<?php echo getHospNoDisplayByHospNo($pID); ?>"/></div></td>
    <td class="title"  >Resident's name</td>
    <td align="left"><input type="text" id="log0" name="log0" disabled="disabled"  /></td>
    <td class="title">Documented personnel</td>
    <td  align="left"><?php echo checkusername($rs['userID']);?><input type="hidden" id="userID" name="userID" value="<?php echo $_SESSION['ncareID_lwj'];?>"></td>
  </tr>
</table>
<table width="100%" border="0">
  <tr>
    <td class="title">Charge items</td>
    <td colspan="2" class="title">Amount of fee</td>
  </tr>
  <tr>
    <td width="200" class="title"><?php echo (substr($rs['date1'],0,4)-1911).'Year'.substr($rs['date1'],4,2).' month'; ?> monthly fee</td>
    <td width="160" colspan="2"  align="left"><input type="text" id="fee1" name="fee1" value="<?php echo $rs['fee1'];?>" readonly="readonly">&nbsp;<a href="index.php?mod=consump&func=formview&id=17_1&pid=<?php echo getpID($rs['HospNo']);?>" target="_blank" title="View monthly fee">View monthly fee</a></td>
  </tr>
  <?php
  $arrSortDate = array();
  $db1 = new DB;
  $db1->query("SELECT * FROM `feeinfo` WHERE `receiptID`='".$rs['receiptID']."' ORDER BY firmStockID");
  for($i1=0;$i1<$db1->num_rows();$i1++){
  	$rs1 = $db1->fetch_assoc();	 
	$type = substr($rs1['firmStockID'],0,2);
	$STK_Date1 = '20'.substr($rs1['firmStockID'],2,2);
	$STK_Date2 = substr($rs1['firmStockID'],4,2);
	$firmStockID = substr($rs1['firmStockID'],6,4);
	$db2 = new DB;
	$db2->query("SELECT STK_Date FROM `firmstock` WHERE `type`='".$type."' AND year(`STK_Date`)='".$STK_Date1."' AND month(`STK_Date`)='".$STK_Date2."' AND `firmStockID`='".$firmStockID."'");
	$rs2 = $db2->fetch_assoc();
	  array_push($arrSortDate, $rs2['STK_Date']);
  }
  sort($arrSortDate);
  $date1 = $arrSortDate[0];
  $date2 = $arrSortDate[count($arrSortDate)-1];
  if($rs['date2']!=""){
	  //getHospNoDisplayByPID()
  ?>
  <tr>
    <td class="title"><?php echo (substr($rs['date2'],0,4)-1911).'Year'.substr($rs['date2'],4,2).' month';?> incidentals fee</td>
    <td colspan="2" align="left"><input type="text" id="fee2" name="fee2" value="<?php echo $rs['fee2'];?>" readonly="readonly">
    <?php if($rs['fee2'] > 0){?>
    &nbsp;<a href="printReport.php?type=SP&date1=<?php echo $date1;?>&date2=<?php echo $date2;?>&FirmDiv=<?php echo getHospNoDisplayByHospNo($rs['HospNo']);?>" target="_blank">View Incidentals details</a>
    <?php }?>
    </td>
  </tr>
  <tr>
    <td class="title"><?php echo (substr($rs['date2'],0,4)-1911).'Year'.substr($rs['date2'],4,2).' month';?> payment on center's behalf</td>
    <td colspan="2" align="left"><input type="text" id="fee3" name="fee3" value="<?php echo $rs['fee3'];?>" readonly="readonly"></td>
  </tr>
  <?php }?>
  <tr>
    <td class="title">Other payment on other's behalf</td>
    <td colspan="2" align="left"><input type="text" id="fee4" name="fee4" value="<?php echo $rs['fee4'];?>" readonly="readonly"></td>
  </tr>
  <tr>
    <td class="title">Comment</td>
    <td colspan="2" align="left"><input type="text" id="mark" name="mark" value="<?php echo $rs['mark'];?>" size="80" readonly="readonly"></td>
  </tr>
</table>
<table width="100%" border="0">
  <tr>
    <td class="title" width="120">Payment amount</td>
    <td width="160" align="left"><?php echo ($rs['fee1']+$rs['fee2']+$rs['fee3']+$rs['fee4']);?></td>
    <td class="title" width="120">payment on center's behalf</td>
    <td width="160" align="left"><?php echo ($rs['fee3']+$rs['fee4']);?></td>
    <td class="title" width="120">Amount on the receipt</td>
    <td width="160" align="left"><?php echo $rs['fee1']+$rs['fee2'];?></td>
  </tr>
</table>

</div>
<br />&nbsp;
<center>
    <input type="button" id="cmdBack" name="cmdBack" value="Back to list"  />
    <?php
	if($_GET['t'] != 'view'){
    ?>
	<input type="submit" name="submit" id="submit" value="Reverse the entry" />
    <?php }?>
</center>
</form>
<script language="javascript">

function showPatient() {
  $.ajax({
	  url: "class/patient.php",
	  type: "POST",
	  data: { "PID": $("#HospNoDisplay").val()},
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
	var chkID = '<?php echo getpID($pID);?>';
	if(chkID!=""){
		showPatient();
	}
	
	//Back to list
	$('#cmdBack').click(function(){
	  location.href='index.php?mod=consump&func=formview&id=17_3&pid='+chkID ;
	});
	

});
</script>

