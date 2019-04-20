<?php

//模組名稱
$strModule = "firmstock";
$firmstockID = str_pad((int) @$_GET[$strModule.'ID'],4,'0',STR_PAD_LEFT);
$subModule = "firmstockinfo";
$type = "IC";
if ($_GET['STK_DATE']=="") {
	$STKDATE = date("Y/m/d");
} else {
	$STKDATE = $_GET['STK_DATE'];
}

if (isset($_POST['submit'])) {

	//讀寫資料
	if ($_POST['firmstockID']!=NULL) {
		//Add
		if ((int) @$_POST['oldCount1'] <> ""){
			$fCount =  (int) @$_POST['oldCount1'];
			$ItemCount = 0;
			for ($i=1; $i<=$fCount ;$i++) {
				$tmp_STK_NO = "";
				if($_POST['oldSTK_NO'.$i] <> 0){
					$tmp_STK_NO = $_POST['oldSTK_NO'.$i];
				}
			
				if($tmp_STK_NO <> 0 && $_POST['oldSTOCK_INFO_NAME'.$i] <> '')
				{
				  $ItemCount +=1;
						  
				  //新增明細
				  $db2 = new DB;
				  $strQry ="INSERT INTO `firmstockexpire` (`firmStockID`,`STK_DATE`,`infoOrd`,`STK_NO`,`QTY`,`eDate`,`StockID`,`type`,`userID`";
				  $strQry .=") VALUES (";
				  $strQry .=" '".mysql_escape_string($_POST['firmstockID'])."',";
				  $strQry .=" '".mysql_escape_string($_POST['STK_Date'])."',";
				  $strQry .=" '".$ItemCount."',";
				  $strQry .=" '".mysql_escape_string($tmp_STK_NO)."',";
				  $strQry .=" '".mysql_escape_string($_POST['olddQTY'.$i])."',";
				  $strQry .=" '".mysql_escape_string($_POST['oldeDate'.$i])."',";
				  $strQry .=" '".mysql_escape_string($_POST['oldSTOCK_INFO'.$i])."',";
				  $strQry .=" '".$type."',";
				  $strQry .=" '".$_SESSION['ncareID_lwj']."'"; 
				  $strQry .="  )";		
				  $db2->query($strQry);
				}
			}				  
		};		
		echo "<script>alert('Add successfully!');window.location.href='index.php?mod=consump&func=formview&id=18'</script>";
	}else{
		echo "<script>alert('Data error!');window.location.href='index.php?mod=consump&func=formview&id=18'</script>";
	}
}

//編輯畫面
$db = new DB;
$strSQL = "SELECT a.*, RIGHT( EXTRACT( YEAR_MONTH FROM  `STK_Date` ) , 4 ) ordDate , b.Title, b.Fidno, b.Discount FROM `firmstock` a INNER JOIN `firm` b ON a.firmID = b.firmID  WHERE a.`IsStatus`='N' AND a.type='".$type."' and a.`".$strModule."ID`='".mysql_escape_string($firmstockID)."' and STK_DATE='".$STKDATE."'";

$db->query($strSQL);
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
?>
<h3>新增食材有效期限</h3>
<form  method="post">
<div class="content-table">
<table>
  <tr id="backtr">
    <td height="23" class="title" >Purchase bill #</td>
    <td  align="left"><input type="text" value="<?php echo "IC".$r['ordDate'].$r['firmStockID']; ?>" id="IN_firmStockID" name="IN_firmStockID" readonly="readonly"/></td>   
    <td class="title">Purchase date</td>
    <td  align="left"><input type="text" name="STK_Date" id="STK_Date" value="<?php echo $r['STK_Date']; ?>" size="12" readonly="readonly"></td>
    <td class="title"  >Tax</td>
    <td colspan="2"  align="left"><?php echo draw_option("Tax","Taxable;Exemption","xs","single",$Tax,false,2);?></td>
</tr>
  <tr id="backtr"  style=" height:20px;" >
    <td class="title" width="100"  style=" background-color:#FF8928;">Vendor ID#</td>
    <td align="left">
      <div id="FirmDiv" style="width:200px;"><input name="firmID" type="text" id="firmID" value="<?php echo $r['firmID']; ?>" readonly="readonly"/></div></td>
    <td class="title"  width="100">Vendor's name</td>
    <td  align="left"><input type="text" id="log0" name="log0" size="25" disabled="disabled" value="<?php echo $r['Title']; ?>"/></td>
    <td class="title" width="100" >EIN/Tax ID</td>
    <td colspan="2"  align="left"><input type="text" id="log1" name="log1" disabled="disabled" value="<?php echo $r['Fidno']; ?>" /></td>
    </tr>
  <tr >
    <td class="title" >Comment</td>
    <td colspan="3"  align="left"><textarea id="Fmark" name="Fmark" rows="1" cols="50" readonly><?php echo $r['Fmark']; ?></textarea></td>   
    <td class="title"  >Documented personnel</td>
    <td colspan="2"  align="left"><?php echo checkusername($_SESSION['ncareID_lwj']);?></td>
    </tr>  
    
</table>
<?php 
$IN = $type.$r['ordDate'].$r['firmStockID'];
include("class/blockTableExp.php");
 ?>
</div>
<br />&nbsp;
<center>
	<input type="hidden" id="<?php echo $strModule ?>ID" name="<?php echo $strModule ?>ID" value="<?php echo $firmstockID ?>" />    
    <input type="button" id="cmdBack" name="cmdBack" value="Back to list"  />
    <?php if($r['IsStatus'] == 'N'){?>
	<input type="submit" name="submit" id="submit" value="Save" />
    <?php }?>
</center>
</form>
<?php
}
?>

<script language="javascript">
$(function() {
	//Back to list
	$('#cmdBack').click(function(){
	  location.href='index.php?mod=consump&func=formview&id=18' ;
	});
	
  //驗證
  $('#submit').click(function(){
    if($('#oldCount').val()==0){
		alert('產品不得為空!!\n請按F5重新整理頁面');		
		return false;	
	}
  });
});
    

</script>

