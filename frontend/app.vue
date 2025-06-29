<template>
  <div>
    <NuxtRouteAnnouncer />
    <div class="app-header">
      <h1>XPTrackr</h1>
      <HealthStatus />
    </div>
    <NuxtWelcome />
  </div>
</template>

<style scoped>
.app-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px;
  background-color: #f8fafc;
  border-bottom: 1px solid #e2e8f0;
}

.app-header h1 {
  margin: 0;
  color: #1e293b;
  font-size: 24px;
  font-weight: 600;
}
</style>
