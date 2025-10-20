<?php
$class_name = $args['class_name'] ?? '';
$id = $args['id'] ?? '';
?>

<button
    <?php if ($id): ?>id="<?php echo esc_attr($id); ?>"<?php endif; ?>
    class="cursor-pointer flex items-center p-2 border border-current rounded-full [&.is-active]:border-none [&.is-active_svg]:rotate-45 <?php echo esc_attr($class_name); ?>"
    type="button"
    aria-label="Toggle card content"
    aria-expanded="false"
>
    <svg class="transition-transform duration-300" width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true">
        <path d="M12 5V19" stroke="currentColor" stroke-width="2" stroke-linecap="square" stroke-linejoin="round"/>
        <path d="M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="square" stroke-linejoin="round"/>
    </svg>
</button>