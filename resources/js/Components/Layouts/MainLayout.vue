<script setup>
import Sidebar from '@/Components/Sidebar.vue'
import { ref } from 'vue'

const sidebarOpen = ref(false)
</script>

<template>
  <div class="h-screen flex bg-zinc-50 overflow-hidden">
    <!-- Sidebar (FIXED, tidak ikut scroll) -->
    <Sidebar
      :show="sidebarOpen"
      @close="sidebarOpen = false"
      class="fixed inset-y-0 left-0 z-40"
    />

    <!-- Mobile overlay handled inside Sidebar -->

    <!-- Main wrapper -->
    <div class="flex-1 flex flex-col">
      <!-- Topbar (mobile) -->
      <header
        class="h-16 flex items-center px-4 border-b bg-white md:hidden"
      >
        <button
          class="p-2 rounded-lg border text-zinc-600 hover:bg-zinc-100"
          @click="sidebarOpen = true"
        >
          <i class="ph ph-list text-xl"></i>
        </button>

        <span class="ml-3 font-semibold text-zinc-800">
          MyNotes
        </span>
      </header>

      <!-- Main Content (SCROLL DI SINI) -->
      <main class="flex-1 overflow-y-auto">
        <slot />
      </main>
    </div>
  </div>
</template>
