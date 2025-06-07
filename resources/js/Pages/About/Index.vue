<template>
  <AppLayout>
    <!-- Герой-секция -->
    <section class="relative bg-gray-900 text-white py-24">
      <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
          <h1 class="text-4xl md:text-5xl font-bold mb-6">О движении CleanTown</h1>
          <p class="text-xl text-gray-300">
            Мы объединяем людей, которые хотят видеть свои города чистыми и ухоженными
          </p>
        </div>
      </div>
    </section>

    <!-- Наша миссия -->
    <section class="py-20 bg-gray-800">
      <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row items-center gap-12">
          <div class="md:w-1/2">
            <div class="bg-gray-700 rounded-2xl overflow-hidden aspect-video"></div>
          </div>
          <div class="md:w-1/2">
            <h2 class="text-3xl font-bold text-white mb-6">Наша миссия</h2>
            <p class="text-gray-300 mb-4">
              CleanTown - это волонтерское движение, созданное с целью объединения людей для борьбы 
              с загрязнением городской среды и природных территорий.
            </p>
            <p class="text-gray-300 mb-6">
              Мы верим, что совместными усилиями можем сделать наши города чище, безопаснее 
              и привлекательнее для жизни. Каждое мероприятие - это не просто уборка, а шаг к 
              экологическому просвещению и формированию ответственного общества.
            </p>
            <div class="flex items-center space-x-4">
              <div class="flex items-center text-emerald-400">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Экологичность</span>
              </div>
              <div class="flex items-center text-emerald-400">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Сообщество</span>
              </div>
              <div class="flex items-center text-emerald-400">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Ответственность</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Наша история -->
    <section class="py-20 bg-gray-900">
      <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto text-center mb-16">
          <h2 class="text-3xl font-bold text-white mb-4">Наша история</h2>
          <p class="text-gray-300">
            От маленькой инициативной группы до всероссийского движения
          </p>
        </div>

        <div class="relative">
          <!-- Вертикальная линия -->
          <div class="absolute left-1/2 transform -translate-x-1/2 h-full w-0.5 bg-emerald-500"></div>
          
          <!-- Точки на временной линии -->
          <div class="flex flex-col space-y-12">
            <div 
              v-for="(milestone, index) in milestones" 
              :key="index"
              :class="[
                'relative flex items-center',
                index % 2 === 0 ? 'md:flex-row-reverse' : ''
              ]">
              <!-- Точка -->
              <div class="absolute left-1/2 transform -translate-x-1/2 w-6 h-6 rounded-full bg-emerald-500 z-10"></div>
              
              <!-- Контент -->
              <div 
                :class="[
                  'w-full md:w-5/12 p-6 rounded-xl bg-gray-800',
                  index % 2 === 0 ? 'md:mr-auto md:pr-16' : 'md:ml-auto md:pl-16'
                ]">
                <div class="text-emerald-400 font-bold mb-2">{{ milestone.date }}</div>
                <h3 class="text-xl font-bold text-white mb-3">{{ milestone.title }}</h3>
                <p class="text-gray-300">{{ milestone.description }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Команда -->
    <section class="py-20 bg-gray-800">
      <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto text-center mb-16">
          <h2 class="text-3xl font-bold text-white mb-4">Наша команда</h2>
          <p class="text-gray-300">
            Люди, которые делают CleanTown возможным
          </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
          <TeamMember 
            v-for="(member, index) in props.teamMembers" 
            :key="index"
            :name="member.name"
            :role="member.role"
            :bio="member.bio"
            :profile_url="member.profile_url"
          />
        </div>
      </div>
    </section>

    <!-- FAQ -->
    <section class="py-20 bg-gray-900">
      <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto">
          <h2 class="text-3xl font-bold text-white mb-12 text-center">Частые вопросы</h2>
          
          <div class="space-y-4">
            <FAQItem 
              v-for="(faqItem, index) in faq" 
              :key="index"
              :question="faqItem.question"
              :answer="faqItem.answer"
            />
          </div>
        </div>
      </div>
    </section>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import TeamMember from '@/Pages/About/Components/TeamMember.vue'
import FAQItem from '@/Pages/About/Components/FAQItem.vue'

const props = defineProps({
  teamMembers: Object,
  faq: Object
})

const milestones = [
  {
    date: 'Май 2018',
    title: 'Первая уборка',
    description: 'Группа из 15 волонтеров провела уборку в Центральном парке, собрав 300 кг мусора'
  },
  {
    date: 'Сентябрь 2019',
    title: 'Официальная регистрация',
    description: 'CleanTown зарегистрирован как общественное экологическое движение'
  },
  {
    date: 'Апрель 2020',
    title: '10 000 участников',
    description: 'К движению присоединился 10-тысячный участник из Новосибирска'
  },
  {
    date: '2022',
    title: 'Федеральный масштаб',
    description: 'Проведены мероприятия в 45 городах России с общим участием 15 000 человек'
  }
]
</script>