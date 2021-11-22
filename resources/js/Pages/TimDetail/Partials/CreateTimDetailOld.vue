<template>
    <div>
        <jet-button @click="createTimDetail">
            Create New
        </jet-button>

        <!-- Delete Account Confirmation Modal -->
        <jet-dialog-modal :show="creatingTimDetail" @close="closeModal">
            <template #title>
                Create TimDetail
            </template>

            <template #content>
                <div class="form-group">
                    <label>Select Tim : </label>
                    <select
                    class="form-control"
                    @change="getAnggota(temp_section_id)"
                    v-model="temp_section_id"
                    >
                        <option value="" disabled selected>Select Team</option>
                        <option v-for="tim in tims" :key="tim.id" :value="tim.id">{{tim.nama}}</option>
                    </select>
                </div>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th>Nama Anggota</th>
                            <th>Posisi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="banyakAnggota.length === 0">
                        <td colspan="2">No Tim</td>
                        </tr>
                        <tr v-for="(tims, index) in banyakAnggota" :key="tims.id">
                            {{setTimId(index, tims.id)}}
                            <td>{{tims.nama}}</td>
                            <td>
                                <select class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-3/4"
                                    v-model="record[index].nip" >
                                    <option value="" disabled selected>Pilih Anggota</option>
                                    <option v-for="karyawan in karyawans" :key="karyawan.nip" :value="karyawan.nip">{{karyawan.nama}}</option>
                                </select>

                                <jet-input-error :message="record.errors.nip" class="mt-2" />                                
                            </td>
                            <td>
                                <jet-input type="text" class="mt-1 block w-3/4" placeholder="Posisi Anggota"
                                            ref="posisi"
                                            v-model="record[index].posisi"
                                            @keyup.enter="create" />

                                <jet-input-error :message="record.errors.posisi" class="mt-2" />          
                            </td>
                        </tr>
                    </tbody>
                </table>
            </template>

            <template #footer>
                <jet-secondary-button @click="closeModal">
                    Cancel
                </jet-secondary-button>

                <jet-button class="ml-2" @click="create" :class="{ 'opacity-25': record.processing }" :disabled="record.processing">
                    Create
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
import { Inertia } from '@inertiajs/inertia'

export default {
    components: {
        JetButton,
        JetDialogModal,
        JetInput,
        JetInputError,
        JetSecondaryButton,
    },

    props: {
        tims: Array,
        karyawans:Array,
        timDetails:Array
    },

    data() {
        return {
            creatingTimDetail: false,
            banyakAnggota:[],
            temp_section_id:0,

            record: this.$inertia.form({
                tim_id: '',
                nip: '',
                posisi: '',
            })
        }
    },

    created() {
        this.fetchTims();
    },

    methods: {
        setTimId(index, tim_id){
            this.record[index].tim_id = tim_id
        },
        createTimDetail() {
            this.fetchKaryawans();
            this.fetchTims();
            this.creatingTimDetail = true;

            setTimeout(() => this.$refs.posisi.focus(), 250)
        },

        fetchTims() {
            Inertia.reload({ only: ['tims'] }, this.record)
        },

        fetchKaryawans() {
            Inertia.reload({ only: ['karyawans'] })
        },
        getAnggota(){
            Inertia.reload({ only: ['timDetails'] + this.temp_section_id}).then(Request => {
                this.record = [];
                var data = Request.data;
                for (let index = 0; index <= this.timDetails.length; index++){
                    this.addRow();
                    if(data[index].tim_detail != null){
                        this.record[index].nip = data[index].tim_detail.nip;
                        this.record[index].posisi = data[index].tim_detail.posisi;
                    }
                }
                this.banyakAnggota = Request.data;
            })
            
        },

        create() {
            this.record.post(route('timDetail.store'), this.banyakAnggota, {
                preserveScroll: true,
                preserveState: true,
                onSuccess: () => {
                    this.closeModal();
                    this.record.reset();
                },
            })
        },

        closeModal() {
            this.creatingTimDetail = false
            this.record.clearErrors()
            this.record.reset()
        },
        addRow(){
            this.record.push({
                tim_id:"",
                nip:null,
                posisi:null
                
            })
        }        
    },
}
</script>
