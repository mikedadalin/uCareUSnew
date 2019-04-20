<?php
session_start();
include("lwj/lwj.php");
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
	
//模組名稱module name
$strModule = "firmstock";
$subModule = "firmstockinfo";
$type = $_GET['type'];//"SP";
$typeName = "出貨shipping";
if($_GET['FirmDiv'] <> ""){
	//$fid = str_pad($_GET['FirmDiv'],6,'0',STR_PAD_LEFT);
	$fid = getHospNo(getPIDByHospNoDisplay($_GET['FirmDiv']));
}
$arrSPno = array();
?>
<center>
<table border="0" bgcolor="#ffffff" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" style="border:none;">
    <div id="printarea"  class="printarea">
    <?php 
	$db = new DB;
	$dbCount = new DB;
	$q2 = "couont";
	$q1 = "SELECT distinct(a.firmID) FROM `".$strModule."` a inner join `".$subModule."` b on";
	$q2 = "SELECT count(a.firmID) count FROM `".$strModule."` a inner join `".$subModule."` b on";
	$str .=" a.type=b.type and a.STK_Date=b.STK_Date and a.firmStockID=b.firmStockID inner join `arkstock` c on b.STK_NO=c.STK_NO ";
	$str .= "WHERE a.`type`='".$type."' and a.`STK_Date`>='".mysql_escape_string($_GET['date1'])."' and a.`STK_Date`<='".mysql_escape_string($_GET['date2'])."' AND a.IsStatus <> 'D'";
	$str .=" and left(a.firmID,4)<>'Area'";
	if($fid<>""){
		$str .=" and a.firmID='".$fid."'";
	}
	$db->query($q1.$str);
