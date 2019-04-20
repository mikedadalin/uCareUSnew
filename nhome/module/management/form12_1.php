<h3>Add new medication frequency</h3>
<?php
if(isset($_POST['submit'])){
	$code = mysql_escape_string($_POST['code']);
	$name = mysql_escape_string($_POST['name']);
	$db = new DB;
	$db->query("SELECT * FROM `medfreq` WHERE `code`='".$code."' OR name='".$name."' ");
	if($db->num_rows() > 0 ){		
		echo '<script>alert("該用藥頻率已存在");</script>';
	}else{
		foreach ($_POST as $k=>$v) {
			$options = explode("_",$k);
			if(count($options) == 2)
			{
				if ($v==1) {
					if ($options[0]=="time") { $time .= ($options[1]-1).';'; }
					elseif ($options[0]=="avaliable") { $avaliable = $options[1]; }
				}
			}else{
				${$k} = $v;
			}
		}
		$db1 = new DB;
		$db1->query("INSERT INTO `medfreq` VALUES ('','".strtoupper($code)."', '".$name."', '".$time."', '', '".$avaliable."' );");
		echo '<script>alert("Medication frequency add successfully");window.onbeforeunload=null;window.location.href="index.php?mod=management&func=formview&id=12"</script>';
	}
}
?>
<form id="base" method="post">
<table style="width:100%; text-align:left;">
  <tr>
    <td class="title" width="120">Drug frequency code</td>
    <td colspan="3"><input type="text" name="code" id="code" value="" size="40" class="validate[required]" /></td>
  </tr>
  <tr>
    <td class="title" width="120">Drug/Medication</td>
    <td colspan="3"><input type="text" name="name" id="name" value="" size="40" class="validate[required]" /></td>
  </tr>
  <tr>
    <td class="title" width="120">Medication time</td>
    <td colspan="3"><?php echo draw_option("time","0;1;2;3;4;5;6;7;8;9;10;11;12;13;14;15;16;17;18;19;20;21;22;23","s","multi","",true,12);?></td>
  </tr>
  <tr>
    <td class="title">Set to favorate</td>
    <td colspan="3"><?php echo draw_option("avaliable","Yes;No","s","single",1,false,12); ?></td>
  </tr>
</table>
<center>
	<div style="margin-top:30px;">
	<input type="hidden" name="formID" id="formID" value="medfreq" /><input type="hidden" id="submit" value="Save" name="submit"/><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
	</div>
</center>
</form>
<script>
$(function() {
	$('#base').validationEngine();
});
</script>