<?php 
if($_GET['FirmDiv'] <> ""){
	$fid = str_pad($_GET['FirmDiv'],6,'0',STR_PAD_LEFT);
}
?>
<h3>Public property supply spending statistics</h3>
<div class="nurseform-table" align="center">
<table width="100%">
  <tr>
    <td width="120" class="title">Shipping Date (Start)</td>
    <td colspan="3"><script> $(function() { $( "#5printdate1").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="5printdate1" id="5printdate1" value="<?php if (@$_GET['date1']=="") { echo date("Y/m/d"); } else { echo @$_GET['date1']; } ?>" size="12"></td>  
    <td width="120" class="title">Shipping Date (Until)</td>
    <td colspan="3"><script> $(function() { $( "#5printdate2").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="5printdate2" id="5printdate2" value="<?php if (@$_GET['date2']=="") { echo date("Y/m/d"); } else { echo @$_GET['date2']; } ?>" size="12"> </td>  
    </tr>
  <tr style="text-align:center;">
    <td width="120" class="title">Product (Start)</td>
    <td><input name="STK_NO1" type="text" id="STK_NO1" onblur="blurselect(1);" size="5"/></td>  
    <td><button onclick="window.open('class/searchSTK3.php?query=1', '_blank', 'width=960, height=150'); return false;" >...</button></td>
    <td><input type="text" id="STK_NAME1" name="STK_NAME1"  disabled="disabled"/></td>
    <td width="120" class="title">Product (Until)</td>
    <td><input name="STK_NO2" type="text" id="STK_NO2" onblur="blurselect(2);"  size="5"//></td>  
    <td><button onclick="window.open('class/searchSTK3.php?query=2', '_blank', 'width=960, height=150'); return false;" >...</button></td>
    <td><input type="text" id="STK_NAME2" name="STK_NAME2"  disabled="disabled"/></td>
   </tr>

  <tr>
    <td align="center"  bgcolor="#FFFFFF" colspan="8"><input type="button" value="Print" onclick="datefunction('print','5');" /></td>
  </tr> 
</table>
</div>
