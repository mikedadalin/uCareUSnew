<?php
if(substr($_SESSION['ncareID_lwj'],0,8)=="resident"){
$HospNo = substr($_SESSION['ncareID_lwj'],8,6);
$db = new DB;
$db->query("SELECT `patientID` FROM `patient` WHERE `HospNo`='".mysql_escape_string($HospNo)."'");
$r = $db->fetch_assoc();
$url = "index.php?mod=socialwork&func=formview&pid=".$r['patientID'];
echo "<script type='text/javascript'>";
echo "window.location.href='".$url."'";
echo "</script>";
}else{
$db3 = new DB;
$db3->query("SELECT * FROM `nurseform02j` WHERE `Q21_1`='1'");
$db4 = new DB;
$db4->query("SELECT * FROM `nurseform31` WHERE `Q3_1`='1'");
$count=0;
?>
<script type="text/javascript" src="js/WYJ_slider.js"></script>
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
      <div class="patlistbtn"><a href="index.php?func=formremind&type=2" title="Form Reminder"><i class="fa fa-warning fa-2x fa-fw"></i><br>Form Reminder</a></div>
      <div class="patlistbtn"><a href="index.php?mod=socialwork&func=formview&id=8" title="Group Activity"><i class="fa fa-users fa-2x fa-fw"></i><br>Group Activity</a></div>
      <div class="patlistbtn">
        <a class="patlistlink" title="Notification"><i class="fa fa-files-o fa-2x fa-fw"></i><br>Nursing Notify</a>
        <?php
        if ($db3->num_rows()>0 || $db4->num_rows()>0) {
          echo '<div id="MedQList" class="patlistbtndetail">';
          for ($i3=0;$i3<$db3->num_rows();$i3++) {
            $r3 = $db3->fetch_assoc();
            $db3b = new DB;
            $db3b->query("SELECT * FROM `socialform20_2` WHERE `HospNo`='".$r3['HospNo']."' AND `Qreplyto`='".$r3['date']."'");
            if ($db3b->num_rows()==0) {
			$pid = getPID($r3['HospNo']);
            $count++;
            if ($i3>0) { echo '<br>'; }
            echo '<a href="index.php?mod=socialwork&func=formview&pid='.$pid.'&id=20" title="Notify">Pain Notify<br>'.getBedID($pid).'<br>'.getPatientName($pid).'</a><br>-----------';
            }
          }
        echo '</div>';
      }
      ?>
      <div class="listbtnalert"><?php echo $count; ?></div>
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
        <th>Check-in date</th>
        <th>Last date of case record</th>
        <th>Case Record</th>
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
                      <a href="index.php?mod=socialwork&func=formview&pid='.$r['patientID'].'&query='.@$_GET['query'].'" title="Edit" onmouseover="showPatientPic('.$r['patientID'].');" onmouseout="hiddenPatientPic('.$r['patientID'].');"><i class="fa fa-magic fa-lg"></i></a>
                      </center>
                    </td>
                    <td>'.$r2b['areaName'].'</td>
                    <td>'.$r1['bed'].'</td>
                    <td>'.getPatientName($r2c['patientID']).'</td>
                    <td>'.$r2c['HospNoDisplay'].'</td>
                    <td align="center">'.(checkgender($r['patientID'])=="Male"?'<span style="color:CornflowerBlue;"><i class="fa fa-2x fa-male"></i></span>':(checkgender($r['patientID'])=="Female"?'<span style="color:pink;"><i class="fa fa-2x fa-female"></i></span>':'---')).'</td>  
                    <td>'.calcage($r2c['Birth']).'</td>
                    <td>'.formatdate($r1['indate']).'</td>
                    <td align="left">'.formatdate($r2d['date']).' '.(substr($r2d['date'],0,6)<date(Ym)?'<i class="fa fa-warning fa-lg" style="color:#C00;"></i>':'<i class="fa fa-check fa-lg" style="color:#0C0;"></i>').'</td>
                    <td class="link1" align="center"><a href="index.php?mod=socialwork&func=formview&pid='.$r['patientID'].'&id=4"><i class="fa fa-2x fa-pencil-square"></i></a></td></tr>'."\n";
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
        <th>Last date of case record</th>
        <th>Case record</th>
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
                      <a href="index.php?mod=socialwork&func=formview&pid='.$r['patientID'].'&query='.@$_GET['query'].'" title="Edit" onmouseover="showPatientPic('.$r['patientID'].');" onmouseout="hiddenPatientPic('.$r['patientID'].');"><i class="fa fa-magic fa-lg"></i></a>
                      </center>
                    </td>
                    <td>'.$r2b['areaName'].'</td>
                    <td>'.$r1['bed'].'</td>
                    <td>'.getPatientName($r2c['patientID']).'</td>
                    <td>'.$r2c['HospNoDisplay'].'</td>
                    <td align="center">'.(checkgender($r['patientID'])=="Male"?'<span style="color:CornflowerBlue;"><i class="fa fa-2x fa-male"></i></span>':(checkgender($r['patientID'])=="Female"?'<span style="color:pink;"><i class="fa fa-2x fa-female"></i></span>':'---')).'</td>  
                    <td>'.calcage($r2c['Birth']).'</td>
                    <td>'.formatdate($r1['indate']).'</td>
                    <td align="left">'.formatdate($r2d['date']).' '.(substr($r2d['date'],0,6)<date(Ym)?'<i class="fa fa-warning fa-lg" style="color:#C00;"></i>':'<i class="fa fa-check fa-lg" style="color:#0C0;"></i>').'</td>
                    <td class="link1" align="center"><a href="index.php?mod=socialwork&func=formview&pid='.$r['patientID'].'&id=4"><i class="fa fa-2x fa-pencil-square"></i></a></td></tr>'."\n";
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
        <th>Last date of case record</th>
        <th>Case record</th>
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
                      <a href="index.php?mod=socialwork&func=formview&pid='.$r['patientID'].'&query='.@$_GET['query'].'" title="Edit" onmouseover="showPatientPic('.$r['patientID'].');" onmouseout="hiddenPatientPic('.$r['patientID'].');"><i class="fa fa-magic fa-lg"></i></a>
                      </center>
                    </td>
                    <td>'.$r2b['areaName'].'</td>
                    <td>'.$r1['bed'].'</td>
                    <td>'.getPatientName($r2c['patientID']).'</td>
                    <td>'.$r2c['HospNoDisplay'].'</td>
                    <td align="center">'.(checkgender($r['patientID'])=="Male"?'<span style="color:CornflowerBlue;"><i class="fa fa-2x fa-male"></i></span>':(checkgender($r['patientID'])=="Female"?'<span style="color:pink;"><i class="fa fa-2x fa-female"></i></span>':'---')).'</td>  
                    <td>'.calcage($r2c['Birth']).'</td>
                    <td>'.formatdate($r1['indate']).'</td>
                    <td align="left">'.formatdate($r2d['date']).' '.(substr($r2d['date'],0,6)<date(Ym)?'<i class="fa fa-warning fa-lg" style="color:#C00;"></i>':'<i class="fa fa-check fa-lg" style="color:#0C0;"></i>').'</td>
                    <td class="link1" align="center"><a href="index.php?mod=socialwork&func=formview&pid='.$r['patientID'].'&id=4"><i class="fa fa-2x fa-pencil-square"></i></a></td></tr>'."\n";
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
        <th>Last date of case record</th>
        <th>Case record</th>
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
                      <a href="index.php?mod=socialwork&func=formview&pid='.$r['patientID'].'&query='.@$_GET['query'].'" title="Edit" onmouseover="showPatientPic('.$r['patientID'].');" onmouseout="hiddenPatientPic('.$r['patientID'].');"><i class="fa fa-magic fa-lg"></i></a>
                      </center>
                    </td>
                    <td>'.$r2b['areaName'].'</td>
                    <td>'.$r1['bed'].'</td>
                    <td>'.getPatientName($r2c['patientID']).'</td>
                    <td>'.$r2c['HospNoDisplay'].'</td>
                    <td align="center">'.(checkgender($r['patientID'])=="Male"?'<span style="color:CornflowerBlue;"><i class="fa fa-2x fa-male"></i></span>':(checkgender($r['patientID'])=="Female"?'<span style="color:pink;"><i class="fa fa-2x fa-female"></i></span>':'---')).'</td>  
                    <td>'.calcage($r2c['Birth']).'</td>
                    <td>'.formatdate($r1['indate']).'</td>
                    <td align="left">'.formatdate($r2d['date']).' '.(substr($r2d['date'],0,6)<date(Ym)?'<i class="fa fa-warning fa-lg" style="color:#C00;"></i>':'<i class="fa fa-check fa-lg" style="color:#0C0;"></i>').'</td>
                    <td class="link1" align="center"><a href="index.php?mod=socialwork&func=formview&pid='.$r['patientID'].'&id=4"><i class="fa fa-2x fa-pencil-square"></i></a></td></tr>'."\n";
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
        <th>Last date of case record</th>
        <th>Case record</th>
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
                      <a href="index.php?mod=socialwork&func=formview&pid='.$r['patientID'].'&query='.@$_GET['query'].'" title="Edit" onmouseover="showPatientPic('.$r['patientID'].');" onmouseout="hiddenPatientPic('.$r['patientID'].');"><i class="fa fa-magic fa-lg"></i></a>
                      </center>
                    </td>
                    <td>'.$r2b['areaName'].'</td>
                    <td>'.$r1['bed'].'</td>
                    <td>'.getPatientName($r2c['patientID']).'</td>
                    <td>'.$r2c['HospNoDisplay'].'</td>
                    <td align="center">'.(checkgender($r['patientID'])=="Male"?'<span style="color:CornflowerBlue;"><i class="fa fa-2x fa-male"></i></span>':(checkgender($r['patientID'])=="Female"?'<span style="color:pink;"><i class="fa fa-2x fa-female"></i></span>':'---')).'</td>  
                    <td>'.calcage($r2c['Birth']).'</td>
                    <td>'.formatdate($r1['indate']).'</td>
                    <td align="left">'.formatdate($r2d['date']).' '.(substr($r2d['date'],0,6)<date(Ym)?'<i class="fa fa-warning fa-lg" style="color:#C00;"></i>':'<i class="fa fa-check fa-lg" style="color:#0C0;"></i>').'</td>
                    <td class="link1" align="center"><a href="index.php?mod=socialwork&func=formview&pid='.$r['patientID'].'&id=4"><i class="fa fa-2x fa-pencil-square"></i></a></td></tr>'."\n";
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
        <th>Date of check-out</th>
        <th width="400">Reason</th>
      </tr>
      </thead>
      <?php
      $sql1 = "SELECT * FROM `closedcase` ORDER BY `feeclear` ASC, `outdate` DESC";
      $db = new DB;
      $db->query($sql1);
      for ($i=0;$i<$db->num_rows();$i++) {
          $r = $db->fetch_assoc();
		  echo '<div name="PatientPic_'.$r['patientID'].'" id="PatientPic_'.$r['patientID'].'" style="display:none; z-index:999; position:fixed;">'.getPatientPic(getHospNo($r['patientID'])).'</div>';
          echo '
  <tr'.($_SESSION['ncareOrgStatus_lwj']==2 && $r2c['instat']==0?' style="display:none;"':"").'>
    <td class="link1">
	  <center>
	  <a href="index.php?mod=socialwork&func=formview&pid='.$r['patientID'].'&query='.@$_GET['query'].'" title="Edit" onmouseover="showPatientPic('.$r['patientID'].');" onmouseout="hiddenPatientPic('.$r['patientID'].');"><i class="fa fa-magic fa-lg"></i></a>
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

function actMedQList(action) {
	if (action=='open') {
		$('#MedQList').fadeIn();
	} else if (action=='close') {
		$('#MedQList').fadeOut();
	}
}
/*$("body").click(function(e) {
	if (e.target.className !== "patlistbtndetail") {
		$(".patlistbtndetail").fadeOut();
	}
});*/

$(function() {
  $(".patlistlink").click(function(){
      $("#MedQList").fadeToggle();
  });
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
</script>
<?php }?>