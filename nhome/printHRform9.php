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
$EmpID = mysql_escape_string($_GET['EmpID']);
$EmpGroup = mysql_escape_string($_GET['EmpGroup']);
$trainingformID = mysql_escape_string($_GET['trainingform']);
$type = @$_GET['type'];
if($EmpGroup ==1){
	$db5a = new DB;
	$db5a->query("SELECT * FROM `employer` WHERE `EmpID`='".$EmpID."';");
	$r5a = $db5a->fetch_assoc();
	$Name = $r5a['Name'];
}else{
	$db5b = new DB;
	$db5b->query("SELECT * FROM `foreignemployer` WHERE `foreignID`='".$EmpID."'");
	$r5b = $db5b->fetch_assoc();
	$Name = $r5b['cNickname'];
}
$db = new DB;
$db->query("SELECT * FROM `training_form` WHERE `trainingformID`='".$trainingformID."'");
$rs = $db->fetch_assoc();
$trainingform = $rs['type'];
$trainingname = $rs['trainingname'];
$hour = $rs['hour'];
$arrSign = str_replace(";","　　　　　　　　",$rs['sign']);
?>
<table width="800" style="border:none;">
  <tr>
    <td><center><font size="5"><b><?php echo $_SESSION['nOrgName_lwj']; ?></b></font></center></td>
  </tr>
  <tr>
    <td>&nbsp;<br /><center><font size="5"><b>New-join staff<?php echo $trainingname; ?>Pre-employment training</b></font></center><font style="float:right;">Name:<?php echo $Name;?></font></td>
  </tr>
</table>
<table width="800" class="drawformborder" cellpadding="0" cellspacing="0" style="font-size:12pt;">
  <tr class="title">
    <td colspan="2" rowspan="2" align="center">Pre-employment training</td>
    <td rowspan="2" align="center" width="80">Training date</td>
    <td colspan="4" align="center">Train time and result</td>
  </tr>
  <tr class="title">
      <td align="center" width="80">1st month</td>
      <td align="center" width="80">2nd month</td>
      <td align="center" width="80">3rd month</td>
      <td align="center" width="80">Comment</td>
  </tr>
<?php
$a = 1;
$db = new DB;
$str =" SELECT a.title titlea, a.service_cateID aID, c.title titlec, c.service_cateID cID FROM  `service_cate` a ";
$str .=" LEFT JOIN  `service_cate` c ON c.`parentID` = a.`service_cateID` ";
$str .=" WHERE 1 and a.typeCode='".$trainingform."' AND a.`layer` =1 AND a.`isHidden_1` =1 ";
$str .=" ORDER BY a.ord";
$db->query($str);

for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();

	$dba = new DB;
	$str1 = "SELECT count(*) rowCount FROM `service_cate` b WHERE b.parentID='".$r['aID']."' and b.isHidden_1=1 order by b.ord";
	$dba->query($str1);
	$r2 = $dba->fetch_assoc();	


	$db1 = new DB;
	$db1->query("SELECT * FROM `humanresource9_1` WHERE `EmpID`='".$EmpID."' AND `EmpGroup`='".$EmpGroup."' AND `cID`='".$r['cID']."'");
	$r1 = $db1->fetch_assoc();
	echo '
  <tr>';
  if($tmp!=$r['titlea']){
    echo '<td class="title_s" rowspan="'.$r2['rowCount'].'">'.$r['titlea'].'</td>';
  }
    echo '<td>'.str_replace("\n","<br>",$r['titlec']).'</td>
    <td>'.$r1['teachDate'].'</td>
	<td>'.$r1['date1'].'<br><center><font size="+2">'.$r1['score1'].'</font><center></td>
	<td>'.$r1['date2'].'<br><center><font size="+2">'.$r1['score2'].'</font><center></td>
	<td>'.$r1['date3'].'<br><center><font size="+2">'.$r1['score3'].'</font><center></td>
	<td valign="top">'.str_replace("\n","<br>",$r1['memo']).'</td>
  </tr>
	'."\n";
	$tmp=$r['titlea'];
}
?>
<tr>
	<td colspan="2" align="center"><font size="4">考核總分</font></td>
    <td>&nbsp;</td>
  <?php
   for ($i=1; $i<=3; $i++){
	   $db1 = new DB;
	   $db1->query("SELECT SUM(`score".$i."`) AS s FROM  `humanresource9_1` WHERE `EmpID` ='".$EmpID."' AND  `EmpGroup` ='".$EmpGroup."' AND  `trainingformID` ='".$trainingformID."'");  
	   $r1 = $db1->fetch_assoc();
  ?>
    <td align="center"><?php echo $r1['s']; ?></td>
  <?php }?>
    <td>&nbsp;</td>
</tr>

<tr>
	<td colspan="2" align="center"><font size="4">考核評分簽名</font></td>
    <td>&nbsp;</td>
    <?php
	$db2 = new DB;
	$db2->query("SELECT * FROM `humanresource9_1` WHERE `EmpID`='".$EmpID."' AND `EmpGroup`='".$EmpGroup."'");
	$r2 = $db2->fetch_assoc();
    ?>
    <td align="center" style="color:#ddd; border-color:black;"><?php echo checkusername($r2['Qfiller1']); ?></td>
    <td align="center" style="color:#ddd; border-color:black;"><?php echo checkusername($r2['Qfiller2']); ?></td>
    <td align="center" style="color:#ddd; border-color:black;"><?php echo checkusername($r2['Qfiller3']); ?></td>
    <td>&nbsp;</td>
</tr>
<?php if($hour!=0){?>
<tr>
    <td colspan="7" align="left">
    ◎第一次示教總計<?php echo $hour;?>小時，試用期三個月期間每月查核並評分80以上即通過試用或提前試用，若第三個月分數仍低於60分則表示未通過試用，70分延後一個月。<br>
	◎工作態度，責任和出缺勤則依據行政組考核成績為主。
    </td>
</tr>
<?php }?>
</table>
&nbsp;<br />
<span style="line-height:30px; font-size:16pt;"><?php echo $arrSign;?></span>
</body>
</html>