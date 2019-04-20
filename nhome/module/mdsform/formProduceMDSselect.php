<?php
$db1 = new DB;
$db1->query("SELECT `Q3_1`,`Q3_2` FROM `nurseform02g_2` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date` IN (SELECT MAX(`date`) FROM `nurseform02g_2` GROUP BY `no`) AND `ReportID` IN (SELECT MAX(`ReportID`) FROM `nurseform02g_2` GROUP BY `no`) ORDER BY `no` ASC");
$PU =0;
if($db1->num_rows()>0) {
  for ($i=0;$i<$db1->num_rows();$i++) {
	   $r1 = $db1->fetch_assoc();
	   foreach ($r1 as $k=>$v) {
	      if (substr($k,0,1)=="Q") {
	  		  $arrAnswer = explode("_",$k);
	  		  if (count($arrAnswer)==2) {
	  			  if ($v==1) { ${$arrAnswer[0]} .= $arrAnswer[1].';'; }
	  		  } else {
	  			  ${$k} = $v;
	  		  }
	  	  }  else { ${$k} = $v; }
	   }
	   if ($Q3=="2;"){$PU++;}
  }
  if($PU>0){
	  $PU="1";
  }else{
	  $PU="0";
  }
}else{
  $PU="0";
}
?>
	<style>
	  table.mds {font-family:sans-serif; line-height:30px}
	  th.mds {background-color:#009a93; color:white; font-size:20px; text-align:center; padding:7px 15px;}
	  th.mds2 {background-color:#69b3b6; font-size:20px; text-align:left; padding:7px 15px; color:#fff;}
	  td.mds {background-color:#cfe7e8; font-size:15px; text-align:left; padding:5px;}
	  td.function {background-color:#ddeeff; font-size:15px; text-align:center}
	  td.mdssection {background-color:#ddeeff; font-size:15px; padding-left:15px; padding-right:15px}
	  td.mdspage {background-color:#ddeeff; font-size:15px; text-align:center; padding-left:10px; padding-right:10px}
	  td.print {background-color:#ddeeff; font-size:15px; text-align:center; padding-left:10px; padding-right:10px}
	  td.add {background-color:#ddeeff; font-size:15px; width:70px; text-align:center}
	  td.alter {background-color:#ddeeff; font-size:15px; text-align:center; padding-left:10px; padding-right:10px}
	</style>
<br>
<div class="nurseform-table">
<?php
  /*============= A0050 =============*/
  if($_POST['A0050_1']=="" && $_POST['A0050_2']=="" && $_POST['A0050_3']=="" && $_POST['A0050']==""){
?>
<form  method="post" onSubmit="return checkForm();" action="">
<table class="mds" cellpadding="5">
  <tr>
    <th class="mds">
	  Type of Record
	</th>
  </tr>
  <tr>
    <td class="mds">
	  <?php echo draw_checkbox("A0050","Add new record;Modify existing record;Inactivate existing record","1","single"); ?>
	</td>
  </tr>
  <tr>
    <td class="mds" style="padding-top:12px; padding-bottom:12px;">
	  <input type="hidden" name="PU" id="PU" value="<?php echo $PU;?>" />
	  <center><input type="submit" id="submit" style="background-color:#009a93; color:white; font-size:18px; width:100px; height:30px; border:none;" value="Submit" /></center>
	</td>
  </tr>
<?php
  }
  /*============= A0200 =============*/
  if($_POST['A0050_1']=="1" || $_POST['A0050_2']=="1"){
     $PU = $_POST['PU'];
	 if($_POST['A0050_1']=="1"){
	    $A0050="1";
	 }elseif($_POST['A0050_2']=="1"){
	    $A0050="2";
	 }else{}
?>
<form  method="post" onSubmit="return checkForm();" action="">
<table class="mds">
  <tr>
    <th class="mds">
	  Type of Provider
	</th>
  </tr>
  <tr>
    <td class="mds">
	  <?php echo draw_checkbox("A0200","Nursing home(SNF/NF);Swing Bed","1","single"); ?>
	</td>
  </tr>
  <tr>
    <td class="mds" style="padding-top:12px; padding-bottom:12px;">
	  <input type="hidden" name="PU" id="PU" value="<?php echo $PU;?>" />
	  <input type="hidden" name="A0050" id="A0050" value="<?php echo $A0050;?>" />
	  <center>
	  <input type="submit" id="submit" style="background-color:#009a93; color:white; font-size:18px; width:100px; height:30px; border:none;" value="Submit" />
	  </center>
	</td>
  </tr>
<?php
  }
  /*============= Inactivate Date =============*/
  if($_POST['A0050_3']=="1"){
	  $PU = $_POST['PU'];
	  $A0050="3";
?>
<form  method="post" onSubmit="return checkForm();" action="">
<table class="mds">
  <tr>
    <th class="mds">
	  Previous Assessment Reference Date for Inactivate
	</th>
  </tr>
  <tr>
    <td class="mds">
	    <br>
	    &nbsp;&nbsp;&nbsp;&nbsp;<b>Select dates:</b>&nbsp;
	    <select name="InactivateDate" id="InactivateDate">
	        <option>Select dates</option>
	        <?php
			$db = new DB;
	        $db->query("SELECT * FROM `mdsform99` WHERE `HospNo`='".$HospNo."' ORDER BY `date` DESC");
	        for ($i=0;$i<$db->num_rows();$i++) {
	   	    $r = $db->fetch_assoc();
			$rdate = str_replace('-','',$r['date']);
			  if($rdate==$_GET['date']){
				  echo '<option value="'.formatdate_Ymd($r['date']).'" selected="selected">'.formatdate_Ymd_Slash($r['date']).'</option>';
			  }else{
				  echo '<option value="'.formatdate_Ymd($r['date']).'">'.formatdate_Ymd_Slash($r['date']).'</option>';
			  }
	        }
			?>
	    </select>
		<br>&nbsp;
	</td>
  </tr>
  <tr>
    <td class="mds" style="padding-top:12px; padding-bottom:12px;">
	  <input type="hidden" name="PU" id="PU" value="<?php echo $PU;?>" />
	  <input type="hidden" name="A0050" id="A0050" value="<?php echo $A0050;?>" />
	  <center>
	  <input type="submit" id="submit" style="background-color:#009a93; color:white; font-size:18px; width:100px; height:30px; border:none;" value="Submit" />
	  </center>
	</td>
  </tr>
<?php  
  }
  /*============= X1050 =============*/
  if($_POST['InactivateDate']!=""){
	  $PU = $_POST['PU'];
	  $A0050="3";
	  $InactivateDate = $_POST['InactivateDate'];
?>
<form  method="post" onSubmit="return checkForm();" action="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'];?>&id=ProduceMDS">
<table class="mds">
  <tr>
    <th class="mds">
	  Reasons for Inactivation
	</th>
  </tr>
  <tr>
    <th class="mds2">
	  Check all that apply
	</th>
  </tr>
  <tr>
    <td class="mds">
	  <?php echo draw_checkbox("X1050","<b>Event did not occur</b>;<b>Other error requiring inactivation</b>","","multi"); ?><br>
      If "Other" checked, please specify:<input type="text" name="X1050Ztext" id="X1050Ztext" value="" />
	</td>
  </tr>
  <tr>
    <td class="mds" style="padding-top:12px; padding-bottom:12px;">
	  <input type="hidden" name="PU" id="PU" value="<?php echo $PU;?>" />
	  <input type="hidden" name="A0050" id="A0050" value="<?php echo $A0050;?>" />
	  <input type="hidden" name="InactivateDate" id="InactivateDate" value="<?php echo $InactivateDate;?>" />
	  <center>
	  <input type="submit" id="submit" style="background-color:#009a93; color:white; font-size:18px; width:100px; height:30px; border:none;" value="Submit" />
	  </center>
	</td>
  </tr>
<?php  
  }
  /*============= A0310A =============*/
  if($_POST['A0200_1']=="1" || $_POST['A0200_2']=="1"){
    if($_POST['A0200_1']=="1"){
	    $A0200 ="1";
	}elseif($_POST['A0200_2']=="1"){
	    $A0200 ="2";
    }else{}
	$PU = $_POST['PU'];
	$A0050 = $_POST['A0050'];
?>
<form  method="post" onSubmit="return checkForm();" action="">
<table class="mds">
  <tr>
    <th class="mds">
	  Type of Assessment
	</th>
  </tr>
  <tr>
    <th class="mds2">
	  A. Federal OBRA Reason for Assessment
	</th>
  </tr>
  <tr>
    <td class="mds">
	  <?php echo draw_checkbox("A0310A","<b>Admission assessment</b> (required by day 14);<b>Quarterly</b> review assessment;<b>Annual</b> assessment;<b>Significant change in status</b> assessment;<b>Significant correction</b> to <b>prior comprehensive</b> assessment;<b>Significant correction</b> to <b>prior quarterly</b> assessment;<b>Not OBRA required</b> assessment","1","single"); ?>
	</td>
  </tr>
  <tr>
    <td class="mds" style="padding-top:12px; padding-bottom:12px;">
	  <input type="hidden" name="PU" id="PU" value="<?php echo $PU;?>" />
	  <input type="hidden" name="A0050" id="A0050" value="<?php echo $A0050;?>" />
	  <input type="hidden" name="A0200" id="A0200" value="<?php echo $A0200;?>" />
	  <center>
	  <input type="submit" id="submit" style="background-color:#009a93; color:white; font-size:18px; width:100px; height:30px; border:none;" value="Submit" />
	  </center>
	</td>
  </tr>
<?php
  }
  /*============= A0310B =============*/
  if($_POST['A0310A_1']=="1" || $_POST['A0310A_2']=="1" || $_POST['A0310A_3']=="1" || $_POST['A0310A_4']=="1" || $_POST['A0310A_5']=="1" || $_POST['A0310A_6']=="1" || $_POST['A0310A_7']=="1"){
	  if($_POST['A0310A_1']=="1"){
		  $A0310A="01";
	  }elseif($_POST['A0310A_2']=="1"){
		  $A0310A="02";
	  }elseif($_POST['A0310A_3']=="1"){
		  $A0310A="03";
	  }elseif($_POST['A0310A_4']=="1"){
		  $A0310A="04";
	  }elseif($_POST['A0310A_5']=="1"){
		  $A0310A="05";
	  }elseif($_POST['A0310A_6']=="1"){
		  $A0310A="06";
	  }elseif($_POST['A0310A_7']=="1"){
		  $A0310A="99";
	  }else{}
	  $PU = $_POST['PU'];
	  $A0050 = $_POST['A0050'];
	  $A0200 = $_POST['A0200'];
?>
<form  method="post" onSubmit="return checkForm();" action="">
<table class="mds">
  <tr>
    <th class="mds">
	  Type of Assessment
	</th>
  </tr>
  <tr>
    <th class="mds2">
	  B. PPS Assessment
	</th>
  </tr>
  <tr>
    <td class="mds">
	  <b>&nbsp;&nbsp;&nbsp;PPS Scheduled Assessments for a Medicare Part A Stay</b><br>
	  <?php echo draw_checkbox("A0310B1","<b>5-day</b> scheduled assessment;<b>14-day</b> scheduled assessment;<b>30-day</b> scheduled assessment;<b>60-day</b> scheduled assessment;<b>90-day</b> scheduled assessment","","single"); ?>
	  <b>&nbsp;&nbsp;&nbsp;PPS Unscheduled Assessments for a Medicare Part A Stay</b><br>
	  <?php echo draw_checkbox("A0310B2","<b>Unscheduled assessment used for PPS</b> (OMRA, significant or clinical change, or significant correction assessment)","","single"); ?>
	  <b>&nbsp;&nbsp;&nbsp;Not PPS Assessment</b><br>
	  <?php echo draw_checkbox("A0310B3","<b>Not PPS</b> assessment","","single"); ?>
	</td>
  </tr>
  <tr>
    <td class="mds" style="padding-top:12px; padding-bottom:12px;">
	  <input type="hidden" name="PU" id="PU" value="<?php echo $PU;?>" />
	  <input type="hidden" name="A0050" id="A0050" value="<?php echo $A0050;?>" />
	  <input type="hidden" name="A0200" id="A0200" value="<?php echo $A0200;?>" />
	  <input type="hidden" name="A0310A" id="A0310A" value="<?php echo $A0310A;?>" />
	  <center>
	  <input type="submit" id="submit" style="background-color:#009a93; color:white; font-size:18px; width:100px; height:30px; border:none;" value="Submit" />
	  </center>
	</td>
  </tr>
<?php	  
  }
  /*============= A0310C =============*/
  if($_POST['A0310B1_1']=="1" || $_POST['A0310B1_2']=="1" || $_POST['A0310B1_3']=="1" || $_POST['A0310B1_4']=="1" || $_POST['A0310B1_5']=="1" || $_POST['A0310B2_1']=="1" || $_POST['A0310B3_1']=="1"){
	  if($_POST['A0310B1_1']=="1"){
		  $A0310B="01";
	  }elseif($_POST['A0310B1_2']=="1"){
		  $A0310B="02";
	  }elseif($_POST['A0310B1_3']=="1"){
		  $A0310B="03";
	  }elseif($_POST['A0310B1_4']=="1"){
		  $A0310B="04";
	  }elseif($_POST['A0310B1_5']=="1"){
		  $A0310B="05";
	  }elseif($_POST['A0310B2_1']=="1"){
		  $A0310B="07";
	  }elseif($_POST['A0310B3_1']=="1"){
		  $A0310B="99";
	  }else{}
	  $PU = $_POST['PU'];
	  $A0050 = $_POST['A0050'];
	  $A0200 = $_POST['A0200'];
	  $A0310A = $_POST['A0310A'];
?>
<form  method="post" onSubmit="return checkForm();" action="">
<table class="mds">
  <tr>
    <th class="mds">
	  Type of Assessment
	</th>
  </tr>
  <tr>
    <th class="mds2">
	  C. PPS Other Medicare Required Assessment - OMRA
	</th>
  </tr>
  <tr>
    <td class="mds">
	  <?php echo draw_checkbox("A0310C","<b>No</b>;<b>Start of therapy</b> assessment;<b>End of therapy</b> assessment;<b>Both Start and End of therapy</b> assessment;<b>Change of therapy</b> assessment","","single"); ?>
	</td>
  </tr>
  <tr>
    <td class="mds" style="padding-top:12px; padding-bottom:12px;">
	  <input type="hidden" name="PU" id="PU" value="<?php echo $PU;?>" />
	  <input type="hidden" name="A0050" id="A0050" value="<?php echo $A0050;?>" />
	  <input type="hidden" name="A0200" id="A0200" value="<?php echo $A0200;?>" />
	  <input type="hidden" name="A0310A" id="A0310A" value="<?php echo $A0310A;?>" />
	  <input type="hidden" name="A0310B" id="A0310B" value="<?php echo $A0310B;?>" />
	  <center>
	  <input type="submit" id="submit" style="background-color:#009a93; color:white; font-size:18px; width:100px; height:30px; border:none;" value="Submit" />
	  </center>
	</td>
  </tr>
<?php
  }
  /*============= A0310D OR A0310F =============*/
  if($_POST['A0310C_1']=="1" || $_POST['A0310C_2']=="1" || $_POST['A0310C_3']=="1" || $_POST['A0310C_4']=="1" || $_POST['A0310C_5']=="1"){
	  if($_POST['A0310C_1']=="1"){
		  $A0310C="0";
	  }elseif($_POST['A0310C_2']=="1"){
		  $A0310C="1";
	  }elseif($_POST['A0310C_3']=="1"){
		  $A0310C="2";
	  }elseif($_POST['A0310C_4']=="1"){
		  $A0310C="3";
	  }elseif($_POST['A0310C_5']=="1"){
		  $A0310C="4";
	  }else{}
	  $PU = $_POST['PU'];
	  $A0050 = $_POST['A0050'];
	  $A0200 = $_POST['A0200'];
	  $A0310A = $_POST['A0310A'];
	  $A0310B = $_POST['A0310B'];
?>
<form  method="post" onSubmit="return checkForm();" action="">
<table class="mds">
  <tr>
    <th class="mds">
	  Type of Assessment
	</th>
  </tr>
<?php
      if($A0200=="2"){
?>
  <tr>
    <th class="mds2">
	  D. Is this a Swing Bed clinical change assessment?
	</th>
  </tr>
  <tr>
    <td class="mds">
	  <?php echo draw_checkbox("A0310D","<b>No</b>;<b>Yes</b>","","single"); ?>
	</td>
  </tr>
<?php
	  }else{
?>
  <tr>
    <th class="mds2">
	  F. Entry/discharge reporting
	</th>
  </tr>
  <tr>
    <td class="mds">
	  <?php echo draw_checkbox("A0310F","<b>Entry</b> record;<b>Discharge</b> assessment-<b>return not anticipated</b>;<b>Discharge</b> assessment-<b>return anticipated</b>;<b>Death in facility</b> record;<b>Not entry/discharge</b> record","","single"); ?>
	</td>
  </tr>
<?php
	  }
?>
  <tr>
    <td class="mds" style="padding-top:12px; padding-bottom:12px;">
	  <input type="hidden" name="PU" id="PU" value="<?php echo $PU;?>" />
	  <input type="hidden" name="A0050" id="A0050" value="<?php echo $A0050;?>" />
	  <input type="hidden" name="A0200" id="A0200" value="<?php echo $A0200;?>" />
	  <input type="hidden" name="A0310A" id="A0310A" value="<?php echo $A0310A;?>" />
	  <input type="hidden" name="A0310B" id="A0310B" value="<?php echo $A0310B;?>" />
	  <input type="hidden" name="A0310C" id="A0310C" value="<?php echo $A0310C;?>" />
	  <center>
	  <input type="submit" id="submit" style="background-color:#009a93; color:white; font-size:18px; width:100px; height:30px; border:none;" value="Submit" />
	  </center>
	</td>
  </tr>
<?php
  }
  /*============= A0310F =============*/
  if($_POST['A0310D_1']=="1" || $_POST['A0310D_2']=="1"){
	  if($_POST['A0310D_1']=="1"){
		  $A0310D="0";
	  }elseif($_POST['A0310D_2']=="1"){
		  $A0310D="1";
	  }else{}
	  $PU = $_POST['PU'];
	  $A0050 = $_POST['A0050'];
	  $A0200 = $_POST['A0200'];
	  $A0310A = $_POST['A0310A'];
	  $A0310B = $_POST['A0310B'];
	  $A0310C = $_POST['A0310C'];
?>
<form  method="post" onSubmit="return checkForm();" action="">
<table class="mds">
  <tr>
    <th class="mds">
	  Type of Assessment
	</th>
  </tr>
  <tr>
    <th class="mds2">
	  F. Entry/discharge reporting
	</th>
  </tr>
  <tr>
    <td class="mds">
	  <?php echo draw_checkbox("A0310F","<b>Entry</b> record;<b>Discharge</b> assessment-<b>return not anticipated</b>;<b>Discharge</b> assessment-<b>return anticipated</b>;<b>Death in facility</b> record;<b>Not entry/discharge</b> record","","single"); ?>
	</td>
  </tr>
  <tr>
    <td class="mds" style="padding-top:12px; padding-bottom:12px;">
	  <input type="hidden" name="PU" id="PU" value="<?php echo $PU;?>" />
	  <input type="hidden" name="A0050" id="A0050" value="<?php echo $A0050;?>" />
	  <input type="hidden" name="A0200" id="A0200" value="<?php echo $A0200;?>" />
	  <input type="hidden" name="A0310A" id="A0310A" value="<?php echo $A0310A;?>" />
	  <input type="hidden" name="A0310B" id="A0310B" value="<?php echo $A0310B;?>" />
	  <input type="hidden" name="A0310C" id="A0310C" value="<?php echo $A0310C;?>" />
	  <input type="hidden" name="A0310D" id="A0310D" value="<?php echo $A0310D;?>" />
	  <center>
	  <input type="submit" id="submit" style="background-color:#009a93; color:white; font-size:18px; width:100px; height:30px; border:none;" value="Submit" />
	  </center>
	</td>
  </tr>
<?php
  }
  /*============= A2200 OR M0700 OR Q0100A =============*/
  if($_POST['A0310F_1']=="1" || $_POST['A0310F_2']=="1" || $_POST['A0310F_3']=="1" || $_POST['A0310F_4']=="1" || $_POST['A0310F_5']=="1"){
	  if($_POST['A0310F_1']=="1"){
		  $A0310F="01";
	  }elseif($_POST['A0310F_2']=="1"){
		  $A0310F="10";
	  }elseif($_POST['A0310F_3']=="1"){
		  $A0310F="11";
	  }elseif($_POST['A0310F_4']=="1"){
		  $A0310F="12";
	  }elseif($_POST['A0310F_5']=="1"){
		  $A0310F="99";
	  }else{}
	  $PU = $_POST['PU'];
	  $A0050 = $_POST['A0050'];
	  $A0200 = $_POST['A0200'];
	  $A0310A = $_POST['A0310A'];
	  $A0310B = $_POST['A0310B'];
	  $A0310C = $_POST['A0310C'];
	  $A0310D = $_POST['A0310D'];
?>
<form  method="post" onSubmit="return checkForm();" action="">
<table class="mds">
<?php
      if($A0310A=="05" || $A0310A=="06"){
?>
  <tr>
    <th class="mds">
	  Previous Assessment Reference Date for Significant Correction 
	</th>
  </tr>
  <tr>
    <td class="mds">
	    <br>
	    &nbsp;&nbsp;&nbsp;&nbsp;<b>Select dates:</b>&nbsp;
	    <select name="A2200a" id="A2200a">
	        <option>Select dates</option>
	        <?php
			$db = new DB;
	        $db->query("SELECT * FROM `mdsform99` WHERE `HospNo`='".$HospNo."' ORDER BY `date` DESC");
	        for ($i=0;$i<$db->num_rows();$i++) {
	   	    $r = $db->fetch_assoc();
			$rdate = str_replace('-','',$r['date']);
			  if($rdate==$_GET['date']){
				  echo '<option value="'.formatdate_Ymd($r['date']).'" selected="selected">'.formatdate_Ymd_Slash($r['date']).'</option>';
			  }else{
				  echo '<option value="'.formatdate_Ymd($r['date']).'">'.formatdate_Ymd_Slash($r['date']).'</option>';
			  }
	        }
			?>
	    </select>
		<br>&nbsp;
	</td>
  </tr>
<?php
	  }elseif($PU>0){
?>
  <tr>
    <th class="mds">
	  Most Severe Tissue Type for Any Pressure Ulcer
	</th>
  </tr>
  <tr>
    <th class="mds2">
	  Select the best description of the most severe type of tissue present in any pressure ulcer bed
	</th>
  </tr>
  <tr>
    <td class="mds">
	  <?php echo draw_checkbox("M0700","<b>Epithelial tissue</b>  - new skin growing in superficial ulcer. It can be light pink and shiny, even in persons with darkly pigmented skin;<b>Granulation tissue</b> - pink or red tissue with shiny, moist, granular appearance;<b>Slough</b> - yellow or white tissue that adheres to the ulcer bed in strings or thick clumps, or is mucinous;<b>Eschar</b> - black, brown, or tan tissue that adheres firmly to the wound bed or ulcer edges, may be softer or harder than surrounding skin;<b>None of the Above</b>","","single"); ?>
	</td>
  </tr>
<?php		  
	  }else{
?>
  <tr>
    <th class="mds">
	  Participation in Assessment
	</th>
  </tr>
  <tr>
    <th class="mds2">
	  A. Resident participated in assessment
	</th>
  </tr>
  <tr>
    <td class="mds">
	  <?php echo draw_checkbox("Q0100A","<b>No</b>;<b>Yes</b>","","single"); ?>
	</td>
  </tr>
<?php
	  }
?>
  <tr>
    <td class="mds" style="padding-top:12px; padding-bottom:12px;">
	  <input type="hidden" name="PU" id="PU" value="<?php echo $PU;?>" />
	  <input type="hidden" name="A0050" id="A0050" value="<?php echo $A0050;?>" />
	  <input type="hidden" name="A0200" id="A0200" value="<?php echo $A0200;?>" />
	  <input type="hidden" name="A0310A" id="A0310A" value="<?php echo $A0310A;?>" />
	  <input type="hidden" name="A0310B" id="A0310B" value="<?php echo $A0310B;?>" />
	  <input type="hidden" name="A0310C" id="A0310C" value="<?php echo $A0310C;?>" />
	  <input type="hidden" name="A0310D" id="A0310D" value="<?php echo $A0310D;?>" />
	  <input type="hidden" name="A0310F" id="A0310F" value="<?php echo $A0310F;?>" />
	  <center>
	  <input type="submit" id="submit" style="background-color:#009a93; color:white; font-size:18px; width:100px; height:30px; border:none;" value="Submit" />
	  </center>
	</td>
  </tr>
<?php
  }
  /*============= M0700 OR Q0100A =============*/
  if($_POST['A2200a']!=""){
	  $PU = $_POST['PU'];
	  $A0050 = $_POST['A0050'];
	  $A0200 = $_POST['A0200'];
	  $A0310A = $_POST['A0310A'];
	  $A0310B = $_POST['A0310B'];
	  $A0310C = $_POST['A0310C'];
	  $A0310D = $_POST['A0310D'];
	  $A0310F = $_POST['A0310F'];
	  $A2200 = $_POST['A2200a'];
?>
<form  method="post" onSubmit="return checkForm();" action="">
<table class="mds">
<?php
	  if($PU>0){
?>
  <tr>
    <th class="mds">
	  Most Severe Tissue Type for Any Pressure Ulcer
	</th>
  </tr>
  <tr>
    <th class="mds2">
	  Select the best description of the most severe type of tissue present in any pressure ulcer bed
	</th>
  </tr>
  <tr>
    <td class="mds">
	  <?php echo draw_checkbox("M0700","<b>Epithelial tissue</b>  - new skin growing in superficial ulcer. It can be light pink and shiny, even in persons with darkly pigmented skin;<b>Granulation tissue</b> - pink or red tissue with shiny, moist, granular appearance;<b>Slough</b> - yellow or white tissue that adheres to the ulcer bed in strings or thick clumps, or is mucinous;<b>Eschar</b> - black, brown, or tan tissue that adheres firmly to the wound bed or ulcer edges, may be softer or harder than surrounding skin;<b>None of the Above</b>","","single"); ?>
	</td>
  </tr>
<?php
	  }else{
?>
  <tr>
    <th class="mds">
	  Participation in Assessment
	</th>
  </tr>
  <tr>
    <th class="mds2">
	  A. Resident participated in assessment
	</th>
  </tr>
  <tr>
    <td class="mds">
	  <?php echo draw_checkbox("Q0100A","<b>No</b>;<b>Yes</b>","","single"); ?>
	</td>
  </tr>
<?php
	  }
?>
  <tr>
    <td class="mds" style="padding-top:12px; padding-bottom:12px;">
	  <input type="hidden" name="PU" id="PU" value="<?php echo $PU;?>" />
	  <input type="hidden" name="A0050" id="A0050" value="<?php echo $A0050;?>" />
	  <input type="hidden" name="A0200" id="A0200" value="<?php echo $A0200;?>" />
	  <input type="hidden" name="A0310A" id="A0310A" value="<?php echo $A0310A;?>" />
	  <input type="hidden" name="A0310B" id="A0310B" value="<?php echo $A0310B;?>" />
	  <input type="hidden" name="A0310C" id="A0310C" value="<?php echo $A0310C;?>" />
	  <input type="hidden" name="A0310D" id="A0310D" value="<?php echo $A0310D;?>" />
	  <input type="hidden" name="A0310F" id="A0310F" value="<?php echo $A0310F;?>" />
	  <input type="hidden" name="A2200" id="A2200" value="<?php echo $A2200;?>" />
	  <center>
	  <input type="submit" id="submit" style="background-color:#009a93; color:white; font-size:18px; width:100px; height:30px; border:none;" value="Submit" />
	  </center>
	</td>
  </tr>
<?php
  }
  /*============= Q0100A =============*/
  if($_POST['M0700_1']=="1" || $_POST['M0700_2']=="1" || $_POST['M0700_3']=="1" || $_POST['M0700_4']=="1" || $_POST['M0700_5']=="1"){
	  if($_POST['M0700_1']=="1"){
		  $M0700=1;
	  }elseif($_POST['M0700_2']=="1"){
		  $M0700=2;
	  }elseif($_POST['M0700_3']=="1"){
		  $M0700=3;
	  }elseif($_POST['M0700_4']=="1"){
		  $M0700=4;
	  }elseif($_POST['M0700_5']=="1"){
		  $M0700=9;
	  }else{}
	  $PU = $_POST['PU'];
	  $A0050 = $_POST['A0050'];
	  $A0200 = $_POST['A0200'];
	  $A0310A = $_POST['A0310A'];
	  $A0310B = $_POST['A0310B'];
	  $A0310C = $_POST['A0310C'];
	  $A0310D = $_POST['A0310D'];
	  $A0310F = $_POST['A0310F'];
	  $A2200 = $_POST['A2200'];
?>
<form  method="post" onSubmit="return checkForm();" action="">
<table class="mds">
  <tr>
    <th class="mds">
	  Participation in Assessment
	</th>
  </tr>
  <tr>
    <th class="mds2">
	  A. Resident participated in assessment
	</th>
  </tr>
  <tr>
    <td class="mds">
	  <?php echo draw_checkbox("Q0100A","<b>No</b>;<b>Yes</b>","","single"); ?>
	</td>
  </tr>
  <tr>
    <td class="mds" style="padding-top:12px; padding-bottom:12px;">
	  <input type="hidden" name="PU" id="PU" value="<?php echo $PU;?>" />
	  <input type="hidden" name="A0050" id="A0050" value="<?php echo $A0050;?>" />
	  <input type="hidden" name="A0200" id="A0200" value="<?php echo $A0200;?>" />
	  <input type="hidden" name="A0310A" id="A0310A" value="<?php echo $A0310A;?>" />
	  <input type="hidden" name="A0310B" id="A0310B" value="<?php echo $A0310B;?>" />
	  <input type="hidden" name="A0310C" id="A0310C" value="<?php echo $A0310C;?>" />
	  <input type="hidden" name="A0310D" id="A0310D" value="<?php echo $A0310D;?>" />
	  <input type="hidden" name="A0310F" id="A0310F" value="<?php echo $A0310F;?>" />
	  <input type="hidden" name="A2200" id="A2200" value="<?php echo $A2200;?>" />
	  <input type="hidden" name="M0700" id="M0700" value="<?php echo $M0700;?>" />
	  <center>
	  <input type="submit" id="submit" style="background-color:#009a93; color:white; font-size:18px; width:100px; height:30px; border:none;" value="Submit" />
	  </center>
	</td>
  </tr>
<?php
  }
  /*============= Q0100B =============*/
  if($_POST['Q0100A_1']=="1" || $_POST['Q0100A_2']=="1"){
	  if($_POST['Q0100A_1']=="1"){
		  $Q0100A="0";
	  }elseif($_POST['Q0100A_2']=="1"){
		  $Q0100A="1";
	  }else{}
	  $PU = $_POST['PU'];
	  $A0050 = $_POST['A0050'];
	  $A0200 = $_POST['A0200'];
	  $A0310A = $_POST['A0310A'];
	  $A0310B = $_POST['A0310B'];
	  $A0310C = $_POST['A0310C'];
	  $A0310D = $_POST['A0310D'];
	  $A0310F = $_POST['A0310F'];
	  $A2200 = $_POST['A2200'];
	  $M0700 = $_POST['M0700'];
?>
<form  method="post" onSubmit="return checkForm();" action="">
<table class="mds">
  <tr>
    <th class="mds">
	  Participation in Assessment
	</th>
  </tr>
  <tr>
    <th class="mds2">
	  B. Family or significant other participated in assessment
	</th>
  </tr>
  <tr>
    <td class="mds">
	  <?php echo draw_checkbox("Q0100B","<b>No</b>;<b>Yes</b>;<b>Resident has no family or significant other</b>","","single"); ?>
	</td>
  </tr>
  <tr>
    <td class="mds" style="padding-top:12px; padding-bottom:12px;">
	  <input type="hidden" name="PU" id="PU" value="<?php echo $PU;?>" />
	  <input type="hidden" name="A0050" id="A0050" value="<?php echo $A0050;?>" />
	  <input type="hidden" name="A0200" id="A0200" value="<?php echo $A0200;?>" />
	  <input type="hidden" name="A0310A" id="A0310A" value="<?php echo $A0310A;?>" />
	  <input type="hidden" name="A0310B" id="A0310B" value="<?php echo $A0310B;?>" />
	  <input type="hidden" name="A0310C" id="A0310C" value="<?php echo $A0310C;?>" />
	  <input type="hidden" name="A0310D" id="A0310D" value="<?php echo $A0310D;?>" />
	  <input type="hidden" name="A0310F" id="A0310F" value="<?php echo $A0310F;?>" />
	  <input type="hidden" name="A2200" id="A2200" value="<?php echo $A2200;?>" />
	  <input type="hidden" name="M0700" id="M0700" value="<?php echo $M0700;?>" />
	  <input type="hidden" name="Q0100A" id="Q0100A" value="<?php echo $Q0100A;?>" />
	  <center>
	  <input type="submit" id="submit" style="background-color:#009a93; color:white; font-size:18px; width:100px; height:30px; border:none;" value="Submit" />
	  </center>
	</td>
  </tr>
<?php
  }
  /*============= Q0100C =============*/
  if($_POST['Q0100B_1']=="1" || $_POST['Q0100B_2']=="1" || $_POST['Q0100B_3']=="1"){
	  if($_POST['Q0100B_1']=="1"){
		  $Q0100B="0";
	  }elseif($_POST['Q0100B_2']=="1"){
		  $Q0100B="1";
	  }elseif($_POST['Q0100B_3']=="1"){
		  $Q0100B="9";
	  }else{}
	  $PU = $_POST['PU'];
	  $A0050 = $_POST['A0050'];
	  $A0200 = $_POST['A0200'];
	  $A0310A = $_POST['A0310A'];
	  $A0310B = $_POST['A0310B'];
	  $A0310C = $_POST['A0310C'];
	  $A0310D = $_POST['A0310D'];
	  $A0310F = $_POST['A0310F'];
	  $A2200 = $_POST['A2200'];
	  $M0700 = $_POST['M0700'];
	  $Q0100A = $_POST['Q0100A'];
?>
<form  method="post" onSubmit="return checkForm();" action="">
<table class="mds">
  <tr>
    <th class="mds">
	  Participation in Assessment
	</th>
  </tr>
  <tr>
    <th class="mds2">
	  C. Guardian or legally authorized representative participated in assessment
	</th>
  </tr>
  <tr>
    <td class="mds">
	  <?php echo draw_checkbox("Q0100C","<b>No</b>;<b>Yes</b>;<b>Resident has no guardian or legally authorized representative</b>","","single"); ?>
	</td>
  </tr>
  <tr>
    <td class="mds" style="padding-top:12px; padding-bottom:12px;">
	  <input type="hidden" name="PU" id="PU" value="<?php echo $PU;?>" />
	  <input type="hidden" name="A0050" id="A0050" value="<?php echo $A0050;?>" />
	  <input type="hidden" name="A0200" id="A0200" value="<?php echo $A0200;?>" />
	  <input type="hidden" name="A0310A" id="A0310A" value="<?php echo $A0310A;?>" />
	  <input type="hidden" name="A0310B" id="A0310B" value="<?php echo $A0310B;?>" />
	  <input type="hidden" name="A0310C" id="A0310C" value="<?php echo $A0310C;?>" />
	  <input type="hidden" name="A0310D" id="A0310D" value="<?php echo $A0310D;?>" />
	  <input type="hidden" name="A0310F" id="A0310F" value="<?php echo $A0310F;?>" />
	  <input type="hidden" name="A2200" id="A2200" value="<?php echo $A2200;?>" />
	  <input type="hidden" name="M0700" id="M0700" value="<?php echo $M0700;?>" />
	  <input type="hidden" name="Q0100A" id="Q0100A" value="<?php echo $Q0100A;?>" />
	  <input type="hidden" name="Q0100B" id="Q0100B" value="<?php echo $Q0100B;?>" />
	  <center>
	  <input type="submit" id="submit" style="background-color:#009a93; color:white; font-size:18px; width:100px; height:30px; border:none;" value="Submit" />
	  </center>
	</td>
  </tr>
<?php
  }
  /*============= X0900 OR START =============*/
  if($_POST['Q0100C_1']=="1" || $_POST['Q0100C_2']=="1" || $_POST['Q0100C_3']=="1"){
	  if($_POST['Q0100C_1']=="1"){
		  $Q0100C="0";
	  }elseif($_POST['Q0100C_2']=="1"){
		  $Q0100C="1";
	  }elseif($_POST['Q0100C_3']=="1"){
		  $Q0100C="9";
	  }else{}
	  $PU = $_POST['PU'];
	  $A0050 = $_POST['A0050'];
	  $A0200 = $_POST['A0200'];
	  $A0310A = $_POST['A0310A'];
	  $A0310B = $_POST['A0310B'];
	  $A0310C = $_POST['A0310C'];
	  $A0310D = $_POST['A0310D'];
	  $A0310F = $_POST['A0310F'];
	  $A2200 = $_POST['A2200'];
	  $M0700 = $_POST['M0700'];
	  $Q0100A = $_POST['Q0100A'];
	  $Q0100B = $_POST['Q0100B'];
?>
<form  method="post" onSubmit="return checkForm();" action="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'];?>&id=ProduceMDS">
<table class="mds">
<?php
	  if($A0050=="2"){
?>
  <tr>
    <th class="mds">
	  Reasons for Modification
	</th>
  </tr>
  <tr>
    <th class="mds2">
	  Check all that apply
	</th>
  </tr>
  <tr>
    <td class="mds">
	  <?php echo draw_checkbox("X0900","<b>Transcription error</b>;<b>Data entry error</b>;<b>Software product error</b>;<b>Item coding error</b>;<b>End of Therapy - Resumption (EOT-R) date</b>;<b>Other error requiring modification</b>","","multi"); ?><br>
      If "Other" checked, please specify:<input type="text" name="X0900Ztext" id="X0900Ztext" value="" />
	</td>
  </tr>
<?php
	  }
?>
  <tr>
    <td class="mds" style="padding-top:12px; padding-bottom:12px;">
	  <input type="hidden" name="PU" id="PU" value="<?php echo $PU;?>" />
	  <input type="hidden" name="A0050" id="A0050" value="<?php echo $A0050;?>" />
	  <input type="hidden" name="A0200" id="A0200" value="<?php echo $A0200;?>" />
	  <input type="hidden" name="A0310A" id="A0310A" value="<?php echo $A0310A;?>" />
	  <input type="hidden" name="A0310B" id="A0310B" value="<?php echo $A0310B;?>" />
	  <input type="hidden" name="A0310C" id="A0310C" value="<?php echo $A0310C;?>" />
	  <input type="hidden" name="A0310D" id="A0310D" value="<?php echo $A0310D;?>" />
	  <input type="hidden" name="A0310F" id="A0310F" value="<?php echo $A0310F;?>" />
	  <input type="hidden" name="A2200" id="A2200" value="<?php echo $A2200;?>" />
	  <input type="hidden" name="M0700" id="M0700" value="<?php echo $M0700;?>" />
	  <input type="hidden" name="Q0100A" id="Q0100A" value="<?php echo $Q0100A;?>" />
	  <input type="hidden" name="Q0100B" id="Q0100B" value="<?php echo $Q0100B;?>" />
	  <input type="hidden" name="Q0100C" id="Q0100C" value="<?php echo $Q0100C;?>" />
	  <?php
	  if($A0050=="2"){
	  ?>
	  <center>
	  <input type="submit" id="submit" style="background-color:#009a93; color:white; font-size:18px; width:100px; height:30px; border:none;" value="Submit" />
	  </center>
	  <?php
	  }else{
	  ?>
	  <center>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type="submit" id="submit" style="background-color:#009a93; color:white; font-size:30px; width:120px; height:50px; border:none;" value="Start" />
	  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</center>
	  <?php
	  }
	  ?>
	</td>
  </tr>
<?php
  }
?>
</table>
</form><br>
</div>