<script>
$(function() {
    $( "#dialog-form" ).dialog({
		autoOpen: false,
		height: 680, //710
		width: 1000,
		modal: true,
		buttons: {
			"Add record": function() {
				$.ajax({
					url: "class/nurseform06.php",
					type: "POST",
					data: {"date": $("#date").val(), "time":$("#time").val(), "Q1": $("#Q1").val(), "Q2": $("#Q2").val(), "Qcontent": $("#Qcontent").val(), "Qfiller": '<?php echo $_SESSION['ncareID_lwj']; ?>' },
					success: function(data) {
						$( "#recordlist tbody" ).append( "<tr>" +
						"<td>" + $("#date").val() + "</td>" + 
						"<td>" + $("#Q2").val() + "# " + data + "</td>" + 
						"<td>" + $("#Qcontent").val() + "</td>" +
						"<td>&nbsp;</td>" + "</tr>" );
						$( "#dialog-form" ).dialog( "close" );
						alert("Add record sucessfully!");
						window.location.reload();
					}
				});
			},
			"Cancel": function() {
				$( "#dialog-form" ).dialog( "close" );
				window.location.reload();
			}
		}
	});
	$( "#newrecord" ).button().click(function() {
		var id = "Qcontent";
	    var instance = CKEDITOR.instances[id];
		if(instance) {
			CKEDITOR.remove(instance);
		}
		CKEDITOR.replace(id);
		openVerificationForm('#dialog-form');
	});
});
</script>
<!--<div style="background-color: rgba(255,255,255,0.9); border-radius: 10px; padding:10px; position:relative; left:1%;">-->
<h3>Nursing meeting minutes</h3>
<form action="index.php?func=database&action=save" style="height=60px; width:100%; text-align:left;">
<input type="button" id="newrecord" value="Add new record"></form>
<div id="dialog-form" title="Add new record" class="dialog-form"> 
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
	        <td><textarea name="Qcontent" id="Qcontent" cols="60" rows="14"></textarea></td>
	      </tr>
	    </table>
	  </fieldset>
	  </form>
</div>
<div style="width:100%;">
<table id="recordlist" style="width:100%;">
  <thead>
  <tr class="title">
    <th width="60">Select</th>
    <th width="120">Date</th>
    <th>Conference theme</th>
  </tr>
  </thead>
  <tbody>
    <?php
    $db2 = new DB;
    $db2->query("SELECT * FROM `nurseform06a` WHERE `Qcate`='1' ORDER BY `date`, `time` DESC");
    for ($i=0;$i<$db2->num_rows();$i++) {
 	$r2 = $db2->fetch_assoc();
	echo '
  <tr>
    <td><center><a href="index.php?mod=nurseform&func=formview&id=6_1&date='.$r2['date'].'&time='.$r2['time'].'"><img src="Images/edit_patient.png" width="20" border="0"></a></center></td>
    <td>'.formatdate($r2['date']).' '.substr($r2['time'],0,2).':'.substr($r2['time'],2,2).'</td>
    <td>'.$r2['Q2'].'</td>
  </tr>
	'."\n";
    }
    ?>
  </tbody>
</table>
</div>
<!--</div>-->
<script>
$(function() {
	$('#recordlist').dataTable({
		"order": [[1,'desc']],
		"paging": false;
	});
})
</script>