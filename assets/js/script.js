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

    // 获取 <book> 元素
    var $book = $('book');
    var doubanId = $book.data('doubanid');
    // 检查是否存在 <book> 标签以及是否有豆瓣 ID
    if ($book.length && doubanId) {
        // 在 <book> 元素后面插入一个新的 <div> 用于显示书籍信息
        $book.after('<div id="book-info"><p>正在加载书籍信息...</p></div>');

        // 发起 AJAX 请求，获取书籍信息
        $.ajax({
            url: themeUrl+'core/fetch-douban-info.php',  // 替换为你的 PHP 脚本路径
            type: 'GET',
            data: {
                info_type: 'book',
                book_id: doubanId
            },
            dataType: 'json',
            success: function(response) {
                // 根据返回的 JSON 数据更新页面内容
                if (response.title) {
                    $('#book-info').html(
                        '<img src="' + response.image + '" alt="' + response.title + '" referrerpolicy="no-referrer" />' +
                        '<div><h2>' + response.title + '</h2>' +
                        '<p>作者: ' + response.author + '</p>' +
                        '<p>出版日期: ' + response.pubdate + '</p>' +
                        '<p>简介: ' + response.summary + '</p></div>'
                    );
                } else {
                    $('#book-info').html('<p>无法获取书籍信息</p>');
                }
            },
            error: function() {
                $('#book-info').html('<p>获取书籍信息失败</p>');
            }
        });
    }
});