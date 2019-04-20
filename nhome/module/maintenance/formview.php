<div style="background-color: rgba(255,255,255,0.8); border-radius: 10px; padding:10px; margin-bottom: 30px;">
<table style="width:100%;">
<?php include("BackToListButton.php"); ?>
  <tr>
    <td style="border:none;">
    <?php
	if (@$_GET['id']!=NULL) {
		echo '<div class="nurseform-table">';
		include("form".@$_GET['id'].".php");
		echo '</div>';
	} else {
		include("formlist.php");
	}
	?>
    </td>
  </tr>
</table>
</div>