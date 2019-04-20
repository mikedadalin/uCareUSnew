function gotoselecteddate() {
    var e = document.getElementById("inputeddate").value;
    var t = location.search;
    var n, r;
    var i = [];
    if (t.indexOf("?") != -1) {
        var s = t.split("?");
        n = s[1].split("&");
        for (a = 0; a < n.length; a++) {
            r = n[a].split("=");
            i.push(r[0]);
            if (r[0] == "date") {
                i[r[0]] = e;
                var o = true
            } else {
                i[r[0]] = r[1];
                var o = false
            }
        }
    }
    if (o == false) {
        i.push("date");
        i["date"] = e
    }
    var u = "";
    for (var a = 0; a < i.length; a++) {
        if (a > 0) {
            u = u + "&"
        }
        u = u + i[a] + "=" + i[i[a]]
    }
    window.location.href = "index.php?" + u
}

function checkForm() {
    var e = 0;
    var t = "";
    if (document.getElementById("date").value != "") {
        var n = document.getElementById("date").value;
        var r = /^(\d{4})\/(\d{2})\/(\d{2})$/.exec(n);
        if (!r) {
            document.getElementById("date").style.backgroundColor = "#FFCC66";
            e++;
            t = "填寫日期格式不正確"
        }
    } else {
        document.getElementById("date").style.backgroundColor = "#FFCC66";
        e++;
        t = "未輸入填寫日期"
    } if (e == 0) {
        return true
    } else {
        alert(t);
        $("#date").focus();
        return false
    }
}

function inputdate(e) {
    var t = new Date;
    var n = t.getDate();
    var r = t.getMonth() + 1;
    var i = t.getFullYear();
    if (n < 10) {
        n = "0" + n
    }
    if (r < 10) {
        r = "0" + r
    }
    t = i + "/" + r + "/" + n;
    document.getElementById(e).value = t
}

function hoverbtn(id, position, size) {
    if (document.getElementById(id).className == "tabbtn_" + size + "_" + position + "_off") {
        document.getElementById(id).className = "tabbtn_" + size + "_" + position + "_on"
    } else if (document.getElementById(id).className == "tabbtn_" + size + "_" + position + "_hold") {
        document.getElementById(id).className = "tabbtn_" + size + "_" + position + "_hold"
    }
}

function outbtn(id, position, size) {
    if (document.getElementById(id).className == "tabbtn_" + size + "_" + position + "_on") {
        document.getElementById(id).className = "tabbtn_" + size + "_" + position + "_off"
    }
}

function click_single_btn(id, position, size, groupid, elements) {
    var btnid = id.replace("btn_", "");
    if (document.getElementById(id).className == "tabbtn_" + size + "_" + position + "_on") {
        for (i = 1; i <= elements; i++) {
            var classname = document.getElementById('btn_' + groupid + '_' + i).className;
            var classarr = classname.split("_");
            document.getElementById('btn_' + groupid + '_' + i).className = classarr[0] + '_' + classarr[1] + '_' + classarr[2] + '_off';
            document.getElementById(groupid + '_' + i).value = "0"
        }
        document.getElementById(id).className = "tabbtn_" + size + "_" + position + "_hold";
        document.getElementById(btnid).value = "1"
    } else {
        document.getElementById(id).className = "tabbtn_" + size + "_" + position + "_off";
        document.getElementById(btnid).value = "0"
    }
}

function click_multi_btn(id, position, size, groupid, elements) {
    var btnid = id.replace("btn_", "");
    if (document.getElementById(id).className == "tabbtn_" + size + "_" + position + "_on") {
        document.getElementById(id).className = "tabbtn_" + size + "_" + position + "_hold";
        document.getElementById(btnid).value = "1"
    } else {
        document.getElementById(id).className = "tabbtn_" + size + "_" + position + "_off";
        document.getElementById(btnid).value = "0"
    }
}

function hovercheckbox(id) {
    if (document.getElementById(id).className == "checkbox_off") {
        document.getElementById(id).className = "checkbox_on"
    } else if (document.getElementById(id).className == "checkbox_on") {
        document.getElementById(id).className = "checkbox_on"
    }
}

function outcheckbox(id) {
    if (document.getElementById(id).className == "checkbox_on") {
        document.getElementById(id).className = "checkbox_off"
    }
}

function click_multi_checkbox(id, groupid, elements) {
    var btnid = id.replace("btn_", "");
    if (document.getElementById(id).className == "checkbox_on") {
        document.getElementById(id).className = "checkbox_on";
        document.getElementById(btnid).value = "1"
    } else {
        document.getElementById(id).className = "checkbox_off";
        document.getElementById(btnid).value = "0"
    }
}

function click_single_checkbox(id, groupid, elements) {
    var btnid = id.replace("btn_", "");
    if (document.getElementById(id).className == "checkbox_on") {
        for (i = 1; i <= elements; i++) {
            var classname = document.getElementById('btn_' + groupid + '_' + i).className;
            var classarr = classname.split("_");
            document.getElementById('btn_' + groupid + '_' + i).className = classarr[0] + '_off';
            document.getElementById(groupid + '_' + i).value = "0"
        }
        document.getElementById(id).className = "checkbox_on";
        document.getElementById(btnid).value = "1"
    } else {
        document.getElementById(id).className = "checkbox_off";
        document.getElementById(btnid).value = "0"
    }
}