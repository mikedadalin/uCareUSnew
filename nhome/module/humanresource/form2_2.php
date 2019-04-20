<?php
if ($_GET['empid']!="") {
	$empid = (int) @$_GET['empid'];
} else {
	$empid = "";
}

if (isset($_POST['submit'])) {
	$EmpID = mysql_escape_string($_POST['EmpID']);
	
	//讀寫資料
	$db = new DB;
	$db->query("SELECT * FROM `employer_resume` WHERE `EmpID`='".$EmpID."'");
	if ($db->num_rows()==0) {
		/*== 加 START ==*/
    $rsa = new lwj('lwj/lwj');
    $part = ceil(strlen($_POST['IdNo'])/117);
    if($part>1){
     $datapart = str_split($_POST['IdNo'], 117);
     for($i=0;$i<$part;$i++){
      $puepart = $rsa->pubEncrypt($datapart[$i]);
      $_POST['IdNo'] = $_POST['IdNo'].$puepart." ";
    }
  }else{
   $_POST['IdNo'] = $rsa->pubEncrypt($_POST['IdNo']);
 }
 /*== 加 END ==*/
 $db1 = new DB;
 $db1->query("INSERT INTO `employer_resume` (`EmpID`, `Name`, `Birth`, `IdNo`, `Address`, `Phone1`, `Gender_1`, `Gender_2`) VALUES ('".mysql_escape_string($_POST['EmpID'])."', '".mysql_escape_string($_POST['Name'])."', '".mysql_escape_string($_POST['Birth'])."', '".mysql_escape_string($_POST['IdNo'])."', '".mysql_escape_string($_POST['Address'])."', '".mysql_escape_string($_POST['Phone1'])."', '".mysql_escape_string($_POST['Gender_1'])."', '".mysql_escape_string($_POST['Gender_2'])."');");		
}else{
  /*== 加 START ==*/
  $rsa = new lwj('lwj/lwj');
  $part = ceil(strlen($_POST['IdNo'])/117);
  if($part>1){
   $datapart = str_split($_POST['IdNo'], 117);
   for($i=0;$i<$part;$i++){
    $puepart = $rsa->pubEncrypt($datapart[$i]);
    $_POST['IdNo'] = $_POST['IdNo'].$puepart." ";
  }
}else{
 $_POST['IdNo'] = $rsa->pubEncrypt($_POST['IdNo']);
}
/*== 加 END ==*/
$db1 = new DB;
$db1->query("UPDATE `employer_resume` SET `Name`='".mysql_escape_string($_POST['Name'])."',`Birth`='".mysql_escape_string($_POST['Birth'])."', `IdNo`='".mysql_escape_string($_POST['IdNo'])."', `Address`='".mysql_escape_string($_POST['Address'])."', `Phone1`='".mysql_escape_string($_POST['Phone1'])."', `Gender_1`='".mysql_escape_string($_POST['Gender_1'])."', `Gender_2`='".mysql_escape_string($_POST['Gender_2'])."' WHERE `EmpID`='".$EmpID."';");
}
foreach ($_POST as $k=>$v) {
  if (substr($k,0,1)=="Q") {
    $db2b = new DB;
    $db2b->query("UPDATE `employer_resume` SET `".mysql_escape_string($k)."`='".mysql_escape_string($v)."' WHERE `EmpID`='".$EmpID."' ");
  }
}

echo "<script>window.location.href='index.php?mod=humanresource&func=formview&id=2_2&empid='".$EmpID."'</script>";
}

	//Edit/新增畫面
