<?
if(isset($_POST['submit'])){
	if(isset($_POST['GroupID'])){
		$db = new DB;
		$db->query("UPDATE `formgroup` SET `ListName`='".mysql_escape_string($_POST['ListName'])."',`Description`='".mysql_escape_string($_POST['Description'])."',`cateID`='".mysql_escape_string($_POST['cateID'])."',`Qfiller`='".$_SESSION['ncareID_lwj']."' WHERE `GroupID`='".mysql_escape_string($_POST['GroupID'])."'");
		foreach($_POST as $k=>$v){
			$arr_k = explode("_",$k);
			if(count($arr_k)==2){
				$db2 = new DB;
				$db2->query("UPDATE `formorder` SET `serNo`='".$v."' WHERE `GroupID`='".mysql_escape_string($_POST['GroupID'])."' AND `order`='".$arr_k[1]."'");
			}
		}
		?>
		<script>alert('Edit!');</script>
        <script>window.location.href='index.php?mod=management&func=formview&id=30'</script>
		<?
	}else{
		$db = new DB;
		$db->query("INSERT INTO `formgroup` VALUES ('','".mysql_escape_string($_POST['ListName'])."','".mysql_escape_string($_POST['Description'])."','".mysql_escape_string($_POST['cateID'])."','".$_SESSION['ncareID_lwj']."')");
		$db2 = new DB;
		$db2->query("SELECT `GroupID` FROM `formgroup` WHERE `ListName`='".mysql_escape_string($_POST['ListName'])."' AND `Description`='".mysql_escape_string($_POST['Description'])."' AND `cateID`='".mysql_escape_string($_POST['cateID'])."' AND `Qfiller`='".$_SESSION['ncareID_lwj']."' ORDER BY `GroupID` DESC");
		for($i2=0;$i2<$db2->num_rows();$i2++){
			$r2 = $db2->fetch_assoc();
			foreach($_POST as $k=>$v){
				$arr_k = explode("_",$k);
				if(count($arr_k)==2){
					$db3 = new DB;
					$db3->query("INSERT INTO `formorder` VALUES ('".$r2['GroupID']."','".$arr_k[1]."','".$v."')");
				}
			}
		}
		?>
		<script>alert('New!');</script>
		<script>window.location.href='index.php?mod=management&func=formview&id=30'</script>
		<?
	}
}

