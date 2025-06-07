<template>
<AdminLayout title="Events" activeTab="events">
    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-white">Мероприятия</h2>
            <button @click="showEventModal = true" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 rounded-lg text-white flex items-center transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Добавить мероприятие
            </button>
        </div>

        <!-- Таблица мероприятий -->
        <div class="overflow-x-auto">
            <table class="w-full table-auto">
                <thead class="bg-gray-700 text-gray-300">
                <tr>
                    <th class="px-4 py-3 text-left">Название</th>
                    <th class="px-4 py-3 text-left">Дата</th>
                    <th class="px-4 py-3 text-left">Статус</th>
                    <th class="px-4 py-3 text-right">Действия</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(event, index) in props.events" :key="index" class="border-b border-gray-700 hover:bg-gray-700/50 transition">
                    <td class="px-4 py-3">{{ event.title }}</td>
                    <td class="px-4 py-3">{{ event.starts_at }}</td>
                    <td class="px-4 py-3">
                    <span :class="[
                        'px-2 py-1 rounded-full text-xs font-medium',
                        event.status === 'upcoming' ? 'bg-emerald-600/20 text-emerald-400' :
                        event.status === 'active' ? 'bg-yellow-500/20 text-yellow-400' :
                        'bg-gray-600/20 text-gray-400'
                    ]">
                        {{ event.status }}
                    </span>
                    </td>
                    <td class="px-4 py-3 text-right space-x-2">
                    <button @click="editEvent(event)" class="text-blue-400 hover:text-blue-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </button>
                    <button @click="deleteEvent(event)" class="text-red-400 hover:text-red-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <transition name="fade">
      <div v-if="showEventModal" class="fixed inset-0 bg-black/70 flex items-center justify-center p-4 z-50">
        <div class="bg-gray-800 rounded-xl p-6 w-full max-w-2xl max-h-[90vh] overflow-y-auto">
          <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-white">{{ isEditingEvent ? 'Редактировать' : 'Создать' }} мероприятие</h3>
            <button @click="closeEventModal" class="text-gray-400 hover:text-white">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
              </svg>
            </button>
          </div>

          <form @submit.prevent="saveEvent" class="space-y-4" enctype="multipart/form-data">
          <!-- Поле для загрузки изображения -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">Изображение мероприятия</label>
                
                <!-- Предпросмотр изображения -->
                <div v-if="imagePreview" class="mb-3 flex justify-center">
                    <img :src="imagePreview" class="max-h-48 rounded-lg border border-gray-600 object-cover">
                </div>
                <div v-else-if="isEditingEvent && currentEvent.image" class="mb-3 flex justify-center">
                    <img :src="currentEvent.image_url" class="max-h-48 rounded-lg border border-gray-600 object-cover">
                </div>

                <!-- Кастомная кнопка загрузки -->
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
              <label class="block text-sm font-medium text-gray-300 mb-1">Заголовок</label>
              <input v-model="currentEvent.title" type="text" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>

            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">Дата</label>
                <input v-model="currentEvent.starts_at" type="datetime-local" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">Статус</label>
                <select v-model="currentEvent.status" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500">
                  <option value="upcoming">Предстоящее</option>
                  <option value="active">Идет сейчас</option>
                  <option value="completed">Завершено</option>
                </select>
              </div>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-300 mb-1">Место</label>
              <input v-model="currentEvent.location" type="text" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-300 mb-1">Макс. число участников</label>
              <input v-model="currentEvent.max_members" type="number" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-300 mb-1">Описание</label>
              <textarea v-model="currentEvent.description" rows="4" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500"></textarea>
            </div>

            <div class="flex justify-end space-x-3 pt-4">
              <button @click="closeEventModal" type="button" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg text-gray-300 transition">
                Отменить
              </button>
              <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 rounded-lg text-white transition">
                Сохранить
              </button>
            </div>
          </form>
        </div>
      </div>
    </transition>
</AdminLayout>
</template>

<script setup>
import { ref, watch } from 'vue'
import AdminLayout from '@/Pages/Admin/Layouts/AdminLayout.vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
  events: Object
})

const showEventModal = ref(false)
const isEditingEvent = ref(false)
const currentEvent = ref({
  title: '',
  starts_at: '',
  location: '',
  status: 'upcoming',
  description: '',
  max_members: '',
  image: '',
})

function editEvent(event) {
  isEditingEvent.value = true
  currentEvent.value = { ...event, image_url: event.image_url }
  imageFile.value = null
  imagePreview.value = null
  showEventModal.value = true
}

function deleteEvent(event) {
  if (confirm(`Удалить мероприятие "${event.title}"?`)) {
    router.delete(`/admin/events/${event.id}`)
  }
}

const imageFile = ref(null)
const imagePreview = ref(null)

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

function saveEvent() {
    const formData = new FormData()
    
    for (const key in currentEvent.value) {
        if (currentEvent.value[key] !== null && key !== 'image') {
            formData.append(key, currentEvent.value[key])
        }
    }
    
    if (imageFile.value) {
        formData.append('image', imageFile.value)
    }
    
    if (isEditingEvent.value) {
        formData.append('_method', 'PUT')
        router.post(`/admin/events/${currentEvent.value.id}`, formData, {
            onSuccess: () => closeEventModal(),
            onError: (errors) => console.error(errors),
            onFinish: () => console.log('Request finished')
        })

    } else {
        router.post('/admin/events', formData, {
            onSuccess: () => closeEventModal(),
            onError: (errors) => console.error(errors)
        })
    }
}

function closeEventModal() {
  showEventModal.value = false
  isEditingEvent.value = false
  currentEvent.value = {
    title: '',
    starts_at: '',
    location: '',
    status: 'upcoming',
    description: '',
    max_members: '',
    image_url: '',
  }
  imageFile.value = null
  imagePreview.value = null 
}

watch(() => currentEvent.value, (newVal) => {
    if (isEditingEvent.value && newVal.image) {
        imagePreview.value = ''
    }
})
</script>
