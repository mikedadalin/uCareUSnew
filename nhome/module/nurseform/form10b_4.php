<?php
if (isset($_POST['submit'])) {
	$date = str_replace("/","",$_POST['date']);
	$Qreply = $_GET['Qreply'];
	$Q2_1 = $_POST['Q2_1'];
	$Q2_2 = $_POST['Q2_2'];
	$Q2a = $_POST['Q2a'];
	$Q3 = $_POST['Q3'];
	$Qfiller = $_SESSION['ncareID_lwj'];
	
	$db3 = new DB;
	$db3->query("SELECT * FROM `socialform10b_1` WHERE `HospNo`='".$HospNo."' AND `date`='".$date."' AND `Qreply`='".$Qreply."'");
	if ($db3->num_rows()==0) {
		$db3a = new DB;
		$db3a->query("INSERT INTO `socialform10b_1` (`HospNo`, `date`, `Qreply`, `Q2_1`, `Q2_2`, `Q2a`, `Q3`, `Qfiller`) VALUES ('".$HospNo."', '".$date."', '".$Qreply."', '".$Q2_1."', '".$Q2_2."', '".$Q2a."', '".$Q3."', '".$Qfiller."')");
	} else {
		$db3a = new DB;
		$db3a->query("UPDATE `socialform10b_1` SET `Q2_1`='".$Q2_1."', `Q2_2`='".$Q2_2."', `Q2a`='".$Q2a."', `Q3`='".$Q3."' WHERE `HospNo`='".$HospNo."' AND `date`='".$date."' AND `Qreply`='".$Qreply."'");
	}
	echo "<script>window.location.href='index.php?mod=socialwork&func=formview&id=10b&pid=".$_GET['pid']."'</script>";
}
$sql = "SELECT * FROM `socialform10b_1` WHERE `HospNo`='".mysql_escape_string($HospNo)."'";
if (@$_GET['date']!='') { $sql .= " AND `date`='".mysql_escape_string($_GET['date'])."'"; }
if (@$_GET['Qreply']!='') { $sql .= " AND `Qreply`='".mysql_escape_string($_GET['Qreply'])."'"; }
$sql .= " ORDER BY `date` DESC LIMIT 0,1";
$db1 = new DB;
$db1->query($sql);
$r1 = $db1->fetch_assoc();
if ($db1->num_rows()>0) {
	foreach ($r1 as $k=>$v) {
		if (substr($k,0,1)=="Q") {
			$arrAnswer = explode("_",$k);
			if (count($arrAnswer)==2) {
				if ($v==1) {
					${$arrAnswer[0]} .= $arrAnswer[1].';';
				}
			} else {
				${$k} = $v;
			}
		}  else {
			${$k} = $v;
		}
	}
}
?>
<script>
$(function() {
    $( "#dialog" ).dialog({
		autoOpen: false,
		height: 560,
		width: 1050,
		modal: true,
		buttons: {
			"Close": function() {
				$( "#dialog" ).dialog( "close" );
			}
		}
	});
	$( "#viewform" ).button().click(function() {
		$( "#dialog" ).dialog( "open" );
	});
});
</script>
<h3>Follow up assessment</h3>
<div id="dialog" title="Assessment results">
<iframe src="<?php echo "print.php?mod=socialwork&func=formview&pid=".$_GET['pid']."&id=10b_3&date=".$_GET['Qreply']; ?>" width="1000" height="400" frameborder="0"></iframe>
</div>
<div align="right"><form><input type="button" value="View plan" id="viewform" /></form></div>
<form  method="post" onSubmit="return checkForm();" action="index.php?mod=socialwork&func=formview&id=10b_4&pid=<?php echo $_GET['pid']; ?>&Qreply=<?php echo $_GET['Qreply']; ?>">
<table width="100%" border="0">
  <tr>
    <td class="title" colspan="2">Follow up assessment</td>
  </tr>
  <tr>
    <td class="title_s" width="100">Filled date</td>
    <td><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if ($date != NULL) { echo formatdate($date); }else{ echo date("Y/m/d");} ?>" size="10"><input type="hidden" name="Qreply" id="Qreply" value="<?php echo $_GET['Qreply']; ?>" size="10"></td>
  </tr>
  <tr>
    <td class="title_s" width="100">Nursing group</td>
    <td>
    <?php if ($_SESSION['ncareLevel_lwj']>=4 || $_SESSION['ncareID_lwj']==$Qfiller) { ?><textarea name="Q1"  cols="60" rows="5" id="Q1"><?php echo $Q1; ?></textarea><?php } else { echo $Q1; } ?>
    </td>
  </tr>
  <tr>
    <td class="title_s" width="100">Social working group</td>
    <td>
    1.The work objectives<br />
    <?php echo option_result("Q2","Maintain;Alter","s","single",$Q2,true,2); ?><br><?php echo $Q2a; ?><br />
    2. The implementation measures<br /><?php echo $Q3; ?>
    </td>
  </tr>
  <tr>
    <td  class="title_s" width="100">Rehabilitation group</td>
    <td><?php echo $Q4; ?></td>
  </tr>
</table>
<center><input type="hidden" name="formID" id="formID" value="socialform10b_1" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><input type="submit" id="submit" name="submit" value="Save" /></center>
</form>