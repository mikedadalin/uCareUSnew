<?php
$db1 = new DB;
$db1->query("SELECT * FROM `socialform17` WHERE `no`='".mysql_real_escape_string($_GET['no'])."' AND `HospNo`='".$HospNo."' AND `date`='".mysql_real_escape_string($_GET['date'])."'");
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
		$db->query("UPDATE `socialform17` SET `".$k."`='".$v."' WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".mysql_escape_string($_POST['date'])."' AND `no`='".mysql_escape_string($_POST['no'])."';");		
	}
}

	echo "<script>alert('Saved successfully');window.location.href='index.php?mod=socialwork&func=formview&pid=".@$_GET['pid']."&id=17'</script>";
}

?>
<form method="post">
<table>
  <tr>
      <td class="title" width="100">Date</td>
      <td><?php echo formatdate($r1['date']); ?><input type="hidden" name="date" id="date" value="<?php echo $r1['date']; ?>"> <?php echo $r1['time']; ?></td>
  </tr>
    <tr>
        <td class="title">服務類別</td>
        <td><?php echo draw_option("Q1","照顧問題;家庭支持;費用問題;節慶活動;問卷填寫;個案就醫;資源協助;諮詢服務;轉介服務;Other","m","multi",$Q1,true,5); ?>&nbsp;<input type="text" name="Q1a" id="Q1a" size="20" value="<?php echo $Q1a; ?>"></td>
    </tr>
    <tr>
        <td class="title">Family</td>
        <td><input type="text" name="Q2" id="Q2" size="20" value="<?php echo $Q2;?>"></td>
    </tr>
    <tr>
        <td class="title">relationship</td>
        <td><input type="text" name="Q3" id="Q3" size="20" value="<?php echo $Q3;?>"></td>
    </tr>
  <tr>
      <td class="title">會談摘要</td>
      <td><textarea name="Qinteraction" id="Qinteraction" cols="50" rows="5"><?php echo $r1['Qinteraction']; ?></textarea></td>
  </tr>
  <tr>
    <td colspan="4" class="title_s"><input type="submit" value="Save" name="savemod" ></td>
  </tr>
</table>
      <input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
      <input type="hidden" name="Qfiller" id="Qfiller" value="<?php echo $_SESSION['ncareID_lwj']; ?>">
      <input type="hidden" name="no" id="no" value="<?php echo $r1['no']; ?>">

</form>