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
<h3>Integrative individual care plan</h3>
<table width="100%" bgcolor="#ffffff" style="border-radius:10px;">
  <tr>
    <td valign="top" bgcolor="#ffffff">
    <form><input type="button" value="Add record" id="newrecord2" onclick="openVerificationForm('#dialog-form2');" /></form>
<script>
$(function() {
    $( "#dialog-form2" ).dialog({
		autoOpen: false,
		height: 570,
		width: 900,
		modal: true,
		buttons: {
			"Add record": function() {
				$.ajax({
					url: "class/nurseform31.php",
					type: "POST",
					data: {'HospNo': $('#HospNo_tab2').val(), 'Name': $('#Name_tab2').val(),
					'date': $('#date').val(), 
					'Q1': $('#Q1').val(), 
					'Q2': $('#Q2').val(), 
					'Q4': $('#Q4').val(), 
					'Q3_1': $('#Q3_1').val(), 
					'Q3_2': $('#Q3_2').val(), 
					'Q3_3': $('#Q3_3').val(), 
					'Q3_4': $('#Q3_4').val(),
					'Q3_5': $('#Q3_5').val(),  
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
<div id="dialog-form2" title="Integrative individual care plan" class="dialog-form"> 
  <form>
  <fieldset>
    <table>
      <tr>
        <td class="title">Care ID#</td>
        <td><input type="text" name="HospNo" id="HospNo_tab2" size="8"> Full name <input type="text" name="Name" id="Name_tab2" readonly  size="16"></td>
      </tr>
      <tr>
      <td class="title">Date</td>
      <td><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php echo date("Y/m/d"); ?>">&nbsp;</td>
    </tr>
      <tr>
        <td class="title">Current problems and demand assessment</td>
        <td><textarea name="Q1" id="Q1" cols="80" rows="3"></textarea></td>
      </tr>
      <tr>
        <td class="title">Topic of discussion with family</td>
        <td><textarea name="Q2" id="Q2" cols="80" rows="3"></textarea></td>
      </tr>
      <tr>
        <td class="title">Conclusion and follow up</td>
        <td><textarea name="Q4" id="Q4" cols="80" rows="3"></textarea></td>
      </tr>
      <tr>
        <td class="title">Need to notify multi-disciplinary care group</td>
        <td><?php echo draw_option("Q3","Social worker;physiotherapist;Nutritionist;Pharmacist;Physician","xm","multi",$Q3,false,3); ?></td>
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
      <td>Date</td>
      <td>Current problems and demand assessment</td>
      <td>Topic of discussion with family</td>
      <td>Conclusion and follow up</td>
      <td>Notify multi-disciplinary care group</td>
      <td>Filled by</td>
      <td class="printcol">Print</td>
      </tr>
    <?php
	$dbp1_7 = new DB;
	$dbp1_7->query("SELECT * FROM  `nurseform31` WHERE `HospNo`='".$HospNo."'");
	if ($dbp1_7->num_rows()==0) {
	?>
      <tr>
        <td colspan="10"><center>-------Yet no data of this month-------</center></td>
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
        <td class="printcol"><center><a href="index.php?mod=nurseform&func=formview&id=31_1&pid=<?php echo $_GET['pid']; ?>&tID=<?php echo $targetID; ?>"><img src="Images/folder.png" width="24" /></a></center></td>
        <td><?php echo $HospNo; ?></td>
        <td><center><?php echo $Name; ?></center></td>
        <td><?php echo $date; ?></td>
        <td><center><?php echo $Q1; ?></center></td>
        <td><center><?php echo $Q2; ?></center></td>
        <td><center><?php echo $Q4; ?></center></td>
        <td><center><?php echo option_result("Q3","Social worker;physiotherapist;Nutritionist;Pharmacist;Physician","m","single",$Q3,false,3); ?></center></td>
        <td><center><?php echo checkusername($Qfiller); ?></center></td>
        <td class="printcol"><center><a href="print.php?mod=nurseform&func=formview&id=31_1&pid=<?php echo $_GET['pid']; ?>&tID=<?php echo $targetID; ?>" target="_blank"><img src="Images/printer.png" width="30"/></a></center></td>
      </tr>
    <?php
	$Q3="";
	}
	}
	?>
    </table>
    </div>
    </td>
  </tr>
</table>
<script>
$(document).ready( function () {
	$('#HospNo_tab2').val('<?php echo $HospNo; ?>');
	loadPatInfo('tab2');
});
</script>