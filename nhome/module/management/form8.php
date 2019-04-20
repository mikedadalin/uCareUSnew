<h3>System setting</h3>
<?php
if (isset($_POST['submit'])) {
	array_pop($_POST);
	foreach ($_POST as $k1=>$v1) {
		if ($k1=="backupPassword") {
			if ($v1!="") {
				$bkuppwd = md5($v1);
				$dbu = new DB2;
				$dbu->query("UPDATE `system_setting` SET `".$k1."`='".$bkuppwd."' WHERE `OrgID`='".$_SESSION['nOrgID_lwj']."'");
			}
		} else {
			$dbu = new DB2;
			$dbu->query("UPDATE `system_setting` SET `".$k1."`='".$v1."' WHERE `OrgID`='".$_SESSION['nOrgID_lwj']."'");
		}
	}
	echo '
	<script>
	$(function() {
		var $dialog = $(\'<div title="UCare message" class="dialog-form"><table width="100%"><tr><td class="title">Save successfully</td></tr></table></div>\').dialog({
			buttons: [{
				text: "Confirm",
				click: function(){ $dialog.remove(); }
			}]
		});
});
</script>';
}
$db1 = new DB2;
$db1->query("SELECT * FROM `system_setting` WHERE `OrgID`='".$_SESSION['nOrgID_lwj']."'");
$r1 = $db1->fetch_assoc();
?>
<form method="post">
  <table style="width:100%;">
    <tr>
      <td colspan="3" class="title">Center's Basic Information</td>
    </tr>
    <tr>
      <td class="title_s" width="120">Name</td>
      <td colspan="2" align="left"><input type="text" name="orgTitle" id="orgTitle" size="30" value="<?php echo $r1['orgTitle']; ?>"></td>
    </tr>
    <tr>
      <td class="title_s" width="120">Person in charge</td>
      <td colspan="2" align="left"><input type="text" name="orgPerson" id="orgPerson" size="10" value="<?php echo $r1['orgPerson']; ?>"></td>
    </tr>
    <tr>
      <td class="title_s" width="120">Address</td>
      <td colspan="2" align="left"><input type="text" name="orgAddress" id="orgAddress" size="60" value="<?php echo $r1['orgAddress']; ?>"></td>
    </tr>
    <tr>
      <td class="title_s" width="120">Phone</td>
      <td colspan="2" align="left"><input type="text" name="orgTel" id="orgTel" size="20" value="<?php echo $r1['orgTel']; ?>"></td>
    </tr>
    <tr>
      <td class="title_s" width="120">Tax ID/ EIN</td>
      <td colspan="2" align="left"><input type="text" name="orgGovNo" id="orgGovNo" size="30" value="<?php echo $r1['orgGovNo']; ?>"></td>
    </tr>
    <tr>
      <td class="title_s" width="120">National Provider Identifier (NPI)</td>
      <td colspan="2" align="left"><input type="text" name="NPI" id="NPI" size="30" value="<?php echo $r1['NPI']; ?>"></td>
    </tr>
    <tr>
      <td class="title_s" width="120">CMS Certification Nember (CCN)</td>
      <td colspan="2" align="left"><input type="text" name="CCN" id="CCN" size="30" value="<?php echo $r1['CCN']; ?>"></td>
    </tr>
    <tr>
      <td class="title_s" width="120">State Provider Number</td>
      <td colspan="2" align="left"><input type="text" name="SPN" id="SPN" size="30" value="<?php echo $r1['SPN']; ?>"></td>
    </tr>
    <tr>
      <td class="title_s" width="120">Unit Certification or <br>Licensure Designation</td>
      <td colspan="2" align="left">
       <div class="formselect" style="display:inline;">
        <select name="Licensure" id="Licensure">
          <option></option>
          <option value="1" <?php if ($Licensure==1) echo " selected"; ?>>Unit is neither Medicare nor Medicaid certified and MDS data is not required by the State</option>
          <option value="2" <?php if ($Licensure==2) echo " selected"; ?>>Unit is neither Medicare nor Medicaid certified but MDS data is required by the State</option>
          <option value="3" <?php if ($Licensure==3) echo " selected"; ?>>Unit is Medicare and/or Medicaid certified</option>
        </select>
      </div>
    </td>
  </tr>
  <tr>
    <td class="title_s" width="120">Inventory close date</td>
    <td colspan="2" align="left">
      <select name="cSTKdate" id="cSTKdate">
        <option></option>
        <?php
        for ($i1=0;$i1<=27;$i1++) {
          if ($i1==0) {
           echo '<option value="'.$i1.'" '.($r1['cSTKdate']==$i1?"selected":"").'>End of month</option>';
         } else {
           echo '<option value="'.$i1.'" '.($r1['cSTKdate']==$i1?"selected":"").'>'.$i1.'</option>';
         }
       }
       ?>
     </select>
   </td>
 </tr>
 <tr>
  <td class="title_s" width="120">Pressure ulcer indicator calculate date</td>
  <td colspan="2" align="left">
    <select name="sixtarget_part4_day" id="sixtarget_part4_day">
      <option></option>
      <?php
      for ($i1=0;$i1<=27;$i1++) {
        if ($i1==0) {
         echo '<option value="'.$i1.'" '.($r1['sixtarget_part4_day']==$i1?"selected":"").'>End of month</option>';
       } else {
         echo '<option value="'.$i1.'" '.($r1['sixtarget_part4_day']==$i1?"selected":"").'>'.$i1.'</option>';
       }
     }
     ?>
   </select>
 </td>
