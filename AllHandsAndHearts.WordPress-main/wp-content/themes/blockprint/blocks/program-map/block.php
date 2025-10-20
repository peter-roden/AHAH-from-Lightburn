<?php
/**
 * Program Map Block
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

$class_name = build_block_class_name( '@container bg-neutral-50 overflow-hidden js-program-map', $block );

$style = build_block_styles( $block );

// check if the function below already exists before declaring

if (!function_exists('get_terms_for_programs')) {
        function get_terms_for_programs($taxonomy) {
            $terms = get_terms([
                'taxonomy' => $taxonomy,
                'hide_empty' => true,
            ]);

            return array_filter($terms, function($term) use ($taxonomy) {
                $posts = get_posts([
                    'post_type' => 'program',
                    'posts_per_page' => 1, // just need to know if *any* exist
                    'tax_query' => [[
                        'taxonomy' => $taxonomy,
                        'field' => 'term_id',
                        'terms' => $term->term_id,
                    ]],
                    'fields' => 'ids',
                ]);

                return !empty($posts);
            });
        }
    }

$countries = get_terms_for_programs('country');
$disaster_types = get_terms_for_programs('disaster-type');
$response_types = get_terms_for_programs('response-type');

$country_param = $_GET['country'] ?? '';
$disaster_type_param = $_GET['disasterType'] ?? '';
$response_type_param = $_GET['responseType'] ?? '';

$filters = [
    [
        'label' => 'Country',
        'name' => 'country',
        'options' => taxonomy_to_options($countries),
        'selected_value' => $country_param,
        'type' => 'select',
    ],
    [
        'label' => 'Disaster Type',
        'name' => 'disasterType',
        'options' => taxonomy_to_options($disaster_types),
        'selected_value' => $disaster_type_param,
        'type' => 'select',
    ],
    [
        'label' => 'Response Type',
        'name' => 'responseType',
        'options' => taxonomy_to_options($response_types),
        'selected_value' => $response_type_param,
        'type' => 'select',
    ],
    // [
    //     'label' => 'Arrival Date',
    //     'name' => 'startDate',
    //     'type' => 'month',
    //     'prefix' => 'Arrive',
    // ],
    // [
    //     'label' => 'Departure Date',
    //     'name' => 'endDate',
    //     'type' => 'month',
    //     'prefix' => 'Depart',
    // ],
];

$args = [
    'post_type' => 'program',
    'posts_per_page' => -1,
    'orderby' => 'title',
    'order'   => 'ASC',
    'relevanssi' => true,
];

$query = new WP_Query($args);
?>

<div id="<?php echo esc_attr( $anchor ) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr( $style ) . '"' : '' ?>>
    <div class="@container container-wide pt-12 @2xl:pt-16">
        <h2 class="text-center mb-0">Program Map</h2>
        <?php get_template_part('partials/filters', null, [
            'filters' => $filters,
            'show_search' => true,
            'search_placeholder' => 'Search the Map'
        ]); ?>
    </div>

    <div id="map" class="h-128.5 @2xl:h-170"></div>

    <div class="group fixed left-0 top-(--wp-admin--admin-bar--height,0px) bottom-0 w-full z-[999] overflow-hidden transition-[visibility] duration-500 data-[state=closed]:invisible js-program-summary" aria-hidden="true" data-state="closed">
        <div class="absolute inset-0 group-data-[state=open]:bg-black/40 transition-colors duration-500 js-program-summary__close"></div>
        <div class="absolute top-0 right-0 h-full w-full md:w-11/12 max-w-195 bg-white overflow-auto p-8 group-data-[state=closed]:translate-x-full transition-transform duration-500">
            <button type="button" class="absolute top-0 left-0 size-8 flex items-center justify-center cursor-pointer js-program-summary__close" aria-label="close summmary">
                <svg class="" viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
            <div class="@container js-program-summary__content"></div>
        </div>
    </div>

    <script>
        window.googleMapsApiKey = 'AIzaSyB53Z97R0KPPHrtQDKN4nb5BaIXixjVEUY';
        window.programs = [
            <?php while ( $query->have_posts() ) :
                $query->the_post();
                $post = get_post();
                $id = $post->ID;
                $thumbnail_id = get_post_thumbnail_id($id);
                $featured_image_data = wp_get_attachment_image_src($thumbnail_id, 'medium_large');
                $volunteer_application = get_field('volunteer_application', $id);
                $volunteer_application_url = $volunteer_application ? get_permalink($volunteer_application->ID) : '';
                $case_study = get_field('case_study', $id);
                $case_study_url = $case_study ? get_permalink($case_study->ID) : '';
                $stats = get_field('stats', $id) ?: [];
            ?>
                {
                    title: <?php echo json_encode($post->post_title) ?>,
                    lat: <?php echo get_field('latitude', $id) ?>,
                    lng: <?php echo get_field('longitude', $id) ?>,
                    location: <?php echo json_encode(get_field('location', $id)) ?>,
                    link: <?php echo json_encode(esc_attr(get_permalink($post))) ?>,
                    startDate: <?php echo json_encode(date_format(date_create(get_field('start_date', $id)), 'F Y')) ?>,
                    startDateNumbers: <?php echo json_encode(date_format(date_create(get_field('start_date', $id)), 'Ym')) ?>,
                    endDate: <?php echo json_encode(get_field('end_date', $id) ? date_format(date_create(get_field('end_date', $id)), 'F Y') : '') ?>,
                    endDateNumbers: <?php echo json_encode(get_field('end_date', $id) ? date_format(date_create(get_field('end_date', $id)), 'Ym') : '') ?>,
                    featuredImage: {
                        url: <?php echo json_encode($featured_image_data[0]) ?>,
                        width: <?php echo json_encode($featured_image_data[1]) ?>,
                        height: <?php echo json_encode($featured_image_data[2]) ?>,
                        alt: <?php echo json_encode(get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true)) ?>
                    },
                    shortDescription: <?php echo json_encode(get_field('short_description', $id)) ?>,
                    donateUrl: <?php echo json_encode(get_field('donate_url', $id)) ?>,
                    volunteerUrl: <?php echo json_encode($volunteer_application_url) ?>,
                    caseStudyUrl: <?php echo json_encode($case_study_url) ?>,
                    active: <?php echo get_field('active', $id) ? 'true' : 'false' ?>,
                    stats: [
                        <?php foreach ($stats as $stat) : ?>
                            {
                                heading: <?php echo json_encode(get_field('heading', $stat->ID)) ?>,
                                description: <?php echo json_encode(get_field('description', $stat->ID)) ?>
                            },
                        <?php endforeach ?>
                    ],
                    summary: <?php echo json_encode(get_field('map_detail_summary', $id)) ?>,
                    mediaGallery: [
                        <?php while ( have_rows('map_detail_media_gallery', $id) ) :
                            the_row();
                            $image = get_sub_field('image');
                            $video_embed = get_sub_field('video_embed');
                            $image_data = $image ? wp_get_attachment_image_src($image['id'], 'medium_large') : false;
                        ?>
                            {
                                image: {
                                    url: <?php echo json_encode($image_data ? $image_data[0] : '') ?>,
                                    width: <?php echo json_encode($image_data ? $image_data[1] : '') ?>,
                                    height: <?php echo json_encode($image_data ? $image_data[2] : '') ?>,
                                    alt: <?php echo json_encode($image ? get_post_meta($image['id'], '_wp_attachment_image_alt', true) : '') ?>
                                },
                                videoEmbed: <?php echo json_encode($video_embed ?: '') ?>
                            },
                        <?php endwhile ?>
                    ],
                    country: <?php echo json_encode(get_taxonomy_term_slugs($id, 'country')) ?>,
                    disasterType: <?php echo json_encode(get_taxonomy_term_slugs($id, 'disaster-type')) ?>,
                    responseType: <?php echo json_encode(get_taxonomy_term_slugs($id, 'response-type')) ?>,
                },
            <?php endwhile ?>
        ];
    </script>
</div>