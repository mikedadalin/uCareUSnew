<?php
$db = new DB;
$db->query("DELETE FROM `roundmenu` WHERE `setID`='".mysql_escape_string($_GET['mealID'])."'");
echo '<script>alert(\'Deletion success\'); window.location.href=\'index.php?mod=mealadmin&func=roundmenu\'</script>'."\n";
?>