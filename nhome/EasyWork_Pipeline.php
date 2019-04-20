<script>
$(function() {
    $( "#Pipeline-form" ).dialog({
		autoOpen: false,
		height: 390,
		width: 450,
		modal: true,
		buttons: {
			"Add pipeline records": function() {
				$.ajax({
					url: "class/nurseform02k.php",
					type: "POST",
					data: {"HospNo": $("#NewPipeline_HospNo").val(), "date": $("#NewPipeline_date").val(), "Q1": $("#NewPipeline_Q1").val(), "Q2": $("#NewPipeline_Q2").val(), "Q3": $("#NewPipeline_Q3").val(), "Q4": $("#NewPipeline_Q4").val(), "Qfiller": '<?php echo $_SESSION['ncareID_lwj']; ?>', },
					success: function(data) {
						$( "#Pipeline-form" ).dialog( "close" );
						alert("Add record sucessfully!");
						window.location.reload();
					}
				});
			},
			"Cancel": function() {
				$( "#Pipeline-form" ).dialog( "close" );
			}
		}
	});
	$( "#NewPipelineRecord" ).click(function() {
		var w = $("#slider_content9").width();
		$("#slider_scroll9").animate( { right:'-'+w+'px' }, 600 ,'swing');
		openVerificationForm('#Pipeline-form');
	});
	
    $( "#Pipeline-change" ).dialog({
		autoOpen: false,
		height: 210,
		width: 350,
		modal: true,
		buttons: {
			"Confirm replacement": function() {
				$.ajax({
					url: "class/nurseform02k_add.php",
					type: "POST",
					data: {"HospNo": $("#aHospNo").val(), "date": $("#adate_Pipeline").val(), "newdate": $("#newdate_Pipeline").val(), "status": '1', "PipelineNo": $("#aPipelineNo").val(), },
					success: function(data) {
						$( "#Pipeline-change" ).dialog( "close" );
						if (data=="1OK") {
							alert("Pipeline replaced");
						}
						document.location.reload(true);
						}
				});
			},
			"Cancel": function() {
				$( "#Pipeline-change" ).dialog( "close" );
			}
		}
    });
	
    $( "#Pipeline-remove" ).dialog({
		autoOpen: false,
		height: 200,
		width: 350,
		modal: true,
		buttons: {
			"Confirm Remove": function() {
				$.ajax({
					url: "class/nurseform02k_add.php",
					type: "POST",
					data: {"HospNo": $("#aHospNo").val(), "date": $("#adate_Pipeline").val(), "newdate":$("#Q4_"+$("#aHospNo").val()+"_"+$("#adate_Pipeline").val()+"_"+$("#aPipelineNo").val()).val(), "PipelineNo": $("#aPipelineNo").val(), "status": '2', },
					success: function(data) {
						if (data=="2OK") {
							alert("Pipeline removed");
						}
						document.location.reload(true);
					}
				});
			},
			"Cancel": function() {
				$( "#Pipeline-remove" ).dialog( "close" );
			}
		}
    });
});
</script>
<div class="nurseform-table">
<!---------------表單-------------------->
<div name="Pipeline-change" id="Pipeline-change" title="Replace Pipeline" class="dialog-form">
	<form>
	<fieldset>
		<table>
          <tr>
            <td class="title">Setup/replace date</td>
            <td><script> $(function() { $( "#newdate_Pipeline").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="newdate_Pipeline" id="newdate_Pipeline" value="<?php echo date("Y/m/d"); ?>" size="12"></td>
          </tr>
        </table>    	
        <input type="hidden" name="adate_Pipeline" id="adate_Pipeline">
        <input type="hidden" name="aHospNo" id="aHospNo">
		<input type="hidden" name="aPipelineNo" id="aPipelineNo">
	</fieldset>
	</form>
</div>
<div name="Pipeline-remove" id="Pipeline-remove" title="Remove Pipeline">
 <center>Confirm removed?</center>
</div>
<div id="Pipeline-form" title="Add Pipeline Record" class="dialog-form"> 
  <form>
  <fieldset>
    <table>
      <tr>
        <td class="title">Pipeline</td>
        <td>
           <select name="NewPipeline_Q1" id="NewPipeline_Q1">
	     <option></option>
              <option value="1">Catheter (Foley)</option>
	     <option value="2">Catheter - Cystostomy (Foley)</option>
	     <option value="3">Nasogastric tube (NG tube)</option>
	     <option value="4">Tracheal tube</option>
	     <option value="5">Gastrostomy</option>
	     <option value="6">Enterostomy</option>
	   </select>
	   <?php
	   $Pipeline_db0 = new DB;
	   $Pipeline_db0->query("SELECT `HospNo` FROM `patient` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."'");
	   $Pipeline_r0 = $Pipeline_db0->fetch_assoc();
	   ?>
	   <input type="hidden" name="NewPipeline_HospNo" id="NewPipeline_HospNo" value="<?php echo $Pipeline_r0['HospNo']; ?>">
        </td>
      </tr>
      <tr>
        <td class="title">Material</td>
        <td>
        <select name="NewPipeline_Q2" id="NewPipeline_Q2">
	    	<option></option>
        	<option value="1">General</option>
	    	<option value="2">Siliceous</option>
	    	<option value="3">Steel</option>
	    	<option value="4">PVC</option>
	    	<option value="5">Shillen</option>
	    </select>
        </td>
      </tr>
      <tr>
        <td class="title">Caliber</td>
        <td><input type="text" name="NewPipeline_Q3" id="NewPipeline_Q3" size="3" />Fr.</td>
      </tr>
      <tr>
        <td class="title">Setup/replace date</td>
        <td><script> $(function() { $( "#NewPipeline_date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="NewPipeline_date" id="NewPipeline_date" value="<?php echo date(Y."/".m."/".d); ?>" size="12"></td>
      </tr>
      <tr>
        <td class="title">Replacement cycle(days)</td>
        <td><select name="NewPipeline_Q4" id="NewPipeline_Q4"><option></option><option value="7">7days</option><option value="14">14days</option><option value="30">30days</option><option value="180">180days</option><option value="365">365days</option></select></td>
      </tr>
    </table>
  </fieldset>
  </form>
</div>
</div>

<?php
if($_GET['PipelineDate']!=""){
	$qdate_Pipeline = $_GET['PipelineDate'];
}else{
	$qdate_Pipeline = date(Ym);
}
?>
<?php
$pipeno = 12;
$Pipeline_dbno = new DB;
$Pipeline_dbno->query("SELECT * FROM `nurseform02k` WHERE `HospNo`='".$HospNo."' GROUP BY `PipelineNo`");
$pageno = ceil($Pipeline_dbno->num_rows()/$pipeno);
$URL_PipelineDate = $qdate_Pipeline;
$URL_PipelineDate_Year = substr($URL_PipelineDate,0,4);
$URL_PipelineDate_Month = substr($URL_PipelineDate,4,2);
$Previous_Month = $URL_PipelineDate_Month-1;
$Next_Month = $URL_PipelineDate_Month+1;
if($Previous_Month==0){
	$Previous_Month = "12";
	$Previous_Month_Year = $URL_PipelineDate_Year-1;
}else{
	$Previous_Month_Year = $URL_PipelineDate_Year;
}
if (strlen((int)$Previous_Month)==1) {
	$Previous_Month = "0".$Previous_Month;
}
if($Next_Month==13){
	$Next_Month = "1";
	$Next_Month_Year = $URL_PipelineDate_Year+1;
}else{
	$Next_Month_Year = $URL_PipelineDate_Year;
}
if (strlen((int)$Next_Month)==1) {
	$Next_Month = "0".$Next_Month;
}
$URL_PipelineDate_Previous = $URL_Pipeline."PipelineDate=".$Previous_Month_Year.$Previous_Month;
$URL_PipelineDate_Next = $URL_Pipeline."PipelineDate=".$Next_Month_Year.$Next_Month;
?>
<div style="font-size:10pt; background-color: rgba(255,255,255,0.7); border-radius: 10px; padding: 0% 2%; margin-bottom:0px; min-width:960px;">
<div align="center" style="padding-top:15px; min-width:900px;"><h3 style="color:#69b3b6;"><a style="font-size:20px; color:rgb(238,203,53);" href="<?php echo $URL_PipelineDate_Previous;?>"><i class="fa fa-chevron-circle-left"></i> Previous</a><font style="padding-left:50px; padding-right:50px;"><?php echo substr($qdate_Pipeline,0,4).' / '.substr($qdate_Pipeline,4,2); ?> Pipeline Management</font><a style="font-size:20px; color:rgb(238,203,53);" href="<?php echo $URL_PipelineDate_Next;?>">Next <i class="fa fa-chevron-circle-right"></i></a></h3></div>
<div style="overflow-x:auto; text-align:center; margin-bottom:0px;">
<?php
if($Pipeline_dbno->num_rows()!=0){
for ($page=1;$page<=$pageno;$page++) {
	$startno = ($page-1)*$pipeno;
	$Pipeline_rowno = $pageno*$pipeno;
?>
<div align="left"><form><input type="button" id="NewPipelineRecord" value="Add Pipeline Record" style="margin-right:7.7%"/></form></div>
<table width="100%">
  <tr height="20" style="background-color:rgba(255,255,255,0.8);">
    <td style="background-color:rgba(105,179,182,0.9); color:white;" width="60">Bed #</td>
    <td width="80"><?php echo $bedID; ?></td>
    <td style="background-color:rgba(105,179,182,0.9); color:white;" width="60">Full name</td>
    <td width="80"><?php echo $name; ?></td>
    <td style="background-color:rgba(105,179,182,0.9); color:white;" width="60">Care ID#</td>
    <td width="80"><?php echo $HospNo; ?></td>
    <td style="background-color:rgba(105,179,182,0.9); color:white;" width="60">DOB</td>
    <td width="180"><?php echo $birth.' ('.checkgender(mysql_escape_string($_GET['pid'])).', '.calcage(str_replace('/','',$birth)).')'; ?></td>
    <td style="background-color:rgba(105,179,182,0.9); color:white;" width="80">Admission date</td>
    <td width="80"><?php echo $indate; ?></td>
  </tr>
</table>
<table style="text-align:center;">
  <tr style="background-color:rgba(105,179,182,0.9); color:white;" height="30">
    <td width="30">First Date (Replacement cycle)<br>(Next Date)</td>
    <td width="100">Pipeline<br>(Material)<br>(Caliber)</td>
    <?php
	echo drawmedcalwithtext($qdate_Pipeline);
	?>
  </tr>
  <?php
  $PipelineShowOrder=1;
  $Pipeline_filter_db = new DB;
  $Pipeline_filter_db->query("SELECT * FROM `nurseform02k` WHERE `HospNo`='".$HospNo."' AND `No`='1' ORDER BY `PipelineNo`");  //第一次
  if ($page == $pageno) { $stopno = $Pipeline_filter_db->num_rows(); } else { $stopno = $pipeno; }
  for($i=0;$i<$stopno;$i++){
	  $Pipeline_filter = $Pipeline_filter_db->fetch_assoc();
	  $Pipeline_filter_db2 = new DB;
	  $Pipeline_filter_db2->query("SELECT * FROM `nurseform02k` WHERE `HospNo`='".$HospNo."' AND `PipelineNo`='".$Pipeline_filter['PipelineNo']."' ORDER BY `date` DESC LIMIT 0,1");  //最後一次
	  $Pipeline_filter2 = $Pipeline_filter_db2->fetch_assoc();
	  if($Pipeline_filter2['date']<($qdate_Pipeline.'01')){   //最後日期在上個月
		  if($Pipeline_filter2['Q4']!='' && $Pipeline_filter2['Q5']==0){  // 計算下次換管日期，如果換管日期在這個月，顯示資料
			  $countday = calcdayafterday($Pipeline_filter2['date'],$Pipeline_filter2['Q4']);
			  $countday2 = str_replace("/","",$countday);
			  if($countday2>=($qdate_Pipeline.'01') && $countday2<=($qdate_Pipeline.'31')){
			      $Pipeline_filter['date'] = substr($Pipeline_filter['date'],0,4)."/".substr($Pipeline_filter['date'],4,2)."/".substr($Pipeline_filter['date'],6,2);
				  $PipelineShowOrder++;
				  echo '
				  <tr height="24" style="background-color:rgba(255,255,255,0.8);">
				      <td style="white-space:nowrap;">'.$Pipeline_filter['date'].'<br>('.$Pipeline_filter['Q4'].')<br>('.$countday.')</td>
				      <td style="white-space:nowrap;">'.$arrForm2k_Q1[$Pipeline_filter['Q1']].'<br>('.$arrForm2k_Q2[$Pipeline_filter['Q2']].')<br>('.$Pipeline_filter['Q3'].' Fr.)</td>
				      '.drawPipeline($HospNo,$Pipeline_filter['PipelineNo'],$countday,$PipelineShowOrder,$qdate_Pipeline).'
				  </tr>'."\n";
			  }
		  }
	  }elseif($Pipeline_filter2['date']>=($qdate_Pipeline.'01') && $Pipeline_filter2['date']<=($qdate_Pipeline.'31')){   //最後日期在這個月   顯示資料
		  if($Pipeline_filter2['Q4']==""){
			  $countday = "----/--/--";
			  $Pipeline_filter['Q4'] = "-";
		  }elseif($Pipeline_filter2['Q5']=="2"){
			  $countday = "Removed";
		  }else{
			  $countday = calcdayafterday($Pipeline_filter2['date'],$Pipeline_filter2['Q4']);
		  }
		  $Pipeline_filter['date'] = substr($Pipeline_filter['date'],0,4)."/".substr($Pipeline_filter['date'],4,2)."/".substr($Pipeline_filter['date'],6,2);
		  $PipelineShowOrder++;
		  echo '
		  <tr height="24" style="background-color:rgba(255,255,255,0.8);">
		      <td style="white-space:nowrap;">'.$Pipeline_filter['date'].'<br>('.$Pipeline_filter['Q4'].')<br>('.$countday.')</td>
		      <td style="white-space:nowrap;">'.$arrForm2k_Q1[$Pipeline_filter['Q1']].'<br>('.$arrForm2k_Q2[$Pipeline_filter['Q2']].')<br>('.$Pipeline_filter['Q3'].' Fr.)</td>
		      '.drawPipeline($HospNo,$Pipeline_filter['PipelineNo'],$countday,$PipelineShowOrder,$qdate_Pipeline).'
		  </tr>'."\n";
	  }else{ //最後日期在這個月之後
		  if($Pipeline_filter['date']<=($qdate_Pipeline.'31')){   //判斷第一次日期在什麼時候，如果在這個月31以前，顯示資料
		      if($Pipeline_filter2['Q4']==""){
			      $countday = "----/--/--";
			      $Pipeline_filter['Q4'] = "-";
		      }elseif($Pipeline_filter2['Q5']=="2"){
			      $countday = "Removed";
		      }else{
			      $countday = calcdayafterday($Pipeline_filter2['date'],$Pipeline_filter2['Q4']);
		      }
			  $Pipeline_filter['date'] = substr($Pipeline_filter['date'],0,4)."/".substr($Pipeline_filter['date'],4,2)."/".substr($Pipeline_filter['date'],6,2);
			  $PipelineShowOrder++;
			  echo '
			  <tr height="24" style="background-color:rgba(255,255,255,0.8);">
			      <td style="white-space:nowrap;">'.$Pipeline_filter['date'].'<br>('.$Pipeline_filter['Q4'].')<br>('.$countday.')</td>
			      <td style="white-space:nowrap;">'.$arrForm2k_Q1[$Pipeline_filter['Q1']].'<br>('.$arrForm2k_Q2[$Pipeline_filter['Q2']].')<br>('.$Pipeline_filter['Q3'].' Fr.)</td>
			      '.drawPipeline($HospNo,$Pipeline_filter['PipelineNo'],$countday,$PipelineShowOrder,$qdate_Pipeline).'
			  </tr>'."\n";
		  }
	  }
  }
  if ($pageno == $page && $Pipeline_filter_db->num_rows()<$pipeno) {
	  $addspaceno = $pipeno - $Pipeline_filter_db->num_rows();
	  for ($k=0;$k<$addspaceno;$k++) {
  ?>
  <tr height="24" style="background-color:rgba(255,255,255,0.8);">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <?php echo drawPipeline('','','','',$qdate_Pipeline); ?>
  </tr>
  <?php
	  }
  }
  ?>
</table>
<br>
<script>
function confirmStatus_Pipeline(id, status) {
	var postinfo = id.split(/_/);
	if(status==1){
		if($("#Q4_"+postinfo[1]+"_"+postinfo[2]+"_"+postinfo[3]).val()==""){
			$("#newdate_Pipeline").val();
		}else{
			$("#newdate_Pipeline").val($("#Q4_"+postinfo[1]+"_"+postinfo[2]+"_"+postinfo[3]).val());
		}
		$("#adate_Pipeline").val(postinfo[2]);
		$("#aHospNo").val(postinfo[1]);
		$("#aPipelineNo").val(postinfo[3]);
		var w = $("#slider_content9").width();
		$("#slider_scroll9").animate( { right:'-'+w+'px' }, 600 ,'swing');
		openVerificationForm('#Pipeline-change');
	}else if(status==2){
		$("#adate_Pipeline").val(postinfo[2]);
		$("#aHospNo").val(postinfo[1]);
		$("#aPipelineNo").val(postinfo[3]);
		var w = $("#slider_content9").width();
		$("#slider_scroll9").animate( { right:'-'+w+'px' }, 600 ,'swing');
		openVerificationForm('#Pipeline-remove');
	}
}
</script>
<?php
}
}else{
	echo '<div><p style="font-size:20px;">no data</p></div>';
}
?>
</div></div>