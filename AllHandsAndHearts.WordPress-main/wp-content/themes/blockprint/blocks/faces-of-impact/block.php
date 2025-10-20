<?php
/**
 * Faces of Impact Block
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

$class_name = build_block_class_name( '@container overflow-hidden acf-block-faces-of-impact', $block );

$style = build_block_styles( $block );

$heading = get_field('heading');
$featured_video = get_field('featured_video');
$featured_video_placeholder = get_field('featured_video_placeholder');
$featured_video_heading = get_field('featured_video_heading');
$cards = get_field('cards');
?>

<div id="<?php echo esc_attr( $anchor ) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr( $style ) . '"' : '' ?>>
    <div class="container">
        <?php if ($heading) : ?>
            <h2 class="text-h4 text-center mb-10"><?php echo $heading; ?></h2>
        <?php endif; ?>
        <?php if ($featured_video): ?>
            <div class="relative size-full">
                <?php echo wp_get_attachment_image($featured_video_placeholder, '1920', false, [ 'class' => 'size-full object-cover aspect-square lg:aspect-[21/9]', 'loading'=>'lazy' ]); ?>
                <div class="absolute bottom-6 left-6 @6xl:bottom-10 @6xl:left-10">
                    <?php if ($featured_video_heading): ?>
                        <h3 class="text-white text-h4 mb-4 drop-shadow-lg"><?php echo $featured_video_heading; ?></h3>
                    <?php endif; ?>
                    <div class="wp-block-button is-style-secondary">
                        <a href="<?php echo '#' . $anchor . '-video-modal'; ?>" class="wp-block-button__link has-sm-font-size has-custom-font-size wp-element-button rounded-full! hover:bg-white/70! gap-x-1! data-[state=hidden]:hidden!" >
                            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor" aria-hidden="true">
                                <polygon points="5 3 19 12 5 21 5 3"/>
                            </svg>
                            Play <span class="sr-only">video</span>
                        </a>
                    </div>
                </div>
            </div>
            <?php get_template_part('partials/modal', null, [
                'id' => $anchor . '-video-modal',
                'is_preview' => $is_preview,
                'bg_color' => 'bg-transparent',
                'html' => $featured_video
            ] ); ?>
        <?php endif; ?>
        <?php if ($cards): ?>
            <div class="w-full mt-5 lg:mt-8">
                <div class="swiper js-swiper" data-options='{
                    "allowTouchMove": true,
                    "spaceBetween": 32,
                    "navigation": {
                        "nextEl": ".swiper-button-next",
                        "prevEl": ".swiper-button-prev"
                    },
                    "pagination": {
                        "el": ".swiper-pagination",
                        "bulletElement": "button",
                            "clickable": true
                    },
                    "breakpointsBase": "container",
                    "breakpoints": {
                        "576": {
                            "slidesPerView": 2,
                            "slidesPerGroup": 2
                        },
                        "896": {
                            "slidesPerView": 3,
                            "slidesPerGroup": 3
                        },
                    }
                }'>
                    <div class="swiper-wrapper">
                        <?php $card_index = 0; ?>
                        <?php foreach($cards as $id): ?>
                            <?php 
                                $title = get_the_title($id);
                                $image = get_field('image', $id);
                                $summary_heading = get_field('summary_heading', $id);
                                $summary_text = get_field('summary_text', $id);
                                $location = get_field('location', $id);
                                $link = get_field('link', $id);
                            ?>
                            <div class="group swiper-slide swiper-slide h-auto">
                                <div class="js-faces-of-impact-card relative size-full min-h-[581px]">
                                    <?php if ($title): ?>
                                        <div class="absolute left-6 lg:left-8 bottom-6 lg:bottom-7 flex items-center">
                                            <p class="text-white text-h4 drop-shadow-lg"><?php echo $title; ?></p>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($image): ?>
                                        <?php echo wp_get_attachment_image($image, 'large', false, [ 'class' => 'size-full object-cover' ]); ?>
                                    <?php endif; ?>
                                    <div 
                                        id="card-overlay-<?php echo $card_index; ?>"
                                        role="region"
                                        aria-labelledby="toggle-overlay-btn-<?php echo $card_index; ?>"
                                        class="acf-block-faces-of-impact__content js-faces-of-impact-card__content absolute opacity-0 [&.is-open]:opacity-100 lg:group-hover:opacity-100 transition-opacity duration-500 ease-in-out flex flex-col justify-center top-0 left-0 size-full bg-purple-700 text-white p-6"
                                    >
                                        <p class="font-bold text-h6 mb-0"><?php echo $summary_heading; ?></p>
                                        <?php if ($summary_text): ?>
                                            <p class="mb-0 mt-2"><?php echo $summary_text; ?></p>
                                        <?php endif; ?>
                                        <?php if ($location): ?>
                                            <p class="font-bold mb-0 mt-2"><?php echo $location; ?></p>
                                        <?php endif; ?>
                                        <?php if ($link): ?>
                                            <div class="mt-8 [&_span]:opacity-100">
                                                <?php 
                                                    get_template_part('partials/cta-link', null, [
                                                        'class_name' => 'text-white',
                                                        'link' => $link,
                                                        'mode' => 'dark',
                                                        'arrow_position' => 'end'
                                                    ]); 
                                                ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <?php get_template_part('partials/open-close-btn', null, [
                                        'id' => 'toggle-overlay-btn-' . $card_index,
                                        'class_name' => 'js-faces-of-impact-card__content-toggle absolute right-6 lg:right-8 bottom-6 lg:bottom-7 lg:hidden text-white'
                                    ] ); ?>
                                </div>
                            </div>
                            <?php $card_index++; ?>
                        <?php endforeach; ?>
                    </div>
                    <?php get_template_part('partials/swiper-controls', null, [
                        'class_name' => 'mt-10 ml-7 @2xl:ml-10 @6xl:ml-16 2xl:ml-0!'
                    ] ); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>