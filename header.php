<meta charset="utf-8" />
<meta name="renderer" content="webkit" />
<meta name="format-detection" content="email=no" />
<meta name="format-detection" content="telephone=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1" />
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, shrink-to-fit=no, viewport-fit=cover">
<link rel="shortcut icon" href="<?php $this->options->Favicon() ?>" />
<title><?php $this->archiveTitle(array('category' => '分类 %s 下的文章', 'search' => '包含关键字 %s 的文章', 'tag' => '标签 %s 下的文章', 'author' => '%s 发布的文章'), '', ' - '); ?><?php $this->options->title(); ?></title>
<?php if ($this->is('single')) : ?>
  <meta name="keywords" content="<?php echo $this->fields->keywords ? $this->fields->keywords : htmlspecialchars($this->_keywords); ?>" />
  <meta name="description" content="<?php echo $this->fields->description ? $this->fields->description : htmlspecialchars($this->_description); ?>" />
  <?php $this->header('keywords=&description='); ?>
<?php else : ?>
  <?php $this->header(); ?>
<?php endif; ?>

<?php
    $fontUrl = $this->options->CustomFont ?? ''; // 使用空字符串作为默认值
    $fontFormat = '';
    
    if (strpos($fontUrl, 'woff2') !== false) {
        $fontFormat = 'woff2';
    } elseif (strpos($fontUrl, 'woff') !== false) {
        $fontFormat = 'woff';
    } elseif (strpos($fontUrl, 'ttf') !== false) {
        $fontFormat = 'truetype';
    } elseif (strpos($fontUrl, 'eot') !== false) {
        $fontFormat = 'embedded-opentype';
    } elseif (strpos($fontUrl, 'svg') !== false) {
        $fontFormat = 'svg';
    }
    
?>
<style>
  @font-face {
    font-family: 'wodeziti';
    font-weight: 400;
    font-style: normal;
    font-display: swap;
    src: url('<?php echo $fontUrl ?>');
    <?php if ($fontFormat) : ?>src: url('<?php echo $fontUrl ?>') format('<?php echo $fontFormat ?>');
    <?php endif; ?>
  }
  @font-face{
    font-family: 'zql Font';
    src:  url('//jsd.cdn.zzko.cn/gh/LWingYan/photos@latest/zql.woff');
    src:  url('//jsd.cdn.zzko.cn/gh/LWingYan/photos@latest/zql.woff2');
    }
    
  body {
    <?php if ($fontUrl) : ?>
    font-family: 'wodeziti';
    <?php else : ?>
    font-family: 'zql Font','Helvetica Neue', Helvetica, 'PingFang SC', 'Hiragino Sans GB', 'Microsoft YaHei', '微软雅黑', Arial, sans-serif;
    <?php endif; ?>
  }
  <?php $this->options->CustomCSS() ?>
</style>
<?php if ($this->options->Favicon()) : ?>
<link rel="shortcut icon" href="<?php $this->options->Favicon() ?>" />
<?php else : ?>
<link rel="shortcut icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text x=%22-0.125em%22 y=%22.9em%22 font-size=%2290%22>💤</text></svg>" />
<?php endif; ?>
<!-- 全局 -->
<link href="<?php _getAssets('assets/css/style.css'); ?>" rel="stylesheet" />
<!-- 幻灯片 -->
<link rel="stylesheet" href="<?php _getAssets('assets/swiper/swiper-bundle.min.css'); ?>"/>
<!-- 代码块 -->
<link href="<?php _getAssets('assets/prism/prism.min.css'); ?>" rel="stylesheet" />
<!-- 音乐 -->
<link href="<?php _getAssets('assets/aplayer/APlayer.min.css'); ?>" rel="stylesheet" />
<?php $this->options->CustomHeadEnd() ?>
<body>
    <div class="p-7 my-6 md:my-6 md-container mr-auto ml-auto shadow-sm bg-white">