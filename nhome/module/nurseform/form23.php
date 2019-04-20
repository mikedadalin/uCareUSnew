<script>
function loadPatInfo(tab){
	var HospNo= $("#HospNo_"+tab).val();
	$.ajax({
		url: 'class/patinfo.php',
		type: "POST",
		async: false,
		data: { med: HospNo }
	}).done(function(meds){
		medList2 = meds.split(',');
		document.getElementById('Name_'+tab).value = medList2[0]+medList2[1]+medList2[2]+medList2[3];
		if (tab=="tab1") { if (medList2[4]!="0") { document.getElementById('indate').value = medList2[4].substr(0,4) + '/' + medList2[4].substr(4,2) + '/' + medList2[4].substr(6,2); } else { document.getElementById('indate').value =''; } }
		if (tab=="tab3") {
			document.getElementById('Gender_tab3').value = medList2[5];
			document.getElementById('Age_tab3').value = medList2[6];
			document.getElementById('Diag_tab3').value = medList2[7];
			document.getElementById('ADLtotal_tab3').value = medList2[8];
		}
	});
	return medList;
}
</script>
<h3>Training record for removing nasogastric tube</h3>
<table width="100%" bgcolor="#ffffff">
  <tr>
    <td valign="top" bgcolor="#ffffff">
	<?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?>
    <form><input type="button" value="Add record" id="newrecord2" onclick="openVerificationForm('#dialog-form2');" /></form>
	<?php }?>
