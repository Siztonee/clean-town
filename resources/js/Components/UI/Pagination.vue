<template>
  <div v-if="paginationData.last_page > 1" class="mt-12 flex justify-center">
    <div class="flex items-center space-x-2">
      <!-- Кнопка "Назад" -->
      <button 
        @click="goToPage(paginationData.current_page - 1)"
        :disabled="!paginationData.prev_page_url"
        :class="[
          'px-3 py-2 rounded-lg font-medium transition',
          paginationData.prev_page_url 
            ? 'bg-gray-700 text-gray-300 hover:bg-gray-600' 
            : 'bg-gray-800 text-gray-500 cursor-not-allowed'
        ]">
        ← Назад
      </button>

      <!-- Номера страниц -->
      <template v-for="page in getPageNumbers()" :key="page">
        <button 
          v-if="page !== '...'"
          @click="goToPage(page)"
          :class="[
            'w-10 h-10 rounded-lg flex items-center justify-center font-medium transition',
            paginationData.current_page === page 
              ? 'bg-emerald-600 text-white shadow-md' 
              : 'bg-gray-700 text-gray-300 hover:bg-gray-600'
          ]">
          {{ page }}
        </button>
        <span v-else class="text-gray-400 px-2">...</span>
      </template>

      <!-- Кнопка "Вперед" -->
      <button 
        @click="goToPage(paginationData.current_page + 1)"
        :disabled="!paginationData.next_page_url"
        :class="[
          'px-3 py-2 rounded-lg font-medium transition',
          paginationData.next_page_url 
            ? 'bg-gray-700 text-gray-300 hover:bg-gray-600' 
            : 'bg-gray-800 text-gray-500 cursor-not-allowed'
        ]">
        Вперед →
      </button>
    </div>
  </div>

  <!-- Информация о пагинации -->
  <div v-if="paginationData.total > 0 && showInfo" class="mt-6 text-center text-gray-400 text-sm">
    Показано {{ paginationData.from }}-{{ paginationData.to }} из {{ paginationData.total }} {{ itemsLabel }}
  </div>
</template>

<script setup>
import { router } from '@inertiajs/vue3'

const props = defineProps({
  paginationData: {
    type: Object,
    required: true
  },
  routeName: {
    type: String,
    required: true
  },
  queryParams: {
    type: Object,
    default: () => ({})
  },
  itemsLabel: {
    type: String,
    default: 'элементов'
  },
  showInfo: {
    type: Boolean,
    default: true
  }
})

// Функция для перехода на страницу
const goToPage = (page) => {
  if (page < 1 || page > props.paginationData.last_page) return
  
  const params = {
    ...props.queryParams,
    page: page
  }
  
  router.get(route(props.routeName), params, { 
    preserveState: true, 
    replace: true 
  })
}

// Функция для генерации номеров страниц с многоточием
const getPageNumbers = () => {
  const current = props.paginationData.current_page
  const last = props.paginationData.last_page
  const pages = []
  
  if (last <= 7) {
    // Если страниц мало, показываем все
    for (let i = 1; i <= last; i++) {
      pages.push(i)
    }
  } else {
    // Логика с многоточием
    if (current <= 4) {
      // Показываем первые страницы
      for (let i = 1; i <= 5; i++) {
        pages.push(i)
      }
      pages.push('...')
      pages.push(last)
    } else if (current >= last - 3) {
      // Показываем последние страницы
      pages.push(1)
      pages.push('...')
      for (let i = last - 4; i <= last; i++) {
        pages.push(i)
      }
    } else {
      // Показываем страницы вокруг текущей
      pages.push(1)
      pages.push('...')
      for (let i = current - 1; i <= current + 1; i++) {
        pages.push(i)
      }
      pages.push('...')
      pages.push(last)
    }
  }
  
  return pages
}
</script>