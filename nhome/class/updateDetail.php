<?php 

if ((int) @$_POST['oldCount'] <> ""){
  $arrQryInfo = explode(", ",$_POST['Qry']);
  for ($i=0;$i<$_POST['oldCount'];$i++) {
	 // echo $arrQryInfo[$i];
	  if($_POST['tmp1'.$arrQryInfo[$i]]==''){
		  //delete DB
		  $strQry = "DELETE FROM `alldetail` ";
		  $strQry .=" WHERE alldetailID='".$arrQryInfo[$i]."'";
		  //echo $strQry."<br>";
	  }else{
		  //update DB
		  $strQry = "UPDATE `alldetail` SET ";
		  $strQry .="`title`='".mysql_escape_string($_POST['tmp1'.$arrQryInfo[$i]])."', ";
		  $strQry .="`content1`='".mysql_escape_string($_POST['tmp2'.$arrQryInfo[$i]])."', ";
		  $strQry .="`content2`='".mysql_escape_string($_POST['tmp3'.$arrQryInfo[$i]])."', ";
		  $strQry .="`content3`='".mysql_escape_string($_POST['tmp4'.$arrQryInfo[$i]])."', ";
		  $strQry .="`content4`='".mysql_escape_string($_POST['tmp5'.$arrQryInfo[$i]])."', ";
		  $strQry .="`userID`='".$_SESSION['ncareID_lwj']."', ";
		  $strQry .="`uDate`='".date("Y-m-d H:i:s")."' ";
		  $strQry .=" WHERE alldetailID='".$arrQryInfo[$i]."'";
		  //echo $strQry."<br>";
	  }
		 $db->query($strQry);
	  
  }
}
?>