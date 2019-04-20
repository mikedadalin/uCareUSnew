<script>
$(function() {
    $( "#newrecordformInsulin" ).dialog({
        autoOpen: false,
        height: 680, //700
        width: 800,
        modal: true,
        buttons: {
            "New injection record": function() {
                $.ajax({
                    url: "class/nurseform18.php",
                    type: "POST",
                    data: {"HospNo": $("#HospNo").val(), "Qstartdate1": $("#Qstartdate1").val(), "Qmedtime1": $("#Qmedtime1").val(), "QACvalue1": $("#QACvalue1").val(), "Qmedicine1": $("#Qmedicine1").val(), "Qdose1": $("#Qdose1").val(), "Qpart1": $("#Qpart1").val(), "Qfiller": $("#Qfiller").val()  },
                    success: function(data) {
                        var arr = data.split(/;/);
						$( "#newrecordformInsulin" ).dialog( "close" );
						alert("New injection record added");
                        $( "#newrecordtable tbody" ).append( '<tr>' +
                        '<td>' + arr[0] + '</td>' + 
                        '<td>' + arr[1] + '</td>' + 
                        '<td>' + arr[2] + '</td>' +
                        '<td>' + arr[3] + '</td>' + 
                        '<td>' + arr[4] + '</td>' +
                        '<td>' + arr[5] + '</td>' +
                        '<td>' + arr[6] + '</td>' +
						'<td>' + arr[7] + '</td>' +
                        '<td><form><input type="button" id="delete_'+$('#HospNo').val()+'_'+$('#Qstartdate1').val()+'_'+$('#Qmedtime1').val()+'" onclick="confirmdelete(this.id);" value="Delete"></form></td>' +  '</tr>' );
                    }
                });
            },
            "Cancel": function() {
                $( "#newrecordformInsulin" ).dialog( "close" );
            }
        }
    });
    $( "#newrecord" ).button().click(function() {
        $( "#newrecordformInsulin" ).dialog( "open" );
    });
});
</script>
<div class="nurseform-table">
<?php
$arrPart = array(
    '1' => array('A1', 'A2', 'A3', 'A4', 'A5', 'A6', 'A7', 'A8', 'B1', 'B2', 'B3', 'B4', 'B5', 'B6', 'B7', 'B8', 'C1', 'C2', 'C3', 'C4', 'C5', 'C6', 'C7', 'C8', 'D1', 'D2', 'D3', 'D4', 'D5', 'D6', 'D7', 'D8', 'E1', 'E2', 'E3', 'E4', 'E5', 'E6', 'E7', 'E8', 'F1', 'F2', 'F3', 'F4', 'F5', 'F6', 'F7', 'F8', 'G1', 'G2', 'G3', 'G4', 'G5', 'G6', 'G7', 'G8', 'H1', 'H2', 'H3', 'H4', 'H5', 'H6', 'H7', 'H8'),
    '2' => array('1A', '1B', '1C', '1D', '1E', '1F', '1G', '2A', '2B', '2C', '2D', '2E', '2F', '2G', '3A', '3B', '3C', '3D', '3E', '3F', '3G', '4A', '4B', '4C', '4D', '4E', '4F', '4G', '5A', '5B', '5C', '5D', '5E', '5F', '5G', '6A', '6B', '6C', '6D', '6E', '6F', '6G'),
    '3' => array('1A', '1B', '1C', '1D', '1E', '1F', '2A', '2B', '2C', '2D', '2E', '2F', '3A', '3B', '3C', '3D', '3E', '3F', '4A', '4B', '4C', '4D', '4E', '4F', '5A', '5B', '5C', '5D', '5E', '5F', '6A', '6B', '6C', '6D', '6E', '6F', '7A', '7B', '7C', '7D', '7E', '7F', '8A', '8B', '8C', '8D', '8E', '8F'),
    '4' => array('1A', '1B', '1C', '1D', '1E', '1F', '1G', '1H', '2A', '2B', '2C', '2D', '2E', '2F', '2G', '2H', '3A', '3B', '3C', '3D', '3E', '3F', '3G', '3H', '4A', '4B', '4C', '4D', '4E', '4F', '4G', '4H', '5A', '5B', '5C', '5D', '5E', '5F', '5G', '5H', '6A', '6B', '6C', '6D', '6E', '6F', '6G', '6H')
);
?>

