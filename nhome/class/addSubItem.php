<script type="text/javascript" src="js/jquery.appendDom.js"></script>
<script>
$(function () {
	//Title
	var jsArray = ["<?php echo join("\", \"", $tmpArr); ?>"];
	var myTitleDom=[{
      tagName : 'table',
	  style:'margin-top:-20px;',
      childNodes : [{
        tagName : 'tbody',  // tbody is needed for Internet Exlorer
        childNodes : [{
			tagName : 'tr', 
		}]
      }]
    }];
	
    for (i in jsArray) {
	  myTitleDom[0].childNodes.push({  // now push a new object onto the 	  
		tagName : 'th',              // childNodes array with each iteration.
		className:'title',
		width:'150',		
		height:'30',
		valign:'middle',
		id:'tmp' + i,
		innerHTML : jsArray[i]          	  
	  });
    }
	myTitleDom[0].childNodes.push({  // now push a new object onto the 
		tagName : 'th',              // childNodes array with each iteration.
		className:'title',
		width:'60',	
		height:'30',	
		valign:'middle',
		innerHTML : 'Function'          
	});
	
	$('#myTitle').appendDom(myTitleDom);	
  
  var count = 0;
  
  // Create Block
  $('#addFile').click(function() {

    count++;
	
	var myTableDom=[{
      tagName : 'table',
	  id:'block' + count, 
	  className:'a1',
	  style:'margin-top:-40px;',
      childNodes : [{
        tagName : 'tbody',  // tbody is needed for Internet Exlorer
        childNodes : [{
			tagName : 'tr', 
		}]
      }]
    }];
	
    for (i in jsArray) {
		  myTableDom[0].childNodes.push({  // now push a new object onto the 
			tagName : 'td',              // childNodes array with each iteration.
			width:'150',		
			valign:'middle',
			childNodes : [{
				tagName:'input', 
				type:'text',
				className:'validate[required]', 
				size:'30', 
				id:'tmp_' + i + '_' + count, 
				name:'tmp_' + i + '_' + count,
			}]
		  });
    }	
	  myTableDom[0].childNodes.push({  // now push a new object onto the 
		tagName : 'td',              // childNodes array with each iteration.
		width:'30',		
		valign:'middle',
		childNodes : [{
			tagName:'input', 
			type:'button', 
			onclick:function (){ $(this).parents('.a1').remove();}, 
			id:'tmp_' + i + '_' + count, 
			name:'tmp_' + i + '_' + count,
			value:' Remove ',
		}]
	  });
	  
    $('#myFile').appendDom(myTableDom);
    $('#fileCount').val(count);
	
	for (i in jsArray) {
		if(jsArray[i]=='Date'){
			$('#tmp_' + i + '_'  + count).datepicker();
			$('#tmp_' + i + '_'  + count).attr('size', '10');
			$('#tmp' + i).attr('width', '120');
		}else if(jsArray[i]=='Filled by'){
			$('#tmp_' + i + '_'  + count).attr('size', '10').attr('readonly', true);
			$('#tmp_' + i + '_'  + count).val('<?php echo checkusername($_SESSION['ncareID_lwj']);?>');
		}else if(jsArray[i]=='Time'){
			$('#tmp' + i).attr('width', '80');
			var timeH = '<select id="tmp'+ i + count+'H" name="tmp'+ i + count+'H">';
          		timeH +='<?php
						for ($i2a=0;$i2a<=23;$i2a++) { 
							echo '<option value="'.$i2a.'" '.(date(H)==$i2a?" selected":"").'>'.(strlen($i2a)==1?'0':'').$i2a.'</option>'; 
						}
		  				echo '</select>';
		  				?>';
			var timeI = '<select id="tmp'+ i + count+'I" name="tmp'+ i + count+'I">';
          		timeI +='<option value="00" selected>00</option>';
				timeI +='<option value="15">15</option>';
				timeI +='<option value="30">30</option>';
				timeI +='<option value="45">45</option>';
				timeI +='</select>';
			var time = timeH +'：'+ timeI;
			$('#tmp_' + i + '_'  + count).replaceWith(time);
		}
	}
  });
});
</script>

<table align="left"  width="100%" style="font-size:10pt; margin-left:0px;" class="printcol">
  <TBODY>
  <tr>
    <td>
      <div id="myTitle"></div>
      <div id="myFile"></div>
    </td>
  </tr>
  <TR>
    <TD>
        <?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?>
		<input type="button" id="addFile" name="addFile" value="Add<?php echo $tmpName;?> ">
		<?php }?>
    </TD>
  </TR>
  </TBODY>
</TABLE>
<input type="hidden" id="fileCount" name="fileCount">