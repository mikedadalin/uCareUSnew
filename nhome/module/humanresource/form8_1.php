<?php
$EmpID = (int) @$_GET['EmpID'];
$EmpGroup = @$_GET['EmpGroup'];

if($EmpGroup ==1){
	$db5a = new DB;
	$db5a->query("SELECT * FROM `employer` WHERE `EmpID`='".$EmpID."';");
	$r5a = $db5a->fetch_assoc();
	$Name = $r5a['Name'];
}else{
	$db5b = new DB;
	$db5b->query("SELECT * FROM `foreignemployer` WHERE `foreignID`='".$EmpID."'");
	$r5b = $db5b->fetch_assoc();
	$Name = $r5b['cNickname'];
}

if (@$_GET['date']=='') {
	$sql = "SELECT * FROM `humanresource8_1` WHERE `EmpID`='".mysql_escape_string($EmpID)."' and `EmpGroup`='".mysql_escape_string($EmpGroup)."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql = "SELECT * FROM `humanresource8_1` WHERE `EmpID`='".mysql_escape_string($EmpID)."' and `EmpGroup`='".mysql_escape_string($EmpGroup)."' AND `date`='".mysql_escape_string($_GET['date'])."'";
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
<div class="moduleNoTab">
<form  method="post" onSubmit="return checkForm();" action="index.php?func=databaseforh&action=save">
  <h3><?php echo $Name; ?> - Nursing skills assessment</h3>
  <table border="0" align="center">
    <tr>
      <td class="title">Assessment content</td>
      <td class="title">Score</td>
      <td class="title">Out of</td>
      <td class="title">Comment</td>
    </tr>
    <tr>
      <td class="title_s" width="400">Wash hands and backup item (therapeutic dish, gloves preparing,jelly 16Fr NG, gavage empty needle, stethoscope, boiled water 200c.c. and 3M tape)</td>
      <td align="center" width="300"><?php echo draw_option("Q1","1;2;3;4;5;6;7;8;9;10","s","single",$Q1,true,5); ?></td>
      <td align="center">10</td>
      <td><textarea name="Q1a" cols="10" rows="3" id="Q1a"><?php echo $Q1a; ?></textarea></td>
    </tr>
    <tr>
      <td class="title_s" width="400">Explain the purpose and process of the care to residents</td>
      <td align="center" width="300"><?php echo draw_option("Q2","1;2;3;4;5;6;7;8;9;10","s","single",$Q2,true,5); ?></td>
      <td align="center">10</td>
      <td><textarea name="Q2a" cols="10" rows="3" id="Q2a"><?php echo $Q2a; ?></textarea></td>
    </tr>
    <tr>
      <td class="title_s" width="400">Maintaing residents sitting and lying posture, perform restrain if needed.</td>
      <td align="center" width="300"><?php echo draw_option("Q3","1;2;3;4;5;6;7;8;9;10","s","single",$Q3,true,5); ?></td>
      <td align="center">10</td>
      <td><textarea name="Q3a" cols="10" rows="3" id="Q3a"><?php echo $Q3a; ?></textarea></td>
    </tr>
    <tr>
      <td class="title_s" width="400">Measure nasogastric tube insertion length with gloves on, and make 2 marks as following:<br />Mark 1: Measure the length from eyebrows to the xiphoid (about 50-60 cm to the stomach) <br />Mark 2: Measure distance between nostril and earlobe (about 20cm to the throat)</td>
      <td align="center" width="300"><?php echo draw_option("Q4","1;2;3;4;5;6;7;8;9;10;11;12;13;14;15","s","single",$Q4,true,5); ?></td>
      <td align="center">15</td>
      <td><textarea name="Q4a" cols="10" rows="3" id="Q4a"><?php echo $Q4a; ?></textarea></td>
    </tr>
    <tr>
      <td class="title_s" width="400">Coat the jelly on the front end of the NG tube</td>
      <td align="center" width="300"><?php echo draw_option("Q5","1;2;3;4;5","s","single",$Q5,true,5); ?></td>
      <td align="center">5</td>
      <td><textarea name="Q5a" cols="10" rows="3" id="Q5a"><?php echo $Q5a; ?></textarea></td>
    </tr>
    <tr>
      <td class="title_s" width="400">When inserting NG tube approaching mark 2, observe if coughing occur or put NG tube into water to measure whether buble occur. Re-plug the NG tube if needed</td>
      <td align="center" width="300"><?php echo draw_option("Q6","1;2;3;4;5;6;7;8;9;10","s","single",$Q6,true,5); ?></td>
      <td align="center">10</td>
      <td><textarea name="Q6a" cols="10" rows="3" id="Q6a"><?php echo $Q6a; ?></textarea></td>
    </tr>
    <tr>
      <td class="title_s" width="400">If the location is correct, ask resident to swallow while continue insert the NG tube to mark 1.</td>
      <td align="center" width="300"><?php echo draw_option("Q7","1;2;3;4;5;6;7;8;9;10","s","single",$Q7,true,5); ?></td>
      <td align="center">10</td>
      <td><textarea name="Q7a" cols="10" rows="3" id="Q7a"><?php echo $Q7a; ?></textarea></td>
    </tr>
    <tr>
      <td class="title_s" width="400">Temporarily affixed  3M tape to the nose</td>
      <td align="center" width="300"><?php echo draw_option("Q8","1;2;3;4;5","s","single",$Q8,true,5); ?></td>
      <td align="center">5</td>
      <td><textarea name="Q8a" cols="10" rows="3" id="Q8a"><?php echo $Q8a; ?></textarea></td>
    </tr>
    <tr>
      <td class="title_s" width="400">Apply 30cc air into the gravage neddle, and confirm the location in stomach through stethoscope,  perform extraction 30cc.</td>
      <td align="center" width="300"><?php echo draw_option("Q9","1;2;3;4;5;6;7;8;9;10","s","single",$Q9,true,5); ?></td>
      <td align="center">10</td>
      <td><textarea name="Q9a" cols="10" rows="3" id="Q9a"><?php echo $Q9a; ?></textarea></td>
    </tr>
    <tr>
      <td class="title_s" width="400">Pour 50c.c boiled water to extrude the air, re-tape the 3M tape.</td>
      <td align="center" width="300"><?php echo draw_option("Q10","1;2;3;4;5;6;7;8;9;10","s","single",$Q10,true,5); ?></td>
      <td align="center">10</td>
      <td><textarea name="Q10a" cols="10" rows="3" id="Q10a"><?php echo $Q10a; ?></textarea></td>
    </tr>
    <tr>
      <td class="title_s" width="400">Clean up items, wash hands and fill the shift turnover record</td>
      <td align="center" width="300"><?php echo draw_option("Q11","1;2;3;4;5","s","single",$Q11,true,5); ?></td>
      <td align="center">5</td>
      <td><textarea name="Q11a" cols="10" rows="3" id="Q11a"><?php echo $Q11a; ?></textarea></td>
    </tr>
    
    <tr>
      <td colspan="2" class="title">Total score</td>
      <td colspan="2">
        <center>
          <h3>
            <span id="total"><?php if ($Qtotal==NULL) { echo "0"; } else { echo  $Qtotal; } ?></span>
            <input type="hidden" name="Qtotal" id="Qtotal" value="<?php if ($Qtotal==NULL) { echo "0"; } else { echo  $Qtotal; } ?>" />
          </h3></center></td>
        </tr>
      </table>


      <table width="100%" align="center">
        <tr>
          <td>Filled date：<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if ($date != NULL) { echo formatdate($date); } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" /></td>
          <td align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
        </tr>
      </table>
      <center>
        <div style="margin:10px auto;">
          <input type="hidden" name="formID" id="formID" value="humanresource8_1" />
          <input type="hidden" name="EmpID" id="EmpID" value="<?php echo @$_GET['EmpID']; ?>" />
          <input type="hidden" name="EmpGroup" id="EmpGroup" value="<?php echo @$_GET['EmpGroup']; ?>" />
          <input type="submit" id="submit" name="submit" value="Save" />
        </div>
      </center>
    </form>
  </div>
    <script>
    $(document).ready(function () {
     calcQtotal();
     $("[id*='btn_Q']").click(function() {
      calcQtotal();
    });
   })
    function calcQtotal() {
     var Qtotal = 0;
     var QNO = ["", "10", "10", "10", "15", "5", "10", "10", "5", "10", "10", "5"];
     
     for (i=1;i<=QNO.length;i++) {
      console.log(i);
      for (j=1;j<=QNO[i];j++) {
       if ($('#Q'+i+'_'+j).val()==1) { Qtotal += j; }
     }
   }
   $('#Qtotal').val(Qtotal);
   $('#total').html(Qtotal);
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