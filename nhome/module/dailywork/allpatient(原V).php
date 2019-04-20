<?php 
$date1 = ($_POST['date']=="" ? $_GET['date'] : $_POST['date']);
$date = "&date=".$date1;
?>
<script>
$(function() {
	$('#leftcol').hide();
	$('#tabs').tabs();
});
</script>
<div id="leftcol" style="background:rgba(0,0,0,0.6); filter: alpha(opacity=90); position:absolute; left: 11%; top: 19%; display:inline; z-index:99; width:20%; border:0px; padding:10px;" align="left">
  <div align="right"></div>
  <?php include("module/dailywork/leftcol.php"); ?>
</div>
<table width="100%" style="background-color: rgba(130,130,130,0.7); border-radius: 10px; padding:10px; margin-bottom: 10px; margin-top:10px;">
  <tr>
    <td width="32"><input type="image" src="Images/fieldset_userlist.png" onclick="$('#leftcol').show('slide', {direction: 'left'}, 500);"></td>
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
<div id="tabs" onclick="closecol();">
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
        $dbqdate = " DATE_FORMAT(`RecordedTime`,'%Y-%m-%d') = '".str_replace('/','-',$date1)."' ";
      }else{
        $dbqdate = " `RecordedTime` > '".str_replace('/','-',calcdayafterday(date('Y/m/d'),'-3'))."' ";
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
         $pat_txt .= "`PersonID`='".$v6."' OR ";
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
        $db2->query("SELECT GROUP_CONCAT(CONCAT(`PersonID`,'|',`LoincCode`,'|',`Value`,'|',DATE_FORMAT(`RecordedTime`,'%Y-%m-%d %H:%i:%s'),'|',`Qfiller`) SEPARATOR ';') AS `vData` FROM `vitalsigns` WHERE ".$dbqdate." AND ".$pat_txt." AND `IsValid`='1' GROUP BY `PersonID`, `RecordedTime` ORDER BY `RecordedTime` DESC");
        $arrVitalData = array();
        for ($i=0;$i<$db2->num_rows();$i++) {
          $r2 = $db2->fetch_assoc();
          $vData = explode(';',$r2['vData']);
          foreach ($vData as $k1=>$v1) {
            $v2 = explode('|',$v1);
                  //$v2[0] = PersonID
                  //$v2[1] = LoincCode
                  //$v2[2] = Value
                  //$v2[3] = RecordedTime
                  //$v2[4] = RecordedTime
            $arrVitalData[$v2[0]][$v2[3]][$v2[1]] = $v2[2];
            $arrVitalData[$v2[0]][$v2[3]]['Qfiller'] = $v2[4];
          }
              /*
              8310-5=>Temperature
              39106-0=>Axillary temperature
              8867-4=>Heartbeats
              8480-6=>Systolic BP
              8462-4=>Diastolic BP
              2710-2=>SpO2
              14743-9=>飯前血糖
              15075-5=>飯後血糖
              3141-9=>Body weight
              9279-1=>Respiration
              46033-7=>Pain scale
              18833-4=>Body weight
              */
            }
            foreach ($arrVitalData as $k3=>$v3) {
              foreach ($v3 as $k4=>$v4) {

                foreach ($arrVital3 as $k5=>$v5) {
                  if ($v4[$k5]!="" && $v4[$k5]<$arrRangeLow[$v5]) {
                    ${'t'.$v5} = ' class="rangeL"';
                  } elseif ($v4[$k5]!="" && $v4[$k5]>$arrRangeHigh[$v5]) {
                    ${'t'.$v5} = ' class="rangeH"';
                  } else {
                    ${'t'.$v5} = '';
                  }
					  //echo $v4[$k5].":".${'t'.$v5}."<br>";
                }



                echo '
                <tr align="left">
                <td>'.getBedID($k3).'</td>
                <td>'.getHospNoDisplayByPID($k3).'<br><a href="index.php?mod=dailywork&func=formview&pid='.$k3.'">'.getPatientName($k3).'</a></td>
                <td align="left" valign="top"><span '.$tvs83105.'>'.$v4['8310-5'].'</span></td>
                <td align="left" valign="top"><span '.$tvs88674.'>'.$v4['8867-4'].'</span></td>
                <td align="left" valign="top"><span '.$tvs92791.'>'.$v4['9279-1'].'</span></td>
                <td align="left" valign="top"><span '.$tvs84806.'>'.$v4['8480-6'].'</span>'.($v4['8462-4']!=""?' / <span '.$tvs84624.'>'.$v4['8462-4'].'</span>':"").'</td>
                <td align="left" valign="top"><span '.$tvs27102.'>'.$v4['2710-2'].'</span></td>
                <td align="left" valign="top"><span '.$tvs460337.'>'.$v4['46033-7'].'</span></td>
                <td align="left" valign="top"><span '.$tvs147439.'>'.$v4['14743-9'].'</span></td>
                <td align="left" valign="top"><span '.$tvs150755.'>'.$v4['15075-5'].'</span></td>
                <td align="left" valign="top"><span '.$tvs391060.'>'.$v4['39106-0'].'</span></td>';
                echo '
                <td align="left" valign="top"><span '.$tvs188334.'>'.$v4['18833-4'].'</span></td>
                <td align="left" valign="top">'.str_replace(" ","<br>",$k4).'</td>
                <td><a href="index.php?mod=dailywork&func=respedit&pid='.$k3.'&time='.$k4.'"><img src="Images/edit_icon.png" width="20" border="0"></a></td>
                </tr>';
              }
            }
            ?>
          </table>
        </div>
        <?php
      }
      ?>
    </div>