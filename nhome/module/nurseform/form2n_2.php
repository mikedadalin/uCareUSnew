<script type="text/javascript" src="js/LWJ_tabs.js"></script>
<?php
   /*========= 分頁 Part 1 START =========*/
   if($_GET['page']=="" || $_GET['page']==NULL){
	   $_SESSION['pagerow']="";
   }
   $sql_query = "SELECT * FROM `nurseform02n` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date` IN (SELECT MAX(`date`) FROM `nurseform02n` GROUP BY `no`) AND `nID` IN (SELECT MAX(`nID`) FROM `nurseform02n` GROUP BY `no`) ORDER BY `no` ASC";
   if(isset($_POST['action']) && ($_POST['action']=="setpagerow")){
	   if($_POST['pagerow']>0){
		   $_SESSION['pagerow'] = $_POST['pagerow'];
	   }else{
		   $_SESSION['pagerow']="";
	   }
	   ?>
	   <script type="text/javascript">
         document.location.href="index.php?mod=nurseform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=<?php echo $_GET['id']; ?>&no=<?php echo $_GET['no'];?>&page=1";
       </script>
	   <?php
   }
  if(isset($_SESSION['pagerow']) && ($_SESSION['pagerow']!="")){
	  $page_row = $_SESSION['pagerow'];
  }else{
	  $page_row=3;
  }
  $page_number=1;
  if(isset($_GET['page']) || $_GET['page']!=""){
	  $page_number = $_GET['page'];
  }
  $start_row = ($page_number-1)*$page_row;
  $sql_query_limit = $sql_query." LIMIT ".$start_row.",".$page_row;
  $db1 = new DB;
  $db1->query($sql_query);
  $db2 = new DB;
  $db2->query($sql_query_limit);
  $total_records = $db1->num_rows();
  $total_pages = ceil($total_records/$page_row);     
  /*========= 分頁 Part 1 END =========*/
?>
<div class="moduleNoTab" style="margin-bottom:5px;">
<div class="nurseform-table">
<table style="width:100%;">
  <tr>
      <td style="width:300px; border-top-left-radius:16px;"><h3>General wound care</h3></td>
	  <td align="right">
		<!--========= 分頁 Part 2 START =========-->
	    <form method="post" action="">
	      &nbsp&nbsp&nbsp Show data set of:
	      <input type="number" id="pagerow" name="pagerow">
	      <input type="hidden" id="action" name="action" value="setpagerow">
	      <input type="submit" id="submit" name="submit" value="Display">
	    </form>
		<!--========= 分頁 Part 2 END =========-->
		<?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?>
		<form>&nbsp&nbsp <input type="button" value="Add new record" style="font-size:12pt; float:right;" onclick="window.location.href='index.php?mod=nurseform&func=formview&pid=<?php echo @$_GET['pid'] ?>&id=2n'" /></form>
		<?php }?>
	  </td>
  </tr>
