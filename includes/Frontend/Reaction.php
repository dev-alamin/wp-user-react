<?php 
namespace AA\WPUserReactionButton\Frontend;

class Reaction{
    
    public function dispatch_reaction(){
        
        add_action('wp_ajax_wp_urb_save_reaction', [ $this, 'save_reaction'] );
        add_action('wp_ajax_nopriv_wp_urb_save_reaction', [ $this, 'save_reaction'] );

        add_filter( 'the_content', [ $this, 'reactions' ] );

    }
    
    public function reactions( $content ) {
        // Check if we're on a singular post type and it's not an attachment
        if ( is_singular() && ! is_attachment() ) {
            // Get the selected post type and position from the database
            $selected_post_type = get_option( 'wp_urb_selected_post_type' );
            $selected_position = get_option( 'wp_urb_selected_position' );
            
            // Check if the selected post type matches the current post type
            if ( in_array( get_post_type( ), $selected_post_type ) ) {
                // Output the reaction icons at the top or bottom of the post content
                if ( $selected_position === 'top' ) {
                    $content = $this->icon_html() . $content;
                } else {
                    $content = $content . $this->icon_html();
                
                }
            }
        }
        return $content;
    }
    
    public function icon_html() {
        $post_id = get_the_ID();
        $output = '<div class="wp-urb-reactions" data-post-id="' . $post_id . '" id="wp-urb-reactions-' . $post_id . '">';
        $output .= '<div class="wp-urb-reaction-like" data-reaction="like">';
        $output .= '<i class="fa fa-thumbs-up"></i><span class="count"></span>';
        $output .= '</div>';
        $output .= '<div class="wp-urb-reaction-icons">';
        $output .= '<span class="wp-urb-reaction" data-reaction="smile"><i class="fa fa-smile"></i> <span class="count"></span></span>';
        $output .= '<span class="wp-urb-reaction" data-reaction="straight"><i class="fa fa-meh"></i> <span class="count"></span></span>';
        $output .= '<span class="wp-urb-reaction" data-reaction="sad"><i class="fa fa-frown"></i> <span class="count"></span></span>';
        $output .= '</div>';
        $output .= '</div>';
        return $output;
    }
    
    

    public function save_reaction() {
        if (isset($_POST['post_id'])) {
            $post_id = intval($_POST['post_id']);
            $reaction = $_POST['reaction'];

            $smile_count = 0;
            $straight_count = 0;
            $sad_count = 0;

            $smile = get_post_meta( $post_id, 'wp_urb_smile_count', true );
            $straight = get_post_meta( $post_id, 'wp_urb_straight_count', true );
            $sad = get_post_meta( $post_id, 'wp_urb_sad_count', true );


            update_post_meta($post_id, 'wp_urb_smile_count', $smile_count+1);
            update_post_meta($post_id, 'wp_urb_straight_count', $straight_count+1);
            update_post_meta($post_id, 'wp_urb_sad_count', $sad_count+1);
            wp_send_json(array(
                'smile_count' => $smile_count,
                'straight_count' => $straight_count,
                'sad_count' => $sad_count
            ));
        }
        wp_die('Invalid request.');
        wp_die();
    }
    
    
}