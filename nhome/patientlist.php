<?php
if(substr($_SESSION['ncareID_lwj'],0,8)=="resident"){
$HospNo = substr($_SESSION['ncareID_lwj'],8,6);
$db = new DB;
$db->query("SELECT `patientID` FROM `patient` WHERE `HospNo`='".mysql_escape_string($HospNo)."'");
$r = $db->fetch_assoc();
$url = "index.php?mod=nurseform&func=formview&pid=".$r['patientID'];
echo "<script type='text/javascript'>";
echo "window.location.href='".$url."'";
echo "</script>";
}else{
?>
<script type="text/javascript" src="js/WYJ_slider.js"></script>
<script type="text/javascript" src="js/WYJ_slider2.js"></script>
<script type="text/javascript" src="js/LWJ_PatientPic.js"></script>
<div id="slider_scroll">
     <div id="slider_tab">
      <span>T</span>
      <span>o</span>
      <span>o</span>
      <span>l</span>
      <span>P</span>
      <span>a</span>
      <span>n</span>
      <span>e</span>
      <span>l</span>  
    </div>
    <div id="slider_content">
      <div class="patlistbtn"><a href="index.php?func=printPatStat" title="Name List"><i class="fa fa-users fa-2x fa-fw"></i><br>Name List</a></div>
      <div class="patlistbtn"><a href="index.php?func=form2klist" title="Usage of catheter"><i class="fa fa-newspaper-o fa-2x fa-fw"></i><br>Usage of catheter</a></div>
      <div class="patlistbtn"><a href="index.php?func=formremind&type=1" title="Form reminder"><i class="fa fa-warning fa-2x fa-fw"></i><br>Form Reminder</a></div>
      <div class="patlistbtn"><a href="index.php?func=reminderlist&date1=<?php echo date(Ymd); ?>&date2=<?php echo str_replace("/","",calcdayafterday(date(Ymd),30)); ?>" title="Reminder"><i class="fa fa-tasks fa-2x fa-fw"></i><br>Reminder</a></div>
      <div class="patlistbtn"><a href="index.php?func=reminderlist2&date1=<?php echo date(Ymd); ?>&date2=<?php echo str_replace("/","",calcdayafterday(date(Ymd),30)); ?>" title="Special reminder"><i class="fa fa-bell-o fa-2x fa-fw"></i><br>Special reminder</a></div>
      <div class="patlistbtn"><a href="index.php?func=shiftrecord&date1=<?php echo str_replace("/","",calcdayafterday(date(Ymd),-7)); ?>&date2=<?php echo date(Ymd); ?>" title="Nursing Record"><i class="fa fa-list fa-2x fa-fw"></i><br>Nursing Records</a></div>
      <div class="patlistbtn"><a href="index.php?func=shiftrecord1" title="Shift record"><i class="fa fa-refresh fa-2x fa-fw"></i><br>Shift record</a></div>
      <!--<div class="patlistbtn"><a href="index.php?mod=management&func=formview&id=3" title="指標分析"><i class="fa fa-pie-chart fa-2x fa-fw"></i><br>指標分析</a></div>-->
      <div class="patlistbtn"><a href="index.php?func=areadmin" title="Bed Management"><i class="fa fa-bed fa-2x fa-fw"></i><br>Bed Manage</a></div>
      <div class="patlistbtn"><a href="index.php?mod=nurseform&func=formview&id=6" title="Meeting record"><i class="fa fa-users fa-2x fa-fw"></i><br>Meeting Record</a></div>
      <div class="patlistbtn"><a href="index.php?func=form2jtracklist" title="Tracking of pain"><i class="fa fa-list-alt fa-2x fa-fw"></i><br>Tracking of pain</a></div>
      <div class="patlistbtn"><a href="index.php?func=newcase" title="New Resident"><i class="fa fa-user-plus fa-2x fa-fw"></i><br>New Resident</a></div>
    </div>
</div>
<div id="slider_scroll2">
     <div id="slider_tab2">
      <span>M</span>
      <span>e</span>
      <span>m</span>
      <span>o</span> 
    </div>
    <div id="slider_content2">
	  <div class="patlistbtn2">
	  <?php include('EasyWork_WorkMemoCheck.php'); ?>
	  </div>
    </div>
</div>
<div id="typeTab" onclick="closecol();">
  <ul>
    <li><a href="#typeTab-1">Long-term</a></li>
    <li><a href="#typeTab-2">Short-term</a></li>
    <li><a href="#typeTab-3">Respite</a></li>
    <li><a href="#typeTab-5">Govnment</a></li>
    <li><a href="#typeTab-6">Emergency</a></li>
    <li><a href="#typeTab-4">Closed Case</a></li>
  </ul>
  <div id="typeTab-1">
  <table id="patlist1" class="hover">
  <?php
  $sql1 = "SELECT `patientID` FROM `inpatientinfo` a INNER JOIN `bedinfo` b ON a.`bed`=b.`bedID` ORDER BY b.`Area` ASC, a.`bed` ASC";
  $db = new DB;
  $db->query($sql1);
      echo '
      <thead>
      <tr class="title">
        <th>Func.</th>
        <th>Area</th>
        <th>Bed</th>
        <th>Name</th>
        <th>No.</th>
        <th>Gender</th>  
        <th>Age</th>
        <th>Admission Date</th>
        <th style="width:128px;">Bed Work</th>
		<th>Materials</th>
        <th>Memo</th>
      </tr>
      </thead>'."\n";
      for ($i=0;$i<$db->num_rows();$i++) {
          $r = $db->fetch_assoc();
          $db1 = new DB;
          $db1->query("SELECT `bed`,`indate` FROM `inpatientinfo` a INNER JOIN `patient` b ON a.patientID = b.patientID WHERE a.`patientID`='".$r['patientID']."' AND b.`type`='1' ORDER BY a.`patientID` DESC LIMIT 0,1");
          for ($j=0;$j<$db1->num_rows();$j++) {
              $r1 = $db1->fetch_assoc();
              if (@$_GET['query']==1 && $_GET['type']==1) {
                  if (count($arrAreaBed)==0) {
                      if (@$_GET['query']!=NULL) {
                          echo '<script>alert("No Information");</script>'."\n";
                          break 2;
                      }
                  }
              }
              $db2a = new DB;
              $db2a->query("SELECT `Area` FROM `bedinfo` WHERE `bedID`='".$r1['bed']."'");
              $r2a = $db2a->fetch_assoc();
              $db2b = new DB;
              $db2b->query("SELECT `areaName` FROM `areainfo` WHERE `areaID`='".$r2a['Area']."'");
              $r2b = $db2b->fetch_assoc();
              $db2c = new DB;
              $db2c->query("SELECT `patientID`,`HospNo`,`HospNoDisplay`,`Birth`,`instat` FROM `patient` WHERE `patientID`='".$r['patientID']."' AND `type`='1'");
              $r2c = $db2c->fetch_assoc();
              if (count($arrAreaBed)==0 || in_array($r1['bed'],$arrAreaBed)) {
				  if(in_array($r2b['areaName'],$User_Shift_Area) || $_SESSION['ncareLevel_lwj']==5 || $_SESSION['GroupLeader_lwj']==1 || $_SESSION['ncareID_lwj']==getPrimary_Duty_Nurse($r2b['areaName'])){//排班權限
				  echo '<div name="PatientPic_'.$r['patientID'].'" id="PatientPic_'.$r['patientID'].'" style="display:none; z-index:999; position:fixed;">'.getPatientPic($r2c['HospNo']).'</div>';
				  echo '
                  <tr';
                  if ($_SESSION['ncareOrgStatus_lwj']==2) {
                      if ($r2c['instat']==0) { echo ' style="display:none;"'; }
                  }
                  echo '>
                    <td class="link1">
                      <center>
                      <a href="index.php?mod=nurseform&func=formview&pid='.$r['patientID'].'" title="Edit" onmouseover="showPatientPic('.$r['patientID'].');" onmouseout="hiddenPatientPic('.$r['patientID'].');"><i class="fa fa-magic fa-lg"></i></a>
                      </center>
                    </td>
                    <td>'.$r2b['areaName'].'</td>
                    <td>'.$r1['bed'].'</td>
                    <td align="left">';
					  $db5 = new DB;
					  $db5->query("SELECT `round` FROM `nurserounds` WHERE `HospNo`='".$r2c['HospNo']."' AND `date`='".date(Ymd)."' AND `Qfiller`='".$_SESSION['ncareID_lwj']."'");
					  if($db5->num_rows()>0){
						  echo '<button id="CheckRound_OFF_'.$r['patientID'].'"><i id="CheckRound_OFF_'.$r['patientID'].'_icon" class="fa fa-check-square-o"></i></button>';
					  }else{
						  echo '<button id="CheckRound_ON_'.$r['patientID'].'"><i id="CheckRound_ON_'.$r['patientID'].'_icon" class="fa fa-square-o"></i></button>';
					  }
					  echo ' '.getPatientName($r2c['patientID']).'
					</td>
                    <td>'.$r2c['HospNoDisplay'].'</td>
                    <td align="center">'.(checkgender($r['patientID'])=="Male"?'<span style="color:CornflowerBlue;"><i class="fa fa-2x fa-male"></i></span>':(checkgender($r['patientID'])=="Female"?'<span style="color:pink;"><i class="fa fa-2x fa-female"></i></span>':'---')).'</td>  
                    <td>'.calcage($r2c['Birth']).'</td>
                    <td>'.formatdate($r1['indate']).'</td>
                    <td class="link1"><center>
					  <a onclick="changeinfo(\''.$r2c['HospNo'].'\')" title="Modify Care ID # or resident type"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-pencil fa-stack-1x fa-inverse"></i></span></a>
                      <a onclick="closecase(\''.$r2c['HospNo'].'\')" title="Discharge resident"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-user-times fa-stack-1x fa-inverse"></i></span></a>
                      <a onclick="changebed(\''.$r2c['HospNo'].'\')" title="Move bed"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-arrows fa-stack-1x fa-inverse"></i></span></a>
					  <a onclick="switchbed(\''.$r2c['HospNo'].'\')" title="Swap bed"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-retweet fa-stack-1x fa-inverse"></i></span></a>
                      <a href="index.php?mod=nurseform&func=formview&pid='.$r['patientID'].'&id=30_1" title="Resident absent record"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-exchange fa-stack-1x fa-inverse"></i></span></a>
					  <a href="index.php?func=NurseRounds&pid='.$r['patientID'].'" title="Rounds"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-eye fa-stack-1x fa-inverse"></i></span></a>
                    </center>
                    </td>
					<td class="link1">
                      <center>
                      <a href="index.php?mod=consump&func=formview&id=3&pid='.$r['patientID'].'&query='.@$_GET['query'].'" title="Apply for item"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-shopping-cart fa-stack-1x fa-inverse"></i></span></a>
                      <a href="index.php?func=editmonthlyfee&pid='.$r['patientID'].'" title="Input charging"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-dollar fa-stack-1x fa-inverse"></i></span></a>
                      </center>
                    </td>
                    <td><center>';
                  $memotxt = "";
                  $db3 = new DB;
                  $db3->query("SELECT `Qmemo_1`, `Qmemo_2` FROM `nurseform01` WHERE `HospNo`='".$r2c['HospNo']."' ORDER BY `date` DESC LIMIT 0,1");
                  $r3 = $db3->fetch_assoc();
                  if ($r3['Qmemo_1']==1) { $memotxt = '<a title="DNR">D</a>'; }
                  if ($r3['Qmemo_2']==1) { if ($memotxt!="") { $memotxt .= '、'; } $memotxt .= ' <a title="No hospitalization">N</a>'; }
                  echo $memotxt;
                  echo '</center></td></tr>'."\n";
				  }//排班權限
              }
          }
      }
      ?>
  </table>
  </div>
  <div id="typeTab-2">
  <table id="patlist2" class="hover">
  <?php
  $sql1 = "SELECT `patientID` FROM `inpatientinfo` a INNER JOIN `bedinfo` b ON a.`bed`=b.`bedID` ORDER BY b.`Area` ASC, a.`bed` ASC";
  $db = new DB;
  $db->query($sql1);
      echo '
      <thead>
      <tr class="title">
        <th>Func.</th>
        <th>Area</th>
        <th>Bed</th>
        <th>Name</th>
        <th>No.</th>
        <th>Gender</th>  
        <th>Age</th>
        <th>Check-in date</th>
        <th style="width:128px;">Bed work</th>
        <th>Materials</th>
        <th>Memo</th>
      </tr>
      </thead>'."\n";
      for ($i=0;$i<$db->num_rows();$i++) {
          $r = $db->fetch_assoc();
          $db1 = new DB;
          $db1->query("SELECT `bed`,`indate` FROM `inpatientinfo` a INNER JOIN `patient` b ON a.patientID = b.patientID WHERE a.`patientID`='".$r['patientID']."' AND b.`type`='2' ORDER BY a.`patientID` DESC LIMIT 0,1");
          for ($j=0;$j<$db1->num_rows();$j++) {
              $r1 = $db1->fetch_assoc();
              if (@$_GET['query']==1 && $_GET['type']==1) {
                  if (count($arrAreaBed)==0) {
                      if (@$_GET['query']!=NULL) {
                          echo '<script>alert("No Information");</script>'."\n";
                          break 2;
                      }
                  }
              }
              $db2a = new DB;
              $db2a->query("SELECT `Area` FROM `bedinfo` WHERE `bedID`='".$r1['bed']."'");
              $r2a = $db2a->fetch_assoc();
              $db2b = new DB;
              $db2b->query("SELECT `areaName` FROM `areainfo` WHERE `areaID`='".$r2a['Area']."'");
              $r2b = $db2b->fetch_assoc();
              $db2c = new DB;
              $db2c->query("SELECT `patientID`,`HospNo`,`HospNoDisplay`,`Birth`,`instat` FROM `patient` WHERE `patientID`='".$r['patientID']."' AND `type`='2'");
              $r2c = $db2c->fetch_assoc();
              if (count($arrAreaBed)==0 || in_array($r1['bed'],$arrAreaBed)) {
				  if(in_array($r2b['areaName'],$User_Shift_Area) || $_SESSION['ncareLevel_lwj']==5 || $_SESSION['GroupLeader_lwj']==1 || $_SESSION['ncareID_lwj']==getPrimary_Duty_Nurse($r2b['areaName'])){//排班權限
				  echo '<div name="PatientPic_'.$r['patientID'].'" id="PatientPic_'.$r['patientID'].'" style="display:none; z-index:999; position:fixed;">'.getPatientPic($r2c['HospNo']).'</div>';
                  echo '
                  <tr';
                  if ($_SESSION['ncareOrgStatus_lwj']==2) {
                      if ($r2c['instat']==0) { echo ' style="display:none;"'; }
                  }
                  echo '>
                    <td class="link1">
                      <center>
                      <a href="index.php?mod=nurseform&func=formview&pid='.$r['patientID'].'&query='.@$_GET['query'].'" title="Edit" onmouseover="showPatientPic('.$r['patientID'].');" onmouseout="hiddenPatientPic('.$r['patientID'].');"><i class="fa fa-magic fa-lg"></i></a>
                      </center>
                    </td>
                    <td>'.$r2b['areaName'].'</td>
                    <td>'.$r1['bed'].'</td>
                    <td align="left">';
					  $db5 = new DB;
					  $db5->query("SELECT `round` FROM `nurserounds` WHERE `HospNo`='".$r2c['HospNo']."' AND `date`='".date(Ymd)."' AND `Qfiller`='".$_SESSION['ncareID_lwj']."'");
					  if($db5->num_rows()>0){
						  echo '<button id="CheckRound_OFF_'.$r['patientID'].'"><i id="CheckRound_OFF_'.$r['patientID'].'_icon" class="fa fa-check-square-o"></i></button>';
					  }else{
						  echo '<button id="CheckRound_ON_'.$r['patientID'].'"><i id="CheckRound_ON_'.$r['patientID'].'_icon" class="fa fa-square-o"></i></button>';
					  }
					  echo ' '.getPatientName($r2c['patientID']).'
					</td>
                    <td>'.$r2c['HospNoDisplay'].'</td>
                    <td align="center">'.(checkgender($r['patientID'])=="Male"?'<span style="color:CornflowerBlue;"><i class="fa fa-2x fa-male"></i></span>':(checkgender($r['patientID'])=="Female"?'<span style="color:pink;"><i class="fa fa-2x fa-female"></i></span>':'---')).'</td>  
                    <td>'.calcage($r2c['Birth']).'</td>
                    <td>'.formatdate($r1['indate']).'</td>
                    <td class="link1"><center>
					  <a onclick="changeinfo(\''.$r2c['HospNo'].'\')" title="Modify Care ID # or resident type"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-pencil fa-stack-1x fa-inverse"></i></span></a>
                      <a onclick="closecase(\''.$r2c['HospNo'].'\')" title="Discharge resident"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-user-times fa-stack-1x fa-inverse"></i></span></a>
                      <a onclick="changebed(\''.$r2c['HospNo'].'\')" title="Move bed"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-arrows fa-stack-1x fa-inverse"></i></span></a>
					  <a onclick="switchbed(\''.$r2c['HospNo'].'\')" title="Swap bed"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-retweet fa-stack-1x fa-inverse"></i></span></a>
                      <a href="index.php?mod=nurseform&func=formview&pid='.$r['patientID'].'&id=30_1" title="Resident absent record"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-exchange fa-stack-1x fa-inverse"></i></span></a>
					  <a href="index.php?func=NurseRounds&pid='.$r['patientID'].'" title="Rounds"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-eye fa-stack-1x fa-inverse"></i></span></a>
                    </center>
                    </td>
                    <td class="link1">
                      <center>
                      <a href="index.php?mod=consump&func=formview&id=3&pid='.$r['patientID'].'&query='.@$_GET['query'].'" title="Apply for item"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-shopping-cart fa-stack-1x fa-inverse"></i></span></a>
                      <a href="index.php?func=editmonthlyfee&pid='.$r['patientID'].'" title="Input charging"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-dollar fa-stack-1x fa-inverse"></i></span></a>
                      </center>
                    </td>
                    <td><center>';
                  $memotxt = "";
                  $db3 = new DB;
                  $db3->query("SELECT `Qmemo_1`, `Qmemo_2` FROM `nurseform01` WHERE `HospNo`='".$r2c['HospNo']."' ORDER BY `date` DESC LIMIT 0,1");
                  $r3 = $db3->fetch_assoc();
                  if ($r3['Qmemo_1']==1) { $memotxt = '<a title="DNR">D</a>'; }
                  if ($r3['Qmemo_2']==1) { if ($memotxt!="") { $memotxt .= '、'; } $memotxt .= ' <a title="No hospitalization">N</a>'; }
                  echo $memotxt;
                  echo '</center></td></tr>'."\n";
				  }//排班權限
              }
          }
      }
      ?>
  </table>
  </div>
  <div id="typeTab-3">
  <table id="patlist3" class="hover">
  <?php
  $sql1 = "SELECT `patientID` FROM `inpatientinfo` a INNER JOIN `bedinfo` b ON a.`bed`=b.`bedID` ORDER BY b.`Area` ASC, a.`bed` ASC";
  $db = new DB;
  $db->query($sql1);
      echo '
      <thead>
      <tr class="title">
        <th>Func.</th>
        <th>Area</th>
        <th>Bed</th>
        <th>Name</th>
        <th>No.</th>
        <th>Gender</th>  
        <th>Age</th>
        <th>Check-in date</th>
        <th style="width:128px;">Bed work</th>
        <th>Materials</th>
        <th>Memo</th>
      </tr>
      </thead>'."\n";
      for ($i=0;$i<$db->num_rows();$i++) {
          $r = $db->fetch_assoc();
          $db1 = new DB;
          $db1->query("SELECT `bed`,`indate` FROM `inpatientinfo` a INNER JOIN `patient` b ON a.patientID = b.patientID WHERE a.`patientID`='".$r['patientID']."' AND b.`type`='3' ORDER BY a.`patientID` DESC LIMIT 0,1");
          for ($j=0;$j<$db1->num_rows();$j++) {
              $r1 = $db1->fetch_assoc();
              if (@$_GET['query']==1 && $_GET['type']==1) {
                  if (count($arrAreaBed)==0) {
                      if (@$_GET['query']!=NULL) {
                          echo '<script>alert("No Information");</script>'."\n";
                          break 2;
                      }
                  }
              }
              $db2a = new DB;
              $db2a->query("SELECT `Area` FROM `bedinfo` WHERE `bedID`='".$r1['bed']."'");
              $r2a = $db2a->fetch_assoc();
              $db2b = new DB;
              $db2b->query("SELECT `areaName` FROM `areainfo` WHERE `areaID`='".$r2a['Area']."'");
              $r2b = $db2b->fetch_assoc();
              $db2c = new DB;
              $db2c->query("SELECT `patientID`,`HospNo`,`HospNoDisplay`,`Birth`,`instat` FROM `patient` WHERE `patientID`='".$r['patientID']."' AND `type`='3'");
              $r2c = $db2c->fetch_assoc();
              if (count($arrAreaBed)==0 || in_array($r1['bed'],$arrAreaBed)) {
				  if(in_array($r2b['areaName'],$User_Shift_Area) || $_SESSION['ncareLevel_lwj']==5 || $_SESSION['GroupLeader_lwj']==1 || $_SESSION['ncareID_lwj']==getPrimary_Duty_Nurse($r2b['areaName'])){//排班權限
				  echo '<div name="PatientPic_'.$r['patientID'].'" id="PatientPic_'.$r['patientID'].'" style="display:none; z-index:999; position:fixed;">'.getPatientPic($r2c['HospNo']).'</div>';
                  echo '
                  <tr';
                  if ($_SESSION['ncareOrgStatus_lwj']==2) {
                      if ($r2c['instat']==0) { echo ' style="display:none;"'; }
                  }
                  echo '>
                    <td class="link1">
                      <center>
                      <a href="index.php?mod=nurseform&func=formview&pid='.$r['patientID'].'&query='.@$_GET['query'].'" title="Edit" onmouseover="showPatientPic('.$r['patientID'].');" onmouseout="hiddenPatientPic('.$r['patientID'].');"><i class="fa fa-magic fa-lg"></i></a>
                      </center>
                    </td>
                    <td>'.$r2b['areaName'].'</td>
                    <td>'.$r1['bed'].'</td>
                    <td align="left">';
					  $db5 = new DB;
					  $db5->query("SELECT `round` FROM `nurserounds` WHERE `HospNo`='".$r2c['HospNo']."' AND `date`='".date(Ymd)."' AND `Qfiller`='".$_SESSION['ncareID_lwj']."'");
					  if($db5->num_rows()>0){
						  echo '<button id="CheckRound_OFF_'.$r['patientID'].'"><i id="CheckRound_OFF_'.$r['patientID'].'_icon" class="fa fa-check-square-o"></i></button>';
					  }else{
						  echo '<button id="CheckRound_ON_'.$r['patientID'].'"><i id="CheckRound_ON_'.$r['patientID'].'_icon" class="fa fa-square-o"></i></button>';
					  }
					  echo ' '.getPatientName($r2c['patientID']).'
					</td>
                    <td>'.$r2c['HospNoDisplay'].'</td>
                    <td align="center">'.(checkgender($r['patientID'])=="Male"?'<span style="color:CornflowerBlue;"><i class="fa fa-2x fa-male"></i></span>':(checkgender($r['patientID'])=="Female"?'<span style="color:pink;"><i class="fa fa-2x fa-female"></i></span>':'---')).'</td>  
                    <td>'.calcage($r2c['Birth']).'</td>
                    <td>'.formatdate($r1['indate']).'</td>
                    <td class="link1"><center>
					  <a onclick="changeinfo(\''.$r2c['HospNo'].'\')" title="Modify Care ID # or resident type"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-pencil fa-stack-1x fa-inverse"></i></span></a>
                      <a onclick="closecase(\''.$r2c['HospNo'].'\')" title="Discharge resident"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-user-times fa-stack-1x fa-inverse"></i></span></a>
                      <a onclick="changebed(\''.$r2c['HospNo'].'\')" title="Move bed"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-arrows fa-stack-1x fa-inverse"></i></span></a>
					  <a onclick="switchbed(\''.$r2c['HospNo'].'\')" title="Swap bed"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-retweet fa-stack-1x fa-inverse"></i></span></a>
                      <a href="index.php?mod=nurseform&func=formview&pid='.$r['patientID'].'&id=30_1" title="Resident absent record"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-exchange fa-stack-1x fa-inverse"></i></span></a>
					  <a href="index.php?func=NurseRounds&pid='.$r['patientID'].'" title="Rounds"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-eye fa-stack-1x fa-inverse"></i></span></a>
                    </center>
                    </td>
                    <td class="link1">
                      <center>
                      <a href="index.php?mod=consump&func=formview&id=3&pid='.$r['patientID'].'&query='.@$_GET['query'].'" title="Apply for item"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-shopping-cart fa-stack-1x fa-inverse"></i></span></a>
                      <a href="index.php?func=editmonthlyfee&pid='.$r['patientID'].'" title="Input charging"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-dollar fa-stack-1x fa-inverse"></i></span></a>
                      </center>
                    </td>
                    <td><center>';
                  $memotxt = "";
                  $db3 = new DB;
                  $db3->query("SELECT `Qmemo_1`, `Qmemo_2` FROM `nurseform01` WHERE `HospNo`='".$r2c['HospNo']."' ORDER BY `date` DESC LIMIT 0,1");
                  $r3 = $db3->fetch_assoc();
                  if ($r3['Qmemo_1']==1) { $memotxt = '<a title="DNR">D</a>'; }
                  if ($r3['Qmemo_2']==1) { if ($memotxt!="") { $memotxt .= '、'; } $memotxt .= ' <a title="No hospitalization">N</a>'; }
                  echo $memotxt;
                  echo '</center></td></tr>'."\n";
				  }//排班權限
              }
          }
      }
      ?>
  </table>
  </div>
  <div id="typeTab-5">
  <table id="patlist5" class="hover">
  <?php
  $sql1 = "SELECT `patientID` FROM `inpatientinfo` a INNER JOIN `bedinfo` b ON a.`bed`=b.`bedID` ORDER BY b.`Area` ASC, a.`bed` ASC";
  $db = new DB;
  $db->query($sql1);
      echo '
      <thead>
      <tr class="title">
        <th>Func.</th>
        <th>Area</th>
        <th>Bed</th>
        <th>Name</th>
        <th>No.</th>
        <th>Gender</th>  
        <th>Age</th>
        <th>Check-in date</th>
        <th style="width:128px;">Bed work</th>
        <th>Materials</th>
        <th>Memo</th>
      </tr>
      </thead>'."\n";
      for ($i=0;$i<$db->num_rows();$i++) {
          $r = $db->fetch_assoc();
          $db1 = new DB;
          $db1->query("SELECT `bed`,`indate` FROM `inpatientinfo` a INNER JOIN `patient` b ON a.patientID = b.patientID WHERE a.`patientID`='".$r['patientID']."' AND b.`type`='4' ORDER BY a.`patientID` DESC LIMIT 0,1");
          for ($j=0;$j<$db1->num_rows();$j++) {
              $r1 = $db1->fetch_assoc();
              if (@$_GET['query']==1 && $_GET['type']==1) {
                  if (count($arrAreaBed)==0) {
                      if (@$_GET['query']!=NULL) {
                          echo '<script>alert("No Information");</script>'."\n";
                          break 2;
                      }
                  }
              }
              $db2a = new DB;
              $db2a->query("SELECT `Area` FROM `bedinfo` WHERE `bedID`='".$r1['bed']."'");
              $r2a = $db2a->fetch_assoc();
              $db2b = new DB;
              $db2b->query("SELECT `areaName` FROM `areainfo` WHERE `areaID`='".$r2a['Area']."'");
              $r2b = $db2b->fetch_assoc();
              $db2c = new DB;
              $db2c->query("SELECT `patientID`,`HospNo`,`HospNoDisplay`,`Birth`,`instat` FROM `patient` WHERE `patientID`='".$r['patientID']."' AND `type`='4'");
              $r2c = $db2c->fetch_assoc();
              if (count($arrAreaBed)==0 || in_array($r1['bed'],$arrAreaBed)) {
				  if(in_array($r2b['areaName'],$User_Shift_Area) || $_SESSION['ncareLevel_lwj']==5 || $_SESSION['GroupLeader_lwj']==1 || $_SESSION['ncareID_lwj']==getPrimary_Duty_Nurse($r2b['areaName'])){//排班權限
				  echo '<div name="PatientPic_'.$r['patientID'].'" id="PatientPic_'.$r['patientID'].'" style="display:none; z-index:999; position:fixed;">'.getPatientPic($r2c['HospNo']).'</div>';
                  echo '
                  <tr';
                  if ($_SESSION['ncareOrgStatus_lwj']==2) {
                      if ($r2c['instat']==0) { echo ' style="display:none;"'; }
                  }
                  echo '>
                    <td class="link1">
                      <center>
                      <a href="index.php?mod=nurseform&func=formview&pid='.$r['patientID'].'&query='.@$_GET['query'].'" title="Edit" onmouseover="showPatientPic('.$r['patientID'].');" onmouseout="hiddenPatientPic('.$r['patientID'].');"><i class="fa fa-magic fa-lg"></i></a>
                      </center>
                    </td>
                    <td>'.$r2b['areaName'].'</td>
                    <td>'.$r1['bed'].'</td>
                    <td align="left">';
					  $db5 = new DB;
					  $db5->query("SELECT `round` FROM `nurserounds` WHERE `HospNo`='".$r2c['HospNo']."' AND `date`='".date(Ymd)."' AND `Qfiller`='".$_SESSION['ncareID_lwj']."'");
					  if($db5->num_rows()>0){
						  echo '<button id="CheckRound_OFF_'.$r['patientID'].'"><i id="CheckRound_OFF_'.$r['patientID'].'_icon" class="fa fa-check-square-o"></i></button>';
					  }else{
						  echo '<button id="CheckRound_ON_'.$r['patientID'].'"><i id="CheckRound_ON_'.$r['patientID'].'_icon" class="fa fa-square-o"></i></button>';
					  }
					  echo ' '.getPatientName($r2c['patientID']).'
					</td>
                    <td>'.$r2c['HospNoDisplay'].'</td>
                    <td align="center">'.(checkgender($r['patientID'])=="Male"?'<span style="color:CornflowerBlue;"><i class="fa fa-2x fa-male"></i></span>':(checkgender($r['patientID'])=="Female"?'<span style="color:pink;"><i class="fa fa-2x fa-female"></i></span>':'---')).'</td>  
                    <td>'.calcage($r2c['Birth']).'</td>
                    <td>'.formatdate($r1['indate']).'</td>
                    <td class="link1"><center>
					  <a onclick="changeinfo(\''.$r2c['HospNo'].'\')" title="Modify Care ID # or resident type"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-pencil fa-stack-1x fa-inverse"></i></span></a>
                      <a onclick="closecase(\''.$r2c['HospNo'].'\')" title="Discharge resident"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-user-times fa-stack-1x fa-inverse"></i></span></a>
                      <a onclick="changebed(\''.$r2c['HospNo'].'\')" title="Move bed"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-arrows fa-stack-1x fa-inverse"></i></span></a>
					  <a onclick="switchbed(\''.$r2c['HospNo'].'\')" title="Swap bed"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-retweet fa-stack-1x fa-inverse"></i></span></a>
                      <a href="index.php?mod=nurseform&func=formview&pid='.$r['patientID'].'&id=30_1" title="Resident absent record"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-exchange fa-stack-1x fa-inverse"></i></span></a>
					  <a href="index.php?func=NurseRounds&pid='.$r['patientID'].'" title="Rounds"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-eye fa-stack-1x fa-inverse"></i></span></a>
                    </center>
                    </td>
                    <td class="link1">
                      <center>
                      <a href="index.php?mod=consump&func=formview&id=3&pid='.$r['patientID'].'&query='.@$_GET['query'].'" title="Apply for item"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-shopping-cart fa-stack-1x fa-inverse"></i></span></a>
                      <a href="index.php?func=editmonthlyfee&pid='.$r['patientID'].'" title="Input charging"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-dollar fa-stack-1x fa-inverse"></i></span></a>
                      </center>
                    </td>
                    <td><center>';
                  $memotxt = "";
                  $db3 = new DB;
                  $db3->query("SELECT `Qmemo_1`, `Qmemo_2` FROM `nurseform01` WHERE `HospNo`='".$r2c['HospNo']."' ORDER BY `date` DESC LIMIT 0,1");
                  $r3 = $db3->fetch_assoc();
                  if ($r3['Qmemo_1']==1) { $memotxt = '<a title="DNR">D</a>'; }
                  if ($r3['Qmemo_2']==1) { if ($memotxt!="") { $memotxt .= '、'; } $memotxt .= ' <a title="No hospitalization">N</a>'; }
                  echo $memotxt;
                  echo '</center></td></tr>'."\n";
				  }//排班權限
              }
          }
      }
      ?>
  </table>
  </div>
  <div id="typeTab-6">
  <table id="patlist6" class="hover">
  <?php
  $sql1 = "SELECT `patientID` FROM `inpatientinfo` a INNER JOIN `bedinfo` b ON a.`bed`=b.`bedID` ORDER BY b.`Area` ASC, a.`bed` ASC";
  $db = new DB;
  $db->query($sql1);
      echo '
      <thead>
      <tr class="title">
        <th>Func.</th>
        <th>Area</th>
        <th>Bed</th>
        <th>Name</th>
        <th>No.</th>
        <th>Gender</th>  
        <th>Age</th>
        <th>Check-in date</th>
        <th style="width:128px;">Bed work</th>
        <th>Materials</th>
        <th>Memo</th>
      </tr>
      </thead>'."\n";
      for ($i=0;$i<$db->num_rows();$i++) {
          $r = $db->fetch_assoc();
          $db1 = new DB;
          $db1->query("SELECT `bed`,`indate` FROM `inpatientinfo` a INNER JOIN `patient` b ON a.patientID = b.patientID WHERE a.`patientID`='".$r['patientID']."' AND b.`type`='5' ORDER BY a.`patientID` DESC LIMIT 0,1");
		  for ($j=0;$j<$db1->num_rows();$j++) {
              $r1 = $db1->fetch_assoc();
              if (@$_GET['query']==1 && $_GET['type']==1) {
                  if (count($arrAreaBed)==0) {
                      if (@$_GET['query']!=NULL) {
                          echo '<script>alert("No Information");</script>'."\n";
                          break 2;
                      }
                  }
              }
              $db2a = new DB;
              $db2a->query("SELECT `Area` FROM `bedinfo` WHERE `bedID`='".$r1['bed']."'");
              $r2a = $db2a->fetch_assoc();
              $db2b = new DB;
              $db2b->query("SELECT `areaName` FROM `areainfo` WHERE `areaID`='".$r2a['Area']."'");
              $r2b = $db2b->fetch_assoc();
              $db2c = new DB;
              $db2c->query("SELECT `patientID`,`HospNo`,`HospNoDisplay`,`Birth`,`instat` FROM `patient` WHERE `patientID`='".$r['patientID']."' AND `type`='5'");
              $r2c = $db2c->fetch_assoc();
              if (count($arrAreaBed)==0 || in_array($r1['bed'],$arrAreaBed)) {
				  if(in_array($r2b['areaName'],$User_Shift_Area) || $_SESSION['ncareLevel_lwj']==5 || $_SESSION['GroupLeader_lwj']==1 || $_SESSION['ncareID_lwj']==getPrimary_Duty_Nurse($r2b['areaName'])){//排班權限
				  echo '<div name="PatientPic_'.$r['patientID'].'" id="PatientPic_'.$r['patientID'].'" style="display:none; z-index:999; position:fixed;">'.getPatientPic($r2c['HospNo']).'</div>';
				  echo '
                  <tr';
                  if ($_SESSION['ncareOrgStatus_lwj']==2) {
                      if ($r2c['instat']==0) { echo ' style="display:none;"'; }
                  }
                  echo '>
                    <td class="link1">
                      <center>
                      <a href="index.php?mod=nurseform&func=formview&pid='.$r['patientID'].'&query='.@$_GET['query'].'" title="Edit" onmouseover="showPatientPic('.$r['patientID'].');" onmouseout="hiddenPatientPic('.$r['patientID'].');"><i class="fa fa-magic fa-lg"></i></a>
                      </center>
                    </td>
                    <td>'.$r2b['areaName'].'</td>
                    <td>'.$r1['bed'].'</td>
                    <td align="left">';
					  $db5 = new DB;
					  $db5->query("SELECT `round` FROM `nurserounds` WHERE `HospNo`='".$r2c['HospNo']."' AND `date`='".date(Ymd)."' AND `Qfiller`='".$_SESSION['ncareID_lwj']."'");
					  if($db5->num_rows()>0){
						  echo '<button id="CheckRound_OFF_'.$r['patientID'].'"><i id="CheckRound_OFF_'.$r['patientID'].'_icon" class="fa fa-check-square-o"></i></button>';
					  }else{
						  echo '<button id="CheckRound_ON_'.$r['patientID'].'"><i id="CheckRound_ON_'.$r['patientID'].'_icon" class="fa fa-square-o"></i></button>';
					  }
					  echo ' '.getPatientName($r2c['patientID']).'
					</td>
                    <td>'.$r2c['HospNoDisplay'].'</td>
                    <td align="center">'.(checkgender($r['patientID'])=="Male"?'<span style="color:CornflowerBlue;"><i class="fa fa-2x fa-male"></i></span>':(checkgender($r['patientID'])=="Female"?'<span style="color:pink;"><i class="fa fa-2x fa-female"></i></span>':'---')).'</td>  
                    <td>'.calcage($r2c['Birth']).'</td>
                    <td>'.formatdate($r1['indate']).'</td>
                    <td class="link1"><center>
					  <a onclick="changeinfo(\''.$r2c['HospNo'].'\')" title="Modify Care ID # or resident type"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-pencil fa-stack-1x fa-inverse"></i></span></a>
                      <a onclick="closecase(\''.$r2c['HospNo'].'\')" title="Discharge resident"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-user-times fa-stack-1x fa-inverse"></i></span></a>
                      <a onclick="changebed(\''.$r2c['HospNo'].'\')" title="Move bed"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-arrows fa-stack-1x fa-inverse"></i></span></a>
					  <a onclick="switchbed(\''.$r2c['HospNo'].'\')" title="Swap bed"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-retweet fa-stack-1x fa-inverse"></i></span></a>
                      <a href="index.php?mod=nurseform&func=formview&pid='.$r['patientID'].'&id=30_1" title="Resident absent record"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-exchange fa-stack-1x fa-inverse"></i></span></a>
					  <a href="index.php?func=NurseRounds&pid='.$r['patientID'].'" title="Rounds"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-eye fa-stack-1x fa-inverse"></i></span></a>
                    </center>
                    </td>
					<td class="link1">
                      <center>
                      <a href="index.php?mod=consump&func=formview&id=3&pid='.$r['patientID'].'&query='.@$_GET['query'].'" title="Apply for item"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-shopping-cart fa-stack-1x fa-inverse"></i></span></a>
                      <a href="index.php?func=editmonthlyfee&pid='.$r['patientID'].'" title="Input charging"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-dollar fa-stack-1x fa-inverse"></i></span></a>
                      </center>
                    </td>
                    <td><center>';
                  $memotxt = "";
                  $db3 = new DB;
                  $db3->query("SELECT `Qmemo_1`, `Qmemo_2` FROM `nurseform01` WHERE `HospNo`='".$r2c['HospNo']."' ORDER BY `date` DESC LIMIT 0,1");
                  $r3 = $db3->fetch_assoc();
                  if ($r3['Qmemo_1']==1) { $memotxt = '<a title="DNR">D</a>'; }
                  if ($r3['Qmemo_2']==1) { if ($memotxt!="") { $memotxt .= '、'; } $memotxt .= ' <a title="No hospitalization">N</a>'; }
                  echo $memotxt;
                  echo '</center></td></tr>'."\n";
				  }//排班權限
              }
          }
      }
      ?>
  </table>
  </div>
  <div id="typeTab-4">
  <table id="closecasetable" class="hover">
      <thead>
      <tr class="title">
        <th>Func.</th>
        <th>Name</th>
        <th>No.</th>
        <th>Gender</th> 
        <th>Check-in date</th>
        <th>Check-out date</th>
        <th width="400">Reason</th>
        <th>Re-admission</th>
      </tr>
      </thead>
      <?php
      $sql1 = "SELECT * FROM `closedcase` ORDER BY `feeclear` ASC, `outdate` DESC";
      $db = new DB;
      $db->query($sql1);
      for ($i=0;$i<$db->num_rows();$i++) {
          $r = $db->fetch_assoc();
		  $HospNo = getHospNo($r['patientID']);
		  echo '<div name="PatientPic_'.$r['patientID'].'" id="PatientPic_'.$r['patientID'].'" style="display:none; z-index:999; position:fixed;">'.getPatientPic($HospNo).'</div>';
          echo '
  <tr'.($_SESSION['ncareOrgStatus_lwj']==2 && $r2c['instat']==0?' style="display:none;"':"").'>
    <td class="link1">
	  <center>
	  <a href="index.php?mod=nurseform&func=formview&pid='.$r['patientID'].'&query='.@$_GET['query'].'" title="Edit" onmouseover="showPatientPic('.$r['patientID'].');" onmouseout="hiddenPatientPic('.$r['patientID'].');"><i class="fa fa-magic fa-lg"></i></a>
	  </center>
	</td>
    <td>'.getPatientName($r['patientID']).'</td>
    <td>'.getHospNoDisplayByPID($r['patientID']).'</td>
    <td align="center">'.(checkgender($r['patientID'])=="Male"?'<span style="color:CornflowerBlue;"><i class="fa fa-2x fa-male"></i></span>':(checkgender($r['patientID'])=="Female"?'<span style="color:pink;"><i class="fa fa-2x fa-female"></i></span>':'---')).'</td>  
    <td>'.formatdate($r['indate']).'</td>
    <td>'.formatdate($r['outdate']).'</td>
    <td>'.option_result("Qreason", "Return/visit home;Hospitalization;Referrals to other facility/center;Death;Other", 's', 'single', $r['reason'], false, 1).($r['memo']!=""?": ".$r['memo']:"").'</td>
    <td class="link1">';
	$db4 = new DB;
	$db4->query("SELECT `patientID` FROM `inpatientinfo` WHERE `patientID`='".$r['patientID']."'");
	if ($db4->num_rows()==0) {
		echo '<a onclick="reopen(\''.$HospNo.'\')" title="Re-admission"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-arrow-left fa-stack-1x fa-inverse"></i></span></a>';
	}
	echo '</td>
  </tr>'."\n";
      
      }
      ?>
      </table>
  </div>
</div>
<p>&nbsp;</p>
<script>
$('#typeTab').tabs(<?php if (@$_GET['type']!="") { echo '{active: '.(@$_GET['type']-1).'}'; } ?>);
</script>
<!--結案作業-->
<script>
$(function() {
    $( "#closecaseform" ).dialog({
		autoOpen: false,
		height: 350,
		width: 700,
		modal: true,
		buttons: {
			"Discharge procedure": function() {
				$.ajax({
					url: "class/closecase.php",
					type: "POST",
					data: {"HospNo": $(this).data('patientID'), "Qclosedate": $("#Qclosedate").val(), "Qclosetype": $("#Qclosetype").val(), "Qreason": $("#Qreason").val(), "Qmemo": $("#Qmemo").val()},
					success: function(data) {
						$( "#closecaseform" ).dialog( "close" );
						alert("已經完成結案");
						window.location.reload();
					}
				});
			},
			"Cancel": function() {
				$( "#closecaseform" ).dialog( "close" );
			}
		}
	});
});
</script>
<div id="closecaseform" title="Discharge procedure" class="dialog-form"> 
  <form>
  <fieldset>
      <table>
        <tr>
          <td class="title">Discharged date</td>
          <td><script> $(function() { $( "#Qclosedate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="Qclosedate" id="Qclosedate" value="<?php echo date(Y."/".m."/".d); ?>" size="12"></td>
        </tr>
  	  <tr>
  	    <td class="title">Type of discharge</td>
  		<td>
            <select id="Qclosetype" name="Qclosetype">
     	        <option></option>
  	        <option value="1">Planned</option>
  	        <option value="2">Unplanned</option>
  	      </select>
  	    </td>
  	  </tr>
        <tr>
          <td class="title">Discharge Status</td>
          <td>
            <select id="Qreason" name="Qreason">
     	   <option></option>
  	   <option value="1">Community (private home/apt., board/care, assisted living, group home)</option>
  	   <option value="2">Another nursing home or swing bed</option>
  	   <option value="3">Acute hospital</option>
  	   <option value="4">Psychiatric hospital</option>
  	   <option value="5">Inpatient rehabilitation facility</option>
  	   <option value="6">ID/DD facility</option>
  	   <option value="7">Hospice</option>
  	   <option value="8">Deceased</option>
  	   <option value="9">Long Term Care Hospital (LTCH)</option>
  	   <option value="99">Other</option>
  	 </select></td>
        </tr>
        <tr>
          <td class="title">Memo/Explanation:</td>
          <td><input type="text" name="Qmemo" id="Qmemo" size="40"></td>
        </tr>
      </table>
  </fieldset>
  </form>
</div>

<!--移床作業-->
<script>
$(function() {
    $( "#changebedform" ).dialog({
		autoOpen: false,
		height: 250,
		width: 310,
		modal: true,
		buttons: {
			"Confirm relocate bed": function() {
				//if (checkBed($('#NewBed').val())) {
					$.ajax({
						url: "class/changebedform.php",
						type: "POST",
						data: {"HospNo": $(this).data('patientID'), "NewBed": $('#bed').val(), "BedArea": $('#BedArea').val() },
						success: function(data) {
							$( "#changebedform" ).dialog( "close" );
							alert("已經完成移床");
							window.location.reload();
						}
					});
				//}
			},
			"Cancel": function() {
				$( "#changebedform" ).dialog( "close" );
			}
		}
	});
});
<!--重入住作業-->
$(function() {
    $( "#reopenform" ).dialog({
		autoOpen: false,
		height: 300,
		width: 400,
		modal: true,
		buttons: {
			"Confirm readmission": function() {
				//if (checkBed($('#NewBed').val())) {
					$.ajax({
						url: "class/reopenform.php",
						type: "POST",
						data: {"HospNo": $(this).data('patientID'), "Reindate": $('#reindate').val(), "NewBed": $('#reopen_NewBed').val(), "BedArea": $('#reopen_BedArea').val() },
						success: function(data) {
							//alert(data);
							$( "#changebedform" ).dialog( "close" );
							alert("Readmission process completed");
							window.location.reload();
						}
					});
				//}
			},
			"Cancel": function() {
				$( "#reopenform" ).dialog( "close" );
			}
		}
	});
});
function checkBed(bedID) {
	var result1;
	$.ajax({
		url: 'class/checkBed.php',
		type: "POST",
		async: false,
		data: { bedID: $('#NewBed').val() }
	}).done(function(result){
		if (result!='OK') {
			alert('不可使用此床位號碼，請重新輸入！');
			result1 = false;
		} else {
			//alert('床位號碼可用！');
			result1 = true;
		}
	});
	return result1;
}
function closecase(patientid) {
	$( "#closecaseform" ).data('patientID',patientid).dialog( "open" );
}
function changebed(patientid) {
	$( "#changebedform" ).data('patientID',patientid).dialog( "open" );
}
function switchbed(patientid) {
	$( "#switchbedform" ).data('patientID',patientid).dialog( "open" );
}
function changeinfo(patientid) {
	$.ajax({
		url: "class/patinfo3.php",
		type: "POST",
		data: {"PID": patientid},
		success: function(data) {
			//alert(data);
			var arr = data.split(';');
			$('#cQHospNoDisplay').val(arr[0]);
			$('#cQtype').val(arr[1]);
			for (var i=1;i<=5;i++) {
				if (i==1) {
					$('#btn_cQtype_'+i).removeClass().addClass('tabbtn_l_left_off');
				} else if (i==5) {
					$('#btn_cQtype_'+i).removeClass().addClass("tabbtn_l_right_off");
				} else {
					$('#btn_cQtype_'+i).removeClass().addClass("tabbtn_l_middle_off");
				}
				$('#cQtype_'+i).val('0');
			}
			var cName = "tabbtn_l_middle_on";
			if (arr[1]==1) {
				cName = "tabbtn_l_left_on";
			} else if (arr[1]==5) {
				cName = "tabbtn_l_right_on";
			}
			$('#btn_cQtype_'+arr[1]).removeClass().addClass(cName);
			$('#cQtype_'+arr[1]).val('1');
		}
	});
	$( "#changeinfoform" ).data('patientID',patientid).dialog( "open" );
}
function reopen(patientid) {
	$( "#reopenform" ).data('patientID',patientid).dialog( "open" );
}
</script>
<div id="changebedform" title="Bed relocation" class="dialog-form">
    <form>
    <fieldset>
    <?php
    $db = new DB;
    $db->query("SELECT `bed` FROM `inpatientinfo` WHERE `patientID`='' OR `patientID`='0'");
    ?>
      <table>
        <tr>
          <td class="title">Select section/room</td>
          <td>
          <select id="BedArea">
            <option></option>
            <?php
  		  $db_area = new DB;
  		  $db_area->query("SELECT * FROM `areainfo` ORDER BY `areaID` ASC");
  		  for ($i=0;$i<$db_area->num_rows();$i++) {
  			  $r_area = $db_area->fetch_assoc();
  			  echo '<option value="'.$r_area['areaID'].'">'.$r_area['areaName'].'</option>'."\n";
  		  }
  		  ?>
          </select>
          </td>
        </tr>
        <tr>
          <td class="title"><?php if ($db->num_rows()>0) { echo 'Select an empty bed';	 } else { echo 'Input new bed #'; } ?></td>
          <td>
            <select name="bed" id="bed">
            <option></option>
            </select>
          </td>
        </tr>
      </table>
    </fieldset>
    </form>
</div>
<script>
$('#BedArea').change(function () {
	$.ajax({
		url: "class/checkEmptyBed.php",
		type: "POST",
		data: { "Area": $("#BedArea").val()},
		success: function(data) {
			if (data=="nobed") {
				$("#bed option").remove();
				$("#bed").append($("<option></option>").attr("value", "").text("No empty bed"));
				$("#bed").attr("disabled",true);
			} else {
				var arr = data.split(';');
				$("#bed").attr("disabled",false);
				$("#bed option").remove();
				$("#bed").append($("<option></option>"));
				for (var i=0; i<arr.length; i++) {
					$("#bed").append($("<option></option>").attr("value", arr[i]).text(arr[i]));
				}
			}
		}
	});
});
</script>

<!--重入住作業-->
<div id="reopenform" title="Readmission process" class="dialog-form"> 
  <form>
  <fieldset>
  <?php
  $db = new DB;
  $db->query("SELECT `bed` FROM `inpatientinfo` WHERE `patientID`='' OR `patientID`='0'");
  ?>
    <table>
      <tr>
        <td class="title">Select Readmission date</td>
        <td><script> $(function() { $( "#reindate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="reindate" id="reindate" value="<?php echo date("Y/m/d"); ?>" size="12" ></td>
      </tr>
      <tr>
        <td class="title">Select section/room</td>
        <td>
        <select id="reopen_BedArea">
          <option></option>
          <?php
		  $db_area = new DB;
		  $db_area->query("SELECT * FROM `areainfo` ORDER BY `areaID` ASC");
		  for ($i=0;$i<$db_area->num_rows();$i++) {
			  $r_area = $db_area->fetch_assoc();
			  echo '<option value="'.$r_area['areaID'].'">'.$r_area['areaName'].'</option>'."\n";
		  }
		  ?>
        </select>
        </td>
      </tr>
      <tr>
        <td class="title"><?php if ($db->num_rows()>0) { echo 'Select an empty bed';	 } else { echo 'Input bed #'; } ?></td>
        <td><select id="reopen_NewBed"><option></option></select></td>
      </tr>
    </table>
  </fieldset>
  </form>
</div>
<script>
$(function() {
	$('table[id^=patlist]').dataTable({
		"order": [[1, "asc"], [2, "asc"]],
		"paging": false,
		"ordering": true,
		"drawCallback": function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;
 
            api.column(1, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="group"><td colspan="11" style="line-height:24px; background:#efefef;"><i class="fa fa-compass fa-lg"></i> '+group+'</td></tr>'
                    );
 
                    last = group;
                }
            } );
        }
	});
	$('#closecasetable').dataTable({
		"order": [[4, "desc"]],
		"paging": false
	});
});
$('#reopen_BedArea').change(function () {
	$.ajax({
		url: "class/checkEmptyBed.php",
		type: "POST",
		data: { "Area": $("#reopen_BedArea").val()},
		success: function(data) {
			if (data=="nobed") {
				$("#reopen_NewBed option").remove();
				$("#reopen_NewBed").append($("<option></option>").attr("value", "").text("No empty bed"));
				$("#reopen_NewBed").attr("disabled",true);
			} else {
				var arr = data.split(';');
				$("#reopen_NewBed").attr("disabled",false);
				$("#reopen_NewBed option").remove();
				$("#reopen_NewBed").append($("<option></option>"));
				for (var i=0; i<arr.length; i++) {
					$("#reopen_NewBed").append($("<option></option>").attr("value", arr[i]).text(arr[i]));
				}
			}
		}
	});
});
</script>

<!--修改護字號及住民類型作業-->
<script>
$(function() {
    $( "#changeinfoform" ).dialog({
		autoOpen: false,
		height: 290,
		width: 700,
		modal: true,
		buttons: {
			"Information Modification": function() {
				$.ajax({
					url: "class/changepInfo.php",
					type: "POST",
					data: {"PID": $(this).data('patientID'), "HospNoDisplay": $("#cQHospNoDisplay").val(), "type1": $("#cQtype_1").val(), "type2": $("#cQtype_2").val(), "type3": $("#cQtype_3").val(), "type4": $("#cQtype_4").val(), "type5": $("#cQtype_5").val(), "Qfiller": '<?php echo $_SESSION['ncareID_lwj']; ?>'},
					success: function(data) {
						if (data=="EXISTED") {
							alert("Care ID# already exists, please choose another number!");
							$('#cQHospNoDisplay').val('');
						} else if (data=="OK") {
							$( "#changeinfoform" ).dialog( "close" );
							alert("Modify success!");
							window.location.reload();
						}
					}
				});
			},
			"Cancel": function() {
				$( "#changeinfoform" ).dialog( "close" );
			}
		}
	});
});
</script>
<div id="changeinfoform" title="Modify Resident Profile Information" class="dialog-form"> 
  <form>
  <fieldset>
      <table cellpadding="7">
        <tr>
          <td class="title">Care ID#</td><!-- New Care ID# -->
          <td><input type="text" name="cQHospNoDisplay" id="cQHospNoDisplay" value="" size="12" readonly></td>
        </tr>
        <tr>
          <td class="title">Resident Type</td>
          <td><?php echo draw_option("cQtype","General admission;Swing bed;Respite care;Public funded care;Urgent care","l","single",NULL,true,3); ?></td>
        </tr>
      </table>
  </fieldset>
  </form>
</div>

<!--Swap bed-->
<script>
$(function() {
    $( "#switchbedform" ).dialog({
		autoOpen: false,
		height: 250,
		width: 550,
		modal: true,
		buttons: {
			"Confirm Swapping": function() {
				//if (checkBed($('#NewBed').val())) {
					$.ajax({
						url: "class/switchbedform.php",
						type: "POST",
						data: {"HospNo": $(this).data('patientID'), "NewBed": $('#BedSwitch').val(), "BedArea": $('#BedAreaSwitch').val() },
						success: function(data) {
							//alert(data);
							if (data=="OK") {
								$( "#switchbedform" ).dialog( "close" );
								alert("Bed swap completed");
								window.location.reload();
							}
						}
					});
				//}
			},
			"Cancel": function() {
				$( "#switchbedform" ).dialog( "close" );
			}
		}
	});
});
</script>
<div id="switchbedform" title="Swap Bed Procedure" class="dialog-form">
    <form>
    <fieldset>
    <?php
    $db = new DB;
    $db->query("SELECT `bed` FROM `inpatientinfo` WHERE `patientID`!='' AND `patientID`!='0'");
    ?>
      <table cellpadding="7">
        <tr>
          <td class="title">Select Section/Room</td>
          <td>
          <select id="BedAreaSwitch">
            <option></option>
            <?php
  		  $db_area = new DB;
  		  $db_area->query("SELECT * FROM `areainfo` ORDER BY `areaID` ASC");
  		  for ($i=0;$i<$db_area->num_rows();$i++) {
  			  $r_area = $db_area->fetch_assoc();
  			  echo '<option value="'.$r_area['areaID'].'">'.$r_area['areaName'].'</option>'."\n";
  		  }
  		  ?>
          </select>
          </td>
        </tr>
        <tr>
          <td class="title"><?php if ($db->num_rows()>0) { echo 'Select The Bed To Switch With';	 } ?></td>
          <td>
            <select name="BedSwitch" id="BedSwitch">
            <option></option>
            </select>
          </td>
        </tr>
      </table>
    </fieldset>
    </form>
</div>
<script>
$('#BedAreaSwitch').change(function () {
	$.ajax({
		url: "class/checkOccupiedBed.php",
		type: "POST",
		data: { "Area": $("#BedAreaSwitch").val()},
		success: function(data) {
			if (data=="nobed") {
				$("#BedSwitch option").remove();
				$("#BedSwitch").append($("<option></option>").attr("value", "").text("No empty bed"));
				$("#BedSwitch").attr("disabled",true);
			} else {
				var arr = data.split(';');
				$("#BedSwitch").attr("disabled",false);
				$("#BedSwitch option").remove();
				$("#BedSwitch").append($("<option></option>"));
				for (var i=0; i<arr.length; i++) {
					var arr1 = arr[i].split(':'); //arr1[0] = BedID; arr1[1] = display option text
					$("#BedSwitch").append($("<option></option>").attr("value", arr1[0]).text(arr1[1]));
				}
			}
		}
	});
});
</script>
<script type="text/javascript" src="js/LWJ_CheckRound.js"></script>
<?php }?>