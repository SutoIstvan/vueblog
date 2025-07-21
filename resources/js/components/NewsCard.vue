<script setup lang="ts">
import { ref } from 'vue'
import { ArrowRight } from 'lucide-vue-next'
import { Card } from '@/components/ui/card'
import { Skeleton } from '@/components/ui/skeleton'

interface Post {
  id: string
  title: string
  content: string
  label: string
  user: {
    id: number
    name: string
  } | null
  published_at: string
  url: string
  image: string
  tags?: string[]
}

defineProps<{ post: Post }>()

const loadingImage = ref(true)

function onImageLoad() {
  loadingImage.value = false
}

function formatDate(date: string): string {
  if (!date) return ''
  return new Date(date).toLocaleDateString('en-GB', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
  })
}

</script>

<template>
  <Card class="border-0 bg-transparent shadow-none">
    <div class="grid gap-y-6 sm:grid-cols-10 sm:gap-x-5 sm:gap-y-0 md:items-center md:gap-x-8 lg:gap-x-12">
      
      <!-- Image -->
      <div class="-mt-1 sm:mt-7 sm:col-span-4 relative">
        <a :href="post.url" target="_blank" class="block">
          <div class="aspect-[16/11] overflow-hidden rounded-lg border border-border relative">
            <Skeleton v-if="loadingImage" class="absolute inset-0" />
            <img
              v-show="!loadingImage"
              :src="post.image"
              :alt="post.title"
              class="h-full w-full object-cover transition-opacity duration-200 hover:opacity-70"
              @load="onImageLoad"
            />
          </div>
        </a>
      </div>

      <!-- Text Content -->
      <div class="sm:col-span-6">
        <h3 class="text-lg font-semibold sm:text-base md:text-lg lg:text-xl mt-3 md:mt-3">
          <a :href="post.url" target="_blank" class="hover:underline">
            {{ post.title }}
          </a>
        </h3>

        <p class="mt-3 text-muted-foreground md:mt-3">
          {{ post.content?.substring(0, 190) }}...
        </p>

        <div class="mt-3 flex justify-between items-center md:mt-3">
          <a :href="post.url" target="_blank" class="inline-flex items-center font-semibold hover:underline md:text-base">
            <span>Read more</span>
            <ArrowRight class="ml-2 h-4 w-4 transition-transform" />
          </a>

          <div class="flex items-center space-x-4 text-sm text-muted-foreground me-4">
            <span>{{ post.user?.name ?? 'Unknown' }}</span>
            <span>•</span>
            <span>{{ formatDate(post.published_at) }}</span>
          </div>
        </div>
      </div>
    </div>
  </Card>
</template>
