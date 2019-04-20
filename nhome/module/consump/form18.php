<script type="text/javascript" src="js/share.js"></script>
<h3>Food ingredients manage</h3>
<?php

//模組名稱
$strModule = "firmstockexpire";
$type = "IC";

$strQry = " AND `zdate` IS NULL ";

if($_POST["act"]=="delete"){
	if(count($_POST['chk'.$strModule.'ID']) >0){
		foreach($_POST['chk'.$strModule.'ID'] as $k =>$v){
			$delDB = new DB;
			$delDB->query("DELETE FROM `".$strModule."` WHERE `nID`=".$v."");
		}		
	}
}

$ExpireDay = getSystemSetting('ExpireDate1');

//主SQL
$sql1="SELECT *, RIGHT( EXTRACT( YEAR_MONTH FROM  `STK_DATE` ) , 4 ) ordDate, datediff(edate,'".date("Y-m-d")."') overDate FROM `".$strModule."` WHERE 1 ".$strQry." ORDER BY nID";
?>
<form method="post">
<div align="right">
<input type="button" name="btnDel" id="btnDel" value=" Delete ">
<input type="button" name="btnAdd" id="btnAdd" value=" Add " />
</div>
<div id="dialog" title="" style="display:none;">
</div>
<div id="dialogEdit" title="Edit" class="dialog-form">
<fieldset>
<table>
	<tr>
    	<td class="title">Expire date</td>
        <td><input type="text" name="edate" id="edate"><script> $(function() { $( "#edate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script></td>
    </tr>
</table>
</fieldset>
</div>
<div class="content-query">
<table width="100%" id="stktable">
  <thead>
	<tr class="title">
        <th>&nbsp;</th>
        <th>Purchase bill #</th>
        <th>Storehouse</th>
        <th>product serial number</th>
        <th>Product name</th>
        <th>Purchase quantity</th>
        <th>Expire date</th>
        <th>Function</th>
    </tr>
  </thead>
<?php
//echo $sql1;	
$db = new DB;
$db->query($sql1);
if ($db->num_rows()>0) {

  for ($i=0;$i<$db->num_rows();$i++) {
	  $r = $db->fetch_assoc();
	  foreach ($r as $k=>$v) {
		  $arrPatientInfo = explode("_",$k);
		  if (count($arrPatientInfo)==2) {
			  if ($v==1) {
				  ${$arrPatientInfo[0]} = $arrPatientInfo[1];
			  }
		  } else {
			  ${$k} = $v;
		  }
	  }
?>
<tr>
  <td align="center">
		<?php print_r("<input type='checkbox' id='chk".$strModule."ID' name='chk".$strModule."ID[]' value='".$nID."'>"); ?>
  </td>
  <td <?php if($overDate<=$ExpireDay){echo 'style="color:red;"';}?>>&nbsp;<?php echo $type.$ordDate.$firmStockID; ?></td>
  <td <?php if($overDate<=$ExpireDay){echo 'style="color:red;"';}?>>&nbsp;<?php echo $StockID; ?></td>
  <td <?php if($overDate<=$ExpireDay){echo 'style="color:red;"';}?>>&nbsp;<?php echo $r['STK_NO']; ?></td>
  <td <?php if($overDate<=$ExpireDay){echo 'style="color:red;"';}?> align="left"><?php echo STK_NAME($r['STK_NO']); ?>&nbsp;</td>
  <td <?php if($overDate<=$ExpireDay){echo 'style="color:red;"';}?> align="right"><?php echo $r['QTY']; ?>&nbsp;</td>
  <td <?php if($overDate<=$ExpireDay){echo 'style="color:red;"';}?> align="center"><?php echo $r['eDate'];?>&nbsp;</td>
  <td>
  	<input type="button" value="Edit" onclick="edit('<?php echo $r['nID'];?>','<?php echo $r['eDate'];?>');">
    <input type="button" value="Done using" onclick="end('<?php echo $r['nID'];?>');">
</td>
</tr>
<?php 
	}
}
?>
</table>
</div>

<input type="hidden" name="act" id="act" />
</form>

<p>&nbsp;</p>
<script language="javascript">
function edit(nID,eDate){
	$("#edate").val(eDate);
	$("#dialogEdit").data('nID',nID).dialog( "open" );
}
function end(nID){
	$.ajax({
		url: "class/editrow.php",
		type: "POST",
		data: {"nID": nID,"zdate":'<?php echo date("Y-m-d");?>',"formID":'firmstockexpire'},
		success: function(data) {
			window.location.reload();
		}
	});
}

$(function() {
    $("#dialogEdit").dialog({
        title: 'Modify expire date',
        autoOpen: false,
        width: 300,
        height: 210,
        modal: true,        
        buttons: {
			"Confirm": function() {
				$.ajax({
					url: "class/editrow.php",
					type: "POST",
					data: {"nID": $(this).data('nID'),"edate":$("#edate").val(),"formID":'firmstockexpire'},
					success: function(data) {
						$( "#dialogEdit" ).dialog( "close" );
						window.location.reload();
					}
				});
			},			
            'Close': function() {
                $(this).dialog('close');
            }
        }
    });	
  $('#stktable').dataTable({
		"order": [[1, "asc"], [0, "asc"]],
		"paging": false
  });	
  $('#btnAdd').click(function() {
	var page = "module/consump/firm.php?status=18_1" ;
    $('#dialog').html( '<iframe style="border: 0px; " src="' + page + '" width="100%" height="100%"></iframe>' );
    $("#dialog").dialog({
        title: 'Select purchase bill',
        bgiframe: true,
        width: 500,
        height: 630,
        modal: true,
		resize: true,
        draggable: true,
        overlay:{opacity: 0.7, background: "#FF8899" },
        buttons: {
            'Close': function() {
                $(this).dialog('close');
            }
        }
    });
   });
  
  $('#btnDel').click(function() {
	if (DelDataCheck(document.forms[0].chk<?php echo $strModule."ID";?>)){
	  $('#act').val('delete');
	  $('form').submit();
	}
  });
});
</script>	