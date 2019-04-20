<script>
$(function() {
    $( "#newrecordform" ).dialog({
		autoOpen: false,
		height: 540,
		width: 960,
		modal: true,
		buttons: {
			"New plan": function() {
				$.ajax({
					url: "class/socialform05.php",
					type: "POST",
					data: {"HospNo": $("#HospNo").val(), "date": $("#date").val(), "Q1_1": $("#Q1_1").val(), "Q1_2": $("#Q1_2").val(), "Q1_3": $("#Q1_3").val(), "Q1_4": $("#Q1_4").val(), "Q1_5": $("#Q1_5").val(), "Q1_6": $("#Q1_6").val(), "Q1_7": $("#Q1_7").val(), "Q2": $("#Q2").val(), "Q3": $("#Q3").val(), "Q4": $("#Q4").val(), "Q5": $("#Q5").val(),  "Qfiller": $("#Qfiller").val()  },
					success: function(data) {
						var arr = data.split(/;/);
						$( "#newrecordtable tbody" ).append( "<tr>" +
						"<td>" + arr[0] + "</td>" + 
						"<td>" + arr[1] + "</td>" +
						"<td>" + arr[2] + "</td>" +
						"<td><form><input type=\"button\" id=\"delete_"+$("#HospNo").val()+"_"+$("#date").val()+"\" onclick=\"confirmdelete(this.id);\" value=\"Delete\"></form></td>" +  "</tr>" );
						$( "#newrecordform" ).dialog( "close" );
						alert("已經新增計畫");
					}
				});
			},
			"Cancel": function() {
				$( "#newrecordform" ).dialog( "close" );
			}
		}
	});
});
</script>
<div id="newrecordform" title="New plan" class="dialog-form">
	<fieldset>
		<table>
			<tr>
			    <td class="title">Date</td>
			    <td><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php echo date(Y."/".m."/".d); ?>" size="12"></td>
		    </tr>
            <tr>
			    <td class="title">主要問題</td>
			    <td><?php echo draw_option("Q1","Adaptation issues;Emotional problem(s);行為問題;健康問題;經濟問題;家庭問題;Other","l","single","",false,5); ?></td>
			</tr>
            <tr>
			    <td class="title">Issue/problem description</td>
			    <td><textarea name="Q2" id="Q2" cols="70" rows="3"></textarea></td>
			</tr>
            <tr>
			    <td class="title">評估分析</td>
			    <td><textarea name="Q3" id="Q3" cols="70" rows="3"></textarea></td>
			</tr>
			<tr>
			    <td class="title">處遇計畫</td>
			    <td><textarea name="Q4" id="Q4" cols="70" rows="3"></textarea></td>
			</tr>
			<tr>
				<td class="title">執行成效</td>
				<td>
                <textarea name="Q5" id="Q5" cols="70" rows="3"></textarea>
                <input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
				<input type="hidden" name="Qfiller" id="Qfiller" value="<?php echo $_SESSION['ncareID_lwj']; ?>">
                </td>
			</tr>
		</table>
	</fieldset>
</div>
<h3>Individual care plan/Resident's counseling and treatment program</h3>
<?php
$url = $_SERVER['PHP_SELF'];
$url = explode(".",$url);
$url = explode("/",$url[0]);
$file = $url[2];
?>
<div align="right" <?php if ($file=="print") echo ' style="display:none;"'; ?>><form><input type="button" id="newrecord" value="新增特殊個案輔導記錄" onclick="openVerificationForm('#newrecordform');" /></form></div>
<table width="100%" id="newrecordtable">
  <thead>
  <tr class="title">
    <td>Date</td>
    <td>主要問題</td>
    <td>Issue/problem description</td>
    <td>Delete</td>
  </tr>
  </thead>
  <tbody>
  <?php
  $db2 = new DB;
  $db2->query("SELECT * FROM `socialform05` WHERE `HospNo`='".$HospNo."' ORDER BY `date` DESC");
  for ($i=0;$i<$db2->num_rows();$i++) {
 	$r2 = $db2->fetch_assoc();
	for ($j=1;$j<=7;$j++) {
		$txt = "Q1_".$j;
		$var = $r2[$txt];
		if ($var == 1) {
			$ans = explode("_",$txt);
			$Q1 = $ans[1];
		}
	}
	echo '
  <tr>
    <td>'.formatdate($r2['date']).'</td>
    <td>'.$arrSocialform05_Q1[$Q1].'</td>
    <td>'.$r2['Q2'].'</td>
	<td><form><input type="button" id="delete_'.$HospNo.'_'.$r2['date'].'" onclick="confirmdelete(this.id);" value="Delete"></form></td>
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
			url: "class/socialform05_delete.php",
			type: "POST",
			data: {"HospNo": postinfo[1], "date": postinfo[2] },
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