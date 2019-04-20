<?php
if (@$_GET['date']=='') {
	$sql = "SELECT * FROM `nurseform02f` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql = "SELECT * FROM `nurseform02f` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`='".mysql_escape_string($_GET['date'])."'";
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
<form  method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<h3>Depression assessment</h3>
<table width="100%">
  <tr>
    <td rowspan="13" class="title" width="50px">DS</td>
    <td colspan="2" class="title" style="text-align:left;">&nbsp;In the past week, do you have the following scenario and feeling?</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td style="text-align:left;"><?php echo draw_checkbox("Q0","Unassessable",$Q0,"multi"); ?></td>
  </tr>
  <tr>
    <td class="title_s" style="text-align:left;">&nbsp;a. Decreased appetite</td>
    <td><?php echo draw_option("Q1","Never occurred(<1 day);Sometimes (1-2 days);Often (3 to 7 days)","xl","multi",$Q1,false,0); ?></td>
  </tr>
  <tr>
    <td class="title_s" style="text-align:left;">&nbsp;b. Feeling down, bad mood, or hopeless.</td>
    <td><?php echo draw_option("Q2","Never occurred(<1 day);Sometimes (1-2 days);Often (3 to 7 days)","xl","multi",$Q2,false,0); ?></td>
  </tr>
  <tr>
    <td class="title_s" style="text-align:left;">&nbsp;c. Feeling things aren't going well, such as more challenges.</td>
    <td><?php echo draw_option("Q3","Never occurred(<1 day);Sometimes (1-2 days);Often (3 to 7 days)","xl","multi",$Q3,false,0); ?></td>
  </tr>
  <tr>
    <td class="title_s" style="text-align:left;">&nbsp;d. Poor sleeping condition</td>
    <td><?php echo draw_option("Q4","Never occurred(<1 day);Sometimes (1-2 days);Often (3 to 7 days)","xl","multi",$Q4,false,0); ?></td>
  </tr>
  <tr>
    <td class="title_s" style="text-align:left;">&nbsp;e. Feeling very happy</td>
    <td><?php echo draw_option("Q5","Never occurred(<1 day);Sometimes (1-2 days);Often (3 to 7 days)","xl","multi",$Q5,false,0); ?></td>
  </tr>
  <tr>
    <td class="title_s" style="text-align:left;">&nbsp;f. Feeling lonely</td>
    <td><?php echo draw_option("Q6","Never occurred(<1 day);Sometimes (1-2 days);Often (3 to 7 days)","xl","multi",$Q6,false,0); ?></td>
  </tr>
  <tr>
    <td class="title_s" style="text-align:left;">&nbsp;g. Feeling that people treat you unfriendly</td>
    <td><?php echo draw_option("Q7","Never occurred(<1 day);Sometimes (1-2 days);Often (3 to 7 days)","xl","multi",$Q7,false,0); ?></td>
  </tr>
  <tr>
    <td class="title_s" style="text-align:left;">&nbsp;h. Feeling life is very good and enjoy it</td>
    <td><?php echo draw_option("Q8","Never occurred(<1 day);Sometimes (1-2 days);Often (3 to 7 days)","xl","multi",$Q8,false,0); ?></td>
  </tr>
  <tr>
    <td class="title_s" style="text-align:left;">&nbsp;i. Feeling very sad </td>
    <td><?php echo draw_option("Q9","Never occurred(<1 day);Sometimes (1-2 days);Often (3 to 7 days)","xl","multi",$Q9,false,0); ?></td>
  </tr>
  <tr>
    <td class="title_s" style="text-align:left;">&nbsp;j. Feel that people do not like you</td>
    <td><?php echo draw_option("Q10","Never occurred(<1 day);Sometimes (1-2 days);Often (3 to 7 days)","xl","multi",$Q10,false,0); ?></td>
  </tr>
  <tr>
    <td class="title_s" style="text-align:left;">&nbsp;k. Feel no motivation to do anything</td>
    <td><?php echo draw_option("Q11","Never occurred(<1 day);Sometimes (1-2 days);Often (3 to 7 days)","xl","multi",$Q11,false,0); ?></td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td>Filled date：<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if($_GET['newDate']!="") { echo formatdate($_GET['newDate']); } else { if ($date != NULL) { echo formatdate($date); } } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" /></td>
    <td align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>
<center><input type="hidden" name="formID" id="formID" value="nurseform02f" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></center>
</form><br><br>
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