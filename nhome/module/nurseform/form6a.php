<script>
$(function() {
    $( "#dialog-form" ).dialog({
		autoOpen: false,
		height: 680, //710
		width: 800,
		modal: true,
		buttons: {
			"Add record": function() {
				$.ajax({
					url: "class/nurseform06a.php",
					type: "POST",
					data: {"date": $("#date").val(), "time":$("#time").val(), "Q1": $("#Q1").val(), "Q2": $("#Q2").val(), "Qcontent": $("#Qcontent").val() },
					success: function(data) {
						$( "#dialog-form" ).dialog( "close" );
						alert("Add record sucessfully!");
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
<h3>Administrative meeting record</h3>
<form action="index.php?func=database&action=save">
<input type="button" id="newrecord" value="New meeting minute" onclick="openVerificationForm('#dialog-form');" /></form>
<div id="dialog-form" title="New meeting minute" class="dialog-form"> 
  <form>
  <fieldset>
    <table>
      <tr>
        <td class="title">Date/Time</td>
        <td><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php echo date(Y."/".m."/".d); ?>" size="12"> <input type="text" name="time" id="time" value="<?php echo date(Hi); ?>" size="4"> <font size="2">(Time format:HHmm)</font></td>
      </tr>
      <tr>
        <td class="title">Attendee</td>
        <td><input type="text" name="Q1" id="Q1" value="" size="60"></td>
      </tr>
      <tr>
        <td class="title">Conference theme</td>
        <td><input type="text" name="Q2" id="Q2" value="" size="60"></td>
      </tr>
      <tr>
        <td class="title">Meeting minutes</td>
        <td><textarea name="Qcontent" id="Qcontent" cols="100" rows="20"></textarea></td>
      </tr>
    </table>
  </fieldset>
  </form>
</div>
<table width="100%" id="recordlist">
  <thead>
  <tr class="title">
    <td width="120">Date</td>
    <td width="240">Conference theme</td>
  </tr>
  </thead>
  <tbody>
    <?php
    $db2 = new DB;
    $db2->query("SELECT * FROM `nurseform06a` ORDER BY `date`, `time` DESC");
    for ($i=0;$i<$db2->num_rows();$i++) {
 	$r2 = $db2->fetch_assoc();
	echo '
  <tr>
    <td>'.formatdate($r2['date']).' '.substr($r2['time'],0,2).':'.substr($r2['time'],2,2).'</td>
    <td>'.$r2['Q2'].'</td>
  </tr>
	'."\n";
    }
    ?>
  </tbody>
</table>