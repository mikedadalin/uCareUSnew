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
$sql = "SELECT * FROM `mdsform40` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
	  ol {list-style:decimal; padding:0px; padding-left:40px; margin:0px}
	  ol.zero {list-style:decimal-leading-zero}
	td.sectiontop1 {border:0px solid black; width:300px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop2 {border:0px solid black; width:150px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop3 {border:0px solid black; width:100px; text-align:left; margin:0px; padding-left:10px}
</style>
  <body>
    <form name="form40" method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
    <table cellspacing="0" align="center" style="font-size:16px"><tr><td>Resident:</td><td class="sectiontop1"><font size="3"><b><?php echo $name; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Identifier:</td><td class="sectiontop2"><font size="3"><b><?php echo $_SESSION['ncareName_lwj']; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Date:</td><td class="sectiontop3"><font size="3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script></font><input type="text" size="18" name="date" id="date" value="<?php echo formatdate_Ymd_Slash($date);?>"></b></font><hr color="black" align="left" width="100%" size="1"></td></tr></table>
    <table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1" style="margin-bottom:3px">
      <tr>
		<td class="section2" width="150"><b style="padding-left:5px">Section Z</b></td>
		<td class="section2" width="720"><b style="padding-left:5px">Assessment Administration</b></td>
	  </tr>
    </table>
<!-------------------------------------------->
    <table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1" class="bordercolor"> 
   	  <tr>
	    <td class="part" colspan="2"><b>Z0100. Medicare Part A Billing</b></td>
	  </tr>
<!-------------------------------------------->
      <tr> 
		<td class="content" valign="bottom" width="70" rowspan="4">
		  Enter Code
		  <table align="center" cellspacing="0">
		    <td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($Z0100C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
		  </table>
		</td>
	  </tr>
	  <tr>
		<td width="800">
		  <ul>
		    <li><b>Medicare Part A HIPPS code</b><?php if (substr($url[3],0,5)!="print"){ if($Z0100A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?> (RUG group followed by assessment type indicator):
		    <table cellspacing="0"><br>
		      <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0100A_1" value="<?php echo $QZ0100A_1; ?>" onkeyup="if(this.value.length==1)document.form40.QZ0100A_2.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0100A_2" value="<?php echo $QZ0100A_2; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0100A_1.focus();if(this.value.length==1)document.form40.QZ0100A_3.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0100A_3" value="<?php echo $QZ0100A_3; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0100A_2.focus();if(this.value.length==1)document.form40.QZ0100A_4.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0100A_4" value="<?php echo $QZ0100A_4; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0100A_3.focus();if(this.value.length==1)document.form40.QZ0100A_5.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0100A_5" value="<?php echo $QZ0100A_5; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0100A_4.focus();if(this.value.length==1)document.form40.QZ0100A_6.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0100A_6" value="<?php echo $QZ0100A_6; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0100A_5.focus();if(this.value.length==1)document.form40.QZ0100A_7.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0100A_7" value="<?php echo $QZ0100A_7; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0100A_6.focus();"></td>
		    </table>
		  </ul>
		</td>
      </tr> 
<!-------------------------------------------->	 
      <tr> 
		<td>
          <ul>		
            <li value="2"><b>RUG version code:</b><?php if (substr($url[3],0,5)!="print"){ if($Z0100B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
		    <table cellspacing="0"><br>
		      <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0100B_1" value="<?php echo $QZ0100B_1; ?>" onkeyup="if(this.value.length==1)document.form40.QZ0100B_2.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0100B_2" value="<?php echo $QZ0100B_2; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0100B_1.focus();if(this.value.length==1)document.form40.QZ0100B_3.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0100B_3" value="<?php echo $QZ0100B_3; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0100B_2.focus();if(this.value.length==1)document.form40.QZ0100B_4.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0100B_4" value="<?php echo $QZ0100B_4; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0100B_3.focus();if(this.value.length==1)document.form40.QZ0100B_5.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0100B_5" value="<?php echo $QZ0100B_5; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0100B_4.focus();if(this.value.length==1)document.form40.QZ0100B_6.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0100B_6" value="<?php echo $QZ0100B_6; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0100B_5.focus();if(this.value.length==1)document.form40.QZ0100B_7.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0100B_7" value="<?php echo $QZ0100B_7; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0100B_6.focus();if(this.value.length==1)document.form40.QZ0100B_8.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0100B_8" value="<?php echo $QZ0100B_8; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0100B_7.focus();if(this.value.length==1)document.form40.QZ0100B_9.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0100B_9" value="<?php echo $QZ0100B_9; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0100B_8.focus();if(this.value.length==1)document.form40.QZ0100B_10.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0100B_10" value="<?php echo $QZ0100B_10; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0100B_9.focus();"></td>
		    </table>		  
		  </ul>
		</td>
      </tr>
<!-------------------------------------------->
	  <tr> 
		<td>
          <ul>		
            <li value="3"><b>Is this a Medicare Short Stay assessment?</b>
		  </ul>
            <ol start="0">
			  <li><input type="radio" name="QZ0100C" value="0" <?php if($QZ0100C=="0") echo "checked";?>><b>No</b>
			  <li><input type="radio" name="QZ0100C" value="1" <?php if($QZ0100C=="1") echo "checked";?>><b>Yes</b>
            </ol>			
		</td>
      </tr>
<!-------------------------------------------->
      <tr>
	    <td class="part" colspan="2"><b>Z0150. Medicare Part A Non-Therapy Billing</b></td>
	  </tr>
<!-------------------------------------------->
	  <tr> 
	    <td class="content" rowspan="3"></td>
	  </tr>
	  <tr>
		<td>
		  <ul>
		    <li><b>Medicare Part A non-therapy HIPPS code</b><?php if (substr($url[3],0,5)!="print"){ if($Z0150A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?> (RUG group followed by assessment type indicator):
		    <table cellspacing="0"><br>
		      <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0150A_1" value="<?php echo $QZ0150A_1; ?>" onkeyup="if(this.value.length==1)document.form40.QZ0150A_2.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0150A_2" value="<?php echo $QZ0150A_2; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0150A_1.focus();if(this.value.length==1)document.form40.QZ0150A_3.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0150A_3" value="<?php echo $QZ0150A_3; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0150A_2.focus();if(this.value.length==1)document.form40.QZ0150A_4.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0150A_4" value="<?php echo $QZ0150A_4; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0150A_3.focus();if(this.value.length==1)document.form40.QZ0150A_5.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0150A_5" value="<?php echo $QZ0150A_5; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0150A_4.focus();if(this.value.length==1)document.form40.QZ0150A_6.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0150A_6" value="<?php echo $QZ0150A_6; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0150A_5.focus();if(this.value.length==1)document.form40.QZ0150A_7.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0150A_7" value="<?php echo $QZ0150A_7; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0150A_6.focus();"></td>
		    </table>
		  </ul>
		</td>
      </tr> 
<!-------------------------------------------->	 
      <tr> 
  	    <td>
		  <ul>
		    <li value="2"><b>RUG version code:</b><?php if (substr($url[3],0,5)!="print"){ if($Z0150B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
		    <table cellspacing="0"><br>
		      <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0150B_1" value="<?php echo $QZ0150B_1; ?>" onkeyup="if(this.value.length==1)document.form40.QZ0150B_2.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0150B_2" value="<?php echo $QZ0150B_2; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0150B_1.focus();if(this.value.length==1)document.form40.QZ0150B_3.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0150B_3" value="<?php echo $QZ0150B_3; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0150B_2.focus();if(this.value.length==1)document.form40.QZ0150B_4.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0150B_4" value="<?php echo $QZ0150B_4; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0150B_3.focus();if(this.value.length==1)document.form40.QZ0150B_5.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0150B_5" value="<?php echo $QZ0150B_5; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0150B_4.focus();if(this.value.length==1)document.form40.QZ0150B_6.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0150B_6" value="<?php echo $QZ0150B_6; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0150B_5.focus();if(this.value.length==1)document.form40.QZ0150B_7.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0150B_7" value="<?php echo $QZ0150B_7; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0150B_6.focus();if(this.value.length==1)document.form40.QZ0150B_8.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0150B_8" value="<?php echo $QZ0150B_8; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0150B_7.focus();if(this.value.length==1)document.form40.QZ0150B_9.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0150B_9" value="<?php echo $QZ0150B_9; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0150B_8.focus();if(this.value.length==1)document.form40.QZ0150B_10.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0150B_10" value="<?php echo $QZ0150B_10; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0150B_9.focus();"></td>
		    </table>
          </ul>		  
		</td>
      </tr>
<!-------------------------------------------->
	  <tr>
	    <td class="part" colspan="2"><b>Z0200. State Medicaid Billing (if required by the state)</b></td>
	  </tr>
<!-------------------------------------------->
      <tr> 
	    <td class="content" rowspan="3"></td>
	  </tr>
	  <tr>
		<td>
		  <ul>
		    <li><b>RUG Case Mix group:</b><?php if (substr($url[3],0,5)!="print"){ if($Z0200A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
		    <table cellspacing="0"><br>
		      <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0200A_1" value="<?php echo $QZ0200A_1; ?>" onkeyup="if(this.value.length==1)document.form40.QZ0200A_2.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0200A_2" value="<?php echo $QZ0200A_2; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0200A_1.focus();if(this.value.length==1)document.form40.QZ0200A_3.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0200A_3" value="<?php echo $QZ0200A_3; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0200A_2.focus();if(this.value.length==1)document.form40.QZ0200A_4.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0200A_4" value="<?php echo $QZ0200A_4; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0200A_3.focus();if(this.value.length==1)document.form40.QZ0200A_5.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0200A_5" value="<?php echo $QZ0200A_5; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0200A_4.focus();if(this.value.length==1)document.form40.QZ0200A_6.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0200A_6" value="<?php echo $QZ0200A_6; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0200A_5.focus();if(this.value.length==1)document.form40.QZ0200A_7.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0200A_7" value="<?php echo $QZ0200A_7; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0200A_6.focus();if(this.value.length==1)document.form40.QZ0200A_8.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0200A_8" value="<?php echo $QZ0200A_8; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0200A_7.focus();if(this.value.length==1)document.form40.QZ0200A_9.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0200A_9" value="<?php echo $QZ0200A_9; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0200A_8.focus();if(this.value.length==1)document.form40.QZ0200A_10.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0200A_10" value="<?php echo $QZ0200A_10; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0200A_9.focus();"></td>
		    </table>
          </ul>		  
		</td>
      </tr>
<!-------------------------------------------->
	  <tr> 
		<td>
		  <ul>
		    <li value="2"><b>RUG version code:</b><?php if (substr($url[3],0,5)!="print"){ if($Z0200B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
		    <table cellspacing="0"><br>
		      <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0200B_1" value="<?php echo $QZ0200B_1; ?>" onkeyup="if(this.value.length==1)document.form40.QZ0200B_2.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0200B_2" value="<?php echo $QZ0200B_2; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0200B_1.focus();if(this.value.length==1)document.form40.QZ0200B_3.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0200B_3" value="<?php echo $QZ0200B_3; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0200B_2.focus();if(this.value.length==1)document.form40.QZ0200B_4.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0200B_4" value="<?php echo $QZ0200B_4; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0200B_3.focus();if(this.value.length==1)document.form40.QZ0200B_5.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0200B_5" value="<?php echo $QZ0200B_5; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0200B_4.focus();if(this.value.length==1)document.form40.QZ0200B_6.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0200B_6" value="<?php echo $QZ0200B_6; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0200B_5.focus();if(this.value.length==1)document.form40.QZ0200B_7.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0200B_7" value="<?php echo $QZ0200B_7; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0200B_6.focus();if(this.value.length==1)document.form40.QZ0200B_8.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0200B_8" value="<?php echo $QZ0200B_8; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0200B_7.focus();if(this.value.length==1)document.form40.QZ0200B_9.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0200B_9" value="<?php echo $QZ0200B_9; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0200B_8.focus();if(this.value.length==1)document.form40.QZ0200B_10.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0200B_10" value="<?php echo $QZ0200B_10; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0200B_9.focus();"></td>
		    </table>
		  </ul>
		</td>
      </tr>
<!-------------------------------------------->
	  <tr>
	    <td class="part" colspan="2"><b>Z0250. Alternate State Medicaid Billing (if required by the state)</b></td>
	  </tr>
<!-------------------------------------------->
      <tr> 
	    <td class="content" rowspan="3"></td>
	  </tr>
	  <tr>
		<td>
		  <ul>
		    <li><b>RUG Case Mix group:</b><?php if (substr($url[3],0,5)!="print"){ if($Z0250A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
		    <table cellspacing="0"><br>
		      <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0250A_1" value="<?php echo $QZ0250A_1; ?>" onkeyup="if(this.value.length==1)document.form40.QZ0250A_2.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0250A_2" value="<?php echo $QZ0250A_2; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0250A_1.focus();if(this.value.length==1)document.form40.QZ0250A_3.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0250A_3" value="<?php echo $QZ0250A_3; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0250A_2.focus();if(this.value.length==1)document.form40.QZ0250A_4.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0250A_4" value="<?php echo $QZ0250A_4; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0250A_3.focus();if(this.value.length==1)document.form40.QZ0250A_5.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0250A_5" value="<?php echo $QZ0250A_5; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0250A_4.focus();if(this.value.length==1)document.form40.QZ0250A_6.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0250A_6" value="<?php echo $QZ0250A_6; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0250A_5.focus();if(this.value.length==1)document.form40.QZ0250A_7.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0250A_7" value="<?php echo $QZ0250A_7; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0250A_6.focus();if(this.value.length==1)document.form40.QZ0250A_8.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0250A_8" value="<?php echo $QZ0250A_8; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0250A_7.focus();if(this.value.length==1)document.form40.QZ0250A_9.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0250A_9" value="<?php echo $QZ0250A_9; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0250A_8.focus();if(this.value.length==1)document.form40.QZ0250A_10.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0250A_10" value="<?php echo $QZ0250A_10; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0250A_9.focus();"></td>
		    </table>
          </ul>		  
		</td>
      </tr>
<!-------------------------------------------->
	  <tr> 
		<td>
		  <ul>
		    <li value="2"><b>RUG version code:</b><?php if (substr($url[3],0,5)!="print"){ if($Z0250B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
		    <table cellspacing="0"><br>
		      <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0250B_1" value="<?php echo $QZ0250B_1; ?>" onkeyup="if(this.value.length==1)document.form40.QZ0250B_2.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0250B_2" value="<?php echo $QZ0250B_2; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0250B_1.focus();if(this.value.length==1)document.form40.QZ0250B_3.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0250B_3" value="<?php echo $QZ0250B_3; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0250B_2.focus();if(this.value.length==1)document.form40.QZ0250B_4.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0250B_4" value="<?php echo $QZ0250B_4; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0250B_3.focus();if(this.value.length==1)document.form40.QZ0250B_5.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0250B_5" value="<?php echo $QZ0250B_5; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0250B_4.focus();if(this.value.length==1)document.form40.QZ0250B_6.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0250B_6" value="<?php echo $QZ0250B_6; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0250B_5.focus();if(this.value.length==1)document.form40.QZ0250B_7.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0250B_7" value="<?php echo $QZ0250B_7; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0250B_6.focus();if(this.value.length==1)document.form40.QZ0250B_8.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0250B_8" value="<?php echo $QZ0250B_8; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0250B_7.focus();if(this.value.length==1)document.form40.QZ0250B_9.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0250B_9" value="<?php echo $QZ0250B_9; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0250B_8.focus();if(this.value.length==1)document.form40.QZ0250B_10.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0250B_10" value="<?php echo $QZ0250B_10; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0250B_9.focus();"></td>
		    </table>
		  </ul>
		</td>
      </tr>
<!-------------------------------------------->
      <tr>
	    <td class="part" colspan="2"><b>Z0300. Insurance Billing</b></td>
	  </tr>
<!-------------------------------------------->
      <tr> 
	    <td class="content" rowspan="3"></td>
	  </tr>
	  <tr>
		<td>
		  <ul>
		    <li><b>RUG billing code:</b><?php if (substr($url[3],0,5)!="print"){ if($Z0300A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
		    <table cellspacing="0"><br>
		      <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0300A_1" value="<?php echo $QZ0300A_1; ?>" onkeyup="if(this.value.length==1)document.form40.QZ0300A_2.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0300A_2" value="<?php echo $QZ0300A_2; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0300A_1.focus();if(this.value.length==1)document.form40.QZ0300A_3.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0300A_3" value="<?php echo $QZ0300A_3; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0300A_2.focus();if(this.value.length==1)document.form40.QZ0300A_4.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0300A_4" value="<?php echo $QZ0300A_4; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0300A_3.focus();if(this.value.length==1)document.form40.QZ0300A_5.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0300A_5" value="<?php echo $QZ0300A_5; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0300A_4.focus();if(this.value.length==1)document.form40.QZ0300A_6.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0300A_6" value="<?php echo $QZ0300A_6; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0300A_5.focus();if(this.value.length==1)document.form40.QZ0300A_7.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0300A_7" value="<?php echo $QZ0300A_7; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0300A_6.focus();if(this.value.length==1)document.form40.QZ0300A_8.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0300A_8" value="<?php echo $QZ0300A_8; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0300A_7.focus();if(this.value.length==1)document.form40.QZ0300A_9.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0300A_9" value="<?php echo $QZ0300A_9; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0300A_8.focus();if(this.value.length==1)document.form40.QZ0300A_10.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0300A_10" value="<?php echo $QZ0300A_10; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0300A_9.focus();"></td>
		    </table>
          </ul>		  
		</td>
      </tr>
<!-------------------------------------------->
	  <tr> 
		<td>
		  <ul>
		    <li value="2"><b>RUG billing version:</b><?php if (substr($url[3],0,5)!="print"){ if($Z0300B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
		    <table cellspacing="0"><br>
		      <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0300B_1" value="<?php echo $QZ0300B_1; ?>" onkeyup="if(this.value.length==1)document.form40.QZ0300B_2.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0300B_2" value="<?php echo $QZ0300B_2; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0300B_1.focus();if(this.value.length==1)document.form40.QZ0300B_3.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0300B_3" value="<?php echo $QZ0300B_3; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0300B_2.focus();if(this.value.length==1)document.form40.QZ0300B_4.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0300B_4" value="<?php echo $QZ0300B_4; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0300B_3.focus();if(this.value.length==1)document.form40.QZ0300B_5.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0300B_5" value="<?php echo $QZ0300B_5; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0300B_4.focus();if(this.value.length==1)document.form40.QZ0300B_6.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0300B_6" value="<?php echo $QZ0300B_6; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0300B_5.focus();if(this.value.length==1)document.form40.QZ0300B_7.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0300B_7" value="<?php echo $QZ0300B_7; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0300B_6.focus();if(this.value.length==1)document.form40.QZ0300B_8.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0300B_8" value="<?php echo $QZ0300B_8; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0300B_7.focus();if(this.value.length==1)document.form40.QZ0300B_9.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0300B_9" value="<?php echo $QZ0300B_9; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0300B_8.focus();if(this.value.length==1)document.form40.QZ0300B_10.focus();"></td>
			  <td class="answer"><input type="text" size="1" maxlength="1" name="QZ0300B_10" value="<?php echo $QZ0300B_10; ?>" onkeyup="if(this.value.length==0)document.form40.QZ0300B_9.focus();"></td>
		    </table>
		  </ul>
		</td>
      </tr>
    </table>
<!-------------------------------------------->
    <p align="center">
      <input type="hidden" name="formID" id="formID" value="mdsform40">
      <input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
      <button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
      <input type="reset" value="Reset"></p>
    <p style="font-size:10px; color:black">MDS 3.0 Nursing Home Comprehensive (NC) Version 1.12.0 Effective 10/01/2014</p>
    </form>
  </body>