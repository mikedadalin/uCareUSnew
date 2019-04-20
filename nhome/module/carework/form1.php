<?php
$db2 = new DB;
$str = "SELECT DISTINCT c.`service_ym` FROM  `service_cate` a ";
$str .=" INNER JOIN `service_cate` a1 ON a.service_cateID = a1.parentID ";
$str .=" INNER JOIN  `service_item` b ON a1.service_cateID = b.service_cateID ";
$str .=" INNER JOIN service_maintenance c ON c.service_itemID = b.service_itemID";
$str .=" WHERE 1 AND a.typeCode='".mysql_escape_string($_GET['mod'])."' order by c.service_ym DESC";
$db2->query($str);
?>
<div class="moduleNoTab">
	<form  method="post">
		<h3>Cleansing and Disinfection Record</h3>
		<table border="0" style="width:100%;">	
			<tr class="title">
				<td colspan="2">Shift</td>
			</tr>
			<tr>
				<td align="center"><input type="button" value="Day shift" id="day" name="day" onclick="goList('d');"></td>
				<td align="center"><input type="button" value="Night shift" id="night" name="night" onclick="goList('n');"></td>
			</tr>
		</table>
	</form>
</div>
<script language="javascript">
$(function() {
	$('#Add').click(function(){
		location.href = "index.php?mod=carework&func=formview&id=1_2a";
	});
	$('#night').click(function(){
		location.href = "index.php?mod=carework&func=formview&id=2";
	});
});
function goList(t){
	location.href = "index.php?mod=carework&func=formview&id=1_2a&type="+t;
}
</script>