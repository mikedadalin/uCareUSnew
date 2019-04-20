<?php
$db1 = new DB;
$db1->query("SELECT * FROM `socialform18` WHERE `no`='".mysql_real_escape_string($_GET['no'])."' AND `HospNo`='".$HospNo."' AND `date`='".mysql_real_escape_string($_GET['date'])."'");
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
		$db->query("UPDATE `socialform18` SET `".$k."`='".$v."' WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".mysql_escape_string($_POST['date'])."' AND `no`='".mysql_escape_string($_POST['no'])."';");		
	}
}

	echo "<script>alert('Saved successfully');window.location.href='index.php?mod=socialwork&func=formview&pid=".@$_GET['pid']."&id=18'</script>";
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
        <td><?php echo draw_option("Q1","例行訪視;評估量表;照顧問題;節慶活動;就醫協助;醫院探訪;個案支持;諮商輔導;適應協助;轉介安置;資源協助;經濟問題;Other","m","multi",$Q1,true,5); ?>&nbsp;<input type="text" name="Q1a" id="Q1a" size="20" value="<?php echo $Q1a; ?>"></td>
    </tr>
    <tr>
        <td class="title">行為觀察</td>
        <td>
            意識：<?php echo draw_option("Q2","Clear;Fair;Poor","m","single",$Q2,false,5); ?><br>
            表達：<?php echo draw_option("Q3","Clear;Fair;Poor","m","single",$Q3,false,5); ?><br>
            行動：<?php echo draw_option("Q4","Clear;Fair;Poor","m","single",$Q4,false,5); ?><br>
            情緒：<?php echo draw_option("Q5","Clear;Fair;Poor","m","single",$Q5,false,5); ?>
        </td>
    </tr>
  <tr>
      <td class="title">Treatment summary</td>
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