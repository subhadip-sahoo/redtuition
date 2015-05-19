<?php
    /* Template Name: Home */
    get_header();
?>
<section class="wrapper">
    <?php 
        query_posts(array('post_type' => 'sliders', 'posts_per_page' => -1));
        if(have_posts()):
    ?>
    <div id="main" role="main">
      <section class="slider">
        <div class="flexslider">
          <ul class="slides">
            <?php while(have_posts()): the_post();?>
            <li>
                <?php 
                    if(has_post_thumbnail()){
                        the_post_thumbnail('full');
                    }else if(get_field('youtube_video_id') <> ''){
                        echo '<iframe width="100%" height="458" src="https://www.youtube.com/embed/'.get_field('youtube_video_id').'" frameborder="0" allowfullscreen></iframe>';
                    }else{
                        echo '<img src="'.get_template_directory_uri().'/images/no-image-available.jpg" width="100%" height="458" alt="No image">';
                    }
                ?>
            </li>
            <?php endwhile; wp_reset_query();?>
          </ul>
        </div>
      </section>
    </div>
    <?php endif;?>

    <section class="contener home-page">
        <?php 
            if(have_posts()):
                while(have_posts()):
                    the_post();
                    the_content();
                endwhile;
                wp_reset_query();
            endif;
        ?>
    </section>
    <?php 
        query_posts(array('post_type' => 'testimonials', 'posts_per_page' => -1));
        if(have_posts()):
    ?>
    <section class="testimonial">
        <section class="slider">
            <div class="flexslider1 carousel">
              <ul class="slides">
                <?php while(have_posts()): the_post();?>
                <li>
                    <?php
                        if(has_post_thumbnail()):
                    ?>
                    <?php $image = vt_resize(get_post_thumbnail_id(get_the_ID()), '', 114, 118);?>
                    <img src="<?php echo ($image['url'] <> '') ? $image['url'] : get_template_directory_uri().'/images/no-image-testi.jpg';?>" width="" height=""/>
                    <?php endif;?>
                    <?php the_content();?>
                    <p class="testimonial-writer"><a href="<?php echo (get_field('website_url') <> '') ? get_field('website_url') : '#';?>">-<?php the_title();?></a></p>
                </li>
                <?php endwhile; wp_reset_query();?>
              </ul>
            </div>
        </section>
    </section>
    <?php endif;?>
    <section class="contener">
        <p class="free-trial"><a href="<?php echo site_url('pricing');?>" class="start-btn">Start your free trial</a></p>   
        <br style="clear:both;" />
    </section>
</section>
<?php get_footer();?>

