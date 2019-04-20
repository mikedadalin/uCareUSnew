<?php
if(substr($_SESSION['ncareID_lwj'],0,8)=="resident"){
$HospNo = substr($_SESSION['ncareID_lwj'],8,6);
$db = new DB;
$db->query("SELECT `patientID` FROM `patient` WHERE `HospNo`='".mysql_escape_string($HospNo)."'");
$r = $db->fetch_assoc();
$url = "index.php?mod=nurseform&func=formview&pid=".$r['patientID'];
echo "<script type='text/javascript'>";
echo 'window.location.href="'.$url.'"';
echo "</script>";
}else{
$url = explode("/",$_SERVER['PHP_SELF']);
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
	$bedID = $r1['bed'];
	$db2 = new DB;
	$db2->query("SELECT `Qdiag1`, `Qdiag2`, `Qdiag3`, `Qdiag4`, `Qdiag5`, `Qdiag6`, `Qdiag7`, `Qdiag8` FROM `nurseform01` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1");
	$r2 = $db2->fetch_assoc();
	for ($j=1;$j<=8;$j++) { if ($r2['Qdiag'.$j]!=NULL) { $diagMsg .= $r2['Qdiag'.$j].', '; } }
		$diagMsg = substr($diagMsg, 0, strlen($diagMsg)-2);
}
$db_remind = new DB;
$db_remind->query("SELECT * FROM `reminder` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `remindDate` LIKE '".date('Y/m')."%' AND `active`='1'");
for ($i=0;$i<$db_remind->num_rows();$i++) {
	$reminder = $db_remind->fetch_assoc();
	if ($marqueetext != "") { $marqueetext .= ' ||| '; }
	$marqueetext .= '['.$reminder['remindDate'].'] '.$reminder['remindContent'];
}
?>

