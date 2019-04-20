<div style="background-color: rgba(255,255,255,0.8); border-radius: 10px; padding:10px 0px; margin-bottom: 30px;">

<div align="left" style="width:95%; padding:10px;" ondblclick="$('#modal1').fadeOut(); $('#modal2').fadeOut(); $('#modal3').fadeOut(); $('#modal4').fadeOut(); $('#modal5').fadeOut(); $('#modal6').fadeOut();">
<div style="width:100%; padding-top:10px; padding-bottom:10px;">
<div style="display:inline-block; width:100%;" onclick="$('#modal1').fadeOut(); $('#modal2').fadeOut(); $('#modal3').fadeOut(); $('#modal4').fadeOut(); $('#modal5').fadeOut(); $('#modal6').fadeOut();">

<h3 align="center" style="margin-top:0px;">Calendar</h3>
<input type="button" onclick="javascript:location.href='index.php?func=Calendar&type=ALL'" value="ALL" style="background:red; color:white; font-size:15.35px; display:inline-block; padding:10px; border-radius:10px; border:1px; outline: none;">
<input type="button" onclick="javascript:location.href='index.php?func=Calendar&type=1'" value="System" style="background:#65aea3; color:white; font-size:15.35px; display:inline-block; padding:10px; border-radius:10px; border:1px; outline: none;">
<input type="button" onclick="javascript:location.href='index.php?func=Calendar&type=2'" value="Announcement" style="background:#38a351; color:white; font-size:15.35px; display:inline-block; padding:10px; border-radius:10px; border:1px; outline: none;">
<input type="button" onclick="$('#CalendarCliniccol').show('slide', {direction: 'left'}, 500); $('#CalendarRemindercol').hide('slide', {direction: 'left'}, 500); $('#CalendarMedcol').hide('slide', {direction: 'left'}, 500); $('#CalendarInsulincol').hide('slide', {direction: 'left'}, 500); $('#CalendarPipelinecol').hide('slide', {direction: 'left'}, 500); $('#modal1').fadeOut(); $('#modal2').fadeOut(); $('#modal3').fadeOut(); $('#modal4').fadeOut(); $('#modal5').fadeOut(); $('#modal6').fadeOut(); $('#modal7').fadeOut();" value="Clinic revisit" style="background:#db9b24; color:white; font-size:15.35px; display:inline-block; padding:10px; border-radius:10px; border:1px; outline: none;">
<input type="button" onclick="$('#CalendarRemindercol').show('slide', {direction: 'left'}, 500); $('#CalendarCliniccol').hide('slide', {direction: 'left'}, 500); $('#CalendarMedcol').hide('slide', {direction: 'left'}, 500); $('#CalendarInsulincol').hide('slide', {direction: 'left'}, 500); $('#CalendarPipelinecol').hide('slide', {direction: 'left'}, 500); $('#modal1').fadeOut(); $('#modal2').fadeOut(); $('#modal3').fadeOut(); $('#modal4').fadeOut(); $('#modal5').fadeOut(); $('#modal6').fadeOut(); $('#modal7').fadeOut();" value="Reminders" style="background:#3a87ad; color:white; font-size:15.35px; display:inline-block; padding:10px; border-radius:10px; border:1px; outline: none;">
<input type="button" onclick="$('#CalendarMedcol').show('slide', {direction: 'left'}, 500); $('#CalendarCliniccol').hide('slide', {direction: 'left'}, 500); $('#CalendarRemindercol').hide('slide', {direction: 'left'}, 500); $('#CalendarInsulincol').hide('slide', {direction: 'left'}, 500); $('#CalendarPipelinecol').hide('slide', {direction: 'left'}, 500); $('#modal1').fadeOut(); $('#modal2').fadeOut(); $('#modal3').fadeOut(); $('#modal4').fadeOut(); $('#modal5').fadeOut(); $('#modal6').fadeOut(); $('#modal7').fadeOut();" value="Medication" style="background:#969810; color:white; font-size:15.35px; display:inline-block; padding:10px; border-radius:10px; border:1px; outline: none;">
<input type="button" onclick="$('#CalendarInsulincol').show('slide', {direction: 'left'}, 500); $('#CalendarCliniccol').hide('slide', {direction: 'left'}, 500); $('#CalendarRemindercol').hide('slide', {direction: 'left'}, 500); $('#CalendarMedcol').hide('slide', {direction: 'left'}, 500); $('#CalendarPipelinecol').hide('slide', {direction: 'left'}, 500); $('#modal1').fadeOut(); $('#modal2').fadeOut(); $('#modal3').fadeOut(); $('#modal4').fadeOut(); $('#modal5').fadeOut(); $('#modal6').fadeOut(); $('#modal7').fadeOut();" value="Insulin" style="background:#DF62A9; color:white; font-size:15.35px; display:inline-block; padding:10px; border-radius:10px; border:1px; outline: none;">
<input type="button" onclick="$('#CalendarPipelinecol').show('slide', {direction: 'left'}, 500); $('#CalendarCliniccol').hide('slide', {direction: 'left'}, 500); $('#CalendarRemindercol').hide('slide', {direction: 'left'}, 500); $('#CalendarMedcol').hide('slide', {direction: 'left'}, 500); $('#CalendarInsulincol').hide('slide', {direction: 'left'}, 500); $('#modal1').fadeOut(); $('#modal2').fadeOut(); $('#modal3').fadeOut(); $('#modal4').fadeOut(); $('#modal5').fadeOut(); $('#modal6').fadeOut(); $('#modal7').fadeOut();" value="Pipeline" style="background:#c64d0c; color:white; font-size:15.35px; display:inline-block; padding:10px; border-radius:10px; border:1px; outline: none;">


<div id="CalendarCliniccol" style="background:rgba(219, 155, 36,0.9); filter: alpha(opacity=90); display:none; z-index:99; width:20%; border:0px solid rgb(149,219,208); padding:10px; border-radius:10px;" align="left">
<div align="center"><font style="color:white; font-size:26px; font-weight:bold;">Clinic revisit</font></div>
<?php include("Calendar_Cliniccol.php"); ?>
</div>
<div id="CalendarRemindercol" style="background:rgba(57,134,172,0.9); filter: alpha(opacity=90); display:none; z-index:99; width:20%; border:0px solid rgb(149,219,208); padding:10px; border-radius:10px;" align="left">
<div align="center"><font style="color:white; font-size:26px; font-weight:bold;">Reminders</font></div>
<?php include("Calendar_Remindercol.php"); ?>
</div>
<div id="CalendarMedcol" style="background:rgba(150, 152, 16,0.9); filter: alpha(opacity=90); display:none; z-index:99; width:20%; border:0px solid rgb(149,219,208); padding:10px; border-radius:10px;" align="left">
<div align="center"><font style="color:white; font-size:26px; font-weight:bold;">Medication</font></div>
<?php include("Calendar_Medcol.php"); ?>
</div>
<div id="CalendarInsulincol" style="background:rgba(223,98,169,0.9); filter: alpha(opacity=90); display:none; z-index:99; width:20%; border:0px solid rgb(149,219,208); padding:10px; border-radius:10px;" align="left">
<div align="center"><font style="color:white; font-size:26px; font-weight:bold;">Insulin</font></div>
<?php include("Calendar_Insulincol.php"); ?>
</div>

