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
?>
<?php
$preURL = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$_SESSION['preURL'] = $preURL;
?>
<div style="background-color:rgba(255,255,255,0.7); padding:10px; border-radius:10px;">
<?php
$d = new DateTime();
$d->modify("-30 day"); 
$td1 = $d->format('Ymd');
$db2 = new DB;
$db2->query("SELECT * FROM `nurseform05` WHERE `HospNo`='".$HospNo."' AND `date`>='".mysql_escape_string($td1)."' AND `date`<='".mysql_escape_string(date(Ymd))."' ORDER BY `date` DESC, `time` DESC LIMIT 5");
$db2a = new DB;
$db2a->query("SELECT * FROM `nursediagassess` WHERE `HospNo`='".$HospNo."' AND `assessdate`>='".mysql_escape_string($td1)."' AND `assessdate`<='".mysql_escape_string(date(Ymd))."'  ORDER BY `assessdate` DESC");

$arrRecord = array();
for ($i=0;$i<$db2->num_rows();$i++) {
	$r2 = $db2->fetch_assoc();
	$arrRecord[formatdate($r2['date']).' '.substr($r2['time'],0,2).':'.substr($r2['time'],2,2)][$i] = array($r2['date'], $r2['time'], $r2['Q2'], str_replace("\n","<br>",str_replace("\'","'",$r2['Qcontent'])), $r2['Qfiller'], '<a href="index.php?mod=nurseform&func=formview&id=5_1&pid='.$_GET['pid'].'&nID='.$r2['nID'].'&action=edit"><img src="Images/edit_icon.png" width="20" border="0"></a>', '<a href="index.php?mod=nurseform&func=formview&pid='.mysql_escape_string($_GET['pid']).'&id=5_1&nID='.$r2['nID'].'&action=delete"><img src="Images/delete2.png" border="0"></a>', '1');
}
for ($i2=0;$i2<$db2a->num_rows();$i2++) {
	$r2a = $db2a->fetch_assoc();
	$arrRecord[formatdate($r2a['assessdate'])][$i+$i2] = array($r2a['assessdate'], '', '#'.$r2a['diagno'].' '.$arrNursediag[$r2a['diagno']].' [護理診斷評值]', $r2a['text'], $r2a['Qfiller'], '<center><a href="index.php?mod=nursediag&func=formview&pid='.mysql_escape_string($_GET['pid']).'&id='.$r2a['diagno'].'&date='.str_replace('/','',$r2a['date']).'"><img src="Images/edit_icon.png" width="20" border="0"></a></center>', '', '2');
}
?>
<h3 align="center" style="width:100%;">Nursing record</h3>
<table width="100%" id="recordlist" cellpadding="10" style="text-align:center">
	<thead>
		<tr style="background-color:rgba(105,179,182,0.9); color:white; height:30px;">
			<td class="printcol" width="80">Function</td>
			<td width="120">Date and Time</td>
			<td width="240">Focusing Problem</td>
			<td>Record Content</td>
			<td width="60">Staff</td>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach ($arrRecord as $k1=>$v1) {
			foreach ($arrRecord[$k1] as $k=>$v) {
				echo '
				<tr '.($v[7]==2?'style="color:#000; background-color:rgba(255,255,255,0.8); height:30px;"':'style="background-color:rgba(255,255,255,0.8); height:30px;"').'>
				<td class="printcol" align="center">';
				if ($v[4]==$_SESSION['ncareID_lwj'] || $_SESSION['ncareLevel_lwj']>=4) {
					echo $v[5].' '.$v[6];
				} else {
					echo '&nbsp;';
				}
				echo '</td>
				<td>'.$k1.'</td>
				<td align="center">'.$v[2].'</td>
				<td>'.$v[3].'</td>
				<td align="center">'.checkusername($v[4]).'</td>
				</tr>
				'."\n";
			}
		}
		if($arrRecord=="" || $arrRecord==NULL){
			echo '<tr style="background-color:rgba(255,255,255,0.8); height:30px;"><td colspan="5"></td></tr>';
		}
		?>
	</tbody>
