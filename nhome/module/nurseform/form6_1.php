<h3>Nursing Meeting Minutes</h3>
<?php
$db = new DB;
$db->query("SELECT * FROM `nurseform06a` WHERE `Qcate`='1' AND `date`='".mysql_escape_string($_GET['date'])."' AND `time`='".mysql_escape_string($_GET['time'])."'");
$r = $db->fetch_assoc();
?>
<table>
  <tr>
    <td class="title" width="120">Date/Time</td>
    <td><?php echo formatdate(@$_GET['date']).' '.substr(@$_GET['time'],0,2).':'.substr(@$_GET['time'],2,2); ?></td>
  </tr>
  <tr>
    <td class="title">Attendee</td>
    <td><?php echo $r['Q1']; ?></td>
  </tr>
  <tr>
    <td class="title">Conference theme</td>
    <td><?php echo $r['Q2']; ?></td>
  </tr>
  <tr>
    <td class="title">Meeting minutes</td>
    <td><?php echo str_replace("\n","<br>",$r['Qcontent']); ?></td>
  </tr>
</table>