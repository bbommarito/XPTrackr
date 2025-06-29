<template>
  <div class="health-status">
    <div class="status-indicator" :class="statusClass">
      <div class="status-dot"></div>
      <span class="status-text">{{ statusText }}</span>
    </div>
    <div v-if="error" class="error-message">
      {{ error }}
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const status = ref('checking')
const error = ref(null)

const statusClass = computed(() => {
  switch (status.value) {
    case 'ok': return 'status-active'
    case 'error': return 'status-inactive'
    default: return 'status-checking'
  }
})

const statusText = computed(() => {
  switch (status.value) {
    case 'ok': return 'Backend Active'
    case 'error': return 'Backend Inactive'
    default: return 'Checking...'
  }
})

const checkHealth = async () => {
  try {
    status.value = 'checking'
    error.value = null
    
    const response = await $fetch('/health')
    
    // Handle different response types
    if (typeof response === 'object' && response.status === 'ok') {
      status.value = 'ok'
    } else if (typeof response === 'string' && response.includes('Rails')) {
      // We're getting the Rails welcome page - proxy issue
      status.value = 'error'
      error.value = 'Proxy configuration issue - getting Rails welcome page'
    } else {
      status.value = 'error'
      error.value = `Unexpected response: ${typeof response}`
    }
  } catch (err) {
    status.value = 'error'
    error.value = err.message || 'Failed to connect to backend'
  }
}

onMounted(() => {
  checkHealth()
  // Check health every 30 seconds
  setInterval(checkHealth, 30000)
})
</script>

<style scoped>
.health-status {
  display: inline-flex;
  flex-direction: column;
  align-items: flex-start;
  gap: 4px;
}

.status-indicator {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 4px 8px;
  border-radius: 4px;
  font-size: 14px;
  font-weight: 500;
}

.status-dot {
  width: 8px;
  height: 8px;
  border-radius: 50%;
}

.status-active {
  background-color: #dcfce7;
  color: #166534;
}

.status-active .status-dot {
  background-color: #22c55e;
}

.status-inactive {
  background-color: #fef2f2;
  color: #991b1b;
}

.status-inactive .status-dot {
  background-color: #ef4444;
}

.status-checking {
  background-color: #fef3c7;
  color: #92400e;
}

.status-checking .status-dot {
  background-color: #f59e0b;
  animation: pulse 2s infinite;
}

.error-message {
  font-size: 12px;
  color: #991b1b;
  background-color: #fef2f2;
  padding: 4px 8px;
  border-radius: 4px;
  border-left: 3px solid #ef4444;
}

@keyframes pulse {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.5; }
}
</style>
