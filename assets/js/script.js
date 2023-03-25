jQuery(document).ready(function($) {
    $('.wp-urb-reaction').click(function() {
        var $this = $(this);
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
                $('.wp-urb-reaction .reaction-count').text(response);
                $('.wp-urb-reaction .current-reaction').text(reaction);

                setTimeout(() => {
                    $('.wp-urb-reaction .reaction-text').text(reaction);
                }, 3000);
                

                // Remove the user's old reaction
                // $this.siblings().removeClass('active');
                // $this.siblings('[data-reaction="' + reaction + '"]').addClass('active');
            }
        });
    });
});


