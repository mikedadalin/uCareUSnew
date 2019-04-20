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
$sql = "SELECT * FROM `mdsform01` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
	  td.answer {background-color:rgb(221,228,255); border:1px solid black; width:20px; height:20px}
	  td.part {background-color:rgb(230,230,226); height:20px; text-align:left; font-size:10px; padding-left:5px}
	  td.content {background-color:rgb(230,230,226); text-align:center; width:70px}
	  ul {list-style:upper-alpha; padding:0px; padding-left:22px; margin:0px}
	  ol {list-style:decimal; padding:0px; padding-left:0px; margin:0px}
	  ol.zero {list-style:decimal-leading-zero; padding-left:3px; margin:0px}
      td.sectiontop1 {border:0px solid black; width:300px; text-align:left; margin:0px; padding-left:10px}
      td.sectiontop2 {border:0px solid black; width:150px; text-align:left; margin:0px; padding-left:10px}
      td.sectiontop3 {border:0px solid black; width:100px; text-align:left; margin:0px; padding-left:10px}
    </style>
  <body>
    <form name="form1" method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
	<table cellspacing="0" align="center" style="font-size:16px"><tr><td>Resident:</td><td class="sectiontop1"><font size="3"><b><?php echo $name; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Identifier:</td><td class="sectiontop2"><font size="3"><b><?php echo $_SESSION['ncareName_lwj']; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Date:</td><td class="sectiontop3"><font size="3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script></font><input type="text" size="18" name="date" id="date" value="<?php echo formatdate_Ymd_Slash($date);?>"></b><hr color="black" align="left" width="100%" size="1"></td></tr></table>
	<p align="center" style="color:#2B6B6E; margin:3px">
	<b>MINIMUM DATA SET(MDS)-Version 3.0<br> 
	RESIDENT ASSESSMENT AND CARE SCREENING<br>
	Nursing Home Comprehensive(NC)Item Set</b>
    </p>
    <table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1" style="margin-bottom:3px">
      <tr>
		<td class="section2" width="150"><b style="padding-left:5px">Section A</b></td>
		<td class="section2" width="720"><b style="padding-left:5px">Identification Information</b></td>
	  <tr>
    </table>
<!----------------------------------------------------->
	<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1">
	  <tr>
	    <td class="part" colspan="2"><b>A0050. Type of Record</b></td>
	  </tr>
<!----------------------------------------------------->
	  <tr>
	    <td class="content" valign="top" width="70">
		  <a style="font-size:7px">Enter Code</a>
		  <table align="center" cellspacing="0">
		    <td class="answer"></td>
		  </table>
		</td>
		<td width="800">
		  <ol style="padding-left:40px">
		    <li><input type="radio" name="QA0050" id="QA0050" value="1" <?php if($QA0050=="1") echo "checked";?>><b>Add new record &#8594; </b>Continue to A0100, Facility Provider Numbers
		    <li><input type="radio" name="QA0050" id="QA0050" value="2" <?php if($QA0050=="2") echo "checked";?>><b>Modify existing record &#8594; </b>Continue to A0100, Facility Provider Numbers
			<li><input type="radio" name="QA0050" id="QA0050" value="3" <?php if($QA0050=="3") echo "checked";?>><b>Inactivate existing record &#8594; </b>Skip to X0150, Type of Provider
		  </ol>
		</td>
	  </tr>
<!----------------------------------------------------->
	  <tr>
	    <td class="part" colspan="2"><b>A0100. Facility Provider Nembers</b></td>
	  </tr>
