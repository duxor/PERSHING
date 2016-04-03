<!--
         _____ _ _ __\/_____ __ _   ___ ___ ___ _ __\/___ _/___
        |_    | | |  ___/   |  \ | |   | __|   | |  ___/ |  __/
         _| | | | |___  | ^ | |  | | ^_| __| ^_| |___  | | |__
        |_____|_,_|_____|_|_|_|__| |_| |___|_|\ _|_____|_|____|

        Hvala što se interesujete za kod :)

        Kontakt za developere: kontakt@dusanperisic.com

-->
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width">
        <title><?php bloginfo('name'); ?></title>
        <link href="<?php bloginfo('template_directory'); ?>/css/bootstrap.min.css" rel="stylesheet">
        <script src="<?php bloginfo('template_directory'); ?>/js/jquery.min.js"></script>
        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>
        <nav class="navbar <?php if(!is_user_logged_in()) echo'navbar-fixed-top';?> navbar-default navbar-c navbar-default-c">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-menu">
                        <span class="sr-only"><?php echo __('Toggle navigation');?></span>
                        <i class="icon-bar"></i>
                        <i class="icon-bar"></i>
                        <i class="icon-bar"></i>
                    </button>
                    <a class="navbar-brand" href="<?php bloginfo('url');?>"><?php bloginfo('name');?></a>
                </div>
                <?php 
                    wp_nav_menu([
                        'theme_location'    => 'primary',
                        'depth'             => 2,
                        'container'         => 'div',
                        'container_class'   => 'collapse navbar-collapse',
                        'container_id'      => 'main-menu',
                        'menu_class'        => 'nav navbar-nav',
                        'fallback_cb'       => 'Duxor_Bootstrap_Nav_Walker::fallback',
                        'walker'            => new Duxor_Bootstrap_Nav_Walker()
                        ]
                    );
                ?>
            </div>
        </nav>