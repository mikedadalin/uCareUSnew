<?php
if(isset($_POST['submit'])){
	array_pop($_POST);
	$db4 = new DB;
	$db4->query("SELECT * FROM `feesetting` WHERE HospNo='".mysql_escape_string($_POST['HospNo'])."'");
	if($db4->num_rows() == 0){
		$db4->query("INSERT INTO `feesetting` (`HospNo`) VALUES ('".mysql_escape_string($_POST['HospNo'])."')");
	}
	$strSQL ="UPDATE feesetting SET ";
	foreach ($_POST as $k=>$v) {
		if(substr($k,0,6)!="Qebill"){
			/*== 加 START ==*/
			if($k=="account" || $k=="accountName"){
	  	    	$rsa = new lwj('lwj/lwj');
	  	    	$part = ceil(strlen($v)/117);
	  	    	if($part>1){
        	    	$datapart = str_split($v, 117);
        	    	for($m=0;$m<$part;$m++){
	      	        	$puepart = $rsa->pubEncrypt($datapart[$m]);
	      		    	$v = $v.$puepart." ";
        	    	}
	  	    	}else{
		  	    	$v = $rsa->pubEncrypt($v);
	  	    	}			
			}
			/*== 加 END ==*/
			$strSQL .= "`".$k."`='".$v."', ";			
		}
	}
	$strSQL .= "`uDate`='".date("Y-m-d H:i:s")."', `userID`='".$_SESSION['ncareID_lwj']."' WHERE HospNo='".mysql_escape_string($_POST['HospNo'])."'";
	//echo $strSQL;
	$db = new DB;
	$db->query($strSQL);
}
$pid = (int) @$_GET['pid'];
$db = new DB;
$db->query("SELECT `patientID`,`HospNo`,`Birth`,`Gender_1`,`Gender_2`,`Birthplace`,`IdNo`,`Postcode`,`Address`,`Address2`,`Address3`,`Address4`,`Address5` FROM `patient` WHERE `patientID`='".mysql_escape_string($pid)."'");
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
$Name = getPatientName($r['patientID']);
	/*== 解 START ==*/
	$LWJArray = array('IdNo','Postcode','Address','Address2','Address3','Address4','Address5');
	$LWJdataArray = array($IdNo,$Postcode,$Address,$Address2,$Address3,$Address4,$Address5);
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
if (@$_GET['date']=='') {
	$sql = "SELECT * FROM `nurseform01` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql = "SELECT * FROM `nurseform01` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`='".mysql_escape_string($_GET['date'])."'";
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
	/*== 解 START ==*/
	$LWJArray = array('QContactPerson1Name','QContactPerson1Company','QContactPerson1Tel1','QContactPerson1Tel2','QContactPerson1Tel3','QContactPerson1Address','QContactPerson1Email','QContactPerson2Name','QContactPerson2Company','QContactPerson2Tel1','QContactPerson2Tel2','QContactPerson2Tel3','QContactPerson2Address','QContactPerson2Email','QContactPerson3Name','QContactPerson3Company','QContactPerson3Tel1','QContactPerson3Tel2','QContactPerson3Tel3','QContactPerson3Address','QContactPerson3Email','QContactPerson4Name','QContactPerson4Company','QContactPerson4Tel1','QContactPerson4Tel2','QContactPerson4Tel3','QContactPerson4Address','QContactPerson4Email');
	$LWJdataArray = array($QContactPerson1Name,$QContactPerson1Company,$QContactPerson1Tel1,$QContactPerson1Tel2,$QContactPerson1Tel3,$QContactPerson1Address,$QContactPerson1Email,$QContactPerson2Name,$QContactPerson2Company,$QContactPerson2Tel1,$QContactPerson2Tel2,$QContactPerson2Tel3,$QContactPerson2Address,$QContactPerson2Email,$QContactPerson3Name,$QContactPerson3Company,$QContactPerson3Tel1,$QContactPerson3Tel2,$QContactPerson3Tel3,$QContactPerson3Address,$QContactPerson3Email,$QContactPerson4Name,$QContactPerson4Company,$QContactPerson4Tel1,$QContactPerson4Tel2,$QContactPerson4Tel3,$QContactPerson4Address,$QContactPerson4Email);
	for($z=0;$z<count($LWJdataArray);$z++){
	    $rsa = new lwj('lwj/lwj');
	    $puepart = explode(" ",$LWJdataArray[$z]);
	    $puepartcount = count($puepart);
	    if($puepartcount>1){
            for($m=0;$m<$puepartcount;$m++){
                $prdpart = $rsa->privDecrypt($puepart[$m]);
                ${$LWJArray[$z]} = ${$LWJArray[$z]}.$prdpart;
            }
	    }else{
		   ${$LWJArray[$z]} = $rsa->privDecrypt($LWJdataArray[$z]);
	    }
	}
	/*== 解 END ==*/

$db3 = new DB;
$db3->query("SELECT * FROM `feesetting` WHERE `HospNo`='".mysql_escape_string(getHospNo($pid))."'");
$r3 = $db3->fetch_assoc();
	/*== 解 START ==*/
	$LWJArray = array('account','accountName');
	$LWJdataArray = array($r3['account'],$r3['accountName']);
	for($z=0;$z<count($LWJdataArray);$z++){
	    $rsa = new lwj('lwj/lwj');
	    $puepart = explode(" ",$LWJdataArray[$z]);
	    $puepartcount = count($puepart);
	    if($puepartcount>1){
            for($m=0;$m<$puepartcount;$m++){
                $prdpart = $rsa->privDecrypt($puepart[$m]);
                ${$LWJArray[$z]} = ${$LWJArray[$z]}.$prdpart;
            }
	    }else{
		   ${$LWJArray[$z]} = $rsa->privDecrypt($LWJdataArray[$z]);
	    }
	}
	/*== 解 END ==*/
?>
<form  method="post" id="form1">
<h3>Resident's profile(Monthly charge setting)</h3>
<table width="100%">
  <tr>
    <td width="120" class="title">Resident name</td>
    <td width="160"><?php echo $Name; ?></td>
    <td width="120" class="title">Gender</td>
    <td width="160"><?php echo option_result("patient_Gender","Male;Female","s","single",$Gender,false,5); ?></td>
    <td width="120" class="title"><p>Birthplace</p></td>
    <td><?php echo $Birthplace; ?></td>
  </tr>
  <tr>
    <td class="title">Social Security number</td>
    <td><?php echo $IdNo; ?></td>
    <td class="title">DOB</td>
    <td><?php echo formatdate($Birth); ?></td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  <tr>
    <td class="title">Residence address</td>
    <td colspan="5">
    <table class="tableinside">
      <tr style="height:12px;">
        <td width="60"><span style="font-size:8pt;">Postal code</span></td>
        <td width="60"><span style="font-size:8pt;">State</span></td>
        <td width="120"><span style="font-size:8pt;">Country</span></td>
        <td width="120"><span style="font-size:8pt;">City</span></td>
        <td width="120"><span style="font-size:8pt;">Address 1</span></td>
        <td width="120"><span style="font-size:8pt;">Address 2</span></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><?php echo $Postcode; ?></td>
        <td><?php echo $Address; ?></td>
        <td><?php echo $Address2; ?></td>
        <td><?php echo $Address3; ?></td>
        <td><?php echo $Address4; ?></td>
        <td><?php echo $Address5; ?></td>
      </tr>
    </table>
    </td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td width="120" class="title">Disability proof card</td>
    <td width="160" colspan="5" align="left"><?php echo option_result("Qdisable","Has;None","s","multi",$Qdisable,false,5); ?><br />舊類別：
    <div class="formselect" style="display:inline;">
    <select name="QdisableTypeA" id="QdisableTypeA" disabled="disabled">
      <option value="0" <?php if ($QdisableTypeA==0) echo " selected"; ?>>None</option>
      <option value="">---------------舊制類別---------------</option>
      <option value="9" <?php if ($QdisableTypeA==9) echo " selected"; ?>>智能障礙者</option>
      <option value="10" <?php if ($QdisableTypeA==10) echo " selected"; ?>>vegetative being</option>
      <option value="11" <?php if ($QdisableTypeA==11) echo " selected"; ?>>失智症者</option>
      <option value="12" <?php if ($QdisableTypeA==12) echo " selected"; ?>>自閉症者</option>
      <option value="13" <?php if ($QdisableTypeA==13) echo " selected"; ?>>慢性精神病患者</option>
      <option value="14" <?php if ($QdisableTypeA==14) echo " selected"; ?>>頑性（難治型）癲癇症者</option>
      <option value="15" <?php if ($QdisableTypeA==15) echo " selected"; ?>>視覺障礙者</option>
      <option value="16" <?php if ($QdisableTypeA==16) echo " selected"; ?>>聽覺機能障礙者</option>
      <option value="17" <?php if ($QdisableTypeA==17) echo " selected"; ?>>平衡機能障礙者</option>
      <option value="18" <?php if ($QdisableTypeA==18) echo " selected"; ?>>聲音機能或語言機能障礙者</option>
      <option value="19" <?php if ($QdisableTypeA==19) echo " selected"; ?>>重要器官失去功能者-心臟</option>
      <option value="20" <?php if ($QdisableTypeA==20) echo " selected"; ?>>重要器官失去功能者-造血機能</option>
      <option value="21" <?php if ($QdisableTypeA==21) echo " selected"; ?>>重要器官失去功能者-呼吸器官</option>
      <option value="22" <?php if ($QdisableTypeA==22) echo " selected"; ?>>重要器官失去功能-吞嚥機能</option>
      <option value="23" <?php if ($QdisableTypeA==23) echo " selected"; ?>>重要器官失去功能-胃</option>
      <option value="24" <?php if ($QdisableTypeA==24) echo " selected"; ?>>重要器官失去功能-腸道</option>
      <option value="25" <?php if ($QdisableTypeA==25) echo " selected"; ?>>重要器官失去功能-肝臟</option>
      <option value="26" <?php if ($QdisableTypeA==26) echo " selected"; ?>>重要器官失去功能-腎臟</option>
      <option value="27" <?php if ($QdisableTypeA==27) echo " selected"; ?>>重要器官失去功能-膀胱</option>
      <option value="28" <?php if ($QdisableTypeA==28) echo " selected"; ?>>肢體障礙者</option>
      <option value="29" <?php if ($QdisableTypeA==29) echo " selected"; ?>>顏面損傷者</option>
      <option value="30" <?php if ($QdisableTypeA==30) echo " selected"; ?>>多重障礙者</option>
      <option value="31" <?php if ($QdisableTypeA==31) echo " selected"; ?>>經中央衛生主管機關認定，因罕見疾病而致身心功能障礙者</option>
      <option value="32" <?php if ($QdisableTypeA==32) echo " selected"; ?>>其他經中央衛生主管機關認定之障礙者(染色體異常、先天代謝異常、先天缺陷)</option>
    </select>
    </div><br />
    <div class="formselect">Category:
    <?php echo checkbox_result("QdisableTypeB","None;Class 1: Nervous system, structural impaired or mentally challenged;Class 2: Eye, ear or related sensors structural impair;Class 3 : Voicing or structure related to speech dysfunction;Class 4 : Circulation, hematopoiesis or immune system dysfunction;Class 5 : Digestion, metabolism and endocrine system dysfunction;Class 6 : Urinary and reproductive system dysfunction;Class 7 : Nuron, muscles and bone motion dysfunction;Class 8 : Skin and related structure dysfunction",$QdisableTypeB,"multi"); ?>
    </select>
    </div><br />
    <div class="formselect" style="margin-left:30px; display:inline;">Severity:
    <select name="QdisableLevel" id="QdisableLevel" disabled="disabled">
      <option value="0" <?php if ($QdisableLevel==0) echo " selected"; ?>>None</option>
      <option value="1" <?php if ($QdisableLevel==1) echo " selected"; ?>>Mild</option>
      <option value="2" <?php if ($QdisableLevel==2) echo " selected"; ?>>Moderate</option>
      <option value="3" <?php if ($QdisableLevel==3) echo " selected"; ?>>Severe</option>
      <option value="4" <?php if ($QdisableLevel==4) echo " selected"; ?>>Extremely severe</option>
    </select>
    </div>
    Validity period:<?php echo $Qdisableexpiry; ?>
    </td>
  </tr>
  <tr>
    <td class="title">Proof of major injury</td>
    <td width="160"><?php echo option_result("QillnessCard","Has;None","s","multi",$QillnessCard,false,5); ?></td>
    <td width="120" class="title">Major injuries</td>
    <td colspan="3"><?php echo $QillnessName; ?></td>
  </tr>
  <tr>
    <td class="title">Admission category</td>
    <td colspan="5"><?php echo option_result("QillnessType","General;Veteran;Middle-low income;Low-income;Other","m","multi",$QillnessType,false,5); ?> <?php echo $QillnessTypeOther; ?><br /><?php echo option_result("QillnessTypeB","Temporary care;Respite Care;Subsidy type","m","multi",$QillnessTypeB,false,5); ?> <?php echo $QillnessTypeBOther; ?></td>
  </tr>
</table>
<hr />
<table width="100%">
  <tr>
    <td colspan="6" class="title">Client (primary contact person)</td>
  </tr>
  <tr>
    <td width="120"  class="title">Full name</td>
    <td><?php echo $QContactPerson1Name; ?></td>
    <td width="120"  class="title">DOB</td>
    <td><?php echo $QContactPerson1Birth; ?></td>
    <td width="120"  class="title">relationship</td>
    <td><?php echo $QContactPerson1Relate; ?></td>
  </tr>
  <tr>
    <td class="title">Serving unit</td>
    <td colspan="3"><?php echo $QContactPerson1Company; ?></td>
    <td class="title">Occupation</td>
    <td><?php echo $QContactPerson1Position; ?></td>
  </tr>
  <tr>
    <td class="title">Phone #(H)</td>
    <td><?php echo $QContactPerson1Tel1; ?></td>
    <td class="title">Phone #(W)</td>
    <td><?php echo $QContactPerson1Tel2; ?></td>
    <td class="title">Cell phone #</td>
    <td><?php echo $QContactPerson1Tel3; ?></td>
  </tr>
  <tr>
    <td class="title">Contact address</td>
    <td colspan="4"><?php echo $QContactPerson1Address; ?></td>
    <td><?php echo option_result("Qreceipt","Mail receipts;Pickup receipts","m","single",$Qreceipt,false,5); ?></td>
  </tr>
  <tr>
    <td class="title">Email</td>
    <td colspan="4"><?php echo $QContactPerson1Email; ?></td>
    <td><?php echo draw_checkbox("Qebill","Electronic incidentals details",$Qebill,"single"); ?></td>
  </tr>
</table>
<hr />
<table width="100%" border="0">
  <tr>
    <td class="title" width="120">Bank Code</td>
    <td width="160" align="left"><input type="text" id="bank" name="bank" maxlength="3" size="3" value="<?php echo $r3['bank'];?>"><a href="Images/banklist.gif" target="_blank">Bank code table</a></td>
    <td class="title" width="120">Remittance account</td>
    <td colspan="3" align="left"><input type="text" id="account" name="account" size="30" value="<?php echo $account;?>"></td>
  </tr>
  <tr>
    <td class="title">Account name</td>
    <td colspan="5" align="left"><input type="text" id="accountName" name="accountName" value="<?php echo $accountName;?>"></td>
  </tr>
  <tr>
    <td class="title">Out-of-pocket</td>
    <td align="left"><input type="text" id="self" name="self" size="7" value="<?php echo $r3['self'];?>" class="validate[required,custom[integer]]"></td>
    <td class="title">Subsidy</td>
    <td width="120" align="left"><input type="text" id="allowance" name="allowance" size="7" value="<?php echo $r3['allowance'];?>" class="validate[required,custom[integer]]"></td>
    <td width="120" class="title">Total monthly fee</td>
    <td width="120" align="left"><input type="text" id="total" name="total" size="7" disabled="disabled"></td>
  </tr>
</table>

<table width="100%">
  <tr>
    <td align="right">Filled by :<?php echo checkusername($_SESSION['ncareID_lwj']); ?></td>
  </tr>
</table>
<br />
<center><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><input type="button" id="back" value="Back to list"><input type="submit" name="submit" id="submit" value="Save" /></center>
</form><br><br>
<script type="text/jscript">
$(function(){
	chktotal();
	$("#self").blur(function(){
		chktotal();
	})
	$("#allowance").blur(function(){
		chktotal();
	})
	$("#back").click(function(){
		location.href='index.php?mod=consump&func=formview&id=17' ;
	})
});
$('#form1').validationEngine();

function chktotal(){
	var self = parseInt($("#self").val());				
	var allowance = parseInt($("#allowance").val());
	if(isNaN(self)){self=0;}
	if(isNaN(allowance)){allowance=0;}
	if((self+allowance)==0){
		$("#total").val("");
	}else{
		$("#total").val(self+allowance);
	}
}
</script>