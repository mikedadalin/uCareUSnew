<h3>Reminders</h3>
<table width="100%" id="recordlist">
  <tbody>
    <tr><td colspan="1" id="setReminder"><form><input type="button" id="newrecord" value="Set reminder" onclick="openVerificationForm('#dialog-form');" style="height:25px;" /></form></td></tr>
    <tr class="title">
      <td class="printcol">Edit</td>
      <td>Remind date</td>
      <td>Reminder content</td>
      <td>Established by</td>
    </tr>
    <?php
    $db2 = new DB;
    $db2->query("SELECT * FROM `reminder` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `remindDate` DESC");
    for ($i=0;$i<$db2->num_rows();$i++) {
 	$r2 = $db2->fetch_assoc();
	echo '
  <tr>
    <td width="60" class="printcol"><center><a href="index.php?mod=nurseform&func=formview&id=4_1&pid='.$_GET['pid'].'&rID='.$r2['remindID'].'"><img src="Images/edit_icon.png"></a></center></td>
    <td><center>'.$r2['remindDate'].'</center></td>
    <td width="600"><center>'.str_replace("\n","<br>",$r2['remindContent']).'</center></td>
    <td><center>'.checkusername($r2['Qfiller']).'</center></td>
  </tr>'."\n";
	}
    ?>
  </tbody>
</table>
<script>
$(function() {
    $( "#dialog-form" ).dialog({
		autoOpen: false,
		height: 250,
		width: 680,
		modal: true,
		buttons: {
			"Set reminder": function() {
				$.ajax({
					url: "class/setreminder.php",
					type: "POST",
					data: { "HospNo": $("#HospNo").val(), "QremindContent": $("#QremindContent").val(), "QremindDate": $("#QremindDate").val(), "active": '1', "Qfiller": $("#Qfiller").val() },
					success: function(data) {
						$( "#dialog-form" ).dialog( "close" );
						alert("Set up successfully!");
						window.location.reload();
					}
				});
			},
			"Cancel": function() {
				$( "#dialog-form" ).dialog( "close" );
			}
		}
	});
});
</script>
<div id="dialog-form" title="Set reminder" class="dialog-form"> 
  <form>
  <fieldset>
    <table>
      <tr>
        <td class="title">Remind date</td>
        <td><script> $(function() { $( "#QremindDate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="QremindDate" id="QremindDate" size="12"> </td>
      </tr>
      <tr>
        <td class="title">Reminder content</td>
        <td><input type="text" name="QremindContent" id="QremindContent" size="60" ><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><input type="hidden" name="Qfiller" id="Qfiller" value="<?php echo $_SESSION['ncareID_lwj']; ?>" /></td>
      </tr>
    </table>
  </fieldset>
  </form>
</div>