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
body { font-size:11pt; line-height:20px; padding:0; margin:0; font-family: "Times New Roman", "標楷體"; }
.drawformborder { border:none; display:block; padding:0; }
.drawformborder tr { border:none; display:block; }
.drawformborder tr.title { border-top:2px solid; border-bottom:2px solid; }
.drawformborder .title td { font-size:10pt; font-weight:bold; }
.drawformborder tr.title2 { border-top:1px solid; padding-bottom:16px; }
.drawformborder .title2 td { font-size:10pt; }
.drawformborder td { border:none; display:inline-block; vertical-align:top;}
.drawformborder .footer { display:block; line-height:120px; height:120px; border:none; text-align:right; }
</style>
</head>

<body>
<table cellspacing="0" cellpadding="0" width="980" align="center">
  <tr>
    <td align="left" height="30" valign="middle"><font size="4">健順養護中心institution's 維修清單maintenance list [<?php if (@$_GET['status']==0) { echo 'Unprocessed'; } elseif (@$_GET['status']==1) { echo 'Processing'; } elseif (@$_GET['status']==2) { echo 'Processed'; } elseif (@$_GET['status']==3) { echo 'All'; } ?>] (<?php echo @$_GET['date1'].'~'.@$_GET['date2']; ?>)</font></td>
    <td align="right">
    <?php
	if ($_GET['order']==1) {
		echo "按地點排序sort by location";
	} elseif ($_GET['order']==2) {
		echo "按項目排序sort by item";
	} elseif ($_GET['order']==3) {
		echo "按申請日期排序sort by apply date";
	} elseif ($_GET['order']==4) {
		echo "按維修日期排序sort by maintain date";
	}
	?>
    </td>
  </tr>
