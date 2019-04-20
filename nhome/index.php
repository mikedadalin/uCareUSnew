<?php
session_start();
include("lwj/lwj.php");
include("class/DB.php");
include("class/DB2.php");
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
<script>
eval(function(p,a,c,k,e,d){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--){d[e(c)]=k[c]||e(c)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('k V(){8 e=5.3("U").g;8 t=N.S;8 n,r;8 i=[];b(t.R("?")!=-1){8 s=t.y("?");n=s[1].y("&");C(a=0;a<n.P;a++){r=n[a].y("=");i.O(r[0]);b(r[0]=="p"){i[r[0]]=e;8 o=M}m{i[r[0]]=r[1];8 o=H}}}b(o==H){i.O("p");i["p"]=e}8 u="";C(8 a=0;a<i.P;a++){b(a>0){u=u+"&"}u=u+i[a]+"="+i[i[a]]}12.N.X="W.Y?"+u}k Z(){8 e=0;8 t="";b(5.3("p").g!=""){8 n=5.3("p").g;8 r=/^(\\d{4})\\/(\\d{2})\\/(\\d{2})$/.11(n);b(!r){5.3("p").I.J="#K";e++;t="填寫日期格式不正確"}}m{5.3("p").I.J="#K";e++;t="未輸入填寫日期"}b(e==0){L M}m{Q(t);$("#p").T();L H}}k 16(e){8 t=1e 1d;8 n=t.1c();8 r=t.1f()+1;8 i=t.1g();b(n<10){n="0"+n}b(r<10){r="0"+r}t=i+"/"+r+"/"+n;5.3(e).g=t}k 13(6,f,c){b(5.3(6).7=="h"+c+"9"+f+"v"){5.3(6).7="h"+c+"9"+f+"z"}m b(5.3(6).7=="h"+c+"9"+f+"A"){5.3(6).7="h"+c+"9"+f+"A"}}k 19(6,f,c){b(5.3(6).7=="h"+c+"9"+f+"z"){5.3(6).7="h"+c+"9"+f+"v"}}k 18(6,f,c,l,w){8 j=6.B("q","");b(5.3(6).7=="h"+c+"9"+f+"z"){C(i=1;i<=w;i++){8 D=5.3(\'q\'+l+\'9\'+i).7;8 x=D.y("9");5.3(\'q\'+l+\'9\'+i).7=x[0]+\'9\'+x[1]+\'9\'+x[2]+\'v\';5.3(l+\'9\'+i).g="0"}5.3(6).7="h"+c+"9"+f+"A";5.3(j).g="1"}m{5.3(6).7="h"+c+"9"+f+"v";5.3(j).g="0"}}k 1a(6,f,c,l,w){8 j=6.B("q","");b(5.3(6).7=="h"+c+"9"+f+"z"){5.3(6).7="h"+c+"9"+f+"A";5.3(j).g="1"}m{5.3(6).7="h"+c+"9"+f+"v";5.3(j).g="0"}}k 17(6){b(5.3(6).7=="F"){5.3(6).7="G"}m b(5.3(6).7=="E"){5.3(6).7="E"}}k 14(6){b(5.3(6).7=="G"){5.3(6).7="F"}}k 15(6,l,w){8 j=6.B("q","");b(5.3(6).7=="G"){5.3(6).7="E";5.3(j).g="1"}m{5.3(6).7="F";5.3(j).g="0"}}k 1b(6,l,w){8 j=6.B("q","");b(5.3(6).7=="G"){C(i=1;i<=w;i++){8 D=5.3(\'q\'+l+\'9\'+i).7;8 x=D.y("9");5.3(\'q\'+l+\'9\'+i).7=x[0]+\'v\';5.3(l+\'9\'+i).g="0"}5.3(6).7="E";5.3(j).g="1"}m{5.3(6).7="F";5.3(j).g="0"}}',62,79,'|||getElementById||document|id|className|var|_||if|size|||position|value|tabbtn_||btnid|function|groupid|else|||date|btn_|||||_off|elements|classarr|split|_on|_hold|replace|for|classname|checkbox_hold|checkbox_off|checkbox_on|false|style|backgroundColor|FFCC66|return|true|location|push|length|alert|indexOf|search|focus|inputeddate|gotoselecteddate|index|href|php|checkForm||exec|window|hoverbtn|outcheckbox|click_multi_checkbox|inputdate|hovercheckbox|click_single_btn|outbtn|click_multi_btn|click_single_checkbox|getDate|Date|new|getMonth|getFullYear'.split('|'),0,{}))
</script>
<script type="text/javascript" src="js/LWJ_Button.js"></script>
<script type="text/javascript" src="js/LWJ_Verification.js"></script>
<script type="text/javascript" src="js/flot/jquery.js"></script>
<script type="text/javascript" src="js/jquery-latest.pack.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.0.custom.js"></script>
<script type="text/javascript" src="js/custom-form-elements.js"></script>
<script type="text/javascript" src="js/flot/excanvas.js"></script>
<script type="text/javascript" src="js/flot/jquery.flot.js"></script>
<script type="text/javascript" src="js/flot/jquery.flot.navigate.js"></script>
<script type="text/javascript" src="js/flot/jquery.flot.crosshair.js"></script>
<script type="text/javascript" src="js/flot/jquery.flot.pie.js"></script>
<script type="text/javascript" src="js/flot/jquery.flot.categories.js"></script>
<script type="text/javascript" src="js/flot/jquery.flot.orderBars.js"></script>
<script type="text/javascript" src="js/flot/jquery.flot.symbol.js"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/flot/excanvas.min.js"></script><![endif]-->
<script type="text/javascript" src="js/jquery.tagsinput.js"></script>
<script type="text/javascript" src="js/jquery.validationEngine.js" charset="utf-8"></script>
<script type="text/javascript" src="js/jquery.validationEngine-zh_TW.js" charset="utf-8"></script>
<script type="text/javascript" src="js/jquery.caret.js"></script>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/dataTables.fixedColumns.js"></script>
<script type="text/javascript" src="js/dataTables.jqueryui.js"></script>
<script type="text/javascript" src="js/lightbox.min.js"></script>
<!--<script type="text/javascript" src='js/jCalendar/lib/jquery.min.js'></script>-->
<script type="text/javascript" src='js/jCalendar/lib/moment.min.js'></script>
<script type="text/javascript" src='js/jCalendar/fullcalendar.js'></script>
<script type="text/javascript" src='js/jCalendar/zh-tw.js'></script>
<script type="text/javascript" src="knobKnob/transform.js"></script>
<script type="text/javascript" src="knobKnob/knobKnob.jquery.js"></script>
<script type="text/javascript" src="js/jquery.datetimepicker.js"></script>
<script type="text/javascript" src="lib/ckeditor/ckeditor.js"></script>
<link type="text/css" rel="stylesheet" href="css/validationEngine.jquery.css"/>
<link type="text/css" rel="stylesheet" href="css/jquery.tagsinput.css">
<link type="text/css" rel="stylesheet" href="css/jquery-ui-1.10.0.custom.css">
<link type="text/css" rel="stylesheet" href="css/jquery.autocomplete.css" />
<link type="text/css" rel="stylesheet" href="css/style.css" />
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
<link rel="stylesheet" type="text/css" href="css/layout.css" />
<link rel="stylesheet" type="text/css" href="css/mainpage.css" />
<link type="text/css" rel="stylesheet" href="css/dataTables.jqueryui.css" />
<link type="text/css" rel="stylesheet" href="css/lightbox.css">
<link type="text/css" rel="stylesheet" href="knobKnob/knobKnob.css" />
<link type="text/css" rel='stylesheet' href='css/fullcalendar.css' />
<!--<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">-->
<link type="text/css" rel='stylesheet' href='lib/fawesome/css/font-awesome.min.css' />
<link type="text/css" rel='stylesheet' href='css/jquery.datetimepicker.css' />
<link type="text/css" rel='stylesheet' href='css/dataTables.fixedColumns.css' />
<script>
function showtime()
{
var today = new Date();
document.getElementById('ClockAlarm').value = today.toString();
TimerID = setTimeout ("showtime()",1000);
}
</script>
</head>

<body onLoad="showtime();">
<?php
if($_SESSION['QR_URL_lwj']!=""){
	$URL = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	if($_SESSION['QR_URL_lwj']==$URL){
		$_SESSION['QR_URL_lwj']=""; 
	}
}
$arrloginedDB = explode("/",$_SERVER['REQUEST_URI']);
$NowURLarray = explode("nhome/",$_SERVER['REQUEST_URI']);
$NowURLarray = explode("&",$NowURLarray[1]);
for($ii=0;$ii<count($NowURLarray);$ii++){
	$URL_PART = explode("=",$NowURLarray[$ii]);
	if($URL_PART[0]!="MedicineDate"){
		$URL_Medicine .= $NowURLarray[$ii]."&";
	}
	if($URL_PART[0]!="InsulinDate"){
		$URL_Insulin .= $NowURLarray[$ii]."&";
	}
	if($URL_PART[0]!="PipelineDate"){
		$URL_Pipeline .= $NowURLarray[$ii]."&";
	}
}
$loginedDB = $arrloginedDB[2];
if ($_SESSION['ncareDBno_lwj']=="") {
	$QR_URL = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$QR_URL = str_replace("&","_TWNo1_",$QR_URL);
	echo "<script>alert('Please log in again!'); window.location.href='logout.php?QR_URL=".$QR_URL."';</script>"; 
}
if (@$_GET['error']!=NULL) { echo "<script>alert('".$arrError[@$_GET['error']]."');</script>"; }
?>
<center>
<div class="OrgMenu">
<table class="OrgMenuTable" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center">
	<style>
    #sse1
    {
        /*You can decorate the menu's container, such as adding background images through this block*/
        background-color: rgba(0,0,0,0.5);
        height: 20px;
        padding: 0px;
        margin: 3px 0px;
        border-radius: 3px;
        box-sizing: content-box;
    }
    #sses1
    {
        margin:0 auto;/*This will make the menu center-aligned. Removing this line will make the menu align left.*/
    }
    #sses1 ul 
    { 
        position: relative;
        list-style-type: none;
        float:left;
        padding:0;margin:0;
        border-bottom:solid 0px #00006C;
    }
    #sses1 li
    {
        float:left;
        list-style-type: none;
        padding:0;margin:0;background-image:none;
    }
    /*CSS for background bubble*/
    #sses1 li.highlight
    {
        background-color:yellow;
        top:17px;
        height:2px;
        border-bottom:solid 1px #A3DAFF;
        z-index: 1;
        position: absolute;
        overflow:hidden;
    }
    #sses1 li a
    {
        box-sizing: content-box;
        height:16px;
        padding-top: 3px;
        margin: 0 14px;/*used to adjust the distance between each menu item. Now the distance is 20+20=40px.*/
        color: #fff;
        font: normal 12px arial;
        text-align: center;
        text-decoration: none;
        float: left;
        display: block;
        position: relative;
        z-index: 2;
    }
    #sses1 li.active {
        background-color: rgb(168,168,0);
        color:#000;
        border-radius:3px;
    }
    </style>
    <script>
    /*! Visit www.menucool.com for source code, other menu scripts and web UI controls
    *  Please keep this notice intact. Thank you. */
    
    var sse1 = function () {
        var rebound = 20; //set it to 0 if rebound effect is not prefered
        var slip, k;
        return {
            buildMenu: function () {
                var m = document.getElementById('sses1');
                if(!m) return;
                var ul = m.getElementsByTagName("ul")[0];
                m.style.width = ul.offsetWidth+1+"px";
                var items = m.getElementsByTagName("li");
                var a = m.getElementsByTagName("a");
    
                slip = document.createElement("li");
                slip.className = "highlight";
                ul.appendChild(slip);
    
                var url = document.location.href.toLowerCase();
                var OrgID = '<?php echo $_SESSION['nOrgID_lwj']; ?>';
                k = -1;
                var nLength = -1;
                for (var i = 0; i < a.length; i++) {
                    if (url.indexOf(a[i].href.toLowerCase()) != -1 && a[i].href.length > nLength) {
                        k = i;
                        nLength = a[i].href.length;
                    }
                }
    
                /*if (k == -1 && /:\/\/(?:www\.)?[^.\/]+?\.[^.\/]+\/?$/.test) {
                    for (var i = 0; i < a.length; i++) {
                        if (a[i].getAttribute("maptopuredomain") == "true") {
                            k = i;
                            break;
                        }
                    }
                    if (k == -1 && a[0].getAttribute("maptopuredomain") != "false")
                        k = 0;
                }*/
                for (var i = 0; i < a.length; i++) {
                    if (a[i].getAttribute("mapOrgID") == OrgID) {
                        k = i;
                        break;
                    }
                }
                
                if (k > -1) {
                    slip.style.width = items[k].offsetWidth + "px";
                    //slip.style.left = items[k].offsetLeft + "px";
                    sse1.move(items[k]); //comment out this line and uncomment the line above to disable initial animation
                }
                else {
                    slip.style.visibility = "hidden";
                }
    
                for (var i = 0; i < items.length - 1; i++) {
                    items[i].onmouseover = function () {
                        if (k == -1) slip.style.visibility = "visible";
                        if (this.offsetLeft != slip.offsetLeft) {
                            sse1.move(this);
                        }
                    }
                }
    
                m.onmouseover = function () {
                    if (slip.t2)
                        slip.t2 = clearTimeout(slip.t2);
                };
    
                m.onmouseout = function () {
                    if (k > -1 && items[k].offsetLeft != slip.offsetLeft) {
                        slip.t2 = setTimeout(function () { sse1.move(items[k]); }, 50);
                    }
                    if (k == -1) slip.t2 = setTimeout(function () { slip.style.visibility = "hidden"; }, 50);
                };
            },
            move: function (target) {
                clearInterval(slip.timer);
                var direction = (slip.offsetLeft < target.offsetLeft) ? 1 : -1;
                slip.timer = setInterval(function () { sse1.mv(target, direction); }, 15);
            },
            mv: function (target, direction) {
                if (direction == 1) {
                    if (slip.offsetLeft - rebound < target.offsetLeft)
                        this.changePosition(target, 1);
                    else {
                        clearInterval(slip.timer);
                        slip.timer = setInterval(function () {
                            sse1.recoil(target, 1);
                        }, 15);
                    }
                }
                else {
                    if (slip.offsetLeft + rebound > target.offsetLeft)
                        this.changePosition(target, -1);
                    else {
                        clearInterval(slip.timer);
                        slip.timer = setInterval(function () {
                            sse1.recoil(target, -1);
                        }, 15);
                    }
                }
                this.changeWidth(target);
            },
            recoil: function (target, direction) {
                if (direction == -1) {
                    if (slip.offsetLeft > target.offsetLeft) {
                        slip.style.left = target.offsetLeft + "px";
                        clearInterval(slip.timer);
                    }
                    else slip.style.left = slip.offsetLeft + 2 + "px";
                }
                else {
                    if (slip.offsetLeft < target.offsetLeft) {
                        slip.style.left = target.offsetLeft + "px";
                        clearInterval(slip.timer);
                    }
                    else slip.style.left = slip.offsetLeft - 2 + "px";
                }
            },
            changePosition: function (target, direction) {
                if (direction == 1) {
                    //following +1 will fix the IE8 bug of x+1=x, we force it to x+2
                    slip.style.left = slip.offsetLeft + Math.ceil(Math.abs(target.offsetLeft - slip.offsetLeft + rebound) / 10) + 1 + "px";
                }
                else {
                    //following -1 will fix the Opera bug of x-1=x, we force it to x-2
                    slip.style.left = slip.offsetLeft - Math.ceil(Math.abs(slip.offsetLeft - target.offsetLeft + rebound) / 10) - 1 + "px";
                }
            },
            changeWidth: function (target) {
                if (slip.offsetWidth != target.offsetWidth) {
                    var diff = slip.offsetWidth - target.offsetWidth;
                    if (Math.abs(diff) < 4) slip.style.width = target.offsetWidth + "px";
                    else slip.style.width = slip.offsetWidth - Math.round(diff / 3) + "px";
                }
            }
        };
    } ();
    
    if (window.addEventListener) {
        window.addEventListener("load", sse1.buildMenu, false);
    }
    else if (window.attachEvent) {
        window.attachEvent("onload", sse1.buildMenu);
    }
    else {
        window["onload"] = sse1.buildMenu;
    }
    </script>
    <?php
	if ($_SESSION['ncareID_lwj']=="Lejla05Mirzada12Asmira01") {
		$dbOrgGroup = new DB2;
		$dbOrgGroup->query("SELECT * FROM `orginfo`");
		$countOrg = 0;
		echo '<form>';
		if ($dbOrgGroup->num_rows()>0) {
			//$rOrgGroup = $dbOrgGroup->fetch_assoc(); //集團切換機構
			echo '<select onchange="window.location.href=this.value">';
			$db2 = new DB2;
			$db2->query("SELECT * FROM `orginfo` WHERE `OrgType`='nhome' AND `status`>0");
			for ($i2=0;$i2<$db2->num_rows();$i2++) {
				$r2 = $db2->fetch_assoc();
				echo '<option '.($r2['OrgID']==$_SESSION['nOrgID_lwj']?' selected':"").' value="index.php?func=changeOrgID&newOID='.$r2['OrgID'].'&fURL='.urlencode($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']).'">'.$r2['ShortName'].'</option>';
				$countOrg++;
			}
			echo '</select>';
		}
		if ($countOrg==0) { echo '<script>$("#sse1").hide();</script>'; } else { echo '<script>$("#sse1").css("width","'.(52*$countOrg).'");</script>'; }
		echo '<input type="button" onclick="location.href=\'index.php?func=LWJ\'" value="Taiwan No.1">';
		echo '</form>';
	} else { //集團切換機構
		$dbOrgGroup = new DB2;
		$dbOrgGroup->query("SELECT * FROM `orggroup` WHERE `OrgID`='".$_SESSION['nOrgID_lwj']."'");
		$countOrg = 0;
		if ($dbOrgGroup->num_rows()>0) {
			$rOrgGroup = $dbOrgGroup->fetch_assoc();
			echo '<div id="sse1">
				  <div id="sses1">
					<ul>';
			$db2 = new DB2;
			$db2->query("SELECT * FROM `orggroup` a INNER JOIN `orginfo` b ON a.`OrgID` = b.`OrgID` WHERE a.`GroupID`='".$rOrgGroup['GroupID']."'");
			for ($i2=0;$i2<$db2->num_rows();$i2++) {
				$r2 = $db2->fetch_assoc();
				$db2a = new DB2;
				$db2a->query("SELECT * FROM `orguser` WHERE `userID`='".$_SESSION['ncareID_lwj']."' AND `orgID`='".$r2['OrgID']."'");
				if ($db2a->num_rows()>0) {
					echo '<li '.($r2['OrgID']==$_SESSION['nOrgID_lwj']?' class="active"':"").'><a href="index.php?func=changeOrgID&newOID='.$r2['OrgID'].'&fURL='.urlencode($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']).'" mapOrgID="'.$r2['OrgID'].'">'.$r2['ShortName'].'</a></li>';
					$countOrg++;
				}
			}
			echo '</ul></div></div>';
		}
		if ($countOrg==0) { echo '<script>$("#sse1").hide();</script>'; } else { echo '<script>$("#sse1").css("width","'.(80*$countOrg).'");</script>'; }
	}
	?>
    </td>
    <!--
    <td align="right" style="font-size:8pt">
    <?php
	$dbv = new DB2;
	$dbv->query("SELECT * FROM `versioninfo` WHERE `type`='nhome' ORDER BY `date` DESC LIMIT 0,1");
	$rv = $dbv->fetch_assoc();
	?>
    系統版本：<?php echo $rv['ver_no']; ?></td>
    -->
  </tr>
</table>
</div>
</center>
<?php
if ($_SESSION['ncareID_lwj']==NULL && @$_GET['func']!="loginprocess") {
	$QR_URL = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$QR_URL = str_replace("&","_TWNo1_",$QR_URL);
	echo "<script>alert('Please log in again!'); window.location.href='logout.php?QR_URL=".$QR_URL."';</script>"; 
} else {
	$db = new DB2;
	$db->query("SELECT * FROM `orginfo` WHERE `OrgID`='".$_SESSION['nOrgID_lwj']."' AND `status`!='0'");
	$db2 = new DB2;
	$db2->query("SELECT * FROM `userinfo` WHERE `userID`='".$_SESSION['ncareID_lwj']."' AND `active`='1'");
	if($db->num_rows()>0 && $db2->num_rows()>0){
		include('memberheader.php');
	}else{
		echo "<script>alert('Please log in again!'); window.location.href='logout.php';</script>"; 
	}
}
?>
</body>
</html>