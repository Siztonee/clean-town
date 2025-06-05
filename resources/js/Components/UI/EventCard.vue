<template>
  <div class="bg-gray-800 rounded-xl overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
    <!-- Блок изображения -->
    <div class="aspect-video bg-gradient-to-br from-gray-700 to-gray-800 relative">
      <div 
        class="absolute top-4 right-4 px-3 py-1 rounded-full text-sm font-medium backdrop-blur-sm"
        :class="{
          'bg-emerald-600/90 text-white': status === 'upcoming',
          'bg-yellow-500/90 text-gray-900': status === 'active',
          'bg-gray-600/90 text-gray-300': status === 'completed'
        }">
        {{ statusText }}
      </div>
    </div>
    
    <!-- Контент карточки -->
    <div class="p-6 space-y-6">
      <!-- Заголовок -->
      <h3 class="text-xl font-bold text-white">{{ title }}</h3>

      <!-- Дополнительная информация -->
      <div class="space-y-4">
        <!-- Местоположение -->
        <div class="flex items-center text-gray-300">
          <svg class="w-5 h-5 mr-2 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
          </svg>
          {{ location }}
        </div>

        <!-- Дата и участники -->
        <div class="grid grid-cols-2 gap-4">
          <div class="flex flex-col">
            <span class="text-xs text-gray-400 uppercase tracking-wider">Дата</span>
            <div class="flex items-center text-gray-300">
              <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
              </svg>
              {{ date }}
            </div>
          </div>

          <div class="flex flex-col">
            <span class="text-xs text-gray-400 uppercase tracking-wider">Участники</span>
            <div class="flex items-center text-gray-300">
              <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
              </svg>
              {{ participants }}
            </div>
          </div>
        </div>
      </div>

      <!-- Кнопка действия -->
      <Link 
        href="#" 
        class="w-full py-3 bg-gradient-to-r from-emerald-600 to-emerald-500 hover:from-emerald-500 hover:to-emerald-400 text-white font-medium rounded-lg text-center transition-all duration-300 shadow-md hover:shadow-emerald-500/25">
        {{ status === 'completed' ? 'Смотреть отчет' : 'Участвовать' }}
      </Link>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  title: String,
  date: String,
  location: String,
  participants: String,
  status: {
    type: String,
    default: 'upcoming'
  }
})

const statusText = computed(() => {
  return {
    'upcoming': 'Предстоящее',
    'active': 'Идет сейчас',
    'completed': 'Завершено'
  }[props.status]
})
</script>