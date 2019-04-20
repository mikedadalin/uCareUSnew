<h3>住民個別活動紀録</h3>
<div align="right" class="printcol">
<select id="selmonth">
    <option>--Select month--</option>
    <?php
    $nextmonth = date(m)+1; if ($nextmonth>12) { $nextmonth = 1; $nextyear = date(Y)+1; } else { $nextyear = date(Y); }
    if (strlen($nextmonth)==1) { $nextmonth = "0".$nextmonth; }
    echo '<option value="'.$nextyear.$nextmonth.'">'.$nextyear.'-'.$nextmonth.'</option>'."\n";
    for ($i=date(m);$i>=(date(m)-5);$i--) {
        $month = $i;
        $year = date(Y);
        if ($i<1) {
            $month = 12+$i;
            $year = date(Y)-1;
        }
        if (strlen($month)==1) {
            $month = "0".$month;
        }
        echo '<option value="'.$year.$month.'">'.$year.'-'.$month.'</option>'."\n";
    }
    ?>
</select>
<input type="image" src="Images/print.png" onclick="printreport()">
<script>
function printreport() {
    var selectedmonth = document.getElementById('selmonth').value;
    window.open('printsocialform08.php?date='+selectedmonth+'&pid=<?php echo $_GET['pid']; ?>', '_blank' );
}

</script>
</div>
<table style="width:960px;" id="newrecordtable">
  <thead><tr class="title">
    <th>Date</th>
    <th>Activity</th>
    <th>Plan/Record</th>
  </tr></thead>
  <?php
  $db1 = new DB;
  $db1->query("SELECT * FROM `socialform08` WHERE `HospNo` LIKE '%".$HospNo."%' ORDER BY `date` DESC, `actID` ASC");
  for ($i1=0;$i1<$db1->num_rows();$i1++) {
	  $r1 = $db1->fetch_assoc();
	  $arrHospNo = explode(";",$r1['HospNo']);
	  $db1a = new DB;
	  $db1a->query("SELECT * FROM `socialform08_act` WHERE `actID`='".$r1['actID']."'");
	  $r1a = $db1a->fetch_assoc();
	  echo '
  <tr>
    <td align="center">'.formatdate($r1['date']).'</td>
	<td align="center">'.$r1a['cateName'].' - '.$r1a['actName'].'</td>
	<td align="center"><a href="index.php?mod=socialwork&func=formview&id=8b&actNo='.$r1['actNo'].'">活動計畫</a> <a href="index.php?mod=socialwork&func=formview&id=8_1b&actNo='.$r1['actNo'].'">活動紀錄</a></td>
  </tr>
	  '."\n";
  }
  ?>
</table>
