<div style="background-color: rgba(255,255,255,0.8); border-radius: 10px; padding:10px 10px 30px 10px; margin-bottom: 20px;">
<h3>New resident adaptation assessment</h3>
<?php
$url = $_SERVER['PHP_SELF'];
$url = explode(".",$url);
$url = explode("/",$url[0]);
$file = $url[2];

$db1 = new DB;
$db1->query("SELECT `indate` FROM `inpatientinfo` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."'");
$r1 = $db1->fetch_assoc();

$indate = $r1['indate'];
$n2date = date("Ymd",mktime(0,0,0,substr($indate,4,2),substr($indate,6,2)+14,substr($indate,0,4)));;

$db2b = new DB;
$db2b->query("SELECT `Q33_1`, `Q33_2` FROM `socialform06a_2` WHERE `HospNo`='".$HospNo."' ORDER BY `date` DESC LIMIT 0,1");
$r2b = $db2b->fetch_assoc();
if ($r2b['Q33_1']==1) { $n2result = "1"; } elseif ($r2b['Q33_2']==1) { $n2result = "2"; } else { $n2result = "0"; }

?>

<table id="newrecordtable" style="width:100%;">
  <thead>
  <tr class="title">
    <td>&nbsp;</td>
    <td>Date</td>
    <td>Assessment Results</td>
    <td <?php if ($file=="print") echo ' style="display:none;"'; ?>><?php if(substr($_SESSION['ncareID_lwj'],0,8)=="resident"){ echo 'View';}else{ echo 'Edit';}?></td>
  </tr>
  </thead>
  <tbody>
  <tr <?php if ($n2result==0 && $n2date<(date(Ymd)+0)) echo 'class="table_tr_alert"'; ?>>
    <td><center>2 weeks after admission</center></td>
    <td><center><?php echo formatdate($n2date); ?></center></td>
    <td><center><?php echo $arrSocialform06a_Q33[$n2result]; ?></center></td>
    <td <?php if ($file=="print") echo ' style="display:none;"'; ?>><center><form><input type="button" onclick="window.location.href='index.php?mod=socialwork&func=formview&pid=<?php echo @$_GET['pid']; ?>&id=6a&time=2'" value="<?php if(substr($_SESSION['ncareID_lwj'],0,8)=="resident"){ echo 'View';}else{ echo 'Edit';}?>"></form></center></td>
  </tr>
  </tbody>
</table>
</div>