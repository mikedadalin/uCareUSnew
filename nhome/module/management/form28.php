<style>
#chart table { width: auto; }
#chart table tr { background:none; }
#chart_gender table { width: auto; }
#chart_gender table tr { background:none; }
#chart_age table { width: auto; }
#chart_age table tr { background:none; }
#chart_comingSource table { width: auto; }
#chart_comingSource table tr { background:none; }
#chart_disableLevel table { width: auto; }
#chart_disableLevel table tr { background:none; }
#chart_illnessCard table { width: auto; }
#chart_illnessCard table tr { background:none; }
#chart_Diag table { width: auto; }
#chart_Diag table tr { background:none; }
</style>
<script type="text/javascript" src="js/LWJ_tabs.js"></script>
<h3 style="margin-bottom:0px;">Basic statistics</h3>
<div class="patlistbtnlist" style="background-color:rgba(255,255,255,0);">
  <div class="patlistbtn" style="background-color:rgba(149,219,208,0.9);"><a href="print.php?mod=management&func=formview&id=28" title="Print report" target="_blank"><i class="fa fa-print fa-2x fa-fw"></i><br>Print report</a></div>
</div>
<?php
$countDNR=0;
$countDNR2=0;
$countNoDNR=0;
$countComingSource1 = 0;
$countComingSource2 = 0;
$countComingSource3 = 0;
$countComingSource4 = 0;
$countDisableLevel1 = 0;
$countDisableLevel2 = 0;
$countDisableLevel3 = 0;
$countDisableLevel4 = 0;
$countIllnessCard1 = 0;
$countIllnessCard2 = 0;
$arrAge = array();
$arrAgeData = array();
$arrDiag = array();
$db1 = new DB;
$db1->query("SELECT `patientID` FROM `inpatientinfo`");
for ($i1=0;$i1<$db1->num_rows();$i1++) {
	$r1 = $db1->fetch_assoc();
	$db1a = new DB;
	$db1a->query("SELECT * FROM `nurseform01` WHERE `HospNo`='".getHospNo($r1['patientID'])."' ORDER BY `date` DESC LIMIT 0,1");
	$r1a = $db1a->fetch_assoc();
	
	$db2a = new DB;
	$db2a->query("SELECT `Birth` FROM `patient` WHERE `patientID`='".$r1['patientID']."'");
	$r2a = $db2a->fetch_assoc();
	
	if ($r1a['Qmemo_1']==1) { $countDNR++; } //DNR
	if ($r1a['Qmemo_2']==1) { $countDNR2++; } //不送醫
	if ($r1a['Qmemo_3']==1) { $countNoDNR++; } //無DNR
	
	if (checkgender($r1['patientID'])=="Male") { $gender1++; } //Male
	if (checkgender($r1['patientID'])=="Female") { $gender2++; } //Female
	

	if ($r1a['Qcomingsource_1']==1) { $countComingSource1++; } //Hospital
	if ($r1a['Qcomingsource_2']==1) { $countComingSource2++; } //Long-term care facility
	if ($r1a['Qcomingsource_3']==1) { $countComingSource3++; } //Home
	if ($r1a['Qcomingsource_4']==1) { $countComingSource4++; } //Other
	
	if ($r1a['QdisableLevel']==1) { $countDisableLevel1++; } //身障 - Mild
	if ($r1a['QdisableLevel']==2) { $countDisableLevel2++; } //身障 - Moderate
	if ($r1a['QdisableLevel']==3) { $countDisableLevel3++; } //身障 - Severe
	if ($r1a['QdisableLevel']==4) { $countDisableLevel4++; } //身障 - Extremely severe
	
	if ($r1a['QillnessCard_1']==1) { $countIllnessCard1++; } //有重大傷病
	if ($r1a['QillnessCard_2']==1) { $countIllnessCard2++; } //無重大傷病
	
	//診斷別
	for ($i3=1;$i3<=8;$i3++) {
		$tmp = strtolower($r1a['Qdiag'.$i3]);
		if ($tmp!="") {
			$arrDiag[$tmp]++;
		}
	}
	
	//Admission category
	
	array_push($arrAge, calcagenum($r2a['Birth']));
}
arsort($arrDiag);
sort($arrAge);
$minAge = $arrAge[0];
$maxAge = $arrAge[(count($arrAge)-1)];
$ageGroup =  ceil(($maxAge-$minAge)%10);
$startAge = (floor($arrAge[0]/10))*10;
for ($i2=0;$i2<$ageGroup;$i2++) {
	$arrAgeData[$startAge + ($i2*10)] = 0;
}
foreach ($arrAge as $k1=>$v1) {
	$tmp_age = (floor($v1/10))*10;
	$arrAgeData[$tmp_age]++;
}
?>
<div id="tabs" style="width:100%;">
  <ul>
    <li><a href="#tabs-3">Age-specific</a></li>
    <li><a href="#tabs-2">Gender-specific</a></li>
    <li><a href="#tabs-1">DNR</a></li>
    <li><a href="#tabs-4">Source</a></li>
    <li><a href="#tabs-5">Disability</a></li>
    <li><a href="#tabs-6">Major injury</a></li>
    <li><a href="#tabs-7">Diagnosis-specific</a></li>
    <!--<li><a href="#tabs-8">Admission category</a></li>
    <li><a href="#tabs-9">語言別</a></li>
    <li><a href="#tabs-10">宗教別</a></li>
    <li><a href="#tabs-11">依賴程度別</a></li>
    <li><a href="#tabs-12">入住訊息來源</a></li>-->
  </ul>
  <div id="tabs-1" style="width:93.5%;">
    <h3>DNR</h3>
    <table style="width:100%;">
      <tr>
        <td class="title" width="120">DNR</td>
        <td style="padding:10px;"><?php echo $countDNR; ?> people</td>
        <td rowspan="3" style="background:#fff;"><center><div id="chart" style="width:480px;height:400px;"></div></center></td>
      </tr>
      <tr>
        <td class="title">No Hospital</td>
        <td style="padding:10px;"><?php echo $countDNR2; ?> people</td>
      </tr>
      <tr>
        <td class="title">No DNR</td>
        <td style="padding:10px;"><?php echo $countNoDNR; ?> people</td>
      </tr>
    </table>
    <script type="text/javascript">
    $(document).ready(function () {
      var data = [
      { label: "DNR",  data: <?php echo $countDNR; ?> },
      { label: "No hospital",  data: <?php echo $countDNR2; ?> },
      { label: "No DNR",  data: <?php echo $countNoDNR; ?> }
      ];
      $.plot('#chart', data, {
        series: {
          pie: {
            show: true,
            radius: 0.8
          }
        }
      });
    });
    </script>
  </div>
  <div id="tabs-2" style="width:94.3%;">
    <h3>Gender</h3>
    <table style="width:100%;">
      <tr>
        <td class="title" width="120">Male</td>
        <td width="200" style="padding-left:10px;"><?php echo $gender1; ?> people</td>
        <td rowspan="3" style="background:#fff;"><center><div id="chart_gender" style="width:480px;height:400px;"></div></center></td>
      </tr>
      <tr>
        <td class="title">Female</td>
        <td style="padding-left:10px;"><?php echo $gender2; ?> people</td>
      </tr>
      <tr>
        <td class="title">Totally </td>
        <td style="padding-left:10px;"><?php echo ($gender1+$gender2); ?> people</td>
      </tr>
    </table>
    <script type="text/javascript">
    $(document).ready(function () {
      var data = [
      { label: "Male",  data: <?php echo $gender1; ?> },
      { label: "Female",  data: <?php echo $gender2; ?> }
      ];
      $.plot('#chart_gender', data, {
        series: {
          pie: {
            show: true,
            radius: 0.8
          }
        }
      });
    });
    </script>
  </div>
  <div id="tabs-3" style="width:94.7%;">
    <h3>Age</h3>
    <table style="width:100%;">
      <?php
      $countAge = 0;
      foreach ($arrAgeData as $k1=>$v1) {
        if ($v1>0) {
          if ($countAge==0) {
           echo '
           <tr>
           <td class="title" width="120">'.$k1.' Years old -<br>'.($k1+10).' Years old</td>
           <td width="200" style="padding-left:10px;">'.$v1.' people</td>
           <td rowspan="'.count($arrAgeData).'" style="background:#fff;"><center><div id="chart_age" style="width:480px;height:400px;"></div></center></td>
           </tr>
           '."\n";
         } else {
           echo '
           <tr>
           <td class="title">'.$k1.' Years old -<br>'.($k1+10).' Years old</td>
           <td style="padding-left:10px;">'.$v1.' people</td>
           </tr>
           '."\n";
         }
       }
       $countAge++;
     }
     ?>
     <tr>
      <td class="title">Totally </td>
      <td><?php echo ($gender1+$gender2); ?> people</td>
    </tr>
  </table>
  <script type="text/javascript">
  $(document).ready(function () {
    var data = [
    <?php
    $countAge = 0;
    foreach ($arrAgeData as $k1=>$v1) {
      if ($v1>0) {
       echo '{ label: "'.$k1.'Years old-'.($k1+10).'Years old",  data: '.$v1.' }';
       if ($countAge!=count($arrAgeData)-1) { echo ','."\n"; }
       $countAge++;
     }
   }
   ?>
   ];
   $.plot('#chart_age', data, {
    series: {
      pie: {
        show: true,
        radius: 0.8
      }
    }
  });
 });
  </script>
