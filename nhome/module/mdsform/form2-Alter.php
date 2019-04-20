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
$sql = "SELECT * FROM `mdsform02` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
$db1 = new DB;
$db1->query($sql);
$r1 = $db1->fetch_assoc();
if ($db1->num_rows()>0) {
	foreach ($r1 as $k=>$v) {
		${$k} = $v;
	}
}
	/*== ¸Ñ START ==*/
	$LWJArray = array('QA0500A_1','QA0500A_2','QA0500A_3','QA0500A_4','QA0500A_5','QA0500A_6','QA0500A_7','QA0500A_8','QA0500A_9','QA0500A_10','QA0500A_11','QA0500A_12','QA0500B','QA0500C_1','QA0500C_2','QA0500C_3','QA0500C_4','QA0500C_5','QA0500C_6','QA0500C_7','QA0500C_8','QA0500C_9','QA0500C_10','QA0500C_11','QA0500C_12','QA0500C_13','QA0500C_14','QA0500C_15','QA0500C_16','QA0500C_17','QA0500C_18','QA0500D_1','QA0500D_2','QA0500D_3','QA0600A_1','QA0600A_2','QA0600A_3','QA0600A_4','QA0600A_5','QA0600A_6','QA0600A_7','QA0600A_8','QA0600A_9','QA0600B_1','QA0600B_2','QA0600B_3','QA0600B_4','QA0600B_5','QA0600B_6','QA0600B_7','QA0600B_8','QA0600B_9','QA0600B_10','QA0600B_11','QA0600B_12','QA0700_1','QA0700_2','QA0700_3','QA0700_4','QA0700_5','QA0700_6','QA0700_7','QA0700_8','QA0700_9','QA0700_10','QA0700_11','QA0700_12');
	$LWJdataArray = array($QA0500A_1,$QA0500A_2,$QA0500A_3,$QA0500A_4,$QA0500A_5,$QA0500A_6,$QA0500A_7,$QA0500A_8,$QA0500A_9,$QA0500A_10,$QA0500A_11,$QA0500A_12,$QA0500B,$QA0500C_1,$QA0500C_2,$QA0500C_3,$QA0500C_4,$QA0500C_5,$QA0500C_6,$QA0500C_7,$QA0500C_8,$QA0500C_9,$QA0500C_10,$QA0500C_11,$QA0500C_12,$QA0500C_13,$QA0500C_14,$QA0500C_15,$QA0500C_16,$QA0500C_17,$QA0500C_18,$QA0500D_1,$QA0500D_2,$QA0500D_3,$QA0600A_1,$QA0600A_2,$QA0600A_3,$QA0600A_4,$QA0600A_5,$QA0600A_6,$QA0600A_7,$QA0600A_8,$QA0600A_9,$QA0600B_1,$QA0600B_2,$QA0600B_3,$QA0600B_4,$QA0600B_5,$QA0600B_6,$QA0600B_7,$QA0600B_8,$QA0600B_9,$QA0600B_10,$QA0600B_11,$QA0600B_12,$QA0700_1,$QA0700_2,$QA0700_3,$QA0700_4,$QA0700_5,$QA0700_6,$QA0700_7,$QA0700_8,$QA0700_9,$QA0700_10,$QA0700_11,$QA0700_12);
	for($i=0;$i<count($LWJdataArray);$i++){
	    $rsa = new lwj('lwj/lwj');
	    $puepart = explode(" ",$LWJdataArray[$i]);
	    $puepartcount = count($puepart);
	    if($puepartcount>1){
            for($j=0;$j<$puepartcount;$j++){
                $prdpart = $rsa->privDecrypt($puepart[$j]);
                ${$LWJArray[$i]} = ${$LWJArray[$i]}.$prdpart;
            }
	    }else{
		   ${$LWJArray[$i]} = $rsa->privDecrypt($LWJdataArray[$i]);
	    }
	}
	/*== ¸Ñ END ==*/
