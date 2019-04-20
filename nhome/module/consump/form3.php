<?php
$db = new DB;
$db->query("SELECT `patientID`,`HospNo`,`Birth` FROM `patient` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."'");
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	$db1 = new DB;
	$db1->query("SELECT `bed`,`indate` FROM `inpatientinfo` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."'");
	$r1 = $db1->fetch_assoc();
	$name = getPatientName($r['patientID']);
	$birth = formatdate($r['Birth']);
	$indate = formatdate($r1['indate']);
	$HospNo = $r['HospNo'];
	$bedID = $r1['bed'];
	$db2 = new DB;
	$db2->query("SELECT `Qdiag1`, `Qdiag2`, `Qdiag3`, `Qdiag4`, `Qdiag5`, `Qdiag6`, `Qdiag7`, `Qdiag8` FROM `nurseform01` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1");
	$r2 = $db2->fetch_assoc();
	for ($j=1;$j<=8;$j++) { if ($r2['Qdiag'.$j]!=NULL) { $diagMsg .= $r2['Qdiag'.$j].', '; } }
	$diagMsg = substr($diagMsg, 0, strlen($diagMsg)-2);
}
?>
<div class="content-query">
<table align="left"  width="882" style="font-size:10pt; margin-left:0px;" cellpadding="5">
  <tr id="backtr"  style="border:none; height:32px;" >
    <td class="title" width="70" style="border-top-left-radius:10px; background-color:#eecb35;">Bed #</td>
    <td width="90" style="border:none;"><?php echo $bedID; ?></td>   
    <td class="title" width="70" style="border:none;">Name</td>
    <td width="90" style="border:none;"><?php echo $name; ?></td>
    <td class="title" width="70" style="border:none;">Care ID#</td>
    <td width="90" style="border:none;"><?php echo $HospNo; ?></td>
    <td class="title" width="70" style="border:none;">DOB</td>
    <td  style="border-top-right-radius:10px;"><?php echo $birth.' ('.checkgender(mysql_escape_string($_GET['pid'])).', '.calcage(str_replace('/','',$birth)).')'; ?></td>
  </tr>
  <tr style="border:none; height:20px;" >
    <td class="title" style="border-bottom-left-radius:10px;">Admission Date</td>
    <td style="border:none;"><?php echo $indate; ?></td>
    <td class="title" style="border:none;">Diagnosis</td>
    <td style="border-bottom-right-radius:10px;" colspan="5"><?php echo $diagMsg; ?></td>
  </tr>
</table>
</div>
&nbsp;
<h3 style="margin-top:0px;">Item application record</h3>
<div align="left" style="float:left;">
<form>
<script>
function newORD() {
	$.ajax({
		url: "class/neword.php",
		type: "POST",
		data: { "PID": '<?php echo @$_GET['pid'] ?>', "ORDUSER": '<?php echo checkusername($_SESSION['ncareID_lwj']); ?>' },
		success: function(data) {
			window.location.href='index.php?mod=consump&func=formview&id=3_1&pid=<?php echo @$_GET['pid']; ?>&ORDSEQ=' + data;
		}
	});
}
</script>
<?php
if(getSystemSetting("consumpstatus")==1){
	echo ' <font color="#f00">目前系統出貨中!暫時無法申請物品!</font>'; 
} else {
?>
<input type="button" name="newBTN" id="newBTN" value="Add new Requisition" onclick="newORD();" />
<?php }?>
</form>
</div>






<div align="right">
<form>Jump to :
<select id="patientnamelist">
  <option>(Select resident...)</option>
  <?php
  $db3a = new DB;
  $db3a->query("SELECT `patientID`,`bed` FROM `inpatientinfo` ORDER BY `bed` ASC");
  for ($j=0; $j<$db3a->num_rows();$j++) {
	  $r3a = $db3a->fetch_assoc();
	  $db3b = new DB;
	  $db3b->query("SELECT `patientID`,`HospNo` FROM `patient` WHERE `patientID` = '".$r3a['patientID']."'");
	  $r3b = $db3b->fetch_assoc();
	  echo '<option value='.$r3b['patientID'].' '.($_GET['pid']==$r3b['patientID']?"selected":"").'>'.$r3a['bed'].' '.getPatientName($r3b['patientID']).' ('.$r3b['HospNo'].')</option>'."\n";
  }
  ?>
</select>
<input type="button" value="Go" onclick="window.location.href='index.php?mod=consump&func=formview&id=3&pid='+document.getElementById('patientnamelist').value">
</form>
</div>
<table width="100%">
  <tr class="title">
    <td>View</td>
    <td>Requisition ID#</td>
    <td>Item</td>
    <td>Requested Quantity</td>
    <td>Confirm Delivery</td>
    <td>Date of Requisition</td>
    <td>Applicant</td>
  </tr>
<?php
$db1 = new DB;
$db1->query("SELECT * FROM `arkordinfo` WHERE `PS_NO`='".$HospNo."' ORDER BY `ORD_DATE` DESC LIMIT 0,50");
for ($i=0;$i<$db1->num_rows();$i++) {
	$r1 = $db1->fetch_assoc();
	$db2 = new DB;
	$db2->query("SELECT * FROM `arkord` WHERE `ORD_SEQ`='".$r1['ORD_SEQ']."'");
	if ($db2->num_rows()>0) {
		for ($j=0;$j<$db2->num_rows();$j++) {
			$r2 = $db2->fetch_assoc();
			echo '
			<tr>';
			if ($j==0) {
				echo '
			  <td align="center" rowspan="'.$db2->num_rows().'"><a href="index.php?mod=consump&func=formview&id=3_2&pid='.@$_GET['pid'].'&ORDSEQ='.$r1['ORD_SEQ'].'"><img src="Images/edit_patient.png"></a></td>
			  <td rowspan="'.$db2->num_rows().'">'.$r1['ORD_SEQ'].'</td>'."\n";
			}
			echo '
			  <td>'.$r2['STK_NAME'].'</td>
			  <td>'.$r2['ORD_QTY'].' '.$r2['STK_UNIT'].'</td>
			  <td align="center">';
			  //回填確認數量
			  echo '
			  <form id="form_'.$r2['ORD_SEQ'].'_'.$r2['ORD_SEQ1'].'">
			  <input type="text" name="OUTQTY" id="OUTQTY_'.$r2['ORD_SEQ'].'_'.$r2['ORD_SEQ1'].'" size="3" value="'.$r2['OUT_QTY'].'">'.$r2['STK_UNIT'].' <input type="button" name="save" id="save" value="Confirm" onclick="confirmedORD(this.form.id);">
			  </form>
			  '."\n";
			  echo '</td>';
			if ($j==0) {
				echo '
			  <td rowspan="'.$db2->num_rows().'">'.$r1['ORD_DATE'].'</td>
			  <td rowspan="'.$db2->num_rows().'">'.$r1['ORD_USER'].'</td>'."\n";
			}
			echo '</tr>'."\n";
		}
	}
}
?>
</table><br><br>
<script>
function confirmedORD(formID) {
	var arrForm = formID.split('_');
	var SEQ = arrForm[1];
	var SEQ1 = arrForm[2];
	var QTY = document.getElementById('OUTQTY_'+arrForm[1]+'_'+arrForm[2]).value;
	$.ajax({
		url: "class/confirmord.php",
		type: "POST",
		data: { "SEQ": SEQ, "SEQ1": SEQ1, "OUTQTY": QTY },
		success: function(data) {
			if (data=="OK") {
			$('#savesuccess').fadeIn().delay(1500).fadeOut();
			} else {
			$('#savefailed').fadeIn().delay(1500).fadeOut();
			}
		}
	});
}

</script>
<div id="savesuccess" style="position:absolute; width:200px; height:40px; background:#ffffff; top:45%; left:45%; text-align:center; line-height:40px; color:#0000ff; display:none; border:3px solid; border-color:#0000ff;">Successfully saved!</div>
<div id="savefailed" style="position:absolute; width:200px; height:40px; background:#ffffff; top:45%; left:45%; text-align:center; line-height:40px; color:#ff0000; display:none; border:3px solid; border-color:#ff0000;">儲存失敗！</div>