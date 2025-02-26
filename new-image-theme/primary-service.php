<?php
/*
Template Name: Основные услуги
*/
?>
<?php
    the_post();
    $content = get_the_content(); 
    $content = apply_filters( 'the_content', $content );
    $content = str_replace( ']]>', ']]>', $content );
    $text_and_images = get_text_and_image($content);
    $paragraph_array = $text_and_images[0];
    $img_set = $text_and_images[1];
?>
<?php get_header(); ?>
    <div class="primary-services-container <?php $post->post_name ?>">
        <div class="side left-side">
            <div class="left-side-header"><?php echo array_shift($paragraph_array[0]) ?></div>
            <div class="left-side-info">
                <?php 
                    foreach($paragraph_array[0] as $paragraph){
                        echo $paragraph;
                    }
                ?>
            </div>
            <div class="left-side-footer"><img src="<?php echo get_template_directory_uri().'/assets/img/contrast_logo_blue.png' ?>" alt=""></div>
        </div>
        <div class="side right-side">
            <?php
                foreach($img_set[0] as $img){
                    print_img_tag($img);
                } 
            ?>
        </div>
    </div>
<?php get_footer('services'); ?>
