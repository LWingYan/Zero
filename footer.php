        <!-- 底部 -->
        <footer class="">
            <hr class="block mr-auto ml-auto border-b-1 border-slate-50 full">
            <nav id="nav-menu" class="text-sm py-3" role="navigation" style="padding:10px 0;">
            <a<?php if($this->is('index')): ?> class="current"<?php endif; ?> href="<?php $this->options->siteUrl(); ?>"><?php _e('首页'); ?></a>
            <?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
            <?php while($pages->next()): ?>
            <a<?php if($this->is('page', $pages->slug)): ?> class="current"<?php endif; ?> href="<?php $pages->permalink(); ?>" title="<?php $pages->title(); ?>"><?php $pages->title(); ?></a>
            <?php endwhile; ?>
            </nav>
        </footer>
    </div>
    <!-- 版权 -->
    <div class="text-xs text-slate-400 opacity-85 w-full text-center my-3">
        &copy; <?php echo date('Y'); ?> <a href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title(); ?></a>.
    <?php _e('由 <a href="http://www.typecho.org">Typecho</a> 强力驱动'); ?>
    </div>
    <?php $this->options->Footer() ?>
    <!-- 返回顶部 -->
    <a href="javascript:;" id="back-to-top" title="返回顶部"></a>
    <script>
      <?php $this->options->CustomScript() ?>
    </script>
    
</body>

    <!-- 全靠jquery -->
    <script src="<?php _getAssets('assets/js/jquery.min.js'); ?>"></script>
    <!-- 灯箱 -->
    <script src="<?php _getAssets('assets/js/view-image.min.js'); ?>"></script>
    <!-- 懒加载 -->
    <script src="<?php _getAssets('assets/js/lazysizes.js'); ?>"></script>
    <!-- 配置灯箱 -->
    <script>
        window.ViewImage && ViewImage.init('.post-content img , .comment-content img , .commentText img' );
    </script>
    <!-- 幻灯片 -->
    <script src="<?php _getAssets('assets/swiper/swiper-element-bundle.min.js'); ?>"></script>
    <script type="text/javascript">
        const swiper = new Swiper('.swiper', {
            autoplay: {
           delay: 2500,
         },
        });
        const themeUrl = '<?php $this->options->themeUrl(); ?>';
    </script>
    <!-- 访客优化 -->
    <script src="//instant.page/5.2.0" type="module" integrity="sha384-jnZyxPjiipYXnSU0ygqeac2q7CVYMbh84q0uHVRRxEtvFPiQYbXWUorga2aqZJ0z"></script>
    <!-- 代码块 -->
    <script src="<?php _getAssets('assets/prism/prism.js'); ?>"></script>
    <!-- 音乐 -->
    <script src="<?php _getAssets('assets/aplayer/APlayer.min.js'); ?>"></script>
    <script src="<?php _getAssets('assets/aplayer/Meting.min.js'); ?>"></script>
    <!-- 全局 -->
    <script src="<?php _getAssets('assets/js/script.js'); ?>"></script>
    
    
    <?php $this->options->CustomBodyEnd() ?>
    
<?php $this->footer(); ?>