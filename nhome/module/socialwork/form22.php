<?php
$date = mysql_escape_string($_GET['date']);
if (@$_GET['date']=='') {
	$sql = "SELECT * FROM `socialform22` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql = "SELECT * FROM `socialform22` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`='".$date."'";
}
$db = new DB;
$db->query($sql);
$rs = $db->fetch_assoc();
if ($db->num_rows()>0) {
	foreach ($rs as $k=>$v) {
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
	
}else{
	$db1 = new DB;
	$db1->query("SELECT * FROM `nurseform01` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1");
	$r1 = $db1->fetch_assoc();
	if ($db1->num_rows()>0) {
		foreach ($r1 as $k=>$v) {
			if (substr($k,0,1)=="Q") {
				$arrAnswer = explode("_",$k);
				if (count($arrAnswer)==2) {
					if ($v==1) {
						${'nurseform01_'.$arrAnswer[0]} .= $arrAnswer[1].';';
					}
				} else {
					${'nurseform01_'.$k} = $v;
				}
			}  else {
				${'nurseform01_'.$k} = $v;
			}
		}
	}
	$db2 = new DB;
	$db2->query("SELECT * FROM `nurseform02a` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1");
	$r2 = $db2->fetch_assoc();
	if ($db2->num_rows()>0) {
		foreach ($r2 as $k=>$v) {
			if (substr($k,0,1)=="Q") {
				$arrAnswer = explode("_",$k);
				if (count($arrAnswer)==2) {
					if ($v==1) {
						${'nurseform02a_'.$arrAnswer[0]} .= $arrAnswer[1].';';
					}
				} else {
					${'nurseform02a_'.$k} = $v;
				}
			}  else {
				${'nurseform02a_'.$k} = $v;
			}
		}
	}
}

$arrMatch = array(
"Q1" => "Name","Q2" => "Birth","Q3" => "IdNo","Q4" => "Birthplace","Q5" => array("Postcode","Address","Address2","Address3","Address4","Address5"),
"Q7" => "nurseform01_Qcomingsource", "Q8" => "nurseform02a_Q15", "Q8a" => "nurseform02a_Q15a", "Q9" => "nurseform01_Qlang", 
"Q9a" => "nurseform01_QlangOther", "Q10" => "nurseform02a_Q11", "Q10a" => "nurseform02a_Q12", "Q11" => "nurseform02a_Q9", "Q11a" => "nurseform02a_Q10",
"Q12" => "nurseform02a_Q14", "Q12a" => "nurseform02a_Q14a", "Q13" => "nurseform02a_84", "Q13a" => "nurseform02a_85", "Q14" => "nurseform02a_Q21",
"Q14a" => "nurseform02a_Q22", "Q15" => "nurseform02a_Q34", "Q16" => "nurseform_02a_Q35", "Q18" => "nurseform01_Qdisable","Q19"=>"nurseform01_QdisableTypeA",
"Q20" => "nurseform01_QdisableTypeB","Q21"=>"nurseform01_QdisableLevel","Q22"=>"nurseform01_Q20","Q23"=>"nurseform01_QillnessCard",
"Q24"=>"nurseform01_QillnessName", "Q25"=>"nurseform01_QillnessType", "Q25a"=>"nurseform01_QillnessTypeOther", "Q26"=>"nurseform01_QemgHosp",
"Q26a"=>"nurseform01_QemgHospOther",
"Q271a"=>"nurseform01_QContactPerson1Name","Q271b"=>"nurseform01_QContactPerson1Birth",
"Q271c"=>"nurseform01_QContactPerson1Relate","Q271d"=>"nurseform01_QContactPerson1Company",
"Q271e"=>"nurseform01_QContactPerson1Position","Q271f"=>"nurseform01_QContactPerson1Tel1",
"Q271g"=>"nurseform01_QContactPerson1Tel2","Q271h"=>"nurseform01_QContactPerson1Tel3",
"Q271i"=>"nurseform01_QContactPerson1Address","Q271j"=>"nurseform01_QContactPerson1Email",
"Q272a"=>"nurseform01_QContactPerson2Name","Q272b"=>"nurseform01_QContactPerson2Birth",
"Q272c"=>"nurseform01_QContactPerson2Relate","Q272d"=>"nurseform01_QContactPerson2Company",
"Q272e"=>"nurseform01_QContactPerson2Position","Q272f"=>"nurseform01_QContactPerson2Tel1",
"Q272g"=>"nurseform01_QContactPerson2Tel2","Q272h"=>"nurseform01_QContactPerson2Tel3",
"Q272i"=>"nurseform01_QContactPerson2Address","Q272j"=>"nurseform01_QContactPerson2Email",
"Q273a"=>"nurseform01_QContactPerson3Name","Q273b"=>"nurseform01_QContactPerson3Birth",
"Q273c"=>"nurseform01_QContactPerson3Relate","Q273d"=>"nurseform01_QContactPerson3Company",
"Q273e"=>"nurseform01_QContactPerson3Position","Q273f"=>"nurseform01_QContactPerson3Tel1",
"Q273g"=>"nurseform01_QContactPerson3Tel2","Q273h"=>"nurseform01_QContactPerson3Tel3",
"Q273i"=>"nurseform01_QContactPerson3Address","Q273j"=>"nurseform01_QContactPerson3Email",
"Q274a"=>"nurseform01_QContactPerson4Name","Q274b"=>"nurseform01_QContactPerson4Birth",
"Q274c"=>"nurseform01_QContactPerson4Relate","Q274d"=>"nurseform01_QContactPerson4Company",
"Q274e"=>"nurseform01_QContactPerson4Position","Q274f"=>"nurseform01_QContactPerson4Tel1",
"Q274g"=>"nurseform01_QContactPerson4Tel2","Q274h"=>"nurseform01_QContactPerson4Tel3",
"Q274i"=>"nurseform01_QContactPerson4Address","Q274j"=>"nurseform01_QContactPerson4Email",
"Q29"=>"nurseform02a_Q98","Q29a"=>"nurseform02a_Q99","Q30"=>"nurseform02a_Q100","Q30a"=>"nurseform02a_Q101",
"Q60"=>"nurseform01_Qdisableexpiry", "Q61"=>"nurseform02a_Q21", "Q61a"=>"nurseform02a_Q22"
);
// $Q1 = $nurseform01_Q1
foreach ($arrMatch as $k=>$v) {
	if (${$k}=="") {
		if (is_array($v)) {
			foreach ($v as $k1=>$v1) {
				${$k} .= ${$v1};
			}
		} else {
			${$k} = ${$v};
		}
	}
}
?>
<form  method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<h3>個案個別化評估表(一)</h3>
<table width="100%">
  <tr>
    <td width="120" class="title">Resident's name</td>
    <td width="250"><input type="text" name="Q1" id="Q1" size="12" value="<?php echo $Q1; ?>" ></td>
    <td width="120" class="title">出生年月日</td>
    <td width="250"><script> $(function() { $( "#Q2").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="Q2" id="Q2" value="<?php echo formatdate($Q2); ?>" size="12" ></td>
  </tr>
  <tr>
    <td class="title">Social Security number</td>
    <td><input type="text" name="Q3" id="Q3" size="12" value="<?php echo $Q3; ?>"></td>
    <td class="title">Birthplace</td>
    <td><input type="text" name="Q4" id="Q4" size="12" value="<?php echo $Q4; ?>" /></td>
  </tr>
  <tr>
    <td class="title">Residence address</td>
    <td colspan="3"><input type="text" name="Q5" id="Q5" size="60" value="<?php echo $Q5; ?>" /></td>
  </tr>
  <tr>
    <td class="title">Phone</td>
    <td><input type="text" name="Q6" id="Q6" size="20" value="<?php echo $Q6; ?>" /></td>
    <td class="title">Address</td>
    <td><input type="text" name="Q5" id="Q5" size="40" value="<?php echo $Q5; ?>" /></td>
    </tr>
  <tr>
    <td class="title">Source</td>
    <td colspan="3"><?php echo draw_option("Q7","Hospital;機構;家中;Other","m","multi",$Q7,false,5); ?></td>
  </tr>
  <tr>
    <td class="title">婚狀狀況</td>
    <td colspan="3"><?php echo draw_option("Q8","Married;Single;同居;離婚;寡(喪夫);鰥(喪婦);分居;Other","m","single",$Q8,true,6); ?> <input type="text" name="Q8a" id="Q8a" size="24" value="<?php echo $Q8a; ?>"></td>
  </tr>
  <tr>
    <td class="title">主要語言</td>
    <td colspan="3"><?php echo draw_option("Q9","English;Spanish;客語;原住民語;Other","m","multi",$Q9,false,5); ?> <input type="text" name="Q9a" id="Q9a" size="24" value="<?php echo $Q9a; ?>"></td>
  </tr>
  <tr>
    <td class="title">Religion</td>
    <td colspan="3"><?php echo draw_option("Q10","None;Buddhism;Taoism;Christian;Catholicism;Islam;Other","s","multi",$Q10,false,5); ?> <input type="text" name="Q10a" id="Q10a" size="24" value="<?php echo $Q10a; ?>"></td>
  </tr>
  <tr>
    <td class="title">以前職業</td>
    <td colspan="3"><?php echo draw_option("Q11","None;公;商;工;農;Other","s","multi",$Q11,false,5); ?> <input type="text" name="Q11a" id="Q11a" size="10" value="<?php echo $Q11a; ?>"></td>
  </tr>
  <tr>
    <td class="title" width="120">Education</td>
    <td colspan="3"><?php echo draw_option("Q12","Illiterate;Unofficial school;Elementary school;Middle school;High school;University;Grad School;Other","m","single",$Q12,true,5); ?> <input type="text" name="Q12a" id="Q12a" size="14" value="<?php echo $Q12a; ?>"></td>
  </tr>
  <tr>
    <td class="title" width="120">一般病史</td>
    <td colspan="3"><?php echo draw_option("Q61","None;Diabetes;Hypertension;Stroke;Stroke(Left);Stroke(Right);Heart disease;Kidney disease;Liver disease;Dementia;Asthma;Parkinson's disease;Benign prostatic hyperplasia;Mental illness;Cancer;Other","m","multi",$Q61,true,6); ?> <input type="text" name="Q61a" id="Q61a" size="14"  value="<?php echo $Q61a; ?>" /></td>
  </tr>
  <tr>
    <td class="title" width="120">興趣專長</td>
    <td colspan="3"><?php echo draw_option("Q13","None;看電視;聽音樂;聽廣播;看報紙;閱讀雜誌書籍;繪畫;書法;舞蹈;編織;散步;棋藝;園藝;茶藝;插花;寵物;打麻將;逛市;Other","m","multi",$Q13,true,7); ?> <input type="text" name="Q13a" id="Q13a" size="30" value="<?php echo $Q13a; ?>" /></td>
  </tr>
<tr>
    <td class="title" width="120">Food allergy</td>
    <td colspan="3"><?php echo draw_option("Q15","None;Yes","s","single",$Q15,false,6); ?> <input type="text" name="Q16" id="Q16" size="60" value="<?php echo $Q16; ?>" /></td>
  </tr>
  <tr>
    <td class="title" width="120">Drug allergy</td>
    <?php 
	if($Q17 ==""){
		$med = new DB;
		$med->query("SELECT * FROM `allergicmed` WHERE `HospNo`='".$HospNo."'");
		if($med->num_rows()>0){
			for($i2=0;$i2<$med->num_rows();$i2++){
				$rmed = $med->fetch_assoc();
				if($Q17!=""){$Q17 .= "、";}
				$Q17 .= $rmed['DrugName'];
			}
		}
	}
	?>
    <td colspan="3"><textarea name="Q17" id="Q17" rows="6" ><?php echo $Q17; ?></textarea>
      <input type="button" id="newallergicmed" name="newallergicmed" value="Add allergic drug" onclick="openVerificationForm('#newmed-form');" />
    </td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td class="title">Disability proof card</td>
    <td width="160" colspan="5"><?php echo draw_option("Q18","Has;None","s","multi",$Q18,false,5); ?><br />舊類別：
    <div class="formselect" style="display:inline;">
    <select name="Q19" id="Q19">
      <option value="0" <?php if ($Q19==0) echo " selected"; ?>>None</option>
      <option value="">---------------舊制類別---------------</option>
      <option value="9" <?php if ($Q19==9) echo " selected"; ?>>智能障礙者</option>
      <option value="10" <?php if ($Q19==10) echo " selected"; ?>>vegetative being</option>
      <option value="11" <?php if ($Q19==11) echo " selected"; ?>>失智症者</option>
      <option value="12" <?php if ($Q19==12) echo " selected"; ?>>自閉症者</option>
      <option value="13" <?php if ($Q19==13) echo " selected"; ?>>慢性精神病患者</option>
      <option value="14" <?php if ($Q19==14) echo " selected"; ?>>頑性（難治型）癲癇症者</option>
      <option value="15" <?php if ($Q19==15) echo " selected"; ?>>視覺障礙者</option>
      <option value="16" <?php if ($Q19==16) echo " selected"; ?>>聽覺機能障礙者</option>
      <option value="17" <?php if ($Q19==17) echo " selected"; ?>>平衡機能障礙者</option>
      <option value="18" <?php if ($Q19==18) echo " selected"; ?>>聲音機能或語言機能障礙者</option>
      <option value="19" <?php if ($Q19==19) echo " selected"; ?>>重要器官失去功能者-心臟</option>
      <option value="20" <?php if ($Q19==20) echo " selected"; ?>>重要器官失去功能者-造血機能</option>
      <option value="21" <?php if ($Q19==21) echo " selected"; ?>>重要器官失去功能者-呼吸器官</option>
      <option value="22" <?php if ($Q19==22) echo " selected"; ?>>重要器官失去功能-吞嚥機能</option>
      <option value="23" <?php if ($Q19==23) echo " selected"; ?>>重要器官失去功能-胃</option>
      <option value="24" <?php if ($Q19==24) echo " selected"; ?>>重要器官失去功能-腸道</option>
      <option value="25" <?php if ($Q19==25) echo " selected"; ?>>重要器官失去功能-肝臟</option>
      <option value="26" <?php if ($Q19==26) echo " selected"; ?>>重要器官失去功能-腎臟</option>
      <option value="27" <?php if ($Q19==27) echo " selected"; ?>>重要器官失去功能-膀胱</option>
      <option value="28" <?php if ($Q19==28) echo " selected"; ?>>肢體障礙者</option>
      <option value="29" <?php if ($Q19==29) echo " selected"; ?>>顏面損傷者</option>
      <option value="30" <?php if ($Q19==30) echo " selected"; ?>>多重障礙者</option>
      <option value="31" <?php if ($Q19==31) echo " selected"; ?>>經中央衛生主管機關認定，因罕見疾病而致身心功能障礙者</option>
      <option value="32" <?php if ($Q19==32) echo " selected"; ?>>其他經中央衛生主管機關認定之障礙者(染色體異常、先天代謝異常、先天缺陷)</option>
    </select>
    </div><br />
    <div class="formselect">Category:
    <?php echo draw_checkbox_2col("Q20","None;Class 1: Nervous system, structural impaired or mentally challenged;Class 2: Eye, ear or related sensors structural impair;Class 3 : Voicing or structure related to speech dysfunction;Class 4 : Circulation, hematopoiesis or immune system dysfunction;Class 5 : Digestion, metabolism and endocrine system dysfunction;Class 6 : Urinary and reproductive system dysfunction;Class 7 : Nuron, muscles and bone motion dysfunction;Class 8 : Skin and related structure dysfunction",$Q20,"multi"); ?>
    </select>
    </div><br />
    <div class="formselect" style="margin-left:30px; display:inline;">Severity:
    <select name="Q21" id="Q21">
      <option value="0" <?php if ($Q21==0) echo " selected"; ?>>None</option>
      <option value="1" <?php if ($Q21==1) echo " selected"; ?>>Mild</option>
      <option value="2" <?php if ($Q21==2) echo " selected"; ?>>Moderate</option>
      <option value="3" <?php if ($Q21==3) echo " selected"; ?>>Severe</option>
      <option value="4" <?php if ($Q21==4) echo " selected"; ?>>Extremely severe</option>
    </select>
    </div>
<script> $(function() { $( "#Q60").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script>Validity period:<input type="text" name="Q60" id="Q60" value="<?php echo $Q60; ?>" size="10">    </td>
  </tr>
  <tr>
    <td class="title">Proof of major injury</td>
    <td><?php echo draw_option("Q23","Has;None","s","multi",$Q23,false,5); ?></td>
    <td class="title">Major injuries</td>
    <td colspan="3"><input type="text" name="Q24" id="Q24" value="<?php echo $Q24; ?>" size="24"></td>
  </tr>
  <tr>
    <td class="title">Admission category</td>
    <td colspan="5"><?php echo draw_option("Q25","General;Veteran;Middle-low income;Low-income;Other","m","multi",$Q25,false,5); ?> <input type="text" name="Q25a" id="Q25a" value="<?php echo $Q25a; ?>" size="24"></td>
  </tr>
  <?php
  //讀取系統設定
  $dbHosp = new DB2;
  $dbHosp->query("SELECT * FROM `system_setting` WHERE `OrgID`='".$_SESSION['nOrgID_lwj']."'");
  $rHosp = $dbHosp->fetch_assoc();
  for ($i1=1;$i1<=20;$i1++) {
	  if ($rHosp['Hosp'.$i1]!="") { $HospTxt .= $rHosp['Hosp'.$i1].';'; }
  }
  $HospTxt .= "Other";
  ?>
  <tr>
    <td class="title">Visiting hospital</td>
    <td colspan="5"><?php echo draw_option("Q26",$HospTxt,"l","multi",$Q26,true,5); ?> <input type="text" name="Q26a" id="Q26a" size="24" value="<?php echo $Q26a; ?>"></td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td colspan="6" class="title">Client (primary contact person)</td>
  </tr>
  <tr>
    <td class="title">Full name</td>
    <td><input type="text" name="Q271a" id="Q271a" size="10" value="<?php echo $Q271a; ?>"></td>
    <td class="title">DOB</td>
    <td><script> $(function() { $( "#Q271b").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="Q271b" id="Q271b" size="10" value="<?php echo $Q271b; ?>"></td>
    <td class="title">relationship</td>
    <td><input type="text" name="Q271c" id="Q271c" size="10" value="<?php echo $Q271c; ?>"></td>
  </tr>
  <tr>
    <td class="title">Serving unit</td>
    <td colspan="3"><input type="text" name="Q271d" id="Q271d" size="60" value="<?php echo $Q271d; ?>"></td>
    <td class="title">Occupation</td>
    <td><input type="text" name="Q271e" id="Q271e" size="10" value="<?php echo $Q271e; ?>"></td>
  </tr>
  <tr>
    <td class="title">Phone #(H)</td>
    <td><input type="text" name="Q271f" id="Q271f" size="18" value="<?php echo $Q271f; ?>"></td>
    <td class="title">Phone #(W)</td>
    <td><input type="text" name="Q271g" id="Q271g" size="18" value="<?php echo $Q271g; ?>"></td>
    <td class="title">Cell phone #</td>
    <td><input type="text" name="Q271h" id="Q271h" size="18" value="<?php echo $Q271h; ?>" /></td>
  </tr>
  <tr>
    <td class="title">Contact address</td>
    <td colspan="5"><input type="text" name="Q271i" id="Q271i" size="60" value="<?php echo $Q271i; ?>"></td>
  </tr>
  <tr>
    <td class="title">Email</td>
    <td colspan="5"><input type="text" name="Q271j" id="Q271j" size="60" value="<?php echo $Q271j; ?>"></td>
  </tr>
  <?php
  for ($i=1;$i<=$rHosp['ContactPersonNo'];$i++) {
  ?>
  <tr>
    <td colspan="6" class="title"><form>Emergency contact (<?php echo $i; ?>) <input type="button" onclick="cpinfo('<?php echo ($i+1); ?>');" value="Same as primary contact"></form></td>
  </tr>
  <tr>
    <td class="title">Full name</td>
    <td><input type="text" name="Q27<?php echo ($i+1); ?>a" id="Q27<?php echo ($i+1); ?>a" size="10" value="<?php echo ${'Q27'.($i+1).'a'}; ?>"></td>
    <td class="title">DOB</td>
    <td><script> $(function() { $( "#Q27<?php echo ($i+1); ?>b").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="Q27<?php echo ($i+1); ?>b" id="Q27<?php echo ($i+1); ?>b" size="10" value="<?php echo ${'Q27'.($i+1).'b'}; ?>"></td>
    <td class="title">relationship</td>
    <td><input type="text" name="Q27<?php echo ($i+1); ?>c" id="Q27<?php echo ($i+1); ?>c" size="10" value="<?php echo ${'Q27'.($i+1).'c'}; ?>"></td>
  </tr>
  <tr>
    <td class="title">Serving unit</td>
    <td colspan="3"><input type="text" name="Q27<?php echo ($i+1); ?>d" id="Q27<?php echo ($i+1); ?>d" size="60" value="<?php echo ${'Q27'.($i+1).'d'}; ?>"></td>
    <td class="title">Occupation</td>
    <td><input type="text" name="Q27<?php echo ($i+1); ?>e" id="Q27<?php echo ($i+1); ?>e" size="10" value="<?php echo ${'Q27'.($i+1).'e'}; ?>"></td>
  </tr>
  <tr>
    <td class="title">Phone #(H)</td>
    <td><input type="text" name="Q27<?php echo ($i+1); ?>f" id="Q27<?php echo ($i+1); ?>f" size="20" value="<?php echo ${'Q27'.($i+1).'f'}; ?>"></td>
    <td class="title">Phone #(W)</td>
    <td><input type="text" name="Q27<?php echo ($i+1); ?>g" id="Q27<?php echo ($i+1); ?>g" size="20" value="<?php echo ${'Q27'.($i+1).'g'}; ?>"></td>
    <td class="title">Cell phone #</td>
    <td><input type="text" name="Q27<?php echo ($i+1); ?>h" id="Q27<?php echo ($i+1); ?>h" size="20" value="<?php echo ${'Q27'.($i+1).'h'}; ?>"></td>
  </tr>
  <tr>
    <td class="title">Contact address</td>
    <td colspan="5"><input type="text" name="Q27<?php echo ($i+1); ?>i" id="Q27<?php echo ($i+1); ?>i" size="60" value="<?php echo ${'Q27'.($i+1).'i'} ?>"></td>
  </tr>
  <tr>
    <td class="title">Email</td>
    <td colspan="5"><input type="text" name="Q27<?php echo ($i+1); ?>j" id="Q27<?php echo ($i+1); ?>j" size="60" value="<?php echo ${'Q27'.($i+1).'j'}; ?>"></td>
  </tr>
  <?php
  }
  for ($i=1;$i<=3;$i++) {
  ?>
  <tr>
    <td colspan="6" class="title">家庭成員 (<?php echo $i; ?>)</td>
  </tr>
  <tr>
    <td class="title">Full name</td>
    <td><input type="text" name="Q28<?php echo ($i+1); ?>a" id="Q28<?php echo ($i+1); ?>a" size="10" value="<?php echo ${'Q28'.($i+1).'a'}; ?>"></td>
    <td class="title">DOB</td>
    <td><script> $(function() { $( "#Q28<?php echo ($i+1); ?>b").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="Q28<?php echo ($i+1); ?>b" id="Q28<?php echo ($i+1); ?>b" size="10" value="<?php echo ${'Q28'.($i+1).'b'}; ?>"></td>
    <td class="title">relationship</td>
    <td><input type="text" name="Q28<?php echo ($i+1); ?>c" id="Q28<?php echo ($i+1); ?>c" size="10" value="<?php echo ${'Q28'.($i+1).'c'}; ?>"></td>
  </tr>
  <tr>
    <td class="title">Serving unit</td>
    <td colspan="3"><input type="text" name="Q28<?php echo ($i+1); ?>d" id="Q28<?php echo ($i+1); ?>d" size="60" value="<?php echo ${'Q28'.($i+1).'d'}; ?>"></td>
    <td class="title">Occupation</td>
    <td><input type="text" name="Q28<?php echo ($i+1); ?>e" id="Q28<?php echo ($i+1); ?>e" size="10" value="<?php echo ${'Q28'.($i+1).'e'}; ?>"></td>
  </tr>
  <tr>
    <td class="title">Phone #(H)</td>
    <td><input type="text" name="Q28<?php echo ($i+1); ?>f" id="Q28<?php echo ($i+1); ?>f" size="20" value="<?php echo ${'Q28'.($i+1).'f'}; ?>"></td>
    <td class="title">Phone #(W)</td>
    <td><input type="text" name="Q28<?php echo ($i+1); ?>g" id="Q28<?php echo ($i+1); ?>g" size="20" value="<?php echo ${'Q28'.($i+1).'g'}; ?>"></td>
    <td class="title">Cell phone #</td>
    <td><input type="text" name="Q28<?php echo ($i+1); ?>h" id="Q28<?php echo ($i+1); ?>h" size="20" value="<?php echo ${'Q28'.($i+1).'h'}; ?>"></td>
  </tr>
  <tr>
    <td class="title">Contact address</td>
    <td colspan="5"><input type="text" name="Q28<?php echo ($i+1); ?>i" id="Q28<?php echo ($i+1); ?>i" size="60" value="<?php echo ${'Q28'.($i+1).'i'} ?>"></td>
  </tr>
  <tr>
    <td class="title">Email</td>
    <td colspan="5"><input type="text" name="Q28<?php echo ($i+1); ?>j" id="Q28<?php echo ($i+1); ?>j" size="60" value="<?php echo ${'Q28'.($i+1).'j'}; ?>"></td>
  </tr>
  <?php
  }
  ?>
  <tr>
    <td class="title">Reside</td>
    <td colspan="5"><?php echo draw_option("Q29","With spouse;With certain child;With different children;Alone;In nursing home;Other","l","multi",$Q29,true,4); ?> <input type="text" name="Q29a" id="Q29a" size="30" value="<?php echo $Q29a; ?>" /></td>
  </tr>
  <tr>
    <td class="title">Economic sources</td>
    <td colspan="5"><?php echo draw_option("Q30","Resident own;Spouse;Children share the burden;Relative(s);Social security;Other","l","multi",$Q30,true,4); ?> <input type="text" name="Q30a" id="Q30a" size="30" value="<?php echo $Q30a; ?>" /></td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td class="title" colspan="2">生理、心理狀況及行為能力</td>
  </tr>
  <tr>
    <td class="title" width="160">一、活動力</td>
    <td><?php echo draw_checkbox_nobr("Q31","能自理生活;部份日常生活功能需輔助或依賴他人;不能自理生活",$Q31,"multi"); ?></td>
  </tr>
  <tr>
    <td class="title">二、行動輔具</td>
    <td><?php echo draw_checkbox_nobr("Q32","Canes;Walker;支架;wheelchair;Other<input type=\"text\" name=\"Q32a\" value=\"".$Q32a."\">",$Q32,"multi"); ?></td>
  </tr>
  <tr>
    <td class="title">三、皮膚性質</td>
    <td><?php echo draw_checkbox_nobr("Q33","有彈性;Dry Skin;皮膚病;疥瘡，部位<input type=\"text\" name=\"Q33a\">",$Q33,"multi"); ?></td>
  </tr>
  <tr>
    <td class="title">四、聽力</td>
    <td><?php echo draw_checkbox_nobr("Q34","Normal;重聽，是否使用助聽器<input type=\"text\" name=\"Q34a\">;聾",$Q34,"multi"); ?></td>
  </tr>
  <tr>
    <td class="title">五、視力</td>
    <td><?php echo draw_checkbox_nobr("Q35","Normal;Blurred;右眼失明;眼鏡",$Q35,"multi"); ?></td>
  </tr>
  <tr>
    <td class="title">六、意識狀況</td>
    <td><?php echo draw_checkbox_nobr("Q36","Clear;不清楚;對刺激有反應",$Q36,"multi"); ?></td>
  </tr>
  <tr>
    <td class="title">七、睡眠狀況</td>
    <td><?php echo draw_checkbox_nobr("Q37","Normal;不易入眠;Insomnia;Day/Night reversed;服用安眠藥",$Q37,"multi"); ?></td>
  </tr>
  <tr>
    <td class="title">八、食慾</td>
    <td><?php echo draw_checkbox_nobr("Q38","Normal;Normal;Poor appetite;管餵食",$Q38,"multi"); ?></td>
  </tr>
  <tr>
    <td class="title">九、溝通能力</td>
    <td><?php echo draw_checkbox_nobr("Q39","Normal;語言不清;肢體語言;手語;Other<input type=\"text\" name=\"Q39a\" value=\"".$Q39a."\">",$Q39,"multi"); ?></td>
  </tr>
  <tr>
    <td class="title">十、情緒狀態</td>
    <td><?php echo draw_checkbox_nobr("Q40","Stable;Depression;Anxious;躁動;Other(s):<input type=\"text\" name=\"Q40a\" value=\"".$Q40a."\">",$Q40,"multi"); ?></td>
  </tr>
  <tr>
    <td class="title">十一、特殊習慣</td>
    <td><input type="text" name="Q41" size="60"></td>
  </tr>
  <tr>
    <td class="title" colspan="2">精神及行為狀況</td>
  </tr>
  <tr>
    <td class="title">一、態度</td>
    <td><?php echo draw_checkbox_nobr("Q42","Friendly;Suspicious;苛求冷漠;Resist;Hostile",$Q42,"multi"); ?></td>
  </tr>
  <tr>
    <td class="title">二、自發性</td>
    <td><?php echo draw_checkbox_nobr("Q43","自動/積極;需鼓勵;指示;需帶動;依賴他人",$Q43,"multi"); ?></td>
  </tr>
  <tr>
    <td class="title">三、感知</td>
    <td><?php echo draw_checkbox_nobr("Q44","Appropriate/Normal;需解釋;回應遲鈍;混淆;Hallucination/幻聽/幻視",$Q44,"multi"); ?></td>
  </tr>
  <tr>
    <td class="title">四、情感</td>
    <td><?php echo draw_checkbox_nobr("Q45","Appropriate/Normal;豐富;Anxious/緊張/壓抑;冷漠/抑鬱/傷感;狂躁/憤怒",$Q45,"multi"); ?></td>
  </tr>
  <tr>
    <td class="title">五、思考</td>
    <td><?php echo draw_checkbox_nobr("Q46","合情合理;善忘;偏差;糊塗;Delusions",$Q46,"multi"); ?></td>
  </tr>
  <tr>
    <td class="title">六、行為</td>
    <td><?php echo draw_checkbox_nobr("Q47","Appropriate/Normal;頑皮/惡作劇;Flinch/煩躁;不恰當行為;暴力傾向/恐嚇/打架",$Q47,"multi"); ?></td>
  </tr>
  <tr>
    <td class="title">七、定向感</td>
    <td><?php echo draw_option("Q48","Normal;Abnormal","m","single",$Q48,false,4); ?></td>
  </tr>
  <tr>
    <td class="title">八、記憶力</td>
    <td><?php echo draw_option("Q49","Normal;Abnormal","m","single",$Q49,false,4); ?></td>
  </tr>
  <tr>
    <td class="title">九、計算能力</td>
    <td><?php echo draw_option("Q50","Normal;Abnormal","m","single",$Q50,false,4); ?></td>
  </tr>
  <tr>
    <td class="title" colspan="2">社心評估</td>
  </tr>
  <tr>
    <td class="title">情緒狀況</td>
    <td><?php echo draw_checkbox_nobr("Q51","溫和;少有反應;Unstable;Anxiety;易憂鬱;Impulsive;Temper easily;Other<input type=\"text\" name=\"Q51a\" value=\"".$Q51a."\">",$Q51,"multi"); ?></td>
  </tr>
  <tr>
    <td class="title">特殊行為</td>
    <td><?php echo draw_checkbox_2col("Q52","None;過分安靜;說話不停;自言自語;Lack of concentration;坐立不安;多負向思考/言語;具攻擊性<input type=\"text\" name=\"Q52a\" value=\"".$Q52a."\">;具破壞性<input type=\"text\" name=\"Q52b\" value=\"".$Q52a."\">;具自傷傾向<input type=\"text\" name=\"Q52c\" value=\"".$Q52c."\">;Repeat same action<input type=\"text\" name=\"Q52d\" value=\"".$Q52d."\">;固執性行為<input type=\"text\" name=\"Q52e\" value=\"".$Q52e."\">;Other<input type=\"text\" name=\"Q52f\" value=\"".$Q52f."\">",$Q52,"multi"); ?></td>
  </tr>
  <tr>
    <td class="title">Social skills</td>
    <td><?php echo draw_checkbox_2col("Q53","易與人交朋友;Fair;Isolated;習慣依賴人;Resist;Other<input type=\"text\" name=\"Q53a\" value=\"".$Q53a."\">",$Q53,"multi"); ?></td>
  </tr>
  <tr>
    <td class="title">與家人相處</td>
    <td><?php echo draw_checkbox_nobr("Q54","互動關係佳;Basic Interaction;互動關係不佳;Isolated;無家人",$Q54,"multi"); ?></td>
  </tr>
  <tr>
    <td class="title" colspan="2">Demand assessment</td>
  </tr>
  <tr>
    <td class="title">Emotions</td>
    <td><?php echo draw_checkbox_nobr("Q55","穩;家人提供支持關懷;需情緒輔導;Other<input type=\"text\" name=\"Q55a\" value=\"".$Q55a."\">",$Q55,"multi"); ?></td>
  </tr>
  <tr>
    <td class="title">社交</td>
    <td><?php echo draw_checkbox_nobr("Q56","無法活動;鼓勵參與社交活動;介紹同質性住民;Other<input type=\"text\" name=\"Q56a\" value=\"".$Q56a."\">",$Q56,"multi"); ?></td>
  </tr>
  <tr>
    <td class="title">Social resource</td>
    <td><?php echo draw_checkbox_nobr("Q57","無需求;介紹社會資源",$Q57,"multi"); ?></td>
  </tr>
  <tr>
    <td class="title">志工服務</td>
    <td><?php echo draw_checkbox_nobr("Q58","無需求;陪同聊天;陪同散步;情緒支持;Other<input type=\"text\" name=\"Q58a\" value=\"".$Q58a."\">",$Q58,"multi"); ?></td>
  </tr>
  <tr>
    <td class="title">Other</td>
    <td><input type="text" name="Q59" size="60" value="<?php echo $Q59;?>"></td>
  </tr>
</table>  
<table width="100%">
  <tr>
    <td style="background:#ffffff;">Filled date：<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if ($date != NULL) { echo formatdate($date); } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" /></td>
    <td style="background:#ffffff;" align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>
<br />
<center><input type="hidden" name="formID" id="formID" value="socialform22" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></center>
</form>
<div id="newmed-form" title="Add allergic drug" class="dialog-form"> 
  <form>
  <fieldset>
    <table>
      <tr>
        <td class="title">Medication</td>
        <td><input type="text" name="drugName" id="drugName" value="" class="text ui-widget-content ui-corner-all" size="40" onkeyup="autocompleteMeds(this.id)" onclick="autocompleteMeds(this.id)"/></td>
      </tr>
    </table>
  </fieldset>
  </form>
</div>

<?php
if ($r1) {
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
}
?>
<script>
function cpinfo(pNo) {
	$('#Q27'+pNo+'a').val($('#Q271a').val());
	$('#Q27'+pNo+'b').val($('#Q271b').val());
	$('#Q27'+pNo+'c').val($('#Q271c').val());
	$('#Q27'+pNo+'d').val($('#Q271d').val());
	$('#Q27'+pNo+'e').val($('#Q271e').val());
	$('#Q27'+pNo+'f').val($('#Q271f').val());
	$('#Q27'+pNo+'g').val($('#Q271g').val());
	$('#Q27'+pNo+'h').val($('#Q271h').val());
	$('#Q27'+pNo+'i').val($('#Q271i').val());
	$('#Q27'+pNo+'j').val($('#Q271j').val());
}
function loadMedNames(id){
	var medicine= $("#"+id).val();
	var medList = "";
	$.ajax({
		url: 'class/med.php',
		type: "POST",
		async: false,
		data: { med: medicine}
	}).done(function(meds){
		medList = meds.split(',');
	});
	return medList;
}
function autocompleteMeds(id){
	var meds = loadMedNames(id);
	$("#"+id).autocomplete({ source: meds, minLength:3 });
}


$(function() {
	$( "#newrecord" ).button().click(function() {
		$("#QremindDate").val($("#Qdisableexpiry").val());
		$("#QremindContent").val('身心障礙手冊將於 ' + $("#Qdisableexpiry").val() + ' 到期');
		$( "#dialog-form" ).dialog( "open" );
	});
	var medicine = $("#medicine").val();
    $( "#newmed-form" ).dialog({
		autoOpen: false,
		height: 210,
		width: 500,
		modal: true,
		buttons: {
			"Add allergic drug": function() {
				$.ajax({
					url: "class/allergicmed.php",
					type: "POST",
					data: {"HospNo": $("#HospNo").val(), "drugName":$("#drugName").val() },
					success: function(data) {
						if ($("#Q17").val()!="") {
							$("#Q17").val($("#Q17").val()+"、"+data);
						} else {
							$("#Q17").val(data);
						}
						$( "#newmed-form" ).dialog( "close" );
						alert("已經成功新增過敏藥物！");
					}
				});
			},
			"Cancel": function() {
				$( this ).dialog( "close" );
			}
		}
	});
});
</script>