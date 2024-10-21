<?php

require_once("phpmailer.php");
require_once("smtp.php");

/* 加强评论拦截功能 */
Typecho_Plugin::factory('Widget_Feedback')->comment = array('Intercept', 'message');
class Intercept
{
  public static function message($comment)
  {
    /* 用户输入内容画图模式 */
    if (preg_match('/\{!\{(.*)\}!\}/', $comment['text'], $matches)) {
      /* 如果判断是否有双引号，如果有双引号，则禁止评论 */
      if (strpos($matches[1], '"') !== false || _checkXSS($matches[1])) {
        $comment['status'] = 'waiting';
      }
      /* 普通评论 */
    } else {
      /* 判断用户输入是否大于字符 */
      if (Helper::options()->JTextLimit && strlen($comment['text']) > Helper::options()->JTextLimit) {
        $comment['status'] = 'waiting';
      } else {
        /* 判断评论内容是否包含敏感词 */
        if (Helper::options()->JSensitiveWords) {
          if (_checkSensitiveWords(Helper::options()->JSensitiveWords, $comment['text'])) {
            $comment['status'] = 'waiting';
          }
        }
        /* 判断评论是否至少包含一个中文 */
        if (Helper::options()->JLimitOneChinese === "on") {
          if (preg_match("/[\x{4e00}-\x{9fa5}]/u", $comment['text']) == 0) {
            $comment['status'] = 'waiting';
          }
        }
      }
    }
    Typecho_Cookie::delete('__typecho_remember_text');
    return $comment;
  }
}

/* 邮件通知 */
if (
  Helper::options()->JCommentMail === 'on' &&
  Helper::options()->JCommentMailHost &&
  Helper::options()->JCommentMailPort &&
  Helper::options()->JCommentMailFromName &&
  Helper::options()->JCommentMailAccount &&
  Helper::options()->JCommentMailPassword &&
  Helper::options()->JCommentSMTPSecure
) {
  Typecho_Plugin::factory('Widget_Feedback')->finishComment = array('Email', 'send');
}

