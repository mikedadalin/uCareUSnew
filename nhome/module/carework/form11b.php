<?php
$pid = (int) @$_GET['pid'];

if ($_GET['date']=="") {
	$date = date(Ym);
} else {
	$date = $_GET['date'];
}

$url = explode('/', $_SERVER['REQUEST_URI']);
$file = substr($url[3],0,5);

$Mday = date("t");
$arrayQ = array("","Sleeping Disturbance","Repetitive Behavior","Repetitive Words","Stool On Pants/Remove Diaper","Tendency To Attack Other","Say Bad Words to Others","Irritable","Complains","Uncooperative","Depressed","Halucination","Refuse To Eat","Wandering","Improper Sexual Behavior");

if (isset($_POST['submit'])) {
	if ($_POST['date']=="") { $_POST['date'] = date(Ym); }
	$db3 = new DB;
	$db3->query("SELECT * FROM `careform11b` WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".mysql_escape_string($_POST['date'])."'");
	if ($db3->num_rows()==0) {
		for ($i=1;$i<count($arrayQ);$i++) {
			$db3a = new DB;
			$db3a->query("INSERT INTO `careform11b` (`HospNo`, `date`, `QNO`) VALUES ('".mysql_escape_string($_POST['HospNo'])."', '".mysql_escape_string($_POST['date'])."', '".$i."');");
		}
	}
	foreach ($_POST as $k=>$v) {
		if (substr($k,0,2)=="Q_") {
			$arrQ = explode("_",$k);
			$db3b = new DB;
			$db3b->query("UPDATE `careform11b` SET `Q".$arrQ[2]."`='".$v."' WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".mysql_escape_string($_POST['date'])."' AND `QNO`='".$arrQ[1]."'");
		} elseif (substr($k,0,6)=="Qtotal") {
			$arrQ = explode("_",$k);
			$db3b = new DB;
			$db3b->query("UPDATE `careform11b` SET `Qtotal`='".$v."' WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".mysql_escape_string($_POST['date'])."' AND `QNO`='".$arrQ[1]."'");
		}
	}
	echo "<script>window.onbeforeunload=null;window.location.href='index.php?mod=carework&func=formview&pid=".$_GET['pid']."&id=11b&date=".$_POST['date']."'</script>";
}
?>
<div class="moduleNoTab">
<form  method="post" style="width:100%;">
<h3>Emotional behavior record</h3>
<select id="selmonth" name="date">
    <?php
    for ($i=date(m);$i>=(date(m)-6);$i--) {
        $month = $i;
        $year = date(Y);
        if ($i<1) {
            $month = 12+$i;
            $year = date(Y)-1;
        }
        if (strlen($month)==1) {
            $month = "0".$month;
        }
        echo '<option value="'.$year.$month.'" '.($_GET['date']==$year.$month?"selected":"").'>'.$year.'-'.$month.'</option>'."\n";
    }
    ?>
</select>
<input type="button" value="Search" onclick="printmed('<?php echo @$_GET['pid']; ?>')">
<script>
function printmed(pid) {
    var selectedmonth = document.getElementById('selmonth').value;
    window.location.href='index.php?mod=carework&func=formview&pid='+pid+'&id=11b&date='+selectedmonth;
}
</script>
<?php
if ($file=="index") {
	echo '<div style="width:960px; overflow-x:hidden; margin:0px auto;">';
} else {
	echo '<div>';
}
?> 
<table style="width:100%;" border="0" id="careform11btab">
  <thead>
  <tr style="font-size:18px;">
    <th nowrap>Behavior/Date</th>
    <?php for($i=1;$i<=$Mday;$i++){?>
    <th nowrap><?php echo str_pad($i,2,"0",STR_PAD_LEFT);; ?></th>
    <?php }?>
    <th nowrap>Total score</th>
  </tr>
  </thead>
  <tbody>
  <?php
  for ($j=1;$j<count($arrayQ);$j++){
	  $sql = "SELECT * FROM `careform11b` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`='".mysql_escape_string($date)."' AND `QNO`='".$j."'";
	  $db1 = new DB;
	  $db1->query($sql);
	  $r1 = $db1->fetch_assoc();
  ?>
  <tr>
    <td style="font-size:16px;" nowrap><?php echo $arrayQ[$j]; ?></td>
    <?php for($i=1;$i<=$Mday;$i++){?>
    <td><input type="text" id="Q_<?php echo $j; ?>_<?php echo $i; ?>" name="Q_<?php echo $j; ?>_<?php echo $i; ?>" size="1" style="height:20px; width:20px;font-size:10px; background-color:rgba(0,0,0,0.1);" value="<?php echo $r1['Q'.$i]; ?>" /></td>
    <?php }?>
    <td><span id="total_<?php echo $j; ?>"><?php if ($r1['Qtotal']==NULL) { echo "0"; } else { echo  $r1['Qtotal']; } ?></span>
    <input type="hidden" name="Qtotal_<?php echo $j; ?>" id="Qtotal_<?php echo $j; ?>" value="<?php if ($r1['Qtotal']==NULL) { echo "0"; } else { echo  $r1['Qtotal']; } ?>" style="height:20px; width:20px;font-size:10px;" readonly /></td>
  </tr>
  <?php } ?>
  </tbody>
</table>
</div>
<table width="100%" style="margin:0 auto;">
  <tr>
    <td style="background:#ffffff; border:none; padding-right:10px;" align="center">Filled By : <?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>
<center>
	<div style="margin:20px 0 10px 0"><input type="hidden" name="formID" id="formID" value="careform11b" /><input type="hidden" name="Qfiller" id="Qfiller" value="<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?>" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><input type="hidden" id="submit" name="submit" value="Save" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></div>
</center>
</form>
</div>
<?php
if ($file=="index") {
?>
<script>
$(document).ready(function () {
	calcQtotal();
	$('[id^="Q_"]').keyup(function() {
		calcQtotal();
	});
	var table123 = $('#careform11btab').DataTable({
		"scrollY": false,
        "scrollX": true,
        "scrollCollapse": false,
        "paging": false,
		"ordering": false,
		"searching": false
	});
	new $.fn.dataTable.FixedColumns( table123, {
		"iLeftColumns": 1,
      	"iRightColumns": 0
	});
})
function calcQtotal() {
	var D = <?php echo $Mday; ?>;
	var ArrayQ = <?php echo count($arrayQ);?>;
	for(var j=1;j<ArrayQ;j++){
		window['Qtotal_'+j] = 0;
	  	for (i=1;i<=D;i++) {
			if ($('#Q_'+j+'_'+i).val()!="") { window['Qtotal_'+j] += parseInt($('#Q_'+j+'_'+i).val()); }
		}
		var testtotal = window['Qtotal_'+j];
		$('#Qtotal_'+j).val(testtotal);
		$('#total_'+j).html(testtotal);
	}

}
</script>
<?php
}
?>
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