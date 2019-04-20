<?php
if (@$_GET['date']==NULL) {
	$thismonthYear = date(Y);
	$thismonthMonth = date(m);
	$thismonth = $thismonthYear.'Year'.$thismonthMonth.'Month';
	$lastmonth = date(m)-1;
	if ($lastmonth == 0) { $lastyear = date(Y)-1; $lastmonth = 12; } else { $lastyear = date(Y); }
	if (strlen($lastmonth)==1) { $lastmonth = '0'.$lastmonth; }
	$lastmonth = $lastyear.'Year'.$lastmonth.'Month';
} else {
	$thismonth = substr(@$_GET['date'],0,4).'Year'.substr(@$_GET['date'],4,2).'Month';
	$lastmonth = substr(@$_GET['date'],4,2)-1;
	if ($lastmonth == 0) { $lastyear = substr(@$_GET['date'],0,4)-1; $lastmonth = 12; } else { $lastyear = substr(@$_GET['date'],0,4); }
	if (strlen($lastmonth)==1) { $lastmonth = '0'.$lastmonth; }
	$lastmonth = $lastyear.'Year'.$lastmonth.'Month';
}
?>
<h3>Residents admission/discharge </h3>
<table style="width:100%;">
	<tr>
		<td height="40" width="40%" align="center" class="title"><?php echo $thismonth; ?></td>
		<td align="right" class="title" style="line-height:40px;">
			Select month : 
			<select id="selmonth" onchange="showdate()">
				<option>--Select month--</option>
				<?php
				for ($i=date(m);$i>=(date(m)-12);$i--) {
					$month = $i;
					$year = date(Y);
					if ($i<1) {
						$month = 12+$i;
						$year = date(Y)-1;
					}
					if (strlen($month)==1) {
						$month = "0".$month;
					}
					echo '<option value="'.$year.$month.'">'.$year.'-'.$month.'</option>'."\n";
				}
				?>
			</select>
			<script>
			function showdate() {
				var selectedmonth = document.getElementById('selmonth').value;
				window.open('index.php?mod=management&func=formview&pid=&id=25&date='+selectedmonth, '_self' );
			}
			</script>
			<a href="print.php?mod=management&func=formview&pid=&id=25&date=<?php echo $_GET['date']; ?>" target="_blank"><img style="position:relative; top:7px;" src="Images/print.png" /></a>
		</td>
	</tr>
</table>
<table cellpadding="7" style="width:100%;">
	<tr class="title">
		<td class="printcol">Edit</td>
		<td>Bed #</td>
		<td>Care ID#</td>
		<td>Full Name</td>
		<td>Absence Reasons(Hospitalize)</td>
		<td>Discharged Date</td>
		<td>Return Date</td>
		<td>Hospitalize Days</td>
		<td>Deductions Days</td>
		<td>Comment</td>
	</tr>
	<?php
	$db = new DB;
	$db->query("SELECT * FROM `sixtarget_part1` WHERE `lastoutdate` LIKE '".str_replace("Year","/",str_replace("Month","/",$thismonth))."%'");
	$arrList = array();
	for($i=0;$i<$db->num_rows();$i++) {
		$r = $db->fetch_assoc();
		if ($r['outdate']!="") {
			$arrList["T".$r['outdate'].'_'.$r['HospNo']]="T".$r['targetID'];
		} else {
			$arrList["T".$r['thisoutdate'].'_'.$r['HospNo']]="T".$r['targetID'];
		}
	}
	$db = new DB;
	$db->query("SELECT * FROM `general_io` WHERE `outdate` LIKE '".str_replace("Year","/",str_replace("Month","/",$thismonth))."%' OR `indate`='' OR `indate`='____/__/__'");
	for($i=0;$i<$db->num_rows();$i++) {
		$r = $db->fetch_assoc();
		$arrList["G".$r['outdate'].'_'.$r['HospNo']]="G".$r['general_IOID'];
	}
	ksort($arrList);
	foreach ($arrList as $k=>$v) {
		if (substr($v,0,1)=="T") {
			$db1 = new DB;
			$db1->query("SELECT * FROM `sixtarget_part1` WHERE `targetID`='".str_replace('T','',$v)."'");
			$r1 = $db1->fetch_assoc();
			$pid = getPID($r1['HospNo']);
			echo '
			<tr>
			<td class="printcol" align="center"><a href="index.php?mod=management&func=formview&id=3b_1&tID='.str_replace('T','',$v).'"><img src="Images/edit_icon.png" width="24"></a></td>
			<td nowrap align="center">'.getBedID($pid).'</td>
			<td nowrap align="center">'.getHospNoDisplayByPID($pid).'</td>
			<td nowrap align="center">'.getpatientname($pid).'</td>
			<td align="center">Resident transfer to ER</td>
			<td nowrap align="center">'.($r1['outdate']!=""?$r1['outdate']:$r1['thisoutdate']).'</td>
			<td nowrap align="center">'.$r1['lastoutdate'].'</td>
			<td nowrap align="center">'.$r1['outdays'].' Day(s)</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			</tr>'."\n";
		} elseif (substr($v,0,1)=="G") {
			$db1 = new DB;
			$db1->query("SELECT * FROM `general_io` WHERE `general_IOID`='".str_replace('G','',$v)."'");
			$r1 = $db1->fetch_assoc();
			$pid = getPID($r1['HospNo']);
			echo '
			<tr>
			<td class="printcol" align="center"><a href="index.php?mod=nurseform&func=formview&id=30_2&tID='.str_replace('G','',$v).'&pid='.$pid.'"><img src="Images/edit_icon.png" width="24"></a></td>
			<td nowrap align="center">'.getBedID($pid).'</td>
			<td nowrap align="center">'.getHospNoDisplayByPID($pid).'</td>
			<td nowrap align="center">'.getPatientName($pid).'</td>
			<td align="center">';
			if ($r1['reason_1']==1) { echo 'Return/visit home'; }
			elseif ($r1['reason_2']==1) { echo '出國'; }
			elseif ($r1['reason_3']==1) { echo '請假出門'; }
			elseif ($r1['reason_4']==1) { echo 'Hospitalization'; }
			echo ($r1['reasonOther']==""?"":'('.$r1['reasonOther'].')').'</td>
			<td nowrap align="center">'.$r1['outdate'].'</td>
			<td nowrap align="center">'.$r1['indate'].'</td>
			<td nowrap align="center">'.$r1['outdays'].' Day(s)</td>
			<td>&nbsp;</td>
			<td align="center">'.$r1['rmk'].'</td>
			</tr>'."\n";

		}
	}
	?>
	<tr>
		<td colspan="10" align="center">(Blank below)</td>
	</tr>
	<?php
	for($i2=$i;$i2<=10;$i2+=1) {
		echo '
		<tr>
		<td class="printcol">&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		</tr>'."\n";
	}
	?>
</table>
<font style="">&nbsp;※Sort by discharge date</font>
<table style="margin-top:30px; width:100%;">
	<tr>
		<td height="50" class="footer" width="100%" align="right" bgcolor="#ffffff" style="border:none; padding-right:10px;">Checked by:<div style="display:inline; border-bottom:1px solid #000; width:200px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Prepared by:<div style="display:inline; border-bottom:1px solid #000; width:200px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></td>
	</tr>
</table>