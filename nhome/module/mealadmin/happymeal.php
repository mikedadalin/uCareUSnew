<div class="content-table">
<h3>統計快樂餐人數</h3>
<?php
if (isset($_POST['actID'])) {
	$actID = $_POST['actID'];
	$date = str_replace('-','',str_replace('/','',$_POST['date']));
	
	foreach ($_POST['HospNo'] as $k=>$v) {
		if ($hospnotxt!="") { $hospnotxt .= ';'; }
		$hospnotxt .= $v;
	}
	$hospNo = explode(";", $hospnotxt);
	$db0b = new DB;
	$db0b->query("UPDATE `happymeal` SET `HospNo`='".$hospnotxt."', `countNo`='".count($hospNo)."' WHERE `mID`='".$actID."';");
	//echo "<script>window.location.href='index.php?mod=socialwork&func=formview&id=8'<//script>";
}
if(@$_GET['actID']==''){
	$strSQL = "SELECT * FROM `happymeal`  ORDER BY `date` DESC, `mID` Limit 0,1";
}else{
	$strSQL = "SELECT * FROM `happymeal` WHERE `mID`='".mysql_escape_string($_GET['actID'])."'";
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




$arrCateName = array();
$arrActName = array();
$db1a = new DB;
$db1a->query("SELECT DISTINCT `date` FROM `happymeal` WHERE datediff(now(),`date`)<=31 ORDER BY `date` DESC");
for ($i1a=1;$i1a<=$db1a->num_rows();$i1a++) {
	$r1a = $db1a->fetch_assoc();
	$arrCateName[$i1a] = $r1a['date'];
	$db1b = new DB;
	$db1b->query("SELECT * FROM `happymeal` WHERE `date`='".$r1a['date']."'");
	for ($i1b=0;$i1b<$db1b->num_rows();$i1b++) {
		$r1b = $db1b->fetch_assoc();
		$arrActName[$i1a][$r1b['mID']] = $r1b['title'];
	}
}
?>
<script>
function changeAct(idx) {
	var actname = document.getElementById('actID');
	if (idx>0) {
		actname.options.length = 0;
		actname.readonly = false;
		switch (idx) {
			<?php
			foreach ($arrCateName as $k1=>$v1) {
				$count = 1;
				echo '		case '.$k1.':'."\n";
				echo 'actname.options[0] = new Option(\'\', \'\');';
				foreach ($arrActName[$k1] as $k2=>$v2) {
			?>
			actname.options[<?php echo $count; ?>] = new Option('<?php echo $v2; ?>', '<?php echo $k2; ?>');
			<?php
					$count++;
				}
				echo '		break;'."\n";
			}
			?>
		}
	} else {
		actname.options.length = 0;
		actname.readonly = true;
	}
}
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
	$('#actID').change(function(){
		location.href = "index.php?mod=mealadmin&func=happymeal&cateName="+$("#cateName").val()+"&actID="+$("#actID").val();
	});
});
</script>
<form id="happymeal" method="post">
<table width="100%">
  <tr>
    <td width="160" class="title">Date</td>
    <td>
	<select id="cateName" onchange="changeAct(this.selectedIndex);">
      <option>--請Select date--</option>
      <?php
	  foreach ($arrCateName as $k1=>$v1) {
		  echo '<option value="'.$k1.'" '.($k1==$_GET['cateName']?"selected":"").'>'.$v1.'</option>';
	  }
	  ?>
    </select>
    <select name="actID" id="actID" class="validate[required]" readonly>
      <option></option>
      <?php
	  if ($_GET['actID']!="") {
		  $dbMeal = new DB;
		  $dbMeal->query("SELECT * FROM `happymeal` WHERE `mID`='".mysql_escape_string($_GET['actID'])."'");
		  $rMeal = $dbMeal->fetch_assoc();
		  $dbMeal2 = new DB;
		  $dbMeal2->query("SELECT * FROM `happymeal` WHERE `date`='".$rMeal['date']."'");
		  for ($i=0;$i<$dbMeal2->num_rows();$i++) {
			  $rMeal2 = $dbMeal2->fetch_assoc();
			  echo '
			  <option value="'.$rMeal2['mID'].'"';
			  if ($rMeal2['mID']==$_GET['actID']) { echo " selected"; }
			  echo '>'.$rMeal2['title'].'</option>
			  '."\n";
		  }
	  }
	  ?>
    </select>
    </td>
  </tr>
  <tr>
    <td class="title">Select resident(s)</td>
    <td colspan="3">
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
			$count1 = 0;
			foreach ($arrHospNo[$k1] as $k2=>$v2) {
				if ($count1>0 && $count1%4==0) { echo '<br>'; }
				echo '<div style="width:180px; display:inline-block;"><input type="checkbox" name="HospNo[]" value="'.getHospNo($v2).'" class="validate[minCheckbox[1]] checkbox"'.(in_array(getHospNo($v2),$arrSelectedHospNo)?" checked":"").' onclick="calcNo(\'HospNo[]\')">'.getHospNo($v2).' '.getPatientName($v2).' </div>';
				$count1++;
			}
		}
	}
	?>
    </td>
  </tr>
  <tr>
    <td colspan="2" class="title"><input type="submit" value="新增統計" /></td>
  </tr>
</table>
</form>
</div>
<script>$("#happymeal").validationEngine();</script>