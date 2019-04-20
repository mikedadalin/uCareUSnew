<center>
<div class="moduleNoTab">
<?php
$url = explode("/",$_SERVER['PHP_SELF']);
if (substr($url[3],0,5)!="print"){
	echo '<table align="left" style="width:100px"><tr id="backtr"><td class="backbtnn" align="center" id="backbtn" style="border:none; width:100px; height:30px;"><a href="index.php?mod=management&func=formview" style="font-size:14px;">Back to List</a></td></tr></table>';
}
?>
<h3 style="margin-top:50px;">Data backup</h3>
<form>
<a style="font-size:20px; font-weight:bolder; color:#585858;">Input data backup password: </a><input type="password" name="backuppsw" id="backuppsw" size="20">
<input type="button" value="Backup" id="backup" onclick="backup_action_performed()">
</form>
<script>
function backup_action_performed() {
	$.ajax({
		url: "checkbackuppsw.php",
		type: "POST",
		data: {"backuppsw": $("#backuppsw").val()  },
		success: function(data) {
			if (data=="NOTSET") {
				alert('請先至「行政」內的「系統設定」設置備份密碼！');
			} else if (data=="NOTMATCH") {
				$("#backuppsw").val('');
				alert('密碼不符合，請重試！');
			} else if (data=="OK") {
				$("#backuppsw").val('');
				window.open('dbbackup2csv.php');
			}
		}
	});
}

</script>
</div></center>