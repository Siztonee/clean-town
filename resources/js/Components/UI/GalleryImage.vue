<template>
  <Link :href="`/gallery/${id}`"> 
  <div :class="['relative overflow-hidden rounded-xl group h-64', additionalClasses]">
    <div class="absolute inset-0 bg-cover bg-center transition-transform duration-500 group-hover:scale-110" 
         :style="{ backgroundImage: `url(${preview_url})` } "></div>
    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-6">
      <div class="text-white">
        <h3 class="font-bold text-lg mb-1">{{ title }}</h3>
        <p class="text-emerald-300">{{ date }}</p>
      </div>
    </div>
  </div>
  </Link>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
  additionalClasses: {
    type: String,
    default: ''
  },
  id: Number,
  title: String,
  preview_url: String,
  date: String,
})
</script>