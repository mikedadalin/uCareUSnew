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
    <td>&nbsp;<br /><center><font size="5"><b>Group activities record</b></font></center></td>
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
    <td class="title">Resident name</td>
    <td colspan="3">    
    <?php
		for ($i=0;$i<count($arrSelectedHospNo);$i++){
			echo '<div style="width:150px; display:inline-block;">'.getHospNoDisplayByHospNo($arrSelectedHospNo[$i]).' '.getPatientName(getPID($arrSelectedHospNo[$i])).'</div>';
		}
	?>
    </td>
  </tr>  
  <tr>
  	<td class="title">Activity theme</td>
    <td colspan="3"><?php echo $Q1; ?></td>
  </tr>
  <tr>
  	<td width="160" class="title">活動帶領</td>
    <td><?php echo getEmployerName($Q13).'；'.$Q13a; ?></td>
  	<td width="160" class="title">活動協助</td>
    <td><?php echo getEmployerName($Q14).'；'.$Q14a; ?></td>
  </tr>
  <tr>
  	<td class="title">準備用物</td>
    <td colspan="3"><textarea id="Q15" name="Q15" cols="30" rows="5"><?php echo $Q15; ?></textarea></td>
  </tr> 
  <tr>
  	<td class="title">音樂</td>
    <td colspan="3"><?php echo $Q16; ?></td>
  </tr>
  <tr>
  	<td class="title">重要的活動過程</td>
    <td colspan="3"><textarea id="Q17" name="Q17" cols="30" rows="5"><?php echo $Q17; ?></textarea></td>
  </tr> 
  <tr>
  	<td class="title">長輩的重要反應</td>
    <td colspan="3"><textarea id="Q18" name="Q18" cols="30" rows="5"><?php echo $Q18; ?></textarea></td>
  </tr> 
  <tr>
  	<td class="title">Comment</td>
    <td colspan="3"><?php echo $Q19; ?></td>
  </tr>  
  <tr>
    <td class="title">Filled by</td>
	<td colspan="4"><?php echo checkusername($r1c['Qfiller']); ?></td>
  </tr>
</table>

</body>
</html>