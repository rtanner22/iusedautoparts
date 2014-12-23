<?php
ob_start();
setcookie("name", "value", 100);
/**
 * Metabox arrays for retrieving
 * Custom values
 */
$key = 'geocraft_meta';
$checkbox_meta = array(
    'F_checkbox1' => array(
        'name' => THEME_SLUG . '_f_checkbox1',
        'description' => __('', 'geocraft'),
        'label' => META_LBL1,
        'type' => 'checkbox'
    ),
    'F_checkbox2' => array(
        'name' => THEME_SLUG . '_f_checkbox2',
        'description' => __('', 'geocraft'),
        'label' => META_LBL2,
        'type' => 'checkbox'
    ),
);

$listing_type_meta = array(
    'free_listing' => array(
        'name' => THEME_SLUG . '_listing_type',
        'description' => __('', THEME_SLUG),
        'label' => META_LBL3,
        'value' => 'free',
        'type' => 'radio'
    ),
    'pro_listing' => array(
        'name' => THEME_SLUG . '_listing_type',
        'description' => __('', THEME_SLUG),
        'label' => META_LBL4,
        'value' => 'pro',
        'type' => 'radio'
    ),
);

$listing_expiry = array(
    'expired_listing' => array('name' => THEME_SLUG.'_listing_expiry',
    'label' => '(Optional) Format: mm/dd/yy hh:mm:ss',
    'type' => 'text',
    'description' => 'You can set any custom expiry date here. Leave blank if you want the expiry date to be calculated automatically depending upon the listing active period setting inside payment settings under theme options panel.'
));
/**
 * Function for create meta box
 * @global string $key 
 */
function geocraft_create_meta_box() {
    global $key;
    if (function_exists('add_meta_box')) {
        add_meta_box('listing-type-meta-boxes', __('Listing Type', THEME_SLUG), 'geocraft_listing_type_meta', POST_TYPE, 'normal', 'high');
        add_meta_box('checkbox-meta-boxes', __('Feature This Listings', THEME_SLUG), 'geocraft_checkbox_meta', POST_TYPE, 'normal', 'high');
        add_meta_box('expiry-meta-boxes', __('Set Expiry Date', THEME_SLUG), 'geocraft_listing_expiry', POST_TYPE, 'normal', 'high');
    }
}

/**
 * Function for creating 
 * Checkbox meta box
 * @global type $post
 * @global array $checkbox_meta
 * @global string $key 
 */
function geocraft_checkbox_meta() {
    global $post, $checkbox_meta, $key;
    ?>
    <div class="form-wrap">
        <?php
        wp_nonce_field('listing_meta_box', 'listing_nonce', true, true);
        foreach ($checkbox_meta as $check_box) {
            $data = get_post_meta($post->ID, $check_box['name'], true);
            ?>
            <div class="form-required" style="margin:0; padding: 0 8px">
                <label for="<?php echo $check_box['name']; ?>" style="color: #666; padding-bottom: 8px; overflow:hidden; zoom:1; "><?php echo $check_box['title']; ?></label>
                <?php
                if (!isset($check_box['type']))
                    $check_box['type'] = 'input';
                switch ($check_box['type']) :
                    case "checkbox" :
                        ?>
                        <input style="float:left; width:20px;" id="<?php echo $check_box['name']; ?>" class="checkbox of-input" type="checkbox" name="<?php echo $check_box['name']; ?>" <?php
                echo checked($data, 1, false);
                if ($data) {
                    echo 'checked="checked"';
                }
                        ?> />
                        <label for="<?php echo $check_box['name']; ?>" class="check-label"><?php echo $check_box['label']; ?></label>
                        <?php
                        if ($check_box['description'])
                            echo wpautop(wptexturize($check_box['description']));
                        break;
                    default :
                        ?>
                        <input type="text" style="width:320px; margin-right: 10px; float:left" name="<?php echo $check_box['name']; ?>" value="<?php echo htmlspecialchars($data); ?>" /><?php
                if ($check_box['description'])
                    echo wpautop(wptexturize($check_box['description']));
                        ?>
                        <?php
                        break;
                endswitch;
                ?>				
                <div class="clear"></div>
            </div>
        <?php } ?>
    </div>
    <?php
}

