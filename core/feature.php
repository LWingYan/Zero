<?php 
/**
 * 主题功能
 * 
 * @author 林孽
 * 
 * 2024/07/28
 * 
 */
Typecho_Plugin::factory('admin/write-post.php')->bottom = array('Editor', 'edit');
Typecho_Plugin::factory('admin/write-page.php')->bottom = array('Editor', 'edit');
class Editor
{
    public static function edit()
    {
        echo "<link rel='stylesheet' href='" . Helper::options()->themeUrl . '/assets/typecho/option.css' . "'>";
        echo "<script src='" . Helper::options()->themeUrl . '/assets/typecho/editor.js' . "'></script>";

    }
}
function cat_check_XSS($text)
{
    $isXss = false;
    $list = array(
        '/onabort/is',
        '/onblur/is',
        '/onchange/is',
        '/onclick/is',
        '/ondblclick/is',
        '/onerror/is',
        '/onfocus/is',
        '/onkeydown/is',
        '/onkeypress/is',
        '/onkeyup/is',
        '/onload/is',
        '/onmousedown/is',
        '/onmousemove/is',
        '/onmouseout/is',
        '/onmouseover/is',
        '/onmouseup/is',
        '/onreset/is',
        '/onresize/is',
        '/onselect/is',
        '/onsubmit/is',
        '/onunload/is',
        '/eval/is',
        '/ascript:/is',
        '/style=/is',
        '/width=/is',
        '/width:/is',
        '/height=/is',
        '/height:/is',
        '/src=/is',  
    );
    if (strip_tags($text)) {
        for ($i = 0; $i < count($list); $i++) {
            if (preg_match($list[$i], $text) > 0) {
                $isXss = true;
                break;
            }
        }
    } else {
        $isXss = true;
    };
    return $isXss;
}
function cat_reply($text,$word = true)
{
    if (cat_check_XSS($text)) {
        $text = "该回复疑似异常，已被系统拦截！";
    }
    if($word == true){
        $text = strip_tags($text, "<img>");
    }else{
        $text = rtrim(strip_tags($text), "\n");
    }
    return $text;
}
function article_changetext($post, $login){
    $content = $post->content;
    $cid = $post->cid;
    $content = preg_replace('/{{([\s\S]*?)}{([\s\S]*?)}}/', '<span class="e" cat_title="${2}">${1}</span>' , $content);

    $content = preg_replace('/{cat_bili p="([\s\S]*?)" key="([\s\S]*?)"}/', '<article_video><iframe src="https://www.bilibili.com/blackboard/html5mobileplayer.html?bvid=${2}&amp;page=${1}&amp;as_wide=1&amp;danmaku=0&amp;hasMuteButton=1" scrolling="no" border="0" frameborder="no" width="100%" height="280px" framespacing="0" allowfullscreen="true"></iframe></article_video>', $content);
    
    $content = preg_replace('/{photos}([\s\S]*?){\/photos}/','<waterfall>${1}</waterfall>',$content);
    
    $content = preg_replace_callback(
        '/<p><waterfall>([\s\S]*?)<\/waterfall><\/p>/',
        function ($matches) {
            // $matches[1] 包含 <cat_waterfall> 和 </cat_waterfall> 之间的内容
            // 理论上，这里不应该包含<p>标签，因为它们被外层的<p>包裹了
            // 但如果出于某种原因您想要确保去除它们，可以这样做：
            $innerCleanedContent = preg_replace('/<p\b[^>]*>/i', '', $matches[1]); // 去除<p>标签
            $innerCleanedContent = preg_replace('/<\/p\s*>/i', '', $innerCleanedContent); // 去除</p>标签
            
            // 再去掉 $innerCleanedContent 中的 <br> 标签
            $cleanedContent = preg_replace('/<br\s*\/?>/i', '', $innerCleanedContent);
            
            // 返回去除了 <p> 和 <br> 标签的 <cat_waterfall>...</cat_waterfall> 结构
            // 但请注意，这里的<p>去除步骤可能是多余的
            return '<waterfall>' . $cleanedContent . '</waterfall>';
        },
        $content
    );
    
    
    $content = preg_replace('/<img src([\s\S]*?)title="([\s\S]*?)">/', '<post_image><img class="shadow-lg border-solid border-black border-2 roundedaB object-cover postimg isfancy lazyload" data-src${1}></post_image>', $content);
    
    // 这段代码的目的是在字符串$content中查找所有被<p>标签包裹的<cat_post_image>...</cat_post_image>自定义标签，并将它们替换为只保留<cat_post_image>...</cat_post_image>部分（移除了外层的<p>标签）。
    $content = preg_replace('/<p><post_image([\s\S]*?)<\/post_image><\/p>/', '<post_image$1</post_image>', $content);
    
    
    $content = preg_replace('/<p>([\s\S]*?)<\/p>/', '<p class="py-3">${1}</p>', $content);


    // 所有具有class、data-src、和alt属性的<img>标签，并将它们替换为一个<span>标签，该<span>标签包含了一个修改后的<img>标签，并且添加了一些新的属性（data-fancybox="gallery"和data-caption
    $content = preg_replace('/<img class="(.*?) object-cover rounded" width="100%" data-src="(.*?)" alt="(.*?)"(.*?)>/', '<span data-fancybox="gallery" data-caption="${3}"><img width="100%" data-src="${2}" class="shadow-lg border-solid border-black border-2 roundedaB ${1} object-cover" alt="${3}"></span>', $content); 
    

    // [\s\S]*?)：这是一个捕获组，用于匹配<cat_post_image>和</cat_post_image>之间的任何字符（包括换行符，因为[\s\S]匹配任何空白字符或非空白字符，即所有字符）
    // 
    echo $content;
}

/* 获取文章摘要 */
function _getAbstract($item, $num)
{
	$abstract = "";
	if ($item->password) {
		$abstract = "⚠️此文章已加密";
	} else {
		if ($item->fields->post_abstract) {
			$abstract = $item->fields->post_abstract;
		} else {
			$abstract = strip_tags($item->excerpt);
			$abstract = preg_replace('/\-o\-/', '', $abstract);
            $abstract = preg_replace('/{[^{]+}/', '', $abstract);
		}
	}
	if ($abstract === '') $abstract = "此文章暂无简介";
	return mb_substr($abstract, 0, $num);
}