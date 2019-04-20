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
$sql = "SELECT * FROM `mdsform43` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
	  td.section {font-size:14px}
	  td.answer {background-color:rgb(221,228,255); border:1px solid black; width:20px; height:20px; text-align:center}
	  td.answer2 {background-color:rgb(221,228,255); border:1px solid black; width:10px; height:10px; text-align:center}
	  td.part {height:20px; text-align:left; padding-left:5px}
	  td.partwhite {background-color:rgb(255,255,255); height:20px; text-align:left; padding-left:29px}
	  td.content {text-align:center; font-size:xx-small; width:70px}
	  td.content2 {text-align:left; padding-left:5px}
	  ul {list-style:upper-alpha; padding:0px; padding-left:22px; margin:0px}
	  ol {list-style:decimal; padding:0px; padding-left:40px; margin:0px}
	  ol.zero {list-style:decimal-leading-zero}
	td.sectiontop1 {border:0px solid black; width:300px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop2 {border:0px solid black; width:150px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop3 {border:0px solid black; width:100px; text-align:left; margin:0px; padding-left:10px}
</style>
  <body>
    <form name="formS2" method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
    <table cellspacing="0" align="center" style="font-size:16px"><tr><td>Resident:</td><td class="sectiontop1"><font size="3"><b><?php echo $name; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Identifier:</td><td class="sectiontop2"><font size="3"><b><?php echo $_SESSION['ncareName_lwj']; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Date:</td><td class="sectiontop3"><font size="3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script></font><input type="text" size="18" name="date" id="date" value="<?php echo formatdate_Ymd_Slash($date);?>"></b></font><hr color="black" align="left" width="100%" size="1"></td></tr></table>
    <table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1" style="margin-bottom:3px">
      <tr>
        <td class="section" width="150"><b style="padding-left:5px">Section S</b></td>
        <td class="section" width="720"><b style="padding-left:5px">Massachusetts State-Specific Items</b></td>
      </tr>
    </table>
<!-------------------------------------------->
	<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1">
      <tr>
	    <td class="part" colspan="2">
		  <b>S0173. Goals Of Care</b>
		</td>
	  </tr>
<!-------------------------------------------->
      <tr> 
	    <td class="content" width="70">
		  <table align="center" cellspacing="0">
		    <td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($S0173_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
		  </table>
		</td>
		<td width="800">
		  <b style="padding-left:5px">Is there documentation in the medical record that a discussion of</b><br>
          <b style="padding-left:5px">goals of care with the resident or legal healthcare representative</b><br>
          <b style="padding-left:5px">occurred since the last comprehensive OBRA assessment was</b><br>
          <b style="padding-left:5px">completed? (answer "9" if this is an admission assessment)</b>
          <ol start="0">
            <li><input type="radio" name="QS0173" value="0" <?php if($QS0173=="0") echo "checked";?>>No
			<li><input type="radio" name="QS0173" value="1" <?php if($QS0173=="1") echo "checked";?>>Yes
			<li value="9"><input type="radio" name="QS0173" value="9" <?php if($QS0173=="9") echo "checked";?>>Not Applicable
          </ol>		  
		</td>
      </tr>	  	  
<!-------------------------------------------->
      <tr>
	    <td class="part" colspan="2">
		  <b>S6230. Has Resident Received Antipsychotic</b>
		</td>
	  </tr>
<!-------------------------------------------->
      <tr> 
	    <td class="content">
		  <table align="center" cellspacing="0">
		    <td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($S6230_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
		  </table>
		</td>
		<td>
		  <b style="padding-left:5px">Has this resident received an antipsychotic medication since the</b><br>
		  <b style="padding-left:5px">ARD of the last OBRA assessment, or, if this is an admission</b><br>
		  <b style="padding-left:5px">assessment, since the Entry Date (A1600)? (if you answer "no", skip</b><br>
		  <b style="padding-left:5px">questions S6232, S6234, S6236, and S2060)</b>
          <ol start="0">
            <li><input type="radio" name="QS6230" value="0" <?php if($QS6230=="0") echo "checked";?>>No
			<li><input type="radio" name="QS6230" value="1" <?php if($QS6230=="1") echo "checked";?>>Yes
          </ol>		  
		</td>
      </tr>	  	  
<!-------------------------------------------->
      <tr>
	    <td class="part" colspan="2">
		  <b>S6232. Is Resident Currently Receiving Antipsychotic</b>
		</td>
	  </tr>
<!-------------------------------------------->
      <tr> 
	    <td class="content">
		  <table align="center" cellspacing="0">
		    <td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($S6232_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
		  </table>
		</td>
		<td>
		  <b style="padding-left:5px">Is the resident currently receiving an antipsychotic medication? (if</b><br>
		  <b style="padding-left:5px">you answer "no", skip questions S6234 and S6236)</b>
          <ol start="0">
            <li><input type="radio" name="QS6232" value="0" <?php if($QS6232=="0") echo "checked";?>>No
			<li><input type="radio" name="QS6232" value="1" <?php if($QS6232=="1") echo "checked";?>>Yes
          </ol>		  
		</td>
      </tr>	  	  
<!-------------------------------------------->
      <tr>
	    <td class="part" colspan="2">
		  <b>S6234. Attempt to Reduce Amount of Antipsychotic</b>
		</td>
	  </tr>
<!-------------------------------------------->
      <tr> 
	    <td class="content">
		  <table align="center" cellspacing="0">
		    <td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($S6234_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
		  </table>
		</td>
		<td>
		  <b style="padding-left:5px">Has an attempt been made to reduce the total amount of</b><br>
		  <b style="padding-left:5px">antipsychotic medication the resident receives since the ARD</b><br>
		  <b style="padding-left:5px">of the last OBRA assessment, or, if this is an admission</b><br>
		  <b style="padding-left:5px">assessment, since the Entry Date (A1600)? (if you answer "no",</b><br>
		  <b style="padding-left:5px">skip question S6236)</b>
          <ol start="0">
            <li><input type="radio" name="QS6234" value="0" <?php if($QS6234=="0") echo "checked";?>>No
			<li><input type="radio" name="QS6234" value="1" <?php if($QS6234=="1") echo "checked";?>>Yes
          </ol>		  
		</td>
      </tr>	  	  
<!-------------------------------------------->
      <tr>
	    <td class="part" colspan="2">
		  <b>S6236. Was Reduction in Antipsychotic Maintained</b>
		</td>
	  </tr>
<!-------------------------------------------->
      <tr> 
	    <td class="content">
		  <table align="center" cellspacing="0">
		    <td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($S6236_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
		  </table>
		</td>
		<td>
		  <b style="padding-left:5px">Was the reduction in the total amount of antipsychotic</b><br>
          <b style="padding-left:5px">medication that the resident receives maintained?</b>
          <ol start="0">
            <li><input type="radio" name="QS6236" value="0" <?php if($QS6236=="0") echo "checked";?>>No
			<li><input type="radio" name="QS6236" value="1" <?php if($QS6236=="1") echo "checked";?>>Yes
          </ol>		  
		</td>
      </tr>	  	  
<!-------------------------------------------->
      <tr>
	    <td class="part" colspan="2">
		  <b>S2060.<?php if (substr($url[3],0,5)!="print"){ if($S2060_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?> Resident Centered Care - For this resident, are any of the non‐pharmacological resident centered care
		  <br>techniques supported by the programs listed below included in the individualized resident centered care approach?
		  <br>Check all items that apply:</b>
		</td>
	  </tr>
<!-------------------------------------------->
	  <tr> 
	    <td class="content">
		    <input type="checkbox" name="QS2060A" value="X" <?php if($QS2060A=="X") echo "checked";?>>
		</td>
		<td>
		  <ul>
		    <li>Oasis
		  </ul>
		</td>
      </tr>
<!-------------------------------------------->
      <tr> 
	    <td class="content">
		    <input type="checkbox" name="QS2060B" value="X" <?php if($QS2060B=="X") echo "checked";?>>
		</td>
		<td>
		  <ul>
		    <li value="2">Habilitation Therapy
		  </ul>
		</td>
      </tr>
<!-------------------------------------------->
	  <tr> 
	    <td class="content">
		    <input type="checkbox" name="QS2060C" value="X" <?php if($QS2060C=="X") echo "checked";?>>
		</td>
		<td>
		  <ul>
		    <li value="3">Hand in Hand
		  </ul>
		</td>
      </tr>
<!-------------------------------------------->
	  <tr> 
	    <td class="content">
		    <input type="checkbox" name="QS2060D" value="X" <?php if($QS2060D=="X") echo "checked";?>>
		</td>
		<td>
		  <ul>
		    <li value="4">Consistent Assignment
		  </ul>
		</td>
      </tr>
<!-------------------------------------------->
	  <tr> 
	    <td class="content">
		    <input type="checkbox" name="QS2060E" value="X" <?php if($QS2060E=="X") echo "checked";?>>
		</td>
		<td>
		  <ul>
		    <li value="5">Other
		  </ul>
		</td>
      </tr>
<!-------------------------------------------->
	  <tr> 
	    <td class="content">
		    <input type="checkbox" name="QS2060Z" value="X" <?php if($QS2060Z=="X") echo "checked";?>>
		</td>
		<td>
		  <ul>
		    <li value="26">None of the above
		  </ul>
		</td>
      </tr>
	</table>
<!-------------------------------------------->
    <p align="center">
      <input type="hidden" name="formID" id="formID" value="mdsform43">
      <input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
      <button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
      <input type="reset" value="Reset"></p>
	<p style="font-size:10px; color:black">MA Section S Form - Effective 10/01/2013</p>
	</form>
  </body>