<?php
$db1 = new DB;
$db1->query("SELECT * FROM `socialform04` WHERE `no`='".mysql_real_escape_string($_GET['no'])."' AND `HospNo`='".$HospNo."' AND `date`='".mysql_real_escape_string($_GET['date'])."'");
$r1 = $db1->fetch_assoc();

if (isset($_POST['savemod'])) {
	$db2 = new DB;
	$db2->query("UPDATE `socialform04` SET `Qproblem`='".mysql_real_escape_string($_POST['Qproblem'])."', `Qinteraction`='".mysql_real_escape_string($_POST['Qinteraction'])."', `Qcontent`='".mysql_real_escape_string($_POST['Qcontent'])."' WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".mysql_escape_string($_POST['date'])."' AND `no`='".mysql_escape_string($_POST['no'])."';");
	echo "<script>alert('Saved successfully');window.onbeforeunload=null;window.location.href='index.php?mod=socialwork&func=formview&pid=".@$_GET['pid']."&id=4'</script>";
}

?>
<div class="moduleNoTab">
<form method="post">
<table cellpadding="7">
  <tr>
      <td class="title" width="100">Date</td>
      <td><?php echo formatdate($r1['date']); ?><input type="hidden" name="date" id="date" value="<?php echo $r1['date']; ?>"></td>
      <td class="title" width="100">Time</td>
      <td><?php echo $r1['time']; ?></td>
  </tr>
  <tr>
      <td class="title">Issue/problem description</td>
      <td colspan="3" style="text-align:left;"><input type="text" name="Qproblem" id="Qproblem" size="50" value="<?php echo $r1['Qproblem']; ?>"></td>
  </tr>
  <tr>
      <td class="title">Counseling/interaction content</td>
      <td colspan="3" style="text-align:left;"><textarea name="Qinteraction" id="Qinteraction" cols="50" rows="5"><?php echo $r1['Qinteraction']; ?></textarea></td>
  </tr>
  <tr>
      <td class="title">Treatment summary</td>
      <td colspan="3" style="text-align:left;">
      <textarea name="Qcontent" id="Qcontent" cols="50" rows="5"><?php echo $r1['Qcontent']; ?></textarea>
      <input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
      <input type="hidden" name="Qfiller" id="Qfiller" value="<?php echo $_SESSION['ncareID_lwj']; ?>">
      <input type="hidden" name="no" id="no" value="<?php echo $r1['no']; ?>">
      </td>
  </tr>
  <tr>
    <td colspan="4"><input type="hidden" value="Save" name="savemod" ><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></td>
  </tr>
</table>
</form>
</div>