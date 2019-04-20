<?php
// '@'  ->> Do not show the error.
session_start();
if (@$_GET['date']=='') {
    $sql = "SELECT * FROM `nurseform60` WHERE `HospNo`='".mysql_escape_string($r['HospNo'])."' ORDER BY `date` DESC LIMIT 0,1";
} else {
    $sql = "SELECT * FROM `nurseform60` WHERE `HospNo`='".mysql_escape_string($r['HospNo'])."' AND `date`='".mysql_escape_string(@$_GET['date'])."'";
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
<form action="index.php?func=database&action=save" method="post" accept-charset="utf-8">
<h3>Notorn Plus Score CHART for Predicting Pressure Sore Risk</h3>
<div class="nurseform-table">
<!-- loading canvas initialization -->
<!-- <link href="/canvas.css" type="text/css" rel="Stylesheet"> -->
<link rel="stylesheet" type="text/css" href="/uCareUSnew/nhome/css/canvas.css">
<script src="js/THL_canvas.js"></script>
<script src="js/THL_canvas2.js"></script>
<table align="center">
    <tr>
        <td rowspan="2" colspan="2" class="title">Dates</td>
        <td class="title_s">(1)</td>
        <td class="title_s">(2)</td>
        <td class="title_s">(3)</td>
        <td class="title_s">(4)</td>
    </tr>
    <tr>
        <td><script> $(function() { $( "#QD1").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" id="QD1" name="QD1" value="<?php echo $QD1; ?>"></td>
        <td><script> $(function() { $( "#QD2").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" id="QD2" name="QD2" value="<?php echo $QD2; ?>"></td>
        <td><script> $(function() { $( "#QD3").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" id="QD3" name="QD3" value="<?php echo $QD3; ?>"></td>
        <td><script> $(function() { $( "#QD4").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" id="QD4" name="QD4" value="<?php echo $QD4; ?>"></td>
    </tr>
    <tr>
        <td class="title" rowspan="4">General Physical Condition:</td>
        <td>Good(4)</td>
        <td rowspan="4"><input type="number" id="Q1" name="Q1" value="<?php echo $Q1; ?>"></td>
        <td rowspan="4"><input type="number" id="Q2" name="Q2" value="<?php echo $Q2; ?>"></td>
        <td rowspan="4"><input type="number" id="Q3" name="Q3" value="<?php echo $Q3; ?>"></td>
        <td rowspan="4"><input type="number" id="Q4" name="Q4" value="<?php echo $Q4; ?>"></td>
    </tr>
    <tr>
        <td>Fair(3)</td>
    </tr>
    <tr>
        <td>Poor(2)</td>
    </tr>
    <tr>
        <td>Bad(1)</td>
    </tr>
    <tr>
        <td class="title" rowspan="4">Mental State:</td>
        <td>Alert(4)</td>
        <td rowspan="4"><input type='number' id='Q5' name='Q5' value='<?php echo $Q5; ?>'></td>
        <td rowspan="4"><input type='number' id='Q6' name='Q6' value='<?php echo $Q6; ?>'></td>
        <td rowspan="4"><input type='number' id='Q7' name='Q7' value='<?php echo $Q7; ?>'></td>
        <td rowspan="4"><input type='number' id='Q8' name='Q8' value='<?php echo $Q8; ?>'></td>
    </tr>
    <tr>
        <td>Apathetic(3)</td>
    </tr>
    <tr>
        <td>Confused(2)</td>
    </tr>
    <tr>
        <td>Stuporous(1)</td>
    </tr>
    <tr>
        <td class="title" rowspan="4">Activity:</td>
        <td>Ambulant(4)</td>
        <td rowspan="4"><input type='number' id='Q9' name='Q9' value='<?php echo $Q9; ?>'></td>
        <td rowspan="4"><input type='number' id='Q10' name='Q10' value='<?php echo $Q10; ?>'></td>
        <td rowspan="4"><input type='number' id='Q11' name='Q11' value='<?php echo $Q11; ?>'></td>
        <td rowspan="4"><input type='number' id='Q12' name='Q12' value='<?php echo $Q12; ?>'></td>
    </tr>
    <tr>
        <td>Walks with help(3)</td>
    </tr>
    <tr>
        <td>Chair-bound(2)</td>
    </tr>
    <tr>
        <td>Bedrest(1)</td>
    </tr>
    <tr>
        <td class="title" rowspan="4"
class="title" rowspan="4">Mobility</td>
        <td>Full(4)</td>
        <td rowspan="4"><input type='number' id='Q13' name='Q13' value='<?php echo $Q13; ?>'></td>
        <td rowspan="4"><input type='number' id='Q14' name='Q14' value='<?php echo $Q14; ?>'></td>
        <td rowspan="4"><input type='number' id='Q15' name='Q15' value='<?php echo $Q15; ?>'></td>
        <td rowspan="4"><input type='number' id='Q16' name='Q16' value='<?php echo $Q16; ?>'></td>
    </tr>
    <tr>
        <td>Slightly limited(3)</td>
    </tr>
    <tr>
        <td>Very limited(2)</td>
    </tr>
    <tr>
        <td>Immobile(1)</td>
    </tr>
    <tr>
        <td class="title" rowspan="4">Incontinence:</td>
        <td>Not incontinent(4)</td>
        <td rowspan="4"><input type='number' id='Q17' name='Q17' value='<?php echo $Q17; ?>'></td>
        <td rowspan="4"><input type='number' id='Q18' name='Q18' value='<?php echo $Q18; ?>'></td>
        <td rowspan="4"><input type='number' id='Q19' name='Q19' value='<?php echo $Q19; ?>'></td>
        <td rowspan="4"><input type='number' id='Q20' name='Q20' value='<?php echo $Q20; ?>'></td>
    </tr>
    <tr>
        <td>Occasionally incontinent(3)</td>
    </tr>
    <tr>
        <td>Usually incontinent of urine(2)</td>
    </tr>
    <tr>
        <td>Dounle incontinence(1)</td>
    </tr>
    <tr>
        <td class="title" colspan="2">Norton Socre</td>
        <td><?php echo $Q1+$Q5+$Q9+$Q13+$Q17; ?></td>
        <td><?php echo $Q2+$Q6+$Q10+$Q14+$Q18; ?></td>
        <td><?php echo $Q3+$Q7+$Q11+$Q15+$Q19; ?></td>
        <td><?php echo $Q4+$Q8+$Q12+$Q16+$Q20; ?></td>
    </tr>
    <tr>
        <td colspan="2" class="title_s">Norton Plus Deduction (Check only if YES)</td>
        <td>Yes</td>
        <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2" class="title_s">Diagnosis of diabetes</td>
        <td><?php echo draw_checkbox("QA1", "", $QA1, "single"); ?></td>
        <td><?php echo draw_checkbox("QA2", "", $QA2, "single"); ?></td>
        <td><?php echo draw_checkbox("QA3", "", $QA3, "single"); ?></td>
        <td><?php echo draw_checkbox("QA4", "", $QA4, "single"); ?></td>

    </tr>
    <tr>
        <td colspan="2" class="title_s">Diagnosis of hypertension</td>
        <td><?php echo draw_checkbox('QA5', '', $QA5, 'single'); ?></td>
        <td><?php echo draw_checkbox('QA6', '', $QA6, 'single'); ?></td>
        <td><?php echo draw_checkbox('QA7', '', $QA7, 'single'); ?></td>
        <td><?php echo draw_checkbox('QA8', '', $QA8, 'single'); ?></td>
    </tr>
    <tr>
        <td colspan="2" rowspan="2" class="title_s">Hematocrit <br>(M) < 41%<br>(F) < 36%</td>
        <td><?php echo draw_checkbox('QA9', '', $QA9, 'single'); ?></td>
        <td><?php echo draw_checkbox('QA10', '', $QA10, 'single'); ?></td>
        <td><?php echo draw_checkbox('QA11', '', $QA11, 'single'); ?></td>
        <td><?php echo draw_checkbox('QA12', '', $QA12, 'single'); ?></td>
    </tr>
    <tr>
        <td><?php echo draw_checkbox('QA13', '', $QA13, 'single'); ?></td>
        <td><?php echo draw_checkbox('QA14', '', $QA14, 'single'); ?></td>
        <td><?php echo draw_checkbox('QA15', '', $QA15, 'single'); ?></td>
        <td><?php echo draw_checkbox('QA16', '', $QA16, 'single'); ?></td>
    </tr>
    <tr>
        <td colspan="2" rowspan="2" class="title_s">Hemoglobin <br>(M) < 14g/dl<br>(F) < 12g/dl</td>
        <td><?php echo draw_checkbox('QA17', '', $QA17, 'single'); ?></td>
        <td><?php echo draw_checkbox('QA18', '', $QA18, 'single'); ?></td>
        <td><?php echo draw_checkbox('QA19', '', $QA19, 'single'); ?></td>
        <td><?php echo draw_checkbox('QA20', '', $QA20, 'single'); ?></td>
    </tr>
    <tr>
        <td><?php echo draw_checkbox('QA21', '', $QA21, 'single'); ?></td>
        <td><?php echo draw_checkbox('QA22', '', $QA22, 'single'); ?></td>
        <td><?php echo draw_checkbox('QA23', '', $QA23, 'single'); ?></td>
        <td><?php echo draw_checkbox('QA24', '', $QA24, 'single'); ?></td>
    </tr>
    <tr>
        <td colspan="2" class="title_s">Albumin level < 3.3g/dl</td>
        <td><?php echo draw_checkbox('QA25', '', $QA25, 'single'); ?></td>
        <td><?php echo draw_checkbox('QA26', '', $QA26, 'single'); ?></td>
        <td><?php echo draw_checkbox('QA27', '', $QA27, 'single'); ?></td>
        <td><?php echo draw_checkbox('QA28', '', $QA28, 'single'); ?></td>
    </tr>
    <tr>
        <td colspan="2" class="title_s">Febrile > 99.6 degree F</td>
        <td><?php echo draw_checkbox('QA29', '', $QA29, 'single'); ?></td>
        <td><?php echo draw_checkbox('QA30', '', $QA30, 'single'); ?></td>
        <td><?php echo draw_checkbox('QA31', '', $QA31, 'single'); ?></td>
        <td><?php echo draw_checkbox('QA32', '', $QA32, 'single'); ?></td>
    </tr>
    <tr>
        <td colspan="2" class="title_s">5 or more medications</td>
        <td><?php echo draw_checkbox('QA33', '', $QA33, 'single'); ?></td>
        <td><?php echo draw_checkbox('QA34', '', $QA34, 'single'); ?></td>
        <td><?php echo draw_checkbox('QA35', '', $QA35, 'single'); ?></td>
        <td><?php echo draw_checkbox('QA36', '', $QA36, 'single'); ?></td>
    </tr>
    <tr>
        <td colspan="2" class="title_s">Changes in mental status t confused, lethargic within 24 hours</td>
        <td><?php echo draw_checkbox('QA37', '', $QA37, 'single'); ?></td>
        <td><?php echo draw_checkbox('QA38', '', $QA38, 'single'); ?></td>
        <td><?php echo draw_checkbox('QA39', '', $QA39, 'single'); ?></td>
        <td><?php echo draw_checkbox('QA40', '', $QA40, 'single'); ?></td>
    </tr>
    <tr>
        <td colspan="2" class="title_s">TOTAL NUMBER OF CHECKMARKS</td>
        <td><?php echo $QA1+$QA5+$QA9+$QA13+$QA17+$QA21+$QA25+$QA29+$QA33+$QA37; ?></td>
        <td><?php echo $QA2+$QA6+$QA10+$QA14+$QA18+$QA22+$QA26+$QA30+$QA34+$QA38; ?></td>
        <td><?php echo $QA3+$QA7+$QA11+$QA15+$QA19+$QA23+$QA27+$QA31+$QA35+$QA39; ?></td>
        <td><?php echo $QA4+$QA8+$QA12+$QA16+$QA20+$QA24+$QA28+$QA32+$QA36+$QA40; ?></td>
    </tr>
    <tr>
        <td colspan="2" class="title_s">NORTON SCALE SCORE</td>
        <td><?php echo $Q1+$Q5+$Q9+$Q13+$Q17; ?></td>
        <td><?php echo $Q2+$Q6+$Q10+$Q14+$Q18; ?></td>
        <td><?php echo $Q3+$Q7+$Q11+$Q15+$Q19; ?></td>
        <td><?php echo $Q4+$Q8+$Q12+$Q16+$Q20; ?></td>
    </tr>
    <tr>
        <td colspan="2" class="title_s">MINUS TOTAL CHECKMARKS FROM ABOVE</td>
        <td><?php echo ($Q1+$Q5+$Q9+$Q13+$Q17)-($QA1+$QA5+$QA9+$QA13+$QA17+$QA21+$QA25+$QA29+$QA33+$QA37); ?></td>
        <td><?php echo ($Q2+$Q6+$Q10+$Q14+$Q18)-($QA2+$QA6+$QA10+$QA14+$QA18+$QA22+$QA26+$QA30+$QA34+$QA38); ?></td>
        <td><?php echo ($Q3+$Q7+$Q11+$Q15+$Q19)-($QA3+$QA7+$QA11+$QA15+$QA19+$QA23+$QA27+$QA31+$QA35+$QA39); ?></td>
        <td><?php echo ($Q4+$Q8+$Q12+$Q16+$Q20)-($QA4+$QA8+$QA12+$QA16+$QA20+$QA24+$QA28+$QA32+$QA36+$QA40); ?></td>
    </tr>
    <tr>
        <td colspan="2" class="title_s">TOTAL NORTON PLUS SCORE</td>
        <td><?php echo ($Q1+$Q5+$Q9+$Q13+$Q17)-($QA1+$QA5+$QA9+$QA13+$QA17+$QA21+$QA25+$QA29+$QA33+$QA37); ?></td>
        <td><?php echo ($Q2+$Q6+$Q10+$Q14+$Q18)-($QA2+$QA6+$QA10+$QA14+$QA18+$QA22+$QA26+$QA30+$QA34+$QA38); ?></td>
        <td><?php echo ($Q3+$Q7+$Q11+$Q15+$Q19)-($QA3+$QA7+$QA11+$QA15+$QA19+$QA23+$QA27+$QA31+$QA35+$QA39); ?></td>
        <td><?php echo ($Q4+$Q8+$Q12+$Q16+$Q20)-($QA4+$QA8+$QA12+$QA16+$QA20+$QA24+$QA28+$QA32+$QA36+$QA40); ?></td>
    </tr>
    <tr>
        <td colspan="6">(From Norton, D., McLaren, R. & Exton-Smith, AN: An Investigation of <br>Geriatric Nursing Problems in Hospital. Edinburg, Churchill-Livingstone, 1975,225.)</td>
    </tr>
    <tr>
        <td colspan="6"><div style="display: inline-block;width: 100px;"><span>SCORE:</span><br><br><br></div><div style="display: inline-block;">16 - 20 No or Low Risk<br>13 - 15 Moderate Risk<br>05 - 12 High Risk<br></div></td>
    </tr>
</table>                
<table align="center">
    <tr>
        <td class="title_s">Signature:</td>
        <td>(1)<input type="text" id="Q81" name="Q81" value="<?php echo $Q81; ?>"></td>
        <td>(2)<input type="text" id="Q82" name="Q82" value="<?php echo $Q82; ?>"></td>
        <td>(3)<input type="text" id="Q83" name="Q83" value="<?php echo $Q83; ?>"></td>
        <td>(4)<input type="text" id="Q84" name="Q84" value="<?php echo $Q84; ?>"></td>
    </tr>
    <tr>
        <td class="title_s">Date:</td>
        <td><script> $(function() { $( "#Q85").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script>(1)<input type="text" id="Q85" name="Q85" value="<?php echo formatdate($Q85); ?>"></td>
        <td><script> $(function() { $( "#Q86").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script>(2)<input type="text" id="Q86" name="Q86" value="<?php echo formatdate($Q86); ?>"></td>
        <td><script> $(function() { $( "#Q87").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script>(3)<input type="text" id="Q87" name="Q87" value="<?php echo formatdate($Q87); ?>"></td>
        <td><script> $(function() { $( "#Q88").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script>(4)<input type="text" id="Q88" name="Q88" value="<?php echo formatdate($Q88); ?>"></td>
    </tr>
</table>
    <br><br><br><br>
</div>
<h3>Periodic Skin Check</h3>
<div class="nurseform-table">
<table align="center">
    <tr>
    <td colspan="3" align="left">Draw and label the following on the figures: incisions, lumps, sores, bruises, decubiti, broken skin, redness areas, hernias, ascites, ostomies and amputations. <u>A written description is to be included in the Progess Notes.</u><br><br>
    Decubitus ulcers should reflect stage, size, depth, location, color, odor and description of surrounding tissue in note.<br>Please follow the following criteria for staging.</td>
    </tr>
    <tr>
        <td class="title" colspan="3">STAGING OF PRESSURE AREAS</td>
    </tr>
    <tr>
        <td class="title_s" colspan="2">STAGE I ULCER</td>
        <td rowspan="2" style="background-color: white;"><img src="/uCareUSnew/nhome/module/nurseform/img/STAGING OF PRESSURE AREAS- Stage 1.png"></td>
    </tr>
    <tr>
        <td align="left" colspan="2">Area is pink, red or mottled - does not disappear after 15 minutes, when pressure is release. Skin feels warm and firm and blanches on touch.</td>
    </tr>
    <tr>
        <td class="title_s" colspan="2">STAGE II ULCER</td>
        <td rowspan="2" style="background-color: white;"><img src="/uCareUSnew/nhome/module/nurseform/img/STAGING OF PRESSURE AREAS- Stage 2.png"></td>
    </tr>
    <tr>
        <td align="left" colspan="2">Skin is cracked, blistered or broken, surrounding area is reddened. Skin will appear bluish or dusky colored with shallow to full thickness skin injury.</td>
    </tr>
    <tr>
        <td class="title_s" colspan="2">STAGE III ULCER</td>
        <td rowspan="2" style="background-color: white;"><img src="/uCareUSnew/nhome/module/nurseform/img/STAGING OF PRESSURE AREAS- Stage 3.png"></td>
    </tr>
    <tr>
        <td align="left" colspan="2">Skin break with deep tissue involve meat and exposure of subcutaneous tissue. The ulcer may or may not be infected.</td>
    </tr>
    <tr>
        <td class="title_s" colspan="2">STAGE IV ULCER</td>
        <td rowspan="2" style="background-color: white;"><img src="/uCareUSnew/nhome/module/nurseform/img/STAGING OF PRESSURE AREAS- Stage 4.png"></td>
    </tr>
    <tr>
        <td align="left" colspan="2">Extensive ulceration with penetration t the muscle or bone, usually necrotic tissue present, infected with drainage.</td>
    </tr>


    <!-- Decide new record or old (show the canvas or not)-->
    <?php 
        if($tabsID == 0){
            echo '<tr>'; 
        } else {
            echo '<tr style="display: none">';
        }
    ?>
    <!-- Canvas Start-->
        <td colspan="3">
        <div id="drawController">   
            <img src="http://chengxinwei.github.io/images/draw/pencil.png" width="20px;" height="20px;" class="img border_nochoose" onclick="draw_graph('pencil',this)" title="鉛筆"><br>
            <img src="http://chengxinwei.github.io/images/draw/cancel.png" width="20px;" height="20px;" class="img border_nochoose" onclick="cancel(this)" title="撤銷上一個操作"><br>
            <img src="http://chengxinwei.github.io/images/draw/next.png" width="20px;" height="20px;" class="img border_nochoose" onclick="next(this)" title="重做上一個操作"><br>
            <img src="http://chengxinwei.github.io/images/draw/square.png" width="20px;" height="20px;" class="img border_nochoose" onclick="draw_graph('square',this)" title="方形"><br>
            <img src="http://chengxinwei.github.io/images/draw/circle.png" width="20px;" height="20px;" class="img border_choose" onclick="draw_graph('circle',this)" title="圓"><br>
            <img src="http://chengxinwei.github.io/images/draw/xx.png" width="20px;" height="20px;" class="img border_nochoose" onclick="clearContext('2')" title="清屏"><br>
            <!-- <img src="http://chengxinwei.github.io/images/draw/save.png" width="20px;" height="20px;" class="img border_nochoose" onclick="canvasSave()" title="保存"> -->
            <br>
        </div>
         
        <div id="img1"></div>
        <canvas id="canvas" width="800px" height="600px"></canvas>
        <canvas id="canvas_bak" width="800px" height="600px"></canvas>
        </td>
    </tr>
    <!-- Canvas End -->
    <!-- If it is old record, show the picture -->
    <?php 
        // $Qcanvas = "/nhome/Images/".$r['patientID'].$date.".png";
        $Qcanvas = '/uCareUSnew/nhome/uploadfile'.'/'.$_SESSION['nOrgID_lwj'].'/'.$HospNo.'/nurseform60_pic';
        $file_nameY = substr($date, 0, 4);
        $file_nameM = substr($date, 4, 2);
        $file_nameD = substr($date, 6, 2);
        if($tabsID != 0){
            echo '<tr><td colspan="3"><img src="';
            echo $Qcanvas.'/'.$file_nameY.'/'.$file_nameM.'/'.$file_nameD.'/Periodic Skin Check.png"/></td></tr>';
        }
     ?>
    <input type="hidden" id="Qcanvas" name="Qcanvas" value="<?php echo $Qcanvas; ?>">
     <!-- canvas saving process -->
     <script>
     //ajax, 在JS將data url 傳到另一個php檔做處理
         function canvasSave() {
             var saveurl = canvas.toDataURL();
             var Datetime = $('#date').val();
             var theHospNo = $('#HospNo').val();
             $.ajax({
                 type: 'POST',
                 url: 'class/canvasSave.php',
                 async: false,
                 data: {"img":saveurl, "Date":Datetime, "HospNo": theHospNo}
             })
         }
     </script>

    <tr>
        <td class="title">Patient Name</td>
        <td class="title">Nurse</td>
        <td class="title">Date</td>
    </tr>
    <tr>
        <td><input type="text" id="Q89" name="Q89" value="<?php echo $Q89; ?>"></td>
        <td><input type="text" id="Q90" name="Q90" value="<?php echo $Q90; ?>"></td>
        <td><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" id="date" name="date" value="<?php echo formatdate($date); ?>"></td>
    </tr>
</table>
</div>  
<!-- submit button + VN -->
        <center><input type="hidden" name="formID" id="formID" value="nurseform60" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" />
        <button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="canvasSave();window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
        </center>
        <br><br><br><br><br><br>
</form>

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