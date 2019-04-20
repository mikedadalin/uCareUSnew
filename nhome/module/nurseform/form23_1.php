<?php
$targetID = mysql_escape_string($_GET['tID']);
$pid = mysql_escape_string($_GET['pid']);
$sMonth = ($qdate == "" ? "" : "&qdate=".$qdate);

$parentName = "sixtarget_part7";
$parentID = $targetID;
if (isset($_POST['submit'])) {
	$formID = $_POST['formID'];
	foreach ($_POST as $k=>$v) {
	  if($k!="formID" && $k!="submit" && substr($k,0,3)!="tmp" && $k!="fileCount" && $k!="Qry" && $k!="oldCount"){
		$db1 = new DB;
		$db1->query("UPDATE `".$formID."` SET `".mysql_escape_string($k)."`='".mysql_escape_string($v)."' WHERE `targetID`='".$targetID."'");
	  }
	}	
	include('class/insertSubItem.php');
	include('class/updateSubItem.php');
	echo '<script>alert("Modification success!");window.onbeforeunload=null;window.location.href="index.php?mod=nurseform&func=formview&id=23&pid='.$pid.'";</script>';
}

$db1 = new DB;
$db1->query("SELECT * FROM `sixtarget_part7` WHERE `targetID`='".$targetID."' AND `HospNo`='".$HospNo."'");
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
<h3>Training record for removing nasogastric tube</h3>
<table width="100%">
  <tr class="printcol">
    <td class="title" width="160">Full name</td>
    <td><?php echo $bedID.' '.$name; ?></td>
    <td class="title" width="160">Care ID#</td>
    <td><?php echo $r1['HospNo']; ?></td>
  </tr>
  <tr>
    <td class="title">Start date</td>
    <td colspan="3"><input type="text" name="startdate" id="startdate" value="<?php echo $startdate; ?>"></td>
  </tr>
<!--  <tr>
    <td class="title">Time</td>
    <td colspan="3"><select name="timeH" id="timeH">
          <option></option>
          <?php
  		  $H = substr($r1['time'],0,2);
		  $S = substr($r1['time'],3,2);
		  for ($i2a=0;$i2a<=23;$i2a++) { 
		    $select = (($H==""?date(H):$H)==$i2a?" selected":"");	
		  	echo '<option value="'.(strlen($i2a)==1?'0':'').$i2a.'" '.$select.'>'.(strlen($i2a)==1?'0':'').$i2a.'</option>'; 
		  }
		  ?>
        </select>：<select name="timeI" id="timeI">
          <option></option>
          <option value="00" <?php echo (($S==""?"00":$S)=="00"?" selected":"");?>>00</option>
          <option value="15" <?php echo (($S==""?"00":$S)=="15"?" selected":"");?>>15</option>
          <option value="30" <?php echo (($S==""?"00":$S)=="30"?" selected":"");?>>30</option>
          <option value="45" <?php echo (($S==""?"00":$S)=="45"?" selected":"");?>>45</option>
        </select></td>
  </tr>
-->  <tr>
    <td class="title">Reasons for indwelling nasogastric tube</td>
    <td colspan="3"><?php echo draw_option("reason","Dysphagia;Easily choked;Indwelled during hospitalization;Other","xxxl","single",$reason,true,2); ?> <input type="text" name="reasonother" id="reasonother" size="15" value="<?php echo $reasonother;?>"></td>
  </tr>
  <tr>
    <td class="title">Evaluation of results and follow up assessment</td>
    <td colspan="3"><textarea id="releasereason" name="releasereason" cols="3"><?php echo $releasereason; ?></textarea></td>
  </tr>
  <tr>
    <td class="title">End date</td>
    <td colspan="3"><input type="text" name="enddate" id="enddate" value="<?php echo $enddate; ?>"></td>
  </tr>
  <tr>
    <td class="title">Results</td>
    <td colspan="3"><?php echo draw_option("result","Success;Unsuccessful","l","single",$result,false,3); ?></td>
  </tr>
  <tr>
    <td class="title">Filled by</td>
    <td colspan="3"><?php echo checkusername($Qfiller); ?></td>
  </tr>
  </table>
<?php 
$tmpArr=array("Date","Time","Record of training process","Filled by");
$tmpArrCol=array("title","content1","content2","content3");
$tmpLength = count($tmpArr);
include("class/blockSubItem.php");
include("class/addSubItem.php");
?>
<center>
<input type="hidden" name="formID" id="formID" value="sixtarget_part7" />
<?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?>
<input type="hidden" id="submit" value="Save" name="submit"/><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
<input type="button" onClick="window.location.href='index.php?mod=nurseform&func=formview&id=23&pid=<?php echo $pid;?>';" value="Back to list" />
<?php }?>
</center>
</form>
<script>
$(function() { 
	$( "#startdate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true});
	$( "#enddate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); 
	$('#FSform').validationEngine();
});
</script>