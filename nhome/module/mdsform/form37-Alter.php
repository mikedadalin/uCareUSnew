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
$sql = "SELECT * FROM `mdsform37` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
$db1 = new DB;
$db1->query($sql);
$r1 = $db1->fetch_assoc();
if ($db1->num_rows()>0) {
	foreach ($r1 as $k=>$v) {
		${$k} = $v;
	}
}
	/*== ¸Ñ START ==*/
	$LWJArray = array('QX0200A_1','QX0200A_2','QX0200A_3','QX0200A_4','QX0200A_5','QX0200A_6','QX0200A_7','QX0200A_8','QX0200A_9','QX0200A_10','QX0200A_11','QX0200A_12','QX0200C_1','QX0200C_2','QX0200C_3','QX0200C_4','QX0200C_5','QX0200C_6','QX0200C_7','QX0200C_8','QX0200C_9','QX0200C_10','QX0200C_11','QX0200C_12','QX0200C_13','QX0200C_14','QX0200C_15','QX0200C_16','QX0200C_17','QX0200C_18','QX0500_1','QX0500_2','QX0500_3','QX0500_4','QX0500_5','QX0500_6','QX0500_7','QX0500_8','QX0500_9');
	$LWJdataArray = array($QX0200A_1,$QX0200A_2,$QX0200A_3,$QX0200A_4,$QX0200A_5,$QX0200A_6,$QX0200A_7,$QX0200A_8,$QX0200A_9,$QX0200A_10,$QX0200A_11,$QX0200A_12,$QX0200C_1,$QX0200C_2,$QX0200C_3,$QX0200C_4,$QX0200C_5,$QX0200C_6,$QX0200C_7,$QX0200C_8,$QX0200C_9,$QX0200C_10,$QX0200C_11,$QX0200C_12,$QX0200C_13,$QX0200C_14,$QX0200C_15,$QX0200C_16,$QX0200C_17,$QX0200C_18,$QX0500_1,$QX0500_2,$QX0500_3,$QX0500_4,$QX0500_5,$QX0500_6,$QX0500_7,$QX0500_8,$QX0500_9);
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
td.answer {background-color:rgb(221,228,255); border:1px solid black; width:20px; height:20px; text-align:center}
td.answer2 {background-color:rgb(221,228,255); border:1px solid black; width:10px; height:10px; text-align:center}
td.part {background-color:rgb(230,230,226); height:20px; text-align:left; padding-left:5px}
td.partwhite {background-color:rgb(255,255,255); height:20px; text-align:left}
td.content {background-color:rgb(230,230,226); text-align:center; font-size:xx-small; width:70px}
td.content2 {background-color:rgb(230,230,226); text-align:left}
a.content3 {padding-left:5px; margin:0px}
ul {list-style:upper-alpha; padding:0px; padding-left:20px; margin:3px}
ol {list-style:decimal; padding:0px; padding-left:40px; margin:0px}
ol.zero {list-style:decimal-leading-zero; padding-left:5px; margin:0px}
td.sectiontop1 {border:0px solid black; width:300px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop2 {border:0px solid black; width:150px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop3 {border:0px solid black; width:100px; text-align:left; margin:0px; padding-left:10px}
</style>

<body>
<form name="form37" method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
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
<td class="part" colspan="2">
<b>Complete Section X only if A0050 = 2 or 3</b><br><b>Identification of Record to be Modified/Inactivated</b> - The following items identify the existing assessment record that is in error. In this <br>section, reproduce the information EXACTLY as it appeared on the existing erroneous record, even if the information is incorrect. <br>This information is necessary to locate the existing record in the National MDS Database.
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2"><b>X0150. Type of Provider</b> (A0200 on existing record to be modified/inactivated)</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content" width="70">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($X0150_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td width="800">
<a class="content3"><b>Type of provider</b></a>
<ol>
<li><input type="radio" name="QX0150" value="1" <?php if($QX0150=="1") echo "checked";?>><b>Nursing home (SNF/NF)</b>
<li><input type="radio" name="QX0150" value="2" <?php if($QX0150=="2") echo "checked";?>><b>Swing Bed</b>
</ol>			  
</td>
</tr>
<!-------------------------------------------->	
<tr>
<td class="part" colspan="2"><b>X0200. Name of Resident</b> (A0500 on existing record to be modified/inactivated)</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content"></td>
<td>
<ul>
<li><b>First name:</b><?php if (substr($url[3],0,5)!="print"){ if($X0200A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
<table cellspacing="0"><br>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0200A_1" value="<?php echo $QX0200A_1; ?>" onkeyup="if(this.value.length==1)document.form37.QX0200A_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0200A_2" value="<?php echo $QX0200A_2; ?>" onkeyup="if(this.value.length==0)document.form37.QX0200A_1.focus();if(this.value.length==1)document.form37.QX0200A_3.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0200A_3" value="<?php echo $QX0200A_3; ?>" onkeyup="if(this.value.length==0)document.form37.QX0200A_2.focus();if(this.value.length==1)document.form37.QX0200A_4.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0200A_4" value="<?php echo $QX0200A_4; ?>" onkeyup="if(this.value.length==0)document.form37.QX0200A_3.focus();if(this.value.length==1)document.form37.QX0200A_5.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0200A_5" value="<?php echo $QX0200A_5; ?>" onkeyup="if(this.value.length==0)document.form37.QX0200A_4.focus();if(this.value.length==1)document.form37.QX0200A_6.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0200A_6" value="<?php echo $QX0200A_6; ?>" onkeyup="if(this.value.length==0)document.form37.QX0200A_5.focus();if(this.value.length==1)document.form37.QX0200A_7.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0200A_7" value="<?php echo $QX0200A_7; ?>" onkeyup="if(this.value.length==0)document.form37.QX0200A_6.focus();if(this.value.length==1)document.form37.QX0200A_8.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0200A_8" value="<?php echo $QX0200A_8; ?>" onkeyup="if(this.value.length==0)document.form37.QX0200A_7.focus();if(this.value.length==1)document.form37.QX0200A_9.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0200A_9" value="<?php echo $QX0200A_9; ?>" onkeyup="if(this.value.length==0)document.form37.QX0200A_8.focus();if(this.value.length==1)document.form37.QX0200A_10.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0200A_10" value="<?php echo $QX0200A_10; ?>" onkeyup="if(this.value.length==0)document.form37.QX0200A_9.focus();if(this.value.length==1)document.form37.QX0200A_11.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0200A_11" value="<?php echo $QX0200A_11; ?>" onkeyup="if(this.value.length==0)document.form37.QX0200A_10.focus();if(this.value.length==1)document.form37.QX0200A_12.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0200A_12" value="<?php echo $QX0200A_12; ?>" onkeyup="if(this.value.length==0)document.form37.QX0200A_11.focus();"></td>
</table>
</ul>
<ul>
<li value="3"><b>Last name:</b><?php if (substr($url[3],0,5)!="print"){ if($X0200B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
<table cellspacing="0"><br>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0200C_1" value="<?php echo $QX0200C_1; ?>" onkeyup="if(this.value.length==1)document.form37.QX0200C_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0200C_2" value="<?php echo $QX0200C_2; ?>" onkeyup="if(this.value.length==0)document.form37.QX0200C_1.focus();if(this.value.length==1)document.form37.QX0200C_3.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0200C_3" value="<?php echo $QX0200C_3; ?>" onkeyup="if(this.value.length==0)document.form37.QX0200C_2.focus();if(this.value.length==1)document.form37.QX0200C_4.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0200C_4" value="<?php echo $QX0200C_4; ?>" onkeyup="if(this.value.length==0)document.form37.QX0200C_3.focus();if(this.value.length==1)document.form37.QX0200C_5.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0200C_5" value="<?php echo $QX0200C_5; ?>" onkeyup="if(this.value.length==0)document.form37.QX0200C_4.focus();if(this.value.length==1)document.form37.QX0200C_6.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0200C_6" value="<?php echo $QX0200C_6; ?>" onkeyup="if(this.value.length==0)document.form37.QX0200C_5.focus();if(this.value.length==1)document.form37.QX0200C_7.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0200C_7" value="<?php echo $QX0200C_7; ?>" onkeyup="if(this.value.length==0)document.form37.QX0200C_6.focus();if(this.value.length==1)document.form37.QX0200C_8.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0200C_8" value="<?php echo $QX0200C_8; ?>" onkeyup="if(this.value.length==0)document.form37.QX0200C_7.focus();if(this.value.length==1)document.form37.QX0200C_9.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0200C_9" value="<?php echo $QX0200C_9; ?>" onkeyup="if(this.value.length==0)document.form37.QX0200C_8.focus();if(this.value.length==1)document.form37.QX0200C_10.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0200C_10" value="<?php echo $QX0200C_10; ?>" onkeyup="if(this.value.length==0)document.form37.QX0200C_9.focus();if(this.value.length==1)document.form37.QX0200C_11.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0200C_11" value="<?php echo $QX0200C_11; ?>" onkeyup="if(this.value.length==0)document.form37.QX0200C_10.focus();if(this.value.length==1)document.form37.QX0200C_12.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0200C_12" value="<?php echo $QX0200C_12; ?>" onkeyup="if(this.value.length==0)document.form37.QX0200C_11.focus();if(this.value.length==1)document.form37.QX0200C_13.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0200C_13" value="<?php echo $QX0200C_13; ?>" onkeyup="if(this.value.length==0)document.form37.QX0200C_12.focus();if(this.value.length==1)document.form37.QX0200C_14.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0200C_14" value="<?php echo $QX0200C_14; ?>" onkeyup="if(this.value.length==0)document.form37.QX0200C_13.focus();if(this.value.length==1)document.form37.QX0200C_15.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0200C_15" value="<?php echo $QX0200C_15; ?>" onkeyup="if(this.value.length==0)document.form37.QX0200C_14.focus();if(this.value.length==1)document.form37.QX0200C_16.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0200C_16" value="<?php echo $QX0200C_16; ?>" onkeyup="if(this.value.length==0)document.form37.QX0200C_15.focus();if(this.value.length==1)document.form37.QX0200C_17.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0200C_17" value="<?php echo $QX0200C_17; ?>" onkeyup="if(this.value.length==0)document.form37.QX0200C_16.focus();if(this.value.length==1)document.form37.QX0200C_18.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0200C_18" value="<?php echo $QX0200C_18; ?>" onkeyup="if(this.value.length==0)document.form37.QX0200C_17.focus();"></td>
</table>	
</ul>			
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2"><b>X0300. Gender </b>(A0800 on existing record to be modified/inactivated)</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($X0300_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<ol>
<li><input type="radio" name="QX0300" value="1" <?php if($QX0300=="1") echo "checked";?>><b>Male</b>	
<li><input type="radio" name="QX0300" value="2" <?php if($QX0300=="2") echo "checked";?>><b>Female</b>
</ol>			  
</td>
</tr>
<!-------------------------------------------->	
<tr>
<td class="part" colspan="2"><b>X0400. Birth Date</b><?php if (substr($url[3],0,5)!="print"){ if($X0400_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?> (A0900 on existing record to be modified/inactivated)</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content"></td>
<td style="padding-left:25px">
<table cellspacing="0"><br>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0400_1" value="<?php echo $QX0400_1; ?>" onkeyup="if(this.value.length==1)document.form37.QX0400_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0400_2" value="<?php echo $QX0400_2; ?>" onkeyup="if(this.value.length==0)document.form37.QX0400_1.focus();if(this.value.length==1)document.form37.QX0400_3.focus();"></td>
<td>-</td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0400_3" value="<?php echo $QX0400_3; ?>" onkeyup="if(this.value.length==0)document.form37.QX0400_2.focus();if(this.value.length==1)document.form37.QX0400_4.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0400_4" value="<?php echo $QX0400_4; ?>" onkeyup="if(this.value.length==0)document.form37.QX0400_3.focus();if(this.value.length==1)document.form37.QX0400_5.focus();"></td>
<td>-</td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0400_5" value="<?php echo $QX0400_5; ?>" onkeyup="if(this.value.length==0)document.form37.QX0400_4.focus();if(this.value.length==1)document.form37.QX0400_6.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0400_6" value="<?php echo $QX0400_6; ?>" onkeyup="if(this.value.length==0)document.form37.QX0400_5.focus();if(this.value.length==1)document.form37.QX0400_7.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0400_7" value="<?php echo $QX0400_7; ?>" onkeyup="if(this.value.length==0)document.form37.QX0400_6.focus();if(this.value.length==1)document.form37.QX0400_8.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0400_8" value="<?php echo $QX0400_8; ?>" onkeyup="if(this.value.length==0)document.form37.QX0400_7.focus();"></td>
</table>
<a style="padding-left:23px">Month</a><a style="padding-left:68px">Day</a><a style="padding-left:114px">Year</a>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2"><b>X0500. Social Security Number</b><?php if (substr($url[3],0,5)!="print"){ if($X0500_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?> (A0600A on existing record to be modified/inactivated)</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content"></td>
<td style="padding-left:25px">
<table cellspacing="0"><br>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0500_1" value="<?php echo $QX0500_1; ?>" onkeyup="if(this.value.length==1)document.form37.QX0500_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0500_2" value="<?php echo $QX0500_2; ?>" onkeyup="if(this.value.length==0)document.form37.QX0500_1.focus();if(this.value.length==1)document.form37.QX0500_3.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0500_3" value="<?php echo $QX0500_3; ?>" onkeyup="if(this.value.length==0)document.form37.QX0500_2.focus();if(this.value.length==1)document.form37.QX0500_4.focus();"></td>
<td>-</td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0500_4" value="<?php echo $QX0500_4; ?>" onkeyup="if(this.value.length==0)document.form37.QX0500_3.focus();if(this.value.length==1)document.form37.QX0500_5.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0500_5" value="<?php echo $QX0500_5; ?>" onkeyup="if(this.value.length==0)document.form37.QX0500_4.focus();if(this.value.length==1)document.form37.QX0500_6.focus();"></td>
<td>-</td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0500_6" value="<?php echo $QX0500_6; ?>" onkeyup="if(this.value.length==0)document.form37.QX0500_5.focus();if(this.value.length==1)document.form37.QX0500_7.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0500_7" value="<?php echo $QX0500_7; ?>" onkeyup="if(this.value.length==0)document.form37.QX0500_6.focus();if(this.value.length==1)document.form37.QX0500_8.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0500_8" value="<?php echo $QX0500_8; ?>" onkeyup="if(this.value.length==0)document.form37.QX0500_7.focus();if(this.value.length==1)document.form37.QX0500_9.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0500_9" value="<?php echo $QX0500_9; ?>" onkeyup="if(this.value.length==0)document.form37.QX0500_8.focus();"></td>
</table><br>	  
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2"><b>X0600. Type of Assessment</b> (A0310 on existing record to be modified/inactivated)</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($X0600A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($X0600A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<ul>
<li><b>Federal OBRA Reason for Assessment</b>
</ul>
<ol class="zero" style="padding-left:45px">
<li><input type="radio" name="QX0600A" value="01" <?php if($QX0600A=="01") echo "checked";?>><b>Admission</b> assessment (required by day 14)
<li><input type="radio" name="QX0600A" value="02" <?php if($QX0600A=="02") echo "checked";?>><b>Quarterly</b> review assessment
<li><input type="radio" name="QX0600A" value="03" <?php if($QX0600A=="03") echo "checked";?>><b>Annual</b> assessment
<li><input type="radio" name="QX0600A" value="04" <?php if($QX0600A=="04") echo "checked";?>><b>Significant change in status</b> assessment
<li><input type="radio" name="QX0600A" value="05" <?php if($QX0600A=="05") echo "checked";?>><b>Significant correction</b> to <b>prior comprehensive</b> assessment
<li><input type="radio" name="QX0600A" value="06" <?php if($QX0600A=="06") echo "checked";?>><b>Significant correction</b> to <b>prior quarterly</b> assessment</b>
<li value="99"><input type="radio" name="QX0600A" value="99" <?php if($QX0600A=="99") echo "checked";?>><b>None of the above</b>
</ol>			  
</td>
</tr>
<!-------------------------------------------->	
<tr> 
<td class="content">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($X0600B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($X0600B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<ul>
<li value="2"><b>PPS Assessment</b>
</ul>
<ol class="zero">
<b style="padding-left:18px"><u>PPS</u> <u>Scheduled</u> <u>Assessments</u> <u>for</u> <u>a</u> <u>Medicare</u> <u>Part</u> <u>A</u> <u>Stay</u></b>
<dd>
<li><input type="radio" name="QX0600B" value="01" <?php if($QX0600B=="01") echo "checked";?>><b>5-day</b> scheduled assessment
<li><input type="radio" name="QX0600B" value="02" <?php if($QX0600B=="02") echo "checked";?>><b>14-day</b> scheduled assessment
<li><input type="radio" name="QX0600B" value="03" <?php if($QX0600B=="03") echo "checked";?>><b>30-day</b> scheduled assessment
<li><input type="radio" name="QX0600B" value="04" <?php if($QX0600B=="04") echo "checked";?>><b>60-day</b> scheduled assessment
<li><input type="radio" name="QX0600B" value="05" <?php if($QX0600B=="05") echo "checked";?>><b>90-day</b> scheduled assessment
</dd>
<b style="padding-left:18px"><u>PPS</u> <u>Unscheduled</u> <u>Assessments</u> <u>for</u> <u>a</u> <u>Medicare</u> <u>Part</u> <u>A</u> <u>Stay</u></b>
<dd>
<li value="7"><input type="radio" name="QX0600B" value="07" <?php if($QX0600B=="07") echo "checked";?>><b>Unscheduled assessment used for PPS</b> (OMRA, significant or clinical change, or significant correction assessment)
</dd>
<b style="padding-left:18px"><u>Not</u> <u>PPS</u> <u>Assessment</u></b>
<dd>
<li value="99"><input type="radio" name="QX0600B" value="99" <?php if($QX0600B=="99") echo "checked";?>><b>None of the above</b>
</dd>
</ol>			  
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($X0600C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<ul>
<li value="3"><b>PPS Other Medicare Required Assessment - OMRA</b>
</ul>
<ol start="0">
<li><input type="radio" name="QX0600C" value="0" <?php if($QX0600C=="0") echo "checked";?>><b>No</b>	
<li><input type="radio" name="QX0600C" value="1" <?php if($QX0600C=="1") echo "checked";?>><b>Start of therapy</b> assessment
<li><input type="radio" name="QX0600C" value="2" <?php if($QX0600C=="2") echo "checked";?>><b>End of therapy</b> assessment
<li><input type="radio" name="QX0600C" value="3" <?php if($QX0600C=="3") echo "checked";?>><b>Both Start and End of therapy</b> assessment
<li><input type="radio" name="QX0600C" value="4" <?php if($QX0600C=="4") echo "checked";?>><b>Change of therapy</b> assessment	
</ol>			  
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2"><b>X0600 continued on next page</b></td>
</tr>
</table>
<!-------------------------------------------->
<p align="center">
<input type="hidden" name="formID" id="formID" value="mdsform37">
<input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
<button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
<input type="reset" value="Reset"></p>
<p style="font-size:10px; color:black">MDS 3.0 Nursing Home Comprehensive (NC) Version 1.12.0 Effective 10/01/2014</p>
</form>
</body>
