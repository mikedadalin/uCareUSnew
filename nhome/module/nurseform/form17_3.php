<?php
$db = new DB;
$db->query("SELECT * FROM `nurseform17` WHERE `HospNo`='".$HospNo."' AND `date`='".mysql_real_escape_string(@$_GET['date'])."' AND `order`='".mysql_real_escape_string(@$_GET['order'])."'");
if ($db->num_rows()>0) {
	$r = $db->fetch_assoc();
	foreach ($r as $k=>$v) {
		$arrPatientInfo = explode("_",$k);
		if (count($arrPatientInfo)==2) {
			if ($v==1) {
				${$arrPatientInfo[0]} .= $arrPatientInfo[1].';';
			}
		} else {
			${$k} = $v;
		}
	}
    $QmedtimeSelectNumber = explode(";",$Qmedtime);
	$QmedtimeSelectNumber = count($QmedtimeSelectNumber)-1;
	if($QmedtimeSelectNumber=="0" || $QmedtimeSelectNumber=="-1"){$QmedtimeSelectNumber="";}
    $QmeddaySelectNumber = explode(";",$Qmedday);
	$QmeddaySelectNumber = count($QmeddaySelectNumber)-1;
	if($QmeddaySelectNumber=="0" || $QmeddaySelectNumber=="-1"){$QmeddaySelectNumber="";}
}
?>
<script>
function checkSelectQmedtime(id){
	var classNameArray = document.getElementById(id).className.split("_");
	var classNameType = classNameArray[3];
	var SelectNumber = new Number(document.getElementById('SelectQmedtime').value);
	if(classNameType=="on"){
		  document.getElementById('SelectQmedtime').value = eval(SelectNumber+1);
	}
	if(classNameType=="off"){
		if(eval(SelectNumber-1)==0){
			document.getElementById('SelectQmedtime').value = "";
		}else{
			document.getElementById('SelectQmedtime').value = eval(SelectNumber-1);
		}
	}
}
function checkSelectQmedday(id){
	var classNameArray = document.getElementById(id).className.split("_");
	var classNameType = classNameArray[3];
	var SelectNumber = new Number(document.getElementById('SelectQmedday').value);
	if(classNameType=="on"){
		  document.getElementById('SelectQmedday').value = eval(SelectNumber+1);
	}
	if(classNameType=="off"){
		if(eval(SelectNumber-1)==0){
			document.getElementById('SelectQmedday').value = "";
		}else{
			document.getElementById('SelectQmedday').value = eval(SelectNumber-1);
		}
	}
}
</script>
<form action="index.php?func=medwork&pid=<?php echo @$_GET['pid']; ?>&action=edit" method="post" onSubmit="return checkForm();" id="base">
<h3><?php if(substr($_SESSION['ncareID_lwj'],0,8)=="resident"){ echo 'Prescription Record';}else{ echo 'Edit Prescription Record';}?></h3>
    <table>
      <tr>
        <td class="title" width="120">Medication</td>
        <td colspan="3"><?php echo $Qmedicine ?><input type="hidden" name="order" id="order" value="<?php echo $order; ?>" ></td>
      </tr>
      <tr>
        <td class="title" width="100">Source</td>
        <td colspan="3"><input type="text" name="Qsource" id="Qsource" value="<?php echo mb_substr($Qsource,0,5,"utf-8"); ?>" size="10" maxlength="5"/></td>
      </tr>
      <tr>
        <td class="title" width="120">Effect</td>
        <td colspan="3"><input type="text" name="Qeffect" id="Qeffect" value="<?php echo $Qeffect; ?>" size="60" /><br><?php echo draw_option("QeffectOption","Antipsychotic;Antianxiety;Antidepressant;Hypnotic;Anticoagulant;Antibiotic;Diuretic","l","multi",$QeffectOption,true,5); ?></td>
      </tr>
      <tr>
          <td class="title">Pathway</td>
	 <td width="430">
	<script>
	function selectmedtime(freq) {
		for (i=1;i<=24;i++) {
			if (i==1 || i==13) { var classname = "tabbtn_s_left_off"; } else
			if (i==12 || i==24) { var classname = "tabbtn_s_right_off"; } else
			{ var classname = "tabbtn_s_middle_off"; }
			document.getElementById('btn_Qmedtime_'+i).className = classname;
			document.getElementById('Qmedtime_'+i).value = "0";
		}
		$.ajax({
			url: "class/meddata.php",
			type: "POST",
			data: {"freqID": freq },
			success: function(data) {
				var meddata = data.split('||');
				console.log(meddata);
				$('#Qfreq').val(meddata[0]);
				$('#Qfreqtext').html(meddata[1]);
				var medtime = meddata[2].split(';');
				for (var i=0;i<medtime.length;i++) {
					var time = parseInt(medtime[i])+1;
					var timetxt = time.toString();
					if (time==1 || time==13) { var classname2 = "tabbtn_s_left_on"; } else
					if (time==12 || time==24) { var classname2 = "tabbtn_s_right_on"; } else
					{ var classname2 = "tabbtn_s_middle_on"; }
					document.getElementById('btn_Qmedtime_'+timetxt).className = classname2;
					document.getElementById('Qmedtime_'+timetxt).value = '1';
				}
			}
		});
	}
	</script>
	<select onchange="document.getElementById('Qway').value = this.value;">
	  <option></option>
   <option value='ALT'>ALT (抗生素留置治療)</option>
   <option value='AP'>AP (口腔噴霧)</option>
   <option value='APPL'>APPL (術中施用)</option>
   <option value='BI'>BI (膀胱灌注)</option>
   <option value='CEMENT'>CEMENT (骨水泥)</option>
   <option value='CH'>CH (咀嚼)</option>
   <option value='D'>D (皮膚用)</option>
   <option value='E'>E (耳用)</option>
   <option value='ED'>ED (右耳用)</option>
   <option value='EIF'>EIF (硬膜外點滴輸注)</option>
   <option value='EPIDUR'>EPIDUR (硬膜外注射)</option>
   <option value='ES'>ES (左耳用)</option>
   <option value='ET'>ET (氣管內給藥)</option>
   <option value='FLUSH'>FLUSH (導管沖洗)</option>
   <option value='GA'>GA (漱口)</option>
   <option value='GAUZE'>GAUZE (止血綿)</option>
   <option value='GRAFT'>GRAFT (異體移植)</option>
   <option value='HD'>HD (血液透析)</option>
   <option value='IA'>IA (動脈注射)</option>
   <option value='IA infusion'>IA infusion (動脈輸注)</option>
   <option value='IC'>IC (心內注射)</option>
   <option value='ICI'>ICI (前房內注射)</option>
   <option value='ID'>ID (皮內注射)</option>
   <option value='IF'>IF (靜脈點滴輸注)</option>
   <option value='IF for EPS'>IF for EPS (心臟電生理檢查之靜脈輸注)</option>
   <option value='IF CVC'>IF CVC (中央靜脈點滴輸注)</option>
   <option value='IH'>IH (吸入)</option>
   <option value='IJ'>IJ (注射)</option>
   <option value='IL'>IL (病灶注射)</option>
   <option value='IM'>IM (肌肉注射)</option>
   <option value='IMP'>IMP (植入)</option>
   <option value='IN'>IN (鼻用)</option>
   <option value='INIR'>INIR (鼻內灌洗)</option>
   <option value='IO'>IO (眼內注射)</option>
   <option value='IOIR'>IOIR (眼球內沖洗)</option>
   <option value='IP'>IP (腹腔注射)</option>
   <option value='IR'>IR (灌洗)</option>
   <option value='IS'>IS (關節滑液囊注射)</option>
   <option value='IT'>IT (脊腔注射)</option>
   <option value='ITI'>ITI (耳膜內注射)</option>
   <option value='IV'>IV (靜脈注射)</option>
   <option value='IV DRIP'>IV DRIP (靜脈點滴)</option>
   <option value='IV PUSH'>IV PUSH (靜脈注射)</option>
   <option value='IV via line'>IV via line (經管道靜脈注射)</option>
   <option value='IVI'>IVI (玻璃體內注射)</option>
   <option value='LOCK'>LOCK (導管留置)</option>
   <option value='LZ'>LZ (口含後吞服)</option>
   <option value='NA'>NA (指甲用)</option>
   <option value='OD'>OD (右眼用)</option>
   <option value='OP'>OP (開刀前使用)</option>
   <option value='OR'>OR (口腔用)</option>
   <option value='OS'>OS (左眼用)</option>
   <option value='OU'>OU (雙眼用)</option>
   <option value='Other'>Other (其他途徑)</option>
   <option value='PC'>PC (經皮注射)</option>
   <option value='PD'>PD (腹膜透析)</option>
   <option value='PL'>PL (胸腔注射)</option>
   <option value='PO' selected>PO (口服)</option>
   <option value='POMEAL'>POMEAL (隨餐口服)</option>
   <option value='R'>R (肛門用)</option>
   <option value='SA'>SA (蜘蛛膜下)</option>
   <option value='SC'>SC (皮下注射)</option>
   <option value='SD'>SD (硬腦膜下)</option>
   <option value='SL'>SL (舌下)</option>
   <option value='SP'>SP (洗髮用)</option>
   <option value='SUBC'>SUBC (結膜下注射)</option>
   <option value='SUBT'>SUBT (Tenon下注射)</option>
   <option value='T'>T (局部用)</option>
   <option value='TOPIC'>TOPIC (局部點藥)</option>
   <option value='U'>U (尿道用)</option>
   <option value='V'>V (陰道用)</option>
   <option value='VT'>VT (經管道)</option>
   <option value='XX'>XX (遵照醫師指示)</option>
   <option value='cEIF'>cEIF (連續硬膜外點滴輸注)</option>
   <option value='cIF'>cIF (連續靜脈點滴輸注)</option>
   <option value='cIF CVC'>cIF CVC (連續中央靜脈點滴輸注)</option>
   <option value='cIT'>cIT (連續脊腔輸注)</option>
   <option value='cSCI'>cSCI (連續皮下輸注)</option>
	  </select></td>
	 <td colspan="2"><input type="text" size="6" name="Qway" id="Qway" value="<?php echo $Qway; ?>" /></td>
	 </tr>
      <tr>
        <td class="title">Frequency</td>
        <td><select onchange="selectmedtime(this.value);" id="freqselect">
          <option></option>
          <?php
		  $db1 = new DB;
		  $db1->query("SELECT * FROM `medfreq` ORDER BY `avaliable`, `code`");
		  for ($i=0;$i<$db1->num_rows();$i++) {
			  $r1 = $db1->fetch_assoc();
			  echo '<option value="'.$r1['freqID'].'">'.$r1['code'].' ('.$r1['name'].')'.'</option>'."\n";
		  }
		  ?>
        </select></td>
        <td colspan="2"><input type="text" size="10" name="Qfreq" id="Qfreq"  value="<?php echo $Qfreq; ?>" /><span id="Qfreqtext"></span></td>
      </tr>
      <tr>
          <td class="title">Dose</td>
          <td colspan="3"><input type="text" name="Qdose" id="Qdose" size="10"  value="<?php echo $Qdose; ?>"/><input type="text" name="Qdoseq" id="Qdoseq" size="10"  value="<?php echo $Qdoseq; ?>"/></td>
      </tr>
      <tr>
        <td class="title">Intake amount</td>
        <td><input type="text" name="Qusage" id="Qusage" size="3" value="<?php echo $Qusage; ?>" /></td>
		<td colspan="2">
        <?php
		$arrUsageText = array(
			array(1,2,3,4,5,6,7,8,9,0,"1/2","3/4"),
			array("#", "Wrap", "pk", "c.c.", "Deliberate", "Drop", "Time(s)"));
		foreach ($arrUsageText as $k=>$v) {
			foreach ($v as $k1=>$v1) {
			echo ' <input type="button" value="'.$v1.'" onclick="$(\'#Qusage\').val( $(\'#Qusage\').val() + this.value )">';
			} echo '<br>';
		}
		?>
        </td>
      </tr>
      <tr>
        <td class="title">Medication time<input type="text" name="SelectQmedtime" id="SelectQmedtime" class="validate[required]" style="width:0px; height:0px; border:0px;" value="<?php echo $QmedtimeSelectNumber;?>"></td>
        <?php
		$medtimearr = explode(";",$Qmedtime);
		foreach ($medtimearr as $k=>$v) {
			if ($v!="") {
				if ($medtimetxt!="") { $medtimetxt .= ";"; }
				$medtimetxt .= $v+1;
			}
		}
		?>
        <td colspan="3"><?php echo draw_option("Qmedtime","0;1;2;3;4;5;6;7;8;9;10;11;12;13;14;15;16;17;18;19;20;21;22;23","s","multi",$medtimetxt,true,12); ?></td>
      </tr>
      <tr>
		<td class="title">Medication day<input type="text" name="SelectQmedday" id="SelectQmedday" class="validate[required]" style="width:0px; height:0px; border:0px;" value="<?php echo $QmeddaySelectNumber;?>"></td>
        <?php
		$meddayarr = explode(";",$Qmedday);
		foreach ($meddayarr as $k=>$v) {
			if ($v!="") {
				if ($meddaytxt!="") { $meddaytxt .= ";"; }
				$meddaytxt .= $v+1;
			}
		}
		?>
        <td colspan="3"><?php echo draw_option("Qmedday","Mon;Tue;Wed;Thu;Fri;Sat;Sun;Every day;Every 2 day","xm","multi",$meddaytxt,false,7); ?></td>
      </tr>
      <tr>
        <td class="title">Start date</td>
        <td><?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?><script> $(function() { $( "#Qstartdate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><?php }?>
          <input type="text" name="Qstartdate" id="Qstartdate" value="<?php if ($Qstartdate != NULL) { echo $Qstartdate; } else { echo date('Y/m/d'); } ?>" size="12" class="validate[required, custom[date]]"/></td>
        <td class="title">End date</td>
        <td><?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?><script> $(function() { $( "#Qenddate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><?php }?>
          <input type="text" name="Qenddate" id="Qenddate" value="<?php if ($Qenddate != NULL) { echo $Qenddate; } ?>" size="12" class="validate[required, custom[date]]"/></td>
      </tr>
      <tr>
        <td class="title">Doctor</td>
        <td colspan="3"><input type="text" name="Qdoctor" id="Qdoctor" size="30" value="<?php echo $Qdoctor;?>"/></td>
      </tr>
    </table>
<table width="100%">
  <tr>
    <td>Filled date：<?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><?php }?><input type="text" name="date" id="date" value="<?php if($_GET['newDate']!="") { echo formatdate($_GET['newDate']); } else { if ($date != NULL) { echo formatdate($date); } } ?>" size="12"> <?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?><input type="button" value="Today" onclick="inputdate('date');" /><?php }?></td>
    <td align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>
<center><input type="hidden" name="formID" id="formID" value="nurseform17" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button><?php }?></center>
</form>
<script>
$(function() {
	$('#base').validationEngine();
});
</script>