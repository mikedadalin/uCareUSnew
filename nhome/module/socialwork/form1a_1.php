<?php
$pid = (int) @$_GET['pid'];
$db = new DB;
$db->query("SELECT * FROM `patient` WHERE `patientID`='".mysql_escape_string($pid)."'");
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
	$LWJArray = array('Name1','Name2','Name3','Name4','IdNo','MedicalRecordNumber','Nickname','MedicareNumber','MedicaidNumber','Postcode','Address','Address2','Address3','Address4','Address5');
	$LWJdataArray = array($Name1,$Name2,$Name3,$Name4,$IdNo,$MedicalRecordNumber,$Nickname,$MedicareNumber,$MedicaidNumber,$Postcode,$Address,$Address2,$Address3,$Address4,$Address5);
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
   /*===== 身高轉換 START =====*/
   $inch = $height;
   $feet = floor($inch/12);
   $inch = $inch%12;
   $height = $feet."'".$inch;
   /*===== 身高轉換 END =====*/
if (@$_GET['date']=='') {
	$sql = "SELECT * FROM `nurseform01` WHERE `HospNo`='".mysql_escape_string($r['HospNo'])."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql = "SELECT * FROM `nurseform01` WHERE `HospNo`='".mysql_escape_string($r['HospNo'])."' AND `date`='".mysql_escape_string($_GET['date'])."'";
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
	/*== 解 START ==*/
	$LWJArray = array('QContactPerson1Name','QContactPerson1Company','QContactPerson1Tel1','QContactPerson1Tel2','QContactPerson1Tel3','QContactPerson1Address','QContactPerson1Email','QContactPerson2Name','QContactPerson2Company','QContactPerson2Tel1','QContactPerson2Tel2','QContactPerson2Tel3','QContactPerson2Address','QContactPerson2Email','QContactPerson3Name','QContactPerson3Company','QContactPerson3Tel1','QContactPerson3Tel2','QContactPerson3Tel3','QContactPerson3Address','QContactPerson3Email','QContactPerson4Name','QContactPerson4Company','QContactPerson4Tel1','QContactPerson4Tel2','QContactPerson4Tel3','QContactPerson4Address','QContactPerson4Email');
	$LWJdataArray = array($QContactPerson1Name,$QContactPerson1Company,$QContactPerson1Tel1,$QContactPerson1Tel2,$QContactPerson1Tel3,$QContactPerson1Address,$QContactPerson1Email,$QContactPerson2Name,$QContactPerson2Company,$QContactPerson2Tel1,$QContactPerson2Tel2,$QContactPerson2Tel3,$QContactPerson2Address,$QContactPerson2Email,$QContactPerson3Name,$QContactPerson3Company,$QContactPerson3Tel1,$QContactPerson3Tel2,$QContactPerson3Tel3,$QContactPerson3Address,$QContactPerson3Email,$QContactPerson4Name,$QContactPerson4Company,$QContactPerson4Tel1,$QContactPerson4Tel2,$QContactPerson4Tel3,$QContactPerson4Address,$QContactPerson4Email);
	for($z=0;$z<count($LWJdataArray);$z++){
	    $rsa = new lwj('lwj/lwj');
	    $puepart = explode(" ",$LWJdataArray[$z]);
	    $puepartcount = count($puepart);
	    if($puepartcount>1){
            for($m=0;$m<$puepartcount;$m++){
                $prdpart = $rsa->privDecrypt($puepart[$m]);
                ${$LWJArray[$z]} = ${$LWJArray[$z]}.$prdpart;
            }
	    }else{
		   ${$LWJArray[$z]} = $rsa->privDecrypt($LWJdataArray[$z]);
	    }
	}
	/*== 解 END ==*/
$db2 = new DB;
$db2->query("SELECT `indate` FROM `inpatientinfo` WHERE `patientID`='".mysql_escape_string($pid)."'");
$r2 = $db2->fetch_assoc();
?>
<script type="text/javascript">
$(document).ready(function () {
	$('#patient_Address').change(function (){
		$.ajax({
			url: 'class/state.php',
			async: false,
			type:'POST',
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
			async: false,
			type:'POST',
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
			async: false,
			type:'POST',
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

function loadICDNames(id){
	var icdList = "";
	$.ajax({
		url: 'class/icd.php',
		type: "POST",
		async: false,
		data: { icdinput: $('#'+id).val() }
	}).done(function(data){
		icdList = data.split(';');
	});
	return icdList;
}
function autocompleteICD(id){
	var icdoutput = loadICDNames(id);
	$("#"+id).autocomplete({ source: icdoutput, minLength:3 });
}
$(function() {
    $( "#dialog-form" ).dialog({
		autoOpen: false,
		height: 250,
		width: 660,
		modal: true,
		buttons: {
			"Set reminder": function() {
				$.ajax({
					url: "class/setreminder.php",
					type: "POST",
					data: { "HospNo": $("#HospNo").val(), "QremindContent": $("#QremindContent").val(), "QremindDate": $("#QremindDate").val(), "active": '1' },
					success: function(data) {
						$( "#dialog-form" ).dialog( "close" );
						alert("Set up successfully!");
					}
				});
			},
			"Cancel": function() {
				$( "#dialog-form" ).dialog( "close" );
			}
		}
	});
});
function dialogform_set_1(){
	$("#QremindDate").val($("#Qdisableexpiry").val());
	$("#QremindContent").val('身心障礙手冊將於 ' + $("#Qdisableexpiry").val() + ' 到期');
	openVerificationForm('#dialog-form');
}
</script>
<div id="dialog-form" title="Set reminder" class="dialog-form"> 
  <form>
  <fieldset>
    <table>
      <tr>
        <td class="title">Remind date</td>
        <td><script> $(function() { $( "#QremindDate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="QremindDate" id="QremindDate" size="12"> </td>
      </tr>
      <tr>
        <td class="title">Reminder content</td>
        <td><input type="text" name="QremindContent" id="QremindContent" size="60" ><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /></td>
      </tr>
    </table>
  </fieldset>
  </form>
</div>
<form  method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save" style="width:100%">
<h3><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Resident's profile"; }else{ echo $word_1; } ?></h3>
<table width="100%">
  <tr>
    <td width="120" class="title"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Name"; }else{ echo $word_2; } ?></td>
    <td colspan="3" width="400">
	  <?php
        if (substr($url[3],0,5)!="print"){
	        echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ';
	        if($_SESSION['LanguangNumber_lwj']==1){ echo "First name"; }else{ echo $word_Name1; } 
	        echo ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ';
	        if($_SESSION['LanguangNumber_lwj']==1){ echo "Middle initial"; }else{ echo $word_Name2; } 
	        echo ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ';
	        if($_SESSION['LanguangNumber_lwj']==1){ echo "Last name"; }else{ echo $word_Name3; } 
	        echo ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ';
	        if($_SESSION['LanguangNumber_lwj']==1){ echo "Suffix"; }else{ echo $word_Name4; } 
	        echo '<br>';
		}
      ?>
	  <input type="text" name="patient_Name1" id="patient_Name1" size="12" value="<?php echo $Name1; ?>" >
	  <input type="text" name="patient_Name2" id="patient_Name2" size="12" value="<?php echo $Name2; ?>" >
	  <input type="text" name="patient_Name3" id="patient_Name3" size="12" value="<?php echo $Name3; ?>" >
	  <input type="text" name="patient_Name4" id="patient_Name4" size="12" value="<?php echo $Name4; ?>" >
	</td>
    <td rowspan="12" width="200" align="right" valign="top">
    <?php
	$dbPhoto = new DB;
	$dbPhoto->query("SELECT * FROM `pat_idphoto` WHERE `HospNo`='".$HospNo."'");
	$rPhoto = $dbPhoto->fetch_assoc();
	$photo = $rPhoto['photo'];
	$filename = 'uploadfile/'.$_SESSION['nOrgID_lwj'].'/'.$HospNo.'/'.$photo;
	if ($photo=="") {
	?>
    <img id="fsjpg" src="Images/noImage.png" width="180"/>
    <?php }else{?>
	<?php echo '<img id="fsjpg" src="'.$filename.'" border="0" width="180">'; ?>
    <?php }?><br><input type="button" value="upload resident photo" onclick="window.open('class/uploadfilesPatPic.php?pid=<?php echo $_GET['pid']; ?>');" class="printcol">
    </td>
  </tr>
  <tr>
    <td class="title"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Nickname"; }else{ echo $word_3; } ?></td>
    <td colspan="3"><input type="text" name="patient_Nickname" id="patient_Nickname" value="<?php echo $Nickname; ?>"/></td>
  </tr>
  <tr>
    <td width="120" class="title"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Gender"; }else{ echo $word_4; } ?></td>
    <td width="250"><?php echo draw_option("patient_Gender",$word_Gender,"xs","single",$Gender,false,5); ?></td>
	<td class="title"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Race/Ethnicity"; }else{ echo $word_5; } ?></td>
    <td>
      <select id="patient_Race" name="patient_Race">
   	    <option></option>
	    <option value="A" <?php if ($Race=="A") echo " selected"; ?>><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "American Indian or Alaska Native"; }else{ echo $word_RaceA; } ?></option>
	    <option value="B" <?php if ($Race=="B") echo " selected"; ?>><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Asian"; }else{ echo $word_RaceB; } ?></option>
	    <option value="C" <?php if ($Race=="C") echo " selected"; ?>><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Black or African American"; }else{ echo $word_RaceC; } ?></option>
	    <option value="D" <?php if ($Race=="D") echo " selected"; ?>><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Hispanic or Latino"; }else{ echo $word_RaceD; } ?></option>
	    <option value="E" <?php if ($Race=="E") echo " selected"; ?>><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Native Hawaiian or Other Pacific Islander"; }else{ echo $word_RaceE; } ?></option>
	    <option value="F" <?php if ($Race=="F") echo " selected"; ?>><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "White"; }else{ echo $word_RaceF; } ?></option>
	  </select>
    </td>
  </tr>
  <tr>
    <td class="title"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "SSN"; }else{ echo $word_6; } ?></td>
    <td><input type="text" name="patient_IdNo" id="patient_IdNo" size="12" value="<?php echo $IdNo; ?>"></td>
    <td class="title"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "DOB"; }else{ echo $word_7; } ?></td>
    <td><script> $(function() { $( "#patient_Birth").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="patient_Birth" id="patient_Birth" value="<?php echo formatdate($Birth); ?>" size="12" ></td>
  </tr>
  <tr>
    <td class="title"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Birthplace"; }else{ echo $word_8; } ?></td>
    <td><input type="text" name="patient_Birthplace" id="patient_Birthplace" size="12" value="<?php echo $Birthplace; ?>" /></td>
    <td class="title"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Note"; }else{ echo $word_9; } ?></td>
    <td><?php echo draw_option("Qmemo",$word_Qmemo,"xm","multi",$Qmemo,false,3); ?></td>
  </tr>
  <tr>
    <td class="title"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Height"; }else{ echo $word_10; } ?></td>
    <td><input type="text" name="patient_height" id="patient_height" size="12" value="<?php echo $height; ?>"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "(e.g. 5'11)"; }else{ echo $word_height; } ?></td>
    <td class="title"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Weight (admission)"; }else{ echo $word_11; } ?></td>
    <td>
	<?php
	/* 原V
	$inBW = getTitle('vitalsigns','Value',$pid,'PersonID',"","RecordedTime","ASC","AND (`LoincCode`='18833-4' OR `LoincCode`='3141-9')");
	if ($inBW!="") { echo $inBW.' lbs'; }
	*/
	// 新V START
	$inBW = getTitle('vitalsign','loinc_18833_4',$pid,'PatientID',"","date","ASC, `time` ASC","AND `loinc_18833_4`!=''");
	if ($inBW!="") { echo $inBW.' lbs'; }
	// 新V END
	?>
	</td>
  </tr>
  <tr>
    <td class="title"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Entered from"; }else{ echo $word_12; } ?></td>
    <td>
	<div class="formselect" style="display:inline;">
    <select name="Qcomingsource" id="Qcomingsource">
      <option></option>
      <option value="1" <?php if ($Qcomingsource==1) echo " selected"; ?>>Community</option>
      <option value="2" <?php if ($Qcomingsource==2) echo " selected"; ?>>Another nursing home or swing bed</option>
      <option value="3" <?php if ($Qcomingsource==3) echo " selected"; ?>>Acute hospital</option>
      <option value="4" <?php if ($Qcomingsource==4) echo " selected"; ?>>uCare</option>
      <option value="5" <?php if ($Qcomingsource==5) echo " selected"; ?>>Psychiatric hospital</option>
      <option value="6" <?php if ($Qcomingsource==6) echo " selected"; ?>>Inpatient rehabilitation facility</option>
      <option value="7" <?php if ($Qcomingsource==7) echo " selected"; ?>>ID/DD facility</option>
      <option value="8" <?php if ($Qcomingsource==8) echo " selected"; ?>>Hospice</option>
      <option value="9" <?php if ($Qcomingsource==9) echo " selected"; ?>>Long Term Care Hospital(LTCH)</option>
      <option value="10" <?php if ($Qcomingsource==10) echo " selected"; ?>>Other</option>
    </select>
    </div>
	</td>
    <td class="title"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Admission date"; }else{ echo $word_13; } ?></span></td>
    <td><script> $(function() { $( "#inpatientinfo_indate").datetimepicker({allowBlank: true, format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" id="inpatientinfo_indate" name="inpatientinfo_indate" value="<?php echo formatdate($r2['indate']); ?>" size="12" /></td>
  </tr>
  <tr>
    <td class="title"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Medical record number"; }else{ echo $word_14; } ?></td>
    <td colspan="3"><input type="text" name="patient_MedicalRecordNumber" id="patient_MedicalRecordNumber" value="<?php echo $MedicalRecordNumber;?>"/></td>
  </tr>
  <tr>
    <td class="title"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Medicaid Number"; }else{ echo $word_15; } ?></td>
    <td colspan="3">
	  <input type="text" name="patient_MedicaidNumber" id="patient_MedicaidNumber" value="<?php echo $MedicaidNumber;?>"/>
	  <?php echo draw_option("patient_QMedicaidStatus",$word_QMedicaidStatus,"xl","single",$QMedicaidStatus,false,2); ?>
	</td>
  </tr>
  <tr>
    <td class="title"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Medicare number"; }else{ echo $word_16; } ?></td>
    <td><input type="text" name="patient_MedicareNumber" id="patient_MedicareNumber" value="<?php echo $MedicareNumber;?>"/></td>
    <td class="title"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Medicare-covered stay"; }else{ echo $word_17; } ?></td>
    <td><?php echo draw_option("patient_QMedicareCovered",$word_QMedicareCovered,"m","single",$QMedicareCovered,false,2); ?></td>
  </tr>
  <tr>
    <td class="title"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Start date of Medicare stay"; }else{ echo $word_18; } ?></td>
    <td><script> $(function() { $( "#patient_MedicareStartDate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" size="18" name="patient_MedicareStartDate" id="patient_MedicareStartDate" value="<?php echo formatdate($MedicareStartDate);?>"></b></td>
    <td class="title"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "End date of Medicare stay"; }else{ echo $word_19; } ?></span></td>
    <td><script> $(function() { $( "#patient_MedicareEndDate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" size="18" name="patient_MedicareEndDate" id="patient_MedicareEndDate" value="<?php echo formatdate($MedicareEndDate);?>"></b></td>
  </tr>
  <tr>
    <td class="title"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Residence address"; }else{ echo $word_20; } ?></td>
    <td colspan="3">
    <table class="tableinside">
      <tr style="height:12px" class="printcol">
        <td width="60"><span style="font-size:8pt;"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Postal code"; }else{ echo $word_Postcode; } ?></span></td>
        <td width="60"><span style="font-size:8pt;"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "State"; }else{ echo $word_Address; } ?></span></td>
	    <td width="60"><span style="font-size:8pt;"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Country"; }else{ echo $word_Address2; } ?></span></td>	
        <td width="60"><span style="font-size:8pt;"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "City"; }else{ echo $word_Address3; } ?></span></td>
        <td width="60"><span style="font-size:8pt;"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Address 1"; }else{ echo $word_Address4; } ?></span></td>
        <td width="60"><span style="font-size:8pt;"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Address 2"; }else{ echo $word_Address5; } ?></span></td>
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
</table>
<table width="100%">
  <tr>
    <td width="120" class="title" rowspan="4"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Diagnosis"; }else{ echo $word_21; } ?></td>
    <td colspan="2" width="43%">1. <input type="text" name="Qdiag1" id="Qdiag1" size="20" value="<?php echo $Qdiag1; ?>"  onkeyup="autocompleteICD(this.id)"/></td>
    <td colspan="3" width="43%">5. <input type="text" name="Qdiag5" id="Qdiag5" size="20" value="<?php echo $Qdiag5; ?>"  onkeyup="autocompleteICD(this.id)"/></td>
  </tr>
  <tr>
    <td colspan="2">2. <input type="text" name="Qdiag2" id="Qdiag2" size="20" value="<?php echo $Qdiag2; ?>"  onkeyup="autocompleteICD(this.id)"/></td>
    <td colspan="3">6. <input type="text" name="Qdiag6" id="Qdiag6" size="20" value="<?php echo $Qdiag6; ?>"  onkeyup="autocompleteICD(this.id)"/></td>
  </tr>
  <tr>
    <td colspan="2">3. <input type="text" name="Qdiag3" id="Qdiag3" size="20" value="<?php echo $Qdiag3; ?>"  onkeyup="autocompleteICD(this.id)"/></td>
    <td colspan="3">7. <input type="text" name="Qdiag7" id="Qdiag7" size="20" value="<?php echo $Qdiag7; ?>"  onkeyup="autocompleteICD(this.id)"/></td>
  </tr>
  <tr>
    <td colspan="2">4. <input type="text" name="Qdiag4" id="Qdiag4" size="20" value="<?php echo $Qdiag4; ?>"  onkeyup="autocompleteICD(this.id)"/></td>
    <td colspan="3">8. <input type="text" name="Qdiag8" id="Qdiag8" size="20" value="<?php echo $Qdiag8; ?>"  onkeyup="autocompleteICD(this.id)"/></td>
  </tr>
  <tr>
    <td class="title"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Disability Manual"; }else{ echo $word_22; } ?></td>
    <td width="160" colspan="5"><?php echo draw_option("Qdisable",$word_Qdisable,"xs","multi",$Qdisable,false,5); ?><br /><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Old category："; }else{ echo $word_QdisableTypeA; } ?>
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
    <div class="formselect"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "New category："; }else{ echo $word_QdisableTypeB0; } ?>
    <?php echo draw_checkbox_2col("QdisableTypeB",$word_QdisableTypeB,$QdisableTypeB,"multi"); ?>
    </select>
    </div><br />
    <div class="formselect" style="margin-left:30px; display:inline;"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Level："; }else{ echo $word_QdisableLevel; } ?>
    <select name="QdisableLevel" id="QdisableLevel">
      <option value="0" <?php if ($QdisableLevel==0) echo " selected"; ?>><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "None"; }else{ echo $word_QdisableLevel0; } ?></option>
      <option value="1" <?php if ($QdisableLevel==1) echo " selected"; ?>><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Mild"; }else{ echo $word_QdisableLevel1; } ?></option>
      <option value="2" <?php if ($QdisableLevel==2) echo " selected"; ?>><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Moderate"; }else{ echo $word_QdisableLevel2; } ?></option>
      <option value="3" <?php if ($QdisableLevel==3) echo " selected"; ?>><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Severe"; }else{ echo $word_QdisableLevel3; } ?></option>
      <option value="4" <?php if ($QdisableLevel==4) echo " selected"; ?>><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Very severe"; }else{ echo $word_QdisableLevel4; } ?></option>
    </select>
    </div>
    <script> $(function() { $( "#Qdisableexpiry").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Validity period："; }else{ echo $word_Qdisableexpiry; } ?><input type="text" name="Qdisableexpiry" id="Qdisableexpiry" value="<?php echo $Qdisableexpiry;?>" size="10"> <input type="button" id="newrecord" value="<?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Set Reminder"; }else{ echo $word_newrecord; } ?>" onclick="dialogform_set_1();" />
    </td>
  </tr>
  <tr>
    <td class="title"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Major injuries Cards"; }else{ echo $word_23; } ?></td>
    <td><?php echo draw_option("QillnessCard",$word_QillnessCard,"xs","multi",$QillnessCard,false,5); ?></td>
    <td class="title"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Major injuries name"; }else{ echo $word_24; } ?></td>
    <td colspan="3"><input type="text" name="QillnessName" id="QillnessName" value="<?php echo $QillnessName; ?>" size="24"></td>
  </tr>
  <tr>

    <td class="title"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Admission category"; }else{ echo $word_25; } ?></td>
    <td colspan="5"><?php echo draw_option("QillnessType",$word_QillnessType,"l","multi",$QillnessType,false,5); ?> <input type="text" name="QillnessTypeOther" id="QillnessTypeOther" value="<?php echo $QillnessTypeOther; ?>" size="24"><br /><?php echo draw_option("QillnessTypeB",$word_QillnessTypeB,"xm","multi",$QillnessTypeB,true,4); ?> <input type="text" name="QillnessTypeBOther" id="QillnessTypeBOther" value="<?php echo $QillnessTypeBOther; ?>" size="24"></td>
  </tr>
  <tr>
    <td class="title"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Preferred hospital for visit"; }else{ echo $word_26; } ?></td>
    <td colspan="5"><input type="text" name="QassignHosp" id="QassignHosp" value="<?php echo $QassignHosp; ?>" size="80"></td>
  </tr>
  <?php
  //檢查欄位是否存在
  $dbNumFields = new DB;
  $dbNumFields->query("SELECT * FROM `nurseform01` LIMIT 0,1");
  $rNumFields = $dbNumFields->num_fields();
  $field_array = array();
  for ($i=0;$i<$rNumFields;$i++) {
	  $dbFieldName = new DB;
	  $dbFieldName->query("SELECT * FROM `nurseform01` LIMIT 0,1");
	  $rFieldName = $dbFieldName->field_name($i);
	  if (substr($rFieldName,0,9)=="QemgHosp_") { $field_array[$i] = $rFieldName; }
  }
  if (count($field_array)<21) {
	  if (!in_array('QemgHosp_21',$field_array)) {
		  $dbU1 = new DB;
		  $dbU1->query('ALTER TABLE  `nurseform01` CHANGE  `QemgHosp_'.count($field_array).'`  `QemgHosp_21` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;');
		  $movedCol = count($field_array);
	  }
	  for ($i=$movedCol;$i<=20;$i++) {
		  $dbU2 = new DB;
		  $dbU2->query('ALTER TABLE  `nurseform01` ADD  `QemgHosp_'.$i.'` TEXT NOT NULL AFTER  `QemgHosp_'.($i-1).'` ;');
	  }
  }
  //讀取系統設定
  $dbHosp = new DB2;
  $dbHosp->query("SELECT * FROM system_setting WHERE `OrgID`='".$_SESSION['nOrgID_lwj']."'");
  $rHosp = $dbHosp->fetch_assoc();
  $HospTxt ='';
  for ($i1=1;$i1<=20;$i1++) {
	  if ($rHosp['Hosp'.$i1]!="") { $HospTxt .= $rHosp['Hosp'.$i1].';'; }
  }
  $HospTxt .= "Other";
  ?>
  <tr>
    <td class="title"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Preferred hospital for emergency"; }else{ echo $word_27; } ?></td>
    <td colspan="5"><?php echo draw_option("QemgHosp",$HospTxt,"l","multi",$QemgHosp,true,5); ?> <input type="text" name="QemgHospOther" id="QemgHospOther" size="24" value="<?php echo $QemgHospOther; ?>"></td>
  </tr>
  <tr>
    <td class="title"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Preferred Language"; }else{ echo $word_28; } ?></td>
    <td colspan="5"><?php echo draw_option("Qlang",$word_Qlang,"m","multi",$Qlang,false,5); ?> <input type="text" name="QlangOther" id="QlangOther" size="24" value="<?php echo $QlangOther; ?>"></td>
  </tr>
  <tr>
    <td class="title"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Speech Clariy"; }else{ echo $word_29; } ?></td>
    <td colspan="5"><?php echo draw_option("Qexpress",$word_Qexpress,"l","multi",$Qexpress,false,5); ?></td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td colspan="6" class="title"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Client (primary contact person)"; }else{ echo $word_30; } ?></td>
  </tr>
  <tr>
    <td class="title"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Name"; }else{ echo $word_2; } ?></td>
    <td><input type="text" name="QContactPerson1Name" id="QContactPerson1Name" size="10" value="<?php echo $QContactPerson1Name; ?>"></td>
    <td class="title"><?php echo $word_7;?></td>
    <td><script> $(function() { $( "#QContactPerson1Birth").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="QContactPerson1Birth" id="QContactPerson1Birth" size="10" value="<?php echo $QContactPerson1Birth; ?>"></td>
    <td class="title"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Relationship"; }else{ echo $word_31; } ?></td>
    <td><input type="text" name="QContactPerson1Relate" id="QContactPerson1Relate" size="10" value="<?php echo $QContactPerson1Relate; ?>"></td>
  </tr>
  <tr>
    <td class="title"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Serving unit"; }else{ echo $word_32; } ?></td>
    <td colspan="3"><input type="text" name="QContactPerson1Company" id="QContactPerson1Company" size="60" value="<?php echo $QContactPerson1Company; ?>"></td>
    <td class="title"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Occupation"; }else{ echo $word_33; } ?></td>
    <td><input type="text" name="QContactPerson1Position" id="QContactPerson1Position" size="10" value="<?php echo $QContactPerson1Position; ?>"></td>
  </tr>
  <tr>
    <td class="title"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Phone #(H)"; }else{ echo $word_34; } ?></td>
    <td><input type="text" name="QContactPerson1Tel1" id="QContactPerson1Tel1" size="18" value="<?php echo $QContactPerson1Tel1; ?>"></td>
    <td class="title"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Phone #(W)"; }else{ echo $word_35; } ?></td>
    <td><input type="text" name="QContactPerson1Tel2" id="QContactPerson1Tel2" size="18" value="<?php echo $QContactPerson1Tel2; ?>"></td>
    <td class="title"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Cell phone #"; }else{ echo $word_36; } ?></td>
    <td><input type="text" name="QContactPerson1Tel3" id="QContactPerson1Tel3" size="18" value="<?php echo $QContactPerson1Tel3; ?>" title="Fill the cell phone # to enable system for sending text"><!--<input type="button" onclick="window.open('index.php?func=sms_send&tel=<?php echo $QContactPerson1Tel3; ?>')" value="<?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Text msg"; }else{ echo $word_TextMsg; } ?>" <?php echo ($QContactPerson1Tel3=="" || $rHosp['demoSystem']==1?"disabled":"") ?> />--></td>
  </tr>
  <tr>
    <td class="title"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Contact address"; }else{ echo $word_37; } ?></td>
    <td colspan="4"><input type="text" name="QContactPerson1Address" id="QContactPerson1Address" size="60" value="<?php echo $QContactPerson1Address; ?>"></td>
    <td><?php echo draw_option("Qreceipt",$word_Qreceipt,"xm","single",$Qreceipt,false,5); ?></td>
  </tr>
  <tr>
    <td class="title"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "E-mail"; }else{ echo $word_38; } ?></td>
    <td colspan="4"><input type="text" name="QContactPerson1Email" id="QContactPerson1Email" size="60" value="<?php echo $QContactPerson1Email; ?>"></td>
    <td><?php echo draw_checkbox("Qebill",$word_Qebill,$Qebill,"single"); ?></td>
  </tr>
  <?php
  for ($i=1;$i<=$rHosp['ContactPersonNo'];$i++) {
  ?>
  <tr>
    <td colspan="6" class="title"><form><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Emergency contact"; }else{ echo $word_39; } ?> (<?php echo $i; ?>) <input type="button" onclick="cpinfo('<?php echo ($i+1); ?>');" value="<?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Same as primary contact"; }else{ echo $word_same; } ?>"></form></td>
  </tr>
  <tr>
    <td class="title"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Name"; }else{ echo $word_2; } ?></td>
    <td><input type="text" name="QContactPerson<?php echo ($i+1); ?>Name" id="QContactPerson<?php echo ($i+1); ?>Name" size="10" value="<?php echo ${'QContactPerson'.($i+1).'Name'}; ?>"></td>
    <td class="title"><?php echo $word_7;?></td>
    <td><script> $(function() { $( "#QContactPerson<?php echo ($i+1); ?>Birth").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="QContactPerson<?php echo ($i+1); ?>Birth" id="QContactPerson<?php echo ($i+1); ?>Birth" size="10" value="<?php echo ${'QContactPerson'.($i+1).'Birth'}; ?>"></td>
    <td class="title"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Relationship"; }else{ echo $word_31; } ?></td>
    <td><input type="text" name="QContactPerson<?php echo ($i+1); ?>Relate" id="QContactPerson<?php echo ($i+1); ?>Relate" size="10" value="<?php echo ${'QContactPerson'.($i+1).'Relate'}; ?>"></td>
  </tr>
  <tr>
    <td class="title"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Serving unit"; }else{ echo $word_32; } ?></td>
    <td colspan="3"><input type="text" name="QContactPerson<?php echo ($i+1); ?>Company" id="QContactPerson<?php echo ($i+1); ?>Company" size="60" value="<?php echo ${'QContactPerson'.($i+1).'Company'}; ?>"></td>
    <td class="title"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Occupation"; }else{ echo $word_33; } ?></td>
    <td><input type="text" name="QContactPerson<?php echo ($i+1); ?>Position" id="QContactPerson<?php echo ($i+1); ?>Position" size="10" value="<?php echo ${'QContactPerson'.($i+1).'Position'}; ?>"></td>
  </tr>
  <tr>
    <td class="title"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Phone #(H)"; }else{ echo $word_34; } ?></td>
    <td><input type="text" name="QContactPerson<?php echo ($i+1); ?>Tel1" id="QContactPerson<?php echo ($i+1); ?>Tel1" size="20" value="<?php echo ${'QContactPerson'.($i+1).'Tel1'}; ?>"></td>
    <td class="title"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Phone #(W)"; }else{ echo $word_35; } ?></td>
    <td><input type="text" name="QContactPerson<?php echo ($i+1); ?>Tel2" id="QContactPerson<?php echo ($i+1); ?>Tel2" size="20" value="<?php echo ${'QContactPerson'.($i+1).'Tel2'}; ?>"></td>
    <td class="title"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Cell phone #"; }else{ echo $word_36; } ?></td>
    <td><input type="text" name="QContactPerson<?php echo ($i+1); ?>Tel3" id="QContactPerson<?php echo ($i+1); ?>Tel3" size="20" value="<?php echo ${'QContactPerson'.($i+1).'Tel3'}; ?>" title="Fill the cell phone # to enable system for sending text"><!--<input type="button" onclick="window.open('index.php?func=sms_send&tel=<?php echo ${'QContactPerson'.($i+1).'Tel3'}; ?>')" value="<?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Text msg"; }else{ echo $word_TextMsg; } ?>" <?php echo (${'QContactPerson'.($i+1).'Tel3'}==""  || $rHosp['demoSystem']==1?"disabled":"") ?> >--></td>
  </tr>
  <tr>
    <td class="title"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Contact address"; }else{ echo $word_37; } ?></td>
    <td colspan="5"><input type="text" name="QContactPerson<?php echo ($i+1); ?>Address" id="QContactPerson<?php echo ($i+1); ?>Address" size="60" value="<?php echo ${'QContactPerson'.($i+1).'Address'} ?>"></td>
  </tr>
  <tr>
    <td class="title"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "E-mail"; }else{ echo $word_38; } ?></td>
    <td colspan="5"><input type="text" name="QContactPerson<?php echo ($i+1); ?>Email" id="QContactPerson<?php echo ($i+1); ?>Email" size="60" value="<?php echo ${'QContactPerson'.($i+1).'Email'}; ?>"></td>
  </tr>
  <?php
  }
  ?>
</table>
<table width="100%">
  <tr>
    <td><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Filled date："; }else{ echo $word_40; } ?><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if($_GET['newDate']!="") { echo formatdate($_GET['newDate']); } else { if ($date != NULL) { echo formatdate($date); } } ?>" size="12"> <input type="button" value="<?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Today"; }else{ echo $word_today; } ?>" onclick="inputdate('date');" /></td>
    <td align="right"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Filled by："; }else{ echo $word_41; } ?><?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>
<br />
<center><input type="hidden" name="formID" id="formID" value="nurseform01" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></center>
</form>
<br><br>
<?php
if ($r1) {
foreach ($r1 as $k=>$v) {
	if (substr($k,0,1)=="Q") {
		$arrAnswer = explode("_",$k);
		if (count($arrAnswer)==2) {
			if ($v==1) {
				${$arrAnswer[0]} = "";
			}
		} else {
			${$k} = "";
		}
	}  else {
		${$k} = "";
	}
}
}
?>
<script>
function cpinfo(pNo) {
	$('#QContactPerson'+pNo+'Name').val($('#QContactPerson1Name').val());
	$('#QContactPerson'+pNo+'Birth').val($('#QContactPerson1Birth').val());
	$('#QContactPerson'+pNo+'Relate').val($('#QContactPerson1Relate').val());
	$('#QContactPerson'+pNo+'Company').val($('#QContactPerson1Company').val());
	$('#QContactPerson'+pNo+'Position').val($('#QContactPerson1Position').val());
	$('#QContactPerson'+pNo+'Tel1').val($('#QContactPerson1Tel1').val());
	$('#QContactPerson'+pNo+'Tel2').val($('#QContactPerson1Tel2').val());
	$('#QContactPerson'+pNo+'Tel3').val($('#QContactPerson1Tel3').val());
	$('#QContactPerson'+pNo+'Address').val($('#QContactPerson1Address').val());
	$('#QContactPerson'+pNo+'Email').val($('#QContactPerson1Email').val());
}
</script>