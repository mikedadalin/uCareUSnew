$(function(){
  var w = $("#slider_content").width();
  $('#slider_content').css('height', ($(window).height() - 20) + 'px' ); //將區塊自動撐滿畫面高度
 
  $("#slider_tab").mouseover(function(){ //滑鼠滑入時
    if ($("#slider_scroll").css('right') == '-'+w+'px')
    {
      $("#slider_scroll").animate({ right:'0px' }, 600 ,'swing');
    }
  });
  $("#slider_content").mouseleave(function(){　//滑鼠離開後
    $("#slider_scroll").animate( { right:'-'+w+'px' }, 600 ,'swing');  
  }); 
});