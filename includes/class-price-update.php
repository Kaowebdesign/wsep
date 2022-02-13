<?php

class PriceUpdate{
    
    public $usd;
    public $eur;
 
    public function __construct($usd, $eur)
    {
        $this->usd = $usd;
        $this->eur = $eur;
     
    }

    public function updateWoccommercePrice()
    {
        update_option('wsep_currencies', array('usd' => $this->usd, 'eur' => $this->eur));

        // $products = array(
        //     'posts_per_page' => '-1',
        //     'post_type' => 'product',
        // );
        // $loop = new WP_Query($products);
        // while ( $loop->have_posts() ) : $loop->the_post();
        // global $product;

        //     if(get_post_meta ( $loop->post->ID , '_currency_type', true ) != null && get_post_meta ( $loop->post->ID , '_currency_price', true ) != null) {

        //         if (get_post_meta ( $loop->post->ID , '_currency_type', true ) == 'USD') {
        //             update_post_meta(  $loop->post->ID, '_regular_price', floatval(get_post_meta ( $loop->post->ID , '_currency_price', true )) * floatval($this->usd) ); // Update regular price
        //             // $product->save();
        //             remove_action( 'save_post', 'set_private_categories' );
        //             wp_update_post( array( 'ID' => $loop->post->ID, 'post_status' => 'private' ) );
        //             add_action( 'save_post', 'set_private_categories' );
                    
        //             wc_delete_product_transients(  $loop->post->ID );
        //         } else {
        //             update_post_meta(  $loop->post->ID, '_regular_price', floatval(get_post_meta ( $loop->post->ID , '_currency_price', true )) * floatval($this->eur) ); // Update regular price
        //             // $product->save();
        //             wc_delete_product_transients(  $loop->post->ID );
        //         }

        //     }
        // endwhile; 
        // wp_reset_query();
    }
}