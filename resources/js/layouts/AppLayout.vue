<script setup lang="ts">
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
import type { BreadcrumbItemType } from '@/types';

interface Props {
  breadcrumbs?: BreadcrumbItemType[];
  categories?: Array<{
    id: number;
    name: string;
    slug: string;
    posts_count: number;
  }>;
}

withDefaults(defineProps<Props>(), {
  breadcrumbs: () => [],
  categories: () => [],
});

</script>

<template>
  <AppLayout :breadcrumbs="breadcrumbs" :categories="categories">
    <slot />
  </AppLayout>
</template>
