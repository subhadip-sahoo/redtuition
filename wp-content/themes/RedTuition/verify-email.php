<?php
    /* Template Name: Verify Email */
    session_start();
    global $wpdb, $user_ID;
    if($user_ID){
        wp_safe_redirect(site_url());
        exit();
    }
    if(!isset($_REQUEST['verify_id'])){
        wp_redirect(site_url());
        exit();
    }
    if(get_user_meta($_REQUEST['verify_id'], 'account_status', true) == 1){
        wp_redirect(site_url());
        exit();
    }
    if(isset($_REQUEST['activation_key'])){
        $keys = $wpdb->get_results("SELECT * FROM $wpdb->users WHERE ID = ".$_REQUEST['verify_id'], ARRAY_A);
        if($wpdb->num_rows == 1){
            foreach ($keys as $key) {
                if($key['user_activation_key'] == $_REQUEST['activation_key']){
                    if(get_user_meta($_REQUEST['verify_id'], 'account_status', true) == 0){
                        update_user_meta($_REQUEST['verify_id'], 'account_status', 1);
                        $_SESSION['session_msg'] = 'Your account has been activated. Please login.';
                        wp_safe_redirect(site_url('login'));
                        exit();
                    }else{
                        wp_redirect(site_url());
                        exit();
                    }
                }else{
                    wp_redirect(site_url());
                    exit();
                }
            }
        }else{
            wp_redirect(site_url());
            exit();
        }
    }
    else{
        if(get_user_meta($_REQUEST['verify_id'], 'account_status', true) == 0){
            update_user_meta($_REQUEST['verify_id'], 'account_status', 1);
            $_SESSION['session_msg'] = 'Your account has been activated. Please login.';
            wp_safe_redirect(site_url('login'));
            exit();
        }else{
            wp_redirect(site_url());
            exit();
        }
    }