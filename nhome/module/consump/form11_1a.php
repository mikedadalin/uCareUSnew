<h3>Item management</h3>
<div class="content-query">
<form>
<table class="printcol">
  <tr class="title">
    <td colspan="2">Filter condition</td>
  </tr>
  <tr>
    <td class="title" width="160">Property ID#</td>
    <td align="left" style="background:#eeeeee;"><input type="text" name="STKNO" id="STKNO" size="30" value="<?php echo $_GET['STKNO']!=""?$_GET['STKNO']:""; ?>" /> <input type="button" value="Search" onclick="window.location.href='index.php?mod=consump&func=formview&id=11&view=0&query=1&STKNO='+document.getElementById('STKNO').value;" /></td>
  </tr>
  <tr>
    <td class="title" width="160">Category</td>
    <td align="left" style="background:#eeeeee;">
    <select id="KIND1" onchange="window.location.href='index.php?mod=consump&func=formview&id=11&query=2&KIND1='+this.options[this.options.selectedIndex].value;">
      <option></option>
      <?php
	  if ($_GET['KIND1']!="") {
		  $sql1a = "SELECT * FROM `itemkind1` ORDER BY `ID` ASC";
	  } else {
		  $sql1a = "SELECT * FROM `itemkind1` ORDER BY `ID` ASC";
	  }
	  $db1a = new DB;
	  $db1a->query($sql1a);
	  for ($i1a=0;$i1a<$db1a->num_rows();$i1a++) {
		  $r1a = $db1a->fetch_assoc();
		  echo '<option value="'.$r1a['ID'].'"'.($r1a['ID']==$_GET['KIND1']?' selected':'').'>'.$r1a['Name'].'</option>'."\n";
	  }
	  ?>
    </select>&nbsp;
    <?php if ($_GET['KIND1']!="") { ?>
    <select id="KIND2" onchange="window.location.href='index.php?mod=consump&func=formview&id=11&query=2&KIND1=<?php echo $_GET['KIND1']; ?>&KIND2='+this.options[this.options.selectedIndex].value;">
      <option></option>
      <?php
	  if ($_GET['KIND1']!="") {
		  $sql1b = "SELECT * FROM `itemkind2` WHERE `kind1`='".mysql_escape_string($_GET['KIND1'])."' ORDER BY `ID` ASC";
	  } else {
		  $sql1b = "SELECT * FROM `itemkind2` WHERE `kind1`='1' ORDER BY `ID` ASC";
	  }
	  $db1b = new DB;
	  $db1b->query($sql1b);
	  for ($i1b=0;$i1b<$db1b->num_rows();$i1b++) {
		  $r1b = $db1b->fetch_assoc();
		  echo '<option value="'.$r1b['ID'].'"'.($r1b['ID']==$_GET['KIND2']?' selected':'').'>'.$r1b['Name'].'</option>'."\n";
	  }
	  ?>
    </select>
    <?php } ?>
    <select name="KIND3" id="KIND3" onchange="window.location.href='index.php?mod=consump&func=formview&id=11&query=2&KIND1=<?php echo $_GET['KIND1']; ?>&KIND2=<?php echo $_GET['KIND2']; ?>&KIND3='+this.options[this.options.selectedIndex].value;">
      <option></option>
      <?php
	  if ($_GET['KIND1']!="" && $_GET['KIND2']!="") {
		  $sql1c = "SELECT * FROM `itemkind3` WHERE `kind1`='".mysql_escape_string($_GET['KIND1'])."' AND `kind2`='".mysql_escape_string($_GET['KIND2'])."' ORDER BY `ID` ASC";
	  } else {
		  $sql1c = "SELECT * FROM `itemkind3` WHERE `kind1`='1' AND `kind2`='1' ORDER BY `ID` ASC";
	  }
	  $db1c = new DB;
	  $db1c->query($sql1c);
	  for ($i1c=0;$i1c<$db1c->num_rows();$i1c++) {
		  $r1c = $db1c->fetch_assoc();
		  echo '<option value="'.$r1c['ID'].'"'.($r1c['ID']==$_GET['KIND3']?' selected':'').'>'.$r1c['Name'].'</option>'."\n";
	  }
	  ?>
    </select>
    </td>
  </tr>
  <tr style="background:#eeeeee;">
    <td align="center" colspan="2">
    <?php
	if ($_GET['stop']!="y") {
	?>
    <input type="button" value="Display all items" onclick="window.location.href='index.php?mod=consump&func=formview&id=11&stop=y';" />
    <?php
	} else {
	?>
    <input type="button" value="Display only item still applied" onclick="window.location.href='index.php?mod=consump&func=formview&id=11';" />
    <?php	
	}
	?>
    <input type="button" value="Clear search results" onclick="window.location.href='index.php?mod=consump&func=formview&id=11';" /></td>
  </tr>
