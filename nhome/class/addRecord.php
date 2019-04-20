<script type="text/javascript" src="js/jquery.appendDom.js"></script>
<script>

// Create Block
function addRow(id) {
    var count = $('#fileCount_'+id).val();
	count++;
	
    var myTableDom = [{
    	tagName:'table', id:'block' + count, className:'a1',width:'100', childNodes:[{
        	tagName:'tbody', childNodes:[{
				tagName:'tr', childNodes:[{
					tagName:'td',width:'150', childNodes:[{
						tagName:'input', type:'text', size:'15', id:'tmp1_' + id + '_' + count, name:'tmp1_' + id + '_' + count}]},{
					tagName:'td', childNodes:[{
						tagName:'div', id:'tmpdiv_' + id + '_' + count, childNodes:[{
							tagName:'input', type:'radio', id:'tmp2a_' + id + '_' + count, name:'tmp2_' + id + '_' + count, value:'1'},{
							tagName:'label', for:'tmp2a_' + id + '_' + count, innerHTML:'◎ Mothballs'},{
							tagName:'input', type:'radio', id:'tmp2b_' + id + '_' + count, name:'tmp2_' + id + '_' + count, value:'2'},{
							tagName:'label', for:'tmp2b_' + id + '_' + count, innerHTML:'&Delta; Insecticide'},{
							tagName:'input', type:'radio', id:'tmp2c_' + id + '_' + count, name:'tmp2_' + id + '_' + count, value:'3'},{
							tagName:'label', for:'tmp2c_' + id + '_' + count, innerHTML:'&equiv; Bleach'}
						]}
					]},{
					tagName:'td', childNodes:[{						  
						tagName:'div', id:'tmpdiv3_' + id + '_' + count, childNodes:[{
							tagName:'input', type:'radio', id:'tmp3a_' + id + '_' + count, name:'tmp3_' + id + '_' + count, value:'Spider'},{
							tagName:'label', for:'tmp3a_' + id + '_' + count, innerHTML:'Spider'},{
							tagName:'input', type:'radio', id:'tmp3b_' + id + '_' + count, name:'tmp3_' + id + '_' + count, value:'Worm & bug'},{
							tagName:'label', for:'tmp3b_' + id + '_' + count, innerHTML:'Worm & bug'},{
							tagName:'input', type:'radio', id:'tmp3c_' + id + '_' + count, name:'tmp3_' + id + '_' + count, value:'Ant'},{
							tagName:'label', for:'tmp3c_' + id + '_' + count, innerHTML:'Ant'},{
							tagName:'br'},{
							tagName:'input', type:'radio', id:'tmp3d_' + id + '_' + count, name:'tmp3_' + id + '_' + count, value:'Butterfly'},{
							tagName:'label', for:'tmp3d_' + id + '_' + count, innerHTML:'Butterfly'},{
							tagName:'input', type:'radio', id:'tmp3e_' + id + '_' + count, name:'tmp3_' + id + '_' + count, value:'Cockroach'},{
							tagName:'label', for:'tmp3e_' + id + '_' + count, innerHTML:'Cockroach'},{
							tagName:'input', type:'radio', id:'tmp3f_' + id + '_' + count, name:'tmp3_' + id + '_' + count, value:'Other'},{
							tagName:'label', for:'tmp3f_' + id + '_' + count, innerHTML:'Other'}
						]
					},{
							//tagName:'input', type:'text', size:'30', id:'tmp3_' + id + '_' + count, name:'tmp3_' + id + '_' + count}, {
							tagName:'input', type:'button', onclick:function (){ $(this).parents('.a1').remove();S_AMT1();}, value:' Remove '}]
				}]
			}]
        }]//  
    }];
    $('#myFile_' + id).appendDom(myTableDom);
	$('#tmpdiv_' + id + '_' + count).buttonset();
	$('#tmpdiv3_' + id + '_' + count).buttonset().find('label').width(130);	
    $('#fileCount_'+id).val(count);
}
</script>
<table align="left"  width="100%" style="font-size:10pt; margin-left:0px;">
  <TBODY>
  <tr>
    <td>
      <div id="myFile_<?php echo $r['cID'];?>"></div>
    </td>
  </tr>
  <TR>
    <TD>
        <input type="button" id="addFile_<?php echo $r['cID'];?>" name="addFile_<?php echo $r['cID'];?>" onclick="addRow('<?php echo $r['cID'];?>');" value=" Add location(Any place)">
    </TD>
  </TR>
  </TBODY>
</TABLE>
<input type="hidden" id="fileCount_<?php echo $r['cID'];?>" name="fileCount_<?php echo $r['cID'];?>">

