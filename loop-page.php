    <div class="container justify <?php if(!is_user_logged_in()) echo'top-60';?>">    
        <?php 
            if(have_posts()): while(have_posts()) : the_post(); 
            $arg=[
                'child_of'=>get_top_ancestor_id(),
                'title_li'=>''
            ];?>
        <nav class="col-sm-12 child-page-nav">
            <ul>
                <li class="parent-link"><a href="<?php echo get_the_permalink(get_top_ancestor_id());?>"><?php echo get_the_title(get_top_ancestor_id()); ?></a></li>
                <li class="divider">|</li>
                <?php wp_list_pages($arg); ?>
            </ul>
        </nav>
        <?php
            the_content();
            endwhile;
        else : 
               echo __('No posts.','pershing'); endif;?>
    </div>