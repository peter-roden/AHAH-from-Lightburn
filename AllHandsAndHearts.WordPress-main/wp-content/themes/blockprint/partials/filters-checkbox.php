<?php
$label = $args['label'] ?? 'Search';
$name = $args['name'] ?? '';
$value = $args['value'] ?? '';
$id = $args['id'] ?? $name . '_' . $value;
$checked = $args['checked'] ?? false;
?>

<label class="relative flex h-10 w-full cursor-pointer items-center justify-between gap-x-2 px-6 border-b last:border-b-0 transition-colors focus-within:outline-1 focus-within:outline-[initial] @4xl:data-[active=true]:bg-purple-950 @4xl:data-[active=true]:text-white @4xl:w-auto @4xl:min-w-48 @4xl:border @4xl:last:border-b-1 @4xl:rounded-full js-filters__checkbox" for="<?php echo $id ?>" data-active="<?php echo $checked ? 'true' : 'false' ?>">
    <?php echo $label ?>
    <input class="peer absolute opacity-0" type="checkbox" name="<?php echo $name ?>" data-name="<?php echo $name ?>" id="<?php echo $id ?>" value="<?php echo $value ?>"<?php echo $checked ? ' checked' : '' ?>>
    <svg class="block peer-checked:hidden @4xl:hidden!" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <path d="M12.25 0.25H1.75C0.9175 0.25 0.25 0.9175 0.25 1.75V12.25C0.25 12.6478 0.408035 13.0294 0.68934 13.3107C0.970644 13.592 1.35218 13.75 1.75 13.75H12.25C12.6478 13.75 13.0294 13.592 13.3107 13.3107C13.592 13.0294 13.75 12.6478 13.75 12.25V1.75C13.75 1.35218 13.592 0.970644 13.3107 0.68934C13.0294 0.408035 12.6478 0.25 12.25 0.25ZM12.25 1.75V12.25H1.75V1.75H12.25Z" fill="currentColor"/>
    </svg>
    <svg class="hidden peer-checked:block @4xl:hidden!" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <path d="M5.5 10.75L1.75 7L2.8075 5.935L5.5 8.6275L11.1925 2.935L12.25 4M12.25 0.25H1.75C0.9175 0.25 0.25 0.9175 0.25 1.75V12.25C0.25 12.6478 0.408035 13.0294 0.68934 13.3107C0.970644 13.592 1.35218 13.75 1.75 13.75H12.25C12.6478 13.75 13.0294 13.592 13.3107 13.3107C13.592 13.0294 13.75 12.6478 13.75 12.25V1.75C13.75 1.35218 13.592 0.970644 13.3107 0.68934C13.0294 0.408035 12.6478 0.25 12.25 0.25Z" fill="currentColor"/>
    </svg>
</label>