<h3>Multi-disciplinary care conferences</h3>
<?php
if (isset($_POST['save'])) {
	$date = str_replace("/","",$_POST['date']);
	$time = $_POST['timeH'].':'.$_POST['timeI'].':00';
	$location = $_POST['location'];
	$host = $_POST['host'];
	$member = $_POST['member'];
	$db = new DB;
	$db->query("INSERT INTO `sixtarget_profile` (`HospNo`, `date`, `time`,`location`, `host`, `member`,`Qfiller`) VALUES ('".mysql_escape_string($_POST['HospNo'])."', '".$date."','".$time."','".$location."','".$host."','".$member."','".$_SESSION['ncareID_lwj']."')");
	$db0 = new DB;
	$db0->query("SELECT LAST_INSERT_ID();");
	$r0 = $db0->fetch_assoc();
	$targetID = $r0['LAST_INSERT_ID()'];
	foreach ($_POST as $k=>$v) {
		if($k!="save" && $k!="formID" && $k!="HospNo" && $k!="date" && $k!="timeH" && $k!="timeI" && $k!="imgCount" && substr($k,0,4)!="dImg"){
			$db1 = new DB;
			$db1->query("UPDATE `sixtarget_profile` SET `".$k."`='".$v."' WHERE `targetID`='".$targetID."'");
		}
	}	
	
	$uploaddir1 = 'sixtarget_profile/'.$_SESSION['nOrgID_lwj'].'/';
	$uploaddir = 'sixtarget_profile/'.$_SESSION['nOrgID_lwj'].'/'.$targetID.'/';
	include("class/insertImage.php");

	echo '<script>alert("Add successfully");window.location.href="index.php?mod=management&func=formview&id=9_1"</script>';
}

