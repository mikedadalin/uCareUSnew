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
<style>
.newForReceipt td{
	border-top-style:none;
	border-right-style:none;
	border-bottom:1px solid #666;
	border-left-style:none;
	font-size:20px;
	line-height:20px;
	font-family:"標楷體", "Times New Roman", serif;
}
.newForReceipt span{
	font-size:18px;
	line-height:20px;
	font-family:"標楷體", "Times New Roman", serif;
}

</style>
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
    <table width="100%" class="noborderForReceipt" >
      <tr>
        <td align="center"><?php echo $_SESSION['nOrgName_lwj']; ?></td>
      </tr>
      <tr>
        <td align="center">繳費收據</td>
      </tr>
    </table>
<table border="0" bgcolor="#ffffff" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" style="border:none;">
    <div id="printarea"  class="printarea" style="border:1px solid #000;">
    <input type="hidden" id="HospNo" name="HospNo" value="<?php echo getHospNoDisplayByHospNo($rs['HospNo']); ?>" />
    <table width="100%"  class="noborderForReceipt">
      <tr>
        <td>&nbsp;</td>
        <td>民國：<?php echo (substr($rs['date'],0,4)-1911); ?>&nbsp;Year&nbsp;<?php echo (substr($rs['date'],5,2)); ?>&nbsp;Month&nbsp;<?php echo (substr($rs['date'],8,2)); ?>&nbsp;日&nbsp;</td>
        <td align="right">Bed number:<span id="log4"></span></td>
      </tr>
      <tr class="newForReceipt">
        <td >Name:<span id="log0"></span>&nbsp;<?php echo getHospNoDisplayByHospNo($rs['HospNo']); ?></td>
        <td align="left">&nbsp;</td>
        <td align="right">收據編號：<?php echo $rs['receiptID']; ?></td>
      </tr>
    </table>
    <table width="100%" class="noborderForReceipt">
      <tr height="35">
        <td colspan="3">&nbsp;</td>
      </tr>
      <tr>
        <td width="200"><?php echo (substr($rs['date1'],0,4)-1911).'Year'.substr($rs['date1'],4,2).' month'; ?> monthly fee</td>
        <td width="80" align="right"><?php echo number_format($rs['fee1']);?>&nbsp;元</td>
        <td rowspan="3" valign="top" align="left"><?php echo $rs['mark'];?>
		<?php 
			$db2 = new DB;
			$db2->query("SELECT `indate`,`outdate` FROM `closedcase` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."' ORDER BY `outdate` DESC LIMIT 0,1");
			if($db2->num_rows() > 0){
				$r2 = $db2->fetch_assoc();
				echo '<br>入住日期：'.formatdate($r2['indate']).'<br>退住日期：'.formatdate($r2['outdate']);
			}
		?></td>
      </tr>
      <?php if($rs['date2']!=""){?>
      <tr>
        <td><?php echo (substr($rs['date2'],0,4)-1911).'Year'.substr($rs['date2'],4,2).' month';?> incidentals fee</td>
        <td align="right"><?php echo number_format($rs['fee2']);?>&nbsp;元</td>
        </tr>
      <tr>
        <td><?php echo (substr($rs['date2'],0,4)-1911).'Year'.substr($rs['date2'],4,2).' month';?> payment on center's behalf</td>
        <td align="right"><?php echo number_format($rs['fee3']);?>&nbsp;元</td>
        </tr>
      <tr>
      <?php }
	  if($rs['fee4']!="0"){
	  ?>
        <td>Other payment on other's behalf</td>
        <td align="right"><?php echo number_format($rs['fee4']);?>&nbsp;元</td>
        <td>&nbsp;</td>
      </tr>
      <?php }
	  $db1 = new DB;
	  $db1->query("SELECT * FROM `feesetting` WHERE `HospNo`='".$HospNo."' ");
	  $rs1 = $db1->fetch_assoc();
	  ?>
      <tr>
        <td>Subsidy</td>
        <td align="right"><?php echo number_format($rs1['allowance']);?>&nbsp;元</td>
        <td>&nbsp;</td>
      </tr>
      <tr class="newForReceipt">
		<td colspan="3">&nbsp;</td>
      </tr>    
      <tr>
		<td colspan="3">&nbsp;</td>
      </tr>    
    </table>
    <table width="100%" border="0" class="noborderForReceipt">
      <tr>
        <td>&nbsp;繳款金額：&nbsp;<?php echo number_format($rs['fee1']+$rs['fee2']+$rs['fee3']+$rs['fee4']-$rs1['allowance']);?>&nbsp;元</td>
        <td>&nbsp;代墊金額：&nbsp;<?php echo number_format($rs['fee3']+$rs['fee4']);?>&nbsp;元</td>
        <td>&nbsp;收據金額：&nbsp;<?php echo number_format($rs['fee1']+$rs['fee2']);?>&nbsp;元</td>
      </tr>
      <tr class="newForReceipt">
		<td colspan="3">&nbsp;</td>
      </tr>    
      <tr height="30">
        <td colspan="3">&nbsp;新臺幣(大寫)：&nbsp;<?php echo int2chnum($rs['fee1']+$rs['fee2']+$rs['fee3']+$rs['fee4']-$rs1['allowance']); ?>整</td>
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

