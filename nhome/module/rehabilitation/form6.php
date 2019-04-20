<?php
if (@$_GET['date']=='') {
	$sql = "SELECT * FROM `rehabilitationform05` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql = "SELECT * FROM `rehabilitationform05` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`='".mysql_escape_string($_GET['date'])."'";
}
$db1 = new DB;
$db1->query($sql);
$r1 = $db1->fetch_assoc();
if ($db1->num_rows()>0) {
	foreach ($r1 as $k=>$v) {
		if (substr($k,0,1)=="Q") {
			$arrAnswer = explode("_",$k);
			if (count($arrAnswer)==2) {
				if ($v==1) {
					${$arrAnswer[0]} .= $arrAnswer[1].';';
				}
			} else {
				${$k} = $v;
			}
		}  else {
			${$k} = $v;
		}
	}
}

$year = (mysql_escape_string($_GET['selyear'])=='') ? date(Y) : mysql_escape_string($_GET['selyear']);
?>
<h3><?php echo $year;?> Annual Resident rehabilitation appraisal summary table</h3>
<div style="width:92%; text-align:right;">
	<?php 
	$dbSel = new DB;
	$dbSel->query("SELECT DISTINCT(year(date)) sYear FROM `rehabilitationform04` ");
	?>
	<select id="selyear">
		<option>--Select year--</option>
		<?php
		for ($i=0; $i< $dbSel->num_rows();$i++) {		
			$rs = $dbSel->fetch_assoc();
			echo '<option value="'.$rs['sYear'].'" '.($_GET['selyear']==$rs['sYear']?"selected":"").'>'.$rs['sYear'].'</option>'."\n";

		}
		?>
	</select>
</div>
<form  method="post">
	<?php
	$arrayQ = array("Season","State of consciousness","Joint activity<br>range of motion (ROM)","Muscle strength","Hand movements","Function of motion","ADL (Daily activities)","Social interaction");
	if (@$_GET['selyear']!='') {
		$strQuery = " AND year(date)='".mysql_escape_string($_GET['selyear'])."'";
	}
	?>
	<table border="0">
		<tr>
			<td class="title" width="16%">Season</td>
			<td class="title_s" width="21%">Season 1 (Q1)</td>
			<td class="title_s" width="21%">Season 2 (Q2)</td>
			<td class="title_s" width="21%">Season 3 (Q3)</td>
			<td class="title_s" width="21%">Season 4 (Q4)</td>
		</tr>
		<?php
		for ($i=1;$i<count($arrayQ);$i++){
			?>
			<tr>
				<td class="title"><?php echo $arrayQ[$i];?></td>
				<?php
				for($j=1;$j<5;$j++){
					if($j==1){ $season = " AND month(date) between '1' and '3' ";}
					if($j==2){ $season = " AND month(date) between '4' and '6' ";}
					if($j==3){ $season = " AND month(date) between '7' and '9' ";}
					if($j==4){ $season = " AND month(date) between '10' and '12' ";}
//		echo $season."<br>";
					$sql = "SELECT * FROM `rehabilitationform04` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ".$season." ".$strQuery." ORDER BY `date` DESC LIMIT 0,1";
					$db1 = new DB;
					$db1->query($sql);
					$r1 = $db1->fetch_assoc();

					if ($db1->num_rows()>0) {
						foreach ($r1 as $k=>$v) {

							if (substr($k,0,1)=="Q") {
								$arrAnswer = explode("_",$k);
								if (count($arrAnswer)==2) {
									if ($v==1) {
										${$j.$arrAnswer[0]} .= $arrAnswer[1].';';							
									}
								} else {
									${$j.$k} = $v;
								}
							}  else {
								${$j.$k} = $v;
							}
						}			

						?>
						<td>
							<?php 
		if($i==1){//State of consciousness		  
			echo option_result($j."Q1","Clear;Orderless;Somnolence;Stupor;Coma;Semi-coma;Other","m","multi",${$j.'Q1'},true,5).$Q1a;
		}
		if($i==2){//Joint activity
			$top = $r1['Q6_1']+$r1['Q8_1']+$r1['Q10_1'];
			$top1 = $r1['Q6_2']+$r1['Q8_2']+$r1['Q10_2']+$r1['Q6_3']+$r1['Q8_3']+$r1['Q10_3'];;
			$bottom = $r1['Q7_1']+$r1['Q9_1']+$r1['Q11_1'];
			$bottom1 = $r1['Q7_2']+$r1['Q9_2']+$r1['Q11_2']+$r1['Q7_3']+$r1['Q9_3']+$r1['Q11_3'];;
			echo 'Limited upper limbs: '.$top1.'  part(s), normal: '.$top.' part(s)<br>';
			echo 'Limited lower limbs:: '.$bottom1.'  part(s), normal: '.$bottom.' part(s)';
			${'total'.$j} = 24;
			${'score'.$j} = $top + $bottom;
		}
		if($i==3){//Muscle strength
			if($r1['Q16_1']=='1'){
				echo "Unassessable";
			}else{
				$left = ($r1['Qtotal1']+$r1['Qtotal2']);
				$right = ($r1['Qtotal3']+$r1['Qtotal4']);
				echo 'Left '.$left.' / Right '.$right.' point(s)';
				${'total'.$j} += 50;
				${'score'.$j} += $left + $right;
			}			
		}
		if($i==4){//Hand movements
			if($r1['Q17_1']=='1'){
				echo "Unassessable";
			}else{
				$Lhand = ($r1['Q28_1']==1) ? "3" : ($r1['Q28_2']==1 ? "2" : ($r1['Q28_3']==1 ? "1" : "0"));
				$Lhand += ($r1['Q30_1']==1) ? "3" : ($r1['Q30_2']==1 ? "2" : ($r1['Q30_3']==1 ? "1" : "0"));
				$Rhand = ($r1['Q29_1']==1) ? "3" : ($r1['Q29_2']==1 ? "2" : ($r1['Q29_3']==1 ? "1" : "0"));
				$Rhand += ($r1['Q31_1']==1) ? "3" : ($r1['Q31_2']==1 ? "2" : ($r1['Q31_3']==1 ? "1" : "0"));
				echo 'Left hand: '.$Lhand.'分 / Right hand: '.$Rhand.'分';
				${'total'.$j} += 12;
				${'score'.$j} += $Lhand + $Rhand;
			}
		}
		if($i==5){//動作功能Function of motion
			if($r1['Q32_1']=='1'){
				echo "Unassessable";
			}else{
				$self = ($r1['Q32_1']+$r1['Q33_1']+$r1['Q34_1']+$r1['Q35_1']+$r1['Q36_1']+$r1['Q37_1']+$r1['Q38_1']+$r1['Q39_1']); 
				echo 'Independent:'.$self.' item(s)<br> need assistance: '.(7-$self).' item(s)';
				${'total'.$j} += 7;
				${'score'.$j} += $self;
				
			}
		}
		if($i==6){//ADL (Daily activities)
			$disable = ($r1['Q40_1']+$r1['Q41_1']+$r1['Q42_1']+$r1['Q43_1']+$r1['Q44_1']+$r1['Q45_1']+$r1['Q46_1']+$r1['Q47_1']+$r1['Q48_1']+$r1['Q49_1']);
			echo 'No disability: '.$disable.' item(s)<br>disabled: '.(10-$disable).' item(s)';
			${'total'.$j} += 10;
			${'score'.$j} += $disable;
		}
		if($i==7){//社會互動
			if($r1['Q62_1']=='1'){
				echo "Unassessable";
			}else{
				$join = ($r1['Q63_1']==1) ? "3" : ($r1['Q63_2']==1 ? "2" : ($r1['Q63_3']==1 ? "1" : "0"));
				$join1 = ($r1['Q64_1']==1) ? "3" : ($r1['Q64_2']==1 ? "2" : ($r1['Q64_3']==1 ? "1" : "0"));
				$join2 = ($r1['Q65_1']+$r1['Q65_2']+$r1['Q65_3']);
				echo $r1['Qtotal5'].' / 9 point(s)<br> Interaction: '.$join.' point(s)<br> Communication: '.$join1.' point(s)<br>Participation: '.$join2.' point(s)';
				${'total'.$j} += 9;
				${'score'.$j} += $r1['Qtotal5'];
			}
		}
		?>
	</td>    
	<?php
} else {
	echo "<td></td>";	
}
}
?>
</tr>
<?php }?>
<tr>
	<td class="title">Score</td>
	<td><?php echo ($score1!=""?$score1.'/'.$total1.' ('.round($score1/$total1,2).')':""); ?></td>
	<td><?php echo ($score2!=""?$score2.'/'.$total2.' ('.round($score2/$total2,2).')':""); ?></td>
	<td><?php echo ($score3!=""?$score3.'/'.$total3.' ('.round($score3/$total3,2).')':""); ?></td>
	<td><?php echo ($score4!=""?$score4.'/'.$total4.' ('.round($score4/$total4,2).')':""); ?></td>
</tr> 
</table>
<table width="100%">
	<tr>
		<td align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
	</tr>
</table>
<style>
#chart1 table {
	width: 120px;
	left:40px;
	position:relative;
}
#chart1 table tr {
	background:none;
	height:auto;
	padding:0px;
	margin:0px;
}
</style>
<br>
<div id="chart1" style="width:92%; height:300px; margin:30px auto;"></div>
<script type="text/javascript">
$(function () {
	$.plot($("#chart1"), [
		{ label: "Score",  data: [
		['1','<?php echo ($score1!=""?round($score1/$total1,2):''); ?>'],
		['2','<?php echo ($score2!=""?round($score2/$total2,2):''); ?>'],
		['3','<?php echo ($score3!=""?round($score3/$total3,2):''); ?>'],
		['4','<?php echo ($score4!=""?round($score4/$total4,2):''); ?>']
		] }
		],
		{
			series: {
				lines: { show: true },
				points: { show: true }
			},
			xaxis: { ticks:[ ['1','Season 1'], ['2','Season 2'], ['3','Season 3'], ['4','Season 4'] ], 'color':'#000', },
			yaxis: { min:0, max:1, ticks:6, tickSize: 0.2, tickDecimals: 2, 'color':'#FFFFFF', },
			grid: { hoverable: true, clickable: false, borderWidth: 1, },
			legned: { show: false }
		});
});
</script>
</form>
<script language="javascript">
$(function() {
	$("#selyear").change(function(){
		location.href='index.php?mod=rehabilitation&func=formview&pid=<?php echo $_GET['pid'];?>&id=6&selyear='+$("#selyear").val();
	})	
});
</script>
