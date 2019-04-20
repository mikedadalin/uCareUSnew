<script>
$(function() {
    $( "#dialog-form" ).dialog({
		autoOpen: false,
		height: 390,
		width: 400,
		modal: true,
		buttons: {
			"Add clinic": function() {
				$.ajax({
					url: "class/management26.php",
					type: "POST",
					data: {"date": $("#date").val(), "timeH": $("#timeH").val(), "timeI": $("#timeI").val(), "department": $("#department").val(), "doctor": $("#doctor").val(), "follower": $("#follower").val(), "sUser": '<?php echo $_SESSION['ncareID_lwj']; ?>' },
					success: function(data) {
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
});
$(document).ready(function() {
	$('#table1').dataTable({
		"order": [[1,'desc']]
	});
} );
</script>

<div id="dialog-form" title="Add new clinic info" class="dialog-form"> 
  <form>
  <fieldset>
    <table>
      <tr>
        <td class="title">Date</td>
        <td><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php echo date(Y."/".m."/".d); ?>" size="12"></td>
      </tr>
      <tr>
        <td class="title">Time</td>
        <td>
        <select name="timeH" id="timeH">
          <option></option>
          <?php
		  for ($i2a=0;$i2a<=23;$i2a++) { echo '<option value="'.$i2a.'">'.(strlen($i2a)==1?'0':'').$i2a.'</option>'; }
		  ?>
        </select>：<select name="timeI" id="timeI">
          <option></option>
          <option value="00">00</option>
          <option value="15">15</option>
          <option value="30">30</option>
          <option value="45">45</option>
        </select>
        </td>
      </tr>
      <tr>
        <td class="title">Division</td>
        <td><input type="text" name="department" id="department" value="" size="20"></td>
      </tr>
      <tr>
        <td class="title">Physician</td>
        <td><input type="text" name="doctor" id="doctor" value="" size="20"></td>
      </tr>
      <tr>
        <td class="title">Visit Companion (Staff)</td>
        <td>
        <select name="follower" id="follower">
          <option></option>
          <?php
		  $db2 = new DB2;
		  $db2->query("SELECT * FROM `userinfo` WHERE `OrgID`='".$_SESSION['nOrgID_lwj']."' AND (`group`='2' OR (`group`='1' AND `level`='5')) AND `active`='1';");
		  for ($i2b=0;$i2b<$db2->num_rows();$i2b++) {
			  $r2b = $db2->fetch_assoc();
			  echo '<option value="'.$r2b['userID'].'">'.$r2b['name'].'</option>'."\n";
		  }
		  ?>
        </select>
        </td>
      </tr>
    </table>
  </fieldset>
  </form>
</div>

<h3>Clinic visit report</h3>
<div align="right"><form><input type="button" id="newrecord" value="Add new clinic info" onclick="openVerificationForm('#dialog-form'); filloldrecord();" style="height:32px;"/></form></div>
<table id="table1" width="100%">
  <thead><tr class="title">
    <th style="padding:10px;">Clinic ID#</th>
    <th>Date</th>
    <th style="padding:10px;">Division</th>
    <th style="padding:10px;">Physician</th>
    <th style="padding:10px;">Visit Companion (Staff)</th>
    <th style="padding:10px;">Resident Register</th>
    <th style="padding:10px;">Registered List</th>
    <th style="padding:10px;">Generate Reports</th>
    <th style="padding:10px;">Clinic Visiting Records</th>
  </tr></thead>
  <tbody>
  <?php
  $db1 = new DB;
  $db1->query("SELECT * FROM `opdinfo` ORDER BY `date` DESC");
  for ($i1=0;$i1<$db1->num_rows();$i1++) {
	  $r1 = $db1->fetch_assoc();
	  echo '
  <tr>
	<td align="center">'.$r1['opdID'].'</td>
	<td nowrap align="center" style="padding:10px;">'.$r1['date'].'</td>
	<td align="center">'.$r1['department'].'</td>
	<td align="center">'.$r1['doctor'].'</td>
	<td align="center">'.checkusername($r1['follower']).'</td>
	<td align="center" style="padding:10px;"><a href="index.php?mod=management&func=formview&id=26c&opdID='.$r1['opdID'].'">Resident register</a></td>
	<td align="center" style="padding:10px;"><a href="module/management/form26d.php?opdID='.$r1['opdID'].'" target="_blank">Registered list</a></td>
	<td align="center" style="padding:10px;"><a href="index.php?mod=management&func=formview&id=26e&opdID='.$r1['opdID'].'">Generate reports</a></td>
	<td align="center" style="padding:10px;"><a href="module/management/form26f.php?opdID='.$r1['opdID'].'" target="_blank">Clinic visiting records</a></td>
  </tr>
	  '."\n";
  }
  ?>
  </tbody>
</table>