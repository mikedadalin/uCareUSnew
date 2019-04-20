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
body { padding:0; margin:0; font-family: "Times New Roman", "標楷體"; font-size:10pt;}
.drawformborder { border:solid 1px; border-collapse:collapse; }
.drawformborder tr { border:solid 1px; }
.drawformborder td { border:solid 1px; }
.title { font-weight:bold; }
</style>
</head>

<body>
<?php
$actNo = (int) @$_GET['actNo'];
if (@$_GET['actNo']!="") {
	$db1c = new DB;
	$db1c->query("SELECT * FROM `socialform08` WHERE `actNo`='".mysql_escape_string($actNo)."'");
	$r1c = $db1c->fetch_assoc();
	$db1d = new DB;
	$db1d->query("SELECT * FROM `socialform08_act` WHERE `actID`='".$r1c['actID']."'");
	$r1d = $db1d->fetch_assoc();
	$cateName = $r1d['cateName'];
	$actName = $r1d['actName'];
	$date = formatdate($r1c['date']);
	$arrSelectedHospNo = explode(";",$r1c['HospNo']);
	
	$db1e = new DB;
	$db1e->query("SELECT * FROM `socialform08a` WHERE `actNo`='".mysql_escape_string($actNo)."'");
	if ($db1e->num_rows()>0) {
		$r1e = $db1e->fetch_assoc();
		foreach ($r1e as $k=>$v) {
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
}

?>
<table width="800" style="border:none;">
  <tr>
    <td><center><font size="5"><b><?php echo $_SESSION['nOrgName_lwj']; ?></b></font></center></td>
  </tr>
  <tr>
    <td>&nbsp;<br /><center><font size="5"><b>團體活動計畫表</b></font></center></td>
  </tr>
</table>
<table width="800" class="drawformborder" cellpadding="0" cellspacing="0" style="font-size:12pt;">
  <tr>
    <td width="160" class="title">Activity category</td>
    <td><?php echo $cateName . ' - ' . $actName; ?></td>
    <td width="160" class="title">Date/Time</td>
    <td><?php echo $date==NULL?date("Y/m/d"):$date; ?>&nbsp;<?php echo $Q12;?></td>
  </tr>
  <tr>
  	<td class="title">Activity theme</td>
    <td colspan="3"><?php echo $Q1; ?></td>
  </tr>
  <tr>
  	<td class="title">Activity objectives</td>
    <td colspan="3"><?php echo checkbox_2col_result("Q2","Enhance cognition and thinking skills;Improve resident's short-term memory;Mindfulness training;Improve cognition of surrounding environment;Improve language skills;Enhance concept of time in daily activities;Slow down the degradation of cognition and memory;Improve conversation and interaction with the visiting family member(s)",$Q2,"multi"); ?><div style="margin-left:18px;"><?php echo checkbox_result("Q3","Increase sensory sensitivity",$Q3,"multi"); ?><div style="margin-left:48px;"><?php echo option_result("Q4","Taste;Tactile;Proprioception;Sight;Thermoception","m","multi",$Q4,false,3);?></div><?php echo checkbox_result("Q5","Strengthen contact to the real life and society to understand current affairs.;Other(please state) <input type=\"text\" id=\"Q5a\" name=\"Q5a\" value=\"".$Q5a."\">",$Q5,"multi"); ?></div></td>
  </tr>
  <tr>
  	<td class="title">Participants' activity level</td>
    <td><?php echo option_result("Q6","Mild dementia;Mild disability;Moderate dementia;Moderate disability","m","multi",$Q6,true,2);?></td>
  	<td class="title">Number of group participant</td>
    <td><?php echo $Q7; ?></td>
  </tr>
  <tr>
  	<td class="title">Host</td>
    <td colspan="3"><?php echo getEmployerName($Q8).'；'.$Q8a; ?></td>
  </tr>
  <tr>
  	<td class="title">Assistive material</td>
    <td colspan="3"><?php echo $Q9; ?></td>
  </tr>
  <tr>
  	<td class="title">Activity and guided topic</td>
    <td colspan="3"><?php echo $Q10; ?></td>
  </tr> 
  <tr>
  	<td class="title">Notes</td>
    <td colspan="3"><?php echo $Q11; ?></td>
  </tr>
  <tr>
    <td class="title">參與者</td>
    <td colspan="3">    
    <?php
		for ($i=0;$i<count($arrSelectedHospNo);$i++){
			echo '<div style="width:150px; display:inline-block;">'.getHospNoDisplayByHospNo($arrSelectedHospNo[$i]).' '.getPatientName(getPID($arrSelectedHospNo[$i])).'</div>';
		}
	
	?>
    </td>
  </tr>
</table>

</body>
</html>