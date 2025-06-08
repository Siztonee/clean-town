<template>
<AdminLayout title="Stats" activeTab="stats">
    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-white">Статистика</h2>
            <button 
                @click="showStatModal = true"
                class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 rounded-lg text-white flex items-center transition"
            >
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Добавить показатель
            </button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div 
                v-for="stat in props.stats" 
                :key="stat.id"
                class="bg-gray-800 rounded-xl p-6 hover:bg-gray-700/80 transition"
            >
                <div class="flex items-center">
                    <div class="p-3 bg-emerald-500/20 rounded-xl mr-4">
                        <i :class="`fa ${stat.icon} text-emerald-400 text-xl`"></i>
                    </div>
                    <div>
                        <div class="text-gray-300 text-sm">{{ stat.label }}</div>
                        <div class="text-white text-2xl font-bold">{{ stat.number }}</div>
                    </div>
                </div>
                
                <div class="flex justify-end mt-4 space-x-2">
                    <button 
                        @click="editStat(stat)"
                        class="text-blue-400 hover:text-blue-300"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </button>
                    <button 
                        @click="deleteStat(stat)"
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
        <div v-if="showStatModal" class="fixed inset-0 bg-black/70 flex items-center justify-center p-4 z-50">
            <div class="bg-gray-800 rounded-xl p-6 w-full max-w-md">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-white">
                        {{ isEditing ? 'Редактировать' : 'Добавить' }} показатель
                    </h3>
                    <button @click="closeModal" class="text-gray-400 hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form @submit.prevent="saveStat" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1">Заголовок*</label>
                        <input 
                            v-model="currentStat.label" 
                            type="text" 
                            required
                            class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1">Значение*</label>
                        <input 
                            v-model="currentStat.number" 
                            type="number" 
                            required
                            class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1">Иконка Font Awesome*</label>
                        <div class="flex items-center">
                            <span class="mr-2 text-gray-400">fa-</span>
                            <input 
                                v-model="currentStat.icon" 
                                type="text" 
                                placeholder="users"
                                required
                                class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500"
                            >
                        </div>
                        <p class="mt-2 text-xs text-gray-400">
                            Примеры: user, users, chart-bar, globe, calendar
                        </p>
                        <div v-if="currentStat.icon" class="mt-3 flex items-center">
                            <span class="text-gray-400 mr-3">Предпросмотр:</span>
                            <i :class="`fa fa-${currentStat.icon} text-emerald-400 text-xl`"></i>
                        </div>
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
  stats: Array
})

const showStatModal = ref(false)
const isEditing = ref(false)
const currentStat = ref({
  id: null,
  label: '',
  number: '',
  icon: ''
})

function openNewStat() {
  isEditing.value = false
  currentStat.value = {
    id: null,
    label: '',
    number: '',
    icon: ''
  }
  showStatModal.value = true
}

function editStat(stat) {
  isEditing.value = true
  // Убираем префикс 'fa-' если он есть
  const icon = stat.icon.replace('fa-', '')
  currentStat.value = { 
    ...stat,
    icon: icon
  }
  showStatModal.value = true
}

function deleteStat(stat) {
  if (confirm(`Удалить показатель "${stat.label}"?`)) {
    router.delete(`/admin/stats/${stat.id}`)
  }
}

function saveStat() {
  // Добавляем префикс к иконке
  const statData = {
    ...currentStat.value,
    icon: `fa-${currentStat.value.icon}`
  }

  if (isEditing.value) {
    router.put(`/admin/stats/${statData.id}`, statData, {
      onSuccess: () => closeModal()
    })
  } else {
    router.post('/admin/stats', statData, {
      onSuccess: () => closeModal()
    })
  }
}

function closeModal() {
  showStatModal.value = false
}
</script>

<style scoped>
.bg-emerald-500\/20 {
  background-color: rgba(16, 185, 129, 0.2);
}
</style>