<script type='text/javascript'>
    var tm_cos_token = "<?php echo get_option('tm_coschedule_token'); ?>";
</script>
<!--[if lt IE 9]>
  <style>
    .cos-settings-wrap .ie-only {
        display:block !important;
    }
    .cos-settings-wrap .not-ie {
        display: none !important;
    }
  </style>
<![endif]-->

<div class="coschedule">
    <div class="cos-settings-wrap">

        <div class="cos-header">
            <a href="http://coschedule.com" target="_blank" class="cos-logo-full pull-left" style="margin-bottom:20px;"></a>
            <ul class="nav navbar-tabs pull-right">
                <li>
                    <a href="http://app.coschedule.com" target="_blank" title="My Account" class="text-center">
                        <span aria-hidden="true" class="icon-user"></span>
                    </a>
                </li>
            </ul>
            <div class="clear"></div>
        </div>

        <div class="cos-hero">
            <!-- Settings Form -->
            <form id="cs-setting-form" method="post" action="options.php">
                <table class="cos-form-table">
                    <tr valign="middle">
                        <td>
                            <div id="tm_deactivate" style="display:none;">
                                <img src="<?=$this->assets.'/img/vector-editorial-calendar-ready.png';?>" class="calendar-image" alt="Your CoSchedule Calendar Is Ready"/>
                                <h3>Your calendar is ready!</h3>
                                <a href="admin.php?page=tm_coschedule_calendar" class="btn btn-orange btn-large">View Your Calendar</a><br/>
                                <button class="btn-disconnect" type="button" id="tm_deactivate_button">Disconnect</button>
                            </div>
                            <div id="tm_activate" style="display:none;">
                                <label for="tm_coschedule_token"><h3>Connect to CoSchedule</h3></label>
                                <div id="tm_coschedule_alert" class="alert" style="display:none;"></div>
                                <form name="connect-blog">
                                    <label class="form-label ie-only text-left">Email Address</label>
                                    <input class="input-jumbo input-block-level" type="text" name="tm_coschedule_email" id="tm_coschedule_email" placeholder="email"><br>
                                    <label class="form-label ie-only text-left">Password</label>
                                    <input class="input-jumbo input-block-level" type="password" name="tm_coschedule_password" id="tm_coschedule_password" placeholder="password"><br>
                                    <button type="submit" class="btn btn-blue btn-jumbo btn-block btn-caps" id="tm_activate_button">Connect</button>
                                    <p>Activate your plugin by connecting to CoSchedule. If you don’t have an account, you can <a href="http://app.coschedule.com/#/register" target="_blank">register here</a>.</p>
                                    <input type="hidden" id="" value="">
                                </form>
                            </div>
                        </td>
                    </tr>
                </table>
            </form>

            <div class="cos-hero-bottom">
                <div class="pull-left">
                    Version 1.9.2
                </div>
                <div class="pull-right">
                    <a href="#" id="tm_debug_toggle">Debug Information</a>
                </div>
            </div>

            <div class="cos-hero-debug-info" id="tm_debug_info" style="display:none;">
                <p>Having problems with the plugin? Check out our <a href="http://coschedule.com/help" target="_blank">FAQ</a> documentation. You can also <a href="mailto:support@coschedule.com">drop us a line</a> including the following details and we'll do what we can.</p>
                <textarea>URL: <?php echo get_option('siteurl'); ?> &#10;Timezone: <?php echo get_option('timezone_string').' -- GMT Offset: '.get_option('gmt_offset'); ?> &#10;CoS Version: 1.9.2 &#10;CoS Build: 15 &#10;CoS Token: <?php echo get_option('tm_coschedule_token'); ?> &#10;CoS ID: <?php echo get_option('tm_coschedule_id'); ?>&#10;CoS App: https://app.coschedule.com &#10;CoS Assets: https://d27i93e1y9m4f5.cloudfront.net &#10;CoS API: https://api.coschedule.com &#10;WP Version: <?php echo get_bloginfo('version'); ?> &#10;PHP Version: <?php echo phpversion(); ?> &#10;User String: <?php echo $_SERVER['HTTP_USER_AGENT']; ?> &#10;Active Theme: <?php $my_theme = wp_get_theme(); echo $my_theme->Name . " is version " . $my_theme->Version; ?> &#10;Plugins: &#10;<?php
                foreach (get_plugins() as $key => $plugin) {
                    $isactive = "";
                    if (is_plugin_active($key)) {
                        $isactive = "(active)";
                    }
                    echo $plugin['Name'].' '.$plugin['Version'].' '.$isactive."\n";
                }
                ?></textarea>
            </div>
        </div>

        <div class="cos-content">
            <h3 class="orange">What is CoSchedule?</h3>
            <p class="lead">
                CoSchedule is an editorial and social media calendar for publishers. It integrates directly with your WordPress blogs and social media profiles to simplify your content marketing workflow and make content scheduling easier on you and your team.
            </p>
            <p class="lead">
                It is made by Todaymade.
            </p>
            <div class="text-center">
                <a href="http://todaymade.com" target="_blank" class="todaymade-logo"></a>
            </div>
        </div>

        <hr style="margin-top:40px;"/>

        <div style="float: right; margin-top:20px;">
            <iframe allowtransparency="true" frameborder="0" scrolling="no" src="//platform.twitter.com/widgets/follow_button.1368146021.html#_=1369774539012&amp;id=twitter-widget-1&amp;lang=en&amp;screen_name=todaymade&amp;show_count=false&amp;show_screen_name=true&amp;size=l" class="twitter-follow-button twitter-follow-button" title="Twitter Follow Button" data-twttr-rendered="true" style="width: 163px; height: 28px;"></iframe>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

            <iframe allowtransparency="true" frameborder="0" scrolling="no" src="//platform.twitter.com/widgets/follow_button.1368146021.html#_=1369774539012&amp;id=twitter-widget-1&amp;lang=en&amp;screen_name=coschedule&amp;show_count=false&amp;show_screen_name=true&amp;size=l" class="twitter-follow-button twitter-follow-button" title="Twitter Follow Button" data-twttr-rendered="true" style="width: 163px; height: 28px;"></iframe>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

            <iframe allowtransparency="true" frameborder="0" scrolling="no" src="//platform.twitter.com/widgets/tweet_button.1368146021.html#_=1369774539009&amp;count=horizontal&amp;id=twitter-widget-0&amp;lang=en&amp;original_referer=http%3A%2F%2Fcoschedule.com%2Faccount&amp;related=coschedule&amp;size=l&amp;text=Check%20this%20awesome%20new%20%23wordpress%20tool%20-%20Organize%20%26%20Automate%20Your%20WordPress%20Content&amp;url=http%3A%2F%2Fwww.coschedule.com%2F&amp;via=coschedule" class="twitter-share-button twitter-count-horizontal" title="Twitter Tweet Button" data-twttr-rendered="true" style="width: 138px; height: 28px;"></iframe>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
        </div>

        <div style="clear:both;"></div>

        <hr style="margin-top:20px;"/>

        <a href="http://coschedule.com/help" target="_blank">Help</a>
        &nbsp;&bull;&nbsp; <a href="mailto:support@coschedule.com">Support/Feedback</a>
        <div style="float: right;">
            CoSchedule by <a href="http://todaymade.com" target="_blank">Todaymade</a>
        </div>

    </div>
</div>
