<?php
/*

Plugin Name:  Pure PHP Pagination

Plugin URI: https://surecode.me

Description: Pagination Plugin for WordPress

Version: 1.0.1

Author: Kirill Shur(SureCode Marketing)

License: GPLv2

*/
add_shortcode('pure_php_pagination','pure_php_pagination_method');

function pure_php_pagination_method($atts)
{
  $pur_php_pagination_parameters = [
    "ppp" => null,
    "post_type" => null,
    "page_number" => null,
    "category_name" => null,
    "taxonomy" => null,
    "order" => null,
    "type_of_pagination" => null
   ];

$attrset = shortcode_atts($pur_php_pagination_parameters,$atts);

global $wpdb;
global $post;
$ppp_category =  $attrset['category_name'];
$ppp_post_type = $attrset['post_type'];
$ppp_posts_perpage = $attrset['ppp'];
$paged = 1;
$args = array(
'posts_per_page' => $ppp_posts_perpage,
'post_type' => $ppp_post_type,
'category_name' => $ppp_category,
'paged' =>  $paged
);
$query = new WP_Query( $args );
$totalpages = ceil($query->found_posts / $ppp_posts_perpage);
 ob_start();
	 if ( $query->have_posts() ) {

 ?>
  <div class="outer_wrapper">

 <ul class="ppp_list">
<?php
   while ( $query->have_posts() ) : $query->the_post();
?>
 <li class="ppp_list_item">
  <div class="ppp_list_item_cotent">
    <div class="ppp_list_item_cotent_image">
     <?php
       $post_thumbnail_id = get_post_thumbnail_id( $post->ID );
       $attachment_url=wp_get_attachment_image_src($post_thumbnail_id,'full');
      ?>
      <img src="<?php print($attachment_url[0]);?>" alt="image">
    </div>
    <?php
       print_r($post->post_excerpt);
     ?>
  </div>
  <div class="readmore">
     <a target="_blank" href="<?php print(get_permalink());?>" class="read_more">Read More</a>
  </div>
 </li>
<?php
    endwhile;
 ?>
</ul>
<div class="ppp_list_pagination" data-top="<?php print($attrset["type_of_pagination"]);?>">
  <div class="loader_wrap">
    <span id="loader"><img src="<?php  echo plugins_url('/images/loader.gif',__FILE__) ?>" alt="loader"/><span>
  </div>
 <ul class="ppp_list_pagination_list" data-maxpages="<?php print($totalpages);?>" data-type="<?php print($ppp_post_type);?>" data-cat="<?php print($ppp_category);?>" data-ppp="<?php print($ppp_posts_perpage);?>" data-ajax="<?php print(admin_url('admin-ajax.php'));?>">
   <li class="ppp_list_pagination_list_item">
     <a class="ppp_list_pagination_list_item_link pagination_link" data-num="1" href="#">First</a>
   </li>
   <li class="ppp_list_pagination_list_item">
     <a class="ppp_list_pagination_list_item_link pagination_link" data-num="1" href="#">1</a>
   </li>
    <?php
        for ($i=0; $i < $totalpages; ++$i) {
        if($i == 0){
    ?>

    <?php
  }elseif ($i ==  $totalpages) {
     ?>
      <?php
    } elseif($i != 1 ){
       ?>
       <li class="ppp_list_pagination_list_item">
         <a class="ppp_list_pagination_list_item_link pagination_link" data-num="<?php print($i);?>" href="#"><?php print($i);?></a>
       </li>
      <?php
       }
      }
     ?>
     <li class="ppp_list_pagination_list_item">
       <a class="ppp_list_pagination_list_item_link pagination_link" data-num="<?php print($totalpages);?>" href="#"><?php print($totalpages);?></a>
     </li>
     <li class="ppp_list_pagination_list_item">
       <a class="ppp_list_pagination_list_item_link pagination_link" data-num="<?php print($totalpages);?>" href="#">Last</a>
     </li>
 </ul>
 <div class="load_more_wrap" data-maxpages="<?php print($totalpages);?>" data-type="<?php print($ppp_post_type);?>" data-cat="<?php print($ppp_category);?>" data-ppp="<?php print($ppp_posts_perpage);?>" data-ajax="<?php print(admin_url('admin-ajax.php'));?>">
   <span class="load_more_wrap_button">LoadMore</span>
 </div>
</div>
</div>
<?php
 }
 return ob_get_clean();
}

