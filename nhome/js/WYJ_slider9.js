$(function(){
  var w = $("#slider_content9").width();
  $('#slider_content9').css('height', ($(window).height() - 20) + 'px' ); //將區塊自動撐滿畫面高度
 
  $("#slider_tab9").mouseover(function(){ //滑鼠滑入時
    if ($("#slider_scroll9").css('right') == '-'+w+'px')
    {
      $("#slider_scroll9").animate({ right:'0px' }, 600 ,'swing');
    }
  });
  $("#slider_content9").mouseleave(function(){　//滑鼠離開後
    $("#slider_scroll9").animate( { right:'-'+w+'px' }, 600 ,'swing');
  });
});