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
$sql = "SELECT * FROM `mdsform42` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
    <form name="formS1" method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
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
		  <b>S0170. Advanced Directives<?php if (substr($url[3],0,5)!="print"){ if($S0170_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?> - For those items with supporting documentation in the medical record, check all that apply:</b>
		</td>
	  </tr>
<!-------------------------------------------->
	  <tr> 
	    <td class="content" width="70">
		    <input type="checkbox" name="QS0170A" value="X" <?php if($QS0170A=="X") echo "checked";?>>
		</td>
		<td width="800">
		  <ul>
		    <li>Guardian
		  </ul>
		</td>
      </tr>
<!-------------------------------------------->
      <tr> 
	    <td class="content">
		    <input type="checkbox" name="QS0170B" value="X" <?php if($QS0170B=="X") echo "checked";?>>
		</td>
		<td>
		  <ul>
		    <li value="2">DPOA-HC
		  </ul>
		</td>
      </tr>
<!-------------------------------------------->
	  <tr> 
	    <td class="content">
		    <input type="checkbox" name="QS0170C" value="X" <?php if($QS0170C=="X") echo "checked";?>>
		</td>
		<td>
		  <ul>
		    <li value="3">Living Will
		  </ul>
		</td>
      </tr>
<!-------------------------------------------->
	  <tr> 
	    <td class="content">
		    <input type="checkbox" name="QS0170D" value="X" <?php if($QS0170D=="X") echo "checked";?>>
		</td>
		<td>
		  <ul>
		    <li value="4">Do Not Resuscitate
		  </ul>
		</td>
      </tr>
<!-------------------------------------------->
	  <tr> 
	    <td class="content">
		    <input type="checkbox" name="QS0170E" value="X" <?php if($QS0170E=="X") echo "checked";?>>
		</td>
		<td>
		  <ul>
		    <li value="5">Do Not Hospitalize
		  </ul>
		</td>
      </tr>
<!-------------------------------------------->
	  <tr> 
	    <td class="content">
		    <input type="checkbox" name="QS0170F" value="X" <?php if($QS0170F=="X") echo "checked";?>>
		</td>
		<td>
		  <ul>
		    <li value="6">Do Not Intubate
		  </ul>
		</td>
      </tr>
<!-------------------------------------------->
      <tr> 
	    <td class="content">
		    <input type="checkbox" name="QS0170G" value="X" <?php if($QS0170G=="X") echo "checked";?>>
		</td>
		<td>
		  <ul>
		    <li value="7">Feeding Restrictions
		  </ul>
		</td>
      </tr>
<!-------------------------------------------->
      <tr> 
	    <td class="content">
		    <input type="checkbox" name="QS0170H" value="X" <?php if($QS0170H=="X") echo "checked";?>>
		</td>
		<td>
		  <ul>
		    <li value="8">Other Treatment Restrictions
		  </ul>
		</td>
      </tr>
<!-------------------------------------------->
	  <tr> 
	    <td class="content">
		    <input type="checkbox" name="QS0170Z" value="X" <?php if($QS0170Z=="X") echo "checked";?>>
		</td>
		<td>
		  <ul>
		    <li value="26">None Of The Above
		  </ul>
		</td>
      </tr>
<!-------------------------------------------->
	  <tr>
	    <td class="part" colspan="2">
		  <b>S0171. Health Care Proxy</b>
		</td>
	  </tr>
<!-------------------------------------------->
	  <tr> 
	    <td class="content">
		  <table align="center" cellspacing="0">
		    <td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($S0171A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
		  </table>
		</td>
		<td>
		  <ul>
		    <li><b>Does resident have a health care proxy?</b>
		  </ul>
          <ol start="0">
            <li><input type="radio" name="QS0171A" value="0" <?php if($QS0171A=="0") echo "checked";?>>No
			<li><input type="radio" name="QS0171A" value="1" <?php if($QS0171A=="1") echo "checked";?>>Yes
          </ol>		  
		</td>
      </tr>	  	  
<!-------------------------------------------->
	  <tr> 
	    <td class="content">
		  <table align="center" cellspacing="0">
		    <td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($S0171B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
		  </table>
		</td>
		<td>
		  <ul>
		    <li value="2"><b>Has health care proxy been invoked?</b>
		  </ul>
          <ol start="0">
            <li><input type="radio" name="QS0171B" value="0" <?php if($QS0171B=="0") echo "checked";?>>No
			<li><input type="radio" name="QS0171B" value="1" <?php if($QS0171B=="1") echo "checked";?>>Yes
          </ol>		  
		</td>
      </tr>	  	  
<!-------------------------------------------->
	  <tr>
	    <td class="part" colspan="2">
		  <b>S0172. Goals Of Care</b>
		</td>
	  </tr>
<!-------------------------------------------->
	  <tr> 
	    <td class="content">
		  <table align="center" cellspacing="0">
		    <td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($S0172A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
		  </table>
		</td>
		<td>
		  <ul>
		    <li><b>On admission, was documentation received by the facility from <br>the referring provider that a discussion of goals of care with the <br>resident or legal healthcare representative occurred?</b>
		  </ul>
          <ol start="0">
            <li><input type="radio" name="QS0172A" value="0" <?php if($QS0172A=="0") echo "checked";?>>No
			<li><input type="radio" name="QS0172A" value="1" <?php if($QS0172A=="1") echo "checked";?>>Yes
			<li value="9"><input type="radio" name="QS0172A" value="9" <?php if($QS0172A=="9") echo "checked";?>>Not Applicable
          </ol>	
		</td>
      </tr>	  	  
<!-------------------------------------------->
	  <tr> 
	    <td class="content"></td>
		<td>
		  <b style="padding-left:5px"><?php if (substr($url[3],0,5)!="print"){ if($S0172B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>If you answered `yes' to question S0172A, in which setting(s) did the </b><br><b style="padding-left:5px">discussion take place? (check all that apply):</b>
		</td>
      </tr>
<!-------------------------------------------->
	  <tr> 
	    <td class="content">
		    <input type="checkbox" name="QS0172B" value="X" <?php if($QS0172B=="X") echo "checked";?>>
		</td>
		<td>
		  <ul>
		    <li value="2">Hospital
		  </ul>
		</td>
      </tr>
<!-------------------------------------------->
	  <tr> 
	    <td class="content">
		    <input type="checkbox" name="QS0172C" value="X" <?php if($QS0172C=="X") echo "checked";?>>
		</td>
		<td>
		  <ul>
		    <li value="3">Previous Nursing Home
		  </ul>
		</td>
      </tr>
<!-------------------------------------------->
	  <tr> 
	    <td class="content">
		    <input type="checkbox" name="QS0172D" value="X" <?php if($QS0172D=="X") echo "checked";?>>
		</td>
		<td>
		  <ul>
		    <li value="4">Home without Home Health Services
		  </ul>
		</td>
      </tr>
<!-------------------------------------------->
	  <tr> 
	    <td class="content">
		    <input type="checkbox" name="QS0172E" value="X" <?php if($QS0172E=="X") echo "checked";?>>
		</td>
		<td>
		  <ul>
		    <li value="5">Home with Home Health Services
		  </ul>
		</td>
      </tr>
<!-------------------------------------------->
	  <tr> 
	    <td class="content">
		    <input type="checkbox" name="QS0172F" value="X" <?php if($QS0172F=="X") echo "checked";?>>
		</td>
		<td>
		  <ul>
		    <li value="6">PCP Office
		  </ul>
		</td>
      </tr>
<!-------------------------------------------->
      <tr> 
	    <td class="content">
		    <input type="checkbox" name="QS0172G" value="X" <?php if($QS0172G=="X") echo "checked";?>>
		</td>
		<td>
		  <ul>
		    <li value="7">Other
		  </ul>
		</td>
      </tr>
	</table>
<!-------------------------------------------->
    <p align="center">
      <input type="hidden" name="formID" id="formID" value="mdsform42">
      <input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
      <button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
      <input type="reset" value="Reset"></p>
	<p style="font-size:10px; color:black">Form continues on next page<p>
	<p style="font-size:10px; color:black">MA Section S Form - Effective 10/01/2013</p>
	</form>
  </body>