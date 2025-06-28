<template>
<AdminLayout :title="`Галерея: ${props.gallery.title}`" activeTab="gallery">
  <div class="space-y-6">
    <div class="flex justify-between items-center">
      <div>
        <h2 class="text-xl font-semibold text-white">{{ gallery.title }}</h2>
        <p class="text-gray-400 text-sm mt-1">{{ gallery.date }}</p>
      </div>
      <div class="flex space-x-3">
        <button 
          @click="showUploadModal = true"
          class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 rounded-lg text-white flex items-center transition"
        >
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
          </svg>
          Добавить медиа
        </button>
      </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
      <div 
        v-for="(item, index) in gallery_items" 
        :key="item.id"
        class="relative group bg-gray-800 rounded-lg overflow-hidden"
      >
        <div class="h-40 overflow-hidden flex items-center justify-center">
          <img 
            v-if="item.type === 'image'"
            :src="item.path_url" 
            :alt="item.description || 'Изображение'"
            class="object-cover w-full h-full"
          >
          <video 
            v-else
            class="object-cover w-full h-full"
            muted
          >
            <source :src="item.path_url" type="video/mp4">
          </video>
        </div>

        <div class="p-3">
          <p class="text-gray-400 text-xs mt-1">
            {{ formatFileSize(item.size) }}
          </p>
        </div>

        <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition flex items-center justify-center space-x-3">
          <button 
            @click="deleteMediaItem(item)"
            class="p-2 bg-red-600/80 rounded-full hover:bg-red-500"
          >
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
          </button>
        </div>
      </div>
    </div>
  </div>

  <transition name="fade">
    <div v-if="showUploadModal" class="fixed inset-0 bg-black/70 flex items-center justify-center p-4 z-50">
      <div class="bg-gray-800 rounded-xl p-6 w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-6">
          <h3 class="text-xl font-bold text-white">Добавить медиа</h3>
          <button @click="closeUploadModal" class="text-gray-400 hover:text-white">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>
        </div>

        <form @submit.prevent="uploadMedia" class="space-y-4" enctype="multipart/form-data">
          <div>
            <label class="block text-sm font-medium text-gray-300 mb-1">
              Файлы (максимум 10)
            </label>
            
            <div class="flex items-center justify-center w-full">
              <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed rounded-lg cursor-pointer border-gray-600 bg-gray-700 hover:bg-gray-600/50 transition">
                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                  <svg class="w-8 h-8 mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                  </svg>
                  <p class="mb-2 text-sm text-gray-400">
                    <span class="font-semibold">Нажмите для загрузки</span>
                  </p>
                  <p class="text-xs text-gray-500">Изображения и видео (макс. 50MB каждый)</p>
                </div>
                <input 
                  type="file" 
                  class="hidden" 
                  multiple
                  accept="image/*,video/*"
                  @change="handleFilesSelect"
                  ref="fileInput"
                >
              </label>
            </div>

            <div v-if="selectedFiles.length > 0" class="mt-4 space-y-2">
              <div 
                v-for="(file, index) in selectedFiles" 
                :key="index"
                class="flex items-center justify-between p-3 bg-gray-700 rounded-lg"
              >
                <div class="flex items-center space-x-3">
                  <div class="text-emerald-500">
                    <svg v-if="file.type.startsWith('image')" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <svg v-else class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                  </div>
                  <div>
                    <p class="text-white text-sm truncate max-w-xs">{{ file.name }}</p>
                    <p class="text-gray-400 text-xs">{{ formatFileSize(file.size) }}</p>
                  </div>
                </div>
                
                <div class="flex items-center space-x-3">
                  <button 
                    @click="removeSelectedFile(index)"
                    type="button"
                    class="text-red-500 hover:text-red-400"
                  >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                  </button>
                </div>
              </div>
            </div>
          </div>

          <div class="flex justify-end space-x-3 pt-4">
            <button 
              @click="closeUploadModal" 
              type="button" 
              class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg text-gray-300 transition"
            >
              Отменить
            </button>
            <button 
              type="submit" 
              :disabled="uploading || selectedFiles.length === 0"
              :class="{
                'bg-emerald-600 hover:bg-emerald-500': !uploading && selectedFiles.length > 0,
                'bg-emerald-800 cursor-not-allowed': uploading || selectedFiles.length === 0
              }"
              class="px-4 py-2 rounded-lg text-white transition flex items-center"
            >
              <span v-if="uploading" class="flex items-center">
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Загрузка...
              </span>
              <span v-else>Загрузить</span>
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
import { router } from '@inertiajs/vue3'
import AdminLayout from '@/Pages/Admin/Layouts/AdminLayout.vue'

