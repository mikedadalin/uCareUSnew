<?php
if ($_GET['EmpID']!="" && $_GET['EmpGroup']!="") {
	$EmpID = mysql_escape_string($_GET['EmpID']);
	$EmpGroup = mysql_escape_string($_GET['EmpGroup']);
} else{
	$EmpID = "";
	$EmpGroup = "";
}
if($_GET['workID']==''){
	$workID="";
}else{
	$workID=(int) @$_GET['workID'];
}

//Profile
if($EmpGroup==1){
	$strSQL = "SELECT * FROM `employer` WHERE `EmpID`='".$EmpID."' ORDER BY `EmpID` ASC";
}else{
	$strSQL = "SELECT * FROM `foreignemployer` WHERE `foreignID`='".$EmpID."' ORDER BY `foreignID` ASC";
}
$db5a = new DB;
$db5a->query($strSQL);
$r5a = $db5a->fetch_assoc();
if($EmpGroup==1){
	$Name = $r5a['Name'];
	$position = $r5a['Position'];
}else{
	$Name = $r5a['eNickname'].$r5a['cNickname'];
	$position = $r5a['position'];
}


if (isset($_POST['submit'])) {
	if ($_POST['workID']==''){
		$db1 = new DB;
		$strSQL = "INSERT INTO `humanresource16` (`EmpID`,`EmpGroup`,`date`) VALUES (";
		$strSQL .= "'".mysql_escape_string($_POST['EmpID'])."',";
		$strSQL .= "'".mysql_escape_string($_POST['EmpGroup'])."',";
		$strSQL .= "'".mysql_escape_string($_POST['date'])."')";
		$db1->query($strSQL);		
		$db1a = new DB;
		$db1a->query("SELECT LAST_INSERT_ID()");
		$r1a = $db1a->fetch_assoc();
		$newID = $r1a['LAST_INSERT_ID()'];
		$strSQL = "UPDATE `humanresource16` SET ";
		foreach($_POST as $k=>$v){
			if(substr($k,0,1)=="Q"){
				$strSQL .="`".$k."` = '".$v."',";
			}
		}
		$strSQL .=" `Qfiller` ='".mysql_escape_string($_POST['Qfiller'])."' WHERE `workID`=".$newID;
		$db1b = new DB;
		$db1b->query($strSQL);
	}else{
		$strSQL = "UPDATE `humanresource16` SET ";
		foreach($_POST as $k=>$v){
			if(substr($k,0,1)=="Q"){
				$strSQL .="`".$k."` = '".$v."',";
			}
		}
		$strSQL .=" `Qfiller` ='".mysql_escape_string($_POST['Qfiller'])."' WHERE `workID`=".$_POST['workID'];
		$db1b = new DB;
		$db1b->query($strSQL);
		
	}
	echo "<script>history.go(-1);</script>";
}
	
$sql = "SELECT * FROM `humanresource16` WHERE `EmpID`='".mysql_escape_string($EmpID)."' AND `EmpGroup`='".mysql_escape_string($EmpGroup)."'";
if ($workID!='') { $sql .= " AND `workID`='".mysql_escape_string($workID)."'"; }
$sql .= " ORDER BY `date` DESC LIMIT 0,1";
$db1 = new DB;
$db1->query($sql);
if ($db1->num_rows()>0) {
	$r1 = $db1->fetch_assoc();
	foreach ($r1 as $k=>$v){
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
?>
<form  method="post" onSubmit="return checkForm();">

<table width="100%" border="0" style="margin-top:10px;">
  <tr>
    <td class="title" colspan="4">請假單</td>
  </tr>
<tr>
    <td width="100" class="title_s">Full name</td>
    <td width="100" ><?php echo $Name;?></td>
    <td width="100" class="title_s">Title</td>
    <td width="100"><?php echo $position;?></td>
</tr>
  <tr>
    <td class="title_s" width="100">Date of requisition</td>
    <td colspan="3">
    <input type="text" name="date" id="date" value="<?php echo date("Y/m/d"); ?>" size="12">
    </td>
  </tr>
  <tr>
    <td class="title_s" width="100">表單類別</td>
    <td colspan="3"><?php echo draw_option("Q1","請假單;調班單;排休單","m","single",$Q1,false,5); ?></td>
  </tr>
  <tr>
    <td class="title_s" width="100">職務代理人</td>
    <td><?php getEmployerName($Q2); ?>
    <span class="printcol">
    <select name="Q2" id="Q2">
    <?php 
	$EmpList = getWorkingStaff(1);
	foreach ($EmpList as $k=>$v) {
		echo '<option value="1_'.$k.'" '.('1_'.$k==$Q2?"selected":"").'>'.$v.'</option>';
	}
	?>
    <?php 
	$ForeignEmpList = getWorkingStaff(2);
	foreach ($ForeignEmpList as $k=>$v) {
		echo '<option value="2_'.$k.'" '.('2_'.$k==$Q2?"selected":"").'>'.$v.'</option>';		
	}
	?>
    </select></span>&nbsp;<input type="text" id="Q2a" name="Q2a" size="17" value="<?php echo $Q2a;?>"></td>
    <td class="title_s" width="100">職務代理人簽章</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="title_s" width="100">Off date</td>
    <td colspan="3">
    <input type="text" name="Q3" id="Q3" size="15" value="<?php echo $Q3;?>">至
    <input type="text" name="Q4" id="Q4" size="15" value="<?php echo $Q4;?>">Ends
    </td>
  </tr>
  <tr>
    <td class="title_s" width="100">Absent category</td>
    <td colspan="3"><?php echo draw_option("Q5","Regular vacation;Chrismas/new year vacation;Casual leave;Sick leave;Official leave;Other","xl","single",$Q5,false,5); ?><input type="text" name="Q5a" value="<?php echo $Q5a;?>"><br><input type="text" name="Q5b" size="5" value="<?php echo $Q5b;?>">Day(s)</td>
  </tr>
  <tr>
    <td class="title_s" width="100">事由</td>
    <td colspan="3"><textarea name="Q6" cols="20" rows="5"><?php echo $Q6;?></textarea></td>
  </tr>	
  <tr class="noShowCol">
  	<td colspan="4" align="center">院長：　　　　　　副院長：　　　　　　秘書：　　　　　　單位主管：　　　　　　人事：</td>
  </tr>
  <tr class="noShowCol">
    <td class="title_s" width="100">Comment</td>
    <td colspan="3"><textarea name="Q7" cols="20" rows="3"><?php echo $Q7;?></textarea></td>
  </tr>	
</table>
<center>
	<div style="margin-top:30px;">
<input type="hidden" name="workID" id="workID" value="<?php echo $_GET['workID']; ?>" />
<input type="hidden" name="Qfiller" id="Qfiller" value="<?php echo $_SESSION['ncareID_lwj']; ?>" />
<input type="hidden" name="EmpID" id="EmpID" value="<?php echo $_GET['EmpID']; ?>" />
<input type="hidden" name="EmpGroup" id="EmpGroup" value="<?php echo $_GET['EmpGroup']; ?>" />
<input type="button" name="back" onClick="window.location='index.php?mod=humanresource&func=formview&id=16&type=p'" value="Back to list">
<input type="submit" id="submit" name="submit" value="Save" />
</div>
</center>
</form>
<?php ?>
<script> 
$(function() { 
	$( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); 
	$("#Q2").change(function(){
		$("#Q2a").val($("#Q2 :selected").text());
	})
	$("#Q3").datetimepicker();
	$("#Q4").datetimepicker();
}); 
</script>