<div onclick="closecol();">
<div class="content-query2" ondblclick="closeResidentCol();">
	<table align="center" style=" width:100%; font-size:10pt; margin: 0px 0px;">
		<tr id="backtr"  style="border:none; height:28px;" >
			<?php
			if (@$_GET['id']!=NULL) {
				if ($_SESSION['ncareGroup_lwj']!=4) {
					echo '<td class="backbtnn" align="center" width="40" id="backbtn"  style="border:none;" rowspan="3"><a href="index.php?mod=nurseform&func=formview&pid='.mysql_escape_string($_GET['pid']).'">'.$word_Back.'</a></td>';
				} else {
					echo '<td class="backbtnn" align="center" bgcolor="#ffffff" width="40" id="backbtn"  style="border:none;" rowspan="3"><a href="index.php?func=medlist" style="font-size:14px;">Resident List</a></td>';
				}
			}else{
				if ($_SESSION['ncareGroup_lwj']!=4) {
					echo '<td class="backbtnn" align="center" width="40" id="backbtn"  style="border:none;" rowspan="3"><a href="index.php?func=patientlist" style="font-size:14px;">Resident List</a></td>';
				} else {
					echo '<td class="backbtnn" align="center" bgcolor="#ffffff" width="40" id="backbtn"  style="border:none;" rowspan="3"><a href="index.php?func=medlist" style="font-size:14px;">Resident List</a></td>';
				}
			}
			?>
			<td class="title" width="80" style="border-top-left-radius:10px; background-color:#EECB35;"><?php echo $word_Bed; ?></td>
			<td width="80" style="border:none; padding-left: 10px;"><?php echo $bedID; ?></td>
			<td class="title" width="60" style="border:none;"><?php echo $word_Name; ?></td>
			<td width="160" style="border:none; padding-left: 10px;"><?php echo $name; ?></td>
			<td class="title" width="70" style="border:none;"><?php echo $word_CareID; ?></td>
			<td width="90" style="border:none; padding-left: 10px;"><?php echo getHospNoDisplayByHospNo($HospNo); ?></td>
			<td width="100" class="title" style="border:none;"><?php echo $word_AdmissionDate; ?></td>
			<td width="80" style="border:none; padding-left: 10px;"><?php echo $indate; ?></td>    
			<td class="title" width="70" style="border:none;"><?php echo $word_DOB; ?></td>
			<td width="170" style="border-top-right-radius:10px; padding-left: 10px;"><?php echo $birth.' ('.checkgender(mysql_escape_string($_GET['pid'])).', '.calcage(str_replace('/','',$birth)).')'; ?></td>
		</tr>
		<tr style="border:none; height:28px;" >  <!-- 診斷 + Jump to + 時間 + Print -->
			<?php
			if ($db_remind->num_rows()>0) {
				echo '
				<td class="title" style="background-color:#b79810;">'.$word_Diagnosis.'</td>
				<td style="padding-left: 10px;" colspan="9">'.$diagMsg.'</td>
				';
			}else{
				echo '<td class="title" style="background-color:#b79810; border-bottom-left-radius:10px;">'.$word_Diagnosis.'</td>';
				if(substr($url[3],0,5)!="print"){
					if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){
						echo '
						<td style="=padding-left: 10px;" colspan="7">'.$diagMsg.'</td>
						<td style="border-bottom-right-radius:10px; padding-left: 5px;" colspan="2">';
						?><input class="residentListButton" type="button" onclick="$('#ResidentCol').show('slide', {direction: 'left'}, 500);" value="Resident List"><?php
					    $db5 = new DB;
					    $db5->query("SELECT `round` FROM `nurserounds` WHERE `HospNo`='".$HospNo."' AND `date`='".date(Ymd)."' AND `Qfiller`='".$_SESSION['ncareID_lwj']."'");
					    if($db5->num_rows()>0){
						    echo '&nbsp;<button id="CheckRound_OFF_'.$_GET['pid'].'"><i id="CheckRound_OFF_'.$_GET['pid'].'_icon" class="fa fa-check-square-o"></i></button>';
					    }else{
						    echo '&nbsp;<button id="CheckRound_ON_'.$_GET['pid'].'"><i id="CheckRound_ON_'.$_GET['pid'].'_icon" class="fa fa-square-o"></i></button>';
					    }
						echo '
						</td>';
					}else{
						echo'
						<td style="border-bottom-right-radius:10px; padding-left: 10px;" colspan="9">'.$diagMsg.'</td>';
					}
				}else{
					echo'
					<td style="border-bottom-right-radius:10px; padding-left: 10px;" colspan="9">'.$diagMsg.'</td>';
				}
			}
			?>
		</tr>
		<?php      /* 備忘錄 + Jump to + 時間 + Print */
		if ($db_remind->num_rows()>0) {
			if(substr($url[3],0,5)!="print"){
				if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){
					echo '
					<tr class="printcol">
					<td class="title" width="70" style="border:none; background-color:#e87217; border-bottom-left-radius:10px;">'.$word_Reminders.'</td>
					<td style="border:none;" colspan="7"><marquee scrollamount="3">'.$marqueetext.'</marquee></td>
					<td style="border-bottom-right-radius:10px; padding-left: 5px;" colspan="2">';
					?><input class="residentListButton" type="button" onclick="$('#ResidentCol').show('slide', {direction: 'left'}, 500);" value="Resident List"><?php
					$db5 = new DB;
					$db5->query("SELECT `round` FROM `nurserounds` WHERE `HospNo`='".$HospNo."' AND `date`='".date(Ymd)."' AND `Qfiller`='".$_SESSION['ncareID_lwj']."'");
					if($db5->num_rows()>0){
						echo '&nbsp;<button id="CheckRound_OFF_'.$_GET['pid'].'"><i id="CheckRound_OFF_'.$_GET['pid'].'_icon" class="fa fa-check-square-o"></i></button>';
					}else{
						echo '&nbsp;<button id="CheckRound_ON_'.$_GET['pid'].'"><i id="CheckRound_ON_'.$_GET['pid'].'_icon" class="fa fa-square-o"></i></button>';
					}
					echo '
					</td>';
				}
			}
		}
		?>
	</table>
</div>
<?php  /* 表單下移 */
if($db_remind->num_rows()>0) {
	echo '<div id="printbtn2" style="padding-top:108px;"></div>';
}else{
	echo '<div id="printbtn2" style="padding-top:74px;"></div>';
}
?>
<div style="background-color:rgba(255,255,255,0.7); padding:10px; border-radius:10px;" onclick="closeResidentCol();">
<h3 style="background-color:rgba(255,255,255, 0.1); color:#3F3F3F; width:90%; margin-bottom:30px; border: 3px solid #3F3F3F; height:40px; line-height:40px; font-size:32px; font-weight: bold;">Rounds</h3>
<?php include('EasyWork.php'); ?>
</div>
</div>
<?php
if (substr($url[3],0,5)!="print") {
	echo '<div id="ResidentCol" align="left">';
	echo '<div align="center" style="background-color:#eecb35; border-radius:10px; padding:7px; margin-bottom:20px;"><font style="color:white; font-size:26px; font-weight:bold;">Resident List</font></div>';
	include("ResidentCol.php");
	echo '</div>';
	echo '<script type="text/javascript" src="js/closeResidentCol.js"></script>';
}
?>
<script type="text/javascript" src="js/LWJ_CheckRound.js"></script>
<?php }?>