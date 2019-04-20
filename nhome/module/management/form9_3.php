<h3>Multi-disciplinary care conferences</h3>
<?php
$tID = mysql_escape_string($_GET['tID']);

if (isset($_POST['save'])) {
	$date = str_replace("/","",$_POST['date']);
	$time = $_POST['timeH'].':'.$_POST['timeI'].':00';

	foreach ($_POST as $k=>$v) {
		if($k!="save" && $k!="formID" && $k!="HospNo" && $k!="date" && $k!="timeH" && $k!="timeI" && substr($k,0,4)!="dImg" && $k!="delCount" && $k!="imgCount" && substr($k,0,6)!="Delimg" && substr($k,0,3)!="Del"){
			$db1 = new DB;
			$db1->query("UPDATE `sixtarget_profile` SET `".$k."`='".$v."' WHERE `targetID`='".$tID."'");
		}
	}
	$db = new DB;
	$db->query("UPDATE `sixtarget_profile` SET `date`='".$date."', `time`='".$time."' WHERE `targetID`='".$tID."'");
	
	$uploaddir1 = 'sixtarget_profile/'.$_SESSION['nOrgID_lwj'].'/';
	$uploaddir = 'sixtarget_profile/'.$_SESSION['nOrgID_lwj'].'/'.$tID.'/';
	include("class/insertImage.php");
	
	echo '<script>alert("Modify success!");window.location.href="index.php?mod=management&func=formview&id=9_1"</script>';
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
$db = new DB;
$db->query("SELECT * FROM `sixtarget_profile` WHERE `targetID`='".$tID."'");
$r = $db->fetch_assoc();
if ($db->num_rows()>0) {
	foreach ($r as $k=>$v) {
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
			${$k} =  $v;
		}
	}
}

?>
<form method="post" enctype="multipart/form-data" onsubmit="return checkDel();">
<div class="content-query">
<table width="960" class="printcol">
  <tr id="backtr"  style=" height:20px;" >
    <td class="title" width="70" style=" background-color:#FF8928;">Bed #</td>
    <td width="90" ><?php echo $bedID; ?></td>   
    <td class="title" width="70" >Full name</td>
    <td width="90" ><?php echo $name; ?></td>
    <td class="title" width="70" >Care ID#</td>
    <td width="90" ><?php echo getHospNoDisplayByHospNo($HospNo); ?></td>
    <td class="title" width="70" >DOB</td>
    <td  ><?php echo $birth.' ('.checkgender(mysql_escape_string($_GET['pid'])).', '.calcage(str_replace('/','',$birth)).')'; ?></td>
  </tr>
  <tr style=" height:20px;" >
    <td class="title" >Admission date</td>
    <td ><?php echo $indate; ?></td>
    <td class="title" >Diagnosis</td>
    <td  colspan="5"><?php echo $diagMsg; ?></td>
  </tr>
