<?php
    /* Template Name: Login */
    session_start();
    global $user_ID;
    if($user_ID){
        wp_safe_redirect(site_url('student-portal'));
        exit();
    }
    $err_msg = '';
    $war_msg = '';
    $info_msg = '';
    $suc_msg = '';
    if(isset($_POST['submit_login'])){
        if(empty($_POST['user_login'])){
            $err_msg = 'Username is required.';
        }
        else if(empty($_POST['user_pass'])){
            $err_msg = 'Password is required.';
        }
        $remember = (isset($_POST['rememberme']) && $_POST['rememberme'] == 'on') ? TRUE : FALSE;
        if($err_msg == ''){
            $creds = array();
            $creds['user_login'] =  esc_sql($_POST['user_login']);
            $creds['user_password'] =  esc_sql($_POST['user_pass']);
            $creds['remember'] =  $remember;
            $user = wp_signon( $creds, true);
            if ( is_wp_error($user) ) {
                if(isset($user->errors['incorrect_password'])){
                    $war_msg = "Email / password does not match.";
                }
                else if(isset($user->errors['verification_failed'])){
                    $war_msg = $user->errors['verification_failed'][0];
                }
                else{
                    $war_msg = "Email / password does not match.";
                }
            }
            else {
                wp_set_auth_cookie($user->ID, $remember, true);
                if ( isset($user->roles) && is_array( $user->roles ) ) {
                    if ( in_array( 'subscriber', $user->roles ) ) {
                        wp_safe_redirect(site_url('student-portal'));
                        exit();
                    } 
                    if ( in_array( 'administrator', $user->roles ) ) {
                        wp_safe_redirect(admin_url());
                        exit();
                    }
                }
                wp_safe_redirect(site_url('student-portal'));
                exit();
            }
        }
    }
    get_header();
?>
<section class="wrapper">
    <section class="contener inner-pages">
        <?php
        while ( have_posts() ) : the_post();
            get_template_part( 'content', 'page' );
        endwhile;
        ?>
        <?php if(!empty($err_msg)): echo '<p style="color: red;">'.$err_msg.'</p>'; endif;?>
        <?php if(!empty($war_msg)): echo '<p style="color: orange;">'.$war_msg.'</p>'; endif;?>
        <?php if(isset($_SESSION['session_msg']) && !empty($_SESSION['session_msg'])): echo '<p style="color: green;">'.$_SESSION['session_msg'].'</p>'; endif; unset($_SESSION['session_msg']);?>
        <form name="login" action="" method="POST" class="form_content">
            <p>
                <label>Email Address: </label>
                <input type="text" name="user_login" id="user_login" value="" />
            </p>
            <p>
                <label>Password: </label>
                <input type="password" name="user_pass" id="user_pass" value="" />
            </p>
            <p class="rememberme">
                <label for="rememberme"><input type="checkbox" name="rememberme" value="on"> Remember me</label>
            </p>
            <?php //do_action('login_form');?>
            <p>
                <input type="submit" name="submit_login" value="Login" class="signup" />
                <a href="<?php echo site_url('forgot-password');?>" title="Forgot Password">Forgot password ?</a>
            </p>
        </form>
	    <div class="Clear"></div>
    </section>
    <div class="Clear"></div>
</section>
<?php get_footer();?>