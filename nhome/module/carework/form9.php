<div class="moduleNoTab">
<h3>Special Reminders</h3>
<div style="margin:0 auto;">
<span align="right"><form><input type="button" id="newrecord" value="Add Special Reminder" onclick="openVerificationForm('#dialog-form');" style="height:32px;"/></form></span>
<center>
<table id="recordlist" cellpadding="5" style="width:100%;">
  <thead>
  <tr class="title">
    <td>Date</td>
    <td>Contents</td>
    <td>Established By</td>
  </tr>
  </thead>
  <tbody>
    <?php
    $db2 = new DB;
    $db2->query("SELECT * FROM `reminder2` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `remindDate` DESC");
    for ($i=0;$i<$db2->num_rows();$i++) {
 	$r2 = $db2->fetch_assoc();
	echo '
  <tr>
    <td><center>'.$r2['remindDate'].'</center></td>
    <td><center>'.$r2['remindContent'].'</center></td>
    <td><center>'.checkusername($r2['Qfiller']).'</center></td>
  </tr>'."\n";
	}
    ?>
  </tbody>
</table>
</center>
</div>
</div>
<script>
$(function() {
    $( "#dialog-form" ).dialog({
		autoOpen: false,
		height: 250,
		width: 610,
		modal: true,
		buttons: {
			"Add special reminder": function() {
				$.ajax({
					url: "class/setreminder2.php",
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
<div id="dialog-form" title="Add special reminder" class="dialog-form"> 
  <form>
  <fieldset>
    <table>
      <tr>
        <td class="title">Date</td>
        <td><script> $(function() { $( "#QremindDate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="QremindDate" id="QremindDate" size="12"> </td>
      </tr>
      <tr>
        <td class="title">Contents</td>
        <td><input type="text" name="QremindContent" id="QremindContent" size="60" ><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><input type="hidden" name="Qfiller" id="Qfiller" value="<?php echo $_SESSION['ncareID_lwj']; ?>" /></td>
      </tr>
    </table>
  </fieldset>
  </form>
</div>