<div class="moduleNoTab">
<h3>Transfer list</h3>
<div align="right">
  <?php
  if ($_GET['EmpID']!="") {
   $EmpID = (int) @$_GET['EmpID'];
 } else {
   $EmpID = "";
 }
 ?>
 <form>
  <input type="button" value="Add" onclick="window.location.href='index.php?mod=humanresource&func=formview&id=10_1&EmpID=<?php echo $EmpID; ?>'" />
  <input type="button" value="Print" onclick="window.open('printHRform10.php?EmpID=<?php echo $EmpID; ?>');" />
</form>
</div>
<div class="content-table">
  <table>
    <tr class="title">
      <td>&nbsp;</td>
      <td>Handover item</td>
      <td>Quantity of handover</td>
      <td>Contents</td>
      <td>Not yet progressed focus</td>
      <td>Handover personnel</td>
      <td>Handover supervised by</td>
      <td>Handover date</td>
    </tr>
    <?php
    $sql1 = "SELECT * FROM `humanresource10` WHERE `EmpID`='".$EmpID."'";
    $db = new DB;
    $db->query($sql1);
    for ($i=0;$i<$db->num_rows();$i++) {
     $r = $db->fetch_assoc();
     foreach ($r as $k=>$v) {
      $arrPatientInfo = explode("_",$k);
      if (count($arrPatientInfo)==2) {
       if ($v==1) {
        ${$arrPatientInfo[0]} = $arrPatientInfo[1];
      }
    } else {
     ${$k} = $v;
   }
 }
 echo '
 <tr>
 <td width="6%"><center><a href="index.php?mod=humanresource&func=formview&id=10_1&humanID='.$r['humanID'].'&EmpID='.$r['EmpID'].'"><img src="Images/select.png"></a></center></td>
 <td>'.$title.'</td>
 <td>'.$qty.'</td>
 <td>'.str_replace("\n","<br>",$content1).'</td>
 <td>'.$content2.'</td>
 <td>'.getEmployerName($handover).'</td>
 <td>'.getEmployerName($Qfiller).'</td>
 <td>'.$date.'</td>
 </tr>'."\n";
}
?>
</table>
</div>
</div>