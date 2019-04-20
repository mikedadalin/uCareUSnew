<?php
$arrAreaList = array();
$arrAreaPatientList = array();
$db = new DB;
$db->query("SELECT * FROM `areainfo`");
for ($i1=0;$i1<$db->num_rows();$i1++) {
	$r = $db->fetch_assoc();
	$db1a = new DB;
	$db1a->query("SELECT * FROM `bedinfo` WHERE `Area`='".$r['areaID']."'");
	array_push($arrAreaList, $r['areaID']);
	$arrAreaPatientList[$r['areaID']] = array();
	for ($i2=0;$i2<$db1a->num_rows();$i2++) {
		$r1a = $db1a->fetch_assoc();
		$db1b = new DB;
		$db1b->query("SELECT `patientID` FROM `inpatientinfo` WHERE `bed`='".$r1a['bedID']."'");
		$r1b = $db1b->fetch_assoc();
		if ($r1b['patientID']!="") {
			array_push($arrAreaPatientList[$r['areaID']], $r1b['patientID']);
		}
	}
}

foreach ($arrAreaList as $k1=>$v1) {
	$AreaPatientList = $arrAreaPatientList[$v1];
	foreach ($AreaPatientList as $k2=>$v2) {
		$db2a = new DB;
		$db2a->query("SELECT * FROM `nurseform02c` WHERE `HospNo`='".getHospNo($v2)."' ORDER BY `date` DESC LIMIT 0,1");
		$db2b = new DB;
		$db2b->query("SELECT * FROM `nurseform02h` WHERE `HospNo`='".getHospNo($v2)."' ORDER BY `date` DESC LIMIT 0,1");
		$db2c = new DB;
		$db2c->query("SELECT * FROM `nurseform02m` WHERE `HospNo`='".getHospNo($v2)."' ORDER BY `date` DESC LIMIT 0,1");
		$r2a="";
		$r2b="";
		$r2c="";
		if ($db2a->num_rows()>0) {
			$r2a = $db2a->fetch_assoc();
			$count1[$v1]++;
			$arrADLscore[$v1] += $r2a['Qtotal'];
		}else{
			$r2a['Qtotal']="";
		}
		if ($db2b->num_rows()>0) {
			$r2b = $db2b->fetch_assoc();
			$count2[$v1]++;
			$arrMMSEscore[$v1] += $r2b['Q32'];
		}else{
			$r2b['Q32']="";
		}
		if ($db2c->num_rows()>0) {
			$r2c = $db2c->fetch_assoc();
			$count3[$v1]++;
			$arrIADLscore[$v1] += $r2c['Qtotal'];
		}else{
			$r2c['Qtotal']="";
		}
		$arrScores[$v2] = array("IADL"=>$r2c['Qtotal'], "MMSE"=>$r2b['Q32'], "BI"=>$r2a['Qtotal']);
	}
	if ($count1[$v1]!="") {
		$arrAvgADLScore[$v1] = round($arrADLscore[$v1]/$count1[$v1],1);
	}
	if ($count2[$v1]!="") {
		$arrAvgMMSEScore[$v1] = round($arrMMSEscore[$v1]/$count2[$v1],1);
	}
	if ($count3[$v1]!="") {
		$arrAvgIADLScore[$v1] = round($arrIADLscore[$v1]/$count3[$v1],1);
	}
}

?>
<div id="form21-tab">
	<ul class="printcol">
       <li><a href="#form21-tab1">Statistical charts</a></li>
       <li><a href="#form21-tab2">Resident list</a></li>
   </ul>
   <div id="form21-tab1">
    <h3>Resident ADL, IADL, MMSE chart</h3>
    <div class="patlistbtnlist printcol" style="background-color:rgba(255,255,255,0);">
        <div class="patlistbtn" style="background-color:rgba(0,0,0,0.5);"><a href="print.php?mod=management&func=formview&id=21&view=0" target="_blank"><i class="fa fa-print fa-2x"></i><br>Print</a></div>
    </div>
    <style>
    #adlchart table {
        width: auto;
    }
    #adlchart table tr {
        background:none;
    }
    </style>
    <br />
    <center><div id="adlchart" style="width:900px;height:400px;"></div></center>
    <br /><br />
    <table style="width:100%">
      <tr class="title">
        <td>Item(s)</td>
        <?php
        foreach ($arrAreaList as $k1=>$v1) {
            $db3a = new DB;
            $db3a->query("SELECT * FROM `areainfo` WHERE `areaID`='".$v1."'");
            $r3a = $db3a->fetch_assoc();
            $AreaLabel .= "[".$k1.",'".$r3a['areaName']."'],"; 
            echo '<td>'.$r3a['areaName'].'</td>';
            $ADLscore = $arrAvgADLScore[$v1];
            if ($ADLscore == "") { $ADLscore = 0; }
            $ADLchart .= "[".$k1.",".$ADLscore."],";
            
            $MMSEscore = $arrAvgMMSEScore[$v1];
            if ($MMSEscore == "") { $MMSEscore = 0; }
            $MMSEchart .= "[".$k1.",".$MMSEscore."],";
            
            $IADLscore = $arrAvgIADLScore[$v1];
            if ($IADLscore == "") { $IADLscore = 0; }
            $IADLchart .= "[".$k1.",".$IADLscore."],";
        }
        $ADLchart=substr($ADLchart,0,strlen($ADLchart)-1);
        $ADLchart = '['.$ADLchart.']';
        $MMSEchart=substr($MMSEchart,0,strlen($MMSEchart)-1);
        $MMSEchart = '['.$MMSEchart.']';
        $IADLchart=substr($IADLchart,0,strlen($IADLchart)-1);
        $IADLchart = '['.$IADLchart.']';
        $AreaLabel=substr($AreaLabel,0,strlen($AreaLabel)-1);
        $AreaLabel = '['.$AreaLabel.']';
        ?>
    </tr>
    <tr>
        <td class="title_s">ADL</td>
        <?php
        foreach ($arrAreaList as $k1=>$v1) {
            echo '<td><center>'.$arrAvgADLScore[$v1].'</center></td>';
        }
        ?>
    </tr>
    <tr>
        <td class="title_s">MMSE</td>
        <?php
        foreach ($arrAreaList as $k1=>$v1) {
            echo '<td><center>'.$arrAvgMMSEScore[$v1].'</center></td>';
        }
        ?>
    </tr>
    <tr>
        <td class="title_s">IADL</td>
        <?php
        foreach ($arrAreaList as $k1=>$v1) {
            echo '<td><center>'.$arrAvgIADLScore[$v1].'</center></td>';
        }
        ?>
    </tr>
