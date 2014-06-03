<?php if (current_user_can('manage_options')) { ?>
    <script type='text/javascript'>
        var tm_cos_token = "<?php echo get_option('tm_coschedule_token'); ?>";
    </script>
    <!--[if IE 9]>
      <style>
        .coschedule .ie-only {
            display:block !important;
        }
        .coschedule .not-ie {
            display: none !important;
        }
      </style>
    <![endif]-->

    <div class="coschedule aj-window-height">
        <div class="cos-welcome-wrapper calendar-bg container-fluid">
            <div class="row-fluid">
                <div class="span8 offset2">
                    <div class="cos-plugin-wrapper">
                        <div class="cos-plugin-inner">
                                <div class="cos-plugin-header text-center">
                                    <h3 class="aj-header-text white marg-none marg-b">Your CoSchedule Editorial Calendar Is Waiting</h3>
                                    <div class="cos-plugin-sales-pitch">
                                        <ul class="text-left">
                                            <li>&bull; Drag-And-Drop Editorial Calendar</li>
                                            <li>&bull; Schedule Social Media While You Blog</li>
                                            <li>&bull; All-In-One Blog &amp; Social Media Publishing</li>
                                            <li>&bull; Communicate With Your Team</li>
                                            <li>&bull; 14 Day Free Trial, Cancel Anytime</li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="cos-plugin-body">
                                    <!-- Form chooser -->
                                    <div id="tm_form_mode">
                                        <a href="#" class="tm_form_mode_register btn btn-blue btn-jumbo btn-block brandon-regular">
                                            <span style="font-size: 20px; line-height: 24px;">Register, And Get Started Now</span></br>
                                            <span class="small blue1">No Credit Card Required, Cancel Anytime</span>
                                        </a>
                                        <div id="tm_form_mode_login" class="text-center grey brandon-regular marg-t pad-t" style="margin-bottom: -20px;">
                                            Already have a CoSchedule account? <a href="#" class="tm_form_mode_login">Login now</a>.
                                        </div>
                                    </div>

                                    <!-- Login Progress -->
                                    <div id="tm_coschedule_alert" class="alert" style="display:none; margin: 0px 0px 10px 0px"></div>

                                    <!-- Calendar Setup Area -->
                                    <div id="tm_form_calendar_setup" style="display: none;">
                                        <div class="cos-installer-loading">
                                            Loading your calendar....
                                        </div>
                                    </div>

                                    <!-- Connection Progress -->
                                    <div id="tm_connection_progress" style="display: none;">
                                        <div class="cos-installer-loading">
                                            <span id="tm_connection_msg"></span>
                                        </div>
                                    </div>

                                    <div id="tm_connection_body" style="display: none;">
                                        <div id="tm_connection_msg" class="alert" style="display: none; margin: 0px 0px 10px 0px"></div>
                                    </div>

                                    <!-- Login form -->
                                    <div id="tm_form_login" style="display: none;">
                                        <label class="form-label ie-only text-left">Email Address</label>
                                        <input class="input-jumbo input-block-level" type="text" name="tm_coschedule_email" id="tm_coschedule_email" placeholder="Email Address"><br>
                                        <label class="form-label ie-only text-left">Password</label>
                                        <input class="input-jumbo input-block-level" type="password" name="tm_coschedule_password" id="tm_coschedule_password" placeholder="Password"><br>
                                        <button type="submit" class="btn btn-blue btn-jumbo btn-block" id="tm_activate_button">Sign In</button>
                                        <div class="text-center grey brandon-regular marg-t pad-t" style="margin-bottom: -20px;">
                                            Don't have a CoSchedule account yet? <a href="#" class="tm_form_mode_register">Register now</a>.
                                        </div>
                                    </div>
                                    <!-- Registration form -->
                                    <div id="tm_form_register" style="display: none;">
                                        <label class="form-label ie-only text-left">Full Name</label>
                                        <div class="form-group">
                                            <input class="input-jumbo input-block-level" type="text" name="tm_coschedule_name" id="tm_coschedule_name_register" placeholder="Full Name">
                                            <div class="flag">
                                                You'll be up and running <br/>in <strong>30 seconds</strong>!
                                            </div>
                                        </div>
                                        <label class="form-label ie-only text-left">Email Address</label>
                                        <div class="form-group">
                                            <input class="input-jumbo input-block-level" type="text" name="tm_coschedule_email" id="tm_coschedule_email_register" placeholder="Email Address">
                                            <div class="flag">
                                                Now you got it <br/> keep going!
                                            </div>
                                        </div>
                                        <label class="form-label ie-only text-left">Password</label>
                                        <div class="form-group">
                                            <input class="input-jumbo input-block-level" type="password" name="tm_coschedule_password" id="tm_coschedule_password_register" placeholder="Password"><br>
                                            <div class="flag">
                                                Almost ready <br/> don't stop now!
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-blue btn-jumbo btn-block" id="tm_activate_button_register">Start your 14 day free trial <span aria-hidden="true" class="icon-arrow"></span></button>
                                        <div class="text-center grey brandon-regular marg-t pad-t" style="margin-bottom: -20px;">
                                            Already have a CoSchedule account? <a href="#" class="tm_form_mode_login">Sign in now</a>.
                                        </div>
                                    </div>
                                    <input type="hidden" id="" value="">
                                </div>
                                <div class="tm_footer_logos cos-plugin-footer text-center">
                                    <div class="customer-logos">
                                        <img src="http://direct.coschedule.com/img/app-tmp/customer-logos-color.png">
                                        CoSchedule is trusted by WordPress bloggers and content marketers around the world.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

            <div class="hidden">
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
                                        <img src="<?php echo $this->assets.'/plugin/img/vector-editorial-calendar-ready.png';?>" class="calendar-image" alt="Your CoSchedule Calendar Is Ready"/>
                                        <h3>Your calendar is ready!</h3>
                                        <a href="admin.php?page=tm_coschedule_calendar" class="btn btn-orange btn-large">View Your Calendar</a><br/>
                                        <button class="btn-disconnect" type="button" id="tm_deactivate_button">Disconnect</button>
                                    </div>
                                    <div id="tm_activate" style="display:none;">
                                        <label for="tm_coschedule_token"><h3>Connect to CoSchedule</h3></label>
                                        <div id="tm_coschedule_alert" class="alert" style="display:none;"></div>

                                        <form name="connect-blog" id="tm_form_login" style="display: none;">
                                            <!-- Select Mode -->
                                            <div id="tm_form_mode" style="display: none;">
                                                <button class="btn btn-jumbo btn-block btn-caps" id="tm_form_mode_login">Login</button><br>
                                                <button class="btn btn-jumbo btn-block btn-caps" id="tm_form_mode_register">Register</button>
                                            </div>

                                            <!-- Login form -->
                                            <div id="tm_form_login" style="display: none;">
                                                <label class="form-label ie-only text-left">Email Address</label>
                                                <input class="input-jumbo input-block-level" type="text" name="tm_coschedule_email" id="tm_coschedule_email" placeholder="email"><br>
                                                <label class="form-label ie-only text-left">Password</label>
                                                <input class="input-jumbo input-block-level" type="password" name="tm_coschedule_password" id="tm_coschedule_password" placeholder="password"><br>
                                                <button type="submit" class="btn btn-blue btn-jumbo btn-block btn-caps" id="tm_activate_button">Login</button>
                                                <p>Activate your plugin by connecting to CoSchedule. If you don’t have an account, you can <a href="#" class="tm_form_toggle">register here</a>.</p>
                                            </div>

                                            <!-- Registration form -->
                                            <div id="tm_form_register" style="display: none;">
                                                <label class="form-label ie-only text-left">Full Name</label>
                                                <input class="input-jumbo input-block-level" type="text" name="tm_coschedule_name" id="tm_coschedule_name_register" placeholder="name"><br>
                                                <label class="form-label ie-only text-left">Email Address</label>
                                                <input class="input-jumbo input-block-level" type="text" name="tm_coschedule_email" id="tm_coschedule_email_register" placeholder="email"><br>
                                                <label class="form-label ie-only text-left">Password</label>
                                                <input class="input-jumbo input-block-level" type="password" name="tm_coschedule_password" id="tm_coschedule_password_register" placeholder="password"><br>
                                                <button type="submit" class="btn btn-blue btn-jumbo btn-block btn-caps" id="tm_activate_button_register">Register</button>
                                                <p>Activate your plugin by connecting to CoSchedule. If you already have an account, you can <a href="#" class="tm_form_toggle">login here</a>.</p>
                                            </div>
                                            <input type="hidden" id="" value="">
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </form>

                    <div class="cos-hero-bottom">
                        <div class="pull-left">
                            Version 2.0.0
                        </div>
                        <div class="pull-right">
                            <a href="#" id="tm_debug_toggle">Debug Information</a>
                        </div>
                    </div>

                    <div class="cos-hero-debug-info" id="tm_debug_info" style="display:none;">
                        <p>Having problems with the plugin? Check out our <a href="http://coschedule.com/help" target="_blank">FAQ</a> documentation. You can also <a href="mailto:support@coschedule.com">drop us a line</a> including the following details and we'll do what we can.</p>
                        <textarea>URL: <?php echo get_option('siteurl'); ?> &#10;Timezone: <?php echo get_option('timezone_string').' -- GMT Offset: '.get_option('gmt_offset'); ?> &#10;CoS Version: 2.0.0 &#10;CoS Build: 30 &#10;CoS Token: <?php echo get_option('tm_coschedule_token'); ?> &#10;CoS ID: <?php echo get_option('tm_coschedule_id'); ?>&#10;CoS App: https://app.coschedule.com &#10;CoS Assets: https://d2lbmhk9kvi6z5.cloudfront.net &#10;CoS API: https://api.coschedule.com &#10;WP Version: <?php echo get_bloginfo('version'); ?> &#10;PHP Version: <?php echo phpversion(); ?> &#10;User String: <?php echo $_SERVER['HTTP_USER_AGENT']; ?> &#10;Active Theme: <?php $my_theme = wp_get_theme(); echo $my_theme->Name . " is version " . $my_theme->Version; ?> &#10;Plugins: &#10;<?php
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

    <script>
        jQuery(document).ready(function($) {
            $('.update-nag').remove();
            $('#wpfooter').remove();
            $('#wpwrap #footer').remove();
            $('#wpbody-content').css('paddingBottom', 0);
            var resize = function() {
                var p = $(window).height() - $('#wpadminbar').height() - 3; // 3 extra pixels
                $('.aj-window-height').height(p);
            }

            resize();
            $(window).resize(function() {
                resize();
            });
        });
    </script>
<?php
} else {
    include(plugin_dir_path(__FILE__) . '_access-denied.php');
}
?>