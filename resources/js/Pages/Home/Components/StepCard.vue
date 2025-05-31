<template>
  <div class="text-center">
    <div class="relative inline-block mb-6">
      <div class="w-16 h-16 rounded-full bg-emerald-600 flex items-center justify-center text-white text-xl font-bold relative z-10">
        {{ step }}
      </div>
      <div class="absolute inset-0 z-0">
        <div class="w-20 h-20 rounded-full bg-emerald-100 animate-ping opacity-30 absolute inset-0 mx-auto my-auto"></div>
      </div>
    </div>
    
    <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mb-4 mx-auto">
      <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <component :is="getIcon" />
      </svg>
    </div>
    
    <h3 class="text-xl font-bold mb-3 text-gray-800">{{ title }}</h3>
    <p class="text-gray-600">{{ description }}</p>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  step: String,
  title: String,
  description: String,
  icon: String
})

const getIcon = computed(() => {
  const icons = {
    clipboard: {
      path: `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>`
    },
    clock: {
      path: `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>`
    },
    heart: {
      path: `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>`
    },
    calendar: {
      path: `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>`
    }
  }
  
  return icons[props.icon] || icons.calendar
})
</script>