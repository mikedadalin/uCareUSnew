<div class="nurseform-table" style="padding:20px;">	
	<div><h3>Nursing Diagnoses</h3></div>
	<table align="center">
		<tr>
			<td class="title">Domain</td>
			<td align="left">
				<select name="DomainID" id="DomainID">
					<option>-------------- Select --------------</option>
					<?
					$db = new DB2;
					$db->query("SELECT * FROM `diagnoses_domain` ORDER BY `DomainID` ASC");
					for ($i=0;$i<$db->num_rows();$i++) {
						$r = $db->fetch_assoc();
						echo '<option value="'.$r['DomainID'].'">'.$r['DomainName'].'</option>';
					}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td class="title">Classification</td>
			<td align="left">
				<select name="ClassID" id="ClassID" disabled>
					<option>--- Select Domain ---</option>
				</select>
			</td>
		</tr>
		<tr>
			<td class="title">Diagnoses</td>
			<td align="left">
				<select name="Code" id="Code" disabled>
					<option>--- Select Domain ---</option>
				</select>
			</td>
		</tr>
		<tr>
			<td class="title">NIC Code</td>
			<td align="left">
				<select name="CodeNumber" id="CodeNumber">
					<option>------------------------------- Select -------------------------------</option>
					<?
					$db2 = new DB2;
					$db2->query("SELECT * FROM `nic_code` ORDER BY `CodeNumber` ASC");
					for ($i2=0;$i2<$db2->num_rows();$i2++) {
						$r2 = $db2->fetch_assoc();
						echo '<option value="'.$r2['CodeNumber'].'">'.$r2['Code'].' --- '.$r2['Categorization'].'</option>';
					}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td class="title">Activity Select</td>
			<td align="left">
				<select name="ActivityNumber" id="ActivityNumber" disabled>
					<option>--- Select NIC Code ---</option>
				</select>
			</td>
		</tr>
		<tr>
			<td class="title">Activity CheckBox</td>
			<td align="left"><div><table><div id="Activity"></div></table></div></td>
		</tr>
	</table>
</div>
<script>
$(function() {
	$('#DomainID').change(function () {
		$.ajax({
			url: "class/Load_Diagnosese_Class.php",
			type: "POST",
			data: { "DomainID": $("#DomainID").val()},
			success: function(data) {
				var arr = data.split(';');
				$("#ClassID").attr("disabled",false);
				$("#ClassID").addClass("validate[required]");
				$("#ClassID option").remove();
				$("#ClassID").append($("<option></option>"));
				for (var i=0; i<arr.length; i++) {
					var arrdata = arr[i].split('_');
					$("#ClassID").append($("<option></option>").attr("value", arrdata[0]).text(arrdata[1]));
				}
				document.getElementById('Code').innerHTML = "<option>--- Select Classification ---</option>";
			}
		});
	});
	
	$('#ClassID').change(function () {
		$.ajax({
			url: "class/Load_Diagnosese_Code.php",
			type: "POST",
			data: { "DomainID": $("#DomainID").val(), "ClassID": $("#ClassID").val()},
			success: function(data) {
				var arr = data.split(';');
				$("#Code").attr("disabled",false);
				$("#Code").addClass("validate[required]");
				$("#Code option").remove();
				$("#Code").append($("<option></option>"));
				for (var i=0; i<arr.length; i++) {
					var arrdata = arr[i].split('_');
					$("#Code").append($("<option></option>").attr("value", arrdata[0]).text(arrdata[1]));
				}
			}
		});
	});
	
	$('#CodeNumber').change(function () {
		var Activity ='';
		var Activity_CheckBox ='';
		$.ajax({
			url: "class/Load_NIC_Activity.php",
			type: "POST",
			data: { "CodeNumber": $("#CodeNumber").val()},
			success: function(data) {
				var arr = data.split(';');
				$("#ActivityNumber").attr("disabled",false);
				$("#ActivityNumber").addClass("validate[required]");
				$("#ActivityNumber option").remove();
				$("#ActivityNumber").append($("<option></option>"));
				for (var i=0; i<arr.length; i++) {
					var arrdata = arr[i].split('_');
					$("#ActivityNumber").append($("<option></option>").attr("value", arrdata[0]).text(arrdata[1]));
					if(Activity!=''){ Activity = Activity +';'; }
					if(arrdata[1]!=null){
						Activity = Activity + arrdata[1];
					}
				}
				var arrActivity = Activity.split(';');
				for (var i2=0; i2<arr.length; i2++) {
					var arrdata2 = arr[i2].split('_');
					if(arrdata2[1]!=null){
						Activity_CheckBox = Activity_CheckBox + '<tr>';
						Activity_CheckBox = Activity_CheckBox + '<input type="hidden" name="Activity_' + eval(i2+1) + '" id="Activity_' + eval(i2+1) + '" value="1">';
						Activity_CheckBox = Activity_CheckBox + '<td width="40">';
						Activity_CheckBox = Activity_CheckBox + '<button type="button" class="checkbox_on" onclick="click_multi_checkbox2(this.id,\'Activity\',\''+ arrActivity.length +'\');" id="btn_Activity_'+ eval(i2+1) +'"><font style="color:white;">✔</font></button>';
						Activity_CheckBox = Activity_CheckBox + '</td>';
						Activity_CheckBox = Activity_CheckBox + '<td> '+ arrdata2[1] +'</td>';
						Activity_CheckBox = Activity_CheckBox + '</tr><br>';
					}
				}
				document.getElementById('Activity').innerHTML = Activity_CheckBox;
			}
		});
	});
});
</script>