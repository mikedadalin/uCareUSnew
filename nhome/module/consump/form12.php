<script type="text/javascript" src="js/share.js"></script>
<h3>Shippment</h3>
<?php

//模組名稱
$strModule = "firmstock";
$subModule = "firmstockinfo";
$type = "SP";

/*
分頁
ps 每頁顯示筆數
pn 頁次
*/
$ps = 50;
$pn = 1;
if (@$_GET['pn'] > 0) { $pn= @$_GET['pn']; }


$strQry = "";
//預設帶入目前系統年月

if($_POST["act"]!=""){
//	$strQry = " AND YEAR(t1.`STK_Date`) ='".date("Y")."' AND MONTH(t1.`STK_Date`) ='".date("m")."'";
}

//住民護字號
if($_GET["firmID"]!=""){
	$strQry .= " AND t1.firmID = '".str_pad(getHospNo(getPIDByHospNoDisplay($_GET["firmID"])),6,'0',STR_PAD_LEFT)."'";
}

//Shipping date
if($_GET["sSTK_Date"]!=""){
	$strQry .= " AND t1.STK_Date >= '".mysql_escape_string($_GET["sSTK_Date"])."'";
}
//Delivery note ID#
if($_GET["firmStockID"]!=""){
	$tmpDate1 = substr($_GET["firmStockID"], 0, 2);
	$tmpDate2 = substr($_GET["firmStockID"], 2, 2);
	$tmpStockID = substr($_GET["firmStockID"], 4, 4);		
	$strQry .= " AND YEAR(  `STK_Date` ) ='20".$tmpDate1."'";
	$strQry .= " AND MONTH( `STK_Date` ) ='".$tmpDate2."'";
	$strQry .=" AND  `firmStockID` =".$tmpStockID;
}
$pageString = "firmID=".$_GET["firmID"]."&sSTK_Date=".$_GET["sSTK_Date"]."&firmStockID=".$_GET["firmStockID"];

if($_POST["act"]=="delete"){
	//刪除出貨單
	//print_r($_POST);
	$delDB1 = new DB;
	$delDB2 = new DB;
	$DelCounter=count($_POST['chk'.$strModule.'ID']);
	for($del=0;$del<$DelCounter;$del++){
		$arrDel = explode(",",$_POST['chk'.$strModule.'ID'][$del]);		
		$db->query("select * from `".$strModule."` where `IN_firmStockID`='".$arrDel[0]."' AND `IsStatus` <> 'D'");
		if($db->num_rows()>0){
			echo "<script>alert('有退貨不能刪除!');window.location.href='index.php?mod=consump&func=formview&id=12'</script>";
		}else{
		  //主單
			$DelQry = "UPDATE `".$strModule."` SET IsStatus='D' WHERE type='".$type."' and `".$strModule."ID` ='".substr($arrDel[0],-4)."' ";
			$DelQry .=" AND YEAR(`STK_Date`)='20".substr($arrDel[0],2,2)."' AND MONTH(`STK_Date`) ='".substr($arrDel[0],4,2)."'";
			$delDB1->query($DelQry);
		  //細項
			$DelQry = "UPDATE `".$subModule."` SET IsStatus='D' WHERE type='".$type."' and `".$strModule."ID` ='".substr($arrDel[0],-4)."' ";
			$DelQry .=" AND YEAR(`STK_Date`)='20".substr($arrDel[0],2,2)."' AND MONTH(`STK_Date`) ='".substr($arrDel[0],4,2)."'";
			$delDB2->query($DelQry);
		//扣除庫存量
			$UPDATE_DB = new DB;
			foreach ($_POST['chk'.$strModule.'ID'] as $k1=>$v1) {
				$DelQry = "select * from `".$subModule."` where type='".$type."' and `".$strModule."ID`='".substr($v1,-4)."' ";
				$DelQry .=" AND YEAR(`STK_Date`)='20".substr($v1,2,2)."' AND MONTH(`STK_Date`) ='".substr($v1,4,2)."'";
				$db->query($DelQry);	
				if($db->num_rows()>0){			
					for ($ii=0;$ii<$db->num_rows();$ii++) {
						$rs = $db->fetch_assoc();	
						$strQry1 = "UPDATE `stock` SET ";
						$strQry1 .="`StockSum`=StockSum-".$rs['QTY'].", ";
						$strQry1 .="`stockAMT`=stockAMT-".$rs['QTY'] * $rs['Price'].", ";
						$strQry1 .="`uDate`='".date("Y-m-d H:i:s")."', ";
						$strQry1 .="`userID`='".$_SESSION['ncareID_lwj']."' ";
						$strQry1 .=" WHERE StockID='".$rs['StockID']."' and STK_NO=".$rs['STK_NO']."";
						$UPDATE_DB->query($strQry1);
					}
				}
			}
			
		//寫入庫存進出表
			$UPDATE_DB = new DB;
			$DelQry = "select * from `".$subModule."` where type='".$type."' and `".$strModule."ID`='".substr($arrDel[0],-4)."' ";
			$DelQry .=" AND YEAR(`STK_Date`)='20".substr($arrDel[0],2,2)."' AND MONTH(`STK_Date`) ='".substr($arrDel[0],4,2)."' AND `IsStatus` = 'D'";
			$db->query($DelQry);	
			if($db->num_rows()>0){			
				for ($ii=0;$ii<$db->num_rows();$ii++) {
					$rs = $db->fetch_assoc();	
					$arrDateFunction = chkDate($rs['STK_DATE']);
					$strQry1 = "UPDATE `stockform` SET ";
					$strQry1 .="`OUT_STK`=OUT_STK-".$rs['QTY'].", ";
					$strQry1 .="`OUT_PRC`=OUT_PRC-(".$rs['QTY'] * round($rs['Price'])."), ";
					$strQry1 .="`uDate`='".date("Y-m-d H:i:s")."', ";
					$strQry1 .="`userID`='".$_SESSION['ncareID_lwj']."' ";
					$strQry1 .=" WHERE StockID='".$rs['StockID']."' and STK_NO=".$rs['STK_NO']." and `STK_YEAR`='".$arrDateFunction['year']."' and STK_MONTH='".$arrDateFunction['month']."'";
					$UPDATE_DB->query($strQry1);
				}
			}
		}
	}
}

