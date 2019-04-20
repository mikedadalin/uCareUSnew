<form align="right">
<i class="fa fa-magic" style="float:left;" id="see"></i>
<script>$(function() { $('#date').datepicker(); });</script>
<script>$(function() { $('#date1').datepicker(); });</script>
<i class="fa fa-calendar"></i> Search by date:
<input type="text" name="date" id="date" size="11" value="<?php echo ($_GET['date']==NULL?date("Y/m/01"):$_GET['date']); ?>">～
<input type="text" name="date1" id="date1" size="11" value="<?php echo ($_GET['date1']==NULL?date("Y/m/t"):$_GET['date1']); ?>"><input type="button" value="Search" onclick="window.location.href='index.php?mod=humanresource&func=formview&id=5&view=1&date='+document.getElementById('date').value+'&date1='+document.getElementById('date1').value">
<input type="button" value="Transfer" id="Export">
</form>
<table id="hr05">
<thead>
<tr class="title">
  <th id="f1">Function</th>  
  <th>Full name</th>
  <th>Punch in time</th>
  <th>Punch out time</th>
  <th>Lunch break</th>
  <th>Number of hours</th>
</tr>
</thead>
<?php
if ($_GET['date']!="") { 
	$strQry = " WHERE (DATE_FORMAT(`startdate`,'%Y/%m/%d') >='".mysql_escape_string($_GET['date'])."' AND DATE_FORMAT(`startdate`,'%Y/%m/%d') <='".mysql_escape_string($_GET['date1'])."')"; 
	$strQry .= "  OR  (DATE_FORMAT(`enddate`,'%Y/%m/%d') >='".mysql_escape_string($_GET['date'])."' AND DATE_FORMAT(`enddate`,'%Y/%m/%d') <='".mysql_escape_string($_GET['date1'])."') "; 
}else{
	$strQry = "WHERE DATE_FORMAT(`startdate`, '%Y-%m')='".date("Y-m")."' OR DATE_FORMAT(`enddate`, '%Y-%m')='".date("Y-m")."' ";
}
$sql1 = "SELECT * FROM `humanresource11` ".$strQry." ORDER BY `workID` ASC";
//echo $sql1;
$db = new DB;
$db->query($sql1);
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	echo '
<tr>
  <td width="8%" class="link1" id="f2'.$r['workID'].'"><a onclick="changeinfo(\''.getEmpName($r['EmpID'], $r['EmpGroup']).'\',\''.$r['workID'].'\',\''.$r['startdate'].'\',\''.$r['enddate'].'\')" title="修改上下班時間"><i class="fa fa-pencil fa-lg"></i></span></td>
  <td width="20%">'.getEmpName($r['EmpID'], $r['EmpGroup']).'</td>
  <td width="20%">'.$r['startdate'].'</td>
  <td width="20%">'.$r['enddate'].'</td>
  <td width="20%">'.$r['noon'].'</td>
  <td width="20%" align="center">'.($r['enddate']!="0000-00-00 00:00:00"?floor((strtotime($r['enddate'])-strtotime($r['startdate']))/3660):"---").'</td>
</tr>'."\n";
}
?>
</table>
<div id="changeinfoform" title="修改上下班時間" class="dialog-form"> 
  <form>
  <fieldset>
    <table>
      <tr>
        <td class="title">Full name</td>
        <td id="name"></td>
      </tr>
      <tr>
        <td class="title">Punch in time</td>
        <td><input type="text" name="startdate" id="startdate" value="" size="20" maxlength="19"></td>
      </tr>
      <tr>
        <td class="title">Punch out time</td>
        <td><input type="text" name="enddate" id="enddate" value="" size="20" maxlength="19"></td>
      </tr>
    </table>
  </fieldset>
  <input type="hidden" id="osdate">
  <input type="hidden" id="oedate">
  </form>
</div>
<script>
$(function() {
	$("#f1").hide();
	$('td[id^=f2]').hide();
	$("#see").click(function(){
		$("#f1").toggle();
		$('td[id^=f2]').toggle();
	});
	$("#startdate").datetimepicker({
		lang:'ch',
		format:'Y-m-d H:i:s',
		mask:true
	});
	$("#enddate").datetimepicker({
		lang:'ch',
		format:'Y-m-d H:i:s',
		mask:true
	});
	$('#hr05').dataTable({
		"autoWidth": true,
		"order": [[2, "desc"]],
		"pageLength": 20
	});
	$("#Export").click(function(){
		if(confirm('轉出日期為'+$('#date').val()+'~'+$('#date1').val()+'，且會覆蓋已儲存相同時間點的打卡資料，確定執行？')){
			$.ajax({
			url: "class/changeinfo.php",
			type: "POST",
			data: {"Export":'Y',"date":$("#date").val(),"date1":$("#date1").val()},
				success: function(data) {
					if (data=="OK") {
						alert("資料轉出成功！");
						window.location.reload();
					}
				}
			});
		}else{
			return false;
		}
	});
    $( "#changeinfoform" ).dialog({
		autoOpen: false,
		height: 300,
		width: 380,
		modal: true,
		buttons: {
			"Information Modification": function() {
				$.ajax({
				url: "class/changeinfo.php",
				type: "POST",
				data: {
					"colID": 'workID',
					"autoID":$(this).data('workID'),
					"startdate":$("#startdate").val(),
					"enddate":$("#enddate").val(),
					"formID":'humanresource11',
					"osdate":$("#osdate").val(),
					"oedate":$("#oedate").val()},
					success: function(data) {
						if (data=="OK") {
							$( "#changeinfoform" ).dialog( "close" );
							alert("Modify success!");
							window.location.reload();
						}
					}
				});
			},
			"Cancel": function() {
				$( "#changeinfoform" ).dialog( "close" );
			}
		}
	});
	
});
function changeinfo(name,workID,sdate,edate) {
	$("#name").html(name);
	$("#startdate").val(sdate);
	$("#enddate").val(edate);
	$("#osdate").val(sdate);
	$("#oedate").val(edate);
	$("#changeinfoform").data('workID',workID).dialog("open");
}
</script>