<h3>Administrative meeting record</h3>
<?php
$db = new DB;
$db->query("SELECT * FROM `nurseform06a` WHERE `Qcate`='".mysql_escape_string($_GET['cate'])."' AND `date`='".mysql_escape_string($_GET['date'])."' AND `time`='".mysql_escape_string($_GET['time'])."'");
$r = $db->fetch_assoc();
?>
<table style="width:100%; text-align:left;">
  <tr>
    <td class="title" width="120" style="padding:5px 10px;">Date/Time</td>
    <td style="padding:5px 10px;"><?php echo formatdate(@$_GET['date']).' '.substr(@$_GET['time'],0,2).':'.substr(@$_GET['time'],2,2); ?></td>
  </tr>
  <tr>
    <td class="title" style="padding:5px 10px;">Attendee</td>
    <td style="padding:5px 10px;"><?php echo $r['Q1']; ?></td>
  </tr>
  <tr>
    <td class="title" style="padding:5px 10px;">Conference Theme</td>
    <td style="padding:5px 10px;"><?php echo $r['Q2']; ?></td>
  </tr>
  <tr>
    <td class="title" style="padding:5px 10px;">Meeting Minutes</td>
    <td style="padding:5px 10px;"><?php echo $r['Qcontent']; ?></td>
  </tr>
</table><br>