<?php
/**
 * Active Programs List Block
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or its parent block.
 */

$anchor = $block['id'];
if ( !empty($block['anchor']) ) {
    $anchor = $block['anchor'];
}

$class_name = build_block_class_name( 'js-posts-list', $block );

$style = build_block_styles( $block );

if (!function_exists('get_unique_sorted_terms')) {
    function get_unique_sorted_terms(array $posts, $taxonomy) {
        $terms_array = [];

        foreach ($posts as $post) {
            $post_id = is_object($post) ? $post->ID : (int) $post;
            $terms = get_the_terms($post_id, $taxonomy);

            if (!empty($terms) && !is_wp_error($terms)) {
                foreach ($terms as $term) {
                    // Prevent duplicates using term_id as the key
                    $terms_array[$term->term_id] = $term;
                }
            }
        }

        // Convert to slug => name
        $terms_array = wp_list_pluck($terms_array, 'name', 'slug');

        // Sort alphabetically by name
        asort($terms_array, SORT_NATURAL | SORT_FLAG_CASE);

        return $terms_array;
    }
}

$months = [
    1 => 'January',
    2 => 'February',
    3 => 'March',
    4 => 'April',
    5 => 'May',
    6 => 'June',
    7 => 'July',
    8 => 'August',
    9 => 'September',
    10 => 'October',
    11 => 'November',
    12 => 'December'
];

$country_param = $_GET['country'] ?? '';
$disaster_type_param = $_GET['disasterType'] ?? '';
$response_type_param = $_GET['responseType'] ?? '';
$arrival_month_param = $_GET['arrivalMonth'] ?? '';

$args = [
    'post_type' => 'program',
    'posts_per_page' => -1,
    'meta_query'  => [
        'relation' => 'AND',
        [
            'key'     => 'active',
            'value'   => '1',
            'compare' => '=',
        ]
    ],
    'tax_query' => [
        'relation' => 'AND',
    ],
    'meta_key' => 'urgent',
    'orderby' => 'meta_value_num',
    'order' => 'DESC',
    // 'relevanssi' => true,
];

if ( $country_param ) {
    $args['tax_query'][] = [
        'taxonomy' => 'country',
        'field'    => 'slug',
        'terms'    => $country_param,
    ];
}

if ( $disaster_type_param ) {
    $args['tax_query'][] = [
        'taxonomy' => 'disaster-type',
        'field'    => 'slug',
        'terms'    => $disaster_type_param,
    ];
}

if ( $response_type_param ) {
    $args['tax_query'][] = [
        'taxonomy' => 'response-type',
        'field'    => 'slug',
        'terms'    => $response_type_param,
    ];
}

if ( $arrival_month_param ) {
    $month = str_pad($arrival_month_param, 2, '0', STR_PAD_LEFT); // ensures '06' not '6'
    $args['meta_query'][] = [
        'key'     => 'start_date',
        'value'   => '^....' . $month,
        'compare' => 'REGEXP',
    ];
}

$query = new WP_Query($args);

$posts = [];
if ($query->have_posts()) {
    while ($query->have_posts()) {
        $query->the_post();
        $posts[] = get_post();
    }
}

$countries = get_unique_sorted_terms($posts, 'country');
$disaster_types = get_unique_sorted_terms($posts, 'disaster-type');
$response_types = get_unique_sorted_terms($posts, 'response-type');

$filters = [
    [
        'label' => 'Country',
        'name' => 'country',
        'options' => $countries,
        'selected_value' => $country_param,
        'type' => 'select',
    ],
    [
        'label' => 'Disaster Type',
        'name' => 'disasterType',
        'options' => $disaster_types,
        'selected_value' => $disaster_type_param,
        'type' => 'select',
    ],
    [
        'label' => 'Response Type',
        'name' => 'responseType',
        'options' => $response_types,
        'selected_value' => $response_type_param,
        'type' => 'select',
    ],
    [
        'label' => 'Arrival Month',
        'name' => 'arrivalMonth',
        'options' => $months,
        'selected_value' => $arrival_month_param,
        'type' => 'select',
    ],
];
?>

