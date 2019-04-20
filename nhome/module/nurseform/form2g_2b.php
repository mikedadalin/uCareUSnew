<?php
   /*========= 分頁 Part 1 START =========*/
   if($_GET['page']=="" || $_GET['page']==NULL){
	   $_SESSION['pagerow']="";
   }
   $sql_query = "SELECT * FROM `nurseform02g_2` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date` IN (SELECT MAX(`date`) FROM `nurseform02g_2` GROUP BY `no`) AND `ReportID` IN (SELECT MAX(`ReportID`) FROM `nurseform02g_2` GROUP BY `no`) ORDER BY `no` ASC";
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
<div class="moduleNoTab" style="margin-bottom:5px; padding-bottom:10px;">
	<div class="nurseform-table">
	  <table style="width:100%;">
	    <tr>
	      <td style="width:300px; border-top-left-radius:16px;"><h3>Pressure ulcer care record</h3></td>
		  <td align="center">
			<!--========= 分頁 Part 2 START =========-->
		    <form method="post" action="">
		      &nbsp;&nbsp;&nbsp; Show data set of:
		      <input type="number" id="pagerow" name="pagerow">
		      <input type="hidden" id="action" name="action" value="setpagerow">
		      <input type="submit" id="submit" name="submit" value="Display">
		    </form>
			<!--========= 分頁 Part 2 END =========-->
		  <?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?>
		    <form>&nbsp&nbsp <input type="button" value="Add pressure ulcer care record" style="font-size:12pt;" onclick="window.location.href='index.php?mod=nurseform&func=formview&pid=<?php echo @$_GET['pid'] ?>&id=<?php echo $_GET['id']; ?>'" /></form>
		  <?php }?>
		  </td>
	    </tr>
	  </table>
	  <table style="width:100%;">
	    <tr class="title">
	      <td colspan="9">Pressure Ulcer</td>
	    </tr>
	    <tr class="title_s">
	      <td width="80"><?php if(substr($_SESSION['ncareID_lwj'],0,8)=="resident"){ echo 'View';}else{ echo 'Edit';}?></td>
		  <td width="80">No.</td>
		  <td width="100">Part</td>
	      <td width="200">Stage</td>
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
	  		  echo '<center><a href="index.php?mod=nurseform&func=formview&pid='.mysql_escape_string($_GET['pid']).'&id=2g_2&no='.$r2['no'].'';
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
		  <td><center>'.option_result("Q2","Forehead;Nose;Chin;Outer ear;Occipital;Breast;Chest;Rib cage;Costal arch;Scapula;Humerus;Elbow;Abdomen;Spine protruding spot;Scrotum;Perineum;Sacral vertebrae;Buttock;Hip ridge;Ischial tuberosity;Front knee;Medial knee;Fibula;Lateral ankle;Inner ankle;Heel;Toe;Plantar;Intertrochanteric;Other","m","multi",$Q2,true,6).'</center></td>
	      <td><center>'.checkbox_result("Q4","Stage 1;Stage 2;Stage 3;Stage 4;Unstageable<br>Non-removable dressing;Unstageable<br>Slough and/or eschar;Unstageable<br>Deep tissue",$Q4,"multi").'</center></td>
	      <td><center>'.option_result("Q3","Healed;Unhealed","s","multi",$Q3,false,5).'</center></td>
	  	  <td><center>'.$Q7.'</center></td>
		  <td><center>';
		  if($Q3=="1;"){ echo $Q26;}else{ echo "";}
		  echo '</center></td>
		  <td><center>';
		  ?>
		  <script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><?php echo formatdate($date); ?>
		  <?php
		  echo '</center></td>
	      <td><center>'.checkusername($Qfiller).'</center></td>
	    </tr>
	  	  '."\n";
	  	  $Q4 = "";
	  	  $Q3 = "";
	  	  $Q7 = "";
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