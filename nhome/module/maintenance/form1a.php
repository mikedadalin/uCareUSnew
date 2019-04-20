<?php
if (isset($_POST['submit'])) {
	
	for ($i=1; $i <= $_POST['itemCount'];$i++){
	  $dba = new DB;
	  $dba->query("SELECT * FROM `service_maintenance` WHERE `service_ym`='".date(Ym)."' AND `service_itemID`='".mysql_escape_string($_POST['s_'.$i])."'");
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
	echo "<script>alert('Add successfully!');window.location.href='index.php?mod=maintenance&func=formview&id=1'</script>";
}

?>
<form  method="post">
<h3><?php echo substr(date(Ym), 4, 2)?> Month-Routine Service / Maintenance Record</h3>
<div align="right">
<input type="button" id="Item" name="Item" value="Project management">
<!--月份查詢:-->
<?php
/*$ym = new DB;
$ym->query("SELECT DISTINCT service_ym FROM service_maintenance");
if($ym->num_rows()>0){
	echo '<select name="yy" id="yy">';
	echo '<option value="">-- month--</option>';
	for($ii=0;$ii<$ym->num_rows();$ii++){
		$rr = $ym->fetch_assoc();
		echo '<option value="'.$rr['service_ym'].'">'.substr($rr['service_ym'], 0, 4).'/'.substr($rr['service_ym'], 4, 2).'</option>';
	}
	echo '</select>';
}
$r5 = $ym->fetch_assoc();*/
?>
</div>
<table border="0" style="width:100%;">	
  <tr class="title">
    <td colspan="2">Item(s)</td>
    <td>Maintenance items</td>
    <td>Date</td>
    <td>Repair/maintenance status</td>
    <td>Repair status description</td>
  </tr>
<?php
$a = 1;
$db = new DB;
$str =" SELECT a.title titlea, a.service_cateID aID, c.title titlec, c.service_cateID cID FROM  `service_cate` a ";
$str .=" LEFT JOIN  `service_cate` c ON c.`parentID` = a.`service_cateID` ";
$str .=" WHERE 1 and a.typeCode='".mysql_escape_string($_GET['mod'])."' AND a.`layer` =1 AND a.`isHidden_1` =1 ";
$str .=" ORDER BY a.ord";

$db->query($str);
if($db->num_rows()>0){
	for ($i=0;$i<$db->num_rows();$i++) {
		$r = $db->fetch_assoc();
		$cate = ($r['cID']=="")? $r['aID']:$r['cID'];
		$db1 = new DB;
		$str1 = "SELECT * FROM `service_item` a inner join `service_cate` b on a.service_cateID=b.service_cateID  WHERE a.service_cateID='".$cate."' and a.isHidden_1=1 and b.isHidden_1=1 order by a.ord";
		$db1->query($str1);
		${'aa'.$r['aID']} += $db1->num_rows();
		$ab += $db1->num_rows();
	}
}

$db->query($str);
if($db->num_rows()>0){
	for ($i=0;$i<$db->num_rows();$i++) {
		$r = $db->fetch_assoc();
		
		$cate = ($r['cID']=="")? $r['aID']:$r['cID'];
		$db1 = new DB;
		$str1 = "SELECT a.title, a.service_itemID FROM `service_item` a inner join `service_cate` b on a.service_cateID=b.service_cateID  WHERE a.service_cateID='".$cate."' and a.isHidden_1=1 and b.isHidden_1=1 order by a.ord";


		$db1->query($str1);
		if($db->num_rows()>0){
			
			for ($i1=0;$i1<$db1->num_rows();$i1++) {
			  $r1 = $db1->fetch_assoc();				
			  
		  	  echo '
			  <tr>';
				  if($tmp!=$r['titlea']){
					  echo'<td class="title_s" rowspan="'.${'aa'.$r['aID']}.'">'.$r['titlea']."<br>".'</td>';
				  }
				  if($tmp1!=$cate){
					  echo '<td class="title_s" rowspan="'.$db1->num_rows().'">'.$r['titlec'].'</td>';
				  }			  
				  echo'
				  <td>'.$r1['title'].'<input name="s_'.$a.'" type="hidden" value="'.$r1['service_itemID'].'" ></td>
				  <td align="center"><input name="d_'.$a.'" type="text" size="2" maxlength="2" id="d_'.$a.'" /></td>
				  <td align="center">'.draw_option("Q".$a,"Good;Needs repair","l","single",$status,false,0).'</td>
				  <td><input type="text" name="content_'.$a.'" id="content_'.$a.'" /></td>
			  </tr>
		  	  ';
			  
		$a +=1;
		$tmp=$r['titlea'];
		$tmp1=$cate;
		$tmp2 = getCate($r1['service_cateID']);
			}
		}
	}
	echo '
	';
}
 
?>  
</table>
<table style="width:100%;">
  <tr>
    <td align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>
<center style="margin-top:10px;">
	<input type="hidden" name="formID" id="formID" value="service_maintenance" />
    <input type="hidden" name="itemCount" id="itemCount" value="<?php echo $ab; ?>" />
    <input type="button" id="back" name="back" value="Back to list" />
    <input type="submit" id="submit" name="submit" value="Save" />
</center>
</form>
<script language="javascript">
$(function() {
	$('#back').click(function(){
		location.href = "index.php?mod=maintenance&func=formview&id=1";
	});
	$('#Item').click(function(){
		location.href = "index.php?mod=category&func=formview&id=2&code=maintenance";
	});
	 
});
</script>
<?php
function getCate($id){
	$db = new DB;
	$str = "select * from service_cate a inner join service_item b on a.service_cateID=b.service_cateID ";
	$str .=" where b.service_cateID='".$id."'";
	$db->query($str);
	$r1 = $db->fetch_assoc();
	return $r1['parentID'];
}
?>