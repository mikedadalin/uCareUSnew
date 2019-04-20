<div class="content-table">
	<h3>Vital sign normal value setting (High/Low bound)</h3>
	<?php
	if (isset($_POST['saverange'])) {
		foreach ($_POST as $k=>$v) {
			if (substr($k,0,2)=="vs") {
				$arr = explode('_',$k);
				$itemID = $arr[0];
				$field = $arr[1];
				$value = $v;
				$db1 = new DB;
				$db1->query("UPDATE `vitalsign_range` SET `".$field."`='".$value."' WHERE `itemID`='".$itemID."'");
			}
		}
	}
	?>
	<form method="post" action="index.php?mod=management&func=formview&id=5">
		<table style="width:100%;">
			<tr class="title">
				<td>Item(s)</td>
				<td>Input low bound</td>
				<td>Input high bound</td>
				<td>Alerting low bound</td>
				<td>Alerting high bound</td>
			</tr>
			<?php
			$db0 = new DB;
			$db0->query("SELECT * FROM `vitalsign_range` ORDER BY `itemID` ASC");
			for ($i=0;$i<$db0->num_rows();$i++) {
				$r0 = $db0->fetch_assoc();
				echo '
				<tr>
				<td class="title_s">'.$arrVital2[$r0['itemID']].'</td>
				<td><center><input type="text" name="'.$r0['itemID'].'_keylow" id="'.$r0['itemID'].'_keylow" size="3" value="'.$r0['keylow'].'"></center></td>
				<td><center><input type="text" name="'.$r0['itemID'].'_keyhigh" id="'.$r0['itemID'].'_keyhigh" size="3" value="'.$r0['keyhigh'].'"></center></td>
				<td><center><input type="text" name="'.$r0['itemID'].'_viewlow" id="'.$r0['itemID'].'_viewlow" size="3" value="'.$r0['viewlow'].'"></center></td>
				<td><center><input type="text" name="'.$r0['itemID'].'_viewhigh" id="'.$r0['itemID'].'_viewhigh" size="3" value="'.$r0['viewhigh'].'"></center></td>
				</tr>
				'."\n";
			}
			?>
		</table>
		<div style="margin-top:30px; text-align:center;">
			<input type="submit" name="saverange" id="saverange" value="Save" /><input type="reset" value="Reset" />
		</div>
	</form>
</div>