if(isset($_GET['GID'])){
	$db = new DB;
	$db->query("SELECT * FROM `formgroup` WHERE `GroupID`='".mysql_escape_string($_GET['GID'])."'");
	if($db->num_rows()>0){
		$r = $db->fetch_assoc();
		$db2 = new DB;
		$db2->query("SELECT * FROM `formorder` WHERE `GroupID`='".$r['GroupID']."'");
		for($i2=0;$i2<$db2->num_rows();$i2++){
			$r2 = $db2->fetch_assoc();
			${'serNo_'.$r2['order']} = $r2['serNo'];
		}
	}
}
?>
<div align="center"><table><tr style="background-color:rgba(0,0,0,0);"><td>
<form method="post" action="">
<div align="left" style="padding:10px;"><button type="button" onclick="location.href='index.php?mod=management&func=formview&id=30'" style="background-color:#5C5C5C; border:0; border-radius:8px; height:40px; color:white;">Back To List</button></div>
<table>
	<tr>
		<td class="title">List Name</td>
		<td colspan="3"><input type="text" name="ListName" id="ListName" value="<? if($r['ListName']!=''){ echo $r['ListName']; }?>"></td>
	</tr>
	<tr>
		<td class="title">Description</td>
		<td colspan="3"><textarea name="Description" id="Description"><? if($r['Description']!=''){ echo $r['Description']; }?></textarea></td>
	</tr>
	<tr>
		<td class="title">Mod</td>
		<td colspan="3">
		<select name="cateID" id="cateID">
			<option value=""></option>
			<?
			$dbN = new DB2;
			$dbN->query("SELECT * FROM `permission2` WHERE `PermissionID`<'13' ORDER BY `order` ASC");
			for($i=0;$i<$dbN->num_rows();$i++){
				$rN = $dbN->fetch_assoc();
				if($rN['PermissionID']==$r['cateID']){ $select = ' selected="selected"'; }else{ $select = ''; }
				echo '<option value="'.$rN['PermissionID'].'"'.$select.'>'.$rN['Name'].'</option>';
			}
			?>
		</select>		
		</td>
	</tr>
	<tr>
		<td class="title_s">Sequence</td>
		<td class="title_s">Form Name</td>
		<td class="title_s">Sequence</td>
		<td class="title_s">Form Name</td>
	</tr>
	<tr style="text-align:center;">
		<td>1</td>
		<td>
		<?
		if(isset($_GET['GID']) && $r['cateID']!=''){
			echo '<select name="serNo_1" id="serNo_1">';
			echo '<option value=""></option>';
			$dbN2 = new DB2;
			$dbN2->query("SELECT `subcateID` FROM `permission_subcate` WHERE `cateID`='".$r['cateID']."'");
			for($i2=0;$i2<$dbN2->num_rows();$i2++){
				$rN2 = $dbN2->fetch_assoc();
				$dbN3 = new DB2;
				$dbN3->query("SELECT `serNo`,`name` FROM `permission_item` WHERE `subcateID`='".$rN2['subcateID']."' ORDER BY `ord` ASC");
				for($i3=0;$i3<$dbN3->num_rows();$i3++){
					$rN3 = $dbN3->fetch_assoc();
					if($rN3['serNo']==$serNo_1){ $select = ' selected="selected"'; }else{ $select = ''; }
					echo '<option value="'.$rN3['serNo'].'"'.$select.'>'.$rN3['name'].'</option>';
				}
			}
			echo '</select>';
		}else{
			echo '
			<select name="serNo_1" id="serNo_1" disabled>
				<option>---First select Mod---</option>
			</select>';
		}
		?>
		</td>
		<td>6</td>
		<td>
		<?
		if(isset($_GET['GID']) && $r['cateID']!=''){
			echo '<select name="serNo_6" id="serNo_6">';
			echo '<option value=""></option>';
			$dbN2 = new DB2;
			$dbN2->query("SELECT `subcateID` FROM `permission_subcate` WHERE `cateID`='".$r['cateID']."'");
			for($i2=0;$i2<$dbN2->num_rows();$i2++){
				$rN2 = $dbN2->fetch_assoc();
				$dbN3 = new DB2;
				$dbN3->query("SELECT `serNo`,`name` FROM `permission_item` WHERE `subcateID`='".$rN2['subcateID']."' ORDER BY `ord` ASC");
				for($i3=0;$i3<$dbN3->num_rows();$i3++){
					$rN3 = $dbN3->fetch_assoc();
					if($rN3['serNo']==$serNo_6){ $select = ' selected="selected"'; }else{ $select = ''; }
					echo '<option value="'.$rN3['serNo'].'"'.$select.'>'.$rN3['name'].'</option>';
				}
			}
			echo '</select>';
		}else{
			echo '
			<select name="serNo_6" id="serNo_6" disabled>
				<option>---First select Mod---</option>
			</select>';
		}
		?>
		</td>
	</tr>
	<tr style="text-align:center;">
		<td>2</td>
		<td>
		<?
		if(isset($_GET['GID']) && $r['cateID']!=''){
			echo '<select name="serNo_2" id="serNo_2">';
			echo '<option value=""></option>';
			$dbN2 = new DB2;
			$dbN2->query("SELECT `subcateID` FROM `permission_subcate` WHERE `cateID`='".$r['cateID']."'");
			for($i2=0;$i2<$dbN2->num_rows();$i2++){
				$rN2 = $dbN2->fetch_assoc();
				$dbN3 = new DB2;
				$dbN3->query("SELECT `serNo`,`name` FROM `permission_item` WHERE `subcateID`='".$rN2['subcateID']."' ORDER BY `ord` ASC");
				for($i3=0;$i3<$dbN3->num_rows();$i3++){
					$rN3 = $dbN3->fetch_assoc();
					if($rN3['serNo']==$serNo_2){ $select = ' selected="selected"'; }else{ $select = ''; }
					echo '<option value="'.$rN3['serNo'].'"'.$select.'>'.$rN3['name'].'</option>';
				}
			}
			echo '</select>';
		}else{
			echo '
			<select name="serNo_2" id="serNo_2" disabled>
				<option>---First select Mod---</option>
			</select>';
		}
		?>
		</td>
		<td>7</td>
		<td>
		<?
		if(isset($_GET['GID']) && $r['cateID']!=''){
			echo '<select name="serNo_7" id="serNo_7">';
			echo '<option value=""></option>';
			$dbN2 = new DB2;
			$dbN2->query("SELECT `subcateID` FROM `permission_subcate` WHERE `cateID`='".$r['cateID']."'");
			for($i2=0;$i2<$dbN2->num_rows();$i2++){
				$rN2 = $dbN2->fetch_assoc();
				$dbN3 = new DB2;
				$dbN3->query("SELECT `serNo`,`name` FROM `permission_item` WHERE `subcateID`='".$rN2['subcateID']."' ORDER BY `ord` ASC");
				for($i3=0;$i3<$dbN3->num_rows();$i3++){
					$rN3 = $dbN3->fetch_assoc();
					if($rN3['serNo']==$serNo_7){ $select = ' selected="selected"'; }else{ $select = ''; }
					echo '<option value="'.$rN3['serNo'].'"'.$select.'>'.$rN3['name'].'</option>';
				}
			}
			echo '</select>';
		}else{
			echo '
			<select name="serNo_7" id="serNo_7" disabled>
				<option>---First select Mod---</option>
			</select>';
		}
		?>
		</td>
	</tr>
	<tr style="text-align:center;">
		<td>3</td>
		<td>
		<?
		if(isset($_GET['GID']) && $r['cateID']!=''){
			echo '<select name="serNo_3" id="serNo_3">';
			echo '<option value=""></option>';
			$dbN2 = new DB2;
			$dbN2->query("SELECT `subcateID` FROM `permission_subcate` WHERE `cateID`='".$r['cateID']."'");
			for($i2=0;$i2<$dbN2->num_rows();$i2++){
				$rN2 = $dbN2->fetch_assoc();
				$dbN3 = new DB2;
				$dbN3->query("SELECT `serNo`,`name` FROM `permission_item` WHERE `subcateID`='".$rN2['subcateID']."' ORDER BY `ord` ASC");
				for($i3=0;$i3<$dbN3->num_rows();$i3++){
					$rN3 = $dbN3->fetch_assoc();
					if($rN3['serNo']==$serNo_3){ $select = ' selected="selected"'; }else{ $select = ''; }
					echo '<option value="'.$rN3['serNo'].'"'.$select.'>'.$rN3['name'].'</option>';
				}
			}
			echo '</select>';
		}else{
			echo '
			<select name="serNo_3" id="serNo_3" disabled>
				<option>---First select Mod---</option>
			</select>';
		}
		?>
		</td>
		<td>8</td>
		<td>
		<?
		if(isset($_GET['GID']) && $r['cateID']!=''){
			echo '<select name="serNo_8" id="serNo_8">';
			echo '<option value=""></option>';
			$dbN2 = new DB2;
			$dbN2->query("SELECT `subcateID` FROM `permission_subcate` WHERE `cateID`='".$r['cateID']."'");
			for($i2=0;$i2<$dbN2->num_rows();$i2++){
				$rN2 = $dbN2->fetch_assoc();
				$dbN3 = new DB2;
				$dbN3->query("SELECT `serNo`,`name` FROM `permission_item` WHERE `subcateID`='".$rN2['subcateID']."' ORDER BY `ord` ASC");
				for($i3=0;$i3<$dbN3->num_rows();$i3++){
					$rN3 = $dbN3->fetch_assoc();
					if($rN3['serNo']==$serNo_8){ $select = ' selected="selected"'; }else{ $select = ''; }
					echo '<option value="'.$rN3['serNo'].'"'.$select.'>'.$rN3['name'].'</option>';
				}
			}
			echo '</select>';
		}else{
			echo '
			<select name="serNo_8" id="serNo_8" disabled>
				<option>---First select Mod---</option>
			</select>';
		}
		?>
		</td>
	</tr>
	<tr style="text-align:center;">
		<td>4</td>
		<td>
		<?
		if(isset($_GET['GID']) && $r['cateID']!=''){
			echo '<select name="serNo_4" id="serNo_4">';
			echo '<option value=""></option>';
			$dbN2 = new DB2;
			$dbN2->query("SELECT `subcateID` FROM `permission_subcate` WHERE `cateID`='".$r['cateID']."'");
			for($i2=0;$i2<$dbN2->num_rows();$i2++){
				$rN2 = $dbN2->fetch_assoc();
				$dbN3 = new DB2;
				$dbN3->query("SELECT `serNo`,`name` FROM `permission_item` WHERE `subcateID`='".$rN2['subcateID']."' ORDER BY `ord` ASC");
				for($i3=0;$i3<$dbN3->num_rows();$i3++){
					$rN3 = $dbN3->fetch_assoc();
					if($rN3['serNo']==$serNo_4){ $select = ' selected="selected"'; }else{ $select = ''; }
					echo '<option value="'.$rN3['serNo'].'"'.$select.'>'.$rN3['name'].'</option>';
				}
			}
			echo '</select>';
		}else{
			echo '
			<select name="serNo_4" id="serNo_4" disabled>
				<option>---First select Mod---</option>
			</select>';
		}
		?>
		</td>
		<td>9</td>
		<td>
		<?
		if(isset($_GET['GID']) && $r['cateID']!=''){
			echo '<select name="serNo_9" id="serNo_9">';
			echo '<option value=""></option>';
			$dbN2 = new DB2;
			$dbN2->query("SELECT `subcateID` FROM `permission_subcate` WHERE `cateID`='".$r['cateID']."'");
			for($i2=0;$i2<$dbN2->num_rows();$i2++){
				$rN2 = $dbN2->fetch_assoc();
				$dbN3 = new DB2;
				$dbN3->query("SELECT `serNo`,`name` FROM `permission_item` WHERE `subcateID`='".$rN2['subcateID']."' ORDER BY `ord` ASC");
				for($i3=0;$i3<$dbN3->num_rows();$i3++){
					$rN3 = $dbN3->fetch_assoc();
					if($rN3['serNo']==$serNo_9){ $select = ' selected="selected"'; }else{ $select = ''; }
					echo '<option value="'.$rN3['serNo'].'"'.$select.'>'.$rN3['name'].'</option>';
				}
			}
			echo '</select>';
		}else{
			echo '
			<select name="serNo_9" id="serNo_9" disabled>
				<option>---First select Mod---</option>
			</select>';
		}
		?>
		</td>
	</tr>
	<tr style="text-align:center;">
		<td>5</td>
		<td>
		<?
		if(isset($_GET['GID']) && $r['cateID']!=''){
			echo '<select name="serNo_5" id="serNo_5">';
			echo '<option value=""></option>';
			$dbN2 = new DB2;
			$dbN2->query("SELECT `subcateID` FROM `permission_subcate` WHERE `cateID`='".$r['cateID']."'");
			for($i2=0;$i2<$dbN2->num_rows();$i2++){
				$rN2 = $dbN2->fetch_assoc();
				$dbN3 = new DB2;
				$dbN3->query("SELECT `serNo`,`name` FROM `permission_item` WHERE `subcateID`='".$rN2['subcateID']."' ORDER BY `ord` ASC");
				for($i3=0;$i3<$dbN3->num_rows();$i3++){
					$rN3 = $dbN3->fetch_assoc();
					if($rN3['serNo']==$serNo_5){ $select = ' selected="selected"'; }else{ $select = ''; }
					echo '<option value="'.$rN3['serNo'].'"'.$select.'>'.$rN3['name'].'</option>';
				}
			}
			echo '</select>';
		}else{
			echo '
			<select name="serNo_5" id="serNo_5" disabled>
				<option>---First select Mod---</option>
			</select>';
		}
		?>
		</td>
		<td>10</td>
		<td>
		<?
		if(isset($_GET['GID']) && $r['cateID']!=''){
			echo '<select name="serNo_10" id="serNo_10">';
			echo '<option value=""></option>';
			$dbN2 = new DB2;
			$dbN2->query("SELECT `subcateID` FROM `permission_subcate` WHERE `cateID`='".$r['cateID']."'");
			for($i2=0;$i2<$dbN2->num_rows();$i2++){
				$rN2 = $dbN2->fetch_assoc();
				$dbN3 = new DB2;
				$dbN3->query("SELECT `serNo`,`name` FROM `permission_item` WHERE `subcateID`='".$rN2['subcateID']."' ORDER BY `ord` ASC");
				for($i3=0;$i3<$dbN3->num_rows();$i3++){
					$rN3 = $dbN3->fetch_assoc();
					if($rN3['serNo']==$serNo_10){ $select = ' selected="selected"'; }else{ $select = ''; }
					echo '<option value="'.$rN3['serNo'].'"'.$select.'>'.$rN3['name'].'</option>';
				}
			}
			echo '</select>';
		}else{
			echo '
			<select name="serNo_10" id="serNo_10" disabled>
				<option>---First select Mod---</option>
			</select>';
		}
		?>
		</td>
	</tr>
	<tr>
		<? if($r['GroupID']!=''){ echo '<input type="hidden" name="GroupID" id="GroupID" value="'.$r['GroupID'].'">'; }?>
		<td class="title_s" colspan="4"><input type="submit" name="submit" id="submit" value="Submit"></td>
	</tr>
</table>
</form>
</td></tr></table></div>
<script>
$('#cateID').change(function(){
	$.ajax({
		url: "class/getFormList.php",
		type: "POST",
		data: { "cateID": $("#cateID").val()},
		success: function(data) {
			if (data=="no") {
				for(var i=1;i<11;i++){
					var ID = '#serNo_'+i;
					var optionID = '#serNo_'+i+' option';
					$(optionID).remove();
					$(ID).append($("<option></option>").attr("value", "").text("---First select Mod---"));
					$(ID).attr("disabled",true);
				}
			} else {
				var arr = data.split(';');
				for(var i=0;i<10;i++){
					var ID = '#serNo_'+eval(i+1);
					var optionID = '#serNo_'+eval(i+1)+' option';
					$(ID).attr("disabled",false);
					$(optionID).remove();
					$(ID).append($("<option></option>"));
					for (var i2=0; i2<arr.length; i2++) {
						var arr2 = arr[i2].split(':');
						$(ID).append($("<option></option>").attr("value", arr2[0]).text(arr2[1]));
					}
				}
			}
		}
	});
});
</script>