<template>
  <!-- Overlay for mobile -->
  <transition name="fade">
    <div
      v-if="show"
      class="fixed inset-0 bg-black/40 z-40 md:hidden"
      @click="$emit('close')"
    />
  </transition>

  <aside
    :class="[
      'w-64 h-screen bg-white shadow-md fixed top-0 left-0 flex flex-col z-50 transition-transform duration-300',
      show ? 'translate-x-0' : '-translate-x-full',
      'md:translate-x-0 md:static md:block'
    ]"
  >
    <div class="h-20 flex items-center justify-between border-b px-4">
      <span class="text-xl font-bold">📚 MyNotes</span>
      <!-- Close button on mobile -->
      <button
        class="md:hidden text-2xl p-2 focus:outline-none"
        @click="$emit('close')"
        aria-label="Tutup Sidebar"
        v-if="show"
      >
        &times;
      </button>
    </div>
    <nav class="flex-1 p-4">
      <ul class="space-y-2">
        <li><a href="/dashboard" class="block px-4 py-2 rounded hover:bg-indigo-100">Dashboard</a></li>
        <li><a href="/notes" class="block px-4 py-2 rounded hover:bg-indigo-100">Catatan</a></li>
        <li><a href="/subjects" class="block px-4 py-2 rounded hover:bg-indigo-100">Mata Pelajaran</a></li>
      </ul>
    </nav>
  </aside>
</template>

<script setup>
import { defineProps, defineEmits } from 'vue'

const props = defineProps({
  show: { type: Boolean, default: false }
})

defineEmits(['close'])
</script>

<style scoped>
.fade-enter-active, .fade-leave-active { transition: opacity 0.2s; }
.fade-enter-from, .fade-leave-to { opacity: 0; }
</style>
