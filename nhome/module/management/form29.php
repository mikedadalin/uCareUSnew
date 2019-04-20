<h3>Sundries statistics</h3>
<table style="width:100%;">
	<tr>
		<td style="height:40px; padding:5px 10px;">
			<div align="left" style="float:left; line-height:40px;">
				Applied Date : <select id="selmonth" onchange="showdate()">
				<option>--Select date--</option>
				<?php
				$db2 = new DB;
				$db2->query("SELECT DISTINCT `date` FROM `careform08`  ORDER BY `date` DESC Limit 0,30");
				for ($i1a=0;$i1a<$db2->num_rows();$i1a++) {
					$r2 = $db2->fetch_assoc();
					echo '<option value="'.$r2['date'].'" '.($r2['date']==$_GET['date']?"selected":"").'>'.$r2['date'].'</option>'."\n";
				}
				?>
			</select>
			<script>
			function showdate() {
				var selectedmonth = document.getElementById('selmonth').value;
				window.open('index.php?mod=management&func=formview&pid=&id=29&date='+selectedmonth, '_self' );
			}
			</script>
		</div>
		<div class="printcol" align="right" style="margin-top:7px;">
			<div style="width:60px; background-color:rgba(255,255,255,0.8); border-radius:5px; padding:2px;"><a href="print.php?mod=management&func=formview&pid=&id=29&date=<?php echo $_GET['date']; ?>" target="_blank"><img src="Images/print.png" /></a></div>
		</div>
	</td>
</tr>
</table>
<?php
if (@$_GET['date']==NULL) {	
	$strSQL = "SELECT DISTINCT(`date`) FROM `careform08` order by `date` desc LIMIT 0, 1";
} else {
	$strSQL = "SELECT * FROM `careform08` WHERE `date`='".mysql_escape_string($_GET['date'])."'";
}
$db = new DB;
$db->query($strSQL);
?>
<table cellpadding="6px" style="width:100%;">
	<tr class="title">
		<td>&nbsp;</td>
		<?php
		$db_area = new DB;
		$db_area->query("SELECT * FROM `areainfo` ORDER BY `areaName` ASC");
		$areaNo = $db_area->num_rows();
		$arrArea = array();
		for ($i=0;$i<$areaNo;$i++) {
			$rArea = $db_area->fetch_assoc();
			$arrArea[$i] = $rArea['areaID'];
			echo '<td align="center">'.$rArea['areaName'].'</td>'."\n";
		}
		?>
	</tr>
	<?php 
	$arrAreaBed = array();
	$mealNo = $db->num_rows();
	for ($i1=0;$i1<$mealNo;$i1++){
		$r1 = $db->fetch_assoc();
		$arrHospNo = explode(";", $r1['HospNo']);
		for ($i2=0;$i2<count($arrHospNo);$i2++) {			
			$bedID = getBedID(getPID($arrHospNo[$i2]));
			$db_bed = new DB;
			$db_bed->query("SELECT `Area` FROM `bedinfo` WHERE `bedID`='".$bedID."'");
			$rBed = $db_bed->fetch_assoc();
			$arrAreaBed[$i1][$rBed['Area']]++;		
		}
		?>
		<tr>
			<td align="center"><?php echo getItemName($r1['title']);?></td>
			<?php
			$db_area = new DB;
			$db_area->query("SELECT * FROM `areainfo` ORDER BY `areaName` ASC");
			$areaNo = $db_area->num_rows();
			$arrArea1 = array();
			for ($i3=0;$i3<$areaNo;$i3++) {
				$rArea = $db_area->fetch_assoc();
				$arrArea1[$i3] = $rArea['areaName'];
				echo '<td align="center">'.$arrAreaBed[$i1][$arrArea[$i3]];
				foreach($arrHospNo as $a=>$b){
					$c=explode("_",$b);
					if($arrArea1[$i3]==$c[0]){
						echo ($c[1]==0?"":$c[1]." (公用)");
					}
				}
				echo '</td>'."\n";
			}
			?>
		</tr>  
		<?php
	}?>
	<tr>
		<td align="center">Number Head Count</td>
		<?php
		for ($j2=0;$j2<$areaNo;$j2++) {
			$tmp = 0;
			for ($j1=0;$j1<$mealNo;$j1++) {
				$tmp += $arrAreaBed[$j1][$arrArea[$j2]];
			}
			echo '<td align="center">'.$tmp.'</td>'."\n";
		}
		?>
	</tr>
	<tr class="noShowCol">
		<td>Sign</td>
		<?php
		for ($j2=0;$j2<$areaNo;$j2++) {
			echo '<td>&nbsp;</td>'."\n";
		}
		?>
	</tr>
</table>