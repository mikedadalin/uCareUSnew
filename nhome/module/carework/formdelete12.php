<?php
$db = new DB;
$db->query("SELECT `patientID`,`HospNo`,`Birth` FROM `patient` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."'");
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	$db1 = new DB;
	$db1->query("SELECT `indate` FROM `inpatientinfo` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."'");
	$r1 = $db1->fetch_assoc();
	$name = getPatientName($r['patientID']);
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
  <tr id="backtr" style="border:none; height:28px;">
    <td class="backbtnn" align="center" width="40" id="backbtn"  style="border:none;" rowspan="2"><a href="index.php?mod=socialwork&func=formview&pid=<?php echo mysql_escape_string($_GET['pid']); ?>&id=19">Go Back</a></td>
    <td class="title">Full Name</td>
    <td><?php echo $name; ?></td>
    <td class="title">DOB</td>
    <td><?php echo $birth.' ('.calcage(str_replace('/','',$birth)).')'; ?></td>
    <td class="title">Admission Date</td>
    <td><?php echo $indate; ?></td>
    <td class="title">Diagnosis</td>
    <td><?php echo $diagMsg; ?></td>
  </tr>
</table>
</div>

<?php
$db3 = new DB;
$db3->query("SELECT * FROM `careform12` WHERE `nID`='".mysql_escape_string($_GET['nID'])."'");
$r3 = $db3->fetch_assoc();
	foreach ($r3 as $k=>$v) {
		$arrAnswer = explode("_",$k);
		if (count($arrAnswer)==2) {
			if ($v==1) {
				${$arrAnswer[0]} .= $arrAnswer[1].';';
			}
		} else {
			${$k} = $v;
		}
	}

?>
<table border="0" style="text-align:left; padding-left:20px;">
  <tr>
    <td>
    <h3>Confirm deletion of this data?</h3>
    <div class="content-query">
    <table width="100%">
      <tr class="title">
        <td>Date</td>
        <td>主要問題</td>
        <td>Resident(家屬)期望</td>
        <td>照顧目標</td>
      </tr>
      <tr>
        <td><?php echo formatdate($date); ?></td>
        <td><?php echo checkbox_result("Q1","完全無法生活自理;部分無法生活自理;尚未適應機構生活;情緒經常不穩定;情緒有時不穩定;Other(s):".$Q1a."",$Q1,"multi"); ?></td>
        <td><?php echo checkbox_result("Q2","給予關心及安撫情緒;給予協助盡快適應機構生活;給予協助上廁所;依需求給予食用家屬帶來的食物;依需求給予使用家屬帶來的用品;Other(s):".$Q2a."",$Q2,"multi"); ?></td>
        <td><?php echo checkbox_result("Q3","完成協助生活起居;給予關心及安撫情緒;給予協助盡快適應機構生活;給予協助上廁所;依需求給予食用家屬帶來的食物;依需求給予使用家屬帶來的用品;完成家屬合理交代事項;給予訓練生活自理功能;安排完整的休閒娛樂活動;Other(s):".$Q3a."",$Q3,"multi"); ?></td>
      </tr>
    </table>
    </div>
    </td>
  </tr>
</table>
    <form action="index.php?func=databaseAI" method="post">
    <input type="hidden" id="formID" name="formID" value="careform12">
    <input type="hidden" id="nID" name="nID" value="<?php echo $_GET['nID']; ?>">
    <input type="hidden" id="action" name="action" value="delete">
    <input type="submit" value="Confirm deletation"> 
    </form>
    </div>
    </td>
  </tr>
</table>