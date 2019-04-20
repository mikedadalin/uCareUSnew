<div class="moduleNoTab">
<h3>Nursing diagnosis list</h3>
<?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?>
<table width="100%">
  <tr class="title_s">
    <td align="left">
      <form action="index.php?func=database&action=save">
        Add nursing diagnoses:
        <select name="formid" id="formid">
          <?php
		  foreach ($arrNursediag as $k=>$v) {
			  echo '<option value="'.$k.'">'.$k.'# '.$v.'</option>';
		  }
		  ?>
        </select>
        <input type="button" value="Add" onclick="newdiag();" />
        <script>
		function padLeft(str,lenght){ if(str.length >= lenght) return str; else return padLeft("0" +str,lenght); }
		function newdiag() {
			var id = document.getElementById('formid').selectedIndex;
			id = id+1;
			var idno = id.toString();
			idno = padLeft(idno,2);
			window.location.href = 'index.php?mod=nursediag&func=formview&pid=<?php echo mysql_escape_string($_GET['pid']); ?>&id='+idno;
		}
		</script>
      </form>
    </td>
  </tr>
</table>
<?php }?>
<form>
<table width="100%">
  <tr class="title">
    <td colspan="8">Active diagnosis</td>
  </tr>
  <tr class="title">
    <td>&nbsp;</td>
    <td>Nursing diagnosis</td>
    <td>Start date</td>
    <td>Staff</td>
    <!--<td>評值</td>-->
    <td>Date of last assessment</td>
    <td>Evaluators</td>
	<?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?>
    <td>Deactivate diagnosis</td>
    <td>Delete</td>
	<?php }?>
  </tr>
  <?php
  $db0 = new DB;
  $db0->query("SELECT `HospNo` FROM `patient` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."'");
  $r0 = $db0->fetch_assoc();
  $arrDiag = array();
  for ($i=1;$i<=count($arrNursediag);$i++) {
	  if (strlen($i)==1) { $idno = '0'.$i; } else { $idno = $i; }
	  $dbc = new DB;
	  $dbc->query("UPDATE `nursediag".$idno."` SET `Q2`='' WHERE `Q2`='____/__/__'");
	  $db = new DB;
	  $db->query("SELECT * FROM `nursediag".$idno."` WHERE `HospNo`='".$r0['HospNo']."' AND `Q2`='' ORDER BY `date` DESC");
	  for ($j=1;$j<=$db->num_rows();$j++) {
		  $r = $db->fetch_assoc();
		  $db1 = new DB;
		  $db1->query("SELECT `assessdate`, `Qfiller` FROM `nursediagassess` WHERE `HospNo`='".$r0['HospNo']."' AND `date`='".$r['Q1']."' AND `diagno`='".$idno."' ORDER BY `assessdate` DESC LIMIT 0,1");
		  $r1 = $db1->fetch_assoc();
		  //0=>護理診斷號碼; 1=>Start date; 2=>Filled by; 3=>Evaluation date; 4=>Evaluators
		  $arrDiag[$r['date'].$idno] = $i.";".$r['Q1'].";".$r['Qfiller'].";".$r1['assessdate'].";".$r1['Qfiller'];
		  //echo "SELECT `assessdate`, `Qfiller` FROM `nursediagassess` WHERE `HospNo`='".$r0['HospNo']."' AND `date`='".$r['Q1']."' AND `diagno`='".$idno."' ORDER BY `assessdate` DESC LIMIT 0,1";
	  }
  }
  ksort($arrDiag);
  foreach ($arrDiag as $k=>$v) {
	  $diaginfo = explode(';',$v);
  ?>
  <tr>
    <td width="6%">
	<?php if(substr($_SESSION['ncareID_lwj'],0,8)=="resident"){?>
    <center><a href="index.php?mod=nursediag&func=formview&pid=<?php echo mysql_escape_string($_GET['pid']); ?>&id=<?php if (strlen($diaginfo[0])==1) { echo "0"; } echo $diaginfo[0]; ?>&date=<?php echo substr($k,0,8); ?>"><img src="Images/MDSview.png" width="80%" border="0"></a></center>
    <?php }else{?>
	<center><a href="index.php?mod=nursediag&func=formview&pid=<?php echo mysql_escape_string($_GET['pid']); ?>&id=<?php if (strlen($diaginfo[0])==1) { echo "0"; } echo $diaginfo[0]; ?>&date=<?php echo substr($k,0,8); ?>"><img src="Images/edit_icon.png" width="24" border="0"></a></center>
	<?php }?>
	</td>
    <td><?php echo $diaginfo[0]; ?># <?php echo $arrNursediag[$diaginfo[0]]; ?><input type="hidden" id="diagNo<?php echo $k; ?>" value="<?php echo $diaginfo[0]; ?># <?php echo $arrNursediag[$diaginfo[0]]; ?>"></td>
    <td><?php echo $diaginfo[1]; ?></td>
    <td><?php echo checkusername($diaginfo[2]); ?></td>
    <?php /*<td><center><a href="index.php?mod=nursediag&func=formview&pid=<?php echo mysql_escape_string($_GET['pid']); ?>&id=assess&idno=<?php if (strlen($diaginfo[0])==1) { echo "0"; } echo $diaginfo[0]; ?>&date=<?php echo substr($k,0,8); ?>"><img src="Images/edit_icon.png" border="0" width="16" height="16"></a></center></td>*/ ?>
    <td><?php if ($diaginfo[3]!="") { echo formatdate($diaginfo[3]); } ?></td>
    <td><?php echo checkusername($diaginfo[4]); ?></td>
	<?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?>
    <td align="center">
    <!--結束診斷-->
    <input type="button" onclick="if (confirm('確定結束此診斷「'+$('#diagNo<?php echo $k; ?>').val()+'」？')) { window.location.href='index.php?mod=nursediag&func=formend&pid=<?php echo mysql_escape_string($_GET['pid']); ?>&id=<?php if (strlen($diaginfo[0])==1) { echo "0"; } echo $diaginfo[0]; ?>&date=<?php echo substr($k,0,8); ?>'; } else { return false; }" value="Deactivate">
    </td>
    <td width="6%">
    <?php
	if ($_SESSION['ncareLevel_lwj']>=4 || $diaginfo[2]==$_SESSION['ncareID_lwj']) {
	?>
    <center><a href="index.php?mod=nursediag&func=formdelete&pid=<?php echo mysql_escape_string($_GET['pid']); ?>&id=<?php if (strlen($diaginfo[0])==1) { echo "0"; } echo $diaginfo[0]; ?>&date=<?php echo substr($k,0,8); ?>"><img src="Images/delete2.png" border="0"></a></center>
    <?php
	} else { echo '&nbsp;'; }
	?>
    </td>
	<?php }?>
  </tr>
  <?php
  }
  ?>
