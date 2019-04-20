<script>
$(function() {
  $( "#accordion" ).accordion({ collapsible: true });
});
</script>
<?php
if (isset($_POST['submit'])) {
	$qID = $_POST['qID'];
	$date = $_POST['date'];
	$answer = $_POST['answer'];
	$Qfiller = $_SESSION['ncareID_lwj'];
	
	$db3a = new DB;
	$db3a->query("INSERT INTO `medicinea` (`qID`, `date`, `answer`, `Q1a`, `Q1b`, `Q1c`, `Q1d`, `Q1e`, `Qfiller`) VALUES ('".$qID."', '".date("Y/m/d H:i:s")."', '".$answer."', '".mysql_escape_string($_POST['Q1a'])."', '".mysql_escape_string($_POST['Q1b'])."', '".mysql_escape_string($_POST['Q1c'])."', '".mysql_escape_string($_POST['Q1d'])."', '".mysql_escape_string($_POST['Q1e'])."', '".$Qfiller."')");	
	$db3b = new DB;
	$db3b->query("SELECT LAST_INSERT_ID()"); 
 $r3b = $db3b->fetch_assoc();
 $aID = $r3b['LAST_INSERT_ID()'];
 foreach ($_POST as $k=>$v){
   $arrAnswer = explode("_",$k);
   if(count($arrAnswer)==2){
    $db1 = new DB;
    $db1->query("UPDATE `medicinea` SET `".$k."` = '".$v."' WHERE `aID` = '".$aID."'");
  }
}
echo "<script>window.location.href='index.php?mod=nurseform&func=formview&id=17_4&pid=".$_GET['pid']."'</script>";
}

$sql = "SELECT * FROM `medicineq` WHERE `qID`='".mysql_escape_string($_GET['qID'])."'";
if (@$_GET['date']!='') { $sql .= " AND `date`='".mysql_escape_string($_GET['date'])."'"; }
$sql .= " ORDER BY `date` DESC LIMIT 0,1";
$db1 = new DB;
$db1->query($sql);
$r1 = $db1->fetch_assoc();
if ($db1->num_rows()>0) {
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
}
?>
<h3>藥物諮詢回覆</h3>
<div id="accordion" style="width:93%;">
  <h3>Current medication</h3>
  <div>
    <table style="width:100%; font-size:11pt;">
      <tr class="title">
        <td>Date</td>
        <td>Time</td>
        <td>Medication</td>
        <td>Dose</td>
        <td>Frequency</td>
        <td>Pathway</td>
      </tr>
      <?php
      $db = new DB;$db->query("SELECT * FROM `nurseform17` WHERE `HospNo`='".$HospNo."' ORDER BY `order` ASC");
      for ($j=1;$j<=$db->num_rows();$j++) {
        $r = $db->fetch_assoc();
        foreach ($r as $k=>$v) { ${$k} = $v; }
        echo '
        <tr>
        <td align="center">'.$Qstartdate.'~'.$Qenddate.' ('.calcperiod(str_replace('/','',$Qstartdate),str_replace('/','',$Qenddate)).'Day(s))</td>
        <td align="center">';
        $Qtime = explode(";",$Qmedtime);
        for ($i=0;$i<count($Qtime);$i++) {
          if ($Qtime[$i]!="") {
            if (strlen($Qtime[$i])==1) {
              $Time = "0".$Qtime[$i].":00";
            } else {
              $Time = $Qtime[$i].":00";
            }
            echo $Time;
            if ($i<(count($Qtime)-2)) {
              echo ' / ';
            }
          }
        }
        echo '</td>
        <td align="center">'.$Qmedicine.' ('.$Qdose.$Qdoseq.')</td>
        <td align="center">'.$Qusage.'</td>
        <td align="center">'.$Qfreq.'</td>
        <td align="center">'.$Qway.'</td>
        </tr>'."\n";
      }
      ?>

    </table>
  </div>
