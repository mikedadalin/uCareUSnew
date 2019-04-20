function click_multi_btn2(id, position, size, groupid, elements) {
    var btnid = id.replace("btn_", "");
    if (document.getElementById(id).className == "tabbtn_" + size + "_" + position + "_off") {
        document.getElementById(id).className = "tabbtn_" + size + "_" + position + "_on";
        document.getElementById(btnid).value = "1";
    } else {
        document.getElementById(id).className = "tabbtn_" + size + "_" + position + "_off";
        document.getElementById(btnid).value = "0";
    }
}
function click_single_btn2(id, position, size, groupid, elements) {
    var btnid = id.replace("btn_", "");
    if (document.getElementById(id).className == "tabbtn_" + size + "_" + position + "_off") {
        for (i = 1; i <= elements; i++) {
            var classname = document.getElementById('btn_' + groupid + '_' + i).className;
            var classarr = classname.split("_");
            document.getElementById('btn_' + groupid + '_' + i).className = "tabbtn_" + size + '_' + classarr[2] + '_off';
            document.getElementById(groupid + '_' + i).value = "0";
        }
		document.getElementById(id).className = "tabbtn_" + size + "_" + position + "_on";
		document.getElementById(btnid).value = "1";
    } else {
        document.getElementById(id).className = "tabbtn_" + size + "_" + position + "_off";
        document.getElementById(btnid).value = "0";
    }
}
function click_multi_checkbox2(id, groupid, elements) {
    var btnid = id.replace("btn_", "");
    if (document.getElementById(id).className == "checkbox_off") {
        document.getElementById(id).className = "checkbox_on";
        document.getElementById(btnid).value = "1"
    } else {
        document.getElementById(id).className = "checkbox_off";
        document.getElementById(btnid).value = "0"
    }
}

function click_single_checkbox2(id, groupid, elements) {
    var btnid = id.replace("btn_", "");
    if (document.getElementById(id).className == "checkbox_off") {
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