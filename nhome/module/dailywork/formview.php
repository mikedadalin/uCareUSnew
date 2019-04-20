<?php
if (@$_GET['pid']==NULL) {
	if (@$_GET['id']==NULL) {
		if(substr($_SESSION['ncareID_lwj'],0,8)=="resident"){
			$HospNo = substr($_SESSION['ncareID_lwj'],8,6);
			$db = new DB;
			$db->query("SELECT `patientID` FROM `patient` WHERE `HospNo`='".mysql_escape_string($HospNo)."'");
			$r = $db->fetch_assoc();
			$url = "index.php?mod=dailywork&func=formview&pid=".$r['patientID'];
			echo "<script type='text/javascript'>";
			echo "window.location.href='".$url."'";
			echo "</script>";
		}else{
			include('allpatient.php');
		}
	} else {
		echo '
		<table border="0" style="text-align:left; width:100%;">
		<tr>
		<td style="border:none;" colspan="3">
		<div class="nurseform-table">';
		include("form".@$_GET['id'].".php");
		echo '
		</div>
		</td>
		</tr>
		</table>';
	}
} elseif (@$_GET['id']==4) {
	echo '
	<table border="0" style="text-align:left;">
	<tr>
	<td style="border:none;" colspan="3">
	<div class="nurseform-table">';
	include("form".@$_GET['id'].".php");
	echo '
	</div>
	</td>
	</tr>
	</table>';
} else {
	echo '<div id="vitalpatient">';
	include('patient.php');
	echo '</div>';
}
?>
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