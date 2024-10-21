<?php
/**
 * 
 * 林孽
 * 
 * 24-10-20
 * 
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>

        <main>
            <section class="relative transition w-full ">
                <header>
                    <!--判断logo已被设置-->
                    <?php if ($this->options->logoUrl): ?>
                    
                    <a href="<?php $this->options->siteUrl(); ?>" rel="home" class="text-center w-full">
                        
                        <img src="<?php $this->options->logoUrl() ?>" class="block mr-auto ml-auto" alt="<?php $this->options->title() ?>">
                    </a>
                    
                    <hr class="block mr-auto ml-auto border-b-1 border-slate-50" style="width:30%;">
                    
                    <?php endif; ?>
                    
                </header>
                    
                <div class="mt-9 mb-7 post relative">
                    
                        
                    <div class="text-base py-1.5 leading-7 mt-4 mb-7 post-content">
                        <?php $this->content(); ?>
                    </div>
                    
                    <br>
                    
                    <div class="text-xs text-slate-400 opacity-85 w-full text-end"><?php echo human_time_diff($this->created);?></div>
                    
                    <br>
                    
                </div>
                
                <div class="mt-9 mb-7 post relative " >
                    <?php $this->need('comments.php'); ?>
                </div>
                
                
            </section>
            
        </main>
    <?php $this->need('footer.php'); ?>





