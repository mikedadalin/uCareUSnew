<?php
$db = new DB;
$db->query("SELECT * FROM `patient` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."'");
for ($i=0;$i<$db->num_rows();$i++) {
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
	/*== 解 START ==*/
	$LWJArray = array('Name1','Name2','Name3','Name4','IdNo');
	$LWJdataArray = array($Name1,$Name2,$Name3,$Name4,$IdNo);
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
	$db1 = new DB;
	$db1->query("SELECT `indate` FROM `inpatientinfo` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."'");
	$r1 = $db1->fetch_assoc();
	if($Name2!="" || $Name!=NULL){$Name2 = " ".$Name2;}
    if($Name3!="" || $Name3!=NULL){$Name3 = " ".$Name3;}
    if($Name4!="" || $Name4!=NULL){$Name4 = " ".$Name4;}
	$name = $Name1.$Name2.$Name3.$Name4;
	$birth = formatdate($r['Birth']);
	$indate = formatdate($r1['indate']);
	$db2 = new DB;
	$db2->query("SELECT `Qdiag1`, `Qdiag2`, `Qdiag3`, `Qdiag4` FROM `nurseform01` WHERE `HospNo`='".mysql_escape_string($r['HospNo'])."' ORDER BY `date` DESC LIMIT 0,1");
	$r2 = $db2->fetch_assoc();
	for ($j=1;$j<=4;$j++) { if ($r2['Qdiag'.$j]!=NULL) { $diagMsg .= $r2['Qdiag'.$j].', '; } }
	$diagMsg = substr($diagMsg, 0, strlen($diagMsg)-2);
}
?>
<div class="content-query">
<table align="center">
  <tr>
    <?php if (@$_GET['id']!=NULL) { echo '<td align="center" bgcolor="#ffffff"><a href="index.php?mod=nurseform&func=formview&pid='.mysql_escape_string($_GET['pid']).'&id=3"><img src="Images/back_button.png"></a></td>'; } ?>
    <td class="title">Full name</td>
    <td><?php echo $name; ?></td>
    <td class="title">DOB</td>
    <td><?php echo $birth.' ('.calcage(str_replace('/','',$birth)).')'; ?></td>
    <td class="title">Admission date</td>
    <td><?php echo $indate; ?></td>
    <td class="title">Diagnosis</td>
    <td><?php echo $diagMsg; ?></td>
  </tr>
</table>
</div>
<table border="0" style="text-align:left; padding-left:20px;">
  <tr>
    <td>
    <h3>Confirm deletion of this data?</h3>
    <?php
	$db3 = new DB;
	$db3->query("SELECT * FROM `nursediag".@$_GET['id']."` WHERE `HospNo`='".$r['HospNo']."' AND `date`='".mysql_escape_string($_GET['date'])."'");
	$r3 = $db3->fetch_assoc();
	?>
    <div class="content-query">
    <table width="100%">
      <tr class="title">
        <td>Nursing diagnosis</td>
        <td>Start date</td>
        <td>Staff</td>
        <td>停止日期</td>
        <td>Staff</td>
      </tr>
      <tr>
        <td><?php echo @$_GET['id']; ?># <?php echo $arrNursediag[(int) @$_GET['id']]; ?></td>
        <td><?php echo $r3['Q1']; ?></td>
        <td><?php echo checkusername($r3['Qrater_start']); ?></td>
        <td><?php echo $r3['Q2']; ?></td>
        <td><?php echo checkusername($r3['Qrater_end']); ?></td>
      </tr>
    </table>
    <form action="index.php?func=database&action=delete" method="post">
    <input type="hidden" id="formID" name="formID" value="nursediag<?php echo @$_GET['id']; ?>">
    <input type="hidden" id="HospNo" name="HospNo" value="<?php echo $r['HospNo']; ?>">
    <input type="hidden" id="date" name="date" value="<?php echo $r3['date']; ?>">
    <input type="submit" value="Confirm deletation"> 
    </form>
    </div>
    </td>
  </tr>
</table>