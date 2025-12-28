<template>
  <!-- Overlay mobile -->
  <transition name="fade">
    <div v-if="show" class="fixed inset-0 bg-black/40 z-40 md:hidden" @click="$emit('close')" />
  </transition>

  <aside :class="[
    'w-64 h-screen bg-white border-r fixed top-0 left-0 flex flex-col z-50 transition-transform duration-300',
    show ? 'translate-x-0' : '-translate-x-full',
    'md:translate-x-0 md:static md:block'
  ]">
    <!-- Header -->
    <div class="h-20 flex items-center justify-between px-5 border-b">
      <div class="flex items-center gap-3">
        <i class="ph ph-notebook text-2xl text-indigo-600"></i>
        <span class="text-2xl font-semibold text-zinc-800">MyNotes</span>
      </div>

      <button v-if="show" class="md:hidden text-2xl text-zinc-500 hover:text-zinc-800" @click="$emit('close')">
        &times;
      </button>
    </div>

    <!-- Menu -->
    <nav class="flex-1 px-3 py-4">
      <ul class="space-y-1">
        <li>
          <a href="/dashboard" :class="[
            'flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition',
            isActive('/dashboard')
              ? 'bg-indigo-900 text-indigo-50'
              : 'text-zinc-700 hover:bg-indigo-50 hover:text-indigo-700'
          ]">
            <i class="ph ph-house text-lg"></i>
            Dashboard
          </a>
        </li>

        <li>
          <a href="/notes" :class="[
            'flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition',
            isActive('/notes')
              ? 'bg-indigo-900 text-indigo-50'
              : 'text-zinc-700 hover:bg-indigo-50 hover:text-indigo-700'
          ]">
            <i class="ph ph-note-pencil text-lg"></i>
            Catatan
          </a>
        </li>

        <li>
          <a href="/subjects" :class="[
            'flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition',
            isActive('/subjects')
              ? 'bg-indigo-900 text-indigo-50'
              : 'text-zinc-700 hover:bg-indigo-50 hover:text-indigo-700'
          ]">
            <i class="ph ph-book-open text-lg"></i>
            Mata Pelajaran
          </a>
        </li>
      </ul>
    </nav>
  </aside>
</template>

<script setup>
import { computed } from 'vue'

defineProps({ show: Boolean })
defineEmits(['close'])

const currentPath = computed(() => window.location.pathname)

const isActive = (path) => {
  return currentPath.value.startsWith(path)
}
</script>
