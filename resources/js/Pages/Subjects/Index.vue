  <script setup>
  import { ref } from 'vue'
  import { useForm } from '@inertiajs/vue3'
  import { Dialog, DialogPanel, TransitionRoot } from '@headlessui/vue'
  import MainLayout from '@/Components/Layouts/MainLayout.vue'
  import Swal from 'sweetalert2'

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
    Swal.fire({
      title: 'Hapus mata pelajaran?',
      text: 'Semua catatan terkait tidak akan ikut terhapus.',
      icon: 'warning',

      // 📱 RESPONSIVE SIZE
      width: window.innerWidth < 640 ? '90%' : 360,
      padding: '1.25rem',

      iconColor: '#f97316', // orange lembut
      showCancelButton: true,
      confirmButtonText: 'Ya, hapus',
      cancelButtonText: 'Batal',
      reverseButtons: true,
      buttonsStyling: false,

      customClass: {
        popup: 'rounded-xl shadow-lg',
        icon: 'swal-small-icon',
        title: 'text-base font-semibold text-zinc-800',
        htmlContainer: 'text-sm text-zinc-500',
        actions: 'mt-4',
        confirmButton:
          'px-3 py-2 rounded-lg bg-red-600 text-white text-sm hover:bg-red-700 m-1',
        cancelButton:
          'px-3 py-2 rounded-lg border border-zinc-300 text-sm text-zinc-600 hover:bg-zinc-100 m-1',
      }
    }).then((result) => {
      if (result.isConfirmed) {
        form.delete(`/subjects/${id}`, {
          onSuccess: () => {
            Swal.fire({
              icon: 'success',
              title: 'Dihapus',
              text: 'Mata pelajaran berhasil dihapus',
              width: 300,
              padding: '1rem',
              timer: 1200,
              showConfirmButton: false,
            })
          },
          onError: (errors) => {
            if (errors.subject) {
              Swal.fire({
                icon: 'error',
                title: 'Gagal Menghapus',
                text: errors.subject,
                width: 'auto',
                padding: '1rem',
                showConfirmButton: true,
              })
            }
          }
        })
      }
    })
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
    <MainLayout>
      <div class="p-8">
        <!-- Header -->
        <div class="mb-8">
          <h1 class="text-3xl font-bold text-gray-800"><i class="ph-bold ph-books text-indigo-600"></i> Mata Pelajaran
          </h1>
          <p class="text-gray-500">Kelola catatan berdasarkan pelajaran</p>
        </div>

        <!-- Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

          <!-- ➕ TAMBAH SUBJECT -->
          <div @click="showModal = true" class="bg-white border-2 border-dashed border-indigo-300 rounded-2xl min-h-[100px]
           flex flex-col items-center justify-center text-center
           cursor-pointer hover:shadow-md hover:-translate-y-1
           transition-all group">
            <i class="ph ph-plus-circle text-4xl text-indigo-500 group-hover:scale-110 transition"></i>
            <p class="font-semibold text-indigo-600">
              Tambah Mata Pelajaran
            </p>
            <p class="text-sm text-zinc-400">
              Klik untuk menambahkan pelajaran baru
            </p>
          </div>

          <!-- SUBJECTS -->
          <!-- 📘 SUBJECT CARD -->
          <div v-for="subject in subjects" :key="subject.id" @click="openEdit(subject)"
            :class="[getColor(subject.id), 'rounded-2xl p-6 shadow-md hover:shadow-xl hover:-translate-y-1 transition cursor-pointer group min-h-[100px]']">
            <div class="flex justify-between items-start">
              <h3 class="font-semibold text-lg text-gray-800 group-hover:text-indigo-700 transition">
                {{ subject.name }}
              </h3>

              <!-- Delete -->
              <button @click.stop="destroy(subject.id)" title="Hapus" class="text-red-500 hover:text-red-700">
                <i class="ph-bold ph-trash"></i>
              </button>
            </div>

            <p class="mt-3 text-sm text-gray-700">
              {{ subject.notes_count ?? 0 }} catatan
            </p>
          </div>
        </div>

        <!-- Modal -->
        <TransitionRoot :show="showModal" as="template">
          <Dialog class="relative z-50" @close="resetForm">
            <div class="fixed inset-0 bg-black/40" />
            <div class="fixed inset-0 flex items-center justify-center p-4">
              <DialogPanel class="bg-white rounded-2xl p-6 w-full max-w-md shadow-xl">
                <h2 class="text-xl font-semibold mb-4 text-gray-800">
                  {{ isEdit ? 'Edit Mata Pelajaran' : 'Tambah Mata Pelajaran' }}
                </h2>

                <input v-model="form.name" type="text" placeholder="Nama Pelajaran"
                  class="w-full border border-gray-300 rounded-lg p-3 mb-4 focus:ring-indigo-300" />

                <div class="flex justify-end gap-2">
                  <button @click="resetForm" class="px-4 py-2 rounded-lg border">Batal</button>
                  <button v-if="isEdit" @click="update"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg">
                    Update
                  </button>
                  <button v-else @click="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg">
                    Simpan
                  </button>
                </div>
              </DialogPanel>
            </div>
          </Dialog>
        </TransitionRoot>
      </div>
    </MainLayout>
  </template>
