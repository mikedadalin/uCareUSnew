<h3>特殊事件報告單</h3>
<table width="100%">
  <tr class="title_s">
    <td><form><input type="button" value="新增特殊事件" onclick="window.location.href='index.php?mod=nurseform&func=formview&pid=<?php echo mysql_escape_string($_GET['pid'])?>&id=8_1&action=new'" /></form></td>
  </tr>
</table>
<table width="100%">
  <tr class="title">
    <td width="6%">&nbsp;</td>
    <td>發生日期</td>
    <td>事由</td>
    <td>Filled date</td>
    <td>Filled by</td>
    <td>主管意見回覆</td>
    <td width="6%">&nbsp;</td>
  </tr>
<?php
$db = new DB;
$db->query("SELECT * FROM `nurseform08` WHERE `HospNo`='".$HospNo."' ORDER BY `Q1` DESC");
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
	$arrQ2 = array("", "Hospitalization", "離院", "特殊事件", "客訴", "新褥瘡產生", "跌倒", "Other");
	$ansQ2 = getGroupTitle('nurseform08', 'Q2', '_', 6, $r['nID'], "nID", "", "date", "desc");
	if (count($ansQ2)>0) {
		$txtQ2 = "";
		foreach ($ansQ2 as $k1=>$v1) {
			if ($txtQ2!="") { $txtQ2 .= '、'; }
			$txtQ2 .= $arrQ2[$v1];
		}
	}
	echo '
  <tr>
    <td'.($Q5b!=""?' rowspan="2"':"").'><center><a href="index.php?mod=nurseform&func=formview&pid='.mysql_escape_string($_GET['pid']).'&id=8_1&nID='.$nID.'&action=edit"><img src="Images/edit_icon.png" width="30"></a></center></td>
    <td>'.$Q1.'</td>
    <td>'.$txtQ2.'</td>
    <td>'.formatdate($date).'</td>
    <td>'.checkusername($Qfiller).'</td>
	<td>';
	if ($_SESSION['ncareLevel_lwj']>=4) {
		echo '<center><a href="index.php?mod=nurseform&func=formview&pid='.mysql_escape_string($_GET['pid']).'&id=8_2&nID='.$nID.'&action=edit"><i class="fa fa-reply"></i></a></center>';
	}
	echo '</td>
	<td width="6%"'.($Q5b!=""?' rowspan="2"':"").'><center><a href="index.php?mod=nurseform&func=formdelete8&pid='.$_GET['pid'].'&nID='.$nID.'"><img src="Images/delete2.png" border="0" width="30"></a></center></td>
  </tr>'."\n";
  if ($Q5b!="") {
	  echo '
	  <tr>
	    <td colspan="5">主管意見：'.$Q5b.'</td>
	  </tr>
	  '."\n";
  }
  $Q1 = "";
  $Q2 = "";
  $Q3 = "";
  $Q4 = "";
}
?>
</table>