<template>
  <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 p-4">
    <div class="w-full max-w-md">
      <!-- Логотип -->
      <div class="text-center mb-8">
        <div class="mx-auto bg-emerald-500 w-16 h-16 rounded-full flex items-center justify-center mb-4">
          <i class="fa fa-leaf text-2xl text-white"></i>
        </div>
        <h1 class="text-3xl font-bold text-white">Создайте аккаунт</h1>
        <p class="text-gray-400 mt-2">Присоединяйтесь к нашему сообществу</p>
      </div>

      <!-- Форма регистрации -->
      <div class="bg-gray-800 rounded-2xl shadow-xl overflow-hidden">
        <div class="p-8">
          <form @submit.prevent="register">
            <!-- Поле: Имя пользователя -->
            <div class="mb-5">
              <label for="username" class="block text-gray-300 mb-2 text-sm font-medium">Имя пользователя</label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <i class="fa fa-user text-gray-500"></i>
                </div>
                <input 
                  type="text" 
                  id="username"
                  v-model="form.username"
                  class="w-full pl-10 pr-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition"
                  placeholder="Придумайте имя"
                  autocomplete="off"
                >
              </div>
            </div>

            <!-- Поле: Номер телефона -->
            <div class="mb-5">
              <label for="emailOrPhone" class="block text-gray-300 mb-2 text-sm font-medium">Номер телефона</label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <i class="fa fa-phone text-gray-500"></i>
                </div>
                <input 
                  type="text" 
                  id="phone"
                  v-model="form.phone"
                  class="w-full pl-10 pr-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition"
                  placeholder="+996-xxx-xxx-xxx"
                  autocomplete="off"
                >
              </div>
            </div>

            <!-- Поле: Пароль -->
            <div class="mb-6">
              <label for="password" class="block text-gray-300 mb-2 text-sm font-medium">Пароль</label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <i class="fa fa-lock text-gray-500"></i>
                </div>
                <input 
                  :type="showPassword ? 'text' : 'password'" 
                  id="password"
                  v-model="form.password"
                  class="w-full pl-10 pr-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition"
                  placeholder="Не менее 8 символов"
                >
                <button 
                  type="button" 
                  class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-300"
                  @click="showPassword = !showPassword"
                >
                  <i :class="showPassword ? 'fa fa-eye-slash' : 'fa fa-eye'"></i>
                </button>
              </div>
              <div class="mt-2 flex items-center">
                <div 
                  v-for="i in 4" 
                  :key="i"
                  class="w-1/4 h-1 rounded mr-1"
                  :class="{
                    [passwordStrength.color]: i <= passwordStrength.level,
                    'bg-gray-700': i > passwordStrength.level
                  }"
                ></div>
                <span class="text-xs ml-2" :class="{
                  'text-red-500': passwordStrength.level === 1,
                  'text-orange-500': passwordStrength.level === 2,
                  'text-yellow-500': passwordStrength.level === 3,
                  'text-green-500': passwordStrength.level >= 4,
                  'text-gray-500': passwordStrength.level === 0
                }">
                  {{ passwordStrength.text || 'Сложность пароля' }}
                </span>
              </div>
            </div>

            <!-- Кнопка регистрации -->
            <button 
              type="submit"
              class="w-full bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white font-bold py-3.5 rounded-lg shadow-lg transition-all duration-300 transform hover:-translate-y-0.5 mb-6"
            >
              Зарегистрироваться
            </button>

            <!-- Разделитель -->
            <div class="flex items-center mb-6">
              <div class="flex-grow border-t border-gray-700"></div>
              <span class="mx-4 text-gray-500 text-sm">или войти через</span>
              <div class="flex-grow border-t border-gray-700"></div>
            </div>

            <!-- Кнопка Google -->
            <a
              href="/login/google/redirect"
              class="w-full flex items-center justify-center bg-gray-700 hover:bg-gray-600 text-white py-3.5 rounded-lg transition-all duration-200 mb-6"
            >
              <div class="bg-white w-6 h-6 rounded-full flex items-center justify-center mr-3">
                <i class="fa-brands fa-google text-red-500 text-xs"></i>
              </div>
              <span class="font-medium">Продолжить с Google</span>
            </a>

            <!-- Соглашение -->
            <p class="text-xs text-gray-500 text-center">
              Нажимая "Зарегистрироваться", вы соглашаетесь с нашими 
              <a href="#" class="text-emerald-400 hover:text-emerald-300 transition-colors">Условиями</a> и 
              <a href="#" class="text-emerald-400 hover:text-emerald-300 transition-colors">Политикой конфиденциальности</a>
            </p>
          </form>
        </div>

        <!-- Ссылка на вход -->
        <div class="bg-gray-900 px-8 py-5 text-center">
          <span class="text-gray-400">Уже зарегистрированы?</span>
          <Link href="/login" class="text-emerald-400 hover:text-emerald-300 font-medium ml-2 transition-colors">Войти в аккаунт</Link>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { router, Link } from '@inertiajs/vue3'

const form = ref({
    username: '',
    phone: '',
    password: ''
})

const showPassword = ref(false)

const passwordStrength = computed(() => {
    if (!form.value.password) return { level: 0, text: '' }
    
    const hasLetter = /[a-zA-Zа-яА-Я]/.test(form.value.password)
    const hasDigit = /\d/.test(form.value.password)
    const hasSpecial = /[!@#$%^&*(),.?":{}|<>]/.test(form.value.password)
    const length = form.value.password.length
    
    let strength = 0
    if (length >= 8) strength += 1
    if (length >= 10) strength += 1
    if (hasLetter && hasDigit) strength += 1
    if (hasSpecial) strength += 1
    
    const levels = [
        { level: 1, text: 'Слабый', color: 'bg-red-500' },
        { level: 2, text: 'Средний', color: 'bg-orange-500' },
        { level: 3, text: 'Хороший', color: 'bg-yellow-500' },
        { level: 4, text: 'Надежный', color: 'bg-green-500' }
    ]
    
    return levels[Math.min(strength, 3)] || levels[0]
})

const register = () => {
  router.post('/register', form.value)
}
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

body {
  font-family: 'Inter', sans-serif;
  background-color: #0f172a;
}

.bg-gradient-to-br {
  background-size: 200% 200%;
  animation: gradientAnimation 10s ease infinite;
}

@keyframes gradientAnimation {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}

input:focus {
  box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
}
</style>