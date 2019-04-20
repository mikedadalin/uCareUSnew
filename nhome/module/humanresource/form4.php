<div class="moduleNoTab">
<h3>Foreign staff profile maintain</h3>
<div align="right">
  <form>
    <?php
    if (@$_GET['query']==NULL || @$_GET['query']==1) {
      ?>
      <input type="button" value="Display all staff" onclick="window.location.href='index.php?mod=humanresource&func=formview&id=4&query=2'" />
      <?php
    } elseif (@$_GET['query']==2) {
      ?>
      <input type="button" value="只顯示目前在職員工" onclick="window.location.href='index.php?mod=humanresource&func=formview&id=4'" />
      <?php
    }
    ?>
    <input type="button" value="Add new staff" onclick="window.location.href='index.php?mod=humanresource&func=formview&id=4_1'" />
  </form>
</div>
<div class="content-table">
  <table>
    <tr class="title">
      <td>&nbsp;</td>
      <td>Staff ID#</td>
      <td>Full name</td>
      <td>Gender</td>
      <td>Job title</td>
    </tr>
    <?php
    $sql1 = "SELECT * FROM `foreignemployer` ORDER BY `foreignID` ASC";
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
 if (@$_GET['query']==NULL || @$_GET['query']==1) {
   if ($Enddate1==NULL) {
     echo '
     <tr>
     <td width="6%"><center><a href="index.php?mod=humanresource&func=formview&id=4_1&empid='.$r['foreignID'].'"><img src="Images/select.png"></a></center></td>
     <td width="13%" align="center">'.$foreignID.'</td>
     <td width="13%" align="center">'.$eNickname.' '.$cNickname.'</td>
     <td width="13%" align="center">'.$arrGender[$Gender].'</td>
     <td width="13%" align="center">'.$position.'</td>
     </tr>'."\n";
   } elseif ($Startdate2!=NULL && $Enddate2==NULL) {
     echo '
     <tr>
     <td width="6%"><center><a href="index.php?mod=humanresource&func=formview&id=4_1&empid='.$r['foreignID'].'"><img src="Images/select.png"></a></center></td>
     <td width="13%" align="center">'.$foreignID.'</td>
     <td width="13%" align="center">'.$eNickname.' '.$cNickname.'</td>
     <td width="13%" align="center">'.$arrGender[$Gender].'</td>
     <td width="13%" align="center">'.$position.'</td>
     </tr>'."\n";
   } elseif ($Startdate3!=NULL && $Enddate3==NULL) {
     echo '
     <tr>
     <td width="6%"><center><a href="index.php?mod=humanresource&func=formview&id=4_1&empid='.$r['foreignID'].'"><img src="Images/select.png"></a></center></td>
     <td width="13%" align="center">'.$foreignID.'</td>
     <td width="13%" align="center">'.$eNickname.' '.$cNickname.'</td>
     <td width="13%" align="center">'.$arrGender[$Gender].'</td>
     <td width="13%" align="center">'.$position.'</td>
     </tr>'."\n";
   } elseif ($Startdate4!=NULL && $Enddate4==NULL) {
     echo '
     <tr>
     <td width="6%"><center><a href="index.php?mod=humanresource&func=formview&id=4_1&empid='.$r['foreignID'].'"><img src="Images/select.png"></a></center></td>
     <td width="13%" align="center">'.$foreignID.'</td>
     <td width="13%" align="center">'.$eNickname.' '.$cNickname.'</td>
     <td width="13%" align="center">'.$arrGender[$Gender].'</td>
     <td width="13%" align="center">'.$position.'</td>
     </tr>'."\n";
   } elseif ($Startdate5!=NULL && $Enddate5==NULL) {
     echo '
     <tr>
     <td width="6%"><center><a href="index.php?mod=humanresource&func=formview&id=4_1&empid='.$r['foreignID'].'"><img src="Images/select.png"></a></center></td>
     <td width="13%" align="center">'.$foreignID.'</td>
     <td width="13%" align="center">'.$eNickname.' '.$cNickname.'</td>
     <td width="13%" align="center">'.$arrGender[$Gender].'</td>
     <td width="13%" align="center">'.$position.'</td>
     </tr>'."\n";
   }
 } elseif (@$_GET['query']==2) {
  echo '
  <tr>
  <td width="6%"><center><a href="index.php?mod=humanresource&func=formview&id=4_1&empid='.$r['foreignID'].'"><img src="Images/select.png"></a></center></td>
  <td width="13%" align="center">'.$foreignID.'</td>
  <td width="13%" align="center">'.$eNickname.' '.$cNickname.'</td>
  <td width="13%" align="center">'.$arrGender[$Gender].'</td>
  <td width="13%" align="center">'.$position.'</td>
  </tr>'."\n";
}
}
?>
</table>
</div>
</div>