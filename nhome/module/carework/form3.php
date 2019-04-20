<?php
$db2 = new DB;
$str = "SELECT DISTINCT c.`service_ym` FROM  `service_cate` a ";
$str .=" INNER JOIN `service_cate` a1 ON a.service_cateID = a1.parentID ";
$str .=" INNER JOIN  `service_item` b ON a1.service_cateID = b.service_cateID ";
$str .=" INNER JOIN careform03 c ON c.service_itemID = b.service_itemID";
$str .=" WHERE 1 AND a.typeCode='".mysql_escape_string($_GET['mod'])."' order by c.service_ym DESC";
$db2->query($str);
?>
<div class="moduleNoTab">
	<form  method="post">
		<h3>Routine service / maintenance record</h3>
		<div align="right">
			<input type="button" id="Add" name="Add" value="New maintenance record">
		</div>
		<table width="100%" border="0">	
			<tr class="title">
				<td>Maintenance date</td>
				<td>Function</td>
			</tr>
			<?php
			if($db2->num_rows()>0){
				for ($i=0;$i<$db2->num_rows();$i++) {
					$r2 = $db2->fetch_assoc();	
					echo '
					<tr>
					<td align="center">'.substr($r2['service_ym'], 0, 4).'/'.substr($r2['service_ym'], 4, 2).'</td>
					<td align="center"><input type="button" value="Preview" id="edit" name="edit" onclick="goEdit('.$r2['service_ym'].');"></td>
					</tr>';
				}

			}
			?>  
		</table>
	</form>
</div>
<script language="javascript">
$(function() {
	$('#Add').click(function(){
		location.href = "index.php?mod=carework&func=formview&id=3_1";
	});
	$('#Item').click(function(){
		location.href = "index.php?mod=category&func=formview&id=2&code=carework";
	});
});
function goEdit(ym){
	location.href = "index.php?mod=carework&func=formview&id=3_2&ym="+ym;
}
</script>