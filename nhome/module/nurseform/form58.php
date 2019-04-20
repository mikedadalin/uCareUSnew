<?php
// '@'  ->> Do not show the error.
if (@$_GET['date']=='') {
    $sql = "SELECT * FROM `nurseform58` WHERE `HospNo`='".mysql_escape_string($r['HospNo'])."' ORDER BY `date` DESC LIMIT 0,1";
} else {
    $sql = "SELECT * FROM `nurseform58` WHERE `HospNo`='".mysql_escape_string($r['HospNo'])."' AND `date`='".mysql_escape_string(@$_GET['date'])."'";
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
?>
<h3>Multi-Disciplinary Patient/Family Teaching Record</h3>
<div class="nurseform-table">
<form action="index.php?func=database&action=save" method="post" accept-charset="utf-8">
<table align="center">                
    <tr>
        <td class="title" colspan="5" width="35%">TEACHING TOPICS</td>
        <td class="title" width="150px" colspan="1">READY TO LEARN (RTL)</td>
        <td class="title" colspan="2">TAUGHT TO</td>
        <td class="title" colspan="5" width="20%">FOLLOW UP PLAN</td>
    </tr>
    <tr>
        <td colspan="5" rowspan="3" align="left">
            <ol>
                <li>Disease/Condition</li>
                <li>Diagonstic testing/treatments</li>
                <li>Risk factor/Lifestyle Management</li>
                <li>Medication(safety, dose, schedule, drug/drug Interactions)</li>
                <li>Nutrition(food/drug, interactions, restrictions)</li>
                <li>Medical equipment(instruction)</li>
                <li>Activity/Adaptive techniques</li>
                <li>Follow-up Care(appointments, when to call MD, etc)</li>
                <li>Community Resources</li>
                <li>Other:<input type="text" id="Q1" name="Q1" value="<?php echo $Q1; ?>"</li>
            </ol>
        </td>
        <td><strong>Y</strong> = Yes<br><strong>N</strong> = No</td>
        <td colspan="2"><strong>P</strong> = Patient<br><strong>F</strong> = Family<br><strong>O</strong> = Other<br>(specity)</td>
        <td rowspan="3" align="left" colspan="5"><strong>NP</strong> = Needs practice<br><strong>RT</strong> = Reteach<br><strong>RC</strong> = Reinforce content<br><strong>NI</strong> = No further teaching required<br><strong>O</strong> = Other</td>
    </tr>
    <tr>
        <td class="title" align="left">Teaching Aids:</td>
        <td colspan="2" class="title" align="left">Response:</td>
    </tr>
    <tr>
        <td align="left"><strong>AV</strong> = Vledeo<br><strong>B</strong> = Booklet<br><strong>D</strong> = Demonstration<br><strong>O</strong> = Other</td>
        <td colspan="2" align="left"><strong>V</strong> = Verbalized understanding<br><strong>VP</strong> = Verbalized partial<br><strong>RD</strong> = Returned demonstration with assistance<br><strong>RI</strong> = Returned demonstration Independently<br><strong>U</strong> = Unreceptive to teaching</td>
    </tr>

    <tr>
        <td class="title" width="1px">Date</td>
        <td class="title">Time</td>
        <td class="title">Initial</td>
        <td class="title">RTL</td>
        <td class="title">Topic</td>
        <td class="title" colspan="2" width="350px">Description</td>
        <td class="title" width="50px">Aids</td>
        <td class="title">Taught to</td>
        <td class="title">Response</td>
        <td class="title">Follow up plans</td>
    </tr>
    <tr>
        <td align="center" style="width:200px"><script> $(function() { $( "#QD1").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input style="width:70%" type="text" id="QD1" name="QD1" value="<?php echo formatdate($QD1); ?>"></td>
        <td><input type="time" id="Q1" name="Q1" style="width:90%"value="<?php echo $Q1; ?>"></td>
        <td><input type="text" id="Q2" name="Q2" style="width:55%" value="<?php echo $Q2; ?>"></td>
        <td><input type="text" id="Q3" name="Q3" style="width:55%" value="<?php echo $Q3; ?>"></td>
        <td><input type="text" id="Q4" name="Q4" style="width:55%" value="<?php echo $Q4; ?>"></td>
        <td colspan="2"><input type="text" id="Q5" name="Q5" style="width:90%" value="<?php echo $Q5; ?>"></td>
        <td><input type="text" id="Q6" name="Q6" style="width:55%" value="<?php echo $Q6; ?>"></td>
        <td><input type="text" id="Q7" name="Q7" style="width:55%" value="<?php echo $Q7; ?>"></td>
        <td><input type="text" id="Q9" name="Q9" style="width:55%" value="<?php echo $Q9; ?>"></td>
        <td><input type="text" id="Q10" name="Q10" style="width:55%" value="<?php echo $Q10; ?>"></td>
    </tr>
    <tr>
        <td align="center" style="width:200px"><script> $(function() { $( "#QD2").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input style="width:70%" type="text" id="QD2" name="QD2" value="<?php echo formatdate($QD2); ?>"></td>
        <td><input type="time" id="Q11" name="Q11" style="width:90%"value="<?php echo $Q11; ?>"></td>
        <td><input type="text" id="Q12" name="Q12" style="width:55%" value="<?php echo $Q12; ?>"></td>
        <td><input type="text" id="Q13" name="Q13" style="width:55%" value="<?php echo $Q13; ?>"></td>
        <td><input type="text" id="Q14" name="Q14" style="width:55%" value="<?php echo $Q14; ?>"></td>
        <td colspan="2"><input type="text" id="Q15" name="Q15" style="width:90%" value="<?php echo $Q15; ?>"></td>
        <td><input type="text" id="Q16" name="Q16" style="width:55%" value="<?php echo $Q16; ?>"></td>
        <td><input type="text" id="Q17" name="Q17" style="width:55%" value="<?php echo $Q17; ?>"></td>
        <td><input type="text" id="Q19" name="Q19" style="width:55%" value="<?php echo $Q19; ?>"></td>
        <td><input type="text" id="Q20" name="Q20" style="width:55%" value="<?php echo $Q20; ?>"></td>
    </tr>
    <tr>
        <td align="center" style="width:200px"><script> $(function() { $( "#QD3").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input style="width:70%" type="text" id="QD3" name="QD3" value="<?php echo formatdate($QD3); ?>"></td>
        <td><input type="time" id="Q21" name="Q21" style="width:90%"value="<?php echo $Q21; ?>"></td>
        <td><input type="text" id="Q22" name="Q22" style="width:55%" value="<?php echo $Q22; ?>"></td>
        <td><input type="text" id="Q23" name="Q23" style="width:55%" value="<?php echo $Q23; ?>"></td>
        <td><input type="text" id="Q24" name="Q24" style="width:55%" value="<?php echo $Q24; ?>"></td>
        <td colspan="2"><input type="text" id="Q25" name="Q25" style="width:90%" value="<?php echo $Q25; ?>"></td>
        <td><input type="text" id="Q26" name="Q26" style="width:55%" value="<?php echo $Q26; ?>"></td>
        <td><input type="text" id="Q27" name="Q27" style="width:55%" value="<?php echo $Q27; ?>"></td>
        <td><input type="text" id="Q29" name="Q29" style="width:55%" value="<?php echo $Q29; ?>"></td>
        <td><input type="text" id="Q30" name="Q30" style="width:55%" value="<?php echo $Q30; ?>"></td>
    </tr>
    <tr>
        <td align="center" style="width:200px"><script> $(function() { $( "#QD4").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input style="width:70%" type="text" id="QD4" name="QD4" value="<?php echo formatdate($QD4); ?>"></td>
        <td><input type="time" id="Q31" name="Q31" style="width:90%"value="<?php echo $Q31; ?>"></td>
        <td><input type="text" id="Q32" name="Q32" style="width:55%" value="<?php echo $Q32; ?>"></td>
        <td><input type="text" id="Q33" name="Q33" style="width:55%" value="<?php echo $Q33; ?>"></td>
        <td><input type="text" id="Q34" name="Q34" style="width:55%" value="<?php echo $Q34; ?>"></td>
        <td colspan="2"><input type="text" id="Q35" name="Q35" style="width:90%" value="<?php echo $Q35; ?>"></td>
        <td><input type="text" id="Q36" name="Q36" style="width:55%" value="<?php echo $Q36; ?>"></td>
        <td><input type="text" id="Q37" name="Q37" style="width:55%" value="<?php echo $Q37; ?>"></td>
        <td><input type="text" id="Q39" name="Q39" style="width:55%" value="<?php echo $Q39; ?>"></td>
        <td><input type="text" id="Q40" name="Q40" style="width:55%" value="<?php echo $Q40; ?>"></td>
    </tr>
    <tr>
        <td align="center" style="width:200px"><script> $(function() { $( "#QD5").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input style="width:70%" type="text" id="QD5" name="QD5" value="<?php echo formatdate($QD5); ?>"></td>
        <td><input type="time" id="Q41" name="Q41" style="width:90%"value="<?php echo $Q41; ?>"></td>
        <td><input type="text" id="Q42" name="Q42" style="width:55%" value="<?php echo $Q42; ?>"></td>
        <td><input type="text" id="Q43" name="Q43" style="width:55%" value="<?php echo $Q43; ?>"></td>
        <td><input type="text" id="Q44" name="Q44" style="width:55%" value="<?php echo $Q44; ?>"></td>
        <td colspan="2"><input type="text" id="Q45" name="Q45" style="width:90%" value="<?php echo $Q45; ?>"></td>
        <td><input type="text" id="Q46" name="Q46" style="width:55%" value="<?php echo $Q46; ?>"></td>
        <td><input type="text" id="Q47" name="Q47" style="width:55%" value="<?php echo $Q47; ?>"></td>
        <td><input type="text" id="Q49" name="Q49" style="width:55%" value="<?php echo $Q49; ?>"></td>
        <td><input type="text" id="Q50" name="Q50" style="width:55%" value="<?php echo $Q50; ?>"></td>
    </tr>
    <tr>
        <td align="center" style="width:200px"><script> $(function() { $( "#QD6").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input style="width:70%" type="text" id="QD6" name="QD6" value="<?php echo formatdate($QD6); ?>"></td>
        <td><input type="time" id="Q51" name="Q51" style="width:90%"value="<?php echo $Q51; ?>"></td>
        <td><input type="text" id="Q52" name="Q52" style="width:55%" value="<?php echo $Q52; ?>"></td>
        <td><input type="text" id="Q53" name="Q53" style="width:55%" value="<?php echo $Q53; ?>"></td>
        <td><input type="text" id="Q54" name="Q54" style="width:55%" value="<?php echo $Q54; ?>"></td>
        <td colspan="2"><input type="text" id="Q55" name="Q55" style="width:90%" value="<?php echo $Q55; ?>"></td>
        <td><input type="text" id="Q56" name="Q56" style="width:55%" value="<?php echo $Q56; ?>"></td>
        <td><input type="text" id="Q57" name="Q57" style="width:55%" value="<?php echo $Q57; ?>"></td>
        <td><input type="text" id="Q59" name="Q59" style="width:55%" value="<?php echo $Q59; ?>"></td>
        <td><input type="text" id="Q60" name="Q60" style="width:55%" value="<?php echo $Q60; ?>"></td>
    </tr>
    <tr>
        <td align="center" style="width:200px"><script> $(function() { $( "#QD7").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input style="width:70%" type="text" id="QD7" name="QD7" value="<?php echo formatdate($QD7); ?>"></td>
        <td><input type="time" id="Q61" name="Q61" style="width:90%"value="<?php echo $Q61; ?>"></td>
        <td><input type="text" id="Q62" name="Q62" style="width:55%" value="<?php echo $Q62; ?>"></td>
        <td><input type="text" id="Q63" name="Q63" style="width:55%" value="<?php echo $Q63; ?>"></td>
        <td><input type="text" id="Q64" name="Q64" style="width:55%" value="<?php echo $Q64; ?>"></td>
        <td colspan="2"><input type="text" id="Q65" name="Q65" style="width:90%" value="<?php echo $Q65; ?>"></td>
        <td><input type="text" id="Q66" name="Q66" style="width:55%" value="<?php echo $Q66; ?>"></td>
        <td><input type="text" id="Q67" name="Q67" style="width:55%" value="<?php echo $Q67; ?>"></td>
        <td><input type="text" id="Q69" name="Q69" style="width:55%" value="<?php echo $Q69; ?>"></td>
        <td><input type="text" id="Q70" name="Q70" style="width:55%" value="<?php echo $Q70; ?>"></td>
    </tr>
    <tr>
        <td align="center" style="width:200px"><script> $(function() { $( "#QD8").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input style="width:70%" type="text" id="QD8" name="QD8" value="<?php echo formatdate($QD8); ?>"></td>
        <td><input type="time" id="Q71" name="Q71" style="width:90%"value="<?php echo $Q71; ?>"></td>
        <td><input type="text" id="Q72" name="Q72" style="width:55%" value="<?php echo $Q72; ?>"></td>
        <td><input type="text" id="Q73" name="Q73" style="width:55%" value="<?php echo $Q73; ?>"></td>
        <td><input type="text" id="Q74" name="Q74" style="width:55%" value="<?php echo $Q74; ?>"></td>
        <td colspan="2"><input type="text" id="Q75" name="Q75" style="width:90%" value="<?php echo $Q75; ?>"></td>
        <td><input type="text" id="Q76" name="Q76" style="width:55%" value="<?php echo $Q76; ?>"></td>
        <td><input type="text" id="Q77" name="Q77" style="width:55%" value="<?php echo $Q77; ?>"></td>
        <td><input type="text" id="Q79" name="Q79" style="width:55%" value="<?php echo $Q79; ?>"></td>
        <td><input type="text" id="Q80" name="Q80" style="width:55%" value="<?php echo $Q80; ?>"></td>
    </tr>
    <tr>
        <td align="center" style="width:200px"><script> $(function() { $( "#QD9").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input style="width:70%" type="text" id="QD9" name="QD9" value="<?php echo formatdate($QD9); ?>"></td>
        <td><input type="time" id="Q81" name="Q81" style="width:90%"value="<?php echo $Q81; ?>"></td>
        <td><input type="text" id="Q82" name="Q82" style="width:55%" value="<?php echo $Q82; ?>"></td>
        <td><input type="text" id="Q83" name="Q83" style="width:55%" value="<?php echo $Q83; ?>"></td>
        <td><input type="text" id="Q84" name="Q84" style="width:55%" value="<?php echo $Q84; ?>"></td>
        <td colspan="2"><input type="text" id="Q85" name="Q85" style="width:90%" value="<?php echo $Q85; ?>"></td>
        <td><input type="text" id="Q86" name="Q86" style="width:55%" value="<?php echo $Q86; ?>"></td>
        <td><input type="text" id="Q87" name="Q87" style="width:55%" value="<?php echo $Q87; ?>"></td>
        <td><input type="text" id="Q89" name="Q89" style="width:55%" value="<?php echo $Q89; ?>"></td>
        <td><input type="text" id="Q90" name="Q90" style="width:55%" value="<?php echo $Q90; ?>"></td>
    </tr>
    <tr>
        <td align="center" style="width:200px"><script> $(function() { $( "#QD10").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input style="width:70%" type="text" id="QD10" name="QD10" value="<?php echo formatdate($QD10); ?>"></td>
        <td><input type="time" id="Q91" name="Q91" style="width:90%"value="<?php echo $Q91; ?>"></td>
        <td><input type="text" id="Q92" name="Q92" style="width:55%" value="<?php echo $Q92; ?>"></td>
        <td><input type="text" id="Q93" name="Q93" style="width:55%" value="<?php echo $Q93; ?>"></td>
        <td><input type="text" id="Q94" name="Q94" style="width:55%" value="<?php echo $Q94; ?>"></td>
        <td colspan="2"><input type="text" id="Q95" name="Q95" style="width:90%" value="<?php echo $Q95; ?>"></td>
        <td><input type="text" id="Q96" name="Q96" style="width:55%" value="<?php echo $Q96; ?>"></td>
        <td><input type="text" id="Q97" name="Q97" style="width:55%" value="<?php echo $Q97; ?>"></td>
        <td><input type="text" id="Q99" name="Q99" style="width:55%" value="<?php echo $Q99; ?>"></td>
        <td><input type="text" id="Q100" name="Q100" style="width:55%" value="<?php echo $Q100; ?>"></td>
    </tr>
    <tr>
        <td align="center" style="width:200px"><script> $(function() { $( "#QD11").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input style="width:70%" type="text" id="QD11" name="QD11" value="<?php echo formatdate($QD11); ?>"></td>
        <td><input type="time" id="Q111" name="Q111" style="width:90%"value="<?php echo $Q111; ?>"></td>
        <td><input type="text" id="Q112" name="Q112" style="width:55%" value="<?php echo $Q112; ?>"></td>
        <td><input type="text" id="Q113" name="Q113" style="width:55%" value="<?php echo $Q113; ?>"></td>
        <td><input type="text" id="Q114" name="Q114" style="width:55%" value="<?php echo $Q114; ?>"></td>
        <td colspan="2"><input type="text" id="Q115" name="Q115" style="width:90%" value="<?php echo $Q115; ?>"></td>
        <td><input type="text" id="Q116" name="Q116" style="width:55%" value="<?php echo $Q116; ?>"></td>
        <td><input type="text" id="Q117" name="Q117" style="width:55%" value="<?php echo $Q117; ?>"></td>
        <td><input type="text" id="Q119" name="Q119" style="width:55%" value="<?php echo $Q119; ?>"></td>
        <td><input type="text" id="Q120" name="Q120" style="width:55%" value="<?php echo $Q120; ?>"></td>
    </tr>
    <tr>
        <td class="title" style="width:200px">Initial</td>
        <td colspan="4">Signature & License Status</td>
        <td class="title">Initial</td>
        <td colspan="5">Signature & License Status</td>
    </tr>
    <tr>
        <td style="width:200px"><input type="text" id="Q121" name="Q121" value="<?php echo $Q121; ?>"></td>
        <td colspan="4"><input type="text" style="width: 95%" id="Q122" name="Q122" value="<?php echo $Q122; ?>"></td>
        <td><input type="text" id="Q123" name="Q123" value="<?php echo $Q123; ?>"></td>
        <td colspan="5"><input type="text" style="width: 95%" id="Q124" name="Q124" value="<?php echo $Q124; ?>"></td>
    </tr>
    <tr>
        <td style="width:200px"><input type="text" id="Q125" name="Q125" value="<?php echo $Q125; ?>"></td>
        <td colspan="4"><input type="text" style="width: 95%" id="Q126" name="Q126" value="<?php echo $Q126; ?>"></td>
        <td><input type="text" id="Q127" name="Q127" value="<?php echo $Q127; ?>"></td>
        <td colspan="5"><input type="text" style="width: 95%" id="Q128" name="Q128" value="<?php echo $Q128; ?>"></td>
    </tr>
    <tr>
        <td style="width:200px"><input type="text" id="Q129" name="Q129" value="<?php echo $Q129; ?>"></td>
        <td colspan="4"><input type="text" style="width: 95%" id="Q130" name="Q130" value="<?php echo $Q130; ?>"></td>
        <td><input type="text" id="Q131" name="Q131" value="<?php echo $Q131; ?>"></td>
        <td colspan="5"><input type="text" style="width: 95%" id="Q132" name="Q132" value="<?php echo $Q132; ?>"></td>
    </tr>
    <tr>
        <td style="width:200px"><input type="text" id="Q133" name="Q133" value="<?php echo $Q133; ?>"></td>
        <td colspan="4"><input type="text" id="Q134" name="Q134" style="width: 95%" value="<?php echo $Q134; ?>"></td>
        <td><input type="text" id="Q135" name="Q135" value="<?php echo $Q135; ?>"></td>
        <td colspan="5"><input type="text" style="width: 95%" id="Q136" name="Q136" value="<?php echo $Q136; ?>"></td>
    </tr>
    <tr>
    <td colspan="6"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Filled date："; }else{ echo $word_40; } ?><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if($_GET['newDate']!="") { echo formatdate($_GET['newDate']); } else { if ($date != NULL) { echo formatdate($date); } } ?>" size="12"> <input type="button" value="<?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Today"; }else{ echo $word_today; } ?>" onclick="inputdate('date');" /></td>
    <td colspan="5" align="right"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Filled by："; }else{ echo $word_41; } ?><?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>
<!-- Real Date and Form Filler -->
<!-- submit button + VN -->
        <center><input type="hidden" name="formID" id="formID" value="nurseform58" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" />
        <button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
        </center>
</form>
</div>
        <br><br><br><br><br><br>
<!-- clean the varaiable -->
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