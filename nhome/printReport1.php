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

//模組名稱module name
$strModule = "firmstock";
$subModule = "firmstockinfo";

if(@$_GET['type'] == "IC"){
	$type="IC";
	$rName = "廠商Vendor";
	$typeName = "進貨entry";
	$dis = @$_GET['dis'];
}else{
	$type="SP";
	$rName = "院民resident";
	$typeName = "出貨ship";
}
if($_GET['FirmDiv'] <> ""){
	$fid = str_pad($_GET['FirmDiv'],4,'0',STR_PAD_LEFT);
}

	?>
<center>
<table border="0" bgcolor="#ffffff" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" style="border:none;">
    <div id="printarea"  class="printarea">
    <?php 
	$db = new DB;
	$dbCount = new DB;

	$q1 = "SELECT distinct(a.firmID) FROM `".$strModule."` a inner join `".$subModule."` b on";
	$q2 = "SELECT count(a.firmID) count FROM `".$strModule."` a inner join `".$subModule."` b on";
	$str .=" a.type=b.type and a.STK_Date=b.STK_Date and a.firmStockID=b.firmStockID inner join `arkstock` c on b.STK_NO=c.STK_NO ";
	$str .= "WHERE a.`type`='".$type."' and a.`STK_Date`>='".mysql_escape_string($_GET['date1'])."' and a.`STK_Date`<='".mysql_escape_string($_GET['date2'])."' AND a.IsStatus <> 'D'";
	$str .=" and left(a.firmID,4)<>'Area'";
	if($fid<>""){
		$str .=" and a.firmID='".$fid."'";
	}
	$db->query($q1.$str);
	$count1 =$db->num_rows();
