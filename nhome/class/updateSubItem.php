<?php 
if ((int) @$_POST['oldCount'] <> ""){
  $arrQryInfo = explode(", ",$_POST['Qry']);
  for ($i=0;$i<$_POST['oldCount'];$i++) {
	  
	  if($_POST['tmp0'.$arrQryInfo[$i]]==''){
		  //delete DB
		  $strQry = "DELETE FROM `alldetail` ";
		  $strQry .=" WHERE alldetailID='".$arrQryInfo[$i]."'";
		  //echo $strQry."<br>";
	  }else{
		  //update DB
		  if($_POST['tmp0'.$arrQryInfo[$i]] !=""){
			  $tmp0 = str_replace("/","",$_POST['tmp0'.$arrQryInfo[$i]]);
		  }
		  if($_POST['tmp1'.$arrQryInfo[$i].'H1'] !="" && $_POST['tmp1'.$arrQryInfo[$i].'I1'] !=""){
			  $tmp1 = $_POST['tmp1'.$arrQryInfo[$i].'H1'].':'.$_POST['tmp1'.$arrQryInfo[$i].'I1'];
		  }else{
			  $tmp1 = $_POST['tmp1'.$arrQryInfo[$i]];
		  }		  
		  
		  $strQry = "UPDATE `alldetail` SET ";
		  $strQry .="`title`='".mysql_escape_string($tmp0)."', ";
		  $strQry .="`content1`='".mysql_escape_string($tmp1)."', ";
		  $strQry .="`content2`='".mysql_escape_string($_POST['tmp2'.$arrQryInfo[$i]])."', ";
		  $strQry .="`content3`='".mysql_escape_string($_POST['tmp3'.$arrQryInfo[$i]])."', ";
		  $strQry .="`content4`='".mysql_escape_string($_POST['tmp4'.$arrQryInfo[$i]])."', ";
		  $strQry .="`userID`='".$_SESSION['ncareID_lwj']."', ";
		  $strQry .="`uDate`='".date("Y-m-d H:i:s")."' ";
		  $strQry .=" WHERE `allDetailID`='".$arrQryInfo[$i]."'";
		  //echo $strQry."<br>";
	  }
		 $db->query($strQry);
	  
  }
}
?>