<div id="CalendarPipelinecol" style="background:rgba(198, 77, 12,0.9); filter: alpha(opacity=90); display:none; z-index:99; width:20%; border:0px solid rgb(149,219,208); padding:10px; border-radius:10px;" align="left">
<div align="center"><font style="color:white; font-size:26px; font-weight:bold;">Pipeline</font></div>
<?php include("Calendar_Pipelinecol.php"); ?>
</div>

</div>
</div>
<div id="calendar" style="color:black;" onclick="closecol();"></div>
</div><br><br>
<?php
if($_GET['type']==1 || $_GET['type']=="" ||  $_GET['type']=="ALL"){
	$db_noticeUCare = new DB2;
	$db_noticeUCare->query("SELECT `date`, `content` FROM `notice` WHERE (`orgID` LIKE '%".$_SESSION['nOrgID_lwj']."%' OR `orgID`='ALL') ORDER BY `date` DESC LIMIT 0,20");
	for ($i=0;$i<$db_noticeUCare->num_rows();$i++) {
		$rNoticeUCare = $db_noticeUCare->fetch_assoc();
		if ($noticetxt4d!=NULL) { $noticetxt4d .= ','."\n"; }
		$noticetxt4d .= '{ title: \'---------- System ----------\n'.str_replace("'","\'",str_replace("<br>",'\n',$rNoticeUCare['content'])).'\', start:\''.substr($rNoticeUCare['date'],0,10).'\'}'; 
	}
}


if($_GET['type']==2 || $_GET['type']=="" ||  $_GET['type']=="ALL"){
	$db_notice = new DB;
	$db_notice->query("SELECT DATE_FORMAT(`datetime`, '%Y-%m-%d') AS `datetoshow`, `Q1`, `Qcontent`, `Qfiller` FROM `management07a` WHERE `available`='1'");
	$noticetxt4b = "";
	for ($i=0;$i<$db_notice->num_rows();$i++) {
		$rNotice = $db_notice->fetch_assoc();
		if ($noticetxt4b!=NULL) { $noticetxt4b .= ','."\n"; }
		$noticetxt4b .= '{ title: \'----- Announcement -----'.'\nSubject: '.str_replace("'","\'",str_replace("\n",'\n',$rNotice['Q1'])).'\nContent: '.str_replace("'","\'",str_replace("\n",'\n',$rNotice['Qcontent'])).'\nFilled by: '.checkusername($rNotice['Qfiller']).'\', start:\''.$rNotice['datetoshow'].'\'}';
	}
}


if($_GET['type']==3 || $_GET['type']=="ALL"){
	if($_GET['pid']!=""){
		$db_hosp = new DB;
		$db_hosp->query("SELECT * FROM `nurseform16` WHERE `HospNo`='".getHospNo($_GET['pid'])."' ORDER BY `Q1` ASC");
	}elseif($_GET['area']!=""){
		$rPID = explode(";",$arrAreaPID[$_GET['area']]);
		$db_hosp = new DB;
		$db_hosp->query("SELECT * FROM `nurseform16` ORDER BY `Q1` ASC");
	}else{
		$db_hosp = new DB;
		$db_hosp->query("SELECT * FROM `nurseform16` ORDER BY `Q1` ASC");
	}
	for ($i=0;$i<$db_hosp->num_rows();$i++) {
		$rHosp = $db_hosp->fetch_assoc();
		$pid = getPID($rHosp['HospNo']);
		$msg = '';
	
		for ($i1=1;$i1<=20;$i1++) {
			if ($rHosp['Q2_'.$i1]=="1") {
				$db_hospName = new DB2;
				$db_hospName->query("SELECT `Hosp".$i1."` FROM `system_setting` WHERE `OrgID`='".$_SESSION['nOrgID_lwj']."'");
				$rHospName = $db_hospName->fetch_assoc();
				$hospName = $rHospName['Hosp'.$i1];
				if($hospName==""){$hospName=$rHosp['Q2a'];}
			}
		}
	
		$msg .= '醫院：'.$hospName.'\n科別：'.$rHosp['Q2b'].'\n';
		$msg .= '醫師：'.$rHosp['Q2c'].'\n午別：'.($rHosp['Q6_1']==1?"AM":($rHosp['Q6_2']==1?"PM":($rHosp['Q6_3']==1?"Night":""))).'\n';
		$msg .= '就診號碼：'.$rHosp['Q2e'].'\n';
	
		if ($_SESSION['ncareOrgStatus_lwj']==2) {
			if($_GET['area']!=""){
				if (in_array($pid,$rPID)){
			        $db_instat = new DB;
			        $db_instat->query("SELECT `instat` FROM `patient` WHERE `patientID`='".$pid."'");
			        $r_instat = $db_instat->fetch_assoc();
			        if ($r_instat['instat']==1) {
				        if ($noticetxt4a!=NULL) { $noticetxt4a .= ','."\n"; }
				        $noticetxt4a .= '{ title: \'------- Clinic revisit -------\n'.'Bed #: '.getBedID($pid).'\nResident: '.getPatientName($pid).'\n'.str_replace("'","\'",$msg).'Filled by: '.checkusername($rHosp['Qfiller']).'\n------------------------------<br><a href="index.php?mod=nurseform&func=formview&pid='.$pid.'&id=13"><input type="button" value="Clinic revisit record" style="background-color:rgb(149,219,208); color:white; font-size:16px; font-weight:bolder; border-radius:5px; border:none; height:30px; margin-top:10px; cursor:pointer;"></a>'.'\', start:\''.str_replace("/","-",$rHosp['Q1']).'\'}';
			        }
			    }
			}else{
			    $db_instat = new DB;
			    $db_instat->query("SELECT `instat` FROM `patient` WHERE `patientID`='".$pid."'");
			    $r_instat = $db_instat->fetch_assoc();
			    if ($r_instat['instat']==1) {
				    if ($noticetxt4a!=NULL) { $noticetxt4a .= ','."\n"; }
				    $noticetxt4a .= '{ title: \'------- Clinic revisit -------\n'.'Bed #: '.getBedID($pid).'\nResident: '.getPatientName($pid).'\n'.str_replace("'","\'",$msg).'Filled by: '.checkusername($rHosp['Qfiller']).'\n------------------------------<br><a href="index.php?mod=nurseform&func=formview&pid='.$pid.'&id=13"><input type="button" value="Clinic revisit record" style="background-color:rgb(149,219,208); color:white; font-size:16px; font-weight:bolder; border-radius:5px; border:none; height:30px; margin-top:10px; cursor:pointer;"></a>'.'\', start:\''.str_replace("/","-",$rHosp['Q1']).'\'}';
			    }
			}
		} else {
			if($_GET['area']!=""){
				if (in_array($pid,$rPID)){
			        if ($noticetxt4a!=NULL) { $noticetxt4a .= ','."\n"; }
			        $noticetxt4a .= '{ title: \'------- Clinic revisit -------\n'.'Bed #: '.getBedID($pid).'\nResident: '.getPatientName($pid).'\n'.str_replace("'","\'",$msg).'Filled by: '.checkusername($rHosp['Qfiller']).'\n------------------------------<br><a href="index.php?mod=nurseform&func=formview&pid='.$pid.'&id=13"><input type="button" value="Clinic revisit record" style="background-color:rgb(149,219,208); color:white; font-size:16px; font-weight:bolder; border-radius:5px; border:none; height:30px; margin-top:10px; cursor:pointer;"></a>'.'\', start:\''.str_replace("/","-",$rHosp['Q1']).'\'}';
			    }
			}else{
			    if ($noticetxt4a!=NULL) { $noticetxt4a .= ','."\n"; }
			    $noticetxt4a .= '{ title: \'------- Clinic revisit -------\n'.'Bed #: '.getBedID($pid).'\nResident: '.getPatientName($pid).'\n'.str_replace("'","\'",$msg).'Filled by: '.checkusername($rHosp['Qfiller']).'\n------------------------------<br><a href="index.php?mod=nurseform&func=formview&pid='.$pid.'&id=13"><input type="button" value="Clinic revisit record" style="background-color:rgb(149,219,208); color:white; font-size:16px; font-weight:bolder; border-radius:5px; border:none; height:30px; margin-top:10px; cursor:pointer;"></a>'.'\', start:\''.str_replace("/","-",$rHosp['Q1']).'\'}';
			}
		}
	}
}


