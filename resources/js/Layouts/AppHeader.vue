<template>
  <header class="bg-emerald-600 text-white shadow-md">
    <div class="container mx-auto px-4 py-3">
      <div class="flex justify-between items-center">
        <!-- Логотип и название -->
        <router-link to="/" class="flex items-center space-x-3">
          <div class="bg-white rounded-full p-2">
              <img class="w-8 h-8" :src="logo" alt="Logo">
          </div>
          <span class="text-xl font-bold tracking-wide">CleanTown</span>
        </router-link>

        <!-- Навигация для десктопа -->
        <nav class="hidden md:flex space-x-8">
          <router-link 
            to="/events" 
            class="py-2 hover:text-emerald-100 transition duration-200"
            active-class="font-semibold underline decoration-2 underline-offset-4">
            Мероприятия
          </router-link>
          <router-link 
            to="/gallery" 
            class="py-2 hover:text-emerald-100 transition duration-200"
            active-class="font-semibold underline decoration-2 underline-offset-4">
            Галерея
          </router-link>
          <router-link 
            to="/about" 
            class="py-2 hover:text-emerald-100 transition duration-200"
            active-class="font-semibold underline decoration-2 underline-offset-4">
            О нас
          </router-link>
          <router-link 
            to="/join" 
            class="px-4 py-2 bg-white text-emerald-600 rounded-full hover:bg-emerald-50 font-medium transition shadow-sm">
            Присоединиться
          </router-link>
        </nav>

        <!-- Мобильное меню -->
        <button 
          @click="isMenuOpen = !isMenuOpen"
          class="md:hidden text-white focus:outline-none"
          aria-label="Меню">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path v-if="!isMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>

      <!-- Мобильная навигация -->
      <div 
        v-if="isMenuOpen" 
        class="md:hidden py-4 space-y-4 animate-fadeIn">
        <router-link 
          to="/events" 
          class="block py-2 px-4 hover:bg-emerald-500 rounded transition"
          @click="isMenuOpen = false">
          Мероприятия
        </router-link>
        <router-link 
          to="/gallery" 
          class="block py-2 px-4 hover:bg-emerald-500 rounded transition"
          @click="isMenuOpen = false">
          Галерея
        </router-link>
        <router-link 
          to="/about" 
          class="block py-2 px-4 hover:bg-emerald-500 rounded transition"
          @click="isMenuOpen = false">
          О нас
        </router-link>
        <router-link 
          to="/join" 
          class="block mt-4 py-2 px-4 bg-white text-emerald-600 text-center rounded-full font-medium shadow-sm"
          @click="isMenuOpen = false">
          Присоединиться
        </router-link>
      </div>
    </div>
  </header>
</template>

<script setup>
import { ref } from 'vue'
import logo from '~images/logo.png'

const isMenuOpen = ref(false)
</script>

<style scoped>
.animate-fadeIn {
  animation: fadeIn 0.3s ease-out;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(-10px); }
  to { opacity: 1; transform: translateY(0); }
}
</style>