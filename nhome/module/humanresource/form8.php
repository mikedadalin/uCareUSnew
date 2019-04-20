<script type="text/javascript" src="js/LWJ_tabs.js"></script>
<?php
//Group
$arrGroupName = array();
$db5c = new DB;
$db5c->query("SELECT * FROM `shift_group` WHERE `GroupID` in (1,2) ORDER BY `GroupID` ASC");
for ($i=0;$i<$db5c->num_rows();$i++) {
	$r5c = $db5c->fetch_assoc();
	$arrGroupName[$r5c['GroupID']] = $r5c['GroupName'];
}

?>
<div class="moduleNoTab">
<form  method="post">
	<h3>Staff appraisal list</h3>
	<div id="tabs" style="width:100%; padding:15px;">
		<ul>
			<?php
			foreach ($arrGroupName as $k5=>$v5) {
				echo '<li><a href="#tabs-'.$k5.'">'.$v5.'</a></li>'."\n";
			}
			?>
		</ul>
		<?php 
		$db5f = new DB;
		$db5f->query("SELECT DISTINCT `GroupID` FROM `shift_member` WHERE `GroupID` in (1,2) ORDER BY `GroupID` ASC");
		for ($i0=0;$i0<$db5f->num_rows();$i0++) {
			$r5f = $db5f->fetch_assoc();
			$db5 = new DB;
			$db5->query("SELECT * FROM `shift_member` WHERE `GroupID`='".mysql_escape_string($r5f['GroupID'])."' ORDER BY `GroupID` ASC, `order` ASC");
			echo '
			<div id="tabs-'.$r5f['GroupID'].'" style="padding:0;">'."\n".'
			<table style="width:100%;">'."\n".'
			<tr class="title">'."\n".'
			<td>Staff name</td>'."\n".'
			<td>Assessment</td>'."\n".'
			</tr>'."\n";
			for ($i=0;$i<$db5->num_rows();$i++) {
				$r5 = $db5->fetch_assoc();
				if ($r5['EmpGroup']==1) {
					$db5a = new DB;
					$db5a->query("SELECT * FROM `employer` WHERE `EmpID`='".$r5['EmpID']."';");
					$r5a = $db5a->fetch_assoc();
					$Name = $r5a['Name'];
				} else {
					$db5b = new DB;
					$db5b->query("SELECT * FROM `foreignemployer` WHERE `foreignID`='".$r5['EmpID']."'");
					$r5b = $db5b->fetch_assoc();
					$Name = $r5b['cNickname'];
				}							
				echo '
				<tr>'."\n".'
				<td align="center" width="150">'.$Name.'</td>'."\n".'
				<td align="left"><!--input type="button" value="Pre-employment training list" onclick="goform(\''.($r5['EmpID']+0).'\','.$r5['EmpGroup'].',\'9\');"-->				  <input type="button" value="Nursing skills" onclick="goform(\''.($r5['EmpID']+0).'\','.$r5['EmpGroup'].',\'8_1\');">';
				if ($r5['EmpGroup']==2) {
					echo ' <input type="button" value="Foreign staff appraisal" onclick="goform(\''.($r5['EmpID']+0).'\','.$r5['EmpGroup'].',\'8_2\');">';
				}
				echo '</td>'."\n".'
				</tr>'."\n";
			}
			echo '	
			</table>'."\n".'
			</div>'."\n";
		}
		?>
	</div>
	<br>
</form>
</div>
<script>
function goform(EmpID,EmpGroup,formID){
	window.location.href='index.php?mod=humanresource&func=formview&id='+formID+'&EmpID='+EmpID+'&EmpGroup='+EmpGroup;
}
</script>