class Email
{
  public static function send($comment)
  {
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->CharSet = 'UTF-8';
    $mail->SMTPSecure = Helper::options()->JCommentSMTPSecure;
    $mail->Host = Helper::options()->JCommentMailHost;
    $mail->Port = Helper::options()->JCommentMailPort;
    $mail->FromName = Helper::options()->JCommentMailFromName;
    $mail->Username = Helper::options()->JCommentMailAccount;
    $mail->From = Helper::options()->JCommentMailAccount;
    $mail->Password = Helper::options()->JCommentMailPassword;
    $mail->isHTML(true);
    $text = $comment->text;
    $text = preg_replace('/\{!\{([^\"]*)\}!\}/', '<img style="max-width: 100%;vertical-align: middle;" src="$1"/>', $text);
    $html = '
            <style>
@font-face {
	font-family: "zql Font";
	src: url("//jsd.cdn.zzko.cn/gh/LWingYan/photos@latest/zql.woff");
	src: url("//jsd.cdn.zzko.cn/gh/LWingYan/photos@latest/zql.woff2");
}

.mail-wrapper {
    word-break: break-all;
    background-color: #fff;
    box-shadow: inset 0 0 1px 1px rgba(9, 0, 80, 0.2), inset 0 -2px 1px rgba(9, 0, 80, 0.1), 0 1px 2px rgba(9, 0, 80, 0.2), 0 1px 8px rgba(9, 0, 80, 0.1);
    overflow: hidden;
    position: relative;
    border-radius: 8px;
    padding: calc(1em + 8px);
    width: 520px;
	margin: 0 auto;
	font-family: "zql Font , Helvetica Neue", Helvetica, "PingFang SC", "Hiragino Sans GB", "Microsoft YaHei", "微软雅黑", Arial, sans-serif;
}

.mail-wrapper::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: repeating-linear-gradient(45deg, transparent 0 16px, #d51122 0 32px, transparent 0 48px, #2770cb 0 64px);
    clip-path: polygon(0% 0%, 0% 100%, 8px 100%, 8px 8px, calc(100% - 8px) 8px, calc(100% - 8px) calc(100% - 8px), 8px calc(100% - 8px), 8px 100%, 100% 100%, 100% 0%);
}

.mail_title {
    margin-bottom: 0.5em;
    font-weight: 600;
    color: #2770cb;
}
</style>
            <div class="mail-wrapper"><div class="mail_title">{title}</div><div style="background: #fff;padding: 20px;font-size: 13px;color: #666;"><div style="line-height: 1.5;">{subtitle}</div><div style="background: -webkit-gradient( linear, left top, left bottom, from(rgb(29 29 29)), color-stop(2%, rgba(255, 255, 255, 0)) );-webkit-background-size: 100% 30px;padding-bottom: 15px;font-size: 14px;line-height: 2.2;text-indent: 2em;letter-spacing: 3pt;">{content}</div>
            <div style="padding-bottom: 25px;font-size: 14px;line-height: 2.2;letter-spacing: 3pt;text-align: -webkit-right;">
                {links}
            </div>
            <div style="font-size:12px;line-height:2">请注意：此邮件由系统自动发送，请勿直接回复。<br>若此邮件不是您请求的，请忽略并删除！</div></div></div>
        ';
    /* 如果是博主发的评论 */
    if ($comment->authorId == $comment->ownerId) {
      /* 发表的评论是回复别人 */
      if ($comment->parent != 0) {
        $db = Typecho_Db::get();
        $parentInfo = $db->fetchRow($db->select('mail')->from('table.comments')->where('coid = ?', $comment->parent));
        $parentMail = $parentInfo['mail'];
        /* 被回复的人不是自己时，发送邮件 */
        if ($parentMail != $comment->mail) {
          $mail->Body = strtr(
            $html,
            array(
              "{title}" => '[' . $comment->title . ']收到邮件',
              "{subtitle}" => '博主：[ ' . $comment->author . ' ] 回您:',
              "{links}" => '《 <a style="color: #12addb;text-decoration: none;" href="' . substr($comment->permalink, 0, strrpos($comment->permalink, "#")) . '" target="_blank">' . $comment->title . '</a> 》',
              "{content}" => $text,
            )
          );
          $mail->addAddress($parentMail);
          $mail->Subject = '[' . $comment->title . '] 收到邮件';
          $mail->send();
        }
      }
      /* 如果是游客发的评论 */
    } else {
      /* 如果是直接发表的评论，不是回复别人，那么发送邮件给博主 */
      if ($comment->parent == 0) {
        $db = Typecho_Db::get();
        $authoInfo = $db->fetchRow($db->select()->from('table.users')->where('uid = ?', $comment->ownerId));
        $authorMail = $authoInfo['mail'];
        if ($authorMail) {
          $mail->Body = strtr(
            $html,
            array(
              "{title}" => '' . $comment->title . ' 文收到邮件',
              "{subtitle}" => '' . $comment->author . '：',
              "{links}" => '《<a style="color:#333;text-decoration:none;" href="' . substr($comment->permalink, 0, strrpos($comment->permalink, "#")) . '" target="_blank">' . $comment->title . '</a> 》',
              "{content}" => $text,
            )
          );
          $mail->addAddress($authorMail);
          $mail->Subject = '[' . $comment->title . '] 收到邮件';
          $mail->send();
        }
        /* 如果发表的评论是回复别人 */
      } else {
        $db = Typecho_Db::get();
        $parentInfo = $db->fetchRow($db->select('mail')->from('table.comments')->where('coid = ?', $comment->parent));
        $parentMail = $parentInfo['mail'];
        /* 被回复的人不是自己时，发送邮件 */
        if ($parentMail != $comment->mail) {
          $mail->Body = strtr(
            $html,
            array(
              "{title}" => '[' . $comment->title . '] 收到邮件',
              "{subtitle}" => $comment->author . ' 回复您:',
              "{links}" => '《 <a style="color: #12addb;text-decoration: none;" href="' . substr($comment->permalink, 0, strrpos($comment->permalink, "#")) . '" target="_blank">' . $comment->title . '</a> 》',
              "{content}" => $text,
            )
          );
          $mail->addAddress($parentMail);
          $mail->Subject = '[' . $comment->title . '] 收到邮件';
          $mail->send();
        }
      }
    }
  }
}

