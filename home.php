<?php
if ($_SESSION['ncareID_lwj']!='') {
?>
<script>
window.location.href='<?php echo $_SESSION['nOrgType_lwj']; ?>/index.php?func=home';
</script>
<?php
} else {
?>
<script>
window.location.href='logout.php';
</script>
<?php
}
?>