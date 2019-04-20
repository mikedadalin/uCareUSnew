<?php

//模組名稱
$strModule = "firmstock";
$subModule = "firmstockinfo";
$type = "SP";
$typeName = "Shippment";

?>
<div id="tabs" style="width:100%;" >
  <ul <?php  if (strpos($_SERVER['PHP_SELF'],'print.php')!==false) { echo 'style="display:none;"'; } ?>>
    <li><a href="#tabs-1"><?php echo $typeName; ?> notes detail</a></li>
    <li><a href="#tabs-2"><?php echo $typeName; ?> Statistics</a></li>
    <li><a href="#tabs-3"><?php echo $typeName; ?> Price list</a></li>
    <li><a href="#tabs-4">Resident reconciliation list</a></li>
	<li><a href="#tabs-5">Resident supply spending statistic</a></li>
	<li><a href="#tabs-6">Public property supply spending statistics</a></li>
	<li><a href="#tabs-7">Individual <?php echo $typeName; ?> statistic</a></li>
  </ul>
  <form>
  <div id="tabs-1" style="padding:1px;font-size:11pt;"><?php include('form15_1a.php'); ?></div>
  <div id="tabs-2" style="padding:1px;font-size:11pt;"><?php include('form15_1b.php'); ?></div>
  <div id="tabs-3" style="padding:1px;font-size:11pt;"><?php include('form15_1c.php'); ?></div>
  <div id="tabs-4" style="padding:1px;font-size:11pt;"><?php include('form15_1d.php'); ?></div>
  <div id="tabs-5" style="padding:1px;font-size:11pt;"><?php include('form15_1e.php'); ?></div>
  <div id="tabs-6" style="padding:1px;font-size:11pt;"><?php include('form15_1f.php'); ?></div>
  <div id="tabs-7" style="padding:1px;font-size:11pt;"><?php include('form15_1g.php'); ?></div>
  <input id="type" type="hidden" name="type" value="<?php $type; ?>" />
  </form>
</div>


<script>
function datefunction(functioname,tab) {
	for (var i=0;i<=6;i++){
	  var date1 = document.getElementById(tab+'printdate1').value;
	  var date2 = document.getElementById(tab+'printdate2').value;
	  var date3 = document.getElementById(tab+'printdate1').value;
	  var date4 = document.getElementById(tab+'printdate2').value;
	  var firmID = document.getElementById('FirmDiv').value;
	  var firmID1 = document.getElementById('FirmDiv1').value;
	  var STK_NO1 = document.getElementById('STK_NO1').value;
	  var STK_NO2 = document.getElementById('STK_NO2').value;
	  var STK_NO3 = document.getElementById('STK_NO3').value;
	  if (functioname=='print') {
		  if(tab == 3 && i == (tab-1)){
			window.open('printReport.php?type=SP&date1='+date1+'&date2='+date2+'&FirmDiv='+firmID);  
		  }else if (tab==4 && i == (tab-1)){
			window.open('printReport2a.php?type=SP&date1='+date1+'&date2='+date2+'&FirmDiv='+firmID1);  
		  }else if (tab==5 && i == (tab-1)){
			window.open('printReport3.php?type=SP&date1='+date1+'&date2='+date2+'&STK_NO1='+STK_NO1+'&STK_NO2='+STK_NO2);  
		  }else if (i==(tab-1)) {
		  	window.open('print.php?mod=consump&func=formview&id=15&view='+tab+'&date1='+date1+'&date2='+date2+'&FirmDiv='+firmID);
		  }
	  } else if (functioname=='view') {
		  if(tab == 6){
			  window.location.href='index.php?mod=consump&func=formview&id=15&view='+tab+'&date3='+date3+'&date4='+date4+'&STK_NO3='+STK_NO3;
		  }else{
		  	window.location.href='index.php?mod=consump&func=formview&id=15&view='+tab+'&date1='+date1+'&date2='+date2+'&FirmDiv='+firmID;
		  }
	  } else if (functioname=='export') {
		  if(tab==4 && i == (tab-1)) {
			  window.open('printReport2a.php?out=xls&type=SP&date1='+date1+'&date2='+date2+'&FirmDiv='+firmID1);
		  }
	  }
	}
}
$(function() {
    $( "#tabs" ).tabs( { active: <?php if (@$_GET['view']==NULL) { echo '0'; } else { echo @$_GET['view']; } ?> } );
});
function showPatient() {
  $.ajax({
	  url: "class/patient.php",
	  type: "POST",
	  data: { "PID": $("#FirmDiv").val()},
	  success: function(data) {
		  var dataArr = data.split(';');
		  for (i = 0; i < dataArr.length; i++){				
			  $( "#log"+i ).val( dataArr[i] );
			  $("#log"+i).html(dataArr[i]);
		  }
	  }
  });
}
function showPatient1() {
  $.ajax({
	  url: "class/patient.php",
	  type: "POST",
	  data: { "PID": $("#FirmDiv1").val()},
	  success: function(data) {
		  var dataArr = data.split(';');
		  	  $("#log99").html(dataArr[0]);
			  $("#log98").html(dataArr[4]);
	  }
  });
}
function blurselect(id) {//取得產品資訊
	$.ajax({
		url: "class/searchSTK2a.php",
		type: "POST",
		data: {"STK_SELECT": $("#STK_NO"+id).val() },
		success: function(data) {
			var arr = data.split("||");
			$('#STK_NO'+id).val(arr[0]);
			$('#STK_NAME'+id).val(arr[1]);
		}
	});
}

function stockINFO(id) {
  $.ajax({
	  url: "class/stockInfo.php",
	  type: "POST",
	  data: { "PID": $("#SSTOCK_INFO"+id).val()},
	  success: function(data) {
		  var STOCK_INFO_NAME = document.getElementById('SSTOCK_INFO_NAME'+id);
		  $('#SSTOCK_INFO_NAME'+id).val(data);
	  }
  });
}

</script>
