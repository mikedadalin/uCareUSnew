<?php

if (@$_GET['qdate']==NULL || @$_GET['qdate']=="--Select month--") { $qdate = date('Y-m'); $qdate2 = date('Y-m-'); } else { $qdate = @$_GET['qdate']; $qdate2 = @$_GET['qdate'].'-'; }
if (@$_GET['area']==NULL) { $db0 = new DB; $db0->query("SELECT `areaID` FROM `areainfo` ORDER BY `areaID` LIMIT 0,1"); $r0 = $db0->fetch_assoc(); $areaID=$r0['areaID']; } else { $areaID = @$_GET['area']; }

?>
<div class="moduleNoTab">
	<h3>Bug elimination record</h3>
	<?php
	if (date('W',strtotime(date($qdate2.date('t',date($qdate2.'01'))))) < date('W',strtotime(date($qdate2.'01')))) {
		$weeks = 53 - date('W',strtotime(date($qdate2.'01'))) + 1;
	} else {
		$weeks = date('W',strtotime(date($qdate2.date('t',date($qdate2.'01'))))) - date('W',strtotime(date($qdate2.'01'))) + 1;
	}
	$arrWeek = array();
	for ($i4=1;$i4<=date('t',strtotime(date($qdate2.'01')));$i4++) {
		$day = $i4;
		if (strlen($day)==1) { $day = '0'.$day; }
		$weekNo = (int) date('W',strtotime(date($qdate2.$day)));
		if (substr($qdate2,5,2)=='12' && $weekNo == 1) { $weekNo = 53; }
		if (count($arrWeek[$weekNo])==0) { $arrWeek[$weekNo] = array(); }
		$arrWeek[$weekNo][date($qdate2.$day)] = date($qdate2.$day);
	}
	$weeks = count($arrWeek);
	?>
	<form  class="printcol">
		<div align="right" style="float:right;"><input type="button" id="Add" name="Add" value="Bug elimination work"><input type="button" id="Item" name="Item" value="Project management">
		</div>
		<a style="color:#3F3F3F; font-size:18px; font-weight:bold;">Select month: </a><select id="selmonth">
		<option>--Select month--</option>
		<?php
		$nextmonth = date(m)+1; if ($nextmonth>12) { $nextmonth = 1; $nextyear = date(Y)+1; } else { $nextyear = date(Y); }
		if (strlen($nextmonth)==1) { $nextmonth = "0".$nextmonth; }
		for ($i=date(m);$i>=(date(m)-12);$i--) {
			$month = $i;
			if ($year==NULL) { $year = date(Y); }
			if ($i<1) {
				$month = 12+$i;
				$year = date(Y)-1;
			}
			if (strlen($month)==1) {
				$month = "0".$month;
			}
			echo '<option value="'.$year.'-'.$month.'"';
			if ($qdate==$year.'-'.$month) { echo ' selected'; }
			echo '>'.$year.'-'.$month.'</option>'."\n";
		}
		?>
	</select>
	<?php
	echo '<a style="color:#3F3F3F; font-size:18px; font-weight:bold;"> Select floor： </a><select id="areaID" name="areaID">';
	echo '  <option></option>';
	$db3 = new DB;
	$db3->query("SELECT * FROM `areainfo` ORDER BY `areaID` ASC");
	for ($i3=0;$i3<$db3->num_rows();$i3++) {
		$r3 = $db3->fetch_assoc();
		echo '  <option value="'.$r3['areaID'].'"';
		if ($areaID==$r3['areaID']) { echo ' selected'; }
		echo '>'.$r3['areaName'].'</option>';
		$arrAreaName[$r3['areaID']] = $r3['areaName'];
	}
	echo '</select>';
	?>
	<input type="button" onclick="getdata();" value="Search" >
