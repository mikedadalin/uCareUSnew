<script>
$(function() {
    $( "#newrecordform" ).dialog({
		autoOpen: false,
		height: 510,
		width: 700,
		modal: true,
		buttons: {
			"Add resident's record": function() {
				$.ajax({
					url: "class/socialform15.php",
					type: "POST",
					data: {
						"HospNo": $("#HospNo").val(),
						"date": $("#date").val(),
						"formID":"socialform17",
						"timeH": $("#timeH").val(), "timeI": $("#timeI").val(),
						"Q1_1": $("#Q1_1").val(),"Q1_2": $("#Q1_2").val(),"Q1_3": $("#Q1_3").val(),"Q1_4": $("#Q1_4").val(),"Q1a": $("#Q1a").val(),
						"Q1_5": $("#Q1_5").val(),"Q1_6": $("#Q1_6").val(),"Q1_7": $("#Q1_7").val(),"Q1_8": $("#Q1_8").val(),"Q1_9": $("#Q1_9").val(),
						"Q1_10": $("#Q1_10").val(),"Q2": $("#Q2").val(),"Q3": $("#Q3").val(),
						"Qinteraction": $("#Qinteraction").val(), 
						"Qfiller": $("#Qfiller").val()  
					},
					success: function(data) {
						$( "#newrecordform" ).dialog( "close" );
						window.location.reload();
					}
				});
			},
			"Cancel": function() {
				$( "#newrecordform" ).dialog( "close" );
			}
		}
	});
});function datefunction(functioname) {
	var date1 = (document.getElementById('printdate1').value).replace("/",""); date1 = date1.replace("/","");
	var date2 = (document.getElementById('printdate2').value).replace("/",""); date2 = date2.replace("/","");
	if (functioname=='print') {
		window.open('print.php?mod=socialwork&func=formview&pid=<?php echo $_GET['pid']; ?>&id=17&date1='+date1+'&date2='+date2);
	} else if (functioname=='view') {
		window.location.href='index.php?mod=socialwork&func=formview&pid=<?php echo $_GET['pid']; ?>&id=17&date1='+date1+'&date2='+date2;
	}
}
</script>
<div id="newrecordform" title="新增個案家屬服務工作紀錄表" class="dialog-form">
	<form id="socialform17">
	<fieldset>
		<table>
			<tr>
			    <td class="title">服務日期</td>
			    <td><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php echo date(Y."/".m."/".d); ?>" size="12"> <select name="timeH" id="timeH">
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
			    <td class="title">服務類別</td>
			    <td><?php echo draw_option("Q1","照顧問題;家庭支持;費用問題;節慶活動;問卷填寫;個案就醫;資源協助;諮詢服務;轉介服務;Other","m","multi",$Q1,true,5); ?>&nbsp;<input type="text" name="Q1a" id="Q1a" size="20"></td>
			</tr>
			<tr>
			    <td class="title">Family</td>
			    <td><input type="text" name="Q2" id="Q2" size="20"></td>
			</tr>
			<tr>
			    <td class="title">relationship</td>
			    <td><input type="text" name="Q3" id="Q3" size="20"></td>
			</tr>
            <tr>
			    <td class="title">會談摘要</td>
			    <td><textarea name="Qinteraction" id="Qinteraction" cols="50" rows="5"></textarea></td>
			</tr>
                <input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
				<input type="hidden" name="Qfiller" id="Qfiller" value="<?php echo $_SESSION['ncareID_lwj']; ?>">
		</table>
	</fieldset>
    </form>
