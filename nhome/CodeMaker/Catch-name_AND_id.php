<script>
$(function() {
	var id_and_name ="";
	var name ="";
	var diff_id_and_name ="";
	var array_id = new Array("patient_Name1","patient_Name2","patient_Name3","patient_Name4","patient_Nickname","patient_Gender_1","patient_Gender_2","patient_Race","patient_IdNo","patient_Birth","patient_Birthplace","Qmemo_1","Qmemo_2","Qmemo_3","patient_height","Qcomingsource","inpatientinfo_indate","patient_MedicalRecordNumber","patient_MedicaidNumber","patient_QMedicaidStatus_1","patient_QMedicaidStatus_2","patient_MedicareNumber","patient_QMedicareCovered_1","patient_QMedicareCovered_2","patient_MedicareStartDate","patient_MedicareEndDate","patient_Postcode","patient_Address","patient_Address2","patient_Address3","patient_Address4","patient_Address5","Qdiag1","Qdiag5","Qdiag2","Qdiag6","Qdiag3","Qdiag7","Qdiag4","Qdiag8","Qdisable_1","Qdisable_2","QdisableTypeA","QdisableTypeB_1","QdisableTypeB_6","QdisableTypeB_2","QdisableTypeB_7","QdisableTypeB_3","QdisableTypeB_8","QdisableTypeB_4","QdisableTypeB_9","QdisableTypeB_5","QdisableLevel","Qdisableexpiry","QillnessCard_1","QillnessCard_2","QillnessName","QillnessType_1","QillnessType_2","QillnessType_3","QillnessType_4","QillnessType_5","QillnessTypeOther","QillnessTypeB_1","QillnessTypeB_2","QillnessTypeB_3","QillnessTypeBOther","QassignHosp","QemgHosp_1","QemgHosp_2","QemgHosp_3","QemgHosp_4","QemgHosp_5","QemgHosp_6","QemgHosp_7","QemgHosp_8","QemgHosp_9","QemgHosp_10","QemgHospOther","Qlang_1","Qlang_2","Qlang_3","Qlang_4","Qlang_5","Qlang_6","QlangOther","Qexpress_1","Qexpress_2","Qexpress_3","QContactPerson1Name","QContactPerson1Birth","QContactPerson1Relate","QContactPerson1Company","QContactPerson1Position","QContactPerson1Tel1","QContactPerson1Tel2","QContactPerson1Tel3","QContactPerson1Address","Qreceipt_1","Qreceipt_2","QContactPerson1Email","Qebill_1","QContactPerson2Name","QContactPerson2Birth","QContactPerson2Relate","QContactPerson2Company","QContactPerson2Position","QContactPerson2Tel1","QContactPerson2Tel2","QContactPerson2Tel3","QContactPerson2Address","QContactPerson2Email","QContactPerson3Name","QContactPerson3Birth","QContactPerson3Relate","QContactPerson3Company","QContactPerson3Position","QContactPerson3Tel1","QContactPerson3Tel2","QContactPerson3Tel3","QContactPerson3Address","QContactPerson3Email","QContactPerson4Name","QContactPerson4Birth","QContactPerson4Relate","QContactPerson4Company","QContactPerson4Position","QContactPerson4Tel1","QContactPerson4Tel2","QContactPerson4Tel3","QContactPerson4Address","QContactPerson4Email","date","formID","HospNo");
	for(var i=0;i<array_id.length;i++){
		name = document.getElementById(array_id[i]).name;
		if(name!=array_id[i]){
			diff_id_and_name += array_id[i]+" == "+name+"<br>";
		}
		id_and_name += array_id[i]+" == "+name+"<br>";
	}
	//alert(id_and_name);
	//alert(diff_id_and_name);
	//document.getElementById('id_and_name').value = id_and_name;
	//document.getElementById('diff_id_and_name').value = diff_id_and_name;
	document.getElementById('id_and_name').innerHTML = id_and_name;
	document.getElementById('diff_id_and_name').innerHTML = diff_id_and_name;
});
</script>
<!--<textarea id="id_and_name"></textarea>-->
<!--<textarea id="diff_id_and_name"></textarea>-->
<div id="id_and_name"></div>
<div id="diff_id_and_name" style="font-weight:bolder; color:red;"></div>