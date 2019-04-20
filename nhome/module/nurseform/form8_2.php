<?php
$db1 = new DB;
if (@$_GET['nID']==NULL) {
	$sql1 = "SELECT * FROM `nurseform08` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql1 = "SELECT * FROM `nurseform08` WHERE `nID`='".mysql_escape_string($_GET['nID'])."'";
	$db1->query($sql1);
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
}
?>
<form  method="post" onSubmit="return checkForm();" action="index.php?func=databaseAI">
<h3>特殊事件</h3>
<table width="100%">
<?php
if ($Q0=="") { $Q0 = date('Y/m/d');; }
?>
  <tr height="30">
    <td class="title" width="140">發生日期</td>
    <td colspan="3"><?php echo $Q1; ?></td>
  </tr>
  <tr height="30">
    <td class="title">Item(s)</td>
    <td><?php echo option_result("Q2","Hospitalization;離院;特殊事件;客訴;新褥瘡產生;跌倒;Other","m","single",$Q2,false,5); ?><br>Note:<?php echo $Q3; ?></td>
  </tr>
  <tr height="30">
    <td class="title">Cause of the event / treatment</td>
    <td><?php echo $Q4; ?></td>
  </tr>
  <tr height="30">
    <td class="title">Filled by</td>
    <td><?php echo checkusername($Qfiller); ?></td>
  </tr>
  <tr height="30">
    <td class="title" colspan="2">追蹤日期/Results</td>
  </tr>
  <tr>
    <td colspan="2">
    <table width="100%">
      <tr class="title_s">
        <td>Date</td>
        <td>Time</td>
        <td>Results</td>
        <td>Filled by</td>
      </tr>
	<?php 
	$pid = (int) @$_GET['pid'];
	$parentName = "nurseform08";
	$parentID = $_GET['nID'];
	$db3 = new DB;
	$db3->query("SELECT * FROM `alldetail` WHERE `parentName`='".$parentName."' and `parentID`='".mysql_escape_string($parentID)."'");
	for ($i3=0;$i3<$db3->num_rows();$i3++) {
		$r3 = $db3->fetch_assoc();
		echo '
		<tr>
		  <td style="background:#fff;">'.formatdate($r3['title']).'</td>
		  <td style="background:#fff;">'.$r3['content1'].'</td>
		  <td style="background:#fff;">'.$r3['content2'].'</td>
		  <td style="background:#fff;">'.$r3['content3'].'</td>
		</tr>
		'."\n";
	}
	?>
    </table>
    </td>
  </tr>
  <tr height="30">
    <td class="title" colspan="2">主管意見</td>
  </tr>
  <tr>
    <td class="title">Reply date</td>
	<td><script>$(function() { $('#Q5a').datepicker(); });</script><input type="text" name="Q5a" id="Q5a" size="18" value="<?php echo $Q5a; ?>"></td>
  </tr>
  <tr>
    <td class="title">回覆意見</td>
	<td><textarea name="Q5b" id="Q5b" rows="6"><?php echo $Q5b; ?></textarea></td>
  </tr>
  <tr>
    <td class="title">回覆人員</td>
	<td><input type="hidden" name="Q5c" id="Q5c" value="<?php if ($Q5c=="") { echo $_SESSION['ncareID_lwj']; } else { echo $Q5c; } ?>" /><?php if ($Q5c=="") { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Q5c); } ?></td>
  </tr>
</table>
<center><input type="hidden" name="formID" id="formID" value="nurseform08" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><input type="hidden" name="nID" id="nID" value="<?php echo $_GET['nID']; ?>" /><input type="hidden" name="action" id="action" value="<?php echo $_GET['action']; ?>" /> <input type="button" value="Back to list" id="back"> <button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></center>
</form>

<script>
$(function() {
	$('#back').click(function(){
		location.href = "index.php?mod=nurseform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=8";
	});
});
</script>