</table>
</form>
<hr />
<form>
<table width="100%">
  <tr class="title">
    <td colspan="8">Deactivated diagnosis</td>
  </tr>
  <tr class="title">
    <td>&nbsp;</td>
    <td>Nursing diagnosis</td>
    <td>Start date</td>
    <td>Staff</td>
    <td>Deactivated date</td>
    <td>Staff</td>
	<?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?>
    <td>Activate diagnosis</td>
    <td>Delete</td>
	<?php }?>
  </tr>
  <?php
  $db0 = new DB;
  $db0->query("SELECT `HospNo` FROM `patient` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."'");
  $r0 = $db0->fetch_assoc();
  $arrDiag = array();
  for ($i=1;$i<=count($arrNursediag);$i++) {
	  if (strlen($i)==1) { $idno = '0'.$i; } else { $idno = $i; }
	  $db = new DB;
	  $db->query("SELECT * FROM `nursediag".$idno."` WHERE `HospNo`='".$r0['HospNo']."' AND `Q2`!='' AND `Q2`!='____/__/__' ORDER BY `date` DESC");
	  for ($j=1;$j<=$db->num_rows();$j++) {
		  $r = $db->fetch_assoc();
		  //0=>護理診斷號碼; 1=>Start date; 2=>Filled by; 3=>End date; 4=>結束人員
		  $arrDiag[$r['date'].$idno] = $i.";".$r['Q1'].";".$r['Qfiller'].";".$r['Q2'].";".$r['Qrater_end'];
	  }
  }
  ksort($arrDiag);
  foreach ($arrDiag as $k=>$v) {
	  $diaginfo = explode(';',$v);
  ?>
  <tr>
	<?php if(substr($_SESSION['ncareID_lwj'],0,8)=="resident"){?>
    <td width="6%"><center><a href="index.php?mod=nursediag&func=formview&pid=<?php echo mysql_escape_string($_GET['pid']); ?>&id=<?php if (strlen($diaginfo[0])==1) { echo "0"; } echo $diaginfo[0]; ?>&date=<?php echo substr($k,0,8); ?>"><img src="Images/MDSview.png" width="80%" border="0"></a></center></td>
    <?php }else{?>
	<td width="6%"><center><a href="index.php?mod=nursediag&func=formview&pid=<?php echo mysql_escape_string($_GET['pid']); ?>&id=<?php if (strlen($diaginfo[0])==1) { echo "0"; } echo $diaginfo[0]; ?>&date=<?php echo substr($k,0,8); ?>"><img src="Images/edit_icon.png" width="24" border="0"></a></center></td>
	<?php }?>
    <td><?php echo $diaginfo[0]; ?># <?php echo $arrNursediag[$diaginfo[0]]; ?><input type="hidden" id="diagNo<?php echo $k; ?>" value="<?php echo $diaginfo[0]; ?># <?php echo $arrNursediag[$diaginfo[0]]; ?>"></td>
    <td><?php echo $diaginfo[1]; ?></td>
    <td><?php echo checkusername($diaginfo[2]); ?></td>
    <td><?php if ($diaginfo[3]!="") { echo $diaginfo[3]; } ?></td>
    <td><?php echo checkusername($diaginfo[4]); ?></td>
    <?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?>
	<td>
    <?php
	if ($_SESSION['ncareLevel_lwj']>=4 || $diaginfo[2]==$_SESSION['ncareID_lwj']) {
	?>
    <center><input type="button" onclick="if (confirm('Confirm activating「'+$('#diagNo<?php echo $k; ?>').val()+'」？')) { window.location.href='index.php?mod=nursediag&func=formrecover&pid=<?php echo mysql_escape_string($_GET['pid']); ?>&id=<?php if (strlen($diaginfo[0])==1) { echo "0"; } echo $diaginfo[0]; ?>&date=<?php echo substr($k,0,8); ?>'; } else { return false; }" value="Activate diagnosis"></center>
    <?php
	} else { echo '&nbsp;'; }
	?>
    </td>
    <td width="6%">
    <?php
	if ($_SESSION['ncareLevel_lwj']>=4 || $diaginfo[2]==$_SESSION['ncareID_lwj']) {
	?>
    <center><a href="index.php?mod=nursediag&func=formdelete&pid=<?php echo mysql_escape_string($_GET['pid']); ?>&id=<?php if (strlen($diaginfo[0])==1) { echo "0"; } echo $diaginfo[0]; ?>&date=<?php echo substr($k,0,8); ?>"><img src="Images/delete2.png" border="0"></a></center>
    <?php
	} else { echo '&nbsp;'; }
	?>
    </td>
	<?php }?>
  </tr>
  <?php
  }
  ?>
