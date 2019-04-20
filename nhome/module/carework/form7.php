<div class="moduleNoTab">
<h3 style="width:100%;">Indwelling Catheterization bladder training</h3>
<form style="width:100%; margin:0 auto; padding-bottom:20px;">
	<?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?>
    <div align="left"><input type="button" value="Add Record" id="Add"></div>
	<?php }?>
    <table class="content-query" style="font-size:11pt; font-weight:normal; width:100%;">
      <tr class="title">
      <td class="printcol">View</td>
      <td>Care ID#</td>
      <td>Full Name</td>
      <td>Start Date</td>
      <td>End Date</td>
      <td>Results</td>
      <td>Filled by</td>
      <td class="printcol">Print</td>
	  <?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?>
      <td class="printcol">Delete</td>
	  <?php }?>
      </tr>
    <?php
	$dbp1_7 = new DB;
	$dbp1_7->query("SELECT * FROM  `careform07` WHERE `HospNo`='".$HospNo."' ORDER BY nID DESC");
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
		  $action = mysql_escape_string($_GET['action']);
		  if($action=="chk"){
			  $url ="index.php?mod=carework&func=formview&id=7_2&action=chk";			  
		  } else {
			  $url ="index.php?mod=carework&func=formview&id=7_1&action=edit";
		  }
	?>
      <tr>
        <td><center><a href="<?php echo $url; ?>&pid=<?php echo $_GET['pid']; ?>&nID=<?php echo $nID; ?>"><img src="Images/folder.png" width="24" /></a></center></td>
        <td><center><?php echo $HospNo; ?></center></td>
        <td><center><?php echo $name; ?></center></td>
        <td><center><?php echo $Q1; ?></center></td>
        <td><center><?php echo $Q2; ?></center></td>
        <td><center><?php echo str_replace("\n","<br>",$Q26); ?></center></td>
        <td><center><?php echo checkusername($Qfiller); ?></center></td>
        <td><center><a href="print.php?mod=carework&func=formview&id=7_1&pid=<?php echo $_GET['pid']; ?>&nID=<?php echo $nID; ?>" target="_blank"><img src="Images/printer.png" width="30"/></a></center></td>
        <?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?>
		<td><center><a href="index.php?mod=management&func=formview&id=3c_8&pid=<?php echo $_GET['pid']; ?>&nID=<?php echo $nID; ?>"><img src="Images/delete2.png" width="30" /></a></center></td>
		<?php }?>
      </tr>
    <?php
	}
	}
	?>
    </table>
</form>
</div>
<script>
$(function() {
	$('#Add').click(function(){
		location.href = "index.php?mod=carework&func=formview&id=7_1&action=new&pid=<?php echo $_GET['pid']; ?>";
	});	
});
</script>