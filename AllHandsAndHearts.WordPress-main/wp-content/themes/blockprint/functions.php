<?php
/**
 * Blockprint functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 * @package Blockprint
 */

/**
 * Theme constants
 * Define shared stylesheet URLs and paths
 */
define( 'BLOCKPRINT_FONT_STYLESHEET_PATH', 'https://fonts.googleapis.com/css2?family=Manrope:wght@400..800&display=swap' );
define( 'BLOCKPRINT_FONT_2_STYLESHEET_PATH', 'https://use.typekit.net/oex3tbo.css' );
define( 'BLOCKPRINT_GLOBAL_STYLESHEET_PATH', '/assets/css/dist/global.css' );

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @return void
 */
function blockprint_setup() {
    // Enqueue editor styles and fonts
    add_editor_style( [
        BLOCKPRINT_FONT_STYLESHEET_PATH,
        BLOCKPRINT_FONT_2_STYLESHEET_PATH,
        '.' . BLOCKPRINT_GLOBAL_STYLESHEET_PATH,
        './admin/editor.css'
    ] );

    // Register nav menus
    register_nav_menus([
        'main'      => 'Main',
        'utility'   => 'Utility',
        'footer-1'  => 'Footer 1',
        'footer-2'  => 'Footer 2',
        'footer-3'  => 'Footer 3',
        'footer-4'  => 'Footer 4',
        'legal'     => 'Footer Legal'
    ]);

    // Remove core block patterns
    remove_theme_support( 'core-block-patterns' );
}
add_action( 'after_setup_theme', 'blockprint_setup' );

/**
 * Enqueue styles.
 */
function blockprint_enqueue_styles() {
    wp_enqueue_style( 'fonts', BLOCKPRINT_FONT_STYLESHEET_PATH, [], null );
    wp_enqueue_style( 'fonts-2', BLOCKPRINT_FONT_2_STYLESHEET_PATH, [], null );
    wp_enqueue_style( 'global', get_template_directory_uri() . BLOCKPRINT_GLOBAL_STYLESHEET_PATH, [], null );

    if (is_admin_bar_showing()) {
        wp_enqueue_style( 'mobile-admin-bar-fix', get_template_directory_uri() . '/admin/mobile-admin-bar-fix.css', [], null );
    }
}
add_action( 'wp_enqueue_scripts', 'blockprint_enqueue_styles', 20 );

/**
 * Enqueue scripts.
 */
function blockprint_enqueue_scripts() {
    wp_enqueue_script( 'global', get_template_directory_uri() . '/assets/js/dist/global.js', [], null, true );
    wp_enqueue_script( 'tabs', get_template_directory_uri() . '/assets/js/dist/tabs.js', [], null, true );

    if (is_admin_bar_showing()) {
        wp_enqueue_script( 'mobile-admin-bar-fix', get_template_directory_uri() . '/admin/mobile-admin-bar-fix.js', [], null, true );
    }
}
add_action( 'wp_enqueue_scripts', 'blockprint_enqueue_scripts' );

/**
 * Enqueue block editor assets.
 */
function blockprint_enqueue_block_editor_assets() {
    wp_enqueue_script( 'blockprint-editor', get_template_directory_uri() . '/admin/editor.js', [ 'wp-blocks' ], null, true );
}
add_action( 'enqueue_block_editor_assets', 'blockprint_enqueue_block_editor_assets' );

/**
 * Register block styles.
 */
function blockprint_register_block_styles() {
    $block_styles = [
        'core/columns' => [
            'columns-reverse' => 'Reverse'
        ],
        'core/list' => [
            'no-disc' => 'No Disc'
        ],
        'core/button' => [
            'secondary' => 'Secondary',
            'white' => 'White',
            'outline-white' => 'Outline White'
        ]
    ];

    foreach ( $block_styles as $block => $styles ) {
        foreach ( $styles as $style_name => $style_label ) {
            register_block_style( $block, [
                'name'  => $style_name,
                'label' => $style_label,
            ] );
        }
    }
}
add_action( 'init', 'blockprint_register_block_styles' );

// Add custom block categories
require get_template_directory() . '/inc/add-block-categories.php';

// Add head/body scripts
require get_template_directory() . '/inc/add-head-body-scripts.php';

// Register custom REST API fields/endpoints
require get_template_directory() . '/inc/custom-rest-api.php';

// Disable emojis
require get_template_directory() . '/inc/disable-emojis.php';

// Add additonal headers
require get_template_directory() . '/inc/headers.php';

// Register block pattern categories
require get_template_directory() . '/inc/register-block-pattern-categories.php';

// Register blocks
require get_template_directory() . '/inc/register-blocks.php';

// Custom shortcodes
require get_template_directory() . '/inc/shortcodes.php';

// Build block class name
require get_template_directory() . '/inc/build-block-class-name.php';

