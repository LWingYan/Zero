<?php
require_once "core/feature.php";
require_once "core/factory.php";
require_once "core/Parsedown.php";
require_once "core/Config.php";
Typecho_Plugin::factory('admin/write-post.php')->bottom = array('tagshelper', 'tagslist');
class tagshelper {
    public static function tagslist()
    {      
    $tag="";$taglist="";$i=0;//循环一次利用到两个位置
Typecho_Widget::widget('Widget_Metas_Tag_Cloud', 'sort=count&desc=1&limit=200')->to($tags);
while ($tags->next()) {
$tag=$tag."'".$tags->name."',";
$taglist=$taglist."<a id=".$i." onclick=\"$(\'#tags\').tokenInput(\'add\', {id: \'".$tags->name."\', tags: \'".$tags->name."\'});\">".$tags->name."</a>";
$i++;
}
?><style>.Posthelper a{cursor: pointer; padding: 0px 6px; margin: 2px 0;display: inline-block;border-radius:var(--radius)!important;text-decoration: none;}
.Posthelper a:hover{background:var(--theme);color:var(--main);}.fullscreen #tab-files{right: 0;}/*解决全屏状态下鼠标放到附件上传按钮上导致的窗口抖动问题*/
</style>
<script>
  function chaall () {
   var html='';
 $("#file-list li .insert").each(function(){
   var t = $(this), p = t.parents('li');
   var file=t.text();
   var url= p.data('url');
   var isImage= p.data('image');
   if ($("input[name='markdown']").val()==1) {
   html = isImage ? html+'\n!['+file+'](' + url + ')\n':''+html+'';
   }else{
   html = isImage ? html+'<img src="' + url + '" alt="' + file + '" />\n':''+html+'';
   }
    });
   var textarea = $('#text');
   textarea.replaceSelection(html);return false;
    }
 
    function chaquan () {
   var html='';
 $("#file-list li .insert").each(function(){
   var t = $(this), p = t.parents('li');
   var file=t.text();
   var url= p.data('url');
   var isImage= p.data('image');
   if ($("input[name='markdown']").val()==1) {
   html = isImage ? html+'':html+'\n['+file+'](' + url + ')\n';
   }else{
   html = isImage ? html+'':html+'<a href="' + url + '"/>' + file + '</a>\n';
   }
    });
   var textarea = $('#text');
   textarea.replaceSelection(html);return false;
    }
function filter_method(text, badword){
    //获取文本输入框中的内容
    var value = text;
    var res = '';
    //遍历敏感词数组
    for(var i=0; i<badword.length; i++){
        var reg = new RegExp(badword[i],"g");
        //判断内容中是否包括敏感词        
        if (value.indexOf(badword[i]) > -1) {
            $('#tags').tokenInput('add', {id: badword[i], tags: badword[i]});
        }
    }
    return;
}
var badwords = [<?php echo $tag; ?>];
function chatag(){
var textarea=$('#text').val();
filter_method(textarea, badwords); 
}
  $(document).ready(function(){
    $('#file-list').after('<div class="Posthelper"><a class="w-100" onclick=\"chaall()\" style="background: var(--main);background-color:var(--theme);text-align: center; padding: 5px 0; color: #fbfbfb;">插入所有图片</a><a class="w-100" onclick=\"chaquan()\" style="background:var(--main);background-color:var(--theme);text-align:center; padding:5px 0; color:#fbfbfb;">插入所有非图片附件</a></div>');
    $('#tags').after('<div style="margin-top: 35px;" class="Posthelper"><ul style="border-radius:var(--radius)!important;list-style:none;min-height:100px;padding:6px 12px; max-height:240px;overflow:auto;background-color:var(--theme);margin-bottom:0;"><?php echo $taglist; ?></ul><a class="w-100" onclick=\"chatag()\" style="background:var(--main);background-color:var(--theme);text-align:center; padding:5px 0; color:#fbfbfb;">检测内容插入标签</a></div>');
  }); 
  </script>
<?php
    }
}
/* 初始化主题 */
function themeInit(Widget_Archive $archive)
{
  //暴力解决访问加密文章会被 pjax 刷新页面的问题
  if ($archive->hidden) header('HTTP/1.1 200 OK');
  Helper::options()->commentsMaxNestingLevels = 2;
  //强制评论关闭反垃圾保护
  Helper::options()->commentsAntiSpam = false;
  //将最新的评论展示在前
  Helper::options()->commentsOrder = 'DESC';
  //关闭检查评论来源URL与文章链接是否一致判断
  Helper::options()->commentsCheckReferer = false;
  // 强制开启评论markdown
  Helper::options()->commentsMarkdown = '1';
  Helper::options()->commentsHTMLTagAllowed .= '<img class src alt><div class>';
  //评论显示列表
  Helper::options()->commentsListSize = 5;
}
  
