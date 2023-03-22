jQuery(document).ready(function($) {
    $('.wp-urb-reaction').click(function() {
        var reaction = $(this).data('reaction');
        var post_id = $(this).closest('.wp-urb-reactions').data('post-id');
        
        $.ajax({
            type: 'POST',
            url: wp_urb_reactions.ajax_url,
            data: {
                action: 'wp_urb_save_reaction',
                post_id: post_id,
                reaction: reaction
            },
            success: function(response) {
                console.log(post_id);
            }
        });
    });
});
