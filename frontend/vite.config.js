import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";
import { fileURLToPath, URL } from "node:url";
import dotenv from "dotenv";

// Load environment variables from .env
const env = dotenv.config().parsed;

export default defineConfig({
    plugins: [vue()],
    resolve: {
        alias: {
            "@": fileURLToPath(new URL("./src",
                import.meta.url)),
        },
    },
    define: {
        "process.env": env,
    },
});