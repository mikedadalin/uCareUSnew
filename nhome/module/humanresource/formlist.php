<div class="content-query">
<table cellpadding="0" cellspacing="0" style="background-color:rgba(255,255,255,0.8); padding:5px; border-radius:10px;">
  <tr>
    <td class="title" style="border-top-left-radius:10px; border-top-right-radius:10px;">Reminders</td>
  </tr>
  <tr>
    <td valign="top" style="padding-top:0px;"><?php include('formalt.php'); ?></td>
  </tr>
</table>
</div>
<br />
<div class="formlist">
<?php
include('FormGroup_Link.php');
$db1 = new DB2;
$db1->query("SELECT *, a.`name` as `catename` FROM `permission_subcate` a INNER JOIN `permission_item` b ON a.subcateID = b.subcateID AND a.cateID='9' INNER JOIN `user_permission` c ON c.`serNo`=b.`serNo` AND c.`userID`='".$_SESSION['ncareID_lwj']."' AND c.`level`='1' ORDER BY b.subcateID, b.ord");
for ($i1=0;$i1<$db1->num_rows();$i1++) {
	$r1 = $db1->fetch_assoc();
	$catename = explode(";",$r1['catename']);
	if ($r1['subcateID']!=$tmpSubcate) { echo '<div class="formlistStyle">'.$catename[$_SESSION['LanguangNumber_lwj']].'</div>'; }
	echo '
	<div class="formlistItem">
	<a href="'.str_replace('{PID}',$_GET['pid'],$r1['link']).'"><span class="fa-stack fa-2x"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-'.$r1['icon'].' fa-stack-1x fa-inverse"></i></span><br>'.$r1['name'].'</a>
	</div>';
	$tmpSubcate = $r1['subcateID'];
}
include('FormMaker_Link.php');
?>
</div>