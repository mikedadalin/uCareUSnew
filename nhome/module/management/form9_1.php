<h3>Multi-disciplinary care conferences</h3>
<form>
<div align="right" style="margin-bottom:5px;">
<input type="button" onClick="window.location.href='index.php?mod=management&func=formview&id=3';" value="Back to appraisal index" />
<input type="button" id="Add" value="Add new conferences" />
</div>
</form>
<table id="recordtable" style="width:100%;">
  <thead>
  <tr class="title">
    <th>Date</th>
    <th>Time</th>
    <th>Location</th>
    <th>Resident's name</th>
    <th>Presenter</th>
    <th>Function</th>
  </tr>
  </thead>
  <tbody>
    <?php
    $db2 = new DB;
    $db2->query("SELECT * FROM `sixtarget_profile` WHERE 1 ORDER BY `date` DESC, `time` DESC");
    for ($i=0;$i<$db2->num_rows();$i++) {
 	$r2 = $db2->fetch_assoc();
	$pid = getPID($r2['HospNo']);
	echo '
  <tr>
    <td>'.formatdate($r2['date']).'</td>
    <td>'.$r2['time'].'</td>
    <td>'.$r2['location'].'</td>
    <td>'.getPatientName($pid).'</td>
    <td>'.$r2['host'].'</td>
	<td>';
	if ($r2['Qfiller']==$_SESSION['ncareID_lwj']) {
		echo '<center><a href="index.php?mod=management&func=formview&id=9_3&pid='.$pid.'&tID='.$r2['targetID'].'" title="Edit"><img src="Images/edit_icon.png" width="30" border="0"></a><a href="print.php?mod=management&func=formview&id=9_3&pid='.$pid.'&tID='.$r2['targetID'].'" title="Print" target="_blank"><img src="Images/printer.png" width="30" border="0"></a><a href="" onClick="del(\''.$r2['targetID'].'\');" title="Delete"><img src="Images/delete2.png" width="30" ></a></center>';
	} else {
		echo '&nbsp;';
	}
	echo '</td>
  </tr>
	'."\n";
    }
    ?>
  </tbody>
</table>
<script>
$(function(){
	$('#recordtable').dataTable();
	$("#Add").click(function(){
		var $dialog = $('<div title="Multi-disciplinary care conferences" class="dialog-form"><table width="100%"><tr><td class="title">Select resident</td></tr></table></div>').dialog({
			buttons: [{
				text: "Enter",
				click: function(){
					location.href="index.php?func=managementlist";
					$dialog.remove();
				}
			}]
		});	
	});
})
function del(id){
	if (confirm("Are you sure to delete this item?")) {
		$.ajax({
			url: "class/delrow.php",
			type: "POST",
			data: {"formID": "sixtarget_profile", "colID": "targetID", "autoID": id },
			success: function(data) {
				if (data=="OK") {
					alert("Deletion successful !");
					window.location.reload();
				}
			}
		});
	}
}
</script>
