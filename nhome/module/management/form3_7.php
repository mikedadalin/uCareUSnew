<script>
$(function() {
    $( "#dialog-form7" ).dialog({
		autoOpen: false,
		height: 450,
		width: 930,
		modal: true,
		buttons: {
			"Add record": function() {
				$.ajax({
					url: "class/sixtarget_part7.php",
					type: "POST",
					data: {'HospNo': $('#HospNo_tab7').val(), 'Name': $('#Name_tab7').val(),
					'startdate': $('#part7_startdate').val(), 
					'time': $('#timeH').val() + ':' + $('#timeI').val() + '00', 
					'reason_1': $('#part7_reason_1').val(), 
					'reason_2': $('#part7_reason_2').val(), 
					'reason_3': $('#part7_reason_3').val(), 
					'reason_4': $('#part7_reason_4').val(), 
					'reasonother': $('#part7_reasonother').val(), 
					'releasereason': $('#part7_releasereason').val(), 
					'Qfiller': $('#Qfiller').val() },
					success: function(data) {
						$( "#dialog-form7" ).dialog( "close" );
						alert("Add record sucessfully!");
						window.location.reload();
					}
				});
			},
			"Cancel": function() {
				$( "#dialog-form7" ).dialog( "close" );
			}
		}
	});
});
</script>
<div id="dialog-form7" title="Training record for removing nasogastric tube" class="dialog-form"> 
    <form id="form7">
    <fieldset>
    <table>
    <tr>
      <td class="title">Search</td>
      <td colspan="3">
      &nbsp;<span style="padding:3px; border:1px solid #999; color:#666; font-size:10pt;">Care ID#</span> <input type="text" name="HospNo" id="HospNo_tab7" value="" size="8">&nbsp;
      <span style="padding:3px; background:#69b3b6; color:#fff; font-size:10pt;">or</span>&nbsp;
      <span style="padding:3px; border:1px solid #999; color:#666; font-size:10pt;">Bed #</span> <input type="text" name="BedID" id="BedID_tab7" size="8">&nbsp;
	  <span style="padding:3px; border:1px solid #999; color:#666; font-size:10pt;">Full name</span> <input type="text" name="Name" id="Name_tab7" size="8" readonly="readonly">&nbsp;
      <input type="button" value="Search" id="search_tab7" onclick="loadPatInfo('tab7')" /><input type="button" value="Empty" id="clear_tab7" onclick="cleartab('7')" style="display:none;"/></td>
    </tr>
      <tr>
      <td class="title">Date</td>
      <td><script> $(function() { $( "#part7_startdate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="part7_startdate" id="part7_startdate" value="<?php echo date(Y."/".m."/".d); ?>">&nbsp;Time&nbsp;<select name="timeH" id="timeH">
          <option></option>
          <?php
		  for ($i2a=0;$i2a<=23;$i2a++) { echo '<option value="'.$i2a.'" '.(date(H)==$i2a?" selected":"").'>'.(strlen($i2a)==1?'0':'').$i2a.'</option>'; }
		  ?>
        </select>：<select name="timeI" id="timeI">
          <option></option>
          <option value="00" selected>00</option>
          <option value="15">15</option>
          <option value="30">30</option>
          <option value="45">45</option>
        </select></td>
    </tr>
      <tr>
        <td class="title">Reasons for indwelling nasogastric tube</td>
        <td><?php echo draw_option("part7_reason","Dysphagia;Easily choked;Indwelled during hospitalization;Other","xxl","single",$part7_reason,true,2); ?> <input type="text" name="part7_reasonother" id="part7_reasonother" size="15"></td>
      </tr>
      <tr>
        <td class="title">Record of training process<br>(Contents.量.反應..等)</td>
        <td><textarea id="part7_releasereason" name="part7_releasereason" cols="3"></textarea></td>
      </tr>
      <tr>
        <td class="title">Filled by</td>
        <td><?php echo checkusername($_SESSION['ncareID_lwj']); ?><input type="hidden" name="Qfiller" id="Qfiller" value="<?php echo $_SESSION['ncareID_lwj']; ?>"></td>
      </tr>
    </table>
  </fieldset>
  </form>
</div>
<?php 
if($_GET['part']==2){
	$report = substr($qdate,0,4);
	$content = ($report-1911)." Year";
}else{
	$report = substr($qdate,0,4).'/'.substr($qdate,4,2);
	$content = "(".$report.")";
}
?>
<h3>Training record for removing nasogastric tube &nbsp;<?php echo $content;?></h3>
  <div align="center" style="margin-bottom:10px;">
	   <?php echo draw_option("tab8option","Current month record;Annual total list","xl","single",1,false,5); ?>
  </div>
  <div align="center">
    <button type="button" id="newrecord7" title="移除鼻胃管訓練紀錄登錄" onclick="openVerificationForm('#dialog-form7');"><i class="fa fa-user-plus fa-2x fa-fw"></i><br>Add new data</button>
    <div class="patlistbtn" style="background-color:rgba(149,219,208,1); width:100px;"><a href="index.php?mod=management&func=formview&id=3d_1&type=7<?php echo $sMonth;?>" title="逐案分析列表"><i class="fa fa-list fa-2x fa-fw"></i><br>Case-by-case analysis</a></div>
    <div class="patlistbtn" style="background-color:rgba(149,219,208,1);"><a href="print.php?mod=management&func=formview&id=3&view=8&part=<?php echo $_GET['part'];?>&qdate=<?php echo $_GET['qdate']; ?>" target="_blank" title="Print report"><i class="fa fa-print fa-2x fa-fw"></i><br>Print report</a></div>
  </div>
<form id="tform7" action="index.php?mod=management&func=formview&id=3d_2&type=7<?php echo $sMonth; ?>" method="post">
<table class="content-query" style="font-size:8pt; font-weight:normal;" width="100%" align="center">
      <tr class="title">
      <td class="printcol">View</td>
      <td>Care ID#</td>
      <td>Full name</td>
      <td>Start date</td>
      <td>End date</td>
      <td class="printcol">Reasons for indwelling nasogastric tube</td>
      <td class="printcol">Assessment and follow up</td>
      <td>Results</td>
      <td class="printcol">Case-by-case analysis</td>
      <td>Filled by</td>
      <td class="printcol">Delete</td>
      </tr>
    <?php
	$dbp1_7 = new DB;
	$dbp1_7->query("SELECT * FROM  `sixtarget_part7` WHERE `startdate` LIKE '".$report."%'");
	if ($dbp1_7->num_rows()==0) {
	?>
      <tr>
        <td colspan="11"><center>-------Yet no data of this month-------</center></td>
      </tr>
    <?php
	} else {
	for ($p1_i1=0;$p1_i1<$dbp1_7->num_rows();$p1_i1++) {
		$result="";
		$reason="";
		$rp1_7 =$dbp1_7->fetch_assoc();
		  foreach ($rp1_7 as $k=>$v) {
			  $arrAnswer = explode("_",$k);
			  if (count($arrAnswer)==2) {
				  if ($v==1) { ${$arrAnswer[0]} .= $arrAnswer[1].';'; }
			  } else {
				  ${$k} = $v;
			  }
		  }
		  $pid = getPID($HospNo);
	  /*== 解 START ==*/
	      $rsa = new lwj('lwj/lwj');
	      $puepart = explode(" ",$Name);
	      $puepartcount = count($puepart);
	      if($puepartcount>1){
              for($j=0;$j<$puepartcount;$j++){
                  $prdpart = $rsa->privDecrypt($puepart[$j]);
                  $Name = $Name.$prdpart;
              }
	      }else{
		     $Name = $rsa->privDecrypt($Name);
	      }
	  /*== 解 END ==*/
	?>
      <tr>
        <td class="printcol"><center><a href="index.php?mod=nurseform&func=formview&id=23_1&pid=<?php echo $pid; ?>&tID=<?php echo $targetID; ?>"><img src="Images/folder.png" width="24" /></a></center></td>
        <td align="center"><?php echo $HospNo; ?></td>
        <td align="center"><?php echo $Name; ?></td>
        <td align="center"><?php echo $startdate; ?></td>
        <td align="center"><?php echo $enddate; ?></td>
        <td class="printcol" align="center"><?php echo option_result("reason","Dysphagia;Easily choked;Indwelled during hospitalization;Other","l","single",$reason,false,3).$reasonother; ?></td>
        <td class="printcol" align="center"><?php echo str_replace("\n","<br>",$releasereason); ?></td>
        <td align="center"><?php echo option_result("result","Success;Unsuccessful","l","single",$result,false,3); ?></td>
        <td class="printcol"><center><input type="checkbox" name="targetList_7[]" id="targetList_7_<?php echo $rp1_7['targetID']; ?>" class="validate[required]" value="<?php echo $rp1_7['targetID']; ?>"></center></td>
        <td align="center"><?php echo checkusername($Qfiller); ?></td>
        <td class="printcol"><center><a href="index.php?mod=management&func=formview&id=3c_7&pid=<?php echo $pid; ?>&tID=<?php echo $targetID; ?>"><img src="Images/delete2.png" width="24" /></a></center></td>
      </tr>
    <?php
	}
	}
	?>
    </table>
    <center><input type="submit" id="analysis1" value="Start case-by-case analysis" class="printcol"></center>
</form>
<script>
$(function(){
	$('button[id^="btn_tab8option"').click(function(){
		var id = $(this).attr('id');
		var arrID = id.split('_');
		window.location.href='index.php?mod=management&func=formview&id=3&view=8&part='+arrID[2];
	})
});
</script>