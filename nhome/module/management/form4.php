<?php
if (count($_POST)>0) {
	foreach ($_POST as $k=>$v) {
		$arr = explode("_",$k);
		$arrinfo = (count($arr)==3?$arr[1]."_".$arr[2]:$arr[1]);
		$db0 = new DB;
		$db0->query("UPDATE `formremind` SET `remindDay` = '".$v."' WHERE `formID`='".$arrinfo."'");
	}
}
$db1 = new DB;
$db1->query("SELECT * FROM `formremind` ORDER BY `formID`");
?>
<h3>Form filling reminder scheduling</h3>
<fieldset class="rangeH" style="font-size:18px; font-weight:bolder; background-color:rgba(255,255,255,0.8); color:#f33548;">If Not need to remind, enter 0, 30 days for a month, 90 days for 3 months, 180 days for half year, 365 days a year.</fieldset>
<form method="post">
  <table style="width:100%;">
    <tr class="title">
      <td>Category</td>
      <td>Form/Aseessment Name</td>
      <td>Alert Cycle (days)</td>
    </tr>
    <?php
    for ($i1=0;$i1<$db1->num_rows();$i1++) {
     $r1 = $db1->fetch_assoc();
     ?>
     <tr>
      <td align="center"><?php echo $r1['formType']; ?></td>
      <td style="padding:10px;"><?php echo $r1['formName']; ?></td>
      <td align="center"><input type="text" name="remindDay_<?php echo $r1['formID']; ?>" id="remindDay_<?php echo $r1['formID']; ?>" size="3" value="<?php echo $r1['remindDay']; ?>">Day(s)</td>
    </tr>
    <?php
  }
  ?>
</table>
<div style="margin-top:30px; text-align:center;">
  <input type="submit" id="save" value="Save">
</div>
</form>