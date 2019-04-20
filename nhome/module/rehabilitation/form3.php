<?php
if (@$_GET['date']=='') {
	$sql = "SELECT * FROM `rehabilitationform03` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql = "SELECT * FROM `rehabilitationform03` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`='".mysql_escape_string($_GET['date'])."'";
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
					${$arrAnswer[0]} .= $arrAnswer[1].';';
				}
			} else {
				${$k} = $v;
			}
		}  else {
			${$k} = $v;
		}
	}
}
?>
<h3>Preliminary assessment</h3>
<form  method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
  <table border="0" width="100%">
    <tr>
      <td colspan="3" class="title">(1) Activities of Daily Living (ADL) Skill:</td>
    </tr>
    <tr>
      <td rowspan="10" class="title_s">ADL</td>
      <td class="title_s">Personal hygiene</td>
      <td><?php echo draw_option("Q1","Independently;Need assistance","xl","multi",$Q1,false,2); ?></td>
    </tr>
    <tr>
      <td class="title_s">Bathing</td>
      <td><?php echo draw_option("Q2","Independently;Need assistance","xl","multi",$Q2,false,2); ?></td>
    </tr>
    <tr>
      <td class="title_s">Self-feeding</td>
      <td><?php echo draw_option("Q3","Independently;Need assistance;Totally dependent","xl","multi",$Q3,false,2); ?></td>
    </tr>
    <tr>
      <td class="title_s">Toileting</td>
      <td><?php echo draw_option("Q4","Independently;Need assistance;Totally dependent","xl","multi",$Q4,false,2); ?></td>
    </tr>
    <tr>
      <td class="title_s">Climbing stairs</td>
      <td><?php echo draw_option("Q5","Independently;Need assistance;Totally dependent","xl","multi",$Q5,false,2); ?></td>
    </tr>
    <tr>
      <td class="title_s">Dressing/Grooming</td>
      <td><?php echo draw_option("Q6","Independently;Need assistance;Totally dependent","xl","multi",$Q6,false,2); ?></td>
    </tr>
    <tr>
      <td class="title_s">Defecate control</td>
      <td><?php echo draw_option("Q7","Independently;Need assistance;Totally dependent","xl","multi",$Q7,false,2); ?></td>
    </tr>
    <tr>
      <td class="title_s">Urine control</td>
      <td><?php echo draw_option("Q8","Independently;Need assistance;Totally dependent","xl","multi",$Q8,false,2); ?></td>
    </tr>
    <tr>
      <td class="title_s">Transposing</td>
      <td><?php echo draw_option("Q9","Independently;Need assistance;Totally dependent","xl","multi",$Q9,false,2); ?></td>
    </tr>
    <tr>
      <td class="title_s">Ambulation</td>
      <td><?php echo draw_option("Q10","Independently;Need assistance;Totally dependent","xl","multi",$Q10,false,2); ?></td>
    </tr>
  </table>
  <table border="0">
    <tr>
      <td colspan="7" class="title">(2) Functionality Assessment:</td>
    </tr>
    <tr>
      <td colspan="3" rowspan="3" class="title_s">Joint activity</td>
      <td class="title_s">Shoulder</td>
      <td><?php echo draw_option("Q11","Normal;Limited (L);Limited (R)","xm","multi",$Q11,false,2); ?></td>
      <td class="title_s">Hip</td>
      <td><?php echo draw_option("Q12","Normal;Limited (L);Limited (R)","xm","multi",$Q12,false,2); ?></td>
    </tr>
    <tr>
      <td class="title_s">Elbow</td>
      <td><?php echo draw_option("Q13","Normal;Limited (L);Limited (R)","xm","multi",$Q13,false,2); ?></td>
      <td class="title_s">Knee</td>
      <td><?php echo draw_option("Q14","Normal;Limited (L);Limited (R)","xm","multi",$Q14,false,2); ?></td>
    </tr>
    <tr>
      <td class="title_s">Wrist</td>
      <td><?php echo draw_option("Q15","Normal;Limited (L);Limited (R)","xm","multi",$Q15,false,2); ?></td>
      <td class="title_s">Ankle</td>
      <td><?php echo draw_option("Q16","Normal;Limited (L);Limited (R)","xm","multi",$Q16,false,2); ?></td>
    </tr>
    <tr>
      <td colspan="3" class="title_s">Muscle tone</td>
      <td colspan="4" ><?php echo draw_option("Q17","Normal;Relaxation;Spasm","m","multi",$Q17,false,2); ?><input type="text" id="Q17a" name="Q17a" value="<?php echo $Q17a; ?>"></td>
    </tr>
    <tr>
      <td colspan="3" rowspan="7" class="title_s">Muscle strength </td>
      <td class="title_s">Left shoulder</td>
      <td><?php echo draw_option("Q18","0;1;2;3;4;5","ss","single",$Q18,true,6); ?></td>
      <td class="title_s">Right shoulder</td>
      <td><?php echo draw_option("Q23","0;1;2;3;4;5","ss","single",$Q23,true,6); ?></td>
    </tr>
    <tr>
      <td class="title_s">Left wrist</td>
      <td><?php echo draw_option("Q19","0;1;2;3;4;5","ss","single",$Q19,true,6); ?></td>
      <td class="title_s">Right wrist</td>
      <td><?php echo draw_option("Q24","0;1;2;3;4;5","ss","single",$Q24,true,6); ?></td>
    </tr>
    <tr>
      <td class="title_s">Left elbow</td>
      <td><?php echo draw_option("Q20","0;1;2;3;4;5","ss","single",$Q20,true,6); ?></td>
      <td class="title_s">Right elbow</td>
      <td><?php echo draw_option("Q25","0;1;2;3;4;5","ss","single",$Q25,true,6); ?></td>
    </tr>
    <tr>
      <td class="title_s">Left ankle</td>
      <td><?php echo draw_option("Q21","0;1;2;3;4;5","ss","single",$Q21,true,6); ?></td>
      <td class="title_s">Right ankle</td>
      <td><?php echo draw_option("Q26","0;1;2;3;4;5","ss","single",$Q26,true,6); ?></td>
    </tr>
    <tr>
      <td class="title_s">Left knee</td>
      <td><?php echo draw_option("Q22","0;1;2;3;4;5","ss","single",$Q22,true,6); ?></td>
      <td class="title_s">Right knee</td>
      <td><?php echo draw_option("Q27","0;1;2;3;4;5","ss","single",$Q27,true,6); ?></td>
    </tr>
    <tr>
      <td class="title_s">Total score</td>
      <td>Left upper limb 
        <input type="text"  name="Qtotal1" id="Qtotal1" size="2" value="<?php echo $Qtotal1;?>" /> </br>
        Left lower limb 
        <input type="text" name="Qtotal2" id="Qtotal2" size="2" value="<?php echo $Qtotal2;?>" /></td>
        <td class="title_s">Total score</td>
        <td>Right upper limb 
          <input type="text" name="Qtotal3" id="Qtotal3" size="2" value="<?php echo $Qtotal3;?>" /> </br>
          Right lower limb 
          <input type="text" name="Qtotal4" id="Qtotal4" size="2" value="<?php echo $Qtotal4;?>" /></td>
        </tr>
        <tr>
          <td colspan="4" class="title_s">5-Good,4-Fair,3-Average,2-Poor,1-Very Poor,0-None</td>
        </tr>   
        <tr>
          <td colspan="3" class="title_s">Consciousness (appearance)</td>
          <td colspan="4" ><?php echo draw_option("Q28","Clear;Orderless;Somnolence;Stupor;Coma;Semi-coma","xm","multi",$Q28,false,2); ?></td>
        </tr>
        <tr>
          <td colspan="3" class="title_s">Walking aids</td>
          <td colspan="4" ><?php echo draw_option("Q29","Need not;wheelchair;Special wheelchair;Walker;Canes;crutch","xl","multi",$Q29,true,3); ?></td>
        </tr>
        <tr>
          <td colspan="7" class="title">(3) Ability to Communicate:</td>
        </tr> 
        <tr>
          <td colspan="3" class="title_s">Vision</td>
          <td colspan="4" ><?php echo draw_option("Q30","Normal(R);Blurred(R);Blind(R);Unassessable(R);Normal(L);Blurred(L);Blind(L);Unassessable(L)","l","multi",$Q30,true,4); ?></td>
        </tr>
        <tr>
          <td colspan="3" class="title_s">Hearing</td>
          <td colspan="4" ><?php echo draw_option("Q31","Normal(R);Impaired(R);Deaf(R);Unassessable(R);Normal(L);Impaired(L);Deaf(L);Unassessable(L)","l","multi",$Q31,true,4); ?></td>
        </tr>
        <tr>
          <td colspan="3" class="title_s">Speaking skill</td>
          <td colspan="4" ><?php echo draw_option("Q32","Good;Can express simple sentences;Can speak piecemeal words;Unable to speak;Unable to determine;Unassessable","xxxl","multi",$Q32,true,2); ?></td>
        </tr>
        <tr>
          <td colspan="3" class="title_s">Comprehension</td>
          <td colspan="4" ><?php echo draw_option("Q33","Good;Understandable simple sentences;Understand piecemeal words;Unable to speak;Unable to determine;Unassessable","xxxl","multi",$Q33,true,2); ?></td>
        </tr>
        <tr>
          <td colspan="3" class="title_s">Preferred Language</td>
          <td colspan="4" ><?php echo draw_option("Q34","English;Spanish;Chinese;French;German;Others","m","multi",$Q34,true,4); ?> <input type="text" name="Q34a" id="Q34a" size="24" value="<?php echo $Q34a; ?>"</td>
        </tr>
        <tr>
          <td colspan="3" class="title_s">Preliminary assessment result</td>
          <td colspan="4" ><?php echo draw_checkbox("Q35","Admission NOT approved because: <input type=\"text\" name=\"Q35a\" id=\"Q35a\" size=\"40\" value=\"".$Q35a."\" />;Admission approved",$Q35,"single"); ?><?php echo draw_checkbox_nobr("Q36","Individually exercise;Bedside exercise;Group activities/exercise",$Q36,"single"); ?></td>
        </tr>
      </table>
      <table width="100%">
        <tr>
          <td>Filled date：<?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><?php }?><input type="text" name="date" id="date" value="<?php if ($date != NULL) { echo formatdate($date); } ?>" size="12"><?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?><input type="button" value="Today" onclick="inputdate('date');" /><?php }?></td>
          <td align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
        </tr>
      </table>

      <center>
        <div style="margin-top:50px">
          <input type="hidden" name="formID" id="formID" value="rehabilitationform03" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button><?php }?>
        </div>
      </center>
    </form><br><br>
    <?php
    $url = explode('/',$_SERVER['REQUEST_URI']);
    $file = substr($url[3],0,5);
    ?>
    <script>
    $(document).ready(function () {
     <?php if($file=="index"){echo 'calcQtotal';}?>
//	calcQtotal();
$("[id*='btn_Q']").click(function() {
  calcQtotal();
});
})
    function calcQtotal() {
     var Qtotal1 = 0;
     var Qtotal2 = 0;
     var Qtotal3 = 0;
     var Qtotal4 = 0;
     for(var i=0;i<7;i++){
      if ($('#Q18_'+i).val()==1) { Qtotal1 += (i-1); }
      if ($('#Q19_'+i).val()==1) { Qtotal1 += (i-1); }		
      if ($('#Q20_'+i).val()==1) { Qtotal1 += (i-1); }		
      if ($('#Q21_'+i).val()==1) { Qtotal2 += (i-1); }		
      if ($('#Q22_'+i).val()==1) { Qtotal2 += (i-1); }		
      if ($('#Q23_'+i).val()==1) { Qtotal3 += (i-1); }		
      if ($('#Q24_'+i).val()==1) { Qtotal3 += (i-1); }		
      if ($('#Q25_'+i).val()==1) { Qtotal3 += (i-1); }		
      if ($('#Q26_'+i).val()==1) { Qtotal4 += (i-1); }		
      if ($('#Q27_'+i).val()==1) { Qtotal4 += (i-1); }		
    }
    $('#Qtotal1').val(Qtotal1);
    $('#Qtotal2').val(Qtotal2);	
    $('#Qtotal3').val(Qtotal3);
    $('#Qtotal4').val(Qtotal4);	
  }
  </script>