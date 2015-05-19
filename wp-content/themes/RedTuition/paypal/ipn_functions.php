<?php
    function func_web_accept($arr_ipn){
        global $wpdb;
        $custom_data = explode(',', $arr_ipn['custom']);
        $user_id = $custom_data[0];
        $product_id = $custom_data[1];
        $product_value = str_replace('$', '', get_field('package_price', $product_id, TRUE));
        $results = $wpdb->get_results("SELECT * FROM wp_users WHERE ID = '".$user_id."'");
        if($wpdb->num_rows == 1){
            foreach ($results as $result) {
                $user_email = $result->user_email;
                $user_display_name = $result->display_name;
            }
        }
        if($arr_ipn['mc_gross'] == $product_value){
            update_user_meta($user_id,'is_paid_user', 1);
            $data_arr = array(
                'id_user' => $user_id,
                'id_package' => $product_id,
                'payment_date' => date('Y-m-d H:i:s')
            );
            $wpdb->insert('wp_user_payment', $data_arr);
            //******  A mail has been thrown after executing this code ************** //
            $from = get_option('admin_email');
            $from_name = "Red Tuition";
            $headers = "From: $from_name <$from>\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
            $subject = "Your payment has been successful completed.";
            $msg = "Dear {$user_display_name}<br/><br/>";
            $msg .= "Thank you for making payment. Your payment details are as follows.<br/>";
            $msg .= "<br/>";
            $msg .= "Package Name: ".$arr_ipn['item_name']."<br/>";
            $msg .= "Transaction ID: ".$arr_ipn['txn_id']."<br/>Transaction amount: ".$arr_ipn['mc_gross']." ".$arr_ipn['mc_currency']."<br/>";
            $msg .= "Payment Date: ".$arr_ipn['payment_date']."<br/>";
            $msg .= "PayPal Email Address: ".$arr_ipn['payer_email']."<br/><br/>";
            $msg .= "Best Regards<br/>Red Tuition Team";
            wp_mail( $user_email, $subject, $msg, $headers );
            
            // *********** Mail to admin ************ //
            $to = get_option('admin_email');
            $from = $user_email;
            $from_name = $user_display_name;
            $headers = "From: $from_name <$from>\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
            $subject = $user_display_name. " has made payment for ".$arr_ipn['item_name'];
            $msg = "Please find the details below.<br/><br/>";
            $msg .= "Package Name: ".$arr_ipn['item_name']."<br/>";
            $msg .= "Transaction ID: ".$arr_ipn['txn_id']."<br/>Transaction amount: ".$arr_ipn['mc_gross']." ".$arr_ipn['mc_currency']."<br/>";
            $msg .= "Payment Date: ".$arr_ipn['payment_date']."<br/>";
            $msg .= "PayPal Email Address: ".$arr_ipn['payer_email']."<br/><br/>";
            
            wp_mail( $to, $subject, $msg, $headers );
            
        }else{
            $from = get_option('admin_email');
            $from_name = "Red Tuition";
            $headers = "From: $from_name <$from>\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
            $subject = "There is an errot regarding transaction";
            $msg = "Dear {$user_display_name}<br/><br/>";
            $msg .= "Your payment is not successfully completed. This seems to be item value and transction amount are not same.<br/>";
            $msg .= "Your payment details are as follows.<br/>";
            $msg .= "<br/>";
            $msg .= "Package Name: ".$arr_ipn['item_name']."<br/>";
//            $msg .= "Quantity: ".$arr_ipn['quantity']."<br/>";
            $msg .= "Transaction ID: ".$arr_ipn['txn_id']."<br/>Transaction amount: ".$arr_ipn['mc_gross']." ".$arr_ipn['mc_currency']."<br/>";
            $msg .= "Payment Date: ".$arr_ipn['payment_date']."<br/>";
            $msg .= "PayPal Email Address: ".$arr_ipn['payer_email']."<br/><br/>";
            $msg .= "If you have any query please contact to administrator.<br/><br/>";
            $msg .= "Best Regards<br/>Red Tuition Team";
            wp_mail( $user_email, $subject, $msg, $headers );
        }
        
    }
?>