if($_GET['type']==4 || $_GET['type']=="ALL"){
	if($_GET['pid']!=""){
		$db_remind = new DB;
		$db_remind->query("SELECT DISTINCT `remindContent`, `HospNo`, `remindDate`, `Qfiller` FROM `reminder` WHERE `active`='1' AND `HospNo`='".getHospNo($_GET['pid'])."' ORDER BY `remindDate` ASC");
	}elseif($_GET['area']!=""){
		$rPID = explode(";",$arrAreaPID[$_GET['area']]);
		$db_remind = new DB;
		$db_remind->query("SELECT DISTINCT `remindContent`, `HospNo`, `remindDate`, `Qfiller` FROM `reminder` WHERE `active`='1' ORDER BY `remindDate` ASC");
	}else{
		$db_remind = new DB;
		$db_remind->query("SELECT DISTINCT `remindContent`, `HospNo`, `remindDate`, `Qfiller` FROM `reminder` WHERE `active`='1' ORDER BY `remindDate` ASC");
	}
	for ($i=0;$i<$db_remind->num_rows();$i++) {
		$reminder = $db_remind->fetch_assoc();
		$pid = getPID($reminder['HospNo']);
		if ($_SESSION['ncareOrgStatus_lwj']==2) {
			if($_GET['area']!=""){
				if (in_array($pid,$rPID)){
					$db_instat = new DB;
					$db_instat->query("SELECT `instat` FROM `patient` WHERE `patientID`='".$pid."'");
					$r_instat = $db_instat->fetch_assoc();
					if ($r_instat['instat']==1) {
						if ($noticetxt4!=NULL) { $noticetxt4 .= ','."\n"; }
						$noticetxt4 .= '{ title: \'-------- Reminder --------\n'.'Bed #: '.getBedID($pid).'\nResident: '.getPatientName($pid).'\nContent: '.$reminder['remindContent'].'\nFilled by: '.checkusername($reminder['Qfiller']).'\n------------------------------<br><a href="index.php?mod=nurseform&func=formview&pid='.$pid.'&id=4"><input type="button" value="Reminders" style="background-color:rgb(149,219,208); color:white; font-size:16px; font-weight:bolder; border-radius:5px; border:none; height:30px; margin-top:10px; cursor:pointer;"></a>'.'\', start:\''.str_replace("/","-",$reminder['remindDate']).'\'}';
					}
				}
			}else{
				$db_instat = new DB;
				$db_instat->query("SELECT `instat` FROM `patient` WHERE `patientID`='".$pid."'");
				$r_instat = $db_instat->fetch_assoc();
				if ($r_instat['instat']==1) {
					if ($noticetxt4!=NULL) { $noticetxt4 .= ','."\n"; }
					$noticetxt4 .= '{ title: \'-------- Reminder --------\n'.'Bed #: '.getBedID($pid).'\nResident: '.getPatientName($pid).'\nContent: '.$reminder['remindContent'].'\nFilled by: '.checkusername($reminder['Qfiller']).'\n------------------------------<br><a href="index.php?mod=nurseform&func=formview&pid='.$pid.'&id=4"><input type="button" value="Reminders" style="background-color:rgb(149,219,208); color:white; font-size:16px; font-weight:bolder; border-radius:5px; border:none; height:30px; margin-top:10px; cursor:pointer;"></a>'.'\', start:\''.str_replace("/","-",$reminder['remindDate']).'\'}';
				}
			}
		} else {
			if($_GET['area']!=""){
				if (in_array($pid,$rPID)){
					if ($noticetxt4!=NULL) { $noticetxt4 .= ','."\n"; }
					$noticetxt4 .= '{ title: \'-------- Reminder --------\n'.'Bed #: '.getBedID($pid).'\nResident: '.getPatientName($pid).'\nContent: '.$reminder['remindContent'].'\nFilled by: '.checkusername($reminder['Qfiller']).'\n------------------------------<br><a href="index.php?mod=nurseform&func=formview&pid='.$pid.'&id=4"><input type="button" value="Reminders" style="background-color:rgb(149,219,208); color:white; font-size:16px; font-weight:bolder; border-radius:5px; border:none; height:30px; margin-top:10px; cursor:pointer;"></a>'.'\', start:\''.str_replace("/","-",$reminder['remindDate']).'\'}';
				}
			}else{
				if ($noticetxt4!=NULL) { $noticetxt4 .= ','."\n"; }
				$noticetxt4 .= '{ title: \'-------- Reminder --------\n'.'Bed #: '.getBedID($pid).'\nResident: '.getPatientName($pid).'\nContent: '.$reminder['remindContent'].'\nFilled by: '.checkusername($reminder['Qfiller']).'\n------------------------------<br><a href="index.php?mod=nurseform&func=formview&pid='.$pid.'&id=4"><input type="button" value="Reminders" style="background-color:rgb(149,219,208); color:white; font-size:16px; font-weight:bolder; border-radius:5px; border:none; height:30px; margin-top:10px; cursor:pointer;"></a>'.'\', start:\''.str_replace("/","-",$reminder['remindDate']).'\'}';
			}
		}
	}
}


