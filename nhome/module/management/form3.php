<style>
@media print {
	* {
		font-family: "標楷體", DFKai-sb, BiauKai, STKaiTi-TC-Regular, "KaiTi TC Regular";
	}
	#tab1 td {
		font-size:10pt;
	}
	#tab1 .title td {
		font-size:9pt;
	}
}
</style>
<script>
<?php
if (@$_GET['reset']==1) {
	?>
	$(document).ready( function () {
		$('#stat<?php echo @$_GET['view']; ?>').submit();
	});
	<?php
}
?>
function loadPatInfo(tab){
	if ($("#HospNo_"+tab).val()!="") { var HospNo= $("#HospNo_"+tab).val(); }
	if ($("#Name_"+tab).val()!="") { var Name= $("#Name_"+tab).val(); }
	if ($("#BedID_"+tab).val()!="") { var BedID= $("#BedID_"+tab).val(); }
	
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
			document.getElementById('HospNo_'+tab).value = medList2[6];
			document.getElementById('Name_'+tab).value = medList2[0];
			document.getElementById('BedID_'+tab).value = medList2[7];
			if (tab=="tab1") {
				if (medList2[1]!="") {
					document.getElementById('indate').value = medList2[1].substr(0,4) + '/' + medList2[1].substr(4,2) + '/' + medList2[1].substr(6,2);
				} else {
					document.getElementById('indate').value ='';
				}
				document.getElementById('outdate').value = medList2[8];
			}
			if (tab=="tab3") {
				document.getElementById('Gender_tab3').value = medList2[2];
				document.getElementById('Age_tab3').value = medList2[3];
				document.getElementById('Diag_tab3').value = medList2[4];
				document.getElementById('ADLtotal_tab3').value = medList2[5];
			}
			document.getElementById("search_"+tab).style.display = "none";
			document.getElementById("clear_"+tab).style.display = "inline-block";

			calcindays();

		}
	});
return medList;
}
function cleartab(tab) {
	$("#form"+tab)[0].reset();
	$('#search_tab'+tab).show();
	$('#clear_tab'+tab).hide();
	$('#HospNo_tab'+tab).attr("readonly",false);
	$('#Name_tab'+tab).attr("readonly",true);
	$('#BedID_tab'+tab).attr("readonly",false);
}
function printDialog(view, date) {
	if (view==6) {
		var btn3txt = "6 months analysis";
	} else {
		var btn3txt = "3 months(seasonal) analysis";
	}
	var $dialog = $('<div title="Print" class="dialog-form"><table width="100%"><tr><td class="title">Select report to print</td></tr></table></div>').dialog({
		width: "480px",
		buttons: [{
			text: "Current month record",
			click: function(){
				window.open("print.php?mod=management&func=formview&id=3&view="+view+"&part=1&qdate="+date);
			}
		},
		{
			text: "Current month statistic",
			click: function(){
				window.open("print.php?mod=management&func=formview&id=3&view="+view+"&part=2&qdate="+date);
			}
		},
		{
			text: btn3txt,
			click: function(){
				window.open("print.php?mod=management&func=formview&id=3&view="+view+"&part=3&qdate="+date);
			}
		},
		{
			text: "Annual analysis",
			click: function(){
				window.open("print.php?mod=management&func=formview&id=3&view="+view+"&part=4&qdate="+date);
			}
		}]
	});
	return false;
}
</script>
<?php $sMonth = ($_GET['qdate'] == "" ? "" : "&qdate=".$_GET['qdate']); ?>
<h3 class="printcol">9 indicators analysis</h3>
<table class="printcol" style="width:100%;">
	<tr>
		<td align="left" bgcolor="#ffffff" style="border-radius:10px;">
			<div style="float:left;">
				<form>&nbsp;&nbsp; Select month:
					<select id="selmonth">
						<option>--Select month--</option>
						<?php
						$nextmonth = date(m)+1; if ($nextmonth>12) { $nextmonth = 1; $nextyear = date(Y)+1; } else { $nextyear = date(Y); }
						if (strlen($nextmonth)==1) { $nextmonth = "0".$nextmonth; }
						//echo '<option value="'.$nextyear.$nextmonth.'">'.$nextyear.'-'.$nextmonth.'</option>'."\n";
						for ($i=date(m);$i>=(date(m)-24);$i--) {
							$month = $i;
							if ($year==NULL) { $year = date(Y); }
							if ($i<1) {
								$month = 12+$i;
								$year = date(Y)-1;
							}
							if ($i<-11) {
								$month = 24+$i;
								$year = date(Y)-2;
							}
							if (strlen($month)==1) {
								$month = "0".$month;
							}
							echo '<option value="'.$year.$month.'"';
							if (@$_GET['qdate']==$year.$month) { echo ' selected'; }
							echo '>'.$year.'-'.$month.'</option>'."\n";
						}
						?>
					</select>
					<input type="button" onclick="gotoDate();" value="Search" > <input type="button" onclick="showallresult();" value="Display all data" >
				</form>
			</div>
			<script>
			function gotoDate() {
				var selectedmonth = document.getElementById('selmonth').value;
				window.location.href='index.php?mod=management&func=formview&id=3&view=<?php echo @$_GET['view']; ?>&part=<?php echo @$_GET['part']; ?>&qdate='+selectedmonth;
			}
			function showallresult() {
				window.location.href='index.php?mod=management&func=formview&id=3&view=<?php echo @$_GET['view']; ?>&part=<?php echo @$_GET['part']; ?>&qdate=ALL';
			}
			</script>
			<div style="float:right;">
				<form>
					<!--<input type="button" value="Multi-disciplinary care conferences" onclick="window.location.href='index.php?mod=management&func=formview&id=9_1'" />-->
					<input type="button" value="Input daily resident count" onclick="window.location.href='index.php?mod=management&func=formview&id=3a'" />
				</form>
			</div>
		</td>
	</tr>
