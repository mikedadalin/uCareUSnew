<div style="background-color: rgba(255,255,255,0.8); border-radius: 10px; padding:10px; margin-bottom: 10px;">
	<div class="content-query">
		<table>
			<tr class="title">
				<td colspan="2">Filter condition</td>
			</tr>
			<tr>
				<td width="120" class="title"><center><b>Area search</b></center></td>
				<td align="left" style="padding-left:5px;">
					<form action="index.php?mod=management&func=formview&id=1&query=1" method="post">
						Area&nbsp;<select name="area">
						<?php
						$qArea = new DB;
						$qArea->query("SELECT * FROM `areainfo` ORDER BY `areaID` ASC");
						for ($i=0;$i<$qArea->num_rows();$i++) {
							$rArea = $qArea->fetch_assoc();
							echo '<option value="'.$rArea['areaID'].'">'.$rArea['areaName'].'</option>'."\n";
						}
						?>
					</select>&nbsp;
					<input type="submit" value="Search" /></form>
				</td>
			</tr>
			<tr>
				<td width="120" class="title"><center><b>Resident search</b></center></td>
				<td align="left" style="padding-left:5px;"><form action="index.php?mod=management&func=formview&id=1&query=2" method="post">Social Security number&nbsp;<input name="IdNo" value="<?php echo $_POST['IdNo']; ?>" />&nbsp;or Care ID#&nbsp;<input name="HospNo" value="<?php echo $_POST['HospNo']; ?>" />&nbsp;<input type=submit value="Resident search" /><input type=button value="ID card search" /></form></td>
			</tr>
		</table>
	</div>
</div>
<div style="background-color: rgba(255,255,255,0.8); border-radius: 10px; padding:10px 10px 30px 10px; margin-bottom: 10px;">
	<div class="content-table">
		<div align="right" style="margin-top:5px; margin-bottom:5px;"><form><?php if (@$_GET['query']!=NULL) { echo '<input type="button" value="Clear search results" onclick="window.location.href = \'index.php?mod=management&func=formview&id=1\'" />'."\n"; } ?></form></div>
		<table>
			<tr class="title">
				<td>&nbsp;</td>
				<td>Area</td>
				<td>Bed</td>
				<td>Full name</td>
				<td>Care ID#</td>
				<td>Gender</td>  
				<td>Age</td>
				<td>Admission date</td>
				<td>紀錄查詢</td>
			</tr>
			<?php
			if (@$_GET['query']==2) {
	//身份證查詢
				if ($_POST['IdNo']!=NULL) {
					$sql1 = "SELECT `patientID` FROM `patient` WHERE `IdNo` LIKE '%".mysql_escape_string($_POST['IdNo'])."%' ORDER BY `patientID` DESC";
				} elseif ($_POST['HospNo']!=NULL) {
					$sql1 = "SELECT `patientID` FROM `patient` WHERE `HospNo` LIKE '%".mysql_escape_string($_POST['HospNo'])."%' ORDER BY `patientID` DESC";
				} else {
					$sql1 = "SELECT `patientID` FROM `inpatientinfo` ORDER BY `bed` ASC";
				}
			} elseif (@$_GET['query']==1) {
	//查詢區域
				$arrAreaBed = array();
				$db2 = new DB;
				$db2->query("SELECT `bedID` FROM `bedinfo` WHERE `Area`='".mysql_escape_string($_POST['area'])."'");
				for ($k=0;$k<$db2->num_rows();$k++) {
					$r2 = $db2->fetch_assoc();
					$arrAreaBed[$k] = $r2['bedID'];
				}
				$sql1 = "SELECT `patientID` FROM `inpatientinfo` ORDER BY `bed` ASC";
			} else {
				$sql1 = "SELECT `patientID` FROM `inpatientinfo` ORDER BY `bed` ASC";
			}
			$db = new DB;
			$db->query($sql1);
			for ($i=0;$i<$db->num_rows();$i++) {
				$r = $db->fetch_assoc();
				$db1 = new DB;
				$db1->query("SELECT `bed`,`indate` FROM `inpatientinfo` WHERE `patientID`='".$r['patientID']."' ORDER BY `patientID` DESC LIMIT 0,1");
				for ($j=0;$j<$db1->num_rows();$j++) {
					$r1 = $db1->fetch_assoc();
					if (@$_GET['query']==1) {
						if (count($arrAreaBed)==0) {
							if (@$_GET['query']!=NULL) {
								echo '<script>alert("此區域尚未有住民入住");</script>'."\n";
								break 2;
							}
						}
					}
					$db2a = new DB;
					$db2a->query("SELECT `Area` FROM `bedinfo` WHERE `bedID`='".$r1['bed']."'");
					$r2a = $db2a->fetch_assoc();
					$db2b = new DB;
					$db2b->query("SELECT `areaName` FROM `areainfo` WHERE `areaID`='".$r2a['Area']."'");
					$r2b = $db2b->fetch_assoc();
					$db2c = new DB;
					$db2c->query("SELECT `HospNo`,`Birth` FROM `patient` WHERE `patientID`='".$r['patientID']."'");
					$r2c = $db2c->fetch_assoc();
					if (count($arrAreaBed)==0 || in_array($r1['bed'],$arrAreaBed)) {
						echo '
						<tr>
						<td><center><a href="index.php?mod=management&func=formview&id=1_1&pid='.$r['patientID'].'&query='.@$_GET['query'].'"><img src="Images/select.png"></a></center></td>
						<td align="center">'.$r2b['areaName'].'</td>
						<td align="center">'.$r1['bed'].'</td>
						<td align="center">'.getPatientName($r['patientID']).'</td>
						<td align="center">'.$r2c['HospNo'].'</td>
						<td align="center">'.checkgender($r['patientID']).'</td>  
						<td align="center">'.calcage($r2c['Birth']).'</td>
						<td align="center">'.formatdate($r1['indate']).'</td>
						<td align="center">
						<form action="index.php?mod=management&func=formview&id=1_2&pid='.$r['patientID'].'">
						<select name="seldate">
						<option></option>';
						$db3 = new DB;
						$db3->query("SELECT `startdate`, `enddate` FROM `feeinvoice` WHERE `HospNo`='".$r2c['HospNo']."' ORDER BY `startdate` DESC");
						for ($k=0;$k<$db3->num_rows();$k++) {
							$r3 = $db3->fetch_assoc();
							echo '<option value="'.$k.'">'.formatdate($r3['startdate']).'~'.formatdate($r3['enddate']).'</option>';
						}
						echo '
						</select>
						<input type="submit" value="Search">
						</form>
						</td>
						</tr>
						'."\n";
					}
				}
			}
			?>
		</table>
	</div>
</div>
<p>&nbsp;</p>