<?php

//模組名稱
$strModule = "firmstock";
$subModule = "firmstockinfo";
$type = "OC";
$typeName = "Returns";
?>
<div id="tabs" style="width:964px;" >
  <ul <?php  if (strpos($_SERVER['PHP_SELF'],'print.php')!==false) { echo 'style="display:none;"'; } ?>>
    <li><a href="#tabs-1"><?php echo $typeName; ?> notes detail</a></li>
    <li><a href="#tabs-2"><?php echo $typeName; ?> Statistics</a></li>
    <li><a href="#tabs-3"><?php echo $typeName; ?> Price list</a></li>
  </ul>
  <form>
  <div id="tabs-1" style="padding:1px;font-size:11pt;"><?php include('form13_1a.php'); ?></div>
  <div id="tabs-2" style="padding:1px;font-size:11pt;"><?php include('form13_1b.php'); ?></div>
  <div id="tabs-3" style="padding:1px;font-size:11pt;"><?php include('form13_1c.php'); ?></div>
  <input id="type" type="hidden" name="type" value="<?php $type; ?>" />
  </form>
</div>


<script>
function datefunction(functioname,tab) {
	for (var i=0;i<2;i++){
	  var date1 = document.getElementById(tab+'printdate1').value;
	  var date2 = document.getElementById(tab+'printdate2').value;
	  if (functioname=='print') {
		  window.open('print.php?mod=consump&func=formview&id=14&view='+tab+'&date1='+date1+'&date2='+date2);
	  } else if (functioname=='view') {
		  window.location.href='index.php?mod=consump&func=formview&id=14&view='+tab+'&date1='+date1+'&date2='+date2;
	  }
	}
}
$(function() {
    $( "#tabs" ).tabs( { active: <?php if (@$_GET['view']==NULL) { echo '0'; } else { echo @$_GET['view']; } ?> } );
});
function newORD() {
  $.ajax({
	  url: "class/firm.php",
	  type: "POST",
	  data: { "PID": $("#FirmDiv").val()},
	  success: function(data) {
		  var dataArr = data.split(';');
		  for (i = 0; i < dataArr.length; i++){				
			  $("#log"+i).val( dataArr[i] );			  
			  $("#log"+i).html(dataArr[i]);
		  }
	  }
  });
}

</script>
