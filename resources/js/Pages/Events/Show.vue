<template>
  <AppLayout>
    <!-- Герой-секция мероприятия -->
    <section class="relative">
      <img 
        :src="event.image_url" 
        class="absolute inset-0 object-cover w-full h-full brightness-75" 
        alt="Фон мероприятия"
      >
      <div class="relative bg-gray-900 bg-opacity-85 text-white py-24">
        <div class="container mx-auto px-4">
          <div class="max-w-3xl">
            <div class="mb-4">
              <span class="px-3 py-1 bg-emerald-500 rounded-full text-sm font-medium">
                {{ statusLabel }}
              </span>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold mb-4 text-white">{{ event.title }}</h1>
            <div class="flex items-center text-xl text-gray-200">
              <i class="fa fa-calendar w-6 h-6 mr-2 mt-1 text-emerald-400"></i>
              {{ formattedDate }}
            </div>
            <div class="flex items-center text-xl mt-2 text-gray-200">
              <i class="fa fa-location w-6 h-6 mr-2 mt-1 text-emerald-400"></i>
              {{ event.location }}
            </div>
            
            <div class="mt-8 flex flex-wrap items-center gap-4">
              <!-- Кнопка участия -->
              <button 
                @click="toggleMembership"
                :class="[
                  'px-8 py-3 rounded-lg font-bold flex items-center transition-all shadow-lg',
                  isMembership 
                    ? 'bg-gray-700 hover:bg-gray-600 text-white' 
                    : 'bg-emerald-500 hover:bg-emerald-600 text-gray-900'
                ]"
              >
                <i v-if="!isMembership" class="fa fa-user-plus w-5 h-5 mr-2"></i>
                <i v-else class="fa fa-user-minus w-5 h-5 mr-2"></i>
                {{ isMembership ? 'Отменить участие' : 'Участвовать' }}
              </button>
              
              <div class="flex items-center bg-gray-800 bg-opacity-70 px-4 py-2 rounded-lg text-gray-200">
                <i class="fa fa-users w-5 h-5 mr-2 text-emerald-400"></i>
                <span>{{ event.members_count }} участников</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Основной контент -->
    <section class="py-16 bg-gray-900">
      <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
          <!-- Описание мероприятия -->
          <div class="lg:col-span-2">
            <h2 class="text-3xl font-bold mb-6 text-white">Описание мероприятия</h2>
            <div class="prose prose-invert max-w-none">
              <p class="text-gray-300">{{ event.description }}</p>
            </div>
          </div>
          
          <!-- Детали мероприятия -->
          <div>
            <div class="bg-gray-800 border border-gray-700 rounded-xl p-6 sticky top-6 shadow-xl">
              <h3 class="text-xl font-bold mb-4 text-white">Детали мероприятия</h3>
              
              <div class="space-y-4">
                <div class="flex">
                  <i class="fa fa-calendar w-5 h-5 text-emerald-400 mr-3 mt-1.5"></i>
                  <div>
                    <p class="font-medium text-gray-300">Дата и время</p>
                    <p class="text-white">{{ formattedDate }}, {{ formattedTime }}</p>
                  </div>
                </div>
                
                <div class="flex">
                  <i class="fa fa-clock w-5 h-5 text-emerald-400 mr-3 mt-1.5"></i>
                  <div>
                    <p class="font-medium text-gray-300">Длительность</p>
                    <p class="text-white">2-3 часа</p>
                  </div>
                </div>
                
                <div class="flex">
                  <i class="fa fa-map w-5 h-5 text-emerald-400 mr-3 mt-1.5"></i>
                  <div>
                    <p class="font-medium text-gray-300">Место встречи</p>
                    <p class="text-white mb-1">{{ event.location }}</p>
                    <a 
                      href="#" 
                      class="text-emerald-400 hover:text-emerald-300 hover:underline inline-block transition-colors"
                    >
                      Посмотреть на карте
                    </a>
                  </div>
                </div>
                
                <div class="flex">
                  <i class="fa fa-user w-5 h-5 text-emerald-400 mr-3 mt-1.5"></i>
                  <div>
                    <p class="font-medium text-gray-300">Организатор</p>
                    <p class="text-white">Экологическое сообщество "Зеленый город"</p>
                  </div>
                </div>
              </div>
              
              <div class="mt-8 pt-6 border-t border-gray-700">
                <h3 class="text-lg font-bold mb-3 text-white">Поделиться мероприятием</h3>
                <div class="flex space-x-3">
                  <button class="w-10 h-10 rounded-full bg-gray-700 hover:bg-gray-600 transition-all flex items-center justify-center text-emerald-400 hover:text-white">
                    <i class="fa-brands fa-instagram w-5 h-5 mt-0.5"></i>
                  </button>
                  <button class="w-10 h-10 rounded-full bg-gray-700 hover:bg-gray-600 transition-all flex items-center justify-center text-emerald-400 hover:text-white">
                    <i class="fa-brands fa-telegram w-5 h-5 mt-0.5"></i>
                  </button>
                  <button class="w-10 h-10 rounded-full bg-gray-700 hover:bg-gray-600 transition-all flex items-center justify-center text-emerald-400 hover:text-white">
                    <i class="fa-brands fa-whatsapp w-5 h-5 mt-0.5"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { ref, computed } from 'vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
  event: Object,
  initialMembership: Boolean
})

const isMembership = ref(props.initialMembership)
const isProcessing = ref(false) // Флаг для блокировки кнопки

const toggleMembership = async () => {
  if (isProcessing.value) return
  
  isProcessing.value = true
  const newMembershipState = !isMembership.value
  
  try {
    if (newMembershipState) {
      await router.post(`/events/${props.event.id}/join`, {}, {
        preserveScroll: true,
        onSuccess: () => {
          // Не изменяем props напрямую!
          isMembership.value = true
        }
      })
    } else {
      await router.delete(`/events/${props.event.id}/leave`, {
        preserveScroll: true,
        onSuccess: () => {
          isMembership.value = false
        }
      })
    }
  } finally {
    isProcessing.value = false
  }
}

// Форматирование даты и времени
const formattedDate = computed(() => {
  return new Date(props.event.starts_at).toLocaleDateString('ru-RU', {
    day: 'numeric',
    month: 'long',
    year: 'numeric'
  })
})

const formattedTime = computed(() => {
  return new Date(props.event.starts_at).toLocaleTimeString('ru-RU', {
    hour: '2-digit',
    minute: '2-digit'
  })
})

// Метка статуса мероприятия
const statusLabel = computed(() => {
  const now = new Date()
  const startDate = new Date(props.event.starts_at)
  const endDate = new Date(props.event.ends_at)
  
  if (now < startDate) return 'Предстоящее'
  if (now >= startDate && now <= endDate) return 'Идет сейчас'
  return 'Завершено'
})
</script>