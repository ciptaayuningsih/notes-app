<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import Sidebar from '@/Components/Sidebar.vue'
import Modal from '@/Components/Modal.vue'

defineProps({ notes: Array, subjects: Array })

/* Sidebar */
const sidebarOpen = ref(false)

/* Modal & Form */
const openModal = ref(false)
const isEdit = ref(false)
const selectedId = ref(null)

const form = useForm({
  title: '',
  content: '',
  subject_id: '',
})

/* Tambah Catatan */
const submit = () => {
  form.post('/notes', { onSuccess: resetForm })
}

/* Edit Catatan */
const openEdit = (note) => {
  isEdit.value = true
  selectedId.value = note.id
  form.title = note.title
  form.content = note.content
  form.subject_id = note.subject.id
  openModal.value = true
}

const update = () => {
  form.put(`/notes/${selectedId.value}`, { onSuccess: resetForm })
}

/* Hapus Catatan */
const destroy = (id) => {
  if (confirm('Yakin ingin menghapus catatan ini?')) {
    form.delete(`/notes/${id}`)
  }
}

/* Reset form */
const resetForm = () => {
  form.reset()
  isEdit.value = false
  selectedId.value = null
  openModal.value = false
}
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
    <div class="flex-1 p-6">
      <div class="flex justify-between mb-6">
        <h1 class="text-2xl font-bold">Catatan Belajar</h1>
        <button @click="openModal=true" class="bg-indigo-600 text-white px-4 py-2 rounded-lg">
          + Catatan
        </button>
      </div>

      <!-- Cards -->
      <div class="grid md:grid-cols-3 gap-6">
        <div v-for="note in notes" :key="note.id" class="bg-white p-5 rounded-xl shadow">
          <div class="flex justify-between items-start">
            <div>
              <h3 class="font-semibold">{{ note.title }}</h3>
              <p class="text-sm text-gray-500">{{ note.subject.name }}</p>
              <p class="mt-2 text-gray-700 line-clamp-3">{{ note.content }}</p>
            </div>
            <div class="flex gap-2">
              <button @click="openEdit(note)" title="Edit">✏️</button>
              <button @click="destroy(note.id)" title="Hapus">🗑</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal Tambah/Edit -->
      <Modal :show="openModal" @close="resetForm">
        <h2 class="font-semibold mb-3">{{ isEdit ? 'Edit Catatan' : 'Tambah Catatan' }}</h2>

        <input v-model="form.title" placeholder="Judul" class="w-full border rounded p-2 mb-2" />

        <select v-model="form.subject_id" class="w-full border rounded p-2 mb-2">
          <option value="">Pilih Pelajaran</option>
          <option v-for="s in subjects" :value="s.id">{{ s.name }}</option>
        </select>

        <textarea v-model="form.content" class="w-full border rounded p-2 mb-3" rows="4"></textarea>

        <div class="flex justify-end gap-2">
          <button @click="resetForm" class="px-4 py-2 rounded-lg border">Batal</button>
          <button
            v-if="isEdit"
            @click="update"
            class="bg-indigo-600 text-white px-4 py-2 rounded-lg"
          >
            Update
          </button>
          <button
            v-else
            @click="submit"
            class="bg-indigo-600 text-white px-4 py-2 rounded-lg"
          >
            Simpan
          </button>
        </div>
      </Modal>
    </div>
  </div>
</template>
