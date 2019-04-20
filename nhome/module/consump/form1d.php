
<?php
//模組名稱
$strModule = "stockinfo";
$LAY_NO = (int) @$_GET['LAY_NO'];
//date_default_timezone_set('Asia/Taipei');
if (isset($_POST['submit'])) {
	//讀寫資料
	if ($LAY_NO==NULL) {
		$db->query("SELECT * FROM `".$strModule."` WHERE `stockinfoID`='".mysql_escape_string($_POST['stockinfoID'])."'");
		if ($db->num_rows()>0) {
			echo "<script>alert('代碼重覆');window.location.href='index.php?mod=consump&func=formview&id=1c'</script>";
		}else{	
			if($_POST['stockinfoID']!=''){
			//新倉庫
			  $strQry ="INSERT INTO `".$strModule."` (`stockinfoID`,`Title`";
			  $strQry .=") VALUES (";
			  $strQry .=" '".mysql_escape_string($_POST['stockinfoID'])."', ";
			  $strQry .=" '".mysql_escape_string($_POST['Title'])."'";
			  $strQry .="  )";		
			  $db->query($strQry);
			}
		}
	} else {
		$db->query("SELECT * FROM `".$strModule."` WHERE `stockinfoID`='".mysql_escape_string($_POST['stockinfoID'])."' and LAY_NO<>".$LAY_NO."");
		if ($db->num_rows()>0) {
			echo "<script>alert('代碼重覆');window.location.href='index.php?mod=consump&func=formview&id=1c'</script>";
		}else{
			//更新倉庫資料
			$db = new DB;
			$strQry = "UPDATE `".$strModule."` SET ";
			$strQry .="`Title`='".mysql_escape_string($_POST['Title'])."', ";
			$strQry .="`stockinfoID`='".mysql_escape_string($_POST['stockinfoID'])."' ";
			$strQry .=" WHERE LAY_NO=".$LAY_NO;
			$db->query($strQry);			
		}

	}
	echo "<script>window.location.href='index.php?mod=consump&func=formview&id=1c'</script>";
} else {
	//Edit/新增畫面
$db = new DB;
$db->query("SELECT * FROM `".$strModule."` WHERE `LAY_NO`='".mysql_escape_string($LAY_NO)."'");

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

?>
<form method="post">
<div class="title_nav" style="width:240px">Storehouse information <?php echo ($LAY_NO == 0)?"Add":"Maintain" ?></div>
<table width="100%">
  <tr>
    <td width="120" class="title">Storehouse ID#</td>
    <td align="left"><input type="text" name="stockinfoID" id="stockinfoID" size="60" value="<?php echo $stockinfoID; ?>" onblur="<?php if($LAY_NO ==NULL){?>chkNO();<?php }?> this.value = this.value.toUpperCase();"><span id="err" style="color:#F00;"></span></td>
  </tr>
  <tr>
    <td width="120" class="title">Storehouse name</td>
    <td colspan="3" align="left"><input type="text" name="Title" id="Title" size="60" value="<?php echo $Title; ?>" ></td> 
  </tr>
</table>
<br />
<center>
	<input type="hidden" id="LAY_NO" name="LAY_NO" value="<?php $LAY_NO ?>" />
    <input type="button" id="cmdBack" name="cmdBack" value="Back to list"  />
    <input type="reset" name="reset" id="reset" value="Re-fill" />
	<input type="submit" name="submit" id="submit" value="Save" />
    
</center>
</div>

</form>
<?php

}
?>

<script language="javascript">
 $(function() {	 
	//Back to list
	$('#cmdBack').click(function(){
	  location.href='index.php?mod=consump&func=formview&id=1c' ;
	});
	$('#submit').click(function(){
	  if($('#stockinfoID').val() == ''){
		  alert('請輸入倉庫編號');
		  $('#stockinfoID').focus();
		  return false;
	  }	
	  if($('#Title').val() == ''){
		  alert('請輸入倉庫名稱');
		  $('#Title').focus();
		  return false;
	  }	
	});
	
  });
    
  function chkNO(){
	$.ajax({
		url: "class/stockInfo.php",
		type: "POST",
		data: { "PID": $("#stockinfoID").val()},
		success: function(data) {
			if(data!=''){
				$("#err").html("( "+data+" )"+" 已使用該編號!!");
				$("#stockinfoID").focus();				
			}else{
				$("#err").html("");
			}
		}
  });
	  
	  
  }

  
</script>