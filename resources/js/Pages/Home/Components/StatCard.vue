<template>
  <div class="p-6 bg-gray-800 rounded-2xl shadow-md hover:shadow-lg transition">
    <div class="w-16 h-16 bg-emerald-900/30 rounded-full flex items-center justify-center mb-4 mx-auto">
      <i :class="`mt-3 w-8 h-8 text-emerald-400 fa ${icon} text-xl`"></i>
    </div>
    <div class="text-3xl md:text-4xl font-bold text-emerald-400 mb-2 text-center">{{ number }}</div>
    <div class="text-gray-400 text-center">{{ label }}</div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  number: String,
  label: String,
  icon: String
})

</script>