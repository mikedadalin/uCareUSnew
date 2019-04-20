<script>
function loadMedNames2(){
	var medicine= $("#Qmedicine2").val();
	var medList = "";
	$.ajax({
		url: 'class/med.php',
		type: "POST",
		async: false,
		data: { med: medicine}
	}).done(function(meds){
		medList = meds.split(',');
	});
	return medList;
}
function autocompleteMeds2() {
	var meds = loadMedNames2();
	$("#Qmedicine2").autocomplete({ source: meds, minLength:3 });
}
</script>
<script>
function loadMedeffect2(){
	var medicine2= $("#Qeffect2").val();
	var medeffectList = "";
	$.ajax({
		url: 'class/medeffect.php',
		type: "POST",
		async: false,
		data: { med2: medicine2}
	}).done(function(medseffect){
		medeffectList = medseffect.split(',');
	});
	return medeffectList;
}
function autocompleteMedeffect2() {
	var medseffect = loadMedeffect2();
	$("#Qeffect2").autocomplete({ source: medseffect, minLength:3 });
}
</script>
<script>
function downloadeffet2(){
	var medicine3= $("#Qmedicine2").val();
	var HospNo= $("#HospNo").val();
		for (i=1;i<=7;i++) {
			if (i==1) { var classname = "tabbtn_m_left_off"; } else
			if (i==7) { var classname = "tabbtn_m_right_off"; } else
			{ var classname = "tabbtn_m_middle_off"; }
			document.getElementById('btn_QeffectOption2_'+i).className = classname;
			document.getElementById('QeffectOption2_'+i).value = "0";
		}
		$.ajax({
			url: "class/medeffectDownload.php",
			type: "POST",
			data: {"Qmedicine": medicine3 , "HospNo": HospNo},
			success: function(data) {
				var meddata = data.split('||');
				console.log(meddata);
				$('#Qeffect2').val(meddata[0]);
				$('#Qway2').val(meddata[2]);
				$('#QwayOption2').val(meddata[2]);
				$('#Qdose2').val(meddata[3]);
				$('#Qdoseq2').val(meddata[4]);
				$('#Qusage2').val(meddata[5]);
				var medtime = meddata[1].split(';');
				for (var i=0;i<medtime.length;i++) {
					var time = parseInt(medtime[i]);
					var timetxt = time.toString();
					if (time==1) { var classname2 = "tabbtn_m_left_on"; } else
					if (time==7) { var classname2 = "tabbtn_m_right_on"; } else
					{ var classname2 = "tabbtn_m_middle_on"; }
					document.getElementById('btn_QeffectOption2_'+timetxt).className = classname2;
					document.getElementById('QeffectOption2_'+timetxt).value = '1';
				}
			}
		});
}
</script>
<script>
$(function() {
    $( "#newrecordformMedicine" ).dialog({
        autoOpen: false,
        height: 540,
        width: 630,
        modal: true,
        buttons: {
            "New medication record": function() {
                $.ajax({
                    url: "class/nurseform17.php",
                    type: "POST",
                    data: {"HospNo": $("#HospNo").val(), "QUseDate": $("#QUseDate").val(), "Qmedtime1": $("#Qmedtime2").val(), "Qmedicine1": $("#Qmedicine2").val(), "Qeffect1": $("#Qeffect2").val(), "QeffectOption1_1": $("#QeffectOption2_1").val(), "QeffectOption1_2": $("#QeffectOption2_2").val(), "QeffectOption1_3": $("#QeffectOption2_3").val(), "QeffectOption1_4": $("#QeffectOption2_4").val(), "QeffectOption1_5": $("#QeffectOption2_5").val(), "QeffectOption1_6": $("#QeffectOption2_6").val(), "QeffectOption1_7": $("#QeffectOption2_7").val(), "Qway1": $("#Qway2").val(), "Qdose1": $("#Qdose2").val(), "Qusage1": $("#Qusage2").val(), "QNeedUseDate": $("#QNeedUseDate").val(), "QNeedUseTime": $("#QNeedUseTime").val(), "QMedicationRecordType": $("#QMedicationRecordType").val(), "Qfiller": $("#Qfiller").val()  },
                    success: function(data) {
                       $( "#newrecordformMedicine" ).dialog( "close" );
                        alert("Medication record added");
                        window.location.reload();
                    }
                });
            },
            "Cancel": function() {
                $( "#newrecordformMedicine" ).dialog( "close" );
            }
        }
    });

	//#newUSErecord2_20151201_order_MedName_24HR
	$('button:button[id^="newUSErecord2_"]').click(function() {
		var w = $("#slider_content9").width();
		$("#slider_scroll9").animate( { right:'-'+w+'px' }, 600 ,'swing');
		openVerificationForm('#newrecordformMedicine');
		var arrID = $(this).attr('id');
		arrID = arrID.split('_');
		var NeedUseDate = arrID[1];
		var NeedUseTime = arrID[4];
		var needgiveMed = arrID[3];
		document.getElementById('QNeedUseDate').value = NeedUseDate;
		document.getElementById('QNeedUseTime').value = NeedUseTime;
		document.getElementById('Qmedicine2').value = needgiveMed;
		downloadeffet2();
	});
});
</script>
<div class="nurseform-table">
<div id="newrecordformMedicine" title="New medication record" class="dialog-form">
    <fieldset>
        <table>
            <tr>
                <td class="title">Record Type</td>
				<td colspan="3" style="font-size:22px;">
                  <select name="QMedicationRecordType" id="QMedicationRecordType">
	                 <option value="1">Drug delivered</option>
					 <option value="2">(NPO)</option>
					 <option value="3">(Ref)</option>
					 <option value="4">(Out)</option>
					 <option value="5">Shortage of drug(A)</option>
					 <option value="6">Pause medication(Hold)</option>
					 <option value="7">Other(＊)</option>
                  </select>
				</td>
            </tr>
            <tr>
                <td class="title">Date</td>
                <td colspan="3"><script> $(function() { $( "#QUseDate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="QUseDate" id="QUseDate" value="<?php echo date(Y."/".m."/".d); ?>" size="12">
                  <span class="title">　Time</span>
                  <input type="text" name="Qmedtime2" id="Qmedtime2" value="<?php echo date(Hi); ?>" size="4" />
                <font size="2">(Format:HHmm)</font></td>
            </tr>
            <tr>
                <td class="title">Medication</td>
                <td colspan="3"><input type="text" name="Qmedicine2" id="Qmedicine2" value="" size="40" onkeyup="autocompleteMeds2()" onclick="autocompleteMeds2()" readonly="readonly" /></td>
            </tr>
            <tr>
                <td class="title">Effect</td>
                <td colspan="3"><input type="text" name="Qeffect2" id="Qeffect2" value="" size="50" onkeyup="autocompleteMedeffect2()" onclick="autocompleteMedeffect2()"/><input type="button" value="Prescription Sync" onclick="downloadeffet2()"><br><?php echo draw_option("QeffectOption2","Antipsychotic;Antianxiety;Antidepressant;Hypnotic;Anticoagulant;Antibiotic;Diuretic","m","multi","",true,4); ?></td>
            </tr>
            <tr>
                <td class="title">Pathway</td>
                <td>
	                <select name="QwayOption2" id="QwayOption2" onchange="document.getElementById('Qway2').value = this.value;">
	                  <option></option>
	                  <option value='ALT'>ALT </option>
	                  <option value='AP'>AP </option>
	                  <option value='APPL'>APPL </option>
	                  <option value='BI'>BI </option>
	                  <option value='CEMENT'>CEMENT </option>
	                  <option value='CH'>CH </option>
	                  <option value='D'>D </option>
	                  <option value='E'>E </option>
	                  <option value='ED'>ED </option>
	                  <option value='EIF'>EIF </option>
	                  <option value='EPIDUR'>EPIDUR </option>
	                  <option value='ES'>ES </option>
	                  <option value='ET'>ET </option>
	                  <option value='FLUSH'>FLUSH </option>
	                  <option value='GA'>GA </option>
	                  <option value='GAUZE'>GAUZE </option>
	                  <option value='GRAFT'>GRAFT </option>
	                  <option value='HD'>HD </option>
	                  <option value='IA'>IA </option>
	                  <option value='IA infusion'>IA infusion </option>
	                  <option value='IC'>IC </option>
	                  <option value='ICI'>ICI </option>
	                  <option value='ID'>ID </option>
	                  <option value='IF'>IF </option>
	                  <option value='IF for EPS'>IF for EPS </option>
	                  <option value='IF CVC'>IF CVC </option>
	                  <option value='IH'>IH </option>
	                  <option value='IJ'>IJ </option>
	                  <option value='IL'>IL </option>
	                  <option value='IM'>IM </option>
	                  <option value='IMP'>IMP </option>
	                  <option value='IN'>IN </option>
	                  <option value='INIR'>INIR </option>
	                  <option value='IO'>IO </option>
	                  <option value='IOIR'>IOIR </option>
	                  <option value='IP'>IP </option>
	                  <option value='IR'>IR </option>
	                  <option value='IS'>IS </option>
	                  <option value='IT'>IT </option>
	                  <option value='ITI'>ITI </option>
	                  <option value='IV'>IV </option>
	                  <option value='IV DRIP'>IV DRIP </option>
	                  <option value='IV PUSH'>IV PUSH </option>
	                  <option value='IV via line'>IV via line </option>
	                  <option value='IVI'>IVI </option>
	                  <option value='LOCK'>LOCK </option>
	                  <option value='LZ'>LZ </option>
	                  <option value='NA'>NA </option>
	                  <option value='OD'>OD </option>
	                  <option value='OP'>OP </option>
	                  <option value='OR'>OR </option>
	                  <option value='OS'>OS</option>
	                  <option value='OU'>OU </option>
	                  <option value='Other'>Other </option>
	                  <option value='PC'>PC </option>
	                  <option value='PD'>PD </option>
	                  <option value='PL'>PL </option>
	                  <option value='PO'>PO </option>
	                  <option value='POMEAL'>POMEAL </option>
	                  <option value='R'>R </option>
	                  <option value='SA'>SA </option>
	                  <option value='SC'>SC </option>
	                  <option value='SD'>SD </option>
	                  <option value='SL'>SL </option>
	                  <option value='SP'>SP </option>
	                  <option value='SUBC'>SUBC </option>
	                  <option value='SUBT'>SUBT </option>
	                  <option value='T'>T </option>
	                  <option value='TOPIC'>TOPIC </option>
	                  <option value='U'>U </option>
	                  <option value='V'>V </option>
	                  <option value='VT'>VT </option>
	                  <option value='XX'>XX </option>
	                  <option value='cEIF'>cEIF </option>
	                  <option value='cIF'>cIF </option>
	                  <option value='cIF CVC'>cIF CVC </option>
	                  <option value='cIT'>cIT </option>
	                  <option value='cSCI'>cSCI </option>
                   </select>
				 </td>
				 <td colspan="2"><input type="text" size="6" name="Qway2" id="Qway2" value="" /></td>
			</tr>
			<tr>
				 <td class="title">Dosage</td>
				 <td colspan="3"><input type="text" name="Qdose2" id="Qdose2" value="" size="10"/>
                   <select name="Qdoseq2" id="Qdoseq2">
	                  <option></option>
	                  <option value="cc">c.c. (毫升)</option>
	                  <option value="gm">gm. (公克)</option>
	                  <option value="gtt">gtt (Drop)</option>
	                  <option value="IU">I.U.</option>
	                  <option value="kg">Kg. (公斤)</option>
	                  <option value="l">L. (公升)</option>
	                  <option value="lb">lb. (磅)</option>
	                  <option value="meq">mEq. (毫克當量)</option>
	                  <option value="mg" selected>mg. (毫克)</option>
	                  <option value="mcg" >mcg. (微克)</option>
	                  <option value="ml">ml. (毫升)</option>
	                  <option value="oz">oz. (盎司)</option>
	                  <option value="t1">T. (湯匙)</option>
	                  <option value="t2">t. (茶匙)</option>
                   </select>
				 </td>
			</tr>
			<tr>
				 <td class="title">Amount</td>
				 <td><input type="text" name="Qusage2" id="Qusage2" size="10" /></td>
				 <td colspan="2">
				 <?php
			     $arrUsageText = array(
			        array(1,2,3,4,5,6,7,8,9,0,"1/2","3/4"),
			        array("#", "Wrap", "pk", "c.c.", "Deliberate", "Drop", "Times"));
			        foreach ($arrUsageText as $k=>$v) {
			           foreach ($v as $k1=>$v1) {
			              echo ' <input type="button" value="'.$v1.'" onclick="$(\'#Qusage2\').val( $(\'#Qusage2\').val() + this.value )">';
			           } echo '<br>';
			        }
			     ?>
				 </td>
			</tr>
            <input type="hidden" name="QNeedUseDate" id="QNeedUseDate" value="">
			<input type="hidden" name="QNeedUseTime" id="QNeedUseTime" value="">
            <input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
            <input type="hidden" name="Qfiller" id="Qfiller" value="<?php echo $_SESSION['ncareID_lwj']; ?>">
        </table>
    </fieldset>
</div>
</div>
<?php
if($_GET['MedicineDate']!=""){
	$qdate_Medicine = $_GET['MedicineDate'];
}else{
	$qdate_Medicine = date(Ym);
}
?>
<?php
$drugno = 6;
$Medicine_dbno = new DB;
$Medicine_dbno->query("SELECT * FROM `nurseform17` WHERE `HospNo`='".$HospNo."' AND (`Qstartdate` < '".substr($qdate_Medicine,0,4).'/'.substr($qdate_Medicine,4,2)."/31' AND (`Qenddate` > '".substr($qdate_Medicine,0,4).'/'.substr($qdate_Medicine,4,2)."/01' OR `Qenddate`=''))");
$pageno = ceil($Medicine_dbno->num_rows()/$drugno);
$URL_MedicineDate = $qdate_Medicine;
$URL_MedicineDate_Year = substr($URL_MedicineDate,0,4);
$URL_MedicineDate_Month = substr($URL_MedicineDate,4,2);
$Previous_Month = $URL_MedicineDate_Month-1;
$Next_Month = $URL_MedicineDate_Month+1;
if($Previous_Month==0){
	$Previous_Month = "12";
	$Previous_Month_Year = $URL_MedicineDate_Year-1;
}else{
	$Previous_Month_Year = $URL_MedicineDate_Year;
}
if (strlen((int)$Previous_Month)==1) {
	$Previous_Month = "0".$Previous_Month;
}
if($Next_Month==13){
	$Next_Month = "1";
	$Next_Month_Year = $URL_MedicineDate_Year+1;
}else{
	$Next_Month_Year = $URL_MedicineDate_Year;
}
if (strlen((int)$Next_Month)==1) {
	$Next_Month = "0".$Next_Month;
}
$URL_MedicineDate_Previous = $URL_Medicine."MedicineDate=".$Previous_Month_Year.$Previous_Month;
$URL_MedicineDate_Next = $URL_Medicine."MedicineDate=".$Next_Month_Year.$Next_Month;

$Medicine_dbintake2 = new DB;
$Medicine_dbintake2->query("SELECT * FROM `medintake` WHERE `HospNo`='".$HospNo."';");
if ($Medicine_dbintake2->num_rows()>0) {
	$Medicine_rintake2 = $Medicine_dbintake2->fetch_assoc();
	foreach ($Medicine_rintake2 as $kintake2=>$vintake2) {
		if (substr($kintake2,0,1)=="Q") {
			$arrAnswer = explode("_",$kintake2);
			if (count($arrAnswer)==2) {
				if ($vintake2==1) {
					${$arrAnswer[0]} .= $arrAnswer[1].';';
				}
			}
		}
	}
}
?>
<div style="font-size:10pt; background-color: rgba(255,255,255,0.7); border-radius: 10px; padding: 0% 2%; margin-bottom:0px; min-width:960px;">
<div align="center" style="padding-top:15px; min-width:900px;"><h3 style="color:#69b3b6;"><a style="font-size:20px; color:rgb(238,203,53);" href="<?php echo $URL_MedicineDate_Previous;?>"><i class="fa fa-chevron-circle-left"></i> Previous</a><font style="padding-left:50px; padding-right:50px;"><?php echo substr($qdate_Medicine,0,4).' / '.substr($qdate_Medicine,4,2); ?> Medication Record</font><a style="font-size:20px; color:rgb(238,203,53);" href="<?php echo $URL_MedicineDate_Next;?>">Next <i class="fa fa-chevron-circle-right"></i></a></h3></div>
<div style="overflow-x:auto; text-align:center; margin-bottom:0px;">
<?php
if($Medicine_dbno->num_rows()!=0){
for ($page=1;$page<=$pageno;$page++) {
	$startno = ($page-1)*$drugno;
	$Medicine_rowno = $pageno*$drugno;
?>
<?php
	if ($pageno==$page) {
		echo '<p><font size="2">Abbreviation: Not through mouth-NPO　Refuse - Ref　Outgoing - Out　Shortage of drug -A　Pause medication - Hold　Other-＊ (Noted in Nursing records)</font></p>';
	} else {
		echo '<p style="page-break-after: always;"><font size="2">Abbreviation: Not through mouth-NPO　Refuse - Ref　Outgoing - Out　Shortage of drug -A　Pause medication - Hold　Other-＊ (Noted in Nursing records)</font></p>';
	}
?>
<table width="100%">
  <tr height="20" style="background-color:rgba(255,255,255,0.8);">
    <td style="background-color:rgba(105,179,182,0.9); color:white;" width="60">Bed #</td>
    <td width="80"><?php echo $bedID; ?></td>
    <td style="background-color:rgba(105,179,182,0.9); color:white;" width="60">Full name</td>
    <td width="80"><?php echo $name; ?></td>
    <td style="background-color:rgba(105,179,182,0.9); color:white;" width="60">Care ID#</td>
    <td width="80"><?php echo $HospNo; ?></td>
    <td style="background-color:rgba(105,179,182,0.9); color:white;" width="60">DOB</td>
    <td width="180"><?php echo $birth.' ('.checkgender(mysql_escape_string($_GET['pid'])).', '.calcage(str_replace('/','',$birth)).')'; ?></td>
    <td style="background-color:rgba(105,179,182,0.9); color:white;" width="80">Admission date</td>
    <td width="80"><?php echo $indate; ?></td>
  </tr>
  <tr height="20" style="background-color:rgba(255,255,255,0.8);">
    <td style="background-color:rgba(105,179,182,0.9); color:white;" width="80">Comment</td>
    <td colspan="9" align="left"><?php echo draw_option("Qintake_Easy","Powdery;NG","m","multi",$Qintake,false,5); ?></td>
  </tr>
  <tr height="20" style="background-color:rgba(255,255,255,0.8);">
    <td style="background-color:rgba(105,179,182,0.9); color:white;">Allergic drug</td>
    <td colspan="9" align="left">
	<?php
	$outputamed2 = '';
    $Medicine_db_amed2 = new DB;
	$Medicine_db_amed2->query("SELECT * FROM `allergicmed` WHERE `HospNo`='".$HospNo."' Order By `drugID` ASC");
	for ($i=0;$i<$Medicine_db_amed2->num_rows();$i++) {
		if ($outputamed2!="") { $outputamed2.='、'; }
		$amed2 = $Medicine_db_amed2->fetch_assoc();
		$outputamed2 .= $amed2['DrugName'];
    }
	echo $outputamed2;
	?>
    </td>
  </tr>
</table>
<table style="text-align:center;">
  <tr style="background-color:rgba(105,179,182,0.9); color:white;" height="30">
    <td width="30">Date<br>(Doctor)</td>
    <td width="100">Medication<br>(Dose)</td>
    <td width="40">Time</td>
    <?php
	echo drawmedcalwithtext($qdate_Medicine);
	?>
  </tr>
  <?php
  $Medicine_db = new DB;
  $Medicine_db->query("SELECT * FROM `nurseform17` WHERE `HospNo`='".$HospNo."' AND (`Qstartdate` < '".substr($qdate_Medicine,0,4).'/'.substr($qdate_Medicine,4,2)."/31' AND (`Qenddate` > '".substr($qdate_Medicine,0,4).'/'.substr($qdate_Medicine,4,2)."/01' OR `Qenddate`='')) LIMIT ".$startno.",".$Medicine_rowno);
  if ($page == $pageno) { $stopno = $Medicine_db->num_rows(); } else { $stopno = $drugno; }
  for ($i=0;$i<$stopno;$i++) {
	  $bgday = "";
	  $Medicine_r = $Medicine_db->fetch_assoc();
	  $time = explode(';',$Medicine_r['Qmedtime']);
	  $time2 = array_pop($time);
	  if (count($time)<=4) { $Medicine_rowspan=4; } else { $Medicine_rowspan = count($time); }
	  $pstartday = str_replace('/','',substr($Medicine_r['Qstartdate'],0,7));
	  $pendday = str_replace('/','',substr($Medicine_r['Qenddate'],0,7));
	  if ($pstartday<$qdate_Medicine) {
		  $startday = 1;
	  } else {
		  $startday = substr($Medicine_r['Qstartdate'],8,2);
	  }
	  if ($qdate_Medicine < str_replace('/','',substr($Medicine_r['Qenddate'],0,7))) {
		  $endday = date('t',strtotime(formatdate($qdate_Medicine.'01')));
	  } elseif ($Medicine_r['Qenddate']=="") {
		  $endday = date('t',strtotime(formatdate($qdate_Medicine.'01')));
	  } else {
		  $endday = substr($Medicine_r['Qenddate'],8,2);
	  }
	  for ($starti=$startday;$starti<=$endday;$starti++) {
		  $bgday .= $starti.';';
	  }
	  echo '
  <tr height="24" style="background-color:rgba(255,255,255,0.8);">
	<td rowspan="'.$Medicine_rowspan.'" style="white-space:nowrap;">'.$Medicine_r['Qstartdate'].'<br>~<br>'.$Medicine_r['Qenddate'].'<br>('.$Medicine_r['Qdoctor'].')</td>
    <td rowspan="'.$Medicine_rowspan.'" style="white-space:nowrap;">'.$Medicine_r['Qmedicine'].'<br>('.$Medicine_r['Qusage'].' '.$Medicine_r['Qdose'].$Medicine_r['Qdoseq'].')<br>'.$Medicine_r['Qway'].', '.$Medicine_r['Qfreq'].'</td>
    <td style="white-space:nowrap;">'; if (count($time)>0 && $time[0]<=9) { echo $time[0].' am'; $needgive1=1;} else { echo '&nbsp;'; $needgive1=0;} $time1_24HR = $time[0]; echo '</td>'.drawmedcal($bgday,$Medicine_r['Qmedday'],$needgive1,$i,$Medicine_r['Qmedicine'],$time1_24HR,$HospNo,$qdate_Medicine).'
  </tr>'."\n";
    if (count($time)<=4) {
		$time2 = '&nbsp;';
		$needgive2=0;
		$time3 = '&nbsp;';
		$needgive3=0;
		$time4 = '&nbsp;';
		$needgive4=0;
		for ($t1=0;$t1<count($time);$t1++) {
			if ($time[$t1]>9 && $time[$t1]<=13) { if ($time[$t1]>12) { $time2 = ($time[$t1]-12).' pm'; $needgive2=1;} elseif ($time[$t1]==12) { $time2 = '12 pm'; $needgive2=1;} else { $time2 = $time[$t1].' am'; $needgive2=1;} $time2_24HR = $time[$t1]; }
			elseif ($time[$t1]>13 && $time[$t1]<=18) { $time3 = ($time[$t1]-12).' pm'; $needgive3=1; $time3_24HR = $time[$t1];}
			elseif ($time[$t1]>18 && $time[$t1]<=23) { $time4 = ($time[$t1]-12).' pm'; $needgive4=1; $time4_24HR = $time[$t1];}
		}
		echo '
		<tr height="24" style="background-color:rgba(255,255,255,0.8);"><td style="white-space:nowrap;">'.$time2.'</td>'.drawmedcal($bgday,$Medicine_r['Qmedday'],$needgive2,$i,$Medicine_r['Qmedicine'],$time2_24HR,$HospNo,$qdate_Medicine).'</tr>
		<tr height="24" style="background-color:rgba(255,255,255,0.8);"><td style="white-space:nowrap;">'.$time3.'</td>'.drawmedcal($bgday,$Medicine_r['Qmedday'],$needgive3,$i,$Medicine_r['Qmedicine'],$time3_24HR,$HospNo,$qdate_Medicine).'</tr>
		<tr height="24" style="background-color:rgba(255,255,255,0.8);"><td style="white-space:nowrap;">'.$time4.'</td>'.drawmedcal($bgday,$Medicine_r['Qmedday'],$needgive4,$i,$Medicine_r['Qmedicine'],$time4_24HR,$HospNo,$qdate_Medicine).'</tr>
		';
	} elseif (count($time)==0) {
		echo '<tr height="24" style="background-color:rgba(255,255,255,0.8);"><td>&nbsp;</td>'.drawmedcal('','','','','','','',$qdate_Medicine).'</tr>'."\n";
		echo '<tr height="24" style="background-color:rgba(255,255,255,0.8);"><td>&nbsp;</td>'.drawmedcal('','','','','','','',$qdate_Medicine).'</tr>'."\n";
		echo '<tr height="24" style="background-color:rgba(255,255,255,0.8);"><td>&nbsp;</td>'.drawmedcal('','','','','','','',$qdate_Medicine).'</tr>'."\n";
	} else {
		for ($t1=1;$t1<count($time);$t1++) {
			if ($time[$t1]>12) { $manytime = ($time[$t1]-12).' pm'; ${"needgive".$t1}=1;} elseif ($time[$t1]==12) { $manytime = '12 pm'; ${"needgive".$t1}=1;} else { $manytime = $time[$t1].' am'; ${"needgive".$t1}=1;}
			$manytime_24HR = $time[$t1];
			echo '<tr height="24" style="background-color:rgba(255,255,255,0.8);"><td style="white-space:nowrap;">'.$manytime.'</td>'.drawmedcal($bgday,$Medicine_r['Qmedday'], ${"needgive".$t1},$i,$Medicine_r['Qmedicine'],$manytime_24HR,$HospNo,$qdate_Medicine).'</tr>'."\n";
		}
	}
  }
  if ($pageno == $page && $Medicine_db->num_rows()<$drugno) {
	  $addspaceno = $drugno - $Medicine_db->num_rows();
	  for ($k=0;$k<$addspaceno;$k++) {
  ?>
  <tr height="24" style="background-color:rgba(255,255,255,0.8);">
    <td rowspan="4">&nbsp;</td>
    <td rowspan="4">&nbsp;</td>
    <td>&nbsp;</td>
    <?php echo drawmedcal('','','','','','','',$qdate_Medicine); ?>
  </tr>
  <tr height="24" style="background-color:rgba(255,255,255,0.8);">
    <td>&nbsp;</td>
    <?php echo drawmedcal('','','','','','','',$qdate_Medicine); ?>
  </tr>
  <tr height="24" style="background-color:rgba(255,255,255,0.8);">
    <td>&nbsp;</td>
    <?php echo drawmedcal('','','','','','','',$qdate_Medicine); ?>
  </tr>
  <tr height="24" style="background-color:rgba(255,255,255,0.8);">
    <td>&nbsp;</td>
    <?php echo drawmedcal('','','','','','','',$qdate_Medicine); ?>
  </tr>
  <?php
	  }
  }
  ?>
</table>
<br>
<?php
}
}else{
	echo '<div><p style="font-size:20px;">no data</p></div>';
}
?>
</div></div>