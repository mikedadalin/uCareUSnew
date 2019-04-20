<?
if(isset($_GET['GID']) && isset($_GET['action']) && $_GET['action']=="delete"){
	$db = new DB;
	$db->query("DELETE FROM `formgroup` WHERE `GroupID`='".mysql_escape_string($_GET['GID'])."'");
	$db2 = new DB;
	$db2->query("DELETE FROM `formorder` WHERE `GroupID`='".mysql_escape_string($_GET['GID'])."'");
	echo '<script>window.location.href="index.php?mod=management&func=formview&id=30"</script>';
}
?>
<div>
	<h3>Continuous form setting</h3>
	<div align="left" style="padding:10px;"><button type="button" onclick="location.href='index.php?mod=management&func=formview&id=30_1'" style="background-color:#5C5C5C; border:0; border-radius:8px; height:60px; color:white;"><i class="fa fa-plus fa-2x fa-fw"></i><br>Add New List</button></div>
	<table id="form14tab1">
		<thead>
		<tr>
			<th width="80">ID #</th>
			<th width="180">List Name</th>
			<th width="270">MOD</th>
			<th width="270">Description</th>
			<th width="160">Function</th>
			</tr>
		</thead>
		<?php
		$db1 = new DB;
		$db1->query("SELECT * FROM `formgroup`");
		for ($i1=0;$i1<$db1->num_rows();$i1++) {
			$r1 = $db1->fetch_assoc();
			$db2 = new DB2;
			$db2->query("SELECT `Name` FROM `permission2` WHERE `PermissionID`='".$r1['cateID']."'");
			$r2 = $db2->fetch_assoc();
			echo '
			<tr>
				<td>'.$r1['GroupID'].'</td>
				<td>'.$r1['ListName'].'</td>
				<td>'.$r2['Name'].'</td>
				<td>'.$r1['Description'].'</td>
				<td class="link1">
				<a href="index.php?mod=management&func=formview&id=30_1&GID='.$r1['GroupID'].'"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-pencil fa-stack-1x fa-inverse"></i></span></a>
				<a title="Delete" onclick="DeleteFormCheck(\''.$r1['GroupID'].'\',\''.$r1['ListName'].'\');"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-trash fa-stack-1x fa-inverse"></i></span></a>
				</td>
			</tr>
			';
		}
		?>
	</table>
</div>
<script>
$(function() {
	$('#form14tab1').dataTable({
		paging: false
	});
});
function DeleteFormCheck(formID,FormName) {
    if (confirm("Are you sure you want to delete this List? \n\nList ID#: "+formID+"\nList Name: "+FormName+"\n") == true) {
		if (confirm("If you do delete, this list can not be restored. Are you sure? \n\nList ID#: "+formID+"\nList Name: "+FormName+"\n") == true){
			document.location.href="index.php?mod=management&func=formview&id=30&GID="+formID+"&action=delete";
		}
    }
}
</script>