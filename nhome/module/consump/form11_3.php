<script>
function checkExistSTKNO() {
	$.ajax({
		url: "class/checkExistSTKNO.php",
		type: "POST",
		data: {"STKNO": $('#STK_NO').val() },
		success: function(data) {
			if (data=="EXISTED") { alert('This number already exists, please use another number!'); $('#STK_NO').val('').focus(); }
		}
	})
}
function changekind1() {
	var kind1 = document.getElementById('STK_KIND1').value;
	var kind2 = document.getElementById('STK_KIND2');
	var kind3 = document.getElementById('STK_KIND3');
	kind2.options.length = 0;
	kind3.options.length = 0;
	kind2.disabled=false;
	kind3.disabled=false;
	<?php
	$db2a = new DB;
	$db2a->query("SELECT * FROM `itemkind1` ORDER BY `ID` ASC");
	for ($i2a=0;$i2a<$db2a->num_rows();$i2a++) {
		$r2a = $db2a->fetch_assoc();
		if ($response2!="") { $response2 .= ' else '; }
		$response2 .= 'if (kind1=="'.$r2a['ID'].'") {'."\n";
		$db2b = new DB;
		$db2b->query("SELECT * FROM `itemkind2` WHERE `kind1`='".$r2a['ID']."' ORDER BY `ID` ASC");
		if ($db2b->num_rows()==0) {
			$response2 .= "		kind2.options[0] = new Option('－－沒有次分類－－','');
		kind2.disabled=true;
		kind3.options[0] = new Option('－－沒有次分類－－','');
		kind3.disabled=true;\n";
		} else {
			$response2 .= "		kind2.options[0] = new Option('','');\n";
			for ($i2b=1;$i2b<=$db2b->num_rows();$i2b++) {
				$r2b = $db2b->fetch_assoc();
				$response2 .= "		kind2.options[".$i2b."] = new Option('".$r2b['Name']."','".$r2b['ID']."');\n";
			}
		}
		$response2 .= "	}";
	}
	echo $response2;
	?>
}
function changekind2() {
	var kind1 = document.getElementById('STK_KIND1').value;
	var kind2 = document.getElementById('STK_KIND2').value;
	var kind3 = document.getElementById('STK_KIND3');
	kind3.options.length = 0;
	kind3.selectedIndex = 0;
	kind3.disabled=false;
	<?php
	$db3a = new DB;
	$db3a->query("SELECT * FROM `itemkind1` ORDER BY `ID` ASC");
	for ($i3a=0;$i3a<$db3a->num_rows();$i3a++) {
		$r3a = $db3a->fetch_assoc();
		$db3b = new DB;
		$db3b->query("SELECT * FROM `itemkind2` WHERE `kind1`='".$r3a['ID']."' ORDER BY `ID` ASC");
		for ($i3b=1;$i3b<=$db3b->num_rows();$i3b++) {
			$r3b = $db3b->fetch_assoc();
			if ($response3!="") { $response3 .= ' else '; }
			$response3 .= 'if (kind1=="'.$r3a['ID'].'" && kind2=="'.$r3b['ID'].'") {'."\n";
			$response3 .= "		kind3.options[0] = new Option('','');\n";
			$db3c = new DB;
			$db3c->query("SELECT * FROM `itemkind3` WHERE `kind1`='".$r3a['ID']."' AND `kind2`='".$r3b['ID']."' ORDER BY `ID` ASC");
			if ($db3c->num_rows()==0) {
				$response3 .= "		kind3.options[0] = new Option('－－沒有次分類－－','');
	kind3.disabled=true;\n";
			} else {
				for ($i3c=1;$i3c<=$db3c->num_rows();$i3c++) {
					$r3c = $db3c->fetch_assoc();
					$response3 .= "		kind3.options[".$i3c."] = new Option('".$r3c['Name']."','".$r3c['ID']."');\n";
				}
			}
			$response3 .= "	}";
		}
	}
	echo $response3;
	?>
}
</script>
<?php

