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
function showQfillerName(checktime){
	document.getElementById('QfillerName_'+checktime).style.display = 'inline';
	document.getElementById('QfillerName_'+checktime).style.top = eval(y+30)+'px';
	document.getElementById('QfillerName_'+checktime).style.left = eval(x+40)+'px';
	var QfillerName = document.getElementById('QfillerName_'+checktime);
	var w = QfillerName.offsetWidth;
	document.getElementById('QfillerName_'+checktime).style.width = w+'px';
	document.getElementById('QfillerName_'+checktime).style.border = 'purple 1px dotted';
}
function hiddenQfillerName(checktime){
	document.getElementById('QfillerName_'+checktime).style.display = 'none';
}
document.onmousemove=move;