<?php 
namespace AA\WPUserReactionButton\Frontend;

class Reaction{
    
    public function dispatch_reaction(){
        add_action('wp_ajax_wp_urb_save_reaction', [ $this, 'save_reaction'] );
        add_action('wp_ajax_nopriv_wp_urb_save_reaction', [ $this, 'save_reaction'] );

        add_filter( 'the_content', [ $this, 'reactions' ] );
    }
    
    /**
     * Hooking after content
     *
     * @param content $content
     * @return icon
     */
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
    
    /**
     * Html Icon 
     *
     * @return html
     */
    public function icon_html() {
        $post_id = get_the_ID();
        $total_reaction = get_post_meta( $post_id, 'reaction_counts', true);
        $user_id = get_current_user_id();
        $current_reaction = wp_urb_get_reaction( $user_id, $post_id );
        $add_class = $current_reaction ? ' done' : '';
        $reaction_counts = get_post_meta($post_id, 'reaction_counts' );
        $output = '<div class="wp-urb-reactions" data-userid="'. $user_id . '" data-post-id="' . $post_id . '" id="wp-urb-reactions-' . $post_id . '">';
        $output .= '<div class="wp-urb-reaction-like" data-reaction="like">';
        $output .=  '<span class="current-reaction" style="font-size:18px !important;">' . $current_reaction . '</span>';

        $output .= '<span class="reaction-text"></span>';
        $output .= '<span class="reaction-count '. $add_class.'">&#128077; '. $total_reaction .'</span>';
        $output .= '</div>';
        $output .= '<div class="wp-urb-reaction-icons">';
        $output .= '<span class="wp-urb-reaction" data-reaction="smile">&#x1F603; <span class="count"></span></span>';
        $output .= '<span class="wp-urb-reaction" data-reaction="straight">&#x1F610; <span class="count"></span></span>';
        $output .= '<span class="wp-urb-reaction" data-reaction="sad">&#x1F614; <span class="count"></span></span>';
        $output .= '</div>';
        $output .= '</div>';
        return $output;
    }
    
    

    public function save_reaction() {
        $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
        $reaction = isset($_POST['reaction']) ? sanitize_text_field($_POST['reaction']) : '';
    
        if( ! is_user_logged_in() ) {
            echo 'You are not logged in.';
            return;
        }
    
        if ( !wp_verify_nonce( $_POST['nonce'], 'wpurb_reaction_nonce' ) ) {
            wp_send_json_error( 'Invalid nonce' );
        }
        
        $user_id = $_POST['userid'];
        $reaction_meta_key = 'reaction_' . $post_id;
        
        // Check if user already reacted
        $current_reaction = get_user_meta( $user_id, 'reaction_' . $post_id, true );
        if ( $current_reaction && $current_reaction !== $reaction ) {
            // User has already reacted with a different reaction, remove their previous reaction
            $prev_count = get_post_meta( $post_id, 'reaction_count_' . $current_reaction, true );
            $prev_count--;
            update_post_meta( $post_id, 'reaction_count_' . $current_reaction, $prev_count );
        
            $prev_user_count = get_user_meta( $user_id, 'reaction_count_' . $current_reaction, true );
            $prev_user_count--;
            update_user_meta( $user_id, 'reaction_count_' . $current_reaction, $prev_user_count );
        }
        
        // Update post reaction count
        $count = get_post_meta( $post_id, 'reaction_count_' . $reaction, true );
        $count++;
        update_post_meta( $post_id, 'reaction_count_' . $reaction, $count );
        
        // Update user reaction count
        $user_count = get_user_meta( $user_id, 'reaction_count_' . $reaction, true );
        $user_count++;
        update_user_meta( $user_id, 'reaction_count_' . $reaction, $user_count );
        
        // Update user reaction
        update_user_meta( $user_id, 'reaction_' . $post_id, $reaction );
        
        // Update total reactions count
        $total_reactions = array(
            'smile' => intval(get_post_meta($post_id, 'reaction_count_smile', true)),
            'straight' => intval(get_post_meta($post_id, 'reaction_count_straight', true)),
            'sad' => intval(get_post_meta($post_id, 'reaction_count_sad', true))
        );
        $total_count = array_sum($total_reactions);
        update_post_meta($post_id, 'reaction_counts' , $total_count);
        
        wp_send_json_success( array(
            'count' => $count,
            'total_count' => $total_count,
            'reaction' => $reaction
        ) );
    } 
}