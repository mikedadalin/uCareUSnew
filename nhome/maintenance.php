<script>
$(function() {
    $( "#dialog-form" ).dialog({
		autoOpen: false,
		height: 390,
		width: 620,
		modal: true,
		buttons: {
			"Repairment apply": function() {
				$.ajax({
					url: "class/newmaintenance.php",
					type: "POST",
					data: {"mainID": $(this).data('mainID'), "ApplyDate": $("#ApplyDate").val(), "ApplyFloor": $("#ApplyFloor").val(), "ApplyContent1": $("#lbllevel2").val()+'_'+$("#ApplyContent1").val(), "ApplyContent2": $("#ApplyContent2").val(), "Applicant": $("#Applicant").val() },
					success: function(data) {
						$( "#dialog-form" ).dialog( "close" );
						if(data=="insert"){
							alert("Add record sucessfully!");
						} else{
							alert("Modify success!");
						}
						window.location.reload();
					}
				});
			},
			"Cancel": function() {
				$( "#dialog-form" ).dialog( "close" );
				window.location.reload();
			}
		}
	});
});
function editRecord(id) {
	$("#dialog-form").data('mainID',id).dialog( "open" );
	$.ajax({
		url: "class/getmaintenance.php",
		type: "POST",
		data: {"mainID": id },
		success: function(data) {
			var arr = data.split('_');
			var arr2 = arr[1].split(';');
			$("#2nd").html(arr[0]);
			$("#ApplyDate").val(arr2[0]);
			$("#ApplyFloor").val(arr2[1]);
			$("#ApplyContent1").val(arr2[2]);
			$("#ApplyContent2").val(arr2[3]);
		}
	});
}

</script>

<?php
$db1 = new DB;
$db1->query("SELECT * FROM `maintenance_area` ORDER BY `areaName` ASC");
$areatxt = ":";
for ($i=0;$i<$db1->num_rows();$i++) {
	$r1 = $db1->fetch_assoc();
	if ($areatxt!=NULL) { $areatxt .= ";"; }
	$areatxt .= $r1['areaID'].":".$r1['areaName'];
}

$db2 = new DB2;
$db2->query("SELECT * FROM `userinfo` WHERE `OrgID`='".$_SESSION['nOrgID_lwj']."'");
$usertxt = ":";
for ($i=0;$i<$db2->num_rows();$i++) {
	$r2 = $db2->fetch_assoc();
	if ($usertxt!=NULL) { $usertxt .= ";"; }
	//$usertxt .= $r2['userID'].":".str_replace("&#20931;","凃",$r2['name']);
	//$usertxt .= $r2['userID'].":".str_replace(";","",$r2['name']);
	$usertxt .= $r2['userID'].":".str_replace(";","",$r2['name']);
}
$statustxt = "0:Unprocessed;1:Processing;2:Processed";
?>
<div id="dialog-form" title="Repairment Apply" class="dialog-form"> 
  <form>
  <fieldset>
    <table>
      <tr onmouseover="this.style.background='#fec'" onmouseout="this.style.background=''">
        <td class="title">Date of requisition</td>
        <td><input type="text" name="ApplyDate" id="ApplyDate" value="<?php echo date("Y/m/d"); ?>" size="12" readonly /></td>
      </tr>
      <tr onmouseover="this.style.background='#fec'" onmouseout="this.style.background=''">
        <td class="title">Floor/area</td>
        <td><select id="lbllevel1" onchange="document.getElementById('ApplyFloor').value = this.options[this.selectedIndex].text">
          <?php
		  $arrFloor = explode(";",$areatxt);
		  foreach ($arrFloor as $k=>$v) {
			  $arrFloor2 = explode(":",$v);
			  echo '<option value="'.$arrFloor2[0].'">'.$arrFloor2[1].'</option>'."\n";
		  }
		  ?>
        </select><br /><input type="text" name="ApplyFloor" id="ApplyFloor" size="60" />
        
        </td>
      </tr>
      <tr onmouseover="this.style.background='#fec'" onmouseout="this.style.background=''">
        <td class="title">Damaged item(s)</td>
        <td><div id="2nd"></div>
        <input type="text" name="ApplyContent1" id="ApplyContent1" size="60">
        </td>
      </tr>
      <tr onmouseover="this.style.background='#fec'" onmouseout="this.style.background=''">
        <td class="title">Damaged scenarios</td>
        <td><select name="select" onchange="document.getElementById('ApplyContent2').value = this.options[this.selectedIndex].text">
          <option></option>
          <?php
		  $db3 = new DB;
		  $db3->query("SELECT * FROM `maintenance_phrase1` ORDER BY `phraseID` ASC");
		  for ($i=0;$i<$db3->num_rows();$i++) {
			  $r3 = $db3->fetch_assoc();
			  echo '<option value="'.$r3['phraseID'].'">'.$r3['content'].'</option>'."\n";
		  }
		  ?>
        </select><br /><input type="text" name="ApplyContent2" id="ApplyContent2" size="60"></td>
      </tr>
       <input type="hidden" name="Applicant" id="Applicant" value="<?php echo $_SESSION['ncareID_lwj']; ?>">
    </table>
  </fieldset>
  </form>
</div>