//	echo $q1.$str;
	if($db->num_rows() > 0){
	  $count1 =$db->num_rows();
	  for ($i0=0;$i0<$db->num_rows();$i0++) {			
		$r= $db->fetch_assoc();
		$dbCount ->query($q2.$str." and a.firmID='".$r['firmID']."'");
		$Tcount = $dbCount->fetch_assoc();
		//echo $r['firmID'].':'.$Tcount['count']."<br>";
		$db0 = new DB;
		$str0 = "SELECT *, RIGHT(EXTRACT(YEAR_MONTH FROM a.`STK_Date` ),4) ordDate FROM `".$strModule."` a inner join `".$subModule."` b on";
		$str0 .=" a.type=b.type and a.STK_Date=b.STK_Date and a.firmStockID=b.firmStockID "; /*inner join `arkstock` c on b.STK_NO=c.STK_NO */
		$str0 .= "WHERE a.`type`='".$type."' and a.`STK_Date`>='".mysql_escape_string($_GET['date1'])."' and a.`STK_Date`<='".mysql_escape_string($_GET['date2'])."' AND a.IsStatus <> 'D'";
		$str0 .=" and left(a.firmID,4)<>'Area'";
		  //if($fid<>""){
			  $str0 .=" and a.firmID='".$r['firmID']."'";
		  //}
		  $str0 .=" ORDER BY a.firmID, b.STK_NO, b.STK_DATE ";	  
		
		
		  $db0->query($str0);
		  //echo $str0;
		  if($db0->num_rows() > 0){
			  $page = 15;
			  $pageSize = ceil($db0->num_rows()/$page);
			  for ($i=0;$i<$db0->num_rows();$i++) {			
				  $r0 = $db0->fetch_assoc();
				  if((($i+1)%15==1)){
					  $count++;
				  ?>
				  <center><h3><?php echo $_SESSION['nOrgName_lwj']; ?></h3><h3>Resident reconciliation list</h3></center>
				  <table class="noborder2">
					<tr>
					  <td width="280" bgcolor="#FFFFFF">床號bed number：<span id="log4"><?php if ($fid=="") { echo getBedID(getPID($r0['firmID'])); } else { echo getBedID(getPID($fid)); } ?></span></td>
					  <td bgcolor="#FFFFFF" align="right" width="320"> since&nbsp;<?php if (@$_GET['date1']=="") { echo date("Y/m/d"); } else { echo @$_GET['date1']; } ?> ~ <?php if (@$_GET['date2']=="") { echo date("Y/m/d"); } else { echo @$_GET['date2']; } ?> Until</td>
					</tr>
					<tr>
					  <td bgcolor="#FFFFFF">院民 Resident：<?php echo getHospNoDisplayByHospNo($r0['firmID']); ?>&nbsp;
<span id="log0"><?php if ($fid=="") { echo getPatientName(getPID($r0['firmID'])); } else { echo getPatientName(getPID($r0['firmID'])); } ?></span>					  </td>
					  <td align="right"  bgcolor="#FFFFFF" >頁次:<?php echo $count;?></td>
					</tr> 
				  </table>
				  <?php 
					
				  echo '			  
				  <table width="100%" class="noborder">
					<tr class="bLineT bLineB">
					  <td width="80" align="center">出貨日期ship date</td>
					  <td width="80" align="center">出貨單號ship number</td>
					  <td width="60" align="center">Product serial number</td>
					  <td width="185" >product name</td>
					  <td width="40" align="center">Quantity</td>	
					  <td width="55" align="center">Unit</td>
					  <td width="45" align="center">Unit price</td>	
					  <td width="55" align="center">出貨金額ship product total price</td>		
					</tr>'."\n";
				  }
				  $disQTY = $r0['QTY'];
				  $disPrice = $r0['Price'];
				  
				  if ($i==0) {
					  $NET = 0;
					  $TAX = 0;
					  $TOT = 0;
					  $TOT2 = 0;
				  }
				  //if ($r0['type'].$r0['ordDate'].$r0['firmStockID']!=$tmp_no) {
				  if (!in_array($r0['type'].$r0['ordDate'].$r0['firmStockID'], $arrSPno)) {
					  if (substr($r0['STK_NO'],0,1)!='3') { $NET += $r0['STK_NET']; $TAX += $r0['STK_TAX']; }
					  if (substr($r0['STK_NO'],0,1)=='3') { $TOT2 += $r0['STK_TOT']; $type3count++; } else { $TOT += $r0['STK_TOT']; }
					  array_push($arrSPno, $r0['type'].$r0['ordDate'].$r0['firmStockID']);
				  }
				  if (substr($r0['STK_NO'],0,1)!='3') { $sum1no++; } else { $sum3no++; }
				  if ($type3count==1) {
					  echo '
				  <tr class="bLineB">
				    <td colspan="8" align="right" width="615" >Subtotal:'.$sum1no.' data ,金額小計：$'.($TOT).'&nbsp;</td>
				  </tr>
					  ';
				  }
				  echo '
				  <tr>
					<td align="center" width="80">'.$r0['STK_Date'].'</td>
					<td align="center" width="80">'.$r0['type'].$r0['ordDate'].$r0['firmStockID'].'</td>
					<td align="center" width="60">'.$r0['STK_NO'].'</td>
					<td align="left" width="185">'.STK_NAME($r0['STK_NO']).'</td>
					<td align="right" width="40">'.$disQTY.'</td>	
					<td align="center" width="55">'.$r0['STK_UNIT'].'</td>	
					<td align="right" width="45">'.$disPrice.'</td>	
					<td align="right" width="55">'.$disQTY*$disPrice.'</td>
				  </tr>'."\n";
				  
				  $tmp_no = $r0['type'].$r0['ordDate'].$r0['firmStockID'];
				  
				  if (($i+1)%15==0) {
					  echo '</table>';
				  }
				  if(($i==($db0->num_rows()-1))){	
					echo '
					<table class="noborder" width="100%">
					<tr class="bLineB">
					<td colspan="8" align="right" width="615" >Subtotal:'.$sum3no.' data ,金額小計：$'.($TOT2).'&nbsp;</td>
					</tr>
					<tr>
					<td colspan="8" align="right" width="615" >合計：'.($sum1no + $sum3no).' data ,金額總計：$'.($TOT + $TOT2).'&nbsp;</td>
					</tr>
					</table>';
				  }
				  if(($i+1)%15==0){$count1++;}
				  if($i==($Tcount['count']-1) || ($i+1)%15==0){ 
				  	if($count !=$count1){
				  		echo '<P style="page-break-after:always"></P>'."\n"; 
				  	}
				  }
				  $temp = $r0['firmID'];
			  }//end for
		  }//end if
	  }//end for
	}//end if
	?><!--here-->
    </div>
    </td>
  </tr>
</table><br><br>
</center>
<?php
}//end if
?>

</body>
</html>