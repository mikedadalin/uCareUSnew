<?php 
$dbb = new DB;
$dbb->query("SELECT * FROM `careform04` WHERE `date`='".$qdate."' AND `areaID`='".$areaID."' AND `itemID`='".$r['cID']."'");
//列出原有檔案區塊
if ($db->num_rows()>0) {
?>

<table align="left"  width="100%" style="font-size:10pt; margin-left:0px;">
  <TBODY>
  <tr>
    <td>
      <table border="0" class="a1" width="100%">
      	<tbody>
<?php 
  for ($j1=0;$j1<$dbb->num_rows();$j1++) {
	  $rb = $dbb->fetch_assoc();
	  foreach ($rb as $k=>$v) {
		  $arrPatientInfo = explode("_",$k);
		  if (count($arrPatientInfo)==2) {
			  if ($v==1) {
				  ${$arrPatientInfo[0]} = $arrPatientInfo[1];
			  }
		  } else {
			  ${$k} = $v;
		  }
	  }
	$arrEffect = array("Spider"=>"1","Worm & bug"=>"2","Ant"=>"3","Butterfly"=>"4","Cockroach"=>"5","Other"=>"6");
?>        
        <tr id="DelTR<?php echo $rb['careworkID'];?>">
          <td><input type="text" size="15" id="tmp1_<?php echo $r['cID'].'_'.$rb['careworkID'];?>" name="tmp1_<?php echo $r['cID'].'_'.$rb['careworkID'];?>" value="<?php echo $rb['itemDetail']; ?>"/></td>
          <td><?php echo draw_option("tmp2_".$r['cID'].'_'.$rb['careworkID'],"Mothballs;Insecticide;Bleach","s","single",$status,false,0); ?></td>
          <td>
          <?php echo draw_option("tmp3_".$r['cID'].'_'.$rb['careworkID'],"Spider;Worm & bug;Ant;Butterfly;Cockroach;Other","m","single",$arrEffect[$rb['effect']],true,3); ?>
          <input type="button" value="Delete" onclick="isDEL(<?php echo $rb['careworkID'];?>);"  /></td>
        <?php } ?>
    </table>
  </td>
</tr>
  </TBODY>
</TABLE>
<?php 
}
?>
<script>
function isDEL(id){
	if (confirm('確定刪除此筆資料?')) {
		$.ajax({
			url: 'class/delRow.php',
			type: 'post',
			data: {'formID': 'careform04', 'colID': 'careworkID', 'autoID': id},
			success: function (data) {
				$("#DelTR"+id).remove();
			}
		});
	}
}
</script>

