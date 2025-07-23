<script setup lang="ts">
import { ref, watch, computed } from 'vue'
import { router } from '@inertiajs/vue3'
import { useMagicKeys } from '@vueuse/core'

import {
  CommandDialog,
  CommandEmpty,
  CommandGroup,
  CommandInput,
  CommandItem,
  CommandList
} from '@/components/ui/command'

const props = defineProps<{
  posts: Array<{
    id: number
    title: string
    content: string
    slug: string
  }>
}>()

const open = ref(false)
const search = ref('')

const { Meta_F, Ctrl_F } = useMagicKeys({
  passive: false,
  onEventFired(e) {
    if (e.key === 'f' && (e.metaKey || e.ctrlKey)) e.preventDefault()
  },
})

watch([Meta_F, Ctrl_F], (v) => {
  if (v[0] || v[1]) open.value = true
})

const filteredPosts = computed(() => {
  const q = search.value.toLowerCase()
  return props.posts.filter(post =>
    post.title.toLowerCase().includes(q) ||
    post.content.toLowerCase().includes(q)
  )
})

function goToPost(slug: string) {
  open.value = false
  router.visit(`/news/${slug}`)
}
</script>

<template>
  <CommandDialog v-model:open="open">
    <CommandInput v-model="search" placeholder="Search articles..." />
    <CommandList>
      <CommandEmpty>Nothing found</CommandEmpty>
      <CommandGroup heading="Posts">
        <CommandItem
          v-for="post in filteredPosts"
          :key="post.id"
          :value="post.title"
          @select="goToPost(post.slug)"
        >
          <div>
            <div class="font-medium">{{ post.title }}</div>
            <div class="text-xs text-gray-500 truncate">{{ post.content }}</div>
          </div>
        </CommandItem>
      </CommandGroup>
    </CommandList>
  </CommandDialog>
</template>
