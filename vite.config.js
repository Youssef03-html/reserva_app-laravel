// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/sass/app.scss', 'resources/js/app.js'],
      refresh: true,
    }),
  ],
  server: {
    host: 'reserva-app.local',
    hmr: {
      host: 'reserva-app.local',
    },
    cors: true,
  },
});
