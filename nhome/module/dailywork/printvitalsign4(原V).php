<?php
function array_kshift(&$arr) {
  list($k) = array_keys($arr);
  $r  = array($k=>$arr[$k]);
  unset($arr[$k]);
  return $r;
}

$db = new DB;
$db->query("SELECT * FROM `patient` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."'");
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	$db1 = new DB;
	$db1->query("SELECT * FROM `inpatientinfo` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."'");
	$r1 = $db1->fetch_assoc();
	/*== 解 START ==*/
	$LWJArray = array('Name1','Name2','Name3','Name4');
	$LWJdataArray = array($r['Name1'],$r['Name2'],$r['Name3'],$r['Name4']);
	for($i=0;$i<count($LWJdataArray);$i++){
	    $rsa = new lwj('lwj/lwj');
	    $puepart = explode(" ",$LWJdataArray[$i]);
	    $puepartcount = count($puepart);
	    if($puepartcount>1){
            for($j=0;$j<$puepartcount;$j++){
                $prdpart = $rsa->privDecrypt($puepart[$j]);
                $r[$LWJArray[$i]] = $r[$LWJArray[$i]].$prdpart;
            }
	    }else{
		   $r[$LWJArray[$i]] = $rsa->privDecrypt($LWJdataArray[$i]);
	    }
	}
	/*== 解 END ==*/
	if($r['Name2']!="" || $r['Name2']!=NULL){$r['Name2'] = " ".$r['Name2'];}
    if($r['Name3']!="" || $r['Name3']!=NULL){$r['Name3'] = " ".$r['Name3'];}
    if($r['Name4']!="" || $r['Name4']!=NULL){$r['Name4'] = " ".$r['Name4'];}
	$name = $r['Name1'].$r['Name2'].$r['Name3'].$r['Name4'];
	$birth = formatdate($r['Birth']);
	$indate = formatdate($r1['indate']);
	$db2 = new DB;
	$db2->query("SELECT `Qdiag1`, `Qdiag2`, `Qdiag3`, `Qdiag4`, `Qdiag5`, `Qdiag6`, `Qdiag7`, `Qdiag8` FROM `nurseform01` WHERE `HospNo`='".mysql_escape_string($r['HospNo'])."' ORDER BY `date` DESC LIMIT 0,1");
	$r2 = $db2->fetch_assoc();
	for ($j=1;$j<=8;$j++) { if ($r2['Qdiag'.$j]!=NULL) { $diagMsg .= $r2['Qdiag'.$j].', '; } }
	$diagMsg = substr($diagMsg, 0, strlen($diagMsg)-2);
}
foreach ($arrVital as $k=>$v) {
	${'arrVital'.$k} = array();
}
if (@$_GET['Date1']=="--Select month--") {
	$qdate = date(Y).'-'.date(m);
} else {
	$qdate = substr(@$_GET['date'],0,4).'-'.substr(@$_GET['date'],4,2);
}

if($_GET['Date1'] =="____/__/__" && $_GET['Date2'] =="____/__/__"){
}else{
	$strSQL = " AND DATE_FORMAT(`RecordedTime`,'%Y/%m/%d') >='".mysql_escape_string($_GET['date1'])."' AND DATE_FORMAT(`RecordedTime`,'%Y/%m/%d') <='".mysql_escape_string($_GET['date2'])."'";
}
switch ($_GET['code']){
	case 2 :
		$strSQL .=" AND ( `LoincCode`='8480-6' OR `LoincCode`='8462-4' OR `LoincCode`='8867-4' )";
		$VitalType = 2;
	break;
	case 3 :
		$strSQL .=" AND `LoincCode`='2710-2'";
		$VitalType = 3;
	break;
	case 4 :
		$strSQL .=" AND (`LoincCode`='15075-5' OR `LoincCode`='14743-9')";
		$VitalType = 4;
	break;
	case 5 :
		$strSQL .=" AND (`LoincCode`='8310-5' OR `LoincCode`='39106-0')";
		$VitalType = 5;
	break;
	case 6 :
		$strSQL .=" AND `LoincCode`='9279-1'";
		$VitalType = 6;
	break;
	case 7 :
		$strSQL .=" AND `LoincCode`='46033-7'";
		$VitalType = 7;		
	break;
	default:
		$strSQL .=" AND `LoincCode`!='18833-4'";
		$VitalType = 1;
	break;
}
	

$arrVital = array();

	if ($qDay<10) { $qDay = '0'.$qDay; }
$db = new DB;
$db->query("SELECT VitalSignID, DATE_FORMAT(`RecordedTime`,'%m/%d') as `mDay`, DATE_FORMAT(`RecordedTime`,'%H:%i') as `mTime`, `LoincCode`, `Value`, `Qfiller` FROM `vitalsigns` WHERE `PersonID`='".mysql_escape_string($_GET['pid'])."' ".$strSQL." AND `IsValid`='1' ORDER BY `RecordedTime` ASC");
if ($db->num_rows()==0) {
	$arrVital[$qDay.';'] = "";
} else {
	for ($i=0;$i<$db->num_rows();$i++) {
		$r = $db->fetch_assoc();
		$day = $r['mDay'];
		$time = $r['mTime'];
		$id = $r['VitalSignID'];
		$VitalName = 'arrVital'.$r['LoincCode'];
		$arrVital[$day.';'.$time.($VitalType!=1?';'.$id:"")][$r['LoincCode']] = $r['Value'];
		$arrVital[$day.';'.$time.($VitalType!=1?';'.$id:"")]['Qfiller'] = checkusername($r['Qfiller']);
	}
}
foreach ($arrVital as $k=>$v) {
	$count++;
}

$ItemNo = 33;

$pn = ceil($count/($ItemNo*2));
for ($i1=0;$i1<$pn;$i1++) {
	if ($i1>0) {
		echo '<p style="page-break-before:always;">&nbsp;</p><center><h3>'.$_SESSION['nOrgName_lwj'].'</h3></center>';
	}
?>
<div class="content-query">
<table border="1" style="border-collapse:collapse;" width="1050">
  <tr id="backtr"  style="border:none;" height="40">
    <?php if (@$_GET['id']!=NULL) { echo '<td align="center" bgcolor="#ffffff" width="40" id="backbtn"  style="border:none;"><a href="index.php?mod=nurseform&func=formview&pid='.mysql_escape_string($_GET['pid']).'"><img src="Images/back_button.png"></a></td>'; } ?>
    <td class="title" width="60" style="border:none;">Full name</td>
    <td width="80" style="border:none;"><?php echo $name; ?></td>
    <td class="title" width="60" style="border:none;">DOB</td>
    <td width="240" style="border:none;"><?php echo $birth.' ('.checkgender(mysql_escape_string($_GET['pid'])).', '.calcage(str_replace('/','',$birth)).')'; ?></td>
    <td class="title" width="80" style="border:none;">Admission date</td>
    <td style="border:none;"><?php echo $indate; ?></td>
  </tr>
</table>
</div>
<h3>Daily vital signs record- 
<?php
if (@$_GET['date']=="--Select month--") {
	echo date(Y).'/'.date(m);
} else {
	echo $_GET['date1'].'至'.$_GET['date2'];
}
?></h3>
<table border="0" cellpadding="0" cellspacing="0" style="border:0px;">
  <tr>
    <td valign="top">
      <table border="1" style="border-collapse:collapse; text-align:center;" width="525">
        <tr class="title" height="40">
          <td nowrap>Date</td>
          <td width="45" nowrap>Time</td>
        <?php 
			if($VitalType==1 || $VitalType==5){echo '<td  nowrap>Temperature</td>';};
			if($VitalType==1 || $VitalType==2){echo '<td  nowrap>Heartbeat/Pulse</td>';};
			if($VitalType==1 || $VitalType==6){echo '<td  nowrap>Respiration</td>';};
			if($VitalType==1){echo '<td nowrap>Blood pressure</td>';};
			if($VitalType==2){echo '<td nowrap>Systolic BP</td>';};
			if($VitalType==2){echo '<td nowrap>Diastolic BP</td>';};
			if($VitalType==1 || $VitalType==3){echo '<td nowrap>SpO2</td>';};
			if($VitalType==1 || $VitalType==7){echo '<td nowrap>Pain</td>';};
			if($VitalType==1 || $VitalType==4){echo '<td  nowrap>AC<br />Blood glucose</td>';};
			if($VitalType==1 || $VitalType==4){echo '<td  nowrap>PC<br />Blood glucose</td>';};
		?>  
          <td width="60" nowrap>Signature</td>
        </tr>
        <?php
		$countno = 0;
		while($countno<$ItemNo) {
			$arr1 = array_kshift($arrVital);
			foreach ($arr1 as $ka=>$va) {
				$arrDate = explode(";",$ka);
				echo '
		<tr height="40">
          <td nowrap>'.$arrDate[0].'</td>
          <td nowrap>'.$arrDate[1].'</td>';
			if($VitalType==1 || $VitalType==5){echo '<td nowrap>'.$va['8310-5'].'</td>';};
			if($VitalType==1 || $VitalType==2){echo '<td nowrap>'.$va['8867-4'].'</td>';};
			if($VitalType==1 || $VitalType==6){echo '<td nowrap>'.$va['9279-1'].'</td>';};
			if($VitalType==1){echo '<td nowrap>'.$va['8480-6'].'/'.$va['8462-4'].'</td>';};
			if($VitalType==2){echo '<td nowrap>'.$va['8480-6'].'</td>';};
			if($VitalType==2){echo '<td nowrap>'.$va['8462-4'].'</td>';};
			if($VitalType==1 || $VitalType==3){echo '<td nowrap>'.$va['2710-2'].'</td>';};
			if($VitalType==1 || $VitalType==7){echo '<td nowrap>'.$va['46033-7'].'</td>';};
			if($VitalType==1 || $VitalType==4){echo '<td nowrap>'.$va['14743-9'].'</td>';};
			if($VitalType==1 || $VitalType==4){echo '<td nowrap>'.$va['15075-5'].'</td>';};
          echo '<td nowrap><font size="2" color="#CCC">'.$va['Qfiller'].'</font></td>
        </tr>
				'."\n";
			}
			$countno++;
		}
		?>
        </table>
    </td>
    <td valign="top" >
      <table border="1" style="border-collapse:collapse; text-align:center;" width="525" >
        <tr class="title" height="40">
          <td nowrap>Date</td>
          <td width="45" nowrap>Time</td>
        <?php 
			if($VitalType==1 || $VitalType==5){echo '<td  nowrap>Temperature</td>';};
			if($VitalType==1 || $VitalType==2){echo '<td  nowrap>Heartbeat/Pulse</td>';};
			if($VitalType==1 || $VitalType==6){echo '<td  nowrap>Respiration</td>';};
			if($VitalType==1){echo '<td nowrap>Blood pressure</td>';};
			if($VitalType==2){echo '<td nowrap>Systolic BP</td>';};
			if($VitalType==2){echo '<td nowrap>Diastolic BP</td>';};
			if($VitalType==1 || $VitalType==3){echo '<td nowrap>SpO2</td>';};
			if($VitalType==1 || $VitalType==7){echo '<td nowrap>Pain</td>';};
			if($VitalType==1 || $VitalType==4){echo '<td  nowrap>AC<br />Blood glucose</td>';};
			if($VitalType==1 || $VitalType==4){echo '<td  nowrap>PC<br />Blood glucose</td>';};
		?>  
          <td width="60" nowrap>Signature</td>
        </tr>
        <?php
		while($countno<($ItemNo*2)) {
			$arr1 = array_kshift($arrVital);
			foreach ($arr1 as $ka=>$va) {
				$arrDate = explode(";",$ka);
				echo '
		<tr height="40">
          <td nowrap>'.$arrDate[0].'</td>
          <td nowrap>'.$arrDate[1].'</td>';
			if($VitalType==1 || $VitalType==5){echo '<td nowrap>'.$va['8310-5'].'</td>';};
			if($VitalType==1 || $VitalType==2){echo '<td nowrap>'.$va['8867-4'].'</td>';};
			if($VitalType==1 || $VitalType==6){echo '<td nowrap>'.$va['9279-1'].'</td>';};
			if($VitalType==1){echo '<td nowrap>'.$va['8480-6'].'/'.$va['8462-4'].'</td>';};
			if($VitalType==2){echo '<td nowrap>'.$va['8480-6'].'</td>';};
			if($VitalType==2){echo '<td nowrap>'.$va['8462-4'].'</td>';};
			if($VitalType==1 || $VitalType==3){echo '<td nowrap>'.$va['2710-2'].'</td>';};
			if($VitalType==1 || $VitalType==7){echo '<td nowrap>'.$va['46033-7'].'</td>';};
			if($VitalType==1 || $VitalType==4){echo '<td nowrap>'.$va['14743-9'].'</td>';};
			if($VitalType==1 || $VitalType==4){echo '<td nowrap>'.$va['15075-5'].'</td>';};
          echo '<td nowrap><font size="2" color="#CCC">'.$va['Qfiller'].'</font></td>
        </tr>
				'."\n";
			}
			$countno++;
		}
		?>
        </table>
    </td>
  </tr>
</table>
<?php
}
?>