<script>
$(function() {
    $( "#dialog-form" ).dialog({
		autoOpen: false,
		height: 390,
		width: 460,
		modal: true,
		buttons: {
			"Add pipeline records": function() {
				$.ajax({
					url: "class/nurseform02k.php",
					type: "POST",
					data: {"HospNo": $("#HospNo").val(), "date": $("#date").val(), "Q1": $("#Q1").val(), "Q2": $("#Q2").val(),"Q3": $("#Q3").val(),"Q4": $("#Q4").val(), "Qfiller": '<?php echo $_SESSION['ncareID_lwj']; ?>' },
					success: function(data) {
						$( "#dialog-form" ).dialog( "close" );
						alert("Add record sucessfully!");
						window.location.reload();
					}
				});
			},
			"Cancel": function() {
				$( "#dialog-form" ).dialog( "close" );
			}
		}
	});
	$( "#newrecord" ).click(function() {
		$( "#dialog-form" ).dialog( "open" );
	});
    $( "#dialog-change" ).dialog({
		autoOpen: false,
		height: 210,
		width: 350,
		modal: true,
		buttons: {
			"Confirm replacement": function() {
				$.ajax({
					url: "class/nurseform02k_add.php",
					type: "POST",
					data: {"HospNo": $("#aHospNo").val(), "date": $("#adate").val(), "newdate": $("#newdate").val(), "status": "1", "PipelineNo": $("#aPipelineNo").val() },
					success: function(data) {
						$( "#dialog-change" ).dialog( "close" );
						if (data=="1OK") {
							alert("Pipeline replaced");
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
</script>
<h3>Pipeline management</h3>
<div id="dialog-change" title="Replace Pipeline" class="dialog-form">
	<form>
	<fieldset>	
		<table>
	        <tr>
	           <td class="title">Setup/replace date</td>
	           <td><script> $(function() { $( "#newdate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="newdate" id="newdate" value="<?php echo date("Y/m/d"); ?>" size="12"></td>
	        </tr>
	    </table>    	
	    <input type="hidden" name="adate" id="adate">
	    <input type="hidden" name="aHospNo" id="aHospNo">
		<input type="hidden" name="aPipelineNo" id="aPipelineNo">
	</fieldset>
	</form>
</div>
<div id="dialog-form" title="Add pipeline records" class="dialog-form"> 
	  <form>
	  <fieldset>
	    <table>
	      <tr>
	        <td class="title">Pipeline</td>
	        <td>
	           <select name="Q1" id="Q1">
		     <option></option>
	              <option value="1">Catheter (Foley)</option>
		     <option value="2">Catheter - Cystostomy (Foley)</option>
		     <option value="3">Nasogastric tube (NG tube)</option>
		     <option value="4">Tracheal tube</option>
		     <option value="5">Gastrostomy</option>
		     <option value="6">Enterostomy</option>
		   </select>
		   <input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
	        </td>
	      </tr>
	      <tr>
	        <td class="title">Material</td>
	        <td>
	        <select name="Q2" id="Q2">
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
	        <td><input type="text" name="Q3" id="Q3" size="3" />Fr.</td>
	      </tr>
	      <tr>
	        <td class="title">Setup/replace date</td>
	        <td><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php echo date(Y."/".m."/".d); ?>" size="12"></td>
	      </tr>
	      <tr>
	        <td class="title">Replacement cycle(days)</td>
	        <td><select name="Q4" id="Q4"><option></option><option value="7">7days</option><option value="14">14days</option><option value="30">30days</option><option value="180">180days</option><option value="365">365days</option></select></td>
	      </tr>
	    </table>
	  </fieldset>
	  </form>
</div>
<form>
<div align="left"><input type="button" id="newrecord" value="Add pipeline records" style="height:32px;" /></div>
<table width="100%" id="recordlist">
  <thead>
  <tr class="title">
    <td>Pipeline</td>
    <td>Material</td>
    <td>Caliber</td>
    <td>Setup/replace date</td>
    <td>Replacement cycle(days)</td>
    <td width="132px;">Next expected replacement date</td>
    <td width="132px;">Status</td>
    <td>Delete</td>
  </tr>
  </thead>
  <tbody>
    <?php
    $db2 = new DB;
    $db2->query("SELECT * FROM `nurseform02k` WHERE `HospNo`='".$HospNo."' ORDER BY `date` DESC");
    for ($i=0;$i<$db2->num_rows();$i++) {
 	$r2 = $db2->fetch_assoc();
	$countday = $r2['Q4']!= "" ? calcdayafterday($r2['date'],$r2['Q4']):"";
	echo '
  <tr>
    <td><center>'.$arrForm2k_Q1[$r2['Q1']].'</center></td>
    <td><center>'.$arrForm2k_Q2[$r2['Q2']].'</center></td>
    <td><center>'.$r2['Q3']; if ($r2['Q3']!="") { echo 'Fr.'; } echo '</center></td>
    <td><center>'.formatdate($r2['date']).'</center></td>
	<td><center>'.$r2['Q4'].'</center></td>
	<td><center>'.$countday.'<input type="hidden" id="Q4_'.$HospNo.'_'.$r2['date'].'_'.$r2['PipelineNo'].'" value="'.$countday.'">'.'</center></td>
	<td><center>';
	if ($r2['Q5']==0) {
		echo '<input type="button" id="status_'.$HospNo.'_'.$r2['date'].'_'.$r2['PipelineNo'].'" onclick="confirmStatus(this.id,1);" value="Replace pipeline">';
		echo '<input type="button" id="status_'.$HospNo.'_'.$r2['date'].'_'.$r2['PipelineNo'].'" onclick="confirmStatus(this.id,2);" value="Remove pipeline">';
	} else if($r2['Q5']==2){
		echo 'Removed';
	} else {
		echo 'Replaced';
	}
    echo '
	</center></td>
	<td><center>';
	if ($r2['Qfiller']==$_SESSION['ncareID_lwj']) {
		echo '<input type="button" id="delete_'.$HospNo.'_'.$r2['date'].'_'.$r2['PipelineNo'].'" onclick="confirmdelete(this.id);" value="Delete">';
	} else {
		echo '&nbsp;';
	}
	}
    echo '
	</center></td>
  </tr>
	'."\n";
    ?>
  </tbody>
</table>
</form><br><br>
<script>
function confirmStatus(id, status) {
	if (status==1) {
		var msg = 'Confirm replacement?';
	} else {
		var msg = 'Confirm removed?';
	}
	if (confirm(msg)) {
		var postinfo = id.split(/_/);
		if(status==1){
			$( "#dialog-change" ).dialog( "open" );
			if($("#Q4_"+postinfo[1]+"_"+postinfo[2]+"_"+postinfo[3]).val()==""){
				$("#newdate").val();
			}else{
				$("#newdate").val($("#Q4_"+postinfo[1]+"_"+postinfo[2]+"_"+postinfo[3]).val());
			}
			
			$("#adate").val(postinfo[2]);
			$("#aHospNo").val(postinfo[1]);
			$("#aPipelineNo").val(postinfo[3]);
		}else if(status==2){
			$.ajax({
				url: "class/nurseform02k_add.php",
				type: "POST",
				data: {"HospNo": postinfo[1], "date": postinfo[2],"newdate":$("#Q4_"+postinfo[1]+"_"+postinfo[2]+"_"+postinfo[3]).val(), "PipelineNo": postinfo[3], "status": status },
				success: function(data) {
					if (data=="1OK") {
						alert("Pipeline replaced");
					} else if (data=="2OK") {
						alert("Pipeline removed");
					}
					document.location.reload(true);
				}
			});
		}
	}
}
function confirmdelete(id) {
	if (confirm('Confirm delete?')) {
		var postinfo = id.split(/_/);
		$.ajax({
			url: "class/nurseform02k_delete.php",
			type: "POST",
			data: {"HospNo": postinfo[1], "date": postinfo[2] },
			success: function(data) {
				alert("Deletion success");
				document.location.reload(true);
			}
		});
	} else {
		alert('Deletion canceled');
	}
}

</script>