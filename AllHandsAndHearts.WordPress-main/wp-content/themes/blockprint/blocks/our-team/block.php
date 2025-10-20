<?php
/**
 * Our Team Block
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or its parent block.
 */

$anchor = $block['id'];
if ( !empty($block['anchor']) ) {
    $anchor = $block['anchor'];
}

$class_name = build_block_class_name( '@container relative js-our-team', $block );
$style = build_block_styles( $block );
$category = get_field('category');

$team = get_posts( array(
    'post_type' => 'team',
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'tax_query' => array(
        array(
            'taxonomy' => 'team-category',
            'field' => 'term_id',
            'terms' => $category,
        ),
    ),
) );

?>

<script>
    (function () {
        const newTeamMembers = {
            <?php if ($team): ?>
                <?php foreach ($team as $index => $member): ?>
                    <?php
                        $id = $member->ID;
                        $image = get_the_post_thumbnail($id, 'full', ['class' => 'object-cover size-full']);
                        $name = get_the_title($id);
                        $job_title = get_field('job_title', $id);
                        $addtl_titles = get_field('addtl_titles', $id);
                        $bio = get_field('bio', $id);
                        $media = get_field('media', $id);
                    ?>
                    <?php echo $id; ?>: {
                        image: <?php echo json_encode($image); ?>,
                        name: <?php echo json_encode($name); ?>,
                        job_title: <?php echo json_encode($job_title); ?>,
                        addtl_titles: <?php echo json_encode($addtl_titles); ?>,
                        bio: <?php echo json_encode($bio); ?>,
                        media: <?php echo json_encode($media); ?>
                    }<?php echo $index !== array_key_last($team) ? ',' : ''; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        };

        if (typeof globalThis.team === 'undefined') {
            globalThis.team = newTeamMembers;
        } else {
            Object.assign(globalThis.team, newTeamMembers);
        }
    })();
</script>

<div id="<?php echo esc_attr( $anchor ) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr( $style ) . '"' : '' ?>>
    <div class="container-wide">
        <?php if ($team): ?>
            <div class="grid @xl:grid-cols-2  @2xl:grid-cols-3 @4xl:grid-cols-4 gap-x-10 gap-y-13">
                <?php foreach($team as $member): ?>
                    <?php 
                        $id = $member->ID;
                        $bio = get_field('bio', $member->ID);
                        $image = get_the_post_thumbnail( $member->ID, 'full', array('class' => 'object-cover size-full'));
                        $name = get_the_title( $member->ID );
                        $job_title = get_field('job_title', $member->ID);
                        $addtl_titles = get_field('addtl_titles', $member->ID);
                    ?>
                    <div class="relative">
                        <?php if ($image): ?>
                            <div class="aspect-square relative">
                                <?php echo $image; ?>
                                <?php if ($bio): ?>
                                    <div class="shadow-[0_0_22.79px_0_rgba(0,0,0,0.8)] flex items-center justify-center rounded-full size-9 border-2 border-white absolute bottom-4 right-4">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 5V19" stroke="white" stroke-width="2" stroke-linecap="square" stroke-linejoin="round"/><path d="M5 12H19" stroke="white" stroke-width="2" stroke-linecap="square" stroke-linejoin="round"/></svg>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <div class="flex flex-col mt-4">
                            <?php if ($name): ?>
                                <p class="font-bold text-xl mb-1"><?php echo $name; ?></p>
                            <?php endif; ?>
                            <?php if ($job_title): ?>
                                <p class="mb-0"><?php echo $job_title; ?></p>
                            <?php endif; ?>
                            <?php if ($addtl_titles): ?>
                                <p class="mb-0"><?php echo $addtl_titles; ?></p>
                            <?php endif; ?>
                        </div>
                        <?php if ($bio): ?>
                            <a class="absolute inset-0 z-10 js-our-team__trigger cursor-pointer" data-id="<?php echo $id; ?>" href="#">
                                <span class="sr-only">Open Modal</span>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php elseif ($is_preview): ?>
            <p class="border-1 p-8 text-center text-gray-500">No team members found. Please add team members in the Our Team post type.</p>
        <?php endif; ?>
    </div>
    <div class="group fixed left-0 top-(--wp-admin--admin-bar--height,0px) bottom-0 w-full z-[999] overflow-hidden transition-[visibility] duration-500 data-[state=closed]:invisible js-our-team__slideout" aria-hidden="true" data-state="closed">
        <div class="absolute inset-0 group-data-[state=open]:bg-black/40 transition-colors duration-500 js-our-team__close"></div>
        <div class="absolute top-0 right-0 h-full w-full md:w-11/12 max-w-180 bg-white overflow-auto p-8 group-data-[state=closed]:translate-x-full transition-transform duration-500">
            <button type="button" class="absolute top-0 left-0 size-8 flex items-center justify-center cursor-pointer js-our-team__close" aria-label="close summmary">
                <svg class="" viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
            <div class="@container js-our-team__content"></div>
        </div>
    </div>
</div>