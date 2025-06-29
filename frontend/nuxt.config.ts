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
  
  // Runtime config
  runtimeConfig: {
    // Private keys (only available on server-side)
    backendUrl: process.env.NUXT_API_TARGET || 'http://localhost:3000',
    // Public keys (exposed to client-side)
    public: {
      apiBase: process.env.NUXT_PUBLIC_API_BASE || '/api'
    }
  }
})
