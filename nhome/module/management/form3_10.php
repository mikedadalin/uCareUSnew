<style>
#chart_f_m table tr td { border:none; font-size:10pt; padding: 4px 0px; }
#chart_f_m table { width: auto; left:780px; position:relative; }
#chart_f_m table tr { background:none; height:auto; padding:0px; margin:0px; }
#chart_f_m_1 table tr td { border:none; font-size:10pt; padding: 4px 0px; }
#chart_f_m_1 table { width: auto; left:780px; position:relative; }
#chart_f_m_1 table tr { background:none; height:auto; padding:0px; margin:0px; }
#chart_f_m_2 table tr td { border:none; font-size:10pt; padding: 4px 0px; }
#chart_f_m_2 table { width: auto; left:780px; position:relative; }
#chart_f_m_2 table tr { background:none; height:auto; padding:0px; margin:0px; }
#chart_f_m_3 table tr td { border:none; font-size:10pt; padding: 4px 0px; }
#chart_f_m_3 table { width: auto; left:780px; position:relative; }
#chart_f_m_3 table tr { background:none; height:auto; padding:0px; margin:0px; }

#chart_f_1 table tr td { border:none; font-size:10pt; padding: 4px 0px; }
#chart_f_1 table { width: auto; left:780px; position:relative; }
#chart_f_1 table tr { background:none; height:auto; padding:0px; margin:0px; }
#chart_f_2 table tr td { border:none; font-size:10pt; padding: 4px 0px; }
#chart_f_2 table { width: auto; left:780px; position:relative; }
#chart_f_2 table tr { background:none; height:auto; padding:0px; margin:0px; }
#chart_f_3 table tr td { border:none; font-size:10pt; padding: 4px 0px; }
#chart_f_3 table { width: auto; left:780px; position:relative; }
#chart_f_3 table tr { background:none; height:auto; padding:0px; margin:0px; }
#chart_f_4 table tr td { border:none; font-size:10pt; padding: 4px 0px; }
#chart_f_4 table { width: auto; left:780px; position:relative; }
#chart_f_4 table tr { background:none; height:auto; padding:0px; margin:0px; }
#flotcontainer, #pie_month{
    width: 600px;
    height: 400px;
    text-align: left;
}

</style>
<?php 
if($_GET['part']==2){   /*$qdate 為搜尋之年月*/
  $report = substr($qdate,0,4); /*$report 為搜尋之年*/
  $content = ($report-1911)."Year"; /*換算民國年*/
}else{ 
  $report = substr($qdate,0,4).'/'.substr($qdate,4,2);
  $content = "(".$report.")";
}

?>