/* 获取资源路径 */
function _getAssets($assets, $type = true)
{
  $assetsURL = "";
  // 是否本地化资源
  if (Helper::options()->AssetsURL) {
    $assetsURL = Helper::options()->AssetsURL . '/' . $assets;
  } else {
    $assetsURL = Helper::options()->themeUrl . '/' . $assets;
  }
  if ($type) echo $assetsURL;
  else return  $assetsURL;
}
/*人性化时间*/
function human_time_diff($from, $to = '') {
    if (empty($to)) {
        $to = time();
    }
    $diff = abs($to - $from);
    $day_diff = floor($diff / 86400);
    if ($day_diff >= 1) {
        if ($day_diff == 1) {
            return '昨天';
        }
        return ' ' . $day_diff . ' 天前';
    }
    $hour_diff = floor(($diff - $day_diff * 86400) / 3600);
    if ($hour_diff >= 1) {
        if ($hour_diff == 1) {
            return ' 1 小时前';
        }
        return ' ' . $hour_diff . ' 小时前';
    }
    $minute_diff = floor(($diff - $day_diff * 86400 - $hour_diff * 3600) / 60);
    if ($minute_diff >= 1) {
        if ($minute_diff == 1) {
            return ' 1 分钟前';
        }
        return ' ' . $minute_diff . ' 分钟前';
    }
    return ' 刚刚';
}
/**
 * 处理字符串超长问题
 */
function subText($text, $maxlen)
{
    if (mb_strlen($text) > $maxlen) {
        echo mb_substr($text, 0, $maxlen) . '...';
    } else {
        echo $text;
    }
}
/* 通过邮箱生成头像地址 
  <?php _getAvatarByMail($this->author->mail) ?>
  <?php _getAvatarByMail($comments->mail) ?>
*/
function _getAvatarByMail($mail)
{
  $gravatarsUrl = Helper::options()->CustomAvatarSource ? Helper::options()->CustomAvatarSource : 'https://gravatar.helingqi.com/wavatar/';
  $mailLower = strtolower($mail);
  $md5MailLower = md5($mailLower);
  $qqMail = str_replace('@qq.com', '', $mailLower);
  if (strstr($mailLower, "qq.com") && is_numeric($qqMail) && strlen($qqMail) < 11 && strlen($qqMail) > 4) {
    echo 'https://thirdqq.qlogo.cn/g?b=qq&nk=' . $qqMail . '&s=100';
  } else {
    echo $gravatarsUrl . $md5MailLower . '?d=mm';
  }
};
function get_comment_at($coid)
{//评论@函数
    $db   = Typecho_Db::get();
    $prow = $db->fetchRow($db->select('parent')->from('table.comments')
                                 ->where('coid = ?', $coid));
    $parent = $prow['parent'];
    if (!empty($parent)) {
        $arow = $db->fetchRow($db->select('author')->from('table.comments')
                                     ->where('coid = ? AND status = ?', $parent, 'approved'));
if(!empty($arow['author'])){ $author = $arow['author'];
        $href   = '<a style="color:#CD919E;border-bottom:0;" class="text-xs px-1 bg-tertiaryA text-gray rounded " href="#comment-' . $parent . '">@' . $author . '</a> ';
        return $href;
}else { return '';}
    } else {
        return '';
    }
}
/**
 * 判断当前是菜单否激活
 * @param $self
 * @return string
 */
