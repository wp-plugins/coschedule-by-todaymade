<?php
if (get_option('tm_coschedule_token')) {
    if (current_user_can('edit_posts') && isset($_GET['tm_cos_user_token']) && !empty($_GET['tm_cos_user_token'])) {
?>
        <iframe id="CoSiFrame" frameborder=0 border=0 src="https://dgp49e2avkx9v.cloudfront.net/#/<?php echo get_option('tm_coschedule_token'); ?>/<?php echo get_current_user_id(); ?>/<?php echo $_GET['tm_cos_user_token']; ?>/schedule" width="100%"></iframe>
    <?php } else if (current_user_can('edit_posts')) { ?>
        <iframe id="CoSiFrame" frameborder=0 border=0 src="https://dgp49e2avkx9v.cloudfront.net/#/<?php echo get_option('tm_coschedule_token'); ?>/<?php echo get_current_user_id(); ?>/0/schedule" width="100%"></iframe>
<?php
    } else {
        include('_access-denied.php');
    }
} else {
    include('_missing-token.php');
}
?>
<script>
    jQuery(document).ready(function($) {
        $('.update-nag').remove();
        $('#wpfooter').remove();
        $('#wpwrap #footer').remove();
        $('#wpbody-content').css('paddingBottom', 0);
        $('#CoSiFrame').css('min-height',$('#wpbody').height());
        var resize = function() {
            var p =  $(window).height() - $('#wpadminbar').height() - 4;
            $('#CoSiFrame').height(p);
        }

        resize();
        $(window).resize(function() {
            resize();
        });
    });
</script>