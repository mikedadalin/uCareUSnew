<?php
$arrTargetType = array("", "Hospitalization", "約束", "跌倒", "Infection", "Pressure ulcer(s)", "", "Nasogastric tube remove", "Catheter remove");

if (@$_GET['qdate']==NULL) {
	$qdate1 = date(Y."-".m);
	$qdate = date(Ym);
}else{
	$qdate = mysql_escape_string($_GET['qdate']);
}
$sMonth = ($qdate == "" ? "" : "&qdate=".$qdate);
?>
<h3><?php echo $arrTargetType[$_GET['type']]; ?>逐案分析列表</h3>
<table width="100%" id="recordlist">
  <thead>
  <tr class="title">
    <td width="100">Date</td>
    <td width="100">Time</td>
    <td>Location</td>
    <td width="150">Moderator</td>
    <td>簽到</td>
    <td width="60">Edit</td>
  </tr>
  </thead>
  <tbody>
    <?php
    $db2 = new DB;
    $db2->query("SELECT * FROM `sixtarget_meeting` WHERE `targetType` = '".mysql_escape_string($_GET['type'])."' AND `date` LIKE '".str_replace("/","-",$qdate1)."%' ORDER BY `date` DESC, `time` DESC");
    for ($i=0;$i<$db2->num_rows();$i++) {
 	$r2 = $db2->fetch_assoc();
	echo '
  <tr>
    <td>'.$r2['date'].'</td>
    <td>'.$r2['time'].'</td>
    <td>'.$r2['location'].'</td>
    <td>'.$r2['host'].'</td>
    <td>'.$r2['member'].'</td>
	<td>';
	//if ($r2['Qfiller']==$_SESSION['ncareID_lwj']) {
		echo '<center><a href="index.php?mod=management&func=formview&id=3d_3&type='.$r2['targetType'].'&mID='.$r2['meetingID'].$sMonth.'"><img src="Images/edit_icon.png" width="20" border="0"></a>&nbsp;<input type="image" src="Images/delete2.png" alt="Delete" onclick="del('.$r2['meetingID'].')"></center>';
	//} else {
	//	echo '&nbsp;';
	//}
	echo '</td>
  </tr>
	'."\n";
    }
    ?>
  </tbody>
</table>
<form>
<center>
<input type="button" onClick="window.location.href='index.php?mod=management&func=formview&view=<?php echo ($_GET['type']==7?8:($_GET['type']==8?9:$_GET['type']));?>&id=3<?php echo $sMonth;?>';" value="回<?php echo $arrTargetType[$_GET['type']]; ?>指標" />
</center>
</form>
<script>
function del(id){
	if(confirm('Confirm deletation??')){
		$.ajax({
			url: "class/delrow.php",
			type: "POST",
			data: {"formID": "sixtarget_meeting", "colID": "meetingID", "autoID": id},
			success: function(data) {
				if(data=="OK"){
					alert('刪除成功');
				}
				window.location.reload();
			}
		});
	}
}
</script>
