<?php
if(substr($_SESSION['ncareID_lwj'],0,8)=="resident"){
$HospNo = substr($_SESSION['ncareID_lwj'],8,6);
$db = new DB;
$db->query("SELECT `patientID` FROM `patient` WHERE `HospNo`='".mysql_escape_string($HospNo)."'");
if ($db->num_rows()>0) {
	$r = $db->fetch_assoc();
	foreach ($r as $k=>$v) {
			${$k} = $v;
	}
}
$url = "index.php?mod=nurseform&func=formview&pid=".$patientID;
echo "<script type='text/javascript'>";
echo 'window.location.href="'.$url.'"';
echo "</script>";
}else{
?>
<?php
$preURL = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$_SESSION['preURL'] = $preURL;
?>
<script>
$(function() {
    $( "#dialog-formVital" ).dialog({
		autoOpen: false,
		height:660,
		width: 640,
		modal: true,
		buttons: {
			"Input": function() {
				$.ajax({
					url: "class/dailywork_resptimes.php",
					type: "POST",
					data: {"bedID": $("#resper").val(), "date": $("#measuredate").val(),"measuretime": $("#measuretime").val(), "loinc_8480-6": $("#loinc_8480-6").val(), "loinc_8462-4":$("#loinc_8462-4").val(), "loinc_8867-4":$("#loinc_8867-4").val(), "loinc_2710-2":$("#loinc_2710-2").val(), "loinc_14743-9":$("#loinc_14743-9").val(), "loinc_15075-5":$("#loinc_15075-5").val(), "loinc_8310-5":$("#loinc_8310-5").val(), "loinc_9279-1":$("#loinc_9279-1").val(), "loinc_46033-7":$("#loinc_46033-7").val(), "loinc_18833-4":$("#loinc_18833-4").val(), "loinc_39106-0":$("#loinc_39106-0").val(), "Qfiller":'<?php echo $_SESSION['ncareID_lwj']; ?>' },
					success: function(data) {
						alert("Saved successfully!");
						$("#pinfo").text("");
						$( "#dialog-formVital" ).dialog( "close" );
						window.location.reload();
					}
				});
			},
			"Cancel": function() {
				$( "#dialog-formVital" ).dialog( "close" );
				window.location.reload();
			}
		}
	});
});
function dialogform_set(id){
	var respid = id;
	respid = respid.split(/_/);
	$("#pinfo").text(respid[1]+" Bed");
	document.getElementById('resper').value = respid[1];
	openVerificationForm('#dialog-formVital');
	var w = $("#slider_content9").width();
	$("#slider_scroll9").animate( { right:'-'+w+'px' }, 600 ,'swing');
}
</script>
<?php
if(isset($_POST['vitalDateclear'])){
	$_SESSION['vitalDate1'] = "";
	$_SESSION['vitalDate2'] = "";
	$strSQL = "";
}
if($_POST['vitalDate1'] !="____/__/__" && $_POST['vitalDate2'] !="____/__/__"){
	if(isset($_POST['Search'])){
		$_SESSION['vitalDate1'] = $_POST['vitalDate1'];
		$_SESSION['vitalDate2'] = $_POST['vitalDate2'];
		$strSQL = " AND DATE_FORMAT(`RecordedTime`,'%Y/%m/%d') >='".$_SESSION['vitalDate1']."' AND DATE_FORMAT(`RecordedTime`,'%Y/%m/%d') <='".$_SESSION['vitalDate2']."'";
	}
}

$db0 = new DB;
$db0->query("SELECT * FROM `vitalsign_range` ORDER BY `itemID` ASC");
for ($i=0;$i<$db0->num_rows();$i++) {
	$r0 = $db0->fetch_assoc();
	${$r0['itemID'].'_low'} = $r0['keylow'];
	${$r0['itemID'].'_high'} = $r0['keyhigh'];
}
?>
<div id="dialog-formVital" title="Vitalsigns"> 
  <form id="basevital">
  <fieldset><legend><span id="pinfo"></span></legend>
    <div class="nurseform-table">
    <table style="width:520px;">
      <tr>
        <td class="title" width="120">Date: </td>
        <td width="400"><script> $(function() { $( "#measuredate").datetimepicker({format:'Y-m-d', timepicker: false, mask: true}); }); </script><input type="text" name="measuredate" id="measuredate" value="<?php echo date('Y-m-d'); ?>" size="12" > <input type="text" name="measuretime" id="measuretime" value="<?php echo date(Hi); ?>" size="4" > <font size="2">(Format: HHMM)</font></td>
		<input type="hidden" id="resper" name="resper">
      </tr>
      <tr>
        <td class="title">Temperature</td>
        <td><input type="text" name="loinc_8310-5" id="loinc_8310-5" size="4" class="validate[min[<?php echo $vs83105_low; ?>],max[<?php echo $vs83105_high; ?>]]">&deg;F</td>
      </tr>
      <tr>
        <td class="title">Heart Beat</td>
        <td><input type="text" name="loinc_8867-4" id="loinc_8867-4" size="4" class="validate[min[<?php echo $vs88674_low; ?>],max[<?php echo $vs88674_high; ?>]]">times/min.</td>
      </tr>
      <tr>
        <td class="title">Respiratory Rate</td>
        <td><input type="text" name="loinc_9279-1" id="loinc_9279-1" size="4" class="validate[min[<?php echo $vs92791_low; ?>],max[<?php echo $vs92791_high; ?>]]">times/min.</td>
      </tr>
      <tr>
        <td class="title" width="120">Blood Pressure</td>
        <td width="400"><input type="text" name="loinc_8480-6" id="loinc_8480-6" size="4" class="validate[min[<?php echo $vs84806_low; ?>],max[<?php echo $vs84806_high; ?>]]">/<input type="text" name="loinc_8462-4" id="loinc_8462-4" size="4" class="validate[min[<?php echo $vs84624_low; ?>],max[<?php echo $vs82462_high; ?>]]">mmHg</td>
      </tr>
      <tr>
        <td class="title">SpO2</td>
        <td><input type="text" name="loinc_2710-2" id="loinc_2710-2" size="4" class="validate[min[<?php echo $vs27102_low; ?>],max[<?php echo $vs27102_high; ?>]]">%</td>
      </tr>
      <tr>
        <td class="title">Pain scale</td>
        <td><input type="text" name="loinc_46033-7" id="loinc_46033-7" size="4" class="validate[min[<?php echo $vs460337_low; ?>],max[<?php echo $vs460337_high; ?>]]"></td>
      </tr>
      <tr>
        <td class="title">AC Sugar</td>
        <td><input type="text" name="loinc_14743-9" id="loinc_14743-9" size="4" class="validate[min[<?php echo $vs14743_low; ?>],max[<?php echo $vs14743_high; ?>]]">mg/dl</td>
      </tr>
      <tr>
        <td class="title">PC Sugar</td>
        <td><input type="text" name="loinc_15075-5" id="loinc_15075-5" size="4" class="validate[min[<?php echo $vs150755_low; ?>],max[<?php echo $vs150755_high; ?>]]">mg/dl</td>
      </tr>
      <tr>
        <td class="title">
        Axillary temperature
		</td>
        <td>
		<input type="text" name="loinc_39106-0" id="loinc_39106-0" size="4" class="validate[min[<?php echo $vs391060_low; ?>],max[<?php echo $vs391060_high; ?>]]">
        &deg;F
		</td>
      </tr>
      <tr>
        <td class="title">Weight</td>
        <td><input type="text" name="loinc_18833-4" id="loinc_18833-4" size="4" class="validate[min[<?php echo $vs188334_low; ?>],max[<?php echo $vs188334_high; ?>]]"> lbs</td>
      </tr>
    </table>
    </div>
  </fieldset>
  </form>
</div>
<script>
$( "#basevital" ).validationEngine();
$(function() {
	$('#btn_vitalsign_1').click(function() {
		$("#code").val(1);
		$('#vital-tab1').show();
		$('#vital-tab2').hide();
		$('#vital-tab3').hide();
		$('#vital-tab4').hide();
		$('#vital-tab5').hide();
		$('#vital-tab6').hide();
		$('#vital-tab7').hide();
		$('#vital-tab8').hide();
		
	});
	$('#btn_vitalsign_2').click(function() {
		$("#code").val(2);
		$('#vital-tab1').hide();
		$('#vital-tab2').show();
		$('#vital-tab3').hide();
		$('#vital-tab4').hide();
		$('#vital-tab5').hide();
		$('#vital-tab6').hide();
		$('#vital-tab7').hide();
		$('#vital-tab8').hide();
	});
	$('#btn_vitalsign_3').click(function() {
		$("#code").val(3);
		$('#vital-tab1').hide();
		$('#vital-tab2').hide();
		$('#vital-tab3').show();
		$('#vital-tab4').hide();
		$('#vital-tab5').hide();
		$('#vital-tab6').hide();
		$('#vital-tab7').hide();
		$('#vital-tab8').hide();
	});
	$('#btn_vitalsign_4').click(function() {
		$("#code").val(4);
		$('#vital-tab1').hide();
		$('#vital-tab2').hide();
		$('#vital-tab3').hide();
		$('#vital-tab4').show();
		$('#vital-tab5').hide();
		$('#vital-tab6').hide();
		$('#vital-tab7').hide();
		$('#vital-tab8').hide();
	});
	$('#btn_vitalsign_5').click(function() {
		$("#code").val(5);
		$('#vital-tab1').hide();
		$('#vital-tab2').hide();
		$('#vital-tab3').hide();
		$('#vital-tab4').hide();
		$('#vital-tab5').show();
		$('#vital-tab6').hide();
		$('#vital-tab7').hide();
		$('#vital-tab8').hide();
	});
	$('#btn_vitalsign_6').click(function() {
		$("#code").val(6);
		$('#vital-tab1').hide();
		$('#vital-tab2').hide();
		$('#vital-tab3').hide();
		$('#vital-tab4').hide();
		$('#vital-tab5').hide();
		$('#vital-tab6').show();
		$('#vital-tab7').hide();
		$('#vital-tab8').hide();
	});
	$('#btn_vitalsign_7').click(function() {
		$("#code").val(7);
		$('#vital-tab1').hide();
		$('#vital-tab2').hide();
		$('#vital-tab3').hide();
		$('#vital-tab4').hide();
		$('#vital-tab5').hide();
		$('#vital-tab6').hide();
		$('#vital-tab7').show();
		$('#vital-tab8').hide();
	});
	$('#btn_vitalsign_8').click(function() {
		$("#code").val(1);
		$('#vital-tab1').hide();
		$('#vital-tab2').hide();
		$('#vital-tab3').hide();
		$('#vital-tab4').hide();
		$('#vital-tab5').hide();
		$('#vital-tab6').hide();
		$('#vital-tab7').hide();
		$('#vital-tab8').show();
	});
});
</script>
<?php
$db = new DB;
$db->query("SELECT * FROM `patient` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."' ORDER BY `patientID` ASC");
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	$db1 = new DB;
	$db1->query("SELECT * FROM `inpatientinfo` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."'");
	$r1 = $db1->fetch_assoc();
	/*== 解 START ==*/
	$LWJArray = array('Name1','Name2','Name3','Name4');
	$LWJdataArray = array($r['Name1'],$r['Name2'],$r['Name3'],$r['Name4']);
	for($i=0;$i<count($LWJdataArray);$i++){
	    $rsa = new lwj('lwj/lwj');
	    $puepart = explode(" ",$LWJdataArray[$i]);
	    $puepartcount = count($puepart);
	    if($puepartcount>1){
            for($j=0;$j<$puepartcount;$j++){
                $prdpart = $rsa->privDecrypt($puepart[$j]);
                $r[$LWJArray[$i]] = $r[$LWJArray[$i]].$prdpart;
            }
	    }else{
		   $r[$LWJArray[$i]] = $rsa->privDecrypt($LWJdataArray[$i]);
	    }
	}
	/*== 解 END ==*/
	if($r['Name2']!="" || $r['Name2']!=NULL){$r['Name2'] = " ".$r['Name2'];}
    if($r['Name3']!="" || $r['Name3']!=NULL){$r['Name3'] = " ".$r['Name3'];}
    if($r['Name4']!="" || $r['Name4']!=NULL){$r['Name4'] = " ".$r['Name4'];}
	$name = $r['Name1'].$r['Name2'].$r['Name3'].$r['Name4'];
	$birth = formatdate($r['Birth']);
	$indate = formatdate($r1['indate']);
}
$basicinfo = '<div class="content-query">
<table>
  <tr>
    <td class="title">Name</td>
    <td>'.$name.'</td>
    <td class="title">Birth</td>
    <td>'.$birth.'</td>
    <td class="title">Admission date</td>
    <td>'.$indate.'</td>
  </tr>
</table>
</div>'."\n";
?>
<div>
<table style="background-color: rgba(255,255,255,0.7); border-radius: 10px; padding:6px 10px 6px 10px; width:100%;">
  <tr>
    <td valign="top">
      <table>
        <tr>
          <td><input type="hidden" id="code" name="code">
		  <?php echo draw_option("vitalsign","Overview;Blood Pressure;SpO2;Blood Glucose;Temperature;Respiration;Pain;Weight","l","single",1,true,4); ?><br />&nbsp;
          </td>
      	</tr>
      	<tr>
          <td align="left">
		  <?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?>
          <form><input type="button" id="Vitalnewrecord_<?php echo getBedID(@$_GET['pid']); ?>" value="InputVitalsigns" onclick="dialogform_set(this.id);" /></form>
          <?php }?>
		  </td>
        </tr>
        <tr>
          <td align="left" colspan="2">
          <?php
		  if ($_SESSION['ncareGroup_lwj']!=3) {
		  ?>
          <form>
          <select id="vitalselmonth">
			<option>--Select month--</option>
			<?php
			for ($i=date(m);$i>=(date(m)-5);$i--) {
				$month = $i;
				$year = date(Y);
				if ($i<1) {
					$month = 12+$i;
					$year = date(Y)-1;
				}
				if (strlen($month)==1) {
					$month = "0".$month;
				}
				echo '<option value="'.$year.$month.'">'.$year.'-'.$month.'</option>'."\n";
			}
			?>
		</select>
		<input type="button" value="Print" onclick="printvitalsign('<?php echo @$_GET['pid']; ?>')">
		<input type="button" value="Print (including I/O)" onclick="printvitalsign2('<?php echo @$_GET['pid']; ?>')">
        </form>
		<script>
		function printvitalsign(pid) {
			var selectedmonth = document.getElementById('vitalselmonth').value;
			window.open('print.php?mod=dailywork&func=printvitalsign3&pid='+pid+'&date='+selectedmonth, '_blank' );
		}
		function printvitalsign2(pid) {
			var selectedmonth = document.getElementById('vitalselmonth').value;
			window.open('print.php?mod=dailywork&func=printvitalsign2&pid='+pid+'&date='+selectedmonth, '_blank' );
		}
		</script>
          <?php
		  }
		  ?>
          </td>
        </tr>
        <tr>
        <td align="left" colspan="2"><form method="post" action="<?php echo $_SESSION['preURL'];?>"><a style="color:#3F3F3F; font-size:16px; font-weight:bold;">Date: </a><script> $(function() { $( "#vitalDate1").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="vitalDate1" id="vitalDate1" size="8"  value="<?php echo $_SESSION['vitalDate1'];?>"><a style="color:#3F3F3F; font-size:16px; font-weight:bold;"> to </a><script> $(function() { $( "#vitalDate2").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="vitalDate2" id="vitalDate2" size="8"  value="<?php echo $_SESSION['vitalDate2'];?>"><input type="submit" id="Search" name="Search" value="Search" /><input type="submit" id="vitalDateclear" name="vitalDateclear" value="Clear" /><input type="button" value="Print Result" onclick="printvitalsignFromS('<?php echo @$_GET['pid']; ?>')">
</form></td>
		<script>
			function printvitalsignFromS(pid){
				var vitalDate1 = document.getElementById('vitalDate1').value;
				var vitalDate2 = document.getElementById('vitalDate2').value;
				var code = document.getElementById('code').value
				window.open('print.php?mod=dailywork&func=printvitalsign4&pid='+pid+'&date1='+vitalDate1+'&date2='+vitalDate2+'&code='+code, '_blank' );
			}
		</script>
        </tr>
  <tr>
    <td valign="top" colspan="2">
    <div id="vital-tab1">
    <table>
      <tr>
        <td valign="middle"><h3 align="center">Overview</h3></td>
        <td align="right"><?php echo $basicinfo; ?></td>
      </tr>
    </table>
    <table cellpadding="6px" style="font-size:10pt;">
      <tr bgcolor="#f7bbc3" style="color:#ffffff;">
        <td>Time</td>
        <td>Temperature</td>
        <td>Heart Beat</td>
        <td>Respiration</td>
        <td>Blood Pressure</td>
        <td>SpO2</td>
        <td>Pain</td>
        <td>AC sugar</td>
        <td>PC sugar</td>
        <td>Axillary temperature</td>
        <td>Weight</td>
        <td>Input Staff</td>
      </tr>
      <?php
	  $db2 = new DB;
	  $db2->query("SELECT `PersonID`, `RecordedTime` FROM `vitalsigns` WHERE `PersonID`='".mysql_escape_string($_GET['pid'])."' AND `IsValid`='1' ".$strSQL." GROUP BY `PersonID`, `RecordedTime` ORDER BY `RecordedTime` DESC LIMIT 0,30");
	  if ($db2->num_rows()>0) {
	  for ($i=0;$i<$db2->num_rows();$i++) {
		  $r2 = $db2->fetch_assoc();
		  $valueof_83105 = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		  $valueof_88674 = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		  $valueof_84806 = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		  $valueof_84624 = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		  $valueof_27102 = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		  $valueof_147439 = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		  $valueof_150755 = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		  $valueof_31419 = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		  $valueof_92791 = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		  $valueof_460337 = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		  $valueof_188334 = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		  $valueof_391060 = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		  $arrVitalShow = array('8310-5', '8867-4', '8480-6', '8462-4', '2710-2', '14743-9', '15075-5', '3141-9', '9279-1', '46033-7', '18833-4', '391060');
		  $db2b_1 = new DB;
		  $db2b_1->query("SELECT `LoincCode`, `Value`, `Qfiller` FROM `vitalsigns` WHERE `PersonID`='".$r2['PersonID']."' AND `RecordedTime`='".$r2['RecordedTime']."' AND `IsValid`='1'");
		  for ($j=0;$j<$db2b_1->num_rows();$j++) {
			  $r2b_1 = $db2b_1->fetch_assoc();
			  if ($r2b_1['Value']!="") { ${'valueof_'.str_replace('-','',$r2b_1['LoincCode'])} = $r2b_1['Value']; }
			  if ($r2b_1['Qfiller']!="") { $Qfiller = $r2b_1['Qfiller']; }
		  }
		  $recocordedtime = substr($r2['RecordedTime'],0,19);
		  if ($i%2==0) { $bgcolor = '#fee9e4'; } else { $bgcolor = '#ffffff'; }
		  echo '
	  <tr bgcolor="'.$bgcolor.'" align="left">
        <td align="left">'.$recocordedtime.'</td>
        <td align="left" nowrap><span '.vsRange('vs83105',$valueof_83105).'>'.$valueof_83105.'</span> <font size="2" color="#999999">&ordm;F</font></td>
        <td align="left" nowrap><span '.vsRange('vs88674',$valueof_88674).'>'.$valueof_88674.'</span> <font size="2" color="#999999"><br>times/min.</font></td>
        <td align="left" nowrap><span '.vsRange('vs92791',$valueof_92791).'>'.$valueof_92791.'</span> <font size="2" color="#999999"><br>times/min.</font></td>
        <td align="left" nowrap><span '.vsRange('vs84806',$valueof_84806).'>'.$valueof_84806.'</span> / <span '.vsRange('vs84624',$valueof_84624).'>'.$valueof_84624.'</span> <font size="2" color="#999999"><br>mmHg</font></td>
        <td align="left" nowrap><span '.vsRange('vs27102',$valueof_27102).'>'.$valueof_27102.'</span> <font size="2" color="#999999">%</font></td>
		<td align="left" nowrap><span '.vsRange('vs460337',$valueof_460337).'>'.$valueof_460337.'</span> <font size="2" color="#999999"><br>Score</font></td>
        <td align="left" nowrap><span '.vsRange('vs147439',$valueof_147439).'>'.$valueof_147439.'</span> <font size="2" color="#999999"><br>mg/dL</font></td>
        <td align="left" nowrap><span '.vsRange('vs150755',$valueof_150775).'>'.$valueof_150755.'</span> <font size="2" color="#999999"><br>mg/dL</font></td>';
		echo '<td align="left" nowrap><span '.vsRange('vs391060',$valueof_391060).'>'.$valueof_391060.'</span> <font size="2" color="#999999">&ordm;F</font></td>';
		echo '
		<td align="left" nowrap><span '.vsRange('vs188334',$valueof_188334).'>'.$valueof_188334.'</span> <font size="2" color="#999999"><br>lbs</font></td>
		<td align="left" nowrap>'.checkusername($Qfiller).'</td>
      </tr>';
	  }
	  } else {
		  echo '
	  <tr bgcolor="'.$bgcolor.'" align="left">
        <td colspan="12">No information</td>
      </tr>';
	  }
	  ?>
    </table>
    </div>
    <div id="vital-tab2" style="display:none;">
    <table>
      <tr>
        <!--<td width="32"><center><img src="Images/bpicon.png" /></center></td>-->
        <td valign="middle"><h3 align="center">Blood Pressure</h3></td>
        <td align="right"><?php echo $basicinfo; ?></td>
      </tr>
    </table>
    <div id="bpchart" style="width:720px;height:300px; margin-left:40px;"></div><br /><br />
    <table cellpadding="6px">
      <tr bgcolor="#f7bbc3" style="color:#ffffff;">
        <td>Name</td>
        <td>Type</td>
        <td>Value</td>
        <td>Measure Time</td>
        <td>Upload Time</td>
        <td>Input Staff</td>
		<?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?>
        <td>Edit</td>
		<?php }?>
      </tr>
      <?php
	  $db3 = new DB;
	  $db3->query("SELECT * FROM `vitalsigns` WHERE `PersonID`='".mysql_escape_string($_GET['pid'])."' AND ( `LoincCode`='8480-6' OR `LoincCode`='8462-4' OR `LoincCode`='8867-4' ) AND `IsValid`='1' ".$strSQL." ORDER BY `RecordedTime` DESC LIMIT 0,90");
	  $array8462 = array();
	  $array8480 = array();
	  $arrRecordDate = array();
	  $bp1 = "";
	  $bp2 = "";
	  if ($db3->num_rows()>0) {
	  for ($i=0;$i<$db3->num_rows();$i++) {
		  $r3 = $db3->fetch_assoc();
		  $RecordTime = explode(".",$r3['RecordedTime']);
		  $UploadTime = explode(".",$r3['UploadedTime']);
		  if ($i%2==0) { $bgcolor = '#fee9e4'; } else { $bgcolor = '#ffffff'; }
		  echo '
	  <tr bgcolor="'.$bgcolor.'" align="left">
        <td><a href="index.php?mod=dailywork&func=formview&pid='.$r2['PersonID'].'">'.$name.'</a></td>
        <td>'.$arrVital[$r3['LoincCode']].'</td>
        <td>'.$r3['Value'].'</td>
        <td>'.$RecordTime[0].'</td>
        <td>'.$UploadTime[0].'</td>
        <td>'.checkusername($r3['Qfiller']).'</td>';
		if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){
		echo '
		<td><a href="index.php?mod=dailywork&func=respedit&pid='.$r2['PersonID'].'&time='.substr($RecordTime[0],0,19).'"><img src="Images/edit_icon.png" width="20" border="0"></a></td>';
		}
		  echo '</tr>'."\n";
		  if (is_numeric($r3['Value'])) {
			  $RecordDate = explode(" ",$RecordTime[0]);
			  $arrRecordTime = explode(":",$RecordDate[1]); // 0:Hour 1:Minute 2:Second
			  $arrRecordDate = explode("-",$RecordDate[0]); // 0:Year 1:Month 2:Date
			  $second1970 = mktime($arrRecordTime[0],$arrRecordTime[1],$arrRecordTime[2],$arrRecordDate[1],$arrRecordDate[2],$arrRecordDate[0]);
			  $second1970ms = $second1970 * 1000;
			  if ($r3['LoincCode']=='8462-4') {
				  $arr8462[number_format($second1970ms, 0, '.', '')] = $r3['Value'];
			  } elseif ($r3['LoincCode']=='8480-6') {
				  $arr8480[number_format($second1970ms, 0, '.', '')] = $r3['Value'];
			  }
		  }
	  }
	  ksort($arr8462);
	  ksort($arr8480);
	  foreach ($arr8462 as $k1=>$v1) { $bp1 .= "[".$k1.",".$v1."],"; }
	  foreach ($arr8480 as $k2=>$v2) { $bp2 .= "[".$k2.",".$v2."],"; }
	  $bp1=substr($bp1,0,strlen($bp1)-1);
	  $bp2=substr($bp2,0,strlen($bp2)-1);
	  $bp1 = '['.$bp1.']';
	  $bp2 = '['.$bp2.']';
	  } else {
		  echo '
	  <tr bgcolor="'.$bgcolor.'" align="left">
        <td colspan="6">No information</td>
      </tr>  
		  '."\n";
	  }
	  ?>
    </table>
    <script type="text/javascript">
	$(function () {
		$.plot($("#bpchart"), [
			{ label: "Systolic",  data: <?php echo $bp2; ?> },
		    { label: "Diastolic",  data: <?php echo $bp1; ?> }
		],
		{
            lines: { show: true },
            points: { show: true },
            xaxis: {
				mode: 'time',
				panRange: [-10, 10],
				'color': '#5B5B5B'
			},
			yaxis: { panRange: [-10, 10], 'color': '#5B5B5B' },
			zoom: { interactive: false },
			pan: { interactive: false },
			grid: {
				markings: [
				  {yaxis: { from: 100, to: 140 },color: "#FFE2CF"},
				  {yaxis: { from: 90, to: 100 },color: "#FFB5B5"},
				  {yaxis: { from: 60, to: 90 },color: "#D2EFE1"},
				  {yaxis: { from: 0, to: 60 },color: "#FFB5B5"},
				  //{xaxis: { from: 1351904812000, to: 1352004812000 },color: "#808080"},
				],
				hoverable: true
			},
			crosshair: { mode: "x" }
		});
		function showTooltip(x, y, contents) {
			$('<div id="tooltip">' + contents + '</div>').css( {
				position: 'absolute',
				display: 'none',
				top: y + 5,
				left: x + 5,
				border: '1px solid #fdd',
				padding: '2px',
				'background-color': '#fee',
				opacity: 0.80
			}).appendTo("body").fadeIn(200);
		}
		var previousPoint = null;
		$("#bpchart").bind("plothover", function (event, pos, item) {
			$("#x").text(pos.x.toFixed(2));
			$("#y").text(pos.y.toFixed(2));
			if (item) {
				if (previousPoint != item.dataIndex) {
					previousPoint = item.dataIndex;
					$("#tooltip").remove();
					var x = item.datapoint[0].toFixed(0), y = item.datapoint[1].toFixed(0);
					var date = new Date();
					date.setTime(x);
					showTooltip(item.pageX, item.pageY, item.series.label + " " + y + "<br>" + date.getUTCFullYear() + '/' + (date.getUTCMonth() + 1) + '/' + date.getUTCDate() + ' ' + date.getUTCHours() + ':' + date.getUTCMinutes() );
				}
            } else {
                $("#tooltip").remove();
                previousPoint = null;            
            }
		});
	});
    </script>
    </div>
    <div id="vital-tab3" style="display:none;">
    <table>
      <tr>
        <!--<td width="32"><center><img src="Images/o2icon.png" /></center></td>-->
        <td valign="middle"><h3 align="center">SpO2</h3></td>
        <td align="right"><?php echo $basicinfo; ?></td>
      </tr>
    </table>
    <div id="oxichart" style="width:720px;height:300px; margin-left:40px;"></div><br><br><br>
    <table cellpadding="6px">
      <tr bgcolor="#f7bbc3" style="color:#ffffff;">
        <td>Name</td>
        <td>Type</td>
        <td>Value</td>
        <td>Measure Time</td>
        <td>Upload Time</td>
        <td>Input Staff</td>
		<?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?>
        <?php
		if ($_SESSION['ncareGroup_lwj']=='1' && $_SESSION['ncareLevel_lwj']>=4) {
			echo '<td>Edit</td>';
		}
		?>
		<?php }?>
      </tr>
      <?php
	  $db4 = new DB;
	  $db4->query("SELECT * FROM `vitalsigns` WHERE `PersonID`='".mysql_escape_string($_GET['pid'])."' AND `LoincCode`='2710-2' AND `IsValid`='1' ".$strSQL." ORDER BY `RecordedTime` DESC LIMIT 0,90");
	  if ($db4->num_rows()>0) {
	  for ($i=0;$i<$db4->num_rows();$i++) {
		  $r4 = $db4->fetch_assoc();
		  $RecordTime = explode(".",$r4['RecordedTime']);
		  $UploadTime = explode(".",$r4['UploadedTime']);
		  if ($i%2==0) { $bgcolor = '#fee9e4'; } else { $bgcolor = '#ffffff'; }
		  echo '
	  <tr bgcolor="'.$bgcolor.'" align="left">
        <td><a href="index.php?mod=dailywork&func=formview&pid='.$r4['PersonID'].'">'.$name.'</a></td>
        <td>'.$arrVital[$r4['LoincCode']].'</td>
        <td>'.$r4['Value'].'</td>
        <td>'.$RecordTime[0].'</td>
        <td>'.$UploadTime[0].'</td>
        <td>'.checkusername($r4['Qfiller']).'</td>';
		if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){
		if ($_SESSION['ncareGroup_lwj']=='1' && $_SESSION['ncareLevel_lwj']>=4) {
			echo '<td><a href="index.php?mod=dailywork&func=respedit&pid='.$r4['PersonID'].'&time='.substr($RecordTime[0],0,19).'"><img src="Images/edit_icon.png" width="20" border="0"></a></td>';
		}
		}
      echo '</tr>  
		  '."\n";
		  if (is_numeric($r4['Value'])) {
			  $RecordDate = explode(" ",$RecordTime[0]);
			  $arrRecordTime = explode(":",$RecordDate[1]); // 0:Hour 1:Minute 2:Second
			  $arrRecordDate = explode("-",$RecordDate[0]); // 0:Year 1:Month 2:Date
			  $second1970 = mktime($arrRecordTime[0],$arrRecordTime[1],$arrRecordTime[2],$arrRecordDate[1],$arrRecordDate[2],$arrRecordDate[0]);
			  $second1970ms = $second1970 * 1000;
			  $arr2710[number_format($second1970ms, 0, '.', '')] = $r4['Value'];
		  }
	  }
	  ksort($arr2710);
	  foreach ($arr2710 as $k1=>$v1) { $oxi .= "[".$k1.",".$v1."],"; }
	  $oxi=substr($oxi,0,strlen($oxi)-1);
	  $oxi = '['.$oxi.']';
	  } else {
		  echo '
	  <tr bgcolor="'.$bgcolor.'" align="left">
        <td colspan="6">No information</td>
      </tr>  
		  '."\n";
	  }
	  ?>
    </table>
    <?php
	if (count($arr2710)>0) {
	?>
    <script type="text/javascript">
	$(function () {
		$.plot($("#oxichart"), [
			{ label: "SpO2",  data: <?php echo $oxi; ?> }
		],
		{
            lines: { show: true },
            points: { show: true },
            xaxis: {
				mode: 'time',
				panRange: [-10, 10],
				'color': '#5B5B5B'
			},
			yaxis: { panRange: [-10, 10], 'color': '#5B5B5B' },
			zoom: { interactive: false },
			pan: { interactive: false },
			grid: {
				markings: [
				  {yaxis: { from: 90, to: 100 },color: "#FFE2CF"},
				  {yaxis: { from: 0, to: 90 },color: "#FFB5B5"}
				  //{xaxis: { from: 1351904812000, to: 1352004812000 },color: "#808080"},
				],
				hoverable: true
			},
			crosshair: { mode: "x" }
		});
		function showTooltip(x, y, contents) {
			$('<div id="tooltip">' + contents + '</div>').css( {
				position: 'absolute',
				display: 'none',
				top: y + 5,
				left: x + 5,
				border: '1px solid #fdd',
				padding: '2px',
				'background-color': '#fee',
				opacity: 0.80
			}).appendTo("body").fadeIn(200);
		}
		var previousPoint = null;
		$("#oxichart").bind("plothover", function (event, pos, item) {
			$("#x").text(pos.x.toFixed(2));
			$("#y").text(pos.y.toFixed(2));
			if (item) {
				if (previousPoint != item.dataIndex) {
					previousPoint = item.dataIndex;
					$("#tooltip").remove();
					var x = item.datapoint[0].toFixed(0), y = item.datapoint[1].toFixed(0);
					var date = new Date();
					date.setTime(x);
					showTooltip(item.pageX, item.pageY, item.series.label + " " + y + "<br>" + date.getUTCFullYear() + '/' + (date.getUTCMonth() + 1) + '/' + date.getUTCDate() + ' ' + date.getUTCHours() + ':' + date.getUTCMinutes() );
				}
            } else {
                $("#tooltip").remove();
                previousPoint = null;            
            }
		});
	});
    </script>
    <?php
	} else {
	?><script>$(function() { $("#oxichart").css("background", "#eee").css("border", "3px solid #000").css("padding", "20px").html("No information"); }); </script>
	<?php
    }
	?>
    </div>
    <div id="vital-tab4" style="display:none;">
    <table>
      <tr>
        <!--<td width="32"><center><img src="Images/bgicon.png" /></center></td>-->
        <td valign="middle"><h3 align="center">Blood Glucose</h3></td>
        <td align="right"><?php echo $basicinfo; ?></td>
      </tr>
    </table>
    <div id="bgchart" style="width:720px; height:300px; margin-left:40px;"></div><br><br><br>
    <table cellpadding="6px">
      <tr bgcolor="#f7bbc3" style="color:#ffffff;">
        <td>Name</td>
        <td>Type</td>
        <td>Value</td>
        <td>Measure Time</td>
        <td>Upload Time</td>
        <td>Input Staff</td>
		<?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?>
        <td>Edit</td>
		<?php }?>
      </tr>
      <?php
      $arr14743 = array();
      $arr15075 = array();
	  $db2 = new DB;
	  $db2->query("SELECT * FROM `vitalsigns` WHERE `PersonID`='".mysql_escape_string($_GET['pid'])."' AND (`LoincCode`='15075-5' OR `LoincCode`='14743-9') AND `IsValid`='1' ".$strSQL." ORDER BY `RecordedTime` DESC LIMIT 0,30");
	  if ($db2->num_rows()>0) {
	  for ($i=0;$i<$db2->num_rows();$i++) {
		  $r2 = $db2->fetch_assoc();
		  $RecordTime = explode(".",$r2['RecordedTime']);
		  $UploadTime = explode(".",$r2['UploadedTime']);
		  if ($i%2==0) { $bgcolor = '#fee9e4'; } else { $bgcolor = '#ffffff'; }
		  echo '
	  <tr bgcolor="'.$bgcolor.'" align="left">
        <td><a href="index.php?mod=dailywork&func=formview&pid='.$r2['PersonID'].'">'.$name.'</a></td>
        <td>'.$arrVital[$r2['LoincCode']].'</td>
        <td>'.$r2['Value'].'</td>
        <td>'.$RecordTime[0].'</td>
        <td>'.$UploadTime[0].'</td>
        <td>'.checkusername($r2['Qfiller']).'</td>';
		if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){
		echo '
		<td><a href="index.php?mod=dailywork&func=respedit&pid='.$r2['PersonID'].'&time='.substr($RecordTime[0],0,19).'"><img src="Images/edit_icon.png" width="20" border="0"></a></td>';
		}
		echo '
      </tr>  
		  '."\n";
		  if (is_numeric($r2['Value'])) {
			  $RecordDate = explode(" ",$RecordTime[0]);
			  $arrRecordTime = explode(":",$RecordDate[1]); // 0:Hour 1:Minute 2:Second
			  $arrRecordDate = explode("-",$RecordDate[0]); // 0:Year 1:Month 2:Date
			  $second1970 = mktime($arrRecordTime[0],$arrRecordTime[1],$arrRecordTime[2],$arrRecordDate[1],$arrRecordDate[2],$arrRecordDate[0]);
			  $second1970ms = $second1970 * 1000;
			  if ($r2['LoincCode']=='14743-9') {
				  $arr14743[number_format($second1970ms, 0, '.', '')] = $r2['Value'];
			  } elseif ($r2['LoincCode']=='15075-5') {
				  $arr15075[number_format($second1970ms, 0, '.', '')] = $r2['Value'];
			  }
		  }
	  }
	  ksort($arr14743);
	  ksort($arr15075);
	  foreach ($arr14743 as $k1=>$v1) { $acbg .= "[".$k1.",".$v1."],"; }
	  foreach ($arr15075 as $k2=>$v2) { $pcbg .= "[".$k2.",".$v2."],"; }
	  $acbg=substr($acbg,0,strlen($acbg)-1);
	  $acbg = '['.$acbg.']';
	  $pcbg=substr($pcbg,0,strlen($pcbg)-1);
	  $pcbg = '['.$pcbg.']';
	  } else {
		  echo '
	  <tr bgcolor="'.$bgcolor.'" align="left">
        <td colspan="6">No information</td>
      </tr>  
		  '."\n";
	  }
	  ?>
    </table>
    <?php
	if (count($arr14743)>0 || count($arr15075)>0) {
	?>
    <script type="text/javascript">
	$(function () {
		$.plot($("#bgchart"), [
			{ label: "AC Blood Glucose",  data: <?php echo $acbg; ?> },
			{ label: "PC Blood Glucose",  data: <?php echo $pcbg; ?> }
		],
		{
            lines: { show: true },
            points: { show: true },
            xaxis: {
				mode: 'time',
				panRange: [-10, 10],
				'color': '#5B5B5B'
			},
			yaxis: { panRange: [-10, 10], 'color': '#5B5B5B' },
			zoom: { interactive: false },
			pan: { interactive: false },
			grid: {
				markings: [
				  {yaxis: { from: 120, to: 500 },color: "#FFB5B5"},
				  {yaxis: { from: 90, to: 120 },color: "#FFFFFF"},
				  {yaxis: { from: 70, to: 99 },color: "#FFE2CF"},
				  {yaxis: { from: 40, to: 70 },color: "#FFFFFF"},
				  {yaxis: { from: 0, to: 40 },color: "#FFB5B5"}
				],
				hoverable: true
			},
			crosshair: { mode: "x" }
		});
		function showTooltip(x, y, contents) {
			$('<div id="tooltip">' + contents + '</div>').css( {
				position: 'absolute',
				display: 'none',
				top: y + 5,
				left: x + 5,
				border: '1px solid #fdd',
				padding: '2px',
				'background-color': '#fee',
				opacity: 0.80
			}).appendTo("body").fadeIn(200);
		}
		var previousPoint = null;
		$("#bgchart").bind("plothover", function (event, pos, item) {
			$("#x").text(pos.x.toFixed(2));
			$("#y").text(pos.y.toFixed(2));
			if (item) {
				if (previousPoint != item.dataIndex) {
					previousPoint = item.dataIndex;
					$("#tooltip").remove();
					var x = item.datapoint[0].toFixed(0), y = item.datapoint[1].toFixed(0);
					var date = new Date();
					date.setTime(x);
					showTooltip(item.pageX, item.pageY, item.series.label + " " + y + "<br>" + date.getUTCFullYear() + '/' + (date.getUTCMonth() + 1) + '/' + date.getUTCDate() + ' ' + date.getUTCHours() + ':' + date.getUTCMinutes() );
				}
            } else {
                $("#tooltip").remove();
                previousPoint = null;            
            }
		});
	});
    </script>
    <?php
	} else {
	?>
    <script>$(function() { $("#bgchart").css("background", "#eee").css("border", "3px solid #000").css("padding", "20px").html("No information"); }); </script>
    <?php
	}
	?>
    </div>
    <div id="vital-tab5" style="display:none;">
    <table>
      <tr>
        <!--<td width="32"><center><img src="Images/tpicon.png" /></center></td>-->
        <td valign="middle"><h3 align="center">Temperature</h3></td>
        <td align="right"><?php echo $basicinfo; ?></td>
      </tr>
    </table>
    <div id="tempchart" style="width:720px;height:300px; margin-left:40px;"></div><br /><br />
    <table cellpadding="6px">
      <tr bgcolor="#f7bbc3" style="color:#ffffff;">
        <td>Name</td>
        <td>Type</td>
        <td>Value</td>
        <td>Measure Time</td>
        <td>Upload Time</td>
        <td>Input Staff</td>
		<?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?>
        <td>Edit</td>
		<?php }?>
      </tr>
      <?php
      $arr8310 = array();
      $arr391060 = array();
	  $db2 = new DB;
	  $db2->query("SELECT * FROM `vitalsigns` WHERE `PersonID`='".mysql_escape_string($_GET['pid'])."' AND (`LoincCode`='8310-5' OR `LoincCode`='39106-0') AND `IsValid`='1' ".$strSQL." ORDER BY `RecordedTime` DESC LIMIT 0,30");
	  if ($db2->num_rows()>0) {
	  for ($i=0;$i<$db2->num_rows();$i++) {
		  $r2 = $db2->fetch_assoc();
		  $RecordTime = explode(".",$r2['RecordedTime']);
		  $UploadTime = explode(".",$r2['UploadedTime']);
		  if ($i%2==0) { $bgcolor = '#fee9e4'; } else { $bgcolor = '#ffffff'; }
		  echo '
	  <tr bgcolor="'.$bgcolor.'" align="left">
        <td><a href="index.php?mod=dailywork&func=formview&pid='.$r2['PersonID'].'">'.$name.'</a></td>
        <td>'.$arrVital[$r2['LoincCode']].'</td>
        <td>'.$r2['Value'].'</td>
        <td>'.$RecordTime[0].'</td>
        <td>'.$UploadTime[0].'</td>
        <td>'.checkusername($r2['Qfiller']).'</td>';
		if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){
		if ($_SESSION['ncareGroup_lwj']=='1' && $_SESSION['ncareLevel_lwj']>=4) {
			echo '<td><a href="index.php?mod=dailywork&func=respedit&pid='.$r2['PersonID'].'&time='.substr($RecordTime[0],0,19).'"><img src="Images/edit_icon.png" width="20" border="0"></a></td>';
		}
		}
		echo '
      </tr>  
		  '."\n";
		  if (is_numeric($r2['Value'])) {
			  $RecordDate = explode(" ",$RecordTime[0]);
			  $arrRecordTime = explode(":",$RecordDate[1]); // 0:Hour 1:Minute 2:Second
			  $arrRecordDate = explode("-",$RecordDate[0]); // 0:Year 1:Month 2:Date
			  $second1970 = mktime($arrRecordTime[0],$arrRecordTime[1],$arrRecordTime[2],$arrRecordDate[1],$arrRecordDate[2],$arrRecordDate[0]);
			  $second1970ms = $second1970 * 1000;
			  if ($r2['LoincCode']=="8310-5") {
				  $arr8310[number_format($second1970ms, 0, '.', '')] = $r2['Value'];
			  } elseif ($r2['LoincCode']=="39106-0") {
				  $arr391060[number_format($second1970ms, 0, '.', '')] = $r2['Value'];
			  }
		  }
	  }
	  ksort($arr8310);
	  ksort($arr391060);
	  foreach ($arr8310 as $k1=>$v1) { $temp .= "[".$k1.",".$v1."],"; }
	  $temp=substr($temp,0,strlen($temp)-1);
	  $temp = '['.$temp.']';
	  foreach ($arr391060 as $k1=>$v1) { $temp2 .= "[".$k1.",".$v1."],"; }
	  $temp2=substr($temp2,0,strlen($temp2)-1);
	  $temp2 = '['.$temp2.']';
	  } else {
		  echo '
	  <tr bgcolor="'.$bgcolor.'" align="left">
        <td colspan="6">No information</td>
      </tr>  
		  '."\n";
	  }
	  ?>
    </table>
    <?php
	if (count($arr8310)>0 || count($arr391060)>0) {
	?>
    <script type="text/javascript">
	$(function () {
		$.plot($("#tempchart"), [
			{ label: "Temperature",  data: <?php echo $temp; ?> },
			{ label: "Temperautre",  data: <?php echo $temp2; ?> }
		],
		{
            lines: { show: true },
            points: { show: true },
            xaxis: {
				mode: 'time',
				panRange: [-10, 10],
				'color': '#5B5B5B'
			},
			yaxis: { panRange: [-10, 10], 'color': '#5B5B5B' },
			zoom: { interactive: false },
			pan: { interactive: false },
			grid: {
				markings: [
				  {yaxis: { from: 100, to: 120 },color: "#FFB5B5"},
				  {yaxis: { from: 93, to: 100 },color: "#FFE2CF"},
				  {yaxis: { from: 0, to: 93 },color: "#FFB5B5"}
				],
				hoverable: true
			},
			crosshair: { mode: "x" }
		});
		function showTooltip(x, y, contents) {
			$('<div id="tooltip">' + contents + '</div>').css( {
				position: 'absolute',
				display: 'none',
				top: y + 5,
				left: x + 5,
				border: '1px solid #fdd',
				padding: '2px',
				'background-color': '#fee',
				opacity: 0.80
			}).appendTo("body").fadeIn(200);
		}
		var previousPoint = null;
		$("#tempchart").bind("plothover", function (event, pos, item) {
			$("#x").text(pos.x.toFixed(2));
			$("#y").text(pos.y.toFixed(2));
			if (item) {
				if (previousPoint != item.dataIndex) {
					previousPoint = item.dataIndex;
					$("#tooltip").remove();
					var x = item.datapoint[0].toFixed(0), y = item.datapoint[1].toFixed(0);
					var date = new Date();
					date.setTime(x);
					showTooltip(item.pageX, item.pageY, item.series.label + " " + y + "<br>" + date.getUTCFullYear() + '/' + (date.getUTCMonth() + 1) + '/' + date.getUTCDate() + ' ' + date.getUTCHours() + ':' + date.getUTCMinutes() );
				}
            } else {
                $("#tooltip").remove();
                previousPoint = null;            
            }
		});
	});
    </script>
    <?php
	} else {
	?>
    <script>$(function() { $("#tempchart").css("background", "#eee").css("border", "3px solid #000").css("padding", "20px").html("No information"); }); </script>
    <?php
	}
	?>
    </div>
    <div id="vital-tab6" style="display:none;">
    <table>
      <tr>
        <!--<td width="32"><center><img src="Images/o2icon.png" /></center></td>-->
        <td valign="middle"><h3 align="center">Respiration</h3></td>
        <td align="right"><?php echo $basicinfo; ?></td>
      </tr>
    </table>
    <div id="respchart" style="width:720px;height:300px; margin-left:40px;"></div><br><br><br>
    <table cellpadding="6px">
      <tr bgcolor="#f7bbc3" style="color:#ffffff;">
        <td>Name</td>
        <td>Type</td>
        <td>Value</td>
        <td>Measure Time</td>
        <td>Upload Time</td>
        <td>Input Staff</td>
		<?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?>
        <td>Edit</td>
		<?php }?>
      </tr>
      <?php
      $arr9279 = array();
	  $db2 = new DB;
	  $db2->query("SELECT * FROM `vitalsigns` WHERE `PersonID`='".mysql_escape_string($_GET['pid'])."' AND `LoincCode`='9279-1' AND `IsValid`='1' ".$strSQL." ORDER BY `RecordedTime` DESC LIMIT 0,30");
	  if ($db2->num_rows()>0) {
	  for ($i=0;$i<$db2->num_rows();$i++) {
		  $r2 = $db2->fetch_assoc();
		  $RecordTime = explode(".",$r2['RecordedTime']);
		  $UploadTime = explode(".",$r2['UploadedTime']);
		  if ($i%2==0) { $bgcolor = '#fee9e4'; } else { $bgcolor = '#ffffff'; }
		  echo '
	  <tr bgcolor="'.$bgcolor.'" align="left">
        <td><a href="index.php?mod=dailywork&func=formview&pid='.$r2['PersonID'].'">'.$name.'</a></td>
        <td>'.$arrVital[$r2['LoincCode']].'</td>
        <td>'.$r2['Value'].'</td>
        <td>'.$RecordTime[0].'</td>
        <td>'.$UploadTime[0].'</td>
        <td>'.checkusername($r2['Qfiller']).'</td>';
		if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){
		if ($_SESSION['ncareGroup_lwj']=='1' && $_SESSION['ncareLevel_lwj']>=4) {
			echo '<td><a href="index.php?mod=dailywork&func=respedit&pid='.$r2['PersonID'].'&time='.substr($RecordTime[0],0,19).'"><img src="Images/edit_icon.png" width="20" border="0"></a></td>';
		}
		}
		echo '
      </tr>  
		  '."\n";
		  if (is_numeric($r2['Value'])) {
			  $RecordDate = explode(" ",$RecordTime[0]);
			  $arrRecordTime = explode(":",$RecordDate[1]); // 0:Hour 1:Minute 2:Second
			  $arrRecordDate = explode("-",$RecordDate[0]); // 0:Year 1:Month 2:Date
			  $second1970 = mktime($arrRecordTime[0],$arrRecordTime[1],$arrRecordTime[2],$arrRecordDate[1],$arrRecordDate[2],$arrRecordDate[0]);
			  $second1970ms = $second1970 * 1000;
			  $arr9279[number_format($second1970ms, 0, '.', '')] = $r2['Value'];
		  }
	  }
	  ksort($arr9279);
	  foreach ($arr9279 as $k1=>$v1) { $resp .= "[".$k1.",".$v1."],"; }
	  $resp=substr($resp,0,strlen($resp)-1);
	  $resp = '['.$resp.']';
	  } else {
		  echo '
	  <tr bgcolor="'.$bgcolor.'" align="left">
        <td colspan="6">No information</td>
      </tr>  
		  '."\n";
	  }
	  ?>
    </table>
    <?php
	if (count($arr9279)>0) {
	?>
    <script type="text/javascript">
	$(function () {
		$.plot($("#respchart"), [
			{ label: "Respiratory Rate",  data: <?php echo $resp; ?> }
		],
		{
            lines: { show: true },
            points: { show: true },
            xaxis: {
				mode: 'time',
				panRange: [-10, 10],
				'color': '#5B5B5B'
			},
			yaxis: { panRange: [-10, 10], 'color': '#5B5B5B' },
			zoom: { interactive: false },
			pan: { interactive: false },
			grid: {
				markings: [
				  {yaxis: { from: 24, to: 70 },color: "#FFB5B5"},
				  {yaxis: { from: 20, to: 24 },color: "#FFFFFF"},
				  {yaxis: { from: 12, to: 20 },color: "#FFE2CF"},
				  {yaxis: { from: 10, to: 12 },color: "#FFFFFF"},
				  {yaxis: { from: 0, to: 10 },color: "#FFB5B5"}
				],
				hoverable: true
			},
			crosshair: { mode: "x" }
		});
		function showTooltip(x, y, contents) {
			$('<div id="tooltip">' + contents + '</div>').css( {
				position: 'absolute',
				display: 'none',
				top: y + 5,
				left: x + 5,
				border: '1px solid #fdd',
				padding: '2px',
				'background-color': '#fee',
				opacity: 0.80
			}).appendTo("body").fadeIn(200);
		}
		var previousPoint = null;
		$("#respchart").bind("plothover", function (event, pos, item) {
			$("#x").text(pos.x.toFixed(2));
			$("#y").text(pos.y.toFixed(2));
			if (item) {
				if (previousPoint != item.dataIndex) {
					previousPoint = item.dataIndex;
					$("#tooltip").remove();
					var x = item.datapoint[0].toFixed(0), y = item.datapoint[1].toFixed(0);
					var date = new Date();
					date.setTime(x);
					showTooltip(item.pageX, item.pageY, item.series.label + " " + y + "<br>" + date.getUTCFullYear() + '/' + (date.getUTCMonth() + 1) + '/' + date.getUTCDate() + ' ' + date.getUTCHours() + ':' + date.getUTCMinutes() );
				}
            } else {
                $("#tooltip").remove();
                previousPoint = null;            
            }
		});
	});
    </script>
    <?php
	} else {
	?>
    <script>$(function() { $("#respchart").css("background", "#eee").css("border", "3px solid #000").css("padding", "20px").html("No information"); }); </script>
    <?php
	}
	?>
    </div>
    <div id="vital-tab7" style="display:none;">
    <table>
      <tr>
        <!--<td width="32"><center><img src="Images/o2icon.png" /></center></td>-->
        <td valign="middle"><h3 align="center">Pain</h3></td>
        <td align="right"><?php echo $basicinfo; ?></td>
      </tr>
    </table>
    <div id="painchart" style="width:720px;height:300px; margin-left:40px;"></div><br><br><br>
    <table cellpadding="6px">
      <tr bgcolor="#f7bbc3" style="color:#ffffff;">
        <td>Name</td>
        <td>Type</td>
        <td>Value</td>
        <td>Measure Time</td>
        <td>Upload Time</td>
        <td>Input Staff</td>
		<?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?>
        <td>Edit</td>
		<?php }?>
      </tr>
      <?php
      $arr460337 = array();
	  $db2 = new DB;
	  $db2->query("SELECT * FROM `vitalsigns` WHERE `PersonID`='".mysql_escape_string($_GET['pid'])."' AND `LoincCode`='46033-7' AND `IsValid`='1' ".$strSQL." ORDER BY `RecordedTime` DESC LIMIT 0,30");
	  if ($db2->num_rows()>0) {
	  for ($i=0;$i<$db2->num_rows();$i++) {
		  $r2 = $db2->fetch_assoc();
		  $RecordTime = explode(".",$r2['RecordedTime']);
		  $UploadTime = explode(".",$r2['UploadedTime']);
		  if ($i%2==0) { $bgcolor = '#fee9e4'; } else { $bgcolor = '#ffffff'; }
		  echo '
	  <tr bgcolor="'.$bgcolor.'" align="left">
        <td><a href="index.php?mod=dailywork&func=formview&pid='.$r2['PersonID'].'">'.$name.'</a></td>
        <td>'.$arrVital[$r2['LoincCode']].'</td>
        <td>'.$r2['Value'].'</td>
        <td>'.$RecordTime[0].'</td>
        <td>'.$UploadTime[0].'</td>
        <td>'.checkusername($r2['Qfiller']).'</td>';
		if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){
		if ($_SESSION['ncareGroup_lwj']=='1' && $_SESSION['ncareLevel_lwj']>=4) {
			echo '<td><a href="index.php?mod=dailywork&func=respedit&pid='.$r2['PersonID'].'&time='.substr($RecordTime[0],0,19).'"><img src="Images/edit_icon.png" width="20" border="0"></a></td>';
		}
		}
		echo '
      </tr>  
		  '."\n";
		  if (is_numeric($r2['Value'])) {
			  $RecordDate = explode(" ",$RecordTime[0]);
			  $arrRecordTime = explode(":",$RecordDate[1]); // 0:Hour 1:Minute 2:Second
			  $arrRecordDate = explode("-",$RecordDate[0]); // 0:Year 1:Month 2:Date
			  $second1970 = mktime($arrRecordTime[0],$arrRecordTime[1],$arrRecordTime[2],$arrRecordDate[1],$arrRecordDate[2],$arrRecordDate[0]);
			  $second1970ms = $second1970 * 1000;
			  $arr460337[number_format($second1970ms, 0, '.', '')] = $r2['Value'];
		  }
	  }
	  ksort($arr460337);
	  foreach ($arr460337 as $k1=>$v1) { $pain .= "[".$k1.",".$v1."],"; }
	  $pain=substr($pain,0,strlen($pain)-1);
	  $pain = '['.$pain.']';
	  } else {
		  echo '
	  <tr bgcolor="'.$bgcolor.'" align="left">
        <td colspan="6">No information</td>
      </tr>  
		  '."\n";
	  }
	  ?>
    </table>
    <?php
	if (count($arr460337)>0) {
	?>
    <script type="text/javascript">
	$(function () {
		$.plot($("#painchart"), [
			{ label: "Pain scale",  data: <?php echo $pain; ?> }
		],
		{
            lines: { show: true },
            points: { show: true },
            xaxis: {
				mode: 'time',
				panRange: [-10, 10],
				'color': '#5B5B5B'
			},
			yaxis: { panRange: [-10, 10], 'color': '#5B5B5B' },
			zoom: { interactive: false },
			pan: { interactive: false },
			grid: {
				markings: [
				  {yaxis: { from: 0, to: 100 },color: "#FFE2CF"}
				],
				hoverable: true
			},
			crosshair: { mode: "x" }
		});
		function showTooltip(x, y, contents) {
			$('<div id="tooltip">' + contents + '</div>').css( {
				position: 'absolute',
				display: 'none',
				top: y + 5,
				left: x + 5,
				border: '1px solid #fdd',
				padding: '2px',
				'background-color': '#fee',
				opacity: 0.80
			}).appendTo("body").fadeIn(200);
		}
		var previousPoint = null;
		$("#painchart").bind("plothover", function (event, pos, item) {
			$("#x").text(pos.x.toFixed(2));
			$("#y").text(pos.y.toFixed(2));
			if (item) {
				if (previousPoint != item.dataIndex) {
					previousPoint = item.dataIndex;
					$("#tooltip").remove();
					var x = item.datapoint[0].toFixed(0), y = item.datapoint[1].toFixed(0);
					var date = new Date();
					date.setTime(x);
					showTooltip(item.pageX, item.pageY, item.series.label + " " + y + "<br>" + date.getUTCFullYear() + '/' + (date.getUTCMonth() + 1) + '/' + date.getUTCDate() + ' ' + date.getUTCHours() + ':' + date.getUTCMinutes() );
				}
            } else {
                $("#tooltip").remove();
                previousPoint = null;            
            }
		});
	});
    </script>
    <?php
	} else {
	?>
    <script>$(function() { $("#painchart").css("background", "#eee").css("border", "3px solid #000").css("padding", "20px").html("No information"); }); </script>
    <?php
	}
	?>
    </div>
    <div id="vital-tab8" style="display:none;">
    <table>
      <tr>
        <!--<td width="32"><center><img src="Images/o2icon.png" /></center></td>-->
        <td valign="middle"><h3 align="center">Weight</h3></td>
        <td align="right"><?php echo $basicinfo; ?></td>
      </tr>
    </table>
    <div id="bweightchart" style="width:720px;height:300px; margin-left:40px;"></div><br /><br />
    <table cellpadding="6px">
      <tr bgcolor="#f7bbc3" style="color:#ffffff;">
        <td>Name</td>
        <td>Type</td>
        <td>Value</td>
        <td>BMI</td>
        <td>Weight Change</td>
        <td>Measure Time</td>
        <td>Upload Time</td>
        <td>Input Staff</td>
		<?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?>
        <td>Edit</td>
		<?php }?>
      </tr>
      <?php
      $arr188334 = array();
	  $db2 = new DB;
	  $db2->query("SELECT * FROM `vitalsigns` WHERE `PersonID`='".mysql_escape_string($_GET['pid'])."' AND `LoincCode`='18833-4' AND `IsValid`='1' ".$strSQL." ORDER BY `RecordedTime` ASC LIMIT 0,30");
	  if ($db2->num_rows()>0) {
	  for ($i=0;$i<$db2->num_rows();$i++) {
		  $r2 = $db2->fetch_assoc();
		  $RecordTime = explode(".",$r2['RecordedTime']);
		  $UploadTime = explode(".",$r2['UploadedTime']);
		  if ($i%2==0) { $bgcolor = '#fee9e4'; } else { $bgcolor = '#ffffff'; }
		  if ($oldweight=="") {
			  $weightchange = "---";
		  } else {
			 $weightchange = round((($r2['Value']-$oldweight)/$oldweight)*100,2).' %';
		  }
		  $db5 = new DB;
		  $db5->query("SELECT `height` FROM `patient` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."'");
		  $r5 = $db5->fetch_assoc();
		  $height = $r5['height'];
		  if ($height!="0" && $height!="") {
			  $BMI = $r2['Value']/($height*$height)*703;
			  $BMI = round($BMI,1);
		  }
		  if ($BMI == "") { $BMI = "---"; }
		  echo '
	  <tr bgcolor="'.$bgcolor.'" align="left">
        <td><a href="index.php?mod=dailywork&func=formview&pid='.$r2['PersonID'].'">'.$name.'</a></td>
        <td>'.$arrVital[$r2['LoincCode']].'</td>
        <td>'.$r2['Value'].'</td>
		<td>'.$BMI.'</td>
        <td>'.$weightchange.'</td>
        <td>'.$RecordTime[0].'</td>
        <td>'.$UploadTime[0].'</td>
        <td>'.checkusername($r2['Qfiller']).'</td>';
		if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){
		echo '
		<td><a href="index.php?mod=dailywork&func=respedit&pid='.$r2['PersonID'].'&time='.substr($RecordTime[0],0,19).'"><img src="Images/edit_icon.png" width="20" border="0"></a></td>';
		}
		echo '
      </tr>  
		  '."\n";
		  if (is_numeric($r2['Value'])) {
			  $oldweight = $r2['Value'];
			  $RecordDate = explode(" ",$RecordTime[0]);
			  $arrRecordTime = explode(":",$RecordDate[1]); // 0:Hour 1:Minute 2:Second
			  $arrRecordDate = explode("-",$RecordDate[0]); // 0:Year 1:Month 2:Date
			  $second1970 = mktime($arrRecordTime[0],$arrRecordTime[1],$arrRecordTime[2],$arrRecordDate[1],$arrRecordDate[2],$arrRecordDate[0]);
			  $second1970ms = $second1970 * 1000;
			  $arr188334[number_format($second1970ms, 0, '.', '')] = $r2['Value'];
		  }
	  }
	  ksort($arr188334);
	  foreach ($arr188334 as $k1=>$v1) { $bweight .= "[".$k1.",".$v1."],"; }
	  $bweight=substr($bweight,0,strlen($bweight)-1);
	  $bweight = '['.$bweight.']';
	  } else {
		  echo '
	  <tr bgcolor="'.$bgcolor.'" align="left">
        <td colspan="8">No information</td>
      </tr>  
		  '."\n";
	  }
	  ?>
    </table>
    <?php
	if (count($arr188334)>0) {
	?>
    <script type="text/javascript">
	$(function () {
		$.plot($("#bweightchart"), [
			{ label: "Weight",  data: <?php echo $bweight; ?> }
		],
		{
            lines: { show: true },
            points: { show: true },
            xaxis: {
				mode: 'time',
				panRange: [-10, 10],
				'color': '#5B5B5B'
			},
			yaxis: { panRange: [-10, 10], 'color': '#5B5B5B' },
			zoom: { interactive: false },
			pan: { interactive: false },
			grid: {
				markings: [
				  {yaxis: { from: 308, to: 500 },color: "#FFB5B5"},
				  {yaxis: { from: 99, to: 308 },color: "#FFE2CF"},
				  {yaxis: { from: 0, to: 99 },color: "##FFB5B5"}
				],
				hoverable: true
			},
			crosshair: { mode: "x" }
		});
		function showTooltip(x, y, contents) {
			$('<div id="tooltip">' + contents + '</div>').css( {
				position: 'absolute',
				display: 'none',
				top: y + 5,
				left: x + 5,
				border: '1px solid #fdd',
				padding: '2px',
				'background-color': '#fee',
				opacity: 0.80
			}).appendTo("body").fadeIn(200);
		}
		var previousPoint = null;
		$("#bweightchart").bind("plothover", function (event, pos, item) {
			$("#x").text(pos.x.toFixed(2));
			$("#y").text(pos.y.toFixed(2));
			if (item) {
				if (previousPoint != item.dataIndex) {
					previousPoint = item.dataIndex;
					$("#tooltip").remove();
					var x = item.datapoint[0].toFixed(0), y = item.datapoint[1].toFixed(0);
					var date = new Date();
					date.setTime(x);
					showTooltip(item.pageX, item.pageY, item.series.label + " " + y + "<br>" + date.getUTCFullYear() + '/' + (date.getUTCMonth() + 1) + '/' + date.getUTCDate() + ' ' + date.getUTCHours() + ':' + date.getUTCMinutes() );
				}
            } else {
                $("#tooltip").remove();
                previousPoint = null;            
            }
		});
	});
    </script>
    <?php
	} else {
	?>
    <script>$(function() { $("#bweightchart").css("background", "#eee").css("border", "3px solid #000").css("padding", "20px").html("No information"); }); </script>
    <?php
	}
	?>
    </div>
    </td>
  </tr>		
      </table>    <!----------------------------------->
    </td>
  </tr>
</table>
</div>
<?php }?>