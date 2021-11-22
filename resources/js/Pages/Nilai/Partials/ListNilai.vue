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
                                        Nilai
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
                                <tr v-for="nilai in nilais" :key="nilai.id">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ nilai.kriteria.nama }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ nilai.kriteria.sub_kriteria }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ nilai.nilai_bawah }} - {{nilai.nilai_atas}}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ nilai.keterangan }}
                                        </div>
                                    </td>      
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <jet-secondary-button href="#" @click.prevent="updateNilai(nilai)" class="text-indigo-600 hover:text-indigo-900">Edit  </jet-secondary-button>
                                         
                                        <jet-button href="#" @click.prevent="ConfirmingNilaiDeletion(nilai)" class="text-indigo-600 hover:text-indigo-900">Hapus</jet-button>
                                    </td>                                                                
                                </tr>

                                <!-- More people... -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Update Nilai Modal -->
        <jet-dialog-modal :show="updatingNilai" @close="closeModal">
            <template #title>
                Update Nilai
            </template>

            <template #content>


                <div class="mt-4">
                    <select class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-3/4"
                        v-model="form.kriteria_id" >
                        <option value="" disabled selected>Select Category</option>
                        <option v-for="kriteria in kriterias" :key="kriteria.id" :value="kriteria.id">{{kriteria.nama}} {{'-'}} {{ kriteria.sub_kriteria }}</option>
                    </select>

                    <jet-input-error :message="form.errors.kriteria_id" class="mt-2" />
                </div>

                <div class="mt-4">
                    <jet-input type="number" class="mt-1 block w-3/4" placeholder="Nilai Bawah"
                                ref="nilai_bawah"
                                v-model="form.nilai_bawah"
                                @keyup.enter="update" />

                    <jet-input-error :message="form.errors.nilai_bawah" class="mt-2" />
                </div>

                <div class="mt-4">
                    <jet-input type="number" class="mt-1 block w-3/4" placeholder="Nilai Atas"
                                ref="nilai_atas"
                                v-model="form.nilai_atas"
                                @keyup.enter="update" />

                    <jet-input-error :message="form.errors.nilai_atas" class="mt-2" />
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

        <jet-dialog-modal :show="deletingNilai" @close="deletingNilai = false">
            <template #title>
                Delete Nilai
            </template>
            <template #content>
                Are you sure you want to delete this team? Once a team is deleted, all of its resources and data will be permanently deleted.
            </template>

            <template #footer>
                <jet-secondary-button @click="deletingNilai = false">
                    Cancel
                </jet-secondary-button>

                <jet-button class="ml-2" @click="deleteNilai" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Delete Nilai
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
import { Inertia } from '@inertiajs/inertia'

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
        nilais: Array,
        kriterias:Array
    },

    data() {
        return {
            updatingNilai: false,
            deletingNilai: false,
            selectedNilai: {},

            form: this.$inertia.form({
                kriteria_id: '',
                nilai_bawah: '',
                nilai_atas: '',
                keterangan: '',
            })
        }
    },

    methods: {
        updateNilai(nilai) {
            this.fetchKriterias();
            this.updatingNilai = true;
            this.selectedNilai = nilai;
            this.form.kriteria_id = nilai.kriteria_id;
            this.form.nilai_bawah = nilai.nilai_bawah;
            this.form.nilai_atas = nilai.nilai_atas;
            this.form.keterangan = nilai.keterangan;

            setTimeout(() => this.$refs.nilai.focus(), 250)
        },

        fetchKriterias() {
            Inertia.reload({ only: ['kriterias'] })
        },        

        update() {
            this.form.put(route('nilai.update', this.selectedNilai.id), {
                preserveScroll: true,
                preserveState:true,
                onSuccess: () => {
                    this.closeModal();
                    this.form.reset();
                },
                onError: () => this.$refs.nama.focus(),
            })
        },
        ConfirmingNilaiDeletion(nilai) {
            this.deletingNilai = true;
            this.selectedNilai = nilai;

        },

        deleteNilai() {
            this.form.delete(route('nilai.destroy', this.selectedNilai.id), {
                preserveScroll: true,
                errorBag: 'delete',
                onSuccess: () => this.closeModal()
            });
        },        

        closeModal() {
            this.updatingNilai = false,
            this.deletingNilai = false,

            this.form.reset()
        },
    },
}
</script>
