<?php
/*
$Array_Area_Expected = array();
$db3 = new DB;
$db3->query("SELECT * FROM `expectedtoleave`");
if($db3->num_rows()>0){
	for($i=0;$i<$db3->num_rows();$i++){
		$r3 = $db3->fetch_assoc();
		$db4 = new DB;
		$db4->query("SELECT `bed` FROM `inpatientinfo` WHERE `patientID`='".getPID($r3['HospNo'])."'");
		if($db4->num_rows()>0){
			$r4 = $db4->fetch_assoc();
			$db5 = new DB;
			$db5->query("SELECT `Area` FROM `bedinfo` WHERE `bedID`='".$r4['bed']."'");
			if($db5->num_rows()>0){
				$r5 = $db5->fetch_assoc();
				if(!in_array($r5['Area'],$Array_Area_Expected)){
					array_push($Array_Area_Expected,$r5['Area']);
					${$r5['Area'].'_Expected_Leave'} = array();
				}
				if(in_array($r5['Area'],$Array_Area_Expected)){
					array_push(${$r5['Area'].'_Expected_Leave'},$r4['bed'].'_'.$r3['ExpectedLeaveDate']);
				}
			}
		}
	}
}
*/
?>
<div class="nurseform-table" style="margin-top:50px;">	
	<div ><h3 style="font-size:26px;">Room System</h3></div>
	<table align="center" style="width:100%;"><tr style="background-color:rgba(0,0,0,0); padding:0;"><td style="padding:0;">
	<div align="center" style="margin-bottom:20px; width:100%;">
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
		if($area_option!=''){
			echo draw_option("AreaPage",$area_option,"xm","single",1,true,$tab_number);
		}else{
			echo 'First Add New Section/Room';
		}
		?>
	</div>
	<div>
		<!--
		<div id="AreaPage-tab1" align="center">
			<table align="center">
			<?php
			/*
			$db = new DB;
			$db->query("SELECT * FROM `bedinfo` a LEFT JOIN `inpatientinfo` b ON a.`bedID` = b.`bed` WHERE (b.patientID IS NULL OR b.patientID='') ORDER BY `Area`");
			$Array_Area = array();
			if ($db->num_rows()>0) {
				echo '<tr>';
				echo '<td colspan="6" class="title" style="background-color:orange; font-size:20px; font-weight:bloder; border-radius:30px 30px 0px 0px;">Empty Bed</td>';
				echo '</tr>';
				for ($i=0;$i<$db->num_rows();$i++) {
					$r = $db->fetch_assoc();
					if(!in_array($r['Area'],$Array_Area)){
						array_push($Array_Area,$r['Area']);
						${'Array_'.$r['Area'].'_Empty_Bed'} = array();
					}
					if(in_array($r['Area'],$Array_Area)){
						array_push(${'Array_'.$r['Area'].'_Empty_Bed'},$r['bedID']);
					}
				}
				for($i=0;$i<count($Array_Area);$i++){
					$db2 = new DB;
					$db2->query("SELECT `areaName` FROM `areainfo` WHERE `areaID`='".$Array_Area[$i]."'");
					$r2 = $db2->fetch_assoc();
					$Expected_Bed = '';
					$Empty_Bed = '';
					echo '<tr>';
					echo '<td class="title">Area</td>';
					echo '<td>'.$r2['areaName'].'</td>';
					echo '<td class="title">Sum</td>';
					echo '<td>'.count(${'Array_'.$Array_Area[$i].'_Empty_Bed'}).' <font style="color:red;">('.count(${$Array_Area[$i].'_Expected_Leave'}).')</font></td>';
					echo '<td class="title">Bed#</td>';
					echo '<td align="left">';
					for($j=0;$j<count(${'Array_'.$Array_Area[$i].'_Empty_Bed'});$j++){
						if($j==(count(${'Array_'.$Array_Area[$i].'_Empty_Bed'})-1)){
							$Empty_Bed .= ${'Array_'.$Array_Area[$i].'_Empty_Bed'}[$j];
						}else{
							$Empty_Bed .= ${'Array_'.$Array_Area[$i].'_Empty_Bed'}[$j].' , ';
						}
					}
					for($z=0;$z<count(${$Array_Area[$i].'_Expected_Leave'});$z++){
						$Array_Expected_Bed = explode("_",${$Array_Area[$i].'_Expected_Leave'}[$z]);
						if($z==(count(${$Array_Area[$i].'_Expected_Leave'})-1)){
							$Expected_Bed .= $Array_Expected_Bed[0].' (Expected: '.formatdate_Ymd_Dash($Array_Expected_Bed[1]).')';
						}else{
							$Expected_Bed .= $Array_Expected_Bed[0].' (Expected: '.formatdate_Ymd_Dash($Array_Expected_Bed[1]).') , ';
						}
					}
					echo $Empty_Bed.'<br><font style="color:red;">'.$Expected_Bed.'</font></td></tr>';
				}
			} else {
				echo '<tr><td colspan="6">nobed</td></tr>';
			}
			*/
			?>
				<tr>
					<td colspan="6" class="title" style="background-color:orange; font-size:20px; font-weight:bloder; border-radius:0px 0px 30px 30px;">Empty Bed</td>
				</tr>
			</table>
		</div>
		-->
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
					$Use_number =0;
					for ($i3=0;$i3<$db6->num_rows();$i3++) {
						$r6 = $db6->fetch_assoc();
						$db5 = new DB;
						$db5->query("SELECT `patientID` FROM `inpatientinfo` WHERE `bed`='".$r6['bedID']."'");
						if ($db5->num_rows()>0) {
							$Use_number++;
						}
					}
					$Empty_number = $db2->num_rows()-$Use_number;
					for ($i2=0;$i2<$db2->num_rows();$i2++) {
						$r2 = $db2->fetch_assoc();
						$db3 = new DB;
						$db3->query("SELECT `patientID`,`bed` FROM `inpatientinfo` WHERE `bed`='".$r2['bedID']."'");
						$Expected_to_leave = '';
						if ($db3->num_rows()>0) {
							$r3 = $db3->fetch_assoc();
							$HospNo = getHospNo($r3['patientID']);
							$db4 = new DB;
							$db4->query("SELECT * FROM `expectedtoleave` WHERE `HospNo`='".$HospNo."' AND `bedID`='".$r3['bed']."'");
							if ($db4->num_rows()>0) {
								$r4 = $db4->fetch_assoc();
								$Expected_to_leave = '<button type="button" id="Delete_Expected_'.$r2['bedID'].'_'.$HospNo.'" style="background-color:#f56251; color:#fff; border:0; border-radius:5px; height:35px;"><i class="fa fa-times-circle fa-lg"></i> '.formatdate_Ymd_Dash($r4['ExpectedLeaveDate']).'</button>';
							}else{
								$Expected_to_leave = '<button type="button" id="NewRecord_Expected_'.$r['areaName'].'_'.$r2['bedID'].'_'.$HospNo.'_'.getPatientName($r3['patientID']).'" style="background-color:#5C5C5C; border:0; border-radius:5px; height:35px; color:white;"><i class="fa fa-paper-plane-o fa-lg"></i> Expected to Leave</button>';
							}
							$bed_status = '<font style="color:#f34835">In Use</font>';
						}else{
							$bed_status = '<font style="color:#82ab1c; font-weight:bolder;">Empty</font>';
						}
						$Reservation_button = '<form><button type="button" id="NewRecord_Reservation_'.$r['areaName'].'_'.$r2['bedID'].'" style="background-color:rgba(0, 146, 214, 0.8); color:#fff; border-radius:5px; height:35px; border:0;"><i class="fa fa-h-square fa-2x" style="display:inline-block; vertical-align:middle;"></i> <font style="vertical-align:middle; display:inline-block; font-size:12px;">Make Reservation</font></button></form>';
						
						$db7 = new DB;
						$db7->query("SELECT * FROM `reservation` WHERE `bedID`='".$r2['bedID']."'");
						$Reservation_status = '';
						if ($db7->num_rows()>0) {
							for($i4=0;$i4<$db7->num_rows();$i4++){
								$r7 = $db7->fetch_assoc();
								$Reservation_status .= '<div style="padding:5px;"><button type="button" id="Delete_Reservation_'.$r2['bedID'].'_'.$r7['SSN'].'" style="background-color:#f56251; color:#fff; border-radius:5px; border:0; height:35px;"><i class="fa fa-times-circle fa-lg"></i> '.formatdate_Ymd_Dash($r7['ReservationDate']).' '.$r7['ResidentName'].'</button> <font style="padding-left:20px;">Contact: '.$r7['Contact'].' '.$r7['Phone'].'</font></div>';
							}
						}
						
						if($i2==0){
							if($i==0){
								echo '<div id="AreaPage-tab'.($i+1).'" align="center">';
							}else{
								echo '<div id="AreaPage-tab'.($i+1).'" align="center" style="display:none;">';
							}
							echo '<table align="center" style="width:100%;">';
							echo '<tr>';
							echo '<td colspan="6" class="title" style="background-color:#ebc314; font-size:20px; color:#fff; font-weight:600;">'.$r['areaName'].'</td>';
							echo '</tr>';
							echo '<tr>';
							echo '<td colspan="6" class="title">';
							echo '<table style="width:100%;">';
							echo '<tr class="title" style="font-size:20px; font-weight:bloder;">';
							echo '<td style="width:33.3%;">Bed: '.$db2->num_rows().'</td>';
							echo '<td style="width:33.3%;">In use: <font style="color:pink">'.$Use_number.'</font></td>';
							echo '<td style="width:33.3%;">Empty: <font style="color:#daed59">'.$Empty_number.'</font></td>';
							echo '</tr>';
							echo '</table>';
							echo '</td>';
							echo '</tr>';
							echo '<tr>';
							echo '<td class="title">Bed#</td>';
							echo '<td class="title">Price</td>';
							echo '<td class="title">Status</td>';
							echo '<td class="title">Expected to leave</td>';
							echo '<td class="title">Reservation</td>';
							echo '<td class="title">Reservation status</td>';
							echo '</tr>';
						}
						echo '<tr align="center">';
						echo '<td>'.$r2['bedID'].'</td>';
						echo '<td>$'.$r2['price'].'</td>';
						echo '<td>'.$bed_status.'</td>';
						echo '<td>'.$Expected_to_leave.'</td>';
						echo '<td>'.$Reservation_button.'</td>';
						echo '<td align="left">'.$Reservation_status.'</td>';
						echo '</tr>';
						if($i2==($db2->num_rows()-1)){
							echo '<tr>';
							echo '<td colspan="6" class="title" style="background-color:#ebc314; font-size:20px; color:#fff; font-weight:600;">'.$r['areaName'].'</td>';
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
    $( "#NewExpectedForm" ).dialog({
        autoOpen: false,
        height: 400,
        width: 380,
        modal: true,
        buttons: {
            "Save": function() {
                $.ajax({
                    url: "class/ExpectedToLeave_save.php",
                    type: "POST",
                    data: {"HospNo": $("#HospNo").val(), "bed": $("#bed").val(), "ExpectedLeaveDate": $("#ExpectedLeaveDate").val() },
                    success: function(data) {
                        $( "#NewExpectedForm" ).dialog( "close" );
					    alert(data);
                        window.location.reload();
                    }
                });
            },
            "Cancel": function() {
                $( "#NewExpectedForm" ).dialog( "close" );
            }
        }
    });
	
	$('button:button[id^="NewRecord_Expected_"]').click(function() {
		var arrID = $(this).attr('id');
		arrID = arrID.split('_');
		document.getElementById('Area').value = arrID[2];
		document.getElementById('bed').value = arrID[3];
		document.getElementById('HospNo').value = arrID[4];
		document.getElementById('ResidentName').innerHTML = arrID[5];
		$( "#NewExpectedForm" ).dialog( "open" );
	});
	
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
	
    $( "#NewReservationForm" ).dialog({
        autoOpen: false,
        height: 490,
        width: 380,
        modal: true,
        buttons: {
            "Reservation": function() {
                $.ajax({
                    url: "class/Reservation_save.php",
                    type: "POST",
                    data: {"bed": $("#bed_Reservation").val(), "ResidentName": $("#ResidentName_Reservation").val(), "SSN": $("#SSN").val(), "Contact": $("#Contact").val(), "Phone": $("#Phone").val(), "ReservationDate": $("#ReservationDate").val() },
                    success: function(data) {
                        $( "#NewReservationForm" ).dialog( "close" );
					    alert(data);
                        window.location.reload();
                    }
                });
            },
            "Cancel": function() {
                $( "#NewReservationForm" ).dialog( "close" );
            }
        }
    });
	
	$('button:button[id^="NewRecord_Reservation_"]').click(function() {
		var arrID = $(this).attr('id');
		arrID = arrID.split('_');
		document.getElementById('Area_Reservation').value = arrID[2];
		document.getElementById('bed_Reservation').value = arrID[3];
		$( "#NewReservationForm" ).dialog( "open" );
	});
	
	$('button:button[id^="Delete_Reservation_"]').click(function() {
		if(confirm("Are you sure you want to delete?")){
			var arrID = $(this).attr('id');
			arrID = arrID.split('_');
			$.ajax({
				url: "class/Reservation_delete.php",
				type: "POST",
				data: {"bedID": arrID[2], "SSN": arrID[3] },
				success: function(data) {
					alert(data);
					window.location.reload();
				}
			});
		}
	});
	
	/*
	$('#Area').change(function () {
		$.ajax({
			url: "class/checkNotEmptyBed.php",
			type: "POST",
			data: { "Area": $("#Area").val()},
			success: function(data) {
				if (data=="NoResident") {
					$("#bed option").remove();
					$("#bed").append($("<option></option>").attr("value", "").text("No Resident"));
					$("#bed").attr("disabled",true);
				} else {
					var arr = data.split(';');
					$("#bed").attr("disabled",false);
					$("#bed").addClass("validate[required]");
					$("#bed option").remove();
					$("#bed").append($("<option></option>"));
					for (var i=0; i<arr.length; i++) {
						$("#bed").append($("<option></option>").attr("value", arr[i]).text(arr[i]));
					}
				}
			}
		});
	});

	$('#bed').change(function () {
		$.ajax({
			url: "class/checkBedResident.php",
			type: "POST",
			data: { "bed": $("#bed").val()},
			success: function(data) {
				if (data=="NoResident") {
					document.getElementById('ResidentName').innerHTML = 'No Resident';
				} else {
					var arr = data.split(';');
					document.getElementById('ResidentName').innerHTML = arr[0];
					document.getElementById('HospNo').value = arr[1];
				}
			}
		});
	});
	*/
});
</script>
<div class="nurseform-table">
	<div id="NewExpectedForm" title="Expected To Leave Center" class="dialog-form">
		<form>
		<fieldset>
		<table align="center">
			<tr>
				<td class="title">Area</td>
				<td>
				<input type="text" name="Area" id="Area" readonly="readonly">
				<!--
				<select name="Area" id="Area" class="validate[required]">
					<option></option>
					<?php
					/*
					$db = new DB;
					$db->query("SELECT * FROM `areainfo` ORDER BY `areaID` ASC");
					for ($i=0;$i<$db->num_rows();$i++) {
						$r = $db->fetch_assoc();
						echo '<option value="'.$r['areaID'].'">'.$r['areaName'].'</option>'."\n";
					}
					*/
					?>
				</select>
				-->
				</td>
			</tr>
			<tr>
				<td class="title">Bed#</td>
				<td>
				<input type="text" name="bed" id="bed" readonly="readonly">
				<!--
				<select name="bed" id="bed" disabled>
					<option>---First select Area---</option>
				</select>
				-->
				</td>
			</tr>
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
				<td class="title">Expected leave date</td>
				<td>
				<script> $(function() { $( "#ExpectedLeaveDate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script>
				<input type="text" name="ExpectedLeaveDate" id="ExpectedLeaveDate" size="10" style="text-align:center;">
				</td>
			</tr>
		</table>
		</fieldset>
		</form>
	</div>
	<div id="NewReservationForm" title="Reservation Of Bed" class="dialog-form">
		<form>
		<fieldset>
		<table align="center">
			<tr>
				<td class="title">Area</td>
				<td>
				<input type="text" name="Area_Reservation" id="Area_Reservation" readonly="readonly">
				</td>
			</tr>
			<tr>
				<td class="title">Bed#</td>
				<td>
				<input type="text" name="bed_Reservation" id="bed_Reservation" readonly="readonly">
				</td>
			</tr>
			<tr>
				<td class="title">Resident</td>
				<td>
				<input type="text" name="ResidentName_Reservation" id="ResidentName_Reservation">
				</td>
			</tr>
			<tr>
				<td class="title">SSN</td>
				<td>
				<input type="text" name="SSN" id="SSN">
				</td>
			</tr>
			<tr>
				<td class="title">Contact Person</td>
				<td>
				<input type="text" name="Contact" id="Contact">
				</td>
			</tr>
			<tr>
				<td class="title">Phone</td>
				<td>
				<input type="text" name="Phone" id="Phone">
				</td>
			</tr>
			<tr>
				<td class="title">Date of Reservation</td>
				<td>
				<script> $(function() { $( "#ReservationDate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script>
				<input type="text" name="ReservationDate" id="ReservationDate" size="10" style="text-align:center;">
				</td>
			</tr>
		</table>
		</fieldset>
		</form>
	</div>
</div>