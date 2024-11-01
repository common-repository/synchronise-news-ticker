<?php
/*
Plugin Name: Synchronise News Ticker
Plugin URI:  http://synchronisebd.com/product/synchronise-news-ticker-wordpress-plugin/
Description: Synchronise News Ticker is a lightweight plugin used to animating a simple news ticker.You can customise type speed, post count, category selection, color,background color via shortcode.
Author: Mohammad Jahidul Alam Rudro
Version: 1.0
Author URI: http://synchronisebd.com/
*/

if(!defined('ABSPATH'))
{
    exit;
}
//Grab the latest Jquery
function synchroniseTickerLatestJquery()
{
    wp_enqueue_script('jquery');
    add_action('init','synchroniseTickerLatestJquery');

}

//to Initialize Js link and add in head section

function synchroniseNewsTickerJs()
{
    wp_enqueue_script('ticker_Js',plugins_url('/js/ticker.js',__FILE__),array('jquery'),1.0,false);
    wp_enqueue_style('ticker_css',plugins_url('/css/ticker.css',__FILE__));

}
add_action('init','synchroniseNewsTickerJs');

function tickerListShortCode($atts)
{
    extract(shortcode_atts(array(
        'id'=>'tickerId',
        'category'=>'',
        'count'=>'5',
        'category_slug'=>'category_ID',
        'speed'=>'3000',
        'typespeed'=>'50',
        'color'=>'#0000',
        'backgroundcolor'=>'#F8F0DB',
        'text'=>'LATEST',
    ),$atts,'projects'));
    $q=new WP_Query(
        array('posts_per_page'=>$count,'post_type'=>'post',$category_slug=>$category)
    );

    $list=' <script type="text/javascript">
        jQuery(document).ready(function () {

            jQuery("#synchroniseTicker'.$id.'").ticker({
            itemSpeed:'.$speed.',
            cursorSpeed:'.$typespeed.',

            });
        });

    </script>
    <div style="background-color:'.$backgroundcolor.'" id="synchroniseTicker'.$id.'" class="ticker"><strong style="background-color:'.$color.'">'.$text.'</strong><ul class="ticker_list">';
    while($q->have_posts()):$q->the_post();
        $id=get_the_ID();
        $list.='
        <li class="ticker_item"><a class="ticker_text" href="'.get_permalink().'">'.get_the_title().'</a></li>
        ';
        endwhile;
    $list.='</ul></div>';
    wp_reset_query();
    return $list;

}
add_shortcode('ticker_list','tickerListShortCode');


