<script type="text/javascript" src="js/LWJ_tabs.js"></script>
<h3>住民資料概覽</h3>
<table width="100%">
  <tr>
    <td rowspan="7" width="180">
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
    <?php }?>
    </td>
    <td width="90" class="title">Bed #</td>
    <td width="160"><?php echo getBedID($_GET['pid']); ?></td>
    <td width="90" class="title">Full name</td>
    <td width="160"><?php echo getTitle("patient", "Name", $_GET['pid'], "patientID", ""); ?></td>
    <td width="90" class="title">Gender</td>
    <td><?php echo checkgender($_GET['pid']); ?></td>
  </tr>
  <tr>
    <td class="title">Social Security number</td>
    <td><?php echo getTitle("patient", "IdNo", ($_GET['pid']), "patientID", ""); ?></td>
    <td class="title">DOB</td>
    <td colspan="3"><?php echo formatdate(getPatientBOD($_GET['pid'])); ?></td>
  </tr>
  <tr>
    <td class="title">主要聯絡人</td>
    <td><?php echo getTitle("nurseform01", "QContactPerson1Name", $HospNo, "HospNo", "").' ('.getTitle("nurseform01", "QContactPerson1Relate", $HospNo, "HospNo", "").')'; ?></td>
    <td class="title">Phone #</td>
    <td colspan="3"><?php echo getTitle("nurseform01", "QContactPerson1Tel1", $HospNo, "HospNo", "").'<br>'.getTitle("nurseform01", "QContactPerson1Tel2", $HospNo, "HospNo", ""); ?></td>
  </tr>
  <tr>
    <td class="title">次要聯絡人</td>
    <td><?php echo getTitle("nurseform01", "QContactPerson2Name", $HospNo, "HospNo", "").' ('.getTitle("nurseform01", "QContactPerson2Relate", $HospNo, "HospNo", "").')'; ?></td>
    <td class="title">Phone #</td>
    <td colspan="3"><?php echo getTitle("nurseform01", "QContactPerson2Tel1", $HospNo, "HospNo", "").'<br>'.getTitle("nurseform01", "QContactPerson2Tel2", $HospNo, "HospNo", ""); ?></td>
  </tr>
  <tr>
    <td class="title">Admission category</td>
    <td>
	<?php
	$arrQillnessType = array("","General","Veteran","Middle-low income","Low-income","Other");
	$ansQillnessType = getGroupTitle("nurseform01", "QillnessType", "_", 5, $HospNo, "HospNo", "", "date", "desc");
	if (count($ansQillnessType)>0) {
		foreach ($ansQillnessType as $k1=>$v1) {
			if ($txt1!="") { $txt1 .= '、'; }
			$txt1 .= $arrQillnessType[$v1];
		}
		echo $txt1;
	}
	?>
    </td>
    <td class="title">過敏病史</td>
    <td colspan="3">
    藥物：
    <?php
	$db1 = new DB;
	$db1->query("SELECT * FROM `allergicmed` WHERE `HospNo`='".$HospNo."'");
	if ($db1->num_rows()>0) {
		for ($i1=0;$i1<$db1->num_rows();$i1++) {
			$r1 = $db1->fetch_assoc();
			if ($txt2!="") { $txt2 .= '、'; }
			$txt2 .= $r1['DrugName'];
		}
	} else {
		$txt2 = "None";
	}
	echo $txt2;
	?>
	<br>食物：
    <?php
	$arr2aQ34 = array("","None","Yes");
	$ans2aQ34 = getGroupTitle("nurseform02a", "Q34", "_", 2, $HospNo, "HospNo", "", "date", "desc");
	if (count($ans2aQ34)>0) {
		foreach ($ans2aQ34 as $k2=>$v2) {
			if ($txt3!="") { $txt3 .= '、'; }
			$txt3 .= $arr2aQ34[$v2];
		}
	}
	if ($txt3=="") { $txt3 = "None"; }
	elseif ($txt3=="Yes") { $txt3 .= '，'.getTitle("nurseform02a", "Q35", $HospNo, "HospNo", "", "date", "desc"); }
	echo $txt3; 
	?>
    </td>
  </tr>
  <tr>
    <td class="title">Major diagnosis</td>
    <td colspan="5">
    <?php
	$ansQdiag = getGroupTitle("nurseform01", "Qdiag", "", 8, $HospNo, "HospNo", "", "date", "desc",2);
	if (count($ansQdiag)>0) {
		foreach ($ansQdiag as $k3=>$v3) {
			if ($txt4!="") { $txt4 .= '、'; }
			$txt4 .= $v3;
		}
		if ($txt4=="") { $txt4 = "None"; }
	}
	echo $txt4;
	?>
    </td>
  </tr>
  <tr>
    <td class="title">特殊狀況</td>
    <td colspan="5">
    Food intake status:
    <?php
	$arr2bQ24 = array("","General","Meat only","Vegetarian","Soft food","細碎","糊狀","自製流質","配方流質");
	$ans2bQ24 = getGroupTitle("nurseform02b", "Q24", "_", 8, $HospNo, "HospNo", "", "date", "desc");
	if (count($ans2bQ24)>0) {
		foreach ($ans2bQ24 as $k4=>$v4) {
			if ($txt5!="") { $txt5 .= '、'; }
			$txt5 .= $arr2bQ24[$v4];
		}
	}
	if ($txt5=="") { $txt5 = "None"; }
	if (count($ans2bQ24)>0 && in_array(8,$ans2bQ24)) { $txt5 .= "：".getTitle("nurseform02b", "Q24a", $HospNo, "HospNo", "", "date", "desc")." kcal/Day(s)"; }
	echo $txt5;
	?>
    <br>壓瘡：
    <?php
	$arr2aQ51 = array("","None","Yes");
	$ans2aQ51 = getGroupTitle("nurseform02a", "Q51", "_", 2, $HospNo, "HospNo", "", "date", "desc");
	if (count($ans2aQ51)>0) {
		foreach ($ans2aQ51 as $k5=>$v5) {
			if ($txt6!="") { $txt6 .= '、'; }
			$txt6 .= $arr2aQ51[$v5];
		}
	}
	if ($txt6=="") { $txt6 = "None"; }
	echo $txt6; 
	?>
    </td>
  </tr>
  <tr>
    <td colspan="7" style="background:#fff;">
    <div id="tabs">
      <ul>
        <li><a href="#tabs1">護理服務</a></li>
        <li><a href="#tabs2">照顧服務</a></li>
        <li><a href="#tabs3">社工服務</a></li>
        <li><a href="#tabs4">個別化照顧計畫</a></li>
      </ul>
      <div id="tabs1">
      <table width="100%">
        <tr>
          <td class="title_s" width="140">Height</td>
          <td><?php echo getTitle("patient", "height", $_GET['pid'], "patientID", ""); ?></td>
          <td class="title_s" width="140">Body weight</td>
          <td><?php echo getTitle("vitalsigns", "Value", $_GET['pid'], "PersonID", "", "RecordedTime", "desc", " AND `LoincCode`='18833-4'").' lbs'; ?></td>
        </tr>
        <tr>
          <td class="title_s">Vital Signs</td>
          <td colspan="3">
          <span class="title">&nbsp;T&nbsp;</span>&nbsp;&nbsp;<?php echo getTitle("vitalsigns", "Value", $_GET['pid'], "PersonID", "", "RecordedTime", "desc", " AND `LoincCode`='8310-5'"); ?>&nbsp;&nbsp;<span class="title">&nbsp;P&nbsp;</span>&nbsp;&nbsp;<?php echo getTitle("vitalsigns", "Value", $_GET['pid'], "PersonID", "", "RecordedTime", "desc", " AND `LoincCode`='8867-4'"); ?>&nbsp;&nbsp;<span class="title">&nbsp;R&nbsp;</span>&nbsp;&nbsp;<?php echo getTitle("vitalsigns", "Value", $_GET['pid'], "PersonID", "", "RecordedTime", "desc", " AND `LoincCode`='9279-1'"); ?>&nbsp;&nbsp;<span class="title">&nbsp;BP&nbsp;</span>&nbsp;&nbsp;<?php echo getTitle("vitalsigns", "Value", $_GET['pid'], "PersonID", "", "RecordedTime", "desc", " AND `LoincCode`='8480-6'").'/'.getTitle("vitalsigns", "Value", $_GET['pid'], "PersonID", "", "RecordedTime", "desc", " AND `LoincCode`='8462-4'"); ?> mmHg</td>
        </tr>
        <tr>
          <td class="title_s">Admission method</td>
          <td>
		  <?php
		  $arr2aQ7 = array("","On foot","wheelchair","In bed","Other");
		  $ans2aQ7 = getGroupTitle("nurseform02a", "Q7", "_", 4, $HospNo, "HospNo", "", "date", "desc");
		  if (count($ans2aQ7)>0) {
			  foreach ($ans2aQ7 as $k6=>$v6) {
				  if ($txt7!="") { $txt7 .= '、'; }
				  $txt7 .= $arr2aQ7[$v6];
			  }
		  }
		  echo $txt7; 
		  ?>
          </td>
          <td class="title_s">Immunization (Vaccine)</td>
          <td>
		  <?php
		  $arr2aQ113 = array("","None","Flu shot","Streptococcus pneumoniae");
		  $ans2aQ113 = getGroupTitle("nurseform02a", "Q113", "_", 3, $HospNo, "HospNo", "", "date", "desc");
		  if (count($ans2aQ113)>0) {
			  foreach ($ans2aQ113 as $k7=>$v7) {
				  if ($txt8!="") { $txt8 .= '、'; }
				  $txt8 .= $arr2aQ113[$v7];
			  }
		  }
		  if ($txt8=="") { $txt8 = "None"; }
		  echo $txt8; 
		  ?>
          </td>
        </tr>
        <tr>
          <td class="title_s">Past medical history</td>
          <td colspan="3">
		  <?php
		  $arr2aQ21 = array("","None","Diabetes","Hypertension","Stroke","Stroke(Left)","Stroke(Right)","Heart disease","Kidney disease","Liver disease","Dementia","Asthma","Parkinson's disease","Benign prostatic hyperplasia","Mental illness","Cancer","Other");
		  $ans2aQ21 = getGroupTitle("nurseform02a", "Q21", "_", 16, $HospNo, "HospNo", "", "date", "desc");
		  if (count($ans2aQ21)>0) {
			  foreach ($ans2aQ21 as $k8=>$v8) {
				  if ($txt9!="") { $txt9 .= '、'; }
				  $txt9 .= $arr2aQ21[$v8];
				  if ($arr2aQ21[$v8]=="Other") { $txt9 .= "：".getTitle("nurseform02a", "Q22", $HospNo, "HospNo", ""); }
			  }
		  }
		  echo $txt9; 
		  ?>
          </td>
        </tr>
        <tr>
          <td class="title_s">入住前主要照顧者</td>
          <td colspan="3">
		  <?php
		  $arr2aQ19 = array("","None","Spouse","Son","Daughter in law","Daughter","Grandson","Relative","Friend","Personal aide","Other");
		  $ans2aQ19 = getGroupTitle("nurseform02a", "Q19", "_", 10, $HospNo, "HospNo", "", "date", "desc");
		  if (count($ans2aQ19)>0) {
			  foreach ($ans2aQ19 as $k9=>$v9) {
				  if ($txt10!="") { $txt10 .= '、'; }
				  $txt10 .= $arr2aQ19[$v9];
			  }
		  }
		  echo $txt10; 
		  ?>
          </td>
        </tr>
        <tr>
          <td class="title_s">Major medical decision maker</td>
          <td colspan="3">
		  <?php
		  $arr2aQ114 = array("","Oneself","Spouse","Offspring","Other");
		  $ans2aQ114 = getGroupTitle("nurseform02a", "Q114", "_", 4, $HospNo, "HospNo", "", "date", "desc");
		  if (count($ans2aQ114)>0) {
			  foreach ($ans2aQ114 as $k10=>$v10) {
				  if ($txt11!="") { $txt11 .= '、'; }
				  $txt11 .= $arr2aQ114[$v10];
			  }
		  }
		  echo $txt11; 
		  ?>
          </td>
        </tr>
        <tr>
          <td class="title_s">Special care project</td>
          <td colspan="3">
		  <?php
		  $arr2aQ115 = array("","化痰","Sputum suction","Nasogastric tube","Catheter","Wound dressing change","情緒不穩定");
		  $ans2aQ115 = getGroupTitle("nurseform02a", "Q115", "_", 6, $HospNo, "HospNo", "", "date", "desc");
		  if (count($ans2aQ115)>0) {
			  foreach ($ans2aQ115 as $k11=>$v11) {
				  if ($txt12!="") { $txt12 .= '、'; }
				  $txt12 .= $arr2aQ115[$v11];
			  }
		  }
		  echo $txt12; 
		  ?>
          </td>
        </tr>
        <tr>
          <td class="title_s">家屬交代項目</td>
          <td colspan="3">
		  <?php echo getTitle("nurseform02a", "Q108", $HospNo, "HospNo", ""); ?>
          </td>
        </tr>
      </table>
      </div>
      <div id="tabs2">
      <table width="100%">
        <tr>
          <td class="title_s" width="160">入住前居住狀況</td>
          <td>
		  <?php
		  $arr2aQ6 = array("","家中","Hospital","Other facility");
		  $ans2aQ6 = getGroupTitle("nurseform02a", "Q6", "_", 3, $HospNo, "HospNo", "", "date", "desc");
		  if (count($ans2aQ6)>0) {
			  foreach ($ans2aQ6 as $k12=>$v12) {
				  if ($txt13!="") { $txt13 .= '、'; }
				  $txt13 .= $arr2aQ6[$v12];
			  }
		  }
		  echo $txt13; 
		  ?>
          </td>
        </tr>
        <tr>
          <td class="title_s">Primary caregiver</td>
          <td><?php echo $txt10; ?></td>
        </tr>
        <tr>
          <td class="title_s">家屬交代項目</td>
          <td><?php echo getTitle("nurseform02a", "Q108", $HospNo, "HospNo", ""); ?></td>
        </tr>
        <tr>
          <td class="title_s">用物用品項目/Quantity</td>
          <td><?php echo getTitle("nurseform02a", "Q116", $HospNo, "HospNo", ""); ?></td>
        </tr>
      </table>
      </div>
      <div id="tabs3">
      <table width="100%">
        <tr>
          <td class="title_s" width="140">Education</td>
          <td>
		  <?php
		  $arr2aQ14 = array("","Illiterate","Unofficial school","Elementary school","Middle school","High school","University","Grad School","Other");
		  $ans2aQ14 = getGroupTitle("nurseform02a", "Q14", "_", 8, $HospNo, "HospNo", "", "date", "desc");
		  if (count($ans2aQ14)>0) {
			  foreach ($ans2aQ14 as $k13=>$v13) {
				  if ($txt14!="") { $txt14 .= '、'; }
				  $txt14 .= $arr2aQ14[$v13];
			  }
		  }
		  echo $txt14; 
		  ?>
          </td>
        </tr>
        <tr>
          <td class="title_s">Religion</td>
          <td>
		  <?php
		  $arr2aQ11 = array("","None","Buddhism","Taoism","Christian","Catholicism","Islam","Other");
		  $ans2aQ11 = getGroupTitle("nurseform02a", "Q11", "_", 7, $HospNo, "HospNo", "", "date", "desc");
		  if (count($ans2aQ11)>0) {
			  foreach ($ans2aQ11 as $k15=>$v15) {
				  if ($txt15!="") { $txt15 .= '、'; }
				  $txt15 .= $arr2aQ11[$v15];
			  }
		  }
		  echo $txt15; 
		  ?>
          </td>
        </tr>
        <tr>
          <td class="title_s">Marital status</td>
          <td>
		  <?php
		  $arr2aQ15 = array("","Married","Single","同居","離婚","寡(喪夫)","鰥(喪婦)","分居","Other");
		  $ans2aQ15 = getGroupTitle("nurseform02a", "Q15", "_", 8, $HospNo, "HospNo", "", "date", "desc");
		  if (count($ans2aQ15)>0) {
			  foreach ($ans2aQ15 as $k16=>$v16) {
				  if ($txt16!="") { $txt16 .= '、'; }
				  $txt16 .= $arr2aQ15[$v16];
			  }
		  }
		  echo $txt16; 
		  ?>
          </td>
        </tr>
        <tr>
          <td class="title_s">社會福利</td>
          <td>
          </td>
        </tr>
        <tr>
          <td class="title_s">入住前職業</td>
          <td>
		  <?php
		  $arr2aQ9 = array("","None","公","商","工","農","Other");
		  $ans2aQ9 = getGroupTitle("nurseform02a", "Q9", "_", 6, $HospNo, "HospNo", "", "date", "desc");
		  if (count($ans2aQ9)>0) {
			  foreach ($ans2aQ9 as $k17=>$v17) {
				  if ($txt17!="") { $txt17 .= '、'; }
				  $txt17 .= $arr2aQ9[$v17];
			  }
		  }
		  echo $txt17; 
		  ?>
          </td>
        </tr>
        <tr>
          <td class="title_s">入住前居住所</td>
          <td><?php echo $txt13; ?></td>
        </tr>
        <tr>
          <td class="title_s">吸菸史</td>
          <td>
		  <?php
		  $arr2bQ28 = array("","None","Yes");
		  $ans2bQ28 = getGroupTitle("nurseform02a", "Q28", "_", 2, $HospNo, "HospNo", "", "date", "desc");
		  if (count($ans2bQ28)>0) {
			  foreach ($ans2bQ28 as $k18=>$v18) {
				  if ($txt18!="") { $txt18 .= '、'; }
				  $txt18 .= $arr2bQ28[$v18];
			  }
		  }
		  if ($txt18=="") { $txt18 = "None"; }
		  if (count($ans2bQ28)>0 && in_array(2,$ans2bQ28)) {
			  $txt18 .= "：每日".getTitle("nurseform02a", "Q29", $HospNo, "HospNo", "", "date", "desc")."包，已抽".getTitle("nurseform02a", "Q30", $HospNo, "HospNo", "", "date", "desc")."年，已戒".getTitle("nurseform02a", "Q30quit", $HospNo, "HospNo", "", "date", "desc")."Year";
		  }
		  echo $txt18;
		  ?>
          </td>
        </tr>
        <tr>
          <td class="title_s">飲酒</td>
          <td>
		  <?php
		  $arr2aQ31 = array("","不喝","Occasionally","經常喝","每天喝");
		  $ans2aQ31 = getGroupTitle("nurseform02a", "Q31", "_", 4, $HospNo, "HospNo", "", "date", "desc");
		  if (count($ans2aQ31)>0) {
			  foreach ($ans2aQ31 as $k19=>$v19) {
				  if ($txt19!="") { $txt19 .= '、'; }
				  $txt19 .= $ans2aQ31[$v19];
			  }
		  }
		  if ($txt19=="") { $txt19 = "不喝"; }
		  echo $txt19;
		  ?>
          </td>
        </tr>
        <tr>
          <td class="title_s">Betel nut usage</td>
          <td>
		  <?php
		  $arr2aQ117 = array("","不嚼檳榔","偶爾嚼檳榔","經常嚼檳榔");
		  $ans2aQ117 = getGroupTitle("nurseform02a", "Q117", "_", 3, $HospNo, "HospNo", "", "date", "desc");
		  if (count($ans2aQ117)>0) {
			  foreach ($ans2aQ117 as $k20=>$v20) {
				  if ($txt20!="") { $txt20 .= '、'; }
				  $txt20 .= $ans2aQ117[$v20];
			  }
		  }
		  if ($txt20=="") { $txt20 = "不嚼檳榔"; }
		  if (count($ans2aQ117)>0 && in_array(2,$ans2aQ117)) { $txt20 .= "：".getTitle("nurseform02a", "Q117a", $HospNo, "HospNo", "", "date", "desc")."Pcs / day"; }
		  if (count($ans2aQ117)>0 && in_array(3,$ans2aQ117)) { $txt20 .= "：".getTitle("nurseform02a", "Q117a", $HospNo, "HospNo", "", "date", "desc")."Pcs / day"; }
		  echo $txt20;
		  ?>
          </td>
        </tr>
      </table>
      <script>
	  <?php $QFamilyTreeJPG = getTitle("socialform01", "QFamilyTreeJPG", $HospNo, "HospNo", "", "date", "desc"); ?>
	  $(function() {
		  $( "#tabs_familystructure" ).tabs(
		  <?php if ($QFamilyTreeJPG=="") { echo '{active:1}'; } ?>
		  );
	  }); </script>
	  <div id="tabs_familystructure">
		<ul class="printcol">
		  <li><a href="#fstabs-1">Upload image</a></li>
		  <li><a href="#fstabs-2">System image</a></li>
		</ul>
		<div id="fstabs-1">
        <h3>Family tree</h3>
		<?php
		if ($QFamilyTreeJPG!="") {
			echo '<img id="fsjpg" src="uploadfile/'.$_SESSION['nOrgID_lwj'].'/'.$HospNo.'/socialform01_pic/'.$QFamilyTreeJPG.'" border="0">';	  
		} else {
			echo '<img id="fsjpg" border="0" width="800" style="display:none;">';
		}?>
		</div>
		<div id="fstabs-2">
		<iframe src="module/nurseform/form1a_1.php?pid=<?php echo $_GET['pid']; ?>" width="100%" height="480" frameborder="0"></iframe>
		</div>
	  </div>
      </div>
    </div>
    </td>
  </tr>
</table>