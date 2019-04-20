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
body { padding:0; margin:0; font-family: "Times New Roman", "標楷體"; font-size:11pt;}
.drawformborder { border:solid 1px; border-collapse:collapse;}
.drawformborder tr { border:solid 1px; height:24px; }
.drawformborder td { border:solid 1px; }
.title { font-weight:bold; }
</style>
</head>
<body>
<?php 
$date1=substr($_POST['selmonth'],0,4);
$date2=substr($_POST['selmonth'],5,2);
$dateT=lastday($date2, $date1);
if($_POST['view']==1){
	$postID = $_POST['EmpID'];
	$EmpGroup = 1;
}else{
	$postID = $_POST['foreignID'];
	$EmpGroup = 2;
}
$Counter=count($postID);
if($Counter >0){	
	$arrTitle = array('1'=>'(Monthly) attendance sheet','2'=>'Work days statistical tables');
	foreach($postID as $k=>$v){
		//Profile
		if($_POST['view']==1){
			$strSQL = "SELECT * FROM `employer` WHERE `EmpID`='".$v."' ORDER BY `EmpID` ASC";
		}else{
			$strSQL = "SELECT * FROM `foreignemployer` WHERE `foreignID`='".$v."' ORDER BY `foreignID` ASC";
		}
		$db5a = new DB;
		$db5a->query($strSQL);
		$r5a = $db5a->fetch_assoc();
		if($EmpGroup==1){
			$Name = $r5a['Name'];
			$position = $r5a['Position'];
		}else{
			$Name = $r5a['eNickname'].$r5a['cNickname'];
			$position = $r5a['position'];
		}
		
?>
<table width="100%" style="border:none;">
  <tr>
    <td><center><font size="5"><b><?php echo $_SESSION['nOrgName_lwj']; ?></b></font><br /><font size="4"><b><?php echo $arrTitle[$_POST['title']];?></b></font></center>
    </td>
  </tr>
  <tr>
    <td><center><font size="3">月份：<?php echo $_POST['selmonth'];?>　姓名：<?php echo $Name;?>　職稱：<?php echo $position;?>　</b></font></center></td>
  </tr>
</table>
<?php 
if($_POST['title']==1){
?>
<!--考勤表-->
<table width="100%" class="drawformborder">
	<tr>
    	<th width="60">Date</th>
    	<th width="150">起時</th>
    	<th width="150">訖時</th>
    	<th width="200">工作內容</th>
    	<th width="40">加班時數</th>
    	<th width="40">請假時數</th>
    	<th width="40">累計時數</th>
    	<th width="40">主管簽核</th>
    </tr>
    <?php 
	for($i=1;$i<=$dateT;$i++){
		//刷卡紀錄
		$db5b = new DB;
		$db5b->query("SELECT * FROM `humanresource11` WHERE `EmpID`='".$v."' AND `EmpGroup`='".$EmpGroup."' AND DATE_FORMAT(`startdate`, '%Y-%m-%d') ='".mysql_escape_string($_POST['selmonth']).'-'.str_pad($i,2,"0",STR_PAD_LEFT)."'");
		//echo "SELECT * FROM `humanresource11` WHERE `EmpID`='".$v."' AND `EmpGroup`='1' AND `startdate` ='".mysql_escape_string($_POST['selmonth']).'-'.str_pad($i,2,"0",STR_PAD_LEFT)."'<br>";
		$r5b = $db5b->fetch_assoc();
		//print_r($r5b);		
		echo '
		<tr>
			<td align="center">'.$i.'</td>
			<td align="center">'.$r5b['startdate'].'</td>
			<td align="center">'.$r5b['enddate'].'</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		';
	}	
	?>
</table>
<br />
<table class="drawformborder" width="100%">
	<tr>
        <td align="center" width="160">本月應上班天數</td>
        <td width="90">&nbsp;</td>
        <td align="center" width="130">本月請假天數</td>
        <td width="90">&nbsp;</td>
        <td align="center" width="130">本月未休天數</td>
        <td width="90">&nbsp;</td>
        <td align="center" width="130">年假</td>
        <td width="90">&nbsp;</td>
    </tr>
	<tr>
        <td align="center">實際上班天數</td>
        <td>&nbsp;</td>
        <td align="center">請假類別</td>
        <td>&nbsp;</td>
        <td align="center">上月未休天數</td>
        <td>&nbsp;</td>
        <td align="center">已休年假</td>
        <td>&nbsp;</td>
    </tr>
	<tr>
        <td align="center">本月加班時數</td>
        <td>&nbsp;</td>
        <td align="center">下月預排休假</td>
        <td>&nbsp;</td>
        <td align="center">累計未休天數</td>
        <td>&nbsp;</td>
        <td align="center">未休年假</td>
        <td>&nbsp;</td>
    </tr>
</table>
<!--考勤表-->
<?php 
}else{
?>
<!--Work days statistical tables-->
<table width="100%">
	<tr>
    <?php for($i1=0;$i1<2;$i1++){?>
    	<td width="50%" valign="top">
        	<table class="drawformborder" width="100%" style="font-size:10px; line-height:14px;">
            	<tr>
                    <th width="60">Date<br>Date</th>
                    <th width="150">起時<br>Reg Work Hour</th>
                    <th width="150">訖時</th>
                    <th width="200">第一次兩小時加班<br>1<sup>ST</sup>2hrOT</th>
                    <th width="200">第二小時加班<br>2<sup>nd</sup>2hrOT</th>
                    <th width="200">第三次兩小時加班<br>3<sup>rd</sup>2hrOT</th>
                </tr>
				<?php 
				if($i1==0){
					$count = 1;
					$dateCount = 15;
				}else{
					$count = 16;
					$dateCount = $dateT;
				}
                for($i=$count;$i<=$dateCount;$i++){
                    //刷卡紀錄
                    $db5b = new DB;
                    $db5b->query("SELECT * FROM `humanresource11` WHERE `EmpID`='".$v."' AND `EmpGroup`='".$EmpGroup."' AND DATE_FORMAT(`startdate`, '%Y-%m-%d') ='".mysql_escape_string($_POST['selmonth']).'-'.str_pad($i,2,"0",STR_PAD_LEFT)."'");
                    //echo "SELECT * FROM `humanresource11` WHERE `EmpID`='".$v."' AND `EmpGroup`='1' AND `startdate` ='".mysql_escape_string($_POST['selmonth']).'-'.str_pad($i,2,"0",STR_PAD_LEFT)."'<br>";
                    $r5b = $db5b->fetch_assoc();
                    //print_r($r5b);		
                    echo '
                    <tr>
                        <td align="center">'.$i.'</td>
                        <td align="center">'.substr($r5b['startdate'],5,5).'<br>'.substr($r5b['startdate'],11,8).'</td>
                        <td align="center">'.substr($r5b['enddate'],5,5).'<br>'.substr($r5b['enddate'],11,8).'</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    ';
                }	
                ?>
            </table>
        </td>
    <?php }?>    
    </tr>
</table>
<br />
<table class="drawformborder" width="100%" style="font-size:10px; line-height:12px;">
	<tr>
        <td align="center" width="130">本月請假天數 NO.OF DAYS SICK LEAVE jumlah hari cuti sakit</td>
        <td width="90">&nbsp;</td>
        <td align="center" width="130">請假類別SICK LEAVE REASON alasan cuti sakit</td>
        <td width="90">&nbsp;</td>
        <td align="center" width="130">下月預排休假Request off next mo. / permintaan libur bulan berikutnya</td>
        <td width="90">&nbsp;</td>
    </tr>
	<tr>
        <td align="center" width="130">備註：REMARKS keterangan</td>
        <td width="90" colspan="3">&nbsp;</td>
        <td align="center" width="130">SIGNATURE tanda tangan</td>
        <td width="90">&nbsp;</td>
    </tr>
	<tr>
	    <td align="left">Computations / penggajian:Basic Salary / gaji pokok</td>
	    <td colspan="2">基本薪資&nbsp;</td>
	    <td align="left">Deductions/pemotongan: (For authorized person only/utk yg berwenang) Gross Total/Total gaji kotor;</td>
	    <td colspan="2">合計&nbsp;</td>
    </tr>
	<tr>
	    <td align="left">OT.1<sup>ST</sup>2hours/2jim lembur pertama </td>
	    <td colspan="2"> 79 X _______  =  ____________</td>
	    <td align="left">PC/Goods/Fare/Penalty / PC/barang/denda/hukuman</td>
	    <td colspan="2">購物 &nbsp;</td>
    </tr>
	<tr>
	    <td align="left">OT.2<sup>nd</sup>2hours/2jim lembur kedua</td>
	    <td colspan="2">105 X _______  =  ____________</td>
	    <td align="left">Food and Accomodation / makan dan tinggal</td>
	    <td colspan="2">膳食費 &nbsp;</td>
    </tr>
	<tr>
	    <td align="left">OT.3<sup>rd</sup>2hours/2jim lembur kedua</td>
	    <td colspan="2">131 X _______  =  ____________</td>
	    <td align="left">Medical/ARC / medikal/ARC</td>
	    <td colspan="2">Physical examination &nbsp;</td>
    </tr>
	<tr>
	    <td align="left">Others(Vac.Pay;leader)/lain-lain(pembayaran vac.,ketua)</td>
	    <td colspan="2"></td>
	    <td align="left">Others(Electric Bill, Hosp. Fee)/Lainnya (biaya listrik, biaya rumah sakit) </td>
	    <td colspan="2">水電 &nbsp;</td>
    </tr>
	<tr>
	    <td align="left">Gross Total / total gaji kotor</td>
	    <td colspan="2">未假渡假給薪、主管加給</td>
	    <td align="left">Net Total / gaji bersih total </td>
	    <td colspan="2">&nbsp; </td>
    </tr>
</table>
<!--Work days statistical tables-->
<?php }?>
<p style="page-break-after:always"></p>
<?php 
	}
}?>

</body>
</html>