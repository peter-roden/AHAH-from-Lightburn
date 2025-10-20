<?php
$name = $args['name'] ?? '';
$label = $args['label'] ?? '';
$options = $args['options'] ?? [];
$selected_value = $args['selected_value'] ?? '';
$active = !empty($selected_value);
?>

<div class="relative h-10 w-full @4xl:w-48 border-b last:border-b-0 @4xl:border @4xl:last:border-b-1 @4xl:rounded-full data-[active=true]:bg-purple-950 data-[active=true]:text-white transition-colors js-filters__filter" data-active="<?php echo $active ? 'true' : 'false' ?>">
    <select class="<?php echo esc_attr('appearance-none size-full pl-6 pr-12 cursor-pointer rounded-[inherit]') ?>" name="<?php echo esc_attr($name) ?>" aria-label="<?php echo esc_attr($label) ?>">
        <option class="text-purple-950 bg-white" value=""><?php echo esc_html($label) ?></option>
        <?php foreach ($options as $value => $option_label): ?>
            <option class="text-purple-950 bg-white" value="<?php echo esc_attr($value) ?>"<?php echo $selected_value == $value ? ' selected' : '' ?>>
                <?php echo esc_html($option_label) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <svg class="absolute top-1/2 right-5 -translate-y-1/2 pointer-events-none" width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
        <path d="M4 6L8 10L12 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="square" />
    </svg>
</div>