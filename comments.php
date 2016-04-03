<div class="container">
    <?php if (post_password_required()) return; ?>
    <div id="comments" class="article-title">
        <?php if (have_comments()) : ?>
            <div class="article-title">
                <h2>
                    <?php printf(_n('1 Comment','%1$s Comments',get_comments_number(),'pershing'),number_format_i18n(get_comments_number()), get_the_title());?>
                </h2>
                <hr>
            </div>
            <?php
                wp_list_comments( 'type=comment&callback=mytheme_comment' );
                paginate_comments_links(); 
                else : echo __('No comments for this post.','pershing'); 
        endif; ?>
        
        
        <div class="col-sm-8">
        <?php 
            comment_form([
                'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title">',
                'title_reply_after'  => '</h2>',
                
                'class_form'        =>  'form-horizontal',
                'class_submit'      =>  'btn btn-primary',
                'title_reply'       =>  __('Leave a Reply','pershing'),
                'title_reply_to'    =>  __('Leave a Reply to %s','pershing'),
                'cancel_reply_link' =>  __('Cancel Reply','pershing'),
                'label_submit'      =>  __('Post Comment','pershing'),
                'comment_field'     => '<p class="comment-form-comment"><textarea id="comment" name="comment" class="form-control" cols="45" rows="8" aria-required="true"></textarea></p>',
                'comment_notes_before'=>'<p class="comment-notes">'.__( 'Your email address will not be published.','pershing').($req?$required_text:'').'</p>',
                'fields'=>[
                    'author' =>
                        '<p class="comment-form-author"><label for="author">'.__('Name','pershing').'</label> '.( $req ? '<span class="required">*</span>':'').'<input id="author" name="author" class="form-control" type="text" value="'.esc_attr( $commenter['comment_author']).'" size="30"'.$aria_req.' /></p>',

                  'email' =>
                    '<p class="comment-form-email"><label for="email">'.__('Email','pershing').'</label> '.($req?'<span class="required">*</span>':'').'<input id="email" name="email" class="form-control" type="text" value="'.esc_attr($commenter['comment_author_email']).'" size="30"'.$aria_req.'/></p>',

                  'url' =>
                    '<p class="comment-form-url"><label for="url">'.__('Website','pershing').'</label>'.'<input id="url" name="url" class="form-control" type="text" value="'.esc_attr($commenter['comment_author_url']).'" size="30" /></p>',
                ],
                'must_log_in' => '<p class="must-log-in">'.sprintf(__( 'You must be <a href="%s">logged in</a> to post a comment.','pershing' ),wp_login_url( apply_filters( 'the_permalink', get_permalink()))).'</p>',
                'logged_in_as'=>'<p class="logged-in-as">'.sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account.">Log out?</a>','pershing'),admin_url( 'profile.php' ),$user_identity, wp_logout_url(apply_filters('the_permalink',get_permalink()))).'</p>',
		    ]); 
                
        ?>
        </div>    
    </div>
</div>