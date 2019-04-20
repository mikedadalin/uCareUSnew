<?php 

?>
<div>
<table width="100%" border="0">
  <tr>
<!--    <td width="150" class="title" valign="top">招募
    	<div class="title_s" style="background:#fff; border-top:1px solid #fff; color:#666; min-height:90px;">
        </div>
    </td>
    <td width="150" class="title" valign="top">入國引進函
    	<div class="title_s" style="background:#fff; border-top:1px solid #fff; color:#666; min-height:90px;">
        </div>    
    </td>
    <td width="150" class="title" valign="top">聘僱許可
    	<div class="title_s" style="background:#fff; border-top:1px solid #fff; color:#666; min-height:90px;">
        </div>
    </td>
-->    <td width="150" class="title" valign="top">Passport
    	<div class="title_s" style="background:#fff; border-top:1px solid #fff; color:#666; min-height:90px;">
        	<?php 
				$db4 = new DB;
				$db4->query("SELECT * FROM `foreign_personal_approval` where DATEDIFF(PassportExpireDate,'".date("Y/m/d")."') >= 1 and DATEDIFF(PassportExpireDate,'".date("Y/m/d")."') <= 121 ");
				if($db4->num_rows() > 0){
				  for ($i4=0;$i4<$db4->num_rows();$i4++) {
					  $r4 = $db4->fetch_assoc();
					  if(getQuit($r4['foreignID'])==0){					  
 				      	echo getforeignName($r4['foreignID']).'-'.$r4['PassportExpireDate']."<br>";
					  }
				  }
				}else{
					echo "---";
				}
								
			?>
        </div>
    </td>
    <td width="150" class="title" valign="top">Residence permit
    	<div class="title_s" style="background:#fff; border-top:1px solid #fff; color:#666; min-height:90px;">
        	<?php 
				$db5 = new DB;
				$db5->query("SELECT * FROM `foreign_personal_approval` where DATEDIFF(ResidentCardDate,'".date("Y/m/d")."') >= 1 and DATEDIFF(ResidentCardDate,'".date("Y/m/d")."') <= 31 and ResidentCardMemo = ''");
				if($db5->num_rows() > 0){
				  for ($i5=0;$i5<$db5->num_rows();$i5++) {
					  $r5 = $db5->fetch_assoc();
					  if(getQuit($r5['foreignID'])==0){
					  	echo getforeignName($r5['foreignID']).'-'.$r5['ResidentCardDate']."<br>";
					  }
				  }
				}else{
					echo "---";
				}
								
			?>
        </div>
    </td>
    <td width="150" class="title" valign="top">Physical examination
    	<div class="title_s" style="background:#fff; border-top:1px solid #fff; color:#666; min-height:90px;">
        	<?php 
				$db6 = new DB;
				$db6->query("SELECT * FROM `foreign_personal_approval` where DATEDIFF(PhyExamDate1,'".date("Y/m/d")."') >= 1 and DATEDIFF(PhyExamDate1,'".date("Y/m/d")."') <= 31 ");
				if($db6->num_rows() > 0){
				  for ($i6=0;$i6<$db6->num_rows();$i6++) {
					  $r6 = $db6->fetch_assoc();
					  if(getQuit($r6['foreignID'])==0){
					  	echo getforeignName($r6['foreignID']).'-'.$r6['PhyExamDate1']."<br>";
					  }
				  }
				}else{
					echo "---";
				}
								
			?>
        </div>
    </td>
  </tr>
</table>
</div>