?>
<style>
body {font-family:sans-serif; line-height:15px; font-size:9px}
table.bordercolor {border-color:rgb(113,113,99); background-color:rgb(255,255,255);}
td.section {background-color:rgb(113,113,99); color:white; font-size:14px; padding-left:5px}
td.section2 {background-color:rgb(230,230,226); font-size:14px}
td.answer {background-color:rgb(221,228,255); border:1px solid black; width:20px; height:20px}
td.answer2 {background-color:rgb(221,228,255); border:1px solid black; width:10px; height:10px}
td.part {background-color:rgb(230,230,226); height:20px; text-align:left; padding-left:5px}
td.partwhite {background-color:rgb(255,255,255); height:20px; text-align:left; padding-left:32px}
td.content {background-color:rgb(230,230,226); text-align:center; font-size:xx-small; width:70px}
ul {list-style:upper-alpha; padding:0px; padding-left:20px; margin:0px}
ol {list-style:decimal; padding:0px; padding-left:35px; margin:0px}
ol.zero {list-style:decimal-leading-zero; padding-left:42px}
td.sectiontop1 {border:0px solid black; width:300px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop2 {border:0px solid black; width:150px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop3 {border:0px solid black; width:100px; text-align:left; margin:0px; padding-left:10px}
</style>
<body>
<form name="form2" method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<table cellspacing="0" align="center" style="font-size:16px"><tr><td>Resident:</td><td class="sectiontop1"><font size="3"><b><?php echo $name; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Identifier:</td><td class="sectiontop2"><font size="3"><b><?php echo $_SESSION['ncareName_lwj']; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Date:</td><td class="sectiontop3"><font size="3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script></font><input type="text" size="18" name="date" id="date" value="<?php echo formatdate_Ymd_Slash($date);?>"></b></font><hr color="black" align="left" width="100%" size="1"></td></tr></table>
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1" style="margin-bottom:3px">
<tr>
<td class="section2" width="152"><b style="padding-left:5px">Section A</b></td>
<td class="section2" width="730"><b style="padding-left:5px">Identification Information</b></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1">
<tr>
<td class="part" colspan="2"><b>A0310. Type of Assessment - Continued</b></td>
</tr>
<!----------------------------------------------------->
<tr>
<td class="content" valign="top" width="70">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"></td>
</table>
</td>
<td width="800">
<ul>
<li value="5"><b>Is this assessment the first assessment</b> (OBRA, PPS, or Discharge) <b>since the most recent admission?</b>
</ul>
<ol start="0">		    
<li><input type="radio" name="QA0310E" value="0" <?php if($QA0310E=="0") echo "checked";?>><b>No</b>
<li><input type="radio" name="QA0310E" value="1" <?php if($QA0310E=="1") echo "checked";?>><b>Yes</b>
</ol>
</td>
</tr>
<!----------------------------------------------------->
<tr>
<td class="content" valign="top">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"></td>
<td class="answer"></td>
</table>
</td>
<td>
<ul>
<li value="6"><b>Entry/discharge reporting</b>
</ul>
<ol class="zero">
<li><input type="radio" name="QA0310F" value="01" <?php if($QA0310F=="01") echo "checked";?>><b>Entry</b> record
<li value="10"><input type="radio" name="QA0310F" value="10" <?php if($QA0310F=="10") echo "checked";?>><b>Discharge</b> assessment-<b>return not anticipated</b>
<li value="11"><input type="radio" name="QA0310F" value="11" <?php if($QA0310F=="11") echo "checked";?>><b>Discharge</b> assessment-<b>return anticipated</b>
<li value="12"><input type="radio" name="QA0310F" value="12" <?php if($QA0310F=="12") echo "checked";?>><b>Death in facility</b> record
<li value="99"><input type="radio" name="QA0310F" value="99" <?php if($QA0310F=="99") echo "checked";?>><b>Not entry/discharge</b> record		 
</ol>		  
</td>
</tr>
<!----------------------------------------------------->
<tr>
<td class="content" valign="top">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($A0310G_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<ul>
<li value="7"><b>Type of discharge</b> - Complete only if A0310F = 10 or 11
</ul>
<ol>		    
<li><input type="radio" name="QA0310G" value="1" <?php if($QA0310G=="1") echo "checked";?>><b>Planned</b>
<li><input type="radio" name="QA0310G" value="2" <?php if($QA0310G=="2") echo "checked";?>><b>Unplanned</b>
</ol>
</td>
</tr>
<!----------------------------------------------------->
<tr>
<td class="part" colspan="3"><b>A0410. Submission Requirement</b></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="content" valign="top">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($A0410_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td colspan="2">
<ol>
<li><input type="radio" name="QA0410" value="1" <?php if($QA0410=="1") echo "checked";?>><b>Unit is neither Medicare nor Medicaid certified and MDS data is not required by the State</b>
<li><input type="radio" name="QA0410" value="2" <?php if($QA0410=="2") echo "checked";?>><b>Unit is neither Medicare nor Medicaid certified but MDS data is required by the State</b>
<li><input type="radio" name="QA0410" value="3" <?php if($QA0410=="3") echo "checked";?>><b>Unit is Medicare and/or Medicaid certified</b>
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td  class="part" colspan="3"><b>A0500. Legal Name of Resident</b></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="content"></td>
<td>
<ul>
<li><b>First name:</b><?php if (substr($url[3],0,5)!="print"){ if($A0500A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<table cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0500A_1" value="<?php echo $QA0500A_1; ?>" onkeyup="if(this.value.length==1)document.form2.QA0500A_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0500A_2" value="<?php echo $QA0500A_2; ?>" onkeyup="if(this.value.length==0)document.form2.QA0500A_1.focus();if(this.value.length==1)document.form2.QA0500A_3.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0500A_3" value="<?php echo $QA0500A_3; ?>" onkeyup="if(this.value.length==0)document.form2.QA0500A_2.focus();if(this.value.length==1)document.form2.QA0500A_4.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0500A_4" value="<?php echo $QA0500A_4; ?>" onkeyup="if(this.value.length==0)document.form2.QA0500A_3.focus();if(this.value.length==1)document.form2.QA0500A_5.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0500A_5" value="<?php echo $QA0500A_5; ?>" onkeyup="if(this.value.length==0)document.form2.QA0500A_4.focus();if(this.value.length==1)document.form2.QA0500A_6.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0500A_6" value="<?php echo $QA0500A_6; ?>" onkeyup="if(this.value.length==0)document.form2.QA0500A_5.focus();if(this.value.length==1)document.form2.QA0500A_7.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0500A_7" value="<?php echo $QA0500A_7; ?>" onkeyup="if(this.value.length==0)document.form2.QA0500A_6.focus();if(this.value.length==1)document.form2.QA0500A_8.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0500A_8" value="<?php echo $QA0500A_8; ?>" onkeyup="if(this.value.length==0)document.form2.QA0500A_7.focus();if(this.value.length==1)document.form2.QA0500A_9.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0500A_9" value="<?php echo $QA0500A_9; ?>" onkeyup="if(this.value.length==0)document.form2.QA0500A_8.focus();if(this.value.length==1)document.form2.QA0500A_10.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0500A_10" value="<?php echo $QA0500A_10; ?>" onkeyup="if(this.value.length==0)document.form2.QA0500A_9.focus();if(this.value.length==1)document.form2.QA0500A_11.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0500A_11" value="<?php echo $QA0500A_11; ?>" onkeyup="if(this.value.length==0)document.form2.QA0500A_10.focus();if(this.value.length==1)document.form2.QA0500A_12.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0500A_12" value="<?php echo $QA0500A_12; ?>" onkeyup="if(this.value.length==0)document.form2.QA0500A_11.focus();"></td>
</table>
<li><b>Middle initial:</b><br>
<table cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0500B" value="<?php echo $QA0500B; ?>"></td>
</table>
<li><b>Last name:</b><?php if (substr($url[3],0,5)!="print"){ if($A0500C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<table cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0500C_1" value="<?php echo $QA0500C_1; ?>" onkeyup="if(this.value.length==1)document.form2.QA0500C_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0500C_2" value="<?php echo $QA0500C_2; ?>" onkeyup="if(this.value.length==0)document.form2.QA0500C_1.focus();if(this.value.length==1)document.form2.QA0500C_3.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0500C_3" value="<?php echo $QA0500C_3; ?>" onkeyup="if(this.value.length==0)document.form2.QA0500C_2.focus();if(this.value.length==1)document.form2.QA0500C_4.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0500C_4" value="<?php echo $QA0500C_4; ?>" onkeyup="if(this.value.length==0)document.form2.QA0500C_3.focus();if(this.value.length==1)document.form2.QA0500C_5.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0500C_5" value="<?php echo $QA0500C_5; ?>" onkeyup="if(this.value.length==0)document.form2.QA0500C_4.focus();if(this.value.length==1)document.form2.QA0500C_6.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0500C_6" value="<?php echo $QA0500C_6; ?>" onkeyup="if(this.value.length==0)document.form2.QA0500C_5.focus();if(this.value.length==1)document.form2.QA0500C_7.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0500C_7" value="<?php echo $QA0500C_7; ?>" onkeyup="if(this.value.length==0)document.form2.QA0500C_6.focus();if(this.value.length==1)document.form2.QA0500C_8.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0500C_8" value="<?php echo $QA0500C_8; ?>" onkeyup="if(this.value.length==0)document.form2.QA0500C_7.focus();if(this.value.length==1)document.form2.QA0500C_9.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0500C_9" value="<?php echo $QA0500C_9; ?>" onkeyup="if(this.value.length==0)document.form2.QA0500C_8.focus();if(this.value.length==1)document.form2.QA0500C_10.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0500C_10" value="<?php echo $QA0500C_10; ?>" onkeyup="if(this.value.length==0)document.form2.QA0500C_9.focus();if(this.value.length==1)document.form2.QA0500C_11.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0500C_11" value="<?php echo $QA0500C_11; ?>" onkeyup="if(this.value.length==0)document.form2.QA0500C_10.focus();if(this.value.length==1)document.form2.QA0500C_12.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0500C_12" value="<?php echo $QA0500C_12; ?>" onkeyup="if(this.value.length==0)document.form2.QA0500C_11.focus();if(this.value.length==1)document.form2.QA0500C_13.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0500C_13" value="<?php echo $QA0500C_13; ?>" onkeyup="if(this.value.length==0)document.form2.QA0500C_12.focus();if(this.value.length==1)document.form2.QA0500C_14.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0500C_14" value="<?php echo $QA0500C_14; ?>" onkeyup="if(this.value.length==0)document.form2.QA0500C_13.focus();if(this.value.length==1)document.form2.QA0500C_15.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0500C_15" value="<?php echo $QA0500C_15; ?>" onkeyup="if(this.value.length==0)document.form2.QA0500C_14.focus();if(this.value.length==1)document.form2.QA0500C_16.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0500C_16" value="<?php echo $QA0500C_16; ?>" onkeyup="if(this.value.length==0)document.form2.QA0500C_15.focus();if(this.value.length==1)document.form2.QA0500C_17.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0500C_17" value="<?php echo $QA0500C_17; ?>" onkeyup="if(this.value.length==0)document.form2.QA0500C_16.focus();if(this.value.length==1)document.form2.QA0500C_18.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0500C_18" value="<?php echo $QA0500C_18; ?>" onkeyup="if(this.value.length==0)document.form2.QA0500C_17.focus();"></td>
</table>
<li><b>Suffix:</b><br>
<table cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0500D_1" value="<?php echo $QA0500D_1; ?>" onkeyup="if(this.value.length==1)document.form2.QA0500D_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0500D_2" value="<?php echo $QA0500D_2; ?>" onkeyup="if(this.value.length==0)document.form2.QA0500D_1.focus();if(this.value.length==1)document.form2.QA0500D_3.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0500D_3" value="<?php echo $QA0500D_3; ?>" onkeyup="if(this.value.length==0)document.form2.QA0500D_2.focus();"></td>
</table>
</ul>
</td>
</tr>
<!-------------------------------------------------------------------------->	  
<tr>
<td class="part" colspan="3"><b>A0600. Social Security and Medicare Numbers</b></td>
</tr>
<!-------------------------------------------------------------------------->	  
<tr>
<td class="content"></td>
<td>
<ul>
<li><b>Social Security Number:</b><?php if (substr($url[3],0,5)!="print"){ if($A0600A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<table cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0600A_1" value="<?php echo $QA0600A_1; ?>" onkeyup="if(this.value.length==1)document.form2.QA0600A_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0600A_2" value="<?php echo $QA0600A_2; ?>" onkeyup="if(this.value.length==0)document.form2.QA0600A_1.focus();if(this.value.length==1)document.form2.QA0600A_3.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0600A_3" value="<?php echo $QA0600A_3; ?>" onkeyup="if(this.value.length==0)document.form2.QA0600A_2.focus();if(this.value.length==1)document.form2.QA0600A_4.focus();"></td>
<td>-</td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0600A_4" value="<?php echo $QA0600A_4; ?>" onkeyup="if(this.value.length==0)document.form2.QA0600A_3.focus();if(this.value.length==1)document.form2.QA0600A_5.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0600A_5" value="<?php echo $QA0600A_5; ?>" onkeyup="if(this.value.length==0)document.form2.QA0600A_4.focus();if(this.value.length==1)document.form2.QA0600A_6.focus();"></td>
<td>-</td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0600A_6" value="<?php echo $QA0600A_6; ?>" onkeyup="if(this.value.length==0)document.form2.QA0600A_5.focus();if(this.value.length==1)document.form2.QA0600A_7.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0600A_7" value="<?php echo $QA0600A_7; ?>" onkeyup="if(this.value.length==0)document.form2.QA0600A_6.focus();if(this.value.length==1)document.form2.QA0600A_8.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0600A_8" value="<?php echo $QA0600A_8; ?>" onkeyup="if(this.value.length==0)document.form2.QA0600A_7.focus();if(this.value.length==1)document.form2.QA0600A_9.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0600A_9" value="<?php echo $QA0600A_9; ?>" onkeyup="if(this.value.length==0)document.form2.QA0600A_8.focus();"></td>
</table>
<li><b>Medicare number (or comparable railroad insurance number):</b><?php if (substr($url[3],0,5)!="print"){ if($A0600B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<table cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0600B_1" value="<?php echo $QA0600B_1; ?>" onkeyup="if(this.value.length==1)document.form2.QA0600B_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0600B_2" value="<?php echo $QA0600B_2; ?>" onkeyup="if(this.value.length==0)document.form2.QA0600B_1.focus();if(this.value.length==1)document.form2.QA0600B_3.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0600B_3" value="<?php echo $QA0600B_3; ?>" onkeyup="if(this.value.length==0)document.form2.QA0600B_2.focus();if(this.value.length==1)document.form2.QA0600B_4.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0600B_4" value="<?php echo $QA0600B_4; ?>" onkeyup="if(this.value.length==0)document.form2.QA0600B_3.focus();if(this.value.length==1)document.form2.QA0600B_5.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0600B_5" value="<?php echo $QA0600B_5; ?>" onkeyup="if(this.value.length==0)document.form2.QA0600B_4.focus();if(this.value.length==1)document.form2.QA0600B_6.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0600B_6" value="<?php echo $QA0600B_6; ?>" onkeyup="if(this.value.length==0)document.form2.QA0600B_5.focus();if(this.value.length==1)document.form2.QA0600B_7.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0600B_7" value="<?php echo $QA0600B_7; ?>" onkeyup="if(this.value.length==0)document.form2.QA0600B_6.focus();if(this.value.length==1)document.form2.QA0600B_8.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0600B_8" value="<?php echo $QA0600B_8; ?>" onkeyup="if(this.value.length==0)document.form2.QA0600B_7.focus();if(this.value.length==1)document.form2.QA0600B_9.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0600B_9" value="<?php echo $QA0600B_9; ?>" onkeyup="if(this.value.length==0)document.form2.QA0600B_8.focus();if(this.value.length==1)document.form2.QA0600B_10.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0600B_10" value="<?php echo $QA0600B_10; ?>" onkeyup="if(this.value.length==0)document.form2.QA0600B_9.focus();if(this.value.length==1)document.form2.QA0600B_11.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0600B_11" value="<?php echo $QA0600B_11; ?>" onkeyup="if(this.value.length==0)document.form2.QA0600B_10.focus();if(this.value.length==1)document.form2.QA0600B_12.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0600B_12" value="<?php echo $QA0600B_12; ?>" onkeyup="if(this.value.length==0)document.form2.QA0600B_11.focus();"></td>
</table>
</ul>
</td>
</tr>
<!-------------------------------------------------------------------------->	
<tr>
<td class="part" colspan="3"><b>A0700. Medicaid Number</b>- Enter "+" if pending, "N" if not a Medicaid recipient<?php if (substr($url[3],0,5)!="print"){ if($A0700_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
<!-------------------------------------------------------------------------->
<tr>
<td class="content"></td>
<td style="height:30px">
<table cellspacing="0" style="padding-left:20px; margin:3px">
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0700_1" value="<?php echo $QA0700_1; ?>" onkeyup="if(this.value.length==1)document.form2.QA0700_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0700_2" value="<?php echo $QA0700_2; ?>" onkeyup="if(this.value.length==0)document.form2.QA0700_1.focus();if(this.value.length==1)document.form2.QA0700_3.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0700_3" value="<?php echo $QA0700_3; ?>" onkeyup="if(this.value.length==0)document.form2.QA0700_2.focus();if(this.value.length==1)document.form2.QA0700_4.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0700_4" value="<?php echo $QA0700_4; ?>" onkeyup="if(this.value.length==0)document.form2.QA0700_3.focus();if(this.value.length==1)document.form2.QA0700_5.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0700_5" value="<?php echo $QA0700_5; ?>" onkeyup="if(this.value.length==0)document.form2.QA0700_4.focus();if(this.value.length==1)document.form2.QA0700_6.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0700_6" value="<?php echo $QA0700_6; ?>" onkeyup="if(this.value.length==0)document.form2.QA0700_5.focus();if(this.value.length==1)document.form2.QA0700_7.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0700_7" value="<?php echo $QA0700_7; ?>" onkeyup="if(this.value.length==0)document.form2.QA0700_6.focus();if(this.value.length==1)document.form2.QA0700_8.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0700_8" value="<?php echo $QA0700_8; ?>" onkeyup="if(this.value.length==0)document.form2.QA0700_7.focus();if(this.value.length==1)document.form2.QA0700_9.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0700_9" value="<?php echo $QA0700_9; ?>" onkeyup="if(this.value.length==0)document.form2.QA0700_8.focus();if(this.value.length==1)document.form2.QA0700_10.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0700_10" value="<?php echo $QA0700_10; ?>" onkeyup="if(this.value.length==0)document.form2.QA0700_9.focus();if(this.value.length==1)document.form2.QA0700_11.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0700_11" value="<?php echo $QA0700_11; ?>" onkeyup="if(this.value.length==0)document.form2.QA0700_10.focus();if(this.value.length==1)document.form2.QA0700_12.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0700_12" value="<?php echo $QA0700_12; ?>" onkeyup="if(this.value.length==0)document.form2.QA0700_11.focus();"></td>
</table>
</td>
</tr>
<!-------------------------------------------------------------------------->	
<tr>
<td class="part" colspan="3"><b>A0800. Gender</b></td>
</tr>
<!-------------------------------------------------------------------------->
<tr>
<td class="content" valign="top">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($A0800_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td  colspan="2">
<ol>
<li><input type="radio" name="QA0800" value="1" <?php if($QA0800=="1") echo "checked";?>><b>Male</b>
<li><input type="radio" name="QA0800" value="2" <?php if($QA0800=="2") echo "checked";?>><b>Female</b>
</ol>
</td>
</tr>
<!-------------------------------------------------------------------------->
<tr>
<td class="part" colspan="3"><b>A0900. Birth Date</b><?php if (substr($url[3],0,5)!="print"){ if($A0900_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
<!-------------------------------------------------------------------------->
<tr>
<td class="content"></td>
<td>
<table cellspacing="0" style="padding-left:20px; margin:3px">
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0900_1" value="<?php echo $QA0900_1; ?>" onkeyup="if(this.value.length==1)document.form2.QA0900_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0900_2" value="<?php echo $QA0900_2; ?>" onkeyup="if(this.value.length==0)document.form2.QA0900_1.focus();if(this.value.length==1)document.form2.QA0900_3.focus();"></td>
<td>-</td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0900_3" value="<?php echo $QA0900_3; ?>" onkeyup="if(this.value.length==0)document.form2.QA0900_2.focus();if(this.value.length==1)document.form2.QA0900_4.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0900_4" value="<?php echo $QA0900_4; ?>" onkeyup="if(this.value.length==0)document.form2.QA0900_3.focus();if(this.value.length==1)document.form2.QA0900_5.focus();"></td>
<td>-</td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0900_5" value="<?php echo $QA0900_5; ?>" onkeyup="if(this.value.length==0)document.form2.QA0900_4.focus();if(this.value.length==1)document.form2.QA0900_6.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0900_6" value="<?php echo $QA0900_6; ?>" onkeyup="if(this.value.length==0)document.form2.QA0900_5.focus();if(this.value.length==1)document.form2.QA0900_7.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0900_7" value="<?php echo $QA0900_7; ?>" onkeyup="if(this.value.length==0)document.form2.QA0900_6.focus();if(this.value.length==1)document.form2.QA0900_8.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA0900_8" value="<?php echo $QA0900_8; ?>" onkeyup="if(this.value.length==0)document.form2.QA0900_7.focus();"></td>
</table>
<a style="padding-left:47px">Month</a><a style="padding-left:68px">Day</a><a style="padding-left:114px">Year</a>
</td>
</tr>
<!-------------------------------------------------------------------------->
<tr>
<td class="part" colspan="3"><b>A1000. Race/Ethnicity</b><?php if (substr($url[3],0,5)!="print"){ if($A1000_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
<!-------------------------------------------------------------------------->	
<tr>
<td class="partwhite" colspan="3"><b>&#8595; Check all that apply</b></td>
</tr>
<!-------------------------------------------------------------------------->	
<tr>
<td class="content" valign="top">
<input type="radio" name="QA1000" value="A" <?php if($QA1000=="A") echo "checked";?>>
</td>
<td  colspan="2">
<ul>
<li><b>American Indian or Alaska Native</b>
</ul>
</td>
</tr>
<tr>
<td class="content" valign="top">
<input type="radio" name="QA1000" value="B" <?php if($QA1000=="B") echo "checked";?>>
</td>
<td  colspan="2">
<ul>
<li value="2"><b>Asian</b>
</ul>
</td>
</tr>
<tr>
<td class="content" valign="top">
<input type="radio" name="QA1000" value="C" <?php if($QA1000=="C") echo "checked";?>>
</td>
<td  colspan="2">
<ul>
<li value="3"><b>Black or African American</b>
</ul>
</td>
</tr>
<tr>
<td class="content" valign="top">
<input type="radio" name="QA1000" value="D" <?php if($QA1000=="D") echo "checked";?>>
</td>
<td  colspan="2">
<ul>
<li value="4"><b>Hispanic or Latino</b>
</ul>
</td>
</tr>
<tr>
<td class="content" valign="top">
<input type="radio" name="QA1000" value="E" <?php if($QA1000=="E") echo "checked";?>>
</td>
<td  colspan="2">
<ul>
<li value="5"><b>Native Hawaiian or Other Pacific Islander</b>
</ul>
</td>
</tr>
<tr>
<td class="content" valign="top">
<input type="radio" name="QA1000" value="F" <?php if($QA1000=="F") echo "checked";?>>
</td>
<td  colspan="2">
<ul>
<li value="6"><b>White</b>
</ul>
</td>
</tr>
<!-------------------------------------------------------------------------->	
</table>
<p align="center">
<input type="hidden" name="formID" id="formID" value="mdsform02">
<input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
<button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
<input type="reset" value="Reset"></p>
<p style="font-size:10px; color:black">MDS 3.0 Nursing Home Comprehensive (NC) Version 1.12.0 Effective 10/01/2014</p>
</form>
</body>