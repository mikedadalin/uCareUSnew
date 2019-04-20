<?php 
//echo ;
if ($parentName=='sixtarget_part7') {
	$order = 'ORDER BY title, content1';
} else {
	$order = 'order by alldetailID';
}
$db = new DB;
$db->query("SELECT * FROM `alldetail` WHERE `parentName`='".$parentName."' and `parentID`='".mysql_escape_string($parentID)."' ".$order);
//列出原有檔案區塊
if ($db->num_rows()>0) {
?>
<table align="left"  width="100%" style="font-size:10pt; margin-left:0px;">
  <TBODY>
  <tr>
    <td>
      <table border="0" class="a1" width="100%">
      	<tbody>
          <tr class="title">
          <?php for($i=0;$i<$tmpLength;$i++){?>
            <th width="150"><?php echo $tmpArr[$i];?></th>
          <?php }?>  
            <th width="60" class="printcol">Function</th>
          </tr>
<?php 
  for ($idb=0;$idb<$db->num_rows();$idb++) {
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
        <?php
        for($i=0;$i<$tmpLength;$i++){
			switch($parentName) {
				case 'sixtarget_part7':
					if ($tmpArrCol[$i]=="userID") {
						$rVal = checkusername($r[$tmpArrCol[$i]]).'" readonly="readonly';
					} elseif ($tmpArrCol[$i]=="title") {
						$rVal = formatdate($r[$tmpArrCol[$i]]);
					} else { $rVal = $r[$tmpArrCol[$i]]; }
					$arrHS = explode(":",$r['content1']);
					foreach($arrHS as $k=>$v){
						$H = $arrHS[0];
						$S = $arrHS[1];
					}									
				break;
				case 'nurseform08':
					if ($tmpArrCol[$i]=="userID") {
						$rVal = checkusername($r[$tmpArrCol[$i]]).'" readonly="readonly';
					} elseif ($tmpArrCol[$i]=="title") {
						$rVal = formatdate($r[$tmpArrCol[$i]]);
					} else { $rVal = $r[$tmpArrCol[$i]]; }
					$arrHS = explode(":",$r['content1']);
					foreach($arrHS as $k=>$v){
						$H = $arrHS[0];
						$S = $arrHS[1];
					}	
				break;
				case 'careform07':
					if ($tmpArrCol[$i]=="userID") {
						$rVal = checkusername($r[$tmpArrCol[$i]]).'" readonly="readonly';
					} elseif ($tmpArrCol[$i]=="title") {
						$rVal = formatdate($r[$tmpArrCol[$i]]);
					} else { $rVal = $r[$tmpArrCol[$i]]; }
					$arrHS = explode(":",$r['content1']);
					foreach($arrHS as $k=>$v){
						$H = $arrHS[0];
						$S = $arrHS[1];
					}									
				break;
				default:
					if ($tmpArrCol[$i]=="userID") {
						$rVal = checkusername($r[$tmpArrCol[$i]]).'" readonly="readonly';
					} else { $rVal = $r[$tmpArrCol[$i]]; }
					$H = "";
					$S = "";
				break;
			}
		?>
          <td><input type="text" size="30" id="tmp<?php echo $i.$infoOrd;?>" name="tmp<?php echo $i.$infoOrd;?>" value="<?php echo $rVal; ?>" class="validate[required]" <?php echo $disabled;?>/></td>
        <?php }?>  
        <script>
			$(function () {
				var jsArray_block = ["<?php echo join("\", \"", $tmpArr); ?>"];
				var infoOrd = '<?php echo $infoOrd;?>';
				for (i in jsArray_block) {
					if(jsArray_block[i].search("Date")>-1){
						$('#tmp' + i + infoOrd).datepicker();
						$('#tmp' + i + infoOrd).attr('size', '10');
						$('#tmp' + i).attr('width', '120');
					}else if(jsArray_block[i]=='Filled by'){
						$('#tmp' + i + infoOrd).attr('size', '10').attr('readonly', true);
					}else if(jsArray_block[i]=='Time'){
						$('#tmp' + i).attr('width', '80');
						var timeH = '<select id="tmp'+i+infoOrd+'H1" name="tmp'+i+infoOrd+'H1" >';
							timeH +='<?php
									for ($i2a=0;$i2a<=23;$i2a++) { 
										$select = (($H==""?date(H):$H)==$i2a?" selected":"");
										echo '<option value="'.(strlen($i2a)==1?'0':'').$i2a.'" '.$select.'>'.(strlen($i2a)==1?'0':'').$i2a.'</option>';
									}
									echo '</select>';
									?>';
						var timeI = '<select id="tmp'+i+infoOrd+'I1" name="tmp'+i+infoOrd+'I1" >';
							timeI +='<?php 
										echo '<option value="00" '.($S=="00"?"selected":"").'>00</option>';
										echo '<option value="15" '.($S=="15"?"selected":"").'>15</option>';
										echo '<option value="30" '.($S=="30"?"selected":"").'>30</option>';
										echo '<option value="45" '.($S=="45"?"selected":"").'>45</option>';
									 ?>';
							timeI +='</select>';
						var time = timeH +'：'+ timeI;
						$('#tmp' + i + infoOrd).replaceWith(time);
					}
				}
			});
		 
		</script>
          <td class="printcol">
              <input type="button" value="Remove" onclick="isDEL(<?php echo $infoOrd;?>);" <?php echo $disabled;?>  /></td>
        </tr>
<?php 
  }
?>
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
