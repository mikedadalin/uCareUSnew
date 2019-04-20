<h3>Modify medication frequency</h3>
<?php
$freqID = mysql_escape_string($_GET['freqID']);

if(isset($_POST['submit']) && $freqID !=""){
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
	$db1->query("UPDATE `medfreq` SET `code`='".strtoupper($code)."', `name`='".$name."', `time`='".$time."', `avaliable`='".$avaliable."' WHERE `freqID`='".$freqID."';");
	echo '<script>alert("Medication frequency modified successfully");window.onbeforeunload=null;window.location.href="index.php?mod=management&func=formview&id=12"</script>';
}


$db = new DB;
$db->query("SELECT * FROM `medfreq`  WHERE `freqID` = '".$freqID."' ");
if($db->num_rows()==0){echo '<script>window.location.href="index.php?mod=management&func=formview&id=12"</script>';}
if($db->num_rows() > 0){
	$r = $db->fetch_assoc();
	foreach ($r as $k=>$v) { ${$k} = $v; }
	$medtimearr = explode(";",$time);
	foreach ($medtimearr as $k=>$v) {
		if ($v!="") {
			if ($medtimetxt!="") { $medtimetxt .= ";"; }
			$medtimetxt .= $v+1;
		}
	}
?>
<form id="base" method="post">
<table style="width:100%; text-align:left;">
  <tr>
    <td class="title" width="120">Drug frequency code</td>
    <td colspan="3"><input type="text" name="code" id="code"  size="40" class="validate[required]" value="<?php echo $code;?>"/></td>
  </tr>
  <tr>
    <td class="title" width="120">Drug/Medication</td>
    <td colspan="3"><input type="text" name="name" id="name"  size="40" class="validate[required]" value="<?php echo $name;?>"/></td>
  </tr>
  <tr>
    <td class="title" width="120">Medication time</td>
    <td colspan="3"><?php echo draw_option("time","0;1;2;3;4;5;6;7;8;9;10;11;12;13;14;15;16;17;18;19;20;21;22;23","s","multi",$medtimetxt,true,12);?></td>
  </tr>
  <tr>
    <td class="title">Set to favorate</td>
    <td colspan="3"><?php echo draw_option("avaliable","Yes;No","s","single",$avaliable,false,12); ?></td>
  </tr>
</table>
<center>
	<div style="margin-top:30px">
	<input type="hidden" name="formID" id="formID" value="medfreq" /><input type="button" value="Back to list" onClick="window.location.href='index.php?mod=management&func=formview&id=12'"/><input type="hidden" id="submit" value="Save" name="submit"/><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
	</div>
</center>
</form>
<?php 
}
?>
<script>
$(function() {
	$('#base').validationEngine();
});
</script>