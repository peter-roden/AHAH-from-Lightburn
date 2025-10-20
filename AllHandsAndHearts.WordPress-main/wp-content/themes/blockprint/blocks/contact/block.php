<?php
/**
 * Contact Block
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

$class_name = build_block_class_name( 'bg-purple-950', $block );

$style = build_block_styles( $block );
$heading = get_field( 'heading' );
$locations = get_posts(
    array(
        'post_type' => 'location',
        'posts_per_page' => -1,
        'orderby' => 'menu_order',
        'order' => 'ASC',
    )
);
$locations_section_heading = get_field( 'locations_section_heading' );
$form_section_heading = get_field( 'form_section_heading' );
$form_embed = get_field( 'form_embed' );
?>

<div id="<?php echo esc_attr( $anchor ) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr( $style ) . '"' : '' ?>>
    <div class="@container container-wide py-16">
        <?php if ($heading): ?>
            <h2 class="text-[28px] @2xl:text-[34px] text-white mb-10 @3xl:mb-12"><?php echo $heading; ?></h2>
        <?php endif; ?>
        <div class="grid grid-cols-2 gap-y-24 gap-x-8">
            <?php if ($locations): ?>
                <div class="col-span-2 @3xl:col-span-1">
                    <?php if ($locations_section_heading): ?>
                        <p class="text-[20px] @2xl:text-[22px] font-bold text-white mb-4 @3xl:mb-12"><?php echo $locations_section_heading; ?></p>
                    <?php endif; ?>
                    <div class="w-full grid grid-cols-2 @3xl:gap-y-12 gap-x-4">
                        <?php foreach ($locations as $location): ?>
                            <?php
                                $title = get_the_title($location);
                                $details = get_field('details', $location->ID);
                            ?>
                            <div class="text-white col-span-1 hidden @3xl:block">
                                <p class="font-semibold mb-1"><?php echo $title; ?></p>
                                <div class="[&_a]:text-white [&_a]:hover:text-purple-300">
                                    <?php echo $details; ?>
                                </div>
                            </div>
                            <div class="text-white col-span-2 @3xl:hidden [&_summary]:text-base [&_.accordion-content-inner]:text-lg [&_.accordion-content-inner]:ml-10 [&_.accordion-content-inner]:relative  [&_.accordion-content-inner]:before:content-[''] [&_.accordion-content-inner]:before:absolute [&_.accordion-content_inner]:before:top-0 [&_.accordion-content-inner]:before:-left-4 [&_.accordion-content-inner]:before:w-0.5 [&_.accordion-content-inner]:before:h-full [&_.accordion-content-inner]:before:bg-purple-400 [&_.accordion-content-inner]:opacity-0 [&:has(details[data-state=open])]:[&_.accordion-content-inner]:opacity-100 [&_.accordion-content-inner]:transition-opacity [&_.accordion-content-inner]:duration-300 [&_a]:text-white!">
                                <?php
                                    echo do_blocks('<!-- wp:acf/accordion {"name":"acf/accordion","data":{"title":"' . esc_attr($title) . '"},"mode":"preview"} -->' .'<!-- wp:html --><div class="accordion-content-inner">' . $details . '</div><!-- /wp:html -->' .'<!-- /wp:acf/accordion -->');
                                ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
            <div class="col-span-2 @3xl:col-span-1">
                <div class="mx-auto @3xl:max-w-[560px]">
                    <?php if ($form_section_heading): ?>
                        <p class="text-[20px] @2xl:text-[22px] font-bold text-white mb-4 @3xl:mb-12"><?php echo $form_section_heading; ?></p>
                    <?php endif; ?>
                    <div>
                        <?php if ($form_embed): ?>
                            <?php echo $form_embed; ?>
                        <?php endif; ?>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>