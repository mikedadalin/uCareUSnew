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
	$sql = "SELECT * FROM `humanresource8_2` WHERE `EmpID`='".mysql_escape_string($EmpID)."' and `EmpGroup`='".mysql_escape_string($EmpGroup)."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql = "SELECT * FROM `humanresource8_2` WHERE `EmpID`='".mysql_escape_string($EmpID)."' and `EmpGroup`='".mysql_escape_string($EmpGroup)."' AND `date`='".mysql_escape_string($_GET['date'])."'";
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
<form  method="post" onSubmit="return checkForm();" action="index.php?func=databaseforh&action=save">
  <h3><?php echo $Name; ?> - Foreign staff appraisal</h3>
  <table width="100%" border="0" align="center">
    <tr>
      <td class="title">Item(s)</td>
      <td class="title">Contents</td>
      <td class="title">Score</td>
      <td class="title">Out of</td>
      <td class="title">Description</td>
    </tr>
    <tr>
      <td class="title_s">Punctuality</td>
      <td class="title_s" width="400">1.On time when on duty<br>2.Leave in advance(except emergency)</td>
      <td align="center" width="300"><?php echo draw_option("Q1","1;2;3;4;5;6;7;8;9;10","s","single",$Q1,true,5); ?></td>
      <td align="center" width="50">10</td>
      <td rowspan="2" width="150">-1 if late,disappear or leave without notify.</td>
    </tr>
    <tr>
      <td class="title_s">On duty</td>
      <td class="title_s" width="400">1.Noon<br>2.Afternoon<br>3.Night shift doze</td>
      <td align="center" width="300"><?php echo draw_option("Q2","1;2;3;4;5;6;7;8;9;10","s","single",$Q2,true,5); ?></td>
      <td align="center">10</td>
    </tr>
    <tr>
      <td class="title_s">Responsibility</td>
      <td class="title_s" width="400">1.Finish assigned job in time<br>2.Actively discover and report patient/resident abnormal problem(Careful)<br>3.Individual shift handover record is clear and complete<br>4.Fully understand the focus of patient care and area of responsibility</td>
      <td align="center" width="300"><?php echo draw_option("Q3","1;2;3;4;5;6;7;8;9;10;11;12;13;14;15","s","single",$Q3,true,5); ?></td>
      <td align="center">15</td>
      <td>1-3 are 3 points each, 4 is 6 points, totally 15 points<br></td>
    </tr>
    <tr>
      <td class="title_s">Attitude</td>
      <td class="title_s" width="400">1.Talk attitude<br>2.Patient<br>3.Care<br>4.Empathy<br>5.Active caring<br>6.Open mind to learn</td>
      <td align="center" width="300"><?php echo draw_option("Q4","1;2;3;4;5;6;7;8;9;10;11;12;13;14;15","s","single",$Q4,true,5); ?></td>
      <td align="center">15</td>
      <td>1-3 are 2 points each <br>4-6 are 3 points each</td>
    </tr>
    <tr>
      <td class="title_s">Work skill</td>
      <td class="title_s" width="400">1.Environment clean and patients'/residents' body cleansers<br>2.Performance of wearing on/off cloath. feeding, turning over, bed transposition, medication, suction, diaper changing, clysis, hair washing, bathing, nails maintain and bed sheet changing. </td>
      <td align="center" width="300"><?php echo draw_option("Q5","1;2;3;4;5;6;7;8;9;10;11;12;13;14;15;16;17;18;19;20","s","single",$Q5,true,5); ?></td>
      <td align="center">20</td>
      <td>Apply random, continuous observation and based on duty area.</td>
    </tr>
    <tr>
      <td class="title_s">Record</td>
      <td class="title_s" width="400">1.Daily reports<br>2.Nursing dialog is detailed and indeed.</td>
      <td align="center" width="300"><?php echo draw_option("Q6","1;2;3;4;5","s","single",$Q6,true,5); ?></td>
      <td align="center">5</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="title_s">Problem solving</td>
      <td class="title_s" width="400">1.Proactively identify and report problems<br>2.Problem solving skill</td>
      <td align="center" width="300"><?php echo draw_option("Q7","1;2;3;4;5","s","single",$Q7,true,5); ?></td>
      <td align="center">5</td>
      <td>This column apply additional plus</td>
    </tr>
    <tr>
      <td class="title_s">Preferred Language</td>
      <td class="title_s" width="400">Communication skills</td>
      <td align="center" width="300"><?php echo draw_option("Q8","1;2;3;4;5;6;7;8;9;10;11;12;13;14;15","s","single",$Q8,true,5); ?></td>
      <td align="center">15</td>
      <td>This column apply additional plus</td>
    </tr>
    <tr>
      <td class="title_s">Other</td>
      <td class="title_s" width="400">1.Clothing appearance<br>2.Honesty</td>
      <td align="center" width="300"><?php echo draw_option("Q9","1;2;3;4;5","s","single",$Q9,true,5); ?></td>
      <td align="center">5</td>
      <td>This column apply additional plus</td>
    </tr>
    <tr>
      <td colspan="2" class="title">Total score</td>
      <td colspan="3">
        <center>
          <h3>
            <span id="total"><?php if ($Qtotal==NULL) { echo "0"; } else { echo  $Qtotal; } ?></span>
            <input type="hidden" name="Qtotal" id="Qtotal" value="<?php if ($Qtotal==NULL) { echo "0"; } else { echo  $Qtotal; } ?>" />
          </h3></center></td>
        </tr>
      </table>


      <table width="100%" align="center">
        <tr>
          <td style="background:#ffffff;">Filled date：<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if ($date != NULL) { echo formatdate($date); } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" /></td>
          <td style="background:#ffffff;" align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
        </tr>
      </table>
      <center>
        <div style="margin:10px auto;">
          <input type="hidden" name="formID" id="formID" value="humanresource8_2" />
          <input type="hidden" name="EmpID" id="EmpID" value="<?php echo @$_GET['EmpID']; ?>" />
          <input type="hidden" name="EmpGroup" id="EmpGroup" value="<?php echo @$_GET['EmpGroup']; ?>" />
          <input type="submit" id="submit" name="submit" value="Save" />
        </div>
      </center>
    </form>
    <script>
    $(document).ready(function () {
     calcQtotal();
     $("[id*='btn_Q']").click(function() {
      calcQtotal();
    });
   })
    function calcQtotal() {
     var Qtotal = 0;
     var QNO = ["", "10", "10", "15", "15", "20", "5", "5", "15", "5"];
     
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