<script setup>

import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import MainLayout from '@/Components/Layouts/MainLayout.vue'
import Modal from '@/Components/Modal.vue'
import Swal from 'sweetalert2'

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

// Warna card (copy dari Subjects)
const colors = [
  'bg-gradient-to-br from-yellow-200 to-yellow-300',
  'bg-gradient-to-br from-orange-200 to-orange-300',
  'bg-gradient-to-br from-green-200 to-green-300',
  'bg-gradient-to-br from-purple-200 to-purple-300',
  'bg-gradient-to-br from-blue-200 to-blue-300',
  'bg-gradient-to-br from-pink-200 to-pink-300',
]
const getColor = (id) => colors[id % colors.length]

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

const destroy = (id) => {
  Swal.fire({
    title: 'Hapus catatan?',
    text: 'Catatan yang dihapus tidak dapat dikembalikan.',
    icon: 'warning',

    // ✅ RESPONSIVE SIZE
    width: window.innerWidth < 640 ? '90%' : 340,
    padding: '1.25rem',

    iconColor: '#f97316',

    showCancelButton: true,
    confirmButtonText: 'Ya, hapus',
    cancelButtonText: 'Batal',
    reverseButtons: true,
    buttonsStyling: false,

    // ✅ CUSTOM CLASS UNTUK UKURAN
    customClass: {
      popup: 'rounded-xl shadow-lg',
      icon: 'swal-small-icon',
      title: 'text-base font-semibold text-zinc-800',
      htmlContainer: 'text-sm text-zinc-500',
      actions: 'mt-3',
      confirmButton:
        'px-3 py-2 rounded-lg bg-red-600 text-white text-sm hover:bg-red-700 m-2',
      cancelButton:
        'px-3 py-2 rounded-lg border border-zinc-300 text-sm text-zinc-600 hover:bg-zinc-100 ml-2',
    }
  }).then((result) => {
    if (result.isConfirmed) {
      form.delete(`/notes/${id}`, {
        onSuccess: () => {
          Swal.fire({
            icon: 'success',
            title: 'Dihapus',
            text: 'Catatan berhasil dihapus',
            width: 300,
            padding: '1rem',
            timer: 1200,
            showConfirmButton: false,
          })
        }
      })
    }
  })
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
  <MainLayout>
    <div class="p-6">
      <div class="flex justify-between mb-6">
        <h1 class="text-2xl font-bold">Catatan Belajar</h1>
      </div>

      <!-- Cards -->
      <div class="grid md:grid-cols-3 gap-6">
        <!-- Tambah -->
        <!-- ➕ CARD TAMBAH CATATAN (URUTAN PERTAMA) -->
        <div @click="openModal = true" class="bg-white border-2 border-dashed border-indigo-300 p-5 rounded-xl shadow-sm
           cursor-pointer hover:shadow-md hover:-translate-y-1
           transition-all flex flex-col items-center justify-center text-center group">
          <i class="ph ph-plus-circle text-4xl text-indigo-500 group-hover:scale-110 transition"></i>
          <p class="mt-2 font-semibold text-indigo-600">
            Tambah Catatan
          </p>
          <p class="text-sm text-zinc-400">
            Klik untuk membuat catatan baru
          </p>
        </div>

        <!-- Catatan -->
        <div v-for="note in notes" :key="note.id" @click="openEdit(note)"
          :class="[getColor(note.id), 'p-5 rounded-xl shadow cursor-pointer hover:shadow-lg hover:-translate-y-1 transition-all group']">
          <div class="flex justify-between items-start">
            <!-- Content -->
            <div>
              <h3 class="font-bold text-lg text-zinc-950 group-hover:text-indigo-700 transition">
                {{ note.title }}
              </h3>
              <p class="text-sm text-gray-500">{{ note.subject.name }}</p>
              <p class="mt-2 text-gray-600 line-clamp-3">
                {{ note.content }}
              </p>
            </div>

            <!-- Delete -->
            <button @click.stop="destroy(note.id)" title="Hapus" class="text-red-500 hover:text-red-700 transition">
              <i class="ph-bold ph-trash text-lg"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Modal Tambah/Edit -->
      <Modal :show="openModal" @close="resetForm">
        <div class="bg-white rounded-2xl p-8 max-w-2xl w-full">

          <!-- Header -->
          <div class="flex items-center gap-3 mb-6">
            <i :class="isEdit ? 'ph-bold ph-pen' : 'ph ph-plus-circle'" class="text-indigo-600 text-xl"></i>

            <h2 class="text-xl font-extrabold text-zinc-800">
              {{ isEdit ? 'Edit Catatan' : 'Catatan Baru' }}
            </h2>
          </div>

          <!-- Judul (Heading Style) -->
          <input v-model="form.title" placeholder="Judul catatan..." class="w-full text-2xl font-bold text-zinc-900
             placeholder-zinc-400
             border-none outline-none
             focus:ring-0 mb-4" />

          <!-- Meta -->
          <div class="flex items-center gap-3 mb-6">
            <select v-model="form.subject_id" class="text-sm font-medium text-indigo-600
               bg-indigo-50 px-3 py-1.5 rounded-full
               border-none outline-none cursor-pointer">
              <option value="">Pilih pelajaran</option>
              <option v-for="s in subjects" :key="s.id" :value="s.id">
                {{ s.name }}
              </option>
            </select>
          </div>

          <!-- Divider -->
          <hr class="mb-6" />

          <!-- Isi Catatan (Article Style) -->
          <textarea v-model="form.content" rows="8" placeholder="Mulai menulis catatan di sini..." class="w-full text-zinc-700 leading-relaxed text-base
             placeholder-zinc-400
             border-none outline-none resize-none
             focus:ring-0"></textarea>

          <!-- Actions -->
          <div class="flex justify-end gap-3 mt-8">
            <button @click="resetForm" class="px-4 py-2 rounded-lg text-sm
               text-zinc-600 hover:bg-zinc-100 transition">
              Batal
            </button>

            <button v-if="isEdit" @click="update" class="px-5 py-2 rounded-lg bg-indigo-600 text-white text-sm
               hover:bg-indigo-700 transition flex items-center gap-1">
              <i class="ph ph-check"></i>
              Update
            </button>

            <button v-else @click="submit" class="px-5 py-2 rounded-lg bg-indigo-600 text-white text-sm
               hover:bg-indigo-700 transition flex items-center gap-1">
              <i class="ph ph-floppy-disk"></i>
              Simpan
            </button>
          </div>

        </div>
      </Modal>

    </div>
  </MainLayout>
</template>