<div name="newrecordformInsulin" id="newrecordformInsulin" title="New injection record" onclick="filloldrecord()">
    <fieldset>
        <table>
            <tr>
                <td class="title" width="100">Date</td>
                <td colspan="2"><script> $(function() { $( "#Qstartdate1").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="Qstartdate1" id="Qstartdate1" value="<?php echo date(Y."/".m."/".d); ?>" size="12">
                  <span class="title">Time</span>
                  <input type="text" name="Qmedtime1" id="Qmedtime1" value="<?php echo date(Hi); ?>" size="4" />
                <font size="2">(Format:HHmm)</font></td>
            </tr>
            <tr>
                <td class="title">Blood glucose level</td>
                <td colspan="2"><input type="text" name="QACvalue1" id="QACvalue1" value="<?php echo $ACvalue; ?>" size="4">mg/dl</td>
            </tr>
            <tr>
                <td class="title" valign="top">Medication</td>
                <td colspan="2">
                <input type="text" name="Qmedicine1" id="Qmedicine1" value="" size="30"><br />
                <input type="button" onclick="writetomed1('Novomix')" value="Novomix" />
                <input type="button" onclick="writetomed1('Regular Insulin (RI)')" value="Regular Insulin (RI)" />
                <input type="button" onclick="writetomed1('Humulin N')" value="Humulin N" />
                <input type="button" onclick="writetomed1('Lantus')" value="Lantus" />
                <input type="button" onclick="writetomed1('Forteo')" value="Forteo" /><br />
                <input type="button" onclick="writetomed1('Humalog mix Kwikpen')" value="Humalog mix Kwikpen" />
                <input type="button" onclick="writetomed1('Apidra')" value="Apidra" />
                <input type="button" onclick="writetomed1('Novorapid')" value="Novorapid" />
                <input type="button" onclick="writetomed1('Insulatard')" value="Insulatard" />
                <input type="button" onclick="writetomed1('Levemir')" value="Levemir" />
                <input type="button" onclick="writetomed1('Hold')" value="Hold" />
                <script>
                function writetomed1(name) {
                    if (document.getElementById('Qmedicine1').value!='') {
                        if (confirm('是否取代原有內容？\n按「確定」為「取代」，按「取消」為「加在原內容後方」')) {
                            document.getElementById('Qmedicine1').value = name;
                        } else {
                            document.getElementById('Qmedicine1').value = document.getElementById('Qmedicine1').value + ' ' + name;
                        }
                    } else {
                        document.getElementById('Qmedicine1').value = name;
                    }
                }
                </script>
                </td>
            </tr>
            <tr>
                <td class="title">Dose</td>
                <td colspan="2"><input type="text" name="Qdose1" id="Qdose1" value="" size="4">Unit</td>
            </tr>
            <tr>
                <td>Last 3 records</td>
                <td colspan="2"><div id="oldrecord"></div></td>
            <tr>
                <td class="title" valign="top">Body part</td>
                <td valign="top">
                <select id="Qpart1" name="Qpart1">
                  <option></option>
                  <?php
                  foreach ($arrPart[$_SESSION['ncareInsulinImage_lwj']] as $k=>$v) {
                      echo '<option value="'.$v.'">'.$v.'</option>';
                  }
                  ?>
                </select>
                <input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
                <input type="hidden" name="Qfiller" id="Qfiller" value="<?php echo $_SESSION['ncareID_lwj']; ?>">
                </td>
                <td>
                <?php
                if ($_SESSION['ncareInsulinImage_lwj']==1) {
                    echo '<img src="module/nurseform/img/pic2.png" border="0" width="440" />';
                } elseif ($_SESSION['ncareInsulinImage_lwj']==2) {
                    echo '<img src="module/nurseform/img/pic2a.png" border="0" width="220" />';
                } elseif ($_SESSION['ncareInsulinImage_lwj']==3) {
                    echo '<img src="module/nurseform/img/pic2b.png" border="0" width="440" />';
                } elseif ($_SESSION['ncareInsulinImage_lwj']==4) {
                    echo '<img src="module/nurseform/img/pic2c.png" border="0" width="220" />';
                }
                ?>
                </td>
            </tr>
        </table>
    </fieldset>
</div>
<div class="moduleNoTab">
<h3>Insulin injection record</h3>


<?php
$url = $_SERVER['PHP_SELF'];
$url = explode(".",$url);
$url = explode("/",$url[0]);
$file = $url[2];
?>
<div align="right" <?php if ($file=="print") echo ' style="display:none;"'; ?>>


<script>
function datefunction(functioname) {
    var date1 = (document.getElementById('printdate1').value).replace("/",""); date1 = date1.replace("/","");
    var date2 = (document.getElementById('printdate2').value).replace("/",""); date2 = date2.replace("/","");
    //window.location.href='print.php?mod=nurseform&func=formview&pid=<?php //echo @$_GET['pid']; ?>&id=5&date1='+date1+'&date2='+date2;
    if (functioname=='print') {
        window.open('print.php?mod=nurseform&func=formview&pid=<?php echo @$_GET['pid']; ?>&id=18&date1='+date1+'&date2='+date2<?php if (@$_GET['query']==1) { echo '+\'&query=1\''; } ?>);
    } else if (functioname=='view') {
        window.location.href='index.php?mod=nurseform&func=formview&pid=<?php echo @$_GET['pid']; ?>&id=18&date1='+date1+'&date2='+date2<?php if (@$_GET['query']==1) { echo '+\'&query=1\''; } ?>;
    }
}
</script>
<table <?php  if (strpos($_SERVER['PHP_SELF'],'print.php')!==false) { echo 'style="display:none;"'; }else{ echo 'style="width:100%;"'; } ?>>
  <tr>
    <?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?>
	<!--<td bgcolor="#FFFFFF"><form><input type="button" id="newrecord" value="New injection record" style="font-size:10pt;" /></form></td>-->
    <?php }?>
	<td align="left">
    <form><?php
    if (@$_GET['query']==NULL) {
        echo '<input type="button" value="Display only records with value" onclick="window.location.href=\'index.php?mod=nurseform&func=formview&pid='.@$_GET['pid'].'&id=18&query=1';
        if (@$_GET['date1']!='') { echo '&date1='.@$_GET['date1'].'&date2='.@$_GET['date2']; }
        echo'\';" style="font-size:10pt;" />';
    } else {
        echo '<input type="button" value="Display all records" onclick="window.location.href=\'index.php?mod=nurseform&func=formview&pid='.@$_GET['pid'].'&id=18';
        if (@$_GET['date1']!='') { echo '&date1='.@$_GET['date1'].'&date2='.@$_GET['date2']; }
        echo '\';" style="font-size:10pt;" />';
    }
    ?>
    Select date:<script> $(function() { $( "#printdate1").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="printdate1" id="printdate1" value="<?php if (@$_GET['date1']==NULL) { echo date(Y."/".m."/01"); } else { echo formatdate(@$_GET['date1']); } ?>" size="12"> ~ <script> $(function() { $( "#printdate2").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="printdate2" id="printdate2" value="<?php if (@$_GET['date2']==NULL) { echo date(Y."/".m."/".d); } else { echo formatdate(@$_GET['date2']); } ?>" size="12"><input type="button" value="Search" onclick="datefunction('view');" /><input type="button" value="Print" onclick="datefunction('print');" /></form></td>
  </tr>
</table>
</div>
<table width="100%" id="newrecordtable">
  <thead>
  <tr class="title">
    <td>Date</td>
    <td>Time</td>
    <td>Blood glucose level</td>
    <td>Medication</td>
    <td>Dose</td>
    <td>Body part</td>
    <td>Staff</td>
    <td class="printcol">Delete</td>
  </tr>
  </thead>
  <tbody>
  <?php
  if (@$_GET['query']=="") {
      if (@$_GET['date1']==NULL || @$_GET['date2']==NULL) {
          $db3 = new DB;
          $db3->query("SELECT * FROM `nurseform18_1` WHERE `HospNo`='".$HospNo."' AND `QInsulinRecordType`='1' ORDER BY `Qstartdate1` ASC, `Qmedtime1` ASC");
      } else {
          $db3 = new DB;
          $db3->query("SELECT * FROM `nurseform18_1` WHERE `HospNo`='".$HospNo."' AND `QInsulinRecordType`='1' AND `Qstartdate1`>='".mysql_escape_string($_GET['date1'])."' AND `Qstartdate1`<='".mysql_escape_string($_GET['date2'])."' ORDER BY `Qstartdate1` ASC, `Qmedtime1` ASC");
      }
  } elseif (@$_GET['query']=="1") {
      if (@$_GET['date1']==NULL || @$_GET['date2']==NULL) {
          $db3 = new DB;
          $db3->query("SELECT * FROM `nurseform18_1` WHERE `HospNo`='".$HospNo."' AND `QInsulinRecordType`='1' AND `QACvalue1`!='' ORDER BY `Qstartdate1` ASC, `Qmedtime1` ASC");
      } else {
          $db3 = new DB;
          $db3->query("SELECT * FROM `nurseform18_1` WHERE `HospNo`='".$HospNo."' AND `QInsulinRecordType`='1' AND `Qstartdate1`>='".mysql_escape_string($_GET['date1'])."' AND `Qstartdate1`<='".mysql_escape_string($_GET['date2'])."' AND `QACvalue1`!='' ORDER BY `Qstartdate1` ASC, `Qmedtime1` ASC");
      }
  }
  for ($i=0;$i<$db3->num_rows();$i++) {
    $r3 = $db3->fetch_assoc();
    echo '
  <tr>
    <td>'.formatdate($r3['Qstartdate1']).'</td>
    <td>'.substr($r3['Qmedtime1'],0,2).':'.substr($r3['Qmedtime1'],2,2).'</td>
    <td>'.$r3['QACvalue1'].'</td>
    <td>'.$r3['Qmedicine1'].'</td>
    <td>'.$r3['Qdose1'];
    if ($r3['Qdose1']!="") { echo "Unit"; }
    echo '</td>
    <td>'.$r3['Qpart1'].'</td>
    <td>';
    $db_filler = new DB2;
    $db_filler->query("SELECT `name` FROM `userinfo` WHERE `userID`='".$r3['Qfiller']."' AND `orgID`='".$_SESSION['nOrgID_lwj']."'");
    $r_filler = $db_filler->fetch_assoc();
    echo $r_filler['name'];
    echo '</td>';
	if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){
	echo '
    <td class="printcol">';
    if ($r3['Qfiller']==$_SESSION['ncareID_lwj']) {
        echo '<form><input type="button" id="delete_'.$HospNo.'_'.$r3['Qstartdate1'].'_'.$r3['Qmedtime1'].'" onclick="confirmdelete(this.id);" value="Delete"></form>';
    } else { echo '&nbsp;'; }
    echo '</td>';
	}
	echo '
  </tr>
  '."\n";
    if (($db3->num_rows()-$i)<4) {
        $spantext .= '
          <tr>
            <td>'.formatdate($r3['Qstartdate1']).'</td>
            <td>'.substr($r3['Qmedtime1'],0,2).':'.substr($r3['Qmedtime1'],2,2).'</td>
            <td>'.$r3['QACvalue1'].'</td>
            <td>'.$r3['Qmedicine1'].'</td>
            <td>'.$r3['Qdose1']; if ($r3['Qdose1']!="") { $spantext .= "Unit"; }
            $spantext .= '</td>
            <td>'.$r3['Qpart1'].'</td>
          </tr>'."\n";
          
          //$spantext = $addtext.$spantext;
    }
                            
        if ($r3) {
            foreach ($r3 as $k=>$v) {
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

  }
  ?>
  </tbody>
</table>
<div id="spantext" style="display:none;">
<table style="font-size:10pt; width:100%">
  <thead><tr>
    <td>Date</td>
    <td>Time</td>
    <td>Blood glucose level</td>
    <td>Medication</td>
    <td>Dose</td>
    <td>Body part</td>
  </tr></thead>
  <?php echo $spantext; ?>
</table>
</div>
<script>
function filloldrecord() {
  document.getElementById('oldrecord').innerHTML = document.getElementById('spantext').innerHTML;
}
function confirmdelete(id) {
    if (confirm('Confirm deletion?')) {
        var postinfo = id.split(/_/);
        $.ajax({
            url: "class/nurseform18_delete.php",
            type: "POST",
            data: {"HospNo": postinfo[1], "Qstartdate1": postinfo[2], "Qmedtime1": postinfo[3] },
            success: function(data) {
                confirm("Successfully deleted");
                document.location.reload(true);
            }
        });
    } else {
        alert('Deletion canceled');
    }
}
<?php
$url = explode('/', $_SERVER['REQUEST_URI']);
$file = substr($url[3],0,5);
if ($file=="index") {
?>
$('#newrecordtable').dataTable({
    "order": [[0,"desc"],[1,"desc"]],
    "paging": false
});
<?php
}
?>
</script>
<style>
@media print {
    .fg-toolbar {
        display:none;
    }
}
</style>
    </div>
  </div>