const themeColors = [
    '#f0e2f7', // purple-100
    '#b26eff', // purple-400
    '#9358d6', // purple-500
    '#5a1482', // purple-700
    '#120445', // purple-950
    '#e3f9eb', // green-100
    '#0b3d1e', // green-950
    '#ffffff', // white
    '#fafafa', // neutral-50
    '#f4f4f4', // neutral-100
    '#000000'  // black
];

// Unregister block types
const unregisterBlockTypes = () => {
    const blocks = [
        'core/media-text',
        'core/spacer'
    ];

    blocks.forEach(block => {
        wp.blocks.unregisterBlockType(block);
    });
};

// Allow only certain embed variants
// const allowEmbedBlockVariations = () => {
//     const allowed = [
//         'flickr',
//         'spotify',
//         'soundcloud',
//         'twitter',
//         'youtube',
//         'vimeo'
//     ];

//     wp.blocks.getBlockVariations('core/embed').forEach(variant => {
//         if (!allowed.includes(variant.name)) {
//             wp.blocks.unregisterBlockVariation('core/embed', variant.name);
//         }
//     });
// };

wp.domReady(() => {
    unregisterBlockTypes();
    // allowEmbedBlockVariations();
});

if (acf) {
    // define acf color picker colors
    acf.addFilter('color_picker_args', args => {
        args.palettes = themeColors;
        return args;
    });
}