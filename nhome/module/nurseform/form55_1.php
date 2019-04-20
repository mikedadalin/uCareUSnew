<?php
// fetching data from database
if (@$_GET['date']=='') {
    $sql = "SELECT * FROM `nurseform55_1` WHERE `HospNo`='".mysql_escape_string($r['HospNo'])."' ORDER BY `date` DESC LIMIT 0,1";
} else {
    $sql = "SELECT * FROM `nurseform55_1` WHERE `HospNo`='".mysql_escape_string($r['HospNo'])."' AND `date`='".mysql_escape_string(@$_GET['date'])."'";
}
$db1 = new DB;
$db1->query($sql);
$r1 = $db1->fetch_assoc();
if ($db1->num_rows()>0) {
    foreach ($r1 as $k=>$v) {
        if (substr($k,0,1)=="Q") {
            $arrAnswer = explode("_",$k);
            if (count($arrAnswer)==2) {
                if ($v==1) {
                    ${$arrAnswer[0]} .= $arrAnswer[1].';';
                }
            } else {
                ${$k} = $v;
            }
        }  else {
            ${$k} = $v;
        }
    }
}
?>


<style type="text/css" media="screen">
    input[type=number]{
        width:80%;
    }    
</style>

<h3 align="center">Inventory of Personal Effect</h3>
<div class="nurseform-table">
    
