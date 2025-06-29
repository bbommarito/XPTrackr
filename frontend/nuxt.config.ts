// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: '2025-05-15',
  devtools: { enabled: true },
  modules: [],
  
  // Development server configuration
  devServer: {
    host: '0.0.0.0',
    port: 3000
  },
  
  // Proxy configuration for API requests
  nitro: {
    devProxy: {
      '/api': {
        target: process.env.NUXT_API_TARGET || 'http://localhost:3000',
        changeOrigin: true
      },
      '/health': {
        target: process.env.NUXT_API_TARGET || 'http://localhost:3000',
        changeOrigin: true
      }
    }
  },
  
  // Runtime config for environment variables
  runtimeConfig: {
    // Private keys (only available on server-side)
    // Public keys (exposed to client-side)
    public: {
      apiBase: process.env.NUXT_PUBLIC_API_BASE || '/api'
    }
  }
})
