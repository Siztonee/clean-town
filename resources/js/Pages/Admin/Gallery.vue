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
            Создать галерею
        </button>
        </div>

        <!-- Сетка галереи -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div v-for="(gallery, index) in galleries" :key="index" class="relative group">
          <Link :href="`/admin/gallery/${gallery.id}`">
            <img :src="gallery.preview_url" :alt="gallery.title" class="w-full h-40 object-cover rounded-lg">
            <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition flex items-center justify-center space-x-3">
            <button @click="editGalleryItem(gallery)" class="p-2 bg-emerald-600/80 rounded-full hover:bg-emerald-500">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </button>
            <button @click="deleteGalleryItem(gallery)" class="p-2 bg-red-600/80 rounded-full hover:bg-red-500">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </button>
            </div>
          </Link>
        </div>
        </div>
    </div>


     <transition name="fade">
      <div v-if="showGalleryModal" class="fixed inset-0 bg-black/70 flex items-center justify-center p-4 z-50">
        <div class="bg-gray-800 rounded-xl p-6 w-full max-w-2xl max-h-[90vh] overflow-y-auto">
          <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-white">{{ isEditing ? 'Редактировать' : 'Создать' }} галерею</h3>
            <button @click="closeGalleryModal" class="text-gray-400 hover:text-white">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
              </svg>
            </button>
          </div>

          <form @submit.prevent="saveGallery" class="space-y-4" enctype="multipart/form-data">
            <!-- Поле загрузки изображения -->
            <div>
              <label class="block text-sm font-medium text-gray-300 mb-1">Обложка галереи</label>
              
              <!-- Предпросмотр -->
              <div v-if="imagePreview" class="mb-3 flex justify-center">
                <img :src="imagePreview" class="max-h-64 rounded-lg border border-gray-600 object-cover">
              </div>
              <div v-else-if="isEditing && currentGallery.preview_url" class="mb-3 flex justify-center">
                <img :src="currentGallery.preview_url" class="max-h-64 rounded-lg border border-gray-600 object-cover">
              </div>

              <!-- Кастомный загрузчик -->
              <div class="flex items-center justify-center w-full">
                <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed rounded-lg cursor-pointer border-gray-600 bg-gray-700 hover:bg-gray-600/50 transition">
                  <div class="flex flex-col items-center justify-center pt-5 pb-6">
                    <svg class="w-8 h-8 mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                    </svg>
                    <p class="mb-2 text-sm text-gray-400">
                      <span class="font-semibold">Нажмите для загрузки</span>
                    </p>
                    <p class="text-xs text-gray-500">PNG, JPG, JPEG (макс. 2MB)</p>
                  </div>
                  <input 
                    type="file" 
                    class="hidden" 
                    accept="image/*"
                    @change="handleImageUpload"
                  >
                </label>
              </div>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-300 mb-1">Название</label>
              <input v-model="currentGallery.title" type="text" required class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-300 mb-1">Дата</label>
              <input v-model="currentGallery.date" type="date" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>

            <div class="flex justify-end space-x-3 pt-4">
              <button @click="closeGalleryModal" type="button" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg text-gray-300 transition">
                Отменить
              </button>
              <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 rounded-lg text-white transition">
                {{ isEditing ? 'Сохранить' : 'Создать' }}
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
import { router, Link } from '@inertiajs/vue3'

const props = defineProps({
  galleries: Array
})

const showGalleryModal = ref(false)
const isEditing = ref(false)
const currentGallery = ref({
  id: null,
  title: '',
  date: '',
  image: null,
  preview: null
})

const imageFile = ref(null)
const imagePreview = ref(null)

// Обработка загрузки изображения
function handleImageUpload(e) {
  const file = e.target.files[0]
  if (!file) return
  
  imageFile.value = file
  
  const reader = new FileReader()
  reader.onload = (e) => {
    imagePreview.value = e.target.result
  }
  reader.readAsDataURL(file)
}

// Редактирование галереи
function editGalleryItem(gallery) {
  isEditing.value = true
  currentGallery.value = {
    id: gallery.id,
    title: gallery.title,
    date: gallery.date,
    preview: gallery.preview,
    preview_url: gallery.preview_url
  }
  imageFile.value = null
  imagePreview.value = null
  showGalleryModal.value = true
}

// Удаление галереи
function deleteGalleryItem(gallery) {
  if (confirm(`Удалить галерею "${gallery.title}"?`)) {
    router.delete(`/admin/galleries/${gallery.id}`)
  }
}

// Сохранение галереи
function saveGallery() {
  const formData = new FormData()
  
  formData.append('title', currentGallery.value.title)
  formData.append('date', currentGallery.value.date)
  
  if (imageFile.value) {
    formData.append('preview', imageFile.value)
  }
  
  if (isEditing.value) {
    formData.append('_method', 'PUT')
    router.post(`/admin/galleries/${currentGallery.value.id}`, formData, {
      onSuccess: () => closeGalleryModal()
    })
  } else {
    router.post('/admin/galleries', formData, {
      onSuccess: () => closeGalleryModal()
    })
  }
}

// Закрытие модального окна
function closeGalleryModal() {
  showGalleryModal.value = false
  isEditing.value = false
  currentGallery.value = {
    id: null,
    title: '',
    date: '',
    image: null,
    preview: null,
    preview_url: null
  }
  imageFile.value = null
  imagePreview.value = null
}
</script>