</table>
<table style="width:100%;">
  <tr class="title">
    <td width="80"><?php if(substr($_SESSION['ncareID_lwj'],0,8)=="resident"){ echo 'View';}else{ echo 'Edit';}?></td>
    <td width="80">No.</td>
    <td width="100">Part</td>
	<td width="100">Type</td>
    <td width="140">Healing condition</td>
    <td width="140">Generation time</td>
	<td width="110">Healed date</td>
	<td width="110">Record Time</td>
	<td>Identifier</td>
  </tr>
  <?php
  for ($i=0;$i<$db2->num_rows();$i++) {
	  $r2 = $db2->fetch_assoc();
	  foreach ($r2 as $k=>$v) {
		  if (substr($k,0,1)=="Q") {
			  $arrAnswer = explode("_",$k);
			  if (count($arrAnswer)==2) {
				  if ($v==1) { ${$arrAnswer[0]} .= $arrAnswer[1].';'; }
			  } else {
				  ${$k} = $v;
			  }
		  }  else { ${$k} = $v; }
	  }
	  echo '
  <tr>
    <td>';
	  if ($r2['Qfiller']==$_SESSION['ncareID_lwj'] || $_SESSION['ncareLevel_lwj']>=4) {
		  echo '<center><a href="index.php?mod=nurseform&func=formview&pid='.mysql_escape_string($_GET['pid']).'&id=2n&no='.$r2['no'].'';
		  if($_GET['page']!="" || $_GET['page']!=NULL){ echo '&page='.$_GET['page'].'';}
		  echo '">';
		  if(substr($_SESSION['ncareID_lwj'],0,8)=="resident"){
			  echo '<img src="Images/MDSView.png" width="60%" border="0">';
		  }else{
			  echo '<img src="Images/edit_icon.png" width="20" border="0">';
		  }
		  echo '</a></center>';
	  } else { echo '&nbsp;'; }
	  echo '
	</td>
	<td><center>'.$no.'</center></td>
    <td><center>'.option_result("Q1","Forehead;Nose;Chin;Outer ear;Occipital;Breast;Chest;Rib cage;Costal arch;Scapula;Humerus;Elbow;Abdomen;Spine protruding spot;Scrotum;Perineum;Sacral vertebrae;Buttock;Hip ridge;Ischial tuberosity;Front knee;Medial knee;Fibula;Lateral ankle;Inner ankle;Heel;Toe;Plantar;Intertrochanteric;Other","m","multi",$Q1,true,6).'</center></td>	
    <td><center>'.option_result("Qtype","General;Surgical wound;Ulcers;Diabetic foot ulcer;Skin tear;MASD;Burn","l","single",$Qtype,false,4).'</center></td>
	<td><center>'.option_result("Q14","Healed;Unhealed","s","multi",$Q14,false,5).'</center></td>
    <td><center>'.$Q2.'</center></td>
	<td><center>';
	if($Q14=="1;"){ echo $Q15;}else{ echo "";}
	echo '</center></td>
	<td><center>';
	?>
	<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><?php echo formatdate($date); ?>
	<?php
	echo '</center></td>
    <td><center>'.checkusername($Qfiller).'</center></td>
  </tr>
	  '."\n";
	  $Q1 = "";
	  $Q14 = "";
	  $Q2 = "";
	  $Q15 = "";
	  $Qfiller="";
	  	if ($r2) {
          foreach ($r2 as $k=>$v) {
	        if (substr($k,0,1)=="Q") {
		      $arrAnswer = explode("_",$k);
		      if(count($arrAnswer)==2) {
			    if($v==1) {
				  ${$arrAnswer[0]} = "";
			    }
		      }else {
			    ${$k} = "";
		      }
	        }else {
		      ${$k} = "";
	        }
          }
        }
  }
  ?>
</table>
	  <!--========= 分頁 Part 3 START =========-->
	  <table border="0" style="width:100%; text-align:center">
	    <tr>
	      <td style="border-bottom-left-radius:16px; border-bottom-right-radius:16px;">
		  <?php if($page_number > 1){?>
	  	  <a href="index.php?mod=nurseform&func=formview&pid=<?php echo $_GET['pid'];?>&id=<?php echo $_GET['id']; ?>&no=<?php echo $_GET[no];?>&page=1"> << First Page</a>&nbsp&nbsp&nbsp
	  	  <a href="index.php?mod=nurseform&func=formview&pid=<?php echo $_GET['pid'];?>&id=<?php echo $_GET['id']; ?>&no=<?php echo $_GET[no];?>&page=<?php echo $page_number-1;?>"> < Previous</a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
	  	  <?php };?>
		  <?php
		  if($total_pages>0){
			echo 'Page:&nbsp&nbsp';  
		  }
		  ?>
	  	  <?php
	  	    for($i=1;$i<=$total_pages;$i++){
	  		   if($i==$page_number){
	  			   echo "<a style='color:red'><b><u>".$i."</u></b></a>&nbsp&nbsp&nbsp&nbsp";
	  		   }else{
				   ?>
	  			   <a href="index.php?mod=nurseform&func=formview&pid=<?php echo $_GET['pid'];?>&id=<?php echo $_GET['id']; ?>&no=<?php echo $_GET[no];?>&page=<?php echo $i;?>"><u><?php echo $i."</u>";?></a>&nbsp&nbsp&nbsp&nbsp
				   <?php
	  		   }
	  	    }
	  	  ?>		  
	  	  <?php if($page_number < $total_pages){?>
		  &nbsp&nbsp&nbsp&nbsp&nbsp
	  	  <a href="index.php?mod=nurseform&func=formview&pid=<?php echo $_GET['pid'];?>&id=<?php echo $_GET['id']; ?>&no=<?php echo $_GET[no];?>&page=<?php echo $page_number+1;?>">Next ></a>&nbsp&nbsp&nbsp
	  	  <a href="index.php?mod=nurseform&func=formview&pid=<?php echo $_GET['pid'];?>&id=<?php echo $_GET['id']; ?>&no=<?php echo $_GET[no];?>&page=<?php echo $total_pages;?>">Last Page >></a>
	  	  <?php };?>
	      </td>
	    </tr>
	  </table>
	  <!--========= 分頁 Part 3 END =========-->
