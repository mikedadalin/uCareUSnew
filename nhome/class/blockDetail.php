<?php 
//echo ;
$db = new DB;
$db->query("SELECT * FROM `alldetail` WHERE `parentName`='".$parentName."' and `parentID`='".mysql_escape_string($parentID)."' order by alldetailID");

//列出原有檔案區塊print original file block
if ($db->num_rows()>0) {
?>

<table align="left"  width="100%" style="font-size:10pt; margin-left:0px;">
  <TBODY>
  <tr>
    <td>
      <table border="0" class="a1" width="100%">
      	<tbody>
          <tr>
            <th class="title" width="100"><?php echo $tmpArr[0];?></th>
            <th class="title" width="100"><?php echo $tmpArr[1];?></th>
            <th class="title" width="100"><?php echo $tmpArr[2];?></th>
            <th class="title" width="100"><?php echo $tmpArr[3];?></th>
            <th class="title" width="200"><?php echo $tmpArr[4];?></th>
            <th class="title" width="100"><?php echo $tmpArr[5];?></th>
            <th class="title" width="150"><?php echo $tmpArr[6];?></th>
          </tr>
<?php 
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
		$tmp = $db->num_rows();
		$infoOrd = $r['allDetailID'];
		$Qry .= $infoOrd.', ';		   
		if($r['uDate']=='0000-00-00 00:00:00'){
			$uDate = "";
		}else{
			$uDate = $r['uDate'];
			$uDate = date("Y-m-d", strtotime($uDate));
		}


?>        
        <tr id="DelTR<?php echo $infoOrd;?>">
          <td><input type="text" size="12" id="tmp1<?php echo $infoOrd;?>" name="tmp1<?php echo $infoOrd;?>" value="<?php echo $r['title']; ?>"/></td>
          <td><input type="text" size="12" id="tmp2<?php echo $infoOrd;?>" name="tmp2<?php echo $infoOrd;?>" value="<?php echo $r['content1']; ?>" /></td>
          <td><input type="text" size="12" id="tmp3<?php echo $infoOrd;?>" name="tmp3<?php echo $infoOrd;?>"  value="<?php echo $r['content2']; ?>" /></td>
          <td><input type="text" size="12" id="tmp4<?php echo $infoOrd;?>" name="tmp4<?php echo $infoOrd;?>" value="<?php echo $r['content3']; ?>" /></td>
          <td><input type="text" size="30" id="tmp5<?php echo $infoOrd;?>" name="tmp5<?php echo $infoOrd;?>" value="<?php echo $r['content4']; ?>" /></td>
          <td><input type="text" size="10" id="tmp6<?php echo $infoOrd;?>" name="tmp6<?php echo $infoOrd;?>"  value="<?php echo $uDate; ?>" readonly="readonly" /></td>
          <td>
              <input type="text" size="10" id="tmp7<?php echo $infoOrd;?>" name="tmp7<?php echo $infoOrd;?>" value="<?php echo checkusername($r['userID']); ?>" readonly="readonly" />
              <input type="button" value="Remove" onclick="isDEL(<?php echo $infoOrd;?>);"  /></td>
        </tr>
        <?php } ?>
    </table>
  </td>
</tr>
  <input type="hidden" value="<?php echo $Qry ?>" id="Qry" name="Qry">  
  <input type="hidden" value="<?php echo $tmp ?>" id="oldCount" name="oldCount">  
  </TBODY>
</TABLE>
<?php 
}?>
<script>
function isDEL(id){
	$("#DelTR"+id).remove();
}
</script>
