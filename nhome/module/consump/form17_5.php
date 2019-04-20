<?php
//模組名稱
$strModule = "feecreate";
$type = "AR";

//先取得最新收據編號
$db = new DB;
$db->query("SELECT count(*)+1 AS fid FROM `feecreate` WHERE YEAR(`date`)='".date("Y")."' and MONTH(`date`)='".date("m")."'");
if($db->num_rows() >0){
	$rs = $db->fetch_assoc();
	$fid = $rs['fid'];
	$fid = str_pad($fid,4,'0',STR_PAD_LEFT);
}

if($_GET['pid'] == ""){
	$pID = "";
}else{
	$pID = mysql_escape_string(getHospNo($_GET['pid']));
}

$reID = mysql_escape_string($_GET['reID']);
$db = new DB;
$db->query("select * from `".$strModule."` where HospNo='".$pID."' and receiptID='".$reID."'");
if($db->num_rows() > 0 ){
	$rs = $db->fetch_assoc();
	if($rs['status']=='Y'){ echo '<script>alert("請先將收據編號'.$reID.'作廢!");window.location="index.php?mod=consump&func=formview&id=17_3&pid='.$_GET['pid'].'&re=17_5";</script>';}
}else{
	echo '<script>alert("未有收據紀錄!");history.go(-1);</script>';
}
$nowMonth = date(substr($rs['date2'],4,2));
$nowYear = date(substr($rs['date2'],0,4))-1911;
$myMonth = date(substr($rs['date1'],4,2));
$myYear = date(substr($rs['date1'],0,4))-1911;



