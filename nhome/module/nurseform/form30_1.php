<script>
function loadPatInfo(tab){
	var HospNo= $("#HospNo_"+tab).val();
	$.ajax({
		url: 'class/patinfo.php',
		type: "POST",
		async: false,
		data: { med: HospNo }
	}).done(function(meds){
		medList2 = meds.split(',');	
		document.getElementById('Name_'+tab).value = medList2[0];	
	});
	return medList;
}
function checkPatInfo(){
	$.ajax({
		url: "class/generalIO.php",
		type: "POST",
		data: {
			'type':"check",
			'HospNo': $('#HospNo_tab1').val(), 
			'outdate': $('#outdate').val() },
		success: function(data) {
			if (data=="離院日期已存在!") {
				alert(data);
				$('#outdate').val('');
			}
		}
	});
}

</script>
<h3>General facility attendance status tracking</h3>
<?php 
if($_GET['del']=='y'){
	$db = new DB;
	$db->query("DELETE FROM `general_io` WHERE general_IOID='".mysql_escape_string($_GET['tid'])."' ");
	echo '<script>location.replace("?mod=nurseform&func=formview&id=30_1&pid='.$_GET['pid'].'");</script>';
}
?>
<table width="100%" bgcolor="#ffffff" cellpadding="5">
  <tr>
    <td valign="top" bgcolor="#ffffff">
    <div id="tab1">
    <form><input type="button" value="Add resident attendance record" id="newrecord1" onclick="openVerificationForm('#dialog-form1');" /></form>
