<script>
$(function() {
    $( "#newrecordform" ).dialog({
		autoOpen: false,
		height: 550,
		width: 760,
		modal: true,
		buttons: {
			"Add resident's record": function() {
				$.ajax({
					url: "class/socialform15.php",
					type: "POST",
					data: {
						"HospNo": $("#HospNo").val(),
						"date": $("#date").val(),
						"formID":"socialform18",
						"timeH": $("#timeH").val(), "timeI": $("#timeI").val(),
						"Q1_1": $("#Q1_1").val(),"Q1_2": $("#Q1_2").val(),"Q1_3": $("#Q1_3").val(),"Q1_4": $("#Q1_4").val(),"Q1a": $("#Q1a").val(),
						"Q1_5": $("#Q1_5").val(),"Q1_6": $("#Q1_6").val(),"Q1_7": $("#Q1_7").val(),"Q1_8": $("#Q1_8").val(),"Q1_9": $("#Q1_9").val(),
						"Q1_10": $("#Q1_10").val(),"Q1_11": $("#Q1_11").val(),"Q1_12": $("#Q1_12").val(),
						"Q2_1": $("#Q2_1").val(),"Q2_2": $("#Q2_2").val(),"Q2_3": $("#Q2_3").val(),
						"Q3_1": $("#Q3_1").val(),"Q3_2": $("#Q3_2").val(),"Q3_3": $("#Q3_3").val(),
						"Q4_1": $("#Q4_1").val(),"Q4_2": $("#Q4_2").val(),"Q4_3": $("#Q4_3").val(),
						"Q5_1": $("#Q5_1").val(),"Q5_2": $("#Q5_2").val(),"Q5_3": $("#Q5_3").val(),
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
		window.open('print.php?mod=socialwork&func=formview&pid=<?php echo $_GET['pid']; ?>&id=18&date1='+date1+'&date2='+date2);
	} else if (functioname=='view') {
		window.location.href='index.php?mod=socialwork&func=formview&pid=<?php echo $_GET['pid']; ?>&id=18&date1='+date1+'&date2='+date2;
	}
}
</script>
<div id="newrecordform" title="新增個案服務工作紀錄表" class="dialog-form">
	<form id="socialform18">
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
			    <td class="title">工作內容</td>
			    <td><?php echo draw_option("Q1","例行訪視;評估量表;照顧問題;節慶活動;就醫協助;醫院探訪;個案支持;諮商輔導;適應協助;轉介安置;資源協助;經濟問題;Other","m","multi",$Q1,true,5); ?>&nbsp;<input type="text" name="Q1a" id="Q1a" size="20"></td>
			</tr>
			<tr>
			    <td class="title">行為觀察</td>
			    <td>
                	意識：<?php echo draw_option("Q2","Clear;Fair;Poor","m","single",$Q2,false,5); ?><br>
                    表達：<?php echo draw_option("Q3","Clear;Fair;Poor","m","single",$Q3,false,5); ?><br>
                    行動：<?php echo draw_option("Q4","Clear;Fair;Poor","m","single",$Q4,false,5); ?><br>
                    情緒：<?php echo draw_option("Q5","Clear;Fair;Poor","m","single",$Q5,false,5); ?>
                </td>
			</tr>
            <tr>
			    <td class="title">Treatment summary</td>
			    <td><textarea name="Qinteraction" id="Qinteraction" cols="50" rows="5"></textarea></td>
			</tr>
                <input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
				<input type="hidden" name="Qfiller" id="Qfiller" value="<?php echo $_SESSION['ncareID_lwj']; ?>">
		</table>
	</fieldset>
    </form>
</div>
<h3>個案服務工作紀錄表</h3>
<?php
$url = $_SERVER['PHP_SELF'];
$url = explode(".",$url);
$url = explode("/",$url[0]);
$file = $url[2];
?>
<div align="right" class="printcol"><form>Select date:<script> $(function() { $( "#printdate1").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="printdate1" id="printdate1" value="<?php if (@$_GET['date1']==NULL) { echo date(Y."/".m."/01"); } else { echo formatdate(@$_GET['date1']); } ?>" size="12"> ~ <script> $(function() { $( "#printdate2").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="printdate2" id="printdate2" value="<?php if (@$_GET['date2']==NULL) { echo date(Y."/".m."/01"); } else { echo formatdate(@$_GET['date2']); } ?>" size="12"> <input type="button" value="Search" onclick="datefunction('view');" /> <input type="button" value="Print" onclick="datefunction('print');" /> <input type="button" id="newrecord" value="新增個案服務紀錄" onclick="openVerificationForm('#newrecordform');" /></form></div>
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
	  $sql1 = "SELECT * FROM `socialform18` WHERE `HospNo`='".$HospNo."' AND (`date` BETWEEN '".mysql_escape_string($_GET['date1'])."' AND '".mysql_escape_string($_GET['date2'])."') ORDER BY `date` DESC";
  } else {
	  $sql1 = "SELECT * FROM `socialform18` WHERE `HospNo`='".$HospNo."' ORDER BY `date` DESC";
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
    <td rowspan="4" class="title" width="120">'.formatdate($r2['date']).($r2['time']!="00:00:00"?'<br>'.$r2['time']:"").'<br><br>'.$r2['Qproblem'].'</td>
	<td class="title_s" width="80">服務類別</td>
	<td>'.option_result("Q1","例行訪視;評估量表;照顧問題;節慶活動;就醫協助;醫院探訪;個案支持;諮商輔導;適應協助;轉介安置;資源協助;經濟問題;Other","m","single",$Q1,true,5).($r2['Q1a']!=""?"：".$r2['Q1a']:"").'</td>
	<td rowspan="4" class="printcol">';
	//<form><input type="button" id="edit_'.$HospNo.'_'.$r2['date'].'_'.$r2['no'].'" onclick="window.location.href=\'index.php?mod=socialwork&func=formview&pid='.@$_GET['pid'].'&id=18_1&no='.$r2['no'].'&date='.$r2['date'].'\'" value="Edit"><br><input type="button" id="delete_'.$HospNo.'_'.$r2['date'].'_'.$r2['no'].'" onclick="confirmdelete(this.id);" value="Delete"></form>
	echo '<form><input type="button" id="edit_'.$HospNo.'_'.$r2['date'].'_'.$r2['no'].'" onclick="window.location.href=\'index.php?mod=socialwork&func=formview&pid='.@$_GET['pid'].'&id=18_1&no='.$r2['no'].'&date='.$r2['date'].'\'" value="Edit"><br><input type="button" id="delete_'.$HospNo.'_'.$r2['date'].'_'.$r2['no'].'" onclick="confirmdelete(this.id);" value="Delete"></form>';
	echo '</td>
  </tr>
  <tr>
    <td class="title_s">行為觀察</td>
	<td>
		意識→('.option_result("Q2","Clear;Fair;Poor","m","single",$Q2,true,5).')。
		表達→('.option_result("Q3","Clear;Fair;Poor","m","single",$Q3,true,5).')。
		行動→('.option_result("Q4","Clear;Fair;Poor","m","single",$Q4,true,5).')。
		情緒→('.option_result("Q5","Clear;Fair;Poor","m","single",$Q5,true,5).')。
	</td>
  </tr>
  <tr>
    <td class="title_s">Treatment summary</td>
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
			data: {"HospNo": postinfo[1], "date": postinfo[2], "no": postinfo[3],"formID":"socialform18" },
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