<div class="patlistbtnlist">
    <div class="patlistbtn"><a href="index.php?func=printPatStat" title="住民名冊"><i class="fa fa-users fa-2x fa-fw"></i><br>住民名冊</a></div>
	<div class="patlistbtn"><a href="index.php?func=form2klist" title="管路使用情形總表"><i class="fa fa-newspaper-o fa-2x fa-fw"></i><br>Pipeline summary list</a></div>
    <div class="patlistbtn"><a href="index.php?func=formremind&type=1" title="表單填寫提示"><i class="fa fa-warning fa-2x fa-fw"></i><br>表單警示</a></div>
    <div class="patlistbtn"><a href="index.php?func=reminderlist&date1=<?php echo date(Ymd); ?>&date2=<?php echo str_replace("/","",calcdayafterday(date(Ymd),30)); ?>" title="提醒事項列表"><i class="fa fa-tasks fa-2x fa-fw"></i><br>提醒列表</a></div>
    <div class="patlistbtn"><a href="index.php?func=reminderlist2&date1=<?php echo date(Ymd); ?>&date2=<?php echo str_replace("/","",calcdayafterday(date(Ymd),30)); ?>" title="Special reminder"><i class="fa fa-bell-o fa-2x fa-fw"></i><br>Special reminders</a></div>
    <div class="patlistbtn"><a href="index.php?func=areadmin" title="床位管理"><i class="fa fa-bed fa-2x fa-fw"></i><br>床位管理</a></div>
    <!--<div class="patlistbtn"><a href="index.php?func=shiftrecord&date1=<?php echo str_replace("/","",calcdayafterday(date(Ymd),-7)); ?>&date2=<?php echo date(Ymd); ?>" title="護理紀錄總表"><i class="fa fa-list fa-2x fa-fw"></i><br>護紀總表</a></div>
    <div class="patlistbtn"><a href="index.php?func=shiftrecord1" title="Nursing document handover table"><i class="fa fa-refresh fa-2x fa-fw"></i><br>護理交班</a></div>
    <div class="patlistbtn"><a href="index.php?func=areadmin" title="床位管理"><i class="fa fa-bed fa-2x fa-fw"></i><br>床位管理</a></div>
    <div class="patlistbtn"><a href="index.php&func=formview&id=6" title="護理會議紀錄"><i class="fa fa-users fa-2x fa-fw"></i><br>會議紀錄</a></div>
    <?php if (substr($_SESSION['nOrgID_lwj'],0,1)!="K") { ?>
    <div class="patlistbtn"><a href="index.php?func=form2jtracklist" title="疼痛評估追蹤"><i class="fa fa-list-alt fa-2x fa-fw"></i><br>疼痛追蹤</a></div><?php } else { ?>
    <div class="patlistbtn"><a href="index.php?func=form2jtracklist" title="疼痛總表"><i class="fa fa-list-alt fa-2x fa-fw"></i><br>疼痛總表</a></div><?php } ?>-->
    <div class="patlistbtn"><a href="index.php?func=newcase" title="新增住民"><i class="fa fa-user-plus fa-2x fa-fw"></i><br>新增住民</a></div>
</div>

