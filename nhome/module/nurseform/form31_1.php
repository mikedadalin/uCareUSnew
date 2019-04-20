<?php
$targetID = mysql_escape_string($_GET['tID']);
$pid = mysql_escape_string($_GET['pid']);
//$thisType = mysql_escape_string($_GET['t']);
$sMonth = ($qdate == "" ? "" : "&qdate=".$qdate);
//$disabled = ($thisType==""?"":"disabled");
$parentName = "nurseform31";
$parentID = $targetID;
if (isset($_POST['submit'])) {
	$formID = $_POST['formID'];
	foreach ($_POST as $k=>$v) {
	  if($k!="formID" && $k!="submit" && substr($k,0,3)!="tmp" && $k!="fileCount" && $k!="Qry" && $k!="oldCount" && $k!="t"){
		$db1 = new DB;
		$db1->query("UPDATE `".$formID."` SET `".mysql_escape_string($k)."`='".mysql_escape_string($v)."' WHERE `targetID`='".$targetID."'");
	  }
	}
	if($thisType==""){
		include('class/insertSubItem.php');
		include('class/updateSubItem.php');
	}
	echo '<script>alert("Modification success!");window.onbeforeunload=null;window.location.href="index.php?mod=nurseform&func=formview&id=31_1&pid='.$pid.'&tID='.$targetID.'&t='.$thisType.'";</script>';
}

$db1 = new DB;
$db1->query("SELECT * FROM `nurseform31` WHERE `targetID`='".$targetID."'");
$r1 = $db1->fetch_assoc();
  foreach ($r1 as $k=>$v) {
	  $arrAnswer = explode("_",$k);
	  if (count($arrAnswer)==2) {
		  if ($v==1) { ${$arrAnswer[0]} .= $arrAnswer[1].';'; }
	  } else {
		  ${$k} = $v;
	  }
  }
?>
<form  method="post" onSubmit="return checkForm();" id="FSform">
<h3>Integrative individual care plan</h3>
<table width="100%">
  <tr class="printcol">
    <td class="title" width="160">Full name</td>
    <td><?php echo $bedID.' '.$name; ?></td>
    <td class="title" width="160">Care ID#</td>
    <td><?php echo $r1['HospNo']; ?></td>
  </tr>
  <tr>
    <td class="title">Date</td>
    <td colspan="3"><input type="text" name="date" id="date" value="<?php echo $date; ?>" <?php echo $disabled;?>></td>
  </tr>
  <tr>
    <td class="title">Current problems and demand assessment</td>
    <td><textarea id="Q1" name="Q1" rows="5" <?php echo $disabled;?>><?php echo $Q1; ?></textarea></td>
    <td class="title">Filled by</td>
    <td><?php echo checkusername($Qfiller); ?></td>
  </tr>
  <tr>
    <td class="title">Topic of discussion with family</td>
    <td colspan="3"><textarea id="Q2" name="Q2" rows="5" <?php echo $disabled;?>><?php echo $Q2; ?></textarea></td>
  </tr>
  <tr>
    <td class="title">Conclusion and follow up</td>
    <td colspan="3"><textarea id="Q4" name="Q4" rows="5" <?php echo $disabled;?>><?php echo $Q4; ?></textarea></td>
  </tr>
  <tr>
    <td class="title">Notify multi-disciplinary care group</td>
    <td colspan="3"><?php 
	if($thisType==""){
		echo draw_option("Q3","Social worker;physiotherapist;Nutritionist;Pharmacist;Physician","l","multi",$Q3,false,3); 
	}else{
		echo option_result("Q3","Social worker;physiotherapist;Nutritionist;Pharmacist;Physician","l","multi",$Q3,false,3); 
	}
	?></td>
  </tr>
  <?php 
  $arrtype = array("1"=>"Social worker","2"=>"physiotherapist","3"=>"Nutritionist","4"=>"Pharmacist","5"=>"Physician");
  for ($i=1;$i<=5;$i++){
	  //($i==$thisType || ($thisType=="" && $i==5)?"":"disabled")
	  echo '
	  <tr>
		<td class="title">'.$arrtype[$i].' note advice</td>
		<td colspan="3"><textarea id="Q4_'.$i.'" name="Q4_'.$i.'" rows="5">'.$r1['Q4_'.$i].'</textarea></td>
	  </tr>
	  ';
  }
  ?>
  </table>
<?php 
$tmpArr=array("Care plan adjustment and follow up assessment","Filled by");
$tmpArrCol=array("title","userID");
$tmpLength = count($tmpArr);
include("class/blockSubItem.php");
if($thisType==""){
	include("class/addSubItem.php");
}

?>
  
<center>
<input type="hidden" name="t" id="t" value="<?php echo $thisType;?>">
<input type="hidden" name="formID" id="formID" value="nurseform31" />
<?php 
if ($Qfiller==$_SESSION['ncareID_lwj'] || $_SESSION['ncareLevel_lwj']>=5) {
?>
<input type="hidden" id="submit" value="Save" name="submit" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
<?php 
}
?>
<input type="button" onClick="window.location.href='index.php?mod=nurseform&func=formview&id=31&pid=<?php echo $pid;?>';" value="Back to list" />
</center>
  
</form>
<script>
$(function() { 
	<?php if($thisType==""){?>
	$( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true});
	<?php }?>
	$('#FSform').validationEngine();
});
</script>