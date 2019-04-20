<?php
include("DB.php");
include("function.php");
include("../lwj/lwj.php");
//模組名稱module name
if (@$_GET['query']==NULL || @$_GET['query']==1) {
	$strModule = "firm";
	$strQry = " and IsStop_1=1";
	$strTitle = "Vendor list";
	if($_REQUEST['cateID']!='') {$strQry.=" and Fcode='".$_REQUEST['cateID']."'";}
} elseif(@$_GET['query']==2){
	$strModule = "stockinfo";
	$strQry = "";
	$strTitle = "Storage list";
} elseif(@$_GET['query']==3){
	$strModule = "patient";
	
	$strTitle = "Resident list";
	if($_GET['area'] != ""){

		$db2 = new DB;
		$db2->query("SELECT b.`patientID` FROM `bedinfo` a inner join `inpatientinfo` b WHERE a.`bedID`=b.`bed` AND a.`Area`='".mysql_escape_string($_GET['area'])."'");
		if ($db2->num_rows()){
		  for ($k=0;$k<$db2->num_rows();$k++) {
			  $r2 = $db2->fetch_assoc();
			   if ($k == $db2->num_rows()-1){
					$Qry .= $r2['patientID'];
			   }else{
					$Qry .= $r2['patientID'].', ';		   
			   }  
		  }
		}
		if($Qry != ""){
		  $strQry .= " and a.`patientID` in (".$Qry.")";
		}else{
		  $strQry .= "";  
		}
		
	}
	$db3 = new DB;
	$db3->query("SELECT b.`patientID` FROM `closedcase` b ");
	if ($db3->num_rows()){
	  for ($k1=0;$k1<$db3->num_rows();$k1++) {
		  $r3 = $db3->fetch_assoc();
		   if ($k1 == $db3->num_rows()-1){
				$Qry1 .= $r3['patientID'];
		   }else{
				$Qry1 .= $r3['patientID'].', ';		   
		   }  
	  }
	}
	if(@$_GET['show']==NULL || @$_GET['show']==1){
		if($Qry1 != ""){
		  $strQry .= " and a.`patientID` not in (".$Qry1.")";
		}else{
		  $strQry .= "";  
		}
	}else{
		$strQry = " and a.`patientID` in (".$Qry1.")";
	}

} else{
	echo "<script>alert('No data match');window.close();</script>";	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $strTitle; ?></title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery-1.8.2.min.js"></script>
</head>

<body>

<form>
<div class="content-table">
<center>
	<h3><?php echo $strTitle; ?></h3>
</center>

<?php
if ($strTitle == "Vendor list") {
$cate = "select distinct Fcode from ".$strModule." where Fcode<>'' and IsStop_1=1";
$db1 = new DB;
$db1->query($cate);	

if($db1->num_rows() >0){ 
?>
<div id="cate">&nbsp;Vendor category
<select name="cateID" id="cateID">
	<option value="">---total---</option> 
	<?php for ($i=0;$i<$db1->num_rows();$i++) {
		  $rs = $db1->fetch_assoc();
	?>
		<option value="<?php echo $rs['Fcode']; ?>" <?php if($_REQUEST['cateID']==$rs['Fcode']) echo "selected"; ?>><?php echo $rs['Fcode']; ?></option>
    <?php }?>
</select>
</div>
<?php }}?>
<?php
if ($strTitle == "Resident list") {
?>
<div id="cate">&nbsp;Section
<select name="area" id="area">
	<option value="">---total---</option> 
      <?php
	  $qArea = new DB;
	  $qArea->query("SELECT * FROM `areainfo` ORDER BY `areaID` ASC");
	  for ($i=0;$i<$qArea->num_rows();$i++) {
		  $rArea = $qArea->fetch_assoc();
		  echo '<option value="'.$rArea['areaID'].'"';
		  if ($_GET['area']==$rArea['areaID']) { echo " selected"; }
		  echo '>'.$rArea['areaName'].'</option>'."\n";
	  }
	  ?>
      </select>
<?php if(@$_GET['show']==NULL || @$_GET['show']==1){?>      
<input type="button" id="showAll" value="Display close case resident" style="cursor:pointer;" />
<?php }else{?>
<input type="button" id="show" value="Display current resident" style="cursor:pointer;" />
<?php }?>
      
      </div>
      
<?php }?>

<table>
<tr class="title">
  <td width="10%">Serial number</td>
  <td width="*" align="left">Name</td>
</tr>
<?php
if ($strTitle == "Resident list") {
	$sql1 = "SELECT a.patientID, a.Name1, b.Discount1, b.Discount2, b.Fidno, a.Name2, a.Name3, a.Name4 FROM `".$strModule."` a inner join patientdiscount b ";
	$sql1 .=" on a.".$strModule."ID=b.".$strModule."ID  where 1=1 ".$strQry."";
}else{
	$sql1 = "SELECT * FROM `".$strModule."` WHERE 1=1 ".$strQry." ORDER BY `".$strModule."ID` ASC";
}
$db = new DB;
$db->query($sql1);
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
	/*== 解 START ==*/
	$LWJArray = array('Name1','Name2','Name3','Name4');
	$LWJdataArray = array($r['Name1'],$r['Name2'],$r['Name3'],$r['Name4']);
	for($z=0;$z<count($LWJdataArray);$z++){
	    $rsa = new lwj('../lwj/lwj');
	    $puepart = explode(" ",$LWJdataArray[$z]);
	    $puepartcount = count($puepart);
	    if($puepartcount>1){
            for($m=0;$m<$puepartcount;$m++){
                $prdpart = $rsa->privDecrypt($puepart[$m]);
                $r[$LWJArray[$z]] = $r[$LWJArray[$z]].$prdpart;
            }
	    }else{
		   $r[$LWJArray[$z]] = $rsa->privDecrypt($LWJdataArray[$z]);
	    }
	}
	/*== 解 END ==*/
	if($r['Name2']!="" || $r['Name2']!=NULL){$r['Name2'] = " ".$r['Name2'];}
	if($r['Name3']!="" || $r['Name3']!=NULL){$r['Name3'] = " ".$r['Name3'];}
	if($r['Name4']!="" || $r['Name4']!=NULL){$r['Name4'] = " ".$r['Name4'];}
	$r['Name'] = $r['Name1'].$r['Name2'].$r['Name3'].$r['Name4'];
	if ($strTitle == "Resident list") {
?>
  <tr>
    <td align="center">
    <?php
		if($_GET['type']=="ord"){
			echo '<a href="javascript:void(0);" onclick="patient(\''.$r[$strModule.'ID'].'\');">'.getHospNoDisplayByPID($r[$strModule.'ID']).'</a>';

		}else{			
	?>
    	<a href="#" id="consump" onclick="updateOpener('<?php echo @$_GET['c'] ?>','<?php echo getHospNoDisplayByPID($r[$strModule.'ID']); ?>','<?php echo $r['Name']; ?>','<?php echo $Fidno ?>','<?php echo $Discount1; ?>','<?php echo @$_GET['t'] ?>','<?php echo $Discount2; ?>','<?php echo getBedID($r[$strModule.'ID']); ?>');"><?php echo getHospNoDisplayByPID($r[$strModule.'ID']); ?></a>
	<?php }?>
    </td>
    <td><?php echo $r['Name']; ?></td>
  </tr>
<?php
	}else{
?>		
  <tr>
    <td align="center"><a href="#" id="consump" onclick="updateOpener('<?php echo @$_GET['c'] ?>','<?php echo $r[$strModule.'ID'] ?>','<?php echo $Title ?>','<?php echo $Fidno ?>','<?php echo $Discount ?>','<?php echo @$_GET['t'] ?>');"><?php echo $r[$strModule.'ID'] ?></a></td>
    <td><?php echo $Title ?></td>
  </tr>
<?php
	}
}
?>
</table>
</div>
<center>
	<input type="button" value="Close" onclick="window.close();">