</table>
<table width="960" style="text-align:left;">
  <tr>
    <td class="title" width="120">Date</td>
    <td><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php echo ($r['date']=="" ? date(Y."/".m."/".d):formatdate($r['date'])); ?>" size="12"></td>
    <td class="title" width="120">Time</td>
    <td>
        <select name="timeH" id="timeH">
          <option></option>
          <?php
  		  $H = substr($r['time'],0,2);
		  $S = substr($r['time'],3,2);		  
		  for ($i2a=0;$i2a<=23;$i2a++) { 
		  $select = (($H==""?date(H):$H)==$i2a?" selected":"");	
		  	echo '<option value="'.(strlen($i2a)==1?'0':'').$i2a.'" '.$select.'>'.(strlen($i2a)==1?'0':'').$i2a.'</option>'; 
		  }
		  ?>
        </select>：<select name="timeI" id="timeI">
          <option></option>
          <option value="00" <?php echo (($S==""?"00":$S)=="00"?" selected":"");?>>00</option>
          <option value="15" <?php echo (($S==""?"00":$S)=="15"?" selected":"");?>>15</option>
          <option value="30" <?php echo (($S==""?"00":$S)=="30"?" selected":"");?>>30</option>
          <option value="45" <?php echo (($S==""?"00":$S)=="45"?" selected":"");?>>45</option>
        </select>
	</td>
  </tr>
  <tr>
    <td class="title">Location</td>
    <td colspan="3"><input type="text" name="location" id="location" value="<?php echo $r['location']; ?>" size="80"></td>
  </tr>
  <tr>
    <td class="title">Presenter</td>
    <td><input type="text" name="host" id="host" value="<?php echo $r['host']; ?>" size="40"></td>
    <td class="title">Record taker</td>
    <td><?php echo checkusername($r['Qfiller']); ?><input type="hidden" name="Qfiller" id="Qfiller" value="<?php echo $_SESSION['ncareID_lwj']; ?>" size="40"></td>
  </tr>
  <tr>
    <td class="title">Attendance</td>
    <td colspan="3"><textarea name="member" id="member" cols="80" rows="6"><?php echo $r['member']; ?></textarea></td>
  </tr>
  <tr>
    <td class="title" colspan="4">Conference photo</td>
  </tr>
  <?php
  $picFolder = 'sixtarget_profile/'.$_SESSION['nOrgID_lwj'].'/'.$tID;
  if (file_exists($picFolder)) {
  ?>
  <tr>
  	<td colspan="4">
    <?php
	$arrFiles = scandir($picFolder);
	for ($i=2;$i<count($arrFiles);$i++) {
		echo '
		<div style="margin:5px; padding:10px; background:#fff; display:inline-block;">
		<input type="checkbox" name="Del'.$i.'" id="Del'.$i.'"  class="printcol"> <span  class="printcol">DELETE</span><br>
		<a href="'.$picFolder.'/'.$arrFiles[$i].'" class="example-image-link" data-lightbox="example-set"><img src="'.$picFolder.'/'.$arrFiles[$i].'" width="200"></a>
		<input type="hidden" name="Delimg'.$i.'" id="Delimg'.$i.'" value="'.$picFolder.'/'.$arrFiles[$i].'">
		</div>
		';
	}
	?>
    <input type="hidden" name="delCount" id="delCount" value="<?php echo count($arrFiles); ?>">
    </td>
  </tr>
<?php }?>  
  <tr class="printcol">
    <td colspan="4"><?php include("class/addImage.php");?></td>
  </tr>
  </table>
  <div style="page-break-before:always;"></div>
<table width="960" class="noShowCol" style="text-align:left;">
  <tr id="backtr"  style=" height:20px;" >
    <td class="title" width="70">Bed #</td>
    <td width="90" ><?php echo $bedID; ?></td>   
    <td class="title" width="70" >Full name</td>
    <td width="90" ><?php echo $name; ?></td>
    <td class="title" width="70" >Care ID#</td>
    <td width="90" ><?php echo getHospNoDisplayByHospNo($HospNo); ?></td>
    <td class="title" width="70" >DOB</td>
    <td  ><?php echo $birth.' ('.checkgender(mysql_escape_string($_GET['pid'])).', '.calcage(str_replace('/','',$birth)).')'; ?></td>
  </tr>
  <tr style=" height:20px;" >
    <td class="title" >Admission date</td>
    <td ><?php echo $indate; ?></td>
    <td class="title" >Diagnosis</td>
    <td  colspan="5"><?php echo $diagMsg; ?></td>
  </tr>
</table>
  
  <table style="text-align:left;">
  <tr>
    <td class="title" colspan="5">Content of discussion</td>
  </tr>
  <tr>
    <td class="title">Resident source (came from)</td>
    <td colspan="4"><?php echo draw_option('Q1','Referral by healthcare agency ;Hospital swing bed;Internet search;Self contact;Referral by relatives/friends;Other facility transfer;Other',"xxxl","single",$Q1,true,2); ?>：<input type="text" name="Q1a" id="Q1a" value="<?php echo $Q1a; ?>" size='8' /></td>
  </tr>
  <tr>
  	<td class="title">Family tree</td>
    <td colspan="4">
