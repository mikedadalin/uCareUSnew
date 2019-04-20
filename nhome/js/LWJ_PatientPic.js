var x=0,y=0;
function move(e){
	if(e){
		x=e.pageX;
		y=e.pageY;
	}else{
		x=event.clientX;
		y=event.clientY;
	}
}
function showPatientPic(pid){
	document.getElementById('PatientPic_'+pid).style.display = 'inline';
	document.getElementById('PatientPic_'+pid).style.top = eval(y+30)+'px';
	document.getElementById('PatientPic_'+pid).style.left = eval(x+40)+'px';
	var PatientPic = document.getElementById('PatientPic_'+pid);
	var w = PatientPic.offsetWidth;
	document.getElementById('PatientPic_'+pid).style.width = w+'px';
	document.getElementById('PatientPic_'+pid).style.border = 'purple 1px dotted';
}
function hiddenPatientPic(pid){
	document.getElementById('PatientPic_'+pid).style.display = 'none';
}
document.onmousemove=move;