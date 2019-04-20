<h3>Resident's dialysis record</h3>
<?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?>
<div align="left">
  <form><input type="button" value="Add new dialysis record" onclick="window.location.href='index.php?mod=nurseform&func=formview&pid=<?php echo mysql_escape_string($_GET['pid'])?>&id=19_1&action=new'" /></form>
</div>
<?php }?>
<table width="100%">
  <tr class="title">
    <td width="6%">&nbsp;</td>
    <td>Date</td>
    <td>Weight before dialysis</td>
    <td>Blood pressure before dialysis</td>
    <td>Weight after dialysis</td>
    <td>Blood pressure after dialysis</td>
    <td>Dehydration</td>
	<?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?>
    <td width="6%">&nbsp;</td>
	<?php }?>
  </tr>
<?php
$db = new DB;
$db->query("SELECT * FROM `nurseform19` WHERE `HospNo`='".$HospNo."' ORDER BY `Q1` DESC");
for ($j=0;$j<$db->num_rows();$j++) {
	$r = $db->fetch_assoc();
	$Q2 = "";
	$Q4 = "";
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
	$Q2 = explode(';',$Q2);
	$Q4 = explode(';',$Q4);
	echo '
  <tr>';
	if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){
	  echo '<td><center><a href="index.php?mod=nurseform&func=formview&pid='.mysql_escape_string($_GET['pid']).'&id=19_1&nID='.$nID.'&action=edit"><img src="Images/edit_icon.png" width="30"></a></center></td>';
    }else{
	  echo '<td><center><a href="index.php?mod=nurseform&func=formview&pid='.mysql_escape_string($_GET['pid']).'&id=19_1&nID='.$nID.'&action=edit"><img src="Images/MDSview.png" width="80%"></a></center></td>';
	}
	echo '
	<td><center>'.$Q0.'</center></td>
    <td><center>'.$Q1.' Kilogram</center></td>
    <td><center>'.$Q2a.'/'.$Q2b.' mmHg</center></td>
    <td><center>'.$Q3.' Kilogram</center></td>
    <td><center>'.$Q4a.'/'.$Q4b.' mmHg</center></td>
    <td><center>'.$Q5.' Kilogram</center></td>';
	if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){
	  echo '<td width="6%"><center><a href="index.php?mod=nurseform&func=formdelete19&pid='.$_GET['pid'].'&nID='.$nID.'"><img src="Images/delete2.png" border="0" width="30"></a></center></td>';
    }
	echo '
  </tr>'."\n";
  $Q0 = "";
  $Q1 = "";
  $Q2a = "";
  $Q2b = "";
  $Q3 = "";
  $Q4a = "";
  $Q4b = "";
  $Q5 = "";
}
?>
</table>