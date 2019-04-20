<?php
$db = new DB;
$db->query("SELECT `patientID`,`HospNo`,`Birth` FROM `patient` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."'");
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	$db1 = new DB;
	$db1->query("SELECT `bed`,`indate` FROM `inpatientinfo` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."'");
	$r1 = $db1->fetch_assoc();
	$name = getPatientName($r['patientID']);
	$birth = formatdate($r['Birth']);
	$indate = formatdate($r1['indate']);
	$HospNo = $r['HospNo'];
	$db2 = new DB;
	$db2->query("SELECT `Qdiag1`, `Qdiag2`, `Qdiag3`, `Qdiag4`, `Qdiag5`, `Qdiag6`, `Qdiag7`, `Qdiag8` FROM `nurseform01` WHERE `HospNo`='".$HospNo."' ORDER BY `date` DESC LIMIT 0,1");
	$r2 = $db2->fetch_assoc();
	for ($j=1;$j<=8;$j++) { if ($r2['Qdiag'.$j]!=NULL) { $diagMsg .= $r2['Qdiag'.$j].', '; } }
	$diagMsg = substr($diagMsg, 0, strlen($diagMsg)-2);
}

if (isset($_POST['querydate'])) {
	$datestart = str_replace("/","",$_POST['startdate']);
	$dateend = str_replace("/","",$_POST['enddate']);
} elseif (@$_GET['startdate']!=NULL) {
	$datestart = mysql_escape_string($_GET['startdate']);
	$dateend = mysql_escape_string($_GET['enddate']);
} else {
	$thisyear = date(Y);
	$thismonth = date(m);	
	$lastmonth = $thismonth - 1;
	if ($lastmonth==0) { $lastmonth = '12'; $lastyear = $thisyear-1; } else { $lastyear = $thisyear; }
	if (strlen($thismonth)==1) { $thismonth = "0".$thismonth; }
	if (strlen($lastmonth)==1) { $lastmonth = "0".$lastmonth; }
	$datestart = $lastyear.$lastmonth.'20';
	$dateend = $thisyear.$thismonth.'19';
}
if (isset($_POST['saveinvoice'])) {
	$no = $_POST['staticfeeno'] + $_POST['monthlyfeeno'] + 4;
	for ($i=0;$i<$no;$i++) {
		if (trim($_POST['Q2_'.$i])!="") { $Q2text .= $_POST['Q2_'.$i].':'.$_POST['Q2fee_'.$i].';'; }
	}
	$c3no = $_POST['consump3no'];
	for ($i=0;$i<$c3no;$i++) {
		if (trim($_POST['Q3_'.$i])!="") { $Q3text .= $_POST['Q3_'.$i].':'.$_POST['Q3a_'.$i].':'.$_POST['Q3b_'.$i].';'; }
	}
	$db = new DB;
	$db->query("SELECT * FROM `feeinvoice` WHERE `HospNo`='".$HospNo."' AND `startdate`='".$datestart."' AND `enddate`='".$dateend."'");
	if ($db->num_rows()>0) {
		$db1 = new DB;
		$db1->query("UPDATE `feeinvoice` SET `Q1`='".mysql_escape_string($_POST['Q1'])."', `Q2`='".$Q2text."', `Q3`='".$Q3text."', `Q4`='".mysql_escape_string($_POST['Q4'])."', `Q5`='".mysql_escape_string($_POST['Q5'])."', `Q5date`='".mysql_escape_string($_POST['Q5date'])."', `Q6`='".mysql_escape_string($_POST['Q6'])."', `Q6date`='".mysql_escape_string($_POST['Q6date'])."', `Q7`='".mysql_escape_string($_POST['Q7'])."', `Q8`='".mysql_escape_string($_POST['Q8'])."', `Q9`='".mysql_escape_string($_POST['Q9'])."', `Q10`='".mysql_escape_string($_POST['Q10'])."' WHERE `HospNo`='".$HospNo."' AND `startdate`='".$datestart."' AND `enddate`='".$dateend."'");
	} else {
		$db2 = new DB;
		$db2->query("INSERT INTO `feeinvoice` VALUES ('".$HospNo."', '".mysql_escape_string($_GET['startdate'])."', '".mysql_escape_string($_GET['enddate'])."', '".mysql_escape_string($_POST['Q1'])."', '".$Q2text."', '".$Q3text."', '".mysql_escape_string($_POST['Q4'])."', '".mysql_escape_string($_POST['Q5'])."', '".mysql_escape_string($_POST['Q5date'])."', '".mysql_escape_string($_POST['Q6'])."', '".mysql_escape_string($_POST['Q6date'])."', '".mysql_escape_string($_POST['Q7'])."', '".mysql_escape_string($_POST['Q8'])."', '".mysql_escape_string($_POST['Q9'])."', '".mysql_escape_string($_POST['Q10'])."', '".$_SESSION['ncareID_lwj']."')");
	}
}
?>

<div style="background-color: rgba(255,255,255,0.8); border-radius: 10px; padding:10px 10px 30px 10px; margin-bottom: 30px;">
<h3>住民收費明細紀錄表</h3>

<div style="background-color: rgba(255,255,255,0.8); border-radius: 10px; padding:10px; margin-bottom: 10px; height:40px; line-height:40px;">
	<div width="420px" style="float:left;">
		<form action="index.php?mod=management&func=formview&id=1_1&pid=<?php echo mysql_escape_string($_GET['pid']); ?>" method="post">
查詢日期：<script> $(function() { $( "#startdate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); $(function() { $( "#enddate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" id="startdate" name="startdate" value="<?php if (isset($_POST['querydate']) || @$_GET['startdate']!=NULL) { echo formatdate($datestart); } else { echo date("Y/m/d",strtotime("-1 month")); } ?>" size="12" /> ~ <input type="text" id="enddate" name="enddate" value="<?php if (isset($_POST['querydate']) || @$_GET['enddate']!=NULL) { echo formatdate($dateend); } else { echo formatdate(date(Ymd)); } ?>" size="12" /> <input type="submit" value="Search" name="querydate" /></form>
	</div>
	<div style="float:left; margin-top:9px;">
		<a href="print.php?<?php echo $_SERVER['QUERY_STRING']; ?>&startdate=<?php echo $datestart; ?>&enddate=<?php echo $dateend; ?>" target="_blank"><img src="Images/print.png" border="0"></a>
	</div>
	<div width="120px" style="float:right; margin-top:5px;">
		<form><input type="button" onclick="window.location.href='index.php?func=editpatientfee&pid=<?php echo @$_GET['pid']; ?>'" value="固定費用設定"></form>
	</div>
	<div width="12px" style="float:right; margin-top:5px;">
		<form><input type="button" onclick="window.location.href='index.php?func=editmonthlyfee&pid=<?php echo @$_GET['pid']; ?>'" value="每月費用輸入"></form>
	</div>
</div>

<!-- Old Layout of the above section

<table border="0" id="printbtn">
  <tr>
    <td bgcolor="#ffffff" width="420px"><form action="index.php?mod=management&func=formview&id=1_1&pid=<?php echo mysql_escape_string($_GET['pid']); ?>" method="post">
查詢日期：<script> $(function() { $( "#startdate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); $(function() { $( "#enddate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" id="startdate" name="startdate" value="<?php if (isset($_POST['querydate']) || @$_GET['startdate']!=NULL) { echo formatdate($datestart); } else { echo date("Y/m/d",strtotime("-1 month")); } ?>" size="12" /> ~ <input type="text" id="enddate" name="enddate" value="<?php if (isset($_POST['querydate']) || @$_GET['enddate']!=NULL) { echo formatdate($dateend); } else { echo formatdate(date(Ymd)); } ?>" size="12" /> <input type="submit" value="Search" name="querydate" /></form></td>
    <td bgcolor="#ffffff" width="120px"><form><input type="button" onclick="window.location.href='index.php?func=editpatientfee&pid=<?php echo @$_GET['pid']; ?>'" value="固定費用設定"></form></td>
    <td bgcolor="#ffffff" width="12px"><form><input type="button" onclick="window.location.href='index.php?func=editmonthlyfee&pid=<?php echo @$_GET['pid']; ?>'" value="每月費用輸入"></form></td>
    <td bgcolor="#ffffff"><p align="right"><a href="print.php?<?php echo $_SERVER['QUERY_STRING']; ?>&startdate=<?php echo $datestart; ?>&enddate=<?php echo $dateend; ?>" target="_blank"><img src="Images/print.png" border="0"></a></p></td>
  </tr>
</table>
-->


<div class="content-query">
<table align="center" width="880">
  <tr>
  	<td colspan="6" class="title">
  		<form action="index.php?mod=management&func=formview&id=1_1&pid=<?php echo @$_GET['pid']; ?>&startdate=<?php echo $datestart; ?>&enddate=<?php echo $dateend; ?>" method="post">
  			<?php
  			echo '計費日期：'.formatdate($datestart).' ~ '.formatdate($dateend);
  			?>
  		</td>
  </tr>
  <tr>
    <td class="title" width="60"><p>Bed #</p></td>
    <td width="80" style="padding-left:10px;"><?php echo $r1['bed']; ?></td>
    <td class="title" width="60">Full name</td>
    <td width="80" style="padding-left:10px;"><?php echo $name; ?></td>
    <td class="title" width="60">Admission date</td>
    <td width="80" style="padding-left:10px;"><?php echo $indate; ?></td>
  </tr>
  <tr>
    <td class="title"><p>保證金</p></td>
    <td style="padding-left:10px;"><input type="text" name="Q1" id="Q1" value="<?php if ($Q1=="") { echo "20000"; } else { echo $Q1; } ?>" size="6" /></td>
    <td class="title">Swing bed/簽約</td>
    <td colspan="5" >&nbsp;</td>
  </tr>
</table>
</div>
    
<hr>
<table width="880">
  <tr>
    <td colspan="2" class="title">應收帳款/代收款項</td>
  </tr>
  <tr>
    <td class="title_s">基本費用</td>
    <td class="title_s">每月費用</td>
  </tr>
  <tr>
    <td valign="top">
    <table style="width:430px;">
        <?php
		$totalfee = 0;
		$db1 = new DB;
		$db1->query("SELECT * FROM `staticfee` WHERE `HospNo`='".$HospNo."'");
		for ($i=0;$i<$db1->num_rows();$i++) {
			$r1 = $db1->fetch_assoc();
			echo '<tr>';
			echo '<td valign="top"><input type="text" name="Q2_'.$i.'" id="Q2_'.$i.'" value="'.$r1['feeName'].'" size="25" /></td>';
			echo '<td valign="top">';
			if ($r1['minus']==1) { $prefix='-'; $totalfee -= $r1['fee']; } else { $prefix=''; $totalfee += $r1['fee']; }
			echo '$ <input type="text" name="Q2fee_'.$i.'" id="Q2fee_'.$i.'" value="'.$prefix.$r1['fee'].'" size="5" /></td>';
			echo '</tr>';
		}
		
		$db2 = new DB;
		$db2->query("SELECT * FROM `monthlyfee` WHERE `HospNo`='".$HospNo."' AND `date`<='".$dateend."' AND `date`>'".$datestart."' ORDER BY `feeID` ASC");
		for ($i=0;$i<$db2->num_rows();$i++) {
			$no = $i+1+$db1->num_rows();
			$r2 = $db2->fetch_assoc();
			echo '<tr>';
			echo '<td valign="top"><input type="text" name="Q2_'.$no.'" id="Q2_'.$no.'" value="'.$r2['feeName']; if ($r2['memo']!=NULL) { echo ' ('.$r2['memo'].')'; } echo '" size="25" />';
			echo '</td>';
			echo '<td valign="top">';
			if ($r2['minus']==1) { $prefix='-'; $totalfee -= $r2['fee']; } else { $prefix=''; $totalfee += $r2['fee']; }
			echo '$ <input type="text" name="Q2fee_'.$no.'" id="Q2fee_'.$no.'" value="'.$prefix.$r2['fee'].'" size="5" /></td>';
			echo '</tr>';
		}
		for ($i=($db1->num_rows()+$db2->num_rows());$i<=($db1->num_rows()+$db2->num_rows()+3);$i++) {
			echo '<tr>';
			echo '<td valign="top"><input type="text" name="Q2_'.$i.'" id="Q2_'.$i.'" value="" size="25" /></td>';
			echo '<td valign="top">';
			echo '$ <input type="text" name="Q2fee_'.$i.'" id="Q2fee_'.$i.'" value="" size="5" /></td>';
			echo '</tr>';
		}
		echo '<input type="hidden" name="staticfeeno" id="staticfeeno" value="'.$db1->num_rows().'" />';
		echo '<input type="hidden" name="monthlyfeeno" id="monthlyfeeno" value="'.$db2->num_rows().'" />';
		?>
    </table>
    </td>
    <td valign="top">
    <table style="width:430px;">
        <?php
		$db3 = new DB;
		$db3->query("SELECT * FROM `consumpform03_1` WHERE `HospNo`='".$HospNo."' AND `date`<='".$dateend."' AND `date`>'".$datestart."'");
		for ($i=0;$i<$db3->num_rows();$i++) {
			$r3 = $db3->fetch_assoc();
			$db3a = new DB;
			$db3a->query("SELECT * FROM `consump_pricing` WHERE `itemID`='".$r3['itemID']."'");
			$r3a = $db3a->fetch_assoc();
			echo '<tr>';
			echo '<td valign="top"><input type="text" name="Q3_'.$i.'" id="Q3_'.$i.'" value="'.$r3a['itemName'].' ('.formatshortdate($r3['date']).')" size="25" /></td>';
			echo '<td valign="top"><input type="text" name="Q3a_'.$i.'" id="Q3a_'.$i.'" value="'.$r3['quantity'].'" size="1" />'.$r3a['itemUnit'].'</td>';
			echo '<td valign="top">$ <input type="text" name="Q3b_'.$i.'" id="Q3b_'.$i.'" value="'.($r3a['itemPrice']*$r3['quantity']).'" size="4" /></td>';
			echo '</tr>';
			$totalfee += $r3a['itemPrice']*$r3['quantity'];
		}
		$db4 = new DB;
		$db4->query("SELECT * FROM `vitalsigns` WHERE `PersonID`='".mysql_escape_string($_GET['pid'])."' AND (`LoincCode`='14743-9' OR `LoincCode`='15075-5')  AND (`RecordedTime` >= '".substr($datestart,0,4).'-'.substr($datestart,4,2).'-'.substr($datestart,6,2)."' AND `RecordedTime` <= '".substr($dateend,0,4).'-'.substr($dateend,4,2).'-'.substr($dateend,6,2)."')");
		for ($i=0;$i<$db4->num_rows();$i++) {
			$no = $i+1+$db3->num_rows();
			$r4 = $db4->fetch_assoc();
			$r4date = str_replace("-","",substr($r4['RecordedTime'],0,10));
			if ($r4date>$datestart && $r4date<$dateend) {
				
			}
			echo '<tr>';
			echo '<td valign="top"><input type="text" name="Q3_'.$no.'" id="Q3_'.$no.'" value="血糖測試費 ('.formatshortdate($r4date).')" size="25" /></td>';
			echo '<td valign="top"><input type="text" name="Q3a_'.$no.'" id="Q3a_'.$no.'" value="1" size="1" /> Time(s)</td>';
			echo '<td valign="top">$ <input type="text" name="Q3b_'.$no.'" id="Q3b_'.$no.'" value="50" size="4" /></td>';
			echo '</tr>';
			$totalfee += 50;
		}
		echo '<input type="hidden" name="consump3no" id="consump3no" value="'.($db3->num_rows() + $db4->num_rows()).'" />';
		?>
    </table>
    </td>
  </tr>
</table><hr>
<table width="880">
  <tr>
    <td class="title"></td>
    <td class="title">Amount of fee</td>
    <td class="title">收款日</td>
    <td class="title">方式</td>
    <td class="title">Amount of fee</td>
  </tr>
  <tr>
    <td width="192" class="title">應收自費</td>
    <td width="192" style="padding-left:10px;"><input type="text" name="Q4" id="Q4" value="<?php echo $totalfee; ?>" size="5" /></td>
    <td width="192" style="padding-left:10px;">&nbsp;</td>
    <td width="192" class="title">現金</td>
    <td width="192" style="padding-left:10px;"><input type="text" name="Q7" id="Q7" value="<?php if ($Q7==NULL) { echo '0'; } else { echo $Q7; } ?>" size="5" /></td>
  </tr>
  <tr>
    <td class="title">Subsidy</td>
    <td style="padding-left:10px;"><input type="text" name="Q5" id="Q5" value="<?php if ($Q5==NULL) { echo '0'; } else { echo $Q5; } ?>" size="5" /></td>
    <td style="padding-left:10px;"><script> $(function() { $( "#Q5date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" id="Q5date" name="Q5date" value="<?php echo date("Y/m/d"); ?>" size="12" /></td>
    <td class="title">匯款</td>
    <td style="padding-left:10px;"><input type="text" name="Q8" id="Q8" value="<?php if ($Q8==NULL) { echo '0'; } else { echo $Q8; } ?>" size="5" /></td>
  </tr>
  <tr>
    <td class="title">合計</td>
    <td style="padding-left:10px;"><input type="text" name="Q6" id="Q6" value="<?php echo $totalfee; ?>" size="5" /></td>
    <td style="padding-left:10px;"><script> $(function() { $( "#Q6date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" id="Q6date" name="Q6date" value="<?php echo date("Y/m/d"); ?>" size="12" /></td>
    <td class="title">支票</td>
    <td style="padding-left:10px;"><input type="text" name="Q9" id="Q9" value="<?php if ($Q9==NULL) { echo '0'; } else { echo $Q9; } ?>" size="5" /></td>
  </tr>
  <tr>
    <td colspan="3"></td>
    <td class="title">尚欠金額</td>
    <td style="padding-left:10px;"><input type="text" name="Q10" id="Q10" value="<?php if ($Q10==NULL) { echo '0'; } else { echo $Q10; } ?>" size="5" /></td>
  </tr>
</table> 
<center><input type="submit" name="saveinvoice" id="saveinvoice" value="Save" style="margin-top:30px;" /></center>
</form>
</div>
</body>
</html>
