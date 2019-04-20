<?php
// '@'  ->> Do not show the error.
if (@$_GET['date']=='') {
    $sql = "SELECT * FROM `nurseform57` WHERE `HospNo`='".mysql_escape_string($r['HospNo'])."' ORDER BY `date` DESC LIMIT 0,1";
} else {
    $sql = "SELECT * FROM `nurseform57` WHERE `HospNo`='".mysql_escape_string($r['HospNo'])."' AND `date`='".mysql_escape_string(@$_GET['date'])."'";
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
<h3 align="center">Bed Hold Policy</h3>
<div class="nurseform-table">
<form action="index.php?func=database&action=save" method="post" accept-charset="utf-8">
<table align="center">
    <tr>
        <td class="title">Dear</td>
        <td colspan="2"><?php echo $name; ?></td>
        <td class="title">Date</td>
        <td><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" id="date" name="date" style="width:100px" value="<?php echo formatdate($date); ?>"></td>
    </tr>
    <tr>
        <td colspan="5" align="left" style="padding: 20px;">
        Under OBRA (Omnibus Budget Reconciliation Act of 1987). We require to provide each nursing home resident, the responsible party or legal representative with a copy of our "Bed Hold Policy" at the time of transfer to a hospital.<br><br>
        <p align="center"><strong>BED HOLD POLICY</strong></p>
        Effective September 1, 2014-Medicaid will hold a bed for a participant in the Medicaid program for only a set period of the time. When the resident's hospitalization or absence exceeds the 20-day period allowed under the Massachusetts Medicaid plan, the facility will discharge the resident from the facility unless arrangements have been made to pay to hold the bed.<br><br><br>
        If the absence from the facility exceeds 20 days and the bed is not being held, the facility agrees to readmit the discharged resident when the next appropriate bed becomes available. This readmission is contingent upon the resident continuing to require the care this facility provides and continues to be Medicaid eligible for Medicaid nursing facility services.<br><br>
        For residents not covered by the Medicaid program, arrangements must be made to pay the daily private rate if the resident wishes to hold the bed. If no such arrangments are made, the resident must be discharged upon leaving the facility.
        </td>
    </tr>      
    <tr>
        <td colspan="5" class="title">For Medicaid program only:</td>
    </tr>
    <tr>
    <td colspan="5" style="padding: 20px;" align="left">Resident <strong><?php echo $name; ?></strong> was transferred on <script> $(function() { $( "#QD1").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" id="QD1" name="QD1" style="width:100px"  value="<?php echo formatdate($QD1); ?>">.<br>
        The 20-day hold bed period will end on <script> $(function() { $( "#QD2").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" id="QD2" name="QD2" style="width:100px"  value="<?php echo formatdate($QD2); ?>">.<br><br>
        To hold the bed after that date, arrangments must be made to pay the daily private rate. If you have any question, please contact our social worker.
        </td>
    </tr>
</table>    
<!-- submit button + VN -->
        <center><input type="hidden" name="formID" id="formID" value="nurseform57" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" />
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