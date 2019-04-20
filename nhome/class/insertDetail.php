<?php 
if ((int) @$_POST['fileCount'] <> ""){
	$fCount =  (int) @$_POST['fileCount'];
	for ($i=1; $i<=$fCount ;$i++) {
		$tmp_title = "";
		if(!empty($_POST['tmp1'.$i]))
		{
		  //新增明細adding detail list
		  $db2 = new DB;
		  $strQry ="INSERT INTO `alldetail` (title,parentName,parentID,content1,content2,content3,content4,uDate,userID";
		  $strQry .=") VALUES (";
		  $strQry .=" '".mysql_escape_string($_POST['tmp1'.$i])."',";
		  $strQry .=" '".$parentName."',";
		  $strQry .=" '".$parentID."',";
		  $strQry .=" '".mysql_escape_string($_POST['tmp2'.$i])."',";
		  $strQry .=" '".mysql_escape_string($_POST['tmp3'.$i])."',";
		  $strQry .=" '".mysql_escape_string($_POST['tmp4'.$i])."',";
		  $strQry .=" '".mysql_escape_string($_POST['tmp5'.$i])."',";
		  $strQry .=" '',"; 
		  $strQry .=" '".$_SESSION['ncareID_lwj']."'"; 
		  $strQry .="  )";		
		  $db2->query($strQry);
		  //echo $strQry."<br>";
		}
	}
};

?>