</table>
<?php
if (@$_GET['qdate']==NULL) { $qdate = date(Ym); $qdate2 = date('Y/m'); $qdateY = date('Y'); $qdateM = date('m');} elseif (@$_GET['qdate']=="ALL") { $qdate = "%"; $qdate2 = "%"; $qdateY = date('Y'); $qdateM = date('m');} else { $qdate = @$_GET['qdate']; $qdate2 = substr(@$_GET['qdate'],0,4).'/'.substr(@$_GET['qdate'],4,2); $qdateY = substr(@$_GET['qdate'],0,4); $qdateM = substr(@$_GET['qdate'],4,2);}
?>
<div id="tabs" style="width:100%; background-color: rgba(255,255,255,0.55);">
	<ul class="printcol" style="margin-bottom:10px;">
		<li><a href="#tab1">Unexpected transfer to acute hospital indicators</a></li>
		<li><a href="#tab2">Restraint Indicator</a></li>
		<li><a href="#tab3">Fall Indicator</a></li>
		<li><a href="#tab4">Infection Indicator</a></li>
		<li><a href="#tab5">Pressure ulcer Indicator</a></li>
		<li><a href="#tab6">Unplanned weight change</a></li>
		<li><a href="#tab7">Pain Indicator</a></li>
		<li><a href="#tab8">Nasogastric tube remove</a></li>
		<li><a href="#tab9">Catheter remove</a></li>
		<li><a href="#tab10">Falls</a></li>
	</ul>
	<!--Hospitalization-->
	<div id="tab1" style="font-size:11pt;">
		<h3>Unexpected transfer to acute hospital (<?php echo $qdate2; ?>)</h3>
		<div align="center">
			<div style="margin-bottom:10px;">
				<?php echo draw_option("tab1option","Current month record;Current month statistic;3 months(seasonal) analysis;Annual analysis","xl","single",1,false,5); ?>
			</div>
			<div>
				<button type="button" id="newrecord1" title="Add resident transfer to ER record" onclick="openVerificationForm('#dialog-form1');"><i class="fa fa-user-plus fa-2x fa-fw"></i><br>Add new data</button>
				<div class="patlistbtn" style="background-color:rgb(149,219,208); width:100px;"><a href="index.php?mod=management&func=formview&id=3d_1&type=1<?php echo $sMonth;?>" title="逐案分析列表"><i class="fa fa-list fa-2x fa-fw"></i><br>Case-by-case analysis</a></div>
				<div class="patlistbtn" style="background-color:rgb(149,219,208);"><a href="#" onclick="printDialog('1', '<?php echo $_GET['qdate']; ?>');" title="Print report"><i class="fa fa-print fa-2x fa-fw"></i><br>Print report</a></div>
			</div>
		</div>
		<script>
		$(function() {
			$( "#dialog-form1" ).dialog({
				autoOpen: false,
				height: 660,
				width: 900,
				modal: true,
				buttons: {
					"Add record": function() {
						var e = 0;
						if ($("#HospNo_tab1").val()=="") {
							alert("Please fill resident info");
							$("#HospNo_tab1").css('background', '#FC3').focus().delay(2000).queue(function () { $("#HospNo_tab1").css('background','#fff'); });
							$("#Name_tab1").css('background', '#FC3').delay(2000).queue(function () { $("#Name_tab1").css('background','#fff'); });
							$("#BedID_tab1").css('background', '#FC3').delay(2000).queue(function () { $("#BedID_tab1").css('background','#fff'); });
							e++;
						} else if ($('#outdate').val() == "" && $('#indate').val() == "") {
							alert('Fill admission date and last return date');
							$('#indate').css('background', '#FC3').focus().delay(2000).queue(function () { $("#indate").css('background','#fff'); });
							$('#outdate').css('background', '#FC3').delay(2000).queue(function () { $("#outdate").css('background','#fff'); });
							e++;
						} else if ($('#outdate').val()!="" && $('#indate').val() > $('#outdate').val()) {
							alert(' Latest admission date should come before previous admission date ');
							$('#indate').css('background', '#FC3').focus().delay(2000).queue(function () { $("#indate").css('background','#fff'); });
							$('#outdate').css('background', '#FC3').delay(2000).queue(function () { $("#outdate").css('background','#fff'); });
							e++;
						} else if ($('#thisoutdate').val() == "") {
							alert('Fill hospitalized date!');
							$('#thisoutdate').css('background', '#FC3').focus().delay(2000).queue(function () { $("#thisoutdate").css('background','#fff'); });
							e++;
			  /*} else if ($('#lastoutdate').val()=="") {
				  alert('出院日期未填寫！');
				  $('#lastoutdate').css('background', '#FC3').focus().delay(2000).queue(function () { $("#lastoutdate").css('background','#fff'); });
				  e++;*/
				} else if ($('#lastoutdate').val()!="" && $('#thisoutdate').val() > $('#lastoutdate').val()) {
					alert('Hospitalized date should come before hospital discharge date');
					$('#thisoutdate').css('background', '#FC3').focus().delay(2000).queue(function () { $("#thisoutdate").css('background','#fff'); });
					$('#lastoutdate').css('background', '#FC3').delay(2000).queue(function () { $("#lastoutdate").css('background','#fff'); });
					e++;
				}
				if (e==0) {
					calcindays();
					calcoutdays();
					$.ajax({
						url: "class/sixtarget_part1.php",
						type: "POST",
						data: {'HospNo': $('#HospNo_tab1').val(), 'Name': $('#Name_tab1').val(), 'indate': $('#indate').val(), 'thisoutdate': $('#thisoutdate').val(), 'outdate': $('#outdate').val(), 'indays': $('#indays').val(), 'is72hr_1': $('#is72hr_1').val(), 'occurence_1': $('#occurence_1').val(), 'occurence_2': $('#occurence_2').val(), 'occurence_3': $('#occurence_3').val(), 'reason_1': $('#reason_1').val(), 'reason_2': $('#reason_2').val(), 'reason_3': $('#reason_3').val(), 'reason_4': $('#reason_4').val(), 'reason_5': $('#reason_5').val(), 'reason_6': $('#reason_6').val(), 'reason_7': $('#reason_7').val(), 'reason_8': $('#reason_8').val(), 'reason_9': $('#reason_9').val(), 'reason_10': $('#reason_10').val(), 'reason_11': $('#reason_11').val(), 'reason_12': $('#reason_12').val(), 'reason_13': $('#reason_13').val(), 'reason_14': $('#reason_14').val(), 'reasonanalysis_1': $('#reasonanalysis_1').val(), 'reasonanalysis_2': $('#reasonanalysis_2').val(), 'reasonanalysis_3': $('#reasonanalysis_3').val(), 'result_1': $('#result_1').val(), 'result_2': $('#result_2').val(), 'result_3': $('#result_3').val(), 'result_4': $('#result_4').val(), 'resultanalysis_1': $('#resultanalysis_1').val(), 'resultanalysis_2': $('#resultanalysis_2').val(), 'lastoutdate': $('#lastoutdate').val(), 'outdays': $('#outdays').val(), 'Qfiller': $('#Qfiller').val() },
						success: function(data) {
							$( "#dialog-form1" ).dialog( "close" );
							alert("Add record sucessfully!");
							window.location.reload();
						}
					});
}
},
"Cancel": function() {
	$( "#dialog-form1" ).dialog( "close" );
}
}
});
});
</script>
<div id="dialog-form1" title="Add resident transfer to ER record" class="dialog-form"> 
	<form id="form1">
		<fieldset>
			<script>
			function calcindays() {
				var eTime = new Date(document.getElementById('thisoutdate').value);
				if (document.getElementById('outdate').value!="") {
					var sTime = new Date(document.getElementById('outdate').value);
				} else if (document.getElementById('indate').value!="") {
					var sTime = new Date(document.getElementById('indate').value);
				}
				if (sTime!="") {
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
			}
			function calcoutdays() {
				var eTime = new Date(document.getElementById('lastoutdate').value);
				var sTime = new Date(document.getElementById('thisoutdate').value);
				var indays = parseInt((eTime.getTime() - sTime.getTime()) / parseInt(1000 * 3600 * 24));
				document.getElementById('outdays').value = indays;
			}
			</script>
			<table>
				<tr>
					<td class="title">Search</td>
					<td colspan="3">
						&nbsp;<span style="padding:3px; border:1px solid #999; color:#666; font-size:10pt;">Care ID#</span> <input type="text" name="HospNo" id="HospNo_tab1" value="" size="8">&nbsp;
						<span style="padding:3px; background:#69b3b6; color:#fff; font-size:10pt;">or</span>&nbsp;
						<span style="padding:3px; border:1px solid #999; color:#666; font-size:10pt;">Bed #</span> <input type="text" name="BedID" id="BedID_tab1" size="8">&nbsp;
						<span style="padding:3px; border:1px solid #999; color:#666; font-size:10pt;">Full name</span> <input type="text" name="Name" id="Name_tab1" size="8" readonly="readonly">&nbsp;
						<input type="button" value="Search" id="search_tab1" onclick="loadPatInfo('tab1')" />
						<input type="button" value="Empty" id="clear_tab1" onclick="cleartab('1')" style="display:none;" /></td>
					</tr>
					<tr>
						<td class="title">Admission date</td>
						<td><input type="text" name="indate" id="indate" value=""></td>
						<td class="title">Previous returned from hospital date(last time)</td>
						<td><script> $(function() { $( "#outdate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="outdate" id="outdate" value="" onchange="calcindays()"></td>
					</tr>
					<tr>
						<td class="title">Transfer/ hospitalized date</td>
						<td><script> $(function() { $( "#thisoutdate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="thisoutdate" id="thisoutdate" value="" onchange="calcindays();" ></td>
						<td class="title">Stay in the facility/center day(s)</td>
						<td><input type="text" name="indays" id="indays" value="" size="4">Day(s) <input type="button" onclick="calcindays()" value="Calculate day(s)" /></td>
					</tr>
					<tr>
						<td class="title">&nbsp;</td>
						<td colspan="3"><?php echo draw_checkbox("is72hr","Hospitalize within 72hrs after admission",$is72hr,"single"); ?></td>
					</tr>
					<tr>
						<td class="title">Occur shift</td>
						<td colspan="3"><?php echo draw_option("occurence","Graveyard shift;Day shift;Night shift","xm","single",$occurence,false,4); ?></td>
					</tr>
					<tr>
						<td class="title">Hospitalization main<br />diagnosis or reason</td>
						<?php
						$reasonTxt = "Hypotension;Myocardial Infarction;Arrhythmia;Fracture;Gastrorrhagia;Intestinal obstruction;Urinary tract infection;Pneumonia;Septicemia;Electrolyte imbalance;Dyspnea;Asthma;Head injury;Fever;Blood pressure drop;Other";
						?>
						<td colspan="3"><?php echo draw_option("reason",$reasonTxt,"xl","single",$reason,true,3); ?>：<input type="text" name="reasonOther" id="reasonOther" size="10" value="<?php echo $reasonOther; ?>"></td>
					</tr>
					<tr>
						<td class="title">Cause analysis</td>
						<td colspan="3"><?php echo draw_option("reasonanalysis","Changes in disease;Unstable condition when admission;Improper care","xxxl","single",$reasonanalysis,false,4); ?></td>
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
						<td class="title">Returned from hospital date</td>
						<td class="title"><script> $(function() { $( "#lastoutdate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="lastoutdate" id="lastoutdate" value=""></td>
						<td class="title">Hospitalize days</td>
						<td class="title"><input type="text" name="outdays" id="outdays" value="" size="4">Day(s) <input type="button" onclick="calcoutdays()" value="Calculate day(s)" /></td>
					</tr>
					<input type="hidden" name="Qfiller" id="Qfiller" value="<?php echo $_SESSION['ncareID_lwj']; ?>">
				</table>
			</fieldset>
		</form>
	</div>
	<script>
	$('#btn_tab1option_1').click(function() {
		$('#tab1_part1').show();
		$('#tab1_part2').hide();
		$('#tab1_part3').hide();
		$('#tab1_part4').hide();
	});
	$('#btn_tab1option_2').click(function() {
		$('#tab1_part1').hide();
		$('#tab1_part2').show();
		$('#tab1_part3').hide();
		$('#tab1_part4').hide();
	});
	$('#btn_tab1option_3').click(function() {
		$('#tab1_part1').hide();
		$('#tab1_part2').hide();
		$('#tab1_part3').show();
		$('#tab1_part4').hide();
	});
	$('#btn_tab1option_4').click(function() {
		$('#tab1_part1').hide();
		$('#tab1_part2').hide();
		$('#tab1_part3').hide();
		$('#tab1_part4').show();
	});
	$(function() { $('#tform1').validationEngine(); });
	</script>
	<!--住院資料列表-->
	<div id="tab1_part1">
		<form id="tform1" action="index.php?mod=management&func=formview&id=3d_2&type=1<?php echo $sMonth; ?>" method="post">
			<table class="content-query" style="font-size:10pt; font-weight:normal; width:100%;">
				<tr class="title">
					<td rowspan="3" class="printcol">View</td>
					<td rowspan="3">Name</td>
					<td rowspan="2">Y or E</td>
					<td rowspan="2">X</td>
					<td rowspan="2">X-Y</td>
					<td rowspan="2">B</td>
					<td colspan="3">Occur shift</td>
					<td colspan="14">Hospitalization main diagnosis or reason</td>
					<td colspan="3">Cause analysis</td>
					<td colspan="4">Results</td>
					<td colspan="2">Category analysis</td>
					<td align="center">Z</td>
					<td align="center">Z-X</td>
					<td rowspan="3" class="printcol">Case<br />by<br />case<br />analysis</td>
					<td rowspan="3" class="printcol">Delete</td>
				</tr>
				<tr class="title">
					<td rowspan="2" style="transform:rotate(270deg)">graveyard</td>
					<td rowspan="2" style="transform:rotate(270deg)">Day</td>
					<td rowspan="2" style="transform:rotate(270deg)">Night</td>
					<td colspan="3">D1</td>
					<td align="center">D2</td>
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
					<td rowspan="2" style="transform:rotate(270deg)">Returned from hospital date</td>
					<td rowspan="2">Hospitalize day(s)</td>
				</tr>
				<tr class="title">
					<td align="center">New admission<br />or<br />last return to center<br />date</td>
					<td align="center">Transfer<br />to<br />hospitalize<br />date</td>
					<td align="center">Stay in the <br /> facility/center<br />days</td>
					<td align="center">Hospitalize<br />within<br />72hrs<br />after<br />admission</td>
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
				$dbp1_1->query("SELECT * FROM  `sixtarget_part1` WHERE `thisoutdate` LIKE '".$qdate2."%' ");
				if ($dbp1_1->num_rows()==0) {
					?>
					<tr>
						<td colspan="36"><center>-------Yet no data of this month-------</center></td>
					</tr>
					<script>$(function() { $('#analysis1').hide(); });</script>
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
							<td class="printcol"><center><a href="index.php?mod=management&func=formview&id=3b_1&tID=<?php echo $rp1_1['targetID'].$sMonth; ?>"><img src="Images/folder.png" width="20" /></a></center></td>
							<td align="center"><?php echo $rp1_1['Name'].'<br>'.getHospNoDisplayByHospNo($rp1_1['HospNo']); ?></td>
							<td align="center"><?php echo $rp1_1['indate'].'<br>'.$rp1_1['outdate']; ?></td>
							<td align="center"><?php echo $rp1_1['thisoutdate']; ?></td>
							<td align="center"><?php echo $rp1_1['indays']; ?></td>
							<td align="center"><?php echo $rp1_1['is72hr_1']; ?></td>
							<td align="center"><?php echo $rp1_1['occurence_1']; ?></td>
							<td align="center"><?php echo $rp1_1['occurence_2']; ?></td>
							<td align="center"><?php echo $rp1_1['occurence_3']; ?></td>
							<td align="center"><?php echo $rp1_1['reason_1']; ?></td>
							<td align="center"><?php echo $rp1_1['reason_2']; ?></td>
							<td align="center"><?php echo $rp1_1['reason_3']; ?></td>
							<td align="center"><?php echo $rp1_1['reason_4']; ?></td>
							<td align="center"><?php echo $rp1_1['reason_5']; ?></td>
							<td align="center"><?php echo $rp1_1['reason_6']; ?></td>
							<td align="center"><?php echo $rp1_1['reason_7']; ?></td>
							<td align="center"><?php echo $rp1_1['reason_8']; ?></td>
							<td align="center"><?php echo $rp1_1['reason_9']; ?></td>
							<td align="center"><?php echo $rp1_1['reason_10']; ?></td>
							<td align="center"><?php echo $rp1_1['reason_11']; ?></td>
							<td align="center"><?php echo $rp1_1['reason_12']; ?></td>
							<td align="center"><?php echo $rp1_1['reason_13']; ?></td>
							<td align="center"><?php echo $rp1_1['reason_14']; ?></td>
							<td align="center"><?php echo $rp1_1['reasonanalysis_1']; ?></td>
							<td align="center"><?php echo $rp1_1['reasonanalysis_2']; ?></td>
							<td align="center"><?php echo $rp1_1['reasonanalysis_3']; ?></td>
							<td align="center"><?php echo $rp1_1['result_1']; ?></td>
							<td align="center"><?php echo $rp1_1['result_2']; ?></td>
							<td align="center"><?php echo $rp1_1['result_3']; ?></td>
							<td align="center"><?php echo $rp1_1['result_4']; ?></td>
							<td align="center"><?php echo $rp1_1['resultanalysis_1']; ?></td>
							<td align="center"><?php echo $rp1_1['resultanalysis_2']; ?></td>
							<td align="center"><?php echo $rp1_1['lastoutdate']; ?></td>
							<td align="center"><?php echo $rp1_1['outdays']; ?></td>
							<td class="printcol"><center><input type="checkbox" name="targetList_1[]" id="targetList_1_<?php echo $rp1_1['targetID']; ?>" class="validate[required]" value="<?php echo $rp1_1['targetID']; ?>"></center></td>
							<?php
							if ($_SESSION['ncareLevel_lwj']>=4 || $rp1_1['Qfiller']==$_SESSION['ncareID_lwj']) {
								echo '<td class="printcol"><a href="index.php?mod=management&func=formview&id=3c_1&tID='.$rp1_1['targetID'].'"><img src="Images/delete2.png" width="20"></a></td>';
							}
							?>
						</tr>
						<?php
					}
				}
				?>
			</table>
			<center><input type="submit" id="analysis1" value="Start case-by-case analysis" class="printcol"></center>
		</form>
	</div>
	<!--住院當月統計-->
	<center>
	<div id="tab1_part2" style="display:none;">
		<form action="index.php?func=save_sixtarget_stat" method="post" id="stat1">
			<table class="content-query">
				<tr class="title">
					<td align="center">Indicator item</td>
					<td align="center">Number</td>
					<td align="center">Formula</td>
					<td align="center">Rate(%)</td>
				</tr>
				<tr>
					<td class="title_s" style="text-align:left;">Montly new admission number (A)</td>
					<td align="center">
						<?php
						$db_a_0 = new DB;
						$db_a_0->query("SELECT * FROM `sixtarget_part1_stat` WHERE `month`='".$qdate."'");
						$r_a_0 = $db_a_0->fetch_assoc();
						$db_a_1 = new DB;
						$db_a_1->query("SELECT SUM(`newpat`) FROM `dailypatientno` WHERE DATE_FORMAT(`date`, '%Y/%m') = '".$qdate2."' AND `newpat`>0");
						$r_a_1 = $db_a_1->fetch_assoc();
						$db_a_1a = new DB;
						$db_a_1a->query("SELECT * FROM `sixtarget_part1` WHERE `lastoutdate` LIKE '".$qdate2."%' AND `indate` NOT LIKE '".$qdate2."%'");
						$tmp_varA = $r_a_1['SUM(`newpat`)'] + $db_a_1a->num_rows();
						?>
						<input type="text" name="sixtarget_stat1_varA" size="4" value="<?php if ($r_a_0['varA']=="") { echo $tmp_varA; } else { echo $r_a_0['varA']; } ?>" />
					</td>
					<td align="center">---</td>
					<td align="center">---</td>
				</tr>
				<tr>
					<td class="title_s" style="text-align:left;">Acute hospitalized whithin 72 hours since admission number(B)</td>
					<td align="center">
						<?php
						$db_a_2 = new DB;
						$db_a_2->query("SELECT `targetID` FROM `sixtarget_part1` WHERE `thisoutdate` LIKE '".$qdate2."%' AND `is72hr_1`='1'");
						?>
						<input type="text" name="sixtarget_stat1_varB" size="4" value="<?php if ($r_a_0['varB']=="") { echo $db_a_2->num_rows(); } else { echo $r_a_0['varB']; } ?>" />
					</td>
					<td align="center">B/A</td>
					<td align="center"><?php if ($r_a_0['varB']=="") { echo ($db_a_1->num_rows()>0?round(($db_a_2->num_rows()/$db_a_1->num_rows())*100,1):""); } else { echo $r_a_0['varA']>0?round(($r_a_0['varB']/$r_a_0['varA'])*100,1):"0"; } ?>%</td>
				</tr>
				<tr>
					<td class="title_s" style="text-align:left;">Monthly total residents (C)</font></td>
					<td align="center">
						<?php
						$db_a_3 = new DB;
						$db_a_3->query("SELECT `no` FROM `dailypatientno` WHERE `date` = '".str_replace("/","-",$qdate2)."-01'");
						$r_a_3 = $db_a_3->fetch_assoc();
						$db_a_3b = new DB;
						$db_a_3b->query("SELECT SUM(`newpat`) as `newpat` FROM `dailypatientno` WHERE DATE_FORMAT(`date`,'%Y-%m') = '".str_replace("/","-",$qdate2)."'");
						$r_a_3b = $db_a_3b->fetch_assoc();
						if ($r_a_0['varC']!="") {
							$stat1_varC = $r_a_0['varC'];
						} else {
	  $stat1_varC = $r_a_3['no'] + $r_a_3b['newpat']; //+$tmp_varA;
	}
	if ($stat1_varC=="") { $stat1_varC = 1; }

  //echo "SELECT `no` FROM `dailypatientno` WHERE `date` = '".str_replace("/","-",$qdate2)."-01'";
	?>
	<input type="text" name="sixtarget_stat1_varC" size="4" value="<?php if ($r_a_0['varC']=="") { echo $stat1_varC; } else { echo $r_a_0['varC']; } ?>" />
</td>
<td align="center">---</td>
<td align="center">---</td>
</tr>
<tr>
	<td class="title_s" style="text-align:left;">Monthly unplanned acute hospitalized resident (D)</td>
	<td align="center">
		<?php
		$db_a_4 = new DB;
		$db_a_4->query("SELECT `targetID` FROM `sixtarget_part1` WHERE `thisoutdate` LIKE '".$qdate2."%'");
		if ($r_a_0['varD']=="") { $stat1_varD = $db_a_4->num_rows(); } else { $stat1_varD = $r_a_0['varD']; }
		?>
		<input type="text" name="sixtarget_stat1_varD" size="4" value="<?php echo $stat1_varD; ?>" />
	</td>
	<td align="center">D/C</td>
	<td align="center"><?php if ($r_a_0['varD']=="") { echo round(($db_a_4->num_rows()/$stat1_varC)*100,1); } else { echo round(($r_a_0['varD']/$stat1_varC)*100,1); } ?>%</td>
</tr>
<tr>
	<td class="title_s" style="text-align:left;">Unplanned acute hospitalized resident due to cardiovascular hypofunction (D1)</td>
	<td align="center">
		<?php
		$db_a_5 = new DB;
		$db_a_5->query("SELECT `targetID` FROM `sixtarget_part1` WHERE `thisoutdate` LIKE '".$qdate2."%' AND (`reason_1`='1' OR `reason_2`='1' OR `reason_3`='1')");
		?>
		<input type="text" name="sixtarget_stat1_varD1" size="4" value="<?php if ($r_a_0['varD1']=="") { echo $db_a_5->num_rows(); } else { echo $r_a_0['varD1']; } ?>" />
	</td>
	<td align="center">D1/D</td>
	<td align="center"><?php if ($r_a_0['varD1']=="") { echo $stat1_varD>0?round(($db_a_5->num_rows()/$stat1_varD)*100,1):"0"; } else { echo $stat1_varD>0?round(($r_a_0['varD1']/$stat1_varD)*100,1):"0"; } ?>%</td>
</tr>
<tr>
	<td class="title_s" style="text-align:left;">Unplanned acute hospitalized resident due to treatment or assessment of fracture (D2)</td>
	<td align="center">
		<?php
		$db_a_6 = new DB;
		$db_a_6->query("SELECT `targetID` FROM `sixtarget_part1` WHERE `thisoutdate` LIKE '".$qdate2."%' AND (`reason_4`='1')");
		?>
		<input type="text" name="sixtarget_stat1_varD2" size="4" value="<?php if ($r_a_0['varD2']=="") { echo $db_a_6->num_rows(); } else { echo $r_a_0['varD2']; } ?>" />
	</td>
	<td align="center">D2/D</td>
	<td align="center"><?php if ($r_a_0['varD2']=="") { echo $stat1_varD>0?round(($db_a_6->num_rows()/$stat1_varD)*100,1):"0"; } else { echo $stat1_varD>0?round(($r_a_0['varD2']/$stat1_varD)*100,1):"0"; } ?>%</td>
</tr>
<tr>
	<td class="title_s" style="text-align:left;">Unplanned acute hospitalized resident due to gastrointestinal bleeding (D3)</td>
	<td align="center">
		<?php
		$db_a_7 = new DB;
		$db_a_7->query("SELECT `targetID` FROM `sixtarget_part1` WHERE `thisoutdate` LIKE '".$qdate2."%' AND (`reason_5`='1' OR `reason_6`='1')");
		?>
		<input type="text" name="sixtarget_stat1_varD3" size="4" value="<?php if ($r_a_0['varD3']=="") { echo $db_a_7->num_rows(); } else { echo $r_a_0['varD3']; } ?>" />
	</td>
	<td align="center">D3/D</td>
	<td align="center"><?php if ($r_a_0['varD3']=="") { echo $stat1_varD>0?round(($db_a_7->num_rows()/$stat1_varD)*100,1):"0"; } else { echo $stat1_varD>0?round(($r_a_0['varD3']/$stat1_varD)*100,1):"0"; } ?>%</td>
</tr>
<tr>
	<td class="title_s" style="text-align:left;">Unplanned acute hospitalized resident due to infection (D4)</td>
	<td align="center">
		<?php
		$db_a_8 = new DB;
		$db_a_8->query("SELECT `targetID` FROM `sixtarget_part1` WHERE `thisoutdate` LIKE '".$qdate2."%' AND (`reason_7`='1' OR `reason_8`='1' OR `reason_9`='1')");
		?>
		<input type="text" name="sixtarget_stat1_varD4" size="4" value="<?php if ($r_a_0['varD4']=="") { echo $db_a_8->num_rows(); } else { echo $r_a_0['varD4']; } ?>" />
	</td>
	<td align="center">D4/D</td>
	<td align="center"><?php if ($r_a_0['varD4']=="") { echo $stat1_varD>0?round(($db_a_8->num_rows()/$stat1_varD)*100,1):"0"; } else { echo $stat1_varD>0?round(($r_a_0['varD4']/$stat1_varD)*100,1):"0"; } ?>%</td>
</tr>
<tr>
	<td class="title_s" style="text-align:left;">Unplanned acute hospitalized resident due other medical and surgical reasons (D5)</td>
	<td align="center">
		<?php
		$db_a_9 = new DB;
		$db_a_9->query("SELECT `targetID` FROM `sixtarget_part1` WHERE `thisoutdate` LIKE '".$qdate2."%' AND (`reason_10`='1' OR `reason_11`='1' OR `reason_12`='1' OR `reason_13`='1' OR `reason_14`='1')");
		?>
		<input type="text" name="sixtarget_stat1_varD5" size="4" value="<?php if ($r_a_0['varD5']=="") { echo $db_a_9->num_rows(); } else { echo $r_a_0['varD5']; } ?>" />
	</td>
	<td align="center">D5/D</td>
	<td align="center"><?php if ($r_a_0['varD5']=="") { echo $stat1_varD>0?round(($db_a_9->num_rows()/$stat1_varD)*100,1):"0"; } else { echo $stat1_varD>0?round(($r_a_0['varD5']/$stat1_varD)*100,1):"0"; } ?>%</td>
</tr>
</table>
<table width="100%">
	<tr>
		<td class="title" colspan="3">PDCA analysis</td>
	</tr>
	<tr>
		<td class="title_s" style="text-align:left;" width="260">Plan</td>
		<td colspan="2"><textarea id="sixtarget_stat1_plan" name="sixtarget_stat1_plan" rows="4"><?php echo $r_a_0['plan']; ?></textarea></td>
	</tr>
	<tr>
		<td class="title_s" style="text-align:left;">Execution (Do)</td>
		<td colspan="2"><textarea id="sixtarget_stat1_do" name="sixtarget_stat1_do" rows="4"><?php echo $r_a_0['do']; ?></textarea></td>
	</tr>
	<tr>
		<td class="title_s" style="text-align:left;">Review (Check)</td>
		<td colspan="2"><textarea id="sixtarget_stat1_check" name="sixtarget_stat1_check" rows="4"><?php echo $r_a_0['check']; ?></textarea></td>
	</tr>
	<tr>
		<td class="title_s" style="text-align:left;">Improvement plan develop and action (Action)</td>
		<td colspan="2"><textarea id="sixtarget_stat1_action" name="sixtarget_stat1_action" rows="4"><?php echo $r_a_0['action']; ?></textarea></td>
	</tr>
</table>
<table width="100%">
	<tr <?php if ($qdate=="%") { echo 'style="display:none;"'; } ?> >
		<td class="title"><input type="hidden" name="month" value="<?php echo $qdate; ?>" /><input type="hidden" name="tbname" value="part1" /><input type="submit" value="Save <?php echo $qdate2; ?> Statistics" class="printcol" /> <input type="submit" value="Recalculate latest data formula" name="resetstat" class="printcol" /></td>
		<td colspan="3" class="title">Last modified date:<?php echo formatdate($r_a_0['savedate']); ?> Modified by:<?php echo checkusername($r_a_0['Qfiller']); ?></td>
	</tr>
</table>
</form>
</div>
</center>
<!--住院季分析-->
<center>
<div id="tab1_part3" style="display:none;">
	<table class="content-query" style="font-size:10pt;page-break-after:always;">
		<tr class="title">
			<td width="36%">&nbsp;</td>
			<td width="16%">Season 1 (Q1)</td>
			<td width="16%">Season 2 (Q2)</td>
			<td width="16%">Season 3 (Q3)</td>
			<td width="16%">Season 4 (Q4)</td>
			<?php
			$arrSeasonMonth = array();
			$arrHYearMonth = array();
			if ($qdate2!="%") { $arrDate = explode("/",$qdate2); } else { $arrDate[0]=date(Y); $arrDate[1]=date(m); }
			$arrSeasonMonth[0] = array($arrDate[0].'01', $arrDate[0].'03');
			$arrSeasonMonth[1] = array($arrDate[0].'04', $arrDate[0].'06');
			$arrSeasonMonth[2] = array($arrDate[0].'07', $arrDate[0].'09');
			$arrSeasonMonth[3] = array($arrDate[0].'10', $arrDate[0].'12');
			$arrHYearMonth[0] = array($arrDate[0].'01', $arrDate[0].'06');
			$arrHYearMonth[1] = array($arrDate[0].'07', $arrDate[0].'12');
			?>
		</tr>
		<?php
		$arrQTab1 = array('varA'=>'Montly new admission number (A)', 'varB'=>'Acute hospitalized whithin<br>72 hours since admission number(B)', 'varBP'=>'Acute hospitalized whithin<br>72 hours since admission ratio(B/A)', 'varC'=>'Monthly total residents(C)', 'varD'=>'Monthly unplanned <br>acute hospitalized resident (D)', 'varDP'=>'Monthly unplanned <br>acute hospitalized resident ratio (D/C)', 'varD1'=>'Unplanned acute hospitalized<br> resident due to cardiovascular <br>hypofunction (D1)', 'varD1P'=>'Unplanned acute hospitalized<br> resident due to cardiovascular <br>hypofunction ratio (D1/D)', 'varD2'=>'Unplanned acute hospitalized<br> resident due to treatment or <br>assessment of fracture (D2)', 'varD2P'=>'Unplanned acute hospitalized<br> resident due to treatment or <br>assessment of fracture ratio (D2/D)', 'varD3'=>'Unplanned acute hospitalized <br>resident due to gastrointestinal bleeding (D3)', 'varD3P'=>'Unplanned acute hospitalized <br>resident due to gastrointestinal bleeding ratio (D3/D)', 'varD4'=>'Unplanned acute hospitalized <br>resident due to infection (D4)', 'varD4P'=>'Unplanned acute hospitalized <br>resident due to infection ratio (D4/D)', 'varD5'=>'Unplanned acute hospitalized <br>resident due other medical and <br>surgical reasons (D5)', 'varD5P'=>'Unplanned acute hospitalized <br>resident due other medical and <br>surgical reasons ratio (D5/D)');
		foreach ($arrQTab1 as $ktab1 => $vtab1) {
			?>
			<tr>
				<td class="title_s" style="font-size:9pt;"><?php echo $vtab1; ?></td>
				<?php
				foreach ($arrSeasonMonth as $k1=>$v1) {
					$db3_1 = new DB;
					$db3_1->query("SELECT `month`, `".str_replace("P","",$ktab1)."` AS '".str_replace("P","",$ktab1)."' FROM `sixtarget_part1_stat` WHERE `month`>='".$v1[0]."' AND `month`<='".$v1[1]."' ORDER BY `month` ASC");
					if ($db3_1->num_rows()==0) {
						echo '<td align="center"><center>---</center></td>';
					} else {
						for ($i3_1=0;$i3_1<$db3_1->num_rows();$i3_1++) {
							$r3_1 = $db3_1->fetch_assoc();
							${'arrPart1Tab3Tmp_'.$ktab1}[$k1][$i3_1] += $r3_1[str_replace("P","",$ktab1)];
						}
						if (substr($ktab1,strlen($ktab1)-1,1)=="P") {
							if ($ktab1=="varBP") {
								if (array_sum($arrPart1Tab3Tmp_varA[$k1])==0) {
									$statVarBP = 0;
								} else {
									$statVarBP = round(((array_sum($arrPart1Tab3Tmp_varB[$k1])/3)/(array_sum($arrPart1Tab3Tmp_varA[$k1])/3))*100,2);
								}
								echo '<td align="center"><center>'.$statVarBP.' %</center></td>';
							} elseif ($ktab1=="varDP") {
								if (array_sum($arrPart1Tab3Tmp_varC[$k1])==0) {
									$statVarDP = 0;
								} else {
									$statVarDP = round(((array_sum($arrPart1Tab3Tmp_varD[$k1])/3)/(array_sum($arrPart1Tab3Tmp_varC[$k1])/3))*100,2);
								}
								echo '<td align="center"><center>'.$statVarDP.' %</center></td>';
							} elseif ($ktab1=="varD1P" || $ktab1=="varD2P" || $ktab1=="varD3P" || $ktab1=="varD4P" || $ktab1=="varD5P") {
								if (array_sum($arrPart1Tab3Tmp_varD[$k1])==0) {
									${'statVar'.$ktab1} = 0;
								} else {
									${'statVar'.$ktab1} = round(((array_sum(${'arrPart1Tab3Tmp_'.str_replace("P", "", $ktab1)}[$k1])/3)/(array_sum($arrPart1Tab3Tmp_varD[$k1])/3))*100,2);
								}
								echo '<td align="center"><center>'.${'statVar'.$ktab1}.' %</center></td>';
							}
						} else {
							if ($db3_1->num_rows()==0) {
								$arraysum = 0;
								$numrows = 1;
							} else {
								$arraysum = array_sum(${'arrPart1Tab3Tmp_'.$ktab1}[$k1]);
								$numrows = 3;
							}
							echo '<td align="center"><center>'.round(($arraysum/$numrows),2).'</center></td>';
						}
					}
				}
				?>
			</tr>
			<?php
		}
		?>
	</table>
</div>
</center>
<!--住院年度分析-->
<center>
<div id="tab1_part4" style="display:none;">
	<table class="content-query" style="font-size:10pt;page-break-after:always;">
		<tr class="title">
			<td width="22%">&nbsp;</td>
			<?php
			$arrPast12Months = array();
			if ($qdate2!="%") { $arrDate = explode("/",$qdate2); } else { $arrDate[0]=date(Y); $arrDate[1]=date(m); }
			for ($i3=1;$i3<=12;$i3++) {
          //$month_i3 = $arrDate[1] - $i3;
          //if ($month_i3<1) { $year_i3 = $arrDate[0]-1;  $month_i3+=12; } else { $year_i3 = $arrDate[0]; }
          //$date_i3 = $year_i3.'/'.$month_i3;
          //$arrPast12Months[(12-$i3)] = $date_i3;
				$date_i3 = $arrDate[0].'/'.$i3;
				$arrPast12Months[$i3] = $date_i3;
			}
			ksort($arrPast12Months);
			foreach ($arrPast12Months as $k1=>$v1) {
				echo '<td width="6.5%">'.str_replace("/","<br>",$v1).'</td>';
			}
			?>
		</tr>
		<?php
		foreach ($arrQTab1 as $ktab1 => $vtab1) {
			?>
			<tr>
				<td class="title_s" style="font-size:9pt;"><?php echo $vtab1; ?></td>
				<?php
	  //print_r($arrPast12Months);
				foreach ($arrPast12Months as $k1=>$v1) {
					$arrDateTab1Q = explode("/",$v1);
					if (strlen($arrDateTab1Q[1])==1) { $monthofq31 = '0'.$arrDateTab1Q[1]; } else { $monthofq31 = $arrDateTab1Q[1]; }
					$second1970 = mktime(0,0,0,$arrDateTab1Q[1],1,$arrDateTab1Q[0]);
					$second1970ms = number_format(($second1970 * 1000), 0, '.', '');
					$db3_1 = new DB;
					$db3_1->query("SELECT `".str_replace("P","",$ktab1)."` FROM `sixtarget_part1_stat` WHERE `month`='".$arrDateTab1Q[0].$monthofq31."'");
					if ($db3_1->num_rows()==0) {
						if (${$ktab1.'_per'}!="") { ${$ktab1.'_per'} .= ', '; }
						${$ktab1.'_per'} .= '["'.$second1970ms.'",0]';
						${$ktab1} .= '["'.$second1970ms.'",0]';
						echo '<td align="center"><center>---</center></td>';
					} else {
						$r3_1 = $db3_1->fetch_assoc();
						if ($r3_1['varA']!='') { ${'totalpatientstat1A_'.$arrDateTab1Q[0].$monthofq31} = $r3_1['varA']; }
						if ($r3_1['varC']!='') { ${'totalpatientstat1_'.$arrDateTab1Q[0].$monthofq31} = $r3_1['varC']; }
						if ($r3_1['varD']!='') { ${'totalpatientstat1D_'.$arrDateTab1Q[0].$monthofq31} = $r3_1['varD']; }
						if ($r3_1[str_replace("P","",$ktab1)]=="") {
							echo '<td align="center"><center>---</center></td>';
						} else {
							echo '<td align="center"><center>';
							if ($ktab1=="varA") {
								echo $r3_1[$ktab1];
							} elseif ($ktab1=="varB") {
								echo $r3_1[$ktab1];
								if (${$ktab1.'_per'}!="") { ${$ktab1.'_per'} .= ', '; }
								if (${'totalpatientstat1A_'.$arrDateTab1Q[0].$monthofq31}>0) {
									${$ktab1.'_per'} .= '["'.$second1970ms.'",'.round(($r3_1[$ktab1]/${'totalpatientstat1A_'.$arrDateTab1Q[0].$monthofq31})*100,1).']';
								} else {
									${$ktab1.'_per'} .= '["'.$second1970ms.'",0]';
								}
							} elseif ($ktab1=="varBP") {
								if (${'totalpatientstat1A_'.$arrDateTab1Q[0].$monthofq31}>0) {
									echo round(($r3_1[str_replace("P","",$ktab1)]/${'totalpatientstat1A_'.$arrDateTab1Q[0].$monthofq31})*100,1)." %";
								} else { echo "0 %"; }
							} elseif ($ktab1=="varD") {
								echo $r3_1[$ktab1];
							} elseif ($ktab1=="varDP") {
								if (${$ktab1.'_per'}!="") { ${$ktab1.'_per'} .= ', '; }
								if (${'totalpatientstat1_'.$arrDateTab1Q[0].$monthofq31}>0) {
									echo round(($r3_1[str_replace("P","",$ktab1)]/${'totalpatientstat1_'.$arrDateTab1Q[0].$monthofq31})*100,1)." %";
									${$ktab1.'_per'} .= '["'.$second1970ms.'",'.round(($r3_1[str_replace("P","",$ktab1)]/${'totalpatientstat1_'.$arrDateTab1Q[0].$monthofq31})*100,1).']';
								} else {
									echo "0 %";
									${$ktab1.'_per'} .= '["'.$second1970ms.'",0]';
								}
							} elseif ($ktab1=="varD1" || $ktab1=="varD2" || $ktab1=="varD3" || $ktab1=="varD4" || $ktab1=="varD5") {
								if (${$ktab1.'_per'}!="") { ${$ktab1.'_per'} .= ', '; }
								if (${'totalpatientstat1D_'.$arrDateTab1Q[0].$monthofq31}>0) {
									${$ktab1.'_per'} .= '["'.$second1970ms.'",'.round(($r3_1[$ktab1]/${'totalpatientstat1D_'.$arrDateTab1Q[0].$monthofq31})*100,1).']';
								} else {
									${$ktab1.'_per'} .= '["'.$second1970ms.'",0]';
								}
								echo $r3_1[$ktab1];
							}  elseif ($ktab1=="varD1P" || $ktab1=="varD2P" || $ktab1=="varD3P" || $ktab1=="varD4P" || $ktab1=="varD5P") {
								if (${'totalpatientstat1D_'.$arrDateTab1Q[0].$monthofq31}>0) {
									echo round(($r3_1[str_replace("P","",$ktab1)]/${'totalpatientstat1D_'.$arrDateTab1Q[0].$monthofq31})*100,1).' %';
								} else {
									echo '0 %';
								}
							} else {
								echo $r3_1[$ktab1];
							}
							echo '</center></td>';
						}
						if ($r3_1[$ktab1]=="") { ${$ktab1} .= '["'.$second1970ms.'",0]'; } else { ${$ktab1} .= '["'.$second1970ms.'",'.$r3_1[$ktab1].']'; }
					}
					if (${$ktab1}!="") { ${$ktab1} .= ', '; }
				}
				?>
			</tr>
			<?php
		}
		?>
	</table><br><br>
	<style>
	.tickLabel {
		display:table-cell !important;
		word-break:keep-all !important;
		width:40px !important;
	}
	#chart1 table {
		width: auto;
		left:780px;
		position:relative;
	}
	#chart1 table tr {
		background:none;
		height:auto;
		padding:0px;
		margin:0px;
	}
	#chart1 table tr td { border:none; font-size:10pt; padding: 4px 0px; }
	#chart1b table {
		width: auto;
		left:780px;
		position:relative;
	}
	#chart1b table tr {
		background:none;
		height:auto;
		padding:0px;
		margin:0px;
	}
	#chart1b table tr td { border:none; font-size:10pt; padding: 4px 0px; }
	#chart1c table {
		width: auto;
		left:780px;
		position:relative;
	}
	#chart1c table tr {
		background:none;
		height:auto;
		padding:0px;
		margin:0px;
	}
	#chart1c table tr td { border:none; font-size:10pt; padding: 4px 0px; }
	#chart1 .legend table {
		top: -60px !important;
	}
	</style>
	<h3><?php echo $arrDate[0]; ?> Annual unplanned acute hospitalized whithin 72 hours since admission ratio</h3>
	<div id="chart1b" style="width:740px;height:420px; margin-left:30px; padding-top:50px; margin-top:50px; padding-bottom:50px; margin-bottom:50px; page-break-after:always;"></div><br /><br />
	<h3><?php echo $arrDate[0]; ?> Annual unplanned acute hospitalized resident ratio</h3>
	<div id="chart1c" style="width:740px;height:420px; margin-left:40px; padding-top:50px; margin-top:50px; padding-bottom:50px; margin-bottom:50px; page-break-after:always;"></div><br /><br />
	<h3><?php echo $arrDate[0]; ?> Annual hospitalized cause and ratio analysis</h3>
	<div id="chart1" style="width:740px;height:420px; margin-left:30px; padding-top:50px; margin-top:50px; padding-bottom:50px; margin-bottom:50px;"></div><br /><br />
	<script type="text/javascript">
	$(function () {
		$.plot($("#chart1"), [
			{ label: "Unplanned acute hospitalized resident<br> due to cardiovascular hypofunction(D1)",  data: [<?php echo $varD1; ?>], bars: {fillColor: "#edc240"}, color: "#edc240" },
			{ label: "Unplanned acute hospitalized resident<br> due to treatment or assessment of fracture(D2)",  data: [<?php echo $varD2; ?>], bars: {fillColor: "#afd8f8"}, color: "#afd8f8" },
			{ label: "Unplanned acute hospitalized resident<br> due to gastrointestinal bleeding(D3)",  data: [<?php echo $varD3; ?>], bars: {fillColor: "#cb4b16"}, color: "#cb4b16" },
			{ label: "Unplanned acute hospitalized resident<br> due to infection(D4)",  data: [<?php echo $varD4; ?>], bars: {fillColor: "#99EC41" }, color: "#99EC41" },
			{ label: "Unplanned acute hospitalized resident<br> due other medical and surgical reasons(D5)",  data: [<?php echo $varD5; ?>], bars: {fillColor: "#9440ed"}, color: "#9440ed" },
			{ label: "Unplanned acute hospitalized resident<br> due to cardiovascular hypofunction ratio(D1/D)",  data: [<?php echo $varD1_per; ?>], lines: {show: true}, points: { show: true, symbol:"cross" }, bars: {show: false}, yaxis:2 },
			{ label: "Unplanned acute hospitalized resident<br> due to treatment or assessment of fracture ratio(D2/D)",  data: [<?php echo $varD2_per; ?>], lines: {show: true}, points: { show: true, symbol:"circle" }, bars: {show: false}, yaxis:2 },
			{ label: "Unplanned acute hospitalized resident<br> due to gastrointestinal bleeding ratio(D3/D)",  data: [<?php echo $varD3_per; ?>], lines: {show: true}, points: { show: true, symbol:"square" }, bars: {show: false}, yaxis:2 },
			{ label: "Unplanned acute hospitalized resident<br> due to infection ratio(D4/D)",  data: [<?php echo $varD4_per; ?>], lines: {show: true}, points: { show: true, symbol:"diamond" }, bars: {show: false}, yaxis:2 },
			{ label: "Unplanned acute hospitalized resident<br> due other medical and surgical reasons ratio(D5/D)",  data: [<?php echo $varD5_per; ?>], lines: {show: true}, points: { show: true, symbol:"triangle" }, bars: {show: false}, yaxis:2 }
			],
			{
				xaxis: { label: " month", mode: "time", timeformat: "%y<br>%b", monthNames: [<?php for ($imonth=1;$imonth<=12;$imonth++) { if ($imonth>1) { echo ', '; } echo "'".$imonth."'"; } ?>], tickLength: 0, axisLabelUseCanvas: true, axisLabelFontSizePixels: 12, axisLabelFontFamily: "Verdana, Arial, Helvetica, Tahoma, sans-serif", axisLabelPadding: 5 },
				yaxes: [
				{tickSize: 1, tickDecimals: 0, position: 'left'},
				{tickSize: 10, tickDecimals: 1, min:0, position: 'right'}
				],
				grid: { hoverable: true, clickable: false, borderWidth: 1 },
				series: { shadowSize: 0, bars: { show: true, barWidth: 12*24*60*60*300, order: 1 } }
			});
var yaxisLabel = $("<div class='axisLabel yaxisLabel' style='position: absolute; left: -28px; top: -30px;'></div>").text("People").appendTo($('#chart1'));
var yaxisLabel2 = $("<div class='axisLabel yaxisLabel' style='width:50px; position: absolute; left: 740px; top: -30px;'></div>").text("Rate").appendTo($('#chart1'));
var xaxisLabel = $("<div class='axisLabel xaxisLabel' style='position: absolute; left:400px; bottom: -50px;'></div>").text(" month").appendTo($('#chart1'));
});
$(function () {
	$.plot($("#chart1b"), [
		{ label: "Montly new admission number(A)",  data: [<?php echo $varA; ?>], bars: {fillColor: "#9440ed"}, color: "#9440ed" },
		{ label: "Acute hospitalized whithin 72 hours since admission number(B)",  data: [<?php echo $varB; ?>], bars: {fillColor: "#afd8f8"}, color: "#afd8f8" },
		{ label: "Acute hospitalized whithin 72 hours since admission number ratio(B/A)",  data: [<?php echo $varB_per; ?>], lines: {show: true}, points: { show: true, symbol:"cross" }, bars: {show: false}, yaxis:2 }
		],
		{
			xaxis: { label: " month", mode: "time", timeformat: "%y<br>%b", monthNames: [<?php for ($imonth=1;$imonth<=12;$imonth++) { if ($imonth>1) { echo ', '; } echo "'".$imonth."'"; } ?>], tickLength: 0, axisLabelUseCanvas: true, axisLabelFontSizePixels: 12, axisLabelFontFamily: "Verdana, Arial, Helvetica, Tahoma, sans-serif", axisLabelPadding: 5 },
			yaxes: [
			{tickSize: 1, tickDecimals: 0, position: 'left'},
			{tickSize: 5, tickDecimals: 1, min:0, position: 'right'}
			],
			grid: { hoverable: true, clickable: false, borderWidth: 1 },
			series: { shadowSize: 0, bars: { show: true, barWidth: 12*24*60*60*300, order: 1 } }
		});
var yaxisLabel = $("<div class='axisLabel yaxisLabel' style='position: absolute; left: -28px; top: -30px;'></div>").text("incidents").appendTo($('#chart1b'));
var yaxisLabel2 = $("<div class='axisLabel yaxisLabel' style='width:50px; position: absolute; left: 740px; top: -30px;'></div>").text("Rate").appendTo($('#chart1b'));
var xaxisLabel = $("<div class='axisLabel xaxisLabel' style='position: absolute; left:400px; bottom: -50px;'></div>").text(" month").appendTo($('#chart1b'));
});
$(function () {
	$.plot($("#chart1c"), [
		{ label: "Monthly total residents(C)",  data: [<?php echo $varC; ?>], bars: {fillColor: "#9440ed"}, color: "#9440ed" },
		{ label: "Monthly unplanned acute hospitalized resident(D)",  data: [<?php echo $varD; ?>], bars: {fillColor: "#afd8f8"}, color: "#afd8f8" },
		{ label: "Monthly unplanned acute hospitalized resident ratio(D/C)",  data: [<?php echo $varDP_per; ?>], lines: {show: true}, points: { show: true, symbol:"cross" }, bars: {show: false}, yaxis:2 }
		],
		{
			xaxis: { label: " month", mode: "time", timeformat: "%y<br>%b", monthNames: [<?php for ($imonth=1;$imonth<=12;$imonth++) { if ($imonth>1) { echo ', '; } echo "'".$imonth."'"; } ?>], tickLength: 0, axisLabelUseCanvas: true, axisLabelFontSizePixels: 12, axisLabelFontFamily: "Verdana, Arial, Helvetica, Tahoma, sans-serif", axisLabelPadding: 5 },
			yaxes: [
			{tickSize: 10, tickDecimals: 0, position: 'left'},
			{tickSize: 2, tickDecimals: 1, min:0, position: 'right'}
			],
			grid: { hoverable: true, clickable: false, borderWidth: 1 },
			series: { shadowSize: 0, bars: { show: true, barWidth: 12*24*60*60*300, order: 1 } }
		});
var yaxisLabel = $("<div class='axisLabel yaxisLabel' style='position: absolute; left: -28px; top: -30px;'></div>").text("incidents").appendTo($('#chart1c'));
var yaxisLabel2 = $("<div class='axisLabel yaxisLabel' style='width:50px; position: absolute; left: 740px; top: -30px;'></div>").text("Rate").appendTo($('#chart1c'));
var xaxisLabel = $("<div class='axisLabel xaxisLabel' style='position: absolute; left:400px; bottom: -50px;'></div>").text(" month").appendTo($('#chart1c'));
});
</script>
</div>
</div>
</center>
<!--約束-->
<center>
<div id="tab2" style="font-size:11pt;">
	<h3>Restraint Indicator report</h3>
	<div style="margin-bottom:10px;">
		<?php echo draw_option("tab2option","Current month record;Current month statistic;3 months(seasonal) analysis;Annual analysis","xl","single",1,false,5); ?>
	</div>
	<div>	
			<button type="button" id="newrecord2" title="Add restraint record" onclick="openVerificationForm('#dialog-form2');"><i class="fa fa-user-plus fa-2x fa-fw"></i><br>Add new data</button>
			<div class="patlistbtn" style="background-color:rgb(149,219,208); width:100px;"><a href="index.php?mod=management&func=formview&id=3d_1&type=2<?php echo $sMonth;?>" title="逐案分析列表"><i class="fa fa-list fa-2x fa-fw"></i><br>Case-by-case analysis</a></div>
			<div class="patlistbtn" style="background-color:rgb(149,219,208);"><a href="#" onclick="printDialog('2', '<?php echo $_GET['qdate']; ?>');" title="Print report"><i class="fa fa-print fa-2x fa-fw"></i><br>Print report</a></div>
	</div>

	<script>
	$(function() {
		$( "#dialog-form2" ).dialog({
			autoOpen: false,
			height: 640,
			width: 900,
			modal: true,
			buttons: {
				"Add record": function() {
					if ($("#HospNo_tab2").val()=="" || $("#BedID_tab2").val()=="" || $("#Name_tab2").val()=="") {
						alert("Please fully fill the resident info");
						$("#HospNo_tab2").focus();
					} else {
						$.ajax({
							url: "class/sixtarget_part2.php",
							type: "POST",
							data: {'HospNo': $('#HospNo_tab2').val(), 'Name': $('#Name_tab2').val(), 'startdate': $('#part2_startdate').val(),
							'reason1': $('#part2_reason_1').val(), 
							'reason2': $('#part2_reason_2').val(), 
							'reason3': $('#part2_reason_3').val(), 
							'reason4': $('#part2_reason_4').val(), 
							'reason5': $('#part2_reason_5').val(), 
							'reason6': $('#part2_reason_6').val(), 
							'reasonother': $('#part2_reasonother').val(), 
							'equipment1': $('#part2_equipment_1').val(), 
							'equipment2': $('#part2_equipment_2').val(), 
							'equipment3': $('#part2_equipment_3').val(), 
							'equipment4': $('#part2_equipment_4').val(), 
							'equipment5': $('#part2_equipment_5').val(), 
							'equipment6': $('#part2_equipment_6').val(), 
							'equipmentother': $('#part2_equipmentother').val(), 
							'bodypart1': $('#part2_bodypart_1').val(), 
							'bodypart2': $('#part2_bodypart_2').val(), 
							'bodypart3': $('#part2_bodypart_3').val(), 
							'bodypart4': $('#part2_bodypart_4').val(), 
							'bodypart5': $('#part2_bodypart_5').val(), 
							'bodypart6': $('#part2_bodypart_6').val(), 
							'bodypartother': $('#part2_bodypartother').val(), 
							'releasedate': $('#part2_releasedate').val(), 
							'releasereason1': $('#part2_releasereason_1').val(), 
							'releasereason2': $('#part2_releasereason_2').val(), 
							'releasereason3': $('#part2_releasereason_3').val(), 
							'releasereason4': $('#part2_releasereason_4').val(), 
							'releasereason5': $('#part2_releasereason_5').val(), 
							'releasereasonother': $('#part2_releasereasonother').val(), 
							'Qfiller': $('#Qfiller').val() },
							success: function(data) {
								$( "#dialog-form2" ).dialog( "close" );
								alert("Add record sucessfully!");
								window.location.reload();
							}
						});
}
},
"Cancel": function() {
	$( "#dialog-form2" ).dialog( "close" );
}
}
});
});
</script>
<div id="dialog-form2" title="Add restraint record" class="dialog-form"> 
	<form id="form2">
		<fieldset>
			<table>
				<tr>
					<td class="title">Search</td>
					<td colspan="3">
						&nbsp;<span style="padding:3px; border:1px solid #999; color:#666; font-size:10pt;">Care ID#</span> <input type="text" name="HospNo" id="HospNo_tab2" value="" size="8">&nbsp;
						<span style="padding:3px; background:#69b3b6; color:#fff; font-size:10pt;">or</span>&nbsp;
						<span style="padding:3px; border:1px solid #999; color:#666; font-size:10pt;">Bed #</span> <input type="text" name="BedID" id="BedID_tab2" size="8">&nbsp;
						<span style="padding:3px; border:1px solid #999; color:#666; font-size:10pt;">Full name</span> <input type="text" name="Name" id="Name_tab2" size="8" readonly="readonly">&nbsp;
						<input type="button" value="Search" id="search_tab2" onclick="loadPatInfo('tab2')" />
						<input type="button" value="Empty" id="clear_tab2" onclick="cleartab('2')" style="display:none;" /></td>
					</tr>
					<tr>
						<td class="title">Restraint date</td>
						<td><script> $(function() { $( "#part2_startdate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="part2_startdate" id="part2_startdate" value="<?php echo date(Y."/".m."/".d); ?>"></td>
					</tr>
					<tr>
						<td class="title">Restraint reason</td>
						<td><?php echo draw_option("part2_reason","Fall prevent;Pipeline Protect;Self-injury prevent;Behavioral disorders;Assist treatment;Other","l","single",$part2_reason,true,3); ?> <input type="text" name="part2_reasonother" id="part2_reasonother" size="15"></td>
					</tr>
					<tr>
						<td class="title">Restraint equipment</td>
						<td><?php echo draw_option("part2_equipment","Restraint strap;T-shape restraint strap;Magnetic clasp(s);Glove(s);Special dinner plate(s);Other","xl","multi",$part2_equipment,true,3); ?> <input type="text" name="part2_equipmentother" id="part2_equipmentother" size="15"></td>
					</tr>
					<tr>
						<td class="title">Restraint part(s)</td>
						<td><?php echo draw_option("part2_bodypart","Waist;Ankle(s);Wrist(s);Knee(s);Torso;Other","m","multi",$part2_bodypart,false,3); ?> <input type="text" name="part2_bodypartother" id="part2_bodypartother" size="15"></td>
					</tr>
					<tr>
						<td class="title">Relieve date</td>
						<td><script> $(function() { $( "#part2_releasedate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="part2_releasedate" id="part2_releasedate" value=""></td>
					</tr>
					<tr>
						<td class="title">Relieve reason</td>
						<td><?php echo draw_option("part2_releasereason","Cognitive Improvement;Emotion stabilized;Deterioration;Death;Other","xl","single",$part2_releasereason,true,3); ?> <input type="text" name="part2_releasereasonother" id="part2_releasereasonother" size="15"></td>
					</tr>
					<input type="hidden" name="Qfiller" id="Qfiller" value="<?php echo $_SESSION['ncareID_lwj']; ?>">
				</table>
			</fieldset>
		</form>
	</div>
	<script>
	$('#btn_tab2option_1').click(function() {
		$('#tab2_part1').show();
		$('#tab2_part2').hide();
		$('#tab2_part3').hide();
		$('#tab2_part4').hide();
	});
	$('#btn_tab2option_2').click(function() {
		$('#tab2_part1').hide();
		$('#tab2_part2').show();
		$('#tab2_part3').hide();
		$('#tab2_part4').hide();
	});
	$('#btn_tab2option_3').click(function() {
		$('#tab2_part1').hide();
		$('#tab2_part2').hide();
		$('#tab2_part3').show();
		$('#tab2_part4').hide();
	});
	$('#btn_tab2option_4').click(function() {
		$('#tab2_part1').hide();
		$('#tab2_part2').hide();
		$('#tab2_part3').hide();
		$('#tab2_part4').show();
	});
	$(function() { $('#tform2').validationEngine(); });
	</script>
	<!--約束資料列表-->
	<div id="tab2_part1">
		<form id="tform2" action="index.php?mod=management&func=formview&id=3d_2&type=2<?php echo $sMonth; ?>" method="post">
			<table class="content-query" style="font-size:10pt; font-weight:normal;">
				<tr class="title">
					<td class="printcol">View</td>
					<td align="center">Care ID#</td>
					<td align="center">Full name</td>
					<td align="center">Restraint date</td>
					<td align="center">Restraint reason</td>
					<td align="center">Restraint equipment</td>
					<td align="center">Restraint part(s)</td>
					<td align="center">Relieve date</td>
					<td align="center">Relieve reason</td>
					<td class="printcol">Case-by-case analysis</td>
					<td class="printcol">Delete</td>
				</tr>
				<?php
				$dbp1_2 = new DB;
				$dbp1_2->query("SELECT * FROM  `sixtarget_part2` WHERE `startdate` LIKE '".$qdate2."%' OR (`releasedate`='' OR `releasedate`='____/__/__') ORDER BY `HospNo` ASC");
				if ($dbp1_2->num_rows()==0) {
					?>
					<tr>
						<td colspan="11"><center>-------Yet no data of this month-------</center></td>
					</tr>
					<script>$(function() { $('#analysis2').hide(); });</script>
					<?php
				} else {
					for ($p1_i1=0;$p1_i1<$dbp1_2->num_rows();$p1_i1++) {
						$rp1_2 =$dbp1_2->fetch_assoc();
						/*== 解 START ==*/
						$rsa = new lwj('lwj/lwj');
						$puepart = explode(" ",$rp1_2['Name']);
						$puepartcount = count($puepart);
						if($puepartcount>1){
							for($j=0;$j<$puepartcount;$j++){
								$prdpart = $rsa->privDecrypt($puepart[$j]);
								$rp1_2['Name'] = $rp1_2['Name'].$prdpart;
							}
						}else{
							$rp1_2['Name'] = $rsa->privDecrypt($rp1_2['Name']);
						}
						/*== 解 END ==*/
						$reason = '';
						if ($rp1_2['reason1']==1) { $reason .= 'Fall prevent'; }
						if ($rp1_2['reason2']==1) { if ($reason!='') { $reason.='、'; } $reason .= 'Pipeline Protect'; }
						if ($rp1_2['reason3']==1) { if ($reason!='') { $reason.='、'; } $reason .= 'Self-injury prevent'; }
						if ($rp1_2['reason4']==1) { if ($reason!='') { $reason.='、'; } $reason .= 'Behavioral disorders'; }
						if ($rp1_2['reason5']==1) { if ($reason!='') { $reason.='、'; } $reason .= 'Assist treatment'; }
						if ($rp1_2['reason6']==1) { if ($reason!='') { $reason.='、'; } $reason .= 'Other(s):'.$rp1_2['reasonother']; }
						$equipment = '';
						if ($rp1_2['equipment1']==1) { $equipment .= 'Restraint strap'; }
						if ($rp1_2['equipment2']==1) { if ($equipment!='') { $equipment.='、'; } $equipment .= 'T-shape restraint strap'; }
						if ($rp1_2['equipment3']==1) { if ($equipment!='') { $equipment.='、'; } $equipment .= 'Magnetic clasp(s)'; }
						if ($rp1_2['equipment4']==1) { if ($equipment!='') { $equipment.='、'; } $equipment .= 'Glove(s)'; }
						if ($rp1_2['equipment5']==1) { if ($equipment!='') { $equipment.='、'; } $equipment .= 'Special dinner plate(s)'; }
						if ($rp1_2['equipment6']==1) { if ($equipment!='') { $equipment.='、'; } $equipment .= 'Other(s):'.$rp1_2['equipmentother']; }
						$bodypart = '';
						if ($rp1_2['bodypart1']==1) { $bodypart .= 'Waist'; }
						if ($rp1_2['bodypart2']==1) { if ($bodypart!='') { $bodypart.='、'; } $bodypart .= 'Ankle(s)'; }
						if ($rp1_2['bodypart3']==1) { if ($bodypart!='') { $bodypart.='、'; } $bodypart .= 'Wrist(s)'; }
						if ($rp1_2['bodypart4']==1) { if ($bodypart!='') { $bodypart.='、'; } $bodypart .= 'Knee(s)'; }
						if ($rp1_2['bodypart5']==1) { if ($bodypart!='') { $bodypart.='、'; } $bodypart .= 'Torso'; }
						if ($rp1_2['bodypart6']==1) { if ($bodypart!='') { $bodypart.='、'; } $bodypart .= 'Other(s):'.$rp1_2['bodypartother']; }
						if ($rp1_2['releasedate']=='') { $releasedate = '---'; } else { $releasedate = $rp1_2['releasedate']; }
						$releasereason = '';
						if ($rp1_2['releasereason1']==1) { $releasereason .= 'Cognitive Improvement'; }
						if ($rp1_2['releasereason2']==1) { if ($releasereason!='') { $releasereason.='、'; } $releasereason .= 'Emotion stabilized'; }
						if ($rp1_2['releasereason3']==1) { if ($releasereason!='') { $releasereason.='、'; } $releasereason .= 'Deterioration'; }
						if ($rp1_2['releasereason4']==1) { if ($releasereason!='') { $releasereason.='、'; } $releasereason .= 'Death'; }
						if ($rp1_2['releasereason5']==1) { if ($releasereason!='') { $releasereason.='、'; } $releasereason .= 'Other(s):'.$rp1_2['releasereasonother']; }
						$pid = getPID($rp1_2['HospNo']);
						?>
						<tr>
							<td class="printcol"><center><a href="index.php?mod=management&func=formview&id=3b_2&pid=<?php echo $pid; ?>&view=2&tID=<?php echo $rp1_2['targetID'].$sMonth; ?>"><img src="Images/folder.png" width="24" /></a></center></td>
							<td align="center"><?php echo getHospNoDisplayByPID($pid); ?></td>
							<td align="center"><?php echo $rp1_2['Name']; ?></td>
							<td align="center"><?php echo $rp1_2['startdate']; ?></td>
							<td align="center"><?php echo $reason; ?></td>
							<td align="center"><?php echo $equipment; ?></td>
							<td align="center"><?php echo $bodypart; ?></td>
							<td align="center"><?php echo $rp1_2['releasedate']; ?></td>
							<td align="center"><?php echo $releasereason; ?></td>
							<td class="printcol"><center><input type="checkbox" name="targetList_2[]" id="targetList_2_<?php echo $rp1_2['targetID']; ?>" class="validate[required]" value="<?php echo $rp1_2['targetID']; ?>"></center></td>
							<?php
							if ($_SESSION['ncareLevel_lwj']>=4 || $rp1_2['Qfiller']==$_SESSION['ncareID_lwj']) {
								echo '<td class="printcol"><a href="index.php?mod=management&func=formview&id=3c_2&tID='.$rp1_2['targetID'].'"><img src="Images/delete2.png" width="20"></a></td>';
							}
							?>
						</tr>
						<?php
					}
				}
				?>
			</table>
			<center><input type="submit" id="analysis2" value="Start case-by-case analysis" class="printcol"></center>
		</form>
	</div>
	<!--約束當月統計-->
	<div id="tab2_part2" style="display:none;">
		<form action="index.php?func=save_sixtarget_stat" method="post" id="stat2">
			<table class="content-query">
				<tr class="title">
					<td align="center">Indicator item</td>
					<td align="center">Number</td>
					<td align="center">Formula</td>
					<td align="center">Rate(%)</td>
				</tr>
				<tr>
					<td class="title_s" style="text-align:left;">Monthly total resident days(A)</td>
					<td align="center">
						<?php
						$db_b_0 = new DB;
						$db_b_0->query("SELECT * FROM `sixtarget_part2_stat` WHERE `month`='".$qdate."'");
						$r_b_0 = $db_b_0->fetch_assoc();
						$db_b_1 = new DB;
						$db_b_1->query("SELECT SUM(`no`) FROM `dailypatientno` WHERE `date` LIKE '".str_replace("/","-",$qdate2)."%'");
						$r_b_1 = $db_b_1->fetch_assoc();
						if ($r_b_0['varA']=="") { $tmp_stat2_varA = $r_b_1['SUM(`no`)']; } else { $tmp_stat2_varA = $r_b_0['varA']; }
						?>
						<input type="text" name="sixtarget_stat2_varA" size="4" value="<?php echo $tmp_stat2_varA; ?>" />
					</td>
					<td align="center">---</td>
					<td align="center">---</td>
				</tr>
				<tr>
					<td class="title_s" style="text-align:left;">Montly body retrained resident number(B)；Body restrain ratio</td>
					<td align="center">
						<?php
						$db_b_2 = new DB;
						$db_b_2->query("SELECT * FROM `sixtarget_part2` WHERE (`startdate` LIKE '".$qdate2."%' AND `releasedate` NOT LIKE '".$qdate2."%') OR (`startdate` NOT LIKE '".$qdate2."%' AND (`releasedate`='' OR `releasedate`='____/__/__'))");
						if ($r_b_0['varB']=="") { $tmp_stat2_varB = $db_b_2->num_rows(); } else { $tmp_stat2_varB = $r_b_0['varB']; }
						?>
						<input type="text" name="sixtarget_stat2_varB" size="4" value="<?php echo $tmp_stat2_varB; ?>" />
					</td>
					<td align="center">B/A</td>
					<td align="center"><?php if ($tmp_stat2_varA>0) { echo round(($tmp_stat2_varB/$tmp_stat2_varA)*100,1).' %'; } ?></td>
				</tr>
				<tr>
					<td class="title_s" style="text-align:left;">Resident restrain due to fall prevention number(C1)</td>
					<td align="center">
						<?php
						$db_b_3 = new DB;
						$db_b_3->query("SELECT * FROM `sixtarget_part2` WHERE `reason1`='1' AND ((`startdate` LIKE '".$qdate2."%' AND `releasedate` NOT LIKE '".$qdate2."%') OR (`startdate` NOT LIKE '".$qdate2."%' AND (`releasedate`='' OR `releasedate`='____/__/__')))");
						if ($r_b_0['varC1']=="") { $tmp_stat2_varC1 = $db_b_3->num_rows(); } else { $tmp_stat2_varC1 = $r_b_0['varC1']; }
						?>
						<input type="text" name="sixtarget_stat2_varC1" size="4" value="<?php echo $tmp_stat2_varC1; ?>" />
					</td>
					<td align="center">C1/B</td>
					<td align="center"><?php if ($tmp_stat2_varB>0) { echo round(($tmp_stat2_varC1/$tmp_stat2_varB)*100,1).' %'; } ?></td>
				</tr>
				<tr>
					<td class="title_s" style="text-align:left;">Resident restrain due to pipeline self extrication prevention number(C2)</td>
					<td align="center">
						<?php
						$db_b_4 = new DB;
						$db_b_4->query("SELECT * FROM `sixtarget_part2` WHERE `reason2`='1' AND ((`startdate` LIKE '".$qdate2."%' AND `releasedate` NOT LIKE '".$qdate2."%') OR (`startdate` NOT LIKE '".$qdate2."%' AND (`releasedate`='' OR `releasedate`='____/__/__')))");
						if ($r_b_0['varC2']=="") { $tmp_stat2_varC2 = $db_b_4->num_rows(); } else { $tmp_stat2_varC2 = $r_b_0['varC2']; }
						?>
						<input type="text" name="sixtarget_stat2_varC2" size="4" value="<?php echo $tmp_stat2_varC2; ?>" />
					</td>
					<td align="center">C2/B</td>
					<td align="center"><?php if ($tmp_stat2_varB>0) { echo round(($tmp_stat2_varC2/$tmp_stat2_varB)*100,1).' %'; } ?></td>
				</tr>
				<tr>
					<td class="title_s" style="text-align:left;">Resident restrain due to self harm prevention number(C3)</td>
					<td align="center">
						<?php
						$db_b_5 = new DB;
						$db_b_5->query("SELECT * FROM `sixtarget_part2` WHERE `reason3`='1' AND ((`startdate` LIKE '".$qdate2."%' AND `releasedate` NOT LIKE '".$qdate2."%') OR (`startdate` NOT LIKE '".$qdate2."%' AND (`releasedate`='' OR `releasedate`='____/__/__')))");
						if ($r_b_0['varC3']=="") { $tmp_stat2_varC3 = $db_b_5->num_rows(); } else { $tmp_stat2_varC3 = $r_b_0['varC3']; }
						?>
						<input type="text" name="sixtarget_stat2_varC3" size="4" value="<?php echo $tmp_stat2_varC3; ?>" />
					</td>
					<td align="center">C3/B</td>
					<td align="center"><?php if ($tmp_stat2_varB>0) { echo round(($tmp_stat2_varC3/$tmp_stat2_varB)*100,1).' %'; } ?></td>
				</tr>
				<tr>
					<td class="title_s" style="text-align:left;">Resident restrain due to behavioral disorders number(C4)</td>
					<td align="center">
						<?php
						$db_b_6 = new DB;
						$db_b_6->query("SELECT * FROM `sixtarget_part2` WHERE `reason4`='1' AND ((`startdate` LIKE '".$qdate2."%' AND `releasedate` NOT LIKE '".$qdate2."%') OR (`startdate` NOT LIKE '".$qdate2."%' AND (`releasedate`='' OR `releasedate`='____/__/__')))");
						if ($r_b_0['varC4']=="") { $tmp_stat2_varC4 = $db_b_6->num_rows(); } else { $tmp_stat2_varC4 = $r_b_0['varC4']; }
						?>
						<input type="text" name="sixtarget_stat2_varC4" size="4" value="<?php echo $tmp_stat2_varC4; ?>" />
					</td>
					<td align="center">C4/B</td>
					<td align="center"><?php if ($tmp_stat2_varB>0) { echo round(($tmp_stat2_varC4/$tmp_stat2_varB)*100,1).' %'; } ?></td>
				</tr>
				<tr>
					<td class="title_s" style="text-align:left;">Resident restrain due to assistance of the treatment(C5)</td>
					<td align="center">
						<?php
						$db_b_7 = new DB;
						$db_b_7->query("SELECT * FROM `sixtarget_part2` WHERE `reason5`='1' AND ((`startdate` LIKE '".$qdate2."%' AND `releasedate` NOT LIKE '".$qdate2."%') OR (`startdate` NOT LIKE '".$qdate2."%' AND (`releasedate`='' OR `releasedate`='____/__/__')))");
						if ($r_b_0['varC5']=="") { $tmp_stat2_varC5 = $db_b_7->num_rows(); } else { $tmp_stat2_varC5 = $r_b_0['varC5']; }
						?>
						<input type="text" name="sixtarget_stat2_varC5" size="4" value="<?php echo $tmp_stat2_varC5; ?>" />
					</td>
					<td align="center">C5/B</td>
					<td align="center"><?php if ($tmp_stat2_varB>0) { echo round(($tmp_stat2_varC5/$tmp_stat2_varB)*100,1).' %'; } ?></td>
				</tr>
				<tr>
					<td class="title_s" style="text-align:left;">Resident restrain due to other reason(C6)</td>
					<td align="center">
						<?php
						$db_b_8 = new DB;
						$db_b_8->query("SELECT * FROM `sixtarget_part2` WHERE `reason6`='1' AND ((`startdate` LIKE '".$qdate2."%' AND `releasedate` NOT LIKE '".$qdate2."%') OR (`startdate` NOT LIKE '".$qdate2."%' AND (`releasedate`='' OR `releasedate`='____/__/__')))");
						if ($r_b_0['varC6']=="") { $tmp_stat2_varC6 = $db_b_8->num_rows(); } else { $tmp_stat2_varC6 = $r_b_0['varC6']; }
						?>
						<input type="text" name="sixtarget_stat2_varC6" size="4" value="<?php echo $tmp_stat2_varC6; ?>" />
					</td>
					<td align="center">C6/B</td>
					<td align="center"><?php if ($tmp_stat2_varB>0) { echo round(($tmp_stat2_varC6/$tmp_stat2_varB)*100,1).' %'; } ?></td>
				</tr>
				<tr>
					<td class="title_s" style="text-align:left;">Resident with more than 2 restraint(D)</td>
					<td align="center">
						<?php
						$db_b_9 = new DB;
  //$db_b_9->query("SELECT COUNT(*) FROM ( SELECT COUNT(HospNo), HospNo FROM `sixtarget_part2` WHERE `startdate` LIKE '".$qdate2."%' AND `releasedate`='' GROUP BY `HospNo` HAVING COUNT(HospNo)>1) t");
						$db_b_9->query("SELECT SUM(`equipment1` + `equipment2` + `equipment3` + `equipment4` + `equipment5` + `equipment6` + `equipmentother`) AS `equipments`  FROM `sixtarget_part2` WHERE DATE_FORMAT(`startdate`, '%Y/%m') = '".$qdate2."' OR (`releasedate`='' OR `releasedate`='____/__/__') GROUP BY `targetID` HAVING `equipments`>1");
  //$r_b_9 = $db_b_9->fetch_assoc();
						if ($r_b_0['varD']=="") { $tmp_stat2_varD = $db_b_9->num_rows(); } else { $tmp_stat2_varD = $r_b_0['varD']; }
						?>
						<input type="text" name="sixtarget_stat2_varD" size="4" value="<?php echo $tmp_stat2_varD; ?>" />
					</td>
					<td align="center">D/B</td>
					<td align="center"><?php if ($tmp_stat2_varB>0) { echo round(($tmp_stat2_varD/$tmp_stat2_varB)*100,1).' %'; } ?></td>
				</tr>
				<tr>
					<td class="title_s" style="text-align:left;">Monthly residents removed retraint for more than 24 hours(H)</td>
					<td align="center">
						<?php
						$tmp_stat2_varH = 0;
						$db_b_9h = new DB;
						$db_b_9h->query("SELECT `HospNo`, `Name`, GROUP_CONCAT(startdate) as sDateStr, GROUP_CONCAT(releasedate) as rDateStr, COUNT(*) AS `count`  FROM `sixtarget_part2` WHERE `startdate` LIKE '".$qdate2."%' GROUP BY `HospNo`");
						if ($r_b_0['varH']=="") {
							for ($i9dbh=0;$i9dbh<$db_b_9h->num_rows();$i9dbh++) {
								$r_b_9h = $db_b_9h->fetch_assoc();
								if ($r_b_9h['count']==1 && $r_b_9h['rDateStr']!="" && $r_b_9h['rDateStr']!=",") {
									$tmp_stat2_varH++;
								} else {
									$arrStartdate = explode(",",$r_b_9h['sDateStr']);
									$arrReleasedate = explode(",",$r_b_9h['rDateStr']);
									for ($i9h=0;$i9h<count($arrReleasedate);$i9h++) {
										$days = abs((strtotime($arrReleasedate[$i9h]) - strtotime($arrStartdate[$i9h+1]))/(3600*24));
				  //echo $r_b_9h['HospNo'].' '.$days."<br>";
										if ($days>1 && $days<1000) {
											$tmp_stat2_varH++;
										}
									}
								}
							}
						} else { $tmp_stat2_varH = $r_b_0['varH']; }
						?>
						<input type="text" name="sixtarget_stat2_varH" size="4" value="<?php echo $tmp_stat2_varH; ?>" />
					</td>
					<td align="center">H/B</td>
					<td align="center"><?php if ($tmp_stat2_varB>0) { echo round(($tmp_stat2_varH/$tmp_stat2_varB)*100,1).' %'; } ?></td>
				</tr>
			</table>
			<table width="100%">
				<tr>
					<td class="title" colspan="3">PDCA analysis</td>
				</tr>
				<tr>
					<td class="title_s" style="text-align:left;" width="260">Plan</td>
					<td colspan="2"><textarea id="sixtarget_stat2_plan" name="sixtarget_stat2_plan" rows="4"><?php echo $r_b_0['plan']; ?></textarea></td>
				</tr>
				<tr>
					<td class="title_s" style="text-align:left;">Execution (Do)</td>
					<td colspan="2"><textarea id="sixtarget_stat2_do" name="sixtarget_stat2_do" rows="4"><?php echo $r_b_0['do']; ?></textarea></td>
				</tr>
				<tr>
					<td class="title_s" style="text-align:left;">Review (Check)</td>
					<td colspan="2"><textarea id="sixtarget_stat2_check" name="sixtarget_stat2_check" rows="4"><?php echo $r_b_0['check']; ?></textarea></td>
				</tr>
				<tr>
					<td class="title_s" style="text-align:left;">Improvement plan develop and action (Action)</td>
					<td colspan="2"><textarea id="sixtarget_stat2_action" name="sixtarget_stat2_action" rows="4"><?php echo $r_b_0['action']; ?></textarea></td>
				</tr>
			</table>
			<table width="100%">
				<tr <?php if ($qdate=="%") { echo 'style="display:none;"'; } ?>>
					<td class="title"><input type="hidden" name="month" value="<?php echo $qdate; ?>" /><input type="hidden" name="tbname" value="part2" /><input type="submit" value="Save <?php echo $qdate2; ?> Statistics" class="printcol" /> <input type="submit" value="Recalculate latest data formula" name="resetstat" class="printcol" /></td>
					<td colspan="3" class="title">Last modified date:<?php echo formatdate($r_a_0['savedate']); ?> Modified by:<?php echo checkusername($r_a_0['Qfiller']); ?></td>
				</tr>
			</table>
		</form>
	</div>
	<!--約束季分析-->
	<div id="tab2_part3" style="display:none;">
		<table class="content-query" style="font-size:10pt;page-break-after:always;">
			<tr class="title">
				<td width="36%">&nbsp;</td>
				<td width="16%">Season 1 (Q1)</td>
				<td width="16%">Season 2 (Q2)</td>
				<td width="16%">Season 3 (Q3)</td>
				<td width="16%">Season 4 (Q4)</td>
			</tr>
			<?php
			$arrQTab2 = array('varA'=>'Monthly total resident days(A)', 'varB'=>'Montly body retrained resident number(B)', 'varBP'=>'Body restrain ratio(B/A)', 'varC1'=>'Resident restrain due to fall prevention number(C1)', 'varC1P'=>'Resident restrain due to fall prevention number ratio(C1/B)', 'varC2'=>'Resident restrain due to pipeline self extrication prevention number(C2)', 'varC2P'=>'Resident restrain due to pipeline self extrication prevention number ratio(C2/B)', 'varC3'=>'Resident restrain due to self harm prevention number(C3)', 'varC3P'=>'Resident restrain due to self harm prevention number ratio(C3/B)', 'varC4'=>'Resident restrain due to behavioral disorders number(C4)', 'varC4P'=>'Resident restrain due to behavioral disorders number ratio(C4/B)', 'varC5'=>'Resident restrain due to assistance of the treatment(C5)', 'varC5P'=>'Resident restrain due to assistance of the treatment ratio(C5/B)', 'varC6'=>'Resident restrain due to other reason(C6)', 'varC6P'=>'Resident restrain due to other reason ratio(C6/B)', 'varD'=>'Resident with more than 2 restraint(D)', 'varDP'=>'Resident with more than 2 restraint ratio(D/B)', 'varH'=>'Monthly residents removed retraint for more than 24 hours(H)', 'varHP'=>'Monthly restrain remove successfully ratio(H/B)');
			foreach ($arrQTab2 as $ktab2 => $vtab2) {
				?>
				<tr>
					<td class="title_s" style="font-size:9pt;"><?php echo $vtab2; ?></td>
					<?php
					foreach ($arrSeasonMonth as $k2=>$v2) {
						$db3_2 = new DB;
						$db3_2->query("SELECT `month`, `".str_replace("P","",$ktab2)."` AS '".str_replace("P","",$ktab2)."' FROM `sixtarget_part2_stat` WHERE `month`>='".$v2[0]."' AND `month`<='".$v2[1]."' ORDER BY `month` ASC");
						if ($db3_2->num_rows()==0) {
							echo '<td align="center"><center>---</center></td>';
						} else {
							for ($i3_2=0;$i3_2<$db3_2->num_rows();$i3_2++) {
								$r3_2 = $db3_2->fetch_assoc();
								${'arrPart2Tab3Tmp_'.$ktab2}[$k2][$i3_2] += $r3_2[str_replace("P","",$ktab2)];
							}
							if (substr($ktab2,strlen($ktab2)-1,1)=="P") {
								if ($ktab2=="varBP") {
									if (array_sum($arrPart2Tab3Tmp_varA[$k2])==0) {
										${'statVar'.$ktab2} = 0;
									} else {
										${'statVar'.$ktab2} = round(((array_sum(${'arrPart2Tab3Tmp_'.str_replace("P", "", $ktab2)}[$k2])/3)/(array_sum($arrPart2Tab3Tmp_varA[$k2])/3))*100,2);
									}
									echo '<td align="center"><center>'.${'statVar'.$ktab2}.' %</center></td>';
								} elseif ($ktab2=="varC1P" || $ktab2=="varC2P" || $ktab2=="varC3P" || $ktab2=="varC4P" || $ktab2=="varC5P" || $ktab2=="varC6P" || $ktab2=="varDP" || $ktab2=="varHP") {
									if (array_sum($arrPart2Tab3Tmp_varB[$k2])==0) {
										${'statVar'.$ktab2} = 0;
									} else {
										${'statVar'.$ktab2} = round(((array_sum(${'arrPart2Tab3Tmp_'.str_replace("P", "", $ktab2)}[$k2])/3)/(array_sum($arrPart2Tab3Tmp_varB[$k2])/3))*100,2);
									}
									echo '<td align="center"><center>'.${'statVar'.$ktab2}.' %</center></td>';
								}
							} else {
								if ($db3_2->num_rows()==0) {
									$arraysum = 0;
									$numrows = 1;
								} else {
									$arraysum = array_sum(${'arrPart2Tab3Tmp_'.$ktab2}[$k2]);
									$numrows = 3;
								}
								echo '<td align="center"><center>'.round(($arraysum/$numrows),2).'</center></td>';
							}
						}
					}
					?>
				</tr>
				<?php
			}
			?>
		</table>
	</div>
	<!--約束年度分析-->
	<div id="tab2_part4" style="display:none;">
		<table class="content-query" style="page-break-after:always;">
			<tr class="title">
				<td width="22%">&nbsp;</td>
				<?php
				foreach ($arrPast12Months as $k1=>$v1) {
					echo '<td width="6.5%">'.str_replace("/","<br>",$v1).'</td>';
				}
				?>
			</tr>
			<?php
			foreach ($arrQTab2 as $ktab2 => $vtab2) {
				?>
				<tr>
					<td class="title_s" style="font-size:9pt;"><?php echo $vtab2; ?></td>
					<?php
	  //print_r($arrPast12Months);
					foreach ($arrPast12Months as $k1=>$v1) {
						$arrDateTab2Q = explode("/",$v1);
						if (strlen($arrDateTab2Q[1])==1) { $monthofq32 = '0'.$arrDateTab2Q[1]; } else { $monthofq32 = $arrDateTab2Q[1]; }
						$db3_2 = new DB;
						$db3_2->query("SELECT `".str_replace("P","",$ktab2)."` FROM `sixtarget_part2_stat` WHERE `month`='".$arrDateTab2Q[0].$monthofq32."'");
						if (${'stat2_'.$ktab2}!="") { ${'stat2_'.$ktab2} .= ', '; }
						if (${'stat2_'.$ktab2.'_per'}!="") { ${'stat2_'.$ktab2.'_per'} .= ', '; }
						$second1970 = mktime(0,0,0,$arrDateTab2Q[1],1,$arrDateTab2Q[0]);
						$second1970ms = number_format(($second1970 * 1000), 0, '.', '');
						if ($db3_2->num_rows()==0) {
							${'stat2_'.$ktab2.'_per'} .= '["'.$second1970ms.'",0]';
							${'stat2_'.$ktab2} .= '["'.$second1970ms.'",0]';
							echo '<td align="center"><center>---</center></td>';
						} else {
							$r3_2 = $db3_2->fetch_assoc();
							if ($r3_2['varA']!='') { ${'totalpatientstat2A_'.$arrDateTab2Q[0].$monthofq32} = $r3_2['varA']; }
							if ($r3_2['varB']!='') { ${'totalpatientstat2B_'.$arrDateTab2Q[0].$monthofq32} = $r3_2['varB']; }
			  /*if ($r3_2[str_replace("P","",$ktab2)]=="") {
				  echo '<td align="center"><center>---</center></td>';
				} else {*/
					echo '<td align="center"><center>';
					if ($ktab2=="varB") {
						echo $r3_2[$ktab2];
						${'stat2_'.$ktab2} .= '["'.$second1970ms.'","'.$r3_2[$ktab2].'"]';
					} elseif ($ktab2=="varBP") {
						if (${'totalpatientstat2A_'.$arrDateTab2Q[0].$monthofq32}>0) {
							echo round(($r3_2[str_replace("P","",$ktab2)]/${'totalpatientstat2A_'.$arrDateTab2Q[0].$monthofq32})*100,1)." %<br>";
						} else { echo "0 %"; ${'stat2_'.$ktab2.'_per'} .= '["'.$second1970ms.'",0]'; }
						if ($r3_2[str_replace("P","",$ktab2)]=="") { ${'stat2_'.$ktab2.'_per'} .= '["'.$second1970ms.'",0]'; } else { ${'stat2_'.$ktab2.'_per'} .= '["'.$second1970ms.'",'.round(($r3_2[str_replace("P","",$ktab2)]/${'totalpatientstat2A_'.$arrDateTab2Q[0].$monthofq32})*100,1).']'; }
					} elseif ($ktab2=="varC1" || $ktab2=="varC2" || $ktab2=="varC3" || $ktab2=="varC4" || $ktab2=="varC5" || $ktab2=="varC6" || $ktab2=="varD") {
						echo $r3_2[$ktab2];
						${'stat2_'.$ktab2} .= '["'.$second1970ms.'","'.$r3_2[$ktab2].'"]';
					} elseif ($ktab2=="varC1P" || $ktab2=="varC2P" || $ktab2=="varC3P" || $ktab2=="varC4P" || $ktab2=="varC5P" || $ktab2=="varC6P" || $ktab2=="varDP") {
						if (${'totalpatientstat2B_'.$arrDateTab2Q[0].$monthofq32}>0) {
							echo round(($r3_2[str_replace("P","",$ktab2)]/${'totalpatientstat2B_'.$arrDateTab2Q[0].$monthofq32})*100,1)." %<br>";
							if ($r3_2[str_replace("P","",$ktab2)]=="") { ${'stat2_'.$ktab2.'_per'} .= '["'.$second1970ms.'",0]'; } else { ${'stat2_'.$ktab2.'_per'} .= '["'.$second1970ms.'",'.round(($r3_2[str_replace("P","",$ktab2)]/${'totalpatientstat2B_'.$arrDateTab2Q[0].$monthofq32})*100,1).']'; }
						} else { echo "0 %"; ${'stat2_'.$ktab2.'_per'} .= '["'.$second1970ms.'",0]'; }
					} elseif ($ktab2=="varHP") {
						if (${'totalpatientstat2B_'.$arrDateTab2Q[0].$monthofq32}>0) {
							echo round(($r3_2[str_replace("P","",$ktab2)]/${'totalpatientstat2B_'.$arrDateTab2Q[0].$monthofq32})*100,1)." %<br>";
							if ($r3_2[str_replace("P","",$ktab2)]=="") {
								${'stat2_'.$ktab2.'_per'} .= '["'.$second1970ms.'",0]';
							} else {
								${'stat2_'.$ktab2.'_per'} .= '["'.$second1970ms.'",'.round(($r3_2[str_replace("P","",$ktab2)]/${'totalpatientstat2B_'.$arrDateTab2Q[0].$monthofq32})*100,1).']';
							}
						} else { echo "0 %"; ${'stat2_'.$ktab2.'_per'} .= '["'.$second1970ms.'",0]'; }
					} else {
						echo $r3_2[$ktab2];
						${'stat2_'.$ktab2} .= '["'.$second1970ms.'","'.$r3_2[$ktab2].'"]';
					}
					echo '</center></td>';
					/*}*/
			  //if ($r3_2[$ktab2]=="") { ${'stat2_'.$ktab2} .= '["'.$second1970ms.'",0]'; } else { ${'stat2_'.$ktab2} .= '["'.$second1970ms.'",'.$r3_2[$ktab2].']'; }
				}
			}
			?>
		</tr>
		<?php
	}
	?>
</table><br><br>
<style>
#chart2 table {
	width: auto;
	left:780px;
	position:relative;
}
#chart2 table tr {
	background:none;
	height:auto;
	padding:0px;
	margin:0px;
}
#chart2 table tr td { border:none; font-size:10pt; padding: 4px 0px; }
#chart2b table {
	width: auto;
	left:780px;
	position:relative;
}
#chart2b table tr {
	background:none;
	height:auto;
	padding:0px;
	margin:0px;
}
#chart2b table tr td { border:none; font-size:10pt; padding: 4px 0px; }
</style>
<h3><?php echo $arrDate[0]; ?>Annual restrain applied and successfully removed ratio</h3>
<div id="chart2b" style="width:740px;height:420px; margin-left:40px; padding-top:50px; margin-top:50px; padding-bottom:50px; margin-bottom:50px; page-break-after:always;"></div><br /><br />
<h3><?php echo $arrDate[0]; ?>Annual retrain reason analysis</h3>
<div id="chart2" style="width:740px;height:420px; margin-left:40px; padding-top:50px; margin-top:50px; padding-bottom:50px; margin-bottom:50px;"></div><br /><br />
<script type="text/javascript">
$(function () {
	$.plot($("#chart2"), [
		{ label: "Fall prevent (C1)",  data: [<?php echo $stat2_varC1; ?>], bars: {fillColor: "#edc240"}, color: "#edc240" },
		{ label: "Pipeline Protect (C2)",  data: [<?php echo $stat2_varC2; ?>], bars: {fillColor: "#afd8f8"}, color: "#afd8f8" },
		{ label: "Self-injury prevent (C3)",  data: [<?php echo $stat2_varC3; ?>], bars: {fillColor: "#cb4b16"}, color: "#cb4b16" },
		{ label: "Behavioral disorders (C4)",  data: [<?php echo $stat2_varC4; ?>], bars: {fillColor: "#99EC41" }, color: "#99EC41" },
		{ label: "Assist treatment (C5)",  data: [<?php echo $stat2_varC5; ?>], bars: {fillColor: "#9440ed"}, color: "#9440ed" },
		{ label: "Other reason (C6)",  data: [<?php echo $stat2_varC6; ?>], bars: {fillColor: "#cb4b16"}, color: "#cb4b16" },
		{ label: "Fall prevention ratio (C1/B)",  data: [<?php echo $stat2_varC1P_per; ?>], lines: {show: true}, points: { show: true, symbol:"circle" }, bars: {show: false}, yaxis:2 },
		{ label: "Pipeline protection ratio<br>(C2/B)",  data: [<?php echo $stat2_varC2P_per; ?>], lines: {show: true}, points: { show: true, symbol:"square" }, bars: {show: false}, yaxis:2 },
		{ label: "Self harm prevention ratio(C3/B)",  data: [<?php echo $stat2_varC3P_per; ?>], lines: {show: true}, points: { show: true, symbol:"diamond" }, bars: {show: false}, yaxis:2 },
		{ label: "Behavioral disorders protect ratio (C4/B)",  data: [<?php echo $stat2_varC4P_per; ?>], lines: {show: true}, points: { show: true, symbol:"cross" }, bars: {show: false}, yaxis:2 },
		{ label: "Assistance of the treatment ratio (C5/B)",  data: [<?php echo $stat2_varC5P_per; ?>], lines: {show: true}, points: { show: true, symbol:"triangle" }, bars: {show: false}, yaxis:2 },
		{ label: "Other reason ratio (C6/B)",  data: [<?php echo $stat2_varC6P_per; ?>], lines: {show: true}, points: { show: true, symbol:"circle" }, bars: {show: false}, yaxis:2 }
		],
		{
			xaxis: { mode: "time", timeformat: "%y<br>%b", monthNames: [<?php for ($imonth=1;$imonth<=12;$imonth++) { if ($imonth>1) { echo ', '; } echo "'".$imonth."'"; } ?>], tickLength: 0, axisLabelUseCanvas: true, axisLabelFontSizePixels: 12, axisLabelFontFamily: "Verdana, Arial, Helvetica, Tahoma, sans-serif", axisLabelPadding: 5 },
			yaxes: [
			{tickSize: 2, tickDecimals: 0, position: 'left'},
			{tickSize: 10, tickDecimals: 1, min:0, position: 'right'}
			],
			grid: { hoverable: true, clickable: false, borderWidth: 1 },
			series: { shadowSize: 0, bars: { show: true, barWidth: 12*24*60*60*300, order: 1 } }
		});
var yaxisLabel = $("<div class='axisLabel yaxisLabel' style='position: absolute; left: -28px; top: -30px;'></div>").text("People").appendTo($('#chart2'));
var yaxisLabel2 = $("<div class='axisLabel yaxisLabel' style='width:50px; position: absolute; left: 740px; top: -30px;'></div>").text("Rate").appendTo($('#chart2'));
var xaxisLabel = $("<div class='axisLabel xaxisLabel' style='position: absolute; left:400px; bottom: -50px;'></div>").text(" month").appendTo($('#chart2'));
});

$(function () {
	$.plot($("#chart2b"), [
		{ label: "Monthly total resident days(A)",  data: [<?php echo $stat2_varA; ?>], bars: {fillColor: "#edc240"}, color: "#edc240" },
		{ label: "Montly body retrained resident number (B)",  data: [<?php echo $stat2_varB; ?>], bars: {fillColor: "#afd8f8"}, color: "#afd8f8" },
		{ label: "Monthly residents removed retraint<br> for more than 24 hours (H)",  data: [<?php echo $stat2_varH; ?>], bars: {fillColor: "#cb4b16"}, color: "#cb4b16" },
		{ label: "Mothly retraint ratio (B/A)",  data: [<?php echo $stat2_varBP_per; ?>], lines: {show: true}, points: { show: true, symbol:"cross" }, bars: {show: false},  color: "#99EC41", yaxis:2 },
		{ label: "Monthly restrain remove successfully ratio(H/B)",  data: [<?php echo $stat2_varHP_per; ?>], lines: {show: true}, points: { show: true, symbol:"square" }, bars: {show: false}, color: "#9440ed", yaxis:2 }
		],
		{
			xaxis: { mode: "time", timeformat: "%y<br>%b", monthNames: [<?php for ($imonth=1;$imonth<=12;$imonth++) { if ($imonth>1) { echo ', '; } echo "'".$imonth."'"; } ?>], tickLength: 0, axisLabelUseCanvas: true, axisLabelFontSizePixels: 12, axisLabelFontFamily: "Verdana, Arial, Helvetica, Tahoma, sans-serif", axisLabelPadding: 5 },
			yaxes: [
			{tickSize: 200, tickDecimals: 0, position: 'left'},
			{tickSize: 5, tickDecimals: 1, min:0, position: 'right'}
			],
			grid: { hoverable: true, clickable: false, borderWidth: 1 },
			series: { shadowSize: 0, bars: { show: true, barWidth: 12*24*60*60*300, order: 1 } }
		});
var yaxisLabel = $("<div class='axisLabel yaxisLabel' style='position: absolute; left: -28px; top: -30px;'></div>").text("Total number of resident days").appendTo($('#chart2b'));
var yaxisLabel2 = $("<div class='axisLabel yaxisLabel' style='width:50px; position: absolute; left: 740px; top: -30px;'></div>").text("Rate").appendTo($('#chart2b'));
var xaxisLabel = $("<div class='axisLabel xaxisLabel' style='position: absolute; left:400px; bottom: -50px;'></div>").text(" month").appendTo($('#chart2b'));
});
</script>
</div>
</div>
</center>
<!--跌倒-->
<center>
<div id="tab3" style="font-size:11pt;">
	<h3>Fall indicator annual monitoring</h3>
	<div align="center" style="margin-bottom:10px;">
			<?php echo draw_option("tab3option","Current month record;Current month statistic;3 months(seasonal) analysis;Annual analysis","xl","single",1,false,5); ?>
	</div>
	<div align="center">	
			<button type="button" id="newrecord3" title="Add fall record" onclick="openVerificationForm('#dialog-form3');"><i class="fa fa-user-plus fa-2x fa-fw"></i><br>Add new data</button>
			<div class="patlistbtn" style="background-color:rgb(149,219,208); width:100px;"><a href="index.php?mod=management&func=formview&id=3d_1&type=3<?php echo $sMonth;?>" title="逐案分析列表"><i class="fa fa-list fa-2x fa-fw"></i><br>Case-by-case analysis</a></div>
			<div class="patlistbtn" style="background-color:rgb(149,219,208);"><a href="#" onclick="printDialog('3', '<?php echo $_GET['qdate']; ?>');" title="Print report"><i class="fa fa-print fa-2x fa-fw"></i><br>Print report</a></div>
		
	</div>
	<script>
	$(function() {
		$( "#dialog-form3" ).dialog({
			autoOpen: false,
			height: 600,
			width: 940,
			modal: true,
			buttons: {
				"Add record": function() {
					if ($("#HospNo_tab3").val()=="") {
						alert("請先填寫住民資料");
						$("#HospNo_tab3").focus();
					} else {
						$.ajax({
							url: "class/sixtarget_part3.php",
							type: "POST",
							data: { 'HospNo': $('#HospNo_tab3').val(), 'Name': $('#Name_tab3').val(), 'Gender': $('#Gender_tab3').val(), 'Age': $('#Age_tab3').val(), 'Diag': $('#Diag_tab3').val(), 'ADLtotal': $('#ADLtotal_tab3').val(), 'date': $('#part3_date').val(), 'time': $('#part3_time').val(), 'location_1': $('#part3_location_1').val(), 'location_2': $('#part3_location_2').val(), 'location_3': $('#part3_location_3').val(), 'location_4': $('#part3_location_4').val(), 'location_5': $('#part3_location_5').val(), 'location_6': $('#part3_location_6').val(), 'locationother': $('#part3_locationother').val(), 'movement_1': $('#part3_movement_1').val(), 'movement_2': $('#part3_movement_2').val(), 'movement_3': $('#part3_movement_3').val(), 'movement_4': $('#part3_movement_4').val(), 'movement_5': $('#part3_movement_5').val(), 'movement_6': $('#part3_movement_6').val(), 'movement_7': $('#part3_movement_7').val(), 'movementother': $('#part3_movementother').val(), 'reason_1': $('#part3_reason_1').val(), 'reason_2': $('#part3_reason_2').val(), 'reason_3': $('#part3_reason_3').val(), 'reason_4': $('#part3_reason_4').val(), 'reasonother': $('#part3_reasonother').val(), 'object_1': $('#part3_object_1').val(), 'object_2': $('#part3_object_2').val(), 'object_3': $('#part3_object_3').val(), 'object_4': $('#part3_object_4').val(), 'object_5': $('#part3_object_5').val(), 'med_1': $('#part3_med_1').val(), 'med_2': $('#part3_med_2').val(), 'med_3': $('#part3_med_3').val(), 'med_4': $('#part3_med_4').val(), 'med_5': $('#part3_med_5').val(), 'med_6': $('#part3_med_6').val(), 'med_7': $('#part3_med_7').val(), 'med_8': $('#part3_med_8').val(), 'injurlv_1': $('#part3_injurlv_1').val(), 'injurlv_2': $('#part3_injurlv_2').val(), 'injurlv_3': $('#part3_injurlv_3').val(), 'injurlv_4': $('#part3_injurlv_4').val(), 'bodypart_1': $('#part3_bodypart_1').val(), 'bodypart_2': $('#part3_bodypart_2').val(), 'bodypart_3': $('#part3_bodypart_3').val(), 'bodypart_4': $('#part3_bodypart_4').val(), 'bodypart_5': $('#part3_bodypart_5').val(), 'bodypart_6': $('#part3_bodypart_6').val(), 'bodypartother': $('#part3_bodypartother').val(), 'description': $('#part3_description').val(), 'Qfiller': $('#Qfiller').val() },
							success: function(data) {
								$( "#dialog-form3" ).dialog( "close" );
								alert("Add record sucessfully!");
								window.location.reload();
							}
						});
}
},
"Cancel": function() {
	$( "#dialog-form3" ).dialog( "close" );
}
}
});
});
</script>
<div id="dialog-form3" title="Add fall record" class="dialog-form"> 
	<form id="form3">
		<fieldset>
			<table>
				<tr>
					<td class="title">Search</td>
					<td colspan="3">
						&nbsp;<span style="padding:3px; border:1px solid #999; color:#666; font-size:10pt;">Care ID#</span> <input type="text" name="HospNo" id="HospNo_tab3" value="" size="8">&nbsp;
						<span style="padding:3px; background:#69b3b6; color:#fff; font-size:10pt;">or</span>&nbsp;
						<span style="padding:3px; border:1px solid #999; color:#666; font-size:10pt;">Bed #</span> <input type="text" name="BedID" id="BedID_tab3" size="8">&nbsp;
						<span style="padding:3px; border:1px solid #999; color:#666; font-size:10pt;">Full name</span> <input type="text" name="Name" id="Name_tab3" size="8" readonly="readonly">&nbsp;
						<input type="button" value="Search" id="search_tab3" onclick="loadPatInfo('tab3')" />
						<input type="button" value="Empty" id="clear_tab3" onclick="cleartab('3')" style="display:none;" /></td>
				</tr>
				<tr>
					<td class="title">Gender</td>
					<td><input type="text" name="Gender" id="Gender_tab3" value="" size="8">
					<td class="title">Age</td>
					<td><input type="text" name="Age" id="Age_tab3" size="8"></td>
				</tr>
				<tr>
					<td class="title">Major diagnosis</td>
					<td><input type="text" name="Diag" id="Diag_tab3" value="" size="30" >
					<td class="title">ADL score</td>
					<td><input type="text" name="ADLtotal" id="ADLtotal_tab3"  size="8"></td>
				</tr>
				<tr>
					<td class="title">Date</td>
					<td><script> $(function() { $( "#part3_date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="part3_date" id="part3_date" value="<?php echo date(Y."/".m."/".d); ?>"></td>
					<td class="title">Time</td>
					<td><input type="text" name="part3_time" id="part3_time" value="<?php echo date(Hi); ?>"></td>
				</tr>
				<tr>
					<td class="title">Location</td>
					<td colspan="3"><?php echo draw_option("part3_location","Room;Bedside;Bathroom;Activity area;Walkway;Other","m","single",$part3_location,false,4); ?> <input type="text" name="part3_locationother" id="part3_locationother" size="12"></td>
				</tr>
				<tr>
					<td class="title">Scenarios</td>
					<td colspan="3"><?php echo draw_option("part3_movement","Toileting;In/out bed;During activity;Slip(wheelchair);Stand up(wheelchair);Across(Bed rails);Other","xl","single",$part3_movement,true,3); ?> <input type="text" name="part3_movementother" id="part3_movementother" size="12"></td>
				</tr>
				<tr>
					<td class="title">Reason</td>
					<td colspan="3"><?php echo draw_option("part3_reason","Resident's health;Treatment/medication;Environmental risk;Other","xl","multi",$part3_reason,true,3); ?> <input type="text" name="part3_reasonother" id="part3_reasonother" size="12"></td>
				</tr>
				<tr>
					<td class="title">Restraints</td>
					<td colspan="3"><?php echo draw_option("part3_object","Bed rails(2);Bed rail(1);Waist restraint straps;Posey vest;No restraint","xl","multi",$part3_object,true,3); ?></td>
				</tr>
				<tr>
					<td class="title">Medication</td>
					<td colspan="3"><?php echo draw_option("part3_med","Antihistamine;Antihypertensive;Sedative-hypnotic;Muscle relaxants;Laxative;Diuretics;Antidepressant;Hypoglycemic","l","multi",$part3_med,true,4); ?></td>
				</tr>
				<tr>
					<td class="title">Injury severity</td>
					<td colspan="3">
						<?php echo draw_option("part3_injurlv","None;Level1;Level2;Level3","m","multi",$part3_injurlv,false,6); ?>
						<div style="font-size:10pt;">
						<b>Level1:</b> Refers to the degree of injury does not require treatment or just a bit of treatment and observation, such as abrasions, contusions, small lacerations that do not need suturing.<br>
						<b>Level2:</b> Refers to the need ice, bandaging, suturing kind of care treatment. Such as sprains, large or deep lacerations.<br>
						<b>Level3:</b> Refers to the servirity that require medical attention. Such as fractures, loss of consciousness, change of mental or physical state. Injury seriously affect resident's treatment and prolong hospital stay.</div>
					</td>
				</tr>
				<tr>
					<td class="title">Body part(s)</td>
					<td colspan="3"><?php echo draw_option("part3_bodypart","Waist;Ankle(s);Wrist(s);Knee(s);Torso;Other","m","multi",$part3_bodypart,false,3); ?> <input type="text" name="part3_bodypartother" id="part3_bodypartother" size="10"></td>
				</tr>
				<tr>
					<td class="title">Status description</td>
					<td colspan="3"><textarea name="part3_description" id="part3_description" rows="6"></textarea></td>
				</tr>
				<input type="hidden" name="Qfiller" id="Qfiller" value="<?php echo $_SESSION['ncareID_lwj']; ?>">
			</table>
		</fieldset>
	</form>
</div>
				<script>
				$('#btn_tab3option_1').click(function() {
					$('#tab3_part1').show();
					$('#tab3_part2').hide();
					$('#tab3_part3').hide();
					$('#tab3_part4').hide();
				});
				$('#btn_tab3option_2').click(function() {
					$('#tab3_part1').hide();
					$('#tab3_part2').show();
					$('#tab3_part3').hide();
					$('#tab3_part4').hide();
				});
				$('#btn_tab3option_3').click(function() {
					$('#tab3_part1').hide();
					$('#tab3_part2').hide();
					$('#tab3_part3').show();
					$('#tab3_part4').hide();
				});
				$('#btn_tab3option_4').click(function() {
					$('#tab3_part1').hide();
					$('#tab3_part2').hide();
					$('#tab3_part3').hide();
					$('#tab3_part4').show();
				});
				$(function() { $('#tform3').validationEngine(); });
				</script>
				<!--跌倒資料列表-->
				<div id="tab3_part1">
					<form id="tform3" action="index.php?mod=management&func=formview&id=3d_2&type=3<?php echo $sMonth; ?>" method="post">
						<table class="content-query" style="font-size:10pt; font-weight:normal;">
							<tr class="title">
								<td rowspan="2" class="printcol">View</td>
								<td colspan="6">Profile</td>
								<td colspan="7">Characteristic analysis of falls</td>
								<td colspan="3">Physical injury</td>
								<td rowspan="2" class="printcol">Case-by-case analysis</td>
								<td rowspan="2" class="printcol">Delete</td>
							</tr>
							<tr class="title">
								<td align="center">Care ID#</td>
								<td width="60">Full name</td>
								<td align="center">Gender</td>
								<td align="center">Age</td>
								<td width="130">Major diagnosis</td>
								<td align="center">ADL<br />Score</td>
								<td align="center">Date</td>
								<td align="center">Time</td>
								<td align="center">Location</td>
								<td align="center">Scenarios</td>
								<td align="center">Reason</td>
								<td align="center">Restraints</td>
								<td align="center">Medication</td>
								<td align="center">severity of injury</td>
								<td align="center">Body part(s)</td>
								<td align="center">Status description</td>
							</tr>
							<?php
							$dbp1_3 = new DB;
							$dbp1_3->query("SELECT * FROM  `sixtarget_part3` WHERE `date` LIKE '".$qdate2."%'");
							if ($dbp1_3->num_rows()==0) {
								?>
								<tr>
									<td colspan="19"><center>-------Yet no data of this month-------</center></td>
								</tr>
								<script>$(function() { $('#analysis3').hide(); });</script>
								<?php
							} else {
								for ($p1_i1=0;$p1_i1<$dbp1_3->num_rows();$p1_i1++) {
									$rp1_3 =$dbp1_3->fetch_assoc();
									/*== 解 START ==*/
									$rsa = new lwj('lwj/lwj');
									$puepart = explode(" ",$rp1_3['Name']);
									$puepartcount = count($puepart);
									if($puepartcount>1){
										for($j=0;$j<$puepartcount;$j++){
											$prdpart = $rsa->privDecrypt($puepart[$j]);
											$rp1_3['Name'] = $rp1_3['Name'].$prdpart;
										}
									}else{
										$rp1_3['Name'] = $rsa->privDecrypt($rp1_3['Name']);
									}
									/*== 解 END ==*/
									$location = '';
									if ($rp1_3['location_1']==1) { $location .= 'Room'; }
									if ($rp1_3['location_2']==1) { if ($location!='') { $location.='、'; } $location .= 'Bedside'; }
									if ($rp1_3['location_3']==1) { if ($location!='') { $location.='、'; } $location .= 'Bathroom'; }
									if ($rp1_3['location_4']==1) { if ($location!='') { $location.='、'; } $location .= 'Activity area'; }
									if ($rp1_3['location_5']==1) { if ($location!='') { $location.='、'; } $location .= 'Walkway'; }
									if ($rp1_3['location_6']==1) { if ($location!='') { $location.='、'; } $location .= 'Other(s):'.$rp1_3['locationother']; }
									$movement = '';
									if ($rp1_3['movement_1']==1) { $movement .= 'Toileting'; }
									if ($rp1_3['movement_2']==1) { if ($movement!='') { $movement.='、'; } $movement .= 'In/out bed'; }
									if ($rp1_3['movement_3']==1) { if ($movement!='') { $movement.='、'; } $movement .= 'During activity'; }
									if ($rp1_3['movement_4']==1) { if ($movement!='') { $movement.='、'; } $movement .= 'Slip(wheelchair)'; }
									if ($rp1_3['movement_5']==1) { if ($movement!='') { $movement.='、'; } $movement .= 'Stand up(wheelchair)'; }
									if ($rp1_3['movement_6']==1) { if ($movement!='') { $movement.='、'; } $movement .= 'Across(Bed rails)'; }
									if ($rp1_3['movement_7']==1) { if ($movement!='') { $movement.='、'; } $movement .= 'Other(s):'.$rp1_3['movementother']; }
									$reason = '';
									if ($rp1_3['reason_1']==1) { $reason .= 'Resident\'s health'; }
									if ($rp1_3['reason_2']==1) { if ($reason!='') { $reason.='、'; } $reason .= 'Treatment/medication'; }
									if ($rp1_3['reason_3']==1) { if ($reason!='') { $reason.='、'; } $reason .= 'Environmental risk'; }
									if ($rp1_3['reason_4']==1) { if ($reason!='') { $reason.='、'; } $reason .= 'Other(s):'.$rp1_3['reasonother']; }
									$object = '';
									if ($rp1_3['object_1']==1) { $object .= 'Bed rails(2)'; }
									if ($rp1_3['object_2']==1) { if ($object!='') { $object.='、'; } $object .= 'Bed rail(1)'; }
									if ($rp1_3['object_3']==1) { if ($object!='') { $object.='、'; } $object .= 'Waist restraint straps'; }
									if ($rp1_3['object_4']==1) { if ($object!='') { $object.='、'; } $object .= 'Posey vest'; }
									if ($rp1_3['object_5']==1) { if ($object!='') { $object.='、'; } $object .= 'No restraint'; }
									$med = '';
									if ($rp1_3['med_1']==1) { $med .= 'Antihistamine'; }
									if ($rp1_3['med_2']==1) { if ($med!='') { $med.='、'; } $med .= 'Antihypertensive'; }
									if ($rp1_3['med_3']==1) { if ($med!='') { $med.='、'; } $med .= 'Sedative-hypnotic'; }
									if ($rp1_3['med_4']==1) { if ($med!='') { $med.='、'; } $med .= 'Muscle relaxants'; }
									if ($rp1_3['med_5']==1) { if ($med!='') { $med.='、'; } $med .= 'Laxative'; }
									if ($rp1_3['med_6']==1) { if ($med!='') { $med.='、'; } $med .= 'Diuretics'; }
									if ($rp1_3['med_7']==1) { if ($med!='') { $med.='、'; } $med .= 'Antidepressant'; }
									if ($rp1_3['med_8']==1) { if ($med!='') { $med.='、'; } $med .= 'Hypoglycemic'; }
									$injurlv = '';
									if ($rp1_3['injurlv_1']==1) { $injurlv .= 'None'; }
									if ($rp1_3['injurlv_2']==1) { if ($injurlv!='') { $injurlv.='、'; } $injurlv .= 'Level1'; }
									if ($rp1_3['injurlv_3']==1) { if ($injurlv!='') { $injurlv.='、'; } $injurlv .= 'Level2'; }
									if ($rp1_3['injurlv_4']==1) { if ($injurlv!='') { $injurlv.='、'; } $injurlv .= 'Level3'; }
									$bodypart = '';
									if ($rp1_3['bodypart_1']==1) { $bodypart .= 'Waist'; }
									if ($rp1_3['bodypart_2']==1) { if ($bodypart!='') { $bodypart.='、'; } $bodypart .= 'Ankle(s)'; }
									if ($rp1_3['bodypart_3']==1) { if ($bodypart!='') { $bodypart.='、'; } $bodypart .= 'Wrist(s)'; }
									if ($rp1_3['bodypart_4']==1) { if ($bodypart!='') { $bodypart.='、'; } $bodypart .= 'Knee(s)'; }
									if ($rp1_3['bodypart_5']==1) { if ($bodypart!='') { $bodypart.='、'; } $bodypart .= 'Torso'; }
									if ($rp1_3['bodypart_6']==1) { if ($bodypart!='') { $bodypart.='、'; } $bodypart .= 'Other(s):'.$rp1_3['bodypartother']; }
									?>
									<tr>
										<td class="printcol"><center><a href="index.php?mod=management&func=formview&id=3b_3&tID=<?php echo $rp1_3['targetID'].$sMonth; ?>"><img src="Images/folder.png" width="24" /></a></center></td>
										<td align="center"><?php echo getHospNoDisplayByHospNo($rp1_3['HospNo']); ?></td>
										<td align="center"><?php echo $rp1_3['Name']; ?></td>
										<td align="center"><?php echo $rp1_3['Gender']; ?></td>
										<td align="center"><?php echo $rp1_3['Age']; ?></td>
										<td align="center"><?php echo $rp1_3['Diag']; ?></td>
										<td align="center"><?php echo $rp1_3['ADLtotal']; ?></td>
										<td align="center"><?php echo $rp1_3['date']; ?></td>
										<td align="center"><?php echo substr($rp1_3['time'],0,2).":".substr($rp1_3['time'],2,2); ?></td>
										<td align="center"><?php echo $location; ?></td>
										<td align="center"><?php echo $movement; ?></td>
										<td align="center"><?php echo $reason; ?></td>
										<td align="center"><?php echo $object; ?></td>
										<td align="center"><?php echo $med; ?></td>
										<td align="center"><?php echo $injurlv; ?></td>
										<td align="center"><?php echo $bodypart; ?></td>
										<td align="center"><?php echo $rp1_3['description']; ?></td>
										<td class="printcol"><center><input type="checkbox" name="targetList_3[]" id="targetList_3_<?php echo $rp1_3['targetID']; ?>" class="validate[required]" value="<?php echo $rp1_3['targetID']; ?>"></center></td>
										<?php
										if ($_SESSION['ncareLevel_lwj']>=4 || $rp1_3['targetID']==$_SESSION['ncareID_lwj']) {
											echo '<td class="printcol"><a href="index.php?mod=management&func=formview&id=3c_3&tID='.$rp1_3['targetID'].'"><img src="Images/delete2.png" width="20"></a></td>';
										}
										?>
									</tr>
									<?php
								}
							}
							?>
						</table>
						<center><input type="submit" id="analysis3" value="Start case-by-case analysis" class="printcol"></center></form>
					</div>
					<!--跌倒當月統計-->
					<div id="tab3_part2" style="display:none;">
						<form action="index.php?func=save_sixtarget_stat" method="post" id="stat3">
							<table class="content-query">
								<tr class="title">
									<td align="center">Indicator item</td>
									<td align="center">Number</td>
									<td align="center">Formula</td>
									<td align="center">Rate(%)</td>
								</tr>
								<tr>
									<td class="title_s" style="text-align:left;">Monthly total resident days(A)</td>
									<td align="center">
										<?php
										$db_c_0 = new DB;
										$db_c_0->query("SELECT * FROM `sixtarget_part3_stat` WHERE `month`='".$qdate."'");
										$r_c_0 = $db_c_0->fetch_assoc();
										$db_c_1 = new DB;
										$db_c_1->query("SELECT SUM(`no`) FROM `dailypatientno` WHERE `date` LIKE '".str_replace("/","-",$qdate2)."%'");
										$r_c_1 = $db_c_1->fetch_assoc();
										$tmp_stat3_varA = $r_c_1['SUM(`no`)'];
										if ($r_c_0['varA']=="") { $tmp_stat3_varA = $r_c_1['SUM(`no`)']; } else { $tmp_stat3_varA = $r_c_0['varA']; }
										?>
										<input type="text" name="sixtarget_stat3_varA" size="4" value="<?php echo $tmp_stat3_varA; ?>" />
									</td>
									<td align="center">---</td>
									<td align="center">---</td>
								</tr>
								<tr>
									<td class="title_s" style="text-align:left;">Residents who have fallen history(B0)</td>
									<td align="center">
										<?php
										$tmp_stat3_varB0 = 0;
										$db_c_2a = new DB;
										$db_c_2a->query("SELECT * FROM `sixtarget_part3` WHERE `date` LIKE '".$qdate2."%'");
										if ($r_c_0['varB0']=="") {
											for($i3_3b0=0;$i3_3b0<$db_c_2a->num_rows();$i3_3b0++) {
												$r_c_2a = $db_c_2a->fetch_assoc();
												$db_c_2b = new DB;
												$db_c_2b->query("SELECT `HospNo` FROM `sixtarget_part3` WHERE `HospNo`='".$r_c_2a['HospNo']."' AND `date` < '".$qdate2."/01'");
												if ($db_c_2b->num_rows()>0) {
													$tmp_stat3_varB0++;
												}
											}
										} else { $tmp_stat3_varB0 = $r_c_0['varB0']; }
										?>
										<input type="text" name="sixtarget_stat3_varB0" size="4" value="<?php echo $tmp_stat3_varB0; ?>" />
										<td align="center">---</td>
										<td align="center">---</td>
									</tr>
									<tr>
										<td class="title_s" style="text-align:left;">Fall incident(B) --- density</td>
										<td align="center">
											<?php
											$db_c_2 = new DB;
											$db_c_2->query("SELECT * FROM `sixtarget_part3` WHERE `date` LIKE '".$qdate2."%'");
											if ($r_c_0['varB']=="") { $tmp_stat3_varB = $db_c_2->num_rows(); } else { $tmp_stat3_varB = $r_c_0['varB']; }
											?>
											<input type="text" name="sixtarget_stat3_varB" size="4" value="<?php echo $tmp_stat3_varB; ?>" />
											<td align="center">B/A</td>
											<td align="center"><?php echo round(($tmp_stat3_varB/$tmp_stat3_varA)*100,1); ?>%</td>
										</tr>
										<tr>
											<td class="title_s" style="text-align:left;">Fall occured due to health condition of residents(B1)</td>
											<td align="center">
												<?php
												$db_c_3a = new DB;
												$db_c_3a->query("SELECT * FROM `sixtarget_part3` WHERE `reason_1`='1' AND `date` LIKE '".$qdate2."%'");
												if ($r_c_0['varB1']=="") { $tmp_stat3_varB1 = $db_c_3a->num_rows(); } else { $tmp_stat3_varB1 = $r_c_0['varB1']; }
												?>
												<input type="text" name="sixtarget_stat3_varB1" size="4" value="<?php echo $tmp_stat3_varB1; ?>" />
												<td align="center">B1/B</td>
												<td align="center"><?php echo $tmp_stat3_varB>0?round(($tmp_stat3_varB1/$tmp_stat3_varB)*100,1):"0"; ?>%</td>
											</tr>
											<tr>
												<td class="title_s" style="text-align:left;">Fall occured due to medication or treatment(B2)</td>
												<td align="center">
													<?php
													$db_c_3b = new DB;
													$db_c_3b->query("SELECT * FROM `sixtarget_part3` WHERE `reason_2`='1' AND `date` LIKE '".$qdate2."%'");
													if ($r_c_0['varB2']=="") { $tmp_stat3_varB2 = $db_c_3b->num_rows(); } else { $tmp_stat3_varB2 = $r_c_0['varB2']; }
													?>
													<input type="text" name="sixtarget_stat3_varB2" size="4" value="<?php echo $tmp_stat3_varB2; ?>" />
													<td align="center">B2/B</td>
													<td align="center"><?php echo $tmp_stat3_varB>0?round(($tmp_stat3_varB2/$tmp_stat3_varB)*100,1):"0"; ?>%</td>
												</tr>
												<tr>
													<td class="title_s" style="text-align:left;">Fall occured due to enviromental risk(B3)</td>
													<td align="center">
														<?php
														$db_c_3c = new DB;
														$db_c_3c->query("SELECT * FROM `sixtarget_part3` WHERE `reason_3`='1' AND `date` LIKE '".$qdate2."%'");
														if ($r_c_0['varB3']=="") { $tmp_stat3_varB3 = $db_c_3c->num_rows(); } else { $tmp_stat3_varB3 = $r_c_0['varB3']; }
														?>
														<input type="text" name="sixtarget_stat3_varB3" size="4" value="<?php echo $tmp_stat3_varB3; ?>" />
														<td align="center">B3/B</td>
														<td align="center"><?php echo $tmp_stat3_varB>0?round(($tmp_stat3_varB3/$tmp_stat3_varB)*100,1):"0"; ?>%</td>
													</tr>
													<tr>
														<td class="title_s" style="text-align:left;">Fall occured due to other factor(B4)</td>
														<td align="center">
															<?php
															$db_c_3d = new DB;
															$db_c_3d->query("SELECT * FROM `sixtarget_part3` WHERE `reason_4`='1' AND `date` LIKE '".$qdate2."%'");
															if ($r_c_0['varB4']=="") { $tmp_stat3_varB4 = $db_c_3d->num_rows(); } else { $tmp_stat3_varB4 = $r_c_0['varB4']; }
															?>
															<input type="text" name="sixtarget_stat3_varB4" size="4" value="<?php echo $tmp_stat3_varB4; ?>" />
															<td align="center">B2/B</td>
															<td align="center"><?php echo $tmp_stat3_varB>0?round(($tmp_stat3_varB4/$tmp_stat3_varB)*100,1):"0"; ?>%</td>
														</tr>
														<tr>
															<td class="title_s" style="text-align:left;">Injury due to falling number(C) --- Fall injury</td>
															<td align="center">
																<?php
																$db_c_4 = new DB;
																$db_c_4->query("SELECT * FROM `sixtarget_part3` WHERE (`injurlv_2`='1' OR `injurlv_3`='1' OR `injurlv_4`='1') AND `date` LIKE '".$qdate2."%'");
																if ($r_c_0['varC']=="") { $tmp_stat3_varC = $db_c_4->num_rows(); } else { $tmp_stat3_varC = $r_c_0['varC']; }
																?>
																<input type="text" name="sixtarget_stat3_varC" size="4" value="<?php echo $tmp_stat3_varC; ?>" />
																<td align="center">C/B</td>
																<td align="center"><?php echo $tmp_stat3_varB>0?round(($tmp_stat3_varC/$tmp_stat3_varB)*100,1):"0"; ?>%</td>
															</tr>
															<tr>
																<td class="title_s" style="text-align:left;">Level 1 fall injury incidents(C1)</td>
																<td align="center">
																	<?php
																	$db_c_4a = new DB;
																	$db_c_4a->query("SELECT * FROM `sixtarget_part3` WHERE `injurlv_2`='1' AND `date` LIKE '".$qdate2."%'");
																	if ($r_c_0['varC1']=="") { $tmp_stat3_varC1 = $db_c_4a->num_rows(); } else { $tmp_stat3_varC1 = $r_c_0['varC1']; }
																	?>
																	<input type="text" name="sixtarget_stat3_varC1" size="4" value="<?php echo $tmp_stat3_varC1; ?>" />
																	<td align="center">C1/C</td>
																	<td align="center"><?php echo $tmp_stat3_varC>0?round(($tmp_stat3_varC1/$tmp_stat3_varC)*100,1):"0"; ?>%</td>
																</tr>
																<tr>
																	<td class="title_s" style="text-align:left;">Level 2 fall injury incidents(C2)</td>
																	<td align="center">
																		<?php
																		$db_c_4b = new DB;
																		$db_c_4b->query("SELECT * FROM `sixtarget_part3` WHERE `injurlv_3`='1' AND `date` LIKE '".$qdate2."%'");
																		if ($r_c_0['varC2']=="") { $tmp_stat3_varC2 = $db_c_4b->num_rows(); } else { $tmp_stat3_varC2 = $r_c_0['varC2']; }
																		?>
																		<input type="text" name="sixtarget_stat3_varC2" size="4" value="<?php echo $tmp_stat3_varC2; ?>" />
																		<td align="center">C2/C</td>
																		<td align="center"><?php echo $tmp_stat3_varC>0?round(($tmp_stat3_varC2/$tmp_stat3_varC)*100,1):"0"; ?>%</td>
																	</tr>
																	<tr>
																		<td class="title_s" style="text-align:left;">Level 3 fall injury incidents(C3)</td>
																		<td align="center">
																			<?php
																			$db_c_4c = new DB;
																			$db_c_4c->query("SELECT * FROM `sixtarget_part3` WHERE `injurlv_4`='1' AND `date` LIKE '".$qdate2."%'");
																			if ($r_c_0['varC3']=="") { $tmp_stat3_varC3 = $db_c_4c->num_rows(); } else { $tmp_stat3_varC3 = $r_c_0['varC3']; }
																			?>
																			<input type="text" name="sixtarget_stat3_varC3" size="4" value="<?php echo $tmp_stat3_varC3; ?>" />
																			<td align="center">C3/C</td>
																			<td align="center"><?php echo $tmp_stat3_varC>0?round(($tmp_stat3_varC3/$tmp_stat3_varC)*100,1):"0"; ?>%</td>
																		</tr>
																		<tr>
																			<td class="title_s" style="text-align:left;">Number of residents fall more than 1 time(D) --- Repeat falling ratio</td>
																			<td align="center">
																				<?php
																				$db_c_5 = new DB;
																				$db_c_5->query("SELECT COUNT(*) FROM ( SELECT COUNT(HospNo), HospNo FROM `sixtarget_part3` WHERE `date` LIKE '".$qdate2."/%' GROUP BY `HospNo` HAVING COUNT(HospNo)>1) t");
																				$r_c_5 = $db_c_5->fetch_assoc();
																				if ($r_c_0['varD']=="") { $tmp_stat3_varD = $r_c_5['COUNT(*)']; } else { $tmp_stat3_varD = $r_c_0['varD']; }
																				?>
																				<input type="text" name="sixtarget_stat3_varD" size="4" value="<?php echo $tmp_stat3_varD; ?>" />
																				<td align="center">D/B0</td>
																				<td align="center"><?php echo $tmp_stat3_varB0>0?round(($tmp_stat3_varD/$tmp_stat3_varB0)*100,1):"0"; ?>%</td>
																			</tr>
																		</table>
																		<table width="100%">
																			<tr>
																				<td class="title" colspan="3">PDCA analysis</td>
																			</tr>
																			<tr>
																				<td class="title_s" style="text-align:left;" width="260">Plan</td>
																				<td colspan="2"><textarea id="sixtarget_stat3_plan" name="sixtarget_stat3_plan" rows="4"><?php echo $r_c_0['plan']; ?></textarea></td>
																			</tr>
																			<tr>
																				<td class="title_s" style="text-align:left;">Execution (Do)</td>
																				<td colspan="2"><textarea id="sixtarget_stat3_do" name="sixtarget_stat3_do" rows="4"><?php echo $r_c_0['do']; ?></textarea></td>
																			</tr>
																			<tr>
																				<td class="title_s" style="text-align:left;">Review (Check)</td>
																				<td colspan="2"><textarea id="sixtarget_stat3_check" name="sixtarget_stat3_check" rows="4"><?php echo $r_c_0['check']; ?></textarea></td>
																			</tr>
																			<tr>
																				<td class="title_s" style="text-align:left;">Improvement plan develop and action (Action)</td>
																				<td colspan="2"><textarea id="sixtarget_stat3_action" name="sixtarget_stat3_action" rows="4"><?php echo $r_c_0['action']; ?></textarea></td>
																			</tr>
																		</table>
																		<table width="100%">
																			<tr <?php if ($qdate=="%") { echo 'style="display:none;"'; } ?>>
																				<td class="title"><input type="hidden" name="month" value="<?php echo $qdate; ?>" /><input type="hidden" name="tbname" value="part3" /><input type="submit" value="Save <?php echo $qdate2; ?> Statistics" class="printcol" /> <input type="submit" value="Recalculate latest data formula" name="resetstat" class="printcol" /></td>
																				<td colspan="3" class="title">Last modified date:<?php echo formatdate($r_c_0['savedate']); ?> Modified by:<?php echo checkusername($r_c_0['Qfiller']); ?></td>
																			</tr>
																		</table>
																	</form>
																</div>
																<!--跌倒季分析-->
																<div id="tab3_part3" style="display:none;">
																	<table class="content-query" style="font-size:10pt;page-break-after:always;">
																		<tr class="title">
																			<td width="36%">&nbsp;</td>
																			<td width="16%">Season 1 (Q1)</td>
																			<td width="16%">Season 2 (Q2)</td>
																			<td width="16%">Season 3 (Q3)</td>
																			<td width="16%">Season 4 (Q4)</td>
																		</tr>
																		<?php
																		$arrQTab3 = array('varA'=>'Monthly total resident days(A)','varB'=>'Fall incident(B) density','varBP'=>'Monthly fall occur % (B/A)','varB0'=>'Residents who have fallen history (B0)','varB1'=>'Fall occured due to health condition of residents(B1)','varB1P'=>'Fall occured due to health condition of residents ratio(B1/B)','varB2'=>'Fall occured due to medication or treatment(B2)','varB2P'=>'Fall occured due to medication or treatment ratio(B2/B)','varB3'=>'Fall occured due to enviromental risk(B3)','varB3P'=>'Fall occured due to enviromental risk ratio(B3/B)','varB4'=>'Fall occured due to other factor(B4)','varB4P'=>'Fall occured due to other factor ratio(B4/B)','varC'=>'Injury due to falling number(C)','varCP'=>'Fall injury ratio (C/B)','varC1'=>'Level 1 fall injury incidents(C1)','varC1P'=>'Level 1 fall injury incidents ratio(C1/C)','varC2'=>'Level 2 fall injury incidents(C2)','varC2P'=>'Level 2 fall injury incidents ratio(C2/C)','varC3'=>'Level 3 fall injury incidents(C3)','varC3P'=>'Level 3 fall injury incidents ratio(C3/C)','varD'=>'Number of residents fall more than 1 time(D)', 'varDP'=>'Repeat falling ratio (D/B0)');
																		foreach ($arrQTab3 as $ktab3 => $vtab3) {
																			?>
																			<tr>
																				<td class="title_s" style="font-size:9pt;"><?php echo $vtab3; ?></td>
																				<?php
																				foreach ($arrSeasonMonth as $k3=>$v3) {
																					$db3_3 = new DB;
																					$db3_3->query("SELECT `month`, `".str_replace("P","",$ktab3)."` AS '".str_replace("P","",$ktab3)."' FROM `sixtarget_part3_stat` WHERE `month`>='".$v3[0]."' AND `month`<='".$v3[1]."' ORDER BY `month` ASC");
																					if ($db3_3->num_rows()==0) {
																						echo '<td align="center"><center>---</center></td>';
																					} else {
																						for ($i3_3=0;$i3_3<$db3_3->num_rows();$i3_3++) {
																							$r3_3 = $db3_3->fetch_assoc();
																							${'arrPart3Tab3Tmp_'.$ktab3}[$k3][$i3_3] += $r3_3[str_replace("P","",$ktab3)];
																						}
																						if (substr($ktab3,strlen($ktab3)-1,1)=="P") {
																							if ($ktab3=="varBP") {
																								if (array_sum($arrPart3Tab3Tmp_varA[$k3])==0) {
																									${'statVar'.$ktab3} = 0;
																								} else {
																									${'statVar'.$ktab3} = round(((array_sum(${'arrPart3Tab3Tmp_'.str_replace("P", "", $ktab3)}[$k3])/3)/(array_sum($arrPart3Tab3Tmp_varA[$k3])/3))*100,2);
																								}
																								echo '<td align="center"><center>'.${'statVar'.$ktab3}.' %</center></td>';
																							} elseif ($ktab3=="varB1P" || $ktab3=="varB2P" || $ktab3=="varB3P" || $ktab3=="varB4P" || $ktab3=="varCP") {
																								if (array_sum($arrPart3Tab3Tmp_varB[$k3])==0) {
																									${'statVar'.$ktab3} = 0;
																								} else {
																									${'statVar'.$ktab3} = round(((array_sum(${'arrPart3Tab3Tmp_'.str_replace("P", "", $ktab3)}[$k3])/3)/(array_sum($arrPart3Tab3Tmp_varB[$k3])/3))*100,2);
																								}
																								echo '<td align="center"><center>'.${'statVar'.$ktab3}.' %</center></td>';
																							} elseif ($ktab3=="varC1P" || $ktab3=="varC2P" || $ktab3=="varC3P") {
																								if (array_sum($arrPart3Tab3Tmp_varC[$k3])==0) {
																									${'statVar'.$ktab3} = 0;
																								} else {
																									${'statVar'.$ktab3} = round(((array_sum(${'arrPart3Tab3Tmp_'.str_replace("P", "", $ktab3)}[$k3])/3)/(array_sum($arrPart3Tab3Tmp_varC[$k3])/3))*100,2);
																								}
																								echo '<td align="center"><center>'.${'statVar'.$ktab3}.' %</center></td>';
																							} elseif ($ktab3=="varDP") {
																								if (array_sum($arrPart3Tab3Tmp_varB0[$k3])==0) {
																									${'statVar'.$ktab3} = 0;
																								} else {
																									${'statVar'.$ktab3} = round(((array_sum(${'arrPart3Tab3Tmp_'.str_replace("P", "", $ktab3)}[$k3])/3)/(array_sum($arrPart3Tab3Tmp_varB0[$k3])/3))*100,2);
																								}
																								echo '<td align="center"><center>'.${'statVar'.$ktab3}.' %</center></td>';
																							}
																						} else {
																							if ($db3_3->num_rows()==0) {
																								$arraysum = 0;
																								$numrows = 1;
																							} else {
																								$arraysum = array_sum(${'arrPart3Tab3Tmp_'.$ktab3}[$k3]);
																								$numrows = 3;
																							}
																							echo '<td align="center"><center>'.round(($arraysum/$numrows),2).'</center></td>';
																						}
																					}
																				}
																				?>
																			</tr>
																			<?php
																		}
																		?>
																	</table>
																</div>
																<!--跌倒年度分析-->
																<div id="tab3_part4" style="display:none;">
																	<table class="content-query" style="page-break-after:always;">
																		<tr class="title">
																			<td width="22%">&nbsp;</td>
																			<?php
																			foreach ($arrPast12Months as $k1=>$v1) {
																				echo '<td width="6.5%">'.str_replace("/","<br>",$v1).'</td>';
																			}
																			?>
																		</tr>
																		<?php
																		foreach ($arrQTab3 as $ktab1 => $vtab1) {
																			?>
																			<tr>
																				<td class="title_s" style="font-size:10pt;"><?php echo $vtab1; ?></td>
																				<?php
																				foreach ($arrPast12Months as $k1=>$v1) {
																					$arrDateTab1Q = explode("/",$v1);
																					if (strlen($arrDateTab1Q[1])==1) { $monthofq31 = '0'.$arrDateTab1Q[1]; } else { $monthofq31 = $arrDateTab1Q[1]; }
																					$db3_1 = new DB;
																					$db3_1->query("SELECT `".str_replace("P","",$ktab1)."` FROM `sixtarget_part3_stat` WHERE `month`='".$arrDateTab1Q[0].$monthofq31."'");
																					$r3_1 = $db3_1->fetch_assoc();
																					if (${'stat3_'.$ktab1}!="") { ${'stat3_'.$ktab1} .= ', '; }
																					if (${'stat3_'.$ktab1.'_per'}!="") { ${'stat3_'.$ktab1.'_per'} .= ', '; }
																					$second1970 = mktime(0,0,0,$arrDateTab1Q[1],1,$arrDateTab1Q[0]);
																					$second1970ms = number_format(($second1970 * 1000), 0, '.', '');
																					if ($r3_1['varA']!='') { ${'totalpatientstat3A_'.$arrDateTab1Q[0].$monthofq31} = $r3_1['varA']; }
																					if ($r3_1['varB']!='') { ${'totalpatientstat3B_'.$arrDateTab1Q[0].$monthofq31} = $r3_1['varB']; }
																					if ($r3_1['varB0']!='') { ${'totalpatientstat3B0_'.$arrDateTab1Q[0].$monthofq31} = $r3_1['varB0']; }
																					if ($r3_1['varC']!='') { ${'totalpatientstat3C_'.$arrDateTab1Q[0].$monthofq31} = $r3_1['varC']; }
																					if ($db3_1->num_rows()==0) {
																						echo '<td align="center"><center>---</center></td>';
																						${'stat3_'.$ktab1} .= '["'.$second1970ms.'",0]';
																						${'stat3_'.$ktab1.'_per'} .= '["'.$second1970ms.'",0]';
																					} else {
																						echo '<td align="center"><center>';
																						if ($ktab1=="varBP") {
																							if (${'totalpatientstat3A_'.$arrDateTab1Q[0].$monthofq31}>0) {
																								echo round(($r3_1[str_replace("P","",$ktab1)]/${'totalpatientstat3A_'.$arrDateTab1Q[0].$monthofq31})*100,2)."%";
																								${'stat3_'.$ktab1.'_per'} .= '["'.$second1970ms.'",'.round(($r3_1[str_replace("P","",$ktab1)]/${'totalpatientstat3A_'.$arrDateTab1Q[0].$monthofq31})*100,1).']';
																							} else { echo '0%'; ${'stat3_'.$ktab1.'_per'} .= '["'.$second1970ms.'",0]'; }
																						} elseif ($ktab1=="varB1P" || $ktab1=="varB2P" || $ktab1=="varB3P" || $ktab1=="varB4P" || $ktab1=="varCP") {
																							if (${'totalpatientstat3B_'.$arrDateTab1Q[0].$monthofq31}>0) {
																								echo round(($r3_1[str_replace("P","",$ktab1)]/${'totalpatientstat3B_'.$arrDateTab1Q[0].$monthofq31})*100,3)."%";
																								${'stat3_'.$ktab1.'_per'} .= '["'.$second1970ms.'",'.round(($r3_1[str_replace("P","",$ktab1)]/${'totalpatientstat3B_'.$arrDateTab1Q[0].$monthofq31})*100,1).']';
																							} else { echo '0%'; ${'stat3_'.$ktab1.'_per'} .= '["'.$second1970ms.'",0]'; }
																						} elseif ($ktab1=="varC1P" || $ktab1=="varC2P" || $ktab1=="varC3P") {
																							if (${'totalpatientstat3C_'.$arrDateTab1Q[0].$monthofq31}>0) {
																								echo round(($r3_1[str_replace("P","",$ktab1)]/${'totalpatientstat3C_'.$arrDateTab1Q[0].$monthofq31})*100,3)."%";
																								${'stat3_'.$ktab1.'_per'} .= '["'.$second1970ms.'",'.round(($r3_1[str_replace("P","",$ktab1)]/${'totalpatientstat3C_'.$arrDateTab1Q[0].$monthofq31})*100,1).']';
																							} else { echo '0%'; ${'stat3_'.$ktab1.'_per'} .= '["'.$second1970ms.'",0]'; }
																						} elseif ($ktab1=="varDP") {
																							if (${'totalpatientstat3B0_'.$arrDateTab1Q[0].$monthofq31}>0) {
																								echo round(($r3_1[str_replace("P","",$ktab1)]/${'totalpatientstat3B0_'.$arrDateTab1Q[0].$monthofq31})*100,3)."%";
																								${'stat3_'.$ktab1.'_per'} .= '["'.$second1970ms.'",'.round(($r3_1[str_replace("P","",$ktab1)]/${'totalpatientstat3B0_'.$arrDateTab1Q[0].$monthofq31})*100,1).']';
																							} else { echo '0%'; ${'stat3_'.$ktab1.'_per'} .= '["'.$second1970ms.'",0]'; }
																						} else {
																							echo $r3_1[$ktab1];
																							${'stat3_'.$ktab1} .= '["'.$second1970ms.'","'.$r3_1[$ktab1].'"]';
																						}
																						echo '</center></td>';
																					}
		  //if ($r3_1[$ktab1]=="") { ${'stat3_'.$ktab1} .= '["'.$second1970ms.'",0]'; } else { ${'stat3_'.$ktab1} .= '["'.$second1970ms.'",'.$r3_1[$ktab1].']'; }
																				}
																				?>
																			</tr>
																			<?php
																		}
																		?>
																	</table><br><br>
																	<style>
																	#chart3a table {
																		width: auto;
																		left:780px;
																		position:relative;
																	}
																	#chart3a table tr {
																		background:none;
																		height:auto;
																		padding:0px;
																		margin:0px;
																	}
																	#chart3a table tr td { border:none; font-size:10pt; padding: 4px 0px; }
																	#chart3b table {
																		width: auto;
																		left:780px;
																		position:relative;
																	}
																	#chart3b table tr {
																		background:none;
																		height:auto;
																		padding:0px;
																		margin:0px;
																	}
																	#chart3b table tr td { border:none; font-size:10pt; padding: 4px 0px; }
																	#chart3c table {
																		width: auto;
																		left:780px;
																		position:relative;
																	}
																	#chart3c table tr {
																		background:none;
																		height:auto;
																		padding:0px;
																		margin:0px;
																	}
																	#chart3c table tr td { border:none; font-size:10pt; padding: 4px 0px; }
																	#chart3d table {
																		width: auto;
																		left:780px;
																		position:relative;
																	}
																	#chart3d table tr {
																		background:none;
																		height:auto;
																		padding:0px;
																		margin:0px;
																	}
																	#chart3d table tr td { border:none; font-size:10pt; padding: 4px 0px; }
																	#chart3e table {
																		width: auto;
																		left:780px;
																		position:relative;
																	}
																	#chart3e table tr {
																		background:none;
																		height:auto;
																		padding:0px;
																		margin:0px;
																	}
																	#chart3e table tr td { border:none; font-size:10pt; padding: 4px 0px; }
																	</style>
																	<h3><?php echo $arrDate[0]; ?> Annual severity of injury due to falling</h3>
																	<div id="chart3b" style="width:740px;height:420px; margin-left:40px; margin-top:50px; margin-bottom:50px; padding-top:50px; padding-bottom:50px; page-break-after:always;"></div><br /><br />
																	<h3><?php echo $arrDate[0]; ?> Annual repeat falling ratio</h3>
																	<div id="chart3c" style="width:740px;height:420px; margin-left:40px; margin-top:50px; margin-bottom:50px; padding-top:50px; padding-bottom:50px; page-break-after:always;"></div><br /><br />
																	<h3><?php echo $arrDate[0]; ?> Annual fall incidents/ratio</h3>
																	<div id="chart3d" style="width:740px;height:420px; margin-left:50px; margin-top:50px; margin-bottom:50px; padding-top:50px; padding-bottom:50px; page-break-after:always;"></div><br /><br />
																	<h3><?php echo $arrDate[0]; ?> Annual fall cause statistic</h3>
																	<div id="chart3a" style="width:740px;height:420px; margin-left:40px; margin-top:50px; margin-bottom:50px; padding-top:50px; padding-bottom:50px; page-break-after:always;"></div><br /><br />
																	<h3><?php echo $arrDate[0]; ?> Annual fall injury incident</h3>
																	<div id="chart3e" style="width:740px;height:420px; margin-left:40px; margin-top:50px; margin-bottom:50px; padding-top:50px; padding-bottom:50px;"></div><br /><br />
																	<script type="text/javascript">
																	$(function () {
																		$.plot($("#chart3a"), [
																			{ label: "Health condition(B1)",  data: [<?php echo $stat3_varB1; ?>], bars: {fillColor: "#edc240"}, color: "#edc240" },
																			{ label: "Medication or treatment(B2)",  data: [<?php echo $stat3_varB2; ?>], bars: {fillColor: "#afd8f8"}, color: "#afd8f8" },
																			{ label: "Enviromental risk(B3)",  data: [<?php echo $stat3_varB3; ?>], bars: {fillColor: "#cb4b16"}, color: "#cb4b16" },
																			{ label: "Other factor(B4)",  data: [<?php echo $stat3_varB4; ?>], bars: {fillColor: "#99EC41" }, color: "#99EC41" },
																			{ label: "Health condition ratio %(B1/B)",  data: [<?php echo $stat3_varB1P_per; ?>], lines: {show: true}, points: { show: true, symbol:"triangle" }, bars: {show: false},  color: "#edc240", yaxis:2 },
																			{ label: "Medication or treatment ratio%(B2/B)",  data: [<?php echo $stat3_varB2P_per; ?>], lines: {show: true}, points: { show: true, symbol:"cross" }, bars: {show: false},  color: "#afd8f8", yaxis:2 },
																			{ label: "Enviromental risk ratio%(B3/B)",  data: [<?php echo $stat3_varB3P_per; ?>], lines: {show: true}, points: { show: true, symbol:"square" }, bars: {show: false},  color: "#cb4b16", yaxis:2 },
																			{ label: "Fall occured due to other factor ratio %(B4/B)",  data: [<?php echo $stat3_varB4P_per; ?>], lines: {show: true}, points: { show: true, symbol:"diamond" }, bars: {show: false},  color: "#99EC41", yaxis:2 }
																			],
																			{
																				xaxis: { mode: "time", timeformat: "%y<br>%b", monthNames: [<?php for ($imonth=1;$imonth<=12;$imonth++) { if ($imonth>1) { echo ', '; } echo "'".$imonth."'"; } ?>], tickLength: 0, axisLabelUseCanvas: true, axisLabelFontSizePixels: 12, axisLabelFontFamily: "Verdana, Arial, Helvetica, Tahoma, sans-serif", axisLabelPadding: 5 },
																				yaxes: [
																				{tickSize: 1, tickDecimals: 0, position: 'left'},
																				{tickSize: 20, tickDecimals: 0, min:0, max:100, position: 'right'}
																				],
																				grid: { hoverable: true, clickable: false, borderWidth: 1 },
																				series: { shadowSize: 0, bars: { show: true, barWidth: 12*24*60*60*300, order: 1 } }
																			});

$.plot($("#chart3b"), [
	{ label: "Level 1 fall injury incidents<br>(C1)",  data: [<?php echo $stat3_varC1; ?>], bars: {fillColor: "#edc240"}, color: "#edc240" },
	{ label: "Level 2 fall injury incidents<br>(C2)",  data: [<?php echo $stat3_varC2; ?>], bars: {fillColor: "#afd8f8"}, color: "#afd8f8" },
	{ label: "Level 3 fall injury incidents<br>(C3)",  data: [<?php echo $stat3_varC3; ?>], bars: {fillColor: "#cb4b16"}, color: "#cb4b16" },
	{ label: "Level 1 fall injury incidents ratio %(C1/C)",  data: [<?php echo $stat3_varC1P_per; ?>], lines: {show: true}, points: { show: true, symbol:"triangle" }, bars: {show: false},  color: "#edc240", yaxis:2 },
	{ label: "Level 2 fall injury incidents ratio %(C2/C)",  data: [<?php echo $stat3_varC2P_per; ?>], lines: {show: true}, points: { show: true, symbol:"cross" }, bars: {show: false},  color: "#afd8f8", yaxis:2 },
	{ label: "Level 3 fall injury incidents ratio %(C3/C)",  data: [<?php echo $stat3_varC3P_per; ?>], lines: {show: true}, points: { show: true, symbol:"square" }, bars: {show: false},  color: "#cb4b16", yaxis:2 }
	],
	{
		xaxis: { mode: "time", timeformat: "%y<br>%b", monthNames: [<?php for ($imonth=1;$imonth<=12;$imonth++) { if ($imonth>1) { echo ', '; } echo "'".$imonth."'"; } ?>], tickLength: 0, axisLabelUseCanvas: true, axisLabelFontSizePixels: 12, axisLabelFontFamily: "Verdana, Arial, Helvetica, Tahoma, sans-serif", axisLabelPadding: 5 },
		yaxes: [
		{tickSize: 1, tickDecimals: 0, position: 'left'},
		{tickSize: 20, tickDecimals: 0, min:0, max:120, position: 'right'}
		],
		grid: { hoverable: true, clickable: false, borderWidth: 1 },
		series: { shadowSize: 0, bars: { show: true, barWidth: 12*24*60*60*300, order: 1 } }
	});
$.plot($("#chart3c"), [
	{ label: "Monthly fall incident<br>(B)",  data: [<?php echo $stat3_varB; ?>], bars: {fillColor: "#edc240"}, color: "#edc240" },
	{ label: "Number of residents fall more than 1 time (D)",  data: [<?php echo $stat3_varD; ?>], bars: {fillColor: "#afd8f8"}, color: "#afd8f8" },
	{ label: "Repeat falling ratio(D/B)",  data: [<?php echo $stat3_varDP_per; ?>], lines: {show: true}, points: { show: true, symbol:"triangle" }, bars: {show: false},  color: "#edc240", yaxis:2 }
	],
	{
		xaxis: { mode: "time", timeformat: "%y<br>%b", monthNames: [<?php for ($imonth=1;$imonth<=12;$imonth++) { if ($imonth>1) { echo ', '; } echo "'".$imonth."'"; } ?>], tickLength: 0, axisLabelUseCanvas: true, axisLabelFontSizePixels: 12, axisLabelFontFamily: "Verdana, Arial, Helvetica, Tahoma, sans-serif", axisLabelPadding: 5 },
		yaxes: [
		{tickSize: 1, tickDecimals: 0, position: 'left'},
		{tickSize: 20, tickDecimals: 0, min:0, max:120, position: 'right'}
		],
		grid: { hoverable: true, clickable: false, borderWidth: 1 },
		series: { shadowSize: 0, bars: { show: true, barWidth: 12*24*60*60*300, order: 1 } }
	});
$.plot($("#chart3d"), [
	{ label: "Monthly total resident days<br>(A)",  data: [<?php echo $stat3_varA; ?>], bars: {fillColor: "#cb4b16"}, color: "#cb4b16" },
	{ label: "Monthly fall incident<br>(B)",  data: [<?php echo $stat3_varB; ?>], bars: {fillColor: "#afd8f8"}, color: "#afd8f8" },
	{ label: "Monthly fall occur %<br>(B/A)",  data: [<?php echo $stat3_varBP_per; ?>], lines: {show: true}, points: { show: true, symbol:"triangle" }, bars: {show: false},  color: "#edc240", yaxis:2 }
	],
	{
		xaxis: { mode: "time", timeformat: "%y<br>%b", monthNames: [<?php for ($imonth=1;$imonth<=12;$imonth++) { if ($imonth>1) { echo ', '; } echo "'".$imonth."'"; } ?>], tickLength: 0, axisLabelUseCanvas: true, axisLabelFontSizePixels: 12, axisLabelFontFamily: "Verdana, Arial, Helvetica, Tahoma, sans-serif", axisLabelPadding: 5 },
		yaxes: [
		{tickSize: 200, tickDecimals: 0, position: 'left'},
		{tickSize: 0.05, tickDecimals: 2, min:0, position: 'right'}
		],
		grid: { hoverable: true, clickable: false, borderWidth: 1 },
		series: { shadowSize: 0, bars: { show: true, barWidth: 12*24*60*60*300, order: 1 } }
	});
$.plot($("#chart3e"), [
	{ label: "Monthly injury due to falling<br>Number(C)",  data: [<?php echo $stat3_varC; ?>], bars: {fillColor: "#cb4b16"}, color: "#cb4b16" },
	{ label: "跌倒造成傷害發生<br>率(C/B)",  data: [<?php echo $stat3_varCP_per; ?>], lines: {show: true}, points: { show: true, symbol:"triangle" }, bars: {show: false},  color: "#edc240", yaxis:2 }
	],
	{
		xaxis: { mode: "time", timeformat: "%y<br>%b", monthNames: [<?php for ($imonth=1;$imonth<=12;$imonth++) { if ($imonth>1) { echo ', '; } echo "'".$imonth."'"; } ?>], tickLength: 0, axisLabelUseCanvas: true, axisLabelFontSizePixels: 12, axisLabelFontFamily: "Verdana, Arial, Helvetica, Tahoma, sans-serif", axisLabelPadding: 5 },
		yaxes: [
		{tickSize: 1, tickDecimals: 0, position: 'left'},
		{tickSize: 10, tickDecimals: 0, min:0, max:100, position: 'right'}
		],
		grid: { hoverable: true, clickable: false, borderWidth: 1 },
		series: { shadowSize: 0, bars: { show: true, barWidth: 12*24*60*60*300, order: 1 } }
	});
var yaxisLabel = $("<div class='axisLabel yaxisLabel' style='position: absolute; left: -28px; top: -30px;'></div>").text("People").appendTo($('#chart3b'));
var yaxisLabel2 = $("<div class='axisLabel yaxisLabel' style='width:50px; position: absolute; left: 740px; top: -30px;'></div>").text("Rate").appendTo($('#chart3b'));
var xaxisLabel = $("<div class='axisLabel xaxisLabel' style='position: absolute; left:400px; bottom: -50px;'></div>").text(" month").appendTo($('#chart3b'));
var yaxisLabel = $("<div class='axisLabel yaxisLabel' style='position: absolute; left: -28px; top: -30px;'></div>").text("People").appendTo($('#chart3a'));
var yaxisLabel2 = $("<div class='axisLabel yaxisLabel' style='width:50px; position: absolute; left: 740px; top: -30px;'></div>").text("Rate").appendTo($('#chart3a'));
var xaxisLabel = $("<div class='axisLabel xaxisLabel' style='position: absolute; left:400px; bottom: -50px;'></div>").text(" month").appendTo($('#chart3a'));
var yaxisLabel = $("<div class='axisLabel yaxisLabel' style='position: absolute; left: -28px; top: -30px;'></div>").text("People").appendTo($('#chart3c'));
var yaxisLabel2 = $("<div class='axisLabel yaxisLabel' style='width:50px; position: absolute; left: 740px; top: -30px;'></div>").text("Rate").appendTo($('#chart3c'));
var xaxisLabel = $("<div class='axisLabel xaxisLabel' style='position: absolute; left:400px; bottom: -50px;'></div>").text(" month").appendTo($('#chart3c'));
var yaxisLabel = $("<div class='axisLabel yaxisLabel' style='position: absolute; left: -28px; top: -30px;'></div>").text("Total people*day").appendTo($('#chart3d'));
var yaxisLabel2 = $("<div class='axisLabel yaxisLabel' style='width:50px; position: absolute; left: 740px; top: -30px;'></div>").text("Rate").appendTo($('#chart3d'));
var xaxisLabel = $("<div class='axisLabel xaxisLabel' style='position: absolute; left:400px; bottom: -50px;'></div>").text(" month").appendTo($('#chart3d'));
var yaxisLabel = $("<div class='axisLabel yaxisLabel' style='position: absolute; left: -28px; top: -30px;'></div>").text("Number").appendTo($('#chart3e'));
var yaxisLabel2 = $("<div class='axisLabel yaxisLabel' style='width:50px; position: absolute; left: 740px; top: -30px;'></div>").text("Rate").appendTo($('#chart3e'));
var xaxisLabel = $("<div class='axisLabel xaxisLabel' style='position: absolute; left:400px; bottom: -50px;'></div>").text(" month").appendTo($('#chart3e'));
});
</script>
</div>
</div>
</center>
<!--Infection-->
<center>
<div id="tab4" style="font-size:11pt;">
	<h3>Infection statistic</h3>
	<div align="center" style="margin-bottom:10px;">
		<?php echo draw_option("tab4option","Current month record;Current month statistic;3 months(seasonal) analysis;Annual analysis","xl","single",1,false,5); ?>
	</div>
	<div align="center">
		<button type="button" id="newrecord4" title="Infection record log" onclick="openVerificationForm('#dialog-form4');"><i class="fa fa-user-plus fa-2x fa-fw"></i><br>Add new data</button>
		<div class="patlistbtn" style="background-color:rgb(149,219,208); width:100px;"><a href="index.php?mod=management&func=formview&id=3d_1&type=4<?php echo $sMonth;?>" title="逐案分析列表"><i class="fa fa-list fa-2x fa-fw"></i><br>Case-by-case analysis</a></div>
		<div class="patlistbtn" style="background-color:rgb(149,219,208);"><a href="#" onclick="printDialog('4', '<?php echo $_GET['qdate']; ?>');" title="Print report"><i class="fa fa-print fa-2x fa-fw"></i><br>Print report</a></div>
	</div>
	<script>
	$(function() {
		$( "#dialog-form4" ).dialog({
			autoOpen: false,
			height: 600,
			width: 900,
			modal: true,
			buttons: {
				"Add record": function() {
					if ($("#HospNo_tab4").val()=="") {
						alert("請先填寫住民資料");
						$("#HospNo_tab4").focus();
					} else {
						$.ajax({
							url: "class/sixtarget_part4.php",
							type: "POST",
							data: { 'HospNo': $('#HospNo_tab4').val(), 'Name': $('#Name_tab4').val(), 'date': $('#date_tab4').val(), 'InfectType': $('#InfectType').val(), 'Q1_A_1_1': $('#Q1_A_1_1').val(), 'Q1_A_1_2': $('#Q1_A_1_2').val(), 'Q1_A_1_3': $('#Q1_A_1_3').val(), 'Q1_A_1_4': $('#Q1_A_1_4').val(), 'Q1_A_1_5': $('#Q1_A_1_5').val(), 'Q1_A_2_1': $('#Q1_A_2_1').val(), 'Q1_A_2_2': $('#Q1_A_2_2').val(), 'Q1_A_2_3': $('#Q1_A_2_3').val(), 'Q1_A_2_4': $('#Q1_A_2_4').val(), 'Q1_A_2_4_date': $('#Q1_A_2_4_date').val(), 'Q1_date': $('#Q1_date').val(), 'Q1_B_1': $('#Q1_B_1').val(), 'Q1_B_2': $('#Q1_B_2').val(), 'Q1_B_3': $('#Q1_B_3').val(), 'Q1_B_4': $('#Q1_B_4').val(), 'Q1_B_5': $('#Q1_B_5').val(), 'Q1_B_6': $('#Q1_B_6').val(), 'Q1_B_7': $('#Q1_B_7').val(), 'Q1_B_8': $('#Q1_B_8').val(), 'Q1_C_1': $('#Q1_C_1').val(), 'Q1_C_2': $('#Q1_C_2').val(), 'Q1_C_3': $('#Q1_C_3').val(), 'Q1_C_4': $('#Q1_C_4').val(), 'Q1_memo': $('#Q1_memo').val(), 'Q2_A_1_1': $('#Q2_A_1_1').val(), 'Q2_A_1_2': $('#Q2_A_1_2').val(), 'Q2_A_1_3': $('#Q2_A_1_3').val(), 'Q2_A_1_4': $('#Q2_A_1_4').val(), 'Q2_A_1_5': $('#Q2_A_1_5').val(), 'Q2_A_2_1': $('#Q2_A_2_1').val(), 'Q2_A_2_2': $('#Q2_A_2_2').val(), 'Q2_A_2_3': $('#Q2_A_2_3').val(), 'Q2_A_2_4': $('#Q2_A_2_4').val(), 'Q2_A_2_5': $('#Q2_A_2_5').val(), 'Q2_A_2_6': $('#Q2_A_2_6').val(), 'Q2_A_3_1': $('#Q2_A_3_1').val(), 'Q2_A_3_2': $('#Q2_A_3_2').val(), 'Q2_A_3_3': $('#Q2_A_3_3').val(), 'Q2_A_3_4': $('#Q2_A_3_4').val(), 'Q2_A_3_5': $('#Q2_A_3_5').val(), 'Q2_A_3_6': $('#Q2_A_3_6').val(), 'Q2_A_3_7': $('#Q2_A_3_7').val(), 'Q2_A_3_8': $('#Q2_A_3_8').val(), 'Q2_A_3_9': $('#Q2_A_3_9').val(), 'Q2_B_1': $('#Q2_B_1').val(), 'Q2_B_2': $('#Q2_B_2').val(), 'Q2_B_3': $('#Q2_B_3').val(), 'Q2_B_4': $('#Q2_B_4').val(), 'Q2_B_5': $('#Q2_B_5').val(), 'Q2_B_6': $('#Q2_B_6').val(), 'Q2_B_7': $('#Q2_B_7').val(), 'Q2_B_8': $('#Q2_B_8').val(), 'Q2_B_9': $('#Q2_B_9').val(), 'Q2_B_10': $('#Q2_B_10').val(), 'Q2_B_11': $('#Q2_B_11').val(), 'Q2_C_1': $('#Q2_C_1').val(), 'Q2_C_2': $('#Q2_C_2').val(), 'Q2_memo': $('#Q2_memo').val(), 'Q3_A_1_1': $('#Q3_A_1_1').val(), 'Q3_A_1_2': $('#Q3_A_1_2').val(), 'Q3_A_1_3': $('#Q3_A_1_3').val(), 'Q3_A_1_4': $('#Q3_A_1_4').val(), 'Q3_A_1_5': $('#Q3_A_1_5').val(), 'Q3_A_1_6': $('#Q3_A_1_6').val(), 'Q3_A_1_7': $('#Q3_A_1_7').val(), 'Q3_A_1_8': $('#Q3_A_1_8').val(), 'Q3_A_2_1': $('#Q3_A_2_1').val(), 'Q3_A_2_2': $('#Q3_A_2_2').val(), 'Q3_A_2_3': $('#Q3_A_2_3').val(), 'Q3_date': $('#Q3_date').val(), 'Q3_B_1': $('#Q3_B_1').val(), 'Q3_B_2': $('#Q3_B_2').val(), 'Q3_B_3': $('#Q3_B_3').val(), 'Q3_B_4': $('#Q3_B_4').val(), 'Q3_B_5': $('#Q3_B_5').val(), 'Q3_B_6': $('#Q3_B_6').val(), 'Q3_B_7': $('#Q3_B_7').val(), 'Q3_B_8': $('#Q3_B_8').val(), 'Q3_B_9': $('#Q3_B_9').val(), 'Q3_B_10': $('#Q3_B_10').val(), 'Q3_B_11': $('#Q3_B_11').val(), 'Q3_C_1': $('#Q3_C_1').val(), 'Q3_C_2': $('#Q3_C_2').val(), 'Q3_memo': $('#Q3_memo').val(), 'Q4_A_1': $('#Q4_A_1').val(), 'Q4_A_2': $('#Q4_A_2').val(), 'Q4_A_3': $('#Q4_A_3').val(), 'Q4_A_4': $('#Q4_A_4').val(), 'Q4_A_5': $('#Q4_A_5').val(), 'Q4_A_6': $('#Q4_A_6').val(), 'Q4_date': $('#Q4_date').val(), 'Q4_B_1': $('#Q4_B_1').val(), 'Q4_B_2': $('#Q4_B_2').val(), 'Q4_B_3': $('#Q4_B_3').val(), 'Q4_B_4': $('#Q4_B_4').val(), 'Q4_B_5': $('#Q4_B_5').val(), 'Q4_B_6': $('#Q4_B_6').val(), 'Q4_B_7': $('#Q4_B_7').val(), 'Q4_C_1': $('#Q4_C_1').val(), 'Q4_memo': $('#Q4_memo').val(), 'Q5_A_1_1': $('#Q5_A_1_1').val(), 'Q5_A_1_2': $('#Q5_A_1_2').val(), 'Q5_A_2_1': $('#Q5_A_2_1').val(), 'Q5_A_2_2': $('#Q5_A_2_2').val(), 'Q5_date': $('#Q5_date').val(), 'Q5_B_1': $('#Q5_B_1').val(), 'Q5_B_2': $('#Q5_B_2').val(), 'Q5_B_3': $('#Q5_B_3').val(), 'Q5_C_1': $('#Q5_C_1').val(), 'Q5_memo': $('#Q5_memo').val(), 'Q6_A_1_1': $('#Q6_A_1_1').val(), 'Q6_A_1_2': $('#Q6_A_1_2').val(), 'Q6_memo': $('#Q6_memo').val(), 'Q7_A_3_1': $('#Q7_A_3_1').val(), 'Q7_A_3_2': $('#Q7_A_3_2').val(), 'Q7_A_3_3': $('#Q7_A_3_3').val(), 'Q7_A_3_4': $('#Q7_A_3_4').val(), 'Q7_A_3_5': $('#Q7_A_3_5').val(), 'Q7_A_3_6': $('#Q7_A_3_6').val(), 'Q7_A_3_7': $('#Q7_A_3_7').val(), 'Q7_A_3_8': $('#Q7_A_3_8').val(), 'Q7_A_3_9': $('#Q7_A_3_9').val(), 'Q7_B_1': $('#Q7_B_1').val(), 'Q7_B_2': $('#Q7_B_2').val(), 'Q7_B_3': $('#Q7_B_3').val(), 'Q7_B_4': $('#Q7_B_4').val(), 'Q7_B_5': $('#Q7_B_5').val(), 'Q7_B_6': $('#Q7_B_6').val(), 'Q7_B_7': $('#Q7_B_7').val(), 'Q7_B_8': $('#Q7_B_8').val(), 'Q7_B_9': $('#Q7_B_9').val(), 'Q7_B_10': $('#Q7_B_10').val(), 'Q7_B_11': $('#Q7_B_11').val(), 'Q7_C_1': $('#Q7_C_1').val(), 'Q7_C_2': $('#Q7_C_2').val(), 'Q7_memo': $('#Q7_memo').val(), 'Qfiller': $('#Qfiller').val() },
							success: function(data) {
								$( "#dialog-form4" ).dialog( "close" );
								alert("Add record sucessfully!");
								window.location.reload();
							}
						});
}
},
"Cancel": function() {
	$( "#dialog-form4" ).dialog( "close" );
}
}
});
});
</script>
<div id="dialog-form4" title="Infection record log" class="dialog-form"> 
	<script>
	function changepart4ques(indexno) {
		for (var i=1;i<=5;i++) {
			document.getElementById('quesdiv'+i).style.display = "none";
		}
		document.getElementById('quesdiv'+indexno).style.display = "block";
	}
	</script>
	<form id="form4">
		<fieldset>
			<table>
				<tr>
					<td class="title">Search</td>
					<td colspan="7">
						&nbsp;<span style="padding:3px; border:1px solid #999; color:#666; font-size:10pt;">Care ID#</span> <input type="text" name="HospNo" id="HospNo_tab4" value="" size="8">&nbsp;
						<span style="padding:3px; background:#69b3b6; color:#fff; font-size:10pt;">or</span>&nbsp;
						<span style="padding:3px; border:1px solid #999; color:#666; font-size:10pt;">Full name</span> <input type="text" name="Name" id="Name_tab4" size="8">&nbsp;
						<span style="padding:3px; background:#69b3b6; color:#fff; font-size:10pt;">or</span>&nbsp;
						<span style="padding:3px; border:1px solid #999; color:#666; font-size:10pt;">Bed #</span> <input type="text" name="BedID" id="BedID_tab4" size="8">&nbsp;
						<input type="button" value="Search" id="search_tab4" onclick="loadPatInfo('tab4')" />
						<input type="button" value="Empty" id="clear_tab4" onclick="cleartab('4')" style="display:none;" /></td>
					</tr>
					<tr>
						<td class="title">Date</td>
						<td><script> $(function() { $( "#date_tab4").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date_tab4" id="date_tab4" value="<?php echo date(Y."/".m."/".d); ?>"></td>
						<td class="title">Type of infection</td>
						<td colspan="5">
							<select name="InfectType" id="InfectType" onchange="changepart4ques(this.selectedIndex);">
								<option></option>
								<option value="1">Urinary tract infection(UTI)</option>
								<option value="2">Respiratory tract infection (RTI)</option>
								<option value="3">Skin infection</option>
								<option value="4">Gastrointestinal infections</option>
								<option value="5">Ear, eye, nose and mouth infection </option>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="8">
							<div id="quesdiv1" style="display:none;">
								<h3>Urinary tract infection(UTI)</h3>
								<table width="820" cellpadding="0" cellspacing="0">
									<tr>
										<td bgcolor="#6699CC" colspan="2" height="30"><font color="#ffffff">Symptoms</font></td>
									</tr>
									<tr>
										<td valign="top">(1) Not on foley (at least 3)<br /><?php echo draw_checkbox("Q1_A_1","1. Temperature ≥38ºC(100ºF) or feeling chills;2. Urethral burning sensation, urinary frequency or urgently;3. bladder area or lower back pain;4. Urine characteristic changes;5. Worsening mental or physical function",$Q1_A_1,"multi"); ?></td>
										<td valign="top">(2)Is on foley (at least 2)<br /><?php echo draw_checkbox("Q1_A_2","1. Temperature ≥38ºC(100ºF) or feeling chills;2. Bladder area or lower back pain;3. The changing status of urine (such as urine becomes turbid , malodorous, or has blood in the urine, etc.);4. Worsening mental or physical function",$Q1_A_2,"multi"); ?><br />Date of last catheter replacement:<script> $(function() { $( "#Q1_A_2_4_date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="Q1_A_2_4_date" id="Q1_A_2_4_date" value="<?php echo date(Y."/".m."/".d); ?>"></td>
									</tr>
									<tr>
										<td colspan="2">Visit outpatient clinic when suspected infection：<script> $(function() { $( "#Q1_date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="Q1_date" id="Q1_date" value="<?php echo date(Y."/".m."/".d); ?>"></td>
									</tr>
									<tr>
										<td bgcolor="#6699CC" colspan="2" height="30"><font color="#ffffff">Care measures</font></td>
									</tr>
									<tr>
										<td colspan="2"><?php echo draw_checkbox("Q1_B","Monitor temperature changes QID;Monitor urine test results;Monitor antibiotic treatment results;Increased water intake to 2000.c.c(68 fl oz) /day;Empty the bladder as much as possible - such as Q2H toileting, intermittent catheterization;Teach and assist in maintaining the vulva clean and hygiene;Correct indwelling catheter care;Replace the catheter",$Q1_B,"multi"); ?></td>
									</tr>
									<tr>
										<td bgcolor="#6699CC" colspan="2" height="30"><font color="#ffffff">Improvement tracking</font></td>
									</tr>
									<tr>
										<td colspan="2"><?php echo draw_checkbox("Q1_C","Clear urine and improvement in odor;Normal body temperature;Continue to track;Mental or functional improvement",$Q1_C,"multi"); ?></td>
									</tr>
									<tr>
										<td bgcolor="#6699CC" colspan="2" height="30"><font color="#ffffff">Note(s):</font><input type="text" name="Q1_memo" id="Q1_memo" size="80"></td>
									</tr>
								</table>
							</div>
							<div id="quesdiv2" style="display:none;">
								<h3>Respiratory tract infection (RTI)</h3>
								<table width="820" cellpadding="0" cellspacing="0">
									<tr>
										<td bgcolor="#6699CC" colspan="2" height="30"><font color="#ffffff">Symptoms</font></td>
									</tr>
									<tr>
										<td valign="top">(1) The common cold syndrome (at least 2)<br /><?php echo draw_checkbox("Q2_A_1","1. Runny nose or sneezing;2. Stuffy nose;3. Sore throat, hoarse, or difficulty swallowing;4. Dry cough;5. Swollen glands in the neck or allergies",$Q2_A_1,"multi"); ?><font size="2">Note: not necessarily having a fever, but the symptoms must be newly created.</font></td>
										<td valign="top">(2) Influenza (at least 3)<br /><?php echo draw_checkbox("Q2_A_2","1. Chills;2. New generated headache or eye pain symptom;3. Muscle pain;4. Physical discomfort or loss of appetite;5. Sore throat;6. Cough newly created or worsening",$Q1_A_2,"multi"); ?><font size="2">Note: This diagnosis must be at epidemic season (late fall to early spring each year)</font></td>
									</tr>
									<tr>
										<td colspan="2">(3) Other lower respiratory tract infections - tracheitis and bronchitis (at least 3 categories)<br /><?php echo draw_checkbox("Q2_A_3","1. Newly generated cough;2. Body temperature higher than 38ºC (100ºF);3. Produce sputum;4. Sternocostal pain;5. New breath sounds found in chest physical examination (e.g. rales rhonchi wheezing bronchial-breathing);6. With one of the following changes in the state of dyspnea;　　a. Newly appeared shortness of breath;　　b. Respiratory> 25 time/minute;　　c. Worsening mental or physical function",$Q2_A_3,"multi"); ?></td>
									</tr>
									<tr>
										<td bgcolor="#6699CC" colspan="2" height="30"><font color="#ffffff">Care measures</font></td>
									</tr>
									<tr>
										<td colspan="2"><?php echo draw_checkbox("Q2_B","Monitoring vital sign changes QID;Monitoring results of medication;Raising the headboard 30 degree when lying;Turning over and chest percussion Q2H;Nebulization therapy to improve coughing/suction efficiency;Adequate water intake;Enhance oral care;Evaluate the ability to chew and swallow;Nutritional support to enhance immunity;Oxygen therapy;Postural drainage",$Q2_B,"multi"); ?></td>
									</tr>
									<tr>
										<td bgcolor="#6699CC" colspan="2" height="30"><font color="#ffffff">Improvement tracking</font></td>
									</tr>
									<tr>
										<td colspan="2"><?php echo draw_checkbox("Q2_C","Symptoms improved;Hospitalization",$Q2_C,"multi"); ?></td>
									</tr>
									<tr>
										<td bgcolor="#6699CC" colspan="2" height="30"><font color="#ffffff">Note(s):</font><input type="text" name="Q2_memo" id="Q2_memo" size="80"></td>
									</tr>
								</table>
							</div>
							<div id="quesdiv3" style="display:none;">
								<h3>Skin infection</h3>
								<table width="820" cellpadding="0" cellspacing="0">
									<tr>
										<td bgcolor="#6699CC" colspan="2" height="30"><font color="#ffffff">Symptoms</font></td>
									</tr>
									<tr>
										<td valign="top">(1)Cellulitis, pressure sores, wound infection (at least one)<br /><?php echo draw_checkbox("Q3_A_1","1. Pus;2. At least 4 symptoms;　　a. Fever;　　b. Reddish;　　c. Swollen;　　d. Tenderness pain;　　e. Worsening mental or physical function;　　f. Serous secretion",$Q3_A_1,"multi"); ?></td>
										<td valign="top">(2)Other skin infections<br /><?php echo draw_checkbox("Q3_A_2","1. Blisters;2. Papules;3. Itchy skin",$Q3_A_2,"multi"); ?></td>
									</tr>
									<tr>
										<td colspan="2">Visit outpatient clinic when suspected infection：<script> $(function() { $( "#Q3_date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="Q3_date" id="Q3_date" value="<?php echo date(Y."/".m."/".d); ?>"></td>
									</tr>
									<tr>
										<td bgcolor="#6699CC" colspan="2" height="30"><font color="#ffffff">Care measures</font></td>
									</tr>
									<tr>
										<td colspan="2"><?php echo draw_checkbox("Q3_B","Intermittent icing 20 minutes/time QID;Raising wounded limb;Maintaining clean skin;Moisturizing the dried skin;Wound assessment and dressing medication;Prevention of oppression on abnormal skin;Turn over Q2H;monitoring results of medication treatment;Adequate nutrition;Applying air bed and air cushion;Checking hemoglobin, albumin",$Q3_B,"multi"); ?></td>
									</tr>
									<tr>
										<td bgcolor="#6699CC" colspan="2" height="30"><font color="#ffffff">Improvement tracking</font></td>
									</tr>
									<tr>
										<td colspan="2"><?php echo draw_checkbox("Q3_C","Skin recovered;Hospitalization",$Q3_C,"multi"); ?></td>
									</tr>
									<tr>
										<td bgcolor="#6699CC" colspan="2" height="30"><font color="#ffffff">Note(s):</font><input type="text" name="Q3_memo" id="Q3_memo" size="80"></td>
									</tr>
								</table>
							</div>
							<div id="quesdiv4" style="display:none;">
								<h3>Gastrointestinal infections</h3>
								<table width="820" cellpadding="0" cellspacing="0">
									<tr>
										<td bgcolor="#6699CC" colspan="2" height="30"><font color="#ffffff">Symptoms</font></td>
									</tr>
									<tr>
										<td colspan="2">At least 1<br /><?php echo draw_checkbox("Q4_A","1. Having diarrhea two or more times per day;2. Vomiting two or more times per day;3. At least 1 following symptom;　　a. Vomiting;　　b. Abdominal pain;　　c. Diarrhea",$Q4_A,"multi"); ?></td>
									</tr>
									<tr>
										<td colspan="2">Visit outpatient clinic when suspected infection：<script> $(function() { $( "#Q4_date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="Q4_date" id="Q4_date" value="<?php echo date(Y."/".m."/".d); ?>"></td>
									</tr>
									<tr>
										<td bgcolor="#6699CC" colspan="2" height="30"><font color="#ffffff">Care measures</font></td>
									</tr>
									<tr>
										<td colspan="2"><?php echo draw_checkbox("Q4_B","Adequate water intake;Maintaining electrolyte balanced;Review resident's medication;Close observation of the skin status at buttocks;Monitoring results of medication;Monitoring changes in body weight;Light diet",$Q4_B,"multi"); ?></td>
									</tr>
									<tr>
										<td bgcolor="#6699CC" colspan="2" height="30"><font color="#ffffff">Improvement tracking</font></td>
									</tr>
									<tr>
										<td colspan="2"><?php echo draw_checkbox("Q4_C","The number of loose stools is reduced",$Q4_C,"multi"); ?></td>
									</tr>
									<tr>
										<td bgcolor="#6699CC" colspan="2" height="30"><font color="#ffffff">Note(s):</font><input type="text" name="Q4_memo" id="Q4_memo" size="80"></td>
									</tr>
								</table>
							</div>
							<div id="quesdiv5" style="display:none;">
								<h3>Ear, eye, nose and mouth infection </h3>
								<table width="820" cellpadding="0" cellspacing="0">
									<tr>
										<td bgcolor="#6699CC" colspan="2" height="30"><font color="#ffffff">Symptoms</font></td>
									</tr>
									<tr>
										<td valign="top">(1)Conjunctivitis (match 1)<br /><?php echo draw_checkbox("Q5_A_1","1. Pus appear in one or both eyes within 24 hours;2. New conjunctival redness (whether or itching sensation) for at least 24 hours",$Q5_A_1,"multi"); ?></td>
										<td valign="top">(2)Ear Infection (match 1)<br /><?php echo draw_checkbox("Q5_A_2","1. Physician's diagnosis;2. New secretions in 1 ear or both ears",$Q5_A_2,"multi"); ?></td>
									</tr>
									<tr>
										<td colspan="2">Visit outpatient clinic when suspected infection：<script> $(function() { $( "#Q5_date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="Q5_date" id="Q5_date" value="<?php echo date(Y."/".m."/".d); ?>"></td>
									</tr>
									<tr>
										<td bgcolor="#6699CC" colspan="2" height="30"><font color="#ffffff">Care measures</font></td>
									</tr>
									<tr>
										<td colspan="2"><?php echo draw_checkbox("Q5_B","Keep the affected area clean;Contact isolation;monitoring results of medication treatment",$Q5_B,"multi"); ?></td>
									</tr>
									<tr>
										<td bgcolor="#6699CC" colspan="2" height="30"><font color="#ffffff">Improvement tracking</font></td>
									</tr>
									<tr>
										<td colspan="2"><?php echo draw_checkbox("Q5_C","Secretions decrease",$Q5_C,"multi"); ?></td>
									</tr>
									<tr>
										<td bgcolor="#6699CC" colspan="2" height="30"><font color="#ffffff">Note(s):</font><input type="text" name="Q5_memo" id="Q5_memo" size="80"></td>
									</tr>
								</table>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="8">
							<input type="hidden" name="Qfiller" id="Qfiller" value="<?php echo $_SESSION['ncareID_lwj']; ?>">
						</td>
					</tr>
				</table>
			</fieldset>
		</form>
	</div>
	<script>
	$('#btn_tab4option_1').click(function() {
		$('#tab4_part1').show();
		$('#tab4_part2').hide();
		$('#tab4_part3').hide();
		$('#tab4_part4').hide();
	});
	$('#btn_tab4option_2').click(function() {
		$('#tab4_part1').hide();
		$('#tab4_part2').show();
		$('#tab4_part3').hide();
		$('#tab4_part4').hide();
	});
	$('#btn_tab4option_3').click(function() {
		$('#tab4_part1').hide();
		$('#tab4_part2').hide();
		$('#tab4_part3').show();
		$('#tab4_part4').hide();
	});
	$('#btn_tab4option_4').click(function() {
		$('#tab4_part1').hide();
		$('#tab4_part2').hide();
		$('#tab4_part3').hide();
		$('#tab4_part4').show();
	});
	$(function() { $('#tform4').validationEngine(); });
	</script>
	<!--感染資料列表-->
	<div id="tab4_part1">
		<form id="tform4" action="index.php?mod=management&func=formview&id=3d_2&type=4<?php echo $sMonth; ?>" method="post">
			<table class="content-query" style="font-size:10pt; font-weight:normal;">
				<tr class="title">
					<td class="printcol">View</td>
					<td align="center">Care ID#</td>
					<td align="center">Full name</td>
					<td align="center">Date</td>
					<td align="center">Type of infection</td>
					<td align="center">Infection status</td>
					<td class="printcol">Case-by-case analysis</td>
					<td class="printcol">Delete</td>
				</tr>
				<?php
				$dbp1_4 = new DB;
				$dbp1_4->query("SELECT * FROM  `sixtarget_part4`  WHERE `date` LIKE '".$qdate2."%'");
				if ($dbp1_4->num_rows()==0) {
					?>
					<tr>
						<td colspan="8"><center>-------Yet no data of this month-------</center></td>
					</tr>
					<script>$(function() { $('#analysis4').hide(); });</script>
					<?php
				} else {
					for ($p1_i4=0;$p1_i4<$dbp1_4->num_rows();$p1_i4++) {
						$rp1_4 =$dbp1_4->fetch_assoc();
						/*== 解 START ==*/
						$rsa = new lwj('lwj/lwj');
						$puepart = explode(" ",$rp1_4['Name']);
						$puepartcount = count($puepart);
						if($puepartcount>1){
							for($j=0;$j<$puepartcount;$j++){
								$prdpart = $rsa->privDecrypt($puepart[$j]);
								$rp1_4['Name'] = $rp1_4['Name'].$prdpart;
							}
						}else{
							$rp1_4['Name'] = $rsa->privDecrypt($rp1_4['Name']);
						}
						/*== 解 END ==*/
						$InfectType = '';
						$InfectType2 = '';
						$InfectType_a = 0;
						$InfectType_b = 0;
						$InfectType_c = 0;
						if ($rp1_4['InfectType']==1) {
							$InfectType2 .= 'Urinary tract infection(UTI)';
							if ($rp1_4['Q1_A_1_1']==1 || $rp1_4['Q1_A_1_2']==1 || $rp1_4['Q1_A_1_3']==1 || $rp1_4['Q1_A_1_4']==1 || $rp1_4['Q1_A_1_5']==1) { $InfectType .= "No usage of catheter"; }
							if ($rp1_4['Q1_A_2_1']==1 || $rp1_4['Q1_A_2_2']==1 || $rp1_4['Q1_A_2_3']==1 || $rp1_4['Q1_A_2_4']==1) { $InfectType .= "Usage of catheter"; }
						} elseif ($rp1_4['InfectType']==2) {
							$InfectType2 .= 'Respiratory tract infection (RTI)';
							if ($rp1_4['Q2_A_1_1']==1 || $rp1_4['Q2_A_1_2']==1 || $rp1_4['Q2_A_1_3']==1 || $rp1_4['Q2_A_1_4']==1 || $rp1_4['Q2_A_1_5']==1) {
								if ($rp1_4['Q2_A_1_1']==1) { $InfectType_a++; }
								if ($rp1_4['Q2_A_1_2']==1) { $InfectType_a++; }
								if ($rp1_4['Q2_A_1_3']==1) { $InfectType_a++; }
								if ($rp1_4['Q2_A_1_4']==1) { $InfectType_a++; }
								if ($rp1_4['Q2_A_1_5']==1) { $InfectType_a++; }
								if ($InfectType_a>=2) { if ($InfectType!="") { $InfectType .= "、"; } $InfectType .= "Common cold"; }
							}
							if ($rp1_4['Q2_A_2_1']==1 || $rp1_4['Q2_A_2_2']==1 || $rp1_4['Q2_A_2_3']==1 || $rp1_4['Q2_A_2_4']==1 || $rp1_4['Q2_A_2_5']==1 || $rp1_4['Q2_A_2_6']==1) {
								if ($rp1_4['Q2_A_2_1']==1) { $InfectType_b++; }
								if ($rp1_4['Q2_A_2_2']==1) { $InfectType_b++; }
								if ($rp1_4['Q2_A_2_3']==1) { $InfectType_b++; }
								if ($rp1_4['Q2_A_2_4']==1) { $InfectType_b++; }
								if ($rp1_4['Q2_A_2_5']==1) { $InfectType_b++; }
								if ($rp1_4['Q2_A_2_6']==1) { $InfectType_b++; }
								if ($InfectType_b>=3) { if ($InfectType!="") { $InfectType .= "、"; } $InfectType .= "Influenza"; }
							}
							if ($rp1_4['Q2_A_3_1']==1 || $rp1_4['Q2_A_3_2']==1 || $rp1_4['Q2_A_3_3']==1 || $rp1_4['Q2_A_3_4']==1 || $rp1_4['Q2_A_3_5']==1 || $rp1_4['Q2_A_3_6']==1 || $rp1_4['Q2_A_3_7']==1 || $rp1_4['Q2_A_3_8']==1 || $rp1_4['Q2_A_3_9']==1) {
								if ($rp1_4['Q2_A_3_1']==1) { $InfectType_c++; }
								if ($rp1_4['Q2_A_3_2']==1) { $InfectType_c++; }
								if ($rp1_4['Q2_A_3_3']==1) { $InfectType_c++; }
								if ($rp1_4['Q2_A_3_4']==1) { $InfectType_c++; }
								if ($rp1_4['Q2_A_3_5']==1) { $InfectType_c++; }
								if ($rp1_4['Q2_A_3_6']==1) { $InfectType_c++; }
								if ($rp1_4['Q2_A_3_7']==1) { $InfectType_c++; }
								if ($rp1_4['Q2_A_3_8']==1) { $InfectType_c++; }
								if ($rp1_4['Q2_A_3_9']==1) { $InfectType_c++; }
								if ($InfectType_c>=3) { if ($InfectType!="") { $InfectType .= "、"; } $InfectType .= "Lower respiratory tract infection"; }
							}
						} elseif ($rp1_4['InfectType']==3) {
							$InfectType2 .= 'Skin infection';
							if ($rp1_4['Q3_A_1_1']==1 || $rp1_4['Q3_A_1_2']==1 || $rp1_4['Q3_A_1_3']==1 || $rp1_4['Q3_A_1_4']==1 || $rp1_4['Q3_A_1_5']==1 || $rp1_4['Q3_A_1_6']==1 || $rp1_4['Q3_A_1_7']==1 || $rp1_4['Q3_A_1_8']==1) { $InfectType .= "Cellulitis, pressure sores, wound infection"; }
							if ($rp1_4['Q3_A_2_1']==1 || $rp1_4['Q3_A_2_2']==1 || $rp1_4['Q3_A_2_3']==1) { $InfectType .= "Other skin infection"; }
						} elseif ($rp1_4['InfectType']==4) {
							$InfectType2 .= 'Gastrointestinal infections';
						} elseif ($rp1_4['InfectType']==5) {
							$InfectType2 .= 'Ear, eye, nose and mouth infection ';
							if ($rp1_4['Q5_A_1_1']==1 || $rp1_4['Q5_A_1_2']==1) { $InfectType .= "Conjunctivitis"; }
							if ($rp1_4['Q5_A_2_1']==1 || $rp1_4['Q5_A_2_2']==1) { $InfectType .= "Ear infection"; }
						} elseif ($rp1_4['InfectType']==6) {
							$InfectType2 .= 'Scabies';
						} elseif ($rp1_4['InfectType']==7) {
							$InfectType2 .= 'Respiratory tract infection (RTI)';
							if ($rp1_4['Q7_A_3_1']==1 || $rp1_4['Q7_A_3_2']==1 || $rp1_4['Q7_A_3_3']==1 || $rp1_4['Q7_A_3_4']==1 || $rp1_4['Q7_A_3_5']==1 || $rp1_4['Q7_A_3_6']==1 || $rp1_4['Q7_A_3_7']==1 || $rp1_4['Q7_A_3_8']==1 || $rp1_4['Q7_A_3_9']==1) {
								if ($rp1_4['Q7_A_3_1']==1) { $InfectType_d++; }
								if ($rp1_4['Q7_A_3_2']==1) { $InfectType_d++; }
								if ($rp1_4['Q7_A_3_3']==1) { $InfectType_d++; }
								if ($rp1_4['Q7_A_3_4']==1) { $InfectType_d++; }
								if ($rp1_4['Q7_A_3_5']==1) { $InfectType_d++; }
								if ($rp1_4['Q7_A_3_6']==1) { $InfectType_d++; }
								if ($rp1_4['Q7_A_3_7']==1) { $InfectType_d++; }
								if ($rp1_4['Q7_A_3_8']==1) { $InfectType_d++; }
								if ($rp1_4['Q7_A_3_9']==1) { $InfectType_d++; }
								if ($InfectType_d>=3) { if ($InfectType!="") { $InfectType .= "、"; } $InfectType .= "Lower respiratory tract infection"; }
							}
						}
						?>
						<tr>
							<td class="printcol"><center><a href="index.php?mod=management&func=formview&id=3b_4&pid=<?php echo getPID($rp1_4['HospNo']); ?>&date=<?php echo str_replace("/","",$rp1_4['date']).$sMonth; ?>&tID=<?php echo $rp1_4['targetID']; ?>"><img src="Images/folder.png" width="24" /></a></center></td>
							<td align="center"><?php echo getHospNoDisplayByHospNo($rp1_4['HospNo']); ?></td>
							<td align="center"><?php echo $rp1_4['Name']; ?></td>
							<td align="center"><?php echo $rp1_4['date']; ?></td>
							<td align="center"><?php echo $InfectType2; ?></td>
							<td align="center"><?php echo $InfectType; ?></td>
							<td class="printcol"><center><input type="checkbox" name="targetList_4[]" id="targetList_4_<?php echo $rp1_4['targetID']; ?>" class="validate[required]" value="<?php echo $rp1_4['targetID']; ?>"></center></td>
							<?php
							if ($_SESSION['ncareLevel_lwj']>=4 || $rp1_4['targetID']==$_SESSION['ncareID_lwj']) {
								echo '<td class="printcol"><a href="index.php?mod=management&func=formview&id=3c_4&tID='.$rp1_4['targetID'].'"><img src="Images/delete2.png" width="20"></a></td>';
							}
							?>
						</tr>
						<?php
					}
				}
				?>
			</table>
			<center><input type="submit" id="analysis4" value="Start case-by-case analysis" class="printcol"></center>
		</form>
	</div>
	<!--感染當月統計-->
	<div id="tab4_part2" style="display:none;">
		<form action="index.php?func=save_sixtarget_stat" method="post" id="stat4">
			<table class="content-query">
				<tr class="title">
					<td align="center">Indicator item</td>
					<td align="center">Number</td>
					<td align="center">Formula</td>
					<td align="center">Permill(&#8240;)</td>
				</tr>
				<tr>
					<td class="title_s" style="text-align:left;">Monthly total resident days (A)</td>
					<td align="center">
						<?php
						$db_d_0 = new DB;
						$db_d_0->query("SELECT * FROM `sixtarget_part4_stat` WHERE `month`='".$qdate."'");
						$r_d_0 = $db_d_0->fetch_assoc();
						$db_d_1 = new DB;
						$db_d_1->query("SELECT SUM(`no`) FROM `dailypatientno` WHERE `date` LIKE '".str_replace("/","-",$qdate2)."%'");
						$r_d_1 = $db_d_1->fetch_assoc();
						if ($r_d_0['varA']=="") { $tmp_stat4_varA = $r_d_1['SUM(`no`)']; } else { $tmp_stat4_varA = $r_d_0['varA']; }
						?>
						<input type="text" name="sixtarget_stat4_varA" id="sixtarget_stat4_varA" size="4" value="<?php echo $tmp_stat4_varA; ?>" /></td>
						<td align="center">---</td>
						<td align="center">---</td>
					</tr>
					<tr>
						<td class="title_s" style="text-align:left;">Monthly infection people (B)</td>
						<td align="center">
							<?php
							$db_d_1a = new DB;
							$db_d_1a->query("SELECT * FROM `sixtarget_part4` WHERE `date` LIKE '".$qdate2."%'");
							if ($r_d_0['varB']=="") { $tmp_stat4_varB = $db_d_1a->num_rows(); } else { $tmp_stat4_varB = $r_d_0['varB']; }
							?>
							<input type="text" name="sixtarget_stat4_varB" size="4" value="<?php echo $tmp_stat4_varB; ?>" />
						</td>
						<td align="center">B/A</td>
						<td align="center"><?php echo round(($tmp_stat4_varB/$tmp_stat4_varA)*1000,2); ?> &#8240;</td>
					</tr>
					<tr>
						<td class="title_s" style="text-align:left;">Respiratory infection (C)</td>
						<td align="center">
							<?php
							$db_d_3 = new DB;
							$db_d_3->query("SELECT * FROM `sixtarget_part4` WHERE `InfectType`='2' AND `date` LIKE '".$qdate2."%'");
							if ($r_d_0['varC']=="") { $tmp_stat4_varC = $db_d_3->num_rows(); } else { $tmp_stat4_varC = $r_d_0['varC']; }
							?>
							<input type="text" name="sixtarget_stat4_varC" size="4" value="<?php echo $tmp_stat4_varC; ?>" />
						</td>
						<td align="center">C/A</td>
						<td align="center"><?php echo round(($tmp_stat4_varC/$tmp_stat4_varA)*1000,2); ?> &#8240;</td>
					</tr>
					<tr>
						<td class="title_s" style="text-align:left;">Lower respiratory tract infection (C1)</td>
						<td align="center">
							<?php
							$tmp_stat4_varC1 = 0;
							$db_d_3a = new DB;
							$db_d_3a->query("SELECT * FROM `sixtarget_part4` WHERE `InfectType`='2' AND (`Q2_A_3_1`='1' OR `Q2_A_3_2`='1' OR `Q2_A_3_3`='1' OR `Q2_A_3_4`='1' OR `Q2_A_3_5`='1' OR `Q2_A_3_6`='1' OR `Q2_A_3_7`='1' OR `Q2_A_3_8`='1' OR `Q2_A_3_9`='1')  AND `date` LIKE '".$qdate2."%'");
							if ($r_d_0['varC1']=="") {
								for ($i4=0;$i4<$db_d_3a->num_rows();$i4++) {
									$r_d_3a = $db_d_3a->fetch_assoc();
									$tmp_InfectType_c = 0;
									if ($r_d_3a['Q2_A_3_1']==1) { $tmp_InfectType_c++; }
									if ($r_d_3a['Q2_A_3_2']==1) { $tmp_InfectType_c++; }
									if ($r_d_3a['Q2_A_3_3']==1) { $tmp_InfectType_c++; }
									if ($r_d_3a['Q2_A_3_4']==1) { $tmp_InfectType_c++; }
									if ($r_d_3a['Q2_A_3_5']==1) { $tmp_InfectType_c++; }
									if ($r_d_3a['Q2_A_3_6']==1) { $tmp_InfectType_c++; }
									if ($r_d_3a['Q2_A_3_7']==1) { $tmp_InfectType_c++; }
									if ($r_d_3a['Q2_A_3_8']==1) { $tmp_InfectType_c++; }
									if ($r_d_3a['Q2_A_3_9']==1) { $tmp_InfectType_c++; }
									if ($tmp_InfectType_c>=3) { $tmp_stat4_varC1++; }
								}
							} else { $tmp_stat4_varC1 = $r_d_0['varC1']; }
							?>
							<input type="text" name="sixtarget_stat4_varC1" size="4" value="<?php echo $tmp_stat4_varC1; ?>" />
						</td>
						<td align="center">C1/A</td>
						<td align="center"><?php echo round(($tmp_stat4_varC1/$tmp_stat4_varA)*1000,2); ?> &#8240;</td>
					</tr>
					<tr>
						<td class="title_s" style="text-align:left;">Urinary tract infections (D)</td>
						<td align="center">
							<?php
							$db_d_4 = new DB;
							$db_d_4->query("SELECT * FROM `sixtarget_part4` WHERE `InfectType`='1' AND `date` LIKE '".$qdate2."%'");
							if ($r_d_0['varD']=="") { $tmp_stat4_varD = $db_d_4->num_rows(); } else { $tmp_stat4_varD = $r_d_0['varD']; }
							?>
							<input type="text" name="sixtarget_stat4_varD" size="4" value="<?php echo $tmp_stat4_varD; ?>" />
						</td>
						<td align="center">C/A</td>
						<td align="center"><?php echo round(($tmp_stat4_varD/$tmp_stat4_varA)*1000,2); ?> &#8240;</td>
					</tr>
					<tr>
						<td class="title_s" style="text-align:left;">Use catheter people*day (D1)</td>
						<td align="center">
							<?php
							$db_d_4a = new DB;
							$db_d_4a->query("SELECT SUM(`foleypat`) AS `foleypatno` FROM `dailypatientno` WHERE DATE_FORMAT(`date`,'%Y/%m')='".$qdate2."'");
							$r_d_4a = $db_d_4a->fetch_assoc();
							$tmp_stat4_varD1 = $r_d_0['varD1'];
							if ($r_d_0['varD1']=="") { $tmp_stat4_varD1 = $r_d_4a['foleypatno']; } else { $tmp_stat4_varD1 = $r_d_0['varD1']; }
							?>
							<input type="text" name="sixtarget_stat4_varD1" id="sixtarget_stat4_varD1" size="4" value="<?php echo $tmp_stat4_varD1; ?>" onkeyup="$('#sixtarget_stat4_varD2').val(($('#sixtarget_stat4_varA').val()-$('#sixtarget_stat4_varD1').val()));" />
						</td>
						<td align="center">---</td>
						<td align="center">---</td>
					</tr>
					<tr>
						<td class="title_s" style="text-align:left;">Unuse catheter people*day (D2)</td>
						<td align="center">
							<?php
							$db_d_4b = new DB;
							$db_d_4b->query("SELECT SUM(`nofoleypat`) AS `nofoleypatno` FROM `dailypatientno` WHERE DATE_FORMAT(`date`,'%Y/%m')='".$qdate2."'");
							$r_d_4b = $db_d_4b->fetch_assoc();
							if ($r_d_0['varD2']=="") { $tmp_stat4_varD2 = $r_d_4b['nofoleypatno']; } else { $tmp_stat4_varD2 = $r_d_0['varD2']; }
							?>
							<input type="text" name="sixtarget_stat4_varD2" id="sixtarget_stat4_varD2" size="4" value="<?php echo $tmp_stat4_varD2; ?>" readonly />
						</td>
						<td align="center">---</td>
						<td align="center">---</td>
					</tr>
					<tr>
						<td class="title_s" style="text-align:left;">Use indwelling catheter people (D5)</td>
						<td align="center">
							<?php
							$db_d_5 = new DB;
							$db_d_5->query("SELECT * FROM `sixtarget_part4` WHERE `InfectType`='1' AND (`Q1_A_2_1`='1' OR `Q1_A_2_2`='1' OR `Q1_A_2_3`='1' OR `Q1_A_2_4`='1') AND `date` LIKE '".$qdate2."%'");
							if ($r_d_0['varD5']=="") { $tmp_stat4_varD5 = $db_d_5->num_rows(); } else { $tmp_stat4_varD5 = $r_d_0['varD5']; }
							?>
							<input type="text" name="sixtarget_stat4_varD5" size="4" value="<?php echo $tmp_stat4_varD5; ?>" />
						</td>
						<td align="center">D5/D1</td>
						<td align="center"><?php if ($tmp_stat4_varD1>0) { echo round(($tmp_stat4_varD5/$tmp_stat4_varD1)*1000,2); } ?> &#8240;</td>
					</tr>
					<tr>
						<td class="title_s" style="text-align:left;">Unuse indwelling catheter people (D6)</td>
						<td align="center">
							<?php
							$db_d_6 = new DB;
							$db_d_6->query("SELECT * FROM `sixtarget_part4` WHERE `InfectType`='1' AND (`Q1_A_1_1`='1' OR `Q1_A_1_2`='1' OR `Q1_A_1_3`='1' OR `Q1_A_1_4`='1' OR `Q1_A_1_5`='1') AND `date` LIKE '".$qdate2."%'");
							if ($r_d_0['varD6']=="") { $tmp_stat4_varD6 = $db_d_6->num_rows(); } else { $tmp_stat4_varD6 = $r_d_0['varD6']; }
							?>
							<input type="text" name="sixtarget_stat4_varD6" size="4" value="<?php echo $tmp_stat4_varD6; ?>" />
						</td>
						<td align="center">D6/D2</td>
						<td align="center"><?php if ($tmp_stat4_varD2>0) { echo round(($tmp_stat4_varD6/$tmp_stat4_varD2)*1000,2); } ?> &#8240;</td>
					</tr>
					<tr>
						<td class="title_s" style="text-align:left;"><b>Scabies infection people (F)</td>
						<td align="center">
							<?php
							$db_d_7 = new DB;
							$db_d_7->query("SELECT * FROM `sixtarget_part4` WHERE `InfectType`='3' AND `date` LIKE '".$qdate2."%'");
							if ($r_d_0['varF']=="") { $tmp_stat4_varF = $db_d_7->num_rows(); } else { $tmp_stat4_varF = $r_d_0['varF']; }
							?>
							<input type="text" name="sixtarget_stat4_varF" size="4" value="<?php echo $tmp_stat4_varF; ?>" />
						</td>
						<td align="center">F/A</td>
						<td align="center"><?php echo round(($tmp_stat4_varF/$tmp_stat4_varA)*1000,2); ?> &#8240;</td>
					</tr>
				</table>
				<table width="100%">
					<tr>
						<td class="title" colspan="3">PDCA analysis</td>
					</tr>
					<tr>
						<td class="title_s" style="text-align:left;" width="260">Plan</td>
						<td colspan="2"><textarea id="sixtarget_stat4_plan" name="sixtarget_stat4_plan" rows="4"><?php echo $r_d_0['plan']; ?></textarea></td>
					</tr>
					<tr>
						<td class="title_s" style="text-align:left;">Execution (Do)</td>
						<td colspan="2"><textarea id="sixtarget_stat4_do" name="sixtarget_stat4_do" rows="4"><?php echo $r_d_0['do']; ?></textarea></td>
					</tr>
					<tr>
						<td class="title_s" style="text-align:left;">Review (Check)</td>
						<td colspan="2"><textarea id="sixtarget_stat4_check" name="sixtarget_stat4_check" rows="4"><?php echo $r_d_0['check']; ?></textarea></td>
					</tr>
					<tr>
						<td class="title_s" style="text-align:left;">Improvement plan develop and action (Action)</td>
						<td colspan="2"><textarea id="sixtarget_stat4_action" name="sixtarget_stat4_action" rows="4"><?php echo $r_d_0['action']; ?></textarea></td>
					</tr>
				</table>
				<table width="100%">
					<tr <?php if ($qdate=="%") { echo 'style="display:none;"'; } ?>>
						<td class="title"><input type="hidden" name="month" value="<?php echo $qdate; ?>" /><input type="hidden" name="tbname" value="part4" /><input type="submit" value="Save <?php echo $qdate2; ?> Statistics" class="printcol" /> <input type="submit" value="Recalculate latest data formula" name="resetstat" class="printcol" /></td>
						<td colspan="3" class="title">Last modified date:<?php echo formatdate($r_d_0['savedate']); ?> Modified by:<?php echo checkusername($r_d_0['Qfiller']); ?></td>
					</tr>
				</table>
			</form>
		</div>
		<!--感染季分析-->
		<div id="tab4_part3" style="display:none;">
			<table class="content-query" style="font-size:10pt;page-break-after:always;">
				<tr class="title">
					<td width="36%">&nbsp;</td>
					<td width="16%">Season 1 (Q1)</td>
					<td width="16%">Season 2 (Q2)</td>
					<td width="16%">Season 3 (Q3)</td>
					<td width="16%">Season 4 (Q4)</td>
				</tr>
				<?php
				$arrQTab4 = array('varA'=>'Monthly total resident days (A)', 'varB'=>'Monthly infection people (B)', 'varBP'=>'Monthly infection people ratio&#8240;(B/A)', 'varC'=>'Respiratory infection (C)', 'varCP'=>'Respiratory infection ratio&#8240;(C/A)', 'varC1'=>'Lower respiratory tract infection (C1)', 'varC1P'=>'Lower respiratory tract infection ratio&#8240;(C1/A)', 'varD'=>'Urinary tract infections (D)', 'varDP'=>'Urinary tract infections&#8240;(D/A)', 'varD1'=>'Use catheter people*days (D1)', 'varD5'=>'Use indwelling catheter people (D5)', 'varD5P'=>'Infection with using indwelling catheter ratio&#8240;(D5/D1)', 'varD2'=>'Unuse catheter people*day (D2)', 'varD6'=>'Unuse indwelling catheter people (D6)', 'varD6P'=>'Infection without using indwelling catheter ratio&#8240;(D6/D2)', 'varF'=>'Scabies infection people (F)', 'varFP'=>'Scabies infection people ratio&#8240;(F/A)');
				foreach ($arrQTab4 as $ktab4 => $vtab4) {
					?>
					<tr>
						<td class="title_s" style="font-size:9pt;"><?php echo $vtab4; ?></td>
						<?php
						foreach ($arrSeasonMonth as $k3=>$v3) {
							$db3_3 = new DB;
							$db3_3->query("SELECT `month`, `".str_replace("P","",$ktab4)."` AS '".str_replace("P","",$ktab4)."' FROM `sixtarget_part4_stat` WHERE `month`>='".$v3[0]."' AND `month`<='".$v3[1]."' ORDER BY `month` ASC");
							if ($db3_3->num_rows()==0) {
								echo '<td align="center"><center>---</center></td>';
							} else {
								for ($i3_3=0;$i3_3<$db3_3->num_rows();$i3_3++) {
									$r3_3 = $db3_3->fetch_assoc();
									${'arrPart4Tab3Tmp_'.$ktab4}[$k3][$i3_3] += $r3_3[str_replace("P","",$ktab4)];
								}
								if (substr($ktab4,strlen($ktab4)-1,1)=="P") {
									if ($ktab4=="varBP" || $ktab4=="varCP" || $ktab4=="varC1P" || $ktab4=="varDP" || $ktab4=="varFP" || $ktab4=="varGP" || $ktab4=="varHP" || $ktab4=="varIP") {
										if (array_sum($arrPart4Tab3Tmp_varA[$k3])==0) {
											${'statVar'.$ktab4} = 0;
										} else {
											${'statVar'.$ktab4} = round(((array_sum(${'arrPart4Tab3Tmp_'.str_replace("P", "", $ktab4)}[$k3])/3)/(array_sum($arrPart4Tab3Tmp_varA[$k3])/3))*1000,2);
										}
										echo '<td align="center"><center>'.${'statVar'.$ktab4}.' &#8240;</center></td>';
									} elseif ($ktab4=="varD5P") {
										if (array_sum($arrPart4Tab3Tmp_varD1[$k3])==0) {
											${'statVar'.$ktab4} = 0;
										} else {
											${'statVar'.$ktab4} = round(((array_sum(${'arrPart4Tab3Tmp_'.str_replace("P", "", $ktab4)}[$k3])/3)/(array_sum($arrPart4Tab3Tmp_varD1[$k3])/3))*1000,2);
										}
										echo '<td align="center"><center>'.${'statVar'.$ktab4}.' &#8240;</center></td>';
									} elseif ($ktab4=="varD6P") {
										if (array_sum($arrPart4Tab3Tmp_varD2[$k3])==0) {
											${'statVar'.$ktab4} = 0;
										} else {
											${'statVar'.$ktab4} = round(((array_sum(${'arrPart4Tab3Tmp_'.str_replace("P", "", $ktab4)}[$k3])/3)/(array_sum($arrPart4Tab3Tmp_varD2[$k3])/3))*1000,2);
										}
										echo '<td align="center"><center>'.${'statVar'.$ktab4}.' &#8240;</center></td>';
									}
								} else {
									if ($db3_3->num_rows()==0) {
										$arraysum = 0;
										$numrows = 1;
									} else {
										$arraysum = array_sum(${'arrPart4Tab3Tmp_'.$ktab4}[$k3]);
										$numrows = 3;
									}
									echo '<td align="center"><center>'.round(($arraysum/$numrows),2).'</center></td>';
								}
							}
						}
						?>
					</tr>
					<?php
				}
				?>
			</table>
		</div>
		<!--感染年度分析-->
		<div id="tab4_part4" style="display:none;">
			<table class="content-query">
				<tr class="title">
					<td align="center">&nbsp;</td>
					<?php
					foreach ($arrPast12Months as $k1=>$v1) {
						echo '<td align="center">'.str_replace("/","<br>",$v1).'</td>';
					}
					?>
				</tr>
				<?php
				foreach ($arrQTab4 as $ktab1 => $vtab1) {
					?>
					<tr>
						<td class="title_s" style="font-size:10pt;"><?php echo $vtab1; ?></td>
						<?php
						foreach ($arrPast12Months as $k1=>$v1) {
							$arrDateTab1Q = explode("/",$v1);
							if (strlen($arrDateTab1Q[1])==1) { $monthofq31 = '0'.$arrDateTab1Q[1]; } else { $monthofq31 = $arrDateTab1Q[1]; }
							$db3_1 = new DB;
							$db3_1->query("SELECT `".str_replace("P","",$ktab1)."` FROM `sixtarget_part4_stat` WHERE `month`='".$arrDateTab1Q[0].$monthofq31."'");
							$r3_1 = $db3_1->fetch_assoc();
							if (${'stat4_'.$ktab1}!="") { ${'stat4_'.$ktab1} .= ', '; }
							if (${'stat4_'.$ktab1.'_per'}!="") { ${'stat4_'.$ktab1.'_per'} .= ', '; }
							$second1970 = mktime(0,0,0,$arrDateTab1Q[1],1,$arrDateTab1Q[0]);
							$second1970ms = number_format(($second1970 * 1000), 0, '.', '');
							if ($r3_1['varA']!='') { ${'totalpatientstat4A_'.$arrDateTab1Q[0].$monthofq31} = $r3_1['varA']; }
							if ($r3_1['varD1']!='') { ${'totalpatientstat4D1_'.$arrDateTab1Q[0].$monthofq31} = $r3_1['varD1']; }
							if ($r3_1['varD2']!='') { ${'totalpatientstat4D2_'.$arrDateTab1Q[0].$monthofq31} = $r3_1['varD2']; }
							if ($db3_1->num_rows()==0) {
								echo '<td align="center"><center>---</center></td>';
								${'stat4_'.$ktab1} .= '["'.$second1970ms.'",0]';
								${'stat4_'.$ktab1.'_per'} .= '["'.$second1970ms.'",0]';
							} else {
								echo '<td align="center"><center>';
								if ($ktab1=="varBP" || $ktab1=="varCP" || $ktab1=="varC1P" || $ktab1=="varDP" || $ktab1=="varFP" || $ktab1=="varGP" || $ktab1=="varHP" || $ktab1=="varIP") {
									if (${'totalpatientstat4A_'.$arrDateTab1Q[0].$monthofq31}>0) {
										echo round(($r3_1[str_replace("P","",$ktab1)]/${'totalpatientstat4A_'.$arrDateTab1Q[0].$monthofq31})*1000,2)."&#8240;";
										${'stat4_'.$ktab1.'_per'} .= '["'.$second1970ms.'",'.round(($r3_1[str_replace("P","",$ktab1)]/${'totalpatientstat4A_'.$arrDateTab1Q[0].$monthofq31})*1000,2).']';
									} else { echo '0%'; ${'stat4_'.$ktab1.'_per'} .= '["'.$second1970ms.'",0]'; }
								} elseif ($ktab1=="varD5P") {
									if (${'totalpatientstat4D1_'.$arrDateTab1Q[0].$monthofq31}>0) {
										echo round(($r3_1['varD5']/${'totalpatientstat4D1_'.$arrDateTab1Q[0].$monthofq31})*1000,2)."&#8240;";
										${'stat4_'.$ktab1.'_per'} .= '["'.$second1970ms.'",'.round(($r3_1['varD5']/${'totalpatientstat4D1_'.$arrDateTab1Q[0].$monthofq31})*1000,2).']';
									} else { echo '0%'; ${'stat4_'.$ktab1.'_per'} .= '["'.$second1970ms.'",0]'; }
								} elseif ($ktab1=="varD6P") {
									if (${'totalpatientstat4D2_'.$arrDateTab1Q[0].$monthofq31}>0) {
										echo round(($r3_1['varD6']/${'totalpatientstat4D2_'.$arrDateTab1Q[0].$monthofq31})*1000,2)."&#8240;";
										${'stat4_'.$ktab1.'_per'} .= '["'.$second1970ms.'",'.round(($r3_1['varD6']/${'totalpatientstat4D2_'.$arrDateTab1Q[0].$monthofq31})*1000,2).']';
									} else { echo '0%'; ${'stat4_'.$ktab1.'_per'} .= '["'.$second1970ms.'",0]'; }
								} else {
				  //echo $r3_1[$ktab1];
									if ($r3_1[$ktab1]=="") { echo '0'; } else { echo $r3_1[$ktab1]; }
									${'stat4_'.$ktab1} .= '["'.$second1970ms.'",'.$r3_1[$ktab1].']';
								}
								echo '</center></td>';
							}
						}
						?>
					</tr>
					<?php
				}
				?>
			</table><br><br>

			<style>
			#chart4a table {
				width: auto;
				left:780px;
				position:relative;
			}
			#chart4a table tr {
				background:none;
				height:auto;
				padding:0px;
				margin:0px;
			}
			#chart4a table tr td { border:none; font-size:10pt; padding: 4px 0px; }
			#chart4b table {
				width: auto;
				left:780px;
				position:relative;
			}
			#chart4b table tr {
				background:none;
				height:auto;
				padding:0px;
				margin:0px;
			}
			#chart4b table tr td { border:none; font-size:10pt; padding: 4px 0px; }
			#chart4c table {
				width: auto;
				left:780px;
				position:relative;
			}
			#chart4c table tr {
				background:none;
				height:auto;
				padding:0px;
				margin:0px;
			}
			#chart4c table tr td { border:none; font-size:10pt; padding: 4px 0px; }
			#chart4d table {
				width: auto;
				left:780px;
				position:relative;
			}
			#chart4d table tr {
				background:none;
				height:auto;
				padding:0px;
				margin:0px;
			}
			#chart4d table tr td { border:none; font-size:10pt; padding: 4px 0px; }
			#chart4e table {
				width: auto;
				left:780px;
				position:relative;
			}
			#chart4e table tr {
				background:none;
				height:auto;
				padding:0px;
				margin:0px;
			}
			#chart4e table tr td { border:none; font-size:10pt; padding: 4px 0px; }
			</style>
			<h3><?php echo $arrDate[0]; ?> Annual resident infection occur statistic</h3>
			<div id="chart4a" style="width:740px;height:420px; margin-left:50px; margin-top:50px; margin-bottom:50px; padding-top:50px; padding-bottom:50px; page-break-after:always;"></div><br /><br />
			<h3><?php echo $arrDate[0]; ?> Annual resident infection cause analysis</h3>
			<div id="chart4b" style="width:740px;height:420px; margin-left:40px; margin-top:50px; margin-bottom:50px; padding-top:50px; padding-bottom:50px; page-break-after:always;"></div><br /><br />
			<h3><?php echo $arrDate[0]; ?> Annual respiratory infection statistic</h3>
			<div id="chart4c" style="width:740px;height:420px; margin-left:50px; margin-top:50px; margin-bottom:50px; padding-top:50px; padding-bottom:50px; page-break-after:always;"></div><br /><br />
			<h3><?php echo $arrDate[0]; ?> Annual urinary tract infections statistic</h3>
			<div id="chart4d" style="width:740px;height:420px; margin-left:50px; margin-top:50px; margin-bottom:50px; padding-top:50px; padding-bottom:50px; page-break-after:always;"></div><br /><br />
			<h3><?php echo $arrDate[0]; ?> Annual scabies incidence ratio</h3>
			<div id="chart4e" style="width:740px;height:420px; margin-left:40px; margin-top:50px; margin-bottom:50px; padding-top:50px; padding-bottom:50px;"></div><br /><br />
			<script type="text/javascript">
			$(function () {
				$.plot($("#chart4a"), [
					{ label: "Monthly resident number(A)",  data: [<?php echo $stat4_varA; ?>], bars: {fillColor: "#edc240"}, color: "#edc240" },
					{ label: "Monthly infection people<br>(B)",  data: [<?php echo $stat4_varB; ?>], bars: {fillColor: "#afd8f8"}, color: "#afd8f8" },
					{ label: "Monthly infection people ratio<br>&#8240;(B/A)",  data: [<?php echo $stat4_varBP_per; ?>], lines: {show: true}, points: { show: true, symbol:"triangle" }, bars: {show: false},  color: "#cb4b16", yaxis:2 }
					],
					{
						xaxis: { mode: "time", timeformat: "%y<br>%b", monthNames: [<?php for ($imonth=1;$imonth<=12;$imonth++) { if ($imonth>1) { echo ', '; } echo "'".$imonth."'"; } ?>], tickLength: 0, axisLabelUseCanvas: true, axisLabelFontSizePixels: 12, axisLabelFontFamily: "Verdana, Arial, Helvetica, Tahoma, sans-serif", axisLabelPadding: 5 },
						yaxes: [
						{tickSize: 200, tickDecimals: 0, position: 'left'},
						{tickSize: 5, tickDecimals: 1, min:0, position: 'right'}
						],
						grid: { hoverable: true, clickable: false, borderWidth: 1 },
						series: { shadowSize: 0, bars: { show: true, barWidth: 12*24*60*60*300, order: 1 } }
					});
$.plot($("#chart4b"), [
	{ label: "Monthly infection people<br>(B)",  data: [<?php echo $stat4_varB; ?>], bars: {fillColor: "#edc240"}, color: "#edc240" },
	{ label: "Respiratory infection<br>People(C)",  data: [<?php echo $stat4_varC; ?>], bars: {fillColor: "#afd8f8"}, color: "#afd8f8" },
	{ label: "Lower respiratory tract infection<br>People(C1)",  data: [<?php echo $stat4_varC1; ?>], bars: {fillColor: "#cb4b16"}, color: "#cb4b16" },
	{ label: "Urinary tract infections<br>People(D)",  data: [<?php echo $stat4_varD; ?>], bars: {fillColor: "#99EC41"}, color: "#99EC41" },
	{ label: "Scabies infection <br>people(F)",  data: [<?php echo $stat4_varF; ?>], bars: {fillColor: "#9440ed"}, color: "#9440ed" }
	],
	{
		xaxis: { mode: "time", timeformat: "%y<br>%b", monthNames: [<?php for ($imonth=1;$imonth<=12;$imonth++) { if ($imonth>1) { echo ', '; } echo "'".$imonth."'"; } ?>], tickLength: 0, axisLabelUseCanvas: true, axisLabelFontSizePixels: 12, axisLabelFontFamily: "Verdana, Arial, Helvetica, Tahoma, sans-serif", axisLabelPadding: 5 },
		yaxes: [
		{tickSize: 2, tickDecimals: 0, position: 'left'}
		],
		grid: { hoverable: true, clickable: false, borderWidth: 1 },
		series: { shadowSize: 0, bars: { show: true, barWidth: 12*24*60*60*300, order: 1 } }
	});
$.plot($("#chart4c"), [
	{ label: "Respiratory infection<br>incidents(C)",  data: [<?php echo $stat4_varC; ?>], bars: {fillColor: "#edc240"}, color: "#edc240" },
	{ label: "Lower respiratory tract infection<br>incidents(C1)",  data: [<?php echo $stat4_varC1; ?>], bars: {fillColor: "#afd8f8"}, color: "#afd8f8" },
	{ label: "Respiratory infection ratio&#8240;(C/A)",  data: [<?php echo $stat4_varCP_per; ?>], lines: {show: true}, points: { show: true, symbol:"triangle" }, bars: {show: false},  color: "#99EC41", yaxis:2 },
	{ label: "Lower respiratory tract infection ratio&#8240;(C1/A)",  data: [<?php echo $stat4_varC1P_per; ?>], lines: {show: true}, points: { show: true, symbol:"cross" }, bars: {show: false},  color: "#9440ed", yaxis:2 }
	],
	{
		xaxis: { mode: "time", timeformat: "%y<br>%b", monthNames: [<?php for ($imonth=1;$imonth<=12;$imonth++) { if ($imonth>1) { echo ', '; } echo "'".$imonth."'"; } ?>], tickLength: 0, axisLabelUseCanvas: true, axisLabelFontSizePixels: 12, axisLabelFontFamily: "Verdana, Arial, Helvetica, Tahoma, sans-serif", axisLabelPadding: 5 },
		yaxes: [
		{tickSize: 1, tickDecimals: 0, position: 'left'},
		{tickSize: 2, tickDecimals: 1, min:0, position: 'right'}
		],
		grid: { hoverable: true, clickable: false, borderWidth: 1 },
		series: { shadowSize: 0, bars: { show: true, barWidth: 12*24*60*60*300, order: 1 } }
	});
$.plot($("#chart4d"), [
	{ label: "Apply FOLEY total<br> people*day(D1)",  data: [<?php echo $stat4_varD1; ?>], bars: {fillColor: "#cb4b16"}, color: "#cb4b16" },
	{ label: "Apply FOLEY UTI<br>People(D5)",  data: [<?php echo $stat4_varD5; ?>], bars: {fillColor: "#afd8f8"}, color: "#afd8f8" },
	{ label: "Not apply FOLEY  total<br>people*day(D2)",  data: [<?php echo $stat4_varD2; ?>], bars: {fillColor: "#edc240"}, color: "#edc240" },
	{ label: "Not apply FOLEY <br>UTI people(D6)",  data: [<?php echo $stat4_varD6; ?>], bars: {fillColor: "#99EC41"}, color: "#99EC41" },
	{ label: "Apply FOLEY UTI<br>ratio&#8240;(D5/D1)",  data: [<?php echo $stat4_varD5P_per; ?>], lines: {show: true}, points: { show: true, symbol:"triangle" }, bars: {show: false},  color: "#cb4b16", yaxis:2 },
	{ label: "Not apply FOLEY UTI<br>ratio&#8240;(D6/D2",  data: [<?php echo $stat4_varD6P_per; ?>], lines: {show: true}, points: { show: true, symbol:"cross" }, bars: {show: false},  color: "#9440ed", yaxis:2 }
		],
		{
			xaxis: { mode: "time", timeformat: "%y<br>%b", monthNames: [<?php for ($imonth=1;$imonth<=12;$imonth++) { if ($imonth>1) { echo ', '; } echo "'".$imonth."'"; } ?>], tickLength: 0, axisLabelUseCanvas: true, axisLabelFontSizePixels: 12, axisLabelFontFamily: "Verdana, Arial, Helvetica, Tahoma, sans-serif", axisLabelPadding: 5 },
			yaxes: [
			{tickSize: 200, tickDecimals: 0, position: 'left'},
			{tickSize: 2, tickDecimals: 2, min:0, position: 'right'}
			],
			grid: { hoverable: true, clickable: false, borderWidth: 1 },
			series: { shadowSize: 0, bars: { show: true, barWidth: 12*24*60*60*300, order: 1 } }
		});
$.plot($("#chart4e"), [
	{ label: "Scabies infection <br>People(F)",  data: [<?php echo $stat4_varF; ?>], bars: {fillColor: "#cb4b16"}, color: "#cb4b16" },
	{ label: "Scabies infection people ratio &#8240;(F/A)",  data: [<?php echo $stat4_varFP_per; ?>], lines: {show: true}, points: { show: true, symbol:"triangle" }, bars: {show: false},  color: "#edc240", yaxis:2 }
	],
	{
		xaxis: { mode: "time", timeformat: "%y<br>%b", monthNames: [<?php for ($imonth=1;$imonth<=12;$imonth++) { if ($imonth>1) { echo ', '; } echo "'".$imonth."'"; } ?>], tickLength: 0, axisLabelUseCanvas: true, axisLabelFontSizePixels: 12, axisLabelFontFamily: "Verdana, Arial, Helvetica, Tahoma, sans-serif", axisLabelPadding: 5 },
		yaxes: [
		{tickSize: 1, tickDecimals: 0, position: 'left'},
		{tickSize: 1, tickDecimals: 2, min:0, position: 'right'}
		],
		grid: { hoverable: true, clickable: false, borderWidth: 1 },
		series: { shadowSize: 0, bars: { show: true, barWidth: 12*24*60*60*300, order: 1 } }
	});
var yaxisLabel = $("<div class='axisLabel yaxisLabel' style='position: absolute; left: -28px; top: -30px;'></div>").text("People").appendTo($('#chart4b'));
var xaxisLabel = $("<div class='axisLabel xaxisLabel' style='position: absolute; left:400px; bottom: -50px;'></div>").text(" month").appendTo($('#chart4b'));
var yaxisLabel = $("<div class='axisLabel yaxisLabel' style='position: absolute; left: -28px; top: -30px;'></div>").text("Total people*day").appendTo($('#chart4a'));
var yaxisLabel2 = $("<div class='axisLabel yaxisLabel' style='width:50px; position: absolute; left: 740px; top: -30px;'></div>").text("Rate").appendTo($('#chart4a'));
var xaxisLabel = $("<div class='axisLabel xaxisLabel' style='position: absolute; left:400px; bottom: -50px;'></div>").text(" month").appendTo($('#chart4a'));
var yaxisLabel = $("<div class='axisLabel yaxisLabel' style='position: absolute; left: -28px; top: -30px;'></div>").text("incidents").appendTo($('#chart4c'));
var yaxisLabel2 = $("<div class='axisLabel yaxisLabel' style='width:50px; position: absolute; left: 740px; top: -30px;'></div>").text("Rate").appendTo($('#chart4c'));
var xaxisLabel = $("<div class='axisLabel xaxisLabel' style='position: absolute; left:400px; bottom: -50px;'></div>").text(" month").appendTo($('#chart4c'));
var yaxisLabel = $("<div class='axisLabel yaxisLabel' style='position: absolute; left: -28px; top: -30px;'></div>").text("Resident days").appendTo($('#chart4d'));
var yaxisLabel2 = $("<div class='axisLabel yaxisLabel' style='width:50px; position: absolute; left: 740px; top: -30px;'></div>").text("Rate").appendTo($('#chart4d'));
var xaxisLabel = $("<div class='axisLabel xaxisLabel' style='position: absolute; left:400px; bottom: -50px;'></div>").text(" month").appendTo($('#chart4d'));
var yaxisLabel = $("<div class='axisLabel yaxisLabel' style='position: absolute; left: -28px; top: -30px;'></div>").text("incidents").appendTo($('#chart4e'));
var yaxisLabel2 = $("<div class='axisLabel yaxisLabel' style='width:50px; position: absolute; left: 740px; top: -30px;'></div>").text("Rate").appendTo($('#chart4e'));
var xaxisLabel = $("<div class='axisLabel xaxisLabel' style='position: absolute; left:400px; bottom: -50px;'></div>").text(" month").appendTo($('#chart4e'));
});
</script>
</div>
</div>
</center>
<!--Pressure ulcer(s)-->
<center>
<div id="tab5" style="padding:1px; font-size:11pt;">
	<h3>Pressure ulcer statistic</h3>
	<div align="center" style="margin-bottom:10px;">
		<?php echo draw_option("tab5option","Current month record;Current month statistic;3 months(seasonal) analysis;Annual analysis","xl","single",1,false,5); ?>
	</div>
	<div align="center">
			<div class="patlistbtn" style="background-color:rgb(149,219,208); width:100px;"><a href="index.php?mod=management&func=formview&id=3d_1&type=5<?php echo $sMonth;?>" title="逐案分析列表"><i class="fa fa-list fa-2x fa-fw"></i><br>Case-by-case analysis</a></div>
			<div class="patlistbtn" style="background-color:rgb(149,219,208);"><a href="#" onclick="printDialog('5', '<?php echo $_GET['qdate']; ?>');" title="Print report"><i class="fa fa-print fa-2x fa-fw"></i><br>Print report</a></div>
	</div>
	<script>
	$(function() {
		$( "#dialog-form5" ).dialog({
			autoOpen: false,
			height: 600,
			width: 900,
			modal: true,
			buttons: {
				"Add record": function() {
					if ($("#HospNo_tab5").val()=="") {
						alert("請先填寫住民資料");
						$("#HospNo_tab5").focus();
					} else {
						$.ajax({
							url: "class/sixtarget_part5.php",
							type: "POST",
							data: {'HospNo': $('#HospNo_tab5').val(), 'Name': $('#Name_tab5').val(), 'startdate': $('#part5_startdate').val(), 'enddate': $('#part5_enddate').val(), 'level_1': $('#part5_level_1').val(), 'level_2': $('#part5_level_2').val(), 'level_3': $('#part5_level_3').val(), 'level_4': $('#part5_level_4').val(), 'Qfiller': $('#Qfiller').val() },
							success: function(data) {
								$( "#dialog-form5" ).dialog( "close" );
								alert("Add record sucessfully!");
								window.location.reload();
							}
						});
					}
				},
				"Cancel": function() {
					$( "#dialog-form5" ).dialog( "close" );
				}
			}
		});
		$( "#newrecord5" ).button().click(function() {
			$( "#dialog-form5" ).dialog( "open" );
		});
	});
</script>
<div id="dialog-form5" title="壓瘡情況登錄"> 
	<form id="form5">
		<fieldset>
			<table>
				<tr>
					<td style="background:#999; color:#fff;">Search</td>
					<td colspan="3">
						&nbsp;<span style="padding:3px; border:1px solid #999; color:#666; font-size:10pt;">Care ID#</span> <input type="text" name="HospNo" id="HospNo_tab5" value="" size="8">&nbsp;
						<input type="button" value="Search" id="search_tab5" onclick="loadPatInfo('tab5')" />
						<input type="button" value="Empty" id="clear_tab5" onclick="cleartab('5')" style="display:none;" /></td>
					</tr>
					<tr>
						<td align="center">壓瘡發生日期</td>
						<td align="center"><script> $(function() { $( "#part5_startdate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="part5_startdate" id="part5_startdate" value="<?php echo date(Y."/".m."/".d); ?>"></td>
						<td align="center">Healed date</td>
						<td align="center"><script> $(function() { $( "#part5_enddate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="part5_enddate" id="part5_enddate" value=""><input type="button" onclick="document.getElementById('part5_enddate').value='<?php echo date(Y."/".m."/".d); ?>'" value="Today" /></td>
					</tr>
					<tr>
						<td align="center">Pressure ulcer(s) stage</td>
						<td colspan="3"><?php echo draw_option("part5_level","一級;二級;三級;四級","m","single",$part5_level,false,3); ?></td>
					</tr>
					<tr>
						<td colspan="4">
							<input type="hidden" name="Qfiller" id="Qfiller" value="<?php echo $_SESSION['ncareID_lwj']; ?>">
						</td>
					</tr>
				</table>
			</fieldset>
		</form>
	</div>
	<script>
	$('#btn_tab5option_1').click(function() {
		$('#tab5_part1').show();
		$('#tab5_part2').hide();
		$('#tab5_part3').hide();
		$('#tab5_part4').hide();
	});
	$('#btn_tab5option_2').click(function() {
		$('#tab5_part1').hide();
		$('#tab5_part2').show();
		$('#tab5_part3').hide();
		$('#tab5_part4').hide();
	});
	$('#btn_tab5option_3').click(function() {
		$('#tab5_part1').hide();
		$('#tab5_part2').hide();
		$('#tab5_part3').show();
		$('#tab5_part4').hide();
	});
	$('#btn_tab5option_4').click(function() {
		$('#tab5_part1').hide();
		$('#tab5_part2').hide();
		$('#tab5_part3').hide();
		$('#tab5_part4').show();
	});
	$(function() { $('#tform5').validationEngine(); });
	</script>
	<!--壓瘡當月資料-->
	<div id="tab5_part1">
		<form id="tform5" action="index.php?mod=management&func=formview&id=3d_2&type=5<?php echo $sMonth; ?>" method="post">
			<table class="content-query" style="font-size:10pt; font-weight:normal;">
				<tr class="title">
					<td class="printcol">View</td>
					<td align="center">Care ID#</td>
					<td align="center">Full name</td>
					<td align="center">Braden risk factors</td>
					<td align="center">Occur date</td>
					<td align="center">Pressure sores location/body part(s)</td>
					<td align="center">Stage</td>
					<td align="center">Size (cm)</td>
					<td align="center">Healed date</td>
					<td class="printcol">Case-by-case analysis</td>
					<td class="printcol">Delete</td>
				</tr>
				<?php
				$dbp1_5 = new DB;
//  $dbp1_5->query("SELECT * FROM  `sixtarget_part5`  WHERE `startdate` LIKE '".$qdate2."%'");
				$dbp1_5->query("SELECT * FROM `nurseform02g_2` WHERE `Q28_1`='1' ".($_GET['qdate']=="ALL"?"":"AND DATE_FORMAT(`date`, '%Y%m') = '".$qdate."'"));
				if ($dbp1_5->num_rows()==0) {
					?>
					<tr>
						<td colspan="11"><center>-------Yet no data of this month-------</center></td>
					</tr>
					<script>$(function() { $('#analysis5').hide(); });</script>
					<?php
				} else {
					for ($p1_i5=0;$p1_i5<$dbp1_5->num_rows();$p1_i5++) {
						$rp1_5 =$dbp1_5->fetch_assoc();

						foreach ($rp1_5 as $k=>$v) {
							if (substr($k,0,1)=="Q") {
								$arrAnswer = explode("_",$k);
								if (count($arrAnswer)==2) {
									if ($v==1) { ${$arrAnswer[0]} .= $arrAnswer[1].';'; }
								} else {
									${$k} = $v;
								}
							}  else { ${$k} = $v; }
						}
						$pid = getPID($rp1_5['HospNo']);
						?>
						<tr>
							<td class="printcol"><center><a href="index.php?mod=nurseform&func=formview&view=5&part=1&id=2g_2&pid=<?php echo $pid;?>&date=<?php echo $rp1_5['date'].'_'.$rp1_5['no'];?>"><img src="Images/folder.png" width="24" /></a></center></td>
							<td align="center"><?php echo getHospNoDisplayByHospNo($rp1_5['HospNo']); ?></td>
							<td align="center"><?php echo getPatientName($pid); ?></td>
							<td align="center"><?php echo $rp1_5['Q27']; ?></td>
							<td align="center"><?php echo $rp1_5['Q7']; ?></td>
							<td align="center"><?php echo option_result("Q2","Forehead;Nose;Chin;Outer ear;Occipital;Breast;Chest;Rib cage;Costal arch;Scapula;Humerus;Elbow;Abdomen;Spine protruding spot;Scrotum;Perineum;Sacral vertebrae;Buttock;Hip ridge;Ischial tuberosity;Front knee;Medial knee;Fibula;Lateral ankle;Inner ankle;Heel;Toe;Plantar;Intertrochanteric;Other","m","multi",$Q2,true,6); ?></td>
							<td align="center"><?php echo checkbox_result("Q4","Stage 1;Stage 2;Stage 3;Stage 4;Unstageable<br>Non-removable dressing;Unstageable<br>Slough and/or eschar;Unstageable<br>Deep tissue",$Q4,"multi"); ?></td>
							<td>
								<?php 
								if($Q9 !="" && $Q9 != NULL){echo '(Length：'.$Q9.')';}
								if($Q10 !="" && $Q10 != NULL){echo 'X(Width：'.$Q10.')';}
								if($Q11 !="" && $Q11 != NULL){echo 'X(Depth：'.$Q11.')';}
								if($Q11a !="" && $Q11a != NULL){echo '，Tunneling：'.$Q11a.'';}
								?>
							</td>      
							<td align="center"><?php echo $rp1_5['Q26']; ?></td>
							<td class="printcol"><center><input type="checkbox" name="targetList_5[]" id="targetList_5_<?php echo $rp1_5['HospNo'].'_'.$rp1_5['date'].'_'.$rp1_5['no']; ?>" class="validate[required]" value="<?php echo $rp1_5['HospNo'].'-'.$rp1_5['date'].'-'.$rp1_5['no']; ?>"></center></td>     
							<?php
							if ($_SESSION['ncareLevel_lwj']>=4 || $rp1_5['targetID']==$_SESSION['ncareID_lwj']) {
								echo '<td class="printcol"><a href="index.php?mod=management&func=formview&id=3c_5&view=5&part=1&tID='.$rp1_5['no'].'&date='.$rp1_5['date'].'&pid='.$pid.'"><img src="Images/delete2.png" width="20"></a></td>';
							}
							?>
						</tr>
						<?php
						$Q4="";
						$Q2="";
					}
				}
				?>
			</table>
			<center><input type="submit" id="analysis5" value="Start case-by-case analysis" class="printcol"></center></form>
		</div>
		<!--壓瘡當月統計-->
		<div id="tab5_part2" style="display:none;">
			<form action="index.php?func=save_sixtarget_stat" method="post" id="stat5">
				<table class="content-query">
					<tr class="title">
						<td align="center">Indicator item</td>
						<td align="center">Number</td>
						<td align="center">Formula</td>
						<td align="center">Rate(%)</td>
					</tr>
					<tr>
						<td class="title_s" style="text-align:left;">Monthly total resident days(A)</td>
						<td align="center">
							<?php
							$db_e_0 = new DB;
							$db_e_0->query("SELECT * FROM `sixtarget_part5_stat` WHERE `month`='".$qdate."'");
							if($db_e_0->num_rows() > 0){
								$r_e_0 = $db_e_0->fetch_assoc();
								$tmp_stat5_varA = $r_e_0['varA'];
							} else {
								$db_sys = new DB2;
								$db_sys->query("SELECT `sixtarget_part4_day` FROM `system_setting` WHERE `OrgID`='".$_SESSION['nOrgID_lwj']."'");
								$r_sys = $db_sys->fetch_assoc();
								$lastday = $r_sys['sixtarget_part4_day'];
								if ($lastday == "0") {
									$lastday = lastday(substr($qdate,0,4),substr($qdate,4,2));
								}
								$db_e_1 = new DB;
								$db_e_1->query("SELECT `no` FROM `dailypatientno` WHERE `date` = '".str_replace("/","-",$qdate2)."-".$lastday."'");
								$r_e_1 = $db_e_1->fetch_assoc();	  
								if($r_e_1['no'] >0){
									$tmp_stat5_varA = $r_e_1['no'];
								} else{
									$tmp_stat5_varA = 0;
								}
							}
							?>
							<input type="text" name="sixtarget_stat5_varA" id="sixtarget_stat5_varA" size="4" value="<?php echo $tmp_stat5_varA; ?>" />
						</td>
						<td align="center">---</td>
						<td align="center">---</td>
					</tr>
					<tr>
						<td class="title_s" style="text-align:left;">Monthly resident with continuous pressure ulcer(B) - Point prevalence</td>
						<td align="center">
							<?php
							if ($r_e_0['varB']=="") {
								$db_e_2 = new DB;
								$db_e_2->query("SELECT * FROM `nurseform02g_2` WHERE `Q28_1`='1' AND `Q3_2` = '1' AND (`date` BETWEEN '".$qdate."01' AND '".$qdate.$lastday."' OR (`date` BETWEEN '".$qdate."01' AND '".$qdate."31' AND `Q7`<='".$qdate2."/".$lastday."'))");
								$tmp_stat5_varB = $db_e_2->num_rows();
							} else {
								$tmp_stat5_varB = $r_e_0['varB'];
							}
							?>
							<input type="text" name="sixtarget_stat5_varB" id="sixtarget_stat5_varB" size="4" value="<?php echo $tmp_stat5_varB; ?>" />
						</td>
						<td align="center">B/A</td>
						<td align="center"><?php if ($tmp_stat5_varA>0) { echo round(($tmp_stat5_varB/$tmp_stat5_varA)*100,1).'%'; } else { echo '---'; } ?></td>
					</tr>
					<tr>
						<td class="title_s" style="text-align:left;">Monthly total resident with pressure ulcer(B1) - Prevalence</td>
						<td align="center">
							<?php
							if ($r_e_0['varB1']=="") {
								$db_e_3 = new DB;
								$db_e_3->query("SELECT * FROM `nurseform02g_2` WHERE `Q28_1`='1' AND `Q6_3`='1' AND `Q7` BETWEEN '".$qdate2."/01' AND '".$qdate2."/31'");
								$tmp_stat5_varB1 = $db_e_3->num_rows();
							} else {
								$tmp_stat5_varB1 = $r_e_0['varB1'];
							}
							?>
							<input type="text" name="sixtarget_stat5_varB1" id="sixtarget_stat5_varB1" size="4" value="<?php echo $tmp_stat5_varB1; ?>" />
						</td>
						<td align="center">B1/A</td>
						<td align="center"><?php if ($tmp_stat5_varA>0) { echo round(($tmp_stat5_varB1/$tmp_stat5_varA)*100,1).'%'; } else { echo '---'; } ?></td>
					</tr>
					<tr>
						<td class="title_s" style="text-align:left;">Monthly residents with stage 1 pressure ulcer(C1)</td>
						<td align="center">
							<?php
							if ($r_e_0['varC1']=="") {

								$db_e_4 = new DB;
								$db_e_4->query("SELECT * FROM `nurseform02g_2` WHERE `Q28_1`='1' AND DATE_FORMAT(`date`, '%Y%m') = '".$qdate."' AND `Q4_1`='1'");
								$tmp_stat5_varC1 = $db_e_4->num_rows();
							} else {
								$tmp_stat5_varC1 = $r_e_0['varC1'];
							}
							?>
							<input type="text" name="sixtarget_stat5_varC1" id="sixtarget_stat5_varC1" size="4" value="<?php echo $tmp_stat5_varC1; ?>" />
						</td>
						<td align="center">C1/A</td>
						<td align="center"><?php if ($tmp_stat5_varA>0) { echo round(($tmp_stat5_varC1/$tmp_stat5_varA)*100,1).'%'; } else { echo '---'; } ?></td>
					</tr>
					<tr>
						<td class="title_s" style="text-align:left;">Monthly residents with stage 2 pressure ulcer(C2)</td>
						<td align="center">
							<?php
							if ($r_e_0['varC2']=="") {
								$db_e_5 = new DB;
								$db_e_5->query("SELECT * FROM `nurseform02g_2` WHERE `Q28_1`='1' AND DATE_FORMAT(`date`, '%Y%m') = '".$qdate."' AND `Q4_2`='1'");
								$tmp_stat5_varC2 = $db_e_5->num_rows();
							} else {
								$tmp_stat5_varC2 = $r_e_0['varC2'];
							}
							?>
							<input type="text" name="sixtarget_stat5_varC2" id="sixtarget_stat5_varC2" size="4" value="<?php echo $tmp_stat5_varC2; ?>" />
						</td>
						<td align="center">C2/A</td>
						<td align="center"><?php if ($tmp_stat5_varA>0) { echo round(($tmp_stat5_varC2/$tmp_stat5_varA)*100,1).'%'; } else { echo '---'; } ?></td>
					</tr>
					<tr>
						<td class="title_s" style="text-align:left;">Monthly residents with stage 3 pressure ulcer(C3)</td>
						<td align="center">
							<?php
							if ($r_e_0['varC3']=="") {
								$db_e_6 = new DB;
								$db_e_6->query("SELECT * FROM `nurseform02g_2` WHERE `Q28_1`='1' AND DATE_FORMAT(`date`, '%Y%m') = '".$qdate."' AND `Q4_3`='1'");
								$tmp_stat5_varC3 = $db_e_6->num_rows();
							} else {
								$tmp_stat5_varC3 = $r_e_0['varC3'];
							}
							?>
							<input type="text" name="sixtarget_stat5_varC3" id="sixtarget_stat5_varC3" size="4" value="<?php echo $tmp_stat5_varC3; ?>" />
						</td>
						<td align="center">C3/A</td>
						<td align="center"><?php if ($tmp_stat5_varA>0) { echo round(($tmp_stat5_varC3/$tmp_stat5_varA)*100,1).'%'; } else { echo '---'; } ?></td>
					</tr>
					<tr>
						<td class="title_s" style="text-align:left;">Monthly residents with stage 4 pressure ulcer(C4)</td>
						<td align="center">
							<?php
							if ($r_e_0['varC4']=="") {
								$db_e_7 = new DB;
								$db_e_7->query("SELECT * FROM `nurseform02g_2` WHERE `Q28_1`='1' AND DATE_FORMAT(`date`, '%Y%m') = '".$qdate."' AND `Q4_4`='1'");
								$tmp_stat5_varC4 = $db_e_7->num_rows();
							} else {
								$tmp_stat5_varC4 = $r_e_0['varC4'];
							}
							?>
							<input type="text" name="sixtarget_stat5_varC4" id="sixtarget_stat5_varC4" size="4" value="<?php echo $tmp_stat5_varC4; ?>" />
						</td>
						<td align="center">C4/A</td>
						<td align="center"><?php if ($tmp_stat5_varA>0) { echo round(($tmp_stat5_varC4/$tmp_stat5_varA)*100,1).'%'; } else { echo '---'; } ?></td>
					</tr>
				</table>
				<table width="100%">
					<tr>
						<td class="title" colspan="3">PDCA analysis</td>
					</tr>
					<tr>
						<td class="title_s" style="text-align:left;" width="260">Plan</td>
						<td colspan="2"><textarea id="sixtarget_stat5_plan" name="sixtarget_stat5_plan" rows="4"><?php echo $r_e_0['plan']; ?></textarea></td>
					</tr>
					<tr>
						<td class="title_s" style="text-align:left;">Execution (Do)</td>
						<td colspan="2"><textarea id="sixtarget_stat5_do" name="sixtarget_stat5_do" rows="4"><?php echo $r_e_0['do']; ?></textarea></td>
					</tr>
					<tr>
						<td class="title_s" style="text-align:left;">Review (Check)</td>
						<td colspan="2"><textarea id="sixtarget_stat5_check" name="sixtarget_stat5_check" rows="4"><?php echo $r_e_0['check']; ?></textarea></td>
					</tr>
					<tr>
						<td class="title_s" style="text-align:left;">Improvement plan develop and action (Action)</td>
						<td colspan="2"><textarea id="sixtarget_stat5_action" name="sixtarget_stat5_action" rows="4"><?php echo $r_e_0['action']; ?></textarea></td>
					</tr>
				</table>
				<table width="100%">
					<tr <?php if ($qdate=="%") { echo 'style="display:none;"'; } ?>>
						<td class="title"><input type="hidden" name="month" value="<?php echo $qdate; ?>" /><input type="hidden" name="tbname" value="part5" /><input type="submit" value="Save <?php echo $qdate2; ?> Statistics" class="printcol" /> <input type="submit" value="Recalculate latest data formula" name="resetstat" class="printcol" /></td>
						<td colspan="3" class="title">Last modified date:<?php echo formatdate($r_e_0['savedate']); ?> Modified by:<?php echo checkusername($r_e_0['Qfiller']); ?></td>
					</tr>
				</table>
			</form>
		</div>
		<!--壓瘡季分析-->
		<div id="tab5_part3" style="display:none;">
			<table class="content-query" style="font-size:10pt;page-break-after:always;">
				<tr class="title">
					<td width="36%">&nbsp;</td>
					<td width="16%">Season 1 (Q1)</td>
					<td width="16%">Season 2 (Q2)</td>
					<td width="16%">Season 3 (Q3)</td>
					<td width="16%">Season 4 (Q4)</td>
				</tr>
				<?php
				$arrQTab5 = array('varA'=>'Monthly total resident days(A)', 'varB'=>'Monthly resident with continuous pressure ulcer(B)', 'varBP'=>'Pressure ulcer point prevalence % (B/A)', 'varB1'=>'Monthly total resident with pressure ulcer(B1)', 'varB1P'=>'Pressure ulcer ratio% (B1/A)', 'varC1'=>'Residents with stage 1 pressure ulcer(C1)', 'varC1P'=>'Residents with stage 1 pressure ulcer ratio %(C1/A)', 'varC2'=>'Residents with stage 2 pressure ulcer(C2)', 'varC2P'=>'Residents with stage 2 pressure ulcer ratio %(C2/A)', 'varC3'=>'Residents with stage 3 pressure ulcer(C3)', 'varC3P'=>'Residents with stage 3 pressure ulcer ratio %(C3/A)', 'varC4'=>'Residents with stage 4 pressure ulcer(C4)', 'varC4P'=>'Residents with stage 4 pressure ulcer ratio %(C4/A)');
				foreach ($arrQTab5 as $ktab5 => $vtab5) {
					?>
					<tr>
						<td class="title_s" style="font-size:9pt;"><?php echo $vtab5; ?></td>
						<?php
						foreach ($arrSeasonMonth as $k3=>$v3) {
							$db3_3 = new DB;
							$db3_3->query("SELECT `month`, `".str_replace("P","",$ktab5)."` AS '".str_replace("P","",$ktab5)."' FROM `sixtarget_part5_stat` WHERE `month`>='".$v3[0]."' AND `month`<='".$v3[1]."' ORDER BY `month` ASC");
							if ($db3_3->num_rows()==0) {
								echo '<td align="center"><center>---</center></td>';
							} else {
								for ($i3_3=0;$i3_3<$db3_3->num_rows();$i3_3++) {
									$r3_3 = $db3_3->fetch_assoc();
									${'arrPart5Tab3Tmp_'.$ktab5}[$k3][$i3_3] += $r3_3[str_replace("P","",$ktab5)];
								}
								if (substr($ktab5,strlen($ktab5)-1,1)=="P") {
									if ($ktab5=="varBP" || $ktab5=="varB1P") {
										if (array_sum($arrPart5Tab3Tmp_varA[$k3])==0) {
											${'statVar'.$ktab5} = 0;
										} else {
											${'statVar'.$ktab5} = round(((array_sum(${'arrPart5Tab3Tmp_'.str_replace("P", "", $ktab5)}[$k3])/3)/(array_sum($arrPart5Tab3Tmp_varA[$k3])/3))*100,2);
										}
										echo '<td align="center"><center>'.${'statVar'.$ktab5}.' %</center></td>';
									} elseif ($ktab5=="varC1P" || $ktab5=="varC2P" || $ktab5=="varC3P" || $ktab5=="varC4P") {
										if (array_sum($arrPart5Tab3Tmp_varA[$k3])==0) {
											${'statVar'.$ktab5} = 0;
										} else {
											${'statVar'.$ktab5} = round(((array_sum(${'arrPart5Tab3Tmp_'.str_replace("P", "", $ktab5)}[$k3])/3)/(array_sum($arrPart5Tab3Tmp_varA[$k3])/3))*100,2);
										}
										echo '<td align="center"><center>'.${'statVar'.$ktab5}.' %</center></td>';
									}
								} else {
									if ($db3_3->num_rows()==0) {
										$arraysum = 0;
										$numrows = 1;
									} else {
										$arraysum = array_sum(${'arrPart5Tab3Tmp_'.$ktab5}[$k3]);
										$numrows = 3;
									}
									echo '<td align="center"><center>'.round(($arraysum/$numrows),2).'</center></td>';
								}
							}
						}
						?>
					</tr>
					<?php
				}
				?>
			</table>
		</div>
		<!--壓瘡年度分析-->
		<div id="tab5_part4" style="display:none;">
			<table class="content-query" style="page-break-after:always;">
				<tr class="title">
					<td width="22%">&nbsp;</td>
					<?php
					foreach ($arrPast12Months as $k1=>$v1) {
						echo '<td width="6.5%">'.str_replace("/","<br>",$v1).'</td>';
					}
					?>
				</tr>
				<?php
				foreach ($arrQTab5 as $ktab1 => $vtab1) {
					?>
					<tr>
						<td class="title_s" style="font-size:10pt;"><?php echo $vtab1; ?></td>
						<?php
						foreach ($arrPast12Months as $k1=>$v1) {
							$arrDateTab1Q = explode("/",$v1);
							if (strlen($arrDateTab1Q[1])==1) { $monthofq31 = '0'.$arrDateTab1Q[1]; } else { $monthofq31 = $arrDateTab1Q[1]; }
							$db3_1 = new DB;
							$db3_1->query("SELECT `".str_replace("P","",$ktab1)."` FROM `sixtarget_part5_stat` WHERE `month`='".$arrDateTab1Q[0].$monthofq31."'");
							$r3_1 = $db3_1->fetch_assoc();

							if (${'stat5_'.$ktab1}!="") { ${'stat5_'.$ktab1} .= ', '; }
							if (${'stat5_'.$ktab1.'_per'}!="") { ${'stat5_'.$ktab1.'_per'} .= ', '; }
							$second1970 = mktime(0,0,0,$arrDateTab1Q[1],1,$arrDateTab1Q[0]);
							$second1970ms = number_format(($second1970 * 1000), 0, '.', '');

							if ($r3_1['varA']!='') { ${'totalpatientstat5A_'.$arrDateTab1Q[0].$monthofq31} = $r3_1['varA']; }
							if ($r3_1['varB']!='') { ${'totalpatientstat5B_'.$arrDateTab1Q[0].$monthofq31} = $r3_1['varB']; }
							if ($db3_1->num_rows()==0) {
								echo '<td align="center"><center>---</center></td>';
								${'stat5_'.$ktab1} .= '["'.$second1970ms.'",0]';
								${'stat5_'.$ktab1.'_per'} .= '["'.$second1970ms.'",0]';
							} else {
								echo '<td align="center"><center>';
								if ($ktab1=="varBP" || $ktab1=="varB1P") {
									if (${'totalpatientstat5A_'.$arrDateTab1Q[0].$monthofq31}>0) {
										echo round(($r3_1[str_replace("P","",$ktab1)]/${'totalpatientstat5A_'.$arrDateTab1Q[0].$monthofq31})*100,1)." %";
										${'stat5_'.$ktab1.'_per'} .= '["'.$second1970ms.'",'.round(($r3_1[str_replace("P","",$ktab1)]/${'totalpatientstat5A_'.$arrDateTab1Q[0].$monthofq31})*100,1).']';
									} else {
										echo '0 %';
										${'stat5_'.$ktab1.'_per'} .= '["'.$second1970ms.'",0]';
									}
								} elseif ($ktab1=="varC1P" || $ktab1=="varC2P" || $ktab1=="varC3P" || $ktab1=="varC4P") {
									if (${'totalpatientstat5A_'.$arrDateTab1Q[0].$monthofq31}>0) {
										echo round(($r3_1[str_replace("P","",$ktab1)]/${'totalpatientstat5A_'.$arrDateTab1Q[0].$monthofq31})*100,1)." %";
										${'stat5_'.$ktab1.'_per'} .= '["'.$second1970ms.'",'.round(($r3_1[str_replace("P","",$ktab1)]/${'totalpatientstat5A_'.$arrDateTab1Q[0].$monthofq31})*100,1).']';
									} else {
										echo '0 %';
										${'stat5_'.$ktab1.'_per'} .= '["'.$second1970ms.'",0]';
									}
								} else {
									echo $r3_1[$ktab1];
									${'stat5_'.$ktab1} .= '["'.$second1970ms.'",'.$r3_1[$ktab1].']';
								}
								echo '</center></td>';
							}
						}
						?>
					</tr>
					<?php
				}
				?>
			</table><br><br>
			<style>
			#chart5a table {
				width: auto;
				left:780px;
				position:relative;
			}
			#chart5a table tr {
				background:none;
				height:auto;
				padding:0px;
				margin:0px;
			}
			#chart5a table tr td { border:none; font-size:10pt; padding: 4px 0px; }
			#chart5b table {
				width: auto;
				left:780px;
				position:relative;
			}
			#chart5b table tr {
				background:none;
				height:auto;
				padding:0px;
				margin:0px;
			}
			#chart5b table tr td { border:none; font-size:10pt; padding: 4px 0px; }
			</style>
			<h3><?php echo $arrDate[0]; ?>Annual Pressure ulcer ratio/ point prevalence</h3>
			<div id="chart5a" style="width:740px;height:420px; margin-left:50px; margin-top:50px; margin-bottom:50px; padding-top:50px; padding-bottom:50px; page-break-after:always;"></div><br /><br />
			<h3><?php echo $arrDate[0]; ?>Annual All stage of pressure ulcer prevalence</h3>
			<div id="chart5b" style="width:740px;height:420px; margin-left:40px; margin-top:50px; margin-bottom:50px; padding-top:50px; padding-bottom:50px;"></div><br /><br />
			<script type="text/javascript">
			$(function () {
				$.plot($("#chart5a"), [
					{ label: "Monthly total resident days<br>(A)",  data: [<?php echo $stat5_varA; ?>], bars: {fillColor: "#edc240"}, color: "#edc240" },
					{ label: "Monthly resident with continuous pressure ulcer<br>(B)",  data: [<?php echo $stat5_varB; ?>], bars: {fillColor: "#afd8f8"}, color: "#afd8f8" },
					{ label: "Monthly total resident with pressure ulcer<br>(B1)",  data: [<?php echo $stat5_varB1; ?>], bars: {fillColor: "#cb4b16"}, color: "#cb4b16" },
					{ label: "Pressure ulcer point prevalence %<br>(B/A)",  data: [<?php echo $stat5_varBP_per; ?>], lines: {show: true}, points: { show: true, symbol:"triangle" }, bars: {show: false},  color: "#99EC41", yaxis:2 },
					{ label: "Pressure ulcer ratio%<br>(B1/A)",  data: [<?php echo $stat5_varB1P_per; ?>], lines: {show: true}, points: { show: true, symbol:"cross" }, bars: {show: false},  color: "#9440ed", yaxis:2 }
					],
					{
						xaxis: { mode: "time", timeformat: "%y<br>%b", monthNames: [<?php for ($imonth=1;$imonth<=12;$imonth++) { if ($imonth>1) { echo ', '; } echo "'".$imonth."'"; } ?>], tickLength: 0, axisLabelUseCanvas: true, axisLabelFontSizePixels: 12, axisLabelFontFamily: "Verdana, Arial, Helvetica, Tahoma, sans-serif", axisLabelPadding: 5 },
						yaxes: [
						{tickSize: 10, tickDecimals: 0, position: 'left'},
						{tickSize: 1, tickDecimals: 1, min:0, position: 'right'}
						],
						grid: { hoverable: true, clickable: false, borderWidth: 1 },
						series: { shadowSize: 0, bars: { show: true, barWidth: 12*24*60*60*300, order: 1 } }
					});
$.plot($("#chart5b"), [
	{ label: "Residents with stage 1 pressure ulcer(C1)",  data: [<?php echo $stat5_varC1; ?>], bars: {fillColor: "#edc240"}, color: "#edc240" },
	{ label: "Residents with stage 2 pressure ulcer(C2)",  data: [<?php echo $stat5_varC2; ?>], bars: {fillColor: "#afd8f8"}, color: "#afd8f8" },
	{ label: "Residents with stage 3 pressure ulcer(C3)",  data: [<?php echo $stat5_varC3; ?>], bars: {fillColor: "#cb4b16"}, color: "#cb4b16" },
	{ label: "Residents with stage 4 pressure ulcer(C4)",  data: [<?php echo $stat5_varC4; ?>], bars: {fillColor: "#99EC41"}, color: "#99EC41" },
	{ label: "Residents with stage 1 pressure ulcer ratio<br>%(C1/A)",  data: [<?php echo $stat5_varC1P_per; ?>], lines: {show: true}, points: { show: true, symbol:"triangle" }, bars: {show: false},  color: "#edc240", yaxis:2 },
	{ label: "Residents with stage 2 pressure ulcer ratio<br>%(C2/A)",  data: [<?php echo $stat5_varC2P_per; ?>], lines: {show: true}, points: { show: true, symbol:"cross" }, bars: {show: false},  color: "#afd8f8", yaxis:2 },
	{ label: "Residents with stage 3 pressure ulcer ratio<br>%(C3/A)",  data: [<?php echo $stat5_varC3P_per; ?>], lines: {show: true}, points: { show: true, symbol:"diamond" }, bars: {show: false},  color: "#cb4b16", yaxis:2 },
	{ label: "Residents with stage 4 pressure ulcer ratio<br>%(C4/A)",  data: [<?php echo $stat5_varC4P_per; ?>], lines: {show: true}, points: { show: true, symbol:"circle" }, bars: {show: false},  color: "#99EC41", yaxis:2 }
	],
	{
		xaxis: { mode: "time", timeformat: "%y<br>%b", monthNames: [<?php for ($imonth=1;$imonth<=12;$imonth++) { if ($imonth>1) { echo ', '; } echo "'".$imonth."'"; } ?>], tickLength: 0, axisLabelUseCanvas: true, axisLabelFontSizePixels: 12, axisLabelFontFamily: "Verdana, Arial, Helvetica, Tahoma, sans-serif", axisLabelPadding: 5 },
		yaxes: [
		{tickSize: 1, tickDecimals: 0, position: 'left'},
		{tickSize: 10, tickDecimals: 1, min:0, position: 'right'}
		],
		grid: { hoverable: true, clickable: false, borderWidth: 1 },
		series: { shadowSize: 0, bars: { show: true, barWidth: 12*24*60*60*300, order: 1 } }
	});
var yaxisLabel = $("<div class='axisLabel yaxisLabel' style='position: absolute; left: -28px; top: -30px;'></div>").text("People").appendTo($('#chart5b'));
var yaxisLabel2 = $("<div class='axisLabel yaxisLabel' style='width:200px; position: absolute; left: 740px; top: -30px;'></div>").text("Point prevalence").appendTo($('#chart5b'));
var xaxisLabel = $("<div class='axisLabel xaxisLabel' style='position: absolute; left:400px; bottom: -50px;'></div>").text(" month").appendTo($('#chart5b'));
var yaxisLabel = $("<div class='axisLabel yaxisLabel' style='position: absolute; left: -28px; top: -30px;'></div>").text("People").appendTo($('#chart5a'));
var yaxisLabel2 = $("<div class='axisLabel yaxisLabel' style='width:250px; position: absolute; left: 740px; top: -30px;'></div>").text("Pressure ulcer ratio/ point prevalence").appendTo($('#chart5a'));
var xaxisLabel = $("<div class='axisLabel xaxisLabel' style='position: absolute; left:400px; bottom: -50px;'></div>").text(" month").appendTo($('#chart5a'));
});
</script>
</div>
</div>
</center>
<!--Body weight-->
<center>
<div id="tab6" style="padding:1px; font-size:11pt;">
	<h3>Unplanned weight change report</h3>
	<div align="center" style="margin-bottom:10px;">
		<?php echo draw_option("tab6option","Current month record;Current month statistic;6 months analysis;Annual analysis","xl","single",1,false,5); ?>
	</div>
	<div align="center">
		<div class="patlistbtn" style="background-color:rgb(149,219,208);"><a href="#" onclick="printDialog('6', '<?php echo $_GET['qdate']; ?>');" title="Print report"><i class="fa fa-print fa-2x fa-fw"></i><br>Print report</a></div>
	</div>
	<script>
	$('#btn_tab6option_1').click(function() {
		$('#tab6_part1').show();
		$('#tab6_part2').hide();
		$('#tab6_part3').hide();
		$('#tab6_part4').hide();
	});
	$('#btn_tab6option_2').click(function() {
		$('#tab6_part1').hide();
		$('#tab6_part2').show();
		$('#tab6_part3').hide();
		$('#tab6_part4').hide();
	});
	$('#btn_tab6option_3').click(function() {
		$('#tab6_part1').hide();
		$('#tab6_part2').hide();
		$('#tab6_part3').show();
		$('#tab6_part4').hide();
	});
	$('#btn_tab6option_4').click(function() {
		$('#tab6_part1').hide();
		$('#tab6_part2').hide();
		$('#tab6_part3').hide();
		$('#tab6_part4').show();
	});
	</script>
	<!--體重當月資料-->
	<div id="tab6_part1">
		<table class="content-query" style="font-size:10pt; font-weight:normal;">
			<tr class="title">
				<td align="center">Care ID#</td>
				<td align="center">Full name</td>
				<td align="center">Weight change</td>
				<td class="printcol">Delete</td>
			</tr>
			<?php
			$dbp1_6 = new DB;
			$dbp1_6->query("SELECT * FROM  `sixtarget_part6`  WHERE `measuredate` LIKE '".str_replace("/","",$qdate2)."%'");
			if ($dbp1_6->num_rows()==0) {
				?>
				<tr>
					<td colspan="11"><center>-------Yet no data of this month-------</center></td>
				</tr>
				<?php
			} else {
				for ($p1_i6=0;$p1_i6<$dbp1_6->num_rows();$p1_i6++) {
					$rp1_6 =$dbp1_6->fetch_assoc();
					?>
					<tr>
						<td align="center"><?php echo getHospNoDisplayByHospNo($rp1_6['HospNo']); ?></td>
						<td align="center"><?php echo getPatientName(getPID($rp1_6['HospNo'])); ?></td>
						<td align="center"><?php echo $rp1_6['weight']; ?> %</td>  
						<?php
						if ($_SESSION['ncareLevel_lwj']>=4 || $rp1_6['Qfiller']==$_SESSION['ncareID_lwj']) {
							echo '<td class="printcol"><a href="index.php?mod=management&func=formview&id=3c_6&view=6&part=1&tID='.$rp1_6['targetID'].'"><img src="Images/delete2.png" width="20"></a></td>';
						}
						?>
					</tr>
					<?php
				}
			}
			?>
		</table>
	</div>
	<!--體重當月統計-->
	<div id="tab6_part2" style="display:none;">
		<form action="index.php?func=save_sixtarget_stat" method="post" id="stat6">
			<table class="content-query">
				<tr class="title">
					<td align="center">Indicator item</td>
					<td align="center">Number</td>
					<td align="center">Formula</td>
					<td align="center">Rate(%)</td>
				</tr>
				<tr>
					<td class="title_s" style="text-align:left;">Residents entered for more than 30 days(A)</td>
					<td align="center">
						<?php
						$db_f_0 = new DB;
						$db_f_0->query("SELECT * FROM `sixtarget_part6_stat` WHERE `month`='".$qdate."'");
						if($db_f_0->num_rows() > 0){
							$r_f_0 = $db_f_0->fetch_assoc();
							$tmp_stat6_varA = $r_f_0['varA'];
						} else{
							$db_f_1 = new DB;
							$db_f_1->query("SELECT `no` FROM `dailypatientno` WHERE `date` = '".str_replace("/","-",$qdate2)."-".lastday(substr($qdate,0,4),substr($qdate,4,2))."'");
							$r_f_1 = $db_f_1->fetch_assoc();	  
							if($r_f_1['no'] >0){
								$tmp_stat6_varA = $r_f_1['no'];
							} else{
								$tmp_stat6_varA = 0;
							}
						}
						?>
						<input type="text" name="sixtarget_stat6_varA" id="sixtarget_stat6_varA" size="4" value="<?php echo $tmp_stat6_varA; ?>" />
					</td>
					<td align="center">---</td>
					<td align="center">---</td>
				</tr>
				<tr>
					<td class="title_s" style="text-align:left;">Resident entered for more than 30 days with weight loss more than 5%(B)</td>
					<td align="center">
						<?php
						if ($r_f_0['varB']=="") {
							$db_f_2 = new DB;
							$db_f_2->query("SELECT * FROM `sixtarget_part6` WHERE `weight` < 0 AND `measuredate` = '".str_replace("/","",$qdate2)."'");
							$tmp_stat6_varB = $db_f_2->num_rows();
						} else {
							$tmp_stat6_varB = $r_f_0['varB'];
						}
						?>
						<input type="text" name="sixtarget_stat6_varB" id="sixtarget_stat6_varB" size="4" value="<?php echo $tmp_stat6_varB; ?>" />
					</td>
					<td align="center">B/A</td>
					<td align="center"><?php if ($tmp_stat6_varA>0) { echo round(($tmp_stat6_varB/$tmp_stat6_varA)*100,1).'%'; } else { echo '---'; } ?></td>
				</tr>
				<tr>
					<td class="title_s" style="text-align:left;">Resident entered for more than 30 days with weight gain more than 5%(C)</td>
					<td align="center">
						<?php
						if ($r_f_0['varC']=="") {
							$db_f_3 = new DB;
							$db_f_3->query("SELECT * FROM `sixtarget_part6` WHERE `weight` > 0 AND `measuredate` = '".str_replace("/","",$qdate2)."'");
							$tmp_stat6_varC = $db_f_3->num_rows();
						} else {
							$tmp_stat6_varC = $r_f_0['varC'];
						}
						?>
						<input type="text" name="sixtarget_stat6_varC" id="sixtarget_stat6_varC" size="4" value="<?php echo $tmp_stat6_varC; ?>" />
					</td>
					<td align="center">C/A</td>
					<td align="center"><?php if ($tmp_stat6_varA>0) { echo round(($tmp_stat6_varC/$tmp_stat6_varA)*100,1).'%'; } else { echo '---'; } ?></td>
				</tr>
			</table>
			<table width="100%">
				<tr>
					<td class="title" colspan="3">PDCA analysis</td>
				</tr>
				<tr>
					<td class="title_s" style="text-align:left;" width="260">Plan</td>
					<td colspan="2"><textarea id="sixtarget_stat6_plan" name="sixtarget_stat6_plan" rows="4"><?php echo $r_f_0['plan']; ?></textarea></td>
				</tr>
				<tr>
					<td class="title_s" style="text-align:left;">Execution (Do)</td>
					<td colspan="2"><textarea id="sixtarget_stat6_do" name="sixtarget_stat6_do" rows="4"><?php echo $r_f_0['do']; ?></textarea></td>
				</tr>
				<tr>
					<td class="title_s" style="text-align:left;">Review (Check)</td>
					<td colspan="2"><textarea id="sixtarget_stat6_check" name="sixtarget_stat6_check" rows="4"><?php echo $r_f_0['check']; ?></textarea></td>
				</tr>
				<tr>
					<td class="title_s" style="text-align:left;">Improvement plan develop and action (Action)</td>
					<td colspan="2"><textarea id="sixtarget_stat6_action" name="sixtarget_stat6_action" rows="4"><?php echo $r_f_0['action']; ?></textarea></td>
				</tr>
			</table>
			<table width="100%">
				<tr <?php if ($qdate=="%") { echo 'style="display:none;"'; } ?>>
					<td class="title"><input type="hidden" name="month" value="<?php echo $qdate; ?>" /><input type="hidden" name="tbname" value="part6" /><input type="submit" value="Save <?php echo $qdate2; ?> Statistics" class="printcol" /> <input type="submit" value="Recalculate latest data formula" name="resetstat" class="printcol" /></td>
					<td colspan="3" class="title">Last modified date:<?php echo formatdate($r_f_0['savedate']); ?> Modified by:<?php echo checkusername($r_f_0['Qfiller']); ?></td>
				</tr>
			</table>
		</form>
	</div>
	<!--體重半年分析-->
	<div id="tab6_part3" style="display:none;">
		<table class="content-query" style="font-size:10pt;page-break-after:always;">
			<tr class="title">
				<td width="40%">&nbsp;</td>
				<td width="30%" align="center">1st half year</td>
				<td width="30%" align="center">2nd half year</td>
			</tr>
			<?php
			$arrQTab6 = array('varA'=>'Monthly total resident days(A)', 'varB'=>'Resident entered for more than 30 days with weight loss more than 5%(B)', 'varBP'=>'Unplanned weight loss ratio %(B/A)', 'varC'=>'Resident entered for more than 30 days with weight gain more than 5%C)', 'varCP'=>'Unplanned weight gain ratio %(C/A)');
			foreach ($arrQTab6 as $ktab5 => $vtab5) {
				?>
				<tr>
					<td class="title_s" style="font-size:9pt;"><?php echo $vtab5; ?></td>
					<?php
					foreach ($arrHYearMonth as $k3=>$v3) {
		  //echo "SELECT `month`, `".str_replace("P","",$ktab5)."` AS '".str_replace("P","",$ktab5)."' FROM `sixtarget_part6_stat` WHERE `month`>='".$v3[0]."' AND `month`<='".$v3[1]."' ORDER BY `month` ASC<br>";
						$db3_3 = new DB;
						$db3_3->query("SELECT `month`, `".str_replace("P","",$ktab5)."` AS '".str_replace("P","",$ktab5)."' FROM `sixtarget_part6_stat` WHERE `month`>='".$v3[0]."' AND `month`<='".$v3[1]."' ORDER BY `month` ASC");
						if ($db3_3->num_rows()==0) {
							echo '<td align="center"><center>---</center></td>';
						} else {
							for ($i3_3=0;$i3_3<$db3_3->num_rows();$i3_3++) {
								$r3_3 = $db3_3->fetch_assoc();
								${'arrPart6Tab3Tmp_'.$ktab5}[$k3][$i3_3] += $r3_3[str_replace("P","",$ktab5)];
							}
							if (substr($ktab5,strlen($ktab5)-1,1)=="P") {
								if ($ktab5=="varBP" || $ktab5=="varCP") {
									if (array_sum($arrPart6Tab3Tmp_varA[$k3])==0) {
										${'statVar'.$ktab5} = 0;
									} else {
										${'statVar'.$ktab5} = round(((array_sum(${'arrPart6Tab3Tmp_'.str_replace("P", "", $ktab5)}[$k3])/6)/(array_sum($arrPart6Tab3Tmp_varA[$k3])/6))*100,2);
									}
									echo '<td align="center"><center>'.${'statVar'.$ktab5}.' %</center></td>';
								}
							} else {
								if ($db3_3->num_rows()==0) {
									$arraysum = 0;
									$numrows = 1;
								} else {
									$arraysum = array_sum(${'arrPart6Tab3Tmp_'.$ktab5}[$k3]);
									$numrows = 6;
								}
								echo '<td align="center"><center>'.round(($arraysum/$numrows),2).'</center></td>';
							}
						}
					}
					?>
				</tr>
				<?php
			}
			?>
		</table>
	</div>
	<!--體重年度分析-->
	<div id="tab6_part4" style="display:none;">
		<table class="content-query">
			<tr class="title">
				<td width="22%">&nbsp;</td>
				<?php
				foreach ($arrPast12Months as $k1=>$v1) {
					echo '<td width="6.5%">'.str_replace("/","<br>",$v1).'</td>';
				}
				?>
			</tr>
			<?php
			foreach ($arrQTab6 as $ktab1 => $vtab1) {
				?>
				<tr>
					<td class="title_s" style="font-size:10pt;"><?php echo $vtab1; ?></td>
					<?php
					foreach ($arrPast12Months as $k1=>$v1) {
						$arrDateTab1Q = explode("/",$v1);
						if (strlen($arrDateTab1Q[1])==1) { $monthofq31 = '0'.$arrDateTab1Q[1]; } else { $monthofq31 = $arrDateTab1Q[1]; }
						$db3_1 = new DB;
						$db3_1->query("SELECT `".str_replace("P","",$ktab1)."` FROM `sixtarget_part6_stat` WHERE `month`='".$arrDateTab1Q[0].$monthofq31."'");
						$r3_1 = $db3_1->fetch_assoc();

						if (${'stat6_'.$ktab1}!="") { ${'stat6_'.$ktab1} .= ', '; }
						if (${'stat6_'.$ktab1.'_per'}!="") { ${'stat6_'.$ktab1.'_per'} .= ', '; }
						$second1970 = mktime(0,0,0,$arrDateTab1Q[1],1,$arrDateTab1Q[0]);
						$second1970ms = number_format(($second1970 * 1000), 0, '.', '');

						if ($r3_1['varA']!='') { ${'totalpatientstat6A_'.$arrDateTab1Q[0].$monthofq31} = $r3_1['varA']; }
						if ($db3_1->num_rows()==0) {
							echo '<td align="center"><center>---</center></td>';
							${'stat6_'.$ktab1} .= '["'.$second1970ms.'",0]';
							${'stat6_'.$ktab1.'_per'} .= '["'.$second1970ms.'",0]';
						} else {
							echo '<td align="center"><center>';
							if ($ktab1=="varBP" || $ktab1=="varCP") {
								if (${'totalpatientstat6A_'.$arrDateTab1Q[0].$monthofq31}>0) {
									echo round(($r3_1[str_replace("P","",$ktab1)]/${'totalpatientstat6A_'.$arrDateTab1Q[0].$monthofq31})*100,1)." %";
									${'stat6_'.$ktab1.'_per'} .= '["'.$second1970ms.'",'.round(($r3_1[str_replace("P","",$ktab1)]/${'totalpatientstat6A_'.$arrDateTab1Q[0].$monthofq31})*100,1).']';
								} else {
									echo '0 %';
									${'stat6_'.$ktab1.'_per'} .= '["'.$second1970ms.'",0]';
								}
							} else {
								echo $r3_1[$ktab1];
								${'stat6_'.$ktab1} .= '["'.$second1970ms.'",'.$r3_1[$ktab1].']';
							}
							echo '</center></td>';
						}
					}
					?>
				</tr>
				<?php
			}
			?>
		</table><br><br>
		<style>
		#chart6a table {
			width: auto;
			left:780px;
			position:relative;
		}
		#chart6a table tr {
			background:none;
			height:auto;
			padding:0px;
			margin:0px;
		}
		#chart6a table tr td { border:none; font-size:10pt; padding: 4px 0px; }
		</style>
		<h3><?php echo $arrDate[0]; ?>Annual unplanned weight change statistic</h3>
		<div id="chart6a" style="width:740px;height:420px; margin-left:50px; margin-top:50px; margin-bottom:50px; padding-top:50px; padding-bottom:50px;"></div><br /><br />
		<script type="text/javascript">
		$(function () {
			$.plot($("#chart6a"), [
				{ label: "Monthly total resident days <br>(A)",  data: [<?php echo $stat6_varA; ?>], bars: {fillColor: "#edc240"}, color: "#edc240" },
				{ label: "Resident entered for more than 30 days with weight loss more than 5%(B)",  data: [<?php echo $stat6_varB; ?>], bars: {fillColor: "#afd8f8"}, color: "#afd8f8" },
				{ label: "Resident entered for more than 30 days with weight gain more than 5%(C)",  data: [<?php echo $stat6_varC; ?>], bars: {fillColor: "#cb4b16"}, color: "#cb4b16" },
				{ label: "Unplanned weight loss ratio %(B/A)",  data: [<?php echo $stat6_varBP_per; ?>], lines: {show: true}, points: { show: true, symbol:"triangle" }, bars: {show: false},  color: "#99EC41", yaxis:2 },
				{ label: "Unplanned weight gain ratio%(C/A)",  data: [<?php echo $stat6_varCP_per; ?>], lines: {show: true}, points: { show: true, symbol:"cross" }, bars: {show: false},  color: "#9440ed", yaxis:2 }
				],
				{
					xaxis: { mode: "time", timeformat: "%y<br>%b", monthNames: [<?php for ($imonth=1;$imonth<=12;$imonth++) { if ($imonth>1) { echo ', '; } echo "'".$imonth."'"; } ?>], tickLength: 0, axisLabelUseCanvas: true, axisLabelFontSizePixels: 12, axisLabelFontFamily: "Verdana, Arial, Helvetica, Tahoma, sans-serif", axisLabelPadding: 5 },
					yaxes: [
					{tickSize: 10, tickDecimals: 0, position: 'left'},
					{tickSize: 1, tickDecimals: 1, min:0, position: 'right'}
					],
					grid: { hoverable: true, clickable: false, borderWidth: 1 },
					series: { shadowSize: 0, bars: { show: true, barWidth: 12*24*60*60*300, order: 1 } }
				});
var yaxisLabel = $("<div class='axisLabel yaxisLabel' style='position: absolute; left: -28px; top: -30px;'></div>").text("People").appendTo($('#chart6a'));
var yaxisLabel2 = $("<div class='axisLabel yaxisLabel' style='width:120px; position: absolute; left: 740px; top: -30px;'></div>").text("Rate").appendTo($('#chart6a'));
var xaxisLabel = $("<div class='axisLabel xaxisLabel' style='position: absolute; left:400px; bottom: -50px;'></div>").text(" month").appendTo($('#chart6a'));
});
</script>
</div>
</div>
</center>
<!--Pain-->
<center>
<div id="tab7" style="padding:1px; font-size:11pt;">
	<?php include("form3_2j.php"); ?>
</div>
</center>
<!--Nasogastric tube remove-->
<center>
<div id="tab8" style="padding:1px; font-size:11pt;">
	<?php include("form3_7.php"); ?>
</div>
</center>
<!--Catheter remove-->
<center>
<div id="tab9" style="padding:1px; font-size:11pt;">
	<?php include("form3_8.php"); ?>
</div>
</center>
<!--Falls-->
<center>
<div id="tab10" style="padding:1px; font-size:11pt;">
	<?php include("form3_10.php"); ?>
</div>
</center>
</div>
</td>
</tr>
</table>
<script>
$(function() {
	$( "#tabs" ).tabs( { active: <?php if (@$_GET['view']==NULL) { echo '0'; } else { echo (@$_GET['view']-1); } ?> } );
	<?php
	if (@$_GET['part']!="") {
		echo '
		$("div[id^=tab'.@$_GET['view'].'_part]").hide();
		$("#tab'.@$_GET['view'].'_part'.@$_GET['part'].'").show();
		'."\n";
		if (@$_GET['part']==2) {
			echo '$("#btn_tab'.@$_GET['view'].'option_1").attr("class","tabbtn_xl_left_off");';
			echo '$("#btn_tab'.@$_GET['view'].'option_2").attr("class","tabbtn_xl_middle_on");';
			echo '$("#btn_tab'.@$_GET['view'].'option_3").attr("class","tabbtn_xl_middle_off");';
		} elseif (@$_GET['part']==3) {
			echo '$("#btn_tab'.@$_GET['view'].'option_1").attr("class","tabbtn_xl_left_off");';
			echo '$("#btn_tab'.@$_GET['view'].'option_2").attr("class","tabbtn_xl_middle_off");';
			echo '$("#btn_tab'.@$_GET['view'].'option_3").attr("class","tabbtn_xl_middle_on");';
		} elseif (@$_GET['part']==4) {
			echo '$("#btn_tab'.@$_GET['view'].'option_1").attr("class","tabbtn_xl_left_off");';
			echo '$("#btn_tab'.@$_GET['view'].'option_4").attr("class","tabbtn_xl_right_on");';
		}
	}
	?>
});
</script><br><br>
