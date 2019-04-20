<?php
session_start();
include("class/DB.php");
include("class/DB2.php");
include("class/error.php");
include("class/array.php");
include("class/functionforprint.php");
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
<script>
if(navigator.appName.indexOf("Internet Explorer")!=-1)document.onmousedown=noSourceExplorer;function noSourceExplorer(){if(event.button==2|event.button==3){}}function NoRightClick(evnt){if(navigator.appName.toUpperCase().match(/NETSCAPE/)!=null){if(evnt.which==3){return false}}else if(event.button==2){}}document.onmousedown=NoRightClick;$(document).ready(function(){$("form :input").attr("readonly",true);
//$("textarea").replaceWith($("textarea").html());
$("textarea").each(function(){
	var content = $(this).html();
	$(this).replaceWith(content.replace(/\n/g,"<br>"));
});
$("#submit").hide();$("input[type=button]").hide();$("input[type=image]").hide();$("#backbtn").hide();$("#printbtn").hide();$("option:selected").each(function(){var e=$(this);var t=$(this).parent().attr("id");if(e.length){var n=e.text();$("#"+t).replaceWith(""+n+"")}})})
</script>
</head>

<body>

<?php
if (@$_GET['func']=='printmed') {
	$width = '1309px';
} else {
	$width = '909px';
}
if ($_SESSION['ncareID_lwj']==NULL && @$_GET['func']!="loginprocess") {
	$QR_URL = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$QR_URL = str_replace("&","_TWNo1_",$QR_URL);
	echo "<script>alert('Please log in again!'); window.location.href='logout.php?QR_URL=".$QR_URL."';</script>"; 
} else {
	
//模組名稱
$strModule = "feecreate";
$reID = mysql_escape_string($_GET['reID']);
$HospNo = mysql_escape_string(getHospNo($_GET['pid']));

$db = new DB;
$db->query("select * from `".$strModule."` where HospNo='".$HospNo."' and receiptID='".$reID."'");
$rs = $db->fetch_assoc();
?>
<center>
<table border="0" bgcolor="#ffffff" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" style="border:none;">
    <div id="printarea"  class="printarea">
    <br>
    <input type="hidden" id="HospNo" name="HospNo" value="<?php echo $rs['HospNo']; ?>" />
    <table width="100%" border="0" class="noborderForReceipt">
      <tr>
        <td width="280">&nbsp;</td>
        <td width="300">&nbsp;</td>
        <td width="220"  align="right">Bed number:<span id="log4"></span></td>
      </tr>
      <tr>
        <td>　　　<span id="log0"></span>&nbsp;<?php echo $rs['HospNo']; ?></td>
        <td align="right"><?php echo (substr($rs['date'],0,4)-1911); ?>&nbsp;&nbsp;&nbsp;<?php echo (substr($rs['date'],5,2)); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo (substr($rs['date'],8,2)); ?></td>
        <td align="right"><?php echo $rs['receiptID']; ?></td>
      </tr>
    </table>
    <table width="100%" border="0" class="noborderForReceipt">
      <tr height="35">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="200"><?php echo (substr($rs['date1'],0,4)-1911).'Year'.substr($rs['date1'],4,2).' month'; ?> monthly fee</td>
        <td width="80" align="right"><?php echo number_format($rs['fee1']);?></td>
        <td rowspan="3" valign="top" align="left"><?php echo $rs['mark'];?></td>
      </tr>
      <tr>
        <td><?php echo (substr($rs['date2'],0,4)-1911).'Year'.substr($rs['date2'],4,2).' month';?> incidentals fee</td>
        <td align="right"><?php echo number_format($rs['fee2']);?></td>
        </tr>
      <tr>
        <td><?php echo (substr($rs['date2'],0,4)-1911).'Year'.substr($rs['date2'],4,2).' month';?> payment on center's behalf</td>
        <td align="right"><?php echo number_format($rs['fee3']);?></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>    
    </table>
    <table width="100%" border="0" class="noborderForReceipt">
      <tr>
        <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($rs['fee1']+$rs['fee2']+$rs['fee3']);?></td>
        <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($rs['fee2']);?></td>
        <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($rs['fee1']+$rs['fee3']);?></td>
      </tr>
      <tr height="30">
        <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;新臺幣<?php echo int2chnum($rs['fee1']+$rs['fee2']+$rs['fee3']); ?>整</td>
        </tr>
    </table>
    </div>
    </td>
  </tr>
</table>
</center>
<?php
}//end if
?>
</body>
</html>
<script language="javascript">
var chkID = '<?php echo $HospNo;?>';
if(chkID!=""){
	showPatient();
}
function showPatient() {
  $.ajax({
	  url: "class/patient.php",
	  type: "POST",
	  data: { "PID": $("#HospNo").val()},
	  success: function(data) {
		  var dataArr = data.split(';');
		  for (i = 0; i < dataArr.length; i++){				
			  $( "#log"+i ).html( dataArr[i] );
		  }
	  }
  });
}
</script>