$db = new DB;
$db->query("SELECT * FROM `employer_resume` WHERE `EmpID`='".mysql_escape_string($empid)."'");
if ($db->num_rows()>0) {
	$tmp=1;
	$r = $db->fetch_assoc();
	foreach ($r as $k=>$v) {
		$arrPatientInfo = explode("_",$k);
   
		if (count($arrPatientInfo)==2) {
			if ($v==1) {
				${$arrPatientInfo[0]} .= $arrPatientInfo[1].';';
			}
		}elseif(count($arrPatientInfo)==3){
			if ($v==1) {
				${$arrPatientInfo[0].$arrPatientInfo[1]} = $arrPatientInfo[2];
			}
		}else {
			${$k} = $v;
		}		
	}
	/*== 解 START ==*/
 $rsa = new lwj('lwj/lwj');
 $puepart = explode(" ",$IdNo);
 $puepartcount = count($puepart);
 if($puepartcount>1){
  for($m=0;$m<$puepartcount;$m++){
    $prdpart = $rsa->privDecrypt($puepart[$m]);
    $IdNo = $IdNo.$prdpart;
  }
}else{
 $IdNo = $rsa->privDecrypt($IdNo);
}
/*== 解 END ==*/
}else{
  $tmp=0;
  $db1 = new DB;
  $db1->query("SELECT * FROM `employer` WHERE `EmpID`='".mysql_escape_string($empid)."'");
  if ($db1->num_rows()>0) {
   $r1 = $db1->fetch_assoc();
   foreach ($r1 as $k=>$v) {
    $arrPatientInfo = explode("_",$k);
    if (count($arrPatientInfo)==2) {
     if ($v==1) {
      ${$arrPatientInfo[0]} = $arrPatientInfo[1];
      
    }
  } else {
   ${$k} = $v;
 }
}
}
/*== 解 START ==*/
$rsa = new lwj('lwj/lwj');
$puepart = explode(" ",$IdNo);
$puepartcount = count($puepart);
if($puepartcount>1){
  for($m=0;$m<$puepartcount;$m++){
    $prdpart = $rsa->privDecrypt($puepart[$m]);
    $IdNo = $IdNo.$prdpart;
  }
}else{
 $IdNo = $rsa->privDecrypt($IdNo);
}
/*== 解 END ==*/
}
?>
<div class="moduleNoTab">
<form  method="post">
  <h3>Resume</h3>
