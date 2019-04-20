<form align="right">
<i class="fa fa-magic" style="float:left;" id="see_2"></i>
<script>$(function() { $('#date_2').datepicker(); });</script>
<script>$(function() { $('#date1_2').datepicker(); });</script>
<i class="fa fa-calendar"></i> Search by date:
<input type="text" name="date_2" id="date_2" size="11" value="<?php echo ($_GET['date_2']==NULL?date("Y/m/01"):$_GET['date_2']); ?>">～
<input type="text" name="date1_2" id="date1_2" size="11" value="<?php echo ($_GET['date1_2']==NULL?date("Y/m/t"):$_GET['date1_2']); ?>"><input type="button" value="Search" onclick="window.location.href='index.php?mod=humanresource&func=formview&id=5&view=2&date_2='+document.getElementById('date_2').value+'&date1_2='+document.getElementById('date1_2').value">
</form>
<table id="hr05_2">
<thead>
<tr class="title">
  <th id="f1_2">Function</th>  
  <th>Full name</th>
  <th>Punch in time</th>
  <th>Punch out time</th>
  <th>Number of hours</th>
</tr>
</thead>
<?php
if ($_GET['date_2']!="") { 
	$strQry = " WHERE (DATE_FORMAT(`startdate`,'%Y/%m/%d') >='".mysql_escape_string($_GET['date_2'])."' AND DATE_FORMAT(`startdate`,'%Y/%m/%d') <='".mysql_escape_string($_GET['date_2'])."')";
}else{
	$strQry = "WHERE DATE_FORMAT(`startdate`, '%Y-%m')='".date("Y-m")."'";
}
$sql1 = "SELECT * FROM `humanresource11` ".$strQry." ORDER BY `workID` ASC";
//echo $sql1;
$db = new DB;
$db->query($sql1);
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	echo '
<tr>
  <td width="8%" class="link1" id="f2_2'.$r['workID'].'"><a onclick="changeinfo2(\''.getEmpName($r['EmpID'], $r['EmpGroup']).'\',\''.$r['workID'].'\',\''.$r['startdate'].'\',\''.$r['enddate'].'\')" title="修改上下班時間"><i class="fa fa-pencil fa-lg"></i></span></td>
  <td width="20%">'.getEmpName($r['EmpID'], $r['EmpGroup']).'</td>
  <td width="30%">'.$r['startdate'].'</td>
  <td width="30%">'.$r['enddate'].'</td>
  <td width="8%" align="center">'.($r['enddate']!="0000-00-00 00:00:00"?floor((strtotime($r['enddate'])-strtotime($r['startdate']))/3660):"---").'</td>
</tr>'."\n";
}
?>
</table>
<div id="changeinfoform_2" title="修改上下班時間" class="dialog-form"> 
  <form>
  <fieldset>
    <table>
      <tr>
        <td class="title">Full name</td>
        <td id="name_2"></td>
      </tr>
      <tr>
        <td class="title">Punch in time</td>
        <td><input type="text" name="startdate_2" id="startdate_2" value="" size="20" maxlength="19"></td>
      </tr>
      <tr>
        <td class="title">Punch out time</td>
        <td><input type="text" name="enddate_2" id="enddate_2" value="" size="20" maxlength="19"></td>
      </tr>
    </table>
  </fieldset>
  </form>
</div>
<script>
$(function() {
	$("#f1_2").hide();
	$('td[id^=f2_2]').hide();
	$("#see_2").click(function(){
		$("#f1_2").toggle();
		$('td[id^=f2_2]').toggle();
	});
	$("#startdate_2").datetimepicker({
		lang:'ch',
		format:'Y-m-d H:i:s',
		mask:true
	});
	$("#enddate_2").datetimepicker({
		lang:'ch',
		format:'Y-m-d H:i:s',
		mask:true
	});
	$('#hr05_2').dataTable({
		"autoWidth": true,
		"order": [[2, "desc"]],
		"pageLength": 20
	});
    $( "#changeinfoform_2" ).dialog({
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
					"startdate":$("#startdate_2").val(),
					"enddate":$("#enddate_2").val(),
					"formID":'humanresource11_1'},
					success: function(data) {
						if (data=="OK") {
							$( "#changeinfoform_2" ).dialog( "close" );
							alert("Modify success!");
							window.location.href="index.php?mod=humanresource&func=formview&id=5&view=2";
						}
					}
				});
			},
			"Cancel": function() {
				$( "#changeinfoform_2" ).dialog( "close" );
			}
		}
	});
	
});
function changeinfo2(name,workID,sdate,edate) {
	$("#name_2").html(name);
	$("#startdate_2").val(sdate);
	$("#enddate_2").val(edate);
	$("#changeinfoform_2").data('workID',workID).dialog("open");
}
</script>