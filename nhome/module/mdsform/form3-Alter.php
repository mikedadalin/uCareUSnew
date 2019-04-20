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
$sql = "SELECT * FROM `mdsform03` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
$db1 = new DB;
$db1->query($sql);
$r1 = $db1->fetch_assoc();
if ($db1->num_rows()>0) {
	foreach ($r1 as $k=>$v) {
		${$k} = $v;
	}
}
	/*== ¸Ñ START ==*/
	$LWJArray = array('QA1300A_1','QA1300A_2','QA1300A_3','QA1300A_4','QA1300A_5','QA1300A_6','QA1300A_7','QA1300A_8','QA1300A_9','QA1300A_10','QA1300A_11','QA1300A_12');
	$LWJdataArray = array($QA1300A_1,$QA1300A_2,$QA1300A_3,$QA1300A_4,$QA1300A_5,$QA1300A_6,$QA1300A_7,$QA1300A_8,$QA1300A_9,$QA1300A_10,$QA1300A_11,$QA1300A_12);
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
td.content2 {background-color:rgb(230,230,226); text-align:left}
ul {list-style:upper-alpha; padding:0px; padding-left:20px; margin:0px}
ol {list-style:decimal; padding:0px; padding-left:40px; margin:0px}
ol.zero {list-style:decimal-leading-zero}
td.sectiontop1 {border:0px solid black; width:300px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop2 {border:0px solid black; width:150px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop3 {border:0px solid black; width:100px; text-align:left; margin:0px; padding-left:10px}
</style>
<body>
<form name="form3" method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<table cellspacing="0" align="center" style="font-size:16px"><tr><td>Resident:</td><td class="sectiontop1"><font size="3"><b><?php echo $name; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Identifier:</td><td class="sectiontop2"><font size="3"><b><?php echo $_SESSION['ncareName_lwj']; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Date:</td><td class="sectiontop3"><font size="3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script></font><input type="text" size="18" name="date" id="date" value="<?php echo formatdate_Ymd_Slash($date);?>"></b></font><hr color="black" align="left" width="100%" size="1"></td></tr></table>
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1" style="margin-bottom:3px">
<tr>
<td class="section2" width="192"><b style="padding-left:5px">Section A</b></td>
<td class="section2" width="910"><b style="padding-left:5px">Identification Information</b></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1">
<tr>
<td class="part" colspan="3"><b>A1100. Language</b></td>
</tr>
<!-------------------------------------------------------------------------->	
<tr>
<td class="content" valign="top" width="70">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($A1100A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td width="800">
<ul>
<li><b>Does the resident need or want an interpreter to communicate with a doctor or health care staff?</b>
<ol start="0" style="padding-left:20px">
<li><input type="radio" name="QA1100A" value="0" <?php if($QA1100A=="0") echo "checked";?>><b>No &#8594; </b>Skip to A1200, Marital Status
<li><input type="radio" name="QA1100A" value="1" <?php if($QA1100A=="1") echo "checked";?>><b>Yes &#8594; </b>Specify in A1100B, Preferred language
<li value="9"><input type="radio" name="QA1100A" value="9" <?php if($QA1100A=="9") echo "checked";?>><b>Unable to determine &#8594; </b>Skip to A1200, Marital Status
</ol>
<li><b>Preferred language:</b><?php if (substr($url[3],0,5)!="print"){ if($A1100B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<table cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1100B_1" value="<?php echo $QA1100B_1; ?>" onkeyup="if(this.value.length==1)document.form3.QA1100B_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1100B_2" value="<?php echo $QA1100B_2; ?>" onkeyup="if(this.value.length==0)document.form3.QA1100B_1.focus();if(this.value.length==1)document.form3.QA1100B_3.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1100B_3" value="<?php echo $QA1100B_3; ?>" onkeyup="if(this.value.length==0)document.form3.QA1100B_2.focus();if(this.value.length==1)document.form3.QA1100B_4.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1100B_4" value="<?php echo $QA1100B_4; ?>" onkeyup="if(this.value.length==0)document.form3.QA1100B_3.focus();if(this.value.length==1)document.form3.QA1100B_5.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1100B_5" value="<?php echo $QA1100B_5; ?>" onkeyup="if(this.value.length==0)document.form3.QA1100B_4.focus();if(this.value.length==1)document.form3.QA1100B_6.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1100B_6" value="<?php echo $QA1100B_6; ?>" onkeyup="if(this.value.length==0)document.form3.QA1100B_5.focus();if(this.value.length==1)document.form3.QA1100B_7.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1100B_7" value="<?php echo $QA1100B_7; ?>" onkeyup="if(this.value.length==0)document.form3.QA1100B_6.focus();if(this.value.length==1)document.form3.QA1100B_8.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1100B_8" value="<?php echo $QA1100B_8; ?>" onkeyup="if(this.value.length==0)document.form3.QA1100B_7.focus();if(this.value.length==1)document.form3.QA1100B_9.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1100B_9" value="<?php echo $QA1100B_9; ?>" onkeyup="if(this.value.length==0)document.form3.QA1100B_8.focus();if(this.value.length==1)document.form3.QA1100B_10.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1100B_10" value="<?php echo $QA1100B_10; ?>" onkeyup="if(this.value.length==0)document.form3.QA1100B_9.focus();if(this.value.length==1)document.form3.QA1100B_11.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1100B_11" value="<?php echo $QA1100B_11; ?>" onkeyup="if(this.value.length==0)document.form3.QA1100B_10.focus();if(this.value.length==1)document.form3.QA1100B_12.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1100B_12" value="<?php echo $QA1100B_12; ?>" onkeyup="if(this.value.length==0)document.form3.QA1100B_11.focus();if(this.value.length==1)document.form3.QA1100B_13.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1100B_13" value="<?php echo $QA1100B_13; ?>" onkeyup="if(this.value.length==0)document.form3.QA1100B_12.focus();if(this.value.length==1)document.form3.QA1100B_14.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1100B_14" value="<?php echo $QA1100B_14; ?>" onkeyup="if(this.value.length==0)document.form3.QA1100B_13.focus();if(this.value.length==1)document.form3.QA1100B_15.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1100B_15" value="<?php echo $QA1100B_15; ?>" onkeyup="if(this.value.length==0)document.form3.QA1100B_14.focus();"></td>
</table>
</ul>
</td>
</tr>	
<!-------------------------------------------------------------------------->
<tr>
<td class="part" colspan="2"><b>A1200. Marital Status</b></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="content" valign="top">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($A1200_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<ol>
<li><input type="radio" name="QA1200" value="1" <?php if($QA1200=="1") echo "checked";?>><b>Never married</b>
<li><input type="radio" name="QA1200" value="2" <?php if($QA1200=="2") echo "checked";?>><b>Married</b>
<li><input type="radio" name="QA1200" value="3" <?php if($QA1200=="3") echo "checked";?>><b>Widowed</b>
<li><input type="radio" name="QA1200" value="4" <?php if($QA1200=="4") echo "checked";?>><b>Separated</b>
<li><input type="radio" name="QA1200" value="5" <?php if($QA1200=="5") echo "checked";?>><b>Divorced</b>
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2"><b>A1300. Optional Resident Items</b></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="content"></td>
<td>
<ul>
<li><b>Medical record number:</b><?php if (substr($url[3],0,5)!="print"){ if($A1300A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<table cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300A_1" value="<?php echo $QA1300A_1; ?>" onkeyup="if(this.value.length==1)document.form3.QA1300A_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300A_2" value="<?php echo $QA1300A_2; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300A_1.focus();if(this.value.length==1)document.form3.QA1300A_3.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300A_3" value="<?php echo $QA1300A_3; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300A_2.focus();if(this.value.length==1)document.form3.QA1300A_4.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300A_4" value="<?php echo $QA1300A_4; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300A_3.focus();if(this.value.length==1)document.form3.QA1300A_5.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300A_5" value="<?php echo $QA1300A_5; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300A_4.focus();if(this.value.length==1)document.form3.QA1300A_6.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300A_6" value="<?php echo $QA1300A_6; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300A_5.focus();if(this.value.length==1)document.form3.QA1300A_7.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300A_7" value="<?php echo $QA1300A_7; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300A_6.focus();if(this.value.length==1)document.form3.QA1300A_8.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300A_8" value="<?php echo $QA1300A_8; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300A_7.focus();if(this.value.length==1)document.form3.QA1300A_9.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300A_9" value="<?php echo $QA1300A_9; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300A_8.focus();if(this.value.length==1)document.form3.QA1300A_10.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300A_10" value="<?php echo $QA1300A_10; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300A_9.focus();if(this.value.length==1)document.form3.QA1300A_11.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300A_11" value="<?php echo $QA1300A_11; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300A_10.focus();if(this.value.length==1)document.form3.QA1300A_12.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300A_12" value="<?php echo $QA1300A_12; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300A_11.focus();"></td>
</table>
<li><b>Room number:</b><?php if (substr($url[3],0,5)!="print"){ if($A1300B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<table cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300B_1" value="<?php echo $QA1300B_1; ?>" onkeyup="if(this.value.length==1)document.form3.QA1300B_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300B_2" value="<?php echo $QA1300B_2; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300B_1.focus();if(this.value.length==1)document.form3.QA1300B_3.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300B_3" value="<?php echo $QA1300B_3; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300B_2.focus();if(this.value.length==1)document.form3.QA1300B_4.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300B_4" value="<?php echo $QA1300B_4; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300B_3.focus();if(this.value.length==1)document.form3.QA1300B_5.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300B_5" value="<?php echo $QA1300B_5; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300B_4.focus();if(this.value.length==1)document.form3.QA1300B_6.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300B_6" value="<?php echo $QA1300B_6; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300B_5.focus();if(this.value.length==1)document.form3.QA1300B_7.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300B_7" value="<?php echo $QA1300B_7; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300B_6.focus();if(this.value.length==1)document.form3.QA1300B_8.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300B_8" value="<?php echo $QA1300B_8; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300B_7.focus();if(this.value.length==1)document.form3.QA1300B_9.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300B_9" value="<?php echo $QA1300B_9; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300B_8.focus();if(this.value.length==1)document.form3.QA1300B_10.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300B_10" value="<?php echo $QA1300B_10; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300B_9.focus();"></td>
</table>
<li><b>Name by which resident prefers to be addressed:</b><?php if (substr($url[3],0,5)!="print"){ if($A1300C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<table cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300C_1" value="<?php echo $QA1300C_1; ?>" onkeyup="if(this.value.length==1)document.form3.QA1300C_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300C_2" value="<?php echo $QA1300C_2; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300C_1.focus();if(this.value.length==1)document.form3.QA1300C_3.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300C_3" value="<?php echo $QA1300C_3; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300C_2.focus();if(this.value.length==1)document.form3.QA1300C_4.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300C_4" value="<?php echo $QA1300C_4; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300C_3.focus();if(this.value.length==1)document.form3.QA1300C_5.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300C_5" value="<?php echo $QA1300C_5; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300C_4.focus();if(this.value.length==1)document.form3.QA1300C_6.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300C_6" value="<?php echo $QA1300C_6; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300C_5.focus();if(this.value.length==1)document.form3.QA1300C_7.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300C_7" value="<?php echo $QA1300C_7; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300C_6.focus();if(this.value.length==1)document.form3.QA1300C_8.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300C_8" value="<?php echo $QA1300C_8; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300C_7.focus();if(this.value.length==1)document.form3.QA1300C_9.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300C_9" value="<?php echo $QA1300C_9; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300C_8.focus();if(this.value.length==1)document.form3.QA1300C_10.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300C_10" value="<?php echo $QA1300C_10; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300C_9.focus();if(this.value.length==1)document.form3.QA1300C_11.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300C_11" value="<?php echo $QA1300C_11; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300C_10.focus();if(this.value.length==1)document.form3.QA1300C_12.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300C_12" value="<?php echo $QA1300C_12; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300C_11.focus();if(this.value.length==1)document.form3.QA1300C_13.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300C_13" value="<?php echo $QA1300C_13; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300C_12.focus();if(this.value.length==1)document.form3.QA1300C_14.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300C_14" value="<?php echo $QA1300C_14; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300C_13.focus();if(this.value.length==1)document.form3.QA1300C_15.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300C_15" value="<?php echo $QA1300C_15; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300C_14.focus();if(this.value.length==1)document.form3.QA1300C_16.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300C_16" value="<?php echo $QA1300C_16; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300C_15.focus();if(this.value.length==1)document.form3.QA1300C_17.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300C_17" value="<?php echo $QA1300C_17; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300C_16.focus();if(this.value.length==1)document.form3.QA1300C_18.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300C_18" value="<?php echo $QA1300C_18; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300C_17.focus();if(this.value.length==1)document.form3.QA1300C_19.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300C_19" value="<?php echo $QA1300C_19; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300C_18.focus();if(this.value.length==1)document.form3.QA1300C_20.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300C_20" value="<?php echo $QA1300C_20; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300C_19.focus();if(this.value.length==1)document.form3.QA1300C_21.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300C_21" value="<?php echo $QA1300C_21; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300C_20.focus();if(this.value.length==1)document.form3.QA1300C_22.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300C_22" value="<?php echo $QA1300C_22; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300C_21.focus();if(this.value.length==1)document.form3.QA1300C_23.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300C_23" value="<?php echo $QA1300C_23; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300C_22.focus();"></td>
</table>
<li><b>Lifetime occupation(s)</b>- put "/" between two occupations:<?php if (substr($url[3],0,5)!="print"){ if($A1300D_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<table cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300D_1" value="<?php echo $QA1300D_1; ?>" onkeyup="if(this.value.length==1)document.form3.QA1300D_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300D_2" value="<?php echo $QA1300D_2; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300D_1.focus();if(this.value.length==1)document.form3.QA1300D_3.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300D_3" value="<?php echo $QA1300D_3; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300D_2.focus();if(this.value.length==1)document.form3.QA1300D_4.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300D_4" value="<?php echo $QA1300D_4; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300D_3.focus();if(this.value.length==1)document.form3.QA1300D_5.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300D_5" value="<?php echo $QA1300D_5; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300D_4.focus();if(this.value.length==1)document.form3.QA1300D_6.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300D_6" value="<?php echo $QA1300D_6; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300D_5.focus();if(this.value.length==1)document.form3.QA1300D_7.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300D_7" value="<?php echo $QA1300D_7; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300D_6.focus();if(this.value.length==1)document.form3.QA1300D_8.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300D_8" value="<?php echo $QA1300D_8; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300D_7.focus();if(this.value.length==1)document.form3.QA1300D_9.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300D_9" value="<?php echo $QA1300D_9; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300D_8.focus();if(this.value.length==1)document.form3.QA1300D_10.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300D_10" value="<?php echo $QA1300D_10; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300D_9.focus();if(this.value.length==1)document.form3.QA1300D_11.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300D_11" value="<?php echo $QA1300D_11; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300D_10.focus();if(this.value.length==1)document.form3.QA1300D_12.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300D_12" value="<?php echo $QA1300D_12; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300D_11.focus();if(this.value.length==1)document.form3.QA1300D_13.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300D_13" value="<?php echo $QA1300D_13; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300D_12.focus();if(this.value.length==1)document.form3.QA1300D_14.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300D_14" value="<?php echo $QA1300D_14; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300D_13.focus();if(this.value.length==1)document.form3.QA1300D_15.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300D_15" value="<?php echo $QA1300D_15; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300D_14.focus();if(this.value.length==1)document.form3.QA1300D_16.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300D_16" value="<?php echo $QA1300D_16; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300D_15.focus();if(this.value.length==1)document.form3.QA1300D_17.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300D_17" value="<?php echo $QA1300D_17; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300D_16.focus();if(this.value.length==1)document.form3.QA1300D_18.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300D_18" value="<?php echo $QA1300D_18; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300D_17.focus();if(this.value.length==1)document.form3.QA1300D_19.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300D_19" value="<?php echo $QA1300D_19; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300D_18.focus();if(this.value.length==1)document.form3.QA1300D_20.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300D_20" value="<?php echo $QA1300D_20; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300D_19.focus();if(this.value.length==1)document.form3.QA1300D_21.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300D_21" value="<?php echo $QA1300D_21; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300D_20.focus();if(this.value.length==1)document.form3.QA1300D_22.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300D_22" value="<?php echo $QA1300D_22; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300D_21.focus();if(this.value.length==1)document.form3.QA1300D_23.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1300D_23" value="<?php echo $QA1300D_23; ?>" onkeyup="if(this.value.length==0)document.form3.QA1300D_22.focus();"></td>
</table>
</ul>			  
</td>
</tr> 
<!-------------------------------------------------------------------------->	  
<tr>
<td class="part" colspan="2">
<b>A1500. Preadmission Screening and Resident Review (PASRR)</b>
<br>Complete only if A0310A = 01, 03, 04, or 05
</td>
</tr>
<!--------------------------------------------------------------------------> 
<tr>
<td class="content" valign="top">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($A1500_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td >
<b style="padding-left:5px">Is the resident currently considered by the state level II PASRR process to have serious mental illness and/or intellectual disability</b><br><b style="padding-left:5px">("mental retardation" in federal regulation) or a related condition?</b>
<ol start="0">
<li><input type="radio" name="QA1500" value="0" <?php if($QA1500=="0") echo "checked";?>><b>No &#8594; </b>Skip to A1550, Conditions Related to ID/DD Status
<li><input type="radio" name="QA1500" value="1" <?php if($QA1500=="1") echo "checked";?>><b>Yes &#8594; </b>Continue to A1510, Level II Preadmission Screening and Resident Review (PASRR) Conditions.
<li value="9"><input type="radio" name="QA1500" value="9" <?php if($QA1500=="9") echo "checked";?>><b>Not a Medicaid certified unit &#8594; </b>Skip to A1550, Conditions Related to ID/DD Status
</ol>	  
</td>
</tr>
<!-------------------------------------------------------------------------->	  
<tr>
<td class="part" colspan="2">
<b>A1510. Level II Preadmission Screening and Resident Review (PASRR) Conditions</b><?php if (substr($url[3],0,5)!="print"){ if($A1510_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
<br>Complete only if A0310A = 01, 03, 04, or 05
</td>
</tr>
<!-------------------------------------------------------------------------->	  
<tr>
<td class="partwhite" colspan="2">
<b>&#8595; Check all that apply</b>
</td>
</tr>
<!-------------------------------------------------------------------------->
<tr>
<td class="content">
<input type="checkbox" name="QA1510A" value="X" <?php if($QA1510A=="X") echo "checked";?>>
</td>
<td>
<ul>
<li><b>Serious mental illness</b>
</ul>
</td>
</tr>
<tr>
<td class="content">
<input type="checkbox" name="QA1510B" value="X" <?php if($QA1510B=="X") echo "checked"; ?>>
</td>
<td>
<ul>
<li value="2"><b>Intellectual Disability ("mental retardation" in federal regulation)</b>
</ul>
</td>
</tr>
<tr>
<td class="content">
<input type="checkbox" name="QA1510C" value="X" <?php if($QA1510C=="X") echo "checked"; ?>>
</td>
<td>
<ul>
<li value="3"><b>Other related conditions</b>
</ul>
</td>
</tr>
<!-------------------------------------------->
</table>
<p align="center">
<input type="hidden" name="formID" id="formID" value="mdsform03">
<input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
<button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
<input type="reset" value="Reset"></p>
<p style="font-size:10px; color:black">MDS 3.0 Nursing Home Comprehensive (NC) Version 1.12.0 Effective 10/01/2014</p>
</form>
</body>