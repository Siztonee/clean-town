<template>
  <div class="text-center bg-gray-800/50 rounded-xl p-6 transition hover:bg-gray-800/80">
    <div class="w-32 h-32 mx-auto rounded-full bg-gray-700 mb-6 overflow-hidden"
      :style="{ backgroundImage: `url(${profile_url})` } " style="background-size: cover;"></div>
    <h3 class="text-xl font-bold text-white mb-2">{{ name }}</h3>
    <div class="text-emerald-400 font-medium mb-4">{{ role }}</div>
    <p class="text-gray-300">{{ bio }}</p>
  </div>
</template>

<script setup>
defineProps({
  name: String,
  role: String,
  bio: String,
  profile_url: String
})
</script>