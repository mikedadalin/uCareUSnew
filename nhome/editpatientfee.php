<script>
$(function() {
    $( "#addstaticfeeform" ).dialog({
		autoOpen: false,
		height: 320,
		width: 440,
		modal: true,
		buttons: {
			"增加項目": function() {
				$.ajax({
					url: "class/addstaticfee.php",
					type: "POST",
					data: {"HospNo": $(this).data('HospNo'), "feeName": $('#feeName').val(), "fee": $('#fee').val(), "minus": $('#minus').attr("checked") },
					success: function(data) {
						$( "#addstaticfeeform" ).dialog( "close" );
						location.reload();
					}
				});
			},
			"Cancel": function() {
				$( "#addstaticfeeform" ).dialog( "close" );
			}
		}
	});
});
function addstaticfee(HospNo) {
	$( "#addstaticfeeform" ).data('HospNo',HospNo).dialog( "open" );
}
</script>
<div id="addstaticfeeform" title="增加固定費用項目"> 
  <form>
  <fieldset>
    <table>
      <tr>
        <td width="140">項目名稱item name</td>
        <td>
        <!--<input type="text" name="feeName" id="feeName" size="20" />-->
        <select name="feeName" id="feeName">
          <option></option>
          <option value="床位租金bed rent">床位租金bed rent</option>
          <option value="床租金電費bed rent electricity fee ">床租金電費rent electricity fee </option>
          <option value="尿布diaper">尿布diaper</option>
          <option value="奶粉milk powder">奶粉milk powder</option>
        </select>
        </td>
      </tr>
      <tr>
        <td>Amount</td>
        <td><input type="text" name="fee" id="fee" size="10" /></td>
      </tr>
      <tr>
        <td>是否為扣除項目 Deduction or not</td>
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
<div class="formNoSelDate">


<div class="content-query" style="margin:0 10px;">
<table align="center" cellpadding="5" style="font-size:10pt; margin: 0px auto;">
  <tr id="backtr"  style="border:none; height:28px;" >
    <?php if (@$_GET['id']!=NULL) { echo '<td class="backbtnn" align="center" width="40" id="backbtn"  style="border:none;" rowspan="2"><a href="index.php?mod=nurseform&func=formview&pid='.mysql_escape_string($_GET['pid']).'"><img src="Images/back_button.png"></a></td>'; } ?>
    <td class="title" style="border-top-left-radius:10px; background-color:#EECB35;">Bed #</td>
    <td style="border:none;"><?php echo $bedID; ?></td>   
    <td class="title" style="border:none;">Full Name</td>
    <td style="border:none;"><?php echo $name; ?></td>
    <td class="title" style="border:none;">Care ID#</td>
    <td style="border:none;"><?php echo $HospNo; ?></td>
    <td class="title" style="border:none;">DOB</td>
    <td style="border:none; border-top-right-radius:10px;"><?php echo $birth.' ('.checkgender(mysql_escape_string($_GET['pid'])).', '.calcage(str_replace('/','',$birth)).')'; ?></td>
  </tr>
  <tr style="border:none; height:20px;" >
    <td class="title" style="border:none; border-bottom-left-radius:10px;">Admission Date</td>
    <td style="border:none;"><?php echo $indate; ?></td>
    <td class="title" style="border:none;">Diagnosis</td>
    <td style="border:none; border-bottom-right-radius:10px;" colspan="5"><?php echo $diagMsg; ?></td>
  </tr>
</table>
</div>
<table border="0" style="width:100%;">
  <tr>
    <td style="border:none;" colspan="2">
  <br>
 <table border="0" style="width:100%;">
  <tr>
	<td colspan="2" align="center" style="border:none;"><h3 style="width:100%;">固定費用設定 Fixed Charge Setting</h3></td>
	</tr>
  <tr id="backtr">
    <td class="backbtnn" align="center" id="backbtn"  style="border:none;" rowspan="3"><a href="index.php?mod=consump&func=formview&id=3">Go Back</a></td>
    <td id="printbtn" align="right">
      <form><input type="button" value="增加固定費用項目 adding fixed fee item" onclick="addstaticfee('<?php echo $HospNo; ?>')" />&nbsp;&nbsp;<a href="print.php?<?php echo $_SERVER['QUERY_STRING']; ?>" target="_blank"><img src="Images/print.png" border="0"></a></form>
    </td>
  </tr>
 </table>
<div class="nurseform-table">
<table style="width:100%;">
  <tr class="title">
    <td><center>Delete</center></td>
    <td>費用項目 Charge Item</td>
    <td>Amount of Fee Amount</td>
  </tr>
<?php
$db = new DB;
$db->query("SELECT * FROM `staticfee` WHERE `HospNo`='".$HospNo."' ORDER BY `feeID` ASC");
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	echo '
	<tr>
	  <td><center><form><input type="button" value="Delete" onclick="if (confirm(\'確認刪除此筆費用？confirm delete this charge?\')) { window.location.href=\'index.php?func=deletepatientfee&pid='.@$_GET['pid'].'&feeID='.$r['feeID'].'\' } else { alert(\'已經取消刪除！cancellation delete\'); }" /></form></center></td>
	  <td>'.$r['feeName'].'</td>
	  <td>';
	if ($r['minus']==1) { echo '-'; }
	echo '$'.$r['fee'].'</td>
	</tr>
	'."\n";
}
?>
</table>
</div>
</td>
  </tr>
</table>

</div>