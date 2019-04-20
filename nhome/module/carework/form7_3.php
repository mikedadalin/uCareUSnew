<?php
$pid = (int) @$_GET['pid'];
$parentName = "careform07";
$parentID = $pid;
if (isset($_POST['submit'])) {
	include('class/insertSubItem.php');
	include('class/updateSubItem.php');
	echo '<script>window.onbeforeunload=null;window.location.href="index.php?mod=carework&func=formview&id=7_3&pid='.$pid.'";</script>';
}
?>
<div class="moduleNoTab">
<form method="post" style="width:100%;">
<h3>Post catheter removal self/residual urination record</h3> <!-- 尿管移除後自解情形與餘尿紀錄 -->
<?php 
$tmpArr=array("Date","Time","Water intake","Self urination status","Filled by");
$tmpArrCol=array("title","content1","content2","content3","content4");
$tmpLength = count($tmpArr);
include("class/blockSubItem.php");
include("class/addSubItem.php");
?>
<center>
<input type="button" value="Back to list" id="back">
<input type="hidden" id="submit" value="Save" name="submit"/><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
</center>
</form>
</div>
<script>
$(function() {
	$('#back').click(function(){
		location.href = "index.php?mod=nurseform&func=formview&pid=<?php echo $_GET['pid']; ?>";
	});
});
</script>
