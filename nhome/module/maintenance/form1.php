<?php
$db2 = new DB;
$str = "SELECT DISTINCT c.`service_ym` FROM  `service_cate` a ";
$str .=" INNER JOIN `service_cate` a1 ON a.service_cateID = a1.parentID ";
$str .=" INNER JOIN  `service_item` b ON a1.service_cateID = b.service_cateID ";
$str .=" INNER JOIN service_maintenance c ON c.service_itemID = b.service_itemID";
$str .=" WHERE 1 AND a.typeCode='".mysql_escape_string($_GET['mod'])."' order by c.service_ym DESC";
$db2->query($str);
?>
<div style="width:100%;">
<form  method="post">
<h3 style="margin-top:0px;">Routine service / maintenance record</h3>
<div>
	<div style="float:left">
		<input type="button" id="Item" name="Item" value="Project management">
		<?php
		$dba = new DB;
		$dba->query("SELECT * FROM `service_maintenance` WHERE `service_ym`='".date(Ym)."'");
		if ($dba->num_rows() <= 0) {	
		?>
	</div>
	<div style="float:right">
		<input type="button" id="Add" name="Add" value="New this month maintenance records">
		<?php
		}
		?>
	</div>
</div>
<table style="width:100%" border="0">	
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
		<td><center><input type="button" value="Edit" id="edit" name="edit" onclick="goEdit('.$r2['service_ym'].');"></center></td>
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
		location.href = "index.php?mod=maintenance&func=formview&id=1a";
	});
	$('#Item').click(function(){
		location.href = "index.php?mod=category&func=formview&id=2&code=maintenance";
	});
});
function goEdit(ym){
	location.href = "index.php?mod=maintenance&func=formview&id=1b&ym="+ym;
}
</script>