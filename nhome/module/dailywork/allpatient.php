<?php 
$date1 = ($_POST['date']=="" ? $_GET['date'] : $_POST['date']);
$date = "&date=".$date1;
?>
<script type="text/javascript" src="js/LWJ_tabs.js"></script>
<table width="100%" style="background-color: rgba(130,130,130,0.7); border-radius: 10px; padding:10px; margin-bottom: 10px; margin-top:10px;">
  <tr>
    <td width="32"><input type="image" src="Images/fieldset_userlist.png" onclick="$('#ResidentCol').show('slide', {direction: 'left'}, 500);"></td>
    <!--<td width="32"><center><img src="Images/allicon.png" /></center></td>-->
    <!--<td valign="middle" width="300"><h3><font color="#D80001">Overview</font></h3></td>-->
    <td align="right">
      <form action="index.php?mod=dailywork&func=formview" method="post">
        <a style="color:rgb(238,203,53); font-size:16px; font-weight:bold;">Date: </a><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php echo $date1; ?>" size="12" ><input type="submit" value="Search" onlick="goSelDate();"> <input type="button" value="Vitalsign Input" onclick="window.location.href='index.php?mod=dailywork&func=resplist2'"></form>
    <!--<form>
    <input type="button" value="Special reminder" onclick="window.location.href = 'index.php?func=reminderlist2&date1=<?php echo date(Ymd); ?>&date2=<?php echo str_replace("/","",calcdayafterday(date(Ymd),30)); ?>'" />
    <input type="button" value=" Care work meeting minute" onclick="window.location.href = 'index.php?mod=dailywork&func=formview&id=6'" />
    <input type="button" value="Apply for item" onclick="window.location.href = 'index.php?func=consumplist'" />
    <input type="button" value="快樂餐統計" onclick="window.location.href = 'index.php?mod=mealadmin&func=happymeal'" />
  </form>-->
