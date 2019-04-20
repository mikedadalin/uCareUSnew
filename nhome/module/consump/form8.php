<script type="text/javascript" src="js/share.js"></script>
<?php
//模組名稱
$strModule = "firmstock";
$firmstockID = (int) @$_POST[$strModule.'ID'];
$type = "IC";
if(getStatus(date("Y/m/d"))=="0"){
	echo "<script>alert('請先進行月結關帳作業!');window.location.href='index.php?mod=consump&func=formview&id=9_2'</script>";
}
if (isset($_POST['submit'])) {

	//讀寫資料
	if ($firmstockID != NULL) {
		//新增進貨單
		$dba = new DB;
		$dba->query("SELECT count(*)+1 AS fid FROM `firmstock` WHERE type='".$type."' and YEAR(`STK_Date`)='".substr($_POST['STK_Date'], 0, 4)."' and MONTH(`STK_Date`)='".substr($_POST['STK_Date'], 5, 2)."' ");
		if($dba->num_rows() >0){
			$rsa = $dba->fetch_assoc();
			$fid = $rsa['fid'];
			$fid = str_pad($fid,4,'0',STR_PAD_LEFT);
		}else{
			$fid = $_POST['firmstockID'];
		}
//		echo "SELECT count(*)+1 AS fid FROM `firmstock` WHERE type='".$type."' and YEAR(`STK_Date`)='".substr($_POST['STK_Date'], 0, 4)."' and MONTH(`STK_Date`)='".substr($_POST['STK_Date'], 5, 2)."' ";
//		echo $fida;
		$db = new DB;
		$strQry ="INSERT INTO `".$strModule."` (`firmStockID`,`STK_Date`,`type`, `firmID`,`ReceiptNO`,`ReceiptDate`,`Tax_1`,`Tax_2`,";
		$strQry .="`T_PRC`,`STK_NET`,`STK_TAX`,`STK_TOT`,`Fmark`,`userID`) VALUES (";
		$strQry .=" '".$fid."',";
		$strQry .=" '".mysql_escape_string($_POST['STK_Date'])."',";
		$strQry .=" '".$type."',";
		$strQry .=" '".mysql_escape_string(str_pad($_POST['firmID'],4,'0',STR_PAD_LEFT))."',";
		$strQry .=" '".mysql_escape_string($_POST['ReceiptNO'])."',";
		$strQry .=" '".mysql_escape_string($_POST['ReceiptDate'])."',";
		$strQry .=" '".mysql_escape_string($_POST['Tax_1'])."',";
		$strQry .=" '".mysql_escape_string($_POST['Tax_2'])."',";
		$strQry .=" '".mysql_escape_string($_POST['T_PRC'])."',";
		$strQry .=" '".mysql_escape_string($_POST['STK_NET'])."',";
		$strQry .=" '".mysql_escape_string($_POST['STK_TAX'])."',";
		$strQry .=" '".mysql_escape_string($_POST['STK_TOT'])."',";
		$strQry .=" '".mysql_escape_string($_POST['Fmark'])."',";
		$strQry .=" '".$_SESSION['ncareID_lwj']."'"; 
		$strQry .="  )";		
		$db->query($strQry);		
		include("class/insertTable.php");
		echo "<script>alert('Add successfully!');window.location.href='index.php?mod=consump&func=formview&id=8_2'</script>";
	}else{
		echo "<script>alert('Data error!');window.location.href='index.php?mod=consump&func=formview&id=8_2'</script>";
	}
}

//先取得最新進貨編號
$db = new DB;
$db->query("SELECT count(*)+1 AS fid FROM `firmstock` WHERE type='".$type."' and YEAR(`STK_Date`)='".date("Y")."' and MONTH(`STK_Date`)='".date("m")."' ");

