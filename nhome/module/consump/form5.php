<h3>Print picking invoices</h3>
<div id="format1" style="display:inline;" align="left">
<?php 
$consumpstatus = getSystemSetting("consumpstatus");
?>
    <input type="radio" name="status" id="status_1" value="1" <?php echo ($consumpstatus=="1" || $consumpstatus==""?"checked":""); ?>><label for="status_1">Lock</label>
    <input type="radio" name="status" id="status_0" value="0" <?php echo ($consumpstatus=="0" || $consumpstatus==""?"checked":""); ?>><label for="status_0">Unlock</label>
</div>    
<div align="right">
<form>
	<input type="button" onclick="window.location.href='index.php?mod=consump&func=formview&id=5_2'" value="Picking statistics">
</form>
</div>
<table width="100%" id="tbl1">
<thead>
<tr class="title">
  <th width="720">Area</th>
  <th width="80">Not shipped</th>
  <th width="80">Print</th>
</tr>
</thead>
<?php
$db = new DB;
$db->query("SELECT * FROM `arkarea` ORDER BY `areaID` ASC");
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	
	//先算住民
	$arrHospNo = array();
	$db0 = new DB;
	$db0->query("SELECT * FROM `bedinfo` WHERE `Area`='".mysql_escape_string($r['areaID'])."'");
	for ($i1=0;$i1<$db0->num_rows();$i1++) {
		$r0 = $db0->fetch_assoc();
		$db0_1 = new DB;
		$db0_1->query("SELECT `patientID` FROM `inpatientinfo` WHERE `bed`='".$r0['bedID']."'");
		$r0_1 = $db0_1->fetch_assoc();
		$HospNo = getHospNo($r0_1['patientID']);
		if ($HospNo!="") { array_push($arrHospNo, $HospNo); }
	}
	$notFinished = 0;
	for ($k=0;$k<count($arrHospNo);$k++) {
		$sql = "SELECT * FROM `arkordinfo` a INNER JOIN `arkord` b ON a.`ORD_SEQ`=b.`ORD_SEQ` WHERE a.`PS_NO`='".$arrHospNo[$k]."' AND b.`ORD_QTY`>b.`OUT_QTY` AND b.`ORD_RMK` IS NULL ORDER BY a.`ORD_DATE` DESC";
		$db1 = new DB;
		$db1->query($sql);
		if ($db1->num_rows()>0) {
			$notFinished += $db1->num_rows();
		}
	}
	
	//再算公用物品
	$sql2 = "SELECT * FROM `arkordinfo` a INNER JOIN `arkord` b ON a.`ORD_SEQ`=b.`ORD_SEQ` WHERE a.`PS_NAME`='Area".$r['areaID']."' AND b.`ORD_QTY`>b.`OUT_QTY` AND b.`ORD_RMK` IS NULL ORDER BY a.`ORD_DATE` DESC";
	$db2 = new DB;
	$db2->query($sql2);
	if ($db2->num_rows()>0) {
		$notFinished += $db2->num_rows();
	}
	
	//Display
	echo '
<tr>
  <td>'.$r['areaName'].'</td>
  <td><center>'.$notFinished.' 項</center></td>
  <td><center><a href="index.php?mod=consump&func=formview&id=5_1&area='.$r['areaID'].'" width="24"><img src="Images/printer.png" border="0"></a></center></td>
</tr>
	'."\n";
}
?>
</table>
<script>
$(function() {
	$('div[id^=format]').buttonset();
	$('input[id^=status]').click(function(){
		var id = this.id.split('_');
		  $.ajax({
			  url: "class/edit2.php",
			  type: "POST",
			  data: {"formID": 'system_setting', "consumpstatus":id[1], "colID":'OrgID', "autoID": '<?php echo $_SESSION['nOrgID_lwj']; ?>'},
			  success: function(data) {
				if(data==1){
				   alert("Please unlock after delivered!");
				}else{
					alert("Unlock!");
				}
			  }
		  });
	});
	$('#tbl1').dataTable({
		"jQueryUI": false,
		searching: false,
		paging: false
	});
});
</script>