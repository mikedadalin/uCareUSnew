<?php
//產生備份檔下載連結
$arrDBNO = explode("-",$_SESSION['ncareDBno_lwj']);
if (strlen($arrDBNO[1])==1) { $prefix = "0".$arrDBNO[1]; } else { $prefix = $arrDBNO[1]; }
$directory = "../".md5(md5(md5('SQL')))."/".$prefix."a".md5(md5(md5($_SESSION['ncareDBno_lwj'])))."/";
$texts = glob($directory . "*.7z");
$link = $texts[(count($texts)-1)];
$arrLink = explode('/',$link);
$filename = $arrLink[(count($arrLink)-1)];
$filename = str_replace(".7z","",$filename);
$backupdate = formatdate($filename);
//link 下載連結
//backupdate 備份日期
?>
<div class="formlist">
<?php
include('FormGroup_Link.php');
$db1 = new DB2;
$db1->query("SELECT *, a.`name` as `catename` FROM `permission_subcate` a INNER JOIN `permission_item` b ON a.subcateID = b.subcateID AND a.cateID='10' INNER JOIN `user_permission` c ON c.`serNo`=b.`serNo` AND c.`userID`='".$_SESSION['ncareID_lwj']."' AND c.`level`='1' ORDER BY b.subcateID, b.ord");
for ($i1=0;$i1<$db1->num_rows();$i1++) {
	$r1 = $db1->fetch_assoc();
	$catename = explode(";",$r1['catename']);
	if ($r1['subcateID']!=$tmpSubcate) { echo '<div class="formlistStyle">'.$catename[$_SESSION['LanguangNumber_lwj']].'</div>'; }
	echo '
	<div class="formlistItem">
	<a href="'.str_replace('{LINK}',$link,str_replace('{PID}',$_GET['pid'],$r1['link'])).'"><span class="fa-stack fa-2x"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-'.$r1['icon'].' fa-stack-1x fa-inverse"></i></span><br>'.$r1['name'].'</a>
	</div>';
	$tmpSubcate = $r1['subcateID'];
}
include('FormMaker_Link.php');
?>
</div>