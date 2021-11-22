<template>
    <div>
        <jet-button @click="createPenilaian">
            Tambah Penilaian
        </jet-button>

        <!-- Delete Account Confirmation Modal -->
        <jet-dialog-modal :show="creatingPenilaian" @close="closeModal">
            <template #title>
                Create Penilaian
            </template>
        
            <template #content>
                <div class="space-x-4 sm:-my-px sm:ml-1 sm:flex">
                    <jet-input type="date" class="mt-1 block w-3/4" placeholder="Tanggal Penilaian"
                                ref="tgl"
                                v-model="form.tgl"
                                @keyup.enter="create" />

                    <jet-input-error :message="form.errors.tgl" class="mt-2" />

                    <select class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-3/4"
                        required v-model="form.pernum" v-on:change="getPenilaianTim(form.pernum)">
                        <option value="" disabled selected>Pilih Penilai</option>
                        <option v-for="karyawan in tims" :key="karyawan.karyawan.pernum" :value="karyawan.karyawan.pernum">{{karyawan.karyawan.pernum}} - {{karyawan.karyawan.nama}}</option>
                    </select>
                
                    <jet-input-error :message="form.errors.pernum" class="mt-2" />     


                    <select class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-3/4"
                        v-model="form.tim_unit_id">
                        <option value="" disabled selected>Pilih Tim 5P/Unit</option>
                        <option v-for="tim in form1.timList" :key="tim.tim_unit_id" :value="tim.tim_unit_id">{{tim.tim_unit.nama}}</option>
                    </select>
                    <jet-input-error :message="form.errors.tim_unit_id" class="mt-2" />  

                </div> 
            
                
            </template>

            <template #footer>
                <jet-secondary-button @click="closeModal">
                    Cancel
                </jet-secondary-button>

                <jet-button class="ml-2" @click="create" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
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
import CreatePenilaianDetail from './CreatePenilaianDetail.vue'

export default {
    components: {
        JetButton,
        JetDialogModal,
        JetInput,
        JetInputError,
        JetSecondaryButton,
        CreatePenilaianDetail,
    },

    data() {
        return {
            creatingPenilaian: false,
            openNilai:false,
            
            
            form: this.$inertia.form({
                tgl: new Date(),
                pernum: '',
                tim_unit_id: '',
            }), 
            form1: this.$inertia.form({
                timList: [],
            }),             
                      
        }
    },
    props:{
        tims:Array,
        penilaians:Array,
        penilaianTims:Array,
    },

    methods: {
        createPenilaian() {
            this.creatingPenilaian = true;

        },
        getPenilaianTim(pernum){
            this.form1.reset();
            var k=0;
            for(var index=0;index<=this.penilaianTims.length-1;index++){
                for(var j=0;j<=this.tims.length-1;j++){
                    if (pernum == this.tims[j].karyawan.pernum && this.penilaianTims[index].tim_id == this.tims[j].tim_id) {
                        this.form1.timList[k] = this.penilaianTims[index];
                        k++;
                    }
                }
            }
        },

        create() {
            this.form.post(route('penilaian.store'), {
                preserveScroll: true,
                preserveState: true,
                onSuccess: () => {
                    this.form.closeModal();
                    this.form.reset();
                },
            })
        },

        closeModal() {
            this.creatingPenilaian = false
            this.form.clearErrors()
            this.form.reset()

        }, 
    }
}
</script>
