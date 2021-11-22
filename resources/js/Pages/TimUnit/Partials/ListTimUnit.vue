<template>
    <div>
        <!-- This example requires Tailwind CSS v2.0+ -->
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50" :v-on:show="getTimMember()">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama Tim
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Ketua Tim
                                    </th>    
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Unit
                                    </th>   
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Kategori Unit
                                    </th>                                                                                                         
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Add Member</span>
                                        <span class="sr-only">Show Member</span>
                                        <span class="sr-only">Ubah Nama Tim</span>
                                        <span class="sr-only">Delete Tim</span>
                                    </th>                                    
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="tim in showTim" :key="tim.id">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ tim.nama }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ tim.nama_karyawan }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ tim.unit}}
                                        </div>
                                    </td>                                   
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ tim.kategori}}
                                        </div>
                                    </td>                                                                             
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <jet-confirm-button href="#" @click.prevent="addMember(tim)" class="text-indigo-600 hover:text-indigo-900">Add Member</jet-confirm-button>
                                        <jet-button href="#" @click.prevent="showMember(tim)" class="text-indigo-600 hover:text-indigo-900">Show Member</jet-button>
                                        <jet-secondary-button href="#" @click.prevent="updateTim(tim)" class="text-indigo-600 hover:text-indigo-900">Ubah Nama Tim</jet-secondary-button>
                                        <jet-button href="#" @click.prevent="ConfirmingTimDeletion(tim)" class="text-indigo-600 hover:text-indigo-900">Hapus</jet-button>
                                    </td>                                    
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <jet-dialog-modal :show="addMemberModal" @close="closeModal">
        <!-- Add Member Modal -->
            <template #title>
                Tambahkan Anggota Tim
            </template>

            <template #content>
                <div class="form-group">
                    <label>Tim : {{this.selectedTim1.nama}}</label>
                </div>
                <jet-secondary-button @click="addRow(this.selectedTim1)"> + </jet-secondary-button>
                <jet-button class="mr-4" @click="deleteRow(this.selectedTim1)"> - </jet-button>                
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
                                        v-model="form1.pernum[index]" 
                                        >
                                        
                                        <option value="" disabled selected>Select Karyawan</option>
                                        <option v-for="karyawan in karyawans" :key="karyawan.pernum" :value="karyawan.pernum" selected>{{karyawan.pernum}} - {{karyawan.nama}}</option>
                                    </select>

                                    <jet-input-error :message="form1.errors.pernum" class="mt-2" />
                                </div>
                            </td>
                            <td>
                                <div class="mt-4">
                                    <jet-input type="text" class="mt-1 block w-3/4" placeholder="Posisi"
                                                ref="posisi"
                                                v-model="form1.posisi[index]"
                                                @keyup.enter="create" disabled
                                                />

                                    <jet-input-error :message="form1.errors.posisi" class="mt-2" />                                
                                </div>                            
                            </td>
                        </tr>
                    </tbody>
                </table>
            </template>

            <template #footer>
                <jet-secondary-button @click="closeModal">
                    Cancel
                </jet-secondary-button>

                <jet-button class="ml-2" @click="create" :class="{ 'opacity-25': form1.processing }" :disabled="form1.processing">
                    Create
                </jet-button>
            </template>
        </jet-dialog-modal>

        <!-- Show member Modal -->
        <jet-dialog-modal :show="timModal" @close="closeModal">
            <template #title>
                Tim {{this.selectedTim.nama}}
            </template>

            <template #content>
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama Anggota
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Posisi
                                    </th>         
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Ubah</span>
                                        <span class="sr-only">Delete</span>
                                    </th>                                                                                       
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="tim in form1.member" :key="tim.tim_unit_id">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ tim.karyawan.nama }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ tim.posisi }}
                                        </div>
                                    </td>
                                    <td>
                                        <jet-secondary-button @click="updateMember(tim)" class="text-indigo-600 hover:text-indigo-900">Ubah</jet-secondary-button>
                                        <jet-button @click="deleteMember(tim)" class="text-indigo-600 hover:text-indigo-900">Hapus</jet-button>
                                    </td>
                                </tr>

                                <!-- More people... -->
                            </tbody>
                        </table>

                </div>
            </template>

            <template #footer>
                <jet-secondary-button @click="closeModal">
                    Cancel
                </jet-secondary-button>
            </template>
        </jet-dialog-modal>    

        <!-- Delete Modal !-->

        <jet-confirmation-modal :show="deletingMember" @close="deletingMember = false">
            <template #title>
                Delete Tim
            </template>
            <template #content>
                Are you sure you want to delete this team? Once a team is deleted, all of its resources and data will be permanently deleted.
            </template>

            <template #footer>
                <jet-secondary-button @click="deletingMember = false">
                    Cancel
                </jet-secondary-button>

                <jet-button class="ml-2" @click="deleteProses" :class="{ 'opacity-25': form2.processing }" :disabled="form2.processing">
                    Delete Tim
                </jet-button>
            </template>
        </jet-confirmation-modal>      

        <!--Update Member Modal-->
        <jet-dialog-modal :show="updatingMember" @close="updatingMember = false">
            <template #title>
                Ubah Anggota
            </template>
            <template #content>
                <div class="mt-4">
                    <select  class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-3/4"
                    v-model="form2.pernum" 
                    >
                        <option value="" disabled selected>Select Karyawan</option>
                        <option v-for="karyawan in karyawans" :key="karyawan.pernum" :value="karyawan.pernum">{{karyawan.pernum}} - {{karyawan.nama}}</option>
                    </select>

                    <jet-input-error :message="form2.errors.pernum" class="mt-2" />
                </div>

                <div class="mt-4">
                    <select  class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-3/4"
                    v-model="form2.posisi" 
                    >
                        <option value="" disabled selected>Select Posisi</option>
                        <option value="Ketua">Ketua</option>
                        <option value="Sekretaris">Sekretaris</option>
                        <option value="Anggota">Anggota</option>
                    </select>

                    <jet-input-error :message="form2.errors.posisi" class="mt-2" />                                
                </div>                  
            </template>

            <template #footer>
                <jet-secondary-button @click="updatingMember = false">
                    Cancel
                </jet-secondary-button>

                <jet-button class="ml-2" @click="updateProses" :class="{ 'opacity-25': form2.processing }" :disabled="form2.processing">
                    Ubah
                </jet-button>
            </template>
        </jet-dialog-modal>

        <jet-dialog-modal :show="updatingTim" @close="closeModal">
            <template #title>
                Ubah Nama Tim
            </template>
            <template #content>
                <div class="mt-4">
                    <jet-input type="text" class="mt-1 block w-3/4" placeholder="Nama Tim"
                                ref="nama"
                                v-model="form.nama"
                                @keyup.enter="update" />

                    <jet-input-error :message="form.errors.nama" class="mt-2" />
                </div>

                <div class="mt-4">
                    <jet-input type="text" class="mt-1 block w-3/4" placeholder="Nama Unit"
                                ref="unit"
                                v-model="form.unit"
                                @keyup.enter="update" />

                    <jet-input-error :message="form.errors.unit" class="mt-2" />
                </div>            
                
                    <select class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-3/4"
                        v-model="form.kategori" >
                        <option value="" disabled selected>Pilih Kategori</option>
                        <option value="Operasional">Operasional</option>
                        <option value="Non-Operasional">Non-Operasional</option>
                    </select>

                    <jet-input-error :message="form.errors.kategori" class="mt-2" />                    
            </template>

            <template #footer>
                <jet-secondary-button @click="closeModal">
                    Cancel
                </jet-secondary-button>

                <jet-button class="ml-2" @click="update" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Ubah
                </jet-button>
            </template>
        </jet-dialog-modal>        
    </div>
