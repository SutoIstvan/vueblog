<script setup lang="ts">
import { ref, computed } from 'vue'
import { ArrowRight, MessageCircle } from 'lucide-vue-next'
import { Link } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import { Card } from '@/components/ui/card'
import { Skeleton } from '@/components/ui/skeleton'

interface Post {
  id: string
  slug: string
  title: string
  content: string
  label: string
  user: {
    id: number
    name: string
  } | null
  published_at: string
  image: string
  tags?: string[]
  comments_count?: number // Добавляем количество комментариев
}

// Получаем props
const props = defineProps<{ post: Post }>()

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

const postUrl = computed(() => route('post.show', { slug: props.post.slug }))
</script>

<template>
  <Card class="border-0 bg-transparent shadow-none">
    <div class="grid gap-y-6 sm:grid-cols-10 sm:gap-x-5 sm:gap-y-0 md:items-center md:gap-x-8 lg:gap-x-12">
      <!-- Image -->
      <div class="-mt-1 sm:mt-7 sm:col-span-4 relative">
        <Link :href="postUrl" class="block">
          <div class="aspect-[16/11] overflow-hidden rounded-lg border border-border relative">
            <Skeleton v-if="loadingImage" class="absolute inset-0" />
            <img
              v-show="!loadingImage"
              :src="props.post.image"
              :alt="props.post.title"
              class="h-full w-full object-cover transition-opacity duration-200 hover:opacity-70"
              @load="onImageLoad"
            />
          </div>
        </Link>
      </div>

      <!-- Text Content -->
      <div class="sm:col-span-6">
        <h3 class="text-lg font-semibold sm:text-base md:text-lg lg:text-xl mt-3 md:mt-3">
          <Link :href="postUrl" class="hover:underline">
            {{ props.post.title }}
          </Link>
        </h3>

        <p class="mt-3 text-muted-foreground md:mt-3">
          {{ props.post.content?.substring(0, 190) }}...
        </p>

        <div class="mt-3 flex justify-between items-center md:mt-3">
          <Link :href="postUrl" class="inline-flex items-center font-semibold hover:underline md:text-base">
            <span>Read more</span>
            <ArrowRight class="ml-2 h-4 w-4 transition-transform" />
          </Link>

          <div class="flex items-center space-x-4 text-sm text-muted-foreground me-4">
            <span>{{ props.post.user?.name ?? 'Unknown' }}</span>
            <span>•</span>
            <span>{{ formatDate(props.post.published_at) }}</span>
            <!-- Добавляем количество комментариев -->
            <span v-if="props.post.comments_count !== undefined">•</span>
            <div v-if="props.post.comments_count !== undefined" class="flex items-center space-x-1">
              <MessageCircle class="h-4 w-4" />
              <span>{{ props.post.comments_count }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </Card>
</template>