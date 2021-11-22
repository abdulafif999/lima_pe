<template>
    <div>
        <!-- This example requires Tailwind CSS v2.0+ -->
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Kategori
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Keterangan
                                    </th>                                                                                                     
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Edit</span>
                                        <span class="sr-only">Delete</span>
                                    </th>                                    
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="area in areas" :key="area.id">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ area.nama }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ area.kategori }}
                                        </div>
                                    </td>  
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ area.keterangan }}
                                        </div>
                                    </td>                                                                        
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <jet-secondary-button href="#" @click.prevent="updateArea(area)" class="text-indigo-600 hover:text-indigo-900">Edit  </jet-secondary-button>
                                         
                                        <jet-button href="#" @click.prevent="ConfirmingAreaDeletion(area)" class="text-indigo-600 hover:text-indigo-900">Hapus</jet-button>
                                    </td>                                    
                                </tr>

                                <!-- More people... -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Update Area Modal -->
        <jet-dialog-modal :show="updatingArea" @close="closeModal">
            <template #title>
                Update Area
            </template>

            <template #content>
                <div class="mt-4">
                    <jet-input type="text" class="mt-1 block w-3/4" placeholder="Nama Area"
                                ref="nama"
                                v-model="form.nama"
                                @keyup.enter="update" />

                    <jet-input-error :message="form.errors.nama" class="mt-2" />
                </div>
                <div class="mt-4">
                    <jet-input type="text" class="mt-1 block w-3/4" placeholder="Kategori"
                                ref="kategori"
                                v-model="form.kategori"
                                @keyup.enter="update" />

                    <jet-input-error :message="form.errors.kategori" class="mt-2" />
                </div>     
                <div class="mt-4">
                    <jet-input type="text" class="mt-1 block w-3/4" placeholder="Keterangan"
                                ref="keterangan"
                                v-model="form.keterangan"
                                @keyup.enter="update" />

                    <jet-input-error :message="form.errors.keterangan" class="mt-2" />
                </div>                            
            </template>

            <template #footer>
                <jet-secondary-button @click="closeModal">
                    Cancel
                </jet-secondary-button>

                <jet-button class="ml-2" @click="update" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Update
                </jet-button>
            </template>
        </jet-dialog-modal>    

        <!-- Delete Modal !-->

        <jet-dialog-modal :show="deletingArea" @close="deletingArea = false">
            <template #title>
                Delete Area
            </template>
            <template #content>
                Yakin ingin menghapus??
            </template>

            <template #footer>
                <jet-secondary-button @click="deletingArea = false">
                    Cancel
                </jet-secondary-button>

                <jet-button class="ml-2" @click="deleteArea" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Delete Area
                </jet-button>
            </template>
        </jet-dialog-modal>            
    </div>
</template>
<script>
import JetButton from '@/Jetstream/Button.vue'
import JetDialogModal from '@/Jetstream/DialogModal.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
import JetCheckbox from '@/Jetstream/Checkbox.vue'

export default {
    components: {
        JetButton,
        JetDialogModal,
        JetInput,
        JetInputError,
        JetSecondaryButton,
        JetCheckbox
    },

    props: {
        areas: Array
    },

    data() {
        return {
            updatingArea: false,
            deletingArea: false,
            selectedArea: {},

            form: this.$inertia.form({
                nama: '',
                kategori: '',
                keterangan: '',
            })
        }
    },

    methods: {
        updateArea(area) {
            this.updatingArea = true;
            this.selectedArea = area;
            this.form.nama = area.nama;
            this.form.kategori = area.kategori;
            this.form.keterangan = area.keterangan;

            setTimeout(() => this.$refs.nama.focus(), 250)
        },

        update() {
            this.form.put(route('area.update', this.selectedArea.id), {
                preserveScroll: true,
                onSuccess: () => this.closeModal(),
                onError: () => this.$refs.nama.focus(),
                onFinish: () => this.form.reset(),
            })
        },
        ConfirmingAreaDeletion(area) {
            this.deletingArea = true;
            this.selectedArea = area;

        },

        deleteArea() {
            this.form.delete(route('area.destroy', this.selectedArea.id), {
                preserveScroll: true,
                errorBag: 'delete',
                onSuccess: () => this.closeModal()
            });
        },        

        closeModal() {
            this.updatingArea = false,
            this.deletingArea = false,

            this.form.reset()
        },
    },
}
</script>