if($_GET['type']==5 || $_GET['type']=="ALL"){
	if($_GET['pid']!=""){
		$db_instatHospNo = new DB;
		$db_instatHospNo->query("SELECT `patientID`,`HospNo` FROM `patient` WHERE `instat`='1' AND `patientID`='".mysql_escape_string($_GET['pid'])."'");
	}elseif($_GET['area']!=""){
		$rPID = explode(";",$arrAreaPID[$_GET['area']]);
		$db_instatHospNo = new DB;
		$db_instatHospNo->query("SELECT `patientID`,`HospNo` FROM `patient` WHERE `instat`='1'");
	}else{
		$db_instatHospNo = new DB;
		$db_instatHospNo->query("SELECT `patientID`,`HospNo` FROM `patient` WHERE `instat`='1'");
	}
	for($z=0;$z<$db_instatHospNo->num_rows();$z++){
    	$r_instatHospNo = $db_instatHospNo->fetch_assoc();
    	$db_med = new DB;
    	$db_med->query("SELECT * FROM `nurseform17` WHERE `HospNo`='".$r_instatHospNo['HospNo']."'");
    	for ($i=0;$i<$db_med->num_rows();$i++) {
	    	$rMed = $db_med->fetch_assoc();
			if($i==0){
				$pid = $r_instatHospNo['patientID'];
				$name = getPatientName($pid);
				$bedID = getBedID($pid);
			}
			if($_GET['area']!=""){
				if (in_array($pid,$rPID)){
					$rQmedtime = explode(";",$rMed['Qmedtime']);
					for($j=0;$j<(count($rQmedtime)-1);$j++){
						if (strlen($rQmedtime[$j])==1) {
				    		$rQmedtime[$j] = '0'.$rQmedtime[$j].':00';
						}else{
		  					$rQmedtime[$j] = $rQmedtime[$j].':00';
						}
						$postDay = $rMed['Qmedday'];
						$postDayArray = explode(";",$postDay);
						for($k=0;$k<(count($postDayArray)-1);$k++){
							$startdate=strtotime($rMed['Qstartdate']);
							$enddate=strtotime($rMed['Qenddate']);
							if($postDayArray[$k]==0){ $dayName = "Monday";}
							if($postDayArray[$k]==1){ $dayName = "Tuesday";}
							if($postDayArray[$k]==2){ $dayName = "Wednesday";}
							if($postDayArray[$k]==3){ $dayName = "Thursday";}
							if($postDayArray[$k]==4){ $dayName = "Friday";}
							if($postDayArray[$k]==5){ $dayName = "Saturday";}
							if($postDayArray[$k]==6){ $dayName = "Sunday";}
							if($postDayArray[$k]==7){ $dayName = "Every Day";}
							if($postDayArray[$k]==8){ $dayName = "Every 2 Day";}
				
							if($dayName!="Every Day" && $dayName!="Every 2 Day"){
				    			$day=strtotime($dayName,$startdate);
			   					while($startdate <=  $enddate && $day <=  $enddate){
	  			      				$rMeddate = date("Y/m/d", $day);
  			        				$startdate = strtotime("+1 week", $startdate);
									$day=strtotime("+1 week", $day);
									if ($noticetxt4c!=NULL) { $noticetxt4c .= ','."\n"; }
									$noticetxt4c .= '{ title: \'------- Medication -------\n'.'Bed #: '.$bedID.'\nResident: '.$name.'\nTime: '.$rQmedtime[$j].'\nMedication: '.$rMed['Qmedicine'].'\nPathway: '.$rMed['Qway'].'\nFrequency: '.$rMed['Qfreq'].'\nDose: '.$rMed['Qdose'].' '.$rMed['Qdoseq'].'\nIntake amount: '.$rMed['Qusage'].'\nDoctor: '.$rMed['Qdoctor'].'\nFilled by: '.checkusername($rMed['Qfiller']).'\n------------------------------<br><a href="index.php?mod=nurseform&func=formview&pid='.$pid.'&id=17"><input type="button" value="Medication record" style="background-color:rgb(149,219,208); color:white; font-size:16px; font-weight:bolder; border-radius:5px; border:none; height:30px; margin-top:10px; cursor:pointer;"></a>'.'\', start:\''.str_replace("/","-",$rMeddate).'\'}';
			    				}
							}elseif($dayName=="Every Day"){
				   				while($startdate <=  $enddate){
  			      					$rMeddate = date("Y/m/d", $startdate);
  			        				$startdate = strtotime("+1 day", $startdate);
									if ($noticetxt4c!=NULL) { $noticetxt4c .= ','."\n"; }
									$noticetxt4c .= '{ title: \'------- Medication -------\n'.'Bed #: '.$bedID.'\nResident: '.$name.'\nTime: '.$rQmedtime[$j].'\nMedication: '.$rMed['Qmedicine'].'\nPathway: '.$rMed['Qway'].'\nFrequency: '.$rMed['Qfreq'].'\nDose: '.$rMed['Qdose'].' '.$rMed['Qdoseq'].'\nIntake amount: '.$rMed['Qusage'].'\nDoctor: '.$rMed['Qdoctor'].'\nFilled by: '.checkusername($rMed['Qfiller']).'\n------------------------------<br><a href="index.php?mod=nurseform&func=formview&pid='.$pid.'&id=17"><input type="button" value="Medication record" style="background-color:rgb(149,219,208); color:white; font-size:16px; font-weight:bolder; border-radius:5px; border:none; height:30px; margin-top:10px; cursor:pointer;"></a>'.'\', start:\''.str_replace("/","-",$rMeddate).'\'}';
			    				}
							}elseif($dayName=="Every 2 Day"){
				   				while($startdate <=  $enddate){
  				      				$rMeddate = date("Y/m/d", $startdate);
  				        			$startdate = strtotime("+2 day", $startdate);
									if ($noticetxt4c!=NULL) { $noticetxt4c .= ','."\n"; }
									$noticetxt4c .= '{ title: \'------- Medication -------\n'.'Bed #: '.$bedID.'\nResident: '.$name.'\nTime: '.$rQmedtime[$j].'\nMedication: '.$rMed['Qmedicine'].'\nPathway: '.$rMed['Qway'].'\nFrequency: '.$rMed['Qfreq'].'\nDose: '.$rMed['Qdose'].' '.$rMed['Qdoseq'].'\nIntake amount: '.$rMed['Qusage'].'\nDoctor: '.$rMed['Qdoctor'].'\nFilled by: '.checkusername($rMed['Qfiller']).'\n------------------------------<br><a href="index.php?mod=nurseform&func=formview&pid='.$pid.'&id=17"><input type="button" value="Medication record" style="background-color:rgb(149,219,208); color:white; font-size:16px; font-weight:bolder; border-radius:5px; border:none; height:30px; margin-top:10px; cursor:pointer;"></a>'.'\', start:\''.str_replace("/","-",$rMeddate).'\'}';
			    				}
							}
						}
					}
				}
			}else{
				$rQmedtime = explode(";",$rMed['Qmedtime']);
				for($j=0;$j<(count($rQmedtime)-1);$j++){
					if (strlen($rQmedtime[$j])==1) {
				    	$rQmedtime[$j] = '0'.$rQmedtime[$j].':00';
					}else{
		  				$rQmedtime[$j] = $rQmedtime[$j].':00';
					}
			
					$postDay = $rMed['Qmedday'];
					$postDayArray = explode(";",$postDay);
					for($k=0;$k<(count($postDayArray)-1);$k++){
						$startdate=strtotime($rMed['Qstartdate']);
						$enddate=strtotime($rMed['Qenddate']);
						if($postDayArray[$k]==0){ $dayName = "Monday";}
						if($postDayArray[$k]==1){ $dayName = "Tuesday";}
						if($postDayArray[$k]==2){ $dayName = "Wednesday";}
						if($postDayArray[$k]==3){ $dayName = "Thursday";}
						if($postDayArray[$k]==4){ $dayName = "Friday";}
						if($postDayArray[$k]==5){ $dayName = "Saturday";}
						if($postDayArray[$k]==6){ $dayName = "Sunday";}
						if($postDayArray[$k]==7){ $dayName = "Every Day";}
						if($postDayArray[$k]==8){ $dayName = "Every 2 Day";}
				
						if($dayName!="Every Day" && $dayName!="Every 2 Day"){
				    		$day=strtotime($dayName,$startdate);
			   				while($startdate <=  $enddate && $day <=  $enddate){
	  			      			$rMeddate = date("Y/m/d", $day);
  			        			$startdate = strtotime("+1 week", $startdate);
								$day=strtotime("+1 week", $day);
								if ($noticetxt4c!=NULL) { $noticetxt4c .= ','."\n"; }
								$noticetxt4c .= '{ title: \'------- Medication -------\n'.'Bed #: '.$bedID.'\nResident: '.$name.'\nTime: '.$rQmedtime[$j].'\nMedication: '.$rMed['Qmedicine'].'\nPathway: '.$rMed['Qway'].'\nFrequency: '.$rMed['Qfreq'].'\nDose: '.$rMed['Qdose'].' '.$rMed['Qdoseq'].'\nIntake amount: '.$rMed['Qusage'].'\nDoctor: '.$rMed['Qdoctor'].'\nFilled by: '.checkusername($rMed['Qfiller']).'\n------------------------------<br><a href="index.php?mod=nurseform&func=formview&pid='.$pid.'&id=17"><input type="button" value="Medication record" style="background-color:rgb(149,219,208); color:white; font-size:16px; font-weight:bolder; border-radius:5px; border:none; height:30px; margin-top:10px; cursor:pointer;"></a>'.'\', start:\''.str_replace("/","-",$rMeddate).'\'}';
			    			}
						}elseif($dayName=="Every Day"){
				   			while($startdate <=  $enddate){
  			      				$rMeddate = date("Y/m/d", $startdate);
  			        			$startdate = strtotime("+1 day", $startdate);
								if ($noticetxt4c!=NULL) { $noticetxt4c .= ','."\n"; }
								$noticetxt4c .= '{ title: \'------- Medication -------\n'.'Bed #: '.$bedID.'\nResident: '.$name.'\nTime: '.$rQmedtime[$j].'\nMedication: '.$rMed['Qmedicine'].'\nPathway: '.$rMed['Qway'].'\nFrequency: '.$rMed['Qfreq'].'\nDose: '.$rMed['Qdose'].' '.$rMed['Qdoseq'].'\nIntake amount: '.$rMed['Qusage'].'\nDoctor: '.$rMed['Qdoctor'].'\nFilled by: '.checkusername($rMed['Qfiller']).'\n------------------------------<br><a href="index.php?mod=nurseform&func=formview&pid='.$pid.'&id=17"><input type="button" value="Medication record" style="background-color:rgb(149,219,208); color:white; font-size:16px; font-weight:bolder; border-radius:5px; border:none; height:30px; margin-top:10px; cursor:pointer;"></a>'.'\', start:\''.str_replace("/","-",$rMeddate).'\'}';
			    			}
						}elseif($dayName=="Every 2 Day"){
				   			while($startdate <=  $enddate){
  				      			$rMeddate = date("Y/m/d", $startdate);
  				        		$startdate = strtotime("+2 day", $startdate);
								if ($noticetxt4c!=NULL) { $noticetxt4c .= ','."\n"; }
								$noticetxt4c .= '{ title: \'------- Medication -------\n'.'Bed #: '.$bedID.'\nResident: '.$name.'\nTime: '.$rQmedtime[$j].'\nMedication: '.$rMed['Qmedicine'].'\nPathway: '.$rMed['Qway'].'\nFrequency: '.$rMed['Qfreq'].'\nDose: '.$rMed['Qdose'].' '.$rMed['Qdoseq'].'\nIntake amount: '.$rMed['Qusage'].'\nDoctor: '.$rMed['Qdoctor'].'\nFilled by: '.checkusername($rMed['Qfiller']).'\n------------------------------<br><a href="index.php?mod=nurseform&func=formview&pid='.$pid.'&id=17"><input type="button" value="Medication record" style="background-color:rgb(149,219,208); color:white; font-size:16px; font-weight:bolder; border-radius:5px; border:none; height:30px; margin-top:10px; cursor:pointer;"></a>'.'\', start:\''.str_replace("/","-",$rMeddate).'\'}';
			    			}
						}
					}
				}
			}
		}
	}
}


