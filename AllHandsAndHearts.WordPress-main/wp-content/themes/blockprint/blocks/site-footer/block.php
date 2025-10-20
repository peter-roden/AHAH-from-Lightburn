<?php
/**
 * Site Footer Block
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

$class_name = build_block_class_name( '@container bg-purple-950 text-center md:text-left pt-20 pb-6', $block );

$logo_image = get_field('logo_image');
$logo_width = get_field('logo_width');
$heading = get_field('heading');
$content = get_field('content');
$award_logos = get_field('award_logos');
$button_link = get_field('button_link');
$copyright = get_field('copyright') ?: '&copy; $year $site_title. All rights reserved.';
$copyright = strtr($copyright, [
    '$year' => date('Y'),
    '$site_title' => get_bloginfo('name')
]);
$footer_cta = get_field('footer_cta',$post_id);
?>
<?php if ($footer_cta): ?> 
    <?php 
        $form_heading = get_field('form_heading');
        $form_embed = get_field('form_embed');
    ?>
    <div class="container-wide">
        <div class="flex flex-col md:flex-row py-12 gap-y-4">
            <?php if ($form_heading): ?>
                <div class="w-full md:w-1/2">
                    <h2 class="text-purple-950 text-balance text-h3 max-w-100 mr-auto">
                        <?php echo $form_heading; ?>
                    </h2>
                </div>
            <?php endif; ?>
            <?php if ($form_embed): ?>
                <div class="w-full md:w-1/2">
                    <div class="flex md:justify-center overflow-hidden">
                        <?php echo $form_embed; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>
<div id="<?php echo esc_attr( $anchor ); ?>" class="<?php echo trim( esc_attr( $class_name ) ); ?>">
    <div class="container-wide">
        <div class="@6xl:grid grid-cols-12 gap-4">
            <div class="@6xl:col-span-6">
                <div class="max-w-126">
                    <?php if ( $heading ) : ?>
                        <p class="text-white font-bold text-left">
                            <?php echo $heading; ?>
                        </p>
                    <?php endif; ?> 
                    <?php if ( $content ) : ?>
                        <div class="text-white text-left">
                            <?php echo $content; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="@6xl:col-span-6 mt-8">
                <div class="flex flex-row gap-4 justify-content-between w-full">
                    <div class="flex-1 flex-col hidden sm:flex sm:flex-row lg:mr-16 xl:mr-auto gap-4">
                        <?php 
                            $menu_1 = wp_get_nav_menu_items( get_nav_menu_locations()['footer-1'] ?? '' );
                            $menu_2 = wp_get_nav_menu_items( get_nav_menu_locations()['footer-2'] ?? '' );
                            $merged_items = array_merge( $menu_1 ?: [], $menu_2 ?: [] );
                        ?>
                        <?php if ($menu_1): ?>
                            <ul class="min-w-[190px] flex-1 mt-0 mb-auto list-none pl-0 flex flex-col flex-wrap justify-start items-start gap-6 font-bold text-sm [&_a]:text-white [&_a]:hover:text-white [&_a]:no-underline [&_a:hover]:underline">
                                <?php foreach ( $menu_1 as $item ) : ?>
                                    <li>
                                        <?php
                                            $target = $item->target === '_blank' ? ' target="_blank" rel="noopener noreferrer"' : '';
                                        ?>
                                        <a href="<?php echo esc_url( $item->url ); ?>" class="flex items-center text-start"<?php echo $target; ?>>
                                            <?php echo $item->title; ?>
                                            <?php if ( $item->target === '_blank' ) : ?>
                                                <svg class="ml-1" height="16" width="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M4.66602 11.3337L11.3327 4.66699M11.3327 4.66699H4.66602M11.3327 4.66699V11.3337" stroke="white" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            <?php endif; ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>

                        <?php if ($menu_2): ?>
                            <ul class="min-w-[190px] flex-1 mt-0 mb-auto list-none pl-0 flex flex-col flex-wrap justify-start items-start gap-6 font-bold text-sm [&_a]:text-white [&_a]:hover:text-white [&_a]:no-underline [&_a:hover]:underline">
                                <?php foreach ( $menu_2 as $item ) : ?>
                                    <li>
                                        <?php
                                            $target = $item->target === '_blank' ? ' target="_blank" rel="noopener noreferrer"' : '';
                                        ?>
                                        <a href="<?php echo esc_url( $item->url ); ?>" class="flex items-center text-start"<?php echo $target; ?>>
                                            <?php echo $item->title; ?>
                                            <?php if ( $item->target === '_blank' ) : ?>
                                                <svg class="ml-1" height="16" width="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M4.66602 11.3337L11.3327 4.66699M11.3327 4.66699H4.66602M11.3327 4.66699V11.3337" stroke="white" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            <?php endif; ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>

                    <div class="flex flex-col sm:hidden">
                        <?php if ( $merged_items ) : ?>
                            <ul class="list-none pl-0 flex flex-col gap-6 font-bold text-sm [&_a]:text-white [&_a]:hover:text-white [&_a]:no-underline [&_a:hover]:underline">
                                <?php foreach ( $merged_items as $item ) : ?>
                                    <li>
                                        <?php
                                            $target = $item->target === '_blank' ? ' target="_blank" rel="noopener noreferrer"' : '';
                                        ?>
                                        <a href="<?php echo esc_url( $item->url ); ?>" class="flex items-center text-start"<?php echo $target; ?>>
                                            <?php echo $item->title; ?>
                                            <?php if ( $item->target === '_blank' ) : ?>
                                                <svg class="ml-1" height="16" width="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M4.66602 11.3337L11.3327 4.66699M11.3327 4.66699H4.66602M11.3327 4.66699V11.3337" stroke="white" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            <?php endif; ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                    <?php if ($award_logos) : ?>
                        <div class="flex-1 flex justify-end">
                            <?php foreach ($award_logos as $id) : ?>
                                <?php
                                    echo wp_get_attachment_image( $id, 'medium', false, [
                                        'loading' => 'lazy',
                                        'class' => 'size-24',
                                    ] );
                                ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="@container mt-14 md:mt-16">
            <?php if ( have_rows('social_media_links', 'option') ) : ?>
                <div class="grid grid-cols-3 place-items-center @sm:flex flex-wrap gap-3.5 @md:gap-6 items-center justify-center w-full">
                    <?php while ( have_rows('social_media_links', 'option') ) :
                        the_row();
                        $link = get_sub_field('link');
                        $svg_code = get_sub_field('svg_code');
                    ?>
                        <a aria-label="<?php echo $link['title'] ?> (opens in new tab)" class="flex items-center justify-center size-12 p-2 rounded-full bg-white text-purple-950 hover:text-purple-500 transition-colors [&_svg]:h-5.5 [&_svg]:w-auto" href="<?php echo $link['url'] ?>" target="_blank" rel="noopener noreferrer">
                            <?php echo $svg_code ?: $link['title']; ?>
                        </a>
                    <?php endwhile ?>
                </div>
            <?php endif ?>
        </div>

        <div class="mt-14 md:mt-16">
            <?php
                if ( $logo_image ) {
                    echo wp_get_attachment_image( $logo_image['id'], 'large', false, [
                        'loading' => 'lazy',
                        'class' => $logo_width ? 'w-(--width)' : 'w-full',
                        'style' => $logo_width ? '--width:' . $logo_width . 'px' : ''
                    ] );
                } else {
                    echo '<span class="block text-h3 font-bold">' . get_bloginfo( 'name' ) . '</span>';
                }
            ?>
        </div>

        <div class="flex flex-col md:flex-row w-full md:justify-between gap-4 text-xs border-t text-center pt-4 mt-10 md:mt-16">
            <div class="order-3 md:order-1">
                <p class="text-white"><?php echo $copyright ?></p>
            </div>

            <div class="order-1 md:order-2">
                <p class="text-white">501(c)(3) Tax ID #20-3414952</p>
            </div>

            <?php if ( has_nav_menu('legal') ) : ?>
                <div class="order-2 md:order-3">
                    <?php
                        wp_nav_menu([
                            'theme_location'    => 'legal',
                            'menu_id'           => 'menu-legal',
                            'menu_class'        => 'list-none pl-0 flex flex-wrap gap-x-4 justify-center [&_a]:text-white [&_a]:hover:text-white [&_a]:no-underline [&_a:hover]:underline',
                            'container'         => '',
                            'depth'             => 1
                        ]);
                    ?>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>