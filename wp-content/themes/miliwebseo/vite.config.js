import { defineConfig } from 'vite';
import path from 'path';

export default defineConfig({
  build: {
    outDir: 'dist',
    rollupOptions: {
      input: {
        main: path.resolve(__dirname, 'src/main.js'),
        style: path.resolve(__dirname, 'src/main.css'),
      },
      output: {
        assetFileNames: 'assets/[name].[ext]',
        chunkFileNames: 'assets/[name].js',
        entryFileNames: 'assets/[name].js',
      },
    },
  },
  server: {
    cors: true,
    strictPort: true,
    port: 5173,
    hmr: {
      host: 'localhost',
    },
  },
});