<div id="<?php echo esc_attr( $anchor ) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr( $style ) . '"' : '' ?>>
    <div class="border-b border-purple-950 bg-neutral-50">
        <div class="container-wide">
            <?php get_template_part('partials/filters', null, [ 'filters' => $filters ]); ?>
        </div>
    </div>

    <div class="@container container-wide py-12 js-posts-list__query">
        <?php if ( $posts ) : ?>
            <div class="grid @xl:grid-cols-2 @5xl:grid-cols-3 gap-x-8 gap-y-10 @2xl:gap-y-12 js-posts-list__items">
                <?php foreach ( $posts as $post ) :
                    $title = $post->post_title;
                    $link = get_permalink($post->ID);
                    $excerpt = $post->post_excerpt ?: get_field('short_description', $post->ID);
                    $urgent = get_field('urgent', $post->ID);
                    $location = get_field('location', $post->ID);
                    $donate_url = get_field('donate_url', $post->ID);
                    $volunteer_application = get_field('volunteer_application', $post->ID);
                    $start_date = get_field('start_date', $post->ID);
                ?>
                    <div class="relative flex flex-col group">
                        <div>
                            <div class="aspect-[1.68] w-full bg-neutral-100">
                                <?php echo get_the_post_thumbnail($post->ID, 'medium', [
                                    'loading' => 'lazy',
                                    'class' => 'size-full object-cover'
                                ]); ?>
                            </div>
                        </div>

                        <div class="flex flex-col gap-y-6 w-full p-6 @6xl:p-8 grow bg-neutral-50">
                            <div class="flex gap-6">
                                <div class="text-center shrink-0">
                                    <div class="text-h5 mb-0"><?php echo date_format(date_create($start_date), 'M') ?></div>
                                    <div class="text-h6 mb-0"><?php echo date_format(date_create($start_date), 'Y') ?></div>
                                </div>
                                <div class="grow">
                                    <h3 class="text-lg mb-3">
                                        <a class="text-current hover:text-purple-500 font-semibold no-underline! transition-colors
                                                before:content-[''] before:absolute before:inset-0" 
                                            href="<?php echo $link ?>">
                                            <?php echo $title ?>
                                        </a>
                                    </h3>

                                    <p class="text-sm text-purple-950/70 mb-3">
                                        <?php echo $location ?>
                                    </p>

                                    <?php if ( $urgent ) : ?>
                                        <p class="absolute top-0 left-1/2 -translate-y-1/2 -translate-x-1/2 flex items-center justify-center text-center bg-green-100 text-green-950 uppercase leading-[1.2] tracking-[0.05em] font-extrabold text-nowrap rounded-full min-h-7 px-4">
                                            Urgent need
                                        </p>
                                    <?php endif ?>

                                    <p class="text-sm line-clamp-3">
                                        <?php echo $excerpt ?>
                                    </p>
                                </div>
                            </div>

                            <div class="flex flex-col gap-y-5 text-center mt-auto">
                                <?php if ( $donate_url || $volunteer_application ) : ?>
                                    <div class="wp-block-buttons flex -mx-1">
                                        <!-- <?php if ( $donate_url ) : ?>
                                            <div class="wp-block-button w-full max-w-1/2 px-1">
                                                <a class="wp-block-button__link has-sm-font-size has-custom-font-size wp-element-button w-full z-2 relative" href="<?php echo $donate_url ?>" target="_blank" rel="noopener noreferrer">
                                                    Donate
                                                </a>
                                            </div>
                                        <?php endif ?> -->

                                        <?php if ( $volunteer_application ) : ?>
                                            <div class="wp-block-button is-style-outline w-full max-w-1/2 px-1">
                                                <a class="wp-block-button__link has-sm-font-size has-custom-font-size wp-element-button w-full z-2 relative" href="<?php echo get_permalink($volunteer_application) ?>">
                                                    Volunteer
                                                </a>
                                            </div>
                                        <?php endif ?>
                                    </div>
                                <?php endif ?>

                                <div>
                                    <?php get_template_part( 'partials/cta-link', null, [
                                        'link' => [
                                            'title' => 'Learn More <span class="sr-only">about ' . $title . '</span>',
                                            'url' => $link
                                        ],
                                        'class_name' => 'relative z-2',
                                    ] ); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        <?php else : ?>
            <div class="text-center py-20">
                <p class="font-bold text-xl">No matches found</p>
                <p>Please try changing your filters.</p>
            </div>
        <?php endif ?>
    </div>
</div>