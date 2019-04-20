<style type="text/css">
@media print {
	.cPrintOnly { 
		page-break-before: always; 
		display: none;
	}
}
</style>
<?php
$_GET['qdate'] = ($_GET['qdate']==""?date(Ym):$_GET['qdate']);
$type = ($_GET['type']==""?'1':$_GET['type']);

$url = $_SERVER['PHP_SELF'];
$arrURL = explode("/",$url); //$arrURL[3] = index.php / print.php

$arrPatList = array();

if ($_GET['qdate']=="") {
	$sql = "SELECT a.`patientID` FROM `inpatientinfo` a INNER JOIN `patient` b ON a.`patientID`=b.`patientID` WHERE b.`type`='".$type."'";
} else {
	$sql = "SELECT a.`patientID` FROM `inpatientinfo` a INNER JOIN `patient` b ON a.`patientID`=b.`patientID` WHERE LEFT(a.`indate`,6)<='".mysql_escape_string($_GET['qdate'])."' AND b.`type`='".$type."'";
	$db1b = new DB;
	$db1b->query("SELECT `patientID` FROM `closedcase` a INNER JOIN `patient` b ON a.`patientID`=b.`patientID` WHERE LEFT(a.`outdate`,6) >= '".mysql_escape_string($_GET['qdate'])."' AND LEFT(a.`indate`,6) <= '".mysql_escape_string($_GET['qdate'])."' AND b.`type`='".$type."'");
	for ($i1b=0;$i1b<$db1b->num_rows();$i1b++) {
		$r1b = $db1b->fetch_assoc();
		if ($r1b['patientID']!="") {
			array_push($arrPatList, $r1b['patientID']);
		}
	}
}

$db1a = new DB;
$db1a->query($sql);
for ($i1a=0;$i1a<$db1a->num_rows();$i1a++) {
	$r1a = $db1a->fetch_assoc();
	if ($r1a['patientID']!="") {
		if (!in_array($r1a['patientID'], $arrPatList)) {
			array_push($arrPatList, $r1a['patientID']);
		}
	}
}
?>
<!--
<div class="printcol" style="position: absolute; top: 2%; right: 2%;">
    <div class="patlistbtn" style="background-color:rgba(200,200,200,1); border: none;"><a href="print.php?func=printPatStat" target="_blank"><i class="fa fa-print fa-2x"></i><br>Print</a></div>
</div>
-->

<div style="background-color:rgba(255,255,255,0.9); border-radius:10px; padding:15px 15px 20px 15px; margin-bottom:30px;">

<div align="center"><h3 style="color:#69b3b6; font-size:22px; margin-bottom:30px; background-color: rgba(255,255,255,0.8); border-radius: 10px; width: 100%; padding: 13px 0px; letter-spacing:1px;"><?php echo substr($_GET['qdate'],0,4).' Year '.substr($_GET['qdate'],4,2).'th Month '; ?>Residents name list</h3></div>
<div align="left" class="printcol">
<form>
<select id="seltype">
  <option>--Select resident type--</option>
  <option value="1" <?php echo ($type==1?"selected":""); ?>>General admission</option>
  <option value="2" <?php echo ($type==2?"selected":""); ?>>Swing bed</option>
  <option value="3" <?php echo ($type==3?"selected":""); ?>>Respite care</option>
  <option value="4" <?php echo ($type==4?"selected":""); ?>>Public funded care</option>
  <option value="5" <?php echo ($type==5?"selected":""); ?>>Urgent care</option>
</select>
<select id="selmonth">
  <option>--Select month--</option>
  <?php
  for ($i=date(m);$i>=(date(m)-12);$i--) {
      $month = $i;
      $year = date(Y);
      if ($i<1) {
          $month = 12+$i;
          $year = date(Y)-1;
      }
      if (strlen($month)==1) {
          $month = "0".$month;
      }
      echo '<option value="'.$year.$month.'"';
	  if ($_GET['qdate']==$year.$month) { echo " selected"; }
	  echo '>'.$year.'-'.$month.'</option>'."\n";
  }
  ?>