</table>
</form>
</div>
<div align="right"><form><input type="button" onclick="window.location.href='index.php?mod=consump&func=formview&id=11_3'" value="New Item" /></form></div>
<table width="100%">
  <tr class="title">
    <td class="printcol">Edit</td>
    <td>ID #</td>
    <td>Name</td>
    <td>Spec.</td>
    <td>Model</td>
    <td>Unit</td>
    <td>Storehouse</td>
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

if ($_GET['query']=="") {
	$sql = "SELECT * FROM `arkstock` WHERE 1 ";
} elseif ($_GET['query']=="1" && ($_GET['view']==0 || $_GET['view']=="")) {
	//搜尋編號
	$sql = "SELECT * FROM `arkstock` WHERE `STK_NO`='".mysql_escape_string($_GET['STKNO'])."'";
} elseif ($_GET['query']=="2" && ($_GET['view']==0 || $_GET['view']=="")) {
	//搜尋分類
	$sql = "SELECT * FROM `arkstock` WHERE ";
	if ($_GET['KIND1']!="") {
		$sql .= "`STK_KIND1`='".mysql_escape_string($_GET['KIND1'])."' AND ";
	}
	if ($_GET['KIND2']!="") {
		$sql .= "`STK_KIND2`='".mysql_escape_string($_GET['KIND2'])."' AND ";
	}
	if ($_GET['KIND3']!="") {
		$sql .= "`STK_KIND3`='".mysql_escape_string($_GET['KIND3'])."' AND ";
	}
	$sql = substr($sql,0,strlen($sql)-5);
} elseif ($_GET['query']=="3" && ($_GET['view']==0 || $_GET['view']=="")) {
	//顯示所有物品
	$sql = "SELECT * FROM `arkstock` WHERE 1 ";
}
if ($sql=="") { $sql = "SELECT * FROM `arkstock` WHERE 1 "; }
if ($_GET['stop']=='y') {
	//$sql .= " AND `STOP_ID`='Y'";
} elseif ($_GET['stop']=='n') {
	$sql .= " AND `STOP_ID`='N'";
}
$sql .= " ORDER BY `STK_NO` ASC";
$db0 = new DB;
$db0->query($sql);
$totalRow = $db0->num_rows();
$totalPages = ceil($totalRow/$maxNo);

$sql .= " LIMIT ".$ps.", ".$maxNo;

$db = new DB;
$db->query($sql);
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	$img = ($r['STOP_ID']=="Y"?"star_empty":"star_full");
	echo '
  <tr style="line-height:24px;">
    <td align="center" class="printcol"><a href="index.php?mod=consump&func=formview&id=11_1&STKNO='.$r['STK_NO'].'"><img src="Images/edit_icon.png" width="18"></a></td>
    <td>'.$r['STK_NO'].'</td>
    <td>'.$r['STK_NAME'].'</td>
    <td>'.$r['STK_SPK'].'</td>
    <td>'.$r['STK_MODEL'].'</td>
    <td>'.$r['STK_UNIT'].'</td>
	<td>'.checkLayNo($r['LAY_NO']).'</td>
	<td align="center"><img src="Images/'.$img.'.png" width="24" title="Set to frequent usage" id="sItem_'.$r['STK_NO'].'"></td>
  </tr>'."\n";
}
?>
  <tr class="title page printcol">
    <td colspan="8"><?php echo changePageManager($totalRow, $totalPages, $pn, $maxNo, "&stop=".$_GET['stop']."&query=".$_GET['query']."&KIND1=".$_GET['KIND1']."&KIND2=".$_GET['KIND2'], "index.php?mod=consump&func=formview&id=11&view=0&stop=".$_GET['stop'].""); ?></td>
  </tr>
</table>
<script>
$(function() {
	$("img[id^='sItem_']").click(function(){
		var id = $(this).attr("id").split('_');
		var idname = $(this).attr("id");
		//id[1] = ApplyItemID
		$.ajax({
			url: "class/setEnableStar.php",
			type: "POST",
			data: {"table": 'arkstock', "autoID":'STK_NO', "colID":'STOP_ID', "ID": id[1], "type": 1 },
			success: function(data) {
				$('#'+idname).attr("src", "Images/"+data+".png");
			}
		});
  });
});
</script>