if($_GET['type']==6 || $_GET['type']=="ALL"){
	if($_GET['pid']!=""){
		$db_instatHospNo = new DB;
		$db_instatHospNo->query("SELECT `patientID`,`HospNo` FROM `patient` WHERE `instat`='1' AND `patientID`='".mysql_escape_string($_GET['pid'])."'");
	}elseif($_GET['area']!=""){
		$rPID = explode(";",$arrAreaPID[$_GET['area']]);
		$db_instatHospNo = new DB;
		$db_instatHospNo->query("SELECT `patientID`,`HospNo` FROM `patient` WHERE `instat`='1'");
	}else{
		$db_instatHospNo = new DB;
		$db_instatHospNo->query("SELECT `patientID`,`HospNo` FROM `patient` WHERE `instat`='1'");
	}
	for($z=0;$z<$db_instatHospNo->num_rows();$z++){
    	$r_instatHospNo = $db_instatHospNo->fetch_assoc();
    	$db_Insulin = new DB;
    	$db_Insulin->query("SELECT * FROM `nurseform18` WHERE `HospNo`='".$r_instatHospNo['HospNo']."'");
		for ($i=0;$i<$db_Insulin->num_rows();$i++) {
	    	$rInsulin = $db_Insulin->fetch_assoc();
			if($i==0){
				$pid = $r_instatHospNo['patientID'];
				$name = getPatientName($pid);
				$bedID = getBedID($pid);
			}
			if($_GET['area']!=""){
				if (in_array($pid,$rPID)){
					foreach ($rInsulin as $k=>$v) {
    					if (substr($k,0,1)=="Q") {
      			    		$arrAnswer = explode("_",$k);
      			    		if (count($arrAnswer)==2) {
        			    		if ($v==1) {
          			        		${'rInsulin_'.$arrAnswer[0]} .= $arrAnswer[1].';';
        			    		}
      			    		} else {
        			    		${'rInsulin_'.$k} = $v;
      			    		}
    					}  else {
      			    		${'rInsulin_'.$k} = $v;
    					}
  			  		}
					$rInsulin_Qmedtime = explode(";",$rInsulin_Qmedtime);
					for($j=0;$j<(count($rInsulin_Qmedtime)-1);$j++){
						if (strlen(($rInsulin_Qmedtime[$j]-1))==1) {
				    		$rInsulin_Qmedtime[$j] = '0'.($rInsulin_Qmedtime[$j]-1).':00';
						}else{
		  					$rInsulin_Qmedtime[$j] = ($rInsulin_Qmedtime[$j]-1).':00';
						}
			
						$postDay = $rInsulin_Qmedday;
						$postDayArray = explode(";",$postDay);
						for($k=0;$k<(count($postDayArray)-1);$k++){
							$startdate=strtotime($rInsulin['Qstartdate']);
							$enddate=strtotime($rInsulin['Qenddate']);
							if(($postDayArray[$k]-1)==0){ $dayName = "Monday";}
							if(($postDayArray[$k]-1)==1){ $dayName = "Tuesday";}
							if(($postDayArray[$k]-1)==2){ $dayName = "Wednesday";}
							if(($postDayArray[$k]-1)==3){ $dayName = "Thursday";}
							if(($postDayArray[$k]-1)==4){ $dayName = "Friday";}
							if(($postDayArray[$k]-1)==5){ $dayName = "Saturday";}
							if(($postDayArray[$k]-1)==6){ $dayName = "Sunday";}
							if(($postDayArray[$k]-1)==7){ $dayName = "Every Day";}
							if(($postDayArray[$k]-1)==8){ $dayName = "Every 2 Day";}
				
							if($dayName!="Every Day" && $dayName!="Every 2 Day"){
				    			$day=strtotime($dayName,$startdate);
			   					while($startdate <=  $enddate && $day <=  $enddate){
	  			      				$rInsulindate = date("Y/m/d", $day);
  			        				$startdate = strtotime("+1 week", $startdate);
									$day=strtotime("+1 week", $day);
									if ($noticetxt4e!=NULL) { $noticetxt4e .= ','."\n"; }
									$noticetxt4e .= '{ title: \'---------- Insulin ----------\n'.'Bed #: '.$bedID.'\nResident: '.$name.'\nTime: '.$rInsulin_Qmedtime[$j].'\nMedication: '.$rInsulin['Qmedicine'].'\nDose: '.$rInsulin['Qdose'].' '.$rInsulin['Qdoseq'].'\nDoctor: '.$rInsulin['Qdoctor'].'\nFilled by: '.checkusername($rInsulin['Qfiller']).'\n------------------------------<br><a href="index.php?mod=nurseform&func=formview&pid='.$pid.'&id=18"><input type="button" value="Insulin injection record" style="background-color:rgb(149,219,208); color:white; font-size:16px; font-weight:bolder; border-radius:5px; border:none; height:30px; margin-top:10px; cursor:pointer;"></a>'.'\', start:\''.str_replace("/","-",$rInsulindate).'\'}';
			    				}
							}elseif($dayName=="Every Day"){
				   				while($startdate <=  $enddate){
  			      					$rInsulindate = date("Y/m/d", $startdate);
  			        				$startdate = strtotime("+1 day", $startdate);
									if ($noticetxt4e!=NULL) { $noticetxt4e .= ','."\n"; }
									$noticetxt4e .= '{ title: \'---------- Insulin ----------\n'.'Bed #: '.$bedID.'\nResident: '.$name.'\nTime: '.$rInsulin_Qmedtime[$j].'\nMedication: '.$rInsulin['Qmedicine'].'\nDose: '.$rInsulin['Qdose'].' '.$rInsulin['Qdoseq'].'\nDoctor: '.$rInsulin['Qdoctor'].'\nFilled by: '.checkusername($rInsulin['Qfiller']).'\n------------------------------<br><a href="index.php?mod=nurseform&func=formview&pid='.$pid.'&id=18"><input type="button" value="Insulin injection record" style="background-color:rgb(149,219,208); color:white; font-size:16px; font-weight:bolder; border-radius:5px; border:none; height:30px; margin-top:10px; cursor:pointer;"></a>'.'\', start:\''.str_replace("/","-",$rInsulindate).'\'}';
			    				}
							}elseif($dayName=="Every 2 Day"){
				   				while($startdate <=  $enddate){
  				      				$rInsulindate = date("Y/m/d", $startdate);
  				        			$startdate = strtotime("+2 day", $startdate);
									if ($noticetxt4e!=NULL) { $noticetxt4e .= ','."\n"; }
									$noticetxt4e .= '{ title: \'---------- Insulin ----------\n'.'Bed #: '.$bedID.'\nResident: '.$name.'\nTime: '.$rInsulin_Qmedtime[$j].'\nMedication: '.$rInsulin['Qmedicine'].'\nDose: '.$rInsulin['Qdose'].' '.$rInsulin['Qdoseq'].'\nDoctor: '.$rInsulin['Qdoctor'].'\nFilled by: '.checkusername($rInsulin['Qfiller']).'\n------------------------------<br><a href="index.php?mod=nurseform&func=formview&pid='.$pid.'&id=18"><input type="button" value="Insulin injection record" style="background-color:rgb(149,219,208); color:white; font-size:16px; font-weight:bolder; border-radius:5px; border:none; height:30px; margin-top:10px; cursor:pointer;"></a>'.'\', start:\''.str_replace("/","-",$rInsulindate).'\'}';
			    				}
							}
						}
					}
				}
			}else{
				foreach ($rInsulin as $k=>$v) {
    			    if (substr($k,0,1)=="Q") {
      			        $arrAnswer = explode("_",$k);
      			        if (count($arrAnswer)==2) {
        			        if ($v==1) {
          			            ${'rInsulin_'.$arrAnswer[0]} .= $arrAnswer[1].';';
        			        }
      			        } else {
        			        ${'rInsulin_'.$k} = $v;
      			        }
    			    }  else {
      			        ${'rInsulin_'.$k} = $v;
    			    }
  			      }
			    $rInsulin_Qmedtime = explode(";",$rInsulin_Qmedtime);
			    for($j=0;$j<(count($rInsulin_Qmedtime)-1);$j++){
				    if (strlen(($rInsulin_Qmedtime[$j]-1))==1) {
				        $rInsulin_Qmedtime[$j] = '0'.($rInsulin_Qmedtime[$j]-1).':00';
				    }else{
		  			    $rInsulin_Qmedtime[$j] = ($rInsulin_Qmedtime[$j]-1).':00';
				    }
			
				    $postDay = $rInsulin_Qmedday;
				    $postDayArray = explode(";",$postDay);
				    for($k=0;$k<(count($postDayArray)-1);$k++){
					    $startdate=strtotime($rInsulin['Qstartdate']);
					    $enddate=strtotime($rInsulin['Qenddate']);
					    if(($postDayArray[$k]-1)==0){ $dayName = "Monday";}
					    if(($postDayArray[$k]-1)==1){ $dayName = "Tuesday";}
					    if(($postDayArray[$k]-1)==2){ $dayName = "Wednesday";}
					    if(($postDayArray[$k]-1)==3){ $dayName = "Thursday";}
					    if(($postDayArray[$k]-1)==4){ $dayName = "Friday";}
					    if(($postDayArray[$k]-1)==5){ $dayName = "Saturday";}
					    if(($postDayArray[$k]-1)==6){ $dayName = "Sunday";}
					    if(($postDayArray[$k]-1)==7){ $dayName = "Every Day";}
					    if(($postDayArray[$k]-1)==8){ $dayName = "Every 2 Day";}
				
					    if($dayName!="Every Day" && $dayName!="Every 2 Day"){
				    	    $day=strtotime($dayName,$startdate);
			   			    while($startdate <=  $enddate && $day <=  $enddate){
	  			      		    $rInsulindate = date("Y/m/d", $day);
  			        		    $startdate = strtotime("+1 week", $startdate);
							    $day=strtotime("+1 week", $day);
							    if ($noticetxt4e!=NULL) { $noticetxt4e .= ','."\n"; }
							    $noticetxt4e .= '{ title: \'---------- Insulin ----------\n'.'Bed #: '.$bedID.'\nResident: '.$name.'\nTime: '.$rInsulin_Qmedtime[$j].'\nMedication: '.$rInsulin['Qmedicine'].'\nDose: '.$rInsulin['Qdose'].' '.$rInsulin['Qdoseq'].'\nDoctor: '.$rInsulin['Qdoctor'].'\nFilled by: '.checkusername($rInsulin['Qfiller']).'\n------------------------------<br><a href="index.php?mod=nurseform&func=formview&pid='.$pid.'&id=18"><input type="button" value="Insulin injection record" style="background-color:rgb(149,219,208); color:white; font-size:16px; font-weight:bolder; border-radius:5px; border:none; height:30px; margin-top:10px; cursor:pointer;"></a>'.'\', start:\''.str_replace("/","-",$rInsulindate).'\'}';
			    		    }
					    }elseif($dayName=="Every Day"){
				   		    while($startdate <=  $enddate){
  			      			    $rInsulindate = date("Y/m/d", $startdate);
  			        		    $startdate = strtotime("+1 day", $startdate);
							    if ($noticetxt4e!=NULL) { $noticetxt4e .= ','."\n"; }
							    $noticetxt4e .= '{ title: \'---------- Insulin ----------\n'.'Bed #: '.$bedID.'\nResident: '.$name.'\nTime: '.$rInsulin_Qmedtime[$j].'\nMedication: '.$rInsulin['Qmedicine'].'\nDose: '.$rInsulin['Qdose'].' '.$rInsulin['Qdoseq'].'\nDoctor: '.$rInsulin['Qdoctor'].'\nFilled by: '.checkusername($rInsulin['Qfiller']).'\n------------------------------<br><a href="index.php?mod=nurseform&func=formview&pid='.$pid.'&id=18"><input type="button" value="Insulin injection record" style="background-color:rgb(149,219,208); color:white; font-size:16px; font-weight:bolder; border-radius:5px; border:none; height:30px; margin-top:10px; cursor:pointer;"></a>'.'\', start:\''.str_replace("/","-",$rInsulindate).'\'}';
			    		    }
					    }elseif($dayName=="Every 2 Day"){
				   		    while($startdate <=  $enddate){
  				      		    $rInsulindate = date("Y/m/d", $startdate);
  				        	    $startdate = strtotime("+2 day", $startdate);
							    if ($noticetxt4e!=NULL) { $noticetxt4e .= ','."\n"; }
							    $noticetxt4e .= '{ title: \'---------- Insulin ----------\n'.'Bed #: '.$bedID.'\nResident: '.$name.'\nTime: '.$rInsulin_Qmedtime[$j].'\nMedication: '.$rInsulin['Qmedicine'].'\nDose: '.$rInsulin['Qdose'].' '.$rInsulin['Qdoseq'].'\nDoctor: '.$rInsulin['Qdoctor'].'\nFilled by: '.checkusername($rInsulin['Qfiller']).'\n------------------------------<br><a href="index.php?mod=nurseform&func=formview&pid='.$pid.'&id=18"><input type="button" value="Insulin injection record" style="background-color:rgb(149,219,208); color:white; font-size:16px; font-weight:bolder; border-radius:5px; border:none; height:30px; margin-top:10px; cursor:pointer;"></a>'.'\', start:\''.str_replace("/","-",$rInsulindate).'\'}';
			    		    }
					    }
				    }
			    }
			}
		}
	}
}


