<?php
$HospNo = getHospNo(@$_GET['pid']);
$date = mysql_escape_string(formatdate(@$_GET['date']));

$db1 = new DB;
$db1->query("SELECT * FROM `sixtarget_part5` WHERE `HospNo`='".$HospNo."' AND `startdate`='".$date."'");
$r1 = $db1->fetch_assoc();

foreach ($r1 as $k=>$v) {
	$arrPatientInfo = explode("_",$k);
	if (count($arrPatientInfo)>1) {
		$varname = "";
		for ($i=0;$i<(count($arrPatientInfo)-1);$i++) {
			if ($v==1) {
				if ($varname!="") { $varname .= '_'; }
				$varname .= $arrPatientInfo[$i];
			}
		}
		//echo $varname.'<br>';
		${$varname} .= $arrPatientInfo[(count($arrPatientInfo)-1)].';';
	} else {
		${$k} = $v;
	}
}
?>
<div style="background-color: rgba(255,255,255,0.8); border-radius: 10px; padding:20px 10px 30px 10px; margin-bottom: 30px;">
  <form  method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
    <h3>壓瘡紀錄</h3>
    <div align="right" id="printbtn"><a href="print.php?<?php echo $_SERVER['QUERY_STRING']; ?>" target="_blank"><img src="Images/print.png" border="0"></a></div>
    <table width="100%">
      <tr>
        <td width="120" class="title" style="border-top-left-radius:10px;">Care ID#</td>
        <td><?php echo getHospNoDisplayByPID(getPID($HospNo)); ?></td>
        <td width="120" class="title">Resident name</td>
        <td style="border-top-right-radius:10px;"><?php echo $Name; ?></td>
      </tr>
      <tr>
        <td class="title">壓瘡發生日期</td>
        <td><script> $(function() { $( "#startdate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="startdate" id="startdate" value="<?php echo $startdate; ?>"></td>
        <td class="title">Healed date</td>
        <td><script> $(function() { $( "#enddate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="enddate" id="enddate" value="<?php echo $enddate; ?>"><input type="button" onclick="document.getElementById('enddate').value='<?php echo $enddate; ?>'" value="Today" /></td>
      </tr>
      <tr>
        <td class="title">Pressure ulcer(s) stage</td>
        <td colspan="3">
         <?php echo draw_option("level","一級;二級;三級;四級","m","single",$level,false,3);	?>
       </td>
     </tr>
     <tr>
      <td width="120" height="30" class="title" style="border-bottom-left-radius:10px;">Filled by</td>
      <td colspan="3" style="border-bottom-right-radius:10px;"><?php echo checkusername($Qfiller); ?></td>
    </tr>
  </table>
</form>
</div>