/**
 * Function : geocraft_listing_type_meta()
 * @global type $post
 * @global array $listing_type_meta
 * @global string $key 
 */
function geocraft_listing_type_meta() {
    global $post, $listing_type_meta, $key;
    ?>
    <div class="form-wrap">
        <?php
         wp_nonce_field('listing_meta_box', 'listing_nonce', true, true);
        foreach ($listing_type_meta as $listing) {
            $data = get_post_meta($post->ID, $listing['name'], true);
            ?>
            <div class="form-required" style="margin:0; padding: 0 8px">
                <label for="<?php echo $listing['name']; ?>" style="color: #666; padding-bottom: 8px; overflow:hidden; zoom:1; "><?php echo $listing['title']; ?></label>
                <?php
                switch ($listing['type']) :
                    case "radio" :
                        ?>
                        <input style="float:left; width:20px;" id="<?php echo $listing['value']; ?>" class="radio of-input" value="<?php echo $listing['value']; ?>" type="radio" name="<?php echo $listing['name']; ?>" <?php
                echo checked($data, true, true);
                if ($data == $listing['value']) {
                    echo 'checked="checked"';
                }
                if ($data == '' && $listing['value'] == 'free') {
                    echo 'checked="checked"';
                }
                        ?> />
                        <label for="<?php echo $listing['value']; ?>"><?php echo $listing['label']; ?></label>
                        <?php
                        if ($listing['description'])
                            echo wpautop(wptexturize($listing['description']));
                        break;
                    default :
                        ?>                      
                        <?php
                        break;
                endswitch;
                ?>				
                <div class="clear"></div>
            </div>
        <?php } ?>
    </div>
    <?php
}
function geocraft_listing_expiry(){
    global $listing_expiry,$post;
    ?>
     <div class="form-wrap">
        <?php
        wp_nonce_field('listing_meta_box', 'listing_nonce', true, true);
        foreach ($listing_expiry as $expiry) {
            $data = get_post_meta($post->ID, 'gc_listing_duration', true);
            ?>
            <div class="form-required" style="margin:0; padding: 0 8px">
                <label for="<?php echo $expiry['name']; ?>" style="color: #666;overflow:hidden;"><?php echo $expiry['label']; ?></label>
                <?php                
                switch ($expiry['type']) :
                    case "text" :              
                        ?>
                        <input id="<?php echo $expiry['name']; ?>" type="text" style="width:320px; margin-right: 10px; float:left" name="<?php echo $expiry['name']; ?>" value="<?php echo htmlspecialchars($data); ?>" />
                            <?php
                if ($expiry['description'])
                    echo wpautop(wptexturize($expiry['description']));
                        ?>
                        <?php
                        break;
                endswitch;
                ?>				
                <div class="clear"></div>
            </div>
        <?php } ?>
    </div> 
<?php
}
/**
 * @global type $post
 * @global array $meta_boxes
 * @global string $key
 * @param type $post_id
 * @return type 
 */
function geocraft_save_meta_box($post_id) {
    global $post, $key, $checkbox_meta, $listing_type_meta,$listing_expiry;
    if (!isset($_POST['listing_nonce']))
            return $post_id;
    if (!current_user_can('edit_post', $post_id))
        return $post_id;
    if($checkbox_meta){
        foreach ($checkbox_meta as $check_box) {
            update_post_meta($post_id, $check_box['name'], $_POST[$check_box['name']]);
        }
    }
    if($listing_type_meta){
        foreach ($listing_type_meta as $listing_type) {
            update_post_meta($post_id, $listing_type['name'], $_POST[$listing_type['name']]);
        }
    }
    if($listing_expiry){
        foreach ($listing_expiry as $expiry) {
            update_post_meta($post_id, 'gc_listing_duration', $_POST[$expiry['name']]);
        }
    }
}

add_action('admin_menu', 'geocraft_create_meta_box');
add_action('save_post', 'geocraft_save_meta_box');
?>