if($_GET['type']==7 || $_GET['type']=="ALL"){
	if($_GET['pid']!=""){
		$db_Pipeline = new DB;
		$db_Pipeline->query("SELECT * FROM `nurseform02k` WHERE `Q5`=0 AND `HospNo`='".getHospNo($_GET['pid'])."' ORDER BY `date` DESC");
	}elseif($_GET['area']!=""){
		$rPID = explode(";",$arrAreaPID[$_GET['area']]);
		$db_Pipeline = new DB;
		$db_Pipeline->query("SELECT * FROM `nurseform02k` WHERE `Q5`=0 ORDER BY `date` DESC");
	}else{
		$db_Pipeline = new DB;
		$db_Pipeline->query("SELECT * FROM `nurseform02k` WHERE `Q5`=0 ORDER BY `date` DESC");
	}
	for ($i=0;$i<$db_Pipeline->num_rows();$i++) {
		$Pipeline = $db_Pipeline->fetch_assoc();
		$pid = getPID($Pipeline['HospNo']);
		$NextChangeDay = calcdayafterday($Pipeline['date'],$Pipeline['Q4']);
		if ($_SESSION['ncareOrgStatus_lwj']==2) {
			if($_GET['area']!=""){
				if (in_array($pid,$rPID)){
					$db_instat = new DB;
					$db_instat->query("SELECT `instat` FROM `patient` WHERE `patientID`='".$pid."'");
					$r_instat = $db_instat->fetch_assoc();
					if ($r_instat['instat']==1) {
						if ($noticetxt4f!=NULL) { $noticetxt4f .= ','."\n"; }
						$noticetxt4f .= '{ title: \'-------- Pipeline --------\n'.'Bed #: '.getBedID($pid).'\nResident: '.getPatientName($pid).'\nPipeline: '.$arrForm2k_Q1[$Pipeline['Q1']].'\nMaterial: '.$arrForm2k_Q2[$Pipeline['Q2']].'\nCaliber: '.$Pipeline['Q3'].' Fr.'.'\nSetup/replace date: '.formatdate($Pipeline['date']).'\nReplacement cycle(days): '.$Pipeline['Q4'].'\nNext expected replacement date: '.$NextChangeDay.'\nFilled by: '.checkusername($Pipeline['Qfiller']).'\n------------------------------<br><a href="index.php?mod=nurseform&func=formview&pid='.$pid.'&id=2k"><input type="button" value="Pipelines management" style="background-color:rgb(149,219,208); color:white; font-size:16px; font-weight:bolder; border-radius:5px; border:none; height:30px; margin-top:10px; cursor:pointer;"></a>'.'\', start:\''.str_replace("/","-",$NextChangeDay).'\'}';
					}
				}
			}else{
				$db_instat = new DB;
				$db_instat->query("SELECT `instat` FROM `patient` WHERE `patientID`='".$pid."'");
				$r_instat = $db_instat->fetch_assoc();
				if ($r_instat['instat']==1) {
					if ($noticetxt4f!=NULL) { $noticetxt4f .= ','."\n"; }
					$noticetxt4f .= '{ title: \'-------- Pipeline --------\n'.'Bed #: '.getBedID($pid).'\nResident: '.getPatientName($pid).'\nPipeline: '.$arrForm2k_Q1[$Pipeline['Q1']].'\nMaterial: '.$arrForm2k_Q2[$Pipeline['Q2']].'\nCaliber: '.$Pipeline['Q3'].' Fr.'.'\nSetup/replace date: '.formatdate($Pipeline['date']).'\nReplacement cycle(days): '.$Pipeline['Q4'].'\nNext expected replacement date: '.$NextChangeDay.'\nFilled by: '.checkusername($Pipeline['Qfiller']).'\n------------------------------<br><a href="index.php?mod=nurseform&func=formview&pid='.$pid.'&id=2k"><input type="button" value="Pipelines management" style="background-color:rgb(149,219,208); color:white; font-size:16px; font-weight:bolder; border-radius:5px; border:none; height:30px; margin-top:10px; cursor:pointer;"></a>'.'\', start:\''.str_replace("/","-",$NextChangeDay).'\'}';
				}
			}
		} else {
			if($_GET['area']!=""){
				if (in_array($pid,$rPID)){
					if ($noticetxt4f!=NULL) { $noticetxt4f .= ','."\n"; }
					$noticetxt4f .= '{ title: \'-------- Pipeline --------\n'.'Bed #: '.getBedID($pid).'\nResident: '.getPatientName($pid).'\nPipeline: '.$arrForm2k_Q1[$Pipeline['Q1']].'\nMaterial: '.$arrForm2k_Q2[$Pipeline['Q2']].'\nCaliber: '.$Pipeline['Q3'].' Fr.'.'\nSetup/replace date: '.formatdate($Pipeline['date']).'\nReplacement cycle(days): '.$Pipeline['Q4'].'\nNext expected replacement date: '.$NextChangeDay.'\nFilled by: '.checkusername($Pipeline['Qfiller']).'\n------------------------------<br><a href="index.php?mod=nurseform&func=formview&pid='.$pid.'&id=2k"><input type="button" value="Pipelines management" style="background-color:rgb(149,219,208); color:white; font-size:16px; font-weight:bolder; border-radius:5px; border:none; height:30px; margin-top:10px; cursor:pointer;"></a>'.'\', start:\''.str_replace("/","-",$NextChangeDay).'\'}';
				}
			}else{
				if ($noticetxt4f!=NULL) { $noticetxt4f .= ','."\n"; }
				$noticetxt4f .= '{ title: \'-------- Pipeline --------\n'.'Bed #: '.getBedID($pid).'\nResident: '.getPatientName($pid).'\nPipeline: '.$arrForm2k_Q1[$Pipeline['Q1']].'\nMaterial: '.$arrForm2k_Q2[$Pipeline['Q2']].'\nCaliber: '.$Pipeline['Q3'].' Fr.'.'\nSetup/replace date: '.formatdate($Pipeline['date']).'\nReplacement cycle(days): '.$Pipeline['Q4'].'\nNext expected replacement date: '.$NextChangeDay.'\nFilled by: '.checkusername($Pipeline['Qfiller']).'\n------------------------------<br><a href="index.php?mod=nurseform&func=formview&pid='.$pid.'&id=2k"><input type="button" value="Pipelines management" style="background-color:rgb(149,219,208); color:white; font-size:16px; font-weight:bolder; border-radius:5px; border:none; height:30px; margin-top:10px; cursor:pointer;"></a>'.'\', start:\''.str_replace("/","-",$NextChangeDay).'\'}';
			}
		}
	}
}
?>
</div>

