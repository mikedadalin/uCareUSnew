<script>
$(function() {
    $( "#newareaform" ).dialog({
		autoOpen: false,
		height: 210,
		width: 450,
		modal: true,
		buttons: {
			"New area/room": function() {
				if ($("#areaName").val()=="") {
					alert("請輸入名稱");
					$("#areaName").val('');
					$("#areaName").focus();
				} else {
					$.ajax({
						url: "class/newarea.php",
						type: "POST",
						data: { "areaName": $("#areaName").val()},
						success: function(data) {
							$( "#newareaform" ).dialog( "close" );
							alert("Area/room added successfully");
							window.location.reload();
						}
					});
				}
			},
			"Cancel": function() {
				$( "#newareaform" ).dialog( "close" );
			}
		}
	});
});
</script>
<?php
if($_GET['action']=='delete' && $_GET['area'] != ''){
	$dbC1 = new DB;
	$dbC1->query("SELECT `areaName` FROM `areainfo` WHERE `areaID`='".mysql_escape_string($_GET['area'])."'");
	$rC1 = $dbC1->fetch_assoc();
	$db2 = new DB;
	$db2->query("DELETE FROM `areainfo` WHERE `areaID`='".mysql_escape_string($_GET['area'])."'");
	$db2a = new DB;
	$db2a->query("DELETE FROM `bedinfo` WHERE `Area`='".mysql_escape_string($_GET['area'])."'");
	$dbC2 = new DB;
	$dbC2->query("DELETE FROM `shift_area` WHERE `areaName`='".$rC1['areaName']."'");
	echo '<script>alert("刪除成功");window.location.href="index.php?func=areadmin";</script>';
}
if($_GET['action']=='delete1' && $_GET['area']!=''){
	$db2 = new DB;
	$db2->query("DELETE FROM `bedinfo` WHERE `bedID`='".mysql_escape_string($_GET['bed'])."'");	
	echo '<script>alert("刪除成功");window.location.href="index.php?func=areadmin&action=EditBed&area='.$_GET['area'].'";</script>';
}
?>
<div id="newareaform" title="Add new section / room" class="dialog-form"> 
	<form id="newareaformA">
	<fieldset>
		<table>
			<tr>
				<td class="title">Section/Room Name</td>
				<td><input type="text" name="areaName" id="areaName" size="24" class="validate[required]"></td>
			</tr>
		</table>
	</fieldset>
	</form>
