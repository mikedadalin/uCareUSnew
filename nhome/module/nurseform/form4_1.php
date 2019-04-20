<h3>Reminders</h3>
<?php
if (isset($_POST['submit'])) {
	if ($_POST['Qactive_1']==1) {
		$active = 1;
	} elseif ($_POST['Qactive_2']==1) {
		$active = 2;
	}
	$db1 = new DB;
	$db1->query("UPDATE `reminder` SET `remindDate`='".mysql_escape_string($_POST['QremindDate'])."', `remindContent`='".mysql_escape_string($_POST['QremindContent'])."', `active`='".$active."' WHERE `remindID`='".mysql_escape_string($_GET['rID'])."';");
}
$db0 = new DB;
$db0->query("SELECT * FROM `reminder` WHERE `remindID`='".mysql_escape_string($_GET['rID'])."'");
$r0 = $db0->fetch_assoc();
?>
<form method="post">
<table width="100%">
  <tr>
    <td class="title" width="110">Remind date</td>
    <td><script> $(function() { $( "#QremindDate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="QremindDate" id="QremindDate" size="12" value="<?php echo $r0['remindDate']; ?>"> </td>
  </tr>
  <tr>
    <td class="title" width="110">Reminder content</td>
    <td><textarea name="QremindContent" id="QremindContent" cols="80" rows="5"><?php echo $r0['remindContent']; ?></textarea></td>
  </tr>
  <tr>
    <td class="title" width="110">Active</td>
    <td><?php echo draw_option("Qactive","Yes;No","s","single",$r0['active'],false,1); ?></td>
  </tr>
  <tr>
    <td class="title" width="110">Established by</td>
    <td><?php echo checkusername($r0['Qfiller']); ?></td>
  </tr>
</table>
<center><input type="hidden" id="submit" name="submit" value="Save"><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></center>
</form>