<?php
if(substr($_SESSION['ncareID_lwj'],0,8)=="resident"){
$HospNo = substr($_SESSION['ncareID_lwj'],8,6);
$db = new DB;
$db->query("SELECT `patientID` FROM `patient` WHERE `HospNo`='".mysql_escape_string($HospNo)."'");
$r = $db->fetch_assoc();
$url = "index.php?mod=nurseform&func=formview&pid=".$r['patientID'];
echo "<script type='text/javascript'>";
echo 'window.location.href="'.$url.'"';
echo "</script>";
}else{
?>
<div style="font-size:10pt; background-color: rgba(255,255,255,0.7); border-radius: 10px; margin-bottom:0px; width:100%;">
<div align="center" style="padding-top:15px; margin:0 10px;"><h3 style="color:#69b3b6;">Work Memo</h3></div>
<div style="overflow-x:hidden; text-align:center; margin:0px auto; width:672px;">
<table align="center" style="border-radius:10px; position:fixed; z-index:1; width:672px;">
  <tr style="font-size:11pt; background-color:rgba(105,179,182,0.9); color:white;">
    <td>Resident</td>
	<?php
	$db1 = new DB;
	$db1->query("SELECT * FROM `workmemolist` ORDER BY `order`");
    for ($i1=0;$i1<$db1->num_rows();$i1++) {
        $r1 = $db1->fetch_assoc();
    ?>
    <td width="90px;">
	  <?php echo $r1['name']; ?><br>
	  <?php if($i1!=0){ echo '<a href="index.php?func=changeWorkMemoOrder&MemoID='.$r1['MemoID'].'&order='.$r1['order'].'&action=UP" style="color:rgb(238,203,53);"><i class="fa fa-chevron-circle-left"></i></a>'; } ?>
	  <a style="color:rgb(238,203,53);">order</a>
	  <?php if($i1!=$db1->num_rows()-1){ echo '<a href="index.php?func=changeWorkMemoOrder&MemoID='.$r1['MemoID'].'&order='.$r1['order'].'&action=DOWN" style="color:rgb(238,203,53);"><i class="fa fa-chevron-circle-right"></i></a>'; } ?>
	</td>
	<?php
    }
    ?>
  </tr>
</table>
<table style="border-radius:10px; margin-top:75px; width:672px;">
  <tr style="font-size:10pt;">
  <?php
  $db = new DB;
  $db->query("SELECT * FROM `inpatientinfo` ORDER BY `bed` ASC");
  for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
		$db1 = new DB;
		$db1->query("SELECT `patientID`,`HospNo`,`HospNoDisplay`,`instat` FROM `patient` WHERE `patientID`='".$r['patientID']."' ORDER BY `patientID` DESC LIMIT 0,1");
		for ($j=0;$j<$db1->num_rows();$j++) {
			$r1 = $db1->fetch_assoc();
			echo '
			<tr'.($_SESSION['ncareOrgStatus_lwj']==2 && $r1['instat']==0?' style="display:none;"':"").'>';
			if($_GET['pid']==$r1['patientID']){
				echo '<td align="left" style="background-color:rgba(245,215,101,0.7); font-size:10pt; padding:7px;">';
			}else{
				echo '<td align="left" style="background-color:rgba(255,255,255,0.8); font-size:10pt; padding:7px;">';
			}
			echo $r['bed'].' '.$r1['HospNoDisplay'].'<br>'.getPatientName($r1['patientID']).'<br>'.formatdate($r['indate']).'</td>'."\n";
			  $db2 = new DB;
			  $db2->query("SELECT * FROM `workmemocheck` WHERE `date`='".date(Ymd)."' AND `HospNo`='".$r1['HospNo']."' AND `Qfiller`='".$_SESSION['ncareID_lwj']."'");
			  if($db2->num_rows()>0){
				  $r2 = $db2->fetch_assoc();
				  $CheckedMemoID = "";
				  foreach($r2 as $k2=>$v2){
					  $arrWorkMemo = explode("_",$k2);
					  if (count($arrWorkMemo)==2) {
						  if ($v2==1) {
							   $CheckedMemoID .= $arrWorkMemo[1].";";
						  }
					  }
				  }
				  $arrCheckedMemoID = explode(";",$CheckedMemoID);
				  $db3 = new DB;
				  $db3->query("SELECT * FROM `workmemolist` ORDER BY `order`");
				  for ($z=0;$z<$db3->num_rows();$z++) {
					  $r3 = $db3->fetch_assoc();
					  if($_GET['pid']==$r1['patientID']){
						  echo '<td width="90px;" style="background-color:rgba(245,215,101,0.7);">';
					  }else{
						  echo '<td width="90px;" style="background-color:rgba(255,255,255,0.8);">';
					  }					  
					  if(in_array($r3['MemoID'],$arrCheckedMemoID)){
						  echo '<button id="MemoID_'.$r3['MemoID'].'_OFF_'.$r1['patientID'].'"><i id="MemoID_'.$r3['MemoID'].'_OFF_'.$r1['patientID'].'_icon" class="fa fa-check-square-o"></i></button></td>';
					  }else{
						  echo '<button id="MemoID_'.$r3['MemoID'].'_ON_'.$r1['patientID'].'"><i id="MemoID_'.$r3['MemoID'].'_ON_'.$r1['patientID'].'_icon" class="fa fa-square-o"></i></button></td>';
					  }
				  }
			  }else{
				  $db3 = new DB;
				  $db3->query("SELECT * FROM `workmemolist` ORDER BY `order`");
				  for ($z=0;$z<$db3->num_rows();$z++) {
					  $r3 = $db3->fetch_assoc();
					  if($_GET['pid']==$r1['patientID']){
						  echo '<td width="90px;" style="background-color:rgba(245,215,101,0.7);">';
					  }else{
						  echo '<td width="90px;" style="background-color:rgba(255,255,255,0.8);">';
					  }
					  echo '<button id="MemoID_'.$r3['MemoID'].'_ON_'.$r1['patientID'].'"><i id="MemoID_'.$r3['MemoID'].'_ON_'.$r1['patientID'].'_icon" class="fa fa-square-o"></i></button></td>';
				  }
			  }
			  echo '</tr>'."\n";
		}
  }
?>
</table>
</div>
<br>
</div>
<script>
$(function() {
	$('button:button[id^="MemoID_"]').click(function() {
		var arrID = $(this).attr('id');
		arrID = arrID.split('_');
		var PID = arrID[3];
		var Action = arrID[2];
		var MemoID = arrID[1];
		$.ajax({
			url: "class/CheckWorkMemo.php",
			type: "POST",
			data: {"PID": PID, "Action": Action, "MemoID": MemoID }
		});
		var id = $(this).attr('id');
		if(Action=="ON"){
			document.getElementById(id+"_icon").className = "fa fa-check-square-o";
			document.getElementById(id).id = "MemoID_"+MemoID+"_OFF_"+PID;
			document.getElementById(id+"_icon").id = "MemoID_"+MemoID+"_OFF_"+PID+"_icon";
		}
		if(Action=="OFF"){
			document.getElementById(id+"_icon").className = "fa fa-square-o";
			document.getElementById(id).id = "MemoID_"+MemoID+"_ON_"+PID;
			document.getElementById(id+"_icon").id = "MemoID_"+MemoID+"_ON_"+PID+"_icon";
		}
	});
});
</script>
<?php }?>