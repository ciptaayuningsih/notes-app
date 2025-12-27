<script setup>
import Sidebar from '@/Components/Sidebar.vue'

defineProps({
  stats: Object,
  latestNotes: Array
})

/* Sidebar toggle */
import { ref } from 'vue'
const sidebarOpen = ref(false)
</script>

<template>
  <div class="flex min-h-screen bg-gray-100">
    <!-- Sidebar -->
    <Sidebar :show="sidebarOpen" @close="sidebarOpen=false" />

    <!-- Hamburger -->
    <button
      class="fixed top-4 left-4 z-50 md:hidden bg-white shadow p-2 rounded-full text-2xl"
      @click="sidebarOpen=true"
    >
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-7 h-7">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
      </svg>
    </button>

    <!-- Konten utama -->
    <div class="flex-1 max-w-6xl mx-auto">
      <h1 class="text-3xl font-bold mb-8">📘 Dashboard Belajar</h1>

      <!-- Statistik -->
      <div class="grid md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white rounded-xl shadow p-6">
          <p class="text-gray-500">Total Catatan</p>
          <h2 class="text-3xl font-bold">{{ stats.notes }}</h2>
        </div>
        <div class="bg-white rounded-xl shadow p-6">
          <p class="text-gray-500">Mata Pelajaran</p>
          <h2 class="text-3xl font-bold">{{ stats.subjects }}</h2>
        </div>
        <div class="bg-white rounded-xl shadow p-6">
          <p class="text-gray-500">Favorit</p>
          <h2 class="text-3xl font-bold">{{ stats.favorites }}</h2>
        </div>
      </div>

      <!-- Catatan Terbaru -->
      <div>
        <h2 class="text-xl font-semibold mb-4">📝 Catatan Terbaru</h2>

        <div v-if="latestNotes.length === 0" class="text-gray-500">
          Belum ada catatan.
        </div>

        <div class="grid md:grid-cols-2 gap-4">
          <div v-for="note in latestNotes" :key="note.id" class="bg-white rounded-xl shadow p-5">
            <h3 class="font-semibold">{{ note.title }}</h3>
            <p class="text-sm text-gray-500">{{ note.subject.name }}</p>
            <p class="mt-2 text-gray-700 line-clamp-4">{{ note.content }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
