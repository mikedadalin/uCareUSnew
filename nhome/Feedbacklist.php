<?php
$date = mysql_escape_string($_GET['date']);
if ($date=="") { $date = date(Ymd); }
?>
<div class="nurseform-table" style="background-color: rgba(255,255,255,0.8); border-radius: 10px; padding:20px 10px 30px 10px; margin-bottom: 30px;">
<div>
	<h3 style="width:100%; font-size:28px;">Feedback Form</h3>
	<form><a style="font-size:30px; font-weight:bolder; color:rgb( 243, 219, 114);"></a><input type="text" name="printdate1" id="printdate1" value="<?php if (@$_GET['date']==NULL) { echo date("Y/m/d"); } else { echo formatdate(@$_GET['date']); } ?>" size="12"> <input type="button" value="Search" onclick="datefunction('view');" /><input type="button" value="All" onclick="window.location.href='index.php?func=Feedbacklist'" /><?php if($_SESSION['ncareID_lwj']=="Mor3Geneki6nge08" || $_SESSION['ncareID_lwj']=="Lejla05Mirzada12Asmira01"){?><input type="button" value="Print" onclick="datefunction('print');" /><?php }?><input type="button" value="Add" onclick="window.location.href='index.php?func=FeedbackForm&action=new'" /></form>
</div>
<?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?>
<table style="padding-top:20px; width:100%;">
  <tr class="title">
    <td width="6%" class="printcol">View</td>
    <td nowrap width="10%">Date</td>
    <td nowrap width="20%">Name</td>
	<td nowrap width="7%">URL</td>
    <td nowrap>Subject</td>
	<td nowrap width="7%">Replied</td>
    <td width="6%" class="printcol">&nbsp;</td>
  </tr>
<?php
if (@$_GET['date']==NULL) {
	$db = new DB;
	$db->query("SELECT * FROM `feedback` WHERE `Status`='1' ORDER BY `date` DESC");
} else {
	$db = new DB;
	$db->query("SELECT * FROM `feedback` WHERE `Status`='1' AND `date`>='".mysql_escape_string($_GET['date'])."' ORDER BY `date` DESC");
}

for ($j=0;$j<$db->num_rows();$j++) {
	$r = $db->fetch_assoc();
	foreach ($r as $k=>$v) {
		${$k} = $v;	
	}
	echo '
  <tr valign="middle">
    <td class="printcol"><center><a href="index.php?func=FeedbackForm&nID='.$nID.'&action=view"><img src="Images/Dialogue.png" width="30"></a></center></td>
    <td align="center" nowrap>'.formatdate($date).'</td>
    <td align="center" nowrap>'.$Name.'</td>';
	if($URL!="" || $URL!=NULL){
		echo '<td align="center"><a href="'.$URL.'"><img src="Images/Link.png" alt="Link"></a></td>';
	}else{
		echo '<td align="center"></td>';
	}
    echo '
	<td align="center" nowrap>'.$Subject.'</td>';
	if($Responses!="" && $ResponsesStatus=="1"){
		echo '<td align="center"><img src="Images/checkmark.png" alt="Replied"></td>';
	}else{
		echo '<td align="center"></td>';
	}
	echo '
	<td width="6%" class="printcol">';
	if ($_SESSION['ncareLevel_lwj']>=4 || $_SESSION['ncareID_lwj']==$Qfiller) {
		echo '<center><img src="Images/delete2.png" border="0" width="30" style="cursor:pointer;" onClick="del(\''.$nID.'\');" ></a>';
	}
	echo '</td>
  </tr>'."\n";
}
?>
</table>
<?php }?>
<table style="padding-top:20px; width:100%;">
  <tr class="title">
    <td width="6%" class="printcol">View</td>
    <td nowrap width="10%">Date</td>
	<td nowrap width="7%">Bed #</td>
    <td nowrap width="20%">Name</td>
    <td nowrap>Subject</td>
	<td nowrap width="7%">Replied</td>
    <td width="6%" class="printcol">&nbsp;</td>
  </tr>
