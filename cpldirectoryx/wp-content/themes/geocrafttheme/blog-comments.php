<?php
    if (comments_open()) :
        ?>
        <div id="commentsbox">            
                <?php if (post_password_required()) : ?>
                <p class="nopassword">
            <?php echo PASSWORDPROTECT; ?>
                </p>
            </div>
            <!-- #comments -->
                <?php return;
            endif; ?>
        <div id="comments">
        <?php if (have_comments()) : ?>                
                <div class="comment_list">
                    <h3 id="comments"><?php comments_number(NO_RESPONSE, ONE_RESPONSE, RESPONSE);?></h3>
                    <ol class="commentlist">
                <?php wp_list_comments(array('callback' => 'geocraft_commentslist', 'avatar_size' => 63)); ?>
                    </ol>
                </div>
        <?php endif; // end have_comments() ?>
        </div>
        <?php
        global $post, $wp_query;
        $post = $wp_query->post;
        $comment_add_flag =  geocraft_is_user_can_add_comment($post->ID);
        if ($comment_add_flag) {
            _e('<h6>Review has already been inserted from this computer. So no other reviews are allowed from this computer on this post.</h6>',THEME_SLUG);
        }
        ?>
        <?php if ('open' == $post->comment_status && !$comment_add_flag) : ?>
            <div id="respond">
                <div class="post-info">
                    <h2><?php echo POST_CMT_MSG; ?></h2>
                  </div>
                <div class="comment_form">
                    <?php if (get_option('comment_registration') && !$user_ID) : ?>
                        <p class="comment_message"><?php echo YOUMUST; ?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>"><?php echo LOGGEDIN; ?></a> <?php echo POSTCOMMENT; ?></p>
                        <?php else : ?>
                        <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
                            <?php global $post;
                            if ($post->post_type == POST_TYPE) { ?> 
                                <span class="rating_text"><?php echo RATING_MSG; ?> </span>
                                <p class="commpadd" style="margin: 10px 0 10px 0;"><span class="comments_rating"> <?php geocraft_get_rating(); ?> </span> </p>
                            <?php } ?>
                                <?php if ($user_ID) : ?>
                                <p class="comment_message" style="margin-bottom: 10px;"><?php echo LOGGEDAS; ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account"><?php echo LOGOUT; ?></a></p>


                                <p class="clearfix">
                                    <label for="comment"><?php echo COMMENT; ?></label>
                                    <textarea name="comment" id="comment" cols="50" rows="7" tabindex="1"></textarea>
                                </p>

                            <?php else : ?>

                                <p class="clearfix">
                                    <label for="author"><?php echo NAME; ?> <small><?php echo REQUIRED; ?></small></label>
                                    <input type="text" name="author" id="author" tabindex="2" value="" onfocus="if (this.value == 'Your name') {this.value = '';}" placeholder="<?php echo YOUR_NAME; ?>" />
                                </p>

                                <p class="clearfix">
                                    <label for="email"><?php echo EMAIL; ?> <small><?php echo REQUIRED; ?></small></label>
                                    <input type="text" name="email" id="email" tabindex="3" value="" placeholder="<?php echo EMAIL_TEXT; ?>" />
                                </p>

                                <p class="clearfix">
                                    <label for="url"><?php echo WEBSITE; ?></label>
                                    <input type="text" name="url" id="url" tabindex="4" value="" placeholder="<?php echo WEBSITE_TEXT; ?>"/>
                                </p>

                                <p class="clearfix">
                                    <label for="comment"><?php echo COMMENT; ?></label>
                                    <textarea name="comment" id="comment" cols="50" tabindex="5" rows="7"  placeholder="<?php echo COMMENT; ?>"></textarea>
                                </p>
                                 <?php endif; ?>
                                <div class="submit">
                                <input name="submit" type="submit" id="submit" tabindex="6" value="<?php echo SUBMIT; ?>" />
                                <p id="cancel-comment-reply">
                                <?php cancel_comment_reply_link() ?>
                                </p>
                            </div>
                            <div>
                                <?php comment_id_fields(); ?>
                            </div>
                        </form>
                <?php endif; // If registration required and not logged in  ?>
                </div>
        <?php endif; // if you delete this the sky will fall on your head  ?>
        </div>
        <?php if (!$comment_add_flag) { ?>
            </div>
        <?php } ?>
    <?php endif; // end ! comments_open() ?>
