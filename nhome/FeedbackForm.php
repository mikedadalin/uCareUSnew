<div style="background-color: rgba(255,255,255,0.8); border-radius: 10px; padding:10px 10px 30px 10px; margin-bottom: 20px;">
	<div class="content-query">
		<table align="center" style="width:11%; font-size:10pt; margin: 0px 0px;">
			<tr id="backtr"  style="border:none; height:28px;">
				<td class="backbtnn" align="center" bgcolor="#ffffff" width="40" height="40" id="backbtn"  style="border:none;" rowspan="3"><a href="index.php?func=Feedbacklist">Back to List</a></td>
			</tr>
		</table>
	</div>
	<div class="nurseform-table">
	<?php
	if (@$_GET['nID']!=NULL) {
		$db = new DB;
		if(substr($_SESSION['ncareID_lwj'],0,8)=="resident"){
	    	$db->query("SELECT * FROM `feedback_resident` WHERE `nID`='".mysql_escape_string($_GET['nID'])."' AND `HospNo`='".substr($_SESSION['ncareID_lwj'],8,6)."'");
		}else{
			if(@$_GET['pid']!=NULL) {
				$db->query("SELECT * FROM `feedback_resident` WHERE `nID`='".mysql_escape_string($_GET['nID'])."' AND `HospNo`='".getHospNo($_GET['pid'])."'");
			}else{
				$db->query("SELECT * FROM `feedback` WHERE `nID`='".mysql_escape_string($_GET['nID'])."'");
			}
		}
		if ($db->num_rows()>0) {
			$r = $db->fetch_assoc();
			foreach ($r as $k=>$v) {
				${$k} = $v;
				if(substr($Qfiller,0,8)=="resident"){
					$db2 = new DB;
					$db2->query("SELECT `patientID` FROM `patient` WHERE `HospNo`='".substr($Qfiller,8,6)."'");
					$r2 = $db2->fetch_assoc();
					$Name = getPatientName($r2['patientID']);
				}
			}
		}
	}
	?>
	<form method="post" onSubmit="submitFeedback();" action="index.php?func=databaseFeedback">
		<table cellpadding="7" style="width:100%;">
      		<tr height="30">
        		<td class="title" colspan="4">Feedback Form</td>
      		</tr>
      		<tr height="30">
        		<td class="title" width="130">Name</td>
				<td><?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?><input type="hidden" id="Name" name="Name" value="<?php if ($Name != NULL) { echo $Name; } else { echo $_SESSION['ncareName_lwj'].'&nbsp;'.$_SESSION['ncarePos_lwj']; } ?>"><?php }?><?php if ($Name != NULL) { echo $Name; } else { echo $_SESSION['ncareName_lwj'].'&nbsp;'.$_SESSION['ncarePos_lwj']; } ?></td>
        		<td class="title">Date</td>
        		<td><?php if ($date != NULL) { echo formatdate($date); } else { echo date('Y/m/d'); } ?></td>
      		</tr>
      		<tr height="30">
        		<td class="title" width="130">Subject</td>
				<td colspan="3"><input type="text" id="Subject" name="Subject" size="110" value="<?php echo $Subject; ?>" <?php if($_GET['action']=="view"){?>readonly="readonly"<?php }?>></td>
      		</tr>
			<?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident" && $_GET['pid']==NULL){?>
      		<tr height="30">
        		<td class="title" width="130">URL</td>
				<td colspan="3"><input type="text" id="URL" name="URL" size="110" value="<?php echo $URL; ?>" <?php if($_GET['action']=="view"){?>readonly="readonly"<?php }?>></td>
      		</tr>
			<?php }?>
      		<tr height="30">
        		<td class="title">Content</td>
        		<td colspan="3"><textarea cols="3" rows="6" id="Content" name="Content" class="validate[required]" <?php if($_GET['action']=="view"){?>readonly="readonly"<?php }?>><?php echo $Content; ?></textarea></td>
      		</tr>
	  		<?php if($_GET['action']=="view"){?>
	  		<tr>
        		<td class="title">Responses</td>
        		<td colspan="3"><textarea cols="3" rows="6" id="Responses" name="Responses" class="validate[required]"<?php if($_GET['action']=="view" && substr($_SESSION['ncareID_lwj'],0,8)=="resident"){?>readonly="readonly"<?php }?>><?php echo $Responses; ?></textarea></td>
	  		</tr>
	  		<?php }?>
		</table>
		<center><div style="margin-top:25px">
		<?php if(substr($_SESSION['ncareID_lwj'],0,8)=="resident" || $_GET['pid']!=NULL){?>
		<input type="hidden" name="formID" id="formID" value="feedback_resident" />
		<?php }else{?>
		<input type="hidden" name="formID" id="formID" value="feedback" />
		<?php }?>
		<input type="hidden" name="nID" id="nID" value="<?php echo $_GET['nID'];?>" />
		<input type="hidden" name="action" id="action" value="<?php echo $_GET['action']; ?>" />
		<?php if($_GET['action']=="new"){?>
		<input type="submit" id="submit" style="width:100px; height:32px; font-size:16px;" value="Submit" />
		<?php }?>
		<?php if($_GET['action']=="view" && substr($_SESSION['ncareID_lwj'],0,8)!="resident" && $_GET['pid']!=NULL){?>
		<input type="submit" id="submit" style="width:100px; height:34px; font-size:16px;" value="Submit" />
		<?php }elseif($_GET['action']=="view"){
	     	if($_SESSION['ncareID_lwj']=="Mor3Geneki6nge08" || $_SESSION['ncareID_lwj']=="Lejla05Mirzada12Asmira01"){
		?>
		<input type="submit" id="submit" style="width:100px; height:34px; font-size:16px;" value="Submit" />	
		<?php }}?>
		</div></center>
	</form>
	</div>
</div>
<script>
function submitFeedback(){
	alert("Thank you for your feedback!");
}
</script>