<template>
<AdminLayout title="Info" activeTab="info">
    <div class="space-y-8">
        <!-- Команда -->
        <div class="space-y-4">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-white">Команда</h2>
            <button @click="showTeamModal = true" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 rounded-lg text-white flex items-center transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            Добавить участника
            </button>
        </div>

        <!-- Список команды -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div v-for="(member, index) in team" :key="index" class="bg-gray-700/50 rounded-xl p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-white">{{ member.name }}</h3>
                    <div class="flex space-x-2">
                    <button @click="editTeamMember(member)" class="text-blue-400 hover:text-blue-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </button>
                    <button @click="deleteTeamMember(member)" class="text-red-400 hover:text-red-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                    </div>
                </div>
                <div class="text-emerald-400 font-medium mb-2">{{ member.role }}</div>
                <p class="text-gray-300">{{ member.bio }}</p>
                </div>
            </div>
        </div>
    </div>


    <transition name="fade">
      <div v-if="showTeamModal" class="fixed inset-0 bg-black/70 flex items-center justify-center p-4 z-50">
        <div class="bg-gray-800 rounded-xl p-6 w-full max-w-2xl">
          <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-white">Добавить участника команды</h3>
            <button @click="showTeamModal = false" class="text-gray-400 hover:text-white">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
              </svg>
            </button>
          </div>

          <form @submit.prevent="addTeamMember" class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">Имя</label>
                <input v-model="newTeamMember.name" type="text" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">Роль</label>
                <input v-model="newTeamMember.role" type="text" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500">
              </div>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-300 mb-1">Биография</label>
              <textarea v-model="newTeamMember.bio" rows="3" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500"></textarea>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-300 mb-1">Фото</label>
              <input type="file" accept="image/*" @change="handleTeamImageUpload" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-emerald-600 file:text-white hover:file:bg-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500">
              <div v-if="teamImagePreview" class="mt-4 flex justify-center">
                <img :src="teamImagePreview" alt="Предпросмотр" class="h-32 w-32 rounded-full object-cover">
              </div>
            </div>

            <div class="flex justify-end space-x-3 pt-4">
              <button @click="showTeamModal = false" type="button" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg text-gray-300 transition">
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
import { ref, computed } from 'vue'
import AdminLayout from '@/Pages/Admin/Layouts/AdminLayout.vue'

const team = ref([
  {
    id: 1,
    name: 'Анна Смирнова',
    role: 'Основатель',
    bio: 'Идеолог движения, эколог с 10-летним стажем'
  },
  {
    id: 2,
    name: 'Дмитрий Волков',
    role: 'Координатор',
    bio: 'Организует мероприятия в 15 регионах'
  }
])

const showTeamModal = ref(false)
const newTeamMember = ref({
  name: '',
  role: '',
  bio: '',
  photo: null
})
const teamImagePreview = ref(null)

function handleTeamImageUpload(event) {
  const file = event.target.files[0]
  if (file) {
    const reader = new FileReader()
    reader.onload = (e) => {
      teamImagePreview.value = e.target.result
    }
    reader.readAsDataURL(file)
  }
}

function addTeamMember() {
  if (!newTeamMember.value.name || !newTeamMember.value.role || !newTeamMember.value.bio || !teamImagePreview.value) return
  
  const newItem = {
    id: Math.max(...team.value.map(i => i.id), 0) + 1,
    name: newTeamMember.value.name,
    role: newTeamMember.value.role,
    bio: newTeamMember.value.bio,
    photo: teamImagePreview.value
  }
  
  team.value.push(newItem)
  resetTeamForm()
}

function resetTeamForm() {
  newTeamMember.value = {
    name: '',
    role: '',
    bio: '',
    photo: null
  }
  teamImagePreview.value = null
  showTeamModal.value = false
}

function editTeamMember(member) {
  // Реализация редактирования
  console.log('Редактировать команду:', member)
}

function deleteTeamMember(member) {
  if (confirm(`Удалить участника "${member.name}"?`)) {
    team.value = team.value.filter(m => m.id !== member.id)
  }
}
</script>