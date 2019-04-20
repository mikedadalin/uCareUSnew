<script type="text/javascript" src="js/LWJ_tabs.js"></script>
<?php
//在職訓練表
$arrGroupName = array();
$db5c = new DB;
$db5c->query("SELECT * FROM `training_form` WHERE 1 ORDER BY `ord` ASC");
for ($i=0;$i<$db5c->num_rows();$i++) {
	$r5c = $db5c->fetch_assoc();
	$arrGroupName[$r5c['trainingformID']] = $r5c['trainingname'];
}
?>
<div class="moduleNoTab">
<form  method="post">
	<h3 style="margin-top:0px;">Staff training record</h3>
	<div id="tabs" style="width:100%; padding:15px;">
		<ul>
			<?php
			foreach ($arrGroupName as $k5=>$v5) {
				echo '<li><a href="#tabs-'.$k5.'">'.$v5.'</a></li>'."\n";
			}
			?>
		</ul>
		<?php 
		foreach ($arrGroupName as $k5=>$v5) {
	//$EmpList = getWorkingStaff(1);	  
	//$foreignList = getWorkingStaff(2);
			echo '
			<div id="tabs-'.$k5.'" style="padding:1px;">'."\n".'
			<table style="width:100%;">'."\n".'
			<tr class="title">'."\n".'
			<td width="350">Staff name</td>'."\n".'
			<td>Form</td>'."\n".'
			</tr>'."\n";
			//foreach ($EmpList as $k1=>$v1) {
			$db = new DB;
			$db->query("SELECT * FROM `employer_training` WHERE `trainingformID` like '%".$k5."%' ORDER BY `EmpGroup`,`EmpID`");	
			if($db->num_rows() >0){
				for($i5=0;$i5<$db->num_rows();$i5++){
					$r5 = $db->fetch_assoc();
					$EmpName="";
					if($r5['EmpGroup']==2){
						$EmpName1 = getTitle("foreignemployer","eNickname",$r5['EmpID'],"foreignID","").getTitle("foreignemployer","cNickname",$r5['EmpID'],"foreignID",""); 
							$EmpName = ($EmpName1 !=""?$EmpName1:getTitle("foreignemployer","eName",$r5['EmpID'],"foreignID","")); //外藉
						}else{
							$EmpName = getTitle("employer","Name",$r5['EmpID'],"EmpID",""); //本國
						}
						
						if(checkWorkingStatus($r5['EmpID'],$r5['EmpGroup']) ==1 && calcdays(getLastStartdate($r5['EmpID'], $r5['EmpGroup'])) <=100){
							echo '
							<tr>'."\n".'
							<td align="left" width="150">'.$EmpName.'</td>'."\n".'
							<td align="left">
							<input type="button" value="Pre-employment training" onclick="goform(\''.$r5['EmpID'].'\','.$r5['EmpGroup'].',\'9\','.$k5.');">
							</td>'."\n".'
							</tr>'."\n";
						}
					}
				}
			//}
				echo '	
				</table>'."\n".'
				</div>'."\n";
			}
			?>
		</div>

	</form>
</div>
	<script>
	function goform(EmpID,EmpGroup,formID,trainingformID){
		window.location.href='index.php?mod=humanresource&func=formview&id='+formID+'&EmpID='+EmpID+'&EmpGroup='+EmpGroup+'&trainingform='+trainingformID;
	}
	</script>