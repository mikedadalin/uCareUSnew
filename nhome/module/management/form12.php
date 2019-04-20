<h3>Medication frequency</h3>
<form method="post" id="searchForm">
	<div style="width:100%;">
		<div style="float:left;">
			<input type="button" value="New medication frequency" onclick="window.location.href='index.php?mod=management&func=formview&pid=<?php echo @$_GET['pid']; ?>&id=12_1';" />
		</div>
		<div style="float:right;">
			Code/name: <input type="text" name="search" id="search" /><input type="submit" id="submit" value="Search" name="submit"/><input type="submit" id="submit" value="Display all" name="submit"/>
		</div>
	</div>
</form>
<table style="width:100%;">
	<tr class="title">
		<td width="120">Drug Frequency Code</td>
		<td>Drug/Medication</td>
		<td width="400">Medication Time</td>
		<td>Favorite</td>
		<td width="12%">Function</td>
	</tr>
	<?php
//設定常用
	if($_GET['star'] !="" && $_GET['freqID'] !=""){
		$db2 = new DB;
		$db2->query("UPDATE `medfreq` SET `avaliable`='".mysql_escape_string($_GET['star'])."' WHERE `freqID`= '".mysql_escape_string($_GET['freqID'])."'");
		echo '<script>window.location.href="index.php?mod=management&func=formview&id=12"</script>';
	}
//搜尋關鍵字
	if(isset($_POST['submit']) && $_POST['search'] !=""){
		$sql = " WHERE `code` like '%".strtoupper(mysql_escape_string($_POST['search']))."%' OR `name` like '%".mysql_escape_string($_POST['search'])."%' ";
	}else{
		$sql = "";
	}		

	$db = new DB;$db->query("SELECT * FROM `medfreq` ".$sql." ORDER BY avaliable, code ");
	for ($j=1;$j<=$db->num_rows();$j++) {
		$r = $db->fetch_assoc();
		foreach ($r as $k=>$v) { ${$k} = $v; }
		$medtimearr = explode(";",$time);
		foreach ($medtimearr as $k=>$v) {
			if ($v!="") {
				if ($medtimetxt!="") { $medtimetxt .= ";"; }
				$medtimetxt .= $v+1;
			}
		}
		$img = ($avaliable==1?"star_full":"star_empty");
		$avaliable1 = ($avaliable==1?"2":"1");
		echo '
		<tr>
		<td align="center">'.$code.'</td>
		<td style="padding:10px;">'.$name.'</td>
		<td style="padding:10px;">'.option_result("time","0;1;2;3;4;5;6;7;8;9;10;11;12;13;14;15;16;17;18;19;20;21;22;23","s","multi","".$medtimetxt."",true,12).'</td>
		<td align="center"><img src="Images/'.$img.'.png" width="24" title="Set to frequent usage" id="freq_'.$r['freqID'].'"></td>
		<td>
		<form><center><a href="index.php?mod=management&func=formview&id=12_2&freqID='.$freqID.'" title="Edit"><img src="Images/edit_icon.png" border="0" width="24"></a> <a href="" onClick="del(\''.$freqID.'\');" title="Delete"><img src="Images/delete2.png" width="24" ></a></center>
		</form></td>
		</tr>'."\n";
		$medtimetxt="";
	}
	?>
</table>
<script type="text/javascript">
function del(id){
	if (confirm("Confirm deletion of this item?")) {
		$.ajax({
			url: "class/delrow.php",
			type: "POST",
			data: {"formID": "medfreq", "colID": "freqID", "autoID": id },
			success: function(data) {
				if (data=="OK") {
					alert("Deletion successful !");
					window.location.reload();
				}
			}
		});
	}
}

$(function() {
	$("img[id^='freq_']").click(function(){
		var id = $(this).attr("id").split('_');
		var idname = $(this).attr("id");
		//id[1] = ApplyItemID
		$.ajax({
			url: "class/setEnableStar.php",
			type: "POST",
			data: {"table": 'medfreq', "autoID":'freqID', "colID":'avaliable', "ID": id[1], "type": 3 },
			success: function(data) {
				$('#'+idname).attr("src", "Images/"+data+".png");
			}
		});
	});
});
</script>

