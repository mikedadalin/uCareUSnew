<?php
$pid = (int) @$_GET['pid'];
$db = new DB;
$db->query("SELECT `Name1`,`Name2`,`Name3`,`Name4`,`Race` FROM `patient` WHERE `patientID`='".mysql_escape_string($pid)."'");
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
}
	/*== 解 START ==*/
	$LWJArray = array('Name1','Name2','Name3','Name4');
	$LWJdataArray = array($Name1,$Name2,$Name3,$Name4);
	for($i=0;$i<count($LWJdataArray);$i++){
	    $rsa = new lwj('lwj/lwj');
	    $puepart = explode(" ",$LWJdataArray[$i]);
	    $puepartcount = count($puepart);
	    if($puepartcount>1){
            for($j=0;$j<$puepartcount;$j++){
                $prdpart = $rsa->privDecrypt($puepart[$j]);
                ${$LWJArray[$i]} = ${$LWJArray[$i]}.$prdpart;
            }
	    }else{
		   ${$LWJArray[$i]} = $rsa->privDecrypt($LWJdataArray[$i]);
	    }
	}
	/*== 解 END ==*/
   /*===== 身高轉換 START =====*/
   $inch = $height;
   $feet = floor($inch/12);
   $inch = $inch%12;
   $height = $feet."'".$inch;
   /*===== 身高轉換 END =====*/
