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
<table width="100%" style="border:none;">
  <tr>
    <td><center><font size="5"><b><?php echo $_SESSION['nOrgName_lwj']; ?></b></font></center></td>
  </tr>
  <?php if($_POST['report1']!=""){?>
  <tr>
    <td>&nbsp;<br /><center><font size="5"><b><?php echo $_POST['report1'];?></b></font></center></td>
  </tr>
  <?php }?>
</table>
<?php 
$Counter=count($_POST['EmpID']);
$arrTitleE = array('Job title'=>'Position', 'Full name'=>'Name', 'Gender'=>'Gender', 'DOB'=>'Birth', 'Social Security number'=>'IdNo', 'Date of reporting for duty'=>'Startdate', 'Education'=>'Qschool', 'Phone'=>'Phone', 'Address'=>'Address', 'Tax form'=>'aNo1', '84-1核備'=>'aNo2', 'Physical examination status'=>'phyexam', '體檢追蹤'=>'petrack', '在職訓練'=>'training');
$arrUseTitle = array();
if($Counter >0){
	$arrTitle = explode(";",$_POST['title']);
?>
<table width="100%" class="drawformborder">
    <tr>
        <?php 
		for($i1=0;$i1<count($arrTitle)-1;$i1++){
			echo '
				<td '.($_POST['report1']!=""?"rowspan=2":"").' align="center">'.$arrTitle[$i1].'</td>	
			';
			$arrUseTitle[$i1] = $arrTitleE[$arrTitle[$i1]];
		}
		?>
<!--        <td rowspan="2" align="center">Full name</td>
        <td rowspan="2" align="center">Date of reporting for duty</td>
-->        <?php if($_POST['report1']!=""){?>
        <td rowspan="2" align="center">Resignation date</td>
		<?php 
        $arrY = array();
        for($i=(date("Y")-4);$i<date("Y");$i++){
        ?>    
            <td colspan="4" align="center"><?php echo $i-1911;?>year physical examination report</td>
        <?php 
        array_push($arrY,$i);
        }
        ?>        
        </tr>
        <tr>
        <?php for($i=0;$i<=3;$i++){?>
            <td>Chest X-ray</td>
            <td>Test items</td>
            <td>Physicians recommendation</td>
            <td>Follow-up</td>
        <?php }?>    
    	<?php }?>
    </tr>
	<?php
    foreach($_POST['EmpID'] as $k=>$v){
		
		//Profile
		$db5a = new DB;
		$db5a->query("SELECT * FROM `employer` WHERE `EmpID`='".$v."' ORDER BY `EmpID` ASC");
		$r5a = $db5a->fetch_assoc();
			//Date of reporting for duty
			if ($r5a['Enddate1']==NULL){
				$StartDate = $r5a['Startdate1'];
			} elseif ($r5a['Startdate2']!=NULL && $r5a['Enddate2']==NULL) {
				$StartDate = $r5a['Startdate2'];
			} elseif ($r5a['Startdate3']!=NULL && $r5a['Enddate3']==NULL) {
				$StartDate = $r5a['Startdate3'];
			}
			//Resignation date
			if ($r5a['Enddate3']!=NULL && $r5a['Startdate3']!=NULL){
				$EndDate = $r5a['Enddate3'];
			} elseif ($r5a['Startdate2']!=NULL && $r5a['Enddate2']==NULL) {
				$EndDate = $r5a['Enddate2'];
			} elseif ($r5a['Startdate1']!=NULL && $r5a['Enddate1']==NULL) {
				$EndDate = $r5a['Enddate1'];
			}
			
		//人員履歷
		$db5c = new DB;
		$db5c->query("SELECT * FROM `employer_resume` WHERE `EmpID`='".$v."'");
		if($db5c->num_rows() >0){
			$r5c = $db5c->fetch_assoc();
			//Education
			if ($r5c['QSchoolA_2']!=NULL){
				$Qschool = $r5c['QSchoolA_2']."(".$r5c['QSchoolC_2'].")";
			} elseif ($r5c['QSchoolA_1']!=NULL && $r5c['QSchoolA_2']==NULL) {
				$Qschool = $r5c['QSchoolA_1']."(".$r5c['QSchoolC_1'].")";
			} elseif ($r5c['QSchoolA_0']!=NULL && $r5c['QSchoolA_1']==NULL && $r5c['QSchoolA_1']==NULL) {
				$Qschool = $r5c['QSchoolA_0']."(".$r5c['QSchoolC_0'].")";
			}
		}else{
			$Qschool = "";
		}
		
		//Physical examination status
		$db5d = new DB;
		$db5d->query("SELECT * FROM `humanresource12` WHERE `EmpID`='".$v."' ORDER BY `date` DESC Limit 0,1");
		if($db5d->num_rows() >0){
			$r5d = $db5d->fetch_assoc();
			$phyexam = $r5d['lab'];
			$petrack = $r5d['followup'];
		}else{
			$phyexam = "";
			$petrack = "";
		}
        echo '
        <tr>';
		foreach ($arrUseTitle as $k1=>$v1) {
			echo '<td>';
			switch ($v1) {
				case 'Gender':					
					echo $r5a['Gender_1']=="1"?"Male":"Female";
					break;
				case 'Startdate':					
					echo $StartDate;
					break;
				case 'Qschool':					
					echo $Qschool;
					break;
				case 'Phone':					
					echo $r5a['Phone1'].($r5a['Phone2']!=""?"、".$r5a['Phone2']:"").($r5a['Phone3']!=""?"、".$r5a['Phone3']:"");
					break;
				case 'phyexam':					
					echo $phyexam;
					break;
				case 'petrack':					
					echo $petrack;
					break;
				default:
					echo $r5a[$v1];
				break;
			}
			echo '</td>';
		}
		if($_POST['report1']!=""){
			echo '<td>'.$EndDate.'</td>';
			for($i=0;$i<=3;$i++){
				$db5b = new DB;
				$db5b->query("SELECT * FROM `humanresource12` WHERE `EmpID`='".$r5a['EmpID']."' AND YEAR(`date`)='".$arrY[$i]."'");	
				if($db5b->num_rows()>0){
					$r5b = $db5b->fetch_assoc();
					echo '
					<td width="20">'.$r5b['cxr'].'</td>
					<td width="80">'.str_replace("\n","<br>",$r5b['lab']).'</td>
					<td width="80">'.str_replace("\n","<br>",$r5b['suggest']).'</td>
					<td width="80">'.str_replace("\n","<br>",$r5b['followup']).'</td>';	
				}else{
					echo '
					<td width="20">&nbsp;</td>
					<td width="80">&nbsp;</td>
					<td width="80">&nbsp;</td>
					<td width="80">&nbsp;</td>';
				}
			}
		}
        echo '</tr>
        ';
    }
    ?>
</table>
<?php }?>

</body>
</html>