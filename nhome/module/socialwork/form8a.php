<div class="moduleNoTab">
	<h3>New activity schedule</h3>
	<?php
	if (isset($_POST['actID'])) {
		$actID = $_POST['actID'];
		$date = str_replace('-','',str_replace('/','',$_POST['date']));
		foreach ($_POST['HospNo'] as $k=>$v) {
			if ($hospnotxt!="") { $hospnotxt .= ';'; }
			$hospnotxt .= $v;
		}
		$db0b = new DB;
		$db0b->query("INSERT INTO `socialform08` (`date`, `actID`, `HospNo`, `Qfiller`) VALUES ('".$date."', '".$actID."', '".$hospnotxt."', '".$_SESSION['ncareID_lwj']."');");
		$db0b = new DB;
		$db0b->query("SELECT LAST_INSERT_ID()");
		$r0b = $db0b->fetch_assoc();
		$db0c = new DB;
		$db0c->query("INSERT INTO `socialform08a` (`actNo`, `Q1`, `Q2_1`, `Q2_5`, `Q2_2`, `Q2_6`, `Q2_3`, `Q2_7`, `Q2_4`, `Q2_8`, `Q3_1`, `Q4_1`, `Q4_2`, `Q4_3`, `Q4_4`, `Q4_5`, `Q5_1`, `Q5_2`, `Q5a`, `Q6_1`, `Q6_2`, `Q6_3`, `Q6_4`, `Q7`, `Q8`, `Q8a`, `Q9`, `Q10`, `Q11`, `Q12`) VALUES ('".$r0b['LAST_INSERT_ID()']."', '".mysql_escape_string($_POST['Q1'])."', '".mysql_escape_string($_POST['Q2_1'])."', '".mysql_escape_string($_POST['Q2_5'])."', '".mysql_escape_string($_POST['Q2_2'])."', '".mysql_escape_string($_POST['Q2_6'])."', '".mysql_escape_string($_POST['Q2_3'])."', '".mysql_escape_string($_POST['Q2_7'])."', '".mysql_escape_string($_POST['Q2_4'])."', '".mysql_escape_string($_POST['Q2_8'])."', '".mysql_escape_string($_POST['Q3_1'])."', '".mysql_escape_string($_POST['Q4_1'])."', '".mysql_escape_string($_POST['Q4_2'])."', '".mysql_escape_string($_POST['Q4_3'])."', '".mysql_escape_string($_POST['Q4_4'])."', '".mysql_escape_string($_POST['Q4_5'])."', '".mysql_escape_string($_POST['Q5_1'])."', '".mysql_escape_string($_POST['Q5_2'])."', '".mysql_escape_string($_POST['Q5a'])."', '".mysql_escape_string($_POST['Q6_1'])."', '".mysql_escape_string($_POST['Q6_2'])."', '".mysql_escape_string($_POST['Q6_3'])."', '".mysql_escape_string($_POST['Q6_4'])."', '".mysql_escape_string($_POST['Q7'])."', '".mysql_escape_string($_POST['Q8'])."', '".mysql_escape_string($_POST['Q8a'])."', '".mysql_escape_string($_POST['Q9'])."', '".mysql_escape_string($_POST['Q10'])."', '".mysql_escape_string($_POST['Q11'])."', '".mysql_escape_string($_POST['Q12'])."');");
		echo "<script>window.onbeforeunload=null;window.location.href='index.php?mod=socialwork&func=formview&id=8'</script>";
	}
	$arrCateName = array();
	$arrActName = array();
	$db1a = new DB;
	$db1a->query("SELECT DISTINCT `cateName` FROM `socialform08_act`");
	for ($i1a=1;$i1a<=$db1a->num_rows();$i1a++) {
		$r1a = $db1a->fetch_assoc();
		$arrCateName[$i1a] = $r1a['cateName'];
		$db1b = new DB;
		$db1b->query("SELECT * FROM `socialform08_act` WHERE `cateName`='".$r1a['cateName']."'");
		for ($i1b=0;$i1b<$db1b->num_rows();$i1b++) {
			$r1b = $db1b->fetch_assoc();
			$arrActName[$i1a][$r1b['actID']] = $r1b['actName'];
		}
	}
	?>
	<script>
	function changeAct(idx) {
		var actname = document.getElementById('actID');
		if (idx>0) {
			actname.options.length = 0;
			actname.readonly = false;
			switch (idx) {
				<?php
				foreach ($arrCateName as $k1=>$v1) {
					$count = 0;
					echo '		case '.$k1.':'."\n";
					foreach ($arrActName[$k1] as $k2=>$v2) {
						?>
						actname.options[<?php echo $count; ?>] = new Option('<?php echo $v2; ?>', '<?php echo $k2; ?>');
						<?php
						$count++;
					}
					echo '		break;'."\n";
				}
				?>
			}
		} else {
			actname.options.length = 0;
			actname.readonly = true;
		}
	}
	function checkall(cName) {
		var checkboxs = document.getElementsByName(cName);
		for(var i=0;i<checkboxs.length;i++){checkboxs[i].checked = true;}
	}
