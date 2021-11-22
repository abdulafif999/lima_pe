<template>
    <app-layout>
        <template #header>
            <h2 class="flex justify-between font-semibold text-xl text-gray-800 leading-tight">
                Tim 5P
                <create-tim />
            </h2>
        </template>    
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">                
                                <div>
                                    Tambahkan Anggota Tim
                                </div>

                                <div>
                                    <div class="form-group" :v-on:show ="getTimUnitId()">
                                        <label>Tim : {{this.timUnits.nama}}</label>
                                    </div>
                                    <jet-secondary-button @click="addRow">Tambah Anggota</jet-secondary-button>
                                    <jet-button class="mr-4" @click="deleteRow">Kurang Anggota</jet-button>                
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead>
                                            <tr>
                                                <th>Nama Anggota</th>
                                                <th>Posisi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(n, index) in banyakAnggota" :key="index">
                                                <td>
                                                    <div class="mt-4">
                                                        <select  class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-3/4"
                                                            v-model="form.pernum[index]" 
                                                            >
                                                            
                                                            <option value="" disabled selected>Select Karyawan</option>
                                                            <option v-for="karyawan in karyawans" :key="karyawan.pernum" :value="karyawan.pernum" selected>{{karyawan.pernum}} - {{karyawan.nama}}</option>
                                                        </select>

                                                        <jet-input-error :message="form.errors.pernum" class="mt-2" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="mt-4">
                                                        <select  class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-3/4"
                                                            v-model="form.posisi[index]" 
                                                            >
                                                            
                                                            <option value="" disabled selected>Pilih Posisi</option>
                                                            <option value="Ketua">Ketua</option>
                                                            <option value="Sekretaris">Sekretaris</option>
                                                            <option value="Anggota">Anggota</option>
                                                        </select>

                                                        <jet-input-error :message="form.errors.posisi" class="mt-2" />                                
                                                    </div>                            
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div>
                                    <jet-secondary-button @click="closeModal">
                                        Cancel
                                    </jet-secondary-button>

                                    <jet-button class="ml-2" @click="create" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                        Create
                                    </jet-button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>
<script>
import JetButton from '@/Jetstream/Button.vue'
import JetDialogModal from '@/Jetstream/DialogModal.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
import { Inertia } from '@inertiajs/inertia'
import AppLayout from '@/Layouts/AppLayout.vue'

export default {
    components: {
        AppLayout,
        JetButton,
        JetDialogModal,
        JetInput,
        JetInputError,
        JetSecondaryButton,
    },

    props: {
        timUnits: Array,
        karyawans:Array
    },

    data() {
        return {
            creatingTimDetail: false,
            banyakAnggota:3,
            namaTim:'',
            

            form: this.$inertia.form({
                tim_unit_id: '',
                pernum: [],
                posisi: [],
            })
        }
    },

    methods: {

        createTimDetail() {
            this.fetchKaryawans();
            this.fetchTimUnits();
            this.creatingTimDetail = true;
        },

        fetchTimUnits() {
            Inertia.reload({ only: ['timUnits'] })
        },

        fetchKaryawans() {
            Inertia.reload({ only: ['karyawans'] })
        },

        create() {
            this.form.post(route('unitDetail.store'), {
                preserveScroll: true,
                preserveState: true,
                onSuccess: () => {
                    this.closeModal();
                    this.form.reset();
                },
            })
        },
        getTimUnitId(){
            this.form.tim_unit_id = this.timUnits.tim_unit_id
        },

        closeModal() {
            this.form.clearErrors();
            this.form.reset();
            this.route('timUnit.index');
        },
        addRow(){
            this.banyakAnggota++
        }, 
        deleteRow(){
            this.banyakAnggota--
        }
    },
}
</script>
