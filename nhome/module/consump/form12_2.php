<script type="text/javascript" src="js/share.js"></script>
<?php
//模組名稱
$strModule = "firmstock";
if(getStatus(date("Y/m/d"))=="0"){
	echo "<script>alert('請先進行月結關帳作業!');window.location.href='index.php?mod=consump&func=formview&id=9_2'</script>";
}		
if($_GET['pid'] == ""){
	$pID = "";
} else {
	$pID = getHospNoDisplayByPID(mysql_escape_string($_GET['pid']));
}
if($_GET['aID'] == ""){
	$areaID = "";
}else{
	$areaID = mysql_escape_string($_GET['aID']);
}
$type = "SP";
if ($_GET['STK_DATE']=="") {
	$STKDATE = date("Y/m/d");
} else {
	$STKDATE = $_GET['STK_DATE'];
}
//$_SESSION['ncarecSTKdate_lwj'])
//先取得最新出貨編號
$db = new DB;
$db->query("SELECT count(*)+1 AS fid FROM `firmstock` WHERE type='".$type."' and YEAR(`STK_Date`)='".date("Y")."' and MONTH(`STK_Date`)='".date("m")."' ");

if($db->num_rows() >0){
	$rs = $db->fetch_assoc();
	$fid = $rs['fid'];
	$fid = str_pad($fid,4,'0',STR_PAD_LEFT);
}

if (isset($_POST['submit'])) {
	$firmstockID = mysql_escape_string($_POST['firmstockID']);
	//讀寫資料
	if ($firmstockID != NULL) {
		
		//先取得出貨編號
		$db = new DB;
		$db->query("SELECT count(*)+1 AS fid FROM `firmstock` WHERE type='".$type."' and YEAR(`STK_Date`)='".substr($_POST['STK_Date'],0,4)."' and MONTH(`STK_Date`)='".substr($_POST['STK_Date'],5,2)."' ");
		if($db->num_rows() >0){
			$rs = $db->fetch_assoc();
			$newid = $rs['fid'];
			$newid = str_pad($newid,4,'0',STR_PAD_LEFT);
		}
		
		//新增出貨單
		$db = new DB;
		$strQry ="INSERT INTO `".$strModule."` (`firmStockID`,`STK_Date`,`type`, `firmID`,`ReceiptNO`,`ReceiptDate`,`Tax_1`,`Tax_2`,";
		$strQry .="`T_PRC`,`STK_NET`,`STK_TAX`,`STK_TOT`,`Fmark`,`userID`) VALUES (";
		$strQry .=" '".$newid."',";
		$strQry .=" '".mysql_escape_string($_POST['STK_Date'])."',";
		$strQry .=" '".$type."',";
		if($_POST['OrdType_1']==1){
			$strQry .=" '".mysql_escape_string(getHospNoByHospNoDisplayNoType($_POST['firmID']))."',";
		}else{
			$strQry .=" '".mysql_escape_string("Area".$_POST['area'])."',";
		}
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
		
		include("class/insertORDTable.php");
		include("class/insertTable2.php");
		echo "<script>alert('Add successfully!');window.location.href='index.php?mod=consump&func=formview&id=12'</script>";
	}else{
		echo "<script>alert('Data error!');window.location.href='index.php?mod=consump&func=formview&id=12'</script>";
	}
}



