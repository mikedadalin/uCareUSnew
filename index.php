<?php
session_start();
include("class/DB.php");
include("class/error.php");
include("class/array.php");
include("class/function.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="expires" content="0">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="Images/mainLogo.png"></link>
<title>U-ARK America UCare System</title>
<!--<OBJECT id=NHICardReader codeBase="js/NHICardReaderOCX.ocx#version=0,5,0,40" classid=clsid:1BFA1079-2761-4FF6-8499-5D886F7D972E width=2 align=center height=1></OBJECT>-->
<script>
if(navigator.appName.indexOf("Internet Explorer")!=-1)document.onmousedown=noSourceExplorer;function noSourceExplorer(){if(event.button==2|event.button==3){}}function NoRightClick(evnt){if(navigator.appName.toUpperCase().match(/NETSCAPE/)!=null){if(evnt.which==3){return false}}else if(event.button==2){}}document.onmousedown=NoRightClick;
function gotoselecteddate(){
	var seldate=document.getElementById('inputeddate').value;
	var strUrl = location.search;
	var getPara, ParaVal;
	var aryPara = [];
	if (strUrl.indexOf("?") != -1) {
		var getSearch = strUrl.split("?");
		getPara = getSearch[1].split("&");
		for (i = 0; i < getPara.length; i++) {
			ParaVal = getPara[i].split("=");
			aryPara.push(ParaVal[0]);
			if (ParaVal[0]=='date') {
				aryPara[ParaVal[0]] = seldate;
				var dateInArray = true;
			} else {
				aryPara[ParaVal[0]] = ParaVal[1];
				var dateInArray = false;
			}
		}
	}
	if (dateInArray==false) {
		aryPara.push('date');
		aryPara['date'] = seldate;
	}
	var QueryString = '';
	for (var i=0; i<aryPara.length; i++) {
		if (i>0) { QueryString = QueryString + "&"; }
		QueryString = QueryString + aryPara[i] + "=" + aryPara[aryPara[i]] ;
	}
	window.location.href='index.php?'+QueryString;
}
function checkForm(){if(document.getElementById('date').value.length!=0){var d=document.getElementById('date').value;var match=/^(\d{4})\/(\d{2})\/(\d{2})$/.exec(d);if(!match){document.getElementById('date').style.backgroundColor='#FFCC66';alert("填寫日期格式不正確");return false}else{return true}}else{document.getElementById('date').style.backgroundColor='#FFCC66';alert("未輸入填寫日期");return false}}function inputdate(id){var today=new Date();var dd=today.getDate();var mm=today.getMonth()+1;var yyyy=today.getFullYear();if(dd<10){dd='0'+dd}if(mm<10){mm='0'+mm}today=yyyy+'/'+mm+'/'+dd;document.getElementById(id).value=today}function hoverbtn(id,position,size){if(document.getElementById(id).className=="tabbtn_"+size+"_"+position+"_off"){document.getElementById(id).className="tabbtn_"+size+"_"+position+"_on"}else if(document.getElementById(id).className=="tabbtn_"+size+"_"+position+"_hold"){document.getElementById(id).className="tabbtn_"+size+"_"+position+"_hold"}}function outbtn(id,position,size){if(document.getElementById(id).className=="tabbtn_"+size+"_"+position+"_on"){document.getElementById(id).className="tabbtn_"+size+"_"+position+"_off"}}function click_single_btn(id,position,size,groupid,elements){var btnid=id.replace("btn_","");if(document.getElementById(id).className=="tabbtn_"+size+"_"+position+"_on"){for(i=1;i<=elements;i++){var classname=document.getElementById('btn_'+groupid+'_'+i).className;var classarr=classname.split("_");document.getElementById('btn_'+groupid+'_'+i).className=classarr[0]+'_'+classarr[1]+'_'+classarr[2]+'_off';document.getElementById(groupid+'_'+i).value="0"}document.getElementById(id).className="tabbtn_"+size+"_"+position+"_hold";document.getElementById(btnid).value="1"}else{document.getElementById(id).className="tabbtn_"+size+"_"+position+"_off";document.getElementById(btnid).value="0"}}function click_multi_btn(id,position,size,groupid,elements){var btnid=id.replace("btn_","");if(document.getElementById(id).className=="tabbtn_"+size+"_"+position+"_on"){document.getElementById(id).className="tabbtn_"+size+"_"+position+"_hold";document.getElementById(btnid).value="1"}else{document.getElementById(id).className="tabbtn_"+size+"_"+position+"_off";document.getElementById(btnid).value="0"}}function hovercheckbox(id){if(document.getElementById(id).className=="checkbox_off"){document.getElementById(id).className="checkbox_on"}else if(document.getElementById(id).className=="checkbox_hold"){document.getElementById(id).className="checkbox_hold"}}function outcheckbox(id){if(document.getElementById(id).className=="checkbox_on"){document.getElementById(id).className="checkbox_off"}}function click_multi_checkbox(id,groupid,elements){var btnid=id.replace("btn_","");if(document.getElementById(id).className=="checkbox_on"){document.getElementById(id).className="checkbox_hold";document.getElementById(btnid).value="1"}else{document.getElementById(id).className="checkbox_off";document.getElementById(btnid).value="0"}}function click_single_checkbox(id,groupid,elements){var btnid=id.replace("btn_","");if(document.getElementById(id).className=="checkbox_on"){for(i=1;i<=elements;i++){var classname=document.getElementById('btn_'+groupid+'_'+i).className;var classarr=classname.split("_");document.getElementById('btn_'+groupid+'_'+i).className=classarr[0]+'_off';document.getElementById(groupid+'_'+i).value="0"}document.getElementById(id).className="checkbox_hold";document.getElementById(btnid).value="1"}else{document.getElementById(id).className="checkbox_off";document.getElementById(btnid).value="0"}}
</script>
<script type="text/javascript" src="js/flot/jquery.js"></script>
<script type="text/javascript" src="js/jquery-latest.pack.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.0.custom.js"></script>
<script type="text/javascript" src="js/custom-form-elements.js"></script>
<script type="text/javascript" src="js/go.js"></script>

<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/flot/excanvas.min.js"></script><![endif]-->
<script type="text/javascript" src="js/flot/excanvas.js"></script>
<script type="text/javascript" src="js/flot/jquery.flot.js"></script>
<script type="text/javascript" src="js/flot/jquery.flot.navigate.js"></script>
<script type="text/javascript" src="js/flot/jquery.flot.crosshair.js"></script>
<script type="text/javascript" src="js/flot/jquery.flot.pie.js"></script>

<link type="text/css" rel="stylesheet" href="css/jquery-ui-1.10.0.custom.css">
<link type="text/css" rel="stylesheet" href="css/jquery.autocomplete.css" />
<link type="text/css" rel="stylesheet" href="css/style.css" />
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
</head>

<body onSelectStart="event.returnValue=false" oncontextmenu="window.event.returnValue=false;" ondragstart="window.event.returnValue=false" onkeydown="if(event.ctrlKey || event.keyCode==67 && event.ctrlKey) { event.returnValue=false }">

<?php
if (@$_GET['error']!=NULL) { echo "<script>alert('".$arrError[@$_GET['error']]."');</script>"; }
?>
<center>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>
<?php
if (!isset($_SESSION['ncareID_lwj']) && @$_GET['func']!="loginprocess") {
	include('uCareSystemLogin.php');
} else {
	if (@$_GET['mod']==NULL) {
		if (@$_GET['func']==NULL) { include('home.php'); } else { include(@$_GET['func'].'.php'); }
	} else {
		include('module/'.@$_GET['mod'].'/'.@$_GET['func'].'.php');
	}
}
?>
    </td>
  </tr>
</table>
</center>
</body>
</html>