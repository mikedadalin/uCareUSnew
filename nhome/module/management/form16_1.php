<h3>檢驗項目新增</h3>
<?php
if(isset($_POST['submit'])){
	$name = mysql_escape_string($_POST['name']);
	$nickname = mysql_escape_string($_POST['nickname']);
	$db = new DB;
	$db->query("SELECT * FROM `labitem` WHERE name='".$name."' ");
	if($db->num_rows() > 0 ){		
		echo '<script>alert("該檢驗項目已存在");</script>';
	}else{
		foreach ($_POST as $k=>$v) {
			${$k} = $v;
		}
		$db1 = new DB;
		$db1->query("INSERT INTO `labitem` VALUES ('','".strtoupper($category)."', '".$name."', '".$nickname."' );");
		echo '<script>alert("Examination add successfully");window.onbeforeunload=null;window.location.href="index.php?mod=management&func=formview&id=16"</script>';
	}
}
?>
<form id="base" method="post">
<table width="100%">
  <tr>
    <td class="title" width="120">Category</td>
    <td colspan="3"><select name="category" id="category" class="validate[required]">
    <option></option>
    <option value="生化血液">生化血液</option>
	<option value="血液">血液</option>
	<option value="尿液">尿液</option>
	<option value="Stool">Stool</option>
	<option value="放射">放射</option>
	<option value="Other">Other</option>
    </select></td>
  </tr>
  <tr>
    <td class="title" width="120">中文名稱</td>
    <td colspan="3"><input type="text" name="name" id="name" value="" size="30" class="validate[required]" /></td>
  </tr>
  <tr>
    <td class="title">英文名稱</td>
    <td colspan="3"><input type="text" name="nickname" id="nickname" value="" size="30" /></td>
  </tr>
</table>
<center><input type="hidden" name="formID" id="formID" value="labitem" /><input type="hidden" id="submit" value="Save" name="submit"/><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></center>
</form>
<script>
$(function() {
	$('#base').validationEngine();
});
</script>