<?php
if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){
	if (@$_GET['date']==NULL) {
		$db = new DB;
		$db->query("SELECT * FROM `feedback_resident` WHERE `Status`='1' ORDER BY `date` DESC");
	} else {
		$db = new DB;
		$db->query("SELECT * FROM `feedback_resident` WHERE `Status`='1' AND `date`>='".mysql_escape_string($_GET['date'])."' ORDER BY `date` DESC");
	}
}else{
	if (@$_GET['date']==NULL) {
		$db = new DB;
		$db->query("SELECT * FROM `feedback_resident` WHERE `Status`='1' AND `HospNo`='".substr($_SESSION['ncareID_lwj'],8,6)."' ORDER BY `date` DESC");
	} else {
		$db = new DB;
		$db->query("SELECT * FROM `feedback_resident` WHERE `Status`='1' AND `HospNo`='".substr($_SESSION['ncareID_lwj'],8,6)."' AND `date`>='".mysql_escape_string($_GET['date'])."' ORDER BY `date` DESC");
	}
}

for ($j=0;$j<$db->num_rows();$j++) {
	$r = $db->fetch_assoc();
	foreach ($r as $k=>$v) {
		${$k} = $v;
		$db2 = new DB;
		$db2->query("SELECT `patientID` FROM `patient` WHERE `HospNo`='".substr($Qfiller,8,6)."'");
		$r2 = $db2->fetch_assoc();
		$Name = getPatientName($r2['patientID']);	
	}
	$pid = getPID($HospNo);
	echo '
  <tr valign="middle">
    <td class="printcol"><center><a href="index.php?func=FeedbackForm&nID='.$nID.'&pid='.$pid.'&action=view"><img src="Images/Dialogue.png" width="30"></a></center></td>
    <td align="center" nowrap>'.formatdate($date).'</td>
	<td align="center" nowrap>'.getBedID($pid).'</td>
    <td align="center" nowrap>'.$Name.'</td>';
    echo '
	<td align="center" nowrap>'.$Subject.'</td>';
	if($Responses!="" && $ResponsesStatus=="1"){
		echo '<td align="center"><img src="Images/checkmark.png" alt="Replied"></td>';
	}else{
		echo '<td align="center"></td>';
	}
	echo '
	<td width="6%" class="printcol">';
	if ($_SESSION['ncareLevel_lwj']>=4 || $_SESSION['ncareID_lwj']==$Qfiller) {
		echo '<center><img src="Images/delete2.png" border="0" width="30" style="cursor:pointer;" onClick="del_resident(\''.$nID.'\');" ></a>';
	}
	echo '</td>
  </tr>'."\n";
}
?>
</table>
</div><br>
<script>
$(function() { 
	$( "#printdate1").datetimepicker({format:'Y/m/d', timepicker: false, mask: true});
});
function datefunction(functioname) {
	var date1 = (document.getElementById('printdate1').value).replace("/",""); date1 = date1.replace("/","");
	if (functioname=='print') {
		window.open('printfeedback.php?date='+date1);
	} else if (functioname=='view') {
		window.location.href='index.php?func=Feedbacklist&date='+date1;
	}
}
function del(id){
	if (confirm("Are you sure to delete this item?")) {
		$.ajax({
			url: "class/editrow.php",
			type: "POST",
			data: {"formID": "feedback", "nID": id , "Status":"0"},
			success: function(data) {
				window.location.reload();
			}
		});
	}
}
function del_resident(id){
	if (confirm("Are you sure to delete this item?")) {
		$.ajax({
			url: "class/editrow.php",
			type: "POST",
			data: {"formID": "feedback_resident", "nID": id , "Status":"0"},
			success: function(data) {
				window.location.reload();
			}
		});
	}
}
</script>