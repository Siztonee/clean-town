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
                <tr v-for="(event, index) in events" :key="index" class="border-b border-gray-700 hover:bg-gray-700/50 transition">
                    <td class="px-4 py-3">{{ event.title }}</td>
                    <td class="px-4 py-3">{{ event.date }}</td>
                    <td class="px-4 py-3">
                    <span :class="[
                        'px-2 py-1 rounded-full text-xs font-medium',
                        event.status === 'upcoming' ? 'bg-emerald-600/20 text-emerald-400' :
                        event.status === 'active' ? 'bg-yellow-500/20 text-yellow-400' :
                        'bg-gray-600/20 text-gray-400'
                    ]">
                        {{ event.statusText }}
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

          <form @submit.prevent="saveEvent" class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-300 mb-1">Название</label>
              <input v-model="currentEvent.title" type="text" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>

            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">Дата</label>
                <input v-model="currentEvent.date" type="date" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500">
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
import { ref } from 'vue'
import AdminLayout from '@/Pages/Admin/Layouts/AdminLayout.vue'

const events = ref([
  {
    id: 1,
    title: 'Весенняя уборка парка',
    date: '2023-04-15',
    location: 'Центральный парк',
    status: 'upcoming',
    description: 'Общая уборка в Центральном парке, сбор мусора и посадка деревьев'
  },
  {
    id: 2,
    title: 'Экологический марафон',
    date: '2023-06-20',
    location: 'Набережная реки',
    status: 'active',
    description: 'Масштабная акция по очистке береговой линии'
  }
])

const showEventModal = ref(false)
const isEditingEvent = ref(false)
const currentEvent = ref({
  id: null,
  title: '',
  date: '',
  location: '',
  status: 'upcoming',
  description: ''
})

function editEvent(event) {
  isEditingEvent.value = true
  currentEvent.value = { ...event }
  showEventModal.value = true
}

function deleteEvent(event) {
  if (confirm(`Удалить мероприятие "${event.title}"?`)) {
    events.value = events.value.filter(e => e.id !== event.id)
  }
}

function saveEvent() {
  if (isEditingEvent.value) {
    // Обновление события
    const index = events.value.findIndex(e => e.id === currentEvent.value.id)
    if (index > -1) {
      events.value[index] = { ...currentEvent.value }
    }
  } else {
    // Добавление нового события
    const newEvent = {
      ...currentEvent.value,
      id: Math.max(...events.value.map(e => e.id), 0) + 1
    }
    events.value.push(newEvent)
  }
  
  closeEventModal()
}

function closeEventModal() {
  showEventModal.value = false
  isEditingEvent.value = false
  currentEvent.value = {
    id: null,
    title: '',
    date: '',
    location: '',
    status: 'upcoming',
    description: ''
  }
}
</script>
