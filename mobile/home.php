<script>
$(function() {
	$( "img" ).css("width","50%");
    $( "div[id^=notice]" ).accordion({
		heightStyle: "content",
		collapsible: true
	});
	$(".ui-accordion-content").show();
	$("h3[id^=ui-accordion-notice1-header]").removeClass('ui-accordion-header ui-helper-reset ui-state-default ui-corner-all ui-accordion-icons').addClass('ui-accordion-header ui-helper-reset ui-state-default ui-accordion-header-active ui-state-active ui-corner-top ui-accordion-icons');
});
</script>
<?php
$db1 = new DB2;
$db1->query("SELECT * FROM `permissionset` WHERE `OrgID`='".$_SESSION['nOrgID_lwj']."' AND `Group`='".$_SESSION['ncareGroup_lwj']."'");
$r1 = $db1->fetch_assoc();

$arrHomeLink = array();
$arrPermissionSet = explode(";",$r1['PermissionSet']);

if (count($arrPermissionSet)==1 || $r1['PermissionSet']==NULL) {
	echo "<script>window.location.href='".$r1['DirectLink']."';</script>";
} else {
	foreach ($arrPermissionSet as $k=>$v) {
		$db1a = new DB2;
		$db1a->query("SELECT * FROM `permission` WHERE `PermissionID`='".$v."'");
		$r1a = $db1a->fetch_assoc();
		$arrHomeLink[$k] = $r1a['HomeLink'];
	}
}

$table_rowno = ceil(count($arrHomeLink)/3);

?>
<table bgcolor="#ffffff" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top" width="100%">
      <?php
	  for ($i=0;$i<$table_rowno;$i++) {
		  for ($j=1;$j<=3;$j++) {
			  $keyno = ($i*3)+$j;
			  $keyno = $keyno-1;
			  echo '<div style="padding:10px;"><center>&nbsp;'.$arrHomeLink[$keyno].'</center></div>';
		  }
	  }
	  ?>
    </td>
    <td style="padding-top:16px;" valign="top" width="250">
    <?php //include("rightcolumn.php"); ?>
    </td>
  </tr>
</table>