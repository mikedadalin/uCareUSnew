<h3>Property management</h3>
<div class="content-query">
<form>
<table width="100%" class="printcol" cellpadding="10" style="text-align:left;">
  <tr class="title">
    <td colspan="2">Filter Condition</td>
  </tr>
  <tr>
    <td class="title" width="240">Property ID#</td>
    <td><input type="text" name="pno" id="pno" size="30" value="<?php echo $_GET['pno']!=""?$_GET['pno']:""; ?>" /> <input type="button" value="Search" onclick="window.location.href='index.php?mod=consump&func=formview&id=16&view=0&query=1&pno='+document.getElementById('pno').value;" /></td>
  </tr>
  <tr>
    <td class="title" width="160">Storage Unit</td>
    <td>
    <?php
	$db1 = new DB;
	$db1->query("select * from service_cate where typeCode='property' and layer =1 and isHidden_1");
	if($db1->num_rows() > 0 ){
		echo '<select id="cateID" name="cateID"><option value="0">========</option>';
		for($i1=0;$i1<$db1->num_rows();$i1++){
			$r1 = $db1->fetch_assoc();
			echo '<option value="'.$r1['service_cateID'].'" '.($r1['service_cateID']==$_GET['cateID']?'selected':'').'>'.$r1['title'].'</option>';
		}
		echo '</select>';
	}
    ?>
    </td>
  </tr>
  <tr>
    <td class="title" width="160">Placed location</td>
    <td>
    <?php
	$db1 = new DB;
	$db1->query("select * from maintenance_area where 1 order by areaName");
	if($db1->num_rows() > 0 ){
		echo '<select id="a1_areaID" name="a1_areaID"><option value="0">========</option>';
		for($i1=0;$i1<$db1->num_rows();$i1++){
			$r1 = $db1->fetch_assoc();
			echo '<option value="'.$r1['areaID'].'" '.($r1['areaID']==$_GET['a1_areaID']?'selected':'').'>'.$r1['areaName'].'</option>';
		}
		echo '</select>';
	}
    ?>    
    </td>
  </tr>
  <tr>
    <td align="center" colspan="2">
    <?php
	if ($_GET['stop']!="y") {
	?>
    <input type="button" value="Display only item still applied" onclick="window.location.href='index.php?mod=consump&func=formview&id=16&stop=y';" />
    <?php
	} else {
	?>
    <input type="button" value="Display all item" onclick="window.location.href='index.php?mod=consump&func=formview&id=16';" />
    <?php	
	}
	?>
    <input type="button" value="Clear search results" onclick="window.location.href='index.php?mod=consump&func=formview&id=16';" /></td>
  </tr>
</table>
</form>
</div>
<div align="center" style="margin-top:30px;">
<form>
	<input type="button" id="print16" value="Annual property transaction record" />
	<input type="button" onclick="window.location.href='index.php?mod=consump&func=formview&id=16_3'" value="New Item" />
    <input type="button" onclick="window.location.href='index.php?mod=category&func=formview&id=1&code=property'" value="Setup storage unit" />
</form>
</div>
<table width="100%" cellpadding="10">
  <tr class="title">
    <td class="printcol">Edit</td>
    <td>ID #</td>
    <td>Name</td>
    <td>Spec.</td>
    <td>Model</td>
    <td>Unit</td>
    <td>Storage Unit</td>
    <td>Retire</td>
  </tr>
<?php

$maxNo = 30;

if ($_GET['pn']=="") {
	$pn = 1;
} else {
	$pn = $_GET['pn'];
}

$ps = ($pn-1)*$maxNo;

if ($_GET['query']=="") {
	$sql = "SELECT * FROM `property` WHERE 1";
} elseif ($_GET['query']=="1" && ($_GET['view']==0 || $_GET['view']=="")) {
	//搜尋編號
	$sql = "SELECT * FROM `property` WHERE `p_no`='".mysql_escape_string($_GET['pno'])."'";
} elseif ($_GET['query']=="2" && ($_GET['view']==0 || $_GET['view']=="")) {
	//搜尋分類
	$sql = "SELECT * FROM `property` WHERE ";
	if ($_GET['cateID']!="") {
		$sql .= "`service_cateID`='".mysql_escape_string($_GET['cateID'])."' AND ";
	}
	if ($_GET['a1_areaID']!=""){
		$sql .= "`areaID`='".mysql_escape_string($_GET['a1_areaID'])."' AND ";
	}
	$sql = substr($sql,0,strlen($sql)-5);
} elseif ($_GET['query']=="3" && ($_GET['view']==0 || $_GET['view']=="")) {
	//顯示所有物品
	$sql = "SELECT * FROM `property` WHERE 1 ";
}
if ($sql=="") { $sql = "SELECT * FROM `property` WHERE 1 "; }
if ($_GET['stop']=='y') {
	$sql .= " AND `STOP_ID`='0'";
} else {
	$sql .= " AND `STOP_ID`='1'";
}
$sql .= " ORDER BY `p_no` ASC";
//echo $sql;
$db0 = new DB;
$db0->query($sql);
$totalRow = $db0->num_rows();
$totalPages = ceil($totalRow/$maxNo);

$sql .= " LIMIT ".$ps.", ".$maxNo;

$db = new DB;
$db->query($sql);
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	echo '
  <tr style="line-height:24px;">
    <td align="center" class="printcol"><a href="index.php?mod=consump&func=formview&id=16_1&pno='.$r['propertyID'].'"><img src="Images/edit_icon.png" width="18"></a></td>
    <td>'.$r['p_no'].'</td>
    <td>'.$r['p_name'].'</td>
    <td>'.$r['p_spk'].'</td>
    <td>'.$r['p_model'].'</td>
    <td>'.$r['p_unit'].'</td>
	<td>'.getCateName($r['service_cateID']).'</td>
	<td>'.($r['stop_ID']=="0"?'Retire':'').'</td>
  </tr>'."\n";
}
?>
  <tr class="title page printcol">
    <td colspan="8"><?php echo changePageManager($totalRow, $totalPages, $pn, $maxNo, "&stop=".$_GET['stop']."&query=".$_GET['query']."&cateID=".$_GET['cateID'], "index.php?mod=consump&func=formview&id=16&view=0&stop=".$_GET['stop'].""); ?></td>
  </tr>
</table>
<?php
$db2 = new DB;
$db2->query("SELECT DISTINCT YEAR(`cDate`) AS `year` FROM `alldetail`");
for ($i2=0;$i2<$db2->num_rows();$i2++) {
	$r2 = $db2->fetch_assoc();
	$yearsel .= '<option value="'.$r2['year'].'">'.$r2['year'].'</option>';
}
?>
<script type="text/javascript">
$(function() {
	$("#cateID").change(function(){
		location.href = "index.php?mod=consump&func=formview&id=16&view=0&query=2&cateID="+$("#cateID").val(); 
	});
	$("#a1_areaID").change(function(){
		location.href = "index.php?mod=consump&func=formview&id=16&view=0&query=2&a1_areaID="+$("#a1_areaID").val(); 
	});
	$("#print16").click(function(){
		var $dialog = $('<div title="Print annual property transaction" class="dialog-form"><table><tr><td class="title">Select year:</td><td><select id="printyear"><?php echo $yearsel; ?></select></td></tr></table></div>').dialog({
			buttons: [{
				text: "Print",
				click: function(){
					window.open("print.php?mod=consump&func=printform16&date="+$('#printyear').val());
					$dialog.remove();
					}
				}]
		});	
	});
})
</script>