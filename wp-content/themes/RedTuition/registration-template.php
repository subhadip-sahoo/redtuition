<?php
    /* Template Name: Registration */
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
    if(isset($_POST['submit_reg'])){
        if(empty($_POST['first_name'])){
            $err_msg = 'First name is required.';
        }
        else if(empty($_POST['last_name'])){
            $err_msg = 'Last name is required.';
        }
        else if(empty($_POST['contact_number'])){
            $err_msg = 'Contact number is required.';
        }
        else if(empty($_POST['user_email'])){
            $err_msg = 'Email address is required.';
        }
        else if(!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL) === TRUE){
            $err_msg = 'Please enter a valid email address';
        }
        else if(empty($_POST['user_pass'])){
            $err_msg = 'Password is required.';
        }
        else if($_POST['user_pass'] <> $_POST['con_password']){
            $err_msg = 'Password does not match.';
        }
        else if(!isset($_POST['term_condition']) || $_POST['term_condition'] <> 1){
            $err_msg = 'Please confirm that you have read and agreed with terms and conditions.';
        }
        if($err_msg == ''){
            if( $_SESSION['security_code'] == $_POST['security_code'] && !empty($_SESSION['security_code'] ) ) {
                $userinfo = array(
                    'user_login' => esc_sql($_POST['first_name']).time(),
                    'user_pass'  => esc_sql($_POST['user_pass']),
                    'user_email' => esc_sql($_POST['user_email'])
                );
                $ID = wp_insert_user($userinfo);
                if ( is_wp_error($ID) ) {
                    $war_msg .= 'Email / Username Address already exists. Please try another one.<br/>';
                }
                if($war_msg == ''){
                    $userdata = array(
                        'ID' => $ID,
                        'user_pass' => esc_sql($_POST['user_pass']),
                        'display_name' => esc_sql($_POST['first_name'].' '.$_POST['last_name'])
                    );
                }
                $new_user_id = wp_update_user( $userdata );
                if ( is_wp_error($new_user_id) ) {
                    $err_msg .= 'Registration failed. Please try again later.<br/>';
                }else{
                    $keys = $wpdb->get_results("SELECT * FROM $wpdb->users WHERE ID = $new_user_id", ARRAY_A);
                    if($wpdb->num_rows == 1){
                        foreach ($keys as $key) {
                            if(!empty($key['user_activation_key'])){
                                $act_key = $key['user_activation_key'];
                                $set_key = 1;
                            }else{
                                $set_key = 0;
                            }
                        }
                    }
                    $from = get_option('admin_email');
                    $from_name = "Red Tuition";
                    $headers = "From: $from_name <$from>\r\n";
                    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                    $subject = "Activate your account.";
                    $msg = "Hi ".$_POST['first_name']." ".$_POST['last_name'].".<br/><br/>";
                    $msg .= "Thank you for registration.<br/>Your login details<br/>Username: ".$_POST['user_email']."<br/>Password: Your choosen password.<br/>";
                    $msg .= "Please click the link below to activate your account.<br/>";
                    if(isset($set_key) && $set_key == 1){
                        $msg .= "<a href='".site_url()."/verify-email/?verify_id=$new_user_id&activation_key=$act_key'>Click here for verify your email</a><br/><br/>";
                    }else{
                        $msg .= "<a href='".site_url()."/verify-email/?verify_id=$new_user_id'>Click here for verify your email</a><br/><br/>";
                    }
                    $msg .= "Best regards<br/>Red Tuition Team";
                    if(wp_mail( $_POST['user_email'], $subject, $msg, $headers )){
                        update_user_meta($new_user_id,'account_status', 0);
                        update_user_meta($new_user_id,'is_paid_user', 0);
                        update_user_meta($new_user_id,'first_name', esc_sql($_POST['first_name']));
                        update_user_meta($new_user_id,'last_name', esc_sql($_POST['last_name']));
                        update_user_meta($new_user_id,'contact_number', esc_sql($_POST['contact_number']));
                        update_user_meta($new_user_id,'weekly_timeslot', esc_sql($_POST['weekly_timeslot']));
                        update_user_meta($new_user_id,'pre_exam_subject', esc_sql($_POST['pre_exam_subject']));
                        update_user_meta($new_user_id,'user_source_to_red_tuition', esc_sql($_POST['user_source_to_red_tuition']));

                        $to = get_option('admin_email');

                        $from_name = esc_sql($_POST['first_name'].' '.$_POST['last_name']);
                        $headers = "From: $from_name <".$_POST['user_email'].">\r\n";
                        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                        $subject = 'New user registration details';

                        $msg = "Someone has registered in Red Tuition. Please find the details below.<br/><br/>";
                        $msg .= "Name: ".esc_sql($_POST['first_name'].' '.$_POST['last_name'])."<br/>";
                        $msg .= "Contact Number: ".esc_sql($_POST['contact_number'])."<br/>";
                        $msg .= "Email Address: ".esc_sql($_POST['user_email'])."<br/>";
                        $msg .= "Subject: ".esc_sql($_POST['pre_exam_subject'])."<br/>";
                        $msg .= "Preferred Weekly Timeslot: ".esc_sql($_POST['weekly_timeslot'])."<br/>";
                        $msg .= "How did you hear about RED Tuition: ".esc_sql($_POST['user_source_to_red_tuition'])."<br/>";

                        wp_mail($to, $subject, $msg, $headers);

                        $suc_msg = 'Registration completed successfully. Please check your mail to activate account';
                        unset($_POST);
                    }
                }
            }else{
                $err_msg .= 'Verification code does not match.<br/>';
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
        <?php if(!empty($suc_msg)): echo '<p style="color: green;">'.$suc_msg.'</p>'; endif;?>
        <form name="registration" id="red_registration" action="" method="POST" class="form_content info-seminar">
            <p>
                <label>First Name: </label>
                <input type="text" name="first_name" id="first_name" value="<?php echo ($_POST['first_name']) ? $_POST['first_name'] : ''?>" class="validate[required]"/>
            </p>
            <p>
                <label>Last Name: </label>
                <input type="text" name="last_name" id="last_name" value="<?php echo ($_POST['last_name']) ? $_POST['last_name'] : ''?>" class="validate[required]"/>
            </p>
            <p>
                <label>Contact Number: </label>
                <input type="text" name="contact_number" id="contact_number" value="<?php echo ($_POST['contact_number']) ? $_POST['contact_number'] : ''?>" class="validate[required]"/>
            </p>
            <p>
                <label>Email Address: </label>
                <input type="text" name="user_email" id="user_email" value="<?php echo ($_POST['user_email']) ? $_POST['user_email'] : ''?>" class="validate[required, custom[email]]"/>
            </p>
            <p>
                <label>Subject: </label>
                <select name="pre_exam_subject" id="pre_exam_subject">
                    <option value="General Mathematics" <?php echo (isset($_POST['pre_exam_subject']) && $_POST['pre_exam_subject'] == 'General Mathematics' ) ? 'selected="selected"' : ''; ?>>General Mathematics</option>
                    <option value="Advanced Mathematics" <?php echo (isset($_POST['pre_exam_subject']) && $_POST['pre_exam_subject'] == 'Advanced Mathematics' ) ? 'selected="selected"' : ''; ?>>Advanced Mathematics</option>
                </select>
            </p>
            <p>
                <label>Preferred Weekly Timeslot (Only If Purchasing Weekly Tuition): </label>
                <select name="weekly_timeslot" id="weekly_timeslot">
                    <option value="I am not purchasing weekly tuition" <?php echo (isset($_POST['weekly_timeslot']) && $_POST['weekly_timeslot'] == 'I am not purchasing weekly tuition' ) ? 'selected="selected"' : ''; ?>>I am not purchasing weekly tuition</option>
                    <option value="Year 11 General Maths Monday 4:00pm" <?php echo (isset($_POST['weekly_timeslot']) && $_POST['weekly_timeslot'] == 'Year 11 General Maths Monday 4:00pm' ) ? 'selected="selected"' : ''; ?>>Year 11 General Maths Monday 4:00pm</option>
                    <option value="Year 11 General Maths Monday 5:30pm" <?php echo (isset($_POST['weekly_timeslot']) && $_POST['weekly_timeslot'] == 'Year 11 General Maths Monday 5:30pm' ) ? 'selected="selected"' : ''; ?>>Year 11 General Maths Monday 5:30pm</option>
                    <option value="Year 11 General Maths Tuesday 7:00pm" <?php echo (isset($_POST['weekly_timeslot']) && $_POST['weekly_timeslot'] == 'Year 11 General Maths Tuesday 7:00pm' ) ? 'selected="selected"' : ''; ?>>Year 11 General Maths Tuesday 7:00pm</option>
                    <option value="Year 12 General Maths Monday 7:00pm" <?php echo (isset($_POST['weekly_timeslot']) && $_POST['weekly_timeslot'] == 'Year 12 General Maths Monday 7:00pm' ) ? 'selected="selected"' : ''; ?>>Year 12 General Maths Monday 7:00pm</option>
                    <option value="Year 12 General Maths Tuesday 4:00pm" <?php echo (isset($_POST['weekly_timeslot']) && $_POST['weekly_timeslot'] == 'Year 12 General Maths Tuesday 4:00pm' ) ? 'selected="selected"' : ''; ?>>Year 12 General Maths Tuesday 4:00pm</option>
                    <option value="Year 12 General Maths Tuesday 5:30pm" <?php echo (isset($_POST['weekly_timeslot']) && $_POST['weekly_timeslot'] == 'Year 12 General Maths Tuesday 5:30pm' ) ? 'selected="selected"' : ''; ?>>Year 12 General Maths Tuesday 5:30pm</option>
                    <option value="Year 11 Advanced Maths Wednesday 4:00pm" <?php echo (isset($_POST['weekly_timeslot']) && $_POST['weekly_timeslot'] == 'Year 11 Advanced Maths Wednesday 4:00pm' ) ? 'selected="selected"' : ''; ?>>Year 11 Advanced Maths Wednesday 4:00pm</option>
                    <option value="Year 11 Advanced Maths Wednesday 5:30pm" <?php echo (isset($_POST['weekly_timeslot']) && $_POST['weekly_timeslot'] == 'Year 11 Advanced Maths Wednesday 5:30pm' ) ? 'selected="selected"' : ''; ?>>Year 11 Advanced Maths Wednesday 5:30pm</option>
                    <option value="Year 11 Advanced Maths Thursday 7:00pm" <?php echo (isset($_POST['weekly_timeslot']) && $_POST['weekly_timeslot'] == 'Year 11 Advanced Maths Thursday 7:00pm' ) ? 'selected="selected"' : ''; ?>>Year 11 Advanced Maths Thursday 7:00pm</option>
                    <option value="Year 12 Advanced Maths Wednesday 7:00pm" <?php echo (isset($_POST['weekly_timeslot']) && $_POST['weekly_timeslot'] == 'Year 12 Advanced Maths Wednesday 7:00pm' ) ? 'selected="selected"' : ''; ?>>Year 12 Advanced Maths Wednesday 7:00pm</option>
                    <option value="Year 12 Advanced Maths Thursday 4:00pm" <?php echo (isset($_POST['weekly_timeslot']) && $_POST['weekly_timeslot'] == 'Year 12 Advanced Maths Thursday 4:00pm' ) ? 'selected="selected"' : ''; ?>>Year 12 Advanced Maths Thursday 4:00pm</option>
                    <option value="Year 12 Advanced Maths Thursday 5:30pm" <?php echo (isset($_POST['weekly_timeslot']) && $_POST['weekly_timeslot'] == 'Year 12 Advanced Maths Thursday 5:30pm' ) ? 'selected="selected"' : ''; ?>>Year 12 Advanced Maths Thursday 5:30pm</option>
                </select>
            </p>
            <p>
                <label>How did you hear about RED Tuition: </label>
                <select name="user_source_to_red_tuition" id="user_source_to_red_tuition">
                    <option value="Referred By Friend" <?php echo (isset($_POST['user_source_to_red_tuition']) && $_POST['user_source_to_red_tuition'] == 'Referred By Friend' ) ? 'selected="selected"' : ''; ?>>Referred By Friend</option>
                    <option value="Search Engine" <?php echo (isset($_POST['user_source_to_red_tuition']) && $_POST['user_source_to_red_tuition'] == 'Search Engine' ) ? 'selected="selected"' : ''; ?>>Search Engine</option>
                    <option value="Social Media" <?php echo (isset($_POST['user_source_to_red_tuition']) && $_POST['user_source_to_red_tuition'] == 'Social Media' ) ? 'selected="selected"' : ''; ?>>Social Media</option>
                    <option value="Leaflet in Mail" <?php echo (isset($_POST['user_source_to_red_tuition']) && $_POST['user_source_to_red_tuition'] == 'Leaflet in Mail' ) ? 'selected="selected"' : ''; ?>>Leaflet in Mail</option>
                    <option value="School Visit" <?php echo (isset($_POST['user_source_to_red_tuition']) && $_POST['user_source_to_red_tuition'] == 'School Visit' ) ? 'selected="selected"' : ''; ?>>School Visit</option>
                    <option value="Other" <?php echo (isset($_POST['user_source_to_red_tuition']) && $_POST['user_source_to_red_tuition'] == 'Other' ) ? 'selected="selected"' : ''; ?>>Other</option>
                </select>
            </p>
            <p>
                <label>Password: </label>
                <input type="password" name="user_pass" id="user_pass" value="" class="validate[required]"/>
            </p>
            <p>
                <label>Confirm Password: </label>
                <input type="password" name="con_password" id="con_password" value="" class="validate[required, equals[user_pass]]"/>
            </p>
            <p>
                <label></label>
                <input type="checkbox" name="term_condition" id="term_condition" value="1" class="validate[required]"/> I accept all <a href="<?php echo site_url('ts-cs');?>" target="_blank">Terms & Conditions</a> 
            </p>
            <p>
                <label></label>
                <img src="<?php echo get_template_directory_uri(); ?>/captcha/CaptchaSecurityImages.php?width=100&height=40&characters=5" />
            </p>
            <p>
                <label>Verification Code: </label>
                <input id="security_code" name="security_code" type="text" class="validate[required]"/>
            </p>
            <?php //do_action('register_form');?>
            <p>
                <input type="hidden" name="package_type" value="<?php echo $_POST['package_type']; ?>">
                <input type="submit" name="submit_reg" value="Register" class="signup" />
            </p>
        </form>
    </section>
</section>

<?php get_footer();?>