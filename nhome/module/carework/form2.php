<div class="moduleNoTab">
<h3>Night shift cleansing and disinfection record</h3>
<?php 
if (@$_GET['qdate']==NULL) { $qdate = date('Y-m'); } else { $qdate = @$_GET['qdate']; }
if (@$_GET['area']==NULL) { $db0 = new DB; $db0->query("SELECT `areaID` FROM `areainfo` ORDER BY `areaID` LIMIT 0,1"); $r0 = $db0->fetch_assoc(); $areaID=$r0['areaID']; } else { $areaID = @$_GET['area']; }
?>
<center>
<form class="printcol" style="width:100%;">
<div align="center"><input type="button" id="day" name="day" value="Day shift"><input type="button" id="Add" name="Add" value="New cleaning and disinfection work"><input type="button" id="Item" name="Item" value="Project management">
</div>
<div align="center" style="margin:5px auto;">Select month Date ：<select id="selmonth">
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
echo 'Select floor ：<select id="areaID" name="areaID">';
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
<input type="button" onclick="getdata();" value="Search Search" ></div>
</form>
</center>
<form  method="post" onsubmit="return checkForm();">
<?php

$arrDates = getdays($qdate);
//print_r($arrDates);
$d = new DateTime($arrDates[0]);
$dlw = new DateTime($arrDates[0]);
$dnw = new DateTime($arrDates[0]);
$dlw->modify('-7 day'); $lastweek = $dlw->format('Y-m-d');
$dnw->modify('+7 day'); $nextweek = $dnw->format('Y-m-d');

$db3 = new DB;
$db3->query("SELECT distinct(b.`areaname`) 'AreaName' FROM `careform01` a inner join `areainfo` b on a.`areaID`=b.`areaID` WHERE  a.areaID='".$areaID."'");
	$r3 = $db3->fetch_assoc();
	echo '<span class="noShowCol">'.substr($qdate,0,4).'Year'.substr($qdate,5,2).'Month'.$r3['AreaName'].'</span>';
?>
<table border="0">
  <tr class="title printcol">
    <td colspan="9"><input type="button" onclick="window.location.href='index.php?mod=carework&func=formview&id=2&area=<?php echo $areaID; ?>&qdate=<?php echo $lastweek; ?>'" value="Previous week Last week"> <input type="button" onclick="window.location.href='index.php?mod=carework&func=formview&id=2&area=<?php echo $areaID; ?>'" value="Back to current week"> <input type="button" onclick="window.location.href='index.php?mod=carework&func=formview&id=2&area=<?php echo $areaID; ?>&qdate=<?php echo $nextweek; ?>'" value="Next week"></td>
  </tr>
  <tr class="title">
    <td width="200" colspan="2">Item(s)</td>
    <?php
	$i1 = 0;
	foreach ($arrPHPDay as $k=>$v) {
		if ($i1==0) { $n = 0; } else { $n = 1; }
		$d->modify("+".$n." day"); $sd = $d->format('m/d');
    ?>
    <td width="80" align="center"><?php echo $v;?><br><?php echo $k;?><br><?php echo $sd;?></td>
    <?php 
	    $i1++;
	}
	?>
  </tr>
<?php
$db = new DB;
$str =" SELECT a.title titlea, a.service_cateID aID, c.title titlec, c.service_cateID cID FROM  `service_cate` a ";
$str .=" LEFT JOIN  `service_cate` c ON c.`parentID` = a.`service_cateID` ";
$str .=" WHERE 1 and a.typeCode='".mysql_escape_string($_GET['mod'])."' AND a.`layer` =1 AND a.`isHidden_1` =1 AND a.title like 'Night shift%'";
$str .=" ORDER BY a.ord";

$db->query($str);
if($db->num_rows()>0){
	for ($i=0;$i<$db->num_rows();$i++) {
		$r = $db->fetch_assoc();
		$cate = ($r['cID']=="")? $r['aID']:$r['cID'];
		$db1 = new DB;
		$str1 = "SELECT * FROM `service_item` a inner join `service_cate` b on a.service_cateID=b.service_cateID  WHERE a.service_cateID='".$cate."' and a.isHidden_1=1 and b.isHidden_1=1 and a.title like 'Night shift%' order by a.ord";
		$db1->query($str1);
		${'aa'.$r['aID']} += $db1->num_rows();
		$ab += $db1->num_rows();
	}
}

$db->query($str);
if($db->num_rows()>0){
	for ($i=0;$i<$db->num_rows();$i++) {
		$r = $db->fetch_assoc();
		
		$cate = ($r['cID']=="")? $r['aID']:$r['cID'];
		$db1 = new DB;
		$str1 = "SELECT a.title, a.service_itemID FROM `service_item` a inner join `service_cate` b on a.service_cateID=b.service_cateID  WHERE a.service_cateID='".$cate."' and a.isHidden_1=1 and b.isHidden_1=1 order by a.ord";

		$db1->query($str1);
		if($db1->num_rows()>0){
			
			for ($i1=0;$i1<$db1->num_rows();$i1++) {
				$r1 = $db1->fetch_assoc();				
				$da = new DateTime($arrDates[0]);
				echo '<tr>';
				if($tmp1!=$cate){
				  echo '<td class="title_s" rowspan="'.$db1->num_rows().'">'.$r['titlec'].'</td>';
				}			  
				echo'<td>'.str_replace("\n","<br>",$r1['title']).'</td>';
				
				for ($i2=0;$i2<7;$i2++){
					if ($i2==0) { $n = 0; } else { $n = 1; }
					$da->modify("+".$n." day"); $tda = $da->format('Y-m-d');
					$db1a = new DB;
					$db1a->query("SELECT * FROM `careform02` WHERE `itemID`='".$r1['service_itemID']."' and `status_1`=1 and `date` like '".$tda."' AND `areaID`='".$areaID."'");      
					$r1a=$db1a->fetch_assoc();
					echo '<td><a href="index.php?mod=carework&func=formview&id=2_1a&area='.$r1a['areaID'].'&qdate='.$r1a['date'].'">'.checkusername($r1a['filler']).'</a></td>';
				}
				
				echo '</tr>';
			  
		$a +=1;
		$tmp=$r['titlea'];
		$tmp1=$cate;
		$tmp2 = getCate($r1['service_cateID']);
			}
		}
	}
	echo '
	';
}

					
		
?>
<tr class="noShowCol">
	<td class="title_s" align="center" height="40" colspan="2">查核者簽名</td>
    <?php 
	for ($i1=0;$i1<7;$i1++){
		echo '<td>&nbsp;</td>';
	}
	?>
</tr>
</table>
</form>
<script language="javascript">
$(function() {
	$('#Item').click(function(){
		location.href = "index.php?mod=category&func=formview&id=2&code=carework";
	});
	$('#Add').click(function(){
		location.href = "index.php?mod=carework&func=formview&id=2_1a";
	});
	$('#day').click(function(){
		location.href = "index.php?mod=carework&func=formview&id=1_2a";
	});
});
function getdata(){
	var area = document.getElementById("areaID").value;
	var qdate = document.getElementById("selmonth").value;
	location.href = "index.php?mod=carework&func=formview&id=2&qdate="+$("#selmonth").val()+"&area="+area;
}
</script>
<?php
function getCate($id){
	$db = new DB;
	$str = "select * from service_cate a inner join service_item b on a.service_cateID=b.service_cateID ";
	$str .=" where b.service_cateID='".$id."'";
	$db->query($str);
	$r1 = $db->fetch_assoc();
	return $r1['parentID'];
}
?>
</div>