</div>
</div>
<!--</div>
<div id="tabs-2">
<?php
$db2 = new DB;
$db2->query("SELECT * FROM `nurseform02g_2` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `Q0_2`='1' ORDER BY `date` DESC LIMIT 0,100");
?>
<table style="width:900px;">
  <tr class="title">
    <td colspan="5">Wound</td>
  </tr>
  <tr class="title_s">
    <td width="80">Edit</td>
    <td width="240">Wound size</td>
    <td width="240">Wound dressing change</td>
    <td width="180">Filled date</td>
    <td>Filled by</td>
  </tr>
  <?php
  for ($i=0;$i<$db2->num_rows();$i++) {
	  $r2 = $db2->fetch_assoc();
	  foreach ($r2 as $k=>$v) {
		  if (substr($k,0,1)=="Q") {
			  $arrAnswer = explode("_",$k);
			  if (count($arrAnswer)==2) {
				  if ($v==1) { ${$arrAnswer[0]} .= $arrAnswer[1].';'; }
			  } else {
				  ${$k} = $v;
			  }
		  }  else { ${$k} = $v; }
	  }
	  echo '
  <tr>
    <td>';
	  if ($r2['Qfiller']==$_SESSION['ncareID_lwj'] || $_SESSION['ncareLevel_lwj']>=4) {
		  echo '<center><a href="index.php?mod=nurseform&func=formview&id=2n&pid='.mysql_escape_string($_GET['pid']).'&date='.$r2['date'].'"><img src="Images/edit_icon.png" width="20" border="0"></a></center>';
	  } else { echo '&nbsp;'; }
	  echo '
	</td>
    <td><center>'.$Q9.'x'.$Q10.'x'.$Q11.'cm</center></td>
    <td><center>';
	  $Q22 = substr($Q22,0,strlen($Q22)-1); $arrQ22 = explode(';',$Q22); $Q22txt = ''; foreach ($arrQ22 as $k=>$v) { if ($Q22txt != '') { $Q22txt .= '、'; } $Q22txt .= $arrQ22item[$v]; }
	  echo $Q22txt.'</center></td>
	<td><center>'.formatdate($date).'</center></td>
    <td><center>'.checkusername($Qfiller).'</center></td>
  </tr>
	  '."\n";
  }
  ?>
</table>
</div>
</div>-->

<div id="dialog-change" title="複製傷口紀錄">
	<form>
		<table>
          <tr>
            <td class="title">新填寫日期</td>
            <td><script> $(function() { $( "#newdate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="newdate" id="newdate" value="<?php echo date("Y/m/d"); ?>" size="12"></td>
          </tr>
        </table>    	
        <input type="hidden" id="oldnID" name="oldnID">
    </form>
</div>
<script>
$(function() {
    $( "#dialog-change" ).dialog({
		autoOpen: false,
		height: 200,
		width: 350,
		modal: true,
		buttons: {
			"Confirm copy": function() {
				$.ajax({
					url: "class/copyform.php",
					type: "POST",
					data: {	"colid"  : $("#oldnID").val(),
							"colName": "nID", 
							"date"   : $("#newdate").val(),
							"formID" : "nurseform02n",
							"Qfiller": '<?php echo $_SESSION['ncareID_lwj']; ?>'},
					success: function(data) {
						$( "#dialog-change" ).dialog( "close" );
						if (data=="OK") {
							alert("Copied successfully");
						}
						document.location.reload(true);
						}
				});
			},
			"Cancel": function() {
				$( "#dialog-change" ).dialog( "close" );
				document.location.reload(true);
			}
		}
	});
});
function copyDialog(id) {
	var id1 = id.split('_');
	$( "#dialog-change" ).dialog( "open" );
	$("#oldnID").val(id1[1]);
}
</script>