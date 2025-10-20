<?php
/**
 * Stat List Block
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

$class_name = build_block_class_name( '@container text-center py-12 mt-0', $block );

$style = build_block_styles( $block );

$stats = get_field('stats');
$stat_value_color = get_field('stat_value_color');
$show_dividers = get_field('show_dividers');

$stat_count = is_array($stats) ? count($stats) : 0;

$container_class_name = 'grid gap-x-6 gap-y-14';
if ($is_preview && !have_rows('stats')) {
    $container_class_name .= ' @lg:grid-cols-4 opacity-50';
} else {
    switch ($stat_count) {
        case 2:
            $container_class_name .= ' @lg:grid-cols-2';
            break;
        case 3:
            $container_class_name .= ' @lg:grid-cols-3';
            break;
        case 4:
            $container_class_name .= ' @lg:grid-cols-4';
            break;
        case 5:
            $container_class_name .= ' @xl:grid-cols-5';
            break;
    }
}

if ($block['align'] === 'full') {
    if ($stat_count >= 4 || $is_preview) {
        $container_class_name .= ' container-wide';
    } else {
        $container_class_name .= ' container';
    }
} else {
    $class_name .= ' px-6';
}

$stat_class_name = 'relative flex flex-col gap-y-2';
$stat_value_class_name = 'text-display-2 text-purple-500 break-all font-bold mb-0';
$stat_caption_class_name = 'max-w-[170px] mx-auto';

$placeholder_stats = [
    [
        'value' => '250',
        'caption' => 'Non aliqua nostrud nisi aute laboris'
    ],
    [
        'value' => '$1.2M',
        'caption' => 'Adipisicing ipsum veniam magna'
    ],
    [
        'value' => '20',
        'caption' => 'Irure aliquip irure mollit incididunt'
    ],
    [
        'value' => '800k',
        'caption' => 'Dolore mollit laborum magnar'
    ]
];
?>

<?php if ( have_rows('stats') || $is_preview ) : ?>
    <div id="<?php echo esc_attr( $anchor ) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr( $style ) . '"' : '' ?>>
        <div class="<?php echo esc_attr( $container_class_name ) ?>">
            <?php if ( have_rows('stats') ) : ?>
                <?php while ( have_rows('stats') ) : the_row(); ?>
                    <?php $index = get_row_index(); ?>
                    <div class="<?php echo esc_attr($stat_class_name) ?>">
                        <span class="<?php echo esc_attr( $stat_value_class_name ) ?>"<?php echo $stat_value_color ? ' style="color:' . $stat_value_color . '"' : '' ?>>
                            <?php the_sub_field('value') ?>
                        </span>
                        <span class="<?php echo esc_attr( $stat_caption_class_name ) ?>">
                            <?php the_sub_field('caption') ?>
                        </span>
                        <?php if ( $show_dividers ) {
                            $divider_class_name = 'absolute top-0 left-full h-full border-r ml-3 opacity-20 hidden @lg:block';
                            $show_divider = (
                                ($stat_count === 2 && $index === 1) ||
                                ($stat_count === 3 && $index % 3 !== 0) ||
                                ($stat_count === 5 && $index % 5 !== 0) ||
                                ($stat_count === 4 && $stat_count !== 5 && $index % 4 !== 0)
                            );

                            if ( $show_divider ) {
                                echo '<div class="' . esc_attr( $divider_class_name ) . '"></div>';
                            }
                        } ?>
                    </div>
                <?php endwhile ?>
            <?php elseif ( $is_preview) : ?>
                <?php foreach ( $placeholder_stats as $stat ) : ?>
                    <div class="<?php echo esc_attr($stat_class_name) ?>">
                        <span class="<?php echo esc_attr( $stat_value_class_name ) ?>">
                            <?php echo $stat['value'] ?>
                        </span>
                        <span class="<?php echo esc_attr( $stat_caption_class_name ) ?>">
                            <?php echo $stat['caption'] ?>
                        </span>
                    </div>
                <?php endforeach ?>
            <?php endif ?>
        </div>
    </div>
<?php endif ?>