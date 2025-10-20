<?php
$class_name = $args['class_name'] ?? '';
$link = $args['link'] ?? [];
$link_title = $link['title'] ?? 'CTA Link';
$link_url = $link['url'] ?? '#';
$link_target = $link['target'] ?? null;
$mode = $args['mode'] ?? 'light';
$arrow_position = $args['arrow_position'] ?? 'end';
?>

<a class="group/cta-link inline-flex items-center gap-x-2 leading-[1.2] no-underline! text-current! <?php echo esc_attr($class_name) ?>" href="<?php echo $link_url ?>"<?php echo $link_target === '_blank' ? ' target="_blank" rel="noopener noreferrer"' : '' ?>>
    <span class="grow<?php echo $mode === 'light' ? ' opacity-80' : '' ?>"><?php echo $link_title ?></span>
    <span class="shrink-0 w-4 overflow-hidden<?php echo $arrow_position === 'start' ? ' -order-1' : '' ?>">
        <span class="flex -translate-x-full group-hover/cta-link:translate-x-0 transition-transform">
            <svg class="shrink-0<?php echo $mode === 'light' ? ' text-purple-500' : '' ?>" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path d="M1.832 8H13.004" stroke="currentColor" stroke-width="1.5" stroke-linecap="square" stroke-linejoin="round"/>
                <path d="M8.867 3.035L13.833 8.001 8.867 12.966" stroke="currentColor" stroke-width="1.5" stroke-linecap="square"/>
            </svg>
            <svg class="shrink-0<?php echo $mode === 'light' ? ' opacity-80' : '' ?>" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path d="M1.832 8H13.004" stroke="currentColor" stroke-width="1.5" stroke-linecap="square" stroke-linejoin="round"/>
                <path d="M8.867 3.035L13.833 8.001 8.867 12.966" stroke="currentColor" stroke-width="1.5" stroke-linecap="square"/>
            </svg>
        </span>
    </span>
</a>