<h3>每日機構住民人數</h3>
<script>
$(function() {
  $( "#dialog-form1" ).dialog({
      autoOpen: false,
      height: 600,
      width: 600,
      modal: true,
      buttons: {
          "Add record": function() {
			  $.ajax({
				  url: "class/saveTargetPatNo.php",
				  type: "POST",
				  data: {'date': $('#date').val(), 'newpat': $('#newpat').val(), 'no': $('#no').val(), 'outpat': $('#outpat').val(), 'foleypat': $('#foleypat').val(), 'nofoleypat': $('#nofoleypat').val(), 'hosppat': $('#hosppat').val(), 'backpat': $('#backpat').val(), 'deadpat': $('#deadpat').val(), 'Qfiller': '<?php echo $_SESSION['ncareID_lwj']; ?>' },
				  success: function(data) {
					  if (data=="EXISTED") {
						  alert("日期已有資料，請使用編輯功能修改資料！");
					  } else {
						  $( "#dialog-form1" ).dialog( "close" );
						  alert("Add record sucessfully!");
						  window.location.reload();
					  }
				  }
			  });
          },
          "Cancel": function() {
              $( "#dialog-form1" ).dialog( "close" );
          }
      }
  });
});
function refreshNo(date) {
	$.ajax({
		url: "class/getTargetPatNo.php",
		type: "POST",
		data: {'date': date },
		success: function(data) {
			var arr = data.split(':');
			//0 = 輸入日期
			//1 = 新入住人數
			//2 = 總人數
			//3 = 退住人數
			//4 = On Foley人數
			//5 = 轉住院人數
			//6 = 住院返回機構人數
			//7 = 死亡人數
			$('#newpat').val(arr[1]);
			$('#no').val(arr[2]);
			$('#outpat').val(arr[3]);
			$('#foleypat').val(arr[4]);
			$('#nofoleypat').val(arr[2]-arr[4]);
			$('#hosppat').val(arr[5]);
			$('#backpat').val(arr[6]);
			$('#deadpat').val(arr[7]);
			
			$('#oldnewpat').val(arr[1]);
			$('#oldno').val(arr[2]);
			$('#oldoutpat').val(arr[3]);
			$('#oldfoleypat').val(arr[4]);
			$('#oldnofoleypat').val(arr[2]-arr[4]);
			$('#oldhosppat').val(arr[5]);
			$('#oldbackpat').val(arr[6]);
			$('#olddeadpat').val(arr[7]);
		}
	});
}
$(function() {
	$('#form1').validationEngine();
	$('#date').change(function() {
		refreshNo($('#date').val());
	});
	$( "#dialog-form2" ).dialog({
      autoOpen: false,
      height: 600,
      width: 600,
      modal: true,
      buttons: {
          "Edit record": function() {
			  $.ajax({
				  url: "class/editTargetPatNo.php",
				  type: "POST",
				  data: {'editDate': $('#editDate').val(), 'editNewpat': $('#editNewpat').val(), 'editNo': $('#editNo').val(), 'editOutpat': $('#editOutpat').val(), 'editFoleypat': $('#editFoleypat').val(), 'editNoFoleypat': $('#editNoFoleypat').val(), 'editHosppat': $('#editHosppat').val(), 'editBackpat': $('#editBackpat').val(), 'editDeadpat': $('#editDeadpat').val(), 'Qfiller': $('#newQfiller').val() },
				  success: function(data) {
					  $( "#dialog-form2" ).dialog( "close" );
					  alert("已經成功編輯紀錄！");
					  window.location.reload();
					  //console.log(data);
				  }
			  });
          },
          "Cancel": function() {
              $( "#dialog-form2" ).dialog( "close" );
          }
      }
  });
});
function datefunction(functioname) {
	var date1 = (document.getElementById('printdate1').value).replace("/","-"); date1 = date1.replace("/","-");
	var date2 = (document.getElementById('printdate2').value).replace("/","-"); date2 = date2.replace("/","-");
	if (functioname=='print') {
		window.open('print.php?mod=management&func=formview&id=3a&date1='+date1+'&date2='+date2);
	} else if (functioname=='view') {
		window.location.href='index.php?mod=management&func=formview&id=3a&date1='+date1+'&date2='+date2;
	}
}
</script>
<div>
<button type="button" id="newrecord1" class="btnAddNewRecord" title="新增每日機構住民人數資料" onclick="openVerificationForm('#dialog-form1');" style="float:left;"><i class="fa fa-plus fa-2x fa-fw"></i><br>Add new data</button>
<div style="float:right; padding-top:5px;"><form>Select date:<script> $(function() { $( "#printdate1").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="printdate1" id="printdate1" value="<?php if (@$_GET['date1']==NULL) { echo date(Y."/".m."/01"); } else { echo (@$_GET['date1']); } ?>" size="12"> ~ <script> $(function() { $( "#printdate2").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="printdate2" id="printdate2" value="<?php if (@$_GET['date2']==NULL) { echo date(Y."/".m."/01"); } else { echo (@$_GET['date2']); } ?>" size="12"> <input type="button" value="Search" onclick="datefunction('view');" /><!--<input type="button" value="Print" onclick="datefunction('print');" />--></form></div>
</div>
<table style="width:100%;" id="pNoTable">
  <thead>
  <tr>
    <th></th>
    <th>Date</th>
    <th>New admission</th>
    <th>Discharge</th>
    <th>Use catheter</th>
    <th>No use of catheter</th>
    <th>Turn hospitalized</th>
    <th>Return from hospitalization </th>
    <th>Death</th>
    <th>Number of residents</th>
    <th>Filled by</th>
  </tr>
  </thead>
<?php
if ($_GET['date1']==NULL && $_GET['date2']==NULL) {
	$sql = "SELECT * FROM `dailypatientno` ORDER BY `date` DESC";
} else {
	$sql = "SELECT * FROM `dailypatientno` WHERE `date` BETWEEN '".mysql_escape_string($_GET['date1'])."' AND '".mysql_escape_string($_GET['date2'])."' ORDER BY `date` DESC";
}
$db0 = new DB;
$db0->query($sql);
for ($i0=0;$i0<$db0->num_rows();$i0++) {
	$r0 = $db0->fetch_assoc();
	echo '
  <tr>
    <td><input type="image" src="Images/edit_icon.png" width="24" id="edit_'.$r0['date'].'"></td>
    <td>'.$r0['date'].'</td>
    <td>'.$r0['newpat'].'</td>
    <td>'.$r0['outpat'].'</td>
    <td>'.(str_replace('-','',$r0['date'])<'20150401' && $r0['foleypat']==0?"---":$r0['foleypat']).'</td>
    <td>'.(str_replace('-','',$r0['date'])<'20150401' && $r0['nofoleypat']==0?"---":$r0['nofoleypat']).'</td>
    <td>'.(str_replace('-','',$r0['date'])<'20150401' && $r0['hosppat']==0?"---":$r0['hosppat']).'</td>
    <td>'.(str_replace('-','',$r0['date'])<'20150401' && $r0['backpat']==0?"---":$r0['backpat']).'</td>
    <td>'.(str_replace('-','',$r0['date'])<'20150401' && $r0['deadpat']==0?"---":$r0['deadpat']).'</td>
    <td>'.$r0['no'].'</td>
    <td>'.checkusername($r0['Qfiller']).'</td>
  </tr>
	'."\n";
}
?>
</table>
</div>
<script>
$('input[id^="edit_"]').click(function() {
	var id = $(this).attr('id');
	var arr = id.split('_');
	var date = arr[1];
	$.ajax({
		url: "class/getPatNo.php",
		type: "POST",
		data: {'date': date},
		success: function(data) {
			var arrVar = data.split(":");
			$("#editDate").val(date);
			$("#editNewpat").val(arrVar[0]);
			$("#editOutpat").val(arrVar[1]);
			$("#editFoleypat").val(arrVar[2]);
			$("#editNoFoleypat").val(arrVar[3]);
			$("#editHosppat").val(arrVar[4]);
			$("#editBackpat").val(arrVar[5]);
			$("#editDeadpat").val(arrVar[6]);
			$("#editNo").val(arrVar[7]);
			
			$("#oldeditNewpat").val(arrVar[0]);
			$("#oldeditOutpat").val(arrVar[1]);
			$("#oldeditFoleypat").val(arrVar[2]);
			$("#oldeditNoFoleypat").val(arrVar[3]);
			$("#oldeditHosppat").val(arrVar[4]);
			$("#oldeditBackpat").val(arrVar[5]);
			$("#oldeditDeadpat").val(arrVar[6]);
			$("#oldeditNo").val(arrVar[7]);
			
			$("#newQfiller").val(arrVar[8]);
		}
	});
	$( "#dialog-form2" ).dialog( "open" );
});
$(function() {
	$('#pNoTable').dataTable({
		"order": [[1,"desc"]],
		pageLength: 10	
	});
});
</script>
<div id="dialog-form1" title="新增每日機構住民人數資料" class="dialog-form"> 
<form id="form1">
<fieldset>
  <table>
    <tr>
      <td class="title">Date</td>
      <td><input type="date" name="date" id="date" value="" class="validate[required,custom[date]]"> <input type="button" onclick="$('#date').val('<?php echo date('Y-m-d'); ?>'); refreshNo($('#date').val());" value="今天"></td>
    </tr>
    <!--<tr>
      <td></td>
      <td><input type="button" value="自動計算人數" onclick="refreshNo($('#date').val());"/></td>
    </tr>-->
    <tr>
      <td class="title">New admission</td>
      <td><input type="text" name="newpat" id="newpat" value="" onkeyup="calcTotalNo(this.id);"><br>(包含新住民及請假返院住民)</td>
    </tr>
    <tr>
      <td class="title">退住人數</td>
      <td><input type="text" name="outpat" id="outpat" value="" onkeyup="calcTotalNo(this.id);"></td>
    </tr>
    <tr>
      <td class="title">使用尿管人數</td>
      <td><input type="text" name="foleypat" id="foleypat" value="" onkeyup="calcTotalNo(this.id);"></td>
    </tr>
    <tr>
      <td class="title">未使用尿管人數</td>
      <td><input type="text" name="nofoleypat" id="nofoleypat" value="" onkeyup="calcTotalNo(this.id);"></td>
    </tr>
    <tr>
      <td class="title">轉住院人數</td>
      <td><input type="text" name="hosppat" id="hosppat" value="" onkeyup="calcTotalNo(this.id);"></td>
    </tr>
    <tr>
      <td class="title">住院返回機構人數</td>
      <td><input type="text" name="backpat" id="backpat" value="" onkeyup="calcTotalNo(this.id);"></td>
    </tr>
    <tr>
      <td class="title">Number of death</td>
      <td><input type="text" name="deadpat" id="deadpat" value="" onkeyup="calcTotalNo(this.id);"></td>
    </tr>
    <tr>
      <td class="title">目前在機構人數</td>
      <td><input type="text" name="no" id="no" value="" onkeyup="calcTotalNo(this.id);"><br>(包含新入住人數)</td>
    </tr>
    <input type="hidden" name="Qfiller" id="Qfiller" value="<?php echo $_SESSION['ncareID_lwj']; ?>">
    <input type="hidden" name="oldno" id="oldno">
    <input type="hidden" name="oldnewpat" id="oldnewpat">
    <input type="hidden" name="oldoutpat" id="oldoutpat">
    <input type="hidden" name="oldfoleypat" id="oldfoleypat">
    <input type="hidden" name="oldnofoleypat" id="oldnofoleypat">
    <input type="hidden" name="oldhosppat" id="oldhosppat">
    <input type="hidden" name="oldbackpat" id="oldbackpat">
    <input type="hidden" name="olddeadpat" id="olddeadpat">
  </table>
</fieldset>
</form>
</div>
<script>
function calcTotalNo(type) {
	/*switch (type) {
		case 'newpat':
			var newpatC = $('#newpat').val() - $('#oldnewpat').val();
			$('#oldnewpat').val($('#newpat').val());
			$('#nofoleypat').val(parseInt($('#nofoleypat').val()) + parseInt(newpatC));
			$('#oldnofoleypat').val($('#nofoleypat').val());
			$('#no').val(parseInt($('#oldno').val()) + parseInt(newpatC));
			$('#oldno').val($('#no').val());
			break;
		case 'outpat':
			var outpatC = $('#outpat').val() - $('#oldoutpat').val();
			$('#oldoutpat').val($('#outpat').val());
			$('#nofoleypat').val(parseInt($('#nofoleypat').val()) - parseInt(outpatC));
			$('#oldnofoleypat').val($('#nofoleypat').val());
			$('#no').val(parseInt($('#oldno').val()) - parseInt(outpatC));
			$('#oldno').val($('#no').val());
			break;
		case 'foleypat':
			$('#nofoleypat').val(parseInt($('#oldno').val()) - parseInt($('#foleypat').val()));
			$('#oldnofoleypat').val($('#nofoleypat').val());
			break;
		case 'nofoleypat':
			$('#foleypat').val(parseInt($('#oldno').val()) - parseInt($('#nofoleypat').val()));
			$('#oldfoleypat').val($('#foleypat').val());
			break;
	}*/
}
function calcTotalEditNo(type) {
	/*switch (type) {
		case 'editNewpat':
			var newpatC = $('#editNewpat').val() - $('#oldeditNewpat').val();
			$('#oldeditNewpat').val($('#editNewpat').val());
			$('#editNoFoleypat').val(parseInt($('#editNoFoleypat').val()) + parseInt(newpatC));
			$('#oldeditNoFoleypat').val($('#editNoFoleypat').val());
			$('#editNo').val(parseInt($('#oldeditNo').val()) + parseInt(newpatC));
			$('#oldeditNo').val($('#editNo').val());
			break;
		case 'editOutpat':
			var outpatC = $('#editOutpat').val() - $('#oldeditOutpat').val();
			$('#oldeditOutpat').val($('#editOutpat').val());
			$('#editNoFoleypat').val(parseInt($('#editNoFoleypat').val()) - parseInt(outpatC));
			$('#oldeditNoFoleypat').val($('#editNoFoleypat').val());
			$('#editNo').val(parseInt($('#oldeditNo').val()) - parseInt(outpatC));
			$('#oldeditNo').val($('#editNo').val());
			break;
		case 'editFoleypat':
			$('#editNoFoleypat').val(parseInt($('#oldeditNo').val()) - parseInt($('#editFoleypat').val()));
			$('#oldeditNoFoleypat').val($('#editNoFoleypat').val());
			break;
		case 'editNoFoleypat':
			$('#editFoleypat').val(parseInt($('#oldeditNo').val()) - parseInt($('#editNoFoleypat').val()));
			$('#oldeditFoleypat').val($('#editFoleypat').val());
			break;
	}*/
}
</script>
<div id="dialog-form2" title="編輯每日機構住民人數資料" class="dialog-form"> 
<form id="form2">
<fieldset>
  <table>
    <tr>
      <td class="title">Date</td>
      <td><input type="text" name="editDate" id="editDate" value="" readonly></td>
    </tr>
    <tr>
      <td class="title">New admission</td>
      <td><input type="text" name="editNewpat" id="editNewpat" value="" onkeyup="calcTotalEditNo(this.id);"><br>(包含新住民及請假返院住民)</td>
    </tr>
    <tr>
      <td class="title">退住人數</td>
      <td><input type="text" name="editOutpat" id="editOutpat" value="" onkeyup="calcTotalEditNo(this.id);"></td>
    </tr>
    <tr>
      <td class="title">使用尿管人數</td>
      <td><input type="text" name="editFoleypat" id="editFoleypat" value="" onkeyup="calcTotalEditNo(this.id);"></td>
    </tr>
    <tr>
      <td class="title">未使用尿管人數</td>
      <td><input type="text" name="editNoFoleypat" id="editNoFoleypat" value="" onkeyup="calcTotalEditNo(this.id);"></td>
    </tr>
    <tr>
      <td class="title">轉住院人數</td>
      <td><input type="text" name="editHosppat" id="editHosppat" value="" onkeyup="calcTotalEditNo(this.id);"></td>
    </tr>
    <tr>
      <td class="title">住院返回機構人數</td>
      <td><input type="text" name="editBackpat" id="editBackpat" value="" onkeyup="calcTotalEditNo(this.id);"></td>
    </tr>
    <tr>
      <td class="title">Number of death</td>
      <td><input type="text" name="editDeadpat" id="editDeadpat" value="" onkeyup="calcTotalEditNo(this.id);"></td>
    </tr>
    <tr>
      <td class="title">目前在機構人數</td>
      <td><input type="text" name="editNo" id="editNo" value="" onkeyup="calcTotalEditNo(this.id);"><br>(包含新入住人數)</td>
    </tr>
    <input type="hidden" name="newQfiller" id="newQfiller" value="<?php echo $_SESSION['ncareID_lwj']; ?>">
  </table>
  <input type="hidden" name="oldeditNo" id="oldeditNo">
  <input type="hidden" name="oldeditNewpat" id="oldeditNewpat">
  <input type="hidden" name="oldeditOutpat" id="oldeditOutpat">
  <input type="hidden" name="oldeditFoleypat" id="oldeditFoleypat">
  <input type="hidden" name="oldeditNoFoleypat" id="oldeditNoFoleypat">
  <input type="hidden" name="oldeditHosppat" id="oldeditHosppat">
  <input type="hidden" name="oldeditBackpat" id="oldeditBackpat">
  <input type="hidden" name="oldeditDeadpat" id="oldeditDeadpat">
</fieldset>
</form>