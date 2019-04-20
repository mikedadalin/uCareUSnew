<?php
$targetID = mysql_escape_string($_GET['tID']);
$qdate = mysql_escape_string($_GET['qdate']);
$sMonth = ($qdate == "" ? "" : "&qdate=".$qdate);
if (isset($_POST['submit'])) {
	$formID = $_POST['formID'];

	foreach ($_POST as $k=>$v) {
   if($k!="indate" && $k!="formID" && $k!="submit"){
    $db1 = new DB;
    $db1->query("UPDATE `".$formID."` SET `".mysql_escape_string($k)."`='".mysql_escape_string($v)."' WHERE `targetID`='".$targetID."'");
  }
}	
echo '<script>alert("Modification success!");window.onbeforeunload=null;window.location.href="index.php?mod=management&func=formview&id=3'.$sMonth.'";</script>';
}


$db1 = new DB;
$db1->query("SELECT * FROM `sixtarget_part1` WHERE `targetID`='".$targetID."' AND `HospNo`='".getHospNo(@$_GET['pid'])."'");
$r1 = $db1->fetch_assoc();

foreach ($r1 as $k=>$v) {
	$arrPatientInfo = explode("_",$k);
	if (count($arrPatientInfo)>1) {
		$varname = "";
		for ($i=0;$i<(count($arrPatientInfo)-1);$i++) {
			if ($v==1) {
				if ($varname!="") { $varname .= '_'; }
				$varname .= $arrPatientInfo[$i];
			}
		}
		${$varname} .= $arrPatientInfo[(count($arrPatientInfo)-1)].';';
	} else {
		${$k} = $v;
	}
}
$pid = getPID($HospNo);
?>
<form method="post" onSubmit="return checkThisForm();">
  <div style="background-color: rgba(255,255,255,0.8); border-radius: 10px; padding:20px 10px 30px 10px; margin-bottom: 30px;">
    <h3>Resident transfer to ER</h3>
    <div align="right" id="printbtn"><a href="print.php?<?php echo $_SERVER['QUERY_STRING']; ?>" target="_blank"><img src="Images/print.png" border="0"></a></div>
    <table width="100%">
      <tr>
        <td class="title" width="200px" style="border-top-left-radius:10px;">Full name</td>
        <td><?php echo getBedID($pid).' '.getPatientName($pid); ?></td>
        <td class="title">Care ID#</td>
        <td style="border-top-right-radius:10px;"><?php echo getHospNoDisplayByPID($pid); ?></td>
      </tr>
      <tr>
        <td class="title">Admission date</td>
        <td><input type="text" name="indate" id="indate" value="<?php echo $indate; ?>"></td>
        <td class="title">Previous returned from hospital date(last time)</td>
        <td><input type="text" name="outdate" id="outdate" value="<?php echo $outdate; ?>"></td>
      </tr>
      <tr>
        <td class="title">Transfer/ hospitalized date</td>
        <td><input type="text" name="thisoutdate" id="thisoutdate" value="<?php echo $thisoutdate; ?>" ></td>
        <td class="title">Stay in the facility/center day(s)</td>
        <td><input type="text" name="indays" id="indays" value="<?php echo $indays; ?>" size="3" >Day(s)</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3"><?php echo draw_checkbox("is72hr","Hospitalize within 72hrs after admission",$is72hr,"single"); ?></td>
      </tr>
      <tr>
        <td class="title">Occur shift</td>
        <td colspan="3"><?php echo draw_option("occurence","Graveyard shift;Day shift;Night shift","l","single",$occurence,false,4); ?></td>
      </tr>
      <?php
      $reasonTxt = "Hypotension;Myocardial Infarction;Arrhythmia;Fracture;Gastrorrhagia;Intestinal obstruction;Urinary tract infection;Pneumonia;Septicemia;Electrolyte imbalance;Dyspnea;Asthma;Head injury;Fever;Blood pressure drop;Other";
      ?>
      <tr>
        <td class="title">Hospitalization main<br />diagnosis or reason</td>
        <td colspan="3"><?php echo draw_option("reason",$reasonTxt,"xl","single",$reason,true,3); ?></td>
      </tr>
      <tr>
        <td class="title">Cause analysis</td>
        <td colspan="3"><?php echo draw_option("reasonanalysis","Changes in disease;Unstable condition when admission;Improper care","xxxl","single",$reasonanalysis,false,4); ?></td>
      </tr>
      <tr>
        <td class="title">Results</td>
        <td colspan="3"><?php echo draw_option("result","Returns after treatment;Observing;Hospitalization;Death","xxl","single",$result,true,2); ?></td>
      </tr>
      <tr>
        <td class="title">Category analysis</td>
        <td colspan="3"><?php echo draw_option("resultanalysis","Controllable;Uncontrollable","xm","single",$resultanalysis,false,4); ?></td>
      </tr>
      <tr>
        <td class="title">Returned from hospital date(this time)</td>
        <td><input type="text" name="lastoutdate" id="lastoutdate" value="<?php echo $lastoutdate; ?>"></td>
        <td class="title">Hospitalize days</td>
        <td><input type="text" name="outdays" id="outdays" value="<?php echo $outdays; ?>" size="3">Day(s)</td>
      </tr>
      <tr>
        <td class="title" style="border-bottom-left-radius:10px;">Filled by</td>
        <td colspan="3" style="border-bottom-right-radius:10px;"><?php echo checkusername($Qfiller); ?></td>
      </tr>
    </table>
    <center>
      <div style="margin-top:30px;">
        <input type="hidden" name="formID" id="formID" value="sixtarget_part1" />
        <?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?>
        <input type="hidden" id="submit" value="Save" name="submit" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
        <input type="button" onClick="window.location.href='index.php?mod=management&func=formview&id=3<?php echo $sMonth;?>';" value="Back to list" />
        <?php }?>
      </div>
    </center>

  </form>
</div>
<script>
$(function() { 
	$( "#outdate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); 
	$( "#thisoutdate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); 
	$( "#lastoutdate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); 
});
</script>