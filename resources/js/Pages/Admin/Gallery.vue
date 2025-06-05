<template>
<AdminLayout title="Gallery" activeTab="gallery">
    <div class="space-y-6">
        <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold text-white">Галерея</h2>
        <button @click="showGalleryModal = true" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 rounded-lg text-white flex items-center transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Добавить фото
        </button>
        </div>

        <!-- Сетка галереи -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div v-for="(image, index) in gallery" :key="index" class="relative group">
            <img :src="image.url" :alt="image.alt" class="w-full h-40 object-cover rounded-lg">
            <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition flex items-center justify-center space-x-3">
            <button @click="editGalleryItem(image)" class="p-2 bg-emerald-600/80 rounded-full hover:bg-emerald-500">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </button>
            <button @click="deleteGalleryItem(image)" class="p-2 bg-red-600/80 rounded-full hover:bg-red-500">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </button>
            </div>
        </div>
        </div>
    </div>


    <transition name="fade">
      <div v-if="showGalleryModal" class="fixed inset-0 bg-black/70 flex items-center justify-center p-4 z-50">
        <div class="bg-gray-800 rounded-xl p-6 w-full max-w-2xl">
          <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-white">Добавить фото в галерею</h3>
            <button @click="showGalleryModal = false" class="text-gray-400 hover:text-white">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
              </svg>
            </button>
          </div>

          <form @submit.prevent="addGalleryItem" class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-300 mb-1">Загрузить изображение</label>
              <input type="file" accept="image/*" @change="handleImageUpload" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-emerald-600 file:text-white hover:file:bg-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500">
              <div v-if="imagePreview" class="mt-4">
                <img :src="imagePreview" alt="Предпросмотр" class="max-h-64 mx-auto rounded-lg">
              </div>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-300 mb-1">Описание</label>
              <input v-model="newGalleryItem.alt" type="text" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>

            <div class="flex justify-end space-x-3 pt-4">
              <button @click="showGalleryModal = false" type="button" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg text-gray-300 transition">
                Отменить
              </button>
              <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 rounded-lg text-white transition">
                Добавить
              </button>
            </div>
          </form>
        </div>
      </div>
    </transition>
</AdminLayout>
</template>

<script setup>
import { ref } from 'vue'
import AdminLayout from '@/Pages/Admin/Layouts/AdminLayout.vue'

const gallery = ref([
  { id: 1, url: 'https://picsum.photos/400/300?random=1', alt: 'Уборка парка' },
  { id: 2, url: 'https://picsum.photos/400/300?random=2', alt: 'Посадка деревьев' },
  { id: 3, url: 'https://picsum.photos/400/300?random=3', alt: 'Марафон' },
  { id: 4, url: 'https://picsum.photos/400/300?random=4', alt: 'Чистый пляж' }
])

const showGalleryModal = ref(false)
const newGalleryItem = ref({ url: '', alt: '' })
const imagePreview = ref(null)

function handleImageUpload(event) {
  const file = event.target.files[0]
  if (file) {
    const reader = new FileReader()
    reader.onload = (e) => {
      imagePreview.value = e.target.result
    }
    reader.readAsDataURL(file)
  }
}

function addGalleryItem() {
  if (!newGalleryItem.value.alt || !imagePreview.value) return
  
  const newItem = {
    id: Math.max(...gallery.value.map(i => i.id), 0) + 1,
    url: imagePreview.value,
    alt: newGalleryItem.value.alt
  }
  
  gallery.value.push(newItem)
  resetGalleryForm()
}

function resetGalleryForm() {
  newGalleryItem.value = { url: '', alt: '' }
  imagePreview.value = null
  showGalleryModal.value = false
}

function editGalleryItem(item) {
  // Реализация редактирования
  console.log('Редактировать галерею:', item)
}

function deleteGalleryItem(item) {
  if (confirm(`Удалить изображение "${item.alt}"?`)) {
    gallery.value = gallery.value.filter(i => i.id !== item.id)
  }
}
</script>