<div style="background-color: rgba(255,255,255,0.8); border-radius: 10px; padding:10px 10px 30px 10px; margin-bottom: 20px;">
<table style="100%;">
  <tr>
    <td align="left"><form><input type="button" id="newrecord" value="Repairment apply" style="height:32px;" onclick="openVerificationForm('#dialog-form');"/></form></td>
    <td align="right"><form>Date:<script> $(function() { $( "#date1" ).datepicker({ dateFormat: 'yy/mm/dd' }); }); </script><script> $(function() { $( "#date2" ).datepicker({ dateFormat: 'yy/mm/dd' }); }); </script><input type="text" id="date1" value="<?php echo date('Y/m/d'); ?>" size="10" />~<input type="text" id="date2" value="<?php echo date('Y/m/d'); ?>" size="10" /> Status:<select id="status"><option value="0">Unprocessed</option><option value="1">Processing</option><option value="2">Processed</option><option value="4">All</option></select> Sort:<select id="order"><option value="0">Ungrouped count</option><option value="1">Sort by floor</option><option value="2">Sort by item</option><option value="3">Sort by date of application</option><option value="4">Sort by date of repairment</option></select><input type="button" id="print" value="Print" onclick="window.open('printnotrepaired.php?date1='+document.getElementById('date1').value+'&date2='+document.getElementById('date2').value+'&status='+document.getElementById('status').selectedIndex+'&order='+document.getElementById('order').selectedIndex)" /><?php if ($_SESSION['ncareGroup_lwj']==1 || $_SESSION['ncareGroup_lwj']==8 || $_SESSION['ncareGroup_lwj']==9) { ?> <input type="button" value="Routine service / maintenance record" onclick="window.location.href='index.php?mod=maintenance&func=formview&id=1'" /><?php } ?></form></td>
  </tr>
  <tr>
  	<td>
  		
  	</td>
  </tr>
</table>
<?php
$db4 = new DB;
$db4->query("SELECT *, CASE `status` WHEN 0 THEN 'Unprocessed' WHEN 1 THEN 'Processing' END statustxt FROM `maintenance` WHERE status='0' OR status='1'");
?>
<table id="maintenancetable" class="hover">
	<thead>
	<tr class="title" >
        <td width="100">ID #</td>
        <td width="50">Status</td>
        <td width="75">Date of requisition</td>
        <td>Floor/area</td>
        <td>Damaged item(s)</td>
        <td>Damaged scenarios</td>
        <td>Applicant</td>
        <td width="75">Repair date</td>
        <td>Process</td>
        <td>Repaired by</td>
    </tr>
    </thead>
<?php
if ($db4->num_rows() > 0){
	for($i=0;$i<$db4->num_rows();$i++){
		$r4 = $db4->fetch_assoc();
		$link ="";
		if($r4['status']==0 && ($_SESSION['ncareLevel_lwj']==5 || $r4['Applicant']==$_SESSION['ncareID_lwj'])){
			$link = '<a href="javascript:void(0);" title="Edit" onclick="editRecord(\''.$r4['mainID'].'\')"><i class="fa fa-magic fa-lg"></i></a>&nbsp;';
		}
		if ($_SESSION['ncareGroup_lwj']==1 || $_SESSION['ncareGroup_lwj']==8 || $_SESSION['ncareGroup_lwj']==9) {
			$link .= '<a href="index.php?mainID='.$r4['mainID'].'&func=maintenance_repair">'.$r4['mainID'].'</a>';
		} else{
			$link .= $r4['mainID'];
		}
		$arrContent = explode("_",$r4['ApplyContent1']);
		foreach ($arrContent as $k=>$v){
			if(count($arrContent) ==2){
				$content = getTitle("property","p_name",$arrContent[0],"propertyID","p_no").($arrContent[1] !=""?"，".$arrContent[1]:"");
			} else{
				$content = $r4['ApplyContent1'];
			}
		}
		echo '<tr  class="link1">
			<td>'.$link.'</td>
			<td>'.$r4['statustxt'].'</td>
			<td>'.$r4['ApplyDate'].'</td>
			<td>'.$r4['ApplyFloor'].'</td>
			<td>'.str_replace("undefined","",$content).'</td>
			<td>'.$r4['ApplyContent2'].'</td>
			<td>'.checkusername($r4['Applicant']).'</td>
			<td>'.$r4['RepairDate'].'</td>
			<td>'.$r4['RepairContent'].'</td>
			<td>'.checkusername($r4['Repairer']).'</td>
		</tr>';
	}
}
?>    
</table>
</div>


<script>
$(function(){
  $('#lbllevel1').change(function() {
	  getLevel2();
  });
  $('#maintenancetable').dataTable({
	  "pageLength": 50
  });
});
function getLevel2() {
  $.ajax({
	  url: "class/chainedSelect.php",
	  type: "POST",
	  data: { 
		  "table":'property',					//資料表
		  "lbllevel1":'areaID',					//分類欄位名稱
		  "lbllevel1ID":$("#lbllevel1").val(),	//分類欄位代碼
		  "moduleName":'p_name',				//顯示欄位名稱
		  "moduleID":'p_no',					//顯示欄位代碼
		  "autoID":'propertyID',				//流水號
		  "display":true						//是否顯示moduleID
	  },
	  success: function(data) {
		  $("#2nd").html(data);
	  }
  });
}
</script>

