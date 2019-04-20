<script type="text/javascript" src="js/LWJ_showInsuranceInfo.js"></script>
<div class="nurseform-table" style="padding:20px;">	
	<div><h3>Insurance List</h3></div>
	<table align="center"><tr style="background-color:rgba(0,0,0,0);"><td>
	<div align="left">
		<font style="color:yellow;">Select Month: </font>
		<select>
		<?php
		for($i=-12;$i<12;$i++){
			$years = date("Y");
			$months = date("m");
			$date = date("Y-m",mktime(0,0,0,$months+$i,1,$years));
			echo '<option value="'.$date.'">'.$date.'</option>';
		}
		?>
		</select>
	</div>
	<div align="center">
		<?php
		$db8 = new DB;
		$db8->query("SELECT * FROM `areainfo` ORDER BY `areaID` ASC");
		$Area_number = 0;
		$area_option = '';
		if ($db8->num_rows()>0) {
			for ($i8=0;$i8<$db8->num_rows();$i8++) {
				$r8 = $db8->fetch_assoc();
				if($i8!=0){ $area_option .= ";";}
				$area_option .=  $r8['areaName'];
				$Area_number++;
			}
		}
		$tab_number = ceil($i8/2);
		echo draw_option("AreaPage",$area_option,"xm","single",1,true,$tab_number);
		?>
	</div>
	<div>
		<?php
		$db = new DB;
		$db->query("SELECT * FROM `areainfo` ORDER BY `areaID` ASC");
		if ($db->num_rows()>0) {
			for ($i=0;$i<$db->num_rows();$i++) {
				$r = $db->fetch_assoc();
				$db2 = new DB;
				$db2->query("SELECT * FROM `bedinfo` WHERE `Area`='".$r['areaID']."' ORDER BY `bedID` ASC");
				$db6 = new DB;
				$db6->query("SELECT * FROM `bedinfo` WHERE `Area`='".$r['areaID']."' ORDER BY `bedID` ASC");
				if ($db2->num_rows()>0) {
					for ($i2=0;$i2<$db2->num_rows();$i2++) {
						$r2 = $db2->fetch_assoc();
						$db3 = new DB;
						$db3->query("SELECT `patientID` FROM `inpatientinfo` WHERE `bed`='".$r2['bedID']."'");
						if ($db3->num_rows()>0) {
							$r3 = $db3->fetch_assoc();
							$HospNo = getHospNo($r3['patientID']);
							$name = getPatientName($r3['patientID']);
							$bed_status = 'In use';
							$TotalMoney = 0;
							for($i5=1;$i5<6;$i5++){
								$db4 = new DB;
								$db4->query("SELECT * FROM `insurance` WHERE `HospNo`='".$HospNo."' AND `InsuranceNo`='".$i5."'");
								if($db4->num_rows()>0){
									$r4 = $db4->fetch_assoc();
									echo '<div name="InsuranceInfo_'.$i5.'" id="InsuranceInfo_'.$i5.'" style="display:none; z-index:999; position:fixed; background-color:rgba(0,0,0,0.7); color:yellow; text-align:left;"><div style="padding:7px;">'.formatdate($r4['PeriodStart']).'~'.formatdate($r4['PeriodEnd']).'<br>Amount: '.$r4['Amount'].'<br>Bill Time: '.formatdate($r4['BillTime']).'</div></div>';
									${"Insurance_".$i5} = '<button type="button" style="background-color:rgba(0,0,0,0); text-align:left;" id="EditRecord_Insurance_'.$i5.'_'.$HospNo.'_'.$name.'" onmouseover="showInsuranceInfo(\''.$i5.'\');" onmouseout="hiddenInsuranceInfo(\''.$i5.'\');"><i class="fa fa-pencil fa-lg"></i> '.$r4['Insurance'].'<br>'.$r4['InsuranceNumber'].'</button>';
									$TotalMoney = $TotalMoney+$r4['Amount'];
								}else{
									if($i5==1){ $button_value = "Medicare"; }elseif($i5==2){ $button_value = "Medicaid"; }else{ $button_value = "Insurance"; }
									${"Insurance_".$i5} = '<button type="button" id="NewRecord_Insurance_'.$i5.'_'.$HospNo.'_'.$name.'" style="background-color:rgb(85,85,85); border-radius:5px; height:38px; color:white;"><i class="fa fa-paper-plane-o fa-lg"></i> '.$button_value.'</button>';
								}					
							}
						}else{
							$bed_status = '';
						}
						
						if($i2==0){
							if($i==0){
								echo '<div id="AreaPage-tab'.($i+1).'" align="center">';
							}else{
								echo '<div id="AreaPage-tab'.($i+1).'" align="center" style="display:none;">';
							}
							echo '<table align="center">';
							echo '<tr>';
							echo '<td colspan="10" class="title" style="background-color:orange; font-size:20px; font-weight:bloder; border-radius:30px 30px 0px 0px;">'.$r['areaName'].'</td>';
							echo '</tr>';
							echo '<tr>';
							echo '<td class="title">Bed#</td>';
							echo '<td class="title">Care ID#</td>';
							echo '<td class="title">Resident</td>';
							echo '<td class="title">Medicare</td>';
							echo '<td class="title">Medicaid</td>';
							echo '<td class="title">Insurance A<br>Bill Time</td>';
							echo '<td class="title">Insurance B<br>Bill Time</td>';
							echo '<td class="title">Insurance C<br>Bill Time</td>';
							echo '<td class="title">Self-Pay<br>Bill Time</td>';
							echo '<td class="title">Total</td>';
							echo '</tr>';
						}
						if($bed_status!=""){
							echo '<tr align="center">';
							echo '<td>'.$r2['bedID'].'</td>';
							echo '<td>'.$HospNo.'</td>';
							echo '<td>'.$name.'</td>';
							echo '<td>'.$Insurance_1.'</td>';
							echo '<td>'.$Insurance_2.'</td>';
							echo '<td>'.$Insurance_3.'</td>';
							echo '<td>'.$Insurance_4.'</td>';
							echo '<td>'.$Insurance_5.'</td>';
							echo '<td></td>';
							echo '<td style="color:rgb(109,179,168); font-weight:bolder; font-size:17px;">'.$TotalMoney.'</td>';
							echo '</tr>';
						}
						if($i2==($db2->num_rows()-1)){
							echo '<tr>';
							echo '<td colspan="10" class="title" style="background-color:orange; font-size:20px; font-weight:bloder; border-radius:0px 0px 30px 30px;">'.$r['areaName'].'</td>';
							echo '</tr>';
							echo '</table>';
							echo '</div>';
						}
					}
				}
			}
		}
		?>
	</div>
	</td></tr></table>
