<template>
    <app-layout>
        <template #header>
            <h2 class="flex justify-between font-semibold text-xl text-gray-800 leading-tight">
                Tim Detail
                <create-tim />
            </h2>
        </template>    
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg" v-if="tims.nama != null" >                
        <!-- Delete Account Confirmation Modal -->
                                <div>
                                    Tambahkan Anggota Tim
                                </div>

                                <div class="form-group" >
                                    <div :v-on:show ="getTimId()">
                                        <label>Tim : {{this.tims.nama}}</label>
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
                                                            v-model="form.selected[index]" 
                                                            v-bind:id = "'karyawan' + n">
                                                            
                                                            <option value="" disabled selected>Select Karyawan</option>
                                                            <option v-for="karyawan in karyawans" :key="karyawan.nip" :value="karyawan.nip" selected>{{karyawan.nip}} - {{karyawan.nama}}</option>
                                                        </select>

                                                        <jet-input-error :message="form.errors.nip" class="mt-2" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="mt-4">
                                                        <select  class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-3/4"
                                                            v-model="form.posisi[index]" 
                                                            v-bind:id = "'posisi' + n">
                                                            
                                                            <option value="" disabled selected>Select Karyawan</option>
                                                            <option value="Ketua">Ketua</option>
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
        tims: Array,
        karyawans:Array
    },

    data() {
        return {
            creatingTimDetail: false,
            banyakAnggota:3,
            
            form: this.$inertia.form({
                tim_id: '',
                selected: [],
                posisi: [],
            })
        }
    },

    methods: {

        createTimDetail() {
            this.fetchKaryawans();
            this.fetchTims();
            this.creatingTimDetail = true;
        },

        fetchTims() {
            Inertia.reload({ only: ['tims'] })
        },

        fetchKaryawans() {
            Inertia.reload({ only: ['karyawans'] })
        },

        create() {
            this.form.post(route('timDetail.store'), {
                preserveScroll: true,
                preserveState: true,
                onSuccess: () => {
                    this.closeModal();
                    this.form.reset();
                },
            })
        },
        getTimId(){
            this.form.tim_id = this.tims.tim_id
        },

        closeModal() {
            this.form.clearErrors()
            this.form.reset()
            return route('tim.index');
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
