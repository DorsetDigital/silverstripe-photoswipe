import { defineConfig } from 'vite';

export default defineConfig({
  build: {
    outDir: 'client/dist',
    emptyOutDir: true,
    lib: {
      entry: 'client/src/gallery.js',
      formats: ['es'],
      fileName: () => 'gallery.js',
    },
    rollupOptions: {
      output: {
        assetFileNames: (assetInfo) => assetInfo.name === 'style.css' ? 'gallery.css' : '[name][extname]',
      },
    },
  },
});
