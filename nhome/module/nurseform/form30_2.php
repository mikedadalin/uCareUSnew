<?php
if($_POST['edit'] = "success"){
//	print_r($_POST);
	$indate = $_POST['indate'];
	if ($indate=="____/__/__") { $indate = ""; }
	$db2 = new DB;
	$db2->query("UPDATE `general_io` SET `indate`='".$indate."', `reason_1`='".mysql_escape_string($_POST['reason_1'])."', `reason_2`='".mysql_escape_string($_POST['reason_2'])."', `reason_3`='".mysql_escape_string($_POST['reason_3'])."', `reason_4`='".mysql_escape_string($_POST['reason_4'])."', `reasonOther`='".mysql_escape_string($_POST['reasonOther'])."', `outdays`='".mysql_escape_string($_POST['outdays'])."', `rmk`='".mysql_escape_string($_POST['rmk'])."' WHERE general_IOID='".mysql_escape_string($_POST['ioID'])."'");
}
$targetID = mysql_escape_string($_GET['tID']);

$db1 = new DB;
$db1->query("SELECT * FROM `general_io` WHERE `general_IOID`='".$targetID."'");
$r1 = $db1->fetch_assoc();

foreach ($r1 as $k=>$v) {
	$arrPatientInfo = explode("_",$k);
	if (count($arrPatientInfo)>1) {
		$varname = "";
		for ($i=0;$i<(count($arrPatientInfo)-1);$i++) {
			if ($v==1) {
				if ($varname!="") { $varname .= '_'; }
				$varname .= $arrPatientInfo[$i];
			}
		}
		//echo $varname.'<br>';
		${$varname} .= $arrPatientInfo[(count($arrPatientInfo)-1)].';';
	} else {
		${$k} = $v;
	}
}
?>
<form  method="post" id="form1">
<h3>Resident's status input</h3>
<div align="right" id="printbtn"><a href="print.php?<?php echo $_SERVER['QUERY_STRING']; ?>" target="_blank"><img src="Images/print.png" border="0"></a></div>
    <table>
      <tr>
        <td class="title">Full name</td>
        <td><?php echo $name; ?></td>
        <td class="title">Care ID#</td>
        <td><?php echo getHospNoDisplayByHospNo($HospNo); ?></td>
      </tr>
      <tr>
        <td class="title">Bed #</td>
        <td><?php echo $bedID; ?></td>
        <td class="title">Off date</td>
        <td><?php echo $outdate; ?><input type="hidden" name="outdate" id="outdate" value="<?php echo $outdate; ?>"></td>
      </tr>
      <tr>
        <td class="title">Return date</td>
        <td><script> $(function() { $( "#indate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="indate" id="indate" value="<?php echo $indate; ?>"></td>
        <td class="title">Day(s)</td>
        <td><input type="text" name="outdays" id="outdays" size="3" value="<?php echo $outdays; ?>">Day(s) <input type="button" onclick="calcoutdays()" value="Calculate day(s)" /></td>
      </tr>
      <tr>
        <td class="title">Reason of temporary leaving</td>
        <td colspan="3"><?php echo draw_option("reason","Visit home;Go abroad;Private schedule;Hospitalize","l","single",$reason,false,2); ?><input type="text" id="reasonOther" name="reasonOther" value="<?php echo $r1['reasonOther']; ?>" ></td>
      </tr>
      <tr>
        <td class="title">Comment</td>
        <td colspan="3"><input type="text" name="rmk" id="rmk" value="<?php echo $r1['rmk']; ?>"></td>
      </tr>
      <tr>
        <td class="title">Filled by</td>
        <td colspan="3"><?php echo checkusername($_SESSION['ncareID_lwj']); ?></td>
      </tr>
      <tr>
        <td colspan="4" align="center">
        <input type="button" value="Back to list" onclick="window.location.href='index.php?mod=nurseform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=30_1'"> 
        <input type="button" name="modify" id="modify" value="Modify">
        </td>
      </tr>
    </table>
<input type="hidden" id="edit" name="edit" value="success">
<input type="hidden" id="ioID" name="ioID" value="<?php echo $targetID; ?>">
</form>
<script>
function calcoutdays() {
	if (document.getElementById('indate').value!="____/__/__") {
		var sTime = new Date(document.getElementById('outdate').value);
		var eTime = new Date(document.getElementById('indate').value);
		var indays = parseInt((eTime.getTime() - sTime.getTime()) / parseInt(1000 * 3600 * 24));
		document.getElementById('outdays').value = indays;
	}
}
$(function() {
	$("#modify").click(function(){
		if($('#indate').val()==''){
			alert('Input return date!!');
			$('#indate').focus();
			return false;
		}else if($('#indate').val() < $('#outdate').val()){
			alert("Return date should be later than discharge date!!");
			$('#indate').focus();
			return false;
		}else if($('#outdate').val()!='____/__/__'){
			//alert('請點選計算天數!!');
			//$('#indate').focus();
			calcoutdays();
			$("#form1").submit();
		}else{			
			$("#form1").submit();
		}
	})
});
</script>