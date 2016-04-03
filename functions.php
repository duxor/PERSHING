<?php 

function resursi(){
    wp_enqueue_style('style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts','resursi');

add_action('after_setup_theme', 'localization_setup');
function localization_setup(){
    load_theme_textdomain('pershing', get_template_directory() . '/languages');
}

//Navigation Menus
register_nav_menus([
    'primary'=>__('Main Menu','pershing'),
    'footer'=>__('Footer Menu','pershing')
]);

class Duxor_Bootstrap_Nav_Walker extends Walker_Nav_Menu {
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat( "\t", $depth );
		$output .= "\n$indent<ul role=\"menu\" class=\" dropdown-menu\">\n";
	}
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
//GLYPHICON to $item->attr_title
        $item->title=explode('##',$item->title);
        $item->attr_title='glyphicon-'.$item->title[1];
        $item->title=$item->title[0];
//end::GLYPHICON to $item->attr_title            
		if ( strcasecmp( $item->attr_title, 'divider' ) == 0 && $depth === 1 ) {
			$output .= $indent . '<li role="presentation" class="divider">';
		} else if ( strcasecmp( $item->title, 'divider') == 0 && $depth === 1 ) {
			$output .= $indent . '<li role="presentation" class="divider">';
		} else if ( strcasecmp( $item->attr_title, 'dropdown-header') == 0 && $depth === 1 ) {
			$output .= $indent . '<li role="presentation" class="dropdown-header">' . esc_attr( $item->title );
		} else if ( strcasecmp($item->attr_title, 'disabled' ) == 0 ) {
			$output .= $indent . '<li role="presentation" class="disabled"><a href="#">' . esc_attr( $item->title ) . '</a>';
		} else {
			$class_names = $value = '';
			$classes = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes[] = 'menu-item-' . $item->ID;
			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
			if ( $args->has_children )
				$class_names .= ' dropdown';
			if ( in_array( 'current-menu-item', $classes ) )
				$class_names .= ' active';
			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
			$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
			$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
			$output .= $indent . '<li' . $id . $value . $class_names .'>';
			$atts = array();
			$atts['title']  = ! empty( $item->title )	? $item->title	: '';
			$atts['target'] = ! empty( $item->target )	? $item->target	: '';
			$atts['rel']    = ! empty( $item->xfn )		? $item->xfn	: '';
			if ( $args->has_children && $depth === 0 ) {
				$atts['href']   		= '#';
				$atts['data-toggle']	= 'dropdown';
				$atts['class']			= 'dropdown-toggle';
				$atts['aria-haspopup']	= 'true';
			} else {
				$atts['href'] = ! empty( $item->url ) ? $item->url : '';
			}
			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );
			$attributes = '';
			foreach ( $atts as $attr => $value ) {
				if ( ! empty( $value ) ) {
					$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}
			$item_output = $args->before;
			if ( ! empty( $item->attr_title ) )
				$item_output .= '<a'. $attributes .'><span class="glyphicon ' . esc_attr( $item->attr_title ) . '"></span>&nbsp;';
			else
				$item_output .= '<a'. $attributes .'>';
			$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
			$item_output .= ( $args->has_children && 0 === $depth ) ? ' <span class="caret"></span></a>' : '</a>';
			$item_output .= $args->after;
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
	}
	public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
        if ( ! $element )
            return;
        $id_field = $this->db_fields['id'];
        if ( is_object( $args[0] ) )
           $args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );
        parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }
	public static function fallback( $args ) {
		if ( current_user_can( 'manage_options' ) ) {
			extract( $args );
			$fb_output = null;
			if ( $container ) {
				$fb_output = '<' . $container;
				if ( $container_id )
					$fb_output .= ' id="' . $container_id . '"';
				if ( $container_class )
					$fb_output .= ' class="' . $container_class . '"';
				$fb_output .= '>';
			}
			$fb_output .= '<ul';
			if ( $menu_id )
				$fb_output .= ' id="' . $menu_id . '"';
			if ( $menu_class )
				$fb_output .= ' class="' . $menu_class . '"';
			$fb_output .= '>';
			$fb_output .= '<li><a href="' . admin_url( 'nav-menus.php' ) . '">'.__('Add a menu','pershing').'</a></li>';
			$fb_output .= '</ul>';
			if ( $container )
				$fb_output .= '</' . $container . '>';
			echo $fb_output;
		}
	}
}

