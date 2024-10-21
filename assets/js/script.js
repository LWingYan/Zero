$(document).ready(function(){
    // 当文档滚动时，显示返回顶部按钮
    $(window).scroll(function(){
        if ($(this).scrollTop() > 100) { // 如果用户滚动超过100px，则显示按钮
            $('#back-to-top').fadeIn();
        } else {
            $('#back-to-top').fadeOut();
        }
    });

    // 点击返回顶部按钮，平滑滚动到页面顶部
    $('#back-to-top').click(function(){
        $('html, body').animate({scrollTop: 0}, 800); // 800ms内滚动到顶部
        return false; // 阻止默认的跳转行为
    });
});