<script>
$(function() {
    $( "#newrecordform" ).dialog({
		autoOpen: false,
		height: 490,
		width: 800,
		modal: true,
		buttons: {
			"Add resident's record": function() {
				$.ajax({
					url: "class/socialform04.php",
					type: "POST",
					data: {"HospNo": $("#HospNo").val(), "date": $("#date").val(), "timeH": $("#timeH").val(), "timeI": $("#timeI").val(), "Qproblem": $("#Qproblem").val(), "Qinteraction": $("#Qinteraction").val(), "Qcontent": $("#Qcontent").val(), "Qfiller": $("#Qfiller").val()  },
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
		window.open('print.php?mod=socialwork&func=formview&pid=<?php echo $_GET['pid']; ?>&id=4&date1='+date1+'&date2='+date2);
	} else if (functioname=='view') {
		window.location.href='index.php?mod=socialwork&func=formview&pid=<?php echo $_GET['pid']; ?>&id=4&date1='+date1+'&date2='+date2;
	}
}
</script>
<div id="newrecordform" title="Add resident's record" class="dialog-form">
	<fieldset>
		<div class="content-table">
		<table>
			<tr>
			    <td class="title">Date</td>
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
			    <td class="title">Issue/problem description</td>
			    <td><input type="text" name="Qproblem" id="Qproblem" size="50"></td>
			</tr>
            <tr>
			    <td class="title">Counseling/interaction content</td>
			    <td><textarea name="Qinteraction" id="Qinteraction" cols="50" rows="5"></textarea></td>
			</tr>
			<tr>
				<td class="title">Treatment summary</td>
				<td>
                <textarea name="Qcontent" id="Qcontent" cols="50" rows="5"></textarea>
                <input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
				<input type="hidden" name="Qfiller" id="Qfiller" value="<?php echo $_SESSION['ncareID_lwj']; ?>">
                </td>
			</tr>
		</table>
		</div>
	</fieldset>
</div>
<div style="background-color: rgba(255,255,255,0.8); border-radius: 10px; padding:10px 10px 30px 10px; margin-bottom: 20px;">
<h3>Case/resident's record</h3>
<?php
$url = $_SERVER['PHP_SELF'];
$url = explode(".",$url);
$url = explode("/",$url[0]);
$file = $url[2];
?>
<div align="right" class="printcol"><form>Select date: <script> $(function() { $( "#printdate1").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="printdate1" id="printdate1" value="<?php if (@$_GET['date1']==NULL) { echo date(Y."/".m."/01"); } else { echo formatdate(@$_GET['date1']); } ?>" size="12"> ~ <script> $(function() { $( "#printdate2").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="printdate2" id="printdate2" value="<?php if (@$_GET['date2']==NULL) { echo date(Y."/".m."/01"); } else { echo formatdate(@$_GET['date2']); } ?>" size="12"> <input type="button" value="Search" onclick="datefunction('view');" /> <input type="button" value="Print" onclick="datefunction('print');" /> <?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?><input type="button" id="newrecord" value="Add resident's record" onclick="openVerificationForm('#newrecordform');" style="height:30px;"/><?php }?></form></div>
<table id="newrecordtable" cellpadding="7" style="width:100%;">
  <thead>
  <tr class="title">
    <td width="80">Date<br />Issue/problem description</td>
    <td colspan="2">&nbsp;</td>
	<?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?>
    <td class="printcol">Function</td>
	<?php }?>
  </tr>
  </thead>
  <tbody>
  <?php
  if ($_GET['date1']!=NULL && $_GET['date2']!=NULL) {
	  $sql1 = "SELECT * FROM `socialform04` WHERE `HospNo`='".$HospNo."' AND (`date` BETWEEN '".mysql_escape_string($_GET['date1'])."' AND '".mysql_escape_string($_GET['date2'])."') ORDER BY `date` DESC, `time` DESC";
  } else {
	  $sql1 = "SELECT * FROM `socialform04` WHERE `HospNo`='".$HospNo."' ORDER BY `date` DESC, `time` DESC";
  }
  $db2 = new DB;
  $db2->query($sql1);
  for ($i=0;$i<$db2->num_rows();$i++) {
 	$r2 = $db2->fetch_assoc();
	echo '
  <tr>
    <td rowspan="3" class="title" nowrap>'.formatdate($r2['date']).($r2['time']!="00:00:00"?'<br>'.$r2['time']:"").'<br><br>'.$r2['Qproblem'].'</td>
	<td class="title_s" width="120">Counseling/interaction content</td>
	<td>'.$r2['Qinteraction'].'</td>';
	if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){
	echo '
	<td rowspan="3" class="printcol">';
	echo '<form><input type="button" id="edit_'.$HospNo.'_'.$r2['date'].'_'.$r2['no'].'" onclick="window.location.href=\'index.php?mod=socialwork&func=formview&pid='.@$_GET['pid'].'&id=4_1&no='.$r2['no'].'&date='.$r2['date'].'\'" value="Edit"><br><input type="button" id="delete_'.$HospNo.'_'.$r2['date'].'_'.$r2['no'].'" onclick="confirmdelete(this.id);" value="Delete"></form>';
	}
	echo '</td>';
	echo '
  </tr>
  <tr>
    <td class="title_s">Treatment summary</td>
	<td>'.$r2['Qcontent'].'</td>
  </tr>
  <tr>
    <td class="title_s">Filled by</td>
	<td>'.checkusername($r2['Qfiller']).'</td>
  </tr>
  '."\n";
  }
  ?>
  </tbody>
</table>
</div>
<script>
function confirmdelete(id) {
	if (confirm('Confirm delete?')) {
		var postinfo = id.split(/_/);
		$.ajax({
			url: "class/socialform04_delete.php",
			type: "POST",
			data: {"HospNo": postinfo[1], "date": postinfo[2], "no": postinfo[3] },
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