</table>
</form>
<hr />
<form>
<?php
$db2 = new DB;
$db2->query("SELECT `Qdiag1`, `Qdiag2`, `Qdiag3`, `Qdiag4`, `Qdiag5`, `Qdiag6`, `Qdiag7`, `Qdiag8` FROM `nurseform01` WHERE `HospNo`='".getHospNo(@$_GET['pid'])."'");
$r2 = $db2->fetch_assoc();
$arrDiagList = array();
if ($r2['Qdiag1']!="") { array_push($arrDiagList, $r2['Qdiag1']); }
if ($r2['Qdiag2']!="") { array_push($arrDiagList, $r2['Qdiag2']); }
if ($r2['Qdiag3']!="") { array_push($arrDiagList, $r2['Qdiag3']); }
if ($r2['Qdiag4']!="") { array_push($arrDiagList, $r2['Qdiag4']); }
if ($r2['Qdiag5']!="") { array_push($arrDiagList, $r2['Qdiag5']); }
if ($r2['Qdiag6']!="") { array_push($arrDiagList, $r2['Qdiag6']); }
if ($r2['Qdiag7']!="") { array_push($arrDiagList, $r2['Qdiag7']); }
if ($r2['Qdiag8']!="") { array_push($arrDiagList, $r2['Qdiag8']); }
?>
<table width="100%">
  <tr class="title">
    <td colspan="3">Suggested nursing diagnosis</td>
  </tr>
  <tr class="title">
    <td>Nursing diagnosis</td>
    <td>Been applied</td>
    <td>Add</td>
  </tr>
  <?php
  $arrNDList = array();
  foreach ($arrDiagList as $k1=>$v1) {
	  $suggestDiag = smartDiag($v1, $arrNursediag);
	  foreach ($suggestDiag as $k2=>$v2) {
		  $arrND = explode(";",$v2);
		  foreach ($arrND as $k3=>$v3) {
			  $arrNDname = explode(":",$v3);
			  if ($arrNDname[0]!="") { $arrNDList[$arrNDname[0]] += $arrNDname[1]; }
		  }
	  }
  }
  arsort($arrNDList);
  foreach ($arrNDList as $k1=>$v1) {
  ?>
  <tr>
    <td><?php echo '#'.$k1.' '.$arrNursediag[$k1]; ?></td>
    <td><?php echo $v1; ?></td>
    <td><a href="index.php?mod=nursediag&func=formview&pid=<?php echo mysql_escape_string($_GET['pid']); ?>&id=<?php echo $k1 ?>">Add</a></td>
  </tr>
  <?php
  }
  ?>
</table>
</form>
</div>