</div>
<div id="tabs-4" style="width:94.6%;">
  <h3>Source</h3>
  <table style="width:100%;">
    <tr>
      <td class="title" width="120">Hospital</td>
      <td width="200" style="padding-left:10px;"><?php echo $countComingSource1; ?> people</td>
      <td rowspan="4" style="background:#fff;"><center><div id="chart_comingSource" style="width:480px;height:400px;"></div></center></td>
    </tr>
    <tr>
      <td class="title">Long-term Care Facility</td>
      <td style="padding-left:10px;"><?php echo $countComingSource2; ?> people</td>
    </tr>
    <tr>
      <td class="title">Home</td>
      <td style="padding-left:10px;"><?php echo $countComingSource3; ?> people</td>
    </tr>
    <tr>
      <td class="title">Other</td>
      <td style="padding-left:10px;"><?php echo $countComingSource4; ?> people</td>
    </tr>
  </table>
  <script type="text/javascript">
  $(document).ready(function () {
    var data = [
    { label: "Hospital",  data: <?php echo $countComingSource1; ?> },
    { label: "Long-term care facility",  data: <?php echo $countComingSource2; ?> },
    { label: "Home",  data: <?php echo $countComingSource3; ?> },
    { label: "Other",  data: <?php echo $countComingSource4; ?> }
    ];
    $.plot('#chart_comingSource', data, {
      series: {
        pie: {
          show: true,
          radius: 0.8
        }
      }
    });
  });
  </script>