const props = defineProps({
  gallery: Object,
  gallery_items: Array
})

// Состояния для управления модальными окнами
const showUploadModal = ref(false)
const uploading = ref(false)

// Состояния для загрузки файлов
const selectedFiles = ref([])
const fileInput = ref(null)

// Текущее редактируемое медиа
const currentMedia = ref({
  id: null,
  description: ''
})

// Обработка выбора файлов
const handleFilesSelect = (e) => {
  const files = Array.from(e.target.files)
  
  // Валидация: не больше 10 файлов за раз
  if (selectedFiles.value.length + files.length > 10) {
    alert(`Можно выбрать не более 10 файлов. Вы уже выбрали ${selectedFiles.value.length}.`);
    return;
  }
  
  // Проверка размера файлов (макс. 20MB)
  const validFiles = files.filter(file => {
    const isValid = file.size <= 20 * 1024 * 1024;
    if (!isValid) {
      alert(`Файл "${file.name}" слишком большой (макс. 20MB).`);
    }
    return isValid;
  });
  
  selectedFiles.value.push(...validFiles);
  fileDescriptions.value.push(...Array(validFiles.length).fill(''));
  
  // Сбрасываем input
  if (fileInput.value) {
    fileInput.value.value = ''
  }
}

// Удаление файла из списка выбранных
const removeSelectedFile = (index) => {
  selectedFiles.value.splice(index, 1)
  fileDescriptions.value.splice(index, 1)
}

// Загрузка медиа на сервер
const uploadMedia = () => {
  if (selectedFiles.value.length === 0) return;
  
  const formData = new FormData();
  
  // Добавляем все файлы и описания
  selectedFiles.value.forEach((file, index) => {
    formData.append(`files[${index}]`, file); // Ключ должен быть files[index]
    formData.append(`descriptions[${index}]`, fileDescriptions.value[index] || '');
  });
  
  // Добавляем ID галереи
  formData.append('gallery_id', props.gallery.id);
  
  const uploadUrl = `/admin/gallery/${props.gallery.id}`;
  
  router.post(uploadUrl, formData, {
    forceFormData: true,
    onStart: () => { uploading.value = true },
    onSuccess: () => {
      closeUploadModal();
      // Перезагружаем данные страницы
      router.reload({ only: ['gallery_items'] });
    },
    onError: (errors) => {
      const errorMessages = Object.values(errors).join('\n');
      alert('Ошибка при загрузке файлов:\n' + errorMessages);
    },
    onFinish: () => {
      uploading.value = false;
    }
  });
}


// Удаление медиа
const deleteMediaItem = (media) => {
  if (confirm(`Вы уверены, что хотите удалить этот медиа-файл?`)) {

    const deleteUrl = `/admin/gallery/${props.gallery.id}/${media.id}`;
    
    router.delete(deleteUrl, {
        preserveScroll: true, 
    });
  }
}

// Закрытие модального окна загрузки
const closeUploadModal = () => {
  showUploadModal.value = false
  selectedFiles.value = []
  fileDescriptions.value = []
}

// Форматирование размера файла
const formatFileSize = (bytes) => {
  if (bytes === 0) return '0 Bytes'
  const k = 1024
  const sizes = ['Bytes', 'KB', 'MB', 'GB']
  const i = Math.floor(Math.log(bytes) / Math.log(k))
  return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i]
}
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

.group:hover .group-hover\:opacity-100 {
  opacity: 1;
}
</style>
