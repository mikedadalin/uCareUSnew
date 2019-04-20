<?php
if ($_GET['empid']!="") {
	$empid = (int) @$_GET['empid'];
} else {
	$empid = "";
}

if (isset($_POST['submit'])) {
	//print_r($_POST);
	
	foreach($_POST as $k1=>$v1) {
		$_POST[$k1] = str_replace("____/__/__","",$v1);
	}
	
	if ($_SESSION['ncareID_lwj']=="Mor3Geneki6nge08" || $_SESSION['ncareID_lwj']=="Lejla05Mirzada12Asmira01") { print_r($_POST); }
	//讀寫資料
	if ($_POST['EmpID']==NULL) {
		//新員工
		/*== 加 START ==*/
		$rsa = new lwj('lwj/lwj');
		$part = ceil(strlen($_POST['IdNo'])/117);
		if($part>1){
			$datapart = str_split($_POST['IdNo'], 117);
			for($i=0;$i<$part;$i++){
				$puepart = $rsa->pubEncrypt($datapart[$i]);
				$_POST['IdNo'] = $_POST['IdNo'].$puepart." ";
			}
		}else{
			$_POST['IdNo'] = $rsa->pubEncrypt($_POST['IdNo']);
		}
		/*== 加 END ==*/
		$db = new DB;
		$db->query("INSERT INTO `employer` VALUES ('', '".mysql_escape_string($_POST['Position'])."', '".mysql_escape_string($_POST['Position2'])."', '".mysql_escape_string($_POST['Name'])."', '".mysql_escape_string($_POST['Gender_1'])."', '".mysql_escape_string($_POST['Gender_2'])."', '".mysql_escape_string($_POST['ishere_1'])."', '".mysql_escape_string($_POST['ishere_2'])."', '".mysql_escape_string($_POST['Birth'])."', '".mysql_escape_string($_POST['IdNo'])."', '".mysql_escape_string($_POST['Startdate1'])."', '".mysql_escape_string($_POST['Startdate2'])."', '".mysql_escape_string($_POST['Startdate3'])."', '".mysql_escape_string($_POST['Enddate1'])."', '".mysql_escape_string($_POST['Enddate2'])."', '".mysql_escape_string($_POST['Enddate3'])."', '".mysql_escape_string($_POST['Phone1'])."', '".mysql_escape_string($_POST['Phone2'])."', '".mysql_escape_string($_POST['Phone3'])."', '".mysql_escape_string($_POST['Address'])."', '".mysql_escape_string($_POST['account'])."', '".mysql_escape_string($_POST['rfidno'])."', '".mysql_escape_string($_POST['aNo1'])."', '".mysql_escape_string($_POST['aNo2'])."')");
		if ($_POST['ishere_1']==1) {
			$db1 = new DB;
			$db1->query("SELECT LAST_INSERT_ID()");
			$r1 = $db1->fetch_assoc();
			$tmpID = $r1['LAST_INSERT_ID()'];
			$db2 = new DB;
			$db2->query("INSERT INTO `shift_member` VALUES ('".$r1['LAST_INSERT_ID()']."', '1', '', 0, '1', 0)");
		}
	} else {
		//更新員工資料
		/*== 加 START ==*/
		$rsa = new lwj('lwj/lwj');
		$part = ceil(strlen($_POST['IdNo'])/117);
		if($part>1){
			$datapart = str_split($_POST['IdNo'], 117);
			for($i=0;$i<$part;$i++){
				$puepart = $rsa->pubEncrypt($datapart[$i]);
				$_POST['IdNo'] = $_POST['IdNo'].$puepart." ";
			}
		}else{
			$_POST['IdNo'] = $rsa->pubEncrypt($_POST['IdNo']);
		}
		/*== 加 END ==*/
		$db = new DB;
		$db->query("UPDATE `employer` SET `Position`='".mysql_escape_string($_POST['Position'])."', `Position2`='".mysql_escape_string($_POST['Position2'])."', `Name`='".mysql_escape_string($_POST['Name'])."', `Gender_1`='".mysql_escape_string($_POST['Gender_1'])."', 	`Gender_2`='".mysql_escape_string($_POST['Gender_2'])."', `ishere_1`='".mysql_escape_string($_POST['ishere_1'])."', `ishere_2`='".mysql_escape_string($_POST['ishere_2'])."', `Birth`='".mysql_escape_string($_POST['Birth'])."', 	`IdNo`='".mysql_escape_string($_POST['IdNo'])."', 	`Startdate1`='".mysql_escape_string($_POST['Startdate1'])."', 	`Startdate2`='".mysql_escape_string($_POST['Startdate2'])."', 	`Startdate3`='".mysql_escape_string($_POST['Startdate3'])."', 	`Enddate1`='".mysql_escape_string($_POST['Enddate1'])."', 	`Enddate2`='".mysql_escape_string($_POST['Enddate2'])."', 	`Enddate3`='".mysql_escape_string($_POST['Enddate3'])."', 	`Phone1`='".mysql_escape_string($_POST['Phone1'])."', 	`Phone2`='".mysql_escape_string($_POST['Phone2'])."', 	`Phone3`='".mysql_escape_string($_POST['Phone3'])."', 	`Address`='".mysql_escape_string($_POST['Address'])."', 	`account`='".mysql_escape_string($_POST['account'])."', `rfidno`='".mysql_escape_string($_POST['rfidno'])."', `aNo1`='".mysql_escape_string($_POST['aNo1'])."', `aNo2`='".mysql_escape_string($_POST['aNo2'])."' WHERE `EmpID`='".mysql_escape_string($_POST['EmpID'])."'");
		if ($_POST['ishere_1']==1) {
			if ($_POST['Enddate1']==NULL) {
				$db2 = new DB;
				$db2->query("UPDATE `shift_member` SET `available`='1' WHERE `EmpID`='".mysql_escape_string($_POST['EmpID'])."' AND `EmpGroup`='1'");
			} elseif ($_POST['Startdate2']!="" && $_POST['Enddate2']=="") {
				$db2 = new DB;
				$db2->query("UPDATE `shift_member` SET `available`='1' WHERE `EmpID`='".mysql_escape_string($_POST['EmpID'])."' AND `EmpGroup`='1'");
			} elseif ($_POST['Startdate3']!="" && $_POST['Enddate3']=="") {
				$db2 = new DB;
				$db2->query("UPDATE `shift_member` SET `available`='1' WHERE `EmpID`='".mysql_escape_string($_POST['EmpID'])."' AND `EmpGroup`='1'");
			} else {
				$db2 = new DB;
				$db2->query("UPDATE `shift_member` SET `available`='0' WHERE `EmpID`='".mysql_escape_string($_POST['EmpID'])."' AND `EmpGroup`='1'");
			}
		}
		$tmpID = $_POST['EmpID'];
	}
	
		//Pre-employment training Start
	foreach ($_POST as $k=>$v){
		if(substr($k,0,12)=="trainingform"){
			$arrTraining = explode("_",$k);
			if($v==1){
				if ($training!="") { $training .= ';'; }
				$training .= $arrTraining[1];
			}
		}
	}
	$db1 = new DB;
	$db1->query("SELECT * FROM `employer_training` WHERE `EmpID`='".$tmpID."' AND `EmpGroup`='1'");
	$rs = $db1->fetch_assoc();
	if($db1->num_rows() > 0){
		$db2 = new DB;
		$db2->query("UPDATE `employer_training` SET `trainingformID`='".$training."' WHERE `trainingID`='".$rs['trainingID']."'");
	}else{
		$db2 = new DB;
		$db2->query("INSERT INTO `employer_training` VALUES ('','".$tmpID."', '1','".$training."')");
	}
		//Pre-employment training End
	
	if ($_POST['account']!="" && $_POST['rfidno']!="") {
		$db4 = new DB2;
		$db4->query("UPDATE `userinfo` SET `rfidno`='".mysql_escape_string($_POST['rfidno'])."' WHERE `userID`='".mysql_escape_string($_POST['account'])."' AND `OrgID`='".$_SESSION['nOrgID_lwj']."'");
	}
	if ($_POST['account']!="") {
		$db4 = new DB2;
		$db4->query("UPDATE `userinfo` SET `EmpID`='".mysql_escape_string($_POST['EmpID'])."_1' WHERE `userID`='".mysql_escape_string($_POST['account'])."' AND `OrgID`='".$_SESSION['nOrgID_lwj']."'");
	}
	echo "<script>window.location.href='index.php?mod=humanresource&func=formview&id=2_1&empid=".$tmpID."'</script>";
} else {
	//Edit/新增畫面
	$db = new DB;
	$db->query("SELECT * FROM `employer` WHERE `EmpID`='".mysql_escape_string($empid)."'");
	if ($db->num_rows()>0) {
		$r = $db->fetch_assoc();
		foreach ($r as $k=>$v) {
			$arrPatientInfo = explode("_",$k);
			if (count($arrPatientInfo)==2) {
				if ($v==1) {
					${$arrPatientInfo[0]} = $arrPatientInfo[1];
				}
			} else {
				${$k} = $v;
			}
		}
	}
	/*== 解 START ==*/
	$rsa = new lwj('lwj/lwj');
	$puepart = explode(" ",$IdNo);
	$puepartcount = count($puepart);
	if($puepartcount>1){
		for($m=0;$m<$puepartcount;$m++){
			$prdpart = $rsa->privDecrypt($puepart[$m]);
			$IdNo = $IdNo.$prdpart;
		}
	}else{
		$IdNo = $rsa->privDecrypt($IdNo);
	}
	/*== 解 END ==*/
	if ($Startdate1=="") { $Startdate1 = date("Y/m/d"); }
	if ($rfidno=="") {
		$rfid_style = "block";
		$rfid2_style = "none";
	} else {
		$rfid_style = "none";
		$rfid2_style = "block";
	}
	?>
<div class="moduleNoTab">
	<form  method="post" action="index.php?mod=humanresource&func=formview&id=2_1">
		<h3>Domestic staff profile maintain</h3>
<!--
Employee ID#<?php echo $EmpID; ?><input type="hidden" name="EmpID" id="EmpID" size="12" value="<?php echo $EmpID; ?>" >
-->
<table style="text-align:left;">
	<tr>
		<td class="title">Employee ID#</td>
		<td colspan="5" style="padding-left:5px;"><?php echo $EmpID; ?><input type="hidden" name="EmpID" id="EmpID" size="12" value="<?php echo $EmpID; ?>" ></td>
	</tr>
	<tr>
		<td width="120" class="title">Employee name</td>
		<td><input type="text" name="Name" id="Name" size="12" value="<?php echo $Name; ?>" ></td>
		<td width="120" class="title">Job title</td>
		<td><input type="text" name="Position" id="Position" size="12" value="<?php echo $Position; ?>" ></td>
		<td width="120" class="title">Official titles</td>
		<td><input type="text" name="Position2" id="Position2" size="12" value="<?php echo $Position2; ?>" ></td>
	</tr>
	<tr>
		<td class="title">Gender</td>
		<td><?php echo draw_option("Gender","Male;Female","xs","single",$Gender,false,5); ?></td>
		<td class="title">Social Security number</td>
		<td><input type="text" name="IdNo" id="IdNo" size="12" value="<?php echo $IdNo; ?>"></td>
		<td class="title">DOB</td>
		<td><script> $(function() { $( "#Birth").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="Birth" id="Birth" value="<?php echo $Birth; ?>" size="12" ></td>
	</tr>
	<tr>
		<td class="title">Link to account</td>
		<td>
			<select name="account" id="account">
				<option></option>
				<?php
				$db3 = new DB2;
				$db3->query("SELECT * FROM `userinfo` WHERE `OrgID`='".$_SESSION['nOrgID_lwj']."' AND `active`='1'");
				for ($i=0;$i<$db3->num_rows();$i++) {
					$r3 = $db3->fetch_assoc();
					$db3a = new DB;
					$db3a->query("SELECT * FROM `employer` WHERE `account`='".$r3['userID']."'");
					$db3b = new DB;
					$db3b->query("SELECT * FROM `foreignemployer` WHERE `account`='".$r3['userID']."'");
					if ($db3a->num_rows()==0 && $db3b->num_rows()==0 || ($account==$r3['userID'])) {
						echo '<option value="'.$r3['userID'].'" '.($account==$r3['userID']?"selected":"").'>'.$r3['userID'].' '.$r3['name'].'</option>';
					}
				}
				?>
			</select>
		</td>
		<td class="title">ID card setup</td>
		<td><input type="button" value="Setting" id="rfid" style="display:<?php echo $rfid_style; ?>;" onclick="rfid_click();"><input type="button" value="Off setting" id="rfid2" style="display:<?php echo $rfid2_style; ?>;" onclick="rfid2_click();"><input type="hidden" value="<?php echo $rfidno; ?>" name="rfidno" id="rfidno"></td>
		<td class="title">Serving in this center</td>
		<td colspan="5"><?php echo draw_option("ishere","Yes;No","s","single",($ishere==""?"1":$ishere),false,5); ?></td>
	</tr>
	<tr>
		<td class="title">Pre-employment training</td>
		<td colspan="5" style="padding:10px;">
			<?php
	//取得訓練表
			$db5 = new DB;
			$db5->query("SELECT `trainingname` FROM `training_form` ORDER BY `ord`");
			for ($i5=0;$i5<$db5->num_rows();$i5++){
				$r5 = $db5->fetch_assoc();
				if ($trainingname!="") { $trainingname .= ';'; }
				$trainingname .= $r5['trainingname'];
			}
	//設定人員要用的訓練表
			$db6 = new DB;
			$db6->query("SELECT `trainingformID` FROM `employer_training` WHERE `EmpID`='".$empid."' AND `EmpGroup`=1");
			$r6 = $db6->fetch_assoc();
			echo draw_checkbox_nobr("trainingformID","".$trainingname."",$r6['trainingformID'],"multi");
	//echo '<a href="?'.$r5['link'].'&EmpID='.$empid.'&EmpGroup=1" target="_blank">aaa</a>';
			?><br>
			<?php if($r6['trainingformID']==""){?>
			<span class="title">＊Setup the training list first！！</span>
			<?php }else{?>
			<input type="button" value="Pre-employment training" onClick="window.open('index.php?mod=humanresource&func=formview&id=9&EmpID=<?php echo $empid;?>&EmpGroup=1&trainingform=<?php echo $r6['trainingformID'];?>');">
			<?php }?>
		</td>
	</tr>
	<tr>
		<td colspan="6"></td>
	</tr>
	<tr>
		<td class="title">Date of reporting for duty (1)</td>
		<td><script> $(function() { $( "#Startdate1").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="Startdate1" id="Startdate1" value="<?php echo $Startdate1; ?>" size="12" ></td>
		<td class="title">Date of reporting for duty (2)</td>
		<td><script> $(function() { $( "#Startdate2").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="Startdate2" id="Startdate2" value="<?php echo $Startdate2; ?>" size="12" ></td>
		<td class="title">Date of reporting for duty (3)</td>
		<td><script> $(function() { $( "#Startdate3").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="Startdate3" id="Startdate3" value="<?php echo $Startdate3; ?>" size="12" ></td>
	</tr>
	<tr>
		<td class="title">Resignation date (1)</td>
		<td><script> $(function() { $( "#Enddate1").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="Enddate1" id="Enddate1" value="<?php echo $Enddate1; ?>" size="12" ></td>
		<td class="title">Resignation date (2)</td>
		<td><script> $(function() { $( "#Enddate2").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="Enddate2" id="Enddate2" value="<?php echo $Enddate2; ?>" size="12" ></td>
		<td class="title">Resignation date (3)</td>
		<td><script> $(function() { $( "#Enddate3").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="Enddate3" id="Enddate3" value="<?php echo $Enddate3; ?>" size="12" ></td>
	</tr>
	<tr>
		<td colspan="6"></td>
	</tr>
	<tr>
		<td class="title">Phone 1</td>
		<td><input type="text" name="Phone1" id="Phone1" size="12" value="<?php echo $Phone1; ?>"></td>
		<td class="title">Phone 2</td>
		<td><input type="text" name="Phone2" id="Phone2" size="12" value="<?php echo $Phone2; ?>"></td>
		<td class="title">Phone 3</td>
		<td><input type="text" name="Phone3" id="Phone3" size="12" value="<?php echo $Phone3; ?>" ></td>
	</tr>
	<tr>
		<td class="title">Address</td>
		<td colspan="5"><input type="text" name="Address" id="Address" size="60" value="<?php echo $Address; ?>" /></td>
	</tr>
	<tr>
		<td class="title">Tax form</td>
		<td><input type="text" name="aNo1" id="aNo1" size="12" value="<?php echo $aNo1; ?>"></td>
		<td class="title">84-1核備</td>
		<td colspan="3"><input type="text" name="aNo2" id="aNo2" size="12" value="<?php echo $aNo2; ?>"></td>
	</tr>
</table>
<br />
<center><input type="hidden" name="formID" id="formID" value="nurseform01" /><input type="hidden" name="employeeID" id="employeeID" value="<?php echo $employeeID; ?>" /><input type="submit" name="submit" id="submit" value="Save" /></center>
</form>
</div>
<?php
}
?>
<script>
function rfid2_click(){
	$.ajax({
		url: "class/removeRFID.php",
		type: "POST",
		data: {"account": $("#account").val(), "rfidno": $('#rfidno').val() },
		success: function(data) {
			$('#rfidno').val("");
			$('#rfid').show();
			$('#rfid2').hide();
		}
	});
}
function rfid_click(){
	if ($("#account").val()!="") {
		$('#rfid-dialog').dialog({
			autoOpen: true,
			height: 140,
			width: 280,
			modal: true});	
	} else {
		alert("請先設定帳號連結");
	}
	$( "#rfid-dialog" ).dialog( "open" );
}
function saveRFID(cardno) {
	if (cardno.length==10) {
		$.ajax({
			url: "class/checkExistRFID.php",
			type: "POST",
			data: {"cardno": cardno },
			success: function(data) {
				var arr = data.split(':');
				if (arr[0]=="OK") {
					$( "#rfid-dialog" ).dialog( "close" );
					$('#rfidno').val(cardno);
					$('#rfid2').show();
					$('#rfid').hide();
				} else if (arr[0]=="EXISTED") {
					alert('此卡號已設定予「'+arr[1]+'」，請先解除設定！');
				}
			}
		});
	}
}
</script>
<div id="rfid-dialog" title="ID card setup" class="dialog-form">
	<form onsubmit="return false;">
	<fieldset>
		<table>
			<tr>
				<td class="title">請感應卡片：</td>
				<td><input type="text" size="8" onchange="saveRFID(this.value);"></td>
			</tr>
		</table>
	</fieldset>
	</form>
</div>