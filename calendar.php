<iframe id="CoSiFrame" frameborder=0 border=0 src="http://app.coschedule.com" width="100%"></iframe>
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