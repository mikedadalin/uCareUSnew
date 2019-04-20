<script>
$(function() {
    $( "#dialog-form" ).dialog({
		autoOpen: false,
		height:510,
		width: 640,
		modal: true,
		buttons: {
			"Input": function() {
				$.ajax({
					url: "class/inputoutput_resptimes.php",
					type: "POST",
					data: {"bedID": $("#resper").val(), "date": $("#measuredate").val(),"measuretime": $("#measuretime").val(), "input": $("#input").val(), "output": $("#output").val(), "output1": $("#output1").val(), "output2": $("#output2").val(), "output3": $("#output3").val(), "IOstatus":$('#IOstatus').val(), "Qfiller":'<?php echo $_SESSION['ncareID_lwj']; ?>' },
					success: function(data) {
						alert("Successfully saved!");
						$( "#dialog-form" ).dialog( "close" );
						window.location.reload();
					}
				});
			},
			"Cancel": function() {
				$( "#dialog-form" ).dialog( "close" );
			}
		}
	});
});
function dialogform_set(id){
	var respid = id;
	respid = respid.split(/_/);
	$("#pinfo").text(respid[1]+"Bed");
	document.getElementById('resper').value = respid[1];
	openVerificationForm('#dialog-form');
}
</script>
<div style="background-color: rgba(255,255,255,0.8); border-radius: 10px; padding:10px; margin-bottom: 10px;">
<div class="content-query">
<table>
  <tr class="title">
    <td colspan="2">Filter condition</td>
  </tr>
  <tr>
    <td width="120" class="title"><center><b>Area search</b></center></td>
    <td align="left" style="padding-left:5px;">
      <form action="index.php?mod=inputoutput&func=resplist&query=1" method="post">
      Area&nbsp;<select name="area">
      <?php
	  $qArea = new DB;
	  $qArea->query("SELECT * FROM `areainfo` ORDER BY `areaID` ASC");
	  for ($i=0;$i<$qArea->num_rows();$i++) {
		  $rArea = $qArea->fetch_assoc();
		  echo '<option value="'.$rArea['areaID'].'">'.$rArea['areaName'].'</option>'."\n";
	  }
	  ?>
      </select>&nbsp;
      <input type="submit" value="Search" /></form>
    </td>
  </tr>
  <tr>
    <td width="120" class="title"><center><b>Resident search</b></center></td>
    <td align="left" style="padding-left:5px;"><form action="index.php?mod=inputoutput&func=resplist&query=2" method="post">Social Security number&nbsp;<input name="IdNo" value="<?php echo $_POST['IdNo']; ?>" />&nbsp;or Care ID#&nbsp;<input name="HospNo" value="<?php echo $_POST['HospNo']; ?>" />&nbsp;<input type=submit value="Resident search" /><input type=button value="ID card search" /></form></td>
  </tr>
</table>
</div>
</div>
<div style="background-color: rgba(255,255,255,0.8); border-radius: 10px; padding:10px 10px 30px 10px; margin-bottom: 20px;">
<div class="content-table">
<form>
<table>
<tr class="title">
  <td>Area</td>
  <td>Bed</td>
  <td>Full name</td>
  <td>Care ID#</td>
  <td>Gender</td>  
  <td>Age</td>
  <td>I/O</td>
