   <?php wp_footer();?>

    <div class="footer" <?php if(!is_front_page()):?> style="margin-top:30px;"<?php endif;?> >
        <div class="container">
            <div class="col-sm-4 info">
                <b><?php bloginfo('name');?></b><br>
                <a href="<?php bloginfo('url') ?>"><?php bloginfo('url') ?></a><br>
                <a href="mailto:<?php bloginfo('admin_email');?>"><?php bloginfo('admin_email');?></a>
            </div>
            <div class="col-sm-4">
                
            </div>
            <?php 
                $arg=[
                    'theme_location'=>'footer',
                    'container'=>'nav',
                    'container_class'=>'col-sm-4',
                ];
                wp_nav_menu($arg);
            ?>
            <div class="col-sm-12 copyright"><?php bloginfo('name'); ?> &copy; <?php echo date('Y'); ?></div>
        </div>
    </div>

    <script src="<?php bloginfo('template_directory');?>/js/funkcije.js"></script>
    <script src="<?php bloginfo('template_directory');?>/js/bootstrap.min.js"></script>
</body>
</html>