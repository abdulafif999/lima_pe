<template>
    <div>
        <!-- This example requires Tailwind CSS v2.0+ -->
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200" :v-on:show="getTimPenilai()">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama Tim
                                    </th>                                    
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama Penilai
                                    </th>                                   
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tim 5P/Unit yg Dinilai
                                    </th>                                    
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tanggal Penilaian
                                    </th>                                             
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Detail Nilai</span>
                                    </th>                                    
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="penilaian in penilaians" :key="penilaian.id">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ penilaian.nama_tim }}
                                        </div>
                                    </td>                                    
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ penilaian.karyawan.nama }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ penilaian.tim_unit.nama }}
                                        </div>
                                    </td>                                                                        
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ penilaian.tgl }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <jet-secondary-button href="#" @click.prevent="openNilai(penilaian)" class="text-indigo-600 hover:text-indigo-900">Show Nilai</jet-secondary-button>                                        
                                    </td>                                    
                                </tr>

                                <!-- More people... -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>  

        <jet-dialog-modal :show="detailNilai" @close="closeModal">
            <template #title>
                Nilai 5P dari {{this.selectedPenilaian.tim_unit.nama}}
            </template>

            <template #content>
                <div class="mt-4">
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
                                    Status
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Rekomendasi
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Foto
                                </th>                                                                
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="penilaian in form.listNilai" :key="penilaian.id">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        {{ penilaian.kriteria.nama }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        {{ penilaian.kriteria.sub_kriteria }}
                                    </div>
                                </td>                                                                        
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        {{penilaian.nilai}}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        {{ penilaian.status }}
                                    </div>
                                </td>                                             
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        {{ penilaian.rekomendasi }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        {{ penilaian.foto }}
                                    </div>
                                </td>                                                                
                            </tr>
                            <tr>
                                <td colspan="5" class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        Nilai Akhir :
                                    </div>
                                </td>
                                <td >
                                    <div class="flex items-center">
                                        {{this.nilaiTotal}}
                                    </div>
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
        JetCheckbox,
    },

    props: {
        penilaians:Array,
        penilaianDetails:Array,
        kriterias:Array,
        tims:Array,
    },

    data() {
        return {
            detailNilai: false,
            selectedPenilaian:{},
            nilaiTotal:0,

            form: this.$inertia.form({
                listNilai: [],
            })            
        }
    },

    methods: {
        openNilai(penilaian){
            this.detailNilai = true;
            this.selectedPenilaian = penilaian;
            var j=0;
            var nilaiTotal=0;
            for(var index=0;index<=this.penilaianDetails.length-1;index++){
                if(this.penilaianDetails[index].penilaian_id == penilaian.id){
                    this.form.listNilai[j] = this.penilaianDetails[index];
                    nilaiTotal = nilaiTotal + this.form.listNilai[j].nilai;
                    j++;
                    
                }
            }
            this.nilaiTotal = parseFloat((nilaiTotal).toFixed(2));
        },

        getTimPenilai(){
            for(var index=0;index<=this.penilaians.length-1;index++){
                for(var j=0;j<=this.tims.length-1;j++){
                    if(this.penilaians[index].pernum == this.tims[j].karyawan.pernum){
                        this.penilaians[index].nama_tim = this.tims[j].tim.nama;
                    }
                }
            }
        },
      

        closeModal() {
            this.detailNilai = false;
            this.form.reset();
            this.nilaiTotal = 0;
        },
    },
}
</script>
