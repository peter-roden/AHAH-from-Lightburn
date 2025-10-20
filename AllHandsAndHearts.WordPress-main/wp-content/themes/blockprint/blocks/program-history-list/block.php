<?php
/**
 * Program History List Block
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

$class_name = build_block_class_name( 'bg-neutral-50', $block );

$style = build_block_styles( $block );

$active_programs_heading = get_field('active_programs_heading');
$active_programs_text = get_field('active_programs_text');
$active_programs_button_link = get_field('active_programs_button_link');

$sort_by_param = $_GET['programHistorySortBy'] ?? 'country';

if ( !function_exists( 'render_programs_list' ) ) {
    function render_programs_list($sort_taxonomy) {
        $grouped = [];

        $terms = get_terms([
            'taxonomy' => $sort_taxonomy,
            'hide_empty' => false,
        ]);

        if (!empty($terms) && !is_wp_error($terms)) {
            foreach ($terms as $term) {
                $posts = get_posts([
                    'post_type' => 'program',
                    'tax_query' => [
                        [
                            'taxonomy' => $sort_taxonomy,
                            'field'    => 'term_id',
                            'terms'    => $term->term_id,
                        ],
                    ],
                    'posts_per_page' => -1,
                ]);

                if (!empty($posts)) {
                    $grouped[] = [
                        'term' => $term,
                        'posts' => $posts,
                    ];
                }
            }
        }

        // Render the HTML list
        ob_start(); ?>
        <div class="py-8 @2xl:py-12 @5xl:py-16 js-program-history-list">
            <div class="flex items-center gap-x-4 text-sm mb-8 @2xl:mb-12 @5xl:mb-16">
                <b class="font-semibold">Sort by</b>
                <div class="flex bg-white rounded-full">
                    <div class="relative z-0 shrink-0">
                        <input class="absolute -z-1 opacity-0 peer js-program-history-list__filter" type="radio" name="programHistorySortBy" id="programHistorySortByCountry" value="country"<?php echo $sort_taxonomy === 'country' ? ' checked' : '' ?>>
                        <label class="flex items-center min-w-34 h-10 px-6 rounded-full cursor-pointer transition-colors peer-checked:bg-secondary peer-checked:text-white" for="programHistorySortByCountry">Location</label>
                    </div>
                    <div class="relative z-0 shrink-0">
                        <input class="absolute -z-1 opacity-0 peer js-program-history-list__filter" type="radio" name="programHistorySortBy" id="programHistorySortByDisasterType" value="disaster-type"<?php echo $sort_taxonomy === 'disaster-type' ? ' checked' : '' ?>>
                        <label class="flex items-center min-w-34 h-10 px-6 rounded-full cursor-pointer transition-colors peer-checked:bg-secondary peer-checked:text-white" for="programHistorySortByDisasterType">Disaster Type</label>
                    </div>
                </div>
            </div>

            <ul class="list-none pl-0 @2xl:columns-3 @4xl:columns-4 gap-x-16 space-y-10 js-program-history-list__query">
                <?php foreach ( $grouped as $group ) : ?>
                    <li class="border-t pt-2 break-inside-avoid">
                        <div<?php /* class="hidden @2xl:block" */ ?>>
                            <h3 class="text-xl font-bold mb-4">
                                <?php echo esc_html($group['term']->name) ?>
                            </h3>

                            <?php foreach ( $group['posts'] as $post ) :
                                $title = $post->post_title;
                                $link = get_permalink($post->ID);
                                $location = get_field('location', $post->ID);
                                $start_date = get_field('start_date', $post->ID);
                                $end_date = get_field('end_date', $post->ID);
                            ?>
                                <ul class="list-none pl-0">
                                    <li><a class="text-inherit hover:text-primary no-underline font-semibold" href="<?php echo $link ?>"><?php echo $title ?></a></li>
                                    <?php echo $location ? "<li>{$location}</li>" : ''?>
                                    <li><?php echo date_format(date_create($start_date), 'F Y') . ($end_date ? ' - ' . date_format(date_create($end_date), 'F Y') : '') ?></li>
                                </ul>
                            <?php endforeach ?>
                        </div>

                        <?php /* echo do_blocks('<!-- wp:acf/accordions {"name":"acf/accordions","data":{"field_680669d9d4f03":"0"},"mode":"preview","className":"@2xl:hidden"} -->
                            <!-- wp:acf/accordion {"name":"acf/accordion","data":{"field_62f566138b06d":"'.esc_html($group['term']->name).'","field_62f57053d9d4d":"0"},"mode":"preview"} -->
                                <!-- wp:html -->
                                
                                <!-- /wp:html -->
                            <!-- /wp:acf/accordion -->
                        <!-- /wp:acf/accordions -->') */ ?>
                    </li>
                <?php endforeach ?>
            </ul>
        </div>
        <?php return ob_get_clean();
    }
}
?>

<div id="<?php echo esc_attr( $anchor ) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr( $style ) . '"' : '' ?>>
    <div class="@container container-wide">
        <div class="<?php echo esc_attr('flex flex-col gap-y-12 @4xl:gap-y-20 [&>*]:w-full pt-6 @4xl:pt-12 pb-12') ?>">
            <?php echo do_blocks('<!-- wp:acf/accordions {"name":"acf/accordions","data":{"field_680669d9d4f03":"0"},"mode":"preview"} -->
                <!-- wp:acf/accordion {"name":"acf/accordion","data":{"field_62f566138b06d":"Program History List View","field_62f57053d9d4d":"0"},"mode":"preview"} -->
                    <!-- wp:html -->
                    ' . render_programs_list($sort_by_param) . '
                    <!-- /wp:html -->
                <!-- /wp:acf/accordion -->
            <!-- /wp:acf/accordions -->') ?>

            <?php if ( $active_programs_heading || $active_programs_text || $active_programs_button_link ) : ?>
                <div class="grid @4xl:grid-cols-12 gap-x-4 gap-y-6 s">
                    <div class="flex flex-col gap-y-10 @4xl:col-span-5">
                        <?php if ( $active_programs_heading ) : ?>
                            <h2 class="text-h3 mb-0">
                                <?php echo $active_programs_heading ?>
                            </h2>
                        <?php endif ?>

                        <?php if ( $active_programs_button_link ) : ?>
                            <div class="wp-block-buttons hidden @4xl:block">
                                <div class="wp-block-button">
                                    <a class="wp-block-button__link wp-element-button" href="<?php echo $active_programs_button_link['url'] ?>"<?php echo $active_programs_button_link['target'] === '_blank' ? ' target="_blank" rel="noopener noreferrer"' : '' ?>>
                                        <?php echo $active_programs_button_link['title'] ?>
                                    </a>
                                </div>
                            </div>
                        <?php endif ?>
                    </div>

                    <div class="flex flex-col gap-y-6 @4xl:col-span-6 @4xl:col-start-7">
                        <?php if ( $active_programs_text ) : ?>
                            <div>
                                <?php echo $active_programs_text ?>
                            </div>
                        <?php endif ?>

                        <?php if ( $active_programs_button_link ) : ?>
                            <div class="wp-block-buttons @4xl:hidden">
                                <div class="wp-block-button">
                                    <a class="wp-block-button__link wp-element-button" href="<?php echo $active_programs_button_link['url'] ?>"<?php echo $active_programs_button_link['target'] === '_blank' ? ' target="_blank" rel="noopener noreferrer"' : '' ?>>
                                        <?php echo $active_programs_button_link['title'] ?>
                                    </a>
                                </div>
                            </div>
                        <?php endif ?>
                    </div>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>