<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import NewsCard from '@/components/NewsCard.vue';
import {
  Pagination,
  PaginationContent,
  PaginationEllipsis,
  PaginationItem,
  PaginationNext,
  PaginationPrevious,
} from '@/components/ui/pagination';

const props = defineProps<{
  posts: {
    data: Array<any>,
    current_page: number,
    last_page: number,
    per_page: number,
    total: number,
    from: number,
    to: number,
    links: Array<{
      url: string | null,
      label: string,
      active: boolean
    }>
  }
  categories?: Array<{
    id: number;
    name: string;
    slug: string;
    posts_count: number;
  }>;
}>();

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'News',
    href: '/dashboard',
  },
];

// Функция для перехода на страницу
function goToPage(page: number) {
  if (page >= 1 && page <= props.posts.last_page && page !== props.posts.current_page) {
    router.get(window.location.pathname, { page }, {
      preserveState: true,
      replace: true,
      only: ['posts']
    });
  }
}
</script>

<template>
  <Head title="News" />

  <AppLayout :breadcrumbs="breadcrumbs" :categories="categories">
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
      <div class="hidden sm:grid auto-rows-min gap-4 md:grid-cols-3">
        <div
          class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
        >
          <PlaceholderPattern />
        </div>
        <div
          class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
        >
          <PlaceholderPattern />
        </div>
        <div
          class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
        >
          <PlaceholderPattern />
        </div>
      </div>

      <!-- Карточки новостей -->
      <NewsCard v-for="post in posts.data" :key="post.id" :post="post" />

      <!-- Пагинация -->
      <div v-if="posts.last_page > 1" class="mt-6">
        <Pagination 
          v-slot="{ page }" 
          :itemsPerPage="posts.per_page" 
          :total="posts.total" 
          :defaultPage="posts.current_page"
          @update:page="goToPage"
        >
          <PaginationContent v-slot="{ items }">
            <PaginationPrevious />
            
            <template v-for="(item, index) in items" :key="index">
              <PaginationItem
                v-if="item.type === 'page'"
                :value="item.value"
                :is-active="item.value === page"
              >
                {{ item.value }}
              </PaginationItem>
              <PaginationEllipsis 
                v-else-if="item.type === 'ellipsis'"
                :index="index" 
              />
            </template>
            
            <PaginationNext />
          </PaginationContent>
        </Pagination>
        
      </div>
    </div>
  </AppLayout>
</template>