if (isset($_POST['saveproduct'])) {
	array_pop($_POST);
	$dbn = new DB;
	$dbn->query("INSERT INTO `arkstock` (`STK_NO`) VALUES ('".mysql_escape_string($_POST['STK_NO'])."')");
	foreach ($_POST as $k=>$v) {
		$arrVarName = explode('_',$k);
		if (count($arrVarName)==2) {
			//General
			$db0 = new DB;
			$db0->query("UPDATE `arkstock` SET `".$k."`='".$v."' WHERE `STK_NO`='".mysql_escape_string($_POST['STK_NO'])."'");
			//echo "UPDATE `arkstock` SET `".$k."`='".$v."' WHERE `STK_NO`='".mysql_escape_string($_POST['STK_NO'])."'<br>";
		} elseif (count($arrVarName)==3) {
			//STOP_ID PRC_ID處理
			if ($v==1) {
				if ($arrVarName[2]==1) {
					$vtowrite="Y";
				} elseif ($arrVarName[2]==2) {
					$vtowrite="N";
				}
			$db0 = new DB;
			$db0->query("UPDATE `arkstock` SET `".$arrVarName[0].'_'.$arrVarName[1]."`='".$vtowrite."' WHERE `STK_NO`='".mysql_escape_string($_POST['STK_NO'])."'");
			//echo "UPDATE `arkstock` SET `".$arrVarName[0].'_'.$arrVarName[1]."`='".$vtowrite."' WHERE `STK_NO`='".mysql_escape_string($_POST['STK_NO'])."'<br>";
			}
		}
	}
	//print_r($_POST);
	echo "<script>alert('新增商品成功！');window.location.href='index.php?mod=consump&func=formview&id=11_1&STKNO=".$_POST['STK_NO']."';</script>";
}

