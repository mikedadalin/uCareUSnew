<style>
.MEname {
	 align: right;
	 background-color: rgb(255,255,255);
	 border-radius:5px;
	 padding:3px;
	 color:rgb(149,219,208);
	 font-size:16px;
	 word-wrap: break-word;
	 word-break: normal;
	 position:relative;
	 left:55%;
	 width:45%;
}
.MEmsgdate {
	 align: right;
	 background-color: rgb(255,255,255);
	 border-radius:5px;
	 padding:3px;
	 color:rgb(149,219,208);
	 font-size:8px;
	 word-wrap: break-word;
	 word-break: normal;
}
.MEmsg {
	 align: right;
	 background-color: rgb(149,219,208);
	 border-radius:5px;
	 padding:3px;
	 color:white;
	 font-size:16px;
	 word-wrap: break-word;
	 word-break: normal;
	 position:relative;
	 left:55%;
	 width:45%;
}
.Strangername {
	 align: left;
	 background-color: rgb(255,255,255);
	 border-radius:5px;
	 padding:3px;
	 color:#FF95CA;
	 font-size:16px;
	 word-wrap: break-word;
	 word-break: normal;
	 position:relative;
	 left:0%;
	 width:45%;
}
.Strangermsgdate {
	 align: left;
	 background-color: rgb(255,255,255);
	 border-radius:5px;
	 padding:3px;
	 color:#FF95CA;
	 font-size:8px;
	 word-wrap: break-word;
	 word-break: normal;
}
.Strangermsg {
	 align: left;
	 background-color:#FF95CA;
	 border-radius:5px;
	 padding:3px;
	 color:white;
	 font-size:16px;
	 word-wrap: break-word;
	 word-break: normal;
	 position:relative;
	 left:0%;
	 width:45%;
}
</style>
<script>
Date.prototype.format = function(fmt) {
	var o = {
		'M+':this.getMonth()+1,
		'd+':this.getDate(),
		'H+':this.getHours(),
		'm+':this.getMinutes(),
		's+':this.getSeconds(),
		'q+':Math.floor((this.getMonth()+3)/3),
		'S':this.getMilliseconds(),
	};
	if(/(y+)/.test(fmt))
		fmt = fmt.replace(RegExp.$1,(this.getFullYear()+"").substr(4-RegExp.$1.length));
	for(var k in o)
		if(new RegExp("("+k+")").test(fmt))
			fmt = fmt.replace(RegExp.$1,(RegExp.$1.length==1)?(o[k]):(("00"+o[k]).substr((""+o[k]).length)));
		return fmt;
}
function sendmsg() {
	var i = $("#me-i").val();
	var name = $("#username").val();
	var msg = $("#msg").val();
	var date = new Date().format('MM-dd-yyyy HH:mm:ss');
	
	var username = document.createElement("div");
	username.id = 'mename'+i;
    username.innerHTML = '&nbsp;'+name+": ";
    var n = document.getElementById("msgform");
    n.appendChild(username);
	document.getElementById('mename'+i).className = 'MEname';
	
	var msgdate = document.createElement("font");
	msgdate.id = 'memsgdate'+i;
    msgdate.innerHTML = "( "+date+" )";
    var t = document.getElementById('mename'+i);
    t.appendChild(msgdate);
	document.getElementById('memsgdate'+i).className = 'MEmsgdate';
	
	
    var div = document.createElement("div");
	div.id = 'me'+i;
    div.innerHTML = '&nbsp;'+msg;
	var s = document.getElementById("msgform");
    s.appendChild(div);
	document.getElementById('msg').value = '';
	document.getElementById('me'+i).className = 'MEmsg';
	
	var i = new Number($("#me-i").val());
	document.getElementById('me-i').value = eval(i+1);
}
function sendmsg2() {
	var j = $("#stranger-j").val();
	var name = 'God of Computer';
	var msg = $("#msg2").val();
	var date = new Date().format('MM-dd-yyyy HH:mm:ss');
	
	var strangername = document.createElement("div");
	strangername.id = 'strangername'+j;
    strangername.innerHTML = '&nbsp;'+name+": ";
    var n = document.getElementById("msgform");
    n.appendChild(strangername);
	document.getElementById('strangername'+j).className = 'Strangername';
	
	var msgdate = document.createElement("font");
	msgdate.id = 'strangermsgdate'+j;
    msgdate.innerHTML = "( "+date+" )";
    var t = document.getElementById('strangername'+j);
    t.appendChild(msgdate);
	document.getElementById('strangermsgdate'+j).className = 'Strangermsgdate';
	
	
    var div = document.createElement("div");
	div.id = 'stranger'+j;
    div.innerHTML = '&nbsp;'+msg;
	var s = document.getElementById("msgform");
    s.appendChild(div);
	document.getElementById('msg2').value = '';
	document.getElementById('stranger'+j).className = 'Strangermsg';
	
	var j = new Number($("#stranger-j").val());
	document.getElementById('stranger-j').value = eval(j+1);
}
</script>
<div style="background-color:rgba(255,255,255,1); padding:10px; width:50%; border-radius:20px;">
<center><h2><font style="color:rgb(149,219,208);">Message</font></h2></center>
<input type="hidden" id="username" value="<?php echo $_SESSION['ncareName_lwj'];?>">
<input type="hidden" id="me-i" value="">
<input type="hidden" id="stranger-j" value="">
<div id="msgform"></div><br><br>
<center><div><input type="text" name="msg2" id="msg2" value="" size="50"/><input type="button" value="Send message" onclick="sendmsg2()"></div></center>
<center><div><input type="text" name="msg" id="msg" value="" size="50"/><input type="button" value="Send message" onclick="sendmsg()"></div></center>
</div>