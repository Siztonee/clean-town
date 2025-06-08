<template>
  <div class="min-h-screen bg-gray-900 text-gray-100">
    <!-- Боковое меню -->
    <div 
      class="fixed inset-y-0 left-0 w-64 bg-gray-800 p-6 shadow-xl transform transition-transform duration-300 z-30 lg:translate-x-0"
      :class="isSidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    >
      <div class="flex items-center space-x-2 mb-12">
        <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"
          />
        </svg>
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
          <svg
            :class="['w-5 h-5 mr-3', tab.icon]"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              :d="tab.iconPath"
            />
          </svg>
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
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16"
              />
            </svg>
          </button>
          <h1 class="text-xl lg:text-2xl font-bold text-white">{{ props.title }}</h1>
        </div>
        
        <div class="flex items-center space-x-4">
            <div class="h-10 w-10 rounded-full bg-emerald-500 flex items-center justify-center text-white font-medium">
              A
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
    iconPath:
      "M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10",
    url: "/admin"
  },
  {
    id: "events",
    title: "Мероприятия",
    icon: "text-emerald-400",
    iconPath:
      "M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10",
    url: "/admin/events"
  },
  {
    id: "gallery",
    title: "Галерея",
    icon: "text-blue-400",
    iconPath:
      "M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z",
    url: "/admin/gallery"
  },
  {
    id: "teamMembers",
    title: "Команда",
    icon: "text-purple-400",
    iconPath: "M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z",
    url: "/admin/team-members"
  },
  {
    id: "faq",
    title: "FAQ",
    icon: "text-purple-400",
    iconPath: "M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z",
    url: "/admin/faq"
  },
  {
    id: "stats",
    title: "Stats",
    icon: "text-purple-400",
    iconPath: "M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z",
    url: "/admin/stats"
  },
  {
    id: "history",
    title: "History",
    icon: "text-purple-400",
    iconPath: "M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z",
    url: "/admin/history"
  },
];

const activeTab = props.activeTab;
</script>
