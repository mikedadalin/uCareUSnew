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
$nowMonth = date("m", mktime(0,0,0,date(m)-1,1,date(Y)));
$nowYear = date("Y", mktime(0,0,0,date(m)-1,1,date(Y)));
$myMonth = date("m", mktime(0,0,0,date(m),1,date(Y)));
$myYear = date("Y", mktime(0,0,0,date(m),1,date(Y)))-1911;

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
	$db3d->query("INSERT INTO `feecreate` (`receiptID`,`date`,`date1`) VALUES ('".mysql_escape_string($_POST['receiptID'])."','".mysql_escape_string($_POST['date'])."','".mysql_escape_string($_POST['selmonth'])."')");
	foreach ($_POST as $k=>$v){
		if($k!="selmonth"){
			$db->query("UPDATE `feecreate` SET `".$k."` = '".$v."' WHERE receiptID='".mysql_escape_string($_POST['receiptID'])."' AND date='".mysql_escape_string($_POST['date'])."'");
		}
	}
	 echo "<script>alert('立帳成功，請沖帳!');window.location.href='index.php?mod=consump&func=formview&id=17_3&pid=".getPID($pID)."'</script>";
  }else{
	 echo "<script>alert('Data error!');window.location.href='index.php?mod=consump&func=formview&id=17'</script>";
  }
}
?>
<h3>Late payment</h3>
<form name="FSform" id="FSform" method="post">
<div class="content-table">
<table align="left"  width="100%" style="font-size:10pt; margin-left:0px;">
  <tr id="backtr"  >
    <td class="title" >Receipt No.</td>
    <td  align="left"><input type="text" value="<?php echo $type.date("ym").$fid; ?>" id="receiptID" name="receiptID" readonly="readonly"/></td>   
    <td class="title"  >Billing date</td>
    <td  align="left"><script> $(function() { $( "#STK_Date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php echo date("Y/m/d"); ?>" size="12" readonly></td>
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
    <td  align="left"><?php echo checkusername($_SESSION['ncareID_lwj']);?><input type="hidden" id="userID" name="userID" value="<?php echo $_SESSION['ncareID_lwj'];?>"></td>
  </tr>
</table>
<table width="100%" border="0">
  <tr>
    <td class="title" width="250px">Charge items</td>
    <td colspan="2" class="title">Amount of fee</td>
  </tr>
  <?php 
  $db1 = new DB;
  $db1->query("select * from feesetting where HospNo='".$pID."'");
  if ($db1->num_rows() > 0 ){
	  $r1 = $db1->fetch_assoc();
  }
  ?>
  <tr>
    <td width="200" class="title">Repay <select id="selmonth" name="selmonth" class="validate[required]">
<option></option>
<?php
$nextmonth = date(m)+1; if ($nextmonth>12) { $nextmonth = 1; $nextyear = date(Y)+1; } else { $nextyear = date(Y); }
if (strlen($nextmonth)==1) { $nextmonth = "0".$nextmonth; }
for ($i=date(m)-1;$i>=(date(m)-12);$i--) {
    $month = $i;
    if ($year==NULL) { $year = date(Y); }
    if ($i<1) {
        $month = 12+$i;
        $year = date(Y)-1;
    }
    if (strlen($month)==1) {
        $month = "0".$month;
    }
    echo '<option value="'.$year.$month.'"';
    if ($qdate==$year.'-'.$month) { echo ' selected'; }
    echo '>'.$year.'-'.$month.'</option>'."\n";
}
?>
</select>
    
    Monthly fee</td>
    <td width="160" colspan="2"  align="left"><input type="text" id="fee1" name="fee1" value="<?php echo $r1['self']+$r1['allowance'];?>" readonly="readonly">&nbsp;<a href="index.php?mod=consump&func=formview&id=17_1&pid=<?php echo getpID($pID);?>" target="_blank" title="View monthly fee">View monthly fee</a></td>
  </tr>
<!--  <tr>
    <td class="title"><?php echo ($nowYear-1911).'Year'.$nowMonth.' month';?> incidentals fee</td>
    <?php
/*	$db2 = new DB;
	$db2->query("SELECT SUM(`STK_TOT`) AS total FROM `firmstock` WHERE `firmID` = '".$pID."' and IsStatus='M' and type='SP'");
	$r2 = $db2->fetch_assoc();
	$db3 = new DB;
	$str0 = "SELECT *, RIGHT(EXTRACT(YEAR_MONTH FROM a.`STK_Date` ),4) ordDate FROM `firmstock` a inner join ";
	$str0 .=" `firmstockinfo` b on a.type=b.type and a.STK_Date=b.STK_Date and a.firmStockID=b.firmStockID ";
	$str0 .= "WHERE a.`type`='SP' AND a.IsStatus = 'M' and a.firmID='".$pID."'  order by a.STK_Date";//
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
	
*/    
if ($tmp == "") { $tmp = '0'; }
?>
    <td colspan="2"><input type="text" id="fee2" name="fee2" value="<?php //echo ($r2['total']-$tmp);?>" readonly="readonly"></td>
  </tr>
  <tr>
    <td class="title"><?php //echo ($nowYear-1911).'Year'.$nowMonth.' month';?> payment on center's behalf</td>
    <td colspan="2"><input type="hidden" id="fee3" name="fee3" value="<?php //echo $tmp;?>" readonly="readonly"></td>
  </tr>-->
  <input type="hidden" id="fee2" name="fee2" value="0" readonly="readonly">
  <input type="hidden" id="fee3" name="fee3" value="0" readonly="readonly">
  <tr>
    <td class="title">Other payment on other's behalf</td>
    <td colspan="2" align="left"><input type="text" id="fee4" name="fee4" class="validate[custom[integer]]"></td>
  </tr>
  <tr>
    <td class="title">Comment</td>
    <td colspan="2" align="left"><input type="text" id="mark" name="mark" value="" size="80"></td>
  </tr>
</table>
<table width="100%" border="0">
  <tr>
    <td class="title" width="120">Payment amount</td>
    <td width="160" align="left"><input type="text" id="total1" readonly></td>
    <td class="title" width="120">payment on center's behalf</td>
    <td width="160" align="left"><input type="text" id="total2" readonly></td>
    <td class="title" width="120">Amount on the receipt</td>
    <td width="160" align="left"><input type="text" id="total3" readonly></td>
  </tr>
</table>
<center>
	<div style="margin-top:20px;">
	    <input type="button" id="cmdBack" name="cmdBack" value="Back to list"  />
		<input type="submit" name="submit" id="submit" value="Billing" />
	</div>
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

$(function() {
	var chkID = '<?php echo $pID;?>';
	if(chkID!=""){
		showPatient();
	}
	//Back to list
	$('#cmdBack').click(function(){
	  location.href='index.php?mod=consump&func=formview&id=17' ;
	});
	$("#total1").val('<?php echo $r1['self']+$r1['allowance']+$r2['total'];?>');
	$("#total2").val('<?php echo $tmp;?>');
	$("#total3").val('<?php echo ($r1['self']+$r1['allowance'])+($r2['total']-$tmp);?>');
	
	$("#fee4").blur(function(){
		var tmp1  = parseInt('<?php echo $r1['self']+$r1['allowance']+$r2['total'];?>');
		var tmp2  = parseInt('<?php echo $tmp;?>');
		var ex = parseInt($("#fee4").val());
		if(isNaN(ex)){ex=0;}
		$("#total1").val(tmp1+ex);
		$("#total2").val(tmp2+ex);
		if($("#total1").val()!=0){
			$("#submit").show();
		}
	})
	if($("#total1").val()==0){
		$("#submit").hide();
	}
	$("#selmonth").change(function(){
	  $.ajax({
		  url: "class/feeCheck.php",
		  type: "POST",
		  data: { "PID": $("#HospNoDisplay").val(),"date1":$("#selmonth").val()},
		  success: function(data) {
			  var dataArr = data.split(';');			  
			  if(dataArr[0]=='1'){$("#submit").hide();alert(dataArr[1]);}else{$("#submit").show();}
		  }
	  });
	});
	if($("#total1").val()==0){$("#submit").hide();}else{$("#submit").show();}
$('#FSform').validationEngine();
});
</script>