</table>
<form action="index.php?func=databaseAI&round=5" method="post" id="base99">
	<table width="100%" cellpadding="10" style="text-align:center;">
	    <tr height="30"><td style="background-color:rgba(105,179,182,0.9); color:white;" colspan="5">Add New Nursing Record</td></tr>
		<tr style="background-color:rgba(255,255,255,0.8);">
			<td style="background-color:rgba(105,179,182,0.9); color:white;" width="120">Date</td>
			<td><script>$(function() { $('#dateRound2').datepicker(); });</script>
			<input type="text" name="dateRound2" id="dateRound2" value="<?php echo date("Y/m/d"); ?>" size="12" > <input type="text" name="timeRound2" id="timeRound2" size="4" value="<?php echo date("Hi"); ?>" /></td>
		</tr>
		<tr style="background-color:rgba(255,255,255,0.8);">
			<td style="background-color:rgba(105,179,182,0.9); color:white;">Focus / problems (No.)</td>
			<td>
				<select onchange="if (this.selectedIndex==0) { document.getElementById('Q2Round2').value = ''; } else { document.getElementById('Q2Round2').value = this.value; }" >
					<option>(Choose nursing diagnosis has been filled, or at the bottom to fill nursing problems ...)</option>
					<?php
					$db3 = new DB;
					$db3->query("SELECT `HospNo` FROM `patient` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."'");
					$r3 = $db3->fetch_assoc();
					for ($i=1;$i<=28;$i++) {
						if (strlen($i)==1) { $num = '0'.$i; } else { $num = $i; }
						$db1 = new DB;
						$db1->query("SELECT * FROM `nursediag".$num."` WHERE `HospNo`='".$r3['HospNo']."' AND `Q2`=''");
						if ($db1->num_rows()>0) {
							echo '<option value="'.$i.'# '.$arrNursediag[$i].'">'.$i.'# '.$arrNursediag[$i].'</option>'."\n";
						}
					}
					?>
				</select>
				<br><input type="text" name="Q2Round2" id="Q2Round2" size="40" value="" />
			</td>
		</tr>
		<tr style="background-color:rgba(255,255,255,0.8);">
			<td style="background-color:rgba(105,179,182,0.9); color:white;">Record content</td>
			<td>
				<div id="tabs99" style="background:#ffffff; width:95%; margin:0;">
					<ul>
						<li><a href="#tabs99-1">Symbol</a></li>
						<li><a href="#tabs99-2">Unit</a></li>
						<li><a href="#tabs99-3">Professional Terms</a></li>
						<li><a href="#tabs99-5">Vital Sign</a></li>
						<li><a href="#tabs99-6">Current Medication</a></li>
						<li><a href="#tabs99-4">Custom Terms</a></li>
						<li><a href="#tabs99-7">History</a></li>
					</ul>
					<div id="tabs99-1">
						<input type="button" value="、" onclick="addtotextareaRound2('QcontentRound2', '、')" />
						<input type="button" value="，" onclick="addtotextareaRound2('QcontentRound2', '，')" />
						<input type="button" value="。" onclick="addtotextareaRound2('QcontentRound2', '。')" />
						<input type="button" value="&ge;" onclick="addtotextareaRound2('QcontentRound2', '&ge;')" />
						<input type="button" value="&le;" onclick="addtotextareaRound2('QcontentRound2', '&le;')" />
						<input type="button" value="&ordm;F" onclick="addtotextareaRound2('QcontentRound2', '&ordm;F')" />
						<input type="button" value="&mdash;" onclick="addtotextareaRound2('QcontentRound2', '&mdash;')" />
						<input type="button" value="&plusmn;" onclick="addtotextareaRound2('QcontentRound2', '&plusmn;')" />
						<input type="button" value="#" onclick="addtotextareaRound2('QcontentRound2', '#')" />
						<input type="button" value="%" onclick="addtotextareaRound2('QcontentRound2', '&#037;')" />
						<input type="button" value="L/min" onclick="addtotextareaRound2('QcontentRound2', 'L/min')" />
						<input type="button" value="/day" onclick="addtotextareaRound2('QcontentRound2', '/day')" />
						<input type="button" value="/hr" onclick="addtotextareaRound2('QcontentRound2', '/hr')" />
					</div>
					<div id="tabs99-2">
						<input type="button" value="mg/dl" onclick="addtotextareaRound2('QcontentRound2', 'mg/dl')" />
						<input type="button" value="mmHg" onclick="addtotextareaRound2('QcontentRound2', 'mmHg')" />
						<input type="button" value="ml" onclick="addtotextareaRound2('QcontentRound2', 'ml')" />
						<input type="button" value="kcal" onclick="addtotextareaRound2('QcontentRound2', 'kcal')" />
					</div>
					<div id="tabs99-3">
						<input type="button" value="GCS:E M V " onclick="addtotextareaRound2('QcontentRound2', 'GCS:E M V ')" />
						<input type="button" value="V/S " onclick="addtotextareaRound2('QcontentRound2', 'V/S')" />
						<input type="button" value="Nasal tube" onclick="addtotextareaRound2('QcontentRound2', 'Nasal tube')" />
						<input type="button" value="Oxygen mask" onclick="addtotextareaRound2('QcontentRound2', 'Oxygen mask')" />
						<input type="button" value="Oxygen mask" onclick="addtotextareaRound2('QcontentRound2', 'Oxygen mask')" />
						<input type="button" value="Sputum suction" onclick="addtotextareaRound2('QcontentRound2', 'Sputum suction')" />
						<input type="button" value="Output" onclick="addtotextareaRound2('QcontentRound2', 'Output')" />
						<input type="button" value="Input" onclick="addtotextareaRound2('QcontentRound2', 'Input')" /><br />
						<input type="button" value="SpO2: " onclick="addtotextareaRound2('QcontentRound2', 'SpO2: ')" />
						<input type="button" value="BP: " onclick="addtotextareaRound2('QcontentRound2', 'BP: ')" />
						<input type="button" value="BS: " onclick="addtotextareaRound2('QcontentRound2', 'BS: ')" />
						<input type="button" value="NG" onclick="addtotextareaRound2('QcontentRound2', 'NG')" />
						<input type="button" value="Tr." onclick="addtotextareaRound2('QcontentRound2', 'Tr.')" />
						<input type="button" value="Foley tube" onclick="addtotextareaRound2('QcontentRound2', 'Foley tube')" />
						<input type="button" value="Foley bag" onclick="addtotextareaRound2('QcontentRound2', 'Foley bag')" />
						<input type="button" value="F/U" onclick="addtotextareaRound2('QcontentRound2', 'F/U')" />
						<input type="button" value="obs: " onclick="addtotextareaRound2('QcontentRound2', 'obs: ')" />
						<input type="button" value="irrigation" onclick="addtotextareaRound2('QcontentRound2', 'irrigation')" />
					</div>
					<div id="tabs99-4">
						<?php
						$db_phrase = new DB;
						$db_phrase->query("SELECT * FROM `phrase` WHERE `userID`='".$_SESSION['ncareID_lwj']."' OR (`userID`!='".$_SESSION['ncareID_lwj']."' AND `public`='1') ORDER BY `userID`, `order` ASC");
						if ($db_phrase->num_rows()==0) {
							echo '請至右上角「系統設定」中的「片語管理」新增自訂片語';
						} else {
							echo '<select id="r_phrase" style="width:600px; overflow:hidden;">';
							for ($phrasei=0;$phrasei<$db_phrase->num_rows();$phrasei++) {
								$r_phrase = $db_phrase->fetch_assoc();
								echo '<option value="'.$r_phrase['text'].'">'.$r_phrase['text'].'</option>'."\n";
							}
							echo '</select>
							<input type="button" value="Substitute" onclick="addtotextareaRound2(\'QcontentRound2\', $(\'#r_phrase\').val())" />';
						}
						?>
					</div>
					<div id="tabs99-5">
						<?php
						/* 原V
						$dbvital = new DB;
						$dbvital->query("SELECT GROUP_CONCAT(CONCAT(`LoincCode`,'|',`Value`,'|',DATE_FORMAT(`RecordedTime`, '%Y-%m-%d %H:%i')) SEPARATOR ';') AS `vitalData` FROM `vitalsigns` WHERE `PersonID`='".($_GET['pid'])."' GROUP BY `RecordedTime` ORDER BY `RecordedTime` DESC LIMIT 0,8");
						for ($i1=0;$i1<$dbvital->num_rows();$i1++) {
							$rvital = $dbvital->fetch_assoc();
							$vData = explode(';',$rvital['vitalData']);
							for ($i2=0;$i2<count($vData);$i2++) {
								$vData2 = explode('|',$vData[$i2]);
								$vData3[$vData2[2]][$vData2[0]] = $vData2[1];
							}
						}
						if (count($vData3)>0) {
							foreach ($vData3 as $k2=>$v2) {
								$output = "V/S: ";
								$output .= $v2['8310-5'].' '; //T
								$output .= $v2['8867-4'].' '; //P
								$output .= $v2['9279-1'].' '; //R
								$output .= $v2['8480-6'].'/'.$v2['8462-4'].'mmHg'; //BP
								if ($output!="V/S:    /mmHg") {
									echo $k2.' <input type="button" value="'.$output.'" onclick="addtotextareaRound2(\'Qcontent\', \''.$output.'\')" /><br>'."\n";
								}
							}
						}
			            */
						// 新V START
						$dbvital = new DB;
						$dbvital->query("SELECT * FROM `vitalsign` WHERE `PatientID`='".($_GET['pid'])."' ORDER BY `date` DESC,`time` DESC LIMIT 0,8");
						for ($i1=0;$i1<$dbvital->num_rows();$i1++) {
							$rvital = $dbvital->fetch_assoc();
							//$output = "V/S: ";
							//$output .= $rvital['loinc_8310_5'].' '; //T
							//$output .= $rvital['loinc_8867_4'].' '; //P
							//$output .= $rvital['loinc_9279_1'].' '; //R
							//$output .= $rvital['loinc_8480_6'].'/'.$rvital['loinc_8462_4'].'mmHg'; //BP
							//if ($output!="V/S:    /mmHg") {
							//    echo date("Y-m-d",strtotime($rvital['date']))." ".date("H:i",strtotime($rvital['time'])).' <input type="button" value="'.$output.'" onclick="addtotextareaRound2(\'QcontentRound2\', \''.$output.'\')" /><br>'."\n";
							//}
							$output = "";
							if ($rvital['loinc_8310_5'] >0){
							    $output .= "BT: ".$rvital['loinc_8310_5'].'&ordm;C ';//T
							}
							if ($rvital['loinc_8867_4'] >0){
							    $output .= ' PR:'.$rvital['loinc_8867_4'].'times/min '; //PR
							}
							if ($rvital['loinc_9279_1'] >0){
							    $output .= ' RR:'.$rvital['loinc_9279_1'].'times/min '; //RR
							}
							if ($rvital['loinc_8480_6'] >0 || $rvital['loinc_8462_4'] >0){
							    $output .= ' BP:'.$rvital['loinc_8480_6'].'/'.$rvital['loinc_8462_4'].'mmHg '; //BP
							}
							if ($rvital['loinc_2710_2'] >0){
							    $output .= ' SpO2:'.$rvital['loinc_2710_2'].'%'; //BP
							}
							if ($output!="") {
							    echo date("Y-m-d",strtotime($rvital['date']))." ".date("H:i",strtotime($rvital['time'])).' <input type="button" value="'.$output.'" onclick="addtotextareaRound2(\'QcontentRound2\', \''.$output.'\')" /><br>'."\n";
							}
							$output1 = "";
							if ($rvital['loinc_14743_9'] >0){
							    $output1 = "AC: ".$rvital['loinc_14743_9'].' '; //AC;
							}
							if ($rvital['loinc_15075_5'] >0){
							    if ($rvital['loinc_14743_9'] >0){ $output1 .="/";}  
							    $output1 .= "PC: ".$rvital['loinc_15075_5'].' '; //PC;
							}
							if ($output1 !="") {
							    echo date("Y-m-d",strtotime($rvital['date']))." ".date("H:i",strtotime($rvital['time'])).' <input type="button" value="'.$output1.'" onclick="addtotextareaRound2(\'QcontentRound2\', \''.$output1.'\')" /><br>'."\n";
							}
						}
						// 新V END
			?>
		</div>
		<div id="tabs99-6">
			<?php
			$db_med = new DB;
			$db_med->query("SELECT * FROM `nurseform17` WHERE `HospNo`='".$HospNo."' ORDER BY `order` ASC");
			if ($db_med->num_rows()>0) {
				for ($i3=0;$i3<$db_med->num_rows();$i3++) {
					$rmed = $db_med->fetch_assoc();
					$output = $rmed['Qmedicine'].' '.$rmed['Qdose'].$rmed['Qdoseq'].' '.$rmed['Qusage'].' '.$rmed['Qfreq'];
					echo '<input type="button" value="'.$output.'" onclick="addtotextareaRound2(\'QcontentRound2\', \''.$output.'\')" />'."\n";
				}
			} else {
				echo '---Currently no data---'; 
			}
			?>
		</div>
		<div id="tabs99-7">
			<?php
			$db4 = new DB;
			$db4->query("SELECT * FROM `nurseform05` WHERE `HospNo`='".$HospNo."' ORDER BY `date` DESC, `nID` DESC LIMIT 0,6");
			if ($db4->num_rows()>0) {
				for ($i4=0;$i4<$db4->num_rows();$i4++) {
					$r4 = $db4->fetch_assoc();
					$output_history = '
					<div style="border-bottom:1px dotted #000; font-size:11pt; line-height:24px;">
					<div style="width:25%; display:inline-block;">'.formatdate($r4['date']).' '.substr($r4['time'],0,2).':'.substr($r4['time'],2,2).'</div>
					<div style="width:65%; display:inline-block;">'.$r4['Qcontent'].'</div>
					</div>'.$output_history;
				}
				echo $output_history;
			} else {
				echo '---Currently no data---'; 
			}
			?>
		</div>
	</div>
</td>
</tr>
<tr style="background-color:rgba(255,255,255,0.8);">
	<td style="background-color:rgba(105,179,182,0.9); color:white;">Record content</td>
	<td>
		<textarea name="QcontentRound2" id="QcontentRound2" rows="5"></textarea><br>
		<input type="checkbox" name="writeToNurseform24Round2" id="writeToNurseform24Round2" value="1" onclick="checkForm24TypeRound2();"> Fill into "nursing shift":
		<select name="writeForm24TypeRound2" id="writeForm24TypeRound2">
			<option></option>
			<option value="0">Day shift</option>
			<option value="1">Night shift</option>
			<option value="2">Graveyard shift</option>
		</select>
		<script>
		function checkForm24TypeRound2() {
			if (document.getElementById('writeToNurseform24Round2').checked) {
				$('#writeForm24TypeRound2').addClass('validate[required]');
			} else {
				$('#writeForm24TypeRound2').removeClass();
			}
		}
		</script>
	</td>
</tr>
</table>
<div align="center" style="margin-top:10px;">
<input type="hidden" name="Round2formID" id="Round2formID" value="nurseform05" />
<input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" />
<input type="hidden" name="nID" id="nID" value="" />
<input type="hidden" name="action" id="action" value="new" />
<button type="submit" id="submit_NursingRecord" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen_NursingRecord" class="ButtonVN" onclick="openVerificationForm2('NursingRecord'); closecol();"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
</div>
</form>
<script>
function addtotextareaRound2(field, text) {
	var pos = $('#QcontentRound2').caret();
	document.getElementById(field).value = document.getElementById('QcontentRound2').value;
	var txt = document.getElementById(field).value;
	var txt_part_1 = txt.substring(0, pos);
	var txt_part_2 = txt.substring(pos, txt.length);
	document.getElementById(field).value = txt_part_1+text+txt_part_2;
	$('#QcontentRound2').caret(pos+text.length);
}
$(function() {
	$( "#tabs99" ).tabs();
	$("#base99").validationEngine();
});
</script>
</div>
<?php }?>