</div>
<div id="tabs-5" style="width:94.3%;">
  <h3>Disability</h3>
  <table style="width:100%;">
    <tr>
      <td class="title" width="120">Mild</td>
      <td width="200" style="padding-left:10px;"><?php echo $countDisableLevel1; ?> people</td>
      <td rowspan="4" style="background:#fff;"><center><div id="chart_disableLevel" style="width:480px;height:400px;"></div></center></td>
    </tr>
    <tr>
      <td class="title">Moderate</td>
      <td style="padding-left:10px;"><?php echo $countDisableLevel2; ?> people</td>
    </tr>
    <tr>
      <td class="title">Severe</td>
      <td style="padding-left:10px;"><?php echo $countDisableLevel3; ?> people</td>
    </tr>
    <tr>
      <td class="title">Extremely Severe</td>
      <td style="padding-left:10px;"><?php echo $countDisableLevel4; ?> people</td>
    </tr>
  </table>
  <script type="text/javascript">
  $(document).ready(function () {
    var data = [
    { label: "Mild",  data: <?php echo $countDisableLevel1; ?> },
    { label: "Moderate",  data: <?php echo $countDisableLevel2; ?> },
    { label: "Severe",  data: <?php echo $countDisableLevel3; ?> },
    { label: "Extremely severe",  data: <?php echo $countDisableLevel4; ?> }
    ];
    $.plot('#chart_disableLevel', data, {
      series: {
        pie: {
          show: true,
          radius: 0.8
        }
      }
    });
  });
  </script>
