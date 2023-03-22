<div class="wrap">
    <h1 class="wp-heading-inline"><?php _e('Configure Button', 'wur' ); ?></h1>
    <?php
    if ( isset( $_POST['wp_urb_nonce'] ) && wp_verify_nonce( $_POST['wp_urb_nonce'], 'wp_urb_save_post_type' ) ) {
        // Save selected post type
        $selected_post_type = isset( $_POST['wp_urb_selected_post_type'] ) ?  $_POST['wp_urb_selected_post_type']  : '';
        $selected_post_type = array_map( 'sanitize_text_field', $selected_post_type );

        update_option( 'wp_urb_selected_post_type', $selected_post_type );

        // Save selected position
        $selected_position = isset( $_POST['wp_urb_selected_position'] ) ? sanitize_text_field( $_POST['wp_urb_selected_position'] ) : '';
        update_option( 'wp_urb_selected_position', $selected_position );
    }
    ?>

    <form method="post">
        <?php wp_nonce_field( 'wp_urb_save_post_type', 'wp_urb_nonce' ); ?>

        <p>
            <label>
                <strong><?php _e( 'Select a post type:', 'wur' ); ?></strong>
            </label>
        </p>
        <?php
        // Query the posts those are available in public
        $args = array(
            'public' => true,
            'show_ui' => true
        );

        $post_types = get_post_types( $args, 'objects' );
        $selected_post_type = get_option( 'wp_urb_selected_post_type' );

        foreach ( $post_types as $post_type ) {
            echo '<p style="max-width:400px;margin-right:15px;display:inline-block;">';
            echo '<label><input type="checkbox" name="wp_urb_selected_post_type[]" value="' . esc_attr( $post_type->name ) . '"';
            if ( is_array( $selected_post_type ) && in_array( $post_type->name, $selected_post_type ) ) {
                echo ' checked="checked"';
            }
            echo '> ' . esc_html( $post_type->labels->singular_name ) . '</label>';
            echo '</p>';
        }
        ?>

       <p>
        <label>
            <strong>
                <?php _e( 'Select a position:', 'wur' ); ?>
            </strong>
        </label>
       </p>
        <?php
        $selected_position = get_option( 'wp_urb_selected_position' );
        ?>
        <p>
            <label>
                <input type="radio" name="wp_urb_selected_position" value="bottom" <?php checked( $selected_position, 'bottom' ); ?>> <?php _e( 'Bottom', 'wur' ); ?>
            </label>
        </p>
     <p>
        <label>
            <input type="radio" name="wp_urb_selected_position" value="top" <?php checked( $selected_position, 'top' ); ?>> <?php _e( 'Top', 'wur' ); ?>
        </label>
     </p>

        <?php submit_button( __( 'Save', 'wur' ), 'primary', 'wp_urb_submit' ); ?>

    </form>


</div>