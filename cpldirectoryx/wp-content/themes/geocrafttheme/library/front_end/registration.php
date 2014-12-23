<?php

function geocraft_reg_proceed_form($success_redirect = '') {

    if (!$success_redirect)
        $success_redirect = $_SERVER['HTTP_REFERER'];
    $multi_site = WP_ALLOW_MULTISITE;
    if (get_option('users_can_register') || $multi_site == true) :

        global $posted;

        $posted = array();
        $errors = new WP_Error();

        if (isset($_POST['register']) && $_POST['register']) {

            require_once( ABSPATH . WPINC . '/registration.php');

            // Get (and clean) data
            $fields = array(
                'your_username',
                'your_email',
                'your_password',
                'your_password_2',
				'capcode'
				);
            foreach ($fields as $field) {
                $posted[$field] = stripslashes(trim($_POST[$field]));
            }

            $user_login = sanitize_user($posted['your_username']);
            $user_email = apply_filters('user_registration_email', $posted['your_email']);

            // Check the username
            if ($posted['your_username'] == '')
                $errors->add('empty_username', __('<strong>ERROR</strong>: ' . ENTER_UNM, THEME_SLUG));
            elseif (!validate_username($posted['your_username'])) {
                $errors->add('invalid_username', __('<strong>ERROR</strong>: ' . INVLD_UNM, THEME_SLUG));
                $posted['your_username'] = '';
            } elseif (username_exists($posted['your_username']))
                $errors->add('username_exists', __('<strong>ERROR</strong>: ' . LRD_UNM, THEME_SLUG));

            // Check the e-mail address
            if ($posted['your_email'] == '') {
                $errors->add('empty_email', __('<strong>ERROR</strong>: ' . TYPE_EMAIL, THEME_SLUG));
            } elseif (!is_email($posted['your_email'])) {
               $errors->add('invalid_email', __('<strong>ERROR</strong>: ' . EMAIL_ISNT, THEME_SLUG));
                $posted['your_email'] = '';
            } elseif (email_exists($posted['your_email']))
                $errors->add('email_exists', __('<strong>ERROR</strong>: ' . LRD_EMAIL, THEME_SLUG));

            // Check Passwords match
            if ($posted['your_password'] == '')
                $errors->add('empty_password', __('<strong>ERROR</strong>: ' . ENTER_PW, THEME_SLUG));
            elseif ($posted['your_password_2'] == '')
                $errors->add('empty_password', __('<strong>ERROR</strong>: ' . PW_AGAIN, THEME_SLUG));
            elseif ($posted['your_password'] !== $posted['your_password_2'])
                $errors->add('wrong_password', __('<strong>ERROR</strong>: ' . PW_NT_EQUAL, THEME_SLUG));
     session_start();
	// Get captcha value from session
	 $sessionCaptcha = $_SESSION['captcha'];
	 
			if($posted['capcode'] == '')
			$errors->add('empty_captcha', __('<strong>ERROR</strong>: ' . "Please enter captcha code", THEME_SLUG));
		elseif ($posted['capcode'] != $sessionCaptcha)
			$errors->add('wrong_captcha', __('<strong>ERROR</strong>: ' . "Please enter correct captcha code", THEME_SLUG));
					
            //do_action('register_post', $posted['your_username'], $posted['your_email'], $errors);
            $errors = apply_filters('registration_errors', $errors, $posted['your_username'], $posted['your_email']);
//print_r($errors);
            if (!$errors->get_error_code()) {
                $user_pass = $posted['your_password'];
                $user_id = wp_create_user($posted['your_username'], $user_pass, $posted['your_email']);
                if (!$user_id) {
                    $errors->add('registerfail', sprintf(__('<strong>ERROR</strong>: Couldn&#8217;t register you... please contact the <a href="mailto:%s">webmaster</a> !', THEME_SLUG), get_option('admin_email')));
                    return array('errors' => $errors, 'posted' => $posted);
                }

                // Change role
                wp_update_user(array('ID' => $user_id, 'role' => 'contributor'));

                wp_new_user_notification($user_id, $user_pass);

                $secure_cookie = is_ssl() ? true : false;

                wp_set_auth_cookie($user_id, true, $secure_cookie);

                ### Redirect
                wp_redirect($success_redirect);
                exit;
            } else {
                return array('errors' => $errors, 'posted' => $posted);
            }
        }
    endif;
}