$db2 = new DB;
$db2->query("SELECT * FROM `closedcase` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."' ORDER BY `outdate` DESC LIMIT 0,1");
$r2 = $db2->fetch_assoc();

if (isset($_POST['submit'])) {
  //讀寫資料
  if ($_POST['HospNo'] != NULL) {
	array_pop($_POST);
	$db3 = new DB;
	$db3a = new DB;
	$db3b = new DB;
	$db3c = new DB;
	$db3d = new DB;
	$str0 = "SELECT CONCAT(b.type,RIGHT(EXTRACT(YEAR_MONTH FROM a.`STK_Date` ),4) ,b.firmStockID) firmStockNO  ";
	$str0 .=" ,a.firmStockID, a.STK_Date, a.type ";
	$str0 .=" FROM `firmstock` a inner join `firmstockinfo` b on a.type=b.type and a.STK_Date=b.STK_Date and ";
	$str0 .=" a.firmStockID=b.firmStockID WHERE a.`type`='SP' AND a.IsStatus = 'M' and a.firmID='".$pID."' order by a.STK_Date";//
	//echo $str0;
	$db3->query($str0);
	for($i1=0;$i1<$db3->num_rows();$i1++){
	  $r3 = $db3->fetch_assoc();
	  //記錄出貨單號與收據單號
	  $db3a->query("INSERT INTO feeinfo (receiptID,firmStockID) VALUES ('".mysql_escape_string($_POST['receiptID'])."','".$r3['firmStockNO']."')");
	  //更新出貨單與明細的狀態
	  $db3b->query("UPDATE firmstock SET isStatus='C' WHERE firmStockID='".$r3['firmStockID']."' and STK_Date='".$r3['STK_Date']."' and type='".$r3['type']."'");
	  $db3c->query("UPDATE  firmstockinfo SET isStatus='C' WHERE firmStockID='".$r3['firmStockID']."' and STK_Date='".$r3['STK_Date']."' and type='".$r3['type']."'");	
	}
	
	//建立收據
	$blah = $_POST['fee1']-$_POST['calcAmt'];
	$db3d->query("INSERT INTO `feecreate` (`receiptID`,`date`,`HospNo`,`fee1`,`fee2`,`fee3`,`fee4`,`userID`,`mark`,`date1`,`date2`) VALUES ('".mysql_escape_string($_POST['receiptID'])."','".mysql_escape_string($_POST['date'])."','".mysql_escape_string($_POST['HospNo'])."','".$blah."','".mysql_escape_string($_POST['fee2'])."','".mysql_escape_string($_POST['fee3'])."','".mysql_escape_string($_POST['fee4'])."','".mysql_escape_string($_POST['userID'])."','".mysql_escape_string($_POST['mark'])."','".mysql_escape_string($_POST['date1'])."','".mysql_escape_string($_POST['date2'])."')");

	 echo "<script>alert('Billing established!');window.location.href='index.php?mod=consump&func=formview&id=17'</script>";
  }else{
	 echo "<script>alert('Data error!');window.location.href='index.php?mod=consump&func=formview&id=17'</script>";
  }
}
?>
<h3>Receipt</h3>
<form name="FSform" id="FSform" method="post">
<div class="content-table">
<table align="left"  width="100%" style="font-size:10pt; margin-left:0px;">
  <tr id="backtr"  >
    <td class="title" >Receipt No.</td>
    <td ><input type="text" value="<?php echo $type.date("ym").$fid; ?>" id="receiptID" name="receiptID" readonly="readonly"/></td>   
    <td class="title"  >Billing date</td>
    <td ><script> $(function() { $( "#STK_Date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php echo date("Y/m/d"); ?>" size="12" readonly></td>
    <td class="title"  >入住區間</td>
    <td colspan="2" ><?php echo formatdate($r2['indate']); ?>～<?php echo formatdate($r2['outdate']); ?></td>
    </tr>
  <tr id="PatientTR"  style="border:none; height:20px;" >
    <td class="title" width="10%">Resident</td>
    <td>
      <div id="FirmDiv" style="width:200px;"><input name="HospNo" type="hidden" id="HospNo" value="<?php echo $pID; ?>"/><input class="validate[required]" id="HospNoDisplay" type="text" readonly="readonly" value="<?php echo getHospNoDisplayByHospNo($pID); ?>"/></div></td>
    <td class="title"  >Resident's name</td>
    <td><input type="text" id="log0" name="log0" disabled="disabled"  /></td>
    <td class="title">Documented personnel</td>
    <td ><?php echo checkusername($_SESSION['ncareID_lwj']);?><input type="hidden" id="userID" name="userID" value="<?php echo $_SESSION['ncareID_lwj'];?>"></td>
  </tr>
</table>
<table width="100%" border="0">
  <tr>
    <td class="title">Charge items</td>
    <td colspan="2" class="title">Amount of fee</td>
  </tr>
  <tr>
    <td width="200" class="title"><?php echo $myYear.'Year'.$myMonth.' month'; ?>已繳月費</td>
    <td width="160" colspan="2" ><input type="text" id="fee1" name="fee1" value="<?php echo $rs['fee1'];?>" readonly="readonly">&nbsp;<a href="index.php?mod=consump&func=formview&id=17_1&pid=<?php echo getpID($pID);?>" target="_blank" title="View monthly fee">View monthly fee</a></td>
  </tr>
  <tr>
    <td class="title">扣款天數方式</td>
    <td><div id="format">
    <?php $outdatemonthdays = date(t, strtotime(formatdate($r2['outdate']))); ?>
    <?php $outdate_day = date(d, strtotime(formatdate($r2['outdate']))); ?>
    <input type="radio" id="check1" name="check" value="30" checked onclick="calcDays();"><label for="check1">固定30天</label>
    <input type="radio" id="check2" name="check" value="<?php echo $outdatemonthdays; ?>"  onclick="calcDays();"><label for="check2">退住當月天數 (<?php echo $outdatemonthdays; ?>Day(s))</label>
    </div>
    </td>
  </tr>
  <tr>
    <td class="title">扣月費天數</td>
    <td>&nbsp;<input type="text" name="calcdays" id="calcdays" size="3" disabled> Day(s)</td>
  </tr>
  <tr>
    <td class="title">扣月費金額</td>
    <td>&nbsp;<input type="text" name="calcAmt" id="calcAmt" size="6" readonly> 元</td>
  </tr>  
  <tr>
    <td class="title"><?php //echo $nowYear.'Year'.$nowMonth.' month';?>應收雜費</td>
    <?php
	$db2 = new DB;
	$db2->query("SELECT SUM(`STK_TOT`) AS total FROM `firmstock` WHERE `firmID` = '".$pID."' and (IsStatus='M' OR IsStatus='N')");
	$r2 = $db2->fetch_assoc();
	$db3 = new DB;
	$str0 = "SELECT *, RIGHT(EXTRACT(YEAR_MONTH FROM a.`STK_Date` ),4) ordDate FROM `firmstock` a inner join ";
	$str0 .=" `firmstockinfo` b on a.type=b.type and a.STK_Date=b.STK_Date and a.firmStockID=b.firmStockID ";
	$str0 .= "WHERE a.`type`='SP' AND (a.IsStatus='M' OR a.IsStatus='N') and a.firmID='".$pID."'  order by a.STK_Date";//
	//echo $str0;
	$db3->query($str0);
	//echo $db3->num_rows();
	for($i=0;$i<$db3->num_rows();$i++){
		$r3 = $db3->fetch_assoc();
		if(substr($r3['STK_NO'],0,1)=='3'){
			$tmp += ($r3['QTY']*$r3['Price']);
		}
		if($i==0){
			$date1 = $r3['STK_Date'];
		}
		if($i==$db3->num_rows()-1){
			$date2 = $r3['STK_Date'];
		}
	}
	if ($tmp == "") { $tmp = '0'; }
    ?>
    <td colspan="2"><input type="text" id="fee2" name="fee2" value="<?php echo ($r2['total']-$tmp);?>" readonly="readonly">&nbsp;<a href="printReport.php?type=SP&date1=<?php echo $date1;?>&date2=<?php echo $date2;?>&FirmDiv=<?php echo $pID;?>" target="_blank">View Incidentals details</a></td>
  </tr>
  <tr>
    <td class="title"><?php //echo $nowYear.'Year'.$nowMonth.' month';?>應收代墊款</td>
    <td colspan="2"><input type="text" id="fee3" name="fee3" value="<?php echo $tmp;?>" readonly="readonly"></td>
  </tr>
  <tr>
    <td class="title">Other payment on other's behalf</td>
    <td colspan="2"><input type="text" id="fee4" name="fee4" class="validate[custom[integer]]" value="<?php echo $rs['fee4'];?>"></td>
  </tr>
  <tr>
    <td class="title">Comment</td>
    <td colspan="2"><input type="text" id="mark" name="mark" value="" size="80"></td>
  </tr>
</table>
<table width="100%" border="0">
  <tr>
    <td class="title" width="120">Payment amount</td>
    <td width="160"><input type="text" id="total1" readonly></td>
    <td class="title" width="120">payment on center's behalf</td>
    <td width="160"><input type="text" id="total2" readonly></td>
    <td class="title" width="120">Amount on the receipt</td>
    <td width="160"><input type="text" id="total3" readonly></td>
  </tr>
</table>
<br />&nbsp;
<center>
	<input type="hidden" id="date1" name="date1" value="<?php echo ($myYear+1911).$myMonth; ?>">
    <input type="hidden" id="date2" name="date2" value="<?php echo ($nowYear+1911).$nowMonth; ?>">
    <input type="button" id="cmdBack" name="cmdBack" value="Back to list"  />
	<input type="submit" name="submit" id="submit" value="Billing" />
</center>
</div>

</form>
<script language="javascript">

function showPatient() {
  $.ajax({
	  url: "class/patient.php",
	  type: "POST",
	  data: { "PID": $("#HospNoDisplay").val()},
	  success: function(data) {
		  //alert(data);
		  var dataArr = data.split(';');
		  for (i = 0; i < dataArr.length; i++){				
			  $( "#log"+i ).val( dataArr[i] );
		  }
		  oS_AMT(1);
	  }
  });
}
function calcDays() {
	var totalDays = 0;
	if ($("#check1").attr('checked')) {
		//固定30天
		totalDays = 30;
	} else if ($("#check2").attr('checked')) {
		//實際每月天數
		totalDays = $("#check2").val();
	}
	var fee1 = $("#fee1").val();
	var fee1pday = (Math.round(fee1 / totalDays)) * (totalDays - <?php echo $outdate_day; ?>);
	
	$("#calcdays").val((totalDays - <?php echo $outdate_day; ?>));
	$("#calcAmt").val(fee1pday);
	var newAmt = parseInt('<?php echo ($rs['fee1']+$rs['fee2'])+($r2['total']-$tmp);?>');	//Amount on the receipt
	var newAmt1 = parseInt($("#calcAmt").val());
	var newAmt2 = parseInt('<?php echo $rs['fee1']+$rs['fee2']+$r2['total'];?>')+parseInt($("#fee4").val()); //Payment amount
	$("#total1").val(newAmt2-newAmt1);
	$("#total3").val(newAmt-newAmt1);
}
$(function() {
	$("#format").buttonset();
	calcDays();
	var chkID = '<?php echo $pID;?>';
	if(chkID!=""){
		showPatient();
	}
	//Back to list
	$('#cmdBack').click(function(){
	  location.href='index.php?mod=consump&func=formview&id=17' ;
	});
	$("#total2").val('<?php echo $tmp+$rs['fee4'];?>');
	
	$("#fee4").blur(function(){
		var tmp1  = parseInt('<?php echo $rs['fee1']+$rs['fee2']+$r2['total'];?>');
		var tmp2  = parseInt('<?php echo $tmp;?>');
		var ex = parseInt($("#fee4").val());
		if(isNaN(ex)){ex=0;}
		$("#total1").val(tmp1+ex);
		$("#total2").val(tmp2+ex);
		if($("#total1").val()!=0){
			$("#submit").show();
		}
		calcDays();
	})
	if($("#total1").val()==0){
		$("#submit").hide();
	}
	
$('#FSform').validationEngine();
});
</script>