function isActiveMenu($self, $slug) : string {
    $activeMenuClass = " active ";
    // 检查当前页面是否是分类页面且slug匹配
    if ($self->is("category") && $self->getArchiveSlug() === $slug) {
        return $activeMenuClass;
    }
    // 检查当前页面是否是文章页面且文章属于给定的分类slug
    if ($self->is("post") && in_array($slug, array_column($self->categories, "slug"))) {
        return $activeMenuClass;
    }
    // 如果都不是，‌返回空字符串
    return "";
}
/* 查询文章浏览量 */
function get_post_view($archive)
{
    $cid    = $archive->cid;
    $db     = Typecho_Db::get();
    $prefix = $db->getPrefix();
    if (!array_key_exists('views', $db->fetchRow($db->select()->from('table.contents')->page(1,1)))) {
        $db->query('ALTER TABLE `' . $prefix . 'contents` ADD `views` INT(10) DEFAULT 0;');
        echo 0;
        return;
    }
    $row = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid));
    if ($archive->is('single')) {
 $views = Typecho_Cookie::get('extend_contents_views');
        if(empty($views)){
            $views = array();
        }else{
            $views = explode(',', $views);
        }
if(!in_array($cid,$views)){
       $db->query($db->update('table.contents')->rows(array('views' => (int) $row['views'] + 1))->where('cid = ?', $cid));
array_push($views, $cid);
            $views = implode(',', $views);
            Typecho_Cookie::set('extend_contents_views', $views); //记录查看cookie
        }
    }
    echo $row['views'];
}

/* 增加自定义字段 */
function themeFields($layout)
{
    $article_type= new Typecho_Widget_Helper_Form_Element_Radio('article_type',array('0' => _t('文章'),'photos' => _t('多图/相册'),'aplayer' => _t('音乐')),'0',_t('文章类型'),_t("选择文章类型首页输出"));
    $layout->addItem($article_type);
    
    $keywords = new Typecho_Widget_Helper_Form_Element_Text(
    'keywords',
    NULL,
    NULL,
    'SEO关键词',
    '介绍：用于设置当前页SEO关键词 <br />
        注意：多个关键词使用英文逗号进行隔开 <br />
        例如：Typecho,Typecho主题,Typecho模板 <br />
        其他：如果不填写此项，则默认取文章标签'
    );
    $layout->addItem($keywords);

    $description = new Typecho_Widget_Helper_Form_Element_Textarea(
    'description',
    NULL,
    NULL,
    'SEO描述语',
    '介绍：用于设置当前页SEO描述语 <br />
        注意：SEO描述语不应当过长也不应当过少 <br />
        其他：如果不填写此项，则默认截取文章片段'
    );
    $layout->addItem($description);
  
    $aplayer = new Typecho_Widget_Helper_Form_Element_Text(
    'aplayer',
    NULL,
    NULL,
    '音乐Id',
    '介绍：需要播放的音乐Id <br />
        注意：只能是填写网易云音乐Id'
    );
    $layout->addItem($aplayer);

    
}
/**
* 显示上一篇
*/
function thePrev($widget, $default = NULL)
{
$db = Typecho_Db::get();
$sql = $db->select()->from('table.contents')
->where('table.contents.created < ?', $widget->created)
->where('table.contents.status = ?', 'publish')
->where('table.contents.type = ?', $widget->type)
->where('table.contents.password IS NULL')
->order('table.contents.created', Typecho_Db::SORT_DESC)
->limit(1);
$content = $db->fetchRow($sql); 
if ($content) {
$content = $widget->filter($content);
$link = '<div class="w-full mt-9"><a class="text-xs text-left" href="' . $content['permalink'] . '" title="' . $content['title'] . '"><div><b class="block">< Previous</b><span class="text-slate-400 opacity-85">' . $content['title'] . '</span></div></a></div>';
echo $link;
} else {
echo $default;
}
}
/**
* 显示下一篇
*/
function theNext($widget, $default = NULL)
{
$db = Typecho_Db::get();
$sql = $db->select()->from('table.contents')
->where('table.contents.created > ?', $widget->created)
->where('table.contents.status = ?', 'publish')
->where('table.contents.type = ?', $widget->type)
->where('table.contents.password IS NULL')
->order('table.contents.created', Typecho_Db::SORT_ASC)
->limit(1);
$content = $db->fetchRow($sql);
 
if ($content) {
$content = $widget->filter($content);
$link = '<div class="w-full mt-9"><a class="text-xs text-end" href="' . $content['permalink'] . '" title="' . $content['title'] . '"><div><b class="block">Next ></b><span class="text-slate-400 opacity-85">' . $content['title'] . '</span></div></a></div>';
echo $link;
} else {
echo $default;
}
} 
function getPostImages($archive) {
    preg_match_all("/<img.*?src=\"(.*?)\".*?\/?>/i", $archive->content, $images);
    if (count($images) > 0 && count($images[0]) > 0) {
        return $images[1]; // 返回所有图片的URL数组
    } else {
        return array(); // 如果没有图片，返回空数组
    }
}