function openVerificationForm(OpenFormID){   //onclick="openVerificationForm('#欲開啟視窗ID');"
	document.getElementById('iVN').value = "";
	document.getElementById('OpenFormID').value = OpenFormID;
	document.getElementById('VerificationForm').style.display = "inline";
}
function showVerificationNumber(){
	document.getElementById('iVNerror').style.display = "none";
	document.getElementById('iVN').style.display = "inline";
}
function inputVerificationNumber(id){
	var arrID = id.split("_");
	document.getElementById('iVN').value = document.getElementById('iVN').value + arrID[1];
	var number = document.getElementById('iVN').value.length;
	if(number==4){
		$.ajax({
			url: 'class/checkVN.php',
			type: "POST",
			async: false,
			data: { iVN: document.getElementById('iVN').value }
		}).done(function(CheckStatus){
			if(CheckStatus=="YES"){
				document.getElementById('ErrorTime').value = 0;
				document.getElementById('iVN').value = "";
				document.getElementById('VerificationForm').style.display = "none";
				var OpenFormID = document.getElementById('OpenFormID').value;
				$(OpenFormID).dialog( "open" );
			}else if(CheckStatus=="NO"){
				if(document.getElementById('ErrorTime').value==""){ document.getElementById('ErrorTime').value=0; }
				document.getElementById('ErrorTime').value = eval(parseInt(document.getElementById('ErrorTime').value)+1);
				if(document.getElementById('ErrorTime').value==4){
					alert("Log out!");
					window.onbeforeunload=null;
					window.location.href='logout.php';
				}
				document.getElementById('iVN').value = "";
				document.getElementById('iVN').style.display = "none";
				document.getElementById('iVNerror').style.display = "inline";
				setTimeout("showVerificationNumber()",800);
			}
		});
	}
}
function deleteVerificationNumber(){
	var number = eval(document.getElementById('iVN').value.length - 1);
	document.getElementById('iVN').value = document.getElementById('iVN').value.substr(0,number);
}
function closeVerificationForm(){
	document.getElementById('iVN').value = "";
	document.getElementById('VerificationForm').style.display = "none";
}


function openVerificationForm2(ShowSubmitID){
	document.getElementById('ShowSubmitID').value = "submit_" + ShowSubmitID;
	document.getElementById('VerificationForm2').style.display = "inline";
}
function showVerificationNumber2(){
	document.getElementById('iVNerror2').style.display = "none";
	document.getElementById('iVN2').style.display = "inline";
}
function inputVerificationNumber2(id){
	var arrID = id.split("_");
	document.getElementById('iVN2').value = document.getElementById('iVN2').value + arrID[1];
	var number = document.getElementById('iVN2').value.length;
	if(number==4){
		$.ajax({
			url: 'class/checkVN.php',
			type: "POST",
			async: false,
			data: { iVN: document.getElementById('iVN2').value }
		}).done(function(CheckStatus){
			if(CheckStatus=="YES"){
				document.getElementById('ErrorTime2').value = 0;
				document.getElementById('iVN2').value = "";
				document.getElementById('VerificationForm2').style.display = "none";
				var ShowSubmitID = document.getElementById('ShowSubmitID').value;
				document.getElementById(ShowSubmitID).style.display = "inline";
				var arrShowSubmitID = ShowSubmitID.split("_");
				if(arrShowSubmitID[1]=="NursingHandover" || arrShowSubmitID[1]=="NursingRecord"){
					document.getElementById('VNFormOpen_' + arrShowSubmitID[1]).style.display = "none";
				}else{
					document.getElementById('VNFormOpen').style.display = "none";
				}
			}else if(CheckStatus=="NO"){
				if(document.getElementById('ErrorTime2').value==""){ document.getElementById('ErrorTime2').value=0; }
				document.getElementById('ErrorTime2').value = eval(parseInt(document.getElementById('ErrorTime2').value)+1);
				if(document.getElementById('ErrorTime2').value==4){
					alert("Log out!");
					window.onbeforeunload=null;
					window.location.href='logout.php';
				}
				document.getElementById('iVN2').value = "";
				document.getElementById('iVN2').style.display = "none";
				document.getElementById('iVNerror2').style.display = "inline";
				setTimeout("showVerificationNumber2()",800);
			}
		});
	}
}
function deleteVerificationNumber2(){
	var number = eval(document.getElementById('iVN2').value.length - 1);
	document.getElementById('iVN2').value = document.getElementById('iVN2').value.substr(0,number);
}
function closeVerificationForm2(){
	document.getElementById('iVN2').value = "";
	document.getElementById('VerificationForm2').style.display = "none";
}