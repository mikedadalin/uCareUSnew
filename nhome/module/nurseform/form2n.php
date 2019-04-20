<?php
if(@$_GET['no']!='' || $_GET['date']!=''){
  if (@$_GET['no']!='') {
	  $sql = "SELECT * FROM `nurseform02n` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `no`='".(int)$_GET['no']."' ORDER BY `date` DESC LIMIT 0,1";
  }
  if (@$_GET['date']!='') {
	  $arrVar1 = explode("_",$_GET['date']);
	  $sql = "SELECT * FROM `nurseform02n` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`='".mysql_escape_string($arrVar1[0])."' AND `no`='".mysql_escape_string($arrVar1[1])."'";
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
}
?>
<form  method="post" onSubmit="return checkForm();" action="index.php?func=databaseAI">
<h3>Ulcers / Wounds / Skin Problems Care Records</h3>
<table width="100%">
  <tr>
    <td class="title" width="120">Part</td>
    <td>
	  <!--<input type="text" name="Q1" id="Q1" size="35" value="<?php echo $Q1; ?>">-->
	  <?php echo draw_option("Q1","Forehead;Nose;Chin;Outer ear;Occipital;Breast;Chest;Rib cage;Costal arch;Scapula;Humerus;Elbow;Abdomen;Spine protruding spot;Scrotum;Perineum;Sacral vertebrae;Buttock;Hip ridge;Ischial tuberosity;Front knee;Medial knee;Fibula;Lateral ankle;Inner ankle;Heel;Toe;Plantar;Intertrochanteric;Other","l","multi",$Q1,true,5); ?>
	</td>
  </tr>
  <tr>
  <td class="title">Produced date</td>
    <td><script> $(function() { $( "#Q2").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><p align="left"><input type="text" id="Q2" name="Q2" value="<?php if ($Q2==NULL) { echo date('Y/m/d'); } else { echo $Q2; } ?>" size="12" /></p></td>
  </tr>
  <tr>
    <td class="title">Type</td>
    <td colspan="2"><?php echo draw_option("Qtype","General;Surgical wound;Ulcers;Diabetic foot ulcer;Skin tear;MASD;Burn","l","single",$Qtype,true,4); ?></td>
  </tr>
  <tr>
    <td class="title">Wound size</td>
    <td colspan="2">(Length)<input type="text" name="Q3" value="<?php echo $Q3; ?>" size="2"/> X (Width) <input type="text" name="Q4" size="2" value="<?php echo $Q4; ?>"/> X (Depth)<input type="text" name="Q5" size="2" value="<?php echo $Q5; ?>"/>cm</td>
  </tr>
  <tr>
    <td class="title">Exudate amount</td>
    <td colspan="2"><?php echo draw_option("Q6","None;Micro;Little;Medium;Large","xs","single",$Q6,false,5); ?></td>
  </tr>
  <tr>
    <td class="title">Exudate texture</td>
    <td colspan="2"><?php echo draw_option("Q7","Watery;Pus-like;Bloody ;Bloody and Purulent;Other","l","multi",$Q7,true,3); ?>：<input type="text" name="Q7a" value="<?php echo $Q7a; ?>"/></td>
  </tr>
  <tr>
    <td class="title">Exudate color</td>
    <td colspan="2"><?php echo draw_option("Q8","Transparent;Pink;Reddish;Yellow;Green;Chartreuse;Black;Other","m","multi",$Q8,true,5); ?>：<input type="text" name="Q8a" value="<?php echo $Q8a; ?>"/></td>
  </tr>
  <tr>
    <td class="title">Exudate odor</td>
    <td colspan="2"><?php echo draw_option("Q9","None;Has;Description","m","multi",$Q9,false,5); ?>：<input type="text" name="Q9a" value="<?php echo $Q9a; ?>"/></td>
  </tr>
  <tr>
    <td class="title">Status</td>
    <td colspan="2"><?php echo draw_option("Q10","Normal;Reddish;Edema;infiltration;Excoriation;Eczema;Blister;Pustule;Desquamation;Bruising;Turn black;Pigmentation disorders;Dry Skin;Scleroma;First degree burn;Second degree burn;Third degree burn;Fourth degree burn;Venous Ulcers;Arterial Ulcers","xl","multi",$Q10,true,4); ?></td>
  </tr>
  <tr>
    <td class="title">Care treatment</td>
    <td colspan="2"><?php echo draw_checkbox("Q16","Pressure reducing device for chair;Pressure reducing device for bed;Turning/repositioning program;Nutrition or hydration intervention to manage skin problems;Ulcer care;Surgical wound care;Application of nonsurgical dressings (with or without topical medications) other than to feet;Applications of ointments/medications other than to feet;Application of dressings to feet (with or without topical medications);Maintain skin cleansing",$Q16,"multi"); ?></td>
  </tr>
  <tr>
    <td class="title">Wound dressing change</td>
    <td colspan="2"><?php echo draw_checkbox_2col("Q11","Burn ointments;Neomycin;Betadine-soaked gauze;Hydrocolloid dressing;Vaseline gauze;Wet dressing;Wound cleansing;Other (please specify the dressing and number of wound) :<input type=\"text\" name=\"Q11a\" id=\"Q11a\" size=\"30\" value=\"".$Q11a."\">",$Q11,"multi"); ?></td>
  </tr>
  <tr>
    <td class="title">Frequency of<br> changing dressing</td>
    <td colspan="2"><input type="text" name="Q12a" id="Q12a" size="1" value="<?php echo $Q12a; ?>">Day(s)<input type="text" name="Q13b" id="Q13b" size="1" value="<?php echo $Q13b; ?>">Time(s)</td>
  </tr>
  <tr>
    <td class="title">Wound healing</td>
    <td colspan="2"><?php echo draw_option("Q14","Healed;Not healed","m","single",$Q14,false,5); ?></td>
  </tr>
  <tr>
    <td class="title">Healed date</td>
    <td colspan="2"><script> $(function() { $( "#Q15").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" id="Q15" name="Q15" value="<?php if ($Q15!=NULL) { echo $Q15; } ?>" size="12" /> <input type="button" value="Today" onclick="$('#Q15').val('<?php echo date("Y/m/d"); ?>')"></td>
  </tr>
  <tr>
    <td colspan="2"><?php if ($_GET['date']!="" && $act == "") { $act = "edit"; } elseif ($_GET['date']!="" && $act != "") { $act = "view"; } else { $act = "new"; }?></td>
  </tr> 
</table>
<table width="100%">
  <tr>
	<td>Filled date：<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if($_GET['newDate']!="") { echo formatdate($_GET['newDate']); } else { if ($date != NULL) { echo formatdate($date); } } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" /></td>
    <td align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>

  </tr>
</table>
<center>
<?php 
if($_GET['no']=="" || $_GET['no']==NULL){
  $db4 = new DB;
  $db4->query("SELECT `no` FROM `nurseform02n` WHERE `HospNo`='".$HospNo."' ORDER BY `no` DESC");
  $r4 = $db4->fetch_assoc();
  if ($db4->num_rows()>0) {
      $newon = $r4['no']+1;
  }else{
	  $newon = 1;
  }
}
?>
<input type="hidden" name="no" id="no" value="<?php if($_GET['no']!="" && $_GET['no']!=NULL){ echo $_GET['no'];}else{ echo $newon;} ?>" />
<input type="hidden" name="formID" id="formID" value="nurseform02n" />
<input type="hidden" name="nID" id="nID" value="<?php echo $nID; ?>" />
<input type="hidden" name="action" id="action" value="<?php echo $act; ?>" />
<input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></center>

</form>
<br><br>
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