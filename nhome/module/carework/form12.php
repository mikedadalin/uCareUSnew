<div class="moduleNoTab">
<h3>照顧計畫書</h3>
<table width="100%">
  <tr class="title_s">
    <td><form><input type="button" value="新增照顧計畫書" onclick="window.location.href='index.php?mod=carework&func=formview&pid=<?php echo mysql_escape_string($_GET['pid'])?>&id=12_1&action=new'" /></form></td>
  </tr>
</table>
<table cellpadding="5">
  <tr class="title">
    <td width="12%">&nbsp;</td>
    <td>Date</td>
    <td>主要問題</td>
    <td>Resident(家屬)期望</td>
    <td>照顧目標</td>
    <td width="6%">&nbsp;</td>
  </tr>
<?php
$db = new DB;
$db->query("SELECT * FROM `careform12` WHERE `HospNo`='".$HospNo."' ORDER BY `date` DESC");
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
    <td><center>
	<a href="index.php?mod=carework&func=formview&pid='.mysql_escape_string($_GET['pid']).'&id=12_1&nID='.$nID.'&action=edit" title="Edit"><img src="Images/edit_icon.png" width="30"></a>&nbsp;
	<a href="print.php?mod=carework&func=formview&pid='.mysql_escape_string($_GET['pid']).'&id=12_1&nID='.$nID.'" title="Print" target="_blank"><img src="Images/printer.png" width="30"></a>&nbsp;
    <td>'.formatdate($date).'</td>
    <td>'.checkbox_result("Q1","完全無法生活自理;部分無法生活自理;尚未適應機構生活;情緒經常不穩定;情緒有時不穩定;Other(s):".$Q1a."",$Q1,"multi").'</td>
    <td>'.checkbox_result("Q2","給予關心及安撫情緒;給予協助盡快適應機構生活;給予協助上廁所;依需求給予食用家屬帶來的食物;依需求給予使用家屬帶來的用品;Other(s):".$Q2a."",$Q2,"multi").'</td>
    <td>'.checkbox_result("Q3","完成協助生活起居;給予關心及安撫情緒;給予協助盡快適應機構生活;給予協助上廁所;依需求給予食用家屬帶來的食物;依需求給予使用家屬帶來的用品;完成家屬合理交代事項;給予訓練生活自理功能;安排完整的休閒娛樂活動;Other(s):".$Q3a."",$Q3,"multi").'</td>
	<td width="6%"><center><a href="index.php?mod=carework&func=formdelete12&pid='.$_GET['pid'].'&nID='.$nID.'"><img src="Images/delete2.png" border="0" width="30"></a></center></td>
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
</div>