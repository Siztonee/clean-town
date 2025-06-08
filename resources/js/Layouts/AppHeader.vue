<template>
  <header class="bg-gray-800 text-white shadow-md sticky top-0 z-50">
    <div class="container mx-auto px-4 py-3">
      <div class="flex justify-between items-center">
        <!-- Логотип и название -->
        <Link href="/" class="flex items-center space-x-3 group">
          <div class="bg-emerald-600 rounded-full p-2 transition-all duration-300 group-hover:bg-emerald-500">
            <img class="w-8 h-8" :src="logo" alt="Logo">
          </div>
          <span class="text-xl font-bold tracking-wide">CleanTown</span>
        </Link>

        <!-- Навигация для десктопа -->
        <nav class="hidden md:flex space-x-6">
          <Link 
            href="/events" 
            class="py-2 px-3 hover:text-emerald-300 transition duration-200 rounded-lg"
            active-class="text-emerald-400 font-semibold bg-gray-700">
            Мероприятия
          </Link>
          <Link 
            href="/gallery" 
            class="py-2 px-3 hover:text-emerald-300 transition duration-200 rounded-lg"
            active-class="text-emerald-400 font-semibold bg-gray-700">
            Галерея
          </Link>
          <Link 
            href="/about" 
            class="py-2 px-3 hover:text-emerald-300 transition duration-200 rounded-lg"
            active-class="text-emerald-400 font-semibold bg-gray-700">
            О нас
          </Link>
          <Link 
            href="/register" 
            class="ml-2 px-5 py-2 bg-emerald-600 text-white rounded-full hover:bg-emerald-500 font-medium transition shadow-md hover:shadow-emerald-500/30">
            Присоединиться
          </Link>
        </nav>

        <!-- Мобильное меню -->
        <button 
          @click="isMenuOpen = !isMenuOpen"
          class="md:hidden text-white focus:outline-none p-2 rounded-lg hover:bg-gray-700 transition"
          aria-label="Меню">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path v-if="!isMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>

      <!-- Мобильная навигация -->
      <transition
        enter-active-class="animate-fadeInDown"
        leave-active-class="animate-fadeOutUp">
        <div 
          v-if="isMenuOpen" 
          class="md:hidden py-4 space-y-2 bg-gray-800 rounded-lg mt-2 shadow-xl">
          <Link 
            href="/events" 
            class="block py-3 px-4 hover:bg-emerald-600 rounded-lg transition"
            @click="isMenuOpen = false">
            Мероприятия
          </Link>
          <Link 
            href="/gallery" 
            class="block py-3 px-4 hover:bg-emerald-600 rounded-lg transition"
            @click="isMenuOpen = false">
            Галерея
          </Link>
          <Link 
            href="/about" 
            class="block py-3 px-4 hover:bg-emerald-600 rounded-lg transition"
            @click="isMenuOpen = false">
            О нас
          </Link>
          <Link 
            href="/join" 
            class="block mt-4 py-3 px-4 bg-emerald-600 text-white text-center rounded-full font-medium shadow-md hover:bg-emerald-500 transition"
            @click="isMenuOpen = false">
            Присоединиться
          </Link>
        </div>
      </transition>
    </div>
  </header>
</template>

<script setup>
import { ref } from 'vue'
import logo from '~images/logo.png'
import { Link } from '@inertiajs/vue3'

const isMenuOpen = ref(false)
</script>

<style scoped>
.animate-fadeInDown {
  animation: fadeInDown 0.3s ease-out;
}

.animate-fadeOutUp {
  animation: fadeOutUp 0.3s ease-out;
}

@keyframes fadeInDown {
  from { 
    opacity: 0; 
    transform: translateY(-10px); 
  }
  to { 
    opacity: 1; 
    transform: translateY(0); 
  }
}

@keyframes fadeOutUp {
  from { 
    opacity: 1; 
    transform: translateY(0); 
  }
  to { 
    opacity: 0; 
    transform: translateY(-10px); 
  }
}
</style>