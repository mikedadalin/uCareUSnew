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
<h3>Resident transfer to ER</h3>
<table width="100%" bgcolor="#ffffff">
  <tr>
    <td valign="top" bgcolor="#ffffff">
    <div id="tab1">
	<?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?>
    <form><input type="button" value="Add resident transfer to ER record" id="newrecord1" onclick="openVerificationForm('#dialog-form1');" /></form>
	<?php }?>
<script>
$(function() {
    $( "#dialog-form1" ).dialog({
		autoOpen: <?php echo ($_GET['autoOpen']==''?'false':$_GET['autoOpen']); ?>,
		height: 660,
		width: 900,
		modal: true,
		buttons: {
			"Add record": function() {
				$.ajax({
					url: "class/sixtarget_part1.php",
					type: "POST",
					data: {'HospNo': $('#HospNo_tab1').val(), 'Name': $('#Name_tab1').val(), 'indate': $('#indate').val(), 'thisoutdate': $('#thisoutdate').val(), 'outdate': $('#outdate').val(), 'indays': $('#indays').val(), 'is72hr_1': $('#is72hr_1').val(), 'occurence_1': $('#occurence_1').val(), 'occurence_2': $('#occurence_2').val(), 'occurence_3': $('#occurence_3').val(), 'reason_1': $('#reason_1').val(), 'reason_2': $('#reason_2').val(), 'reason_3': $('#reason_3').val(), 'reason_4': $('#reason_4').val(), 'reason_5': $('#reason_5').val(), 'reason_6': $('#reason_6').val(), 'reason_7': $('#reason_7').val(), 'reason_8': $('#reason_8').val(), 'reason_9': $('#reason_9').val(), 'reason_10': $('#reason_10').val(), 'reason_11': $('#reason_11').val(), 'reason_12': $('#reason_12').val(), 'reason_13': $('#reason_13').val(), 'reason_14': $('#reason_14').val(), 'reasonanalysis_1': $('#reasonanalysis_1').val(), 'reasonanalysis_2': $('#reasonanalysis_2').val(), 'reasonanalysis_3': $('#reasonanalysis_3').val(), 'result_1': $('#result_1').val(), 'result_2': $('#result_2').val(), 'result_3': $('#result_3').val(), 'result_4': $('#result_4').val(), 'resultanalysis_1': $('#resultanalysis_1').val(), 'resultanalysis_2': $('#resultanalysis_2').val(), 'lastoutdate': $('#lastoutdate').val(), 'outdays': $('#outdays').val(), 'Qfiller': $('#Qfiller').val(), "transform": "1" },
					success: function(data) {
						$( "#dialog-form1" ).dialog( "close" );
						alert("Add record sucessfully!");
						window.location.reload();
					}
				});
			},
			"Cancel": function() {
				$( "#dialog-form1" ).dialog( "close" );
			}
		}
	});
});
</script>
<div id="dialog-form1" title="Add resident transfer to ER record" class="dialog-form"> 
  <form>
  <fieldset>
    <script>
	function calcindays() {
		var sTime = new Date(document.getElementById('thisoutdate').value);
		var eTime = new Date(document.getElementById('outdate').value);
		var indays = parseInt((eTime.getTime() - sTime.getTime()) / parseInt(1000 * 3600 * 24));
		document.getElementById('indays').value = indays;
		if (indays<4) {
			document.getElementById('btn_is72hr_1').className = "checkbox_on";
			document.getElementById('is72hr_1').value = "1";
		} else {
			document.getElementById('btn_is72hr_1').className = "checkbox_off";
			document.getElementById('is72hr_1').value = "0";
		}
	}
	function calcoutdays() {
		var sTime = new Date(document.getElementById('outdate').value);
		var eTime = new Date(document.getElementById('lastoutdate').value);
		var indays = parseInt((eTime.getTime() - sTime.getTime()) / parseInt(1000 * 3600 * 24));
		document.getElementById('outdays').value = indays;
	}
	</script>
    <table>
      <tr>
        <td class="title">Care ID#</td>
        <td><input type="text" size="8" value="<?php echo getHospNoDisplayByPID($_GET['pid']); ?>" readonly><input type="hidden" name="HospNo" id="HospNo_tab1" value="<?php echo $HospNo; ?>"></td>
        <td class="title">Full name</td>
        <td><input type="text" name="Name" id="Name_tab1" readonly  size="16"></td>
      </tr>
      <tr>
        <td class="title">Admission date</td>
        <td><input type="text" name="indate" id="indate" value=""></td>
        <td class="title">Previous returned from hospital date(last time)</td>
        <td><script> $(function() { $( "#thisoutdate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="thisoutdate" id="thisoutdate" value="<?php echo date(Y."/".m."/".d); ?>" ></td>
      </tr>
      <tr>
        <td class="title">Transfer/ hospitalized date</td>
        <td><script> $(function() { $( "#outdate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="outdate" id="outdate" value="<?php echo date(Y."/".m."/".d); ?>"></td>
        <td class="title">Stay in the facility/center day(s)</td>
        <td><input type="text" name="indays" id="indays" value="" size="3">Day(s) <input type="button" onclick="calcindays()" value="Calculate day(s)" /></td>
      </tr>
      <tr>
        <td class="title">Transfer/ hospitalized date</td>
        <td colspan="3"><?php echo draw_checkbox("is72hr","Hospitalize within 72hrs after admission",$is72hr,"single"); ?></td>
      </tr>
      <tr>
        <td class="title">Occur shift</td>
        <td colspan="3"><?php echo draw_option("occurence","Graveyard shift;Day shift;Night shift","xm","single",$occurence,false,4); ?></td>
      </tr>
      <?php
		  $reasonTxt = "Hypotension;Myocardial Infarction;Arrhythmia;Fracture;Gastrorrhagia;Intestinal obstruction;Urinary tract infection;Pneumonia;Septicemia;Electrolyte imbalance;Dyspnea;Asthma;Head injury;Fever;Blood pressure drop;Other";
	  ?>
      <tr>
        <td class="title">Hospitalization main<br />diagnosis or reason</td>
        <td colspan="3"><?php echo draw_option("reason",$reasonTxt,"xl","single",$reason,true,3); ?>：<input type="text" name="reasonOther" id="reasonOther" size="10" value="<?php echo $reasonOther; ?>"></td>
      </tr>
      <tr>
        <td class="title">Cause analysis</td>
        <td colspan="3"><?php echo draw_option("reasonanalysis","Changes in disease;Unstable condition when admission;Improper care","xxxl","single",$reasonanalysis,false,2); ?></td>
      </tr>
      <tr>
        <td class="title">Results</td>
        <td colspan="3"><?php echo draw_option("result","Returns after treatment;Observing;Hospitalization;Death","xl","single",$result,true,2); ?></td>
      </tr>
      <tr>
        <td class="title">Category analysis</td>
        <td colspan="3"><?php echo draw_option("resultanalysis","Controllable;Uncontrollable","xm","single",$resultanalysis,false,4); ?></td>
      </tr>
      <tr>
        <td class="title">Returned from hospital date(this time)</td>
        <td><script> $(function() { $( "#lastoutdate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="lastoutdate" id="lastoutdate" value="<?php echo date(Y."/".m."/".d); ?>"></td>
        <td class="title">Hospitalize days</td>
        <td><input type="text" name="outdays" id="outdays" value="" size="3">Day(s) <input type="button" onclick="calcoutdays()" value="Calculate day(s)" /></td>
      </tr>
      <input type="hidden" name="Qfiller" id="Qfiller" value="<?php echo $_SESSION['ncareID_lwj']; ?>">
    </table>
  </fieldset>
  </form>
</div>
    <div id="tab1_part1">
    <table class="content-query" style="font-size:8pt; font-weight:normal;">
      <tr class="title">
        <td rowspan="3" class="printcol">View</td>
        <td rowspan="3">Medical<br />record<br />number</td>
        <td rowspan="3">Name</td>
        <td rowspan="2">E</td>
        <td rowspan="2">Y</td>
        <td rowspan="2">X</td>
        <td rowspan="2">X-Y</td>
        <td rowspan="2">B</td>
        <td colspan="3">Occur shift</td>
        <td colspan="14">Hospitalization main diagnosis or reason</td>
        <td colspan="3">Cause analysis</td>
        <td colspan="4">Results</td>
        <td colspan="2">Category analysis</td>
        <td>Z</td>
        <td>Z-X</td>
        <td rowspan="3" class="printcol">Print</td>
      </tr>
      <tr class="title">
  	    <td rowspan="2" style="transform:rotate(270deg)">graveyard</td>
  	    <td rowspan="2" style="transform:rotate(270deg)">Day</td>
  	    <td rowspan="2" style="transform:rotate(270deg)">Night</td>
  	    <td colspan="3">D1</td>
  	    <td>D2</td>
  	    <td colspan="2">D3</td>
  	    <td colspan="3">D4</td>
  	    <td colspan="5">D5</td>
  	    <td rowspan="2" style="transform:rotate(270deg)">Changes in disease</td>
  	    <td rowspan="2" style="transform:rotate(270deg)">Unstable condition when admission</td>
  	    <td rowspan="2"style="transform:rotate(270deg)">Improper care</td>
  	    <td rowspan="2"style="transform:rotate(270deg)">Returns after treatment</td>
  	    <td rowspan="2"style="transform:rotate(270deg)">Observing</td>
  	    <td rowspan="2"style="transform:rotate(270deg)">Hospitalization</td>
  	    <td rowspan="2"style="transform:rotate(270deg)">Death</td>
  	    <td rowspan="2"style="transform:rotate(270deg)">Controllable</td>
  	    <td rowspan="2"style="transform:rotate(270deg)">Uncontrollable</td>
  	    <td rowspan="2"style="transform:rotate(270deg)">Returned from hospital date</td>
  	    <td rowspan="2" style="transform:rotate(270deg)">Hospitalize day(s)</td>
      </tr>
      <tr class="title">
        <td >Admission<br />date</td>
        <td>Previous <br /> discharged<br />from<br />hospital<br />date</td>
        <td>Transfer<br />to<br />hospitalize<br />date</td>
        <td>Stay in the <br />facility/center<br />days</td>
        <td>Hospitalize<br />within<br />72hrs<br />after<br />admission</td>
        <td style="transform:rotate(270deg)">Hypotension</td>
        <td style="transform:rotate(270deg)">Myocardial Infarction</td>
        <td style="transform:rotate(270deg)">Arrhythmia</td>
        <td style="transform:rotate(270deg)">Fracture</td>
        <td style="transform:rotate(270deg)">Gastrorrhagia</td>
        <td style="transform:rotate(270deg)">Intestinal obstruction</td>
        <td style="transform:rotate(270deg)">Urinary tract infection</td>
        <td style="transform:rotate(270deg)">Pneumonia</td>
        <td style="transform:rotate(270deg)">Septicemia</td>
        <td style="transform:rotate(270deg)">Electrolyte imbalance</td>
        <td style="transform:rotate(270deg)">Dyspnea</td>
        <td style="transform:rotate(270deg)">Asthma</td>
        <td style="transform:rotate(270deg)">Head injury</td>
        <td style="transform:rotate(270deg)">Other</td>
        </tr>
    <?php
	$dbp1_1 = new DB;
	$dbp1_1->query("SELECT * FROM  `sixtarget_part1` WHERE `HospNo`='".$HospNo."'");
	if ($dbp1_1->num_rows()==0) {
	?>
      <tr>
        <td colspan="37"><center>-------Yet no data of this month-------</center></td>
      </tr>
    <?php
	} else {
	for ($p1_i1=0;$p1_i1<$dbp1_1->num_rows();$p1_i1++) {
		$rp1_1 =$dbp1_1->fetch_assoc();
	/*== 解 START ==*/
	    $rsa = new lwj('lwj/lwj');
	    $puepart = explode(" ",$rp1_1['Name']);
	    $puepartcount = count($puepart);
	    if($puepartcount>1){
            for($j=0;$j<$puepartcount;$j++){
                $prdpart = $rsa->privDecrypt($puepart[$j]);
                $rp1_1['Name'] = $rp1_1['Name'].$prdpart;
            }
	    }else{
		   $rp1_1['Name'] = $rsa->privDecrypt($rp1_1['Name']);
	    }
	/*== 解 END ==*/
	?>
      <tr>
        <td class="printcol"><center><a href="index.php?mod=management&func=formview&pid=<?php echo $_GET['pid']; ?>&id=3b_1&tID=<?php echo $rp1_1['targetID']; ?>"><img src="Images/folder.png" width="20" /></a></center></td>
        <td><?php echo getHospNoDisplayByPID(@$_GET['pid']); ?></td>
        <td><?php echo $rp1_1['Name']; ?></td>
        <td><?php echo $rp1_1['indate']; ?></td>
        <td><?php echo $rp1_1['outdate']; ?></td>
        <td><?php echo $rp1_1['thisoutdate']; ?></td>
        <td><?php echo $rp1_1['indays']; ?></td>
        <td><?php echo $rp1_1['is72hr_1']; ?></td>
        <td><?php echo $rp1_1['occurence_1']; ?></td>
        <td><?php echo $rp1_1['occurence_2']; ?></td>
        <td><?php echo $rp1_1['occurence_3']; ?></td>
        <td><?php echo $rp1_1['reason_1']; ?></td>
        <td><?php echo $rp1_1['reason_2']; ?></td>
        <td><?php echo $rp1_1['reason_3']; ?></td>
        <td><?php echo $rp1_1['reason_4']; ?></td>
        <td><?php echo $rp1_1['reason_5']; ?></td>
        <td><?php echo $rp1_1['reason_6']; ?></td>
        <td><?php echo $rp1_1['reason_7']; ?></td>
        <td><?php echo $rp1_1['reason_8']; ?></td>
        <td><?php echo $rp1_1['reason_9']; ?></td>
        <td><?php echo $rp1_1['reason_10']; ?></td>
        <td><?php echo $rp1_1['reason_11']; ?></td>
        <td><?php echo $rp1_1['reason_12']; ?></td>
        <td><?php echo $rp1_1['reason_13']; ?></td>
        <td><?php echo $rp1_1['reason_14']; ?></td>
        <td><?php echo $rp1_1['reasonanalysis_1']; ?></td>
        <td><?php echo $rp1_1['reasonanalysis_2']; ?></td>
        <td><?php echo $rp1_1['reasonanalysis_3']; ?></td>
        <td><?php echo $rp1_1['result_1']; ?></td>
        <td><?php echo $rp1_1['result_2']; ?></td>
        <td><?php echo $rp1_1['result_3']; ?></td>
        <td><?php echo $rp1_1['result_4']; ?></td>
        <td><?php echo $rp1_1['resultanalysis_1']; ?></td>
        <td><?php echo $rp1_1['resultanalysis_2']; ?></td>
        <td><?php echo $rp1_1['lastoutdate']; ?></td>
        <td><?php echo $rp1_1['outdays']; ?></td>
        <td class="printcol"><center><a href="print.php?mod=management&func=formview&pid=<?php echo $_GET['pid']; ?>&id=3b_1&tID=<?php echo $rp1_1['targetID']; ?>" target="_blank"><img src="Images/print.png" width="42" /></a></center></td>
      </tr>
    <?php
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
	//$('#HospNo_tab1').val('<?php echo $HospNo; ?>');
	loadPatInfo('tab1');
});
</script>