<!--
Employee ID#<?php echo $EmpID; ?><input type="hidden" name="EmpID" id="EmpID" size="12" value="<?php echo $EmpID; ?>" >
-->
<table width="100%" border="0" style="text-align:left;">
  <tr>
    <td class="title">Employee ID#</td>
    <td colspan="5" style="padding-left:5px;"><?php echo $EmpID; ?><input type="hidden" name="EmpID" id="EmpID" size="12" value="<?php echo $EmpID; ?>" ></td>
  </tr>
  <tr>
    <td width="120" class="title">Full name</td>
    <td><input type="text" name="Name" id="Name" size="12" value="<?php echo $Name; ?>" ></td>
    <td width="120" class="title">Gender</td>
    <td><?php echo draw_option("Gender","Male;Female","xs","single",$Gender,false,5); ?></td>
    <td rowspan="5" width="200" align="right">
      <?php if($Photo==''){?>
      <img id="fsjpg" src="Images/noImage.png" width="200"/>
      <?php }else{?>
      <?php echo '<img id="fsjpg" src="emp_pic/'.$_SESSION['nOrgID_lwj'].'/'.$Photo.'" border="0" width="200">'; ?>
      <?php }?><br><input type="button" value="Upload image" onclick="window.open('class/uploadfilesEmp.php?EmpID=<?php echo $EmpID; ?>');" class="printcol"></td>
    </tr>
    <tr>
      <td width="120" class="title">Age</td>
      <td><?php if($tmp==1){echo $Birth;}else{echo calcagenum(formatdatetostring($Birth,"/"));} ?><input type="hidden" name="Birth" id="Birth" value="<?php if($tmp==1){echo $Birth;}else{echo calcagenum(formatdatetostring($Birth,"/"));}?>"></td>
      <td width="120" class="title">Blood type</td>
      <td><input type="text" name="QBlood" id="QBlood" size="12" value="<?php echo $QBlood; ?>" ></td>
    </tr>
    <tr>
      <td width="120" class="title">Birthplace</td>
      <td><input type="text" name="QBirthplace" id="QBirthplace" size="12" value="<?php echo $QBirthplace; ?>"></td>
      <td width="120" class="title">SSN</td>
      <td><input type="text" name="IdNo" id="IdNo" size="12" value="<?php echo $IdNo; ?>"></td>
    </tr>
    <tr>
      <td class="title">Residence address</td>

      <td><input type="text" name="QAddress1" id="QAddress1" size="40" value="<?php echo $QAddress1; ?>" /></td>
      <td class="title">Phone</td>
      <td><input type="text" name="QPhone" id="QPhone" size="12" value="<?php echo $QPhone; ?>"></td>
    </tr>
    <tr>
      <td class="title">Address</td>
      <td><input type="text" name="Address" id="Address" size="40" value="<?php echo $Address; ?>" /></td>
      <td class="title">Phone</td>
      <td><input type="text" name="Phone1" id="Phone1" size="12" value="<?php echo $Phone1; ?>"></td>
    </tr>
  </table>
  <table width="100%" border="0">
    <tr>
      <td rowspan="4" class="title">Education</td>
      <td class="title">School Name</td>
      <td class="title">School Location</td>
      <td class="title">Major</td>
      <td class="title">Admission time</td>
      <td class="title">Graduated time</td>
      <td class="title">Graduated/drop out</td>
      <td class="title">證件是否齊全</td>
      <td class="title">未畢業原因</td>
    </tr>
    <?php
    for ($i=0;$i<3;$i++) {
      ?>
      <tr>
        <td><input type="text" name="QSchoolA_<?php echo $i; ?>" id="QSchoolA_<?php echo $i; ?>" size="12" value="<?php echo $r['QSchoolA_'.$i]; ?>"></td>
        <td><input type="text" name="QSchoolB_<?php echo $i; ?>" id="QSchoolB_<?php echo $i; ?>" size="12" value="<?php echo $r['QSchoolB_'.$i]; ?>"></td>
        <td><input type="text" name="QSchoolC_<?php echo $i; ?>" id="QSchoolC_<?php echo $i; ?>" size="12" value="<?php echo $r['QSchoolC_'.$i]; ?>"></td>
        <td><input type="text" name="QSchoolD_<?php echo $i; ?>" id="QSchoolD_<?php echo $i; ?>" size="6" value="<?php echo $r['QSchoolD_'.$i]; ?>"></td>
        <td><input type="text" name="QSchoolE_<?php echo $i; ?>" id="QSchoolE_<?php echo $i; ?>" size="6" value="<?php echo $r['QSchoolE_'.$i]; ?>"></td>
        <td><?php echo draw_option("QSchoolF_".$i,"Graduated;Drop out","m","single",${'QSchoolF'.$i},false,5); ?></td>
        <td><?php echo draw_option("QSchoolG_".$i,"Yes;No","ss","single",${'QSchoolG'.$i},false,5); ?></td>
        <td><input type="text" name="QSchoolH_<?php echo $i; ?>" id="QSchoolH_<?php echo $i; ?>" size="12" value="<?php echo $r['QSchoolH_'.$i]; ?>"></td>
      </tr>
      <?php
    }
    ?>
  </table>
  <table width="100%" border="0">
    <tr>
      <td rowspan="4" class="title">Experience</td>
      <td class="title">Serviced in</td>
      <td class="title">Job title</td>
      <td class="title">Duty started</td>
      <td class="title">Duty end</td>
      <td class="title">Payment</td>
      <td class="title">Resignation proof</td>
      <td class="title">Reason for Leaving</td>
    </tr>
    <?php
    for ($i=0;$i<3;$i++) {
      ?>
      <tr>
        <td><input type="text" name="QWorkExpA_<?php echo $i; ?>" id="QWorkExpA_<?php echo $i; ?>" size="12" value="<?php echo $r['QWorkExpA_'.$i]; ?>"></td>
        <td><input type="text" name="QWorkExpB_<?php echo $i; ?>" id="QWorkExpB_<?php echo $i; ?>" size="12" value="<?php echo $r['QWorkExpB_'.$i]; ?>"></td>
        <td><input type="text" name="QWorkExpC_<?php echo $i; ?>" id="QWorkExpC_<?php echo $i; ?>" size="12" value="<?php echo $r['QWorkExpC_'.$i]; ?>"></td>
        <td><input type="text" name="QWorkExpD_<?php echo $i; ?>" id="QWorkExpD_<?php echo $i; ?>" size="12" value="<?php echo $r['QWorkExpD_'.$i]; ?>"></td>
        <td><input type="text" name="QWorkExpE_<?php echo $i; ?>" id="QWorkExpE_<?php echo $i; ?>" size="12" value="<?php echo $r['QWorkExpE_'.$i]; ?>"></td>
        <td><?php echo draw_option("QWorkExpF_".$i,"Yes;No","s","single",${'QWorkExpF'.$i},false,5); ?></td>
        <td><input type="text" name="QWorkExpG_<?php echo $i; ?>" id="QWorkExpG_<?php echo $i; ?>" size="12" value="<?php echo $r['QWorkExpG_'.$i]; ?>"></td>
      </tr>
      <?php
    }
    ?>
  </table>
  <table width="100%" border="0" style="text-align:left;">
    <tr>
      <td rowspan="2" class="title">Military service</td>
      <td class="title">Category</td>
      <td><input type="text" name="QMilitaryType" id="QMilitaryType" size="12" value="<?php echo $QMilitaryType; ?>"></td>
      <td class="title">Branch</td>
      <td><input type="text" name="QMilitaryType2" id="QMilitaryType2" size="12" value="<?php echo $QMilitaryType2; ?>"></td>
      <td class="title">Document</td>
      <td><?php echo draw_option("QMilitaryDoc","Has;None","s","single",$QMilitaryDoc,false,5); ?></td>
    </tr>
    <tr>
      <td class="title">Service period</td>
      <td><input type="text" name="QMilitaryDate1" id="QMilitaryDate1" size="12" value="<?php echo $QMilitaryDate1; ?>"> ~ <input type="text" name="QMilitaryDate2" id="QMilitaryDate2" size="12" value="<?php echo $QMilitaryDate2; ?>"></td>
      <td class="title">免役原因</td>
      <td colspan="3"><input type="text" name="QMilitaryReason" id="QMilitaryReason" size="20" value="<?php echo $QMilitaryReason; ?>"></td>
    </tr>
    <tr>
      <td class="title">Physique</td>
      <td class="title">Physical Condition</td>
      <td><input type="text" name="QTherapy" id="QTherapy" size="30" value="<?php echo $QTherapy; ?>"></td>
      <td class="title">Body Weight (lbs)</td>
      <td><input type="text" name="QWeight" id="QWeight" size="6" value="<?php echo $QWeight; ?>"></td>
      <td class="title">Height</td>
      <td><input type="text" name="QHeight" id="QHeight" size="6" value="<?php echo $QHeight; ?>"></td>
    </tr>
    <tr>
      <td rowspan="4" class="title">Other</td>
      <td class="title">Specialty</td>
      <td><input type="text" name="QSpecialist" id="QSpecialist" size="12" value="<?php echo $QSpecialist; ?>"></td>
      <td class="title">Interest</td>
      <td colspan="3"><input type="text" name="QHobby" id="QHobby" size="12" value="<?php echo $QHobby; ?>"></td>
    </tr>
    <tr>
      <td class="title">Professional training</td>
      <td><input type="text" name="QTraining" id="QTraining" size="12" value="<?php echo $QTraining; ?>"></td>
      <td class="title">Driving license</td>
      <td><?php echo draw_option("QCarLicense","Has;None","s","single",$QCarLicense,false,5); ?><br>license</td>
      <td colspan="2"><?php echo draw_option("QCarDriving","Able;Unable","xs","single",$QCarDriving,false,5); ?><br>to drive</td>
    </tr>
    <tr>
      <td class="title">Self-owned</td>
      <td><?php echo draw_option("QVehicle","Car;Motorcycle","m","multi",$QVehicle,false,5); ?></td>
      <td class="title">Motorcycle license</td>
      <td><?php echo draw_option("QBikeLicense","Has;None","s","single",$QBikeLicense,false,5); ?><br>license</td>
      <td colspan="2"><?php echo draw_option("QBikeRiding","Able;Unable","xs","single",$QBikeRiding,false,5); ?><br>to drive</td>
    </tr>    
  </table>
  <table width="100%" border="0">
    <tr>
      <td rowspan="10" class="title">Family status</td>
      <td class="title">Relationship</td>
      <td class="title">Full name</td>
      <td class="title">Age</td>
      <td class="title">Occupation</td>
      <td class="title">Job title</td>
      <td class="title">relationship</td>
    </tr>
    <?php
    for ($i=0;$i<9;$i++) {
      ?>
      <tr>
        <?php
        if ($i==0) {
          echo '<td>Father</td>';
        } elseif ($i==1) {
          echo '<td>Mother</td>';
        } elseif ($i==2) {
          echo '<td rowspan="7">Family <br>member</td>';
        }
        ?>
        <td><input type="text" name="QRelateB_<?php echo $i; ?>" id="QRelateB_<?php echo $i; ?>" size="12" value="<?php echo $r['QRelateB_'.$i]; ?>"></td>
        <td><input type="text" name="QRelateC_<?php echo $i; ?>" id="QRelateC_<?php echo $i; ?>" size="12" value="<?php echo $r['QRelateC_'.$i]; ?>"></td>
        <td><input type="text" name="QRelateD_<?php echo $i; ?>" id="QRelateD_<?php echo $i; ?>" size="12" value="<?php echo $r['QRelateD_'.$i]; ?>"></td>
        <td><input type="text" name="QRelateE_<?php echo $i; ?>" id="QRelateE_<?php echo $i; ?>" size="12" value="<?php echo $r['QRelateE_'.$i]; ?>"></td>
        <td><input type="text" name="QRelateF_<?php echo $i; ?>" id="QRelateF_<?php echo $i; ?>" size="12" value="<?php echo $r['QRelateF_'.$i]; ?>"></td>
      </tr>
      <?php
    }
    ?>
  </table>
  <table width="100%" border="0" style="text-align:left;">
    <tr>
      <td class="title" width="120">Marital status</td>
      <td align="center"><?php echo draw_option("QMarried","Married;Single","xs","single",$QMarried,false,5); ?></td>
      <td class="title" width="120">Offspring</td>
      <td align="center">Male<input type="text" name="QChildM" id="QChildM" size="2" value="<?php echo $QChildM; ?>">  Female<input type="text" name="QChildF" id="QChildF" size="2" value="<?php echo $QChildF; ?>"> </td>
    </tr>
    <tr>
      <td class="title" width="120">Preferred Language</td>
      <td colspan="3"><?php echo draw_option("Qlang","English;Spanish;Chinese;French;Other","m","multi",$Qlang,false,5); ?> <input type="text" name="QlangOther" id="QlangOther" size="24" value="<?php echo $QlangOther; ?>"></td>
    </tr>
    <tr>
      <td class="title" width="120">Religion</td>
      <td colspan="3"><?php echo draw_option("Qreligion","None;Buddhism;Taoism;Christian;Catholicism;Other","m","multi",$Qreligion,false,5); ?> <input type="text" name="QreligionOther" id="QreligionOther" size="14" value="<?php echo $QreligionOther; ?>"></td>
    </tr>
  </table>


  <br />
  <center>
    <input type="hidden" name="formID" id="formID" value="employer_resume" />
    <input type="hidden" name="employeeID" id="employeeID" value="<?php echo $employeeID; ?>" />
    <input type="submit" name="submit" id="submit" value="Save" />
  </center>
</div>
</form>
</div>