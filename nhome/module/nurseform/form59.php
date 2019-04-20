<h3>Resident's Discharge Medication List</h3>
<div class="nurseform-table">
<?php 
    if (@$_GET['date']=='') {
    $sql = "SELECT * FROM `nurseform17` WHERE `HospNo`='".mysql_escape_string($r['HospNo'])."' ORDER BY `date` DESC LIMIT 0,1";
    } else {
    $sql = "SELECT * FROM `nurseform17` WHERE `HospNo`='".mysql_escape_string($r['HospNo'])."' AND `date`='".mysql_escape_string(@$_GET['date'])."'";
}

 ?>
<table width="100%" align="center">
  <tr class="title">
    <td>Medication</td>
    <td>Dose</td>
    <td>Frequency</td>
    <td>Date</td>
    <td>Time</td>
    <td>Pathway</td>
  </tr>
  <?php
  $db = new DB;
  $db->query("SELECT * FROM `nurseform17` WHERE `HospNo`='".$HospNo."' ORDER BY `order` ASC");
  for ($j=0;$j<=$db->num_rows();$j++) {
      $r = $db->fetch_assoc();
      foreach ($r as $k=>$v) { ${$k} = $v; }
      $date = date("Y/m/d");
      if(strtotime($Qenddate) > strtotime($date)){
            echo '
          <tr>
            <td><center>'.$Qmedicine.' ('.$Qdose.$Qdoseq.')</center></td>
            <td><center>'.$Qusage.'</center></td>
            <td><center>'.$Qfreq.'</center></td>
            <td><center>'.$Qstartdate.'~'.$Qenddate.' ('.calcperiod(str_replace('/','',$Qstartdate),str_replace('/','',$Qenddate)).'Day(s))</center></td>
            <td><center>';
                $Qtime = explode(";",$Qmedtime);
                for ($i=0;$i<count($Qtime);$i++) {
                    if ($Qtime[$i]!="") {
                if (strlen($Qtime[$i])==1) {
                    $Time = "0".$Qtime[$i].":00";
                } else {
                    $Time = $Qtime[$i].":00";
                }
                echo $Time;
                if ($i<(count($Qtime)-2)) {
                    echo ' / ';
                }
                     }
                }
            echo '</center></td>
            <td><center>'.$Qway.'</center></td>
            </tr>'."\n";
            $count++;
      }
    }
//判斷列數是否足夠10列
    if($count < 20){
        for($x = 0; $x < 20-$count; $x++){
            echo '<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
        }
    }
 ?>
</table>
</div>