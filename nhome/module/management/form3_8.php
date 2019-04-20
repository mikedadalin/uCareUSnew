<?php 
if($_GET['part']==2){
	$report = substr($qdate,0,4);
	$content = ($report-1911)."Year";
}else{
	$report = substr($qdate,0,4).'/'.substr($qdate,4,2);
	$content = "(".$report.")";
}
?>
<h3>Training record for removing catheter&nbsp;<?php echo $content;?></h3>
  <div align="center" style="margin-bottom:10px;">
	   <?php echo draw_option("tab9option","Current month record;Annual total list","xl","single",1,false,5); ?>
  </div>
  <div align="center">
    <!--<a id="newrecord7" title="移除鼻胃管訓練紀錄登錄"><i class="fa fa-user-plus fa-2x fa-fw"></i><br>Add new data</a>-->
    <div class="patlistbtn" style="background-color:rgba(149,219,208,1); width:100px;"><a href="index.php?mod=management&func=formview&id=3d_1&type=8<?php echo $sMonth;?>" title="逐案分析列表"><i class="fa fa-list fa-2x fa-fw"></i><br>Case-by-case analysis</a></div>
    <div class="patlistbtn" style="background-color:rgba(149,219,208,1);"><a href="print.php?mod=management&func=formview&id=3&view=9&part=<?php echo $_GET['part'];?>&qdate=<?php echo $_GET['qdate']; ?>" target="_blank" title="Print report"><i class="fa fa-print fa-2x fa-fw"></i><br>Print report</a></div>
  </div>
<form id="tform7" action="index.php?mod=management&func=formview&id=3d_2&type=8<?php echo $sMonth; ?>" method="post">
<table class="content-query" style="font-size:8pt; font-weight:normal;" width="100%" align="center">
  <tr class="title">
  <td class="printcol">View</td>
  <td>Care ID#</td>
  <td>Full name</td>
  <td>Start date</td>
  <td>End date</td>
  <td>Results</td>
  <td class="printcol">Case-by-case analysis</td>
  <td>Filled by</td>
  <td class="printcol">Delete</td>
  </tr>
<?php
$dbp1_7 = new DB;
$dbp1_7->query("SELECT * FROM  `careform07` WHERE `Q1` LIKE '".$report."%'");
if ($dbp1_7->num_rows()==0) {
?>
  <tr>
    <td colspan="11"><center>-------Yet no data of this month-------</center></td>
  </tr>
<?php
} else {
for ($p1_i1=0;$p1_i1<$dbp1_7->num_rows();$p1_i1++) {
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
      $action = mysql_escape_string($_GET['action']);
      if($action=="chk"){
          $url ="index.php?mod=carework&func=formview&id=7_2&action=chk";			  
      } else {
          $url ="index.php?mod=carework&func=formview&id=7_1&action=edit&view=9";
      }
?>
  <tr>
    <td class="printcol"><center><a href="<?php echo $url; ?>&pid=<?php echo $pid; ?>&nID=<?php echo $nID; ?>"><img src="Images/folder.png" width="24" /></a></center></td>
    <td align="center"><?php echo $HospNo; ?></td>
    <td align="center"><?php echo getPatientName($pid); ?></td>
    <td align="center"><?php echo $Q1; ?></td>
    <td align="center"><?php echo $Q2; ?></td>
    <td align="center"><?php echo str_replace("\n","<br>",$Q26); ?></td>
    <td class="printcol"><center><input type="checkbox" name="targetList_8[]" id="targetList_8_<?php echo $rp1_7['HospNo'].'_'.$rp1_7['date'].'_'.$rp1_7['nID']; ?>" class="validate[required]" value="<?php echo $rp1_7['HospNo'].'-'.$rp1_7['date'].'-'.$rp1_7['nID']; ?>"></center></td>
    <td align="center"><?php echo checkusername($Qfiller); ?></td>
    <td class="printcol"><center><a href="index.php?mod=management&func=formview&id=3c_8&pid=<?php echo $pid; ?>&nID=<?php echo $nID; ?>"><img src="Images/delete2.png" width="24" /></a></center></td>
  </tr>
<?php
}
}
?>
</table>
<center><input type="submit" id="analysis8" value="Start case-by-case analysis" class="printcol"></center>
</form>
<script>
$(function(){
	$('button[id^="btn_tab9option"').click(function(){
		var id = $(this).attr('id');
		var arrID = id.split('_');
		window.location.href='index.php?mod=management&func=formview&id=3&view=9&part='+arrID[2];
	})
});
</script>