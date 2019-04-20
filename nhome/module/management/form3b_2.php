<?php
$HospNo = getHospNo(@$_GET['pid']);
$targetID = mysql_escape_string($_GET['tID']);
$sMonth = ($qdate == "" ? "" : "&qdate=".$qdate);

if (isset($_POST['submit'])) {
	$formID = $_POST['formID'];

	foreach ($_POST as $k=>$v) {
		$part = explode("_",$k);
		if(count($part) >= 2){
			$db1 = new DB;		
			$db1->query("UPDATE `".$formID."` SET `".$part[1].$part[2]."`='".mysql_escape_string($v)."' WHERE `targetID`='".$targetID."'");	  
		}else if($k!="formID" && $k!="submit"){
			if ($k=="releasedate" && $v=="____/__/__") {
				$db1 = new DB;
				$db1->query("UPDATE `".$formID."` SET `".mysql_escape_string($k)."`='' WHERE `targetID`='".$targetID."'");
			} else {
				$db1 = new DB;
				$db1->query("UPDATE `".$formID."` SET `".mysql_escape_string($k)."`='".mysql_escape_string($v)."' WHERE `targetID`='".$targetID."'");
			}
		}
	}
		if(isset($_SESSION['GNO'])){
			$GNO_Change = 0;
			$kGF3 = 'Gname_'.$_SESSION['GNO'];
			$arr_Gname3 = explode("_",$_SESSION[$kGF3]);
			$_SESSION[$kGF3] = $arr_Gname3[0].'_'.$arr_Gname3[1].'_1';
			for($iGF=1;$iGF<11;$iGF++){
				$kGF = 'Glink_'.$iGF;
				if(isset($_SESSION[$kGF])){
					$kGF2 = 'Gname_'.$iGF;
					$arr_Gname2 = explode("_",$_SESSION[$kGF2]);
					if($arr_Gname2[2]=="0" && $GNO_Change==0){
						$_SESSION['GNO'] = $iGF;
						$GNO_Change = 1;
						?><script>window.location.href="<? echo $_SESSION[$kGF];?>"</script><?
					}
				}
			}
			if($GNO_Change==0){
				if(isset($_SESSION['G_mod']) && isset($_SESSION['G_func']) && isset($_SESSION['G_pid'])){
					$GENDurl = '<script>index.php?mod='.$_SESSION['G_mod'].'&func='.$_SESSION['G_func'].'&pid='.$_SESSION['G_pid'].'</script>';
				}elseif(isset($_SESSION['G_mod']) && isset($_SESSION['G_func'])){
					$GENDurl = '<script>index.php?mod='.$_SESSION['G_mod'].'&func='.$_SESSION['G_func'].'</script>';
				}else{
					$GENDurl = '<script>history.go(-2)</script>';
				}
				for($iGF=1;$iGF<11;$iGF++){
					$kGF = 'Glink_'.$iGF;
					$kGF2 = 'Gname_'.$iGF;
					unset($_SESSION[$kGF]);
					unset($_SESSION[$kGF2]);
				}
				unset($_SESSION['GNO']);
				unset($_SESSION['GListName']);
				unset($_SESSION['G_Temp_Link']);
				unset($_SESSION['G_GNOnumber']);
				unset($_SESSION['G_mod']);
				unset($_SESSION['G_func']);
				unset($_SESSION['G_pid']);

				echo $GENDurl;
			}
		}else{
			echo '<script>alert("Modification success!");window.onbeforeunload=null;window.location.href="index.php?mod=management&func=formview&view=2&id=3'.$sMonth.'";</script>';
		}
}