// 總頁次及總筆數
$strQry1="select COUNT(1) AS tbCount from ".$strModule." t1 where t1.type='".$type."' and t1.IsStatus<>'D' ".$strQry."";
$dbpage = new DB;
$dbpage->query($strQry1);
$p = $dbpage->fetch_assoc();
$totalRecord = $p['tbCount'];
//echo $strQry1;

if($totalRecord < $ps){
	$totalPage = 1;	
}else{
	if($totalRecord % $ps <> 0){
		$totalPage = floor($totalRecord / $ps) +1;		
	}else{
		$totalPage = $totalRecord / $ps;
	}
}

//主SQL
$sql1="";
//$sql1="SELECT * FROM ";
$sql1.="SELECT t1.*, RIGHT( EXTRACT( YEAR_MONTH FROM  t1.`STK_Date` ) , 4 ) ordDate from `".$strModule."` t1 where t1.IsStatus<>'D' and t1.type='".$type."' ".$strQry."  ORDER BY t1.STK_DATE DESC, t1.`".$strModule."ID` DESC LIMIT ".(($pn-1)*$ps).", ".$ps."";
//$sql1.=" ORDER BY T2.STK_DATE DESC,T2.`".$strModule."ID` LIMIT 0 ,".$ps."";
?>
<form method="post">
	<div align="left" class="content-query">
		<table width="100%" class="printcol" cellpadding="6" style="margin-bottom:20px;">
			<tr class="title">
				<td colspan="5">Filter Condition</td>
			</tr>

			<tr>
				<td width="120" class="title"><center><b>Care ID#</b></center></td>
				<td  width="10%"> <div id="FirmDiv"><input name="firmID" type="text" id="firmID" onblur="newORD();"/></div></td>  
				<td><button onclick="window.open('class/consump.php?query=3', '_blank', 'width=300, height=200'); return false;" >...</button></td>
				<td class="title">Resident's name </td>
				<td>&nbsp;<input type="text" id="log0" name="log0" size="40" disabled="disabled"/></td>
			</tr>
			<tr>
				<td width="120" class="title"><center><b>Delivery Note ID#</b></center></td>
				<td align="left" colspan="4" ><?php echo $type;?><input type="text" id="firmStockID" name="firmStockID" /></td>
			</tr>
			<tr>
				<td class="title">Shipping Date</td>
				<td align="left" colspan="4">
					Since <input type="text" name="sSTK_Date" id="sSTK_Date" value="" size="12" > 
				</td>
			</tr>
			<tr>
				<td colspan="5"><center>
					<input type="button" value="Search" id="btnSearch" name="btnSearch" /> 
				</center></td>
			</tr>
		</table>
	</div>
	<div align="left">
		<input type="button" name="btnDel" id="btnDel" value=" Delete">
		<input type="button" name="btnAdd" id="btnAdd" value=" New Delivery note" />
	</div>
	<div class="content-table">
		<table width="100%" cellpadding="6">
			<tr class="title">
				<td width="50">&nbsp;</td>
				<td width="130">Delivery note ID#</td>
				<td width="100">Shipping Date</td>
				<td width="100">Care ID#</td>
				<td width="*">Name</td>
				<td width="100">Bed #</td>
				<td width="120">Function</td>
			</tr>
			<?php

			$db = new DB;
			$db->query($sql1);
			if ($db->num_rows()>0) {
//echo $sql1;	
				for ($i=0;$i<$db->num_rows();$i++) {
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
					<tr>
						<td align="center">
							<?php print_r("<input type='checkbox' id='chk".$strModule."ID' name='chk".$strModule."ID[]' value='".$type.$ordDate.$firmStockID."'>"); ?>
						</td>
						<td>&nbsp;<?php echo $type.$ordDate.$firmStockID; ?></td>
						<td>&nbsp;<?php echo $r['STK_Date']; ?></td>
						<td>&nbsp;<?php if (substr($r['firmID'],0,4)=="Area") { echo '---'; } else { echo getHospNoDisplayByHospNo($r['firmID']); } ?></td>
						<td>&nbsp;<?php if (substr($r['firmID'],0,4)=="Area") { echo getArkAreaName($r['firmID']); } else { echo getPatientName(getPID($r['firmID'])); } ?></td>
						<td>&nbsp;<?php if (substr($r['firmID'],0,4)=="Area") { echo '---'; } else { echo getBedID(getPID($r['firmID'])); } ?></td>
						<td>
							<?php 
							if(substr($r['firmID'],0,4)=="Area"){
								$url = "&aID=".str_replace('Area','',$r['firmID']);
							}else{
								$url = "&pid=".$r['firmID'];
							}
							?>
							<input type="button" value="Edit" onclick="window.location.href='index.php?mod=consump&func=formview&id=12_1&firmstockID=<?php echo $firmStockID.$url; ?>&STK_DATE=<?php echo $r['STK_Date']; ?>'">
							<!--input type="button" value="Returns" onclick="window.location.href='index.php?mod=consump&func=formview&id=12_OC&firmstockID=<?php echo $firmStockID; ?>&STK_DATE=<?php echo $r['STK_Date']; ?>'"-->
						</td>
					</tr>
					<?php }}else{?>
					<tr>
						<td align="center" colspan="7">No data yet!!</td>
					</tr>

					<?php
				}
				?>
			</table>
			<!--page Start-->
			<table width="100%" style="border-collapse: collapse;" cellpadding="5" class="printcol">
				<tr>
					<td align="center" class="title page" style="padding:10px 0px;">
						<?php
						changePageManager($totalRecord,$totalPage,$pn,$ps,$pageString,"index.php?mod=consump&func=formview&id=12");
						?>
					</td>
				</tr>
			</table>
			<!--page End-->
		</div>

		<input type="hidden" name="act" id="act" />
	</form>
	<script language="javascript">
	function newORD() {
		$.ajax({
			url: "class/patient.php",
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
		$('#btnSearch').click(function() {
			$('#act').val('search');
			if($('#firmStockID').val()!=''){
				if ($('#firmStockID').val().length!=8){
					$('#firmStockID').focus();
					alert('請輸入正確單號!');
					return false;
				}
			}
			$('form').attr('action', "index.php?mod=consump&func=formview&id=12&firmStockID="+$('#firmStockID').val()+"&firmID="+$('#firmID').val()+"&sSTK_Date="+$('#sSTK_Date').val());
			$('form').submit();
		});

		$('#btnAdd').click(function() {
			location.href='index.php?mod=consump&func=formview&id=12_2';
		});
		
		$('#btnDel').click(function() {
			if (DelDataCheck(document.forms[0].chk<?php echo $strModule."ID";?>)){
				$('#act').val('delete');
				$('form').submit();
			}
		});
		$( "#sSTK_Date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true});
	});

	</script>
	