<?php get_header(); ?>

<div class="container">

    <?php 
        if(have_posts()) :
            while(have_posts()) : the_post(); ?>
            <h2>
                <a href="<?php the_permalink();?>"><?php the_title(); ?></a>
            </h2>
            <p class="post-info">
                <?php the_time('d.m.Y. H:i'); ?> | <?php echo __('by','pershing');?> <a href="<?php get_author_posts_url(get_the_author_meta('ID'));?>"><?php the_author();?></a>
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
            <p><?php the_content(); ?></p>

            <?php endwhile;
            else :
                echo __( 'Sorry, no posts matched your criteria.','pershing');
         endif;
    ?>
</div>

<?php 
    comments_template();
    get_footer(); 
?>