</div>
<div class="content-table" style="text-align:left; background-color: rgba(255,255,255,0.8); border-radius: 10px; padding:10px 10px 30px 10px;">
<h3 style="font-size:25px;">Section / Room setting</h3>
<?php
if (@$_GET['action']==NULL) {
//瀏覽紀錄 Browse record
?>
<form><input type="button" name="newarea" id="newarea" value="Add New Section / Room" onclick="openVerificationForm('#newareaform');" style="height:30px;"></form>
<table width="100%" id="areatable">
<thead><tr class="title">
  <th width="80">Function</th>
  <th width="120">Section/Room</th>
  <th width="90">Total bed number</th>
  <th width="90">Beds occupied</th>
  <th width="90">Empty bed number</th>
  <th width="*">Empty bed location</th>
  <th width="80">Delete</th>
</tr></thead>
<?php
$db = new DB;
$db->query("SELECT * FROM `areainfo` ORDER BY `areaID` ASC");
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	
	//已入住床數
	$db1 = new DB;
	$db1->query("SELECT * FROM `bedinfo` a INNER JOIN `inpatientinfo` b ON a.`bedID` = b.`bed` WHERE a.`Area`='".$r['areaID']."' ");
	
	$db1a = new DB;
	$db1a->query("SELECT a.`Area` , a.`bedID` , IFNULL(b.patientID,'0') AS 'pid' FROM  `bedinfo` a LEFT JOIN  `inpatientinfo` b ON a.`bedID` = b.`bed` WHERE a.`Area`='".$r['areaID']."' ORDER BY a.`bedID` ");
	
	//空床數
	$db1b = new DB;
	$db1b->query("SELECT * FROM `bedinfo` a LEFT JOIN `inpatientinfo` b ON a.`bedID` = b.`bed` WHERE a.`Area`='".$r['areaID']."' AND (b.patientID IS NULL OR b.patientID='')");
	echo '
<tr>
  <td align="center"><a href="index.php?func=areadmin&action=EditBed&area='.$r['areaID'].'"><img src="Images/edit_icon.png" border="0" width="30"></a></td>
  <td align="center">'.$r['areaName'].'</td>
  <td align="center">'.($db1->num_rows() + $db1b->num_rows()).'</td>
  <td align="center">'.($db1->num_rows()).'</td>
  <td align="center">'.($db1b->num_rows()).'</td>
  <td>';
  if ($db1a->num_rows()==0) {
	  
  } else {
	  $vbedtxt = "";
	  for ($i1a=0;$i1a<$db1a->num_rows();$i1a++) {
		  $r1a = $db1a->fetch_assoc();
		  if ($r1a['pid']!=0) {
			  
		  } else {
			  if ($vbedtxt!="") { $vbedtxt .=  '、'; }
			  $vbedtxt .= $r1a['bedID'];
		  }
	  }
	  echo $vbedtxt;
  }
  echo '</td>
  <td align="center">'.($db1->num_rows()==0?'<a href="index.php?func=areadmin&action=delete&area='.$r['areaID'].'"><img src="Images/delete2.png" border="0" width="30"></a>':"").'</td>
</tr>
	'."\n";
}
?>
</table>
<script>
$(function() {
	$('#areatable').dataTable({
		paging: false,
		"order": [[1, "asc"]]
	});
});
</script>
<?php include("EmptyBed.php");?>
<?php
} elseif (@$_GET['action']=="EditBed") {
	$db = new DB;
	$db->query("SELECT * FROM `areainfo` WHERE `areaID`='".mysql_escape_string($_GET['area'])."' ORDER BY `areaID` ASC");
	$rArea = $db->fetch_assoc();
	//新增區域
?>
<h3><?php echo $rArea['areaName']; ?></h3>
<div align="right"><form><input type="button" id="newBed" value="Add new bed" onclick="openVerificationForm('#newBed-form');"/></form></div>
<table width="100%" id="bedtable">
<thead><tr class="title">
  <th width="200">Bed location</th>
  <th width="200">Resident</th>
  <th width="200">專責護理師</th>
  <th width="80">Delete</th>
</tr></thead>
<?php
$db = new DB;
$db->query("SELECT a.`Area` , a.`bedID`, a.`np` , IFNULL(b.patientID,'0') AS 'pid' FROM  `bedinfo` a LEFT JOIN  `inpatientinfo` b ON a.`bedID` = b.`bed` WHERE a.`Area`='".mysql_escape_string($_GET['area'])."' ORDER BY a.`bedID` ");
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	echo '
<tr>
  <td align="center">'.$r['bedID'].'</td>
  <td align="center">'.($r['pid']!=0?getPatientName($r['pid']):'').'</td>
  <td align="center">
  <form>
  <select name="np_'.$r['bedID'].'" id="np_'.$r['bedID'].'">
    <option></option>';
	$db3 = new DB;
	$db3->query("SELECT * FROM `shift_member` a INNER JOIN `employer` b ON a.`EmpID`=b.`EmpID` WHERE a.GroupID = '1' AND a.available='1'");
	for ($i1=0;$i1<$db3->num_rows();$i1++) {
		$r3 = $db3->fetch_assoc();
		echo '<option value="'.$r3['EmpID'].'" '.($r['np']==$r3['EmpID']?" selected":"").'>'.$r3['Name'].'</option>';
	}
	echo '
  </select>
  <input type="button" value="Save" onclick="saveBedNP(\''.$r['bedID'].'\');">
  </form>
  </td>
  <td align="center">'.($r['pid']!=0?'':'<a href="index.php?func=areadmin&action=delete1&area='.$r['Area'].'&bed='.$r['bedID'].'"><img src="Images/delete2.png" border="0" width="30"></a>').'</td>
</tr>
	'."\n";
}
?>
</table>
<center><form><input type="button" value="Back to area list" onClick="window.location.href='index.php?func=areadmin';"></form></center>
<script>
$(function() {
	$('#bedtable').dataTable({
		paging: false,
		"order": [[0, "asc"]]
	});
	 $( "#newBed-form" ).dialog({
		autoOpen: false,
		height: 300,
		width: 400,
		modal: true,
		buttons: {
			"Add New Bed": function() {
				if ($("#newBedID").val()=="") {
					alert("Please input bed #");
					$("#newBedID").val('');
					$("#newBedID").focus();
				} else {
					$.ajax({
						url: "class/newBed.php",
						type: "POST",
						data: {"newArea": $("#newArea").val(), "newBedID": $("#newBedID").val(), "newNP": $("#newNP").val() },
						success: function(data) {
							if (data=="OK") {
								$( "#newBed-form" ).dialog( "close" );
								alert("Bed added！");
								window.location.reload();
							} else if (data=="repeated") {
								$( "#newBed-form" ).dialog( "close" );
								alert("Bed # already exist!");
								window.location.reload();
							}
						}
					});
				}
			},
			"Cancel": function() {
				$( "#newBed-form" ).dialog( "close" );
				window.location.reload();
			}
		}
	});
});
function saveBedNP(bedID) {
	var npno = $('#np_'+bedID).val();
	$.ajax({
		url: 'class/saveBedNP.php',
		type: 'post',
		data: {"bedID": bedID, "NP": npno },
		success: function (data) {
			if (data=="OK") {
				var $dialog = $('<div title="UCare message" class="dialog-form"><table width="100%"><tr><td class="title">Successfully saved!</td></tr></table></div>').dialog({
					buttons: [{
						text: "Confirm",
						click: function(){ $dialog.remove(); window.reload(); }
					}]
				});
			}
		}
	});
}
</script>
<div id="newBed-form" title="Add new bed" class="dialog-form"> 
<form>
<fieldset>
<table>
  <tr>
    <td class="title" width="140">Section/Room</td>
    <td><?php echo $rArea['areaName']; ?><input type="hidden" size="5" name="newArea" id="newArea" value="<?php echo $rArea['areaID']; ?>" /></td>
  </tr>
  <tr>
    <td class="title">Bed location</td>
    <td><input type="text" size="5" name="newBedID" id="newBedID"  /></td>
  </tr>
  <tr>
    <td class="title">專責護理師</td>
    <td>
    <select name="newNP" id="newNP">
    <option></option>
    <?php
	$db3a = new DB;
	$db3a->query("SELECT * FROM `shift_member` a INNER JOIN `employer` b ON a.`EmpID`=b.`EmpID` WHERE a.GroupID = '1' AND a.available='1'");
	for ($i4=0;$i4<$db3a->num_rows();$i4++) {
		$r3a = $db3a->fetch_assoc();
		echo '<option value="'.$r3a['EmpID'].'">'.$r3a['Name'].'</option>';
	}
	?>
    </select>
    </td>
  </tr>
</table>
</fieldset>
</form>
</div>
<?php
}
?>
</div>
<p>&nbsp;</p>