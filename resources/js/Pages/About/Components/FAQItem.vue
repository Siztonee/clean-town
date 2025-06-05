<template>
  <div class="border-b border-gray-700 pb-4">
    <button 
      @click="isOpen = !isOpen"
      class="flex justify-between items-center w-full py-4 text-left">
      <span class="text-lg font-medium text-white">{{ question }}</span>
      <svg 
        class="w-5 h-5 text-emerald-400 transition-transform duration-200"
        :class="{ 'rotate-180': isOpen }"
        fill="none" 
        stroke="currentColor" 
        viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
      </svg>
    </button>
    
    <transition
      enter-active-class="transition duration-200 ease-out"
      enter-from-class="transform scale-95 opacity-0"
      enter-to-class="transform scale-100 opacity-100"
      leave-active-class="transition duration-150 ease-in"
      leave-from-class="transform scale-100 opacity-100"
      leave-to-class="transform scale-95 opacity-0">
      <div v-if="isOpen" class="pb-4 text-gray-300">
        {{ answer }}
      </div>
    </transition>
  </div>
</template>

<script setup>
import { ref } from 'vue'

defineProps({
  question: String,
  answer: String
})

const isOpen = ref(false)
</script>