//	echo $q1.$str;
	if($db->num_rows() > 0){
	  for ($i0=0;$i0<$db->num_rows();$i0++) {			
		$r= $db->fetch_assoc();
		$dbCount ->query($q2.$str." and a.firmID='".$r['firmID']."'");
		$Tcount = $dbCount->fetch_assoc();
		//echo $q2.$str." and a.firmStockID='".$r['firmStockID']."'";
		$db0 = new DB;
		$str0 = "SELECT *, RIGHT(EXTRACT(YEAR_MONTH FROM a.`STK_Date` ),4) ordDate, left(c.STK_NAME,25) STK_NAME FROM `".$strModule."` a inner join `".$subModule."` b on";
		$str0 .=" a.type=b.type and a.STK_Date=b.STK_Date and a.firmStockID=b.firmStockID inner join `arkstock` c on b.STK_NO=c.STK_NO ";
		$str0 .= "WHERE a.`type`='".$type."' and a.`STK_Date`>='".mysql_escape_string($_GET['date1'])."' and a.`STK_Date`<='".mysql_escape_string($_GET['date2'])."' AND a.IsStatus <> 'D'";
		$str0 .=" and left(a.firmID,4)<>'Area' ";
		  //if($fid<>""){
			  $str0 .=" and a.firmID='".$r['firmID']."'";
		  //}
		  $str0 .=" ORDER BY a.firmID, b.firmStockID, b.STK_NO ";	  
		//echo $str0;
		  $db0->query($str0);
		  if($db0->num_rows() > 0){
			  $page = 7;
			  $pageSize = ceil($db0->num_rows()/$page);
			  for ($i=0;$i<$db0->num_rows();$i++) {			
				  $r0 = $db0->fetch_assoc();
				  
					$db1 = new DB;
					$str1 = "SELECT count(a.firmStockID) sCount FROM `".$strModule."` a inner join `".$subModule."` b on";
					$str1 .=" a.type=b.type and a.STK_Date=b.STK_Date and a.firmStockID=b.firmStockID inner join `arkstock` c ";
					$str1 .=" on b.STK_NO=c.STK_NO WHERE a.`type`='".$type."' and a.`STK_Date`>='".mysql_escape_string($_GET['date1'])."' ";
					$str1 .=" and a.`STK_Date`<='".mysql_escape_string($_GET['date2'])."' AND a.IsStatus <> 'D' and left(a.firmID,4)<>'Area' ";
					$str1 .=" AND a.firmID ='".$r0['firmID']."' AND a.`firmStockID` = '".$r0['firmStockID']."'";
				    $db1->query($str1);
					if($db1->num_rows() > 0){
						$r1 = $db1->fetch_assoc();
						//echo  $r1['sCount'];
					}
					
//					echo $count1;
				  if((($i+1)%7==1)){
					  $count++;
				  ?>
				  <center><h4><?php echo $_SESSION['nOrgName_lwj']; ?></h4><h4><?php echo $rName; ?>對帳明細表reconciliation list</h4></center>
				  <table class="noborder2">
					<tr>
					  <td width="280" bgcolor="#FFFFFF">
                      <?php if($type=="IC"){?>
                      列印時間print date：<?php echo date('Y-m-d H:i:s'); ?>
                      <?php }else{?>
                      床號bed number：<span id="log4"><?php if ($fid=="") { echo getBedID(getPID($r0['firmID'])); } else { echo getBedID(getPID($fid)); } ?></span>
                      <?php }?>
                      </td>
					  <td bgcolor="#FFFFFF" align="right" width="320"> since&nbsp;<?php if (@$_GET['date1']=="") { echo date("Y/m/d"); } else { echo @$_GET['date1']; } ?> ~ <?php if (@$_GET['date2']=="") { echo date("Y/m/d"); } else { echo @$_GET['date2']; } ?> Until</td>
					</tr>
					<tr>
					  <td bgcolor="#FFFFFF">
                      <?php if($type=="IC"){?>
                      廠商vendor:<?php if ($fid=="") { echo $r0['firmID']; } else { echo $fid; } ?>
                          <span id="log0"><?php if ($fid=="") { echo getFirmName($r0['firmID']); } else { echo getFirmName($fid); } ?></span>                      
                      <?php }else{?>
                      院民resident：<?php if ($fid=="") { echo $r0['firmID']; } else { echo $fid; } ?>
					  	  <span id="log0"><?php if ($fid=="") { echo getPatientName(getPID($r['FirmDiv'])); } else { echo getPatientName(getPID($fid)); } ?></span>
                      <?php }?>
					  </td>
					  <td align="right"  bgcolor="#FFFFFF" ><?php echo ($dis==1 ? "(Purchase)" : "(With return)"); ?>&nbsp;頁次page:<?php echo $count;?></td>
					</tr> 
				  </table>
				  <?php 
					
				  echo '			  
				  <table width="100%" class="noborder">
				  
					<tr class="bLineT">
					  <td width="75" >'.$typeName.'單號list number</td>
					  <td width="62">'.$typeName.'Date</td>
					  <td width="180" align="center">稅別名稱tax name</td>	
					  <td width="63" >發票號碼invoice</td>	
					  <td width="220" colspan="4">Note</td>	
					</tr>'."\n".'
					<tr class="bLineB">
					  <td width="75">&nbsp;</td>
					  <td width="62">Product serial number</td>
					  <td width="180">product name</td>
					  <td width="63">Unit</td>
					  <td width="54">Storage name</td>	
					  <td width="54">'.$typeName.'Unit price</td>	
					  <td width="54">'.$typeName.'Quantity</td>	
					  <td width="54">'.$typeName.'Amount</td>		
					</tr>'."\n";
				  }

					if($temp1 != $r0['type'].$r0['ordDate'].$r0['firmStockID']){	
						$aa=0;
					}
					if ($i==0) {
						$NET1 = 0;
						$TAX1 = 0;
						$TOT1 = 0;
					}
					if($dis==2){
						$db0_2 = new DB;
						$str2 = "SELECT * FROM  `firmstock` a INNER JOIN  `firmstockinfo` b ON a.firmStockID = b.firmStockID ";
						$str2 .=" AND a.type = b.type AND a.STK_DATE = b.STK_DATE WHERE a.type = 'OC' AND a.`IsStatus` <> 'D'";
						$str2 .="AND a.IN_firmStockID = '".$r0['type'].$r0['ordDate'].$r0['firmStockID']."' and b.STK_NO='".$r0['STK_NO']."'";
			
						$db0_2->query($str2);
						if($db0_2->num_rows() > 0){
							$r0_2 = $db0_2->fetch_assoc();
							$disQTY = $r0['QTY']-$r0_2['QTY'];
							$disPrice = $r0['Price'];
						}else{
							$disQTY = $r0['QTY'];
							$disPrice = $r0['Price'];				
						}	
						$db0_3 = new DB;
						$str3 = "SELECT SUM(  `STK_NET` ) NET, SUM(  `STK_TAX` ) TAX, SUM(  `STK_TOT` ) TOT";
						$str3 .= " FROM  `firmstock` a";
						$str3 .= " INNER JOIN  `firmstockinfo` b ON a.firmStockID = b.firmStockID";
						$str3 .= " AND a.type = b.type";
						$str3 .= " AND a.STK_DATE = b.STK_DATE";
						$str3 .= " WHERE a.type =  'OC' ";
						$str3 .= " AND a.`IsStatus` <>  'D'";
						$str3 .= " AND a.IN_firmStockID =  '".$r0['type'].$r0['ordDate'].$r0['firmStockID']."' ";			
						$db0_3->query($str3);
						if($db0_3->num_rows() > 0){
							$r0_3 = $db0_3->fetch_assoc();
						}						
						if($temp1 != $r0['type'].$r0['ordDate'].$r0['firmStockID']){	
						  $NET = $r0['STK_NET']- $r0_3['NET'];
						  $TAX = $r0['STK_TAX']- $r0_3['TAX'];
						  $TOT = $r0['STK_TOT']- $r0_3['TOT'];
						  $NET1 += $NET;
						  $TAX1 += $TAX;
						  $TOT1 += $TOT;
						}
					}else{
					  $disQTY = $r0['QTY'];
					  $disPrice = $r0['Price'];
					  
					  if($temp1 != $r0['type'].$r0['ordDate'].$r0['firmStockID']){	
						$NET = $r0['STK_NET'];
						$TAX = $r0['STK_TAX'];
						$TOT = $r0['STK_TOT'];	
						$NET1 += $NET;
						$TAX1 += $TAX;
						$TOT1 += $TOT;
					  }
					}	
				  if($aa == 0){
					echo '
					<tr>
					  <td align="center" valign="top" width="75">'.$r0['type'].$r0['ordDate'].$r0['firmStockID'].'</td>
					  <td align="center" valign="top" width="62">'.$r0['STK_Date'].'</td>
					  <td align="center" valign="top" width="180">&nbsp;'.($r0['Tax_1']==1 ? "Taxable" : "Exemption").'</td>
					  <td align="left" width="63">&nbsp;'.$r0['ReceiptNO'].'</td>
					  <td align="right" colspan="4" width="220">&nbsp;'.$r0['Fmark'].'</td>	
					</tr>'."\n";
				  }
				  echo '
				  <tr>
					<td align="center" width="75">&nbsp;</td>
					<td align="center" valign="top" width="62">&nbsp;'.$r0['STK_NO'].'</td>
					<td align="left" width="180">&nbsp;'.$r0['STK_NAME'].'</td>
					<td align="center" width="63">&nbsp;'.$r0['STK_UNIT'].'</td>	
					<td align="center" valign="top" width="53">'.getStockName($r0['StockID']).'</td>
					<td align="right" width="53">&nbsp;'.$disPrice.'</td>	
					<td align="right" width="53">&nbsp;'.$disQTY.'</td>	
					<td align="right" width="53">&nbsp;'.$disQTY*$disPrice.'</td>		
				  </tr>'."\n";
				  
				  if(($aa+1) == $r1['sCount']){					  
				  //<table class="noborder" width="100%">
					echo '					
					<tr><td colspan="8" width="609" align="right" class="bLineB1">小計subtotal：'.$r1['sCount'].' 筆data，';
					if(getFirmDiscount($r0['firmID']) > 0){
						echo '('.getFirmDiscount($r0['firmID']).'%折扣後after discount)，';
					}					
					echo '
					'.$typeName.'net amount： $ '.$NET.'，'.$typeName.' tax amount： $ '.$TAX.'，'.$typeName.' total amount： $ '.$TOT.'&nbsp;</td>
					</tr>';
				  }
				  
				  if ($i==($Tcount['count']-1) || ($i+1)%7==0) {
					  echo '</table>';
				  }
				  
				  if(($i==($db0->num_rows()-1))){	
					echo '
					<table class="noborder" width="100%">
					<tr class="bLineB"><td colspan="8" width="609" align="right" >totally：'.$db0->num_rows().'  data,'.$typeName.' net amount： $ '.$NET1.'，'.$typeName.' tax amount： $ '.$TAX1.'，'.$typeName.' total amount： $ '.$TOT1.'&nbsp;</td>
					</tr>
					</table>';
				  }
				  if(($i+1)%7==0){$count1++;}				  
				  if(($i==($Tcount['count']-1) || ($i+1)%7==0)){ 
				  	if($count !=$count1){
				  		echo '<P style="page-break-after:always"></P>'."\n"; 
				  	}
				  }
				  $temp = $r0['firmID'];
				  $temp1 = $r0['type'].$r0['ordDate'].$r0['firmStockID'];
				  if( $temp1 == $r0['type'].$r0['ordDate'].$r0['firmStockID']){
					  $aa++;
				  }
				  //echo $aa;
			  }//end for
		  }//end if
	  }//end for
	}//end if
	?><!--here-->
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