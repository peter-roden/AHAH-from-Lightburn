import * as esbuild from 'esbuild';

export const entryPoints = {
    'js/dist/accordions': './assets/js/src/accordions.js',
    'js/dist/posts-list': './assets/js/src/posts-list.js',
    'js/dist/global': './assets/js/src/global.js',
    'js/dist/tabs': './assets/js/src/tabs.js'
};

const ctx = await esbuild.context({
    entryPoints,
    outdir: './assets',
    bundle: true,
    minify: true,
    sourcemap: false,
    plugins: [],
    define: { global: 'window' }
});

await ctx.rebuild();
ctx.dispose();