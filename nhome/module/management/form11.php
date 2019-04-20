<div class="content-table">
<h3>Physical examination reference value setting</h3>
<?php
if (isset($_POST['saverange'])) {
	//print_r($_POST);
	$db2 = new DB;
	$db2->query("SELECT * FROM `labrange` ORDER BY `labID` ASC");
	for ($i2=0;$i2<$db2->num_rows();$i2++) {
		$r2 = $db2->fetch_assoc();
		$db2a = new DB;
		$db2a->query("UPDATE `labrange` SET `type`='".mysql_escape_string($_POST['type_'.$r2['labID']])."', `MrangeL`='".mysql_escape_string($_POST['MrangeL_'.$r2['labID']])."', `MrangeH`='".mysql_escape_string($_POST['MrangeH_'.$r2['labID']])."', `FrangeL`='".mysql_escape_string($_POST['FrangeL_'.$r2['labID']])."', `FrangeH`='".mysql_escape_string($_POST['FrangeH_'.$r2['labID']])."', `abnormal`='".mysql_escape_string($_POST['abnormal_'.$r2['labID']])."' WHERE `labID`='".$r2['labID']."'");
	}
	?>
    <script>alert('Changes saved!');</script>
    <?php
}
?>
<form method="post" action="index.php?mod=management&func=formview&id=11">
<table>
<tr class="title">
  <td width="180">Item(s)</td>
  <td width="180">Reference Type</td>
  <td>Reference Value</td>
</tr>
<?php
$db0 = new DB;
$db0->query("SELECT * FROM `labrange` ORDER BY `labID` ASC");
for ($i=0;$i<$db0->num_rows();$i++) {
	$r0 = $db0->fetch_assoc();
	$db1 = new DB;
	$db1->query("SELECT * FROM `labitem` WHERE `id`='".$r0['labID']."'");
	$r1 = $db1->fetch_assoc();
	echo '
<tr>
  <td class="title_s">'.$r1['name'].'</td>
  <td style="padding:10px;">
    <center>
    <select name="type_'.$r0['labID'].'" id="type_'.$r0['labID'].'" onchange="changetype(\''.$r0['labID'].'\',this.options[selectedIndex].value,\''.$r0['MrangeL'].'\',\''.$r0['MrangeH'].'\',\''.$r0['FrangeL'].'\',\''.$r0['FrangeH'].'\',\''.$r0['abnormal'].'\')">
	  <option></option>
	  <option value="1" '.($r0['type']==1?"selected":"").'>Upper and lower limits</option>
	  <option value="2" '.($r0['type']==2?"selected":"").'>Single comparison value</option>
	  <option value="3" '.($r0['type']==3?"selected":"").'>Text, Positive/Negative</option>
    </select>
	</center>
  </td>
  <td style="padding:10px;"><span id="div_'.$r0['labID'].'">&nbsp;';
  if ($r0['type']==1) {
	  //Upper and lower limits
	  echo 'male：<input type="text" name="MrangeL_'.$r0['labID'].'" id="MrangeL_'.$r0['labID'].'" size="4" value="'.$r0['MrangeL'].'"> ~ <input type="text" name="MrangeH_'.$r0['labID'].'" id="MrangeH_'.$r0['labID'].'" size="4" value="'.$r0['MrangeH'].'"> female：<input type="text" name="FrangeL_'.$r0['labID'].'" id="FrangeL_'.$r0['labID'].'" size="4" value="'.$r0['FrangeL'].'"> ~ <input type="text" name="FrangeH_'.$r0['labID'].'" id="FrangeH_'.$r0['labID'].'" size="4" value="'.$r0['FrangeH'].'">'."\n";
  } elseif ($r0['type']==2) {
	  //Single comparison value
	  echo 'Greater than <input type="text" name="abnormal_'.$r0['labID'].'" id="abnormal_'.$r0['labID'].'" size="5" value="'.$r0['abnormal'].'">  is normal reference values';
  } elseif ($r0['type']==3) {
	  //文字
	  echo '<input type="text" name="abnormal_'.$r0['labID'].'" id="abnormal_'.$r0['labID'].'" size="45" value="'.$r0['abnormal'].'">';
  }
  echo '</span></td></td>
</tr>
	'."\n";
}
?>
</table>
<div style="margin-top:30px; text-align:center">
	<input type="submit" name="saverange" id="saverange" value="Save" /><input type="reset" value="Reset" />
</div>
</form>
</div>
<script>
function changetype (labID, typeID, MrangeL, MrangeH, FrangeL, FrangeH, abnormal) {
	//alert(labID+':'+typeID);
	if (typeID==1) {
		//Upper and lower limits
		$('#div_'+labID).html('&nbsp;male：<input type="text" name="MrangeL_' + labID + '" id="MrangeL_' + labID + '" size="4" value="' + MrangeL + '" > ~ <input type="text" name="MrangeH_' + labID + '" id="MrangeH_' + labID + '" size="4" value="' + MrangeH + '"> female：<input type="text" name="FrangeL_' + labID + '" id="FrangeL_' + labID + '" size="4" value="' + FrangeL + '"> ~ <input type="text" name="FrangeH_' + labID + '" id="FrangeH_' + labID + '" size="4" value="' + FrangeH + '">');
	} else if (typeID==2) {
		//Single comparison value
		$('#div_'+labID).html('&nbsp;Greater than <input type="text" name="abnormal_' + labID + '" id="abnormal_' + labID + '" size="5" value="' + abnormal + '">  is normal reference values');
	} else if (typeID==3) {
		//文字
		$('#div_'+labID).html('&nbsp; <input type="text" name="abnormal_' + labID + '" id="abnormal_' + labID + '" size="5" value="' + abnormal + '">');
	} else {
		$('#div_'+labID).html('');
	}
}
</script>