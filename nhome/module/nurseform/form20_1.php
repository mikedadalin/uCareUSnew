<h3>Medical examination report</h3>
<p align="right">報告產生日期：<?php echo substr(@$_GET['date'],0,3)+1911 . '/' . substr(@$_GET['date'],3,2) .'/' . substr(@$_GET['date'],5,2); ?></p>
<table width="100%" style="font-size:10pt;">
  <?php
  $db1 = new DB;
  $db1->query("SELECT * FROM `labpatient` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."' AND `date`='".mysql_escape_string($_GET['date'])."' ORDER BY `labID` ASC");
  for ($i=0;$i<$db1->num_rows();$i++) {
	  $r1 = $db1->fetch_assoc();
	  if ($r1['value']=="") { $value = "N/A"; } else { $value = $r1['value']; }
	  $db2 = new DB;
	  $db2->query("SELECT * FROM `labitem` WHERE `id`='".$r1['labID']."'");
	  $r2 = $db2->fetch_assoc();
	  echo '
  <tr>
    <td class="title" width="80">'.$r2['category'].'</td>
	<td class="title_s" width="160">'.$r2['name']; if ($r2['nickname']!='') { echo ' ('.$r2['nickname'].')'; } echo '</td>
	<td>'.$value.'</td>
  </tr>
	  '."\n";
  }
  ?>
</table>
</body>
</html>