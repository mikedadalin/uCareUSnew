<div class="moduleNoTab">
<h3 style="margin-top:0px;">Account management</h3>
<div align="right"><form action="index.php?mod=humanresource&func=formview&id=3_2" method="POST"><input type="submit" value="Add new user" /></form></div>
<div class="content-table" align="right">
  <table>
    <tr class="title">
      <td width="50" align="center"><b>Select</b></td>
      <td width="100" align="center"><b>User ID</b></td>
      <td width="90" align="center"><b>Group</b></td>
      <td width="100" align="center"><b>Full name</b></td>
      <td width="180" align="center"><b>E-mail</b></td>
      <td width="90" align="center"><b>Permission</b></td>
      <td width="90" align="center"><b>Status</b></td>
    </tr>
    <?php
		$sql = "SELECT * FROM `userinfo` WHERE `OrgID`='".$_SESSION['nOrgID_lwj']."' AND `userID`!='Lejla05Mirzada12Asmira01' ORDER BY `group` ASC, `level` DESC, `active` DESC";
	    $db2 = new DB2;
		$db2->query($sql);
		$row = $db2->num_rows();
		
		//權限名稱
		$level = array ("1"=>"General staff", "4"=>"General staff", "5"=>"Manager");
		//狀態名稱
		$active = array ("0"=>"Disabled", "1"=>"Normal");
		//組別名稱
		$arrGroup = array("", "Administration", "Nursing", "Domestic CNA", "Pharmacy", "Social worker", "physiotherapist", "Nutritionist", "Public work", "General manage", "Foreign CNA");
		
		for ($i=1;$i<=$row;$i++)
		{
			$r2 = $db2->fetch_assoc();
			
			echo "
			<tr><td width=\"50\" align=\"center\">".($r2['level']<=$_SESSION['ncareLevel_lwj']?"<a href=\"index.php?mod=humanresource&func=formview&id=3_1&uID=".$r2['userID']."\"><img src=\"Images/edit_icon.png\"></a>":"")."</td>
			<td width=\"100\" align=\"center\">".$r2["userID"]."</td>
			<td width=\"100\" align=\"center\">".$arrGroup[(int)$r2["group"]]."</td>
			<td width=\"100\" align=\"center\">".$r2["name"]."</td>
			<td width=\"180\" align=\"center\"><a href=\"mailto:".$r2["email"]."\">".$r2["email"]."</a></td>
			<td width=\"90\" align=\"center\">".$level[$r2["level"]]."</td>
			<td width=\"90\" align=\"center\">".$active[$r2["active"]]."</td></tr>";
		}
	?>
  </table>
</div>
</div>