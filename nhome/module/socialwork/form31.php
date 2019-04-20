<script>
$(function() {
    $( "#dialog-form" ).dialog({
		autoOpen: false,
		height: 490,
		width: 800,
		modal: true,
		buttons: {
			"Add record": function() {
			    document.getElementById('Qcontent').value = document.getElementById('QcontentHTML').innerHTML;
				$.ajax({
					url: "class/socialform31.php",
					type: "POST",
					data: {"HospNo": $("#HospNo").val(), "date": $("#date").val(), "time": $("#time").val(), "Q2": $("#Q2").val(), "Qcontent": $("#Qcontent").val(), "Qfiller": $("#Qfiller").val() },
					success: function(data) {
						$( "#recordlist tbody" ).append( "<tr>" +
						"<td>" + $("#date").val() + "</td>" + 
						"<td>" + $("#Q2").val() + "# " + data + "</td>" + 
						"<td>" + $("#Qcontent").val() + "</td>" +
						"<td>&nbsp;</td>" + "</tr>" );
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
});
</script>
<h3>Nutritionist individual notification</h3>
<form action="index.php?func=database&action=save">
<input type="button" id="newrecord" value="New notification" onclick="openVerificationForm('#dialog-form'); filloldrecord();" /></form>
<div id="dialog-form" title="New notification" class="dialog-form"> 
  <form>
  <fieldset>
    <table>
      <tr>
        <td class="title">Date/Time</td>
        <td><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php echo date(Y."/".m."/".d); ?>" size="12"> <input type="text" name="time" id="time" value="<?php echo date(Hi); ?>" size="4"> <font size="2">(Time format:HHmm)</font></td>
      </tr>
      <tr>
        <td class="title">Reason for notification</td>
        <td>
        <textarea name="Q2" id="Q2" cols="60" rows="5"></textarea>
	   <input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
        </td>
      </tr>
      <tr>
        <td class="title">Notification results</td>
        <td>
        <script>
		function placeCaretAtEnd(el) {
			el.focus();
			if (typeof window.getSelection != "undefined"
            && typeof document.createRange != "undefined") {
        var range = document.createRange();
        range.selectNodeContents(el);
        range.collapse(false);
        var sel = window.getSelection();
        sel.removeAllRanges();
        sel.addRange(range);
    } else if (typeof document.body.createTextRange != "undefined") {
        var textRange = document.body.createTextRange();
        textRange.moveToElementText(el);
        textRange.collapse(false);
        textRange.select();
    }
}
		function addtotextarea(field, text) {
			document.getElementById(field).value = document.getElementById('QcontentHTML').innerHTML;
			var txt = document.getElementById(field).value;
			document.getElementById(field).value = txt + text;
			document.getElementById('QcontentHTML').innerHTML = document.getElementById(field).value;
			document.getElementById('QcontentHTML').focus();
			placeCaretAtEnd( document.getElementById("QcontentHTML") );
		}
		</script>
        <p style="line-height:12px;"><!--<input type="button" value="、" onclick="addtotextarea('Qcontent', '、')" />--></p>
        <!--<textarea name="Qcontent" id="Qcontent" cols="80" rows="10" onfocus="setCursorAtTheEnd(this,event)"></textarea>-->
        <div id="oldrecord"></div>
        <div id="QcontentHTML" contentEditable="true" style="width: 540px; height: 140px; border: 1px solid #ccc; padding: 5px; background:#ffffff;"></div>
        <input type="hidden" name="Qcontent" id="Qcontent" value="" />
        <input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
        <input type="hidden" name="Qfiller" id="Qfiller" value="<?php echo $_SESSION['ncareID_lwj']; ?>">
        </td>
      </tr>
    </table>
  </fieldset>
  </form>
</div>
<table width="100%" id="recordlist">
  <thead>
  <tr class="title">
    <td>Edit</td>
    <td width="120">Date</td>
    <td width="240">Reason for notification</td>
    <td>Notification results</td>
    <td width="60">Staff</td>
    <td>Delete</td>
  </tr>
  </thead>
  <tbody>
    <?php
    $db2 = new DB;
    $db2->query("SELECT * FROM `socialform31` WHERE `HospNo`='".$HospNo."' ORDER BY `date` ASC");
    for ($i=0;$i<$db2->num_rows();$i++) {
 	$r2 = $db2->fetch_assoc();
	echo '
  <tr>
    <td width="6%"><center><a href="index.php?mod=socialwork&func=form31edit&pid='.mysql_escape_string($_GET['pid']).'&date='.$r2['date'].'&time='.$r2['time'].'"><img src="Images/edit_icon.png" width="20" border="0"></a></center></td>
    <td>'.formatdate($r2['date']).' '.substr($r2['time'],0,2).':'.substr($r2['time'],2,2).'</td>
    <td>';
	if ($r2['Q2']!="") {
		echo $r2['Q2'];
	} else {
		echo '&nbsp;';
	}
	echo '</td>
    <td>'.$r2['Qcontent'].'</td>
	<td>';
	$db_filler = new DB2;
	$db_filler->query("SELECT `name` FROM `userinfo` WHERE `userID`='".$r2['Qfiller']."' AND `orgID`='".$_SESSION['nOrgID_lwj']."'");
	$r_filler = $db_filler->fetch_assoc();
	echo $r_filler['name'];
	echo '</td>
	<td width="6%">';
	if ($r2['Qfiller']==$_SESSION['ncareID_lwj']) {
		echo '<center><a href="index.php?mod=socialwork&func=form31delete&pid='.mysql_escape_string($_GET['pid']).'&date='.$r2['date'].'&time='.$r2['time'].'"><img src="Images/delete2.png" border="0"></a></center>';
	} else { echo '&nbsp;'; }
	echo '</td>
  </tr>
	'."\n";
	if (($db2->num_rows()-$i)<5) {
		$spantext .= '<tr><td>'.formatdate($r2['date']).' '.$r2['time'].'：'.$r2['Qcontent']."</td></tr>\n";
	}
    }
    ?>
  </tbody>
</table>
<!--<div id="spantext" style="display:none;">
<table style="font-size:10pt;">
  <tr>
    <td>最後4筆護理紀錄</td>
  </tr>
  <?php //echo $spantext; ?>
</table>
</div>
<script>
function filloldrecord() {
  document.getElementById('oldrecord').innerHTML = document.getElementById('spantext').innerHTML;
}
</script>-->