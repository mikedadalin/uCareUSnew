<script>
$(function() {
    $( "#newrecordform" ).dialog({
		autoOpen: false,
		height: 470,
		width: 680,
		modal: true,
		buttons: {
			"New treatment record": function() {
				$.ajax({
					url: "class/rehabilitationform02.php",
					type: "POST",
					data: {"HospNo": $("#HospNo").val(), "date": $("#date").val(), "Q1": $("#Q1").val(), "Q2": $("#Q2").val(), "Qmemo": $("#Qmemo").val(), "Qfiller": $("#Qfiller").val()  },
					success: function(data) {
						$( "#newrecordform" ).dialog( "close" );
						window.location.reload();
					}
				});
			},
			"Cancel": function() {
				$( "#newrecordform" ).dialog( "close" );
			}
		}
	});
});
</script>
<div id="newrecordform" title="New treatment record" class="dialog-form">
	<fieldset>
		<table>
			<tr>
			    <td class="title">Date</td>
			    <td><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php echo date(Y."/".m."/".d); ?>" size="12"></td>
		         </tr>
			<tr>
			    <td class="title">Passive joint range of motion exercise</td>
			    <td><input type="text" name="Q1" id="Q1" size="50"></td>
			</tr>
            <tr>
			    <td class="title">Posture swinging</td>
			    <td><textarea name="Q2" id="Q2" cols="50" rows="5"></textarea></td>
			</tr>
			<tr>
				<td class="title">Comment</td>
				<td>
                <textarea name="Qmemo" id="Qmemo" cols="50" rows="5"></textarea>
                <input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
				<input type="hidden" name="Qfiller" id="Qfiller" value="<?php echo $_SESSION['ncareID_lwj']; ?>">
                </td>
			</tr>
		</table>
	</fieldset>
</div>
<h3>Bedside Treatment Record</h3>
<?php
$url = $_SERVER['PHP_SELF'];
$url = explode(".",$url);
$url = explode("/",$url[0]);
$file = $url[2];
?>
<table id="newrecordtable" style="width:100%;">
  <thead>
  	<td colspan="4">
  <div <?php if ($file=="print") echo ' style="display:none;"'; ?>><?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?><form><input type="button" id="newrecord" value="New Treatment Record" onclick="openVerificationForm('#newrecordform');" style="height:30px;"/></form><?php }?></div>
    </td>
  </thead>
  <thead>
  <tr class="title">
    <td>Date</td>
    <td colspan="2">&nbsp;</td>
	<?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?>
    <td>Delete</td>
	<?php }?>
  </tr>
  </thead>
  <tbody>
  <?php
  $db2 = new DB;
  $db2->query("SELECT * FROM `rehabilitationform02` WHERE `HospNo`='".$HospNo."' ORDER BY `date`, `no` DESC");
  for ($i=0;$i<$db2->num_rows();$i++) {
 	$r2 = $db2->fetch_assoc();
	echo '
  <tr>
    <td rowspan="4"><center>'.formatdate($r2['date']).'</center></td>
	<td class="title_s">Passive joint range of motion exercise</td>
    <td align="center">'.$r2['Q1'].'</td>';
	if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){
	echo '<td rowspan="4" align="center"><form><input type="button" id="delete_'.$HospNo.'_'.$r2['date'].'_'.$r2['no'].'" onclick="confirmdelete(this.id);" value="Delete"></form></td>';
    }
	echo '
  </tr>
  <tr>
    <td class="title_s">Posture swinging</td>
	<td align="center">'.$r2['Q2'].'</td>
  </tr>
  <tr>
    <td class="title_s">Comment</td>
	<td align="center">'.$r2['Qmemo'].'</td>
  </tr>
  <tr>
    <td class="title_s">Therapist</td>
	<td align="center">'.checkusername($r2['Qfiller']).'</td>
  </tr>
  '."\n";
  }
  ?>
  </tbody>
</table>
<script>
function confirmdelete(id) {
	if (confirm('Confirm delete?')) {
		var postinfo = id.split(/_/);
		$.ajax({
			url: "class/rehabilitationform02_delete.php",
			type: "POST",
			data: {"HospNo": postinfo[1], "date": postinfo[2], "no": postinfo[3] },
			success: function(data) {
				confirm("Deletion success");
				document.location.reload(true);
			}
		});
	} else {
		alert('Deletion canceled');
	}
}
</script>