</tr>
<tr>
  <td class="title_s" width="120" style="padding:5px;">Days of reminding before the food ingredients expire</td>
  <td colspan="2" align="left">
    <input name="ExpireDate1" id="ExpireDate1" value="<?php echo $r1['ExpireDate1']; ?>" max="99" min="0" size="4">
    <font size="2"><a href="#" title="Reminder leading days before food ingredients expire">(Description)</a></font>
  </td>
</tr>
<tr>
  <td class="title_s" width="120">Days of reminding before the supply expire</td>
  <td colspan="2" align="left">
    <input name="ExpireDate2" id="ExpireDate2" value="<?php echo $r1['ExpireDate2']; ?>" max="99" min="0" size="4">
    <font size="2"><a href="#" title="Reminder leading days before supplies expire">(Description)</a></font>
  </td>
</tr>
<tr>
  <td class="title_s" width="120">Care ID length</td>
  <td colspan="2" align="left">
    <input name="HospNoLength" id="HospNoLength" value="<?php echo $r1['HospNoLength']; ?>" max="99" min="0" size="4">
    <font size="2"><a href="#" title="System auto-assign care ID# length, 0 meas no restriction and the default setting is 6 digits.">(Description)</a></font>
  </td>
</tr>
<tr>
  <td class="title_s" width="120">Data backup password setting</td>
  <td colspan="2" align="left">
    <input type="password" name="backupPassword" id="backupPassword" size="20" placeholder="<?php if ($r1['backupPassword']!="") { echo 'Set'; } ?>">
    <font size="2"><a href="#" title="Data backup password">(Description)</a></font>
  </td>
</tr>
<tr>
  <td colspan="3" class="title">Paperwork Title Setting</td>
</tr>
<tr>
  <td class="title_s" width="120">Serial number setting</td>
  <td colspan="2" align="left"><input type="text" name="HRFormNo" id="HRFormNo" value="<?php echo $r1['HRFormNo']; ?>" size="20" ></td>
</tr>
<tr>
  <td class="title_s" width="120">Resignation proof/certification</td>
  <td colspan="2" align="left"><input type="text" name="HRFormNo1" id="HRFormNo1" value="<?php echo $r1['HRFormNo1']; ?>" size="20" > Use {N} on behalf of the serial number</td>
</tr>
<tr>
  <td class="title_s" width="120">Served certificate</td>
  <td colspan="2" align="left"><input type="text" name="HRFormNo2" id="HRFormNo2" value="<?php echo $r1['HRFormNo2']; ?>" size="20" > Use {N} on behalf of the serial number</td>
