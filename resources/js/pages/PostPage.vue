<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, Link, usePage, router } from '@inertiajs/vue3'
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert'
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar'
import { Textarea } from '@/components/ui/textarea'
import { Button } from '@/components/ui/button'
import { Toaster } from '@/components/ui/sonner'
import { ref, computed } from 'vue'
import { type BreadcrumbItem } from '@/types'
import { Lightbulb, Send, ChevronLeft } from 'lucide-vue-next'
import { toast } from 'vue-sonner'
import 'vue-sonner/style.css'

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
  }
  categories?: Array<{
    id: number
    name: string
    slug: string
    posts_count: number
  }>
}>()

const newComment = ref('')
const commentsList = ref(props.post.comments || [])
const auth = usePage().props.auth
const visibleCommentsCount = ref(3) // Показываем по 3 комментария изначально
const commentsPerPage = 3 // Загружаем по 3 комментария за раз

function submitComment() {
  if (!auth.user) {
    toast.error('Вы должны быть авторизованы для комментирования.')
    return
  }

  if (!newComment.value.trim()) {
    toast.error('Пожалуйста, введите текст комментария')
    return
  }

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
      // При добавлении нового комментария показываем его (увеличиваем счетчик если нужно)
      if (visibleCommentsCount.value < commentsList.value.length) {
        visibleCommentsCount.value++
      }
      toast.success('Комментарий успешно добавлен!')
    },
    onError: () => {
      toast.error('Ошибка при добавлении комментария')
    }
  })
}

function showMoreComments() {
  visibleCommentsCount.value += commentsPerPage
}

// Вычисляемые свойства для отображения комментариев
const visibleComments = computed(() => {
  return commentsList.value.slice(0, visibleCommentsCount.value)
})

const hasMoreComments = computed(() => {
  return commentsList.value.length > visibleCommentsCount.value
})

function formatDate(date: string): string {
  if (!date) return ''
  return new Date(date).toLocaleDateString('en-GB', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
  })
}

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'News', href: '/news' },
  { title: props.post.title, href: `/news/${props.post.id}` },
]
</script>

<template>
  <Head :title="post.title" />
  
  <Toaster />

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
              <span class="ml-1">— {{ formatDate(props.post.created_at) }}</span>
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
          <Link href="/news">
          <Button variant="outline" class="w-fit cursor-pointer">
            <ChevronLeft class="h-4 w-4 mr-2" />
              Back to all news
          </Button>
          </Link>
        </div>
      </div>

      <!-- Комментарии -->
      <div class="mt-16 max-w-3xl mx-auto px-4">
        <h2 class="text-2xl font-bold mb-1">Comments</h2>
        <div class="mb-5 text-md text-gray-500">Here you can leave your comment to the post.</div>

        <!-- Форма отправки -->
        <div v-if="auth.user" class="mb-8 grid gap-2">
          <Textarea 
            v-model="newComment" 
            placeholder="Write your comment..."
            class="resize-none rounded-md border border-input bg-background p-3 text-sm shadow-sm" 
          />

          <div class="flex justify-end mt-2">
            <Button 
              variant="outline" 
              class="w-fit cursor-pointer" 
              @click="submitComment"
              :disabled="!newComment.trim()"
            >
              <Send class="h-4 w-4 mr-2" />
              Send
            </Button>
          </div>
        </div>
        <div v-else class="mb-8 text-sm text-gray-500">Please log in to leave a comment.</div>

        <!-- Список комментариев -->
        <div class="space-y-6">
          <div v-for="comment in visibleComments" :key="comment.id" class="flex items-start gap-4">
            <Avatar class="h-10 w-10 border">
              <AvatarImage :src="comment.user.avatar ?? `https://ui-avatars.com/api/?name=${comment.user.name}`" />
              <AvatarFallback>{{ comment.user.name.charAt(0) }}</AvatarFallback>
            </Avatar>
            <div class="grid gap-1.5">
              <div class="flex items-center gap-2">
                <div class="font-medium">{{ comment.user.name }}</div>
                <div class="text-xs text-muted-foreground">{{ formatDate(comment.created_at) }}</div>
              </div>
              <div class="text-sm text-muted-foreground">{{ comment.body }}</div>
            </div>
          </div>
          
          <!-- Кнопка "Показать больше" -->
          <div v-if="hasMoreComments" class="flex justify-center pt-4">
            <Button 
              variant="outline" 
              @click="showMoreComments"
              class="w-fit"
            >
              Show more comments ({{ commentsList.length - visibleCommentsCount }} remaining)
            </Button>
          </div>
          
          <!-- Сообщение если комментариев нет -->
          <div v-if="commentsList.length === 0" class="text-center text-muted-foreground py-8">
            There are no comments yet. Be the first!
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