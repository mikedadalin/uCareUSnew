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
?>
<div class="moduleNoTab">
<h3>New-join staff <?php echo $trainingname; ?>Pre-employment training</h3>
<div align="right" style="margin-bottom:15px;">
	<form><input type="button" value="Back to training list" id="back" name="back"><input type="button" onClick="window.open('printHRform9.php?EmpID=<?php echo $EmpID; ?>&EmpGroup=<?php echo $EmpGroup; ?>&trainingform=<?php echo $trainingformID;?>');" value="Print"><input type="button" id="Item" name="Item" value="Project management"></form>
</div>
<table style="width:100%; text-align:center;" border="0">
	<tr>
		<td width="25%" class="title">Employee ID#</td>
		<td><?php echo $EmpID; ?></td>
		<td width="25%"  class="title">Full Name</td>
		<td><?php echo $Name;?></td>
	</tr>
</table>
<table width="100%" border="0">
	<tr>
		<td class="title"> month</td>
		<td class="title">Edit</td>
	</tr>
	<tr>
		<td>Train date</td>
		<td><form  method="post" action="index.php?mod=humanresource&func=formview&id=9_2&EmpID=<?php echo $EmpID; ?>&EmpGroup=<?php echo $EmpGroup; ?>&trainingform=<?php echo $trainingformID;?>"><input type="hidden" name="EmpID" id="EmpID" size="12" value="<?php echo $EmpID; ?>" ><input type="submit" value="Input"></form></td>
	</tr>
	<?php
	for ($i=1; $i<=3; $i++){
		$db1 = new DB;
		$db1->query("SELECT SUM(`score".$i."`) AS s FROM  `humanresource9_1` WHERE `EmpID` ='".$EmpID."' AND  `EmpGroup` ='".$EmpGroup."' AND  `trainingformID` ='".$trainingformID."'");  
		$r1 = $db1->fetch_assoc();
		?>
		<tr>
			<td>The <?php echo $i?> month</td>
			<td><form  method="post" action="index.php?mod=humanresource&func=formview&id=9_1&EmpID=<?php echo $EmpID; ?>&EmpGroup=<?php echo $EmpGroup; ?>&type=<?php echo $i; ?>&trainingform=<?php echo $trainingformID;?> 	"><input type="hidden" name="EmpID" id="EmpID" size="12" value="<?php echo $EmpID; ?>" ><input type="submit" value="Input">
				<?php 
				if($r1['s'] >0){
					echo '目前總分：'.$r1['s'].'Score';
				}
				?>
				
			</form>
		</td>
	</tr>
	<?php }?>
</table>
</div>
</form>
</div>
<script language="javascript">
$(function() {
	$('#Item').click(function(){
		var code = '<?php echo $trainingform; ?>';
		location.href = "index.php?mod=category&func=formview&id=1&code="+code;
	});
	$("#back").click(function(){
		location.href = "index.php?mod=humanresource&func=formview&id=14";
	});
});
</script>
