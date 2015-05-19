<?php 
    global $user_ID;
    if($user_ID){
        $userdata = get_userdata($user_ID);
    }
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title><?php wp_title('|', 'right', TRUE);?></title>
        <link rel="shortcut icon" href="<?php echo get_template_directory_uri();?>/favicon.ico" type="image/x-icon">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
        <link type="text/css" rel="stylesheet" href="<?php echo get_template_directory_uri();?>/css/validationEngine.jquery.css" media="screen"/>
        <link type="text/css" rel="stylesheet" href="<?php echo get_template_directory_uri();?>/css/style.css" media="screen"/>
        <script src="<?php echo get_template_directory_uri();?>/js/html5shiv.js"></script>
        <script src="<?php echo get_template_directory_uri();?>/js/jquery.fitvids.js"></script>
        <link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/css/flexslider.css" type="text/css" media="screen" />
        <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri();?>/css/meanmenu.css" media="all" />
        <link type="text/css" rel="stylesheet" href="<?php echo get_template_directory_uri();?>/css/smk-accordion.css" media="screen"/>
        
        <?php wp_head();?>
    </head>
<body>
<header>
    <section class="header-top">
        <h1 class="logo"><a href="<?php echo home_url();?>"><img src="<?php header_image();?>" alt="Red Tution"/></a></h1>
        <section class="right-sec">
            <?php if(is_user_logged_in()):?>
            <ul class="login-sec">
                <li>Welcome <?php echo $userdata->display_name;?></li>
                <li><a href="<?php echo wp_logout_url(currentPageURL()); ?>">Logout</a></li>
            </ul>
            <?php else:?>
            <ul class="login-sec">
                <li><a href="<?php echo site_url('login'); ?>">Login</a></li>
                <li><a href="<?php echo site_url('pricing'); ?>">Sign Up</a></li>
            </ul>
            <?php endif;?>
            <section class="search">
                <form action="<?php echo home_url();?>" class="search-frm" name="search_form" method="GET">
                    <input type="text" name="s" placeholder="Search here...">
                    <input type="submit" value="SEARCH">
                </form>
            </section>
            <br class="Clear"/>
        </section>
        <section class="delv-txt">“<?php echo get_option('blogdescription');?>”</section>
      <br class="Clear"/>
    </section>	
</header>
<section class="mnu">    
    <nav>
        <?php
            $args_header = array(
                    'theme_location'  => 'primary',
                    'menu'            => '',
                    'container'       => '',
                    'container_class' => '',
                    'container_id'    => '',
                    'menu_class'      => 'menu',
                    'menu_id'         => '',
                    'echo'            => true,
                    'fallback_cb'     => 'wp_page_menu',
                    'before'          => '',
                    'after'           => '',
                    'link_before'     => '',
                    'link_after'      => '',
                    'items_wrap'      => '<ul>%3$s</ul>',
                    'depth'           => 0,
                    'walker'          => ''
            );

            wp_nav_menu( $args_header );

        ?>
    </nav>
</section>
<!-- End Header -->