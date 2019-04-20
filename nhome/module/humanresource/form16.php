<h3>員工請假單</h3>
<div align="right">
<?php
	if ($_GET['EmpID']!="") {
		$EmpID = (int) @$_GET['EmpID'];
	} else {
		if(getTitle("employer","EmpID",$_SESSION['ncareID_lwj'],"account","")==""){
			$EmpID = getTitle("foreignemployer","forefignID",$_SESSION['ncareID_lwj'],"account","");
			$EmpGroup = 2;
		}else{
			$EmpID = getTitle("employer","EmpID",$_SESSION['ncareID_lwj'],"account","");
			$EmpGroup = 1;
		}
	}
	
	//Profile
	if($EmpGroup==1){
		$strSQL = "SELECT * FROM `employer` WHERE `EmpID`='".$EmpID."' ORDER BY `EmpID` ASC";
	}else{
		$strSQL = "SELECT * FROM `foreignemployer` WHERE `foreignID`='".$EmpID."' ORDER BY `foreignID` ASC";
	}
	$db5a = new DB;
	$db5a->query($strSQL);
	$r5a = $db5a->fetch_assoc();
	if($EmpGroup==1){
		$Name = $r5a['Name'];
		$position = $r5a['Position'];
	}else{
		$Name = $r5a['eNickname'].$r5a['cNickname'];
		$position = $r5a['position'];
	}
	$strSQL = "WHERE `EmpID`='".$EmpID."' AND EmpGroup='".$EmpGroup."'";	
$arrstatus = array("Pending","Reviewing","Approved","Canceled");
?>
<form>
<input type="button" value="新增假單" onclick="window.location.href='index.php?mod=humanresource&func=formview&id=16_1&EmpID=<?php echo $EmpID; ?>&EmpGroup=<?php echo $EmpGroup;?>'" />
</form>
</div>
<div class="content-table">
<table id="table16" width="960">
<thead>
<tr class="title">
  <th>Function</th>
  <th>Date of requisition</th>
  <th>Job title</th>
  <th>Full name</th>
  <th>Off date</th>
  <th>Absent category</th>
  <th>Day(s)</th>
  <th>Approval Status</th>
  <th>代理人員</th>
</tr>
</thead>
<?php
$sql1 = "SELECT * FROM `humanresource16` ".$strSQL." ";
$db = new DB;
$db->query($sql1);
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	foreach ($r as $k=>$v) {
		$arrPatientInfo = explode("_",$k);
		if (count($arrPatientInfo)==2) {
			if ($v==1) {
				${$arrPatientInfo[0]} = $arrPatientInfo[1];
			}
		} else {
			${$k} = $v;
		}
	}
	
	echo '
<tr>
  <td width="6%" class="link1"><center>
  <a href="index.php?mod=humanresource&func=formview&id=16_1&workID='.$workID.'&EmpID='.$EmpID.'&EmpGroup='.$EmpGroup.'" title="Edit"><i class="fa fa-pencil fa-lg"></i></a>
  <a href="print.php?mod=humanresource&func=formview&id=16_1&workID='.$workID.'&EmpID='.$EmpID.'&EmpGroup='.$EmpGroup.'" title="Print" target="_blank"><i class="fa fa-print fa-lg"></i></a>
  </center></td>
  <td>'.$date.'</td>
  <td>'.$position.'</td>
  <td>'.$Name.'</td>
  <td>'.$Q3.'～'.$Q4.'</td>
  <td>'.option_result("Q5","Regular vacation;Chrismas/new year vacation;Casual leave;Sick leave;Official leave;Other","s","single",$Q5,false,5).$Q5a.'</td>
  <td>'.$Q5b.'</td>
  <td>'.$arrstatus[$status].'</td>
  <td>'.$Q2a.'</td>
</tr>'."\n";
}
?>
</table>
</div>
<p>&nbsp;</p>
<script>
$(function(){
	$('#table16').dataTable({
		"autoWidth": true,
		"order": [[1, "desc"]],
		"pageLength": 20
	});
});
</script>