<?php
if (@$_GET['date']=='') {
  $sql = "SELECT * FROM `nurseform18` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1";
} else {
  $sql = "SELECT * FROM `nurseform18` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`='".mysql_escape_string($_GET['date'])."'";
}
$db1 = new DB;
$db1->query($sql);
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
    $QmedtimeSelectNumber = explode(";",$Qmedtime);
	$QmedtimeSelectNumber = count($QmedtimeSelectNumber)-1;
	if($QmedtimeSelectNumber=="0" || $QmedtimeSelectNumber=="-1"){$QmedtimeSelectNumber="";}
    $QmeddaySelectNumber = explode(";",$Qmedday);
	$QmeddaySelectNumber = count($QmeddaySelectNumber)-1;
	if($QmeddaySelectNumber=="0" || $QmeddaySelectNumber=="-1"){$QmeddaySelectNumber="";}
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
<!--本form主內容開始-->
<form  method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save" id="base">
<h3>Insulin prescription records</h3>
    <table width="100%">
      <tr>
        <td class="title" width="100">Medication</td>
        <td colspan="2"><input type="text" name="Qmedicine" id="Qmedicine" value="<?php echo $Qmedicine ?>" size="40" onkeyup="autocompleteMeds()" onclick="autocompleteMeds()"/></td>
		<td>
            <input type="button" onclick="writetomed('Novomix')" value="Novomix" />
            <input type="button" onclick="writetomed('Regular Insulin (RI)')" value="Regular Insulin (RI)" />
            <input type="button" onclick="writetomed('Humulin N')" value="Humulin N" />
            <input type="button" onclick="writetomed('Lantus')" value="Lantus" />
            <input type="button" onclick="writetomed('Forteo')" value="Forteo" /><br />
            <input type="button" onclick="writetomed('Humalog mix Kwikpen')" value="Humalog mix Kwikpen" />
            <input type="button" onclick="writetomed('Apidra')" value="Apidra" />
            <input type="button" onclick="writetomed('Novorapid')" value="Novorapid" />
            <input type="button" onclick="writetomed('Insulatard')" value="Insulatard" />
            <input type="button" onclick="writetomed('Levemir')" value="Levemir" />
            <input type="button" onclick="writetomed('Hold')" value="Hold" />
            <script>
                function writetomed(name) {
                    if (document.getElementById('Qmedicine').value!='') {
                        if (confirm('是否取代原有內容？\n按「確定」為「取代」，按「取消」為「加在原內容後方」')) {
                            document.getElementById('Qmedicine').value = name;
                        } else {
                            document.getElementById('Qmedicine').value = document.getElementById('Qmedicine').value + ' ' + name;
                        }
                    } else {
                        document.getElementById('Qmedicine').value = name;
                    }
                }
            </script>
		</td>
      </tr>

  <script>
  function selectmedtime1(freq) {
    for (i=1;i<=24;i++) {
      if (i==1 || i==13) { var classname = "tabbtn_s_left_off"; } else
      if (i==12 || i==24) { var classname = "tabbtn_s_right_off"; } else
      { var classname = "tabbtn_s_middle_off"; }
     
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
         
        }
      }
    });
  }
  </script>
   
   <!--暫時不用頻率
      <tr>
        <td class="title">Frequency</td>
        <td><select onchange="selectmedtime1(this.value);" id="freqselect">
          <option></option>
      <?php/*
      $db1 = new DB;
      $db1->query("SELECT * FROM `medfreq` ORDER BY `avaliable`, `code`");
      for ($i = 0; $i < $db1->num_rows(); $i++) {
        $r1 = $db1->fetch_assoc();
        echo '<option value="'.$r1['freqID'].'"';
          if($r1['freqID'] == $freqselect) {echo " selected";}
         echo ' > '.$r1['code'].$r1['freqID'].' ('.$r1['name'].')'.'</option>'."\n";
      }*/
      ?>
        </select></td>
        <td colspan="2"><input type="text" size="10" name="Qfreq" id="Qfreq" /><span id="Qfreqtext"></span></td>
      </tr>
  -->
      <tr>
          <td class="title">Dose</td>
     <td colspan="3"><input type="text" name="Qdose" id="Qdose" value="<?php echo $Qdose; ?>" size="10"/> Unit
       <!--
	   <select name="Qdoseq" id="Qdoseq">
         <option></option>
         <option value="cc">c.c. (毫升)</option>
         <option value="gm">gm. (公克)</option>
         <option value="gtt">gtt (Drop)</option>
         <option value="IU">I.U.</option>
         <option value="kg">Kg. (Kilogram)</option>
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
	   -->
	   </td>
      </tr>
      
      <tr>
        <td class="title">Medication time<input type="text" name="SelectQmedtime" id="SelectQmedtime" class="validate[required]" style="width:0px; height:0px; border:0px;" value="<?php echo $QmedtimeSelectNumber;?>"></td>
        <td colspan="3"><?php echo draw_option("Qmedtime","0;1;2;3;4;5;6;7;8;9;10;11;12;13;14;15;16;17;18;19;20;21;22;23","s","multi",$Qmedtime,true,12); ?></td>
      </tr>
      <tr>
        <td class="title">Medication day<input type="text" name="SelectQmedday" id="SelectQmedday" class="validate[required]" style="width:0px; height:0px; border:0px;" value="<?php echo $QmeddaySelectNumber;?>"></td>
        <td colspan="3"><?php echo draw_option("Qmedday","Mon;Tue;Wed;Thu;Fri;Sat;Sun;Every day;Every 2 day","m","multi",$Qmedday,false,7); ?></td>
      </tr>
      <tr>
        <td class="title">Start date</td>
        <td><script> $(function() { $( "#Qstartdate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script>
          <input type="text" name="Qstartdate" id="Qstartdate" value="<?php if ($Qstartdate != NULL) { echo $Qstartdate; } else { echo date('Y/m/d'); } ?>" size="12" class="validate[required, custom[date]]"/></td>
        <td class="title">End date</td>
        <td><script> $(function() { $( "#Qenddate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script>
          <input type="text" name="Qenddate" id="Qenddate" value="<?php if ($Qenddate != NULL) { echo $Qenddate; } ?>" size="12" class="validate[required, custom[date]]"/></td>
      </tr>
      <tr>
        <td class="title">Doctor</td>
        <td colspan="3"><input type="text" name="Qdoctor" id="Qdoctor" size="30" value="<?php echo $Qdoctor; ?>" /></td>
      </tr>
    </table>
<!--最下面的連寫日期欄位-->
<table width="100%">
  <tr>
    <td>Filled date：<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if($_GET['newDate']!="") { echo formatdate($_GET['newDate']); } else { if ($date != NULL) { echo formatdate($date); } } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" /></td>
    <td align="right">Filled by:<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>
<center><input type="hidden" name="formID" id="formID" value="nurseform18" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></center>
</form>
<br>
<?php
if ($r1) {
foreach ($r1 as $k=>$v) {
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
?>
<script>
$(function() {
	$('#base').validationEngine();
});
</script>