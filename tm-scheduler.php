<?php
/*
Plugin Name: CoSchedule by Todaymade
Description: Schedule social media messages alongside your blog posts in WordPress, and then view them on a Google Calendar interface. <a href="http://app.coschedule.com" target="_blank">Account Settings</a>
Version: 1.9.14
Author: Todaymade
Author URI: http://todaymade.com/
Plugin URI: http://coschedule.com/
*/

// Check for existing class
if (!class_exists('tm_coschedule')) {

	// Include Http Class
	if(!class_exists('WP_Http')) {
		include_once(ABSPATH . WPINC. '/class-http.php');
	}

	/**
	 * Main Class
	 */
	class tm_coschedule  {
		private $api = "https://api.coschedule.com";
		private $assets = "https://d27i93e1y9m4f5.cloudfront.net";
		private $version = "1.9.14";
		private $build = 27;
		private $connected = false;
		private $token = false;

		/**
		 * Class constructor: initializes class variables and adds actions and filters.
		 */
		public function __construct() {
			$this->tm_coschedule();
		}

		public function tm_coschedule() {
			register_activation_hook(__FILE__, array($this, 'activation'));
			register_deactivation_hook(__FILE__, array($this, 'deactivation'));

			// Load token
			$this->token = get_option('tm_coschedule_token');

			// Check if connected to api
			if (isset($this->token) && !empty($this->token)) {
				$this->connected = true;
			}

			// Register global hooks
			$this->register_global_hooks();

			// Register admin only hooks
			if(is_admin()) {
				$this->register_admin_hooks();
			}
		}

		/**
		 * Print the contents of an array
		 */
		public function debug($array) {
			echo '<pre>';
			print_r($array);
			echo '</pre>';
		}

		/**
		 * Handles activation tasks, such as registering the uninstall hook.
		 */
		public function activation() {
			register_uninstall_hook(__FILE__, array('tm_coschedule', 'uninstall'));

            // Set redirection to true
            add_option('tm_coschedule_activation_redirect', true);
		}

        /**
         * Checks to see if the plugin was just activated to redirect them to settings
         */
        public function activation_redirect() {
            if (get_option('tm_coschedule_activation_redirect', false)) {
                // Redirect to settings page
                if (delete_option('tm_coschedule_activation_redirect')) {
                    wp_redirect('options-general.php?page=tm_coschedule');
                }
            }
        }

		/**
		 * Handles deactivation tasks, such as deleting plugin options.
		 */
		public function deactivation() {
			delete_option('tm_coschedule_token');
			delete_option('tm_coschedule_id');
            delete_option('tm_coschedule_activation_redirect');
            delete_option('tm_coschedule_custom_post_types_list');
		}

		/**
		 * Handles uninstallation tasks, such as deleting plugin options.
		 */
		public function uninstall() {
			delete_option('tm_coschedule_token');
			delete_option('tm_coschedule_id');
            delete_option('tm_coschedule_activation_redirect');
            delete_option('tm_coschedule_custom_post_types_list');
		}

		/**
		 * Registers global hooks, these are added to both the admin and front-end.
		 */
		public function register_global_hooks() {
			// Called whenever a post is created/updated/deleted
			add_action( 'save_post', array($this, "save_post_callback"));
			add_action( 'delete_post', array($this, "delete_post_callback"));

			// Called whenever a post is created/updated/deleted
			add_action( 'create_category', array($this, "save_category_callback"));
			add_action( 'edit_category', array($this, "save_category_callback"));
			add_action( 'delete_category', array($this, "delete_category_callback"));

			// Called whenever a user/author is created/updated/deleted
			add_action( 'user_register', array($this, "save_user_callback"));
			add_action( 'profile_update', array($this, "save_user_callback"));
			add_action( 'delete_user', array($this, "delete_user_callback"));

			// Edit Flow Fix
			add_filter('wp_insert_post_data', array($this, 'fix_custom_status_timestamp_before'), 1);
			add_filter('wp_insert_post_data', array($this, 'fix_custom_status_timestamp_after'), 20);
		}

		/**
		 * Registers admin only hooks.
		 */
		public function register_admin_hooks() {
			// Add meta box setup actions to post edit screen
			add_action('load-post.php', array($this, "meta_box_action"));
			add_action('load-post-new.php', array($this, "meta_box_action"));

			// Add meta box css and script to post edit screen
			add_action('load-post.php', array($this, "meta_box_scripts"));
			add_action('load-post-new.php', array($this, "meta_box_scripts"));

			// Ajax: Get blog info
			add_action('wp_ajax_tm_aj_get_bloginfo', array($this, 'tm_aj_get_bloginfo'));
			add_action('wp_ajax_nopriv_tm_aj_get_bloginfo', array($this, 'tm_aj_get_bloginfo'));

			// Ajax: Get full post with permalink
			add_action('wp_ajax_tm_aj_get_full_post', array($this, 'tm_aj_get_full_post'));
			add_action('wp_ajax_nopriv_tm_aj_get_full_post', array($this, 'tm_aj_get_full_post'));

			// Ajax: Set token
			add_action('wp_ajax_tm_aj_set_token', array($this, 'tm_aj_set_token'));

            // Ajax: Check token
            add_action('wp_ajax_tm_aj_check_token', array($this, 'tm_aj_check_token'));
            add_action('wp_ajax_nopriv_tm_aj_check_token', array($this, 'tm_aj_check_token'));

            // Ajax: Set custom post types
            add_action('wp_ajax_tm_aj_set_custom_post_types', array($this, 'tm_aj_set_custom_post_types'));
            add_action('wp_ajax_nopriv_tm_aj_set_custom_post_types', array($this, 'tm_aj_set_custom_post_types'));

			// Ajax: Get function
			add_action('wp_ajax_tm_aj_function', array($this, 'tm_aj_function'));
			add_action('wp_ajax_nopriv_tm_aj_function', array($this, 'tm_aj_function'));

			// Ajax: Deactivation
			add_action('wp_ajax_tm_aj_deactivation', array($this, 'tm_aj_deactivation'));
			add_action('wp_ajax_nopriv_tm_aj_deactivation', array($this, 'tm_aj_deactivation'));

			// Add Sidebar Settings Link
			add_action('admin_menu', array($this, 'add_menu'));

			// Add settings link to plugins listing page
			add_filter('plugin_action_links', array($this, 'plugin_settings_link'), 2, 2);

            // Add check for activation redirection
            add_action('admin_init', array($this, 'activation_redirect'));
		}

		/**
		* Add calendar and settings link to the admin menu
		*/
		public function add_menu() {
			// Settings Page
			$settings_1 = add_options_page('CoSchedule Settings', 'CoSchedule', 'manage_options', 'tm_coschedule', array($this, 'plugin_settings_page'));
			// Enqueue scripts for settings
			add_action('admin_print_styles-' . $settings_1, array($this, 'plugin_settings_scripts'));

			// Switch main nav link between settings and the calendar depending on if they are connected
			if ($this->connected) {
				add_menu_page('CoSchedule Calendar', 'Calendar', 'edit_posts', 'tm_coschedule_calendar', array($this, 'plugin_calendar_page'), $this->assets.'/plugin/icon.png', '50.505' );
			} else {
				$settings_2 = add_menu_page('CoSchedule Calendar', 'Calendar', 'edit_posts', 'tm_coschedule_calendar', array($this, 'plugin_settings_page'), $this->assets.'/plugin/icon.png', '50.505' );
				// Enqueue scripts for settings
				add_action('admin_print_styles-' . $settings_2, array($this, 'plugin_settings_scripts'));
			}
		}

		/**
		 * Admin: Add settings link to plugin management page
		 */
		public function plugin_settings_link($actions, $file) {
			if(false !== strpos($file, 'tm-scheduler')) {
				$actions['settings'] = '<a href="options-general.php?page=tm_coschedule">Settings</a>';
			}
			return $actions;
		}

		/**
		* Setttings page menu callback
		*/
		public function plugin_settings_page() {
			if(!current_user_can('manage_options')) {
				wp_die(__('You do not have sufficient permissions to access this page.'));
			}
			include(sprintf("%s/settings.php", dirname(__FILE__)));
		}

		/**
		* Settings page scripts
		*/
		public function plugin_settings_scripts() {
			$cache_bust = $this->get_cache_bust();

			wp_enqueue_style('cos_css', $this->assets.'/css/wordpress_plugin.min.css?cb='.$cache_bust);
			wp_enqueue_script('cos_js_config', $this->assets.'/js/config.js?cb='.$cache_bust, false, null, true);
			wp_enqueue_script('cos_js_plugin', $this->assets.'/js/settings.js?cb='.$cache_bust, false, null, true);
		}

		/**
		* Calendar page menu callback
		*/
		public function plugin_calendar_page() {
			if(!current_user_can('edit_posts')) {
				wp_die(__('You do not have sufficient permissions to access this page.'));
			}
			include(sprintf("%s/calendar.php", dirname(__FILE__)));
		}

		/**
		 * Registers the javascript variables for the page
		 */
		public function plugin_js_variables() {
			return array(
				'build' => $this->build,
				'version' => $this->version,
				'post_id' => get_the_ID(),
				'token' => get_option('tm_coschedule_token'),
				'post' => $this->get_full_post(get_the_ID())
			);
		}

        /**
         * Checks if the meta box should be included on the page based on post type
         */
        public function meta_box_enabled() {
            $post_type = $this->get_current_post_type();
            $custom_post_types_list = get_option('tm_coschedule_custom_post_types_list');

            // Grab remote list if not set
            if (!$custom_post_types_list) {
                if ($this->connected) {
                    // Load remote blog information
                    $resp = $this->api_get('/wordpress_keys?_wordpress_key='. $this->token);
                    if (isset($resp['response']['code']) && $resp['response']['code'] === 200) {
                        $json = json_decode($resp['body'], true);

                        // Check for a good response
                        if (isset($json['result'][0]) && $json['result'][0]['custom_post_types']) {
                            $custom_post_types_list = $json['result'][0]['custom_post_types_list'];

                            // Save custom list
                            if (!empty($custom_post_types_list)) {
                                update_option('tm_coschedule_custom_post_types_list', $custom_post_types_list);
                            }
                        }
                    }
                }
            }

            // Default
            if (empty($custom_post_types_list)) {
                $custom_post_types_list = 'post';
                update_option('tm_coschedule_custom_post_types_list', $custom_post_types_list);
            }

            // Convert to an array
            $custom_post_types_list_array = explode(',', $custom_post_types_list);

            // Check if post type is supported
            return in_array($post_type, $custom_post_types_list_array);
        }

		/**
		 * Adds action to insert a meta box
		 */
		public function meta_box_action() {
			add_action('add_meta_boxes', array($this, "meta_box_setup"));
		}

		/**
		 * Enqueue the css and js for the metabox
		 */
		public function meta_box_scripts() {
            $enabled = $this->meta_box_enabled();
            if ($enabled) {
                $cache_bust = $this->get_cache_bust();
				wp_enqueue_style('cos_css', $this->assets.'/css/wordpress_plugin.css?cb='.$cache_bust);
				wp_enqueue_script('cos_js_config', $this->assets.'/js/config.js?cb='.$cache_bust, false, null, true);
				wp_enqueue_script('cos_js_plugin', $this->assets.'/js/plugin.js?cb='.$cache_bust, false, null, true);
                wp_enqueue_script('cos_js_transloadit', 'http://assets.transloadit.com/js/jquery.transloadit2-latest.js', false, null, true);
			}
		}

		/**
		 * Sets up the meta box to be inserted
		 */
		public function meta_box_setup() {
            $enabled = $this->meta_box_enabled();
            if ($enabled) {
                $post_type = $this->get_current_post_type();
    			add_meta_box(
    				'tm-scheduler',						    // Unique ID
    				'CoSchedule',							// Title
    				array(&$this, 'meta_box_insert'),		// Callback function
    				$post_type,								// Admin page (or post type)
    				'normal',								// Context
    				'default'								// Priority
    			);
            }
		}

		/**
		 * Inserts the meta box
		 */
		public function meta_box_insert() {
			echo '
			<div id="tm-coschedule-outlet"></div>
			<script>
				var tm_coschedule_variables = '. json_encode($this->plugin_js_variables()) .';
			</script>
			';
		}

		/**
		 * Ajax: Secure using token
		 */
		public function valid_token($token) {
			$validate = "";
			if (isset($token) && !empty($token)) {
				if ($this->connected) {
					if ($this->token === $token) {
						$validate = true;
					} else {
						$validate = "Invalid token";
					}
				} else {
					$validate = "Not connected to api";
				}
			} else {
				$validate = "Token required";
			}

			if ($validate === true) {
				return true;
			} else {
                header('Content-Type: application/json');
				echo json_encode(array("error"=>$validate));
				die();
			}
		}

		/**
		 * Ajax: Return blog info
		 */
		public function tm_aj_get_bloginfo() {
            try {
                header('Content-Type: application/json');
                $vars = array(
                    "name"=>get_bloginfo("name"),
                    "description"=>get_bloginfo("description"),
                    "wpurl"=>get_bloginfo("wpurl"),
                    "url"=>get_bloginfo("url"),
                    "version"=>get_bloginfo("version"),
                    "language"=>get_bloginfo("language"),
                    "pingback_url"=>get_bloginfo("pingback_url"),
                    "rss2_url"=>get_bloginfo("rss2_url"),
                    "timezone_string"=>get_option("timezone_string"),
                    "gmt_offset"=>get_option("gmt_offset"),
                    "plugin_version"=>$this->version,
                    "plugin_build"=>$this->build
                );

                if (isset($_GET['tm_debug'])) {
                    $vars["debug"] = array();
                    $vars["debug"]["server_time"] = time();
                    $vars["debug"]["server_date"] = date('c');
                    $vars["debug"]["site_url"] = get_option('siteurl');
                    $vars["debug"]["php_version"] = phpversion();

                    $theme = wp_get_theme();
                    $vars["debug"]["theme"] = array();
                    $vars["debug"]["theme"]["Name"] = $theme->get('Name');
                    $vars["debug"]["theme"]["ThemeURI"] = $theme->get('ThemeURI');
                    $vars["debug"]["theme"]["Description"] = $theme->get('Description');
                    $vars["debug"]["theme"]["Author"] = $theme->get('Author');
                    $vars["debug"]["theme"]["AuthorURI"] = $theme->get('AuthorURI');
                    $vars["debug"]["theme"]["Version"] = $theme->get('Version');
                    $vars["debug"]["theme"]["Template"] = $theme->get('Template');
                    $vars["debug"]["theme"]["Status"] = $theme->get('Status');
                    $vars["debug"]["theme"]["Tags"] = $theme->get('Tags');
                    $vars["debug"]["theme"]["TextDomain"] = $theme->get('TextDomain');
                    $vars["debug"]["theme"]["DomainPath"] = $theme->get('DomainPath');

                    $vars["debug"]["plugins"] = $this->get_installed_plugins();
                }
    			echo json_encode($this->array_decode_entities($vars));
            } catch (Exception $e) {
                header('Content-Type: text/plain');
                echo 'Exception: ' . $e->getMessage();
            }
            die();
		}

		/**
		 * Ajax: Return full post with permalink
		 */
		public function tm_aj_get_full_post() {
            try {
                header('Content-Type: application/json');
    			echo json_encode($this->get_full_post($_GET['post_id']));
    			die();
            } catch (Exception $e) {
                header('Content-Type: text/plain');
                echo 'Exception: ' . $e->getMessage();
            }
            die();
		}

		/**
		 * Ajax: Set token
		 */
		public function tm_aj_set_token() {
            header('Content-Type: text/plain');

            try {
                if (isset($_POST['token'])) {
        			update_option('tm_coschedule_token', $_POST['token']);
        			update_option('tm_coschedule_id', $_POST['id']);
        			echo $_POST['token'];
                } else if (isset($_GET['token'])) {
                    update_option('tm_coschedule_token', $_GET['token']);
                    update_option('tm_coschedule_id', $_GET['id']);
                    echo $_GET['token'];
                }
            } catch (Exception $e) {
                echo 'Exception: ' . $e->getMessage();
            }
			die();
		}

        /**
         * Ajax: Check a token against the current token
         */
        public function tm_aj_check_token() {
            header('Content-Type: text/plain');

            try {
                // Check request token
                if (!isset($_GET['token']) || empty($_GET['token'])) {
                    echo 'Token not provided in request';
                    die();
                }

                // Check stored token
                if (!isset($this->token) || empty($this->token)) {
                    echo 'No token saved in WordPress';
                    die();
                }

                // Compare
                if ($_GET['token'] == $this->token) {
                    echo "Tokens match";
                } else {
                    echo "Tokens do not match";
                }
            } catch (Exception $e) {
                echo 'Exception: ' . $e->getMessage();
            }
            die();
        }

        /**
         * Ajax: Set custom post types
         */
        public function tm_aj_set_custom_post_types() {
            header('Content-Type: text/plain');

            try {
                echo $_GET['post_types_list'];
                update_option('tm_coschedule_custom_post_types_list', $_GET['post_types_list']);
            } catch (Exception $e) {
                echo 'Exception: ' . $e->getMessage();
            }
            die();
        }

		/**
		 * Ajax: Get function
		 */
		public function tm_aj_function() {
            header('Content-Type: text/plain');

            try {
                // Validate call
                $this->valid_token($_GET['token']);

                // Save args
                $args = $_GET;

                // Remove action name
                unset($args['action']);

                // Remove token
                unset($args['token']);

                // Save and remove function name
                $func = $args['call'];
                unset($args['call']);

                // Fix: Prevent WP from stripping iframe tags when updating post
                if ($func === "wp_update_post") {
                    remove_filter('content_save_pre', 'wp_filter_post_kses');
                }

                // Call public or private Function
                if (isset($args['private'])) {
                    unset($args['private']);
                    $out = call_user_func_array(array($this, $func), $args);
                } else {
                    $out = call_user_func_array($func, $args);
                }

                if (is_array($out)) {
                    $out = array_values($out);
                    header('Content-Type: application/json');
                    echo json_encode($out);
                } else {
                    // Check for errors
                    if (is_wp_error($out) ) {
                        echo $out->get_error_message();
                    } else {
                        echo $out;
                    }
                }
            } catch (Exception $e) {
                echo 'Exception: ' . $e->getMessage();
            }
			die();
		}

		/**
		 * AJAX: Handles deactivation task
		 */
		public function tm_aj_deactivation() {
            header('Content-Type: text/plain');

            try {
                // Validate call
                $this->valid_token($_GET['token']);

                delete_option('tm_coschedule_token');
                delete_option('tm_coschedule_id');
            } catch (Exception $e) {
                header('Content-Type: text/plain');
                echo 'Exception: ' . $e->getMessage();
            }
			die();
		}

		/**
		 * Get the post by id, with permalink and attachments
		 */
		public function get_full_post($post_id) {
			$post = get_post($post_id, "ARRAY_A");
			$post['permalink'] = get_permalink($post_id);

            // Media attachments (start with featured image)
            $post['attachments'] = array();
            $featured_image = $this->get_thumbnail($post_id);
            if ($featured_image) {
                array_push($post['attachments'], $featured_image);
            }

            if (isset($post['post_content'])) {
                // Add post attachments and remove duplicates
                $post['attachments'] = array_merge($post['attachments'], $this->get_attachments($post['post_content']));
                $post['attachments'] = array_unique($post['attachments']);

                // Generate an excerpt if one isn't available
                if (!isset($post['post_excerpt']) || (isset($post['post_excerpt']) && empty($post['post_excerpt']))) {
                    $post['post_excerpt'] = $this->get_post_excerpt($post['post_content']);
                }

                // Remove content
                unset($post['post_content']);
            }

            // Remove content filtered
            if (isset($post['post_content_filtered'])) {
                unset($post['post_content_filtered']);
            }

            // Process category
            if (!is_null($post['post_category'])) {
                $post['post_category'] = implode($post['post_category'], ',');
            } else {
                $post['post_category'] = "";
            }

			return $post;
		}

        /**
         * Generate an excerpt by taking the first words of the post
         */
        public function get_post_excerpt($content) {
            $the_excerpt = html_entity_decode($content, ENT_QUOTES, 'UTF-8');
            $excerpt_length = 35; // Sets excerpt length by word count
            $the_excerpt = strip_tags(strip_shortcodes($the_excerpt)); //Strips tags and images
            $words = explode(' ', $the_excerpt, $excerpt_length + 1);

            if(count($words) > $excerpt_length) {
                array_pop($words);
                array_push($words, '…');
                $the_excerpt = implode(' ', $words);
            }

            // Remove undesirable whitespace and condense consecutive spaces
            $the_excerpt = preg_replace('/\s+/', " ", $the_excerpt);

            return $the_excerpt;
        }

		/**
		 * Get posts with permalinks, attachments, and categories
		 */
		public function get_posts_with_categories($args) {
			// Load posts
			$out = call_user_func_array('get_posts', $args);

			$posts = array();
			foreach ($out as $post) {
				$post = $this->get_full_post($post->ID);

				array_push($posts, $post);
			}
			return $posts;
		}

        /**
         * Get the thumbnail url of the post
         */
        public function get_thumbnail($post_id) {
            $post_thumbnail_id = get_post_thumbnail_id($post_id);
            $post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);
            $site_url = get_site_url();

            // remove trailing slash from site url
            if(substr($site_url, -1) == '/') {
                $site_url = substr($site_url, 0, -1);
            }

            // Only include valid URL
            if (is_string($post_thumbnail_url) && strlen($post_thumbnail_url) > 0) {
                // Older versions of WordPress (<3.6) may exclude site URL from attachment URL
                if (strpos($post_thumbnail_url, 'http') === FALSE) {
                    $post_thumbnail_url = $site_url . $post_thumbnail_url;
                }
            } else {
                $post_thumbnail_url = null;
            }

            return $post_thumbnail_url;
        }

        /**
         * Get array of all attachments of the post
         */
        public function get_attachments($content) {
            $attachments = array();

            preg_match_all('/<img[^>]+>/i',$content, $images);

            for ($i = 0; $i < count($images[0]); $i++) {
                // get the source string
                preg_match('/src="([^"]+)/i',$images[0][$i], $img);

                // remove opening 'src=' tag, can`t get the regex right
                $attachments[] = str_ireplace( 'src="', '',  $img[0]);
            }

            return $attachments;
        }

        /**
         * Get currated array of all plugins installed in this blog
         */
        public function get_installed_plugins() {
            $plugins = array();
            $plugins['active'] = array();
            $plugins['inactive'] = array();

            foreach (get_plugins() as $key => $plugin) {
                $plugin["path"] = $key;
                $plugin["status"] = is_plugin_active($key) ? "Active" : "Inactive";

                if (is_plugin_active($key)) {
                    array_push($plugins['active'], $plugin);
                } else {
                    array_push($plugins['inactive'], $plugin);
                }
            }

            return $plugins;
        }

		/**
		 * Callback for when a post is created or updated
		 */
		public function save_post_callback($post_id) {
			// Verify post is not a revision
			if ($this->connected && !wp_is_post_revision($post_id)) {
				// Load post
				$post = $this->get_full_post($post_id);

				// Send to API
				$this->api_post('/hook/wordpress_posts/save?_wordpress_key='.$this->token, $post);
			}
		}

		/**
		 * Callback for when a post is deleted
		 */
		public function delete_post_callback($post_id) {
			// Verify post is not a revision
			if ($this->connected && !wp_is_post_revision($post_id)){
				// Send to API
				$this->api_post('/hook/wordpress_posts/delete?_wordpress_key='. $this->token, array('post_id'=>$post_id));
			}
		}

		/**
		 * Callback for when a category is created or updated
		 */
		public function save_category_callback($category_id) {
			if ($this->connected) {
				$category = get_category($category_id, "ARRAY_A");
				$this->api_post('/hook/wordpress_categories/save?_wordpress_key='.$this->token, $category);
			}
		}

		/**
		 * Callback for when a category is deleted
		 */
		public function delete_category_callback($category_id) {
			if ($this->connected) {
				$resp=$this->api_post('/hook/wordpress_categories/delete?_wordpress_key='. $this->token, array('cat_id'=>$category_id));
			}
		}

		/**
		 * Callback for when a user is created or updated
		 */
		public function save_user_callback($user_id) {
			if ($this->connected) {
				$user = get_userdata($user_id);
				$can_edit = $user->has_cap('edit_posts');
				if ($can_edit) {
					$this->api_post('/hook/wordpress_authors/save?_wordpress_key='. $this->token, (array)$user->data);
				} else {
					// Remove
					$this->delete_user_callback($user_id);
				}
			}
		}

		/**
		 * Callback for when a user is deleted
		 */
		public function delete_user_callback($user_id) {
			if ($this->connected) {
				$this->api_post('/hook/wordpress_authors/delete?_wordpress_key='. $this->token , array('user_id'=>$user_id));
			}
		}

		/**
		 * Post data to a url on the api
		 * Returns: Result of call
		 */
		public function api_post($url, $body) {
			$request = new WP_Http;
			return $request->request($this->api.$url, array('method' => 'POST', 'body' => $this->array_decode_entities($body)));
		}

		/**
		 * Get data from a url on the api
		 * Returns: Result of call
		 */
		public function api_get($url) {
			$request = new WP_Http;
			return $request->request($this->api.$url);
		}

		/**
		 * Get cache bust number from assets
		 * Returns: Number from text file
		 */
		public function get_cache_bust() {
			$location = 'https://d27i93e1y9m4f5.cloudfront.net/plugin/cache_bust.txt';
			$request = new WP_Http;
			$result = $request->request($location);
			if (is_array($result) && isset($result['body'])) {
				return $result['body'];
			}
			return '0';
		}

		/**
		 * Given an array it html_entity_decodes every element of the array that is a string.
		 */
		public function array_decode_entities($array){
			$new_array = array();

			foreach ($array as $key => $string) {
				if(is_string($string)) {
					$new_array[$key] = html_entity_decode($string, ENT_QUOTES);
				} else {
					$new_array[$key] = $string;
				}
			}

			return $new_array;
		}

		/**
		* Edit Flow Fix: Runs before the edit flow function that modifies the post_date_gmt
		*/
		public function fix_custom_status_timestamp_before($data) {
			// Save post_date_gmt for later
			global $cos_cached_post_date_gmt;
			if (isset($data['post_date_gmt']) && !empty($data['post_date_gmt'])) {
				$cos_cached_post_date_gmt = $data['post_date_gmt'];
			}

			return $data;
		}

		/**
		* Edit Flow Fix: Runs after the edit flow function that modifies the post_date_gmt
		*/
		public function fix_custom_status_timestamp_after($data) {
			global $cos_cached_post_date_gmt;
			if (isset($cos_cached_post_date_gmt) && !empty($cos_cached_post_date_gmt)) {
				$data['post_date_gmt'] = $cos_cached_post_date_gmt;
			}
			return $data;
		}

		/**
		* Get's the current post's post_type.
		*/
		public function get_current_post_type() {
			global $post, $typenow, $current_screen;

			//we have a post so we can just get the post type from that
			if ($post && $post->post_type)
				return $post->post_type;

			//check the global $typenow - set in admin.php
			elseif($typenow)
				return $typenow;

			//check the global $current_screen object - set in sceen.php
			elseif($current_screen && $current_screen->post_type)
				return $current_screen->post_type;

			//lastly check the post_type querystring
			elseif(isset( $_REQUEST['post_type']))
				return sanitize_key( $_REQUEST['post_type']);

			//we do not know the post type!
			return null;
		}
	} // End tm_coschedule class

	// Init Class
	new tm_coschedule();
}

?>