?>
<h3>Delivery note </h3>
<form name="FSform" id="FSform" method="post">
<div class="content-table">
<table align="left"  width="100%" style="font-size:10pt; margin-left:0px;">
  <tr id="backtr"  >
    <td class="title" >Application category</td>
    <td colspan="5"  align="left"><?php if($areaID!=""){$OrdType=2;}else{$OrdType=1;} echo draw_option("OrdType","Individual use;Public use","l","single",$OrdType,false,2);?></td>   
    <td class="title"  >EIN/Tax ID</td>
    <td colspan="2" align="left"><input type="text" id="log1" name="log1" disabled="disabled" /></td>
    </tr>
  <tr id="backtr"  >
    <td class="title" >Delivery note ID#</td>
    <td colspan="3"  align="left"><input type="text" value="<?php echo $type.date("ym").$fid; ?>" id="a" name="a" disabled="disabled"/></td>   
    <td class="title"  >Shipping date</td>
    <td  align="left"><input type="text" name="STK_Date" id="STK_Date" value="<?php if($STKDATE!=""){echo $STKDATE;}else{echo date("Y/m/d");}?>" size="12" ></td>
    <td class="title"  >Tax</td>
    <td colspan="2"  align="left"><?php echo draw_option("Tax","Taxable;Exemption","m","single",2,false,2);?></td>
    </tr>
  <tr id="AreaTR"  style="border:none; height:20px;" >
    <td class="title" width="10%"  style="border:none; background-color:#FF8928;">Area</td>
    <td colspan="7" align="left">
      <?php 
	  echo '<select class="validate[required]" name="area" id="area" onchange="window.location.href=\'index.php?mod=consump&func=formview&id=12_2&aID=\'+this.options[this.selectedIndex].value+\'&STK_DATE=\'+document.getElementById(\'STK_Date\').value">';
	  echo '  <option></option>';
	  $db3 = new DB;
	  $db3->query("SELECT * FROM `arkarea` ORDER BY `areaID` ASC");
	  for ($i3=0;$i3<$db3->num_rows();$i3++) {
		  $r3 = $db3->fetch_assoc();
		  echo '  <option value="'.$r3['areaID'].'"';
		  if (@$_GET['aID']==$r3['areaID']) { echo ' selected'; }
		  echo '>'.$r3['areaName'].'</option>';
		  $arrAreaName[$r3['areaID']] = $r3['areaName'];
	  }
	  echo '</select>';
	?>
        </td>
	</tr>
  <tr id="PatientTR"  style="border:none; height:20px;" >
    <td class="title" width="10%"  style="border:none; background-color:#eecb35;">Care ID#</td>
    <td  width="12%" align="left">
    <div id="FirmDiv" style="width:200px;"><input class="validate[required]" name="firmID" type="text" id="firmID" onblur="window.location.href='index.php?mod=consump&func=formview&id=12_2&pid='+this.value+'&STK_DATE='+document.getElementById('STK_Date').value+'&reload=1';" value="<?php echo $pID; ?>"/></div>
	</td>
    <td colspan="2"  ><button onclick="window.open('class/consump.php?query=3&type=ord', '_blank', 'width=450, height=200, scrollbars=yes'); return false;" >...</button></td>
  
	<td class="title"  >Resident's name</td>
    <td align="left"><input type="text" id="log0" name="log0" disabled="disabled" /></td>
    <td class="title"  >Bed #</td>
    <td  align="left"><input type="text" id="log4" name="log4" disabled="disabled" /></td>
  </tr>
  <tr  style="border:none; height:20px;" >
    <td class="title">Invoice/reciept No.</td>
    <td colspan="3" align="left"><input name="ReceiptNO" type="text" id="ReceiptNO" /></td>
    <td class="title">Invoice/reciept date</td>
    <td  align="left"><script> $(function() { $( "#ReceiptDate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="ReceiptDate" id="ReceiptDate" size="12"></td>
    <td class="title">Delivery $ amount</td>
    <td colspan="2"  align="left"><input type="text" id="T_PRC" name="T_PRC" readonly  /></td>
  </tr>
  <tr id="backtr"  >
    <td class="title" >Net delivery</td>
    <td colspan="3"  align="left">
    <input type="text" id="STK_NET" name="STK_NET" size="8" readonly />Discount<input type="text" id="log2" name="log2" size="2" readonly /> %, waiver<input type="text" id="log3" name="log3" size="5" readonly />
    </td>   
    <td class="title"  >Delivery tax</td>
    <td  align="left"><input type="text" id="STK_TAX" name="STK_TAX" readonly /></td>
    <td class="title"  >Delivery total value</td>
    <td colspan="2"  align="left"><input type="text" id="STK_TOT" name="STK_TOT" readonly /></td>
    </tr>
  
  <tr >
    <td class="title" >Comment</td>
    <td colspan="5"  align="left"><textarea id="Fmark" name="Fmark"></textarea></td>   
    <td class="title"  >Documented personnel</td>
    <td colspan="2"  align="left"><?php echo checkusername($_SESSION['ncareID_lwj']);?></td>
    </tr>  
    
</table>
<?php 
if($pID !=""){ $tmpID=getHospNoByHospNoDisplayNoType($pID); } elseif($areaID!="") {$tmpID=$areaID;}else{$tmpID="";}
if($tmpID !=""){
	include("class/blockOrdTable.php");
}
include("class/addTable2.php"); ?>
</div>
<br />&nbsp;
<center>
	<input type="hidden" id="<?php echo $strModule ?>ID" name="<?php echo $strModule ?>ID" value="<?php echo $fid ?>" />
    <input type="button" id="cmdBack" name="cmdBack" value="Back to list"  />
	<input type="submit" name="submit" id="submit" value="Save" />
</center>
</form>
<script language="javascript">

<?php if($pID !=""){ ?>
	$('#PatientTR').show();
	$('#AreaTR').hide();
	showPatient();
<?php }elseif($areaID !=""){ ?>	
	$('#AreaTR').show();
	$('#PatientTR').hide();
	showPatient();
<?php }else{ ?>
	$('#PatientTR').show();
	$('#AreaTR').hide();
<?php }?>

function showPatient() {
  $.ajax({
	  url: "class/patient.php",
	  type: "POST",
	  data: { "PID": $("#firmID").val()},
	  success: function(data) {
		  var dataArr = data.split(';');
		  for (i = 0; i < dataArr.length; i++){				
			  $( "#log"+i ).val( dataArr[i] );
		  }
		  oS_AMT(1);
	  }
  });
}

$(function() {
	$("#STK_Date").change(function(){
		showPatient();
		var c1 = '<?php echo $areaID;?>';
		var c2 = '<?php echo $_GET['pid'];?>';
		var getID = "";
		if(c1.length>0){getID="&aID="+c1;}
		if(c2.length>0){getID="&pid="+c2;}	
		window.location.href='index.php?mod=consump&func=formview&id=12_2'+getID+'&STK_DATE='+$("#STK_Date").val();		
	})
	//Back to list
	$('#cmdBack').click(function(){
	  location.href='index.php?mod=consump&func=formview&id=12' ;
	});
	
	<?php
	if ($_GET['pid']!="" && $_GET['reload']==1) {
	?>
	$('#firmID').val('<?php echo $_GET['pid']; ?>');
	//alert('<?php echo $_GET['pid']; ?>');
	showPatient();
		window.location.href='index.php?mod=consump&func=formview&id=12_2&pid=<?php echo getPIDByHospNoDisplay($_GET['pid']); ?>&STK_DATE=<?php echo $STKDATE; ?>';		
	<?php
	}
	?>

  //驗證
  $('#submit').click(function(){

	if($('#OrdType_1').val()==0 && $('#OrdType_2').val()==0){
		alert('請確認申請類別');
		return false;
	}
	if($('#Tax_1').val()==0 && $('#Tax_2').val()==0){
		alert('請確認稅別');
		return false;
	}
	var chkDate  = '<?php echo chkDay(date("Y").'/'.str_pad((date("m")-1),2,'0',STR_PAD_LEFT).'/01',$_SESSION['ncarecSTKdate_lwj']);?>';
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
  $('#btn_OrdType_1').click(function(){
	  $('#AreaTR').hide();
	  $('#PatientTR').show();
  });
  $('#btn_OrdType_2').click(function(){
	  $('#AreaTR').show();
	  $('#PatientTR').hide();
  });
  $('#FSform').validationEngine();
  $("#STK_Date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true});
});
</script>

