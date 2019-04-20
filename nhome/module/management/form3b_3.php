<?php
$HospNo = getHospNo(@$_GET['pid']);
$targetID = mysql_escape_string($_GET['tID']);
$sMonth = ($qdate == "" ? "" : "&qdate=".$qdate);

if (isset($_POST['submit'])) {
	$formID = $_POST['formID'];
		
	foreach ($_POST as $k=>$v) {
	  if($k!="formID" && $k!="submit"){
		$db1 = new DB;
		$db1->query("UPDATE `".$formID."` SET `".mysql_escape_string($k)."`='".mysql_escape_string($v)."' WHERE `targetID`='".$targetID."'");
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
			echo '<script>alert("Modification success!");window.onbeforeunload=null;window.location.href="index.php?mod=management&func=formview&view=3&id=3'.$sMonth.'";</script>';
		}
}


$db1 = new DB;
$db1->query("SELECT * FROM `sixtarget_part3` WHERE `targetID`='".$targetID."' AND `HospNo`='".$HospNo."'");
$r1 = $db1->fetch_assoc();
foreach ($r1 as $k=>$v) {
	$arrPatientInfo = explode("_",$k);
	if (count($arrPatientInfo)>1) {
		$varname = "";
		for ($i=0;$i<(count($arrPatientInfo)-1);$i++) {
			if ($v==1) {
				if ($varname!="") { $varname .= '_'; }
				$varname .= $arrPatientInfo[$i];
			}
		}
		${$varname} .= $arrPatientInfo[(count($arrPatientInfo)-1)].';';
	} else {
		${$k} = $v;
	}
}
$pid = getPID($HospNo);
?>
<form  method="post" onSubmit="return checkForm();">
<h3>Fall record</h3>
<div align="right" id="printbtn"><a href="print.php?<?php echo $_SERVER['QUERY_STRING']; ?>" target="_blank"><img src="Images/print.png" border="0"></a></div>
<table style="width:100%; text-align:left;">
  <tr>
    <td class="title" width="160" style="border-top-left-radius:10px;">Full name</td>
    <td width="400"><?php echo '('.getBedID($pid).') '.getPatientName($pid); ?></td>
    <td class="title" width="160">Care ID#</td>
    <td style="border-top-right-radius:10px;"><?php echo getHospNoDisplayByPID($pid); ?></td>
  </tr>
  <tr>
      <td class="title">Gender</td>
      <td><?php echo $r1['Gender']; ?></td>
      <td class="title">Age</td>
      <td><?php echo $r1['Age']; ?></td>
    </tr>
    <tr>
      <td class="title">Major diagnosis</td>
      <td><?php echo $r1['Diag']; ?></td>
      <td class="title">ADL score</td>
      <td><?php echo $r1['ADLtotal']; ?></td>
    </tr>
    <tr>
      <td class="title">Date</td>
      <td><script>$(function() { $('#date').datepicker(); });</script><input type="text" name="date" id="date" value="<?php echo $r1['date']; ?>" size="12" /></td>
      <td class="title">Time</td>
      <td><input type="text" name="time" id="time" value="<?php echo $r1['time']; ?>" size="6" /></td>
    </tr>
    <tr>
      <td class="title">Location</td>
      <td colspan="3"><?php echo draw_option("location","Room;Bedside;Bathroom;Activity area;Walkway;Other","xm","single",$location,true,4); ?> <input type="text" name="locationother" id="locationother" size="12" value="<?php echo $locationother; ?>"></td>
    </tr>
    <tr>
      <td class="title">Scenarios</td>
      <td colspan="3"><?php echo draw_option("movement","Toileting;In/out bed;During activity;Slip(wheelchair);Stand up(wheelchair);Across(Bed rails);Other","xl","single",$movement,true,3); ?> <input type="text" name="movementother" id="movementother" size="12" value="<?php echo $movementother; ?>"></td>
    </tr>
    <tr>
      <td class="title">Reason</td>
      <td colspan="3"><?php echo draw_option("reason","Resident's health;Treatment/medication;Environmental risk;Other","xl","multi",$reason,true,3); ?> <input type="text" name="reasonother" id="reasonother" size="12" value="<?php echo $reasonother; ?>"></td>
    </tr>
    <tr>
      <td class="title">Restraints</td>
      <td colspan="3"><?php echo draw_option("object","Bed rails(2);Bed rail(1);Waist restraint straps;Posey vest;No restraint","xl","multi",$object,false,4); ?></td>
    </tr>
    <tr>
      <td class="title">Medication</td>
      <td colspan="3"><?php echo draw_option("med","Antihistamine;Antihypertensive;Sedative-hypnotic;Muscle relaxants;Laxative;Diuretics;Antidepressant;Hypoglycemic","xl","multi",$med,true,3); ?></td>
    </tr>
    <tr>
      <td class="title">Injury severity</td>
      <td colspan="3"><?php echo draw_option("injurlv","None;Level1;Level2;Level3","m","multi",$injurlv,false,6); ?></td>
    </tr>
    <tr>
      <td class="title">Body part</td>
      <td colspan="3"><?php echo draw_option("bodypart","Waist;Ankle(s);Wrist(s);Knee(s);Torso;Other","m","multi",$bodypart,false,3); ?> <input type="text" name="bodypartother" id="bodypartother" size="10" value="<?php echo $bodypartother; ?>"></td>
    </tr>
    <tr>
      <td class="title">Status description</td>
      <td colspan="3"><textarea name="description" id="description" cols="5" rows="5"><?php echo $description;?></textarea></td>
    </tr>
    <tr>
      <td class="title" style="border-bottom-left-radius:10px;">Filled by</td>
      <td colspan="3" style="border-bottom-right-radius:10px;"><?php echo checkusername($Qfiller); ?></td>
    </tr>
  </table>
<center>
<input type="hidden" name="formID" id="formID" value="sixtarget_part3" />
<div style="margin-top:30px;">
<?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?>
<input type="hidden" id="submit" value="Save" name="submit"/><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
<input type="button" onClick="window.location.href='index.php?mod=management&func=formview&view=3&id=3<?php echo $sMonth;?>';" value="Back to list" />
<?php }?>
</div>
</center>

</form>