import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
const path = require("path");

export default defineConfig({
  plugins: [
    vue(),
    laravel({
      input: ["resources/css/app.css", "resources/js/app.js"],
      refresh: true,
    }),
  ],
  server: {
    host: true,
    hmr: {
      host: "localhost",
    },
  },
  resolve: {
    alias: {
      "@": "/resources/js",
      "~bootstrap": path.resolve(__dirname, "node_modules/bootstrap"),
    },
  },
});
