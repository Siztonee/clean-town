<template>
  <AppLayout>
    <!-- Герой-секция -->
    <section class="relative bg-emerald-700 text-white">
      <div class="absolute inset-0 bg-black/30 z-0"></div>
      <div class="container mx-auto px-4 py-24 md:py-32 relative z-10">
        <div class="max-w-2xl">
          <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">
            Сделаем наш город <span class="text-emerald-300">чище</span> вместе!
          </h1>
          <p class="text-xl md:text-2xl mb-8 text-emerald-100 max-w-lg">
            Присоединяйтесь к волонтерам CleanTown для уборки парков, пляжей и городских территорий
          </p>
          <div class="flex flex-col sm:flex-row gap-4">
            <router-link 
              to="/join" 
              class="px-8 py-4 bg-white text-emerald-700 font-bold rounded-full text-lg hover:bg-emerald-100 transition shadow-lg hover:shadow-xl transform hover:-translate-y-1">
              Стать волонтером
            </router-link>
            <router-link 
              to="/events" 
              class="px-8 py-4 bg-transparent border-2 border-white text-white font-bold rounded-full text-lg hover:bg-white/10 transition">
              Смотреть мероприятия
            </router-link>
          </div>
        </div>
      </div>
      <div class="absolute bottom-0 left-0 right-0 h-16 bg-gradient-to-t from-emerald-700 to-transparent z-10"></div>
      <div class="absolute inset-0 bg-cover bg-center z-0" style="background-image: url('https://images.unsplash.com/photo-1600880292203-757bb62b4baf?q=80&w=2070&auto=format&fit=crop');"></div>
    </section>

    <!-- Секция статистики -->
    <section class="py-16 bg-emerald-50">
      <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
          <StatCard number="128" label="Проведенных мероприятий" icon="calendar" />
          <StatCard number="5,200+" label="Участников" icon="users" />
          <StatCard number="42" label="Тонн мусора собрано" icon="trash" />
          <StatCard number="18" label="Районов охвачено" icon="map" />
        </div>
      </div>
    </section>

    <!-- Ближайшие мероприятия -->
    <section class="py-20">
      <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-12">
          <h2 class="text-3xl font-bold text-gray-800">Ближайшие мероприятия</h2>
          <router-link to="/events" class="text-emerald-600 font-medium hover:underline">
            Все мероприятия →
          </router-link>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <EventCard 
            title="Уборка Центрального парка"
            date="15 сентября, 10:00"
            location="Центральный парк культуры"
            participants="Осталось 12 мест"
          />
          <EventCard 
            title="Эко-забег вдоль реки"
            date="18 сентября, 9:30"
            location="Набережная реки Волга"
            participants="Осталось 5 мест"
            :featured="true"
          />
          <EventCard 
            title="Субботник в Северном районе"
            date="22 сентября, 11:00"
            location="Лесопарк 'Северный'"
            participants="Осталось 24 места"
          />
        </div>
      </div>
    </section>

    <!-- Как это работает -->
    <section class="py-20 bg-gray-50">
      <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-16 text-gray-800">Как присоединиться</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 max-w-5xl mx-auto">
          <StepCard 
            step="1"
            title="Выберите мероприятие"
            description="Найдите событие по дате или местоположению"
            icon="calendar"
          />
          <StepCard 
            step="2"
            title="Зарегистрируйтесь"
            description="Заполните простую форму участника"
            icon="clipboard"
          />
          <StepCard 
            step="3"
            title="Приходите вовремя"
            description="Мы предоставим весь необходимый инвентарь"
            icon="clock"
          />
          <StepCard 
            step="4"
            title="Сделайте город чище"
            description="Вместе мы сделаем больше!"
            icon="heart"
          />
        </div>
      </div>
    </section>

    <!-- Галерея -->
    <section class="py-20">
      <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">Наша деятельность</h2>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
          <GalleryImage />
          <GalleryImage class="lg:row-span-2 lg:col-span-2" />
          <GalleryImage />
          <GalleryImage />
          <GalleryImage />
          <GalleryImage class="sm:col-span-2" />
        </div>
      </div>
    </section>

    <!-- Призыв к действию -->
    <section class="py-20 bg-emerald-700 text-white">
      <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-6">Готовы сделать первый шаг?</h2>
        <p class="text-xl mb-10 max-w-2xl mx-auto text-emerald-100">
          Присоединяйтесь к нашему следующему мероприятию и станьте частью позитивных изменений
        </p>
        <router-link 
          to="/events" 
          class="inline-block px-8 py-4 bg-white text-emerald-700 font-bold rounded-full text-lg hover:bg-emerald-100 transition shadow-lg">
          Выбрать мероприятие
        </router-link>
      </div>
    </section>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import EventCard from '@/Pages/Home/Components/EventCard.vue'
import StepCard from '@/Pages/Home/Components/StepCard.vue'
import StatCard from '@/Pages/Home/Components/StatCard.vue'
import GalleryImage from '@/Pages/Home/Components/GalleryImage.vue'
</script>