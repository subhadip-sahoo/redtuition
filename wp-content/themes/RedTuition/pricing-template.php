<?php
    /* Template Name: Pricing */
    global $user_ID;
    $action = (get_field('paypal_environment', 'option') == 'sandbox')?'https://www.sandbox.paypal.com/cgi-bin/webscr':'https://www.paypal.com/cgi-bin/webscr';
    $action = (!$user_ID) ? site_url('registration') : $action;
    //echo $action;
    get_header(); 
?>
<section class="wrapper">
    <section class="contener inner-pages">
        <?php
            while ( have_posts() ) : the_post();
                get_template_part( 'content', 'page' );
            endwhile;
        ?>
        <div class="pricing-content">
        <?php 
            $categories = get_categories(array('post_type' => 'packages', 'taxonomy' => 'package-cat', 'order' => 'DESC'));
            $count = 0;
            foreach ($categories as $category) :
                if($category->count == 0){ continue;}
        ?>
            <p class="big-font" style="text-align: center;"><strong><?php echo $category->name; ?></strong></p>  
            <div id="tsc_pricingtable01" class="clear clr1">
            <?php query_posts(array('post_type' => 'packages', 'taxonomy' => 'package-cat', 'package-cat' => $category->slug, 'posts_per_page' => -1));?>
            <?php if(have_posts()) :?>
                <?php while(have_posts()) : the_post();$count++;?>
                <?php if(get_the_ID() == 387) {if(!$user_ID){continue;}}?>
                <form name="our_team" action="<?php echo $action;?>" method="POST">
                    <div class="plan <?php echo ($count == '1') ? 'one' : '';?>">
                        <h3><?php the_title();?><?php echo ($count == '7') ? '' : '<br/>&nbsp;';?><span>$<?php echo str_replace('$', '', get_field('package_price'));?></span></h3>
                        <input type="hidden" name="business" value="<?php echo get_field('paypal_email', 'option');?>">
                        <input type="hidden" name="cmd" value="_xclick">
                        <input type="hidden" name="amount" value="<?php echo str_replace('$', '', get_field('package_price'));?>">
                        <input type="hidden" name="item_name" value="<?php the_title();?>">
                        <input type="hidden" name="return" value="<?php echo home_url().'/pricing/';?>">
                        <input type="hidden" name="cancel_return" value="<?php echo home_url().'/pricing/';?>">
                        <input type="hidden" name="currency_code" value="AUD">
                        <input type="hidden" name="notify_url" value="<?php echo get_template_directory_uri();?>/paypal/ipn_listner.php">
                        <input type="hidden" name="custom" value="<?php echo ($user_ID)? $user_ID : -1;?>,<?php echo get_the_ID(); ?>">
                        <input type="hidden" name="package_type" value="<?php echo $category->name; ?>">
                        <?php if(str_replace('$', '', get_field('package_price')) <> 0):?>
                        <input type="submit" class="signup" value="Add"/>
                        <?php else: ?>
                        <a href="<?php echo (!$user_ID) ? site_url('registration') : site_url('student-portal'); ?>" class="signup">Add</a>
                        <?php endif; ?>
                        <ul>
                        <?php 
                            $package_details = get_field('package_details');
                            foreach ($package_details as $details) :
                        ?>
                            <li><?php echo $details['texts'];?></li>
                        <?php endforeach;?>
                            <li><?php echo (get_field('savings') <> '') ? '<strong class="save-btn">'.get_field('savings').'</strong>': ''; ?></li>
                        </ul>
                    </div>
                </form>
                <?php endwhile;?>
            <?php endif;?>
            </div>
            <div class="tsc_clear"></div>
        <?php endforeach; ?>
        <!-- End loop -->
        </div>
	    <div class="Clear"></div>
    </section>
    <div class="Clear"></div>
</section>
<?php get_footer(); ?>