<!----------------------------------------------------->
	  <tr>
	    <td class="content"></td>
		<td>
		  <ul>
		    <li><b>National Provider Identifier (NPI):</b><?php if (substr($url[3],0,5)!="print"){ if($A0100A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
			  <table cellspacing="0"><br>
		        <td class="answer"><input type="text" size="1" maxlength="1" name="QA0100A_1" id="QA0100A_1" value="<?php echo $QA0100A_1; ?>" onkeyup="if(this.value.length==1)document.form1.QA0100A_2.focus();"></td>
			    <td class="answer"><input type="text" size="1" maxlength="1" name="QA0100A_2" id="QA0100A_2" value="<?php echo $QA0100A_2; ?>" onkeyup="if(this.value.length==0)document.form1.QA0100A_1.focus();if(this.value.length==1)document.form1.QA0100A_3.focus();"></td>
			    <td class="answer"><input type="text" size="1" maxlength="1" name="QA0100A_3" id="QA0100A_3" value="<?php echo $QA0100A_3; ?>" onkeyup="if(this.value.length==0)document.form1.QA0100A_2.focus();if(this.value.length==1)document.form1.QA0100A_4.focus();"></td>
			    <td class="answer"><input type="text" size="1" maxlength="1" name="QA0100A_4" id="QA0100A_4" value="<?php echo $QA0100A_4; ?>" onkeyup="if(this.value.length==0)document.form1.QA0100A_3.focus();if(this.value.length==1)document.form1.QA0100A_5.focus();"></td>
        		<td class="answer"><input type="text" size="1" maxlength="1" name="QA0100A_5" id="QA0100A_5" value="<?php echo $QA0100A_5; ?>" onkeyup="if(this.value.length==0)document.form1.QA0100A_4.focus();if(this.value.length==1)document.form1.QA0100A_6.focus();"></td>
			    <td class="answer"><input type="text" size="1" maxlength="1" name="QA0100A_6" id="QA0100A_6" value="<?php echo $QA0100A_6; ?>" onkeyup="if(this.value.length==0)document.form1.QA0100A_5.focus();if(this.value.length==1)document.form1.QA0100A_7.focus();"></td>
			    <td class="answer"><input type="text" size="1" maxlength="1" name="QA0100A_7" id="QA0100A_7" value="<?php echo $QA0100A_7; ?>" onkeyup="if(this.value.length==0)document.form1.QA0100A_6.focus();if(this.value.length==1)document.form1.QA0100A_8.focus();"></td>
			    <td class="answer"><input type="text" size="1" maxlength="1" name="QA0100A_8" id="QA0100A_8" value="<?php echo $QA0100A_8; ?>" onkeyup="if(this.value.length==0)document.form1.QA0100A_7.focus();if(this.value.length==1)document.form1.QA0100A_9.focus();"></td>
			    <td class="answer"><input type="text" size="1" maxlength="1" name="QA0100A_9" id="QA0100A_9" value="<?php echo $QA0100A_9; ?>" onkeyup="if(this.value.length==0)document.form1.QA0100A_8.focus();if(this.value.length==1)document.form1.QA0100A_10.focus();"></td>
			    <td class="answer"><input type="text" size="1" maxlength="1" name="QA0100A_10" id="QA0100A_10" value="<?php echo $QA0100A_10; ?>" onkeyup="if(this.value.length==0)document.form1.QA0100A_9.focus();"></td>
		      </table>
		    <li><b>CMS Certification Nember (CCN):</b><?php if (substr($url[3],0,5)!="print"){ if($A0100B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
			  <table cellspacing="0"><br>
		        <td class="answer"><input type="text" size="1" maxlength="1" name="QA0100B_1" id="QA0100B_1" onkeyup="if(this.value.length==1)document.form1.QA0100B_2.focus();" value="<?php echo $QA0100B_1;?>"></td>
			    <td class="answer"><input type="text" size="1" maxlength="1" name="QA0100B_2" id="QA0100B_2" onkeyup="if(this.value.length==0)document.form1.QA0100B_1.focus();if(this.value.length==1)document.form1.QA0100B_3.focus();" value="<?php echo $QA0100B_2;?>"></td>
				<td class="answer"><input type="text" size="1" maxlength="1" name="QA0100B_3" id="QA0100B_3" onkeyup="if(this.value.length==0)document.form1.QA0100B_2.focus();if(this.value.length==1)document.form1.QA0100B_4.focus();" value="<?php echo $QA0100B_3;?>"></td>
			    <td class="answer"><input type="text" size="1" maxlength="1" name="QA0100B_4" id="QA0100B_4" onkeyup="if(this.value.length==0)document.form1.QA0100B_3.focus();if(this.value.length==1)document.form1.QA0100B_5.focus();" value="<?php echo $QA0100B_4;?>"></td>
			    <td class="answer"><input type="text" size="1" maxlength="1" name="QA0100B_5" id="QA0100B_5" onkeyup="if(this.value.length==0)document.form1.QA0100B_4.focus();if(this.value.length==1)document.form1.QA0100B_6.focus();" value="<?php echo $QA0100B_5;?>"></td>
			    <td class="answer"><input type="text" size="1" maxlength="1" name="QA0100B_6" id="QA0100B_6" onkeyup="if(this.value.length==0)document.form1.QA0100B_5.focus();if(this.value.length==1)document.form1.QA0100B_7.focus();" value="<?php echo $QA0100B_6;?>"></td>
			    <td class="answer"><input type="text" size="1" maxlength="1" name="QA0100B_7" id="QA0100B_7" onkeyup="if(this.value.length==0)document.form1.QA0100B_6.focus();if(this.value.length==1)document.form1.QA0100B_8.focus();" value="<?php echo $QA0100B_7;?>"></td>
			    <td class="answer"><input type="text" size="1" maxlength="1" name="QA0100B_8" id="QA0100B_8" onkeyup="if(this.value.length==0)document.form1.QA0100B_7.focus();if(this.value.length==1)document.form1.QA0100B_9.focus();" value="<?php echo $QA0100B_8;?>"></td>
			    <td class="answer"><input type="text" size="1" maxlength="1" name="QA0100B_9" id="QA0100B_9" onkeyup="if(this.value.length==0)document.form1.QA0100B_8.focus();if(this.value.length==1)document.form1.QA0100B_10.focus();" value="<?php echo $QA0100B_9;?>"></td>
			    <td class="answer"><input type="text" size="1" maxlength="1" name="QA0100B_10" id="QA0100B_10" onkeyup="if(this.value.length==0)document.form1.QA0100B_9.focus();if(this.value.length==1)document.form1.QA0100B_11.focus();" value="<?php echo $QA0100B_10;?>"></td>
			    <td class="answer"><input type="text" size="1" maxlength="1" name="QA0100B_11" id="QA0100B_11" onkeyup="if(this.value.length==0)document.form1.QA0100B_10.focus();if(this.value.length==1)document.form1.QA0100B_12.focus();" value="<?php echo $QA0100B_11;?>"></td>
			    <td class="answer"><input type="text" size="1" maxlength="1" name="QA0100B_12" id="QA0100B_12" onkeyup="if(this.value.length==0)document.form1.QA0100B_11.focus();" value="<?php echo $QA0100B_12;?>"></td>
		      </table>
		    <li><b>State Provider Number</b><?php if (substr($url[3],0,5)!="print"){ if($A0100C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
			  <table cellspacing="0"><br>
		        <td class="answer"><input type="text" size="1" maxlength="1" name="QA0100C_1" id="QA0100C_1" onkeyup="if(this.value.length==1)document.form1.QA0100C_2.focus();" value="<?php echo $QA0100C_1;?>"></td>
			    <td class="answer"><input type="text" size="1" maxlength="1" name="QA0100C_2" id="QA0100C_2" onkeyup="if(this.value.length==0)document.form1.QA0100C_1.focus();if(this.value.length==1)document.form1.QA0100C_3.focus();" value="<?php echo $QA0100C_2;?>"></td>
			    <td class="answer"><input type="text" size="1" maxlength="1" name="QA0100C_3" id="QA0100C_3" onkeyup="if(this.value.length==0)document.form1.QA0100C_2.focus();if(this.value.length==1)document.form1.QA0100C_4.focus();" value="<?php echo $QA0100C_3;?>"></td>
			    <td class="answer"><input type="text" size="1" maxlength="1" name="QA0100C_4" id="QA0100C_4" onkeyup="if(this.value.length==0)document.form1.QA0100C_3.focus();if(this.value.length==1)document.form1.QA0100C_5.focus();" value="<?php echo $QA0100C_4;?>"></td>
			    <td class="answer"><input type="text" size="1" maxlength="1" name="QA0100C_5" id="QA0100C_5" onkeyup="if(this.value.length==0)document.form1.QA0100C_4.focus();if(this.value.length==1)document.form1.QA0100C_6.focus();" value="<?php echo $QA0100C_5;?>"></td>
			    <td class="answer"><input type="text" size="1" maxlength="1" name="QA0100C_6" id="QA0100C_6" onkeyup="if(this.value.length==0)document.form1.QA0100C_5.focus();if(this.value.length==1)document.form1.QA0100C_7.focus();" value="<?php echo $QA0100C_6;?>"></td>
			    <td class="answer"><input type="text" size="1" maxlength="1" name="QA0100C_7" id="QA0100C_7" onkeyup="if(this.value.length==0)document.form1.QA0100C_6.focus();if(this.value.length==1)document.form1.QA0100C_8.focus();" value="<?php echo $QA0100C_7;?>"></td>
			    <td class="answer"><input type="text" size="1" maxlength="1" name="QA0100C_8" id="QA0100C_8" onkeyup="if(this.value.length==0)document.form1.QA0100C_7.focus();if(this.value.length==1)document.form1.QA0100C_9.focus();" value="<?php echo $QA0100C_8;?>"></td>
			    <td class="answer"><input type="text" size="1" maxlength="1" name="QA0100C_9" id="QA0100C_9" onkeyup="if(this.value.length==0)document.form1.QA0100C_8.focus();if(this.value.length==1)document.form1.QA0100C_10.focus();" value="<?php echo $QA0100C_9;?>"></td>
			    <td class="answer"><input type="text" size="1" maxlength="1" name="QA0100C_10" id="QA0100C_10" onkeyup="if(this.value.length==0)document.form1.QA0100C_9.focus();if(this.value.length==1)document.form1.QA0100C_11.focus();" value="<?php echo $QA0100C_10;?>"></td>
			    <td class="answer"><input type="text" size="1" maxlength="1" name="QA0100C_11" id="QA0100C_11" onkeyup="if(this.value.length==0)document.form1.QA0100C_10.focus();if(this.value.length==1)document.form1.QA0100C_12.focus();" value="<?php echo $QA0100C_11;?>"></td>
			    <td class="answer"><input type="text" size="1" maxlength="1" name="QA0100C_12" id="QA0100C_12" onkeyup="if(this.value.length==0)document.form1.QA0100C_11.focus();if(this.value.length==1)document.form1.QA0100C_13.focus();" value="<?php echo $QA0100C_12;?>"></td>
			    <td class="answer"><input type="text" size="1" maxlength="1" name="QA0100C_13" id="QA0100C_13" onkeyup="if(this.value.length==0)document.form1.QA0100C_12.focus();if(this.value.length==1)document.form1.QA0100C_14.focus();" value="<?php echo $QA0100C_13;?>"></td>
			    <td class="answer"><input type="text" size="1" maxlength="1" name="QA0100C_14" id="QA0100C_14" onkeyup="if(this.value.length==0)document.form1.QA0100C_13.focus();if(this.value.length==1)document.form1.QA0100C_15.focus();" value="<?php echo $QA0100C_14;?>"></td>
			    <td class="answer"><input type="text" size="1" maxlength="1" name="QA0100C_15" id="QA0100C_15" onkeyup="if(this.value.length==0)document.form1.QA0100C_14.focus();" value="<?php echo $QA0100C_15;?>"></td>
		      </table>
		  </ul>
		</td>
	  </tr>
<!----------------------------------------------------->
	  <tr>
	    <td class="part" colspan="2"><b>A0200. Type of Provider</b></td>
	  </tr>
<!----------------------------------------------------->
	  <tr>
	    <td class="content" valign="top">
		  <a style="font-size:7px">Enter Code</a>
		  <table align="center" cellspacing="0">
		    <td class="answer"></td>
		  </table>
		</td>
		<td>
		  <ol>
		  <b style="padding-left:5px">Type of provider</b>
		    <dd>
		      <li><input type="radio" name="QA0200" id="QA0200" value="1" <?php if($QA0200=="1") echo "checked";?>><b>Nursing home(SNF/NF)</b>
		      <li><input type="radio" name="QA0200" id="QA0200" value="2" <?php if($QA0200=="2") echo "checked";?>><b>Swing Bed</b>
			</dd>
		  </ol>
		</td>
	  </tr>
<!----------------------------------------------------->
	  <tr>
	    <td class="part" colspan="2"><b>A0310. Type of Assessment.</b></td>
	  </tr>
<!----------------------------------------------------->
	  <tr>
	    <td class="content" valign="top">
		  <a style="font-size:7px">Enter Code</a>
		  <table align="center" cellspacing="0">
		    <td class="answer"></td>
			<td class="answer"></td>
		  </table>
		</td>
		<td>
		  <ul>
		    <li><b>Federal OBRA Reason for Assessment</b>
		  </ul>
		  <ol class="zero">
		    <dd>
		      <li><input type="radio" name="QA0310A" id="QA0310A" value="01" <?php if($QA0310A=="01") echo "checked";?>><b>Admission</b> assessment (required by day 14)
		      <li><input type="radio" name="QA0310A" id="QA0310A" value="02" <?php if($QA0310A=="02") echo "checked";?>><b>Quarterly</b> review assessment
		      <li><input type="radio" name="QA0310A" id="QA0310A" value="03" <?php if($QA0310A=="03") echo "checked";?>><b>Annual</b> assessment
		      <li><input type="radio" name="QA0310A" id="QA0310A" value="04" <?php if($QA0310A=="04") echo "checked";?>><b>Significant change in status</b> assessment
		      <li><input type="radio" name="QA0310A" id="QA0310A" value="05" <?php if($QA0310A=="05") echo "checked";?>><b>Significant correction</b> to <b>prior comprehensive</b> assessment
		      <li><input type="radio" name="QA0310A" id="QA0310A" value="06" <?php if($QA0310A=="06") echo "checked";?>><b>Significant correction</b> to <b>prior quarterly</b> assessment
		      <li value="99"><input type="radio" name="QA0310A" id="QA0310A" value="99" <?php if($QA0310A=="99") echo "checked";?>><b>Not OBRA required</b> assessment
		    </dd>
		  </ol>
		</td>
	  </tr>
<!----------------------------------------------------->
	  <tr>
	    <td class="content" valign="top">
		  <a style="font-size:7px">Enter Code</a>
		  <table align="center" cellspacing="0">
		    <td class="answer"></td>
			<td class="answer"></td>
		  </table>
		</td>
		<td>
		  <ul>
		    <li value="2"><b>PPS Assessment</b><br><b><u>PPS</u> <u>Scheduled</u> <u>Assessments</u> <u>for</u> <u>a</u> <u>Medicare</u> <u>Part</u> <u>A</u> <u>Stay</u></b>
		  </ul>
		  <ol class="zero">
		    <dd>
		      <li><input type="radio" name="QA0310B" id="QA0310B" value="01" <?php if($QA0310B=="01") echo "checked";?>><b>5-day</b> scheduled assessment
		      <li><input type="radio" name="QA0310B" id="QA0310B" value="02" <?php if($QA0310B=="02") echo "checked";?>><b>14-day</b> scheduled assessment
		      <li><input type="radio" name="QA0310B" id="QA0310B" value="03" <?php if($QA0310B=="03") echo "checked";?>><b>30-day</b> scheduled assessment
		      <li><input type="radio" name="QA0310B" id="QA0310B" value="04" <?php if($QA0310B=="04") echo "checked";?>><b>60-day</b> scheduled assessment
		      <li><input type="radio" name="QA0310B" id="QA0310B" value="05" <?php if($QA0310B=="05") echo "checked";?>><b>90-day</b> scheduled assessment
		    </dd>
              <b style="padding-left:18px"><u>PPS</u> <u>Unscheduled</u> <u>Assessments</u> <u>for</u> <u>a</u> <u>Medicare</u> <u>Part</u> <u>A</u> <u>Stay</u></b>
			<dd>
		      <li value="07"><input type="radio" name="QA0310B" id="QA0310B" value="07" <?php if($QA0310B=="07") echo "checked";?>><b>Unscheduled assessment used for PPS</b> (OMRA, significant or clinical change, or significant correction assessment)
            </dd>
		      <b style="padding-left:18px"><u>Not</u> <u>PPS</u> <u>Assessment</u></b>
		    <dd>
              <li value="99"><input type="radio" name="QA0310B" id="QA0310B" value="99" <?php if($QA0310B=="99") echo "checked";?>><b>Not PPS</b> assessment
            </dd>		  
          </ol>		  
	    </td>
   	  </tr>
<!----------------------------------------------------->
	  <tr>
	    <td class="content" valign="top">
		  <a style="font-size:7px">Enter Code</a>
		  <table align="center" cellspacing="0">
		    <td class="answer"></td>
		  </table>
		</td>
		<td>
		  <ul>
		    <li value="3"><b>PPS Other Medicare Required Assessment - OMRA</b>
		  </ul>
		  <ol start="0">
		    <dd>
		      <li><input type="radio" name="QA0310C" id="QA0310C" value="0" <?php if($QA0310C=="0") echo "checked";?>><b>No</b>
		      <li><input type="radio" name="QA0310C" id="QA0310C" value="1" <?php if($QA0310C=="1") echo "checked";?>><b>Start of therapy</b> assessment
		      <li><input type="radio" name="QA0310C" id="QA0310C" value="2" <?php if($QA0310C=="2") echo "checked";?>><b>End of therapy</b> assessment
		      <li><input type="radio" name="QA0310C" id="QA0310C" value="3" <?php if($QA0310C=="3") echo "checked";?>><b>Both Start and End of therapy</b> assessment
			  <li><input type="radio" name="QA0310C" id="QA0310C" value="4" <?php if($QA0310C=="4") echo "checked";?>><b>Change of therapy</b> assessment
		    </dd>
		  </ol>
		</td>
	  </tr>
<!----------------------------------------------------->
	  <tr>
	    <td class="content" valign="top">
		  <a style="font-size:7px">Enter Code</a>
		  <table align="center" cellspacing="0">
		    <td class="answer"></td>
		  </table>
		</td>
		<td>
		  <ul>
		    <li value="4"><b>Is this a Swing Bed clinical change assessment?</b> Complete only if A0200 = 2
		  </ul>
		  <ol start="0">		    
		    <dd>
		      <li><input type="radio" name="QA0310D" id="QA0310D" value="0" <?php if($QA0310D=="0") echo "checked";?>><b>No</b>
		      <li><input type="radio" name="QA0310D" id="QA0310D" value="1" <?php if($QA0310D=="1") echo "checked";?>><b>Yes</b>
		    </dd>
		  </ol>
		</td>
	  </tr>
<!----------------------------------------------------->
      <tr>
	    <td class="part" colspan="2"><b>A0310 continued on next page</b></td>
	  </tr>
<!----------------------------------------------------->
	</table>
	<p align="center">
	<input type="hidden" name="formID" id="formID" value="mdsform01">
	<input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
	<button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
	<input type="reset" value="Reset"></p>
	<p style="font-size:10px; color:black">MDS 3.0 Nursing Home Comprehensive (NC) Version 1.12.0 Effective 10/01/2014</p>
	</form>
  </body>