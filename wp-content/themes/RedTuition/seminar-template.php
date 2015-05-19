<?php  /* Template Name: Seminar Timetable */ ?>
<?php get_header(); global $wp_query; ?>
<section class="wrapper">
    <section class="contener inner-pages">
        <?php
        while ( have_posts() ) : the_post();
            get_template_part( 'content', 'page' );
        endwhile;
        ?>
        <div class="table_div">
            <?php query_posts(array('post_type' => 'seminar-timetables', 'posts_per_page' => -1, 'order' => 'ASC')); ?>
            <?php if(have_posts()): $post_count = 0;?>
            <?php while(have_posts()): the_post(); $count = 0; $post_count++;?>
            <table width="100%" height="auto" cellpadding="5" cellspacing="5" class="time-table">
                <tr class="heading">
                  <td colspan="8"><?php the_title(); ?></td>
                </tr>
                <tr class="sub-heading">
                  <td colspan="8">&nbsp;  </td>
                </tr>
                <?php 
                    $schedules = get_field('schedule'); 
                    foreach($schedules as $schedule):
                         $count++;
                ?>
                <tr <?php echo ($count == 1) ? 'class="table-head"' : '';?>>
                  <td><?php echo $schedule['column_1'];?></td>
                  <td><?php echo $schedule['column_2'];?></td>
                  <td><?php echo $schedule['column_3'];?></td>
                  <td><?php echo $schedule['column_4'];?></td>
                  <td><?php echo $schedule['column_5'];?></td>
                  <td><?php echo $schedule['column_6'];?></td>
                  <td><?php echo $schedule['column_7'];?></td>
                  <td><?php echo $schedule['column_8'];?></td>
                </tr>
                <?php endforeach; ?>
            </table>
            <?php if($wp_query->post_count > $post_count):?>
            <hr class="divider">
            <?php endif; ?>
            <?php endwhile; wp_reset_query();?>
            <?php endif; ?>
        </div>
    </section>
</section>
<?php get_footer(); ?>