if($db->num_rows() >0){
	$rs = $db->fetch_assoc();
	$fid = $rs['fid'];
	$fid = str_pad($fid,4,'0',STR_PAD_LEFT);
}
?>
<h3>Purchase bill</h3>
<form name="FSform" id="FSform" method="post">
<div class="content-table">
<table align="left"  width="100%" style="font-size:10pt; margin-left:0px;">
  <tr id="backtr"  >
    <td class="title" >Purchase bill #</td>
    <td colspan="3"  align="left"><input type="text" value="<?php echo $type; echo date("ym"); echo $fid; ?>" id="a" name="a" disabled="disabled"/></td>   
    <td class="title"  >Purchase date</td>
    <td  align="left"><script> $(function() { $( "#STK_Date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true});}); </script><input type="text" name="STK_Date" id="STK_Date" value="<?php echo date("Y/m/d"); ?>" size="12" ></td>
    <td class="title"  >Tax</td>
    <td colspan="2"  align="left"><?php if($firmstockID==NULL){$Tax=1;} echo draw_option("Tax","Taxable;Exemption","xs","single",$Tax,false,2);?></td>
    </tr>

  <tr id="backtr"  style="border:none; height:20px;" >
    <td class="title" width="10%"  style="border:none; background-color:#eecb35;">Vendor ID#</td>
    <td  width="12%" align="left">
    <div id="FirmDiv" style="width:200px;"><input name="firmID" type="text" id="firmID" onblur="newORD();"/></div>
	</td>
    <td colspan="2"  ><button onclick="window.open('class/consump.php?query=1', '_blank', 'width=450, height=200, scrollbars=yes'); return false;" >...</button></td>
    <td class="title"  >Vendor's name</td>
    <td  align="left"><input type="text" id="log0" name="log0" size="25" disabled="disabled"/></td>
    <td class="title"  >EIN/Tax ID</td>
    <td colspan="2"  align="left"><input type="text" id="log1" name="log1" disabled="disabled" /></td>
    </tr>
  <tr  style="border:none; height:20px;" >
    <td class="title">Invoice/reciept No.</td>
    <td colspan="3" align="left"><input name="ReceiptNO" type="text" id="ReceiptNO" /></td>
    <td class="title">Invoice/reciept date</td>
    <td  align="left"><script> $(function() { $( "#ReceiptDate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="ReceiptDate" id="ReceiptDate" value="" size="12" ></td>
    <td class="title">Purchase payment amount</td>
    <td colspan="2"  align="left"><input type="text" id="T_PRC" name="T_PRC" readonly /></td>
  </tr>
  <tr id="backtr"  >
    <td class="title" >Net purchase</td>
    <td colspan="3"  align="left"><input type="text" id="STK_NET" name="STK_NET" readonly/>Discount<input type="text" id="log2" name="log2" size="2" readonly />%</td>   
    <td class="title"  >Sales/use tax</td>
    <td  align="left"><input type="text" id="STK_TAX" name="STK_TAX" readonly /></td>
    <td class="title"  >Purchase total value</td>
    <td colspan="2"  align="left"><input type="text" id="STK_TOT" name="STK_TOT" readonly /></td>
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
	  location.href='index.php?mod=consump&func=formview&id=8_2' ;
	});

  //驗證
  $('#submit').click(function(){
	  
	if ($('#log0').val()==""){
		alert('請先選擇廠商!');
		$('#firmID').focus();
		  return false;
	}

	
	if ($('#fileCount').val()==0 || $('#fileCount').val()==""){
		$('#addFile').focus();
		alert('請先新增產品!');
		  return false;
	}	
	for (var j = 1; j <= $('#fileCount1').val(); j++) {		
		if ($('#removed'+j).val()==0) {
		  if($('#STK_NAME'+j).val()== ""){
			  alert('請輸入產品代碼!!')
			  $('#STK_NO'+j).focus();
			  return false;
		  }
		  	
		  if($('#dQTY'+j).val() == ""){
			  alert('請輸入數量!!')
			  $('#dQTY'+j).focus();
			  return false;
		  }else{
			if(isNaN($('#dQTY'+j).val()) || $('#dQTY'+j).val() == 0){
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
	}
	var chkDate  = '<?php echo chkDay(date("Y").'/'.str_pad((date("m")-1),2,'0',STR_PAD_LEFT).'/01',cSTKdate());?>';
	var chkDate1 = '<?php echo date("Y").'/'.str_pad((date("m")-1),2,'0',STR_PAD_LEFT).'/'; ?>' + chkDate;
	if($("#STK_Date").val() <= chkDate1){
		if(confirm('該月份已關帳是否繼續??')){
			$("#FSform").submit();
		}else{
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

