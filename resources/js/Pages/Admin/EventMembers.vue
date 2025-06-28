<template>
<AdminLayout :title="`Участники: ${event.title}`" activeTab="events">
    <div class="space-y-6">
        <!-- Заголовок и кнопки -->
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-xl font-semibold text-white">Участники мероприятия</h2>
                <p class="text-gray-400 mt-1">{{ event.title }}</p>
            </div>
            <div class="flex space-x-3">
                <button 
                    @click="$inertia.visit(route('admin.events.index'))"
                    class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg text-white flex items-center transition"
                >
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Назад
                </button>
                <button 
                    @click="showAddMemberModal = true"
                    class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 rounded-lg text-white flex items-center transition"
                >
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Добавить участника
                </button>
            </div>
        </div>

        <!-- Таблица участников -->
        <div class="overflow-x-auto">
            <table class="w-full table-auto">
                <thead class="bg-gray-700 text-gray-300">
                <tr>
                    <th class="px-4 py-3 text-left">ID</th>
                    <th class="px-4 py-3 text-left">Имя пользователя</th>
                    <th class="px-4 py-3 text-left">Email</th>
                    <th class="px-4 py-3 text-left">Телефон</th>
                    <th class="px-4 py-3 text-left">Дата регистрации</th>
                    <th class="px-4 py-3 text-right">Действия</th>
                </tr>
                </thead>
                <tbody>
                <tr 
                    v-for="member in event_members" 
                    :key="member.id"
                    class="border-b border-gray-700 hover:bg-gray-700/50 transition"
                >
                    <td class="px-4 py-3">{{ member.id }}</td>
                    <td class="px-4 py-3">{{ member.username }}</td>
                    <td class="px-4 py-3">{{ member.email ?? '-' }}</td>
                    <td class="px-4 py-3">{{ member.phone ?? '-' }}</td>
                    <td class="px-4 py-3">{{ formatDate(member.created_at) }}</td>
                    <td class="px-4 py-3 text-right">
                        <button 
                            @click="deleteMember(member)"
                            class="text-red-400 hover:text-red-300"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </td>
                </tr>
                <tr v-if="event_members.length === 0">
                    <td colspan="6" class="px-4 py-6 text-center text-gray-400">
                        Нет участников мероприятия
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Модальное окно добавления участника -->
    <transition name="fade">
        <div v-if="showAddMemberModal" class="fixed inset-0 bg-black/70 flex items-center justify-center p-4 z-50">
            <div class="bg-gray-800 rounded-xl p-6 w-full max-w-md">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-white">Добавить участника</h3>
                    <button @click="closeAddMemberModal" class="text-gray-400 hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form @submit.prevent="addMember" class="space-y-4">
                    <div class="relative">
                        <label class="block text-sm font-medium text-gray-300 mb-1">Поиск пользователя</label>
                        <input 
                            v-model="searchQuery"
                            @input="searchUsers"
                            type="text" 
                            placeholder="Введите имя пользователя"
                            class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        >
                        
                        <!-- Результаты поиска -->
                        <div 
                            v-if="searchResults || searchResults.length > 0"
                            class="absolute z-10 mt-1 w-full bg-gray-700 border border-gray-600 rounded-lg shadow-lg max-h-60 overflow-y-auto"
                        >
                            <ul>
                                <li 
                                    v-for="user in searchResults" 
                                    :key="user.id"
                                    @click="selectUser(user)"
                                    class="px-4 py-3 hover:bg-gray-600 cursor-pointer text-white border-b border-gray-600 last:border-b-0"
                                >
                                    <div class="font-medium">{{ user.username }}</div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Скрытое поле для ID и отображение выбранного пользователя -->
                    <div v-if="newMember.id" class="bg-gray-700 p-3 rounded-lg">
                        <div class="text-sm text-gray-300">Выбран пользователь:</div>
                        <div class="font-medium text-white mt-1">{{ newMember.username }}</div>
                        <input type="hidden" v-model="newMember.id">
                    </div>

                    <div class="flex justify-end space-x-3 pt-4">
                        <button 
                            @click="closeAddMemberModal" 
                            type="button" 
                            class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg text-gray-300 transition"
                        >
                            Отменить
                        </button>
                        <button 
                            type="submit" 
                            :disabled="!newMember.id"
                            :class="{'opacity-50 cursor-not-allowed': !newMember.id}"
                            class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 rounded-lg text-white transition"
                        >
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
import { ref, watch } from 'vue'
import { router } from '@inertiajs/vue3'
import AdminLayout from '@/Pages/Admin/Layouts/AdminLayout.vue'
import axios from 'axios'

const props = defineProps({
    event: Object,
    event_members: Array
})

const showAddMemberModal = ref(false)
const newMember = ref({
    id: '',
    username: '',
})
const searchQuery = ref('')
const searchResults = ref([])
const searchTimeout = ref(null)

// Поиск пользователей с задержкой
let cancelToken;

const searchUsers = () => {
  clearTimeout(searchTimeout.value);
  
  if (searchQuery.value.length < 2) {
    searchResults.value = [];
    return;
  }

  if (cancelToken) cancelToken.cancel();
  cancelToken = axios.CancelToken.source();

  searchTimeout.value = setTimeout(async () => {
    try {
      const response = await axios.get(route('admin.users.search'), {
        params: { query: searchQuery.value },
        cancelToken: cancelToken.token
      });
      
      searchResults.value = response.data;
    } catch (error) {
      if (!axios.isCancel(error)) {
        console.error('Search error:', error);
        searchResults.value = [];
      }
    }
  }, 300);
};

// Выбор пользователя из результатов
const selectUser = (user) => {
    newMember.value = {
        id: user.id,
        username: user.username
    }
    searchQuery.value = ''
    searchResults.value = []
}

// Сброс поиска при открытии/закрытии модалки
watch(showAddMemberModal, (isOpen) => {
    if (isOpen) {
        searchQuery.value = ''
        searchResults.value = []
        newMember.value = { id: '', username: '' }
    }
})

// Форматирование даты
const formatDate = (dateString) => {
    const options = { 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    }
    return new Date(dateString).toLocaleDateString('ru-RU', options)
}

// Добавление участника
const addMember = () => {
    if (!newMember.value.id) {
        alert('Пожалуйста, выберите пользователя')
        return
    }

    router.post(`/admin/event/${props.event.id}`, {
        user_id: newMember.value.id
    }, {
        onSuccess: () => {
            closeAddMemberModal()
        },
        onError: (errors) => {
            alert('Ошибка: ' + (errors.message || 'Неизвестная ошибка'))
        }
    })
}

// Удаление участника
const deleteMember = (member) => {
    if (confirm(`Удалить участника "${member.username}"?`)) {
        router.delete(`/admin/event/${props.event.id}/${member.id}`)
    }
}

// Закрытие модального окна
const closeAddMemberModal = () => {
    showAddMemberModal.value = false
    newMember.value = {
        id: '',
        username: '',
    }
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

.table-auto {
  min-width: 100%;
  border-collapse: separate;
  border-spacing: 0;
}

.table-auto th,
.table-auto td {
  padding: 12px 16px;
  text-align: left;
}

.table-auto th {
  background-color: #374151;
  color: #d1d5db;
  font-weight: 600;
}

.table-auto tbody tr:hover {
  background-color: rgba(55, 65, 81, 0.5);
}

.absolute {
  position: absolute;
  z-index: 100;
}

.max-h-60 {
  max-height: 15rem;
}
</style>