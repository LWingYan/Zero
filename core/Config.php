<?php
function themeConfig($form) {
    $logoUrl = new Typecho_Widget_Helper_Form_Element_Text('logoUrl', NULL, 'https://jsd.onmicrosoft.cn/gh/LWingYan/photos@latest/usr/uploads/2024/10/3072311543.png', _t('站点 LOGO 地址'), _t('在这里填入一个图片 URL 地址'));
    $form->addInput($logoUrl);
    
    //静态资源
    $AssetsURL = new Typecho_Widget_Helper_Form_Element_Text(
        'AssetsURL',
        NULL,
        NULL,
        '自定义静态资源CDN地址（非必填）',
        '介绍：自定义静态资源CDN地址，不填则走本地资源 <br />
         教程：<br />
         1. 将整个assets目录上传至你的CDN <br />
         2. 填写静态资源地址访问的前缀 <br />
         3. 例如：https://npm.elemecdn.com/typecho'
    );
    $form->addInput($AssetsURL);
    
    // 自定义头像源
    $CustomAvatarSource = new Typecho_Widget_Helper_Form_Element_Text(
    'CustomAvatarSource',
    NULL,
    NULL,
    '自定义头像源（非必填）',
    '介绍：用于修改全站头像源地址 <br>
         例如：https://gravatar.ihuan.me/avatar/ <br>
         其他：非必填，默认头像源为https://gravatar.helingqi.com/wavatar/ <br>
         注意：填写时，务必保证最后有一个/字符，否则不起作用！'
          );
    $form->addInput($CustomAvatarSource);
    
    $Footer = new  Typecho_Widget_Helper_Form_Element_Textarea('Footer', NULL, NULL, _t('自定义增加底部内容（非必填）'), _t('可以添加备案或者统计代码等可以使用HTML来实现！！！'));
    $form->addInput($Footer);
    
    
    
    // 邮件通知
    $JCommentMail = new Typecho_Widget_Helper_Form_Element_Select('JCommentMail', array('off' => '关闭（默认）', 'on' => '开启'), 'off', '是否开启评论邮件通知', '介绍：开启后评论内容将会进行邮箱通知 <br />
         注意：此项需要您完整无错的填写下方的邮箱设置！！ <br />
         其他：下方例子以QQ邮箱为例，推荐使用QQ邮箱');
    $form->addInput($JCommentMail->multiMode());
    // 邮箱服务器地址
    $JCommentMailHost = new Typecho_Widget_Helper_Form_Element_Text('JCommentMailHost', NULL, NULL, '邮箱服务器地址', '例如：smtp.qq.com');
    $form->addInput($JCommentMailHost->multiMode());
    $JCommentSMTPSecure = new Typecho_Widget_Helper_Form_Element_Select('JCommentSMTPSecure', array('ssl' => 'ssl（默认）', 'tsl' => 'tsl'), 'ssl', '加密方式', '介绍：用于选择登录鉴权加密方式');
    $form->addInput($JCommentSMTPSecure->multiMode());
    $JCommentMailPort = new Typecho_Widget_Helper_Form_Element_Text('JCommentMailPort', NULL, NULL, '邮箱服务器端口号', '例如：465');
    $form->addInput($JCommentMailPort->multiMode());
    $JCommentMailFromName = new Typecho_Widget_Helper_Form_Element_Text('JCommentMailFromName', NULL, NULL, '发件人昵称', '例如：帅气的象拔蚌');
    $form->addInput($JCommentMailFromName->multiMode());
    $JCommentMailAccount = new Typecho_Widget_Helper_Form_Element_Text('JCommentMailAccount', NULL, NULL, '发件人邮箱', '例如：2323333339@qq.com');
    $form->addInput($JCommentMailAccount->multiMode());
    $JCommentMailPassword = new Typecho_Widget_Helper_Form_Element_Text('JCommentMailPassword', NULL, NULL, '邮箱授权码', '介绍：这里填写的是邮箱生成的授权码 <br>
         获取方式（以QQ邮箱为例）：<br>
         QQ邮箱 > 设置 > 账户 > IMAP/SMTP服务 > 开启 <br>
         其他：这个可以百度一下开启教程，有图文教程');
    $form->addInput($JCommentMailPassword->multiMode());
    
    // 自定义CSS
    $CustomCSS = new  Typecho_Widget_Helper_Form_Element_Textarea('CustomCSS', NULL, NULL, _t('自定义CSS（非必填）'), _t('请填写自定义CSS内容，填写时无需填写style标签！！！'));
    $form->addInput($CustomCSS);
    
    // 增加css链接
    $CustomHeadEnd = new  Typecho_Widget_Helper_Form_Element_Textarea('CustomHeadEnd', NULL, NULL, _t('自定义增加&lt;head&gt;&lt;/head&gt;里内容（非必填）'), _t('此处用于在&lt;head&gt;&lt;/head&gt;标签里增加自定义内容！！！'));
    $form->addInput($CustomHeadEnd);
    
    // 自定义js
    $CustomScript = new Typecho_Widget_Helper_Form_Element_Textarea(
    'CustomScript',
    NULL,
    NULL,
    '自定义JS（非必填）',
    '介绍：请填写自定义JS内容，例如网站统计等，填写时无需填写script标签。'
          );
   $form->addInput($CustomScript);
 
    // 增加js链接
    $CustomBodyEnd = new Typecho_Widget_Helper_Form_Element_Textarea(
    'CustomBodyEnd',
    NULL,
    NULL,
    '自定义&lt;body&gt;&lt;/body&gt;末尾位置内容（非必填）',
    '介绍：此处用于填写在&lt;body&gt;&lt;/body&gt;标签末尾位置的内容 <br>
         例如：可以填写引入第三方js脚本等等'
          );
   $form->addInput($CustomBodyEnd);
   
    $CustomFont = new Typecho_Widget_Helper_Form_Element_Text('CustomFont', NULL, NULL, _t('自定义网站字体（非必填）'), _t('字体URL链接（推荐使用woff格式的字体，网页专用字体格式），字体文件一般有几兆，建议使用cdn链接！！！'));
    $form->addInput($CustomFont);
    
}