</td>
</tr>
</table>
<div id="tabs" onclick="closecol2();">
  <ul>
    <?php
    $db1 = new DB;
    $db1->query("SELECT * FROM `areainfo` ORDER BY `areaName` ASC");
    for ($i1=0;$i1<$db1->num_rows();$i1++) {
      $r1 = $db1->fetch_assoc();
      $arrArea[$r1['areaID']] = $r1['areaName'];
      echo '<li><a href="#tabs-'.$r1['areaID'].'">'.$r1['areaName'].'</a></li>';
    }
    ?>
  </ul>
  <?php
  foreach ($arrArea as $k0=>$v0) {
    ?>
    <div id="tabs-<?php echo $k0; ?>">
      <?php

      if($date1 != ""){
        $dbqdate = " `date` = '".str_replace('/','',$date1)."' ";
      }else{
        $dbqdate = " `date` > '".str_replace('/','',calcdayafterday(date('Y/m/d'),'-3'))."' ";
      }

      $dbrange = new DB;
      $dbrange->query("SELECT * FROM `vitalsign_range`");
      for ($i1=0;$i1<$dbrange->num_rows();$i1++) {
        $rrange = $dbrange->fetch_assoc();
        $arrRangeLow[$rrange['itemID']] = $rrange['viewlow'];
        $arrRangeHigh[$rrange['itemID']] = $rrange['viewhigh'];
      }

      if ($_SESSION['ncareOrgStatus_lwj']==2) {
        $arrNotStat = array();
        $db3 = new DB;
        $db3->query("SELECT `patientID`, `instat` FROM `patient` WHERE `instat`='0';");
        for ($i3=0; $i3<$db3->num_rows(); $i3++) {
          $r3 = $db3->fetch_assoc();
          $arrNotStat[$i3] = $r3['patientID'];
        }
      }

      $arrPatient = explode(';',getAreaPatient($k0));
      $pat_txt = "(";
        foreach ($arrPatient as $k6=>$v6) {
         $pat_txt .= "`PatientID`='".$v6."' OR ";
       }
       $pat_txt = substr($pat_txt,0,strlen($pat_txt)-4).")";
       ?>
       <script>
       $(document).ready(function() {
        $('#table_<?php echo $k0; ?>').dataTable();
      });
       </script>
       <h3><?php echo $v0; ?></h3>
       <table id="table_<?php echo $k0; ?>" cellpadding="6px" width="100%" style="font-size:10pt;">
        <thead><tr bgcolor="#f7bbc3" style="color:#ffffff;" class="title">
          <td valign="top">Bed</td>
          <td valign="top">Name</td>
          <td valign="top">Temp.<br />(&ordm;F)</td>
          <td valign="top">Pulse<br />(/min)</td>
          <td valign="top">Resp.<br />(/min)</td>
          <td valign="top">Blood Pressure<br />(mmHg)</td>
          <td valign="top">SpO<sup>2</sup><br>(%)</td>
          <td valign="top">Pain<br />(Score)</td>
          <td valign="top">AC sugar<br />(mg/dL)</td>
          <td valign="top">PC sugar<br />(mg/dL)</td>
          <td valign="top">Temp.<br>(&ordm;F)</td>
          <td valign="top">Weight<br>(lbs)</td>
          <td valign="top">Time</td>
          <td valign="top">Edit</td>
        </tr></thead>
        <?php
        $db2 = new DB;
        $db2->query("SELECT * FROM `vitalsign` WHERE ".$dbqdate." AND ".$pat_txt." ORDER BY `date` DESC, `time` DESC");
        for ($i=0;$i<$db2->num_rows();$i++) {
          $r2 = $db2->fetch_assoc();
		  foreach ($r2 as $k2=>$v2) {
		      $arrVitalsign = explode("_",$k2);
			  if ($arrVitalsign[0]=="loinc") {
				  $vsLoincCode = "vs".$arrVitalsign[1].$arrVitalsign[2];
				  if ($v2!="" && $v2<$arrRangeLow[$vsLoincCode]) {
				      ${'t'.$vsLoincCode} = ' class="rangeL"';
				  } elseif ($v2!="" && $v2>$arrRangeHigh[$vsLoincCode]) {
				      ${'t'.$vsLoincCode} = ' class="rangeH"';
				  } else {
				      ${'t'.$vsLoincCode} = '';
				  }				  
			  }
		  }
          echo '
          <tr align="left">
          <td>'.getBedID($r2['PatientID']).'</td>
          <td>'.getHospNoDisplayByPID($r2['PatientID']).'<br><a href="index.php?mod=dailywork&func=formview&pid='.$r2['PatientID'].'">'.getPatientName($r2['PatientID']).'</a></td>
          <td align="left" valign="top"><span '.$tvs83105.'>'.$r2['loinc_8310_5'].'</span></td>
          <td align="left" valign="top"><span '.$tvs88674.'>'.$r2['loinc_8867_4'].'</span></td>
          <td align="left" valign="top"><span '.$tvs92791.'>'.$r2['loinc_9279_1'].'</span></td>
          <td align="left" valign="top"><span '.$tvs84806.'>'.$r2['loinc_8480_6'].'</span>'.($r2['loinc_8462_4']!=""?' / <span '.$tvs84624.'>'.$r2['loinc_8462_4'].'</span>':"").'</td>
          <td align="left" valign="top"><span '.$tvs27102.'>'.$r2['loinc_2710_2'].'</span></td>
          <td align="left" valign="top"><span '.$tvs460337.'>'.$r2['loinc_46033_7'].'</span></td>
          <td align="left" valign="top"><span '.$tvs147439.'>'.$r2['loinc_14743_9'].'</span></td>
          <td align="left" valign="top"><span '.$tvs150755.'>'.$r2['loinc_15075_5'].'</span></td>
          <td align="left" valign="top"><span '.$tvs391060.'>'.$r2['loinc_39106_0'].'</span></td>
          <td align="left" valign="top"><span '.$tvs188334.'>'.$r2['loinc_18833_4'].'</span></td>
          <td align="left" valign="top">'.date("Y-m-d",strtotime($r2['date'])).'<br>'.date("H:i",strtotime($r2['time'])).'</td>
          <td><a href="index.php?mod=dailywork&func=respedit&pid='.$r2['PatientID'].'&time='.date("Y-m-d",strtotime($r2['date'])).' '.date("H:i",strtotime($r2['time'])).'"><img src="Images/edit_icon.png" width="20" border="0"></a></td>
          </tr>';
        }
            ?>
          </table>
        </div>
        <?php
      }
      ?>
    </div>
<div id="ResidentCol" align="left">
<div align="center" style="background-color:#eecb35; border-radius:10px; padding:7px; margin-bottom:20px;"><font style="color:white; font-size:26px; font-weight:bold;">Resident List</font></div>
<?php include("ResidentCol.php"); ?>
</div>