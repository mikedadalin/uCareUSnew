<div class="content-table" style="background-color:rgba(255,255,255,0.8); border-radius:10px; padding:10px 5px; margin-bottom:40px;">
<h3>統計雜物品項人數</h3>
<?php
//使用說明 Start
//$manual_table="careform08";
//include("class/useInfo.php");
//使用說明 End

if (isset($_POST['itemID'])) {
	$itemID = $_POST['itemID'];
	$date = str_replace("/","-",$_POST['date']);
	if(count($_POST['HospNo']) > 0){
		foreach ($_POST['HospNo'] as $k=>$v) {
			if ($hospnotxt!="") { $hospnotxt .= ';'; }
			$hospnotxt .= $v;
		}
	}else{
		//公用
		foreach ($_POST as $k=>$v){
			if(substr($k,0,6)=="public"){
				$public = explode("_",$k);
				if ($hospnotxt!="") { $hospnotxt .= ';'; }
				$hospnotxt .= $public[1].'_'.($v==""?"0":$v);
			}
		}
	}
	$hospNo = explode(";", $hospnotxt);

	$db = new DB;
	$db->query("SELECT * FROM `careform08` WHERE `date`='".$date."' AND `title`='".$itemID."'");
	if ($db->num_rows()==0) {
		$db1 = new DB;
		$db1->query("INSERT INTO `careform08` VALUES ('', '".$date."', '".$itemID."', '".$hospnotxt."', '".(count($_POST['HospNo'])>0?count($hospNo):"0")."')");
	} else {
		$r = $db->fetch_assoc();
		$db1 = new DB;
		$db1->query("UPDATE `careform08` SET `HospNo`='".$hospnotxt."', `countNo`='".(count($_POST['HospNo'])>0?count($hospNo):"0")."' WHERE `mID`='".$r['mID']."';");
	}
	//echo "<script>window.location.href='index.php?mod=socialwork&func=formview&id=8'<//script>";
}
if(@$_GET['itemID']==''){
	$strSQL = "SELECT * FROM `careform08` ORDER BY `date` DESC, `mID` Limit 0,1";
}else{
	$strSQL = "SELECT * FROM `careform08` WHERE `title`='".mysql_escape_string($_GET['itemID'])."' AND `date`='".str_replace("/","-",$_GET['date'])."'";
}
	$db1e = new DB;
	$db1e->query($strSQL);
	if ($db1e->num_rows()>0) {
		$r1e = $db1e->fetch_assoc();
		$arrSelectedHospNo = explode(";",$r1e['HospNo']);
		foreach ($r1e as $k=>$v) {
			if (substr($k,0,1)=="Q") {
				$arrAnswer = explode("_",$k);
				if (count($arrAnswer)==2) {
					if ($v==1) {
						${$arrAnswer[0]} .= $arrAnswer[1].';';
					}
				} else {
					${$k} = $v;
				}
			}  else {
				${$k} = $v;
			}
		}		
	}
?>
<script>
function checkall(cName) {
    var checkboxs = document.getElementsByName(cName);
    for(var i=0;i<checkboxs.length;i++){checkboxs[i].checked = true;}
}
function uncheckall(cName) { 
    var checkboxs = document.getElementsByName(cName); 
    for(var i=0;i<checkboxs.length;i++){checkboxs[i].checked = false;} 
}
function calcNo(cName) { 
    var checkboxs = document.getElementsByName(cName); 
	var count = 0;
    for(var i=0;i<checkboxs.length;i++){
		if (checkboxs[i].checked == true) { count++; }
	}
	document.getElementById('Q7').value = count;
}
$(function () {
	$('#itemID').change(function(){
		location.href = "index.php?mod=carework&func=formview&id=8&date="+$("#date").val()+"&itemID="+$("#itemID").val();
	});
});
</script>
<form id="careform08" method="post" action="index.php?mod=carework&func=formview&id=8">
<table width="100%" cellpadding="7">
  <tr>
    <td width="160" class="title">Date</td>
    <td><input type="text" id="date" name="date" value="<?php echo ($date==""?$_GET['date']:str_replace("-","/",$date));?>"></td>
    <td width="160" class="title">雜物品項</td>
    <td>
	<?php		
