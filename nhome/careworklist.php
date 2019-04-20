<?php
if(substr($_SESSION['ncareID_lwj'],0,8)=="resident"){
$HospNo = substr($_SESSION['ncareID_lwj'],8,6);
$db = new DB;
$db->query("SELECT `patientID` FROM `patient` WHERE `HospNo`='".mysql_escape_string($HospNo)."'");
$r = $db->fetch_assoc();
$url = "index.php?mod=carework&func=formview&pid=".$r['patientID'];
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
      <div class="patlistbtn"><a href="index.php?mod=nutrition&func=formview&id=23" title="Change of Body Weight"><i class="fa fa-line-chart fa-2x fa-fw"></i><br>Change of Weight</a></div>
      <div class="patlistbtn"><a href="index.php?mod=nutrition&func=formview&id=24" title="Statistics of Body Weight"><i class="fa fa-tasks fa-2x fa-fw"></i><br>Statistics of Weight</a></div>
      <div class="patlistbtn"><a href="index.php?mod=socialwork&func=formview&id=8" title="Group Activity"><i class="fa fa-users fa-2x fa-fw"></i><br>Group Activity</a></div>
      <!--<div class="patlistbtn"><a href="index.php?mod=carework&func=formview&id=8" title="雜物統計"><i class="fa fa-cube fa-2x fa-fw"></i><br>雜物統計</a></div>
      <div class="patlistbtn"><a href="index.php?mod=mealadmin&func=happymeal" title="快樂餐統計"><i class="fa fa-cutlery fa-2x fa-fw"></i><br>快樂餐</a></div>-->
      <div class="patlistbtn"><a href="index.php?func=reminderlist2&date1=<?php echo date(Ymd); ?>&date2=<?php echo str_replace("/","",calcdayafterday(date(Ymd),30)); ?>" title="Special reminder"><i class="fa fa-bell-o fa-2x fa-fw"></i><br>Special reminder</a></div>
      <div class="patlistbtn"><a href="index.php?mod=dailywork&func=formview&id=6" title="Meeting Records"><i class="fa fa-users fa-2x fa-fw"></i><br>Meeting Records</a></div>
      <div class="patlistbtn"><a href="index.php?mod=carework&func=formview&id=1" title="Cleaning"><i class="fa fa-tree fa-2x fa-fw"></i><br>Cleaning</a></div>
      <div class="patlistbtn"><a href="index.php?mod=carework&func=formview&id=4" title="Bug Elimination"><i class="fa fa-bug fa-2x fa-fw"></i><br>Bug Elimination</a></div>
      <div class="patlistbtn"><a href="index.php?mod=carework&func=formview&id=3" title="Service and maintainance"><i class="fa fa-wrench fa-2x fa-fw"></i><br>Service &amp; Maintain</a></div>
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
    <li><a href="#typeTab-1">General</a></li>
    <li><a href="#typeTab-2">Temporary</a></li>
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
        <th>Check-in date</th>
        <th>Apply for item</th>
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
              $db2d = new DB;
              $db2d->query("SELECT * FROM `socialform04` WHERE `HospNo`='".$r2c['HospNo']."' ORDER BY `date` DESC LIMIT 0,1");
              $r2d = $db2d->fetch_assoc();
              if (count($arrAreaBed)==0 || in_array($r1['bed'],$arrAreaBed)) {
				  echo '<div name="PatientPic_'.$r['patientID'].'" id="PatientPic_'.$r['patientID'].'" style="display:none; z-index:999; position:fixed;">'.getPatientPic($r2c['HospNo']).'</div>';
				  echo '
                  <tr';
                  if ($_SESSION['ncareOrgStatus_lwj']==2) {
                      if ($r2c['instat']==0) { echo ' style="display:none;"'; }
                  }
                  echo '>
                    <td class="link1">
                      <center>
                      <a href="index.php?mod=carework&func=formview&pid='.$r['patientID'].'&query='.@$_GET['query'].'" title="Edit" onmouseover="showPatientPic('.$r['patientID'].');" onmouseout="hiddenPatientPic('.$r['patientID'].');"><i class="fa fa-magic fa-lg"></i></a>
                      </center>
                    </td>
                    <td>'.$r2b['areaName'].'</td>
                    <td>'.$r1['bed'].'</td>
                    <td>'.getPatientName($r2c['patientID']).'</td>
                    <td>'.$r2c['HospNoDisplay'].'</td>
                    <td align="center">'.(checkgender($r['patientID'])=="Male"?'<span style="color:CornflowerBlue;"><i class="fa fa-2x fa-male"></i></span>':(checkgender($r['patientID'])=="Female"?'<span style="color:pink;"><i class="fa fa-2x fa-female"></i></span>':'---')).'</td>  
                    <td>'.calcage($r2c['Birth']).'</td>
                    <td>'.formatdate($r1['indate']).'</td>
                    <td class="link1" align="center"><a href="index.php?mod=consump&func=formview&id=3&pid='.$r['patientID'].'&query='.@$_GET['query'].'" title="Apply for item"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-shopping-cart fa-stack-1x fa-inverse"></i></span></a></td></tr>'."\n";
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
        <th>Apply for item</th>
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
              $db2d = new DB;
              $db2d->query("SELECT * FROM `socialform04` WHERE `HospNo`='".$r2c['HospNo']."' ORDER BY `date` DESC LIMIT 0,1");
              $r2d = $db2d->fetch_assoc();
              if (count($arrAreaBed)==0 || in_array($r1['bed'],$arrAreaBed)) {
				  echo '<div name="PatientPic_'.$r['patientID'].'" id="PatientPic_'.$r['patientID'].'" style="display:none; z-index:999; position:fixed;">'.getPatientPic($r2c['HospNo']).'</div>';
                  echo '
                  <tr';
                  if ($_SESSION['ncareOrgStatus_lwj']==2) {
                      if ($r2c['instat']==0) { echo ' style="display:none;"'; }
                  }
                  echo '>
                    <td class="link1">
                      <center>
                      <a href="index.php?mod=carework&func=formview&pid='.$r['patientID'].'&query='.@$_GET['query'].'" title="Edit" onmouseover="showPatientPic('.$r['patientID'].');" onmouseout="hiddenPatientPic('.$r['patientID'].');"><i class="fa fa-magic fa-lg"></i></a>
                      </center>
                    </td>
                    <td>'.$r2b['areaName'].'</td>
                    <td>'.$r1['bed'].'</td>
                    <td>'.getPatientName($r2c['patientID']).'</td>
                    <td>'.$r2c['HospNoDisplay'].'</td>
                    <td align="center">'.(checkgender($r['patientID'])=="Male"?'<span style="color:CornflowerBlue;"><i class="fa fa-2x fa-male"></i></span>':(checkgender($r['patientID'])=="Female"?'<span style="color:pink;"><i class="fa fa-2x fa-female"></i></span>':'---')).'</td>  
                    <td>'.calcage($r2c['Birth']).'</td>
                    <td>'.formatdate($r1['indate']).'</td>
                    <td class="link1" align="center"><a href="index.php?mod=consump&func=formview&id=3&pid='.$r['patientID'].'&query='.@$_GET['query'].'" title="Apply for item"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-shopping-cart fa-stack-1x fa-inverse"></i></span></a></td></tr>'."\n";
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
        <th>Apply for item</th>
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
              $db2d = new DB;
              $db2d->query("SELECT * FROM `socialform04` WHERE `HospNo`='".$r2c['HospNo']."' ORDER BY `date` DESC LIMIT 0,1");
              $r2d = $db2d->fetch_assoc();
              if (count($arrAreaBed)==0 || in_array($r1['bed'],$arrAreaBed)) {
				  echo '<div name="PatientPic_'.$r['patientID'].'" id="PatientPic_'.$r['patientID'].'" style="display:none; z-index:999; position:fixed;">'.getPatientPic($r2c['HospNo']).'</div>';
                  echo '
                  <tr';
                  if ($_SESSION['ncareOrgStatus_lwj']==2) {
                      if ($r2c['instat']==0) { echo ' style="display:none;"'; }
                  }
                  echo '>
                    <td class="link1">
                      <center>
                      <a href="index.php?mod=carework&func=formview&pid='.$r['patientID'].'&query='.@$_GET['query'].'" title="Edit" onmouseover="showPatientPic('.$r['patientID'].');" onmouseout="hiddenPatientPic('.$r['patientID'].');"><i class="fa fa-magic fa-lg"></i></a>
                      </center>
                    </td>
                    <td>'.$r2b['areaName'].'</td>
                    <td>'.$r1['bed'].'</td>
                    <td>'.getPatientName($r2c['patientID']).'</td>
                    <td>'.$r2c['HospNoDisplay'].'</td>
                    <td align="center">'.(checkgender($r['patientID'])=="Male"?'<span style="color:CornflowerBlue;"><i class="fa fa-2x fa-male"></i></span>':(checkgender($r['patientID'])=="Female"?'<span style="color:pink;"><i class="fa fa-2x fa-female"></i></span>':'---')).'</td>  
                    <td>'.calcage($r2c['Birth']).'</td>
                    <td>'.formatdate($r1['indate']).'</td>
                    <td class="link1" align="center"><a href="index.php?mod=consump&func=formview&id=3&pid='.$r['patientID'].'&query='.@$_GET['query'].'" title="Apply for item"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-shopping-cart fa-stack-1x fa-inverse"></i></span></a></td></tr>'."\n";
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
        <th>Apply for item</th>
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
              $db2d = new DB;
              $db2d->query("SELECT * FROM `socialform04` WHERE `HospNo`='".$r2c['HospNo']."' ORDER BY `date` DESC LIMIT 0,1");
              $r2d = $db2d->fetch_assoc();
              if (count($arrAreaBed)==0 || in_array($r1['bed'],$arrAreaBed)) {
				  echo '<div name="PatientPic_'.$r['patientID'].'" id="PatientPic_'.$r['patientID'].'" style="display:none; z-index:999; position:fixed;">'.getPatientPic($r2c['HospNo']).'</div>';
                  echo '
                  <tr';
                  if ($_SESSION['ncareOrgStatus_lwj']==2) {
                      if ($r2c['instat']==0) { echo ' style="display:none;"'; }
                  }
                  echo '>
                    <td class="link1">
                      <center>
                      <a href="index.php?mod=carework&func=formview&pid='.$r['patientID'].'&query='.@$_GET['query'].'" title="Edit" onmouseover="showPatientPic('.$r['patientID'].');" onmouseout="hiddenPatientPic('.$r['patientID'].');"><i class="fa fa-magic fa-lg"></i></a>
                      </center>
                    </td>
                    <td>'.$r2b['areaName'].'</td>
                    <td>'.$r1['bed'].'</td>
                    <td>'.getPatientName($r2c['patientID']).'</td>
                    <td>'.$r2c['HospNoDisplay'].'</td>
                    <td align="center">'.(checkgender($r['patientID'])=="Male"?'<span style="color:CornflowerBlue;"><i class="fa fa-2x fa-male"></i></span>':(checkgender($r['patientID'])=="Female"?'<span style="color:pink;"><i class="fa fa-2x fa-female"></i></span>':'---')).'</td>  
                    <td>'.calcage($r2c['Birth']).'</td>
                    <td>'.formatdate($r1['indate']).'</td>
                    <td class="link1" align="center"><a href="index.php?mod=consump&func=formview&id=3&pid='.$r['patientID'].'&query='.@$_GET['query'].'" title="Apply for item"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-shopping-cart fa-stack-1x fa-inverse"></i></span></a></td></tr>'."\n";
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
        <th>Apply for item</th>
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
              $db2d = new DB;
              $db2d->query("SELECT * FROM `socialform04` WHERE `HospNo`='".$r2c['HospNo']."' ORDER BY `date` DESC LIMIT 0,1");
              $r2d = $db2d->fetch_assoc();
              if (count($arrAreaBed)==0 || in_array($r1['bed'],$arrAreaBed)) {
				  echo '<div name="PatientPic_'.$r['patientID'].'" id="PatientPic_'.$r['patientID'].'" style="display:none; z-index:999; position:fixed;">'.getPatientPic($r2c['HospNo']).'</div>';
                  echo '
                  <tr';
                  if ($_SESSION['ncareOrgStatus_lwj']==2) {
                      if ($r2c['instat']==0) { echo ' style="display:none;"'; }
                  }
                  echo '>
                    <td class="link1">
                      <center>
                      <a href="index.php?mod=carework&func=formview&pid='.$r['patientID'].'&query='.@$_GET['query'].'" title="Edit" onmouseover="showPatientPic('.$r['patientID'].');" onmouseout="hiddenPatientPic('.$r['patientID'].');"><i class="fa fa-magic fa-lg"></i></a>
                      </center>
                    </td>
                    <td>'.$r2b['areaName'].'</td>
                    <td>'.$r1['bed'].'</td>
                    <td>'.getPatientName($r2c['patientID']).'</td>
                    <td>'.$r2c['HospNoDisplay'].'</td>
                    <td align="center">'.(checkgender($r['patientID'])=="Male"?'<span style="color:CornflowerBlue;"><i class="fa fa-2x fa-male"></i></span>':(checkgender($r['patientID'])=="Female"?'<span style="color:pink;"><i class="fa fa-2x fa-female"></i></span>':'---')).'</td>  
                    <td>'.calcage($r2c['Birth']).'</td>
                    <td>'.formatdate($r1['indate']).'</td>
                    <td class="link1" align="center"><a href="index.php?mod=consump&func=formview&id=3&pid='.$r['patientID'].'&query='.@$_GET['query'].'" title="Apply for item"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-shopping-cart fa-stack-1x fa-inverse"></i></span></a></td></tr>'."\n";
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
      </tr>
      </thead>
      <?php
      $sql1 = "SELECT * FROM `closedcase` ORDER BY `feeclear` ASC, `outdate` DESC";
      $db = new DB;
      $db->query($sql1);
      for ($i=0;$i<$db->num_rows();$i++) {
          $r = $db->fetch_assoc();
		  echo '<div name="PatientPic_'.$r['patientID'].'" id="PatientPic_'.$r['patientID'].'" style="display:none; z-index:999; position:fixed;">'.getPatientPic($r2c['HospNo']).'</div>';
          echo '
  <tr'.($_SESSION['ncareOrgStatus_lwj']==2 && $r2c['instat']==0?' style="display:none;"':"").'>
    <td class="link1">
	  <center>
	  <a href="index.php?mod=carework&func=formview&pid='.$r['patientID'].'&query='.@$_GET['query'].'" title="Edit" onmouseover="showPatientPic('.$r['patientID'].');" onmouseout="hiddenPatientPic('.$r['patientID'].');"><i class="fa fa-magic fa-lg"></i></a>
	  </center>
	</td>
    <td>'.getPatientName($r['patientID']).'</td>
    <td>'.getHospNoDisplayByPID($r['patientID']).'</td>
    <td align="center">'.(checkgender($r['patientID'])=="Male"?'<span style="color:CornflowerBlue;"><i class="fa fa-2x fa-male"></i></span>':(checkgender($r['patientID'])=="Female"?'<span style="color:pink;"><i class="fa fa-2x fa-female"></i></span>':'---')).'</td>  
    <td>'.formatdate($r['indate']).'</td>
    <td>'.formatdate($r['outdate']).'</td>
    <td>'.option_result("Qreason", "Return/visit home;Hospitalization;Referrals to other facility/center;Death;Other", 's', 'single', $r['reason'], false, 1).($r['memo']!=""?": ".$r['memo']:"").'</td>
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
                        '<tr class="group"><td colspan="10" style="line-height:24px; background:#efefef;"><i class="fa fa-compass fa-lg"></i> '+group+'</td></tr>'
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
</script>
<?php }?>