$db1 = new DB;
$db1->query("SELECT * FROM `sixtarget_part2` WHERE `targetID`='".$targetID."' AND `HospNo`='".$HospNo."'");
$r1 = $db1->fetch_assoc();
foreach ($r1 as $k=>$v) {
	${$k} = $v;
}
for ($i=1;$i<=6;$i++) {
	if (${'reason'.$i}==1) { $reason .= $i.';'; }
	if (${'equipment'.$i}==1) { $equipment .= $i.';'; }
	if (${'bodypart'.$i}==1) { $bodypart .= $i.';'; }
	if (${'releasereason'.$i}==1) { $releasereason .= $i.';'; }
	if (${'UseInBed1'.$i}==1) { $UseInBed1 .= $i.';'; }
	if (${'UseInBed2'.$i}==1) { $UseInBed2 .= $i.';'; }
	if (${'UseInBed3'.$i}==1) { $UseInBed3 .= $i.';'; }
	if (${'UseInBed4'.$i}==1) { $UseInBed4 .= $i.';'; }
	if (${'UseInChair1'.$i}==1) { $UseInChair1 .= $i.';'; }
	if (${'UseInChair2'.$i}==1) { $UseInChair2 .= $i.';'; }
	if (${'UseInChair3'.$i}==1) { $UseInChair3 .= $i.';'; }
	if (${'UseInChair4'.$i}==1) { $UseInChair4 .= $i.';'; }
}
$pid = getPID($HospNo);
?>
<form  method="post" onSubmit="return checkForm();">
	<h3>Restraint record</h3>
	<div align="right" id="printbtn"><a href="print.php?<?php echo $_SERVER['QUERY_STRING']; ?>" target="_blank"><img src="Images/print.png" border="0"></a></div>
	<table style="width:100%; text-align:left;">
		<tr>
			<td class="title" width="160" style="border-top-left-radius:10px;">Full name</td>
			<td><?php echo getBedID($pid).' '.getPatientName($pid); ?></td>
			<td class="title" width="160">Care ID#</td>
			<td style="border-top-right-radius:10px;"><?php echo getHospNoDisplayByPID($pid); ?></td>
		</tr>
		<tr>
			<td class="title">Restraint date</td>
			<td colspan="3"><input type="text" name="startdate" id="startdate" value="<?php echo $r1['startdate']; ?>"></td>
		</tr>
		<tr>
			<td class="title">Restraint reason</td>
			<td colspan="3"><?php echo draw_option("part2_reason","Fall prevent;Pipeline Protect;Self-injury prevent;Behavioral disorders;Assist treatment;Other","xl","single",$reason,true,3); ?> <input type="text" name="reasonother" id="reasonother" size="15" value="<?php echo $reasonother; ?>"></td>
		</tr>
		<tr>
			<td class="title">Restraint equipment</td>
			<td colspan="3"><?php echo draw_option("part2_equipment","Restraint strap;T-shape restraint strap;Magnetic clasp(s);Glove(s);Special dinner plate(s);Other","xl","multi",$equipment,true,3); ?> <input type="text" name="equipmentother" id="equipmentother" size="15" value="<?php echo $equipmentother; ?>"></td>
		</tr>
		<tr>
			<td rowspan="4"  class="title">Used in Bed</td>
			<td colspan="3">Bed rail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo draw_option("part2_UseInBed1","Not used;Used less than daily;Used daily","xl","single",$UseInBed1,false,0); ?></td>
		</tr>
		<tr>
			<td colspan="3">Trunk restraint &nbsp;&nbsp;<?php echo draw_option("part2_UseInBed2","Not used;Used less than daily;Used daily","xl","single",$UseInBed2,false,0); ?></td>
		</tr>
		<tr>
			<td colspan="3">Limb restraint &nbsp;&nbsp;&nbsp;<?php echo draw_option("part2_UseInBed3","Not used;Used less than daily;Used daily","xl","single",$UseInBed3,false,0); ?></td>
		</tr>
		<tr>
			<td colspan="3">Other &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo draw_option("part2_UseInBed4","Not used;Used less than daily;Used daily","xl","single",$UseInBed4,false,0); ?></td>
		</tr>
		<tr>
			<td rowspan="4"  class="title">Used in Chair <br>or Out of Bed</td>
			<td colspan="3">Trunk restraint &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo draw_option("part2_UseInChair1","Not used;Used less than daily;Used daily","xl","single",$UseInChair1,false,0); ?></td>
		</tr>
		<tr>
			<td colspan="3">Limb restraint &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo draw_option("part2_UseInChair2","Not used;Used less than daily;Used daily","xl","single",$UseInChair2,false,0); ?></td>
		</tr>
		<tr>
			<td colspan="3">Chair prevents rising &nbsp;&nbsp;&nbsp;<?php echo draw_option("part2_UseInChair3","Not used;Used less than daily;Used daily","xl","single",$UseInChair3,false,0); ?></td>
		</tr>
		<tr>
			<td colspan="3">Other &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo draw_option("part2_UseInChair4","Not used;Used less than daily;Used daily","xl","single",$UseInChair4,false,0); ?></td>
		</tr>
		<tr>
			<td class="title">Restraint part(s)</td>
			<td colspan="3"><?php echo draw_option("part2_bodypart","Waist;Ankle(s);Wrist(s);Knee(s);Torso;Other","m","multi",$bodypart,false,3); ?> <input type="text" name="bodypartother" id="bodypartother" size="15" value="<?php echo $bodypartother; ?>"></td>
		</tr>
		<tr>
			<td class="title">Relieve date</td>
			<td colspan="3"><input type="text" name="releasedate" id="releasedate" value="<?php echo $releasedate; ?>"></td>
		</tr>
		<tr>
			<td class="title">Relieve reason</td>
			<td colspan="3"><?php echo draw_option("part2_releasereason","Cognitive Improvement;Emotion stabilized;Deterioration;Death;Other","xxl","single",$releasereason,true,3); ?> <input type="text" name="releasereasonother" id="releasereasonother" size="15" value="<?php echo $releasereasonother; ?>"></td>
		</tr>
		<tr>
			<td class="title" style="border-bottom-left-radius:10px;">Filled by</td>
			<td colspan="3" style="border-bottom-right-radius:10px;"><?php echo checkusername($Qfiller); ?></td>
		</tr>
	</table>
	<center>
		<input type="hidden" name="formID" id="formID" value="sixtarget_part2" />
		<div style="margin-top:30px;">
			<?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?>
			<input type="hidden" id="submit" value="Save" name="submit"/><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
			<input type="button" onClick="window.location.href='index.php?mod=management&func=formview&id=3&view=2<?php echo $sMonth;?>';" value="Back to list" />
			<?php }?>
		</div>
	</center>

</form>
<script>
$(function() { 
	$( "#startdate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); 
	$( "#releasedate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); 
});
</script>