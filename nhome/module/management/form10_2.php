<?php
if (isset($_POST['submit'])) {
	$tmp = array_pop($_POST);
	$db2a = new DB;
	$db2a->query("DELETE FROM `labset` WHERE `setID`='".mysql_escape_string($_POST['set'])."'");
	for ($i=0;$i<count($_POST['labid']);$i++) {
		$db2b = new DB;
		$db2b->query("INSERT INTO `labset` (`setID`, `description`, `labID`) VALUES ('".mysql_escape_string($_POST['set'])."', '".mysql_escape_string($_POST['description'])."', '".mysql_escape_string($_POST['labid'][$i])."');");
	}
	?>
	<script>
	alert('已經新增套組！');
	window.location.href='index.php?mod=management&func=formview&id=10';
	</script>
	<?php
}
$arrItemSet = array();
$db0 = new DB;
$db0->query("SELECT * FROM `labset` WHERE `setID`='".mysql_escape_string($_GET['set'])."'");
for ($i0=0;$i0<$db0->num_rows();$i0++) {
	$r0 = $db0->fetch_assoc();
	$arrItemSet[$i0] = $r0['labID'];
}
?>
<div class="content-table">
	<h3>Physical examination module setting</h3>
	<form id="base" method="post" action="index.php?mod=management&func=formview&id=10_2">
		<table style="text-align:left;">
			<tr>
				<td class="title" width="180">Module Name</td>
				<td><input type="text" name="description" id="description" size="40" class="validate[required]" value="<?php echo $r0['description']; ?>"></td>
			</tr>
			<tr>
				<td class="title">Item(s) Setting</td>
				<td style="padding-left:5px; padding-right:5px;">
					<?php
					$db1 = new DB;
					$db1->query("SELECT DISTINCT `category` FROM `labitem` ORDER BY `category`");
					for ($i1=0;$i1<$db1->num_rows();$i1++) {
						$r1 = $db1->fetch_assoc();
						echo '<h3>'.$r1['category'].'</h3>'."\n";
						$db1a = new DB;
						$db1a->query("SELECT * FROM `labitem` WHERE `category`='".$r1['category']."' ORDER BY `id` ASC");
						for ($i1a=1;$i1a<=$db1a->num_rows();$i1a++) {
							$r1a = $db1a->fetch_assoc();
							echo '<div style="width:240px;display:inline-block;"><span style="display:;"><input type="checkbox" name="labid[]" id="lab_'.$r1a['id'].'" value="'.$r1a['id'].'" class="validate[required]" '.(in_array($r1a['id'],$arrItemSet)?'checked':'').'> '.$r1a['name'].' '.$r1a['nickname'].'</span></div>'."\n";
							if ($i1a%3==0) { echo ''; }
						}
					}
					?>
				</td>
			</tr>
		</table>
		<div style="margin-top:30px; text-align:center;">
			<input type="hidden" name="set" value="<?php echo $_GET['set']; ?>"><input type="submit" name="submit" value="Save changes">
		</div>
	</form>
</div>
<script>
$('#base').validationEngine();
</script>