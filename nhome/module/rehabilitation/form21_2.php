<?php
$pid = (int) @$_GET['pid'];
if (@$_GET['date']=='') {
	$sql = "SELECT * FROM `socialform21_2` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql = "SELECT * FROM `socialform21_2` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`='".mysql_escape_string($_GET['date'])."'";
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
<!--<p align="right" style="border:1px; position:absolute; left:1012px; top:80px; background-color:rgba(255,255,255,0.8); border-radius:5px;"><a href="printsocialform21_2.php?pid=<?php echo $pid; ?>&date=<?php echo @$_GET['date']; ?>" target="_blank"><img src="Images/print.png" /></a></p>-->
<form  method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
  <h3>Rehabilitation Department Physical Therapy Report (2)</h3>
  <table>
    <tr>
      <td width="80" class="title">Full name</td>
      <td><input type="hidden" name="Q1" id="Q1" value="<?php echo $name; ?>" /><?php echo $name; ?></td>
      <td width="80" class="title">Medical record number</td>
      <td><input type="text" name="Q2" id="Q2" value="<?php echo $Q2; ?>" /><?php echo $Q2; ?></td>
      <td width="80" class="title">ID #</td>
      <td><input type="text" name="Q5" id="Q5" value="<?php echo $Q5; ?>" size="3" /></td>
    </tr>
    <tr>
      <td class="title">Date</td>
      <td><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if ($date != NULL) { echo formatdate($date); } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" /></td>
      <td class="title">Notify date</td>
      <td><script> $(function() { $( "#Q4").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="Q4" id="Q4" value="<?php if ($Q4 != NULL) { echo $Q4; } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('Q4');" /></td>
      <td class="title">Inpatient</td>
      <td><?php echo draw_option("Q6","Yes;No","s","single",$Q6,false,3); ?></td>
    </tr>
    <tr>
      <td class="title" colspan="8">Progressive Note</td>
    </tr>
    <tr>
      <td class="title_s">Subjective</td>
      <td colspan="7"><textarea name="Q7" id="Q7" cols="100" rows="4"><?php echo str_replace("\'","'",$Q7); ?></textarea><br />Quick fill with other inpatients' content:<br />
        <select onchange="document.getElementById('Q7').value=this.value" style="width:600px">
          <option></option>
          <?php
          $db3a = new DB;
          $db3a->query("SELECT DISTINCT `Q7` FROM `socialform21_2` ORDER BY `HospNo` ASC");
          for ($i=0;$i<$db3a->num_rows();$i++) {
            $r3a = $db3a->fetch_assoc();
            echo '<option value="'.$r3a['Q7'].'">'.$r3a['Q7'].'</option>';
          }
          ?>
        </select>
      </td>
    </tr>
    <tr>
      <td class="title" colspan="8">Objective</td>
    </tr>
    <tr>
      <td colspan="8">
        <table style="width:100%; font-size:9pt;">
          <tr class="title_s">
            <td colspan="3">Sensorimotor Status<br />(U/E: upper extremity; L/E: lower extremity)</td>
            <td>Functional<br />status</td>
            <td>Level</td>
            <td>N/A</td>
          </tr>
          <tr>
            <td rowspan="2" class="title_s">Sensation</td>
            <td class="title_s">UE</td>
            <td bgcolor="#fff">
              <select name="Q11s" id="Q11s">
                <option></option>
                <option value="Lt" <?php if ($Q11s=="Lt") { echo 'selected'; } ?>>L't</option>
                <option value="Rt" <?php if ($Q11s=="Rt") { echo 'selected'; } ?>>R't</option>
                <option value="RL" <?php if ($Q11s=="RL") { echo 'selected'; } ?>>R/L</option>
                <option value="NA" <?php if ($Q11s=="NA") { echo 'selected'; } ?>>N/A</option>
              </select> side: pin prick <?php echo draw_option("Q11a","(+);(-)","s","single",$Q11a,false,3); ?><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;light touch <?php echo draw_option("Q11b","(+);(-)","s","single",$Q11b,false,3); ?></td>
              <td class="title_s">rolling</td>
              <td bgcolor="#fff"><?php echo draw_option("Q11c","1;2;3;4;5;6;7","s","single",$Q11c,true,4); ?></td>
              <td bgcolor="#fff"><?php echo draw_option("Q11d","N;A;N/A","s","single",$Q11d,false,4); ?></td>
            </tr>
            <tr>
              <td class="title_s">LE</td>
              <td bgcolor="#fff">
                <select name="Q12s" id="Q12s">
                  <option></option>
                  <option value="Lt" <?php if ($Q12s=="Lt") { echo 'selected'; } ?>>L't</option>
                  <option value="Rt" <?php if ($Q12s=="Rt") { echo 'selected'; } ?>>R't</option>
                  <option value="RL" <?php if ($Q12s=="RL") { echo 'selected'; } ?>>R/L</option>
                  <option value="NA" <?php if ($Q12s=="NA") { echo 'selected'; } ?>>N/A</option>
                </select>
                side: pin prick <?php echo draw_option("Q12a","(+);(-)","s","single",$Q12a,false,3); ?><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;light touch <?php echo draw_option("Q12b","(+);(-)","s","single",$Q12b,false,3); ?></td>
                <td class="title_s">supine&lt;-&gt;sit</td>
                <td bgcolor="#fff"><?php echo draw_option("Q12c","1;2;3;4;5;6;7","s","single",$Q12c,true,4); ?></td>
                <td bgcolor="#fff"><?php echo draw_option("Q12d","N;A;N/A","s","single",$Q12d,false,4); ?></td>
              </tr>
              <tr>
                <td rowspan="2" class="title_s">Muscle<br />tone</td>
                <td class="title_s">UE</td>
                <td bgcolor="#fff">
                  <select name="Q13s" id="Q13s">
                    <option></option>
                    <option value="Lt" <?php if ($Q13s=="Lt") { echo 'selected'; } ?>>L't</option>
                    <option value="Rt" <?php if ($Q13s=="Rt") { echo 'selected'; } ?>>R't</option>
                    <option value="RL" <?php if ($Q13s=="RL") { echo 'selected'; } ?>>R/L</option>
                    <option value="NA" <?php if ($Q13s=="NA") { echo 'selected'; } ?>>N/A</option>
                  </select>
                  side: <?php echo draw_option("Q13a","(+);(++);(+++);(++++)","s","single",$Q13a,false,3); ?></td>
                  <td class="title_s">sit&lt;-&gt;stand</td>
                  <td bgcolor="#fff"><?php echo draw_option("Q13c","1;2;3;4;5;6;7","s","single",$Q13c,true,4); ?></td>
                  <td bgcolor="#fff"><?php echo draw_option("Q13d","N;A;N/A","s","single",$Q13d,false,4); ?></td>
                </tr>
                <tr>
                  <td class="title_s">LE</td>
                  <td bgcolor="#fff">
                    <select name="Q14s" id="Q14s">
                      <option></option>
                      <option value="Lt" <?php if ($Q14s=="Lt") { echo 'selected'; } ?>>L't</option>
                      <option value="Rt" <?php if ($Q14s=="Rt") { echo 'selected'; } ?>>R't</option>
                      <option value="RL" <?php if ($Q14s=="RL") { echo 'selected'; } ?>>R/L</option>
                      <option value="NA" <?php if ($Q14s=="NA") { echo 'selected'; } ?>>N/A</option>
                    </select>
                    side: <?php echo draw_option("Q14a","(+);(++);(+++);(++++)","s","single",$Q14a,false,3); ?></td>
                    <td class="title_s" rowspan="3">Transfer&nbsp;Bed, <br />chair, wheelchair,<br />Toitel<br />Tub, Shower</td>
                    <td bgcolor="#fff"><?php echo draw_option("Q14c","1;2;3;4;5;6;7","s","single",$Q14c,true,4); ?></td>
                    <td bgcolor="#fff"><?php echo draw_option("Q14d","N;A;N/A","s","single",$Q14d,false,4); ?></td>
                  </tr>
                  <tr>
                    <td rowspan="2" class="title_s">Muscle<br />strength</td>
                    <td class="title_s">UE</td>
                    <td bgcolor="#fff">
                      <select name="Q15s" id="Q15s">
                        <option></option>
                        <option value="Lt" <?php if ($Q15s=="Lt") { echo 'selected'; } ?>>L't</option>
                        <option value="Rt" <?php if ($Q15s=="Rt") { echo 'selected'; } ?>>R't</option>
                        <option value="RL" <?php if ($Q15s=="RL") { echo 'selected'; } ?>>R/L</option>
                        <option value="NA" <?php if ($Q15s=="NA") { echo 'selected'; } ?>>N/A</option>
                      </select>
                      side general <input type="text" name="Q15a" id="Q15a" size="2" value="<?php echo $Q15a; ?>" /> grade</td>
                      <td bgcolor="#fff"><?php echo draw_option("Q15c","1;2;3;4;5;6;7","s","single",$Q15c,true,4); ?></td>
                      <td bgcolor="#fff"><?php echo draw_option("Q15d","N;A;N/A","s","single",$Q15d,false,4); ?></td>
                    </tr>
                    <tr>
                      <td class="title_s">LE</td>
                      <td bgcolor="#fff">
                        <select name="Q16s" id="Q16s">
                          <option></option>
                          <option value="Lt" <?php if ($Q16s=="Lt") { echo 'selected'; } ?>>L't</option>
                          <option value="Rt" <?php if ($Q16s=="Rt") { echo 'selected'; } ?>>R't</option>
                          <option value="RL" <?php if ($Q16s=="RL") { echo 'selected'; } ?>>R/L</option>
                          <option value="NA" <?php if ($Q16s=="NA") { echo 'selected'; } ?>>N/A</option>
                        </select>
                        side general <input type="text" name="Q16a" id="Q16a" size="2" value="<?php echo $Q16a; ?>" /> grade</td>
                        <td bgcolor="#fff"><?php echo draw_option("Q16c","1;2;3;4;5;6;7","s","single",$Q16c,true,4); ?></td>
                        <td bgcolor="#fff"><?php echo draw_option("Q16d","N;A;N/A","s","single",$Q16d,false,4); ?></td>
                      </tr>
                      <tr>
                        <td rowspan="2" class="title_s">Range of<br />Motion</td>
                        <td class="title_s">UE</td>
                        <td bgcolor="#fff">
                          <select name="Q17s" id="Q17s">
                            <option></option>
                            <option value="Lt" <?php if ($Q17s=="Lt") { echo 'selected'; } ?>>L't</option>
                            <option value="Rt" <?php if ($Q17s=="Rt") { echo 'selected'; } ?>>R't</option>
                            <option value="RL" <?php if ($Q17s=="RL") { echo 'selected'; } ?>>R/L</option>
                            <option value="NA" <?php if ($Q17s=="NA") { echo 'selected'; } ?>>N/A</option>
                          </select>
                          side: <input type="text" name="Q17a" id="Q17a" size="2" value="<?php echo $Q17a; ?>" /></td>
                          <td class="title_s">sitting balance</td>
                          <td bgcolor="#fff" colspan="2"><?php echo draw_option("Q17c","1;2;3;4;5;6;7","s","single",$Q17c,false,4); ?></td>
                        </tr>
                        <tr>
                          <td class="title_s">LE</td>
                          <td bgcolor="#fff">
                            <select name="Q18s" id="Q18s">
                              <option></option>
                              <option value="Lt" <?php if ($Q18s=="Lt") { echo 'selected'; } ?>>L't</option>
                              <option value="Rt" <?php if ($Q18s=="Rt") { echo 'selected'; } ?>>R't</option>
                              <option value="RL" <?php if ($Q18s=="RL") { echo 'selected'; } ?>>R/L</option>
                              <option value="NA" <?php if ($Q18s=="NA") { echo 'selected'; } ?>>N/A</option>
                            </select>
                            side: <input type="text" name="Q18a" id="Q18a" size="2" value="<?php echo $Q18a; ?>" /></td>
                            <td class="title_s">standing balance</td>
                            <td bgcolor="#fff" colspan="2"><?php echo draw_option("Q18c","1;2;3;4;5;6;7","s","single",$Q18c,false,4); ?></td>
                          </tr>
                          <tr>
                            <td rowspan="2" class="title_s">Brunnstrom<br />Stage</td>
                            <td class="title_s">UE</td>
                            <td bgcolor="#fff">
                              <select name="Q19s" id="Q19s">
                                <option></option>
                                <option value="Lt" <?php if ($Q19s=="Lt") { echo 'selected'; } ?>>L't</option>
                                <option value="Rt" <?php if ($Q19s=="Rt") { echo 'selected'; } ?>>R't</option>
                                <option value="RL" <?php if ($Q19s=="RL") { echo 'selected'; } ?>>R/L</option>
                                <option value="NA" <?php if ($Q19s=="NA") { echo 'selected'; } ?>>N/A</option>
                              </select> 
                              side: <br />
                              <?php echo draw_option("Q19a","I;II;III;IV;V;VI","s","single",$Q19a,false,3); ?></td>
                              <td class="title_s">ambulation</td>
                              <td bgcolor="#fff"><?php echo draw_option("Q19c","1;2;3;4;5;6;7","s","single",$Q19c,true,4); ?></td>
                              <td bgcolor="#fff"><?php echo draw_option("Q19d","N;A;N/A","s","single",$Q19d,false,4); ?></td>
                            </tr>
                            <tr>
                              <td class="title_s">LE</td>
                              <td bgcolor="#fff">
                                <select name="Q20s" id="Q20s">
                                  <option></option>
                                  <option value="Lt" <?php if ($Q20s=="Lt") { echo 'selected'; } ?>>L't</option>
                                  <option value="Rt" <?php if ($Q20s=="Rt") { echo 'selected'; } ?>>R't</option>
                                  <option value="RL" <?php if ($Q20s=="RL") { echo 'selected'; } ?>>R/L</option>
                                  <option value="NA" <?php if ($Q20s=="NA") { echo 'selected'; } ?>>N/A</option>
                                </select> 
                                side: <br />
                                <?php echo draw_option("Q20a","I;II;III;IV;V;VI","s","single",$Q20a,false,3); ?></td>
                                <td class="title_s">gait pattern</td>
                                <td bgcolor="#fff"><?php echo draw_option("Q20c","1;2;3;4;5;6;7","s","single",$Q20c,true,4); ?></td>
                                <td bgcolor="#fff"><?php echo draw_option("Q20d","N;A;N/A","s","single",$Q20d,false,4); ?></td>
                              </tr>
                              <tr>
                                <td rowspan="2" class="title_s">Coordination</td>
                                <td class="title_s">UE</td>
                                <td bgcolor="#fff">
                                  <select name="Q21s" id="Q21s">
                                    <option></option>
                                    <option value="Lt" <?php if ($Q21s=="Lt") { echo 'selected'; } ?>>L't</option>
                                    <option value="Rt" <?php if ($Q21s=="Rt") { echo 'selected'; } ?>>R't</option>
                                    <option value="RL" <?php if ($Q21s=="RL") { echo 'selected'; } ?>>R/L</option>
                                    <option value="NA" <?php if ($Q21s=="NA") { echo 'selected'; } ?>>N/A</option>
                                  </select> 
                                  side: finger to nose 
                                  <input type="text" name="Q21a" id="Q21a" size="2" value="<?php echo $Q21a; ?>" /> times/10sec</td>
                                  <td class="title_s">assistive device</td>
                                  <td bgcolor="#fff" colspan="2"><input type="text" name="Q21c" id="Q21c" size="40" value="<?php echo $Q21c; ?>" /></td>
                                </tr>
                                <tr>
                                  <td class="title_s">LE</td>
                                  <td bgcolor="#fff">
                                    <select name="Q22s" id="Q22s">
                                      <option></option>
                                      <option value="Lt" <?php if ($Q22s=="Lt") { echo 'selected'; } ?>>L't</option>
                                      <option value="Rt" <?php if ($Q22s=="Rt") { echo 'selected'; } ?>>R't</option>
                                      <option value="RL" <?php if ($Q22s=="RL") { echo 'selected'; } ?>>R/L</option>
                                      <option value="NA" <?php if ($Q22s=="NA") { echo 'selected'; } ?>>N/A</option>
                                    </select>
                                    side: heel to shin 
                                    <input type="text" name="Q22a" id="Q22a" size="2" value="<?php echo $Q22a; ?>" /> times/10sec</td>
                                    <td class="title_s">Up/down stairs</td>
                                    <td bgcolor="#fff"><?php echo draw_option("Q22c","1;2;3;4;5;6;7","s","single",$Q22c,true,4); ?></td>
                                    <td bgcolor="#fff"><?php echo draw_option("Q22d","N;A;N/A","s","single",$Q22d,false,4); ?></td>
                                  </tr>
                                  <tr>
                                    <td class="title_s" colspan="2">Pain (area):</td>
                                    <td bgcolor="#fff" colspan="2"><input type="text" name="Q23" id="Q23" size="40" value="<?php echo $Q23; ?>" /></td>
                                    <td class="title_s" colspan="2" style="text-align:left;">Others</td>
                                  </tr>
                                  <tr>
                                    <td class="title_s" colspan="2">cardiopulmonary Status:</td>
                                    <td bgcolor="#fff" colspan="2"><input type="text" name="Q24" id="Q24" size="40" value="<?php echo $Q24; ?>" /></td>
                                    <td bgcolor="#fff" colspan="2"><input type="text" name="Q25" id="Q25" size="35" value="<?php echo $Q25; ?>" /></td>
                                  </tr>
                                </table>
                              </td>
                            </tr>
                            <tr>
                              <td colspan="8" class="title">Assessment</td>
                            </tr>
                            <tr>
                              <td colspan="8">Short term goals achievement percentage:<?php echo draw_option("Q8","100%Complete;85%Complete;50%Complete;25%Complete;0%Complete","xm","single",$Q8,false,1); ?><br /><textarea name="Q9" id="Q9" cols="100" rows="4"><?php echo str_replace("\'","'",$Q9); ?></textarea><br />Quick fill with other inpatients' content:<br />
                                <select onchange="document.getElementById('Q9').value=this.value" style="width:600px">>
                                  <option></option>
                                  <?php
                                  $db3b = new DB;
                                  $db3b->query("SELECT DISTINCT `Q9` FROM `socialform21_2` ORDER BY `HospNo` ASC");
                                  for ($i=0;$i<$db3a->num_rows();$i++) {
                                    $r3b = $db3b->fetch_assoc();
                                    echo '<option value="'.$r3b['Q9'].'">'.$r3b['Q9'].'</option>';
                                  }
                                  ?>
                                </select><br />
                                Long term goals:<br /><textarea name="Q9a" id="Q9a" cols="100" rows="4"><?php echo str_replace("\'","'",$Q9a); ?></textarea><br />Quick fill with other inpatients' content:<br />
                                <select onchange="document.getElementById('Q9a').value=this.value" style="width:600px">>
                                  <option></option>
                                  <?php
                                  $db3c = new DB;
                                  $db3c->query("SELECT DISTINCT `Q9a` FROM `socialform21_2` ORDER BY `HospNo` ASC");
                                  for ($i=0;$i<$db3c->num_rows();$i++) {
                                    $r3c = $db3c->fetch_assoc();
                                    echo '<option value="'.$r3c['Q9a'].'">'.$r3c['Q9a'].'</option>';
                                  }
                                  ?>
                                </select></td>
                              </tr>
                              <tr>
                                <td colspan="8" class="title">Programs</td>
                              </tr>
                              <tr>
                                <td colspan="8"><?php echo draw_checkbox_2col("Q27","Hot/Cold pack;Interferential current;Electrical stimulation;Passive range of motion;Balance training;Ambulation training;Stretch exercise;Strengthening exercise;Tilting table;Mobilization;Gait/posture correction;Facilitation;Balance training;Exercise therapy",$Q27,"multi"); ?></td>
                              </tr>
                              <tr>
                                <td class="title">Physical therapist</td>
                                <td colspan="7"><?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
                              </tr>
                            </table>
                            <center>
                              <div style="margin-top:50px;">
                                <input type="hidden" name="formID" id="formID" value="socialform21_2" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
                              </div>
                            </center>
                          </form><br><br>
