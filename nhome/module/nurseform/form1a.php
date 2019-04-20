<form  method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<div class="content-table">
<h3>Family tree</h3> <!--word_1-->
</div>
<div class="content-table">
<table width="100%">
  <tr class="title">
    <td>Relationship</td> <!--word_2-->
    <td>Sibling order</td> <!--word_3-->
    <td>Parents' sibling order</td> <!--word_4-->
    <td>Age</td> <!--word_5-->
    <td>Occupation</td> <!--word_6-->
    <td width="100px">Gender</td> <!--word_7-->
    <td width="100px">Marriage</td> <!--word_8-->
    <td width="100px">Alive/Dead</td> <!--word_9-->
    <td>Comment</td> <!--word_10-->
    <td>Phone</td> <!--word_11-->
    <td>Email</td> <!--word_12-->
  </tr>
<?php
if (@$_GET['date']=="") {
	$sqladd = " ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sqladd = " AND `date`='".mysql_escape_string($_GET['date'])."'";
}
$sql = "SELECT * FROM `nurseform01a` WHERE `HospNo`='".mysql_escape_string($HospNo)."'".$sqladd;
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
for ($i=0;$i<18;$i++) {
	if (strlen($i)==1) { $no = '0'.$i; } else { $no = $i; }
	if( ${'Qphone'.$i}!=""){
	   /*== 解 START ==*/
	       $rsa = new lwj('lwj/lwj');
	       $puepart = explode(" ", ${'Qphone'.$i});
	       $puepartcount = count($puepart);
	       if($puepartcount>1){
               for($j=0;$j<$puepartcount;$j++){
                   $prdpart = $rsa->privDecrypt($puepart[$j]);
                   ${'Qphone'.$i} = ${'Qphone'.$i}.$prdpart;
               }
	       }else{
		      ${'Qphone'.$i} = $rsa->privDecrypt( ${'Qphone'.$i});
	       }
	   /*== 解 END ==*/		
	}
	if( ${'Qmail'.$i}!=""){
	   /*== 解 START ==*/
	       $rsa = new lwj('lwj/lwj');
	       $puepart = explode(" ", ${'Qmail'.$i});
	       $puepartcount = count($puepart);
	       if($puepartcount>1){
               for($j=0;$j<$puepartcount;$j++){
                   $prdpart = $rsa->privDecrypt($puepart[$j]);
                   ${'Qmail'.$i} = ${'Qmail'.$i}.$prdpart;
               }
	       }else{
		      ${'Qmail'.$i} = $rsa->privDecrypt( ${'Qmail'.$i});
	       }
	   /*== 解 END ==*/		
	}
	echo '
  <tr>
    <td>
	  <input type="hidden" name="QfmID'.$i.'" size="1" value="'.${'QfmID'.$i}.'">
	  <div class="formselect">
      <select name="Qrelate'.$i.'">
	    <option></option>
        <option value="5"'.drawselected(${'Qrelate'.$i},5).'>Father</option>
        <option value="9"'.drawselected(${'Qrelate'.$i},9).'>Mother</option>
        <option value="12"'.drawselected(${'Qrelate'.$i},12).'>Older brother</option>
        <option value="13"'.drawselected(${'Qrelate'.$i},13).'>Older sister</option>
        <option value="14"'.drawselected(${'Qrelate'.$i},14).'>Younger brother</option>
        <option value="15"'.drawselected(${'Qrelate'.$i},15).'>Younger sister</option>
        <option value="16"'.drawselected(${'Qrelate'.$i},16).'>Spouse</option>
        <option value="17"'.drawselected(${'Qrelate'.$i},17).'>Son</option>
        <option value="18"'.drawselected(${'Qrelate'.$i},18).'>Daughter</option>
        <option value="20"'.drawselected(${'Qrelate'.$i},20).'>Son in law</option>
        <option value="21"'.drawselected(${'Qrelate'.$i},21).'>Daughter in law</option>
        <option value="22"'.drawselected(${'Qrelate'.$i},22).'>Grandson</option>
        <option value="23"'.drawselected(${'Qrelate'.$i},23).'>Granddaughter</option>
        <option value="26"'.drawselected(${'Qrelate'.$i},26).'>Personal aide</option>
        <option value="27"'.drawselected(${'Qrelate'.$i},27).'>Friend</option>
        <option value="28"'.drawselected(${'Qrelate'.$i},28).'>Nursing home</option>
        <option value="29"'.drawselected(${'Qrelate'.$i},29).'>Foundation\'s staff</option>
        <option value="30"'.drawselected(${'Qrelate'.$i},30).'>Caregivers</option>
      </select>
	  </div>
    </td>
    <td><input type="text" name="Qrank'.$i.'" size="1" value="'.${'Qrank'.$i}.'"></td>
    <td><input type="text" name="Qprank'.$i.'" size="1" value="'.${'Qprank'.$i}.'"></td>
    <td><input type="text" name="Qage'.$i.'" size="2" value="'.${'Qage'.$i}.'"></td>
    <td><input type="text" name="Qwork'.$i.'" size="2" value="'.${'Qwork'.$i}.'"></td>
	<td>'.draw_option("Qgender".$i,"Male;Female","xs","multi",${'Qgender'.$i},false,5).'</td>
    <td>'.draw_option("Qmarriage".$i,"Married;Divorced;None","xs","multi",${'Qmarriage'.$i},true,1).'</td>
    <td>'.draw_option("Qalive".$i,"Alive;Dead","s","multi",${'Qalive'.$i},false,5).'</td>
    <td><input type="text" name="Qmemo'.$i.'" size="4" value="'.${'Qmemo'.$i}.'"></td>
    <td><input type="text" name="Qphone'.$i.'" size="4" value="'.${'Qphone'.$i}.'"></td>
    <td><input type="text" name="Qmail'.$i.'" size="4" value="'.${'Qmail'.$i}.'"></td>
  </tr>'."\n";
} ?>
</table>
Filled date：<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if($_GET['newDate']!="") { echo formatdate($_GET['newDate']); } else { if ($date != NULL) { echo formatdate($date); } } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" />
<center><input type="hidden" name="formID" id="formID" value="nurseform01a" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></center>
</div>
</form>
<?php
$db2 = new DB;
$db2->query("SELECT `QFamilyTreeJPG` FROM `socialform01` WHERE `HospNo`='".$HospNo."'");
$r2 = $db2->fetch_assoc();
?>
<script>
$(function() {
	$( "#tabs_familystructure" ).tabs(
	<?php if ($r2['QFamilyTreeJPG']=="") { echo '{active:1}'; } ?>
	);
}); </script>
<div id="tabs_familystructure">
  <ul class="printcol">
    <li><a href="#fstabs-1">Upload image</a></li>
    <li><a href="#fstabs-2">System image</a></li>
  </ul>
  <div id="fstabs-1">
  <form><input type="button" value="Upload image" onclick="window.open('class/uploadfiles.php?pid=<?php echo @$_GET['pid']; ?>&date=<?php echo date("Ymd"); ?>');" class="printcol"></form>
  <?php
  if ($r2['QFamilyTreeJPG']!="") {
      echo '<img id="fsjpg" src="uploadfile/'.$_SESSION['nOrgID_lwj'].'/'.$HospNo.'/socialform01_pic/'.$r2['QFamilyTreeJPG'].'" border="0">';	  
  } else {
      echo '<img id="fsjpg" border="0" width="800" style="display:none;">';
  }?>
  </div>
  <div id="fstabs-2">
  <iframe src="module/nurseform/form1a_1.php?pid=<?php echo $_GET['pid']; ?>" width="100%" height="480" frameborder="0"></iframe>
  </div>
</div><br><br>