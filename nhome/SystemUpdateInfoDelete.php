<?php
$db2 = new DB2;
$db2->query("DELETE FROM `notice` WHERE `noticeID`='".mysql_escape_string($_GET['noticeID'])."'");
?>
<script>
alert("Successfully deleted data.")
document.location.href="index.php?func=infoedit";
</script>