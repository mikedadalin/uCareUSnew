<?php
  if($_GET['date']=='Select dates to edit information or new record'){
    $db = new DB;
    $db->query("SELECT * FROM `mdsform99` WHERE `HospNo`='".$HospNo."' ORDER BY `date` DESC");
    $r = $db->fetch_assoc();
    $r['date'] = str_replace('-','',$r['date']);
    ?>
    <script>
    document.location.href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=<?php echo $_GET['id']; ?>&date=<?php echo $r['date'];?>";
    </script>
    <?php
  }
?>
<?php
$sql = "SELECT * FROM `mdsform12` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
$db1 = new DB;
$db1->query($sql);
$r1 = $db1->fetch_assoc();
if ($db1->num_rows()>0) {
	foreach ($r1 as $k=>$v) {
		${$k} = $v;
	}
}
?>
<style>
body {font-family:sans-serif; line-height:15px; font-size:9px}
table.bordercolor {border-color:rgb(113,113,99); background-color:rgb(255,255,255);}
td.section {background-color:rgb(113,113,99); color:white; font-size:14px; padding-left:5px}
td.section2 {background-color:rgb(230,230,226); font-size:14px}
td.answer {background-color:rgb(221,228,255); border:1px solid black; width:20px; height:20px; text-align:center}
td.part {background-color:rgb(230,230,226); height:20px; text-align:left; padding-left:5px}
td.partwhite {background-color:rgb(255,255,255); height:20px; text-align:left}
td.content {background-color:rgb(230,230,226); text-align:center; font-size:xx-small; width:70px}
td.content2 {background-color:rgb(230,230,226); text-align:left}
a.content3 {padding-left:3px; margin:0px}
ul {list-style:upper-alpha; padding:0px; padding-left:20px; margin:0px}
ol {list-style:decimal; padding:0px; padding-left:37px; margin:0px}
ol.zero {list-style:decimal-leading-zero}
td.sectiontop1 {border:0px solid black; width:300px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop2 {border:0px solid black; width:150px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop3 {border:0px solid black; width:100px; text-align:left; margin:0px; padding-left:10px}
</style>

<body>
<form name="form12" method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<table cellspacing="0" align="center" style="font-size:16px"><tr><td>Resident:</td><td class="sectiontop1"><font size="3"><b><?php echo $name; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Identifier:</td><td class="sectiontop2"><font size="3"><b><?php echo $_SESSION['ncareName_lwj']; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Date:</td><td class="sectiontop3"><font size="3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script></font><input type="text" size="18" name="date" id="date" value="<?php echo formatdate_Ymd_Slash($date);?>"></b></font><hr color="black" align="left" width="100%" size="1"></td></tr></table>
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1" style="margin-bottom:3px">
<tr>
<td class="section2" width="150"><b style="padding-left:5px">Section E</b></td>
<td class="section2" width="720"><b style="padding-left:5px">Behavior</b></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1">
<tr>
<td class="part" colspan="2"><b>E0900. Wandering - Presence & Frequency</b></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content" width="70" valign="top">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($E0900_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td width="800">
<b style="padding-left:6px">Has the resident wandered?</b>
<ol start="0">
<li><input type="radio" name="QE0900" value="0" <?php if($QE0900=="0") echo "checked";?>><b>Behavior not exhibited &#8594;</b> Skip to E1100, Change in Behavioral or Other Symptoms
<li><input type="radio" name="QE0900" value="1" <?php if($QE0900=="1") echo "checked";?>><b>Behavior of this type occurred 1 to 3 days</b>
<li><input type="radio" name="QE0900" value="2" <?php if($QE0900=="2") echo "checked";?>><b>Behavior of this type occurred 4 to 6 days,</b> but less than daily
<li><input type="radio" name="QE0900" value="3" <?php if($QE0900=="3") echo "checked";?>><b>Behavior of this type occurred daily</b>
</ol>
</td>
</tr>
<!--------------------------------------------> 
<tr>
<td class="part" colspan="2"><b>E1000. Wandering - Impact</b></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content" valign="top">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($E1000A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<ul>
<li><b>Does the wandering place the resident at significant risk of getting to a potentially dangerous place</b> (e.g., stairs, outside of the<br>facility)?
</ul>
<ol start="0">
<li><input type="radio" name="QE1000A" value="0" <?php if($QE1000A=="0") echo "checked";?>><b>No</b>
<li><input type="radio" name="QE1000A" value="1" <?php if($QE1000A=="1") echo "checked";?>><b>Yes</b>
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content" valign="top">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($E1000B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<ul>
<li value="2"><b>Does the wandering significantly intrude on the privacy or activities of others?
</ul>
<ol start="0">
<li><input type="radio" name="QE1000B" value="0" <?php if($QE1000B=="0") echo "checked";?>><b>No</b>
<li><input type="radio" name="QE1000B" value="1" <?php if($QE1000B=="1") echo "checked";?>><b>Yes</b>
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2">
<b>E1100. Change in Behavior or Other Symptoms</b><br>Consider all of the symptoms assessed in items E0100 through E1000
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($E1100_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<a class="content3">How does resident's current behavior status, care rejection, or wandering <b>compare to prior assessment (OBRA or PPS)?</b></a>
<ol start="0">
<li><input type="radio" name="QE1100" value="0" <?php if($QE1100=="0") echo "checked";?>><b>Same</b>
<li><input type="radio" name="QE1100" value="1" <?php if($QE1100=="1") echo "checked";?>><b>Improved</b>
<li><input type="radio" name="QE1100" value="2" <?php if($QE1100=="2") echo "checked";?>><b>Worse</b>
<li><input type="radio" name="QE1100" value="3" <?php if($QE1100=="3") echo "checked";?>><b>N/A</b> because no prior MDS assessment
</ol>
</td>
</tr>
</table>
<!-------------------------------------------->
<p align="center">
<input type="hidden" name="formID" id="formID" value="mdsform12">
<input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
<button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
<input type="reset" value="Reset"></p>
<p style="font-size:10px; color:black">MDS 3.0 Nursing Home Comprehensive (NC) Version 1.12.0 Effective 10/01/2014</p>
</form>
</body>