<form action="index.php?func=database&action=save" method="post" accept-charset="utf-8">
<table width="100%" align="center">
    <tr>
        <td rowspan="2" class="title" width="1px">Quantity</td>
        <td rowspan="2" class="title">Articles</td>
        <td rowspan="2" class="title">V</td>
        <td colspan="4" class="title">Item of specific value(rings, watches, radio etc.)</td>
        <td rowspan="2" class="title">V</td>
    </tr>
    <tr>
        <td colspan="3" class="title_s">Description</td>
        <td class="title_s" width="80px">Value</td>
    </tr>
    <tr>
        <td><input type="number" name="Q1" id="Q1" value="<?php echo $Q1;?>"></td>
        <td>Dresses</td>
        <td><?php echo draw_checkbox("Q2", "", $Q2, "single"); ?></td>
        <td colspan="3"><input type="text" style="width: 95%;" name="Q3" id="Q3" value="<?php echo $Q3;?>"></td>
        <td><input type="number" name="Q4" id="Q4" value="<?php echo $Q4;?>"></td>
        <td><?php echo draw_checkbox("Q5", "", $Q5, "single"); ?></td>
    </tr>
    <tr>
        <td><input type="number" name="Q6" id="Q6" value="<?php echo $Q6;?>"></td>
        <td>Lady Suits</td>
        <td><?php echo draw_checkbox("Q7", "", $Q7, "single"); ?></td> 
        <td colspan="3"><input value="<?php echo $Q8;?>" name="Q8" id="Q8" type="text" style="width: 95%;"></td>
        <td><input value="<?php echo $Q9;?>" name="Q9" id="Q9" type="number"></td>
        <td><?php echo draw_checkbox("Q10", "", $Q10, "single"); ?></td>
    </tr>
    <tr>
        <td><input value="<?php echo $Q11;?>" name="Q11" id="Q11" type="number"></td>
        <td>Coats</td>
        <td><?php echo draw_checkbox("Q12", "", $Q12, "single"); ?></td>
        <td colspan="3"><input value="<?php echo $Q13;?>" name="Q13" id="Q13" type="text" style="width: 95%;"></td>
        <td><input value="<?php echo $Q14;?>" name="Q14" id="Q14" type="number"></td>
        <td><?php echo draw_checkbox("Q15", "", $Q15, "single"); ?></td>
    </tr>
    <tr>
        <td><input value="<?php echo $Q16;?>" name="Q16" id="Q16" type="number"></td>
        <td>Furs</td>
        <td><?php echo draw_checkbox("Q17", "", $Q17, "single"); ?></td>
        <td colspan="3"><input value="<?php echo $Q18;?>" name="Q18" id="Q18" type="text" style="width: 95%;"></td>
        <td><input value="<?php echo $Q19;?>" name="Q19" id="Q19" type="number"></td>
        <td><?php echo draw_checkbox("Q20", "", $Q20, "single"); ?></td>
    </tr>
    <tr>
        <td><input value="<?php echo $Q21;?>" name="Q21" id="Q21" type="number"></td>
        <td>Lady Shoes</td>
        <td><?php echo draw_checkbox("Q22", "", $Q22, "single"); ?></td>
        <td colspan="3"><input value="<?php echo $Q23;?>" name="Q23" id="Q23" type="text" style="width: 95%;"></td>
        <td><input value="<?php echo $Q24;?>" name="Q24" id="Q24" type="number"></td>
        <td><?php echo draw_checkbox("Q25", "", $Q25, "single"); ?></td>
    </tr>
    <tr>
        <td><input value="<?php echo $Q26;?>" name="Q26" id="Q26" type="number"></td>
        <td>Lady Hats</td>
        <td><?php echo draw_checkbox("Q27", "", $Q27, "single"); ?></td>
        <td colspan="3"><input value="<?php echo $Q28;?>" name="Q28" id="Q28" type="text" style="width: 95%;"></td>
        <td><input value="<?php echo $Q29;?>" name="Q29" id="Q29" type="number"></td>
        <td><?php echo draw_checkbox("Q30", "", $Q30, "single"); ?></td>
    </tr>
    <tr>
        <td><input value="<?php echo $Q31;?>" name="Q31" id="Q31" type="number"></td>
        <td>Blouses</td>
        <td><?php echo draw_checkbox("Q32", "", $Q32, "single"); ?></td>
        <td colspan="3"><input value="<?php echo $Q33;?>" name="Q33" id="Q33" type="text" style="width: 95%;"></td>
        <td><input value="<?php echo $Q34;?>" name="Q34" id="Q34" type="number"></td>
        <td><?php echo draw_checkbox("Q35", "", $Q35, "single"); ?></td>
    </tr>
    <tr>
        <td><input value="<?php echo $Q36;?>" name="Q36" id="Q36" type="number"></td>
        <td>Lady Sweeters</td>
        <td><?php echo draw_checkbox("Q37", "", $Q37, "single"); ?></td>
        <td colspan="3"><input value="<?php echo $Q38;?>" name="Q38" id="Q38" type="text" style="width: 95%;"></td>
        <td><input value="<?php echo $Q39;?>" name="Q39" id="Q39" type="number"></td>
        <td><?php echo draw_checkbox("Q40", "", $Q40, "single"); ?></td>
    </tr>
    <tr>
        <td><input value="<?php echo $Q41;?>" name="Q41" id="Q41" type="number"></td>
        <td>Gloves</td>
        <td><?php echo draw_checkbox("Q42", "", $Q42, "single"); ?></td>
        <td colspan="3"><input value="<?php echo $Q434;?>" name="Q43" id="Q43" type="text" style="width: 95%;"></td>
        <td><input value="<?php echo $Q44;?>" name="Q44" id="Q44" type="number"></td>
        <td><?php echo draw_checkbox("Q45", "", $Q45, "single"); ?></td>
    </tr>
    <tr>
        <td><input value="<?php echo $Q46;?>" name="Q46" id="Q46" type="number"></td>
        <td>Hose</td>
        <td><?php echo draw_checkbox("Q47", "", $Q47, "single"); ?></td>
        <td colspan="3"><input value="<?php echo $Q48;?>" name="Q48" id="Q48" type="text" style="width: 95%;"></td>
        <td><input value="<?php echo $Q49;?>" name="Q49" id="Q49" type="number"></td>
        <td><?php echo draw_checkbox("Q50", "", $Q50, "single"); ?></td>
    </tr>
    <tr>
        <td><input value="<?php echo $Q51;?>" name="Q51" id="Q51" type="number"></td>
        <td>Lady Handkerchiefs</td>
        <td><?php echo draw_checkbox("Q52", "", $Q52, "single"); ?></td>
        <td colspan="3"><input value="<?php echo $Q53;?>" name="Q53" id="Q53" type="text" style="width: 95%;"></td>
        <td><input value="<?php echo $Q54;?>" name="Q54" id="Q54" type="number"></td>
        <td><?php echo draw_checkbox("Q55", "", $Q55, "single"); ?></td>
    </tr>
    <tr>
        <td><input value="<?php echo $Q56;?>" name="Q56" id="Q56" type="number"></td>
        <td>Slips</td>
        <td><?php echo draw_checkbox("Q57", "", $Q57, "single"); ?></td>
        <td colspan="3"><input value="<?php echo $Q58;?>" name="Q58" id="Q58" type="text" style="width: 95%;"></td>
        <td><input value="<?php echo $Q59;?>" name="Q59" id="Q59" type="number"></td>
        <td><?php echo draw_checkbox("Q60", "", $Q60, "single"); ?></td>
    </tr>
    <tr>
        <td><input value="<?php echo $Q61;?>" name="Q61" id="Q61" type="number"></td>
        <td>Foundation Garments</td>
        <td><?php echo draw_checkbox("Q62", "", $Q62, "single"); ?></td>
        <td colspan="4" class="title">Aquired After Original Entry</td>
        <td rowspan="2" class="title">V</td>
    </tr>
    <tr>
        <td><input value="<?php echo $Q63;?>" name="Q63" id="Q63" type="number"></td>
        <td>NightGowns</td>
        <td><?php echo draw_checkbox("Q64", "", $Q64, "single"); ?></td>
        <td class="title_s">Date</td>
        <td class="title_s">Item</td>
        <td class="title_s" colspan="2">How received</td>
    </tr>
    <tr>
        <td><input value="<?php echo $Q65;?>" name="Q65" id="Q65" type="number"></td>
        <td>Brassieres</td>
        <td><?php echo draw_checkbox("Q66", "", $Q66, "single"); ?></td>
        <td><script> $(function() { $( "#Q67").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input value="<?php echo formatdate($Q67);?>" name="Q67" id="Q67" type="text" style="width: 90%;"></td>
        <td><input value="<?php echo $Q68;?>" name="Q68" id="Q68" type="text" style="width: 95%;"></td>
        <td colspan="2"><input value="<?php echo $Q68;?>" name="Q69" id="Q69" type="text"></td>
         <td><?php echo draw_checkbox("Q70", "", $Q70, "single"); ?></td>
    </tr>
    <tr>
        <td><input value="<?php echo $Q71;?>" name="Q71" id="Q71" type="number"></td>
        <td>Housecoats - Robes</td>
        <td><?php echo draw_checkbox("Q72", "", $Q72, "single"); ?></td>
        <td><script> $(function() { $( "#Q73").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input value="<?php echo formatdate($Q73);?>" name="Q73" id="Q73" type="text" style="width: 90%;"></td>
        <td><input value="<?php echo $Q74;?>" name="Q74" id="Q74" type="text" style="width: 95%;"></td>
        <td colspan="2"><input value="<?php echo $Q75;?>" name="Q75" id="Q75" type="text"></td>
        <td><?php echo draw_checkbox("Q76", "", $Q76, "single"); ?></td>
    </tr>
    <tr>
        <td><input value="<?php echo $Q77;?>" name="Q77" id="Q77" type="number"></td>
        <td>House Slippers</td>
        <td><?php echo draw_checkbox("Q78", "", $Q78, "single"); ?></td>
        <td><script> $(function() { $( "#Q79").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input value="<?php echo formatdate($Q79);?>" name="Q79" id="Q79" type="text" style="width: 90%;"></td>
        <td><input value="<?php echo $Q80;?>" name="Q80" id="Q80" type="text" style="width: 95%;"></td>
        <td colspan="2"><input value="<?php echo $Q81;?>" name="Q81" id="Q81" type="text"></td>
        <td><?php echo draw_checkbox("Q82", "", $Q82, "single"); ?></td>
    </tr>
    <tr>
        <td><input value="<?php echo $Q83;?>" name="Q83" id="Q83" type="number"></td>
        <td>Pocket Books</td>
        <td><?php echo draw_checkbox("Q84", "", $Q84, "single"); ?></td>
        <td><script> $(function() { $( "#Q85").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input value="<?php echo formatdate($Q85);?>" name="Q85" id="Q85" type="text" style="width: 90%;"></td>
        <td><input value="<?php echo $Q86;?>" name="Q86" id="Q86" type="text" style="width: 95%;"></td>
        <td colspan="2"><input value="<?php echo $Q87;?>" name="Q87" id="Q87" type="text"></td>
        <td><?php echo draw_checkbox("Q88", "", $Q88, "single"); ?></td>
    </tr>
    <tr>
        <td><input value="<?php echo $Q89;?>" name="Q89" id="Q89" type="number"></td>
        <td>Overnight Case</td>
        <td><?php echo draw_checkbox("Q90", "", $Q90, "single"); ?></td>
        <td><script> $(function() { $( "#Q91").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input value="<?php echo formatdate($Q91);?>" name="Q91" id="Q91" type="text" style="width: 90%;"></td>
        <td><input value="<?php echo $Q92;?>" name="Q92" id="Q92" type="text" style="width: 95%;"></td>
        <td colspan="2"><input value="<?php echo $Q93;?>" name="Q93" id="Q93" type="text"></td>
        <td><?php echo draw_checkbox("Q94", "", $Q94, "single"); ?></td>
    </tr>
    <tr>
        <td><input value="<?php echo $Q95;?>" name="Q95" id="Q95" type="number"></td>
        <td>Men Suits</td>
        <td><?php echo draw_checkbox("Q96", "", $Q96, "single"); ?></td>
        <td><script> $(function() { $( "#Q97").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input value="<?php echo formatdate($Q97);?>" name="Q97" id="Q97" type="text" style="width: 90%;"></td>
        <td><input value="<?php echo $Q98;?>" name="Q98" id="Q98" type="text" style="width: 95%;"></td>
        <td colspan="2"><input value="<?php echo $Q99;?>" name="Q99" id="Q99" type="text"></td>
        <td><?php echo draw_checkbox("Q100", "", $Q100, "single"); ?></td>
    </tr>
    <tr>
        <td><input value="<?php echo $Q101;?>" name="Q101" id="Q101" type="number"></td>
        <td>Topcoats</td>
        <td><?php echo draw_checkbox("Q103", "", $Q103, "single"); ?></td>
        <td><script> $(function() { $( "#Q104").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input value="<?php echo formatdate($Q104);?>" name="Q104" id="Q104" type="text" style="width: 90%;"></td>
        <td><input value="<?php echo $Q105;?>" name="Q105" id="Q105" type="text" style="width: 95%;"></td>
        <td colspan="2"><input value="<?php echo $Q106;?>" name="Q106" id="Q106" type="text"></td>
        <td><?php echo draw_checkbox("Q107", "", $Q107, "single"); ?></td>
    </tr>
    <tr>
        <td><input value="<?php echo $Q108;?>" name="Q108" id="Q108" type="number"></td>
        <td>Slacks</td>
        <td><?php echo draw_checkbox("Q110", "", $Q110, "single"); ?></td>
        <td><script> $(function() { $( "#Q111").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input value="<?php echo formatdate($Q111);?>" name="Q111" id="Q111" type="text" style="width: 90%;"></td>
        <td><input value="<?php echo $Q112;?>" name="Q112" id="Q112" type="text" style="width: 95%;"></td>
        <td colspan="2"><input value="<?php echo $Q113;?>" name="Q113" id="Q113" type="text"></td>
        <td><?php echo draw_checkbox("Q114", "", $Q114, "single"); ?></td>
    </tr>
    <tr>
        <td><input value="<?php echo $Q115;?>" name="Q115" id="Q115" type="number"></td>
        <td>Sport Jackets</td>
        <td><?php echo draw_checkbox("Q116", "", $Q116, "single"); ?></td>
        <td><script> $(function() { $( "#Q117").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input value="<?php echo formatdate($Q117);?>" name="Q117" id="Q117" type="text" style="width: 90%;"></td>
        <td><input value="<?php echo $Q118;?>" name="Q118" id="Q118" type="text" style="width: 95%;"></td>
        <td colspan="2"><input value="<?php echo $Q119;?>" name="Q119" id="Q119" type="text"></td>
        <td><?php echo draw_checkbox("Q120", "", $Q120, "single"); ?></td>
    </tr>
    <tr>
        <td><input value="<?php echo $Q121;?>" name="Q121" id="Q121" type="number"></td>
        <td>Men's Hats</td>
        <td><?php echo draw_checkbox("Q122", "", $Q122, "single"); ?></td>
        <td><script> $(function() { $( "#Q123").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input value="<?php echo formatdate($Q123);?>" name="Q123" id="Q123" type="text" style="width: 90%;"></td>
        <td><input value="<?php echo $Q124;?>" name="Q124" id="Q124" type="text" style="width: 95%;"></td>
        <td colspan="2"><input value="<?php echo $Q125;?>" name="Q125" id="Q125" type="text"></td>
        <td><?php echo draw_checkbox("Q126", "", $Q126, "single"); ?></td>
    </tr>
    <tr>
        <td><input value="<?php echo $Q127;?>" name="Q127" id="Q127" type="number"></td>
        <td>Men's Shoes</td>
        <td><?php echo draw_checkbox("Q128", "", $Q128, "single"); ?></td>
        <td><script> $(function() { $( "#Q129").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input value="<?php echo formatdate($Q129);?>" name="Q129" id="Q129" type="text" style="width: 90%;"></td>
        <td><input value="<?php echo $Q130;?>" name="Q130" id="Q130" type="text" style="width: 95%;"></td>
        <td colspan="2"><input value="<?php echo $Q131;?>" name="Q131" id="Q131" type="text"></td>
        <td><?php echo draw_checkbox("Q132", "", $Q132, "single"); ?></td>
    </tr>
    <tr>
        <td><input value="<?php echo $Q133;?>" name="Q133" id="Q133" type="number"></td>
        <td>Men's Gloves</td>
        <td><?php echo draw_checkbox("Q134", "", $Q134, "single"); ?></td>
        <td><script> $(function() { $( "#Q135").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input value="<?php echo formatdate($Q135);?>" name="Q135" id="Q135" type="text" style="width: 90%;"></td>
        <td><input value="<?php echo $Q136;?>" name="Q136" id="Q136" type="text" style="width: 95%;"></td>
        <td colspan="2"><input value="<?php echo $Q137;?>" name="Q137" id="Q137" type="text"></td>
        <td><?php echo draw_checkbox("Q138", "", $Q138, "single"); ?></td>
    </tr>
    <tr>
        <td><input value="<?php echo $Q139;?>" name="Q139" id="Q139" type="number"></td>
        <td>Socks</td>
        <td><?php echo draw_checkbox("Q140", "", $Q140, "single"); ?></td>
        <td><script> $(function() { $( "#Q141").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input value="<?php echo formatdate($Q141);?>" name="Q141" id="Q141" type="text" style="width: 90%;"></td>
        <td><input value="<?php echo $Q142;?>" name="Q142" id="Q142" type="text" style="width: 95%;"></td>
        <td colspan="2"><input value="<?php echo $Q143;?>" name="Q143" id="Q143" type="text"></td>
        <td><?php echo draw_checkbox("Q144", "", $Q144, "single"); ?></td>
    </tr>
    <tr>
        <td><input value="<?php echo $Q145;?>" name="Q145" id="Q145" type="number"></td>
        <td>Shorts</td>
        <td><?php echo draw_checkbox("Q146", "", $Q146, "single"); ?></td>
        <td><script> $(function() { $( "#Q147").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input value="<?php echo formatdate($Q147);?>" name="Q147" id="Q147" type="text" style="width: 90%;"></td>
        <td><input value="<?php echo $Q148;?>" name="Q148" id="Q148" type="text" style="width: 95%;"></td>
        <td colspan="2"><input value="<?php echo $Q149;?>" name="Q149" id="Q149" type="text"></td>
        <td><?php echo draw_checkbox("Q150", "", $Q150, "single"); ?></td>
    </tr>
    <tr>
        <td><input value="<?php echo $Q151;?>" name="Q151" id="Q151" type="number"></td>
        <td>Undershirts</td>
        <td><?php echo draw_checkbox("Q152", "", $Q152, "single"); ?></td>
        <td><script> $(function() { $( "#Q153").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input value="<?php echo formatdate($Q153);?>" name="Q153" id="Q153" type="text" style="width: 90%;"></td>
        <td><input value="<?php echo $Q154;?>" name="Q154" id="Q154" type="text" style="width: 95%;"></td>
        <td colspan="2"><input value="<?php echo $Q155;?>" name="Q155" id="Q155" type="text"></td>
        <td><?php echo draw_checkbox("Q156", "", $Q156, "single"); ?></td>
    </tr>
    <tr>
        <td><input value="<?php echo $Q157;?>" name="Q157" id="Q157" type="number"></td>
        <td>Ties</td>
        <td><?php echo draw_checkbox("Q158", "", $Q158, "single"); ?></td>
        <td><script> $(function() { $( "#Q159").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input value="<?php echo formatdate($Q159);?>" name="Q159" id="Q159" type="text" style="width: 90%;"></td>
        <td><input value="<?php echo $Q160;?>" name="Q160" id="Q160" type="text" style="width: 95%;"></td>
        <td colspan="2"><input value="<?php echo $Q161;?>" name="Q161" id="Q161" type="text"></td>
        <td><?php echo draw_checkbox("Q162", "", $Q162, "single"); ?></td>
    </tr>
    <tr>
        <td><input value="<?php echo $Q163;?>" name="Q163" id="Q163" type="number"></td>
        <td>Belts - Suspenders</td>
        <td><?php echo draw_checkbox("Q164", "", $Q164, "single"); ?></td>
        <td colspan="5" class="title">Notes On Articles<br>(Listing of Items Damaged, Lost, etc.)</td>
    </tr>
    <tr>
        <td><input value="<?php echo $Q165;?>" name="Q165" id="Q165" type="number"></td>
        <td>Men's Handkerchiefs</td>
        <td><?php echo draw_checkbox("Q166", "", $Q166, "single"); ?></td>
        <td colspan="5"><input value="<?php echo $Q167;?>" name="Q167" id="Q167" type="text" style="width: 97%;"></td>
    </tr>
    <tr>
        <td><input value="<?php echo $Q168;?>" name="Q168" id="Q168" type="number"></td>
        <td>Pajamas</td>
        <td><?php echo draw_checkbox("Q169", "", $Q169, "single"); ?></td>
        <td colspan="5"><input value="<?php echo $Q170;?>" name="Q170" id="Q170" type="text" style="width: 97%;"></td>
    </tr>
    <tr>
        <td><input value="<?php echo $Q171;?>" name="Q171" id="Q171" type="number"></td>
        <td>Robes</td>
        <td><?php echo draw_checkbox("Q172", "", $Q172, "single"); ?></td>
        <td colspan="5"><input value="<?php echo $Q173;?>" name="Q173" id="Q173" type="text" style="width: 97%;"></td>
    </tr>
    <tr>
        <td><input value="<?php echo $Q174;?>" name="Q174" id="Q174" type="number"></td>
        <td>Slippers</td>
        <td><?php echo draw_checkbox("Q175", "", $Q175, "single"); ?></td>
        <td colspan="5"><input value="<?php echo $Q176;?>" name="Q176" id="Q176" type="text" style="width: 97%;"></td>
    </tr>
    <tr>
        <td><input value="<?php echo $Q177;?>" name="Q177" id="Q177" type="number"></td>
        <td>Shaving Kit</td>
        <td><?php echo draw_checkbox("Q178", "", $Q178, "single"); ?></td>
        <td colspan="5"><input value="<?php echo $Q179;?>" name="Q179" id="Q179" type="text" style="width: 97%;"></td>
    </tr>
    <tr>
        <td><input value="<?php echo $Q180;?>" name="Q180" id="Q180" type="number"></td>
        <td>Traceling Bags</td>
        <td><?php echo draw_checkbox("Q181", "", $Q181, "single"); ?></td>
        <td colspan="5"><input value="<?php echo $Q182;?>" name="Q182" id="Q182" type="text" style="width: 97%;"></td>
    </tr>
    <tr>
        <td><input value="<?php echo $Q183;?>" name="Q183" id="Q183" type="number"></td>
        <td>Underpants</td>
        <td><?php echo draw_checkbox("Q184", "", $Q184, "single"); ?></td>
        <td colspan="5"><input value="<?php echo $Q185;?>" name="Q185" id="Q185" type="text" style="width: 97%;"></td>
    </tr>
    <tr>
        <td><input value="<?php echo $Q186;?>" name="Q186" id="Q186" type="number"></td>
        <td>Skirts</td>
        <td><?php echo draw_checkbox("Q187", "", $Q187, "single"); ?></td>
        <td colspan="5"><input value="<?php echo $Q188;?>" name="Q188" id="Q188" type="text" style="width: 97%;"></td>
    </tr>
    <tr>
        <td><input value="<?php echo $Q189;?>" name="Q189" id="Q189" type="number"></td>
        <td>Others:<input value="<?php echo $Q190;?>" name="Q190" id="Q190" type="text"></td>
        <td><?php echo draw_checkbox("Q191", "", $Q191, "single"); ?></td>
        <td colspan="5"><input value="<?php echo $Q192;?>" name="Q192" id="Q192" type="text" style="width: 97%;"></td>
    </tr>
    <tr>
        <td colspan="8" class="title">Remarks</td>
    </tr>
    <tr>
        <td colspan="8" rowspan="3"><input value="<?php echo $Q193;?>" name="Q193" id="Q193" type="text" style="width:97%; height:97%;"></td>
    </tr>
    <tr></tr>
    <tr></tr>
 </table>
 <table align="center">
    <tr>
        <td colspan="8" class="title">Certification of Receipt</td>
    </tr>
    <tr>
        <td colspan="4" class="title_s" width="50%">On Admission</td>
        <td colspan="4" class="title_s" width="60%">On Discharge</td>
    </tr>
    <tr>
        <td rowspan="2" width="7%" class="title">Signed:</td>
        <td colspan="3" style="text-align:left;">(PATIENT OR RESPONSIBLE PARTY)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DATE<br><input value="<?php echo $Q194;?>" name="Q194" id="Q194" type="text">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<script> $(function() { $( "#Q195").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input value="<?php echo formatdate($Q195);?>" name="Q195" id="Q195" type="text"></td>
        <td rowspan="2" width="7%" class="title">Signed:</td>
        <td colspan="4" style="text-align:left;">(PATIENT OR RESPONSIBLE PARTY)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DATE<br><input value="<?php echo $Q196;?>" name="Q196" id="Q196" type="text">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<script> $(function() { $( "#Q197").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input value="<?php echo formatdate($Q197);?>" name="Q197" id="Q197" type="text"></td>
    </tr>
    <tr>
        <td colspan="3">TITLE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DATE<br><input value="<?php echo $Q198;?>" name="Q198" id="Q198" type="text">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<script> $(function() { $( "#Q199").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input value="<?php echo formatdate($Q199);?>" name="Q199" id="Q199" type="text"></td>
        <td colspan="4">TITLE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DATE<br><input value="<?php echo $Q200;?>" name="Q200" id="Q200" type="text">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<script> $(function() { $( "#Q201").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input value="<?php echo formatdate($Q201);?>" name="Q201" id="Q201" type="text"></td>
    </tr>
</table>
<!-- Real Date and Form Filler -->
<table width="100%" align="center">
  <tr>
    <td><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Filled date："; }else{ echo $word_40; } ?><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if($_GET['newDate']!="") { echo formatdate($_GET['newDate']); } else { if ($date != NULL) { echo formatdate($date); } } ?>" size="12"> <input type="button" value="<?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Today"; }else{ echo $word_today; } ?>" onclick="inputdate('date');" /></td>
    <td align="right"><?php if($_SESSION['LanguangNumber_lwj']==1){ echo "Filled by："; }else{ echo $word_41; } ?><?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>
<!-- submit button + VN -->
        <center><input type="hidden" name="formID" id="formID" value="nurseform55_1" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" />
        <button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
        </center>
        <br><br><br><br><br><br>
</form>
</div>
<!-- clean the varaiable -->
<?php
if ($r1) {
foreach ($r1 as $k=>$v) {
    if (substr($k,0,1)=="Q") {
        $arrAnswer = explode("_",$k);
        if (count($arrAnswer)==2) {
            if ($v==1) {
                ${$arrAnswer[0]} = "";
            }
        } else {
            ${$k} = "";
        }
    }  else {
        ${$k} = "";
    }
}
}
?>