</select>
<input type="button" value="Search" onclick="actionPatStat('v');">
<input type="button" value="Print" onclick="actionPatStat('p');">
<script>
function actionPatStat(action) {
	var selectedType = document.getElementById('seltype').value;
	var selectedMonth = document.getElementById('selmonth').value;
	if (action=='p') {
		window.open('print.php?func=printPatStat&type='+selectedType+'&qdate='+selectedMonth, '_blank' );
	} else if (action=='v') {
		window.location.href='index.php?func=printPatStat&type='+selectedType+'&qdate='+selectedMonth;
	}
}
</script>
</form>
</div>
<table width="100%" id="form21table">
  <thead>
  <tr class="title">
    <th nowrap="nowrap">No.</th>
    <th nowrap="nowrap">Resident name</th>
    <th nowrap="nowrap">Gender</th>
    <th nowrap="nowrap">DOB</th>
    <th nowrap="nowrap">Age</th>
    <th nowrap="nowrap">Social Security number</th>
    <th nowrap="nowrap">Disability category</th>
    <th nowrap="nowrap">Admission category</th>
  </tr>
  </thead>
<?php
    foreach ($arrPatList as $k2=>$v2) {
        //$v1 區域ID
        //$v2 PID
		$count++;
        $pInfo = getPatientInfo($v2);
		/*== 解 START ==*/
		$LWJArray = array('Name1','Name2','Name3','Name4','IdNo');
		$LWJdataArray = array($pInfo['Name1'],$pInfo['Name2'],$pInfo['Name3'],$pInfo['Name4'],$pInfo['IdNo']);
		for($n=0;$n<count($LWJdataArray);$n++){
			$rsa = new lwj('lwj/lwj');
			$puepart = explode(" ",$LWJdataArray[$n]);
			$puepartcount = count($puepart);
			if($puepartcount>1){
				for($m=0;$m<$puepartcount;$m++){
					$prdpart = $rsa->privDecrypt($puepart[$m]);
					$pInfo[$LWJArray[$n]] = $pInfo[$LWJArray[$n]].$prdpart;
				}
			}else{
				$pInfo[$LWJArray[$n]] = $rsa->privDecrypt($LWJdataArray[$n]);
			}
		}
		/*== 解 END ==*/
        if($pInfo['Name2']!="" || $pInfo['Name2']!=NULL){$pInfo['Name2'] = " ".$pInfo['Name2'];}
        if($pInfo['Name3']!="" || $pInfo['Name3']!=NULL){$pInfo['Name3'] = " ".$pInfo['Name3'];}
        if($pInfo['Name4']!="" || $pInfo['Name4']!=NULL){$pInfo['Name4'] = " ".$pInfo['Name4'];}
        $pInfo['Name'] = $pInfo['Name1'].$pInfo['Name2'].$pInfo['Name3'].$pInfo['Name4'];
		$db1a = new DB;
		$db1a->query("SELECT * FROM `nurseform01` WHERE `HospNo`='".getHospNo($v2)."' ORDER BY `date` DESC LIMIT 0,1");
		$r1a = $db1a->fetch_assoc();
		$QdisableTypeA = "";
		$QdisableTypeB = "";
		$QillnessType = "";
		if ($db1a->num_rows()>0) {
			foreach ($r1a as $k1a=>$v1a) {
				$arrPatientInfo = explode("_",$k1a);
				if (count($arrPatientInfo)==2) {
					if ($v1a==1) { ${$arrPatientInfo[0]} .= $arrPatientInfo[1].';'; }
				} else {
					${$k1a} = $v1a;
				}
			}
		}
        echo '
  <tr style="page-break-after:auto;">
    <td nowrap="nowrap">'.$count.'</td>
    <td nowrap="nowrap">'.$pInfo['Name'].'</td>
    <td nowrap="nowrap">'.checkgender($v2).'</td>
    <td nowrap="nowrap">'.formatdate($pInfo['Birth'], 2).'</td>
    <td nowrap="nowrap">'.calcagenum($pInfo['Birth']).'</td>
    <td nowrap="nowrap">'.$pInfo['IdNo'].'</td>
	<td>';
	//殘障手冊
	if ($QdisableTypeA==9) { echo "智能障礙"; } 
	elseif ($QdisableTypeA==10) { echo "vegetative being"; } 
	elseif ($QdisableTypeA==11) { echo "Dementia"; } 
	elseif ($QdisableTypeA==12) { echo "自閉症者"; } 
	elseif ($QdisableTypeA==13) { echo "慢性精神病"; } 
	elseif ($QdisableTypeA==14) { echo "頑性（難治型）癲癇症"; } 
	elseif ($QdisableTypeA==15) { echo "視覺障礙"; } 
	elseif ($QdisableTypeA==16) { echo "聽覺機能障礙"; } 
	elseif ($QdisableTypeA==17) { echo "平衡機能障礙"; } 
	elseif ($QdisableTypeA==18) { echo "聲音機能或語言機能障礙"; } 
	elseif ($QdisableTypeA==19) { echo "重要器官失去功能-心臟"; } 
	elseif ($QdisableTypeA==20) { echo "重要器官失去功能-造血機能"; } 
	elseif ($QdisableTypeA==21) { echo "重要器官失去功能-呼吸器官"; } 
	elseif ($QdisableTypeA==22) { echo "重要器官失去功能-吞嚥機能"; } 
	elseif ($QdisableTypeA==23) { echo "重要器官失去功能-胃"; } 
	elseif ($QdisableTypeA==24) { echo "重要器官失去功能-腸道"; } 
	elseif ($QdisableTypeA==25) { echo "重要器官失去功能-肝臟"; } 
	elseif ($QdisableTypeA==26) { echo "重要器官失去功能-腎臟"; } 
	elseif ($QdisableTypeA==27) { echo "重要器官失去功能-膀胱"; } 
	elseif ($QdisableTypeA==28) { echo "Physical disabilities"; } 
	elseif ($QdisableTypeA==29) { echo "顏面損傷"; } 
	elseif ($QdisableTypeA==30) { echo "多重障礙"; } 
	elseif ($QdisableTypeA==31) { echo "經中央衛生主管機關認定，因罕見疾病而致身心功能障礙者"; } 
	elseif ($QdisableTypeA==32) { echo "其他經中央衛生主管機關認定之障礙者(染色體異常、先天代謝異常、先天缺陷)"; }
	//$id, $text, $size, $multi, $pre, $br, $brn
	echo option_result("QdisableTypeB","None;Class 1: Nervous system, structural impaired or mentally challenged;Class 2: Eye, ear or related sensors structural impair;Class 3 : Voicing or structure related to speech dysfunction;Class 4 : Circulation, hematopoiesis or immune system dysfunction;Class 5 : Digestion, metabolism and endocrine system dysfunction;Class 6 : Urinary and reproductive system dysfunction;Class 7 : Nuron, muscles and bone motion dysfunction;Class 8 : Skin and related structure dysfunction","m","multi",$QdisableTypeB,false,1,2);
	echo '
	</td>
	<td nowrap="nowrap">';
	echo option_result("QillnessType","General;Veteran;Middle-low income;Low-income;Other","m","multi",$QillnessType,false,5,2);
	echo '</td>
  </tr>
        '."\n";
		if ($arrURL[3]=='print.php' && $count%36==0) {
			echo '
</table>
<p style="page-break-after:always;">&nbsp;</p>
<center><h3>'.$_SESSION['nOrgName_lwj'].'</h3></center>
<div align="left"><h3>'.substr($_GET['qdate'],0,4).'Year '.substr($_GET['qdate'],4,2).'th Month '.'Residents name list</h3></div>
<table width="100%">
  <thead>
  <tr class="title">
    <th nowrap="nowrap">No.</th>
    <th nowrap="nowrap">Resident name</th>
    <th nowrap="nowrap">Gender</th>
    <th nowrap="nowrap">DOB</th>
    <th nowrap="nowrap">Age</th>
    <th nowrap="nowrap">Social Security number</th>
    <th nowrap="nowrap">Disability category</th>
    <th nowrap="nowrap">Admission category</th>
  </tr>
  </thead>
			'."\n";
		}
}
?>
</table>

</div>


<script>
<?php
if ($arrURL[3]=="index.php") {
?>
$('#form21table').dataTable({
	"paging": false
});
<?php
} else {
?>
$(function() {
	window.print();
});
<?php
}
?>
</script>