<script type="text/javascript" src="js/jquery.appendDom.js"></script>
<script>
$(function () {
	//Title
	var jsArray  = ["<?php echo join("\", \"", $tmpArr); ?>"];

	
//	var aa=[{
//      tagName : 'table',
//      childNodes : [{
//        tagName : 'tbody',  // tbody is needed for Internet Exlorer
//        childNodes : [{
//			tagName : 'tr', 
//		}]
//      }]
//    }];
//	
//    for (i in jsArray) {              
//      aa[0].childNodes.push({  // now push a new object onto the 
//        tagName : 'th',              // childNodes array with each iteration.
//		className:'title',
//		width:'150',		
//		height:'30',
//		valign:'middle',
//        innerHTML : jsArray[i]          
//      });
//    }	
//    $('#test').appendDom(aa);
	
    var myTitleDom = [{
      tagName:'table', childNodes:[{
        tagName:'tbody', childNodes:[{
		tagName:'tr', childNodes:[{
		  tagName:'th', className:'title', width:'100', innerHTML:jsArray[0]},{	
		  tagName:'th', className:'title', width:'100', innerHTML:jsArray[1]},{
		  tagName:'th', className:'title', width:'100', innerHTML:jsArray[2]},{	
		  tagName:'th', className:'title', width:'100', innerHTML:jsArray[3]},{	
		  tagName:'th', className:'title', width:'200', innerHTML:jsArray[4]},{	
		  tagName:'th', className:'title', width:'100', innerHTML:jsArray[5]},{	
		  tagName:'th', className:'title', width:'150', innerHTML:jsArray[6]},{	
		  }]
        }]//
      }],
    }];
	$('#myTitle').appendDom(myTitleDom);	
  
  var count = 0;
  
  // Create Block
  $('#addFile').click(function() {

    count++;

    var myTableDom = [{
      tagName:'table', id:'block' + count, className:'a1', childNodes:[{
        tagName:'tbody', childNodes:[{
          tagName:'tr', childNodes:[{            
              tagName:'td', width:'100', childNodes:[{//tmp1						  
			  tagName:'input', type:'text', size:'12', id:'tmp1' + count, name:'tmp1' + count}]},{
              tagName:'td', width:'100', childNodes:[{//tmp2						  
			  tagName:'input', type:'text', size:'12', id:'tmp2' + count, name:'tmp2' + count}]},{
              tagName:'td', width:'100',  childNodes:[{//tmp3						  
			  tagName:'input', type:'text', size:'12', id:'tmp3' + count, name:'tmp3' + count}]},{
              tagName:'td', width:'100',  childNodes:[{//tmp4						  
			  tagName:'input', type:'text', size:'12', id:'tmp4' + count, name:'tmp4' + count}]},{
              tagName:'td', width:'200',  childNodes:[{//tmp5						  
			  tagName:'input', type:'text', size:'30', id:'tmp5' + count, name:'tmp5' + count}]},{
              tagName:'td', width:'100',  childNodes:[{//tmp6						  
			  tagName:'input', type:'text', size:'10', id:'tmp6' + count, name:'tmp6' + count, readonly:'readonly'}]},{
              tagName:'td', width:'150',  childNodes:[{//tmp7						  
			  tagName:'input', type:'text', size:'10', id:'tmp7' + count, name:'tmp7' + count, value:'<?php echo checkusername($_SESSION['ncareID_lwj']);?>', readonly:'readonly'},{
			  tagName:'input', type:'button', onclick:function (){ $(this).parents('.a1').remove();S_AMT1();}, value:' Remove '},{
			  },]},{
          }]
        }, {

        }]//
      }],
    }];
    $('#myFile').appendDom(myTableDom);		
    $('#fileCount').val(count);
  });
});
</script>

<table align="left"  width="100%" style="font-size:10pt; margin-left:0px; margin-bottom:10px;">
  <TBODY>
  <tr>
    <td>
      <div id="myTitle"></div>
      <div id="myFile"></div>
    </td>
  </tr>
  <TR>
    <TD>    
        <input type="button" id="addFile" name="addFile" value=" Add new<?php echo $tmpName;?> ">
    </TD>
  </TR>
  </TBODY>
</TABLE>
<input type="hidden" id="fileCount" name="fileCount">
