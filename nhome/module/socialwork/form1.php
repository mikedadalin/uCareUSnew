<?php
$pid = (int) @$_GET['pid'];
$db = new DB;
$db->query("SELECT `Gender_1`,`Gender_2`,`Postcode`,`Address`,`Address2`,`Address3`,`Address4`,`Address5` FROM `patient` WHERE `patientID`='".mysql_escape_string($pid)."'");
if ($db->num_rows()>0) {
	$r = $db->fetch_assoc();
	foreach ($r as $k=>$v) {
		$arrPatientInfo = explode("_",$k);
		if (count($arrPatientInfo)==2) {
			if ($v==1) {
				${$arrPatientInfo[0]} .= $arrPatientInfo[1].';';
			}
		} else {
			${$k} = $v;
		}
	}
}
	/*== 解 START ==*/
	$LWJArray = array('Postcode','Address','Address2','Address3','Address4','Address5');
	$LWJdataArray = array($Postcode,$Address,$Address2,$Address3,$Address4,$Address5);
	for($i=0;$i<count($LWJdataArray);$i++){
	    $rsa = new lwj('lwj/lwj');
	    $puepart = explode(" ",$LWJdataArray[$i]);
	    $puepartcount = count($puepart);
	    if($puepartcount>1){
            for($j=0;$j<$puepartcount;$j++){
                $prdpart = $rsa->privDecrypt($puepart[$j]);
                ${$LWJArray[$i]} = ${$LWJArray[$i]}.$prdpart;
            }
	    }else{
		   ${$LWJArray[$i]} = $rsa->privDecrypt($LWJdataArray[$i]);
	    }
	}
	/*== 解 END ==*/
