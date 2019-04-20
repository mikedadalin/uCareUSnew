<?php
//include_once("class/DB3.php");
?>
<script>
$(function() {
	$( "#newrecordform" ).dialog({
		autoOpen: false,
		height: 330,
		width: 570,
		modal: true,
		buttons: {
			"New Item": function() {
				$.ajax({
					url: "class/STKORD.php",
					type: "POST",
					data: { "ORDSEQ": '<?php echo @$_GET['ORDSEQ']; ?>', "STK_NO": $('#STK_NO_txt').val(), "ORDQTY": $('#ORD_QTY').val() },
					success: function(data) {
						var arr = data.split("||");
						window.location.reload();
					}
				});
			},
			"Cancel": function() {
				$( "#newrecordform" ).dialog( "close" );
			}
		}
	});
});
</script>
<div id="newrecordform" title="New Item" class="dialog-form">
	<fieldset>
		<table>
			<script>
			function changecate() {
				$.ajax({
					url: "class/searchSTK1a.php",
					type: "POST",
					data: {"KIND": $("#STK_KIND2").val() },
					success: function(data) {
						document.getElementById('STK_SELECT').options.length = 0;
						var arr = data.split(";");
						document.getElementById('STK_SELECT').options[0] = new Option('','');
						for (var i = 0; i < (arr.length-1); i++) {
							var productinfo = arr[i];
							var arr1 = productinfo.split("||");
							document.getElementById('STK_SELECT').options[(i+1)] = new Option(arr1[1],arr1[0]);
						}
					}
				});
			}
			function selectproduct() {
				$.ajax({
					url: "class/searchSTK2.php",
					type: "POST",
					data: {"STK_SELECT": $("#STK_SELECT").val() },
					success: function(data) {
						var arr = data.split("||");
						$('#STK_NO').html(arr[0]);
						$('#STK_NAME').html(arr[1]);
						$('#STK_UNIT').html(arr[4]);
						$('#STK_NO_txt').val(arr[0]);
					}
				});
			}
			</script>
			<tr>
				<td class="title">Select item</td>
				<td>
					<select name="STK_KIND2" id="STK_KIND2" onchange="changecate()">
						<option></option>
						<?php
						$db4 = new DB;
						$db4->query("SELECT * FROM `applyitemcate` ORDER BY `ID` ASC");
						for ($i4=0;$i4<$db4->num_rows();$i4++) {
							$r4 = $db4->fetch_assoc();
							echo '<option value="'.$r4['ID'].'">'.$r4['Name'].'</option>'."\n";
						}
						?>
					</select><br />
					<select name="STK_SELECT" id="STK_SELECT" onchange="selectproduct();">
						<option></option>
					</select>
				</tr>
		</table>
		<hr />
		<table width="100%">
			<tr>
				<td width="160" class="title">Item name</td>
				<td><span id="STK_NAME"></span><input type="hidden" name="STK_NO_txt" id="STK_NO_txt" /></td>
			</tr>
			<tr>
				<td class="title">Requested quantity</td>
				<td><input type="text" name="ORD_QTY" id="ORD_QTY" size="3"/> <span id="STK_UNIT"></span></td>
			</tr>
		</table>
	</fieldset>
