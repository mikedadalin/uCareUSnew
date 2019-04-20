<?php
$db0 = new DB;
$db0->query("SELECT * FROM `vitalsign_range` ORDER BY `itemID` ASC");
for ($i=0;$i<$db0->num_rows();$i++) {
	$r0 = $db0->fetch_assoc();
	${$r0['itemID'].'_low'} = $r0['keylow'];
	${$r0['itemID'].'_high'} = $r0['keyhigh'];
}
?>
<div class="content-query" style="background-color: rgba(255,255,255,0.8); border-radius: 10px; padding:10px; margin-bottom: 10px;">
	<table>
		<tr class="title">
			<td colspan="2" style="border-top-left-radius:10px; border-top-right-radius:10px;">Filter condition</td>
		</tr>
		<tr>
			<td width="140" class="title"><center><b>Area search</b></center></td>
			<td align="left" style="padding-left:5px;">
				<form action="index.php?mod=dailywork&func=resplist2&query=1" method="post">
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
			<td width="140" class="title" style="border-bottom-left-radius:10px;"><center><b>Resident search</b></center></td>
			<td align="left" style="border-bottom-right-radius:10px; padding-left:5px;"><form action="index.php?mod=dailywork&func=resplist2_weight&query=2" method="post">Social Security number&nbsp;<input name="IdNo" value="<?php echo $_POST['IdNo']; ?>" />&nbsp;or Care ID#&nbsp;<input name="HospNo" value="<?php echo $_POST['HospNo']; ?>" />&nbsp;<input type="submit" value="Search" /></form></td>
		</tr>
	</table>
</div>
<div class="content-table" style="background-color: rgba(255,255,255,0.8); border-radius: 10px; padding:10px 10px 30px 10px; margin-bottom: 20px;">
	<form id="base" name="base" action="module\dailywork\resplist2db.php" method="post">
		<table>
			<tr>
				<td colspan="3" class="title">Date</td>
				<td colspan="4"><script> $(function() { $( "#Qdate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="Qdate" id="Qdate" size="12" value="<?php echo date('Y/m/d'); ?>" class="validate[required,custom[date]]" tabindex="1" style="padding-left:5px;"></td>
				<td colspan="2" class="title">Time</td>
				<td colspan="4"><select name="Qtime" id="Qtime" class="validate[required]" tabindex="2"><option></option><?php for ($i2a=0;$i2a<=23;$i2a++) { echo '<option value="'.$i2a.'" '.(date(H)==$i2a?" selected":"").'>'.(strlen($i2a)==1?'0':'').$i2a.'</option>'; } ?></select>:<select name="Qtime2" id="Qtime2" class="validate[required]" tabindex="2"><option></option><option value="60">隨機帶入</option><?php for ($i2a=0;$i2a<=59;$i2a++) { echo '<option value="'.$i2a.'" '.(date(i)==$i2a?" selected":"").'>'.(strlen($i2a)==1?'0':'').$i2a.'</option>'; } ?></select></td>
			</tr>
		</table>
		<table>
			<tr class="title">
				<td width="120">Area</td>
				<td width="120">Bed</td>
				<td width="200">Full name</td>
				<td>Weight</td>
			</tr>
			<?php
			if (@$_GET['query']==2) {
	//身份證查詢
				if ($_POST['IdNo']!=NULL) {
					$db3 = new DB;
					$db3->query("SELECT `IdNo`,`HospNo` FROM `patient` ORDER BY `patientID` DESC");
					for ($i=0;$i<$db3->num_rows();$i++) {
						$r3 = $db3->fetch_assoc();
						/*== 解 START ==*/
						$rsa = new lwj('lwj/lwj');
						$puepart = explode(" ",$r3['IdNo']);
						$puepartcount = count($puepart);
						if($puepartcount>1){
							for($m=0;$m<$puepartcount;$m++){
								$prdpart = $rsa->privDecrypt($puepart[$m]);
								$r3['IdNo'] = $r3['IdNo'].$prdpart;
							}
						}else{
							$r3['IdNo'] = $rsa->privDecrypt($r3['IdNo']);
						}
						if($r3['IdNo']==$_POST['IdNo']){
							$sql1 = "SELECT `patientID` FROM `patient` WHERE `HospNo` LIKE '%".mysql_escape_string($r3['HospNo'])."%' ORDER BY `patientID` DESC";
						}
						/*== 解 END ==*/
					}
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
	//查詢區域
				$arrAreaBed = array();
				$db2 = new DB;
				$db2->query("SELECT `bedID` FROM `bedinfo` WHERE `Area`='2'");
				for ($k=0;$k<$db2->num_rows();$k++) {
					$r2 = $db2->fetch_assoc();
					$arrAreaBed[$k] = $r2['bedID'];
				}
				$sql1 = "SELECT `patientID` FROM `inpatientinfo` ORDER BY `bed` ASC";
			}
			$db = new DB;
			$db->query($sql1);
			$count=3;
			for ($i=0;$i<$db->num_rows();$i++) {
				$r = $db->fetch_assoc();
				foreach ($r as $k=>$v) {
					$arrPatientInfo = explode("_",$k);
					if (count($arrPatientInfo)==2) {
						if ($v==1) {
							${$arrPatientInfo[0]} = $arrPatientInfo[1];
						}
					} else {
						${$k} = $v;
					}
				}
				$db1 = new DB;
				$db1->query("SELECT `bed` FROM `inpatientinfo` WHERE `patientID`='".$r['patientID']."' ORDER BY `patientID` DESC LIMIT 0,1");
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
					$db2c->query("SELECT `patientID`,`HospNo`,`instat` FROM `patient` WHERE `patientID`='".$r['patientID']."'");
					$r2c = $db2c->fetch_assoc();
					if (count($arrAreaBed)==0 || in_array($r1['bed'],$arrAreaBed)) {
						echo '
						<tr '.($_SESSION['ncareOrgStatus_lwj']==2 && $r2c['instat']==0?' style="display:none;"':"").'>
						<td nowrap align="center">'.$r2b['areaName'].'</td>
						<td nowrap align="center">'.$r1['bed'].'</td>
						<td nowrap style="padding-left:5px;">'.getPatientName($r2c['patientID']).'</td>
						<td nowrap style="padding-left:5px;"><input type="text" name="vs_188334_'.$r2c['HospNo'].'" id="vs_188334_'.$r2c['HospNo'].'" class="validate[min['.$vs188334_low.'],max['.$vs188334_high.']]" size="5" placeholder="Body weight" tabindex="'.($count++).'">lbs</td>
						</tr>
						'."\n";
						$n .= $r2c['HospNo'].';';
					}
				}
			}
			$n = substr($n,0,strlen($n)-1);
			?>
		</table>
		<input type="hidden" name="totaln" value="<?php echo $n; ?>" />
		<input type="hidden" name="Qfiller" value="<?php echo $_SESSION['ncareID_lwj']; ?>" />
		<center>
			<div style="margin-top:30px;">
				<button type="submit" id="submit_resplist2_weight" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('resplist2_weight');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
			</div>
		</center>
	</form>
</div>
<script>$("#base").validationEngine();</script>
<p>&nbsp;</p>