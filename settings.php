<?php
if (get_option('tm_coschedule_token')) {
    if (current_user_can('edit_posts')) {
?>
    <iframe id="CoSiFrame" frameborder=0 border=0 src="https://dgp49e2avkx9v.cloudfront.net/#/<?php echo get_option('tm_coschedule_token'); ?>/<?php echo get_current_user_id(); ?>/0/settings" width="100%"></iframe>

    <script>
        jQuery(document).ready(function($) {
            $('.update-nag').remove();
            $('#wpfooter').remove();
            $('#wpwrap #footer').remove();
            $('#wpbody-content').css('paddingBottom', 0);
            var resize = function() {
                var p = $(window).height() - $('#wpadminbar').height() - 3; // 3 extra pixels
                $('#CoSiFrame').height(p);
            }

            resize();
            $(window).resize(function() {
                resize();
            });
        });
    </script>
<?php
    } else {
        include('_access-denied.php');
    }
} else {
    include('_missing-token.php');
}
?>