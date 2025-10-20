<?php
    $id = $args['id'] ?? '';
    $heading = $id ? get_field('heading', $id) : '';
    $description = $id ? get_field('description', $id) : '';
    $details = $id ? get_field('details', $id) : '';
    $link = $id ? get_field('link', $id) : false;

    $anchor = 'stat-card-' . $id;
    $class_name = 'group relative overflow-hidden h-full min-h-[230px] [&.is-open]:h-[336px] transition-[height] md:min-h-[336px] border border-purple-950 transition-colors duration-350';

    if ( $details ) {
        $class_name .= ' hover:bg-purple-950 hover:text-white [.is-open]:bg-purple-950 [.is-open]:text-white cursor-pointer js-stat-card';
    }
?>

<div id="<?php echo esc_attr($anchor); ?>" class="<?php echo esc_attr($class_name) ?>">
    <div class="size-full p-8 md:p-10 group-[.is-open]:opacity-0 transition-opacity duration-350">
        <?php if ( $heading ) : ?>
            <div class="text-display-2 break-all font-bold mb-4">
                <?php echo $heading; ?>
            </div>
        <?php endif; ?>

        <?php if ( $description ) : ?>
            <div class="text-lg md:text-xl font-semibold">
                <?php echo $description; ?>
            </div>
        <?php endif; ?>
    </div>

    <?php if ( $details ) : ?>
        <?php get_template_part('partials/open-close-btn', null, [
            'class_name' => 'border-none absolute right-6 md:right-8 bottom-6 md:bottom-8 js-stat-card__overlay-toggle'
        ]); ?>

        <div id="<?php echo esc_attr($anchor); ?>__overlay" class="absolute top-100 left-0 size-full group-[.is-open]:top-0 overflow-auto p-10 opacity-0 group-[.is-open]:opacity-100 invisible group-[.is-open]:visible transition-all duration-350 [scrollbar-width:thin] [scrollbar-color:rgba(255,255,255,.5)_transparent] js-stat-card__overlay">
            <?php if ( $details ) : ?>
                <p><?php echo $details; ?></p>
            <?php endif; ?>

            <?php if ( $link ) : ?>
                <p>
                    <?php get_template_part('partials/cta-link', null, [
                        'link' => $link,
                        'mode' => 'dark'
                    ]); ?>
                </p>
            <?php endif; ?>
        </div>
    <?php endif ?>
</div>