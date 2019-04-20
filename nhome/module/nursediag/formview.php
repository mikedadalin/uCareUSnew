<?php
$url = explode("/",$_SERVER['PHP_SELF']);
$db = new DB;
$db->query("SELECT `patientID`,`HospNo`,`Birth` FROM `patient` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."'");
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	$db1 = new DB;
	$db1->query("SELECT `bed`,`indate` FROM `inpatientinfo` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."'");
	$r1 = $db1->fetch_assoc();
	$name = getPatientName($r['patientID']);
	$bedID = $r1['bed'];
	$HospNo = $r['HospNo'];
	$birth = formatdate($r['Birth']);
	$indate = formatdate($r1['indate']);
	$db2 = new DB;
	$db2->query("SELECT `Qdiag1`, `Qdiag2`, `Qdiag3`, `Qdiag4`, `Qdiag5`, `Qdiag6`, `Qdiag7`, `Qdiag8` FROM `nurseform01` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1");
	$r2 = $db2->fetch_assoc();
	for ($j=1;$j<=8;$j++) { if ($r2['Qdiag'.$j]!=NULL) { $diagMsg .= $r2['Qdiag'.$j].', '; } }
	$diagMsg = substr($diagMsg, 0, strlen($diagMsg)-2);
}
?>

<div ondblclick="closeResidentCol();">
<div class="content-query">
<table align="center" style="width:100%; font-size:10pt; margin: 0px 0px;">
  <tr id="backtr" style="border:none; height:28px;">
    <?php if (@$_GET['id']!=NULL) { echo '<td class="backbtnn" align="center" width="40" id="backbtn"  style="border:none;" rowspan="3"><a href="index.php?mod=nurseform&func=formview&pid='.mysql_escape_string($_GET['pid']).'">'.$word_Back.'</a></td>'; } ?>
	<td class="title" width="80" style="border-top-left-radius:10px; background-color:#EECB35;"><?php echo $word_Bed; ?></td>
    <td width="80" style="border:none; padding-left: 10px;"><?php echo $bedID; ?></td>   
    <td class="title" width="60" style="border:none;"><?php echo $word_Name; ?></td>
    <td width="160" style="border:none; padding-left: 10px;"><?php echo $name; ?></td>
    <td class="title" width="70" style="border:none;"><?php echo $word_CareID; ?></td>
    <td width="90" style="border:none; padding-left: 10px;"><?php echo getHospNoDisplayByHospNo($HospNo); ?></td>
    <td width="100" class="title" style="border:none;"><?php echo $word_AdmissionDate; ?></td>
    <td width="80" style="border:none; padding-left: 10px;"><?php echo $indate; ?></td>    
    <td class="title" width="70" style="border:none;"><?php echo $word_DOB; ?></td>
    <td width="170" style="border-top-right-radius:10px; padding-left: 10px;"><?php echo $birth.' ('.checkgender(mysql_escape_string($_GET['pid'])).', '.calcage(str_replace('/','',$birth)).')'; ?></td>
  </tr>
  <tr style="border:none; height:28px;">  <!-- ¶EÂ_ + Jump to + ®É¶¡ + Print -->
    <?php
		echo '<td class="title" style="background-color:#b79810; border-bottom-left-radius:10px;">'.$word_Diagnosis.'</td>';
		if(substr($url[3],0,5)!="print"){
			if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){
				echo '
				<td style="=padding-left: 10px;" colspan="7">'.$diagMsg.'</td>
				<td style="border-bottom-right-radius:10px; padding-left: 5px;" colspan="2">';
				?><input class="residentListButton" type="button" onclick="$('#ResidentCol').show('slide', {direction: 'left'}, 500);" value="Resident List"><?php
				echo '<a href="print.php?'.$_SERVER['QUERY_STRING'].'" target="_blank" style="margin-left:5px;"><input type="button"  value="Print" style="background:rgb(149,219,208); color:white; font-size:15.35px; display:inline-block; padding:3px; border-radius:8px; border:1px; outline: none; width:60px;"></a>';
				$db5 = new DB;
				$db5->query("SELECT `round` FROM `nurserounds` WHERE `HospNo`='".$HospNo."' AND `date`='".date(Ymd)."' AND `Qfiller`='".$_SESSION['ncareID_lwj']."' AND `Qfiller`='".$_SESSION['ncareID_lwj']."' AND `Qfiller`='".$_SESSION['ncareID_lwj']."'");
				if($db5->num_rows()>0){
					echo '&nbsp;<button id="CheckRound_OFF_'.$_GET['pid'].'"><i id="CheckRound_OFF_'.$_GET['pid'].'_icon" class="fa fa-check-square-o"></i></button>';
				}else{
					echo '&nbsp;<button id="CheckRound_ON_'.$_GET['pid'].'"><i id="CheckRound_ON_'.$_GET['pid'].'_icon" class="fa fa-square-o"></i></button>';
				}
				echo '</td>';
	    	}else{
				echo'
				<td style="padding-left: 10px;" colspan="8">'.$diagMsg.'</td>
				<td style="border-bottom-right-radius:10px; padding-left: 5px;">';
				echo '<a href="print.php?'.$_SERVER['QUERY_STRING'].'" target="_blank" style="margin-left:5px;"><input type="button"  value="Print" style="background:rgb(149,219,208); color:white; font-size:15.35px; display:inline-block; padding:3px; border-radius:8px; border:1px; outline: none; width:60px;"></a>';
				echo '</td>';
        	}
		}else{
			echo'<td style="border-bottom-right-radius:10px; padding-left: 10px;" colspan="9">'.$diagMsg.'</td>';
		}
	?>
  </tr>
</table>
</div>
<div onclick="closeResidentCol();">
<table border="0" style="text-align:left;">
  <tr>
    <td>
    <?php
	if (@$_GET['id']!=NULL) {
		echo '<div class="nurseform-table">';
		include(@$_GET['id'].".php");
		echo '</div>';
	} else {
		include("formlist.php");
	}
	?>
    </td>
  </tr>
</table>
</div>
</div>
<?php
if (substr($url[3],0,5)!="print") {
	echo '<div id="ResidentCol" align="left">';
	echo '<div align="center" style="background-color:#eecb35; border-radius:10px; padding:7px; margin-bottom:20px;"><font style="color:white; font-size:26px; font-weight:bold;">Resident List</font></div>';
	include("ResidentCol.php");
	echo '</div>';
	echo '<script type="text/javascript" src="js/closeResidentCol.js"></script>';
}
?>
<script type="text/javascript" src="js/LWJ_CheckRound.js"></script>
<script>
	var lastScrollTop = 0;
	$('#content2').scroll(function(event){
		var st = $(this).scrollTop();
        if(Math.abs(lastScrollTop - st) <= 5)
        return;
    if (st > lastScrollTop && st > 90){
        $(function(){
        	$('.header').removeClass('nav-down').addClass('nav-goup')
        	$('#content2').removeClass('content2Nav').addClass('content2Nav');
        	$('.content-query2').addClass('content-query2Nav');
        });
    } else if(lastScrollTop>st && (lastScrollTop-st>20) || st<=90){
        $(function(){
        	$('.header').removeClass('nav-goup').addClass('nav-down')
        	$('#content2').removeClass('content2Nav').addClass('content2N');
        	$('.content-query2').removeClass('content-query2Nav');
        });
    }
        lastScrollTop = st;
	});
</script>