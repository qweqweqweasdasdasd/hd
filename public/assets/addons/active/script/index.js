$(document).ready(function(){
	window.setTimeout(function(){
		$(".loading").fadeOut(500)
	},400)
	$(".lunleft").lunleftFn({time: 15});
	$(".luntop").luntopFn({time: 15});
  
  function getTime() {
    var nowDate = new Date(new Date().getTime() - 43200000),
    nY = nowDate.getFullYear(),
    nM = nowDate.getMonth() + 1,
    nD = nowDate.getDate(),
    nH = nowDate.getHours(),
    nMi = nowDate.getMinutes(),
    nS = nowDate.getSeconds();
    nM = nM < 10 ? '0' + nM : nM;
    nD = nD < 10 ? '0' + nD : nD;
    nH = nH < 10 ? '0' + nH : nH;
    nMi = nMi < 10 ? '0' + nMi : nMi;
    nS = nS < 10 ? '0' + nS : nS;
  
    var fullTime = nY + '-' + nM + '-' + nD + ' ' + nH + ':' + nMi + ':' + nS;
    $('#nowTime').text(fullTime);
  }
  
  setInterval(getTime, 1000);
  
  $(window).scroll(function () {
    var sc = $(window).scrollTop();
    $(".rightdao").stop().animate({
      top: sc + 200
    }, 400);
  });
  $(".closedao").click(function () {
    $(this).parent().hide();
  });
  
  $(".totop").click(function () {
    $("html,body").stop().animate({
      scrollTop: 0
    }, 300)
  })
})



 