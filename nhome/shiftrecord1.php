<?php
$date = $_GET['date'];
if ($date=="") { $date = date(Ymd); }
?>
<div class="nurseform-table" style="background-color: rgba(255,255,255,0.9); border-radius: 10px; padding:20px 10px 30px 10px;">
<div align="center" style="">
	<form><input type="text" name="printdate1" id="printdate1" value="<?php if (@$_GET['date']==NULL) { echo date("Y/m/d"); } else { echo formatdate(@$_GET['date']); } ?>" size="12"> <input type="button" value="Search" onclick="datefunction('view');" /><input type="button" value="Print" onclick="datefunction('print');" /><input type="button" value="Add" onclick="window.location.href='index.php?func=shiftrecord1_1&action=new'" /></form>
</div>

<table cellpadding="5" style="padding-top:20px; width:100%;">
  <tr class="title">
    <td colspan="7" style="border-top-left-radius:10px; border-top-right-radius:10px; padding:15px 0px; font-size:20px;">Nursing document handover table</td>
  </tr>

      <tr class="title_s">
        <td width="80"></td>
        <td>New admission</td>
        <td>Discharge (checked-out)</td>
        <td>Hospitalization number</td>
        <td>Returned from hospital</td>
        <td>Number of death</td>
        <td>Resident daily census</td>
      </tr>
      <tr style="background:#fff;">
      <?php
	  $db0 = new DB;
	  $db0->query("SELECT * FROM `dailypatientno1` WHERE DATE_FORMAT(`date`,'%Y%m%d')='".mysql_escape_string($date)."'");
	  if ($db0->num_rows()>0) {
		  $r0 = $db0->fetch_assoc();
		 echo '
		 <td></td>
         <td align="center">'.$r0['newpat'].'</td>
         <td align="center">'.$r0['outpat'].'</td>
         <td align="center">'.$r0['hosppat'].'</td>
         <td align="center">'.$r0['backpat'].'</td>
         <td align="center">'.$r0['deadpat'].'</td>
         <td align="center">'.$r0['no'].'</td>
		 '."\n";
	  } else {
		 echo '
		 <td colspan="7">沒有資料</td>
		 '."\n"; 
	  }
	  ?>
      </tr>

  <tr class="title">
    <td width="6%" class="printcol">&nbsp;</td>
    <td nowrap>Handover date</td>
    <td nowrap>Resident</td>
    <td nowrap colspan="2">Handover content</td>
    <td nowrap>Filled by</td>
    <td width="6%" class="printcol">&nbsp;</td>
  </tr>
<?php
$arrVar = array("Day shift","Night shift","Graveyard shift");
if (@$_GET['date']==NULL) {
	$db = new DB;
	$db->query("SELECT * FROM `nurseform24` WHERE 1 AND `Q4`=0 ORDER BY `date` DESC, `Q1`");
} else {
	$db = new DB;
	$db->query("SELECT * FROM `nurseform24` WHERE 1 AND `Q4`=0 AND `date`>='".mysql_escape_string($_GET['date'])."' ORDER BY `date` DESC, `Q1`");
}

for ($j=0;$j<$db->num_rows();$j++) {
	$r = $db->fetch_assoc();
	foreach ($r as $k=>$v) {
		$arrAnswer = explode("_",$k);
		if (count($arrAnswer)==2) {
			if ($v==1) {
				${$arrAnswer[0]} .= $arrAnswer[1].';';
			}
		} else {
			${$k} = $v;
		}
	}
	$pid = getPID($HospNo);
	echo '
  <tr valign="top">
    <td class="printcol"><center><a href="index.php?func=shiftrecord1_1&nID='.$nID.'&action=edit"><img src="Images/edit_icon.png" width="30"></a></center></td>
    <td align="center" nowrap>'.formatdate($date).'<br>'.$arrVar[$Q1].'</td>
    <td align="center" nowrap>'.getBedID($pid).'<br>'.getPatientName($pid).'</td>
    <td align="left" colspan="2">'.str_replace("\n","<br>",$Q2).'</td>
    <td valign="middle" align="center" nowrap>'.checkusername($Qfiller).'</td>
	<td width="6%" class="printcol">
	';
	if ($_SESSION['ncareLevel_lwj']>=4 || $_SESSION['ncareID_lwj']==$Qfiller) {
		echo '<center><img src="Images/delete2.png" border="0" width="30" style="cursor:pointer;" onClick="del(\''.$nID.'\');" ></a>';
	}
	echo '</td>
  </tr>'."\n";
}
?>
</table>
</div>
<script>
$(function() { 
	$( "#printdate1").datetimepicker({format:'Y/m/d', timepicker: false, mask: true});
});
function datefunction(functioname) {
	var date1 = (document.getElementById('printdate1').value).replace("/",""); date1 = date1.replace("/","");
	if (functioname=='print') {
		window.open('printshiftrecord1.php?date='+date1);
	} else if (functioname=='view') {
		window.location.href='index.php?func=shiftrecord1&date='+date1;
	}
}
function del(id){
	if (confirm("Are you sure to delete this item?")) {
		$.ajax({
			url: "class/editrow.php",
			type: "POST",
			data: {"formID": "nurseform24", "nID": id, "Q4":"1" },
			success: function(data) {
				window.location.reload();
			}
		});
	}
}
</script>