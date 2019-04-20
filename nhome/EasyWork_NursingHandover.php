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
<div style="background-color:rgba(255,255,255,0.7); padding:10px; border-radius:10px; width:95%; margin:0px auto;">
<center><h3 style="width:100%;">Nursing document handover table</h3></center>
<table width="100%" cellpadding="10">
	<tr style="background-color:rgba(105,179,182,0.9); color:white;">
		<td width="80"></td>
		<td>New Admission</td>
		<td>Discharge<br>(Checked-Out)</td>
		<td>Hospitalization Number</td>
		<td>Discharged From Hospital</td>
		<td>Number Of Death</td>
		<td>Resident Number Of The Day</td>
	</tr>
	<tr style="background-color:rgba(255,255,255,0.8); height:30px;">
		<?php
		$db0 = new DB;
		$db0->query("SELECT * FROM `dailypatientno1` WHERE DATE_FORMAT(`date`,'%Y%m%d')='".mysql_escape_string(date(Ymd))."'");
		if ($db0->num_rows()>0) {
			$r0 = $db0->fetch_assoc();
			echo '
			<td></td>
			<td align="center">'.$r0['newpat'].'</td>
			<td align="center">'.$r0['outpat'].'</td>
			<td align="center">'.$r0['hosppat'].'</td>
			<td align="center">'.$r0['backpat'].'</td>
			<td align="center">'.$r0['deadpat'].'</td>
			<td align="center">'.$r0['no'].'</td>
			'."\n";
		} else {
			echo '
			<td colspan="7">沒有資料</td>
			'."\n"; 
		}
		?>
	</tr>
	<tr style="background-color:rgba(105,179,182,0.9); color:white; height:30px;">
		<td width="6%" class="printcol">&nbsp;</td>
		<td nowrap>Handover Date</td>
		<td nowrap>Resident</td>
		<td nowrap colspan="2">Handover Content</td>
		<td nowrap>Filled By</td>
		<td width="6%" class="printcol">&nbsp;</td>
	</tr>
	<?php
	$arrVar = array("Day shift","Night shift","Graveyard shift");
	$db = new DB;
	$db->query("SELECT * FROM `nurseform24` WHERE 1 AND `HospNo`='".$HospNo."' AND `Q4`=0 ORDER BY `date` DESC, `Q1` DESC LIMIT 4");
	if($db->num_rows()==0){
		echo '<tr style="background-color:rgba(255,255,255,0.8); height:30px;"><td colspan="7"></td></tr>';
	}
	for ($j=0;$j<$db->num_rows();$j++) {
		$r = $db->fetch_assoc();
		foreach ($r as $k=>$v) {
			$arrAnswer = explode("_",$k);
			if (count($arrAnswer)==2) {
				if ($v==1) {
					${'nurseform24_'.$arrAnswer[0]} .= $arrAnswer[1].';';
				}
			} else {
				${'nurseform24_'.$k} = $v;
			}
		}
		$pid = getPID($nurseform24_HospNo);
		echo '
		<tr style="background-color:rgba(255,255,255,0.8); height:30px;">
		<td class="printcol">';
		if ($_SESSION['ncareLevel_lwj']>=4 || $_SESSION['ncareID_lwj']==$nurseform24_Qfiller) {
			echo '<center><a href="index.php?func=shiftrecord1_1&nID='.$nurseform24_nID.'&action=edit"><img src="Images/edit_icon.png" width="30"></a></center>';
		}
		echo '
		</td>
		<td align="center" nowrap>'.formatdate($nurseform24_date).'<br>'.$arrVar[$nurseform24_Q1].'</td>
		<td align="center" nowrap>'.$bedID.'<br>'.$name.'</td>
		<td align="left" colspan="2">'.str_replace("\n","<br>",$nurseform24_Q2).'</td>
		<td align="center" nowrap>'.checkusername($nurseform24_Qfiller).'</td>
		<td width="6%" class="printcol">
		';
		if ($_SESSION['ncareLevel_lwj']>=4 || $_SESSION['ncareID_lwj']==$nurseform24_Qfiller) {
			echo '<center><img src="Images/delete2.png" border="0" width="30"  onClick="del(\''.$nurseform24_nID.'\');" ></a>';
		}
		echo '
		</td>
		</tr>'."\n";
	}
	?>
</table>
<script>
function del(id){
	if (confirm("Are you sure to delete this item?")) {
		$.ajax({
			url: "class/editrow.php",
			type: "POST",
			data: {"formID": "nurseform24", "nID": id, "Q4":"1" },
			success: function(data) {
				window.location.reload();
			}
		});
	}
}
</script>
<form  method="post" id="nurseform24" onSubmit="return checkForm();" action="index.php?func=databaseAI&round=4">
	<table width="100%" cellpadding="10">
		<tr height="30">
			<td style="background-color:rgba(105,179,182,0.9); color:white;" colspan="4">Add New Handover Record</td>
		</tr>
		<tr height="30" style="background-color:rgba(255,255,255,0.8);">
			<td style="background-color:rgba(105,179,182,0.9); color:white;" width="120">Handover Date</td>
			<td><input type="text" name="dateRound1" id="dateRound1" value="<?php echo date('Y/m/d'); ?>" size="12"></td>
			<td style="background-color:rgba(105,179,182,0.9); color:white;" width="120">Shift</td>
			<td>
				<select id="Q1_round4" name="Q1_round4" class="validate[required]" >
					<option value="">--Please select--</option>
					<option value="0">Day shift</option>
					<option value="1">Night shift</option>
					<option value="2">Graveyard shift</option>            
				</select>
			</td>
		</tr>
		<tr style="background-color:rgba(255,255,255,0.8);">
			<td style="background-color:rgba(105,179,182,0.9); color:white;" width="120">Resident</td>
			<td colspan="3">
				<span style="padding:3px; border:1px solid #999; color:#666; font-size:10pt;">Care ID#</span> <input type="text" name="HospNo" id="HospNo" readonly="readonly" value="<?php echo $HospNo; ?>" size="8">&nbsp;
				<span style="padding:3px; border:1px solid #999; color:#666; font-size:10pt;">Bed #</span> <input type="text" name="BedID" id="BedID" size="8" readonly="readonly" value="<?php echo $bedID; ?>">&nbsp;
				<span style="padding:3px; border:1px solid #999; color:#666; font-size:10pt;">Full name</span> <input type="text" name="Name" id="Name" size="16" readonly="readonly" value="<?php echo $name; ?>">
			</td>
		</tr>
		<tr height="30" style="background-color:rgba(255,255,255,0.8);">
			<td style="background-color:rgba(105,179,182,0.9); color:white;">Handover Content</td>
			<td colspan="3"><textarea cols="3" rows="7" id="Q2Round1" name="Q2Round1" ></textarea></td>
		</tr>
	</table>
	<table width="100%">
		<tr style="height:30px;">
			<td style="background-color:rgba(255,255,255,0.8);" align="right" colspan="2">Filled By : <?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
		</tr>
	</table>
	<center>
		<div style="margin-top:10px;">
		<input type="hidden" name="Round1formID" id="Round1formID" value="nurseform24" />
		<input type="hidden" name="nID" id="nID" value="" />
		<input type="hidden" name="action" id="action" value="new" />
		<button type="submit" id="submit_NursingHandover" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen_NursingHandover" class="ButtonVN" onclick="openVerificationForm2('NursingHandover'); closecol();"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
		</div>
	</center>
</form>
<script> 
$(function() { 
	$("#dateRound1").datetimepicker({format:'Y/m/d', timepicker: false, mask: true});
}); 
</script>
</div>
<?php }?>