</tr>
<tr>
  <td class="title_s" width="120">Certificate of employment</td>
  <td colspan="2" align="left"><input type="text" name="HRFormNo3" id="HRFormNo3" value="<?php echo $r1['HRFormNo3']; ?>" size="20" > Use {N} on behalf of the serial number</td>
</tr>
<tr>
  <td class="title_s" width="120">Resignation application</td>
  <td colspan="2" align="left"><input type="text" name="HRFormNo4" id="HRFormNo4" value="<?php echo $r1['HRFormNo4']; ?>" size="20" > Use {N} on behalf of the serial number</td>
</tr>
<tr>
  <td colspan="3" class="title">Hospital Setting</td>
</tr>
<tr>
  <td valign="top">
    <ol>
      <?php
      for ($i1=1;$i1<=7;$i1++) {
       ?>
       <li><input type="text" name="Hosp<?php echo $i1; ?>" id="Hosp<?php echo $i1; ?>" size="30" value="<?php echo $r1['Hosp'.$i1]; ?>"></li>
       <?php
     }
     ?>
   </ol>
 </td>
 <td valign="top">
  <ol start="8">
    <?php
    for ($i2=8;$i2<=14;$i2++) {
     ?>
     <li><input type="text" name="Hosp<?php echo $i2; ?>" id="Hosp<?php echo $i2; ?>" size="30" value="<?php echo $r1['Hosp'.$i2]; ?>"></li>
     <?php
   }
   ?>
 </ol>
</td>
<td valign="top">
  <ol start="15">
    <?php
    for ($i3=15;$i3<=20;$i3++) {
     ?>
     <li><input type="text" name="Hosp<?php echo $i3; ?>" id="Hosp<?php echo $i3; ?>" size="30" value="<?php echo $r1['Hosp'.$i3]; ?>"></li>
     <?php
   }
   ?>
 </ol>
</td>
</tr>
<tr>
  <td colspan="3" class="title">Functional Setting</td>
</tr>
<tr>
  <td class="title_s" width="120" style="padding:5px;">Resident contact personnel number</td>
  <td colspan="2" align="left">
    <input name="ContactPersonNo" id="ContactPersonNo" value="<?php echo $r1['ContactPersonNo']; ?>" max="3" min="1" size="4">
    <font size="2"><a href="#" title="Adjust the contact personnel number in resident's profile,minimum is 1, maximum is 3">(Description)</a></font>
  </td>
</tr>
<tr>
  <td class="title_s" width="120" style="padding:5px;">Blood glucose substitute into nursing record</td>
  <td colspan="2" align="left">
    <div id="format1" style="display:inline;">
      <input type="radio" name="glucoseRecord" id="glucoseRecord1" value="1" <?php echo ($r1['glucoseRecord']=="1"?"checked":""); ?>><label for="glucoseRecord1">Yes</label>
      <input type="radio" name="glucoseRecord" id="glucoseRecord0" value="0" <?php echo ($r1['glucoseRecord']=="0" || $r1['glucoseRecord']==""?"checked":""); ?>><label for="glucoseRecord0">None</label>
    </div>
    <font size="2"><a href="#" title="Select Yes to automatically fill the blood glucose value into the nursing record">(Description)</a></font>
  </td>
</tr>
<tr>
  <td class="title_s" width="120" style="padding:5px;">Pipeline replacement operation substitute into nursing record</td>
  <td colspan="2" align="left">
    <div id="format2" style="display:inline;">
      <input type="radio" name="foleyRecord" id="foleyRecord1" value="1" <?php echo ($r1['foleyRecord']=="1"?"checked":""); ?>><label for="foleyRecord1">Yes</label>
      <input type="radio" name="foleyRecord" id="foleyRecord0" value="0" <?php echo ($r1['foleyRecord']=="0" || $r1['foleyRecord']==""?"checked":""); ?>><label for="foleyRecord0">None</label>
    </div>
    <font size="2"><a href="#" title="Select Yes to allow system automatically fill pipeline management information into nursing reocrds">(Description)</a></font>
  </td>
