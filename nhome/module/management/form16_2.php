<h3>檢驗項目編輯</h3>
<?php
$labID = mysql_escape_string($_GET['labID']);

if(isset($_POST['submit']) && $labID !=""){
	foreach ($_POST as $k=>$v) {
		${$k} = $v;
	}
	$db1 = new DB;
	$db1->query("UPDATE `labitem` SET `name`='".$name."', `nickname`='".$nickname."', `category`='".$category."' WHERE `id`='".$labID."';");
	echo '<script>alert("Examination item modified successfully");window.onbeforeunload=null;window.location.href="index.php?mod=management&func=formview&id=16"</script>';
}


$db = new DB;
$db->query("SELECT * FROM `labitem`  WHERE `id` = '".$labID."' ");
if($db->num_rows()==0){echo '<script>window.location.href="index.php?mod=management&func=formview&id=16"</script>';}
if($db->num_rows() > 0){
	$r = $db->fetch_assoc();
	foreach ($r as $k=>$v) { ${$k} = $v; }
?>
<form id="base" method="post">
<table width="100%">
  <tr>
    <td class="title" width="120">Category</td>
    <td colspan="3"><select name="category" id="category" class="validate[required]">
    <option></option>
    <option value="生化血液" <?php echo ($category=="生化血液"?"selected":""); ?>>生化血液</option>
	<option value="血液" <?php echo ($category=="血液"?"selected":""); ?>>血液</option>
	<option value="尿液" <?php echo ($category=="尿液"?"selected":""); ?>>尿液</option>
	<option value="Stool" <?php echo ($category=="Stool"?"selected":""); ?>>Stool</option>
	<option value="放射" <?php echo ($category=="放射"?"selected":""); ?>>放射</option>
	<option value="Other" <?php echo ($category=="Other"?"selected":""); ?>>Other</option>
    </select></td>
  </tr>
  <tr>
    <td class="title" width="120">中文名稱</td>
    <td colspan="3"><input type="text" name="name" id="name" value="<?php echo $name; ?>" size="30" class="validate[required]" /></td>
  </tr>
  <tr>
    <td class="title">英文名稱</td>
    <td colspan="3"><input type="text" name="nickname" id="nickname" value="<?php echo $nickname; ?>" size="30" /></td>
  </tr>
</table>
<center><input type="hidden" name="formID" id="formID" value="labitem" /><input type="button" value="Back to list" onClick="window.location.href='index.php?mod=management&func=formview&id=16'"/><input type="hidden" id="submit" value="Save" name="submit"/><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></center>
</form>
<?php 
}
?>
<script>
$(function() {
	$('#base').validationEngine();
});
</script>