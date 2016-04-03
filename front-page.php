<?php get_header(); ?>

<div class="home-front-page" style="background-image:url(<?php 
                                    $img=get_option('pershing_front_img');
                                    if($img['img_show'] && $img['front_img']) echo $img['front_img'];
                                    else echo get_bloginfo('template_directory').'/img/about_img.jpg';
                                    ?>);">
    <div class="container">
        <div class="jumbotron">
            <h1><i class="glyphicon glyphicon-briefcase"></i> <?php bloginfo('name');?></h1>
            <h2><?php bloginfo('description');?></h2>
        </div>
    </div>
</div>
<?php
    $colors=['blue','red','purple'];
    $pages=get_pages([
        'number'        =>  3,
        'sort_column'   =>  'menu_order'
    ]);
if($pages){
    foreach($pages as $i=>$post): 
        setup_postdata( $post ); ?>
        <div class="segment segment-light-<?php echo $colors[$i]; ?>">
            <div class="container">
                <h2><?php the_title(); ?></h2>
                <?php the_content(); ?>
            </div>
        </div>
<?php 
    endforeach;
    wp_reset_postdata(); 
}else{
    get_template_part( 'loop' );
}
    $location=get_option('pershing_location_options');
    if($location['show_map']==1) {
?>
    <div id="googleMap"></div>
    <script src="http://maps.google.com/maps/api/js"></script>
    <script>
        var myCenter = new google.maps.LatLng(<?php if($location['x_coo']&&$location['y_coo']) echo '"'.$location['x_coo'].'","'.$location['y_coo'].'"'; else echo'"44.798831","20.4465872"'?>);
        function initialize() {
            var mapProp = {
                center:myCenter,
                zoom:<?php if($location['map_zoom']) echo $location['map_zoom']; else echo 11;?>,
                scrollwheel:false,
                draggable:false,
                mapTypeId:google.maps.MapTypeId.ROADMAP
            };
            var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
            var marker=new google.maps.Marker({position:myCenter,});marker.setMap(map);
        }

        google.maps.event.addDomListener(window, 'load', initialize);
    </script>
<?php } ?>    
    <div class="segment segment-text-black">
        <div class="container">
            <form action="#" class="form-horizontal" method="post">
                <div class="form-group">
                    <label class="control-label col-sm-4"><?php echo __('Name','pershing');?></label>
                    <div class="col-sm-8">
                        <input name="name" class="form-control" type="text" placeholder="<?php echo __('Name','pershing');?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4"><?php echo __('Email','pershing');?></label>
                    <div class="col-sm-8">
                        <input name="email" class="form-control" type="email" placeholder="<?php echo __('Email','pershing');?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4"><?php echo __('Message','pershing');?></label>
                    <div class="col-sm-8">
                        <textarea name="message" class="form-control" type="text" placeholder="<?php echo __('Message','pershing');?>"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4"></label>
                    <div class="col-sm-8">
                        <button name="submit" class="btn btn-primary" type="button" onclick="send()"><i class="glyphicon glyphicon-floppy-disk"></i> <?php echo __('Submit','pershing');?></button>
                    </div>
                </div>
            </form>    
        </div>
    </div>
<script>
function send(){
    $.post('<?php bloginfo('template_directory');?>/contactmail.php',null,function(data){
        alert('>'+data+'<');
    })
}
</script>
<?php get_footer(); ?>