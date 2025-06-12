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
              @click="changeFilter(filter.value)"
              :class="[
                'px-5 py-2.5 rounded-full font-medium transition',
                currentStatus === filter.value 
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
    <section class="py-16 bg-gray-900">
      <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <EventCard 
            v-for="event in events.data" 
            :key="event.id"
            :id="event.id"
            :title="event.title"
            :starts_at="event.starts_at"
            :location="event.location"
            :members_count="event.members_count"
            :image_url="event.image_url"
            :status="event.status"
          />
        </div>

        <!-- Сообщение если нет мероприятий -->
        <div v-if="!events.data.length" class="text-center py-12">
          <div class="text-gray-400 text-lg">
            Мероприятий с выбранным фильтром не найдено
          </div>
        </div>

        <!-- Пагинация -->
        <Pagination 
          :pagination-data="events"
          route-name="events"
          :query-params="{ status: currentStatus }"
          items-label="мероприятий"
        />
      </div>
    </section>

    <!-- Призыв к действию -->
    <section class="py-20 bg-gradient-to-r from-gray-800 to-emerald-900">
      <div class="container mx-auto px-4 text-center text-white">
        <h2 class="text-3xl font-bold mb-6">Отправьте предложение</h2>
        <p class="text-xl mb-10 max-w-2xl mx-auto text-emerald-100">
          Хотите предложить место для уборки? Мы рассмотрим ваше предложение!
        </p>
        <Link 
          href="/events/create" 
          class="inline-block px-8 py-4 bg-white text-emerald-700 font-bold rounded-lg text-lg hover:bg-emerald-50 transition shadow-lg">
          Отправить предложение
        </Link>
      </div>
    </section>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import EventCard from '@/Components/UI/EventCard.vue'
import Pagination from '@/Components/UI/Pagination.vue'
import { Link, router } from '@inertiajs/vue3'

const props = defineProps({
  events: Object,
  currentStatus: String,
  filters: Array
})

// Функция для изменения фильтра
const changeFilter = (status) => {
  router.get('/events', 
    { status: status, page: 1 }, 
    { 
      preserveState: true,
      replace: true 
    }
  )
}
</script>