</div>
<form  method="post" onSubmit="return checkForm();">
  <table width="100%" border="0">
    <tr>
      <td class="title" colspan="2">諮詢回覆</td>
    </tr>
    <tr>
      <td class="title_s" width="100">藥物諮詢</td>
      <td>
        <table style="width:100%;">
          <tr>
            <td align="center" style="width:150px; background-color:#f0f0f0;">藥品名稱</td>
            <td style="color:#f33548; background-color:#f0f0f0; font-weight:bold;"><?php echo $Qmedicine; ?></td>
          </tr>
          <tr>
            <td align="center" style="background-color:#f0f0f0;">藥物治療問題</td>
            <td style="background-color:#f0f0f0;"><?php echo checkbox_result("Q1","No indications;Have untreated disease(s);Contraindications or precautions;Formulations / dosage or frequency need to adjust;Drug-drug interaction;Repeated drug;Adverse drug reactions;Inappropriate treatment;Drugs health education;Drug expired",$Q1,"multi"); ?>
                <?php echo checkbox_result("Q2","Incorrect administration time (interval, before/after meal);Fail to comply with the special administration instructions (with food, flour, mix, open capsules, with one other solution);Drug dose to inappropriate (excessive or insufficient)",$Q2,"multi");?><br>
                <?php echo checkbox_result("Q3","Other(s):",$Q3,"multi");?><?php echo $Q3a?></td>
          </tr>
          <tr>
            <td align="center" style="background-color:#f0f0f0;">問題治療來源</td>
            <td style="background-color:#f0f0f0;"><?php echo checkbox_result("Q4","藥師親自到訪;Phone;e-mail;傳真",$Q4,"multi");?></td>
          </tr>
          <tr>
            <td align="center" style="background-color:#f0f0f0;">問題敘述</td>
            <td style="background-color:#f0f0f0;"><?php echo $question; ?></td>
          </tr>
        </table>
      <!--
        藥品名稱：<span style="color:#f33548; font-size:22px; font-weight:bold;"><?php echo $Qmedicine; ?></span><br>
        藥物治療問題：<br>
        <div style="margin-left:60px;">
          <?php echo checkbox_result("Q1","No indications;Have untreated disease(s);Contraindications or precautions;Formulations / dosage or frequency need to adjust;Drug-drug interaction;Repeated drug;Adverse drug reactions;Inappropriate treatment;Drugs health education;Drug expired",$Q1,"multi"); ?>
          <?php echo checkbox_result("Q2","Incorrect administration time (interval, before/after meal);Fail to comply with the special administration instructions (with food, flour, mix, open capsules, with one other solution);Drug dose to inappropriate (excessive or insufficient)",$Q2,"multi");?><br>
          <?php echo checkbox_result("Q3","Other(s):",$Q3,"multi");?><?php echo $Q3a?>
        </div><br>
        問題治療來源：<br><div style="margin-left:60px;"><?php echo checkbox_result("Q4","藥師親自到訪;Phone;e-mail;傳真",$Q4,"multi");?></div><br>
        問題敘述：<br><div style="margin-left:60px;"><?php echo $question; ?></div>
      -->
      </td>
    </tr>
    <tr>
      <td  class="title_s" width="100">提問者</td>
      <td><?php echo checkusername($r1['Qfiller']); ?>
      </td>
    </tr>
    <tr>
      <td  class="title_s" width="100">Advice</td>
      <td>
        <?php echo draw_checkbox("Q1","會診醫師更改藥物劑量或頻次：<input type=\"text\" id=\"Q1a\" name=\"Q1a\">;會診醫師更改藥物或劑型：<input type=\"text\" id=\"Q1b\" name=\"Q1b\">;會診醫師停藥或改其他藥：<input type=\"text\" id=\"Q1c\" name=\"Q1c\">;進行藥物血中濃度監測：<input type=\"text\" id=\"Q1d\" name=\"Q1d\">;繼續維持目前用藥情形;住民服藥應注意事項：<input type=\"text\" id=\"Q1e\" name=\"Q1e\" ","","multi");?><br>
        References:
        <br>
        <?php echo draw_checkbox_nobr("Q2","仿單;藥品手冊;參考書籍(或文獻)：","","multi");?>
        <br>
        <textarea name="answer"  cols="60" rows="5" id="answer"><?php echo $answer; ?></textarea>
      </td>
    </tr>
    <tr>
      <td  class="title_s" width="100">Filled by</td>
      <td><?php echo checkusername($_SESSION['ncareID_lwj']); ?>
      </td>
    </tr>
  </table>
  <center>
    <div style="margin-top:20px;">
      <input type="hidden" name="formID" id="formID" value="socialform10b_1" />
      <input type="hidden" name="qID" id="qID" value="<?php echo $_GET['qID']; ?>" />
      <input type="button" name="back" onClick="history.go(-1);" value="Back">
      <input type="submit" id="submit" name="submit" value="Save" />
    </div>
  </center>
</form>