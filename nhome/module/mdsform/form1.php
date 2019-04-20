<?php
if($_GET['date']!=NULL){
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

$Qfiller = explode("&",$Qfiller);
for($i=0;$i<count($Qfiller);$i++){
$sql = "SELECT `name` FROM `userinfo` WHERE `userID`='".$Qfiller[$i]."'";
$db2 = new DB2;
$db2->query($sql);
if ($db2->num_rows()>0) {
	$r2 = $db2->fetch_assoc();
	foreach ($r2 as $k=>$v) {
		if((count($Qfiller)-$i)>2){
			$page1_Qfiller_name .= $v.';';
		}elseif((count($Qfiller)-$i)==2){
			$page1_Qfiller_name .= $v;
		}else{}
	}
}
}
$page1_Qfiller_name = str_replace(';',', ', $page1_Qfiller_name);
?>

  <body class="page1-body">
	<table cellspacing="0" align="center" style="width:55.875em; margin-top:1em; margin-bottom:1em">
	  <tr>
	    <td style="border:hidden">Resident:</td>
	    <td class="sectiontop1"><b><?php echo $name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Identifier:</td>
	    <td class="sectiontop2"><b><?php echo $page1_Qfiller_name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Date:</td>                             
	    <td class="sectiontop3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><?php echo formatdate_Ymd_Slash($date); ?></b><hr color="black" align="left" width="100%" size="1"></td>
	  </tr>
	</table>
	<table cellspacing="5" align="center" style="color:#2B6B6E; text-align:center; width:55.875em; margin-bottom:0.5em">
	  <tr>
	    <td>MINIMUM DATA SET(MDS)-Version 3.0</td>
	  </tr>
	  <tr>
	    <td>RESIDENT ASSESSMENT AND CARE SCREENING</td>
	  </tr>
	  <tr>
	    <td>Nursing Home Comprehensive(NC)Item Set</td>
	  </tr>
	</table>
<!----------------------------------------------------->
    <table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="margin-bottom:0.4em">
      <tr>
		<td class="section" style="width:10.125em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Section A</b></div></td>
		<td class="section" style="width:45.54em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Identification Information</b></div></td>
	  <tr>
    </table>
<!----------------------------------------------------->
	<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="width:55.875em">
	  <tr>
	    <td class="page1-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>A0050. Type of Record</b></div></td>
	  </tr>
<!----------------------------------------------------->
	  <tr>
	    <td class="page1-content" style="width:5.875em">
		  <a style="font-family:serif">Enter Code</a>
		  <div style="padding-left:2.4em">
		  <table>
  		    <tr>
		      <td class="answer">
			    <?php echo $QA0050; ?>
			  </td>
		    </tr>
		  </table>
		  </div>
		</td>
		<td class="page1-partwhite" style="width:50em">
		  <ol class="page1-ol" style="padding-left:2.5em; margin-top:0.1875em; margin-bottom:0.1875em">
		    <li><b>Add new record &#8594; </b>Continue to A0100, Facility Provider Numbers
		    <li><b>Modify existing record &#8594; </b>Continue to A0100, Facility Provider Numbers
			<li><b>Inactivate existing record &#8594; </b>Skip to X0150, Type of Provider
		  </ol>
		</td>
	  </tr>
<!----------------------------------------------------->
	  <tr>
	    <td class="page1-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>A0100. Facility Provider Nembers</b></div></td>
	  </tr>
<!----------------------------------------------------->
	  <tr>
	    <td class="page1-content"></td>
		<td class="page1-partwhite">
		  <ul class="page1-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
		    <li style="margin-top:0.1875em; margin-bottom:0.1875em"><b>National Provider Identifier (NPI):</b><?php if (substr($url[3],0,5)!="print"){ if($A0100A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
			  <table cellspacing="0">
		        <td class="answer"><?php echo $QA0100A_1; ?></td>
			    <td class="answer"><?php echo $QA0100A_2; ?></td>
			    <td class="answer"><?php echo $QA0100A_3; ?></td>
			    <td class="answer"><?php echo $QA0100A_4; ?></td>
        		<td class="answer"><?php echo $QA0100A_5; ?></td>
			    <td class="answer"><?php echo $QA0100A_6; ?></td>
			    <td class="answer"><?php echo $QA0100A_7; ?></td>
			    <td class="answer"><?php echo $QA0100A_8; ?></td>
			    <td class="answer"><?php echo $QA0100A_9; ?></td>
			    <td class="answer"><?php echo $QA0100A_10; ?></td>
		      </table>
		    <li style="margin-top:0.1875em; margin-bottom:0.1875em"><b>CMS Certification Nember (CCN):</b><?php if (substr($url[3],0,5)!="print"){ if($A0100B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
			  <table cellspacing="0">
		        <td class="answer"><?php echo $QA0100B_1; ?></td>
			    <td class="answer"><?php echo $QA0100B_2; ?></td>
				<td class="answer"><?php echo $QA0100B_3; ?></td>
			    <td class="answer"><?php echo $QA0100B_4; ?></td>
			    <td class="answer"><?php echo $QA0100B_5; ?></td>
			    <td class="answer"><?php echo $QA0100B_6; ?></td>
			    <td class="answer"><?php echo $QA0100B_7; ?></td>
			    <td class="answer"><?php echo $QA0100B_8; ?></td>
			    <td class="answer"><?php echo $QA0100B_9; ?></td>
			    <td class="answer"><?php echo $QA0100B_10; ?></td>
			    <td class="answer"><?php echo $QA0100B_11; ?></td>
			    <td class="answer"><?php echo $QA0100B_12; ?></td>
		      </table>
		    <li style="margin-top:0.1875em; margin-bottom:0.1875em"><b>State Provider Number</b><?php if (substr($url[3],0,5)!="print"){ if($A0100C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
			  <table cellspacing="0">
		        <td class="answer"><?php echo $QA0100C_1; ?></td>
			    <td class="answer"><?php echo $QA0100C_2; ?></td>
				<td class="answer"><?php echo $QA0100C_3; ?></td>
			    <td class="answer"><?php echo $QA0100C_4; ?></td>
			    <td class="answer"><?php echo $QA0100C_5; ?></td>
			    <td class="answer"><?php echo $QA0100C_6; ?></td>
			    <td class="answer"><?php echo $QA0100C_7; ?></td>
			    <td class="answer"><?php echo $QA0100C_8; ?></td>
			    <td class="answer"><?php echo $QA0100C_9; ?></td>
			    <td class="answer"><?php echo $QA0100C_10; ?></td>
			    <td class="answer"><?php echo $QA0100C_11; ?></td>
			    <td class="answer"><?php echo $QA0100C_12; ?></td>
			    <td class="answer"><?php echo $QA0100C_13; ?></td>
			    <td class="answer"><?php echo $QA0100C_14; ?></td>
			    <td class="answer"><?php echo $QA0100C_15; ?></td>
		      </table>
		  </ul>
		</td>
	  </tr>
<!----------------------------------------------------->
	  <tr>
	    <td class="page1-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>A0200. Type of Provider</b></div></td>
	  </tr>
<!----------------------------------------------------->
	  <tr>
	    <td class="page1-content">
		  <a style="font-family:serif">Enter Code</a>
		  <div style="padding-left:2.4em">
		  <table>
  		    <tr>
		    <td class="answer"><?php echo $QA0200; ?></td>
		    </tr>
		  </table>
		  </div>
		</td>
		<td class="page1-partwhite">
		  <ol class="page1-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
		  <b>Type of provider</b>
		    <dd style="padding-left:2.8em">
		      <li><b>Nursing home(SNF/NF)</b>
		      <li><b>Swing Bed</b>
			</dd>
		  </ol>
		</td>
	  </tr>
<!----------------------------------------------------->
	  <tr>
	    <td class="page1-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>A0310. Type of Assessment.</b></div></td>
	  </tr>
<!----------------------------------------------------->
	  <tr>
	    <td class="page1-content" style="border-bottom-style:hidden">
		  <a style="font-family:serif">Enter Code</a>
		  <div style="padding-left:1.75em">
		  <table>
  		    <tr>
		    <?php
			  switch($QA0310A)
			  {
			    case "01":
				  $A0310Aa = "0";
				  $A0310Ab = "1";
				  break;
				case "02":
				  $A0310Aa = "0";
				  $A0310Ab = "2";
				  break;
				case "03":
				  $A0310Aa = "0";
				  $A0310Ab = "3";
				  break;
				case "04":
				  $A0310Aa = "0";
				  $A0310Ab = "4";
				  break;
				case "05":
				  $A0310Aa = "0";
				  $A0310Ab = "5";
				  break;
				case "06":
				  $A0310Aa = "0";
				  $A0310Ab = "6";
				  break;
				case "99":
				  $A0310Aa = "9";
				  $A0310Ab = "9";
			  }
			?>
		    <td class="answer"><?php echo $A0310Aa; ?></td>
			<td class="answer"><?php echo $A0310Ab; ?></td>
		    </tr>
		  </table>
		  </div>
		</td>
		<td class="page1-partwhite">
		  <ul class="page1-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
		    <li><b>Federal OBRA Reason for Assessment</b>
		  </ul>
		  <ol class="page1-ol-zero" style="margin-top:0.1875em; margin-bottom:0.1875em">
		    <dd style="padding-left:2em">
		      <li><b>Admission</b> assessment (required by day 14)
		      <li><b>Quarterly</b> review assessment
		      <li><b>Annual</b> assessment
		      <li><b>Significant change in status</b> assessment
		      <li><b>Significant correction</b> to <b>prior comprehensive</b> assessment
		      <li><b>Significant correction</b> to <b>prior quarterly</b> assessment
		      <li value="99"><b>Not OBRA required</b> assessment
		    </dd>
		  </ol>
		</td>
	  </tr>
<!----------------------------------------------------->
	  <tr>
	    <td class="page1-content" style="border-top-style:hidden; border-bottom-style:hidden">
		  <a style="font-family:serif">Enter Code</a>
		  <div style="padding-left:1.75em">
		  <table>
  		    <tr>
		    <?php
			  switch($QA0310B)
			  {
			    case "01":
				  $A0310Ba = "0";
				  $A0310Bb = "1";
				  break;
				case "02":
				  $A0310Ba = "0";
				  $A0310Bb = "2";
				  break;
				case "03":
				  $A0310Ba = "0";
				  $A0310Bb = "3";
				  break;
				case "04":
				  $A0310Ba = "0";
				  $A0310Bb = "4";
				  break;
				case "05":
				  $A0310Ba = "0";
				  $A0310Bb = "5";
				  break;
				case "07":
				  $A0310Ba = "0";
				  $A0310Bb = "7";
				  break;
				case "99":
				  $A0310Ba = "9";
				  $A0310Bb = "9";
			  }
			?>
		    <td class="answer"><?php echo $A0310Ba; ?></td>
			<td class="answer"><?php echo $A0310Bb; ?></td>
		    </tr>
		  </table>
		  </div>
		</td>
		<td class="page1-partwhite">
		  <ul class="page1-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
		    <li value="2"><b>PPS Assessment</b><br><b><u>PPS</u> <u>Scheduled</u> <u>Assessments</u> <u>for</u> <u>a</u> <u>Medicare</u> <u>Part</u> <u>A</u> <u>Stay</u></b>
		  </ul>
		  <ol class="page1-ol-zero" style="margin-top:0.1875em; margin-bottom:0.1875em">
		    <dd style="padding-left:2em">
		      <li><b>5-day</b> scheduled assessment
		      <li><b>14-day</b> scheduled assessment
		      <li><b>30-day</b> scheduled assessment
		      <li><b>60-day</b> scheduled assessment
		      <li><b>90-day</b> scheduled assessment
		    </dd>
              <b><u>PPS</u> <u>Unscheduled</u> <u>Assessments</u> <u>for</u> <u>a</u> <u>Medicare</u> <u>Part</u> <u>A</u> <u>Stay</u></b>
			<dd style="padding-left:2em">
		      <li value="7"><b>Unscheduled assessment used for PPS</b> (OMRA, significant or clinical change, or significant <br>correction assessment)
            </dd>
		      <b><u>Not</u> <u>PPS</u> <u>Assessment</u></b>
		    <dd style="padding-left:2em">
              <li value="99"><b>Not PPS</b> assessment
            </dd>		  
          </ol>		  
	    </td>
   	  </tr>
<!----------------------------------------------------->
	  <tr>
	    <td class="page1-content" style="border-top-style:hidden; border-bottom-style:hidden">
		  <a style="font-family:serif">Enter Code</a>
		  <div style="padding-left:2.4em">
		  <table>
  		    <tr>
		    <td class="answer"><?php echo $QA0310C; ?></td>
		    </tr>
		  </table>
		  </div>
		</td>
		<td class="page1-partwhite">
		  <ul class="page1-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
		    <li value="3"><b>PPS Other Medicare Required Assessment - OMRA</b>
		  </ul>
		  <ol class="page1-ol" start="0">
		    <dd style="padding-left:2.8em">
		      <li><b>No</b>
		      <li><b>Start of therapy</b> assessment
		      <li><b>End of therapy</b> assessment
		      <li><b>Both Start and End of therapy</b> assessment
			  <li><b>Change of therapy</b> assessment
		    </dd>
		  </ol>
		</td>
	  </tr>
<!----------------------------------------------------->
	  <tr>
	    <td class="page1-content" style="border-top-style:hidden">
		  <a style="font-family:serif">Enter Code</a>
		  <div style="padding-left:2.4em">
		  <table>
  		    <tr>
		    <td class="answer"><?php echo $QA0310D; ?></td>
		    </tr>
		  </table>
		  </div>
		</td>
		<td class="page1-partwhite">
		  <ul class="page1-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
		    <li value="4"><b>Is this a Swing Bed clinical change assessment?</b> Complete only if A0200 = 2
		  </ul>
		  <ol class="page1-ol" start="0">		    
		    <dd style="padding-left:2.8em">
		      <li><b>No</b>
		      <li><b>Yes</b>
		    </dd>
		  </ol>
		</td>
	  </tr>
<!----------------------------------------------------->
      <tr>
	    <td class="page1-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>A0310 continued on next page</b></div></td>
	  </tr>
<!----------------------------------------------------->
	</table>
	<p style="font-size:1em">MDS 3.0 Nursing Home Comprehensive (NC) Version 1.12.0 Effective 10/01/2014</p>
  </body>
<?php
  }else{
	$db = new DB;
	$db->query("SELECT * FROM `mdsform99` WHERE `HospNo`='".$HospNo."' ORDER BY `date` DESC");
	if($db->num_rows()>0){
		$r = $db->fetch_assoc();
		$r['date'] = str_replace('-','',$r['date']);
		?>
		<script>
        document.location.href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=<?php echo $_GET['id']; ?>&date=<?php echo $r['date'];?>";
        </script>
		<?php
	}else{
	  echo '
	  <div>
	    <table>
	      <tr>
	        <td>
		      Not have any record.
		    </td>
		  </tr>
		  <tr>
			<td>
		      Please click the button to preduce MDS.
		    </td>
	      </tr>
	    </table>
	  </div>
	  ';		
	}
  }
?>