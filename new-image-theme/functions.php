<?php 
    add_action('wp_enqueue_scripts', 'ni_styles');
    add_action('wp_footer', 'ni_scripts');
    add_action('after_setup_theme', 'menu_reg');
    remove_action( 'shutdown', 'wp_ob_end_flush_all', 1 );

    function menu_reg(){
        add_theme_support('title-tag');
    }

    function ni_styles(){
        wp_enqueue_style('normalize', get_template_directory_uri()."/assets/css/normalize.min.css");
        if(!is_front_page()){
            wp_enqueue_style('services-style', get_template_directory_uri()."/assets/css/services-style.min.css", array('normalize'));
        }else{
            wp_enqueue_style('style', get_template_directory_uri()."/assets/css/style.min.css", array('normalize'));
        }
    }

    function ni_scripts(){
        if(is_front_page()||is_page_template('cards.php')){
            wp_enqueue_script('fss-script', get_template_directory_uri()."/assets/js/fss.min.js");
        }
    }

    function get_text_and_image($source){
        $txt_blocks = [];
        $current = [];
        $imgs = [];
        $tag_with_img = '';
        $source = explode("\n", $source);
        foreach($source as $line){
            $line = trim($line);
            if(startsWith($line, "<p")||startsWith($line, "<a")){
                array_push($current, $line);
            };
            if(startsWith($line, "<h")){
                if(sizeof($current)>0){
                    array_push($txt_blocks, $current);
                    $current = [];
                }
                array_push($current, extract_text_from_h($line));
            };
            if(startsWith($line, "<figure")){
                $img_set = array(
                    "src" => extract_from_attr($line, "src="),
                    "alt" => extract_from_attr($line, "alt="),
                    "title" => extract_from_attr($line, "title=")
                );
                array_push($imgs, $img_set);
            }
        }
        array_push($txt_blocks, $current);
        return [$txt_blocks, $imgs];
    }

    function startsWith($targetStr, $start){
        $len = strlen($start);
        return (substr($targetStr, 0, $len) === $start); 
    }

    function extract_from_attr($str, $attr){
        $attr_len = strlen($attr);
        $start = strpos($str, $attr);
        if($start == false){
            return "";
        };
        $end = strpos($str, "\"", $start + $attr_len + 1);
        return substr($str, $start+$attr_len+1, $end - $start - $attr_len-1);
    }

    function extract_text_from_h($str){
        // return "Заголовок";
        return substr($str, 4, strlen($str)-9);
    }

    function print_sidebar(){
        echo '<div class="sidebar">';
            echo '<div class="logo"><img src="'.get_template_directory_uri().'/assets/img/contrast_logo_inv.png'.'"></div>';
            echo '<div class="phones">';
                echo '<a class="phone-href" href="tel:+74956469779">+7 (495) 646-9779</a>';
                echo '<a class="phone-href" href="tel:+74955053203">+7 (495) 505-3203</a>';
            echo "</div>";
        echo "</div>";
    }
?> 