<script>
$(function() {
    $( "#dialog-form1" ).dialog({
		autoOpen: false,
		height: 370,
		width: 850,
		modal: true,
		buttons: {
			"Add record": function() {
			  if($('#outdate').val()==''){
				  alert('Please input the date off!!');
				  $('#outdate').focus();
				  return false;
			  }else{	
				$.ajax({
					url: "class/generalIO.php",
					type: "POST",
					data: {
						'type':"insert",
						'HospNo': $('#HospNo_tab1').val(), 
						'Name': $('#Name_tab1').val(), 
						'bedID': $('#bedID').val(), 
						'outdate': $('#outdate').val(), 
						'reason_1': $('#reason_1').val(), 
						'reason_2': $('#reason_2').val(), 
						'reason_3': $('#reason_3').val(), 
						'reason_4': $('#reason_4').val(), 
						'reasonOther': $('#reasonOther').val(), 
						'rmk': $('#rmk').val(), 
						'Qfiller': $('#Qfiller').val() },
					success: function(data) {						
						$( "#dialog-form1" ).dialog( "close" );
						alert("Add record sucessfully!");
						window.location.reload();
					}
				});
			  }
			},
			"Cancel": function() {
				$( "#dialog-form1" ).dialog( "close" );
			}
		}
	});
});
</script>
<div id="dialog-form1" title="Resident Medical/Non-medical leave of absent reocrd" class="dialog-form"> 
  <form id="base" method="post">
  <fieldset>
    <table>
      <tr>
        <td class="title">Care ID#</td>
        <td><input type="text" name="HospNo" id="HospNo_tab1" size="8" readonly></td>
        <td class="title">Full name</td>
        <td><input type="text" name="Name" id="Name_tab1" readonly value="<?php echo $name; ?>"  size="16" ></td>
      </tr>
      <tr>
        <td class="title">Bed #</td>
        <td><input type="text" name="bedID" id="bedID" readonly value="<? echo $bedID; ?>"></td>
        <td class="title">Off date</td>
        <td><script> $(function() { $( "#outdate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="outdate" id="outdate" onchange="checkPatInfo();"></td>
      </tr>
<!--      <tr>
        <td>返院日期</td>
        <td><script> $(function() { $( "#indate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="indate" id="indate" value=""></td>
        <td>Hospitalize days</td>
        <td><input type="text" name="outdays" id="outdays" value="" size="3">Day(s) <input type="button" onclick="calcoutdays()" value="Calculate day(s)" /></td>
      </tr>
-->      <tr>
        <td class="title">Reason of temporary leaving</td>
        <td colspan="3"><?php echo draw_option("reason","Visit home;Go abroad;Private schedule;Hospitalize","l","single",$reason,false,2); ?><input type="text" id="reasonOther" name="reasonOther" value="<?php echo $reasonOther; ?>"></td>
      </tr>
      <tr>
        <td class="title">Comment</td>
        <td colspan="3"><input type="text" name="rmk" id="rmk"></td>
        </tr>
        <input type="hidden" name="Qfiller" id="Qfiller" value="<?php echo $_SESSION['ncareID_lwj']; ?>">
    </table>
  </fieldset>
  </form>
</div>
    <div id="tab1_part1">
    <table class="content-query">
      <tr class="title">
        <td >Edit</td>
        <td >Care ID #</td>
        <td >Full Name</td>
        <td >Bed #</td>
        <td >Off Date</td>
        <td >Return Date</td>
        <td >Reason of Temporary Leaving</td>
        <td >Day(s)</td>
        <td >Comment</td>
        <td >Delete</td>
        </tr>
    <?php
	$dbp1_1 = new DB;
	$dbp1_1->query("SELECT * FROM  `general_io` WHERE `HospNo`='".$HospNo."'");
	if ($dbp1_1->num_rows()==0) {
	?>
      <tr>
        <td colspan="37"><center>-------Yet no facility attendance record-------</center></td>
      </tr>
    <?php
	} else {
	for ($p1_i1=0;$p1_i1<$dbp1_1->num_rows();$p1_i1++) {
		$rp1_1 =$dbp1_1->fetch_assoc();
		$reason = "";
		if ($rp1_1['reason_1']==1) {
			$reason.='1;';
		} elseif ($rp1_1['reason_2']==1) {
			$reason.='2;';
		} elseif ($rp1_1['reason_3']==1) {
			$reason.='3;';
		} elseif ($rp1_1['reason_4']==1) {
			$reason.='4;';
		}
		/*== 解 START ==*/
			$rsa = new lwj('lwj/lwj');
			$puepart = explode(" ",$rp1_1['Name']);
			$puepartcount = count($puepart);
			if($puepartcount>1){
				for($j=0;$j<$puepartcount;$j++){
					$prdpart = $rsa->privDecrypt($puepart[$j]);
					$rp1_1['Name'] = $rp1_1['Name'].$prdpart;
				}
			}else{
				$rp1_1['Name'] = $rsa->privDecrypt($rp1_1['Name']);
			}
		/*== 解 END ==*/
	?>
      <tr>
        <td><center><a href="index.php?mod=nurseform&func=formview&id=30_2&tID=<?php echo $rp1_1['general_IOID']; ?>&pid=<?php echo $_GET['pid'];?>"><img src="Images/edit_icon.png" width="20" /></a></center></td>
        <td><center><?php echo getHospNoDisplayByHospNo($rp1_1['HospNo']); ?></center></td>
        <td><center><?php echo $rp1_1['Name']; ?></center></td>
        <td><center><?php echo $bedID; ?></center></td>
        <td><center><?php echo $rp1_1['outdate']; ?></center></td>
        <td><center><?php echo $rp1_1['indate']; ?></center></td>
        <td><center><?php echo option_result("reason","Visit home;Go abroad;Private schedule;Hospitalize","m","single",$reason,false,2); ?> (<?php echo $rp1_1['reasonOther']; ?>)</center></td>
        <td><center><?php echo $rp1_1['outdays']; ?></center></td>
        <td><center><?php echo $rp1_1['rmk']; ?></center></td>
        <td><center><a href="index.php?mod=nurseform&func=formview&pid=<?php echo $_GET['pid']; ?>&tid=<?php echo $rp1_1['general_IOID']; ?>&id=30_1&del=y"><img src="Images/delete2.png"></a></center></td>
      </tr>
    <?php
	}
	}
	?>
    </table>
    </div>
    </td>
  </tr>
</table>
<script>
$(document).ready( function () {
	$('#HospNo_tab1').val('<?php echo getHospNoDisplayByPID(@$_GET['pid']); ?>');
	//loadPatInfo('tab1');	
});
</script>