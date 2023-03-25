<?php

/**
 * Get reaction
 */
function wp_urb_get_reaction( $user_id, $post_id ){
    $reaction = get_user_meta( $user_id, 'reaction_' . $post_id, true );
    $emoji = '';

    if( $reaction == 'smile' ) {
        $emoji = '&#x1F603;';
    }elseif( $reaction == 'straight' ) {
        $emoji = '&#x1F610;';
    }elseif( $reaction == 'sad' ) {
        $emoji = '&#x1F614;';
    }

    return $emoji;
}

/**
 * Get Reacted Posts|Pages
 *
 * @return Array
 */
function wp_urb_get_reacted_posts(){
    global $wpdb;

    $selected_post_type = get_option( 'wp_urb_selected_post_type' );
    $selected_post_types_string = "'" . implode("', '", $selected_post_type) . "'";
    $table_name = $wpdb->prefix . 'postmeta';
    
    $posts_table = $wpdb->posts;
    $postmeta_table = $wpdb->postmeta;
    
    $results = $wpdb->query(
        "SELECT p.ID, p.post_title, p.post_author, pm.meta_value as reaction_counts
        FROM {$wpdb->prefix}posts p
        INNER JOIN {$wpdb->prefix}postmeta pm ON p.ID = pm.post_id
        WHERE p.post_type IN ({$selected_post_types_string})
        AND pm.meta_key = 'reaction_counts'"
    );

    return $results;
}

function wp_urb_get_data_for_list_table( $per_page, $offset ){
    global $wpdb;

    $selected_post_type = get_option( 'wp_urb_selected_post_type' );
    $selected_post_types_string = "'" . implode("', '", $selected_post_type) . "'";
    $table_name = $wpdb->prefix . 'postmeta';
    
    $posts_table = $wpdb->posts;
    $postmeta_table = $wpdb->postmeta;
    
    $results = $wpdb->get_results(
        "SELECT p.ID, p.post_title, p.post_author, pm.meta_value as reaction_counts
        FROM {$wpdb->prefix}posts p
        INNER JOIN {$wpdb->prefix}postmeta pm ON p.ID = pm.post_id
        WHERE p.post_type IN ({$selected_post_types_string})
        AND pm.meta_key = 'reaction_counts' LIMIT $per_page OFFSET $offset"
    );

    return $results;
}
