<?php
if (isset($_POST['saveassess'])) {
	$db = new DB;
	$db->query("INSERT INTO `nursediagassess` VALUES ('', '".mysql_escape_string($_POST['HospNo'])."', '".mysql_escape_string($_POST['date'])."', '".mysql_escape_string($_POST['diagno'])."', '".str_replace('/','',$_POST['assessdate'])."', '".mysql_escape_string($_POST['text'])."', '".mysql_escape_string($_POST['Qfiller'])."')");
	$db1 = new DB;
	$db1->query("INSERT INTO `nurseform05` VALUES ('', '".mysql_escape_string($_POST['HospNo'])."', '".str_replace('/','',$_POST['assessdate'])."', '".date(Hi)."', '#".$_POST['diagno']." ".$arrNursediag[(int) $_POST['diagno']]."', '".mysql_escape_string($_POST['text'])."', '', '".mysql_escape_string($_POST['Qfiller'])."')");
	echo '<script>window.location.href=\'index.php?mod=nursediag&func=formview&pid='.getPID($_POST['HospNo']).'&id=0\';</script>';
} elseif (isset($_POST['deleteassess'])) {
	$db = new DB;
	$db->query("DELETE FROM `nursediagassess` WHERE `assessID`='".mysql_escape_string($_POST['assessID'])."'");
	echo '<script>window.location.href=\'index.php?mod=nursediag&func=formview&pid='.getPID($_POST['HospNo']).'&id=0\';</script>';
} elseif (isset($_POST['editassess'])) {
	$db = new DB;
	$db->query("UPDATE `nursediagassess` SET `text`='".mysql_escape_string($_POST['text'])."' WHERE `assessID`='".mysql_escape_string($_POST['assessID'])."'");
	echo '<script>window.location.href=\'index.php?mod=nursediag&func=formview&pid='.getPID($_POST['HospNo']).'&id=0\';</script>';
}
?>
<table>
  <tr class="title">
    <td width="16%">Evaluation date</td>
    <td width="*">Assessment content</td>
    <td width="6%">&nbsp;</td>
  </tr>
</table>
      <?php
	  $db2 = new DB;
	  $db2->query("SELECT `assessID`, `assessdate`, `text`, `Qfiller` FROM `nursediagassess` WHERE `HospNo`='".$HospNo."' AND `date`='".$Q1."' AND `diagno`='".mysql_escape_string($_GET['id'])."' ORDER BY `assessdate` DESC");
	  for ($i=0;$i<$db2->num_rows();$i++) {
		  $r2 = $db2->fetch_assoc();
		  echo '
<form action="index.php?mod=nursediag&func=assess" method="post">
<table>
  <tr>
	<td width="16%">'.formatdate($r2['assessdate']).'</td>
	<td width="*">';
	if ($r2['Qfiller']==$_SESSION['ncareID_lwj']) {
		echo '<input type="text" id="text" name="text" value="'.$r2['text'].'" size="97%" /><input type="hidden" id="HospNo" name="HospNo" value="'.$HospNo.'" /><input type="hidden" id="assessID" name="assessID" value="'.$r2['assessID'].'" /><input type="submit" id="editassess" name="editassess" value="Modify" />';
	} else {
		echo $r2['text'];
	}
	echo '
	</td>
	<td width="6%">';
	if ($r2['Qfiller']==$_SESSION['ncareID_lwj']) {
		echo '<input type="submit" id="deleteassess" name="deleteassess" value="Delete" />
		<input type="hidden" id="Qfiller_'.$r2['assessID'].'" name="Qfiller_'.$r2['assessID'].'" value="'.checkusername($r2['Qfiller']).'" />';
	} else {
		echo checkusername($r2['Qfiller']);
	}
	echo '</td>
  </tr>
</table>
</form>'."\n";
	  }
	  ?>
<form action="index.php?mod=nursediag&func=assess" method="post">
<table>
  <tr>
	<td width="16%">
	<?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?><script> $(function() { $( "#assessdate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><?php }?><input type="text" id="assessdate" name="assessdate" value="<?php echo date(Y."/".m."/".d); ?>" size="12" /></td>
    <td width="*"><input type="text" id="text" name="text" value="" size="100%" /></td>
    <td width="6%">
    <input type="hidden" id="HospNo" name="HospNo" value="<?php echo $HospNo; ?>" />
    <input type="hidden" id="date" name="date" value="<?php echo $Q1; ?>" />
    <input type="hidden" id="diagno" name="diagno" value="<?php echo @$_GET['id']; ?>" />
    <input type="hidden" id="Qfiller" name="Qfiller" value="<?php echo $_SESSION['ncareID_lwj']; ?>" />
    <?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?><input type="submit" id="saveassess" name="saveassess" value="Save" /><?php }?>
    </td>
  </tr>
</table>
</form>