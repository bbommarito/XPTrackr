export default defineEventHandler(async (event) => {
  const config = useRuntimeConfig()

  try {
    const response = await $fetch(`${config.backendUrl}/health`)
    return response
  } catch (error) {
    throw createError({
      statusCode: 503,
      statusMessage: 'Backend health check failed',
      data: { error: error.message }
    })
  }
})
