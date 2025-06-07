<template>
<AdminLayout title="Info" activeTab="info">
    <div class="space-y-8">
        <!-- Команда -->
        <div class="space-y-4">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-white">Команда</h2>
            <button @click="openNewMemberModal" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 rounded-lg text-white flex items-center transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            {{ isEditing ? 'Редактировать' : 'Добавить' }} участника
            </button>
        </div>

        <!-- Список команды -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          <div v-for="(member, index) in props.teamMembers" :key="index" class="bg-gray-700/50 rounded-xl p-6">
              <!-- Блок с изображением профиля -->
              <div class="flex justify-center mb-4">
                  <img 
                      :src="member.profile_url" 
                      alt="Profile"
                      class="w-24 h-24 object-cover rounded-full border-2 border-emerald-400/50"
                  >
              </div>
              
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
            <h3 class="text-xl font-bold text-white">{{ isEditing ? 'Редактировать' : 'Добавить' }} участника команды</h3>
            <button @click="closeTeamModal" class="text-gray-400 hover:text-white">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
              </svg>
            </button>
          </div>

          <form @submit.prevent="saveTeamMember" class="space-y-4" enctype="multipart/form-data">
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">Имя*</label>
                <input v-model="currentMember.name" type="text" required class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">Роль*</label>
                <input v-model="currentMember.role" type="text" required class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500">
              </div>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-300 mb-1">Биография*</label>
              <textarea v-model="currentMember.bio" rows="3" required class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500"></textarea>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-300 mb-1">Фото</label>
              
              <!-- Предпросмотр изображения -->
              <div v-if="imagePreview" class="mb-3 flex justify-center">
                  <img :src="imagePreview" alt="Preview" class="h-32 w-32 rounded-full object-cover border-2 border-emerald-400/50">
              </div>
              <div v-else-if="isEditing && currentMember.profile_url" class="mb-3 flex justify-center">
                  <img :src="currentMember.profile_url" alt="Current" class="h-32 w-32 rounded-full object-cover border-2 border-emerald-400/50">
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

            <div class="flex justify-end space-x-3 pt-4">
              <button @click="closeTeamModal" type="button" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg text-gray-300 transition">
                Отменить
              </button>
              <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 rounded-lg text-white transition">
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
  teamMembers: Array
})

const showTeamModal = ref(false)
const isEditing = ref(false)
const currentMember = ref({
  id: null,
  name: '',
  role: '',
  bio: '',
  profile_url: '',
})

const imageFile = ref(null)
const imagePreview = ref(null)

// Открытие модалки для нового участника
function openNewMemberModal() {
  isEditing.value = false
  currentMember.value = {
    id: null,
    name: '',
    role: '',
    bio: '',
    profile_url: '',
  }
  imageFile.value = null
  imagePreview.value = null
  showTeamModal.value = true
}

// Загрузка изображения
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

// Редактирование участника
function editTeamMember(member) {
  isEditing.value = true
  currentMember.value = { ...member }
  imageFile.value = null
  imagePreview.value = null
  showTeamModal.value = true
}

// Удаление участника
function deleteTeamMember(member) {
  if (confirm(`Удалить участника "${member.name}"?`)) {
    router.delete(`/admin/team-members/${member.id}`)
  }
}

// Сохранение участника
function saveTeamMember() {
  const formData = new FormData()
  
  formData.append('name', currentMember.value.name)
  formData.append('role', currentMember.value.role)
  formData.append('bio', currentMember.value.bio)
  
  if (imageFile.value) {
    formData.append('profile', imageFile.value)
  }
  
  if (isEditing.value) {
    formData.append('_method', 'PUT')
    router.post(`/admin/team-members/${currentMember.value.id}`, formData, {
      onSuccess: () => closeTeamModal()
    })
  } else {
    router.post('/admin/team-members', formData, {
      onSuccess: () => closeTeamModal()
    })
  }
}

// Закрытие модалки
function closeTeamModal() {
  showTeamModal.value = false
}
</script>