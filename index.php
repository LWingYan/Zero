<?php
/**
 * 
 * 单栏简约风格主题
 * 
 * <p style="font-size:12px;">感谢使用零度 该主题如其名 不需要花里胡哨来修饰</p>
 * 
 * 
 * @package Zero
 * 
 * @author 林孽
 * 
 * @version 1.0
 * 
 * @link //ouyu.me
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
                    
                <div class="mt-9 mb-7">
                    <?php if ($this->have()): ?>
                    <?php while($this->next()): ?>
                        <div class="my-10 relative">
                            <h3 class="post-title my-6">
                                <a class="relative px-3" href="<?php $this->permalink() ?>"><?php $this->title() ?></a>
                            </h3>
                            <div class="text-sm opacity-85 py-1.5 leading-7">
                                <?php echo _getAbstract($this,140);?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                    <?php else: ?>
                        <div class="my-3 block mr-auto ml-auto">
                            暂无文章
                        </div>
                    <?php endif; ?>
                </div>
                
                
            </section>
            
            <section class="my-6 flex relative page_next justify-between text-xs w-full " >
                <div>
                    <?php $this->pageLink('Previous >'); ?>
                </div>
                <div>
                    <?php $this->pageLink('Next >','next'); ?>
                </div>
            </section>
        </main>
        <?php $this->need('footer.php'); ?>






