<div name="VerificationForm" id="VerificationForm" title="Identity verification" style="display:none; z-index:97; position:absolute; margin:auto; top: 0; left: 0; bottom: 0; right: 0;">
<form>
<table style="background-color:rgba(0,0,0,0.8); border-radius:30px; width:550px; height:550px; position:absolute; margin:auto; top: 0; left: 0; bottom: 0; right: 0;">
  <tr>
    <td width="50px"></td>
	<td align="center">
	  <input type="password" name="iVN" id="iVN" size="4" maxlength="4" readonly="readonly" style="display:inline; background-color:rgba(0,0,0,0); border:none; color:#FF8000; font-size:100px; text-align:center; width:100%; height:100%;">
	  <input type="text" name="iVNerror" id="iVNerror" size="4" maxlength="4" readonly="readonly" style="display:none; background-color:rgba(0,0,0,0); border:none; color:red; font-size:25px; text-align:center; width:100%; height:100%;" value="Incorrect verification code!">
	</td>
	<td width="50px" align="center">
	  <input type="button" value="&#8249;" onclick="deleteVerificationNumber();" style="background-color:rgba(0,0,0,0); border:none; color:white; font-size:100px; width:100%; height:100%;">
	</td>
  </tr>
  <tr>
	<td colspan="3" align="center">
      <?php
      for($i=1;$i<11;$i++){
    	  if($i==10){ $i=0; echo '<input type="reset" value="Reset" style="background-color:rgba(0,0,0,0); border:none; color:white; font-size:30px; width:100px; height:100px;">'; }
    	  echo '<input type="button" name="n_'.$i.'" id="n_'.$i.'" value="'.$i.'" onclick="inputVerificationNumber(this.id);" style="background-color:rgba(0,0,0,0); border:none; color:white; font-size:30px; width:100px; height:100px;">';
    	  if($i==0){ $i=10; echo '<input type="button" value="Close" onclick="closeVerificationForm();" style="background-color:rgba(0,0,0,0); border:none; color:white; font-size:30px; width:100px; height:100px;">'; }
    	  if($i%3==0){ echo '<br>'; }
      }
      ?>
    </td>
  </tr>
</table>
</form>
<input type="hidden" name="OpenFormID" id="OpenFormID">
<input type="hidden" name="ErrorTime" id="ErrorTime">
</div>

<div name="VerificationForm2" id="VerificationForm2" title="Identity verification" style="display:none; z-index:97; position:absolute; margin:auto; top: 0; left: 0; bottom: 0; right: 0;">
<form>
<table style="background-color:rgba(0,0,0,0.8); border-radius:30px; width:550px; height:550px; position:absolute; margin:auto; top: 0; left: 0; bottom: 0; right: 0;">
  <tr>
    <td width="50px"></td>
	<td align="center">
	  <input type="password" name="iVN2" id="iVN2" size="4" maxlength="4" readonly="readonly" style="display:inline; background-color:rgba(0,0,0,0); border:none; color:#FF8000; font-size:100px; text-align:center; width:100%; height:100%;">
	  <input type="text" name="iVNerror2" id="iVNerror2" size="4" maxlength="4" readonly="readonly" style="display:none; background-color:rgba(0,0,0,0); border:none; color:red; font-size:25px; text-align:center; width:100%; height:100%;" value="Incorrect verification code!">
	</td>
	<td width="50px" align="center">
	  <input type="button" value="&#8249;" onclick="deleteVerificationNumber2();" style="background-color:rgba(0,0,0,0); border:none; color:white; font-size:100px; width:100%; height:100%;">
	</td>
  </tr>
  <tr>
	<td colspan="3" align="center">
      <?php
      for($i=1;$i<11;$i++){
    	  if($i==10){ $i=0; echo '<input type="reset" value="Reset" style="background-color:rgba(0,0,0,0); border:none; color:white; font-size:30px; width:100px; height:100px;">'; }
    	  echo '<input type="button" name="n2_'.$i.'" id="n2_'.$i.'" value="'.$i.'" onclick="inputVerificationNumber2(this.id);" style="background-color:rgba(0,0,0,0); border:none; color:white; font-size:30px; width:100px; height:100px;">';
    	  if($i==0){ $i=10; echo '<input type="button" value="Close" onclick="closeVerificationForm2();" style="background-color:rgba(0,0,0,0); border:none; color:white; font-size:30px; width:100px; height:100px;">'; }
    	  if($i%3==0){ echo '<br>'; }
      }
      ?>
    </td>
  </tr>
</table>
</form>
<input type="hidden" name="ShowSubmitID" id="ShowSubmitID">
<input type="hidden" name="ErrorTime2" id="ErrorTime2">
</div>