<?php
session_start();
include("lwj/lwj.php");
include("class/DB.php");
include("class/DB2.php");
include("class/error.php");
include("class/array.php");
include("class/functionforprint.php");
if ($_SESSION['ncareID_lwj']==NULL) {
	$QR_URL = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$QR_URL = str_replace("&","_TWNo1_",$QR_URL);
	echo "<script>alert('Please log in again!'); window.location.href='logout.php?QR_URL=".$QR_URL."';</script>"; 
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="expires" content="0">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="Images/mainLogo.png"></link>
<title>U-ARK America UCare System</title>
<script type="text/javascript" src="js/flot/jquery.js"></script>
<script type="text/javascript" src="js/jquery-latest.pack.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.0.custom.js"></script>
<script type="text/javascript" src="js/custom-form-elements.js"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/flot/excanvas.min.js"></script><![endif]-->
<script type="text/javascript" src="js/flot/excanvas.js"></script>
<script type="text/javascript" src="js/flot/jquery.flot.js"></script>
<script type="text/javascript" src="js/flot/jquery.flot.navigate.js"></script>
<script type="text/javascript" src="js/flot/jquery.flot.crosshair.js"></script>
<script type="text/javascript" src="js/flot/jquery.flot.pie.js"></script>
<!--<link type="text/css" rel="stylesheet" href="css/printstyle.css" />-->
<script>
if(navigator.appName.indexOf("Internet Explorer")!=-1)document.onmousedown=noSourceExplorer;function noSourceExplorer(){if(event.button==2|event.button==3){}}function NoRightClick(evnt){if(navigator.appName.toUpperCase().match(/NETSCAPE/)!=null){if(evnt.which==3){return false}}else if(event.button==2){}}document.onmousedown=NoRightClick;$(document).ready(function(){$("form :input").attr("readonly",true);$("textarea").css("border","none");$("#submit").hide();$("input[type=button]").hide();$("input[type=image]").hide();$("#backbtn").hide();$("#printbtn").hide();$("option:selected").each(function(){var $this=$(this);var id=$(this).parent().attr('id');if($this.length){var selText=$this.text();$('#'+id).replaceWith(''+selText+'')}})});
</script>
<style>
body { padding:0; margin:0; font-family: "Times New Roman", "標楷體"; font-size:11pt;}
.drawformborder { border:solid 1px; }
.drawformborder tr { border:solid 1px; }
.drawformborder td { border:solid 1px; }
</style>
</head>
<body>
<?php
$pid = (int) @$_GET['pid'];
$db = new DB;
$db->query("SELECT `patientID`,`HospNo` FROM `patient` WHERE `patientID`='".mysql_escape_string($pid)."'");
if ($db->num_rows()>0) {
	$r = $db->fetch_assoc();
	foreach ($r as $k=>$v) {
		$arrPatientInfo = explode("_",$k);
		if (count($arrPatientInfo)==2) {
			if ($v==1) {
				if (${$arrPatientInfo[0]} != NULL) { ${$arrPatientInfo[0]} .= ';'; }
				${$arrPatientInfo[0]} .= $arrPatientInfo[1];
			}
		} else {
			${$k} = $v;
		}
	}
}
$name = getPatientName($r['patientID']);
if (@$_GET['date']=='') {
	$sql = "SELECT * FROM `socialform21_2` WHERE `HospNo`='".mysql_escape_string($r['HospNo'])."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql = "SELECT * FROM `socialform21_2` WHERE `HospNo`='".mysql_escape_string($r['HospNo'])."' AND `date`='".mysql_escape_string($_GET['date'])."'";
}
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
<table width="860" style="border:none;">
<tr>
  <td width="56" valign="bottom">96.<br />11.<br />09.<br />病<br />歷<br />管<br />理<br />委<br />員<br />Able<br />審<br />查<br />通<br />過</td><!--Health records management committee Approve -->
  <td>
<table width="800" style="broder:none;">
  <tr>
    <td><center><font size="3">萬芳醫院local hospital name<br />
      Rehabilitation department report(2)</font></center></td>
  </tr>
</table>
<table width="800" style="broder:none;">
  <tr>
    <td width="40">Full name</td>
    <td style="border-bottom:solid 1px; text-align:center;"><?php echo $name; ?></td>
    <td width="70">Care ID#</td>
    <td style="border-bottom:solid 1px; text-align:center;"><?php echo $Q2; ?></td>
    <td width="40">Date</td>
    <td style="border-bottom:solid 1px; text-align:center;"><?php echo formatdate($date); ?></td>
  </tr>
</table>
<table width="800" style="broder:none;">
  <tr>
    <td  width="85">Visiting note date</td>
    <td style="border-bottom:solid 1px; text-align:center;" width="100"><?php echo $Q4; ?></td>
    <td width="55">Serial number：</td>
    <td style="border-bottom:solid 1px; text-align:center;" width="170"><?php echo $Q5; ?></td>
    <td width="135">Rehabilitation department inpatient：</td>
    <td style="text-align:left;"><?php if ($Q6==1) { echo '(Yes/<del>No</del>)'; } elseif ($Q6==2) { echo '(<del>Yes</del>/No)'; } ?></td>
  </tr>
</table>
<table width="800" style="broder:none;">
  <tr>
    <td colspan="2" style="line-height:28px;"><center>
      <font size="3">Progress Note</font>
    </center></td>
  </tr>
  <tr>
    <td colspan="2" height="70" valign="top">Subjective:<br /><?php echo str_replace("\'","'",$Q7); ?></td>
  </tr>
  <tr>
    <td colspan="2">Objective: </td>
  </tr>
  <tr>
    <td colspan="2">
    <table class="drawformborder" style="width:708px; margin-left:14px; font-size:9pt;" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="3" width="540">Sensorimotor Status (U/E: upper extremity; L/E: lower extremity)</td>
        <td width="140">Functional status</td>
        <td width="40">level</td>
        <td width="20">N</td>
        <td width="20">A</td>
      </tr>
      <tr>
        <td rowspan="2">Sensation</td>
        <td>UE</td>
        <td><center><?php if ($Q11s=="Lt") { echo "L't"; } elseif ($Q11s=="Rt") { echo "R't"; } elseif ($Q11s=="RL") { echo "R/L"; } elseif ($Q11s=="NA") { echo "N/A"; } ?> side: pin prick <?php if ($Q11a==1) { echo '(+)/<del>(-)</del>'; } elseif ($Q11a==2) { echo '(<del>(+)</del>/(-)'; } ?> ; light touch <?php if ($Q11b==1) { echo '(+)/<del>(-)</del>'; } elseif ($Q11b==2) { echo '(<del>(+)</del>/(-)'; } ?></center></td>
        <td>rolling</td>
        <td><?php echo draw_option("Q11c","1;2;3;4;5;6;7","s","single",$Q11c,true,4); ?><?php if ($Q11d==3) { echo 'N/A'; } ?></td>
        <td><?php if ($Q11d==1) { echo '&#10003;'; } ?></td>
        <td><?php if ($Q11d==2) { echo '&#10003;'; } ?></td>
      </tr>
      <tr>
        <td>LE</td>
        <td><center><?php if ($Q12s=="Lt") { echo "L't"; } elseif ($Q12s=="Rt") { echo "R't"; } elseif ($Q12s=="RL") { echo "R/L"; } elseif ($Q12s=="NA") { echo "N/A"; } ?> side: pin prick <?php if ($Q12a==1) { echo '(+)/<del>(-)</del>'; } elseif ($Q12a==2) { echo '(<del>(+)</del>/(-)'; } ?> ; light touch <?php if ($Q12b==1) { echo '(+)/<del>(-)</del>'; } elseif ($Q12b==2) { echo '(<del>(+)</del>/(-)'; } ?></center></td>
        <td>supine&lt;-&gt;sit</td>
        <td><?php echo draw_option("Q12c","1;2;3;4;5;6;7","s","single",$Q12c,true,4); ?><?php if ($Q12d==3) { echo 'N/A'; } ?></td>
        <td><?php if ($Q12d==1) { echo '&#10003;'; } ?></td>
        <td><?php if ($Q12d==2) { echo '&#10003;'; } ?></td>
      </tr>
      <tr>
        <td rowspan="2">Muscle tone</td>
        <td>UE</td>
        <td><center><?php if ($Q13s=="Lt") { echo "L't"; } elseif ($Q13s=="Rt") { echo "R't"; } elseif ($Q13s=="RL") { echo "R/L"; } elseif ($Q13s=="NA") { echo "N/A"; } ?> side: <?php if ($Q13a==1) { echo '(+)/<del>(++)</del>/<del>(+++)</del>/<del>(++++)</del>'; } elseif ($Q13a==2) { echo '(<del>(+)</del>/(++)/<del>(+++)</del>/<del>(++++)</del>'; } elseif ($Q13a==3) { echo '(<del>(+)</del>/<del>(++)</del>/(+++)/<del>(++++)</del>'; } elseif ($Q13a==4) { echo '(<del>(+)</del>/<del>(+)</del>/<del>(+++)</del>/(++++)'; } ?></center></td>
        <td>sit&lt;-&gt;stand</td>
        <td><?php echo draw_option("Q13c","1;2;3;4;5;6;7","s","single",$Q13c,true,4); ?><?php if ($Q13d==3) { echo 'N/A'; } ?></td>
        <td><?php if ($Q13d==1) { echo '&#10003;'; } ?></td>
        <td><?php if ($Q13d==2) { echo '&#10003;'; } ?></td>
      </tr>
      <tr>
        <td>LE</td>
        <td><center>
          <?php if ($Q14s=="Lt") { echo "L't"; } elseif ($Q14s=="Rt") { echo "R't"; } elseif ($Q14s=="RL") { echo "R/L"; } elseif ($Q14s=="NA") { echo "N/A"; } ?>
side: <?php if ($Q14a==1) { echo '(+)/<del>(++)</del>/<del>(+++)</del>/<del>(++++)</del>'; } elseif ($Q14a==2) { echo '(<del>(+)</del>/(++)/<del>(+++)</del>/<del>(++++)</del>'; } elseif ($Q14a==3) { echo '(<del>(+)</del>/<del>(++)</del>/(+++)/<del>(++++)</del>'; } elseif ($Q14a==4) { echo '(<del>(+)</del>/<del>(+)</del>/<del>(+++)</del>/(++++)'; } ?></center></td>
        <td rowspan="3">Transfer&nbsp;<br />
          Bed, chair, wheelchair,<br />Toitel<br />Tub, Shower</td>
        <td><?php echo draw_option("Q14c","1;2;3;4;5;6;7","s","single",$Q14c,true,4); ?><?php if ($Q14d==3) { echo 'N/A'; } ?></td>
        <td><?php if ($Q14d==1) { echo '&#10003;'; } ?></td>
        <td><?php if ($Q14d==2) { echo '&#10003;'; } ?></td>
      </tr>
      <tr>
        <td rowspan="2">Muscle strength</td>
        <td>UE</td>
        <td><center>
          <?php if ($Q15s=="Lt") { echo "L't"; } elseif ($Q15s=="Rt") { echo "R't"; } elseif ($Q15s=="RL") { echo "R/L"; } elseif ($Q15s=="NA") { echo "N/A"; } ?>
side general <?php echo $Q15a; ?> grade</center></td>
        <td><?php echo draw_option("Q15c","1;2;3;4;5;6;7","s","single",$Q15c,true,4); ?><?php if ($Q15d==3) { echo 'N/A'; } ?></td>
        <td><?php if ($Q15d==1) { echo '&#10003;'; } ?></td>
        <td><?php if ($Q15d==2) { echo '&#10003;'; } ?></td>
      </tr>
      <tr>
        <td>LE</td>
        <td><center>
          <?php if ($Q16s=="Lt") { echo "L't"; } elseif ($Q16s=="Rt") { echo "R't"; } elseif ($Q16s=="RL") { echo "R/L"; } elseif ($Q16s=="NA") { echo "N/A"; } ?>
side general <?php echo $Q16a; ?> grade</center></td>
        <td><?php echo draw_option("Q16c","1;2;3;4;5;6;7","s","single",$Q16c,true,4); ?><?php if ($Q16d==3) { echo 'N/A'; } ?></td>
        <td><?php if ($Q16d==1) { echo '&#10003;'; } ?></td>
        <td><?php if ($Q16d==2) { echo '&#10003;'; } ?></td>
      </tr>
      <tr>
        <td rowspan="2">Range of Motion</td>
        <td>UE</td>
        <td><center>
          <?php if ($Q17s=="Lt") { echo "L't"; } elseif ($Q17s=="Rt") { echo "R't"; } elseif ($Q17s=="RL") { echo "R/L"; } elseif ($Q17s=="NA") { echo "N/A"; } ?>
side: <?php echo $Q17a; ?></center></td>
        <td>sitting balance</td>
        <td colspan="3"><?php echo draw_option("Q17c","1;2;3;4;5;6;7","s","single",$Q17c,false,4); ?></td>
      </tr>
      <tr>
        <td>LE</td>
        <td><center>
          <?php if ($Q18s=="Lt") { echo "L't"; } elseif ($Q18s=="Rt") { echo "R't"; } elseif ($Q18s=="RL") { echo "R/L"; } elseif ($Q18s=="NA") { echo "N/A"; } ?>
side: <?php echo $Q18a; ?></center></td>
        <td>standing balance</td>
        <td colspan="3"><?php echo draw_option("Q18c","1;2;3;4;5;6;7","s","single",$Q18c,false,4); ?></td>
      </tr>
      <tr>
        <td rowspan="2">Brunnstrom Stage</td>
        <td>UE</td>
        <td><center>
          <?php if ($Q19s=="Lt") { echo "L't"; } elseif ($Q19s=="Rt") { echo "R't"; } elseif ($Q19s=="RL") { echo "R/L"; } elseif ($Q19s=="NA") { echo "N/A"; } ?>
side: <?php echo $Q19a; ?></center></td>
        <td>ambulation</td>
        <td><?php echo draw_option("Q19c","1;2;3;4;5;6;7","s","single",$Q19c,true,4); ?><?php if ($Q19d==3) { echo 'N/A'; } ?></td>
        <td><?php if ($Q19d==1) { echo '&#10003;'; } ?></td>
        <td><?php if ($Q19d==2) { echo '&#10003;'; } ?></td>
      </tr>
      <tr>
        <td>LE</td>
        <td><center>
          <?php if ($Q20s=="Lt") { echo "L't"; } elseif ($Q20s =="Rt") { echo "R't"; } elseif ($Q20s =="RL") { echo "R/L"; } elseif ($Q20s =="NA") { echo "N/A"; } ?>
side: <?php echo $Q20a; ?></center></td>
        <td>gait pattern</td>
        <td><?php echo draw_option("Q20c","1;2;3;4;5;6;7","s","single",$Q20c,true,4); ?><?php if ($Q20d==3) { echo 'N/A'; } ?></td>
        <td><?php if ($Q20d==1) { echo '&#10003;'; } ?></td>
        <td><?php if ($Q20d==2) { echo '&#10003;'; } ?></td>
      </tr>
      <tr>
        <td rowspan="2">Coordination</td>
        <td>UE</td>
        <td><center>
          <?php if ($Q21s =="Lt") { echo "L't"; } elseif ($Q21s =="Rt") { echo "R't"; } elseif ($Q21s =="RL") { echo "R/L"; } elseif ($Q21s =="NA") { echo "N/A"; } ?>
side: finger to nose <?php echo $Q21a; ?> times/10sec</center></td>
        <td>assistive device</td>
        <td colspan="3"><?php echo $Q21c; ?></td>
      </tr>
      <tr>
        <td>LE</td>
        <td><center>
          <?php if ($Q22s =="Lt") { echo "L't"; } elseif ($Q22s =="Rt") { echo "R't"; } elseif ($Q22s =="RL") { echo "R/L"; } elseif ($Q22s =="NA") { echo "N/A"; } ?>
side: heel to shin <?php echo $Q22a; ?> times/10sec</center></td>
        <td>Up/down stairs</td>
        <td><?php echo draw_option("Q22c","1;2;3;4;5;6;7","s","single",$Q22c,true,4); ?><?php if ($Q22d==3) { echo 'N/A'; } ?></td>
        <td><?php if ($Q22d==1) { echo '&#10003;'; } ?></td>
        <td><?php if ($Q22d==2) { echo '&#10003;'; } ?></td>
      </tr>
      <tr>
        <td>Pain (area):</td>
        <td>&nbsp;</td>
        <td><?php echo $Q23; ?></td>
        <td colspan="4" rowspan="2" style="text-align:left;" valign="top">Others<br /><?php echo $Q25; ?></td>
      </tr>
      <tr>
        <td colspan="3">cardiopulmonary Status:<br /><?php echo $Q24; ?></td>
      </tr>
    </table>
    <span style="line-height:28px; font-size:10pt;">PS 1: levels 1. total assist (0%)  2. maximal assist (>3/4)   3. with moderate assist (1/2)  4. with minimal assist (1/4)<br />
    　　　　　 5. supervision   6. modified independence (device)   7. independence (timely, safely)<br />
    PS 2: 勾選select N. normal pattern  A. abnormal pattern<br />
    PS 3: Sensation : (+) impaired / (-) OK ; Muscle tone : (+) hypo / (++) normal / (+++) hyper / (++++)contracture</span><br /><br />
    </td>
  </tr>
  <tr>
    <td colspan="2" height="90" valign="top">Assessment:<br /><font size="2">短期目標達成率short-term goals achieve ratio：<?php if ($Q8==1) { echo '&#9745;'; } else { echo '&#9744;'; } ?>100%完成achieve <?php if ($Q8==2) { echo '&#9745;'; } else { echo '&#9744;'; } ?>85%完成achieve <?php if ($Q8==3) { echo '&#9745;'; } else { echo '&#9744;'; } ?>50%完成achieve <?php if ($Q8==4) { echo '&#9745;'; } else { echo '&#9744;'; } ?>25%完成achieve <?php if ($Q8==5) { echo '&#9745;'; } else { echo '&#9744;'; } ?>完全沒做到not achieve</font><br /><?php echo str_replace("\'","'",$Q9); ?><br />Long term goals: <?php echo str_replace("\'","'",$Q9a); ?></td>
  </tr>
  <tr>
    <td colspan="2">
    Programs:<br />
    <table class="drawformborder" style="width:408px; margin-left:14px; font-size:9pt;" cellpadding="0" cellspacing="0">
      <tr>
        <td width="20"><center><?php if ($r1['Q27_1']==1) { echo '&#10003;'; } ?></center></td>
        <td width="180">Hot/cold pack</td>
        <td width="20"><center><?php if ($r1['Q27_8']==1) { echo '&#10003;'; } ?></center></td>
        <td width="180">Strengthening exercise</td>
      </tr>
      <tr>
        <td width="20"><center><?php if ($r1['Q27_2']==1) { echo '&#10003;'; } ?></center></td>
        <td width="180">Interferential current</td>
        <td width="20"><center><?php if ($r1['Q27_9']==1) { echo '&#10003;'; } ?></center></td>
        <td width="180">Tilting table</td>
      </tr>
      <tr>
        <td width="20"><center><?php if ($r1['Q27_3']==1) { echo '&#10003;'; } ?></center></td>
        <td width="180">Electrical stimulation</td>
        <td width="20"><center><?php if ($r1['Q27_10']==1) { echo '&#10003;'; } ?></center></td>
        <td width="180">Mobilization</td>
      </tr>
      <tr>
        <td width="20"><center><?php if ($r1['Q27_4']==1) { echo '&#10003;'; } ?></center></td>
        <td width="180">Passive range of motion</td>
        <td width="20"><center><?php if ($r1['Q27_11']==1) { echo '&#10003;'; } ?></center></td>
        <td width="180">Gait / posture correction</td>
      </tr>
      <tr>
        <td width="20"><center><?php if ($r1['Q27_5']==1) { echo '&#10003;'; } ?></center></td>
        <td width="180">Balance training</td>
        <td width="20"><center><?php if ($r1['Q27_12']==1) { echo '&#10003;'; } ?></center></td>
        <td width="180">Facilitation</td>
      </tr>
      <tr>
        <td width="20"><center><?php if ($r1['Q27_6']==1) { echo '&#10003;'; } ?></center></td>
        <td width="180">Ambulation training</td>
        <td width="20"><center><?php if ($r1['Q27_13']==1) { echo '&#10003;'; } ?></center></td>
        <td width="180">Balance training</td>
      </tr>
      <tr>
        <td width="20"><center><?php if ($r1['Q27_7']==1) { echo '&#10003;'; } ?></center></td>
        <td width="180">Stretch exercise</td>
        <td width="20"><center><?php if ($r1['Q27_14']==1) { echo '&#10003;'; } ?></center></td>
        <td width="180">Exercise therapy</td>
      </tr>
    </table><br /><br /><br /><br />
    </td>
  </tr>
  <tr height="60">
    <td colspan="2" align="right">Physical therapist: <div style="width:140px; display:inline-block; border-bottom:solid 1px;"></div> <font size="2">(簽名蓋章signature or stamp)</font></td>
  </tr>
  <tr height="70">
    <td align="left">臺北醫學大學‧市立萬芳醫院local hospital name 93-12-B</td>
    <td align="right">F4200074(B)</td>
  </tr>
</table>
  </td>
</tr>
</table>