</center>
</form>

<script type="text/javascript">
  function updateOpener(q,t,n,id,d,type,d1,bed)
  {
	var FirmDiv = window.opener.jQuery("#FirmDiv");	
	var FirmDiv1 = window.opener.jQuery("#FirmDiv1");	
	var log0 = window.opener.jQuery("#log0");	
	var log1 = window.opener.jQuery("#log1");
	var log2 = window.opener.jQuery("#log2");
	var log3 = window.opener.jQuery("#log3");
	var log4 = window.opener.jQuery("#log4");
	var log98 = window.opener.jQuery("#log98");
	var log99 = window.opener.jQuery("#log99");
	var STOCK_INFO = window.opener.jQuery("#STOCK_INFO"+q);	
	var STOCK_INFO_NAME = window.opener.jQuery("#STOCK_INFO_NAME"+q);	
	var SSTOCK_INFO = window.opener.jQuery("#SSTOCK_INFO"+q);	
	var SSTOCK_INFO_NAME = window.opener.jQuery("#SSTOCK_INFO_NAME"+q);	
	var oldSTOCK_INFO = window.opener.jQuery("#oldSTOCK_INFO"+q);	
	var oldSTOCK_INFO_NAME = window.opener.jQuery("#oldSTOCK_INFO_NAME"+q);	
	if(q==""){
	  if (FirmDiv != null || FirmDiv1 != null) {
		  FirmDiv.html("<input type=text value="+t+" onblur=newORD() id=firmID name=firmID>");
		  FirmDiv.val(t);
		  FirmDiv1.val(t);
		  log0.val(n);
		  log0.html(n);
		  log99.html(n);
		  log1.val(id);
		  log2.val(d);
		  log3.val(d1);
		  log4.val(bed);
		  log4.html(bed);
		  log98.html(bed);
	  }
	}else{		
		if(type!='old'){
		  STOCK_INFO.val(t);
		  SSTOCK_INFO.val(t);
		  STOCK_INFO_NAME.html(n);
		  STOCK_INFO_NAME.val(n);
		  SSTOCK_INFO_NAME.val(n);
		}else{
		  oldSTOCK_INFO.val(t);
		  oldSTOCK_INFO_NAME.html(n);
		  oldSTOCK_INFO_NAME.val(n);
		  SSTOCK_INFO.val(t);
		  SSTOCK_INFO_NAME.val(n);
		 }
	}
	window.close();
  }
  function patient(pid){
      var chkDATE = window.opener.jQuery('#STK_Date').val();	
	  opener.location.href ="../index.php?mod=consump&func=formview&id=12_2&pid=" + pid + "&STK_DATE=" + chkDATE ;
	  window.close();
  }
$(function() {
   $('#cateID').change(function() {
      location.href = "?query=1&cateID=" + $('#cateID').val();
	 });   
   $('#area').change(function() {
	   var ord = '<?php echo $_GET['type']; ?>';
	   if(ord != ""){
         location.href = "?query=3&type=ord&area=" + $('#area').val();
	   }else{
		  location.href = "?query=3&area=" + $('#area').val(); 
	   }
	 });   
	 
   $('#showAll').click(function(){
	  location.href = "?query=3&show=0"; 
	 });	   
   $('#show').click(function(){
	  location.href = "?query=3&show=1"; 
	 });	   
	 
});

</script>
<p>&nbsp;</p>
</body>
</html>

