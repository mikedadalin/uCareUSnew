<?php
// '@'  ->> Do not show the error.
if (@$_GET['date']=='') {
    $sql = "SELECT * FROM `nurseform55` WHERE `HospNo`='".mysql_escape_string($r['HospNo'])."' ORDER BY `date` DESC LIMIT 0,1";
} else {
    $sql = "SELECT * FROM `nurseform55` WHERE `HospNo`='".mysql_escape_string($r['HospNo'])."' AND `date`='".mysql_escape_string(@$_GET['date'])."'";
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
<h3 align="center">Disposition of Patient's Property</h3>
<div class="nurseform-table">
    
<form action="index.php?func=database&action=save" method="post" accept-charset="utf-8">
<table width="100%" align="center">
        <tr>
            <td class="title">Date</td>
            <!-- <td><input type="date" id="date" name="date" style="width:99%;"></td>  -->
            <td><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php echo formatdate($date); ?>" size="12" ></td>
            <td class="title">Time</td>
            <td><input type="time" id="Qtime" name="Qtime" style="width:99%;" value="<?php echo $Qtime;?>"></td>
        </tr>
        <tr>
            <td class="title">Resident</td>
            <td colspan="3"><?php echo $name; ?></td>
        </tr>
        <tr>
            <td colspan="4" style="text-align: left">
            <ol style="padding-left:30px">

            	<li> I hereby acknowledge that I have been informed that the Nursing Home provides limited facilities for the safe keeping of money, jewelry, perosnal effects and other items belonging to residents at the Nursing Home.<br><br></li>

            	<li>I place the following belongings in the custody of the Nursing Home(to be accepted at the Administrator's discretion).<br><br></li>

            	<li>Recognizing that any item not deposited with the Nursing Home may become lost, misplaced, or otherwise disappears. I choose not to use the Nursing Home's safekeeping facilities with repect to the items listed in paragraph 4, and therefore release and hold harmless the Nursing Home from any and all liability, costs and expenses, caused by, or related to, the loss of or other disappearance of such items.<br><br></li>

            	<li>I take full responsibility for retaining in my (the above resident's) possession the following articles, as well as any other items brought while I am a resident in the Nursing Home. (please check as appropriate).<br><br></li>
            </ol>
                    <?php  
                    	echo draw_checkbox_2col("Q1", "Bible;Earnings;Bracelet;Rings;Clothing;Medals;Rosary;Watch;Wallet;Purse;Radio;Television;Razor(Electric);Dentures(Upper);Dentures(Lower);Dentures(Partial);Amout of Money: <input type=\"text\" id=\"Q1M\" name=\"Q1M\" style=\"width:80px\" value=\"$Q1M\">", $Q1, "multi");
                    ?>   
            </td>             
        </tr>
        <tr>
                <td>Other item retained by resident:</td>
                <td colspan="3"><input type="textarea" id="Q2" name="Q2" style="width:99%;" value="<?php echo $Q2; ?>"></td>
        </tr>
        <tr>    
        	<td colspan="4" class="title"><strong>I acknowledge that the above information is correct:</strong></td>
        </tr>
        <tr>    
            <td class="title_s">Facility Representative</td>
            <td><input type="text" id="Q3" name="Q3" value="<?php echo $Q3; ?>"></td>
            <td class="title_s">Signature of Resident or <br>Person Authorized to Consent for Resident</td>
            <td><input type="text" id="Q4" name="Q4" value="<?php echo $Q4; ?>"></td>
        </tr>
        <tr>
            <td class="title_s">Date</td>
            <td><script> $(function() { $( "#Q5").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="Q5" id="Q5" value="<?php echo $Q5; ?>" size="12"></td>
            <td class="title_s">Relation to Resident</td>
            <td><input type="text" id="Q6" name="Q6" value="<?php echo $Q6; ?>"></td>
        </tr>
</table>

<!-- submit button + VN -->
        <center><input type="hidden" name="formID" id="formID" value="nurseform55" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" />
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