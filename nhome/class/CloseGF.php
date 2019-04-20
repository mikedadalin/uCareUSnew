<?php
session_start();
for($i=1;$i<11;$i++){
	$kGF = 'Glink_'.$i;
	$kGF2 = 'Gname_'.$i;
	unset($_SESSION[$kGF]);
	unset($_SESSION[$kGF2]);
}
unset($_SESSION['GNO']);
unset($_SESSION['GListName']);
unset($_SESSION['G_Temp_Link']);
unset($_SESSION['G_GNOnumber']);
unset($_SESSION['G_mod']);
unset($_SESSION['G_func']);
unset($_SESSION['G_pid']);
echo 'OK';
?>