</table>
<table class="drawformborder" cellspacing="0" cellpadding="0" width="980" align="center">
  <tr class="title">
    <td width="4%" align="center">Serial number</td>
    <td width="8%" align="center">Apply date</td>
    <td width="12%">Location</td>
    <td width="12%">Damage item</td>
    <td width="12%">Damage status</td>
    <td width="9%" align="center">Applicant</td>
    <td width="8%" align="center">Maintain date</td>
    <td>Maintenance status</td>
    <td width="15%">Maintenance detail</td>
    <td align="center">Maintain staff</td>
  </tr>
  <?php
  if (@$_GET['status']==NULL) {
	  $sql = "SELECT * FROM `maintenance` WHERE `status`='0'";
  } elseif (@$_GET['status']!=3) {
	  $sql = "SELECT * FROM `maintenance` WHERE `status`='".mysql_escape_string($_GET['status'])."'";
  } else {
	  $sql = "SELECT * FROM `maintenance` WHERE 1 ";
  }
  
  if (@$_GET['date1']!=NULL && @$_GET['date2']!=NULL) {
	  $sql .= " AND (`ApplyDate`>='".mysql_escape_string($_GET['date1'])."' AND `ApplyDate`<='".mysql_escape_string($_GET['date2'])."')";
  }
  if (@$_GET['order']==0) {
	  $sql .= " ORDER BY `ApplyDate`, `ApplyFloor` ASC";
  } elseif (@$_GET['order']==1) {
	  $sql .= " ORDER BY `ApplyFloor`, `ApplyDate` ASC";
  } elseif (@$_GET['order']==2) {
	  $sql .= " ORDER BY `ApplyContent1`, `ApplyFloor` ASC";
  } elseif (@$_GET['order']==3) {
	  $sql .= " ORDER BY `ApplyDate`, `ApplyFloor` ASC";
  } elseif (@$_GET['order']==4) {
	  $sql .= " ORDER BY `RepairDate`, `ApplyFloor` ASC";
  }
  $db = new DB;
  $db->query($sql);
  $status0count = 0;
  $status1count = 0;
  $status2count = 0;
  $T0count = 0;
  $T1count = 0;
  $T2count = 0;
  for($i=0;$i<$db->num_rows();$i++) {
	  $r = $db->fetch_assoc();
	  if ($_GET['order']==1) {
		  //Location
		  if ($i>0 && $temp!=$r['ApplyFloor']) {
			  echo '
			  <tr class="title2">
			    <td width="100%" colspan="10" align="right">小計subtital '.$RowCount.' 筆number [未維修not yet maintain] '.$status0count.' 筆number [處理中processing] '.$status1count.' 筆number [已維修maintain complete] '.$status2count.' 筆number </td>
			  </tr>'."\n";
			  $RowCount = 0;
			  $status0count = 0;
			  $status1count = 0;
			  $status2count = 0;
		  }
	  } elseif ($_GET['order']==2) {
		  //項目item
		  if ($i>0 && $temp!=$r['ApplyContent1']) {
			  echo '
			  <tr class="title2">
			    <td width="100%" colspan="10" align="right">小計subtital '.$RowCount.' 筆number [未維修not yet maintain] '.$status0count.' 筆number [處理中processing] '.$status1count.' 筆number [已維修maintain complete] '.$status2count.' 筆number </td>
			  </tr>'."\n";
			  $RowCount = 0;
			  $RowCount = 0;
			  $status0count = 0;
			  $status1count = 0;
			  $status2count = 0;
		  }
	  } elseif ($_GET['order']==3) {
		  //Date
		  if ($i>0 && $temp!=$r['ApplyDate']) {
			  echo '
			  <tr class="title2">
			    <td width="100%" colspan="10" align="right">小計subtital '.$RowCount.' 筆number [未維修not yet maintain] '.$status0count.' 筆number [處理中processing] '.$status1count.' 筆number [已維修maintain complete] '.$status2count.' 筆number </td>
			  </tr>'."\n";
			  $RowCount = 0;
			  $RowCount = 0;
			  $status0count = 0;
			  $status1count = 0;
			  $status2count = 0;
		  }
	  } elseif ($_GET['order']==4) {
		  //Date
		  if ($i>0 && $temp!=$r['RepairDate']) {
			  echo '
			  <tr class="title2">
			    <td width="100%" colspan="10" align="right">小計subtital '.$RowCount.' 筆number [未維修not yet maintain] '.$status0count.' 筆number [處理中processing] '.$status1count.' 筆number [已維修maintain complete] '.$status2count.' 筆number </td>
			  </tr>'."\n";
			  $RowCount = 0;
			  $RowCount = 0;
			  $status0count = 0;
			  $status1count = 0;
			  $status2count = 0;
		  }
	  }
	$arrContent = explode("_",$r['ApplyContent1']);
	foreach ($arrContent as $k=>$v){
		if(count($arrContent) ==2){
			$content = getTitle("property","p_name",$arrContent[0],"propertyID","p_no").($arrContent[1] !=""?"，".$arrContent[1]:"");
		} else{
			$content = $r['ApplyContent1'];
		}
	}
	  
	  echo '
	<tr>
	  <td align="center" width="4%">'.(int)$r['mainID'].'</td>
      <td align="center" width="8%">'.$r['ApplyDate'].'</td>
	  <td width="12%">'.$r['ApplyFloor'].'</td>
	  <td width="12%">'.$content.'</td>
	  <td width="12%">'.$r['ApplyContent2'].'</td>
      <td align="center" width="9%">'.checkusername($r['Applicant']).'</td>
	  <td align="center" width="8%">'.($r['RepairDate']==""?"&nbsp;":$r['RepairDate']).'</td>
	  <td>'; if ($r['status']==0) { echo '未處理not yet process'; $status0count++; $T0count++; } elseif ($r['status']==1) { echo '處理中processing'; $status1count++; $T1count++; } elseif ($r['status']==2) { echo '已處理complete'; $status2count++; $T2count++; } echo '</td>
	  <td width="15%">'.($r['RepairContent']==""?"&nbsp;":$r['RepairContent']).'</td>
	  <td align="center">'.($r['Repairer']==""?"&nbsp;":checkusername($r['Repairer'])).'</td>
	</tr>'."\n";
	  if ($_GET['order']==1) {
		  //Location
		  $temp = $r['ApplyFloor'];
	  } elseif ($i>0 && $_GET['order']==2) {
		  //項目item
		  $temp = $r['ApplyContent1'];
	  } elseif ($i>0 && $_GET['order']==3) {
		  //Apply date
		  $temp = $r['ApplyDate'];
	  } elseif ($i>0 && $_GET['order']==4) {
		  //維修日期maintain date
		  $temp = $r['RepairDate'];
	  }
	  $RowCount++;
	  $TRowCount++;
  }
  echo '
              <tr class="title2">
			    <td width="100%" colspan="10" align="right">小計subtital '.$RowCount.' 筆number [未維修not yet maintain] '.$status0count.' 筆number [處理中processing] '.$status1count.' 筆number [已維修maintain complete] '.$status2count.' 筆number </td>
			  </tr>
			  <tr class="title">
			    <td width="100%" colspan="10" align="right">Totally  '.$TRowCount.' 筆number [未維修not yet maintain] '.$T0count.' 筆number [處理中processing] '.$T1count.' 筆number [已維修maintain complete] '.$T2count.' 筆number </td>
			  </tr>'."\n";
?>
  <tr style="border:none;">
    <td colspan="9" height="50" class="footer" width="100%">Administrator:<div style="display:inline; border-bottom:1px solid #000; width:200px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Vice administrator:<div style="display:inline; border-bottom:1px solid #000; width:200px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Unit supervisor:<div style="display:inline; border-bottom:1px solid #000; width:200px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;General work section:<div style="display:inline; border-bottom:1px solid #000; width:200px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></td>
  </tr>
</table>
</body>
</html>