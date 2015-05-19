<?php
    /* Template Name: Student Portal */
    global $user_ID;
    if(!$user_ID){
        wp_safe_redirect(site_url('login'));
        exit();
    }
//    if(get_user_meta($user_ID,'is_paid_user', true) <> '1'){
//        wp_safe_redirect(site_url('pricing'));
//        exit();
//    }
    get_header(); 
?>
<section class="wrapper">
    <section class="contener inner-pages">
        <?php
            while ( have_posts() ) : the_post();
                get_template_part( 'content', 'page' );
            endwhile;
        ?>
        <p class="student-name-p"><strong>Welcome Back <?php echo ucwords($userdata->display_name);?></strong></p>
        <div class="container_student">
            <!-- Accordion begin -->
            <ul class="accordion_student">
                <!-- Section 1 -->
                <li>
                    <div>Weekly Materials</div><!-- Head -->
                    <div>
                        <?php echo get_posts_by_taxonomy_name('weekly-materials');?>
                    </div>
                </li>
                <!-- Section 2 -->
                <li>
                    <div>Study Notes</div><!-- Head -->
                    <div>
                        <?php echo get_posts_by_taxonomy_name('study-notes');?>
                    </div>
                </li>
                <!-- Section 3 -->
                <li>
                    <div>Review Sheets</div><!-- Head -->
                    <div>
                        <?php echo get_posts_by_taxonomy_name('review-sheets');?>
                    </div>
                </li>
                <li>
                    <div>Grades</div><!-- Head -->
                    <div>
                        <?php echo get_posts_by_taxonomy_name('grades');?>
                    </div>
                </li>
                <li>
                    <div>Additional Resources</div><!-- Head -->
                    <div>
                        <?php echo get_posts_by_taxonomy_name('additional-resources');?>
                    </div>
                </li>
                <li>
                    <div>Pre Exam Seminar Resources</div><!-- Head -->
                    <div>
                        <?php echo get_posts_by_taxonomy_name('pre-exam-seminar-resources');?>
                    </div>
                </li>
            </ul>
            <!-- Accordion end -->
        </div>
    </section>
</section>
<?php get_footer(); ?>
