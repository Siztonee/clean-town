<template>
  <div class="min-h-screen bg-gray-900 text-gray-100">
    <!-- Боковое меню -->
    <div class="fixed inset-y-0 left-0 w-64 bg-gray-800 p-6 shadow-xl">
      <div class="flex items-center space-x-2 mb-12">
        <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
        </svg>
        <span class="text-xl font-bold text-white">CleanTown Admin</span>
      </div>

      <nav class="space-y-2">
        <button 
          v-for="(tab, index) in tabs"
          :key="index"
          @click="activeTab = tab.id"
          :class="[
            'w-full text-left px-4 py-3 rounded-lg flex items-center transition-colors',
            activeTab === tab.id 
              ? 'bg-emerald-600/20 text-emerald-400' 
              : 'text-gray-300 hover:bg-gray-700'
          ]">
          <svg :class="['w-5 h-5 mr-3', tab.icon]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="tab.iconPath"/>
          </svg>
          {{ tab.title }}
        </button>
      </nav>
    </div>

    <!-- Основной контент -->
    <div class="ml-64 p-8">
      <!-- Хедер -->
      <header class="mb-8 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-white">{{ currentTabTitle }}</h1>
        <div class="flex items-center space-x-4">
          <button class="p-2 rounded-full text-gray-400 hover:bg-gray-800 hover:text-white">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
          </button>
          <div class="flex items-center space-x-3">
            <div class="h-10 w-10 rounded-full bg-emerald-500 flex items-center justify-center text-white font-medium">
              A
            </div>
            <span class="hidden md:block">Администратор</span>
          </div>
        </div>
      </header>

      <!-- Текущий контент -->
      <div class="bg-gray-800 rounded-xl p-6 shadow-lg">
        <!-- Мероприятия -->
        <div v-if="activeTab === 'events'" class="space-y-6">
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

        <!-- Галерея -->
        <div v-if="activeTab === 'gallery'" class="space-y-6">
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

        <!-- Информация -->
        <div v-if="activeTab === 'info'" class="space-y-8">
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

          <!-- FAQ -->
          <div class="space-y-4">
            <div class="flex justify-between items-center">
              <h2 class="text-xl font-semibold text-white">Частые вопросы</h2>
              <button @click="showFAQModal = true" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 rounded-lg text-white flex items-center transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Добавить вопрос
              </button>
            </div>

            <!-- Список FAQ -->
            <div class="space-y-4">
              <div v-for="(faq, index) in faqs" :key="index" class="bg-gray-700/50 rounded-xl p-6">
                <div class="flex justify-between items-start">
                  <div class="flex-1">
                    <h3 class="text-lg font-semibold text-white mb-2">{{ faq.question }}</h3>
                    <p class="text-gray-300">{{ faq.answer }}</p>
                  </div>
                  <div class="flex space-x-2 ml-4">
                    <button @click="editFAQ(faq)" class="text-blue-400 hover:text-blue-300">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                      </svg>
                    </button>
                    <button @click="deleteFAQ(faq)" class="text-red-400 hover:text-red-300">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                      </svg>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Модальное окно для мероприятий -->
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

    <!-- Модальное окно для галереи -->
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

    <!-- Модальное окно для команды -->
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

    <!-- Модальное окно для FAQ -->
    <transition name="fade">
      <div v-if="showFAQModal" class="fixed inset-0 bg-black/70 flex items-center justify-center p-4 z-50">
        <div class="bg-gray-800 rounded-xl p-6 w-full max-w-2xl">
          <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-white">Добавить частый вопрос</h3>
            <button @click="showFAQModal = false" class="text-gray-400 hover:text-white">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
              </svg>
            </button>
          </div>

          <form @submit.prevent="addFAQ" class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-300 mb-1">Вопрос</label>
              <input v-model="newFAQ.question" type="text" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-300 mb-1">Ответ</label>
              <textarea v-model="newFAQ.answer" rows="4" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500"></textarea>
            </div>

            <div class="flex justify-end space-x-3 pt-4">
              <button @click="showFAQModal = false" type="button" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg text-gray-300 transition">
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
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

// Табы
const tabs = [
  { id: 'events', title: 'Мероприятия', icon: 'text-emerald-400', iconPath: 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10' },
  { id: 'gallery', title: 'Галерея', icon: 'text-blue-400', iconPath: 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z' },
  { id: 'info', title: 'Информация', icon: 'text-purple-400', iconPath: 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z' }
]
const activeTab = ref('events')

// События
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

// Галерея
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

// Команда
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

// FAQ
const faqs = ref([
  {
    id: 1,
    question: 'Как присоединиться к движению?',
    answer: 'Просто зарегистрируйтесь на нашем сайте и выберите интересующее мероприятие. Никаких специальных требований нет!'
  },
  {
    id: 2,
    question: 'Нужно ли приносить свой инвентарь?',
    answer: 'Нет, мы обеспечиваем всех участников перчатками, мешками и другим необходимым инвентарем.'
  }
])

const showFAQModal = ref(false)
const newFAQ = ref({ question: '', answer: '' })

function addFAQ() {
  if (!newFAQ.value.question || !newFAQ.value.answer) return
  
  const newItem = {
    id: Math.max(...faqs.value.map(i => i.id), 0) + 1,
    question: newFAQ.value.question,
    answer: newFAQ.value.answer
  }
  
  faqs.value.push(newItem)
  resetFAQForm()
}

function resetFAQForm() {
  newFAQ.value = { question: '', answer: '' }
  showFAQModal.value = false
}

function editFAQ(faq) {
  // Реализация редактирования
  console.log('Редактировать FAQ:', faq)
}

function deleteFAQ(faq) {
  if (confirm(`Удалить вопрос "${faq.question}"?`)) {
    faqs.value = faqs.value.filter(f => f.id !== faq.id)
  }
}

// Вычисляемый заголовок текущей вкладки
const currentTabTitle = computed(() => {
  const tab = tabs.find(t => t.id === activeTab.value)
  return tab ? tab.title : 'Панель управления'
})
</script>