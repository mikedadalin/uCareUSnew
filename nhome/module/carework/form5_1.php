<?php
if (@$_GET['date']=='') {
	$sql = "SELECT * FROM `careform05` WHERE `HospNo`='".$HospNo."' AND `date`=''";
} else {
	$sql = "SELECT * FROM `careform05` WHERE `HospNo`='".$HospNo."' AND `date`='".mysql_escape_string($_GET['date'])."'";
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
<div class="moduleNoTab">
<form  method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save&url=<?php echo urlencode($_GET['url']); ?>">
<h3>Day shift work record</h3>
<table style="text-align:left;">
  <tr>
    <td width="200" rowspan="7" class="title">Diet</td>
      <td colspan="2" class="title_s">Breakfast/Milk Sarapan/susu</td>
      <td width="464"><?php echo draw_option("Q1","Good;Fair;Poor","m","single",$Q1,false,4); ?></td>
  </tr>
  <tr>
      <td colspan="2" class="title_s">AM tea/refreshment</td>
      <td><?php echo draw_option("Q2","Good;Fair;Poor","m","single",$Q2,false,4); ?></td>
  </tr>
  <tr>
      <td colspan="2" class="title_s">Lunch</td>
      <td><?php echo draw_option("Q3","Good;Fair;Poor","m","single",$Q3,false,4); ?></td>
  </tr>
  <tr>
      <td colspan="2" class="title_s">Afternoon refreshment</td>
      <td><?php echo draw_option("Q4","Good;Fair;Poor","m","single",$Q4,false,4); ?></td>
  </tr>
  <tr>
      <td colspan="2" class="title_s">Dinner</td>
      <td><?php echo draw_option("Q5","Good;Fair;Poor","m","single",$Q5,false,4); ?></td>
  </tr>
  <tr>
      <td colspan="2" class="title_s">Evening refreshement/milk</td>
      <td><?php echo draw_option("Q6","Good;Fair;Poor","m","single",$Q6,false,4); ?></td>
  </tr>
  <tr>
      <td colspan="2" class="title_s">NGT feeding</td>
      <td><?php echo draw_option("Q12","Good;Fair;Poor","m","single",$Q12,false,4); ?></td>
  </tr>
  <tr>
    <td class="title">Activity</td>
    <td colspan="4">
        <?php echo draw_checkbox("Q7","Rehabilitation;Practice walking;Transfer to wheelchair<input type=\"text\" name=\"Q7a\" size=\"3\" value=\"".$Q7a."\">Time(s);Bed rest;Enhance Positioning(turn over)",$Q7,"multi"); ?>
    </td>
  </tr>
  <tr>
    <td class="title">Personal hygiene</td>
    <td colspan="4">
        <?php
			$txt = "Buttock clean/care";
			echo draw_checkbox("Q8","Oral care<input type=\"text\" name=\"Q8a\" size=\"3\" value=\"".$Q8a."\">Time(s);Arrange bedsheet<input type=\"text\" name=\"Q8b\" size=\"3\" value=\"".$Q8b."\">Time(s);Cut nails;".$txt."<input type=\"text\" name=\"Q8c\" size=\"3\" value=\"".$Q8c."\">Time(s);Bathing",$Q8,"multi"); 
		?>
    </td>
  </tr>
  <tr>
    <td class="title">Other</td>
    <td colspan="4">
        <?php echo draw_checkbox("Q9","Out visiting (clinic,hospital,home...etc);Steam inhalation <input type=\"text\" name=\"Q9a\" size=\"3\" value=\"".$Q9a."\">Time(s);Skin lotion;Vaseline",$Q9,"multi"); ?>
    </td>
  </tr>
  <tr>
    <td class="title">Family visit</td>
    <td colspan="4"><?php echo draw_checkbox("Q13","Spouse;Son;Daughter in law;Daughter;Grandson;Relative Relative;Friend;Personal aide;Other <input type=\"text\" id=\"Q10\" name=\"Q10\" value=\"".$Q10."\">","s","multi",$Q13,false,2); ?></td>
  </tr>
  <tr>
    <td class="title">Comment</td>
    <td colspan="4"><input type="text" id="Q11" name="Q11" value="<?php echo $Q11;?>"></td>
  </tr>
</table>  
<table width="100%">
  <tr>
    <td align="left">Filled date：<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if ($date != NULL) { echo formatdate($date); } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" /></td>
    <td align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>
<center>
  <div style="margin-top:20px;">
  <input type="hidden" name="formID" id="formID" value="careform05" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><input type="button" id="back" value="Back to list" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
  </div>
</center>
</form>
</div>
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
$(function() {
	$('#back').click(function(){
		location.href = "index.php?mod=carework&func=formview&id=5&pid=<?php echo $_GET['pid']; ?>";
	});
});
</script>

