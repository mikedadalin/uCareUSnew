<?php
$pid = (int) @$_GET['pid'];
if (@$_GET['date']=='') {
	$sql = "SELECT * FROM `nurseform02h` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql = "SELECT * FROM `nurseform02h` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`='".mysql_escape_string($_GET['date'])."'";
}
$db1 = new DB;
$db1->query($sql);
$r1 = $db1->fetch_assoc();
if ($db1->num_rows()>0) {
	foreach ($r1 as $k=>$v) {
		if (substr($k,0,1)=="Q") {
			$arrAnswer = explode("_",$k);
			if (count($arrAnswer)==2) {
				if ($v==1) {
					if (${$arrAnswer[0]}!="") { ${$arrAnswer[0]} = ${$arrAnswer[0]}.';'; }
					${$arrAnswer[0]} .= $arrAnswer[1];
					if ($arrAnswer[1]=="2") { ${'s'.$arrAnswer[0]} = '1'; }
				}
			} else {
				${$k} = $v;
			}
		}  else {
			${$k} = $v;
		}
	}
}

$Qscore1 = $sQ1 + $sQ2 + $sQ3 + $sQ4 + $sQ5;
$Qscore2 = $sQ6 + $sQ7 + $sQ8 + $sQ9 + $sQ10;
$Qscore3 = $sQ11 + $sQ12 + $sQ13;
$Qscore4 = $sQ15 + $sQ16 + $sQ17 + $sQ18 + $sQ19;
$Qscore5 = $sQ20 + $sQ21 + $sQ22;
$Qscore6 = $sQ23 + $sQ24;
$Qscore7 = $sQ25;
$Qscore8 = $sQ26;
$Qscore9 = $sQ30;
$Qscore10 = $sQ27 + $sQ28 + $sQ29;
$Qscore11 = $sQ31;
?>
<form  method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<h3>Mini-Mental Status Examination (MMSE) </h3>
<iframe src="module/nurseform/form2h_chart.php?pid=<?php echo $pid; ?>" frameborder="0" width="940" height="170" class="printcol" ></iframe>
<table width="100%">
  <?php
        if (substr($url[3],0,5)!="print"){
  ?>	
   <tr>
    <td class="title" colspan="2">Is the resident able to participate with the assessment?</td>
    <td colspan="2">
	  <?php echo draw_option("Q34","No;Yes","m","single",$Q34,false,0); ?><br>
	  If "NO",please evaluate and fill the <a style="font-size:25px; color:red">*</a>questions
	</td>
  </tr> 
  <?php
		}
  ?>
  <tr class="title">
    <td width="40">&nbsp;</td>
    <td width="520">Question</td>
    <td width="60">Subtotal</td>
    <td width="320">Answer</td>
  </tr>
  <tr>
    <td class="title">1)</td>
    <td>   What is the year?</td>
    <td rowspan="5"><input type="text" id="Qscore1"  size="1" value="<?php echo $Qscore1; ?>"></td>
    <td>
	  <?php echo draw_option("Q1","Incorrect;Correct","m","single",$Q1,false,0); ?><br>
	  <?php
        if (substr($url[3],0,5)!="print"){
			echo draw_checkbox("Q1a","Missed by > 5 years or no answer;Missed by 2-5 years;Missed by 1 year",$Q1a,"single");
		}
	  ?>
	</td>
  </tr>
  <tr>
    <td class="title">2)</td>
    <td>   What is the month?</td>
    <td>
	  <?php echo draw_option("Q5","Incorrect;Correct","m","single",$Q5,false,0); ?><br>
      <?php
        if (substr($url[3],0,5)!="print"){
			echo draw_checkbox("Q5a","Missed by > 1 month or no answer;Missed by 6 days to 1 month;Accurate within 5 days",$Q5a,"single"); 
		}
	  ?>
	</td>
  </tr>
  <tr>
    <td class="title">3)</td>
    <td>   What is the date?</td>
    <td><?php echo draw_option("Q3","Incorrect;Correct","m","single",$Q3,false,0); ?></td>
  </tr>
  <tr>
    <td class="title">4)</td>
    <td>   What is the day?</td>
    <td><?php echo draw_option("Q4","Incorrect;Correct","m","single",$Q4,false,0); ?></td>
  </tr>
  <tr>
    <td class="title">5)</td>
    <td>   What is the season?<?php if (substr($url[3],0,5)!="print"){ echo '<a style="font-size:25px; color:red">*</a>';}?></td>
    <td><?php echo draw_option("Q2","Incorrect;Correct","m","single",$Q2,false,0); ?></td>
  </tr>
  <tr>
    <td class="title">6)</td>
    <td>   Where are we now?   (County)</td>
    <td rowspan="5"><input type="text" id="Qscore2" size="1" value="<?php echo $Qscore2; ?>"></td>
    <td><?php echo draw_option("Q8","Incorrect;Correct","m","single",$Q8,false,0); ?></td>
  </tr>
  <tr>
    <td class="title">7)</td>
    <td>   Where are we now?   (Town/city)</td>
    <td><?php echo draw_option("Q7","Incorrect;Correct","m","single",$Q7,false,0); ?></td>
  </tr>
  <tr>
    <td class="title">8)</td>
    <td>   Where are we now?   (Nursing home)<?php if (substr($url[3],0,5)!="print"){ echo '<a style="font-size:25px; color:red">*</a>';}?></td>
    <td><?php echo draw_option("Q6","Incorrect;Correct","m","single",$Q6,false,0); ?></td>
  </tr>
  <tr>
    <td class="title">9)</td>
    <td>   Where are we now?   (Floor)</td>
    <td><?php echo draw_option("Q9","Incorrect;Correct","m","single",$Q9,false,0); ?></td>
  </tr>
  <tr>
    <td class="title">10)</td>
    <td>   Where are we now?   (Location of own room)<?php if (substr($url[3],0,5)!="print"){ echo '<a style="font-size:25px; color:red">*</a>';}?></td>
    <td><?php echo draw_option("Q10","Incorrect;Correct","m","single",$Q10,false,0); ?></td>
  </tr>
  <?php
    if (substr($url[3],0,5)!="print"){
  ?>
  <tr>
    <td class="title"></td>
    <td>   Staff names and faces<?php if (substr($url[3],0,5)!="print"){ echo '<a style="font-size:25px; color:red">*</a>';}?></td>
	<td></td>
    <td><?php echo draw_option("Q33","Incorrect;Correct","m","single",$Q33,false,0); ?></td>
  </tr>
  <?php
    }
  ?>
  <tr>
    <td rowspan="5" valign="top" class="title">11)</td>
    <td colspan="3" class="title_s" style="text-align:left;">   Please memorize and repeat these 3 objects. (score based on the first respond)</td>
  </tr>
  <tr>
    <td>   Sock</td>
    <td rowspan="3"><input type="text" id="Qscore3" size="1" value="<?php echo $Qscore3; ?>"></td>
    <td><?php echo draw_option("Q11","Incorrect;Correct","m","single",$Q11,false,0); ?></td>
  </tr>
  <tr>
    <td>   Blue</td>
    <td><?php echo draw_option("Q12","Incorrect;Correct","m","single",$Q12,false,0); ?></td>
  </tr>
  <tr>
    <td>   Bed</td>
    <td><?php echo draw_option("Q13","Incorrect;Correct","m","single",$Q13,false,0); ?></td>
  </tr>
  <tr>
    <td colspan="2" align="right"><strong><em> Maximum repeat 3 times for practice. Practice:</em></strong></td>
    <td><?php echo draw_option("Q14","0;1;2;3;>3","s","single",$Q14,false,0); ?>time(s)</td>
  </tr>
  <tr>
    <td rowspan="6" valign="top" class="title">12)</td>
    <td colspan="3" class="title_s" style="text-align:left;">  I would like you to count backward from 100 by sevens./Spell WORLD backwards.<strong><em>(</em></strong><strong><em>Score 1 for corectly answering each number/letter</em></strong><strong><em>) </em></strong></td>
  </tr>
  <tr>
    <td>   93&nbsp;/&nbsp;D;       </td>
    <td rowspan="5"><input type="text" id="Qscore4" size="1" value="<?php echo $Qscore4; ?>"></td>
    <td><?php echo draw_option("Q15","Incorrect;Correct","m","single",$Q15,false,0); ?></td>
  </tr>
  <tr>
    <td>   86&nbsp;/&nbsp;L;</td>
    <td><?php echo draw_option("Q16","Incorrect;Correct","m","single",$Q16,false,0); ?></td>
  </tr>
  <tr>
    <td>   79&nbsp;/&nbsp;R;</td>
    <td><?php echo draw_option("Q17","Incorrect;Correct","m","single",$Q17,false,0); ?></td>
  </tr>
  <tr>
    <td>   72&nbsp;/&nbsp;O;</td>
    <td><?php echo draw_option("Q18","Incorrect;Correct","m","single",$Q18,false,0); ?></td>
  </tr>
  <tr>
    <td>   65&nbsp;/&nbsp;W;</td>
    <td><?php echo draw_option("Q19","Incorrect;Correct","m","single",$Q19,false,0); ?></td>
  </tr>
  <tr>
    <td rowspan="4" valign="top" class="title">13)</td>
    <td colspan="3" class="title_s" style="text-align:left;">Please state the 3 object that I asked you to memorize. (Each object score 1 regardless order)</td>
  </tr>
  <tr>
    <td>   Sock</td>
    <td rowspan="3"><input type="text" id="Qscore5" size="1" value="<?php echo $Qscore5; ?>"></td>
    <td>
	  <?php echo draw_option("Q20","Incorrect;Correct","m","single",$Q20,false,0); ?><br>
      <?php
        if (substr($url[3],0,5)!="print"){
			echo draw_checkbox("Q20a","Yes, after cueing (\"something to wear\");Yes, no cue required",$Q20a,"single"); 
		}
	  ?>
	</td>
  </tr>
  <tr>
    <td>   Blue</td>
    <td>
	  <?php echo draw_option("Q21","Incorrect;Correct","m","single",$Q21,false,0); ?><br>
	  <?php
        if (substr($url[3],0,5)!="print"){
			echo draw_checkbox("Q21a","Yes, after cueing (\"a color\");Yes, no cue required",$Q21a,"single"); 
		}
	  ?>
	</td>
  </tr>
  <tr>
    <td>   Bed</td>
    <td>
	  <?php echo draw_option("Q22","Incorrect;Correct","m","single",$Q22,false,0); ?><br>
	  <?php
        if (substr($url[3],0,5)!="print"){
			echo draw_checkbox("Q22a","Yes, after cueing (\"a piece of furniture\");Yes, no cue required",$Q22a,"single"); 
		}
	  ?>
	</td>
  </tr>
  <tr>
    <td class="title">14)</td>
    <td>   What is this?   (Show the patient a watch)</td>
    <td rowspan="2"><input type="text" id="Qscore6" size="1" value="<?php echo $Qscore6; ?>"></td>
    <td><?php echo draw_option("Q23","Incorrect;Correct","m","single",$Q23,false,0); ?></td>
  </tr>
  <tr>
    <td class="title">15)</td>
    <td>   What is this?   (Show the patient a pen)</td>
    <td><?php echo draw_option("Q24","Incorrect;Correct","m","single",$Q24,false,0); ?></td>
  </tr>
  <tr>
    <td class="title">16)</td>
    <td>   Repeat the phrase: "No ifs, ands, or buts."</td>
    <td><input type="text" id="Qscore7" size="1" value="<?php echo $Qscore7; ?>"></td>
    <td><?php echo draw_option("Q25","Incorrect;Correct","m","single",$Q25,false,0); ?></td>
  </tr>
  <tr>
    <td class="title">17)</td>
    <td>   “Please read this and do what it says.”<br>   (Written instruction is “Close your eyes.”)</td>
    <td><input type="text" id="Qscore8" size="1" value="<?php echo $Qscore8; ?>"></td>
    <td><?php echo draw_option("Q26","Incorrect;Correct","m","single",$Q26,false,0); ?></td>
  </tr>
  <tr>
    <td class="title">18)</td>
    <td>   “Make up and write a sentence about anything.”<br>   (This sentence must contain a noun and a verb.)</td>
    <td><input type="text" id="Qscore9" size="1" value="<?php echo $Qscore9; ?>"></td>
    <td><?php echo draw_option("Q30","Incorrect;Correct","m","single",$Q30,false,0); ?></td>
  </tr>
  <tr>
    <td rowspan="4" valign="top" class="title">19)</td>
    <td colspan="3" class="title_s" style="text-align:left;">   The examiner gives the patient a piece of blank paper</td>
  </tr>
  <tr>
    <td>   Take the paper in your right hand</td>
    <td rowspan="3"><input type="text" id="Qscore10" size="1" value="<?php echo $Qscore10; ?>"></td>
    <td><?php echo draw_option("Q27","Incorrect;Correct","m","single",$Q27,false,0); ?></td>
  </tr>
  <tr>
    <td>   Fold it in half</td>
    <td><?php echo draw_option("Q28","Incorrect;Correct","m","single",$Q28,false,0); ?></td>
  </tr>
  <tr>
    <td>   Put it on the floor</td>
    <td><?php echo draw_option("Q29","Incorrect;Correct","m","single",$Q29,false,0); ?></td>
  </tr>
  <tr>
    <td rowspan="2" valign="top" class="title">20)</td>
    <td colspan="3" class="title_s" style="text-align:left;">   Please copy this picture.<br>   (The examiner gives the patient a blank piece of paper and asks him/her to draw the symbol below.)<br>   (All 10 angles must be present and two must intersect.)</td>
  </tr>
  <tr>
    <td valign="top"><img src="Images/mmse_pic.png" style="padding:20px;" height="60" /></td>
    <td valign="top"><input type="text" id="Qscore11" size="1" value="<?php echo $Qscore11; ?>"></td>
    <td valign="top"><?php echo draw_option("Q31","Incorrect;Correct","m","single",$Q31,false,0); ?></td>
  </tr>
  <tr>
    <td class="title">&nbsp;</td>
    <td colspan="2">Total score</td>
    <td><input type="text" name="Q32" id="Q32" size="4"  value="<?php echo $Q32; ?>" /></td>
  </tr>
  <tr>
    <td class="title">&nbsp;</td>
    <td colspan="3">
    Maximumly score 30.<br> 
	<b>Single Cutoff</b>: less than 24 is Abnorma<br>
	<b>Range</b>: less than 21=> Increased odds of dementia<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; more than 25=> Decreased odds of dementia.<br>
    <b>Education</b>: less than 21 is abnormal for 8th grade education.<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;less than 23 is abnormal for high school education.<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;less than 24 is abnormal for college education.<br>
	<b>Severity</b>: 24-30 has No cognitive impairment.<br>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;18-23 has Mild cognitive impairment.<br>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;0-17 has Severe cognitive impairment.
<!--      最高分為30分<br>
      24~30正常 9~12需進一步評估(可能為失智)<br>
      低於九分者視為失智症<br>
      與教育程度有關(教育程度差者低於15分則視為可能為失智)至少須達15分以上才為正常-->
    </td>
    </tr>
</table>
<table width="100%">
  <tr>

    <td>Filled date：<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if($_GET['newDate']!="") { echo formatdate($_GET['newDate']); } else { if ($date != NULL) { echo formatdate($date); } } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" /></td>
    <td align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>

  </tr>
</table>
<center><input type="hidden" name="formID" id="formID" value="nurseform02h" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></center>
</form><br><br>
<?php
$url = explode('/', $_SERVER['REQUEST_URI']);
$file = substr($url[3],0,5);
?>
<script>
$(document).ready(function () {
	<?php if ($file=="index") { echo '
	calcQtotal();
	$("[id*=\'btn_Q\']").click(function() {
		calcQtotal();
	});
	'; }
	?>
})
function calcQtotal() {
	var Qtotal = 0;
	var Q1=0;
	var Q2=0;
	var Q3=0;
	var Q4=0;
	var Q5=0;
	var Q6=0;
	var Q10=0;
	var arri={'25':'7','26':'8','30':'9','31':'11' };
	for (i=1;i<=31;i++) {
		if (i!=14) { if ($('#Q'+i+'_2').val()==1) { Qtotal += 1; } }
		if(i >= 1 && i <= 5){
			if ($('#Q'+i+'_2').val()==1) { Q1 += 1;}
			$("#Qscore1").val(Q1);
		}
		if(i >= 6 && i <= 10){
			if ($('#Q'+i+'_2').val()==1) { Q2 += 1;}
			$("#Qscore2").val(Q2);
		}
		if(i >= 11 && i <= 13){
			if ($('#Q'+i+'_2').val()==1) { Q3 += 1;}
			$("#Qscore3").val(Q3);
		}
		if(i >= 15 && i <= 19){
			if ($('#Q'+i+'_2').val()==1) { Q4 += 1;}
			$("#Qscore4").val(Q4);
		}
		if(i >= 20 && i <= 22){
			if ($('#Q'+i+'_2').val()==1) { Q5 += 1;}
			$("#Qscore5").val(Q5);
		}
		if(i >= 23 && i <= 24){
			if ($('#Q'+i+'_2').val()==1) { Q6 += 1;}
			$("#Qscore6").val(Q6);
		}
		if(i == 25 || i == 26 || i == 30 || i == 31){
			if ($('#Q'+i+'_2').val()==1) { $("#Qscore"+arri[i]).val(1); }else{ $("#Qscore"+arri[i]).val(0); }
		}
		if(i >= 27 && i <= 29){
			if ($('#Q'+i+'_2').val()==1) { Q10 += 1;}
			$("#Qscore10").val(Q10);
		}
	}
	$('#Q32').val(Qtotal);
}
</script>
<?php
if ($r1) {
foreach ($r1 as $k=>$v) {
	if (substr($k,0,1)=="Q") {
		$arrAnswer = explode("_",$k);
		if (count($arrAnswer)==2) {
			if ($v==1) {
				${$arrAnswer[0]} = "";
			}
		} else {
			${$k} = "";
		}
	}  else {
		${$k} = "";
	}
}
}
?>