</tr>
<tr>
  <td class="title_s" width="120">IP Control</td>
  <td colspan="2" align="left">
    <div id="format3" style="display:inline;">
      <input type="radio" name="allowNotInCompany" id="allowNotInCompany0" value="0" <?php echo ($r1['allowNotInCompany']=="0" || $r1['allowNotInCompany']==""?"checked":""); ?>><label for="allowNotInCompany0">Yes</label>
      <input type="radio" name="allowNotInCompany" id="allowNotInCompany1" value="1" <?php echo ($r1['allowNotInCompany']=="1"?"checked":""); ?>><label for="allowNotInCompany1">None</label>
    </div>
    <font size="2"><a href="#" title="Select Yes to disable access of the system outside of the facility(center)">(Description)</a></font>
  </td>
</tr>
<tr>
  <td class="title_s" width="120" style="padding:5px;">Automatic calculation the number of people daily</td>
  <td colspan="2" align="left">
    <div id="format3" style="display:inline;">
      <input type="radio" name="autoPatNo" id="autoPatNo1" value="1" <?php echo ($r1['autoPatNo']=="1"?"checked":""); ?>><label for="autoPatNo1">Yes</label>
      <input type="radio" name="autoPatNo" id="autoPatNo0" value="0" <?php echo ($r1['autoPatNo']=="0" || $r1['autoPatNo']==""?"checked":""); ?>><label for="autoPatNo0">None</label>
    </div>
    <font size="2"><a href="#" title="Select Yes to allow system log the number of people daily">(Description)</a></font>
  </td>
</tr>
<tr>
  <td class="title_s" width="120">Canned phrases function</td>
  <td colspan="2" align="left">
    <div id="format3" style="display:inline;">
      <input type="radio" name="CanText" id="CanText1" value="1" <?php echo ($r1['CanText']=="1"?"checked":""); ?>><label for="CanText1">Yes</label>
      <input type="radio" name="CanText" id="CanText0" value="0" <?php echo ($r1['CanText']=="0" || $r1['CanText']==""?"checked":""); ?>><label for="CanText0">None</label>
    </div>
    <font size="2"><a href="#" title="Select Yes to enable canned phrases">(Description)</a></font>
  </td>
</tr>
<!--
<tr>
  <td class="title_s" width="120" style="padding:5px;">Insulin injection body part(s) image</td>
  <td colspan="2">
    <div style="background:#fff; display:inline-block; margin:10px; padding:10px;"><input type="radio" name="InsulinImage" id="InsulinImage1" value="1" <?php echo ($r1['InsulinImage']=="1"?"checked":""); ?>><label for="InsulinImage1"><a href="module/nurseform/img/pic2.png" data-lightbox="lightbox1"><img src="module/nurseform/img/pic2.png" height="120"></a></label></div>
    <div style="background:#fff; display:inline-block; margin:10px; padding:10px;"><input type="radio" name="InsulinImage" id="InsulinImage2" value="2" <?php echo ($r1['InsulinImage']=="2"?"checked":""); ?>><label for="InsulinImage2"><a href="module/nurseform/img/pic2a.png" data-lightbox="lightbox1"><img src="module/nurseform/img/pic2a.png" height="120"></a></label></div><br>
    <div style="background:#fff; display:inline-block; margin:10px; padding:10px;"><input type="radio" name="InsulinImage" id="InsulinImage3" value="3" <?php echo ($r1['InsulinImage']=="3"?"checked":""); ?>><label for="InsulinImage3"><a href="module/nurseform/img/pic2b.png" data-lightbox="lightbox1"><img src="module/nurseform/img/pic2b.png" height="120"></a></label></div>
    <div style="background:#fff; display:inline-block; margin:10px; padding:10px;"><input type="radio" name="InsulinImage" id="InsulinImage4" value="4" <?php echo ($r1['InsulinImage']=="4"?"checked":""); ?>><label for="InsulinImage4"><a href="module/nurseform/img/pic2c.png" data-lightbox="lightbox1"><img src="module/nurseform/img/pic2c.png" height="120"></a></label></div>
  </td>
