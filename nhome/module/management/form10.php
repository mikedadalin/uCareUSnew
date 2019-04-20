<div class="content-table">
	<h3>Physical examination module setting</h3>
	<form>
		<div align="right">
			<input type="button" onclick="window.location.href='index.php?mod=management&func=formview&id=10_1'" value="Add new module">
		</div>
		<table>
			<tr class="title">
				<td>Edit</td>
				<td width="180">Module Name</td>
				<td>Item(s)</td>
			</tr>
			<?php
			$db1 = new DB;
			$db1->query("SELECT DISTINCT `setID` FROM `labset` ORDER BY `setID`");
			for ($i1=0;$i1<$db1->num_rows();$i1++) {
				$r1 = $db1->fetch_assoc();
				$itemContent = "";
				$db2 = new DB;
				$db2->query("SELECT * FROM `labset` WHERE `setID`='".$r1['setID']."'");
				for ($i2=0;$i2<$db2->num_rows();$i2++) {
					$r2 = $db2->fetch_assoc();
					$db3 = new DB;
					$db3->query("SELECT * FROM `labitem` WHERE `id`='".$r2['labID']."'");
					$r3 = $db3->fetch_assoc();
					$itemContent .= '<div style="width:230px;display:inline-block;">'.$r3['name'].' '.$r3['nickname'].'</div>';
				}
				echo '
				<tr>
				<td style="padding:5px;"><a href="index.php?mod=management&func=formview&id=10_2&set='.$r1['setID'].'"><img src="Images/edit_icon.png"></a></td>
				<td align="center" style="padding:5px;">'.$r2['description'].'</td>
				<td style="padding:10px;">'.$itemContent.'</td>
				</tr>
				';
			}
			?>
		</table>
	</form>
</div>