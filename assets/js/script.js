jQuery(document).ready(function($) {
    $('.wp-urb-reaction').click(function() {
        var reaction = $(this).data('reaction');
        var post_id = $(this).closest('.wp-urb-reactions').data('post-id');
        var userid = $(this).closest('.wp-urb-reactions').data('userid');

        $.ajax({
            url: wp_urb_reactions.ajax_url,
            type: 'POST',
            data: {
                action: 'wp_urb_save_reaction',
                post_id: post_id,
                reaction: reaction,
                userid:userid,
                nonce:wp_urb_reactions.nonce,
            },
            success: function(response) {
                $this.find('.count').text(response);

                // Remove the user's old reaction
                $this.siblings().removeClass('active');
                $this.siblings('[data-reaction="' + reaction + '"]').addClass('active');
            }
        });
    });
});


