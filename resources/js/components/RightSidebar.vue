<script setup lang="ts">
import AppearanceTabs from '@/components/AppearanceTabs.vue';

</script>

<template>
  <div class="w-66 shrink-0 space-y-4 mt-2 me-3 ms-1">
    <AppearanceTabs />

    <div class="rounded-xl border p-4 dark:border-sidebar-border">
      <h2 class="text-lg font-semibold mb-2">Tags</h2>
      <div class="flex flex-wrap gap-2 text-sm">
        <span class="bg-gray-200 dark:bg-gray-700 px-2 py-1 rounded">Vue</span>
        <span class="bg-gray-200 dark:bg-gray-700 px-2 py-1 rounded">Laravel</span>
        <span class="bg-gray-200 dark:bg-gray-700 px-2 py-1 rounded">News</span>
      </div>
    </div>
  </div>
</template>
