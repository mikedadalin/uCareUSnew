<script>
function loadMedNames(){
	var medicine= $("#Qmedicine1").val();
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
function autocompleteMeds() {
	var meds = loadMedNames();
	$("#Qmedicine1").autocomplete({ source: meds, minLength:3 });
}
</script>
<script>
function loadMedeffect(){
	var medicine2= $("#Qeffect1").val();
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
function autocompleteMedeffect() {
	var medseffect = loadMedeffect();
	$("#Qeffect1").autocomplete({ source: medseffect, minLength:3 });
}
</script>
<script>
function downloadeffet(){
	var medicine3= $("#Qmedicine1").val();
	var HospNo= $("#HospNo").val();
		for (i=1;i<=7;i++) {
			if (i==1) { var classname = "tabbtn_l_left_off"; } else
			if (i==7) { var classname = "tabbtn_l_right_off"; } else
			{ var classname = "tabbtn_l_middle_off"; }
			document.getElementById('btn_QeffectOption1_'+i).className = classname;
			document.getElementById('QeffectOption1_'+i).value = "0";
		}
		$.ajax({
			url: "class/medeffectDownload.php",
			type: "POST",
			data: {"Qmedicine": medicine3 , "HospNo": HospNo},
			success: function(data) {
				var meddata = data.split('||');
				console.log(meddata);
				$('#Qeffect1').val(meddata[0]);
				var medtime = meddata[1].split(';');
				for (var i=0;i<medtime.length;i++) {
					var time = parseInt(medtime[i]);
					var timetxt = time.toString();
					if (time==1) { var classname2 = "tabbtn_l_left_on"; } else
					if (time==7) { var classname2 = "tabbtn_l_right_on"; } else
					{ var classname2 = "tabbtn_l_middle_on"; }
					document.getElementById('btn_QeffectOption1_'+timetxt).className = classname2;
					document.getElementById('QeffectOption1_'+timetxt).value = '1';
				}
			}
		});
}
</script>
<script>
$(function() {
    $( "#newrecordform" ).dialog({
        autoOpen: false,
        height: 540,
        width: 800,
        modal: true,
        buttons: {
            "New medication record": function() {
                $.ajax({
                    url: "class/nurseform17.php",
                    type: "POST",
                    data: {"HospNo": $("#HospNo").val(), "QUseDate": $("#QUseDate").val(), "Qmedtime1": $("#Qmedtime1").val(), "Qmedicine1": $("#Qmedicine1").val(), "Qeffect1": $("#Qeffect1").val(), "QeffectOption1_1": $("#QeffectOption1_1").val(), "QeffectOption1_2": $("#QeffectOption1_2").val(), "QeffectOption1_3": $("#QeffectOption1_3").val(), "QeffectOption1_4": $("#QeffectOption1_4").val(), "QeffectOption1_5": $("#QeffectOption1_5").val(), "QeffectOption1_6": $("#QeffectOption1_6").val(), "QeffectOption1_7": $("#QeffectOption1_7").val(), "Qway1": $("#Qway1").val(), "Qdose1": $("#Qdose1").val(), "Qusage1": $("#Qusage1").val(), "Qfiller": $("#Qfiller").val()  },
                    success: function(data) {
                        var arr = data.split(/;/);
                        $( "#newrecordtable tbody" ).append( "<tr>" +
                        "<td>" + arr[0] + "</td>" + 
                        "<td>" + arr[1] + "</td>" + 
                        "<td>" + arr[2] + "</td>" +
                        "<td>" + arr[3] + "</td>" + 
                        "<td>" + arr[4] + "</td>" +
                        "<td>" + arr[5] + "</td>" +
                        "<td>" + arr[6] + "</td>" +
						"<td>" + arr[7] + "</td>" +
						"<td>" + arr[8] + "</td>" +
                        "<td><form><input type=\"button\" id=\"delete_"+$("#HospNo").val()+"_"+$("#QUseDate").val()+"_"+$('#Qmedtime1').val()+"\" onclick=\"confirmdelete(this.id);\" value=\"Delete\"></form></td>" +  "</tr>" );
                        $( "#newrecordform" ).dialog( "close" );
                        alert("Medication record added");
                        window.location.reload();
                    }
                });
            },
            "Cancel": function() {
                $( "#newrecordform" ).dialog( "close" );
            }
        }
    });
    $( "#newUSErecord" ).button().click(function() {
        $( "#newrecordform" ).dialog( "open" );
    });
});
</script>
<div class="nurseform-table">
<div id="newrecordform" title="New medication record" onclick="filloldrecord()">
    <fieldset>
        <table>
            <tr>
                <td class="title" width="100">Date</td>
                <td colspan="3"><script> $(function() { $( "#QUseDate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="QUseDate" id="QUseDate" value="<?php echo date(Y."/".m."/".d); ?>" size="12">
                  <span class="title">　Time</span>
                  <input type="text" name="Qmedtime1" id="Qmedtime1" value="<?php echo date(Hi); ?>" size="4" />
                <font size="2">(Format:HHmm)</font></td>
            </tr>
            <tr>
                <td class="title" width="100">Medication</td>
                <td colspan="3"><input type="text" name="Qmedicine1" id="Qmedicine1" value="" size="40" onkeyup="autocompleteMeds()" onclick="autocompleteMeds()"/></td>
            </tr>
            <tr>
                <td class="title" width="120">Effect</td>
                <td colspan="3"><input type="text" name="Qeffect1" id="Qeffect1" value="" size="50" onkeyup="autocompleteMedeffect()" onclick="autocompleteMedeffect()"/><input type="button" value="Prescription Sync" onclick="downloadeffet()"><?php echo draw_option("QeffectOption1","Antipsychotic;Antianxiety;Antidepressant;Hypnotic;Anticoagulant;Antibiotic;Diuretic","l","multi","",true,3); ?></td>
            </tr>
            <tr>
                <td class="title">Pathway</td>
                <td>
	                <select onchange="document.getElementById('Qway1').value = this.value;">
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
                   </select>
				 </td>
				 <td colspan="2"><input type="text" size="6" name="Qway1" id="Qway1" value="PO" /></td>
			</tr>
			<tr>
				 <td class="title">Dosage</td>
				 <td colspan="3"><input type="text" name="Qdose1" id="Qdose1" value="" size="10"/>
                   <select name="Qdoseq1" id="Qdoseq1">
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
				 <td><input type="text" name="Qusage1" id="Qusage1" size="10" /></td>
				 <td colspan="2">
				 <?php
			     $arrUsageText = array(
			        array(1,2,3,4,5,6,7,8,9,0,"1/2","3/4"),
			        array("#", "Wrap", "pk", "c.c.", "Deliberate", "Drop", "Times"));
			        foreach ($arrUsageText as $k=>$v) {
			           foreach ($v as $k1=>$v1) {
			              echo ' <input type="button" value="'.$v1.'" onclick="$(\'#Qusage1\').val( $(\'#Qusage1\').val() + this.value )">';
			           } echo '<br>';
			        }
			     ?>
				 </td>
			</tr>
            <tr>
                <td valign="top">
                <input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
                <input type="hidden" name="Qfiller" id="Qfiller" value="<?php echo $_SESSION['ncareID_lwj']; ?>">
                </td>
            </tr>
        </table>
    </fieldset>
</div>
<h3>Medication record</h3>


<?php
$url = $_SERVER['PHP_SELF'];
$url = explode(".",$url);
$url = explode("/",$url[0]);
$file = $url[2];
?>
<div align="right" <?php if ($file=="print") echo ' style="display:none;"'; ?>>


<script>
function datefunction(functioname) {
    var date1 = (document.getElementById('printdate1').value).replace("/",""); date1 = date1.replace("/","");
    var date2 = (document.getElementById('printdate2').value).replace("/",""); date2 = date2.replace("/","");
    //window.location.href='print.php?mod=nurseform&func=formview&pid=<?php //echo @$_GET['pid']; ?>&id=5&date1='+date1+'&date2='+date2;
    if (functioname=='print') {
        window.open('print.php?mod=nurseform&func=formview&pid=<?php echo @$_GET['pid']; ?>&id=17&date1='+date1+'&date2='+date2);
    } else if (functioname=='view') {
        window.location.href='index.php?mod=nurseform&func=formview&pid=<?php echo @$_GET['pid']; ?>&id=17&date1='+date1+'&date2='+date2;
    }
}
</script>
<table <?php  if (strpos($_SERVER['PHP_SELF'],'print.php')!==false) { echo 'style="display:none;"'; }else{ echo 'style="width:100%;"'; } ?>>
  <tr>
    <!--
    <?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?>
    <td bgcolor="#FFFFFF"><form><input type="button" id="newUSErecord" value="New medication record" style="font-size:10pt;" /></form></td>
    <?php }?>
	-->
	<td bgcolor="#FFFFFF" align="right">
    <form>
    Select date:<script> $(function() { $( "#printdate1").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="printdate1" id="printdate1" value="<?php if (@$_GET['date1']==NULL) { echo date(Y."/".m."/01"); } else { echo formatdate(@$_GET['date1']); } ?>" size="12"> ~ <script> $(function() { $( "#printdate2").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="printdate2" id="printdate2" value="<?php if (@$_GET['date2']==NULL) { echo date(Y."/".m."/".d); } else { echo formatdate(@$_GET['date2']); } ?>" size="12"><input type="button" value="Search" onclick="datefunction('view');" /><!--<input type="button" value="Print" onclick="datefunction('print');" />--></form></td>
  </tr>
</table>
</div>
<table width="100%" id="newrecordtable">
  <thead>
  <tr class="title">
    <td>Date</td>
    <td>Time</td>
    <td>Medication name</td>
	<td>Effect</td>
	<td>Pathway</td>
    <td>Dosage</td>
	<td>Amount</td>
    <td>Staff</td>
	<?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?>
    <td class="printcol">Delete</td>
	<?php }?>
  </tr>
  </thead>
  <tbody>
  <?php
      if (@$_GET['date1']==NULL || @$_GET['date2']==NULL) {
          $db3 = new DB;
          $db3->query("SELECT * FROM `nurseform17a` WHERE `HospNo`='".$HospNo."' AND `QMedicationRecordType`='1' ORDER BY `QUseDate` ASC, `Qmedtime1` ASC");
      } else {
          $db3 = new DB;
          $db3->query("SELECT * FROM `nurseform17a` WHERE `HospNo`='".$HospNo."' AND `QMedicationRecordType`='1' AND `QUseDate`>='".mysql_escape_string($_GET['date1'])."' AND `QUseDate`<='".mysql_escape_string($_GET['date2'])."' ORDER BY `QUseDate` ASC, `Qmedtime1` ASC");
      }
  for ($i=0;$i<$db3->num_rows();$i++) {
    $r3 = $db3->fetch_assoc();
    echo '
  <tr>
    <td><center>'.formatdate($r3['QUseDate']).'</center></td>
    <td><center>'.substr($r3['Qmedtime1'],0,2).':'.substr($r3['Qmedtime1'],2,2).'</center></td>
    <td><center>'.$r3['Qmedicine1'].'</center></td>
	<td><center>'.$r3['Qeffect1']." ".option_result("QeffectOption1","Antipsychotic;Antianxiety;Antidepressant;Hypnotic;Anticoagulant;Antibiotic;Diuretic","l","multi",$r3['QeffectOption1'],true,5).'</center></td>
	<td><center>'.$r3['Qway1'].'</center></td>
    <td><center>'.$r3['Qdose1'];
    if ($r3['Qdose1']!="") { echo "Unit"; }
    echo '</center></td>
	<td><center>'.$r3['Qusage1'].'</center></td>
    <td><center>';
    $db_filler = new DB2;
    $db_filler->query("SELECT `name` FROM `userinfo` WHERE `userID`='".$r3['Qfiller']."' AND `orgID`='".$_SESSION['nOrgID_lwj']."'");
    $r_filler = $db_filler->fetch_assoc();
    echo $r_filler['name'];
    echo '</center></td>';
	if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){
    echo '
	<td class="printcol"><center>';
    if ($r3['Qfiller']==$_SESSION['ncareID_lwj']) {
        echo '<form><input type="button" id="delete_'.$HospNo.'_'.$r3['QUseDate'].'_'.$r3['Qmedtime1'].'" onclick="confirmdelete(this.id);" value="Delete"></form>';
    } else { echo '&nbsp;'; }
    echo '</center></td>';
	}
	echo '
  </tr>
  '."\n";
    if (($db3->num_rows()-$i)<4) {
        $spantext .= '
          <tr>
            <td>'.formatdate($r3['QUseDate']).'</td>
            <td>'.substr($r3['Qmedtime1'],0,2).':'.substr($r3['Qmedtime1'],2,2).'</td>
            <td>'.$r3['Qmedicine1'].'</td>
			<td>'.$r3['Qeffect1']." ".option_result("QeffectOption1","Antipsychotic;Antianxiety;Antidepressant;Hypnotic;Anticoagulant;Antibiotic;Diuretic","l","multi",$QeffectOption1,true,5).'</td>
			<td>'.$r3['Qway1'].'</td>
            <td>'.$r3['Qdose1']; if ($r3['Qdose1']!="") { $spantext .= "Unit"; }
            $spantext .= '</td>
            <td>'.$r3['Qusage1'].'</td>
          </tr>'."\n";
          
          //$spantext = $addtext.$spantext;
    }                   
        if ($r3) {
            foreach ($r3 as $k=>$v) {
              if (substr($k,0,1)=="Q") {
                $arrAnswer = explode("_",$k);
                if (count($arrAnswer)==2) {
                  if ($v==1) {
                    ${$arrAnswer[0]} = "";
                  }
                } else {
                  ${$k} = "";
                }
              }  else {
                ${$k} = "";
              }
            }
        }
  }
  ?>
  </tbody>
</table>
<div id="spantext" style="display:none;">
<table style="font-size:10pt; width:100%">
  <thead><tr>
    <td>Date</td>
    <td>Time</td>
    <td>Medication name</td>
	<td>Effect</td>
	<td>Pathway</td>
    <td>Dosage</td>
	<td>Amount</td>
  </tr></thead>
  <?php echo $spantext; ?>
</table>
</div>
<script>
function filloldrecord() {
  document.getElementById('oldrecord').innerHTML = document.getElementById('spantext').innerHTML;
}
function confirmdelete(id) {
    if (confirm('確認刪除？')) {
        var postinfo = id.split(/_/);
        $.ajax({
            url: "class/nurseform17_delete.php",
            type: "POST",
            data: {"HospNo": postinfo[1], "QUseDate": postinfo[2], "Qmedtime1": postinfo[3] },
            success: function(data) {
                confirm("已經成功刪除");
                document.location.reload(true);
            }
        });
    } else {
        alert('已取消刪除');
    }
}
<?php
$url = explode('/', $_SERVER['REQUEST_URI']);
$file = substr($url[3],0,5);
if ($file=="index") {
?>
$('#newrecordtable').dataTable({
    "order": [[0,"desc"],[1,"desc"]],
    "paging": false
});
<?php
}
?>
</script>
<style>
@media print {
    .fg-toolbar {
        display:none;
    }
}
</style>
    </div>