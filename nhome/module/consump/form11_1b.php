<h3>Applied item management</h3>
<div class="content-query">
<form>
<table class="printcol">
  <tr class="title">
    <td colspan="2">Filter condition</td>
  </tr>
  <tr>
    <td class="title" width="160">Property ID#</td>
    <td align="left" style="background:#eeeeee;"><input type="text" name="ApplyItemID" id="ApplyItemID" size="30" value="<?php echo $_GET['ApplyItemID']!=""?$_GET['ApplyItemID']:""; ?>" /> <input type="button" value="Search" onclick="window.location.href='index.php?mod=consump&func=formview&id=11&view=1&query=1&ApplyItemID='+document.getElementById('ApplyItemID').value;" /></td>
  </tr>
  <tr>
    <td class="title" width="160">Category</td>
    <td align="left" style="background:#eeeeee;">
    <select id="KIND1" onchange="window.location.href='index.php?mod=consump&func=formview&id=11&view=1&query=2&KIND1='+this.options[this.options.selectedIndex].value;">
      <option></option>
      <?php
	  $db1a = new DB;
	  $db1a->query("SELECT * FROM `applyitemcate` ORDER BY `ID` ASC");
	  for ($i1a=0;$i1a<$db1a->num_rows();$i1a++) {
		  $r1a = $db1a->fetch_assoc();
		  echo '<option value="'.$r1a['ID'].'"'.($r1a['ID']==$_GET['KIND1']?' selected':'').'>'.$r1a['Name'].'</option>'."\n";
	  }
	  ?>
    </select>
    </td>
  </tr>
  <tr style="background:#eeeeee;">
    <td align="center" colspan="2">
    <input type="button" value="Clear search results" onclick="window.location.href='index.php?mod=consump&func=formview&id=11&view=1';" /></td>
  </tr>
</table>
</form>
</div>
<div align="right"><form><input type="button" onclick="window.location.href='index.php?mod=consump&func=formview&id=11_4'" value="新增申請品項" /></form></div>
<table width="100%">
  <tr class="title">
    <td class="printcol">Edit</td>
    <td>ID #</td>
    <td>Delivery corresponding item ID#</td>
    <td>Name</td>
    <td>Unit</td>
    <td>Enable</td>
  </tr>
<?php

$maxNo = 30;

if ($_GET['pn']=="") {
	$pn = 1;
} else {
	$pn = $_GET['pn'];
}

$ps = ($pn-1)*$maxNo;

if ($_GET['query']=="" && $_GET['view']==1) {
	$sql_1= "SELECT * FROM `arkstockforapply` ORDER BY `ApplyItemID` ASC";
} elseif ($_GET['query']=="1" && $_GET['view']==1) {
	//搜尋編號
	$sql_1= "SELECT * FROM `arkstockforapply` WHERE `ApplyItemID`='".mysql_escape_string($_GET['ApplyItemID'])."' ORDER BY `ApplyItemID` ASC";
} elseif ($_GET['query']=="2" && $_GET['view']==1) {
	//搜尋分類
	$sql_1= "SELECT * FROM `arkstockforapply` WHERE ";
	if ($_GET['KIND1']!="") {
		$sql_1.= "`KIND_NO`='".mysql_escape_string($_GET['KIND1'])."'";
	}
} elseif ($_GET['query']=="3" && $_GET['view']==1) {
	//顯示所有物品
	$sql_1= "SELECT * FROM `arkstockforapply` ORDER BY `ApplyItemID` ASC";
}

if ($sql_1=="") { $sql_1= "SELECT * FROM `arkstockforapply` ORDER BY `ApplyItemID` ASC"; }
$db0 = new DB;
$db0->query($sql_1);
$totalRow = $db0->num_rows();
$totalPages = ceil($totalRow/$maxNo);

$sql_1.= " LIMIT ".$ps.", ".$maxNo;
$db = new DB;
$db->query($sql_1);
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	$db1 = new DB;
	$db1->query("SELECT `STK_NO` FROM `arkstock` WHERE `STK_NO`='".$r['STK_NO']."' AND `STOP_ID`='N'");
	$r1 = $db1->fetch_assoc();
	$img = ($r['STOP_ID']==1?"star_empty":"star_full");
	echo '
  <tr style="line-height:24px;">
    <td align="center" class="printcol"><a href="index.php?mod=consump&func=formview&id=11_2&ApplyItemID='.$r['ApplyItemID'].'"><img src="Images/edit_icon.png" width="18"></a></td>
    <td>'.$r['ApplyItemID'].'</td>
    <td>'.$r1['STK_NO'].'</td>
    <td>'.$r['STK_NAME'].'</td>
    <td>'.$r['STK_UNIT'].'</td>
	<td align="center"><img src="Images/'.$img.'.png" width="24" title="Set to frequent usage" id="item_'.$r['ApplyItemID'].'"></td>
  </tr>'."\n";
}
?>
  <tr class="title page printcol">
    <td colspan="8"><?php echo changePageManager($totalRow, $totalPages, $pn, $maxNo, "query=".$_GET['query']."&KIND1=".$_GET['KIND1']."&KIND2=".$_GET['KIND2'], "index.php?mod=consump&func=formview&id=11&view=1"); ?></td>
  </tr>
</table>
<script>
$(function() {
	$("img[id^='item_']").click(function(){
		var id = $(this).attr("id").split('_');
		var idname = $(this).attr("id");
		//id[1] = ApplyItemID
		$.ajax({
			url: "class/setEnableStar.php",
			type: "POST",
			data: {"table": 'arkstockforapply', "autoID":'ApplyItemID', "colID":'STOP_ID', "ID": id[1], "type": 2 },
			success: function(data) {
				$('#'+idname).attr("src", "Images/"+data+".png");
			}
		});
  });
});
</script>