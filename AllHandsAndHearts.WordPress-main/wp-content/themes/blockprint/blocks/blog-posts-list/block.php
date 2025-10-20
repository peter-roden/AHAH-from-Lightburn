<?php
/**
 * Blog Posts List Block
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

$category_filters = get_field('category_filters');
$posts_per_page = get_field('posts_per_page') ?: 15;
$show_featured_post = get_field('show_featured_post');
$featured_post = get_field('featured_post');
$image_aspect_ratio = get_field('image_aspect_ratio') ?: 'var(--card-image-aspect-ratio)';
$show_date = get_field('show_date');
$show_category = get_field('show_category');
$show_excerpt = get_field('show_excerpt');
$show_author_name = get_field('show_author_name');
$paged = get_query_var('paged') ?: 1;
$featured_post_id = 0;

$countries = get_terms([
    'taxonomy' => 'country',
    'orderby' => 'name',
    'order' => 'ASC'
]);

$program_types = get_terms([
    'taxonomy' => 'program-type',
    'orderby' => 'name',
    'order' => 'ASC'
]);

$country_param = $_GET['country'] ?? '';
$program_type_param = $_GET['programType'] ?? '';
$category_param = $_GET['category'] ?? '';
$search_param = $_GET['search'] ?? '';

$is_filtered = $country_param || $program_type_param || $category_param || $search_param;

$filters = [
    [
        'label' => 'Country',
        'name' => 'country',
        'options' => taxonomy_to_options($countries),
        'selected_value' => $country_param,
        'type' => 'select',
    ],
];

if ($program_type_param) {
    $filters[] = [
        'label' => 'Program',
        'name' => 'programType',
        'options' => taxonomy_to_options($program_types),
        'selected_value' => $program_type_param,
        'type' => 'select',
    ];
}

foreach ($category_filters as $id) {
    $category = get_category($id);
    $filters[] = [
        'label' => $category->name,
        'name' => 'category',
        'value' => $category->slug,
        'type' => 'checkbox',
        'checked' => str_contains($category_param, $category->slug),
    ];
}

if ( $show_featured_post ) {
    if ( $featured_post ) {
        $featured_post_id = $featured_post->ID;
    } else {
        $featured_post = get_posts([
            'post_type'     => 'post',
            'post_status'   => 'publish',
            'numberposts'   => 1
        ])[0];
        $featured_post_id = $featured_post->ID;
    }
}

$args = [
    'post_type'         => 'post',
    'paged'             => $paged,
    'posts_per_page'    => $posts_per_page,
    'post__not_in'      => $is_filtered ? [] : [ $featured_post_id ],
    's' => $search_param,
    'tax_query' => [
        'relation' => 'AND',
    ],    
    'orderby' => 'date', // sort by date
    'order' => 'DESC', // newest first
    // 'relevanssi' => true,
];

if ( $country_param ) {
    $args['tax_query'][] = [
        'taxonomy' => 'country',
        'field'    => 'slug',
        'terms'    => $country_param,
    ];
}

if ( $program_type_param ) {
    $args['tax_query'][] = [
        'taxonomy' => 'program-type',
        'field'    => 'slug',
        'terms'    => $program_type_param,
    ];
}

if ( $category_param ) {
    $args['category_name'] = $category_param;
}

$query = new WP_Query($args);
?>

<div id="<?php echo esc_attr($anchor) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr($style) . '"' : '' ?>>
    <div class="border-b border-purple-950 bg-neutral-50">
        <div class="container-wide">
            <?php get_template_part('partials/filters', null, [
                'filters' => $filters,
                'show_search' => true,
                'search_placeholder' => 'Search the News',
                'search_value' => $search_param
            ]); ?>
        </div>
    </div>

    <div class="@container container-wide flex flex-col gap-y-16 pt-6 md:pt-10 pb-16 md:pb-26 js-posts-list__query">
        <?php if ( $query->have_posts() ) : ?>
            <?php $total_pages = $query->max_num_pages; ?>

            <?php if ( $search_param ) : ?>
                <h2 class="text-h4 md:-mt-4 mb-0">
                    <span class="block font-normal tracking-normal text-xs mb-2">Search Results For</span>
                    &ldquo;<?php echo $search_param ?>&rdquo;
                </h2>
            <?php endif ?>

            <?php if ( $featured_post_id && $paged === 1 && !$is_filtered ) : ?>
                <div class="js-posts-list__featured">
                    <?php echo do_blocks('<!-- wp:acf/featured-blog-post {
                        "name": "acf/featured-blog-post",
                        "data": {
                            "post": '. $featured_post_id . ',
                            "_post": "field_68167fd144679",
                            "image_aspect_ratio": "'. $image_aspect_ratio . '",
                            "_image_aspect_ratio": "field_68167ff24467a",
                            "show_date": "'. $show_date . '",
                            "_show_date": "field_6816893767729",
                            "show_category": "'. $show_category . '",
                            "_show_category": "field_681680174467b",
                            "show_excerpt": "'. $show_excerpt . '",
                            "_show_excerpt": "field_681680334467c",
                            "show_author_name": "'. $show_author_name . '",
                            "_show_author_name": "field_6816804f4467e"
                        },
                        "mode":"preview"
                    } /-->'); ?>
                </div>
            <?php endif ?>

            <div class="grid <?php echo $posts_per_page % 3 === 0 ? '@xl:grid-cols-3' : '@xl:grid-cols-2' ?> gap-x-6 gap-y-16 js-posts-list__items">
                <?php while ( $query->have_posts() ) {
                    $query->the_post();
                    $post = get_post();

                    echo do_blocks('<!-- wp:acf/blog-post-card {
                        "name": "acf/blog-post-card",
                        "data": {
                            "post": '. $post->ID . ',
                            "_post": "field_68167fd144679",
                            "image_aspect_ratio": "'. $image_aspect_ratio . '",
                            "_image_aspect_ratio": "field_68167ff24467a",
                            "show_date": "'. $show_date . '",
                            "_show_date": "field_6816893767729",
                            "show_excerpt": "'. $show_excerpt . '",
                            "_show_excerpt": "field_681680334467c"
                        },
                        "mode":"preview"
                    } /-->');
                } ?>
            </div>

            <?php if ( $total_pages > 1 ) : ?>
                <nav class="pagination justify-center js-posts-list__pagination" aria-label="Pagination">
                    <?php echo paginate_links([
                        'base'         => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
                        'total'        => $total_pages,
                        'current'      => max(1, $paged),
                        'mid_size'     => 1,
                        'prev_text'    => 'Previous Page',
                        'next_text'    => 'Next Page'
                    ]); ?>
                </nav>
            <?php endif ?>
        <?php else : ?>
            <div class="text-center py-20">
                <p class="font-bold text-xl">No matches found</p>
                <p>Please try changing your filters.</p>
            </div>
        <?php endif ?>
    </div>
</div>