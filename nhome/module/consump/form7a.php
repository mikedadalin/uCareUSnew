<?php
if (isset($_POST['saveorder'])) {
	$db0 = new DB2;
	$db0->query("SELECT * FROM `itemlist` WHERE `ItemNo`='".mysql_escape_string($_POST['ItemNo'])."'");
	$r0 = $db0->fetch_assoc();
	$ItemSinglePrice = round($r0['ItemLargeQty']*$r0['ItemPrice']);
	$ItemTotalPrice = round($ItemSinglePrice * $_POST['QTY']);
	$db1 = new DB2;
	$db1->query("INSERT INTO `itemorder` VALUES ('', '".$_SESSION['nOrgID_lwj']."', '".date('Y/m/d')."', '".mysql_escape_string($_POST['ItemNo'])."', '".$r0['SupplierItemNo']."', '".$r0['ItemBrand'].$r0['ItemName']."', '".mysql_escape_string($_POST['QTY'])."', '".$ItemSinglePrice."', '".$ItemTotalPrice."', '".$_SESSION['ncareID_lwj']."', '".$r0['SupplierID']."', '0', '', '');");
	$to = "kenji@u-ark.com,andy@u-ark.com"; //收件者 
	$db3 = new DB2;
	$db3->query("SELECT * FROM `userinfo` WHERE `userID`='".$r0['SupplierID']."'");
	$r3 = $db3->fetch_assoc();
	if ($r3['email']!="") { $to .= ','.$r3['email']; }
	$subject = "新訂單"; //信件標題 
	$db2 = new DB2;
	$db2->query("SELECT * FROM `orginfo` WHERE `OrgID`='".$_SESSION['nOrgID_lwj']."'");
	$r2 = $db2->fetch_assoc();
	$msg = "
	機構：".$_SESSION['nOrgName_lwj']."(".$_SESSION['nOrgID_lwj'].")
	地址：".$r2['Address']."
	電話：".$r2['Phone']."
	聯絡人：".$r2['ContactPerson']."
	統一編號：".$r2['InvoiceNo']."
	------------------------------------------------------------
	訂購時間：".date('Y/m/d H:i:s')."
	產品名稱：".$r0['ItemName']."
	數量：".$_POST['QTY'].$r0['ItemLargeUnit']."
	單價：$".$ItemSinglePrice."
	Total :$".$ItemTotalPrice."
	訂購人員：".checkusername($_SESSION['ncareID_lwj'])."";//信件內容 
	$headers = "From: service@u-ark.com"; //寄件者
	mail($to, iconv('utf-8','big5',$subject), iconv('utf-8','big5',$msg), $headers);
	
	echo "<script>window.location.href='index.php?mod=consump&func=formview&id=7'</script>\n";
}
?>
<script>
function changeitemlist(index) {
	var ItemNoList = document.getElementById('ItemNo');
	ItemNoList.options.length = 0;
	ItemNoList.options[0] = new Option('','');
	if (index==1) {
		<?php
		$db0a = new DB2;
		$db0a->query("SELECT * FROM `itemlist` WHERE `ItemNo` LIKE '01%' AND `OrgID`='".$_SESSION['nOrgID_lwj']."' ORDER BY `ItemBrand` DESC, `ItemName` DESC");
		for ($i0=0;$i0<$db0a->num_rows();$i0++) {
			$r0a = $db0a->fetch_assoc();
			echo "ItemNoList.options[".($i0+1)."] = new Option('".$r0a['ItemBrand'].$r0a['ItemName']."','".$r0a['ItemNo']."');\n";
		}
		?>
	} else if (index==2) {
		<?php
		$db0a = new DB2;
		$db0a->query("SELECT * FROM `itemlist` WHERE `ItemNo` LIKE '02%' AND `OrgID`='".$_SESSION['nOrgID_lwj']."' ORDER BY `ItemBrand` DESC, `ItemName` DESC");
		for ($i0=0;$i0<$db0a->num_rows();$i0++) {
			$r0a = $db0a->fetch_assoc();
			echo "ItemNoList.options[".($i0+1)."] = new Option('".$r0a['ItemBrand'].$r0a['ItemName']."','".$r0a['ItemNo']."');\n";
		}
		?>
	} else if (index==3) {
		<?php
		$db0a = new DB2;
		$db0a->query("SELECT * FROM `itemlist` WHERE `ItemNo` LIKE '03%' AND `OrgID`='".$_SESSION['nOrgID_lwj']."' ORDER BY `ItemBrand` DESC, `ItemName` DESC");
		for ($i0=0;$i0<$db0a->num_rows();$i0++) {
			$r0a = $db0a->fetch_assoc();
			echo "ItemNoList.options[".($i0+1)."] = new Option('".$r0a['ItemBrand'].$r0a['ItemName']."','".$r0a['ItemNo']."');\n";
		}
		?>
	} else if (index==4) {
		<?php
		$db0a = new DB2;
		$db0a->query("SELECT * FROM `itemlist` WHERE `ItemNo` LIKE '04%' AND `OrgID`='".$_SESSION['nOrgID_lwj']."' ORDER BY `ItemBrand` DESC, `ItemName` DESC");
		for ($i0=0;$i0<$db0a->num_rows();$i0++) {
			$r0a = $db0a->fetch_assoc();
			echo "ItemNoList.options[".($i0+1)."] = new Option('".$r0a['ItemBrand'].$r0a['ItemName']."','".$r0a['ItemNo']."');\n";
		}
		?>
	} else if (index==5) {
		<?php
		$db0a = new DB2;
		$db0a->query("SELECT * FROM `itemlist` WHERE `ItemNo` LIKE '05%' AND `OrgID`='".$_SESSION['nOrgID_lwj']."' ORDER BY `ItemBrand` DESC, `ItemName` DESC");
		for ($i0=0;$i0<$db0a->num_rows();$i0++) {
			$r0a = $db0a->fetch_assoc();
			echo "ItemNoList.options[".($i0+1)."] = new Option('".$r0a['ItemBrand'].$r0a['ItemName']."','".$r0a['ItemNo']."');\n";
		}
		?>
	}
}
function selectproduct() {
	$.ajax({
		url: "class/searchUARKitem.php",
		type: "POST",
		data: {"ItemNo": $("#ItemNo").val() },
		success: function(data) {
			var arr = data.split("||");
			$('#ItemName').html(arr[0]);
			$('#ItemSpec').html(arr[1]);
			if (arr[2]=="") {
				$('#ItemUnit').html(arr[3]+arr[4]);
			} else {
				$('#ItemUnit').html('1'+arr[2]+arr[3]+arr[4]);
			}
			$('#ItemLargeUnit').html(arr[2]);
			if (arr[5]!="") {
				var price = parseFloat(arr[5]);
				var minqty = parseInt(arr[3]);
				var singleprice = price*minqty;
				singleprice = Math.round(singleprice);
				$('#ItemPrice').html('$'+singleprice);
			} else {
				$('#ItemPrice').html('來電洽詢');
			}
			$('#ItemBrand').html(arr[6]);
			$('#ItemPic').attr('src', '../Images/itemimg/'+parseInt($("#ItemNo").val())+'.jpg').show();
			$("#ItemPic").error(function(){
				$(this).hide();
			});
		}
	});
}
function calctotalprice(qty) {
	var inputqty = parseInt(qty);
	var singleprice = document.getElementById('ItemPrice').innerHTML;
	if (singleprice!="來電洽詢" && singleprice!="") {
		singleprice = singleprice.replace('$','');
		singleprice = parseInt(singleprice);
		var totalprice = inputqty*singleprice;
		document.getElementById('ItemTotalPrice').value = '$'+totalprice;
	}
}
</script>
<center>
	<h3>New order</h3>
	<form action="index.php?mod=consump&func=formview&id=7a" method="post">
		<table width="100%" cellpadding="10">
			<tr>
				<td class="title" width="140">Select Product</td>
				<td colspan="2">
					<select onchange="changeitemlist(this.selectedIndex);">
						<option></option>
						<?php
						$db1 = new DB2;
						$db1->query("SELECT * FROM `itemcate` ORDER BY `cateID` ASC");
						for ($i=0;$i<$db1->num_rows();$i++) {
							$r1 = $db1->fetch_assoc();
							echo '<option value="'.$r1['cateID'].'">'.$r1['cateName'].'</option>';
						}
						?>
					</select>&nbsp;
					<select name="ItemNo" id="ItemNo" onchange="selectproduct();"></select>
				</td>
			</tr>
			<tr>
				<td class="title" width="140">Brand</td>
				<td width="*"><span id="ItemBrand"></span></td>
				<td width="300" rowspan="7" align="center"><img id="ItemPic" border="0" height="200"></td>
			</tr>
			<tr>
				<td class="title">Product Name</td>
				<td colspan="2"><span id="ItemName"></span></td>
			</tr>
			<tr>
				<td class="title">Product Spec.</td>
				<td colspan="2"><span id="ItemSpec"></span></td>
			</tr>
			<tr>
				<td class="title">Package Size</td>
				<td colspan="2"><span id="ItemUnit"></span></td>
			</tr>
			<tr>
				<td class="title">Unit Price</td>
				<td colspan="2"><span id="ItemPrice"></span> (Tax included)</td>
			</tr>
			<tr>
				<td class="title">Quantity</td>
				<td colspan="2"><input type="text" name="QTY" id="QTY" size="3" onkeyup="calctotalprice(this.value);"/> <span id="ItemLargeUnit"></span></td>
			</tr>
			<tr>
				<td class="title">Total Price</td>
				<td colspan="2"><input type="text" name="ItemTotalPrice" id="ItemTotalPrice" size="10" /> (Tax included)</td>
			</tr>
			<?php
			$db = new DB2;
			$db->query("SELECT `demoSystem` FROM `system_setting` WHERE `OrgID`='".$_SESSION['nOrgID_lwj']."'");
			$r = $db->fetch_assoc();
			if ($r['demoSystem']==0) {
				echo '
				<tr>
				<td colspan="3" style="padding-top:15px;"><center><input type="submit" name="saveorder" value="Submit Order" /></center></td>
				</tr>';
			} elseif ($r['demoSystem']==1) {
				echo '
				<tr>
				<td colspan="3"><center>此為測試用帳號，恕不提供訂購耗材功能</center></td>
				</tr>';
			}
			?>
		</table>
	</form>
</center>