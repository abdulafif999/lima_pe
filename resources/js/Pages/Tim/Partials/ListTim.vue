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
                                        Tim yang Dinilai
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
                                            <jet-confirm-button href="#" @click.prevent="showPenilaian(tim)" class="text-indigo-600 hover:text-indigo-900">Show List</jet-confirm-button>
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
                <jet-button class="mr-4" @click="deleteRow"> - </jet-button>                
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
                                        v-model="form1.selected[index]" 
                                        >
                                        
                                        <option value="" disabled selected>Select Karyawan</option>
                                        <option v-for="karyawan in karyawans" :key="karyawan.nip" :value="karyawan.nip" selected>{{karyawan.nip}} - {{karyawan.nama}}</option>
                                    </select>

                                    <jet-input-error :message="form.errors.nip" class="mt-2" />
                                </div>
                            </td>
                            <td>
                                <div class="mt-4">
                                    <jet-input type="text" class="mt-1 block w-3/4" placeholder="Posisi"
                                                ref="posisi"
                                                v-model="form1.posisi[index]"
                                                @keyup.enter="create" disabled
                                                />

                                    <jet-input-error :message="form.errors.posisi" class="mt-2" />                                
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
                                <tr v-for="tim in form1.member" :key="tim.tim_id">
                                    <td v-if="tim.id == null"> Tidak Ada Anggota Terdaftar</td>
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
                    Close
                </jet-secondary-button>
            </template>
        </jet-dialog-modal>

        <!-- Delete Member Modal !-->
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

                <jet-button class="ml-2" @click="deleteProses" :class="{ 'opacity-25': form1.processing }" :disabled="form1.processing">
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
                    v-model="form2.selected" 
                    >
                        <option value="" disabled selected>Select Karyawan</option>
                        <option v-for="karyawan in karyawans" :key="karyawan.nip" :value="karyawan.nip">{{karyawan.nip}} - {{karyawan.nama}}</option>
                    </select>

                    <jet-input-error :message="form2.errors.nip" class="mt-2" />
                </div>

                <div class="mt-4">
                    <select  class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-3/4"
                    v-model="form2.posisi" 
                    >
                        <option value="" disabled selected>Select Posisi</option>
                        <option value="Ketua">Ketua</option>
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

        <!--Change Team Name Modal-->
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

        <jet-confirmation-modal :show="deletingTim" @close="closeModal">
            <template #title>
                Delete Tim
            </template>
            <template #content>
                Are you sure you want to delete this team? Once a team is deleted, all of its resources and data will be permanently deleted.
            </template>

            <template #footer>
                <jet-secondary-button @click="deletingTim = false">
                    Cancel
                </jet-secondary-button>

                <jet-button class="ml-2" @click="deleteTim" :class="{ 'opacity-25': form1.processing }" :disabled="form1.processing">
                    Delete Tim
                </jet-button>
            </template>
        </jet-confirmation-modal> 

        <jet-dialog-modal :show="penilaianTimModal" @close="closeModal">
            <template #title>
                Tim Penilai : {{this.selectedTim.nama}}
            </template>

            <template #content>
                <h2 class="flex justify-between font-semibold text-xl text-gray-800 leading-tight">
                    <jet-button @click="tambahTim(this.selectedTim)" class="text-indigo-600 hover:text-indigo-900">Tambah Tim</jet-button>
                </h2>
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama Tim yang Dinilai
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama Unit
                                    </th>                                           
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Ubah</span>
                                        <span class="sr-only">Delete</span>
                                    </th>                                                                                       
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="tim in form1.listTim" :key="tim.id">
                                    <td v-if="tim == null"> Tidak Ada Anggota Terdaftar</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ tim.tim_unit.nama }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ tim.tim_unit.unit }}
                                        </div>
                                    </td>
                                    <td>
                                        <jet-secondary-button @click="updatePenilaian(tim)" class="text-indigo-600 hover:text-indigo-900">Ubah</jet-secondary-button>
                                        <jet-button @click="deletePenilaian(tim)" class="text-indigo-600 hover:text-indigo-900">Hapus</jet-button>
                                    </td>
                                </tr>

                                <!-- More people... -->
                            </tbody>
                        </table>

                </div>
            </template>

            <template #footer>
                <jet-secondary-button @click="closeModal">
                    Close
                </jet-secondary-button>
            </template>
        </jet-dialog-modal>

        <jet-dialog-modal :show="addTimModal" @close="addTimModal = false">
            <template #title>
                Tambahkan Tim yang Dinilai
            </template>

            <template #content>
                <jet-secondary-button @click="addRow"> + </jet-secondary-button>
                 <jet-button class="mr-4" @click="deleteRow"> - </jet-button>                
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th>Nama Tim</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(n, index) in banyakTim" :key="index">
                            <td>
                                <div class="mt-4">
                                    <select  class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-3/4"
                                        v-model="form3.tim_unit_id[index]"
                                        >
                                        
                                        <option value="" disabled selected>Select Tim</option>
                                        <option v-for="tim in timUnits" :key="tim.id" :value="tim.id">{{tim.nama}} - {{tim.unit}}</option>
                                    </select>

                                    <jet-input-error :message="form3.errors.tim_unit_id" class="mt-2" />
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </template>

            <template #footer>
                <jet-secondary-button @click="addTimModal = false">
                    Cancel
                </jet-secondary-button>

                <jet-button class="ml-2" @click="createTim(this.selectedTim)" :class="{ 'opacity-25': form3.processing }" :disabled="form3.processing">
                    Create
                </jet-button>
            </template>
        </jet-dialog-modal>

        <jet-dialog-modal :show="updatePenilaianModal" @close="updatePenilaianModal = false">
            <template #title>
                Ubah Tim yg Dinilai
            </template>
            <template #content>
                <select  class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-3/4"
                    v-bind:id="'tim_unit_id' + n"
                    v-model="form4.tim_unit_id">
                                        
                    <option value="" disabled selected>Select Tim</option>
                    <option v-for="tim in timUnits" :key="tim.id" :value="tim.id">{{tim.nama}} - {{tim.unit}}</option>
                </select>
            </template>

            <template #footer>
                <jet-secondary-button @click="updatePenilaianModal = false">
                    Cancel
                </jet-secondary-button>

                <jet-button class="ml-2" @click="updatePenilaianTim" :class="{ 'opacity-25': form4.processing }" :disabled="form4.processing">
                    Ubah
                </jet-button>
            </template>
        </jet-dialog-modal>

        <jet-confirmation-modal :show="deletePenilaianModal" @close="deletePenilaianModal = false">
            <template #title>
                Delete Tim
            </template>
            <template #content>
                Are you sure you want to delete this team? Once a team is deleted, all of its resources and data will be permanently deleted.
            </template>

            <template #footer>
                <jet-secondary-button @click="deletePenilaianModal = false">
                    Cancel
                </jet-secondary-button>

                <jet-button class="ml-2" @click="deleteTimPenilai" :class="{ 'opacity-25': form4.processing }" :disabled="form4.processing">
                    Delete Tim
                </jet-button>
            </template>
        </jet-confirmation-modal> 
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
        tims: Array,
        dataTims:Array,
        karyawans:Array,
        penilaianTims:Array,
        timUnits:Array
    },

    data() {
        return {
            updatingTim:false,
            updatingMember:false,
            deletingMember:false,
            timModal: false,
            deletingTim: false,
            addMemberModal: false,
            penilaianTimModal: false,
            updatePenilaianModal: false,
            deletePenilaianModal:false,
            addTimModal: false,
            selectedTim: {},
            selectedTim1: {},
            showTim:[],
            banyakAnggota:3,
            banyakTim:1,

            form: this.$inertia.form({
                nama: '',
            }),
            form1: this.$inertia.form({
                tim_id:'',
                selected:[],
                posisi:[],
                member:[],
                listTim:[],
            }),
            form2: this.$inertia.form({
                tim_id:'',
                selected:'',
                posisi:'',
            }),

            form3: this.$inertia.form({
                tim_id:'',
                tim_unit_id: [],
            }),            

            form4: this.$inertia.form({
                tim_id:'',
                tim_unit_id:'',
            }),
        }
    },

    methods: {

        showMember(dataTim) {
            this.timModal = true;
            var j=0;
            this.selectedTim = dataTim;
            for(var index=0;index<=this.dataTims.length-1;index++){
                if(dataTim.id == this.dataTims[index].tim_id){
                    this.form1.member[j] = this.dataTims[index];
                    j++;
                }
            }
        },

        addMember(dataTim){
            this.addMemberModal = true;
            this.selectedTim1 = dataTim;
            this.form1.tim_id = dataTim.id;
            for(var index=0;index<=this.banyakAnggota;index++){
                this.form1.posisi[index] = 'Anggota';
            }
        },
        updateMember(tim){
            this.updatingMember = true;
            this.selectedTim = tim;
            this.form2.tim_id = tim.tim_id;
            this.form2.selected = tim.nip;
            this.form2.posisi = tim.posisi;          
        },

        updateProses() {
            this.form2.put(route('timDetail.update', this.selectedTim.id), {
                preserveScroll: true,
                onSuccess: () => {
                    this.updatingMember = false;
                    this.form1.reset();
                    this.form2.reset();
                    this.showMember(this.selectedTim);
                },
            })
        },
        updateTim(tim){
            this.updatingTim = true;
            this.selectedTim = tim;
            this.form.nama = tim.nama;
        },

        update() {
            this.form.put(route('tim.update', this.selectedTim.id), {
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
            var dataTim = this.dataTims;
            var daftarTim = this.tims;
            this.showTim = this.tims;
            for(var index=0;index<=daftarTim.length-1;index++){
                for(var k=0;k<=dataTim.length-1;k++){
                    if(dataTim[k].posisi == 'Ketua' && dataTim[k].tim_id == daftarTim[index].id){
                        this.showTim[index].id = daftarTim[index].id;
                        this.showTim[index].nip = dataTim[k].nip;
                        this.showTim[index].nama_karyawan = dataTim[k].karyawan.nama;
                        this.showTim[index].posisi = dataTim[k].posisi;
                        
                    }
                }
            }
        },

        deleteTim() {
            this.form1.delete(route('timDetail.destroyAll', this.selectedTim.tim.id), {
                preserveScroll: true,
                errorBag: 'delete',
                onSuccess: () => this.closeModal()
            });
        },
        create(){
            this.form1.post(route('timDetail.store'), {
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
            this.form1.delete(route('timDetail.destroy', this.selectedTim.id), {
                preserveScroll: true,
                preserveState:true,
                errorBag: 'delete',
                onSuccess: () => {
                    this.deletingMember = false;
                    this.form1.reset();
                    this.showMember(this.selectedTim);
                },
            });
        },  

        showPenilaian(tim){
            this.penilaianTimModal = true;
            this.selectedTim = tim;
            var j=0;
            for(var index = 0;index<=this.penilaianTims.length-1;index++){
                if(tim.id == this.penilaianTims[index].tim_id){
                    this.form1.listTim[j] = this.penilaianTims[index];
                    j++;
                }
            }

        },

        tambahTim(tim){
            this.addTimModal = true;
            this.form3.tim_id = tim.id;
        },

        createTim(){
            this.form3.post(route('penilaianTim.store'), {
                preserveScroll: true,
                preserveState: true,
                onSuccess: () => {
                    this.addTimModal = false;
                    this.form1.reset();
                    this.showPenilaian(this.selectedTim)
                },
            })              
        },

        updatePenilaian(tim){
            this.updatePenilaianModal = true;
            this.selectedTim = tim;
            this.form4.tim_id = tim.tim_id;
            this.form4.tim_unit_id = tim.tim_unit_id;
        },

        updatePenilaianTim(){
            this.form4.put(route('penilaianTim.update', this.selectedTim.id), {
                preserveScroll: true,
                onSuccess: () => {
                    this.updatePenilaianModal = false;
                    this.form1.reset();
                    this.showPenilaian(this.selectedTim);               
                },
            })            
        },

        deletePenilaian(tim){
            this.selectedTim = tim;
            this.deletePenilaianModal = true;
        },

        deleteTimPenilai(){
            this.form4.delete(route('penilaianTim.destroy', this.selectedTim.id), {
                preserveScroll: true,
                preserveState:true,
                errorBag: 'delete',
                onSuccess: () => {
                    this.deletePenilaianModal = false;
                    this.form1.reset();
                    this.showPenilaian(this.selectedTim);
                },
            });                
        },

        closeModal() {
            this.updatingTim = false,
            this.deletingTim = false,
            this.timModal = false,
            this.addMemberModal = false,
            this.penilaianTimModal = false,
            

            this.form.reset(),
            this.form1.reset(),
            this.form2.reset(),
            this.form3.reset()
        },
        addRow(tim){
            this.banyakAnggota++;
            this.addMember(tim);
            this.banyakTim++;
        },
        deleteRow(){
            this.banyakAnggota--;
            this.banyakTim--;
        }
    },
}
</script>
