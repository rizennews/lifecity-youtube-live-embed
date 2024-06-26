<?php
/**
 * Plugin Name: Lifecity YouTube Live Embed
 * Plugin URI: https://github.com/rizennews/lifecity-youtube-live-embed
 * Description: Automatically embeds YouTube Live video and chat on your website when live.
 * Version: 1.0
 * Author: Padmore Aning
 * Author URI: https://designolabs.com
 * License:  MIT License
 * Requires at least: 6.0
 * Tested up to: 6.4
 * Requires PHP: 7.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Enqueue necessary scripts and styles
function lifecity_enqueue_scripts() {
    wp_enqueue_style('lifecity-styles', plugin_dir_url(__FILE__) . 'css/styles.css');
    wp_enqueue_script('lifecity-scripts', plugin_dir_url(__FILE__) . 'js/scripts.js', array('jquery'), null, true);
    if (is_admin()) {
        wp_enqueue_script('jquery-ui-accordion');
        wp_enqueue_script('lifecity-admin-scripts', plugin_dir_url(__FILE__) . 'js/admin-scripts.js', array('jquery-ui-accordion'), null, true);
    }
}
add_action('wp_enqueue_scripts', 'lifecity_enqueue_scripts');

// Admin settings menu
function lifecity_add_admin_menu() {
    add_options_page('Lifecity YouTube Settings', 'Lifecity YouTube', 'manage_options', 'lifecity-youtube', 'lifecity_options_page');
}
add_action('admin_menu', 'lifecity_add_admin_menu');

// Register settings
function lifecity_settings_init() {
    register_setting('lifecity_youtube', 'lifecity_youtube_api_key');

    add_settings_section(
        'lifecity_youtube_section',
        __('Lifecity YouTube Live Settings', 'lifecity-youtube'),
        'lifecity_youtube_section_callback',
        'lifecity_youtube'
    );

    add_settings_field(
        'lifecity_youtube_api_key',
        __('YouTube API Key', 'lifecity-youtube'),
        'lifecity_youtube_api_key_render',
        'lifecity_youtube',
        'lifecity_youtube_section'
    );
}
add_action('admin_init', 'lifecity_settings_init');

function lifecity_youtube_api_key_render() {
    $options = get_option('lifecity_youtube_api_key');
    ?>
    <input type='text' name='lifecity_youtube_api_key' value='<?php echo $options; ?>' style='width: 50%;'>
    <?php
}

function lifecity_youtube_section_callback() {
    echo __('Enter your YouTube API key to automatically embed YouTube Live videos.', 'lifecity-youtube');
}

// Plugin options page
function lifecity_options_page() {
    ?>
    <div class="wrap">
        <h1><?php _e('Lifecity YouTube Live Embed', 'lifecity-youtube'); ?></h1>
        <form action='options.php' method='post'>
            <?php
            settings_fields('lifecity_youtube');
            do_settings_sections('lifecity_youtube');
            submit_button();
            ?>
        </form>
        <h2><?php _e('How to Use', 'lifecity-youtube'); ?></h2>
        <div class="accordion">
            <h3><?php _e('Shortcode Usage', 'lifecity-youtube'); ?></h3>
            <div>
                <p><?php _e('To embed the YouTube Live video and chat, use the following shortcode:', 'lifecity-youtube'); ?></p>
                <code>[lifecity-youtube]</code>
            </div>
        </div>
        <div>
            <h3><?php _e('YouTube API Key', 'lifecity-youtube');?></h3>
            <p>
                <p><?php _e('You can get your YouTube API key from the <a href="https://developers.google.com/youtube/v3/getting-started" target="_blank">Google Developers Console</a>.', 'lifecity-youtube');?></p>
                <p><?php _e('To get your YouTube API key:', 'lifecity-youtube');?></p>
                <p><?php _e('1. Go to the Google Developers Console: Visit the Google Developers Console at [https://console.developers.google.com/](https://console.developers.google.com/).', 'lifecity-youtube');?></p>
                <p><?php _e('2. Create a new project: Click on the <b>Select a project</b> dropdown menu and select <b>Create a new project</b>. Enter a name for your project and click <b>Create</b>.', 'lifecity-youtube');?></p>
                <p><?php _e('3. Enable YouTube Data API v3: Click on the <b>Enable APIs and Services</b> dropdown menu and select <b>YouTube Data API v3</b>.', 'lifecity-youtube');?></p>
                <p><?php _e('4. Create an API key: Click on the <b>Credentials</b> dropdown menu and select <b>Create credentials</b> > <b>API key</b>.', 'lifecity-youtube');?></p>
                <p><?php _e('5. Copy your API key: Click on the <b>API key</b> dropdown menu and select <b>Copy to clipboard</b>.', 'lifecity-youtube');?></p>
                <p><?php _e('You can now paste your API key in the <b>YouTube API Key</b> field in the <b>Lifecity YouTube Live Embed</b> settings page.', 'lifecity-youtube');?></p>
                <p><?php _e('You can now embed the YouTube Live video and chat on your website.', 'lifecity-youtube');?></p>

            </div>
            <h3><?php _e('Support', 'lifecity-youtube');?></h3>
            <div>
                <p><?php _e('If you have any questions, please contact us at <a href="https://designolabs.com" target="_blank">Designolabs Studio</a>.', 'lifecity-youtube');?></p>
            </div>
            <h3><?php _e('About', 'lifecity-youtube');?></h3>
        </div>
        </div>
        <p>If you find this plugin helpful, consider buying us a coffee!</p>
        <a href="https://www.buymeacoffee.com/designolabs" target="_blank">
            <img src="https://img.buymeacoffee.com/button-api/?text=Buy%20us%20a%20coffee&emoji=&slug=yourusername&button_colour=FFDD00&font_colour=000000&font_family=Cookie&outline_colour=000000&coffee_colour=ffffff">
        </a>
        <p>This plugin was developed by <a href="https://github.com/rizennews/" target="_blank">Designolabs Studio</a>.</p>
    </div>
    <?php
}

// Function to get the YouTube Live video
function lifecity_get_youtube_live_video($api_key) {
    // Assuming you have a method to fetch live video ID from YouTube API
    $live_video_id = ''; // Fetch the live video ID using YouTube API
    return $live_video_id;
}

// Shortcode to embed YouTube Live video
function lifecity_youtube_shortcode() {
    $api_key = get_option('lifecity_youtube_api_key');
    $live_video_id = lifecity_get_youtube_live_video($api_key);

    if ($live_video_id) {
        ob_start();
        ?>
        <div id="lifecity-youtube-container">
            <div id="lifecity-youtube-video">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo $live_video_id; ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
            <div id="lifecity-youtube-chat" style="display:none;">
                <iframe src="https://www.youtube.com/live_chat?v=<?php echo $live_video_id; ?>&embed_domain=<?php echo $_SERVER['HTTP_HOST']; ?>" width="100%" height="500px" frameborder="0"></iframe>
            </div>
            <div id="lifecity-youtube-name-input">
                <label for="user-name"><?php _e('Enter your name to join the chat:', 'lifecity-youtube'); ?></label>
                <input type="text" id="user-name" name="user-name">
                <button type="button" id="enter-chat"><?php _e('Join Chat', 'lifecity-youtube'); ?></button>
            </div>
        </div>
        <?php
        return ob_get_clean();
    } else {
        return __('No live video is currently available.', 'lifecity-youtube');
    }
}
add_shortcode('lifecity-youtube', 'lifecity_youtube_shortcode');
?>
