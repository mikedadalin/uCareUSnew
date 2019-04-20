<table border="0" style="width:100%;">
  <tr>
    <td style="border:none;" colspan="2">
    <?php
	if (@$_GET['id']!=NULL) {
		echo '<div class="content-table">';
		include("form".@$_GET['id'].".php");
		echo '</div>';
	} else {
		include("formlist.php");
	}
	?>
    </td>
  </tr>
</table>