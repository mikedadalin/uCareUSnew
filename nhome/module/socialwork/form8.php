<div style="background-color: rgba(255,255,255,0.8); border-radius: 10px; padding:10px 10px 30px 10px; margin-bottom: 20px;">
	<h3>Group activities schedule</h3>
	<div style="float:left;">
		<form>
			<input type="button" value="New activity schedule" onclick="window.location.href='index.php?mod=socialwork&func=formview&id=8a'" />
			<input type="button" value="Modify activity category" onclick="window.location.href='index.php?mod=socialwork&func=formview&id=8c'" />
		</form>
	</div>
	<div class="printcol" style="float:right;">
		<select id="selmonth">
			<option>--Select month--</option>
			<?php
			$nextmonth = date(m)+1; if ($nextmonth>12) { $nextmonth = 1; $nextyear = date(Y)+1; } else { $nextyear = date(Y); }
			if (strlen($nextmonth)==1) { $nextmonth = "0".$nextmonth; }
			echo '<option value="'.$nextyear.$nextmonth.'">'.$nextyear.'-'.$nextmonth.'</option>'."\n";
			for ($i=date(m);$i>=(date(m)-5);$i--) {
				$month = $i;
				$year = date(Y);
				if ($i<1) {
					$month = 12+$i;
					$year = date(Y)-1;
				}
				if (strlen($month)==1) {
					$month = "0".$month;
				}
				echo '<option value="'.$year.$month.'">'.$year.'-'.$month.'</option>'."\n";
			}
			?>
		</select>
		<input type="image" src="Images/print.png" onclick="printreport()">
		<script>
		function printreport() {
			var selectedmonth = document.getElementById('selmonth').value;
			window.open('printsocialform08.php?date='+selectedmonth, '_blank' );
		}

		</script>
	</div>
	<table style="width:100%;" id="newrecordtable">
		<thead><tr class="title">
			<th>Date</th>
			<th>Activity</th>
			<th>Number of participants</th>
			<th>Established by</th>
			<th>Modified by</th>
			<th class="printcol" width="220">Function</th>
		</tr></thead>
		<?php
		$db1 = new DB;
		$db1->query("SELECT * FROM `socialform08` ORDER BY `date` DESC, `actID` ASC");
		for ($i1=0;$i1<$db1->num_rows();$i1++) {
			$r1 = $db1->fetch_assoc();
			$arrHospNo = explode(";",$r1['HospNo']);
			$db1a = new DB;
			$db1a->query("SELECT * FROM `socialform08_act` WHERE `actID`='".$r1['actID']."'");
			$r1a = $db1a->fetch_assoc();
			echo '
			<tr>
			<td align="center">'.formatdate($r1['date']).'</td>
			<td align="center">'.$r1a['cateName'].' - '.$r1a['actName'].'</td>
			<td align="center">'.count($arrHospNo).'</td>
			<td align="center">'.checkusername($r1['Qfiller']).'</td>
			<td align="center">'.checkusername($r1['cUser']).'</td>
			<td align="center" class="printcol"><a href="index.php?mod=socialwork&func=formview&id=8b&actNo='.$r1['actNo'].'" title="Edit group activity"><img src="Images/edit_icon.png" width="30"></a> <img src="Images/delete2.png" width="30" title="Delete group activity" style="cursor:pointer;" id="deleteAct_'.$r1['actNo'].'" onclick="deleteDialog(this.id);"> <a href="index.php?mod=socialwork&func=formview&id=8_1b&actNo='.$r1['actNo'].'" title="Group activities record"><img src="Images/note.png" width="30"></a> <a href="index.php?mod=socialwork&func=formview&id=8d&actNo='.$r1['actNo'].'" title="Photos"><img src="Images/photo_camera.png" width="30"></a> <img src="Images/printer.png" id="printAct_'.$r1['actNo'].'" style="cursor:pointer;" title="Print" width="30" onclick="printDialog(this.id);"> <img src="Images/add_pages.png" id="copyAct_'.$r1['actNo'].'" style="cursor:pointer;" title="Copy this activity" width="30" onclick="copyDialog(this.id);"></td>
			</tr>
			'."\n";
		}
		?>
	</table>
	<div id="dialog-change" title="Copy resident's group activities schedule" class="dialog-form">
		<form>
		<fieldset>
			<table>
				<tr>
					<td class="title">Schedule date</td>
					<td><script> $(function() { $( "#newdate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="newdate" id="newdate" value="<?php echo date("Y/m/d"); ?>" size="12"></td>
				</tr>
			</table>    	
			<input type="hidden" id="oldactNo" name="oldactNo">
		</fieldset>
		</form>
	</div>
</div>
<script>
$(function() {
	$('#newrecordtable').dataTable({
		order: [[0,"desc"]]
	});
	$( "#dialog-change" ).dialog({
		autoOpen: false,
		height: 210,
		width: 330,
		modal: true,
		buttons: {
			"Confirm copy": function() {
				$.ajax({
					url: "class/copyform.php",
					type: "POST",
					data: {	"colid"  : $("#oldactNo").val(),
					"colName": "actNo", 
					"date"   : $("#newdate").val(),
					"formID" : "socialform08;socialform08a",
					"Qfiller": '<?php echo $_SESSION['ncareID_lwj']; ?>'},
					success: function(data) {
						//console.log(data);
						$( "#dialog-change" ).dialog( "close" );
						if (data=="OK") {
							alert("Schedule copied");
						}
						document.location.reload(true);
					}
				});
			},
			"Cancel": function() {
				$( "#dialog-change" ).dialog( "close" );
				document.location.reload(true);
			}
		}
	});
});
function copyDialog(id) {
	var id1 = id.split('_');
	$( "#dialog-change" ).dialog( "open" );
	$("#oldactNo").val(id1[1]);
}
function printDialog(id) {
	var id1 = id.split('_');
	var $dialog = $('<div title="Print" class="dialog-form"><table width="100%"><tr><td class="title">Select the form to print</td></tr></table></div>').dialog({
		buttons: [{
			text: "Print schedule",
			click: function(){
				window.open("printsocialworkAct.php?mod=socialwork&func=formview&id=8b&actNo="+id1[1]);
				$dialog.remove();
			}
		},
		{
			text: "Print record",
			click: function(){
				window.open("printsocialworkAct1.php?mod=socialwork&func=formview&id=8b&actNo="+id1[1]);
				$dialog.remove();
			}
		}]
	});	
}
function deleteDialog(id){
	var id2 = id.split('_');
	//id[1]
	if (confirm('確認刪除此筆活動資料？')) {
		$.ajax({
			url: "class/deleteSocialform8.php",
			type: "post",
			data: { "actNo": id2[1] },
			success: function(data) {
				if (data=="OK") {
					alert('已成功刪除！');
					window.location.reload();
				}
			}
		});
	}
}
</script>