</tr>
<tr>
  <td class="title_s" width="120">Medication note print format</td>
  <td colspan="2">
    <div style="background:#fff; display:inline-block; margin:10px; padding:10px;"><input type="radio" name="medFormat" id="medFormat2" value="2" <?php echo ($r1['medFormat']=="2" || $r1['medFormat']==""?"checked":""); ?>><label for="medFormat2">Basic form<br><a href="module/nurseform/img/med2.jpg" data-lightbox="lightbox2"><img src="module/nurseform/img/med2.jpg" width="180"></a></label></div>
    <div style="background:#fff; display:inline-block; margin:10px; padding:10px;"><input type="radio" name="medFormat" id="medFormat3" value="3" <?php echo ($r1['medFormat']=="3"?"checked":""); ?>><label for="medFormat3">Include staff signature<br><a href="module/nurseform/img/med3.jpg" data-lightbox="lightbox2"><img src="module/nurseform/img/med3.jpg" width="180"></a></label></div>
    <div style="background:#fff; display:inline-block; margin:10px; padding:10px;"><input type="radio" name="medFormat" id="medFormat1" value="1" <?php echo ($r1['medFormat']=="1"?"checked":""); ?>><label for="medFormat1">Include signature and I/O status<br><a href="module/nurseform/img/med1.jpg" data-lightbox="lightbox2"><img src="module/nurseform/img/med1.jpg" width="180"></a></label></div>
    <div style="background:#fff; display:inline-block; margin:10px; padding:10px;"><input type="radio" name="medFormat" id="medFormat4" value="4" <?php echo ($r1['medFormat']=="4"?"checked":""); ?>><label for="medFormat4">Include source, effects<br><a href="module/nurseform/img/med4.jpg" data-lightbox="lightbox2"><img src="module/nurseform/img/med4.jpg" width="180"></a></label></div>
    <div style="background:#fff; display:inline-block; margin:10px; padding:10px;"><input type="radio" name="medFormat" id="medFormat5" value="5" <?php echo ($r1['medFormat']=="5"?"checked":""); ?>><label for="medFormat5">Include source,<br> effects(2 shifts mode)<br><a href="module/nurseform/img/med5.png" data-lightbox="lightbox2"><img src="module/nurseform/img/med5.png" width="180"></a></label></div>
    <div style="background:#fff; display:inline-block; margin:10px; padding:10px;"><input type="radio" name="medFormat" id="medFormat6" value="6" <?php echo ($r1['medFormat']=="6"?"checked":""); ?>><label for="medFormat6">Include source, <br>effects,powder and allergy medication<br><a href="module/nurseform/img/med6.png" data-lightbox="lightbox2"><img src="module/nurseform/img/med6.png" width="180"></a></label></div>
    <div style="background:#fff; display:inline-block; margin:10px; padding:10px;"><input type="radio" name="medFormat" id="medFormat7" value="7" <?php echo ($r1['medFormat']=="7"?"checked":""); ?>><label for="medFormat7">Include source, <br>effects,powder and allergy medication (3 shifts signature)<br><a href="module/nurseform/img/med7.png" data-lightbox="lightbox2"><img src="module/nurseform/img/med7.png" width="180"></a></label></div>
  </td>
</tr>
-->
</table>
<div style="text-align:center; margin-top:30px;">
  <input type="submit" name="submit" value="Save">
</div>
</form>
<style>
.ui-tooltip {
	max-width: 600px;
}
</style>
<script>
$(function() {
	$(document).tooltip();
	$('div[id^=format]').buttonset();
	$('#ContactPersonNo').spinner();
	$('#HospNoLength').spinner();
	$('#ExpireDate1').spinner();
	$('#ExpireDate2').spinner();
});
</script>