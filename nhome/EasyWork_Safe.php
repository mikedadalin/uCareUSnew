<script type="text/javascript" src="js/LWJ_showQfillerName.js"></script>
<?php
if($_GET['SafeDate']!=""){
	$qdate_Safe = $_GET['SafeDate'];
}else{
	$qdate_Safe = date(Ym);
}
$Safe_db = new DB;
$Safe_db->query("SELECT `patientID`,`HospNo`,`Birth` FROM `patient` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."'");
for ($i=0;$i<$Safe_db->num_rows();$i++) {
	$Safe_r = $Safe_db->fetch_assoc();
	$Safe_db1 = new DB;
	$Safe_db1->query("SELECT `bed`,`indate` FROM `inpatientinfo` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."'");
	$Safe_r1 = $Safe_db1->fetch_assoc();
	$HospNo = $Safe_r['HospNo'];
	$name = getPatientName($Safe_r['patientID']);
	$bed = $Safe_r1['bed'];
	$birth = formatdate($Safe_r['Birth']);
	$indate = formatdate($Safe_r1['indate']);
}

$Safe_dbno = new DB;
$Safe_dbno->query("SELECT * FROM `careform14` WHERE `HospNo`='".$HospNo."'");
$URL_SafeDate = $qdate_Safe;
$URL_SafeDate_Year = substr($URL_SafeDate,0,4);
$URL_SafeDate_Month = substr($URL_SafeDate,4,2);
$Previous_Month = $URL_SafeDate_Month-1;
$Next_Month = $URL_SafeDate_Month+1;
if($Previous_Month==0){
	$Previous_Month = "12";
	$Previous_Month_Year = $URL_SafeDate_Year-1;
}else{
	$Previous_Month_Year = $URL_SafeDate_Year;
}
if (strlen((int)$Previous_Month)==1) {
	$Previous_Month = "0".$Previous_Month;
}
if($Next_Month==13){
	$Next_Month = "1";
	$Next_Month_Year = $URL_SafeDate_Year+1;
}else{
	$Next_Month_Year = $URL_SafeDate_Year;
}
if (strlen((int)$Next_Month)==1) {
	$Next_Month = "0".$Next_Month;
}
$URL_SafeDate_Previous = $URL_Safe."SafeDate=".$Previous_Month_Year.$Previous_Month;
$URL_SafeDate_Next = $URL_Safe."SafeDate=".$Next_Month_Year.$Next_Month;
?>
<div style="font-size:10pt; background-color: rgba(255,255,255,0.7); border-radius: 10px; padding: 0% 2%; margin-bottom:0px; min-width:960px;">
<div align="center" style="padding-top:15px; min-width:900px;"><h3 style="color:#69b3b6;"><a style="font-size:20px; color:rgb(238,203,53);" href="<?php echo $URL_SafeDate_Previous;?>"><i class="fa fa-chevron-circle-left"></i> Previous</a><font style="padding-left:50px; padding-right:50px;"><?php echo substr($qdate_Safe,0,4).' / '.substr($qdate_Safe,4,2); ?> Resident's Safety</font><a style="font-size:20px; color:rgb(238,203,53);" href="<?php echo $URL_SafeDate_Next;?>">Next <i class="fa fa-chevron-circle-right"></i></a></h3></div>
<div style="overflow-x:auto; text-align:center; margin-bottom:0px;">
<table width="100%">
  <tr height="20" style="background-color:rgba(255,255,255,0.8);">
    <td style="background-color:rgba(105,179,182,0.9); color:white;" width="60">Bed #</td>
    <td width="80"><?php echo $bed; ?></td>
    <td style="background-color:rgba(105,179,182,0.9); color:white;" width="60">Full name</td>
    <td width="80"><?php echo $name; ?></td>
    <td style="background-color:rgba(105,179,182,0.9); color:white;" width="60">Care ID#</td>
    <td width="80"><?php echo $HospNo; ?></td>
    <td style="background-color:rgba(105,179,182,0.9); color:white;" width="60">DOB</td>
    <td width="180"><?php echo $birth.' ('.checkgender(mysql_escape_string($_GET['pid'])).', '.calcage(str_replace('/','',$birth)).')'; ?></td>
    <td style="background-color:rgba(105,179,182,0.9); color:white;" width="80">Admission date</td>
    <td width="80"><?php echo $indate; ?></td>
  </tr>
</table>
<table style="text-align:center;">
  <tr style="background-color:rgba(105,179,182,0.9); color:white;" height="30">
    <td width="30">Time</td>
    <?php
	echo drawmedcalwithtext($qdate_Safe);
	?>
  </tr>
  <?php
  $array_time = array();
  for($ih=0;$ih<24;$ih++){
	  for($im=0;$im<2;$im++){
		  if($im==0){
			  $hm = $ih.":00";
		  }else{
			  $hm = $ih.":30";
		  }
		  array_push($array_time,$hm);
		  echo '<tr height="24" style="background-color:rgba(255,255,255,0.8);">';
		  echo '<td style="white-space:nowrap;">'.$hm.'</td>';
		  echo drawSafe($HospNo,$hm,$qdate_Safe);
		  echo '</tr>';
	  }
  }
  ?>
</table>
<br>
</div></div>
<script>
$(function() {
    $( "#newrecordformSafe" ).dialog({
        autoOpen: false,
        height: 250,
        width: 280,
        modal: true,
        buttons: {
            "Check": function() {
                $.ajax({
                    url: "class/careform14.php",
                    type: "POST",
                    data: {"HospNo": $("#HospNo").val(), "status": $("#safestatus").val(), "checktime": $("#checktime").val() },
                    success: function(data) {
                       $( "#newrecordformSafe" ).dialog( "close" );
                        alert("Check!");
                        window.location.reload();
                    }
                });
            },
            "Cancel": function() {
                $( "#newrecordformSafe" ).dialog( "close" );
            }
        }
    });
	$('button:button[id^="newCheckSafe_"]').click(function() {
		var w = $("#slider_content9").width();
		$("#slider_scroll9").animate( { right:'-'+w+'px' }, 600 ,'swing');
		openVerificationForm('#newrecordformSafe');
		var arrID = $(this).attr('id');
		arrID = arrID.split('_');
		document.getElementById('checktime').value = arrID[1];
	});
});
</script>
<div class="nurseform-table">
	<div id="newrecordformSafe" title="Check Safe" class="dialog-form">
		<fieldset>
		<table align="center">
			<tr>
				<td class="title">Time</td>
				<td><input type="text" name="checktime" id="checktime" readonly="readonly"></td>
			</tr>
			<tr>
				<td class="title">Safe</td>
				<td>
					<select name="safestatus" id="safestatus">
						<option value="0">Safe</option>
						<option value="1">!</option>
					</select>
					<input type="hidden" name="HospNo" id="HospNo" value="<? echo $HospNo;?>">
				</td>
			</tr>
		</table>
		</fieldset>
	</div>
</div>