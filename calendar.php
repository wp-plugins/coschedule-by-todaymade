<?php
if ( get_option( 'tm_coschedule_token' ) ) {
    if ( current_user_can( 'edit_posts' ) && isset( $_GET['tm_cos_user_token'] ) && ! empty( $_GET['tm_cos_user_token'] ) ) {
?>
        <iframe id="CoSiFrame" frameborder="0" border="0" src="https://dgp49e2avkx9v.cloudfront.net/#/auth2/<?php echo esc_attr( get_option( 'tm_coschedule_id' ) ); ?>/<?php echo esc_attr( $_GET['tm_cos_user_token'] ); ?>/schedule" width="100%"></iframe>
    <?php } else if ( current_user_can( 'edit_posts' ) ) { ?>
        <iframe id="CoSiFrame" frameborder="0" border="0" src="https://dgp49e2avkx9v.cloudfront.net/#/auth2/<?php echo esc_attr( get_option( 'tm_coschedule_id' ) ); ?>/0/schedule" width="100%"></iframe>
<?php
    } else {
        include( '_access-denied.php' );
    }
} else {
    include( '_missing-token.php' );
}
?>
<script>
    jQuery(document).ready(function($) {
        $('.update-nag').remove();
        $('#wpfooter').remove();
        $('#wpwrap #footer').remove();
        $('#wpbody-content').css('paddingBottom', 0);


        var resize = function() {
            var p = $(window).height() - $('#wpadminbar').height();
            $('#CoSiFrame').height(p);
            $('#CoSiFrame').css('display', 'block');
            $('#CoSiFrame').css('lineHeight', 0);
        }

        resize();
        $(window).resize(function() {
            resize();
        });
    });
</script>