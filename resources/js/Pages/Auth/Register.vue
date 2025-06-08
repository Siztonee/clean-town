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
                  class="w-full pl-10 pr-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition"
                  placeholder="Придумайте имя"
                  autocomplete="off"
                >
              </div>
            </div>

            <!-- Поле: Email или телефон -->
            <div class="mb-5">
              <label for="emailOrPhone" class="block text-gray-300 mb-2 text-sm font-medium">Email или телефон</label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <i class="fa fa-at text-gray-500"></i>
                </div>
                <input 
                  type="text" 
                  id="emailOrPhone"
                  class="w-full pl-10 pr-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition"
                  placeholder="example@mail.com"
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
                  type="password" 
                  id="password"
                  class="w-full pl-10 pr-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition"
                  placeholder="Не менее 8 символов"
                >
                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-300">
                  <i class="fa fa-eye"></i>
                </button>
              </div>
              <div class="mt-2 flex items-center">
                <div class="w-1/4 h-1 bg-gray-700 rounded mr-1"></div>
                <div class="w-1/4 h-1 bg-gray-700 rounded mr-1"></div>
                <div class="w-1/4 h-1 bg-gray-700 rounded mr-1"></div>
                <div class="w-1/4 h-1 bg-gray-700 rounded"></div>
                <span class="text-xs text-gray-500 ml-2">Сложность пароля</span>
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
            <button 
              type="button"
              class="w-full flex items-center justify-center bg-gray-700 hover:bg-gray-600 text-white py-3.5 rounded-lg transition-all duration-200 mb-6"
            >
              <div class="bg-white w-6 h-6 rounded-full flex items-center justify-center mr-3">
                <i class="fa-brands fa-google text-red-500"></i>
              </div>
              <span class="font-medium">Продолжить с Google</span>
            </button>

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
          <a href="#" class="text-emerald-400 hover:text-emerald-300 font-medium ml-2 transition-colors">Войти в аккаунт</a>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
const register = () => {
  // Логика регистрации
  console.log('Регистрация...')
}
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

body {
  font-family: 'Inter', sans-serif;
  background-color: #0f172a;
}

/* Анимация градиента */
.bg-gradient-to-br {
  background-size: 200% 200%;
  animation: gradientAnimation 10s ease infinite;
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