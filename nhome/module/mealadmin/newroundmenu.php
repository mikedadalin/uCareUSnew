<div style="background-color:rgba(255,255,255,0.9); border-radius:24px; padding:40px; padding-top:10px; width:92%">
<?php
if (isset($_POST['saveroundmenu'])) {
	$db1 = new DB;
	$db1->query("SELECT `setID` FROM `roundmenu` GROUP BY `setID` ORDER BY `setID` DESC LIMIT 0,1");
	$r1 = $db1->fetch_assoc();
	$newsetID = $r1['setID']+1;
	for ($j=0;$j<=6;$j++) {
		//meal1_1
		$meal1 = str_replace("\n",'<br>',trim($_POST['meal1_'.$arrDay[$j]]));
		$meal2 = str_replace("\n",'<br>',trim($_POST['meal2_'.$arrDay[$j]]));
		$meal3 = str_replace("\n",'<br>',trim($_POST['meal3_'.$arrDay[$j]]));
		$meal4 = str_replace("\n",'<br>',trim($_POST['meal4_'.$arrDay[$j]]));
		$meal5 = str_replace("\n",'<br>',trim($_POST['meal5_'.$arrDay[$j]]));
		$meal6 = str_replace("\n",'<br>',trim($_POST['meal6_'.$arrDay[$j]]));
		$db = new DB;
		$db->query("INSERT INTO `roundmenu` VALUES ('".$newsetID."', '".$arrDay[$j]."', '".$meal1."', '".$meal2."', '".$meal3."', '".$meal4."', '".$meal5."', '".$meal6."')");
	}
	echo '<script>alert(\'Save successfully\'); window.location.href=\'index.php?mod=mealadmin&func=roundmenu\'</script>'."\n";
}
?>
<table align="left"  width="882" style="font-size:10pt; margin-left:19px;">
  <tr style="border:none; height:20px;" >
    <!--<td align="left" bgcolor="#ffffff" width="40" id="backbtn"  style="border:none;" rowspan="2">
    <a href="index.php?mod=mealadmin&func=roundmenu"><img src="Images/back_button.png"></a></td>-->
    <td><h3 style="color:rgb(238,203,53); font-size:30px; font-weight:bold;">New cycle menu</h3></td>
  </tr>
</table>
<form method="post" action="index.php?mod=mealadmin&func=newroundmenu">
<div class="content-table">
<table width="960">
<tr class="title">
  <td width="13%">日</td>
  <td width="13%">一</td>
  <td width="13%">二</td>
  <td width="13%">三</td>
  <td width="13%">四</td>
  <td width="13%">五</td>
  <td width="13%">六</td>
</tr>
<tr>
<?php
for ($j=0;$j<=6;$j++) {
	echo '
	<td valign="top">
	<p align="left">
	<fieldset><legend>Breakfast</legend><textarea cols="10" rows="6" name="meal1_'.$arrDay[$j].'"></textarea></fieldset>
	<fieldset><legend>Refreshment</legend><textarea cols="10" rows="3" name="meal2_'.$arrDay[$j].'"></textarea></fieldset>
	<fieldset><legend>Lunch</legend><textarea cols="10" rows="8" name="meal3_'.$arrDay[$j].'"></textarea></fieldset>
	<fieldset><legend>Refreshment</legend><textarea cols="10" rows="3" name="meal4_'.$arrDay[$j].'"></textarea></fieldset>
	<fieldset><legend>Dinner</legend><textarea cols="10" rows="8" name="meal5_'.$arrDay[$j].'"></textarea></fieldset>
	<fieldset><legend>Night refreshment</legend><textarea cols="10" rows="3" name="meal6_'.$arrDay[$j].'"></textarea></fieldset>
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