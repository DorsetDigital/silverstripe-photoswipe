import { defineConfig } from 'vite';

export default defineConfig({
  build: {
    outDir: 'client/dist',
    emptyOutDir: true,
    rollupOptions: {
      input: {
        gallery: 'client/src/gallery.js',
        'gallery-styles': 'client/src/gallery.css',
        photoswipe: 'client/src/photoswipe.css',
      },
      output: {
        entryFileNames: (chunkInfo) => chunkInfo.name === 'gallery' ? 'gallery.js' : '[name].js',
        chunkFileNames: '[name]-[hash].mjs',
        assetFileNames: '[name][extname]',
      },
    },
  },
});
