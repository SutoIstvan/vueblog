<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, Link, usePage, router } from '@inertiajs/vue3'
import { Lightbulb } from 'lucide-vue-next'
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert'
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar'
import { Textarea } from '@/components/ui/textarea'
import { Button } from '@/components/ui/button'
import { ref } from 'vue'
import { type BreadcrumbItem } from '@/types'

const props = defineProps<{
  post: {
    id: number
    title: string
    content: string
    image: string
    created_at: string
    user: {
      id: number
      name: string
      avatar?: string
    }
  }
  comments?: Array<{
    id: number
    body: string
    created_at: string
    user: {
      id: number
      name: string
      avatar?: string
    }
  }>
  categories?: Array<{
    id: number
    name: string
    slug: string
    posts_count: number
  }>
}>()

const newComment = ref('')
const commentsList = ref(props.comments || [])
const auth = usePage().props.auth

function submitComment() {
  if (!auth.user) {
    alert('Вы должны быть авторизованы для комментирования.')
    return
  }

  if (!newComment.value.trim()) return

  router.post(`/posts/${props.post.id}/comments`, {
    body: newComment.value,
  }, {
    preserveScroll: true,
    onSuccess: () => {
      commentsList.value.unshift({
        id: Date.now(),
        body: newComment.value,
        created_at: new Date().toISOString(),
        user: auth.user,
      })
      newComment.value = ''
    }
  })
}

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'News', href: '/news' },
  { title: props.post.title, href: `/news/${props.post.id}` },
]
</script>

<template>
  <Head :title="post.title" />

  <AppLayout :breadcrumbs="breadcrumbs" :categories="categories">
    <section class="py-15 px-15">
      <div class="container">
        <div class="mx-auto flex max-w-5xl flex-col items-center gap-4 text-center">
          <h3 class="max-w-3xl text-pretty text-5xl font-semibold md:text-6xl">
            {{ post.title }}
          </h3>

          <div class="flex items-center gap-3 text-sm md:text-base">
            <Avatar class="h-8 w-8 border">
              <AvatarImage :src="post.user.avatar ?? `https://ui-avatars.com/api/?name=${post.user.name}`" />
              <AvatarFallback>{{ post.user.name.charAt(0) }}</AvatarFallback>
            </Avatar>
            <span>
              <span class="font-semibold">{{ post.user.name }}</span>
              <span class="ml-1">— {{ post.created_at }}</span>
            </span>
          </div>

          <img :src="post.image" alt="Изображение поста"
            class="mb-8 mt-4 aspect-video w-full rounded-lg border object-cover ms-3 me-3" />
        </div>
      </div>

      <Alert class="mb-4">
        <Lightbulb class="h-4 w-4" />
        <AlertTitle>Image source:</AlertTitle>
        <AlertDescription>
          1st level of puns: 5 gold coins.
        </AlertDescription>
      </Alert>

      <div class="container">
        <div class="prose dark:prose-invert mx-auto max-w-3xl" v-html="post.content"></div>

        <div class="mt-8 text-center">
          <Link href="/news" class="text-blue-600 hover:underline">&larr; Назад ко всем новостям</Link>
        </div>
      </div>

      <!-- Комментарии -->
      <div class="mt-16 max-w-3xl mx-auto px-4">
        <h2 class="text-2xl font-bold mb-4">Комментарии</h2>

        <!-- Форма отправки -->
        <div v-if="auth.user" class="mb-8 grid gap-2">
          <Textarea v-model="newComment" placeholder="Напишите ваш комментарий..."
            class="resize-none rounded-md border border-input bg-background p-3 text-sm shadow-sm" />
          <Button class="w-fit" @click="submitComment">Отправить</Button>
        </div>
        <div v-else class="mb-8 text-sm text-gray-500">Авторизуйтесь, чтобы оставить комментарий.</div>

        <!-- Список комментариев -->
        <div class="space-y-6">
          <div v-for="comment in commentsList" :key="comment.id" class="flex items-start gap-4">
            <Avatar class="h-10 w-10 border">
              <AvatarImage :src="comment.user.avatar ?? `https://ui-avatars.com/api/?name=${comment.user.name}`" />
              <AvatarFallback>{{ comment.user.name.charAt(0) }}</AvatarFallback>
            </Avatar>
            <div class="grid gap-1.5">
              <div class="flex items-center gap-2">
                <div class="font-medium">{{ comment.user.name }}</div>
                <div class="text-xs text-muted-foreground">{{ comment.created_at }}</div>
              </div>
              <div class="text-sm text-muted-foreground">{{ comment.body }}</div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </AppLayout>
</template>

<style scoped>
.prose img {
  max-width: 100%;
  height: auto;
}
</style>
