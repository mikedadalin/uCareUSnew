<?php
if(mysql_escape_string($_GET['ym'])==NULL){
	$ym = date(Ym);
} else{
	$ym = mysql_escape_string($_GET['ym']);
}
$sid = mysql_escape_string($_GET['sid']);
if (@$_GET['area']==NULL) { 
	$areaID = "";
} else { 
	$areaID = @$_GET['area']; 
}

if (isset($_POST['submit'])) {
	for ($i=1; $i <= $_POST['itemCount'];$i++){		
		$dba = new DB;
		$dba->query("SELECT * FROM `careform03` WHERE `service_ym`='".date($ym)."' AND `service_itemID`='".mysql_escape_string($_POST['s_'.$i])."' AND `service_d`='".mysql_escape_string($_POST['d_'.$i])."' AND `areaID`='".mysql_escape_string($_POST['areaID'])."'");
		if (($_POST['Q'.$i.'_1'] + $_POST['Q'.$i.'_2'])!=0) {
			if ($dba->num_rows()>0) {	
				$ra = $dba->fetch_assoc();
				$db = new DB;
				$strQry = "UPDATE `careform03` SET ";
				$strQry .=" service_d = '".mysql_escape_string($_POST['d_'.$i])."',";
				$strQry .=" status_1 = '".mysql_escape_string($_POST['Q'.$i.'_1'])."',";	
				$strQry .=" status_2 ='".mysql_escape_string($_POST['Q'.$i.'_2'])."',";	
				$strQry .=" content = '".mysql_escape_string($_POST['content_'.$i])."',";
				$strQry .="`uDate`='".date("Y-m-d H:i:s")."'";
				$strQry .=" WHERE service_maintenanceID=".$ra['service_maintenanceID'];
				$db->query($strQry);
			}else{
				$db = new DB;
				$strQry ="INSERT INTO `careform03` (`service_itemID`,`service_ym`,`service_d`,`status_1`,`status_2`,`content`,`filler`,`areaID`) VALUES (";
					$strQry .=" '".mysql_escape_string($_POST['s_'.$i])."',";
					$strQry .=" '".mysql_escape_string(date(Ym))."',";
					$strQry .=" '".mysql_escape_string($_POST['d_'.$i])."',";
					$strQry .=" '".mysql_escape_string($_POST['Q'.$i.'_1'])."',";	
					$strQry .=" '".mysql_escape_string($_POST['Q'.$i.'_2'])."',";	
					$strQry .=" '".mysql_escape_string($_POST['content_'.$i])."',";
					$strQry .=" '".$_SESSION['ncareID_lwj']."',"; 
					$strQry .=" '".mysql_escape_string($_POST['areaID'])."'"; 
					$strQry .="  )";		
$db->query($strQry);
}
}
}
echo "<script>window.location.href='index.php?mod=carework&func=formview&id=3_2&ym=".$ym."&area=".$_POST['areaID']."'</script>";
}

?>
<div class="moduleNoTab">
	<form  method="post" id="careform03">
		<h3><?php echo substr(date($ym), 4, 2)?> month-Routine service / maintenance record</h3>
		<div align="left">
			<?php
			echo '<a style="color:#d1ad0a; font-size:18px; font-weight:bold;">&nbsp;Floor area: </a><select id="areaID" name="areaID" class="validate[required]">';
			echo '  <option></option>';
			$db3 = new DB;
			$db3->query("SELECT * FROM `areainfo` ORDER BY `areaID` ASC");
			for ($i3=0;$i3<$db3->num_rows();$i3++) {
				$r3 = $db3->fetch_assoc();
				echo '  <option value="'.$r3['areaID'].'"';
				if ($areaID==$r3['areaID']) { echo ' selected'; }
				echo '>'.$r3['areaName'].'</option>';
				$arrAreaName[$r3['areaID']] = $r3['areaName'];
			}
			echo '</select>';
			?>

		</div>
		<table width="100%" border="0" cellpadding="7">	
			<tr class="title">
				<td>Item(s)</td>
				<td>Maintenance Items</td>
				<td>Date</td>
				<td>Repair/Maintenance Status</td>
				<td>Repair Status Description</td>
			</tr>
			<?php
			$a = 1;
			$db = new DB;
			$str =" SELECT a.title titlea, a.service_cateID aID, c.title titlec, c.service_cateID cID FROM  `service_cate` a ";
			$str .=" LEFT JOIN  `service_cate` c ON c.`parentID` = a.`service_cateID` ";
			$str .=" WHERE 1 and a.typeCode='".mysql_escape_string($_GET['mod'])."' AND a.`layer` =1 AND a.`isHidden_1` =1 AND a.title like '醫療器材%'";
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
					if($db1->num_rows()>0){			
						for ($i1=0;$i1<$db1->num_rows();$i1++) {
							$r1 = $db1->fetch_assoc();
							$db2 = new DB;
							$db2->query("SELECT * FROM `careform03` WHERE `service_ym`= '".$ym."' AND `service_d`='".$sid."' AND `service_itemID`='".$r1['service_itemID']."' AND `areaID` ='".$areaID."' ");
							$status = "";
							$content = "";
							$service_d = "";
							if ($db2->num_rows()>0) {
								$r2 = $db2->fetch_assoc();	
								foreach($r2 as $k=>$v){
									if($k!="service_d"){
										$info = explode("_",$k);
										if(count($info)==2){
											if ($v==1) {
												${$info[0]} .= $info[1].';';
											} 
										}  else {
											${$k} = $v;
										}
									}else{
										${$k} = $v;
									}
								}
							}
							echo '
							<tr>';
							if($tmp1!=$cate){
								echo '<td class="title_s" style="text-transform: capitalize;" rowspan="'.$db1->num_rows().'">'.str_replace("\n","<br>",$r['titlec']).'</td>';
							}						  	  
							echo'
							<td>'.$r1['title'].'<input name="s_'.$a.'" type="hidden" value="'.$r1['service_itemID'].'" ></td>
							<td align="center"><input name="d_'.$a.'" type="text" size="2" maxlength="2" id="d_'.$a.'" value="'.$service_d.'"/></td>
							<td align="center">'.draw_option("Q".$a,"Good;Needs repair","xm","single",$status,false,0).'</td>
							<td><input type="text" name="content_'.$a.'" id="content_'.$a.'" value="'.$content.'" /></td>
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
		<table>
			<tr>
				<td align="right">Filled By : <?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
			</tr>
		</table>
		<center><div style="margin:25px 0 10px 0;">
			<input type="hidden" name="formID" id="formID" value="careform03" />
			<input type="hidden" name="itemCount" id="itemCount" value="<?php echo $ab; ?>" />
			<?php if($sid != ""){?>
			<input type="button" id="back" name="back" value="Back to summary list" />
			<?php } else{?>
			<input type="button" id="back1" name="back1" value="Back to list" />
			<?php }?>
			<input type="submit" id="submit" name="submit" value="Save" />
		</div></center>
	</form>
</div>
<script language="javascript">
$(function() {
	$('#back').click(function(){
		location.href = 'index.php?mod=carework&func=formview&id=3_2&ym=<?php echo $ym;?>&area=<?php echo $areaID; ?>';
	});
	$('#back1').click(function(){
		location.href = 'index.php?mod=carework&func=formview&id=3';
	});
	$('#Item').click(function(){
		location.href = "index.php?mod=category&func=formview&id=2&code=carework";
	});
	$("#careform03").validationEngine(); 
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

