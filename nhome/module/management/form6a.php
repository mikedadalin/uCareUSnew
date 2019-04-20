<script>
$(function() {
	$( "#dialog-form" ).dialog({
		autoOpen: false,
		height: 680, //750
		width: 1000,
		modal: true,
		buttons: {
			"Add record": function() {
				$.ajax({
					url: "class/nurseform06a.php",
					type: "POST",
					data: {"date": $("#date").val(), "time":$("#time").val(), "Qcate": $("#Qcate").val(), "Q1": $("#Q1").val(), "Q2": $("#Q2").val(), "Qcontent": $("#Qcontent").val(), "Qfiller": '<?php echo $_SESSION['ncareID_lwj']; ?>' },
					success: function(data) {
						if (data=="exist") {
							alert("This date and time of the meeting record that already exists, modify the date and time and then save!！");
						} else {
							$( "#dialog-form" ).dialog( "close" );
							alert("Add record sucessfully!");
							window.location.reload();
						}
					}
				});
			},
			"Cancel": function() {
				$( "#dialog-form" ).dialog( "close" );
				window.location.reload();
			}
		}
	});
	$( "#newrecord" ).button().click(function() {
		var id = "Qcontent";
		var instance = CKEDITOR.instances[id];
		if(instance) {
			CKEDITOR.remove(instance);
		}
		CKEDITOR.replace(id);
		openVerificationForm('#dialog-form');
	});
});
</script>
<h3>Administrative meeting record</h3>
<form action="index.php?func=database&action=save" style="width:100%">
	<div align="left"><input type="button" id="newrecord" value="New meeting minute" /></form></div>
	<div id="dialog-form" title="New meeting minute" class="dialog-form"> 
		<form>
			<fieldset>
				<table>
					<tr>
						<td class="title">Date/Time</td>
						<td><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php echo date(Y."/".m."/".d); ?>" size="12"> <input type="text" name="time" id="time" value="<?php echo date(Hi); ?>" size="4"> <font size="2">(Time format:HHmm)</font></td>
					</tr>
					<tr>
						<td class="title">Category</td>
						<td><select name="Qcate" id="Qcate">
							<option></option>
							<?php
							$db3 = new DB;
							$db3->query("SELECT * FROM `nurseform06a_cate` ORDER BY `order` ASC");
							$arrForm6aCate = array("0"=>"Not categorized");
							for ($i=0;$i<$db3->num_rows();$i++) {
								$r3 = $db3->fetch_assoc();
								$arrForm6aCate[$r3['ID']] = $r3['name'];
								echo '<option value="'.$r3['ID'].'">'.$r3['name'].'</option>';
							}
							?>
						</select></td>
					</tr>
					<tr>
						<td class="title">Attendee</td>
						<td><input type="text" name="Q1" id="Q1" value="" size="60"></td>
					</tr>
					<tr>
						<td class="title">Conference theme</td>
						<td><input type="text" name="Q2" id="Q2" value="" size="60"></td>
					</tr>
					<tr>
						<td class="title">Meeting minutes</td>
						<td><textarea name="Qcontent" id="Qcontent" cols="60" rows="14"></textarea></td>
					</tr>
				</table>
			</fieldset>
		</form>
	</div>
	<div id="tabs_6a">
		<ul style="margin:10px 0;">
			<?php
			foreach ($arrForm6aCate as $k1=>$v1) {
				echo '<li><a href="#tabs_6a_'.$k1.'">'.$v1.'</a></li>'."\n";
			}
			?>
		</ul>
		<?php
		foreach ($arrForm6aCate as $k1=>$v1) {
			?>
			<div id="tabs_6a_<?php echo $k1; ?>" style="font-size:11pt; margin:0px; width:100%;; padding:1px;">
				<table style="width:100%;" id="recordlist">
					<thead>
						<tr class="title">
							<td width="60">Select</td>
							<td width="80">Category</td>
							<td width="140">Date</td>
							<td>Conference theme</td>
							<td>Edit</td>
						</tr>
					</thead>
					<tbody>
						<?php
						$db2 = new DB;
						$db2->query("SELECT * FROM `nurseform06a` WHERE `Qcate`='".$k1."' ORDER BY `date` DESC, `time` DESC");
						for ($i=0;$i<$db2->num_rows();$i++) {
							$r2 = $db2->fetch_assoc();
							echo '
							<tr>
							<td><center><a href="index.php?mod=management&func=formview&id=6a_1&date='.$r2['date'].'&time='.$r2['time'].'&cate='.$r2['Qcate'].'"><img src="Images/edit_patient.png" width="20" border="0"></a></center></td>
							<td style="padding:5px 10px;"><center>'.$arrForm6aCate[$r2['Qcate']].'</center></td>
							<td align="center" style="padding:5px 10px;">'.formatdate($r2['date']).' '.substr($r2['time'],0,2).':'.substr($r2['time'],2,2).'</td>
							<td style="padding:5px 10px;">'.$r2['Q2'].'</td>
							<td>';
							if ($r2['Qfiller']==$_SESSION['ncareID_lwj'] || $_SESSION['ncareLevel_lwj']>=4) {
								echo '<center><a href="index.php?mod=management&func=formview&id=6a_2&date='.$r2['date'].'&time='.$r2['time'].'"><img src="Images/edit_icon.png" width="20" border="0"></a></center>';
							} else {
								echo '&nbsp;';
							}
							echo '</td>
							</tr>
							'."\n";
						}
						?>
					</tbody>
				</table>
			</div>
			<?php
		}
		?>
	</div><br>
	<script>$("#tabs_6a").tabs();</script>