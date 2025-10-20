<?php
/**
 * Featured Blog Post Block
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

$class_name = build_block_class_name( 'group/card @container relative z-0', $block );

$style = build_block_styles( $block );

$post = get_field('post') ?: get_posts([
    'numberposts' => 1,
    'post_status' => 'publish'
])[0];

$image_aspect_ratio = get_field('image_aspect_ratio') ?: 'var(--card-image-aspect-ratio)';
$show_date = get_field('show_date');
$show_category = get_field('show_category');
$show_excerpt = get_field('show_excerpt');
$show_author_name = get_field('show_author_name');

$post_title = '';
$post_permalink = '';
$post_excerpt = '';
$news_source_logo = '';
$has_external_link = false;

if ($post) {
    $post_title = $post->post_title;
    $post_id = $post->ID;
    $post_permalink = get_permalink($post_id);
    $post_excerpt = get_the_excerpt($post_id);
    $news_sources = wp_get_post_terms($post_id, 'news-source');
    $has_external_link = !empty(get_field('external_link', $post_id));
    
    if ($news_sources) {
        $news_source = $news_sources[0];
        $news_source_logo = get_field('logo', $news_source);
    }
}
?>

<div id="<?php echo esc_attr($anchor) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr($style) . '"' : '' ?>>
    <div class="grid @xl:grid-cols-12 gap-x-6">
        <figure class="relative -z-1 @xl:col-span-8 bg-neutral-100 aspect-(--aspect-ratio) size-full overflow-hidden" style="--aspect-ratio:<?php echo $image_aspect_ratio ?>">
            <?php if (has_post_thumbnail($post_id)) : ?>
                <?php echo get_the_post_thumbnail($post_id, 'medium_large', [
                    'loading' => 'lazy',
                    'class' => 'size-full object-cover group-hover/card:scale-103 transition-transform duration-300'
                ]) ?>
            <?php endif ?>
        </figure>

        <div class="flex flex-col gap-y-3 @xl:col-span-4 @7xl:pl-6 pt-6">
            <div class="flex flex-row-reverse @xl:flex-col items-start justify-end gap-3">
                <?php if ( has_tag('video', $post_id) ) : ?>
                    <span class="flex items-center justify-center text-center bg-green-100 text-green-950 rounded-full text-sm uppercase tracking-[.03em] leading-[1.2] font-extrabold shrink-0 px-3 py-1 min-h-7">
                        Video
                    </span>
                <?php endif ?>

                <h3 class="text-xl @xs:text-1.5xl font-bold mb-0 grow">
                    <a class="<?php echo esc_attr('text-current hover:text-purple-500 no-underline! transition-colors duration-300 ' . ($is_preview ? '' : 'after:absolute after:inset-0')) ?>" href="<?php echo $post_permalink ?>"<?php echo $has_external_link ? ' target="_blank" rel="noopener noreferrer"' : '' ?>>
                        <?php echo $post_title ?>
                    </a>
                </h3>
            </div>

            <?php if ( $news_source_logo ) : ?>
                <div class="flex items-center justify-start gap-4">
                    <?php
                        echo wp_get_attachment_image( $news_source_logo['id'], 'medium', false, [
                            'loading' => 'lazy',
                            'class' => 'size-fit max-w-60 max-h-12 object-contain object-left'
                        ] );
                    ?>
                    <?php if ($has_external_link) : ?>
                        <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M18.6338 6.62C18.5323 6.37565 18.3382 6.18147 18.0938 6.08C17.9736 6.02876 17.8445 6.00158 17.7138 6H7.71381C7.44859 6 7.19424 6.10536 7.0067 6.29289C6.81916 6.48043 6.71381 6.73478 6.71381 7C6.71381 7.26522 6.81916 7.51957 7.0067 7.70711C7.19424 7.89464 7.44859 8 7.71381 8H15.3038L7.00381 16.29C6.91008 16.383 6.83568 16.4936 6.78491 16.6154C6.73415 16.7373 6.70801 16.868 6.70801 17C6.70801 17.132 6.73415 17.2627 6.78491 17.3846C6.83568 17.5064 6.91008 17.617 7.00381 17.71C7.09677 17.8037 7.20737 17.8781 7.32923 17.9289C7.45109 17.9797 7.58179 18.0058 7.71381 18.0058C7.84582 18.0058 7.97652 17.9797 8.09838 17.9289C8.22024 17.8781 8.33084 17.8037 8.42381 17.71L16.7138 9.41V17C16.7138 17.2652 16.8192 17.5196 17.0067 17.7071C17.1942 17.8946 17.4486 18 17.7138 18C17.979 18 18.2334 17.8946 18.4209 17.7071C18.6084 17.5196 18.7138 17.2652 18.7138 17V7C18.7122 6.86932 18.685 6.74022 18.6338 6.62Z" fill="#8C52CE"/></svg>
                    <?php endif; ?>
                </div>
            <?php elseif ( $show_excerpt ) : ?>
                <p class="line-clamp-5 mb-0">
                    <?php echo $post_excerpt ?>
                </p>
            <?php endif ?>

            <?php if ( $show_date ) : ?>
                <time class="opacity-70" datetime="<?php echo get_the_date('c', $post_id) ?>">
                    <?php echo get_the_date('', $post_id) ?>
                </time>
            <?php endif ?>
        </div>
    </div>
</div>