<?php
session_start();
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
<link type="text/css" rel="stylesheet" href="css/printstyle.css" />
<style>
body { padding:0; margin:0; }
.noprint { color:#ffffff; }
.noprint td { border-color:#ffffff; background:#ffffff;}
</style>
</head>

<body>
<?php
$db = new DB;
$db->query("SELECT `patientID`,`HospNo`,`Birth` FROM `patient` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."'");
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	$db1 = new DB;
	$db1->query("SELECT `indate` FROM `inpatientinfo` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."'");
	$r1 = $db1->fetch_assoc();
	$name = getPatientName($r['patientID')];
	$birth = formatdate($r['Birth']);
	$indate = formatdate($r1['indate']);
	$HospNo = $r['HospNo'];
	$db2 = new DB;
	$db2->query("SELECT `Qdiag1`, `Qdiag2`, `Qdiag3`, `Qdiag4`, `Qdiag5`, `Qdiag6`, `Qdiag7`, `Qdiag8` FROM `nurseform01` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1");
	$r2 = $db2->fetch_assoc();
	for ($j=1;$j<=8;$j++) { if ($r2['Qdiag'.$j]!=NULL) { $diagMsg .= $r2['Qdiag'.$j].', '; } }
	$diagMsg = substr($diagMsg, 0, strlen($diagMsg)-2);
}

if (@$_GET['date1']==NULL || @$_GET['date2']==NULL) {
	$sql = "SELECT * FROM `nurseform05` WHERE `HospNo`='".$HospNo."' ORDER BY `date` ASC";
} else {
	$sql = "SELECT * FROM `nurseform05` WHERE `HospNo`='".$HospNo."' AND `date`>='".mysql_escape_string($_GET['date1'])."' AND `date`<='".mysql_escape_string($_GET['date2'])."' ORDER BY `date` ASC";
}

?>
<div style="width:860px; line-height:23px; page-break-after: always;" id="allpage">
<?php
if (@$_GET['startprint']!=0) {
	echo '<center><font color="#ffffff">'.$_SESSION['nOrgName_lwj'].'Nursing Record</font></center>';
} else {
	echo '<center>'.$_SESSION['nOrgName_lwj'].'Nursing Record</center>';
}
?>
<span <?php if (@$_GET['startprint']!=0) { echo ' class="noprint"'; } ?>><b>Full name</b>：<?php echo $name; ?>　　生日birth date：<?php echo $birth.' ('.checkgender(mysql_escape_string($_GET['pid'])).', '.calcage(str_replace('/','',$birth)).')'; ?>　　入住日期check-in date：<?php echo $indate; ?></span>
<table width="860" style="border-collapse:collapse;" border="1" cellpadding="0" cellspacing="0"  id="page1">
  <tr <?php if (@$_GET['startprint']!=0) { echo ' class="noprint"'; } else { echo 'class="title"'; } ?>>
    <td width="24">&nbsp;</td>
    <td width="120">Date and time</td>
    <td width="160">Focus problem</td>
    <td>Record content</td>
    <td width="60">Staff</td>
  </tr>
    <?php
	 for ($i=1;$i<=@$_GET['startprint'];$i++) {
	 echo '
  <tr class="noprint">
    <td colspan="4">&nbsp;</td>
  </tr>';
	 }
	$db2 = new DB;
	$db2->query($sql);
    for ($i=0;$i<$db2->num_rows();$i++) {
 	$r2 = $db2->fetch_assoc();
	$content = trim($r2['Qcontent']);
	$content = str_replace("<div>","",$content);
	$content = str_replace("<br>","",$content);
	$content = str_replace("<br />","",$content);
	$content = str_replace("</div>","",$content);
	echo '
  <tr id="row'.$i.'">
	<td><span id="row'.$i.'height"></span></td>
    <td valign="top"><span id="date_'.$i.'">'.formatdate($r2['date']).' '.substr($r2['time'],0,2).':'.substr($r2['time'],2,2).'</span></td>
    <td valign="top"><span id="Q2_'.$i.'">'; if ($r2['Q2']!="") { echo $r2['Q2']; } else { echo '&nbsp;'; } echo '</span></td>
    <td valign="top"><span id="content_'.$i.'">'.$content.'</span></td>
	<td valign="top"><span id="Qfiller_'.$i.'">';
	$db_filler = new DB2;
	$db_filler->query("SELECT `name` FROM `userinfo` WHERE `userID`='".$r2['Qfiller']."' AND `orgID`='".$_SESSION['nOrgID_lwj']."'");
	$r_filler = $db_filler->fetch_assoc();
	echo $r_filler['name'];
	echo '</span></td>
  </tr>
	'."\n";
    }
    ?>
</table>
</div>
<script>
function calctdheight(rowno) {
	
	var endno = <?php if (@$_GET['startprint']==0) { echo '1'; } else { echo @$_GET['startprint']; } ?>;
	var page = 1;
	var showtxt = '';
	var arrData = [];
	var pushdata = '';
	var addon = 0;
	for (var i=0;i<rowno;i++) {
		var brtext = '';
		var height = document.getElementById('row'+i).offsetHeight;
		var rowtextno = Math.ceil(height/24);
		var stopno = endno+rowtextno;
		for (var j=endno;j<stopno;j++) {
			var page2 = page;
			showtxt = j-(48*(page-1));
			if (showtxt==1) { addon = 0; }
			if (showtxt==1 && brtext != '') {
				brtext = '1<br>';
				showtxt++;
				j++;
				stopno++;
				brtext += showtxt+'<br>' + (showtxt+1)+'<br>';
				addon++;
			} else {
				brtext += (showtxt+addon)+'<br>';
			}
			document.getElementById('row'+i+'height').innerHTML = brtext;
			if (showtxt == 48) { page++; page2 = page-1; }
		}
		pushdata = $('#row'+i+'height').html() + '||' + (i+1) + '||' + $('#date_'+i).html() + '||' + $('#Q2_'+i).html() + '||' + $('#content_'+i).html() + '||' + $('#Qfiller_'+i).html() + '；';
		arrData[page2] += pushdata;
		endno = j;
	}
	var pagetext = '';
	var startprint = '<?php echo @$_GET['startprint']; ?>';
	for (var i2=0;i2<page;i2++) {
		console.log(arrData[i2]);
		if (i2==0 && startprint>0) {
			pagetext += '<div style="page-break-after:always; margin-top:-1px;"><center><font color="#ffffff"><?php echo $_SESSION['nOrgName_lwj']; ?> Nursing Record</font></center>';
		} else {
			pagetext += '<div style="page-break-after:always;"><center><?php echo $_SESSION['nOrgName_lwj']; ?> Nursing Record</center>';
		}
		pagetext += '<span';
		if (i2==0 && startprint>0) { pagetext += ' class="noprint"'; }
		pagetext +='><b>Full name</b>：<?php echo $name; ?>　　生日birth date：<?php echo $birth.' ('.checkgender(mysql_escape_string($_GET['pid'])).', '.calcage(str_replace('/','',$birth)).')'; ?>　　入住日期check-in date：<?php echo $indate; ?></span><table width="860" style="border-collapse:collapse;" border="1" cellpadding="0" cellspacing="0"><tr';
		if (i2==0 && startprint>0) { pagetext += ' class="noprint"'; } else { pagetext += ' class="title"'; }
		pagetext += '><td width="24">&nbsp;</td><td width="120">Date and time</td><td width="160">Focus problem</td><td>Record content</td><td width="60">Staff</td></tr>';
		if (i2==0 && startprint>0) { for (var i3=1;i3<startprint;i3++) { pagetext += '<tr class="noprint"><td colspan="4">&nbsp;</td></tr>'; } }
		var datatxt = arrData[i2+1].split('；');
		for (var i4=0;i4<(datatxt.length-1);i4++) {
			var tabletext = datatxt[i4].split('||');;
			pagetext += '<tr><td valign="top" width="24">' + tabletext[0].replace('undefined','') + '</td><td valign="top">' + tabletext[2] + '</td><td valign="top">' + tabletext[3] + '</td><td valign="top">' + tabletext[4] + '</td><td valign="top">' + tabletext[5] + '</td></tr>';
		}
		pagetext += '</table></div>';
	}
	document.getElementById('allpage').innerHTML = pagetext;
	//document.getElementById('allpage').innerHTML = '';
}
$(document).ready(function(){
	calctdheight(<?php echo $i; ?>);
});
</script>
</body>
</html>