<?php
/**
 * Modal
 */

$id = $args['id'] ?? '';
$is_preview = $args['is_preview'] ?? false;
$class_name = $args['class_name'] ?? '';
$show_close_button = $args['show_close_button'] ?? true;
$bg_color = $args['bg_color'] ?? 'bg-white';
$html = $args['html'] ?? '';

if ( !$is_preview ) {
    $class_name .= ' fixed top-[var(--wp-admin--admin-bar--height,0px)] left-0 z-999 collapse';
}

$class_name .= ' flex items-center justify-center size-full overflow-auto js-modal';
$class_name = trim($class_name);
?>

<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($class_name); ?>">
    <div class="absolute inset-0 -z-1 bg-black/70 js-modal-close"></div>

    <div class="container-wide relative flex flex-col items-end w-full h-auto <?php echo $bg_color; ?>">
        <?php if ( $show_close_button ) : ?>
            <button type="button" class="bg-white text-purple-950 rounded-full mb-8 size-10 flex items-center justify-center cursor-pointer js-modal-close lg:-mr-5" aria-label="close">
                <svg class="text-purple-950" width="34" height="34" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M21.9492 12.0498L12.0497 21.9493" stroke="currentColor" stroke-width="2" stroke-linecap="square" stroke-linejoin="round" />
                    <path d="M12.0508 12.0498L21.9503 21.9493" stroke="currentColor" stroke-width="2" stroke-linecap="square" stroke-linejoin="round" />
                </svg>
            </button>
        <?php endif ?>

        <?php if ( $html ) : ?>
            <div class="size-full overflow-auto [&_iframe]:size-full [&_iframe]:aspect-video">
                <?php echo $html; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

