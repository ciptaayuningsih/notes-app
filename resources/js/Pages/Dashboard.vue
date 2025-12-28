<script setup>
import MainLayout from '@/Components/Layouts/MainLayout.vue'

defineProps({
  stats: Object,
  latestNotes: Array
})

// Warna card (sama seperti Subjects/Notes)
const colors = [
  'bg-gradient-to-br from-yellow-200 to-yellow-300',
  'bg-gradient-to-br from-orange-200 to-orange-300',
  'bg-gradient-to-br from-green-200 to-green-300',
  'bg-gradient-to-br from-purple-200 to-purple-300',
  'bg-gradient-to-br from-blue-200 to-blue-300',
  'bg-gradient-to-br from-pink-200 to-pink-300',
]
const getColor = (id) => colors[id % colors.length]
</script>

<template>
  <MainLayout>
    <div class="bg-zinc-50 min-h-screen">
      <div class="p-6">

        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
          <h1 class="text-3xl font-bold text-zinc-800 flex items-center gap-2">
            <i class="ph ph-chart-line-up text-indigo-600 text-2xl"></i>
            Dashboard Belajar
          </h1>
        </div>

        <!-- Statistik -->
        <div class="grid md:grid-cols-3 gap-6 mb-10">

          <!-- Total Catatan -->
          <div class="bg-green-200 rounded-xl p-5 border border-zinc-200 shadow-sm hover:shadow-md transition">
            <div class="flex items-center gap-3 text-sm text-zinc-500">
              <div class="p-2 rounded-lg bg-green-100 text-green-600">
                <i class="ph ph-note-pencil"></i>
              </div>
              Total Catatan
            </div>
            <div class="text-3xl font-bold text-zinc-800 mt-4">
              {{ stats.notes }}
            </div>
          </div>

          <!-- Mata Pelajaran -->
          <div class="bg-blue-200 rounded-xl p-5 border border-zinc-200 shadow-sm hover:shadow-md transition">
            <div class="flex items-center gap-3 text-sm text-zinc-500">
              <div class="p-2 rounded-lg bg-blue-100 text-blue-600">
                <i class="ph ph-book-open"></i>
              </div>
              Mata Pelajaran
            </div>
            <div class="text-3xl font-bold text-zinc-800 mt-4">
              {{ stats.subjects }}
            </div>
          </div>

        </div>

        <!-- Catatan Terbaru -->
        <div>
          <h2 class="text-xl font-semibold text-zinc-800 mb-4 flex items-center gap-2">
            <i class="ph ph-clock-counter-clockwise text-indigo-600"></i>
            Catatan Terbaru
          </h2>

          <div v-if="latestNotes.length === 0"
            class="bg-white rounded-xl p-6 border border-zinc-200 shadow-sm text-center text-zinc-500">
            Belum ada catatan.
          </div>

          <div class="grid md:grid-cols-2 gap-6">
            <div v-for="note in latestNotes" :key="note.id"
              :class="[getColor(note.id), 'rounded-xl p-5 border border-zinc-200 shadow-sm hover:shadow-md transition']">
              <h3 class="font-semibold text-zinc-800 flex items-center gap-2">
                <i class="ph ph-file-text text-indigo-600"></i>
                {{ note.title }}
              </h3>

              <p class="text-sm text-zinc-500 mt-1">
                {{ note.subject.name }}
              </p>

              <p class="text-sm text-zinc-600 mt-3 line-clamp-4">
                {{ note.content }}
              </p>
            </div>
          </div>
        </div>

      </div>
    </div>
  </MainLayout>
</template>
