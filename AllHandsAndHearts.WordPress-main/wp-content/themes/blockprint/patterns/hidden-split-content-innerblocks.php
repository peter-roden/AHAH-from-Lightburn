<?php
/**
 * Title: Split Content Innerblocks
 * Slug: blockprint/hidden-split-content-innerblocks
 * Inserter: false
 */
?>

<!-- wp:paragraph {"className":"text-overline","textColor":"purple-500"} -->
<p class="text-overline has-purple-500-color has-text-color">Overline</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"style":{"spacing":{"margin":{"top":"var:preset|spacing|2"}}},"fontSize":"heading-3"} -->
<h2 class="wp-block-heading has-heading-3-font-size" style="margin-top:var(--wp--preset--spacing--2)">Content Heading</h2>
<!-- /wp:heading -->

<!-- wp:group {"className":"pl-10 @4xl:pl-16","style":{"spacing":{"margin":{"top":"var:preset|spacing|8"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group pl-10 @4xl:pl-16" style="margin-top:var(--wp--preset--spacing--8)"><!-- wp:paragraph {"style":{"typography":{"fontStyle":"normal","fontWeight":"700"}},"fontSize":"xl"} -->
<p class="has-xl-font-size" style="font-style:normal;font-weight:700">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque iaculis, purus at dignissim luctus, nulla nisl pharetra lacus, nec aliquam est erat nec elit. Nulla sagittis sapien eget urna hendrerit, quis fermentum tellus egestas.</p>
<!-- /wp:paragraph -->

<!-- wp:group {"style":{"spacing":{"margin":{"top":"var:preset|spacing|8"}}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group" style="margin-top:var(--wp--preset--spacing--8)"><!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-secondary"} -->
<div class="wp-block-button is-style-secondary"><a class="wp-block-button__link wp-element-button">Button CTA</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->

<!-- wp:acf/cta-link {"name":"acf/cta-link","data":{"field_647f664516bf4":{"title":"","url":"","target":""},"field_68433882ea775":"right"},"mode":"preview"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->