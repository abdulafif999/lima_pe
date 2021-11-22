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
                                        Nama Tim
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama Anggota
                                    </th>                                    
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Posisi
                                    </th>                                                                     
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Edit</span>
                                        <span class="sr-only">Delete</span>
                                    </th>                                    
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="timDetail in timDetails" :key="timDetail.tim_id">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ timDetail.tim.nama }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ timDetail.karyawan.nama }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ timDetail.posisi }}
                                        </div>
                                    </td>    
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <jet-secondary-button href="#" @click.prevent="updateTimDetail(timDetail)" class="text-indigo-600 hover:text-indigo-900">Edit  </jet-secondary-button>
                                         
                                        <jet-button href="#" @click.prevent="ConfirmingTimDetailDeletion(timDetail)" class="text-indigo-600 hover:text-indigo-900">Hapus</jet-button>
                                    </td>                                                                
                                </tr>

                                <!-- More people... -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Update TimDetail Modal -->
        <jet-dialog-modal :show="updatingTimDetail" @close="closeModal">
            <template #title>
                Update TimDetail
            </template>

            <template #content>
                <div class="mt-4">
                    <select class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-3/4"
                        v-model="form.tim_id" >
                        <option value="" disabled selected>Select Team</option>
                        <option v-for="tim in tims" :key="tim.id" :value="tim.id">{{tim.nama}}</option>
                    </select>

                    <jet-input-error :message="form.errors.tim_id" class="mt-2" />
                </div>

                <div class="mt-4">
                    <select class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-3/4"
                        v-model="form.nip" >
                        <option value="" disabled selected>Pilih Anggota</option>
                        <option v-for="karyawan in karyawans" :key="karyawan.nip" :value="karyawan.nip">{{karyawan.nama}}</option>
                    </select>

                    <jet-input-error :message="form.errors.nip" class="mt-2" />
                </div>

                <div class="mt-4">
                    <jet-input type="text" class="mt-1 block w-3/4" placeholder="Posisi Anggota"
                                ref="posisi"
                                v-model="form.posisi"
                                @keyup.enter="create" />

                    <jet-input-error :message="form.errors.posisi" class="mt-2" />
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

        <jet-dialog-modal :show="deletingTimDetail" @close="deletingTimDetail = false">
            <template #title>
                Delete TimDetail
            </template>
            <template #content>
                Are you sure you want to delete this team? Once a team is deleted, all of its resources and data will be permanently deleted.
            </template>

            <template #footer>
                <jet-secondary-button @click="deletingTimDetail = false">
                    Cancel
                </jet-secondary-button>

                <jet-button class="ml-2" @click="deleteTimDetail" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Delete TimDetail
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
        timDetails: Array,
        tims : Array,
        karyawans:Array
    },

    data() {
        return {
            updatingTimDetail: false,
            deletingTimDetail: false,
            selectedTimDetail: {},

            form: this.$inertia.form({
                tim_id: '',
                nip: '',
                posisi: '',
            })
        }
    },

    methods: {
        updateTimDetail(timDetail) {
            this.fetchKaryawans();
            this.fetchTims();
            this.updatingTimDetail = true;
            this.selectedTimDetail = timDetail;
            this.form.tim_id = timDetail.tim_id;
            this.form.nip = timDetail.nip;
            this.form.posisi = timDetail.posisi;

            setTimeout(() => this.$refs.posisi.focus(), 250)
        },

        fetchKaryawans() {
            Inertia.reload({ only: ['karyawans'] })
        },        
        fetchTims() {
            Inertia.reload({ only: ['tims'] })
        },          

        update() {
            this.form.put(route('timDetail.update', this.selectedTimDetail.tim_id), {
                preserveScroll: true,
                preserveState:true,
                onSuccess: () => {
                    this.closeModal();
                    this.form.reset();
                },
                onError: () => this.$refs.posisi.focus(),
            })
        },
        ConfirmingTimDetailDeletion(timDetail) {
            this.deletingTimDetail = true;
            this.selectedTimDetail = timDetail;

        },

        deleteTimDetail() {
            this.form.delete(route('timDetail.destroy', this.selectedTimDetail.id), {
                preserveScroll: true,
                errorBag: 'delete',
                onSuccess: () => this.closeModal()
            });
        },        

        closeModal() {
            this.updatingTimDetail = false,
            this.deletingTimDetail = false,

            this.form.reset()
        },
    },
}
</script>