</div>
<div id="tabs-6" style="width:94.3%;">
  <h3>Major injury</h3>
  <table style="width:100%;">
    <tr>
      <td class="title" width="120">Has</td>
      <td width="200" style="padding-left:10px;"><?php echo $countIllnessCard1; ?> people</td>
      <td rowspan="2" style="background:#fff;"><center><div id="chart_illnessCard" style="width:480px;height:400px;"></div></center></td>
    </tr>
    <tr>
      <td class="title">None</td>
      <td style="padding-left:10px;"><?php echo $countIllnessCard2; ?> people</td>
    </tr>
  </table>
  <script type="text/javascript">
  $(document).ready(function () {
    var data = [
    { label: "Yes",  data: <?php echo $countIllnessCard1; ?> },
    { label: "None",  data: <?php echo $countIllnessCard2; ?> }
    ];
    $.plot('#chart_illnessCard', data, {
      series: {
        pie: {
          show: true,
          radius: 0.8
        }
      }
    });
  });
  </script>
</div>
<div id="tabs-7" style="width:95.6%;">
  <h3>Diagnosis</h3>
  <table style="width:100%;">
    <?php
    $i3=0;
    foreach ($arrDiag as $k=>$v) {
      if ($i3==0) {
       ?>
       <tr>
        <td class="title" width="200" style="text-transform: capitalize;"><?php echo $k; ?></td>
        <td width="120" style="padding-left:10px;"><?php echo $v; ?> people</td>
        <td rowspan="<?php echo count($arrDiag); ?>" style="background:#fff;" valign="top">
          <center><div id="chart_Diag" style="width:480px;height:400px;"></div></center>
        </td>
      </tr>
      <?php
    } else {
     ?>
     <tr>
      <td class="title" style="text-transform: capitalize;"><?php echo $k; ?></td>
      <td style="padding-left:10px;"><?php echo $v; ?> people</td>
    </tr>
    <?php
  }
  $i3++;
}
?>
</table>
<script type="text/javascript">
$(document).ready(function () {
  var data = [
  <?php
  $i3=0;
  foreach ($arrDiag as $k=>$v) {
    if (count($arrDiag)>10) {
     if ($v>4) {
      echo '{ label: "'.$k.'",  data: '.$v.' }';
      if ($i3<(count($arrDiag)-1)) {
       echo ',';
     }
   }
 } else {
   echo '{ label: "'.$k.'",  data: '.$v.' }';
   if ($i3<(count($arrDiag)-1)) {
    echo ',';
  }
}
$i3++;
}
?>
];
$.plot('#chart_Diag', data, {
  series: {
    pie: {
      show: true,
      radius: 0.7
    }
  },
  legend: { show: false }
});
});
</script>
</div>
  <!--<div id="tabs-8" style="width:910px;">
    <h3>Admission category</h3>
    <table style="width:860px;">
      <tr>
        <td class="title" width="120">Has</td>
        <td width="200"><?php echo $countIllnessCard1; ?> people</td>
        <td rowspan="2" style="background:#fff;"><center><div id="chart_illnessCard" style="width:480px;height:400px;"></div></center></td>
      </tr>
      <tr>
        <td class="title">None</td>
        <td><?php echo $countIllnessCard2; ?> people</td>
      </tr>
    </table>
    <script type="text/javascript">
    $(document).ready(function () {
        var data = [
            { label: "Yes",  data: <?php echo $countIllnessCard1; ?> },
            { label: "None",  data: <?php echo $countIllnessCard2; ?> }
        ];
        $.plot('#chart_illnessCard', data, {
        series: {
            pie: {
                show: true,
                radius: 0.8
            }
        }
    });
    });
    </script>
  </div>
  <div id="tabs-9" style="width:910px;">
    <h3>Disability</h3>
    <table style="width:860px;">
      <tr>
        <td class="title" width="120">有</td>
        <td width="200"><?php echo $countIllnessCard1; ?> 人</td>
        <td class="title" width="120">Has</td>
        <td width="200"><?php echo $countIllnessCard1; ?> people</td>
        <td rowspan="2" style="background:#fff;"><center><div id="chart_illnessCard" style="width:480px;height:400px;"></div></center></td>
      </tr>
      <tr>

        <td class="title">None</td>
        <td><?php echo $countIllnessCard2; ?> people</td>
      </tr>
    </table>
    <script type="text/javascript">
    $(document).ready(function () {
        var data = [
            { label: "Yes",  data: <?php echo $countIllnessCard1; ?> },
            { label: "None",  data: <?php echo $countIllnessCard2; ?> }
        ];
        $.plot('#chart_illnessCard', data, {
        series: {
            pie: {
                show: true,
                radius: 0.8
            }
        }
    });
    });
    </script>
  </div>
  <div id="tabs-10" style="width:910px;">
    <h3>Disability</h3>
    <table style="width:860px;">
      <tr>
        <td class="title" width="120">Has</td>
        <td width="200"><?php echo $countIllnessCard1; ?> people</td>
        <td rowspan="2" style="background:#fff;"><center><div id="chart_illnessCard" style="width:480px;height:400px;"></div></center></td>
      </tr>
      <tr>
        <td class="title">None</td>
        <td><?php echo $countIllnessCard2; ?> people</td>
      </tr>
    </table>
    <script type="text/javascript">
    $(document).ready(function () {
        var data = [
            { label: "Yes",  data: <?php echo $countIllnessCard1; ?> },
            { label: "None",  data: <?php echo $countIllnessCard2; ?> }
        ];
        $.plot('#chart_illnessCard', data, {
        series: {
            pie: {
                show: true,
                radius: 0.8
            }
        }
    });
    });
    </script>
  </div>
  <div id="tabs-11" style="width:910px;">
    <h3>Disability</h3>
    <table style="width:860px;">
      <tr>
        <td class="title" width="120">Has</td>
        <td width="200"><?php echo $countIllnessCard1; ?> people</td>
        <td rowspan="2" style="background:#fff;"><center><div id="chart_illnessCard" style="width:480px;height:400px;"></div></center></td>
      </tr>
      <tr>
        <td class="title">None</td>
        <td><?php echo $countIllnessCard2; ?> people</td>
      </tr>
    </table>
    <script type="text/javascript">
    $(document).ready(function () {
        var data = [
            { label: "Yes",  data: <?php echo $countIllnessCard1; ?> },
            { label: "None",  data: <?php echo $countIllnessCard2; ?> }
        ];
        $.plot('#chart_illnessCard', data, {
        series: {
            pie: {
                show: true,
                radius: 0.8
            }
        }
    });
    });
    </script>
  </div>
  <div id="tabs-12" style="width:910px;">
    <h3>Disability</h3>
    <table style="width:860px;">
      <tr>
        <td class="title" width="120">Has</td>
        <td width="200"><?php echo $countIllnessCard1; ?> people</td>
        <td rowspan="2" style="background:#fff;"><center><div id="chart_illnessCard" style="width:480px;height:400px;"></div></center></td>
      </tr>
      <tr>
        <td class="title">None</td>
        <td><?php echo $countIllnessCard2; ?> people</td>
      </tr>
    </table>
    <script type="text/javascript">
    $(document).ready(function () {
        var data = [
            { label: "Yes",  data: <?php echo $countIllnessCard1; ?> },
            { label: "None",  data: <?php echo $countIllnessCard2; ?> }
        ];
        $.plot('#chart_illnessCard', data, {
        series: {
            pie: {
                show: true,
                radius: 0.8
            }
        }
    });
    });
    </script>
  </div>-->
</div>
