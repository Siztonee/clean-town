<template>
  <div :class="['relative overflow-hidden rounded-xl group h-64', additionalClasses]">
    <div class="absolute inset-0 bg-cover bg-center transition-transform duration-500 group-hover:scale-110" 
         :style="`background-image: url('https://picsum.photos/seed/${Math.random()}/800/600')`"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-6">
      <div class="text-white">
        <h3 class="font-bold text-lg mb-1">Уборка пляжа</h3>
        <p class="text-emerald-300">15 августа 2023</p>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  additionalClasses: {
    type: String,
    default: ''
  }
})
</script>