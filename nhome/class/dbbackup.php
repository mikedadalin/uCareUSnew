<?php
header('Content-type: text/plain');
header('Content-Disposition: attachment; filename="'.$filename.'"');
print backup_tables(array('allergicmed'));
?>