</form>
<form  method="post" onsubmit="return checkForm();" id="careform01">
	<table border="0" cellpadding="5">
		<tr class="title">
			<td rowspan="2">Item(s)</td>
			<td rowspan="2">Location</td>
			<?php for ($i2a==0;$i2a<$weeks;$i2a++){?>
			<td colspan="2">The <?php echo ($i2a+1); ?> Week</td>
			<?php }?>
		</tr>
		<tr class="title">
			<?php for ($i2b==0;$i2b<$weeks;$i2b++){?>
			<td width="80">Execution<br>Routine</td>
			<td width="80">Effectiveness<br>Result</td>
			<?php }?>
		</tr>
		<?php
		$a = 1;
		$db = new DB;
		$str =" SELECT a.title titlea, a.service_cateID aID, c.title titlec, c.service_cateID cID FROM  `service_cate` a ";
		$str .=" LEFT JOIN  `service_cate` c ON c.`parentID` = a.`service_cateID` ";
		$str .=" WHERE 1 and a.typeCode='".mysql_escape_string($_GET['mod'])."' AND a.`layer` =1 AND a.`isHidden_1` =1 AND a.title like '消除蟲害%' ";
		$str .=" ORDER BY a.ord ";
		$db->query($str);
		for ($i=0;$i<$db->num_rows();$i++) {
			$r = $db->fetch_assoc();	
			$cate = ($r['cID']=="")? $r['aID']:$r['cID'];
			$db1 = new DB;
			$str1 = "SELECT `itemDetail`, GROUP_CONCAT(DATE_FORMAT(`date`,'%Y-%m-%d')) AS `date`, GROUP_CONCAT(`status_1`) as `status_1`, GROUP_CONCAT(`status_2`) as `status_2`, GROUP_CONCAT(`status_3`) as `status_3`, GROUP_CONCAT(`effect`) as `effect` FROM `careform04` WHERE `areaID`='".$areaID."' AND `itemID` ='".$r['cID']."' AND `date` LIKE '".$qdate2."%' GROUP BY `itemDetail` ORDER BY `itemID`, `date`";
			$db1->query($str1);
			if ($db1->num_rows()>0) {		
				for ($i1=0;$i1<$db1->num_rows();$i1++) {
					$r1 = $db1->fetch_assoc();
					$arrR1_date = explode(',',$r1['date']);
					$arrR1_status1 = explode(',',$r1['status_1']);
					$arrR1_status2 = explode(',',$r1['status_2']);
					$arrR1_status3 = explode(',',$r1['status_3']);
					$arrR1_effect = explode(',',$r1['effect']);
					echo '
					<tr>';
					if ($i1==0) {
						echo ' <td class="title_s" style="text-align:left;padding:2px 8px;" rowspan="'.$db1->num_rows().'">'.str_replace("\n","<br>",$r['titlec']).'</td>';
					}
					echo '<td align="center">'.$r1['itemDetail'].'</td>';

					$status_txt = array();
					$effect_txt = array();

					foreach($arrWeek as $k1=>$v1) {
						foreach ($arrR1_date as $k=>$v) {
							$status = "";
							$status = ($arrR1_status1[$k]==1?"◎ Mothballs":"");
							$status .= ($arrR1_status2[$k]==1?"&Delta; Insecticide":"");
							$status .= ($arrR1_status3[$k]==1?"&equiv; Bleach":"");
							if (in_array($arrR1_date[$k], $v1)) {
								$status_txt[$k1] .= '<a title="點選編輯" href="index.php?mod=carework&func=formview&id=4_1&area='.$areaID.'&qdate='.$arrR1_date[$k].'">'.$status.'</a>';
								$effect_txt[$k1] .= '<a title="EDIT" href="index.php?mod=carework&func=formview&id=4_1&area='.$areaID.'&qdate='.$arrR1_date[$k].'">'.$arrR1_effect[$k].'</a>';
							}
						}
					}
					foreach($arrWeek as $k1=>$v1) {
						echo '<td align="center">'.$status_txt[$k1].'</td><td>'.$effect_txt[$k1].'</td>';
					}
			/*foreach($arrWeek as $k1=>$v1) {
				echo '<td>'; print_r($v1);
				foreach ($arrR1_date as $k=>$v) {
					foreach($arrWeek as $k1=>$v1) {
						if (in_array($arrR1_date[$k], $v1)) {
							echo $arrR1_effect[$k];
						}
					}
				}
				echo '</td>';
			}*/
			echo '</tr>
			'."\n";
		}
	} else {
		echo '
		<tr>
		<td class="title_s" style="text-align:left;padding:2px 8px;">'.str_replace("\n","<br>",$r['titlec']).'</td>
		<td align="center">&nbsp;</td>';
		foreach($arrWeek as $k1=>$v1) {
			echo '<td>&nbsp;</td><td>&nbsp;</td>';
		}
		echo '</tr>
		'."\n";
	}
}
?>
</table>
</form>
</div>
<script language="javascript">
$(function() {
	$('#Item').click(function(){
		location.href = "index.php?mod=category&func=formview&id=1&code=carework";
	});
	$('#Add').click(function(){
		location.href = "index.php?mod=carework&func=formview&id=4_1";
	});
});
function getdata(){
	var area = document.getElementById("areaID").value;
	var qdate = document.getElementById("selmonth").value;
	location.href = "index.php?mod=carework&func=formview&id=4&qdate="+$("#selmonth").val()+"&area="+area;
}
</script>