<div id="typeTab">
  <ul>
    <li><a href="#typeTab-1">General</a></li>
    <li><a href="#typeTab-4">Discharged/case closed</a></li>
  </ul>
  <div id="typeTab-1" style="padding:20px 0px; font-size:12pt;">
  <table id="patlist1" class="hover">
  <?php
  $sql1 = "SELECT `patientID` FROM `inpatientinfo` a INNER JOIN `bedinfo` b ON a.`bed`=b.`bedID` ORDER BY b.`Area` ASC, a.`bed` ASC";
  $db = new DB;
  $db->query($sql1);
      echo '
      <thead>
      <tr class="title">
        <th>Function</th>
        <th>Area(location)</th>
        <th>Bed #</th>
        <th>Full name</th>
        <th>Care ID#</th>
        <th>Gender</th>  
        <th>Age</th>
        <th>收案日期</th>
        <th>個案作業</th>
		<th>物品作業</th>
      </tr>
      </thead>'."\n";
      for ($i=0;$i<$db->num_rows();$i++) {
          $r = $db->fetch_assoc();
          $db1 = new DB;
          $db1->query("SELECT `bed`,`indate` FROM `inpatientinfo` a INNER JOIN `patient` b ON a.patientID = b.patientID WHERE a.`patientID`='".$r['patientID']."' AND b.`type`='1' ORDER BY a.`patientID` DESC LIMIT 0,1");
          for ($j=0;$j<$db1->num_rows();$j++) {
              $r1 = $db1->fetch_assoc();
              if (@$_GET['query']==1 && $_GET['type']==1) {
                  if (count($arrAreaBed)==0) {
                      if (@$_GET['query']!=NULL) {
                          echo '<script>alert("此區域尚未有住民收案");</script>'."\n";
                          break 2;
                      }
                  }
              }
              $db2a = new DB;
              $db2a->query("SELECT `Area` FROM `bedinfo` WHERE `bedID`='".$r1['bed']."'");
              $r2a = $db2a->fetch_assoc();
              $db2b = new DB;
              $db2b->query("SELECT `areaName` FROM `areainfo` WHERE `areaID`='".$r2a['Area']."'");
              $r2b = $db2b->fetch_assoc();
              $db2c = new DB;
              $db2c->query("SELECT `HospNo`,`HospNoDisplay`,`Birth`,`instat` FROM `patient` WHERE `patientID`='".$r['patientID']."' AND `type`='1'");
              $r2c = $db2c->fetch_assoc();
              if (count($arrAreaBed)==0 || in_array($r1['bed'],$arrAreaBed)) {
                  echo '
                  <tr';
                  if ($_SESSION['ncareOrgStatus_lwj']==2) {
                      if ($r2c['instat']==0) { echo ' style="display:none;"'; }
                  }
                  echo '>
                    <td class="link1">
                      <center>
                      <a href="index.php?mod=homecare&func=formview&pid='.$r['patientID'].'&query='.@$_GET['query'].'" title="Edit"><i class="fa fa-magic fa-lg"></i></a>
                      </center>
                    </td>
                    <td>'.$r2b['areaName'].'</td>
                    <td>'.$r1['bed'].'</td>
                    <td>'.getPatientName($r['patientID']).'</td>
                    <td>'.$r2c['HospNoDisplay'].'</td>
                    <td align="center">'.(checkgender($r['patientID'])=="Male"?'<span style="color:CornflowerBlue;"><i class="fa fa-2x fa-male"></i></span>':(checkgender($r['patientID'])=="Female"?'<span style="color:pink;"><i class="fa fa-2x fa-female"></i></span>':'---')).'</td>  
                    <td>'.calcage($r2c['Birth']).'</td>
                    <td>'.formatdate($r1['indate']).'</td>
                    <td class="link1"><center>
					  <a onclick="changeinfo(\''.$r2c['HospNo'].'\')" title="Modify Care ID # or resident type"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-pencil fa-stack-1x fa-inverse"></i></span></a>
                      <a onclick="closecase(\''.$r2c['HospNo'].'\')" title="Discharge resident"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-user-times fa-stack-1x fa-inverse"></i></span></a>
                    </center>
                    </td>
					<td class="link1">
                      <center>
                      <a href="index.php?mod=consump&func=formview&id=3&pid='.$r['patientID'].'&query='.@$_GET['query'].'" title="Apply for item"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-shopping-cart fa-stack-1x fa-inverse"></i></span></a>
                      <a href="index.php?func=editmonthlyfee&pid='.$r['patientID'].'" title="Input charging"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-dollar fa-stack-1x fa-inverse"></i></span></a>
                      </center>
                    </td>';
                  echo '</tr>'."\n";
              }
          }
      }
      ?>
  </table>
  </div>
  <div id="typeTab-4" style="padding:20px 0px; font-size:12pt;">
  <table id="closecasetable" class="hover">
      <thead>
      <tr class="title">
        <th>Function</th>
        <th>Full name</th>
        <th>Care ID#</th>
        <th>Gender</th> 
        <th>收案日期</th>
        <th>Discharged date</th>
        <th width="400">Reason</th>
        <th>重新收案</th>
      </tr>
      </thead>
      <?php
      $sql1 = "SELECT * FROM `closedcase` ORDER BY `feeclear` ASC, `outdate` DESC";
      $db = new DB;
      $db->query($sql1);
      for ($i=0;$i<$db->num_rows();$i++) {
          $r = $db->fetch_assoc();
          echo '
  <tr'.($_SESSION['ncareOrgStatus_lwj']==2 && $r2c['instat']==0?' style="display:none;"':"").'>
    <td class="link1">
	  <center>
	  <a href="index.php?mod=homecare&func=formview&pid='.$r['patientID'].'&query='.@$_GET['query'].'" title="Edit"><i class="fa fa-magic fa-lg"></i></a>
	  </center>
	</td>
    <td>'.getPatientName($r['patientID']).'</td>
    <td>'.getHospNoDisplayByPID($r['patientID']).'</td>
    <td align="center">'.(checkgender($r['patientID'])=="Male"?'<span style="color:CornflowerBlue;"><i class="fa fa-2x fa-male"></i></span>':(checkgender($r['patientID'])=="Female"?'<span style="color:pink;"><i class="fa fa-2x fa-female"></i></span>':'---')).'</td>  
    <td>'.formatdate($r['indate']).'</td>
    <td>'.formatdate($r['outdate']).'</td>
    <td>'.option_result("Qreason", "Return/visit home;Hospitalization;Referrals to other facility/center;Death;Other", 's', 'single', $r['reason'], false, 1).($r['memo']!=""?": ".$r['memo']:"").'</td>
    <td class="link1">';
	$db4 = new DB;
	$db4->query("SELECT `patientID` FROM `inpatientinfo` WHERE `patientID`='".$r['patientID']."'");
	if ($db4->num_rows()==0) {
		echo '<a onclick="reopen(\''.getHospNo($r['patientID']).'\')" title="重新收案"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-arrow-left fa-stack-1x fa-inverse"></i></span></a>';
	}
	echo '</td>
  </tr>'."\n";
      
      }
      ?>
      </table>
  </div>
