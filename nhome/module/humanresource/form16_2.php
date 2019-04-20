<div class="moduleNoTab">
<h3 style="margin-top:0px;">Absent form review</h3>
<div class="content-table">
<table id="table16">
<thead>
<tr class="title">
  <th>Approval Status</th>
  <th>Date of requisition</th>
  <th>Full name</th>
  <th>Off date</th>
  <th>Absent category</th>
  <th>Day(s)</th>
  <th>Function</th>
</tr>
</thead>
<?php
$arrstatus = array("Pending","Reviewing","Approved","Canceled");
$sql1 = "SELECT * FROM `humanresource16`";
$db = new DB;
$db->query($sql1);
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	foreach ($r as $k=>$v) {
		$arrPatientInfo = explode("_",$k);
		if (count($arrPatientInfo)==2) {
			if ($v==1) {
				${$arrPatientInfo[0]} = $arrPatientInfo[1];
			}
		} else {
			${$k} = $v;
		}
	}
	
	echo '
<tr>
  <td align="center" id="4_'.$r['workID'].'"><font color="'.($status=="0" || $status=="1"?"red":"green").'">'.$arrstatus[$status].'</font></td>
  <td align="center">'.$date.'</td>
  <td>'.getEmployerName($EmpID).'</td>
  <td>'.$Q3.'～'.$Q4.'</td>
  <td align="center">'.option_result("Q5","Regular vacation;Chrismas/new year vacation;Casual leave;Sick leave;Official leave;Other","s","single",$Q5,false,5).$Q5a.'</td>
  <td align="center">'.$Q5b.'</td>
  <td class="link1" align="center">
  <a href="javascript:void(0);" title="Set to reviewing" id="1_'.$r['workID'].'"><i class="fa fa-external-link fa-lg"></i></a>&nbsp;&nbsp;
  <a href="javascript:void(0);" title="Set to approved" id="2_'.$r['workID'].'"><i class="fa fa-check-square-o fa-lg"></i></a>&nbsp;&nbsp;
  <a href="javascript:void(0);" title="Set to canceled" id="3_'.$r['workID'].'"><i class="fa fa-times fa-lg"></i></a>
  </td>
</tr>'."\n";
}
?>
</table>
</div>
</div>
<script>
$(function(){
	$('#table16').dataTable({
		"autoWidth": true,
		"order": [[1, "desc"]],
		"pageLength": 20
	});
	for(var i=1;i<=3;i++){
	  $("a[id^='"+i+"_']").click(function(){
		  var id = this.id.split('_');
		  //id[1] = ApplyItemID
		  $.ajax({
			  url: "class/edit.php",
			  type: "POST",
			  data: {"formID": 'humanresource16', "status":id[0], "colID":'workID', "autoID": id[1]},
			  success: function(data) {
				  var status="";
				  if(id[0]==1){
					  status="Reviewing";
					  color="red";
				  }else if(id[0]==2){
					  status="Approved";
					  color="green";
				  }else if(id[0]==3){
					  status="Canceled";
					  color="green";
				  }
				  $("#4_"+id[1]).html("<font color='"+color+"'>"+status+"</font>");
			  }
		  });
	  });
	}
	
});
</script>