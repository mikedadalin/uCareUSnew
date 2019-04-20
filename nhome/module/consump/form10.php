<form>
<script>
function newORD() {
	$.ajax({
		url: "class/neword2.php",
		type: "POST",
		data: { "aID": '<?php echo @$_GET['aID'] ?>', "ORDUSER": '<?php echo checkusername($_SESSION['ncareID_lwj']); ?>' },
		success: function(data) {
			window.location.href='index.php?mod=consump&func=formview&id=10_1&aID=<?php echo @$_GET['aID']; ?>&ORDSEQ=' + data;
		}
	});
}
</script>
<?php
echo 'Select floor ：<select id="area" onchange="window.location.href=\'index.php?mod=consump&func=formview&id=10&aID=\'+this.options[this.selectedIndex].value">';
echo '  <option></option>';
$db3 = new DB;
$db3->query("SELECT * FROM `arkarea` ORDER BY `areaID` ASC");
for ($i3=0;$i3<$db3->num_rows();$i3++) {
	$r3 = $db3->fetch_assoc();
	echo '  <option value="'.$r3['areaID'].'"';
	if (@$_GET['aID']==$r3['areaID']) { echo ' selected'; }
	echo '>'.$r3['areaName'].'</option>';
	$arrAreaName[$r3['areaID']] = $r3['areaName'];
}
echo '</select>';
if(getSystemSetting("consumpstatus")==1){
	echo ' <font color="#f00">Currently, the system shipping in! Temporarily unable to apply material!</font>'; 
} elseif (@$_GET['aID']>0) { 
	echo '<input type="button" name="newBTN" id="newBTN" value="Add new requisition" onclick="newORD();"/>'; 
} else { 
	echo ' <font color="#f00">Please select the floor and area first!</font>'; 
}
?>
</form>
<h3>Item application record <?php if (@$_GET['aID']>0) { echo '('.$arrAreaName[@$_GET['aID']].')'; } ?></h3>
<table cellpadding="5" style="width:100%;">
  <tr class="title">
    <td>View</td>
    <td>Requisition ID#</td>
    <td>Item</td>
    <td>Requested quantity</td>
    <td>Confirm delivery</td>
    <td>Date of requisition</td>
    <td>Applicant</td>
  </tr>
<?php
$db1 = new DB;
$db1->query("SELECT * FROM `arkordinfo` WHERE `PS_NAME`='Area".@$_GET['aID']."' ORDER BY `ORD_DATE` DESC LIMIT 0,50");
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
			  <td align="center" rowspan="'.$db2->num_rows().'"><a href="index.php?mod=consump&func=formview&id=10_2&aID='.@$_GET['aID'].'&ORDSEQ='.$r1['ORD_SEQ'].'"><img src="Images/edit_patient.png"></a></td>
			  <td rowspan="'.$db2->num_rows().'">'.$r1['ORD_SEQ'].'</td>'."\n";
			}
			echo '
			  <td align="left">'.$r2['STK_NAME'].'</td>
			  <td align="left">'.$r2['ORD_QTY'].' '.$r2['STK_UNIT'].'</td>
			  <td align="left">';
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
</table>
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