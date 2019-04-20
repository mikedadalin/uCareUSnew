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
$sql = "SELECT * FROM `mdsform41` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
	  td.partwhite {background-color:rgb(255,255,255); height:20px; text-align:left; padding-left:5px}
	  td.content {background-color:rgb(230,230,226); text-align:center; font-size:xx-small; width:70px}
	  td.content2 {background-color:rgb(230,230,226); text-align:left}
	  ul {list-style:upper-alpha; padding:0px; padding-left:20px; margin:0px}
	  ol {list-style:decimal; padding:0px; padding-left:0px; margin:0px}
	  ol.zero {list-style:decimal-leading-zero}
	td.sectiontop1 {border:0px solid black; width:300px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop2 {border:0px solid black; width:150px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop3 {border:0px solid black; width:100px; text-align:left; margin:0px; padding-left:10px}
</style>
  <body>
    <form name="form41" method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
    <table cellspacing="0" align="center" style="font-size:16px"><tr><td>Resident:</td><td class="sectiontop1"><font size="3"><b><?php echo $name; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Identifier:</td><td class="sectiontop2"><font size="3"><b><?php echo $_SESSION['ncareName_lwj']; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Date:</td><td class="sectiontop3"><font size="3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script></font><input type="text" size="18" name="date" id="date" value="<?php echo formatdate_Ymd_Slash($date);?>"></b></font><hr color="black" align="left" width="100%" size="1"></td></tr></table>
    <table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1" style="margin-bottom:3px">
      <tr>
		<td class="section2" width="180"><b style="padding-left:5px">Section Z</b></td>
		<td class="section2" width="804"><b style="padding-left:5px">Assessment Administration</b></td>
	  </tr>
    </table>
<!-------------------------------------------->
    <table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1"> 
   	  <tr>
	    <td class="part" colspan="5"><b>Z0400. Signature of Persons Completing the Assessment or Entry/Death Reporting</b></td>
	  </tr>
<!-------------------------------------------->
      <tr> 
	    <td class="content" width="20" rowspan="15"></td>
	  </tr>
	  <tr>
		<td class="partwhite" width="850" colspan="4">
		  I certify that the accompanying information accurately reflects resident assessment information for this resident and that I collected or coordinated <br>collection of this information on the dates specified. To the best of my knowledge, this information was collected in accordance with applicable <br>Medicare and Medicaid requirements. I understand that this information is used as a basis for ensuring that residents receive appropriate and quality <br>care, and as a basis for payment from federal funds. I further understand that payment of such federal funds and continued participation in the <br>government-funded health care programs is conditioned on the accuracy and truthfulness of this information, and that I may be personally subject to <br>or may subject my organization to substantial criminal, civil, and/or administrative penalties for submitting false information. I also certify that I am <br>authorized to submit this information by this facility on its behalf.
		</td>
      </tr> 
<!-------------------------------------------->	 
      <tr> 
		<td width="300" align="center">
		  <b>Signature</b>
		</td>
		<td width="200" align="center">
		  <b>Title</b>
		</td>
		<td width="200" align="center">
		  <b>Sections</b>
		</td>
		<td width="150" align="center">
		  <b>Date Section <br>Completed</b>
		</td>
      </tr> 
<!-------------------------------------------->
	  <tr>
		<td align="left" valign="top">
		  <ul><li><input type="text" size="24" name="QZ0400A" value="<?php echo $QZ0400A; ?>"></ul><br>
		</td>
		<td><?php if (substr($url[3],0,5)!="print"){ if($Z0400A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><input type="text" size="24" name="QZ0400A1" value="<?php echo $QZ0400A1; ?>"></td>
		<td><input type="text" size="27" name="QZ0400A2" value="<?php echo $QZ0400A2; ?>"></td>
		<td><input type="text" size="19" name="QZ0400A3" value="<?php echo $QZ0400A3; ?>"></td>
      </tr> 
<!-------------------------------------------->
      <tr> 
		<td align="left" valign="top">
		  <ul><li value="2"><input type="text" size="24" name="QZ0400B" value="<?php echo $QZ0400B; ?>"></ul><br>
		</td>
		<td><?php if (substr($url[3],0,5)!="print"){ if($Z0400B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><input type="text" size="24" name="QZ0400B1" value="<?php echo $QZ0400B1; ?>"></td>
		<td><input type="text" size="27" name="QZ0400B2" value="<?php echo $QZ0400B2; ?>"></td>
		<td><input type="text" size="19" name="QZ0400B3" value="<?php echo $QZ0400B3; ?>"></td>
      </tr> 
<!-------------------------------------------->
      <tr> 
		<td align="left" valign="top">
		  <ul><li value="3"><input type="text" size="24" name="QZ0400C" value="<?php echo $QZ0400C; ?>"></ul><br>
		</td>
		<td><?php if (substr($url[3],0,5)!="print"){ if($Z0400C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><input type="text" size="24" name="QZ0400C1" value="<?php echo $QZ0400C1; ?>"></td>
		<td><input type="text" size="27" name="QZ0400C2" value="<?php echo $QZ0400C2; ?>"></td>
		<td><input type="text" size="19" name="QZ0400C3" value="<?php echo $QZ0400C3; ?>"></td>
      </tr> 
<!-------------------------------------------->
	  <tr> 
		<td align="left" valign="top">
		  <ul><li value="4"><input type="text" size="24" name="QZ0400D" value="<?php echo $QZ0400D; ?>"></ul><br>
		</td>
		<td><?php if (substr($url[3],0,5)!="print"){ if($Z0400D_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><input type="text" size="24" name="QZ0400D1" value="<?php echo $QZ0400D1; ?>"></td>
		<td><input type="text" size="27" name="QZ0400D2" value="<?php echo $QZ0400D2; ?>"></td>
		<td><input type="text" size="19" name="QZ0400D3" value="<?php echo $QZ0400D3; ?>"></td>
      </tr> 
<!-------------------------------------------->
	  <tr> 
		<td align="left" valign="top">
		  <ul><li value="5"><input type="text" size="24" name="QZ0400E" value="<?php echo $QZ0400E; ?>"></ul><br>
		</td>
		<td><?php if (substr($url[3],0,5)!="print"){ if($Z0400E_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><input type="text" size="24" name="QZ0400E1" value="<?php echo $QZ0400E1; ?>"></td>
		<td><input type="text" size="27" name="QZ0400E2" value="<?php echo $QZ0400E2; ?>"></td>
		<td><input type="text" size="19" name="QZ0400E3" value="<?php echo $QZ0400E3; ?>"></td>
      </tr> 
<!-------------------------------------------->
	  <tr> 
		<td align="left" valign="top">
		  <ul><li value="6"><input type="text" size="24" name="QZ0400F" value="<?php echo $QZ0400F; ?>"></ul><br>
		</td>
		<td><?php if (substr($url[3],0,5)!="print"){ if($Z0400F_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><input type="text" size="24" name="QZ0400F1" value="<?php echo $QZ0400F1; ?>"></td>
		<td><input type="text" size="27" name="QZ0400F2" value="<?php echo $QZ0400F2; ?>"></td>
		<td><input type="text" size="19" name="QZ0400F3" value="<?php echo $QZ0400F3; ?>"></td>
      </tr> 
<!-------------------------------------------->
	  <tr> 
		<td align="left" valign="top">
		  <ul><li value="7"><input type="text" size="24" name="QZ0400G" value="<?php echo $QZ0400G; ?>"></ul><br>
		</td>
		<td><?php if (substr($url[3],0,5)!="print"){ if($Z0400G_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><input type="text" size="24" name="QZ0400G1" value="<?php echo $QZ0400G1; ?>"></td>
		<td><input type="text" size="27" name="QZ0400G2" value="<?php echo $QZ0400G2; ?>"></td>
		<td><input type="text" size="19" name="QZ0400G3" value="<?php echo $QZ0400G3; ?>"></td>
      </tr> 
<!-------------------------------------------->
	  <tr> 
		<td align="left" valign="top">
		  <ul><li value="8"><input type="text" size="24" name="QZ0400H" value="<?php echo $QZ0400H; ?>"></ul><br>
		</td>
		<td><?php if (substr($url[3],0,5)!="print"){ if($Z0400H_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><input type="text" size="24" name="QZ0400H1" value="<?php echo $QZ0400H1; ?>"></td>
		<td><input type="text" size="27" name="QZ0400H2" value="<?php echo $QZ0400H2; ?>"></td>
		<td><input type="text" size="19" name="QZ0400H3" value="<?php echo $QZ0400H3; ?>"></td>
      </tr> 
<!-------------------------------------------->
	  <tr> 
		<td align="left" valign="top">
		  <ul><li value="9"><input type="text" size="24" name="QZ0400I" value="<?php echo $QZ0400I; ?>"></ul><br>
		</td>
		<td><?php if (substr($url[3],0,5)!="print"){ if($Z0400I_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><input type="text" size="24" name="QZ0400I1" value="<?php echo $QZ0400I1; ?>"></td>
		<td><input type="text" size="27" name="QZ0400I2" value="<?php echo $QZ0400I2; ?>"></td>
		<td><input type="text" size="19" name="QZ0400I3" value="<?php echo $QZ0400I3; ?>"></td>
      </tr> 
<!-------------------------------------------->
	  <tr> 
		<td align="left" valign="top">
		  <ul><li value="10"><input type="text" size="24" name="QZ0400J" value="<?php echo $QZ0400J; ?>"></ul><br>
		</td>
		<td><?php if (substr($url[3],0,5)!="print"){ if($Z0400J_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><input type="text" size="24" name="QZ0400J1" value="<?php echo $QZ0400J1; ?>"></td>
		<td><input type="text" size="27" name="QZ0400J2" value="<?php echo $QZ0400J2; ?>"></td>
		<td><input type="text" size="19" name="QZ0400J3" value="<?php echo $QZ0400J3; ?>"></td>
      </tr> 
<!-------------------------------------------->
	  <tr> 
		<td align="left" valign="top">
		  <ul><li value="11"><input type="text" size="24" name="QZ0400K" value="<?php echo $QZ0400K; ?>"></ul><br>
		</td>
		<td><?php if (substr($url[3],0,5)!="print"){ if($Z0400K_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><input type="text" size="24" name="QZ0400K1" value="<?php echo $QZ0400K1; ?>"></td>
		<td><input type="text" size="27" name="QZ0400K2" value="<?php echo $QZ0400K2; ?>"></td>
		<td><input type="text" size="19" name="QZ0400K3" value="<?php echo $QZ0400K3; ?>"></td>
      </tr> 
<!-------------------------------------------->
	  <tr> 
		<td align="left" valign="top">
		  <ul><li value="12"><input type="text" size="24" name="QZ0400L" value="<?php echo $QZ0400L; ?>"></ul><br>
		</td>
		<td><?php if (substr($url[3],0,5)!="print"){ if($Z0400L_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><input type="text" size="24" name="QZ0400L1" value="<?php echo $QZ0400L1; ?>"></td>
		<td><input type="text" size="27" name="QZ0400L2" value="<?php echo $QZ0400L2; ?>"></td>
		<td><input type="text" size="19" name="QZ0400L3" value="<?php echo $QZ0400L3; ?>"></td>
      </tr> 
<!-------------------------------------------->
	  <tr>
	    <td class="part" colspan="5"><b>Z0500. Signature of RN Assessment Coordinator Verifying Assessment Completion</b></td>
	  </tr>
<!-------------------------------------------->
	  <tr> 
	    <td class="content"></td>
		<td align="left" valign="top" colspan="2">
		  <ul><li><b>Signature:</b><ul>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		  <input type="text" size="24" name="QZ0500A" value="<?php echo $QZ0500A; ?>">
		</td>
		<td align="left" valign="top" colspan="2">
		  <ul><li value="2"><b>Date RN Assessment Coordinator signed <br>assessment as complete:</b>
		    <table cellspacing="0"><br>
              <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0500B_1" value="<?php echo $QZ0500B_1; ?>" onkeyup="if(this.value.length==1)document.form41.QZ0500B_2.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0500B_2" value="<?php echo $QZ0500B_2; ?>" onkeyup="if(this.value.length==0)document.form41.QZ0500B_1.focus();if(this.value.length==1)document.form41.QZ0500B_3.focus();"></td>
			  <td>-</td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0500B_3" value="<?php echo $QZ0500B_3; ?>" onkeyup="if(this.value.length==0)document.form41.QZ0500B_2.focus();if(this.value.length==1)document.form41.QZ0500B_4.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0500B_4" value="<?php echo $QZ0500B_4; ?>" onkeyup="if(this.value.length==0)document.form41.QZ0500B_3.focus();if(this.value.length==1)document.form41.QZ0500B_5.focus();"></td>
        	  <td>-</td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0500B_5" value="<?php echo $QZ0500B_5; ?>" onkeyup="if(this.value.length==0)document.form41.QZ0500B_4.focus();if(this.value.length==1)document.form41.QZ0500B_6.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0500B_6" value="<?php echo $QZ0500B_6; ?>" onkeyup="if(this.value.length==0)document.form41.QZ0500B_5.focus();if(this.value.length==1)document.form41.QZ0500B_7.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0500B_7" value="<?php echo $QZ0500B_7; ?>" onkeyup="if(this.value.length==0)document.form41.QZ0500B_6.focus();if(this.value.length==1)document.form41.QZ0500B_8.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0500B_8" value="<?php echo $QZ0500B_8; ?>" onkeyup="if(this.value.length==0)document.form41.QZ0500B_7.focus();"></td>
		    </table>
		      <a style="padding-left:23px">Month</a><a style="padding-left:68px">Day</a><a style="padding-left:114px">Year</a>
		  </ul>
		</td>
      </tr> 
    </table>
<!-------------------------------------------->
    <p align="center">
      <input type="hidden" name="formID" id="formID" value="mdsform41">
      <input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
      <button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
      <input type="reset" value="Reset"></p>
	<p style="padding-left:15px; color:rgb(220,220,220)"><b>Legal Notice Regarding MDS 3.0</b> - Copyright 2011 United States of America and InterRAI. This work may be freely used and <br>distributed solely within the United States. Portions of the MDS 3.0 are under separate copyright protections; Pfizer Inc. holds <br>the copyright for the PHQ-9 and the Annals of Internal Medicine holds the copyright for the CAM. Both Pfizer Inc. and the Annals <br>of Internal Medicine have granted permission to freely use these instruments in association with the MDS 3.0.</p>
	<p style="font-size:10px; color:black">MDS 3.0 Nursing Home Comprehensive (NC) Version 1.12.0 Effective 10/01/2014</p>
    </form>	
  </body>