if (@$_GET['date']=='') {
	$sql = "SELECT * FROM `mmqform01` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql = "SELECT * FROM `mmqform01` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`='".mysql_escape_string($_GET['date'])."'";
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
$dbSPN= new DB2;
$dbSPN->query("SELECT `SPN` FROM `system_setting` WHERE `OrgID`='".$_SESSION['nOrgID_lwj']."'");
$rSPN = $dbSPN->fetch_assoc();
?>
<form  method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<div class="content-table"><h3>MMQ</h3></div>
<div class="content-table">
<table style="width:1000px; border-spacing:0px; border-collapse:collapse; text-align:center; font-size:7px; white-space:nowrap;">
  <tr>
    <td style="border:black 1px solid;"><?php echo $indate; ?><br>Date of Admission</td>
    <td style="border:black 1px solid;">Commonwealth of Massachusetts --- EOHHS<br>MassHealth<br>Management Minutes Questionnaire</td>
    <td style="border:black 1px solid;"><input type="text" name="Qdate_2" id="Qdate_2" value="" size="1"><br>Effective Date</td>
  </tr>
</table>
<table style="width:1000px; border-spacing:0px; border-collapse:collapse; text-align:center; font-size:7px; white-space:nowrap;">
  <tr>
    <td style="border:black 1px solid;"><?php echo $Name3;?><br>Last Name</td>
	<td style="border:black 1px solid;"><?php echo $Name1;?><br>First Name</td>
	<td style="border:black 1px solid;"><input type="text" name="" id="" value="" size="1"><br>MI</td>
	<td style="border:black 1px solid;"><?php echo checkgender(mysql_escape_string($_GET['pid']));?><br>Sex</td>
	<td style="border:black 1px solid;"><?php echo checkRace($Race);?><br>Race</td>
	<td style="border:black 1px solid;">Reason for<br>Submission</td>
	<td style="border:black 1px solid;"><input type="text" name="" id="" value="" size="1"></td>
  </tr>
</table>
<table style="width:1000px; border-spacing:0px; border-collapse:collapse; text-align:center; font-size:7px; white-space:nowrap;">
  <tr>
    <td style="border:black 1px solid;"><input type="text" name="" id="" value="" size="1"><br>Recipient Identification Number (RID)</td>
	<td style="border:black 1px solid;"><?php echo $birth;?><br>DOB</td>
	<td style="border:black 1px solid;"><?php echo $rSPN['SPN'];?><br>Provider Number</td>
	<td style="border:black 1px solid;"><?php echo $_SESSION['nOrgName_lwj'];?><br>Facility Name</td>
  </tr>
</table>
<table style="width:1000px; border-spacing:0px; border-collapse:collapse; text-align:center; font-size:7px; white-space:nowrap;">
  <tr>
    <td colspan="3" style="border:black 1px solid;">SERVICE</td>
	<td style="border:black 1px solid;">CODE</td>
	<td style="border:black 1px solid;">SCORE</td>
	<td colspan="3" style="border:black 1px solid;">SERVICE</td>
	<td style="border:black 1px solid;">CODE</td>
	<td style="border:black 1px solid;">SCORE</td>
  </tr>
  <tr>
    <td style="border:black 1px solid; vertical-align:top;">1.</td>
	<td colspan="2" style="border:black 1px solid; vertical-align:top; text-align:left;">Dispense Medications and Chart*<br>C1/S30 for all patients</td>
	<td style="border:black 1px solid;">1</td>
	<td style="border:black 1px solid;">30</td>
    <td style="border:black 1px solid; vertical-align:top;">8.</td>
	<td colspan="2" style="border:black 1px solid; vertical-align:top; text-align:left;">Bladder/Bowel Retraining<br>C1/S0	- no retraining received<br>C2/S50	- bladder retraining<br>C3/S18	- bowel retraining<br>C4/S68	- bladder and bowel retraining</td>
	<td style="border:black 1px solid;"><?php echo draw_option("Q8","1;2;3;4","ss","single",$Q8,false,1);?></td>
	<td style="border:black 1px solid;"><input type="text" name="Q8_SCORE" id="Q8_SCORE" value="" size="1"></td>
  </tr>
  <tr>
    <td style="border:black 1px solid; vertical-align:top;">2.</td>
	<td colspan="2" style="border:black 1px solid; vertical-align:top; text-align:left;">Skilled Observation Daily*<br>C1/S0	- no observation<br>C2/S15	- daily observation</td>
	<td style="border:black 1px solid;"><?php echo draw_option("Q2","1;2","ss","single",$Q2,true,1);?></td>
	<td style="border:black 1px solid;"><input type="text" name="Q2_SCORE" id="Q2_SCORE" value="" size="1"></td>
    <td style="border:black 1px solid; vertical-align:top;">9.</td>
	<td colspan="2" style="border:black 1px solid; vertical-align:top; text-align:left;">Positioning<br>C1/S0	- independent<br>C2/S36	- assist</td>
	<td style="border:black 1px solid;"><?php echo draw_option("Q9","1;2","ss","single",$Q9,false,1);?></td>
	<td style="border:black 1px solid;"><input type="text" name="Q9_SCORE" id="Q9_SCORE" value="" size="1"></td>
  </tr>
  <tr>
    <td rowspan="2" style="border:black 1px solid; vertical-align:top;">3.</td>
	<td rowspan="2" style="border:black 1px solid; vertical-align:top; text-align:left;">Personal Hygiene<br>C1/S0	- independent/restorative prg.<br>C2/S18	- assist<br>C3/S20	- totally dependent</td>
	<td style="border:black 1px solid;">Bathing</td>
	<td style="border:black 1px solid;"><?php echo draw_option("Q3a","1;2;3","ss","single",$Q3a,true,1);?></td>
	<td rowspan="2" style="border:black 1px solid;"><input type="text" name="Q3_SCORE" id="Q3_SCORE" value="" size="1"></td>
    <td rowspan="2" style="border:black 1px solid; vertical-align:top;">10.</td>
	<td colspan="2" rowspan="2" style="border:black 1px solid; vertical-align:top; text-align:left;">Pressure Ulcer Prevention<br>C1/S0	- no preventive measures<br>C2/S10	- preventive measures</td>
	<td rowspan="2" style="border:black 1px solid;"><?php echo draw_option("Q10","1;2","ss","single",$Q10,false,1);?></td>
	<td rowspan="2" style="border:black 1px solid;"><input type="text" name="Q10_SCORE" id="Q10_SCORE" value="" size="1"></td>
  </tr>
  <tr>
	<td style="border:black 1px solid;">Grooming</td>
	<td style="border:black 1px solid;"><?php echo draw_option("Q3b","1;2;3","ss","single",$Q3b,true,1);?></td>
  </tr>
  <tr>
    <td style="border:black 1px solid; vertical-align:top;">4.</td>
	<td colspan="2" style="border:black 1px solid; vertical-align:top; text-align:left;">Dressing<br>C1/S0	- independent/restorative prg.<br>C2/S30	- assist<br>C3/S30	- totally dependent<br>C4/S0	- socks and shoes only<br>C5/S0	- not dressed</td>
	<td style="border:black 1px solid;"><?php echo draw_option("Q4","1;2;3;4;5","ss","single",$Q4,true,1);?></td>
	<td style="border:black 1px solid;"><input type="text" name="Q4_SCORE" id="Q4_SCORE" value="" size="1"></td>
    <td style="border:black 1px solid; vertical-align:top;">11.</td>
	<td colspan="3" style="border:black 1px solid; vertical-align:top; text-align:left;">Skilled Procedure Daily/Pressure Ulcer*<br>C1/S0	- if none<br>@daily frequency/S10X frequency<br>
	  <table style="width:80px; border-spacing:0px; border-collapse:collapse; text-align:center; font-size:7px; white-space:nowrap;">
	    <tr>
	      <td rowspan="2"><input type="text" name="Q11a" id="Q11a" value="" size="1"></td>
		  <td colspan="4" style="text-align:left;">Enter # at each stage</td>
	    </tr>
	    <tr>
	      <td><input type="text" name="Q11b_1" id="Q11b_1" value="" size="1"><br>1</td>
		  <td><input type="text" name="Q11b_2" id="Q11b_2" value="" size="1"><br>2</td>
		  <td><input type="text" name="Q11b_3" id="Q11b_3" value="" size="1"><br>3</td>
		  <td><input type="text" name="Q11b_4" id="Q11b_4" value="" size="1"><br>4</td>
	    </tr>
	  </table>
	</td>
	<td style="border:black 1px solid;"><input type="text" name="Q11_SCORE" id="Q11_SCORE" value="" size="1"></td>
  </tr>
  <tr>
    <td rowspan="2" style="border:black 1px solid; vertical-align:top;">5.</td>
	<td colspan="2" rowspan="2" style="border:black 1px solid; vertical-align:top; text-align:left;">Mobility<br>C1/S0	- independent/restorative prg.<br>C2/S0	- independent w/wheelchair<br>C3/S32	- walks with assist<br>C4/S32	- wheelchair with assist<br>C5/S0	- nonambulatory</td>
	<td rowspan="2" style="border:black 1px solid;"><?php echo draw_option("Q5","1;2;3;4;5","ss","single",$Q5,true,1);?></td>
	<td rowspan="2" style="border:black 1px solid;"><input type="text" name="Q5_SCORE" id="Q5_SCORE" value="" size="1"></td>
    <td rowspan="2" style="border:black 1px solid; vertical-align:top;">12.</td>
	<td colspan="2" rowspan="2" style="border:black 1px solid; vertical-align:top; text-align:left;">Skilled Procedure Daily/Other *<br>C0/S0	- if none<br>C daily frequency/S10X frequency<br>Enter up to 3 procedure types</td>
	<!--
	<td style="border:black 1px solid;"><input type="text" name="" id="" value="" size="1"></td>
	<td style="border:black 1px solid;">
	  <table style="width:80px; border-spacing:0px; border-collapse:collapse; text-align:center; font-size:7px; white-space:nowrap;">
	    <tr>
		  <td><input type="text" name="" id="" value="" size="1"></td>
		  <td><input type="text" name="" id="" value="" size="1"></td>
		  <td><input type="text" name="" id="" value="" size="1"></td>
		</tr>
	  </table>
	</td>
	-->
	<td style="border:black 1px solid;">
	<div style="float:left;"><input type="text" name="" id="" value="" size="1"></div>
	<div style="float:right;">
	  <table style="width:80px; border-spacing:0px; border-collapse:collapse; text-align:center; font-size:7px; white-space:nowrap;">
	    <tr>
		  <td><input type="text" name="" id="" value="" size="1" style="padding:0px; margin:0px;"></td>
		  <td><input type="text" name="" id="" value="" size="1" style="padding:0px; margin:0px;"></td>
		  <td><input type="text" name="" id="" value="" size="1" style="padding:0px; margin:0px;"></td>
		</tr>
	  </table>
	</div>
	</td>
	<td style="border:black 1px solid;"><input type="text" name="" id="" value="" size="1"></td>
  </tr>
  <tr>
    <td colspan="2" style="border:black 1px solid; text-align:right;">SUBTOTAL: <input type="text" name="" id="" value="" size="1"></td>
  </tr>
  <tr>
    <td style="border:black 1px solid; vertical-align:top;">6.</td>
	<td colspan="2" style="border:black 1px solid; vertical-align:top; text-align:left;">Eating<br>C1/S0	- independent/restorative prg.<br>C2/S20	- assist<br>C3/S45	- totally dependent<br>C4/S90	- tube fed *<br>C5/S90	- I.V. *<br>C6/S110	- tube fed and assist *<br>C7/S135	- tube fed and totally dependent *<br>C8/S135	- tube fed and I.V. *</td>
	<td style="border:black 1px solid;"><?php echo draw_option("Q6","1;2;3;4;5;6;7;8","ss","single",$Q6,true,1);?></td>
	<td style="border:black 1px solid;"><input type="text" name="Q6_SCORE" id="Q6_SCORE" value="" size="1"></td>
    <td style="border:black 1px solid; vertical-align:top;">13.</td>
	<td colspan="2" style="border:black 1px solid; vertical-align:top; text-align:left;">Special Attention<br>Code A - Immobility<br>Code B - severe spasticity/rigidity<br>Code C - behavioral problems<br>Code D - isolation</td>
	<td style="border:black 1px solid;"><input type="text" name="" id="" value="" size="1"><br><input type="text" name="" id="" value="" size="1"><br><input type="text" name="" id="" value="" size="1"><br><input type="text" name="" id="" value="" size="1"></td>
	<td style="border:black 1px solid; text-align:left;">If applies, Code 1,2,3<br>otherwise Code 0<br>Score 10% of<br>SubTotal: <input type="text" name="" id="" value="" size="1"></td>
  </tr>
  <tr>
    <td rowspan="3" style="border:black 1px solid; vertical-align:top;">7.</td>
	<td rowspan="3" style="border:black 1px solid; vertical-align:top; text-align:left;">Continence/Catheter<br>C1/S0 - continent<br>C2/S0 - incontinent occasionally<br>C3/S48 - incontinent & toileted<br>C4/S48 - incontinent<br>C5/S20 - indwelling catheter<br>Note:if bladder is C5 & bowel is C3 or C4/S38<br>C6/S18 - bowel incontinent & bladder training</td>
	<td style="border:black 1px solid;">Bladder</td>
	<td style="border:black 1px solid;"><?php echo draw_option("Q7a","1;2;3;4;5;6","ss","single",$Q7a,true,1);?></td>
	<td rowspan="3" style="border:black 1px solid;"><input type="text" name="Q7_SCORE" id="Q7_SCORE" value="" size="1"></td>
    <td rowspan="3" style="border:black 1px solid; vertical-align:top;">14.</td>
	<td colspan="2" rowspan="3" style="border:black 1px solid; vertical-align:top; text-align:left;">Restorative Nursing<br>Code 0/S0 if none<br>Code 1-7/S30<br>Code 1 - dressing<br>Code 2 - personal hygiene<br>Code 3 - eating<br>Code 4 - ostonomy teaching<br>Code 5 - diabetic teaching<br>Code 6 - ambulation<br>Code 7 - range of motion</td>
	<td style="border:black 1px solid;"><input type="text" name="" id="" value="" size="1"><input type="text" name="" id="" value="" size="1"><input type="text" name="" id="" value="" size="1"></td>
	<td style="border:black 1px solid;"><input type="text" name="" id="" value="" size="1"></td>
  </tr>
  <tr>
    <td rowspan="2" style="border:black 1px solid;">Bowel</td>
	<td rowspan="2" style="border:black 1px solid;"><?php echo draw_option("Q7b","1;2;3;4;5;6","ss","single",$Q7b,true,1);?></td>
    <td colspan="2" style="border:black 1px solid; text-align:right;">GRAND TOTAL: <input type="text" name="" id="" value="" size="5"></td>
  </tr>
  <tr>
    <td colspan="2" style="border:black 1px solid; text-align:right;">CATEGORY: <input type="text" name="" id="" value="" size="5"></td>
  </tr>
  <tr>
    <td colspan="10" style="border:black 1px solid;">* CARE PROVIDED ONLY BY A LICENSED NURSE</td>
  </tr>
</table>
<table style="width:1000px; border-spacing:0px; border-collapse:collapse; text-align:center; font-size:7px; white-space:nowrap;">
  <tr>
    <td rowspan="2" style="border:black 1px solid; vertical-align:top;">15.</td>
	<td rowspan="2" style="border:black 1px solid; vertical-align:top; text-align:left;">Toilet Use<br>Code 1 - independent<br>Code 2 - assist<br>Code 3 - totally dependent<br>Code 4 - not toileted</td>
	<td style="border:black 1px solid; height:16px;">CODE</td>
    <td rowspan="2" style="border:black 1px solid; vertical-align:top;">18.</td>
	<td rowspan="2" style="border:black 1px solid; vertical-align:top; text-align:left;">Restraint<br>Code 1 - not ordeblack<br>Code 2 - ordeblack not used<br>Code 3 - ordeblack and used daily</td>
	<td style="border:black 1px solid; height:16px;">CODE</td>
    <td rowspan="2" style="border:black 1px solid; vertical-align:top;">21.</td>
	<!--
	<td rowspan="2" style="border:black 1px solid; vertical-align:top; text-align:left;">Medications<br>MED	- Code 0-8<br>F	- Code 1 - regularly<br>	- Code 2 - PRN<br>	- Code 3 - one time only</td>
	<td rowspan="2" style="border:black 1px solid;">
	  <table style="width:80px; border-spacing:0px; border-collapse:collapse; font-size:7px; white-space:nowrap;">
	    <tr>
		  <td style="border:black 1px solid;">MED</td>
		  <td style="border:black 1px solid;"><input type="text" name="" id="" value="" size="1"></td>
		  <td style="border:black 1px solid;"><input type="text" name="" id="" value="" size="1"></td>
		  <td style="border:black 1px solid;"><input type="text" name="" id="" value="" size="1"></td>
		  <td style="border:black 1px solid;"><input type="text" name="" id="" value="" size="1"></td>
		</tr>
	    <tr>
		  <td style="border:black 1px solid;">F</td>
		  <td style="border:black 1px solid;"><input type="text" name="" id="" value="" size="1"></td>
		  <td style="border:black 1px solid;"><input type="text" name="" id="" value="" size="1"></td>
		  <td style="border:black 1px solid;"><input type="text" name="" id="" value="" size="1"></td>
		  <td style="border:black 1px solid;"><input type="text" name="" id="" value="" size="1"></td>
		</tr>
	  </table>
	</td>
	-->
	<td colspan="2" rowspan="2" style="border:black 1px solid; vertical-align:top; text-align:left;">
	<div style="float:left;">Medications<br>MED	- Code 0-8<br>F	- Code 1 - regularly<br>	- Code 2 - PRN<br>	- Code 3 - one time only</div>
	<div style="float:right;">
	  <table style="width:80px; border-spacing:0px; border-collapse:collapse; font-size:7px; white-space:nowrap;">
	    <tr>
		  <td style="border:black 1px solid;">MED</td>
		  <td style="border:black 1px solid;"><input type="text" name="" id="" value="" size="1"></td>
		  <td style="border:black 1px solid;"><input type="text" name="" id="" value="" size="1"></td>
		  <td style="border:black 1px solid;"><input type="text" name="" id="" value="" size="1"></td>
		  <td style="border:black 1px solid;"><input type="text" name="" id="" value="" size="1"></td>
		</tr>
	    <tr>
		  <td style="border:black 1px solid;">F</td>
		  <td style="border:black 1px solid;"><input type="text" name="" id="" value="" size="1"></td>
		  <td style="border:black 1px solid;"><input type="text" name="" id="" value="" size="1"></td>
		  <td style="border:black 1px solid;"><input type="text" name="" id="" value="" size="1"></td>
		  <td style="border:black 1px solid;"><input type="text" name="" id="" value="" size="1"></td>
		</tr>
	  </table>
	  </div>
	</td>
  </tr>
  <tr>
    <td style="border:black 1px solid;"><?php echo draw_option("Q15","1;2;3;4","ss","single",$Q15,true,1);?></td>
    <td style="border:black 1px solid;"><?php echo draw_option("Q18","1;2;3","ss","single",$Q18,false,1);?></td>
  </tr>
  <tr>
    <td style="border:black 1px solid; vertical-align:top;">16.</td>
	<td style="border:black 1px solid; vertical-align:top; text-align:left;">Transfer<br>Code 1 - independent<br>Code 2 - assist<br>Code 3 - totally dependent<br>Code 4 - bed bound</td>
	<td style="border:black 1px solid;"><?php echo draw_option("Q16","1;2;3;4","ss","single",$Q16,true,1);?></td>
    <td style="border:black 1px solid; vertical-align:top;">19.</td>
	<td style="border:black 1px solid; vertical-align:top; text-align:left;">Activities Participation<br>Code 1 - always active<br>Code 2 - occasionally active<br>Code 3 - rarely active or not active<br>Code 8 - not yet determined</td>
	<td style="border:black 1px solid;"><?php echo draw_option("Q19","1;2;3;8","ss","single",$Q19,true,2);?></td>
    <td style="border:black 1px solid; vertical-align:top;">22.</td>
	<!--
	<td style="border:black 1px solid; vertical-align:top; text-align:left;">Accidents/Contracture/Weight Change<br>Code 1 - Yes<br>Code 2 - No</td>
	<td style="border:black 1px solid;">
	  <table style="width:80px; border-spacing:0px; border-collapse:collapse; font-size:7px; white-space:nowrap;">
	    <tr>
	      <td style="border:black 1px solid;">A</td>
		  <td style="border:black 1px solid;">C</td>
		  <td style="border:black 1px solid;">WC</td>
	    </tr>
	    <tr>
	      <td style="border:black 1px solid; height:16px;"><input type="text" name="" id="" value="" size="1"></td>
		  <td style="border:black 1px solid; height:16px;"><input type="text" name="" id="" value="" size="1"></td>
		  <td style="border:black 1px solid; height:16px;"><input type="text" name="" id="" value="" size="1"></td>
	    </tr>
	  </table>
	</td>
	-->
	<td colspan="2" style="border:black 1px solid; vertical-align:top; text-align:left;">
	<div style="float:left;">Accidents/Contracture/Weight Change<br>Code 1 - Yes<br>Code 2 - No</div>
	<div style="float:right;">
	  <table style="width:80px; border-spacing:0px; border-collapse:collapse; font-size:7px; white-space:nowrap;">
	    <tr>
	      <td style="border:black 1px solid;">A</td>
		  <td style="border:black 1px solid;">C</td>
		  <td style="border:black 1px solid;">WC</td>
	    </tr>
	    <tr>
	      <td style="border:black 1px solid; height:16px;"><input type="text" name="" id="" value="" size="1"></td>
		  <td style="border:black 1px solid; height:16px;"><input type="text" name="" id="" value="" size="1"></td>
		  <td style="border:black 1px solid; height:16px;"><input type="text" name="" id="" value="" size="1"></td>
	    </tr>
	  </table>
	  </div>
	</td>
  </tr>
  <tr>
    <td rowspan="2" style="border:black 1px solid; vertical-align:top;">17.</td>
	<td rowspan="2" style="border:black 1px solid; vertical-align:top; text-align:left;">Mental Status<br>Code 1 - oriented<br>Code 2 - disoriented<br>Code 3 - not yet determined</td>
	<td rowspan="2" style="border:black 1px solid;"><?php echo draw_option("Q17","1;2;3","ss","single",$Q17,true,1);?></td>
    <td rowspan="2" style="border:black 1px solid; vertical-align:top;">20.</td>
	<!--
	<td rowspan="2" style="border:black 1px solid; vertical-align:top; text-align:left;">Consultations<br>Code 00 - not consultations<br>Code 88 - not yet determined<br>Enter type and frequency<br>Code 01-12</td>
	<td rowspan="2" style="border:black 1px solid;">
	  <table style="width:80px; border-spacing:0px; border-collapse:collapse; font-size:7px; white-space:nowrap;">
	    <tr>
	      <td style="border:black 1px solid;">TYPE</td>
		  <td style="border:black 1px solid;">FREQ</td>
	    </tr>
	    <tr>
	      <td style="border:black 1px solid; height:16px;"><input type="text" name="" id="" value="" size="1"></td>
		  <td style="border:black 1px solid; height:16px;"><input type="text" name="" id="" value="" size="1"></td>
	    </tr>
	    <tr>
	      <td style="border:black 1px solid; height:16px;"><input type="text" name="" id="" value="" size="1"></td>
		  <td style="border:black 1px solid; height:16px;"><input type="text" name="" id="" value="" size="1"></td>
	    </tr>
	    <tr>
	      <td style="border:black 1px solid; height:16px;"><input type="text" name="" id="" value="" size="1"></td>
		  <td style="border:black 1px solid; height:16px;"><input type="text" name="" id="" value="" size="1"></td>
	    </tr>
	  </table>
	</td>
	-->
	<td colspan="2" rowspan="2" style="border:black 1px solid; vertical-align:top; text-align:left;">
	<div rowspan="2" style="float:left;">Consultations<br>Code 00 - not consultations<br>Code 88 - not yet determined<br>Enter type and frequency<br>Code 01-12</div>
	<div rowspan="2" style="float:right;">
	  <table style="width:80px; border-spacing:0px; border-collapse:collapse; font-size:7px; white-space:nowrap;">
	    <tr>
	      <td style="border:black 1px solid;">TYPE</td>
		  <td style="border:black 1px solid;">FREQ</td>
	    </tr>
	    <tr>
	      <td style="border:black 1px solid; height:16px;"><input type="text" name="" id="" value="" size="1"></td>
		  <td style="border:black 1px solid; height:16px;"><input type="text" name="" id="" value="" size="1"></td>
	    </tr>
	    <tr>
	      <td style="border:black 1px solid; height:16px;"><input type="text" name="" id="" value="" size="1"></td>
		  <td style="border:black 1px solid; height:16px;"><input type="text" name="" id="" value="" size="1"></td>
	    </tr>
	    <tr>
	      <td style="border:black 1px solid; height:16px;"><input type="text" name="" id="" value="" size="1"></td>
		  <td style="border:black 1px solid; height:16px;"><input type="text" name="" id="" value="" size="1"></td>
	    </tr>
	  </table>
	</div>
	</td>
    <td style="border:black 1px solid; vertical-align:top;">23.</td>
	<td colspan="2" style="border:black 1px solid; vertical-align:top; text-align:left;">Primary Diagnosis: <input type="text" name="" id="" value="" size="30"></td>
  </tr>
  <tr>
    <td style="border:black 1px solid; vertical-align:top;">24.</td>
	<td colspan="2" style="border:black 1px solid; vertical-align:top; text-align:left;">Secondary Diagnosis(es)<br>
	  <table style="width:80px; border-spacing:0px; border-collapse:collapse; font-size:7px; white-space:nowrap;">
	    <tr>
		  <td style="border:black 1px solid; height:16px;"><input type="text" name="" id="" value="" size="1"></td>
		  <td style="border:black 1px solid; height:16px;"><input type="text" name="" id="" value="" size="1"></td>
		  <td style="border:black 1px solid; height:16px;"><input type="text" name="" id="" value="" size="1"></td>
		</tr>
	  </table>
	</td>
  </tr>
  <tr>
    <td style="border:black 1px solid; vertical-align:top;">25.</td>
	<td colspan="2" style="border:black 1px solid; vertical-align:top; text-align:left;">RN Evaluator: <input type="text" name="" id="" value="" size="15"></td>
	<td style="border:black 1px solid; vertical-align:top;">26.</td>
	<td colspan="2" style="border:black 1px solid; vertical-align:top; text-align:left;">Eval Date: <input type="text" name="" id="" value="" size="15"></td>
	<td style="border:black 1px solid; vertical-align:top;">27.</td>
	<td colspan="2" style="border:black 1px solid; vertical-align:top; text-align:left;">Administrator: <input type="text" name="" id="" value="" size="15"></td>
  </tr>
  <tr>
    <td style="border:black 1px solid; vertical-align:top;">28.</td>
	<td colspan="8" style="border:black 1px solid; vertical-align:top; text-align:left;">Affiliation<input type="text" name="" id="" value="" size="30"></td>
  </tr>
</table>
Filled date：<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if($_GET['newDate']!="") { echo formatdate($_GET['newDate']); } else { if ($date != NULL) { echo formatdate($date); } } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" />
<center><input type="hidden" name="formID" id="formID" value="nurseform01a" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Requiblack</button></center>
</div>
</form>
<script>
$(document).ready(function () {
	$("[id*=\'btn_Q\']").click(function() {
		changeSCORE(this.id);
	});
})
function changeSCORE(id) {
	var arrID = id.split('_');
	var value = document.getElementById(arrID[1] + '_' + arrID[2]).value;
	if(value=="1"){
		if(arrID[1]=="Q2"){
			if(arrID[2]=="1"){
				document.getElementById(arrID[1] + '_SCORE').value = "0";
			}else if(arrID[2]=="2"){
				document.getElementById(arrID[1] + '_SCORE').value = "15";
			}
		}
		if(arrID[1]=="Q3a" || arrID[1]=="Q3b"){
			var Q3_SCORE = new Number();
			var Q3a_1 = $("#Q3a_1").val();
			var Q3a_2 = $("#Q3a_2").val();
			var Q3a_3 = $("#Q3a_3").val();
			var Q3b_1 = $("#Q3b_1").val();
			var Q3b_2 = $("#Q3b_2").val();
			var Q3b_3 = $("#Q3b_3").val();
			if(Q3a_1=="1"){ Q3_SCORE = eval(Q3_SCORE+0); }
			if(Q3a_2=="1"){ Q3_SCORE = eval(Q3_SCORE+18); }
			if(Q3a_3=="1"){ Q3_SCORE = eval(Q3_SCORE+20); }
			if(Q3b_1=="1"){ Q3_SCORE = eval(Q3_SCORE+0); }
			if(Q3b_2=="1"){ Q3_SCORE = eval(Q3_SCORE+18); }
			if(Q3b_3=="1"){ Q3_SCORE = eval(Q3_SCORE+20); }
			document.getElementById('Q3_SCORE').value = Q3_SCORE;
		}
		if(arrID[1]=="Q4"){
			if(arrID[2]=="1"){
				document.getElementById(arrID[1] + '_SCORE').value = "0";
			}else if(arrID[2]=="2"){
				document.getElementById(arrID[1] + '_SCORE').value = "30";
			}else if(arrID[2]=="3"){
				document.getElementById(arrID[1] + '_SCORE').value = "30";
			}else if(arrID[2]=="4"){
				document.getElementById(arrID[1] + '_SCORE').value = "0";
			}else if(arrID[2]=="5"){
				document.getElementById(arrID[1] + '_SCORE').value = "0";
			}
		}
		if(arrID[1]=="Q5"){
			if(arrID[2]=="1"){
				document.getElementById(arrID[1] + '_SCORE').value = "0";
			}else if(arrID[2]=="2"){
				document.getElementById(arrID[1] + '_SCORE').value = "0";
			}else if(arrID[2]=="3"){
				document.getElementById(arrID[1] + '_SCORE').value = "32";
			}else if(arrID[2]=="4"){
				document.getElementById(arrID[1] + '_SCORE').value = "32";
			}else if(arrID[2]=="5"){
				document.getElementById(arrID[1] + '_SCORE').value = "0";
			}
		}
		if(arrID[1]=="Q6"){
			if(arrID[2]=="1"){
				document.getElementById(arrID[1] + '_SCORE').value = "0";
			}else if(arrID[2]=="2"){
				document.getElementById(arrID[1] + '_SCORE').value = "20";
			}else if(arrID[2]=="3"){
				document.getElementById(arrID[1] + '_SCORE').value = "45";
			}else if(arrID[2]=="4"){
				document.getElementById(arrID[1] + '_SCORE').value = "90";
			}else if(arrID[2]=="5"){
				document.getElementById(arrID[1] + '_SCORE').value = "90";
			}else if(arrID[2]=="6"){
				document.getElementById(arrID[1] + '_SCORE').value = "110";
			}else if(arrID[2]=="7"){
				document.getElementById(arrID[1] + '_SCORE').value = "135";
			}else if(arrID[2]=="8"){
				document.getElementById(arrID[1] + '_SCORE').value = "135";
			}
		}
		if(arrID[1]=="Q7a" || arrID[1]=="Q7b"){
			var Q7_SCORE = new Number();
			var Q7a_1 = $("#Q7a_1").val();
			var Q7a_2 = $("#Q7a_2").val();
			var Q7a_3 = $("#Q7a_3").val();
			var Q7a_4 = $("#Q7a_4").val();
			var Q7a_5 = $("#Q7a_5").val();
			var Q7a_6 = $("#Q7a_6").val();
			var Q7b_1 = $("#Q7b_1").val();
			var Q7b_2 = $("#Q7b_2").val();
			var Q7b_3 = $("#Q7b_3").val();
			var Q7b_4 = $("#Q7b_4").val();
			var Q7b_5 = $("#Q7b_5").val();
			var Q7b_6 = $("#Q7b_6").val();
			if(Q7a_1=="1"){ Q7_SCORE = eval(Q7_SCORE+0); }
			if(Q7a_2=="1"){ Q7_SCORE = eval(Q7_SCORE+0); }
			if(Q7a_3=="1"){ Q7_SCORE = eval(Q7_SCORE+48); }
			if(Q7a_4=="1"){ Q7_SCORE = eval(Q7_SCORE+48); }
			if(Q7a_5=="1"){ Q7_SCORE = eval(Q7_SCORE+20); }
			if(Q7a_6=="1"){ Q7_SCORE = eval(Q7_SCORE+18); }
			if(Q7b_1=="1"){ Q7_SCORE = eval(Q7_SCORE+0); }
			if(Q7b_2=="1"){ Q7_SCORE = eval(Q7_SCORE+0); }
			if(Q7b_3=="1"){ Q7_SCORE = eval(Q7_SCORE+48); }
			if(Q7b_4=="1"){ Q7_SCORE = eval(Q7_SCORE+48); }
			if(Q7b_5=="1"){ Q7_SCORE = eval(Q7_SCORE+20); }
			if(Q7b_6=="1"){ Q7_SCORE = eval(Q7_SCORE+18); }
			document.getElementById('Q7_SCORE').value = Q7_SCORE;
		}
		if(arrID[1]=="Q8"){
			if(arrID[2]=="1"){
				document.getElementById(arrID[1] + '_SCORE').value = "0";
			}else if(arrID[2]=="2"){
				document.getElementById(arrID[1] + '_SCORE').value = "50";
			}else if(arrID[2]=="3"){
				document.getElementById(arrID[1] + '_SCORE').value = "18";
			}else if(arrID[2]=="4"){
				document.getElementById(arrID[1] + '_SCORE').value = "68";
			}
		}
		if(arrID[1]=="Q9"){
			if(arrID[2]=="1"){
				document.getElementById(arrID[1] + '_SCORE').value = "0";
			}else if(arrID[2]=="2"){
				document.getElementById(arrID[1] + '_SCORE').value = "36";
			}
		}
		if(arrID[1]=="Q10"){
			if(arrID[2]=="1"){
				document.getElementById(arrID[1] + '_SCORE').value = "0";
			}else if(arrID[2]=="2"){
				document.getElementById(arrID[1] + '_SCORE').value = "10";
			}
		}
	}else if(value=="0"){
		if(arrID[1]=="Q3a" || arrID[1]=="Q3b"){
			var Q3_SCORE = new Number();
			var Q3a_1 = $("#Q3a_1").val();
			var Q3a_2 = $("#Q3a_2").val();
			var Q3a_3 = $("#Q3a_3").val();
			var Q3b_1 = $("#Q3b_1").val();
			var Q3b_2 = $("#Q3b_2").val();
			var Q3b_3 = $("#Q3b_3").val();
			if(Q3a_1=="0" && Q3a_2=="0" && Q3a_3=="0" && Q3b_1=="0" && Q3b_2=="0" && Q3b_3=="0"){
				document.getElementById('Q3_SCORE').value = "";
			}else{
				if(Q3a_1=="1"){ Q3_SCORE = eval(Q3_SCORE+0); }
				if(Q3a_2=="1"){ Q3_SCORE = eval(Q3_SCORE+18); }
				if(Q3a_3=="1"){ Q3_SCORE = eval(Q3_SCORE+20); }
				if(Q3b_1=="1"){ Q3_SCORE = eval(Q3_SCORE+0); }
				if(Q3b_2=="1"){ Q3_SCORE = eval(Q3_SCORE+18); }
				if(Q3b_3=="1"){ Q3_SCORE = eval(Q3_SCORE+20); }
				document.getElementById('Q3_SCORE').value = Q3_SCORE;
			}
		}else if(arrID[1]=="Q7a" || arrID[1]=="Q7b"){
			var Q7_SCORE = new Number();
			var Q7a_1 = $("#Q7a_1").val();
			var Q7a_2 = $("#Q7a_2").val();
			var Q7a_3 = $("#Q7a_3").val();
			var Q7a_4 = $("#Q7a_4").val();
			var Q7a_5 = $("#Q7a_5").val();
			var Q7a_6 = $("#Q7a_6").val();
			var Q7b_1 = $("#Q7b_1").val();
			var Q7b_2 = $("#Q7b_2").val();
			var Q7b_3 = $("#Q7b_3").val();
			var Q7b_4 = $("#Q7b_4").val();
			var Q7b_5 = $("#Q7b_5").val();
			var Q7b_6 = $("#Q7b_6").val();
			if(Q7a_1=="0" && Q7a_2=="0" && Q7a_3=="0" && Q7a_4=="0" && Q7a_5=="0" && Q7a_6=="0" && Q7b_1=="0" && Q7b_2=="0" && Q7b_3=="0" && Q7b_4=="0" && Q7b_5=="0" && Q7b_6=="0"){
				document.getElementById('Q7_SCORE').value = "";
			}else{
				if(Q7a_1=="1"){ Q7_SCORE = eval(Q7_SCORE+0); }
				if(Q7a_2=="1"){ Q7_SCORE = eval(Q7_SCORE+0); }
				if(Q7a_3=="1"){ Q7_SCORE = eval(Q7_SCORE+48); }
				if(Q7a_4=="1"){ Q7_SCORE = eval(Q7_SCORE+48); }
				if(Q7a_5=="1"){ Q7_SCORE = eval(Q7_SCORE+20); }
				if(Q7a_6=="1"){ Q7_SCORE = eval(Q7_SCORE+18); }
				if(Q7b_1=="1"){ Q7_SCORE = eval(Q7_SCORE+0); }
				if(Q7b_2=="1"){ Q7_SCORE = eval(Q7_SCORE+0); }
				if(Q7b_3=="1"){ Q7_SCORE = eval(Q7_SCORE+48); }
				if(Q7b_4=="1"){ Q7_SCORE = eval(Q7_SCORE+48); }
				if(Q7b_5=="1"){ Q7_SCORE = eval(Q7_SCORE+20); }
				if(Q7b_6=="1"){ Q7_SCORE = eval(Q7_SCORE+18); }
				document.getElementById('Q7_SCORE').value = Q7_SCORE;
			}
		}else{
			document.getElementById(arrID[1] + '_SCORE').value = "";
		}
	}
}
</script>