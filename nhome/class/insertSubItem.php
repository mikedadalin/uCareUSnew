<?php 
if ((int) @$_POST['fileCount'] <> ""){	
	$fCount =  (int) @$_POST['fileCount'];
	for ($i=1; $i<=$fCount ;$i++) {
		$tmp_title = "";
		if(!empty($_POST['tmp_0_'.$i]))
		{
		  //新增明細
		  if($_POST['tmp_0_'.$i] !=""){
			  $tmp_0 = str_replace("/","",$_POST['tmp_0_'.$i]);
		  }
		  if($_POST['tmp1'.$i.'H'] !="" && $_POST['tmp1'.$i.'I'] !=""){
			  $tmp_1 = $_POST['tmp1'.$i.'H'].':'.$_POST['tmp1'.$i.'I'];
		  }else{
			  $tmp_1 = $_POST['tmp_1_'.$i];
		  }
		  $db2 = new DB;
		  $strQry ="INSERT INTO `alldetail` (title,parentName,parentID,content1,content2,content3,content4,uDate,userID";
		  $strQry .=") VALUES (";
		  $strQry .=" '".mysql_escape_string($tmp_0)."',";
		  $strQry .=" '".$parentName."',";
		  $strQry .=" '".$parentID."',";
		  $strQry .=" '".mysql_escape_string($tmp_1)."',";
		  $strQry .=" '".mysql_escape_string($_POST['tmp_2_'.$i])."',";
		  $strQry .=" '".mysql_escape_string($_POST['tmp_3_'.$i])."',";
		  $strQry .=" '".mysql_escape_string($_POST['tmp_4_'.$i])."',";
		  $strQry .=" '',"; 
		  $strQry .=" '".$_SESSION['ncareID_lwj']."'"; 
		  $strQry .="  )";		
		  $db2->query($strQry);
		  //echo $strQry."<br>";
		}
	}
};

?>