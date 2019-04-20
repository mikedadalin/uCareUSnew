<?php
if ($_GET['EmpID']!="") {
	$EmpID = (int) @$_GET['EmpID'];
} else {
	$EmpID = "";
}
if($_GET['workID']==''){
	$workID="";
}else{
	$workID=(int) @$_GET['workID'];
}

$db5a = new DB;
$db5a->query("SELECT * FROM `employer` WHERE `EmpID`='".$EmpID."';");
$r5a = $db5a->fetch_assoc();
$Name = $r5a['Name'];
$Position = $r5a['Position'];
$Position2 = $r5a['Position2'];

if (isset($_POST['submit'])) {
	if ($_POST['workID']==''){
		$db1 = new DB;
		$db1->query("INSERT INTO `humanresource12` (`EmpID`,`EmpGroup`, `date`, `cxr`, `lab`, `suggest`, `followup`, `Qfiller`) VALUES ('".mysql_escape_string($_POST['EmpID'])."','1', '".mysql_escape_string($_POST['date'])."', '".mysql_escape_string($_POST['cxr'])."', '".mysql_escape_string($_POST['lab'])."', '".mysql_escape_string($_POST['suggest'])."', '".mysql_escape_string($_POST['followup'])."', '".mysql_escape_string($_POST['Qfiller'])."');");		
	}else{
		$db1->query("UPDATE `humanresource12` SET `date`='".mysql_escape_string($_POST['date'])."',`cxr`='".mysql_escape_string($_POST['cxr'])."', `lab`='".mysql_escape_string($_POST['lab'])."', `suggest`='".mysql_escape_string($_POST['suggest'])."', `followup`='".mysql_escape_string($_POST['followup'])."', `Qfiller`='".mysql_escape_string($_POST['Qfiller'])."' WHERE `workID`='".mysql_escape_string($_POST['workID'])."';");
		
	}
	echo "<script>history.go(-1);</script>";
}

$sql = "SELECT * FROM `humanresource12` WHERE `EmpID`='".mysql_escape_string($EmpID)."'";
if ($workID!='') { $sql .= " AND `workID`='".mysql_escape_string($workID)."'"; }
$sql .= " ORDER BY `date` DESC LIMIT 0,1";
$db1 = new DB;
$db1->query($sql);
if ($db1->num_rows()>0) {
	$r1 = $db1->fetch_assoc();
	foreach ($r1 as $k=>$v){
		${$k} = $v;
	}
}	
?>
<div class="moduleNoTab">
<h3>Physical examination report</h3>
<form  method="post" onSubmit="return checkForm();">
  <table style="width:100%;" border="0">
   <tr>
     <td width="120" class="title">Unit</td>
     <td width="120">&nbsp;</td>
     <td width="120" class="title">Title</td>
     <td width="120"><?php echo $Position;?></td>
     <td width="120" class="title">Full name</td>
     <td width="120"><?php echo $Name;?></td>
   </tr>
 </table>
 <table width="100%" border="0">
  <tr>
    <td class="title_s" width="100">Date</td>
    <td colspan="3" style="padding-left:20px; text-align:left;">
      <script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if ($date != NULL) { echo str_replace("-","/",$date); } ?>" size="12">
    </td>
  </tr>
  <tr>
    <td class="title_s" width="100">Chest X-ray</td>
    <td colspan="3" align="center">
      <textarea name="cxr"  cols="20" rows="5" id="cxr"><?php echo $cxr; ?></textarea>
    </td>
  </tr>
  <tr>
    <td class="title_s" width="100">Test items</td>
    <td colspan="3" align="center">
      <textarea name="lab"  cols="60" rows="5" id="lab"><?php echo $lab; ?></textarea>
    </td>
  </tr>
  <tr>
    <td  class="title_s" width="100">Physicians recommendation</td>
    <td colspan="3" align="center">
      <textarea name="suggest"  cols="60" rows="5" id="suggest"><?php echo $suggest; ?></textarea>
    </td>
  </tr>
  <tr>
    <td  class="title_s" width="100">Follow-up</td>
    <td colspan="3" align="center">
      <textarea name="followup"  cols="60" rows="5" id="followup"><?php echo $followup; ?></textarea>
    </td>
  </tr>
</table>
<center>
  <div style="margin-top:30px">
    <input type="hidden" name="workID" id="workID" value="<?php echo $_GET['workID']; ?>" />
    <input type="hidden" name="Qfiller" id="Qfiller" value="<?php echo $_SESSION['ncareID_lwj']; ?>" />
    <input type="hidden" name="EmpID" id="EmpID" value="<?php echo $_GET['EmpID']; ?>" />
    <input type="button" name="back" onClick="window.location='index.php?mod=humanresource&func=formview&id=12&EmpID=<?php echo $EmpID; ?>'" value="Back to list">
    <input type="submit" id="submit" name="submit" value="Save" />
  </div>
</center>
</form>
</div>
<?php ?>

