<?php
// '@'  ->> Do not show the error.
if (@$_GET['date']=='') {
    $sql = "SELECT * FROM `nurseform56` WHERE `HospNo`='".mysql_escape_string($r['HospNo'])."' ORDER BY `date` DESC LIMIT 0,1";
} else {
    $sql = "SELECT * FROM `nurseform56` WHERE `HospNo`='".mysql_escape_string($r['HospNo'])."' AND `date`='".mysql_escape_string(@$_GET['date'])."'";
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
<h3 align="center">Nursing Care Guideline for Nurses Aides</h3>
<div class="nurseform-table">
    
<form action="index.php?func=database&action=save" method="post" accept-charset="utf-8">
<table width="100%" align="center">
<tr>
    <td class="title">Major Diseases</td>
    <td align="left"><?php 
        echo 
        draw_checkbox_nobr("Q1", "Denmentia;Renal Disease;CVA;HTN or Cardiac Disease", $Q1, "multi")."<br>";   
        echo 
        draw_checkbox_nobr("Q2", "Cancer;Lung Disease;Diabetes;Other:<input type=\"text\" id=\"QA1\" name=\"QA1\" value=\"$QA1\">", $Q2, "multi");
        ?>
    </td>
</tr>
<tr>
    <td class="title">Bathing</td>
    <td align="left"><?php echo draw_checkbox_nobr("Q3", "Shower;Full body;Lower body;Whirlpool bath", $Q3, "multi")."<br>";   
        ?>
    </td>
</tr>
<tr>
    <td class="title">Toileting</td>
    <td align="left"><?php echo draw_checkbox_nobr("Q4", "Self toileting;Scheduled toileting;Incontinent w/ care;Foley catheter", $Q4, "multi")."<br>";   
        ?>
    </td>
</tr>
<tr>
    <td class="title">Oral Care</td>
    <td align="left"><?php echo draw_checkbox_nobr("Q5", "Routine;Special;Frequency:<input type=\"text\" id=\"QA2\" name=\"QA2\" value=\"$QA2\">", $Q5, "multi");
        ?>   
    </td>
</tr>
<tr>
    <td class="title">Ambulation</td>
    <td align="left"><?php 
        echo 
        draw_checkbox_nobr("Q6", "No Ambulation;Independent;Cont. supervision;1 assist", $Q6, "multi")."<br>";   
        echo 
        draw_checkbox_nobr("Q7", "2 assists;Distance:<input type=\"text\" id=\"QA3\" name=\"QA3\" value=\"$QA3\">;Frequency:<input type=\"text\" id=\"QA4\" name=\"QA4\" value=\"$QA4\">", $Q7, "multi");
        ?>
    </td>
</tr>
<tr>
    <td class="title">Transfer</td>
    <td align="left"><?php echo draw_checkbox_nobr("Q8", "Independent;Cont. supervision;1 assist;2 assists;Hoyer lift", $Q8, "multi")."<br>";   
        ?>
    </td>
</tr>
<tr>
    <td class="title">Devices</td>
    <td align="left"><?php 
        echo draw_checkbox_nobr("Q9", "Glasses;Denture(s);Hearing aid(s);Recliner;Cane;Wheelchair", $Q9, "multi")."<br>";
        echo draw_checkbox_nobr("Q10", "Regular chair;Splint(s);Walker;Gerichair;Rocking chair", $Q10, "multi")."<br>";   
        ?>
    </td>
</tr>
<tr>
    <td class="title">Restraint</td>
    <td align="left"><?php echo draw_checkbox_nobr("Q11", "Yes;Type:<input type=\"text\" id=\"QA5\" name=\"QA5\" value=\"$QA5\">;No", $Q11, "multi");
        ?>   
    </td>
</tr>
<tr>
    <td class="title">Meal/Feeding</td>
    <td align="left"><?php 
        echo draw_checkbox_nobr("Q12", "Breakfast;MDR;FDR", $Q12, "multi")."<br>";
        echo draw_checkbox_nobr("Q13", "Lunch;MDR;FDR", $Q13, "multi")."<br>"; 
        echo draw_checkbox_nobr("Q14", "Dinner;MDR;FDR", $Q14, "multi")."<br>"; 
        echo draw_checkbox_nobr("Q15", "Independent;Set up;Cont. supervision;Assist;Total feeding", $Q15, "multi")."<br>";   
        ?>
    </td>
</tr>
<tr>
    <td class="title">Tube Feeding</td>
    <td align="left"><?php echo draw_checkbox_nobr("Q16", "Total TF;Partial TF;No", $Q16, "multi")."<br>";   
        ?>
    </td>
</tr>
<tr>
    <td class="title">Sleeping Pattern</td>
    <td align="left"><?php echo draw_checkbox_nobr("Q17", "Morning nap;Afternoon nap;As needed", $Q17, "multi")."<br>";   
        ?>
    </td>
</tr>
<tr>
    <td class="title">DM Foot Care</td>
    <td align="left"><?php echo draw_checkbox_nobr("Q18", "Yes;No", $Q18, "multi")."<br>";   
        ?>
    </td>
</tr>
<tr>
    <td class="title">Record I/O QS</td>
    <td align="left"><?php echo draw_checkbox_nobr("Q19", "Yes;No", $Q19, "multi")."<br>";   
        ?>
    </td>
</tr>
<tr>
    <td class="title">Behavior Monitor</td>
    <td align="left"><?php echo draw_checkbox_nobr("Q20", "Yes;No", $Q20, "multi")."<br>";   
        ?>
    </td>
</tr>
<tr>
    <td class="title">Frequent Check</td>
    <td align="left"><?php echo draw_checkbox_nobr("Q21", "1/2 hour;15 minutes;No", $Q21, "multi")."<br>";   
        ?>
    </td>
</tr>
<tr>
    <td class="title">Skin Care</td>
    <td align="left"><?php echo draw_checkbox_nobr("Q22", "Yes;No", $Q22, "multi")."<br>";   
        ?>
    </td>
</tr>
<tr>
    <td class="title">Side Care</td>
    <td align="left"><?php echo draw_checkbox_nobr("Q23", "One side up;Both side up;No", $Q23, "multi")."<br>";   
        ?>
    </td>
</tr>
<tr>
    <td rowspan="2" class="title">Special Care</td>
    <td rowspan="2"><input type="text" style="width:95%;height:90%" id="Q24" name="Q24" value="<?php echo $Q24; ?>"></td>
</tr>
<tr></tr>
</table>
<!-- Real Date and Form Filler -->
<table width="100%" align="center">
  <tr>
    <td><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Filled date："; }else{ echo $word_40; } ?><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if($_GET['newDate']!="") { echo formatdate($_GET['newDate']); } else { if ($date != NULL) { echo formatdate($date); } } ?>" size="12"> <input type="button" value="<?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Today"; }else{ echo $word_today; } ?>" onclick="inputdate('date');" /></td>
    <td align="right"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Filled by："; }else{ echo $word_41; } ?><?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>
<!-- submit button + VN -->
        <center><input type="hidden" name="formID" id="formID" value="nurseform56" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" />
        <button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
        </center>
<br><br><br><br><br><br>
</form>
</div>
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