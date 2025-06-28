<template>
  <AppLayout>
    <section class="py-12 bg-gray-900 text-white">
      <div class="container mx-auto px-4">
        <!-- Заголовок и описание -->
        <div class="text-center max-w-3xl mx-auto mb-16">
          <h1 class="text-4xl md:text-5xl font-bold mb-6">Галерея мероприятий</h1>
          <p class="text-xl text-gray-300">
            Фотографии с наших экологических акций, субботников и мероприятий.
            Увидьте, как волонтеры CleanTown делают город чище!
          </p>
        </div>

        <!-- Галерея -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
          <GalleryImage
            v-for="(gallery, index) in galleries.data"
            :key="gallery.id"
            :id="gallery.id"
            :additional-classes="gallery.classes"
            :title="gallery.title"
            :preview_url="gallery.preview_url"
            :date="gallery.date"
            class="gallery-item"
            :style="{ animationDelay: `${index * 0.1}s` }"
          />
        </div>

        <!-- Сообщение если нет изображений -->
        <div v-if="!galleries.data.length" class="text-center py-12">
          <div class="text-gray-400 text-lg">
            Изображения в галерее пока не добавлены
          </div>
        </div>

        <!-- Пагинация -->
        <Pagination 
          :pagination-data="galleries"
          route-name="gallery"
          items-label="изображений"
        />
      </div>
    </section>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import GalleryImage from '@/Components/UI/GalleryImage.vue'
import Pagination from '@/Components/UI/Pagination.vue'

const props = defineProps({
  galleries: Object
})
</script>

<style scoped>
.gallery-item {
  animation: fadeIn 0.5s ease-out;
  animation-fill-mode: both;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>