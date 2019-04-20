<h3>檢驗項目管理</h3>
<form method="post" id="searchForm">
<table width="100%">
  <tr>
    <td style="background:#ffffff;" width="250"><input type="button" value="新增檢驗項目" onclick="window.location.href='index.php?mod=management&func=formview&pid=<?php echo @$_GET['pid']; ?>&id=16_1';" /></td>
    <td style="background:#ffffff;" width="250" align="right">名稱：<input type="text" name="search" id="search" /><input type="submit" id="submit" value="Search" name="submit"/><input type="submit" id="submit" value="Display all" name="submit"/> </td>
  </tr>
</table>
</form>
<table width="100%">
  <tr class="title">
    <td width="120">項目代碼</td>
    <td>Category</td>
    <td width="500">Name</td>
    <td width="8%">Function</td>
  </tr>
<?php
//搜尋關鍵字
if(isset($_POST['submit']) && $_POST['search'] !=""){
	$sql = " WHERE `nickname` like '%".strtoupper(mysql_escape_string($_POST['search']))."%' OR `name` like '%".mysql_escape_string($_POST['search'])."%' ";
}else{
	$sql = "";
}		

$db = new DB;$db->query("SELECT * FROM `labitem` ".$sql." ORDER BY id ");
for ($j=1;$j<=$db->num_rows();$j++) {
	$r = $db->fetch_assoc();
	foreach ($r as $k=>$v) { ${$k} = $v; }
	$db1 = new DB;
	$db1->query("SELECT * FROM `labpatient` WHERE `labID`='".$id."'");
	echo '
  <tr>
    <td>'.$id.'</td>
    <td>'.$category.'</td>
    <td>'.$name.' '.$nickname.'</td>
	<td align="left">
	<form>'.($db1->num_rows()==0?'<a href="index.php?mod=management&func=formview&id=16_2&labID='.$id.'" title="Edit"><img src="Images/edit_icon.png" border="0" width="24"></a> <a href="" onClick="del(\''.$id.'\');" title="Delete"><img src="Images/delete2.png" width="24" ></a>':'').'</form></td>
  </tr>'."\n";
 $medtimetxt="";
 }
 ?>
</table>

<script type="text/javascript">
function del(id){
	if (confirm("Are you sure to delete this item?")) {
		$.ajax({
			url: "class/delrow.php",
			type: "POST",
			data: {"formID": "labitem", "colID": "id", "autoID": id },
			success: function(data) {
				if (data=="OK") {
					alert("Deletion successful !");
					window.location.reload();
				}
			}
		});
	}
}
</script>

