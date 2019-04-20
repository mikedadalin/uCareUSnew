<?php
if(@$_GET['no']!='' || $_GET['date']!=''){
  if (@$_GET['no']!='') {
    $sql = "SELECT * FROM `nurseform02g_2` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `no`='".(int)$_GET['no']."' ORDER BY `date` DESC LIMIT 0,1";
  }
  if (@$_GET['date']!='') {
    $arrVar1 = explode("_",$_GET['date']);
    $sql = "SELECT * FROM `nurseform02g_2` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`='".mysql_escape_string($arrVar1[0])."' AND `no`='".mysql_escape_string($arrVar1[1])."'";
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
<form  method="post" onSubmit="return checkThisForm();" action="index.php?mod=nurseform&func=nurseform2g2save" enctype="multipart/form-data">
<h3><?php if($_GET[no]!="" && $_GET[no]!=NULL){echo '&nbsp&nbsp<b>No.'.$no.'</b>&nbsp&nbsp&nbsp';}?>Pressure ulcer care record</h3>
<?php
$div1display = "block";
if ($Q0==1) {
  $div1display = "block";
  $div2display = "none";
} elseif ($Q0==2) {
  $div2display = "block";
  $div1display = "none";
}
?>
<div id="div0_1" style="display:<?php echo $div1display; ?>">
<table width="100%">
  <tr>
    <td class="title" width="120">Included in the statistics?</td>
    <td><?php if($Q28==NULL){$Q28=1;} echo draw_option("Q28","Yes;No","s","single",$Q28,false,5); ?></td>
  </tr>
  <tr>
    <td class="title" width="120">Pressure sores location/body part(s)</td>
    <td>
      <?php echo draw_option("Q2","Forehead;Nose;Chin;Outer ear;Occipital;Breast;Chest;Rib cage;Costal arch;Scapula;Humerus;Elbow;Abdomen;Spine protruding spot;Scrotum;Perineum;Sacral vertebrae;Buttock;Hip ridge;Ischial tuberosity;Front knee;Medial knee;Fibula;Lateral ankle;Inner ankle;Heel;Toe;Plantar;Intertrochanteric;Other","l","multi",$Q2,true,5); ?>
    </td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td class="title" width="120">Pressure ulcer(s) stage</td>
    <td colspan="2">
      <?php echo draw_checkbox("Q4","<b>Stage 1</b><br>Intact skin with non-blanchable redness of a localized area usually over a bony prominence.Darkly pigmented skin may not have a visible blanching, in dark skin tones only it may appear with persistent blue or purple hues.;<b>Stage 2</b><br>Partial thickness loss of dermis presenting as a shallow open ulcer with a red or pink wound bed, without slough.  May also present as an intact or open/ruptured blister.;<b>Stage 3</b><br>Full thickness tissue loss.  Subcutaneous fat may be visible but bone, tendon or muscle is not exposed.  Slough may be present but does not obscure the depth of tissue loss.  May include undermining and tunneling.<br>;<b>Stage 4</b><br>Full thickness tissue loss with exposed bone, tendon or muscle.  Slough or eschar may be present on some parts of the wound bed.  Often includes undermining and tunneling.;<b>Unstageable - Non-removable dressing</b><br>Known but not stageable due to non-removable dressing/device;<b>Unstageable - Slough and/or eschar</b><br>Known but not stageable due to coverage of wound bed by slough and/or eschar;<b>Unstageable - Deep tissue</b><br>Suspected deep tissue injury in evolution",$Q4,"single"); ?>
    </td>
  </tr>
  <tr>
    <td rowspan="3" class="title">Pressure ulcer source</td>
    <td class="title_s">Produced location </td>
    <td><?php echo draw_option("Q6","Own home;Hospital;This facility;Other facility","m","single",$Q6,false,5); ?></td> <!---->
    </tr>
  <tr>
    <td class="title_s">Produced date</td>
    <td><script> $(function() { $( "#Q7").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><p align="left"><input type="text" id="Q7" name="Q7" value="<?php if ($Q7==NULL) { echo date('Y/m/d'); } else { echo $Q7; } ?>" size="12" /></p></td>
  </tr>
  <tr>
    <td class="title_s">Medical device related?</td>
    <td><?php echo draw_option("Q8","Yes;No","m","single",$Q8,false,5); ?></td>
  </tr>
</table>
<!--</div>
<div id="div0_2" style="display:<?php //echo $div2display; ?>">-->
<!--<script>
-->
<table>
  <tr>
    <td class="title">Wound size</td>
    <td colspan="2">
    (Length)<input type="text" name="Q9" value="<?php echo $Q9; ?>" size="2"/> X (Width) <input type="text" name="Q10" size="2" value="<?php echo $Q10; ?>"/> X (Depth)<input type="text" name="Q11" size="2" value="<?php echo $Q11; ?>"/>cm<br>
    <div style="line-height:80px;">tunneling <div id="control" style="display:inline-block;"></div>，<input type="text" name="Q11a" value="<?php echo $Q11a; ?>" size="2"/>cm<input type="hidden" name="Qdeg" id="Qdeg" value="<?php echo $Qdeg; ?>">&nbsp;&nbsp;&nbsp;<div id="control2" style="display:inline-block;"></div>，<input type="text" name="Q11b" value="<?php echo $Q11b; ?>" size="2"/>cm<input type="hidden" name="Qdeg2" id="Qdeg2" value="<?php echo $Qdeg2; ?>">&nbsp;&nbsp;&nbsp;<div id="control3" style="display:inline-block;"></div>，<input type="text" name="Q11c" value="<?php echo $Q11c; ?>" size="2"/>cm<input type="hidden" name="Qdeg3" id="Qdeg3" value="<?php echo $Qdeg3; ?>"></div>
    </td>
  </tr>
  <tr>
    <td class="title">Exudate amount</td>
    <td colspan="2"><?php echo draw_option("Q12","None;Micro;Little;Medium;Large","m","single",$Q12,false,5); ?></td>
  </tr>
  <tr>
    <td class="title">Exudate texture</td>
    <td colspan="2"><?php echo draw_option("Q13","Watery;Pus-like;Bloody ;Bloody and Purulent;Other","l","multi",$Q13,true,3); ?>：<input type="text" name="Q13a" value="<?php echo $Q13a; ?>"/></td>
  </tr>
  <tr>
    <td class="title">Exudate color</td>
    <td colspan="2"><?php echo draw_option("Q14","Transparent;Pink;Reddish;Yellow;Green;Chartreuse;Black;Other","xm","multi",$Q14,true,5); ?>：<input type="text" name="Q14a" value="<?php echo $Q14a; ?>"/></td>
  </tr>
  <tr>
    <td class="title">Exudate odor</td>
    <td colspan="2"><?php echo draw_option("Q15","None;Has;Description","xm","multi",$Q15,false,5); ?>：<input type="text" name="Q15a" value="<?php echo $Q15a; ?>"/></td>
  </tr>
  <tr>
    <td class="title">Skin condition <br> near the wound edge<br> (within 4cm)</td>
    <td colspan="2"><?php echo draw_option("Q16","Normal;Reddish;Edema;infiltration;Excoriation;Eczema;Blister;Pustule;Desquamation;Bruising;Turn black;Pigmentation disorders;Dry Skin;Scleroma","xl","multi",$Q16,true,3); ?></td>
  </tr>
<!--  <tr>
    <td class="title">潛行深洞</td>
    <td colspan="2"><?php //echo draw_checkbox("Q17","None;潛行深洞＜2cm;潛行深洞2-4cm、但範圍＜50%傷口邊緣;潛行深洞2-4cm、但範圍＞50%傷口邊緣;潛行深洞或竇狀通道＞4cm;其他隧道型通道描述（請註明長度，單位cm）：<input type=\"text\" name=\"Q17a\" id=\"Q17a\" size=\"30\" value=\"".$Q17a."\">",$Q17,"multi"); ?></td>
  </tr>
  <tr>
    <td class="title">潛行深洞方位</td>
    <td colspan="2"><input type="text" name="Q18" id="Q18" value="<?php //echo $Q18 ?>"/>（幾點鐘位置）</td>
  </tr>
-->  <tr>
    <td class="title">Necrosis</td>
    <td colspan="2"><?php echo draw_checkbox_nobr("Q19","None;White/gray necrotic tissue;Soft,yellow slough;Soft,black scab;Hard,black scab",$Q19,"multi"); ?></td>
  </tr>
<!--  <tr>
    <td class="title">壞死組織量</td>
    <td colspan="2"><?php //echo draw_option("Q20","＜25%;25-50%;＞50% 但＜75%;≧75%","l","multi",$Q20,false,7); ?></td>
  </tr>
  <tr>
    <td class="title">肉芽組織</td>
    <td colspan="2"><?php //echo draw_checkbox("Q21","皮膚完整或部份皮層受損;鮮紅色、75-100%傷口有肉芽組織 / 或 過度增生;鮮紅色、＜75%但≧25%傷口有肉芽組織;粉紅或暗紅色、＜25%傷口有肉芽組織;無肉芽組織",$Q21,"multi"); ?></td>
  </tr>
-->  
  <tr>
    <td class="title">Care treatment</td>
    <td colspan="2"><?php echo draw_checkbox("Q29","Pressure reducing device for chair;Pressure reducing device for bed;Turning/repositioning program;Nutrition or hydration intervention to manage skin problems;Pressure ulcer care;Surgical wound care;Application of nonsurgical dressings (with or without topical medications) other than to feet;Applications of ointments/medications other than to feet;Application of dressings to feet (with or without topical medications);Maintain skin cleansing",$Q29,"multi"); ?></td>
  </tr>
  <tr>
    <td class="title">Wound dressing change</td>
    <td colspan="2"><?php echo draw_checkbox_2col("Q22","Burn ointments;Neomycin;Betadine-soaked gauze;Hydrocolloid dressing;Vaseline gauze;Wet dressing;Wound cleansing;Other (please specify the dressing and number of wound) :<input type=\"text\" name=\"Q22a\" id=\"Q22a\" size=\"30\" value=\"".$Q22a."\">",$Q22,"multi"); ?></td>
  </tr>
  <tr>
    <td class="title">frequency of<br> changing dressing</td>
    <td><input type="text" name="Q25a" id="Q25a" size="1" value="<?php echo $Q25a; ?>">Day(s)<input type="text" name="Q25b" id="Q25b" size="1" value="<?php echo $Q25b; ?>">Time(s)</td>
    <td><?php echo draw_option("Q25","1-3days;3-5days;5-7days","xm","single",$Q25,false,6); ?></td>
  </tr>  
<!--  <tr>
    <td class="title">傳統敷料</td>
    <td colspan="2"><?php //echo draw_option("Q23","None;紗布;散紗;Y型紗布;Vaseline gauze;Betadine-soaked gauze;燙傷紗布;棉墊;Y型棉墊;Other","m","multi",$Q23,true,6); ?>：<input type="text" name="Q23a" id="Q23a" value="<?php //echo $Q23a ?>"/></td>
  </tr>
  <tr>
    <td class="title">特殊敷料</td>
    <td colspan="2"><?php //echo draw_option("Q24","None;噴式保護膜;Alginate;Aquacel;Aquacel Ag;Biatin foam;Biatin Ag foam;Bionect cream;Bionect gel;Bionect gauze;Comfeel powder;Comfeel paste;Duoderm;Duoderm gel;Dermatix;Extra thin;Francetin-T- powder;Medifil;Mepilex foam;Mepitel;Mepiform;OP Site;Purilon gel;Purelan;Stomahesive powder;Transfer;外用藥膏;Other","l","multi",$Q24,true,4); ?>：<input type="text" name="Q24a" id="Q24a" value="<?php //echo $Q24a ?>"/></td>
  </tr>
-->
  <tr>
    <td class="title">Pressure ulcer healing</td>
    <td colspan="2"><?php echo draw_option("Q3","Healed;Not healed","xm","single",$Q3,false,5); ?></td>
  </tr>
  <tr>
    <td class="title">Healed date</td>
    <td colspan="2"><script> $(function() { $( "#Q26").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" id="Q26" name="Q26" value="<?php if ($Q26!=NULL) { echo $Q26; } ?>" size="12" /> <input type="button" value="Today" onclick="$('#Q26').val('<?php echo date("Y/m/d"); ?>')"></td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td class="title">Wound photo</td>
  </tr>
  <?php
  $picFolder = 'uploadfile/'.$_SESSION['nOrgID_lwj'].'/'.$HospNo.'/nurseform2g2_pic/';
  if (file_exists($picFolder)) {
  ?>
  <tr>
    <td colspan="4">
    <?php
  $arrFiles = scandir($picFolder);
  for ($i=2;$i<count($arrFiles);$i++) {
    $arrFileName = explode('_',$arrFiles[$i]);
    if ($arrFileName[0].'_'.$arrFileName[1]==$_GET['date']) {
      $delCountNo++;
      echo '
      <div style="margin:5px; padding:10px; background:#fff; display:inline-block;">
      <span class="printcol" id="txtDel'.$delCountNo.'"><input type="checkbox" name="Del'.$delCountNo.'" id="Del'.$delCountNo.'"> DELETE<br></span>
      <a href="'.$picFolder.'/'.$arrFiles[$i].'" class="example-image-link" data-lightbox="example-set"><img src="'.$picFolder.'/'.$arrFiles[$i].'" width="200"></a>
      <input type="hidden" name="Delimg'.$delCountNo.'" id="Delimg'.$delCountNo.'" value="'.$picFolder.'/'.$arrFiles[$i].'">
      </div>
      ';
    }
  }
  ?>
    <input type="hidden" name="delCount" id="delCount" value="<?php echo $delCountNo; ?>">
    </td>
  </tr>
  <?php
  }
  ?>
  <tr>
    <td colspan="2"><?php if ($_GET['date']!="" && $act == "") { $act = "edit"; } elseif ($_GET['date']!="" && $act != "") { $act = "view"; } else { $act = "new"; } include("class/addImage.php"); ?></td>
  </tr>  
</table>
</div>
<table width="100%">
  <tr>
    <td>Filled date：<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if($_GET['newDate']!="") { echo formatdate($_GET['newDate']); } else { if ($date != NULL) { echo formatdate($date); } } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" /></td>
    <td align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>
<?php 
  //取得巴氐量表總分
  $db3 = new DB;
  $db3->query("SELECT Qtotal FROM `nurseform02c` WHERE `HospNo`='".$HospNo."' ORDER BY `date` DESC LIMIT 0,1");
  $r3 = $db3->fetch_assoc();
  echo '<input type="hidden" name="Q27" id="Q27" value="'.$r3['Qtotal'].'">';
?>
<center><input type="hidden" name="formID" id="formID" value="nurseform02g_2" />
<?php 
if($_GET['no']=="" || $_GET['no']==NULL){
  $db4 = new DB;
  $db4->query("SELECT `no` FROM `nurseform02g_2` WHERE `HospNo`='".$HospNo."' ORDER BY `no` DESC");
  $r4 = $db4->fetch_assoc();
  if ($db4->num_rows()>0) {
      $newon = $r4['no']+1;
  }else{
    $newon = 1;
  }
}
?>
<input type="hidden" name="CheckInRecord" id="CheckInRecord" value="<?php echo $CheckInRecord;?>" />
<input type="hidden" name="no" id="no" value="<?php if($_GET['no']!="" && $_GET['no']!=NULL){ echo $_GET['no'];}else{ echo $newon;} ?>" />
<input type="hidden" name="oldNo" id="oldNo" value="<?php echo $r1['no'];?>" />
<input type="hidden" name="oldDate" id="oldDate" value="<?php echo $r1['date'];?>" />
<input type="hidden" name="act" id="act" value="<?php echo $act;?>" />
<input type="hidden" name="view" id="view" value="<?php echo $_GET['view'];?>" />
<input type="hidden" name="part" id="part" value="<?php echo $_GET['part'];?>" />
<input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
<!--<input type="button" onClick="window.location.href='index.php?mod=nurseform&func=formview&pid=<?php //echo $_GET['pid']; ?>&id=2g_2a';" value="Back to list" />--></center>
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
<script>
function checkDel() {
  var delCount = $('#delCount').val();
  var count=0;
  if (delCount>0) {
    for (var i=1;i<=delCount;i++) {
      if ($('#Del'+i).attr('checked')) {
        count++;
      }
    }
    if (count>0) {
      if (confirm("確認刪除圖片?")) {
        return true;
      } else {
        return false;
      }
    } else {
      return true;
    }
  } else {
    return true;
  }
}
function checkThisForm() {
  if (checkForm() && checkDel()) {
    return true;
  } else {
    return false;
  }
}
</script>