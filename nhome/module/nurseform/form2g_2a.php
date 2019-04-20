<script type="text/javascript" src="js/LWJ_tabs.js"></script>
<?php
$db1 = new DB;
$db1->query("SELECT * FROM `nurseform02g_2` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `no` ASC LIMIT 0,100");
?>
<table style="width:100%;">
  <tr style="background:#ffffff">
    <td style="width:300px; border-top-left-radius:16px;"><h3>Pressure ulcer care record</h3></td>
	<?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?>
	<td style="width:420px;" align="center"><form><input type="button" value="Add pressure ulcer care record" style="font-size:10pt;" onclick="window.location.href='index.php?mod=nurseform&func=formview&pid=<?php echo @$_GET['pid'] ?>&id=2g_2'" /></form></td>
	<?php }?>
	<td style="border-top-right-radius:16px;">&nbsp;</td>
  </tr>
</table>
<!--<div id="tabs">
  <ul>
    <li><a href="#tabs-1">Pressure ulcer(s)</a></li>
    <li><a href="#tabs-2">Wound</a></li>
  </ul>
  <div id="tabs-1">-->

	  <table style="width:100%;">
	    <tr class="title">
	      <td colspan="9">Pressure Ulcer</td>
	    </tr>
	    <tr class="title_s">
	      <td width="80"><?php if(substr($_SESSION['ncareID_lwj'],0,8)=="resident"){ echo 'View';}else{ echo 'Edit';}?></td>
		  <td width="80">No.</td>
		  <td width="100">Part</td>
	      <td width="200">Stage</td>
	      <td width="140">Healing condition</td>
	      <td width="140">Generation time</td>
		  <td width="110">Healed date</td>
		  <td width="110">Record Time</td>
	      <td>Identifier</td>
	    </tr>

  <?php
  for ($i=0;$i<$db1->num_rows();$i++) {
	  $r1 = $db1->fetch_assoc();
	  foreach ($r1 as $k=>$v) {
		  if (substr($k,0,1)=="Q") {
			  $arrAnswer = explode("_",$k);
			  if (count($arrAnswer)==2) {
				  if ($v==1) { ${$arrAnswer[0]} .= $arrAnswer[1].';'; }
			  } else {
				  ${$k} = $v;
			  }
		  }  else { ${$k} = $v; }
	  }
	  echo '
  <tr>
    <td>';
	  if ($r1['Qfiller']==$_SESSION['ncareID_lwj'] || $_SESSION['ncareLevel_lwj']>=4) {
		  if(substr($_SESSION['ncareID_lwj'],0,8)=="resident"){
			  echo '<center><a href="index.php?mod=nurseform&func=formview&id=2g_2&pid='.mysql_escape_string($_GET['pid']).'&date='.$r1['date'].'&no='.$r1['no'].'"><img src="Images/MDSView.png" width="60%" border="0"></a></center>';
		  }else{
			  echo '<center><a href="index.php?mod=nurseform&func=formview&id=2g_2&pid='.mysql_escape_string($_GET['pid']).'&date='.$r1['date'].'&no='.$r1['no'].'"><img src="Images/edit_icon.png" width="20" border="0"></a></center>';
		  }
	  } else { echo '&nbsp;'; }
	  echo '
	  	  </td>
		  <td><center>'.$r1['no'].'</center></td>
		  <td><center>'.option_result("Q2","Forehead;Nose;Chin;Outer ear;Occipital;Breast;Chest;Rib cage;Costal arch;Scapula;Humerus;Elbow;Abdomen;Spine protruding spot;Scrotum;Perineum;Sacral vertebrae;Buttock;Hip ridge;Ischial tuberosity;Front knee;Medial knee;Fibula;Lateral ankle;Inner ankle;Heel;Toe;Plantar;Intertrochanteric;Other","m","multi",$Q2,true,6).'</center></td>
	      <td><center>'.checkbox_result("Q4","Stage 1;Stage 2;Stage 3;Stage 4;Unstageable - Non-removable dressing;Unstageable - Slough and/or eschar;Unstageable - Deep tissue",$Q4,"multi").'</center></td>
	      <td><center>'.option_result("Q3","Healed;Unhealed","s","multi",$Q3,false,5).'</center></td>
	  	  <td><center>'.$Q7.'</center></td>
		  <td><center>';
		  if($Q3=="1;"){ echo $Q26;}else{ echo "";}
		  echo '</center></td>
		  <td><center>';
		  ?>
		  <script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><?php echo formatdate($date); ?>
		  <?php
		  echo '</center></td>
	      <td><center>'.checkusername($Qfiller).'</center></td>
	    </tr>
	  	  '."\n";
	  	  $Q4 = "";
	  	  $Q3 = "";
	  	  $Q7 = "";
		if ($r1) {
          foreach ($r1 as $k=>$v) {
	        if (substr($k,0,1)=="Q") {
		      $arrAnswer = explode("_",$k);
		      if(count($arrAnswer)==2) {
			    if($v==1) {
				  ${$arrAnswer[0]} = "";
			    }
		      }else {
			    ${$k} = "";
		      }
	        }else {
		      ${$k} = "";
	        }
          }
        }
	    }
  ?>
</table>
<br><br>
<!--</div>
<div id="tabs-2">
<?php
$db2 = new DB;
$db2->query("SELECT * FROM `nurseform02g_2` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `Q0_2`='1' ORDER BY `date` DESC LIMIT 0,100");
?>
<table style="width:900px;">
  <tr class="title">
    <td colspan="5">Wound</td>
  </tr>
  <tr class="title_s">
    <td width="80">Edit</td>
    <td width="240">Wound size</td>
    <td width="240">Wound dressing change</td>
    <td width="180">Filled date</td>
    <td>Filled by</td>
  </tr>
  <?php
  for ($i=0;$i<$db2->num_rows();$i++) {
	  $r2 = $db2->fetch_assoc();
	  foreach ($r2 as $k=>$v) {
		  if (substr($k,0,1)=="Q") {
			  $arrAnswer = explode("_",$k);
			  if (count($arrAnswer)==2) {
				  if ($v==1) { ${$arrAnswer[0]} .= $arrAnswer[1].';'; }
			  } else {
				  ${$k} = $v;
			  }
		  }  else { ${$k} = $v; }
	  }
	  echo '
  <tr>
    <td>';
	  if ($r2['Qfiller']==$_SESSION['ncareID_lwj'] || $_SESSION['ncareLevel_lwj']>=4) {
		  echo '<center><a href="index.php?mod=nurseform&func=formview&id=2g_2&pid='.mysql_escape_string($_GET['pid']).'&date='.$r2['date'].'"><img src="Images/edit_icon.png" width="20" border="0"></a></center>';
	  } else { echo '&nbsp;'; }
	  echo '
	</td>
    <td><center>'.$Q9.'x'.$Q10.'x'.$Q11.'cm</center></td>
    <td><center>';
	  $Q22 = substr($Q22,0,strlen($Q22)-1); $arrQ22 = explode(';',$Q22); $Q22txt = ''; foreach ($arrQ22 as $k=>$v) { if ($Q22txt != '') { $Q22txt .= '、'; } $Q22txt .= $arrQ22item[$v]; }
	  echo $Q22txt.'</center></td>
	<td><center>'.formatdate($date).'</center></td>
    <td><center>'.checkusername($Qfiller).'</center></td>
  </tr>
	  '."\n";
  }
  ?>
</table>
</div>
</div>-->