</template>
<script>
import JetButton from '@/Jetstream/Button.vue'
import JetDialogModal from '@/Jetstream/DialogModal.vue'
import JetConfirmationModal from '@/Jetstream/ConfirmationModal.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
import JetConfirmButton from '@/Jetstream/ConfirmButton.vue'
import JetCheckbox from '@/Jetstream/Checkbox.vue'
import { Inertia } from '@inertiajs/inertia'

export default {
    components: {
        JetButton,
        JetDialogModal,
        JetInput,
        JetInputError,
        JetSecondaryButton,
        JetCheckbox,
        JetConfirmButton,
        JetConfirmationModal,
    },

    props: {
        timUnits: Array,
        unitDetails:Array,
        areas:Array,
        karyawans:Array
    },

    data() {
        return {
            updatingTim:false,
            updatingMember:false,
            timModal: false,
            deletingTim: false,
            addMemberModal: false,
            deletingMember:false,
            selectedTim: {},
            selectedTim1: {},
            showTim:[],
            banyakAnggota:3,

            form: this.$inertia.form({
                nama: '',
                unit:'',
                kategori:'',
            }),
            form1: this.$inertia.form({
                tim_unit_id:'',
                pernum:[],
                posisi:[],
                member:[]
            }),
            form2: this.$inertia.form({
                tim_unit_id:'',
                pernum:'',
                posisi:'',
            }),            

        }
    },

    methods: {
        fetchKaryawan(){
            Inertia.reload({ only: ['karyawans'] })
        },

        showMember(dataTim) {
            this.timModal = true;
            var j=0;
            this.selectedTim = dataTim;
            for(var index=0;index<=this.unitDetails.length-1;index++){
                if(dataTim.id == this.unitDetails[index].tim_unit_id){
                    this.form1.member[j] = this.unitDetails[index];
                    j++;
                }
            }
        },

        addMember(unitDetail){
            this.addMemberModal = true;
            this.selectedTim1 = unitDetail;
            this.form1.tim_unit_id = unitDetail.id;
            for(var index=0;index<=this.banyakAnggota-1;index++){
                this.form1.posisi[index] = 'Anggota';
            }
        },

        updateMember(tim){
            this.fetchKaryawan();
            this.updatingMember = true;
            this.selectedTim = tim;
            this.form2.tim_unit_id = tim.tim_unit_id;
            this.form2.pernum = tim.pernum;
            this.form2.posisi = tim.posisi;          
        },

        updateProses() {
            this.form2.put(route('unitDetail.update', this.selectedTim.id), {
                preserveScroll: true,
                preserveState:true,
                onSuccess: () => {
                    this.updatingMember = false;
                    this.form1.reset();
                    this.showMember(this.selectedTim);                      
                }
            })
        },

        updateTim(tim){
            this.updatingTim = true;
            this.selectedTim = tim;
            this.form.nama = tim.nama;
            this.form.unit = tim.unit;
            this.form.kategori = tim.kategori;
        },

        update() {
            this.form.put(route('timUnit.update', this.selectedTim.id), {
                preserveScroll: true,
                preserveState:true,
                onSuccess: () => {
                    this.closeModal();
                    this.form.reset();
                },
                onError: () => this.$refs.nama.focus(),
            })
        },

        ConfirmingTimDeletion(tim) {
            this.deletingTim = true;
            this.selectedTim = tim;

        },
        getTimMember(){
            var unitDetail = this.unitDetails;
            var daftarTim = this.timUnits;
            this.showTim = this.timUnits;
            for(var index=0;index<=daftarTim.length-1;index++){
                for(var k=0;k<=unitDetail.length-1;k++){
                    if(unitDetail[k].posisi == 'Ketua' && unitDetail[k].tim_unit_id == daftarTim[index].id){
                        this.showTim[index].nama_karyawan = unitDetail[k].karyawan.nama;
                    }
                }
            }
        },

        deleteTim() {
            this.form.delete(route('unitDetail.destroy', this.selectedTim.tim_unit_id), {
                preserveScroll: true,
                errorBag: 'delete',
                onSuccess: () => this.closeModal()
            });
        },
        create(){
            this.form1.post(route('unitDetail.store'), {
                preserveScroll: true,
                preserveState: true,
                onSuccess: () => {
                    this.closeModal();
                    this.form1.reset();
                },
            })            
        },

        deleteMember(dataTim){
            this.selectedTim = dataTim;
            this.deletingMember = true;
        },

        deleteProses() {
            this.form2.delete(route('unitDetail.destroy', this.selectedTim.id), {
                preserveScroll: true,
                preserveState:true,
                errorBag: 'delete',
                onSuccess: () => {
                    this.deletingMember = false;

                },
                onFinish: () =>{
                    this.form1.reset();
                    this.timModal = false;
                    this.showMember(this.selectedTim);                    
                }
            })
        },          


        closeModal() {
            this.updatingTim = false,
            this.deletingTim = false,
            this.timModal = false,
            this.addMemberModal = false,
            

            this.form.reset(),
            this.form1.reset(),
            this.form2.reset()
        },
        addRow(tim){
            this.banyakAnggota++;
            this.addMember(tim);
        },
        deleteRow(){
            this.banyakAnggota--;
        }        
    },
}
</script>
