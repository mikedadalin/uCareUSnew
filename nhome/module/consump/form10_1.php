<?php
//include_once("class/DB3.php");
?>
<script>
$(function() {
    $( "#newrecordform" ).dialog({
		autoOpen: false,
		height: 330,
		width: 550,
		modal: true,
		buttons: {
			"New Item": function() {
				$.ajax({
					url: "class/STKORD.php",
					type: "POST",
					data: { "ORDSEQ": '<?php echo @$_GET['ORDSEQ']; ?>', "STK_NO": $('#STK_NO_txt').val(), "ORDQTY": $('#ORD_QTY').val() },
					success: function(data) {
						var arr = data.split("||");
						window.location.reload();
					}
				});
			},
			"Cancel": function() {
				$( "#newrecordform" ).dialog( "close" );
			}
		}
	});
});
</script>
<div id="newrecordform" title="New Item" class="dialog-form">
  <fieldset>
	<table>
        <script>
		function changecate() {
			$.ajax({
				url: "class/searchSTK1a.php",
				type: "POST",
				data: {"KIND": $("#STK_KIND2").val(), "AREA": 1 },
				success: function(data) {
					document.getElementById('STK_SELECT').options.length = 0;
					var arr = data.split(";");
					document.getElementById('STK_SELECT').options[0] = new Option('','');
					for (var i = 0; i < (arr.length-1); i++) {
						var productinfo = arr[i];
						var arr1 = productinfo.split("||");
						document.getElementById('STK_SELECT').options[(i+1)] = new Option(arr1[1],arr1[0]);
					}
				}
			});
		}
		function selectproduct() {
			$.ajax({
				url: "class/searchSTK2.php",
				type: "POST",
				data: {"STK_SELECT": $("#STK_SELECT").val(), "AREA": 1 },
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
        <!--<select name="STK_KIND1" id="STK_KIND1" onchange="changekind1()">
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
      </tr>-->
      <tr>
        <td class="title">Select item</td>
        <td>
        <select name="STK_KIND2" id="STK_KIND2" onchange="changecate()">
          <option></option>
          <?php
		  $db4 = new DB;
		  $db4->query("SELECT * FROM `applyitemcate` ORDER BY `ID` ASC");
		  for ($i4=0;$i4<$db4->num_rows();$i4++) {
			  $r4 = $db4->fetch_assoc();
			  echo '<option value="'.$r4['ID'].'">'.$r4['Name'].'</option>'."\n";
		  }
		  ?>
        </select><br />
        <select name="STK_SELECT" id="STK_SELECT" onchange="selectproduct();">
          <option></option>
        </select>
	  </tr>
	</table>
    <hr />
    <table>
      <!--<tr>
        <td width="120">物品編號</td>
        <td><span id="STK_NO"></span></td>
      </tr>-->
      <tr>
        <td class="title">Item name</td>
        <td><span id="STK_NAME"></span><input type="hidden" name="STK_NO_txt" id="STK_NO_txt" /></td>
      </tr>
      <!--<tr>
        <td>物品規格</td>
        <td><span id="STK_SPK"></span></td>
      </tr>-->
      <!--<tr>
        <td>物品型號</td>
        <td><span id="STK_MODEL"></span></td>
      </tr>-->
      <tr>
        <td class="title">Requested quantity</td>
        <td><input type="text" name="ORD_QTY" id="ORD_QTY" size="3"/> <span id="STK_UNIT"></span></td>
      </tr>
    </table>
  </fieldset>
</div>
<h3>Items Requisitions</h3>
<div align="left" style="float:left;">
	<form>
		<input type="button" value="Back to list" onclick="window.location.href='index.php?mod=consump&func=formview&id=10&aID=<?php echo @$_GET['aID']; ?>'">
	</form>
</div>
<form  method="post" align="left">
	<input type="button" value="New Item" id="add" onclick="openVerificationForm('#newrecordform');"/>
</form>
<table width="100%" id="newformtable">
  <tr class="title">
    <td>ID #</td>
    <td>Name</td>
    <td>Quantity</td>
    <td>Unit</td>
    <td>Delete</td>
  </tr>
  <?php
  $db3 = new DB;
  $db3->query("SELECT * FROM `arkord` WHERE `ORD_SEQ`='".mysql_escape_string($_GET['ORDSEQ'])."' ORDER BY `ORD_SEQ1` ASC");
  for ($i=0;$i<$db3->num_rows();$i++) {
	  $r3 = $db3->fetch_assoc();
	  echo '
	  <tr>
		<td align="center">'.$r3['STK_NO'].'</td>
        <td align="left">'.$r3['STK_NAME'].'</td>
		<td align="center"><input type="text" name="item_'.@$_GET['ORDSEQ'].'_'.$r3['ORD_SEQ1'].'" id="item_'.@$_GET['ORDSEQ'].'_'.$r3['ORD_SEQ1'].'" size="2" value="'.$r3['ORD_QTY'].'" /><input type="button" value="修改數量" onclick="modifyquat(\'item_'.@$_GET['ORDSEQ'].'_'.$r3['ORD_SEQ1'].'\');"></td>
		<td align="center">'.$r3['STK_UNIT'].'</td>
		<td align="center"><input type="button" value="刪除此筆資料"  onclick="if (confirm(\'確定刪除？\')) { deleteORDitem(\'item_'.@$_GET['ORDSEQ'].'_'.$r3['ORD_SEQ1'].'\'); }"></td>
	  </tr>
	  '."\n";
  }
  ?>
  <tbody>
  </tbody>
</table>
<script>
function modifyquat (id) {
	//var newquat = document.getElementById(id).value;
	$.ajax({
		url: "class/modifyquat.php",
		type: "POST",
		data: { "ORDID": id, "QTY": $('#'+id).val() },
		success: function(data) {
			if (data=="OK") {
				alert('Quantity modified !');
			} else {
				alert('Can not be modified');
			}
		}
	});
}

function deleteORDitem (id) {
	//var newquat = document.getElementById(id).value;
	$.ajax({
		url: "class/deleteORDitem.php",
		type: "POST",
		data: { "ORDID": id },
		success: function(data) {
			if (data=="OK") {
				alert('Successfully deleted!');
				window.location.reload();
			} else {
				alert('Unable to delete');
			}
		}
	});
}
</script>