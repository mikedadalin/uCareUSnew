<?php
$VN = "";
for($i=0;$i<4;$i++){
	$N= rand(9,0);;
	$VN .= $N;
}
?>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td style="height:30%; padding-top:10px; padding-bottom:10px;"><center><a href="http://www.u-arkamerica.com/"><img alt="U-ARK America" src="Images/UARKAmericaLogo.png"></a></center></td>
  </tr>
  <tr>
    <td style="height:30%; background:url('Images/banner.jpg') no-repeat center center #ffffff;">
	  <center>
      <form action="index.php?func=loginprocess" onSubmit="return checkForm();" method="post" onSubmit="return checkForm();">
      <table border="0" cellpadding="0" cellspacing="0" style="background-color:rgba(0,0,0,0.6); width:37%; padding:15px;">
	    <tr>
		  <td rowspan="5">
		  <center><a href="index.php"><img alt="U-ARK America UCare System" src="Images/mainLogo.png" style="width:140px; height:140px;"></a></center>
		  </td>
		</tr>
        <tr>
          <td>
		    <font style="color:white; font-size:30px; font-weight:bold;">&nbsp;&nbsp;Username:</font>
		  </td>
          <td>
		    <input type="text" name="username" size="25" tabindex="1" style="font-size:18px; text-align:center;"/>
		  </td>
        </tr>
		<tr>
          <td>
			<font style="color:white; font-size:30px; font-weight:bold;">&nbsp;&nbsp;Password:</font>
		  </td>
          <td>
			<input type="password" name="password" size="25" tabindex="2" style="font-size:18px; text-align:center;"/>
		  </td>
		</tr>
		<tr>
          <td>
			<font style="color:white; font-size:30px; font-weight:bold;">&nbsp;&nbsp;Verification:</font>
		  </td>
          <td>
			<input type="text" name="iVN" size="25" tabindex="3" maxlength="4" style="font-size:18px; text-align:center;"/>
			<input type="hidden" name="VN" id="VN" value="<?php echo $VN;?>">
		  </td>
		</tr>
		<tr>
          <td>
		    <center>
		    <?PHP echo '<font style="color:#FF8000; font-size:30px; font-weight:bolder;">'.$VN.'</font>'; ?>
		    </center>
		  </td>
          <td>
		    <center>
		    <input type="submit" name="submit" id="submit" tabindex="4" onClick="this.submit();" value="Login" style="width:100px; height:40px; background-color:rgba(149,219,208,1); color:white; font-size:20px; border:none; border-radius:12px; margin:10px;"/>
		    </center>
		  </td>
		</tr>
      </table>
      </form>
	  </center>
	</td>
  </tr>
  <tr>
    <td style="height:30%;" align="center">
	<div style="margin-top:80px;">
      <a href="https://www.facebook.com/uarkamerica?fref=ts"><img alt="fb-link" src="Images/fb-icon.png" width="80px" height="80px"></a></li>
      <a href="mailto:info@u-arkamerica.com"><img alt="mail-to-UARK" src="Images/email-icon.png" width="80px" height="80px"></a></li>
    </div>
	<div>
      <h5>Copyright &copy 2015, U-ARK America | All Rights Reserved | 
      <a href="http://www.u-arkamerica.com/privacypolicy.htm">Privacy Policy</a></h5>
    </div>
	</td>
  </tr>
</table>