<?php include('DB.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Product info</title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery-1.8.2.min.js"></script>
</head>

<body>
<div class="content-query">
<table width="100%" border="0">
  <tr class="title">
    <td colspan="2">Product info</td>
  </tr>
  <tr>
  	<td>Select category</td>
    <td>
        <select name="STK_KIND1<?php echo $_REQUEST['query']?>" id="STK_KIND1<?php echo $_REQUEST['query']?>" onchange="changekind1('<?php echo $_REQUEST['query']?>')">
          <option></option>
          <?php
		  $db1 = new DB;
		  $db1->query("SELECT * FROM `itemkind1` ORDER BY `ID` ASC");
		  for ($i1=0;$i1<$db1->num_rows();$i1++) {
			  $r1 = $db1->fetch_assoc();
			  echo '          <option value="'.$r1['ID'].'">'.$r1['Name'].'</option>'."\n";
		  }
		  ?>
        </select>
        <select name="STK_KIND2<?php echo $_REQUEST['query']?>" id="STK_KIND2<?php echo $_REQUEST['query']?>" onchange="changekind2('<?php echo $_REQUEST['query']?>')">
          <option></option>
        </select>
        <select name="STK_KIND3<?php echo $_REQUEST['query']?>" id="STK_KIND3<?php echo $_REQUEST['query']?>" onchange="searchproduct('<?php echo $_REQUEST['query']?>')">
          <option></option>
        </select>
        
    
    </td>
  </tr>
      <tr>
        <td>Select item</td>
        <td>
        <select name="STK_SELECT<?php echo $_REQUEST['query']?>" id="STK_SELECT<?php echo $_REQUEST['query']?>" onchange="selectproduct('<?php echo $_REQUEST['query']?>','<?php echo $_REQUEST['t'];?>');">
          <option></option>
        </select>
	  </tr>
</table>

</div>
<center>
	<input type="button" value="Close" onclick="window.close();">
</center>

<script type="text/javascript">
function changekind1(id) {
	var kind1 = document.getElementById('STK_KIND1'+id).value;
	var kind2 = document.getElementById('STK_KIND2'+id);
	var kind3 = document.getElementById('STK_KIND3'+id);
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
			$response2 .= "		kind2.options[0] = new Option('－－no sub-category－－','');
		kind2.disabled=true;
		kind3.options[0] = new Option('－－no sub-category－－','');
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
	searchproduct(id);
}
function changekind2(id) {
	var kind1 = document.getElementById('STK_KIND1'+id).value;
	var kind2 = document.getElementById('STK_KIND2'+id).value;
	var kind3 = document.getElementById('STK_KIND3'+id);
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
				$response3 .= "		kind3.options[0] = new Option('－－no sub-category－－','');
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
	searchproduct(id);
}
function searchproduct(i) {
	$.ajax({
		url: "searchSTK1.php",
		type: "POST",
		data: {"STK_KIND1": $("#STK_KIND1"+i).val(), "STK_KIND2": $("#STK_KIND2"+i).val(), "STK_KIND3": $("#STK_KIND3"+i).val() },
		success: function(data) {
			var arr = data.split(";");
			var STK_SELECT = document.getElementById('STK_SELECT'+i);
			STK_SELECT.options.length = 0;			
			for (var j = 0; j < (arr.length-1); j++) {
				var productinfo = arr[j];
				var arr1 = productinfo.split("||");																					
				//STK_SELECT.options[0] = new Option('','');
				//STK_NO / STK_NAME / STK_SPK / STK_MODEL / STK_UNIT
				STK_SELECT.options[j+1] = new Option(arr1[0] + ' ' + arr1[1] + ' ' + arr1[2] + ' ' + arr1[3],arr1[0]);
				console.log(arr1);				
				
			}
		}
	});
}
function selectproduct(id,type) {	
	$.ajax({
		url: "searchSTK2a.php",
		type: "POST",
		data: {"STK_SELECT": $("#STK_SELECT"+id).val() },
		success: function(data) {
			var arr = data.split("||");
			$('#STK_NO'+id).val(arr[0]);
			$('#STK_NAME'+id).val(arr[1]);
			$('#STK_MODEL'+id).val(arr[3]);
			$('#STK_UNIT'+id).val(arr[4]);
			$('#IN_PRC'+id).val(arr[5]);
			$('#STOCK_INFO'+id).val(arr[6]);
			$('#OUT_PRC'+id).val(arr[7]);
			//id, STK_NO, STK_NAME,	STK_UNIT, IN_PRC, STOCK_INFO, STOCK_INFONAME
			updateOpener(id,arr[0],arr[1],arr[4],arr[5],arr[6],type,arr[7]);
			stockINFO1(id,arr[6],type);
			
			//window.close();
		}
	});
}
  function updateOpener(id,a1,a2,a3,a4,a5,type,a6)
  {
	var STK_NO = window.opener.jQuery("#STK_NO"+id);	
	var STK_NAME = window.opener.jQuery("#STK_NAME"+id);	
	var STK_UNIT = window.opener.jQuery("#STK_UNIT"+id);	
	var IN_PRC = window.opener.jQuery("#IN_PRC"+id);
	var QTY = window.opener.jQuery("#dQTY"+id);	
	var OUT_PRC = window.opener.jQuery("#OUT_PRC"+id);
	var STOCK_INFO = window.opener.jQuery("#STOCK_INFO"+id);
	var oldSTK_NO = window.opener.jQuery("#oldSTK_NO"+id);	
	var oldSTK_NAME = window.opener.jQuery("#oldSTK_NAME"+id);	
	var oldSTK_UNIT = window.opener.jQuery("#oldSTK_UNIT"+id);	
	var oldIN_PRC = window.opener.jQuery("#oldIN_PRC"+id);
	var oldOUT_PRC = window.opener.jQuery("#oldOUT_PRC"+id);		
	var oldSTOCK_INFO = window.opener.jQuery("#oldSTOCK_INFO"+id);
	stockform(id, a1, a5);
	if(type!='old'){
	  STK_NO.val(a1);	
	  STK_NAME.val(a2);
	  STK_UNIT.val(a3);
	  IN_PRC.val(a4);
	  OUT_PRC.val(a6);
	  STOCK_INFO.val(a5);
	}else{
	  oldSTK_NO.val(a1);	
	  oldSTK_NAME.val(a2);
	  oldSTK_UNIT.val(a3);
	  oldIN_PRC.val(a4);
	  oldOUT_PRC.val(a6);
	  oldSTOCK_INFO.val(a5);
	}
	window.close();
  }
  
function stockINFO1(id,t,type) {	
	var STOCK_INFO_NAME = window.opener.jQuery("#STOCK_INFO_NAME"+id);
	var oldSTOCK_INFO_NAME = window.opener.jQuery("#oldSTOCK_INFO_NAME"+id);
  $.ajax({
	  url: "stockInfo.php",
	  type: "POST",
	  data: { "PID": t},
	  success: function(data) {
		  if(type!='old'){		  
		  	STOCK_INFO_NAME.html(data);	
			STOCK_INFO_NAME.val(data);	
		  }else{		  
		  	oldSTOCK_INFO_NAME.html(data);
			oldSTOCK_INFO_NAME.val(data);		  
		  }
	  }
  });
}
function stockform(id, a1, a5) {
	var QTY = window.opener.jQuery("#dQTY"+id);	
	var oldQTY = window.opener.jQuery("#olddQTY"+id);
	var chkDATE = window.opener.jQuery('#STK_Date').val();	
	$.ajax({
		async: false,
		url: "stockform.php",
		type: "POST",
		data: { "STK_NO": a1, "StockID": a5, "STK_DATE":chkDATE},
		success: function(data) {
			var arr = data.split(':');
			if (arr[0]=='1') {
				//低於安全庫存量
				QTY.css('background', '#f00');
				QTY.css('color', '#fff');
				QTY.addClass('validate[custom[integer],min[-1],required]');
				QTY.attr('title', a1 + " [低於安全庫存量] 目前庫存量為" + arr[1]);
				oldQTY.css('background', '#f00');
				oldQTY.css('color', '#fff');
				oldQTY.addClass('validate[custom[integer],min[-1],required]');
				oldQTY.attr('title', a1 + " [低於安全庫存量] 目前庫存量為" + arr[1]);
			} else {
				QTY.css('background', '#fff');
				QTY.css('color', '#21689F');
				QTY.addClass('validate[custom[integer],min[-1],required]');
				QTY.attr('title', a1 + "目前庫存量為" + arr[1]);
				oldQTY.css('background', '#fff');
				oldQTY.css('color', '#21689F');
				oldQTY.addClass('validate[custom[integer],min[-1],required]');
				oldQTY.attr('title', a1 + "目前庫存量為" + arr[1]);
			}
		}
	});
}  
</script>
<p>&nbsp;</p>
</body>
</html>


