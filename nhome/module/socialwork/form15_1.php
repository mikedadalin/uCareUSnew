<?php
$db1 = new DB;
$db1->query("SELECT * FROM `socialform15` WHERE `no`='".mysql_real_escape_string($_GET['no'])."' AND `HospNo`='".$HospNo."' AND `date`='".mysql_real_escape_string($_GET['date'])."'");
$r1 = $db1->fetch_assoc();
	foreach ($r1 as $k=>$v) {
		if (substr($k,0,1)=="Q") {
			$arrAnswer = explode("_",$k);
			if (count($arrAnswer)==2) {
				if ($v==1) {
					${$arrAnswer[0]} .= $arrAnswer[1].';';
				}
			} else {
				${$k} = $v;
			}
		}  else {
			${$k} = $v;
		}
	}

if (isset($_POST['savemod'])) {
	foreach ($_POST as $k => $v){
	$db = new DB;
	if($k != "HospNo" && $k != "Qfiller" && $k != "no" && $k!="savemod"){
		$db->query("UPDATE `socialform15` SET `".$k."`='".$v."' WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".mysql_escape_string($_POST['date'])."' AND `no`='".mysql_escape_string($_POST['no'])."';");		
	}
}

	echo "<script>alert('Saved successfully');window.location.href='index.php?mod=socialwork&func=formview&pid=".@$_GET['pid']."&id=15'</script>";
}

?>
<form method="post">
<table>
  <tr>
      <td class="title" width="100">Date</td>
      <td><?php echo formatdate($r1['date']); ?><input type="hidden" name="date" id="date" value="<?php echo $r1['date']; ?>"></td>
  </tr>
    <tr>
        <td class="title">訪談方式</td>
        <td><?php echo draw_option("Q1","電訪;家訪;面談;Other","m","single",$Q1,false,5); ?>&nbsp;<input type="text" name="Q1a" id="Q1a" size="20" value="<?php echo $Q1a?>"></td>
    </tr>
    <tr>
        <td class="title">訪談對象</td>
        <td><?php echo draw_option("Q2","Family;案主;Relative(s);Physician;Nursing;physiotherapist;Nursing assistant;社福機構;慈善單位;居服員;志工;Other","m","multi",$Q2,true,7); ?>&nbsp;<input type="text" name="Q2a" id="Q2a" size="20" value="<?php echo $Q2a; ?>"></td>
    </tr>
    <tr>
        <td class="title">問題分類</td>
        <td><?php echo draw_option("Q3","Emotions;醫療;病況;居家服務;家庭關係;室友關係;關懷慰問;經濟;權益保障;Other","m","multi",$Q3,true,5); ?>&nbsp;<input type="text" name="Q3a" id="Q3a" size="20" value="<?php echo $Q3a;?>"></td>
    </tr>
    <tr>
        <td class="title">Location</td>
        <td><?php echo draw_option("Q4","本中心;案家;Hospital;Other","m","single",$Q4,false,5); ?>&nbsp;<input type="text" name="Q4a" id="Q4a" size="20" value="<?php echo $Q4a;?>"></td>
    </tr>
  <tr>
      <td class="title">Counseling/interaction content</td>
      <td><textarea name="Qinteraction" id="Qinteraction" cols="50" rows="5"><?php echo $r1['Qinteraction']; ?></textarea></td>
  </tr>
  <tr>
      <td class="title">Treatment summary</td>
      <td>
      <textarea name="Qcontent" id="Qcontent" cols="50" rows="5"><?php echo $r1['Qcontent']; ?></textarea>
      <input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
      <input type="hidden" name="Qfiller" id="Qfiller" value="<?php echo $_SESSION['ncareID_lwj']; ?>">
      <input type="hidden" name="no" id="no" value="<?php echo $r1['no']; ?>">
      </td>
  </tr>
  <tr>
    <td colspan="4" class="title_s"><input type="submit" value="Save" name="savemod" ></td>
  </tr>
</table>
</form>