add_action('init','pure_php_pagination_get_data');

function pure_php_pagination_get_data(){

    function pure_php_pagination_get_data_method(){
     if(isset($_POST["get_data"])){
      global $wpdb;
      global $post;
      $paged = sanitize_text_field(isset($_POST['page_number'])) ? sanitize_text_field($_POST['page_number']) : 0;

      $args = array(
      'posts_per_page' => sanitize_text_field($_POST["ppp"]),
      'post_type' => sanitize_text_field($_POST["post_type"]),
      'category_name' => sanitize_text_field($_POST["category"]),
      'paged' =>  $paged
     );
      $query = new WP_Query( $args );
      $ppp_posts_perpage = sanitize_text_field($_POST["ppp"]);
      $totalpages = ceil($query->found_posts / $ppp_posts_perpage);
      $ppp_post_type = sanitize_text_field($_POST["post_type"]);
      $ppp_category = sanitize_text_field($_POST["category"]);

        if ( $query->have_posts() ) {
           ?>
          <?php
          while ( $query->have_posts() ) : $query->the_post();
          ?>
            <li class="ppp_list_item" data-curpage="<?php print($paged);?>">
              <div class="ppp_list_item_cotent">
                <div class="ppp_list_item_cotent_image">
                 <?php
                   $post_thumbnail_id = get_post_thumbnail_id( $post->ID );
                   $attachment_url=wp_get_attachment_image_src($post_thumbnail_id,'full');
                  ?>
                  <img src="<?php print($attachment_url[0]);?>" alt="image">
                </div>
              <?php
                  print_r($post->post_excerpt);
               ?>
             </div>
             <div class="readmore">
                <a target="_blank" href="<?php print(get_permalink());?>" class="read_more">Read More</a>
             </div>

            </li>
         <?php
          endwhile;
         }
        ?>

      <?php
       wp_reset_postdata();
       die();

     }elseif (isset($_POST["scroll"])) {
       global $wpdb;
       global $post;
       $paged = sanitize_text_field(isset($_POST['page_number'])) ? sanitize_text_field($_POST['page_number']) : 0;

       $args = array(
       'posts_per_page' => sanitize_text_field($_POST["ppp"]),
       'post_type' => sanitize_text_field($_POST["post_type"]),
       'category_name' => sanitize_text_field($_POST["category"]),
       'paged' =>  $paged
      );
       $query = new WP_Query( $args );
       $ppp_posts_perpage = sanitize_text_field($_POST["ppp"]);
       $totalpages = ceil($query->found_posts / $ppp_posts_perpage);
       $ppp_post_type = sanitize_text_field($_POST["post_type"]);
       $ppp_category = sanitize_text_field($_POST["category"]);

         if ( $query->have_posts() ) {
            ?>
           <?php
           while ( $query->have_posts() ) : $query->the_post();
           ?>
             <li class="ppp_list_item" data-curpage="<?php print($paged);?>">
               <div class="ppp_list_item_cotent">
               <?php
                   print_r($post->post_excerpt);
                ?>
              </div>
              <div class="readmore">
                 <a target="_blank" href="<?php print(get_permalink());?>" class="read_more">Read More</a>
              </div>

             </li>
          <?php
           endwhile;
          }
         ?>

       <?php
        wp_reset_postdata();
        die();
     }
    }
    add_action("wp_ajax_pure_php_pagination","pure_php_pagination_get_data_method");

    add_action("wp_ajax_nopriv_pure_php_pagination","pure_php_pagination_get_data_method");
}



   add_action('wp_enqueue_scripts','pure_php_pagination_style');

   function pure_php_pagination_style(){
     wp_enqueue_style('purephppagination',plugins_url('/css/style.css',__FILE__));
     wp_enqueue_script('jquery');
     wp_enqueue_script('paginscript',plugins_url('/js/custom.js',__FILE__));
   }
add_filter( 'show_admin_bar', '__return_false' );
