<div class="content-query">
<form>
<table width="100%">
  <tr class="title">
    <td colspan="2">Change ID#</td>
  </tr>
  <tr>
	<td class="title" width="160">現有護字號 Current Care ID#</td>
	<td><?php echo @$_GET['oldHN']; ?></td>
  </tr>
  <tr>
	<td class="title">請輸入新的護字號Type the new Care ID#</td>
	<td><input type="text" id="newHN" name="newHN" size="8" /></td>
  </tr>
  <tr>
    <td colspan="2"><span style="color:#f00;"><h3>注意！此操作有可能會造成資料遺失，建議執行動作前先請我們協助備份資料，謝謝！ Attention! The manipulation might cause lost of the information. Suggest contact us for assisting in backing up the data. Thank you!  </h3></span></td>
  </tr>
  <tr>
    <td colspan="2"><input type="button" value="確認變更" onclick="window.location.href='index.php?func=changehn2&oldHN=<?php echo @$_GET['oldHN']; ?>&newHN='+document.getElementById('newHN').value;"></td>
  </tr>
</table>
</form>
</div>