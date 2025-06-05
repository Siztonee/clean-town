<template>
  <AdminLayout title="Info" activeTab="info">
    <div class="space-y-8">
      <!-- FAQ -->
      <div class="space-y-4">
        <div class="flex justify-between items-center">
          <h2 class="text-xl font-semibold text-white">Частые вопросы</h2>
          <button
            @click="showFAQModal = true"
            class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 rounded-lg text-white flex items-center transition"
          >
            <svg
              class="w-5 h-5 mr-2"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
              />
            </svg>
            Добавить вопрос
          </button>
        </div>

        <!-- Список FAQ -->
        <div class="space-y-4">
          <div
            v-for="(faq, index) in faqs"
            :key="index"
            class="bg-gray-700/50 rounded-xl p-6"
          >
            <div class="flex justify-between items-start">
              <div class="flex-1">
                <h3 class="text-lg font-semibold text-white mb-2">{{ faq.question }}</h3>
                <p class="text-gray-300">{{ faq.answer }}</p>
              </div>
              <div class="flex space-x-2 ml-4">
                <button @click="editFAQ(faq)" class="text-blue-400 hover:text-blue-300">
                  <svg
                    class="w-5 h-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                    />
                  </svg>
                </button>
                <button @click="deleteFAQ(faq)" class="text-red-400 hover:text-red-300">
                  <svg
                    class="w-5 h-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                    />
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <transition name="fade">
      <div
        v-if="showFAQModal"
        class="fixed inset-0 bg-black/70 flex items-center justify-center p-4 z-50"
      >
        <div class="bg-gray-800 rounded-xl p-6 w-full max-w-2xl">
          <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-white">Добавить частый вопрос</h3>
            <button @click="showFAQModal = false" class="text-gray-400 hover:text-white">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M6 18L18 6M6 6l12 12"
                />
              </svg>
            </button>
          </div>

          <form @submit.prevent="addFAQ" class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-300 mb-1">Вопрос</label>
              <input
                v-model="newFAQ.question"
                type="text"
                class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500"
              />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-300 mb-1">Ответ</label>
              <textarea
                v-model="newFAQ.answer"
                rows="4"
                class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500"
              ></textarea>
            </div>

            <div class="flex justify-end space-x-3 pt-4">
              <button
                @click="showFAQModal = false"
                type="button"
                class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg text-gray-300 transition"
              >
                Отменить
              </button>
              <button
                type="submit"
                class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 rounded-lg text-white transition"
              >
                Добавить
              </button>
            </div>
          </form>
        </div>
      </div>
    </transition>
  </AdminLayout>
</template>

<script setup>
import { ref, computed } from "vue";
import AdminLayout from "@/Pages/Admin/Layouts/AdminLayout.vue";

const faqs = ref([
  {
    id: 1,
    question: "Как присоединиться к движению?",
    answer:
      "Просто зарегистрируйтесь на нашем сайте и выберите интересующее мероприятие. Никаких специальных требований нет!",
  },
  {
    id: 2,
    question: "Нужно ли приносить свой инвентарь?",
    answer:
      "Нет, мы обеспечиваем всех участников перчатками, мешками и другим необходимым инвентарем.",
  },
]);

const showFAQModal = ref(false);
const newFAQ = ref({ question: "", answer: "" });

function addFAQ() {
  if (!newFAQ.value.question || !newFAQ.value.answer) return;

  const newItem = {
    id: Math.max(...faqs.value.map((i) => i.id), 0) + 1,
    question: newFAQ.value.question,
    answer: newFAQ.value.answer,
  };

  faqs.value.push(newItem);
  resetFAQForm();
}

function resetFAQForm() {
  newFAQ.value = { question: "", answer: "" };
  showFAQModal.value = false;
}

function editFAQ(faq) {
  // Реализация редактирования
  console.log("Редактировать FAQ:", faq);
}

function deleteFAQ(faq) {
  if (confirm(`Удалить вопрос "${faq.question}"?`)) {
    faqs.value = faqs.value.filter((f) => f.id !== faq.id);
  }
}
</script>
