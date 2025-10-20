<?php
$name = $args['name'] ?? '';
$label = $args['label'] ?? '';
$type = $args['type'] ?? 'date';
$prefix = $args['prefix'] ?? '';
?>

<div class="group relative z-0 border-b last:border-b-0 @4xl:border-b-0 js-filters__date" data-active="false">
    <input type="<?php echo $type ?>" class="absolute size-full -z-1 focus:outline-0 px-6" name="<?php echo $name ?>" aria-label="<?php echo $label ?>" min="2000-01" tabindex="-1">
    <button type="button" class="flex h-10 w-full @4xl:w-auto @4xl:min-w-48 cursor-pointer items-center justify-between gap-x-2 bg-white pl-6 pr-5 text-left @4xl:border @4xl:last:border-b-1 @4xl:rounded-full group-data-[active=true]:bg-purple-950 group-data-[active=true]:text-white transition-colors" data-label="<?php echo $label ?>" data-prefix="<?php echo $prefix ?>">
        <span><?php echo $label ?></span>
        <svg class="shrink-0" width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
            <path d="M4 6L8 10L12 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="square" />
        </svg>
    </button>
</div>