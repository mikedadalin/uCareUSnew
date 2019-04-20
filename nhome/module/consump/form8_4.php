<script type="text/javascript" src="js/share.js"></script>
<?php
//模組名稱
$strModule = "firmstock";
$firmstockID = (int) @$_POST[$strModule.'ID'];
$type = "A";

//先取得最新調整編號
$db = new DB;
$db->query("SELECT count(*)+1 AS fid FROM `firmstock` WHERE type='".$type."' and YEAR(`STK_Date`)='".date("Y")."' and MONTH(`STK_Date`)='".date("m")."' ");
if($db->num_rows() >0){
	$rs = $db->fetch_assoc();
	$fid = $rs['fid'];
	$fid = str_pad($fid,4,'0',STR_PAD_LEFT);
	
}

if (isset($_POST['submit'])) {

	//讀寫資料
	if ($firmstockID != NULL) {
		//New adjustment note
		$db = new DB;
		$strQry ="INSERT INTO `".$strModule."` (`firmStockID`,`STK_Date`,`type`, `Fmark`,`userID`) VALUES (";
		$strQry .=" '".mysql_escape_string($_POST['firmstockID'])."',";
		$strQry .=" '".mysql_escape_string($_POST['STK_Date'])."',";
		$strQry .=" '".$type."',";
		$strQry .=" '".mysql_escape_string($_POST['Fmark'])."',";
		$strQry .=" '".$_SESSION['ncareID_lwj']."'"; 
		$strQry .="  )";		
		$db->query($strQry);		
		include("class/insertTable.php");
		echo "<script>alert('Add successfully!');window.location.href='index.php?mod=consump&func=formview&id=8_3'</script>";
	}else{
		echo "<script>alert('Data error!');window.location.href='index.php?mod=consump&func=formview&id=8_3'</script>";
	}
}

?>
<h3>Adjustment note</h3>
<form name="FSform" id="FSform" method="post">
<div class="content-table">
<table align="left"  width="100%" style="font-size:10pt; margin-left:0px;">
  <tr id="backtr"  >
    <td class="title" >Adjustment note ID#</td>
    <td colspan="5"  align="left"><input type="text" value="<?php echo $type; echo date("ym"); echo $fid; ?>" id="a" name="a" disabled="disabled"/></td>   
    <td class="title"  >Adjusted date</td>
    <td  align="left"><script> $(function() { $( "#STK_Date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="STK_Date" id="STK_Date" value="<?php echo date("Y/m/d"); ?>" size="12" ></td>
    </tr>
  <tr >
    <td class="title" >Comment</td>
    <td colspan="5"  align="left"><textarea id="Fmark" name="Fmark" rows="1" cols="30"><?php echo $Fmark; ?></textarea></td>   
    <td class="title"  >Documented personnel</td>
    <td colspan="2"  align="left"><?php echo checkusername($_SESSION['ncareID_lwj']);?></td>
    </tr>  
    
</table>
<?php include("class/addTable.php"); ?>
</div>
<br />&nbsp;
<center>
	<input type="hidden" id="<?php echo $strModule ?>ID" name="<?php echo $strModule ?>ID" value="<?php echo $fid ?>" />
    <input type="button" id="cmdBack" name="cmdBack" value="Back to list"  />
	<input type="submit" name="submit" id="submit" value="Save" />
</center>
</form>
<script language="javascript">
function newORD() {
  $.ajax({
	  url: "class/firm.php",
	  type: "POST",
	  data: { "PID": $("#firmID").val()},
	  success: function(data) {
		  var dataArr = data.split(';');
		  for (i = 0; i < dataArr.length; i++){				
			  $( "#log"+i ).val( dataArr[i] );
		  }
	  }
  });
}

$(function() {
	//Back to list
	$('#cmdBack').click(function(){
	  location.href='index.php?mod=consump&func=formview&id=8_3' ;
	});

  //驗證
  $('#submit').click(function(){
	if($('#Fmark').val()== ""){
		alert('請輸入調整原因!!')
		$('#Fmark').focus();
		return false;
	}

	if ($('#fileCount').val()==0 || $('#fileCount').val()==""){
		$('#addFile').focus();
		alert('請先新增產品!');
		  return false;
	}	
	for (var j = 1; j <= $('#fileCount').val(); j++) {		
	
	  if($('#STK_NAME'+j).val()== ""){
		  alert('請輸入產品代碼!!')
		  $('#STK_NO'+j).focus();
		  return false;
	  }
	  
	  if(!$('#STK_NO'+j).val()){
		return;	
	  }	  

	  if($('#dQTY'+j).val() == ""){
		  alert('請輸入數量!!')
		  $('#dQTY'+j).focus();
		  return false;
	  }else{
		if(isNaN($('#dQTY'+j).val())){
		   alert("請輸入有效數量!!");
		   $('#dQTY'+j).focus();
		   return false;
		}		
	  }
	  if ($("#STOCK_INFO_NAME"+j).val()==""){
		  $('#STOCK_INFO'+j).focus();
		  alert('請輸入有效倉庫代碼!!')
		  return false;
	  }	  	  
	}		
  });
  $('#btn_Tax_1').click(function(){
	  S_TAX($("#STK_NET").val());
  });
  $('#btn_Tax_2').click(function(){
	  S_TAX($("#STK_NET").val());
  });
});
    

</script>