echo '<select id="itemID" name="itemID" class="validate[required]">';
echo '  <option></option>';
$db3 = new DB;
$db3->query("SELECT * FROM `applyitem2` ORDER BY `itemID` ASC");
for ($i3=0;$i3<$db3->num_rows();$i3++) {
	$r3 = $db3->fetch_assoc();
	echo '  <option value="'.$r3['itemID'].'"';
	if (($title==""?$_GET['itemID']:$title)==$r3['itemID']) { echo ' selected'; }
	echo '>'.$r3['itemName'].'</option>';
	$arritemName[$r3['itemID']] = $r3['itemName'];
}
echo '</select>';
?>
    </td>
  </tr>
  <tr>
    <td class="title">Select Resident(s)</td>
    <td colspan="5">
    <input type="button" name="all" onclick="checkall('HospNo[]')" value="Select all" /> <input type="button" name="all" onclick="uncheckall('HospNo[]')" value="Unselect all" />
    <?php
	$arrHospNo = array();
	$db2a = new DB;
	$db2a->query("SELECT * FROM `areainfo`");
	for ($i2a=0;$i2a<$db2a->num_rows();$i2a++) {
		$r2a = $db2a->fetch_assoc();
		$arrHospNo[$r2a['areaName']] = array();
		$db2b = new DB;
		$db2b->query("SELECT a.`patientID` FROM `inpatientinfo` a, `bedinfo` b WHERE (a.`bed` = b.`bedID` AND b.`Area`='".$r2a['areaID']."') ORDER BY a.`bed` ASC");
		for ($i2b=0;$i2b<$db2b->num_rows();$i2b++) {
			$r2b = $db2b->fetch_assoc();
			$arrHospNo[$r2a['areaName']][$i2b] = $r2b['patientID'];			
		}
	}
	if ($arrSelectedHospNo=="") { $arrSelectedHospNo = array(); }
	foreach ($arrHospNo as $k1=>$v1) {
		if (count($arrHospNo[$k1])>0) {
			echo '<h3>'.$k1.'</h3>';						
			echo '<div>公用申請：<input type="text" name="public_'.$k1.'" id="public_'.$k1.'" size="5" value="';
				foreach($arrSelectedHospNo as $a=>$b){$c=explode("_",$b);if($k1==$c[0]){echo ($c[1]==0?"":$c[1]);}}
			echo '"></div>';
			$count1 = 0;
			foreach ($arrHospNo[$k1] as $k2=>$v2) {
				if ($count1>0 && $count1%4==0) { echo '<br>'; }
				echo '<div style="width:180px; display:inline-block;"><input type="checkbox" name="HospNo[]" value="'.getHospNo($v2).'" checkbox"'.(in_array(getHospNo($v2),$arrSelectedHospNo)?" checked":"").' onclick="calcNo(\'HospNo[]\')">'.getHospNo($v2).' '.getPatientName($v2).' </div>';
				$count1++;
			}
		}
	}
	?>
    </td>
  </tr>
  <tr>
    <td colspan="4" align="center"><input type="submit" value="新增統計" id="submit" /></td>
  </tr>
</table>
</form>
</div>
<script>
$(function(){
	$("#careform08").validationEngine();
	$("#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true});
	$("#submit").click(function(){
		var count = 0;
		var count1 = 0;
		$("input[name^='public_']").each(function () {
			if ($(this).val()!="") {
				count1++;
			}
		});
		var checkboxs = document.getElementsByName('HospNo[]');
		for(var i=0;i<checkboxs.length;i++){
			if (checkboxs[i].checked == true) { count++; }
		}
		if(count == 0 && count1 == 0){
			alert("無勾選資料!");
			return false;
		}else{
			$('form[id=careform08]').submit();
		}
	});
});

</script>