function geocraft_register_form($action = '') {
    global $posted;
    $multi_site = WP_ALLOW_MULTISITE;
    if (get_option('users_can_register') || $multi_site == true) :
        if (!$action)
            $action = site_url('wp-login.php?action=register');
       // $captcha_value1 = geocraft_captcha1();
        //$captcha_value2 = geocraft_captcha2();
       // $geocraft_sbs_captcha = $captcha_value1 + $captcha_value2;
        ?>
        <div id="registration_form">
            <div class="register">
                <h4><?php echo CRT_AC; ?></h4>
                <form name="registration" id="reg_form" action='<?php echo $action;?>' method="post">
                    <div class="row">
                        <label for="user_login"><?php echo USR_NM; ?><span class="required">*</span></label>
                        <input type="text" id="user_login" name="your_username" value="<?php if (isset($posted['your_username'])) echo $posted['your_username']; ?>"/>
                        <span id="user_error"></span>
                    </div>
                    <div class="row">
                        <label for="email"><?php echo EMAIL; ?><span class="required">*</span></label>
                        <input type="text" id="email" name="your_email" value="<?php if (isset($posted['your_email'])) echo $posted['your_email']; ?>"/>
                        <span id="email_error"></span>
                    </div>
                    <div class="row">
                        <label for="rpassword"><?php echo ENTR_PW; ?><span class="required">*</span></label>
                        <input style=" width: 245px !important;
                               height: 28px !important;
                               border: 1px solid #dddcdc;
                               padding-left: 5px;
                               -webkit-border-radius: 3px;
                               -moz-border-radius: 3px;
                               border-radius: 3px;
                               margin-bottom: 3px;" type="password" id="rpassword" name="your_password" value=""/>
                        <span id="pw_error"></span>
                    </div>
                    <div class="row">
                        <label for="password2"><?php echo ENTR_PW_AGN; ?><span class="required">*</span></label>
                        <input style=" width: 245px !important;
                               height: 28px !important;
                               border: 1px solid #dddcdc;
                               padding-left: 5px;
                               -webkit-border-radius: 3px;
                               -moz-border-radius: 3px;
                               border-radius: 3px;
                               margin-bottom: 3px;" type="password" id="password2" name="your_password_2" value=""/>
                        <span id="pw_error2"></span>
                    </div>
                    <?php //if(geocraft_get_option('reg_captcha') == 'on'){ ?>
                    <div class="row">
                        <input type="text" placeholder="<?php echo LEADCP; ?>"  name="capcode" id="capcode"  value=""/>
                        <span class="captcha_error"></span>
						</br>
						<?php $cap_path = LIBRARYURL."controls/captcha.php";
				        $refresh_cap_path = LIBRARYURL."controls/images/reload.png";
				        ?>
                      <span><img style="border: 1px solid #dcdbdb;" src="<?php echo $cap_path; ?>"/>
		<a href=""><img src="<?php echo $refresh_cap_path; ?>"/></a></span>
                    </div>
                    <?php// } ?>
                    <?php /*if(geocraft_get_option('reg_terms') == 'on'){ ?>
                    <div class="row">
                     <input type="checkbox" id="terms" name="terms"/>
                     <label><?php echo sprintf(__('I agree to the <a target="_new" href="%s">Terms and conditions</a>.',THEME_SLUG),  geocraft_get_option('gc_terms')); ?></label>
                        <span style="display:block;" class="term_error"></span>
                        <inpu type="hidden" name="termcheck" id="termcheck" value="true"/>
                    </div>
                    <?php }else{ ?>
                    <inpu type="hidden" name="termcheck" id="termcheck" value=""/>
                    <?php }*/
					?>
					<div class="row">
                        <input type="submit" id="reg" name="register" value="<?php echo "Register"; ?>" class="submit" tabindex="103" />
                        <input type="hidden" name="user-cookie" value="1" />
                    </div>
                </form>
            </div>
        </div> 
	
	<?php include_once(LIBRARYPATH . 'js/registration_validation.php'); ?>
    <?php endif; ?>
<?php }
/*
function validate_captcha_code(){
session_start();
	// Get captcha value from session
	 $sessionCaptcha = $_SESSION['captcha'];
    $requestCaptcha=$_POST['code'];
	 if (strCmp(strToUpper($sessionCaptcha),strToUpper($requestCaptcha)) == 0)
		echo "yes";
	else
		echo "no";
die(0);
}
add_action( 'wp_ajax_validate_captcha_code', 'validate_captcha_code' );
add_action( 'wp_ajax_nopriv_validate_captcha_code', 'validate_captcha_code' );
*/
 ?>