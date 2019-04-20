<script>
function ReaderCount(){

      var NHICardReader = document.getElementById('NHICardReader');
      var ReaderSelect = document.getElementById('reader_select');
    	ReaderSelect.options.length = 0;
    	var firstIndex = null;
	
   for (var i=0; i<NHICardReader.ReaderCount; i++)
    {
	NHICardReader.ReaderIndex = i;
        var ReaderItem = new Option(NHICardReader.ReaderName, i);
	ReaderSelect.options.add(ReaderItem);
	
	if (firstIndex == null && NHICardReader.CardPresent && NHICardReader.Read())
	{
  	firstIndex = i;
    ReaderSelect.value= firstIndex;
    ExecRead(firstIndex);
  }
    	
 }

}

function ExecRead(SelIndex)
{
	var NHICardReader = document.getElementById('NHICardReader');
  var ReaderSelect = document.getElementById('reader_select');
	
	if (SelIndex == null && ReaderSelect.value != null && ReaderSelect.value >= 0){
	NHICardReader.ReaderIndex = ReaderSelect.value;
	}else if(SelIndex != null){
	NHICardReader.ReaderIndex = SelIndex;
	}else{
	return;
	}	
    
    NHICardReader.Refresh();

    var iscard = false;
    var Msg = '';
    if (NHICardReader.CardPresent && NHICardReader.Read()){	
		iscard = true;
		Msg = '使用using ' + NHICardReader.NHI_HolderName + (NHICardReader.NHI_Sex == 'M' ? '先生Mr.':'小姐Ms') + ' 的全民健康保險IC卡登入 insurace IC card to log in';
    } else if(NHICardReader.CardPresent && !NHICardReader.Read()){
    iscard = false;
		Msg = '您可能插入了錯誤的卡，或將卡片插反了。you might insert the wrong card or wrong side of the card';
	  }
    
    //document.getElementById('nhi_cardno').value = (iscard)?NHICardReader.NHI_CardNo:'';
	document.getElementById('nhi_holdername').value = (iscard)?NHICardReader.NHI_HolderName:'';
	document.getElementById('IdentityCardNumber').value = (iscard)?NHICardReader.NHI_IDNO:'';
	
	var months = {'Jan':'01', 'Feb':'02', 'Mar':'03', 'Apr':'04', 'May':'05', 'Jun':'06',
	              'Jul':'07', 'Aug':'08', 'Sep':'09', 'Oct':'10', 'Nov':'11', 'Dec':'12' };
	document.getElementById('nhi_birthdate').value = (iscard)?NHICardReader.NHI_BirthDate:'';
	var birth = document.getElementById('nhi_birthdate').value;
	var birthyear = birth.substr(29,4);
	var birthmonth = months[birth.substr(4,3)].toString();
	var birthday = birth.substr(8,2);
	document.getElementById('BirthInput').value = birthyear+'/'+birthmonth+'/'+birthday;
	
	document.getElementById('nhi_sex').value = (iscard)?NHICardReader.NHI_Sex:'';
	var Sex = document.getElementById('nhi_sex').value;
	if (Sex=="M") {
		document.getElementById('Sex_1').value="1";
		document.getElementById('Sex_2').value="0";
		document.getElementById('btn_Sex_1').className = "tabbtn_m_left_on";
		document.getElementById('btn_Sex_2').className = "tabbtn_m_right_off";
	} else {
		document.getElementById('Sex_1').value="0";
		document.getElementById('Sex_2').value="1";
		document.getElementById('btn_Sex_1').className = "tabbtn_m_left_off";
		document.getElementById('btn_Sex_2').className = "tabbtn_m_right_on";
	}
	
	//document.getElementById('nhi_issuedate').value = (iscard)?NHICardReader.NHI_IssueDate:'';
    
    //if(Msg != '') alert(Msg);
	
	document.getElementById('searchID').disabled = false;
	document.getElementById('newaccount').disabled = false;
}
$(function() {
	$('#base').validationEngine();
	$('#getHospNo').button().click( function() {
		$.ajax({
			url: "class/getNewHospNo.php",
			type: "POST",
			data: {HospNo: $( "#HospNoDisplay" ).val()},
			success: function(data) {
				$( "#HospNoDisplay" ).val( data );
			}
		});
	});
});
</script>
<div class="formNoSelDate" align="center">
	<h3>Add new resident</h3>
	<div class="nurseform-table">