<!-- 計算各月人數= 先搜時間點以前在的人+時間點以前在的人可是時間點後走的人-->
<?php      
  $db1_all = new DB;
  $resdent_num = '';
  for($countX = 2; $countX <= 13; $countX++){
    if($countX <= 9){
      $db1_all->query("SELECT * FROM `patient` INNER JOIN `inpatientinfo` 
    ON patient.patientID = inpatientinfo.patientID WHERE `indate` < " .$qdateY."0".$countX."00");}
    else{
      $db1_all->query("SELECT * FROM `patient` INNER JOIN `inpatientinfo` 
    ON patient.patientID = inpatientinfo.patientID WHERE `indate` < " .$qdateY.$countX."00");}    
    if($qdateY == date(Y) && $countX-1 > date(m)){$month_num2[$countX-1] = 0;}
    else{$month_num2[$countX-1] = $db1_all->num_rows();}  
  }

  for($countX = 2; $countX <= 13; $countX++){
    if($countX <= 9){
      $db1_all->query("SELECT * FROM `patient` INNER JOIN `closedcase` 
    ON patient.patientID = closedcase.patientID WHERE `indate` < " .$qdateY."0".$countX."00 AND `outdate` > " .$qdateY."0".$countX."00");}
    else{
      $db1_all->query("SELECT * FROM `patient` INNER JOIN `closedcase` 
    ON patient.patientID = closedcase.patientID WHERE  `indate` < " .$qdateY.$countX."00 AND `outdate` > " .$qdateY.$countX."00");}             
    $month_num2[$countX-1] += $db1_all->num_rows();

  $second1970 = mktime(0,0,0,$countX-1,1,$qdateY);
  $second1970ms =  $second1970*1000; 
  $resdent_num .= '["'.$second1970ms.'",'.$month_num2[$countX-1].'],'; 

  }

?>

<!-- 當月摔倒長條圖 先求當月天數 三月有差值 加回個10000-->
<?php
  $db1_all = new DB;
  $fall_ddata_lv = 'fall_ddata_lv'; //fall data set, lv1 2 3

  $begin = mktime(0,0,0,$qdateM,1,$qdateY);
  $end = mktime(0,0,0,$qdateM+1,0,$qdateY);
  $diff = $end + 10000 - $begin;
  $days = ($diff /86400)+1;

  for($fall_level = 1; $fall_level <= 4; $fall_level++){
    $injurlv_ = 'injurlv_'.$fall_level;
    for($countX = 1; $countX <= $days; $countX++){
      if($countX <= 9){
        $db1_all->query("SELECT * FROM  `sixtarget_part3` INNER JOIN `patient` ON patient.HospNo = sixtarget_part3.HospNo WHERE `type` = 1 AND `".$injurlv_."` = 1 AND `date` LIKE '".$qdateY."/".$qdateM."/0".$countX."%'");}
      else{
        $db1_all->query("SELECT * FROM  `sixtarget_part3` INNER JOIN `patient` ON patient.HospNo = sixtarget_part3.HospNo WHERE `type` = 1 AND `".$injurlv_."` = 1 AND `date` LIKE '".$qdateY."/".$qdateM."/".$countX."%'");}
      $day_num[$countX] = $db1_all->num_rows();
    $second1970 = mktime(0,0,0,$qdateM,$countX,$qdateY);
    $second1970ms =  $second1970*1000; 
    ${$fall_ddata_lv.$fall_level} .= '["'.$second1970ms.'",'.$day_num[$countX].'],'; 
    }
  }  
?>


<!-- 月摔倒圓餅圖-->
<?php 
  $db1_all = new DB;
  $check_zero_month = 0;
  for($fall_loca_num = 1;$fall_loca_num <= 6; $fall_loca_num++){
      $fall_location = 'location_'.$fall_loca_num;
      for($fall_level = 1; $fall_level <= 4; $fall_level++){
            $injurlv_ = 'injurlv_'.$fall_level;
            $db1_all->query("SELECT * FROM  `sixtarget_part3` INNER JOIN `patient` ON patient.HospNo = sixtarget_part3.HospNo WHERE `type` = 1 AND `".$injurlv_."` = 1 AND `".$fall_location."` = 1 AND `date` LIKE '".$qdate2."%'");
            $fall_pie_data_month[($fall_loca_num-1)*4+$fall_level] = $db1_all->num_rows();   
            $check_zero_month += $db1_all->num_rows();
      }  
  }
  if($check_zero_month != 0){$check_zero_month = 0;} else{$check_zero_month = 1;}
?> 

<!-- 年度摔倒圓餅圖-->
<?php 
  $db1_all = new DB;
  $check_zero_year = 0;
  for($fall_loca_num = 1;$fall_loca_num <= 6; $fall_loca_num++){
      $fall_location = 'location_'.$fall_loca_num;
      for($fall_level = 1; $fall_level <= 4; $fall_level++){
          $injurlv_ = 'injurlv_'.$fall_level;
          $db1_all->query("SELECT * FROM  `sixtarget_part3` INNER JOIN `patient` ON patient.HospNo = sixtarget_part3.HospNo WHERE `type` = 1 AND `".$injurlv_."` = 1 AND `".$fall_location."` = 1 AND `date` LIKE '".$qdateY."%'");
          $fall_pie_data[($fall_loca_num-1)*4+$fall_level] = $db1_all->num_rows();    
          $check_zero_year += $db1_all->num_rows();
      }  
  }   
  if($check_zero_year != 0){$check_zero_year = 0;} else{$check_zero_year = 1;}
?>   


<h3>Fall Record&nbsp;<?php echo $content;?></h3>
  <div align="center" style="margin-bottom:10px;">
      <!--畫選項 當月.年度-->
     <?php echo draw_option("tab10option","Month statistic;3 months(seasonal) analysis;Annual analysis","xl","single",1,false,5); ?>
  </div>
  <div align="center">
    <!--逐案分析.列印 研究用暫停 -->  
  </div>

  <script>
  $('#btn_tab10option_1').click(function() {
    $('#tab10_part1').show();
    $('#tab10_part2').hide();
    $('#tab10_part3').hide();
  });
  $('#btn_tab10option_2').click(function() {
    $('#tab10_part1').hide();
    $('#tab10_part2').show();
    $('#tab10_part3').hide();
  });
  $('#btn_tab10option_3').click(function() {
    $('#tab10_part1').hide();
    $('#tab10_part2').hide();
    $('#tab10_part3').show();
  });
  // $(function() { $('#tform1').validationEngine(); });
  </script> 
  

<!--畫資料表 $sMonth為搜尋的月份-->
<form id="tab10_part1" action="index.php?mod=management&func=formview&id=3d_2&type=8<?php echo $sMonth; ?>" method="post">
      <table class="content-query" style="font-size:8pt; font-weight:normal;" width="100%" align="center">
              <tr class="title">
                <td align="center">Care ID#</td>
                <td align="center">ADL<br />Score</td>
                <td align="center">Date</td>
                <td align="center">Time</td>
                <td align="center">Location</td>
                <td align="center">Scenarios</td>
                <td align="center">Reason</td>
                <td align="center">Restraints</td>
                <td align="center">Medication</td>
                <td align="center">severity of injury</td>
                <td align="center">Body part(s)</td>
              </tr>
              <?php
              $dbp1_3 = new DB;
              $dbp1_3->query("SELECT * FROM  `sixtarget_part3` WHERE `date` LIKE '".$qdate2."%'");
              if ($dbp1_3->num_rows()==0) {
                ?>
                <tr>
                  <td colspan="19"><center>-------Yet no data of this month-------</center></td>
                </tr>
                <script>$(function() { $('#analysis3').hide(); });</script>
                <?php
              } else {
                for ($p1_i1=0;$p1_i1<$dbp1_3->num_rows();$p1_i1++) {
                  $rp1_3 =$dbp1_3->fetch_assoc();
                  /*== 解 START ==*/
                  $rsa = new lwj('lwj/lwj');
                  $puepart = explode(" ",$rp1_3['Name']);
                  $puepartcount = count($puepart);
                  if($puepartcount>1){
                    for($j=0;$j<$puepartcount;$j++){
                      $prdpart = $rsa->privDecrypt($puepart[$j]);
                      $rp1_3['Name'] = $rp1_3['Name'].$prdpart;
                    }
                  }else{
                    $rp1_3['Name'] = $rsa->privDecrypt($rp1_3['Name']);
                  }
                  /*== 解 END ==*/
                  $location = '';
                  if ($rp1_3['location_1']==1) { $location .= 'Room'; }
                  if ($rp1_3['location_2']==1) { if ($location!='') { $location.='、'; } $location .= 'Bedside'; }
                  if ($rp1_3['location_3']==1) { if ($location!='') { $location.='、'; } $location .= 'Bathroom'; }
                  if ($rp1_3['location_4']==1) { if ($location!='') { $location.='、'; } $location .= 'Activity area'; }
                  if ($rp1_3['location_5']==1) { if ($location!='') { $location.='、'; } $location .= 'Walkway'; }
                  if ($rp1_3['location_6']==1) { if ($location!='') { $location.='、'; } $location .= 'Other(s):'.$rp1_3['locationother']; }
                  $movement = '';
                  if ($rp1_3['movement_1']==1) { $movement .= 'Toileting'; }
                  if ($rp1_3['movement_2']==1) { if ($movement!='') { $movement.='、'; } $movement .= 'In/out bed'; }
                  if ($rp1_3['movement_3']==1) { if ($movement!='') { $movement.='、'; } $movement .= 'During activity'; }
                  if ($rp1_3['movement_4']==1) { if ($movement!='') { $movement.='、'; } $movement .= 'Slip(wheelchair)'; }
                  if ($rp1_3['movement_5']==1) { if ($movement!='') { $movement.='、'; } $movement .= 'Stand up(wheelchair)'; }
                  if ($rp1_3['movement_6']==1) { if ($movement!='') { $movement.='、'; } $movement .= 'Across(Bed rails)'; }
                  if ($rp1_3['movement_7']==1) { if ($movement!='') { $movement.='、'; } $movement .= 'Other(s):'.$rp1_3['movementother']; }
                  $reason = '';
                  if ($rp1_3['reason_1']==1) { $reason .= 'Resident\'s health'; }
                  if ($rp1_3['reason_2']==1) { if ($reason!='') { $reason.='、'; } $reason .= 'Treatment/medication'; }
                  if ($rp1_3['reason_3']==1) { if ($reason!='') { $reason.='、'; } $reason .= 'Environmental risk'; }
                  if ($rp1_3['reason_4']==1) { if ($reason!='') { $reason.='、'; } $reason .= 'Other(s):'.$rp1_3['reasonother']; }
                  $object = '';
                  if ($rp1_3['object_1']==1) { $object .= 'Bed rails(2)'; }
                  if ($rp1_3['object_2']==1) { if ($object!='') { $object.='、'; } $object .= 'Bed rail(1)'; }
                  if ($rp1_3['object_3']==1) { if ($object!='') { $object.='、'; } $object .= 'Waist restraint straps'; }
                  if ($rp1_3['object_4']==1) { if ($object!='') { $object.='、'; } $object .= 'Posey vest'; }
                  if ($rp1_3['object_5']==1) { if ($object!='') { $object.='、'; } $object .= 'No restraint'; }
                  $med = '';
                  if ($rp1_3['med_1']==1) { $med .= 'Antihistamine'; }
                  if ($rp1_3['med_2']==1) { if ($med!='') { $med.='、'; } $med .= 'Antihypertensive'; }
                  if ($rp1_3['med_3']==1) { if ($med!='') { $med.='、'; } $med .= 'Sedative-hypnotic'; }
                  if ($rp1_3['med_4']==1) { if ($med!='') { $med.='、'; } $med .= 'Muscle relaxants'; }
                  if ($rp1_3['med_5']==1) { if ($med!='') { $med.='、'; } $med .= 'Laxative'; }
                  if ($rp1_3['med_6']==1) { if ($med!='') { $med.='、'; } $med .= 'Diuretics'; }
                  if ($rp1_3['med_7']==1) { if ($med!='') { $med.='、'; } $med .= 'Antidepressant'; }
                  if ($rp1_3['med_8']==1) { if ($med!='') { $med.='、'; } $med .= 'Hypoglycemic'; }
                  $injurlv = '';
                  if ($rp1_3['injurlv_1']==1) { $injurlv .= 'None'; }
                  if ($rp1_3['injurlv_2']==1) { if ($injurlv!='') { $injurlv.='、'; } $injurlv .= 'Level1'; }
                  if ($rp1_3['injurlv_3']==1) { if ($injurlv!='') { $injurlv.='、'; } $injurlv .= 'Level2'; }
                  if ($rp1_3['injurlv_4']==1) { if ($injurlv!='') { $injurlv.='、'; } $injurlv .= 'Level3'; }
                  $bodypart = '';
                  if ($rp1_3['bodypart_1']==1) { $bodypart .= 'Waist'; }
                  if ($rp1_3['bodypart_2']==1) { if ($bodypart!='') { $bodypart.='、'; } $bodypart .= 'Ankle(s)'; }
                  if ($rp1_3['bodypart_3']==1) { if ($bodypart!='') { $bodypart.='、'; } $bodypart .= 'Wrist(s)'; }
                  if ($rp1_3['bodypart_4']==1) { if ($bodypart!='') { $bodypart.='、'; } $bodypart .= 'Knee(s)'; }
                  if ($rp1_3['bodypart_5']==1) { if ($bodypart!='') { $bodypart.='、'; } $bodypart .= 'Torso'; }
                  if ($rp1_3['bodypart_6']==1) { if ($bodypart!='') { $bodypart.='、'; } $bodypart .= 'Other(s):'.$rp1_3['bodypartother']; }
                  ?>
                  <tr>
                    <td align="center"><?php echo getHospNoDisplayByHospNo($rp1_3['HospNo']); ?></td>
                    <td align="center"><?php echo $rp1_3['ADLtotal']; ?></td>
                    <td align="center"><?php echo $rp1_3['date']; ?></td>
                    <td align="center"><?php echo substr($rp1_3['time'],0,2).":".substr($rp1_3['time'],2,2); ?></td>
                    <td align="center"><?php echo $location; ?></td>
                    <td align="center"><?php echo $movement; ?></td>
                    <td align="center"><?php echo $reason; ?></td>
                    <td align="center"><?php echo $object; ?></td>
                    <td align="center"><?php echo $med; ?></td>
                    <td align="center"><?php echo $injurlv; ?></td>
                    <td align="center"><?php echo $bodypart; ?></td>
                  </tr>
                  <?php
                }
              }
              ?>
      </table>
</form>

<!-- style="display:none;" 讓標籤2.3先行消失-->
<form id="tab10_part2" style="display:none;" action="index.php?mod=management&func=formview&id=3d_2&type=8<?php echo $sMonth; ?>" method="post">
    <!-- 月摔倒圖表, 月摔倒圓餅圖 -->
    <input  type="button" value="Show All" onClick="fun_show_m()">
    <input  type="button" value="Show Level 1" onClick="fun_show_m1()">
    <input  type="button" value="Show Level 2" onClick="fun_show_m2()">
    <input  type="button" value="Show Level 3" onClick="fun_show_m3()">    
    <div id="chart_f_m" style="width:740px;height:420px; margin-left:40px; margin-top:50px; margin-bottom:50px; padding-top:50px; padding-bottom:50px; page-break-after:always;"></div>
    <div id="chart_f_m_1" style="width:740px;height:420px; margin-left:40px; margin-top:50px; margin-bottom:50px; padding-top:50px; padding-bottom:50px; page-break-after:always;"></div>
    <div id="chart_f_m_2" style="width:740px;height:420px; margin-left:40px; margin-top:50px; margin-bottom:50px; padding-top:50px; padding-bottom:50px; page-break-after:always;"></div>
    <div id="chart_f_m_3" style="width:740px;height:420px; margin-left:40px; margin-top:50px; margin-bottom:50px; padding-top:50px; padding-bottom:50px; page-break-after:always;"></div>
    <div id="pie_month"></div> 
    <!-- <center><input type="submit" id="analysis8" value="Start case-by-case analysis" class="printcol"></center> -->
</form>

<form id="tab10_part3" style="display:none;" action="index.php?mod=management&func=formview&id=3d_2&type=8<?php echo $sMonth; ?>" method="post">

        <!--年度 各月長照跌倒人數 $qdateY為年 撈12個月資料庫後 再進表格 -->
        <?php
          $db1_all = new DB;
          $fall_data_lv = 'fall_data_lv'; //fall data set, lv1 2 3
          $fall_stat_lv = 'fall_stat_lv'; //fall %, lv1 2 3
          for($fall_level = 1; $fall_level <= 4; $fall_level++){
            $injurlv_ = 'injurlv_'.$fall_level;
            for($countX = 1; $countX <= 12; $countX++){
              if($countX <= 9){
                $db1_all->query("SELECT * FROM  `sixtarget_part3` INNER JOIN `patient` ON patient.HospNo = sixtarget_part3.HospNo WHERE `type` = 1 AND `".$injurlv_."` = 1 AND `date` LIKE '".$qdateY."/0".$countX."%'");}
              else{
                $db1_all->query("SELECT * FROM  `sixtarget_part3` INNER JOIN `patient` ON patient.HospNo = sixtarget_part3.HospNo WHERE `type` = 1 AND `".$injurlv_."` = 1 AND `date` LIKE '".$qdateY."/".$countX."%'");}
              $month_num[$countX] = $db1_all->num_rows();
              $second1970 = mktime(0,0,0,$countX,1,$qdateY);
              $second1970ms =  $second1970*1000; 
              ${$fall_data_lv.$fall_level} .= '["'.$second1970ms.'",'.$month_num[$countX].'],'; 
              if($month_num2[$countX] == 0){ ${$fall_stat_lv.$fall_level} .= '["'.$second1970ms.'",0],';}
              else{$conv_per = 100*$month_num[$countX]/$month_num2[$countX];
                ${$fall_stat_lv.$fall_level} .= '["'.$second1970ms.'",'.$conv_per.'],';}
            }
          } 
        ?>

      <!-- 圖表不知何故 放在form就一切正常 -->
      <h3><?php echo $arrDate[0]; ?> Annual severity of injury due to falling </h3>
      <input  type="button" value="Show All" onClick="fun_show()">
      <input  type="button" value="Show Level 1" onClick="fun_show1()">
      <input  type="button" value="Show Level 2" onClick="fun_show2()">
      <input  type="button" value="Show Level 3" onClick="fun_show3()">
      <div id="chart_f_1" style="width:740px;height:420px; margin-left:40px; margin-top:50px; margin-bottom:50px; padding-top:50px; padding-bottom:50px; page-break-after:always;"></div>
      <div id="chart_f_2" style="width:740px;height:420px; margin-left:40px; margin-top:50px; margin-bottom:50px; padding-top:50px; padding-bottom:50px; page-break-after:always;"></div>
      <div id="chart_f_3" style="width:740px;height:420px; margin-left:40px; margin-top:50px; margin-bottom:50px; padding-top:50px; padding-bottom:50px; page-break-after:always;"></div>
      <div id="chart_f_4" style="width:740px;height:420px; margin-left:40px; margin-top:50px; margin-bottom:50px; padding-top:50px; padding-bottom:50px; page-break-after:always;"></div>
      <div id="flotcontainer"></div>

      <script>

      function fun_show_m() {
        $('#chart_f_m').show();
        $('#chart_f_m_1').hide();
        $('#chart_f_m_2').hide();
        $('#chart_f_m_3').hide();
      }

      function fun_show_m1() {
        $('#chart_f_m').hide();
        $('#chart_f_m_1').show();
        $('#chart_f_m_2').hide();
        $('#chart_f_m_3').hide();
      }
      function fun_show_m2() {
        $('#chart_f_m').hide();
        $('#chart_f_m_1').hide();
        $('#chart_f_m_2').show();
        $('#chart_f_m_3').hide();
      }
      function fun_show_m3() {
        $('#chart_f_m').hide();
        $('#chart_f_m_1').hide();
        $('#chart_f_m_2').hide();
        $('#chart_f_m_3').show();
      }

      function fun_show() {
        $('#chart_f_1').show();
        $('#chart_f_2').hide();
        $('#chart_f_3').hide();
        $('#chart_f_4').hide();
      }      

      function fun_show1() {
        $('#chart_f_1').hide();
        $('#chart_f_2').show();
        $('#chart_f_3').hide();
        $('#chart_f_4').hide();
      }
      function fun_show2() {
        $('#chart_f_1').hide();
        $('#chart_f_2').hide();
        $('#chart_f_3').show();
        $('#chart_f_4').hide();
      }
      function fun_show3() {
        $('#chart_f_1').hide();
        $('#chart_f_2').hide();
        $('#chart_f_3').hide();
        $('#chart_f_4').show();
      }
      </script>

      <script type="text/javascript">

      $(function () {
          var f3_10pie_option = {
              series: {pie: {show: true}},
              legend: {show: false}
          };

          $.plot($("#pie_month"), [
          {label: "Room Lv1", data: <?php echo $fall_pie_data_month[2]; ?>},
          {label: "Room Lv2", data: <?php echo $fall_pie_data_month[3]; ?>},
          {label: "Room Lv3", data: <?php echo $fall_pie_data_month[4]; ?>},
          {label: "Bedside Lv1", data: <?php echo $fall_pie_data_month[6]; ?>},
          {label: "Bedside Lv2", data: <?php echo $fall_pie_data_month[7]; ?>},
          {label: "Bedside Lv3", data: <?php echo $fall_pie_data_month[8]; ?>},
          {label: "Bathroom Lv1", data: <?php echo $fall_pie_data_month[10]; ?>},
          {label: "Bathroom Lv2", data: <?php echo $fall_pie_data_month[11]; ?>},
          {label: "Bathroom Lv3", data: <?php echo $fall_pie_data_month[12]; ?>},
          {label: "Activity area Lv1", data: <?php echo $fall_pie_data_month[14]; ?>},
          {label: "Activity area Lv2", data: <?php echo $fall_pie_data_month[15]; ?>},
          {label: "Activity area Lv3", data: <?php echo $fall_pie_data_month[16]; ?>},
          {label: "Walkway Lv1", data: <?php echo $fall_pie_data_month[18]; ?>},
          {label: "Walkway Lv2", data: <?php echo $fall_pie_data_month[19]; ?>},
          {label: "Walkway Lv3", data: <?php echo $fall_pie_data_month[20]; ?>},
          {label: "Other(s) Lv1", data: <?php echo $fall_pie_data_month[22]; ?>},
          {label: "Other(s) Lv2", data: <?php echo $fall_pie_data_month[23]; ?>},
          {label: "Other(s) Lv2", data: <?php echo $fall_pie_data_month[24]; ?>},
          {label: "No fall record", data: <?php echo $check_zero_month; ?>}], f3_10pie_option); 


          $.plot($("#flotcontainer"), [
          {label: "Room Lv1", data: <?php echo $fall_pie_data[2]; ?>},
          {label: "Room Lv2", data: <?php echo $fall_pie_data[3]; ?>},
          {label: "Room Lv3", data: <?php echo $fall_pie_data[4]; ?>},
          {label: "Bedside Lv1", data: <?php echo $fall_pie_data[6]; ?>},
          {label: "Bedside Lv2", data: <?php echo $fall_pie_data[7]; ?>},
          {label: "Bedside Lv3", data: <?php echo $fall_pie_data[8]; ?>},
          {label: "Bathroom Lv1", data: <?php echo $fall_pie_data[10]; ?>},
          {label: "Bathroom Lv2", data: <?php echo $fall_pie_data[11]; ?>},
          {label: "Bathroom Lv3", data: <?php echo $fall_pie_data[12]; ?>},
          {label: "Activity area Lv1", data: <?php echo $fall_pie_data[14]; ?>},
          {label: "Activity area Lv2", data: <?php echo $fall_pie_data[15]; ?>},
          {label: "Activity area Lv3", data: <?php echo $fall_pie_data[16]; ?>},
          {label: "Walkway Lv1", data: <?php echo $fall_pie_data[18]; ?>},
          {label: "Walkway Lv2", data: <?php echo $fall_pie_data[19]; ?>},
          {label: "Walkway Lv3", data: <?php echo $fall_pie_data[20]; ?>},
          {label: "Other(s) Lv1", data: <?php echo $fall_pie_data[22]; ?>},
          {label: "Other(s) Lv2", data: <?php echo $fall_pie_data[23]; ?>},
          {label: "Other(s) Lv3", data: <?php echo $fall_pie_data[24]; ?>},
          {label: "No fall record", data: <?php echo $check_zero_year; ?>}], f3_10pie_option);  

            var f3_10chart_option = {
            xaxis: { mode: "time", timeformat: "%y<br>%b", monthNames: [<?php for ($imonth=1;$imonth<=12;$imonth++) { if ($imonth>1) { echo ', '; } echo "'".$imonth."'"; } ?>], tickLength: 0, axisLabelUseCanvas: true, axisLabelFontSizePixels: 12, axisLabelFontFamily: "Verdana, Arial, Helvetica, Tahoma, sans-serif", axisLabelPadding: 5 },
            yaxes: [
            {tickSize: 1, tickDecimals: 0, position: 'left'},
            {tickSize: 1, tickDecimals: 0, min:0, max:5, position: 'right'}
            ],
            grid: { hoverable: true, clickable: false, borderWidth: 1 },
            series: { shadowSize: 0, bars: { show: true, barWidth: 12*24*60*60*300, order: 1 } }
            };

            var f3_10_f_m_option = {
            xaxis: { mode: "time", timeformat: "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;%0d", tickLength: 0, axisLabelUseCanvas: true, axisLabelFontSizePixels: 12, axisLabelFontFamily: "Verdana, Arial, Helvetica, Tahoma, sans-serif", axisLabelPadding: 0 },
            yaxes: [
            {tickSize: 1, tickDecimals: 0, position: 'left'}
            ],
            grid: { hoverable: true, clickable: false, borderWidth: 1 },
            series: { shadowSize: 0, bars: { show: true, barWidth: 1*24*60*60*300, order: 1 } }
            };

          $.plot($("#chart_f_m"), [
            { label: "Level 1 fall injury C1",  data: [<?php echo $fall_ddata_lv2; ?>], bars: {barWidth: 5, fillColor: "#edc240"}, color: "#edc240" },
            { label: "Level 2 fall injury C2",  data: [<?php echo $fall_ddata_lv3; ?>], bars: {barWidth: 5, fillColor: "#afd8f8"}, color: "#afd8f8" },
            { label: "Level 3 fall injury C3",  data: [<?php echo $fall_ddata_lv4; ?>], bars: {barWidth: 5, fillColor: "#cb4b16"}, color: "#cb4b16" }
            ], f3_10_f_m_option);

          $.plot($("#chart_f_m_1"), [
            { label: "Level 1 fall injury C1",  data: [<?php echo $fall_ddata_lv2; ?>], bars: {fillColor: "#edc240"}, color: "#edc240" }
            ], f3_10_f_m_option);

          $.plot($("#chart_f_m_2"), [
            { label: "Level 2 fall injury C2",  data: [<?php echo $fall_ddata_lv3; ?>], bars: {fillColor: "#afd8f8"}, color: "#afd8f8" }
            ], f3_10_f_m_option);

          $.plot($("#chart_f_m_3"), [
            { label: "Level 3 fall injury C3",  data: [<?php echo $fall_ddata_lv4; ?>], bars: {fillColor: "#cb4b16"}, color: "#cb4b16" }
            ], f3_10_f_m_option);                                  

          $.plot($("#chart_f_1"), [
            { label: "Level 1 fall injury C1",  data: [<?php echo $fall_data_lv2; ?>], bars: {fillColor: "#edc240"}, color: "#edc240" },
            { label: "Level 2 fall injury C2",  data: [<?php echo $fall_data_lv3; ?>], bars: {fillColor: "#afd8f8"}, color: "#afd8f8" },
            { label: "Level 3 fall injury C3",  data: [<?php echo $fall_data_lv4; ?>], bars: {fillColor: "#cb4b16"}, color: "#cb4b16" },
            { label: "Level 1 fall injury C1/C",  data: [<?php echo $fall_stat_lv2; ?>], lines: {show: true}, points: { show: true, symbol:"triangle" }, bars: {show: false},  color: "#edc240", yaxis:2},
            { label: "Level 2 fall injury C1/C",  data: [<?php echo $fall_stat_lv3; ?>], lines: {show: true}, points: { show: true, symbol:"triangle" }, bars: {show: false},  color: "#afd8f8", yaxis:2},
            { label: "Level 3 fall injury C1/C",  data: [<?php echo $fall_stat_lv4; ?>], lines: {show: true}, points: { show: true, symbol:"triangle" }, bars: {show: false},  color: "#cb4b16", yaxis:2}
            ], f3_10chart_option);

          $.plot($("#chart_f_2"), [
            { label: "Level 1 fall injury C1",  data: [<?php echo $fall_data_lv2; ?>], bars: {fillColor: "#edc240"}, color: "#edc240" },
            { label: "Level 1 fall injury C1/C",  data: [<?php echo $fall_stat_lv2; ?>], lines: {show: true}, points: { show: true, symbol:"triangle" }, bars: {show: false},  color: "#edc240", yaxis:2}
            ], f3_10chart_option);

          $.plot($("#chart_f_3"), [
            { label: "Level 2 fall injury C2",  data: [<?php echo $fall_data_lv3; ?>], bars: {fillColor: "#afd8f8"}, color: "#afd8f8" },
            { label: "Level 2 fall injury C1/C",  data: [<?php echo $fall_stat_lv3; ?>], lines: {show: true}, points: { show: true, symbol:"triangle" }, bars: {show: false},  color: "#afd8f8", yaxis:2}
            ], f3_10chart_option);

          $.plot($("#chart_f_4"), [
            { label: "Level 3 fall injury C3",  data: [<?php echo $fall_data_lv4; ?>], bars: {fillColor: "#cb4b16"}, color: "#cb4b16" },
            { label: "Level 3 fall injury C1/C",  data: [<?php echo $fall_stat_lv4; ?>], lines: {show: true}, points: { show: true, symbol:"triangle" }, bars: {show: false},  color: "#cb4b16", yaxis:2}
            ], f3_10chart_option);

      var yaxisLabel = $("<div class='axisLabel yaxisLabel' style='position: absolute; left: -28px; top: -30px;'></div>").text("People").appendTo($('#chart_f_m'));
      var xaxisLabel = $("<div class='axisLabel xaxisLabel' style='position: absolute; left:400px; bottom: -50px;'></div>").text(" day").appendTo($('#chart_f_m'));
      var yaxisLabel = $("<div class='axisLabel yaxisLabel' style='position: absolute; left: -28px; top: -30px;'></div>").text("People").appendTo($('#chart_f_m_1'));
      var xaxisLabel = $("<div class='axisLabel xaxisLabel' style='position: absolute; left:400px; bottom: -50px;'></div>").text(" day").appendTo($('#chart_f_m_1'));
      var yaxisLabel = $("<div class='axisLabel yaxisLabel' style='position: absolute; left: -28px; top: -30px;'></div>").text("People").appendTo($('#chart_f_m_2'));
      var xaxisLabel = $("<div class='axisLabel xaxisLabel' style='position: absolute; left:400px; bottom: -50px;'></div>").text(" day").appendTo($('#chart_f_m_2'));
      var yaxisLabel = $("<div class='axisLabel yaxisLabel' style='position: absolute; left: -28px; top: -30px;'></div>").text("People").appendTo($('#chart_f_m_3'));
      var xaxisLabel = $("<div class='axisLabel xaxisLabel' style='position: absolute; left:400px; bottom: -50px;'></div>").text(" day").appendTo($('#chart_f_m_3'));

      var yaxisLabel = $("<div class='axisLabel yaxisLabel' style='position: absolute; left: -28px; top: -30px;'></div>").text("People").appendTo($('#chart_f_1'));
      var yaxisLabel2 = $("<div class='axisLabel yaxisLabel' style='width:50px; position: absolute; left: 740px; top: -30px;'></div>").text("Rate").appendTo($('#chart_f_1'));
      var xaxisLabel = $("<div class='axisLabel xaxisLabel' style='position: absolute; left:400px; bottom: -50px;'></div>").text(" month").appendTo($('#chart_f_1'));
      
      var yaxisLabel = $("<div class='axisLabel yaxisLabel' style='position: absolute; left: -28px; top: -30px;'></div>").text("People").appendTo($('#chart_f_2'));
      var yaxisLabel2 = $("<div class='axisLabel yaxisLabel' style='width:50px; position: absolute; left: 740px; top: -30px;'></div>").text("Rate").appendTo($('#chart_f_2'));
      var xaxisLabel = $("<div class='axisLabel xaxisLabel' style='position: absolute; left:400px; bottom: -50px;'></div>").text(" month").appendTo($('#chart_f_2'));

      var yaxisLabel = $("<div class='axisLabel yaxisLabel' style='position: absolute; left: -28px; top: -30px;'></div>").text("People").appendTo($('#chart_f_3'));
      var yaxisLabel2 = $("<div class='axisLabel yaxisLabel' style='width:50px; position: absolute; left: 740px; top: -30px;'></div>").text("Rate").appendTo($('#chart_f_3'));
      var xaxisLabel = $("<div class='axisLabel xaxisLabel' style='position: absolute; left:400px; bottom: -50px;'></div>").text(" month").appendTo($('#chart_f_3'));

      var yaxisLabel = $("<div class='axisLabel yaxisLabel' style='position: absolute; left: -28px; top: -30px;'></div>").text("People").appendTo($('#chart_f_4'));
      var yaxisLabel2 = $("<div class='axisLabel yaxisLabel' style='width:50px; position: absolute; left: 740px; top: -30px;'></div>").text("Rate").appendTo($('#chart_f_4'));
      var xaxisLabel = $("<div class='axisLabel xaxisLabel' style='position: absolute; left:400px; bottom: -50px;'></div>").text(" month").appendTo($('#chart_f_4'));

      });

      $('#chart_f_m').show();
      $('#chart_f_m_1').hide();
      $('#chart_f_m_2').hide();
      $('#chart_f_m_3').hide();

      $('#chart_f_1').show();
      $('#chart_f_2').hide();
      $('#chart_f_3').hide();
      $('#chart_f_4').hide();

      </script>


</form>


