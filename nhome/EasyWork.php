<script>
$(function() {
	$('#btn_EasyWork_1').click(function() {
		$('#EasyWork-tab1').show();
		$('#EasyWork-tab2').hide();
		$('#EasyWork-tab3').hide();
		$('#EasyWork-tab4').hide();
		$('#EasyWork-tab5').hide();
		$('#EasyWork-tab6').hide();
		$('#EasyWork-tab7').hide();
		$('#EasyWork-tab8').hide();
		
	});
	$('#btn_EasyWork_2').click(function() {
		$('#EasyWork-tab1').hide();
		$('#EasyWork-tab2').show();
		$('#EasyWork-tab3').hide();
		$('#EasyWork-tab4').hide();
		$('#EasyWork-tab5').hide();
		$('#EasyWork-tab6').hide();
		$('#EasyWork-tab7').hide();
		$('#EasyWork-tab8').hide();
	});
	$('#btn_EasyWork_3').click(function() {
		$('#EasyWork-tab1').hide();
		$('#EasyWork-tab2').hide();
		$('#EasyWork-tab3').show();
		$('#EasyWork-tab4').hide();
		$('#EasyWork-tab5').hide();
		$('#EasyWork-tab6').hide();
		$('#EasyWork-tab7').hide();
		$('#EasyWork-tab8').hide();
	});
	$('#btn_EasyWork_4').click(function() {
		$('#EasyWork-tab1').hide();
		$('#EasyWork-tab2').hide();
		$('#EasyWork-tab3').hide();
		$('#EasyWork-tab4').show();
		$('#EasyWork-tab5').hide();
		$('#EasyWork-tab6').hide();
		$('#EasyWork-tab7').hide();
		$('#EasyWork-tab8').hide();
	});
	$('#btn_EasyWork_5').click(function() {
		$('#EasyWork-tab1').hide();
		$('#EasyWork-tab2').hide();
		$('#EasyWork-tab3').hide();
		$('#EasyWork-tab4').hide();
		$('#EasyWork-tab5').show();
		$('#EasyWork-tab6').hide();
		$('#EasyWork-tab7').hide();
		$('#EasyWork-tab8').hide();
	});
	$('#btn_EasyWork_6').click(function() {
		$('#EasyWork-tab1').hide();
		$('#EasyWork-tab2').hide();
		$('#EasyWork-tab3').hide();
		$('#EasyWork-tab4').hide();
		$('#EasyWork-tab5').hide();
		$('#EasyWork-tab6').show();
		$('#EasyWork-tab7').hide();
		$('#EasyWork-tab8').hide();
	});
	$('#btn_EasyWork_7').click(function() {
		$('#EasyWork-tab1').hide();
		$('#EasyWork-tab2').hide();
		$('#EasyWork-tab3').hide();
		$('#EasyWork-tab4').hide();
		$('#EasyWork-tab5').hide();
		$('#EasyWork-tab6').hide();
		$('#EasyWork-tab7').show();
		$('#EasyWork-tab8').hide();
	});
	$('#btn_EasyWork_8').click(function() {
		$('#EasyWork-tab1').hide();
		$('#EasyWork-tab2').hide();
		$('#EasyWork-tab3').hide();
		$('#EasyWork-tab4').hide();
		$('#EasyWork-tab5').hide();
		$('#EasyWork-tab6').hide();
		$('#EasyWork-tab7').hide();
		$('#EasyWork-tab8').show();
	});
});
</script>
<?php
$_SESSION['Easy_Medicine_Red_lwj']=0;
$_SESSION['Easy_Medicine_Orange_lwj']=0;
$_SESSION['Easy_Insulin_Red_lwj']=0;
$_SESSION['Easy_Insulin_Orange_lwj']=0;
$_SESSION['Easy_Pipeline_Red_lwj']=0;
$_SESSION['Easy_Pipeline_Orange_lwj']=0;
?>
<div style="width:100%;">
  <table width="100%">
    <tr>
      <td>
	    <div align="center">
	    <table>
		  <tr>
		    <td colspan="4" align="center">
			  <?php echo draw_option("EasyWork","Memo;Note;Diagnosis;Track;Vital;Medicine;Insulin;Pipeline","l","single",1,true,4); ?>
			</td>
		  </tr>
		  <tr>
		    <td style="width:25%;"></td>
			<td style="width:25%;">
			  <div style="width:100%;">
			    <div name="Medicine_Red_Point" id="Medicine_Red_Point" style="display:none; float:left; width:50%;">
			      <table style="width:100%;">
			        <tr>
			          <td style="width:20px; height:20px; border-radius:10px; background-color:red; color:white; font-size:14px; font-weight:bolder; text-align:center;">
			            <div name="Medicine_Red_Number" id="Medicine_Red_Number"></div>
			          </td>
			        </tr>
			      </table>
				</div>
			    <div name="Medicine_Orange_Point" id="Medicine_Orange_Point" style="display:none; float:left; width:50%;">
			      <table style="width:100%;">
			        <tr>
			          <td style="width:20px; height:20px; border-radius:10px; background-color:orange; color:white; font-size:14px; font-weight:bolder; text-align:center;">
			            <div name="Medicine_Orange_Number" id="Medicine_Orange_Number"></div>
			          </td>
			        </tr>
			      </table>
				</div>
			  </div>
			</td>
			<td style="width:25%;">
			  <div style="width:100%;">
			    <div name="Insulin_Red_Point" id="Insulin_Red_Point" style="display:none; float:left; width:50%;">
			      <table style="width:100%;">
			        <tr>
			          <td style="width:20px; height:20px; border-radius:10px; background-color:red; color:white; font-size:14px; font-weight:bolder; text-align:center;">
			            <div name="Insulin_Red_Number" id="Insulin_Red_Number"></div>
			          </td>
			        </tr>
			      </table>
				</div>
			    <div name="Insulin_Orange_Point" id="Insulin_Orange_Point" style="display:none; float:left; width:50%;">
			      <table style="width:100%;">
			        <tr>
			          <td style="width:20px; height:20px; border-radius:10px; background-color:orange; color:white; font-size:14px; font-weight:bolder; text-align:center;">
			            <div name="Insulin_Orange_Number" id="Insulin_Orange_Number"></div>
			          </td>
			        </tr>
			      </table>
				</div>
			  </div>
			</td>
			<td style="width:25%;">
			  <div style="width:100%;">
			    <div name="Pipeline_Red_Point" id="Pipeline_Red_Point" style="display:none; float:left; width:50%;">
			      <table style="width:100%;">
			        <tr>
			          <td style="width:20px; height:20px; border-radius:10px; background-color:red; color:white; font-size:14px; font-weight:bolder; text-align:center;">
			            <div name="Pipeline_Red_Number" id="Pipeline_Red_Number"></div>
			          </td>
			        </tr>
			      </table>
				</div>
			    <div name="Pipeline_Orange_Point" id="Pipeline_Orange_Point" style="display:none; float:left; width:50%;">
			      <table style="width:100%;">
			        <tr>
			          <td style="width:20px; height:20px; border-radius:10px; background-color:orange; color:white; font-size:14px; font-weight:bolder; text-align:center;">
			            <div name="Pipeline_Orange_Number" id="Pipeline_Orange_Number"></div>
			          </td>
			        </tr>
			      </table>
				</div>
			  </div>
			</td>
		  </tr>
		</table>
		</div>
      </td>
    </tr>
    <tr>
      <td valign="top" colspan="2">
        <div id="EasyWork-tab1" width="100%" align="center">
          <table width="95%" align="center">
            <tr>
			  <td><?php include('EasyWork_WorkMemoCheck.php'); ?></td>
            </tr>
          </table>
        </div>
        <div id="EasyWork-tab2" align="center" style="display:none;">
          <table>
            <tr>
			  <td><?php include('EasyWork_NursingHandover.php'); ?></td>
            </tr>
          </table>
        </div>
        <div id="EasyWork-tab3" width="100%" align="center" style="display:none;">
          <table width="95%;">
            <tr>
			  <td><?php include('EasyWork_NursingDiagnosis.php'); ?></td>
            </tr>
          </table>
        </div>
        <div id="EasyWork-tab4" width="100%" align="center" style="display:none;">
          <table>
            <tr>
			  <td><?php include('EasyWork_NursingRecord.php'); ?></td>
            </tr>
          </table>
        </div>
        <div id="EasyWork-tab5" align="center" style="display:none;">
          <table>
            <tr>
			  <td><?php include('EasyWork_VitalSign.php'); ?></td>
            </tr>
          </table>
        </div>
        <div id="EasyWork-tab6" align="center" style="display:none;">
          <table>
            <tr>
			  <td><?php include('EasyWork_Medicine.php'); ?></td>
            </tr>
          </table>
        </div>
        <div id="EasyWork-tab7" align="center" style="display:none;">
          <table>
            <tr>
			  <td><?php include('EasyWork_Insulin.php'); ?></td>
            </tr>
          </table>
        </div>
        <div id="EasyWork-tab8" align="center" style="display:none;">
          <table>
            <tr>
			  <td><?php include('EasyWork_Pipeline.php'); ?></td>
            </tr>
          </table>
        </div>
      </td>
    </tr>		
  </table>
