<div style="background-color:rgba(255,255,255,0.9); border-radius:24px; padding:40px; padding-top:10px; width:92%">
<table align="left"  width="882" style="font-size:10pt; margin-left:19px;">
  <tr style="border:none; height:20px;" >
    <!--<td align="left" bgcolor="#ffffff" width="40" id="backbtn"  style="border:none;" rowspan="2">
    <a href="index.php?mod=mealadmin&func=foodmenu"><img src="Images/back_button.png"></a></td>-->
    <td><h3 style="color:rgb(238,203,53); font-size:30px; font-weight:bold;">Cycle menu management</h3></td>
  </tr>
</table>
<form>
<table border="0" width="960" style="text-align:left; margin-left:3px;">
  <tr>
	<td align="left" style="border:none;">&nbsp;</td>
	<td align="right" style="border:none;" id="printbtn"><input type="button" value="New cycle menu" onclick="window.location.href='index.php?mod=mealadmin&func=newroundmenu'" /></td>
  </tr>
</table>
</form>
<div class="content-table">
<table width="960">
<tr class="title">
  <td>Package No.</td>
      <td width="14%">Sun</td>
	  <td width="14%">Mon</td>
	  <td width="14%">Tue</td>
	  <td width="14%">Wed</td>
	  <td width="14%">Thu</td>
	  <td width="14%">Fri</td>
	  <td width="14%">Sat</td>
	  
  </tr>
<?php
$db = new DB;
$db->query("SELECT `setID` FROM `roundmenu` GROUP BY `setID`");
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	echo '
	<tr>
	  <td align="center">
	  '.$r['setID'].'<br>
	  <form><p>
	  <input type="button" onclick="window.location.href=\'index.php?mod=mealadmin&func=editroundmenu&mealID='.$r['setID'].'\'" value="Edit"></p>
	  <p><input type="button" onclick="if (confirm(\'Confirm delete？\')) { window.location.href=\'index.php?mod=mealadmin&func=deleteroundmenu&mealID='.$r['setID'].'\' } else { alert(\'Deletion canceled\'); }" value="Delete">
	  </p></form>
	  </td>'."\n";
	for ($j=0;$j<=6;$j++) {
		$db1 = new DB;
		$db1->query("SELECT * FROM `roundmenu` WHERE `setID`='".$r['setID']."' AND `day`='".$arrDay[$j]."'");
		$r1 = $db1->fetch_assoc();
		echo '
		<td valign="top">
		<p align="left">
		<fieldset><legend>Breakfast</legend>'.$r1['meal1'].'</fieldset>
		<fieldset><legend>Refreshment</legend>'.$r1['meal2'].'</fieldset>
		<fieldset><legend>Lunch</legend>'.$r1['meal3'].'</fieldset>
		<fieldset><legend>Refreshment</legend>'.$r1['meal4'].'</fieldset>
		<fieldset><legend>Dinner</legend>'.$r1['meal5'].'</fieldset>
		<fieldset><legend>Night refreshment</legend>'.$r1['meal6'].'</fieldset>
		</p>
		</td>
		'."\n";
	}
}
?>
</table>
</div></div>