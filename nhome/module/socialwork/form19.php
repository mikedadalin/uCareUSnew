<h3>跨專業整合照顧計畫表</h3>
<table width="100%">
  <tr class="title_s">
    <td><form><input type="button" value="新增跨專業整合照顧計畫" onclick="window.location.href='index.php?mod=socialwork&func=formview&pid=<?php echo mysql_escape_string($_GET['pid'])?>&id=19_1&action=new'" /></form></td>
  </tr>
</table>
<table width="100%">
  <tr class="title">
    <td width="6%">&nbsp;</td>
    <td>Date</td>
    <td>個案問題</td>
    <td>照會單位</td>
    <td>專業人員意見</td>
    <td>Execution</td>
    <td>Follow-up</td>
    <td width="12%">&nbsp;</td>
  </tr>
<?php
$db = new DB;
$db->query("SELECT * FROM `socialform19` WHERE `HospNo`='".$HospNo."' ORDER BY `date` DESC");
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
	echo '
  <tr>
    <td><center><a href="index.php?mod=socialwork&func=formview&pid='.mysql_escape_string($_GET['pid']).'&id=19_1&nID='.$nID.'&action=edit"><img src="Images/edit_icon.png" width="30"></a></center></td>
    <td>'.formatdate($date).'</td>
    <td>'.str_replace("\n","<br>",$Q1).'</td>
    <td>'.str_replace("\n","<br>",$Q2).'</td>
    <td>'.str_replace("\n","<br>",$Q3).'</td>
    <td>'.str_replace("\n","<br>",$Q4).'</td>
    <td>'.str_replace("\n","<br>",$Q5).'</td>
	<td><center><a href="print.php?mod=socialwork&func=formview&pid='.mysql_escape_string($_GET['pid']).'&id=19_1&nID='.$nID.'" target="_blank"><img src="Images/printer.png" border="0" width="30"></a> <a href="index.php?mod=socialwork&func=formdelete19&pid='.$_GET['pid'].'&nID='.$nID.'"><img src="Images/delete2.png" border="0" width="30"></a></center></td>
  </tr>'."\n";
  $date = "";
  $Q1 = "";
  $Q2 = "";
  $Q3 = "";
  $Q4 = "";
  $Q5 = "";
}
?>
</table>