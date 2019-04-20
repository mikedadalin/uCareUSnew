<script>
$(function() {
  $( "#dialog-form" ).dialog({
    autoOpen: false,
    height: 510,
    width: 640,
    modal: true,
    buttons: {
     "Input": function() {
      $.ajax({
       url: "class/inputoutput_resptimes.php",
       type: "POST",
       data: {"bedID": $("#resper").val(), "date": $("#measuredate").val(),"measuretime": $("#measuretime").val(), "input":$("#input").val(), "output":$("#output").val(), "output1":$("#output1").val(), "output2":$("#output2").val(), "output3":$("#output3").val(), "IOstatus":$('#IOstatus').val(), "Qfiller":'<?php echo $_SESSION['ncareID_lwj']; ?>' },
       success: function(data) {
        alert("Successfully saved!");
        $("#pinfo").text("");
        $( "#dialog-form" ).dialog( "close" );
        window.location.reload();
      }
    });
    },
    "Cancel": function() {
      $( "#dialog-form" ).dialog( "close" );
    }
  }
});
  $("#output").blur(function(){
    $("#IOstatus").val($("#input").val() - $("#output").val());
  });
  $("#input").blur(function(){
    $("#IOstatus").val($("#input").val() - $("#output").val());
  });
});

function dialogform_set(id){
	var respid = id;
	respid = respid.split(/_/);
	$("#pinfo").text(respid[1]+"Bed");
	document.getElementById('resper').value = respid[1];
	openVerificationForm('#dialog-form');
}
</script>
<div id="dialog-form" title="I/O intake and output" class="dialog-form"> 
  <form>
    <fieldset><legend><span id="pinfo"></span></legend>
        <table>
          <tr>
            <td class="title">Measure date/time</td>
            <td><script> $(function() { $( "#measuredate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="measuredate" id="measuredate" value="<?php echo date('Y-m-d'); ?>" size="12" > <input type="text" name="measuretime" id="measuretime" value="<?php echo date(Hi); ?>" size="4" > <font size="2">(Format:HHmm)</font></td>
			<input type="hidden" id="resper" name="resper">
          </tr>
          <tr>
            <td class="title">Total daily intake<br />I (Intake)</td>
            <td><input type="text" name="input" id="input" size="4"></td>
          </tr>
          <tr>
            <td class="title">Total daily output<br />O (Output)</td>
            <td><input type="text" name="output" id="output" size="4"></td>
          </tr>
          <tr>
            <td class="title">1. Stool<br />(STOOL)</td>
            <td><input type="text" name="output1" id="output1" size="4"></td>
          </tr>
          <tr>
            <td class="title">2. Number of other drainage tube<br />(Drain)</td>
            <td><input type="text" name="output2" id="output2" size="4"></td>
          </tr>
          <tr>
            <td class="title">3. Other<br />(Other)</td>
            <td><input type="text" name="output3" id="output3" size="4"></td>
          </tr>
          <tr>
            <td class="title">I-O=Daily<br />Positive and negative status</td>
            <td><input type="text" name="IOstatus" id="IOstatus" size="4"></td>
          </tr>
        </table>
    </fieldset>
  </form>
</div>

  <?php
  $db = new DB;
  $db->query("SELECT `patientID`,`Birth` FROM `patient` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."' ORDER BY `patientID` ASC");
  for ($i=0;$i<$db->num_rows();$i++) {
   $r = $db->fetch_assoc();
   $db1 = new DB;
   $db1->query("SELECT `indate` FROM `inpatientinfo` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."'");
   $r1 = $db1->fetch_assoc();
 $name = getPatientName($r['patientID']);
 $birth = formatdate($r['Birth']);
 $indate = formatdate($r1['indate']);
}
$basicinfo = '<div class="content-query" style="width:100%;">
<table align="center" style="width:100%;">
<tr>
<td class="title">Full name</td>
<td>'.$name.'</td>
<td class="title">DOB</td>
<td>'.$birth.'</td>
<td class="title">Admission date</td>
<td>'.$indate.'</td>
</tr>
</table>
</div>'."\n";
?>
<div style="background-color: rgba(255,255,255,0.8); border-radius: 10px; padding:10px 0px 30px 0px; margin-bottom: 20px; width:100%;">
  <table style="width:98%; margin:5px;">
    <tr>
      <td valign="top" style="width:15%;">
        <div style="width:100%; background:rgba(88,88,88,0.9); border-radius:5px; padding: 7px 0px;"><?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){ include("ResidentCol.php");} ?></div>
      </td>
      <td valign="top" style="width:85%;">
        <div id="tab1">
          <table style="width:100%">
            <tr>
              <td colspan="2"><h3 align="center">Overview</h3></td>
            </tr>
            <tr>
              <td colspan="2">
                <?php echo $basicinfo; ?>
              </td>
            </tr>
            <tr>
              <td align="left">
                <?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?>
                <form><input type="button" id="newrecord_<?php echo getBedID(@$_GET['pid']); ?>" value="Input I/O value" onclick="dialogform_set(this.id);" /></form>
                <?php }?>
              </td>
              <td align="right">
                <?php
                if ($_SESSION['ncareGroup_lwj']!=3) {
                  ?>
                  <select id="selmonth">
                    <option>--Select month--</option>
                    <?php
                    for ($i=date(m);$i>=(date(m)-5);$i--) {
                      $month = $i;
                      $year = date(Y);
                      if ($i<1) {
                        $month = 12+$i;
                        $year = date(Y)-1;
                      }
                      if (strlen($month)==1) {
                        $month = "0".$month;
                      }
                      echo '<option value="'.$year.$month.'">'.$year.'-'.$month.'</option>'."\n";
                    }
                    ?>
                  </select>
                  <input type="image" src="Images/print.png" onclick="printvitalsign('<?php echo @$_GET['pid']; ?>')">
                  <script>
                  function printvitalsign(pid) {
                    var selectedmonth = document.getElementById('selmonth').value;
                    window.open('print.php?mod=inputoutput&func=printvitalsign&pid='+pid+'&date='+selectedmonth, '_blank' );
                  }
                  </script>
                  <?php }?>
                </td>
              </tr>
            </table>
            <table cellpadding="6px" style="font-size:10pt; width:100%;">
              <tr bgcolor="#f54d5d" style="color:#ffffff; text-transform:capitalize" class="title" align="center">
                <td>Time</td>
                <td>Total daily intake<br />I (Intake)</td>
                <td>Total daily output<br />O (Output)</td>
                <td>1. Stool<br />(STOOL)</td>
                <td>2. Number of other drainage tube<br />(Drain)</td>
                <td>3. Other<br />(Other)</td>
                <td>I-O = Daily<br />Positive and negative status</td>
                <td>Filled by</td>
              </tr>
              <?php
              $db2 = new DB;
              $db2->query("SELECT * FROM `iostatus` WHERE `PersonID`='".mysql_escape_string($_GET['pid'])."' ORDER BY `RecordedTime` DESC LIMIT 0,30");
              for ($i=0;$i<$db2->num_rows();$i++) {
               $r2 = $db2->fetch_assoc();
               $recocordedtime = substr($r2['RecordedTime'],0,19);
               if ($i%2==0) { $bgcolor = '#feeced'; } else { $bgcolor = '#ffffff'; }
               echo '
               <tr bgcolor="'.$bgcolor.'" align="center">
               <td>'.$recocordedtime.'</td>
               <td>'.$r2['input'].'</td>
               <td>'.$r2['output'].'</td>
               <td>'.$r2['output1'].'</td>
               <td>'.$r2['output2'].'</td>
               <td>'.$r2['output3'].'</td>
               <td>'.$r2['iostatus'].'</td>
               <td>'.checkusername($r2['Qfiller']).'</td>
               </tr>'."\n";
             }
             ?>
           </table>
         </div>
       </td>
     </tr>
   </table>
</div>