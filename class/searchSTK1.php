<?php
include("DB.php");


foreach($_POST as $k=>$v){
	$_POST[$k] = mysql_escape_string($v);
}
$KIND1 = $_POST['STK_KIND1'];
$KIND2 = $_POST['STK_KIND2'];
$KIND3 = $_POST['STK_KIND3'];

$where = ' WHERE ';
if ($KIND1!='') { $where .= "`STK_KIND1`='".$KIND1."' AND "; }
if ($KIND2!='') { $where .= "`STK_KIND2`='".$KIND2."' AND "; }
if ($KIND3!='') { $where .= "`STK_KIND3`='".$KIND3."' AND "; }

$where = substr($where,0,strlen($where)-4);

$sql = "SELECT * FROM `ARKSTOCK` ".$where." ORDER BY `STK_NO` ASC";

/*$db = new DB3;
$db->query($sql);
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	$result .= $r['STK_NAME'].';';
}*/

return $KIND1;
?>