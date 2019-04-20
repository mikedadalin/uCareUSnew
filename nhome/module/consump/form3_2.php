<?php
//include_once("class/DB3.php");
?>
<script>
$(function() {
	$( "#newrecordform" ).dialog({
		autoOpen: false,
		height: 380,
		width: 800,
		modal: true,
		buttons: {
			"New Item": function() {
				$.ajax({
					url: "class/STKORD.php",
					type: "POST",
					data: { "ORDSEQ": '<?php echo @$_GET['ORDSEQ']; ?>', "STK_NO": $('#STK_NO_txt').val(), "ORDQTY": $('#ORD_QTY').val() },
					success: function(data) {
						var arr = data.split("||");
						$( "#newformtable" ).append( "<tr>" +
							"<td>" + arr[0] + "</td>" + 
							"<td>" + arr[1] + "</td>" + 
							"<td>" + arr[2] + "</td>" +
							"<td>" + arr[3] + "</td>");
						$( "#newrecordform" ).dialog( "close" );
						//alert("New injection record added");
					}
				});
			},
			"Cancel": function() {
				$( "#newrecordform" ).dialog( "close" );
			}
		}
	});
	$( "#add" ).button().click(function() {
		$( "#newrecordform" ).dialog( "open" );
	});
});
</script>
<div id="newrecordform" title="New Item">
	<fieldset>
		<table>
			<tr>
				<td width="120">Category</td>
				<td>
					<script>
					function changekind1() {
						var kind1 = document.getElementById('STK_KIND1').value;
						var kind2 = document.getElementById('STK_KIND2');
						var kind3 = document.getElementById('STK_KIND3');
						kind2.options.length = 0;
						kind3.options.length = 0;
						kind2.disabled=false;
						kind3.disabled=false;
						if (kind1=="1") {
							kind2.options[0] = new Option('','');
							kind2.options[1] = new Option('生活照護類','1');
							kind2.options[2] = new Option('醫務用品類','2');
							kind2.options[3] = new Option('食品類','4');
							kind2.options[4] = new Option('勞務類','5');
						} else if (kind1=="2") {
							kind2.options[0] = new Option('','');
							kind2.options[1] = new Option('醫療儀器類','1');
							kind2.options[2] = new Option('清潔液體類','2');
							kind2.options[3] = new Option('五金用品類','3');
							kind2.options[4] = new Option('紡織布品類','8');
							kind2.options[5] = new Option('文具用品類','9');
						} else if (kind1=="3") {
							kind2.options[0] = new Option('','');
							kind2.options[1] = new Option('代收費用','1');
							kind2.options[2] = new Option('Other','2');
						} else if (kind1=="4") {
							kind2.options[0] = new Option('','');
							kind2.options[1] = new Option('主要食品(米.油)','01');
							kind2.options[2] = new Option('罐頭食品','02');
							kind2.options[3] = new Option('調味醬料','03');
							kind2.options[4] = new Option('粉類','04');
							kind2.options[5] = new Option('豆類.雜糧','05');
							kind2.options[6] = new Option('乾貨1','06');
							kind2.options[7] = new Option('乾貨2','07');
							kind2.options[8] = new Option('其他食材','08');
							kind2.options[9] = new Option('加熱調理食品','09');
							kind2.options[10] = new Option('水果類','10');
							kind2.options[11] = new Option('蔬菜類','11');
							kind2.options[12] = new Option('豬肉類','12');
							kind2.options[13] = new Option('雞肉類','13');
							kind2.options[14] = new Option('其他肉類','14');
							kind2.options[15] = new Option('魚類','15');
							kind2.options[16] = new Option('海產類','16');
							kind2.options[17] = new Option('素食類','17');
							kind2.options[18] = new Option('加工品','18');
							kind2.options[19] = new Option('煤材','80');
							kind2.options[20] = new Option('Discount','99');
						} else if (kind1=="7") {
							kind2.options[0] = new Option('','');
							kind2.options[1] = new Option('綜合','1');
							kind2.options[2] = new Option('定期更換耗材類','2');
							kind2.options[3] = new Option('故障汰換類','4');
						} else {
							kind2.options[0] = new Option('－－沒有次分類－－','');
							kind2.disabled=true;
							kind3.options[0] = new Option('－－沒有次分類－－','');
							kind3.disabled=true;
						}
						searchproduct();
					}
					function changekind2() {
						var kind1 = document.getElementById('STK_KIND1').value;
						var kind2 = document.getElementById('STK_KIND2').value;
						var kind3 = document.getElementById('STK_KIND3');
						kind3.options.length = 0;
						kind3.selectedIndex = 0;
						kind3.disabled=false;
						if (kind1=="1" && kind2=="1") {
							kind3.options[0] = new Option('','');
							kind3.options[1] = new Option('衛生用品類','1');
							kind3.options[2] = new Option('日常用品類','2');
							kind3.options[3] = new Option('(空白)','3');
							kind3.options[4] = new Option('經常類','5');
						} else if (kind1=="1" && kind2=="2") {
							kind3.options[0] = new Option('','');
							kind3.options[1] = new Option('空針類','1');
							kind3.options[2] = new Option('紗布類','2');
							kind3.options[3] = new Option('棉棒類','3');
							kind3.options[4] = new Option('管路類','4');
							kind3.options[5] = new Option('袋、膜類','5');
							kind3.options[6] = new Option('紙膠類','6');
							kind3.options[7] = new Option('繃帶類','7');
							kind3.options[8] = new Option('藥水、液體類','8');
							kind3.options[9] = new Option('罩類','9');
							kind3.options[10] = new Option('Other','10');
						} else if (kind1=="1" && kind2=="4") {
							kind3.options[0] = new Option('','');
							kind3.options[1] = new Option('主要營養品','1');
							kind3.options[2] = new Option('其他營養品','2');
							kind3.options[3] = new Option('Other','3');
							kind3.options[4] = new Option('(空白)','6');
							kind3.options[5] = new Option('經常類','21');
							kind3.options[6] = new Option('餅乾類','31');
							kind3.options[7] = new Option('飲料類','41');
							kind3.options[8] = new Option('雜項','51');
							kind3.options[9] = new Option('麵食類','61');
						} else if (kind1=="1" && kind2=="5") {
							kind3.options[0] = new Option('','');
							kind3.options[1] = new Option('一般車','1');
							kind3.options[2] = new Option('救護車','2');
							kind3.options[3] = new Option('人力','3');
							kind3.options[4] = new Option('月計算型','4');
							kind3.options[5] = new Option('Discount','5');
							kind3.options[6] = new Option('Other','6');
						} else if (kind1=="2" && kind2=="1") {
							kind3.options[0] = new Option('','');
							kind3.options[1] = new Option('儀器耗材','1');
							kind3.options[2] = new Option('綜合','2');
							kind3.options[3] = new Option('綜合','3');
						} else if (kind1=="2" && kind2=="2") {
							kind3.options[0] = new Option('','');
							kind3.options[1] = new Option('頭和身體','1');
							kind3.options[2] = new Option('手部','2');
							kind3.options[3] = new Option('浴室','3');
							kind3.options[4] = new Option('廚房','4');
							kind3.options[5] = new Option('玻璃','5');
							kind3.options[6] = new Option('地板','6');
							kind3.options[7] = new Option('消毒','7');
							kind3.options[8] = new Option('衣物','8');
							kind3.options[9] = new Option('防蟲','9');
							kind3.options[10] = new Option('綜合','10');
						} else if (kind1=="2" && kind2=="3") {
							kind3.options[0] = new Option('','');
							kind3.options[1] = new Option('清潔袋','1');
							kind3.options[2] = new Option('清潔用品','2');
							kind3.options[3] = new Option('食物用品','3');
							kind3.options[4] = new Option('綜合','4');
							kind3.options[5] = new Option('綜合','5');
						} else if (kind1=="2" && kind2=="8") {
							kind3.options[0] = new Option('','');
							kind3.options[1] = new Option('毛.浴巾','1');
							kind3.options[2] = new Option('床用品','2');
							kind3.options[3] = new Option('圍巾','3');
							kind3.options[4] = new Option('輔助類','4');
							kind3.options[5] = new Option('服飾','5');
						} else if (kind1=="4" && kind2=="01") {
							kind3.options[0] = new Option('','');
							kind3.options[1] = new Option('米類','1');
							kind3.options[2] = new Option('麵類','2');
							kind3.options[3] = new Option('油脂類','3');
							kind3.options[4] = new Option('Refreshment','4');
						} else if (kind1=="4" && kind2=="02") {
							kind3.options[0] = new Option('','');
							kind3.options[1] = new Option('蔬果類','1');
							kind3.options[2] = new Option('魚類','2');
							kind3.options[3] = new Option('肉類','3');
							kind3.options[4] = new Option('素食類','4');
							kind3.options[5] = new Option('Other','5');
						} else if (kind1=="4" && kind2=="03") {
							kind3.options[0] = new Option('','');
							kind3.options[1] = new Option('主味','1');
							kind3.options[2] = new Option('鹹味','2');
							kind3.options[3] = new Option('甜味','3');
							kind3.options[4] = new Option('酸味','4');
							kind3.options[5] = new Option('辣味','5');
							kind3.options[6] = new Option('香味','6');
							kind3.options[7] = new Option('綜合','7');
						} else if (kind1=="4" && kind2=="11") {
							kind3.options[0] = new Option('','');
							kind3.options[1] = new Option('葉菜類','1');
							kind3.options[2] = new Option('根莖類','2');
							kind3.options[3] = new Option('花果類','3');
							kind3.options[4] = new Option('菇蕈類','4');
							kind3.options[5] = new Option('芽藻類','5');
							kind3.options[6] = new Option('辛香料','6');
						} else {
							kind3.options[0] = new Option('－－沒有次分類－－','');
							kind3.disabled=true;
						}
						searchproduct();
					}
					$('#search_STK1').click(function () {
						searchproduct();
					})
					function searchproduct() {
						$.ajax({
							url: "class/searchSTK1.php",
							type: "POST",
							data: {"STK_KIND1": $("#STK_KIND1").val(), "STK_KIND2": $("#STK_KIND2").val(), "STK_KIND3": $("#STK_KIND3").val() },
							success: function(data) {
					//alert(data);
					var arr = data.split(";");
					var STK_SELECT = document.getElementById('STK_SELECT');
					STK_SELECT.options.length = 0;
					for (var i = 0; i < (arr.length-1); i++) {
						var productinfo = arr[i];
						var arr1 = productinfo.split("||");
						//STK_NO / STK_NAME / STK_SPK / STK_MODEL / STK_UNIT
						STK_SELECT.options[i] = new Option(arr1[1] + ' ' + arr1[2] + ' ' + arr1[3],arr1[0]);
						console.log(arr1);
					}
				}
			});
					}
					function selectproduct() {
						$.ajax({
							url: "class/searchSTK2.php",
							type: "POST",
							data: {"STK_SELECT": $("#STK_SELECT").val() },
							success: function(data) {
								var arr = data.split("||");
								$('#STK_NO').html(arr[0]);
								$('#STK_NAME').html(arr[1]);
								$('#STK_SPK').html(arr[2]);
								$('#STK_MODEL').html(arr[3]);
								$('#STK_UNIT').html(arr[4]);
								$('#STK_NO_txt').val(arr[0]);
							}
						});
					}
					</script>
					<select name="STK_KIND1" id="STK_KIND1" onchange="changekind1()">
						<option></option>
						<option value="1">有收費類</option>
						<option value="2">無直接收費類</option>
						<option value="3">代收類</option>
						<option value="4">廚房食材.用品</option>
						<option value="5">其他部門代訂貨</option>
						<option value="6">捐款</option>
						<option value="7">財產設備維護</option>
						<option value="8">財產設備</option>
						<option value="9">捐贈物資</option>
					</select>
					<select name="STK_KIND2" id="STK_KIND2" onchange="changekind2()">
						<option></option>
					</select>
					<select name="STK_KIND3" id="STK_KIND3" onchange="searchproduct()">
						<option></option>
					</select>
					<input type="button" id="search_STK1" value="Search" />
				</td>
			</tr>
			<tr>
				<td>Select item</td>
				<td>
					<select name="STK_SELECT" id="STK_SELECT" onchange="selectproduct();">
						<option></option>
					</select>
				</tr>
			</table>
			<hr />
			<table width="100%">
				<tr>
					<td width="120">物品編號</td>
					<td><span id="STK_NO"></span><input type="hidden" name="STK_NO_txt" id="STK_NO_txt" /></td>
				</tr>
				<tr>
					<td>Item name</td>
					<td><span id="STK_NAME"></span></td>
				</tr>
				<tr>
					<td>物品規格</td>
					<td><span id="STK_SPK"></span></td>
				</tr>
				<tr>
					<td>物品型號</td>
					<td><span id="STK_MODEL"></span></td>
				</tr>
				<tr>
					<td>Requested quantity</td>
					<td><input type="text" name="ORD_QTY" id="ORD_QTY" size="3"/> <span id="STK_UNIT"></span></td>
				</tr>
			</table>
		</fieldset>
	</div>
	<?php
	$db = new DB;
	$db->query("SELECT `patientID`,`HospNo`,`Birth` FROM `patient` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."'");
	for ($i=0;$i<$db->num_rows();$i++) {
		$r = $db->fetch_assoc();
		$db1 = new DB;
		$db1->query("SELECT `bed`,`indate` FROM `inpatientinfo` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."'");
		$r1 = $db1->fetch_assoc();
		$name = getPatientName($r['patientID']);
		$birth = formatdate($r['Birth']);
		$indate = formatdate($r1['indate']);
		$HospNo = $r['HospNo'];
		$bedID = $r1['bed'];
		$db2 = new DB;
		$db2->query("SELECT `Qdiag1`, `Qdiag2`, `Qdiag3`, `Qdiag4`, `Qdiag5`, `Qdiag6`, `Qdiag7`, `Qdiag8` FROM `nurseform01` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1");
		$r2 = $db2->fetch_assoc();
		for ($j=1;$j<=8;$j++) { if ($r2['Qdiag'.$j]!=NULL) { $diagMsg .= $r2['Qdiag'.$j].', '; } }
			$diagMsg = substr($diagMsg, 0, strlen($diagMsg)-2);
	}
	?>
	<div class="content-query">
		<table align="left"  width="882" style="font-size:10pt; margin-left:0px;">
			<tr id="backtr"  style="border:none; height:32px;" >
				<td class="title" width="70" style="border-top-left-radius:10px; background-color:#eecb35;">Bed #</td>
				<td width="90" style="border:none;"><?php echo $bedID; ?></td>   
				<td class="title" width="70" style="border:none;">Name</td>
				<td width="90" style="border:none;"><?php echo $name; ?></td>
				<td class="title" width="70" style="border:none;">Care ID#</td>
				<td width="90" style="border:none;"><?php echo $HospNo; ?></td>
				<td class="title" width="70" style="border:none;">DOB</td>
				<td  style="border-top-right-radius:10px;"><?php echo $birth.' ('.checkgender(mysql_escape_string($_GET['pid'])).', '.calcage(str_replace('/','',$birth)).')'; ?></td>
			</tr>
			<tr style="border:none; height:20px;" >
				<td class="title" style="border-bottom-left-radius:10px;">Admission date</td>
				<td style="border:none;"><?php echo $indate; ?></td>
				<td class="title" style="border:none;">Diagnosis</td>
				<td style="border-bottom-right-radius:10px;" colspan="5"><?php echo $diagMsg; ?></td>
			</tr>
		</table>
	</div>
	<br />&nbsp;<h3>Items Requisitions</h3>
	<div align="right">
	</div>
	<form  method="post">
		<table width="100%" id="newformtable">
			<tr class="title">
				<td>ID #</td>
				<td>Name</td>
				<td>Quantity</td>
				<td>Unit</td>
			</tr>
			<?php
			$db3 = new DB;
			$db3->query("SELECT * FROM `arkord` WHERE `ORD_SEQ`='".mysql_escape_string($_GET['ORDSEQ'])."' ORDER BY `ORD_SEQ1` ASC");
			for ($i=0;$i<$db3->num_rows();$i++) {
				$r3 = $db3->fetch_assoc();
				echo '
				<tr>
				<td>'.$r3['STK_NO'].'</td>
				<td>'.$r3['STK_NAME'].'</td>
				<td>'.$r3['ORD_QTY'].'</td>
				<td>'.$r3['STK_UNIT'].'</td>
				</tr>
				'."\n";
			}
			?>
			<tbody>
			</tbody>
		</table>