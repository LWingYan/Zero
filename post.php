<?php
/**
 * 
 * 林孽
 * 
 * 24-10-19
 * 
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>
        <main>
            <section class="relative transition w-full ">
                <header>
                    <?php if($this->fields->article_type == "photos"): ?><!-- 相册样式 -->
                    <!-- Slider main container -->
                    <div class="swiper">
                        <!-- Additional required wrapper -->
                        <div class="swiper-wrapper">
                            <!-- Slides -->
                            <?php
                            $images = getPostImages($this);
                            if (!empty($images)) {
                                foreach ($images as $imgUrl) {
                                    echo '
                                    <div class="swiper-slide">
                                        <img width="100%" height="100%" class="object-cover thumbnail lazyload" data-src="' . htmlspecialchars($imgUrl) . '" />
                                    </div>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                    
                    <?php elseif($this->fields->article_type == "aplayer"): ?><!-- 音乐样式 -->
                    <meting-js
                        server="netease"
                        type="song"
                        id="<?php $this->fields->aplayer() ?>">
                    </meting-js>

                    <?php elseif($this->fields->article_type == "book"): ?><!-- 音乐样式 -->
                    <book data-doubanId="<?php $this->fields->doubanId() ?>"></book>
                    
                    
                    <?php else: ?><!-- 默认样式 -->
                        <!--判断logo已被设置-->
                        <?php if ($this->options->logoUrl): ?>
                        
                        <a href="<?php $this->options->siteUrl(); ?>" rel="home" class="text-center w-full">
                            
                            <img src="<?php $this->options->logoUrl() ?>" class="block mr-auto ml-auto" alt="<?php $this->options->title() ?>">
                        </a>
                        
                        <hr class="block mr-auto ml-auto border-b-1 border-slate-50" style="width:30%;">
                        
                        <?php endif; ?>
                    <?php endif; ?>
                        
                    
                    
                </header>
                
                <article class="mt-9 mb-7 post relative">
                    <h3 class="title " style="margin-bottom:.25rem;">
                        <?php $this->title() ?>
                    </h3>
                        
                    <span class="text-xs text-slate-400 opacity-85 "><?php echo human_time_diff($this->created);?></span>
                        
                    <div class="text-base py-1.5 leading-7 mt-4 mb-7 post-content">
                        <?php article_changetext($this, $this->user->hasLogin()) ?>
                    </div>
                    
                    <hr class="opacity-15">
                    
                    <div class="flex justify-between w-full my-10 page_next ">
                        <?php thePrev($this); ?>
                        <?php theNext($this); ?>
                    </div>
                    
                </article>
                
                <div class="mt-9 mb-7 post relative " >
                    <?php $this->need('comments.php'); ?>
                </div>
                
                
            </section>
            
        </main>
    <?php $this->need('footer.php'); ?>





