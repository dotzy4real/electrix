import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [react()],
  build: {
    outDir: 'build', // Specify the output directory for the build files
    sourcemap: true, // Generate sourcemaps for debugging (optional)
    minify: 'esbuild', // Use esbuild for minification (faster)
    rollupOptions: {
      // Custom Rollup options (optional)
      output: {
        // Customize output chunks (optional)
        manualChunks: undefined, // Disable default chunk splitting
      },
    },
  },
});