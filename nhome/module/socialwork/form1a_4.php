<div class="content-table">
<h3>生態圖</h3>
<?php
$db2 = new DB;
$db2->query("SELECT `QEcologyJPG` FROM `socialform01` WHERE `HospNo`='".$HospNo."'");
$r2 = $db2->fetch_assoc();
?>
<form><input type="button" value="Upload image" onclick="window.open('class/uploadEcofiles.php?pid=<?php echo @$_GET['pid']; ?>&date=<?php echo date("Ymd"); ?>');" class="printcol"></form>
<?php
if ($r2['QEcologyJPG']!="") {
    echo '<img id="fsjpg" src="uploadfile/'.$_SESSION['nOrgID_lwj'].'/'.$HospNo.'/socialform01_Ecopic/'.$r2['QEcologyJPG'].'" border="0">';	  
} else {
    echo '<img id="fsjpg" border="0" width="800" style="display:block;">';
}?>
</div>