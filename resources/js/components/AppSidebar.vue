<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { 
  Sidebar, 
  SidebarContent, 
  SidebarFooter, 
  SidebarHeader, 
  SidebarMenu, 
  SidebarMenuButton, 
  SidebarMenuItem,
  SidebarGroup,
  SidebarGroupLabel,
  SidebarGroupContent
} from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { BookOpen, Folder, LayoutGrid, Tag } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

// Типы для категорий
interface Category {
  id: number;
  name: string;
  slug: string;
  posts_count: number;
}

// Пропсы компонента
defineProps<{
  categories?: Category[];
}>();

const mainNavItems: NavItem[] = [
    {
        title: 'All news',
        href: '/dashboard',
        icon: LayoutGrid,
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'Github Repo',
        href: 'https://github.com/laravel/vue-starter-kit',
        icon: Folder,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits#vue',
        icon: BookOpen,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('dashboard')">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <!-- Основная навигация -->
            <NavMain :items="mainNavItems" />
            
            <!-- Категории новостей -->
            <SidebarGroup v-if="categories && categories.length > 0">
                <SidebarGroupContent>
                    <SidebarMenu>
                        <SidebarMenuItem v-for="category in categories" :key="category.id">
                            <SidebarMenuButton as-child>
                                <Link 
                                  :href="`/news/category/${category.slug}`"
                                  class="flex items-center justify-between w-full"
                                >
                                    <div class="flex items-center gap-2">
                                        <Tag class="h-4 w-4" />
                                        <span>{{ category.name }}</span>
                                    </div>
                                    <span 
                                      v-if="category.posts_count > 0" 
                                      class="text-xs text-muted-foreground bg-muted px-1.5 py-0.5 rounded-full"
                                    >
                                        {{ category.posts_count }}
                                    </span>
                                </Link>
                            </SidebarMenuButton>
                        </SidebarMenuItem>
                    </SidebarMenu>
                </SidebarGroupContent>
            </SidebarGroup>
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
</template>