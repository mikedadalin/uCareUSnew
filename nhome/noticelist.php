<div style="background-color: rgba(255,255,255,0.8); border-radius: 10px; padding:10px 10px 30px 10px; margin-bottom: 20px;">
<div align="left">
	<h3 align="center" style="margin-bottom:30px;">Announcement</h3>
</div>
<?php
$db = new DB;
$db->query("SELECT * FROM `management07a` WHERE `available`='1' ORDER BY `datetime` DESC");
$noticetxt = "";
for ($i=0;$i<$db->num_rows();$i++) {
    $r = $db->fetch_assoc();
    //if ($noticetxt!=NULL) { $noticetxt .= '<hr>'; }
    $noticetxt .= '
	<tr>
	  <td nowrap>'.substr($r['datetime'],0,10).'</td>
	  <td><a onclick="opendialog('.$r['noticeID'].')" style="cursor:pointer;">'.$r['Q1'].'</a></td>
	  <td nowrap>'.checkusername($r['Qfiller']).checkuserposition($r['Qfiller']).'</td>
	</tr>';
    $dialogtxt .= '<div id="dialog_'.$r['noticeID'].'" title="'.$r['Q1'].'"><fieldset><p>'.str_replace("\n","<br>",$r['Qcontent']).'</fieldset></p>';
    if ($r['Attach']!="") {
        $dialogtxt .= '<p align="left">appendix 1：<a href="'.$r['Attach'].'" target="_blank">'.str_replace('announcement_files/','',$r['Attach']).'</a></p>';
    }
    if ($r['Attach2']!="") {
        $dialogtxt .= '<p align="left">appendix 2：<a href="'.$r['Attach2'].'" target="_blank">'.str_replace('announcement_files/','',$r['Attach2']).'</a></p>';
    }
    if ($r['Attach3']!="") {
        $dialogtxt .= '<p align="left">appendix 3：<a href="'.$r['Attach3'].'" target="_blank">'.str_replace('announcement_files/','',$r['Attach3']).'</a></p>';
    }
    $dialogtxt .= '<p align="right"><font size="2">'.substr($r['datetime'],5,5).' '.substr($r['datetime'],11,2).':'.substr($r['datetime'],14,2).' <em>by</em> '.checkusername($r['Qfiller']).' '.checkuserposition($r['Qfiller']).'</font></p></div>';
}
?>
<table id="noticetab">
  <thead>
  <tr>
    <th>Date</th>
    <th>Title</th>
    <th>Post by staff</th>
  </tr>
  </thead>
  <?php echo $noticetxt; ?>
</table>
<?php
echo $dialogtxt;
?>
</div><br>
<script>
$(function() {
	$('#noticetab').dataTable({
		pageLength: 30,
		"order": [[0,'desc']]
	});
	$("div[id^=dialog_]").dialog({
		autoOpen: false,
		width:800,
		height:500,
		show: {
			effect: "blind", duration: 600
		},
		hide: {
			effect: "blind", duration: 600
		}
	});
});
function opendialog(id) {
	$("div[id^=dialog_]").dialog("close");
	var vartxt = 'dialog_'+id;
	$("#"+vartxt).dialog("open");
}
$(document).ready(function () {
	$("#notice1").css("width","250px");
})
</script>