</table>
<br />

<script type="text/javascript">
$(document).ready(function () {
    var data = [
    { label: "ADL", data: <?php echo $ADLchart; ?>, bars: {fillColor: "#89A54E"}, color: "#89A54E" },
    { label: "MMSE", data: <?php echo $MMSEchart; ?>, bars: {fillColor: "#4572A7"}, color: "#4572A7" },
    { label: "IADL", data: <?php echo $IADLchart; ?>, bars: {fillColor: "#FF9900"}, color: "#FF9900" }];
    var options = {
        xaxis: { mode: null, ticks: <?php echo $AreaLabel; ?>, tickLength: 0, axisLabel: "Floor/area", axisLabelUseCanvas: true, axisLabelFontSizePixels: 12, axisLabelFontFamily: "Verdana, Arial, Helvetica, Tahoma, sans-serif", axisLabelPadding: 5},
        yaxis: { axisLabel: "No of builds", tickDecimals: 0, axisLabelUseCanvas: true, axisLabelFontSizePixels: 12, axisLabelFontFamily: "Verdana, Arial, Helvetica, Tahoma, sans-serif", axisLabelPadding: 5},
        grid: { hoverable: true, clickable: false, borderWidth: 1 },
            //legend: { labelBoxBorderColor: "none", position: "right" },
            series: { shadowSize: 0, bars: { show: true, barWidth: 0.25, order: 1 } }
        };
        
        $.plot($("#adlchart"), data, options);
        
    });
</script>
</div>
<div id="form21-tab2">
    <h3><?php echo date(Y).' Year'.date(m).' Month'; ?> Resident list of ADL, IADL, MMSE and Barthel index</h3>
    <div class="patlistbtnlist printcol" style="background-color:rgba(255,255,255,0);">
        <div class="patlistbtn" style="background-color:rgba(0,0,0,0.5);"><a href="print.php?mod=management&func=formview&id=21&view=1" target="_blank"><i class="fa fa-print fa-2x"></i><br>Print</a></div>
    </div>
    <table style="width:100%;" id="form21table">
      <thead>
          <tr class="title">
            <td>Resident name</td>
            <td>Gender</td>
            <td>DOB</td>
            <td>Age</td>
            <td>Social Security Number</td>
            <td>IADL</td>
            <td>MMSE</td>
            <td>Barthel Index</td>
        </tr>
    </thead>
    <?php
    foreach ($arrAreaList as $k1=>$v1) {
     $AreaPatientList = $arrAreaPatientList[$v1];
     foreach ($AreaPatientList as $k2=>$v2) {
				//$v1 區域ID
				//$v2 PID
        $pInfo = getPatientInfo($v2);
        /*== 解 START ==*/
        $LWJArray = array('Name1','Name2','Name3','Name4','IdNo','MedicalRecordNumber','Nickname','MedicareNumber','MedicaidNumber','Postcode','Address','Address2','Address3','Address4','Address5');
        $LWJdataArray = array($pInfo['Name1'],$pInfo['Name2'],$pInfo['Name3'],$pInfo['Name4'],$pInfo['IdNo'],$pInfo['MedicalRecordNumber'],$pInfo['Nickname'],$pInfo['MedicareNumber'],$pInfo['MedicaidNumber'],$pInfo['Postcode'],$pInfo['Address'],$pInfo['Address2'],$pInfo['Address3'],$pInfo['Address4'],$pInfo['Address5']);
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
echo '
<tr>
<td align="center">'.$pInfo['Name'].'</td>
<td align="center">'.checkgender($v2).'</td>
<td align="center" style="padding:5px;">'.formatdate($pInfo['Birth']).'</td>
<td align="center" style="padding:5px;">'.calcagenum($pInfo['Birth']).'</td>
<td align="center">'.$pInfo['IdNo'].'</td>
<td align="center">'.$arrScores[$v2]['IADL'].'</td>
<td align="center">'.$arrScores[$v2]['MMSE'].'</td>
<td align="center">'.$arrScores[$v2]['BI'].'</td>
</tr>
'."\n";
}
}
?>
</table>
</div>
</div><br>
<?php if ($_GET['view']=="") { $view = 0; } else { $view = $_GET['view']; } ?>
<script>
$(function() {
	//$('#form21table').DataTable();
	$('#form21-tab').tabs({
		active: <?php echo $view; ?>
	});
});
</script>