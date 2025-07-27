<script setup>
import { computed } from 'vue'
import { Position, Handle } from '@vue-flow/core'

const props = defineProps({
  position: {
    type: Object,
    required: true,
  },
  data: {
    type: Object,
    required: true,
  }
})

const x = computed(() => `${Math.round(props.position.x)}px`)
const y = computed(() => `${Math.round(props.position.y)}px`)
</script>

<template>
  <div >
    <!-- Аватарка -->
    <img v-if="props.data.avatar" :src="props.data.avatar" alt="avatar" class="avatar" />

    <!-- Метка -->
    <div>{{ props.data.label }}</div>

    <!-- Координаты -->
    <div>
      {{ x }} {{ y }}
    </div>

    <!-- Ручка для соединения -->
    <Handle type="source" :position="Position.Bottom" />
  </div>
</template>

<style scoped>
.node-with-avatar {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 8px;
}

.avatar {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  object-fit: cover;
  margin-bottom: 6px;
  border: 2px solid #666;
}
</style>
