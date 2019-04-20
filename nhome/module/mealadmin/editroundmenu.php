<div style="background-color:rgba(255,255,255,0.9); border-radius:24px; padding:40px; padding-top:10px; width:92%">
<?php
if (isset($_POST['saveroundmenu'])) {
	for ($j=0;$j<=6;$j++) {
		//meal1_1
		$meal1 = str_replace("\n",'<br>',trim($_POST['meal1_'.$arrDay[$j]]));
		$meal2 = str_replace("\n",'<br>',trim($_POST['meal2_'.$arrDay[$j]]));
		$meal3 = str_replace("\n",'<br>',trim($_POST['meal3_'.$arrDay[$j]]));
		$meal4 = str_replace("\n",'<br>',trim($_POST['meal4_'.$arrDay[$j]]));
		$meal5 = str_replace("\n",'<br>',trim($_POST['meal5_'.$arrDay[$j]]));
		$meal6 = str_replace("\n",'<br>',trim($_POST['meal6_'.$arrDay[$j]]));
		$db = new DB;
		$db->query("UPDATE `roundmenu` SET `meal1`='".$meal1."', `meal2`='".$meal2."', `meal3`='".$meal3."', `meal4`='".$meal4."', `meal5`='".$meal5."', `meal6`='".$meal6."' WHERE `setID`='".mysql_escape_string($_POST['mealID'])."' AND `day`='".$arrDay[$j]."'");
	}
	echo '<script>alert(\'Save successfully\'); window.location.href=\'index.php?mod=mealadmin&func=roundmenu\'</script>'."\n";
}
?>
<table align="left"  width="882" style="font-size:10pt; margin-left:19px;">
  <tr style="border:none; height:20px;" >
    <!--<td align="left" bgcolor="#ffffff" width="40" id="backbtn"  style="border:none;" rowspan="2">
    <a href="index.php?mod=mealadmin&func=roundmenu"><img src="Images/back_button.png"></a></td>-->
    <td><h3 style="color:rgb(238,203,53); font-size:30px; font-weight:bold;">Cycle menu management</h3></td>
  </tr>
</table>
<form method="post" action="index.php?mod=mealadmin&func=editroundmenu">
<div class="content-table">
<table width="960">
<tr class="title">
  <td width="13%">Sun</td>
  <td width="13%">Mon</td>
  <td width="13%">Tue</td>
  <td width="13%">Wed</td>
  <td width="13%">Thur</td>
  <td width="13%">Fri</td>
  <td width="13%">Sat</td>
</tr>
<tr>
<?php
for ($j=0;$j<=6;$j++) {
	$db1 = new DB;
	$db1->query("SELECT * FROM `roundmenu` WHERE `setID`='".mysql_escape_string($_GET['mealID'])."' AND `day`='".$arrDay[$j]."'");
	$r1 = $db1->fetch_assoc();
	echo '
	<td valign="top">
	<p align="left">
	<fieldset><legend>Breakfast</legend><textarea cols="10" rows="6" name="meal1_'.$arrDay[$j].'">'.str_replace('<br>',"\n",$r1['meal1']).'</textarea></fieldset>
	<fieldset><legend>Refreshment</legend><textarea cols="10" rows="3" name="meal2_'.$arrDay[$j].'">'.str_replace('<br>',"\n",$r1['meal2']).'</textarea></fieldset>
	<fieldset><legend>Lunch</legend><textarea cols="10" rows="8" name="meal3_'.$arrDay[$j].'">'.str_replace('<br>',"\n",$r1['meal3']).'</textarea></fieldset>
	<fieldset><legend>Refreshment</legend><textarea cols="10" rows="3" name="meal4_'.$arrDay[$j].'">'.str_replace('<br>',"\n",$r1['meal4']).'</textarea></fieldset>
	<fieldset><legend>Dinner</legend><textarea cols="10" rows="8" name="meal5_'.$arrDay[$j].'">'.str_replace('<br>',"\n",$r1['meal5']).'</textarea></fieldset>
	<fieldset><legend>Night refreshment</legend><textarea cols="10" rows="8" name="meal6_'.$arrDay[$j].'">'.str_replace('<br>',"\n",$r1['meal6']).'</textarea></fieldset>
	</p>
	</td>
	'."\n";
}
?>
</tr>
<tr>
  <td colspan="7" align="center"><input type="hidden" name="mealID" id="mealID" value="<?php echo @$_GET['mealID']; ?>"><input type="submit" name="saveroundmenu" id="saveroundmenu" value="Save"></td>
</tr>
</table>
</div>
</form></div>