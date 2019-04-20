<script>
$(function() {
    $( "#addmonthlyfeeform" ).dialog({
		autoOpen: false,
		height: 560,
		width: 600,
		modal: true,
		buttons: {
			"Add item": function() {
				$.ajax({
					url: "class/addmonthlyfee.php",
					type: "POST",
					data: {"date": $('#date').val(), "HospNo": $(this).data('HospNo'), "feeName": $('#feeName').val(), "fee": $('#fee').val(), "memo": $('#memo').val(), "minus": $('#minus').attr("checked") },
					success: function(data) {
						$( "#addmonthlyfeeform" ).dialog( "close" );
						location.reload();
					}
				});
			},
			"Cancel": function() {
				$( "#addmonthlyfeeform" ).dialog( "close" );
			}
		}
	});
});
function addmonthlyfee(HospNo) {
	$( "#addmonthlyfeeform" ).data('HospNo',HospNo).dialog( "open" );
}
</script>
<div id="addmonthlyfeeform" title="Add monthly fee item" class="dialog-form">
    <form>
    <fieldset>
      <table>
        <tr>
          <td class="title">Fee charged date</td>
          <td><script> $(function() { $( "#date" ).datepicker(); }); </script><input type="text" name="date" id="date" value="<?php if ($date==NULL) { echo date('Y/m/d'); } else { echo formatdate($date); } ?>" size="12" ></td>
        </tr>
        <tr>
          <td class="title">Item name</td>
          <td>
          <!--<input type="text" name="feeName" id="feeName" size="20" />-->
          <select name="feeName" id="feeName">
            <option></option>
            <option value="Oxygen usage fee">Oxygen usage fee</option>
            <option value="Rehabilitation fee">Rehabilitation fee</option>
            <option value="Transportation fee">Transportation fee</option>
            <option value="Guided diagnostic fee">Guided diagnostic fee</option>
            <option value="Examination fees">Examination fees</option>
            <option value="Refund hospital charges">Refund hospital charges</option>
          </select>
          </td>
        </tr>
        <tr>
          <td class="title">Amount</td>
          <td><input type="text" name="fee" id="fee" size="10" /></td>
        </tr>
        <tr>
          <td class="title">Description</td>
          <td><textarea name="memo" id="memo" cols="60" rows="10"></textarea></td>
        </tr>
        <tr>
          <td class="title">Deduction or not</td>
          <td><input type="checkbox" name="minus" id="minus" value="1" /></td>
        </tr>
      </table>
    </fieldset>
    </form>
</div>
<?php
$db = new DB;
$db->query("SELECT `patientID`,`HospNo`,`Birth` FROM `patient` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."'");
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	$db1 = new DB;
	$db1->query("SELECT `bed`,`indate` FROM `inpatientinfo` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."'");
	$r1 = $db1->fetch_assoc();
	$name = getPatientName($r['patientID']);
	$birth = formatdate($r['Birth']);
	$indate = formatdate($r1['indate']);
	$HospNo = $r['HospNo'];
	$bedID = $r1['bed'];
	$db2 = new DB;
	$db2->query("SELECT `Qdiag1`, `Qdiag2`, `Qdiag3`, `Qdiag4`, `Qdiag5`, `Qdiag6`, `Qdiag7`, `Qdiag8` FROM `nurseform01` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1");
	$r2 = $db2->fetch_assoc();
	for ($j=1;$j<=8;$j++) { if ($r2['Qdiag'.$j]!=NULL) { $diagMsg .= $r2['Qdiag'.$j].', '; } }
	$diagMsg = substr($diagMsg, 0, strlen($diagMsg)-2);
}
?>
<div style="width:95%; border:none; background-color:rgba(255,255,255,0.8); border-radius:10px; padding:15px 15px;">
<div class="content-query">
<table align="center" cellpadding="5" style="font-size:10pt; margin-left:0px; text-align:center;">
  <tr id="backtr"  style="border:none; height:32px;" >
    <?php if (@$_GET['id']!=NULL) { echo '<td align="center" bgcolor="#ffffff" width="40" id="backbtn"  style="border:none;" rowspan="3"><a href="index.php?mod=nurseform&func=formview&pid='.mysql_escape_string($_GET['pid']).'"><input type="button" value="Back"></a></td>'; } ?>
    <td class="title" width="80" style="border-top-left-radius:10px; background-color:#EECB35;">Bed #</td>
    <td width="80" style="border:none; padding-left: 10px;"><?php echo $bedID; ?></td>   
    <td class="title" width="70" style="border:none;">Name</td>
    <td width="90" style="border:none; padding-left: 10px;"><?php echo $name; ?></td>
    <td class="title" width="70" style="border:none;">Care ID#</td>
    <td width="90" style="border:none; padding-left: 10px;"><?php echo $HospNo; ?></td>
    <td class="title" width="70" style="border:none;">DOB</td>
    <td  style="border-top-right-radius:10px;"><?php echo $birth.' ('.checkgender(mysql_escape_string($_GET['pid'])).', '.calcage(str_replace('/','',$birth)).')'; ?></td>
  </tr>
  <tr style="border:none; height:20px;" >
    <td class="title" style="border-bottom-left-radius:10px;">Admission Date</td>
    <td style="border:none;"><?php echo $indate; ?></td>
    <td class="title">Diagnosis</td>
    <td style="border-bottom-right-radius:10px;" colspan="5"><?php echo $diagMsg; ?></td>
  </tr>
</table>
</div>
<div style="text-align:left;  border-radius:10px; margin-bottom:40px;">
  <h3 align="center">Set mothly charge</h3>
  <div>  
  <form><a href="index.php?mod=consump&func=formview&id=3"><input type="button" value="Back"></a><input type="button" value="Add monthly charge item" onclick="addmonthlyfee('<?php echo $HospNo; ?>')" />&nbsp;&nbsp;<a href="print.php?<?php echo $_SERVER['QUERY_STRING']; ?>" target="_blank"><img src="Images/print.png" border="0"></a></form>
  </div>
<div class="nurseform-table" style="width:100%;">
<table cellpadding="5" style="margin:0 auto; width:100%">
  <tr class="title">
    <td width="60"><center>Delete</center></td>
    <td width="120">Date</td>
    <td>Charged Item</td>
    <td>Charge Description</td>
    <td width="120">Amount</td>
  </tr>
<?php
$db = new DB;
$db->query("SELECT * FROM `monthlyfee` WHERE `HospNo`='".$HospNo."' ORDER BY `date` DESC, `feeID` ASC");
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	echo '
	<tr>
	  <td><center><form><input type="button" value="Delete" onclick="if (confirm(\'Confirm to delete this charge(fee)?\')) { window.location.href=\'index.php?func=deletemonthlyfee&pid='.@$_GET['pid'].'&feeID='.$r['feeID'].'&date='.$r['date'].'\' } else { alert(\'已經取消刪除！cancellation deleted\'); }" /></form></center></td>
	  <td><center>'.formatdate($r['date']).'</center></td>
	  <td><center>'.$r['feeName'].'</center></td>
	  <td><center><font size="2">'.$r['memo'].'</font></center></td>
	  <td><center>';
	if ($r['minus']==1) { echo '-'; }
	echo '$'.$r['fee'].'</center></td>
	</tr>
	'."\n";
}
?>
</table>
</div>
</div>
</div>