<?php
$db2 = new DB;
$db2->query("SELECT `QFamilyTreeJPG` FROM `socialform01` WHERE `HospNo`='".$HospNo."'");
$r2 = $db2->fetch_assoc();
?>    
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
    <td colspan="4"><textarea name="Q2" id="Q2" rows="5" cols="90"><?php echo $Q2; ?></textarea></td>
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
    <td colspan="4"><?php echo draw_option("Q5","Active / easy to make friends;Fair;Passive / depend on other;Loner;Resist;Unassessable","xxl","single",$Q5,true,2); ?></td>
  </tr>
  <tr>
    <td class="title_s">Ability to communicate:</td>
    <td colspan="4"><?php echo draw_option("Q6","Normal;Semantic confusion;Language barrier;Strong accent;Body movements;Unassessable","xl","single",$Q6,true,2); ?></td>
  </tr>
  <tr>
    <td class="title_s">Interacting with relatives</td>
    <td colspan="4"><?php echo draw_option("Q7","Good;Basic Interaction;Isolated;No relatives;Other","l","single",$Q7,true,3); ?> <input type="text" name="Q7a" id="Q7a" size="18"  value="<?php echo $Q7a; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Interacting with friends</td>
    <td colspan="4"><?php echo draw_option("Q8","Frequently and good;Occasional;Never;No friend;Other","xl","single",$Q8,true,2); ?> <input type="text" name="Q8a" id="Q8a" size="18"  value="<?php echo $Q8a; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Interacting with neighbors</td>
    <td colspan="4"><?php echo draw_option("Q9","Frequently and good;Occasional;Never;No neighbor;Other","xl","single",$Q9,true,2); ?> <input type="text" name="Q9a" id="Q9a" size="18"  value="<?php echo $Q9a; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Interaction with staff</td>
    <td colspan="4"><?php echo draw_option("Q10","Good;Fair;Alienation;Poor/harsh","m","single",$Q10,false,3); ?></td>
  </tr>
  <tr>
    <td class="title_s">Interaction with other residents</td>
    <td colspan="4"><?php echo draw_option("Q11","Good;Fair;Alienation;Poor/harsh","m","single",$Q11,false,3); ?></td>
  </tr>
  <tr>
    <td class="title_s">Interaction with family</td>
    <td colspan="4"><?php echo draw_option("Q12","Good;Fair;Alienation;Poor/harsh","m","single",$Q12,false,3); ?></td>
  </tr>
  <tr>
    <td colspan="5"><textarea name="Q20" id="Q20" rows="5" cols="90"><?php echo $Q20; ?></textarea></td>
  </tr>
  <tr>
    <td class="title" rowspan="10">Mental / behavioral problems</td>
    <td class="title_s">Sleep conditions</td>
    <td  colspan="4"><?php echo draw_option("Q21","Good;Normal;Day/Night reversed;Rely on medication","xl","multi",$Q21,true,2); ?></td>    
  </tr>
  <tr>
    <td class="title_s">Appetite / tube feeding status</td>
    <td colspan="4"><?php echo draw_option("Q22","Good;Normal;Poor;Antifeeding","m","multi",$Q22,false,5); ?></td>
  </tr>
  <tr>
    <td class="title_s">Mental Status</td>
    <td colspan="4"><?php echo draw_option("Q23","Pleasant;Stable;Normal;Feeling lost;Sad;Irritable;Anxious;Other","l","multi",$Q23,true,3); ?><input type="text" name="Q23a" id="Q23a" size="10" value="<?php echo $Q23a; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Behavior</td>
    <td colspan="4"><?php echo draw_option("Q24","Good;Normal;Behavioral problems","xl","multi",$Q24,false,4); ?></td>
  </tr>
  <tr>
    <td class="title_s">Activities participation</td>
    <td colspan="4"><?php echo draw_option("Q25","High;Normal;Low;Refuse;Unable to participate","xl","multi",$Q25,true,2); ?></td>
  </tr>
  <tr>
    <td class="title_s">Attention</td>
    <td colspan="4"><?php echo draw_option("Q26","Concentrate;Poor;Excessive concentration;Other","xxl","multi",$Q26,true,2); ?><input type="text" name="Q26a" id="Q26a" size="10" value="<?php echo $Q26a; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Cerebration/thinking</td>
    <td colspan="4"><?php echo draw_option("Q27","Normal;Delusions;Relaxation;Lack;Jumping/Leaping;Other","l","multi",$Q27,true,3); ?><input type="text" name="Q27a" id="Q27a" size="10" value="<?php echo $Q27a; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Attitude</td>
    <td colspan="4"><?php echo draw_option("Q28","Friendly;Hostile;Wary;Uncooperative;Refuse;Stubborn;Suspicious;Other","l","multi",$Q28,true,3); ?><input type="text" name="Q28a" id="Q28a" size="10" value="<?php echo $Q28a; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Comprehension</td>
    <td colspan="4"><?php echo draw_option("Q29","Good;Normal;Poor;Unassessable","l","single",$Q29,true,2); ?></td>
  </tr>
  <tr>
    <td colspan="4"><textarea name="Q30" id="Q30" rows="5" cols="90"><?php echo $Q30; ?></textarea></td>
  </tr>    
   <tr>
    <td class="title">Meeting subject with (familty,resident or friend)</td>
    <td colspan="4"><textarea name="Q31" id="Q31" rows="5" cols="90"><?php echo $Q31; ?></textarea></td>
  </tr>
  </table>
  <div style="page-break-before:always;"></div>
  <table style="text-align:left;">  
  <tr>
    <td class="title" rowspan="22" width="104px">Nursing assessment</td>
    <td class="title_s" rowspan="3" width="80px">Nutrition</td>
    <td colspan="2" class="title_s">Nutritional pathway</td>
    <td><?php echo draw_option("Q32","Oral;Nasogastric tube;Gastrostomy;Other","l","multi",$Q32,false,0); ?> <input type="text" id="Q32a" name="Q32a" size="30"  value="<?php echo $Q32a; ?>"></td>
  </tr>
   <tr>
    <td colspan="2" class="title_s">Eating patterns</td>
    <td><?php echo draw_option("Q33","General;Meat only;Vegetarian;Soft food;Crushed;Mushy;Self-made liquid;Liquid  formula","l","multi",$Q33,true,3); ?><br><input type="text" id="Q33a" name="Q33a" size="6"  value="<?php echo $Q33a; ?>">kcal/d</td>
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
      <option value="1" <?php if ($Q35==1) echo " selected"; ?>>Light yellow</option>
      <option value="3" <?php if ($Q35==2) echo " selected"; ?>>Intense yellow</option>
      <option value="2" <?php if ($Q35==3) echo " selected"; ?>>Brown</option>
      <option value="3" <?php if ($Q35==4) echo " selected"; ?>>Hematuria</option>
      <option value="7" <?php if ($Q35==5) echo " selected"; ?>>Other</option>
    </select><input type="text" name="Q36" id="Q36" size="10" value="<?php echo $Q36; ?>"></td>
  </tr>
    <tr>
        <td class="title_s">Clear</td>
        <td colspan="2"><?php echo draw_option("Q37","Clear;Turbid","m","multi",$Q37,false,0); ?></td>
    </tr>
    <tr>
        <td class="title_s">Sediments</td>
        <td colspan="2"><?php echo draw_option("Q38","Has;None","m","multi",$Q38,false,0); ?></td>
    </tr>
   <tr>
    <td colspan="2" class="title_s">Urination treatment</td>
    <td colspan="2"><?php echo draw_option("Q39","Toilet or urinal (potty chair);Diapers;Catheter;Intermittent catheterization;Indwelling catheter;Other","xxl","multi",$Q39,true,2); ?> <input type="text" name="Q40" id="Q40" size="46" value="<?php echo $Q40; ?>"></td>
  </tr>
  <tr>
    <td colspan="2" class="title_s">Abdominal sounds</td>
    <td colspan="2"><?php echo draw_option("Q41","Normal(3~6 times/minute);Too slow (less than 2 times/minute);None(0 time/minute);Overspeed (more than 7 times/minute)","xxxxl","multi",$Q41,true,2); ?></td>
  </tr>
  <tr>
    <td colspan="2" class="title_s">Flatulence </td>
    <td colspan="2"><?php echo draw_option("Q42","None;Yes","s","multi",$Q42,false,0); ?></td>
  </tr>
  <tr>
    <td colspan="2" class="title_s">Lump(s)</td>
    <td colspan="2"><?php echo draw_option("Q43","None;Yes","s","multi",$Q43,false,0); ?> Note:<input type="text" name="Q43a" id="Q43a" size="46" value="<?php echo $Q43a; ?>"></td>
  </tr>
  <tr>
    <td colspan="2" class="title_s">Stool color</td>
    <td colspan="2"><select name="Q44" id="Q44">
      <option></option>
      <option value="1" <?php if ($Q44==1) echo " selected"; ?>>Yellow</option>
      <option value="2" <?php if ($Q44==2) echo " selected"; ?>>Brown</option>
      <option value="3" <?php if ($Q44==3) echo " selected"; ?>>Tan</option>
      <option value="4" <?php if ($Q44==4) echo " selected"; ?>>Black</option>
      <option value="5" <?php if ($Q44==5) echo " selected"; ?>>Gray</option>
      <option value="6" <?php if ($Q44==6) echo " selected"; ?>>Dark green</option>
      <option value="7" <?php if ($Q44==7) echo " selected"; ?>>Other</option>
    </select><input type="text" name="Q45" id="Q45" size="10" value="<?php echo $Q45; ?>"></td>
  </tr>
  <tr>
    <td colspan="2" class="title_s">Stool shape</td>
    <td colspan="2"><select name="Q46" id="Q46">
      <option></option>
      <option value="1" <?php if ($Q46==1) echo " selected"; ?>>Soft</option>
      <option value="2" <?php if ($Q46==2) echo " selected"; ?>>Hard</option>
      <option value="3" <?php if ($Q46==3) echo " selected"; ?>>Loose</option>
      <option value="4" <?php if ($Q46==4) echo " selected"; ?>>watery</option>
      <option value="5" <?php if ($Q46==5) echo " selected"; ?>>Other</option>
    </select><input type="text" name="Q47" id="Q47" size="10" value="<?php echo $Q47; ?>"></td>
  </tr>
  <tr>
    <td colspan="2" class="title_s">Defecation treatment</td>
    <td colspan="2"><?php echo draw_option("Q48","Normal defecation without medication;Stool softeners;Laxative;Enema;Digital removal of faeces(DRF);Colostomy;Other","xxxxl","multi",$Q48,false,2); ?><input type="text" name="Q48a" id="Q48a" size="21" value="<?php echo $Q48a; ?>"></td>
  </tr>
    <tr>
    <td class="title_s">Activity and exercise</td>
    <td colspan="3">Weekly ambulation(out of bed)<input type="text" name="Q49" id="Q49" size="1" value="<?php echo $Q49; ?>">time(s).<?php echo draw_checkbox_nobr("Q50","Able to do activity freely",$Q50,"multi"); ?><br>Participate in weekly activities<?php echo draw_option("Q51","Yes;Maybe;None","m","single",$Q51,true,4); ?><br>Participate in occasional events<?php echo draw_option("Q52","Yes;Maybe;None","m","single",$Q52,true,4); ?></td>
  </tr>
  <tr>
    <td class="title_s" rowspan="3">Skin care</td>
    <td class="title_s">Skin</td>
    <td colspan="2"><?php echo draw_option("Q53","Normal;Pale;Jaundice;Pigmentation;Dehydration;Edema;Itchy;Abnormal nail;Sparse hair;Loss of hair;Skin allergy;Eczema;Fungal infection;Suspected scabies;Other","xl","multi",$Q53,true,3); ?> <input type="text" name="Q53a" id="Q53a" size="40" value="<?php echo $Q53a; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Wound</td>
    <td width="80px"><?php echo draw_option("Q54","None;Yes","ss","multi",$Q54,false,6); ?></td>
    <td colspan="1">Severity:<br><?php echo draw_option("Q55","Reddish;Epidermis;Subcutaneous tissue;Muscle and bone","xl","multi",$Q55,true,2); ?><br />Size:<input type="text" name="Q55a" id="Q55a" size="12" value="<?php echo $Q55a; ?>" /> part(s):<input type="text" name="Q55b" id="Q55b" size="12" value="<?php echo $Q55b; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Pressure ulcer(s)</td>
    <td><?php echo draw_option("Q56","None;Yes","ss","multi",$Q56,false,6); ?></td>
    <td colspan="1">Severity:<br><?php echo draw_option("Q57","Reddish;Epidermis;Subcutaneous tissue;Muscle and bone","xl","multi",$Q57,true,2); ?><br />Size:<input type="text" name="Q57a" id="Q57a" size="12" value="<?php echo $Q57a; ?>" /> part(s):<input type="text" name="Q57b" id="Q57b" size="12" value="<?php echo $Q57b; ?>" /></td>
  </tr>
    <tr>
    <td class="title_s" rowspan="4">Sleeping</td>
        <td class="title_s">Daytime energy state</td>
    <td colspan="2"><?php echo draw_option("Q58","Good;Occasionally doze;Fatigue;Sleepy/somnolence;Other","xl","multi",$Q58,true,3); ?> <input type="text" name="Q58a" id="Q58a" size="21" value="<?php echo $Q58a; ?>" /></td>
  </tr>