$db = new DB;
$db->query("SELECT `patientID`,`HospNo`,`Birth` FROM `patient` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."'");
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	$take = new DB;
	$take->query("SELECT `bed`,`indate` FROM `inpatientinfo` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."'");
	$r1 = $take->fetch_assoc();
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


$tID = mysql_escape_string($_GET['tID']);
$db = new DB;
$db->query("SELECT * FROM `sixtarget_profile` WHERE `targetID`='".$tID."'");
$r = $db->fetch_assoc();
?>
<form method="post" enctype="multipart/form-data">
<div class="content-query" style="margin:0 auto; width:100%;">
<table align="center" cellpadding="5" style="font-size:10pt; margin: 0px auto 10px auto; width:100%;">
  <tr id="backtr" style="border:none; height:28px;">
    <?php
	if (@$_GET['id']!=NULL) {		
		echo '<td class="backbtnn" align="center" width="40" id="backbtn"  style="border:none;" rowspan="3"><a href="index.php?func=managementlist">Go Back</a></td>';
	} ?>
    <td class="title" style="border-top-left-radius:10px; background-color:#EECB35;">Bed #</td>
    <td align="center" style="border:none;"><?php echo $bedID; ?></td>   
    <td class="title" style="border:none;">Full name</td>
    <td align="center" style="border:none;"><?php echo $name; ?></td>
    <td class="title" style="border:none;">Care ID#</td>
    <td align="center" style="border:none;"><?php echo getHospNoDisplayByHospNo($HospNo); ?></td>
    <td class="title" tyle="border:none;">DOB</td>
    <td align="center" style="border:none; border-top-right-radius:10px;"><?php echo $birth.' ('.checkgender(mysql_escape_string($_GET['pid'])).', '.calcage(str_replace('/','',$birth)).')'; ?></td>
  </tr>
  <tr style="border:none; height:28px;" >
    <td class="title" style="border:none; border-bottom-left-radius:10px;">Admission date</td>
    <td align="center" style="border:none;"><?php echo $indate; ?></td>
    <td class="title" style="border:none;">Diagnosis</td>
    <td style="border:none; border-bottom-right-radius:10px;" colspan="5"><?php echo $diagMsg; ?></td>
  </tr>
</table>

<table style="width:100%; text-align:left;">
  <tr>
    <td class="title" width="120">Date</td>
    <td><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php echo ($r['date']=="" ? date(Y."/".m."/".d):$r['date']); ?>" size="12"></td>
    <td class="title" width="120">Time</td>
    <td>
    <select name="timeH" id="timeH">
          <option></option>
          <?php
		  for ($i2a=0;$i2a<=23;$i2a++) { 
		  	echo '<option value="'.(strlen($i2a)==1?'0':'').$i2a.'" '.(date(H)==$i2a?" selected":"").'>'.(strlen($i2a)==1?'0':'').$i2a.'</option>';
		  }
		  ?>
        </select>：<select name="timeI" id="timeI">
          <option></option>
          <option value="00" selected>00</option>
          <option value="15">15</option>
          <option value="30">30</option>
          <option value="45">45</option>
        </select></td>
  </tr>
  <tr>
    <td class="title">Location</td>
    <td colspan="3"><input type="text" name="location" id="location" value="<?php echo $r['location']; ?>" size="80"></td>
  </tr>
  <tr>
    <td class="title">Presenter</td>
    <td><input type="text" name="host" id="host" value="<?php echo $r['host']; ?>" size="40"></td>
    <td class="title">Record taker</td>
    <td><?php echo checkusername($_SESSION['ncareID_lwj']); ?><input type="hidden" name="Qfiller" id="Qfiller" value="<?php echo $_SESSION['ncareID_lwj']; ?>" size="40"></td>
  </tr>
  <tr>
    <td class="title">Attendance</td>
    <td colspan="3"><textarea name="member" id="member" cols="80" rows="6"><?php echo $r['member']; ?></textarea></td>
  </tr>
  <tr>
    <td class="title" colspan="4">Conference photo</td>
  </tr>
  <tr>
    <td colspan="4"><?php include("class/addImage.php");?></td>
  </tr>
  </table>
  <table style="width:100%; text-align:left;">
<?php 
$social04 = new DB;
$social04->query("SELECT * FROM `socialform02` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1");
$rsocial04 = $social04->fetch_assoc();
if ($social04->num_rows()>0) {
	foreach ($rsocial04 as $k=>$v) {
		if (substr($k,0,1)=="Q") {
			$arrAnswer = explode("_",$k);
			if (count($arrAnswer)==2) {
				if ($v==1) {
					${'socialform02_'.$arrAnswer[0]} .= $arrAnswer[1].';';
				}
			} else {
				${'socialform02_'.$k} = $v;
			}
		}  else {
			${'socialform02_'.$k} =  $v;
		}
	}
}
?>  
  <tr>
    <td class="title" colspan="5">Content of discussion</td>
  </tr>
  <tr>
    <td class="title">Resident source (came from)</td>
    <td colspan="4"><?php echo draw_option('Q1','Referral by healthcare agency ;Hospital swing bed;Internet search;Self contact;Referral by relatives/friends;Other facility transfer;Other',"xxxl","single",$socialform02_Q40,true,2); ?>：<input type="text" name="Q1a" id="Q1a" value="<?php echo $socialform02_Q1a; ?>" size='8' /></td>
  </tr>
  <tr>
  	<td class="title">Family tree</td>
    <td colspan="4">
<script>
$(function() {
	$( "#tabs_familystructure" ).tabs(
	<?php if ($r2['QFamilyTreeJPG']=="") { echo '{active:1}'; } ?>
	);
}); </script>
<div id="tabs_familystructure">
  <ul class="printcol">
    <li><a href="#fstabs-1">Upload image</a></li>
    <li><a href="#fstabs-2">System image</a></li>
  </ul>
  <div id="fstabs-1">
<input type="button" value="Upload image" onclick="window.open('class/uploadfiles.php?pid=<?php echo @$_GET['pid']; ?>&date=<?php echo date("Ymd"); ?>');" class="printcol">
  <?php
  if ($r2['QFamilyTreeJPG']!="") {
      echo '<img id="fsjpg" src="uploadfile/'.$_SESSION['nOrgID_lwj'].'/'.$HospNo.'/socialform01_pic/'.$r2['QFamilyTreeJPG'].'" border="0">';	  
  } else {
      echo '<img id="fsjpg" border="0" width="400" height="300" style="display:none;">';
  }?>
  </div>
  <div id="fstabs-2">
  <iframe src="module/nurseform/form1a_1.php?pid=<?php echo $_GET['pid']; ?>" width="100%" height="300" frameborder="0"></iframe>
  </div>
</div>    </td>
  </tr>  
  <tr>
    <td class="title">Family status overview</td>
    <td colspan="4"><textarea name="Q2" id="Q2" rows="5" cols="90"><?php echo $socialform02_Q43; ?></textarea></td>
  </tr>
  <tr>
    <td class="title">Physical problems</td>
    <td colspan="4"><textarea name="Q3" id="Q3" rows="5" cols="90"><?php echo $Q3; ?></textarea></td>
  </tr>
  <tr>
    <td class="title">Psychological/mental problem</td>
    <td colspan="4"><textarea name="Q4" id="Q4" rows="5" cols="90"><?php echo $Q4; ?></textarea></td>
  </tr>
  <tr>
    <td class="title" rowspan="9">Social issues </td>
    <td class="title_s" width="120">Social skills</td>
    <td colspan="4"><?php echo draw_option("Q5","Active / easy to make friends;Fair;Passive / depend on other;Loner;Resist;Unassessable","xxl","single",$socialform02_Q54,true,2); ?></td>
  </tr>
  <tr>
    <td class="title_s">Ability to communicate:</td>
    <td colspan="4"><?php echo draw_option("Q6","Normal;Semantic confusion;Language barrier;Strong accent;Body movements;Unassessable","xl","single",$socialform02_Q55,true,3); ?></td>
  </tr>
  <tr>
    <td class="title_s">Interacting with relatives</td>
    <td colspan="4"><?php echo draw_option("Q7","Good;Basic Interaction;Isolated;No relatives;Other","l","single",$socialform02_Q56,true,3); ?> <input type="text" name="Q7a" id="Q7a" size="18"  value="<?php echo $socialform02_Q56a; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Interacting with friends</td>
    <td colspan="4"><?php echo draw_option("Q8","Frequently and good;Occasional;Never;No friend;Other","xl","single",$Q8,true,3); ?> <input type="text" name="Q8a" id="Q8a" size="18"  value="<?php echo $socialform02_Q57a; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Interacting with neighbors</td>
    <td colspan="4"><?php echo draw_option("Q9","Frequently and good;Occasional;Never;No neighbor;Other","xl","single",$socialform02_Q58,true,3); ?> <input type="text" name="Q9a" id="Q9a" size="18"  value="<?php echo $socialform02_Q58a; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Interaction with staff</td>
    <td colspan="4"><?php echo draw_option("Q10","Good;Fair;Alienation;Poor/harsh","m","single",$socialform02_Q16,false,3); ?></td>
  </tr>
  <tr>
    <td class="title_s">Interaction with other residents</td>
    <td colspan="4"><?php echo draw_option("Q11","Good;Fair;Alienation;Poor/harsh","m","single",$socialform02_Q18,false,3); ?></td>
  </tr>
  <tr>
    <td class="title_s">Interaction with family</td>
    <td colspan="4"><?php echo draw_option("Q12","Good;Fair;Alienation;Poor/harsh","m","single",$socialform02_Q19,false,3); ?></td>
  </tr>
  <tr>
    <td colspan="5"><textarea name="Q20" id="Q20" rows="5" cols="90"><?php echo $Q20; ?></textarea></td>
  </tr>
  <tr>
    <td class="title" rowspan="10">Mental / behavioral problems</td>
    <td class="title_s">Sleep conditions</td>
    <td  colspan="4"><?php echo draw_option("Q21","Good;Normal;Day/Night reversed;Rely on medication","xl","multi",$socialform02_Q4,true,2); ?></td>    
  </tr>
  <tr>
    <td class="title_s">Appetite / tube feeding status</td>
    <td colspan="4"><?php echo draw_option("Q22","Good;Normal;Poor;Antifeeding","m","multi",$socialform02_Q6,false,5); ?></td>
  </tr>
  <tr>
    <td class="title_s">Mental Status</td>
    <td colspan="4"><?php echo draw_option("Q23","Pleasant;Stable;Normal;Feeling lost;Sad;Irritable;Anxious;Other","xm","multi",$socialform02_Q7,true,4); ?><input type="text" name="Q23a" id="Q23a" size="10" value="<?php echo $socialform02_Q7a; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Behavior</td>
    <td colspan="4"><?php echo draw_option("Q24","Good;Normal;Behavioral problems","xl","multi",$socialform02_Q8,false,4); ?></td>
  </tr>
  <tr>
    <td class="title_s">Activities participation</td>
    <td colspan="4"><?php echo draw_option("Q25","High;Normal;Low;Refuse;Unable to participate","xl","multi",$socialform02_Q9,true,3); ?></td>
  </tr>
  <tr>
    <td class="title_s">Attention</td>
    <td colspan="4"><?php echo draw_option("Q26","Concentrate;Poor;Excessive concentration;Other","xxl","multi",$socialform02_Q45,true,2); ?><input type="text" name="Q26a" id="Q26a" size="10" value="<?php echo $socialform02_Q45a; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Cerebration/thinking</td>
    <td colspan="4"><?php echo draw_option("Q27","Normal;Delusions;Relaxation;Lack;Jumping/Leaping;Other","l","multi",$socialform02_Q46,true,4); ?><input type="text" name="Q27a" id="Q27a" size="10" value="<?php echo $socialform02_Q46a; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Attitude</td>
    <td colspan="4"><?php echo draw_option("Q28","Friendly;Hostile;Wary;Uncooperative;Refuse;Stubborn;Suspicious;Other","xm","multi",$socialform02_Q47,true,4); ?><input type="text" name="Q28a" id="Q28a" size="10" value="<?php echo $socialform02_Q47a; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Comprehension</td>
    <td colspan="4"><?php echo draw_option("Q29","Good;Normal;Poor;Unassessable","l","single",$socialform02_Q53,true,6); ?></td>
  </tr>
  <tr>
    <td colspan="4"><textarea name="Q30" id="Q30" rows="5" cols="90"><?php echo $Q30; ?></textarea></td>
  </tr>    
   <tr>
    <td class="title">Meeting subject with (familty,resident or friend)</td>
    <td colspan="4"><textarea name="Q31" id="Q31" rows="5" cols="90"><?php echo $Q31; ?></textarea></td>
  </tr>
<?php 
$nurse02b = new DB;
$nurse02b->query("SELECT * FROM `nurseform02b` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1");
$rnurse02b = $nurse02b->fetch_assoc();
if ($nurse02b->num_rows()>0) {
	foreach ($rnurse02b as $k=>$v) {
		if (substr($k,0,1)=="Q") {
			$arrAnswer = explode("_",$k);
			if (count($arrAnswer)==2) {
				if ($v==1) {
					${'nurseform02b_'.$arrAnswer[0]} .= $arrAnswer[1].';';
				}
			} else {
				${'nurseform02b_'.$k} = $v;
			}
		}  else {
			${'nurseform02b_'.$k} = $v;
		}
	}
}
?>  
   <tr>
    <td class="title" rowspan="22" width="104px">Nursing assessment</td>
    <td class="title_s" rowspan="3" width="80px">Nutrition</td>
    <td colspan="2" class="title_s">Nutritional pathway</td>
    <td><?php echo draw_option("Q32","Oral;Nasogastric tube;Gastrostomy;Other","l","multi",$nurseform02b_Q22,false,0); ?> <input type="text" id="Q32a" name="Q32a" size="30"  value="<?php echo $nurseform02b_Q23; ?>"></td>
  </tr>
   <tr>
    <td colspan="2" class="title_s">Eating patterns</td>
    <td><?php echo draw_option("Q33","General;Meat only;Vegetarian;Soft food;Crushed;Mushy;Self-made liquid;Liquid  formula","l","multi",$nurseform02b_Q24,true,3); ?><br><input type="text" id="Q33a" name="Q33a" size="6"  value="<?php echo $nurseform02b_Q24a; ?>">kcal/d</td>
  </tr>
   <tr>
    <td colspan="2" class="title_s">Absorption</td>
    <td><?php echo draw_option("Q34","Good;Fair;Poor","m","single",$Q34,true,5); ?></td>
  </tr>
    <tr>
    <td class="title_s" rowspan="10">Excretion</td>
    <td rowspan="3" class="title_s">Urinary symptoms</td>
    <td class="title_s">Color</td>
    <td colspan="2"><select name="Q35" id="Q35">
      <option></option>
      <option value="1" <?php if ($nurseform02b_Q32a==1) echo " selected"; ?>>Light yellow</option>
      <option value="3" <?php if ($nurseform02b_Q32a==2) echo " selected"; ?>>Intense yellow</option>
      <option value="2" <?php if ($nurseform02b_Q32a==3) echo " selected"; ?>>Brown</option>
      <option value="3" <?php if ($nurseform02b_Q32a==4) echo " selected"; ?>>Hematuria</option>
      <option value="7" <?php if ($nurseform02b_Q32a==5) echo " selected"; ?>>Other</option>
    </select><input type="text" name="Q36" id="Q36" size="10" value="<?php echo $nurseform02b_Q32; ?>"></td>
  </tr>
    <tr>
        <td class="title_s">Clear</td>
        <td colspan="2"><?php echo draw_option("Q37","Clear;Turbid","m","multi",$nurseform02b_Q33,false,0); ?></td>
    </tr>
    <tr>
        <td class="title_s">Sediments</td>
        <td colspan="2"><?php echo draw_option("Q38","Has;None","m","multi",$nurseform02b_Q34,false,0); ?></td>
    </tr>
   <tr>
    <td colspan="2" class="title_s">Urination treatment</td>
    <td colspan="2"><?php echo draw_option("Q39","Toilet or urinal (potty chair);Diapers;Catheter;Intermittent catheterization;Indwelling catheter;Other","xxl","multi",$nurseform02b_Q35,true,2); ?> <input type="text" name="Q40" id="Q40" size="46" value="<?php echo $nurseform02b_Q36; ?>"></td>
  </tr>
  <tr>
    <td colspan="2" class="title_s">Abdominal sounds</td>
    <td colspan="2"><?php echo draw_option("Q41","Normal(3~6 times/minute);Too slow (less than 2 times/minute);None(0 time/minute);Overspeed (more than 7 times/minute)","xxxxl","multi",$nurseform02b_Q37,true,2); ?></td>
  </tr>
  <tr>
    <td colspan="2" class="title_s">Flatulence </td>
    <td colspan="2"><?php echo draw_option("Q42","None;Yes","m","multi",$nurseform02b_Q38,false,0); ?></td>
  </tr>
  <tr>
    <td colspan="2" class="title_s">Lump(s)</td>
    <td colspan="2"><?php echo draw_option("Q43","None;Yes","m","multi",$nurseform02b_Q39,false,0); ?> Note:<input type="text" name="Q43a" id="Q43a" size="46" value="<?php echo $nurseform02b_Q40; ?>"></td>
  </tr>
  <tr>
    <td colspan="2" class="title_s">Stool color</td>
    <td colspan="2"><select name="Q44" id="Q44">
      <option></option>
      <option value="1" <?php if ($nurseform02b_Q41a==1) echo " selected"; ?>>Yellow</option>
      <option value="2" <?php if ($nurseform02b_Q41a==2) echo " selected"; ?>>Brown</option>
      <option value="3" <?php if ($nurseform02b_Q41a==3) echo " selected"; ?>>Tan</option>
      <option value="4" <?php if ($nurseform02b_Q41a==4) echo " selected"; ?>>Black</option>
      <option value="5" <?php if ($nurseform02b_Q41a==5) echo " selected"; ?>>Gray</option>
      <option value="6" <?php if ($nurseform02b_Q41a==6) echo " selected"; ?>>Dark green</option>
      <option value="7" <?php if ($nurseform02b_Q41a==7) echo " selected"; ?>>Other</option>
    </select><input type="text" name="Q45" id="Q45" size="10" value="<?php echo $nurseform02b_Q41; ?>"></td>
  </tr>
  <tr>
    <td colspan="2" class="title_s">Stool shape</td>
    <td colspan="2"><select name="Q46" id="Q46">
      <option></option>
      <option value="1" <?php if ($nurseform02b_Q41b==1) echo " selected"; ?>>Soft</option>
      <option value="2" <?php if ($nurseform02b_Q41b==2) echo " selected"; ?>>Hard</option>
      <option value="3" <?php if ($nurseform02b_Q41b==3) echo " selected"; ?>>Loose</option>
      <option value="4" <?php if ($nurseform02b_Q41b==4) echo " selected"; ?>>watery</option>
      <option value="5" <?php if ($nurseform02b_Q41b==5) echo " selected"; ?>>Other</option>
    </select><input type="text" name="Q47" id="Q47" size="10" value="<?php echo $nurseform02b_Q41c; ?>"></td>
  </tr>
  <tr>
    <td colspan="2" class="title_s">Defecation treatment</td>
    <td colspan="2"><?php echo draw_option("Q48","Normal defecation without medication;Stool softeners;Laxative;Enema;Digital removal of faeces(DRF);Colostomy;Other","xxxxl","multi",$nurseform02b_Q42,false,4); ?> <input type="text" name="Q48a" id="Q48a" size="21" value="<?php echo $nurseform02b_Q42a; ?>"></td>
  </tr>
    <tr>
    <td class="title_s">Activity and exercise</td>
    <td colspan="3">Weekly ambulation(out of bed)<input type="text" name="Q49" id="Q49" size="1" value="<?php echo $Q49; ?>">time(s).<?php echo draw_checkbox_nobr("Q50","Able to do activity freely",$Q50,"multi"); ?><br>Participate in weekly activities<?php echo draw_option("Q51","Yes;Maybe;None","m","single",$Q51,true,4); ?><br>Participate in occasional events<?php echo draw_option("Q52","Yes;Maybe;None","m","single",$Q52,true,4); ?></td>
  </tr>
<?php
$nurse02a = new DB;
$nurse02a->query("SELECT * FROM `nurseform02a` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1");
$rnurse02a = $nurse02a->fetch_assoc();
if ($nurse02a->num_rows()>0) {
	foreach ($rnurse02a as $k=>$v) {
		if (substr($k,0,1)=="Q") {
			$arrAnswer = explode("_",$k);
			if (count($arrAnswer)==2) {
				if ($v==1) {
					${'nurseform02a_'.$arrAnswer[0]} .=$arrAnswer[1].';';
				}
			} else {
				${'nurseform02a_'.$k} = $v;
			}
		}  else {
			${'nurseform02a_'.$k} = $v;
		}
	}
}
?>  
    <tr>
    <td class="title_s" rowspan="3">Skin care</td>
    <td class="title_s">Skin</td>
    <td colspan="2"><?php echo draw_option("Q53","Normal;Pale;Jaundice;Pigmentation;Dehydration;Edema;Itchy;Abnormal nail;Sparse hair;Loss of hair;Skin allergy;Eczema;Fungal infection;Suspected scabies;Other","xl","multi",$nurseform02a_Q45,true,2); ?> <input type="text" name="Q53a" id="Q53a" size="40" value="<?php echo $nurseform02a_Q46; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Wound</td>
    <td width="80px"><?php echo draw_option("Q54","None;Yes","s","multi",$nurseform02a_Q47,false,6); ?></td>
    <td colspan="2">Severity:<br><?php echo draw_option("Q55","Reddish;Epidermis;Subcutaneous tissue;Muscle and bone","xl","multi",$nurseform02a_Q48,true,2); ?><br />Size:<input type="text" name="Q55a" id="Q55a" size="12" value="<?php echo $nurseform02a_Q49; ?>" /> part(s):<input type="text" name="Q55b" id="Q55b" size="12" value="<?php echo $nurseform02a_Q50; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Pressure ulcer(s)</td>
    <td><?php echo draw_option("Q56","None;Yes","s","multi",$nurseform02a_Q51,false,6); ?></td>
    <td colspan="2">Severity:<br><?php echo draw_option("Q57","Reddish;Epidermis;Subcutaneous tissue;Muscle and bone","xl","multi",$nurseform02a_Q52,true,2); ?><br />Size:<input type="text" name="Q57a" id="Q57a" size="12" value="<?php echo $nurseform02a_Q53; ?>" /> part(s):<input type="text" name="Q57b" id="Q57b" size="12" value="<?php echo $nurseform02a_Q54; ?>" /></td>
  </tr>
    <tr>
    <td class="title_s" rowspan="4">Sleeping</td>
        <td class="title_s">Daytime energy state</td>
    <td colspan="2"><?php echo draw_option("Q58","Good;Occasionally doze;Fatigue;Sleepy/somnolence;Other","xl","multi",$nurseform02a_Q86,true,2); ?> <input type="text" name="Q58a" id="Q58a" size="21" value="<?php echo $nurseform02a_Q87; ?>" /></td>
  </tr>
<td class="title_s">Nap time</td>
    <td colspan="3"><?php echo draw_option("Q59","None;Yes","s","multi",$nurseform02a_Q88,false,8); ?> Total napping hours:<input type="text" name="Q59a" id="Q59a" size="4" value="<?php echo $nurseform02a_Q89; ?>" />hour(s)/day</td>
  </tr>
  <tr>
    <td class="title_s">hypnotic agent</td>
    <td colspan="3"><?php echo draw_option("Q60","None;Yes;comply with medical advice;Self purchased","xxl","multi",$nurseform02a_Q90,true,2); ?><br />Name of the medicine:<input type="text" name="Q60a" id="Q60a" size="30" value="<?php echo $nurseform02a_Q91; ?>" /><br>Dosage:<input type="text" name="Q60b" id="Q60b" size="30" value="<?php echo $nurseform02a_Q92; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Sleep disorder(s)</td>
    <td colspan="3"><?php echo draw_option("Q61","None;Difficulty falling asleep;Easily awakened;Day/Night reversed;Nightmare;Orderless;Other","xl","multi",$nurseform02a_Q93,true,2); ?></td>
  </tr>
  <tr>
    <td class="title_s">Medication</td>
    <td colspan="3">Usage of chronic medication:
    <?php echo draw_option("Q62","None;Yes","s","multi",$Q62,false,8).' (Current applied medication name)<br>';
	$db_med = new DB;
	$db_med->query("SELECT * FROM `nurseform17` WHERE `HospNo`='".$HospNo."' ORDER BY `order` ASC");
	for ($i3=0;$i3<$db_med->num_rows();$i3++) {
	  $rmed = $db_med->fetch_assoc();
	  $med .=$output = $rmed['Qmedicine'].' '.$rmed['Qdose'].$rmed['Qdoseq'].' '.$rmed['Qusage'].' '.$rmed['Qfreq'].';';
	}
	?><textarea id="Q63" name="Q63" rows="5"><?php echo str_replace(";","\n",$med);?></textarea>
    <br>
    <?php
	$take = new DB;
	$take->query("SELECT * FROM `medintake` WHERE `HospNo`='".$HospNo."';");
	$rtake = $take->fetch_assoc();
	if ($take->num_rows()>0) {
		foreach ($rtake as $k=>$v) {
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
	?>
    Medication state for intake:
    <?php echo draw_option("Qintake","Powdery;NG","xs","multi",$Qintake,false,5); ?><br>
    Note for medication usage:<br>
    <?php 
    $db_amed = new DB;
	$db_amed->query("SELECT * FROM `medicineq` WHERE `HospNo`='".$HospNo."' Order By `date` DESC");
	for ($i=0;$i<$db_amed->num_rows();$i++) {
		$amed = $db_amed->fetch_assoc();
		$medq .= $amed['Qmedicine'].'：'.$amed['question'].';';
	}	
	?><textarea id="Q64" name="Q64" rows="5"><?php echo str_replace(";","\n",$medq);?></textarea>
    </td>
  </tr>
   <tr>
    <td class="title">Current problem when giving care :</td>
    <td colspan="4"><textarea name="Q65" id="Q65" rows="5" cols="90"><?php echo $Q65; ?></textarea></td>
  </tr>
   <tr>
    <td class="title">Need to adjust care plan :</td>
    <td colspan="4"><?php echo draw_option("Q66","None;Yes","s","multi",$Q66,false,8); ?> Please state the new plan or content after adjustment :<br>
    <textarea name="Q66a" id="Q66a" rows="5" cols="90"><?php echo $Q66a; ?></textarea>
    </td>
  </tr>
   <tr>
    <td class="title" colspan="5">Discussion and Suggestions</td>
  </tr>
   <tr>
    <td class="title" width="100">Manager</td>
    <td colspan="4"> <textarea name="Q67" id="Q67" rows="3" cols="90"><?php echo $Q67; ?></textarea></td>
  </tr>
   <tr>
    <td class="title">Nutritionist</td>
    <td colspan="4"> <textarea name="Q68" id="Q68" rows="3" cols="90"><?php echo $Q68; ?></textarea></td>
  </tr>
   <tr>
    <td class="title">Physician</td>
    <td colspan="4"> <textarea name="Q69" id="Q69" rows="3" cols="90"><?php echo $Q69; ?></textarea></td>
  </tr>
   <tr>
    <td class="title">Social worker</td>
    <td colspan="4"> <textarea name="Q70" id="Q70" rows="3" cols="90"><?php echo $Q70; ?></textarea></td>
  </tr>
   <tr>
    <td class="title">Nurse</td>
    <td colspan="4"> <textarea name="Q71" id="Q71" rows="3" cols="90"><?php echo $Q71; ?></textarea></td>
  </tr>
   <tr>
    <td class="title">Physical therapist</td>
    <td colspan="4"> <textarea name="Q72" id="Q72" rows="3" cols="90"><?php echo $Q72; ?></textarea></td>
  </tr>
   <tr>
    <td class="title">Pharmacist</td>
    <td colspan="4"> <textarea name="Q73" id="Q73" rows="3" cols="90"><?php echo $Q73; ?></textarea></td>
  </tr>
   <tr>
    <td class="title">Nursing assistant</td>
    <td colspan="4"> <textarea name="Q74" id="Q74" rows="3" cols="90"><?php echo $Q74; ?></textarea></td>
  </tr>
   <tr>
    <td class="title" colspan="5">Follow up and assessment</td>
  </tr>
   <tr>
    <td colspan="5" align="center"> <textarea name="Q75" id="Q75" rows="5" cols="90"><?php echo $Q75; ?></textarea><br>(At least three disciplines personnel involved in the discussion)</td>
  </tr>
  <tr>
    <td colspan="5"><center><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><input type="button"  onclick="window.location.href='index.php?mod=management&func=formview&id=9_1'" value="Back to list"><input type="hidden" name="save" id="save" value="Save"><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></center></td>
  </tr>
</table>
</div>
</form><br><br>