<script>
$(function() {
    $( "#dialog-form2" ).dialog({
		autoOpen: false,
		height: 400,
		width: 860,
		modal: true,
		buttons: {
			"Add record": function() {
				$.ajax({
					url: "class/sixtarget_part7.php",
					type: "POST",
					data: {'HospNo': $('#HospNo_tab2').val(), 'Name': $('#Name_tab2').val(),
					'startdate': $('#part7_startdate').val(), 
					//'time': $('#timeH').val() + ':' + $('#timeI').val() + ':00', 
					'reason_1': $('#part7_reason_1').val(), 
					'reason_2': $('#part7_reason_2').val(), 
					'reason_3': $('#part7_reason_3').val(), 
					'reason_4': $('#part7_reason_4').val(), 
					'reasonother': $('#part7_reasonother').val(), 
					'Qfiller': $('#Qfiller').val() },
					success: function(data) {
						$( "#dialog-form2" ).dialog( "close" );
						alert("Add record sucessfully!");
						window.location.reload();
					}
				});
			},
			"Cancel": function() {
				$( "#dialog-form2" ).dialog( "close" );
			}
		}
	});
});
</script>
<div id="dialog-form2" title="Training record for removing nasogastric tube" class="dialog-form"> 
  <form>
  <fieldset>
    <table>
      <tr>
        <td class="title">Care ID#</td>
        <td><input type="text" name="HospNo" id="HospNo_tab2" size="8"> Full name <input type="text" name="Name" id="Name_tab2" readonly  size="16"></td>
      </tr>
      <tr>
      <td class="title">Date</td>
      <td><script> $(function() { $( "#part7_startdate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="part7_startdate" id="part7_startdate" value="<?php echo date(Y."/".m."/".d); ?>">&nbsp;
      <!--Time&nbsp;<select name="timeH" id="timeH">
          <option></option>
          <?php
		  for ($i2a=0;$i2a<=23;$i2a++) { echo '<option value="'.$i2a.'" '.(date(H)==$i2a?" selected":"").'>'.(strlen($i2a)==1?'0':'').$i2a.'</option>'; }
		  ?>
        </select>：<select name="timeI" id="timeI">
          <option></option>
          <option value="00" selected>00</option>
          <option value="15">15</option>
          <option value="30">30</option>
          <option value="45">45</option>
        </select>--></td>
    </tr>
      <tr>
        <td class="title">Reasons for indwelling nasogastric tube</td>
        <td><?php echo draw_option("part7_reason","Dysphagia;Easily choked;Indwelled during hospitalization;Other","xxl","single",$part7_reason,true,2); ?> <input type="text" name="part7_reasonother" id="part7_reasonother" size="15"></td>
      </tr>
      <tr>
        <td class="title">Filled by</td>
        <td><?php echo checkusername($_SESSION['ncareID_lwj']); ?><input type="hidden" name="Qfiller" id="Qfiller" value="<?php echo $_SESSION['ncareID_lwj']; ?>"></td>
      </tr>
    </table>
  </fieldset>
  </form>
</div>
    <div id="tab2_part1">
    <table class="content-query" style="font-size:8pt; font-weight:normal;">
      <tr class="title">
      <td class="printcol">View</td>
      <td>Care ID#</td>
      <td>Full name</td>
      <td>Start date</td>
      <td>End date</td>
      <td>Reasons for indwelling nasogastric tube</td>
      <td>Assessment and follow up</td>
      <td>Results</td>
      <td>Filled by</td>
	  <?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?>
      <td class="printcol">Delete</td>
	  <?php }?>
      <td class="printcol">Print</td>
      </tr>
    <?php
	$dbp1_7 = new DB;
	$dbp1_7->query("SELECT * FROM  `sixtarget_part7` WHERE `HospNo`='".$HospNo."'");
	if ($dbp1_7->num_rows()==0) {
	?>
      <tr>
        <td colspan="11"><center>-------Yet no data of this month-------</center></td>
      </tr>
    <?php
	} else {
	for ($p1_i1=0;$p1_i1<$dbp1_7->num_rows();$p1_i1++) {
		$rp1_7 =$dbp1_7->fetch_assoc();
		  foreach ($rp1_7 as $k=>$v) {
			  $arrAnswer = explode("_",$k);
			  if (count($arrAnswer)==2) {
				  if ($v==1) { ${$arrAnswer[0]} .= $arrAnswer[1].';'; }
			  } else {
				  ${$k} = $v;
			  }
		  }
	/*== 解 START ==*/
	    $rsa = new lwj('lwj/lwj');
	    $puepart = explode(" ",$Name);
	    $puepartcount = count($puepart);
	    if($puepartcount>1){
            for($j=0;$j<$puepartcount;$j++){
                $prdpart = $rsa->privDecrypt($puepart[$j]);
                $Name = $Name.$prdpart;
            }
	    }else{
		   $Name = $rsa->privDecrypt($Name);
	    }
	/*== 解 END ==*/
	?>
      <tr>
        <td class="printcol"><center><a href="index.php?mod=nurseform&func=formview&id=23_1&pid=<?php echo $_GET['pid']; ?>&tID=<?php echo $targetID; ?>"><img src="Images/folder.png" width="24" /></a></center></td>
        <td><center><?php echo $HospNo; ?></center></td>
        <td><center><?php echo $Name; ?></center></td>
        <td><center><?php echo $startdate; ?></center></td>
        <td><center><?php echo $enddate; ?></center></td>
        <td><center><?php echo option_result("reason","Dysphagia;Easily choked;Indwelled during hospitalization;Other","l","single",$reason,false,3).$reasonother; ?></center></td>
        <td><center><?php echo str_replace("\n","<br>",$releasereason); ?></center></td>
        <td><center><?php echo option_result("result","Success;Unsuccessful","l","single",$result,false,3); ?></center></td>
        <td><center><?php echo checkusername($Qfiller); ?></center></td>
		<?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?>
        <td class="printcol"><center><a href="index.php?mod=management&func=formview&id=3c_7&pid=<?php echo $_GET['pid']; ?>&tID=<?php echo $targetID; ?>"><img src="Images/delete2.png" width="30"/></a></center></td>
        <?php }?>
		<td class="printcol"><center><a href="print.php?mod=nurseform&func=formview&id=23_1&pid=<?php echo $_GET['pid']; ?>&tID=<?php echo $targetID; ?>" target="_blank"><img src="Images/printer.png" width="30"/></a></center></td>
      </tr>
    <?php
	$result="";
	$reason="";
	}
	}
	?>
    </table>
    </div>
    </td>
  </tr>
</table><br><br>
<script>
$(document).ready( function () {
	$('#HospNo_tab2').val('<?php echo $HospNo; ?>');
	loadPatInfo('tab2');
});
</script>