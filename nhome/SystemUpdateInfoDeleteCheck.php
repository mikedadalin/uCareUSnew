<script>
if (confirm("Are you sure you want to delete this data?") == true) {
	if (confirm("If you do delete, this data can not be restored. Are you sure?") == true){
		document.location.href="index.php?func=SystemUpdateInfoDelete&noticeID=<?php echo $_GET['noticeID'];?>";
	}else{
		document.location.href="index.php?func=infoedit";
	}
}else{
	document.location.href="index.php?func=infoedit";
}
</script>
