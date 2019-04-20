
<?php
//模組名稱
$strModule = "firm";
$firmID = (int) @$_GET[$strModule.'ID'];
$parentName = $strModule;
$parentID = $firmID;

//date_default_timezone_set('Asia/Taipei');
if (isset($_POST['submit'])) {
	
	//讀寫資料
	if ($firmID==NULL) {
		//新廠商
		$db = new DB;
		$strQry ="INSERT INTO `".$strModule."` (`Fidno`,`Fcode`,`Title`,`IsStop_1`,`IsStop_2`,`Director`,`Tel1`,`Tel2`,`Fax`,`Address`,";
		$strQry .="`Email`,`Contact`,`Payment`,`ReceiptAddr`,`RemitAddr`,`Fmark`,`userID`) VALUES (";
		$strQry .=" '".mysql_escape_string($_POST['Fidno'])."',";
		$strQry .=" '".mysql_escape_string($_POST['Fcode'])."',";
		$strQry .=" '".mysql_escape_string($_POST['Title'])."',";
		$strQry .=" '".mysql_escape_string($_POST['IsStop_1'])."',";
		$strQry .=" '".mysql_escape_string($_POST['IsStop_2'])."',";
		$strQry .=" '".mysql_escape_string($_POST['Director'])."',";
		$strQry .=" '".mysql_escape_string($_POST['Tel1'])."',";
		$strQry .=" '".mysql_escape_string($_POST['Tel2'])."',";
		$strQry .=" '".mysql_escape_string($_POST['Fax'])."',";
		$strQry .=" '".mysql_escape_string($_POST['Address'])."',";
		$strQry .=" '".mysql_escape_string($_POST['Email'])."',";
		$strQry .=" '".mysql_escape_string($_POST['Contact'])."',";
		$strQry .=" '".mysql_escape_string($_POST['Payment'])."',";
		$strQry .=" '".mysql_escape_string($_POST['ReceiptAddr'])."',";
		$strQry .=" '".mysql_escape_string($_POST['RemitAddr'])."',";
		$strQry .=" '".mysql_escape_string($_POST['Fmark'])."',";
		$strQry .=" '".$_SESSION['ncareID_lwj']."'"; 
		$strQry .="  )";		
		$db->query($strQry);
	} else {
		//更新廠商資料
		$db = new DB;
		$strQry = "UPDATE `".$strModule."` SET ";
		$strQry .="`Fidno`='".mysql_escape_string($_POST['Fidno'])."', ";
		$strQry .="`Fcode`='".mysql_escape_string($_POST['Fcode'])."', ";		
		$strQry .="`Title`='".mysql_escape_string($_POST['Title'])."', ";
		$strQry .="`Director`='".mysql_escape_string($_POST['Director'])."', ";
		$strQry .="`IsStop_1`='".mysql_escape_string($_POST['IsStop_1'])."', ";
		$strQry .="`IsStop_2`='".mysql_escape_string($_POST['IsStop_2'])."', ";
		$strQry .="`Tel1`='".mysql_escape_string($_POST['Tel1'])."', ";
		$strQry .="`Tel2`='".mysql_escape_string($_POST['Tel2'])."', ";
		$strQry .="`Fax`='".mysql_escape_string($_POST['Fax'])."', ";
		$strQry .="`Address`='".mysql_escape_string($_POST['Address'])."', ";
		$strQry .="`Email`='".mysql_escape_string($_POST['Email'])."', ";
		$strQry .="`Contact`='".mysql_escape_string($_POST['Contact'])."', ";
		$strQry .="`Payment`='".mysql_escape_string($_POST['Payment'])."', ";
		$strQry .="`ReceiptAddr`='".mysql_escape_string($_POST['ReceiptAddr'])."', ";
		$strQry .="`RemitAddr`='".mysql_escape_string($_POST['RemitAddr'])."', ";
		$strQry .="`Fmark`='".mysql_escape_string($_POST['Fmark'])."', ";
		$strQry .="`Discount`='".mysql_escape_string($_POST['Discount'])."', ";
		$strQry .="`uDate`='".date("Y-m-d H:i:s")."', ";
		$strQry .="`userID`='".$_SESSION['ncareID_lwj']."'"; 
		$strQry .=" WHERE ".$strModule."ID=".$firmID;
		$db->query($strQry);
	}
	include('class/insertDetail.php');
	include('class/updateDetail.php');
	echo "<script>window.location.href='index.php?mod=consump&func=formview&id=1b&firmID=".$firmID."'</script>";
} else {
	//Edit/新增畫面
$db = new DB;
$db->query("SELECT * FROM `".$strModule."` WHERE `".$strModule."ID`='".mysql_escape_string($firmID)."'");
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
<div class="title_nav" style="width:160px">Vendor's info<?php echo ($firmID == $NULL)?"Add":"Maintain" ?></div>
<table width="100%">
  <tr>
    <td width="120" class="title">Vendor ID#</td>
    <td align="left"><?php echo ($firmID == $NULL)?"(System auto assign)":$firmID; ?></td>
    <td width="120" class="title">Vendor's name</td>
    <td colspan="3" align="left"><input type="text" name="Title" id="Title" size="60" value="<?php echo $Title; ?>" ></td>
    </tr>
  <tr>
    <td class="title">In partnership</td>
    <td align="left"><?php if($firmID==NULL){$IsStop=1;} echo draw_option("IsStop","Yes;No","s","single",$IsStop,false,2); ?></td>
    <td class="title">EIN/Tax ID</td>
    <td align="left"><input type="text" name="Fidno" id="Fidno" size="12" value="<?php echo $Fidno; ?>"></td>
    <td width="120" class="title">Person in charge</td>
    <td align="left"><input type="text" name="Director" id="Director" value="<?php echo $Director; ?>" size="12" ></td>
  </tr>
  <tr>
    <td class="title">Contact person</td>
    <td align="left"><input type="text" name="Contact" id="Contact" size="12" value="<?php echo $Contact; ?>"></td>
    <td class="title">Phone 1</td>
    <td align="left"><input type="text" name="Tel1" id="Tel1" size="15" value="<?php echo $Tel1; ?>"></td>
    <td class="title">Phone 2</td>
    <td align="left"><input type="text" name="Tel2" id="Tel2" size="15" value="<?php echo $Tel2; ?>" ></td>
  </tr>
  <tr>
    <td class="title">Fax</td>
    <td align="left"><input type="text" name="Fax" id="Fax" size="15" value="<?php echo $Fax; ?>"></td>
    <td class="title">e-mail</td>
    <td colspan="3" align="left"><input type="text" name="Email" id="Email" size="60" value="<?php echo $Email; ?>"></td>
    </tr>
  <tr>
    <td class="title">Address</td>
    <td colspan="5" align="left"><input type="text" name="Address" id="Address" size="60" value="<?php echo $Address; ?>" /></td>
  </tr>
  <tr>
    <td class="title">Payment terms</td>
    <td align="left"><input type="text" name="Payment" id="Payment" size="12" value="<?php echo $Payment; ?>"></td>
    <td class="title">Discount</td>
    <td align="left"><input type="text" name="Discount" id="Discount" size="6" value="<?php echo $Discount; ?>" >%</td>
    <td class="title">Vendor Category</td>
    <td align="left"><input type="text" name="Fcode" id="Fcode" size="12" value="<?php echo $Fcode; ?>" ></td>
  </tr>
  <tr>
    <td class="title">Billing address</td>
    <td colspan="5" align="left">
    <div style="width:230px; overflow:hidden;">
		<?php if($Address != NULL && $ReceiptAddr==$Address){$same1=1;}; echo draw_checkbox("same1","Same as vendor address",$same1,"single"); ?>
    </div>
    <input type="text" name="ReceiptAddr" id="ReceiptAddr" size="60" value="<?php echo $ReceiptAddr; ?>" />
    </td>
  </tr>
  <tr>
    <td class="title">Money address</td>
    <td colspan="5" align="left">
    <div style="width:230px; overflow:hidden;">
		<?php if($Address != NULL && $RemitAddr==$Address){$same2=1;}; echo draw_checkbox("same2","Same as vendor address",$same2,"single"); ?>
    </div><input type="text" name="RemitAddr" id="RemitAddr" size="60" value="<?php echo $RemitAddr; ?>" />
    </td>
  </tr>  
  <tr>
    <td class="title">Comment</td>
    <td colspan="5" align="left"><textarea id="Fmark" name="Fmark" cols="90" rows="3"><?php echo $Fmark; ?></textarea></td>
  </tr>
</table>
<br />
<div class="title_nav" style="width:200px">Other contact person</div>
<?php 
$tmpArr=array("Full name","Phone","Cell phone #","Fax","E-mail","Transaction date","Modified by");
$tmpLength = count($tmpArr);
include("class/blockDetail.php");
include("class/addDetail.php");

?>
<center>
	<input type="hidden" id="<?php $strModule ?>ID" name="<?php $strModule ?>ID" value="<?php $firmID ?>" />
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
	  location.href='index.php?mod=consump&func=formview&id=1a' ;
	});
	//發票地址同廠商地址
	$('#btn_same1_1').click(function(){
		$('#ReceiptAddr').val($('#Address').val());
	});
	//寄款地址同廠商地址
	$('#btn_same2_1').click(function(){
		$('#RemitAddr').val($('#Address').val());
	});
	
	//驗證
	$('#submit').click(function(){
	  if($('#Title').val() == ''){
		  alert('請輸入廠商名稱');
		  $('#Title').focus();
		  return false;
	  }	
	  if ($('#Email').val()!=''){
		var pattern= /^[\w\.\-]+@([\w\-]+\.)+[a-zA-Z]+$/;
		if (pattern.test($('#Email').val()) == false){
		  alert('您輸入的E-Mail有誤!!');
		  $('#Email').focus();
		  return false;
		}
	  }
	  
	  if(isNaN($('#Discount').val())){
		 alert("Input discount number");
		 $('#Discount').focus();
		 return false;
	  }	});
	    
  });
</script>