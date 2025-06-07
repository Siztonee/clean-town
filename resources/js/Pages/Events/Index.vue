<template>
  <AppLayout>
    <!-- Герой-секция -->
    <section class="relative bg-gray-900 text-white py-24">
      <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-3xl">
          <h1 class="text-4xl md:text-5xl font-bold mb-6">Наши мероприятия</h1>
          <p class="text-xl text-gray-300 mb-10">
            Присоединяйтесь к предстоящим событиям или найдите прошедшие мероприятия
          </p>
          
          <div class="flex flex-wrap gap-4">
            <button 
              v-for="(filter, index) in filters" 
              :key="index"
              @click="activeFilter = filter.value"
              :class="[
                'px-5 py-2.5 rounded-full font-medium transition',
                activeFilter === filter.value 
                  ? 'bg-emerald-600 text-white shadow-md' 
                  : 'bg-gray-800 text-gray-300 hover:bg-gray-700'
              ]">
              {{ filter.label }}
            </button>
          </div>
        </div>
      </div>
    </section>

    <!-- Сетка мероприятий -->
    <section class="py-16 bg-gray-800">
      <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <EventCard 
            v-for="(event, index) in filteredEvents" 
            :key="index"
            :title="event.title"
            :starts_at="event.starts_at"
            :location="event.location"
            :max_members="event.max_members"
            :image="event.image"
            :status="event.status"
          />
        </div>

        <!-- Пагинация -->
        <div class="mt-12 flex justify-center">
          <div class="flex space-x-2">
            <button 
              v-for="page in 5" 
              :key="page"
              :class="[
                'w-10 h-10 rounded-full flex items-center justify-center font-medium',
                currentPage === page 
                  ? 'bg-emerald-600 text-white' 
                  : 'bg-gray-700 text-gray-300 hover:bg-gray-600'
              ]">
              {{ page }}
            </button>
          </div>
        </div>
      </div>
    </section>

    <!-- Призыв к действию -->
    <section class="py-20 bg-gradient-to-r from-gray-800 to-emerald-900">
      <div class="container mx-auto px-4 text-center text-white">
        <h2 class="text-3xl font-bold mb-6">Организуйте свое мероприятие</h2>
        <p class="text-xl mb-10 max-w-2xl mx-auto text-emerald-100">
          Хотите провести уборку в своем районе? Мы поможем с организацией!
        </p>
        <Link 
          href="/events/create" 
          class="inline-block px-8 py-4 bg-white text-emerald-700 font-bold rounded-lg text-lg hover:bg-emerald-50 transition shadow-lg">
          Создать мероприятие
        </Link>
      </div>
    </section>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import EventCard from '@/Components/UI/EventCard.vue'
import { ref, computed } from 'vue'

// Фильтры
const filters = [
  { label: 'Все', value: 'all' },
  { label: 'Предстоящие', value: 'upcoming' },
  { label: 'Текущие', value: 'active' },
  { label: 'Завершенные', value: 'completed' },
  { label: 'Мои мероприятия', value: 'my' }
]

const activeFilter = ref('upcoming')
const currentPage = ref(1)

const props = defineProps({
  events: Object
})

// Фильтрация мероприятий
const filteredEvents = computed(() => {
  if (activeFilter.value === 'all') return props.events
  return props.events.filter(event => event.status === activeFilter.value)
})
</script>