</div>
<input type="hidden" name="Easy_Medicine_Red_lwj" id="Easy_Medicine_Red_lwj" value="<? echo $_SESSION['Easy_Medicine_Red_lwj'];?>">
<input type="hidden" name="Easy_Medicine_Orange_lwj" id="Easy_Medicine_Orange_lwj" value="<? echo $_SESSION['Easy_Medicine_Orange_lwj'];?>">
<input type="hidden" name="Easy_Insulin_Red_lwj" id="Easy_Insulin_Red_lwj" value="<? echo $_SESSION['Easy_Insulin_Red_lwj'];?>">
<input type="hidden" name="Easy_Insulin_Orange_lwj" id="Easy_Insulin_Orange_lwj" value="<? echo $_SESSION['Easy_Insulin_Orange_lwj'];?>">
<input type="hidden" name="Easy_Pipeline_Red_lwj" id="Easy_Pipeline_Red_lwj" value="<? echo $_SESSION['Easy_Pipeline_Red_lwj'];?>">
<input type="hidden" name="Easy_Pipeline_Orange_lwj" id="Easy_Pipeline_Orange_lwj" value="<? echo $_SESSION['Easy_Pipeline_Orange_lwj'];?>">
<script>
$(function() {
	var Red_Medicine = $("#Easy_Medicine_Red_lwj").val();
	var Orange_Medicine = $("#Easy_Medicine_Orange_lwj").val();
	if(Red_Medicine>0){
		document.getElementById('Medicine_Red_Number').innerHTML= Red_Medicine;
		document.getElementById('Medicine_Red_Point').style.display = 'inline';
	}
	if(Orange_Medicine>0){
		document.getElementById('Medicine_Orange_Number').innerHTML= Orange_Medicine;
		document.getElementById('Medicine_Orange_Point').style.display = 'inline';
	}
	
	
	var Red_Insulin = $("#Easy_Insulin_Red_lwj").val();
	var Orange_Insulin = $("#Easy_Insulin_Orange_lwj").val();
	if(Red_Insulin>0){
		document.getElementById('Insulin_Red_Number').innerHTML= Red_Insulin;
		document.getElementById('Insulin_Red_Point').style.display = 'inline';
	}
	if(Orange_Insulin>0){
		document.getElementById('Insulin_Orange_Number').innerHTML= Orange_Insulin;
		document.getElementById('Insulin_Orange_Point').style.display = 'inline';
	}
	
	
	var Red_Pipeline = $("#Easy_Pipeline_Red_lwj").val();
	var Orange_Pipeline = $("#Easy_Pipeline_Orange_lwj").val();
	if(Red_Pipeline>0){
		document.getElementById('Pipeline_Red_Number').innerHTML= Red_Pipeline;
		document.getElementById('Pipeline_Red_Point').style.display = 'inline';
	}
	if(Orange_Pipeline>0){
		document.getElementById('Pipeline_Orange_Number').innerHTML= Orange_Pipeline;
		document.getElementById('Pipeline_Orange_Point').style.display = 'inline';
	}
	
	
	var Medicine_Red = Number($("#Easy_Medicine_Red_lwj").val());
	var Insulin_Red = Number($("#Easy_Insulin_Red_lwj").val());
	var Pipeline_Red = Number($("#Easy_Pipeline_Red_lwj").val());
	var Total = eval(Medicine_Red + Insulin_Red + Pipeline_Red);
	if(Total>0){
		document.getElementById('Total_Red_Number').innerHTML = Total;
		document.getElementById('Total_Red_Point').style.display = 'inline';
	}
});
</script>