</div>
	<?php
	$db = new DB;
	$db->query("SELECT `patientID`,`HospNo`,`Birth` FROM `patient` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."'");
	for ($i=0;$i<$db->num_rows();$i++) {
		$r = $db->fetch_assoc();
		$db1 = new DB;
		$db1->query("SELECT `bed`,`indate` FROM `inpatientinfo` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."'");
		$r1 = $db1->fetch_assoc();
		$name = getPatientName($r['patientID']);
		$birth = formatdate($r['Birth']);
		$indate = formatdate($r1['indate']);
		$HospNo = $r['HospNo'];
		$bedID = $r1['bed'];
		$db2 = new DB;
		$db2->query("SELECT `Qdiag1`, `Qdiag2`, `Qdiag3`, `Qdiag4`, `Qdiag5`, `Qdiag6`, `Qdiag7`, `Qdiag8` FROM `nurseform01` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1");
		$r2 = $db2->fetch_assoc();
		for ($j=1;$j<=8;$j++) { if ($r2['Qdiag'.$j]!=NULL) { $diagMsg .= $r2['Qdiag'.$j].', '; } }
			$diagMsg = substr($diagMsg, 0, strlen($diagMsg)-2);
	}
	?>
	<div class="content-query">
		<table align="left"  width="882" style="font-size:10pt; margin-left:0px;">
			<tr id="backtr"  style="border:none; height:32px;" >
				<td class="title" width="70" style="border-top-left-radius:10px; background-color:#eecb35;">Bed #</td>
				<td width="90" style="border:none;"><?php echo $bedID; ?></td>   
				<td class="title" width="70" style="border:none;">Name</td>
				<td width="90" style="border:none;"><?php echo $name; ?></td>
				<td class="title" width="70" style="border:none;">Care ID#</td>
				<td width="90" style="border:none;"><?php echo $HospNo; ?></td>
				<td class="title" width="70" style="border:none;">DOB</td>
				<td  style="border-top-right-radius:10px;"><?php echo $birth.' ('.checkgender(mysql_escape_string($_GET['pid'])).', '.calcage(str_replace('/','',$birth)).')'; ?></td>
			</tr>
			<tr style="border:none; height:20px;" >
				<td class="title" style="border-bottom-left-radius:10px;">Admission Date</td>
				<td style="border:none;"><?php echo $indate; ?></td>
				<td class="title" style="border:none;">Diagnosis</td>
				<td style="border-bottom-right-radius:10px;" colspan="5"><?php echo $diagMsg; ?></td>
			</tr>
		</table>
	</div>
	&nbsp;<h3 style="margin-top:0px;">Items Requisitions</h3>
	<form  method="post">
		<div align="left" style="float:left;">
			<input type="button" value="New Item" id="add" onclick="openVerificationForm('#newrecordform');"/>
		</div>
	</form>
	<div align="right">
		<form>
			<input type="button" value="Back to list" onclick="window.location.href='index.php?mod=consump&func=formview&id=3&pid=<?php echo @$_GET['pid']; ?>'">
		</form>
	</div>
	<table width="100%" id="newformtable">
		<tr class="title">
			<td>ID #</td>
			<td>Name</td>
			<td>Quantity</td>
			<td>Unit</td>
			<td>Delete</td>
		</tr>
		<?php
		$db3 = new DB;
		$db3->query("SELECT * FROM `arkord` WHERE `ORD_SEQ`='".mysql_escape_string($_GET['ORDSEQ'])."' ORDER BY `ORD_SEQ1` ASC");
		for ($i=0;$i<$db3->num_rows();$i++) {
			$r3 = $db3->fetch_assoc();
			echo '
			<tr>
			<td align="center">'.$r3['STK_NO'].'</td>
			<td align="left">'.$r3['STK_NAME'].'</td>
			<td align="center"><input type="text" name="item_'.@$_GET['ORDSEQ'].'_'.$r3['ORD_SEQ1'].'" id="item_'.@$_GET['ORDSEQ'].'_'.$r3['ORD_SEQ1'].'" size="2" value="'.$r3['ORD_QTY'].'" /><input type="button" value="修改數量" onclick="modifyquat(\'item_'.@$_GET['ORDSEQ'].'_'.$r3['ORD_SEQ1'].'\');"></td>
			<td align="center">'.$r3['STK_UNIT'].'</td>
			<td align="center"><input type="button" value="刪除此筆資料"  onclick="if (confirm(\'確定刪除？\')) { deleteORDitem(\'item_'.@$_GET['ORDSEQ'].'_'.$r3['ORD_SEQ1'].'\'); }"></td>
			</tr>
			'."\n";
		}
		?>
		<tbody>
		</tbody>
	</table>
	<script>
	function modifyquat (id) {
	//var newquat = document.getElementById(id).value;
	$.ajax({
		url: "class/modifyquat.php",
		type: "POST",
		data: { "ORDID": id, "QTY": $('#'+id).val() },
		success: function(data) {
			if (data=="OK") {
				alert('Quantity modified !');
			} else {
				alert('Can not be modified');
			}
		}
	});
}

function deleteORDitem (id) {
	//var newquat = document.getElementById(id).value;
	$.ajax({
		url: "class/deleteORDitem.php",
		type: "POST",
		data: { "ORDID": id },
		success: function(data) {
			if (data=="OK") {
				alert('Successfully deleted!');
				window.location.reload();
			} else {
				alert('Unable to delete');
			}
		}
	});
}
</script>