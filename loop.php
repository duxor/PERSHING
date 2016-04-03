    <div class="container justify <?php if(!is_user_logged_in()) echo'top-60';?>">    
        <?php if(have_posts()): while(have_posts()) : the_post(); ?>
        <h1><a href="<?php the_permalink()?>"><?php the_title()?></a></h1>
        <p class="post-info">
            <?php the_date('d.m.Y. H:i');?> | 
            <?php echo __('Posted by','pershing');?> 
            <a href="<?php get_author_posts_url(); ?>"><?php the_author();?></a> | 
            <?php 
                $categories=get_the_category();
                $separator=', ';
                $output=' | '.__('Posted in').' ';
                if($categories){
                    foreach($categories as $category){
                        $output.='<a href="'.get_category_link($category->term_id).'">'.$category->cat_name.'</a>'.$separator;
                    }
                    echo trim($output, $separator);
                }
            ?>
        </p>
        <?php
            the_content();
            endwhile;
        else : 
               echo __('No posts.','pershing'); endif;?>
    </div>