</div>
<p>&nbsp;</p>
<script>
$('#typeTab').tabs(<?php if (@$_GET['type']!="") { echo '{active: '.(@$_GET['type']-1).'}'; } ?>);
</script>

<!--結案作業-->
<script>
$(function() {
    $( "#closecaseform" ).dialog({
		autoOpen: false,
		height: 360,
		width: 600,
		modal: true,
		buttons: {
			"Discharge procedure": function() {
				$.ajax({
					url: "class/closecase.php",
					type: "POST",
					data: {"HospNo": $(this).data('patientID'), "Qclosedate": $("#Qclosedate").val(), "Qreason": $("#Qreason").val(), "Qmemo": $("#Qmemo").val()},
					success: function(data) {
						$( "#closecaseform" ).dialog( "close" );
						alert("已經完成結案");
						window.location.reload();
					}
				});
			},
			"Cancel": function() {
				$( "#closecaseform" ).dialog( "close" );
			}
		}
	});
});
</script>
<div id="closecaseform" title="Discharge procedure"> 
  <form>
  <fieldset>
    <table>
      <tr>
        <td class="title" width="100">Discharged date</td>
        <td><script> $(function() { $( "#Qclosedate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="Qclosedate" id="Qclosedate" value="<?php echo date(Y."/".m."/".d); ?>" size="12"></td>
      </tr>
      <tr>
        <td class="title" width="100">Case closed reason</td>
        <td>
          <select id="Qreason" name="Qreason">
   	   <option></option>
	   <option value="1">Return/visit home</option>
	   <option value="2">Hospitalization</option>
	   <option value="3">Referrals to other facility/center</option>
	   <option value="4">Death</option>
	   <option value="5">Other</option>
	 </select></td>
      </tr>
      <tr>
        <td class="title" width="100">Memo/Explanation:</td>
        <td><input type="text" name="Qmemo" id="Qmemo" size="40"></td>
      </tr>
    </table>
  </fieldset>
  </form>
</div>

<!--移床作業-->
<script>
$(function() {
    $( "#changebedform" ).dialog({
		autoOpen: false,
		height: 360,
		width: 600,
		modal: true,
		buttons: {
			"Confirm relocate bed": function() {
				//if (checkBed($('#NewBed').val())) {
					$.ajax({
						url: "class/changebedform.php",
						type: "POST",
						data: {"HospNo": $(this).data('patientID'), "NewBed": $('#bed').val(), "BedArea": $('#BedArea').val() },
						success: function(data) {
							$( "#changebedform" ).dialog( "close" );
							alert("已經完成移床");
							window.location.reload();
						}
					});
				//}
			},
			"Cancel": function() {
				$( "#changebedform" ).dialog( "close" );
			}
		}
	});
});
<!--重收案作業-->
$(function() {
    $( "#reopenform" ).dialog({
		autoOpen: false,
		height: 360,
		width: 600,
		modal: true,
		buttons: {
			"確定重新收案": function() {
				//if (checkBed($('#NewBed').val())) {
					$.ajax({
						url: "class/reopenform.php",
						type: "POST",
						data: {"HospNo": $(this).data('patientID'), "Reindate": $('#reindate').val(), "NewBed": $('#reopen_NewBed').val(), "BedArea": $('#reopen_BedArea').val() },
						success: function(data) {
							//alert(data);
							$( "#changebedform" ).dialog( "close" );
							alert("已經完成重新收案作業");
							window.location.reload();
						}
					});
				//}
			},
			"Cancel": function() {
				$( "#reopenform" ).dialog( "close" );
			}
		}
	});
});
function checkBed(bedID) {
	var result1;
	$.ajax({
		url: 'class/checkBed.php',
		type: "POST",
		async: false,
		data: { bedID: $('#NewBed').val() }
	}).done(function(result){
		if (result!='OK') {
			alert('不可使用此床位號碼，請重新輸入！');
			result1 = false;
		} else {
			//alert('床位號碼可用！');
			result1 = true;
		}
	});
	return result1;
}
function closecase(patientid) {
	$( "#closecaseform" ).data('patientID',patientid).dialog( "open" );
}
function changebed(patientid) {
	$( "#changebedform" ).data('patientID',patientid).dialog( "open" );
}
function switchbed(patientid) {
	$( "#switchbedform" ).data('patientID',patientid).dialog( "open" );
}
function changeinfo(patientid) {
	$.ajax({
		url: "class/patinfo3.php",
		type: "POST",
		data: {"PID": patientid},
		success: function(data) {
			//alert(data);
			var arr = data.split(';');
			$('#cQHospNoDisplay').val(arr[0]);
			$('#cQtype').val(arr[1]);
			for (var i=1;i<=5;i++) {
				if (i==1) {
					$('#btn_cQtype_'+i).removeClass().addClass('tabbtn_m_left_off');
				} else if (i==5) {
					$('#btn_cQtype_'+i).removeClass().addClass("tabbtn_m_right_off");
				} else {
					$('#btn_cQtype_'+i).removeClass().addClass("tabbtn_m_middle_off");
				}
				$('#cQtype_'+i).val('0');
			}
			var cName = "tabbtn_m_middle_on";
			if (arr[1]==1) {
				cName = "tabbtn_m_left_on";
			} else if (arr[1]==5) {
				cName = "tabbtn_m_right_on";
			}
			$('#btn_cQtype_'+arr[1]).removeClass().addClass(cName);
			$('#cQtype_'+arr[1]).val('1');
		}
	});
	$( "#changeinfoform" ).data('patientID',patientid).dialog( "open" );
}
function reopen(patientid) {
	$( "#reopenform" ).data('patientID',patientid).dialog( "open" );
}
</script>
<div id="changebedform" title="Bed relocation"> 
  <form>
  <fieldset>
  <?php
  $db = new DB;
  $db->query("SELECT `bed` FROM `inpatientinfo` WHERE `patientID`='' OR `patientID`='0'");
  ?>
    <table>
      <tr>
        <td>Select section/room</td>
        <td>
        <select id="BedArea">
          <option></option>
          <?php
		  $db_area = new DB;
		  $db_area->query("SELECT * FROM `areainfo` ORDER BY `areaID` ASC");
		  for ($i=0;$i<$db_area->num_rows();$i++) {
			  $r_area = $db_area->fetch_assoc();
			  echo '<option value="'.$r_area['areaID'].'">'.$r_area['areaName'].'</option>'."\n";
		  }
		  ?>
        </select>
        </td>
      </tr>
      <tr>
        <td class="title" width="140"><?php if ($db->num_rows()>0) { echo 'Select an empty bed';	 } else { echo 'Input new bed #'; } ?></td>
        <td>
          <select name="bed" id="bed">
          <option></option>
          </select>
        </td>
      </tr>
    </table>
  </fieldset>
  </form>
</div>
<script>
$('#BedArea').change(function () {
	$.ajax({
		url: "class/checkEmptyBed.php",
		type: "POST",
		data: { "Area": $("#BedArea").val()},
		success: function(data) {
			if (data=="nobed") {
				$("#bed option").remove();
				$("#bed").append($("<option></option>").attr("value", "").text("No empty bed"));
				$("#bed").attr("disabled",true);
			} else {
				var arr = data.split(';');
				$("#bed").attr("disabled",false);
				$("#bed option").remove();
				$("#bed").append($("<option></option>"));
				for (var i=0; i<arr.length; i++) {
					$("#bed").append($("<option></option>").attr("value", arr[i]).text(arr[i]));
				}
			}
		}
	});
});
</script>

<!--重收案作業-->
<div id="reopenform" title="重新收案作業"> 
  <form>
  <fieldset>
  <?php
  $db = new DB;
  $db->query("SELECT `bed` FROM `inpatientinfo` WHERE `patientID`='' OR `patientID`='0'");
  ?>
    <table>
      <tr>
        <td>選擇收案日期</td>
        <td><script> $(function() { $( "#reindate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="reindate" id="reindate" value="<?php echo date("Y/m/d"); ?>" size="12" ></td>
      </tr>
      <tr>
        <td>Select section/room</td>
        <td>
        <select id="reopen_BedArea">
          <option></option>
          <?php
		  $db_area = new DB;
		  $db_area->query("SELECT * FROM `areainfo` ORDER BY `areaID` ASC");
		  for ($i=0;$i<$db_area->num_rows();$i++) {
			  $r_area = $db_area->fetch_assoc();
			  echo '<option value="'.$r_area['areaID'].'">'.$r_area['areaName'].'</option>'."\n";
		  }
		  ?>
        </select>
        </td>
      </tr>
      <tr>
        <td class="title" width="140"><?php if ($db->num_rows()>0) { echo 'Select an empty bed';	 } else { echo 'Input bed #'; } ?></td>
        <td><select id="reopen_NewBed"><option></option></select></td>
      </tr>
    </table>
  </fieldset>
  </form>
</div>
<script>
$(function() {
	$('table[id^=patlist]').dataTable({
		"order": [[1, "asc"], [2, "asc"]],
		"paging": false,
		"ordering": true,
		"drawCallback": function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;
 
            api.column(1, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="group"><td colspan="11" style="line-height:24px; background:#efefef;"><i class="fa fa-compass fa-lg"></i> '+group+'</td></tr>'
                    );
 
                    last = group;
                }
            } );
        }
	});
	$('#closecasetable').dataTable({
		"order": [[4, "desc"]],
		"paging": false
	});
});
$('#reopen_BedArea').change(function () {
	$.ajax({
		url: "class/checkEmptyBed.php",
		type: "POST",
		data: { "Area": $("#reopen_BedArea").val()},
		success: function(data) {
			if (data=="nobed") {
				$("#reopen_NewBed option").remove();
				$("#reopen_NewBed").append($("<option></option>").attr("value", "").text("No empty bed"));
				$("#reopen_NewBed").attr("disabled",true);
			} else {
				var arr = data.split(';');
				$("#reopen_NewBed").attr("disabled",false);
				$("#reopen_NewBed option").remove();
				$("#reopen_NewBed").append($("<option></option>"));
				for (var i=0; i<arr.length; i++) {
					$("#reopen_NewBed").append($("<option></option>").attr("value", arr[i]).text(arr[i]));
				}
			}
		}
	});
});
</script>

<!--修改護字號及住民類型作業-->
<script>
$(function() {
    $( "#changeinfoform" ).dialog({
		autoOpen: false,
		height: 360,
		width: 600,
		modal: true,
		buttons: {
			"Information Modification": function() {
				$.ajax({
					url: "class/changepInfo.php",
					type: "POST",
					data: {"PID": $(this).data('patientID'), "HospNoDisplay": $("#cQHospNoDisplay").val(), "type1": $("#cQtype_1").val(), "type2": $("#cQtype_2").val(), "type3": $("#cQtype_3").val(), "type4": $("#cQtype_4").val(), "type5": $("#cQtype_5").val(), "Qfiller": '<?php echo $_SESSION['ncareID_lwj']; ?>'},
					success: function(data) {
						if (data=="EXISTED") {
							alert("護字號已存在，請選擇其他號碼！");
							$('#cQHospNoDisplay').val('');
						} else if (data=="OK") {
							$( "#changeinfoform" ).dialog( "close" );
							alert("Modify success!");
							window.location.reload();
						}
					}
				});
			},
			"Cancel": function() {
				$( "#changeinfoform" ).dialog( "close" );
			}
		}
	});
});
</script>
<div id="changeinfoform" title="Modify resident profile information"> 
  <form>
  <fieldset>
    <table>
      <tr>
        <td class="title" width="100">New care ID#</td>
        <td><input type="text" name="cQHospNoDisplay" id="cQHospNoDisplay" value="" size="12"></td>
      </tr>
      <tr>
        <td class="title" width="100">Resident type</td>
        <td><?php echo draw_option("cQtype","General admission;Swing bed;Respite care;Public funded care;Urgent care","xl","single",NULL,true,3); ?></td>
      </tr>
    </table>
  </fieldset>
  </form>
</div>

<!--床位對調-->
<script>
$(function() {
    $( "#switchbedform" ).dialog({
		autoOpen: false,
		height: 360,
		width: 600,
		modal: true,
		buttons: {
			"Confirm swapping": function() {
				//if (checkBed($('#NewBed').val())) {
					$.ajax({
						url: "class/switchbedform.php",
						type: "POST",
						data: {"HospNo": $(this).data('patientID'), "NewBed": $('#BedSwitch').val(), "BedArea": $('#BedAreaSwitch').val() },
						success: function(data) {
							//alert(data);
							if (data=="OK") {
								$( "#switchbedform" ).dialog( "close" );
								alert("Bed swap completed");
								window.location.reload();
							}
						}
					});
				//}
			},
			"Cancel": function() {
				$( "#switchbedform" ).dialog( "close" );
			}
		}
	});
});
</script>
<div id="switchbedform" title="Swap bed procedure"> 
  <form>
  <fieldset>
  <?php
  $db = new DB;
  $db->query("SELECT `bed` FROM `inpatientinfo` WHERE `patientID`!='' AND `patientID`!='0'");
  ?>
    <table>
      <tr>
        <td>Select section/room</td>
        <td>
        <select id="BedAreaSwitch">
          <option></option>
          <?php
		  $db_area = new DB;
		  $db_area->query("SELECT * FROM `areainfo` ORDER BY `areaID` ASC");
		  for ($i=0;$i<$db_area->num_rows();$i++) {
			  $r_area = $db_area->fetch_assoc();
			  echo '<option value="'.$r_area['areaID'].'">'.$r_area['areaName'].'</option>'."\n";
		  }
		  ?>
        </select>
        </td>
      </tr>
      <tr>
        <td class="title" width="140"><?php if ($db->num_rows()>0) { echo 'Select the bed to switch with';	 } ?></td>
        <td>
          <select name="BedSwitch" id="BedSwitch">
          <option></option>
          </select>
        </td>
      </tr>
    </table>
  </fieldset>
  </form>
</div>
<script>
$('#BedAreaSwitch').change(function () {
	$.ajax({
		url: "class/checkOccupiedBed.php",
		type: "POST",
		data: { "Area": $("#BedAreaSwitch").val()},
		success: function(data) {
			if (data=="nobed") {
				$("#BedSwitch option").remove();
				$("#BedSwitch").append($("<option></option>").attr("value", "").text("No empty bed"));
				$("#BedSwitch").attr("disabled",true);
			} else {
				var arr = data.split(';');
				$("#BedSwitch").attr("disabled",false);
				$("#BedSwitch option").remove();
				$("#BedSwitch").append($("<option></option>"));
				for (var i=0; i<arr.length; i++) {
					var arr1 = arr[i].split(':'); //arr1[0] = BedID; arr1[1] = display option text
					$("#BedSwitch").append($("<option></option>").attr("value", arr1[0]).text(arr1[1]));
				}
			}
		}
	});
});
</script>