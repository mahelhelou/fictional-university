<?php

require get_theme_file_path('/inc/search-route.php');

// Rest api customizing
function university_custom_rest() {
    register_rest_field('post', 'authorName', array(
        'get_callback' => function() {return get_the_author();}
    ));
}

add_action('rest_api_init', 'university_custom_rest');

// STYLES & SCRIPTS
function university_files() {
    // loading styles
    wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('university_main_styles', get_stylesheet_uri(), NULL, microtime());

    // loading scripts
    wp_enqueue_script('university-_main_scripts', get_theme_file_uri('/js/scripts-bundled.js'), NULL, microtime(), true);

    // root url
    wp_localize_script('university_main_scripts', 'universityData', array(
        'root_url' => get_site_url()
    ));
}

add_action('wp_enqueue_scripts', 'university_files');

// THEME FEATURES
function university_features() {
    // register_nav_menu('headerMenuLocation', 'Header Menu Location');
    // register_nav_menu('footerLocationOne', 'Footer Location One');
    // register_nav_menu('footerLocationTwo', 'Footer Location Two');
    add_theme_support('title-tag'); // Blog title in the bar
    add_theme_support('post-thumbnails');
    add_image_size('professorLandscape', 400, 260, true);
    add_image_size('professorPortrait', 480, 650, true);
    add_image_size('pageBanner', 1500, 350, true);
}

add_action('after_setup_theme', 'university_features');

// CUSTOM POST TYPES
// moved to mu-plugins folder {near to plugins folder}

// Adjust Queries
function university_adjust_queries($query) {
    if (!is_admin() && is_post_type_archive('event') && $query->is_main_query()) {
        $today = date('Ymd');
        $query->set('meta_key', 'event_date');
        $query->set('orderby', 'meta_value_num');
        $query->set('order', 'ASC');
        $query->set('meta_query', array(
            array(
                'key' => 'event_date',
                'compare' => '>=',
                'value' => $today,
                'type' => 'numeric'
            )
        ));
    }

    if (!is_admin() && is_post_type_archive('program') && $query->is_main_query()) {
        $query->set('orderby', 'title');
        $query->set('order', 'ASC');
        $query->set('posts_per_page', -1);
    }
}

add_action('pre_get_posts', 'university_adjust_queries');

// Page Banner
function pageBanner($args = NULL) {
    // if title isn't passed to the array
    if (!$args['title']) {
        $args['title'] = get_the_title();
    }

    if (!$args['subtitle']) {
        $args['subtitle'] = get_field('page_banner_subtitle');
    }

    if (!$args['photo']) {
        if (get_field('page_banner_background_image')) {
            $args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
        } else {
            $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
        }
    }
?>
    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(<?php /* $pageBannerImage = get_field('page_banner_background_image');
        // echo $pageBannerImage['url'];
        echo $pageBannerImage['sizes']['pageBanner'];  */
        echo $args['photo'];
        ?>);"></div>
        <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?php echo $args['title'] ?></h1>
        <div class="page-banner__intro">
            <p><?php echo $args['subtitle']; ?></p>
        </div>
        </div>
    </div>
<?php }

function universityMapKey($api) {
    $api['key'] = 'AIzaSyBXVTnMfrlnuDVR4aDVD9xf2jjrngCJoNY';
    return $api;
}

add_filter('acf/fields/google_map/api', 'universityMapKey');