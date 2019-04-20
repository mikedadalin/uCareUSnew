<h3>Medical examination report</h3>
<script>
$(function() {
	$( "#tabs" ).tabs(<?php if ($_GET['view']!="") { echo '{ active: '.$_GET['view'].' }'; } ?>);
});
</script>
<div id="tabs">
  <ul class="printcol">
    <li><a href="#tabs-1">Examination report</a></li>
    <li><a href="#tabs-2">Input examination value</a></li>
  </ul>
  <div id="tabs-1" style="padding:1px; font-size:11pt;">
<?php
$db = new DB;
$db->query("SELECT DISTINCT `date` FROM `labpatient` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."' ORDER BY `date` ASC LIMIT 0,8");
$arrLabDate = array();
$arrLabItem = array();
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	array_push($arrLabDate,$r['date']);
	$db1 = new DB;
	$db1->query("SELECT `labID` FROM `labpatient` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."' AND `date`='".$r['date']."'");
	for ($j=0;$j<$db1->num_rows();$j++) {
		$r1 = $db1->fetch_assoc();
		array_push($arrLabItem,$r1['labID']);
	}
}
$arrLabItem = array_unique($arrLabItem);
asort($arrLabItem);
$arrLabItem = array_values($arrLabItem);
//print_r($arrLabDate); echo "<br>"; print_r($arrLabItem);
?>
<table style="font-size:10pt;" width="100%">
  <tr class="title" height="45">
    <td width="180">Item(s)</td>
    <?php
	for ($i=0;$i<count($arrLabDate);$i++) {
		echo '<td align="center">'.formatdate($arrLabDate[$i]).'</td>';
	}
	?>
    <td width="120" align="center">Reference value</td>
  </tr>
  <?php
  for ($i=0;$i<count($arrLabItem);$i++) {
	  $db2 = new DB;
	  $db2->query("SELECT `name`, `nickname` FROM `labitem` WHERE `id`='".$arrLabItem[$i]."'");
	  $r2 =$db2->fetch_assoc();
	  echo '<tr height="45">';
	  echo '<td class="title_s">'.$r2['name']; if ($r2['nickname']!='') { echo '<br>('.$r2['nickname'].')'; } echo '</td>';
	  for ($j=0;$j<count($arrLabDate);$j++) {
		  $db3 = new DB;
		  $db3->query("SELECT `value` FROM `labpatient` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."' AND `date`='".$arrLabDate[$j]."' AND `labID`='".$arrLabItem[$i]."'");
		  $r3 = $db3->fetch_assoc();
		  echo '<td ';
		  //檢查是否異常值
		  $db5 = new DB;
		  $db5->query("SELECT * FROM `labrange` WHERE `labID`='".$arrLabItem[$i]."'");
		  if ($db5->num_rows()>0) {
			  $nrange = '';
			  $r5 = $db5->fetch_assoc();
			  
			  if (checkgender(mysql_escape_string($_GET['pid']))=='Male') {
				  $rangeL = $r5['MrangeL'];
				  $rangeH = $r5['MrangeH'];
				  $abnormal1 = $r5['abnormal'];
				  $abnormal2 = explode(';',$r5['abnormal']);
				  $abnormaltxt = str_replace(';','、',$r5['abnormal']);
			  } elseif (checkgender(mysql_escape_string($_GET['pid']))=='Female') {
				  $rangeL = $r5['FrangeL'];
				  $rangeH = $r5['FrangeH'];
				  $abnormal1 = $r5['abnormal'];
				  $abnormal2 = explode(';',$r5['abnormal']);
				  $abnormaltxt = str_replace(';','、',$r5['abnormal']);
			  }
			  
			  if ($r5['type']==1) {
				  //上下限
				  if ($r3['value']<$rangeL) { echo 'class="rangeL"'; } //過低
				  elseif ($r3['value']>$rangeH) { echo 'class="rangeH"'; } //過高
				  else { echo 'style="color:#000;"'; } //Normal
				  $nrange = $rangeL .'~'. $rangeH;
			  } elseif ($r5['type']==2) {
				  //Single comparison value
				  if ($r3['value']<$abnormal1) { echo 'class="rangeH"'; } //比比對值則顯示紅色
				  else { echo 'style="color:#000;"'; } //Normal
				  $nrange = $abnormaltxt;
			  } elseif ($r5['type']==3) {
				  //文字
				  if (!in_array(trim($r3['value']),$abnormal2)) { echo 'class="rangeH"'; }
				  else { echo 'style="color:#000;"'; } //Normal
				  $nrange = $abnormaltxt;
			  } else {
				  echo 'style="color:#000;"';
			  }
		  } else {
			  $nrange = '';
		  }
		  echo '><center>'.($r3['value']!=""?$r3['value']:"").'</center></td>';
	  }
	  echo '<td class="title_s"><center>'.$nrange.'</center></td>';
	  echo '</tr>';
  }
  ?>
</table>
  </div>
  <div id="tabs-2">
    <h3>Input examination value</h3>
    <form>
    Select package:<select id="set" onchange="window.location.href='index.php?mod=nurseform&func=formview&id=20_2&pid=<?php echo @$_GET['pid']; ?>&view=1&set='+this.options[this.selectedIndex].value">
    <option>(All items)</option>
    <?php
	$db4a = new DB;
	$db4a->query("SELECT DISTINCT `setID` FROM `labset` ORDER BY `setID` DESC");
	for ($i4a=0;$i4a<$db4a->num_rows();$i4a++) {
		$r4a = $db4a->fetch_assoc();
		$db4b = new DB;
		$db4b->query("SELECT * FROM `labset` WHERE `setID`='".$r4a['setID']."'");
		$r4b = $db4b->fetch_assoc();
		echo '
		<option value="'.$r4a['setID'].'" '.($_GET['set']==$r4a['setID']?'selected':'').'>'.$r4b['description'].'</option>
		';
	}
	?>
    </select>
    </form>
    <?php
	if (isset($_POST['submit'])) {
		$arrSubmit = array_pop($_POST);
		$date = str_replace("/","",$_POST['date']);
		$arrSubmit = array_pop($_POST);
		//print_r($_POST);
		$arrError = array();
		foreach ($_POST as $k=>$v) {
			if ($v!="") {
				$labIDtow = explode("_",$k);
				$db4e = new DB;
				$db4e->query("SELECT * FROM `labpatient` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."' AND `date`='".$date."' AND `labID`='".$labIDtow[1]."'");
				if ($db4e->num_rows()==0) {
					$db4 = new DB;
					$db4->query("INSERT INTO `labpatient` VALUES ('".mysql_escape_string($_GET['pid'])."', '".$date."', '".$labIDtow[1]."', '".$v."', '".$_SESSION['ncareID_lwj']."')");
				} else {
					$arrError[$labIDtow[1]] = $v;
				}
			}
		}
		if (count($arrError)==0) {
		?>
			<script>window.location.href='index.php?mod=nurseform&func=formview&id=20_2&pid=<?php echo @$_GET['pid']; ?>'</script>
        <?php
		} else {
			echo '<h3><span style="color:#f00;">下列項目重複輸入，請修改日期！</span></h3>';
		}
	}
	if ($_GET['set']!=NULL) {
		$db4c = new DB;
		$db4c->query("SELECT * FROM `labset` WHERE `setID`='".mysql_escape_string($_GET['set'])."'");
	?>
    <form method="post" action="index.php?mod=nurseform&func=formview&id=20_2&pid=<?php echo @$_GET['pid']; ?>&view=<?php echo @$_GET['view']; ?>&set=<?php echo @$_GET['set']; ?>" onsubmit="return checkForm();">
    <table class="tableinside">
      <tr class="title">
        <td>Item(s)</td>
        <td>Value(s)</td>
        <td>Item(s)</td>
        <td>Value(s)</td>
      </tr>
        <?php
		for ($i4c=1;$i4c<=$db4c->num_rows();$i4c++) {
			$r4c = $db4c->fetch_assoc();
			$db4d = new DB;
			$db4d->query("SELECT * FROM `labitem` WHERE `id`='".$r4c['labID']."' ORDER BY `id`;");
			$r4d = $db4d->fetch_assoc();
			if ($i4c%2!=0) { echo '<tr>'; }
			echo '
			<td>'.$r4d['name'].' '.$r4d['nickname'].'</td>
			<td'.($i4c%2!=0 && $i4c==$db4c->num_rows()?" colspan='3'":"").'><input type="text" name="labID_'.$r4c['labID'].'" id="labID_'.$r4c['labID'].'" size="12" value="'.$arrError[$r4c['labID']].'" ></td>
			';
			if ($i4c==0 || $i4c%2==0) { echo '</tr>'; }
		}
		?>
      <tr>
        <td class="title_s">Date</td>
        <td colspan="3"><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" size="20" /></td>
      </tr>
    </table>
    <center><input type="hidden" name="submit" value="Save" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></center>
    </form>
    <?php
	} else {
		//全部項目都可key
		$db4c = new DB;
		$db4c->query("SELECT * FROM `labitem` ORDER BY `category`, `id`");
	?>
    <form method="post" action="index.php?mod=nurseform&func=formview&id=20_2&pid=<?php echo @$_GET['pid']; ?>&view=<?php echo @$_GET['view']; ?>&set=<?php echo @$_GET['set']; ?>" onsubmit="return checkForm();">
    <table class="tableinside">
      <tr class="title">
        <td>Item(s)</td>
        <td>Value(s)</td>
        <td>Item(s)</td>
        <td>Value(s)</td>
      </tr>
        <?php
		for ($i4c=1;$i4c<=$db4c->num_rows();$i4c++) {
			$r4c = $db4c->fetch_assoc();
			$db4d = new DB;
			$db4d->query("SELECT * FROM `labitem` WHERE `id`='".$r4c['id']."';");
			$r4d = $db4d->fetch_assoc();
			if ($i4c%2!=0) { echo '<tr>'; }
			echo '
			<td>'.$r4d['name'].' '.$r4d['nickname'].'</td>
			<td'.($i4c%2!=0 && $i4c==$db4c->num_rows()?" colspan='3'":"").'><input type="text" name="labID_'.$r4c['id'].'" id="labID_'.$r4c['id'].'" size="12" value="'.$arrError[$r4c['id']].'" ></td>
			';
			if ($i4c==0 || $i4c%2==0) { echo '</tr>'; }
		}
		?>
      <tr>
        <td class="title_s">Examination date</td>
        <td colspan="3"><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" size="20" /></td>
      </tr>
    </table>
    <center><input type="hidden" name="submit" value="Save" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></center>
    </form>
    <?php
	}
	?>
  </div>
</div><br>
</body>
</html>