</div>
<?php
echo '<script>';
echo '$(function() {';
for($ii=1;$ii<=$Area_number;$ii++){
	echo "$('#btn_AreaPage_".$ii."').click(function() {";
	for($jj=1;$jj<=$Area_number;$jj++){
		echo "document.getElementById('AreaPage-tab".$jj."').style.display = 'none';";
	}
	echo "document.getElementById('AreaPage-tab".$ii."').style.display = 'inline';";
	echo "});";
}
echo '});';
echo '</script>';
?>
<script>
$(function() {
    $( "#NewInsuranceForm" ).dialog({
        autoOpen: false,
        height: 490,
        width: 430,
        modal: true,
        buttons: {
            "Save": function() {
                $.ajax({
                    url: "class/Insurance_save.php",//還沒建立資料庫
                    type: "POST",
                    data: {"HospNo": $("#HospNo").val(), "InsuranceNo": $("#InsuranceNo").val(), "Insurance": $("#Insurance").val(), "InsuranceNumber": $("#InsuranceNumber").val(), "PeriodStart": $("#PeriodStart").val(), "PeriodEnd": $("#PeriodEnd").val(), "Amount": $("#Amount").val(), "BillTime": $("#BillTime").val() },
                    success: function(data) {
                        $( "#NewInsuranceForm" ).dialog( "close" );
					    alert(data);
                        window.location.reload();
                    }
                });
            },
            "Cancel": function() {
                $( "#NewInsuranceForm" ).dialog( "close" );
            }
        }
    });
	
	$('button:button[id^="NewRecord_Insurance_"]').click(function() {
		document.getElementById('InsuranceNumber').value = '';
		document.getElementById('PeriodStart').value = '';
		document.getElementById('PeriodEnd').value = '';
		document.getElementById('Amount').value = '';
		document.getElementById('BillTime').value = '';
		var arrID = $(this).attr('id');
		arrID = arrID.split('_');
		document.getElementById('HospNo').value = arrID[3];
		document.getElementById('ResidentName').innerHTML = arrID[4];
		document.getElementById('InsuranceNo').value = arrID[2];
		if(arrID[2]==1){
			document.getElementById('Insurance').value = "Medicare";
			$("#Insurance").attr("readonly",true);
		}else if(arrID[2]==2){
			document.getElementById('Insurance').value = "Medicaid";
			$("#Insurance").attr("readonly",true);
		}else{
			document.getElementById('Insurance').value = '';
			$("#Insurance").attr("readonly",false);
		}
		$( "#NewInsuranceForm" ).dialog( "open" );
	});
	
	$('button:button[id^="EditRecord_Insurance_"]').click(function() {
		var arrID = $(this).attr('id');
		arrID = arrID.split('_');
		if(arrID[2]==1 || arrID[2]==2){
			$("#Insurance").attr("readonly",true);
		}else{
			$("#Insurance").attr("readonly",false);
		}
		document.getElementById('HospNo').value = arrID[3];
		document.getElementById('ResidentName').innerHTML = arrID[4];
		document.getElementById('InsuranceNo').value = arrID[2];
		$.ajax({
			url: "class/getInsuranceInfo.php",
			type: "POST",
			data: {"HospNo": arrID[3], "InsuranceNo": arrID[2]},
			success: function(data) {
				var InsuranceData = data.split('||');
				$('#Insurance').val(InsuranceData[0]);
				$('#InsuranceNumber').val(InsuranceData[1]);
				$('#PeriodStart').val(InsuranceData[2]);
				$('#PeriodEnd').val(InsuranceData[3]);
				$('#Amount').val(InsuranceData[4]);
				$('#BillTime').val(InsuranceData[5]);
			}
		});
		$( "#NewInsuranceForm" ).dialog( "open" );
	});
	/*
	$('button:button[id^="Delete_Expected_"]').click(function() {
		if(confirm("Are you sure you want to delete?")){
			var arrID = $(this).attr('id');
			arrID = arrID.split('_');
			$.ajax({
				url: "class/ExpectedToLeave_delete.php",
				type: "POST",
				data: {"bedID": arrID[2], "HospNo": arrID[3] },
				success: function(data) {
					alert(data);
					window.location.reload();
				}
			});
		}
	});
	*/
});
</script>
<div class="nurseform-table">
	<div id="NewInsuranceForm" title="Insurance" class="dialog-form">
		<form>
		<fieldset>
		<table align="center">
			<tr>
				<td class="title">Care ID#</td>
				<td>
				<input type="text" name="HospNo" id="HospNo" readonly="readonly">
				</td>
			</tr>
			<tr>
				<td class="title">Resident</td>
				<td>
				<div id="ResidentName" readonly="readonly"></div>
				</td>
			</tr>
			<tr>
				<td class="title">Insurance</td>
				<td>
				<input type="text" name="Insurance" id="Insurance">
				<input type="hidden" name="InsuranceNo" id="InsuranceNo">
				</td>
			</tr>
			<tr>
				<td class="title">Insurance Number</td>
				<td>
				<input type="text" name="InsuranceNumber" id="InsuranceNumber">
				</td>
			</tr>
			<tr>
				<td class="title">Period</td>
				<td>
				<script> $(function() { $( "#PeriodStart").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script>
				<input type="text" name="PeriodStart" id="PeriodStart" size="8">
				~
				<script> $(function() { $( "#PeriodEnd").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script>
				<input type="text" name="PeriodEnd" id="PeriodEnd" size="8">
				</td>
			</tr>
			<tr>
				<td class="title">Amount</td>
				<td>
				<input type="text" name="Amount" id="Amount">
				</td>
			</tr>
			<tr>
				<td class="title">Bill Time</td>
				<td>
				<script> $(function() { $( "#BillTime").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script>
				<input type="text" name="BillTime" id="BillTime" size="8">
				</td>
			</tr>
		</table>
		</fieldset>
		</form>
	</div>
</div>