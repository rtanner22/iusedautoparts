<?php

class Paypal {

    public $item_name = '';
    public $item_number = 0;
    public $payment_status = '';
    public $payment_amount = 0;
    public $payment_currency = '';
    public $txn_id = '';
    public $receiver_email = '';
    public $payer_email = '';
    public $userid = 0;
    public $post_id = 0;
    public $post_title = '';
    public $status = 0;
    public $payment_method = '';
    public $pay_date = '';
    public $user_name = '';
    public $billing_name = '';
    public $billing_add = '';
    //Recurring variable
    var $pending_reason = '';
    var $recurring_payment_id = '';
    var $payment_cycle = '';
    var $recurring_payment = '';
	
    var $listing_title;
    var $amount;
	public $test;

    function __construct() {
        // parent::__construct();
        $this->geocraft_paypal_trans();
    }

    public function geocraft_paypal_trans() {
        global $current_user;
        get_currentuserinfo();
        // assign posted variables to local variables
        if (isset($_REQUEST['ptype']) && $_REQUEST['ptype'] == 'pstatus'):
            $to_admin = get_option('admin_email');
            $store_name = get_option('blogname');
            $this->item_name = $_POST['item_name'];
            $this->item_number = $_POST['item_number'];
            if ($_REQUEST['recurring'])
                $this->payment_status = $_REQUEST['recurring'];
            else
                $this->payment_status = $_REQUEST['payment_status'];
            if ($_POST['mc_amount1']) {
                $this->payment_amount = $_REQUEST['mc_amount1'];
            } elseif(isset($_REQUEST['amt'])){
                $this->payment_amount = $_REQUEST['amt'];
            }else {
                $this->payment_amount = $_REQUEST['mc_gross'];
            }
            $this->payment_currency = $_REQUEST['mc_currency'];
            if ($_POST['recurring'] == true) {
                $this->txn_id = $_REQUEST['subscr_id'];
            } else {
                $this->txn_id = $_REQUEST['txn_id'];
            }
            $this->receiver_email = $_REQUEST['receiver_email'];
            $this->payer_email = $_REQUEST['payer_email'];

			$this->test = $_REQUEST['txn_type'];
            global $wpdb, $transection_table_name;
            $this->post_id = $_REQUEST['post_id'];
            if ($this->post_id != '') {
                $post_id = $this->post_id;
                $post_author = $wpdb->get_row("select * from $wpdb->posts where ID = '" . $post_id . "'");
            }
            $post_author = $post_author->post_author;
            $this->userid = $current_user->ID;
            $userinfo = get_userdata($post_author);
            $this->post_title = $_REQUEST['post_title'];
            $pkg_type = $_REQUEST['pkg_type'];
            $this->listing_title = $_REQUEST['post_title'];            
            //Checking payment success or not
            if ($this->payment_status == 'Completed' || $this->payment_status == 'Pending' || $this->payment_status == true || $_REQUEST['txn_type'] == 'subscr_signup' || $_REQUEST['st'] == 'Completed') {
                $this->status = 1;
                $this->payment_status = 'Completed';
                $post_status_to_admin = "Payment Received";
                $post_status_to_client = "Your @" . $store_name . " is successfully completed.";
            }

        endif;
    }

}

add_shortcode('pay-status', 'trans_display');

function trans_display($atts) {
    $paypal_init = new Paypal();
    if($paypal_init->status == 1){
        $status = "<h2>Thanks for your payment.</h2>";
        $str = <<<ST
    $status
     Your Listing Title:&nbsp;&nbsp;<b> $paypal_init->listing_title </b><br/>
     Payment Status:&nbsp;&nbsp;<b> $paypal_init->payment_status </b><br/>
     Payment Amount:&nbsp;&nbsp;<b> $paypal_init->payment_amount </b><br/>
    
ST;
    }else{
        $status = "<h2>Your Payment is Failed.</h2>";
        $str = $status;
    }
    /**
     $str .= "Payment Currency:&nbsp;&nbsp;<b> $paypal_init->test </b><br/>";
	 
     Payment Receiver Email:&nbsp;&nbsp;<b> $paypal_init->receiver_email </b><br/>
     Payment Payer Email:&nbsp;&nbsp;<b> $paypal_init->payer_email</b><br/>
     */
    return $str;
}

?>