</tr>
<?php
if (@$_GET['query']==2) {
	//身份證查詢
	if ($_POST['IdNo']!=NULL) {
		$sql1 = "SELECT `patientID` FROM `patient` WHERE `IdNo` LIKE '%".mysql_escape_string($_POST['IdNo'])."%' ORDER BY `patientID` DESC";
	} elseif ($_POST['HospNo']!=NULL) {
		$sql1 = "SELECT `patientID` FROM `patient` WHERE `HospNo` LIKE '%".mysql_escape_string($_POST['HospNo'])."%' ORDER BY `patientID` DESC";
	} else {
		$sql1 = "SELECT `patientID` FROM `inpatientinfo` ORDER BY `bed` ASC";
	}
} elseif (@$_GET['query']==1) {
	//查詢區域
	$arrAreaBed = array();
	$db2 = new DB;
	$db2->query("SELECT `bedID` FROM `bedinfo` WHERE `Area`='".mysql_escape_string($_POST['area'])."'");
	for ($k=0;$k<$db2->num_rows();$k++) {
		$r2 = $db2->fetch_assoc();
		$arrAreaBed[$k] = $r2['bedID'];
	}
	$sql1 = "SELECT `patientID` FROM `inpatientinfo` ORDER BY `bed` ASC";
} else {
	$sql1 = "SELECT `patientID` FROM `inpatientinfo` ORDER BY `bed` ASC";
}
$db = new DB;
$db->query($sql1);
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	$db1 = new DB;
	$db1->query("SELECT `bed` FROM `inpatientinfo` WHERE `patientID`='".$r['patientID']."' ORDER BY `patientID` DESC LIMIT 0,1");
	for ($j=0;$j<$db1->num_rows();$j++) {
		$r1 = $db1->fetch_assoc();
		if (@$_GET['query']==1) {
			if (count($arrAreaBed)==0) {
			if (@$_GET['query']!=NULL) {
				echo '<script>alert("此區域尚未有住民入住");</script>'."\n";
				break 2;
			}
			}
		}
		$db2a = new DB;
		$db2a->query("SELECT `Area` FROM `bedinfo` WHERE `bedID`='".$r1['bed']."'");
		$r2a = $db2a->fetch_assoc();
		$db2b = new DB;
		$db2b->query("SELECT `areaName` FROM `areainfo` WHERE `areaID`='".$r2a['Area']."'");
		$r2b = $db2b->fetch_assoc();
		$db2c = new DB;
		$db2c->query("SELECT `HospNo`,`Birth`,`instat` FROM `patient` WHERE `patientID`='".$r['patientID']."'");
		$r2c = $db2c->fetch_assoc();
		if (count($arrAreaBed)==0 || in_array($r1['bed'],$arrAreaBed)) {
			echo '
<tr'.($_SESSION['ncareOrgStatus_lwj']==2 && $r2c['instat']==0?' style="display:none;"':"").'>
  <td width="13%" align="center">'.$r2b['areaName'].'</td>
  <td width="13%" align="center">'.$r1['bed'].'</td>
  <td width="13%" style="padding-left:5px;">'.getPatientName($r['patientID']).'</td>
  <td width="13%" align="center">'.$r2c['HospNo'].'</td>
  <td width="6%" align="center">'.checkgender($r['patientID']).'</td>  
  <td width="13%" align="center">'.calcage($r2c['Birth']).'</td>
  <td width="6%" align="center"><center><input type="button" id="newrecord_'.$r1['bed'].'" value="Input" onclick="dialogform_set(this.id);" /></center></td>
</tr>
		'."\n";
		}
	}
}
?>
</table>
</form>
</div>
</div>
<div id="dialog-form" title="I/O intake and output" class="dialog-form"> 
  <form>
  <fieldset><legend><span id="pinfo"></span></legend>
    <table>
      <tr>
        <td class="title">Measure date/time</td>
        <td><script> $(function() { $( "#measuredate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="measuredate" id="measuredate" value="<?php echo date('Y-m-d'); ?>" size="12" > <input type="text" name="measuretime" id="measuretime" value="<?php echo date(Hi); ?>" size="4" > <font size="2">(Format:HHmm)</font></td>
		<input type="hidden" id="resper" name="resper">
      </tr>
      <tr>
        <td class="title">Total daily intake<br />I (Intake)</td>
        <td><input type="text" name="input" id="input" size="4"></td>
      </tr>
      <tr>
        <td class="title">Total daily output<br />O (Output)</td>
        <td><input type="text" name="output" id="output" size="4"></td>
      </tr>
      <tr>
        <td class="title">1. Stool<br />(STOOL)</td>
        <td><input type="text" name="output1" id="output1" size="4"></td>
      </tr>
      <tr>
        <td class="title">2. Number of other drainage tube<br />(Drain)</td>
        <td><input type="text" name="output2" id="output2" size="4"></td>
      </tr>
      <tr>
        <td class="title">3. Other<br />(Other)</td>
        <td><input type="text" name="output3" id="output3" size="4"></td>
      </tr>
      <tr>
        <td class="title">I-O=Daily<br />Positive and negative status</td>
        <td><input type="text" name="IOstatus" id="IOstatus" size="4"></td>
      </tr>
    </table>
  </fieldset>
  </form>
</div>
<p>&nbsp;</p>