<form id="base" action="index.php?func=addpatient" method="post">
<table cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" valign="top">
    <table style="width:100%;">
      <!--<tr>
        <td class="title" rowspan="2">選擇讀卡機select card reader</td>
        <td><img src="Images/newcaseicon/account_btn5.png"> <font color="#5C1986">請插入健保卡以利讀取基本資訊please insert the insurance ID card to acquire info</font></td>
      </tr>
      <tr>
        <td><div id="reader_select_block" style="display:none;">選擇讀卡機select card reader : <select id="reader_select" onChange="ExecRead(this.value);"></select></div> <input onClick="ExecRead(reader_select.value);" value="讀取卡片" type="button"></td>
      </tr>-->
      <tr>
        <td class="title" rowspan="2">Name</td>
        <td class="title">First name</td>
		<td class="title">Middle initial</td>
		<td class="title">Last name</td>
		<td class="title">Suffix</td>
      </tr>
      <tr>
        <td align="center"><input type="text" name="Name1" id="nhi_holdername" value="" /></td>
		<td align="center"><input type="text" name="Name2" id="nhi_holdername" value="" /></td>
		<td align="center"><input type="text" name="Name3" id="nhi_holdername" value="" /></td>
		<td align="center"><input type="text" name="Name4" id="nhi_holdername" value="" /></td>
      </tr>
      <tr>
        <td class="title">SSN</td>
        <td colspan="4"><input type="text" name="IdentityCardNumber" id="IdentityCardNumber" value=""  /></td>
      </tr>
      <tr>
        <td class="title">Birth date</td>
        <td colspan="4"><input type="text" placeholder="yyyy/mm/dd" name="BirthInput" id="BirthInput" value="" /> (input format：<?php echo date('Y/m/d'); ?>)<input type="hidden" id="nhi_birthdate" value="" /></td>
      </tr>
      <tr>
        <td class="title">Race/Ethnicity</td>
        <td colspan="4">
          <select id="Race" name="Race">
   	        <option></option>
	        <option value="A">American Indian or Alaska Native</option>
	        <option value="B">Asian</option>
	        <option value="C">Black or African American</option>
	        <option value="D">Hispanic or Latino</option>
	        <option value="E">Native Hawaiian or Other Pacific Islander</option>
	        <option value="F">White</option>
	      </select>
		</td>
      </tr>
      <tr>
        <td class="title">Gender</td>
        <td colspan="4"><?php echo draw_option("Sex","Male;Female","m","single","",false,5); ?><input type="hidden" id="nhi_sex" value="" /></td>
      </tr>
      <tr>
        <td class="title">Medical record number</td>
        <td colspan="4"><input type="text" name="MedicalRecordNumber" id="MedicalRecordNumber" value=""  /></td>
      </tr>
      <tr>
        <td class="title">Medicare number</td>
        <td colspan="4"><input type="text" name="MedicareNumber" id="MedicareNumber" value=""  /></td>
      </tr>
      <tr>
        <td class="title">Has the resident had a <br>Medicare-covered stay ?</td>
        <td colspan="4"><?php echo draw_option("QMedicareCovered","No;Yes","l","single","",false,2); ?></td>
      </tr>
      <tr>
        <td class="title">Start date of Medicare stay</td>
        <td colspan="4"><script> $(function() { $( "#MedicareStartDate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" size="18" name="MedicareStartDate" id="MedicareStartDate" value="<?php echo formatdate($MedicareStartDate);?>"></b></td>
      </tr>
      <tr>
        <td class="title">End date of Medicare stay</td>
        <td colspan="4"><script> $(function() { $( "#MedicareEndDate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" size="18" name="MedicareEndDate" id="MedicareEndDate" value="<?php echo formatdate($MedicareEndDate);?>"></b></td>
      </tr>
      <tr>
        <td class="title">Medicaid Number</td>
        <td colspan="4">
		  <input type="text" name="MedicaidNumber" id="MedicaidNumber" value=""  />
		  <?php echo draw_option("QMedicaidStatus","Pending;Not a Medicaid recipient","xxl","single","",false,2); ?>
		</td>
      </tr>
      <tr>
        <td class="title">Type</td>
        <td colspan="4"><?php echo draw_option("type","General admission;Swing bed;Respite care;Public funded care;Urgent care","xl","single","1",true,3); ?></td>
      </tr>
      <?php
	  $db2 = new DB2;
	  $db2->query("SELECT `HospNoLength` FROM `system_setting` WHERE `OrgID`='".$_SESSION['nOrgID_lwj']."'");
	  $r2 = $db2->fetch_assoc();
	  ?>
      <tr>
        <td class="title">Care ID #</td>
        <td colspan="4"><input type="text" name="HospNoDisplay" id="HospNoDisplay" onkeyup="checkRepeatHospNoDisplay(this.value);" class="validate[required<?php if ($r2['HospNoLength']>0) { echo ',maxSize['.$r2['HospNoLength'].']'; } ?>]" /> <input type="button" id="getHospNo" value="Auto-generate care ID#"> <span id="repeatedmsg" class="rangeH"></span></td>
      </tr>
      <tr>
        <td class="title">Area</td>
        <td colspan="4">
        <select name="Area" id="Area" class="validate[required]">
          <option></option>
          <?php
		  $db = new DB;
		  $db->query("SELECT * FROM `areainfo` ORDER BY `areaID` ASC");
		  for ($i=0;$i<$db->num_rows();$i++) {
			  $r = $db->fetch_assoc();
			  echo '<option value="'.$r['areaID'].'">'.$r['areaName'].'</option>'."\n";
		  }
		  ?>
        </select>
        </td>
      </tr>
      <tr>
        <td class="title">Bed number</td>
        <td colspan="4">
        <select name="bed" id="bed" disabled>
          <option>---First select Area---</option>
        </select>
		</td>
      </tr>
	</table>
	<table>
	  <tr>
        <td class="title">Name by which resident prefers to be addressed</td>
        <td colspan="4"><input type="text" name="Nickname" id="Nickname" value="" /></td>
      </tr>      
	  <tr>
        <td class="title">Does the resident need or want an interpreter to <br>communicate with a doctor or health care staff?</td>
        <td colspan="4"><?php echo draw_option("QInterpreter","No;Yes;Unable to determine","xl","single","",false,5); ?></td>
      </tr>
	  <tr>
        <td class="title">Preferred language</td>
        <td colspan="4"><input type="text" name="Language" id="Language" value="" /></td>
      </tr>
	</table>
	<table>
      <tr>
        <td colspan="5"><center><input type="submit" name="newpatient" id="newpatient" value="Add" style="display:none;"></center></td>
      </tr>
    </table>
    </td>
  </tr>
</table>
</form>
</div>
</div>
<script>
function checkRepeatHospNoDisplay(hndis) {
	$.ajax({
		url: "class/checkRepeatHospNoDisplay.php",
		type: "POST",
		data: {"HospNoDisplay": hndis, "Type_1": $('#type_1').val(), "Type_2": $('#type_2').val(), "Type_3": $('#type_3').val(), "Type_4": $('#type_4').val(), "Type_5": $('#type_5').val() },
		success: function(data) {
			if (data=="F") {
				$('#repeatedmsg').html('已有重覆之病歷號！');
				$('#HospNoDisplay').val('');
			} else if (data=="T") {
				$('#repeatedmsg').html('');
			} else if (data=="E") {
				$('#repeatedmsg').html('請先選擇院民類別！');
				$('#HospNoDisplay').val('');
			}
		}
	});
}
function checkRepeatBedID(bedID) {
	$.ajax({
		url: "class/checkRepeatBedID.php",
		type: "POST",
		data: {"bedID": bedID },
		success: function(data) {
			if (data=="F") {
				$('#repeatedbedmsg').html('床號已有住民進住！');
				$('#bed').val('');
			} else if (data=="T") {
				$('#repeatedbedmsg').html('');
			}
		}
	});
}
$('#Area').change(function () {
	$.ajax({
		url: "class/checkEmptyBed.php",
		type: "POST",
		data: { "Area": $("#Area").val()},
		success: function(data) {
			if (data=="nobed") {
				$("#bed option").remove();
				$("#bed").append($("<option></option>").attr("value", "").text("No empty bed"));
				$("#newpatient").hide();
				$("#bed").attr("disabled",true);
			} else {
				var arr = data.split(';');
				$("#bed").attr("disabled",false);
				$("#newpatient").show();
				$("#bed").addClass("validate[required]");
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