if (@$_GET['date']=='') {
	$sql = "SELECT * FROM `socialform01` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql = "SELECT * FROM `socialform01` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`='".mysql_escape_string($_GET['date'])."'";
}
$db1 = new DB;
$db1->query($sql);
$r1 = $db1->fetch_assoc();
if ($db1->num_rows()>0) {
	foreach ($r1 as $k=>$v) {
		if (substr($k,0,1)=="Q") {
			$arrAnswer = explode("_",$k);
			if (count($arrAnswer)==2) {
				if ($v==1) {
					${$arrAnswer[0]} .= $arrAnswer[1].';';
				}
			} else {
				${$k} = $v;
			}
		}  else {
			${$k} = $v;
		}
	}
}

//護理表單01欄位
$db3 = new DB;
$db3->query("SELECT * FROM `nurseform01` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1");
$r3 = $db3->fetch_assoc();
if ($db3->num_rows()>0) { foreach ($r3 as $k=>$v) { if (substr($k,0,1)=="Q") { $arrAnswer = explode("_",$k); if (count($arrAnswer)==2) { if ($v==1) { ${'nurseform01_'.$arrAnswer[0]} .= $arrAnswer[1].';'; } } else { ${'nurseform01_'.$k} = $v; } }  else { ${'nurseform01_'.$k} = $v; } } }

//護理表單2a欄位
$db4 = new DB;
$db4->query("SELECT * FROM `nurseform02a` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1");
$r4 = $db4->fetch_assoc();
if ($db4->num_rows()>0) { foreach ($r4 as $k=>$v) { if (substr($k,0,1)=="Q") { $arrAnswer = explode("_",$k); if (count($arrAnswer)==2) { if ($v==1) { ${'nurseform02a_'.$arrAnswer[0]} .= $arrAnswer[1].';'; } } else { ${'nurseform02a_'.$k} = $v; } }  else { ${'nurseform02a_'.$k} = $v; } } }
?>
<script type="text/javascript">
$(document).ready(function () {
	$('#patient_Address').change(function (){
		$.ajax({
			url: 'class/state.php',
			cache: false,
			dataType: 'html',
			type:'GET',
			data: { state: $('#patient_Address').val() },
			error: function(xhr) {
				alert('Ajax request Error occur');
			},
			success: function(response){
				$('#patient_Address2').find('option').remove().end();
				var arr = response.split(/:/);
				for (i=0;i<=(arr.length-2);i++) {
					$('#patient_Address2').append('<option value="'+arr[i]+'">'+arr[i]+'</option>').val(arr[i]);
				}
				$('#patient_Address2').append('<option selected></option>').val();
			}
		});
	});
	$('#patient_Address2').change(function (){
		$.ajax({
			url: 'class/country.php',
			cache: false,
			dataType: 'html',
			type:'GET',
			data: { country: $('#patient_Address2').val(), state: $('#patient_Address').val()  },
			error: function(xhr) {
				alert('Ajax request Error occur');
			},
			success: function(response){
				$('#patient_Address3').find('option').remove().end();
				var arr = response.split(/:/);
				for (i=0;i<=(arr.length-2);i++) {
					$('#patient_Address3').append('<option value="'+arr[i]+'">'+arr[i]+'</option>').val(arr[i]);
				}
				$('#patient_Address3').append('<option selected></option>').val();
			}
		});
	});
	$('#patient_Address3').change(function (){
		$.ajax({
			url: 'class/city.php',
			cache: false,
			dataType: 'html',
			type:'GET',
			data: { city: $('#patient_Address3').val(), country: $('#patient_Address2').val(), state: $('#patient_Address').val() },
			error: function(xhr) {
				alert('Ajax request Error occur');
			},
			success: function(response){
				$('#patient_Postcode').find('option').remove().end();
				var arr = response.split(/:/);
				for (i=0;i<=(arr.length-2);i++) {
					$('#patient_Postcode').append('<option value="'+arr[i]+'">'+arr[i]+'</option>').val(arr[i]);
				}
				$('#patient_Postcode').append('<option selected></option>').val();
			}
		});
	});
});
function loadRoadNames(){
	var citySelected= $("#patient_Address3").val();
	var roadList = "";
	$.ajax({
		url: 'class/road.php',
		type: "POST",
		async: false,
		data: { city: citySelected}
	}).done(function(roads){
		roadList = roads.split(',');
	});
	return roadList;
}
function autocompleteRoads(){
	var roads = loadRoadNames();
	$("#patient_Address5").autocomplete({ source: roads });
}
});
</script>
<h3>社工訪視評估表</h3>
<form method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<table width="100%">
  <tr>
    <td class="title" width="80">Preliminary assessment date</td>
    <td colspan="5"><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if ($date != NULL) { echo formatdate($date); } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" /></td>
  </tr>
  <tr>
    <td class="title">Full name</td>
    <td><input type="text" name="Q3" id="Q3" size="12" value="<?php echo $name; ?>"></td>
    <td class="title">DOB</td>
    <td><script> $(function() { $( "#patient_Birth").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="patient_Birth" id="patient_Birth" value="<?php echo $birth; ?>" size="12" ></td>
    <td class="title">Gender </td>
    <td colspan="3"><?php echo draw_option("patient_Gender","Male;Female","s","single",$Gender,false,5); ?></td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td class="title">受訪者姓名</td>
    <td><input type="text" name="Q3a" id="Q3a" size="12" value="<?php echo $Q3a; ?>"></td>
    <td class="title">與案主關係</td>
    <td><input type="text" name="Q3b" id="Q3b" size="20" value="<?php echo $Q3b; ?>"></td>
  </tr>
  <tr>
    <td class="title">家屬聯絡電話</td>
    <td><input type="text" name="Q3c" id="Q3c" size="20" value="<?php echo $Q3c; ?>"></td>
    <td class="title">訪視地點</td>
    <td><input type="text" name="Q3d" id="Q3d" size="20" value="<?php echo $Q3d; ?>"></td>
  </tr>
  <tr>
    <td class="title" width="80">戶籍地 </td>
    <td colspan="3">
    <table class="tableinside" style="width:400px;">
      <tr style="height:12px;">
        <td width="60"><span style="font-size:8pt;">Postal code</span></td>
        <td width="60"><span style="font-size:8pt;">State</span></td>
        <td width="60"><span style="font-size:8pt;">Country</span></td>
      </tr>
      <tr>
        <td><?php echo zip_selection("patient_Postcode",$Address,$Address2,$Address3,$Postcode); ?></td>
		<td><?php echo state_selection("patient_Address",$Address); ?></td>
		<td><?php echo country_selection("patient_Address2",$Address,$Address2); ?></td>
        <td><?php echo city_selection("patient_Address3",$Address,$Address2,$Address3); ?></td>
        <td><input type="text" name="patient_Address4" id="patient_Address4" size="12" value="<?php echo $Address4; ?>" /></td>
        <td><input type="text" name="patient_Address5" id="patient_Address5" size="12" value="<?php echo $Address5; ?>" onkeyup="autocompleteRoads()" onclick="autocompleteRoads()" /></td>
      </tr>	
    </table>
    </td>
  </tr>
  <tr>
    <td class="title">溝通方式 </td>
    <td colspan="3"><?php echo draw_option("nurseform01_Qlang","English;Spanish;客語;原住民語;Other","m","single",$nurseform01_Qlang,false,5); ?> <input type="text" name="nurseform01_QlangOther" id="nurseform01_QlangOther" size="14" value="<?php echo $nurseform01_QlangOther; ?>"></td>
  </tr>
  <tr>
    <td rowspan="2" class="title">身 份 別 </td>
    <td class="title_s" width="80">Proof of major injury</td>
    <td colspan="2"><script> $(function() { $( "#Q22a").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><?php echo draw_checkbox("Q22","None;有，病名：<input type=\"text\" name=\"Q22b\" id=\"Q22b\" value=\"".$Q22b."\" size=\"15\">，到期年月日：<input type=\"text\" name=\"Q22a\" id=\"Q22a\" value=\"".$Q22a."\" size=\"8\">;有，永久有效",$Q22,"single"); ?></td>
  </tr>
  <tr>
    <td class="title_s" width="80">身心障礙證明</td>
    <td colspan="2"><?php echo draw_option("Qdisable","Has;None","s","multi",$Qdisable,false,5); ?><br />舊類別：
    <div class="formselect" style="display:inline;">
    <select name="QdisableTypeA" id="QdisableTypeA">
      <option value="0" <?php if ($QdisableTypeA==0) echo " selected"; ?>>None</option>
      <option value="">---------------舊制類別---------------</option>
      <option value="9" <?php if ($QdisableTypeA==9) echo " selected"; ?>>智能障礙者</option>
      <option value="10" <?php if ($QdisableTypeA==10) echo " selected"; ?>>vegetative being</option>
      <option value="11" <?php if ($QdisableTypeA==11) echo " selected"; ?>>失智症者</option>
      <option value="12" <?php if ($QdisableTypeA==12) echo " selected"; ?>>自閉症者</option>
      <option value="13" <?php if ($QdisableTypeA==13) echo " selected"; ?>>慢性精神病患者</option>
      <option value="14" <?php if ($QdisableTypeA==14) echo " selected"; ?>>頑性（難治型）癲癇症者</option>
      <option value="15" <?php if ($QdisableTypeA==15) echo " selected"; ?>>視覺障礙者</option>
      <option value="16" <?php if ($QdisableTypeA==16) echo " selected"; ?>>聽覺機能障礙者</option>
      <option value="17" <?php if ($QdisableTypeA==17) echo " selected"; ?>>平衡機能障礙者</option>
      <option value="18" <?php if ($QdisableTypeA==18) echo " selected"; ?>>聲音機能或語言機能障礙者</option>
      <option value="19" <?php if ($QdisableTypeA==19) echo " selected"; ?>>重要器官失去功能者-心臟</option>
      <option value="20" <?php if ($QdisableTypeA==20) echo " selected"; ?>>重要器官失去功能者-造血機能</option>
      <option value="21" <?php if ($QdisableTypeA==21) echo " selected"; ?>>重要器官失去功能者-呼吸器官</option>
      <option value="22" <?php if ($QdisableTypeA==22) echo " selected"; ?>>重要器官失去功能-吞嚥機能</option>
      <option value="23" <?php if ($QdisableTypeA==23) echo " selected"; ?>>重要器官失去功能-胃</option>
      <option value="24" <?php if ($QdisableTypeA==24) echo " selected"; ?>>重要器官失去功能-腸道</option>
      <option value="25" <?php if ($QdisableTypeA==25) echo " selected"; ?>>重要器官失去功能-肝臟</option>
      <option value="26" <?php if ($QdisableTypeA==26) echo " selected"; ?>>重要器官失去功能-腎臟</option>
      <option value="27" <?php if ($QdisableTypeA==27) echo " selected"; ?>>重要器官失去功能-膀胱</option>
      <option value="28" <?php if ($QdisableTypeA==28) echo " selected"; ?>>肢體障礙者</option>
      <option value="29" <?php if ($QdisableTypeA==29) echo " selected"; ?>>顏面損傷者</option>
      <option value="30" <?php if ($QdisableTypeA==30) echo " selected"; ?>>多重障礙者</option>
      <option value="31" <?php if ($QdisableTypeA==31) echo " selected"; ?>>經中央衛生主管機關認定，因罕見疾病而致身心功能障礙者</option>
      <option value="32" <?php if ($QdisableTypeA==32) echo " selected"; ?>>其他經中央衛生主管機關認定之障礙者(染色體異常、先天代謝異常、先天缺陷)</option>
    </select>
    </div><br />
    <div class="formselect">Category:
    <?php echo draw_checkbox_2col("QdisableTypeB","None;Class 1: Nervous system, structural impaired or mentally challenged;Class 2: Eye, ear or related sensors structural impair;Class 3 : Voicing or structure related to speech dysfunction;Class 4 : Circulation, hematopoiesis or immune system dysfunction;Class 5 : Digestion, metabolism and endocrine system dysfunction;Class 6 : Urinary and reproductive system dysfunction;Class 7 : Nuron, muscles and bone motion dysfunction;Class 8 : Skin and related structure dysfunction",$QdisableTypeB,"multi"); ?>
    </select>
    </div><br />
    <div class="formselect" style="margin-left:30px; display:inline;">Severity:
    <select name="QdisableLevel" id="QdisableLevel">
      <option value="0" <?php if ($QdisableLevel==0) echo " selected"; ?>>None</option>
      <option value="1" <?php if ($QdisableLevel==1) echo " selected"; ?>>Mild</option>
      <option value="2" <?php if ($QdisableLevel==2) echo " selected"; ?>>Moderate</option>
      <option value="3" <?php if ($QdisableLevel==3) echo " selected"; ?>>Severe</option>
      <option value="4" <?php if ($QdisableLevel==4) echo " selected"; ?>>Extremely severe</option>
    </select>
    </div>
    <script> $(function() { $( "#Qdisableexpiry").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script>Validity period:<input type="text" name="Qdisableexpiry" id="Qdisableexpiry" value="<?php echo $Qdisableexpiry; ?>" size="10"> <input type="button" id="newrecord" value="Set reminder" /></td>
  </tr>
  <tr>
    <?php
	$arrNurseform02a_Q13 = array("1"=>"Literate", "2"=>"Illiterate");
	$arrNurseform02a_Q14 = array("1"=>"Elementary school", "2"=>"Middle school", "3"=>"High school", "4"=>"University", "5"=>"Grad School");
	?>
    <td class="title">個案史</td>
    <td colspan="3">
    <textarea name="Q24" id="Q24" cols="60" rows="6" ><?php echo $Q24; ?></textarea></td>
  </tr>
  <tr>
    <td class="title">Family tree</td>
    <td colspan="3">
    <script>$(function() { $( "#tabs_familystructure" ).tabs(); }); </script>
    <div id="tabs_familystructure">
      <ul>
        <li><a href="#fstabs-1">Upload image</a></li>
        <li><a href="#fstabs-2">System image</a></li>
      </ul>
      <div id="fstabs-1">
      <input type="button" value="Upload image" onclick="window.open('class/uploadfiles.php?pid=<?php echo @$_GET['pid']; ?>&date='+document.getElementById('date').value);" class="printcol">
      <?php
	  if ($QFamilyTreeJPG!="") {
		  echo '<img id="fsjpg" src="socialform01_pic/'.$_SESSION['nOrgID_lwj'].'/'.$QFamilyTreeJPG.'" border="0" width="800">';
	  } else {
		  echo '<img id="fsjpg" border="0" width="800" style="display:none;">';
	  }?>
      </div>
      <div id="fstabs-2">
      <iframe src="module/nurseform/form1a_1.php?pid=<?php echo $_GET['pid']; ?>" width="100%" height="720" frameborder="0"></iframe>
      </div>
    </div>
    </td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td rowspan="6" class="title" width="80">Psychological level </td>
    <td class="title_s" width="80">Emotional status</td>
    <td colspan="2"><?php echo draw_option("Q26","Stable;Depression;Anxiety;Impulsive;Temper easily;Unassessable","m","single",$Q26,true,6); ?></td>
  </tr>
  <tr>
    <td class="title_s">Behavior</td>
    <td colspan="2"><?php echo draw_option("Q27","Appropriate;Slow;Assault;Flinch;Impatient;Wandering;Giggling;Irritable;Unassessable","m","single",$Q27,true,6); ?></td>
  </tr>
  <tr>
    <td class="title_s">Attitude</td>
    <td colspan="2"><?php echo draw_option("Q28","Friendly;Hostile;Wary;Uncooperative;Refuse;Stubborn;Suspicious;Unassessable","m","single",$Q28,true,6); ?></td>
  </tr>
  <tr>
    <td class="title_s">注 意 力</td>
    <td colspan="2"><?php echo draw_option("Q29","Concentrate;Poor;Excessive concentration;Unassessable","m","single",$Q29,true,6); ?></td>
  </tr>
  <tr>
    <td class="title_s">Cogitation</td>
    <td colspan="2"><?php echo draw_option("Q30","Normal;Delusions;Relaxation;Lack;Jumping/Leaping;Unassessable","m","single",$Q30,true,6); ?></td>
  </tr>
  <tr>
    <td class="title_s">Comprehension</td>
    <td colspan="2"><?php echo draw_option("Q31","Good;Normal;Poor;Unassessable","l","single",$Q31,true,6); ?></td>
  </tr>
  <tr>
    <td rowspan="5" class="title">Social dimension </td>
    <td class="title_s">Social skills</td>
    <td colspan="2"><?php echo draw_option("Q32","Active / easy to make friends;Fair;Passive / depend on other;Loner;Resist;Unassessable","l","single",$Q32,true,3); ?></td>
  </tr>
  <tr>
    <td class="title_s">Ability to communicate:</td>
    <td colspan="2"><?php echo draw_option("Q33","Normal;Semantic confusion;Language barrier;Strong accent;Body movements;Unassessable","l","single",$Q33,true,3); ?></td>
  </tr>
  <tr>
    <td class="title_s">Interacting with relatives</td>
    <td colspan="2"><?php echo draw_option("Q34","Good;Basic Interaction;Isolated;No relatives;Other","l","single",$Q34,true,3); ?> <input type="text" name="Q35" id="35" size="18"  value="<?php echo $Q35; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Interacting with friends</td>
    <td colspan="2"><?php echo draw_option("Q36","Frequently and good;Occasional;Never;No friend;Other","l","single",$Q36,true,3); ?> <input type="text" name="Q37" id="Q37" size="18"  value="<?php echo $Q37; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Interacting with neighbors</td>
    <td colspan="2"><?php echo draw_option("Q38","Frequently and good;Occasional;Never;No neighbor;Other","l","single",$Q38,true,3); ?> <input type="text" name="Q39" id="Q39" size="18"  value="<?php echo $Q39; ?>" /></td>
  </tr>
  
  <tr>
    <td rowspan="2" class="title">經濟層面 </td>
    <td class="title_s">Social resource</td>
    <td colspan="2"><textarea name="Q41" id="Q41" cols="60" rows="3" ><?php echo $Q41; ?></textarea></td>
  </tr>
  <tr>
    <td class="title_s">Economic sources</td>
    <td colspan="2"><textarea name="Q42" id="Q42" cols="60" rows="3" ><?php echo $Q42; ?></textarea></td>
  </tr>
  <tr>
    <td rowspan="3" class="title">初步評估<br>與建議</td>
    <td class="title_s">長輩入住<br>評估</td>
    <td colspan="2"><?php echo draw_option("Q43","適宜;不適宜;Other","m","single",$Q43,true,3); ?> <input type="text" name="Q44" id="Q44" size="18"  value="<?php echo $Q44; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Admission information</td>
    <td colspan="2"><?php echo draw_checkbox_2col("Q45","Physical examination report;Admission note;Contract and appendix signature;Open case description",$Q45,"multi"); ?></td>
  </tr>
  <tr>
    <td colspan="3"><textarea name="Q40" id="Q40" cols="60" rows="6" ><?php echo $Q40; ?></textarea></td>
  </tr>
</table>
<center><input type="hidden" name="formID" id="formID" value="socialform01" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></center>
</form>