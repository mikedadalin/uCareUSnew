<?php
  if($_GET['date']!=NULL){
	  if($_GET['date']=='Select dates to edit information or new record'){
		  $db = new DB;
		  $db->query("SELECT * FROM `mdsform99` WHERE `HospNo`='".$HospNo."' ORDER BY `date` DESC");
		  $r = $db->fetch_assoc();
		  $r['date'] = str_replace('-','',$r['date']);
		  ?>
		  <script>
          document.location.href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=<?php echo $_GET['id']; ?>&date=<?php echo $r['date'];?>";
          </script>
		  <?php
	  }
	  $db = new DB;
	  $db->query("SELECT * FROM `mdsform99` WHERE `HospNo`='".$HospNo."' AND `date`='".mysql_escape_string($_GET['date'])."'");
	  if($db->num_rows()==0){
		  ?>
		  <script>
          document.location.href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=<?php echo $_GET['id'];?>";
          </script>
		  <?
	  }
?>
<script>
function deleteMDScheck() {
    if (confirm("Are you sure you want to delete this data? \n( MDS: <?php echo formatdate_Ymd_Slash($_GET['date']);?> )") == true) {
		if (confirm("If you do delete, this data( MDS: <?php echo formatdate_Ymd_Slash($_GET['date']);?> ) can not be restored. Are you sure?") == true){
			document.location.href="index.php?func=MDS-Delete&pid=<?php echo $_GET['pid']; ?>&date=<?php echo $_GET['date']; ?>";
		}
    }
}
</script>
	<style>
	  table.mds {font-family:sans-serif; line-height:20px}
	  th.mds {background-color:#69b3b6; font-size:20px; text-align:center; padding:10px 15px;}
	  td.mds {background-color:#cfe7e8; font-size:15px; text-align:center}
	  td.function {background-color:#cfe7e8; font-size:15px; text-align:center}
	  td.mdssection {background-color:#cfe7e8; font-size:15px; padding-left:15px; padding-right:15px}
	  td.mdspage {background-color:#cfe7e8; font-size:15px; text-align:center; padding-left:10px; padding-right:10px}
	  td.mdspage_red {background-color:#ff8f9a; font-size:15px; text-align:center; padding-left:10px; padding-right:10px}
	  td.mdspage_yellow {background-color:#f2da6e; font-size:15px; text-align:center; padding-left:10px; padding-right:10px}
	  td.print {background-color:#cfe7e8; font-size:15px; text-align:center; padding-left:10px; padding-right:10px}
	  td.print_red {background-color:#ff8f9a; font-size:15px; text-align:center; padding-left:10px; padding-right:10px}
	  td.print_yellow {background-color:#f2da6e; font-size:15px; text-align:center; padding-left:10px; padding-right:10px}
	  td.alter {background-color:#cfe7e8; font-size:15px; text-align:center; padding-left:10px; padding-right:10px}
	  td.alter_red {background-color:#ff8f9a; font-size:15px; text-align:center; padding-left:10px; padding-right:10px}
	  td.alter_yellow {background-color:#f2da6e; font-size:15px; text-align:center; padding-left:10px; padding-right:10px}
	</style>
  <div>
	<table class="mds" colspan="5" cellpadding="5" style="margin-bottom:20px;">
	  <tr>
	    <th class="mds" colspan="1">MDS</th>
		<th class="mds" colspan="2">Function</th>
	    <th class="mds" colspan="1">Section</th>
		<th class="mds" colspan="1">Function</th>
		<th class="mds" colspan="1">Page</th>
		<th class="mds" colspan="2">Function</th>
	  </tr>
	  <tr>    <!--========= 寫完判斷式給 0:red   1:yellow 判斷是否顯示red =========-->
		<td class="mds" rowspan="45"><form><input type="button" value="MDS" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=MDS&date=<?php echo $_GET['date']; ?>'" /></form></td>
		<td class="function" rowspan="45"><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=MDS&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td> <!--location.href='index.php?func=MDS-Delete&pid=<?php echo $_GET['pid']; ?>&date=<?php echo $_GET['date']; ?>' -->
		<td class="function" rowspan="45"><input type="image" src="Images/delete3.png" onclick="deleteMDScheck()" /></td>
		<td class="mdssection" rowspan="5"><form><input type="button" value="Section A :&nbsp Identification Information" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=SectionA&date=<?php echo $_GET['date']; ?>'" /></form></td>                                       
		<td class="function" rowspan="5"><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=SectionA&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>
	    <td <?php if($page1=="0"){echo 'class="mdspage_red"';}else{echo 'class="mdspage"';}?>><form><input type="button" value="Page 1" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=1&date=<?php echo $_GET['date']; ?>'"></form></td>
		<td <?php if($page1=="0"){echo 'class="print_red"';}else{echo 'class="print"';}?>><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=1&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>
		<td <?php if($page1=="0"){echo 'class="alter_red"';}else{echo 'class="alter"';}?>><a href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=1-Alter&date=<?php echo $_GET['date']; ?>"><img src="Images/Edit.png" border="0"></a><!-- <form><input type="button" value="Alter" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=1-Alter&date=<?php echo $_GET['date']; ?>'" /></form> --></td>
	  </tr>
	  <tr>
	    <td <?php if($page2=="0"){echo 'class="mdspage_red"';}else{echo 'class="mdspage"';}?>><form><input type="button" value="Page 2" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=2&date=<?php echo $_GET['date']; ?>'"></form></td>
		<td <?php if($page2=="0"){echo 'class="print_red"';}else{echo 'class="print"';}?>><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=2&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>
		<td <?php if($page2=="0"){echo 'class="alter_red"';}else{echo 'class="alter"';}?>><a href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=2-Alter&date=<?php echo $_GET['date']; ?>"><img src="Images/Edit.png" border="0"></a></td>
	  </tr>
	  <tr>
	    <td <?php if($page3=="0"){echo 'class="mdspage_red"';}elseif($page3=="1"){echo 'class="mdspage_yellow"';}else{echo 'class="mdspage"';}?>><form><input type="button" value="Page 3" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=3&date=<?php echo $_GET['date']; ?>'"></form></td>
		<td <?php if($page3=="0"){echo 'class="print_red"';}elseif($page3=="1"){echo 'class="print_yellow"';}else{echo 'class="print"';}?>><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=3&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>
		<td <?php if($page3=="0"){echo 'class="alter_red"';}elseif($page3=="1"){echo 'class="alter_yellow"';}else{echo 'class="alter"';}?>><a href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=3-Alter&date=<?php echo $_GET['date']; ?>"><img src="Images/Edit.png" border="0"></a></td>
	  </tr>
	  <tr>
	    <td <?php if($page4=="0"){echo 'class="mdspage_red"';}elseif($page4=="1"){echo 'class="mdspage_yellow"';}else{echo 'class="mdspage"';}?>><form><input type="button" value="Page 4" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=4&date=<?php echo $_GET['date']; ?>'"></form></td>
		<td <?php if($page4=="0"){echo 'class="print_red"';}elseif($page4=="1"){echo 'class="print_yellow"';}else{echo 'class="print"';}?>><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=4&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>
		<td <?php if($page4=="0"){echo 'class="alter_red"';}elseif($page4=="1"){echo 'class="alter_yellow"';}else{echo 'class="alter"';}?>><a href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=4-Alter&date=<?php echo $_GET['date']; ?>"><img src="Images/Edit.png" border="0"></a></td>
	  </tr>
	  <tr>
	    <td <?php if($page5=="0"){echo 'class="mdspage_red"';}else{echo 'class="mdspage"';}?>><form><input type="button" value="Page 5" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=5&date=<?php echo $_GET['date']; ?>'"></form></td>
		<td <?php if($page5=="0"){echo 'class="print_red"';}else{echo 'class="print"';}?>><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=5&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>
		<td <?php if($page5=="0"){echo 'class="alter_red"';}else{echo 'class="alter"';}?>><a href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=5-Alter&date=<?php echo $_GET['date']; ?>"><img src="Images/Edit.png" border="0"></a></td>
	  </tr>
	  <tr>
		<td class="mdssection"><form><input type="button" value="Section B :&nbsp Hearing, Speech, and Vision" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=SectionB&date=<?php echo $_GET['date']; ?>'" /></form></td>
	    <td class="function" rowspan="1"><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=SectionB&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>
		<td <?php if($page6=="0"){echo 'class="mdspage_red"';}else{echo 'class="mdspage"';}?>><form><input type="button" value="Page 6" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=6&date=<?php echo $_GET['date']; ?>'"></form></td>
		<td <?php if($page6=="0"){echo 'class="print_red"';}else{echo 'class="print"';}?>><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=6&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>
		<td <?php if($page6=="0"){echo 'class="alter_red"';}else{echo 'class="alter"';}?>><a href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=6-Alter&date=<?php echo $_GET['date']; ?>"><img src="Images/Edit.png" border="0"></a></td>
	  </tr>
	  <tr>
		<td class="mdssection" rowspan="2"><form><input type="button" value="Section C :&nbsp Cognitive Patterns" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=SectionC&date=<?php echo $_GET['date']; ?>'" /></form></td>  
		<td class="function" rowspan="2"><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=SectionC&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>
		<td <?php if($page7=="0"){echo 'class="mdspage_red"';}else{echo 'class="mdspage"';}?>><form><input type="button" value="Page 7" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=7&date=<?php echo $_GET['date']; ?>'"></form></td>
		<td <?php if($page7=="0"){echo 'class="print_red"';}else{echo 'class="print"';}?>><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=7&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>
		<td <?php if($page7=="0"){echo 'class="alter_red"';}else{echo 'class="alter"';}?>><a href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=7-Alter&date=<?php echo $_GET['date']; ?>"><img src="Images/Edit.png" border="0"></a></td>
	  </tr>
	  <tr>	  
		<td <?php if($page8=="0"){echo 'class="mdspage_red"';}else{echo 'class="mdspage"';}?>><form><input type="button" value="Page 8" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=8&date=<?php echo $_GET['date']; ?>'"></form></td>
		<td <?php if($page8=="0"){echo 'class="print_red"';}else{echo 'class="print"';}?>><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=8&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>
		<td <?php if($page8=="0"){echo 'class="alter_red"';}else{echo 'class="alter"';}?>><a href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=8-Alter&date=<?php echo $_GET['date']; ?>"><img src="Images/Edit.png" border="0"></a></td>
	  </tr>
	  <tr>
		<td class="mdssection" rowspan="2"><form><input type="button" value="Section D :&nbsp Mood" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=SectionD&date=<?php echo $_GET['date']; ?>'" /></form></td>
		<td class="function" rowspan="2"><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=SectionD&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>
		<td <?php if($page9=="0"){echo 'class="mdspage_red"';}else{echo 'class="mdspage"';}?>><form><input type="button" value="Page 9" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=9&date=<?php echo $_GET['date']; ?>'"></form></td>
		<td <?php if($page9=="0"){echo 'class="print_red"';}else{echo 'class="print"';}?>><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=9&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>
		<td <?php if($page9=="0"){echo 'class="alter_red"';}else{echo 'class="alter"';}?>><a href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=9-Alter&date=<?php echo $_GET['date']; ?>"><img src="Images/Edit.png" border="0"></a></td>
	  </tr>
	  <tr>	  
		<td <?php if($page10=="0"){echo 'class="mdspage_red"';}else{echo 'class="mdspage"';}?>><form><input type="button" value="Page 10" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=10&date=<?php echo $_GET['date']; ?>'"></form></td>
		<td <?php if($page10=="0"){echo 'class="print_red"';}else{echo 'class="print"';}?>><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=10&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>
		<td <?php if($page10=="0"){echo 'class="alter_red"';}else{echo 'class="alter"';}?>><a href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=10-Alter&date=<?php echo $_GET['date']; ?>"><img src="Images/Edit.png" border="0"></a></td>
	  </tr>
	  <tr>
		<td class="mdssection" rowspan="2"><form><input type="button" value="Section E :&nbsp Behavior" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=SectionE&date=<?php echo $_GET['date']; ?>'" /></form></td>
        <td class="function" rowspan="2"><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=SectionE&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>  
		<td <?php if($page11=="0"){echo 'class="mdspage_red"';}else{echo 'class="mdspage"';}?>><form><input type="button" value="Page 11" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=11&date=<?php echo $_GET['date']; ?>'"></form></td>
		<td <?php if($page11=="0"){echo 'class="print_red"';}else{echo 'class="print"';}?>><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=11&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>
		<td <?php if($page11=="0"){echo 'class="alter_red"';}else{echo 'class="alter"';}?>><a href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=11-Alter&date=<?php echo $_GET['date']; ?>"><img src="Images/Edit.png" border="0"></a></td>
	  </tr>
	  <tr>	  
		<td <?php if($page12=="0"){echo 'class="mdspage_red"';}else{echo 'class="mdspage"';}?>><form><input type="button" value="Page 12" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=12&date=<?php echo $_GET['date']; ?>'"></form></td>
		<td <?php if($page12=="0"){echo 'class="print_red"';}else{echo 'class="print"';}?>><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=12&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>
		<td <?php if($page12=="0"){echo 'class="alter_red"';}else{echo 'class="alter"';}?>><a href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=12-Alter&date=<?php echo $_GET['date']; ?>"><img src="Images/Edit.png" border="0"></a></td>
	  </tr>
	  <tr>
		<td class="mdssection" rowspan="2"><form><input type="button" value="Section F :&nbsp Preferences for Customary Routine and Activities" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=SectionF&date=<?php echo $_GET['date']; ?>'" /></form></td>
	    <td class="function" rowspan="2"><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=SectionF&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>  
		<td <?php if($page13=="0"){echo 'class="mdspage_red"';}else{echo 'class="mdspage"';}?>><form><input type="button" value="Page 13" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=13&date=<?php echo $_GET['date']; ?>'"></form></td>
		<td <?php if($page13=="0"){echo 'class="print_red"';}else{echo 'class="print"';}?>><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=13&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>
		<td <?php if($page13=="0"){echo 'class="alter_red"';}else{echo 'class="alter"';}?>><a href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=13-Alter&date=<?php echo $_GET['date']; ?>"><img src="Images/Edit.png" border="0"></a></td>
	  </tr>
	  <tr>	  
		<td <?php if($page14=="0"){echo 'class="mdspage_red"';}else{echo 'class="mdspage"';}?>><form><input type="button" value="Page 14" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=14&date=<?php echo $_GET['date']; ?>'"></form></td>
		<td <?php if($page14=="0"){echo 'class="print_red"';}else{echo 'class="print"';}?>><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=14&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>
		<td <?php if($page14=="0"){echo 'class="alter_red"';}else{echo 'class="alter"';}?>><a href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=14-Alter&date=<?php echo $_GET['date']; ?>"><img src="Images/Edit.png" border="0"></a></td>
	  </tr>
	  <tr>
		<td class="mdssection" rowspan="2"><form><input type="button" value="Section G :&nbsp Functional Status" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=SectionG&date=<?php echo $_GET['date']; ?>'" /></form></td>
	    <td class="function" rowspan="2"><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=SectionG&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>  
		<td <?php if($page15=="0"){echo 'class="mdspage_red"';}else{echo 'class="mdspage"';}?>><form><input type="button" value="Page 15" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=15&date=<?php echo $_GET['date']; ?>'"></form></td>
		<td <?php if($page15=="0"){echo 'class="print_red"';}else{echo 'class="print"';}?>><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=15&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>
		<td <?php if($page15=="0"){echo 'class="alter_red"';}else{echo 'class="alter"';}?>><a href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=15-Alter&date=<?php echo $_GET['date']; ?>"><img src="Images/Edit.png" border="0"></a></td>
	  </tr>
	  <tr>	  
		<td <?php if($page16=="0"){echo 'class="mdspage_red"';}else{echo 'class="mdspage"';}?>><form><input type="button" value="Page 16" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=16&date=<?php echo $_GET['date']; ?>'"></form></td>
		<td <?php if($page16=="0"){echo 'class="print_red"';}else{echo 'class="print"';}?>><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=16&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>
		<td <?php if($page16=="0"){echo 'class="alter_red"';}else{echo 'class="alter"';}?>><a href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=16-Alter&date=<?php echo $_GET['date']; ?>"><img src="Images/Edit.png" border="0"></a></td>
	  </tr>
	  <tr>
		<td class="mdssection"><form><input type="button" value="Section H :&nbsp Bladder and Bowel" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=SectionH&date=<?php echo $_GET['date']; ?>'" /></form></td>
	    <td class="function" rowspan="1"><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=SectionH&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>
		<td <?php if($page17=="0"){echo 'class="mdspage_red"';}else{echo 'class="mdspage"';}?>><form><input type="button" value="Page 17" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=17&date=<?php echo $_GET['date']; ?>'"></form></td>
		<td <?php if($page17=="0"){echo 'class="print_red"';}else{echo 'class="print"';}?>><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=17&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>
		<td <?php if($page17=="0"){echo 'class="alter_red"';}else{echo 'class="alter"';}?>><a href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=17-Alter&date=<?php echo $_GET['date']; ?>"><img src="Images/Edit.png" border="0"></a></td>
	  </tr>
	  <tr>
		<td class="mdssection" rowspan="2"><form><input type="button" value="Section I &nbsp :&nbsp Active Diagnoses" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=SectionI&date=<?php echo $_GET['date']; ?>'" /></form></td>
	    <td class="function" rowspan="2"><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=SectionI&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>	  
		<td <?php if($page18=="0"){echo 'class="mdspage_red"';}elseif($page18=="1"){echo 'class="mdspage_yellow"';}else{echo 'class="mdspage"';}?>><form><input type="button" value="Page 18" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=18&date=<?php echo $_GET['date']; ?>'"></form></td>
		<td <?php if($page18=="0"){echo 'class="print_red"';}elseif($page18=="1"){echo 'class="print_yellow"';}else{echo 'class="print"';}?>><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=18&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>
		<td <?php if($page18=="0"){echo 'class="alter_red"';}elseif($page18=="1"){echo 'class="alter_yellow"';}else{echo 'class="alter"';}?>><a href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=18-Alter&date=<?php echo $_GET['date']; ?>"><img src="Images/Edit.png" border="0"></a></td>
	  </tr>
	  <tr>	  
		<td <?php if($page19=="0"){echo 'class="mdspage_red"';}elseif($page19=="1"){echo 'class="mdspage_yellow"';}else{echo 'class="mdspage"';}?>><form><input type="button" value="Page 19" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=19&date=<?php echo $_GET['date']; ?>'"></form></td>
		<td <?php if($page19=="0"){echo 'class="print_red"';}elseif($page19=="1"){echo 'class="print_yellow"';}else{echo 'class="print"';}?>><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=19&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>
		<td <?php if($page19=="0"){echo 'class="alter_red"';}elseif($page19=="1"){echo 'class="alter_yellow"';}else{echo 'class="alter"';}?>><a href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=19-Alter&date=<?php echo $_GET['date']; ?>"><img src="Images/Edit.png" border="0"></a></td>
	  </tr>
	  <tr>
		<td class="mdssection" rowspan="3"><form><input type="button" value="Section J :&nbsp Health Conditions" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=SectionJ&date=<?php echo $_GET['date']; ?>'" /></form></td>
	    <td class="function" rowspan="3"><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=SectionJ&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>  
		<td <?php if($page20=="0"){echo 'class="mdspage_red"';}else{echo 'class="mdspage"';}?>><form><input type="button" value="Page 20" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=20&date=<?php echo $_GET['date']; ?>'"></form></td>
		<td <?php if($page20=="0"){echo 'class="print_red"';}else{echo 'class="print"';}?>><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=20&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>
		<td <?php if($page20=="0"){echo 'class="alter_red"';}else{echo 'class="alter"';}?>><a href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=20-Alter&date=<?php echo $_GET['date']; ?>"><img src="Images/Edit.png" border="0"></a></td>
	  </tr>
	  <tr>	  
		<td <?php if($page21=="0"){echo 'class="mdspage_red"';}else{echo 'class="mdspage"';}?>><form><input type="button" value="Page 21" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=21&date=<?php echo $_GET['date']; ?>'"></form></td>
		<td <?php if($page21=="0"){echo 'class="print_red"';}else{echo 'class="print"';}?>><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=21&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>
		<td <?php if($page21=="0"){echo 'class="alter_red"';}else{echo 'class="alter"';}?>><a href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=21-Alter&date=<?php echo $_GET['date']; ?>"><img src="Images/Edit.png" border="0"></a></td>
	  </tr>
	  <tr>	  
		<td <?php if($page22=="0"){echo 'class="mdspage_red"';}else{echo 'class="mdspage"';}?>><form><input type="button" value="Page 22" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=22&date=<?php echo $_GET['date']; ?>'"></form></td>
		<td <?php if($page22=="0"){echo 'class="print_red"';}else{echo 'class="print"';}?>><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=22&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>
		<td <?php if($page22=="0"){echo 'class="alter_red"';}else{echo 'class="alter"';}?>><a href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=22-Alter&date=<?php echo $_GET['date']; ?>"><img src="Images/Edit.png" border="0"></a></td>
	  </tr>
	  <tr>
		<td class="mdssection" rowspan="2"><form><input type="button" value="Section K :&nbsp Swallowing/Nutritional Status" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=SectionK&date=<?php echo $_GET['date']; ?>'" /></form></td>
	    <td class="function" rowspan="2"><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=SectionK&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>	  
		<td <?php if($page23=="0"){echo 'class="mdspage_red"';}else{echo 'class="mdspage"';}?>><form><input type="button" value="Page 23" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=23&date=<?php echo $_GET['date']; ?>'"></form></td>
		<td <?php if($page23=="0"){echo 'class="print_red"';}else{echo 'class="print"';}?>><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=23&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>
		<td <?php if($page23=="0"){echo 'class="alter_red"';}else{echo 'class="alter"';}?>><a href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=23-Alter&date=<?php echo $_GET['date']; ?>"><img src="Images/Edit.png" border="0"></a></td>
	  </tr>
	  <tr>	  
		<td <?php if($page24=="0"){echo 'class="mdspage_red"';}else{echo 'class="mdspage"';}?>><form><input type="button" value="Page 24" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=24&date=<?php echo $_GET['date']; ?>'"></form></td>
		<td <?php if($page24=="0"){echo 'class="print_red"';}else{echo 'class="print"';}?>><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=24&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>
		<td <?php if($page24=="0"){echo 'class="alter_red"';}else{echo 'class="alter"';}?>><a href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=24-Alter&date=<?php echo $_GET['date']; ?>"><img src="Images/Edit.png" border="0"></a></td>
	  </tr>
	  <tr>
		<td class="mdssection"><form><input type="button" value="Section L :&nbsp Oral/Dental Status" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=SectionL&date=<?php echo $_GET['date']; ?>'" /></form></td>
	    <td class="function" rowspan="1"><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=SectionL&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>
		<td <?php if($page24=="0"){echo 'class="mdspage_red"';}else{echo 'class="mdspage"';}?>><form><input type="button" value="Page 24" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=24&date=<?php echo $_GET['date']; ?>'"></form></td>
		<td <?php if($page24=="0"){echo 'class="print_red"';}else{echo 'class="print"';}?>><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=24&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>
		<td <?php if($page24=="0"){echo 'class="alter_red"';}else{echo 'class="alter"';}?>><a href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=24-Alter&date=<?php echo $_GET['date']; ?>"><img src="Images/Edit.png" border="0"></a></td>
	  </tr>
	  <tr>
		<td class="mdssection" rowspan="3"><form><input type="button" value="Section M :&nbsp Skin Conditions" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=SectionM&date=<?php echo $_GET['date']; ?>'" /></form></td>
	    <td class="function" rowspan="3"><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=SectionM&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>	  
		<td <?php if($page25=="0"){echo 'class="mdspage_red"';}else{echo 'class="mdspage"';}?>><form><input type="button" value="Page 25" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=25&date=<?php echo $_GET['date']; ?>'"></form></td>
		<td <?php if($page25=="0"){echo 'class="print_red"';}else{echo 'class="print"';}?>><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=25&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>
		<td <?php if($page25=="0"){echo 'class="alter_red"';}else{echo 'class="alter"';}?>><a href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=25-Alter&date=<?php echo $_GET['date']; ?>"><img src="Images/Edit.png" border="0"></a></td>
	  </tr>
	  <tr>	  
		<td <?php if($page26=="0"){echo 'class="mdspage_red"';}else{echo 'class="mdspage"';}?>><form><input type="button" value="Page 26" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=26&date=<?php echo $_GET['date']; ?>'"></form></td>
		<td <?php if($page26=="0"){echo 'class="print_red"';}else{echo 'class="print"';}?>><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=26&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>
		<td <?php if($page26=="0"){echo 'class="alter_red"';}else{echo 'class="alter"';}?>><a href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=26-Alter&date=<?php echo $_GET['date']; ?>"><img src="Images/Edit.png" border="0"></a></td>
	  </tr>
	  <tr>	  
		<td <?php if($page27=="0"){echo 'class="mdspage_red"';}elseif($page27=="1"){echo 'class="mdspage_yellow"';}else{echo 'class="mdspage"';}?>><form><input type="button" value="Page 27" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=27&date=<?php echo $_GET['date']; ?>'"></form></td>
		<td <?php if($page27=="0"){echo 'class="print_red"';}elseif($page27=="1"){echo 'class="print_yellow"';}else{echo 'class="print"';}?>><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=27&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>
		<td <?php if($page27=="0"){echo 'class="alter_red"';}elseif($page27=="1"){echo 'class="alter_yellow"';}else{echo 'class="alter"';}?>><a href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=27-Alter&date=<?php echo $_GET['date']; ?>"><img src="Images/Edit.png" border="0"></a></td>
	  </tr>
	  <tr>
		<td class="mdssection"><form><input type="button" value="Section N :&nbsp Medications" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=SectionN&date=<?php echo $_GET['date']; ?>'" /></form></td>
	    <td class="function" rowspan="1"><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=SectionN&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>
		<td <?php if($page28=="0"){echo 'class="mdspage_red"';}else{echo 'class="mdspage"';}?>><form><input type="button" value="Page 28" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=28&date=<?php echo $_GET['date']; ?>'"></form></td>
		<td <?php if($page28=="0"){echo 'class="print_red"';}else{echo 'class="print"';}?>><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=28&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>
		<td <?php if($page28=="0"){echo 'class="alter_red"';}else{echo 'class="alter"';}?>><a href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=28-Alter&date=<?php echo $_GET['date']; ?>"><img src="Images/Edit.png" border="0"></a></td>
	  </tr>
	  <tr>
		<td class="mdssection" rowspan="4"><form><input type="button" value="Section O :&nbsp Special Treatments, Procedures, and Programs" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=SectionO&date=<?php echo $_GET['date']; ?>'" /></form></td>
	    <td class="function" rowspan="4"><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=SectionO&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>  
		<td <?php if($page29=="0"){echo 'class="mdspage_red"';}else{echo 'class="mdspage"';}?>><form><input type="button" value="Page 29" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=29&date=<?php echo $_GET['date']; ?>'"></form></td>
		<td <?php if($page29=="0"){echo 'class="print_red"';}else{echo 'class="print"';}?>><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=29&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>
		<td <?php if($page29=="0"){echo 'class="alter_red"';}else{echo 'class="alter"';}?>><a href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=29-Alter&date=<?php echo $_GET['date']; ?>"><img src="Images/Edit.png" border="0"></a></td>
	  </tr>
	  <tr>	  
		<td <?php if($page30=="0"){echo 'class="mdspage_red"';}else{echo 'class="mdspage"';}?>><form><input type="button" value="Page 30" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=30&date=<?php echo $_GET['date']; ?>'"></form></td>
		<td <?php if($page30=="0"){echo 'class="print_red"';}else{echo 'class="print"';}?>><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=30&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>
		<td <?php if($page30=="0"){echo 'class="alter_red"';}else{echo 'class="alter"';}?>><a href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=30-Alter&date=<?php echo $_GET['date']; ?>"><img src="Images/Edit.png" border="0"></a></td>
	  </tr>
	  <tr>	  
		<td <?php if($page31=="0"){echo 'class="mdspage_red"';}else{echo 'class="mdspage"';}?>><form><input type="button" value="Page 31" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=31&date=<?php echo $_GET['date']; ?>'"></form></td>
		<td <?php if($page31=="0"){echo 'class="print_red"';}else{echo 'class="print"';}?>><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=31&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>
		<td <?php if($page31=="0"){echo 'class="alter_red"';}else{echo 'class="alter"';}?>><a href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=31-Alter&date=<?php echo $_GET['date']; ?>"><img src="Images/Edit.png" border="0"></a></td>
	  </tr>
      <tr>	  
		<td <?php if($page32=="0"){echo 'class="mdspage_red"';}else{echo 'class="mdspage"';}?>><form><input type="button" value="Page 32" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=32&date=<?php echo $_GET['date']; ?>'"></form></td>
		<td <?php if($page32=="0"){echo 'class="print_red"';}else{echo 'class="print"';}?>><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=32&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>
		<td <?php if($page32=="0"){echo 'class="alter_red"';}else{echo 'class="alter"';}?>><a href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=32-Alter&date=<?php echo $_GET['date']; ?>"><img src="Images/Edit.png" border="0"></a></td>
	  </tr>
      <tr>
		<td class="mdssection"><form><input type="button" value="Section P :&nbsp Restraints" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=SectionP&date=<?php echo $_GET['date']; ?>'" /></form></td>
	    <td class="function" rowspan="1"><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=SectionP&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>
		<td <?php if($page33=="0"){echo 'class="mdspage_red"';}else{echo 'class="mdspage"';}?>><form><input type="button" value="Page 33" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=33&date=<?php echo $_GET['date']; ?>'"></form></td>
		<td <?php if($page33=="0"){echo 'class="print_red"';}else{echo 'class="print"';}?>><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=33&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>
		<td <?php if($page33=="0"){echo 'class="alter_red"';}else{echo 'class="alter"';}?>><a href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=33-Alter&date=<?php echo $_GET['date']; ?>"><img src="Images/Edit.png" border="0"></a></td>
	  </tr>
      <tr>
		<td class="mdssection" rowspan="2"><form><input type="button" value="Section Q :&nbsp Participation in Assessment and Goal Setting" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=SectionQ&date=<?php echo $_GET['date']; ?>'" /></form></td>
	    <td class="function" rowspan="2"><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=SectionQ&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>  
		<td <?php if($page33=="0"){echo 'class="mdspage_red"';}else{echo 'class="mdspage"';}?>><form><input type="button" value="Page 33" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=33&date=<?php echo $_GET['date']; ?>'"></form></td>
		<td <?php if($page33=="0"){echo 'class="print_red"';}else{echo 'class="print"';}?>><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=33&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>
		<td <?php if($page33=="0"){echo 'class="alter_red"';}else{echo 'class="alter"';}?>><a href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=33-Alter&date=<?php echo $_GET['date']; ?>"><img src="Images/Edit.png" border="0"></a></td>
	  </tr>
	  <tr>	  
		<td <?php if($page34=="0"){echo 'class="mdspage_red"';}else{echo 'class="mdspage"';}?>><form><input type="button" value="Page 34" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=34&date=<?php echo $_GET['date']; ?>'"></form></td>
		<td <?php if($page34=="0"){echo 'class="print_red"';}else{echo 'class="print"';}?>><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=34&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>
		<td <?php if($page34=="0"){echo 'class="alter_red"';}else{echo 'class="alter"';}?>><a href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=34-Alter&date=<?php echo $_GET['date']; ?>"><img src="Images/Edit.png" border="0"></a></td>
	  </tr>
      <tr>
		<td class="mdssection" rowspan="2"><form><input type="button" value="Section V :&nbsp Care Area Assessment (CAA) Summary" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=SectionV&date=<?php echo $_GET['date']; ?>'" /></form></td>
	    <td class="function" rowspan="2"><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=SectionV&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>  
		<td <?php if($page35=="0"){echo 'class="mdspage_red"';}else{echo 'class="mdspage"';}?>><form><input type="button" value="Page 35" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=35&date=<?php echo $_GET['date']; ?>'"></form></td>
		<td <?php if($page35=="0"){echo 'class="print_red"';}else{echo 'class="print"';}?>><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=35&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>
		<td <?php if($page35=="0"){echo 'class="alter_red"';}else{echo 'class="alter"';}?>><a href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=35-Alter&date=<?php echo $_GET['date']; ?>"><img src="Images/Edit.png" border="0"></a></td>
	  </tr>
	  <tr>	  
		<td <?php if($page36=="0"){echo 'class="mdspage_red"';}elseif($page36=="1"){echo 'class="mdspage_yellow"';}else{echo 'class="mdspage"';}?>><form><input type="button" value="Page 36" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=36&date=<?php echo $_GET['date']; ?>'"></form></td>
		<td <?php if($page36=="0"){echo 'class="print_red"';}elseif($page36=="1"){echo 'class="print_yellow"';}else{echo 'class="print"';}?>><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=36&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>
		<td <?php if($page36=="0"){echo 'class="alter_red"';}elseif($page36=="1"){echo 'class="alter_yellow"';}else{echo 'class="alter"';}?>><a href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=36-Alter&date=<?php echo $_GET['date']; ?>"><img src="Images/Edit.png" border="0"></a></td>
	  </tr>
      <tr>
		<td class="mdssection" rowspan="3"><form><input type="button" value="Section X :&nbsp Correction Request" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=SectionX&date=<?php echo $_GET['date']; ?>'" /></form></td>
	    <td class="function" rowspan="3"><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=SectionX&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>  
		<td <?php if($page37=="0"){echo 'class="mdspage_red"';}else{echo 'class="mdspage"';}?>><form><input type="button" value="Page 37" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=37&date=<?php echo $_GET['date']; ?>'"></form></td>
		<td <?php if($page37=="0"){echo 'class="print_red"';}else{echo 'class="print"';}?>><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=37&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>
		<td <?php if($page37=="0"){echo 'class="alter_red"';}else{echo 'class="alter"';}?>><a href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=37-Alter&date=<?php echo $_GET['date']; ?>"><img src="Images/Edit.png" border="0"></a></td>
	  </tr>
	  <tr>	  
		<td <?php if($page38=="0"){echo 'class="mdspage_red"';}else{echo 'class="mdspage"';}?>><form><input type="button" value="Page 38" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=38&date=<?php echo $_GET['date']; ?>'"></form></td>
		<td <?php if($page38=="0"){echo 'class="print_red"';}else{echo 'class="print"';}?>><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=38&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>
		<td <?php if($page38=="0"){echo 'class="alter_red"';}else{echo 'class="alter"';}?>><a href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=38-Alter&date=<?php echo $_GET['date']; ?>"><img src="Images/Edit.png" border="0"></a></td>
	  </tr>
	  <tr>	  
		<td <?php if($page39=="0"){echo 'class="mdspage_red"';}else{echo 'class="mdspage"';}?>><form><input type="button" value="Page 39" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=39&date=<?php echo $_GET['date']; ?>'"></form></td>
		<td <?php if($page39=="0"){echo 'class="print_red"';}else{echo 'class="print"';}?>><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=39&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>
		<td <?php if($page39=="0"){echo 'class="alter_red"';}else{echo 'class="alter"';}?>><a href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=39-Alter&date=<?php echo $_GET['date']; ?>"><img src="Images/Edit.png" border="0"></a></td>
	  </tr>
      <tr>
		<td class="mdssection" rowspan="2"><form><input type="button" value="Section Z :&nbsp Assessment Administration" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=SectionZ&date=<?php echo $_GET['date']; ?>'" /></form></td>
	    <td class="function" rowspan="2"><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=SectionZ&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>  
		<td <?php if($page40=="0"){echo 'class="mdspage_red"';}elseif($page40=="1"){echo 'class="mdspage_yellow"';}else{echo 'class="mdspage"';}?>><form><input type="button" value="Page 40" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=40&date=<?php echo $_GET['date']; ?>'"></form></td>
		<td <?php if($page40=="0"){echo 'class="print_red"';}elseif($page40=="1"){echo 'class="print_yellow"';}else{echo 'class="print"';}?>><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=40&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>
		<td <?php if($page40=="0"){echo 'class="alter_red"';}elseif($page40=="1"){echo 'class="alter_yellow"';}else{echo 'class="alter"';}?>><a href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=40-Alter&date=<?php echo $_GET['date']; ?>"><img src="Images/Edit.png" border="0"></a></td>
	  </tr>
	  <tr>	  
		<td <?php if($page41=="0"){echo 'class="mdspage_red"';}else{echo 'class="mdspage"';}?>><form><input type="button" value="Page 41" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=41&date=<?php echo $_GET['date']; ?>'"></form></td>
		<td <?php if($page41=="0"){echo 'class="print_red"';}else{echo 'class="print"';}?>><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=41&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>
		<td <?php if($page41=="0"){echo 'class="alter_red"';}else{echo 'class="alter"';}?>><a href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=41-Alter&date=<?php echo $_GET['date']; ?>"><img src="Images/Edit.png" border="0"></a></td>
	  </tr>
	  <tr>
		<td class="mdssection" rowspan="2"><form><input type="button" value="Section S :&nbsp Massachusetts State-Specific Items" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=SectionS&date=<?php echo $_GET['date']; ?>'" /></form></td>
	    <td class="function" rowspan="2"><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=SectionS&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>
		<td <?php if($page42=="0"){echo 'class="mdspage_red"';}else{echo 'class="mdspage"';}?>><form><input type="button" value="Page 42" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=42&date=<?php echo $_GET['date']; ?>'"></form></td>
		<td <?php if($page42=="0"){echo 'class="print_red"';}else{echo 'class="print"';}?>><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=42&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>
		<td <?php if($page42=="0"){echo 'class="alter_red"';}else{echo 'class="alter"';}?>><a href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=42-Alter&date=<?php echo $_GET['date']; ?>"><img src="Images/Edit.png" border="0"></a></td>
	  </tr>
	  <tr>
		<td <?php if($page43=="0"){echo 'class="mdspage_red"';}else{echo 'class="mdspage"';}?>><form><input type="button" value="Page 43" onclick="location.href='index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=43&date=<?php echo $_GET['date']; ?>'"></form></td>
		<td <?php if($page43=="0"){echo 'class="print_red"';}else{echo 'class="print"';}?>><a href="print.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'] ;?>&id=43&date=<?php echo $_GET['date'] ;?>" target="_blank"><img src="Images/print.png" border="0"></a></td>
		<td <?php if($page43=="0"){echo 'class="alter_red"';}else{echo 'class="alter"';}?>><a href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=43-Alter&date=<?php echo $_GET['date']; ?>"><img src="Images/Edit.png" border="0"></a></td>
	  </tr>
    </table>
	<br>
	<br>
  </div>
<?php
  }else{
	$db = new DB;
	$db->query("SELECT * FROM `mdsform99` WHERE `HospNo`='".$HospNo."' ORDER BY `date` DESC");
	if($db->num_rows()>0){
		$r = $db->fetch_assoc();
		$r['date'] = str_replace('-','',$r['date']);
		?>
		<script>
        document.location.href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=<?php echo $_GET['id']; ?>&date=<?php echo $r['date'];?>";
        </script>
		<?php
	}else{
	  echo '
	  <div><br><br>
	    <table>
	      <tr>
	        <td>
		      Not have any record.
		    </td>
		  </tr>
		  <tr>
			<td>
		      Please click the button to preduce MDS.
		    </td>
	      </tr>
	    </table><br><br><br><br>
	  </div>
	  ';		
	}
  }
?>