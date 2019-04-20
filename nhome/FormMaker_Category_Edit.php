<?php
if($_SESSION['ncareLevel_lwj']!=5){
	echo '<script>window.location.href="index.php?func=home"</script>';
}
$db = new DB;
$db->query("SELECT * FROM `formmaker_category` ORDER BY `CategoryID` ASC");
for($i=0;$i<$db->num_rows();$i++){
	$r = $db->fetch_assoc();
	$db2 = new DB;
	$db2->query("SELECT `CategoryName` FROM `formmaker_order` WHERE `CategoryID`='".$r['CategoryID']."'");
	for($j=0;$j<$db2->num_rows();$j++){
		$r2 = $db2->fetch_assoc();
		if($r['CategoryName']!=$r2['CategoryName']){
			$db3 = new DB;
			$db3->query("UPDATE `formmaker_order` SET `CategoryName`='".$r['CategoryName']."' WHERE `CategoryID`='".$r['CategoryID']."'");
			$j = $db2->num_rows();
		}
	}
}
?>
<script type="text/javascript" src="js/LWJ_tabs.js"></script>
<table align="center" style="width:100%;">
	<tr>
		<td>
		<div align="left">
			<form><input type="button" onclick="location.href='index.php?func=FormMaker_List&bk=<? echo $_GET['bk'];?>'" value="Back To List"></form>
		</div>
		<div id="tabs" style="width:100%;" align="center">
		<ul>
			<li><a href="#tabs-1">Edit Category</a></li>
			<li><a href="#tabs-2">Edit Form Order</a></li>
		</ul>
		<div id="tabs-1">
			<iframe src="FormMaker_Category_Edit_grid.php" frameborder="0" width="920" height="640"></iframe>
		</div>
		<div id="tabs-2">
			<iframe src="FormMaker_Form_Edit_grid.php" frameborder="0" width="920" height="640"></iframe>
		</div>
		</div>
		</td>
	</tr>
</table>