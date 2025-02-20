import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";
import path from "path";

// https://vite.dev/config/
export default defineConfig({
  plugins: [vue()],
  resolve: {
    alias: {
      "@": path.resolve(__dirname, "./src"),
      "@assets": path.resolve(__dirname, "./src/assets"),
    },
  },
  build: {
    assetsInlineLimit: 0, // Đảm bảo không inline ảnh
  },
  server: {
    host: "0.0.0.0", // Cho phép truy cập từ các thiết bị khác trong mạng
    port: 2001, // Cổng cho frontend
    strictPort: true, // Đảm bảo không thay đổi cổng
    proxy: {
      "/api": {
        target: "http://localhost/online-exam-website/backend/", // Địa chỉ backend (chỉnh theo cổng của backend)
        changeOrigin: true,
        rewrite: (path) => path.replace(/^\/api/, ""), // Rewrite nếu cần
      },
    },
  },
});
