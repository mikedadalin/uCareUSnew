// JScript 檔

function TextCheck(txtObj, theField) { //文字欄位元輸入檢查（文字欄位元，欄位元名稱）
	if (txtObj.value == '') {
	    alert('請輸入' + theField + '!'); txtObj.focus(); return false;
	}
	return true;
}

function TextareaCheck(txaObj, nLen, theField) { //多行文字欄位元輸入長度檢查（文字欄位元，長度，欄位名稱）
	if (txaObj.value.length > nLen) {
	    alert(theField + '過長!'); txtObj.focus(); return false;
	}
	return true;
}

function CheckboxCheck(chkObj, theField) { //核取方塊核取檢查（核取方塊，欄位名稱）
	if (!chkObj.checked) {
	    alert('請核取' + theField + '!'); txtObj.focus(); return false;
	}
	return true;
}

function RadioCheck(rdoObj, theField) { //選項按鈕核取檢查（選項按鈕，欄位元名稱）
	var bChecked = false;
	for (var i = 0; i < rdoObj.length; i++) {
		if (rdoObj[i].checked) {bChecked = true; break;}
	}
	if (!bChecked) {
	    alert('請核取' + theField + '!'); txtObj.focus(); return false;
	}
	return true;
}

function SelectCheck(selObj, theField) { //選單選取檢查（選單，欄位名稱）
	if (selObj.options[selObj.selectedIndex].value == '') {
		alert('請選取' + theField + '!'); selObj.focus(); return false;
	}
	return true;
}

//刪除選取檢查
function DelDataCheck(chkObj) {
	var del_ck = false;
	if (chkObj != null) {
		if (chkObj.length != null) {
			for (i=0;i < chkObj.length;i++) {
				if (chkObj[i].checked == true) {
					del_ck = true;
					break;
				}
			}
		} else {
			if (chkObj.checked == true){del_ck = true;}
		}
	}
	if (del_ck == true) {
		if (!confirm("確定是否刪除所選取之記錄 !!")){return false;}
		else{return true;}
	} else {
        alert("無勾選刪除資料!");return false;
    }
}

//回覆選取檢查
function ReplyDataCheck(chkObj) {
	var del_ck = false;
	if (chkObj != null) {
		if (chkObj.length != null) {
			for (i=0;i < chkObj.length;i++) {
				if (chkObj[i].checked == true) {
					del_ck = true;
					break;
				}
			}
		} else {
			if (chkObj.checked == true){del_ck = true;}
		}
	}
	if (del_ck == true) {
		if (!confirm("確定是否回覆所選取之記錄 !!")){return false;}
		else{return true;}
	} else {
        alert("無勾選回覆資料!");return false;
    }
}


//刪除選取
function DoSelectCk(selObj_Str, selTy) {
    var selectall = false;
    var selObj = eval('window.document.' + selObj_Str);
    if (selObj != null) {
        if (selObj.length == null) {
            selObj.checked=!selObj.checked;
        } else {
	        for (i=0; i < selObj.length ;i++) {
                if ((selTy==true) && (!selObj[i].checked))
                    selectall=true;
                selObj[i].checked = selTy;
            }
            if ((selectall==false) && (selTy==true))
                DoSelectCk(selObj_Str,false);
        }
    }
}

// 全選
function checkAll_group(obj){
    if(obj.checked==true){
        for (var i=0;i<document.forms[0].length;i++){
            if(document.forms[0].elements[i].name.indexOf('chk') >=0){
                document.forms[0].elements[i].checked=true;
            }
        }	
    }else{
        for (var i=0;i<document.forms[0].length;i++){
            if(document.forms[0].elements[i].name.indexOf('chk') >=0){
                document.forms[0].elements[i].checked=false;
            }
        }
    }
}

//ajax active物件判斷
function Js_createXMLHttpRequest() {
    if(window.ActiveXObject) {
        var Js_xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    } else {
        var Js_xmlHttp = new XMLHttpRequest();
    }
    return Js_xmlHttp;
}