<script>
$(document).ready(function() {
    $('#calendar').fullCalendar({
		theme: true,
		header: {

				left: 'prev,next today',

				center: 'title',

				right: 'month,basicWeek,basicDay'

		},
		defaultView: 'month',
		editable: false,
		eventSources: [
		{
			events: [<?php echo $noticetxt4; ?>],
			color: '#3a87ad',
			textColor: 'white'
    	}, 
		{
			events: [<?php echo $noticetxt4a; ?>],
			color: '#db9b24',
			textColor: 'white'
    	},
		{
			events: [<?php echo $noticetxt4b; ?>],
			color: '#38a351',
			textColor: 'white'
    	},
		{
			events: [<?php echo $noticetxt4c; ?>],
			color: '#969810',
			textColor: 'white'
    	},
		{
			events: [<?php echo $noticetxt4d; ?>],
			color: '#65aea3',
			textColor: 'white'
    	},
		{
			events: [<?php echo $noticetxt4e; ?>],
			color: '#DF62A9',
			textColor: 'white'
    	},
		{
			events: [<?php echo $noticetxt4f; ?>],
			color: '#c64d0c',
			textColor: 'white'
    	},
		],
		eventClick: function(calEvent, jsEvent, view) {
			var text = calEvent.title;
			var text2 = text.replace(/\n/g,'<br>');
			var modalSelet1 = text.search(/-- System --/);
			var modalSelet2 = text.search(/-- Announcement --/);
			var modalSelet3 = text.search(/-- Clinic revisit --/);
			var modalSelet4 = text.search(/-- Reminder --/);
			var modalSelet5 = text.search(/-- Medication --/);
			var modalSelet6 = text.search(/-- Insulin --/);
			var modalSelet7 = text.search(/-- Pipeline --/);
			$('#modal1').fadeOut(); $('#modal2').fadeOut(); $('#modal3').fadeOut(); $('#modal4').fadeOut(); $('#modal5').fadeOut(); $('#modal6').fadeOut(); $('#modal7').fadeOut();
			if(modalSelet1!=-1){
				
				$("#modalDialog1").html(text2);
				$("#modal1").fadeIn();
			}
			if(modalSelet2!=-1){
			    $("#modalDialog2").html(text2);
			    $("#modal2").fadeIn();
			}
			if(modalSelet3!=-1){
			    $("#modalDialog3").html(text2);
			    $("#modal3").fadeIn();
			}
			if(modalSelet4!=-1){
			    $("#modalDialog4").html(text2);
			    $("#modal4").fadeIn();
			}
			if(modalSelet5!=-1){
			    $("#modalDialog5").html(text2);
			    $("#modal5").fadeIn();
			}
			if(modalSelet6!=-1){
			    $("#modalDialog6").html(text2);
			    $("#modal6").fadeIn();
			}
			if(modalSelet7!=-1){
			    $("#modalDialog7").html(text2);
			    $("#modal7").fadeIn();
			}
		},
		eventMouseover: function( event, jsEvent, view ) {
			$(this).css("cursor", "pointer");
		}
    });
	$("#format").buttonset();
	$("#format2").buttonset();
});
</script>

