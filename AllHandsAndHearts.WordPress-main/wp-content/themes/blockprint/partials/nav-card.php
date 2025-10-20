<?php
    $featured_img = $args['featured_img'] ?? '';
    $title = $args['title'] ?? '';
    $urgent = $args['urgent'] ?? false;
    $excerpt = $args['excerpt'] ?? '';
    $permalink = $args['permalink'] ?? '';
?>

<div class="group/card grow w-[216px] relative">
    <?php if ($featured_img) : ?>
        <div class="w-full aspect-video overflow-hidden">
            <?php echo wp_get_attachment_image($featured_img, 'medium', false, ['class' => 'size-full object-cover', 'loading' => 'lazy']); ?>
        </div>
    <?php endif; ?>
    <div class="flex flex-col gap-2 mt-4 h-auto [&_p]:mb-0">
        <p class="text-sm font-semibold group-hover/card:text-purple-500"><?php echo $title; ?></p>
        <?php if ($urgent) : ?>
            <p class="bg-green-100 text-xs uppercase px-3 py-2 w-fit font-bold rounded-[360px]">Urgent Need</p>
        <?php endif; ?>
        <p class="text-xs line-clamp-2"><?php echo $excerpt; ?></p>
        <?php if ($permalink) : ?>
            <?php get_template_part('partials/cta-link', null, [
                'class_name' => '[&>span:first-child]:opacity-0 group-hover/card:[&>span:first-child]:opacity-100 [&>span:first-child]:transition-opacity [&>span:first-child]:ease-in-out [&>span:first-child]:delay-100 after:content-[""] after:absolute after:inset-0 after:border-b-2 after:border-transparent [&_a]:text-sm!',
                'link' => [
                    'url' => $permalink,
                    'title' => 'Learn More',
                    'target' => '_self'
                ],
                'mode' => 'dark',
                'arrow_position' => 'start'
            ]); ?>
        <?php endif; ?>
    </div>
</div>