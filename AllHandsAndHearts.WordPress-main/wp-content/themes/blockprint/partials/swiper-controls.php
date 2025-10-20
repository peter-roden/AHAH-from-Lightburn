<?php
$class_name = $args['class_name'] ?? '';
$hide_pagination = $args['hide_pagination'] ?? false;
$hide_navigation = $args['hide_navigation'] ?? false;

$pagination_class_name = "swiper-pagination flex flex-wrap justify-center gap-2 [&_.swiper-pagination-bullet]:size-2 [&_.swiper-pagination-bullet]:rounded-lg [&_.swiper-pagination-bullet]:bg-purple-950/50 [&_.swiper-pagination-bullet]:cursor-pointer [&_.swiper-pagination-bullet-active]:bg-purple-950 [&_.swiper-pagination-bullet]:transition-colors";
$btn_class_name = "text-purple-950/50 not-disabled:hover:text-purple-950 not-disabled:cursor-pointer transition-colors shrink-0";
$prev_btn_class_name = 'swiper-button-prev ' . $btn_class_name . ' ' . ($args['prev_btn_class_name'] ?? '');
$next_btn_class_name = 'swiper-button-next ' . $btn_class_name . ' ' . ($args['next_btn_class_name'] ?? '');
?>

<div class="<?php echo esc_attr('flex items-center justify-center gap-6 has-[.swiper-button-lock]:hidden' . ($class_name ? ' ' . $class_name : '')) ?>">
    <?php if ( !$hide_pagination ) : ?>
        <button class="<?php echo trim(esc_attr($prev_btn_class_name)) ?>">
            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <polyline points="15 18 9 12 15 6"></polyline>
            </svg>
        </button>
    <?php endif ?>

    <?php if ( !$hide_navigation ) : ?>
        <div class="<?php echo trim(esc_attr($pagination_class_name)) ?>"></div>
    <?php endif ?>

    <?php if ( !$hide_pagination ) : ?>
        <button class="<?php echo trim(esc_attr($next_btn_class_name)) ?>">
            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
        </button>
    <?php endif ?>
</div>