function mytheme_comment($comment, $args, $depth) {
    //if ( 'div' === $args['style'] ) {
        $tag       = 'div';
        $add_below = 'comment';
    /*} else {
        $tag       = 'li';
        $add_below = 'div-comment';
    }*/
    ?>
    <<?php echo $tag ?> <?php comment_class(empty($args['has_children'])?'':'parent')?> id="comment-<?php comment_ID()?>">
    <?php if ( 'div' != $args['style'] ) : ?>
        <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
    <?php endif; ?>
    <div class="comment-author vcard col-sm-3">
        <?php if ( $args['avatar_size'] != 0 ) echo get_avatar($comment,$args['avatar_size'],null,null,['class'=>'img-circle']); ?>
        <?php printf( __( '<cite class="fn">%s</cite> <span class="says">says:</span>','pershing'), get_comment_author_link() ); ?>
    </div>
<div class="col-sm-9">            
    <?php if ( $comment->comment_approved == '0' ) : ?>
         <em class="comment-awaiting-moderation"><?php __('Your comment is awaiting moderation.','pershing'); ?></em>
          <br />
    <?php endif; ?>

    <div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>">
        <?php
        /* translators: 1: date, 2: time */
        printf( __('%1$s at %2$s','pershing'), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link(__( '(Edit)','pershing'), '  ','');
        ?>
    </div>

    <div class="comment-text"><?php echo get_comment_text(); ?></div>
    <div class="reply">
        <?php comment_reply_link(array_merge($args,['add_below'=>$add_below,'depth'=>$depth,'max_depth'=>$args['max_depth'],'reply_text'=>__('Reply','pershing')] ) ); ?>
    </div>
    
</div>    
    <?php if ( 'div' != $args['style'] ) : ?>
        </div>
    <?php endif; ?>
        </<?php echo $tag ?>>
    <?php
    }

function get_top_ancestor_id(){
    global $post;
    
    if($post->post_parent){ 
        $ancestors=array_reverse(get_post_ancestors($post->ID));
        return $ancestors[0];
    }
    return $post->ID;
}
function has_children(){
    global $post;
    $pages=get_pages('child_of='.$post->ID);
    return count($pages);
}
// Widgets
add_action('after_setup_theme','addWidgets');
function addWidgets(){
    register_sidebar([
        'name'=>'Segment Area',
        'id'=>'segment1'
    ]);
}

//PERSHING Theme Settings
/*
    1. dodajMeni()=> add_menu_page($page_title, $menu_title, $capability, $menu_slug, callable $function = '', $icon_url='', $position = null)
    2. add_action('admin_menu', 'dodajMeni')
    3. ucitajStranicu() 
        => forma action=options.php
        => settings_fields()
        => do_settings_sections()
        

    register_setting('ID_OPTIONS','OPTION_NAME_IN_DB');
    add_settings_section(
        'ID_SECTION', 
        __('SECTION_DESCRIPTION','pershing'), 
        'DISPLAY_FUNCTION', 
        'SHOW_PAGE_/ID_OPTION/.php'
    );
        add_settings_field(
            'ID_FIELD',
            __('FIELD_NAME','pershing'),
            'DISPLAY_FUNCTION',
            'SHOW_PAGE_/ID_OPTION/.php',
            'ID_SECTION',
            [
                'type'      => 'text',
                'id'        => 'y_coo',
                'name'      => 'y_coo',
                'desc'      => __('Y coordinate','pershing'),
                'std'       => '',
                'label_for' => 'y_coo',
                'class'     => 'css_class'
            ]
        );        
*/

//PERSHING Theme Settings
function pershing_theme_menu(){
    add_menu_page( 'PERSHING Settings', 'PERSHING', 'manage_options', 'pershing_theme_options.php', 'pershing_theme_page');  
}
add_action('admin_menu', 'pershing_theme_menu');
function pershing_theme_page(){
?>
        
        
        
        
        
    <div class="section panel">
        <h1>PERSHING Settings</h1>
        <div class="wrap">
            <div id="icon-options-general" class="icon32"></div>
            <?php settings_errors(); ?>
            <?php
                $active_tab = get_active_tab_options();/*"basic_options";
                if(isset($_GET["tab"]))
                {
                    if($_GET["tab"] == "basic_options")
                    {
                        $active_tab = "basic_options";
                    }
                    else
                    {
                        $active_tab = "advanced_options";
                    }
                }*/
            ?>
            <h2 class="nav-tab-wrapper">
                <a href="?page=pershing_theme_options.php" class="nav-tab <?php if($active_tab == 'basic_options'){echo 'nav-tab-active';} ?> "><?php _e('Basic Options', 'pershing'); ?></a>
                <a href="?page=pershing_theme_options.php&tab=advanced_options" class="nav-tab <?php if($active_tab == 'advanced_options'){echo 'nav-tab-active';} ?>"><?php _e('Advanced Options', 'pershing'); ?></a>
                <a href="?page=pershing_theme_options.php&tab=about_options" class="nav-tab <?php if($active_tab == 'about_options'){echo 'nav-tab-active';} ?>"><?php _e('About', 'pershing'); ?></a>
            </h2>
        </div>
        <?php if(function_exists($active_tab)) $active_tab(); ?>
        <p><?php echo __('Created by','pershing'); ?> <a href="http://dusanperisic.com">Dusan Perisic</a>.</p>
    </div>
    <?php
}
function get_active_tab_options(){
    if(isset($_GET["tab"])){
        if($_GET["tab"] == "basic_options") return 'basic_options';
        if($_GET["tab"] == "advanced_options") return 'advanced_options';
        if($_GET["tab"] == "about_options") return 'about_options';
    }
    return 'basic_options';
}
function basic_options(){?>
    <script src="<?php bloginfo('template_directory'); ?>/js/jquery.min.js"></script>
    <script src="http://maps.google.com/maps/api/js"></script>
    <script src="<?php bloginfo('template_directory');?>/js/gmaps-picker.js"></script>
    <form method="post" action="options.php" class="gllpLatlonPicker">
        <?php 
            settings_fields('pershing_location_options');
            do_settings_sections('pershing_location_options.php');?>
        <div id="googleMap" class="gllpMap" style="width: 800px; height: 300px;"></div>
        <?php
            submit_button(__('Save map settings','pershing'));
        ?>
    </form>
    <form method="post" enctype="multipart/form-data" action="options.php">
        <?php 
            settings_fields('pershing_front_img');
            do_settings_sections('pershing_front_img.php');
            submit_button(__('Save background settings','pershing'));
        ?>
    </form><?php
}
function advanced_options(){?>
    <div class="col-sm-12" style="margin:60px 0">
        <h1><?php echo _e('Advanced Options are available in PERSHING Premium theme.','pershing');?></h1>    
    </div><?php
}
function about_options(){?>
    <div class="col-sm-12" style="margin:60px 0">
        <h1><?php echo _e('Page is under construction.','pershing');?></h1>    
    </div><?php
}
/******************************************
*********************
*********************   ACTIONS
*********************
*******************************************/
add_action('admin_init', 'actions');
function actions(){
    pershing_location_register_settings();
    pershing_custom_background_register_settings();
}

/******************************************
*********************
*********************   PLAY FUNCTIONS
*********************
*******************************************/
function pershing_location_register_settings(){
    register_setting('pershing_location_options', 'pershing_location_options');//(_id_options_,_option_name_in_database)
    add_settings_section(
        'front_map_location_section', 
        __('Location for front page map','pershing'), 
        'pershing_display_section', 
        'pershing_location_options.php'
    );
    //Show Map
        add_settings_field(
            'show_map',
            __('Show Map','pershing'),
            'pershing_display_setting',
            'pershing_location_options.php',
            'front_map_location_section',
            [
                'type'      => 'checkbox',
                'id'        => 'show_map',
                'name'      => 'show_map',
                'desc'      => __('Show map with location on my front page.','pershing'),
                'std'       => '',
                'label_for' => 'show_map',
                'class'     => 'css_class'
            ]
        );
    //X coo
        add_settings_field(
            'x_coo',
            __('X coordinate','pershing'),
            'pershing_display_setting',
            'pershing_location_options.php',
            'front_map_location_section',
            [
                'type'      => 'readonly',
                'id'        => 'x_coo',
                'name'      => 'x_coo',
                'desc'      => __('X coordinate','pershing'),
                'std'       => '',
                'label_for' => 'x_coo',
                'class'     => 'css_class',
                'class2'    => 'gllpLatitude'
            ]
        );
    //Y coo
        add_settings_field(
            'y_coo',
            __('Y coordinate','pershing'),
            'pershing_display_setting',
            'pershing_location_options.php',
            'front_map_location_section',
            [
                'type'      => 'readonly',
                'id'        => 'y_coo',
                'name'      => 'y_coo',
                'desc'      => __('Y coordinate','pershing'),
                'std'       => '',
                'label_for' => 'y_coo',
                'class'     => 'css_class',
                'class2'    => 'gllpLongitude'
            ]
        );
    //ZOOM coo
        add_settings_field(
            'map_zoom',
            __('Map zoom','pershing'),
            'pershing_display_setting',
            'pershing_location_options.php',
            'front_map_location_section',
            [
                'type'      => 'readonly',
                'id'        => 'map_zoom',
                'name'      => 'map_zoom',
                'desc'      => __('Map zoom','pershing'),
                'std'       => '',
                'label_for' => 'map_zoom',
                'class'     => 'css_class',
                'class2'    => 'gllpZoom'
            ]
        );
}
function pershing_custom_background_register_settings(){
    register_setting('pershing_front_img','pershing_front_img','handle_file_upload');
    add_settings_section(
        'pershing_front_img_section', 
        __('Front Background','pershing'), 
        'pershing_display_section', 
        'pershing_front_img.php'
    );
    add_settings_field(
        'img_show',
        __('Show custom front background','pershing'),
        'pershing_front_img_show_display',
        'pershing_front_img.php',
        'pershing_front_img_section',
        [
            'type'      => 'checkbox',
            'id'        => 'img_show',
            'name'      => 'img_show',
            'desc'      => __('Show my background','pershing'),
            'std'       => '',
            'label_for' => 'pershing_front_img_show',
            'class'     => 'css_class'
        ]
    );
    add_settings_field(
        'front_img',
        __('Front background','pershing'),
        'pershing_front_img_show_display',
        'pershing_front_img.php',
        'pershing_front_img_section',
        [
            'type'      => 'img',
            'id'        => 'front_img',
            'name'      => 'front_img',
            'desc'      => __('Choice image','pershing'),
            'std'       => '',
            'label_for' => 'front_img',
            'class'     => 'css_class'
        ]
    );
}
function handle_file_upload($options){
    if($_FILES['pershing_front_img']['tmp_name']['front_img']){
        $img=[
            'name'      =>$_FILES['pershing_front_img']['name']['front_img'],
            'tmp_name'  =>$_FILES['pershing_front_img']['tmp_name']['front_img'],
            'type'      =>$_FILES['pershing_front_img']['type']['front_img'],
            'size'      =>$_FILES['pershing_front_img']['size']['front_img'],
            'error'     =>$_FILES['pershing_front_img']['error']['front_img']
        ];
        $urls = wp_handle_upload($img, array('test_form' => FALSE));
        return [
            'img_show'=>$_POST['pershing_front_img']['img_show']?1:0,
            'front_img'=>$urls["url"]
        ];  
    }
    $options = get_option( 'pershing_front_img' );
    $options['img_show']=$_POST['pershing_front_img']['img_show']?1:0;
    return $options;
}

/******************************************
*********************
*********************   DISPLAY FUNCTIONS
*********************
*******************************************/
function pershing_display_section($section){ }
function pershing_display_setting($args){
    show_input($args,'pershing_location_options');
}
function pershing_front_img_show_display($args){
    show_input($args,'pershing_front_img');
}
function show_input($args,$oname){   
    extract( $args );
    $option_name = $oname;
    $options = get_option( $option_name );
    if(!in_array($type,['text_only','checkbox_only','img_only'])){
        $options[$id] = stripslashes($options[$id]);  
        $options[$id] = esc_attr( $options[$id] );  
    }
    switch ( $type ) {  
        case 'readonly':  
            echo "<input class='regular-text$class $class2' type='text' id='$id' name='" . $option_name . "[$id]' value='$options[$id]' readonly/>";  
            break;
        case 'text':  
            echo "<input class='regular-text$class $class2' type='$type' id='$id' name='" . $option_name . "[$id]' value='$options[$id]' />";  
            break;
        case 'text_only':  
            echo "<input class='regular-text$class $class2' type='text' id='$id' name='" . $option_name . "' value='$options' />";  
            break;
        case 'checkbox':  
            echo "<input class='regular-text$class' type='$type' id='$id' name='" . $option_name . "[$id]' value='1' ".($options[$id]==1?'checked':'')."/>";  
            break;  
        case 'checkbox_only':  
            echo "<input class='regular-text$class' type='checkbox' id='$id' name='" . $option_name . "' value='1' ".($options==1?'checked':'')."/>";  
            break;  
        case 'img':
            echo    "<input class='regular-text$class' type='file' id='$id' name='".$option_name."[$id]' />".
                    "<div style='width:40%;float:right'><img style='width:100%' src='$options[$id]'></div>";
            break;
        case 'img_only':
            echo    "<input class='regular-text$class' type='file' id='$id' name='".$option_name."' />".
                    "<div style='width:40%;float:right'><img style='width:100%' src='$options'></div>";
            break;
        
    }
    echo ($desc != '') ? "<br /><span class='description'>$desc</span>" : "";  
}