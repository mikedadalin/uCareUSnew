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
$sql = "SELECT * FROM `mdsform39` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
ul {list-style:upper-alpha; padding:0px; padding-left:22px; margin:3px}
ol {list-style:decimal; padding:0px; padding-left:0px; margin:0px}
ol.zero {list-style:decimal-leading-zero}
td.sectiontop1 {border:0px solid black; width:300px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop2 {border:0px solid black; width:150px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop3 {border:0px solid black; width:100px; text-align:left; margin:0px; padding-left:10px}
</style>
<body>
<form name="form39" method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<table cellspacing="0" align="center" style="font-size:16px"><tr><td>Resident:</td><td class="sectiontop1"><font size="3"><b><?php echo $name; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Identifier:</td><td class="sectiontop2"><font size="3"><b><?php echo $_SESSION['ncareName_lwj']; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Date:</td><td class="sectiontop3"><font size="3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script></font><input type="text" size="18" name="date" id="date" value="<?php echo formatdate_Ymd_Slash($date);?>"></b></font><hr color="black" align="left" width="100%" size="1"></td></tr></table>
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1" style="margin-bottom:3px">
<tr>
<td class="section2" width="150"><b style="padding-left:5px">Section X</b></td>
<td class="section2" width="740"><b style="padding-left:5px">Correction Request</b></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1"> 
<tr>
<td class="part" colspan="2"><b>X1100. RN Assessment Coordinator Attestation of Completion</b></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content" width="70" rowspan="6"></td>
<td width="800">
<ul>
<li><b>Attesting individual's first name:</b><?php if (substr($url[3],0,5)!="print"){ if($X1100A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
<table cellspacing="0"><br>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX1100A_1" value="<?php echo $QX1100A_1; ?>" onkeyup="if(this.value.length==1)document.form39.QX1100A_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX1100A_2" value="<?php echo $QX1100A_2; ?>" onkeyup="if(this.value.length==0)document.form39.QX1100A_1.focus();if(this.value.length==1)document.form39.QX1100A_3.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX1100A_3" value="<?php echo $QX1100A_3; ?>" onkeyup="if(this.value.length==0)document.form39.QX1100A_2.focus();if(this.value.length==1)document.form39.QX1100A_4.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX1100A_4" value="<?php echo $QX1100A_4; ?>" onkeyup="if(this.value.length==0)document.form39.QX1100A_3.focus();if(this.value.length==1)document.form39.QX1100A_5.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX1100A_5" value="<?php echo $QX1100A_5; ?>" onkeyup="if(this.value.length==0)document.form39.QX1100A_4.focus();if(this.value.length==1)document.form39.QX1100A_6.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX1100A_6" value="<?php echo $QX1100A_6; ?>" onkeyup="if(this.value.length==0)document.form39.QX1100A_5.focus();if(this.value.length==1)document.form39.QX1100A_7.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX1100A_7" value="<?php echo $QX1100A_7; ?>" onkeyup="if(this.value.length==0)document.form39.QX1100A_6.focus();if(this.value.length==1)document.form39.QX1100A_8.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX1100A_8" value="<?php echo $QX1100A_8; ?>" onkeyup="if(this.value.length==0)document.form39.QX1100A_7.focus();if(this.value.length==1)document.form39.QX1100A_9.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX1100A_9" value="<?php echo $QX1100A_9; ?>" onkeyup="if(this.value.length==0)document.form39.QX1100A_8.focus();if(this.value.length==1)document.form39.QX1100A_10.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX1100A_10" value="<?php echo $QX1100A_10; ?>" onkeyup="if(this.value.length==0)document.form39.QX1100A_9.focus();if(this.value.length==1)document.form39.QX1100A_11.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX1100A_11" value="<?php echo $QX1100A_11; ?>" onkeyup="if(this.value.length==0)document.form39.QX1100A_10.focus();if(this.value.length==1)document.form39.QX1100A_12.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX1100A_12" value="<?php echo $QX1100A_12; ?>" onkeyup="if(this.value.length==0)document.form39.QX1100A_11.focus();"></td>
</table>
</ul>
</td>
</tr> 
<!-------------------------------------------->	 
<tr> 
<td> 
<ul>
<li value="2"><b>Attesting individual's last name:</b><?php if (substr($url[3],0,5)!="print"){ if($X1100B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
<table cellspacing="0"><br>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX1100B_1" value="<?php echo $QX1100B_1; ?>" onkeyup="if(this.value.length==1)document.form39.QX1100B_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX1100B_2" value="<?php echo $QX1100B_2; ?>" onkeyup="if(this.value.length==0)document.form39.QX1100B_1.focus();if(this.value.length==1)document.form39.QX1100B_3.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX1100B_3" value="<?php echo $QX1100B_3; ?>" onkeyup="if(this.value.length==0)document.form39.QX1100B_2.focus();if(this.value.length==1)document.form39.QX1100B_4.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX1100B_4" value="<?php echo $QX1100B_4; ?>" onkeyup="if(this.value.length==0)document.form39.QX1100B_3.focus();if(this.value.length==1)document.form39.QX1100B_5.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX1100B_5" value="<?php echo $QX1100B_5; ?>" onkeyup="if(this.value.length==0)document.form39.QX1100B_4.focus();if(this.value.length==1)document.form39.QX1100B_6.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX1100B_6" value="<?php echo $QX1100B_6; ?>" onkeyup="if(this.value.length==0)document.form39.QX1100B_5.focus();if(this.value.length==1)document.form39.QX1100B_7.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX1100B_7" value="<?php echo $QX1100B_7; ?>" onkeyup="if(this.value.length==0)document.form39.QX1100B_6.focus();if(this.value.length==1)document.form39.QX1100B_8.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX1100B_8" value="<?php echo $QX1100B_8; ?>" onkeyup="if(this.value.length==0)document.form39.QX1100B_7.focus();if(this.value.length==1)document.form39.QX1100B_9.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX1100B_9" value="<?php echo $QX1100B_9; ?>" onkeyup="if(this.value.length==0)document.form39.QX1100B_8.focus();if(this.value.length==1)document.form39.QX1100B_10.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX1100B_10" value="<?php echo $QX1100B_10; ?>" onkeyup="if(this.value.length==0)document.form39.QX1100B_9.focus();if(this.value.length==1)document.form39.QX1100B_11.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX1100B_11" value="<?php echo $QX1100B_11; ?>" onkeyup="if(this.value.length==0)document.form39.QX1100B_10.focus();if(this.value.length==1)document.form39.QX1100B_12.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX1100B_12" value="<?php echo $QX1100B_12; ?>" onkeyup="if(this.value.length==0)document.form39.QX1100B_11.focus();if(this.value.length==1)document.form39.QX1100B_13.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX1100B_13" value="<?php echo $QX1100B_13; ?>" onkeyup="if(this.value.length==0)document.form39.QX1100B_12.focus();if(this.value.length==1)document.form39.QX1100B_14.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX1100B_14" value="<?php echo $QX1100B_14; ?>" onkeyup="if(this.value.length==0)document.form39.QX1100B_13.focus();if(this.value.length==1)document.form39.QX1100B_15.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX1100B_15" value="<?php echo $QX1100B_15; ?>" onkeyup="if(this.value.length==0)document.form39.QX1100B_14.focus();if(this.value.length==1)document.form39.QX1100B_16.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX1100B_16" value="<?php echo $QX1100B_16; ?>" onkeyup="if(this.value.length==0)document.form39.QX1100B_15.focus();if(this.value.length==1)document.form39.QX1100B_17.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX1100B_17" value="<?php echo $QX1100B_17; ?>" onkeyup="if(this.value.length==0)document.form39.QX1100B_16.focus();if(this.value.length==1)document.form39.QX1100B_18.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX1100B_18" value="<?php echo $QX1100B_18; ?>" onkeyup="if(this.value.length==0)document.form39.QX1100B_17.focus();"></td>
</table>
</ul>			
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td> 
<ul>
<li value="3"><b>Attesting individual's title:</b><?php if (substr($url[3],0,5)!="print"){ if($X1100C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<table cellspacing="0">			
<td class="answer"><input type="text" size="105" name="QX1100C" value="<?php echo $QX1100C; ?>"></td>			
</table>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td>
<ul>
<li value="4"><b>Signature</b><?php if (substr($url[3],0,5)!="print"){ if($X1100D_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<table cellspacing="0">			
<td class="answer"><input type="text" size="105" name="QX1100D" value="<?php echo $QX1100D; ?>"></td>			
</table>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 	  
<td>
<ul>
<li value="5"><b>Attestation date</b>	<?php if (substr($url[3],0,5)!="print"){ if($X1100E_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
<table cellspacing="0"><br>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX1100E_1" value="<?php echo $QX1100E_1; ?>" onkeyup="if(this.value.length==1)document.form39.QX1100E_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX1100E_2" value="<?php echo $QX1100E_2; ?>" onkeyup="if(this.value.length==0)document.form39.QX1100E_1.focus();if(this.value.length==1)document.form39.QX1100E_3.focus();"></td>
<td>-</td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX1100E_3" value="<?php echo $QX1100E_3; ?>" onkeyup="if(this.value.length==0)document.form39.QX1100E_2.focus();if(this.value.length==1)document.form39.QX1100E_4.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX1100E_4" value="<?php echo $QX1100E_4; ?>" onkeyup="if(this.value.length==0)document.form39.QX1100E_3.focus();if(this.value.length==1)document.form39.QX1100E_5.focus();"></td>
<td>-</td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX1100E_5" value="<?php echo $QX1100E_5; ?>" onkeyup="if(this.value.length==0)document.form39.QX1100E_4.focus();if(this.value.length==1)document.form39.QX1100E_6.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX1100E_6" value="<?php echo $QX1100E_6; ?>" onkeyup="if(this.value.length==0)document.form39.QX1100E_5.focus();if(this.value.length==1)document.form39.QX1100E_7.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX1100E_7" value="<?php echo $QX1100E_7; ?>" onkeyup="if(this.value.length==0)document.form39.QX1100E_6.focus();if(this.value.length==1)document.form39.QX1100E_8.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX1100E_8" value="<?php echo $QX1100E_8; ?>" onkeyup="if(this.value.length==0)document.form39.QX1100E_7.focus();"></td>
</table>
<a style="padding-left:23px">Month</a><a style="padding-left:68px">Day</a><a style="padding-left:114px">Year</a>
</ul>			  
</td>
</tr>
</table>
<!-------------------------------------------->
<p align="center">
<input type="hidden" name="formID" id="formID" value="mdsform39">
<input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
<button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
<input type="reset" value="Reset"></p>
<p style="font-size:10px; color:black">MDS 3.0 Nursing Home Comprehensive (NC) Version 1.12.0 Effective 10/01/2014</p>
</form>
</body>