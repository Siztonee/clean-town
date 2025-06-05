<template>
  <div class="min-h-screen bg-gray-900 text-gray-100">
    <!-- Боковое меню -->
    <div class="fixed inset-y-0 left-0 w-64 bg-gray-800 p-6 shadow-xl">
      <div class="flex items-center space-x-2 mb-12">
        <svg
          class="w-8 h-8 text-emerald-500"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
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

    <div class="ml-64 p-8">
      <!-- Хедер -->
      <header class="mb-8 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-white">{{ props.title }}</h1>
        <div class="flex items-center space-x-4">
          <button
            class="p-2 rounded-full text-gray-400 hover:bg-gray-800 hover:text-white"
          >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"
              />
            </svg>
          </button>
          <div class="flex items-center space-x-3">
            <div
              class="h-10 w-10 rounded-full bg-emerald-500 flex items-center justify-center text-white font-medium"
            >
              A
            </div>
            <span class="hidden md:block">Администратор</span>
          </div>
        </div>
      </header>
      <div class="bg-gray-800 rounded-xl p-6 shadow-lg">
        <slot :active-tab="activeTab"></slot>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  title: String,
  activeTab: String
})

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
];

const activeTab = props.activeTab;
</script>
