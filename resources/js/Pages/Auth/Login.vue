<template>
  <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 p-4">
    <div class="w-full max-w-md">
      <!-- Логотип -->
      <div class="text-center mb-10">
        <div class="mx-auto bg-gradient-to-br from-emerald-500 to-teal-500 w-16 h-16 rounded-xl flex items-center justify-center mb-4 shadow-lg">
          <i class="fa fa-leaf text-2xl text-white"></i>
        </div>
        <h1 class="text-3xl font-bold text-white">С возвращением!</h1>
        <p class="text-gray-400 mt-2">Пожалуйста, войдите в свой аккаунт</p>
      </div>

      <!-- Форма входа -->
      <div class="bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-700">
        <div class="p-8">
          <form @submit.prevent="login">

            <div class="mb-6">
              <label for="username" class="block text-gray-300 mb-2 text-sm font-medium">Имя пользователя</label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                  <i class="fa fa-user"></i>
                </div>
                <input 
                  type="text" 
                  id="username"
                  v-model="form.username"
                  class="w-full pl-10 pr-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition"
                  placeholder="username"
                  autocomplete="username"
                >
              </div>
            </div>

            <!-- Поле: Пароль -->
            <div class="mb-6">
              <label for="password" class="block text-gray-300 mb-2 text-sm font-medium">Пароль</label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                  <i class="fa fa-lock"></i>
                </div>
                <input 
                  :type="showPassword ? 'text' : 'password'" 
                  id="password"
                  v-model="form.password"
                  class="w-full pl-10 pr-10 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition"
                  placeholder="Ваш пароль"
                >
                <button 
                  type="button" 
                  class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-300"
                  @click="showPassword = !showPassword"
                >
                  <i :class="showPassword ? 'fa fa-eye-slash' : 'fa fa-eye'"></i>
                </button>
              </div>
            </div>

            <!-- Запомнить и забыли пароль -->
            <div class="flex items-center justify-between mb-8">
              <div class="flex items-center">
                <input 
                  type="checkbox" 
                  id="remember"
                  v-model="form.remember"
                  class="w-4 h-4 text-emerald-500 bg-gray-700 border-gray-600 rounded focus:ring-emerald-500 focus:ring-2"
                >
                <label for="remember" class="ml-2 text-sm text-gray-300">Запомнить меня</label>
              </div>
              <a 
                href="#" 
                class="text-sm text-emerald-400 hover:text-emerald-300 transition-colors"
              >
                Забыли пароль?
              </a>
            </div>

            <!-- Кнопка входа -->
            <button 
              type="submit"
              :disabled="form.processing"
              :class="[
                'w-full bg-gradient-to-r from-emerald-500 to-teal-500 text-white font-bold py-3.5 rounded-lg shadow-lg transition-all duration-300 transform',
                form.processing 
                  ? 'opacity-75 cursor-not-allowed' 
                  : 'hover:from-emerald-600 hover:to-teal-600 hover:-translate-y-0.5'
              ]"
            >
              <span v-if="form.processing">
                <i class="fa fa-spinner fa-spin mr-2"></i> Вход...
              </span>
              <span v-else>Войти</span>
            </button>

            <!-- Разделитель -->
            <div class="flex items-center my-8">
              <div class="flex-grow border-t border-gray-700"></div>
              <span class="mx-4 text-gray-500 text-sm">или войти через</span>
              <div class="flex-grow border-t border-gray-700"></div>
            </div>

            <!-- Кнопка Google -->
            <Link 
              href="/login-google"
              class="w-full flex items-center justify-center bg-gray-700 hover:bg-gray-600 text-white py-3.5 rounded-lg transition-all duration-200 mb-6"
            >
              <div class="bg-white w-6 h-6 rounded-full flex items-center justify-center mr-3">
                <i class="fa-brands fa-google text-red-500 text-xs"></i>
              </div>
              <span class="font-medium">Google</span>
            </Link>

            <!-- Сообщение об ошибке -->
            <div v-if="hasErrors" class="mt-4 p-3 bg-red-500/10 border border-red-500/30 rounded-lg">
              <p class="text-sm text-red-400 text-center">
                Неверные учетные данные. Пожалуйста, попробуйте снова.
              </p>
            </div>
          </form>
        </div>

        <!-- Ссылка на регистрацию -->
        <div class="bg-gray-900 px-8 py-5 text-center border-t border-gray-700">
          <span class="text-gray-400">Еще нет аккаунта?</span>
          <Link 
            href="/register" 
            class="text-emerald-400 hover:text-emerald-300 font-medium ml-2 transition-colors"
          >
            Зарегистрироваться
          </Link>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Link, router } from '@inertiajs/vue3'

const showPassword = ref(false)

const form = ref({
  username: '',
  password: '',
  remember: false,
})

const login = () => {
  router.post('/login', form.value)
}
</script>

<style>
/* Анимация фона */
.bg-gradient-to-br {
  background-size: 200% 200%;
  animation: gradientAnimation 15s ease infinite;
}

@keyframes gradientAnimation {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}

/* Эффект свечения при фокусе */
input:focus {
  box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
}
</style>