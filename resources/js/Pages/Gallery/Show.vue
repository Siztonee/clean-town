<template>
  <AppLayout>
    <!-- Герой-секция галереи -->
    <section class="relative bg-gray-900 text-white py-24">
      <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-3xl">
          <h1 class="text-4xl md:text-5xl font-bold mb-6">{{ gallery.title }}</h1>
          <p class="text-xl text-gray-300 mb-4">
            {{ formattedDate }}
          </p>
          <div class="flex items-center text-lg">
            <i class="fas fa-image text-emerald-400 mr-2"></i>
            <span>{{ gallery.items.length }} материалов</span>
          </div>
        </div>
      </div>
      <div class="absolute inset-0 z-0">
        <img 
          v-if="gallery.preview_url"
          :src="gallery.preview_url" 
          class="w-full h-full object-cover opacity-30"
          alt="Превью галереи"
        />
        <div v-else class="w-full h-full bg-gray-800"></div>
      </div>
    </section>

    <!-- Галерея материалов -->
    <section class="py-16 bg-gray-900">
      <div class="container mx-auto px-4">

        <!-- Сетка материалов -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
          <div 
            v-for="(item, index) in gallery.items" 
            :key="index"
            class="group cursor-pointer overflow-hidden rounded-xl shadow-md hover:shadow-xl transition-all duration-300"
            @click="openLightbox(item, index)"
          >
            <!-- Изображение -->
            <div v-if="item.type === 'image'" class="relative aspect-square">
              <img 
                :src="item.path_url" 
                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                :alt="`Изображение ${index + 1}`"
              />
              <div class="absolute inset-0 bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-300 flex items-center justify-center">
                <i class="fas fa-search-plus text-white text-3xl opacity-0 group-hover:opacity-100 transition-opacity"></i>
              </div>
            </div>

            <!-- Видео -->
            <div v-if="item.type === 'video'" class="relative aspect-square bg-gray-800">
              <div class="absolute inset-0 flex items-center justify-center">
                <i class="fas fa-play-circle text-white text-4xl opacity-90 group-hover:opacity-100 group-hover:scale-110 transition-all"></i>
              </div>
              <div class="absolute bottom-0 left-0 right-0 p-3">
                <p class="text-white font-medium truncate">Видео {{ index + 1 }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Пагинация -->
        <div v-if="gallery.items.length > 12" class="mt-12 flex justify-center">
          <div class="flex space-x-2">
            <button 
              v-for="page in totalPages" 
              :key="page"
              :class="[
                'w-10 h-10 rounded-full flex items-center justify-center font-medium',
                currentPage === page 
                  ? 'bg-emerald-600 text-white' 
                  : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
              ]"
            >
              {{ page }}
            </button>
          </div>
        </div>
      </div>
    </section>

    <!-- Лайтбокс для просмотра -->
    <Transition enter-active-class="transition duration-300 ease-out"
                enter-from-class="transform opacity-0"
                enter-to-class="transform opacity-100"
                leave-active-class="transition duration-200 ease-in"
                leave-from-class="transform opacity-100"
                leave-to-class="transform opacity-0">
      <div v-if="lightboxOpen" class="fixed inset-0 z-50">
        <!-- Overlay -->
        <div class="absolute inset-0 bg-black/90" @click="closeLightbox"></div>
        
        <!-- Контент лайтбокса -->
        <div class="relative h-full w-full flex items-center justify-center">
          <!-- Кнопки навигации -->
          <button 
            @click.stop="prevItem"
            class="absolute left-4 z-10 w-12 h-12 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center transition-all"
          >
            <i class="fas fa-chevron-left text-white text-xl"></i>
          </button>
          
          <button 
            @click.stop="nextItem"
            class="absolute right-4 z-10 w-12 h-12 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center transition-all"
          >
            <i class="fas fa-chevron-right text-white text-xl"></i>
          </button>
          
          <!-- Кнопка закрытия -->
          <button 
            @click="closeLightbox"
            class="absolute top-4 right-4 z-10 w-12 h-12 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center transition-all"
          >
            <i class="fas fa-times text-white text-xl"></i>
          </button>
          
          <!-- Контент -->
          <div class="relative w-full max-w-5xl px-4">
            <!-- Изображение -->
            <img 
              v-if="lightboxItem && lightboxItem.type === 'image'"
              :src="lightboxItem.path_url" 
              class="max-h-[80vh] mx-auto object-contain"
              :alt="`Изображение ${lightboxIndex + 1}`"
            />
            
            <!-- Видео -->
            <div v-if="lightboxItem && lightboxItem.type === 'video'" class="w-full aspect-video">
              <video 
                :src="lightboxItem.path_url" 
                controls
                class="w-full h-full object-contain"
                autoplay
                ref="videoPlayer"
              ></video>
            </div>
            
            <!-- Описание -->
            <div class="mt-4 text-center text-white">
              <p class="text-lg">{{ gallery.title }} - Материал {{ lightboxIndex + 1 }} из {{ gallery.items.length }}</p>
              <p class="text-gray-300 mt-1">{{ formattedDate }}</p>
            </div>
          </div>
        </div>
      </div>
    </Transition>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { ref, computed, watch } from 'vue'

const props = defineProps({
  gallery: {
    type: Object,
    required: true,
    default: () => ({
      title: '',
      preview: '',
      date: '',
      items: []
    })
  }
})

// Лайтбокс
const lightboxOpen = ref(false)
const lightboxItem = ref(null)
const lightboxIndex = ref(0)
const videoPlayer = ref(null)

const openLightbox = (item, index) => {
  lightboxItem.value = item
  lightboxIndex.value = index
  lightboxOpen.value = true
}

const closeLightbox = () => {
  lightboxOpen.value = false
  if (videoPlayer.value) {
    videoPlayer.value.pause()
  }
}

const nextItem = () => {
  if (lightboxIndex.value < props.gallery.items.length - 1) {
    lightboxIndex.value++
    lightboxItem.value = props.gallery.items[lightboxIndex.value]
    if (videoPlayer.value) videoPlayer.value.pause()
  }
}

const prevItem = () => {
  if (lightboxIndex.value > 0) {
    lightboxIndex.value--
    lightboxItem.value = props.gallery.items[lightboxIndex.value]
    if (videoPlayer.value) videoPlayer.value.pause()
  }
}

// Закрытие по ESC
const handleKeydown = (e) => {
  if (e.key === 'Escape') closeLightbox()
  if (e.key === 'ArrowRight') nextItem()
  if (e.key === 'ArrowLeft') prevItem()
}

watch(lightboxOpen, (isOpen) => {
  if (isOpen) window.addEventListener('keydown', handleKeydown)
  else window.removeEventListener('keydown', handleKeydown)
})

// Пагинация
const itemsPerPage = 12
const currentPage = ref(1)
const totalPages = computed(() => Math.ceil(props.gallery.items.length / itemsPerPage))

// Форматирование даты
const formattedDate = computed(() => {
  const date = new Date(props.gallery.date)
  return date.toLocaleDateString('ru-RU', {
    day: 'numeric',
    month: 'long',
    year: 'numeric'
  })
})
</script>