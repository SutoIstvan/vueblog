<script setup lang="ts">
import AppContent from '@/components/AppContent.vue';
import AppShell from '@/components/AppShell.vue';
import AppSidebar from '@/components/AppSidebar.vue';
import RightSidebar from '@/components/RightSidebar.vue';
import AppSidebarHeader from '@/components/AppSidebarHeader.vue';
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

const props = defineProps<{
  breadcrumbs?: BreadcrumbItemType[];
  categories?: Array<{
    id: number;
    name: string;
    slug: string;
    posts_count: number;
  }>;
}>();

</script>

<template>
    <AppShell variant="sidebar" class="relative max-w-[1440px] mx-auto">
        <AppSidebar :categories="categories" />
        <AppContent variant="sidebar" class="overflow-x-hidden">
            <AppSidebarHeader :breadcrumbs="breadcrumbs" />
            <slot />
        </AppContent>
        <RightSidebar class="hidden lg:block" />
    </AppShell>
</template>