?>
<form id="base" method="post" action="index.php?mod=consump&func=formview&id=11_3">
<table width="100%">
  <tr>
    <td class="title" colspan="10">New Item</td>
  </tr>
  <tr>
    <td class="title" width="100">ID #</td>
    <td width="200" align="left"><input type="text" name="STK_NO" id="STK_NO" size="10" class="validate[min[100000],max[999999],required]" onblur="checkExistSTKNO()"></td>
    <td class="title" width="80">Name</td>
    <td colspan="3" align="left"><input type="text" name="STK_NAME" id="STK_NAME" size="80" value="<?php echo $r['STK_NAME']; ?>" class="validate[required]"></td>
    
  </tr>
  <tr>
    <td class="title" width="80">Spec.</td>
    <td align="left"><input type="text" name="STK_SPK" id="STK_SPK" size="20" value="<?php echo $r['STK_SPK']; ?>"></td>
    <td class="title">Model</td>
    <td width="200" align="left"><input type="text" name="STK_MODEL" id="STK_MODEL" size="20" value="<?php echo $r['STK_MODEL']; ?>"></td>
    <td class="title">Unit</td>
    <td align="left"><input type="text" name="STK_UNIT" id="STK_UNIT" size="20" value="<?php echo $r['STK_UNIT']; ?>"></td>
  </tr>
  <tr>
    <td class="title">Purchase price</td>
    <td align="left">$ <input type="text" name="IN_PRC" id="IN_PRC" size="20" value="<?php echo $r['IN_PRC']; ?>"></td>
    <td class="title">Sale price</td>
    <td align="left">$ <input type="text" name="OUT_PRC" id="OUT_PRC" size="20" value="<?php echo $r['OUT_PRC']; ?>"></td>
    <td class="title">Sale price category</td>
    <td align="left">
    <?php
	if ($r['PRC_ID']=='N') { $PRCID = '2'; } elseif ($r['PRC_ID']=='Y') { $PRCID = '1'; }
	echo draw_option("PRC_ID","Standard price;Resident price", "l", "single", $PRCID, false, 0);
	?>
    </td>
  </tr>
  <tr>
    <td class="title">Major category</td>
    <td align="left">
    <select name="STK_KIND1" id="STK_KIND1" onchange="changekind1();">
      <option></option>
      <?php
	  $db1a = new DB;
	  $db1a->query("SELECT * FROM `itemkind1` ORDER BY `ID` ASC");
	  for ($i1a=0;$i1a<$db1a->num_rows();$i1a++) {
		  $r1a = $db1a->fetch_assoc();
		  echo '<option value="'.$r1a['ID'].'"'.($r1a['ID']==$r['STK_KIND1']?' selected':'').'>'.$r1a['Name'].'</option>'."\n";
	  }
	  ?>
    </select>
    </td>
    <td class="title">Item category</td>
    <td align="left">
    <select name="STK_KIND2" id="STK_KIND2" onchange="changekind2();">
      <option></option>
      <?php
	  if ($r['STK_KIND1']!="") {
		  $sql1b = "SELECT * FROM `itemkind2` WHERE `kind1`='".$r['STK_KIND1']."' ORDER BY `ID` ASC";
	  } else {
		  $sql1b = "SELECT * FROM `itemkind2` WHERE `kind1`='1' ORDER BY `ID` ASC";
	  }
	  $db1b = new DB;
	  $db1b->query($sql1b);
	  for ($i1b=0;$i1b<$db1b->num_rows();$i1b++) {
		  $r1b = $db1b->fetch_assoc();
		  echo '<option value="'.$r1b['ID'].'"'.($r1b['ID']==$r['STK_KIND2']?' selected':'').'>'.$r1b['Name'].'</option>'."\n";
	  }
	  ?>
    </select>
    </td>
    <td class="title">Item sub-category</td>
    <td align="left">
    <select name="STK_KIND3" id="STK_KIND3">
      <option></option>
      <?php
	  if ($r['STK_KIND1']!="" && $r['STK_KIND2']!="") {
		  $sql1c = "SELECT * FROM `itemkind3` WHERE `kind1`='".$r['STK_KIND1']."' AND `kind2`='".$r['STK_KIND2']."' ORDER BY `ID` ASC";
	  } else {
		  $sql1c = "SELECT * FROM `itemkind3` WHERE `kind1`='1' AND `kind2`='2' ORDER BY `ID` ASC";
	  }
	  $db1c = new DB;
	  $db1c->query($sql1c);
	  for ($i1c=0;$i1c<$db1c->num_rows();$i1c++) {
		  $r1c = $db1c->fetch_assoc();
		  echo '<option value="'.$r1c['ID'].'"'.($r1c['ID']==$r['STK_KIND3']?' selected':'').'>'.$r1c['Name'].'</option>'."\n";
	  }
	  ?>
    </select>
    </td>
  </tr>
  <tr>
    <td class="title">Minimum safe stock</td>
    <td align="left"><input type="text" name="SAFE_QTY" id="SAFE_QTY" value="<?php echo $r['SAFE_QTY']; ?>" size="10"></td>
    <td class="title">Storehouse</td>
    <td align="left"><?php echo checkLayNo($r['LAY_NO']); ?></td>
    <td class="title">Disabled</td>
    <td align="left">
    <?php
	if ($r['STOP_ID']=='N') { $STOPID = '2'; } elseif ($r['STOP_ID']=='Y') { $STOPID = '1'; }
	echo draw_option("STOP_ID","Disabled;Usable", "xs", "single", $STOPID, false, 0);
	?>
    </td>
  </tr>
  <tr>
    <td class="title">Latest delivery date</td>
    <td align="left" align="left"><?php echo $r['OUT_DATE']; ?></td>
    <td class="title">Comment</td>
    <td colspan="3" align="left"><input type="text" name="STK_RMK" id="STK_RMK" size="80" value="<?php echo $r['STK_RMK']; ?>"></td>
  </tr>
  <tr>
    <td class="title">Transaction date</td>
    <td align="left"><?php echo $r['CHG_DATE']; ?><input type="hidden" name="CHG_DATE" id="CHG_DATE" value="<?php echo date('Y-m-d H:i:s'); ?>"></td>
    <td class="title">Modified by</td>
    <td colspan="3" align="left"><?php echo checkusername($r['CHG_USER']); ?><input type="hidden" name="CHG_USER" id="CHG_USER" value="<?php echo $_SESSION['ncareID_lwj']; ?>"></td>
  </tr>
  <tr class="printcol">
    <td colspan="6" align="center"><input type="button" value="Back to list" onclick="window.location.href='index.php?mod=consump&func=formview&id=11'"> <input type="submit" name="saveproduct" id="saveproduct" value="New Item"></td>
  </tr>
</table>
</form>

<script>$("#base").validationEngine();</script>