<div class="calendarModal" id="modal1" style="background-color:rgba(101, 174, 163,0.95);">
<div id="modalDialog1" align="center"></div>
<div align="center"><button class="calendarCloseBtn" onclick="$('#modal1').fadeOut();">Close</button></div>
</div>
<div class="calendarModal" id="modal2" style="background-color:rgba(56, 163, 81,0.95);">
<div id="modalDialog2" align="center"></div>
<div align="center"><button class="calendarCloseBtn" onclick="$('#modal2').fadeOut();">Close</button></div>
</div>
<div class="calendarModal" id="modal3" style="background-color:rgba(219, 155, 36,0.95);">
<div id="modalDialog3" align="center"></div>
<div align="center"><button class="calendarCloseBtn" onclick="$('#modal3').fadeOut();" style="margin-top:10px;">Close</button></div>
</div>
<div class="calendarModal" id="modal4" style="background-color:rgba(57,134,172,0.95);">
<div id="modalDialog4" align="center"></div>
<div align="center"><button class="calendarCloseBtn" onclick="$('#modal4').fadeOut();" style="margin-top:10px;">Close</button></div>
</div>
<div class="calendarModal" id="modal5" style="background-color:rgba(150, 152, 16, 0.95);">
<div id="modalDialog5" align="center"></div>
<div align="center"><button class="calendarCloseBtn" onclick="$('#modal5').fadeOut();" style="margin-top:10px;">Close</button></div>
</div>
<div class="calendarModal" id="modal6" style="background-color:rgba(223,98,169,0.95);">
<div id="modalDialog6" align="center"></div>
<div align="center"><button class="calendarCloseBtn" onclick="$('#modal6').fadeOut();" style="margin-top:10px;">Close</button></div>
</div>
<div class="calendarModal" id="modal7" style="background-color:rgba(198, 77, 12, 0.95);">
<div id="modalDialog7" align="center"></div>
<div align="center"><button class="calendarCloseBtn" onclick="$('#modal7').fadeOut();" style="margin-top:10px;">Close</button></div>
</div>