function uncheckall(cName) { 
	var checkboxs = document.getElementsByName(cName); 
	for(var i=0;i<checkboxs.length;i++){checkboxs[i].checked = false;} 
}
function calcNo(cName) { 
	var checkboxs = document.getElementsByName(cName); 
	var count = 0;
	for(var i=0;i<checkboxs.length;i++){
		if (checkboxs[i].checked == true) { count++; }
	}
	document.getElementById('Q7').value = count;
}
</script>
<form id="socialform08" method="post">
	<table width="100%">
		<tr>
			<td width="160" class="title">Select activity category</td>
			<td>
				<select id="cateName" onchange="changeAct(this.selectedIndex);">
					<option>--Activity category--</option>
					<?php
					foreach ($arrCateName as $k1=>$v1) {
						echo '<option value="'.$k1.'">'.$v1.'</option>';
					}
					?>
				</select>
				<select name="actID" id="actID" class="validate[required]" readonly>
					<option></option>
				</select>
			</td>
			<td width="150" class="title">Date</td>
			<td><script>$(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); });</script><input type="text" name="date" id="date" size="10" value="<?php echo date("Y/m/d"); ?>" class="validate[required,custom[date]]" />&nbsp;Time:<input type="text" id="Q12" name="Q12"></td>
		</tr>
		<tr>
			<td class="title">Select resident(s)</td>
			<td colspan="3" style="text-align:left;">
				<input type="button" name="all" onclick="checkall('HospNo[]')" value="Select all" /> <input type="button" name="all" onclick="uncheckall('HospNo[]')" value="Unselect all" />
				<?php
				$arrHospNo = array();
				$db2a = new DB;
				$db2a->query("SELECT * FROM `areainfo`");
				for ($i2a=0;$i2a<$db2a->num_rows();$i2a++) {
					$r2a = $db2a->fetch_assoc();
					$arrHospNo[$r2a['areaName']] = array();
					$db2b = new DB;
					$db2b->query("SELECT a.`patientID` FROM `inpatientinfo` a, `bedinfo` b WHERE (a.`bed` = b.`bedID` AND b.`Area`='".$r2a['areaID']."') ORDER BY a.`bed` ASC");
					for ($i2b=0;$i2b<$db2b->num_rows();$i2b++) {
						$r2b = $db2b->fetch_assoc();
						$arrHospNo[$r2a['areaName']][$i2b] = $r2b['patientID'];
					}
				}
				foreach ($arrHospNo as $k1=>$v1) {
					if (count($arrHospNo[$k1])>0) {
						echo '<h3>'.$k1.'</h3>';
						$count1 = 0;
						foreach ($arrHospNo[$k1] as $k2=>$v2) {
							if ($count1>0 && $count1%4==0) { echo '<br>'; }
							echo '<div style="width:220px; display:inline-block;"><input type="checkbox" name="HospNo[]" value="'.getHospNo($v2).'" class="validate[minCheckbox[1]] checkbox" onclick="calcNo(\'HospNo[]\')">'.getHospNo($v2).' '.getPatientName($v2).' </div>';
							$count1++;
						}
					}
				}
				?>
			</td>
		</tr>
		<tr>
			<td class="title">Activity theme</td>
			<td colspan="3" style="text-align:left;"><input type="text" id="Q1" name="Q1" style="width:80%;" value="<?php echo $Q1; ?>"></td>
		</tr>
		<tr>
			<td class="title">Activity objectives</td>
			<td colspan="3" style="text-align:left;"><?php echo draw_checkbox_2col("Q2","Enhance cognition and thinking skills;Improve resident's short-term memory;Mindfulness training;Improve cognition of surrounding environment;Improve language skills;Enhance concept of time in daily activities;Slow down the degradation of cognition and memory;Improve conversation and interaction with the visiting family member(s)",$Q2,"multi"); ?>
			<div style="margin-left:18px;"><?php echo draw_checkbox("Q3","Increase sensory sensitivity",$Q3,"multi"); ?><div style="margin-left:48px;"><?php echo draw_option("Q4","Taste;Tactile;Proprioception;Sight;Thermoception;Hearing","xm","multi",$Q4,true,3);?></div><?php echo draw_checkbox("Q5","Strengthen contact to the real life and society to understand current affairs.;Other(please state) <input type=\"text\" id=\"Q5a\" name=\"Q5a\" value=\"".$Q5a."\">",$Q5,"multi"); ?></div>
			</td>
		</tr>
		<tr>
			<td class="title">Participants' activity level</td>
			<td><?php echo draw_option("Q6","Mild dementia;Mild disability;Moderate dementia;Moderate disability","xl","multi",$Q6,true,2);?></td>
			<td class="title">Number of group participant</td>
			<td><input type="text" id="Q7" name="Q7" size="3" value="<?php echo $Q1; ?>" readonly></td>
		</tr>
		<tr>
			<td class="title">Host</td>
			<td colspan="3" style="text-align:left;">
				<select name="Q8" id="Q8">
					<?php
					$EmpList = getWorkingStaff(1);
					foreach ($EmpList as $k=>$v) {
						echo '<option value="1_'.$k.'" '.('1_'.$k==$Q8?"selected":"").'>'.$v.'</option>';
					}
					?>
					<?php 
					$ForeignEmpList = getWorkingStaff(2);
					foreach ($ForeignEmpList as $k=>$v) {
						echo '<option value="2_'.$k.'" '.('2_'.$k==$Q8?"selected":"").'>'.$v.'</option>';		
					}
					?>
				</select>&nbsp;
				<input type="text" id="Q8a" name="Q8a" size="30"></td>
			</tr>
			<tr>
				<td class="title">
					<?php
					echo 'Assistive material';
					?>
				</td>
				<td colspan="3" style="text-align:left;"><input type="text" id="Q9" name="Q9" size="60" value="<?php echo $Q9; ?>"></td>
			</tr>
			<tr colspan="3" style="text-align:left;">
				<td class="title">Activity and guided topic</td>
				<td colspan="3"><textarea id="Q10" name="Q10" cols="30" rows="5"><?php echo $Q10; ?></textarea></td>
			</tr> 
			<tr>
				<td class="title">Notes</td>
				<td colspan="3" style="text-align:left;"><input type="text" id="Q11" name="Q11" size="60" value="<?php echo $Q11; ?>"></td>
			</tr>
			<tr>
				<td colspan="4" class="title"><input type="button" onClick="window.location.href='index.php?mod=socialwork&func=formview&id=8';" value="Back to list" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></td>
			</tr>
		</table>
	</form>
</div>
<script>
$("#socialform08").validationEngine();
$(function() {
	$("#Q8").change(function(){
		$("#Q8a").val($("#Q8 :selected").text());
	})
});
</script>