<?php
if (@$_GET['date']=='') {
	$sql = "SELECT * FROM `careform06` WHERE `HospNo`='".$HospNo."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql = "SELECT * FROM `careform06` WHERE `HospNo`='".$HospNo."' AND `date`='".mysql_escape_string($_GET['date'])."'";
}
$db1 = new DB;
$db1->query($sql);
$r1 = $db1->fetch_assoc();
if ($db1->num_rows()>0) {
	foreach ($r1 as $k=>$v) {
		if (substr($k,0,1)=="Q") {
			$arrAnswer = explode("_",$k);
			if (count($arrAnswer)==2) {
				if ($v==1) {
					${$arrAnswer[0]} .= $arrAnswer[1].';';
				}
			} else {
				${$k} = $v;
			}
		}  else {
			${$k} = $v;
		}
	}
}

if(isset($_POST['submit'])) {
$db3 = new DB;
$date_save = date("Ymd");
$db3->query("INSERT INTO `".$_POST['formID']."` (`HospNo`, `date`,`Qfiller`) VALUES ('".mysql_escape_string($_POST['HospNo'])."', '".$date_save."','".$_SESSION['ncareID_lwj']."');");
    foreach ($_POST as $k=>$v){

        if (substr($k,0,1)=="Q" && $k != 'Qfiller') {
            $db4 = new DB;
            $db4->query("UPDATE `".$_POST['formID']."` SET `".mysql_escape_string($k)."`='".mysql_escape_string($v)."' WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".$date_save."'");
        }   
    }
}
?>
<div class="moduleNoTab">
<form  method="post">
<h3>Toileting schedule record</h3>
<table style="width:100%;">
  <tr>
    <td class="title">Time</td>
    <td class="title">Item(s)</td>
  </tr>
  <tr>
    <td class="title_s">06：00</td>
    <td>
        <?php echo draw_checkbox_2col("Q1","Micturition (frequently);Induced urinary;Self-controlled voiding;None;Incontinence",$Q1,"single"); ?>
    </td>
  </tr>
  <tr>
    <td class="title_s">08：00</td>
    <td>
        <?php echo draw_checkbox_2col("Q2","Micturition (frequently);Induced urinary;Self-controlled voiding;None;Incontinence",$Q2,"single"); ?>
    </td>
  </tr>
  <tr>
    <td class="title_s">10：00</td>
    <td>
        <?php echo draw_checkbox_2col("Q3","Micturition (frequently);Induced urinary;Self-controlled voiding;None;Incontinence",$Q3,"single"); ?>
    </td>
  </tr>
  <tr>
    <td class="title_s">12：00</td>
    <td>
        <?php echo draw_checkbox_2col("Q4","Micturition (frequently);Induced urinary;Self-controlled voiding;None;Incontinence",$Q4,"single"); ?>
    </td>
  </tr>
  <tr>
    <td class="title_s">14：00</td>
    <td>
        <?php echo draw_checkbox_2col("Q5","Micturition (frequently);Induced urinary;Self-controlled voiding;None;Incontinence",$Q5,"single"); ?>
    </td>
  </tr>
  <tr>
    <td class="title_s">16：00</td>
    <td>
        <?php echo draw_checkbox_2col("Q6","Micturition (frequently);Induced urinary;Self-controlled voiding;None;Incontinence",$Q6,"single"); ?>
    </td>
  </tr>
  <tr>
    <td class="title_s">18：00</td>
    <td>
        <?php echo draw_checkbox_2col("Q7","Micturition (frequently);Induced urinary;Self-controlled voiding;None;Incontinence",$Q7,"single"); ?>
    </td>
  </tr>
  <tr>
    <td class="title_s">20：00</td>
    <td>
        <?php echo draw_checkbox_2col("Q8","Micturition (frequently);Induced urinary;Self-controlled voiding;None;Incontinence",$Q8,"single"); ?>
    </td>
  </tr>
</table>  
<center><div style="margin:20px 0px 10px 0px;">
<input type="hidden" name="formID" id="formID" value="careform06" />
<input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" />
<input type="submit" id="submit" name="submit" value="Save"/>
<input type="button" id="back" value="Back to list" />
</div></center>
</form>
<?php
if ($r1) {
foreach ($r1 as $k=>$v) {
	if (substr($k,0,1)=="Q") {
		$arrAnswer = explode("_",$k);
		if (count($arrAnswer)==2) {
			if ($v==1) {
				${$arrAnswer[0]} = "";
			}
		} else {
			${$k} = "";
		}
	}  else {
		${$k} = "";
	}
}
}
?>
</div>
<script>
$(function() {
	$('div[id^=btn_Q]').click(function() {
		var id = $(this).attr('id');
		$.ajax({
			url: "class/careform06.php",
			type: "POST",
			data: {"formID": "careform06", "Q": id, "HospNo":$("#HospNo").val(),"date":'<?php echo $_GET['date'];?>' },
			success: function(data) {
				if(data=='1'){
					alert('Insufficient permissions! Please notify the original input personnel to modify or select other dates to save as a new data!');
					window.location.reload();
				}else{
					//location.href = "index.php?mod=carework&func=formview&id=6&pid=<?php echo $_GET['pid']; ?>";
					alert('Saved successfully!');
					window.location.reload();
				}
			}
		});
    });
	$('#back').click(function(){
		location.href = "index.php?mod=carework&func=formview&id=6&pid=<?php echo $_GET['pid']; ?>";
	});
});
</script>