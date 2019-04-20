<div class="moduleNoTab">
<div class="nurseform-table">
<?php
if (@$_GET['nID']!=NULL) {
	$db1 = new DB;
	$sql1 = "SELECT * FROM `nurseform24` WHERE `nID`='".mysql_escape_string($_GET['nID'])."'";
	$db1->query($sql1);
	$r1 = $db1->fetch_assoc();
	if ($db1->num_rows()>0) {
		foreach ($r1 as $k=>$v) {
			if (substr($k,0,1)=="Q") {
				$arrAnswer = explode("_",$k);
				if (count($arrAnswer)==2) {
					if ($v==1) {
						${$arrAnswer[0]} .= $arrAnswer[1].';';
					}
				} else {
					${$k} = $v;
				}
			}  else {
				${$k} = $v;
			}
		}
	}
}
$pid = getPID($HospNo);
?>
<script>
function loadPatInfo(tab){
	if ($("#HospNo").val()!="") { var HospNo= $("#HospNo").val(); }
	if ($("#Name").val()!="") { var Name= $("#Name").val(); }
	if ($("#BedID").val()!="") { var BedID= $("#BedID").val(); }
	
	$.ajax({
		url: 'class/patinfo2.php',
		type: "POST",
		async: false,
		data: { med: HospNo, Namevar: Name, BedIDvar: BedID }
	}).done(function(meds){
		if (meds=="NORECORD") {
			alert("無符合條件之住民");
		} else {
			medList2 = meds.split('|');
			document.getElementById('HospNo').value = medList2[6];
			document.getElementById('Name').value = medList2[0];
			document.getElementById('BedID').value = medList2[7];
			document.getElementById("search").style.display = "none";
			document.getElementById("clear").style.display = "inline-block";
		}
	});
}
function cleartab(tab) {
	$("#nurseform24")[0].reset();
	$('#search').show();
	$('#clear').hide();
	$('#HospNo').attr("readonly",false);
	$('#Name').attr("readonly",true);
	$('#BedID').attr("readonly",false);
}
</script>
<form  method="post" id="nurseform24" onSubmit="return checkForm();" action="index.php?func=databaseAI">
<table style="margin-top:20px;">
      <tr height="30">
        <td class="title" colspan="4">Add new handover record</td>
      </tr>
      <tr height="30">
        <td class="title" width="120">Handover date</td>
        <td><input type="text" name="date" id="date" value="<?php if ($date != NULL) { echo formatdate($date); } else { echo date('Y/m/d'); } ?>" size="12"></td>
        <td class="title" width="120">Shift</td>
        <td colspan="3">
        <select id="Q1" name="Q1" class="validate[required]" >
        	<option value="">--Please select--</option>
            <option value="0" <?php echo ($Q1==0?"selected":"");?>>Day shift</option>
            <option value="1" <?php echo ($Q1==1?"selected":"");?>>Night shift</option>
			<option value="2" <?php echo ($Q1==2?"selected":"");?>>Graveyard shift</option>            
        </select>
        </td>
      </tr>
	  <tr>
		<td class="title" width="120">Resident</td>
        <td colspan="5">
          <span style="padding:3px; border:1px solid #999; color:#666; font-size:10pt;">Care ID#</span> <input type="text" name="HospNo" id="HospNo" value="<?php if($_GET['action']=="edit"){ echo $HospNo;} ?>" size="8">&nbsp;
          <span style="padding:3px; border:1px solid #999; background:#999; color:#fff; font-size:10pt;">or</span>&nbsp;
          <span style="padding:3px; border:1px solid #999; color:#666; font-size:10pt;">Bed #</span> <input type="text" name="BedID" id="BedID" size="8" value="<?php if($_GET['action']=="edit"){ echo getBedID($pid);} ?>">&nbsp;
          <span style="padding:3px; border:1px solid #999; color:#666; font-size:10pt;">Full name</span> <input type="text" name="Name" id="Name" size="8" readonly="readonly" value="<?php if($_GET['action']=="edit"){ echo getPatientName($pid);} ?>">&nbsp;
	      <input type="button" value="Search" id="search" onclick="loadPatInfo()" />
          <input type="button" value="清空" id="clear" onclick="cleartab()" style="display:none;" />
		</td>
	  </tr>
      <tr height="30">
        <td class="title">Handover content</td>
        <td colspan="3"><textarea cols="3" rows="10" id="Q2" name="Q2" class="validate[required]" ><?php echo $Q2; ?></textarea></td>
      </tr>
</table>
<table>
  <tr>
    <td align="right" colspan="2">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>
<center>
<div style="margin-top:30px">
<input type="hidden" name="formID" id="formID" value="nurseform24" />
<input type="hidden" name="nID" id="nID" value="<?php echo $_GET['nID']; ?>" />
<input type="hidden" name="action" id="action" value="<?php echo $_GET['action']; ?>" />
<button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
</div>
</center>
</form>
</div>
</div>
<script> 
$(function() { 
	$("#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); 
	$("#nurseform24").validationEngine();
}); 
</script>