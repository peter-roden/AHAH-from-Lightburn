import * as esbuild from 'esbuild';
import { entryPoints } from './build.mjs';

const ctx = await esbuild.context({
    entryPoints,
    outdir: './assets',
    bundle: true,
    minify: false,
    sourcemap: 'inline',
    plugins: [],
    define: { global: 'window' }
});

console.log('Watching...');
await ctx.watch();