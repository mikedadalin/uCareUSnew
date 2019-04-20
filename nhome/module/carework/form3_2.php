<?php
$ym = mysql_escape_string($_GET['ym']);
if (@$_GET['area']==NULL) { 
	$dbArea = new DB;
	$dbArea->query("SELECT * FROM `areainfo` ORDER BY `areaID` ASC Limit 0,1");
	$rArea = $dbArea->fetch_assoc();
	$areaID = $rArea['areaID']; 
} else { 
	$areaID = @$_GET['area']; 
}
?>
<div class="moduleNoTab">
	<form  method="post">
		<h3><?php echo substr(date($ym), 4, 2)?> month-Routine service / maintenance record</h3>
		<div align="left">
			<?php
			echo '<a style="color:#d1ad0a; font-size:18px; font-weight:bold;">&nbsp;Select floor： </a><select id="areaID" name="areaID">';
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
		<table border="0" cellpadding="5">	
			<tr class="title">
				<td>Item(s)</td>
				<td>Maintenance Items</td>
				<?php 
				for ($i3=0;$i3<5;$i3++){
					?>
					<td>Date</td>
					<td>Repair Status</td>
					<?php }?>
					<td>Repair Status Description</td>
				</tr>
				<?php
				$a = 1;
				$db = new DB;
				$str =" SELECT a.title titlea, a.service_cateID aID, c.title titlec, c.service_cateID cID FROM  `service_cate` a ";
				$str .=" LEFT JOIN `service_cate` c ON c.`parentID` = a.`service_cateID` ";
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
						if($db->num_rows()>0){

							for ($i1=0;$i1<$db1->num_rows();$i1++) {
								$r1 = $db1->fetch_assoc();				
								$content="";
								echo '
								<tr>';
								if($tmp1!=$cate){
									echo '<td class="title_s" style="text-transform: capitalize;" rowspan="'.$db1->num_rows().'">'.str_replace("\n","<br>",$r['titlec']).'</td>';
								}			  
								echo'
								<td>'.$r1['title'].'<input name="s_'.$a.'" type="hidden" value="'.$r1['service_itemID'].'" ></td>';
								$db2 = new DB;
								$db2->query("SELECT * FROM `careform03` WHERE `service_ym`='".$ym."' AND `service_itemID`='".$r1['service_itemID']."' AND `areaID` = '".$areaID."' ORDER BY `service_d` DESC LIMIT 0,5");
								for($i2=0;$i2<5;$i2++){					  
									$r2 = $db2->fetch_assoc();	
									$content .= ($r2['content']==""?"":$r2['content'].";");			  				  
									echo '<td align="center"><a href="index.php?mod=carework&func=formview&id=3_1&ym='.$r2['service_ym'].'&sid='.$r2['service_d'].'&area='.$r2['areaID'].'" title="Click on to modify">'.($r2['service_d']==""?"":"<img src='Images/edit_icon.png' width='16' class='printcol'>").$r2['service_d'].'</a></td>
									<td align="center">'.($r2['status_1']==0 && $r2['status_2']==0?"":($r2['status_1']==1?"Good":"Needs repair")).'</td>';
								}
								echo '<td>'.$content.'</td>
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
				<tr class="noShowCol">
					<td class="title_s" align="center" height="40" colspan="2">Comment</td>
					<?php 
					for ($i3=0;$i3<5;$i3++){
						?>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<?php }?>
						<td>&nbsp;</td>
					</tr>

				</table>
				<center><div style="margin:25px 0 10px 0;">
					<input type="hidden" name="formID" id="formID" value="careform03" />
					<input type="hidden" name="itemCount" id="itemCount" value="<?php echo $ab; ?>" />
					<input type="button" id="back" name="back" value="Back to routine service/maintenance record" />
				</div></center>
			</form>
		</div>
		<script language="javascript">
		$(function() {
			$('#back').click(function(){
				location.href = "index.php?mod=carework&func=formview&id=3";
			});
			$('#Add').click(function(){
				location.href = "index.php?mod=carework&func=formview&id=3_1";
			});
			$("#areaID").change(function(){
				location.href = "index.php?mod=carework&func=formview&id=3_2&ym=<?php echo $ym; ?>&area=" + $("#areaID").val();
			})
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

