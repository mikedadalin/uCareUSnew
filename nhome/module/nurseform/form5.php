<?php
if (@$_GET['date1']==NULL || @$_GET['date2']==NULL) {
	$d = new DateTime();
	$d->modify("-30 day"); $td1 = $d->format('Ymd');
	$date1 = $td1;
	$date2 = date(Ymd);
	$db2 = new DB;
	$db2->query("SELECT * FROM `nurseform05` WHERE `HospNo`='".$HospNo."' AND `date`>='".mysql_escape_string($td1)."' AND `date`<='".mysql_escape_string(date(Ymd))."'  ORDER BY `date` ASC");
	$db2a = new DB;
	$db2a->query("SELECT * FROM `nursediagassess` WHERE `HospNo`='".$HospNo."' AND `assessdate`>='".mysql_escape_string($td1)."' AND `assessdate`<='".mysql_escape_string(date(Ymd))."'  ORDER BY `assessdate` ASC");
} else {
	$date1 = @$_GET['date1'];
	$date2 = @$_GET['date2'];
	$db2 = new DB;
	$db2->query("SELECT * FROM `nurseform05` WHERE `HospNo`='".$HospNo."' AND `date`>='".mysql_escape_string($_GET['date1'])."' AND `date`<='".mysql_escape_string($_GET['date2'])."' ORDER BY `date` ASC");
	$db2a = new DB;
	$db2a->query("SELECT * FROM `nursediagassess` WHERE `HospNo`='".$HospNo."' AND `assessdate`>='".mysql_escape_string($_GET['date1'])."' AND `assessdate`<='".mysql_escape_string($_GET['date2'])."'  ORDER BY `assessdate` ASC");
}
$arrRecord = array();
for ($i=0;$i<$db2->num_rows();$i++) {
 	$r2 = $db2->fetch_assoc();
	$arrRecord[formatdate($r2['date']).' '.substr($r2['time'],0,2).':'.substr($r2['time'],2,2)][$i] = array($r2['date'], $r2['time'], $r2['Q2'], str_replace("\n","<br>",str_replace("\'","'",$r2['Qcontent'])), $r2['Qfiller'], '<a href="index.php?mod=nurseform&func=formview&id=5_1&pid='.$_GET['pid'].'&nID='.$r2['nID'].'&action=edit"><img src="Images/edit_icon.png" width="20" border="0"></a>', '<a href="index.php?mod=nurseform&func=formview&pid='.mysql_escape_string($_GET['pid']).'&id=5_1&nID='.$r2['nID'].'&action=delete"><img src="Images/delete2.png" border="0"></a>', '1');
}
for ($i2=0;$i2<$db2a->num_rows();$i2++) {
 	$r2a = $db2a->fetch_assoc();
	$arrRecord[formatdate($r2a['assessdate'])][$i+$i2] = array($r2a['assessdate'], '', '#'.$r2a['diagno'].' '.$arrNursediag[$r2a['diagno']].' [護理診斷評值]', $r2a['text'], $r2a['Qfiller'], '<center><a href="index.php?mod=nursediag&func=formview&pid='.mysql_escape_string($_GET['pid']).'&id='.$r2a['diagno'].'&date='.str_replace('/','',$r2a['date']).'"><img src="Images/edit_icon.png" width="20" border="0"></a></center>', '', '2');
}
	ksort($arrRecord);
?>
<h3>Nursing record</h3>
<table <?php  if (strpos($_SERVER['PHP_SELF'],'print.php')!==false) { echo 'style="display:none;"'; } ?>>
  <tr>
    <td><form><input type="button" value="Add new nursing record" onclick="window.location.href='index.php?mod=nurseform&func=formview&id=5_1&pid=<?php echo $_GET['pid']; ?>&action=new'" /></form></td>
    <td align="right"><form>Select date:<script> $(function() { $( "#printdate1").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="printdate1" id="printdate1" value="<?php echo formatdate($date1); ?>" size="12"> ~ <script> $(function() { $( "#printdate2").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="printdate2" id="printdate2" value="<?php echo formatdate($date2); ?>" size="12"><input type="button" value="Search" onclick="datefunction('view');" /><input type="button" value="Print" onclick="datefunction('print');" /><input type="button" value="Continuous print" onclick="datefunction('printnew');" /></form></td>
  </tr>
</table>
<table width="100%" id="recordlist">
  <thead>
  <tr class="title">
    <td class="printcol" width="80">Function</td>
    <td width="120">Date and time</td>
    <td width="240">Focusing problem</td>
    <td>Record content</td>
    <td width="60">Staff</td>
  </tr>
  </thead>
  <tbody>
    <?php
    foreach ($arrRecord as $k1=>$v1) {
		foreach ($arrRecord[$k1] as $k=>$v) {
			echo '
		  <tr '.($v[7]==2?'style="color:#000;"':"").'>
			<td class="printcol" align="center">';
			if ($v[4]==$_SESSION['ncareID_lwj'] || $_SESSION['ncareLevel_lwj']>=4) {
				echo $v[5].' '.$v[6];
			} else {
				echo '&nbsp;';
			}
			echo '</td>
			<td valign="top">'.$k1.'</td>
			<td valign="top" align="center">'.$v[2].'</td>
			<td valign="top">'.$v[3].'</td>
			<td valign="top" align="center">'.checkusername($v[4]).'</td>
		  </tr>
			'."\n";
		}
	}
    ?>
  </tbody>
</table>
<script>
function datefunction(functioname) {
	var date1 = (document.getElementById('printdate1').value).replace("/",""); date1 = date1.replace("/","");
	var date2 = (document.getElementById('printdate2').value).replace("/",""); date2 = date2.replace("/","");
	if (functioname=='print') {
		window.location.href='print.php?mod=nurseform&func=formview&pid=<?php echo @$_GET['pid']; ?>&id=5&date1='+date1+'&date2='+date2;
	} else if (functioname=='printnew') {
		var startprint = prompt("請輸入起始列印行數，如果是列印在新的紙張上，填0即可","0");
		window.open('printnurserecord.php?pid=<?php echo @$_GET['pid']; ?>&id=5&date1='+date1+'&date2='+date2+'&startprint='+startprint);
	} else if (functioname=='view') {
		window.location.href='index.php?mod=nurseform&func=formview&pid=<?php echo @$_GET['pid']; ?>&id=5&date1='+date1+'&date2='+date2;
	}
}
</script>