</div>
<h3>個案家屬服務工作紀錄(二)</h3>
<?php
$url = $_SERVER['PHP_SELF'];
$url = explode(".",$url);
$url = explode("/",$url[0]);
$file = $url[2];
?>
<div align="right" class="printcol"><form>Select date:<script> $(function() { $( "#printdate1").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="printdate1" id="printdate1" value="<?php if (@$_GET['date1']==NULL) { echo date(Y."/".m."/01"); } else { echo formatdate(@$_GET['date1']); } ?>" size="12"> ~ <script> $(function() { $( "#printdate2").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="printdate2" id="printdate2" value="<?php if (@$_GET['date2']==NULL) { echo date(Y."/".m."/01"); } else { echo formatdate(@$_GET['date2']); } ?>" size="12"> <input type="button" value="Search" onclick="datefunction('view');" /> <input type="button" value="Print" onclick="datefunction('print');" /> <input type="button" id="newrecord" value="Add resident's record" onclick="openVerificationForm('#newrecordform');" /></form></div>
<table width="100%" id="newrecordtable">
  <thead>
  <tr class="title">
    <td width="80">Date<br />Time</td>
    <td colspan="2">&nbsp;</td>
    <td class="printcol" width="120">Function</td>
  </tr>
  </thead>
  <tbody>
  <?php
  if ($_GET['date1']!=NULL && $_GET['date2']!=NULL) {
	  $sql1 = "SELECT * FROM `socialform17` WHERE `HospNo`='".$HospNo."' AND (`date` BETWEEN '".mysql_escape_string($_GET['date1'])."' AND '".mysql_escape_string($_GET['date2'])."') ORDER BY `date` DESC";
  } else {
	  $sql1 = "SELECT * FROM `socialform17` WHERE `HospNo`='".$HospNo."' ORDER BY `date` DESC";
  }
  $db2 = new DB;
  $db2->query($sql1);
  for ($i=0;$i<$db2->num_rows();$i++) {
 	$r2 = $db2->fetch_assoc();
		foreach ($r2 as $k=>$v) {
			if (substr($k,0,1)=="Q") {
				$arrAnswer = explode("_",$k);
				if (count($arrAnswer)==2) {
					if ($v==1) {
						${$arrAnswer[0]} .= $arrAnswer[1].';';
					}
				} else {
					${$k} = $v;
				}
			}  else {
				${$k} = $v;
			}
		}
	
	echo '
  <tr>
    <td rowspan="3" class="title" width="120">'.formatdate($r2['date']).($r2['time']!="00:00:00"?'<br>'.$r2['time']:"").'<br><br>'.$r2['Qproblem'].'</td>
	<td class="title_s" width="80">服務類別</td>
	<td>'.option_result("Q1","照顧問題;家庭支持;費用問題;節慶活動;問卷填寫;個案就醫;資源協助;諮詢服務;轉介服務;Other","m","single",$Q1,true,5).($r2['Q1a']!=""?"：".$r2['Q1a']:"").'</td>
	<td rowspan="3" class="printcol"><form><input type="button" id="edit_'.$HospNo.'_'.$r2['date'].'_'.$r2['no'].'" onclick="window.location.href=\'index.php?mod=socialwork&func=formview&pid='.@$_GET['pid'].'&id=17_1&no='.$r2['no'].'&date='.$r2['date'].'\'" value="Edit"><br><input type="button" id="delete_'.$HospNo.'_'.$r2['date'].'_'.$r2['no'].'" onclick="confirmdelete(this.id);" value="Delete"></form></td>
  </tr>
  <tr>
    <td class="title_s">會談摘要</td>
	<td>'.$r2['Qinteraction'].'</td>
  </tr>
  <tr>
    <td class="title_s">Filled by</td>
	<td>'.checkusername($r2['Qfiller']).'</td>
  </tr>
  <tr class="noShowCol">
	<td style="border-style:none;" colspan="2">社工：</td>
	<td style="border-style:none;">主任：</td>
  </tr>
  '."\n";
  }
  ?>
  </tbody>
</table>
<script>
function confirmdelete(id) {
	if (confirm('Confirm delete?')) {
		var postinfo = id.split(/_/);
		$.ajax({
			url: "class/socialform15_delete.php",
			type: "POST",
			data: {"HospNo": postinfo[1], "date": postinfo[2], "no": postinfo[3],"formID":"socialform17" },
			success: function(data) {
				confirm("Deletion success");
				document.location.reload(true);
			}
		});
	} else {
		alert('Deletion canceled');
	}
}
</script>