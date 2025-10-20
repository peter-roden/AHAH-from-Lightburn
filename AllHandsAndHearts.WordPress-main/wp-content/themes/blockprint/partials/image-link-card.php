<?php
$class_name = $args['class_name'] ?? '';
$border_radius = $args['border_radius'];
$border_radius = $border_radius ? $border_radius / 16 . 'rem' : 'var(--default-border-radius)';
$image = $args['image'] ?? [];
$link = $args['link'] ?? [];
?>

<div class="group/card flex flex-col justify-end relative z-0 bg-neutral-100 overflow-hidden aspect-square size-full rounded-(--border-radius) <?php echo esc_attr($class_name) ?>" style="--border-radius:<?php echo $border_radius ?>">
    <?php if ( $image ) : ?>
        <?php echo wp_get_attachment_image( $image['id'], 'large', false, [
            'loading' => 'lazy',
            'class' => 'absolute -z-1 top-0 left-0 size-full object-cover group-hover/card:scale-110 transition-transform duration-500'
        ] ); ?>
    <?php endif ?>    
    <div class="absolute top-0 left-0 size-full -z-1 bg-gradient-to-b from-transparent from-75% to-black opacity-0 group-has-[a:hover]/card:opacity-25 transition-opacity"></div>
    <div class="bg-gradient-to-b from-transparent to-black/75 p-[clamp(1.5rem,2.5vw,2rem)]">
        <?php if ( $link ) : ?>
            <a class="block text-h4 no-underline! font-bold w-full text-white! after:content-[''] after:absolute after:inset-0 mb-0" href="<?php echo $link['url'] ?>" target="<?php echo $link['target'] ?: '_self' ?>">
                <?php echo $link['title'] ?>
            </a>
        <?php endif ?>
    </div>
</div>