var local=new Array(34)
	local[10]='A';
	local[11]='B';
	local[12]='C';
	local[13]='D';
	local[14]='E';
	local[15]='F';
	local[16]='G';
	local[17]='H';
	local[18]='J';
	local[19]='K';
	local[20]='L';
	local[21]='M';
	local[22]='N';
	local[23]='P';
	local[24]='Q';
	local[25]='R';
	local[26]='S';
	local[27]='T';
	local[28]='U';
	local[29]='V';
	local[32]='W';
	local[30]='X';
	local[31]='Y';
	local[33]='Z';

function chkEmail(obj){
  if (obj==''){
    alert('請輸入E-Mail!!');
      return false;
  }else{
    var pattern= /^[\w\.\-]+@([\w\-]+\.)+[a-zA-Z]+$/;
    if (pattern.test(obj) == false){
      alert('您輸入的E-Mail有誤!!');
      return false;
    }
  }
}
function getCheckedValue(radioObj) {
	if(!radioObj)
		return "";
	var radioLength = radioObj.length;
	if(radioLength == undefined)
		if(radioObj.checked)
			return radioObj.value;
		else
			return "";
	for(var i = 0; i < radioLength; i++) {
		if(radioObj[i].checked) {
			return radioObj[i].value;
		}
	}
	return "";
}
function checkid(id) {
	id=id.toUpperCase();
	var obj2=document.getElementById('spnName2');
	if(lengtherr(id)) {
		obj2.innerHTML='<font color="red">您輸入的身分證字號有誤!!</font>';		
		return false;
//	} else if(firstlettererr(id)) {
//		obj2.innerHTML='<font color="red">您輸入的身分證字號有誤!!</font>';
//		return false;
	} else if(numerr(id)) {
		obj2.innerHTML='<font color="red">您輸入的身分證字號有誤!!</font>';
		return false;
	} else if(checkerr(id)) {
		obj2.innerHTML='<font color="red">您輸入的身分證字號有誤!!</font>';
		return false;
	} else {
		obj2.innerHTML='';
		return true;
		//alert('您輸入的身分證字號完全正確！');
	}
}

function lengtherr(id) {
	if(id.length<10)
		return 1;
	else 
		return 0;
}

function firstlettererr(id) {
	var fl=id.substring(0,1)
	var haserr=1
	for(i=10;i<=33;i++) {
		if(local[i]!=fl)
			continue;
		else{ 
			haserr=0;
			break;
		}
	}
	if(haserr==1)
		return 1;
	else
		return 0;
}

function numerr(id) {
	var haserr=0;
	for(i=1;i<=9;i++) {
		if(parseInt(id.substring(i,i+1))>0 || id.substring(i,i+1)=='0')
			continue;
		else {
			haserr=1;
			break;
		}
	}
	if(haserr==1)
		return 1;
	else
		return 0;
}

function checkerr(id) {
	var se=new Array(10);
	var we=0;
	var checkcode=0;
	for(i=10;i<=33;i++) {
		if(local[i]==id.substring(0,1)) {
			se[0]=parseInt((i+'0').substring(0,1));
			se[1]=parseInt((i+'0').substring(1,2));
			break;
		} 
	}
	for(i=1;i<=9;i++) {
		se[i+1]=parseInt(id.substring(i,i+1));
	}
	for(i=0;i<=10;i++) {
		if(i==0)
			we=we+se[i];
		else
			we=we+(se[i]*(10-i));
	} 
	checkcode=((10-mod(we,10))+'0').substring(0,1);
	if(checkcode!=id.substring(9,10))
		return 1;
	else
		return 0;
}

function mod(a,b) {
	var r;
	r=Math.round(a/b);
	if((b*r)>a)
		r-=1;
	return (a-(b*r));
}








$(function(){
  $(".mainTable tr")
    .mouseover(function() {
      $(this).addClass("over");})
    .mouseout(function() {
      $(this).removeClass("over");});
  $(".mainTable tr:even").addClass("even");
  $(".mainTable tr:odd").addClass("odd");
});
