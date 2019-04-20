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
function showInsuranceInfo(id){
	document.getElementById('InsuranceInfo_'+id).style.display = 'inline';
	document.getElementById('InsuranceInfo_'+id).style.top = eval(y+30)+'px';
	document.getElementById('InsuranceInfo_'+id).style.left = eval(x+40)+'px';
	var InsuranceInfo = document.getElementById('InsuranceInfo_'+id);
	var w = InsuranceInfo.offsetWidth;
	document.getElementById('InsuranceInfo_'+id).style.width = w+'px';
	document.getElementById('InsuranceInfo_'+id).style.border = 'purple 1px dotted';
}
function hiddenInsuranceInfo(id){
	document.getElementById('InsuranceInfo_'+id).style.display = 'none';
}
document.onmousemove=move;