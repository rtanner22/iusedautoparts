<script type="text/javascript">
    jQuery(document).ready(function() {
        var list_title = jQuery('#list_title').val();
        jQuery('#listing_title').val(list_title);
        jQuery('input:checkbox[name=be_paid]').change(function() {
            if (this.checked) {
                jQuery("#upgrade_form").slideDown();
            }
            else {
                jQuery("#upgrade_form").slideUp();
            }
        });

    });
</script>
<?php if($listing_type == 'free'){ ?>
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery('#upgrade_form').submit(function() {
            var chklength = jQuery("input[name='price_select']:checked").length;
            if (chklength > 0) {
                return true;
            } else {
                alert("Please select atleast one package!");
                return false;
            }
        });
    });
</script>
<?php } ?>
<?php
if (file_exists(FRONTENDPATH . 'submit_validation.php')) {
    require_once(FRONTENDPATH . 'submit_validation.php');
}
?>
<form style="display:none;" name="upgrade_form" id="upgrade_form" action="<?php $_SERVER[PHP_SELF]; ?>" method="post" enctype="multipart/form-data"> 
    <script type="text/javascript" src="<?php echo LIBRARYURL; ?>js/package_price.js"></script>
    <?php if($listing_type == 'pro'){ ?>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            jQuery('#featured').show();
        });
    </script>
    <?php } ?>
    <?php if ($listing_type == 'free') { ?>
        <h4 class="row_title"><?php echo SLT_PKG; ?></h4>
        <div class="form_row" id="packages_checkbox">                
            <?php
            global $wpdb, $price_table_name;
            $packages = $wpdb->get_results("SELECT * FROM $price_table_name WHERE status=1");
            $count = 1;
            if ($packages):
                foreach ($packages as $package):
                    $valid_to = $package->validity_per;
                    if ($valid_to == 'D'):
                        $valid_to = 'Days';
                    endif;
                    if ($valid_to == 'M'):
                        $valid_to = "Months";
                    endif;
                    if ($valid_to == 'Y'):
                        $valid_to = 'Years';
                    endif;
                    $rebill_time = $package->rebill_time;
                    if ($package->package_type != 'pkg_free') {
                        ?>            
                        <div class="package">
                            <label><input type="radio" <?php if ($package->package_cost == 0) echo "checked='checked'"; ?> value="<?php echo $package->package_cost; ?>"  name="price_select" id="price_select<?php echo $count; ?>" />
                                <input type="hidden" class="f_home" name="f_home" value="<?php echo $package->feature_amount; ?>"/>
                                <input type="hidden" class="f_cate" name="f_cate" value="<?php echo $package->feature_cat_amount; ?>"/>
                                <input type="hidden" class="<?php echo $package->package_type; ?>" name="<?php echo $package->package_type; ?>" value="<?php echo $package->validity; ?>"/>
                                <input type="hidden" class="<?php echo $package->package_type_period; ?>" name="<?php echo $package->package_type_period; ?>" value="<?php echo $package->validity_per; ?>"/>
                                <input type="hidden" class="is_recurring" name="is_recurring" value="<?php echo $package->is_recurring; ?>"/>
                                <input type="hidden" class="validity" name="validity" value="<?php echo $package->validity; ?>"/>
                                <input type="hidden" class="validity_per" name="validity_per" value="<?php echo $package->validity_per; ?>"/>
                                <input type="hidden" class="pkg_type" name="pkg_type" value="<?php echo $package->package_type; ?>"/>
                                <?php
                                $is_recurring = $package->is_recurring;
                                if ($is_recurring == 1) {
                                    ?>
                                    <input type="hidden" class="f_period" name="f_period" value="<?php echo $package->first_billing_per; ?>"/>
                                    <input type="hidden" class="f_cycle" name="f_cycle" value="<?php echo $package->first_billing_cycle; ?>"/>
                                    <?php
                                    $rebill_time = $package->rebill_time;
                                    if ($rebill_time == 1) {
                                        ?>
                                        <input type="hidden" class="installment" name="installment" value="<?php echo $package->rebill_period; ?>"/>
                                    <?php } ?>
                                    <input type="hidden" class="s_price" name="s_price" value="<?php echo $package->second_price; ?>"/>
                                    <input type="hidden" class="s_period" name="s_period" value="<?php echo $package->second_billing_per; ?>"/>
                                    <input type="hidden" class="s_cycle" name="s_cycle" value="<?php echo $package->second_billing_cycle; ?>"/>
                                <?php } ?>     
                                <input type="hidden" class="is_featured" name="is_featured" value="<?php echo $package->is_featured; ?>"/>                            
                                <input type="hidden" id="price_title" name="price_title" value="<?php echo $package->price_title; ?>"/>
                                <div class="pkg_ct">                                
                                    <h3><?php echo stripslashes($package->price_title); ?></h3>
                                    <p><?php echo stripslashes($package->price_desc); ?></p>
                                    <p class="cost"><span><?php _e('Cost :', THEME_SLUG); ?><?php echo get_option('currency_symbol'); ?><?php echo $package->package_cost; ?></span>                       
                                        <?php
                                        if ($package->package_type == 'pkg_recurring') {
                                            if ($package->first_billing_cycle == "D"):
                                                $first_period = 'Day';
                                            elseif ($package->first_billing_cycle == 'M'):
                                                $first_period = 'Month';
                                            elseif ($package->first_billing_cycle == 'Y'):
                                                $first_period = 'Year';
                                            endif;
                                            if ($package->second_billing_cycle == "D"):
                                                $second_period = 'Days';
                                            elseif ($package->second_billing_cycle == 'M'):
                                                $second_period = 'Month';
                                            elseif ($package->second_billing_cycle == 'Y'):
                                                $second_period = 'Year';
                                            endif;
                                            if ($rebill_time == 1) {
                                                ?>
                                                <span><?php
                                                    //echo "$package->package_cost USD for first $first_period, then $package->second_price USD for every $package->second_billing_per $second_period, for $package->rebill_period installments";
                                                    printf(BILLING_TERM1, get_option('currency_symbol'), $package->package_cost, get_option('currency_code'), $package->first_billing_per, $first_period, get_option('currency_symbol'), $package->second_price, get_option('currency_code'), $package->second_billing_per, $second_period, $package->rebill_period);
                                                    ?></span>  
                                                <?php
                                            } else {
                                                printf(BILLING_TERM2, get_option('currency_symbol'), $package->package_cost, get_option('currency_code'), $package->first_billing_per, $first_period, get_option('currency_symbol'), $package->second_price, get_option('currency_code'), $package->second_billing_per, $second_period);
                                            }
                                        } else {
                                            ?>
                                            <span>Valid Upto : <?php echo $package->validity . "&nbsp;" . $valid_to; ?></span>
                                        <?php } ?>
                                    </p></div></label>

                        </div>               
                        <?php
                        $count++;
                    }
                endforeach;
            endif;
            ?>
        </div>
    <?php } ?>
    <!--Start Row-->
    <div class="form_row" id="featured">   
        <?php
        $package_type = gc_package_type($listing->ID);
        $p_type = '';
        if ($listing_type == 'pro') {
            if ($package_type['txn_type'] == 'Recurring') {
                $p_type = "recurring";
            } elseif ($package_type['txn_type'] == 'One Time') {
                $p_type = 'one';
            }
            $featured_cost = get_featured_cost($p_type);
            $fhome_cost = $featured_cost[0]['feature_amount'];
            $fcat_cost = $featured_cost[0]['feature_cat_amount'];
        }
        ?>
        <label><?php echo IS_FEATURED; ?></label>           
        <div class="field">    
            <?php
            $is_featured = gc_is_featured($listing->ID);
            if (empty($is_featured['feature_home'])) {
                ?>
                <label><input id="feature_h"  type="checkbox" name="feature_h"  value="<?php echo $fhome_cost; ?>" /><?php echo F_HOME; ?> <span><?php echo get_option('currency_symbol'); ?></span><span id="fhome"><?php echo $fhome_cost; ?></span></label>
                <br/>    
            <?php } ?>
            <?php if (empty($is_featured['feature_cat'])) { ?>
                <label><input id="feature_c"  type="checkbox" name="feature_c"  value="<?php echo $fcat_cost; ?>" /><?php echo F_CAT; ?><span><?php echo get_option('currency_symbol'); ?></span><span id="fcat"><?php echo $fcat_cost; ?></span></label>               <?php } ?>
            <br/><br/><span style="display:block;" class="description"><?php echo FEATURED_DES; ?></span>                                 
        </div>
    </div>
    <!--End Row--> 
    <!--Start Row-->
    <div class="form_row">
        <div class="label">
            &nbsp;
        </div>
        <div class="field">
            <span id='loading' style='display:none;'><img src="<?php echo TEMPLATEURL . "/images/loading.gif"; ?>" alt='Loading..' /></span>
        </div> 
    </div>
    <!--Start Row-->
    <div class="form_row">
        <div class="label">
            <label><?php echo TLT_PRICE; ?> <span class="required">*</span></label>
        </div>
        <div class="field">                  
            <style type="text/css">.field span{font-size: 14px;}</style>
            <?php echo get_option('currency_symbol'); ?><span id="pkg_price">0</span>&nbsp;+&nbsp;<?php echo get_option('currency_symbol'); ?><span id="feature_price">0</span>&nbsp;=&nbsp;<?php echo get_option('currency_symbol'); ?><span id="result_price">0</span>
            <input type="hidden" name="listing_title" id="listing_title" value="0"/>
            <input type="hidden" name="billing" id="billing" value="0"/>
            <input type="hidden" name="total_price" id="total_price" value="0"/>  
            <input type="hidden" name="package_title" id="package_title" value=""/>
            <input type="hidden" name="package_validity" id="package_validity" value=""/>
            <input type="hidden" name="package_validity_per" id="package_validity_per" value=""/>
            <input type="hidden" name="package_type" id="package_type" value=""/>
            <?php
            $get_paypal = get_option('pay_method_paypal');
            if (is_array($get_paypal)):
                $paymethod = $get_paypal['key'];
                $paypal_mode_status = $get_paypal['paypal_sandbox'];
            endif;
            $method = '';
            if ($paymethod == 'paypal') {
                if ($paypal_mode_status == 1)
                    $method = "sandbox";
                else
                    $method = "paypal";
            }
            ?>
            <input type="hidden" name="paypal_mode" value="<?php if ($method != '') echo $method; ?>"/>
            <br/><br/>
            <input type="submit" name="upgrade" value="Upgrade"/>
            <br/><br/>
            <span class="description"><?php echo "Click updrade button, if you want to upgrade your listing."; ?></span>
        </div>
    </div>
    <!--End Row-->  
</form>  