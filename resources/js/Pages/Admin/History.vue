<template>
<AdminLayout title="History" activeTab="history">
    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-white">События</h2>
            <button 
                @click="openNewHistory"
                class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 rounded-lg text-white flex items-center transition"
            >
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Добавить событие
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div 
                v-for="history in props.histories" 
                :key="history.id"
                class="bg-gray-800 rounded-xl p-6 hover:bg-gray-700/80 transition"
            >
                <div class="mb-4">
                    <div class="text-gray-300 text-sm mb-1">
                        {{ formatDate(history.date) }}
                    </div>
                    <h3 class="text-white text-lg font-semibold mb-2">{{ history.title }}</h3>
                    <p class="text-gray-400 text-sm">{{ history.description }}</p>
                </div>
                
                <div class="flex justify-end space-x-2">
                    <button 
                        @click="editHistory(history)"
                        class="text-blue-400 hover:text-blue-300"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </button>
                    <button 
                        @click="deleteHistory(history)"
                        class="text-red-400 hover:text-red-300"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно для добавления/редактирования -->
    <transition name="fade">
        <div v-if="showHistoryModal" class="fixed inset-0 bg-black/70 flex items-center justify-center p-4 z-50">
            <div class="bg-gray-800 rounded-xl p-6 w-full max-w-md">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-white">
                        {{ isEditing ? 'Редактировать' : 'Добавить' }} событие
                    </h3>
                    <button @click="closeModal" class="text-gray-400 hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form @submit.prevent="saveHistory" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1">Заголовок*</label>
                        <input 
                            v-model="currentHistory.title" 
                            type="text" 
                            required
                            maxlength="255"
                            class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1">Описание*</label>
                        <textarea 
                            v-model="currentHistory.description" 
                            required
                            maxlength="255"
                            rows="3"
                            class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        ></textarea>
                        <p class="mt-1 text-xs text-gray-400">
                            {{ currentHistory.description ? currentHistory.description.length : 0 }}/255 символов
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1">Дата*</label>
                        <input 
                            v-model="currentHistory.date" 
                            type="date" 
                            required
                            class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        >
                    </div>

                    <div class="flex justify-end space-x-3 pt-4">
                        <button 
                            @click="closeModal" 
                            type="button" 
                            class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg text-gray-300 transition"
                        >
                            Отменить
                        </button>
                        <button 
                            type="submit" 
                            class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 rounded-lg text-white transition"
                        >
                            {{ isEditing ? 'Сохранить' : 'Добавить' }}
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
import { router } from '@inertiajs/vue3'

const props = defineProps({
  histories: Array
})

const showHistoryModal = ref(false)
const isEditing = ref(false)
const currentHistory = ref({
  id: null,
  title: '',
  description: '',
  date: ''
})

function formatDate(dateString) {
  const date = new Date(dateString)
  return date.toLocaleDateString('ru-RU', {
    day: '2-digit',
    month: 'long',
    year: 'numeric'
  })
}

function openNewHistory() {
  isEditing.value = false
  currentHistory.value = {
    id: null,
    title: '',
    description: '',
    date: new Date().toISOString().split('T')[0] // Устанавливаем текущую дату по умолчанию
  }
  showHistoryModal.value = true
}

function editHistory(history) {
  isEditing.value = true
  currentHistory.value = { 
    ...history,
    date: history.date.split('T')[0] // Конвертируем в формат YYYY-MM-DD
  }
  showHistoryModal.value = true
}

function deleteHistory(history) {
  if (confirm(`Удалить событие "${history.title}"?`)) {
    router.delete(`/admin/history/${history.id}`)
  }
}

function saveHistory() {
  if (isEditing.value) {
    router.put(`/admin/history/${currentHistory.value.id}`, currentHistory.value, {
      onSuccess: () => closeModal()
    })
  } else {
    router.post('/admin/history', currentHistory.value, {
      onSuccess: () => closeModal()
    })
  }
}

function closeModal() {
  showHistoryModal.value = false
}
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}
</style>