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
                                        Kriteria
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Sub Kriteria
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
                                <tr v-for="kriteria in kriterias" :key="kriteria.nama">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ kriteria.nama }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ kriteria.sub_kriteria }}
                                        </div>
                                    </td>         
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ kriteria.keterangan}}
                                        </div>
                                    </td>                                                                 
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <jet-secondary-button href="#" @click.prevent="updateKriteria(kriteria)" class="text-indigo-600 hover:text-indigo-900">Edit  </jet-secondary-button>
                                         
                                        <jet-button href="#" @click.prevent="ConfirmingKriteriaDeletion(kriteria)" class="text-indigo-600 hover:text-indigo-900">Hapus</jet-button>
                                    </td>                                    
                                </tr>

                                <!-- More people... -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Update Kriteria Modal -->
        <jet-dialog-modal :show="updatingKriteria" @close="closeModal">
            <template #title>
                Update Kriteria
            </template>

            <template #content>
                <div class="mt-4">
                    <select  class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-3/4"
                        v-model="form.nama">
                                        
                        <option value="" disabled selected>Select Kriteria</option>
                        <option value="P1">P1</option>
                        <option value="P2">P2</option>
                        <option value="P3">P3</option>
                        <option value="P4">P4</option>
                        <option value="P5">P5</option>
                    </select>

                    <jet-input-error :message="form.errors.nama" class="mt-2" />
                </div>
                <div class="mt-4">
                    <jet-input type="text" class="mt-1 block w-3/4" placeholder="Sub Kriteria"
                                ref="sub_kriteria"
                                v-model="form.sub_kriteria"
                                @keyup.enter="update" />

                    <jet-input-error :message="form.errors.sub_kriteria" class="mt-2" />
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

        <jet-dialog-modal :show="deletingKriteria" @close="deletingKriteria = false">
            <template #title>
                Delete Kriteria
            </template>
            <template #content>
                Yakin ingin menghapus??
            </template>

            <template #footer>
                <jet-secondary-button @click="deletingKriteria = false">
                    Cancel
                </jet-secondary-button>

                <jet-button class="ml-2" @click="deleteKriteria" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Delete Kriteria
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
        kriterias: Array
    },

    data() {
        return {
            updatingKriteria: false,
            deletingKriteria: false,
            selectedKriteria: {},

            form: this.$inertia.form({
                nama: '',
                sub_kriteria: '',    
                keterangan:''
            })
        }
    },

    methods: {
        updateKriteria(kriteria) {
            this.updatingKriteria = true;
            this.selectedKriteria = kriteria;
            this.form.nama = kriteria.nama;
            this.form.sub_kriteria = kriteria.sub_kriteria;
            this.form.keterangan = kriteria.keterangan;

        },

        update() {
            this.form.put(route('kriteria.update', this.selectedKriteria.id), {
                preserveScroll: true,
                onSuccess: () => this.closeModal(),
                onError: () => this.$refs.nama.focus(),
                onFinish: () => this.form.reset(),
            })
        },
        ConfirmingKriteriaDeletion(kriteria) {
            this.deletingKriteria = true;
            this.selectedKriteria = kriteria;

        },

        deleteKriteria() {
            this.form.delete(route('kriteria.destroy', this.selectedKriteria.id), {
                preserveScroll: true,
                errorBag: 'delete',
                onSuccess: () => this.closeModal()
            });
        },        

        closeModal() {
            this.updatingKriteria = false,
            this.deletingKriteria = false,

            this.form.reset()
        },
    },
}
</script>
