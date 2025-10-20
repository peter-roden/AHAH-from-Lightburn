<?php
/**
 * Site Header Block
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

$class_name = build_block_class_name( esc_attr('relative group/nav  z-20'), $block );

$height_desktop = (get_field('height_desktop') ?: 96) / 16 . 'rem';
$height_mobile = (get_field('height_mobile') ?: 64) / 16 . 'rem';
$enable_sticky_header = get_field('enable_sticky_header') ?: '0';
$container_width = get_field('container_width');
$logo_image = get_field('logo_image');
$logo_width_desktop = get_field('logo_width_desktop');
$logo_width_mobile = get_field('logo_width_mobile');
$button_link_outline = get_field('button_link_outline');
$button_link_primary = get_field('button_link_primary');
$show_search = get_field('show_search');
$main_menu = get_field('main_menu', 'option');
$overlay_header = get_field('header_overlay',$post_id);

$logo_style = '';
if ( !empty($logo_width_desktop) ) {
    $logo_style = "--logo-width-desktop:{$logo_width_desktop}px;";
}

if ( !empty($logo_width_mobile) ) {
    $logo_style .= "--logo-width-mobile:{$logo_width_mobile}px;";
}

$parent_class_name = '';
if ( $enable_sticky_header === '1' ) {
    $parent_class_name .= 'js-header--sticky group/header';
    $class_name .= ' group-data-[top=false]/header:bg-none! group-data-[top=false]/header:bg-white! group-data-[top=false]/header:[&_path]:fill-primary! group-data-[top=false]/header:[&_a]:not-[.wp-element-button]:text-purple-950!';
} else if ( $enable_sticky_header === '2' ) {
    $parent_class_name .= 'js-header--sticky-scroll-up';
}

if ($overlay_header) {
    $class_name .= ' bg-gradient-to-b from-black/45 to-transparent hover:bg-none hover:bg-white has-data-[state=open]:bg-none! has-data-[state=open]:bg-white! has-[data-state=open]:[&_path]:fill-primary! transition-all ease-in-out [&_a]:text-white';
    $parent_class_name .= ' -mb-(--header-height)';
} else {
    $class_name .= ' [&_.menu-item-link]:text-purple-950! [&_path]:fill-primary! [&_button>span]:text-purple-950!';
}

$container_class_name = 'container flex items-center gap-6 xl:gap-8 grow h-full';
if ( $container_width === 'wide' || $container_width === 'full' ) {
    $container_class_name .= " container--{$container_width}";
}
?>

<div id="<?php echo esc_attr( $anchor ); ?>" class="<?php echo trim( esc_attr( $class_name ) ); ?>">
    <div class="relative z-3 h-(--height-mobile) lg:h-(--height-desktop)" style="<?php echo "--height-mobile:{$height_mobile};--height-desktop:{$height_desktop}" ?>">
        <div class="<?php echo esc_attr( $container_class_name ) ?>">
            <button type="button" class="group peer group-data-[top=false]/header:text-purple-950! text-white flex lg:hidden flex-col items-center justify-center gap-1 w-[2.75rem] h-[2.75rem] mx-[-.75rem] cursor-pointer js-mobile-nav-toggle" aria-controls="mobile-nav" aria-expanded="false" aria-label="Toggle navigation" data-state="closed">
                <span class="block w-4.5 h-0.5 rounded-md bg-current group-data-[state=open]:rotate-45 group-data-[state=open]:text-primary group-data-[state=open]:translate-y-[.375rem] transition-transform duration-350"></span>
                <span class="block w-4.5 h-0.5 rounded-md bg-current group-data-[state=open]:opacity-0 transition-[opacity] duration-350"></span>
                <span class="block w-4.5 h-0.5 rounded-md bg-current group-data-[state=open]:-rotate-45 group-data-[state=open]:text-primary group-data-[state=open]:translate-y-[-.375rem] transition-transform duration-350"></span>
            </button>

            <a class="text-white no-underline transition-colors peer peer-data-[state=open]:text-purple-950 hover:text-purple-950" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" aria-label="<?php echo get_bloginfo('name') ?>">
                <?php if ( $logo_image ) : ?>
                    <?php
                        echo wp_get_attachment_image( $logo_image['id'], 'large', false, [
                        'class' => 'w-(--width-mobile) lg:w-(--width-desktop)',
                        'style' => $logo_style,
                        'loading' => 'lazy'
                        ] );
                    ?>
                <?php else : ?>
                    <svg 
                    class="[&_path]:fill-current group group-hover/nav:[&_path]:fill-purple-950 [&_path]:transition-colors transition-colors" 
                    width="110" 
                    height="40" 
                    viewBox="0 0 110 40" 
                    fill="none" 
                    xmlns="http://www.w3.org/2000/svg">

                     <g clip-path="url(#clip0_12961_272)">
                            <path d="M10.5833 0.596326L10.5113 0.366211H5.73287L0.14007 18.1091L0 18.5393H3.71186L4.90645 14.7454H11.3237L12.4602 18.3112L12.5343 18.5393H16.2401L10.5833 0.596326ZM10.2411 11.3477H5.97699L8.09605 4.62034L10.2411 11.3477Z" />
                            <path d="M20.9965 0H17.4067V18.5393H20.9965V0Z" />
                            <path d="M26.3618 0H22.772V18.5393H26.3618V0Z" />
                            <path d="M44.4683 7.73594H36.8345V0.364258H33.2427V18.5393H36.8345V11.1436H44.4683V18.5393H48.0481V0.364258H44.4683V7.73594Z" />
                            <path d="M51.5435 18.3172C52.2459 18.7034 53.1103 18.8995 54.1108 18.8995C55.3475 18.8995 56.398 18.6634 57.2344 18.1952C57.6446 17.9651 58.0308 17.6709 58.391 17.3127V18.5353H61.6166V10.1412C61.6166 9.56286 61.5926 9.02259 61.5425 8.53235C61.4905 8.01209 61.3344 7.49583 61.0843 7.00158C60.6221 6.06711 59.8997 5.38277 58.9433 4.97257C58.0188 4.57637 56.9362 4.37427 55.7296 4.37427C54.1168 4.37427 52.8082 4.73645 51.8417 5.4488C50.8752 6.16116 50.2089 7.11964 49.8667 8.29623L49.7747 8.60638L53.0703 9.6389L53.1724 9.32874C53.3625 8.74645 53.6946 8.33225 54.1609 8.09813C54.6631 7.846 55.1914 7.71994 55.7276 7.71994C56.6101 7.71994 57.2344 7.90403 57.5826 8.26421C57.8187 8.51034 57.9768 8.86651 58.0488 9.32674C57.6206 9.38877 57.2124 9.4488 56.8182 9.50283C55.9818 9.62089 55.1994 9.75096 54.491 9.88902C53.7687 10.0291 53.1323 10.1892 52.5941 10.3633C51.8597 10.6114 51.2514 10.9355 50.7832 11.3297C50.3069 11.7319 49.9488 12.2162 49.7186 12.7685C49.4925 13.3127 49.3765 13.931 49.3765 14.6054C49.3765 15.3818 49.5606 16.1021 49.9227 16.7485C50.2889 17.4008 50.8332 17.929 51.5415 18.3172H51.5435ZM58.0328 12.3983C58.0288 12.5123 58.0248 12.6324 58.0188 12.7585C58.0008 13.2007 57.9207 13.5949 57.7807 13.933L57.7727 13.9551C57.6886 14.2132 57.5185 14.5013 57.2664 14.8075C57.0163 15.1096 56.6741 15.3718 56.2479 15.5859C55.8257 15.798 55.3034 15.904 54.6931 15.904C54.2829 15.904 53.9387 15.84 53.6706 15.7159C53.4165 15.5979 53.2224 15.4378 53.0943 15.2437C52.9683 15.0516 52.9042 14.8255 52.9042 14.5674C52.9042 14.3453 52.9523 14.1532 53.0463 13.9931C53.1464 13.825 53.2964 13.6709 53.4905 13.5368C53.7006 13.3908 53.9648 13.2607 54.2689 13.1527C54.6051 13.0426 54.9993 12.9426 55.4375 12.8525C55.8817 12.7605 56.426 12.6624 57.0543 12.5564C57.3545 12.5063 57.6786 12.4523 58.0288 12.3963L58.0328 12.3983Z" />
                            <path d="M66.7494 11.4598C66.7494 10.6974 66.8334 10.0691 66.9995 9.59082C67.1616 9.12659 67.3737 8.75841 67.6318 8.50028C67.89 8.24215 68.1801 8.05806 68.4943 7.95401C68.8244 7.84395 69.1606 7.78792 69.4968 7.78792C70.1191 7.78792 70.6113 7.91799 70.9615 8.17411C71.3217 8.43825 71.5978 8.78042 71.7799 9.19062C71.972 9.62284 72.0961 10.0811 72.1481 10.5473C72.2041 11.0395 72.2321 11.4878 72.2321 11.884V18.5373H75.8599V10.8735C75.8599 10.5473 75.8319 10.1211 75.7799 9.60483C75.7239 9.07657 75.6038 8.51428 75.4197 7.92799C75.2316 7.32769 74.9355 6.75541 74.5433 6.22514C74.1411 5.68287 73.5948 5.23264 72.9205 4.88847C72.2441 4.5423 71.3837 4.36621 70.3612 4.36621C69.0706 4.36621 67.962 4.65636 67.0696 5.22664C66.8314 5.37872 66.6073 5.5468 66.3972 5.73089V4.7444H63.1216V18.5393H66.7494V11.4598Z" />
                            <path d="M80.044 17.9309C80.9965 18.5732 82.121 18.8994 83.3917 18.8994C84.7363 18.8994 85.8829 18.5732 86.8034 17.9269C86.8034 17.9269 86.8054 17.9269 86.8074 17.9249V18.5352H90.057V0.360107H86.4412V5.08847C85.6148 4.61423 84.6263 4.37411 83.4997 4.37411C82.1991 4.37411 81.0485 4.69828 80.082 5.3346C79.1195 5.96891 78.3672 6.84335 77.8429 7.9359C77.3246 9.01844 77.0625 10.2631 77.0625 11.6357C77.0625 13.0084 77.3226 14.231 77.8369 15.3156C78.3551 16.4121 79.0975 17.2906 80.042 17.9289L80.044 17.9309ZM80.8264 11.6357C80.8264 10.8854 80.9424 10.193 81.1706 9.57872C81.3907 8.98842 81.7348 8.51419 82.1911 8.17001C82.6413 7.82984 83.2296 7.65776 83.9379 7.65776C84.6063 7.65776 85.1525 7.81784 85.5608 8.13199C85.977 8.45215 86.2891 8.90638 86.4892 9.48667C86.6993 10.093 86.8054 10.8153 86.8054 11.6357C86.8054 12.4562 86.6993 13.1685 86.4892 13.7788C86.2891 14.3611 85.971 14.8173 85.5447 15.1355C85.1225 15.4517 84.5502 15.6117 83.8399 15.6117C83.1295 15.6117 82.5893 15.4416 82.155 15.1075C81.7128 14.7673 81.3787 14.2951 81.1625 13.7048C80.9384 13.0925 80.8244 12.3961 80.8244 11.6357H80.8264Z" />
                            <path d="M93.2867 17.759C94.3533 18.5274 95.748 18.9155 97.4328 18.9155C99.1176 18.9155 100.604 18.5113 101.619 17.7149C102.659 16.8985 103.186 15.764 103.186 14.3413C103.186 13.6049 103.03 12.9626 102.721 12.4363C102.411 11.908 101.911 11.4518 101.233 11.0796C100.582 10.7235 99.7119 10.4053 98.6434 10.1312C97.6349 9.87503 96.8685 9.65692 96.3643 9.48283C95.758 9.27273 95.5418 9.11065 95.4678 9.03061C95.3578 8.91455 95.3037 8.77848 95.3037 8.6144C95.3037 8.28623 95.4538 8.04611 95.774 7.86002C96.1341 7.64791 96.6324 7.55987 97.2547 7.59389C97.907 7.63191 98.4293 7.79399 98.8095 8.07613C99.1677 8.34426 99.3798 8.71645 99.4398 9.18268L99.4858 9.52485L102.813 8.92855L103.13 8.87453L103.084 8.55637C102.962 7.71195 102.633 6.96557 102.111 6.33726C101.593 5.71295 100.903 5.2267 100.064 4.89254C99.2397 4.56237 98.2832 4.39429 97.2227 4.39429C96.1622 4.39429 95.1757 4.56837 94.3693 4.91255C93.5448 5.26472 92.8925 5.77498 92.4283 6.43131C91.9601 7.09364 91.7239 7.87803 91.7239 8.76247C91.7239 9.47883 91.884 10.1011 92.1982 10.6134C92.5123 11.1237 93.0266 11.5679 93.7269 11.9321C94.3933 12.2782 95.2997 12.6024 96.4223 12.9005C97.4008 13.1567 98.1311 13.3708 98.5974 13.5369C99.1617 13.737 99.3317 13.899 99.3778 13.9571C99.4718 14.0791 99.5198 14.2532 99.5198 14.4773C99.5198 14.8555 99.3758 15.1437 99.0776 15.3598C98.7515 15.5959 98.2672 15.7159 97.6349 15.7159C96.9065 15.7159 96.2982 15.5479 95.83 15.2177C95.3718 14.8935 95.0736 14.4433 94.9375 13.877L94.8655 13.5829L91.5719 14.0911L91.2417 14.1452L91.2977 14.4713C91.5298 15.876 92.1962 16.9826 93.2787 17.763L93.2867 17.759Z" />
                            <path d="M44.4664 28.7923H36.8306V21.4207H33.2388V39.5957H36.8306V32.2H44.4664V39.5957H48.0442V21.4207H44.4664V28.7923Z" />
                            <path d="M59.8903 26.4253C58.8858 25.755 57.6551 25.4148 56.2344 25.4148C54.8918 25.4148 53.6892 25.7249 52.6606 26.3373C51.6301 26.9516 50.8157 27.824 50.2394 28.9326C49.6651 30.0331 49.375 31.3438 49.375 32.8245C49.375 34.2052 49.6731 35.4438 50.2614 36.5103C50.8517 37.5809 51.6862 38.4293 52.7407 39.0336C53.7912 39.6359 55.0258 39.9401 56.4065 39.9401C57.7872 39.9401 58.9558 39.5919 60.0543 38.9055C61.1569 38.2152 61.9853 37.2367 62.5116 35.9961L62.6576 35.6579L59.408 34.6734L59.1379 34.5934L59.0158 34.8495C58.7597 35.3958 58.3955 35.818 57.9313 36.1001C57.463 36.3863 56.8928 36.5324 56.2364 36.5324C55.2279 36.5324 54.4555 36.2062 53.9393 35.5619C53.5851 35.1176 53.345 34.5334 53.2269 33.823H62.6596L62.6837 33.5168C62.7997 31.9 62.6156 30.4733 62.1374 29.2727C61.6531 28.0561 60.8968 27.0976 59.8923 26.4273L59.8903 26.4253ZM53.327 30.9496C53.461 30.4193 53.6671 29.9751 53.9413 29.6289C54.4575 28.9746 55.2699 28.6424 56.3585 28.6424C57.307 28.6424 58.0033 28.9306 58.4315 29.4968C58.6917 29.843 58.8818 30.3313 58.9938 30.9516H53.329L53.327 30.9496Z" />
                            <path d="M75.3938 28.066C74.9296 27.1296 74.2092 26.4472 73.2528 26.037C72.3283 25.6388 71.2478 25.4387 70.0392 25.4387C68.4244 25.4387 67.1177 25.8009 66.1512 26.5133C65.1847 27.2276 64.5184 28.1861 64.1762 29.3627L64.0842 29.6728L67.0697 30.6093L67.3798 30.7054L67.4819 30.3972C67.672 29.8149 68.0041 29.4007 68.4704 29.1666C68.9726 28.9145 69.5009 28.7884 70.0372 28.7884C70.9196 28.7884 71.5439 28.9725 71.8921 29.3327C72.1242 29.5728 72.2763 29.929 72.3503 30.3952C71.9161 30.4592 71.5059 30.5173 71.1277 30.5713C70.2893 30.6913 69.5069 30.8214 68.8005 30.9575C68.0782 31.0976 67.4419 31.2556 66.9036 31.4317C66.1692 31.6798 65.5609 32.004 65.0947 32.3982C64.6185 32.8004 64.2603 33.2846 64.0302 33.8369C63.804 34.3812 63.688 34.9995 63.688 35.6718C63.688 36.4482 63.8721 37.1686 64.2343 37.8149C64.6004 38.4672 65.1447 38.9955 65.8531 39.3837C66.5554 39.7699 67.4199 39.966 68.4204 39.966C69.657 39.966 70.7075 39.7299 71.5439 39.2616C71.9521 39.0335 72.3403 38.7374 72.7005 38.3752V39.5998H75.9261V31.2056C75.9261 30.6273 75.9021 30.087 75.8521 29.5968C75.8 29.0765 75.644 28.5603 75.3938 28.066ZM72.3443 33.4627C72.3403 33.5768 72.3363 33.6969 72.3303 33.8229C72.3123 34.2651 72.2323 34.6593 72.0962 34.9895L72.0842 35.0195C72.0001 35.2796 71.8301 35.5658 71.5779 35.8719C71.3298 36.1741 70.9876 36.4362 70.5614 36.6503C70.1392 36.8624 69.617 36.9685 69.0066 36.9685C68.5964 36.9685 68.2523 36.9045 67.9841 36.7804C67.728 36.6603 67.5359 36.5023 67.4078 36.3082C67.2818 36.1161 67.2178 35.8899 67.2178 35.6318C67.2178 35.4097 67.2658 35.2176 67.3598 35.0575C67.4599 34.8894 67.61 34.7354 67.804 34.6013C68.0142 34.4552 68.2783 34.3252 68.5824 34.2171C68.9186 34.1071 69.3108 34.007 69.751 33.917C70.1972 33.8249 70.7415 33.7269 71.3678 33.6208C71.664 33.5708 71.9901 33.5188 72.3423 33.4627H72.3443Z" />
                            <path d="M83.842 25.7467C83.4038 25.7767 82.9695 25.8588 82.5533 25.9928C82.1311 26.1289 81.7409 26.315 81.4048 26.5431C81.1046 26.7292 80.8345 26.9513 80.5943 27.2094V25.8007H77.3447V39.5956H80.9485V32.5881C80.9485 32.1179 81.0066 31.6757 81.1186 31.2735C81.2287 30.8813 81.4008 30.5271 81.6309 30.221C81.857 29.9208 82.1551 29.6687 82.5273 29.4666C82.8875 29.2505 83.2997 29.1224 83.7519 29.0864C84.2142 29.0484 84.6284 29.0824 84.9785 29.1844L85.4008 29.3065V25.8528L85.1246 25.8047C84.7124 25.7367 84.2822 25.7167 83.844 25.7467H83.842Z" />
                            <path d="M92.3165 22.2891H88.7387V25.8969H86.3555V29.3226H88.7387V34.0409C88.7387 34.7933 88.7467 35.4717 88.7627 36.0559C88.7807 36.6963 88.9528 37.3306 89.2769 37.9429C89.6511 38.6292 90.2074 39.1395 90.9298 39.4556C91.6221 39.7598 92.4145 39.9239 93.2849 39.9459C93.379 39.9479 93.473 39.9499 93.5671 39.9499C94.3295 39.9499 95.1159 39.8759 95.9002 39.7278L96.1724 39.6798V36.5682L95.7942 36.6202C95.0058 36.7383 94.2954 36.7703 93.6831 36.7163C93.1489 36.6683 92.7747 36.4541 92.5366 36.0579C92.4145 35.8578 92.3465 35.5857 92.3365 35.2475C92.3245 34.8613 92.3184 34.3991 92.3184 33.8709V29.3246H96.1744V25.8989H92.3184V22.2911L92.3165 22.2891Z" />
                            <path d="M108.55 33.4686C108.24 32.9403 107.74 32.4821 107.062 32.1119C106.411 31.7557 105.541 31.4356 104.472 31.1634C103.466 30.9073 102.699 30.6892 102.195 30.5151C101.589 30.305 101.373 30.1429 101.299 30.0629C101.189 29.9468 101.135 29.8108 101.135 29.6467C101.135 29.3185 101.285 29.0784 101.603 28.8903C101.961 28.6802 102.459 28.5901 103.084 28.6242C103.736 28.6602 104.26 28.8243 104.638 29.1064C104.997 29.3745 105.209 29.7467 105.269 30.211L105.315 30.5531L108.644 29.9568L108.961 29.9028L108.915 29.5866C108.792 28.7422 108.464 27.9958 107.942 27.3675C107.422 26.7432 106.733 26.257 105.895 25.9228C105.069 25.5926 104.112 25.4246 103.054 25.4246C101.995 25.4246 101.007 25.5986 100.2 25.9428C99.3758 26.295 98.7234 26.8053 98.2612 27.4616C97.793 28.1239 97.5569 28.9083 97.5569 29.7927C97.5569 30.5091 97.7169 31.1314 98.0311 31.6437C98.3452 32.1559 98.8595 32.6001 99.5599 32.9623C100.226 33.3065 101.133 33.6327 102.255 33.9308C103.228 34.1869 103.96 34.401 104.43 34.5671C104.997 34.7692 105.165 34.9293 105.211 34.9873C105.307 35.1094 105.355 35.2855 105.355 35.5076C105.355 35.8858 105.211 36.1739 104.913 36.39C104.586 36.6262 104.102 36.7462 103.47 36.7462C102.741 36.7462 102.133 36.5781 101.665 36.248C101.207 35.9238 100.909 35.4736 100.772 34.9073L100.7 34.6132L97.4068 35.1214L97.0786 35.1754L97.1346 35.5016C97.3668 36.9063 98.0331 38.0129 99.1156 38.7932C100.182 39.5596 101.577 39.9498 103.262 39.9498C104.947 39.9498 106.433 39.5456 107.448 38.7492C108.488 37.9328 109.015 36.7982 109.015 35.3755C109.015 34.6392 108.859 33.9968 108.55 33.4706V33.4686Z" />
                            <path d="M26.3236 34.5372C26.3476 34.123 26.3596 33.6888 26.3596 33.2466V29.7428H23.122V32.5402L19.2621 28.9684C19.034 28.7563 18.8159 28.5542 18.6038 28.3601C18.3997 28.172 18.2276 27.9999 18.0935 27.8499C17.8874 27.6137 17.7113 27.3776 17.5712 27.1515C17.4552 26.9614 17.3952 26.6933 17.3952 26.3511C17.3952 25.9609 17.4752 25.6288 17.6333 25.3666C17.7874 25.1085 18.0375 24.8984 18.3716 24.7403C18.7238 24.5742 19.138 24.4922 19.6063 24.4922C19.9024 24.4922 20.2086 24.5282 20.5167 24.6002C20.7889 24.6643 21.027 24.7923 21.2331 24.9904C21.4712 25.2085 21.6413 25.4747 21.7373 25.7808L21.8254 26.069L25.013 25.3846L25.3531 25.3146L25.2651 24.9764C25.153 24.5542 24.9829 24.138 24.7588 23.7398C24.5327 23.3356 24.2466 22.9674 23.9184 22.6573C23.3882 22.101 22.7358 21.6928 21.9814 21.4467C20.8589 21.0785 19.6463 21.0024 18.3877 21.1725C17.9394 21.2326 17.4912 21.3446 17.057 21.5067C16.0465 21.8869 15.2381 22.5172 14.6498 23.3816C14.0635 24.2441 13.7653 25.2326 13.7653 26.3171C13.7653 27.0455 13.9014 27.6938 14.1695 28.2381C14.3836 28.6743 14.6838 29.1245 15.06 29.5827C14.9639 29.6508 14.8679 29.7228 14.7718 29.7988C14.5637 29.9609 14.3696 30.151 14.1956 30.3611C13.7553 30.8794 13.4252 31.4837 13.2131 32.154C13.005 32.8143 12.8989 33.5067 12.9009 34.2231C12.9269 34.9434 13.053 35.6298 13.2791 36.2621C13.5072 36.9044 13.8714 37.5047 14.3636 38.047C14.9759 38.7093 15.7483 39.1995 16.6608 39.5037C17.5532 39.8018 18.5157 39.9519 19.5202 39.9519C19.8744 39.9519 20.2266 39.9379 20.5707 39.9079C20.9209 39.8779 21.2891 39.8158 21.6553 39.7258C22.1815 39.6157 22.7118 39.4297 23.2301 39.1755C23.6603 38.9634 24.0665 38.6973 24.4407 38.3791L25.9134 39.7778L26.1535 40.0039L28.4927 37.5147L26.2116 35.4257C26.2636 35.1755 26.3016 34.8794 26.3216 34.5412L26.3236 34.5372ZM21.8214 35.9259C21.7553 35.9679 21.6873 36.0079 21.6173 36.048C21.4252 36.156 21.187 36.2541 20.8989 36.3401C20.7128 36.4041 20.5187 36.4482 20.3206 36.4702C20.1105 36.4942 19.8824 36.5042 19.6443 36.5042C19.174 36.5042 18.6778 36.4282 18.1675 36.2801C17.6953 36.142 17.3291 35.9119 17.077 35.5917C16.9129 35.3916 16.7788 35.1615 16.6788 34.9074C16.5807 34.6573 16.5267 34.3631 16.5207 34.037C16.5207 33.7468 16.5587 33.4787 16.6328 33.2406C16.7068 33.0064 16.8089 32.8003 16.9349 32.6343C17.037 32.5042 17.165 32.3841 17.3131 32.2781C17.4132 32.206 17.5232 32.142 17.6413 32.086L21.8194 35.9239L21.8214 35.9259Z" />
                        </g>
                        <defs>
                            <clipPath id="clip0_12961_272">
                                <rect width="109.017" height="40" />
                            </clipPath>
                        </defs>
                    </svg>
                <?php endif; ?>
            </a>

            <nav class="flex items-center gap-6 xl:gap-8 lg:h-full lg:shrink-0 lg:ms-8 ml-auto lg:mr-auto">
                <div id="nav" class="hidden lg:flex items-center gap-6 xl:gap-8 h-full shrink-0">
                    <?php if ( $main_menu ) : ?>
                        <ul class="flex items-center gap-6 xl:gap-8 h-full list-none pl-0 mb-0 [&_a]:no-underline">
                            <?php foreach ( $main_menu as $menu_item ) : ?>
                                <?php 
                                    $has_submenu = $menu_item['has_submenu'] ?? false;
                                    $submenu = $menu_item['submenu'] ?? [];
                                    $link = $menu_item['link'] ?? '';
                                    $submenu_style = $has_submenu ? $menu_item['submenu_style'] : 'simple' ;
                                    $has_megamenu = $submenu_style === 'mega-menu';
                                ?>
                                    <li class="<?php echo esc_attr('group/menu-item ' . ($has_megamenu ? '' : 'relative') .  ' flex items-center h-full [&:hover>a]:after:border-primary') ?>">
                                        <?php if ( $link ): ?>
                                            <a class="menu-item-link relative font-bold text-sm group-hover/nav:text-purple-950 flex items-center gap-1 h-fit hover:no-underline hover:font-[weight:900] after:content-[''] after:absolute after:inset-0 after:border-b-2 after:border-transparent" href="<?php echo $link['url']; ?>" target="<?php echo $link['target'] ?: '_self' ?>">
                                                <?php echo $link['title']; ?>
                                                <?php if ( $has_submenu ) : ?>
                                                    <svg class="[&_*]:fill-none" viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
                                                <?php endif ?>
                                            </a>
                                        <?php endif; ?>
                                        <?php if ( $has_submenu ): ?>
                                            <div class="<?php echo $has_megamenu ? 'container p-12 mx-auto left-0 right-0' : ' -left-10 p-8'; ?> group-hover/menu-item:flex min-w-96 size-auto! hidden absolute top-full z-1 bg-white -mt-[2px]">
                                                <ul class="list-none pl-0 flex flex-col gap-4 shrink-0">
                                                    <?php foreach ( $submenu as $submenu_item ) : ?>
                                                        <?php
                                                            $submenu_link = $submenu_item['link'] ?? [];
                                                        ?>
                                                        <li>
                                                            <a class="block font-medium text-md text-purple-950! hover:text-purple-500! hover:translate-x-2 transition-all hover:no-underline" href="<?php echo $submenu_link['url'] ?>" target="<?php echo $submenu_link['target'] ?: '_self' ?>">
                                                                <?php echo $submenu_link['title'] ?>
                                                            </a>
                                                        </li>
                                                    <?php endforeach ?>
                                                </ul>
                                                <?php if ($has_megamenu): ?>
                                                    <?php
                                                        $mega_menu = get_posts([
                                                            'post_type' => 'program',
                                                            'numberposts' => 3,
                                                            'meta_query' => [
                                                                [
                                                                    'key' => 'urgent',
                                                                    'value' => true,
                                                                    'compare' => '='
                                                                ],
                                                                [
                                                                    'key' => 'active',
                                                                    'value' => true,
                                                                    'compare' => '='
                                                                ]
                                                            ],
                                                            'orderby' => 'meta_value_num',
                                                            'order' => 'DESC'
                                                        ]);
                                                    ?>
                                                    <div class="ml-20 xl:ml-40 grow w-full">
                                                        <p class="font-bold">Active Programs</p>
                                                        <div class=" grid grid-cols-3 gap-4 w-full">
                                                            <?php foreach ($mega_menu as $id) : ?>
                                                                <?php
                                                                    $featured_img = get_post_thumbnail_id($id);
                                                                    $title = get_the_title($id);
                                                                    $urgent = get_field('urgent', $id);
                                                                    $excerpt = get_field('short_description', $id) ?: get_the_excerpt($id);
                                                                    $permalink = get_permalink($id);
                                                                ?>
                                                                <?php get_template_part(
                                                                    'partials/nav-card',
                                                                    null,
                                                                    [
                                                                        'id' => $id,
                                                                        'featured_img' => $featured_img,
                                                                        'title' => $title,
                                                                        'urgent' => $urgent,
                                                                        'excerpt' => $excerpt,
                                                                        'permalink' => $permalink
                                                                    ]
                                                                ); ?>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                    </li>
                            <?php endforeach ?>
                        </ul>
                    <?php endif ?>
                </div>

                <?php if ( $button_link_primary ) : ?>
                    <div class="wp-block-button block lg:hidden! ml-auto">
                        <a class="wp-block-button__link has-sm-font-size wp-element-button w-full" href="<?php echo $button_link_primary['url'] ?>" target="<?php echo $button_link_primary['target'] ?: '_self' ?>">
                            <?php echo $button_link_primary['title'] ?>
                        </a>
                    </div>
                <?php endif ?>

                <?php if ( $show_search ) : ?>
                    <button type="button" class="relative hidden lg:flex items-center justify-center w-8 h-full cursor-pointer after:content-[''] after:absolute after:inset-0 after:border-b-2 after:border-transparent hover:after:border-current js-header__search-overlay-toggle" aria-controls="search-overlay" aria-expanded="false" aria-label="Toggle search" data-state="closed">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="11" cy="11" r="8"/>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                    </button>

                    <div id="search-overlay" class="absolute top-0 left-0 z-10 hidden lg:flex items-center justify-center size-full bg-white transition-[opacity,visibility] duration-150 ease-linear invisible opacity-0 data-[state=open]:visible data-[state=open]:opacity-100 js-header__search-overlay" aria-hidden="true" data-state="closed">
                        <div class="container">
                            <div class="flex max-w-127 mx-auto">
                                <form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="bg-gray-100 grow">
                                    <div class="flex items-center">
                                        <label class="sr-only" for="header-search-input">Search</label>
                                        <input type="search" id="header-search-input" class="h-12 pl-4 grow" name="s" placeholder="Search" required>
                                        <button type="submit" class="flex items-center justify-center size-12 cursor-pointer" aria-label="Search">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <circle cx="11" cy="11" r="8"/>
                                                <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                                            </svg>
                                        </button>
                                    </div>
                                </form>
                                <button type="button" class="shrink-0 cursor-pointer p-2 js-header__search-overlay-close" aria-label="Close search">
                                    <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <line x1="18" y1="6" x2="6" y2="18"/>
                                        <line x1="6" y1="6" x2="18" y2="18"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endif ?>
            </nav>
            <div class="hidden lg:flex items-center gap-2">
                <?php if ( $button_link_outline ) : ?>
                    <div class="wp-block-button shrink-0 <?php echo $overlay_header ? 'is-style-outline-white' : 'is-style-outline'; ?>  ">
                        <a class="wp-block-button__link has-sm-font-size wp-element-button group-hover/nav:text-primary! group-hover/nav:border-primary! group-data-[top=false]/header:text-primary! group-data-[top=false]/header:border-primary!" href="<?php echo $button_link_outline['url'] ?>" target="<?php echo $button_link_outline['target'] ?: '_self' ?>">
                            <?php echo $button_link_outline['title'] ?>
                        </a>
                    </div>
                <?php endif ?>
                <?php if ( $button_link_primary ) : ?>
                    <div class="wp-block-button shrink-0">
                        <a class="wp-block-button__link has-sm-font-size wp-element-button" href="<?php echo $button_link_primary['url'] ?>" target="<?php echo $button_link_primary['target'] ?: '_self' ?>">
                            <?php echo $button_link_primary['title'] ?>
                        </a>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
    <div id="mobile-nav" class="lg:hidden absolute data-[state=closed]:-top-full top-full left-0 z-2 w-full h-[calc(100vh-var(--header-height))] bg-white data-[state=closed]:invisible data-[state=closed]:opacity-0 transition-all duration-350! js-mobile-nav" aria-hidden="true" data-state="closed">
        <div class="container-wide">
            <?php if ( $show_search ) : ?>
                <form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="focus-within:bg-gray-100 p-2 -mx-2 mb-6">
                    <div class="flex items-center border-b">
                        <label class="sr-only" for="nav-search-input">Search</label>
                        <input type="search" id="nav-search-input" class="grow h-8 focus:outline-0" name="s" placeholder="Search" required />
                        <button type="submit" class="flex items-center h-8 px-2 -mr-2 cursor-pointer" aria-label="Search">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <circle cx="11" cy="11" r="8"/>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                            </svg>
                        </button>
                    </div>
                </form>
            <?php endif ?>

            <?php if ( $button_link_outline ) : ?>
                <div class="wp-block-button is-style-outline shrink-0 w-full mt-8 mb-6">
                    <a class="wp-block-button__link w-full has-md-font-size wp-element-button text-primary! group-hover/nav:text-primary! group-hover/nav:border-primary!" href="<?php echo $button_link_outline['url'] ?>" target="<?php echo $button_link_outline['target'] ?: '_self' ?>">
                        <?php echo $button_link_outline['title'] ?>
                    </a>
                </div>
            <?php endif ?>

            <?php if ( $main_menu ): ?>
                <ul class="flex flex-col gap-y-6 list-none pl-0 mb-0 [&_a]:text-current [&_a]:hover:text-current [&_a]:no-underline">
                    <?php $i=1; ?>
                    <?php foreach ( $main_menu as $menu_item ) : ?>
                        <?php 
                            $has_submenu = $menu_item['has_submenu'] ?? false;
                            $submenu = $menu_item['submenu'] ?? [];
                            $link = $menu_item['link'] ?? '';
                            $submenu_style = $has_submenu ? $menu_item['submenu_style'] : 'simple' ;
                            $has_megamenu = $submenu_style === 'mega-menu';
                        ?>
                        <li class="js-mobile-nav__item">
                            <a 
                                href="<?php echo $link['url'] ?>" 
                                target="<?php echo $link['target'] ?: '_self' ?>"
                                class="text-xl font-semibold text-purple-950! <?php echo $has_submenu ? 'js-mobile-nav-item__toggle flex justify-between items-center data-[state=open]:[&_svg]:scale-y-[-1] [&_svg]:transition-all [&_svg]:duration-200 [&_svg]:ease-in-out' : '' ?>"
                                <?php if ($has_submenu): ?>
                                    aria-controls="mobile-nav-submenu-<?php echo $i ?>"
                                <?php endif; ?>
                            >
                                <?php echo $link['title'] ?>
                                <?php if ($has_submenu): ?>
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path style="fill:none !important;" d="M5 7.5L10 12.5L15 7.5" stroke="#120445" stroke-opacity="0.7" stroke-width="2" stroke-linecap="square"/></svg>
                                <?php endif; ?>
                            </a>

                            <?php if ( $has_submenu ) : ?>
                                <ul id="<?php echo 'mobile-nav-submenu-' . $i ?>" 
                                    class="flex flex-col list-none pl-4 mt-2 js-mobile-nav-item__submenu data-[state=closed]:hidden [data-state=closed]:invisible data-[state=closed]:opacity-0 data-[state=open]:flex data-[state=open]:visible data-[state=open]:opacity-100 transition-all duration-350"
                                    data-state="closed"
                                    aria-expanded="false"
                                    aria-hidden="true"
                                >
                                    <?php foreach ( $submenu as $submenu_item ) : ?>
                                        <?php
                                            $submenu_link = $submenu_item['link'] ?? [];
                                        ?>
                                        <li>
                                            <a class="block font-medium text-purple-950! py-3" href="<?php echo $submenu_link['url'] ?>" target="<?php echo $submenu_link['target'] ?: '_self' ?>">
                                                <?php echo $submenu_link['title'] ?>
                                            </a>
                                        </li>
                                    <?php endforeach ?>
                                </ul>
                                <?php $i++; ?>
                            <?php endif ?>
                        </li>
                    <?php endforeach ?>
                </ul>
            <?php endif ?>
        </div>
    </div>
</div>

<?php if ( $parent_class_name ) : ?>
    <script>
        document.querySelector('.js-header').classList.add(...<?php echo json_encode(explode(' ', trim($parent_class_name))); ?>);
    </script>
<?php endif ?>

