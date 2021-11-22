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
                                        Nama Unit
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama Area Unit
                                    </th>                                                                                                        
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Edit</span>
                                        <span class="sr-only">Delete</span>
                                    </th>                                    
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="unitDetail in unitDetails" :key="unitDetail.id">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ unitDetail.karyawan.unit }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ unitDetail.area.nama }}
                                        </div>
                                    </td>   
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <jet-secondary-button href="#" @click.prevent="updateUnitDetail(unitDetail)" class="text-indigo-600 hover:text-indigo-900">Edit  </jet-secondary-button>
                                         
                                        <jet-button href="#" @click.prevent="ConfirmingUnitDetailDeletion(unitDetail)" class="text-indigo-600 hover:text-indigo-900">Hapus</jet-button>
                                    </td>                                                                
                                </tr>

                                <!-- More people... -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Update UnitDetail Modal -->
        <jet-dialog-modal :show="updatingUnitDetail" @close="closeModal">
            <template #title>
                Update UnitDetail
            </template>

            <template #content>
                <div class="mt-4">
                    <select class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-3/4"
                        v-model="form.nama_unit" >
                        <option value="" disabled selected>Select Unit Pegawai</option>
                        <option v-for="karyawan in karyawans" :key="karyawan.unit" :value="karyawan.unit">{{karyawan.unit}}</option>
                    </select>

                    <jet-input-error :message="form.errors.nama_unit" class="mt-2" />
                </div>

                <div class="mt-4">
                    <select class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-3/4"
                        v-model="form.area_id" >
                        <option value="" disabled selected>Pilih Area Unit</option>
                        <option v-for="area in areas" :key="area.id" :value="area.id">{{area.nama}}</option>
                    </select>

                    <jet-input-error :message="form.errors.area" class="mt-2" />
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

        <jet-dialog-modal :show="deletingUnitDetail" @close="deletingUnitDetail = false">
            <template #title>
                Delete UnitDetail
            </template>
            <template #content>
                Are you sure you want to delete this team? Once a team is deleted, all of its resources and data will be permanently deleted.
            </template>

            <template #footer>
                <jet-secondary-button @click="deletingUnitDetail = false">
                    Cancel
                </jet-secondary-button>

                <jet-button class="ml-2" @click="deleteUnitDetail" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Delete UnitDetail
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
        unitDetails: Array,
        karyawans: Array,
        areas:Array
    },

    data() {
        return {
            updatingUnitDetail: false,
            deletingUnitDetail: false,
            selectedUnitDetail: {},

            form: this.$inertia.form({
                nama_unit: '',
                area_id: '',
            })
        }
    },

    methods: {
        updateUnitDetail(UnitDetail) {
            this.fetchKaryawans();
            this.fetchAreas();
            this.updatingUnitDetail = true;
            this.selectedUnitDetail = UnitDetail;
            this.form.nama_unit = UnitDetail.nama_unit;
            this.form.area_id = UnitDetail.area_id;

            setTimeout(() => this.$refs.posisi.focus(), 250)
        },

        fetchKaryawans() {
            Inertia.reload({ only: ['karyawans'] })
        },        
        fetchAreas() {
            Inertia.reload({ only: ['areas'] })
        },          

        update() {
            this.form.put(route('unitDetail.update', this.selectedUnitDetail.id), {
                preserveScroll: true,
                preserveState:true,
                onSuccess: () => {
                    this.closeModal();
                    this.form.reset();
                },
                onError: () => this.$refs.posisi.focus(),
            })
        },
        ConfirmingUnitDetailDeletion(UnitDetail) {
            this.deletingUnitDetail = true;
            this.selectedUnitDetail = UnitDetail;

        },

        deleteUnitDetail() {
            this.form.delete(route('unitDetail.destroy', this.selectedUnitDetail.id), {
                preserveScroll: true,
                errorBag: 'delete',
                onSuccess: () => this.closeModal()
            });
        },        

        closeModal() {
            this.updatingUnitDetail = false,
            this.deletingUnitDetail = false,

            this.form.reset()
        },
    },
}
</script>
