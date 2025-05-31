<template>
  <div :class="['rounded-xl overflow-hidden shadow-lg transition-all hover:shadow-xl border', featured ? 'border-emerald-500 border-2' : 'border-gray-700', 'bg-gray-800']">
    <div class="h-48 bg-gray-700 relative overflow-hidden">
      <div class="absolute inset-0 bg-cover bg-center" :style="`background-image: url('https://picsum.photos/seed/${title}/600/400')`"></div>
      <div v-if="featured" class="absolute top-4 right-4 bg-amber-500 text-white px-3 py-1 rounded-full text-sm font-bold">
        Популярное
      </div>
      <div class="absolute bottom-0 left-0 right-0 p-4 bg-gradient-to-t from-black/70 to-transparent">
        <h3 class="text-xl font-bold text-white">{{ title }}</h3>
      </div>
    </div>
    
    <div class="p-6">
      <div class="flex items-center mb-4">
        <svg class="w-5 h-5 text-emerald-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        <span class="text-gray-400">{{ location }}</span>
      </div>
      
      <div class="flex items-center mb-6">
        <svg class="w-5 h-5 text-emerald-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        <span class="text-gray-300 font-medium">{{ date }}</span>
      </div>
      
      <div class="flex justify-between items-center">
        <div class="flex items-center">
          <svg class="w-5 h-5 text-emerald-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>
          <span class="text-gray-400">{{ participants }}</span>
        </div>
        <router-link 
          to="/event" 
          class="text-emerald-400 font-medium hover:text-emerald-300 transition flex items-center">
          Подробнее
          <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  title: String,
  date: String,
  location: String,
  participants: String,
  featured: Boolean
})
</script>