<?php 
if($_GET['FirmDiv'] <> ""){
	$fid = str_pad($_GET['FirmDiv'],6,'0',STR_PAD_LEFT);
}
?>
<h3>Resident Supply Spending Statistic</h3>
<div class="nurseform-table">
<table style="width:100%;">
  <tr>
    <td><b>Bed Number: <span id="log98"><?php if ($fid=="") { echo ""; } else { echo getBedID(getPID($fid)); } ?></span></b></td>
    <td><b><span <?php  if (strpos($_SERVER['PHP_SELF'],'print.php')!==false) { echo 'style="display:none;"'; } ?>> Select Delivery Date Range : </span> &nbsp;<script> $(function() { $( "#4printdate1").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="4printdate1" id="4printdate1" value="<?php if (@$_GET['date1']=="") { echo date("Y/m/d"); } else { echo @$_GET['date1']; } ?>" size="12"> ~ <script> $(function() { $( "#4printdate2").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="4printdate2" id="4printdate2" value="<?php if (@$_GET['date2']=="") { echo date("Y/m/d"); } else { echo @$_GET['date2']; } ?>" size="12"></b></td>
  </tr>
  <tr>
  	<td colspan="2"><b>Resident: <input name="FirmDiv1" type="text" id="FirmDiv1" onblur="showPatient1();" size="5" value="<?php if ($fid=="") { echo ""; } else { echo $fid; } ?>"/>
    <button onclick="window.open('class/consump.php?query=3', '_blank', 'width=450, height=200, scrollbars=yes'); return false;" >...</button>
    <span id="log99"><?php if ($fid=="") { echo ""; } else { echo getPatientName(getPID($fid)); } ?></span>
    <input type="button" value="Print" onclick="datefunction('print','4');" /> <input type="button" value="Export Excel" onclick="datefunction('export','4');" /></b></td>
  </tr> 
</table>
</div>

