<?php

if (isset($_POST['saveproduct'])) {
	array_pop($_POST);
	foreach ($_POST as $k=>$v) {
		$arrVarName = explode('_',$k);
		if (count($arrVarName)==2) {
			//General
			$db0 = new DB;
			$db0->query("UPDATE `arkstockforapply` SET `".$k."`='".$v."' WHERE `ApplyItemID`='".mysql_escape_string($_POST['ApplyItemID'])."'");
		} elseif (count($arrVarName)==3) {
			//STK_DISPLAY處理
			if ($v==1) {
				$vtowrite.=$arrVarName[2].';';
			}
		}
	}
	$vtowrite = substr($vtowrite,0,strlen($vtowrite)-1);
	$db0->query("UPDATE `arkstockforapply` SET `".$arrVarName[0].'_'.$arrVarName[1]."`='".$vtowrite."' WHERE `ApplyItemID`='".mysql_escape_string($_POST['ApplyItemID'])."'");
	echo "<script>alert('成功修改申請物品品項！');</script>";
}

$ApplyItemID = mysql_escape_string($_GET['ApplyItemID']);
$db = new DB;
$db->query("SELECT * FROM `arkstockforapply` WHERE `ApplyItemID`='".$ApplyItemID."'");
$r = $db->fetch_assoc();
?>
<form id="base" method="post" action="index.php?mod=consump&func=formview&id=11_2&ApplyItemID=<?php echo $_GET['ApplyItemID']; ?>">
<table width="100%">
  <tr>
    <td class="title" colspan="10">Edit item</td>
  </tr>
  <tr>
    <td class="title" width="100">ID #</td>
    <td width="200" align="left"><?php echo $r['ApplyItemID']; ?><input type="hidden" name="ApplyItemID" id="ApplyItemID" value="<?php echo $r['ApplyItemID']; ?>"></td>
    <td class="title" width="80">Name</td>
    <td align="left"><input type="text" name="STK_NAME" id="STK_NAME" size="80" value="<?php echo $r['STK_NAME']; ?>" class="validate[required]"></td>
    
  </tr>
  <tr>
    <td class="title">Corresponding<br />item ID#</td>
    <td align="left"><input type="text" name="STK_NO" id="STK_NO1" size="10" value="<?php echo $r['STK_NO']; ?>"><input type="button" value="Select product" onclick="window.open('class/searchSTK3.php?query=1', '_blank', 'width=960, height=150'); return true;" /></td>
    <td class="title">Corresponding<br />Item name</td>
    <td align="left"><input type="text" readonly size="80" id="STK_NAME1" value="<?php if ($r['STK_NO']!="") { $db2 = new DB; $db2->query("SELECT `STK_NAME` FROM `arkstock` WHERE `STK_NO`='".$r['STK_NO']."'"); $r2 = $db2->fetch_assoc(); echo $r2['STK_NAME']; } ?>" class="validate[required]"></td>
  </tr>
  <tr>
    <td class="title">Unit</td>
    <td align="left"><input type="text" name="STK_UNIT" id="STK_UNIT1" size="20" value="<?php echo $r['STK_UNIT']; ?>"></td>
    <td class="title">Category</td>
    <td align="left">
    <select name="KIND_NO" id="KIND_NO">
      <option></option>
      <?php
	  $db1a = new DB;
	  $db1a->query("SELECT * FROM `applyitemcate` ORDER BY `ID` ASC");
	  for ($i1a=0;$i1a<$db1a->num_rows();$i1a++) {
		  $r1a = $db1a->fetch_assoc();
		  echo '<option value="'.$r1a['ID'].'"'.($r1a['ID']==$r['KIND_NO']?' selected':'').'>'.$r1a['Name'].'</option>'."\n";
	  }
	  ?>
    </select>
    </td>
  </tr>
  <tr>
    <td class="title">Open to group(s)</td>
    <td colspan="3" align="left">
    <?php echo draw_option('STK_DISPLAY','Administration;Nurse(RN);Domestic CNA;Pharmacy;Social worker;Rehab;Nutrition;Public work;General manage;Foreign CNA','xm','multi',$r['STK_DISPLAY'],true,5); ?>
    </td>
  </tr>
  <tr class="printcol">
    <td colspan="6" align="center"><input type="button" value="Back to list" onclick="window.location.href='index.php?mod=consump&func=formview&id=11&view=1'"> <input type="submit" name="saveproduct" id="saveproduct" value="Save changes"></td>
  </tr>
</table>
</form>
<script>
$(function() {
	$('#base').validationEngine();
});
</script>