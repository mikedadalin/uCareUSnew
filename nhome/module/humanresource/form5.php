<div class="moduleNoTab">
<h3>Punch card Records</h3>
<div id="tabs" style="width:100%; padding:15px;">
  <ul>
  	<li><a href="#tabs-1">Punch card Records</a></li>
    <li><a href="#tabs-2">Transferred punch card records</a></li>
  </ul>
  <div id="tabs-1" style="background-color:rgba(0,0,0,0.1)"><?php include("form5_1.php");?></div>
  <div id="tabs-2" style="background-color:rgba(0,0,0,0.1)"><?php include("form5_2.php");?></div>
  	
</div>
</div>
<script>
$(function() {
	$("#tabs").tabs({ active: <?php if (@$_GET['view']==NULL) { echo '0'; } else { echo (@$_GET['view']-1); } ?> });
});
</script>