<?php
$db = new DB;
$db->query("SELECT `patientID`,`HospNo`,`Birth` FROM `patient` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."'");
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	$db1 = new DB;
	$db1->query("SELECT `indate` FROM `inpatientinfo` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."'");
	$r1 = $db1->fetch_assoc();
	$name = getPatientName($r['patientID']);
	$birth = formatdate($r['Birth']);
	$indate = formatdate($r1['indate']);
	$db2 = new DB;
	$db2->query("SELECT `Qdiag1`, `Qdiag2`, `Qdiag3`, `Qdiag4` FROM `nurseform01` WHERE `HospNo`='".mysql_escape_string($r['HospNo'])."' ORDER BY `date` DESC LIMIT 0,1");
	$r2 = $db2->fetch_assoc();
	for ($j=1;$j<=4;$j++) { if ($r2['Qdiag'.$j]!=NULL) { $diagMsg .= $r2['Qdiag'.$j].', '; } }
	$diagMsg = substr($diagMsg, 0, strlen($diagMsg)-2);
}
?>
<div style="background-color: rgba(255,255,255,0.8); border-radius: 10px; padding:30px 10px; margin-bottom: 20px;">
<div class="content-query">
<table align="center" style="width:100%;">
  <tr>
    <?php if (@$_GET['id']!=NULL) { echo '<td align="center" bgcolor="#ffffff"><a href="index.php?mod=nurseform&func=formview&pid='.mysql_escape_string($_GET['pid']).'"><img src="Images/back_button.png"></a></td>'; } ?>
    <td class="title">Full name</td>
    <td><?php echo $name; ?></td>
    <td class="title">DOB</td>
    <td><?php echo $birth.' ('.calcage(str_replace('/','',$birth)).')'; ?></td>
    <td class="title">Admission date</td>
    <td><?php echo $indate; ?></td>
    <td class="title">Diagnosis</td>
    <td><?php echo $diagMsg; ?></td>
  </tr>
</table>
</div>
<table border="0" style="width:100%;">
  <tr>
    <td>
    <h3>Edit notification content</h3>
    <?php
	$db3 = new DB;
	$db3->query("SELECT * FROM `socialform31` WHERE `HospNo`='".$HospNo."' AND `date`='".mysql_escape_string($_GET['date'])."' AND `time`='".mysql_escape_string($_GET['time'])."'");
	$r3 = $db3->fetch_assoc();
	?>
    <div class="content-query">
    <form action="index.php?mod=nutrition&func=form31save" method="post"  onsubmit="synccontent();">
    <table cellpadding="10" style="width:100%;">
      <tr>
        <td class="title" width="120">Date</td>
        <td style="text-align:left;"><?php echo formatdate(@$_GET['date']); ?> <input type="text" name="newtime" id="newtime" size="4" value="<?php echo @$_GET['time']; ?>" /> <input type="hidden" name="oldtime" id="oldtime" value="<?php echo @$_GET['time']; ?>" /></td>
      </tr>
      <tr>
        <td class="title">Reason For Notification</td>
        <td style="text-align:left;"><?php echo $r3['Q2']; ?></td>
      </tr>
      <tr>
        <td class="title">Notification Results</td>
        <td style="text-align:left;">
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
		
		function synccontent() {
			document.getElementById('Qcontent').value = document.getElementById('QcontentHTML').innerHTML;
		}
		</script>
        <!--<p style="line-height:12px;"><input type="button" value="、" onclick="addtotextarea('Qcontent', '、')" /></p>-->
        <!--<textarea name="Qcontent" id="Qcontent" cols="80" rows="10" onfocus="setCursorAtTheEnd(this,event)"></textarea>-->
        <div id="QcontentHTML" contentEditable="true" style="width: 98%; height: 100%; min-height:200px; border: 1px solid #ccc; padding: 5px; background:#ffffff;"><?php echo $r3['Qcontent']; ?></div>
        <input type="hidden" name="Qcontent" id="Qcontent" value="<?php echo $r3['Qcontent']; ?>" /></td>
      </tr>
    </table>
    <div style="margin-top:40px;">
    <input type="hidden" id="formID" name="formID" value="socialform31">
    <input type="hidden" id="HospNo" name="HospNo" value="<?php echo $HospNo; ?>">
    <input type="hidden" id="date" name="date" value="<?php echo @$_GET['date']; ?>">
    <input type="hidden" id="time" name="time" value="<?php echo @$_GET['time']; ?>">
    <input type="hidden" id="Q2" name="Q2" value="<?php echo $r3['Q2']; ?>">
    <input type="hidden" id="Qfiller" name="Qfiller" value="<?php echo $r3['Qfiller']; ?>">
    <button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
    </div>
    </form>
    </div>
    </td>
  </tr>
</table>
</div>