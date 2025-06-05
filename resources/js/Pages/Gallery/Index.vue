<template>
  <AppLayout>
    <section class="py-12 bg-gray-900 text-white">
      <div class="container mx-auto px-4">
        <!-- Заголовок и описание -->
        <div class="text-center max-w-3xl mx-auto mb-16">
          <h1 class="text-4xl md:text-5xl font-bold mb-6">Галерея мероприятий</h1>
          <p class="text-xl text-gray-300">
            Фотографии с наших экологических акций, субботников и мероприятий. 
            Увидьте, как волонтеры CleanTown делают город чище!
          </p>
        </div>

        <!-- Фильтры -->
        <div class="flex flex-wrap justify-center gap-3 mb-12">
          <button 
            v-for="(filter, index) in filters"
            :key="index"
            @click="activeFilter = filter"
            :class="[
              'px-5 py-2 rounded-full border transition',
              activeFilter === filter 
                ? 'bg-emerald-600 border-emerald-600 text-white' 
                : 'border-gray-700 text-gray-300 hover:border-emerald-500 hover:text-emerald-400'
            ]"
          >
            {{ filter }}
          </button>
        </div>

        <!-- Галерея -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
          <GalleryImage 
            v-for="(item, index) in galleryItems"
            :key="index"
            :additional-classes="item.classes"
          />
        </div>

        <!-- Пагинация -->
        <div class="flex justify-center mt-16">
          <div class="flex items-center space-x-2">
            <button class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-800 hover:bg-gray-700 transition">
              &lt;
            </button>
            <button 
              v-for="page in 4"
              :key="page"
              class="w-10 h-10 flex items-center justify-center rounded-full transition"
              :class="[
                page === 1 
                  ? 'bg-emerald-600 text-white' 
                  : 'bg-gray-800 hover:bg-gray-700'
              ]"
            >
              {{ page }}
            </button>
            <button class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-800 hover:bg-gray-700 transition">
              &gt;
            </button>
          </div>
        </div>
      </div>
    </section>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import GalleryImage from '@/Components/UI/GalleryImage.vue'
import { ref } from 'vue'

const filters = [
  'Все', 
  'Парки', 
  'Пляжи', 
  'Лесопарки', 
  'Городские территории',
  'Эко-фестивали'
]

const activeFilter = ref('Все')

const galleryItems = [
  { classes: '' },
  { classes: '' },
  { classes: 'sm:col-span-2' },
  { classes: 'lg:row-span-2' },
  { classes: '' },
  { classes: 'xl:col-span-2' },
  { classes: '' },
  { classes: 'lg:col-span-2' },
  { classes: '' },
  { classes: '' },
  { classes: 'lg:row-span-2' },
  { classes: 'sm:col-span-2' },
]
</script>

<style scoped>
/* Анимация для элементов галереи */
.gallery-item {
  animation: fadeIn 0.5s ease-out;
  animation-fill-mode: both;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Задержки для анимации */
.gallery-item:nth-child(2) { animation-delay: 0.1s; }
.gallery-item:nth-child(3) { animation-delay: 0.2s; }
.gallery-item:nth-child(4) { animation-delay: 0.3s; }
.gallery-item:nth-child(5) { animation-delay: 0.4s; }
.gallery-item:nth-child(6) { animation-delay: 0.5s; }
.gallery-item:nth-child(7) { animation-delay: 0.6s; }
.gallery-item:nth-child(8) { animation-delay: 0.7s; }
.gallery-item:nth-child(9) { animation-delay: 0.8s; }
.gallery-item:nth-child(10) { animation-delay: 0.9s; }
.gallery-item:nth-child(11) { animation-delay: 1.0s; }
.gallery-item:nth-child(12) { animation-delay: 1.1s; }
</style>