// Build block styles
require get_template_directory() . '/inc/build-block-styles.php';

// Add favicon to head if no site icon is selected
function add_favicon_to_head() {
    if ( !has_site_icon() ) {
        echo '<link rel="icon" href="' . get_template_directory_uri() . '/favicon.ico" type="image/x-icon" />';
    }
}
add_action( 'wp_head', 'add_favicon_to_head' );

// Replace search icon svg
function custom_render_block_core_search ($block_content) {
    $new_svg = '<svg viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false" style="fill:none;min-width:0;min-height:0;width:1.125rem;height:1.125rem"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>';
	return preg_replace('/<svg.*?>.*?<\/svg>/s', $new_svg, $block_content);
}
add_filter('render_block_core/search', 'custom_render_block_core_search', null, 2);

// Templates
function blockprint_add_page_template() {
    // Program Template
    $program = get_post_type_object( 'program' );
    $program_template = [
        ['core/pattern', [
            'slug' => 'blockprint/program-detail'
        ]]
    ];
    $program->template = $program_template;
}
add_action( 'init', 'blockprint_add_page_template' );

function add_volunteer_template() {
    // Volunteer Template
    $volunteer = get_post_type_object( 'volunteer' );
    $volunteer_template = [
        ['acf/page-header'],
        ['acf/spacer'],
        ['core/group', ['align' => 'wide'], [
            ['core/html', [

            ]]
        ]],
        ['acf/spacer']
    ];
    $volunteer->template = $volunteer_template;
}
add_action( 'init', 'add_volunteer_template' );

// Convert taxonomy to options for filter select
function taxonomy_to_options($terms) {
    $options = [];
    foreach ($terms as $term) {
        $options[$term->slug] = $term->name;
    }
    return $options;
}

// pre-populate date_created field w/ today's date
add_filter('acf/load_field/name=date_created', function ($field) {
    $field['default_value'] = date('Ymd');
    return $field;
});

// Add columns to post listing in admin
require get_template_directory() . '/inc/add-admin-post-columns.php';

// Add new image sizes
add_image_size('1440', 1440, 9999);
add_image_size('1920', 1920, 9999);

// get a comma-separated list of taxonomy term slugs for a post
require get_template_directory() . '/inc/get-taxonomy-term-slugs.php';

// change breadcrumbs
function custom_change_breadcrumb_link($links) {
    if (is_singular('program')) {
        $post = get_queried_object();
        $breadcrumb = [[
            'url'  => get_permalink(632),
            'text' => 'Our Work',
        ]];

        if (get_field('active', $post->ID)) {
            // Insert a custom item after the home link (index 1)
            $breadcrumb[] = [
                'url'  => get_permalink(339),
                'text' => 'Active Programs',
            ];
        } else {
            $breadcrumb[] = [
                'url'  => '',
                'text' => 'Archived Programs',
            ];
        }

        array_splice($links, 0, 0, $breadcrumb);
    }

    return $links;
}
add_filter('wpseo_breadcrumb_links', 'custom_change_breadcrumb_link');

// Change 'Posts' to 'News' in admin menu
function rename_post_menu_label() {
    global $menu, $submenu;

    // Top-level menu
    foreach ($menu as $key => $item) {
        if ($item[2] === 'edit.php') {
            $menu[$key][0] = 'News';
            // $menu[$key][6] = 'dashicons-megaphone';
            break;
        }
    }

    // Submenu items
    if (isset($submenu['edit.php'])) {
        $submenu['edit.php'][5][0] = 'All News'; // Posts → All News
        $submenu['edit.php'][10][0] = 'Add News'; // Add New
        // $submenu['edit.php'][15][0] = 'News Categories'; // Categories
        // $submenu['edit.php'][16][0] = 'News Tags'; // Tags
    }
}
add_action('admin_menu', 'rename_post_menu_label');

// Change post type labels
function rename_post_object_labels() {
    global $wp_post_types;

    $labels = &$wp_post_types['post']->labels;

    $labels->name = 'News';
    $labels->singular_name = 'News';
    $labels->add_new = 'Add News';
    $labels->add_new_item = 'Add New News';
    $labels->edit_item = 'Edit News';
    $labels->new_item = 'News';
    $labels->view_item = 'View News';
    $labels->search_items = 'Search News';
    $labels->not_found = 'No News found';
    $labels->not_found_in_trash = 'No News found in Trash';
    $labels->all_items = 'All News';
    $labels->menu_name = 'News';
    $labels->name_admin_bar = 'News';
}
add_action('init', 'rename_post_object_labels');

// Change permalink to external link if field has a value
function external_permalink( $link, $post ) {
    $external_link = get_field('external_link', $post->ID);
    return $external_link ? $external_link : $link;
}
add_filter( 'post_link', 'external_permalink', 10, 2 );