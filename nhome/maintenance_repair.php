<?php
if (isset($_POST['UpdateRepair'])) {
	$status = mysql_escape_string($_POST['status']);
	$RepairDate = mysql_escape_string($_POST['RepairDate']);
	$RepairContent = mysql_escape_string($_POST['RepairContent']);
	/*$db5 = new DB;
	$db5->query("SELECT * FROM `maintenance_phrase2` WHERE `phraseID`='".$RepairContent."'");
	$r5 = $db5->fetch_assoc();
	$RepairContenttxt = $r5['content'];*/
	$Repairer = mysql_escape_string($_POST['Repairer']);
	$mainID = mysql_escape_string($_GET['mainID']);
	
	$db0 = new DB;
	$db0->query("UPDATE `maintenance` SET `status`='".$status."', `RepairDate`='".$RepairDate."', `RepairContent`='".$RepairContent."', `Repairer`='".$Repairer."' WHERE `mainID`='".$mainID."'");
	
	echo '<script>window.location.href="index.php?func=maintenance"</script>';
}

$db1 = new DB;
$db1->query("SELECT * FROM `areainfo` ORDER BY `areaID` ASC");
$arrArea = array();
for ($i=0;$i<$db1->num_rows();$i++) {
	$r1 = $db1->fetch_assoc();
	$arrArea[$r1['areaID']] = $r1['areaName'];
}
$db2 = new DB2;
$db2->query("SELECT * FROM `userinfo` WHERE `OrgID`='".$_SESSION['nOrgID_lwj']."'");
$usertxt = ":";
for ($i=0;$i<$db2->num_rows();$i++) {
	$r2 = $db2->fetch_assoc();
	if ($usertxt!=NULL) { $usertxt .= ";"; }
	$usertxt .= $r2['userID'].":".$r2['name'];
}

$statustxt = "0:Unprocessed;1:Processing;2:Processed";

$db3 = new DB;
$db3->query("SELECT * FROM `maintenance` WHERE `mainID`='".mysql_escape_string($_GET['mainID'])."'");
$r3 = $db3->fetch_assoc();
?>
<div class="nurseform-table">
  <div align="left" style="padding-left:14px;"><h3>維修進度回覆maintenance processing reply</h3>
  <form action="index.php?mainID=<?php echo mysql_escape_string($_GET['mainID']); ?>&func=maintenance_repair" method="post">
  <table>
    <tr>
      <td class="title">維修編號maintenance serial number</td>
      <td><?php echo $r3['mainID']; ?></td>
      <td class="title">Apply date</td>
      <td><?php echo $r3['ApplyDate']; ?></td>
      <td class="title">申請者applicant</td>
      <td><?php echo checkusername($r3['Applicant']); ?></td>
    </tr>
    <tr>
      <td class="title">Floor/area</td>
      <td><?php echo $r3['ApplyFloor']; ?></td>
      <td class="title">Damaged scenarios</td>
      <td colspan="3">
	  <?php 
		$arrContent = explode("_",$r3['ApplyContent1']);
		foreach ($arrContent as $k=>$v){
			if(count($arrContent) ==2){
				$content = getTitle("property","p_name",$arrContent[0],"propertyID","p_no").($arrContent[1] !=""?"，".$arrContent[1]:"");
			} else{
				$content = $r3['ApplyContent1'];
			}
		}
	  
	  echo $content.' - '.$r3['ApplyContent2']; 
	  ?></td>
    </tr>
    <tr>
      <td class="title">狀態state</td>
      <td>
        <select name="status">
          <option></option>
          <option value="0" <?php if ($r3['status']==0) { echo 'selected'; } ?>>未處理unhandle</option>
          <option value="1" <?php if ($r3['status']==1) { echo 'selected'; } ?>>處理中handling</option>
          <option value="2" <?php if ($r3['status']==2) { echo 'selected'; } ?>>已處理handled</option>
        </select>
      </td>
      <td class="title">維修日期maintain date</td>
      <td colspan="3"><script> $(function() { $( "#RepairDate" ).datepicker(); }); </script><input type="text" name="RepairDate" id="RepairDate" value="<?php echo date("Y/m/d"); ?>" size="12" onchange="checkthisdate(this.value);" >
        <script>
	  function checkthisdate(selectedDate) {
		  if (selectedDate < '<?php echo $r3['ApplyDate']; ?>') {
			  alert("維修日期不可以小於申請日期，請重新選擇！maintain date can not be earlier than apply date! please re-select");
			  document.getElementById('RepairDate').value = '<?php echo date("Y/m/d"); ?>';
		  }
	  }
	  </script>
      </td>
      </tr>
    <tr>
      <td class="title">處理情形handling status</td>
      <td colspan="5"><select name="select" onchange="document.getElementById('RepairContent').value=this.options[this.selectedIndex].innerHTML">
        <option></option>
        <?php
		  $db4 = new DB;
		  $db4->query("SELECT * FROM `maintenance_phrase2` ORDER BY `phraseID` ASC");
		  for ($i=0;$i<$db4->num_rows();$i++) {
			  $r4 = $db4->fetch_assoc();
			  echo '<option value="'.$r4['phraseID'].'" '; if ($r4['content']==$r3['RepairContent']) { echo 'selected'; } echo '>'.$r4['content'].'</option>'."\n";
		  }
		  ?>
      </select>
      <input type="text" name="RepairContent" id="RepairContent" size="60" value="<?php echo $r3['RepairContent']; ?>"/></td>
      </tr>
  </table>
  <input type="hidden" name="Repairer" id="Repairer" value="<?php echo $_SESSION['ncareID_lwj']; ?>" />
  維修人員maintenance staff：<?php echo checkusername($_SESSION['ncareID_lwj']); ?>
  <center><input type="submit" name="UpdateRepair" value="Save" /></center>
  </form>
  </div>
</div>