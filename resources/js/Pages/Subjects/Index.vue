<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import { Dialog, DialogPanel, TransitionRoot } from '@headlessui/vue'
import Sidebar from '@/Components/Sidebar.vue'

/* Sidebar toggle */
const sidebarOpen = ref(false)

/* Modal & Form */
const showModal = ref(false)
const isEdit = ref(false)
const selectedId = ref(null)

const form = useForm({
  name: ''
})

/* Props */
defineProps({
  subjects: Array
})

/* CREATE */
const submit = () => {
  form.post('/subjects', { onSuccess: resetForm })
}

/* EDIT */
const openEdit = (subject) => {
  isEdit.value = true
  selectedId.value = subject.id
  form.name = subject.name
  showModal.value = true
}

const update = () => {
  form.put(`/subjects/${selectedId.value}`, { onSuccess: resetForm })
}

/* DELETE */
const destroy = (id) => {
  if (confirm('Yakin ingin menghapus mata pelajaran ini?')) {
    form.delete(`/subjects/${id}`)
  }
}

/* RESET */
const resetForm = () => {
  form.reset()
  isEdit.value = false
  selectedId.value = null
  showModal.value = false
}

/* Warna card */
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
  <div class="flex min-h-screen bg-gray-100">
    <!-- Sidebar -->
    <Sidebar :show="sidebarOpen" @close="sidebarOpen = false" />

    <!-- Hamburger (mobile only) -->
    <button
      class="fixed top-4 left-4 z-50 md:hidden bg-white shadow p-2 rounded-full text-2xl"
      @click="sidebarOpen = true"
      aria-label="Buka Sidebar"
    >
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-7 h-7">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
      </svg>
    </button>

    <!-- Konten utama -->
    <div class="flex-1 p-8">
      <!-- Header -->
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">📚 Mata Pelajaran</h1>
        <p class="text-gray-500">Kelola catatan berdasarkan pelajaran</p>
      </div>

      <!-- Cards -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <div
          v-for="subject in subjects"
          :key="subject.id"
          :class="[getColor(subject.id), 'rounded-2xl p-6 shadow-md hover:shadow-xl transition']"
        >
          <div class="flex justify-between items-start">
            <h3 class="font-semibold text-lg text-gray-800">{{ subject.name }}</h3>
            <div class="flex gap-2">
              <button @click="openEdit(subject)" title="Edit">✏️</button>
              <button @click="destroy(subject.id)" title="Hapus">🗑</button>
            </div>
          </div>
          <p class="mt-3 text-sm text-gray-700">{{ subject.notes_count ?? 0 }} catatan</p>
        </div>
      </div>

      <!-- Floating Button -->
      <button
        @click="showModal = true"
        class="fixed bottom-8 right-8 bg-indigo-600 hover:bg-indigo-700 text-white w-14 h-14 rounded-full shadow-lg text-3xl"
        style="z-index:60"
      >
        +
      </button>

      <!-- Modal -->
      <TransitionRoot :show="showModal" as="template">
        <Dialog class="relative z-50" @close="resetForm">
          <div class="fixed inset-0 bg-black/40" />
          <div class="fixed inset-0 flex items-center justify-center p-4">
            <DialogPanel class="bg-white rounded-2xl p-6 w-full max-w-md shadow-xl">
              <h2 class="text-xl font-semibold mb-4 text-gray-800">
                {{ isEdit ? 'Edit Mata Pelajaran' : 'Tambah Mata Pelajaran' }}
              </h2>

              <input
                v-model="form.name"
                type="text"
                placeholder="Nama Pelajaran"
                class="w-full border border-gray-300 rounded-lg p-3 mb-4 focus:ring-indigo-300"
              />

              <div class="flex justify-end gap-2">
                <button @click="resetForm" class="px-4 py-2 rounded-lg border">Batal</button>
                <button
                  v-if="isEdit"
                  @click="update"
                  class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg"
                >
                  Update
                </button>
                <button
                  v-else
                  @click="submit"
                  class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg"
                >
                  Simpan
                </button>
              </div>
            </DialogPanel>
          </div>
        </Dialog>
      </TransitionRoot>
    </div>
  </div>
</template>
