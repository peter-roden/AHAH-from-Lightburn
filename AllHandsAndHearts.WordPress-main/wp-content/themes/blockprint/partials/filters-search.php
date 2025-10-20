<?php
$placeholder = $args['placeholder'] ?? 'Search';
$value = $args['value'] ?? '';
?>

<div class="relative flex h-10 w-full border rounded-full focus-within:outline-1 focus-within:outline-[initial] js-filters__search">
    <input class="h-full grow pl-6 focus:outline-0 placeholder:text-current js-filters__search-input focus:border-0 border-b-0" type="search" name="search" value="<?php echo $value ?>" placeholder="<?php echo $placeholder ?>" aria-label="<?php echo $placeholder ?>" autocomplete="off">
    <div class="flex items-center justify-center pl-2 pr-5 rounded-full">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M7.33333 12.6667C10.2789 12.6667 12.6667 10.2789 12.6667 7.33333C12.6667 4.38781 10.2789 2 7.33333 2C4.38781 2 2 4.38781 2 7.33333C2 10.2789 4.38781 12.6667 7.33333 12.6667Z" stroke="#120445" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M14.0006 14.0001L11.1006 11.1001" stroke="#120445" stroke-width="1.33333" stroke-linecap="square" stroke-linejoin="round"/>
        </svg>
    </div>
    <div class="absolute top-full left-0 z-10 w-full h-fit max-h-91.25 mt-2 bg-white overflow-auto border border-b-0 empty:hidden js-filters__search-suggestions"></div>
</div>