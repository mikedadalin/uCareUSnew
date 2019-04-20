<script>
$(function() {
    $( "#newrecordform" ).dialog({
		autoOpen: false,
		height: 680, //770
		width: 800,
		modal: true,
		buttons: {
			"Add resident's record": function() {
				$.ajax({
					url: "class/socialform15.php",
					type: "POST",
					data: {
						"HospNo": $("#HospNo").val(),
						"date": $("#date").val(),
						"formID":"socialform15",
						"Q1_1": $("#Q1_1").val(),"Q1_2": $("#Q1_2").val(),"Q1_3": $("#Q1_3").val(),"Q1_4": $("#Q1_4").val(),"Q1a": $("#Q1a").val(),
						"Q2_1": $("#Q2_1").val(),"Q2_2": $("#Q2_2").val(),"Q2_3": $("#Q2_3").val(),"Q2_4": $("#Q2_4").val(),"Q2a": $("#Q2a").val(),
						"Q2_5": $("#Q2_5").val(),"Q2_6": $("#Q2_6").val(),"Q2_7": $("#Q2_7").val(),"Q2_8": $("#Q2_8").val(),"Q2_9": $("#Q2_9").val(),
						"Q2_10": $("#Q2_10").val(),"Q2_11": $("#Q2_11").val(),"Q2_12": $("#Q2_12").val(),
						"Q3_1": $("#Q3_1").val(),"Q3_2": $("#Q3_2").val(),"Q3_3": $("#Q3_3").val(),"Q3_4": $("#Q3_4").val(),"Q3a": $("#Q3a").val(),
						"Q3_5": $("#Q3_5").val(),"Q3_6": $("#Q3_6").val(),"Q3_7": $("#Q3_7").val(),"Q3_8": $("#Q3_8").val(),"Q3_9": $("#Q3_9").val(),
						"Q3_10": $("#Q3_10").val(),
						"Q4_1": $("#Q4_1").val(),"Q4_2": $("#Q4_2").val(),"Q4_3": $("#Q4_3").val(),"Q4_4": $("#Q4_4").val(),"Q4a": $("#Q4a").val(),
						"Qinteraction": $("#Qinteraction").val(), 
						"Qcontent": $("#Qcontent").val(), 
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
		window.open('print.php?mod=socialwork&func=formview&pid=<?php echo $_GET['pid']; ?>&id=15&date1='+date1+'&date2='+date2);
	} else if (functioname=='view') {
		window.location.href='index.php?mod=socialwork&func=formview&pid=<?php echo $_GET['pid']; ?>&id=15&date1='+date1+'&date2='+date2;
	}
}
</script>
<div id="newrecordform" title="新增個案服務紀錄表" class="dialog-form">
	<form id="socialform15">
	<fieldset>
		<table>
			<tr>
			    <td class="title">Date</td>
			    <td><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php echo date(Y."/".m."/".d); ?>" size="12"></td>
		         </tr>
			<tr>
			    <td class="title">訪談方式</td>
			    <td><?php echo draw_option("Q1","電訪;家訪;面談;Other","m","single",$Q1,false,5); ?>&nbsp;<input type="text" name="Q1a" id="Q1a" size="20"></td>
			</tr>
			<tr>
			    <td class="title">訪談對象</td>
			    <td><?php echo draw_option("Q2","Family;案主;Relative(s);Physician;Nursing;physiotherapist;Nursing assistant;社福機構;慈善單位;居服員;志工;Other","m","multi",$Q2,true,5); ?>&nbsp;<input type="text" name="Q2a" id="Q2a" size="20"></td>
			</tr>
			<tr>
			    <td class="title">問題分類</td>
			    <td><?php echo draw_option("Q3","Emotions;醫療;病況;居家服務;家庭關係;室友關係;關懷慰問;經濟;權益保障;Other","m","multi",$Q3,true,5); ?>&nbsp;<input type="text" name="Q3a" id="Q3a" size="20"></td>
			</tr>
			<tr>
			    <td class="title">Location</td>
			    <td><?php echo draw_option("Q4","本中心;案家;Hospital;Other","m","single",$Q4,false,5); ?>&nbsp;<input type="text" name="Q4a" id="Q4a" size="20"></td>
			</tr>
            <tr>
			    <td class="title">Counseling/interaction content</td>
			    <td><textarea name="Qinteraction" id="Qinteraction" cols="50" rows="5"></textarea></td>
			</tr>
			<tr>
				<td class="title">未來輔導計畫或建議</td>
				<td>
                <textarea name="Qcontent" id="Qcontent" cols="50" rows="5"></textarea>
                <input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
				<input type="hidden" name="Qfiller" id="Qfiller" value="<?php echo $_SESSION['ncareID_lwj']; ?>">
                </td>
			</tr>
		</table>
	</fieldset>
    </form>
</div>
<h3>個案服務記錄表(二)</h3>
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
    <td width="80">Date</td>
    <td colspan="2">&nbsp;</td>
    <td class="printcol" width="120">Function</td>
  </tr>
  </thead>
  <tbody>
  <?php
  if ($_GET['date1']!=NULL && $_GET['date2']!=NULL) {
	  $sql1 = "SELECT * FROM `socialform15` WHERE `HospNo`='".$HospNo."' AND (`date` BETWEEN '".mysql_escape_string($_GET['date1'])."' AND '".mysql_escape_string($_GET['date2'])."') ORDER BY `date` DESC";
  } else {
	  $sql1 = "SELECT * FROM `socialform15` WHERE `HospNo`='".$HospNo."' ORDER BY `date` DESC";
  }
  $db2 = new DB;
  $db2->query($sql1);
  for ($i=0;$i<$db2->num_rows();$i++) {
 	$r2 = $db2->fetch_assoc();
	echo '
  <tr>
    <td rowspan="3" class="title" width="120">'.formatdate($r2['date']).'<br>星期'.$arrPHPDay[date("D",strtotime(formatdate($r2['date'])))].'</td>
	<td class="title_s" width="120">Counseling/interaction content</td>
	<td>'.$r2['Qinteraction'].'</td>
	<td rowspan="3" class="printcol"><form><input type="button" id="edit_'.$HospNo.'_'.$r2['date'].'_'.$r2['no'].'" onclick="window.location.href=\'index.php?mod=socialwork&func=formview&pid='.@$_GET['pid'].'&id=15_1&no='.$r2['no'].'&date='.$r2['date'].'\'" value="Edit"><br><input type="button" id="delete_'.$HospNo.'_'.$r2['date'].'_'.$r2['no'].'" onclick="confirmdelete(this.id);" value="Delete"></form></td>
  </tr>
  <tr>
    <td class="title_s">未來輔導計畫或建議</td>
	<td>'.$r2['Qcontent'].'</td>
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
			data: {"HospNo": postinfo[1], "date": postinfo[2], "no": postinfo[3],"formID":"socialform15" },
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