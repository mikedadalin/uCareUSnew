<form><input type="button" id="show_content" name="show_content" value="Instructions"></form>
<?php 
	$db_manual = new DB2;
	$db_manual->query("SELECT * FROM `system_manual` WHERE `table`='".$manual_table."'");
	$r_manual = $db_manual->fetch_assoc();
?>
<h4 class="rangeH" style="display:none;"><?php echo $r_manual['txt'];?></h4>
<script>
$(function () {
	$("#show_content").click(function(){
		$('.rangeH').toggle();
	});
});
</script>
