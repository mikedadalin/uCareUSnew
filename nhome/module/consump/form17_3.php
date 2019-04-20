<?php
//模組名稱
$strModule = "feecreate";
$type = "AR";

if($_GET['pid'] == ""){
	$pID = "";
}else{
	$pID = mysql_escape_string(getHospNo($_GET['pid']));
}

if($_POST['area']<>''){
	$strQry = " and date1='".mysql_escape_string($_POST['area'])."'";
}
if(mysql_escape_string($_GET['t'])=='dis'){
	$db1 = new DB;
	$db2 = new DB;
	$db3 = new DB;
	$db4 = new DB;
	$db1->query("select * from feeinfo where receiptID='".mysql_escape_string($_GET['reID'])."'");
	if($db1->num_rows() >0){
		for($i1=0;$i1<$db1->num_rows();$i1++){
			$rs1 = $db1->fetch_assoc();
			$type = substr($rs1['firmStockID'],0,2);
			$STK_Date = substr($rs1['firmStockID'],2,4);
			$firmStockID = substr($rs1['firmStockID'],6,4);
			echo $type.'-'.$STK_Date.'-'.$firmStockID.'<br>';
			$db2->query("UPDATE firmstock SET isStatus='M' where firmStockID='".$firmStockID."' and RIGHT(EXTRACT(YEAR_MONTH FROM `STK_Date` ),4)='".$STK_Date."' and type='".$type."' and isStatus='P'");
			$db3->query("UPDATE firmstockinfo SET isStatus='M' where firmStockID='".$firmStockID."' and RIGHT(EXTRACT(YEAR_MONTH FROM `STK_Date` ),4)='".$STK_Date."' and type='".$type."' and isStatus='P'");			
		}
	}
	$db4->query("UPDATE feecreate SET status='D' WHERE receiptID='".mysql_escape_string($_GET['reID'])."'");
	if(mysql_escape_string($_GET['re'])=='17_5'){
		echo '<script>window.location="index.php?mod=consump&func=formview&id=17_5&reID='.$_GET['reID'].'&pid='.$_GET['pid'].'";</script>';
	}
	
}
?>
<h3><?php echo getPatientName(getpID($pID)); ?>-payment record</h3>
<div class="content-query">
<table>
  <tr class="title">
    <td colspan="2">Filter condition</td>
  </tr>
  <tr>
    <td width="120" class="title"><center><b>Month select</b></center></td>
    <td align="left">
      <form method="post">
      <select name="area">
      <option></option>
      <?php
	  $qArea = new DB;
	  $qArea->query("SELECT distinct(date1) dd FROM `feecreate` WHERE HospNo='".$pID."' ORDER BY `date1` DESC");
	  for ($i=0;$i<$qArea->num_rows();$i++) {
		  $rArea = $qArea->fetch_assoc();
		  echo '<option value="'.$rArea['dd'].'" '.($_POST['area']==$rArea['dd']?"selected":"").'>'.substr($rArea['dd'],0,4).'/'.substr($rArea['dd'],4,2).'</option>'."\n";
	  }
	  ?>
      </select>&nbsp;
      <input type="submit" value="Search" /></form>
    </td>
  </tr>
</table>
</div>
<form name="FSform" id="FSform" method="post">
<div class="content-table">
<?php 
$db = new DB;
$db->query("select * from `".$strModule."` where HospNo='".$pID."' and status<>'Y' ".$strQry."");
?>
<table border="0">
  <tr>
    <td class="title" colspan="3">Pending/unpaid bill</td>
  </tr>
  <tr>
    <td class="title">Receipt No.</td>
    <td class="title">Amount of fee</td>
    <td class="title">Function</td>
  </tr>
  <?php
  if($db->num_rows()>0){
  for($i=0;$i<$db->num_rows();$i++){
	  $rs = $db->fetch_assoc();
	  echo '<tr>
		<td width="160" align="center">'.$rs['receiptID'].'</td>
		<td align="center">'.($rs['fee1']+$rs['fee2']+$rs['fee3']+$rs['fee4']).'</td>
		<td>';
		if($rs['status']=='N'){
		echo '<input type="button" value="Reverse the entry" name="setting" onclick="window.location.href=\'index.php?mod=consump&func=formview&id=17_4&reID='.$rs['receiptID'].'&pid='.getpID($rs['HospNo']).'\';">';
		}else{
			echo 'Voided';
		}
		echo '</td>
	  </tr>';
  }
  }else{
	  echo '<td align="center" colspan="3">No data of pending payment</td>';
  }
  ?>
</table>

<?php 

$db = new DB;
$db->query("select * from `".$strModule."` where HospNo='".$pID."' and status='Y' ".$strQry." order by receiptID Desc LIMIT 0 , 5");
if($db->num_rows() >0){
?>
<hr>
<table border="0">
  <tr>
    <td class="title" colspan="3">Paid</td>
  </tr>
  <tr>
    <td class="title">Receipt No.</td>
    <td class="title">Amount of fee</td>
    <td class="title">Function</td>
  </tr>
  <?php
  for($i=0;$i<$db->num_rows();$i++){
	  $rs = $db->fetch_assoc();
	  echo '<tr>
		<td width="160" align="center">'.$rs['receiptID'].'</td>
		<td align="center">'.($rs['fee1']+$rs['fee2']+$rs['fee3']+$rs['fee4']).'</td>
		<td>
		<input type="button" value="Print" onclick="printR(\''.$rs['receiptID'].'\',\''.getpID($rs['HospNo']).'\');">
		<input type="button" value="View" onclick="window.location.href=\'index.php?mod=consump&func=formview&reID='.$rs['receiptID'].'&pid='.getpID($rs['HospNo']).'&t=view&id=17_4\';">';
		if(calcperiod(str_replace("-","",$rs['date']),date(Ymd))<=30){
			echo '<input type="button" value="Void" onclick="disable(\''.$rs['receiptID'].'\',\''.getpID($rs['HospNo']).'\',\''.$_GET['re'].'\');">';
		}
		echo '</td>
	  </tr>';
  }
  ?>
</table>
<?php }?>
</div>
<center>
    <input style="margin-top:20px" type="button" id="cmdBack" name="cmdBack" value="Back to list" onclick="location.href='index.php?mod=consump&func=formview&id=17'" />
</center>
</form>
<script language="javascript">

$(function() {
	var chkID = '<?php echo $pID;?>';
	if(chkID!=""){
		showPatient();
	}
});
function printR(t,t1){
	window.open('printReceipt<?php echo $_SESSION['ncareReceiptFormat_lwj']; ?>.php?reID='+t+'&pid='+t1);  
}
function disable(t,t1,t2){
	if(confirm('Confirm invaliding receipt?')){
		window.location.href='index.php?mod=consump&func=formview&id=17_3&t=dis&reID='+t+'&pid='+t1+'&re='+t2;
	}
}

</script>

