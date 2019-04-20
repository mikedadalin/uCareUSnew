<div class="OrgMenu">
<table class="OrgMenuTable" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center">
<?
$db = new DB2;
$db->query("SELECT * FROM `userinfo`");
for($i=0;$i<$db->num_rows();$i++){
	$r = $db->fetch_assoc();
	$All_userID .= $r['userID'].";";
}
$arr_userID = explode(";",$All_userID);

$db2 = new DB2;
$db2->query("SELECT * FROM `user_permission` GROUP BY `userID`");
for($i=0;$i<$db2->num_rows();$i++){
	$r2 = $db2->fetch_assoc();
	if(!in_array($r2['userID'],$arr_userID)){
		$db3 = new DB2;
		$db3->query("DELETE FROM `user_permission` WHERE `userID`='".$r2['userID']."'");
	}
}
?>
		</td>
	</tr>
</table>
</div>