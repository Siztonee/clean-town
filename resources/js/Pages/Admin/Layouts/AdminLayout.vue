<template>
  <div class="min-h-screen bg-gray-900 text-gray-100">
    <!-- Боковое меню -->
    <div 
      class="fixed inset-y-0 left-0 w-64 bg-gray-800 p-6 shadow-xl transform transition-transform duration-300 z-30 lg:translate-x-0"
      :class="isSidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    >
      <div class="flex items-center space-x-2 mb-12">
        <i class="fas fa-leaf text-emerald-500 text-2xl"></i>
        <span class="text-xl font-bold text-white">CleanTown Admin</span>
      </div>

      <nav class="space-y-2">
        <Link
          v-for="(tab, index) in tabs"
          :key="index"
          :href="tab.url"
          :class="[
            'w-full text-left px-4 py-3 rounded-lg flex items-center transition-colors',
            activeTab === tab.id
              ? 'bg-emerald-600/20 text-emerald-400'
              : 'text-gray-300 hover:bg-gray-700',
          ]"
        >
          <i :class="[tab.faIcon, 'mr-3 text-xl', tab.icon]"></i>
          {{ tab.title }}
        </Link>
      </nav>
    </div>

    <!-- Оверлей для мобильного меню -->
    <div 
      v-if="isSidebarOpen"
      @click="isSidebarOpen = false"
      class="fixed inset-0 z-20 bg-black bg-opacity-50 lg:hidden"
    ></div>

    <div class="lg:ml-64 p-4 lg:p-8">

      <header class="mb-6 lg:mb-8 flex justify-between items-center">
        <div class="flex items-center">
          <button @click="isSidebarOpen = !isSidebarOpen"
            class="lg:hidden p-2 mr-3 rounded-lg text-gray-400 hover:bg-gray-800 hover:text-white"
          >
            <i class="fas fa-bars text-xl"></i>
          </button>
          <h1 class="text-xl lg:text-2xl font-bold text-white">{{ props.title }}</h1>
        </div>
        
        <div class="flex items-center space-x-4">
            <div class="h-10 w-10 rounded-full bg-emerald-500 flex items-center justify-center text-white font-medium">
              <i class="fas fa-user-shield"></i>
            </div>
            <span class="hidden md:block">Администратор</span>
        </div>
      </header>

      <div class="bg-gray-800 rounded-xl p-6 shadow-lg">
        <slot :active-tab="activeTab"></slot>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from "vue";
import { Link } from '@inertiajs/vue3';

const props = defineProps({
  title: String,
  activeTab: String
})

const isSidebarOpen = ref(false);

const checkScreenSize = () => {
  isSidebarOpen.value = window.innerWidth >= 1024;
};

onMounted(() => {
  checkScreenSize();
  window.addEventListener('resize', checkScreenSize);
});

onUnmounted(() => {
  window.removeEventListener('resize', checkScreenSize);
});

const tabs = [
  {
    id: "dashboard",
    title: "Главная",
    icon: "text-emerald-400",
    faIcon: "fas fa-home",
    url: "/admin"
  },
  {
    id: "events",
    title: "Мероприятия",
    icon: "text-amber-400",
    faIcon: "fas fa-calendar-check",
    url: "/admin/events"
  },
  {
    id: "gallery",
    title: "Галерея",
    icon: "text-sky-400",
    faIcon: "fas fa-images",
    url: "/admin/galleries"
  },
  {
    id: "teamMembers",
    title: "Команда",
    icon: "text-violet-400",
    faIcon: "fas fa-users",
    url: "/admin/team-members"
  },
  {
    id: "faq",
    title: "FAQ",
    icon: "text-rose-400",
    faIcon: "fas fa-question-circle",
    url: "/admin/faq"
  },
  {
    id: "stats",
    title: "Статистика",
    icon: "text-cyan-400",
    faIcon: "fas fa-chart-line",
    url: "/admin/stats"
  },
  {
    id: "history",
    title: "История",
    icon: "text-yellow-400",
    faIcon: "fas fa-landmark",
    url: "/admin/history"
  },
];

const activeTab = props.activeTab;
</script>