<script>
$(function() {
    $( "#tabs" ).tabs( { active: <?php if (@$_GET['view']==NULL) { echo '0'; } else { echo @$_GET['view']; } ?> } );
	//$("#tabs").tabs();
});
</script>
<div id="tabs" style="width:100%;">
  <ul>
    <li><a href="#tabs-1">Item management</a></li>
    <li><a href="#tabs-2">Applied item management</a></li>
    <li><a href="#tabs-3">Apply category manage</a></li>
    <li><a href="#tabs-4">Applied item location</a></li>
    <li><a href="#tabs-5">Miscellaneous item management</a></li>
  </ul>
  <div id="tabs-1" style="padding:1px;font-size:11pt;"><?php include('form11_1a.php'); ?></div>
  <div id="tabs-2" style="padding:1px;font-size:11pt;"><?php include('form11_1b.php'); ?></div>
  <div id="tabs-3" style="padding:1px;font-size:11pt;"><iframe src="applyitemcate.php" width="920" height="520" frameborder="0"></iframe></div>
  <div id="tabs-4" style="padding:1px;font-size:11pt;"><iframe src="consump_grid_0.php" width="920" height="520" frameborder="0"></iframe></div>
  <div id="tabs-5" style="padding:1px;font-size:11pt;"><iframe src="consump_grid_1.php" width="920" height="520" frameborder="0"></iframe></div>
</div>