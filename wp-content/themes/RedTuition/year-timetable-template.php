<?php /* Template Name: Year Time Table */ ?>
<?php get_header(); global $wp_query; ?>
<section class="wrapper">
    <section class="contener inner-pages">
        <?php
        while ( have_posts() ) : the_post();
            get_template_part( 'content', 'page' );
        endwhile;
        ?>
        <div class="table_div">
            <?php query_posts(array('post_type' => 'year-timetables', 'posts_per_page' => -1, 'order' => 'ASC')); ?>
            <?php if(have_posts()): ?>
            <?php while(have_posts()): the_post(); $count = 0;?>
            <table class="time-table" width="100%" cellspacing="5" cellpadding="5">
                <tbody>
                    <tr class="heading">
                        <td colspan="8"><?php the_title(); ?></td>
                    </tr>
                    <tr class="sub-heading">
                        <td colspan="8" align="center"><?php echo get_field('heading');?></td>
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
                      <?php if(!empty($schedule['column_5'])) :?>
                      <td><?php echo $schedule['column_5'];?></td>
                      <?php endif;?>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endwhile; wp_reset_query();?>
            <?php endif; ?>
        </div>
    </section>
</section>
<?php get_footer(); ?>