<td class="title_s">Nap time</td>
    <td colspan="2"><?php echo draw_option("Q59","None;Yes","s","multi",$Q59,false,8); ?> Total napping hours:<input type="text" name="Q59a" id="Q59a" size="4" value="<?php echo $Q59a; ?>" />hour(s)/day</td>
  </tr>
  <tr>
    <td class="title_s">hypnotic agent</td>
    <td colspan="2"><?php echo draw_option("Q60","None;Yes;comply with medical advice;Self purchased","xxl","multi",$Q60,true,2); ?><br />Name of the medicine:<input type="text" name="Q60a" id="Q60a" size="30" value="<?php echo $Q60a; ?>" /><br>Dosage:<input type="text" name="Q60b" id="Q60b" size="30" value="<?php echo $Q60b; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Sleep disorder(s)</td>
    <td colspan="2"><?php echo draw_option("Q61","None;Difficulty falling asleep;Easily awakened;Day/Night reversed;Nightmare;Orderless;Other","xl","multi",$Q61,true,3); ?></td>
  </tr>
  <tr>
    <td class="title_s">Medication</td>
    <td colspan="3">Usage of chronic medication:
    <?php echo draw_option("Q62","None;Yes","s","multi",$Q62,false,8).' (Current applied medication name)<br>'; ?>
    <textarea id="Q63" name="Q63" rows="5"><?php echo str_replace(";","\n",$Q63);?></textarea>
    <br>
    Medication state for intake:
    <?php echo draw_option("Qintake","Powdery;NG","xs","multi",$Qintake,false,5); ?><br>
    Note for medication usage:<br><textarea id="Q64" name="Q64" rows="5"><?php echo str_replace(";","\n",$Q64);?></textarea>
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
  </table>
  <div style="page-break-before:always;"></div>
  <table width="960" style="text-align:left;">  
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
    <td colspan="5"> <textarea name="Q75" id="Q75" rows="5" cols="90"><?php echo $Q75; ?></textarea></td>
  </tr>
   <tr class="noShowCol">
    <td colspan="5">(At least three disciplines personnel involved in the discussion)</td>
  </tr>
  <tr class="printcol">
    <td colspan="5"><center><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><input type="button"  onclick="window.location.href='index.php?mod=management&func=formview&id=9_1'" value="Back to list"><input type="hidden" name="save" id="save" value="Save"><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-pencil fa-2x"></i>Edit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></center></td>
  </tr>
</table>
</div>
</form>
<script>
function checkDel() {
	var delCount = $('#delCount').val();
	var count=0;
	for (var i=1;i<=delCount;i++) {
		if ($('#Del'+i).attr('checked')) {
			count++;
		}
	}
	if (count>0) {
		if (confirm("確認刪除圖片?")) {
			return true;
		} else {
			return false;
		}
	}
}
</script>