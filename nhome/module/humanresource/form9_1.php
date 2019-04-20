<?php
$EmpID = mysql_escape_string($_GET['EmpID']);
$EmpGroup = mysql_escape_string($_GET['EmpGroup']);
$trainingformID = mysql_escape_string($_GET['trainingform']);
$type = @$_GET['type'];
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
			$db2 = new DB;
			$db2->query("SELECT * FROM `humanresource9_1` WHERE `EmpID`='".$EmpID."' AND `EmpGroup`='".$EmpGroup."' AND `cID`='".$arrPatientInfo[1]."'  AND `trainingformID`='".$trainingformID."'");
			
			if ($v!="") {
				if ($db2->num_rows()==0) {
					echo "<script>alert('Please fill the date of training!');window.location.href='index.php?mod=humanresource&func=formview&id=9_2&EmpID=".$EmpID."&EmpGroup=".$EmpGroup."&trainingform=".$trainingformID."'</script>";
					$error++;
				}
				$db2b = new DB;
				$db2b->query("UPDATE `humanresource9_1` SET `".$arrPatientInfo[0]."` = '".$v."', `Qfiller".$type."`='".$_SESSION['ncareID_lwj']."' WHERE `EmpID`='".$EmpID."' AND `EmpGroup`='".$EmpGroup."' AND `cID`='".$arrPatientInfo[1]."' AND `trainingformID`='".$trainingformID."'");
			}
		}
	}
	if ($error==0) echo "<script>alert('Edited successfully!');</script>";
}

?>
<form  method="post">
	<h3>New-join staff <?php echo $trainingname; ?>Pre-employment training</h3>
	<table style="width:100%; text-align:center;" border="0">
		<tr>
			<td width="25%" class="title">Employee ID#</td>
			<td><?php echo $EmpID; ?></td>
			<td width="25%"  class="title">Full Name</td>
			<td><?php echo $Name;?></td>
		</tr>
	</table>
	<table width="100%" border="0">	
		<tr class="title">
			<td colspan="2">Training Item</td>
			<td width="130">Training date</td>
			<td>Performance</td>
			<td>Comment</td>
		</tr>
		<?php
		$a = 1;
		$db = new DB;
		$str =" SELECT a.title titlea, a.service_cateID aID, c.title titlec, c.service_cateID cID FROM  `service_cate` a ";
		$str .=" LEFT JOIN  `service_cate` c ON c.`parentID` = a.`service_cateID` ";
		$str .=" WHERE 1 and a.typeCode='".$trainingform."' AND a.`layer` =1 AND a.`isHidden_1` =1 ";
		$str .=" ORDER BY a.ord, c.ord";
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
				echo '<td class="title_s" rowspan="'.$r2['rowCount'].'">'.$r['titlea'].'</td>';
			}
			echo ' <td>'.str_replace("\n","<br>",$r['titlec']).'</td>
			<td><script> $(function() { $( "#date'.$type.'_'.$r['cID'].'").datetimepicker({format:\'Y/m/d\', timepicker: false, mask: true}); }); </script><input type="text" name="date'.$type.'_'.$r['cID'].'" id="date'.$type.'_'.$r['cID'].'" size="10" value="'.$r1['date'.$type].'"></td>
			<td><input type="text" name="score'.$type.'_'.$r['cID'].'" id="score'.$type.'_'.$r['cID'].'" size="5" value="'.$r1['score'.$type].'"></td>
			<td><input type="text" name="memo_'.$r['cID'].'" id="memo_'.$r['cID'].'." size="10" value="'.$r1['memo'].'"></td>
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
		<div style="margin-top:20px">
			<input type="button" id="back" name="back" value="Back to list" />
			<input type="submit" id="submit" name="submit" value="Save" />
		</div>
	</center>
</form>
<script language="javascript">
$(function() {
	$('#back').click(function(){
		location.href = "index.php?mod=humanresource&func=formview&id=9&EmpID=<?php echo $EmpID; ?>&EmpGroup=<?php echo $EmpGroup; ?>&type=<?php echo $type; ?>&trainingform=<?php echo $trainingformID;?>";
		
	});
});
</script>
<?php
function getCate($id){
	$db = new DB;
	$str = "select * from service_cate a inner join service_item b on a.service_cateID=b.service_cateID ";
	$str .=" where b.service_cateID='".$id."'";
	$db->query($str);
	$r1 = $db->fetch_assoc();
	return $r1['parentID'];
}
?>