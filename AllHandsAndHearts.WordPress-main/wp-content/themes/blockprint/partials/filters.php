<?php
$filters = $args['filters'] ?? [];
$show_search = $args['show_search'] ?? false;
$search_placeholder = $args['search_placeholder'] ?? 'Search';
$search_value = $args['search_value'] ?? '';

$panel_id = wp_unique_id('filters-toggle-panel-');
?>

<form class="group/filters @container js-filters" style="--height:0" data-state="closed">
    <div class="@4xl:flex gap-x-6 gap-y-4 @4xl:py-6">
        <div class="relative shrink-0 my-2 @4xl:my-0">
            <button type="button" class="absolute top-0 left-0 flex items-center gap-1 h-10 w-full cursor-pointer text-nowrap font-medium aria-expanded:invisible aria-expanded:opacity-0 transition-[visibility,opacity] js-filters__toggle" aria-controls="<?php echo $panel_id ?>" aria-expanded="false">
                <svg class="shrink-0" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M17.1879 5H6.32727C5.71004 5 5.11809 5.24519 4.68164 5.68164C4.24519 6.11809 4 6.71004 4 7.32727V8.23491C3.99989 8.55525 4.06591 8.87217 4.19394 9.16582V9.21236C4.30354 9.46136 4.45878 9.68764 4.65164 9.87951L9.39882 14.5959C9.41897 14.6159 9.4303 14.6431 9.4303 14.6715C9.43028 16.7232 9.42869 18.775 9.43017 20.8267C9.43023 20.9061 9.51407 20.9576 9.58506 20.9219C11.0663 20.1766 12.5718 19.472 14.0291 18.6815C14.0635 18.6629 14.0848 18.6268 14.0848 18.5877C14.0831 17.2823 14.085 15.9768 14.0849 14.6713C14.0849 14.643 14.0961 14.6159 14.1161 14.5959L18.8325 9.87951C19.0253 9.68764 19.1806 9.46136 19.2902 9.21236V9.16582C19.4289 8.87447 19.5055 8.55745 19.5152 8.23491V7.32727C19.5152 6.71004 19.27 6.11809 18.8335 5.68164C18.3971 5.24519 17.8051 5 17.1879 5ZM12.567 13.9426C12.5455 13.9627 12.5333 13.9908 12.5332 14.0202C12.5303 15.2271 12.5332 16.4341 12.5333 17.641C12.5333 17.6814 12.5105 17.7183 12.4744 17.7364L11.1362 18.4055C11.0653 18.4409 10.9818 18.3894 10.9818 18.3101C10.9821 16.8801 10.9854 15.4501 10.9819 14.0202C10.9819 13.9908 10.9696 13.9627 10.9482 13.9426C9.47315 12.5592 8.07654 11.083 6.64533 9.65454H16.8698C15.4386 11.083 14.042 12.5592 12.567 13.9426ZM17.9636 8.10303H5.55152V7.32727C5.55152 7.12153 5.63325 6.92421 5.77873 6.77873C5.92421 6.63325 6.12153 6.55151 6.32727 6.55151H17.1879C17.3936 6.55151 17.5909 6.63325 17.7364 6.77873C17.8819 6.92421 17.9636 7.12153 17.9636 7.32727V8.10303Z" fill="currentColor"/>
                </svg>
                Show Filters
            </button>
            <button type="button" class="flex items-center gap-1 h-10 w-full cursor-pointer text-nowrap font-medium aria-expanded:invisible aria-expanded:opacity-0 transition-[visibility,opacity] js-filters__toggle" aria-controls="<?php echo $panel_id ?>" aria-expanded="true">
                <svg class="shrink-0" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M4 7.3322C4 6.71366 4.24571 6.12046 4.68309 5.68309L6.3322 6.5548C6.12602 6.5548 5.92829 6.63671 5.7825 6.7825C5.63671 6.92829 5.5548 7.12602 5.5548 7.3322V8.1096H8.66441L9.97518 9.66441H6.65094C8.0894 11.1002 9.54154 12.5235 10.9653 13.9739C10.9854 13.9944 10.9967 14.0219 10.9967 14.0506C11.0004 15.4782 10.9969 16.9057 10.9966 18.3332C10.9966 18.415 11.0827 18.4682 11.1558 18.4316L12.4906 17.7642C12.5279 17.7456 12.5514 17.7075 12.5514 17.6658C12.5513 16.4608 12.5482 15.2557 12.5513 14.0506C12.5514 14.0219 12.5627 13.9944 12.5828 13.9739C12.6315 13.9243 12.7251 13.829 12.7769 13.7769L14.1062 14.6475C14.1064 15.9703 14.1045 17.293 14.1061 18.6157C14.1062 18.6575 14.0832 18.6959 14.0463 18.7155C12.587 19.4912 11.0976 20.2198 9.60267 20.9243C9.52781 20.9596 9.44173 20.905 9.44166 20.8222C9.44008 18.7792 9.44178 16.7363 9.44181 14.6933C9.44181 14.664 9.43012 14.6359 9.40934 14.6153L4.65302 9.88985C4.45975 9.69757 4.30418 9.47081 4.19435 9.22129V9.17464C4.06605 8.88037 3.99989 8.56278 4 8.24176V7.3322Z" fill="currentColor"/>
                    <path d="M19.3226 9.22129C19.2128 9.47081 19.0572 9.69757 18.8639 9.88985L16.2811 12.4727C16.2369 12.5169 16.1651 12.5168 16.121 12.4723L15.1867 11.5308C15.1428 11.4866 15.143 11.4152 15.1871 11.3712L16.8971 9.66441H13.3469C13.3165 9.66441 13.2874 9.6522 13.2662 9.63055L11.9625 8.30173C11.8924 8.23024 11.943 8.1096 12.0432 8.1096H17.9932V7.3322C17.9932 7.12602 17.9113 6.92829 17.7655 6.7825C17.6197 6.63671 17.422 6.5548 17.2158 6.5548H10.2395C10.2092 6.5548 10.1801 6.5426 10.1589 6.52094L8.85514 5.19213C8.78501 5.12064 8.83565 5 8.9358 5H17.2158C17.8344 5 18.4276 5.24571 18.8649 5.68309C19.3023 6.12046 19.548 6.71366 19.548 7.3322V8.24176C19.5384 8.56499 19.4616 8.88268 19.3226 9.17464V9.22129Z" fill="currentColor"/>
                    <path d="M19.3413 20.4202L20.4202 19.3413C20.4644 19.2971 20.4644 19.2254 20.4202 19.1812L3.55832 2.3193C3.51411 2.27509 3.44245 2.27509 3.39824 2.3193L2.3193 3.39824C2.27509 3.44245 2.27509 3.51411 2.3193 3.55832L19.1812 20.4202C19.2254 20.4644 19.2971 20.4644 19.3413 20.4202Z" fill="currentColor"/>
                </svg>
                Hide Filters
            </button>
        </div>

        <div id="<?php echo $panel_id ?>" class="@4xl:mx-0 @4xl:h-auto @4xl:data-[state=indeterminate]:invisible @4xl:data-[state=indeterminate]:opacity-0 mx-[calc(var(--container-spacing-x)*-1)] h-(--height) overflow-hidden @4xl:overflow-visible transition-[visibility,opacity,height] data-[state=closed]:hidden js-filters__toggle-panel" data-state="closed">
            <div class="@4xl:flex flex-wrap items-center gap-4">
                <?php foreach ( $filters as $filter ) {
                    $type = $filter['type'];

                    if ($type === 'month') {
                        $type = 'date';
                    }

                    get_template_part('partials/filters-' . $type, null, $filter);
                } ?>
            </div>
        </div>
    </div>

    <?php if ( $show_search ) : ?>
        <div class="relative w-full @4xl:w-70 ml-auto py-4 @4xl:pt-0 @4xl:pb-6 @4xl:group-data-[state=closed]/filters:-mt-16">
            <div class="absolute top-0 inset-x-[calc(-1*var(--container-spacing-x))] border-t @4xl:hidden"></div>
            <?php echo get_template_part('partials/filters-search', null, [
                'placeholder' => $search_placeholder,
                'value' => $search_value
            ]); ?>
        </div>
    <?php endif ?>
</form>