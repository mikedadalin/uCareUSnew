<?php
$ym = mysql_escape_string($_GET['ym']);

if (isset($_POST['submit'])) {
	
	for ($i=1; $i <= $_POST['itemCount'];$i++){
	  $dba = new DB;
	  $dba->query("SELECT * FROM `service_maintenance` WHERE `service_ym`='".$ym."' AND `service_itemID`='".mysql_escape_string($_POST['s_'.$i])."'");
	  if ($dba->num_rows()>0) {	
	  	$ra = $dba->fetch_assoc();
		$db = new DB;
		$strQry = "UPDATE `service_maintenance` SET ";
		$strQry .=" service_d = '".mysql_escape_string($_POST['d_'.$i])."',";
		$strQry .=" status_1 = '".mysql_escape_string($_POST['Q'.$i.'_1'])."',";	
		$strQry .=" status_2 ='".mysql_escape_string($_POST['Q'.$i.'_2'])."',";	
		$strQry .=" content = '".mysql_escape_string($_POST['content_'.$i])."',";
		$strQry .="`uDate`='".date("Y-m-d H:i:s")."'";
		$strQry .=" WHERE service_maintenanceID=".$ra['service_maintenanceID'];
		$db->query($strQry);
	  }else{
		$db = new DB;
		$strQry ="INSERT INTO `service_maintenance` (`service_itemID`,`service_ym`,`service_d`,`status_1`,`status_2`,`content`,`filler`) VALUES (";
		$strQry .=" '".mysql_escape_string($_POST['s_'.$i])."',";
		$strQry .=" '".mysql_escape_string(date(Ym))."',";
		$strQry .=" '".mysql_escape_string($_POST['d_'.$i])."',";
		$strQry .=" '".mysql_escape_string($_POST['Q'.$i.'_1'])."',";	
		$strQry .=" '".mysql_escape_string($_POST['Q'.$i.'_2'])."',";	
		$strQry .=" '".mysql_escape_string($_POST['content_'.$i])."',";
		$strQry .=" '".$_SESSION['ncareID_lwj']."'"; 
		$strQry .="  )";		
		$db->query($strQry);
	  }
	}
	echo "<script>alert('Modify success!');window.location.href='index.php?mod=maintenance&func=formview&id=1'</script>";
}
?>
<form  method="post">
<h3><?php echo substr($ym, 4, 2)?> Month-Routine Service / Maintenance Record</h3>
<table width="100%" border="0">	
  <tr class="title">
    <td colspan="2">Item(s)</td>
    <td>Maintenance items</td>
    <td>Date</td>
    <td>Repair/maintenance status</td>
    <td>Repair status description</td>
  </tr>
<?php
$db = new DB;
$str = "SELECT c.title titleC, c.service_cateID cID, a.title titleA, b.* FROM  `service_item` a ";
$str .="INNER JOIN service_maintenance b ON a.service_itemID = b.service_itemID ";
$str .="INNER JOIN service_cate c ON c.`service_cateID` = a.`service_cateID` ";
$str .=" WHERE 1 AND c.typeCode='".mysql_escape_string($_GET['mod'])."' AND b.service_ym='".$ym."' ORDER BY b.service_maintenanceID ";
//echo $str;
$db->query($str);
if($db->num_rows()>0){
	for ($i=0;$i<$db->num_rows();$i++) {
		$rs = $db->fetch_assoc();
		$db1 = new DB;
		$str1 = "SELECT * FROM `service_item` a inner join `service_cate` b on a.service_cateID=b.service_cateID  WHERE a.service_cateID='".$rs['cID']."' and a.isHidden_1=1 and b.isHidden_1=1 order by a.ord";
		$db1->query($str1);
		$r1 = $db1->fetch_assoc();
		${'aa'.$r1['parentID']} += 1;

	}
}
$db->query($str);
if($db->num_rows()>0){
	for ($i=0;$i<$db->num_rows();$i++) {
		$rs = $db->fetch_assoc();

		$db3 = new DB;
		$db3->query("SELECT * FROM `service_item` a inner join `service_cate` b on a.service_cateID=b.service_cateID  WHERE a.service_cateID='".$rs['cID']."' and a.isHidden_1=1 and b.isHidden_1=1 order by a.ord");
		$r3 = $db3->fetch_assoc();
		$cate = ($r3['parentID']==0)? $rs['titleC'] : getCate($r3['parentID']);
		$cate1 = ($r3['parentID']==0)? "" : $rs['titleC'];

		  echo '
			  <tr>';
				  if($aa!=getCate($r3['parentID'])){
					  echo'<td class="title_s" rowspan="'.${'aa'.$r3['parentID']}.'">'.$cate.'</td>';
				  }
				  $aa=getCate($r3['parentID']);
				  if($bb !=$rs['titleC']){
					  echo '<td class="title_s" rowspan="'.$db3->num_rows().'" >'.$cate1.'</td>';					  
				  }
				  $bb=$rs['titleC'];
				  
				  if($rs['status_1']==1){
					  $status = 1;
				  }elseif($rs['status_2']==1){
					  $status = 2;
				  }else{
					  $status = "";
				  }
				  
				  echo'
				  <td>'.$rs['titleA'].'<input name="s_'.$i.'" type="hidden" value="'.$rs['service_itemID'].'" ></td>
				  <td align="center"><input name="d_'.$i.'" type="text" size="2" maxlength="2" id="d_'.$i.'" value="'.$rs['service_d'].'" /></td>
				  <td align="center">'.draw_option("Q".$i,"Good;Needs repair","m","single",$status,false,0).'</td>
				  <td><input type="text" name="content_'.$i.'" id="content_'.$i.'" value="'.$r1['content'].'"/></td>
			  </tr>
		  ';
			
	}
	echo '
	';
}
echo $ab;?>  
</table>
<table width="100%">
  <tr>
    <td style="background:#ffffff;" align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>
<center style="margin-top:10px;">
	<input type="hidden" name="formID" id="formID" value="service_maintenance" />
    <input type="hidden" name="itemCount" id="itemCount" value="<?php echo $db->num_rows(); ?>" />
    <input type="button" id="back" name="back" value="Back to list" />
    <input type="submit" id="submit" name="submit" value="Save" /></center>
</form><br>
<script language="javascript">
$(function() {
	$('#back').click(function(){
		location.href = "index.php?mod=maintenance&func=formview&id=1";
	});
});
</script>
<?php
function getCate($id){
	$db = new DB;
	$str = "select * from service_cate where service_cateID='".$id."'";
	$db->query($str);
	$r1 = $db->fetch_assoc();
	return $r1['title'];
}
?>