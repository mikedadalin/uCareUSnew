var max_time = 1800;
var cinterval;

function countdown_timer(){
  // decrease timer
  max_time--;
  document.getElementById('countdown').innerHTML = max_time+' sec before log off';
  if(max_time == 0){
	  clearInterval(cinterval);
	  //alert('系統已經自動登出');
	  //window.location.href='logout.php';
	  document.getElementById('countdown').innerHTML = 'System has automatically log off!';
  }
  if (max_time<=60) {
	  document.getElementById('countdown').style.color = 'yellow';
  }
}
// 1,000 means 1 second.
cinterval = setInterval('countdown_timer()', 1000);