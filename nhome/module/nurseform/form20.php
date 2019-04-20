<h3>Medical examination report</h3>
<table width="100%">
  <tr class="title">
    <td width="10%">檢驗日期</td>
    <td width="80%">Test items</td>
    <td>View</td>
  </tr>
  <?php
  $db1 = new DB;
  $db1->query("SELECT DISTINCT `date` FROM `labpatient` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."'");
  if ($db1->num_rows()==0) {
	  echo '
  <tr>
    <td colspan="3">尚未有檢驗紀錄</td>
  </tr>
	  '."\n";
  } else {
	  for ($i=0;$i<$db1->num_rows();$i++) {
		  $labtest = '';
		  $r1 = $db1->fetch_assoc();
		  $db2 = new DB;
		  $db2->query("SELECT `labID` FROM `labpatient` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."' AND `date`='".$r1['date']."'");
		  for ($j=0;$j<$db2->num_rows();$j++) {
			  $r2 = $db2->fetch_assoc();
			  $db3 = new DB;
			  $db3->query("SELECT `name`, `nickname` FROM `labitem` WHERE `id`='".$r2['labID']."'");
			  $r3 = $db3->fetch_assoc();
			  $labtest .= $r3['name'];
			  if ($r3['nickname']!='') { $labtest .= ' ('.$r3['nickname'].')'; }
			  $labtest .= '、';
		  }
		  $labtest = substr($labtest,0,strlen($labtest)-3);
		  echo '
  <tr>
    <td>'.(substr($r1['date'],0,3)+1911).'/'.substr($r1['date'],3,2).'/'.substr($r1['date'],5,2).'</td>
	<td>'.$labtest.'</td>
	<td><center><a href="index.php?mod=nurseform&func=formview&pid='.@$_GET['pid'].'&id=20_1&date='.$r1['date'].'"><img src="Images/nurseform_icons/notes.png"></a></center></td>
  </tr>
	  '."\n";
      }
  }
  ?>
</table>
</body>
</html>