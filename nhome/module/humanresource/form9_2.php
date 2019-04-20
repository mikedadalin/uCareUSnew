<?php
$EmpID = mysql_escape_string($_GET['EmpID']);
$EmpGroup = mysql_escape_string($_GET['EmpGroup']);
$trainingformID = mysql_escape_string($_GET['trainingform']);
if($EmpGroup ==1){
	$db5a = new DB;
	$db5a->query("SELECT * FROM `employer` WHERE `EmpID`='".$EmpID."';");
	$r5a = $db5a->fetch_assoc();
	$Name = $r5a['Name'];
}else{
	$db5b = new DB;
	$db5b->query("SELECT * FROM `foreignemployer` WHERE `foreignID`='".$EmpID."'");
	$r5b = $db5b->fetch_assoc();
	$Name = $r5b['cNickname'];
}
$db = new DB;
$db->query("SELECT * FROM `training_form` WHERE `trainingformID`='".$trainingformID."'");
$rs = $db->fetch_assoc();
$trainingform = $rs['type'];
$trainingname = $rs['trainingname'];

if (isset($_POST['submit'])) {
	foreach ($_POST as $k=>$v) {
		$arrPatientInfo = explode("_",$k);
		if (count($arrPatientInfo)==2) {
			${$arrPatientInfo[0]} = $v;
			//echo ${$arrPatientInfo[0]};
			$db2 = new DB;
			$db2->query("SELECT * FROM `humanresource9_1` WHERE `EmpID`='".$EmpID."' AND `EmpGroup`='".$EmpGroup."' AND `cID`='".$arrPatientInfo[1]."' AND `trainingformID`='".$trainingformID."'");
			
			if ($v!="") {
				if ($db2->num_rows()==0) {
					$db2a = new DB;
					$db2a->query("INSERT INTO `humanresource9_1` (`EmpID`, `EmpGroup`, `cID`, `Qfiller`,`trainingformID`) VALUES ('".$EmpID."', '".$EmpGroup."', '".$arrPatientInfo[1]."', '".$_SESSION['ncareID_lwj']."','".$trainingformID."')");
				}
				$db2b = new DB;
				$db2b->query("UPDATE `humanresource9_1` SET `".$arrPatientInfo[0]."` = '".$v."' WHERE `EmpID`='".$EmpID."' AND `EmpGroup`='".$EmpGroup."' AND `cID`='".$arrPatientInfo[1]."' AND `trainingformID`='".$trainingformID."'");
			}
		}
	}
	echo "<script>alert('New edit successfully!');</script>";
}

?>
<div class="moduleNoTab">
<form  method="post">
<h3>New-join staff<?php echo $trainingname; ?>Pre-employment training</h3>
Employee ID#<?php echo $EmpID; ?><br>Full name:<?php echo $Name;?>

<table width="100%" border="0" style="text-align:left;">	
  <tr class="title">
    <td colspan="2">Training item</td>
    <td width="130">Train date</td>
    <td>Comment</td>
  </tr>
<?php
$a = 1;
$db = new DB;
$str =" SELECT a.title titlea, a.service_cateID aID, c.title titlec, c.service_cateID cID FROM  `service_cate` a ";
$str .=" LEFT JOIN  `service_cate` c ON c.`parentID` = a.`service_cateID` ";
$str .=" WHERE 1 and a.typeCode='".$trainingform."' AND a.`layer` =1 AND a.`isHidden_1` =1 ";
$str .=" ORDER BY a.ord, c.ord";
//echo $str;
$db->query($str);
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	
	$dba = new DB;
	$str1 = "SELECT count(*) rowCount FROM `service_cate` b WHERE b.parentID='".$r['aID']."' and b.isHidden_1=1 order by b.ord";
	$dba->query($str1);
	$r2 = $dba->fetch_assoc();	
	
	$db1 = new DB;
	$db1->query("SELECT * FROM `humanresource9_1` WHERE `EmpID`='".$EmpID."' AND `EmpGroup`='".$EmpGroup."' AND `cID`='".$r['cID']."'");
	$r1 = $db1->fetch_assoc();
	echo '
  <tr>';
  if($tmp!=$r['titlea']){
    echo'<td class="title_s" rowspan="'.$r2['rowCount'].'">'.$r['titlea'].'</td>';
  }
   echo ' <td>'.str_replace("\n","<br>",$r['titlec']).'</td>
    <td><script> $(function() { $( "#teachDate_'.$r['cID'].'").datetimepicker({format:"Y/m/d", timepicker: false, mask: true}); }); </script><input type="text" name="teachDate_'.$r['cID'].'" id="teachDate_'.$r['cID'].'" size="10" value="'.$r1['teachDate'].'"></td>
	<td><textarea name="memo_'.$r['cID'].'" id="memo_'.$r['cID'].'" col="3">'.$r1['memo'].'</textarea></td>
  </tr>
	'."\n";
	$tmp=$r['titlea'];
}
?>
</table>
<table width="100%">
  <tr>
    <td style="background:#ffffff;"></td>
    <td style="background:#ffffff;" align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>
<center>
    <input type="button" id="back" name="back" value="Back to list" />
    <input type="submit" id="submit" name="submit" value="Save" />
</center>
</form>
</div>
<script language="javascript">
$(function() {
	$('#back').click(function(){
		location.href = "index.php?mod=humanresource&func=formview&id=9&EmpID=<?php echo $EmpID; ?>&EmpGroup=<?php echo $EmpGroup; ?>&trainingform=<?php echo $trainingformID;?>";
		
	});
});
</script>
